<?php
  function canmakequest($q) {
    global $questtime;
    $r=mq("select q$q as q from qtimes where user='$_SESSION[uid]'");
    if (mysql_num_rows($r)==0) {
      mq("insert into qtimes (user) values ('$_SESSION[uid]')");
      return true;
    }
    $rec=mysql_fetch_assoc($r);
    $questtime=$rec["q"]-time();
    return $rec["q"]<time();
  }
  function makequest($q, $mult=1, $user=0) {
    if (!$user) $user=$_SESSION["uid"];
    if ($q==1 || $q==3 || $q==13 || $q==14) $tme=86400*$mult;
    elseif ($q==2 || $q==5 || $q==6 || $q==16) $tme=3600*$mult;
    elseif ($q==4) $tme=1800*$mult;
    elseif ($q==8 || $q==12 || $q==18) $tme=1800*$mult;
    elseif ($q==9 || $q==10 || $q==22) $tme=3600*$mult;
    mq("update qtimes set q$q='".(time()+$tme)."' where user='$user' ");
  }
  function takeitem($item, $present=1, $podzem=0, $user=0) {
    if (!$user) $user=$_SESSION["uid"];
    $r=mq("show fields from items");
    $rec1=mqfa("select * from items where id='$item'");
    $rec1["podzem"]=$podzem;
    $sql="";
    while ($rec=mysql_fetch_assoc($r)) {
      if ($present) {
        if ($rec["Field"]=="maxdur") $rec1[$rec["Field"]]=1;
        if ($rec["Field"]=="cost") $rec1[$rec["Field"]]=2;
      }
      if ($rec["Field"]=="id") continue;
      if ($rec["Field"]=="goden") $goden=$rec1[$rec["Field"]];
      $sql.=", `$rec[Field]`='".$rec1[$rec["Field"]]."' ";
    }
    mq("insert into inventory set owner='$user' ".($goden?", dategoden='".($goden*60*60*24+time())."'":"")." $sql");
    return array("img"=>$rec1["img"], "name"=>$rec1["name"]);
  }

  function takeitemfromshop($item, $tbl="shop", $u=0, $extra=array()) {
    $r=mq("show fields from $tbl");
    $rec1=mqfa("select * from $tbl where id='$item'");
    $sql="";
    while ($rec=mysql_fetch_assoc($r)) {                                                                                                                                                                                                                                                                  
      if ($rec["Field"]=="id" || $rec["Field"]=="shshop" || $rec["Field"]=="count" || $rec["Field"]=="zeton" || $rec["Field"]=="destiny" || $rec["Field"]=="zoo" || $rec["Field"]=="honorcount" || $rec["Field"]=="resname" || $rec["Field"]=="rescnt" || $rec["Field"]=="shop" || $rec["Field"]=="buyformoney" || $rec["Field"]=="dategoden" || $rec["Field"]=="koll") continue;
      if ($rec["Field"]=="goden") $goden=$rec1[$rec["Field"]];
      if (isset($extra[$rec["Field"]])) {
        $sql.=", `$rec[Field]`='".$extra[$rec["Field"]]."' ";
        unset($extra[$rec["Field"]]);
      } elseif ($rec["Field"]=="razdel") {
        $sql.=", `otdel`='".$rec1[$rec["Field"]]."' ";
      } else $sql.=", `$rec[Field]`='".$rec1[$rec["Field"]]."' ";
    }
    foreach ($extra as $k=>$v) $sql.=", $k='$v'";
    mq("insert into inventory set prototype='$item', owner='".($u?"$u":"$_SESSION[uid]")."' ".($goden?", dategoden='".($goden*60*60*24+time())."'":"")." $sql");
    return array("img"=>$rec1["img"], "name"=>$rec1["name"], "id"=>mysql_insert_id());
  }

  function takesmallitem($item, $user=0, $reason="", $qty=1, $bs=0, $goden=0) {
    if (!$user) $user=$_SESSION["uid"];
    $rec=mqfa("select * from smallitems where id='$item'");
    $f = mysql_query("SELECT `koll`, id FROM `inventory` WHERE `owner`='$user' and `type`='$rec[type]' and `name`='$rec[name]' and setsale=0 and (dategoden=0 or dategoden>".time().")");

    if ($goden>0) {
      $goden=", dategoden='".($goden*60*60*24+time())."', goden=$goden";
    } elseif ($goden<0) {
      $goden=", dategoden='".(abs($goden)*60*60+time())."', goden=$goden";
    } else $goden="";

    if($g = mysql_fetch_array($f)){
      $koll = $g["koll"];
      mq("UPDATE `inventory` SET koll=koll+$qty, massa=massa+($rec[massa]*$qty) WHERE id='$g[id]'");
    } else {
      mq("INSERT INTO `inventory` set name='$rec[name]', koll='$qty', img='$rec[img]', owner='$user', type='$rec[type]', massa='$rec[massa]', 
      isrep='$rec[isrep]', podzem='$rec[podzem]', maxdur='$rec[maxdur]', bs='$bs' $goden");
    }
    mq("insert into droplog set user=$user, item='$rec[name]', reason='$reason', dat=now()");
    return array("img"=>$rec["img"], "name"=>$rec["name"].($qty>1?" (x$qty)":""));
  }

  function battlewithbot($b, $name="", $comment="", $time=3, $quest=0, $closed=1, $blood=1, $group=1, $battleid=0, $otherbots=array(), $noredir=0, $userid=0, $type=1) {
    global $user;
    if (!$userid) $user1=$user;
    elseif (is_array($userid)) $user1=$userid;
    else $user1=mqfa("select * from users where id='$userid'");
    $bot=mqfa("select login, maxhp from users where id='$b'");
    if (!$name) $name=$bot["login"];
    if ($battleid) {
      $botid=mqfa1("select id from bots where prototype='$b' and battle='$battleid'");
    } elseif ($group) {
      $arha = mqfa("SELECT * FROM `bots` WHERE `prototype` ='$b' order by id desc");
      $battleid = $arha['battle'];
      $botid = $arha['id'];
    }
    if(@$battleid > 0) {
        //вмешиваемся
        $bd = mqfa ("SELECT * FROM `battle` WHERE id='$battleid'");
        $battle = unserialize($bd['teams']);
        $ak = array_keys($battle[$botid]);
        $battle[$user1['id']] = $battle[$ak[0]];
        foreach($battle[$user1['id']] as $k => $v) {
            $battle[$user1['id']][$k] =array(0,0,time());
            $battle[$k][$user1['id']] = array(0,0,time());
        }
        $t1 = explode(";",$bd['t1']);
        // проставляем кто-где
        if (in_array ($botid,$t1)) {
            $ttt = 2;
        } else {
            $ttt = 1;
        }
        addch ("<b>".nick7($user1['id'])."</b> вмешался в <a href=logs.php?log=".$id." target=_blank>поединок >></a>.  ",$user1['room']);

        //mysql_query('UPDATE `logs` SET `log` = CONCAT(`log`,\'<span class=date>'.date("H:i").'</span> '.nick5($user1['id'],"B".$ttt).' вмешался в поединок!<BR>\') WHERE `id` = '.$battle.'');
        //if ($user1['id']=='111' OR $user1['id']=='4717') {
        //addlog($jert['battle'],'<span class=date>'.date("H:i").'</span> Внезапно небо потемнело, засверкали молнии, в их сполохах стали видны приближающиеся тени с горяими глазами. Бойцы, забыв про свои обиды, в страхе прижались друг к другу...<BR>');
        //}
        if ($user1['invis']==1) {
        addlog($battleid,'<span class=date>'.date("H:i").'</span> <b>невидимка</b> вмешался в поединок!<BR>');
        }else
        addlog($battleid,'<span class=date>'.date("H:i").'</span> '.nick5($user1['id'],"B".$ttt).' вмешался в поединок!<BR>');

        mysql_query('UPDATE `battle` SET `teams` = \''.serialize($battle).'\', `t'.$ttt.'`=CONCAT(`t'.$ttt.'`,\';'.$user1['id'].'\')  WHERE `id` = '.$battleid.' ;');
        mysql_query("UPDATE users SET `battle` =".$battleid.",`zayavka`=0 WHERE `id`= ".$user1['id']);

        if (!$noredir) header("Location:fbattle.php");
        //die("<script>location.href='fbattle.php';</script>");
    } else {
        // начинаем бой
        include "config/questbots.php";
        if (@$questbots[$b]) $bot['maxhp']=questbothp();
        mq("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('$name','$b','','".$bot['maxhp']."');");
        $botnames=array();
        $botnames[$name]=1;
        $hps[$b]=$bot["maxhp"];
        $botid1 = mysql_insert_id();
        $cond=" id='$botid1' ";

        $teams = array();
        $teams[$user1['id']][$botid1] = array(0,0,time());
        $teams[$botid1][$user1['id']] = array(0,0,time());
        $t2="$botid1";

        $others="";
        $hps=array();
        
        foreach ($otherbots as $k=>$v) {
          if (@$botnames[$v["name"]]) {
            $i=1;
            while (@$botnames["$v[name] ($i)"]) $i++;
            $botname="$v[name] ($i)";
          } else $botname=$v["name"];
          $botnames[$botname]=1;
          if (!@$hps[$v["id"]]) {
            if (@$questbots[$v["id"]]) $hps[$v["id"]]=questbothp();
            else $hps[$v["id"]]=mqfa1("select maxhp from users where id='$v[id]'");
          }
          mq("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('$botname','$v[id]','','".$hps[$v["id"]]."')");
          $botid = mysql_insert_id();
          $cond.=" or id='$botid' ";
          $teams[$user1['id']][$botid] = array(0,0,time());
          $teams[$botid][$user1['id']] = array(0,0,time());
          $others.="<span class=date>".date("H:i")."</span> <span class=B2>$botname</span> вмешался в поединок.<BR>";
          $t2.=";$botid";
        }
        $sv = array(3,4,5);
        //$tou = array_rand($sv,1);
        mysql_query("INSERT INTO `battle`
            (
                `id`,`coment`,`teams`,`timeout`,`type`,`status`,`t1`,`t2`,`to1`,`to2`,`blood`, quest, closed, date
            )
            VALUES
            (
                NULL,'','".serialize($teams)."','".$time."','$type','0','".$user1['id']."','".$t2."','".time()."','".time()."','$blood', '$quest', '$closed', '".date("Y-m-d H:i")."'
            )");

        $battleid = mysql_insert_id();

        // апдейтим врага
        mq("UPDATE `bots` SET `battle` = {$battleid} WHERE $cond");
        mq("UPDATE `users` SET `battle` = {$battleid} WHERE `id` = {$user1[id]} LIMIT 1;");
        // создаем лог

        if ($user1['invis']==1) {
        $rr = "<b>невидимка</b> и <b>".nick3($botid1)."</b>";
        } else $rr = "<b>".nick3($user1['id'])."</b> и <b>".nick3($botid1)."</b>";
        addch ("<a href=logs.php?log=".$battleid." target=_blank>Бой</a> между <B><b>".nick7($user1['id'])."</b> и <b>".nick7($botid1)."</b> начался.   ",$user1['room']);

        //mysql_query("INSERT INTO `logs` (`id`,`log`) VALUES('{$id}','Часы показывали <span class=date>".date("Y.m.d H.i")."</span>, когда ".$rr." бросили вызов друг другу. <BR>');");
        //if ($user1['id']=='111' OR $user1['id']=='4717') {
        //addlog($id,"<span class=date>".date("Y.m.d H.i")."</span> Внезапно небо потемнело, засверкали молнии, в их сполохах стали видны приближающиеся тени с горяими глазами. Бойцы, забыв про свои обиды, в страхе прижались друг к другу...<BR>");
        //}

        addlog($battleid,"Часы показывали <span class=date>".date("Y.m.d H.i")."</span>, когда ".$rr." бросили вызов друг другу. <BR>".($others?"$others<BR>":""));
        if (!$noredir) header("Location:fbattle.php");
        //die("<script>location.href='fbattle.php';</script>");
    }
    return $battleid;
    if (!$noredir) die("<script>location.href='fbattle.php';</script>");
  }
?>
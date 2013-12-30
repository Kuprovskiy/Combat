<?php

  define("CONTEST", 0);
  session_start();
  if ($_SESSION['uid'] == null) header("Location: index.php");
  include "connect.php";
  include "functions.php";
  if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }

  include "config/fielddata.php";

  if (isset($_POST["stake"]) &&  @$fielddata[$user["room"]]["stake"]) {
    $started=0;
    if (@$fielddata[$user["room"]]["onebattlee"]) $started=mqfa1("select id from fields where room=".($user["room"]+1));
    if (!$started) {
      $stake=(int)@$_POST["stake"];
      if ($stake<5) $error="Ставка указана неверно. Минимальная ставка 5 кр.";
      if ($stake>$user["money"]) $error="У вас недостаточно денег.";
      if (!@$error) {
        $total=getvar("fieldwin$user[room]");
        $total+=$stake*$fielddata[$user["room"]]["winpart"];
        setvar("fieldwin$user[room]", $total);
        $i=mqfa1("select id from fieldmembers where room='$user[room]' and user='$user[id]'");
        mq("update users set money=money-$stake where id='$user[id]'");
        if ($i) mq("update fieldmembers set stake=stake+$stake where id='$i'");
        else mq("insert into fieldmembers set room='$user[room]', stake='$stake', user='$user[id]', valid=1, started=".time());
      }
    }
  }

if(in_array($user["room"], $canalrooms)) {print "<script>location.href='canalizaciya.php'</script>";}

if(in_array($user["room"], $battleenters)){

  $podzemroom=$user["room"]+1;
  include "config/podzemdata.php";  
  function remfieldmember($user1, $rec=0, $del=1) {
    global $user;
    if (!$rec) $rec=mqfa("select id, started from fieldmembers where user='$user1' and room='$user[room]'");
    if (!$rec["started"]) return;
    $diff=time()-$rec["started"];
    mq("update effects set time=time+$diff where owner='$user1' and type<>31");
    if ($del) mq("delete from fieldmembers where id='$rec[id]'");
  }                

  function setstamp($user, $room) {
    global $userslots;
    mq("update inventory set dressed=0 where owner='$user'");
    $rec1=mqfa("select * from deztow_charstams where owner='$user' and room='".($room==31?"0":"$room")."' order by def desc");
    if (!$rec1) {
      if ($room==31) $rec1=array("sila"=>25, "lovk"=>25, "inta"=>25, "vinos"=>25, "intel"=>0, "mudra"=>0);
      else $rec1=array("sila"=>35, "lovk"=>35, "inta"=>35, "vinos"=>35, "intel"=>0, "mudra"=>0);
    }
    if ($room==31) $level=8; else $level=9;
    $hp=30;
    $mana=$rec1["mudra"]*10;
    if ($rec1["mudra"]>=100) $mana+=250;
    elseif ($rec1["mudra"]>=75) $mana+=175;
    elseif ($rec1["mudra"]>=50) $mana+=100;
    elseif ($rec1["mudra"]>=25) $mana+=50;

    $rec=getdressstats($rec1);
    $hp+=$rec["hp"];
    $mana+=$rec["mana"];
    adddressstats($rec1, $rec);

    $sql="";
    foreach ($userslots as $k=>$v) {
      $sql.=", $v='$rec1[$v]'";
    }
    
    $hfv=6;
    $r=mq("select sila, lovk, inta, vinos, hpforvinos, intel, mudra, type, ghp from effects where owner='$user'");
    while ($rec=mysql_fetch_assoc($r)) {
      if ($rec["type"]==11 || $rec["type"]==12 || $rec["type"]==13 || $rec["type"]==14) {
        $rec1["sila"]-=$rec["sila"];
        $rec1["lovk"]-=$rec["lovk"];
        $rec1["inta"]-=$rec["inta"];
        $rec1["vinos"]-=$rec["vinos"];
        $rec1["intel"]-=$rec["intel"];
        $rec1["mudra"]-=$rec["mudra"];
      } else {
        $rec1["sila"]+=$rec["sila"];
        $rec1["lovk"]+=$rec["lovk"];
        $rec1["inta"]+=$rec["inta"];
        $rec1["vinos"]+=$rec["vinos"];
        $rec1["intel"]+=$rec["intel"];
        $rec1["mudra"]+=$rec["mudra"];
      }
      $hp+=$rec["ghp"];
      $hfv+=$rec["hpforvinos"];
    }
    $hp+=$rec1["vinos"]*$hfv;
    if ($rec1["vinos"]>=100) $hp+=250;
    elseif ($rec1["vinos"]>=75) $hp+=175;
    elseif ($rec1["vinos"]>=50) $hp+=100;
    elseif ($rec1["vinos"]>=25) $hp+=50;
    mq("update users set align=0, in_tower='".($room==31?"1":"$room")."', level='$level', stats=0, sila='$rec1[sila]', lovk='$rec1[lovk]', inta='$rec1[inta]', vinos='$rec1[vinos]', intel='$rec1[intel]', mudra='$rec1[mudra]', spirit='$rec1[spirit]',
    noj='$rec1[noj]', mec='$rec1[mec]', topor='$rec1[topor]', dubina='$rec1[dubina]', posoh='$rec1[posoh]', master=0,
    mfire='$rec1[mfire]', mwater='$rec1[mwater]', mair='$rec1[mair]', mearth='$rec1[mearth]',
    mlight='$rec1[mlight]', mgray='$rec1[mgray]', mdark='$rec1[mdark]', hp='$hp', maxhp='$hp', 
    mana='$mana', maxmana='$mana' $sql where id='$user'");
    resetsets($user,1);
  }
?>

<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
</HEAD>
<BODY style="BACKGROUND-IMAGE: url(<?=IMGBASE?>/i/misc/showitems/dungeon.jpg); BACKGROUND-REPEAT: no-repeat; BACKGROUND-POSITION: right top" bgColor=#e2e0e0>
<?
  if(@$_GET["warning"]) echo "<b><font color=red>$_GET[warning]</font></b>";
?>
<div id=hint4 class=ahint></div>

<TABLE width=100%>
<TR><TD valign=top width=100%><center><h3><?=$rooms[$user["room"]]?></h3></center>
<?
  function isonlinelogin($l) {
    $i=mqfa1("select distinct(users.id) from `online` left join users on users.id=online.id WHERE `date` >= ".(time()-60)." and users.login='$l'");
    return $i;
  }
  $noapply=0;
  if ($user["room"]==71) {
    $rec1=mqfa("select id from fields where room=72");
    if ($rec1) {
      echo "Турнир начался. Количество живых участников: ";
      $r=mq("select id, align, klan, login, level, battle from users where in_tower=71");
      $cnt=mysql_num_rows($r);
      echo $cnt;
      if ($cnt==0) {
        mq("delete from fields where id='$rec1[id]'");
        mq("update variables set value=".(60*60+time())." where var='startbs2'");
        echo "<script>document.location.replace('battleenter.php');</script>";
      } elseif ($cnt==1) {
        $rec=mysql_fetch_assoc($r);
        if (!$rec["battle"]) {
          $win=getvar("fieldwin$user[room]");
          mq("delete from fields where id='$rec1[id]'");
          setvar("fieldwin$user[room]", 0);
          $nextBattle = 60*60+time();
          mq("update variables set value=".$nextBattle." where var='startbs2'");
          sysmsg("Битва в Подгорной Башне смерти окончена, победитель - <b>" . $rec["login"] . "</b>. Следующая битва в " . date('H:i', $nextBattle));
          privatemsg("Вы победили в турнире Башни смерти. Приз: $win кр.", $rec["login"]);
          outoffield($rec["id"]);
          mq("update fieldlogs set log=concat(log, '".logdate()." Турнир закончен. Победитель: ".fullnick($rec).".<br>'), winner='$rec[id]', passed=".time()."-started, prize='$win' where id='$rec1[id]'");
          givemoney($rec["id"], $win, "за победу в Подгорной Башне смерти.");
          mq("delete from fieldparties where field='$rec1[id]'");
          header("location: battleenter.php");
        }
      }
      $i=0;
      while ($rec=mysql_fetch_assoc($r)) {
        $i++;
        if ($i>1) echo ", ";
        echo "<nobr>".fullnick($rec)."</nobr> ";
      }
      $noapply=1;
      echo mqfa1("select log from fieldlogs where id='$rec1[id]'");
    } else {
      echo "Начало турнира: ".date("d.m.Y H:i",mqfa1("select value from variables where var='startbs2'"));
      if ($fielddata[$user["room"]]["stake"]) echo "<br>Призовой фонд: ".getvar("fieldwin$user[room]")." кр.";
      echo "<br><br>";               
    }
  }

  $inteam=0;
  if (!@$fielddata[$user["room"]]["stake"]) $inteam=mqfa1("select id from fieldmembers where user='$user[id]' and room='$user[room]'");
  if (@$_GET["joinfree"] && !$inteam && !@$fielddata[$user["room"]]["stake"]) {
    mq("insert into fieldmembers set room='$user[room]', user='$user[id]', valid=1, started=".time());
    $inteam=1;
  }
  if (($inteam && $_GET["leave"]) || @$_POST["leave"]) {
    $gi=mqfa1("select groupid from fieldmembers where user='$user[id]'");
    if ($gi) {
      $r=mq("select users.login from fieldmembers left join users on users.id=fieldmembers.user where fieldmembers.groupid='$gi' and fieldmembers.user<>'$user[id]'");
      while ($rec=mysql_fetch_assoc($r)) {
        privatemsg("Ваша группа для пещеры кристаллов отменяется, т. к. персонаж $user[login] отказался от участия.", $rec["login"]);
      }
      $r=mq("select user from fieldmembers where groupid='$gi'");
      while ($rec=mysql_fetch_assoc($r)) {
        remfieldmember($rec["user"]);
      }
      //mq("delete from fieldmembers where groupid='$gi'");
    } else {
      remfieldmember($user["id"]);
      //mq("delete from fieldmembers where user='$user[id]'");
    }
    $inteam=0;
  }
  if ($_POST["todo"]=="creategroup" && !$inteam) {
    $i=0;
    $group=array($user["id"]=>1);
    while ($i<$fielddata[$user["room"]]["team"]-1) {
      $i++;
      $ur=mqfa("select id, room from users where login='".$_POST["user$i"]."'");
      if ($ur["id"]==$user["id"] || !isonlinelogin($_POST["user$i"]) || $ur["room"]!=$user["room"] || @$group[$ur["id"]]) {
        $_POST["user$i"]="";
        $bad=1;
      } else {
        $mi=mqfa1("select id from fieldmembers where user='$ur[id]'");
        if ($mi) {
          $_POST["user$i"]="";
          $bad=1;
        } else $group[$ur["id"]]=1;
      }
    }
    $enemy=0;
    if (CONTEST && @$_POST["enemy"]) {
      $enemy=mqfa1("select id from users where login='".mysql_real_escape_string($_POST["enemy"])."'");
      if (!$enemy) $bad=1;
      $_POST["enemy"]="";
    }
    if ($bad) {
      echo "<b><font color=red>У участника группы неверно указан ник, персонаж не онлайн, в другой комнате или уже в заявке.</font></b>";
    } else {
      mq("insert into fieldgroups set room='$user[room]', enemy='$enemy'");
      $group=mysql_insert_id();
      mq("insert into fieldmembers set room='$user[room]', groupid='$group', user='$user[id]', valid=1, started=".time());
      $i=0;
      while ($i<$fielddata[$user["room"]]["team"]-1) {
        $i++;
        $ui=mqfa1("select id from users where login='".$_POST["user$i"]."'");
        mq("insert into fieldmembers set room='$user[room]', groupid='$group', user='$ui', valid=0, started=".time());
      }
      $inteam=1;
    }
  }
  if ($user["level"]>=$fielddata[$user["room"]]["minlevel"]) {
    if($inteam) {
      if ($_GET["verify"]) mq("update fieldmembers set valid=1 where user='$user[id]'");
      if ($fielddata[$user["room"]]["team"]) echo "<fieldset style=\"padding-left:5px;width=50%\">
      <legend><b> Группа </b></legend>";
      $groupid=mqfa1("select groupid from fieldmembers where user='$user[id]'");
      if ($groupid) {
        echo "<br><table>";
        $r=mq("select users.login, fieldmembers.valid from fieldmembers left join users on users.id=fieldmembers.user where fieldmembers.groupid='$groupid'");
        $needverify=0;
        while ($rec=mysql_fetch_assoc($r)) {
          if (!$rec["valid"] && $rec["login"]==$user["login"]) $needverify=1;
          echo "<tr><td><b>$rec[login]</b></td><td>".($rec["valid"]?"<font color=green>подтвердил участие</font>":"<font color=red>ожидание подтверждения</font>")."</td></tr>";
        }
        echo "</table><br>";
      }
      if ($needverify) echo "Для участия в битве, вам необходимо подтвердить своё участие.<br><br>
      <input style=\"font-size:12px;\" type=\"button\" onclick=\"document.location.href='battleenter.php?verify=1';\" value=\"Подтвердить участие\">&nbsp;&nbsp;&nbsp;";
      echo "<input style=\"font-size:12px;\" type=\"button\" onclick=\"document.location.href='battleenter.php?leave=1';\" value=\"".($fielddata[$user["room"]]["team"]?"Покинуть группу":"Отказаться от участия")."\">";
      if ($fielddata[$user["room"]]["team"]) "</fieldset>";
    } elseif (!$noapply) {
      print "<table cellpadding=1 cellspacing=0>";
?>

<TR><TD>


</TD></TR>
<TR height=1><TD height=1 bgcolor=#A0A0A0 colspan=2><SPAN></SPAN></TD></TR>
</TABLE>

<?

if (!@$fielddata[$user["room"]]["nogroups"]) {
  echo "<form action=\"battleenter.php\" method=\"post\"><input type=\"hidden\" name=\"todo\" value=\"creategroup\">
  <fieldset style='padding-left: 5; width=50%; color:#000000;'>
  <legend><b> Группа </b></legend>
  <table>";
  $i=0;
  while ($i<$fielddata[$user["room"]]["team"]-1) {
    $i++;
    echo "<tr><td>";
    if ($i==1) echo "Первый";if ($i==2) echo "Второй";if ($i==3) echo "Третий";
    echo " участник:</td><td><input value=\"".@$_POST["user$i"]."\" type=\"text\" name=\"user$i\" size=16></td></tr>";
  }
  if (CONTEST) echo "<tr><td>Противник (любой):</td><td><input value=\"".@$_POST["enemy"]."\" type=\"text\" name=\"enemy\" size=16></td></tr>";
  echo "</table>
  <input style='font-size:12px;' TYPE=submit name=open value='Создать группу'>&nbsp;<BR>
  </fieldset>
  </form>";
}


if ($fielddata[$user["room"]]["stake"]) {
  $stake=mqfa1("select stake from fieldmembers where room='$user[room]' and user='$user[id]'");
    //if ($user['id'] == 7) {
        if (isset($error)) {
            echo '<p style="color: red">' . $error . '</p>';
        }    
    //}
  echo "<form action=\"battleenter.php\" method=\"post\">
  <input type=\"hidden\" name=\"leave\" value=\"0\">";
  if ($stake) echo "Ваша текущая ставка: $stake кр.<br><br>";
  echo ($stake?"Добавить к ставке":"Ваша ставка").": <input type=\"text\" size=2 name=\"stake\"> кр.
  <input type=\"submit\" value=\"".($stake?"Повысить ставку":"Принять участие в бою")."\">
  ".($stake?"<input type=\"button\" value=\"Отказаться от участия\" onclick=\"if (confirm('Вы уверены? Сделання ставка возврщена не будет.')) {this.form.leave.value=1;this.form.submit();}\">":"")."
  <div>&nbsp;</div></form>";
}
else echo "<input onclick=\"document.location.href='battleenter.php?joinfree=1';\" style='font-size:12px;width:210px' type=button value=\"".($fielddata[$user["room"]]["team"]?"Присоединиться к свободной группе":"Принять участие в бою")."\"><div>&nbsp;</div>";

if (!@$fielddata[$user["room"]]["nostamp"]) echo "<input type=\"button\" value=\"Профили характеристик\" onClick=\"document.location.href='towerstamp.php'\">";

if ($user["room"]==56) {
  echo "<br><br><b>Последние 10 поединков:</b><br><br>";
  $r=mq("select * from fieldlogs where room=".($user["room"]+1)." and (pts1=10 or pts2=10) order by id desc limit 0, 10");
  while ($rec=mysql_fetch_assoc($r)) {
    echo "<b>$rec[team1]</b> ".($rec["pts1"]==10?"<img src=\"".IMGBASE."/i/flag.gif\">":"")." против <b>$rec[team2]</b> ".($rec["pts2"]==10?"<img src=\"".IMGBASE."/i/flag.gif\">":"")." <a href=\"fieldlog.php?log=$rec[id]\" target=\"_blank\">»»</a><br>";
  }
}


    }

    if ($user["room"]==71) {
      echo "<H4>Наибольшее количество побед</H4><table>";
      $r=mq("select winner, count(id) as cid from fieldlogs where room='72' and winner>0 group by winner order by cid desc limit 0, 10");
      while ($rec=mysql_fetch_assoc($r)) {
        echo "<tr><td width=\"30\"><b>$rec[cid]</b></td><td>".fullnick($rec["winner"])."</td></tr>";
      }                                                                 //".($user["klan"]?"<img title=\"$user[klan]\" src=\"i/klan/$user[klan].gif">":"")."
      echo "</table>";

      function fieldrow($rec) {
        return ($rec["winner"]?"Победитель: ".fullnick($rec["winner"]).". ":"")."Начало турнира <FONT class=date>$rec[team1]</font> ".($rec["passed"]?"продолжительность <FONT class=date>".secs2hrs($rec["passed"])."</FONT> ":"").($rec["prize"]?"приз: <B>$rec[prize] кр.</B> ":"")."<a href=\"fieldlog.php?log=$rec[id]\" target=\"_blank\">история турнира &raquo;&raquo;</a><br>";
      }

      echo "<P><H4>Самый продолжительный турнир</H4>";

      $rec=mqfa("select * from fieldlogs where room=".($user["room"]+1)." order by passed desc");
      echo fieldrow($rec);

      echo "<P><H4>Максимальный выигрыш</H4>";

      $rec=mqfa("select * from fieldlogs where room=".($user["room"]+1)." order by prize desc");
      echo fieldrow($rec);


      echo "<br><br><b>Последние 10 турниров:</b><br><br>";
      $r=mq("select * from fieldlogs where room=".($user["room"]+1)." order by id desc limit 0, 10");
      while ($rec=mysql_fetch_assoc($r)) {
        echo fieldrow($rec);
      }
    }

  } else echo "<center><b>Вход только с ".$fielddata[$user["room"]]["minlevel"]."-го уровня.</b></center>";

if (!@$fielddata[$user["room"]]["cronstart"]) {
  $r=mq("select user, groupid from fieldmembers where valid=1 and room='$user[room]' order by id desc");
  $groups=array();
  while ($rec=mysql_fetch_assoc($r)) {
    @$groups[$rec["groupid"]][]=$rec["user"];
  }
  $cnt=0;
  foreach ($groups as $k=>$v) {
    if ($k==0) $cnt+=floor(count($v)/$fielddata[$user["room"]]["team"]);
    elseif (count($v)>=$fielddata[$user["room"]]["team"]) $cnt++;
  }
  foreach ($groups as $k=>$v) {
    $e=mqfa1("select enemy from fieldgroups where id='$k'");
    if ($e) {
      foreach ($groups as $k2=>$v2) {
        foreach ($v2 as $k3=>$v3) {
          if ($v3==$e && $k2!=$k) {
            $newgroups=array();
            $newgroups[$k]=$v;
            $newgroups[$k2]=$v2;
            $groups=$newgroups;
            break;
          }
        }
        if (@$newgroups) break;
      }
      if (!@$newgroups) {
        unset($groups[$k]);
        $cnt--;
      }
    }
  }
  if ($cnt>=2) {
    $tostart=array();
    $tn=0;
    foreach ($groups as $k=>$v) {
      if (count($v)>=$fielddata[$user["room"]]["team"] && $k>0) {
        $i=0;
        while ($i<$fielddata[$user["room"]]["team"]) {
          $tostart[$tn][]=$v[$i];
          $i++;
        }
        $tn++;
      }
    }
    $left=count($groups[0]);
    $i1=0;
    while ($left>=$fielddata[$user["room"]]["team"]) {
      $i=0;
      while ($i<$fielddata[$user["room"]]["team"]) {
        $tostart[$tn][]=$groups[0][$i1];
        $i++;
        $i1++;
      }
      $tn++;    
      $left-=$fielddata[$user["room"]]["team"];
    }
    $map=array(
    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,0,0,0,0,0,1,0,1,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,0,0,0,0,1,'s/1/2',0,'s/1/2',0,'s/1/2',1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,0,1,0,1,0,0,0,0,0,0,0,1,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,1,'s/1/2',0,'s/1/2',0,'s/1/2',1,'s/1/2',1,'s/1/2',0,'s/1/2',0,'s/1/2',1,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,1,0,1,0,1,0,0,0,1,0,1,0,0,0,1,0,1,0,0,0,1,0,1,0,1,0,0,0,0,0,0,0,0),
    array(0,1,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',1,0,0,0,0,0,0,0),
    array(0,0,0,0,1,0,0,0,0,0,1,0,1,0,0,0,1,0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0),
    array(0,1,'s/1/2',0,'o/1/3',0,'s/1/2',0,'s/1/2',1,0,0,0,1,'s/1/2',1,0,0,0,1,'s/1/2',0,'s/1/2',0,'o/1/3',0,'s/1/2',1,0,0,0,0,0,0,0),
    array(0,0,0,0,1,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,1,0,0,0,0,0,0,0,0,0,0),
    array(0,1,'s/1/2',0,'s/1/2',1,'s/1/2',1,0,0,0,0,0,1,'s/1/2',1,0,0,0,0,0,1,'s/1/2',1,'s/1/2',0,'s/1/2',1,0,0,0,0,0,0,0),
    array(0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0),
    array(0,0,0,1,'s/1/2',0,'s/1/2',1,0,0,0,0,0,1,'s/1/2',1,0,0,0,0,0,1,'s/1/2',0,'s/1/2',1,0,0,0,0,0,0,0,0,0),
    array(0,0,1,0,0,0,0,0,1,0,0,0,1,0,0,0,1,0,0,0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,0),
    array(0,1,'s/1/2',0,'s/1/2',1,'s/1/2',0,'s/1/2',1,0,1,'s/1/2',0,'s/1/2',0,'s/1/2',1,0,1,'s/1/2',0,'s/1/2',1,'s/1/2',0,'s/1/2',1,0,0,0,0,0,0,0),
    array(0,0,0,0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0),
    array(0,1,'s/1/2',0,'o/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'o/1/4',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'o/1/2',0,'s/1/2',1,0,0,0,0,0,0,0),
    array(0,0,0,0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0),
    array(0,1,'s/1/2',0,'s/1/2',1,'s/1/2',0,'s/1/2',1,0,1,'s/1/2',0,'s/1/2',0,'s/1/2',1,0,1,'s/1/2',0,'s/1/2',1,'s/1/2',0,'s/1/2',1,0,0,0,0,0,0,0),
    array(0,0,1,0,0,0,0,0,1,0,0,0,1,0,0,0,1,0,0,0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,0),
    array(0,0,0,1,'s/1/2',0,'s/1/2',1,0,0,0,0,0,1,'s/1/2',1,0,0,0,0,0,1,'s/1/2',0,'s/1/2',1,0,0,0,0,0,0,0,0,0),
    array(0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0),
    array(0,1,'s/1/2',0,'s/1/2',1,'s/1/2',1,0,0,0,0,0,1,'s/1/2',1,0,0,0,0,0,1,'s/1/2',1,'s/1/2',0,'s/1/2',1,0,0,0,0,0,0,0),
    array(0,0,0,0,1,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,1,0,0,0,0,0,0,0,0,0,0),
    array(0,1,'s/1/2',0,'o/1/1',0,'s/1/2',0,'s/1/2',1,0,0,0,1,'s/1/2',1,0,0,0,1,'s/1/2',0,'s/1/2',0,'o/1/1',0,'s/1/2',1,0,0,0,0,0,0,0),
    array(0,0,0,0,1,0,0,0,0,0,1,0,1,0,0,0,1,0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0),
    array(0,1,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',0,'s/1/2',1,0,0,0,0,0,0,0),
    array(0,0,1,0,1,0,1,0,0,0,1,0,1,0,0,0,1,0,1,0,0,0,1,0,1,0,1,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,1,'s/1/2',0,'s/1/2',0,'s/1/2',1,'s/1/2',1,'s/1/2',0,'s/1/2',0,'s/1/2',1,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,0,1,0,1,0,0,0,0,0,0,0,1,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,0,0,0,0,1,'s/1/2',0,'s/1/2',0,'s/1/2',1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,0,0,0,0,0,1,0,1,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));

    $bad=0;
    foreach ($tostart[0] as $k=>$v) if (!$v) $bad=1;
    foreach ($tostart[1] as $k=>$v) if (!$v) $bad=1;
    if (count($tostart[0])==$fielddata[$user["room"]]["team"] && count($tostart[1])==$fielddata[$user["room"]]["team"] && !$bad) {
      mq("lock tables fieldlogs write, fields write, users write, online write, fieldparties write, fieldmembers write, obshagaeffects write, inventory write, deztow_charstams write, effects write, setstats write");
      if (!mqfa1("select id from fields where team1 like '%-".$tostart[0][0]."-%' or team2 like '%-".$tostart[0][0]."-%'")) {
        mq("insert into fields set map='".serialize($map)."', team1='-".implode("-",$tostart[0])."-', team2='-".implode("-",$tostart[1])."-'");
        $field=mysql_insert_id();
        $cond="";
        $team1="";
        $team2="";
        foreach ($tostart[0] as $k=>$v) {
          moveuser($v, $user["room"]+1);
          $rec=mqfa("select login, shadow, sex from users where id='$v'");
          mq("insert into fieldparties set user='$v', field='$field', x='".$fielddata[$user["room"]]["x1"]."', y='".$fielddata[$user["room"]]["y1"]."', dir='".$fielddata[$user["room"]]["direction1"]."', login='$rec[login]', shadow='$rec[sex]/$rec[shadow]', team=1");
          if ($team1) $team1.=", ";
          $team1.=fullnick($v);
          if ($cond) $cond.=" or ";
          $cond.=" id='$v' ";
          setstamp($v, $user["room"]);
          remfieldmember($v);
        }
        foreach ($tostart[1] as $k=>$v) {
          moveuser($v, $user["room"]+1);
          $rec=mqfa("select login, shadow, sex from users where id='$v'");
          mq("insert into fieldparties set user='$v', field='$field', x='".$fielddata[$user["room"]]["x2"]."', y='".$fielddata[$user["room"]]["y2"]."', dir='".$fielddata[$user["room"]]["direction2"]."', login='$rec[login]', shadow='$rec[sex]/$rec[shadow]', team=2");
          if ($team2) $team2.=", ";
          $team2.=fullnick($v);
          $cond.=" or id='$v' ";
          setstamp($v, $user["room"]);
          remfieldmember($v);
        }
        $log="<span class=date>".date("d.m.y H:i")."</span> Начало поединка. Участники: $team1 против $team2<BR>";
        mq("insert into fieldlogs set id='$field', team1='$team1', team2='$team2', room='".($user["room"]+1)."', log='$log'");
        $r=mq("select login from users where $cond");
        while ($rec=mysql_fetch_assoc($r)) {
          addchnavig("Поединок в пещере кристаллов начался!", $rec["login"], "field.php");
        }
        mq("update users set caveleader='$field' where $cond");
        echo "<script>document.location.replace('field.php');</script>";
      }
      mq("unlock tables");
    }
  }
}
?>

<TD nowrap valign=top><HTML>


<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px; white-space: nowrap;"></div>

</HTML>
<TABLE cellSpacing=0 cellPadding=0>
<TBODY>
<TR vAlign=top align=right>
<TD></TD>
<TD>
<?
  if (!$inteam) {
    include "config/routes.php";
    foreach ($routes[$user["room"]] as $k=>$v) $links[$rooms[$v]]="city.php?bps=1&torg=1&level$v=1";
    echo moveline($links);
  }
?>
<DIV align=right><INPUT onClick="document.location.href='vxod.php?<? echo time(); ?>'" value=Обновить type=button>
<? if ($user["room"]==51) { ?><INPUT style="font-size:12px;" type='button' onClick="location='zadaniya.php'" value="Задания"><? } ?>
</DIV></TD></TR></TBODY></TABLE>
</TD>
</TR>
</TABLE>
<div id="goto" style="text-align:right;white-space:nowrap">&nbsp;</div>
<br><br>
</BODY>
</HTML>
<?
} else {
  header("location: main.php");
}
?>
<?php include("mail_ru.php"); ?>

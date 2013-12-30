<?php
  session_start();
  include 'connect.php';
  include 'functions.php';
  //$user = mysql_fetch_array(mysql_query('SELECT u.caveleader,u.block,u.id,u.battle,u.color,u.invis,u.align,u.klan,u.chattime,u.sid,u.login,u.level,u.room,o.date FROM `users` as u, `online` as o WHERE u.`id` = o.`id` AND u.`id` = \''.$_SESSION['uid'].'\' LIMIT 1;'));
  if($user['block']>0){session_destroy();}
  if (!($_SESSION['uid'] >0)) {
    echo "<script>top.window.location='index.php?exit=0.560057875997465'</script>"; die();
  }
//if($user['klan']!='adminion'){session_destroy();}
//  $invis = mysql_fetch_array(mysql_query("SELECT * FROM `online` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
  header("Cache-Control: no-cache");

  nick99($user['id']);
  if($_GET['online'] != null) {
    if ($_GET['room'] && (int)$_GET['room'] < 900) {
      $user['room'] = (int)$_GET['room'];
    }
    $data = mysql_query('select align,u.id,sex,klan,level,login,battle,o.date,invis, (SELECT `id` FROM `effects` WHERE `type` = 2 AND `owner` = u.id LIMIT 1) as slp, (SELECT `id` FROM `effects` WHERE (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14) AND `owner` = u.id LIMIT 1) as trv,deal FROM `online` as o, `users` as u WHERE o.`id` = u.`id` AND (o.`date` >= '.(time()-90).' OR u.`in_tower`>0) AND u.`room` = '.$user['room'].' AND u.incity = "'.$user['incity'].'" ORDER by `u`.`login`;');
?>
<HTML><HEAD><link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>

<SCRIPT>

    function w(name,id,align,klan,level,slp,trv,deal,battle,name2,sex) {
            if (align.length>0) {
              altext="";
              if (align>2 && align<2.5) altext = "Ангел";
              if (align == 2.5) altext = "Ангел";
              if (align == 2.6) altext = "Ангел";
              if (align>2.6 && align<3) altext = "Ангел";
              if (align>3.00 && align<4) altext = "Тёмное Братство";
              if (align>1 && align<2 && klan !="FallenAngels") altext = "Паладин";
              if (align>1 && align<2 && klan =="FallenAngels") altext = "Падший ангел";
              if ( align == 0.98 ) altext ="Тёмный";
              if ( align == 777 ) altext ="Ангел Падальщик";
              if ( align == 4 ) altext ="В хаосе";
              if ( align == 7 ) altext ="Нейтрал";
              if ( align == 0.99 ) altext ="Светлый";
              if (!name2) name2=name;
              align='<img src="<?=IMGBASE?>/i/align_'+align+'.gif" title="'+altext+'" width=13 height=15>';
            }
            if(battle>0){filter = 'style="filter:invert"';}else{filter = '';}
            if (klan.length>0) { klan='<A HREF="/claninf.php?'+klan+'" target=_blank><img src="<?=IMGBASE?>/i/klan/'+klan+'.gif" title="'+klan+'" width=24 height=15></A>';}
            document.write('<A HREF="javascript:top.AddToPrivate(\''+name+'\', top.CtrlPress)" target=refreshed><img src="<?=IMGBASE?>/i/lock.gif" '+filter+' title="Приват" width=20 height=15></A>'+align+'<a href="(\''+name+'\',true)"></a>'+klan+'<a href="javascript:top.AddTo(\''+name+'\')" target=refreshed>'+name2+'</a>['+level+']<a href="inf.php?'+id+'" target=_blank title="Инф. о '+name+'">'+'<IMG SRC="<?=IMGBASE?>/i/inf'+sex+'.gif" WIDTH=12 HEIGHT=11 BORDER=0 ALT="Инф. о '+name+'"></a>');
            if (slp>0) { document.write(' <IMG SRC="<?=IMGBASE?>/i/sleep2.gif" WIDTH=24 HEIGHT=15 BORDER=0 ALT="Наложено заклятие молчания">'); }
            if (trv>0) { document.write(' <IMG SRC="<?=IMGBASE?>/i/travma2.gif" WIDTH=24 HEIGHT=15 BORDER=0 ALT="Инвалидность">'); }
            //if(battle>0) document.write(' <a href=/logs.php?log='+battle+' target="_blank"><IMG border="0" SRC="<?=IMGBASE?>/i/battle.gif" WIDTH=16 HEIGHT=16 BORDER=0 ALT="Персонаж в бою"></a>');
            document.write('<BR>');
    }
    top.rld();
</SCRIPT>
<title><?=$rooms[$user['room']],' (',mysql_num_rows($data)?>)</title>
</HEAD>
<body mardginwidth=0 leftmardgin=0 leftmargin=0 marginwidth=0 bgcolor=#faf2f2 onscroll="top.myscroll()" onload="document.body.scrollTop=top.OnlineOldPosition">
<center>
<?php
if (!$_GET['room']) {
?>
<BR><INPUT TYPE=button value="Обновить" onclick="location='ch.php?online=<?=time()?>'">


<?php }
if($user['room']==20 && vrag=="on"){$plroom=1;}
if($user['room']==1){$plroom=4;}
if($user['room']==403){$plroom=1;}
 ?>
</center>
<font style="COLOR:#8f0000;FONT-SIZE:10pt"><B><?=$rooms[$user['room']],' (',mysql_num_rows($data)+$plroom?>)</B></font>
<table border=0><tr><td nowrap><fant color="fffff">
<script>
<?php
  if($user['room']==1){
    //$vrag11 = mysql_fetch_array(mysql_query('select align,u.id,klan,level,login,o.date, (SELECT `id` FROM `effects` WHERE `type` = 2 AND `owner` = u.id LIMIT 1) as slp, (SELECT `id` FROM `effects` WHERE (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14) AND `owner` = u.id LIMIT 1) as trv,deal FROM `online` as o, `users` as u WHERE u.`id`=98 ;'));
    //echo 'w(\'',$vrag11['login'],'\',',$vrag11['id'],',\'',$vrag11['align'],'\',\'',$vrag11['klan'],'\',\'',$vrag11['level'],'\',\'',$vrag11['slp'],'\',\'',$vrag11['trv'],'\',\'',(int)$row['deal'],'\',\'',$vrag_b11['battle'],'\');';
    echo 'w(\'Комментатор\', 98,\'1.99\',\'\',\'18\',\'\',\'\',\'0\',\'\',\'Комментатор\',1);';
    //$vrag22 = mysql_fetch_array(mysql_query('select align,u.id,klan,level,login,o.date, (SELECT `id` FROM `effects` WHERE `type` = 2 AND `owner` = u.id LIMIT 1) as slp, (SELECT `id` FROM `effects` WHERE (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14) AND `owner` = u.id LIMIT 1) as trv,deal FROM `online` as o, `users` as u WHERE u.`id`=171 ;'));

  }

  if($user['room']==403){
    //$vrag22 = mysql_fetch_array(mysql_query('select align,u.id,klan,level,login,o.date, (SELECT `id` FROM `effects` WHERE `type` = 2 AND `owner` = u.id LIMIT 1) as slp, (SELECT `id` FROM `effects` WHERE (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14) AND `owner` = u.id LIMIT 1) as trv,deal FROM `online` as o, `users` as u WHERE u.`id`=24 ;'));
    //echo 'w(\'',$vrag22['login'],'\',',$vrag22['id'],',\'',$vrag22['align'],'\',\'',$vrag22['klan'],'\',\'',$vrag22['level'],'\',\'',$vrag22['slp'],'\',\'',$vrag22['trv'],'\',\'',(int)$row['deal'],'\',\'',$vrag_b22['battle'],'\');';
    echo 'w(\'Лука\',', 24,',\'', 9,'\',\'','','\',\'',8,'\',\'','','\',\'','','\',\'',0,'\',\'\',\'Лука\',1);';
  }
  
  if($user['room']==20 && vrag=="on"){
    //$vrag = mysql_fetch_array(mysql_query('select align,u.id,klan,level,login,o.date, (SELECT `id` FROM `effects` WHERE `type` = 2 AND `owner` = u.id LIMIT 1) as slp, (SELECT `id` FROM `effects` WHERE (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14) AND `owner` = u.id LIMIT 1) as trv,deal FROM `online` as o, `users` as u WHERE u.`id`=99 ;'));
    $vrag_b = mysql_fetch_array(mysql_query("SELECT `battle` FROM `bots` WHERE  `prototype` = 99 LIMIT 1 ;"));

    //echo 'w(\'',$vrag['login'],'\',',$vrag['id'],',\'',$vrag['align'],'\',\'',$vrag['klan'],'\',\'',$vrag['level'],'\',\'',$vrag['slp'],'\',\'',$vrag['trv'],'\',\'',(int)$row['deal'],'\',\'',$vrag_b['battle'],'\');';
    echo 'w(\'Общий Враг\', 99,\'4\',\'\',\'15\',\'\',\'\',\'0\',\''.$vrag_b["battle"].'\',\'Общий враг\',1);';
  }

  while($row=mysql_fetch_array($data)) {
    //if ($row['slp']=='NULL')  { $row['slp'] = 0; }
    if ($row['invis']>0 && $row['id']==$_SESSION['uid'])  { $row['login2'] = $row['login']."</a> (невидимка)"; }
    $i=0;
    if($row['invis']==0 or $row['id']==$_SESSION['uid']){
      $i++;

      if ($row["id"]==2236) $row["level"]="?";
      echo 'w(\'',$row['login'],'\',',$row['id'],',\'',$row['align'],'\',\'',$row['klan'],'\',\'',$row['level'],'\',\'',$row['slp'],'\',\'',$row['trv'],'\',\'',(int)$row['deal'],'\',\'',$row['battle'],'\',\'',$row['login2'],'\', '.$row["sex"].');';
    }
  }
?>
</script>
</td></tr></table>
<?php
if (!$_GET['room']) {
?>
    <SCRIPT>document.write('<INPUT TYPE=checkbox onclick="if(this.checked == true) { top.OnlineStop = false; } else { top.OnlineStop=true; }" '+(top.OnlineStop?'':'checked')+'> Обновлять автоматич.')
    </SCRIPT></body></html>
<?php
    die();
}
    } elseif (@$_GET['show'] != null) {
      if($_SESSION['sid'] != $user['sid']) {
        $_SESSION['uid'] = null;
        die ("<script>top.location.href='index.php';</script>");
      }
      $cha = file(CHATROOT."chat.txt");
      header('Content-Type: text/html; charset=windows-1251');
        echo "<script>";
        $ks = 0;
        if ($_SESSION["chattime"]) {
          $tmp=explode("-",$_SESSION["chattime"]);
          $user['chattime']=$tmp[0];
          $lastline=$tmp[1];
        } else {
          $lastline=0;
          $user["chattime"]=0;
        }
        $curline=0;
        $hlchat=0;
        function checktolog($s) {
          global $user;
          if (!$s) return;
          if ($user["id"]==8505 || $user["id"]==924 || $user["id"]==2735) {
            $f=fopen("encicl/images/cl$user[id].dat", "ab+");
            fwrite($f, $s);
            fclose($f);
          }
        }
        $opt="";
        foreach($cha as $k => $v) {
            //echo "alert('df');";
            $curline++;
            $tme=(int)substr($v,2,10);
            if ($tme<$user['chattime'] || ($tme==$user['chattime'] && $curline<=$lastline)) continue;
            if ($user["id"]==204 && strpos($v,"<font m ")) {
              $v=str_replace("private ", "private [Мусорщик] ", $v);
            }
            preg_match("/:\[(.*)\]:\[(.*)\]:\[(.*)]:\[(.*)\]/",$v,$math);
            //print_r($data);
            $math[3] = stripslashes($math[3]);
            if ((@$math[2] == '{[]}'.$user['login'].'{[]}') && (@$math[1] >= @$user['chattime'])) {
              $tmp="";
              if (!$user["battle"] && strpos($math[3],"fbattle.php")) $math[3]=str_replace("top.frames['main'].location='fbattle.php';","",$math[3]);
              if ($user["battle"] && strpos($math[3],"fbattle.php")) $tmp="top.soundB($user[battle]);";
              echo "top.frames['chat'].document.getElementById(\"mes\").innerHTML += '<span class=date2>".date("H:i",$math[1])."</span> ".$math[3]." <BR>';$tmp";
              $hlchat=1;
              $ks++;
              $lastpost = $math[1];
              //$opt.="(1) $math[3]<br>\r\n";
            }
            elseif(substr($math[2],0,4) == '{[]}' && (@$math[1] >= @$user['chattime'])) {
                //exit;
            } elseif ((@$math[2] == '!sys!!') && (@$math[1] >= @$user['chattime']) && ($user['room']==$math[4]) && $_GET['om'] != 1) {
                if($_GET['sys'] == 1 OR strpos($math[3],"<img src=i/magic/" ) !== FALSE) {
                    echo "top.frames['chat'].document.getElementById(\"mes\").innerHTML += '<span class=date>".date("H:i",$math[1])."</span> ".$math[3]." <BR>';";
                    $hlchat=1;
                    $ks++;
                    $lastpost = $math[1];
                    //$opt.="(2) $math[3]<br>\r\n";
                }
                $skip=0;
                if(in_array($user["room"], $canalrooms)) {
                  if (!strpos($math[3], $user["login"])) $skip=1;
                }
                if (!$skip) {
                  echo "top.frames['chat'].document.getElementById(\"mes_sys\").innerHTML += '<span class=date>".date("H:i",$math[1])."</span> ".$math[3]." <BR>';";
                  $ks++;
                  $lastpost = $math[1];
                  //$opt.="(3) $math[3]<br>\r\n";
                }
            } elseif ((@$math[2] == '!cavesys!!') && (@$math[1] >= @$user['chattime']) && ($user['caveleader']==$math[4])) {
                echo "top.frames['chat'].document.getElementById(\"mes\").innerHTML += '<span class=date>".date("H:i",$math[1])."</span> ".$math[3]." <BR>';";
                $ks++;
                $lastpost = $math[1];
                //$opt.="(4) $math[3]<br>\r\n";
            } elseif (@$math[2] == '!sys2all!!' && @$math[1] >= @$user['chattime']) {
                echo "top.frames['chat'].document.getElementById(\"mes\").innerHTML += '<span class=date>".date("H:i",$math[1])."</span> ".$math[3]." <BR>';";
                $hlchat=1;
                $ks++;
                $lastpost = $math[1];
                //$opt.="(5) $math[3]<br>\r\n";
            } elseif (@$math[1] >= @$user['chattime']) {
/*              if (strpos($math[3],"private [pal-" ) !== FALSE) {
                    $chans = mysql_fetch_array(mysql_query("SELECT `name` FROM `chanels` WHERE `klan`='pal' AND `user` = '".$user['id']."';"));
                    $chans = explode(",",$chans['name']) ;
                    $pos = strpos($math[3],"[pal-" )+5;
                    if(in_array(substr($math[3],$pos,1),$chans)) {
                        $math[3] = preg_replace("/private \[pal-([1-9])]/Ue", "'<a href='.chr(92).'\'javascript:top.AddToPrivate(\"pal-\\1\",false)'.chr(92).'\' class=private>private [ pal-\\1 ]</a>'", $math[3]);
                        //$math[3] = str_replace("private [{$user['login']}]", "<a href=javascript:top.AddToPrivate(\"{$math[2]}\",false) class=private>private [ {$user['login']} ]</a>",$math[3]);
                        echo "top.frames['chat'].document.getElementById(\"mes\").innerHTML += '<span class=date2>".date("H:i",$math[1])."</span> [<a href=\'javascript:top.AddTo(\"{$math[2]}\")\'><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] ".$math[3]." <BR>';";
                        $ks++;
                        $lastpost = $math[1];
                    }
                }
            else*/if (@$math[1] >= @$user['chattime']) {
/*              if (strpos($math[3],"private [tar-" ) !== FALSE) {
                    $chans = mysql_fetch_array(mysql_query("SELECT `name` FROM `chanels` WHERE `klan`='tar' AND `user` = '".$user['id']."';"));
                    $chans = explode(",",$chans['name']) ;
                    $pos = strpos($math[3],"[tar-" )+5;
                    if(in_array(substr($math[3],$pos,1),$chans)) {
                        $math[3] = preg_replace("/private \[tar-([1-9])]/Ue", "'<a href='.chr(92).'\'javascript:top.AddToPrivate(\"tar-\\1\",false)'.chr(92).'\' class=private>private [ tar-\\1 ]</a>'", $math[3]);
                        //$math[3] = str_replace("private [{$user['login']}]", "<a href=javascript:top.AddToPrivate(\"{$math[2]}\",false) class=private>private [ {$user['login']} ]</a>",$math[3]);
                        echo "top.frames['chat'].document.getElementById(\"mes\").innerHTML += '<span class=date2>".date("H:i",$math[1])."</span> [<a href=\'javascript:top.AddTo(\"{$math[2]}\")\'><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] ".$math[3]." <BR>';";
                        $ks++;
                        $lastpost = $math[1];
                    }
                }
                elseif (strpos($math[3],"private [klan-{$user['klan']}-" ) !== FALSE) {
                    $chans = mysql_fetch_array(mysql_query("SELECT `name` FROM `chanels` WHERE `klan`='".$user['klan']."' AND `user` = '".$user['id']."';"));
                    $chans = explode(",",$chans['name']) ;
                    $pos = strpos($math[3],"[klan-{$user['klan']}-" )+strlen($user['klan'])+7;
                    if(in_array(substr($math[3],$pos,1),$chans)) {
                        $math[3] = preg_replace("/private \[klan-".$user['klan']."-([1-9])]/Ue", "'<a href='.chr(92).'\'javascript:top.AddToPrivate(\"klan-\\1\",false)'.chr(92).'\' class=private>private [ klan-\\1 ]</a>'", $math[3]);
                        //$math[3] = str_replace("private [{$user['login']}]", "<a href=javascript:top.AddToPrivate(\"{$math[2]}\",false) class=private>private [ {$user['login']} ]</a>",$math[3]);
                        echo "top.frames['chat'].document.getElementById(\"mes\").innerHTML += '<span class=date2>".date("H:i",$math[1])."</span> [<a href=\'javascript:top.AddTo(\"{$math[2]}\")\'><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] ".$math[3]." <BR>';";
                        $ks++;
                        $lastpost = $math[1];
                    }
                }
                else*/if (strpos($math[3],"private [pal]" ) !== FALSE) {
                    if((int)$user['align']==1 OR $user['id'] == 1) {
                        $math[3] = preg_replace("/private \[pal]/Ue", "'<a href='.chr(92).'\'javascript:top.AddToPrivate(\"pal\",false)'.chr(92).'\' class=private>private [ pal ]</a>'", $math[3]);
                        //$math[3] = str_replace("private [{$user['login']}]", "<a href=javascript:top.AddToPrivate(\"{$math[2]}\",false) class=private>private [ {$user['login']} ]</a>",$math[3]);
                        echo "top.frames['chat'].document.getElementById(\"mes\").innerHTML += '<span class=date2>".date("H:i",$math[1])."</span> [<a href=\'javascript:top.AddTo(\"{$math[2]}\")\'><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] ".$math[3]." <BR>';";
                        $hlchat=1;
                        $ks++;
                        $lastpost = $math[1];
                        $opt.="(6) $math[2]: $math[3]<br>\r\n";
                    }
                }
                elseif (strpos($math[3],"private [tar]" ) !== FALSE) {
                    if((int)$user['align']==3 OR $user['id'] == 1) {
                        $math[3] = preg_replace("/private \[tar]/Ue", "'<a href='.chr(92).'\'javascript:top.AddToPrivate(\"tar\",false)'.chr(92).'\' class=private>private [ tar ]</a>'", $math[3]);
                        //$math[3] = str_replace("private [{$user['login']}]", "<a href=javascript:top.AddToPrivate(\"{$math[2]}\",false) class=private>private [ {$user['login']} ]</a>",$math[3]);
                        echo "top.frames['chat'].document.getElementById(\"mes\").innerHTML += '<span class=date2>".date("H:i",$math[1])."</span> [<a href=\'javascript:top.AddTo(\"{$math[2]}\")\'><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] ".$math[3]." <BR>';";
                        $hlchat=1;
                        $ks++;
                        $lastpost = $math[1];
                    }
                }
                elseif (((strpos($math[3],"private [klan-{$user['klan']}]" ) !== FALSE) && $user["in_tower"]!=1 && $user["in_tower"]!=2)) {
                    if($user['klan']!='') {



                        $math[3] = preg_replace("/private \[klan\-{$user['klan']}\]/Ue", "'<a href='.chr(92).'\'javascript:top.AddToPrivate(\"klan\",false)'.chr(92).'\' class=private>private [ klan ]</a>'", $math[3]);
                        //$math[3] = str_replace("private [{$user['login']}]", "<a href=javascript:top.AddToPrivate(\"{$math[2]}\",false) class=private>private [ {$user['login']} ]</a>",$math[3]);
                        echo "top.frames['chat'].document.getElementById(\"mes\").innerHTML += '<span class=date2>".date("H:i",$math[1])."</span> [<a href=\'javascript:top.AddTo(\"{$math[2]}\")\'><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] ".$math[3]." <BR>';";
                        echo "top.frames['chat'].document.getElementById(\"mes_clan\").innerHTML += '<span class=date2>".date("H:i",$math[1])."</span> [<a href=\'javascript:top.AddTo(\"{$math[2]}\")\'><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] ".$math[3]." <BR>';";
                        $hlchat=1;
                        $ks++;
                        $lastpost = $math[1];
                        $opt.="(7) $math[2]: $math[3]<br>\r\n";
                    }
                }
                elseif (((strpos($math[3],"private [{$user['login']}]" ) !== FALSE) OR ($math[2] == $user['login'])) && $user["in_tower"]!=1 && $user["in_tower"]!=2) {
                    $sound=false;
                    preg_match_all("/private \[(.*)\]/siU",$math[3],$mmm,PREG_PATTERN_ORDER);
                    foreach($mmm[1] as $res){
                        $res=trim($res);
                        if ($sound==false)
                            $sound=($res==$user['login'])?true:false;
                        if (strlen($res)<3 || strlen($res)>25 || !ereg("^[ёa-zA-Zа-яА-Я0-9-][ёa-zA-Zа-яА-Я0-9_ -]+[a-zA-Zа-яА-Я0-9ё-]$",$res)  || preg_match("/__/",$res) || preg_match("/--/",$res) || preg_match("/  /",$res) || preg_match("/(.)\\1\\1\\1/",$res)){
                            $math[3]=str_replace($res,$user['login'],$math[3]);
                        }
                    }
                    $math[3] = preg_replace("/private \[(.*)\]/Ue", "'<a href='.chr(92).'\'javascript:top.AddToPrivate(\"'.(('\\1' != '".$user['login']."')?'\\1':'".$math[2]."').'\",false)'.chr(92).'\' class=private>private [ <span oncontextmenu=\"return OpenMenu(event,".$user['level'].")\">\\1</span> ]</a>'", $math[3]);
                    //$math[3] = str_replace("private [{$user['login']}]", "<a href=javascript:top.AddToPrivate(\"{$math[2]}\",false) class=private>private [ {$user['login']} ]</a>",$math[3]);
                    $sssss="top.frames['chat'].document.getElementById(\"mes\").innerHTML += '<span class=date2>".date("H:i",$math[1])."</span> [<a href=\'javascript:top.AddTo(\"{$math[2]}\")\'><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] ".$math[3]." <BR>';";
                    $opt.="(8) $math[2]: $math[3]<br>\r\n";
                    if ($sound==true)
                        $sssss.="top.soundD();";
                    echo $sssss;
                    //echo "top.frames['chat'].document.getElementById(\"mes\").innerHTML += '<span class=date2>".date("H:i",$math[1])."</span> [<a href=\'javascript:top.AddTo(\"{$math[2]}\")\'><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] ".$math[3]." <BR>';";
                    $ks++;
                    $lastpost = $math[1];
                } elseif(( strpos($math[3],"private" ) === FALSE ) && ($user['room']==$math[4] || ($user["id"]==204 && $math[2]!='!sys!!' && $math[2]!='!cavesys!!'))) {
                    $times = ''; $soundON='';
                    if ((strpos($math[3],"[".$user['login']."]") > 0) OR ($math[2] == $user['login'])) {
                        $times = 'date2';
                        //$math[3] = preg_replace("/to \[".$user['login']."\]/U", "<B>".$math[2]."</B>", $math[3]);
                        $math[3] = str_replace("to [".$user['login']."]","<B>to [".$user['login']."]</B>",$math[3] );
                        $soundON='top.soundD();';
                    } elseif($_GET['om'] != 1) {
                        $times = 'date';
                    }
                    if($_GET['om'] != 1 OR $times == 'date2') {
                        echo $soundON."top.frames['chat'].document.getElementById(\"mes\").innerHTML += '<span class={$times}>".date("H:i",$math[1])."</span> [<a href=\'javascript:top.AddTo(\"{$math[2]}\")\'><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] ".$math[3]." <BR>';";
                        $opt.="(9) $math[2]: $math[3]<br>\r\n";
                        $ks++;
                        $lastpost = $math[1];
                        $hlchat=1;
                    }
                }
            }
        }
      }
      checktolog($opt);
      if ($hlchat) echo "top.hlchat();";
        if ($ks > 0) {
          //mysql_query("UPDATE `users` SET `chattime` = '".($lastpost+1)."' WHERE `id` = {$user['id']};");
          $_SESSION["chattime"]="$lastpost-$curline";
        }
        echo "</script><script> top.srld();</script>";
            if ((int)$user['id']!=1)
            mysql_query("UPDATE `online` SET `date` = ".time()." WHERE `id` = {$user['id']};");
            die();
    } else {

        if (strpos($_GET['text'],"private" ) !== FALSE && $user['level'] == 0) {
            preg_match_all("/\[(.*)\]/U", $_GET['text'], $matches);
            //echo "<script>alert('". $matches[1]."')</script>";
            for ($ii=0;$ii<count($matches[1]);$ii++){
                $dde = mysql_fetch_array(mysql_query("SELECT `id` FROM `users` WHERE (`klan` = 'adminion' OR `deal` = 1 OR (`align`>1 AND `align`<2) OR (`align`>3 AND `align`<4)) AND `login` = '".trim($matches[1][$ii])."' LIMIT 1 ;"));
                if (!$dde['id']) {
                    exit;
                }
            }
        }
        if (@trim($_GET['text']) != null) {
          $_GET["text"]=str_replace("\\","",$_GET["text"]);
          $rr = mysql_fetch_array(mysql_query("SELECT `id`  FROM `effects` WHERE `type` = 2 AND `owner` = {$user['id']};"));


        if ($rr[0] == null) {
          $_GET["text"]=str_replace("top.document.write","",$_GET["text"]);
          $_GET["text"]=str_replace("'","\\\\'",$_GET["text"]);
          $hl=haslinks($_GET["text"]);
          if ($_SESSION["uid"]==7) {
            //$hl=0;
            //$hl=0;
            //$f=fopen("ot.txt","ab");
            //fwrite($f, "$_GET[text]q\r\n");
            //fclose($f);
          }
          if (!$hl) {
            $txt=$_GET["text"];
            $bad=hasbad($txt);
          }       //&& $user["id"]!=7
          if ($hl ) {
            if ($user["id"] != 7) { 
                $f=fopen("logs/autosleep.txt","ab");
                fwrite($f, "$user[login]: $_GET[text]\r\n");
                fclose($f);
                mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".$user['id']."','Заклятие молчания',".(time()+1800).",2);");
                $_GET["text"]=str_replace("private","рrivate", $_GET["text"]);
                reportadms("<br><b>$user[login]</b>: $_GET[text]", "Комментатор");
            }
            addch("<img src=i/magic/sleep.gif> Комментатор наложил заклятие молчания на &quot;{$user['login']}&quot;, сроком 30 мин. Причина: РВС.");
            //$user = mysql_fetch_array(mysql_query("SELECT `id` FROM `users` WHERE `login` = '{$_POST['target']}' LIMIT 1;"));
            //mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".$user['id']."','Заклятие молчания',".(time()+1800).",2);");
          } elseif ($bad) {
            $f=fopen("logs/autosleep.txt","ab");
            fwrite($f, "$user[login]: $_GET[text]\r\n");
            fclose($f);
            mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".$user['id']."','Заклятие молчания',".(time()+900).",2);");
            $_GET["text"]=str_replace("private","рrivate", $_GET["text"]);
            addchp("<font color=\"Black\">private [Женя] <br><b>$user[login]</b>: $_GET[text]</font>", "Комментатор");
            addch("<img src=i/magic/sleep.gif> Комментатор наложил заклятие молчания на &quot;{$user['login']}&quot;, сроком 15 мин. Причина: мат.");
          } elseif ($_GET["text"]==$_SESSION["lastmsg"]) {
          } else {
            $_SESSION["lastmsg"]=$_GET["text"];
            if (!in_array($user["id"], $djs) && $user["id"]!=2735 && $user["id"]!=2372) {
              $_GET['text']=preg_replace("/:8[0-9][0-9]:/", "", $_GET['text']);
            }
            if ($user["id"]!=2735 && $user["id"]!=2372) {
              $_GET['text']=str_replace(":228:", "", $_GET['text']);
              $_GET['text']=str_replace(":229:", "", $_GET['text']);
            }
            $_GET['text'] = substr($_GET['text'],0,400);
            $_GET['text'] = str_replace('<','&lt;',$_GET['text']);
            $_GET['text'] = str_replace(']:[','] : [',$_GET['text']);
            $_GET['text'] = str_replace('>','&gt;',$_GET['text']);


            $_GET['text'] = ereg_replace('private \[klan-([a-zA-Z]*)\]','',$_GET['text']);

            if ($user['klan'] == '') {
                $_GET['text'] = str_replace('private [klan]','',$_GET['text']);
                $_GET['text'] = str_replace('private [klan]','private [klan-'.$user['klan'].']',$_GET['text']);
            }
            else {
               // $k1 = Array("/:\[klan-1\]:/","/:\[klan-2\]:/","/:\[klan-3\]:/","/:\[klan-4\]:/","/:\[klan-5\]:/","/:\[klan-6\]:/","/:\[klan-7\]:/","/:\[klan-8\]:/","/:\[klan-9\]:/");
                //$k2 = Array("[klan-".$user['klan']."-1]","[klan-".$user['klan']."-2]","[klan-".$user['klan']."-3]","[klan-".$user['klan']."-4]","[klan-".$user['klan']."-5]","[klan-".$user['klan']."-6]","[klan-".$user['klan']."-7]","[klan-".$user['klan']."-8]","[klan-".$user['klan']."-9]");
                $_GET['text'] = str_replace('private [klan]','private [klan-'.$user['klan'].']',$_GET['text']);

/*              $_GET['text'] = ereg_replace('private \[klan-([1-9])\]','private [klan-'.$user['klan'].'-\\1]',$_GET['text']);

                $chans = mysql_fetch_array(mysql_query("SELECT `name` FROM `chanels` WHERE `klan`='".$user['klan']."' AND `user` = '".$user['id']."';"));
                $chans = explode(",",$chans['name']) ;
                $pos = strpos($_GET['text'],"[klan-{$user['klan']}-" )+strlen($user['klan'])+7;
                if(!in_array(substr($_GET['text'],$pos,1),$chans)) {
                    $_GET['text'] = ereg_replace("private \[klan-{$user['klan']}-[1-9]\]",'',$_GET['text']);
                }

*/              //$_GET['text'] = preg_replace($k1, $k2, $_GET['text'],3);
            }
                if((int)$user['align'] != 1 AND $user['id'] != 1) {
                $_GET['text'] = str_replace('private [pal]','',$_GET['text']);
//              $_GET['text'] = ereg_replace("private \[pal-[1-9]\]",'',$_GET['text']);
            }/* else {
                $chans = mysql_fetch_array(mysql_query("SELECT `name` FROM `chanels` WHERE `klan`='pal' AND `user` = '".$user['id']."';"));
                $chans = explode(",",$chans['name']) ;
                $pos = strpos($_GET['text'],"[pal-" )+5;
                if(!in_array(substr($_GET['text'],$pos,1),$chans)) {
                    $_GET['text'] = ereg_replace("private \[pal-[1-9]\]",'',$_GET['text']);
                }
            }*/
                if((int)$user['align'] != 3 AND $user['id'] != 1) {
                $_GET['text'] = str_replace('private [tar]','',$_GET['text']);
//              $_GET['text'] = ereg_replace("private \[tar-[1-9]\]",'',$_GET['text']);
            }/* else {
                $chans = mysql_fetch_array(mysql_query("SELECT `name` FROM `chanels` WHERE `klan`='tar' AND `user` = '".$user['id']."';"));
                $chans = explode(",",$chans['name']) ;
                $pos = strpos($_GET['text'],"[tar-" )+5;
                if(!in_array(substr($_GET['text'],$pos,1),$chans)) {
                    $_GET['text'] = ereg_replace("private \[tar-[1-9]\]",'',$_GET['text']);
                }
            }*/

if($user['level']<=1){
            $_GET['text'] = eregi_replace('o(.)*l(.)*d(.)*c(.)*o(.)*m(.)*b(.)*a(.)*t(.)*s','<b><font color=red> а я РВС-ник!</font></b>',$_GET['text']);
            $_GET['text'] = eregi_replace('a(.)*r(.)*d(.)*a(.)*n(.)*i(.)*y(.)*a','<b><font color=red> а я РВС-ник!</font></b>',$_GET['text']);
            $_GET['text'] = eregi_replace('l(.)*f(.)*i(.)*g(.)*h(.)*t','<b><font color=red> а я РВС-ник!</font></b>',$_GET['text']);
            $_GET['text'] = eregi_replace('a(.)*r(.)*d(.)*a(.)*n(.)*u(.)*y(.)*a','<b><font color=red> а я РВС-ник!</font></b>',$_GET['text']);
            $_GET['text'] = eregi_replace('o(.)*l(.)*d(.)*b(.)*k','<b><font color=red> а я РВС-ник!</font></b>',$_GET['text']);
            $_GET['text'] = eregi_replace('n(.)*e(.)*w(.)*-(.)*b(.)*k','<b><font color=red> а я РВС-ник!</font></b>',$_GET['text']);
            $_GET['text'] = eregi_replace('a(.)*r(.)*d(.)*a(.)*n(.)*u(.)*y(.)*a','<b><font color=red> а я РВС-ник!</font></b>',$_GET['text']);
            $_GET['text'] = eregi_replace('l(.)*a(.)*s(.)*t(.)*w(.)*o(.)*r(.)*l(.)*d(.)*s','<b><font color=red> а я РВС-ник!</font></b>',$_GET['text']);
            $_GET['text'] = eregi_replace('t(.)*e(.)*k(.)*k(.)*e(.)*n','<b><font color=red> а я РВС-ник!</font></b>',$_GET['text']);
            $_GET['text'] = eregi_replace('n(.)*e(.)*w(.)*a(.)*b(.)*k','<b><font color=red> а я РВС-ник!</font></b>',$_GET['text']);

}


include 'smiles.php';
if($user['invis']=='1') {
$tme=mqfa1("select time from effects where owner='$user[id]' and type='1022'");
$user['login'] = '</a><b><i>невидимка '.substr($tme,strlen($tme)-4).'</i></b>';
}
if (filesize(CHATROOT."chat.txt")>100*1024) {
if ($user['id'] != '1') {
$file=file(CHATROOT."chat.txt");
$fp=fopen(CHATROOT."chat.txt","w");
flock ($fp,LOCK_EX);
for ($s=0;$s<count($file)/1.6;$s++) {
unset($file[$s]);}
fputs($fp, implode("",$file));
fputs($fp ,"\r\n:[".time ()."]:[{$user['login']}]:[<font color=\"".(($user['color'])?$user['color']:"#000000")."\">".($_GET['text'])."</font>]:[".$user['room']."]\r\n"); 
flock ($fp,LOCK_UN);
fclose($fp);}
} else {
if ($user['id'] != '1') {
$fp = fopen (CHATROOT."chat.txt","a"); //открытие
flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
fputs($fp ,":[".time ()."]:[{$user['login']}]:[<font ".($user["level"]<4?"m":"")." color=\"".(($user['color'])?$user['color']:"#000000")."\">".($_GET['text'])."</font>]:[".$user['room']."]\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose ($fp);
}
}
if (strpos($_GET['text'],"to [Комментатор]" ) !== FALSE) {
if (strpos($_GET['text'],"to [Комментатор] анекдот" ) !== FALSE) {
$commas = array('Артника может обидеть каждый, но не каждый успеет извиниться. &copy;Мимоза',
'БКшник сдает кровь. Медсестра, завязывая жгут: - Так, работаем кулачком! - По корпусу или в челюсть? &copy;Мимоза',
'Артник приходит из центральной площади в клан с синяками на теле . Глава его спрашивает: — Что, напали? — Да, меч кромуса хотели отобрать. — Так ты их нам опознать-то сможешь? — А чё я-то? Пускай теперь их сокланновцы в морге опознают... &copy;Секс-Любовник',
'Сидит команда в башне смерти. Делят оружие, вдруг в комнату входит член другой команды, весь уже разодетый. Глава команды кричит одному из своих: - МАРИНУЙ! - От маринуя слышу! &copy;Arkada',
'"Сойдет за близы" - сказал Илья Муромец завязывая вокруг шеи змея Горыныча',
'Часы показывали 16.08.03 12:00, когда бойцы клана MIB и Орден Паладинов бросили вызов друг другу. 12:01 Бой закончен. Победа за Мусорщик',
'ХХХХ: Долой муфлонов из чата!!! Demian Black: Пользователь ХХХХ был удалён по собственному желанию. &copy;XyliGUNka',
'В конкурсе по женской логике победил генератор ударов &copy;Алексей',
'Я вчера с такой девушкой познакомился… 90-60-90! - да ладно!! а выносливость сколько? &copy;Akrobat',
'-Ах ты крыса!!! Ясно ж сказано, ТОЛЬКО ЯНТАРКИ! -Так я ж так и одет! -А эли, эли это что такое?! -Умные да?! А сами-то сможете на эль янтарку нацепить?!! &copy;Arkada',
'-Думаете, Legendarybk - просто клон? Качайтесь, кризис скоро закончится.. &copy;Гефест',
'Трин достала записку Комментатора. Комментатор орал и отбивался ногами. &copy;Посеша',
'Ночь. Темно. Барон Муха идет по Центральной площади. Справа мелькнула тень. "Это merlin", - подумал Барон Муха. "Да, это я", - подумал merlin. &copy;Посеша',
'Проходя мимо будуара, merlin услышал задорный женский смех. "Недосуг" - подумал merlin. &copy;Посеша',
'Хороший, плохой, главный тот, у кого сусел! &copy;Thomas Malton',
'Наши комментаторы, самые <вырезано цензурой> комментаторские комментаторы в мире!');
addchp($commas[rand(0,count($commas)-1)],"Комментатор");} else {
$commas = array('Так слово за слова и получил Иванушка инвалидность...',
'Что поговорить больше не с кем?',
'Отдыхай!',
'Вас много, комментатор - один!',
'А станете наезжать, не буду комментировать ваши бои!',
'Отвали!',
'Тренируйся на кошечках!',
'Анекдот: - Товарищ водитель, почему ваша пассажирка не пристегнута ремнями безопасности? - Так это же моя тёща!!',
                                'Сам такой!',
                                'Продам кредиты (в приват)',
                                'мдя...',
                                'Лучше в бою проявляй энтузиазм.',
                                'Кто тут комментатор? Ты или я???',
                                'Надо же...',
                                'Сам такой!',
                                'Наши комментаторы, самые <вырезано цензурой> комментаторские комментаторы в мире!',
                                '(судорожно оглядываясь) КТО ЗДЕСЬ???',
                                'Не болтайте ерундой',
                                'Все! Теперь ты мне должен!',
                                'р-р-р...',
                                'А в бою это повторить сможешь?',
                                'Я долго думал, что такое 90х60х90. Оказалось, что это 486 000.',
                                'Может тебе кредитов дать, чтоб отстал?',
                                'Братву позову!',
                                'Твой интеллект поражает <вырезано цензурой>',
                                'Вот сижу тут и разбавляю свою мудрость вашей глупостью.',
                                'Ты с кем посоревноваться решил?',
                                'Ждите ответа. Ждите ответа. Ждите ответа. Ждите ответа. Ждите, короче...',
                                'Я комментатор! А ты кто???',
                                'Поехали мы в Дагестан на конкурс чтецов. Слово за слово - 18 трупов.',
                                'Катится, катится Колобок, а навстречу ему Слон. - Блин, прости, - говорит слон.',
                                'Теща рылась на книжной полке зятя, как вдруг вывалилась заначка и убила тещу. Отсюда вывод: прячьте побольше!',
                                'Границу с Кореей российские пограничники выходят караулить с медведями. Собаки как-то не прижились.',
                                'Это я-то нерешительный? Сомневаюсь…',
                                'Я не открою вам Америки…, - начал свою лекцию доцент Середняков, после чего три студента в первом ряду встали и ушли.',
                                'Мальчик сломал руку в шести местах когда показывал как пройти лабиринт.',
                                'Обычно сказки о Василисе Предоброй на два свидания короче, чем сказки о Василисе Прекрасной.',
                                'Наконец-то мы вылечились от раздвоения личности, - сказал гражданин Мухаморов, выходя из кабинета психиатра.',
                                'Это не телефонный разговор, - сказал глава ФСБ, услышав пение соловья.',
                                'Подростки неумело пытаются изнасиловать женщину. Она: «Только не в нос',
                                'А почему ваше кафе называется "У вампира"? - спросил Евгений слабеющим голосом.',
                                '8 марта женщин у "Интуриста" сменили представители сильного пола.',
                                'Блин, на работе не кофейный аппарат, а какой-то офисный тамагочи - сначала ему воды налей, потом зернами покорми, а затем и отходы убери. Так этот поганец еще и под себя написал!',
                                'Давно известно, что 20% людей делают 80% работы. Недавно выяснилось, что 80% людей считают, что они входят в эти 20%',
                                'А знаете, зачем в метро внизу эскалатора бабулька в будке? Она там педали крутит.',
                                'В бухгалтерии одной из фирм всеобщим любимцем был черный котенок по имени Нал.',
                                '"Если водитель пристегнут ремнем безопасности, едет со скоростью не выше 60 км/час, загодя тормозит перед светофором, не стремится проскочить на желтый, терпеливо тащится за ввонючим грузовиком, пропускает пешеходов на переходе и вообще не нарушает ни одного пункта ПДД, значит, скорее всего, он просто пьян".',
                                'передавай им кляузу',
                                'Женщина любит ушами, а мужчина - глазами. Эротическо-сексуальная поза номер 153. Мужчина смотрит женщине в ухо.',
                                'Одна стотысячная секунды - это время между тем как зажегся зеленый свет и гудком сзади.',
                                'Вовочка, назови 5 африканских животных. Вовочка, назови 5 африканских животных. 3 обезьяны и 2 слона',
                                'Тоже неплохо! - сказал зять, бросив камнем в собаку и попав в тещу.',
                                'Молодой солдат пишет письмо домой: "Мать, купи кота, назови Прапор. Приеду - убью".',
                                'Вчера милиция поймала карманного вора, который за последнюю неделю украл более 100 карманов.',
                                'Вчера милиция поймала карманного вора, который за последнюю неделю украл более 100 карманов.',
                                'На Новый Год все одели разные маски: кто зайчика, кто лисички... И только сисадмин одел свою любимую: 255.255.255.0',
                                'Ощущение - это чувство, которое мы ощущаем, когда что-то чувствуем...',
                                '"Наша взяла..." (чистосердечное признание чукотского взяточника).',
                                'Магазин на диване, ресторан на диване, работа на диване, дом на диване, дискотека на диване... Вся жизнь на диване! Такая уж она у нас, клопов...',
                                'Ученые провели смелый эксперимент - испытали Виагру на кроликах. Эксперимент не заставил себя ждать... - досталось даже ученым!',
                                'Менделеев увидел во сне таблицу химических элементов, проснулся и подумал: Все, больше никакой химии! Перехожу на водку.',
                                'Приятно лежать на голом полу, если он - противоположный!',
                                'Как говорится, не при детях будет сказано... хотя им это тоже, было бы очень интересно.',
                                'Если, глядя утром в зеркало, вы видите опухшую, небритую физиономию с потухшим взглядом, значит, позавчера вы все-таки решили выпить 50 грамм для аппетита.',
                                'Если похмелье не лечить - оно проходит за один день. Если лечить - за десять...',
                                'Чеши отсюда! А теперь пониже!',
                                'Ехать с женой в Париж все равно, что ехать в Тулу со своим самоваром!',
                                'Все ли грибы можно есть? Все, но некоторые только один раз.',
                                'На любом бале-маскараде он выглядел легко узнаваемым: из-под полумаски торчала полуморда',
                                'Во сколько завтра вы не придете?',
                                'А ты давай, бухти мне, как космические корабли бороздят большой театр…',
                                'Профессор, конечно, лопух, но аппаратура при нёммм, при нёммм! Как слышно?',
                                'Вот что будет с тобой, если ты не перестанешь грызть ногти!(о Венере Милосской)',
                                'Корнет, вы женщина?',
                                'Тебя в детстве клоуны в автобусе забыли',
                                'Чтобы твоему ребёнку быть ближе к молоку, ему нужно спать в холодильнике!',
                                'Судя по вашему новому питомцу, мать-природа — та еще зараза',
                                'Если женщина молчит и не возражает, значит, она спит.',
                                'Я вам что, памятник, чтобы около меня целоваться?',
                                'Засунь себя под микроскоп и рассмотри, как следует',
                                'Предсказамус настрадал!',
                                'Не можешь довести женщину до оргазма — доведи хотя бы до дома!',
                                'Щас я все это запишу, а потом передам кляузу паладинам...',
                                'Девчонки, кто менял трансмиссию у «Камаза», отзовитесь!',
                                'Удивите печень - выпейте воду!',
                                '"Зря не качал интуицию!"- издевался Колобок, блокируя голову.
"Ну-ну" - отозвался маг, неспешно доставая из-за пазухи посох.',
                                'Пораскинь статами, если мозгами не получается!',
                                'Бывает, что все идет как по маслу - и только потом выясняется, что это был вазелин.',
                                'Убиваю принцесс, спасаю драконов.',
                                'Лучше семь раз хелиться,чем один раз слить!',
                                '«Чем черт не шутит! – подумал осадник и выпустил зверя».',
                                'Я вчера с такой девушкой познакомился… 90-60-90! - да ладно!! а выносливость скока!?',
                                'А вот завтра я расскажу вам о том, как с помощью фломастера и теста на беременность заставить своего парня нервничать',
                                'Если хотите покалечить, лучше дайте мне 20кр и я сам не появлюсь в БК сутки',
                                'Техничка, проработавшая в школе 20 лет, может попасть тряпкой в уворотчика критом на -1000.',
                                'Все шло как обычно..The server как обычно чем-то busy, а вы все Try again later пока administrator не вернется )))',
                                'продам сапоги болтные-рыбацкие!!!защита от магии воды по яйца, цена договорная в екр',
                                'Не все кто в будуаре писают сидя.',
                                '"И уносит меня... и уносит меня..." - напевая, спускались нубы в канализацию...',
                                'Плохому бойцу рандом мешает.',
                                'Не говори "гоп", пока ЦП не перескочишь!',
                                'Модер загнулся, Екр взлетел - всё получилось как ты не хотел...',
                                'Справедливость есть - она не может не есть!',
                                'Просим прощения, Общий Враг так и не появился, потому что у него тоже лагал вирт. © Администрация',
                                'Кто знает админов в реале передайте им подзатыльник от меня...За эту игру :)',
                                'Если тебя укусил вампир, то крикни ему в вдогонку я болею СПИДом.',
                                'Критами нас зовут не даром - ломаем нос одним ударом!',
                                'Обкастовать могу...матом.',
                                'Ты себя так ведёшь, как вроде бы у тебя абонимент в травмпункте ',
                                'Тёмные, светлые...Я различаю только сорта пива.',
                                'Относитесь к сексу с юмором. Не встал - похохотали и баиньки.',
                                'Если женщину долго не мучить, она начинает мучаться сама.',
                                'Продам кота. причина: грустит и много гадит',
'причина отказа: - Мульты: Мусорщик, Мироздатель и т.д. полный список мультов тут: ',
'ДА БУДЕТ КРИТ"- Сказал монтёр, и кромус тряпочкой протёр',
'Я в оффлайне. то что вы видите меня - глюк сервера',
'Не нервируйте меня! Мне скоро негде будет прятать трупы!',
'артники бк и ньюбы --будьте взаимо вежливыми,
как "КАМАЗ"с"ОКА".',
'Ищете женщину? Лучше ищите деньги. Женщина сама вас найдет.',
'Вы не смотрите, что я маленький и кашляю... Стукну вместе кашлять будем',
'Если вы неудачно напали на цп....не орите в приват! Я не 911',
'Регулярно делаю две вещи:Сплю с Бритни Спирс и вру',
'Бегают тут всякие с готиками, народ екровый пугают',
'чего то мне в реале сыкотно ',
'"legendarybk -это КВН,вот только весёлые здесь сидят в молчанках,а находчивые в блоке"-',
'Скоро там 21ый уровень ?',
'Прошу удалить моего мульта "-----" , так как хочу начать нового.',
'ловких и выносливых ловят и выносят!',
'а чего баловаться-то? положили молчанку-сняли молчанку-положили опять.... да киньте вы его в хаос',
'а если я куплю рубашку паладина я стану им ???',
'уважаемый палодин обьясните как женится в бк. женщина есть а что ещо нужно ???',
'Я занят!!!',
'Не делайте из мухи слона, не прокормите!',
'Успех – это когда по телику идёт новогоднее обращение Президента, а ты его не смотришь, а говоришь. ',
'Я сегодня просто прелесть какая гадость!!! ',
'Я умный, потому что очень скромный, поэтому такой красивый… ',
'У знакомых – кота зовут Кастрюлька, на мое удивленное – почему? – ответили – Так кастрированный…',
'Минздрав предупреждает: Алкоголь причина многих увлекательных приключений!',
'Если вам в дверь ломятся бандиты, попробуйте ломиться в нее с другой стороны. Это озадачит злоумышленников.',
'В ногах правды нет. Но между ними есть тот, кто все знает.',
'Мой сука персидский кот, устроил на моем сука персидском ковре, сука персидский залив!',
'Может показаться, что я ничего не делаю, но на клеточном уровне я очень занят!!!',
'У кого склонности к математике? Бери лопату и извлекай корни!',
'“Район у нас тихий… Все с глушителями ходят”.',
'Женщина любит ушами, мужчина – глазами, собака – носом и только кролик – тем, чем надо.',
'Пришел день “Х”, наступило время “Ч” и пришла полная “Ж”…',
'Лучше семь раз покрыться потом, чем один раз инеем.',
'Девушка не воробей залетит мало не покажется.',
'Что уставился, как баран на новую дубленку?',
'Драться надо - так беги!',
'Уходя, гасите всех.',
'Что бы мы без вас только не делали.',
'Экзаменов не будет - все билеты проданы.',
'Эх, бабье лето, какие бабы, такое и лето.',
'Белая, пушистая, хотя на самом деле седая и волосатая.',
'В конце концов, среди концов, найдешь конец ты наконец.',
'Вышла Василиса Прекрасная замуж за Ивана Дурака и стала Василиса Дурак.',
'Де юре, де факто, де било.',
'Замените мне масло, фильтры, колодки и девок в машине.',
'Замысел без умысла называется вымыслом.',
'Из овощей я больше всего люблю пельмени.',
'Из кустов раздавался девичий крик, постепенно переходящий в женский.',
'Какая же у Мери попенс.',
'Может тебе еще ключ от квартиры, где девки визжат?',
'Не хотите по-плохому, по-хорошему будет еще хуже.',
'Пива к обеду в меру бери. Пей понемногу - литра по три.',
'Советские курицы - самые стройные курицы в мире.',
'Таньки грязи не боятся.',
'Меня окружали милые, симпатичные люди, медленно сжимая кольцо... ',
'Девушка - не будите во мне кролика! ',
'Многие холостяки мечтают об умной, красивой, заботливой жене. А еще больше о ней мечтают женатые... ',
'Будете мимо проходить - проходите. ',
'Лучше колымить в Гондурасе, чем гондурасить на Колыме! ',
'"Экипаж прощается с вами, приятного полета!" ',
'Закрой окно! Да нет, не щелкай мышкой... ',
'Когда мне понадобится узнать Ваше мнение, я Вам его скажу! ',
'Самое пpиятное в детях - это пpоцесс их пpоизводства. ',
'Все хотят хоpошо пpовести вpемя, но его не пpоведешь. ',
'Вот у меня в саду гладиолухи растут! ',
'Тост: "за нас с вами, и за хрен с ними!" ',
'Hавешиваю фонари и гирлянды. (Майк Тайсон) ',
'Покyпаю работающие огнетyшители. (Змей Горыныч) ',
'Hа французско-украинских переговорах на высшем уровене подавали лягушачье сало. ',
'Пpивет yчастникам естественного отбоpа! ',
'18 лет бывает лишь раз в жизни! А 81 и того реже... ',
'Мимо прошла девушка с большим бюстом Аристотеля в руке. ',
'Опыт - это то, что получаешь, не получив того, что хотел. ',
'Не украшайте забор своей писаниной! Писайте, пожалуйста, где-нибудь подальше! ',
'Однажды Карлсон надел штаны наизнанку. Так появилась мясорубка. ',
'Продается компьютерная мышь, пробег 1500 км. ',
'Есть два способа командовать женщиной, но никто их не знает. ',
'Благодаря своей физической силе Н. Валуев собирает матрешки не по порядку. ',
'Уважаемые пассажиры, пожалуйста, вырвите из ваших паспортов две первые страницы, сверните их трубочкой и засуньте себе в задницу. А то прошлый раз самолет упал, и такая неразбериха получилась...',
'Пописай в сугроб, почувствуй себя лазером! ',
'Только сядешь поработать - обязательно кто-нибудь разбудит. ',
'В голове моей опилки - не беда! Потому что я блондинка! Да-да-да! ',
'Не будите меня. Я на работе... ',
'Ад был переполнен... и я вернулся!!! ',
'И создал Бог женщину!.. Существо получилось злобное, но симпатичное... ',
'Родители хотели, чтобы из меня вышел толк.... так и получилось.... толк вышел, бестолочь осталась! ',
'Весь день не спишь, всю ночь не ешь, конечно, устаешь...!!! ',
'Золушки исчезают в полночь, а принцы - ранним утром. ',
'"Девчонки, девчонки, мне муж электронный ящик сделал! Так что пишите на \'жена-собака-жизни-точка-нет\'" ',
'Вчера купила у вас морскую свинку. Она немного поплавала в аквариуме, потом легла на дно и уснула. Чем мне ее кормить, когда она проснется? ',
'Жили-были три поросенка: жадина них-них, наркоман нюх-нюх и грубиян нах-нах. ',
'Почему у бегемотов круглые ступни? - Чтобы легче было перепрыгивать с кувшинку на кувшинку. ',
'Вот что я тебе сейчас скажу - я объясняю на пальцах! Средний видишь? ',
'Меня не смутил ваш вопрос, я просто не знаю, как вам лучше врезать. ',
'Анальгин - очень эффективное противозачаточное. Способ применения - зажать таблетку между колен и не отпускать. ',
'Если вы пригласили девушку кормить рыбок, а аквариума у вас отродясь не было, откройте хотя бы банку шпрот. Как правило, покрошив туда немного хлеба, девушки начинают догадываться, зачем их позвали. ',
'Иногда мне кажется, что ума у меня не больше чем у обычного человека.',
'Не молчите на меня!',
'Ничто так не увеличивает размер женской груди как мужское воображение.',
'Питательные салаты из капусты - и на стол подать не стыдно, и сожрут - не жалко.',
'Геморрой стоит свеч.',
'Редкостная скотина ищет изощренную стерву для совместных дискуссий.',
'Канализация! - вот, что нас объединяет.',
'Девушка, да что ж вы так убиваетесь? Вы ж так никогда не убьетесь!',
'Внедрить - внедрили, а вывнедрить - забыли ',
'Женщина 73-х лет ищет место уборщицы. Интим не предлагать. ',
'Пишите помедленнее - я диктовать не успеваю ',
'Вчера сборная Аджарии по боксу отжарила сборную Румынии по художественной гимнастике.',
'Приходи ко мне за баню, а нето тебя забаню (см. Правила для начинающих пользователей форума)',
'7 чудес. Света. Тел. (XXX)-XXX-XXXX ',
'В пронизанном лучами восходящего солнца прозрачном утреннем лесу, на самом кончике нежного лепестка ландыша, переливаясь всеми цветами радуги словно крошечный бриллиантик, висела капелька мочи. ',
'Некоторые идут в бой с открытым забралом для большего устрашения.',
'Мне наверно сегодня ночью снилось что-то очень интересное, если я во сне наволочку с подушки снял...',
'Не знаю как у вас, но у меня нервные клетки не только восстанавливаются, но еще и пытаются отомстить виновным в их гибели...',
'Дорогая всемирная справедливость, сделай пожалуйста так,чтобы все придурки, которые выделены для этого мира, распределились равномерно, а не только мне!',
'Не будите во мне зверя! Он и так не высыпается !',
'Белые полоски на чёрных носках выполняют функции индикаторов загрязнения.',
'То ли вы меня подкупаете, то ли я напрасно жду...',
'Я хочу об этом покурить.',
'Я стёкл как трезвышко...У мя даже заплетык не языкается.',
'С криками: «Повезло вам, сволочи!» 153-летняя пенсионерка внесла последний взнос за ипотеку.',
'Крановщик с пятнадцатилетним стажем за пять минут обчистил автомат с игрушками.',
'Компас - очень вредный прибор: он всегда показывает на север, хотя большинство людей хотят на юг!',
'Господи, я хочу толстый кошелек и тонкую талию. И пожалуйста, неперепутай, как в прошлый раз.',
'Как иной раз хочется не хотеть того, чего хочется!',
'Китайская мудрость гласит: если вам нечего сказать, расскажите китайскую мудрость.',
'Материализация мысли работает по двойным стандартам. Сколько ни мечтай о хорошем - ничего не происходит. Но стоит только на секундочку задуматься о плохом...',
'Интересно, если я что-нибудь натворю, то я кто: творец или тварюга?',
'Мечта: поставить обогреватель в морозилку, включить и посмотреть: кто кого ?',
'А у нас в сельском клубе так: у кого мобила громче, тот и диджей.',
'Жуть стала лучше, жуть стала веселей!',
'Наши люди в булочную на самолетах не летают.',
'Запись в дневнике мазохиста: Пообещали набить морду... Уже два дня живу надеждой...',
'И откуда они только берутся? Я же никогда не покупал пустых бутылок!');
addchp($commas[rand(0,count($commas)-1)],"Комментатор");
}
}
}
}
die ("<script>top.CLR1();top.RefreshChat();</script>");
}
}
?>
</body>
</html>       
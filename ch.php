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
              if (align>2 && align<2.5) altext = "�����";
              if (align == 2.5) altext = "�����";
              if (align == 2.6) altext = "�����";
              if (align>2.6 && align<3) altext = "�����";
              if (align>3.00 && align<4) altext = "Ҹ���� ��������";
              if (align>1 && align<2 && klan !="FallenAngels") altext = "�������";
              if (align>1 && align<2 && klan =="FallenAngels") altext = "������ �����";
              if ( align == 0.98 ) altext ="Ҹ����";
              if ( align == 777 ) altext ="����� ���������";
              if ( align == 4 ) altext ="� �����";
              if ( align == 7 ) altext ="�������";
              if ( align == 0.99 ) altext ="�������";
              if (!name2) name2=name;
              align='<img src="<?=IMGBASE?>/i/align_'+align+'.gif" title="'+altext+'" width=13 height=15>';
            }
            if(battle>0){filter = 'style="filter:invert"';}else{filter = '';}
            if (klan.length>0) { klan='<A HREF="/claninf.php?'+klan+'" target=_blank><img src="<?=IMGBASE?>/i/klan/'+klan+'.gif" title="'+klan+'" width=24 height=15></A>';}
            document.write('<A HREF="javascript:top.AddToPrivate(\''+name+'\', top.CtrlPress)" target=refreshed><img src="<?=IMGBASE?>/i/lock.gif" '+filter+' title="������" width=20 height=15></A>'+align+'<a href="(\''+name+'\',true)"></a>'+klan+'<a href="javascript:top.AddTo(\''+name+'\')" target=refreshed>'+name2+'</a>['+level+']<a href="inf.php?'+id+'" target=_blank title="���. � '+name+'">'+'<IMG SRC="<?=IMGBASE?>/i/inf'+sex+'.gif" WIDTH=12 HEIGHT=11 BORDER=0 ALT="���. � '+name+'"></a>');
            if (slp>0) { document.write(' <IMG SRC="<?=IMGBASE?>/i/sleep2.gif" WIDTH=24 HEIGHT=15 BORDER=0 ALT="�������� �������� ��������">'); }
            if (trv>0) { document.write(' <IMG SRC="<?=IMGBASE?>/i/travma2.gif" WIDTH=24 HEIGHT=15 BORDER=0 ALT="������������">'); }
            //if(battle>0) document.write(' <a href=/logs.php?log='+battle+' target="_blank"><IMG border="0" SRC="<?=IMGBASE?>/i/battle.gif" WIDTH=16 HEIGHT=16 BORDER=0 ALT="�������� � ���"></a>');
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
<BR><INPUT TYPE=button value="��������" onclick="location='ch.php?online=<?=time()?>'">


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
    echo 'w(\'�����������\', 98,\'1.99\',\'\',\'18\',\'\',\'\',\'0\',\'\',\'�����������\',1);';
    //$vrag22 = mysql_fetch_array(mysql_query('select align,u.id,klan,level,login,o.date, (SELECT `id` FROM `effects` WHERE `type` = 2 AND `owner` = u.id LIMIT 1) as slp, (SELECT `id` FROM `effects` WHERE (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14) AND `owner` = u.id LIMIT 1) as trv,deal FROM `online` as o, `users` as u WHERE u.`id`=171 ;'));

  }

  if($user['room']==403){
    //$vrag22 = mysql_fetch_array(mysql_query('select align,u.id,klan,level,login,o.date, (SELECT `id` FROM `effects` WHERE `type` = 2 AND `owner` = u.id LIMIT 1) as slp, (SELECT `id` FROM `effects` WHERE (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14) AND `owner` = u.id LIMIT 1) as trv,deal FROM `online` as o, `users` as u WHERE u.`id`=24 ;'));
    //echo 'w(\'',$vrag22['login'],'\',',$vrag22['id'],',\'',$vrag22['align'],'\',\'',$vrag22['klan'],'\',\'',$vrag22['level'],'\',\'',$vrag22['slp'],'\',\'',$vrag22['trv'],'\',\'',(int)$row['deal'],'\',\'',$vrag_b22['battle'],'\');';
    echo 'w(\'����\',', 24,',\'', 9,'\',\'','','\',\'',8,'\',\'','','\',\'','','\',\'',0,'\',\'\',\'����\',1);';
  }
  
  if($user['room']==20 && vrag=="on"){
    //$vrag = mysql_fetch_array(mysql_query('select align,u.id,klan,level,login,o.date, (SELECT `id` FROM `effects` WHERE `type` = 2 AND `owner` = u.id LIMIT 1) as slp, (SELECT `id` FROM `effects` WHERE (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14) AND `owner` = u.id LIMIT 1) as trv,deal FROM `online` as o, `users` as u WHERE u.`id`=99 ;'));
    $vrag_b = mysql_fetch_array(mysql_query("SELECT `battle` FROM `bots` WHERE  `prototype` = 99 LIMIT 1 ;"));

    //echo 'w(\'',$vrag['login'],'\',',$vrag['id'],',\'',$vrag['align'],'\',\'',$vrag['klan'],'\',\'',$vrag['level'],'\',\'',$vrag['slp'],'\',\'',$vrag['trv'],'\',\'',(int)$row['deal'],'\',\'',$vrag_b['battle'],'\');';
    echo 'w(\'����� ����\', 99,\'4\',\'\',\'15\',\'\',\'\',\'0\',\''.$vrag_b["battle"].'\',\'����� ����\',1);';
  }

  while($row=mysql_fetch_array($data)) {
    //if ($row['slp']=='NULL')  { $row['slp'] = 0; }
    if ($row['invis']>0 && $row['id']==$_SESSION['uid'])  { $row['login2'] = $row['login']."</a> (���������)"; }
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
    <SCRIPT>document.write('<INPUT TYPE=checkbox onclick="if(this.checked == true) { top.OnlineStop = false; } else { top.OnlineStop=true; }" '+(top.OnlineStop?'':'checked')+'> ��������� ���������.')
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
              $v=str_replace("private ", "private [��������] ", $v);
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
                        if (strlen($res)<3 || strlen($res)>25 || !ereg("^[�a-zA-Z�-��-�0-9-][�a-zA-Z�-��-�0-9_ -]+[a-zA-Z�-��-�0-9�-]$",$res)  || preg_match("/__/",$res) || preg_match("/--/",$res) || preg_match("/  /",$res) || preg_match("/(.)\\1\\1\\1/",$res)){
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
                mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".$user['id']."','�������� ��������',".(time()+1800).",2);");
                $_GET["text"]=str_replace("private","�rivate", $_GET["text"]);
                reportadms("<br><b>$user[login]</b>: $_GET[text]", "�����������");
            }
            addch("<img src=i/magic/sleep.gif> ����������� ������� �������� �������� �� &quot;{$user['login']}&quot;, ������ 30 ���. �������: ���.");
            //$user = mysql_fetch_array(mysql_query("SELECT `id` FROM `users` WHERE `login` = '{$_POST['target']}' LIMIT 1;"));
            //mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".$user['id']."','�������� ��������',".(time()+1800).",2);");
          } elseif ($bad) {
            $f=fopen("logs/autosleep.txt","ab");
            fwrite($f, "$user[login]: $_GET[text]\r\n");
            fclose($f);
            mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".$user['id']."','�������� ��������',".(time()+900).",2);");
            $_GET["text"]=str_replace("private","�rivate", $_GET["text"]);
            addchp("<font color=\"Black\">private [����] <br><b>$user[login]</b>: $_GET[text]</font>", "�����������");
            addch("<img src=i/magic/sleep.gif> ����������� ������� �������� �������� �� &quot;{$user['login']}&quot;, ������ 15 ���. �������: ���.");
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
            $_GET['text'] = eregi_replace('o(.)*l(.)*d(.)*c(.)*o(.)*m(.)*b(.)*a(.)*t(.)*s','<b><font color=red> � � ���-���!</font></b>',$_GET['text']);
            $_GET['text'] = eregi_replace('a(.)*r(.)*d(.)*a(.)*n(.)*i(.)*y(.)*a','<b><font color=red> � � ���-���!</font></b>',$_GET['text']);
            $_GET['text'] = eregi_replace('l(.)*f(.)*i(.)*g(.)*h(.)*t','<b><font color=red> � � ���-���!</font></b>',$_GET['text']);
            $_GET['text'] = eregi_replace('a(.)*r(.)*d(.)*a(.)*n(.)*u(.)*y(.)*a','<b><font color=red> � � ���-���!</font></b>',$_GET['text']);
            $_GET['text'] = eregi_replace('o(.)*l(.)*d(.)*b(.)*k','<b><font color=red> � � ���-���!</font></b>',$_GET['text']);
            $_GET['text'] = eregi_replace('n(.)*e(.)*w(.)*-(.)*b(.)*k','<b><font color=red> � � ���-���!</font></b>',$_GET['text']);
            $_GET['text'] = eregi_replace('a(.)*r(.)*d(.)*a(.)*n(.)*u(.)*y(.)*a','<b><font color=red> � � ���-���!</font></b>',$_GET['text']);
            $_GET['text'] = eregi_replace('l(.)*a(.)*s(.)*t(.)*w(.)*o(.)*r(.)*l(.)*d(.)*s','<b><font color=red> � � ���-���!</font></b>',$_GET['text']);
            $_GET['text'] = eregi_replace('t(.)*e(.)*k(.)*k(.)*e(.)*n','<b><font color=red> � � ���-���!</font></b>',$_GET['text']);
            $_GET['text'] = eregi_replace('n(.)*e(.)*w(.)*a(.)*b(.)*k','<b><font color=red> � � ���-���!</font></b>',$_GET['text']);

}


include 'smiles.php';
if($user['invis']=='1') {
$tme=mqfa1("select time from effects where owner='$user[id]' and type='1022'");
$user['login'] = '</a><b><i>��������� '.substr($tme,strlen($tme)-4).'</i></b>';
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
$fp = fopen (CHATROOT."chat.txt","a"); //��������
flock ($fp,LOCK_EX); //���������� �����
fputs($fp ,":[".time ()."]:[{$user['login']}]:[<font ".($user["level"]<4?"m":"")." color=\"".(($user['color'])?$user['color']:"#000000")."\">".($_GET['text'])."</font>]:[".$user['room']."]\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose ($fp);
}
}
if (strpos($_GET['text'],"to [�����������]" ) !== FALSE) {
if (strpos($_GET['text'],"to [�����������] �������" ) !== FALSE) {
$commas = array('������� ����� ������� ������, �� �� ������ ������ ����������. &copy;������',
'������ ����� �����. ���������, ��������� ����: - ���, �������� ��������! - �� ������� ��� � �������? &copy;������',
'������ �������� �� ����������� ������� � ���� � �������� �� ���� . ����� ��� ����������: � ���, ������? � ��, ��� ������� ������ ��������. � ��� �� �� ��� ��������-�� �������? � � �� �-��? ������ ������ �� ����������� � ����� ��������... &copy;����-��������',
'����� ������� � ����� ������. ����� ������, ����� � ������� ������ ���� ������ �������, ���� ��� ���������. ����� ������� ������ ������ �� �����: - �������! - �� ������� �����! &copy;Arkada',
'"������ �� �����" - ������ ���� ������� ��������� ������ ��� ���� ��������',
'���� ���������� 16.08.03 12:00, ����� ����� ����� MIB � ����� ��������� ������� ����� ���� �����. 12:01 ��� ��������. ������ �� ��������',
'����: ����� �������� �� ����!!! Demian Black: ������������ ���� ��� ����� �� ������������ �������. &copy;XyliGUNka',
'� �������� �� ������� ������ ������� ��������� ������ &copy;�������',
'� ����� � ����� �������� ������������� 90-60-90! - �� �����!! � ������������ �������? &copy;Akrobat',
'-�� �� �����!!! ���� � �������, ������ �������! -��� � � ��� � ����! -� ���, ��� ��� ��� �����?! -����� ��?! � ����-�� ������� �� ��� ������� ��������?!! &copy;Arkada',
'-�������, Legendarybk - ������ ����? ���������, ������ ����� ����������.. &copy;������',
'���� ������� ������� ������������. ����������� ���� � ��������� ������. &copy;������',
'����. �����. ����� ���� ���� �� ����������� �������. ������ ��������� ����. "��� merlin", - ������� ����� ����. "��, ��� �", - ������� merlin. &copy;������',
'������� ���� �������, merlin ������� �������� ������� ����. "�������" - ������� merlin. &copy;������',
'�������, ������, ������� ���, � ���� �����! &copy;Thomas Malton',
'���� ������������, ����� <�������� ��������> ��������������� ������������ � ����!');
addchp($commas[rand(0,count($commas)-1)],"�����������");} else {
$commas = array('��� ����� �� ����� � ������� �������� ������������...',
'��� ���������� ������ �� � ���?',
'�������!',
'��� �����, ����������� - ����!',
'� ������� ��������, �� ���� �������������� ���� ���!',
'������!',
'���������� �� ��������!',
'�������: - ������� ��������, ������ ���� ���������� �� ����������� ������� ������������? - ��� ��� �� ��� ���!!',
                                '��� �����!',
                                '������ ������� (� ������)',
                                '���...',
                                '����� � ��� �������� ���������.',
                                '��� ��� �����������? �� ��� �???',
                                '���� ��...',
                                '��� �����!',
                                '���� ������������, ����� <�������� ��������> ��������������� ������������ � ����!',
                                '(��������� �����������) ��� �����???',
                                '�� �������� �������',
                                '���! ������ �� ��� ������!',
                                '�-�-�...',
                                '� � ��� ��� ��������� �������?',
                                '� ����� �����, ��� ����� 90�60�90. ���������, ��� ��� 486 000.',
                                '����� ���� �������� ����, ���� ������?',
                                '������ ������!',
                                '���� ��������� �������� <�������� ��������>',
                                '��� ���� ��� � ��������� ���� �������� ����� ���������.',
                                '�� � ��� ��������������� �����?',
                                '����� ������. ����� ������. ����� ������. ����� ������. �����, ������...',
                                '� �����������! � �� ���???',
                                '������� �� � �������� �� ������� ������. ����� �� ����� - 18 ������.',
                                '�������, ������� �������, � ��������� ��� ����. - ����, ������, - ������� ����.',
                                '���� ������ �� ������� ����� ����, ��� ����� ���������� ������� � ����� ����. ������ �����: ������� ��������!',
                                '������� � ������ ���������� ������������ ������� ��������� � ���������. ������ ���-�� �� ���������.',
                                '��� �-�� �������������? �����������',
                                '� �� ������ ��� �������, - ����� ���� ������ ������ ����������, ����� ���� ��� �������� � ������ ���� ������ � ����.',
                                '������� ������ ���� � ����� ������ ����� ��������� ��� ������ ��������.',
                                '������ ������ � �������� ��������� �� ��� �������� ������, ��� ������ � �������� ����������.',
                                '�������-�� �� ���������� �� ���������� ��������, - ������ ��������� ���������, ������ �� �������� ���������.',
                                '��� �� ���������� ��������, - ������ ����� ���, ������� ����� �������.',
                                '��������� ������� �������� ������������ �������. ���: ������� �� � ���',
                                '� ������ ���� ���� ���������� "� �������"? - ������� ������� ��������� �������.',
                                '8 ����� ������ � "���������" ������� ������������� �������� ����.',
                                '����, �� ������ �� �������� �������, � �����-�� ������� �������� - ������� ��� ���� �����, ����� ������� �������, � ����� � ������ �����. ��� ���� ������� ��� � ��� ���� �������!',
                                '����� ��������, ��� 20% ����� ������ 80% ������. ������� ����������, ��� 80% ����� �������, ��� ��� ������ � ��� 20%',
                                '� ������, ����� � ����� ����� ���������� �������� � �����? ��� ��� ������ ������.',
                                '� ����������� ����� �� ���� �������� �������� ��� ������ ������� �� ����� ���.',
                                '"���� �������� ���������� ������ ������������, ���� �� ��������� �� ���� 60 ��/���, ������ �������� ����� ����������, �� ��������� ���������� �� ������, ��������� ������� �� �������� ����������, ���������� ��������� �� �������� � ������ �� �������� �� ������ ������ ���, ������, ������ �����, �� ������ ����".',
                                '��������� �� ������',
                                '������� ����� �����, � ������� - �������. ����������-����������� ���� ����� 153. ������� ������� ������� � ���.',
                                '���� ����������� ������� - ��� ����� ����� ��� ��� ������� ������� ���� � ������ �����.',
                                '�������, ������ 5 ����������� ��������. �������, ������ 5 ����������� ��������. 3 �������� � 2 �����',
                                '���� �������! - ������ ����, ������ ������ � ������ � ����� � ����.',
                                '������� ������ ����� ������ �����: "����, ���� ����, ������ ������. ������ - ����".',
                                '����� ������� ������� ���������� ����, ������� �� ��������� ������ ����� ����� 100 ��������.',
                                '����� ������� ������� ���������� ����, ������� �� ��������� ������ ����� ����� 100 ��������.',
                                '�� ����� ��� ��� ����� ������ �����: ��� �������, ��� �������... � ������ �������� ���� ���� �������: 255.255.255.0',
                                '�������� - ��� �������, ������� �� �������, ����� ���-�� ���������...',
                                '"���� �����..." (�������������� ��������� ���������� ����������).',
                                '������� �� ������, �������� �� ������, ������ �� ������, ��� �� ������, ��������� �� ������... ��� ����� �� ������! ����� �� ��� � ���, ������...',
                                '������ ������� ������ ����������� - �������� ������ �� ��������. ����������� �� �������� ���� �����... - ��������� ���� ������!',
                                '��������� ������ �� ��� ������� ���������� ���������, ��������� � �������: ���, ������ ������� �����! �������� �� �����.',
                                '������� ������ �� ����� ����, ���� �� - ���������������!',
                                '��� ���������, �� ��� ����� ����� �������... ���� �� ��� ����, ���� �� ����� ���������.',
                                '����, ����� ����� � �������, �� ������ �������, �������� ���������� � �������� ��������, ������, ��������� �� ���-���� ������ ������ 50 ����� ��� ��������.',
                                '���� �������� �� ������ - ��� �������� �� ���� ����. ���� ������ - �� ������...',
                                '���� ������! � ������ ������!',
                                '����� � ����� � ����� ��� �����, ��� ����� � ���� �� ����� ���������!',
                                '��� �� ����� ����� ����? ���, �� ��������� ������ ���� ���.',
                                '�� ����� ����-��������� �� �������� ����� ����������: ��-��� ��������� ������� ���������',
                                '�� ������� ������ �� �� �������?',
                                '� �� �����, ����� ���, ��� ����������� ������� �������� ������� ������',
                                '���������, �������, �����, �� ���������� ��� ����, ��� ����! ��� ������?',
                                '��� ��� ����� � �����, ���� �� �� ����������� ������ �����!(� ������ ���������)',
                                '������, �� �������?',
                                '���� � ������� ������ � �������� ������',
                                '����� ������ ������ ���� ����� � ������, ��� ����� ����� � ������������!',
                                '���� �� ������ ������ �������, ����-������� � �� ��� ������',
                                '���� ������� ������ � �� ���������, ������, ��� ����.',
                                '� ��� ���, ��������, ����� ����� ���� ����������?',
                                '������ ���� ��� ��������� � ���������, ��� �������',
                                '������������ ���������!',
                                '�� ������ ������� ������� �� ������� � ������ ���� �� �� ����!',
                                '��� � ��� ��� ������, � ����� ������� ������ ���������...',
                                '��������, ��� ����� ����������� � �������, ����������!',
                                '������� ������ - ������� ����!',
                                '"��� �� ����� ��������!"- ��������� �������, �������� ������.
"��-��" - ��������� ���, �������� �������� ��-�� ������ �����.',
                                '��������� �������, ���� ������� �� ����������!',
                                '������, ��� ��� ���� ��� �� ����� - � ������ ����� ����������, ��� ��� ��� �������.',
                                '������ ��������, ������ ��������.',
                                '����� ���� ��� ��������,��� ���� ��� �����!',
                                '���� ���� �� �����! � ������� ������� � �������� ������.',
                                '� ����� � ����� �������� ������������� 90-60-90! - �� �����!! � ������������ �����!?',
                                '� ��� ������ � �������� ��� � ���, ��� � ������� ���������� � ����� �� ������������ ��������� ������ ����� ����������',
                                '���� ������ ����������, ����� ����� ��� 20�� � � ��� �� �������� � �� �����',
                                '��������, ������������� � ����� 20 ���, ����� ������� ������� � ���������� ������ �� -1000.',
                                '��� ��� ��� ������..The server ��� ������ ���-�� busy, � �� ��� Try again later ���� administrator �� �������� )))',
                                '������ ������ �������-��������!!!������ �� ����� ���� �� ����, ���� ���������� � ���',
                                '�� ��� ��� � ������� ������ ����.',
                                '"� ������ ����... � ������ ����..." - �������, ���������� ���� � �����������...',
                                '������� ����� ������ ������.',
                                '�� ������ "���", ���� �� �� �����������!',
                                '����� ��������, ��� ������� - �� ���������� ��� �� �� �����...',
                                '�������������� ���� - ��� �� ����� �� ����!',
                                '������ ��������, ����� ���� ��� � �� ��������, ������ ��� � ���� ���� ����� ����. � �������������',
                                '��� ����� ������� � ����� ��������� �� ������������ �� ����...�� ��� ���� :)',
                                '���� ���� ������ ������, �� ������ ��� � �������� � ����� ������.',
                                '������� ��� ����� �� ����� - ������ ��� ����� ������!',
                                '����������� ����...�����.',
                                '�� ���� ��� �����, ��� ����� �� � ���� ��������� � ����������� ',
                                'Ҹ����, �������...� �������� ������ ����� ����.',
                                '���������� � ����� � ������. �� ����� - ���������� � �������.',
                                '���� ������� ����� �� ������, ��� �������� �������� ����.',
                                '������ ����. �������: ������� � ����� �����',
'������� ������: - ������: ��������, ����������� � �.�. ������ ������ ������� ���: ',
'�� ����� ����"- ������ �����, � ������ ��������� �����',
'� � ��������. �� ��� �� ������ ���� - ���� �������',
'�� ���������� ����! ��� ����� ����� ����� ������� �����!',
'������� �� � ����� --������ ������ ���������,
��� "�����"�"���".',
'����� �������? ����� ����� ������. ������� ���� ��� ������.',
'�� �� ��������, ��� � ��������� � ������... ������ ������ ������� �����',
'���� �� �������� ������ �� ��....�� ����� � ������! � �� 911',
'��������� ����� ��� ����:���� � ������ ����� � ���',
'������ ��� ������ � ��������, ����� ������� ������',
'���� �� ��� � ����� ������� ',
'"legendarybk -��� ���,��� ������ ������ ����� ����� � ���������,� ���������� � �����"-',
'����� ��� 21�� ������� ?',
'����� ������� ����� ������ "-----" , ��� ��� ���� ������ ������.',
'������ � ���������� ����� � �������!',
'� ���� ����������-��? �������� ��������-����� ��������-�������� �����.... �� ������ �� ��� � ����',
'� ���� � ����� ������� �������� � ����� �� ???',
'��������� ������� ��������� ��� ������� � ��. ������� ���� � ��� ��� ����� ???',
'� �����!!!',
'�� ������� �� ���� �����, �� ����������!',
'����� � ��� ����� �� ������ ��� ���������� ��������� ����������, � �� ��� �� ��������, � ��������. ',
'� ������� ������ �������� ����� �������!!! ',
'� �����, ������ ��� ����� ��������, ������� ����� �������� ',
'� �������� � ���� ����� ����������, �� ��� ���������� � ������? � �������� � ��� ��������������',
'�������� �������������: �������� ������� ������ ������������� �����������!',
'���� ��� � ����� ������� �������, ���������� �������� � ��� � ������ �������. ��� �������� ���������������.',
'� ����� ������ ���. �� ����� ���� ���� ���, ��� ��� �����.',
'��� ���� ���������� ���, ������� �� ���� ���� ���������� �����, ���� ���������� �����!',
'����� ����������, ��� � ������ �� �����, �� �� ��������� ������ � ����� �����!!!',
'� ���� ���������� � ����������? ���� ������ � �������� �����!',
'������ � ��� ����� ��� � ����������� �����.',
'������� ����� �����, ������� � �������, ������ � ����� � ������ ������ � ���, ��� ����.',
'������ ���� �Ք, ��������� ����� �ה � ������ ������ �Ɣ�',
'����� ���� ��� ��������� �����, ��� ���� ��� �����.',
'������� �� ������� ������� ���� �� ���������.',
'��� ���������, ��� ����� �� ����� ��������?',
'������� ���� - ��� ����!',
'�����, ������ ����.',
'��� �� �� ��� ��� ������ �� ������.',
'��������� �� ����� - ��� ������ �������.',
'��, ����� ����, ����� ����, ����� � ����.',
'�����, ��������, ���� �� ����� ���� ����� � ���������.',
'� ����� ������, ����� ������, ������� ����� �� �������.',
'����� �������� ���������� ����� �� ����� ������ � ����� �������� �����.',
'�� ���, �� �����, �� ����.',
'�������� ��� �����, �������, ������� � ����� � ������.',
'������� ��� ������ ���������� ��������.',
'�� ������ � ������ ����� ����� ��������.',
'�� ������ ���������� ������� ����, ���������� ����������� � �������.',
'����� �� � ���� ������.',
'����� ���� ��� ���� �� ��������, ��� ����� ������?',
'�� ������ ��-�������, ��-�������� ����� ��� ����.',
'���� � ����� � ���� ����. ��� ��������� - ����� �� ���.',
'��������� ������ - ����� �������� ������ � ����.',
'������ ����� �� ������.',
'���� �������� �����, ����������� ����, �������� ������ ������... ',
'������� - �� ������ �� ��� �������! ',
'������ ��������� ������� �� �����, ��������, ���������� ����. � ��� ������ � ��� ������� �������... ',
'������ ���� ��������� - ���������. ',
'����� �������� � ���������, ��� ����������� �� ������! ',
'"������ ��������� � ����, ��������� ������!" ',
'������ ����! �� ���, �� ������ ������... ',
'����� ��� ����������� ������ ���� ������, � ��� ��� �����! ',
'����� �p������ � ����� - ��� �p����� �� �p����������. ',
'��� ����� ��p��� �p������ �p���, �� ��� �� �p�������. ',
'��� � ���� � ���� ���������� ������! ',
'����: "�� ��� � ����, � �� ���� � ����!" ',
'H�������� ������ � ��������. (���� ������) ',
'���y��� ���������� �����y������. (���� �������) ',
'H� ����������-���������� ����������� �� ������ ������� �������� ��������� ����. ',
'�p���� y��������� ������������� ����p�! ',
'18 ��� ������ ���� ��� � �����! � 81 � ���� ����... ',
'���� ������ ������� � ������� ������ ���������� � ����. ',
'���� - ��� ��, ��� ���������, �� ������� ����, ��� �����. ',
'�� ��������� ����� ����� ���������! �������, ����������, ���-������ ��������! ',
'������� ������� ����� ����� ���������. ��� ��������� ���������. ',
'��������� ������������ ����, ������ 1500 ��. ',
'���� ��� ������� ����������� ��������, �� ����� �� �� �����. ',
'��������� ����� ���������� ���� �. ������ �������� �������� �� �� �������. ',
'��������� ���������, ����������, ������� �� ����� ��������� ��� ������ ��������, �������� �� ��������� � �������� ���� � �������. � �� ������� ��� ������� ����, � ����� ����������� ����������...',
'������� � ������, ���������� ���� �������! ',
'������ ������ ���������� - ����������� ���-������ ��������. ',
'� ������ ���� ������ - �� ����! ������ ��� � ���������! ��-��-��! ',
'�� ������ ����. � �� ������... ',
'�� ��� ����������... � � ��������!!! ',
'� ������ ��� �������!.. �������� ���������� �������, �� �����������... ',
'�������� ������, ����� �� ���� ����� ����.... ��� � ����������.... ���� �����, ��������� ��������! ',
'���� ���� �� �����, ��� ���� �� ���, �������, �������...!!! ',
'������� �������� � �������, � ������ - ������ �����. ',
'"��������, ��������, ��� ��� ����������� ���� ������! ��� ��� ������ �� \'����-������-�����-�����-���\'" ',
'����� ������ � ��� ������� ������. ��� ������� ��������� � ���������, ����� ����� �� ��� � ������. ��� ��� �� �������, ����� ��� ���������? ',
'����-���� ��� ���������: ������ ���-���, �������� ���-��� � ������� ���-���. ',
'������ � ��������� ������� ������? - ����� ����� ���� ������������� � �������� �� ��������. ',
'��� ��� � ���� ������ ����� - � �������� �� �������! ������� ������? ',
'���� �� ������ ��� ������, � ������ �� ����, ��� ��� ����� �������. ',
'�������� - ����� ����������� �����������������. ������ ���������� - ������ �������� ����� ����� � �� ���������. ',
'���� �� ���������� ������� ������� �����, � ��������� � ��� �������� �� ����, �������� ���� �� ����� �����. ��� �������, �������� ���� ������� �����, ������� �������� ������������, ����� �� �������. ',
'������ ��� �������, ��� ��� � ���� �� ������ ��� � �������� ��������.',
'�� ������� �� ����!',
'����� ��� �� ����������� ������ ������� ����� ��� ������� �����������.',
'����������� ������ �� ������� - � �� ���� ������ �� ������, � ������ - �� �����.',
'�������� ����� ����.',
'���������� ������� ���� ���������� ������ ��� ���������� ���������.',
'�����������! - ���, ��� ��� ����������.',
'�������, �� ��� � �� ��� ����������? �� � ��� ������� �� ��������!',
'�������� - ��������, � ���������� - ������ ',
'������� 73-� ��� ���� ����� ��������. ����� �� ����������. ',
'������ ����������� - � ��������� �� ������� ',
'����� ������� ������� �� ����� �������� ������� ������� �� �������������� ����������.',
'������� �� ��� �� ����, � ���� ���� ������ (��. ������� ��� ���������� ������������� ������)',
'7 �����. �����. ���. (XXX)-XXX-XXXX ',
'� ����������� ������ ����������� ������ ���������� �������� ����, �� ����� ������� ������� �������� �������, ����������� ����� ������� ������ ������ ��������� �����������, ������ �������� ����. ',
'��������� ���� � ��� � �������� �������� ��� �������� ����������.',
'��� ������� ������� ����� ������� ���-�� ����� ����������, ���� � �� ��� ��������� � ������� ����...',
'�� ���� ��� � ���, �� � ���� ������� ������ �� ������ �����������������, �� ��� � �������� ��������� �������� � �� ������...',
'������� ��������� ��������������, ������ ���������� ���,����� ��� ��������, ������� �������� ��� ����� ����, �������������� ����������, � �� ������ ���!',
'�� ������ �� ��� �����! �� � ��� �� ���������� !',
'����� ������� �� ������ ������ ��������� ������� ����������� �����������.',
'�� �� �� ���� ����������, �� �� � �������� ���...',
'� ���� �� ���� ��������.',
'� ���� ��� ���������...� �� ���� �������� �� ���������.',
'� �������: �������� ���, �������!� 153-������ ����������� ������ ��������� ����� �� �������.',
'��������� � ���������������� ������ �� ���� ����� �������� ������� � ���������.',
'������ - ����� ������� ������: �� ������ ���������� �� �����, ���� ����������� ����� ����� �� ��!',
'�������, � ���� ������� ������� � ������ �����. � ����������, �����������, ��� � ������� ���.',
'��� ���� ��� ������� �� ������ ����, ���� �������!',
'��������� �������� ������: ���� ��� ������ �������, ���������� ��������� ��������.',
'�������������� ����� �������� �� ������� ����������. ������� �� ������ � ������� - ������ �� ����������. �� ����� ������ �� ���������� ���������� � ������...',
'���������, ���� � ���-������ �������, �� � ���: ������ ��� �������?',
'�����: ��������� ������������ � ���������, �������� � ����������: ��� ���� ?',
'� � ��� � �������� ����� ���: � ���� ������ ������, ��� � ������.',
'���� ����� �����, ���� ����� �������!',
'���� ���� � �������� �� ��������� �� ������.',
'������ � �������� ���������: ��������� ������ �����... ��� ��� ��� ���� ��������...',
'� ������ ��� ������ �������? � �� ������� �� ������� ������ �������!');
addchp($commas[rand(0,count($commas)-1)],"�����������");
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
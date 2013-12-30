<?php
  
    session_start();

    $stat_nm=array("1"=>"Сила","2"=>"Ловкость","3"=>"Интуиция","4"=>"Выносливость","5"=>"Интеллект","6"=>"Мудрость","7"=>"Духовность");
    $stat_nmdb=array("1"=>"sila","2"=>"lovk","3"=>"inta","4"=>"vinos","5"=>"intel","6"=>"mudra","7"=>"spirit");
    $stat_nmto=array("1"=>"в силу","2"=>"в ловкость","3"=>"в интуицию","4"=>"в выносливость","5"=>"в интеллект","6"=>"в мудрость","7"=>"в духовность");
    $trv="";
    if ($_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
    if (!$user['login']) header("Location: index.php");
//  if ($user['level']<4) { header("Location: main.php");  die(); }
//  if ($user['room'] != 43) { header("Location: main.php");  die(); }
    if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }
    include "functions.php";
    getadditdata($user);
    if (in_array($user["id"],$testusers)) define("ALLFREE",1);
    else define("ALLFREE",0);
    if ($user["room"]!=43) {
      header("location: main.php");
      die;
    }

//  if (!($user['align'] > 2 AND $user['align'] < 3)) die();

?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<SCRIPT LANGUAGE="JavaScript">
</SCRIPT>
</HEAD>

<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=#e0e0e0>
<div style='color:#8F0000; font-weight:bold; font-size:16px; text-align:center; float:left;'>Комната Знахаря</div><div style='float:right; padding-right:6px;'><input type=button value='Вернуться' OnClick="location.href='main.php?got=1&room8=1'"></div><div style='clear:both;'></div><br>
<?
    if ($_GET["healaddict"]) {
      $_GET["healaddict"]=(int)$_GET["healaddict"];
      $rec=mqfa("select * from effects where owner='$user[id]' and (type=".ADDICTIONEFFECT." or type=".HPADDICTIONEFFECT." or type=".MANAADDICTIONEFFECT.") and id='$_GET[healaddict]'");
      if ($rec) {
        if ($user["money"]<0 && !ALLFREE) {
          echo "<b><font color=red>У вас недостаточно денег.</font></b><br><br>";
        } else {
          remaddiction($user["id"], $rec);
          mq("delete from effects where id='$rec[id]'");
          if (!ALLFREE) {
            mq("update users set money=money-0 where id='$user[id]'");
            $user["money"]-=0;
          }
          echo "<b>Всё прошло успешно</b><br><br>";
          settravma($user["id"],20,rand(300,600),1,1);
        }
      }
    }
    if (@$_GET["remeffect"]) {
      $_GET["remeffect"]=(int)$_GET["remeffect"];
      $t=mqfa1("select type from effects where owner='$user[id]' and id='$_GET[remeffect]'");
      if ($t==187 || $t==188 || $t==189 || $t==49) {
        if ($user["money"]<5 && !ALLFREE) {
          echo "<b><font color=red>У вас недостаточно денег.</font></b><br><br>";
        } else {
          if (!ALLFREE) {
            $user["money"]-=0;
            mq("update users set money=money-0 where id='$user[id]'");
          }
          mq("update effects set isp=1, time=1 where id='$_GET[remeffect]'");
          echo "<b>Всё прошло успешно</b><br><br>";
        }
      }
    }

    if ($_GET["clearels"]) {
      if ($user["money"]<0) {
        echo "<b><font color=red>У Вас недостаточно денег.</font></b>";
      } else {
        $r=mq("select * from effects where owner='$_SESSION[uid]' AND (type=188 or type=187) and (sila>0 or lovk>0 or inta>0 or mudra>0 or vinos>0 or intel>0)");
        if (mysql_num_rows($r)>0) {
          while ($rec=mysql_fetch_assoc($r)) {
            mq("delete from effects WHERE `id`='$rec[id]'");
            mq("update users set sila=sila-$rec[sila], lovk=lovk-$rec[lovk], inta=inta-$rec[inta], vinos=vinos-$rec[vinos], intel=intel-$rec[intel], mudra=mudra-$rec[mudra] where id='$_SESSION[uid]'");
          }
          if (!ALLFREE) mq("update users set money=money-0 where id='$_SESSION[uid]'");
          echo "<b>Действие эликсиров и заклятий снято успешно.</b><br><br>";
        }
      }
    }
    $d = mysql_fetch_array(mysql_query("SELECT sum(`massa`) FROM `inventory` WHERE `owner` = '{$user['id']}' AND `dressed` = 0 AND `setsale` = 0 ; "));
    if($d[0] > get_meshok()) {
        echo "<font color=red><b>У вас переполнен рюкзак, вы не можете передвигаться...</b></font><br>";
    }
    if (@$_GET["warning"]) echo "<font color=red><b>$_GET[warning]</b></font><br><br>";
    ?>
<b><i>Запахи трав наполняют помещение, непонятные и пугающие предметы скрываются в пляшущих тенях...<br>
Говорят, здесь можно изменить свою судьбу. Стать кем-то иным... кем раньше был лишь в мечтах...</b></i><br><br>

Все имеет цену. Но не все можно купить. Помните - некоторые шансы даются лишь раз в жизни...<br>
<?

    $owntravma = mqfa("SELECT `type` FROM `effects` WHERE `owner` =$user[id] AND (type=12 OR type=13 OR type=11 OR type=14)");
    if ($owntravma) { echo "<br><font color=red><b>Вы не можете воспользоваться услугами знахаря имея травму!</b></font>"; die();}
    //elseif($owntravma){echo "<br><font color=red><b>Вы не можете воспользоваться услугами знахаря находясь под действием эликсира или заклятия, которое влияет на первичные параметры!</b></font><br><br>
    //Знахарь может снять действие за 0 кр. <a href=\"znahar.php?clearels=1\">Снять действие эликсира/заклятия</a>."; die();}

if ($_POST['undr']=='1') undressall((int)$_SESSION['uid']);
$s=mysql_fetch_row(mysql_query("SELECT count(id) FROM inventory WHERE dressed!=0 and type>0 AND owner=".(int)$_SESSION['uid']));
//if ((int)$s[0]>0) { echo "<form method=post>Перед входом в комнату знахарь требует полного очищения! <input type=hidden value=1 name='undr'><input type=submit value='Раздеться'></form>"; die();}

if (@(int)$_POST['move_ab']>0) {
    if (($stat_nmdb[(int)$_POST['move_ab']]=='sila' && $user['b_sila']<4) || ($stat_nmdb[(int)$_POST['move_ab']]=='lovk' && $user['b_lovk']<4) || ($stat_nmdb[(int)$_POST['move_ab']]=='inta' && $user['b_inta']<4) || ($stat_nmdb[(int)$_POST['move_ab']]=='vinos' && $user['b_vinos']<(4+$user['level']))) echo "<font color=red><b>Невозможно перераспределить статы ниже минимального уровня.</b></font>";
    else {
    if (@(int)$_POST['move_ab_top']>0) {
        if (ALLFREE) $money_need=0;
        else $money_need=0;
        //$money_need= $user[$stat_nmdb[(int)$_POST['move_ab_top']]]<=0 ? "10":$user[$stat_nmdb[(int)$_POST['move_ab_top']]];
        if (@(int)$_POST['move_ab']==@(int)$_POST['move_ab_top']) echo "<font color=red><b>Переносить умение можно только в другое!</b></font>";
        elseif (!$user["b_".$stat_nmdb[(int)$_POST['move_ab']]]>0) { echo "<font color=red><b>Недостаточно умений для перераспределения!</b></font>"; }
        elseif ($user['money']-$money_need<0 && $user['freedrops']<1) {
            echo "<font color=red><b>Недостаточно кредитов для совершения операции!</b></font>";
            }
        else {
            mq("UPDATE `users` SET `".$stat_nmdb[(int)$_POST['move_ab']]."`=(`".$stat_nmdb[(int)$_POST['move_ab']]."`-1), `".$stat_nmdb[(int)$_POST['move_ab_top']]."`=(`".$stat_nmdb[(int)$_POST['move_ab_top']]."`+1), ".($user["freedrops"]>0?"freedrops=freedrops-1":"money=(money-".$money_need.")")." WHERE id=".(int)$_SESSION['uid']." ");
            mq("UPDATE `userdata` SET `".$stat_nmdb[(int)$_POST['move_ab']]."`=(`".$stat_nmdb[(int)$_POST['move_ab']]."`-1), `".$stat_nmdb[(int)$_POST['move_ab_top']]."`=(`".$stat_nmdb[(int)$_POST['move_ab_top']]."`+1) WHERE id=".(int)$_SESSION['uid']." ");
            resetmax((int)$_SESSION['uid']);
            echo "<font color=red>Перераспределение статов \"".$stat_nm[(int)$_POST['move_ab']]." ".$stat_nmto[(int)$_POST['move_ab_top']]."\" произведено успешно. ";
            if ($user["freedrops"]>0 && !ALLFREE) {
              $user["freedrops"]--;
            } elseif (!ALLFREE)  {
              echo " Цена операции $money_need кр.";
              $user['money']-=$money_need;
            }
            echo "</font>";
            $user[$stat_nmdb[(int)$_POST['move_ab_top']]]++; $user[$stat_nmdb[(int)$_POST['move_ab']]]--;
            $trv=settravma((int)$_SESSION['uid'],20,rand(300,600),1,1);
            }
        }
      }

    } elseif ((int)$_POST['sbr_nav']>0) {
      if (($user['b_noj']+$user['b_mec']+$user['b_topor']+$user['b_dubina']+$user['b_posoh']+$user['b_mfire']+$user['b_mwater']+$user['b_mair']+$user['b_mearth']+$user['b_mlight']+$user['b_mgray']+$user['b_mdark'])==0) echo "<font color=red><b>У Вас нет нераспределённых умений!</b></font>";
      elseif (!file_exists(MEMCACHE_PATH.'/uml'.$_SESSION['uid']) || ALLFREE) {
        $levelstats=statsat($user["nextup"]);    
        if (mq("UPDATE `users` SET `master`=$levelstats[master]+$user[extramaster],noj=0,mec=0,topor=0,dubina=0,posoh=0, luk=0, mfire=0, mwater=0, mair=0, mearth=0, mlight=0, mgray=0, mdark=0 WHERE `id`='$user[id]'")) {
          mq("UPDATE `userdata` SET `master`=$levelstats[master]+$user[extramaster],noj=0,mec=0,topor=0,dubina=0,posoh=0, luk=0, mfire=0, mwater=0, mair=0, mearth=0, mlight=0, mgray=0, mdark=0 WHERE `id`='$user[id]'");
          fixstats($user["id"]);
          mq("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" бесплатно перераспределил умения в Комнате Знахаря. ',1,'".time()."');");
          echo "<font color=red>Все прошло удачно. Вы можете перераспределить умения.</font>";
          if (!ALLFREE) {
            $flum=fopen(MEMCACHE_PATH.'/uml'.$_SESSION['uid'],'w');
            fwrite($flum,date('Y-m-d H:i:s'));
            fclose($flum);
          }
          $trv=settravma((int)$_SESSION['uid'],20,rand(300,600),1,1);
        }
        else echo "<font color=red>Произошла ошибка!</font>";
      } else {
        if ($user['money']<0) echo "<font color=red><b>Недостаточно кредитов для совершения операции!</b></font>";
        else {
          $levelstats=statsat($user["nextup"]);                        
          if (mq("UPDATE `users` SET ".(ALLFREE?"":"money=money-0,")." `master`=$levelstats[master]+$user[extramaster],noj=0,mec=0,topor=0,dubina=0,posoh=0, luk=0, mfire=0, mwater=0, mair=0, mearth=0, mlight=0, mgray=0, mdark=0 WHERE `id`='$user[id]'")) {
            mq("UPDATE `userdata` SET `master`=$levelstats[master]+$user[extramaster],noj=0,mec=0,topor=0,dubina=0,posoh=0, luk=0, mfire=0, mwater=0, mair=0, mearth=0, mlight=0, mgray=0, mdark=0 WHERE `id`='$user[id]'");
            fixstats($user["id"]);
            if (!ALLFREE) $user["money"]-=0;
            mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" перераспределил умения, заплатив 0 кр. в Комнате Знахаря ($user[money]/$user[ekr]). ',1,'".time()."');");
            echo "<font color=red>Все прошло удачно. Вы можете перераспределить умения.</font>";
            $trv=settravma((int)$_SESSION['uid'],20,rand(300,600),1,1);
          } else echo "<font color=red>Произошла ошибка!</font>";
        }
      }
    } elseif ((int)$_POST['sbr_osb']>0) {
      if ($user['features']==0) echo "<font color=red><b>У Вас нет распределённых особенностей!</b></font>";
      elseif (!file_exists(MEMCACHE_PATH.'/osb'.$_SESSION['uid']) || ALLFREE) {
        if (mq("UPDATE `users` SET `features` = 0 WHERE `id`='$user[id]'")) {
          mq("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" бесплатно перераспределил особенности в Комнате Знахаря. ',1,'".time()."');");
          echo "<font color=red>Все прошло удачно. Вы можете перераспределить особенности.</font>";
          if (!ALLFREE) {
            $flum=fopen(MEMCACHE_PATH.'/osb'.$_SESSION['uid'],'w');
            fwrite($flum,date('Y-m-d H:i:s'));
            fclose($flum);
          } $trv=settravma((int)$_SESSION['uid'],20,rand(300,600),1,1);
        } else echo "<font color=red>Произошла ошибка!</font>";
      } else {
        if ($user['money']<0) echo "<font color=red><b>Недостаточно кредитов для совершения операции!</b></font>";
        else {
          if (mq("UPDATE `users` SET ".(ALLFREE?"":"money=money-0,")." `features` = 0 WHERE `id`='$user[id]'")) {
            if (!ALLFREE) $user["money"]-=0;
            mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" перераспределил особенности, заплатив 0 кр. в Комнате Знахаря ($user[money]/$user[ekr]). ',1,'".time()."');");
            echo "<font color=red>Все прошло удачно. Вы можете перераспределить умения.</font>";
            $trv=settravma((int)$_SESSION['uid'],20,rand(300,600),1,1);
          } else echo "<font color=red>Произошла ошибка!</font>";
        }
      }
    } elseif ((int)$_POST['sbr_par']>0) {
      include "config/expstats.php";

      if (!file_exists(MEMCACHE_PATH.'/par'.$_SESSION['uid']) || ALLFREE) {
        //mysql_query("delete from effects where (sila<>0 or lovk<>0 or inta<>0 or vinos<>0 or intel<>0) and owner='".$_SESSION['uid']."'");
        $levelstats=statsat($user['nextup']);
        //mq("delete from effects where (sila<>0 or lovk<>0 or inta<>0 or vinos<>0 or intel<>0) and owner='$user[id]'");
        //mq("delete from obshagaeffects where (sila<>0 or lovk<>0 or inta<>0 or vinos<>0 or intel<>0) and owner='$user[id]'");
        mq("UPDATE `users` SET `stats` = ".($levelstats['stats']-9)."+$user[extrastats], `sila`=3,`lovk`=3,`inta`=3,`mudra`=0,`intel`=0,`spirit`= ".$levelstats["spirit"].", sexy=0,`vinos`= ".$levelstats["vinos"].",`maxhp`= ".$levelstats["vinos"]."*6,`maxmana`= 0,`mana`= 0 WHERE `id`='$user[id]' LIMIT 1;");
        mq("UPDATE `userdata` SET `stats` = ".($levelstats['stats']-9)."+$user[extrastats], `sila`=3,`lovk`=3,`inta`=3,`mudra`=0,`intel`=0,`spirit`= ".$levelstats["spirit"].", sexy=0,`vinos`= ".$levelstats["vinos"]." WHERE `id`='$user[id]' LIMIT 1");
        fixstats($user["id"]);
        mq("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" бесплатно сбросил параметры в Комнате Знахаря. ',1,'".time()."');");
        echo "<font color=red>Все прошло удачно. Вы можете перераспределить параметры.</font>";
        if (!ALLFREE) {
          $flum=fopen(MEMCACHE_PATH.'/par'.$_SESSION['uid'],'w');
          fwrite($flum,date('Y-m-d H:i:s'));
          fclose($flum);
        }
        $trv=settravma((int)$_SESSION['uid'],20,rand(300,600),1,1);
      } else {
        if ($user['money']<0) echo "<font color=red><b>Недостаточно кредитов для совершения операции!</b></font>";
        else {
          //mysql_query("delete from effects where (sila<>0 or lovk<>0 or inta<>0 or vinos<>0 or intel<>0) and owner='".$_SESSION['uid']."'");
          $levelstats=statsat($user['nextup']);
          if (!ALLFREE) {
            mq("update users set money=money-0 where id='$user[id]'");
            $user["money"]-=0;
          }
          //mq("delete from effects where (sila<>0 or lovk<>0 or inta<>0 or vinos<>0 or intel<>0) and owner='$user[id]'");
          //mq("delete from obshagaeffects where (sila<>0 or lovk<>0 or inta<>0 or vinos<>0 or intel<>0) and owner='$user[id]'");
          mq("UPDATE `users` SET `stats` = ".($levelstats['stats']-9)."+$user[extrastats], `sila`=3,`lovk`=3,`inta`=3,`mudra`=0,`intel`=0,`spirit`= ".$levelstats["spirit"].", sexy=0,`vinos`= ".$levelstats["vinos"].",`maxhp`= ".$levelstats["vinos"]."*6,`maxmana`= 0,`mana`= 0 WHERE `id`='$user[id]' LIMIT 1");
          mq("UPDATE `userdata` SET `stats` = ".($levelstats['stats']-9)."+$user[extrastats], `sila`=3,`lovk`=3,`inta`=3,`mudra`=0,`intel`=0,`spirit`= ".$levelstats["spirit"].", sexy=0,`vinos`= ".$levelstats["vinos"]." WHERE `id`='$user[id]' LIMIT 1");
          fixstats($user["id"]);
          mq("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" сбросил параметры, заплатив 0 кр. в Комнате Знахаря ($user[money]/$user[ekr]). ',1,'".time()."');");
          echo "<font color=red>Все прошло удачно. Вы можете перераспределить параметры.</font>";
          $trv=settravma((int)$_SESSION['uid'],20,rand(300,600),1,1);
        }
      }
      resetmax($user["id"]);
    }
if ($trv!="") echo "<br>Вы чувствуете слабость.. ".$trv."";
?>
<br>Деньги: <b><?=$user['money'];?></b> кр.
<br><br>
<? if ($trv!="") die; ?>
<fieldset>
<legend style='font-weight:bold; color:#8F0000;'>Навыки владения оружием и магией</legend>
<form method=post><input type=hidden value='<?=$_SESSION['uid'];?>' name='sbr_nav'> У Вас есть шанс забыть старое ради нового: <input type=submit value='Отпустить умения <?echo file_exists(MEMCACHE_PATH.'/uml'.$_SESSION['uid']) && !ALLFREE? "(0 кр.)":"(бесплатно)"?>'></form>
</fieldset><br><br>


<fieldset>
<legend style='font-weight:bold; color:#8F0000;'>Параметры</legend>
<form method=post><input type=hidden value='<?=$_SESSION['uid'];?>' name='sbr_par'> У Вас есть шанс забыть старое ради нового: <input type=submit value='Отпустить параметры <?echo file_exists(MEMCACHE_PATH.'/par'.$_SESSION['uid']) && !ALLFREE ? "(0 кр.)":"(бесплатно)"?>'></form>
</fieldset><br><br>

<fieldset>
<legend style='font-weight:bold; color:#8F0000;'>Пристрастия</legend>
<?
  $r=mq("select * from effects where owner='$user[id]' and (type='".ADDICTIONEFFECT."' or type='".HPADDICTIONEFFECT."' or type='".MANAADDICTIONEFFECT."')");
  if (mysql_num_rows($r)>0) {
    echo "У Вас есть возможность вылечиться от пагубных пристрастий:<br><br>";
    echo "<table>";
    while ($rec=mysql_fetch_assoc($r)) {
      $at=addicttype($rec);
      echo "<tr><td><img src=\"".IMGBASE."/i/misc/icon_$at.gif\"></td><td><a href=\"znahar.php?healaddict=$rec[id]\">вылечить</a> ".(ALLFREE?"(бесплатно)":"(цена лечения: 0 кр., время действия ещё ".secs2hrs($rec["time"]-time()).")")."</td></tr>";
    }
    echo "</table>";
  } else {
    echo "У вас нет пагубных пристрастий.";
  }
?>
</fieldset><br><br>

<fieldset>
<legend style='font-weight:bold; color:#8F0000;'>Эликсиры, магия и другие эффекты</legend>
<?
  $r=mq("select * from effects where owner='$user[id]' and (type=49 or type=187 or type=188 or type=189) and time>1");
  if (mysql_num_rows($r)>0) {
    echo "У Вас есть возможность вылечиться от пагубных пристрастий:<br><br>";
    echo "<table>";
    while ($rec=mysql_fetch_assoc($r)) {
      echo "<tr><td><a onclick=\"return confirm('Вы уверены, что хотите снять действие эффекта '+String.fromCharCode(34)+'$rec[name]'+String.fromCharCode(34)+'?');\" href=\"znahar.php?remeffect=$rec[id]\">$rec[name]</a> ".(ALLFREE?"(бесплатно)":"(цена 0 кр., время действия ещё ".secs2hrs($rec["time"]-time()).")")."</td></tr>";
    }
    echo "</table>";
  } else {
    echo "Вы не находитесь под воздействием эликсиров, магии или других эффектов, которые знахарь может снять.";
  }
?>
</fieldset><br><br>


</BODY>

</HTML>

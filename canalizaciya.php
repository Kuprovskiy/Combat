<?php
  function delpodzitems($u) {
    $r=mq("select id, dressed from inventory where owner='$_SESSION[uid]' and foronetrip=1");
    while ($rec=mysql_fetch_assoc($r)) if ($rec["dressed"]) dropitem(11);
    mq("delete from inventory where foronetrip=1 and owner='$_SESSION[uid]'");
    mysql_query("DELETE FROM `inventory` WHERE name='Эликсир Жизни' and owner='$u' and podzem='1'");
    mysql_query("DELETE FROM `inventory` WHERE name='Ключик №1' and owner='$u' and podzem='1'");
    mysql_query("DELETE FROM `inventory` WHERE name='Ключик №2' and owner='$u' and podzem='1'");
    mysql_query("DELETE FROM `inventory` WHERE name='Ключик №3' and owner='$u' and podzem='1'");
    mysql_query("DELETE FROM `inventory` WHERE name='Ключик №4' and owner='$u' and podzem='1'");
    mysql_query("DELETE FROM `inventory` WHERE name='Ключик №5' and owner='$u' and podzem='1'");
    mysql_query("DELETE FROM `inventory` WHERE name='Ключик №6' and owner='$u' and podzem='1'");
    mysql_query("DELETE FROM `inventory` WHERE name='Ключик №7' and owner='$u' and podzem='1'");
    mysql_query("DELETE FROM `inventory` WHERE name='Ключик №8' and owner='$u' and podzem='1'");
    mysql_query("DELETE FROM `inventory` WHERE name='Ключик №9' and owner='$u' and podzem='1'");
    mysql_query("DELETE FROM `inventory` WHERE name='Ключик №10' and owner='$u' and podzem='1'");
    mysql_query("DELETE FROM `inventory` WHERE owner='$u' and type='188' and podzem='1'");
  }
  function botname($bot) {
    global $mir;
    if ($bot>=29 && $bot<=31) {
      $obs=array(29=>"sneg1", 30=>"sneg2", 31=>"sneg3");
      if ($mir["level"]<4) $lvl=0;
      else $lvl=$mir["level"]-4;
      if ($lvl>11) $lvl=11;
      $bots["29"]=array("Снеговичёнок","Молодой Снеговик","Снеговик","Взрослый Снеговик","Матёрый Снеговик","Мудрый Снеговик","Старый Снеговик","Старший Снеговик");
      $bots["30"]=array("Злой Снеговичёнок","Злой Молодой Снеговик","Злой Снеговик","Злой Взрослый Снеговик","Злой Матёрый Снеговик","Злой Мудрый Снеговик","Злой Старый Снеговик","Злой Старший Снеговик");
      $bots["31"]=array("Начальник Снеговичат","Начальник Молодых Снеговиков","Начальник Снеговиков","Начальник Взрослых Снеговиков","Начальник Матёрых Снеговиков","Начальник Мудрых Снеговиков","Начальник Старых Снеговиков","Начальник Старших Снеговиков");
      return array($bots[$bot][$lvl], $obs[$bot]);
    } else {
      if ($bot==19) return array("trup","Бродячий Труп", 87); // Образ, логин, ид
      if ($bot==20) return array("izi","Изи", 86);
      if ($bot==21) return array("kosmar","Кошмар Глубин", 85);
      if ($bot==22) return array("prok","Проклятие Глубин", 84);
      if ($bot==23) return array("uzas","Ужас Глубин", 83);
      if ($bot==24) return array("bes","Бес", 92);
      if ($bot==25) return array("zelen","Зеленый Голем", 91);
      if ($bot==26) return array("demon","Крылатый Демон", 90);
      if ($bot==27) return array("skelet","Скелет", 89);
      if ($bot==28) return array("straz","Страж", 88);

    }
  }
  session_start();
  if ($_SESSION['uid'] == null) header("Location: index.php");
  include "connect.php";
  include "functions.php";
  nick99 ($_SESSION['uid']);
if(in_array($user['room'], $canalrooms)){
  include "startpodzemel.php";
  if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }

  if($_GET['act']=="cexit") {
    $das=mysql_query("select glava,glav_id from `labirint` where user_id='".$user['id']."'");
    $rf=mysql_fetch_array($das);
    $glav_id=$rf["glav_id"];
    $glava=$rf["glava"];
    if($glava==$user['login']){//1
      $des=mysql_query("select login,user_id from `labirint` where `glav_id`='$glav_id' and `login`!='$glava'");
      $r=0;
      while($raf=mysql_fetch_array($des)){//2
        $r++;
        $log = $raf["login"];
        $id_us = $raf["user_id"];
      }//2
      if($r>=1){
        mysql_query("UPDATE labirint SET glav_id='$id_us',glava='$log' WHERE glav_id='".$user['id']."'");
        mysql_query("UPDATE podzem3 SET glava='$log' WHERE glava='".$user['login']."'");
        mysql_query("UPDATE podzem4 SET glava='$log' WHERE glava='".$user['login']."'");
      }else{
        mysql_query("DELETE FROM labirint WHERE glav_id='".$user['id']."'");
        mysql_query("DELETE FROM podzem3 WHERE glava='".$user['login']."'");
        mysql_query("DELETE FROM podzem4 WHERE glava='".$user['login']."'");
      }
    }//1
    delpodzitems($user["id"]);
    $e = mysql_query("DELETE FROM labirint WHERE user_id='".$user['id']."'");
    mysql_query("UPDATE `users`,`online` SET `users`.`room` = '".($user["room"]-1)."',`online`.`room` = '".($user["room"]-1)."' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '".$user['id']."' ;");
    print "<script>location.href='vxod.php'</script>"; exit();
  }
?>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="ru">
<link rel=stylesheet type="text/css" href="<?=IMGBASE?>/i/main.css">
<SCRIPT LANGUAGE="JavaScript" >
var Hint3Name = '';
// Заголовок, название скрипта, имя поля с логином
function findlogin(title, script, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B style="font-size:11px">'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><form action="'+script+'" method=GET><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"><td colspan=2>'+
    'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD width=50% align=right><INPUT TYPE=text NAME="'+name+'"></TD><TD width=50%><INPUT TYPE="submit" value=" »» "></TD></TR></FORM></TABLE></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}


function returned2(s){
    if (top.oldlocation != '') { top.frames['main'].navigate(top.oldlocation+'?'+s+'tmp='+Math.random()); top.oldlocation=''; }
    else { top.frames['main'].navigate('main.php?'+s+'tmp='+Math.random()) }
}

function closehint3(){
    document.all("hint3").style.visibility="hidden";
    Hint3Name='';
}
</script>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5  bgcolor="#d7d7d7" onLoad="<?=topsethp()?>">
<script LANGUAGE='JavaScript'>
<!--document.ondragstart = test;-->
//запрет на перетаскивание
<!--document.onselectstart = test;-->
//запрет на выделение элементов страницы
<!--document.oncontextmenu = test;-->
//запрет на выведение контекстного меню
function test() {
 return false
}
</SCRIPT>
<?
  $ros=mysql_query("SELECT * FROM `labirint` WHERE `user_id`='{$_SESSION['uid']}'");
  $mir=mysql_fetch_array($ros);
  $mesto = $mir['location'];
  $vektor = $mir['vector'];
  $glava = $mir['glava'];
  if($_GET['act'] == "luka" and $mesto == '28'){print "<script>location.href='podzem_dialog.php'</script>"; exit();}
  // 3 smerti == vqlet
  if($mir['dead']>=3){print "<script>location.href='?act=cexit'</script>"; exit();}
  //vignat
  if($_GET['kill']){
    if($user['login']==$glava){
      $rost=mysql_fetch_array(mysql_query("SELECT `user_id` FROM `labirint` WHERE `glava`='$glava' and `login`='".$_GET['kill']."'"));
      $varsa = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE `login` = '".$_GET['kill']."' LIMIT 1;"));
      if($varsa and $rost){
        if($_GET['kill']!=$glava){
          mysql_query("DELETE FROM labirint WHERE login='".$_GET['kill']."'");
          delpodzitems($varsa['id']);
          //mysql_query("DELETE FROM `inventory` WHERE name='Бутерброд' and owner='".$varsa['id']."' and podzem='1'");
          print "<script>location.href='canalizaciya.php'</script>"; exit();
        } else {
          print"<font style='font-size:12px; color:#cc0000'>Себя нельзя выгнать.</font>";
        }
      } else {
        print"<font style='font-size:12px; color:#cc0000'>Такого логина не существует или он не в вашей группе.</font>";}
      }
    }
    //smena lider
    if($_GET['change']){
      if($user['login']==$glava){
        $rost=mysql_fetch_array(mysql_query("SELECT `user_id` FROM `labirint` WHERE `glava`='$glava' and `login`='".$_GET['change']."'"));
        $varsa = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE `login` = '".$_GET['change']."' LIMIT 1;"));
        if($varsa and $rost){
          if($_GET['change']!=$glava){
            mysql_query("UPDATE labirint SET glav_id='".$varsa['id']."',glava='".$_GET['change']."' WHERE glava='".$user['login']."'");
            mysql_query("UPDATE podzem3 SET glava='".$_GET['change']."' WHERE glava='".$user['login']."'");
            mysql_query("UPDATE podzem4 SET glava='".$_GET['change']."' WHERE glava='".$user['login']."'");
            print "<script>location.href='canalizaciya.php'</script>"; exit();
          } else {
            print"<font style='font-size:12px; color:#cc0000'>Вы и так Лидер.</font>";
          }
        } else {
          print"<font style='font-size:12px; color:#cc0000'>Такого логина не существует или он не в вашей группе.</font>";
        }
      }
    }

    $wait_sec=$mir["visit_time"];
    $new_t=time();
    if($wait_sec<$new_t) {
      print "<script>location.href='?act=cexit&".time()."'</script>"; exit();
    }
    if($mir['dead']>=3){print "<script>location.href='?act=cexit&".time()."'</script>"; exit();}
    include "canalization_mod.php";

////////////нападение////////////////
    if($_GET['act'] == "atk"){
      $d = $_GET['n']+10;
      $d2 = $_GET['n']-10;
      $d3 = $_GET['n']+1;
      $d4 = $_GET['n']-1;
      $red = mysql_query("SELECT n".$_GET['n']." FROM podzem3 WHERE glava='".$mir['glava']."' and name='".$mir['name']."'");
      if($gef = mysql_fetch_array($red)){
        $dop = $gef["n".$_GET['n'].""];
      }
      if($mesto == $d or $mesto == $d1 or $mesto == $d2 or $mesto == $d3 or $mesto == $d4){
        if($dop!='' && (float)$dop<500){
          include"podzem/atk.php";
        } else echo "<b><font color=red size=2>Кто-то уже убил этого монстра.</font></b>";
      }
    }

    if($_GET['act']=='el') {
      if($mir['el']!='1' and $mesto==$mir['el']){
        mysql_query("INSERT INTO `inventory` (`owner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`present`,`magic`,`otdel`,`isrep`,`podzem`,`prototype`)
                        VALUES('".$user['id']."','Эликсир Жизни','188','1','0','pot_cureHP100_20.gif','10','Лука','189','188','0','1', 1538) ;");
        mysql_query("UPDATE `labirint` SET el='1' WHERE `glava`='".$glava."' and `login`='".$user['login']."'");
        print"&nbsp;<font style='font-size:12px; color:red;'>Вы получили 'Эликсир Жизни'</font><br>";
      } else {
        if($mir['el']=='1'){
          print"&nbsp;<font style='font-size:12px; color:red;'>Вы уже брали зелье!</font><br>";
        } else {
          print"&nbsp;<font style='font-size:12px; color:red;'>Невозможно! Вы далеко!</font><br>";
        }
      }
    }

///////////////Сбор гаек/////////////
if (@$_GET["take"]) {
  $_GET["take"]=(int)$_GET["take"];
  $place=mqfa1("SELECT n$mesto FROM `podzem3` WHERE glava='$glava' and name='$mir[name]'");
  $tmp=explode("-", $place);
  $found=0;
  foreach ($tmp as $k=>$v) {
    if ($v==$_GET["take"]) {
      $found=1;
      unset($tmp[$k]);
      break;
    }
  }
  if ($found) {
    include_once "questfuncs.php";
    if (count($tmp)<=1) mq("UPDATE `podzem3` SET n$mesto='' WHERE glava='$glava' and name='".$mir['name']."'");
    else mq("UPDATE `podzem3` SET n$mesto='".implode("-",$tmp)."' WHERE glava='$glava' and name='".$mir['name']."'");
    $res=takesmallitem($_GET["take"],0,"Нашёл в пещере");
    $mis=mqfa1("select name from smallitems where id='$_GET[take]'");
    include "podzem_brat.php";
    print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили '$mis'</font>";
  } else {
    echo "&nbsp;<font style='font-size:12px; color:cc0000;'>Кто-то оказался быстрее!</font>";
  }
}
if($_GET['sun']=='gaika'){
$ferrr = mysql_query("SELECT n$mesto FROM `podzem3` WHERE glava='$glava' and name='".$mir['name']."'");
$retr = mysql_fetch_array($ferrr);
$stloc = $retr["n$mesto"];
if ($stloc=='511') {
  include_once "questfuncs.php";
  mysql_query("UPDATE `podzem3` SET n$mesto='' WHERE glava='$glava' and name='".$mir['name']."'");
  $res=takesmallitem(12,0,"Нашёл в пещере");
  $mis=$res["name"];
  include "podzem_brat.php";
  print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили '$mis'</font>";
}
if($stloc=='503' or $stloc=='502' or $stloc=='501'){
if($stloc=='503'){mysql_query("UPDATE `podzem3` SET n$mesto='502' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='502'){mysql_query("UPDATE `podzem3` SET n$mesto='501' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='501'){mysql_query("UPDATE `podzem3` SET n$mesto='' WHERE glava='$glava' and name='".$mir['name']."'");}
$f = mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Гайка' and koll<'30'");
if($g = mysql_fetch_array($f)){
$koll = $g["koll"];
mysql_query("UPDATE `inventory` SET koll=koll+1,massa=massa+0.1 WHERE owner='".$user['id']."' and `type`='200' and `name`='Гайка' and koll<'30'");
}else{
$fo = mysql_query("INSERT INTO `inventory`(name,koll,img,owner,type,massa,isrep,podzem,maxdur) VALUES('Гайка','1','g.gif','".$user['id']."','200','0.1','0','1','1')");
}
$mis = "Гайка";
include "podzem_brat.php";
print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили 'Гайка'</font>";
}else{if($stloc==''){print"&nbsp;<font style='font-size:12px; color:cc0000;'>Кто-то оказался быстрее!</font>";}}
}
/////////////////////////////////////
///////////////Сбор вентилей/////////////
if($_GET['sun']=='ventil'){
$ferrr = mysql_query("SELECT n$mesto FROM `podzem3` WHERE glava='$glava' and name='".$mir['name']."'");
$retr = mysql_fetch_array($ferrr);
$stloc = $retr["n$mesto"];
if($stloc=='504' or $stloc=='505' or $stloc=='506'){
if($stloc=='506'){mysql_query("UPDATE `podzem3` SET n$mesto='505' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='505'){mysql_query("UPDATE `podzem3` SET n$mesto='504' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='504'){mysql_query("UPDATE `podzem3` SET n$mesto='' WHERE glava='$glava' and name='".$mir['name']."'");}
$f = mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Вентиль' and koll<'30'");
if($g = mysql_fetch_array($f)){
$koll = $g["koll"];
mysql_query("UPDATE `inventory` SET koll=koll+1,massa=massa+0.2 WHERE owner='".$user['id']."' and `type`='200' and `name`='Вентиль' and koll<'30'");
}else{
$fo = mysql_query("INSERT INTO `inventory`(name,koll,img,owner,type,massa,isrep,podzem,maxdur) VALUES('Вентиль','1','v.gif','".$user['id']."','200','0.2','0','1','1')");
}
$mis = "Вентиль";
include "podzem_brat.php";
print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили 'Вентиль'</font>";
}else{if($stloc==''){print"&nbsp;<font style='font-size:12px; color:cc0000;'>Кто-то оказался быстрее!</font>";}}
}
/////////////////////////////////////
///////////////Сбор Болтов/////////////
if($_GET['sun']=='bolt'){
$ferrr = mysql_query("SELECT n$mesto FROM `podzem3` WHERE glava='$glava' and name='".$mir['name']."'");
$retr = mysql_fetch_array($ferrr);
$stloc = $retr["n$mesto"];
if($stloc=='507' or $stloc=='508' or $stloc=='509'){
if($stloc=='509'){mysql_query("UPDATE `podzem3` SET n$mesto='508' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='508'){mysql_query("UPDATE `podzem3` SET n$mesto='507' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='507'){mysql_query("UPDATE `podzem3` SET n$mesto='' WHERE glava='$glava' and name='".$mir['name']."'");}
$f = mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Болт' and koll<'30'");
if($g = mysql_fetch_array($f)){
$koll = $g["koll"];
mysql_query("UPDATE `inventory` SET koll=koll+1,massa=massa+0.1 WHERE owner='".$user['id']."' and `type`='200' and `name`='Болт' and koll<'30'");
}else{
$fo = mysql_query("INSERT INTO `inventory`(name,koll,img,owner,type,massa,isrep,podzem,maxdur) VALUES('Болт','1','bolt.gif','".$user['id']."','200','0.1','0','1','1')");
}
$mis = "Болт";
include "podzem_brat.php";
print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили 'Болт'</font>";
}else{if($stloc==''){print"&nbsp;<font style='font-size:12px; color:cc0000;'>Кто-то оказался быстрее!</font>";}}
}
/////////////////////////////////////
///////////////Сбор ключиик/////////////
if($_GET['sun']=='kluchiik'){
$ferrr = mysql_query("SELECT n$mesto FROM `podzem3` WHERE glava='$glava' and name='".$mir['name']."'");
$retr = mysql_fetch_array($ferrr);
$stloc = $retr["n$mesto"];
if($stloc=='510'){
if($stloc=='510'){mysql_query("UPDATE `podzem3` SET n$mesto='' WHERE glava='$glava' and name='".$mir['name']."'");}
$fo = mysql_query("INSERT INTO `inventory`(name,koll,img,owner,type,massa,isrep,podzem,maxdur) VALUES('Ключиик','1','kluchik.gif','".$user['id']."','200','0.5','0','1','1')");
$mis = "Ключиик";
include "podzem_brat.php";
print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили 'Ключиик'</font>";
}else{if($stloc==''){print"&nbsp;<font style='font-size:12px; color:cc0000;'>Кто-то оказался быстрее!</font>";}}
}
/////////////////////////////////////
///////////////Сбор сундуков/////////////
if($_GET['act']=='sunduk'){
$ferrr = mysql_query("SELECT n".$_GET['n']." FROM `podzem4` WHERE glava='$glava' and name='".$mir['name']."'");
$retr = mysql_fetch_array($ferrr);
$stloc = $retr["n".$_GET['n'].""];
if($stloc=='13.1'){
$d = $_GET['n']+10;
$d2 = $_GET['n']-10;
$d3 = $_GET['n']+1;
$d4 = $_GET['n']-1;
if($mesto==$d or $mesto==$d2 or $mesto==$d3 or $mesto==$d4){
if($stloc=='13.1'){mysql_query("UPDATE `podzem4` SET n".$_GET['n']."='13.0' WHERE glava='$glava' and name='".$mir['name']."'");}
$f = mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Гайка' and koll<'30'");
if($g = mysql_fetch_array($f)){
$koll = $g["koll"];
mysql_query("UPDATE `inventory` SET koll=koll+1,massa=massa+0.1 WHERE owner='".$user['id']."' and `type`='200' and `name`='Гайка' and koll<'30'");
}else{
$fo = mysql_query("INSERT INTO `inventory`(name,koll,img,owner,type,massa,isrep,podzem,maxdur) VALUES('Гайка','1','g.gif','".$user['id']."','200','0.1','0','1','1')");
}
$mis = "Гайка";
include "podzem_brat.php";
print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили 'Гайка'</font>";
}
}else{if($stloc=='13.0'){print"&nbsp;<font style='font-size:12px; color:cc0000;'>Кто-то оказался быстрее!</font>";}}
}
/////////////////////////////////////
///////////////Сбор сундуков (БОЛТ)/////////////
if($_GET['act']=='sunduk2'){
  $ferrr = mysql_query("SELECT n".$_GET['n']." FROM `podzem4` WHERE glava='$glava' and name='".$mir['name']."'");
  $retr = mysql_fetch_array($ferrr);
  $stloc = $retr["n".$_GET['n'].""];
  if($stloc=='14.1'){
    $d = $_GET['n']+10;
    $d2 = $_GET['n']-10;
    $d3 = $_GET['n']+1;
    $d4 = $_GET['n']-1;
    if($mesto==$d or $mesto==$d2 or $mesto==$d3 or $mesto==$d4){
      if($stloc=='14.1'){mysql_query("UPDATE `podzem4` SET n".$_GET['n']."='14.0' WHERE glava='$glava' and name='".$mir['name']."'");}
      $f = mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Болт' and koll<'30'");
      if($g = mysql_fetch_array($f)){
        $koll = $g["koll"];
        mysql_query("UPDATE `inventory` SET koll=koll+1,massa=massa+0.1 WHERE owner='".$user['id']."' and `type`='200' and `name`='Болт' and koll<'30'");
      } else {
        $fo = mysql_query("INSERT INTO `inventory`(name,koll,img,owner,type,massa,isrep,podzem,maxdur) VALUES('Болт','1','bolt.gif','".$user['id']."','200','0.1','0','1','1')");
      }
      $mis = "Болт";
      include "podzem_brat.php";
      print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили 'Болт'</font>";
    }
  } elseif ($stloc=='15.1' || $stloc=='15.2' || $stloc=='15.3' || $stloc=='15.4') {
    $d = $_GET['n']+10;
    $d2 = $_GET['n']-10;
    $d3 = $_GET['n']+1;
    $d4 = $_GET['n']-1;
    if($mesto==$d or $mesto==$d2 or $mesto==$d3 or $mesto==$d4){
      include_once "questfuncs.php";
      if ($stloc=='15.1') $i=rand(3,6);
      if ($stloc=='15.2') $i=2;
      if ($stloc=='15.3') {
        /*$i=7;
        while ($i<10) {
          $mis=takeitem($i,1,1);
          $mis=$mis["name"];
          include "podzem_brat.php";
          print"&nbsp;<font style='font-size:12px; color:cc0000;'>В сундуке вы нашли '$mis'</font><br>";
          $i++;
        }*/
        $i=14;
      }
      $mis=takeitem($i,1,1);
      $mis=$mis["name"];
      include "podzem_brat.php";
      print"&nbsp;<font style='font-size:12px; color:cc0000;'>В сундуке вы нашли '$mis'</font>";
      mq("UPDATE `podzem4` SET n".$_GET['n']."='15.0' WHERE glava='$glava' and name='".$mir['name']."'");
    }
  } elseif ($stloc=='16.1') {
    $d = $_GET['n']+10;
    $d2 = $_GET['n']-10;
    $d3 = $_GET['n']+1;
    $d4 = $_GET['n']-1;
    if($mesto==$d or $mesto==$d2 or $mesto==$d3 or $mesto==$d4){
      include_once "questfuncs.php";
      $mis=takeitem(12,1,1);
      $mis=$mis["name"];
      include "podzem_brat.php";
      print"&nbsp;<font style='font-size:12px; color:cc0000;'>В сундуке вы нашли '$mis'</font>";
      mq("UPDATE `podzem4` SET n".$_GET['n']."='16.0' WHERE glava='$glava' and name='".$mir['name']."'");
    }
  } elseif ($stloc=='17.1' || $stloc=='17.2') {
    $d = $_GET['n']+10;
    $d2 = $_GET['n']-10;
    $d3 = $_GET['n']+1;
    $d4 = $_GET['n']-1;
    if($mesto==$d or $mesto==$d2 or $mesto==$d3 or $mesto==$d4){
      if ($stloc=='17.1') {$prob=98;$si=15;}
      if ($stloc=='17.2') {$prob=96;$si=19;}
      srand();
      include_once "questfuncs.php";
      $r=rand(0,100);
      if ($r<=$prob) {
        $mis=takesmallitem($si+rand(0,2),0,"Нашёл в пещере");
      } else {
        $items=array(1898, 1897, 1896, 778, 777, 776, 775);
        $item=$items[rand(0,6)];
        $mis=takeshopitem($item, "shop", "", "", 0, array("podzem"=>1, "maxdur"=>5+rand(0,5), "isrep"=>0));
      }
      $mis=$mis["name"];
      include "podzem_brat.php";
      print"&nbsp;<font style='font-size:12px; color:cc0000;'>В сундуке вы нашли '$mis'</font>";
      mq("UPDATE `podzem4` SET n".$_GET['n']."='17.0' WHERE glava='$glava' and name='".$mir['name']."'");
    }
  } elseif ($stloc=='18.1') {
    $d = $_GET['n']+10;
    $d2 = $_GET['n']-10;
    $d3 = $_GET['n']+1;
    $d4 = $_GET['n']-1;
    if($mesto==$d or $mesto==$d2 or $mesto==$d3 or $mesto==$d4){
      include_once "questfuncs.php";
      //$mis=takeshopitem(134, "shop", "", "", 0, array("podzem"=>1, "isrep"=>0));
      $mis=takeshopitem(129, "shop", "", "", 0, array("podzem"=>1, "isrep"=>0));
      $mis=$mis["name"];
      include "podzem_brat.php";
      print"&nbsp;<font style='font-size:12px; color:cc0000;'>В сундуке вы нашли '$mis'</font>";
      mq("UPDATE `podzem4` SET n".$_GET['n']."='16.0' WHERE glava='$glava' and name='".$mir['name']."'");
    }
  } else {
    if($stloc=='14.0' || $stloc=='15.0' || $stloc=='16.0'){print"&nbsp;<font style='font-size:12px; color:cc0000;'>Кто-то оказался быстрее!</font>";}
  }
}
/////////////////////////////////////
///////////////Сбор ключей/////////////
if($_GET['act']=='key'){
$ferrr = mysql_query("SELECT n".$_GET['n']." FROM `podzem4` WHERE glava='$glava' and name='".$mir['name']."'");
$retr = mysql_fetch_array($ferrr);
$stloc = $retr["n".$_GET['n'].""];
$f = mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Ключик №".$_GET['b']."'");
$g = mysql_fetch_array($f);
if(($stloc=='key1' or $stloc=='key2' or $stloc=='key3' or $stloc=='key4' or $stloc=='key5' or $stloc=='key6' or $stloc=='key7' or $stloc=='key8' or $stloc=='key9' or $stloc=='key10') and !$g){
if($mesto==$_GET['n']){
$fo = mysql_query("INSERT INTO `inventory`(name,koll,img,owner,type,massa,isrep,podzem,maxdur) VALUES('Ключик №".$_GET['b']."','1','$stloc.gif','".$user['id']."','200','0.1','0','1','1')");
print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили 'Ключик №".$_GET['b']."'</font>";
}
}else{if($g){print"&nbsp;<font style='font-size:12px; color:cc0000;'>У вас уже есть Ключик №".$_GET['b']."!</font>";}}

}
/////////////////////////////////////
///////////////Сбор гаек из стоков/////////////
if($_GET['act']=='stok') {
    $ferrr = mysql_query("SELECT n".$_GET['n']." FROM `podzem4` WHERE glava='$glava' and name='".$mir['name']."'");
    $retr = mysql_fetch_array($ferrr);
    $stloc = $retr["n".$_GET['n'].""];
    $shans = rand(0,100);
    if ($mesto != 13) { // если с пустой склянкой за пробами
        if ($shans<51) {
            mysql_query("UPDATE `podzem4` SET n".$_GET['n']."='11.0' WHERE glava='$glava' and name='".$mir['name']."'");
            $stloc='11.0';
        }
    }
    if($stloc=='11.1') {
        if ($mesto==$_GET['n']) {
            if ($stloc=='11.1') {
                mysql_query("UPDATE `podzem4` SET n".$_GET['n']."='11.0' WHERE glava='$glava' and name='".$mir['name']."'");
            }
            $rnd=rand(0,10);
            if ($mesto == 13 && $mir['name'] == 'Канализация 1 этаж') { // получение пробы в склянку для Храма Знаний
                $isVial = mysql_result(mysql_query("SELECT COUNT(*) FROM inventory WHERE owner = $user[id] AND name = 'Пустая склянка'"), 0, 0);
                if ($isVial) {
                    mysql_query("UPDATE inventory SET name = 'Склянка с пробами', podzem = 1, img = 'full_rune_vial.gif' WHERE owner = $user[id] AND name = 'Пустая склянка'");
                    print"&nbsp;<font style='font-size:12px; color:cc0000;'>Склянка от Хранителя Знаний наполнилась мутной жидкостью.</font>";
                } else {
                    print"&nbsp;<font style='font-size:12px; color:cc0000;'>Попахивает..</font>";
                }
            } elseif ($rnd==7 && LETTERQUEST) {
                include_once("questfuncs.php");
                $item=takesmallitem(57);
                $mis = "$item[name]";
                include "podzem_brat.php";
                print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили '$item[name]'</font>";
            } else {
                $f=mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Гайка' and koll<'30'");
                if ($g = mysql_fetch_array($f)) {
                    $koll = $g["koll"];
                    mysql_query("UPDATE `inventory` SET koll=koll+1,massa=massa+0.1 WHERE owner='".$user['id']."' and `type`='200' and `name`='Гайка' and koll<'30'");
                } else {
                    $fo = mysql_query("INSERT INTO `inventory`(name,koll,img,owner,type,massa,isrep,podzem,maxdur) VALUES('Гайка','1','g.gif','".$user['id']."','200','0.1','0','1','1')");
                }
                $mis = "Гайка";
                include "podzem_brat.php";
                print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили 'Гайка'</font>";
            }
        }
    } else {
        if ($stloc=='11.0') {
            print"&nbsp;<font style='font-size:12px; color:cc0000;'>Попахивает...</font>";
        }
    }
}
///////////////Сбор гаек из стоков/////////////
if($_GET['act']=='stok2'){
$ferrr = mysql_query("SELECT n".$_GET['n']." FROM `podzem4` WHERE glava='$glava' and name='".$mir['name']."'");
$retr = mysql_fetch_array($ferrr);
$stloc = $retr["n".$_GET['n'].""];
$shans = rand(0,100);
if($shans<51){
mysql_query("UPDATE `podzem4` SET n".$_GET['n']."='12.0' WHERE glava='$glava' and name='".$mir['name']."'");
$stloc='12.0';
}
if($stloc=='12.1'){
$d = $_GET['n']+10;
$d2 = $_GET['n']-10;
$d3 = $_GET['n']+1;
$d4 = $_GET['n']-1;
if($mesto==$d or $mesto==$d2 or $mesto==$d3 or $mesto==$d4){
if($stloc=='12.1'){mysql_query("UPDATE `podzem4` SET n".$_GET['n']."='12.0' WHERE glava='$glava' and name='".$mir['name']."'");}
$f=mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Гайка' and koll<'30'");
if($g = mysql_fetch_array($f)){
$koll = $g["koll"];
mysql_query("UPDATE `inventory` SET koll=koll+1,massa=massa+0.1 WHERE owner='".$user['id']."' and `type`='200' and `name`='Гайка' and koll<'30'");
}else{
$fo = mysql_query("INSERT INTO `inventory`(name,koll,img,owner,type,massa,isrep,podzem,maxdur) VALUES('Гайка','1','g.gif','".$user['id']."','200','0.1','0','1','1')");
}
$mis = "Гайка";
include "podzem_brat.php";
print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили 'Гайка'</font>";
}
}else{if($stloc=='12.0'){print"&nbsp;<font style='font-size:12px; color:cc0000;'>Попахивает...</font>";}}
}
/////////////////////////////////////
///////////////Сбор гаек/////////////
if($_GET['sun']=='se_gaika_c'){
$ferrr = mysql_query("SELECT n$mesto FROM `podzem3` WHERE glava='$glava' and name='".$mir['name']."'");
$retr = mysql_fetch_array($ferrr);
$stloc = $retr["n$mesto"];
if($stloc=='603' or $stloc=='602' or $stloc=='601' or $stloc=='607' or $stloc=='608' or $stloc=='609'){
if($stloc=='609'){mysql_query("UPDATE `podzem3` SET n$mesto='608' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='608'){mysql_query("UPDATE `podzem3` SET n$mesto='607' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='607'){mysql_query("UPDATE `podzem3` SET n$mesto='' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='603'){mysql_query("UPDATE `podzem3` SET n$mesto='602' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='602'){mysql_query("UPDATE `podzem3` SET n$mesto='601' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='601'){mysql_query("UPDATE `podzem3` SET n$mesto='' WHERE glava='$glava' and name='".$mir['name']."'");}
$f = mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Чистая гайка' and koll<'30'");
if($g = mysql_fetch_array($f)){
$koll = $g["koll"];
mysql_query("UPDATE `inventory` SET koll=koll+1,massa=massa+0.1 WHERE owner='".$user['id']."' and `type`='200' and `name`='Чистая гайка' and koll<'30'");
}else{
$fo = mysql_query("INSERT INTO `inventory`(name,koll,img,owner,type,massa,isrep,podzem,maxdur) VALUES('Чистая гайка','1','g_c.gif','".$user['id']."','200','0.1','0','1','1')");
}
$mis = "Чистая гайка";
include "podzem_brat.php";
print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили 'Чистая гайка'</font>";
}else{if($stloc==''){print"&nbsp;<font style='font-size:12px; color:cc0000;'>Кто-то оказался быстрее!</font>";}}
}
/////////////////////////////////////
///////////////Сбор болтов/////////////
if($_GET['sun']=='se_gaika_bd'){
$ferrr = mysql_query("SELECT n$mesto FROM `podzem3` WHERE glava='$glava' and name='".$mir['name']."'");
$retr = mysql_fetch_array($ferrr);
$stloc = $retr["n$mesto"];
if($stloc=='609' or $stloc=='608' or $stloc=='607' || $stloc=='606' or $stloc=='605' or $stloc=='604'){
if($stloc=='609'){mysql_query("UPDATE `podzem3` SET n$mesto='608' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='608'){mysql_query("UPDATE `podzem3` SET n$mesto='607' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='607'){mysql_query("UPDATE `podzem3` SET n$mesto='' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='606'){mysql_query("UPDATE `podzem3` SET n$mesto='605' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='605'){mysql_query("UPDATE `podzem3` SET n$mesto='604' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='604'){mysql_query("UPDATE `podzem3` SET n$mesto='' WHERE glava='$glava' and name='".$mir['name']."'");}
$f = mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Длинный болт' and koll<'30'");
if($g = mysql_fetch_array($f)){
$koll = $g["koll"];
mysql_query("UPDATE `inventory` SET koll=koll+1,massa=massa+0.1 WHERE owner='".$user['id']."' and `type`='200' and `name`='Длинный болт' and koll<'30'");
}else{
$fo = mysql_query("INSERT INTO `inventory`(name,koll,img,owner,type,massa,isrep,podzem,maxdur) VALUES('Длинный болт','1','bolt_d.gif','".$user['id']."','200','0.1','0','1','1')");
}
$mis = "Длинный болт";
include "podzem_brat.php";
print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили 'Длинный болт'</font>";
}else{if($stloc==''){print"&nbsp;<font style='font-size:12px; color:cc0000;'>Кто-то оказался быстрее!</font>";}}
}
/////////////////////////////////////
///////////////Сбор болтов/////////////
if($_GET['sun']=='se_gaika_nb'){
$ferrr = mysql_query("SELECT n$mesto FROM `podzem3` WHERE glava='$glava' and name='".$mir['name']."'");
$retr = mysql_fetch_array($ferrr);
$stloc = $retr["n$mesto"];
if($stloc=='612' or $stloc=='611' or $stloc=='610' or $stloc=='613'){
if($stloc=='612'){mysql_query("UPDATE `podzem3` SET n$mesto='611' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='611'){mysql_query("UPDATE `podzem3` SET n$mesto='610' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='610' || $stloc=='613'){mysql_query("UPDATE `podzem3` SET n$mesto='' WHERE glava='$glava' and name='".$mir['name']."'");}
$f = mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Нужный болт' and koll<'30'");
if($g = mysql_fetch_array($f)){
$koll = $g["koll"];
mysql_query("UPDATE `inventory` SET koll=koll+1,massa=massa+0.1 WHERE owner='".$user['id']."' and `type`='200' and `name`='Нужный болт' and koll<'30'");
}else{
$fo = mysql_query("INSERT INTO `inventory`(name,koll,img,owner,type,massa,isrep,podzem,maxdur) VALUES('Нужный болт','1','nb.gif','".$user['id']."','200','0.1','0','1','1')");
}
$mis = "Нужный болт";
include "podzem_brat.php";
print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили 'Нужный болт'</font>";
}else{if($stloc==''){print"&nbsp;<font style='font-size:12px; color:cc0000;'>Кто-то оказался быстрее!</font>";}}
}
/////////////////////////////////////
///////////////Сбор болтов/////////////
if($_GET['sun']=='se_gaika_rez'){
$ferrr = mysql_query("SELECT n$mesto FROM `podzem3` WHERE glava='$glava' and name='".$mir['name']."'");
$retr = mysql_fetch_array($ferrr);
$stloc = $retr["n$mesto"];
if($stloc=='606' or $stloc=='605' or $stloc=='604' or $stloc=='612' or $stloc=='611' or $stloc=='610'){
if($stloc=='606'){mysql_query("UPDATE `podzem3` SET n$mesto='605' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='605'){mysql_query("UPDATE `podzem3` SET n$mesto='604' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='612'){mysql_query("UPDATE `podzem3` SET n$mesto='611' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='611'){mysql_query("UPDATE `podzem3` SET n$mesto='610' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='604' || $stloc=='610'){mysql_query("UPDATE `podzem3` SET n$mesto='' WHERE glava='$glava' and name='".$mir['name']."'");}
$f = mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Гайка с резьбой' and koll<'30'");
if($g = mysql_fetch_array($f)){
$koll = $g["koll"];
mysql_query("UPDATE `inventory` SET koll=koll+1,massa=massa+0.1 WHERE owner='".$user['id']."' and `type`='200' and `name`='Гайка с резьбой' and koll<'30'");
}else{
$fo = mysql_query("INSERT INTO `inventory`(name,koll,img,owner,type,massa,isrep,podzem,maxdur) VALUES('Гайка с резьбой','1','g_r.gif','".$user['id']."','200','0.1','0','1','1')");
}
$mis = "Гайка с резьбой";
include "podzem_brat.php";
print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили 'Гайка с резьбой'</font>";
}else{if($stloc==''){print"&nbsp;<font style='font-size:12px; color:cc0000;'>Кто-то оказался быстрее!</font>";}}
}
/////////////////////////////////////
///////////////Сбор винтелей/////////////
if($_GET['sun']=='se_gaika_rv'){
$ferrr = mysql_query("SELECT n$mesto FROM `podzem3` WHERE glava='$glava' and name='".$mir['name']."'");
$retr = mysql_fetch_array($ferrr);
$stloc = $retr["n$mesto"];
if($stloc=='612' or $stloc=='611' or $stloc=='610' || $stloc=='613' or $stloc=='614' or $stloc=='615'){
if($stloc=='612'){mysql_query("UPDATE `podzem3` SET n$mesto='611' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='611'){mysql_query("UPDATE `podzem3` SET n$mesto='610' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='610'){mysql_query("UPDATE `podzem3` SET n$mesto='' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='615'){mysql_query("UPDATE `podzem3` SET n$mesto='614' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='614'){mysql_query("UPDATE `podzem3` SET n$mesto='613' WHERE glava='$glava' and name='".$mir['name']."'");}
if($stloc=='613'){mysql_query("UPDATE `podzem3` SET n$mesto='' WHERE glava='$glava' and name='".$mir['name']."'");}
$f = mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Рабочий вентиль' and koll<'30'");
if($g = mysql_fetch_array($f)){
$koll = $g["koll"];
mysql_query("UPDATE `inventory` SET koll=koll+1,massa=massa+0.1 WHERE owner='".$user['id']."' and `type`='200' and `name`='Рабочий вентиль' and koll<'30'");
}else{
$fo = mysql_query("INSERT INTO `inventory`(name,koll,img,owner,type,massa,isrep,podzem,maxdur) VALUES('Рабочий вентиль','1','rv.gif','".$user['id']."','200','0.1','0','1','1')");
}
$mis = "Рабочий вентиль";
include "podzem_brat.php";
print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили 'Рабочий вентиль'</font>";
}else{if($stloc==''){print"&nbsp;<font style='font-size:12px; color:cc0000;'>Кто-то оказался быстрее!</font>";}}
}
/////////////////////////////////////

if($mesto == '1'){$mesto = '01';}
if($mesto == '2'){$mesto = '02';}
if($mesto == '3'){$mesto = '03';}
if($mesto == '4'){$mesto = '04';}
if($mesto == '5'){$mesto = '05';}
if($mesto == '6'){$mesto = '06';}
if($mesto == '7'){$mesto = '07';}
if($mesto == '8'){$mesto = '08';}
if($mesto == '9'){$mesto = '09';}

// переходы
    if(isset($_GET['left'])){
      mysql_query("UPDATE `labirint` SET `vector` = '".$_GET['left']."' WHERE `user_id` = '{$_SESSION['uid']}' ;");
      //header('Location:canalizaciya.php');
      die("<script>location.href='canalizaciya.php?".time()."';</script>");
    }
    if(isset($_GET['right'])){
      mysql_query("UPDATE `labirint` SET `vector` = '".$_GET['right']."' WHERE `user_id` = '{$_SESSION['uid']}' ;");
      //header('Location:canalizaciya.php');
      die("<script>location.href='canalizaciya.php?&".time()."';</script>");
    }
    if($rhar[$mesto][$_GET['path']]!=''){
      $fer = mysql_query("SELECT n".$rhar[$mesto][$_GET['path']]." FROM podzem3 WHERE glava='".$mir['glava']."' and name='".$mir['name']."'");
      if($ret = mysql_fetch_array($fer)){
        $stoi = $ret["n".$rhar[$mesto][$_GET['path']].""];
      }
    }

if($rhar[$mesto][$_GET['path']] > 0 and $_GET['path'] < 4 and $_GET['path'] >= 0 and ($user['movetime'] <= time()) and ($stoi=='' or $stoi>'500' and $mir['name']=='Ледяная пещера' or $stoi>'500' and $mir['name']=='Канализация 1 этаж' or $stoi=='' or ($stoi>=600 and $stoi<=615) and ($mir['name']=='Канализация 2 этаж' || $mir['name']=='Канализация 3 этаж') or $stoi[0]=="i") ) {
  if($_GET['path']==0) $loc2=$mesto+10;
  if($_GET['path']==1) $loc2=$mesto+1;
  if($_GET['path']==2) $loc2=$mesto-10;
  if($_GET['path']==3) $loc2=$mesto-1;
  $fers = mysql_query("SELECT n$loc2,v$loc2 FROM podzem4 WHERE glava='$glava' and name='".$mir['name']."'");
  $rets = mysql_fetch_array($fers);
  $ins = mysql_query("SELECT id FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Ключик №".$rets["n$loc2"]."'");
  $setr = mysql_fetch_array($ins);
  $tmp = mqfa1("SELECT id FROM `effects` WHERE `owner` = '".$user['id']."' AND (`type` = 14 OR `type` = 13)");
  if ($tmp) {
    print"&nbsp;<font style='font-size:12px; color:cc0000;'>У вас тяжёлая травма, вы не можете передвигаться.</font>";
  } elseif($rets["n$loc2"]>=1 and $rets["n$loc2"]<=10 and !$setr) {
    print"&nbsp;<font style='font-size:12px; color:cc0000;'>Нужен ключ №".$rets["n$loc2"]."".$rets["n$mesto"]."</font>";
  } else {
    $vrem=60*60+time();
    if($_GET['path']==0) {$nav='t=t-12';}
    if($_GET['path']==1) {$nav='l=l+12';}
    if($_GET['path']==2) {$nav='t=t+12';}
    if($_GET['path']==3) {$nav='l=l-12';}
    mysql_query("UPDATE `labirint` SET `location` = '".$rhar[$mesto][$_GET['path']]."',`visit_time`='$vrem',$nav WHERE `user_id` = '{$_SESSION['uid']}' ;");
    if($user['id']==7 || $user['id']==2372 || $user['id']==50){
      $_SESSION['time'] = time()+0;
      if ($user['id']==2372) $_SESSION['time'] = time()+3;
    } else {
      $spd=100+mqfa1("select sum(incspeed) from inventory where owner='$user[id]' and dressed=1");
      if ($spd==0) $spd=1;
      if (haseffect($user["data"], LIGHTSTEPS)) $spd*=1.6;
      $spd=round(10/($spd/100));
      $_SESSION['time'] = time()+$spd;

    }
    mq("update users set movetime='$_SESSION[time]' where id='$user[id]'");
    //header('Location:canalizaciya.php');
    die("<script>document.location.replace('canalizaciya.php?moved=1&".time()."');</script>");

  }
}

  $fd = mysql_query("SELECT * FROM podzem4 WHERE glava='$mir[glava]' and name='".$mir['name']."'");
  $repa = mysql_fetch_array($fd);
  if ($_GET["moved"] && strpos($repa["n$mesto"],"s")===0) {
    $surface=str_replace("s","",$repa["n$mesto"]);
    if ($surface==1) {
      if (!$user["boots"]) $p=0;
      else $p=mqfa1("select prototype from inventory where id='$user[boots]'");
      if ($p!=1779) {
        if ($p==1780) {
          echo "<div style=\"font-size:12px;color:#cc0000\">Лёд слишком скользкий и вы со всего разгона въехали в стену и получили тяжёлую травму.</div>";
          settravma($user["id"], 20, 600,1);
        } else {
          echo "<div style=\"font-size:12px;color:#cc0000\">Вы поскользнулись на скользком полу и получили тяжёлую травму.</div>";
          settravma($user["id"], 20, 300,1);
        }
      }
    }
  }

?>

<TABLE border="0" width=100% cellspacing=0 cellpadding=0>
<TR>
<TD colspan=3 valign=top align=right nowrap>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" align="left"><br><br>
<center><table width="440" border="0" cellspacing="1" cellpadding="0" bgcolor="#000000">
<?
$rog=mysql_query("SELECT login,name,glava FROM `labirint` WHERE `glava`='$glava'");
while($more=mysql_fetch_array($rog)){
$big = mysql_fetch_array(mysql_query("SELECT hp,maxhp,id,level FROM `users` WHERE `login` = '".$more['login']."'"));
?>
  <tr>
<td background="img/bg_scroll_05.gif" align="center">
<a href=inf.php?<?=$big['id']?> target=_blank title="Информация о <?=$more['login']?>"><?=$more['login']?></a> [<?=$big['level']?>]<a href='inf.php?<?=$big['id']?>' target='_blank'><img src='<?=IMGBASE?>/i/inf.gif' border=0></a></td>
<!--<td background="img/bg_scroll_05.gif" align="center"><?=$big['hp']?>/<?=$big['maxhp']?> </td>-->
<td background="img/bg_scroll_05.gif" nowrap style="font-size:9px">
<div style="position: relative">
<table cellspacing="0" cellpadding="0" style='line-height: 1'><td nowrap style="font-size:9px" style="position: relative"><SPAN id="HP" style='position: absolute; left: 5; z-index: 1; font-weight: bold; color: #FFFFFF'></SPAN><img src="<?=IMGBASE?>/i/misc/bk_life_loose.gif" alt="Уровень жизни" name="HP1" width="1" height="9" id="HP1"><img src="<?=IMGBASE?>/i/misc/bk_life_loose.gif" alt="Уровень жизни" name="HP2" width="1" height="9" id="HP2"></td></table>
</div></td>
<td background="img/bg_scroll_05.gif" align="center"><?=$more['name']?></td>
<? if($user['login']==$more['glava'] and $more['login']==$more['glava']){ ?>
<td background="img/bg_scroll_05.gif" align="center"><IMG alt="Лидер группы" src="<?=IMGBASE?>/i/misc/lead1.gif" width=24 height=15><A href="#" onClick="findlogin( 'Выберите персонажа которого хотите выгнать','canalizaciya.php', 'kill')"><IMG alt="Выгнать супостата" src="<?=IMGBASE?>/img/podzem/ico_kill_member1.gif" WIDTH="14" HEIGHT="17"></A>&nbsp;<A href="#" onClick="findlogin( 'Выберите персонажа которому хотите передать лидерство','canalizaciya.php', 'change')"><IMG alt="Новый царь" src="<?=IMGBASE?>/img/podzem/ico_change_leader1.gif" WIDTH="14" HEIGHT="17"></A></td>
<?
}
print"</tr>";
}
?>
</table></center>
<?

print"<br>";

if($mir['dead']>'0'){print"<br><font style='font-size:15px; color:#600'> <b>&nbsp;&nbsp;Кол-во проигрышей:</font></b> <b style='font-size:14px; color:#000'>".$mir['dead']."</b><br><br>";}
include "podzem_res.php";
$mis = mysql_fetch_array(mysql_query("SELECT * FROM `podzem_zad_login` WHERE `owner`='".$user['id']."'"));
if($mis){
print"<br><br>&nbsp;Задание:";
list($q,$n,$q)=botname($mis["bot"]);
echo " $n ".$mis['ubil']."/".$mis['ubit']."";
}
?>
    </td>
    <td align="right">
<?
$redd = mysql_query("SELECT `style` FROM `podzem2` WHERE `name`='".$mir['name']."'");
$gefd = mysql_fetch_array($redd);
include"navig.php";

echo build_move_image($mesto, $vektor, $gefd['style'], $glava, $mir['name']);
if($vektor == '0')  {echo 'смотрим на cевер';}
if($vektor == '90') {echo 'смотрим на восток';}
if($vektor == '180'){echo 'смотрим на юг';}
if($vektor == '270'){echo 'смотрим на запад';}
?></td>
  </tr>
</table>
<script language="javascript" type="text/javascript">
var progressEnd = 32;       // set to number of progress <span>'s.
var progressColor = '#00CC00';  // set to progress bar color
var mtime = parseInt('<?
/*if (($_SESSION['uid']==7 || $_SERVER["REMOTE_ADDR"]=="127.0.0.1")) {
  echo 1;
  $_SESSION['time']-=20;
} else {*/
echo $user['movetime']-time();
//}
?>');
if (!mtime || mtime<=0) {mtime=0;}
var progressInterval = Math.round(mtime*1000/progressEnd);  // set to time between updates (milli-seconds)
var is_accessible = true;
var progressAt = progressEnd;
var progressTimer;
function progress_clear() {
    for (var i = 1; i <= progressEnd; i++) document.getElementById('progress'+i).style.backgroundColor = 'transparent';
    progressAt = 0;

    for (var t = 1; t <= 8; t++) {
        if (document.getElementById('m'+t) ) {
            var tempname = document.getElementById('m'+t).children[0].src;
            if (tempname.match(/b\.gif$/)) {
                    document.getElementById('m'+t).children[0].id = 'backend';
            }
            var newname;
            newname = tempname.replace(/(b)?\.gif$/,'i.gif');

            document.getElementById('m'+t).children[0].src = newname;
        }
    }

    is_accessible = false;
    set_moveto(true);
}
function progress_update() {
    progressAt++;
    //if (progressAt > progressEnd) progress_clear();
    if (progressAt > progressEnd) {

        for (var t = 1; t <= 8; t++) {
            if (document.getElementById('m'+t) ) {
                var tempname = document.getElementById('m'+t).children[0].src;
                var newname;
                newname = tempname.replace(/i\.gif$/,'.gif');
                if (document.getElementById('m'+t).children[0].id == 'backend') {
                    tempname = newname.replace(/\.gif$/,'b.gif');
                    newname = tempname;
                }
                document.getElementById('m'+t).children[0].src = newname;
            }
        }

        is_accessible = true;
        if (window.solo_store && solo_store) { solo(solo_store); } // go to stored
        set_moveto(false);
    } else {document.getElementById('progress'+progressAt).style.backgroundColor = progressColor;
        progressTimer = setTimeout('progress_update()',progressInterval);
    }
}
function set_moveto (val) {
    document.getElementById('moveto').disabled = val;
    if (document.getElementById('bmoveto')) {
        document.getElementById('bmoveto').disabled = val;
    }
}
function progress_stop() {
    clearTimeout(progressTimer);
    progress_clear();
}
function check(it) {
    return is_accessible;
}
function check_access () {
    return is_accessible;
}
function ch_counter_color (color) {
    progressColor = color;
    for (var i = 1; i <= progressAt; i++) {
        document.getElementById('progress'+i).style.backgroundColor = progressColor;
    }
}
// brrr
if (mtime>0) {
    progress_clear();
    progress_update();
} else {
    for (var i = 1; i <= progressEnd; i++) {
        document.getElementById('progress'+i).style.backgroundColor = progressColor;
    }
}
</script>

</TD>
</TR>
</TABLE>

<div id=hint3 class=ahint></div>
<script>top.onlineReload(true)</script>

<style>

BODY {
         FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;
        font-size: 10px;
    margin: 0px 0px 0px 0px;

    scrollbar-face-color: #e3ac67;
    scrollbar-highlight-color: #e0c3a0;
    scrollbar-shadow-color: #b78d58;
    scrollbar-3dlight-color: #b78d58;
    scrollbar-arrow-color: #b78d58;
    scrollbar-track-color: #e0c3a0;
    scrollbar-darkshadow-color: #b78d58;
}
.menu {
  z-index: 100;
  background-color: #E4F2DF;
  border-style: solid; border-width: 2px; border-color: #77c3fc
  position: absolute;
  left: 0px;
  top: 0px;
  visibility: hidden;
  cursor:pointer;
}
a.menuItem {
border: 0px solid #000000;
background-color: #484848;
color: #000000;
display: block;
font-family: Verdana, Arial;
font-size: 8pt;
font-weight: bold;
padding: 2px 12px 2px 8px;
text-decoration: none;
}

a.menuItem:hover {
background-color: #d4cbaa;
color: #000000;
}

</style>

<!--<LINK REL=StyleSheet HREF='style.css' TYPE='text/css'>-->
<script>
var rnd = Math.random();
function sunduk(n)
{
 document.location.href="?act=sunduk&n="+n+"&rnd="+Math.random();
}
function sunduk2(n)
{
 document.location.href="?act=sunduk2&n="+n+"&rnd="+Math.random();
}
function key(n,b)
{
 document.location.href="?act=key&n="+n+"&b="+b+"&rnd="+Math.random();
}
function stok2(n)
{
 document.location.href="?act=stok2&n="+n+"&rnd="+Math.random();
}
function stok(n)
{
 document.location.href="?act=stok&n="+n+"&rnd="+Math.random();
}
function attack(n) {
 document.location.href="?act=atk&n="+n+"&rnd="+Math.random();
}
function dialog() {
 document.location.href="?act=luka&rnd="+Math.random();
}
function speakto(n) {
 document.location.href="speakto.php?speak="+n;
}
function OpenMenu(n, e){
  var el, x, y;
  el = document.getElementById("oMenu");
  var posx = 0;
  var posy = 0;
  if (!e) var e = window.event;
  if (e.pageX || e.pageY) {
    posx = e.pageX;
    posy = e.pageY;
  } else if (e.clientX || e.clientY) {
    posx = e.clientX + document.body.scrollLeft;
    posy = e.clientY + document.body.scrollTop;
  }
  el.innerHTML = '<div style="color:#000;font-size:14px;padding:5px 10px 5px 10px" class=menuItem onmouseout="this.className=\'menuItem\';" onmouseover="this.className=\'menuItem2\';" onclick="this.disabled = true;attack('+n+');closeMenu(event);"> <b>Напасть</b> </div>';
  //el.innerHTML = '<div style="color:#000;font-size:14px;padding:5px 10px 5px 10px" class=menuItem onmouseout="this.className=\'menuItem\';" onmouseover="this.className=\'menuItem2\';"> <a href="javascript:void(0)" onclick="this.disabled = true;attack('+n+');closeMenu(event);">Напасть</a> </div><div style="text-align:right;padding: 0px 10px 5px 0px"><a href="javascript:void(0);" onclick="closeMenu(event);">X</a></div>';
  el.style.left = posx + "px";
  el.style.top  = posy + "px";
  el.style.visibility = "visible";
}
function Opendialog(n, e){
  var el, x, y;
  el = document.all("oMenu");
  el = document.getElementById("oMenu");
  var posx = 0;
  var posy = 0;
  if (!e) var e = window.event;
  if (e.pageX || e.pageY) {
    posx = e.pageX;
    posy = e.pageY;
  } else if (e.clientX || e.clientY) {
    posx = e.clientX + document.body.scrollLeft;
    posy = e.clientY + document.body.scrollTop;
  }
  el.innerHTML = '<div style="color:#000;font-size:13px;padding:5px 10px 5px 10px" class=menuItem onmouseout="this.className=\'menuItem\';" onmouseover="this.className=\'menuItem2\';" onclick="this.disabled = true;attack('+n+');"> &nbsp;Напасть </div><div style="color:#000;font-size:13px;padding:5px 10px 5px 10px" class=menuItem onmouseout="this.className=\'menuItem\';" onmouseover="this.className=\'menuItem2\';" onclick="dialog();this.disabled=true;"> Говорить </div>';
  //el.innerHTML = '<div style="color:#000;font-size:14px;padding:5px 10px 5px 10px" class=menuItem onmouseout="this.className=\'menuItem\';" onmouseover="this.className=\'menuItem2\';"> <a href="javascript:void(0)" onclick="this.disabled = true;attack('+n+');closeMenu(event);">Напасть</a><div style="font-size:4px">&nbsp;</div><a href="javascript:void(0)" onclick="this.disabled = true;dialog();closeMenu(event);">Говорить</a> </div><div style="text-align:right;padding: 0px 10px 5px 0px"><a href="javascript:void(0);" onclick="closeMenu(event);">X</a></div>';

  el.style.left = posx + "px";
  el.style.top  = posy + "px";
  el.style.visibility = "visible";
}

function opendialog(n){
  var el, x, y;
  el = document.all("oMenu");
  x = event.clientX + document.documentElement.scrollLeft +document.body.scrollLeft - 5;
  y = event.clientY + document.documentElement.scrollTop + document.body.scrollTop-5;
  if (event.clientY + 72 > document.body.clientHeight) { y-=62 } else { y-=2 }
  el.innerHTML = '<div style="color:#000;font-size:14px;padding:5px 10px 5px 10px" class=menuItem onmouseout="this.className=\'menuItem\';" onmouseover="this.className=\'menuItem2\';"> <a href="javascript:void(0)" onclick="this.disabled = true;attack('+n+');closeMenu(event);">Напасть</a><div style="font-size:4px">&nbsp;</div><a href="javascript:void(0)" onclick="this.disabled = true;dialog();speakto('+n+');">Говорить</a> </div><div style="text-align:right;padding: 0px 10px 5px 0px"><a href="javascript:void(0);" onclick="closeMenu(event);">X</a></div>';

  el.style.left = x + "px";
  el.style.top  = y + "px";
  el.style.visibility = "visible";
}

function opendialog2(n){
  var el, x, y;
  el = document.all("oMenu");
  x = event.clientX + document.documentElement.scrollLeft +document.body.scrollLeft - 5;
  y = event.clientY + document.documentElement.scrollTop + document.body.scrollTop-5;
  if (event.clientY + 72 > document.body.clientHeight) { y-=62 } else { y-=2 }
  el.innerHTML = '<div style="color:#000;font-size:14px;padding:5px 10px 5px 10px" class=menuItem onmouseout="this.className=\'menuItem\';" onmouseover="this.className=\'menuItem2\';"><div style="font-size:4px">&nbsp;</div><a href="javascript:void(0)" onclick="location=\'dialog.php?char=20667\';">Говорить</a> </div><div style="text-align:right;padding: 0px 10px 5px 0px"><a href="javascript:void(0);" onclick="closeMenu(event);">X</a></div>';

  el.style.left = x + "px";
  el.style.top  = y + "px";
  el.style.visibility = "visible";
}

//Закрыть меню наподения
function closeMenu(event){
         if (window.event && window.event.toElement)
          {var cls = window.event.toElement.className;
                  if (cls=='menuItem' || cls=='menu') return;
          }
         document.all("oMenu").style.visibility = "hidden";
         document.all("oMenu").style.top="0px";
         document.all("oMenu").style.left="0px";
         return false;
}
</script>

<div style="position:absolute; left:130px; top:50px;" ID=oMenu CLASS="menu"></DIV>
<script>load_page();</script>
</BODY>
</HTML>
<?} else {
  header("location: main.php");
} ?>
<?php include("mail_ru.php"); ?>

<?php
	session_start();
	if ($_SESSION['uid'] == null) header("Location: index.php");
	include "connect.php";
	include "functions.php";
 nick99 ($_SESSION['uid']);
$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '".mysql_real_escape_string($_SESSION['uid'])."' LIMIT 1;"));

if($user['room']==699){
include "startpodzemelg.php";
if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }

if($_GET['act']=="cexit")
{
$das=mysql_query("select glava,glav_id from `labirint` where user_id='".mysql_real_escape_string($user['id'])."'");
$rf=mysql_fetch_array($das);
$glav_id=$rf["glav_id"];
$glava=$rf["glava"];
if($glava==$user['login']){//1
$des=mysql_query("select login,user_id from `labirint` where `glav_id`='".mysql_real_escape_string($glav_id)."' and `login`!='".mysql_real_escape_string($glava)."'");
$r=0;
while($raf=mysql_fetch_array($des)){//2
$r++;
$log = $raf["login"];
$id_us = $raf["user_id"];
}//2
if($r>=1){
mysql_query("UPDATE labirint SET glav_id='".mysql_real_escape_string($id_us)."',glava='".mysql_real_escape_string($log)."' WHERE glav_id='".mysql_real_escape_string($user['id'])."'");
mysql_query("UPDATE podzem3 SET glava='".mysql_real_escape_string($log)."' WHERE glava='".mysql_real_escape_string($user['login'])."'");
mysql_query("UPDATE podzem4 SET glava='".mysql_real_escape_string($log)."' WHERE glava='".mysql_real_escape_string($user['login'])."'");
mysql_query("UPDATE podzem_predmet SET glava='".mysql_real_escape_string($log)."' WHERE glava='".mysql_real_escape_string($user['login'])."'");
}else{
mysql_query("DELETE FROM podzem_predmet WHERE glava='".mysql_real_escape_string($user['login'])."'");
mysql_query("DELETE FROM labirint WHERE glav_id='".mysql_real_escape_string($user['id'])."'");
mysql_query("DELETE FROM podzem3 WHERE glava='".mysql_real_escape_string($user['login'])."'");
mysql_query("DELETE FROM podzem4 WHERE glava='".mysql_real_escape_string($user['login'])."'");
mysql_query("DELETE FROM `inventory` WHERE name='Зелье жизни' and owner='".mysql_real_escape_string($user['id'])."' and podzem='1'");
mysql_query("DELETE FROM `inventory` WHERE name='Ключик №1' and owner='".mysql_real_escape_string($user['id'])."' and podzem='1'");
mysql_query("DELETE FROM `inventory` WHERE name='Ключик №2' and owner='".mysql_real_escape_string($user['id'])."' and podzem='1'");
mysql_query("DELETE FROM `inventory` WHERE name='Ключик №3' and owner='".mysql_real_escape_string($user['id'])."' and podzem='1'");
mysql_query("DELETE FROM `inventory` WHERE name='Ключик №4' and owner='".mysql_real_escape_string($user['id'])."' and podzem='1'");
mysql_query("DELETE FROM `inventory` WHERE name='Ключик №5' and owner='".mysql_real_escape_string($user['id'])."' and podzem='1'");
mysql_query("DELETE FROM `inventory` WHERE name='Ключик №6' and owner='".mysql_real_escape_string($user['id'])."' and podzem='1'");
mysql_query("DELETE FROM `inventory` WHERE name='Ключик №7' and owner='".mysql_real_escape_string($user['id'])."' and podzem='1'");
mysql_query("DELETE FROM `inventory` WHERE name='Ключик №8' and owner='".mysql_real_escape_string($user['id'])."' and podzem='1'");
mysql_query("DELETE FROM `inventory` WHERE name='Ключик №9' and owner='".mysql_real_escape_string($user['id'])."' and podzem='1'");
mysql_query("DELETE FROM `inventory` WHERE name='Ключик №10' and owner='".mysql_real_escape_string($user['id'])."' and podzem='1'");
}
}//1
$e = mysql_query("DELETE FROM labirint WHERE user_id='".$user['id']."'");
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '698',`online`.`room` = '698' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '".$user['id']."' ;");
print "<script>location.href='vxodg.php'</script>"; exit();
}

?>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="ru">
<link rel=stylesheet type="text/css" href="i/main.css"> 
<SCRIPT LANGUAGE="JavaScript" >
var Hint3Name = '';
// Заголовок, название скрипта, имя поля с логином
function findlogin(title, script, name){
	document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B style="font-size:11px">'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
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
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5  bgcolor="#d7d7d7" onLoad="top.setHP(<?=$user['hp']?>,<?=$user['maxhp']?>,<?if(!$user['battle']){echo"10";}else{echo"0";}?>);"> 

<?
$ros=mysql_query("SELECT * FROM `labirint` WHERE `user_id`='".mysql_real_escape_string($_SESSION['uid'])."'");
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
$rost=mysql_fetch_array(mysql_query("SELECT `user_id` FROM `labirint` WHERE `glava`='".mysql_real_escape_string($glava)."' and `login`='".mysql_real_escape_string($_GET['kill'])."'"));
$varsa = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE `login` = '".mysql_real_escape_string($_GET['kill'])."' LIMIT 1;"));
if($varsa and $rost){
if($_GET['kill']!=$glava){
mysql_query("DELETE FROM labirint WHERE login='".mysql_real_escape_string($_GET['kill'])."'");
mysql_query("DELETE FROM `inventory` WHERE name='Бутерброд' and owner='".mysql_real_escape_string($varsa['id'])."' and podzem='1'");
print "<script>location.href='canalizaciyad.php'</script>"; exit();
}else{print"<font style='font-size:12px; color:#cc0000'>Себя нельзя выгнать.</font>";}
}else{print"<font style='font-size:12px; color:#cc0000'>Такого логина не существует или он не в вашей группе.</font>";}
}}
//smena lider
if($_GET['change']){
if($user['login']==$glava){
$rost=mysql_fetch_array(mysql_query("SELECT `user_id` FROM `labirint` WHERE `glava`='".mysql_real_escape_string($glava)."' and `login`='".mysql_real_escape_string($_GET['change'])."'"));
$varsa = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE `login` = '".mysql_real_escape_string($_GET['change'])."' LIMIT 1;"));
if($varsa and $rost){
if($_GET['change']!=$glava){
mysql_query("UPDATE labirint SET glav_id='".mysql_real_escape_string($varsa['id'])."',glava='".mysql_real_escape_string($_GET['change'])."' WHERE glava='".mysql_real_escape_string($user['login'])."'");
mysql_query("UPDATE podzem3 SET glava='".mysql_real_escape_string($_GET['change'])."' WHERE glava='".mysql_real_escape_string($user['login'])."'");
print "<script>location.href='canalizaciyad.php'</script>"; exit();
}else{print"<font style='font-size:12px; color:#cc0000'>Вы и так Лидер.</font>";}
}else{print"<font style='font-size:12px; color:#cc0000'>Такого логина не существует или он не в вашей группе.</font>";}
}}

$wait_sec=$mir["visit_time"];
$new_t=time();
if($wait_sec<$new_t)
{
print "<script>location.href='?act=cexit'</script>"; exit();
}
if($mir['dead']>=3){print "<script>location.href='?act=cexit'</script>"; exit();}
include "canalization_modg.php";
	
////////////нападение////////////////
if($_GET['act'] == "atk"){
$d = $_GET['n']+10;
$d2 = $_GET['n']-10;
$d3 = $_GET['n']+1;
$d4 = $_GET['n']-1;
$red = mysql_query("SELECT `n".mysql_real_escape_string($_GET['n'])."` FROM podzem3 WHERE glava='".mysql_real_escape_string($mir['glava'])."' and name='".mysql_real_escape_string($mir['name'])."'");
if($gef = mysql_fetch_array($red)){
$dop = $gef["n".$_GET['n'].""];
}
if($mesto == $d or $mesto == $d1 or $mesto == $d2 or $mesto == $d3 or $mesto == $d4){
if($dop!=''){
include"podzem/atk.php";
}
}
}
if($_GET['act']=='el') {
if($mir['el']!='1' and $mesto==$mir['el']){
mysql_query("INSERT INTO `inventory` (`owner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`present`,`magic`,`otdel`,`isrep`,`podzem`)
						VALUES('".mysql_real_escape_string($user['id'])."','Зелье жизни','13','1','0','food_l8.gif','10','Лука','8','6','0','1') ;");
mysql_query("UPDATE `labirint` SET el='1' WHERE `glava`='".mysql_real_escape_string($glava)."' and `login`='".mysql_real_escape_string($user['login'])."'");
print"&nbsp;<font style='font-size:12px; color:red;'>Вы получили 'Зелье жизни'</font><br>";
}else{
if($mir['el']=='1'){print"&nbsp;<font style='font-size:12px; color:red;'>Вы уже брали зелье!</font><br>";}
else{print"&nbsp;<font style='font-size:12px; color:red;'>Невозможно! Вы далеко!</font><br>";}}
}
///////////////Сбор сундуков/////////////
if($_GET['act']=='sunduk'){
$ferrr = mysql_query("SELECT n".mysql_real_escape_string($_GET['n'])." FROM `podzem4` WHERE glava='$glava' and name='".$mir['name']."'");
$retr = mysql_fetch_array($ferrr);
$stloc = $retr["n".$_GET['n'].""];
if($stloc=='13.1'){
$d = $_GET['n']+10;
$d2 = $_GET['n']-10;
$d3 = $_GET['n']+1;
$d4 = $_GET['n']-1;
if($mesto==$d or $mesto==$d2 or $mesto==$d3 or $mesto==$d4){
if($stloc=='13.1'){mysql_query("UPDATE `podzem4` SET n".mysql_real_escape_string($_GET['n'])."='13.0' WHERE glava='$glava' and name='".$mir['name']."'");}
$f = mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Гайка' and koll<'30'");
if($g = mysql_fetch_array($f)){
$koll = $g["koll"];
mysql_query("UPDATE `inventory` SET koll=koll+1,massa=massa+0.1 WHERE owner='".$user['id']."' and `type`='200' and `name`='Гайка' and koll<'30'");
}else{
$fo = mysql_query("INSERT INTO `inventory`(name,koll,img,owner,type,massa,isrep,podzem,maxdur,present) VALUES('Гайка','1','g.gif','".$user['id']."','200','0.1','0','1','1','Лука')");
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
$ferrr = mysql_query("SELECT n".mysql_real_escape_string($_GET['n'])." FROM `podzem4` WHERE glava='$glava' and name='".$mir['name']."'");
$retr = mysql_fetch_array($ferrr);
$stloc = $retr["n".$_GET['n'].""];
if($stloc=='14.1'){
$d = $_GET['n']+10;
$d2 = $_GET['n']-10;
$d3 = $_GET['n']+1;
$d4 = $_GET['n']-1;
if($mesto==$d or $mesto==$d2 or $mesto==$d3 or $mesto==$d4){
if($stloc=='14.1'){mysql_query("UPDATE `podzem4` SET n".mysql_real_escape_string($_GET['n'])."='14.0' WHERE glava='$glava' and name='".$mir['name']."'");}
$f = mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Болт' and koll<'30'");
if($g = mysql_fetch_array($f)){
$koll = $g["koll"];
mysql_query("UPDATE `inventory` SET koll=koll+1,massa=massa+0.1 WHERE owner='".$user['id']."' and `type`='200' and `name`='Болт' and koll<'30'");
}else{
$fo = mysql_query("INSERT INTO `inventory`(name,koll,img,owner,type,massa,isrep,podzem,maxdur,present) VALUES('Болт','1','bolt.gif','".$user['id']."','200','0.1','0','1','1','Лука')");
}
$mis = "Болт";
include "podzem_brat.php";
print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили 'Болт'</font>";
}
}else{if($stloc=='14.0'){print"&nbsp;<font style='font-size:12px; color:cc0000;'>Кто-то оказался быстрее!</font>";}}
}
/////////////////////////////////////
///////////////Сбор ключей/////////////
if($_GET['act']=='key'){
$ferrr = mysql_query("SELECT n".mysql_real_escape_string($_GET['n'])." FROM `podzem4` WHERE glava='$glava' and name='".$mir['name']."'");
$retr = mysql_fetch_array($ferrr);
$stloc = $retr["n".$_GET['n'].""];
$f = mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Ключик №".mysql_real_escape_string($_GET['b'])."'");
$g = mysql_fetch_array($f);
if(($stloc=='key1' or $stloc=='key2' or $stloc=='key3' or $stloc=='key4' or $stloc=='key5' or $stloc=='key6' or $stloc=='key7' or $stloc=='key8' or $stloc=='key9' or $stloc=='key10') and !$g){
if($mesto==$_GET['n']){
$fo = mysql_query("INSERT INTO `inventory`(name,koll,img,owner,type,massa,isrep,podzem,maxdur,present) VALUES('Ключик №".mysql_real_escape_string($_GET['b'])."','1','$stloc.gif','".$user['id']."','200','0.1','0','1','1','Лука')");
print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили 'Ключик №".$_GET['b']."'</font>";
}
}else{if($g){print"&nbsp;<font style='font-size:12px; color:cc0000;'>У вас уже есть Ключик №".$_GET['b']."!</font>";}}

}
/////////////////////////////////////
///////////////Сбор гаек из стоков/////////////
if($_GET['act']=='stok'){
$ferrr = mysql_query("SELECT n".mysql_real_escape_string($_GET['n'])." FROM `podzem4` WHERE glava='$glava' and name='".$mir['name']."'");
$retr = mysql_fetch_array($ferrr);
$stloc = $retr["n".$_GET['n'].""];
$shans = rand(0,100);
if($shans<51){
mysql_query("UPDATE `podzem4` SET n".mysql_real_escape_string($_GET['n'])."='11.0' WHERE glava='$glava' and name='".$mir['name']."'");
$stloc='11.0';
}
if($stloc=='11.1'){
if($mesto==$_GET['n']){
if($stloc=='11.1'){mysql_query("UPDATE `podzem4` SET n".$_GET['n']."='11.0' WHERE glava='$glava' and name='".$mir['name']."'");}
$f=mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Гайка' and koll<'30'");
if($g = mysql_fetch_array($f)){
$koll = $g["koll"];
mysql_query("UPDATE `inventory` SET koll=koll+1,massa=massa+0.1 WHERE owner='".$user['id']."' and `type`='200' and `name`='Гайка' and koll<'30'");
}else{
$fo = mysql_query("INSERT INTO `inventory`(name,koll,img,owner,type,massa,isrep,podzem,maxdur,present) VALUES('Гайка','1','g.gif','".$user['id']."','200','0.1','0','1','1','Лука')");
}
$mis = "Гайка";
include "podzem_brat.php";
print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили 'Гайка'</font>";
}
}else{if($stloc=='11.0'){print"&nbsp;<font style='font-size:12px; color:cc0000;'>Попахивает...</font>";}}
}
///////////////Сбор гаек из стоков/////////////
if($_GET['act']=='stok2'){
$ferrr = mysql_query("SELECT n".mysql_real_escape_string($_GET['n'])." FROM `podzem4` WHERE glava='$glava' and name='".$mir['name']."'");
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
$fo = mysql_query("INSERT INTO `inventory`(name,koll,img,owner,type,massa,isrep,podzem,maxdur,present) VALUES('Гайка','1','g.gif','".$user['id']."','200','0.1','0','1','1','Лука')");
}
$mis = "Гайка";
include "podzem_brat.php";
print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили 'Гайка'</font>";
}
}else{if($stloc=='12.0'){print"&nbsp;<font style='font-size:12px; color:cc0000;'>Попахивает...</font>";}}
}
/////////////////////////////////////
///////////////Сбор/////////////
if($_GET['sun']){
$ferss = mysql_query("SELECT name,img FROM podzem_predmet WHERE id='".mysql_real_escape_string($_GET['sun'])."' and glava='$glava' and location='".$mesto."' and podzem='".$mir['name']."'");
if($gss = mysql_fetch_array($ferss)){
mysql_query("DELETE FROM podzem_predmet WHERE id='".$_GET['sun']."'");

$f = mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='".$gss['name']."' and koll<'30'");
if($g = mysql_fetch_array($f)){
$koll = $g["koll"];
mysql_query("UPDATE `inventory` SET koll=koll+1,massa=massa+0.1 WHERE owner='".$user['id']."' and `type`='200' and `name`='".$gss['name']."' and koll<'30'");
}else{
$fo = mysql_query("INSERT INTO `inventory`(name,koll,img,owner,type,massa,isrep,podzem,maxdur,present) VALUES('".$gss['name']."','1','".$gss['img'].".gif','".$user['id']."','200','0.1','0','1','1','Лука')");
}

$mis = $gss['name'];
include "podzem_brat.php";
print"&nbsp;<font style='font-size:12px; color:cc0000;'>Вы получили '".$gss['name']."'</font>";
}else{print"&nbsp;<font style='font-size:12px; color:cc0000;'>Кто-то оказался быстрее!</font>";}
}
/////////////////////////////////////

//////////////////////////////////////////////////
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
	mysql_query("UPDATE `labirint` SET `vector` = '".$_GET['left']."' WHERE `user_id` = '".mysql_real_escape_string($_SESSION['uid'])."' ;");
	}
	if(isset($_GET['right'])){
	mysql_query("UPDATE `labirint` SET `vector` = '".$_GET['right']."' WHERE `user_id` = '{$_SESSION['uid']}' ;");
	}
if($rhar[$mesto][$_GET['path']]!=''){
$fer = mysql_query("SELECT n".$rhar[$mesto][mysql_real_escape_string($_GET['path'])]." FROM podzem3 WHERE glava='".$mir['glava']."' and name='".$mir['name']."'");
if($ret = mysql_fetch_array($fer)){
$stoi = $ret["n".$rhar[$mesto][$_GET['path']].""];
}	
                                    }

if($rhar[$mesto][$_GET['path']] > 0 and $_GET['path'] < 4 and $_GET['path'] >= 0 and ($_SESSION['time'] <= time()) and $stoi=='' ) {
if($_GET['path']==0) {$loc2=$mesto+10;}
if($_GET['path']==1) {$loc2=$mesto+1;}
if($_GET['path']==2) {$loc2=$mesto-10;}
if($_GET['path']==3) {$loc2=$mesto-1;}

$fers = mysql_query("SELECT n$loc2,v$loc2 FROM podzem4 WHERE glava='$glava' and name='".$mir['name']."'");
$rets = mysql_fetch_array($fers);

$ins = mysql_query("SELECT id FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Ключик №".$rets["n$loc2"]."'");

$setr = mysql_fetch_array($ins);

if($rets["n$loc2"]>=1 and $rets["n$loc2"]<=10 and !$setr){

print"&nbsp;<font style='font-size:12px; color:cc0000;'>Нужен ключ №".$rets["n$loc2"]."".$rets["n$mesto"]."</font>";}else{
$vrem=60*60+time();

if($_GET['path']==0) {$nav='t=t-12';}
if($_GET['path']==1) {$nav='l=l+12';}
if($_GET['path']==2) {$nav='t=t+12';}
if($_GET['path']==3) {$nav='l=l-12';}

mysql_query("UPDATE `labirint` SET `location` = '".$rhar[$mesto][mysql_real_escape_string($_GET['path'])]."',`visit_time`='$vrem',$nav WHERE `user_id` = '".mysql_real_escape_string($_SESSION['uid'])."' ;");

if($user['login']=='Комментатор' ){$_SESSION['time'] = time()+1;}else{$_SESSION['time'] = time()+20;}
	
	

}
	}
	
$ros=mysql_query("SELECT * FROM `labirint` WHERE `user_id`='".mysql_real_escape_string($_SESSION['uid'])."'");                                         
$mir=mysql_fetch_array($ros);
$mesto = $mir['location'];
$vektor = $mir['vector'];
$glava = $mir['glava'];

if($mesto == '1'){$mesto = '01';}
if($mesto == '2'){$mesto = '02';}
if($mesto == '3'){$mesto = '03';}
if($mesto == '4'){$mesto = '04';}
if($mesto == '5'){$mesto = '05';}
if($mesto == '6'){$mesto = '06';}
if($mesto == '7'){$mesto = '07';}
if($mesto == '8'){$mesto = '08';}
if($mesto == '9'){$mesto = '09';}

?>

<TABLE border="0" width=100% cellspacing=0 cellpadding=0>
<TR>
<TD colspan=3 valign=top align=right nowrap>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" align="left"><br><br>
<center><table width="490" border="0" cellspacing="1" cellpadding="0" bgcolor="#000000">
  <tr>
<td background="img/bg_scroll_01.gif" align="center">Логин</td>
<td background="img/bg_scroll_01.gif" align="center">Уровень жизни</td>
<td background="img/bg_scroll_01.gif" align="center">Звание</td>
<td background="img/bg_scroll_01.gif" align="center">Месторасположение</td>
<td background="img/bg_scroll_01.gif" align="center">Действие</td>
  </tr>
<?
$rog=mysql_query("SELECT login,name,glava FROM `labirint` WHERE `glava`='$glava'");                                   
while($more=mysql_fetch_array($rog)){
$big = mysql_fetch_array(mysql_query("SELECT hp,maxhp,id FROM `users` WHERE `login` = '".$more['login']."'"));
?>
  <tr>
<td background="img/bg_scroll_05.gif" align="center">
<a href=inf.php?<?=$big['id']?> target=_blank title="Информация о <?=$more['login']?>"><?=$more['login']?></a></td>
<td background="img/bg_scroll_05.gif" align="center"><?=$big['hp']?>/<?=$big['maxhp']?> </td>
<td background="img/bg_scroll_05.gif" align="center"><?if($more['login']==$more['glava']){print"Лидер";}else{print"Рядовой";}?></td>
<td background="img/bg_scroll_05.gif" align="center"><?=$more['name']?></td>
<? if($user['login']==$more['glava'] and $more['login']==$more['glava']){ ?>
<td background="img/bg_scroll_05.gif" align="center"><A href="#" onClick="findlogin( 'Выберите персонажа которого хотите выгнать','canalizaciyad.php', 'kill')"><IMG alt="Выгнать супостата" src="img/podzem/ico_kill_member1.gif" WIDTH="14" HEIGHT="17"></A>&nbsp;<A href="#" onClick="findlogin( 'Выберите персонажа которому хотите передать лидерство','canalizaciyad.php', 'change')"><IMG alt="Новый царь" src="img/podzem/ico_change_leader1.gif" WIDTH="14" HEIGHT="17"></A></td>
<?
}
print"</tr>";
}


print"</table></center><br>";

if($mir['dead']>'0'){print"<br><font style='font-size:15px; color:#600'> <b>&nbsp;&nbsp;Кол-во смертей:</font></b> <b style='font-size:14px; color:#000'>".$mir['dead']."</b><br><br>";}
include "podzem_res.php";

?>
	</td>
    <td align="right">
<?
$redd = mysql_query("SELECT `style` FROM `podzem2` WHERE `name`='".$mir['name']."'");
$gefd = mysql_fetch_array($redd);
include"navigg.php";


echo build_move_image($mesto, $vektor, $gefd['style'], $glava, $mir['name']);
if($vektor == '0')  {echo 'смотрим на cевер';}
if($vektor == '90') {echo 'смотрим на восток';}
if($vektor == '180'){echo 'смотрим на юг';}
if($vektor == '270'){echo 'смотрим на запад';}
echo'<br><small>живность на локации<small><br>';
?>	
	</td>
  </tr>
</table>
<script language="javascript" type="text/javascript">
var progressEnd = 32;		// set to number of progress <span>'s.
var progressColor = '#00CC00';	// set to progress bar color
var mtime = parseInt('<?=($_SESSION['time']-time())?>');
if (!mtime || mtime<=0) {mtime=0;}
var progressInterval = Math.round(mtime*1000/progressEnd);	// set to time between updates (milli-seconds)
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
  cursor:hand;
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

<LINK REL=StyleSheet HREF='i/main.css' TYPE='text/css'>
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
function attack(n)
{
 document.location.href="?act=atk&n="+n+"&rnd="+Math.random();
}
function dialog()
{
 document.location.href="?act=luka&rnd="+Math.random();
}
function OpenMenu(n){
         var el, x, y;
         el = document.all("oMenu");
         x = event.clientX + document.documentElement.scrollLeft +document.body.scrollLeft - 5;
         y = event.clientY + document.documentElement.scrollTop + document.body.scrollTop-5;
         if (event.clientY + 72 > document.body.clientHeight) { y-=62 } else { y-=2 }
         el.innerHTML = '<div style="color:#000;" class=menuItem onmouseout="this.className=\'menuItem\';" onmouseover="this.className=\'menuItem2\';" onclick="this.disabled = true;attack('+n+');closeMenu(event);"> Напасть </div>';

         el.style.left = x + "px";
         el.style.top  = y + "px";
         el.style.visibility = "visible";
}
function Opendialog(n){
         var el, x, y;
         el = document.all("oMenu");
         x = event.clientX + document.documentElement.scrollLeft +document.body.scrollLeft - 5;
         y = event.clientY + document.documentElement.scrollTop + document.body.scrollTop-5;
         if (event.clientY + 72 > document.body.clientHeight) { y-=62 } else { y-=2 }
         el.innerHTML = '<div style="color:#000" class=menuItem onmouseout="this.className=\'menuItem\';" onmouseover="this.className=\'menuItem2\';" onclick="this.disabled = true;attack('+n+');"> &nbsp;Напасть </div><div style="color:#000" class=menuItem onmouseout="this.className=\'menuItem\';" onmouseover="this.className=\'menuItem2\';" onclick="this.disabled = true;dialog();"> Говарить </div>';
		

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
<?}?>

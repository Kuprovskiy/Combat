<?
session_start();
if ($_SESSION['uid'] == null) header("Location: index.php");
include "connect.php";
$user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
$al = mysql_fetch_array(mq("SELECT * FROM `aligns` WHERE `vip` = '5' LIMIT 1;"));
include "functions.php";
if ($user['vip']!= 5) die;
if ($user['battle'] != 0) { header('location: fbattle.php');die();}
?>
<HTML>
<HEAD>
<script LANGUAGE='JavaScript'> 
document.ondragstart = test;
document.oncontextmenu = test;
function test() {
 return false
}
</SCRIPT>
<link rel=stylesheet type="text/css" href="i/maina.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<style>
.row {
cursor:pointer;
}
</style>
<script src="js/lib/jquery.js" type="text/javascript"></script>
<script src="js/lib/jquery.bgiframe.js" type="text/javascript"></script>
<script src="js/lib/jquery.dimensions.js" type="text/javascript"></script>
<script src="js/jquery.tooltip.js" type="text/javascript"></script>
<SCRIPT>
$(function() {
$('img').tooltip({
showURL: false
});
});
$(function() {
$('span').tooltip({
showURL: false
});
});
</SCRIPT>
<script language="javascript" type="text/javascript">
function g(e){
with(e.nextSibling.nextSibling.style){
display = display=="none"?"block":"none";
}
}
</script>
<script type="text/javascript">
function show(ele) {
var srcElement = document.getElementById(ele);
if(srcElement != null) {
if(srcElement.style.display == "block") {
srcElement.style.display= 'none';
} else {
srcElement.style.display='block';
}
}
}
</script>
<SCRIPT>
var Hint3Name = '';
function runmagic1(title, magic, name){
document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=B1A993><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><BIG><B><IMG src="/i/clear.gif" width=13 height=13>&nbsp;</td></tr><tr><td colspan=2>'+
'<form action="vips.php" method=POST><table width=100% cellspacing=0 cellpadding=2 bgcolor=DDD5BF><tr><td colspan=2><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD align=left><INPUT TYPE=text NAME="'+name+'">'+
'</TD><TD width=120><INPUT TYPE="image" src="/i/b__ok.gif"></TD></TR></TABLE></FORM></td></tr></table>';
document.all("hint3").style.visibility = "visible";
document.all("hint3").style.left = 500;
document.all("hint3").style.top = 100;
document.all(name).focus();
Hint3Name = name;
}
function closehint3(){
document.all("hint3").style.visibility="hidden";
Hint3Name='';
}
</SCRIPT>
<body leftmargin=5 topmargin=5 marginwidth=0 marginheight=0 bgcolor=#e2e0e0 >
<table align=right><tr><td><INPUT TYPE="button" class=btn onclick="location.href='vips.php';" value="Обновить" title="Обновить"> 
<INPUT TYPE="button" class=btn onclick="location.href='main.php';" value="Вернуться" title="Вернуться"></table>
<h3>ViP Панель Персонажа <?=$user['login']?>!</h3>
</HEAD>
<?
if($_GET['dropst']) {
$travma = mysql_fetch_array(mq("SELECT * FROM `effects` WHERE `owner` = ".$user['id']." and (`type`=11 or `type`=12 or `type`=13 or `type`=14) order by `type` desc limit 1;"));
if ($travma['type']) {
$mywarn="Невозможно сбрасывать статы находясь в травме!";
} else {
undressall($user['id']);
$user1 = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$user['id']}' LIMIT 1;"));
if ($user['vip']=1) {
include "config/expstats.php";
if ($user['vip']=1) {
mq("delete from effects where (sila<>0 or lovk<>0 or inta<>0 or vinos<>0 or intel<>0) and owner='".$_SESSION['uid']."'");
if (!mq("UPDATE `users` SET `sila`='3',`lovk`='3',`inta`='3',`mudra`='0',`mana`='0',`maxmana`='0',`master` 
= noj+mec+topor+dubina+mfire+mwater+mair+mearth+mlight+mgray+mdark+master,noj=0,mec=0,topor=0,dubina=0,mfire=0,mwater=0,mair=0,mearth=0,mlight=0,mgray=0,mdark=0,`vinos`
='".(3+$user['level'])."',`hp`=`maxhp`,`maxhp`='".(6*$user['vinos'])."',`intel`='0',`spirit`='0',`sexy`='0',`will`='0',`freedom`='0',`god`='0',`stats` = ".($expstats[$user['nextup']])."
 WHERE `id`= ".$user['id'].";\n")) $errdo=0;
mq("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\ перераспределил статы,',1,'".time()."');");
$mywarn="Все прошло удачно. Вы можете перераспределить статы.";
} else $mywarn="Произошла ошибка! Обратитесь к палладинам."; } else {
}
}
}
if ($travma['type']) {
}else {
$svstats=$user['sila'] + $user['lovk'] + $user['inta'] + $user['vinos'] + $user['intel'] + $user['mudra'] - 12 - $user['level'];
//echo "<a href=\"#\" onclick=\"javascript:if (confirm('Использовать сейчас?')){ location.href='vips.php?dropst=1';}\">Сбросить все статы и умения персонажа</a><BR>";
}
?>
<?
if($_GET['redir']) {
$redir = trim($_GET['redir']);
if (preg_match('/^(http:\/\/|https:\/\/)?([^\.\/]+\.)*([a-zA-Z0-9])([a-zA-Z0-9-]*)\.([a-zA-Z]{2,4})(\/.*)?$/i',$redir)){
if($user['ekr']>=0) {
mq("UPDATE `users` SET `redirect`='".mysql_real_escape_string($redir)."' WHERE `id`= '".mysql_real_escape_string($user['id'])."';");
echo"<font color=red>Редирект установлен!</font><br>";
}else{
echo"<font color=red>Введеный Вами текст не является ссылкой!</font><br>";
}
}else{
echo '<font color=red>Введеный Вами текст не является ссылкой!</font><br>';
}
}
if($_GET['delred']) {
mq("UPDATE `users` SET `redirect`='' WHERE `id`= '".mysql_real_escape_string($user['id'])."';");
echo"<font color=red>Редирект удален!</font><br>";
}
?>
<FORM action="vips.php">
<a href="#" onClick="g(this)">Установить редирект</a><br><div  style="display:none"><small></small><BR><input type=text size=20 name=redir></td><TD> 
<input type=submit name=redirect style="width:75px;" value=  "Установить"></td></tR></div>
<?
if($user['redirect']) {
echo"<br><a href=\"#\" onclick=\"javascript:if (confirm('Убрать редирект?')){ location.href='vips.php?delred=1';}\">Снять редирект</a><BR>";
}
?>
</form> 
<?
$res = mysql_fetch_array(mq("SELECT `id` FROM `users` WHERE `login` = '{$_POST['new_nick']}'"));
if (strlen($_POST['new_nick'])<3 or strlen($_POST['new_nick'])>15){echo"";}
elseif(!ereg("^[a-zA-Zа-яА-Я][a-zA-Zа-яА-Я_ -]+[a-zA-Zа-яА-Я]$",$_POST['new_nick'])){echo"Вы использовали в логине запрещенные символы..";}
elseif(preg_match("/__/",$_POST['new_nick'])){echo"Вы использовали  запрещенные символы.";} 
elseif(preg_match("/--/",$_POST['new_nick'])){echo"Вы использовали запрещенные символы.";} 
elseif(preg_match("/  /",$_POST['new_nick'])) {echo"Вы использовали запрещенные символы.";} 
elseif(preg_match("/(.)\\1\\1\\1/",$_POST['new_nick'])){echo"Запрещено использование трех и более одинаковых символов подряд.";}
elseif(preg_match("#(\_|\-|\ ){2,}#",$_POST['new_nick'])){echo"Запрещено использовать два разделительных символа подряд.";}
elseif($res['id'] != NULL){echo"ник {$_POST['new_nick']} уже занят, выберите другой";}
else{
if ($_POST['old_nick'] && $_POST['new_nick']) {
$log_his=mysql_fetch_array(mq("SELECT loginhistory from users where login='{$_POST['old_nick']}'"));	
if($log_his[0]==""){$loghistory=$_POST['old_nick']."||".date("d.m.Y H:i:s");}else{$loghistory=$log_his[0].";".$_POST['old_nick']."||".date("d.m.Y H:i:s");}
if(mq("update `users` set login='{$_POST['new_nick']}', loginhistory='{$loghistory}' WHERE `login` = '{$_POST['old_nick']}' AND `vip`='1' LIMIT 1;")){
echo "<font color=red>ник успешно изменена=) ...</font><br>";
}else{ 
echo "<font color=red>Произошла ошибка!</font><br>";
}
}	
}
?>
<a href="#" onClick="g(this)">Сменить ник</a><br>
<div  style="display:none"><br>											
<form method=post action="vips.php">
Старый ник: <input type=text name='old_nick'> <br>
Новый ник:   <input type=text name='new_nick'> 
<input type=submit value='Сменить ник'>
<input type=hidden name=angel_pan value="nickname"></form>
</div>
<br>
<a href="#" onClick="g(this)">Сменить образ</a>
<div  style="display:none"><br>
<?
if ($user['sex']==1) {echo"
<td><a href=\"?edit=1&obraz=vip1\"><img src=\"/i/shadow/1/vip1.gif\"></a></td> 
<td><a href=\"?edit=1&obraz=vip2\"><img src=\"/i/shadow/1/vip2.gif\"></a></td>
<td><a href=\"?edit=1&obraz=vip3\"><img src=\"/i/shadow/1/vip3.gif\"></a></td>
<td><a href=\"?edit=1&obraz=vip4\"><img src=\"/i/shadow/1/vip4.gif\"></a></td>
<td><a href=\"?edit=1&obraz=vip5\"><img src=\"/i/shadow/1/vip5.gif\"></a></td>
<td><a href=\"?edit=1&obraz=vip6\"><img src=\"/i/shadow/1/vip6.gif\"></a></td>
<td><a href=\"?edit=1&obraz=vip7\"><img src=\"/i/shadow/1/vip7.gif\"></a></td>
<td><a href=\"?edit=1&obraz=vip8\"><img src=\"/i/shadow/1/vip8.gif\"></a></td>";
if($_GET['obraz']==vip1){
mq("UPDATE `users` SET `shadow` = 'vip1.gif' WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
}
if($_GET['obraz']==vip2){
mq("UPDATE `users` SET `shadow` = 'vip2.gif' WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
}
if($_GET['obraz']==vip3){
mq("UPDATE `users` SET `shadow` = 'vip3.gif' WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
}
if($_GET['obraz']=='vip4'){
mq("UPDATE `users` SET `shadow` = 'vip4.gif' WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
}
if($_GET['obraz']=='vip5'){
mq("UPDATE `users` SET `shadow` = 'vip5.gif' WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
}
if($_GET['obraz']=='vip6'){
mq("UPDATE `users` SET `shadow` = 'vip6.gif' WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
}
if($_GET['obraz']==vip7){
mq("UPDATE `users` SET `shadow` = 'vip7.gif' WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
}
if($_GET['obraz']==vip8){
mq("UPDATE `users` SET `shadow` = 'vip8.gif' WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
}
}
?>
<?
if ($user['sex']==0) {echo"
<td><a href=\"?edit=0&obrazs=vip1\"><img src=\"/i/shadow/0/vip1.gif\"></a></td> 
<td><a href=\"?edit=0&obrazs=vip2\"><img src=\"/i/shadow/0/vip2.gif\"></a></td>
<td><a href=\"?edit=0&obrazs=vip3\"><img src=\"/i/shadow/0/vip3.gif\"></a></td>
<td><a href=\"?edit=0&obrazs=vip4\"><img src=\"/i/shadow/0/vip4.gif\"></a></td>
<td><a href=\"?edit=0&obrazs=vip5\"><img src=\"/i/shadow/0/vip5.gif\"></a></td>
<td><a href=\"?edit=0&obrazs=vip6\"><img src=\"/i/shadow/0/vip6.gif\"></a></td>
<td><a href=\"?edit=0&obrazs=vip7\"><img src=\"/i/shadow/0/vip7.gif\"></a></td>
<td><a href=\"?edit=0&obrazs=vip8\"><img src=\"/i/shadow/0/vip8.gif\"></a></td>";
if($_GET['obrazs']==vip1){
mq("UPDATE `users` SET `shadow` = 'vip1.gif' WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
}
if($_GET['obrazs']==vip2){
mq("UPDATE `users` SET `shadow` = 'vip2.gif' WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
}
if($_GET['obrazs']==vip3){
mq("UPDATE `users` SET `shadow` = 'vip3.gif' WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
}
if($_GET['obrazs']=='vip4'){
mq("UPDATE `users` SET `shadow` = 'vip4.gif' WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
}
if($_GET['obrazs']=='vip5'){
mq("UPDATE `users` SET `shadow` = 'vip5.gif' WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
}
if($_GET['obrazs']=='vip6'){
mq("UPDATE `users` SET `shadow` = 'vip6.gif' WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
}
if($_GET['obrazs']==vip7){
mq("UPDATE `users` SET `shadow` = 'vip7.gif' WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
}
if($_GET['obrazs']==vip8){
mq("UPDATE `users` SET `shadow` = 'vip8.gif' WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
}
}
?>
</div>
<br>
<br>
<?
if ($_GET['delobraz'] == 1){
mq("update users set shadow='0.gif' WHERE `id`= '".mysql_real_escape_string($user['id'])."';");
}	     
?>
<a href="#" onClick="if (confirm('Внимание! Образ будет утерян. Желаете продолжить?')) window.location='vips.php?delobraz=1'">Удалить образ</a>
<br>
<br>
<a href="#" onClick="g(this)">Заклинания</a>
<div  style="display:none"><br>
<?
function imp ($array) {
foreach($array as $k => $v) {
$str .= $k.";".$v.";";
}
return $str;
}
function expa ($str) {
$array = explode(";",$str);
for ($i = 0; $i<=count($array)-2;$i=$i+2) {
$rarray[$array[$i]] = $array[$i+1];
}
return $rarray;
}
echo "<div align=center id=hint3></div>";
$moj = expa($al['accses']);
if(!$_POST['use']){$_POST['use']=$_GET['use'];}
if(in_array($_POST['use'],array_keys($moj))) {
$i=mqfa1("select id from users where login='$_POST[target]'");
if (!$i) {
$i=mqfa1("select id from allusers where login='$_POST[target]'");
if ($i) restoreuser($i);
}
switch($_POST['use']) {
case "act_alls":
include("./magic/act_alls.php");
break;
case "a_ogons":
include("./magic/a_ogons.php");
break;
case "a_vodas":
include("./magic/a_vodas.php");
break;
case "a_vozduhs":
include("./magic/a_vozduhs.php");
break;
case "a_zemlyas":
include("./magic/a_zemlyas.php");
break;
case "iz_ogons":
include("./magic/iz_ogons.php");
break;
case "iz_vodas":
include("./magic/iz_vodas.php");
break;
case "iz_vozduhs":
include("./magic/iz_vozduhs.php");
break;
case "iz_zemlyas":
include("./magic/iz_zemlyas.php");
break;
case "devastate":
include("./magic/devastate.php");
break;
case "defence":
include("./magic/defence.php");
break;
case "hidden":
include("./magic/hidden.php");
break;
case "attacks":
include("./magic/attacks.php");
break;
case "battacks":
include("./magic/battacks.php");
break;
case "lifethirsts":
include("./magic/lifethirsts.php");
break;
case "magmfs1":
include("./magic/magmfs1.php");
break;
case "magmfs2":
include("./magic/magmfs2.php");
break;
case "magmfs3":
include("./magic/magmfs3.php");
break;
case "magmfs4":
include("./magic/magmfs4.php");
break;
case "magmfs":
include("./magic/magmfs.php");
break;
case "magmfss":
include("./magic/magmfss.php");
break;
}
}
echo "<table>";
echo "<tr><td align=center><br><br>";
foreach($moj as $k => $v) {
switch($k) {
//case "act_alls": $script_name="runmagic1"; $magic_name="Вылечить от травм"; break;
//case "a_ogons": $script_name="runmagic1"; $magic_name="Астрал стихий (огонь)"; break;
//case "iz_ogons": $script_name="runmagic1"; $magic_name="Изгнание астрала стихий (огонь)"; break;
//case "a_vodas": $script_name="runmagic1"; $magic_name="Астрал стихий (вода)"; break;
//case "iz_vodas": $script_name="runmagic1"; $magic_name="Изгнание астрала стихий (вода)"; break;
//case "a_vozduhs": $script_name="runmagic1"; $magic_name="Астрал стихий (воздух)"; break;
//case "iz_vozduhs": $script_name="runmagic1"; $magic_name="Изгнание астрала стихий (воздух)"; break;
//case "a_zemlyas": $script_name="runmagic1"; $magic_name="Астрал стихий (земля)"; break;
//case "iz_zemlyas": $script_name="runmagic1"; $magic_name="Изгнание астрала стихий (земля)"; break;
//case "hidden": $script_name="runmagic1"; $magic_name="Заклятие невидимости"; break;
//case "lifethirsts": $script_name="runmagic1"; $magic_name="Наложить Жажду Жизни +6"; break;
//case "magmfs": $script_name="runmagic1"; $magic_name="Наложить Неуязвимость Оружию"; break;
//case "magmfss": $script_name="runmagic1"; $magic_name="Наложить Неуязвимость Стихиям"; break;
//case "magmfs1": $script_name="runmagic1"; $magic_name="Наложить Защиту от Земли"; break;
//case "magmfs2": $script_name="runmagic1"; $magic_name="Наложить Защиту от Воздуха"; break;
//case "magmfs3": $script_name="runmagic1"; $magic_name="Наложить Защиту от Воды"; break;
//case "magmfs4": $script_name="runmagic1"; $magic_name="Наложить Защиту от Огня"; break;
case "attacks": $script_name="runmagic1"; $magic_name="Нападение"; break;
case "battacks": $script_name="runmagic1"; $magic_name="Кровавое нападение"; break;
case "defence": $script_name="runmagic1"; $magic_name="Наложить Защиту от Оружия"; break;
case "devastate": $script_name="runmagic1"; $magic_name="Наложить Сокрушение"; break;
}
if($k=="act_alls"){echo"<a onclick=\"if (confirm('Вы уверены?')) window.location='vips.php?use=ct_alls'\" href='#'><img src='i/magic/ct_alls.gif' title='Вылечить от травм'></a> ";}

elseif($k=="lifethirsts"){echo"<a onclick=\"if (confirm('Вы уверены?')) window.location='vips.php?use=lifethirsts'\" href='#'><img src='i/magic/lifethirsts.gif' title='Наложить Жажду Жизни +6'></a> ";}

elseif($k=="magmfs"){echo"<a onclick=\"if (confirm('Вы уверены?')) window.location='vips.php?use=magmfs'\" href='#'><img src='i/magic/magmfs.gif' title='Наложить Неуязвимость Оружию'></a> ";}

elseif($k=="magmfss"){echo"<a onclick=\"if (confirm('Вы уверены?')) window.location='vips.php?use=magmfss'\" href='#'><img src='i/magic/magmfss.gif' title='Наложить Неуязвимость Стихиям'></a> ";}

elseif($k=="magmfs1"){echo"<a onclick=\"if (confirm('Вы уверены?')) window.location='vips.php?use=magmfs1'\" href='#'><img src='i/magic/magmfs1.gif' title='Наложить Защиту от Земли'></a> ";}

elseif($k=="magmfs2"){echo"<a onclick=\"if (confirm('Вы уверены?')) window.location='vips.php?use=magmfs2'\" href='#'><img src='i/magic/magmfs2.gif' title='Защиту от Воздуха'></a> ";}

elseif($k=="magmfs3"){echo"<a onclick=\"if (confirm('Вы уверены?')) window.location='vips.php?use=magmfs3'\" href='#'><img src='i/magic/magmfs3.gif' title='Защиту от Воды'></a> ";}

elseif($k=="magmfs4"){echo"<a onclick=\"if (confirm('Вы уверены?')) window.location='vips.php?use=magmfs4'\" href='#'><img src='i/magic/magmfs4.gif' title='Защиту от Огня'></a> ";}

elseif ($script_name) {print "<a onclick=\"javascript:$script_name('$magic_name','$k','target','target1') \" href='#'><img src='i/magic/".$k.".gif' title='".$magic_name."'></a>";}
}
echo "</td></tr></table>";
?>
</form>
</body>
</div>
</html>
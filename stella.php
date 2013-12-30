<?
session_start();
include "connect.php";
?>
<?
if ($_SESSION['uid'] == null) header("Location: index.php");
$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
if ($user['room'] != 100100) { header('location: main.php'); die(); }
if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }
if ($user['in_tower'] == 1) { header('Location: towerin.php'); die(); }
?>
<HTML>
<HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<STYLE> 
.pH3			{ COLOR: #8f0000;  FONT-FAMILY: Arial;  FONT-SIZE: 12pt;  FONT-WEIGHT: bold; }
</STYLE>



</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=e2e0e0>


<link href="css/design6.css" rel="stylesheet" type="text/css">
<LINK REL=StyleSheet HREF='css/style.css' TYPE='text/css'>


<SCRIPT src="js/j.js" language="javascript"></SCRIPT>
<script src="js/tooltip.js" language="javascript"></script>
<div id=hint4 class=ahint></div>
 

 
<td width=280 valign=top><TABLE cellspacing=0 cellpadding=0><TD width=100%>&nbsp;</TD><TD><HTML>
<table  border="0" cellpadding="0" cellspacing="0">
<FORM action="city.php" method=GET><td align=right>
<INPUT TYPE="submit" value="Вернуться" name="cp"></td></tr>
<td>
 
 
</td>
<td>
 
<TABLE height=15 border="0" cellspacing="0" cellpadding="0">

</TABLE>
 
 
<table  border="0" cellspacing="0" cellpadding="0">
<tr>
<td nowrap="nowrap" id="moveto">
<table width="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#DEDEDE">
 

</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px; white-space: nowrap;"></div>
<script language="javascript" type="text/javascript"> 
var progressEnd = 64;		// set to number of progress <span>'s.
var progressColor = '#00CC00';	// set to progress bar color
var mtime = parseInt('<?=$vrme?>');
if (!mtime || mtime<=0) {mtime=0;}
var progressInterval = Math.round(mtime*1000/progressEnd);	// set to time between updates (milli-seconds)
var is_accessible = true;
var progressAt = progressEnd;
var progressTimer;
function progress_clear() {
progressAt = 1;
is_accessible = false;
set_moveto(true);
}
function progress_update() {
progressAt++;
//if (progressAt > progressEnd) progress_clear();
if (progressAt > progressEnd) {
is_accessible = true;
if (window.solo_store && solo_store) { solo(solo_store, ""); } // go to stored
set_moveto(false);
} else {
if( !( progressAt % 2 ) )
document.getElementById('MoveLine').style.left = progressAt - 64;
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
/*	progressColor = color;
for (var i = 1; i <= progressAt; i++) {
document.getElementById('progress'+i).style.backgroundColor = progressColor;
}*/
}
if (mtime>0) {
progress_clear();
progress_update();
}
</script>
</HTML>
</TD></TABLE>

</table>

<BR>
<H4><center> Голосование </center> </H4>
<BR>
 
 
<?
$st = mysql_query("SELECT * FROM `stella` WHERE `status`='0' OR  `status`='1'");
$stel = mysql_fetch_array($st);

if($_POST['gol'] and $stel['status']==0 and $user['level']>=$stel['minlevel'] and $user['golos']>0){

if($_POST['golos']){mysql_query("UPDATE `stella` SET `g".$_POST['golos']."`=`g".$_POST['golos']."`+1 WHERE `status`='0'");}
mysql_query("UPDATE `users` SET `golos`=`golos`-1 WHERE `id`='".$user['id']."'");
$user['golos']=$user['golos']-1;
}
if($user['align']==2.5 and $_POST['clock']){
mysql_query("UPDATE `stella` SET `status`='1' WHERE `status`='0'");
}
if($user['align']==2.5 and $_POST['new']){
mysql_query("UPDATE `stella` SET `status`='3' WHERE `status`='0'");
mysql_query("INSERT INTO `stella` (glava,v1,v2,v3,v4,v5,v6,minlevel)values('".$_POST['glava']."','".$_POST['v1']."','".$_POST['v2']."','".$_POST['v3']."','".$_POST['v4']."','".$_POST['v5']."','".$_POST['v6']."','".$_POST['minlevel']."')");
mysql_query("UPDATE `users` SET `golos`='1'");
}

$st = mysql_query("SELECT * FROM `stella` WHERE `status`='0' OR  `status`='1'");
$stel = mysql_fetch_array($st);

$all_golos = $stel['g1']+$stel['g2']+$stel['g3']+$stel['g4']+$stel['g5']+$stel['g6'];
if($all_golos>0){
$p1 = floor(100/$all_golos*$stel['g1']);
$p2 = floor(100/$all_golos*$stel['g2']);
$p3 = floor(100/$all_golos*$stel['g3']);
$p4 = floor(100/$all_golos*$stel['g4']);
$p5 = floor(100/$all_golos*$stel['g5']);
$p6 = floor(100/$all_golos*$stel['g6']);
}


?>
<TABLE width=98% align=center><TD>
<FIELDSET style='padding: 5,5,5,5'><LEGEND><H4> <?=$stel['glava']?> </H4> </LEGEND>
<form action="" method="post"> 
&nbsp;&nbsp;<B style="font-size:12; color:#000000;"><?=$stel['v1']?></B> 
<? if($user['golos']>0 and $stel['status']==0){ ?>
<input name="golos" type="radio" value="1"><BR>
<? }else{ ?>
 <font style="font-size:12; color:#000000;">(<?=$p1?>%)</font><BR>
<? }?>

&nbsp;&nbsp;<B style="font-size:12; color:#000000;"><?=$stel['v2']?></B>  

<? if($user['golos']>0 and $stel['status']==0){ ?>
<input name="golos" type="radio" value="2"><BR>
<? }else{ ?>
 <font style="font-size:12; color:#000000;">(<?=$p2?>%)</font><BR>
<? }?>

&nbsp;&nbsp;<B style="font-size:12; color:#000000;"><?=$stel['v3']?></B>  

<? if($user['golos']>0 and $stel['status']==0){ ?>
<input name="golos" type="radio" value="3"><BR>
<? }else{ ?>
 <font style="font-size:12; color:#000000;">(<?=$p3?>%)</font><BR>
<? }?>

&nbsp;&nbsp;<B style="font-size:12; color:#000000;"><?=$stel['v4']?></B>  

<? if($user['golos']>0 and $stel['status']==0){ ?>
<input name="golos" type="radio" value="4"><BR>
<? }else{ ?>
 <font style="font-size:12; color:#000000;">(<?=$p4?>%)</font><BR>
<? }?>

&nbsp;&nbsp;<B style="font-size:12; color:#000000;"><?=$stel['v5']?></B> 

<? if($user['golos']>0 and $stel['status']==0){ ?>
<input name="golos" type="radio" value="5"><BR>
<? }else{ ?>
 <font style="font-size:12; color:#000000;">(<?=$p5?>%)</font><BR>
<? }?>
 
&nbsp;&nbsp;<B style="font-size:12; color:#000000;"><?=$stel['v6']?></B> 

<? if($user['golos']>0 and $stel['status']==0){ ?>
<input name="golos" type="radio" value="6"><BR>
<? }else{ ?>
 <font style="font-size:12; color:#000000;">(<?=$p6?>%)</font><BR>
<? }?>
<? if($user['golos']>0 and $stel['status']==0){ ?>
<input name="gol" type="submit" value="Голосовать"><BR>
<? }?>
</form>
<BR>
<BR>
</FIELDSET>
</TD></TR></TABLE>
</div>
</FORM>
<TABLE width=100%>
<TR><TD valign=top>
<?
$all_golos = $stel['g1']+$stel['g2']+$stel['g3']+$stel['g4']+$stel['g5']+$stel['g6'];
if($stel['status']==0){
$statu="Голосование активно";}
else if($stel['status']==1){
$statu="Голосование окончено";}
else {
$statu="Голосование закрыто";}
?>
<font style="font-size:12; color:#000000;">Всего голосов: <?=$all_golos?><BR>
Статус голосования: <B><?=$statu?></B><BR>
Минимальный уровень: <?=$stel['minlevel']?><BR>
Можете голосовать раз: <?=$user['golos']?><BR></font>
</TD></TR>
</TABLE>
<BR><BR>
<!--Голосовать имеют право лишь лица достигшие указанного уровня, родившиеся в городе, где проводится голосование.
<BR><A href='vote.php?archive=-1'>Архив</A>-->
<?
if($user['align']==2.5){
echo"<form action='' method='post'>
<input name='clock' type='submit' value='Закрыть голосование'>
</form><br>
<br>";
echo'<form action="" method="post">

<input name="glava" type="text" value="вопрос">
<input name="v1" type="text" value="ответ">
<input name="v2" type="text" value="ответ">
<input name="v3" type="text" value="ответ">
<input name="v4" type="text" value="ответ">
<input name="v5" type="text" value="ответ">
<input name="v6" type="text" value="ответ">
<input name="minlevel" type="text" value="мин.левел">
<input name="new" type="submit" value="Новое голосование">
</form>';
}
?>

	</td>
  </tr>
</table>

</BODY>
</HTML>

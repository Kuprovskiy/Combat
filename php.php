<?php
ob_start("ob_gzhandler");
session_start();
if ($_SESSION['uid'] == null) header("Location: index.php");
include "connect.php";
$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
$al = mysql_fetch_assoc(mysql_query("SELECT * FROM `aligns` WHERE `align` = '{$user['align']}' LIMIT 1;"));
include "functions.php";
header("Cache-Control: no-cache");
if ($user['align']<2 or $user['align']==3 || $user['id']>99999) header("Location: index.php");
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
<title>�������� �������</title>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
</HEAD>
<BODY leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=e2e0e0>
<table align=right><tr><td><INPUT TYPE="button" onClick="location.href='main.php';" value="���������" title="���������"></table>
<table align=right><tr><td><INPUT TYPE="button" onClick="location.href='php.php';" value="��������" title="��������"></table>
<h4>�������� �������</h4>
<?
$la = sys_getloadavg();
$la[0]=$la[0]/4;
$la[1]=$la[1]/4;
$la[2]=$la[2]/4;
?>
<?
echo "<BR><B>�� 1 �����:</B> ".($la[0]*100)."% ";
if ($la[0] < 0.16) {
echo "<font color=green>������</font>";
} elseif ($la[0] < 0.25) {
echo "<font color=orange>�������</font>";
} elseif ($la[0] > 0.25) {
echo "<font color=red>�������</font>";
}
echo "<BR><B>�� 5 �����:</B> ".($la[1]*100)."% ";
if ($la[1] < 0.16) {
echo "<font color=green>������</font>";
} elseif ($la[1] < 0.25) {
echo "<font color=orange>�������</font>";
} elseif ($la[1] > 0.25) {
echo "<font color=red>�������</font>";
}
echo "<BR><B>�� 15 �����:</B> ".($la[2]*100)."% ";
if ($la[2] < 0.16) {
echo "<font color=green>������</font>";
} elseif ($la[2] < 0.25) {
echo "<font color=orange>�������</font>";
} elseif ($la[2] > 0.25) {
echo "<font color=red>�������</font>";
}
$online = mysql_query("select * from `online`  WHERE `real_time` >= ".(time()-60).";");
?>
<br>
<br>������ <B><?=mysql_num_rows($online)?></B> ���.
<br>
<br><?$num = mysql_num_rows(mysql_query("SELECT `id` FROM `users`"));echo"�����   <B>".$num."</B> ���.";?>
<?php
if (!$_POST['dlogs']) {$_POST['dlogs']=date("d.m.y");}
echo '<TABLE><TR><TD colspan=3><FORM METHOD=POST ACTION=php.php>
</tr><tr><td><FORM METHOD=POST ACTION=php.php><INPUT TYPE=hidden NAME=dfilter value="'.$_POST['dfilter'].'">
<INPUT TYPE=hidden NAME=dlogs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['dlogs'],3,2), substr($_POST['dlogs'],0,2)-1, "20".substr($_POST['dlogs'],6,2))).'">
<TD><FORM METHOD=POST ACTION=php.php><INPUT TYPE=hidden NAME=dlogs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['dlogs'],3,2), substr($_POST['dlogs'],0,2)+1, "20".substr($_POST['dlogs'],6,2))).'">
<INPUT TYPE=hidden NAME=dfilter value="'.$_POST['dfilter'].'"> </form></TD>
</TR></TABLE></form>';
$ddate33="20".substr($_POST['dlogs'],6,2)."-".substr($_POST['dlogs'],3,2)."-".substr($_POST['dlogs'],0,2)."";			
$res = mysql_fetch_array(mysql_query("select count(`id`) from `users` where `borntime` LIKE '".$ddate33." %';"));
echo "�� �������  <b>".$res[0]." </b>���.";
?>
<br>
<br><?$haos = mysql_num_rows(mysql_query("SELECT `align` FROM `users` WHERE `align` =4"));echo"� �����  <b> ".$haos." </b>���.";?>
<br><?$pris = mysql_num_rows(mysql_query("SELECT `prison` FROM `users` WHERE `prison` =1"));echo"� ���������  <b> ".$pris." </b>���.";?>
<br><?$put = mysql_num_rows(mysql_query("SELECT `type` FROM `effects` WHERE `type` =10"));echo"� ����  <b> ".$put." </b>���.";?>
<br><?$obe = mysql_num_rows(mysql_query("SELECT `type` FROM `effects` WHERE `type` =5"));echo"� ������������� <b> ".$obe." </b>���.";?>
<br><?$bl = mysql_num_rows(mysql_query("SELECT `block` FROM `users` WHERE `block` =1"));echo"� ����� <b>".$bl." </b>���.";?>
<br>
<br>������� ����� <b><?  echo " ".date("H:i:s");  ?></B>
<br>������� ����  <b><?  echo " ".date("d.m.y");  ?></B>
<br><br>
<? include "mail_ru.php"; ?>
</BODY>
</HTML>
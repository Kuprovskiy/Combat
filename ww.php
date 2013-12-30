<?php
	session_start();
	if ($_SESSION['uid'] == null) header("Location: index.php");
	include "connect.php";
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '".mysql_real_escape_string($_SESSION['uid'])."' LIMIT 1;"));
	include "functions.php";
	$al = mysql_fetch_assoc(mysql_query("SELECT * FROM `aligns` WHERE `align` = '".mysql_real_escape_string($user['align'])."' LIMIT 1;"));
	header("Cache-Control: no-cache");
	if ($user['align']<2 || $user['align']>3) header("Location: index.php");
                     //Скрипт by Cruel-World.Ru
?>
<?
if($_POST['cc']){
if(mysql_query("update `users` set m1='0'"))
if(mysql_query("update `users` set m2='0'"))
if(mysql_query("update `users` set m3='0'"))
if(mysql_query("update `users` set m4='0'"))
if(mysql_query("update `users` set m5='0'"))
if(mysql_query("update `users` set m6='0'"))
if(mysql_query("update `users` set m7='0'"))
if(mysql_query("update `users` set m8='0'"))
if(mysql_query("update `users` set m9='0'"))
if(mysql_query("update `users` set m10='0'"))
if(mysql_query("update `users` set m11='0'"))
if(mysql_query("update `users` set m12='0'"))
{echo" готово";}else {echo"Ошибочка";}
}
?>
<form action="ww.php" method="post">
<input name="cc" type="submit" value="Обнавить" />
</form>
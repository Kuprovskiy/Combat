<?php
ob_start("ob_gzhandler");
session_start();
if ($_SESSION['uid'] == null) header("Location: index.php");
include "connect.php";
$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
include "functions.php";
if ($user['room'] != 667) { header("Location: main.php");  die(); }
if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }
echo"
<table><td><IMG src=\"/i/bar.jpg\"></td><td width=\"100%\" valign=\"top\">
<HTML>
<HEAD>
<link rel=stylesheet type=\"text/css\" href=\"../i/main.css\">
<meta content=\"text/html; charset=windows-1251\" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<SCRIPT LANGUAGE=\"JavaScript\" SRC=\"../i/sl2.24.js\"></SCRIPT>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=#e2e0e0>
<SCRIPT src='../i/commoninf.js'></SCRIPT>
<div id=hint4 class=ahint></div>
";?>
</FORM>
</BODY>
</HTML>
<?
print "<h3>
Добро пожаловать, бухарик <SCRIPT>drwfl(\"".$user['login']."\",".$user['id'].",\"".$user['level']."\",'".$user['align']."',\"".$user['klan']."\")</SCRIPT></h3>";
echo '<FONT style="FONT-SIZE: 10pt; COLOR: red"><B><div id="rezultat"></div></B></FONT>';
echo '<center>Бар "Пьяный Админ" приветствует тебя.</center>';
$R_ONLINE = mysql_query("SELECT bar FROM users WHERE bar ='1'");
$xaos = 0;
while(mysql_fetch_array($R_ONLINE)){
$xaos++;
}
print "<br>Всего в баре: <b>$xaos</b> чел<BR>";
?>
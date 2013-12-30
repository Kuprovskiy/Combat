<?php
ob_start("ob_gzhandler");
	session_start();
	if ($_SESSION['uid'] == null) header("Location: index.php");
	include "connect.php";
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
	include "functions.php";
	if ($user['room'] != 666) { header("Location: main.php");  die(); }
	if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }

echo"
<table><td><IMG src=\"i/prison.jpg\"></td><td width=\"100%\" valign=\"top\">
<HTML><HEAD>
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

if ($user['prison']==0) {
  print" <BR><table width=\"148\" align=right border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#DEDEDE\"><tr>
                <td bgcolor=\"#D3D3D3\"><img src=\"img/links.gif\" width=\"7\" height=\"5\" /></td>
                <td bgcolor=\"#D3D3D3\" nowrap><a href=\"main.php?rnd=0.122974956635421&pathbkbk=1.100&path=8\" onclick=\"\" class=\"menutop\" title=\"Переход на центральную площадь\">Центральная площадь</a></td>
              </tr></table><BR><br>";
}
print "<center>Заточение - место покоя тех, кто был глуп и наивен.</center>";

$R_ONLINE = mysql_query("SELECT prison FROM users WHERE prison ='1'");
$xaos = 0;
        while(mysql_fetch_array($R_ONLINE)){
        $xaos++;
        }
print "<br>Всего в тюрьме: <b>$xaos</b> чел<BR>";

if ($user['prison']==1) {
	$effect = mysql_fetch_array(mysql_query("SELECT `time` FROM `effects` WHERE `owner` = '{$user['id']}' and `type` = '21' LIMIT 1;"));
	if ($effect['time']) {
		$eff=$effect['time'];
		$tt=time();
		$time_still=$eff-$tt;
		$tmp = floor($time_still/2592000);
	$id=0;
	if ($tmp > 0) {
		$id++;
		if ($id<3) {$out .= $tmp." мес. ";}
		$time_still = $time_still-$tmp*2592000;
	}
	$tmp = floor($time_still/604800);
	if ($tmp > 0) {
		$id++;
		if ($id<3) {$out .= $tmp." нед. ";}
		$time_still = $time_still-$tmp*604800;
	}
	$tmp = floor($time_still/86400);
	if ($tmp > 0) {
		$id++;
		if ($id<3) {$out .= $tmp." дн. ";}
		$time_still = $time_still-$tmp*86400;
	}
	$tmp = floor($time_still/3600);
	if ($tmp > 0) {
		$id++;
		if ($id<3) {$out .= $tmp." ч. ";}
		$time_still = $time_still-$tmp*3600;
	}
	$tmp = floor($time_still/60);
	if ($tmp > 0) {
		$id++;
		if ($id<3) {$out .= $tmp." мин. ";}
	}
		echo "<br>В заточении еще <i>$out</i>";
	}
}


?>
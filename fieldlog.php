<?php
  include "connect.php";	
  include "functions.php";	
  $_GET["log"]=(int)$_GET["log"];
  $tr = mqfa("SELECT * FROM `fieldlogs` WHERE `id` = '".$_GET['log']."'");
?>
<HTML>
	<HEAD>
		<link rel=stylesheet type="text/css" href="i/main.css">
		<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
		<META Http-Equiv=Cache-Control Content=no-cache>
		<meta http-equiv=PRAGMA content=NO-CACHE>
		<META Http-Equiv=Expires Content=0>
	</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=e2e0e0> <br>
  <?
  if ($tr["room"]==57) echo "<H3>Пещера кристаллов. Отчет о поединке.</H3>";
  echo $tr['log']?><BR>
</BODY>
</HTML>

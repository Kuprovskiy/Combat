<?php
session_start();
if ($_SESSION['uid'] == null) header("Location: index.php");
?>
<HTML>
<HEAD>
<link rel=stylesheet type="text/css" href="/i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
</HEAD>
<body bgcolor=e2e0e0 style="background-image: url(/i/dungeon.jpg);background-repeat:no-repeat;background-position:top right">
<div id=hint4 class=ahint></div>
<TABLE width=100%>
<TR><TD valign=top width=100%><center><font style="font-size:24px; color:#000033"><h3>Маленькая скамейка</h3></font></center>
<TD nowrap valign=top><HTML>
<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px; white-space: nowrap;"></div>
</HTML>
<BR><DIV align=right><INPUT style="font-size:12px;" type='button' onClick="location='/main.php?s=1'" value=Обновить>
<INPUT style="font-size:12px;" type='button' onClick="location='city.php?park=1'" value=Вернуться></DIV></TD>
</TR>
</TABLE>
</BODY>
</HTML>
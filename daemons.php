<?php
    session_start();
    if ($_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    include "functions.php";
    if ($user['room'] != 44) { header("Location: main.php");  die(); }
    if (@$_GET["attack"]) {
      include "questfuncs.php";
      battlewithbot(1796, "������ �����", "������ ������", "20", 1);
    }
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=#e2e0e0>
<?
  errorreport();
?>
    <TABLE border=0 width=100% cellspacing="0" cellpadding="0">
    <td align=right>
        <INPUT TYPE="button" value="���������" onclick="document.location.href='main.php?got=1&room=20'">
    </table>
<? if (1) { ?>
<table><tr><Td><center>
<img src="/i/camp.jpg"></center></td><td>
�������-�� ��� ������ �����. ��������� ��������� ��������� ����� �� ���� �� ������ ���� ���-�� ��� �����,
� ��� �����, ������� ��������� ������� � �����, ����� ����������� ������ � ����� ��������� �����������, ������� ��������� ������.</td></tr></table>
<? } elseif (0) { ?>
<table><tr><td>
<img src="/i/shadow/1/monctep.jpg">
</td><td>
<img src="/i/shadow/1/monctep.jpg">
</td><td><img src="/i/shadow/1/monctep.jpg">
</td><td style="padding-left:20px;padding-right:20px"><center><h4>������ �������. </h4></center><br>
������� ��������� ��� �� ������, ���������� ������� �������, � ����� ����� ����� ����� ����������� �� ����������.
�� ���� ������ �� ����� �����, ��� ����� ����� � �������, �����, ����� � ����!
<br><br><br>
<center><a href="daemons.php?attack=1">�������!!!</a></center>
</td></tr></table>
<? } else { ?>
<table><tr><Td><center>
<img src="/i/camp.jpg"></center></td><td>
��������� ��� �� ������: ��������� ������ � �������� ���� ���������� �������, �����, ����� � ����, 
������ ������ �� ����� �����, �������� �����, ����� ������ �� ������� ������!<br><br>
<center><a href="daemons.php?attack=1">����� � ������</a></center>
</td></tr></table>
<? } ?>
</BODY>
</HTML>
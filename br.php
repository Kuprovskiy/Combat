<?php


include "connect.php";
include "functions.php";
		

	if ($_GET['id']) {
		$us = " `id` = '".mysql_real_escape_string($_GET['id'])."' ";
	}	
	elseif ($_GET['login']) {
		$us = " `login` = '".mysql_real_escape_string($_GET['login'])."' ";
	}
	elseif(count($_GET)==1 && !is_numeric($_SERVER['QUERY_STRING']))	{
		$us = " `login` = '".mysql_real_escape_string($_SERVER['QUERY_STRING'])."' ";
	}
	else {
		$us = " `id` = '".mysql_real_escape_string($_SERVER['QUERY_STRING'])."' ";

	}
	$user8 = mysql_fetch_array(mysql_query("SELECT `id` FROM `users` WHERE {$us} LIMIT 1;"));
        nick99 ($user8['id']);
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE {$us} LIMIT 1;"));



		?>

<html><head>

<script LANGUAGE='JavaScript'>
document.ondragstart = test;
//������ �� ��������������
document.onselectstart = test;
//������ �� ��������� ��������� ��������
document.oncontextmenu = test;
//������ �� ��������� ������������ ����
function test() {
 return false
}
</SCRIPT>

<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="ru">
<TITLE>��������� ������</TITLE></HEAD><BODY text="#FFFFFF"><p><font color=black>
��������� ������: <pre>�������� <?=($_GET['login']?"\"".$_GET['login']."\"":"")?> �� ������...</pre>
<b><p><a href = "javascript:window.history.go(-1);">�����</b></a>
<HR>
<p align="right">(c) ���������� ���� .</a></p>

</body></html>
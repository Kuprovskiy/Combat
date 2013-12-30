<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<LINK href="/i/main.css" type=text/css rel=stylesheet>
<META http-equiv=Content-type content="text/html; charset=windows-1251">
</head>
<title>Востановление пароля на www.oldbk2.com</title>
<body bottomMargin=0 vLink=#333333 aLink=#000000 link=#000000 bgColor=#666666 leftMargin=0 topMargin=0 rightMargin=0 marginheight="0" marignwidth="0">
<div style='background-color:#636462; width:13%; float:left;'>&nbsp;</div>
<div style='float:left; text-align:justify; width:933px; FONT-SIZE: 10pt; FONT-FAMILY: Verdana, Arial, Helvetica, Tahoma, sans-serif; background-color:#F2E5B1; widh:100%;'>
<table style='font-size:12px; border:0px; margin:0px; padding:0px;' cellpadding=0 cellspacing=0 border=0>
<tr>
<td width=124px;><img src='/encicl/images/pict_1.jpg' width=126 height=243 /><td width=100% valign=top>
<br>
<?php
include "functions.php";
$browsers = get_browser();
switch ($browsers->browser){
case 'Chrome' :
$_GET['login']=iconv('utf-8', 'cp1251', $_GET['login']);
break;
case 'Safari' :
$_GET['login']=iconv('utf-8', 'cp1251', $_GET['login']);
break;
case 'Default Browser' : //Opera10
$_GET['login']=iconv('utf-8', 'cp1251', $_GET['login']);
break;
case 'Firefox' :
$_GET['login']=$_GET['login'];
break;
}
$realtime=mktime(date(H), date(i), date(s), date("m")  , date("d"), date("Y"));
$_GET['login']=strtolower($_GET['login']);
if ($_GET['newpass']!='' && $_GET['login']!='' && $_GET['timev']!='' && $realtime<=$_GET['timev']) {
include ("connect.php");
$sql=mysql_query("select * from confirmpasswd where login='".$_GET['login']."' and passwd='".$_GET['newpass']."' and date='".$_GET['timev']."' and active=1") or die("Ошибка обработки запроса.");
if (mysql_num_rows($sql)==0 or mysql_num_rows($sql)=='') die("Ссылка устарела!");
$sql=mysql_fetch_array($sql,MYSQL_ASSOC) or die("Ошибка обработки запроса!!");
mysql_query("update users set pass='".md5($_GET['newpass'])."' where login='".$sql['login']."'") or die("Ошибка обработки запроса!");
echo "<center>Пароль изменен. Не забывайте пароль.<br>Для входа в игру перейдите по сылке <a href='http://oldbk2.com/'>http://oldbk2.com/</a></center>";
@mysql_query("update confirmpasswd set active=0 where login='".$_GET['login']."' and passwd='".$_GET['newpass']."' and date='".$_GET['timev']."' and active=1");
}
else echo "Ссылка устарела.";
?>
</td>
<td width=107 align=right>
<img src='/encicl/images/paper1.gif' width=39 height=292 />
</table>
<div style='float:left; margin-left:-87px;'></div>
</div>
<div style='clear:both'></div><br>
</table>
</body>
</html>
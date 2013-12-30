<?
header ("Content-type: text/html; charset=UTF-8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//RU" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<LINK href="/i/main.css" type=text/css rel=stylesheet>
<META http-equiv=Content-type content="text/html; charset=utf-8">
<META http-equiv=Cache-Control content=no-cache>
<META http-equiv=PRAGMA content=NO-CACHE>
<META http-equiv=Expires content=0>
</head>
<title>Востановление пароля на userbk.ru</title>
<body bottomMargin=0 vLink=#333333 aLink=#000000 link=#000000 bgColor=#666666 leftMargin=0 topMargin=0 rightMargin=0 marginheight="0" marignwidth="0">
<script language="JavaScript">
function sendmailpassw(){
var loginP=document.getElementById('loginid').value;
if(loginP=='' || loginP.length>50){
alert('Введен некоректный login');
return false;
}
else document.sendmailid.submit();
}
</script>
<div style='background-color:#636462; width:13%; float:left;'>&nbsp;</div>
<div style='float:left; text-align:justify; width:933px; FONT-SIZE: 10pt; FONT-FAMILY: Verdana, Arial, Helvetica, Tahoma, sans-serif; background-color:#F2E5B1; widh:100%;'>
<table style='font-size:12px; border:0px; margin:0px; padding:0px;' cellpadding=0 cellspacing=0 border=0>
<tr>
<td width=124px;><img src='/encicl/images/pict_1.jpg' width=126 height=243 />
<td width=100% valign=top>			
<?php
IF (@$_POST['loginid']!='') {
include ("connect.php");	
$_POST['loginid']=iconv('utf-8', 'cp1251', $_POST['loginid']);
$_POST['loginid']=strtolower($_POST['loginid']);
$_POST['loginid']=mysql_escape_string($_POST['loginid']);
$sql=mysql_query("select * from users where LOWER(login)='".$_POST['loginid']."'");
$sql=mysql_fetch_array($sql, MYSQL_ASSOC);
$newpass=md5(md5(math.rand(-2000000,2000000).$sql['login']));
$newpass=substr($newpass,0,10);
$lasttime=mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
$ipclient=getenv("HTTP_X_FORWARDED_FOR");
if ($sql['login']!='' && mysql_query("insert into confirmpasswd(login,passwd,date,ip,active) values('".$sql['login']."','".$newpass."','".$lasttime."','".$ipclient."',1)")){
$headers  = "Mime-Version: 1.1 \r\n";
$headers .= "Date: ".date("r")." \r\n";
$headers .= "Content-type: text/html; charset=utf-8 \r\n";
$headers .= "From: Восстановление пароля Oldbk2 <support@uOldbk2.com>\r\n";
$headers = trim($headers);
$headers = stripslashes($headers);	
$aa='<html>
<head>
<title>Востановление пароля</title>
</head>
<body>
Добрый день '.iconv('cp1251', 'utf-8', $sql['realname']).'.<br>
Вами было запрошено востановление пароля c IP адреса - '.$ipclient.', если это были не Вы, просто удалите это письмо.<br>
<br>
------------------------------------------------------------------<br>
Ваш логин    | '.iconv('cp1251', 'utf-8', $sql['login']).'<br>
Новый пароль | '.$newpass.'<br>
------------------------------------------------------------------<br>
<br>
<br>
Для подтверждения нового пароля пройдите по ссылке ниже.<br>
<a href="http://oldbk2.com/confirmpassw.php?newpass='.$newpass.'&login='.iconv('cp1251', 'utf-8', $sql['login']).'&timev='.$lasttime.'">Востановление пароля</a>
<br>
<font color="blue">Если вы не восстановите пароль до <b>'.date("d-M-Y", $lasttime) .' 00:00</b>, ссылка будет неактивной.</font>
<br>
Отвечать на данное письмо не нужно.
</body>
</html>';
mail($sql['email'],"Востановление пароля на oldbk2.com, для пользователя - ".iconv('cp1251', 'utf-8', $sql['login']),$aa,$headers);
echo "<center><font color='blue' size='14'><h3>Пароль отправлен Вам на почту.</h3></font></center>";
}else{
echo "<center><h3>Сегодня пароль уже высылался или такой login отсутствует. <br>Проверьте почту</h3></center>";
die();
}
}
else {
?>
<center><h3>Форма востановления пароля</h3></center>
<br>
Для востановления пароля введите свой login и нажмине кнопку "отправить письмо".<br>
Письмо будет выслано на ваш email адрес, указанный Вами при регистрации.<br>
Востановливать пароль можно только раз в сутки.<br>
<form name='sendmailid' method="POST">
<label for='loginid'>Введите Ваш login </label><input type='text' value='<? echo @$_POST['loginid']; ?>' id='loginid' name='loginid'>
<input type="button" onClick="sendmailpassw()" value="Отправить письмо">
</form>	
<?php
}
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
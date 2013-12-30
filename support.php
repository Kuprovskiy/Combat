<?
session_start();
include"connect.php";
if ($_SESSION['uid'] == null) {print'<h2><font color=red>Поройдите авторизацию! иначе ваше Сообщение не будет доставлено';}
$p = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id`='{$_SESSION['uid']}'"));
?>
<script LANGUAGE='JavaScript'>
document.ondragstart = test;
//запрет на перетаскивание
//запрет на выделение элементов страницы
document.oncontextmenu = test;
//запрет на выведение контекстного меню
function test() {
 return false
}
</SCRIPT>

<pre></pre><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<link rel="icon" href="/i/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/i/favicon.ico" type="image/x-icon"> 
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Служба поддержки Бойцовского клуба - support</title>
<link href="/img/support/css/common.css?ver=1" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="/img/support/js/common.js?ver=1"></SCRIPT>
</head>
<body>
	<script type="text/javascript">
		l = {confirmCategory: "Пожалуйста, убедитесь что выбранная категория соответсвует теме сообщения. Сообщение с неправильной категорией не будут рассматриваться. Если всё верно - нажмите ОК. Иначе нажмите Отмена и выберите другую категорию. Выбранная категория: ",selectCategory: "Пожалуйста, уточните категорию"		}
	</script>
	<table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#f8f1d4" width="80%">
		
		<tr>
			<td>
		
		<table border="0" cellpadding="0" cellspacing="0" width=100%>
			<tr bgcolor="#242422">
				<td valign="bottom"><a href="/support.php"><img src="/img/support/logo.jpg" width="416" height="140" alt="Support" border="0"></a></td>
				<td valign="bottom" width="99%"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td align="right"><img src="/img/support/bg2.jpg"></td></tr><tr><td background="/img/support/bg1.jpg"><img src="/img/support/bg1.jpg" width="95" height="57" alt=""></td></tr></table></td>
			<td><img src="/img/support/gnome.jpg" width="228" height="219" alt=""></td>
		</tr>
	</table>
		
		
		
	</td></tr>
		
	<tr>
		<td>
					<table border="0" cellpadding="0" cellspacing="0" width=100%>
		<tr>
			<td valign="top" background="/img/support/bg4.jpg"><img src="/img/support/bg4.jpg" width="19" height="27" alt=""></td>
			<td align="center" valign="middle" width="99%" background="/img/support/bgmain.jpg">
<TABLE width="100%" height="100%" border="0" align="center" cellPadding="1" cellSpacing="1">
   <TR>
      <TD width="100%" vAlign="top">   	
<table border="0" cellpadding="0" cellspacing="0" align="center">
<tr>
	
	<td colspan=2>
<center><h3><span style="color: #ff0000;">Служба поддержки Бойцовского Клуба<br></span></h3></center>
</td>
</tr>
<tr>
	<td valign="top" align="left" style="padding-left:0px;">
<!-- topic list -->
 
<br>
 
<!-- /topic list -->
 
<!-- feedback form -->
 
 
 
<script type="text/javascript"> 
	var topicNames = {
	
11: 'Общие вопросы БК - Вопросы по развитию персонажа',	
	
21: 'Документы БК - Пользовательское соглашение (информ)',	
	
22: 'Документы БК - Законы Клуба (информ)',	
	
23: 'Документы БК - Законы Ордена Света',	
	
24: 'Документы БК - Законы Армады Тьмы',	
	
25: 'Документы БК - Вопросы и Ответы (информ)',	
	
31: 'Ошибки БК - Грамматика и пунктуация',	
	
32: 'Ошибки БК - Боевка',	
	
33: 'Ошибки БК - Вещи, предметы',	
	
34: 'Ошибки БК - Излом хаоса',	
	
35: 'Ошибки БК - Интерфейс',	
	
36: 'Ошибки БК - Квесты',	
	
37: 'Ошибки БК - Магазины',	
	
38: 'Ошибки БК - Магия',	
	
39: 'Ошибки БК - Модерация',	
	
310: 'Ошибки БК - Обменник',	
	
311: 'Ошибки БК - Подземелья',	
	
312: 'Ошибки БК - Чат, Форум',	
	
313: 'Ошибки БК - Случайные или/и трудновоспроизводимые баги',	
	
314: 'Ошибки БК - Прочие ошибки',	
	
41: 'Предложения по БК - Ваши предложения по развитию БК (без ответов)',	
	
51: 'Скроллы - Ошибки в работе',	
	
52: 'Скроллы - Прочее',	
	
61: 'Радио БК - Общие вопросы',	
	
62: 'Радио БК - Как слушать Радио БК',	
	
63: 'Радио БК - Как передать приветы на Радио БК (информ)',	
	
64: 'Радио БК - Рассписание прямых эфиров (информ)',	
	
65: 'Радио БК - Вопросы к Ди-джеям БК',	
	
66: 'Радио БК - Прочее',	
	
71: 'Коммерческий Отдел БК - Основные положения о КО (информ)',	
	
72: 'Коммерческий Отдел БК - Веб-портал КО БК (информ)',	
	
0: 'Прочее - Вопрос, не вошедший ни в одну категорию'	
 
};
 
</script>
 
<center><h5>Создать новую тему</h5></center>
Сообщения не относяшиеся к сервису не рассматриваются и удаляются, не тратьте своё и наше время.<br>Благодарим за понимание.<br>
 
<form method="post" onSubmit="return checkForm(this);">
	<input type="hidden" name="action" value="send_feedback" />
		<table border="0" cellpadding="2" cellspacing="0">
			<tr>
				<td></td>
				<td>
				</td>
			</tr>
			<tr>
				<td align="right">Персонаж: &nbsp;</td><td><b><?=$p['login']?></b></td>
			</tr>
<!--			<tr>
				<td align="right">E-mail: &nbsp;<sup style="color:red">*</sup></td><td><input type="text" name="user_email" value="" class="input" size="80" maxlength="50" /></td>
			</tr>
-->			
			<tr>
				<td align="right">Категория: &nbsp;<sup style="color:red">*</sup></td><td><select name="message_type" class="input">
					<option style="color: #ff0000;" value="1001">Общие вопросы БК</option>
					<option  value="11">&nbsp;&nbsp;&nbsp;&nbsp;Вопросы по развитию персонажа</option>
					<option style="color: #ff0000;" value="1002">Документы БК</option>
					<option  value="21">&nbsp;&nbsp;&nbsp;&nbsp;Пользовательское соглашение (информ)</option>
					<option  value="22">&nbsp;&nbsp;&nbsp;&nbsp;Законы Клуба (информ)</option>
					<option  value="23">&nbsp;&nbsp;&nbsp;&nbsp;Законы Ордена Света</option>
					<option  value="24">&nbsp;&nbsp;&nbsp;&nbsp;Законы Армады Тьмы</option>
					<option  value="25">&nbsp;&nbsp;&nbsp;&nbsp;Вопросы и Ответы (информ)</option>
					<option style="color: #ff0000;" value="1003">Ошибки БК</option>
					<option  value="31">&nbsp;&nbsp;&nbsp;&nbsp;Грамматика и пунктуация</option>
					<option  value="32">&nbsp;&nbsp;&nbsp;&nbsp;Боевка</option>
					<option  value="33">&nbsp;&nbsp;&nbsp;&nbsp;Вещи, предметы</option>
					<option  value="34">&nbsp;&nbsp;&nbsp;&nbsp;Излом хаоса</option>
					<option  value="35">&nbsp;&nbsp;&nbsp;&nbsp;Интерфейс</option>
					<option  value="36">&nbsp;&nbsp;&nbsp;&nbsp;Квесты</option>
					<option  value="37">&nbsp;&nbsp;&nbsp;&nbsp;Магазины</option>
					<option  value="38">&nbsp;&nbsp;&nbsp;&nbsp;Магия</option>
					<option  value="39">&nbsp;&nbsp;&nbsp;&nbsp;Модерация</option>
					<option  value="310">&nbsp;&nbsp;&nbsp;&nbsp;Обменник</option>
					<option  value="311">&nbsp;&nbsp;&nbsp;&nbsp;Подземелья</option>
					<option  value="312">&nbsp;&nbsp;&nbsp;&nbsp;Чат, Форум</option>
					<option  value="313">&nbsp;&nbsp;&nbsp;&nbsp;Случайные или/и трудновоспроизводимые баги</option>
					<option  value="314">&nbsp;&nbsp;&nbsp;&nbsp;Прочие ошибки</option>
					<option style="color: #ff0000;" value="1004">Предложения по БК</option>
					<option  value="41">&nbsp;&nbsp;&nbsp;&nbsp;Ваши предложения по развитию БК (без ответов)</option>
					<option style="color: #ff0000;" value="1005">Скроллы</option>
					<option  value="51">&nbsp;&nbsp;&nbsp;&nbsp;Ошибки в работе</option>
					<option  value="52">&nbsp;&nbsp;&nbsp;&nbsp;Прочее</option>
					<option style="color: #ff0000;" value="1006">Радио БК</option>
					<option  value="61">&nbsp;&nbsp;&nbsp;&nbsp;Общие вопросы</option>
					<option  value="62">&nbsp;&nbsp;&nbsp;&nbsp;Как слушать Радио БК</option>
					<option  value="63">&nbsp;&nbsp;&nbsp;&nbsp;Как передать приветы на Радио БК (информ)</option>
					<option  value="64">&nbsp;&nbsp;&nbsp;&nbsp;Рассписание прямых эфиров (информ)</option>
					<option  value="65">&nbsp;&nbsp;&nbsp;&nbsp;Вопросы к Ди-джеям БК</option>
					<option  value="66">&nbsp;&nbsp;&nbsp;&nbsp;Прочее</option>
					<option style="color: #ff0000;" value="1007">Коммерческий Отдел БК</option>
					<option  value="71">&nbsp;&nbsp;&nbsp;&nbsp;Основные положения о КО (информ)</option>
					<option  value="72">&nbsp;&nbsp;&nbsp;&nbsp;Веб-портал КО БК (информ)</option>
					<option style="color: #ff0000;" value="1100">Прочее</option>
					<option  value="0">&nbsp;&nbsp;&nbsp;&nbsp;Вопрос, не вошедший ни в одну категорию</option>
				</td>
			</tr>
 
			<tr>
				<td align="right">Тема: &nbsp;<sup style="color:red">*</sup></td><td><input type="text" name="message_subject" value="" class="input" size="80" maxlength="100" /></td>
			</tr>
 
			<tr>

			<td valign="top" align="right">Сообщение: &nbsp;<sup style="color:red">*</sup></td><td><textarea name="message" cols="81" rows="15" class="input" maxlength="3000"  onkeyup="ismaxlength(this)"  onmousedown="ismaxlength(this)" style="width:600px; height: 200px;" onselect="ismaxlength(this)"></textarea></td>
			</tr>
			<tr>
				<td valign="top"></td><td align="ridght"><input type="submit" value="Отправить сообщение" class="input" /></td>
			</tr>
		</table>
	</form>
<!-- feedback form -->
	</td>	
</tr>
</table>
<br><br>
<?
if($_POST['message']){

$headers  = "Mime-Version: 1.1 \r\n";
		$headers  = "Mime-Version: 1.1 \r\n";
		$headers .= "Date: ".date("r")." \r\n";
		$headers .= "Content-type: text/html; charset=utf-8 \r\n";
		$headers .= "From: ".$p['login']." <miha.babushkin@mail.ru>\r\n";

		$headers = trim($headers);
		$headers = stripslashes($headers);
	
		$aa='<html>
				<head>
					<title>'.iconv('cp1251', 'utf-8', $_POST['message_subject']).'</title>
				</head>
				<body>
					'.iconv('cp1251', 'utf-8', $_POST['message']).'
				</body>
			</html>';
		//mail("miha.babushkin@mail.ru","тема",$aa,$headers);
		mail("miha.babushkin@mail.ru","",$aa,$headers);
		echo "<center><font color='blue' size='14'><h3>Отправленно.</h3></font></center>";
}
?> 
			</TD>
    </TR>
</TABLE>
 
 
</td>
			<td valign="top" valign="top" background="/img/support/bg3.jpg"><img src="/img/support/gnome2.jpg" width="61" height="86" alt=""></td>
		</tr>
	</table>
</td></tr>
	
		<tr>
			<td>
				
		<table border="0" cellpadding="0" cellspacing="0">
			<tr bgcolor="#242422">
				<td valign="bottom"><img src="/img/support/molot.jpg" width="187" height="72" alt=""></td>
				<td valign="top" width="99%"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td background="/img/support/bg5.jpg"><img src="/img/support/bg5.jpg" width="53" height="40" alt=""></td></tr><tr><td><img src="/img/support/bg6.jpg" width="129" height="32" alt=""></td></tr></table></td>
			<td><img src="/img/support/ug.jpg" width="88" height="72" alt=""></td>
		</tr>
	</table>
		
	</td></tr>
	
		
	</table>
	
</body>
</html> 

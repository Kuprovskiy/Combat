<?
ob_start("ob_gzhandler");
//=========================================================
// bank class
//=========================================================
	session_start();
	if ($_SESSION['uid'] == null) header("Location: index.php");
	include "connect.php";
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '".mysql_real_escape_string($_SESSION['uid'])."' LIMIT 1;"));
	include "functions.php";
    if ($user['room'] != 29) header("Location: main.php");
    if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }

			function inschet($userid){
				$banks = mysql_query("SELECT * FROM `bank` WHERE `owner` = '".mysql_real_escape_string($userid)."';");
				echo "<select style='width:90px' name=id>";
				while ($rah = mysql_fetch_array($banks)) {
					echo "<option>",$rah['id'],"</option>";
				}
				echo "</select>";
			}

?>
<HTML><HEAD>
	<script>
		function returned2(s){
			//if (top.oldlocation != '') { top.frames['main'].navigate(top.oldlocation+'?'+s+'tmp='+Math.random()); top.oldlocation=''; }
			//else {
			top.frames['main'].location='city.php?'+s+'tmp='+Math.random()
			//}
		}
	</script>
<link rel=stylesheet type="text/css" href="/i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<SCRIPT src='/i/commoninf.js'></SCRIPT>
<SCRIPT LANGUAGE="JavaScript1.2" SRC="/i/misc/keypad.js"></SCRIPT>
<style type="text/css">
<!--
.btkey {
	display: block; text-align: center;
	PADDING-RIGHT: 1px; PADDING-LEFT: 1px;
	FONT-SIZE: 6.5pt; FONT-FAMILY: verdana,sans-serif,arial;
	width: 18;
	CURSOR: hand;
	border: 1px solid #D6D3CE;
	COLOR: #000000; BACKGROUND-COLOR: #ffffff;
}
-->
</style>
</HEAD>
<body leftmargin=5 topmargin=0 marginwidth=0 marginheight=0 bgcolor=#e2e0e0>
<table width=100%>
	<Tr>
		<td align=center><h3>Банк</h3></td>
		<td align=right width=60><FORM action="city.php" method=GET>
    <center><INPUT TYPE="submit" value="Вернуться" name="strah"></center>
    </form></td>
	</tr>
</table>
<?
	if($_GET['exit']) $_SESSION['bankid'] = null;

	//заходим на счет
	if($_POST['enter'] && $_POST['pass']) {

				$data = mysql_query("SELECT * FROM `bank` WHERE `owner` = '".mysql_real_escape_string($user['id'])."' AND `id`= '".mysql_real_escape_string($_POST['id'])."' AND `pass` = '".md5($_POST['pass'])."';");
					echo mysql_error();
					$data = mysql_fetch_array($data);
					if($data) {
						$_SESSION['bankid'] = $_POST['id'];
					}
					else
					{
						err('Ошибка входа.');
					}


	}
	if(!$_SESSION['bankid'] )
{
//открытие счета
	if($_POST['reg'] && $_POST['rpass'] && $_POST['rpass2']) {
		if ($_POST['rpass'] == $_POST['rpass2']) {
			if ($user['money'] >= 0.5) {
				if(mysql_query("INSERT INTO `bank` (`pass`,`owner`) values ('".md5($_POST['rpass2'])."','".mysql_real_escape_string($user['id'])."');")) {
					$sh_num=mysql_insert_id();
					err('Ваш номер счета: '.mysql_insert_id().', запишите.');
					mysql_query("UPDATE users SET money = money-0.5 WHERE id = '".$user['id']."' LIMIT 1;");
					mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($_SESSION['uid'])."','\"".mysql_real_escape_string($user['login'])."\" открыл счет №".$sh_num." в банке. ',1,'".time()."');");
					mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($_SESSION['uid'])."','\"".mysql_real_escape_string($user['login'])."\" заплатил за открытие счета в банке 3 кр. ',1,'".time()."');");
				}
				else {
					err('Техническая ошибка');
				}
			} else {
				err('Недостаточно денег');
			}
		} else {
			err('Не совпадают пароли');
		}
	}
//высылаем пароль на мыло
	if ($_POST['resendmail']){

	$bank2 = mysql_fetch_array(mysql_query("SELECT mail FROM `bank` WHERE `owner` = '".mysql_real_escape_string($user['id'])."';"));

		if ($bank2['mail']==0) {
		err('У вас запрещена высылка пароля на email');
		}else{
	$newpass=md5(md5(math.rand(-2000000,2000000).$user['login']));
	$newpass=substr($newpass,0,10);

	$lasttime=mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
	$ipclient=getenv("HTTP_X_FORWARDED_FOR");

	if (mysql_query("insert into confirmpasswd(login,passwd,date,ip,active) values('bbb".mysql_real_escape_string($_POST['id'])."bbb','".mysql_real_escape_string($newpass)."','".mysql_real_escape_string($lasttime)."','".mysql_real_escape_string($ipclient)."',1)")){
		$headers  = "Mime-Version: 1.1 \r\n";
		$headers .= "Date: ".date("r")." \r\n";
		$headers .= "Content-type: text/html; charset=windows-1251 \r\n";
		$headers .= "From: antikombatz.com <support@antikombatz.com>\r\n";

		$headers = trim($headers);
		$headers = stripslashes($headers);

		$aa='<html>
				<head>
					<title>Востановление пароля</title>
				</head>
				<body>
					Добрый день '.$user['realname'].'.<br>
					Вами было запрошено востановление пароля для счета '.$_POST['id'].' c IP адреса - '.$ipclient.', если это были не Вы, просто удалите это письмо.<br>
					<br>
					------------------------------------------------------------------<br>
					Ваш № счета  | '.$_POST['id'].'<br>
					Новый пароль | '.$newpass.'<br>
					------------------------------------------------------------------<br>
					<br>
					<br>
					<h3>Для подтверждения нового пароля пройдите по ссылке ниже.</h3><br>
					<a href="http://antikombatz.com/confpassbank.php?newpass='.$newpass.'&login='.$_POST['id'].'&flag=1&timev='.$lasttime.'">Востановление пароля</a>
					<br>
					<font color="blue">Если вы не восстановите пароль до <b>'.date("d-M-Y", $lasttime) .' 00:00</b>, ссылка будет неактивной.</font>
					<br>
					Отвечать на данное письмо не нужно.
				</body>
			</html>';

		mail($user['email'],"Востановление банковского счета на antikombatz.com, для пользователя - ".$user['login'],$aa,$headers);
		err('Выслан номер счета и пароль на email, указанный в анкете.');
	}else{
		err('Сегодня пароль уже высылался. Проверьте почту');
	}
}
}
//страница открытия счета, знаю что ебануто, но по другому не умею
		if ($_POST['open']){
		?>
<FORM action="bank.php" method=POST name="F3">
<H4>Открытие счета</H4>
<?
$newid = mysql_fetch_array(mysql_query("SELECT id FROM bank ORDER BY id DESC LIMIT 1;"));
?>
Запишите номер вашего счета: <B><?=$newid['id']+1?></B><BR>
Номер счета и пароль строго привязаны только к вашему персонажу. Только персонаж <b><?=$user['login']?></b> может использовать этот счет, никто другой, даже зная ваш номер и пароль, не получит доступа к нему!<BR><BR>
<table><tr><TD valign=top>
<table>
<tr><TD><nobr>Придумайте пароль к счету</nobr><br><INPUT TYPE=password name=rpass>&nbsp;<img border=0 SRC="/i/misc/klav_transparent.gif"  style='cursor: hand' onClick="KeypadShow(1, 'F3', 'rpass', 'keypad3');"></TD></tr>
<tr><TD><nobr>Введите пароль повторно</nobr><br><INPUT TYPE=password name=rpass2>&nbsp;<img border=0 SRC="/i/misc/klav_transparent.gif"  style='cursor: hand' onClick="KeypadShow(1, 'F3', 'rpass2', 'keypad3');"></TD></tr>
<tr><TD><nobr>Вы заплатите: <B>3.00 кр.</B></td></tr>
</table>
<INPUT TYPE=submit value="Открыть счет" name=reg>
</TD>
<TD><div id="keypad3" align=center style="display: none;"></div>
</TD>
</tr></table>
</FORM>
			<?}else{?>
</HTML>
</TD>
</TR>
</TABLE>
<BR>
Мы предоставляем следующие услуги:
<OL>
<LI>Открытие счета<LI>Возможность положить/снять кредиты/еврокредиты со счета
<LI>Перевести кредиты/еврокредиты с одного счета на другой
<LI>Обменный пункт. Обмен еврокредитов на кредиты
</OL>
<FORM action="bank.php" method=POST>
Хотите открыть свой счет? Услуга платная: <B>3.00 кр.</B> <INPUT TYPE=submit value="Открыть счет" name=open>
</FORM>
<TABLE><TR><FORM action="bank.php" name="F2" method=POST><TD>
<FIELDSET><LEGEND><B>Управление счетом</B> </LEGEND>
<TABLE>
<TR><TD valign=top>
<TABLE>
<TR><TD>Номер счета</td> <TD colspan=2>
		<? inschet($user['id']); ?>
</td></tr>
<TR><TD>Пароль</td><td> <INPUT style='width:90;' type=password value="" name=pass></td><TD style='padding: 0, 0, 3, 5'><img border=0 SRC="/i/misc/klav_transparent.gif" style='cursor: hand' onClick="KeypadShow(1, 'F2', 'pass', 'keypad2');"></TD></tr>
<TR><TD colspan=3 align=center><INPUT TYPE=submit value="Войти" name=enter></td></tr>
</TABLE>
</TD>
<TD><div id="keypad2" align=center style="display: none;"></div></TD></TR>
</TABLE>
</FIELDSET>
</TD></TR></TABLE>
Забыли номер счета и/или пароль? Можно их выслать на email, указанный в анкете <INPUT TYPE=submit value="Выслать" name=resendmail>
<br><br>
</FORM>
			<?}}else{
	$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = '".mysql_real_escape_string($_SESSION['bankid'])."';"));
//кладем кредиты на счет
	if($_POST['in'] && $_POST['ik']) {
		$_POST['ik'] = round($_POST['ik'],2);
		if (is_numeric($_POST['ik']) && ($_POST['ik']>0) && ($_POST['ik'] <= $user['money'])) {
			$user['money'] -= $_POST['ik'];
			if (mysql_query("UPDATE `users` SET `money` = `money` - '".mysql_real_escape_string($_POST['ik'])."' WHERE `id`= '".mysql_real_escape_string($user['id'])."' LIMIT 1;")) {
				$mywarn="Деньги удачно положены на счет";
				mysql_query("UPDATE `bank` SET `cr` = `cr` + '".mysql_real_escape_string($_POST['ik'])."' WHERE `id`= '".mysql_real_escape_string($_SESSION['bankid'])."' LIMIT 1;");
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($_SESSION['uid'])."','Персонаж \"".mysql_real_escape_string($user['login'])."\" положил на свой счет №".mysql_real_escape_string($_SESSION['bankid'])." ".mysql_real_escape_string($_POST['ik'])." кр. ',1,'".time()."');");
				$putkr = $_POST['ik']+$bank['cr'];
				mysql_query("INSERT INTO `bankhistory`(`id` , `text` , `bankid`) VALUES ('','Вы положили на счет <b>".mysql_real_escape_string($_POST['ik'])." кр.</b>, комиссия <b>0 кр.</b> <i>(Итого: ".$putkr." кр., ".$bank['ekr']." екр.)</i>','".mysql_real_escape_string($_SESSION['bankid'])."');");

			}
			else {
				$mywarn="Произошла ошибка!";
			}
		}
		else {
			$mywarn="У вас недостаточно денег для выполнения операции";
		}
		$_POST['in']=0;
	}

//Снимаем еврокредиты со счета
	if($_POST['ekrout'] && $_POST['ekrok']) {
		$_POST['ekrok'] = round($_POST['ekrok'],2);
		if (is_numeric($_POST['ekrok']) && ($_POST['ekrok']>0) && ($_POST['ekrok'] <= $bank['ekr'])) {
			$user['ekr'] += $_POST['ekrok'];
			if (mysql_query("UPDATE `users` SET `ekr` = `ekr` + '".mysql_real_escape_string($_POST['ekrok'])."' WHERE `id`= '".mysql_real_escape_string($user['id'])."' LIMIT 1;")) {
				$mywarn="Еврокредиты удачно сняты со счета";
				mysql_query("UPDATE `bank` SET `ekr` = `ekr` - '".mysql_real_escape_string($_POST['ekrok'])."' WHERE `id`= '".mysql_real_escape_string($_SESSION['bankid'])."' LIMIT 1;");
				$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = '".mysql_real_escape_string($_SESSION['bankid'])."';"));
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($_SESSION['uid'])."','Персонаж \"".mysql_real_escape_string($user['login'])."\" снял со своего счета №".mysql_real_escape_string($_SESSION['bankid'])." ".mysql_real_escape_string($_POST['ekrok'])." екр.',1,'".time()."');");
				mysql_query("INSERT INTO `bankhistory`(`id` , `text` , `bankid`) VALUES ('','Вы сняли со счета <b>".mysql_real_escape_string($_POST['ekrok'])." екр.</b>, комиссия <b>0 кр.</b> <i>(Итого: ".mysql_real_escape_string($bank['cr'])." кр., ".mysql_real_escape_string($bank['ekr'])." екр.)</i>','".mysql_real_escape_string($_SESSION['bankid'])."');");

			}
			else {
				$mywarn="Произошла ошибка!";
			}
		}
		else {
			$mywarn="У вас недостаточно Еврокредитов на счету для выполнения операции";
		}
		$_POST['ekrout']=0;
	}
	$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = '".mysql_real_escape_string($_SESSION['bankid'])."';"));
//Снимаем кредиты со счета
	if($_POST['out'] && $_POST['ok']) {
		$_POST['ok'] = round($_POST['ok'],2);
		if (is_numeric($_POST['ok']) && ($_POST['ok']>0) && ($_POST['ok'] <= $bank['cr'])) {
			$user['money'] += $_POST['ok'];
			if (mysql_query("UPDATE `users` SET `money` = `money` + '".mysql_real_escape_string($_POST['ok'])."' WHERE `id`= '".$user['id']."' LIMIT 1;")) {
				$mywarn="Деньги удачно сняты со счета";
				mysql_query("UPDATE `bank` SET `cr` = `cr` - '".mysql_real_escape_string($_POST['ok'])."' WHERE `id`= '".mysql_real_escape_string($_SESSION['bankid'])."' LIMIT 1;");
				$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = '".mysql_real_escape_string($_SESSION['bankid'])."';"));
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($_SESSION['uid'])."','Персонаж \"".mysql_real_escape_string($user['login'])."\" снял со своего счета №".mysql_real_escape_string($_SESSION['bankid'])." ".mysql_real_escape_string($_POST['ok'])." кр.',1,'".time()."');");
				mysql_query("INSERT INTO `bankhistory`(`id` , `text` , `bankid`) VALUES ('','Вы сняли со счета <b>".mysql_real_escape_string($_POST['ok'])." кр.</b>, комиссия <b>0 кр.</b> <i>(Итого: ".$bank['cr']." кр., ".$bank['ekr']." екр.)</i>','".mysql_real_escape_string($_SESSION['bankid'])."');");

			}
			else {
				$mywarn="Произошла ошибка!";
			}
		}
		else {
			$mywarn="У вас недостаточно денег на счету для выполнения операции";
		}
		$_POST['out']=0;
	}
//обмен еврокредитов
	if($_POST['change'] && $_POST['ok1']) {
		$_POST['ok1'] = round($_POST['ok1'],2);
		if (is_numeric($_POST['ok1']) && ($_POST['ok1']>0) && ($_POST['ok1'] <= $bank['ekr'])) {
			$bank['cr'] += $_POST['ok1'] * 40;
			$bank['ekr'] -= $_POST['ok1'];
			$add_money=$_POST['ok1'] * 40;
			if (mysql_query("UPDATE `bank` SET `cr` = `cr` + '".mysql_real_escape_string($add_money)."' WHERE `id`= '".$bank['id']."' LIMIT 1;")) {
				$mywarn="Обмен произведен успешно";
				mysql_query("UPDATE `bank` SET `ekr` = `ekr` - '".mysql_real_escape_string($_POST['ok1'])."' WHERE `id`= '".mysql_real_escape_string($_SESSION['bankid'])."' LIMIT 1;");
				$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = '".mysql_real_escape_string($_SESSION['bankid'])."';"));
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($_SESSION['uid'])."','Персонаж \"".mysql_real_escape_string($user['login'])."\" обменял ".mysql_real_escape_string($_POST['ok1'])." екр. на ".mysql_real_escape_string($add_money)." кр. на счету №".mysql_real_escape_string($_SESSION['bankid'])." в банке. ',1,'".time()."');");
			}
			else {
				$mywarn="Произошла ошибка!";
			}
		}
		else {
			$mywarn="У вас недостаточно денег на валютном счету для выполнения операции";
		}
		$_POST['change']=0;
	}
//смена пароля
	if($_POST['change_psw'] && $_POST['new_psw'] && $_POST['new_psw2']) {
		if ($_POST['new_psw'] == $_POST['new_psw2']) {
				if (mysql_query("UPDATE `bank` SET `pass` = '".md5($_POST['new_psw2'])."' WHERE `id` = '".mysql_real_escape_string($_SESSION['bankid'])."';")) {
					err('Пароль успешно изменен.');
				}
				else {
					err('Техническая ошибка');
				}
		} else {
			err('Не совпадают пароли');
		}
	}
//разрешаем высылать пароль

	if($_POST['start_send_email']) {
				if (mysql_query("UPDATE `bank` SET `mail` = 1 WHERE `id` = '".mysql_real_escape_string($_SESSION['bankid'])."';")) {
					err('Вы разрешили высылку номера счета и пароля на email.');
				}
	}
//запрещаем высылать пароль
	if($_POST['stop_send_email']) {
				if (mysql_query("UPDATE `bank` SET `mail` = 0 WHERE `id` = '".mysql_real_escape_string($_SESSION['bankid'])."';")) {
					err('Вы запретили высылку номера счета и пароля на email.');
				}
	}
//делаем заметки
		if($_POST['save_notepad'])
		{
		$_POST['notepad']=htmlspecialchars($_POST['notepad']);
		$_POST['notepad']=str_replace("\\n","<BR>",$_POST['notepad']);
		if(preg_match("/__/",$_POST['notepad']) || preg_match("/--/",$_POST['notepad']))
		{
		echo"В тексте не должно присутствовать подряд более 1 символа '_' или '-'.";
		}else{
		mysql_query("update `bank` set `note` = '".mysql_real_escape_string($_POST['notepad'])."' WHERE `id` = '".mysql_real_escape_string($_SESSION['bankid'])."';");
		err('Сохранено.');
		}
		}
	$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = '".mysql_real_escape_string($_SESSION['bankid'])."';"));
//переводим кредиды на другой счет
	if($_POST['wu'] && $_POST['sum'] && $_POST['number']) {

		if ($user['align'] == 4) {
			$mywarn="Хаосникам переводы запрещены!";
		}
		else {
			$bank2 = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = '".mysql_real_escape_string($_POST['number'])."';"));
			$to = mysql_fetch_array(mysql_query("SELECT login FROM `users` WHERE `id` = '".mysql_real_escape_string($bank2['owner'])."';"));
			if($bank2[0]){
				$_POST['sum'] = round($_POST['sum'],2);
				if (is_numeric($_POST['sum']) && ($_POST['sum']>0)) {
					$nalog=round($_POST['sum']*0.03);
					if ($nalog < 1) {$nalog=1; }
					$new_sum=$_POST['sum']+$nalog;
					if ($new_sum <= $bank['cr']) {
						if (mysql_query("UPDATE `bank` SET `cr` = `cr` - '".mysql_real_escape_string($new_sum)."' WHERE `id`= '".mysql_real_escape_string($_SESSION['bankid'])."' LIMIT 1;")) {
							mysql_query("UPDATE `bank` SET `cr` = `cr` + '".mysql_real_escape_string($_POST['sum'])."' WHERE `id`= '".mysql_real_escape_string($_POST['number'])."' LIMIT 1;");
							$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = '".mysql_real_escape_string($_SESSION['bankid'])."';"));
							mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($_SESSION['uid'])."','Персонаж \"".mysql_real_escape_string($user['login'])."\" перевел со своего банковского счета №".mysql_real_escape_string($_SESSION['bankid'])." на счет №".mysql_real_escape_string($_POST['number'])." к персонажу ".mysql_real_escape_string($to['login'])." ".mysql_real_escape_string($_POST['sum'])." кр. Дополнительно снято ".$nalog." кр. за услуги банка ',1,'".time()."');");
							mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($bank2['owner'])."','Персонаж \"".mysql_real_escape_string($user['login'])."\" перевел со своего банковского счета №".mysql_real_escape_string($_SESSION['bankid'])." на счет №".mysql_real_escape_string($_POST['number'])." к персонажу ".mysql_real_escape_string($to['login'])." ".mysql_real_escape_string($_POST['sum'])." кр. Дополнительно снято ".$nalog." кр. за услуги банка ',1,'".time()."');");

							$otkogo = mysql_fetch_array(mysql_query("SELECT `login` FROM `users` WHERE `id` = '".mysql_real_escape_string($bank['owner'])."';"));
							$komy = mysql_fetch_array(mysql_query("SELECT `login` FROM `users` WHERE `id` = '".mysql_real_escape_string($bank2['owner'])."';"));
							$bablo = $_POST['sum']+$bank2['cr'];
							mysql_query("INSERT INTO `bankhistory`(`id` , `text` , `bankid`) VALUES ('','Вы перевели <b>{$_POST['sum']} кр.</b> на счет {$_POST['number']} персонажа \"{$komy['login']}\", комиссия <b>$nalog кр.</b> <i>(Итого: {$bank['cr']} кр., {$bank['ekr']} екр.)</i>','{$_SESSION['bankid']}');");
							mysql_query("INSERT INTO `bankhistory`(`id` , `text` , `bankid`) VALUES ('','Вам переведено <b>{$_POST['sum']} кр.</b> со счета {$_SESSION['bankid']} персонажа \"{$otkogo['login']}\" <i>(Итого: {$bablo} кр., {$bank2['ekr']} екр.)</i>','{$_POST['number']}');");

							//mysql_query("INSERT INTO `bankhistory`(`id` , `text` , `bankid`) VALUES ('','Вы перевели <b>\".mysql_real_escape_string($_POST['sum']).\" кр.</b> на счет \".mysql_real_escape_string($_POST['number'].\" персонажа \"{$komy['login']}\", комиссия <b>$nalog кр.</b> <i>(Итого: \".mysql_real_escape_string($bank['cr']).\" кр., \".mysql_real_escape_string($bank['ekr']).\" екр.)</i>','".mysql_real_escape_string($_SESSION['bankid'])."');");
							//mysql_query("INSERT INTO `bankhistory`(`id` , `text` , `bankid`) VALUES ('','Вам переведено <b>".mysql_real_escape_string($_POST['sum'])." кр.</b> со счета ".mysql_real_escape_string($_SESSION['bankid'])." персонажа \"{$otkogo['login']}\" <i>(Итого: ".mysql_real_escape_string($bablo)." кр., ".mysql_real_escape_string($bank2['ekr'])." екр.)</i>','".mysql_real_escape_string($_POST['number'])."');");


							$sum=$_POST['sum'];
							$schet=$_POST['number'];
							$mywarn="$sum кр. успешно переведены на счет № $schet";
						}
						else {
							$mywarn="Произошла ошибка!";
						}
					}
					else {
						$mywarn="У вас недостаточно денег на счету для выполнения операции";
					}
				}
				else {
					$mywarn="У вас недостаточно денег на счету для выполнения операции";
				}
			}
			else {
				$mywarn="Данные о счете получателя не найдены.";
			}
		}
		$_POST['wu']=0;
	}
	print "<center><font color=red><b>&nbsp;$mywarn</b></font></center>";
?>
<!-- управление счетом -->
<FORM action="bank.php" method=POST name=F1>
<INPUT TYPE=hidden name=sid value="230451324010">
<TABLE width=100%>
	<TR>
		<TD valign=top width=50%>
			<TABLE>
				<TR>
					<TD valign=top width=66%>
						<H4>Управление счетом</H4> &nbsp;
						<b>Счёт №:</b> <?=$_SESSION['bankid']?> <a href="?exit=1">[x]</a><br>
					</TD>
					<TD>
						<FIELDSET><LEGEND><B>У вас на счету</B> </LEGEND>
						<TABLE>
							<TR><TD>Кредитов:</TD><TD><B><?=$bank['cr']?></B></TD></TR>
							<TR><TD>Еврокредитов:</TD><TD><B><?=$bank['ekr']?></B></TD></TR>
							<TR><TD colspan=2><HR></TD></TR>
							<TR><TD>При себе наличных:</TD><TD><B><?=$user['money']?> кр.</B><BR><B><?=$user['ekr']?> екр.</B></TD></TR>
						</TABLE>
						</FIELDSET>
					</TD>
				</TR>
			</TABLE>
		</TD>


<TABLE cellspacing=5>
	<TR>
		<TD valign=top width=50%>
			<table width="100%">
				<tr>
					<td valign="top" width="50%">
			<FIELDSET><LEGEND><B>Пополнить счет</B> </LEGEND>
				Сумма <INPUT TYPE=text NAME=ik size=6 maxlength=10> кр. <INPUT TYPE=submit name=in value="Положить кр. на счет" onclick="if (isNaN(parseFloat(document.F1.ik.value))) {alert('Укажите сумму'); return false;} else {return confirm('Вы хотите положить на свой счет '+parseFloat(document.F1.ik.value)+' кр. ?')}"><BR>
			</FIELDSET>
					</td>
					
				</tr>
			</table>
		</TD>
		</TR>
	<TR>
		<TD valign=top>
			<FIELDSET><LEGEND><B>Перевести кредиты на другой счет</B> </LEGEND>
				Сумма <INPUT TYPE=text NAME=sum size=6 maxlength=10> кр.<BR>
				Номер счета куда перевести кредиты <INPUT TYPE=text NAME=number size=12 maxlength=15><BR>
				<INPUT TYPE=submit name=wu value="Перевести кредиты на другой счет" onclick="if (isNaN(parseFloat(document.F1.sum.value)) || isNaN(parseInt(document.F1.number.value)) ) {alert('Укажите сумму и номер счета'); return false;} else {return confirm('Вы хотите перевести со своего счета '+parseFloat(document.F1.sum.value)+' кр. на счет номер '+parseInt(document.F1.number.value)+' ?')}"><BR>
				<FONT COLOR=red>Внимание!</FONT> Комиссия составляет <B>3.00 %</B> от суммы, но не менее <B>1.00 кр</B>.
			</FIELDSET>
		</TD>
		
		<TR>
		<TD valign=top>
			<FIELDSET><LEGEND><B>Обменный пункт</B> </LEGEND>
				Обменять еврокредиты на кредиты.<BR>
				Курс <B>1 екр.</B> = <B>40.00 кр.</B><BR>
				Сумма <INPUT TYPE=text NAME=ok1 size=6 maxlength=10> екр.
				<INPUT TYPE=submit name=change value="Обменять" onclick="if (isNaN(parseFloat(document.F1.ok1.value))) {alert('Укажите обмениваемую сумму'); return false;} else {return confirm('Вы хотите обменять '+parseFloat(document.F1.ok1.value)+' екр. на кредиты ?')}">
			</FIELDSET><br>
			<HR>
			<FIELDSET><LEGEND><B>Настройки</B> </LEGEND>
				<?if($bank['mail']==0) {?>
					Вы запретили высылку номера счета и пароля на email. Можете включить эту функцию.
					<INPUT TYPE=submit name=start_send_email value="Разрешить высылку пароля на email">
				<?}else{?>
					У вас разрешена высылка номера счета и пароля на email. Если вы не уверены в своем email, или убеждены, что не забудете свой номер счета и пароль к нему, то можете запретить высылку пароля на email. Это убережет вас от кражи кредитов с вашего счета в случае взлома вашего email. Но если вы сами забудете свой номер счета и/или пароль, вам уже никто не поможет!<BR>
					<INPUT TYPE=submit name=stop_send_email value="Запретить высылку пароля на email">
				<?}?>
				<HR><B>Сменить пароль</B><BR>
				<table>
					<tr>
						<TD>Новый пароль</TD>
						<TD><INPUT TYPE=password name=new_psw></TD>
						<TD><img border=0 SRC="/i/misc/klav_transparent.gif"  style='cursor: hand' onClick="KeypadShow(1, 'F1', 'new_psw', 'keypad1');"></TD>
					</tr>
					<tr>
						<TD>Введите новый пароль повторно</TD>
						<TD><INPUT TYPE=password name=new_psw2></TD>
						<TD><img border=0 SRC="/i/misc/klav_transparent.gif" style='cursor: hand' onClick="KeypadShow(1, 'F1', 'new_psw2', 'keypad1');"></TD>
					</tr>
				</table>
				<INPUT TYPE=submit name=change_psw value="Сменить пароль"><BR>
				<div id="keypad1" align=center style="display: none;"></div>
			</FIELDSET><br>
			<FIELDSET><LEGEND><B>Последние операции</B> </LEGEND>
			<TABLE cellpadding="2" cellspacing="0" border="0">
<?
				$history = mysql_query("SELECT `date`,`text` FROM `bankhistory` WHERE `bankid` = '{$_SESSION['bankid']}' ORDER BY date DESC LIMIT 10;");
				while ($hist = mysql_fetch_array($history)) {
					echo "<TR><TD><font class=date>$hist[date]</font> $hist[text]</TD></TR>";
				}
?>
			</TABLE>



                        <td valign="top" width="100%">
			<FIELDSET><LEGEND><B>Снять со счета</B> </LEGEND>
				Сумма <INPUT TYPE=text NAME=ok size=6 maxlength=10> кр. <INPUT TYPE=submit name=out value="Снять кр. со счета" onclick="if (isNaN(parseFloat(document.F1.ok.value))) {alert('Укажите сумму'); return false;} else {return confirm('Вы хотите снять со своего счета '+parseFloat(document.F1.ok.value)+' кр. ?')}"><BR>
				Сумма <INPUT TYPE=text NAME=ekrok size=6 maxlength=10> екр. <INPUT TYPE=submit name=ekrout value="Снять екр. со счета" onclick="if (isNaN(parseFloat(document.F1.ekrok.value))) {alert('Укажите сумму'); return false;} else {return confirm('Вы хотите снять со своего счета '+parseFloat(document.F1.ekrok.value)+' екр. ?')}">
			</FIELDSET>
					</td>

		        <TR>
                        <TD colspan="2" valign=top>
			<FIELDSET><LEGEND><B>Записная книжка</B> </LEGEND>
				Здесь вы можете записывать любую информацию для себя. Номера счетов друзей, кто кому чего должен и прочее. Записная книжка общая для всех счетов.<BR>
				<TEXTAREA NAME=notepad ROWS=10 COLS=67 style="width:100%"><?=$bank['note']?></TEXTAREA><BR>
				<INPUT TYPE=submit name=save_notepad value="Сохранить изменения">
			</FIELDSET>
		</TD>
	</TR>
</TABLE>

			<?}?>
<div align=left><? include("mail_ru.php"); ?><div>
</FORM>
</BODY>
</HTML>
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
		<td align=center><h3>����</h3></td>
		<td align=right width=60><FORM action="city.php" method=GET>
    <center><INPUT TYPE="submit" value="���������" name="strah"></center>
    </form></td>
	</tr>
</table>
<?
	if($_GET['exit']) $_SESSION['bankid'] = null;

	//������� �� ����
	if($_POST['enter'] && $_POST['pass']) {

				$data = mysql_query("SELECT * FROM `bank` WHERE `owner` = '".mysql_real_escape_string($user['id'])."' AND `id`= '".mysql_real_escape_string($_POST['id'])."' AND `pass` = '".md5($_POST['pass'])."';");
					echo mysql_error();
					$data = mysql_fetch_array($data);
					if($data) {
						$_SESSION['bankid'] = $_POST['id'];
					}
					else
					{
						err('������ �����.');
					}


	}
	if(!$_SESSION['bankid'] )
{
//�������� �����
	if($_POST['reg'] && $_POST['rpass'] && $_POST['rpass2']) {
		if ($_POST['rpass'] == $_POST['rpass2']) {
			if ($user['money'] >= 0.5) {
				if(mysql_query("INSERT INTO `bank` (`pass`,`owner`) values ('".md5($_POST['rpass2'])."','".mysql_real_escape_string($user['id'])."');")) {
					$sh_num=mysql_insert_id();
					err('��� ����� �����: '.mysql_insert_id().', ��������.');
					mysql_query("UPDATE users SET money = money-0.5 WHERE id = '".$user['id']."' LIMIT 1;");
					mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($_SESSION['uid'])."','\"".mysql_real_escape_string($user['login'])."\" ������ ���� �".$sh_num." � �����. ',1,'".time()."');");
					mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($_SESSION['uid'])."','\"".mysql_real_escape_string($user['login'])."\" �������� �� �������� ����� � ����� 3 ��. ',1,'".time()."');");
				}
				else {
					err('����������� ������');
				}
			} else {
				err('������������ �����');
			}
		} else {
			err('�� ��������� ������');
		}
	}
//�������� ������ �� ����
	if ($_POST['resendmail']){

	$bank2 = mysql_fetch_array(mysql_query("SELECT mail FROM `bank` WHERE `owner` = '".mysql_real_escape_string($user['id'])."';"));

		if ($bank2['mail']==0) {
		err('� ��� ��������� ������� ������ �� email');
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
					<title>������������� ������</title>
				</head>
				<body>
					������ ���� '.$user['realname'].'.<br>
					���� ���� ��������� ������������� ������ ��� ����� '.$_POST['id'].' c IP ������ - '.$ipclient.', ���� ��� ���� �� ��, ������ ������� ��� ������.<br>
					<br>
					------------------------------------------------------------------<br>
					��� � �����  | '.$_POST['id'].'<br>
					����� ������ | '.$newpass.'<br>
					------------------------------------------------------------------<br>
					<br>
					<br>
					<h3>��� ������������� ������ ������ �������� �� ������ ����.</h3><br>
					<a href="http://antikombatz.com/confpassbank.php?newpass='.$newpass.'&login='.$_POST['id'].'&flag=1&timev='.$lasttime.'">������������� ������</a>
					<br>
					<font color="blue">���� �� �� ������������ ������ �� <b>'.date("d-M-Y", $lasttime) .' 00:00</b>, ������ ����� ����������.</font>
					<br>
					�������� �� ������ ������ �� �����.
				</body>
			</html>';

		mail($user['email'],"������������� ����������� ����� �� antikombatz.com, ��� ������������ - ".$user['login'],$aa,$headers);
		err('������ ����� ����� � ������ �� email, ��������� � ������.');
	}else{
		err('������� ������ ��� ���������. ��������� �����');
	}
}
}
//�������� �������� �����, ���� ��� �������, �� �� ������� �� ����
		if ($_POST['open']){
		?>
<FORM action="bank.php" method=POST name="F3">
<H4>�������� �����</H4>
<?
$newid = mysql_fetch_array(mysql_query("SELECT id FROM bank ORDER BY id DESC LIMIT 1;"));
?>
�������� ����� ������ �����: <B><?=$newid['id']+1?></B><BR>
����� ����� � ������ ������ ��������� ������ � ������ ���������. ������ �������� <b><?=$user['login']?></b> ����� ������������ ���� ����, ����� ������, ���� ���� ��� ����� � ������, �� ������� ������� � ����!<BR><BR>
<table><tr><TD valign=top>
<table>
<tr><TD><nobr>���������� ������ � �����</nobr><br><INPUT TYPE=password name=rpass>&nbsp;<img border=0 SRC="/i/misc/klav_transparent.gif"  style='cursor: hand' onClick="KeypadShow(1, 'F3', 'rpass', 'keypad3');"></TD></tr>
<tr><TD><nobr>������� ������ ��������</nobr><br><INPUT TYPE=password name=rpass2>&nbsp;<img border=0 SRC="/i/misc/klav_transparent.gif"  style='cursor: hand' onClick="KeypadShow(1, 'F3', 'rpass2', 'keypad3');"></TD></tr>
<tr><TD><nobr>�� ���������: <B>3.00 ��.</B></td></tr>
</table>
<INPUT TYPE=submit value="������� ����" name=reg>
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
�� ������������� ��������� ������:
<OL>
<LI>�������� �����<LI>����������� ��������/����� �������/����������� �� �����
<LI>��������� �������/����������� � ������ ����� �� ������
<LI>�������� �����. ����� ������������ �� �������
</OL>
<FORM action="bank.php" method=POST>
������ ������� ���� ����? ������ �������: <B>3.00 ��.</B> <INPUT TYPE=submit value="������� ����" name=open>
</FORM>
<TABLE><TR><FORM action="bank.php" name="F2" method=POST><TD>
<FIELDSET><LEGEND><B>���������� ������</B> </LEGEND>
<TABLE>
<TR><TD valign=top>
<TABLE>
<TR><TD>����� �����</td> <TD colspan=2>
		<? inschet($user['id']); ?>
</td></tr>
<TR><TD>������</td><td> <INPUT style='width:90;' type=password value="" name=pass></td><TD style='padding: 0, 0, 3, 5'><img border=0 SRC="/i/misc/klav_transparent.gif" style='cursor: hand' onClick="KeypadShow(1, 'F2', 'pass', 'keypad2');"></TD></tr>
<TR><TD colspan=3 align=center><INPUT TYPE=submit value="�����" name=enter></td></tr>
</TABLE>
</TD>
<TD><div id="keypad2" align=center style="display: none;"></div></TD></TR>
</TABLE>
</FIELDSET>
</TD></TR></TABLE>
������ ����� ����� �/��� ������? ����� �� ������� �� email, ��������� � ������ <INPUT TYPE=submit value="�������" name=resendmail>
<br><br>
</FORM>
			<?}}else{
	$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = '".mysql_real_escape_string($_SESSION['bankid'])."';"));
//������ ������� �� ����
	if($_POST['in'] && $_POST['ik']) {
		$_POST['ik'] = round($_POST['ik'],2);
		if (is_numeric($_POST['ik']) && ($_POST['ik']>0) && ($_POST['ik'] <= $user['money'])) {
			$user['money'] -= $_POST['ik'];
			if (mysql_query("UPDATE `users` SET `money` = `money` - '".mysql_real_escape_string($_POST['ik'])."' WHERE `id`= '".mysql_real_escape_string($user['id'])."' LIMIT 1;")) {
				$mywarn="������ ������ �������� �� ����";
				mysql_query("UPDATE `bank` SET `cr` = `cr` + '".mysql_real_escape_string($_POST['ik'])."' WHERE `id`= '".mysql_real_escape_string($_SESSION['bankid'])."' LIMIT 1;");
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($_SESSION['uid'])."','�������� \"".mysql_real_escape_string($user['login'])."\" ������� �� ���� ���� �".mysql_real_escape_string($_SESSION['bankid'])." ".mysql_real_escape_string($_POST['ik'])." ��. ',1,'".time()."');");
				$putkr = $_POST['ik']+$bank['cr'];
				mysql_query("INSERT INTO `bankhistory`(`id` , `text` , `bankid`) VALUES ('','�� �������� �� ���� <b>".mysql_real_escape_string($_POST['ik'])." ��.</b>, �������� <b>0 ��.</b> <i>(�����: ".$putkr." ��., ".$bank['ekr']." ���.)</i>','".mysql_real_escape_string($_SESSION['bankid'])."');");

			}
			else {
				$mywarn="��������� ������!";
			}
		}
		else {
			$mywarn="� ��� ������������ ����� ��� ���������� ��������";
		}
		$_POST['in']=0;
	}

//������� ����������� �� �����
	if($_POST['ekrout'] && $_POST['ekrok']) {
		$_POST['ekrok'] = round($_POST['ekrok'],2);
		if (is_numeric($_POST['ekrok']) && ($_POST['ekrok']>0) && ($_POST['ekrok'] <= $bank['ekr'])) {
			$user['ekr'] += $_POST['ekrok'];
			if (mysql_query("UPDATE `users` SET `ekr` = `ekr` + '".mysql_real_escape_string($_POST['ekrok'])."' WHERE `id`= '".mysql_real_escape_string($user['id'])."' LIMIT 1;")) {
				$mywarn="����������� ������ ����� �� �����";
				mysql_query("UPDATE `bank` SET `ekr` = `ekr` - '".mysql_real_escape_string($_POST['ekrok'])."' WHERE `id`= '".mysql_real_escape_string($_SESSION['bankid'])."' LIMIT 1;");
				$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = '".mysql_real_escape_string($_SESSION['bankid'])."';"));
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($_SESSION['uid'])."','�������� \"".mysql_real_escape_string($user['login'])."\" ���� �� ������ ����� �".mysql_real_escape_string($_SESSION['bankid'])." ".mysql_real_escape_string($_POST['ekrok'])." ���.',1,'".time()."');");
				mysql_query("INSERT INTO `bankhistory`(`id` , `text` , `bankid`) VALUES ('','�� ����� �� ����� <b>".mysql_real_escape_string($_POST['ekrok'])." ���.</b>, �������� <b>0 ��.</b> <i>(�����: ".mysql_real_escape_string($bank['cr'])." ��., ".mysql_real_escape_string($bank['ekr'])." ���.)</i>','".mysql_real_escape_string($_SESSION['bankid'])."');");

			}
			else {
				$mywarn="��������� ������!";
			}
		}
		else {
			$mywarn="� ��� ������������ ������������ �� ����� ��� ���������� ��������";
		}
		$_POST['ekrout']=0;
	}
	$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = '".mysql_real_escape_string($_SESSION['bankid'])."';"));
//������� ������� �� �����
	if($_POST['out'] && $_POST['ok']) {
		$_POST['ok'] = round($_POST['ok'],2);
		if (is_numeric($_POST['ok']) && ($_POST['ok']>0) && ($_POST['ok'] <= $bank['cr'])) {
			$user['money'] += $_POST['ok'];
			if (mysql_query("UPDATE `users` SET `money` = `money` + '".mysql_real_escape_string($_POST['ok'])."' WHERE `id`= '".$user['id']."' LIMIT 1;")) {
				$mywarn="������ ������ ����� �� �����";
				mysql_query("UPDATE `bank` SET `cr` = `cr` - '".mysql_real_escape_string($_POST['ok'])."' WHERE `id`= '".mysql_real_escape_string($_SESSION['bankid'])."' LIMIT 1;");
				$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = '".mysql_real_escape_string($_SESSION['bankid'])."';"));
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($_SESSION['uid'])."','�������� \"".mysql_real_escape_string($user['login'])."\" ���� �� ������ ����� �".mysql_real_escape_string($_SESSION['bankid'])." ".mysql_real_escape_string($_POST['ok'])." ��.',1,'".time()."');");
				mysql_query("INSERT INTO `bankhistory`(`id` , `text` , `bankid`) VALUES ('','�� ����� �� ����� <b>".mysql_real_escape_string($_POST['ok'])." ��.</b>, �������� <b>0 ��.</b> <i>(�����: ".$bank['cr']." ��., ".$bank['ekr']." ���.)</i>','".mysql_real_escape_string($_SESSION['bankid'])."');");

			}
			else {
				$mywarn="��������� ������!";
			}
		}
		else {
			$mywarn="� ��� ������������ ����� �� ����� ��� ���������� ��������";
		}
		$_POST['out']=0;
	}
//����� ������������
	if($_POST['change'] && $_POST['ok1']) {
		$_POST['ok1'] = round($_POST['ok1'],2);
		if (is_numeric($_POST['ok1']) && ($_POST['ok1']>0) && ($_POST['ok1'] <= $bank['ekr'])) {
			$bank['cr'] += $_POST['ok1'] * 40;
			$bank['ekr'] -= $_POST['ok1'];
			$add_money=$_POST['ok1'] * 40;
			if (mysql_query("UPDATE `bank` SET `cr` = `cr` + '".mysql_real_escape_string($add_money)."' WHERE `id`= '".$bank['id']."' LIMIT 1;")) {
				$mywarn="����� ���������� �������";
				mysql_query("UPDATE `bank` SET `ekr` = `ekr` - '".mysql_real_escape_string($_POST['ok1'])."' WHERE `id`= '".mysql_real_escape_string($_SESSION['bankid'])."' LIMIT 1;");
				$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = '".mysql_real_escape_string($_SESSION['bankid'])."';"));
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($_SESSION['uid'])."','�������� \"".mysql_real_escape_string($user['login'])."\" ������� ".mysql_real_escape_string($_POST['ok1'])." ���. �� ".mysql_real_escape_string($add_money)." ��. �� ����� �".mysql_real_escape_string($_SESSION['bankid'])." � �����. ',1,'".time()."');");
			}
			else {
				$mywarn="��������� ������!";
			}
		}
		else {
			$mywarn="� ��� ������������ ����� �� �������� ����� ��� ���������� ��������";
		}
		$_POST['change']=0;
	}
//����� ������
	if($_POST['change_psw'] && $_POST['new_psw'] && $_POST['new_psw2']) {
		if ($_POST['new_psw'] == $_POST['new_psw2']) {
				if (mysql_query("UPDATE `bank` SET `pass` = '".md5($_POST['new_psw2'])."' WHERE `id` = '".mysql_real_escape_string($_SESSION['bankid'])."';")) {
					err('������ ������� �������.');
				}
				else {
					err('����������� ������');
				}
		} else {
			err('�� ��������� ������');
		}
	}
//��������� �������� ������

	if($_POST['start_send_email']) {
				if (mysql_query("UPDATE `bank` SET `mail` = 1 WHERE `id` = '".mysql_real_escape_string($_SESSION['bankid'])."';")) {
					err('�� ��������� ������� ������ ����� � ������ �� email.');
				}
	}
//��������� �������� ������
	if($_POST['stop_send_email']) {
				if (mysql_query("UPDATE `bank` SET `mail` = 0 WHERE `id` = '".mysql_real_escape_string($_SESSION['bankid'])."';")) {
					err('�� ��������� ������� ������ ����� � ������ �� email.');
				}
	}
//������ �������
		if($_POST['save_notepad'])
		{
		$_POST['notepad']=htmlspecialchars($_POST['notepad']);
		$_POST['notepad']=str_replace("\\n","<BR>",$_POST['notepad']);
		if(preg_match("/__/",$_POST['notepad']) || preg_match("/--/",$_POST['notepad']))
		{
		echo"� ������ �� ������ �������������� ������ ����� 1 ������� '_' ��� '-'.";
		}else{
		mysql_query("update `bank` set `note` = '".mysql_real_escape_string($_POST['notepad'])."' WHERE `id` = '".mysql_real_escape_string($_SESSION['bankid'])."';");
		err('���������.');
		}
		}
	$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = '".mysql_real_escape_string($_SESSION['bankid'])."';"));
//��������� ������� �� ������ ����
	if($_POST['wu'] && $_POST['sum'] && $_POST['number']) {

		if ($user['align'] == 4) {
			$mywarn="��������� �������� ���������!";
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
							mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($_SESSION['uid'])."','�������� \"".mysql_real_escape_string($user['login'])."\" ������� �� ������ ����������� ����� �".mysql_real_escape_string($_SESSION['bankid'])." �� ���� �".mysql_real_escape_string($_POST['number'])." � ��������� ".mysql_real_escape_string($to['login'])." ".mysql_real_escape_string($_POST['sum'])." ��. ������������� ����� ".$nalog." ��. �� ������ ����� ',1,'".time()."');");
							mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($bank2['owner'])."','�������� \"".mysql_real_escape_string($user['login'])."\" ������� �� ������ ����������� ����� �".mysql_real_escape_string($_SESSION['bankid'])." �� ���� �".mysql_real_escape_string($_POST['number'])." � ��������� ".mysql_real_escape_string($to['login'])." ".mysql_real_escape_string($_POST['sum'])." ��. ������������� ����� ".$nalog." ��. �� ������ ����� ',1,'".time()."');");

							$otkogo = mysql_fetch_array(mysql_query("SELECT `login` FROM `users` WHERE `id` = '".mysql_real_escape_string($bank['owner'])."';"));
							$komy = mysql_fetch_array(mysql_query("SELECT `login` FROM `users` WHERE `id` = '".mysql_real_escape_string($bank2['owner'])."';"));
							$bablo = $_POST['sum']+$bank2['cr'];
							mysql_query("INSERT INTO `bankhistory`(`id` , `text` , `bankid`) VALUES ('','�� �������� <b>{$_POST['sum']} ��.</b> �� ���� {$_POST['number']} ��������� \"{$komy['login']}\", �������� <b>$nalog ��.</b> <i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");
							mysql_query("INSERT INTO `bankhistory`(`id` , `text` , `bankid`) VALUES ('','��� ���������� <b>{$_POST['sum']} ��.</b> �� ����� {$_SESSION['bankid']} ��������� \"{$otkogo['login']}\" <i>(�����: {$bablo} ��., {$bank2['ekr']} ���.)</i>','{$_POST['number']}');");

							//mysql_query("INSERT INTO `bankhistory`(`id` , `text` , `bankid`) VALUES ('','�� �������� <b>\".mysql_real_escape_string($_POST['sum']).\" ��.</b> �� ���� \".mysql_real_escape_string($_POST['number'].\" ��������� \"{$komy['login']}\", �������� <b>$nalog ��.</b> <i>(�����: \".mysql_real_escape_string($bank['cr']).\" ��., \".mysql_real_escape_string($bank['ekr']).\" ���.)</i>','".mysql_real_escape_string($_SESSION['bankid'])."');");
							//mysql_query("INSERT INTO `bankhistory`(`id` , `text` , `bankid`) VALUES ('','��� ���������� <b>".mysql_real_escape_string($_POST['sum'])." ��.</b> �� ����� ".mysql_real_escape_string($_SESSION['bankid'])." ��������� \"{$otkogo['login']}\" <i>(�����: ".mysql_real_escape_string($bablo)." ��., ".mysql_real_escape_string($bank2['ekr'])." ���.)</i>','".mysql_real_escape_string($_POST['number'])."');");


							$sum=$_POST['sum'];
							$schet=$_POST['number'];
							$mywarn="$sum ��. ������� ���������� �� ���� � $schet";
						}
						else {
							$mywarn="��������� ������!";
						}
					}
					else {
						$mywarn="� ��� ������������ ����� �� ����� ��� ���������� ��������";
					}
				}
				else {
					$mywarn="� ��� ������������ ����� �� ����� ��� ���������� ��������";
				}
			}
			else {
				$mywarn="������ � ����� ���������� �� �������.";
			}
		}
		$_POST['wu']=0;
	}
	print "<center><font color=red><b>&nbsp;$mywarn</b></font></center>";
?>
<!-- ���������� ������ -->
<FORM action="bank.php" method=POST name=F1>
<INPUT TYPE=hidden name=sid value="230451324010">
<TABLE width=100%>
	<TR>
		<TD valign=top width=50%>
			<TABLE>
				<TR>
					<TD valign=top width=66%>
						<H4>���������� ������</H4> &nbsp;
						<b>���� �:</b> <?=$_SESSION['bankid']?> <a href="?exit=1">[x]</a><br>
					</TD>
					<TD>
						<FIELDSET><LEGEND><B>� ��� �� �����</B> </LEGEND>
						<TABLE>
							<TR><TD>��������:</TD><TD><B><?=$bank['cr']?></B></TD></TR>
							<TR><TD>������������:</TD><TD><B><?=$bank['ekr']?></B></TD></TR>
							<TR><TD colspan=2><HR></TD></TR>
							<TR><TD>��� ���� ��������:</TD><TD><B><?=$user['money']?> ��.</B><BR><B><?=$user['ekr']?> ���.</B></TD></TR>
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
			<FIELDSET><LEGEND><B>��������� ����</B> </LEGEND>
				����� <INPUT TYPE=text NAME=ik size=6 maxlength=10> ��. <INPUT TYPE=submit name=in value="�������� ��. �� ����" onclick="if (isNaN(parseFloat(document.F1.ik.value))) {alert('������� �����'); return false;} else {return confirm('�� ������ �������� �� ���� ���� '+parseFloat(document.F1.ik.value)+' ��. ?')}"><BR>
			</FIELDSET>
					</td>
					
				</tr>
			</table>
		</TD>
		</TR>
	<TR>
		<TD valign=top>
			<FIELDSET><LEGEND><B>��������� ������� �� ������ ����</B> </LEGEND>
				����� <INPUT TYPE=text NAME=sum size=6 maxlength=10> ��.<BR>
				����� ����� ���� ��������� ������� <INPUT TYPE=text NAME=number size=12 maxlength=15><BR>
				<INPUT TYPE=submit name=wu value="��������� ������� �� ������ ����" onclick="if (isNaN(parseFloat(document.F1.sum.value)) || isNaN(parseInt(document.F1.number.value)) ) {alert('������� ����� � ����� �����'); return false;} else {return confirm('�� ������ ��������� �� ������ ����� '+parseFloat(document.F1.sum.value)+' ��. �� ���� ����� '+parseInt(document.F1.number.value)+' ?')}"><BR>
				<FONT COLOR=red>��������!</FONT> �������� ���������� <B>3.00 %</B> �� �����, �� �� ����� <B>1.00 ��</B>.
			</FIELDSET>
		</TD>
		
		<TR>
		<TD valign=top>
			<FIELDSET><LEGEND><B>�������� �����</B> </LEGEND>
				�������� ����������� �� �������.<BR>
				���� <B>1 ���.</B> = <B>40.00 ��.</B><BR>
				����� <INPUT TYPE=text NAME=ok1 size=6 maxlength=10> ���.
				<INPUT TYPE=submit name=change value="��������" onclick="if (isNaN(parseFloat(document.F1.ok1.value))) {alert('������� ������������ �����'); return false;} else {return confirm('�� ������ �������� '+parseFloat(document.F1.ok1.value)+' ���. �� ������� ?')}">
			</FIELDSET><br>
			<HR>
			<FIELDSET><LEGEND><B>���������</B> </LEGEND>
				<?if($bank['mail']==0) {?>
					�� ��������� ������� ������ ����� � ������ �� email. ������ �������� ��� �������.
					<INPUT TYPE=submit name=start_send_email value="��������� ������� ������ �� email">
				<?}else{?>
					� ��� ��������� ������� ������ ����� � ������ �� email. ���� �� �� ������� � ����� email, ��� ��������, ��� �� �������� ���� ����� ����� � ������ � ����, �� ������ ��������� ������� ������ �� email. ��� �������� ��� �� ����� �������� � ������ ����� � ������ ������ ������ email. �� ���� �� ���� �������� ���� ����� ����� �/��� ������, ��� ��� ����� �� �������!<BR>
					<INPUT TYPE=submit name=stop_send_email value="��������� ������� ������ �� email">
				<?}?>
				<HR><B>������� ������</B><BR>
				<table>
					<tr>
						<TD>����� ������</TD>
						<TD><INPUT TYPE=password name=new_psw></TD>
						<TD><img border=0 SRC="/i/misc/klav_transparent.gif"  style='cursor: hand' onClick="KeypadShow(1, 'F1', 'new_psw', 'keypad1');"></TD>
					</tr>
					<tr>
						<TD>������� ����� ������ ��������</TD>
						<TD><INPUT TYPE=password name=new_psw2></TD>
						<TD><img border=0 SRC="/i/misc/klav_transparent.gif" style='cursor: hand' onClick="KeypadShow(1, 'F1', 'new_psw2', 'keypad1');"></TD>
					</tr>
				</table>
				<INPUT TYPE=submit name=change_psw value="������� ������"><BR>
				<div id="keypad1" align=center style="display: none;"></div>
			</FIELDSET><br>
			<FIELDSET><LEGEND><B>��������� ��������</B> </LEGEND>
			<TABLE cellpadding="2" cellspacing="0" border="0">
<?
				$history = mysql_query("SELECT `date`,`text` FROM `bankhistory` WHERE `bankid` = '{$_SESSION['bankid']}' ORDER BY date DESC LIMIT 10;");
				while ($hist = mysql_fetch_array($history)) {
					echo "<TR><TD><font class=date>$hist[date]</font> $hist[text]</TD></TR>";
				}
?>
			</TABLE>



                        <td valign="top" width="100%">
			<FIELDSET><LEGEND><B>����� �� �����</B> </LEGEND>
				����� <INPUT TYPE=text NAME=ok size=6 maxlength=10> ��. <INPUT TYPE=submit name=out value="����� ��. �� �����" onclick="if (isNaN(parseFloat(document.F1.ok.value))) {alert('������� �����'); return false;} else {return confirm('�� ������ ����� �� ������ ����� '+parseFloat(document.F1.ok.value)+' ��. ?')}"><BR>
				����� <INPUT TYPE=text NAME=ekrok size=6 maxlength=10> ���. <INPUT TYPE=submit name=ekrout value="����� ���. �� �����" onclick="if (isNaN(parseFloat(document.F1.ekrok.value))) {alert('������� �����'); return false;} else {return confirm('�� ������ ����� �� ������ ����� '+parseFloat(document.F1.ekrok.value)+' ���. ?')}">
			</FIELDSET>
					</td>

		        <TR>
                        <TD colspan="2" valign=top>
			<FIELDSET><LEGEND><B>�������� ������</B> </LEGEND>
				����� �� ������ ���������� ����� ���������� ��� ����. ������ ������ ������, ��� ���� ���� ������ � ������. �������� ������ ����� ��� ���� ������.<BR>
				<TEXTAREA NAME=notepad ROWS=10 COLS=67 style="width:100%"><?=$bank['note']?></TEXTAREA><BR>
				<INPUT TYPE=submit name=save_notepad value="��������� ���������">
			</FIELDSET>
		</TD>
	</TR>
</TABLE>

			<?}?>
<div align=left><? include("mail_ru.php"); ?><div>
</FORM>
</BODY>
</HTML>
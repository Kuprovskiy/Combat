<?
ob_start("ob_gzhandler");
//=========================================================
// bank class
//=========================================================
	session_start();
	if ($_SESSION['uid'] == null) header("Location: index.php");
	include "connect.php";
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
	include "functions.php";
    if ($user['room'] != 29) header("Location: main.php");
    if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }

	if($_SESSION['bankid'] && $_GET['addekr'] && 1==2  && $user['klan']=='adminion') {
		mysql_query("INSERT `ekrpayments` (`id`,`summa`,`bank`) value ('','".$_POST['amount']."','".$_SESSION['bankid']."');");
		$id = mysql_insert_id();
		$params = array(
				'SYSTEM_NAME'			=> 'legend',
				'PAYMENT_USERNAME'		=> 'kaplenko',
				'PAYMENT_PASSWORD'		=> md5('oDRfIwFN'),
				'PAYMENT_ORDER_ID'		=> $id,
				'PAYMENT_AMOUNT'			=> (float)$_POST['amount'],
				'PAYMENT_DESCRIPTION'		=> '��������� ����������� ����� � ����',
 				'RESULT_URL'				=> 'http://Virt-Life.com/bank.balans.php',
 				'SUCCESS_URL'			=> 'http://lostcombats.com/bank.php?suk=1',
 				'FAIL_URL'				=> 'http://lostcombats.com/bank.php?fail=1'
			);
		$params['SIGN'] = strtolower (md5(implode('::',$params)));
		unset($params['PAYMENT_PASSWORD']);
		$form = '<form action="https://www.wmer.ru/ru/moneypool,merchant/" method="POST">';
		foreach ($params as $k => $v) {
			$form .= '<input type="hidden" name="'.htmlspecialchars($k).'" value="'.htmlspecialchars($v).'" />';
		}
		$form .= '<input type="submit" value="��������" /></form>';
		?>
		<html>
		<head>
			<link rel=stylesheet type="text/css" href="i/main.css">
			<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
		</head>
		<body leftmargin=5 topmargin=0 marginwidth=0 marginheight=0 bgcolor=#e2e0e0>
		<h4>���������� ��������� �����</h4>
		�����: <B><?=$params['PAYMENT_AMOUNT']?></B> ekr.<BR>
		���� � <B><?=$_SESSION['bankid']?></B><BR>
		����� ��������: <B><?=$id?></B>
		<?
		echo $form;
		die();
	}
			function inschet($userid){
				$banks = mysql_query("SELECT * FROM `bank` WHERE `owner` = ".$userid.";");
				echo "<select style='width:150px' name=id>";
				while ($rah = mysql_fetch_array($banks)) {
					echo "<option>",$rah['id'],"</option>";
				}
				echo "</select>";
			}

?>
<html>
<head>
	<script>
		function returned2(s){
			//if (top.oldlocation != '') { top.frames['main'].navigate(top.oldlocation+'?'+s+'tmp='+Math.random()); top.oldlocation=''; }
			//else {
			top.frames['main'].location='city.php?'+s+'tmp='+Math.random()
			//}
		}
	</script>
	<link rel=stylesheet type="text/css" href="i/main.css">
	<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
	<style>
	legend {
		padding: 0.2em 0.5em;
		color:#A52A2A;
		FONT-WEIGHT: bold;
	}

		body {
			background-image: url('i/bank.jpg');
			background-repeat: no-repeat;
			background-position: top right;
		}
	</style>
</head>
<body leftmargin=5 topmargin=0 marginwidth=0 marginheight=0 bgcolor=#e2e0e0>
<table width=100%>
	<Tr>
		<td align=center><h3>����</h3></td>
		<td align=right width=60><INPUT TYPE=button value="���������" onClick="returned2('cp=3&');"></td>
	</tr>
</table>
<?
	if($_GET['exit']) $_SESSION['bankid'] = null;
	
	
	if($_POST['enter'] && $_POST['pass']) {

					$data = mysql_query("SELECT * FROM `bank` WHERE `owner` = '".$user['id']."' AND `id`= '".$_POST['id']."' AND `pass` = '".md5($_POST['pass'])."';");
					echo mysql_error();
					$data = mysql_fetch_array($data);
					if($data) {
						$_SESSION['bankid'] = $_POST['id'];
						err('������� ����.');
					}
					else
					{
						err('������ �����.');
					}


	}
	
if ($_POST['resendmail']){
	$newpass=md5(md5(math.rand(-2000000,2000000).$user['login']));
	$newpass=substr($newpass,0,10);
	$lasttime=mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
	$ipclient=getenv("HTTP_X_FORWARDED_FOR");
	
	if (mysql_query("insert into confirmpasswd(login,passwd,date,ip,active) values('bbb".$_POST['id']."bbb','".$newpass."','".$lasttime."','".$ipclient."',1)")){
		$headers  = "Mime-Version: 1.1 \r\n";
		$headers .= "Date: ".date("r")." \r\n";
		$headers .= "Content-type: text/html; charset=windows-1251 \r\n";
		$headers .= "From: oldbk.com <sup@oldbk.com>\r\n";

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
					<a href="http://Virt-Life.com/confpassbank.php?newpass='.$newpass.'&login='.$_POST['id'].'&flag=1&timev='.$lasttime.'">������������� ������</a>
					<br>
					<font color="blue">���� �� �� ������������ ������ �� <b>'.date("d-M-Y", $lasttime) .' 00:00</b>, ������ ����� ����������.</font>
					<br>
					�������� �� ������ ������ �� �����.
				</body>
			</html>';

		mail($user['email'],"������������� ����������� ����� �� oldbk.com, ��� ������������ - ".$user['login'],$aa,$headers);
		echo "<center><font color='blue' size='14'><h3>������ ��������� ��� �� �����.</h3></font></center>";
		die();
	}
	else{
		echo "<center><h3>������� ������ ��� ���������. <br>��������� �����</h3></center>";
		die();
	}	
}
	
if ($_POST['repasswd']){
		//include("rememberpassword.php");
		?>
		<b>��� ������������� ������ ����������:<br><ul><li>1) ������� ����. </li><li>2) ������ �������� ������������.</li></ul>��� ����� ������� ������ �� email, ��������� ��� �����������, � ����� �������.</ul></b><br><br>
		<form method="post">�������� ����: <?php inschet($user['id']); ?> <input type="submit" name="resendmail" value="������������"></form>
		<?php
		
}
else	
if(!$_SESSION['bankid'] )
{
	if($_POST['reg'] && $_POST['rpass'] && $_POST['rpass2']) {
		if ($_POST['rpass'] == $_POST['rpass2']) {
			if ($user['money'] >= 0.5) {
				if(mysql_query("INSERT INTO `bank` (`pass`,`owner`) values ('".md5($_POST['rpass2'])."','".$user['id']."');")) {
					$sh_num=mysql_insert_id();
					err('��� ����� �����: '.mysql_insert_id().', ��������.');
					mysql_query("UPDATE users SET money = money-0.5 WHERE id = ".$user['id']." LIMIT 1;");
					mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" ������ ���� �".$sh_num." � �����. ',1,'".time()."');");
					mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" �������� �� �������� ����� � �����  0.5 ��. ',1,'".time()."');");
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
?>
	<table width=100%>
	<Tr>
	<td width=200>
	<form method=post>
	<fieldset style="width:200px; height:130px;">
		<legend>����� ����</legend>
		<table>
			<tr>
				<td colspan=2>��������� <b>0.5</b> ��.</td>
			</tr>
			<tr>
				<td>������</td>
				<td><input type=password name=rpass></td>
			</tr>
			<tr>
				<td>��� ���</td>
				<td><input type=password name=rpass2></td>
			</tr>
			<tr>
				<td colspan=2><center><input type=submit name='reg' value='������� ����'></td>
			</tr>
		</table>
	</fieldset>
	</form>
	</td><td width=200>
	<form method=post>
	<fieldset style="width:200px; height:130px;">
		<legend>����� � ����</legend><BR> &nbsp; �
<?
				inschet($user['id']);
?>
	<BR> &nbsp; ������ <input type=password name=pass size=21>
	<BR><BR>
	<input type=hidden name='enter' value='1'><input type=submit name='enter' value='�����'>
	<?php if ($user['id']==111){?>
	<div style="position: relative;float: right;"><input title="����������� ������" type=submit name='repasswd' value='������ ������?'></div>
	<?php }?>
	</fieldset>
	</form>
	</td><td><div align=right><fieldset style="width:400px;"><legend>���� ������������� ��������� ������: </legend>
		<table><tr><td align=left>
		&nbsp;&nbsp;����������� ����������� ����� ��������; <br>
		&nbsp;&nbsp;�������� ����� ������� �������;<br>
		&nbsp;&nbsp;����� ������������ �� ������� � �������;<br>
		&nbsp;&nbsp;������ ��������� ������������ �����</td></tr></table>
		</fieldset></div></td>
	</tr>
	</table>
<?
} else {
	if($_GET['fail']) {
		err('������ ���������� �������.');
		die();
	}
	if($_GET['suk']) {
		err('������ ������ ��������.');
		die();
	}

	if($_POST['in'] && $_POST['ik']) {
		$_POST['ik'] = round($_POST['ik'],2);
		if (is_numeric($_POST['ik']) && ($_POST['ik']>0) && ($_POST['ik'] <= $user['money'])) {
			$user['money'] -= $_POST['ik'];
			if (mysql_query("UPDATE `users` SET `money` = `money` - '".$_POST['ik']."' WHERE `id`= ".$user['id']." LIMIT 1;")) {
				$mywarn="������ ������ �������� �� ����";
				mysql_query("UPDATE `bank` SET `cr` = `cr` + '".$_POST['ik']."' WHERE `id`= ".$_SESSION['bankid']." LIMIT 1;");
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','�������� \"".$user['login']."\" ������� �� ���� ���� �".$_SESSION['bankid']." ".$_POST['ik']." ��. ',1,'".time()."');");
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
	$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = ".$_SESSION['bankid'].";"));
	if($_POST['out'] && $_POST['ok']) {
		$_POST['ok'] = round($_POST['ok'],2);
		if (is_numeric($_POST['ok']) && ($_POST['ok']>0) && ($_POST['ok'] <= $bank['cr'])) {
			$user['money'] += $_POST['ok'];
			if (mysql_query("UPDATE `users` SET `money` = `money` + '".$_POST['ok']."' WHERE `id`= ".$user['id']." LIMIT 1;")) {
				$mywarn="������ ������ ����� �� �����";
				mysql_query("UPDATE `bank` SET `cr` = `cr` - '".$_POST['ok']."' WHERE `id`= ".$_SESSION['bankid']." LIMIT 1;");
				$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = ".$_SESSION['bankid'].";"));
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','�������� \"".$user['login']."\" ���� �� ������ ����� �".$_SESSION['bankid']." ".$_POST['ok']." ��.',1,'".time()."');");
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
	if($_POST['ekrin'] && $_POST['ekrik']) {
		$_POST['ekrik'] = round($_POST['ekrik'],2);
		if (is_numeric($_POST['ekrik']) && ($_POST['ekrik']>0) && ($_POST['ekrik'] <= $user['ekr'])) {
			$user['ekr'] -= $_POST['ekrik'];
			if (mysql_query("UPDATE `users` SET `ekr` = `ekr` - '".$_POST['ekrik']."' WHERE `id`= ".$user['id']." LIMIT 1;")) {
				$mywarn="����������� ������ �������� �� ����";
				mysql_query("UPDATE `bank` SET `ekr` = `ekr` + '".$_POST['ekrik']."' WHERE `id`= ".$_SESSION['bankid']." LIMIT 1;");
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','�������� \"".$user['login']."\" ������� �� ���� ���� �".$_SESSION['bankid']." ".$_POST['ekrik']." ���. ',1,'".time()."');");
			}
			else {
				$mywarn="��������� ������!";
			}
		}
		else {
			$mywarn="� ��� ������������ ������������ ��� ���������� ��������";
		}
		$_POST['ekrin']=0;
	}
	$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = ".$_SESSION['bankid'].";"));
	if($_POST['ekrout'] && $_POST['ekrok']) {
		$_POST['ekrok'] = round($_POST['ekrok'],2);
		if (is_numeric($_POST['ekrok']) && ($_POST['ekrok']>0) && ($_POST['ekrok'] <= $bank['ekr'])) {
			$user['ekr'] += $_POST['ekrok'];
			if (mysql_query("UPDATE `users` SET `ekr` = `ekr` + '".$_POST['ekrok']."' WHERE `id`= ".$user['id']." LIMIT 1;")) {
				$mywarn="����������� ������ ����� �� �����";
				mysql_query("UPDATE `bank` SET `ekr` = `ekr` - '".$_POST['ekrok']."' WHERE `id`= ".$_SESSION['bankid']." LIMIT 1;");
				$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = ".$_SESSION['bankid'].";"));
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','�������� \"".$user['login']."\" ���� �� ������ ����� �".$_SESSION['bankid']." ".$_POST['ekrok']." ���.',1,'".time()."');");
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
	if($_POST['change'] && $_POST['ok']) {
		$_POST['ok'] = round($_POST['ok'],2);
		if (is_numeric($_POST['ok']) && ($_POST['ok']>0) && ($_POST['ok'] <= $bank['ekr'])) {
			$bank['cr'] += $_POST['ok'] * 10;
			$bank['ekr'] -= $_POST['ok'];
			$add_money=$_POST['ok'] * 10;
			if (mysql_query("UPDATE `bank` SET `cr` = `cr` + '$add_money' WHERE `id`= ".$bank['id']." LIMIT 1;")) {
				$mywarn="����� ���������� �������";
				mysql_query("UPDATE `bank` SET `ekr` = `ekr` - '".$_POST['ok']."' WHERE `id`= ".$_SESSION['bankid']." LIMIT 1;");
				$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = ".$_SESSION['bankid'].";"));
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','�������� \"".$user['login']."\" ������� ".$_POST['ok']." ���. �� ".$add_money." ��. �� ����� �".$_SESSION['bankid']." � �����. ',1,'".time()."');");
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
	if($_POST['changeback'] && $_POST['ok'] && $user['klan']=='adminion') {
		$_POST['ok'] = round($_POST['ok'],2);
		if (is_numeric($_POST['ok']) && ($_POST['ok']>0) && ($_POST['ok'] <= $bank['cr'])) {
			$bank['cr'] -= $_POST['ok'];
			$bank['ekr'] += $_POST['ok'] / 16;
			$add_ekr=$_POST['ok'] / 16;
			if (mysql_query("UPDATE `bank` SET `cr` = `cr` - '".$_POST['ok']."' WHERE `id`= ".$bank['id']." LIMIT 1;")) {
				$mywarn="����� ���������� �������";
				mysql_query("UPDATE `bank` SET `ekr` = `ekr` + '$add_ekr' WHERE `id`= ".$_SESSION['bankid']." LIMIT 1;");
				$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = ".$_SESSION['bankid'].";"));
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','�������� \"".$user['login']."\" ������� ".$_POST['ok']." ��. �� ".$add_ekr." ���. �� ����� �".$_SESSION['bankid']." � �����. ',1,'".time()."');");
			}
			else {
				$mywarn="��������� ������!";
			}
		}
		else {
			$mywarn="� ��� ������������ ����� ��� ���������� ��������";
		}
		$_POST['changeback']=0;
	}
	if($_GET['dropm']) {
		if (2 <= $bank['ekr']) {
			undressall($user['id']);
			if (mysql_query("UPDATE `users` SET `master` = noj+mec+topor+dubina+mfire+mwater+mair+mearth+mlight+mgray+mdark+master,noj=0,mec=0,topor=0,dubina=0,mfire=0,mwater=0,mair=0,mearth=0,mlight=0,mgray=0,mdark=0 WHERE `id`= ".$user['id']." LIMIT 1;")) {
				mysql_query("UPDATE `bank` SET `ekr` = `ekr` - '2' WHERE `id`= ".$_SESSION['bankid']." LIMIT 1;");
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" ��������������� ������, �������� 2 ���. �� ����� �".$_SESSION['bankid']." � �����. ',1,'".time()."');");
				$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = ".$_SESSION['bankid'].";"));
				$mywarn="��� ������ ������. �� ������ ���������������� ������.";
			}
			else {
				$mywarn="��������� ������!";
			}
		}
		else {
			$mywarn="� ��� ������������ ����� �� �������� ����� ��� ���������� ��������";
		}
		$_GET['dropm']=0;
	}

	if($_GET['dropst']) {
		$travma = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = ".$user['id']." and (`type`=11 or `type`=12 or `type`=13 or `type`=14) order by `type` desc limit 1;"));
		if ($travma['type']) {
			$mywarn="���������� ���������� ����� �������� � ������!";
		}
		else {
			undressall($user['id']);
			$user1 = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$user['id']}' LIMIT 1;"));
			$svstats=$user1['sila'] + $user1['lovk'] + $user1['inta'] + $user1['vinos'] + $user1['intel'] + $user1['mudra'] - 12 - $user1['level'];
			if ($svstats <= $bank['ekr']) {


				$exps = array("20" => array (15),
						"45" => array (16),
						"75" => array (17),
						"110" => array (18),
						"160" => array (21),
						"215" => array (22),
						"280" => array (23),
						"350" => array (24),
						"410" => array (25),
						"530" => array (28),
						"670" => array (29),
						"830" => array (30),
						"950" => array (31),
						"1100" => array (32),
						"1300" => array (33),
						"1450" => array (36),
						"1650" => array (37),
						"1850" => array (38),
						"2050" => array (39),
						"2200" => array (40),
						"2500" => array (41),
						"2900" => array (46),
						"3350" => array (47),
						"3800" => array (48),
						"4200" => array (49),
						"4600" => array (50),
						"5000" => array (51),
						"6000" => array (54),
						"7000" => array (55),
						"8000" => array (56),
						"9000" => array (57),
						"10000" => array (58),
						"11000" => array (59),
						"12000" => array (60),
						"12500" => array (61),
						"14000" => array (64),
						"15500" => array (65),
						"17000" => array (66),
						"19000" => array (67),
						"21000" => array (68),
						"23000" => array (69),
						"27000" => array (70),
						"30000" => array (71),
						"60000" => array (76),
						"75000" => array (77),
						"150000" => array (78),
						"175000" => array (79),
				);
				echo "<pre>";
				$ss = mysql_query("select `id`,`nextup`,`level` FROM `users` WHERE `level` > 0 AND `level` < 8 AND id=".$user['id'].";");
				$errdo=0;
				while($ssd=mysql_fetch_array($ss)) {
					undressall($ssd['id']);
					if (!mysql_query( "UPDATE `users` SET `sila`='3',`lovk`='3',`inta`='3',`vinos`='".(3+$ssd['level'])."',`intel`='0',`stats` = ".($exps[$ssd['nextup']][0]-12)." WHERE `id`=".$ssd['id'].";\n")) $errdo=1;
					//; // ,$ssd['nextup'],"
					}


                if ($errdo==0) {
					mysql_query("UPDATE `bank` SET `ekr` = `ekr` - '".$svstats."' WHERE `id`= ".$_SESSION['bankid']." LIMIT 1;");
					mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" ��������������� �����, �������� ".$svstats." ���. �� ����� �".$_SESSION['bankid']." � �����. ',1,'".time()."');");
					$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = ".$_SESSION['bankid'].";"));
					$mywarn="��� ������ ������. �� ������ ���������������� �����.";
					}
				else $mywarn="��������� ������! ���������� � ����������.";

			}
			else {
				$mywarn="� ��� ������������ ����� �� �������� ����� ��� ���������� ��������";
			}
		}
		$_GET['dropst']=0;
	}
	if($_GET['dropsh']) {
		if (1 <= $bank['ekr']) {
			if (mysql_query("UPDATE `users` SET `shadow` = '0.gif' WHERE `id`= ".$user['id']." LIMIT 1;")) {
				mysql_query("UPDATE `bank` SET `ekr` = `ekr` - '1' WHERE `id`= ".$_SESSION['bankid']." LIMIT 1;");
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" ������ �����, �������� 1 ���. �� ����� �".$_SESSION['bankid']." � �����. ',1,'".time()."');");
				$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = ".$_SESSION['bankid'].";"));
				$mywarn="��� ������ ������. �� ������ ������� ����� ����� ���������.";
			}
			else {
				$mywarn="��������� ������!";
			}
		}
		else {
			$mywarn="� ��� ������������ ����� �� �������� ����� ��� ���������� ��������";
		}
		$_GET['dropsh']=0;
	}

	if($_POST['wu'] && $_POST['sum'] && $_POST['number']) {

		if ($user['align'] == 4) {
			$mywarn="��������� �������� ���������!";
		}
		else {
			$bank2 = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = ".$_POST['number'].";"));
			$to = mysql_fetch_array(mysql_query("SELECT login FROM `users` WHERE `id` = ".$bank2['owner'].";"));
			if($bank2[0]){
				$_POST['sum'] = round($_POST['sum'],2);
				if (is_numeric($_POST['sum']) && ($_POST['sum']>0)) {
					$nalog=round($_POST['sum']*0.03);
					if ($nalog < 1) {$nalog=1; }
					$new_sum=$_POST['sum']+$nalog;
					if ($new_sum <= $bank['cr']) {
						if (mysql_query("UPDATE `bank` SET `cr` = `cr` - '".$new_sum."' WHERE `id`= ".$_SESSION['bankid']." LIMIT 1;")) {
							mysql_query("UPDATE `bank` SET `cr` = `cr` + '".$_POST['sum']."' WHERE `id`= ".$_POST['number']." LIMIT 1;");
							$bank = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE `id` = ".$_SESSION['bankid'].";"));
							mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','�������� \"".$user['login']."\" ������� �� ������ ����������� ����� �".$_SESSION['bankid']." �� ���� �".$_POST['number']." � ��������� ".$to['login']." ".$_POST['sum']." ��. ������������� ����� ".$nalog." ��. �� ������ ����� ',1,'".time()."');");
							mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$bank2['owner']}','�������� \"".$user['login']."\" ������� �� ������ ����������� ����� �".$_SESSION['bankid']." �� ���� �".$_POST['number']." � ��������� ".$to['login']." ".$_POST['sum']." ��. ������������� ����� ".$nalog." ��. �� ������ ����� ',1,'".time()."');");
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
	<table width=100% border=0>
	<tr>
		<td  valign=top>
				<fieldset>
					<legend>��������� ����������� <br>� ������� �������</legend>
<?

						function get_content()
 						{
							$date = date("d/m/Y");
							$link = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$date";
							$fd = fopen($link, "r");
							$text="";
							if (!$fd) echo "������������� �������� �� �������";
							else
							{
								while (!feof ($fd)) $text .= fgets($fd, 4096);
							}
							fclose ($fd);
							return $text;
						}

	$content = get_content();
	$pattern = "#<Valute ID=\"([^\"]+)[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>([^<]+)#i";
	preg_match_all($pattern, $content, $out, PREG_SET_ORDER);
	foreach($out as $cur)
	{
		if($cur[2] == 840) $dollar = str_replace(",",".",$cur[4]);

		if($cur[2] == 978) $euro   = str_replace(",",".",$cur[4]);

		if($cur[2] == 980) $grivna   = str_replace(",",".",$cur[4]);

	}

	echo "<B>1</B> ECR = <B>0.2</B> EUR<BR>";
	echo "<B>1</B> ECR = <B>".round($dollar/5,3)."</B> RUR<BR>";
	echo "<B>1</B> ECR = <B>".round(($dollar/$grivna*10)/5,3)."</B> UAH<BR>";
	echo "<B>1</B> ECR = <B>".round(($euro/$dollar)/5,3)."</B> USD<BR>";
	echo "<B>1</B> ECR = <B>10</B> ��.<BR>";
?>
				</fieldset>
				<!--<fieldset>
					<legend>��������� �������� ����</legend>
					<table width=100%>
					<form action="bank.php?addekr=1" method="POST" target="_blank">
					<tr>
						<td>�����:</td><td>
						<input type="text" name="amount"></td>
						<td valign=middle>
						<input type="submit" value="���������" /></td>
					</tr></form>
				</table>
				</fieldset>
				<br>-->
				<fieldset>
					<legend>�������� ���. �� ��.</legend>
					<table width=100%>
					<form method="POST">
					<tr>
						<td>����� ���. ��� ������ </td>
					</tr>
					<TR><td><input type=text name=ok></td><td valign=middle> <input type=submit name=change style="width:60px;" value="��������"></td></tr>
					</form>
				</table>
				<small> ���� ������: 1 ���. = 10 ��. </small>
				</fieldset>
<?if($user['klan']=='adminion'){?>
                
					<fieldset>
					<legend>�������� ��. �� ���.</legend>
					<table width=100%>
					<form method="POST">
					<tr>
						<td>����� ��. ��� ������ </td>
					</tr>
					<tr><td><input type=text name=ok></td><td valign=middle> <input type=submit name=changeback style="width:60px;" value="��������"></td></tr>
					</form>
					</table>
					<small> ���� ������: 16 ��. = 1 ���. </small>
					</fieldset>
               
<?}?>
				</td>
		<td valign=top style="width:300px;">
			<fieldset>
				<legend>���������� � �����</legend>
				C��� � <B><?=$bank['id']?></B><BR>
				�������� �� �����: <B><?=$bank['cr']?></B> ��.<BR>
				������������ �� �����: <B><?=$bank['ekr']?></B> ���.<BR>
				�������� � ���������: <B><?=$user['money']?></B> ��.<BR>
				������������ � ���������: <B><?=$user['ekr']?></B> ���.<BR>
				<a href="?exit=1">�����</a>
			</fieldset><form method="post">
			<fieldset>
				<legend>��������</legend>
				<table width=100%>
				<TR><TD>�������� ��. �� ����</td><TD><input type=text size=6 name=ik></td><TD><input type=submit name=in style="width:60px;" value="��������"></td></tR>
				<TR><TD>����� �� �� �����</td><TD><input type=text size=6 name=ok></td><TD><input type=submit name=out style="width:60px;" value=  "�����"></td></tR>
				<TR><TD>�������� ���. �� ����</td><TD><input type=text size=6 name=ekrik></td><TD><input type=submit name=ekrin style="width:60px;" value="��������"></td></tR>
				<TR><TD>����� ��� �� �����</td><TD><input type=text size=6 name=ekrok></td><TD><input type=submit name=ekrout style="width:60px;" value=  "�����"></td></tR>
				</table>
			</fieldset></form><form method="post">
			<fieldset>
				<legend>��������� ������ �� ����</legend>
				<table width=100%>
				<TR><TD>�����</td><TD><input type=text size=12 name=sum></td><TD rowspan=2 align=center valign=middle><input type=submit name=wu style="width:60px;" value=  "���������"></td></tR>
				<TR><TD>����� �����</td><TD><input type=text size=12 name=number></td></tR>
				</table>
				<small> �������� �������� 3% �� ����������� �����, �� �� ����� 1 ��. </small>
			</fieldset></form>
		</td>

		<Td width=30% valign=top><fieldset style="text-align:justify;">
						<legend>����������</legend>
							<DD>���� ��������� ��������� �������� �� �������. ����������� ������ ������ ��� ���������� ������ � ���������� ��������� � ��. ��� �� ��� �������� ������ ��������� ���� ���������� �� ��������������.
							<dd>����� ������� ������, ���������� ��� �����������. �� ��� ����� ���������� �������, ��������� ����������, �� �������� �� ������ �������, ��� �� �������� ������������ ������. ��������: ����� ����� ���������, ����� ���� ���������, �����  ���� �������� ���������, ����� ��������� ������ ���������. ����� ������ ���������. ����� ������ ���������.
						</fieldset>

				</td>
	</tr>
	</table>
	<?
}
?>
<br><div align=left>
	<?php include("mail_ru.php"); ?>
<div>
</body>
</html>
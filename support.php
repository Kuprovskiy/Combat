<?
session_start();
include"connect.php";
if ($_SESSION['uid'] == null) {print'<h2><font color=red>��������� �����������! ����� ���� ��������� �� ����� ����������';}
$p = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id`='{$_SESSION['uid']}'"));
?>
<script LANGUAGE='JavaScript'>
document.ondragstart = test;
//������ �� ��������������
//������ �� ��������� ��������� ��������
document.oncontextmenu = test;
//������ �� ��������� ������������ ����
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
<title>������ ��������� ����������� ����� - support</title>
<link href="/img/support/css/common.css?ver=1" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="/img/support/js/common.js?ver=1"></SCRIPT>
</head>
<body>
	<script type="text/javascript">
		l = {confirmCategory: "����������, ��������� ��� ��������� ��������� ������������ ���� ���������. ��������� � ������������ ���������� �� ����� ���������������. ���� �� ����� - ������� ��. ����� ������� ������ � �������� ������ ���������. ��������� ���������: ",selectCategory: "����������, �������� ���������"		}
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
<center><h3><span style="color: #ff0000;">������ ��������� ����������� �����<br></span></h3></center>
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
	
11: '����� ������� �� - ������� �� �������� ���������',	
	
21: '��������� �� - ���������������� ���������� (������)',	
	
22: '��������� �� - ������ ����� (������)',	
	
23: '��������� �� - ������ ������ �����',	
	
24: '��������� �� - ������ ������ ����',	
	
25: '��������� �� - ������� � ������ (������)',	
	
31: '������ �� - ���������� � ����������',	
	
32: '������ �� - ������',	
	
33: '������ �� - ����, ��������',	
	
34: '������ �� - ����� �����',	
	
35: '������ �� - ���������',	
	
36: '������ �� - ������',	
	
37: '������ �� - ��������',	
	
38: '������ �� - �����',	
	
39: '������ �� - ���������',	
	
310: '������ �� - ��������',	
	
311: '������ �� - ����������',	
	
312: '������ �� - ���, �����',	
	
313: '������ �� - ��������� ���/� ��������������������� ����',	
	
314: '������ �� - ������ ������',	
	
41: '����������� �� �� - ���� ����������� �� �������� �� (��� �������)',	
	
51: '������� - ������ � ������',	
	
52: '������� - ������',	
	
61: '����� �� - ����� �������',	
	
62: '����� �� - ��� ������� ����� ��',	
	
63: '����� �� - ��� �������� ������� �� ����� �� (������)',	
	
64: '����� �� - ����������� ������ ������ (������)',	
	
65: '����� �� - ������� � ��-����� ��',	
	
66: '����� �� - ������',	
	
71: '������������ ����� �� - �������� ��������� � �� (������)',	
	
72: '������������ ����� �� - ���-������ �� �� (������)',	
	
0: '������ - ������, �� �������� �� � ���� ���������'	
 
};
 
</script>
 
<center><h5>������� ����� ����</h5></center>
��������� �� ����������� � ������� �� ��������������� � ���������, �� ������� ��� � ���� �����.<br>���������� �� ���������.<br>
 
<form method="post" onSubmit="return checkForm(this);">
	<input type="hidden" name="action" value="send_feedback" />
		<table border="0" cellpadding="2" cellspacing="0">
			<tr>
				<td></td>
				<td>
				</td>
			</tr>
			<tr>
				<td align="right">��������: &nbsp;</td><td><b><?=$p['login']?></b></td>
			</tr>
<!--			<tr>
				<td align="right">E-mail: &nbsp;<sup style="color:red">*</sup></td><td><input type="text" name="user_email" value="" class="input" size="80" maxlength="50" /></td>
			</tr>
-->			
			<tr>
				<td align="right">���������: &nbsp;<sup style="color:red">*</sup></td><td><select name="message_type" class="input">
					<option style="color: #ff0000;" value="1001">����� ������� ��</option>
					<option  value="11">&nbsp;&nbsp;&nbsp;&nbsp;������� �� �������� ���������</option>
					<option style="color: #ff0000;" value="1002">��������� ��</option>
					<option  value="21">&nbsp;&nbsp;&nbsp;&nbsp;���������������� ���������� (������)</option>
					<option  value="22">&nbsp;&nbsp;&nbsp;&nbsp;������ ����� (������)</option>
					<option  value="23">&nbsp;&nbsp;&nbsp;&nbsp;������ ������ �����</option>
					<option  value="24">&nbsp;&nbsp;&nbsp;&nbsp;������ ������ ����</option>
					<option  value="25">&nbsp;&nbsp;&nbsp;&nbsp;������� � ������ (������)</option>
					<option style="color: #ff0000;" value="1003">������ ��</option>
					<option  value="31">&nbsp;&nbsp;&nbsp;&nbsp;���������� � ����������</option>
					<option  value="32">&nbsp;&nbsp;&nbsp;&nbsp;������</option>
					<option  value="33">&nbsp;&nbsp;&nbsp;&nbsp;����, ��������</option>
					<option  value="34">&nbsp;&nbsp;&nbsp;&nbsp;����� �����</option>
					<option  value="35">&nbsp;&nbsp;&nbsp;&nbsp;���������</option>
					<option  value="36">&nbsp;&nbsp;&nbsp;&nbsp;������</option>
					<option  value="37">&nbsp;&nbsp;&nbsp;&nbsp;��������</option>
					<option  value="38">&nbsp;&nbsp;&nbsp;&nbsp;�����</option>
					<option  value="39">&nbsp;&nbsp;&nbsp;&nbsp;���������</option>
					<option  value="310">&nbsp;&nbsp;&nbsp;&nbsp;��������</option>
					<option  value="311">&nbsp;&nbsp;&nbsp;&nbsp;����������</option>
					<option  value="312">&nbsp;&nbsp;&nbsp;&nbsp;���, �����</option>
					<option  value="313">&nbsp;&nbsp;&nbsp;&nbsp;��������� ���/� ��������������������� ����</option>
					<option  value="314">&nbsp;&nbsp;&nbsp;&nbsp;������ ������</option>
					<option style="color: #ff0000;" value="1004">����������� �� ��</option>
					<option  value="41">&nbsp;&nbsp;&nbsp;&nbsp;���� ����������� �� �������� �� (��� �������)</option>
					<option style="color: #ff0000;" value="1005">�������</option>
					<option  value="51">&nbsp;&nbsp;&nbsp;&nbsp;������ � ������</option>
					<option  value="52">&nbsp;&nbsp;&nbsp;&nbsp;������</option>
					<option style="color: #ff0000;" value="1006">����� ��</option>
					<option  value="61">&nbsp;&nbsp;&nbsp;&nbsp;����� �������</option>
					<option  value="62">&nbsp;&nbsp;&nbsp;&nbsp;��� ������� ����� ��</option>
					<option  value="63">&nbsp;&nbsp;&nbsp;&nbsp;��� �������� ������� �� ����� �� (������)</option>
					<option  value="64">&nbsp;&nbsp;&nbsp;&nbsp;����������� ������ ������ (������)</option>
					<option  value="65">&nbsp;&nbsp;&nbsp;&nbsp;������� � ��-����� ��</option>
					<option  value="66">&nbsp;&nbsp;&nbsp;&nbsp;������</option>
					<option style="color: #ff0000;" value="1007">������������ ����� ��</option>
					<option  value="71">&nbsp;&nbsp;&nbsp;&nbsp;�������� ��������� � �� (������)</option>
					<option  value="72">&nbsp;&nbsp;&nbsp;&nbsp;���-������ �� �� (������)</option>
					<option style="color: #ff0000;" value="1100">������</option>
					<option  value="0">&nbsp;&nbsp;&nbsp;&nbsp;������, �� �������� �� � ���� ���������</option>
				</td>
			</tr>
 
			<tr>
				<td align="right">����: &nbsp;<sup style="color:red">*</sup></td><td><input type="text" name="message_subject" value="" class="input" size="80" maxlength="100" /></td>
			</tr>
 
			<tr>

			<td valign="top" align="right">���������: &nbsp;<sup style="color:red">*</sup></td><td><textarea name="message" cols="81" rows="15" class="input" maxlength="3000"  onkeyup="ismaxlength(this)"  onmousedown="ismaxlength(this)" style="width:600px; height: 200px;" onselect="ismaxlength(this)"></textarea></td>
			</tr>
			<tr>
				<td valign="top"></td><td align="ridght"><input type="submit" value="��������� ���������" class="input" /></td>
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
		//mail("miha.babushkin@mail.ru","����",$aa,$headers);
		mail("miha.babushkin@mail.ru","",$aa,$headers);
		echo "<center><font color='blue' size='14'><h3>�����������.</h3></font></center>";
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

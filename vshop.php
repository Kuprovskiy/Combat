<?php
	session_start();
	if ($_SESSION['uid'] == null) header("Location: index.php");
	include "connect.php";
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
	include "functions.php";
//	if ($user['room'] != 34) header("Location: main.php");
	$d = mysql_fetch_array(mysql_query("SELECT sum(`massa`) FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `setsale` = 0 ; "));
	if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }
	$_GET['otdel'] = 1;

	if(!$_SESSION['flowers']) { $_SESSION['flowers'] = array(); }

	if ($_GET['add']) {
		$dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$_GET['add']}' AND `owner` = '{$_SESSION['uid']}' LIMIT 1;"));
		//destructitem($dress['id']);
		//mysql_query("UPDATE `users` set `money` = `money`+ '".(round(($dress['cost']/2)-$dress['duration']*($dress['cost']/($dress['maxdur']*10)),2))."' WHERE id = {$_SESSION['uid']}");
		//echo "<font color=red><b>�� ������� \"{$dress['name']}\".</b></font>";
		if($dress) {
			$_SESSION['flowers'][$dress['id']] = array($dress['img'],$dress['id'],$dress['name']);
		}
	}
	if ($_POST['delflower']) {
		unset($_SESSION['flowers'][$_POST['flower']]);
	}



	if (($_GET['set'] OR $_POST['set'])) {
		if ($_GET['set']) { $set = $_GET['set']; }
		if ($_POST['set']) { $set = $_POST['set']; }
		if ($_POST['count'] < 1) { $_POST['count'] =1; }
		$dress = mysql_fetch_array(mysql_query("SELECT * FROM `fshop` WHERE `id` = '{$set}' LIMIT 1;"));
		if (($dress['massa']*$_POST['count']+$d[0]) > (get_meshok())) {
			echo "<font color=red><b>������������ ����� � �������.</b></font>";
		}
		elseif(($user['money']>= ($dress['cost']*$_POST['count'])) && ($dress['count'] >= $_POST['count'])) {

			for($k=1;$k<=$_POST['count'];$k++) {
				if(mysql_query("INSERT INTO `inventory`
				(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`isrep`,
					`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
					`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`
				)
				VALUES
				('{$dress['id']}','{$_SESSION['uid']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
				'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}'
				) ;"))
				{
					$good = 1;
				}
				else {
					$good = 0;
				}
			}
			if ($good) {
				mysql_query("UPDATE `fshop` SET `count`=`count`-{$_POST['count']} WHERE `id` = '{$set}' LIMIT 1;");
				$limit=$_POST['count'];
				$invdb = mysql_query("SELECT `id` FROM `inventory` WHERE `name` = '".$dress['name']."' ORDER by `id` DESC LIMIT ".$limit." ;" );
				if ($limit == 1) {
					$dressinv = mysql_fetch_array($invdb);
					$dressid = "cap".$dressinv['id'];
					$dresscount=" ";
				}
				else {
					$dressid="";
					while ($dressinv = mysql_fetch_array($invdb))  {
						$dressid .= "cap".$dressinv['id'].",";
					}
					$dresscount="(x".$_POST['count'].") ";
				}
				$allcost=$_POST['count']*$dress['cost'];

				echo "<font color=red><b>�� ������ {$_POST['count']} ��. \"{$dress['name']}\".</b></font>";
				mysql_query("UPDATE `users` set `money` = `money`- '".($_POST['count']*$dress['cost'])."' WHERE id = {$_SESSION['uid']}");
				mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" ����� �����: \"".$dress['name']."\" ".$dresscount."id:(".$dressid.") [0/".$dress['maxdur']."] �� ".$allcost." ��. ',1,'".time()."');");
			}
		}
		else {
			echo "<font color=red><b>������������ ����� ��� ��� ����� � �������.</b></font>";
		}
	}

?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<SCRIPT LANGUAGE="JavaScript">
function AddCount(name, txt)
{
	document.all("hint3").innerHTML = '<form method=post style="margin:0px; padding:0px;"><table border=0 width=100% cellspacing=1 cellpadding=0 bgcolor="#CCC3AA"><tr><td align=center><B>������ ����. ����</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</TD></tr><tr><td colspan=2>'+
	'<table border=0 width=100% cellspacing=0 cellpadding=0 bgcolor="#FFF6DD"><tr><INPUT TYPE="hidden" name="set" value="'+name+'"><td colspan=2 align=center><B><I>'+txt+'</td></tr><tr><td width=80% align=right>'+
	'���������� (��.) <INPUT TYPE="text" NAME="count" size=4 ></td><td width=20%>&nbsp;<INPUT TYPE="submit" value=" �� ">'+
	'</TD></TR></TABLE></td></tr></table></form>';
	document.all("hint3").style.visibility = "visible";
	document.all("hint3").style.left = event.x+document.body.scrollLeft-20;
	document.all("hint3").style.top = event.y+document.body.scrollTop+5;
	document.all("count").focus();
}
// ��������� ����
function closehint3()
{
	document.all("hint3").style.visibility="hidden";
}
</SCRIPT>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=#e0e0e0>
<TABLE border=0 width=100% cellspacing="0" cellpadding="0">
<FORM action="city.php" method=GET>
<tr><td><h3>������� ���������� 2012</td><td align=right>
<INPUT TYPE="button" value="���������" style="background-color:#A9AFC0" onclick="window.open('help/shop.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">
<INPUT TYPE="submit" value="���������" name="strah"></td></tr>
</FORM>
</table>
<img src="http://zabastovka.com/sites/default/files/uhuyhu.jpg" alt="�������������� �����">
<?
		$bukets = array (
						"����� ��������� 1" => array(
							"�������"=>1,
							"����� ��� ���������� 1"=>1
						),
						"����� ��������� 3" => array(
							"�������"=>3,
							"����� ��� ���������� 1"=>1
						),
						"����� ��������� 5" => array(
							"�������"=>5,
							"����� ��� ���������� 2"=>1
						),
						"����� ��������� 7" => array(
							"�������"=>7,
							"����� ��� ���������� 3"=>1
						),
						"����� ��������� 9" => array(
							"�������"=>9,
							"����� ��� ���������� 4"=>1
						),
						"����� ��������� 21" => array(
							"�������"=>21,
							"����� ��� ���������� 5"=>1
						),
						"����� ��������� 1" => array(
							"�������"=>1,
							"����� ��� ���������� 1"=>1
						),
						"����� ��������� 3" => array(
							"�������"=>3,
							"����� ��� ���������� 1"=>1
						),
						"����� ��������� 5" => array(
							"�������"=>5,
							"����� ��� ���������� 2"=>1
						),
						"����� ��������� 7" => array(
							"�������"=>7,
							"����� ��� ���������� 3"=>1
						),
						"����� ��������� 9" => array(
							"�������"=>9,
							"����� ��� ���������� 4"=>1
						),
						"����� ��������� 21" => array(
							"�������"=>21,
							"����� ��� ���������� 5"=>1
						),
						"����� ������ 3" => array(
							"������"=>3,
							"����� ��� ���������� 1"=>1
						),
						"����� ������ 5" => array(
							"������"=>5,
							"����� ��� ���������� 2"=>1
						),
						"����� ������ 7" => array(
							"������"=>7,
							"����� ��� ���������� 3"=>1
						),
						"����� ������ 9" => array(
							"������"=>9,
							"����� ��� ���������� 4"=>1
						),
						"����� ������ 21" => array(
							"������"=>21,
							"����� ��� ���������� 5"=>1
						),
						"����� �������� 3" => array(
							"��������"=>3,
							"����� ��� ���������� 1"=>1
						),
						"����� �������� 5" => array(
							"��������"=>5,
							"����� ��� ���������� 2"=>1
						),
						"����� �������� 7" => array(
							"��������"=>7,
							"����� ��� ���������� 3"=>1
						),
						"����� �������� 9" => array(
							"��������"=>9,
							"����� ��� ���������� 4"=>1
						),
						"����� �������� 21" => array(
							"��������"=>21,
							"����� ��� ���������� 5"=>1
						),
						"����� ��������� 3" => array(
							"����������"=>3,
							"����� ��� ���������� 1"=>1
						),
						"����� ��������� 5" => array(
							"����������"=>5,
							"����� ��� ���������� 2"=>1
						),
						"����� ��������� 7" => array(
							"����������"=>7,
							"����� ��� ���������� 3"=>1
						),
						"����� ��������� 9" => array(
							"����������"=>9,
							"����� ��� ���������� 4"=>1
						),
						"����� ��������� 21" => array(
							"����������"=>21,
							"����� ��� ���������� 5"=>1
						),
						"����� ��� 3" => array(
							"������ ����"=>3,
							"����� ��� ���������� 1"=>1
						),
						"����� ��� 5" => array(
							"������ ����"=>5,
							"����� ��� ���������� 2"=>1
						),
						"����� ��� 7" => array(
							"������ ����"=>7,
							"����� ��� ���������� 3"=>1
						),
						"����� ��� 9" => array(
							"������ ����"=>9,
							"����� ��� ���������� 4"=>1
						),
						"����� ��� 21" => array(
							"������ ����"=>21,
							"����� ��� ���������� 5"=>1
						),
						"����� ��������� 3" => array(
							"���������"=>3,
							"����� ��� ���������� 1"=>1
						),
						"����� ��������� 5" => array(
							"���������"=>5,
							"����� ��� ���������� 2"=>1
						),
						"����� ��������� 7" => array(
							"���������"=>7,
							"����� ��� ���������� 3"=>1
						),
						"����� ��������� 9" => array(
							"���������"=>9,
							"����� ��� ���������� 4"=>1
						),
						"����� ��������� 21" => array(
							"���������"=>21,
							"����� ��� ���������� 5"=>1
						),
						"����� ����� 3" => array(
							"�����"=>3,
							"����� ��� ���������� 1"=>1
						),
						"����� ����� 5" => array(
							"�����"=>5,
							"����� ��� ���������� 2"=>1
						),
						"����� ����� 7" => array(
							"�����"=>7,
							"����� ��� ���������� 3"=>1
						),
						"����� ����� 9" => array(
							"�����"=>9,
							"����� ��� ���������� 4"=>1
						),
						"����� ����� 21" => array(
							"�����"=>21,
							"����� ��� ���������� 5"=>1
						),
						"����� �����������" => array(
							"���������� ������"=>3,
							"����� ��� ���������� 1"=>1
						),
						"����� ����������" => array(
							"���������� ������"=>5,
							"����� ��� ���������� 2"=>1
						),
						"����� ���������" => array(
							"���������� ������"=>7,
							"����� ��� ���������� 3"=>1
						),
						"����� �������" => array(
							"���������� ������"=>9,
							"����� ��� ���������� 4"=>1
						),
						"����� ���������" => array(
							"���������� ������"=>21,
							"����� ��� ���������� 5"=>1
						),
						"����� ����������" => array(
							"������ ������"=>3,
							"����� ��� ���������� 1"=>1
						),
						"����� ����������" => array(
							"������ ������"=>5,
							"����� ��� ���������� 2"=>1
						),
						"����� ���������" => array(
							"������ ������"=>7,
							"����� ��� ���������� 3"=>1
						),
						"����� �������" => array(
							"������ ������"=>9,
							"����� ��� ���������� 4"=>1
						),
						"����� �������" => array(
							"������ ������"=>21,
							"����� ��� ���������� 5"=>1
						),
					);
	if($_POST['docompare']) {
		$resultbuk = array (
						"����� ��������� 1"=>array(
								"name"=>"����� ��������� 1",
								'maxdur'=>1,
								"img"=>"tulip1.gif",
								'minu'=>1,
								'maxu'=>2,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��������� 3"=>array(
								"name"=>"����� ��������� 3",
								'maxdur'=>3,
								"img"=>"tulip3.gif",
								'minu'=>1,
								'maxu'=>3,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��������� 5"=>array(
								"name"=>"����� ��������� 5",
								'maxdur'=>5,
								"img"=>"tulip5.gif",
								'minu'=>1,
								'maxu'=>5,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��������� 7"=>array(
								"name"=>"����� ��������� 7",
								'maxdur'=>7,
								"img"=>"tulip7.gif",
								'minu'=>1,
								'maxu'=>7,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��������� 9"=>array(
								"name"=>"����� ��������� 9",
								'maxdur'=>9,
								"img"=>"tulip9.gif",
								'minu'=>1,
								'maxu'=>9,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>1,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��������� 21"=>array(
								"name"=>"����� ��������� 21",
								'maxdur'=>10,
								"img"=>"tulip21.gif",
								'minu'=>1,
								'maxu'=>21,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>5,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��������� 1"=>array(
								"name"=>"����� ��������� 1",
								'maxdur'=>1,
								"img"=>"narcissus1.gif",
								'minu'=>1,
								'maxu'=>2,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��������� 3"=>array(
								"name"=>"����� ��������� 3",
								'maxdur'=>3,
								"img"=>"narcissus3.gif",
								'minu'=>1,
								'maxu'=>3,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��������� 5"=>array(
								"name"=>"����� ��������� 5",
								'maxdur'=>5,
								"img"=>"narcissus5.gif",
								'minu'=>1,
								'maxu'=>5,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��������� 7"=>array(
								"name"=>"����� ��������� 7",
								'maxdur'=>7,
								"img"=>"narcissus7.gif",
								'minu'=>1,
								'maxu'=>7,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��������� 9"=>array(
								"name"=>"����� ��������� 9",
								'maxdur'=>9,
								"img"=>"narcissus9.gif",
								'minu'=>1,
								'maxu'=>9,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>1,
								'goden'=>10),
						"����� ��������� 21"=>array(
								"name"=>"����� ��������� 21",
								'maxdur'=>10,
								"img"=>"narcissus21.gif",
								'minu'=>1,
								'maxu'=>21,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>5,
								'goden'=>10),
						"����� ������ 3"=>array(
								"name"=>"����� ������ 3",
								'maxdur'=>3,
								"img"=>"siren_3.gif",
								'minu'=>3,
								'maxu'=>5,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ������ 5"=>array(
								"name"=>"����� ������ 5",
								'maxdur'=>5,
								"img"=>"siren_5.gif",
								'minu'=>3,
								'maxu'=>7,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ������ 7"=>array(
								"name"=>"����� ������ 7",
								'maxdur'=>7,
								"img"=>"siren_7.gif",
								'minu'=>3,
								'maxu'=>9,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>15,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ������ 9"=>array(
								"name"=>"����� ������ 9",
								'maxdur'=>9,
								"img"=>"siren_9.gif",
								'minu'=>3,
								'maxu'=>15,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>15,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ������ 21"=>array(
								"name"=>"����� ������ 21",
								'maxdur'=>10,
								"img"=>"siren_21.gif",
								'minu'=>3,
								'maxu'=>25,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>15,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� �������� 3"=>array(
								"name"=>"����� �������� 3",
								'maxdur'=>3,
								"img"=>"cally_3.gif",
								'minu'=>3,
								'maxu'=>5,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� �������� 5"=>array(
								"name"=>"����� �������� 5",
								'maxdur'=>5,
								"img"=>"cally_5.gif",
								'minu'=>3,
								'maxu'=>7,
								'mfkrit'=>0,
								'mfakrit'=>1,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� �������� 7"=>array(
								"name"=>"����� �������� 7",
								'maxdur'=>7,
								"img"=>"cally_7.gif",
								'minu'=>3,
								'maxu'=>10,
								'mfkrit'=>0,
								'mfakrit'=>10,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� �������� 9"=>array(
								"name"=>"����� �������� 9",
								'maxdur'=>9,
								"img"=>"cally_9.gif",
								'minu'=>3,
								'maxu'=>15,
								'mfkrit'=>0,
								'mfakrit'=>15,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� �������� 21"=>array(
								"name"=>"����� �������� 21",
                                                                'cost'=>1,
								'maxdur'=>10,
								"img"=>"cally_21.gif",
								'minu'=>3,
								'maxu'=>25,
								'mfkrit'=>0,
								'mfakrit'=>20,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��������� 3"=>array(
								"name"=>"����� ��������� 3",
								'maxdur'=>3,
								"img"=>"chrysanthemum3.gif",
								'minu'=>2,
								'maxu'=>6,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��������� 5"=>array(
								"name"=>"����� ��������� 5",
								'maxdur'=>5,
								"img"=>"chrysanthemum5.gif",
								'minu'=>2,
								'maxu'=>8,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��������� 7"=>array(
								"name"=>"����� ��������� 7",
								'maxdur'=>7,
								"img"=>"chrysanthemum7.gif",
								'minu'=>2,
								'maxu'=>10,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��������� 9"=>array(
								"name"=>"����� ��������� 9",
								'maxdur'=>9,
								"img"=>"chrysanthemum9.gif",
								'minu'=>2,
								'maxu'=>12,
								'mfkrit'=>5,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��������� 21"=>array(
								"name"=>"����� ��������� 21",
								'maxdur'=>10,
								"img"=>"chrysanthemum21.gif",
								'minu'=>2,
								'maxu'=>24,
								'mfkrit'=>10,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��� 3"=>array(
								"name"=>"����� ��� 3",
								'maxdur'=>3,
								"img"=>"yrose3.gif",
								'minu'=>3,
								'maxu'=>7,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��� 5"=>array(
								"name"=>"����� ��� 5",
								'maxdur'=>5,
								"img"=>"yrose5.gif",
								'minu'=>3,
								'maxu'=>9,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��� 7"=>array(
								"name"=>"����� ��� 7",
								'maxdur'=>7,
								"img"=>"yrose7.gif",
								'minu'=>3,
								'maxu'=>11,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��� 9"=>array(
								"name"=>"����� ��� 9",
								'maxdur'=>9,
								"img"=>"yrose9.gif",
								'minu'=>3,
								'maxu'=>13,
								'mfkrit'=>0,
								'mfakrit'=>5,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��� 21"=>array(
								"name"=>"����� ��� 21",
								'maxdur'=>10,
								"img"=>"yrose21.gif",
								'minu'=>3,
								'maxu'=>25,
								'mfkrit'=>0,
								'mfakrit'=>10,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��������� 3"=>array(
								"name"=>"����� ��������� 3",
								'maxdur'=>3,
								"img"=>"hydrangea3.gif",
								'minu'=>3,
								'maxu'=>7,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��������� 5"=>array(
								"name"=>"����� ��������� 5",
								'maxdur'=>5,
								"img"=>"hydrangea5.gif",
								'minu'=>3,
								'maxu'=>9,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��������� 7"=>array(
								"name"=>"����� ��������� 7",
								'maxdur'=>7,
								"img"=>"hydrangea7.gif",
								'minu'=>3,
								'maxu'=>11,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��������� 9"=>array(
								"name"=>"����� ��������� 9",
								'maxdur'=>9,
								"img"=>"hydrangea9.gif",
								'minu'=>3,
								'maxu'=>13,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>10,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ��������� 21"=>array(
								"name"=>"����� ��������� 21",
								'maxdur'=>10,
								"img"=>"hydrangea21.gif",
								'minu'=>3,
								'maxu'=>25,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>10,
								'mfauvorot'=>10,
								'goden'=>10),
						"����� ����� 3"=>array(
								"name"=>"����� ����� 3",
								'maxdur'=>3,
								"img"=>"lillies3.gif",
								'minu'=>3,
								'maxu'=>7,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ����� 5"=>array(
								"name"=>"����� ����� 5",
								'maxdur'=>5,
								"img"=>"lillies5.gif",
								'minu'=>3,
								'maxu'=>9,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ����� 7"=>array(
								"name"=>"����� ����� 7",
								'maxdur'=>7,
								"img"=>"lillies7.gif",
								'minu'=>3,
								'maxu'=>11,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ����� 9"=>array(
								"name"=>"����� ����� 9",
								'maxdur'=>9,
								"img"=>"lillies9.gif",
								'minu'=>3,
								'maxu'=>13,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>10,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ����� 21"=>array(
								"name"=>"����� ����� 21",
								'maxdur'=>10,
								"img"=>"lillies21.gif",
								'minu'=>3,
								'maxu'=>25,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>10,
								'mfauvorot'=>10,
								'goden'=>10),
						"����� �����������"=>array(
								"name"=>"����� �����������",
								'maxdur'=>3,
								"img"=>"love3.gif",
								'minu'=>1,
								'maxu'=>3,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ����������"=>array(
								"name"=>"����� ����������",
								'maxdur'=>5,
								"img"=>"love5.gif",
								'minu'=>1,
								'maxu'=>5,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ���������"=>array(
								"name"=>"����� ���������",
								'maxdur'=>7,
								"img"=>"love7.gif",
								'minu'=>1,
								'maxu'=>7,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� �������"=>array(
								"name"=>"����� �������",
								'maxdur'=>9,
								"img"=>"love9.gif",
								'minu'=>1,
								'maxu'=>9,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>1,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ���������"=>array(
								"name"=>"����� ���������",
								'maxdur'=>10,
								"img"=>"love21.gif",
								'minu'=>1,
								'maxu'=>21,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>5,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ����������"=>array(
								"name"=>"����� ����������",
								'maxdur'=>3,
								"img"=>"flove3.gif",
								'minu'=>1,
								'maxu'=>3,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ����������"=>array(
								"name"=>"����� ����������",
								'maxdur'=>5,
								"img"=>"flove5.gif",
								'minu'=>1,
								'maxu'=>5,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� ���������"=>array(
								"name"=>"����� ���������",
								'maxdur'=>7,
								"img"=>"flove7.gif",
								'minu'=>1,
								'maxu'=>7,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� �������"=>array(
								"name"=>"����� �������",
								'maxdur'=>9,
								"img"=>"flove9.gif",
								'minu'=>1,
								'maxu'=>9,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>1,
								'mfauvorot'=>0,
								'goden'=>10),
						"����� �������"=>array(
								"name"=>"����� �������",
								'maxdur'=>10,
								"img"=>"flove21.gif",
								'minu'=>1,
								'maxu'=>21,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>5,
								'mfauvorot'=>0,
								'goden'=>10),
					);
		foreach ($_SESSION['flowers'] as $v) {
					$errs[$v[2]] ++;
		}
		foreach ($bukets as $k=>$v) {
			$zbor = true;
			foreach($v as $name=>$count) {
				if($errs[$name] != $count) { $zbor = false; }
				//unset ($errs[$name]);
			}
			//if(count($errs) > 0) { $zbor = false; }
			if ($zbor) {
				$dress = $resultbuk[$k];
				if(mysql_query("INSERT INTO `inventory`
				(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`isrep`,
					`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`maxu`,`minu`,`dategoden`,`goden`
				)
				VALUES
				('','{$_SESSION['uid']}','{$dress['name']}','3',1,0,'{$dress['img']}',{$dress['maxdur']},0,
				'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}',
				'{$dress['maxu']}','{$dress['minu']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}'
				) ;"))
				{
					$buket_id=mysql_insert_id();
					$good = 1;
				}
				else {
					$good = 0;
				}

				if ($good) {
					echo '<B><font color=red>������ ��������� ����� <img src="i/sh/',$dress['img'],'"><BR>(��������� � ��� � �������)</font>';
					foreach ($_SESSION['flowers'] as $k=>$v) {
						$dressid .= "cap".$k.",";
						mysql_query("DELETE FROM `inventory` WHERE `id` = '".$k."'  LIMIT 1;");
					}
					mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" �������� �������: \"".$dress['name']."\" ".$dresscount."id:(cap".$buket_id.") [0/".$dress['maxdur']."] �� id:(".$dressid.") ',1,'".time()."');");
				}
				else {
					echo '<B><font color=red>��������� ������!</font>';
				}
			}
		}
		if (!$good) {
                  echo "<b><font color=\"red\">�� ������� ��������� �����.</font>";
			/*foreach ($_SESSION['flowers'] as $k=>$v) {
				$fname=mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '".$k."' LIMIT 1;"));
				mysql_query("DELETE FROM `inventory` WHERE `id` = '".$k."'  LIMIT 1;");
				mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','������ ������� \"".$fname['name']."\" id:(cap".$k.") [".$fname['duration']."/".$fname['maxdur']."] � \"".$user['login']."\"  ',1,'".time()."');");
			}*/
		}
		$_SESSION['flowers'] = array();

	}
?>
<TABLE border=0 width=100% cellspacing="0" cellpadding="4">
<TR>
    <FORM METHOD=POST ACTION="vshop.php">
	<INPUT TYPE="hidden" name="sid" value="">
	<INPUT TYPE="hidden" name="id" value="1">
	<TD valign=top align=left>
<!--�������-->
<TABLE border=0 width=100% cellspacing="0" cellpadding="0" <?if (!$_REQUEST['present']) { echo 'bgcolor="#A5A5A5"';}?>>
<TR>
	<TD align=center><B><?php
	if ($_REQUEST['compare'] && !$_REQUEST['common'] && !$_REQUEST['present']) {
		echo "����������� ����������� ������";
	}
	elseif ($_REQUEST['present']) {
		//echo "����������� ����������� ������";
	}
	else
	{
		echo "�����. ����� ���.";
	}


	?></B></TD>
</TR>
<TR><TD><!--������-->
<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">
<?
if ($_REQUEST['compare'] && !$_REQUEST['common'] && !$_REQUEST['present']) {
	?>
	</table>
	<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#D5D5D5">
	<tr>
		<input type="hidden" value="1" name="compare">
		<td width=150px  valign=top><b>����� ��� ������:</b><BR>
		<div  align="right"><input type="submit" onclick="if(!confirm('��������! ��������� ������� � ����������� ������.\n��������, �� ������������� ������������ ������ ���������� ������.\n��������� �����?')) { return false; }" value="������� �����" name="docompare"></div>
		</td>
		<td  valign=top>
		<?
		unset($errs);
		foreach ($_SESSION['flowers'] as $v) {
			if($v[2] == "�������" OR $v[2] == "�������" OR $v[2] == "����������"  OR $v[2] == "������"   OR $v[2] == "��������"  OR $v[2] == "������ ����" OR $v[2] == "���������") {
					$errs[$v[2]] ++;
			}
		}
		if(count($errs) > 1) {
			echo '<font color=red>����� ����� ������� ������ �� ������ ������ ����!</font>';
		}

			if(!$_SESSION['flowers']) { echo '���������� ���� �����, �� ������� ������ ��������� �����'; } else {
				foreach ($_SESSION['flowers'] as $k=>$v) {
					echo '<form method="post" style="margin:0px; padding:0px;"><div style="float: left;" align="center"><img src="i/sh/',$v[0],'" align="center"><BR><input type="hidden" name="flower" value="',$k,'"><input type="hidden" value="1" name="compare"><input type="submit" value="������" name="delflower"></div></form>';
				}
			}
			?>
		</td>
	</tr>
	</table>
	<TABLE border=0 width=100% cellspacing="0" cellpadding="0" bgcolor="#A5A5A5">
	<TR>
		<TD align=center><B>����� � ��� � �������</B></TD>
	</tr>
	</table>
	<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">
	<?
	$data = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND (
		`name` LIKE '������� ���������%' OR
		`name` LIKE '���������� ���������%' OR
		`name` LIKE '�������� ���������%' OR
		`name` LIKE '���������� ���������%'
	) AND `setsale`=0 ORDER by `update` DESC; ");
	while($row = mysql_fetch_array($data)) {
		if(!in_array($row['id'],array_keys($_SESSION['flowers']))) {
			$row['count'] = 1;
			if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
			echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"i/sh/{$row['img']}\" BORDER=0>";
			?>
			<BR><A HREF="vshop.php?add=<?=$row['id']?>&sid=&compare=1">�������� � �����</A>
			</TD>
			<?php
			echo "<TD valign=top>";
			showitem ($row);
			echo "</TD></TR>";
		}
	}
	} elseif($_REQUEST['present']) {
        
	if($_POST['to_login'] && $_POST['flower']) {
		$to = mqfa("SELECT * FROM `users` WHERE `login` = '{$_POST['to_login']}'");
		if (!$to) $to=mqfa("SELECT * FROM `allusers` WHERE `login` = '{$_POST['to_login']}'");

		//$owner=mqfa1("select owner from inventory where id='$_POST[flower]'");
        
        $presInfo = mqfa("select owner, name from inventory where id='$_POST[flower]'");
        if (isset($bukets[$presInfo['name']])) {
            $owner = $presInfo['owner'];  
        } else {
            $owner = false;  
        }
        
		if (!$to) {
                  echo "<b><font color=red>�������� �� ������</font></b>";
		} elseif ($owner!=$user["id"]) {
                  echo "<b><font color=red>������� �� ������</font></b>";
                } elseif ($_POST['to_login'] == $user['login']) {
		  echo "<b><font color=red>����� ����� ������ ���-�� ������ ���� ;)</font></b>";
		} elseif ($to['room'] > 500 && $to['room'] < 561) {
		  echo "<b><font color=red>�������� � ������ ������ ��������� � ������� � ����� ������. ���������� �����.</font></b>";
		} else {
			if((int)$_POST['from']==1) { $from = '������'; }
			elseif((int)$_POST['from']==2 && $user['klan']) { $from = ' ���� '.$user['klan']; }
			else {$from = $user['login'];}
			if ($to) if(mysql_query("UPDATE `inventory` SET `owner` = '".$to['id']."', `present` = '".$from."', `letter` = '".$_POST['podarok2']."' WHERE  `present` = '' AND `id` = '".$_POST['flower']."' AND `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `name` LIKE '�����%' AND `setsale`=0")) {
				$buket = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$_POST['flower']}' AND `name` LIKE '�����%' LIMIT 1; "));
				$buket_name=$buket['name'];
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','������� ����� ������ \"".$buket['name']."\" id:(cap".$_POST['flower'].") [".$buket['duration']."/".$buket['maxdur']."] �� \"".$from."\" � \"".$to['login']."\"','1','".time()."');");
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$to['id']}','������� ����� ������ \"".$buket['name']."\" id:(cap".$buket['id'].") [".$buket['duration']."/".$buket['maxdur']."] �� \"".$from."\" � \"".$to['login']."\"','1','".time()."');");
				if(($_POST['from']==1) || ($_POST['from']==2)) {
					$action="�������";
					mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$to['id']}','������� ����� ������ \"".$buket['name']."\" id:(cap".$buket['id'].") [".$buket['duration']."/".$buket['maxdur']."] �� \"".$user['login']."\" � \"".$to['login']."\"','5','".time()."');");
				}
				else {
					if ($user['sex'] == 0) {$action="��������";}
					else {$action="�������";}
				}
				$us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$to['id']}' LIMIT 1;"));
				if($us[0]){
					addchp ('<font color=red>��������!</font> <span oncontextmenu=OpenMenu()>'.$from.'</span> '.$action.' ��� <B>'.$buket_name.'</B>.   ','{[]}'.$_POST['to_login'].'{[]}');
				} else {
					// ���� � ���
					mysql_query("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$to['id']."','','".'<font color=red>��������!</font> <span oncontextmenu=OpenMenu()>'.$from.'</span> '.$action.' ��� <B>'.$buket_name.'</B>.   '."');");
				}
				echo "<b><font color=red>����� ������ ��������� � \"",$_POST['to_login'],"\"</font></b>";
			}
			echo mysql_error();
		}
	}

		?>

<!-- �������� ������� -->
<form method="post">
<TABLE cellspacing=0 cellpadding=0 width=100% bgcolor=#e0e0e2><TD>
<INPUT TYPE=hidden name=present value=1>
�� ������ �������� ��� ����� �������� ��������. ��� ������� ����� ������������ � ���������� � ���������.
<OL>
<LI>������� ����� ���������, �������� ������ �������� �����<BR>
Login <INPUT TYPE=text NAME=to_login value="">
<LI>���� �������. ����� ������������ � ���������� � ��������� (�� ����� 60 ��������)<BR>
<INPUT TYPE=text NAME=podarok2 value="" maxlength=60 size=50>
<LI>�������� ����� ���������������� ������� (� ���������� � ��������� �� ������������)<BR>
<TEXTAREA NAME=txt ROWS=6 COLS=80></TEXTAREA>
<LI>��������, �� ����� ����� �������:<BR>
<INPUT TYPE=radio NAME=from value=0 checked> <? nick2($user['id']);?><BR>
<INPUT TYPE=radio NAME=from value=1 > ��������<BR>
<INPUT TYPE=radio NAME=from value=2 > �� ����� �����<BR>
<LI>������� ������ <B>��������</B> ��� �������, ������� ������ ����������� � �������:<BR>
</OL>
<input type="hidden" name="flower" id="flower" value="">
<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">
<?

//print_r($_POST);

	$data = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `name` LIKE '�����%' AND `setsale`=0 AND `present` = '' ORDER by `update` DESC; ");
	while($row = mysql_fetch_array($data)) {
		if(!in_array($row['id'],array_keys($_SESSION['flowers']))) {
			$row['count'] = 1;
			if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
			echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"i/sh/{$row['img']}\" BORDER=0>";
			?>
			<BR><input type="submit" onclick="document.all['flower'].value='<?=$row['id']?>';" value="��������">
			</TD>
			<?php
			echo "<TD valign=top>";
			showitem ($row);
			echo "</TD></TR>";
		}
	}
?>
</table>
</form>
		<?
	}
	else
	{
	$data = mysql_query("SELECT * FROM `fshop` WHERE `count` > 0 AND `razdel` = '{$_GET['otdel']}' ORDER by `cost` ASC");
	while($row = mysql_fetch_array($data)) {
		if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
		echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"i/sh/{$row['img']}\" BORDER=0>";
		?>
		<BR><A HREF="vshop.php?otdel=<?=$_GET['otdel']?>&set=<?=$row['id']?>&sid=">������</A>
		<IMG SRC="i/up.gif" WIDTH=11 HEIGHT=11 BORDER=0 ALT="������ ��������� ����" style="cursor:hand" onclick="AddCount('<?=$row['id']?>', '<?=$row['name']?>')"></TD>
		<?php
		echo "<TD valign=top>";
		showitem ($row);
		echo "</TD></TR>";
	}
}
?>
</TABLE>
</TD></TR>
</TABLE>

	</TD>
	<TD valign=top width=280>

	<CENTER><B>����� ���� ����� �����: <?php


	echo $d[0];
	?>/<?=get_meshok()?><BR>
	� ��� � �������: <FONT COLOR="#339900"><?=$user['money']?></FONT> ��.</B></CENTER>
	<div style="MARGIN-LEFT:15px; MARGIN-TOP: 10px;">
	<form method="post">
	<INPUT TYPE="submit" value="����� ���" name="common"><BR>
	<INPUT TYPE="submit" value="����������� ������" name="compare"><BR>
	<INPUT TYPE="submit" value="�������� �����" name="present"><BR>
	</div></form>
	<h3>��������� ������:</h3>
<?
  foreach ($bukets as $k=>$v) {
    echo "<b>$k</b>:<br>";
    foreach ($v as $k2=>$v2) {
      echo "$k2 <b>$v2</b> ��.<br>";
    }
    echo "<br><br>";
  }
?>
<div id="hint3" class="ahint"></div>
    </TD>
    </FORM>
</TR>
</TABLE>

<br><div align=left>

	<?php include("mail_ru.php"); ?>

<div>

</BODY>
</HTML>

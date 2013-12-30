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
		//echo "<font color=red><b>Вы продали \"{$dress['name']}\".</b></font>";
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
			echo "<font color=red><b>Недостаточно места в рюкзаке.</b></font>";
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

				echo "<font color=red><b>Вы купили {$_POST['count']} шт. \"{$dress['name']}\".</b></font>";
				mysql_query("UPDATE `users` set `money` = `money`- '".($_POST['count']*$dress['cost'])."' WHERE id = {$_SESSION['uid']}");
				mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" купил товар: \"".$dress['name']."\" ".$dresscount."id:(".$dressid.") [0/".$dress['maxdur']."] за ".$allcost." кр. ',1,'".time()."');");
			}
		}
		else {
			echo "<font color=red><b>Недостаточно денег или нет вещей в наличии.</b></font>";
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
	document.all("hint3").innerHTML = '<form method=post style="margin:0px; padding:0px;"><table border=0 width=100% cellspacing=1 cellpadding=0 bgcolor="#CCC3AA"><tr><td align=center><B>Купить неск. штук</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</TD></tr><tr><td colspan=2>'+
	'<table border=0 width=100% cellspacing=0 cellpadding=0 bgcolor="#FFF6DD"><tr><INPUT TYPE="hidden" name="set" value="'+name+'"><td colspan=2 align=center><B><I>'+txt+'</td></tr><tr><td width=80% align=right>'+
	'Количество (шт.) <INPUT TYPE="text" NAME="count" size=4 ></td><td width=20%>&nbsp;<INPUT TYPE="submit" value=" »» ">'+
	'</TD></TR></TABLE></td></tr></table></form>';
	document.all("hint3").style.visibility = "visible";
	document.all("hint3").style.left = event.x+document.body.scrollLeft-20;
	document.all("hint3").style.top = event.y+document.body.scrollTop+5;
	document.all("count").focus();
}
// Закрывает окно
function closehint3()
{
	document.all("hint3").style.visibility="hidden";
}
</SCRIPT>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=#e0e0e0>
<TABLE border=0 width=100% cellspacing="0" cellpadding="0">
<FORM action="city.php" method=GET>
<tr><td><h3>Магазин Валентинок 2012</td><td align=right>
<INPUT TYPE="button" value="Подсказка" style="background-color:#A9AFC0" onclick="window.open('help/shop.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">
<INPUT TYPE="submit" value="Вернуться" name="strah"></td></tr>
</FORM>
</table>
<img src="http://zabastovka.com/sites/default/files/uhuyhu.jpg" alt="альтернативный текст">
<?
		$bukets = array (
						"Букет тюльпанов 1" => array(
							"Тюльпан"=>1,
							"Трава для оформления 1"=>1
						),
						"Букет тюльпанов 3" => array(
							"Тюльпан"=>3,
							"Трава для оформления 1"=>1
						),
						"Букет тюльпанов 5" => array(
							"Тюльпан"=>5,
							"Трава для оформления 2"=>1
						),
						"Букет тюльпанов 7" => array(
							"Тюльпан"=>7,
							"Трава для оформления 3"=>1
						),
						"Букет тюльпанов 9" => array(
							"Тюльпан"=>9,
							"Трава для оформления 4"=>1
						),
						"Букет тюльпанов 21" => array(
							"Тюльпан"=>21,
							"Трава для оформления 5"=>1
						),
						"Букет нарциссов 1" => array(
							"Нарцисс"=>1,
							"Трава для оформления 1"=>1
						),
						"Букет нарциссов 3" => array(
							"Нарцисс"=>3,
							"Трава для оформления 1"=>1
						),
						"Букет нарциссов 5" => array(
							"Нарцисс"=>5,
							"Трава для оформления 2"=>1
						),
						"Букет нарциссов 7" => array(
							"Нарцисс"=>7,
							"Трава для оформления 3"=>1
						),
						"Букет нарциссов 9" => array(
							"Нарцисс"=>9,
							"Трава для оформления 4"=>1
						),
						"Букет нарциссов 21" => array(
							"Нарцисс"=>21,
							"Трава для оформления 5"=>1
						),
						"Букет сирени 3" => array(
							"Сирень"=>3,
							"Трава для оформления 1"=>1
						),
						"Букет сирени 5" => array(
							"Сирень"=>5,
							"Трава для оформления 2"=>1
						),
						"Букет сирени 7" => array(
							"Сирень"=>7,
							"Трава для оформления 3"=>1
						),
						"Букет сирени 9" => array(
							"Сирень"=>9,
							"Трава для оформления 4"=>1
						),
						"Букет сирени 21" => array(
							"Сирень"=>21,
							"Трава для оформления 5"=>1
						),
						"Букет рихардий 3" => array(
							"Рихардия"=>3,
							"Трава для оформления 1"=>1
						),
						"Букет рихардий 5" => array(
							"Рихардия"=>5,
							"Трава для оформления 2"=>1
						),
						"Букет рихардий 7" => array(
							"Рихардия"=>7,
							"Трава для оформления 3"=>1
						),
						"Букет рихардий 9" => array(
							"Рихардия"=>9,
							"Трава для оформления 4"=>1
						),
						"Букет рихардий 21" => array(
							"Рихардия"=>21,
							"Трава для оформления 5"=>1
						),
						"Букет хризантем 3" => array(
							"Хризантема"=>3,
							"Трава для оформления 1"=>1
						),
						"Букет хризантем 5" => array(
							"Хризантема"=>5,
							"Трава для оформления 2"=>1
						),
						"Букет хризантем 7" => array(
							"Хризантема"=>7,
							"Трава для оформления 3"=>1
						),
						"Букет хризантем 9" => array(
							"Хризантема"=>9,
							"Трава для оформления 4"=>1
						),
						"Букет хризантем 21" => array(
							"Хризантема"=>21,
							"Трава для оформления 5"=>1
						),
						"Букет роз 3" => array(
							"Желтая роза"=>3,
							"Трава для оформления 1"=>1
						),
						"Букет роз 5" => array(
							"Желтая роза"=>5,
							"Трава для оформления 2"=>1
						),
						"Букет роз 7" => array(
							"Желтая роза"=>7,
							"Трава для оформления 3"=>1
						),
						"Букет роз 9" => array(
							"Желтая роза"=>9,
							"Трава для оформления 4"=>1
						),
						"Букет роз 21" => array(
							"Желтая роза"=>21,
							"Трава для оформления 5"=>1
						),
						"Букет гортензий 3" => array(
							"Гортензия"=>3,
							"Трава для оформления 1"=>1
						),
						"Букет гортензий 5" => array(
							"Гортензия"=>5,
							"Трава для оформления 2"=>1
						),
						"Букет гортензий 7" => array(
							"Гортензия"=>7,
							"Трава для оформления 3"=>1
						),
						"Букет гортензий 9" => array(
							"Гортензия"=>9,
							"Трава для оформления 4"=>1
						),
						"Букет гортензий 21" => array(
							"Гортензия"=>21,
							"Трава для оформления 5"=>1
						),
						"Букет лилий 3" => array(
							"Лилия"=>3,
							"Трава для оформления 1"=>1
						),
						"Букет лилий 5" => array(
							"Лилия"=>5,
							"Трава для оформления 2"=>1
						),
						"Букет лилий 7" => array(
							"Лилия"=>7,
							"Трава для оформления 3"=>1
						),
						"Букет лилий 9" => array(
							"Лилия"=>9,
							"Трава для оформления 4"=>1
						),
						"Букет лилий 21" => array(
							"Лилия"=>21,
							"Трава для оформления 5"=>1
						),
						"Букет влюбленного" => array(
							"Фиолетовый цветок"=>3,
							"Трава для оформления 1"=>1
						),
						"Букет поклонника" => array(
							"Фиолетовый цветок"=>5,
							"Трава для оформления 2"=>1
						),
						"Букет любовника" => array(
							"Фиолетовый цветок"=>7,
							"Трава для оформления 3"=>1
						),
						"Букет супруга" => array(
							"Фиолетовый цветок"=>9,
							"Трава для оформления 4"=>1
						),
						"Букет романтика" => array(
							"Фиолетовый цветок"=>21,
							"Трава для оформления 5"=>1
						),
						"Букет влюбленной" => array(
							"Желтый цветок"=>3,
							"Трава для оформления 1"=>1
						),
						"Букет поклонницы" => array(
							"Желтый цветок"=>5,
							"Трава для оформления 2"=>1
						),
						"Букет любовницы" => array(
							"Желтый цветок"=>7,
							"Трава для оформления 3"=>1
						),
						"Букет супруги" => array(
							"Желтый цветок"=>9,
							"Трава для оформления 4"=>1
						),
						"Букет счастья" => array(
							"Желтый цветок"=>21,
							"Трава для оформления 5"=>1
						),
					);
	if($_POST['docompare']) {
		$resultbuk = array (
						"Букет тюльпанов 1"=>array(
								"name"=>"Букет тюльпанов 1",
								'maxdur'=>1,
								"img"=>"tulip1.gif",
								'minu'=>1,
								'maxu'=>2,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет тюльпанов 3"=>array(
								"name"=>"Букет тюльпанов 3",
								'maxdur'=>3,
								"img"=>"tulip3.gif",
								'minu'=>1,
								'maxu'=>3,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет тюльпанов 5"=>array(
								"name"=>"Букет тюльпанов 5",
								'maxdur'=>5,
								"img"=>"tulip5.gif",
								'minu'=>1,
								'maxu'=>5,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет тюльпанов 7"=>array(
								"name"=>"Букет тюльпанов 7",
								'maxdur'=>7,
								"img"=>"tulip7.gif",
								'minu'=>1,
								'maxu'=>7,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет тюльпанов 9"=>array(
								"name"=>"Букет тюльпанов 9",
								'maxdur'=>9,
								"img"=>"tulip9.gif",
								'minu'=>1,
								'maxu'=>9,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>1,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет тюльпанов 21"=>array(
								"name"=>"Букет тюльпанов 21",
								'maxdur'=>10,
								"img"=>"tulip21.gif",
								'minu'=>1,
								'maxu'=>21,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>5,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет нарциссов 1"=>array(
								"name"=>"Букет нарциссов 1",
								'maxdur'=>1,
								"img"=>"narcissus1.gif",
								'minu'=>1,
								'maxu'=>2,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет нарциссов 3"=>array(
								"name"=>"Букет нарциссов 3",
								'maxdur'=>3,
								"img"=>"narcissus3.gif",
								'minu'=>1,
								'maxu'=>3,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет нарциссов 5"=>array(
								"name"=>"Букет нарциссов 5",
								'maxdur'=>5,
								"img"=>"narcissus5.gif",
								'minu'=>1,
								'maxu'=>5,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет нарциссов 7"=>array(
								"name"=>"Букет нарциссов 7",
								'maxdur'=>7,
								"img"=>"narcissus7.gif",
								'minu'=>1,
								'maxu'=>7,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет нарциссов 9"=>array(
								"name"=>"Букет нарциссов 9",
								'maxdur'=>9,
								"img"=>"narcissus9.gif",
								'minu'=>1,
								'maxu'=>9,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>1,
								'goden'=>10),
						"Букет нарциссов 21"=>array(
								"name"=>"Букет нарциссов 21",
								'maxdur'=>10,
								"img"=>"narcissus21.gif",
								'minu'=>1,
								'maxu'=>21,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>5,
								'goden'=>10),
						"Букет сирени 3"=>array(
								"name"=>"Букет сирени 3",
								'maxdur'=>3,
								"img"=>"siren_3.gif",
								'minu'=>3,
								'maxu'=>5,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет сирени 5"=>array(
								"name"=>"Букет сирени 5",
								'maxdur'=>5,
								"img"=>"siren_5.gif",
								'minu'=>3,
								'maxu'=>7,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет сирени 7"=>array(
								"name"=>"Букет сирени 7",
								'maxdur'=>7,
								"img"=>"siren_7.gif",
								'minu'=>3,
								'maxu'=>9,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>15,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет сирени 9"=>array(
								"name"=>"Букет сирени 9",
								'maxdur'=>9,
								"img"=>"siren_9.gif",
								'minu'=>3,
								'maxu'=>15,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>15,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет сирени 21"=>array(
								"name"=>"Букет сирени 21",
								'maxdur'=>10,
								"img"=>"siren_21.gif",
								'minu'=>3,
								'maxu'=>25,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>15,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет рихардий 3"=>array(
								"name"=>"Букет рихардий 3",
								'maxdur'=>3,
								"img"=>"cally_3.gif",
								'minu'=>3,
								'maxu'=>5,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет рихардий 5"=>array(
								"name"=>"Букет рихардий 5",
								'maxdur'=>5,
								"img"=>"cally_5.gif",
								'minu'=>3,
								'maxu'=>7,
								'mfkrit'=>0,
								'mfakrit'=>1,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет рихардий 7"=>array(
								"name"=>"Букет рихардий 7",
								'maxdur'=>7,
								"img"=>"cally_7.gif",
								'minu'=>3,
								'maxu'=>10,
								'mfkrit'=>0,
								'mfakrit'=>10,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет рихардий 9"=>array(
								"name"=>"Букет рихардий 9",
								'maxdur'=>9,
								"img"=>"cally_9.gif",
								'minu'=>3,
								'maxu'=>15,
								'mfkrit'=>0,
								'mfakrit'=>15,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет рихардий 21"=>array(
								"name"=>"Букет рихардий 21",
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
						"Букет хризантем 3"=>array(
								"name"=>"Букет хризантем 3",
								'maxdur'=>3,
								"img"=>"chrysanthemum3.gif",
								'minu'=>2,
								'maxu'=>6,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет хризантем 5"=>array(
								"name"=>"Букет хризантем 5",
								'maxdur'=>5,
								"img"=>"chrysanthemum5.gif",
								'minu'=>2,
								'maxu'=>8,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет хризантем 7"=>array(
								"name"=>"Букет хризантем 7",
								'maxdur'=>7,
								"img"=>"chrysanthemum7.gif",
								'minu'=>2,
								'maxu'=>10,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет хризантем 9"=>array(
								"name"=>"Букет хризантем 9",
								'maxdur'=>9,
								"img"=>"chrysanthemum9.gif",
								'minu'=>2,
								'maxu'=>12,
								'mfkrit'=>5,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет хризантем 21"=>array(
								"name"=>"Букет хризантем 21",
								'maxdur'=>10,
								"img"=>"chrysanthemum21.gif",
								'minu'=>2,
								'maxu'=>24,
								'mfkrit'=>10,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет роз 3"=>array(
								"name"=>"Букет роз 3",
								'maxdur'=>3,
								"img"=>"yrose3.gif",
								'minu'=>3,
								'maxu'=>7,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет роз 5"=>array(
								"name"=>"Букет роз 5",
								'maxdur'=>5,
								"img"=>"yrose5.gif",
								'minu'=>3,
								'maxu'=>9,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет роз 7"=>array(
								"name"=>"Букет роз 7",
								'maxdur'=>7,
								"img"=>"yrose7.gif",
								'minu'=>3,
								'maxu'=>11,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет роз 9"=>array(
								"name"=>"Букет роз 9",
								'maxdur'=>9,
								"img"=>"yrose9.gif",
								'minu'=>3,
								'maxu'=>13,
								'mfkrit'=>0,
								'mfakrit'=>5,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет роз 21"=>array(
								"name"=>"Букет роз 21",
								'maxdur'=>10,
								"img"=>"yrose21.gif",
								'minu'=>3,
								'maxu'=>25,
								'mfkrit'=>0,
								'mfakrit'=>10,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет гортензий 3"=>array(
								"name"=>"Букет гортензий 3",
								'maxdur'=>3,
								"img"=>"hydrangea3.gif",
								'minu'=>3,
								'maxu'=>7,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет гортензий 5"=>array(
								"name"=>"Букет гортензий 5",
								'maxdur'=>5,
								"img"=>"hydrangea5.gif",
								'minu'=>3,
								'maxu'=>9,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет гортензий 7"=>array(
								"name"=>"Букет гортензий 7",
								'maxdur'=>7,
								"img"=>"hydrangea7.gif",
								'minu'=>3,
								'maxu'=>11,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет гортензий 9"=>array(
								"name"=>"Букет гортензий 9",
								'maxdur'=>9,
								"img"=>"hydrangea9.gif",
								'minu'=>3,
								'maxu'=>13,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>10,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет гортензий 21"=>array(
								"name"=>"Букет гортензий 21",
								'maxdur'=>10,
								"img"=>"hydrangea21.gif",
								'minu'=>3,
								'maxu'=>25,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>10,
								'mfauvorot'=>10,
								'goden'=>10),
						"Букет лилий 3"=>array(
								"name"=>"Букет лилий 3",
								'maxdur'=>3,
								"img"=>"lillies3.gif",
								'minu'=>3,
								'maxu'=>7,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет лилий 5"=>array(
								"name"=>"Букет лилий 5",
								'maxdur'=>5,
								"img"=>"lillies5.gif",
								'minu'=>3,
								'maxu'=>9,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет лилий 7"=>array(
								"name"=>"Букет лилий 7",
								'maxdur'=>7,
								"img"=>"lillies7.gif",
								'minu'=>3,
								'maxu'=>11,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет лилий 9"=>array(
								"name"=>"Букет лилий 9",
								'maxdur'=>9,
								"img"=>"lillies9.gif",
								'minu'=>3,
								'maxu'=>13,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>10,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет лилий 21"=>array(
								"name"=>"Букет лилий 21",
								'maxdur'=>10,
								"img"=>"lillies21.gif",
								'minu'=>3,
								'maxu'=>25,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>10,
								'mfauvorot'=>10,
								'goden'=>10),
						"Букет влюбленного"=>array(
								"name"=>"Букет влюбленного",
								'maxdur'=>3,
								"img"=>"love3.gif",
								'minu'=>1,
								'maxu'=>3,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет поклонника"=>array(
								"name"=>"Букет поклонника",
								'maxdur'=>5,
								"img"=>"love5.gif",
								'minu'=>1,
								'maxu'=>5,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет любовника"=>array(
								"name"=>"Букет любовника",
								'maxdur'=>7,
								"img"=>"love7.gif",
								'minu'=>1,
								'maxu'=>7,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет супруга"=>array(
								"name"=>"Букет супруга",
								'maxdur'=>9,
								"img"=>"love9.gif",
								'minu'=>1,
								'maxu'=>9,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>1,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет романтика"=>array(
								"name"=>"Букет романтика",
								'maxdur'=>10,
								"img"=>"love21.gif",
								'minu'=>1,
								'maxu'=>21,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>5,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет влюбленной"=>array(
								"name"=>"Букет влюбленной",
								'maxdur'=>3,
								"img"=>"flove3.gif",
								'minu'=>1,
								'maxu'=>3,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет поклонницы"=>array(
								"name"=>"Букет поклонницы",
								'maxdur'=>5,
								"img"=>"flove5.gif",
								'minu'=>1,
								'maxu'=>5,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет любовницы"=>array(
								"name"=>"Букет любовницы",
								'maxdur'=>7,
								"img"=>"flove7.gif",
								'minu'=>1,
								'maxu'=>7,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>0,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет супруги"=>array(
								"name"=>"Букет супруги",
								'maxdur'=>9,
								"img"=>"flove9.gif",
								'minu'=>1,
								'maxu'=>9,
								'mfkrit'=>0,
								'mfakrit'=>0,
								'mfuvorot'=>1,
								'mfauvorot'=>0,
								'goden'=>10),
						"Букет счастья"=>array(
								"name"=>"Букет счастья",
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
					echo '<B><font color=red>Удачно составлен букет <img src="i/sh/',$dress['img'],'"><BR>(находится у вас в рюкзаке)</font>';
					foreach ($_SESSION['flowers'] as $k=>$v) {
						$dressid .= "cap".$k.",";
						mysql_query("DELETE FROM `inventory` WHERE `id` = '".$k."'  LIMIT 1;");
					}
					mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" получила предмет: \"".$dress['name']."\" ".$dresscount."id:(cap".$buket_id.") [0/".$dress['maxdur']."] за id:(".$dressid.") ',1,'".time()."');");
				}
				else {
					echo '<B><font color=red>Произошла ошибка!</font>';
				}
			}
		}
		if (!$good) {
                  echo "<b><font color=\"red\">Не удалось составить букет.</font>";
			/*foreach ($_SESSION['flowers'] as $k=>$v) {
				$fname=mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '".$k."' LIMIT 1;"));
				mysql_query("DELETE FROM `inventory` WHERE `id` = '".$k."'  LIMIT 1;");
				mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','Утерян предмет \"".$fname['name']."\" id:(cap".$k.") [".$fname['duration']."/".$fname['maxdur']."] у \"".$user['login']."\"  ',1,'".time()."');");
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
<!--Магазин-->
<TABLE border=0 width=100% cellspacing="0" cellpadding="0" <?if (!$_REQUEST['present']) { echo 'bgcolor="#A5A5A5"';}?>>
<TR>
	<TD align=center><B><?php
	if ($_REQUEST['compare'] && !$_REQUEST['common'] && !$_REQUEST['present']) {
		echo "Составление подарочного букета";
	}
	elseif ($_REQUEST['present']) {
		//echo "Составление подарочного букета";
	}
	else
	{
		echo "Цветы. Общий зал.";
	}


	?></B></TD>
</TR>
<TR><TD><!--Рюкзак-->
<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">
<?
if ($_REQUEST['compare'] && !$_REQUEST['common'] && !$_REQUEST['present']) {
	?>
	</table>
	<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#D5D5D5">
	<tr>
		<input type="hidden" value="1" name="compare">
		<td width=150px  valign=top><b>Цветы для букета:</b><BR>
		<div  align="right"><input type="submit" onclick="if(!confirm('Внимание! Подходите разумно к составлению букета.\nНапример, не рекомендуется использовать четное количество цветов.\nСоставить букет?')) { return false; }" value="Собрать букет" name="docompare"></div>
		</td>
		<td  valign=top>
		<?
		unset($errs);
		foreach ($_SESSION['flowers'] as $v) {
			if($v[2] == "Тюльпан" OR $v[2] == "Нарцисс" OR $v[2] == "Хризантема"  OR $v[2] == "Сирень"   OR $v[2] == "Рихардия"  OR $v[2] == "Желтая роза" OR $v[2] == "Гортензия") {
					$errs[$v[2]] ++;
			}
		}
		if(count($errs) > 1) {
			echo '<font color=red>Букет можно собрать только из цветов одного типа!</font>';
		}

			if(!$_SESSION['flowers']) { echo 'Добавляйте сюда цветы, из которых хотите составить букет'; } else {
				foreach ($_SESSION['flowers'] as $k=>$v) {
					echo '<form method="post" style="margin:0px; padding:0px;"><div style="float: left;" align="center"><img src="i/sh/',$v[0],'" align="center"><BR><input type="hidden" name="flower" value="',$k,'"><input type="hidden" value="1" name="compare"><input type="submit" value="Убрать" name="delflower"></div></form>';
				}
			}
			?>
		</td>
	</tr>
	</table>
	<TABLE border=0 width=100% cellspacing="0" cellpadding="0" bgcolor="#A5A5A5">
	<TR>
		<TD align=center><B>Цветы у вас в рюкзаке</B></TD>
	</tr>
	</table>
	<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">
	<?
	$data = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND (
		`name` LIKE 'Блеклый подземник%' OR
		`name` LIKE 'Черепичный подземник%' OR
		`name` LIKE 'Кровавый подземник%' OR
		`name` LIKE 'Зеркальный подземник%'
	) AND `setsale`=0 ORDER by `update` DESC; ");
	while($row = mysql_fetch_array($data)) {
		if(!in_array($row['id'],array_keys($_SESSION['flowers']))) {
			$row['count'] = 1;
			if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
			echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"i/sh/{$row['img']}\" BORDER=0>";
			?>
			<BR><A HREF="vshop.php?add=<?=$row['id']?>&sid=&compare=1">добавить в букет</A>
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
                  echo "<b><font color=red>Персонаж на найден</font></b>";
		} elseif ($owner!=$user["id"]) {
                  echo "<b><font color=red>Предмет на найден</font></b>";
                } elseif ($_POST['to_login'] == $user['login']) {
		  echo "<b><font color=red>Очень щедро дарить что-то самому себе ;)</font></b>";
		} elseif ($to['room'] > 500 && $to['room'] < 561) {
		  echo "<b><font color=red>Персонаж в данный момент участвует в турнире в Башне Смерти. Попробуйте позже.</font></b>";
		} else {
			if((int)$_POST['from']==1) { $from = 'Аноним'; }
			elseif((int)$_POST['from']==2 && $user['klan']) { $from = ' клан '.$user['klan']; }
			else {$from = $user['login'];}
			if ($to) if(mysql_query("UPDATE `inventory` SET `owner` = '".$to['id']."', `present` = '".$from."', `letter` = '".$_POST['podarok2']."' WHERE  `present` = '' AND `id` = '".$_POST['flower']."' AND `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `name` LIKE 'Букет%' AND `setsale`=0")) {
				$buket = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$_POST['flower']}' AND `name` LIKE 'Букет%' LIMIT 1; "));
				$buket_name=$buket['name'];
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','Подарен букет цветов \"".$buket['name']."\" id:(cap".$_POST['flower'].") [".$buket['duration']."/".$buket['maxdur']."] от \"".$from."\" к \"".$to['login']."\"','1','".time()."');");
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$to['id']}','Подарен букет цветов \"".$buket['name']."\" id:(cap".$buket['id'].") [".$buket['duration']."/".$buket['maxdur']."] от \"".$from."\" к \"".$to['login']."\"','1','".time()."');");
				if(($_POST['from']==1) || ($_POST['from']==2)) {
					$action="подарил";
					mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$to['id']}','Подарен букет цветов \"".$buket['name']."\" id:(cap".$buket['id'].") [".$buket['duration']."/".$buket['maxdur']."] от \"".$user['login']."\" к \"".$to['login']."\"','5','".time()."');");
				}
				else {
					if ($user['sex'] == 0) {$action="подарила";}
					else {$action="подарил";}
				}
				$us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$to['id']}' LIMIT 1;"));
				if($us[0]){
					addchp ('<font color=red>Внимание!</font> <span oncontextmenu=OpenMenu()>'.$from.'</span> '.$action.' вам <B>'.$buket_name.'</B>.   ','{[]}'.$_POST['to_login'].'{[]}');
				} else {
					// если в офе
					mysql_query("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$to['id']."','','".'<font color=red>Внимание!</font> <span oncontextmenu=OpenMenu()>'.$from.'</span> '.$action.' вам <B>'.$buket_name.'</B>.   '."');");
				}
				echo "<b><font color=red>Букет удачно доставлен к \"",$_POST['to_login'],"\"</font></b>";
			}
			echo mysql_error();
		}
	}

		?>

<!-- Подарить подарок -->
<form method="post">
<TABLE cellspacing=0 cellpadding=0 width=100% bgcolor=#e0e0e2><TD>
<INPUT TYPE=hidden name=present value=1>
Вы можете подарить ваш букет дорогому человеку. Ваш подарок будет отображаться в информации о персонаже.
<OL>
<LI>Укажите логин персонажа, которому хотите подарить букет<BR>
Login <INPUT TYPE=text NAME=to_login value="">
<LI>Цель подарка. Будет отображаться в информации о персонаже (не более 60 символов)<BR>
<INPUT TYPE=text NAME=podarok2 value="" maxlength=60 size=50>
<LI>Напишите текст сопроводительной записки (в информации о персонаже не отображается)<BR>
<TEXTAREA NAME=txt ROWS=6 COLS=80></TEXTAREA>
<LI>Выберите, от чьего имени подарок:<BR>
<INPUT TYPE=radio NAME=from value=0 checked> <? nick2($user['id']);?><BR>
<INPUT TYPE=radio NAME=from value=1 > анонимно<BR>
<INPUT TYPE=radio NAME=from value=2 > от имени клана<BR>
<LI>Нажмите кнопку <B>Подарить</B> под букетом, который хотите преподнести в подарок:<BR>
</OL>
<input type="hidden" name="flower" id="flower" value="">
<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">
<?

//print_r($_POST);

	$data = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `name` LIKE 'Букет%' AND `setsale`=0 AND `present` = '' ORDER by `update` DESC; ");
	while($row = mysql_fetch_array($data)) {
		if(!in_array($row['id'],array_keys($_SESSION['flowers']))) {
			$row['count'] = 1;
			if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
			echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"i/sh/{$row['img']}\" BORDER=0>";
			?>
			<BR><input type="submit" onclick="document.all['flower'].value='<?=$row['id']?>';" value="Подарить">
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
		<BR><A HREF="vshop.php?otdel=<?=$_GET['otdel']?>&set=<?=$row['id']?>&sid=">купить</A>
		<IMG SRC="i/up.gif" WIDTH=11 HEIGHT=11 BORDER=0 ALT="Купить несколько штук" style="cursor:hand" onclick="AddCount('<?=$row['id']?>', '<?=$row['name']?>')"></TD>
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

	<CENTER><B>Масса всех ваших вещей: <?php


	echo $d[0];
	?>/<?=get_meshok()?><BR>
	У вас в наличии: <FONT COLOR="#339900"><?=$user['money']?></FONT> кр.</B></CENTER>
	<div style="MARGIN-LEFT:15px; MARGIN-TOP: 10px;">
	<form method="post">
	<INPUT TYPE="submit" value="Общий зал" name="common"><BR>
	<INPUT TYPE="submit" value="Составление букета" name="compare"><BR>
	<INPUT TYPE="submit" value="Подарить букет" name="present"><BR>
	</div></form>
	<h3>Доступные букеты:</h3>
<?
  foreach ($bukets as $k=>$v) {
    echo "<b>$k</b>:<br>";
    foreach ($v as $k2=>$v2) {
      echo "$k2 <b>$v2</b> шт.<br>";
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

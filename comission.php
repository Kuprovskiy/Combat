<?php
	session_start();
	if ($_SESSION['uid'] == null) header("Location: index.php");
	include "connect.php";
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '".mysql_real_escape_string($_SESSION['uid'])."' LIMIT 1;"));
	if (!$user['login']) header("Location: index.php");
	if ($user['level']<1) { header("Location: main.php");  die(); }
	if ($user['room'] != 25) { header("Location: main.php");  die(); }
	include "functions.php";
	$d = mysql_fetch_array(mysql_query("SELECT sum(`massa`) FROM `inventory` WHERE `owner` = '".mysql_real_escape_string($_SESSION['uid'])."' AND `dressed` = 0 AND `setsale` = 0 ; "));
	if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }

	if ($_GET['sale'] && $_GET['kredit'] && $_GET['n']) {
		$_GET['kredit'] = round($_GET['kredit'],2);
		if ((is_numeric($_GET['kredit']) && $_GET['kredit']>0) && (is_numeric($_GET['n']) &&  $_GET['n']>0)) {
			$dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE  `dressed`=0 AND `podzem` = 0 AND `id` = '".mysql_real_escape_string($_GET['n'])."' AND `owner` = '".mysql_real_escape_string($_SESSION['uid'])."' LIMIT 1;"));
			if($dress['id']) {
				mysql_query("UPDATE `inventory` SET `setsale` = '".mysql_real_escape_string($_GET['kredit'])."' WHERE `id` = '".mysql_real_escape_string($_GET['n'])."' AND `owner` = '".mysql_real_escape_string($_SESSION['uid'])."' LIMIT 1;");
				mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($_SESSION['uid'])."','\"".$user['login']."\" сдал предмет: \"".$dress['name']."\" id:(cap".$dress['id'].") [".$dress['duration']."/".$dress['maxdur']."] в комиссионку за ".mysql_real_escape_string($_GET['kredit'])." кр. ',1,'".time()."');");
				echo "<font color=red><b>Вы сдали в магазин \"{$dress['name']}\" за {$_GET['kredit']} кр.</b></font>";
			}
		}
		else {
			echo "<font color=red><b>Не надо так делать</b></font>";
		}
	}

	if ($_GET['back']) {
		if ($user['money'] >= 1) {
			if (is_numeric($_GET['back']) && $_GET['back']>0) {
				$dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `dressed`=0 AND  `id` = '".mysql_real_escape_string($_GET['back'])."' AND `owner` = '".mysql_real_escape_string($_SESSION['uid'])."' AND `setsale` > '0' LIMIT 1;"));
				if($dress['id']) {
					mysql_query("UPDATE `users` set `money` = `money`-'1' WHERE id = '".mysql_real_escape_string($_SESSION['uid'])."'");
					mysql_query("UPDATE `inventory` SET `setsale` = '0' WHERE `id` = '".mysql_real_escape_string($_GET['back'])."' AND `owner` = '".mysql_real_escape_string($_SESSION['uid'])."' LIMIT 1;");
					mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($_SESSION['uid'])."','\"".$user['login']."\" забрал предмет: \"".$dress['name']."\" id:(cap".$dress['id'].") [".$dress['duration']."/".$dress['maxdur']."] из комиссионки ',1,'".time()."');");
					mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($_SESSION['uid'])."','\"".$user['login']."\" заплатил 1 кр за хранение предмета: \"".$dress['name']."\" id:(cap".$dress['id'].") [".$dress['duration']."/".$dress['maxdur']."] в комиссионке ',1,'".time()."');");
					$user['money']=$user['money']-1;

					echo "<font color=red><b>Вы забрали из магазина \"".$dress['name']."\" за 1 кр.</b></font>";
				}
				else {
					echo "<font color=red><b>Произошла ошибка. Вещь не найдена в магазине!</b></font>";
				}
			}
			else {
				echo "<font color=red><b>Не надо так делать</b></font>";
			}
		}
		else {
			echo "<font color=red><b>У вас недостаточно денег на уплату комиссии.</b></font>";
		}
	}


	if (($_GET['set'] OR $_POST['set'])) {
		if ($_GET['set']) { $set = $_GET['set']; }
		if ($_POST['set']) { $set = $_POST['set']; }
		if (!$_POST['count'] || !is_numeric($_POST['count']) || $_POST['count']<=0) { $_POST['count'] =1; }
		if (is_numeric($set) && $set>0) {
			$dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `dressed`=0 AND   `id` = '".mysql_real_escape_string($set)."' AND `setsale` > '0' LIMIT 1;"));
			$userfrom = mysql_fetch_array(mysql_query("SELECT `login`,`id` FROM `users` WHERE  `id` = '".$dress['owner']."' LIMIT 1;"));
			if ($userfrom['id'] && $dress['id']) {
				if (($dress['massa']+$d[0]) > (get_meshok())) {
					echo "<font color=red><b>Недостаточно места в рюкзаке.</b></font>";
				}
				elseif ($user['money'] >= $dress['setsale']) {
					if(mysql_query("UPDATE `inventory` SET `owner` = '".mysql_real_escape_string($user['id'])."', `setsale` = 0 WHERE `id` = '".mysql_real_escape_string($set)."' AND `setsale` > '0' LIMIT 1;"))
					{
						$good = 1;
					}
					else {
						$good = 0;
					}

					if ($good) {
						//mysql_query("UPDATE `shop` SET `count`=`count`-{$_POST['count']} WHERE `id` = '{$set}' LIMIT 1;");
						echo "<font color=red><b>Вы купили \"".$dress['name']."\".</b></font>";
						$moneyto=round($dress['setsale']*0.90,2);
						$komiss=round($dress['setsale']*0.10,2);
						mysql_query("UPDATE `users` set `money` = `money`- '".$dress['setsale']."' WHERE id = '".mysql_real_escape_string($_SESSION['uid'])."'");
						mysql_query("UPDATE `users` set `money` = `money`+ '".$moneyto."' WHERE id = '".mysql_real_escape_string($userfrom['id'])."'");
						mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($_SESSION['uid'])."','\"".$user['login']."\" купил товар: \"".$dress['name']."\" id:(cap".$dress['id'].") [".$dress['duration']."/".$dress['maxdur']."] от \"".$userfrom['login']."\" за ".$dress['setsale']." кр. в комиссионке ',5,'".time()."');");
						mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($userfrom['id'])."','\"".$user['login']."\" купил товар: \"".$dress['name']."\" id:(cap".$dress['id'].") [".$dress['duration']."/".$dress['maxdur']."] от \"".$userfrom['login']."\" за ".$dress['setsale']." кр. в комиссионке ',5,'".time()."');");
						mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($_SESSION['uid'])."','\"".$user['login']."\" купил товар: \"".$dress['name']."\" id:(cap".$dress['id'].") [".$dress['duration']."/".$dress['maxdur']."] за ".$dress['setsale']." кр. в комиссионке ',1,'".time()."');");
						mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($userfrom['id'])."','\"".$userfrom['login']."\" получил ".$moneyto." кр. за продажу товара: \"".$dress['name']."\" id:(cap".$dress['id'].") [".$dress['duration']."/".$dress['maxdur']."] через комиссионку ',1,'".time()."');");
						$user['money']=$user['money']-$dress['setsale'];
						$us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '".mysql_real_escape_string($userfrom['id'])."' LIMIT 1;"));
						if($us[0]){
							addchp ('<font color=red>Внимание!</font> Успешно продан предмет "'.$dress['name'].'" за '.$dress['setsale'].' кр.  Комиссия составила '.$komiss.' кр. Вам перечислено от комиссионного магазина '.$moneyto.' кр. ','{[]}'.$userfrom['login'].'{[]}');
						} else {
							// если в офе
							mysql_query("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$userfrom['id']."','','".'<font color=red>Внимание!</font> Успешно продан предмет "'.$dress['name'].'" за '.$dress['setsale'].' кр.  Комиссия составила '.$komiss.' кр. Вам перечислено от комиссионного магазина '.$moneyto.' кр. '."');");
						}
					}
				}
				else {
					echo "<font color=red><b>Недостаточно денег или нет вещей в наличии.</b></font>";
				}
			}
			else {
				echo "<font color=red><b>Вещь не найдена в магазине</b></font>";
			}
		}
		else {
				echo "<font color=red><b>Не надо так делать</b></font>";
		}
	}

	if ($_GET['unsale'] && $_GET['kredit'] && $_GET['id']) {
		if ((is_numeric($_GET['kredit']) && $_GET['kredit']>0) && (is_numeric($_GET['id']) &&  $_GET['id']>0)) {
			$dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `dressed`=0 AND `podzem`=0 AND `id` = '".mysql_real_escape_string($_GET['id'])."' AND `owner` = '".mysql_real_escape_string($_SESSION['uid'])."' AND `setsale` > 0 LIMIT 1;"));
			if($dress['id']) {
				if($user['money'] >= 0.1) {
					mysql_query("UPDATE `inventory` SET `setsale` = '".mysql_real_escape_string($_GET['kredit'])."' WHERE `id` = '".mysql_real_escape_string($_GET['id'])."' AND `owner` = '".mysql_real_escape_string($_SESSION['uid'])."' LIMIT 1;");

					mysql_query("UPDATE `users` set `money` = `money`- '0.1' WHERE id = '".mysql_real_escape_string($_SESSION['uid'])."'");
					mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".mysql_real_escape_string($_SESSION['uid'])."','\"".$user['login']."\" заплатил 0.1 кр за смену цены на предмет \"".$dress['name']."\" id:(cap".$dress['id'].") [".$dress['duration']."/".$dress['maxdur']."] в комиссионке ',1,'".time()."');");
					$user['money']=$user['money']-0.1;
					echo "<font color=red><b>Вы изменили цену \"{$dress['name']}\" на {$_GET['kredit']} кр.</b></font>";
				}
				else {
					echo "<font color=red><b>У вас недостаточно денег на выполнение операции.</b></font>";
				}
			}
			else {
				echo "<font color=red><b>Предмет не найден.</b></font>";
			}
		}
		else {
				echo "<font color=red><b>Не надо так делать</b></font>";
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
<!--
function sale(name, txt, n, kr)
{
	var s = prompt("Сдать в магазин \""+txt+"\". Укажите цену:", kr);
	if ((s != null)&&(s != '')) {
		location.href="comission.php?sale="+name+"&kredit="+s+"&n="+n;
	}
}
function chsale(name, txt, id, category, kr)
{
	var s = prompt("Сменить цену для предмета \""+txt+"\". Укажите новую цену:", kr);
	if ((s != null)&&(s != '')) {
		location.href="comission.php?unsale="+name+"&id="+id+"&sc="+category+"&kredit="+s;
	}
}
//-->
</SCRIPT>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=#e0e0e0>

<TABLE width=100% cellspacing="0" cellpadding="4">
<TR>
	<TD valign=top align=left>

<!--Комиссионный Магазин-->

<TABLE width=100% cellspacing="0" cellpadding="0" bgcolor="#A5A5A5">
<TR>
	<TD align=center><B>Отдел "<?php
	if ($_REQUEST['sale']) {
		echo "Сдать вещи";
	} elseif ($_REQUEST['unsale']) {
		echo "Забрать вещи";
	} else
switch ($_GET['otdel']) {
	case null:
		if (!$_REQUEST['max']) {
		echo "Оружие: кастеты,ножи"; }
		else echo $_REQUEST['max'];
		$_GET['otdel'] = 1;
	break;
	case 1:
		echo "Оружие: кастеты,ножи";
	break;
	case 11:
		echo "Оружие: топоры";
	break;
	case 12:
		echo "Оружие: дубины,булавы";
	break;
	case 13:
		echo "Оружие: мечи";
	break;
	case 30:
		echo "Оружие: магические посохи";
	break;
	case 2:
		echo "Одежда: сапоги";
	break;
	case 21:
		echo "Одежда: перчатки";
	break;
	case 8:
		echo "Одежда: рубахи";	
	break;
	case 22:
		echo "Одежда: легкая броня";
	break;
	case 23:
		echo "Одежда: тяжелая броня";
	break;
	case 24:
		echo "Одежда: шлемы";
	break;
	case 25:
		echo "Наручи";
	break;
	case 26:
		echo "Пояса";
	break;
	case 27:
		echo "Поножи";
	break;
	case 28:
		echo "плащи";
	break;
	case 3:
		echo "Щиты";
	break;
	case 4:
		echo "Ювелирные товары: серьги";
	break;
	case 41:
		echo "Ювелирные товары: ожерелья";
	break;
	case 42:
		echo "Ювелирные товары: кольца";
	break;
	case 5:
		echo "Заклинания: нейтральные";
	break;
	case 51:
		echo "Заклинания: боевые и защитные";
	break;
	case 52:
		echo "Заклинания: сервисные";
	break;
	case 6:
		echo "Амуниция";
	break;
	case 188:
		echo "Эликсиры";
	break;
	
}


	?>"</B>

	</TD>
</TR>
<TR><TD><!--Рюкзак-->
<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">
<?
if ($_REQUEST['max']) {
	$data = mysql_query("SELECT * FROM `inventory` WHERE  `dressed`=0 AND `name` LIKE '".addcslashes(mysql_real_escape_string($_REQUEST['max']), '%_')."%' AND `setsale` > 0 ORDER by `setsale` ASC");
	while($row = mysql_fetch_array($data)) {
		$row['count'] = 1;
		$row['cost'] = $row['setsale'];
		if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
		echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"i/sh/{$row['img']}\" BORDER=0>";
		?>
		<BR><A HREF="comission.php?otdel=<?=$_GET['otdel']?>&set=<?=$row['id']?>&sid=">купить</A></TD>
		<?php
		echo "<TD valign=top>";
		showitem ($row);
		echo "</TD></TR>";
	}
}
elseif ($_REQUEST['sale']) {
	echo "<TR bgcolor=#C7C7C7><TD align=center colspan=2>Комиссия за услуги магазина составляет 10% от цены, по которой вы предлагаете предмет.</TD></TR>";
	$data = mysql_query("SELECT * FROM `inventory` WHERE `setsale` = 0 AND `owner` = '".mysql_real_escape_string($_SESSION['uid'])."' AND `podzem` = 0 AND `dressed` = 0 AND `present` = '' ORDER by `update` DESC; ");
	while($row = mysql_fetch_array($data)) {
		$row['count'] = 1;
		if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
		echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"i/sh/{$row['img']}\" BORDER=0>";
		?>
		<BR><A onclick="sale('1', '<?=$row['name']?>', '<?=$row['id']?>', '<?=$row['cost']?>');" HREF="#">cдать в магазин</A>
		</TD>
		<?php
		echo "<TD valign=top>";
		showitem ($row);
		echo "</TD></TR>";
	}
} elseif ($_REQUEST['unsale']) {
	$data = mysql_query("SELECT * FROM `inventory` WHERE `setsale` > 0 AND `owner` = '".mysql_real_escape_string($_SESSION['uid'])."' AND `dressed` = 0 ORDER by `update` DESC; ");
	while($row = mysql_fetch_array($data)) {
		$row['count'] = 1;
		if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
		echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"i/sh/{$row['img']}\" BORDER=0>";
		?>
		<BR><A HREF="?back=<?=$row['id']?>&sid=&unsale=1">забрать за 1 кр.</A>
		<BR><A onclick="chsale('1', '<?=$row['name']?>', <?=$row['id']?>, '1', '<?=$row['setsale']?>')" HREF="#">сменить цену<BR>за 0.1 кр.</A>
		</TD>
		<?php
		echo "<TD valign=top>";
		showitem ($row);
		echo "</TD></TR>";
	}
} else
{
	$data = mysql_query("SELECT DISTINCT `img`, `name`, `nalign`,`massa` FROM `inventory` WHERE  `dressed`=0 AND `setsale` > 0 AND `present` = '' AND `otdel` = '".mysql_real_escape_string($_GET['otdel'])."' GROUP BY `img` ORDER by `cost` ASC");
	while($row = mysql_fetch_array($data)) {
		$item_name1=str_replace("+1","",$row[1]);
		$item_name1=str_replace("+2","",$item_name1);
		$item_name1=str_replace("+3","",$item_name1);
		$item_name1=str_replace("+4","",$item_name1);
		$item_name1=str_replace("+5","",$item_name1);
		$item_name=str_replace(" (мф)","",$item_name1);
		$item = mysql_fetch_array(mysql_query("SELECT count(`id`), min(duration), min(maxdur), max(duration), max(maxdur), min(setsale), max(setsale) FROM `inventory` WHERE  `dressed`=0 AND `setsale` > 0 AND `present` = '' AND name LIKE '".addcslashes(mysql_real_escape_string($item_name), '%_')."%';"));
		//$row['count']=1;
		if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
		?>
		<TR bgcolor=<?=$color?>>
		<TD align=center><IMG SRC="i/sh/<?=$row['img']?>" ALT="" ><BR><A HREF="comission.php?&max=<?=$item_name?>">подробнее</A></TD>
		<TD valign=top><A HREF="#"><?=$item_name?></a>
		<IMG SRC="i/align_<?=$row[2]?>.gif" WIDTH="12" HEIGHT="15" ALT="">  (Масса: <?=$row['massa']?>) <BR>
		<b>Цена: <?=round($item[5],2)?> - <?=round($item[6],2)?> кр.</b> <small>(количество: <?=$item[0]?>)</small><BR>

		Долговечность: <?=$item[1]?>-<?=$item[2]?>/<?=$item[3]?>-<?=$item[4]?></FONT><BR>

		</TD>
		</TR>
		<?
	}
}




?>
</TABLE>
</TD></TR>
</TABLE>

	</TD>
	<TD valign=top width=280>
	<TABLE border=0 width=100% cellspacing="0" cellpadding="0">
	<td align=right>
	<FORM action="comission.php" method=GET>
		<INPUT TYPE="button" value="Подсказка" style="background-color:#A9AFC0" onclick="window.open('help/shop.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">
		<INPUT TYPE="button" onclick="location.href='city.php?cp=3';" value="Вернуться" name="cp">

	</table>
	<CENTER><B>Масса всех ваших вещей: <?php


	echo $d[0];
	?>/<?=get_meshok()?><BR>
	У вас в наличии: <FONT COLOR="#339900"><?=$user['money']?></FONT> кр.</B></CENTER>
	<div style="MARGIN-LEFT:15px; MARGIN-TOP: 10px;">

	<INPUT TYPE="submit" value="Сдать вещи в магазин" name="sale"><BR>
	<INPUT TYPE="submit" value="Забрать вещи из магазина" name="unsale"><BR>
<div style="background-color:#d2d0d0;padding:1"><center><font color="#oooo"><B>Отделы магазина</B></center></div>
<A HREF="?otdel=1&sid=&0.162486541405194">Оружие: кастеты,ножи</A><BR>
<A HREF="?otdel=11&sid=&0.337606814894404">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;топоры</A><BR>
<A HREF="?otdel=12&sid=&0.286790872806733">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;дубины,булавы</A><BR>
<A HREF="?otdel=13&sid=&0.0943516060419363">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;мечи</A><BR>
<A HREF="?otdel=30&sid=&0.0436116461412363">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;магические посохи</A><BR>
<A HREF="?otdel=2&sid=&0.76205958316951">Одежда: сапоги</A><BR>
<A HREF="?otdel=21&sid=&0.648260824682342">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;перчатки</A><BR>
<A HREF="?otdel=8&sid=&0.168365917549310">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;рубахи</A><BR>
<A HREF="?otdel=22&sid=&0.520447517792988">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;легкая броня</A><BR>
<A HREF="?otdel=23&sid=&0.99133839275569">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;тяжелая броня</A><BR>
<A HREF="?otdel=24&sid=&0.567932791291376">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;шлемы</A><BR>
<A HREF="?otdel=25&sid=&0.567932791296566">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;наручи</A><BR>
<A HREF="?otdel=26&sid=&0.567932791291655">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;пояса</A><BR>
<A HREF="?otdel=27&sid=&0.567932791291687">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;поножи</A><BR>
<A HREF="?otdel=28&sid=&0.435932661191676">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;плащи</A><BR>
<A HREF="?otdel=3&sid=&0.725667864710179">Щиты</A><BR>
<A HREF="?otdel=4&sid=&0.321709306035984">Ювелирные товары: серьги</A><BR>
<A HREF="?otdel=41&sid=&0.902093651333512">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ожерелья</A><BR>
<A HREF="?otdel=42&sid=&0.510210803380268">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;кольца</A><BR>
<A HREF="?otdel=5&sid=&0.648834385828923">Заклинания: нейтральные</A><BR>
<A HREF="?otdel=51&sid=&0.722009624500359">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;боевые и защитные</A><BR>
<A HREF="?otdel=6&sid=&0.925798340638547">Амуниция</A><BR>
<A HREF="?otdel=188&sid=&0.925798340638547">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Эликсиры</A><BR>
	</div>
<div id="hint3" class="ahint"></div>
    </TD>
    </FORM>
</TR>
</TABLE>

<br><div align=right>

	<?php include("mail_ru.php"); ?>

<div>

</BODY>
</HTML>

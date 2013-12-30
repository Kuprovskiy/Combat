<?php
	session_start();
	if ($_SESSION['uid'] == null) header("Location: index.php");
	include "connect.php";
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
	include "functions.php";
	$d = mysql_fetch_array(mysql_query("SELECT sum(`massa`) FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `setsale` = 0 ; "));
	if ($user['room'] != 668) { header("Location: main.php");  die(); }
	if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }

	if (($_GET['set'] OR $_POST['set'])) {
		if ($_GET['set']) { $set = $_GET['set']; }
		if ($_POST['set']) { $set = $_POST['set']; }
		if (!$_POST['count']) { $_POST['count'] =1; }
		$dress = mysql_fetch_array(mysql_query("SELECT * FROM `shop` WHERE `id` = '{$set}' and shop='$user[room]' and buyformoney=1 LIMIT 1;"));
		if (($dress['massa']*$_POST['count']+$d[0]) > (get_meshok())) {
			echo "<font color=red><b>Недостаточно места в рюкзаке.</b></font>";
		}
		elseif(($user['money']>= ($dress['cost']*$_POST['count'])) && ($dress['count'] >= $_POST['count'])) {

			for($k=1;$k<=$_POST['count'];$k++) {
				if(mysql_query("INSERT INTO `inventory`
				(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`isrep`,
					`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gmana`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
					`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`gmp`,`gmeshok`,`destinyinv`,`gift`,`mfkritpow`,`mfantikritpow`,`mfparir`,`mfshieldblock`,`mfcontr`,`mfrub`,`mfkol`,`mfdrob`,`mfrej`,`mfdhit`,`mfdmag`,`mfhitp`,`mfmagp`,`opisan`,`second`,`vid`,`sitost`
				)
				VALUES
				('{$dress['id']}','{$_SESSION['uid']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gmana']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
				'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}','{$dress['razdel']}','{$dress['gmp']}','{$dress['gmeshok']}','{$dress['destiny']}','{$dress['gift']}','{$dress['mfkritpow']}','{$dress['mfantikritpow']}','{$dress['mfparir']}','{$dress['mfshieldblockj']}','{$dress['mfcontr']}','{$dress['mfrub']}','{$dress['mfkol']}','{$dress['mfdrob']}','{$dress['mfrej']}','{$dress['mfdhit']}','{$dress['mfdmag']}','{$dress['mfhitp']}','{$dress['mfmagp']}','{$dress['opisan']}','{$dress['second']}','{$dress['vid']}','{$dress['sitost']}'
				) ;"))
				{
					$good = 1;
				}
				else {
					$good = 0;
				}
			}
			if ($good) {
				mysql_query("UPDATE `shop` SET `count`=`count`-{$_POST['count']} WHERE `id` = '{$set}' LIMIT 1;");
				echo "<font color=red><b>Вы купили {$_POST['count']} шт. \"{$dress['name']}\".</b></font>";
				mysql_query("UPDATE `users` set `money` = `money`- '".($_POST['count']*$dress['cost'])."' WHERE id = {$_SESSION['uid']} ;");
				$user['money'] -= $_POST['count']*$dress['cost'];
				$limit=$_POST['count'];
				$invdb = mysql_query("SELECT `id` FROM `inventory` WHERE `name` = '".$dress['name']."' ORDER by `id` DESC LIMIT ".$limit." ;" );
				//$invdb = mysql_query("SELECT id FROM `inventory` WHERE `name` = '".{$dress['name']}."' ORDER by `id` DESC LIMIT $limit ;" );
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
	document.all("hint3").innerHTML = '<table border=0 width=100% cellspacing=1 cellpadding=0 bgcolor="#CCC3AA"><tr><td align=center><B>Купить неск. штук</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</TD></tr><tr><td colspan=2>'+
	'<table border=0 width=100% cellspacing=0 cellpadding=0 bgcolor="#FFF6DD"><tr><INPUT TYPE="hidden" name="set" value="'+name+'"><td colspan=2 align=center><B><I>'+txt+'</td></tr><tr><td width=80% align=right>'+
	'Количество (шт.) <INPUT TYPE="text" NAME="count" size=4></td><td width=20%>&nbsp;<INPUT TYPE="submit" value=" »» ">'+
	'</TD></TR></TABLE></td></tr></table>';
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
<tr><td><h3>Зоомагазин</td><td align=right>
<INPUT TYPE="button" value="Подсказка" style="background-color:#A9AFC0" onClick="window.open('help/shop.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">
<INPUT TYPE="submit" value="Вернуться" name="torg"></td></tr>
</FORM>
</table>
<TABLE border=0 width=100% cellspacing="0" cellpadding="4">
<TR>
    <FORM METHOD=POST ACTION="zoo.php">
	<INPUT TYPE="hidden" name="sid" value="">
	<INPUT TYPE="hidden" name="id" value="1">
	<TD valign=top align=left>
<!--Магазин-->
<TABLE border=0 width=100% cellspacing="0" cellpadding="0" bgcolor="#A5A5A5">
<TR>
	<TD align=center><B>Отдел "<?php

switch ($_GET['otdel']) {
	case null:
		echo "Заклинания: нейтральные";
		$_GET['otdel'] = 5;
	break;
	case 5:
		echo "Заклинания: нейтральные";
	break;
	case 50:
		echo "Амуниция: Еда";
	break;

}


	?>"</B>

	</TD>
</TR>
<TR><TD><!--Рюкзак-->
<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">
<?

	


	$data = mysql_query("SELECT * FROM `shop` WHERE `count` > 0 AND `razdel` = '{$_GET['otdel']}' AND `zoo` = '1' ORDER by `nlevel` ASC");
	while($row = mysql_fetch_array($data)) {
		if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
		echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"i/sh/{$row['img']}\" BORDER=0>";
		?>
		<BR><A HREF="zoo.php?otdel=<?=$_GET['otdel']?>&set=<?=$row['id']?>&sid=">купить</A>
		<IMG SRC="i/up.gif" WIDTH=11 HEIGHT=11 BORDER=0 ALT="Купить несколько штук" style="cursor:hand" onClick="AddCount('<?=$row['id']?>', '<?=$row['name']?>')"></TD>
		<?php
		echo "<TD valign=top>";
		showitem ($row);
		echo "</TD></TR>";
	}

	$user8 = mysql_fetch_array(mysql_query("SELECT money FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
?>
</TABLE>
</TD></TR>
</TABLE>

	</TD>
	<TD valign=top width=280>

	<CENTER><B>Масса всех ваших вещей: <?php


	echo $d[0];
	?>/<?=get_meshok()?><BR>
	У вас в наличии: <FONT COLOR="#339900"><?=$user8['money']?></FONT> кр.</B></CENTER>
	<div style="MARGIN-LEFT:15px; MARGIN-TOP: 10px;">

	

<div style="background-color:#d2d0d0;padding:1"><center><font color="#oooo"><B>Отделы магазина</B></center></div>

<div><A HREF="zoo.php?otdel=5&sid=&0.648834385828923"><? if ($_GET["otdel"]==5) echo "<DIV style='background-color: #C7C7C7'>";?>Заклинания: нейтральные<? if ($_GET["otdel"]==5) echo "</div>";?></A></div>

<div><A HREF="zoo.php?otdel=50&sid=&0.925798340638547"><? if ($_GET["otdel"]==50) echo "<DIV style='background-color: #C7C7C7'>";?>Амуниция: Еда<? if ($_GET["otdel"]==50) echo "</div>";?></A></div>
	</div>
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

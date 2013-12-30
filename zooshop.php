<?php
	session_start();
	if ($_SESSION['uid'] == null) header("Location: index.php");
	include "connect.php";
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
	include "functions.php";
	$d = mysql_fetch_array(mysql_query("SELECT sum(`massa`) FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `setsale` = 0 ; "));
	if ($user['room'] != 22) { header("Location: main.php");  die(); }
	if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }

	if (($_GET['set'] OR $_POST['set'])) {
		if ($_GET['set']) { $set = $_GET['set']; }
		if ($_POST['set']) { $set = $_POST['set']; }
		if (!$_POST['count']) { $_POST['count'] =1; }
		$dress = mysql_fetch_array(mysql_query("SELECT * FROM `zooshop` WHERE `id` = '{$set}' LIMIT 1;"));
		if (($dress['massa']*$_POST['count']+$d[0]) > (get_meshok())) {
			echo "<font color=red><b>Недостаточно места в рюкзаке.</b></font>";
		}
		elseif(($user['money']>= ($dress['cost']*$_POST['count'])) && ($dress['count'] >= $_POST['count'])) {

			for($k=1;$k<=$_POST['count'];$k++) {
				if(mysql_query("INSERT INTO `inventory`
				(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`isrep`,`nintel`,`magic`,`nlevel`,`otdel`,`vid`,`sitost`
				)
				VALUES
				('{$dress['id']}','{$_SESSION['uid']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['nintel']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['razdel']}','{$dress['vid']}','{$dress['sitost']}'
				) ;"))
				{
					$good = 1;
				}
				else {
					$good = 0;
				}
			}
			if ($good) {
				mysql_query("UPDATE `zooshop` SET `count`=`count`-{$_POST['count']} WHERE `id` = '{$set}' LIMIT 1;");
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
<INPUT TYPE="submit" value="Вернуться" name="cp"></td></tr>
</FORM>
</table>
<TABLE border=0 width=100% cellspacing="0" cellpadding="4">
<TR>
    <FORM METHOD=POST ACTION="zooshop.php">
	<INPUT TYPE="hidden" name="sid" value="">
	<INPUT TYPE="hidden" name="id" value="1">
	<TD valign=top align=left>
<!--Зоомагазин-->
<TABLE border=0 width=100% cellspacing="0" cellpadding="0" bgcolor="#A5A5A5">
<TR>
	<TD align=center><B>Отделы магазина "<?php
	if ($_POST['sale']) {
		//echo "Скупка";
	} else
switch ($_GET['otdel']) {
	case null:
		echo "Заклинания: нейтральные";
		$_GET['otdel'] = 1;
	break;
	case 1:
		echo "Амуниция: еда";
	break;
}


	?>"</B>

	</TD>
</TR>
<TR><TD><!--Рюкзак-->
</form>
		<?
	}
	else
{
	$data = mysql_query("SELECT * FROM `zooshop` WHERE `count` > 0 AND `razdel` = '{$_GET['otdel']}' ORDER by `nlevel` ASC");
	while($row = mysql_fetch_array($data)) {
		if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
		echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"i/sh/{$row['img']}\" BORDER=0>";
		?>
		<BR><A HREF="zooshop.php?otdel=<?=$_GET['otdel']?>&set=<?=$row['id']?>&sid=">купить</A>
		<IMG SRC="i/up.gif" WIDTH=11 HEIGHT=11 BORDER=0 ALT="Купить несколько штук" style="cursor:hand" onClick="AddCount('<?=$row['id']?>', '<?=$row['name']?>')"></TD>
		<?php
		echo "<TD valign=top>";
		showitem ($row);
		echo "</TD></TR>";
	}
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

	<INPUT TYPE="submit" value="Продать вещи" name="sale"><BR>

<div style="background-color:#d2d0d0;padding:1"><center><font color="#oooo"><B>Отделы магазина</B></center></div>
<A HREF="zooshop.php?otdel=1&sid=&0.162486541405194">Заклинания: нейтральные</A><BR>
<A HREF="zooshop.php?otdel=1&sid=&0.337606814894404">Амуниция: еда</A><BR>

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

<?php
 	session_start();
	if ($_SESSION['uid'] == null) header("Location: index.php");
         include './connect.php';
	$user = mysql_fetch_array(mysql_query('SELECT * FROM `users` WHERE `id` = \''.$_SESSION['uid'].'\' LIMIT 1;'));
	include './functions.php';
	if ($user['room'] != 1300){ header("Location: main.php"); die(); }
    if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }
?>
<HTML><HEAD>
<?php if ($_SESSION['uid'] != 7) { ?>
<script LANGUAGE='JavaScript'>
document.ondragstart = test;
//запрет на перетаскивание
document.onselectstart = test;
//запрет на выделение элементов страницы
document.oncontextmenu = test;
//запрет на выведение контекстного меню
function test() {
 return false
}
</SCRIPT>
<?php } ?>
<body bgcolor=e2e0e0 style="background-image: url(i/misc/statue.jpg);background-repeat:no-repeat;background-position:top right">
<link rel=stylesheet type="text/css" href="/i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor="#CCCCCC">
<TABLE border=0 width=100% cellspacing="0" cellpadding="0">
<FORM action="city.php?cp=1" method=POST>
<TR><TD valign=top width=100%><center><font style="font-size:24px; color:#000033"><h3>Памятник</h3></font></center>

<TD nowrap valign=top>
<BR><DIV align=right><INPUT style="font-size:12px;" type='button' onClick="location='/main.php?s=1'" value=Обновить>
<INPUT style="font-size:12px;" type='button' onClick="location='city.php?got=1&level21'" value=Вернуться></DIV></TD>


</FORM>
</table>

<?php
/*
if ($_GET['sneg']) {

$wer = mysql_query("SELECT * FROM `podarki` WHERE `owner`='".$user['id']."' and `time`>'0'"); 
$el = mysql_fetch_array($wer);
if($el['sneg']>='1'){
$wait_sec=$el["time"];
$new_t=time();
$left_time=$wait_sec-$new_t;
$left_min=floor($left_time/3600);
$left_sec=floor(($left_time-$left_min*3600)/60);
if($wait_sec>$new_t)
{
print" <font style='font-size:12px'><b style='color:#000000'> Вы можете взять очерядной чек через</b>
<font style='font-size:11px; color:#000;'> </font><b><font style='color:#FF0000'>$left_min</b></font>
<font style='font-size:11px; color:#000;'> час. </font><b><font style='color:#FF0000'>$left_sec</b></font>
<font style='font-size:11px; color:#000;'> мин. </font></font><br>";
}else{
mysql_query("DELETE FROM `podarki` WHERE `owner`='".$user['id']."'");
}

}else{	

echo '<font color=#FF0000><b>Вы взяли чек на продажу</b>'.($el['sneg']).'</font>';
$w = mysql_query("SELECT * FROM `shop` WHERE `id`='1773'"); 
$dress = mysql_fetch_array($w);		
		mysql_query("INSERT INTO `inventory`
				(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`isrep`,
					`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gmana`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gposoh`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nposoh`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
					`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`gmp`,`gmeshok`,`destinyinv`,`gift`,`mfkritpow`,`mfantikritpow`,`mfparir`,`mfshieldblock`,`mfcontr`,`mfrub`,`mfkol`,`mfdrob`,`mfrej`,`mfdhit`,`mfdmag`,`mfhitp`,`mfmagp`,`opisan`,`second`,`vid`,`sitost`,`dvur`,`mfudar`,`mfantiudar`,`bron5`,`zol_zeton`,`godenm`,`timem`,`plus_hp`,`k_kach`,`r_kach`,`d_kach`,`z_kach`
				)
				VALUES
				('".mysql_real_escape_string($dress['id'])."','".mysql_real_escape_string($_SESSION['uid'])."','".mysql_real_escape_string($dress['name'])."','".mysql_real_escape_string($dress['type'])."',".mysql_real_escape_string($dress['massa']).",".mysql_real_escape_string($dress['cost']).",'".mysql_real_escape_string($dress['img'])."',".mysql_real_escape_string($dress['maxdur']).",".mysql_real_escape_string($dress['isrep']).",'".mysql_real_escape_string($dress['gsila'])."','".mysql_real_escape_string($dress['glovk'])."','".mysql_real_escape_string($dress['ginta'])."','".mysql_real_escape_string($dress['gintel'])."','".mysql_real_escape_string($dress['ghp'])."','".mysql_real_escape_string($dress['gmana'])."','".mysql_real_escape_string($dress['gnoj'])."','".mysql_real_escape_string($dress['gtopor'])."','".mysql_real_escape_string($dress['gdubina'])."','".mysql_real_escape_string($dress['gmech'])."','".mysql_real_escape_string($dress['gposoh'])."','".mysql_real_escape_string($dress['gfire'])."','".mysql_real_escape_string($dress['gwater'])."','".mysql_real_escape_string($dress['gair'])."','".mysql_real_escape_string($dress['gearth'])."','".mysql_real_escape_string($dress['glight'])."','".mysql_real_escape_string($dress['ggray'])."','".mysql_real_escape_string($dress['gdark'])."','".mysql_real_escape_string($dress['needident'])."','".mysql_real_escape_string($dress['nsila'])."','".mysql_real_escape_string($dress['nlovk'])."','".mysql_real_escape_string($dress['ninta'])."','".mysql_real_escape_string($dress['nintel'])."','".mysql_real_escape_string($dress['nmudra'])."','".mysql_real_escape_string($dress['nvinos'])."','".mysql_real_escape_string($dress['nnoj'])."','".mysql_real_escape_string($dress['ntopor'])."','".mysql_real_escape_string($dress['ndubina'])."','".mysql_real_escape_string($dress['nmech'])."','".mysql_real_escape_string($dress['nposoh'])."','".mysql_real_escape_string($dress['nfire'])."','".mysql_real_escape_string($dress['nwater'])."','".mysql_real_escape_string($dress['nair'])."','".mysql_real_escape_string($dress['nearth'])."','".mysql_real_escape_string($dress['nlight'])."','".mysql_real_escape_string($dress['ngray'])."','".mysql_real_escape_string($dress['ndark'])."',
				'".mysql_real_escape_string($dress['mfkrit'])."','".mysql_real_escape_string($dress['mfakrit'])."','".mysql_real_escape_string($dress['mfuvorot'])."','".mysql_real_escape_string($dress['mfauvorot'])."','".mysql_real_escape_string($dress['bron1'])."','".mysql_real_escape_string($dress['bron2'])."','".mysql_real_escape_string($dress['bron3'])."','".mysql_real_escape_string($dress['bron4'])."','".mysql_real_escape_string($dress['maxu'])."','".mysql_real_escape_string($dress['minu'])."','".mysql_real_escape_string($dress['magic'])."','".mysql_real_escape_string($dress['nlevel'])."','".mysql_real_escape_string($dress['nalign'])."','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','".mysql_real_escape_string($dress['goden'])."','".mysql_real_escape_string($dress['razdel'])."','".mysql_real_escape_string($dress['gmp'])."','".mysql_real_escape_string($dress['gmeshok'])."','".mysql_real_escape_string($dress['destiny'])."','".mysql_real_escape_string($dress['gift'])."','".mysql_real_escape_string($dress['mfkritpow'])."','".mysql_real_escape_string($dress['mfantikritpow'])."','".mysql_real_escape_string($dress['mfparir'])."','".mysql_real_escape_string($dress['mfshieldblockj'])."','".mysql_real_escape_string($dress['mfcontr'])."','".mysql_real_escape_string($dress['mfrub'])."','".mysql_real_escape_string($dress['mfkol'])."','".mysql_real_escape_string($dress['mfdrob'])."','".mysql_real_escape_string($dress['mfrej'])."','".mysql_real_escape_string($dress['mfdhit'])."','".mysql_real_escape_string($dress['mfdmag'])."','".mysql_real_escape_string($dress['mfhitp'])."','".mysql_real_escape_string($dress['mfmagp'])."','".mysql_real_escape_string($dress['opisan'])."','".mysql_real_escape_string($dress['second'])."','".mysql_real_escape_string($dress['vid'])."','".mysql_real_escape_string($dress['sitost'])."','".mysql_real_escape_string($dress['dvur'])."','".mysql_real_escape_string($dress['mfudar'])."','".mysql_real_escape_string($dress['mfantiudar'])."','".mysql_real_escape_string($dress['bron5'])."','".mysql_real_escape_string($dress['zol_zeton'])."','".mysql_real_escape_string($dress['godenm'])."','".mysql_real_escape_string($dress['timem'])."','".mysql_real_escape_string($dress['plus_hp'])."','".mysql_real_escape_string($dress['k_kach'])."','".mysql_real_escape_string($dress['r_kach'])."','".mysql_real_escape_string($dress['d_kach'])."','".mysql_real_escape_string($dress['z_kach'])."'
				) ;");
if($el['time']>0){
mysql_query("UPDATE `podarki` SET `sneg`=`sneg`+1 WHERE `owner`='".$user['id']."'");
}else{
$tim =1440*60+time();
mysql_query("INSERT INTO `podarki` (`owner`,`sneg`,`time`) VALUES ('".$user['id']."','1','".$tim."');");
}
}
	}
	if ($_GET['givepodarok'] && !$user['podarokAD']) {
		echo '<font color=#FF0000><b>До 9 мая осталось ',(7-(int)date("d")),' день, поздравляю!</b></font>';
		mysql_query("INSERT INTO `inventory` (`owner`,`img`,`maxdur`,`type`,`magic`,`present`,`name`) VALUES ('".$user['id']."','big_podarokNY_gold.gif','1','4','7','9 Мая','Подарок на 9 мая');");
		mysql_query("UPDATE `users` SET `podarokAD` = 1 WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
	}
*/
	if ($_POST['comment']) {
		mysql_query('INSERT INTO `elka_suburb` (`who`,`date`,`text`) values (\''.nick3 ($user['id']).'\',\''.date("d.m.Y H:i").'\',\''.strip_tags($_POST['comment']).'\');');
	}

	
	$data = mysql_query("SELECT * FROM `elka_suburb` ORDER by `id` DESC LIMIT ".($_GET['page']*20).",20;");
?>
<table>
<tr><td>&nbsp; &nbsp;</td><Td>

 <?
 if ($user['podarokAD']==1) {print "";} else {print "<a href=\"?givepodarok=1\"></a>";} 
 print "&nbsp;";
 ?>
</td><td>&nbsp; &nbsp;</td>
<td>

</td>
</tr>
</table>

<BR>
<u>Жители столицы оставили сообщение</u> <?
	$pgs = mysql_num_rows($data)/20;
	for ($i=0;$i<=$pgs;++$i) {
		echo ' <a href="?page='.$i.'">'.($i+1).' стр.</a> ';
	}
?><BR>

<?
	while($row = mysql_fetch_array($data)) {
		echo '<span class=date>',$row['date'],'</span> ',$row['who'],' - ',$row['text'],'<BR>';
	}
// 21.12.2009 05:02
?>
<form action='' method='post'>
Оставить сообщение Мироздателю: <INPUT TYPE="text" name="comment" SIZE="50" VALUE="" maxlength=150>
<input type="submit" name="" value="Добавить Сообщение">	
</form>

<div id="hint3" class="ahint"></div>

</BODY>
</HTML>

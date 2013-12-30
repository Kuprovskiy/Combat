<?php
  session_start();
  include "connect.php";
  include "functions.php";
  $_SERVER['QUERY_STRING']=str_replace("%20"," ",$_SERVER['QUERY_STRING']);
  $us = " `name` = '{$_SERVER['QUERY_STRING']}' or `short` = '{$_SERVER['QUERY_STRING']}' ";
  $klan = mysql_fetch_array(mysql_query("SELECT * FROM `clans`  WHERE {$us} LIMIT 1;"));
  $klan["members"]=unserialize($klan["members"]);
  foreach ($klan["members"] as $k=>$v) {
    $klan["members"][$k]["klan"]=$klan["short"];
    $v["klan"]=$klan["short"];
    $members[$v["id"]]=$v;
  }
  $usr ="{$_SERVER['QUERY_STRING']}";
  $_SERVER['QUERY_STRING'] = $klan;
  if($klan['name'] == NULL) {
    $usr = htmlspecialchars($usr);

        ?>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="ru">
<TITLE>Произошла ошибка</TITLE></HEAD><BODY text="#FFFFFF"><p><font color=black>
Произошла ошибка: <pre>Нет информации о клане "<?=$usr?>" в этом городе</pre>
<b><p><a href = "javascript:window.history.go(-1);">Назад</b></a>
<HR>
<p align="right">(c) <a href="http://xn--2-btb1a.xn--p1ai">xn--2-btb1a.xn--p1ai</a></p>
<?php include("mail_ru.php"); ?>
</body></html>
<?
        die();
    }
?>
<HTML>
<HEAD>
<title>Информация о клане <?=$klan['name']?></title>
<link rel=stylesheet type="text/css" href="/i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<link href="/i/move/design3.css" rel="stylesheet" type="text/css">
<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<style type="text/css">
img.pnged {
behavior:   url(/pngbehavior.htc);
}
</style>
</HEAD>
<body style="margin:10px; margin-top:5px; background-image: url(/i/klan/<?=$klan['clanbig']?>.gif); background-repeat:no-repeat; background-position: top right" bgcolor=e2e0e0>
<table width="100%" cellpadding=0 cellspacing=0 border=0>
<?if ($klan['guard']==1) {?>
<tr><td colspan=2 align=center>Информация о клане <img src="<?=IMGBASE?>/i/guard.gif" alt="Гвардейский клан"> "<b><?=$klan['name']?></b>"</td></tr>
<?}else{?>
<tr><td colspan=2 align=center>Информация о клане  "<b><?=$klan['name']?></b>"</td></tr>
<?}?>
</table>
<table width="100%" cellpadding=0 cellspacing=0 border=0>
<tr>
<td width="50%">Уровень: <FONT color=#007200><B><?=$klan['clanlevel']?></B></FONT></td>
<td width="50%">
Знак клана: <img src="<?=IMGBASE?>/i/klan/<?=$klan['short']?>.gif"> Склонность: <img src="<?=IMGBASE?>/i/align_<?=$klan['align']?>.gif">
</td>
</tr>
<tr>
<td>Рейтинг: <a style='color: #007200;'><?=$klan['clanreit']?></td>
<?
if ($klan['clandem']==0) {
echo'<td>Тип правления: <FONT color=#007200><B>неизвестно</B></FONT></td>';
}elseif ($klan['clandem']==1) {
echo'<td>Тип правления: <FONT color=#007200><B>Анархия</B></FONT></td>';
}elseif ($klan['clandem']==2) {
echo'<td>Тип правления: <FONT color=#007200><B>Монархия</B></FONT></td>';
}elseif ($klan['clandem']==3) {
echo'<td>Тип правления: <FONT color=#007200><B>Диктатура</B></FONT></td>';
}elseif ($klan['clandem']==4) {
echo'<td>Тип правления: <FONT color=#007200><B>Демократия</B></FONT></td>';
}
?>
</tr>
<tr>
<td>Девиз клана: <B><?=$klan['deviz']?></B></td></tr>
<tr>
<td colspan=2 align=center style='padding-right: 150px;'><hr></td>
</tr>
<tr valign=top>
<td>
Глава клана:
<?
  echo clannick3($klan["glava"]);
    /*$data=mysql_query("SELECT `id`, `login`,`level`,`align` FROM `users` WHERE `klan` = '".$klan['short']."';");
                    while ($row = mysql_fetch_array($data)) {
                            if ($row['id'] == $klan['glava']) {
                                echo 'Глава клана:';
                                nick2($row['id'],0);
}
}*/
?>
<!--<hr style='margin-right: 15px;'>Союз: <strong><?=$union['souzname']?></strong> (<img src="http://img.combats.com/i/klan/BrothersMercenaries.gif"> <a href="/clans_inf.pl?BrothersMercenaries" target=_blank><b>BrothersMercenaries</b></a>, <img src="http://img.combats.com/i/klan/Mercenaries.gif"> <a href="/clans_inf.pl?Mercenaries" target=_blank><b>Mercenaries</b></a>, <img src="http://img.combats.com/i/klan/RecruitsMercenaries.gif"> <a href="/clans_inf.pl?RecruitsMercenaries" target=_blank><b>RecruitsMercenaries</b></a> )<br>-->
<? if ($klan['homepage']) {?>
<hr style='margin-right: 15px;'>Сайт Клана: <strong><?
  if (strpos($klan['homepage'],"http")!==false) echo "<a  href=\"$klan[homepage]\" target=\"_blank\">$klan[homepage]</a>";
  else echo "<a  href=\"http://$klan[homepage]\" target=\"_blank\">$klan[homepage]</a>";
?></strong><br>
<?}?>
<td>
Бойцы клана:
<?
					$data=mysql_query("SELECT `id`, `login`,`level`,`align` FROM `users` WHERE `klan` = '".$klan['short']."' order by level DESC, login asc ;");
					while ($row = mysql_fetch_array($data)) {
							echo '<br>';
							nick2($row['id']);
}

$R_ONLINE = mysql_query("SELECT `klan` FROM users WHERE `klan` = '{$klan['short']}';");
$total = 0;
        while(mysql_fetch_array($R_ONLINE)){
        $total++;
        }
?>
<br>Всего: <b><?=$total?></b>
</td>
</tr>
<tr>
<td colspan=2 align=right>
<a href="clanreit.php">таблица кланов</a>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</HTML>
<?php include("mail_ru.php"); ?>
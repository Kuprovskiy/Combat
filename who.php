<?php
ob_start("ob_gzhandler");
session_start();
if ($_SESSION['uid'] == null) header("Location: index.php");
include "connect.php";
$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
$al = mysql_fetch_assoc(mysql_query("SELECT * FROM `aligns` WHERE `align` = '{$user['align']}' LIMIT 1;"));
include "functions.php";
header("Cache-Control: no-cache");
if ($user['align']<2 || $user['align']>3) header("Location: index.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="ru">
<meta http-equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<meta http-equiv=Expires content=0>	
<LINK REL=StyleSheet HREF='i/main.css' TYPE='text/css'>
<title>Кто Где</title>
</head>
<META Http-Equiv=Expires Content=0>
<style>
.row {
cursor:pointer;
}
</style>
<script type="text/javascript">
  function show(ele) {
      var srcElement = document.getElementById(ele);
      if(srcElement != null) {
          if(srcElement.style.display == "block") {
            srcElement.style.display= 'none';
          }
          else {
            srcElement.style.display='block';
          }
      }
  }

var Hint3Name = '';
// Заголовок, название скрипта, имя поля с логином
function findlogin(title, script, name){
	document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
	'<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><form action="'+script+'" method=POST><INPUT TYPE=hidden name=sd4 value="6"><td colspan=2>'+
	'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD width=50% align=right><INPUT TYPE=text NAME="'+name+'"></TD><TD width=50%><INPUT TYPE="submit" value=" »» "></TD></TR></FORM></TABLE></td></tr></table>';
	document.all("hint3").style.visibility = "visible";
	document.all("hint3").style.left = 100;
	document.all("hint3").style.top = 100;
	document.all(name).focus();
	Hint3Name = name;
}
function returned2(s){
	if (top.oldlocation != '') { top.frames['main'].location=top.oldlocation+'?'+s+'tmp='+Math.random(); top.oldlocation=''; }
	else { top.frames['main'].location='main.php?edit='+Math.random() }
}
function closehint3(){
	document.all("hint3").style.visibility="hidden";
    Hint3Name='';
}
</script>
</HEAD>
<body topMargin=4 leftMargin=4 bottomMargin=4 rightMargin=4 bgcolor=#dddddd>
<script language="JavaScript" type="text/javascript" src="commoninf.js"></script>          	
			<center><a href="who.php" class=us2>Обновить</a><center>
			<center><a href="main.php" class=us2>Вернуться</a><center>
<?
$online = mysql_fetch_row(mysql_query("select COUNT(*) from `online`  WHERE `real_time` >= ".(time()-60).";"));
?>	             			 
                            
          Жителей Он-лайн  <font color=red> <b><?=$online[0];?></b> </font> чел.<table border="0" cellpadding=3 cellspacing=1  style="border-collapse: collapse" width="600" align="center">
	<tr height=30>
		<td bgcolor=#FCFAF3 style="color:#990000"><b style="color:green">Сейчас в игре  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  Местонахождение</b></td>
	</tr>
		<tr><td bgcolor=#FCFAF3 valign=center noWrap>
								<?
					$data=mysql_query("SELECT * FROM `online` WHERE `real_time` > '".(time()-60)."';");	
					while ($row = mysql_fetch_array($data)) {
						if ($row['online']<1) {
							echo '<A HREF="javascript:top.AddToPrivate(\'',nick7($row['id']),'\', top.CtrlPress)" target=refreshed><img src="i/lock.gif" width=20 height=15></A>';							nick2($row['id']);
							if($row['room'] > 500 && $row['room'] < 561) {
								$rrm = 'Башня смерти, участвует в турнире';
							}
							else {
								$rrm = $rooms[$row['room']];
							}
							echo ' &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp ',$row['status'],' &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <font color=green><i>',$rrm,'</i></font><BR>';
						}
					}
					$data=mysql_query("SELECT * FROM `online` WHERE `real_time` > '".(time()-60)."';");
					while ($row = mysql_fetch_array($data)) {
						if ($row['online']>1) {
							echo '<img src="i/lock1.gif" width=20 height=15>';
							nick2($row['id']);
							echo ' &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp ',$row['status'],' &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <i><font color=gray>персонаж не в клубе</font></i><BR>';
						}
					}
				?>			
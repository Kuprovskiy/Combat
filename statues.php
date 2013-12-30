<?php
session_start();
if ($_SESSION['uid'] == null) header("Location: index.php");
include "connect.php";
include "funtions.php";
$user = mysql_fetch_array(mysql_query("SELECT * from user where id='".$_SESSION['uid']."'"));
$is_eff  = mysql_result(mysql_query("SELECT count(id) FROM effects where type='9991' and owner='".$_SESSION['uid']."'"), 0, 0);
$is_eff2 = mysql_result(mysql_query("SELECT time FROM effects where type='9991' and owner='".$_SESSION['uid']."'"), 0, 0);
if ($_GET['get']=='10' && $user['room']='11111' && !$is_eff) {
mysql_query("UPDATE `users` SET `money`=`money`+'50' where `id`='".$_SESSION['uid']."'") or die(mysql_error());
mysql_query("insert into effects (`owner`,`type`,`time`,`name`) values (".$_SESSION['uid'].",9991,".(time()+86400).",'Задержка на поклонение')") or die(mysql_error());
mysql_query("insert into effects (`owner`,`type`,`time`,`name`,`sila`,`intel`) values (".$_SESSION['uid'].",9990,".(time()+0).",'Благословение Ангела',0,0)") or die(mysql_error());
$err = "Вы получили благословение Ангела. Вам начислено 50 кр";
//addch("<img src=i/magic/blago_admin.gif>Ангел &quot;Мироздатель&quot; наложил заклятие \"Благословение Ангела\" на &quot;{$user['login']}&quot;, сроком 2 часа.");
} elseif ($_GET['get']=='10' && $user['room']='11111' && $is_eff) {
$wait_sec=$is_eff2;
$new_t=time();
$left_time=$wait_sec-$new_t;
$left_min=floor($left_time/3600);
$left_sec=floor(($left_time-$left_min*3600)/60);
if($left_min==1){$time_h="час";}
if($left_min>1 and $left_min<5){$time_h="часа";}
if($left_min>4){$time_h="часов";}
$time_left=$left_min." ".$time_h." ".$left_sec." мин";
$err="Вы уже получали благословение Ангела. До следущего благословения осталось ".$time_left.".";
}	
?>	
<HTML>
<HEAD>
<?php if ($_SESSION['uid'] != 7) { ?>
<script LANGUAGE='JavaScript'>
document.ondragstart = test;
document.oncontextmenu = test;
function test() {
 return false
}
</SCRIPT>
<?php } ?>
<link rel=stylesheet type="text/css" href="/i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<script src="js/lib/jquery.js" type="text/javascript"></script>
</HEAD>
<body bgcolor=e2e0e0 background-repeat:no-repeat;background-position:top right">
<div id=hint4 class=ahint></div>
<TABLE width=100%>
<TR><TD valign=top width=100%><center><font style="font-size:24px; color:#000033"><h3>Памятник Ангела</h3></font></center>
<TD nowrap valign=top>
<BR><DIV align=right><INPUT style="font-size:12px;" type='button' onClick="location='/main.php?s=1'" value=Обновить>
<INPUT style="font-size:12px;" type='button' onClick="location='city.php?cp=1'" value=Вернуться></DIV></TD>
</TR>
<tr>
<td>
<div align="left"><font color="red"><b><?=$err?></b></font></div>
<a href="?get=10">Получить благословение Ангела</a>
</td>
</tr>
</TABLE>
</BODY>
</HTML>
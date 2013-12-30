<?
$la = sys_getloadavg();
$la[0]=$la[0]/4;
$la[1]=$la[1]/4;
$la[2]=$la[2]/4;
?>
<HTML>
<HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
</HEAD>
<BODY leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=e2e0e0>
<h4>Средняя загрузка</h4>
<?
    echo "<B><font color=#DEB887>за 1 минуту:</B> ".($la[0]*100)."% </font>";
    if ($la[0] < 0.16) {
        echo "<font color=green>низкая</font>";
    } elseif ($la[0] < 0.25) {
        echo "<font color=orange>средняя</font>";
    } elseif ($la[0] > 0.25) {
        echo "<font color=red>высокая</font>";
    }
    echo "<BR><font color=#DEB887><B>за 5 минут:</B> ".($la[1]*100)."% </font>";
    if ($la[1] < 0.16) {
        echo "<font color=green>низкая</font>";
    } elseif ($la[1] < 0.25) {
        echo "<font color=orange>средняя</font>";
    } elseif ($la[1] > 0.25) {
        echo "<font color=red>высокая</font>";
    }
    echo "<BR><B><font color=#DEB887>за 15 минут:</B> ".($la[2]*100)."% </font>";
    if ($la[2] < 0.16) {
        echo "<font color=green>низкая</font>";
    } elseif ($la[2] < 0.25) {
        echo "<font color=orange>средняя</font>";
    } elseif ($la[2] > 0.25) {
        echo "<font color=red>высокая</font>";
    }
//  $up=exec("uptime");
//  echo "<br>".substr($up,0,strpos($up,','));
//    include "connect.php";
$online = mysql_query("select * from `online`  WHERE `real_time` >= ".(time()-60).";");
$vsego_u = mqfa1("select count(id) from `users`");
?>
<br><font color=#DEB887>(Нас уже <?=$vsego_u?> и из них в игре только <?=mysql_num_rows($online)?>.)</font>

</BODY>
</HTML>
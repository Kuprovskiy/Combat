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
<h4>������� ��������</h4>
<?
    echo "<B><font color=#DEB887>�� 1 ������:</B> ".($la[0]*100)."% </font>";
    if ($la[0] < 0.16) {
        echo "<font color=green>������</font>";
    } elseif ($la[0] < 0.25) {
        echo "<font color=orange>�������</font>";
    } elseif ($la[0] > 0.25) {
        echo "<font color=red>�������</font>";
    }
    echo "<BR><font color=#DEB887><B>�� 5 �����:</B> ".($la[1]*100)."% </font>";
    if ($la[1] < 0.16) {
        echo "<font color=green>������</font>";
    } elseif ($la[1] < 0.25) {
        echo "<font color=orange>�������</font>";
    } elseif ($la[1] > 0.25) {
        echo "<font color=red>�������</font>";
    }
    echo "<BR><B><font color=#DEB887>�� 15 �����:</B> ".($la[2]*100)."% </font>";
    if ($la[2] < 0.16) {
        echo "<font color=green>������</font>";
    } elseif ($la[2] < 0.25) {
        echo "<font color=orange>�������</font>";
    } elseif ($la[2] > 0.25) {
        echo "<font color=red>�������</font>";
    }
//  $up=exec("uptime");
//  echo "<br>".substr($up,0,strpos($up,','));
//    include "connect.php";
$online = mysql_query("select * from `online`  WHERE `real_time` >= ".(time()-60).";");
$vsego_u = mqfa1("select count(id) from `users`");
?>
<br><font color=#DEB887>(��� ��� <?=$vsego_u?> � �� ��� � ���� ������ <?=mysql_num_rows($online)?>.)</font>

</BODY>
</HTML>
<?php

session_start();
if ($_SESSION['uid'] == null) header("Location: index.php");

include "connect.php";
$user=mysql_fetch_array(mysql_query("SELECT * from users where id='".$_SESSION['uid']."'"));

if($_GET['get']) {
    switch($_GET['get']){
        case 'suburb':
        $err='�� ������ ����� �� Suburb Virt City';
        //mysql_query("insert into inventory (`owner`,`made`,`img`,`type`,`maxdur`,`name`,`letter`) values (".$_SESSION['uid'].",'".$_SESSION['incity']."','ticket1.gif',100,1,'�����','���� ����������� � Suburb: ".date('d.m.Y � H:i')."');");
        mysql_query("UPDATE `users` SET `money`=`money`-0, `incity`='suburb' where `id`='".$_SESSION['uid']."'");
        mysql_query("UPDATE `online` SET `city`='suburb' where `id`='".$_SESSION['uid']."'");
        break;
        case 'virtcity':
        $err='�� ������ ����� �� Virt City';
        //mysql_query("insert into inventory (`owner`,`made`,`img`,`type`,`maxdur`,`name`,`letter`) values (".$_SESSION['uid'].",'".$_SESSION['incity']."','ticket1.gif',100,1,'�����','���� ����������� � Suburb: ".date('d.m.Y � H:i')."');");
        mysql_query("UPDATE `users` SET `money`=`money`-0, `incity`='virtcity' where `id`='".$_SESSION['uid']."'");
        mysql_query("UPDATE `online` SET `city`='virtcity' where `id`='".$_SESSION['uid']."'");
        break;
    }
    header("Location: main.php?s=1");
    exit;
}

?>
	
<html>
    
<head>
    <?php if ($user['id'] != 7) { ?>
    <script LANGUAGE='JavaScript'>
    document.ondragstart = test;
    //������ �� ��������������
    document.onselectstart = test;
    //������ �� ��������� ��������� ��������
    document.oncontextmenu = test;
    //������ �� ��������� ������������ ����
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
    <script src="/js/lib/jquery.js" type="text/javascript"></script>
</head>
    
<body bgcolor=e2e0e0 style="background-image: url(/i/misc/coach.png);background-repeat:no-repeat;background-position:top right">

<div id=hint4 class=ahint></div>
<table width=100%>
    <tr>
        <td valign=top width=100%>
            <h3 style="font-size:24px; color:#8B0000; text-align: center;">
                <?php echo '������ � ' . (($user['incity'] == 'suburb') ? 'Suburb Virt City' : 'Virt City'); ?>
            </h3>
        </td>
        <td nowrap valign=top>
            <br>
            <div align=right>
                <input style="font-size:12px;" type='button' onClick="location='/main.php?s=1'" value=��������>
                <?php if ($user['incity'] == 'suburb') { ?>
                    <input style="font-size:12px;" type='button' onClick="location='city.php?got=1&level20'" value="����������� �������">
                <?php } else { ?>
                    <input style="font-size:12px;" type='button' onClick="location='city.php?got=1&level45'" value="������ ����">
                <?php } ?>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div>
                <font color="red"><b><?=$err?></b></font>
            </div>
            <table width="90%" border="0" cellspacing="1" cellpadding="3" bgcolor="#A5A5A5" align="left">
                <tr bgcolor="#A5A5A5">
                    <td align="center"></td>
                    <td align="center"><span id="city2"><b><?php echo '������� � ' . (($user['incity'] == 'suburb') ? 'Virt City' : 'Suburb Virt City'); ?></b></span></td>
                </tr>
                <tr bgcolor="#C7C7C7" align="center">
                    <td width="17%">����</td>
                    <td><span id="price2">0 ��.<img src=/i/misc/forum/fo1.gif></span></td>
                </tr>
                <tr bgcolor="#C7C7C7" align="center">
                    <td>����� �����������</td>
                    <td>��� ��������</td>
                </tr>
                <tr bgcolor="#C7C7C7">
                    <td></td>
                    <td align="center">
                        <img src="/i/misc/ticket2.gif"><br>
                        <a href="#" style="cursor:hand;" onclick="if (confirm('�� �������, ��� ������ ������ ����� �� ' + $('#city2').text() + ' �� ' + $('#price2').text() + '?')) window.location='station.php?get=<?php echo ($user['incity'] == 'suburb') ? 'virtcity' : 'suburb'; ?>'">������</a>
                    </td>
                    <!--td align="center"><img src="/i/misc/ticket4.gif"><br>��� �������</td-->
            </table>
        </td>
    </tr>
</table>

</body>
</html>

<?php

	session_start();
	if ($_SESSION['uid'] == null) header("Location: index.php");

        include "connect.php";
        $user=mysql_fetch_array(mysql_query("SELECT * from users where id='".$_SESSION['uid']."'"));
        
        if($_GET['get']){
            switch($_GET['get']){
                    case 'suburb':
                    $err='�� ������ ����� �� Suburb';
                    mysql_query("insert into inventory (`owner`,`made`,`img`,`type`,`maxdur`,`name`,`letter`) values (".$_SESSION['uid'].",'".$_SESSION['incity']."','ticket1.gif',100,1,'�����','���� ����������� � Suburb: ".date('d.m.Y � H:i')."');");
                    mysql_query("UPDATE `users` SET `money`=`money`-15, `incity`='suburb' where `id`='".$_SESSION['uid']."'");
                    mysql_query("UPDATE `online` SET `city`='suburb' where `id`='".$_SESSION['uid']."'");
                    //session_destroy();
                    die("<script>top.location.href='/oldcity/battle.php';</script>");
                    break;
                    /*case 'old':
                    $err='�� ������ ����� �� Old City';
                    mysql_query("insert into inventory (`owner`,`made`,`img`,`type`,`maxdur`,`name`,`letter`) values (".$_SESSION['uid'].",'".$_SESSION['incity']."','ticket1.gif',100,1,'�����','���� ����������� � Old city: ".date('d.m.Y � H:i')."');");
                    mysql_query("UPDATE `users` SET `money`=`money`-15, `incity`='oldcity' where `id`='".$_SESSION['uid']."'");
                    mysql_query("UPDATE `online` SET `city`='oldcity' where `id`='".$_SESSION['uid']."'");
                    //session_destroy();
                    die("<script>top.window.location='http://test.lostcombats.com/oldcity/index.php';</script>");
                    break;
                    case 'ang':
                    if($user['money']>=15){$err='�� ������ ����� �� Angels City';
                    mysql_query("insert into inventory (`owner`,`made`,`img`,`type`,`maxdur`,`name`,`letter`) values (".$_SESSION['uid'].",'".$_SESSION['incity']."','ticket2.gif',100,1,'�����','���� ����������� � Angels city: ".date('d.m.Y � H:i')."');");
                    mysql_query("UPDATE `users` SET `money`=`money`-15, `incity`='angelscity' where `id`='".$_SESSION['uid']."'");
                    mysql_query("UPDATE `online` SET `city`='angelscity' where `id`='".$_SESSION['uid']."'");
                    //session_destroy();
                    die("<script>top.window.location='http://test.lostcombats.com/angelscity/index.php';</script>");
                    }
                    else{
                         $err="�� ���������� �����.".$user['money'];
                        }
                    break;
                    case 'dem':
                    $err='�� ������ ����� �� demonscity';
                    mysql_query("insert into inventory (`owner`,`made`,`img`,`type`,`maxdur`,`name`,`letter`) values (".$_SESSION['uid'].",'".$_SESSION['incity']."','ticket3.gif',100,1,'�����','���� ����������� � Demons city: ".date('d.m.Y � H:i')."');");
                    mysql_query("UPDATE `users` SET `money`=`money`-15, `incity`='demonscity' where `id`='".$_SESSION['uid']."'");
                    mysql_query("UPDATE `online` SET `city`='demonscity' where `id`='".$_SESSION['uid']."'");
                    //session_destroy();
                    die("<script>top.window.location='http://demonscity.test.lostcombats.com/index.php';</script>");
                    break;
                    case 'dev':
                    $err='�� ������ ����� �� devilscity';
                    mysql_query("insert into inventory (`owner`,`made`,`img`,`type`,`maxdur`,`name`,`letter`) values (".$_SESSION['uid'].",'".$_SESSION['incity']."','ticket4.gif',100,1,'�����','���� ����������� � Devils city: ".date('d.m.Y � H:i')."');");
                    mysql_query("UPDATE `users` SET `money`=`money`-15, `incity`='devilscity' where `id`='".$_SESSION['uid']."'");
                    mysql_query("UPDATE `online` SET `city`='devilscity' where `id`='".$_SESSION['uid']."'");
                    //session_destroy();
                    die("<script>top.window.location='http://devilscity.test.lostcombats.com/index.php';</script>");
                    break; 
                    case 'dem':
                    $err='�� ������ ����� �� demonscity';
                    mysql_query("insert into inventory (`owner`,`made`,`img`,`type`,`maxdur`,`name`,`letter`) values (".$_SESSION['uid'].",'".$_SESSION['incity']."','ticket1.gif',100,1,'�����','���� ����������� � Demons city: ".date('d.m.Y � H:i')."');");
                    mysql_query("UPDATE `users` SET `money`=`money`-15, `incity`='demonscity' where `id`='".$_SESSION['uid']."'");
                    mysql_query("UPDATE `online` SET `city`='demonscity' where `id`='".$_SESSION['uid']."'");
                    //session_destroy();
                    die("<script>top.window.location='http://demonscity.test.lostcombats.com/index.php';</script>");
                    break; 
                    case 'dem':
                    $err='�� ������ ����� �� demonscity';
                    mysql_query("insert into inventory (`owner`,`made`,`img`,`type`,`maxdur`,`name`,`letter`) values (".$_SESSION['uid'].",'".$_SESSION['incity']."','ticket1.gif',100,1,'�����','���� ����������� � Demons city: ".date('d.m.Y � H:i')."');");
                    mysql_query("UPDATE `users` SET `money`=`money`-15, `incity`='demonscity' where `id`='".$_SESSION['uid']."'");
                    mysql_query("UPDATE `online` SET `city`='demonscity' where `id`='".$_SESSION['uid']."'");
                    //session_destroy();
                    die("<script>top.window.location='http://demonscity.test.lostcombats.com/index.php';</script>");
                    break; 
                    case 'dem':
                    $err='�� ������ ����� �� demonscity';
                    mysql_query("insert into inventory (`owner`,`made`,`img`,`type`,`maxdur`,`name`,`letter`) values (".$_SESSION['uid'].",'".$_SESSION['incity']."','ticket1.gif',100,1,'�����','���� ����������� � Demons city: ".date('d.m.Y � H:i')."');");
                    mysql_query("UPDATE `users` SET `money`=`money`-15, `incity`='demonscity' where `id`='".$_SESSION['uid']."'");
                    mysql_query("UPDATE `online` SET `city`='demonscity' where `id`='".$_SESSION['uid']."'");
                    //session_destroy();
                    die("<script>top.window.location='http://demonscity.test.lostcombats.com/index.php';</script>");
                    break;*/
 
        }
        
        }
	?>
	<HTML><HEAD>
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
<link rel=stylesheet type="text/css" href="http://lostcombats.com/i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<script src="/oldcity/js/lib/jquery.js" type="text/javascript"></script>
</HEAD>
<body bgcolor=e2e0e0 style="background-image: url(/i/misc/coach.png);background-repeat:no-repeat;background-position:top right">

<div id=hint4 class=ahint></div>


<TABLE width=100%>
<TR><TD valign=top width=100%><center><font style="font-size:24px; color:#000033"><h3>������ � Capital City</h3></font></center>




<TD nowrap valign=top>
<BR><DIV align=right><INPUT style="font-size:12px;" type='button' onClick="location='/main.php?s=1'" value=��������>
<INPUT style="font-size:12px;" type='button' onClick="location='city.php?got=1&level45'" value="� Capital City"></DIV></TD>

</TR>
<tr>
    <td>
        
<div><font color="red"><b><?=$err?></b></font></div>
        <table width="90%" border="0" cellspacing="1" cellpadding="3" bgcolor="#A5A5A5" align="left">
            <tr bgcolor="#A5A5A5">
                <td align="center"></td>
                
                <td align="center"><span id="city2"><b>Suburb</b></span></td>
                <!--td align="center"><span id="city3"><b>Demons City</b></span></td>
                
                <td align="center"><span id="city4"><b>Devils �ity</b></span></td>
                <td align="center"><span id="city5"><b>Sun City</b></span></td>
                <td align="center"><span id="city6"><b>�oon City</b></span></td>
                <td align="center"><span id="city7"><b>Sand City</b></span></td>
                <td align="center"></td-->
           
                 </tr>
                  <tr bgcolor="#C7C7C7" align="center">
                      <td width="17%">����</td>
                      
                      <td><span id="price2">15 ��.<img src=http://lostcombats.com/i/sh/fo2.gif></span></td>
                      <!--td><span id="price3">15 ��.<img src=http://lostcombats.com/i/sh/fo3.gif></span></td>
                      <td><span id="price1">15 ��.<img src=http://lostcombats.com/i/sh/fo4.gif></span></td>
                      <td><span id="price2">15 ��.<img src=http://lostcombats.com/i/sh/fo5.gif></span></td>
                      <td><span id="price3">15 ��.<img src=http://lostcombats.com/i/sh/fo8.gif></span></td>
                      <td><span id="price3">15 ��.<img src=http://lostcombats.com/i/sh/fo7.gif></span></td-->
                 </tr>
                  <tr bgcolor="#C7C7C7" align="center">
                      <td>����� �����������</td>
                     
                      <td>��� ��������</td>
                      <!--td>��� ��������</td>
                      <td>��� ��������</td>
                      <td>��� ��������</td>
                      <td>��� ��������</td>
                      <td>��� ��������</td-->

</tr>
                 
                    
                  <tr bgcolor="#C7C7C7">
                      <td></td>
                      <?php if ($user['id'] == 7 || $user['id'] == 50 || $user['id'] == 2735) { ?>
                      <td align="center"><img src="http://lostcombats.com/i/misc/ticket2.gif"><br><a href="#" style="cursor:hand;" onclick="if (confirm('�� �������, ��� ������ ������ ����� �� ' + $('#city2').text() + ' �� ' + $('#price2').text() + '?')) window.location='coach.php?get=suburb'">������</a></td>
                      <?php } else { ?>
                      <td align="center"><img src="http://lostcombats.com/i/misc/ticket4.gif"><br>��� �������</td>
                      <?php } ?>
                      <!--td align="center"><img src="http://lostcombats.com/i/misc/ticket3.gif"><br>��� �������</td>
                      <td align="center"><img src="http://lostcombats.com/i/misc/ticket4.gif"><br>��� �������</td>
                      <td align="center"><img src="http://lostcombats.com/i/misc/ticket5.gif"><br>��� �������</td>
                      <td align="center"><img src="http://lostcombats.com/i/misc/ticket8.gif"><br>��� �������</td>
                      <td align="center"><img src="http://lostcombats.com/i/misc/ticket7.gif"><br>��� �������</td-->

        
</table>
    </td>
</tr>

</TABLE>
</BODY>
</HTML>
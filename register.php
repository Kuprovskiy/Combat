<?php
session_unset();
session_start();
include "connect.php";
include "functions.php";
function ipblocked($ip) {
return false;
}
if(!$_POST['ref']){
$ref = $_GET['ref'];}else{$ref = $_POST['ref'];}
if (!ereg("^[0-9]+$",$ref)){$ref=0;}
if(!empty($ref)){$s_ref = mysql_fetch_array(mq("SELECT id FROM `users` WHERE `id`='$ref';"));
if(!$s_ref){$ref=0;}
}
//if (strpos($_SERVER["HTTP_REFERER"],"combats")) {
//  $_REQUEST=array();
//  $_POST=array();
//  $_SESSION["spammer"]=1;
//    echo("spammer");
//}
$_POST['hobby']=str_replace("\\r","",$_POST['hobby']);
if ($_GET['edit']) {
  $user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
  getfeatures($user);
  if ($_SESSION['uid'] == null) header("Location: index.php");
  $maxlen=$user["sociable"]*200+1000;
} else $maxlen=1000;
if (strlen($_POST["hobby"])>$maxlen) $_POST["hobby"]=substr($_POST["hobby"], 0, $maxlen);
if ($_POST['end'] != null) header("Location: main.php");
if ($_POST['add'] && $_GET['edit']) {
if ($_POST['name']==null) {
$err .= "������� ���! ";
$stop =1;
}
elseif ( ! ($_POST['ChatColor'] == "Black" || $_POST['ChatColor'] == "Blue" || $_POST['ChatColor'] == "#8700e4" ||  $_POST['ChatColor'] == "Fuchsia" || $_POST['ChatColor'] == "Gray" || $_POST['ChatColor'] == "Green" || $_POST['ChatColor'] == "Maroon" || $_POST['ChatColor'] == "Navy" || $_POST['ChatColor'] == "Olive" || $_POST['ChatColor'] == "Purple" || $_POST['ChatColor'] == "Teal" ||  $_POST['ChatColor'] == "Orange" ||  $_POST['ChatColor'] == "Chocolate" || $_POST['ChatColor'] == "DarkKhaki")) {
$err .= "�������� ������������ ������ ����� ��������� � ���� ������ ! ";
$_POST['ChatColor'] = "Black";
}
    if($stop!=1) {
$_POST['hobby']=str_replace("&lt;BR&gt;","<BR>",$_POST['hobby']);
     if (haslinks("$_POST[city2] $_POST[icq] $_POST[name] $_POST[hobby] $_POST[about]")) {
       $f=fopen("logs/autosleep.txt","ab");
       fwrite($f, "$user[login]: $_POST[city2] $_POST[icq] $_POST[hobby] $_POST[about]\r\n");
       fclose($f);

       mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('$user[id]','�������� ��������',".(time()+3600).",2);");
       reportadms("<br><b>$user[login]</b>: ���� � ����", "�����������");
       addch("<img src=i/magic/sleep.gif> ����������� ������� �������� �������� �� &quot;$user[login]&quot;, ������ 60 ���. �������: ���.");
     }
     mq("UPDATE `users` SET  `city` = '{$_POST['city2']}', `icq` = '{$_POST['icq']}',
                 `http` = '{$_POST['homepage']}', `info` = '{$_POST['hobby']}', `lozung` = '{$_POST['about']}',
                 `color` = '{$_POST['ChatColor']}', `realname` = '{$_POST['name']}' WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
     $user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
    }
}
if ($_POST['add'] && !$_GET['edit']) {

                $stop =0;
                $login=$_POST['login'];
                $res = mysql_fetch_array(mq("SELECT `id` FROM `users` WHERE `login` = '".$login."' union SELECT `id` FROM `allusers` WHERE `login` = '".$login."'"));
                $birth_day=(int)$_POST['birth_day'];
                $birth_month=(int)$_POST['birth_month'];
                $birth_year=(int)$_POST['birth_year'];


                if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
                {
                  $ip=$_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
                        {
                  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                  $ip=$_SERVER['REMOTE_ADDR'];
                }
                $regged=mqfa1("select id from users where (ip='$_SERVER[REMOTE_ADDR]' or ip='$ip') and date_add(borntime, interval 300 minute)>now()");
                                                         //&& $_SERVER["REMOTE_ADDR"]!="127.0.0.1"                  
                $f=file("blockips.txt");
                foreach ($f as $k=>$v) {
                  $v=trim($v);
                  if ($v==$_SERVER["REMOTE_ADDR"] || $v==$ip || ipblocked($ip) || ipblocked($_SERVER["REMOTE_ADDR"])) {
                    $err.=" � ������ ���������� ����������� ���������.";
                    $stop=1;
                  }
                }                                          
                if (($_COOKIE["mailru"] != null || $regged) && $_SERVER["REMOTE_ADDR"]!="46.98.70.346") {
                   //$err .= "������ ���������������� ���� ��� ��� � �����! ";
                    //$stop =1;
                }elseif ($_POST['login']==null) {
                    $err .= "������� ��� ���������! ";
                    $stop =1;
                }
                elseif ($res['id']!= null || hasbad($login) || strpos($login, "�����")!==false || strpos(strtolower($login), "admin")!==false) {
                    $err .= "� ��������� �������� � ����� <B>$login</B> ��� ���������������.";
                    $stop =1;
                }
                elseif (strtoupper($_POST['login'])==strtoupper("���������") ||  strtoupper($_POST['login'])==strtoupper("��������") || strtoupper($_POST['login'])==strtoupper("�����������") || strtoupper($_POST['login'])==strtoupper("����������") || strtoupper($_POST['login'])==strtoupper("���������") || strtoupper($_POST['login'])==strtoupper("Merlin") || strtoupper($_POST['login'])==strtoupper("����������")) {
                    $err .= "����������� ��������� � ����� <B>$login</B> ���������! ";
                    $stop =1;
                }
                elseif (strlen($_POST['login'])<4 || strlen($_POST['login'])>20 || !ereg("^[a-zA-Z�-��-�0-9][a-zA-Z�-��-�0-9_ -]+[a-zA-Z�-��-�0-9]$",$_POST['login']))
//                 || preg_match("/__/",$_POST['login']) || preg_match("/--/",$_POST['login']) || preg_match("/  /",$_POST['login']) || preg_match("/(.)\\1\\1\\1/",$_POST['login']))
                    {
                    $err .= "����� ����� ��������� �� 4 �� 20 ��������, � �������� ������ �� ���� �������� ��� ����������� ��������, ����, �������� '_',  '-' � �������.";
                    // <br>����� �� ����� ���������� ��� ������������� ��������� '_', '-' ��� ��������<br>����� � ������ �� ������ �������������� ������ ����� 1 ������� '_' ��� '-' � ����� 1 �������, � ����� ����� 3-� ������ ���������� ��������.";
                    $badlogin=1;
                    $stop =1;
                }
                elseif (ereg("[a-zA-Z]",$_POST['login']) && ereg("[�-��-�]",$_POST['login'])) {
                    $err .= "����� �� ����� ��������� ������������ ����� �������� � ���������� ���������!";
                    $stop =1;
                }
                elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$",$_POST['email'])) {
                    $err .= "�������� ������ �����! ";
                    $stop =1;
                }
                elseif ($_POST['psw']==null) {
                    $err .= "������� ������! ";
                    $stop =1;
                }
                elseif ($_POST['psw']!=$_POST['psw2']) {
                    $err .= "������ �� ���������! ";
                    $stop =1;
                }
                elseif (strlen($_POST['psw'])<6 || strlen($_POST['psw'])>20 ) {
                    $err .= "������ ������ ���� �� 6 �� 20 ��������! ";
                    $stop =1;
                }
                elseif ($_POST['name']==null || strlen($_POST['name']) > 30) {
                    $err .= "�� ������� ���� �������� ���, ��� ��� ������ 30 ��������! ";
                    $stop =1;
                }
                elseif ($_POST['birth_day']<1 || $_POST['birth_day']>31) {
                    $err .= "������� ���� ��������! ";
                    $stop =1;
                }
                elseif ($_POST['birth_month']<1 || $_POST['birth_month']>12) {
                    $err .= "������� ����� ��������! ";
                    $stop =1;
                }
                elseif ($_POST['birth_year']<1940 || $_POST['birth_year']>3000) {
                    $err .= "������� ��� ��������! ";
                    $stop =1;
                }
                elseif ($_POST['sex'] != "0" && $_POST['sex'] != "1") {
                    $err .= "������� ��� ���! ";
                    $stop =1;
                }
                elseif ( ! ($_POST['ChatColor'] == "Black" || $_POST['ChatColor'] == "Blue" || $_POST['ChatColor'] == "#8700e4" || $_POST['ChatColor'] == "Fuchsia" || $_POST['ChatColor'] == "Gray" || $_POST['ChatColor'] == "Green" || $_POST['ChatColor'] == "Maroon" || $_POST['ChatColor'] == "Navy" || $_POST['ChatColor'] == "Olive" || $_POST['ChatColor'] == "Purple" || $_POST['ChatColor'] == "Teal" ||  $_POST['ChatColor'] == "Orange" ||  $_POST['ChatColor'] == "Chocolate" || $_POST['ChatColor'] == "DarkKhaki")) {
                    $err .= "�������� ������������ ������ ����� ��������� � ���� ������ ! ";
                    $stop =1;
                }
                elseif ($_POST['delivery']==null) {
                    $stop =0;
                }
                elseif ($_POST['Law']==null) {
                    $err .= "�� �� ������� ���� �������� � �������� Oldbk2.com! ";
                    $stop =1;
                }
                elseif ($_POST['Law2']==null) {
                    $err .= "�� �� ������� ���������� � �������������� ������� ���� \"oldbk2.com\" ! ";
                    $stop =1;
                }
                elseif (isset($_POST['securityCode']) && isset($_SESSION['securityCode'])) {
                    if (strtolower($_POST['securityCode']) == $_SESSION['securityCode']) {
                        unset($_SESSION['securityCode']);
                    }
else{
$stop =1;
$err .= "�������� �������� ��� ! ";
unset($_SESSION['securityCode']);
}
}
elseif (!isset($_POST['securityCode']) || !isset($_SESSION['securityCode'])) {
$stop =1;
$err .= "�� �� ����� �������� ��� ! ";
}
if($stop!=1) {
$_POST['hobby']=str_replace("&lt;BR&gt;","<BR>",$_POST['hobby']);
if ($birth_month < 10)  {$birth_month = "0".$birth_month;}
$birthday=$birth_day."-".$birth_month."-".$birth_year;
if (!empty($_SERVER['HTTP_CLIENT_IP']))
{$ip=$_SERVER['HTTP_CLIENT_IP'];}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
{$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];}
else{$ip=$_SERVER['REMOTE_ADDR'];}
if(mq("INSERT INTO `users` (`borncity`,`login`,`pass`,`email`,`realname`,`borndate`,`sex`,`city`,`icq`,`http`,`info`,`lozung`,`color`,`ip`,`money`,`showmyinfo`,`refer`,`ekr`,`exp`)VALUES('Capital city','{$_POST['login']}','".md5($_POST['psw'])."','{$_POST['email']}','{$_POST['name']}','$birthday','{$_POST['sex']}','{$_POST['city2']}','{$_POST['icq']}','{$_POST['homepage']}','{$_POST['hobby']}','{$_POST['about']}','{$_POST['ChatColor']}','$ip','500.00','1','$ref','0.00','5000');")) {
$i = mysql_insert_id();
mq("insert into userdata (id) values($i)");
if ($_SESSION["spammer"]) {
reportadms("��������������� ����� �������� ������: <b>$_POST[login]</b>");
}
$f=fopen(CHATROOT."chardata/$i.dat", "wb+");
fclose($f);
resetmax($i);
if (haslinks("$_POST[city2] $_POST[icq] $_POST[name] $_POST[hobby] $_POST[about]")) {
$f=fopen("logs/autosleep.txt","ab");
fwrite($f, "$_POST[login]: $_POST[city2] $_POST[icq] $_POST[hobby] $_POST[about]\r\n");
fclose($f);
mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('$i','�������� ��������',".(time()+3600).",2);");
reportadms("<br><b>$_POST[login]</b>: ���� � ����</font>", "�����������");
}
setcookie("mailru", "enter", time()+84000);
mq("INSERT INTO `inventory` (`owner`,`ghp`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`present`)
VALUES('".$i."','3','�������','6','1','1','roba1.gif','30','�����������') ;");
mq("INSERT INTO `inventory` (`owner`,`bron3`,`bron4`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`present`)
VALUES('".$i."','1','1','����� ����������','24','1','1','leg1.gif','30','�����������') ;");
mq("INSERT INTO `inventory` (`owner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`opisan`,`present`,`magic`,`otdel`,`isrep`)
VALUES('".$i."','����� �����','188','1','1','pot_cureHP100_20.gif','50','������ �������� ����� ����������������� 100 ������ ��������.','�����������','189','6','0') ;");

mq("INSERT INTO puton(id_person,id_thing,slot) VALUES ('".$i."','158','201');");
mq("INSERT INTO puton(id_person,id_thing,slot) VALUES ('".$i."','159','202');");
mq("INSERT INTO puton(id_person,id_thing,slot) VALUES ('".$i."','164','203');");
mq("INSERT INTO `online` (`id` ,`date` ,`room`)VALUES ('".$i."', '".time()."', '1');");

if(!empty($ref)){
$us = mysql_fetch_array(mq("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$ref}' LIMIT 1;"));
if($us[0]){
addchp ('<font color=red>��������!</font> <font color=\"Black\">�������� <B>'.$_POST['login'].'</B> ����������������� �� ����� ������. ��� ����� ����������� ������ �� ������ ��������� �� ������� ����� �������.</font>   ','{[]}'.nick7 ($ref).'{[]}');
} else {
mq("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$ref."','','".'<font color=red>��������!</font> <font color=\"Black\">�������� <B>'.$_POST['login'].'</B> ����������������� �� ����� ������. ��� ����� ����������� ������ �� ������ ��������� �� ������� ����� �������.</font> '."');");
}
echo mysql_error();
}
session_start();
setcookie("battle", $i);
$_SESSION['uid'] = $i;
mq("UPDATE `users` SET `sid` = '".session_id()."' WHERE `id` = {$i};");
$_SESSION['sid'] = session_id();
$_SESSION['bank']=NULL;
$_SESSION['ekr_online'] = time();
header("Location: battle.php");
die();
}
}
}
?>
<HTML><HEAD><TITLE>Oldbk2.com - ������ ���������� ����!</TITLE>
<META content="text/html; charset=windows-1251" http-equiv=Content-type>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<script>
	if (document.all && document.all.item && !window.opera && !document.layers) {
	} else {
		//alert("�� ������ ������������ Internet Explorer 5.0 � ����");  history.back(-1);
		//alert("������������� ������������ Internet Explorer 5.0 � ����");  //history.back(-1);
	}
</script>
</HEAD>
<BODY aLink=#000000 bgColor=#666666 leftMargin=0 link=#000000 topMargin=0
vLink=#333333 marginheight="0" marginwidth="0" 0>
<TABLE border=0 cellPadding=0 cellSpacing=0 height="100%" width="100%">
  <TBODY>
  <TR>
    <TD vAlign=top width="15%">
      <TABLE border=0 cellPadding=0 cellSpacing=0 width="100%">
        <TBODY>
        <TR>
          <TD height=36 width="100%"></TD></TR>
        <TR>
          <TD bgColor=#000000 height=83 width="100%"></TD></TR></TBODY></TABLE></TD>
    <TD vAlign=top width="70%">
      <DIV align=center><IMG border=0 height=21
      src="i/deviz.gif" width=459></DIV>
      <TABLE border=0 cellPadding=0 cellSpacing=0 width="100%">
        <TBODY>
        <TR>
          <TD height=15 width="50%"></TD>
          <TD height=15 width=269><IMG border=0 height=15
            src="i/top.gif" width=269></TD>
          <TD height=15 width="50%"></TD></TR>
        <TR>
          <TD bgColor=#000000 height=83 width="50%"></TD>
          <TD bgColor=#000000 height=83 width=269><A
            href="index.php"><IMG border=0 height=83
            src="i/logo2.jpg" width=269></A></TD>
          <TD bgColor=#000000 height=83 width="50%"></TD></TR>
        <TR>
          <TD bgColor=#f2e5b1 height=24 width="50%"></TD>
          <TD height=24 width=269><IMG border=0 height=24
            src="i/bottom.gif" width=269></TD>
          <TD bgColor=#f2e5b1 height=24 width="50%"></TD></TR></TBODY></TABLE>
      <TABLE bgColor=#f2e5b1 border=0 cellPadding=0 cellSpacing=0
        width="100%"><TBODY>
        <TR>
          <TD colSpan=3 width="100%"><BR></TD></TR>
        <TR>
          <TD colSpan=2 width="85%">&nbsp; &nbsp;&nbsp; &nbsp;<IMG border=0
            height=53 src="i/title_anketa.gif"
width=373></TD>
          <TD rowSpan=2 vAlign=top width="15%"><BR><BR>
            <DIV align=right>
            <TABLE border=0 cellPadding=0 cellSpacing=0 height="100%">
              <TBODY>
              <TR>
                </TR></TBODY></TABLE></DIV></TD></TR>
        <TR>
          <TD vAlign=top width="10%"><IMG border=0 height=243
            src="i/pict_anketa.jpg" width=126></TD>
          <TD vAlign=top width="75%"><FONT color=red><B></B></FONT>
            <BR><!-- Begin of text -->
            <TABLE border=0 cellPadding=2 cellSpacing=0 name="F1">
              <FORM action="register.php?u=<?=$_GET['u']?><?=($_GET['edit'])?"&edit=1":""?>" method=post>
              <TBODY>
              <TR>
                <TD colSpan=2><FONT color=red><B><?=$err?><!--error--></FONT></B></TD></TR>              
              <TR>
                <TD vAlign=top><FONT color=red>*</FONT></TD>
                <TD>��� ������ ��������� (login): <INPUT maxLength=60
                  name=login maxLength=20 size=20 <?=($_GET['edit'])?" disabled ":""?> value="<?=($_GET['edit'])?"{$user['login']}":"{$_POST['login']}"?>"><BR><SMALL><FONT color=<?
                  if ($badlogin) echo "#ff0000 style=\"font-weight:bold\""; else echo "#364875";
                  ?>>
                  ����� ����� ��������� �� 4 �� 20 ��������, � �������� ������ �� ���� �������� ��� ����������� ��������, ����, �������� '_',  '-' � �������. <br>����� �� ����� ���������� ��� ������������� ��������� '_', '-' ��� ��������<br>����� � ������ �� ������ �������������� ������ ����� 1 ������� '_' ��� '-' � ����� 1 �������, � ����� ����� 3-� ������ ���������� ��������
</FONT></SMALL></TD></TR><!--/email-->
              <TR>
                <TD vAlign=top><FONT color=red>*</FONT></TD>
                <TD>��� e-mail: <INPUT maxLength=50 size=50 name=email value="<?=($_GET['edit'])?"{$user['email']}":"{$_POST['email']}"?>" <?=($_GET['edit'])?" disabled ":""?>>
                  <BR><SMALL><FONT color=#364875>������������ <U>������</U> ���
                  ����������� ������, ����� �� ������������ � �� ������������
                  ��� �������� "�����������/����������/..." � �������
                  �����.</FONT></SMALL></TD></TR><!--email/--><!--/psw-->
              <TR>
                <TD vAlign=top><FONT color=red>*</FONT></TD>
                <TD>������: <INPUT maxLength=21 name=psw size=15 type=password
                <?=($_GET['edit'])?" disabled ":""?> value="<?=($_GET['edit'])?"******":""?>"> &nbsp; <FONT color=red>*</FONT> ������
                  ��������: <INPUT maxLength=21 name=psw2 size=15
                  type=password <?=($_GET['edit'])?" disabled ":""?> value="<?=($_GET['edit'])?"******":""?>"><BR>
                  <!--<SMALL><FONT color=#364875>����� �������
                  ������, �������� <A
                  href="encicl/FAQ/afer.html"
                  target=_blank>��� ������� ��</A></FONT></SMALL>--></TD></TR><!--psw/-->
              <TR>
                <TD vAlign=top><FONT color=red>*</FONT></TD>
                <TD>���� �������� ���: <INPUT maxLength=90 name=name
                size=45 value="<?=($_GET['edit'])?"{$user['realname']}":"{$_POST['name']}"?>"></TD></TR>

                 <?if (!$_GET['edit']) { ?>
              <TR>
                <TD vAlign=top><FONT color=red>*</FONT></TD>
 <TD>���� ��������:
                <SELECT NAME="birth_day" CLASS="field" STYLE="width=40;">
                <OPTION VALUE="0"> </OPTION>
                <? for($i=1;$i<=31;$i++){
                        if($i<10){$i="0".$i;}
                        echo "<OPTION ".(@$_POST["birth_day"]==$i?"selected":"")." VALUE=\"$i\">$i</OPTION>";
                    }
                ?>
                 </SELECT>
                 <SELECT NAME="birth_month" CLASS="field" STYLE="width=95;">
                    <OPTION VALUE="0"> </OPTION>
                    <OPTION VALUE="1" <? if (@$_POST["birth_month"]==1) echo "selected"; ?>>������</OPTION>
                    <OPTION VALUE="2" <? if (@$_POST["birth_month"]==2) echo "selected"; ?>>�������</OPTION>
                    <OPTION VALUE="3" <? if (@$_POST["birth_month"]==3) echo "selected"; ?>>����</OPTION>
                    <OPTION VALUE="4" <? if (@$_POST["birth_month"]==4) echo "selected"; ?>>������</OPTION>
                    <OPTION VALUE="5" <? if (@$_POST["birth_month"]==5) echo "selected"; ?>>���</OPTION>
                    <OPTION VALUE="6" <? if (@$_POST["birth_month"]==6) echo "selected"; ?>>����</OPTION>
                    <OPTION VALUE="7" <? if (@$_POST["birth_month"]==7) echo "selected"; ?>>����</OPTION>
                    <OPTION VALUE="8" <? if (@$_POST["birth_month"]==8) echo "selected"; ?>>������</OPTION>
                    <OPTION VALUE="9" <? if (@$_POST["birth_month"]==9) echo "selected"; ?>>��������</OPTION>
                    <OPTION VALUE="10" <? if (@$_POST["birth_month"]==10) echo "selected"; ?>>�������</OPTION>
                    <OPTION VALUE="11" <? if (@$_POST["birth_month"]==11) echo "selected"; ?>>������</OPTION>
                    <OPTION VALUE="12" <? if (@$_POST["birth_month"]==12) echo "selected"; ?>>�������</OPTION>
                 </SELECT>
                 <SELECT NAME="birth_year" CLASS="field" STYLE="width=60;">
                 <OPTION VALUE="0"> </OPTION>
                 <? for($i=1940;$i<=2005;$i++){
                        echo "<OPTION ".(@$_POST["birth_year"]==$i?"selected":"")." VALUE=\"$i\">$i</OPTION>";
                    }
                ?>
                </SELECT>
                <? }
$user['info']=str_replace("<BR>","\n",$user['info']);
?>
                  <SMALL><FONT
                  color=red><BR>��������!</FONT> <FONT color=#364875>���� ��������
                  ������ ���� ����������, ��� ������������ � ������� ��������.
                  ������ � ������������ ����� �������� �������� ���������� ������� ���.</FONT></SMALL></TD></TR>
              <TR>
                <TD vAlign=top><FONT color=red>*</FONT></TD>
                <TD>��� ���: <br><INPUT <? if ($_GET['edit'] && $user['sex']==1) {echo "CHECKED";} else if (!$_GET['edit']) {echo "CHECKED";} ?> id=A1 name=sex
                  style="CURSOR: hand" type=radio value=1 ><LABEL for=A1>
                  �������</LABEL><br><INPUT id=A2 name=sex style="CURSOR: hand"
                  type=radio <? if ($_GET['edit'] && $user['sex']==0) {echo "CHECKED";} ?> value=0 <?=($_GET['edit'])?" disabled ":""?>><LABEL for=A2> �������</LABEL> </TD></TR>
              <TR>
                <TD>&nbsp;</TD>
                <TD>�����: <SELECT name=city> <OPTION
                    selected><OPTION>������<OPTION>�����-���������<OPTION>������
                    (�������)<OPTION>����<OPTION>����� (����������
                    ���.)<OPTION>������<OPTION>�����������<OPTION>������<OPTION>�������<OPTION>�����<OPTION>�������
                    (���������
                    ���.)<OPTION>�������<OPTION>�������<OPTION>�����������<OPTION>������<OPTION>���������<OPTION>��������<OPTION>�������<OPTION>��������<OPTION>���������
                    (�������)<OPTION>��������� (��������
                    ���.)<OPTION>�����<OPTION>����������<OPTION>������������<OPTION>�������
                    ������<OPTION>������������<OPTION>������<OPTION>��������<OPTION>������<OPTION>������<OPTION>�������
                    ����<OPTION>������� �����<OPTION>�������
                    �����<OPTION>�����������<OPTION>�����������<OPTION>��������<OPTION>���������<OPTION>����������<OPTION>������<OPTION>�������<OPTION>������
                    (�.������
                    ���.)<OPTION>�������<OPTION>�����������<OPTION>��������<OPTION>������<OPTION>������
                    (���������� ���.)<OPTION>�������
                    ������<OPTION>��������-��<OPTION>���������<OPTION>����������<OPTION>��������
                    (����������
                    ���.)<OPTION>������<OPTION>����-�����������<OPTION>���������
                    (��������
                    ���.)<OPTION>������������<OPTION>������������<OPTION>�����<OPTION>�������
                    (���������
                    ��)<OPTION>����<OPTION>������������<OPTION>�������
                    (���������)<OPTION>���� (��������
                    ���.)<OPTION>�������<OPTION>������������<OPTION>�����
                    (���������
                    ���.)<OPTION>���������<OPTION>��������<OPTION>����������<OPTION>�����������<OPTION>����������<OPTION>������������<OPTION>��������<OPTION>�������<OPTION>����������
                    (������
                    ���.)<OPTION>������<OPTION>�������<OPTION>����<OPTION>������-���<OPTION>������<OPTION>�����������<OPTION>������<OPTION>�������-���������<OPTION>�������<OPTION>��������<OPTION>�������
                    (���������� ���.)<OPTION>������ ( �.������
                    ���.)<OPTION>�����<OPTION>������-������<OPTION>����������<OPTION>������<OPTION>�������<OPTION>�������<OPTION>�����������-��-�����<OPTION>�������<OPTION>����������<OPTION>��������<OPTION>�����������<OPTION>���������<OPTION>����������<OPTION>���������<OPTION>���������<OPTION>��������
                    (������������)<OPTION>������<OPTION>�����<OPTION>��������<OPTION>�����<OPTION>������<OPTION>���������
                    (����������
                    ���.)<OPTION>�������<OPTION>�������<OPTION>������������<OPTION>������<OPTION>�������������<OPTION>���������<OPTION>�������������<OPTION>������������
                    (������
                    ���.)<OPTION>�����������<OPTION>�����<OPTION>���������
                    (���������� ���.)<OPTION>����������� ����<OPTION>���������
                    (����������
                    ���.)<OPTION>��������<OPTION>�����<OPTION>������<OPTION>����������
                    �����<OPTION>�����<OPTION>�������<OPTION>�������<OPTION>������������<OPTION>����������<OPTION>�����������<OPTION>������������<OPTION>����������<OPTION>������
                    ��������<OPTION>������
                    �����<OPTION>����������-��-�����<OPTION>����������<OPTION>��������<OPTION>�����������<OPTION>������������<OPTION>������������<OPTION>�����������<OPTION>�����������<OPTION>������������<OPTION>�����
                    �������<OPTION>��������<OPTION>��������<OPTION>������<OPTION>�������<OPTION>��������<OPTION>����<OPTION>�����<OPTION>����<OPTION>��������<OPTION>����<OPTION>�����<OPTION>������������<OPTION>����������-���������<OPTION>�����<OPTION>������������<OPTION>�������������-����.<OPTION>�������
                    (����������
                    ����)<OPTION>��������<OPTION>���������<OPTION>��������
                    ����<OPTION>��������<OPTION>�����<OPTION>������<OPTION>���������<OPTION>��������
                    (���������
                    ���.)<OPTION>�����<OPTION>����<OPTION>������-��-����<OPTION>������-�����������<OPTION>��������<OPTION>������<OPTION>��������<OPTION>������<OPTION>�������<OPTION>�������<OPTION>�����<OPTION>������<OPTION>�����
                    (��������� ���.)<OPTION>������������<OPTION>������� (�������
                    ���.)<OPTION>������<OPTION>�������������<OPTION>�������
                    �����<OPTION>�����<OPTION>��������<OPTION>����������
                    (�.������
                    ���.)<OPTION>��������<OPTION>��������<OPTION>���������
                    ������<OPTION>��������� (���������
                    ���.)<OPTION>�������������<OPTION>��������
                    ���<OPTION>�������� ��� (�.������
                    ���.)<OPTION>����<OPTION>����������<OPTION>������
                    �����<OPTION>������ �����<OPTION>�����������
                    (������������)<OPTION>��������� (�������
                    ���.)<OPTION>��������<OPTION>������<OPTION>�������<OPTION>���������<OPTION>��������<OPTION>������<OPTION>������<OPTION>�����<OPTION>��������<OPTION>�����<OPTION>����������<OPTION>������<OPTION>������<OPTION>����<OPTION>������<OPTION>������
                    (��������
                    ���.)<OPTION>����-���<OPTION>���������<OPTION>���������<OPTION>����-�������
                    (���������
                    ����)<OPTION>���<OPTION>����<OPTION>�������<OPTION>���������<OPTION>�����-��������<OPTION>�����<OPTION>������<OPTION>���������<OPTION>���������<OPTION>���������<OPTION>���������<OPTION>��������<OPTION>������������<OPTION>��������
                    (�������� ���.)<OPTION>���������� (���������
                    ���.)<OPTION>����<OPTION>�������� (����������
                    ���.)<OPTION>������<OPTION>�����<OPTION>������� (����������
                    ���.)<OPTION>������������<OPTION>������<OPTION>�������<OPTION>����-���������<OPTION>�����������<OPTION>����<OPTION>������<OPTION>���������<OPTION>�����������<OPTION>�������<OPTION>��������<OPTION>������<OPTION>���������<OPTION>����������<OPTION>������<OPTION>�����<OPTION>�����������<OPTION>������������<OPTION>����������<OPTION>�������<OPTION>�������<OPTION>��������/Germany<OPTION>�������/Israel<OPTION>������/Canada<OPTION>���/USA</OPTION></SELECT>
                  ������ <INPUT maxLength=40 name=city2 value="<?=($_GET['edit'])?"{$user['city']}":"{$_POST['city2']}"?>"></TD></TR>
              
              <TR>
                <TD>&nbsp;</TD>
                <TD>��������� / ����� <SMALL>(�� ����� 60 ����)</SMALL><BR><TEXTAREA cols=60 name=hobby rows=7 ><?=($_GET['edit'])?"{$user['info']}":"{$_POST['nobby']}"?></TEXTAREA></TD></TR>
              <TR>
                <TD>&nbsp;</TD>
                <TD>�����: <INPUT maxLength=160 name=about size=70 value="<?=($_GET['edit'])?"{$user['lozung']}":"{$_POST['about']}"?>"></TD></TR>
              <TR>
               <TD>&nbsp;</TD>
                <TD>���� ��������� � ����: <SELECT name=ChatColor> <OPTION
                    selected style="BACKGROUND: #f2f0f0; COLOR: black"
                    value=Black>������<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: blue"
                    value=Blue>�����<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: fuchsia"
                    value=Fuchsia>�������<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: gray"
                    value=Gray>�����<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: green"
                    value=Green>�������<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: maroon"
                    value=Maroon>������������<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: navy"
                    value=Navy>����������<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: olive"
                    value=Olive>���������<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: purple"
                    value=Purple>����������<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: teal"
                    value=Teal>������� �����<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: orange"
                    value=Orange>���������<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: chocolate"
                    value=Chocolate>����������<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: darkkhaki"
                    value=DarkKhaki>������ ����<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: sandybrown"
                    value=SandyBrown>�������������<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: #8700e4"
                    value="#8700e4">���������</OPTION></SELECT>


                    <?
                    if($_GET['edit']) {
                        echo '<script>document.all[\'ChatColor\'].value = \'',$user['color'],'\';</script>';
                    }

                    ?></TD></TR>




              <TR>
                <TD vAlign=top><FONT color=red>*</FONT></TD>
                <TD><INPUT id=A3 name=Law style="CURSOR: hand"
                  type=checkbox <?=($_GET['edit'])?" disabled checked ":""?>><LABEL for=A3> � ����������� � �������� ���������</LABEL> <A
                  href="/forum.php?conf=17"
                  target=_blank><B>������ www.Oldbk2.com</B></A> </TD></TR>

<br><br><?if (!$_GET['edit']) {?>
                  <TR>
                  <TD vAlign=top><FONT color=red>*</FONT></TD>
                <TD vAlign=top><table><tr><td><img src="sec2.php" border="1"></td><td>
                  ��� �������������:</td><Td>
                <input type="text" name="securityCode" size="20" value="" maxlength=5 style="FONT-FAMILY: verdana;"></td></tr></table> 
                <?}?>
                </TD></TR>
              <TR>
               <input type="hidden" name="ref" value="<?if(!empty($ref)){echo $ref;}?>">
                <TD align=middle colSpan=2><br>
                <? if($_GET['edit']) {
                echo "<INPUT name=add type=submit value=���������>";
                } else {
                echo "<INPUT name=add type=submit value=������������������>";
                }
                ?>
            <BR><!--return--><BR>www.Oldbk2.com &copy; 2013
                <div align=left>
                    <?php include("mail_ru.php"); ?>
                </div>

            </TD></FORM></TR></TBODY></TABLE><!-- End of text --><BR><BR></TD><!--td width=15% valign=top><img src="encicl/images/new_ico.gif" width=86 height=89 border=0></td--></TR>
        <TR>
          <TD bgColor=#000000 colSpan=3 height=10
      width="100%"></TD></TR></TBODY></TABLE><BR><BR><BR></TD>
    <TD vAlign=top width="15%">
      <TABLE border=0 cellPadding=0 cellSpacing=0 width="100%">
        <TBODY>
        <TR>
          <TD height=36 width="100%"></TD></TR>
        <TR>
          <TD bgColor=#000000 height=83
  width="100%"></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></BODY></HTML>
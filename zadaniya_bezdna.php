<?php
session_start();
if ($_SESSION['uid'] == null) header("Location: index.php");
include "connect.php";
include "functions.php";
if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }
?>
<HTML>
<HEAD>
<link rel=stylesheet type="text/css" href="<?=IMGBASE?>/i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<script LANGUAGE='JavaScript'>
document.ondragstart = test;
document.oncontextmenu = test;
function test() {
 return false
}
</SCRIPT>
</HEAD>
<body bgcolor=e2e0e0 style="background-image: url(<?=IMGBASE?>/i/misc/showitems/dungeon.jpg);background-repeat:no-repeat;background-position:top right">
<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; z-index: 100; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px;"></div>

<TABLE width=100%>
<TR><TD valign=top width=100%><H3></H3>
<?
if($_GET['getquest']){
  include_once "questfuncs.php";
  if (canmakequest(20)) { 
    $random = rand(1,10);
    $ests=mqfa("select * from `podzem_zad_bezdna` order by rand()");
    if($ests){
      mysql_query('insert into `podzem_zad_bezdnalog` (owner,ubit,ed,text,bot)values("'.$user['id'].'","'.$ests['ubit'].'","'.$ests['ed'].'","'.$ests["zadanie"].'","'.$ests["bot"].'")');
      $zadantime=time()+86400;
      mysql_query("UPDATE `users` SET `zadantime` = '$zadantime' WHERE `id` = '{$user['id']}'");
      print"<b style='color:red'>�� �������� �������.</b><br><br>";
      makequest(20);
    }
  } else echo "<b>������ ��� ��� ��� �������. ��������� ����� ".secs2hrs($questtime)."</b>";
}
if($_GET['del']){
mysql_query("DELETE FROM `podzem_zad_bezdnalog` WHERE id='".mysql_real_escape_string($_GET['del'])."' AND owner='".mysql_real_escape_string($user['id'])."'");
print"<b style='color:red'>�� ������� ���� �������.</b>";
}
if($_GET['warning']==1){print"<br><b style='color:red'>�� ����� ������� � �������� ".mysql_real_escape_string($_GET['ed'])." �����.</b>";}
$rt=mysql_query("select * from `podzem_zad_bezdnalog` where owner='".$user['id']."'");
if(!$est=mysql_fetch_array($rt)){
?>
<FORM action='zadaniya_bezdna.php?zadanie=1' method=GET name=F1>
<INPUT type=hidden name=ql value=1>
<INPUT type=hidden name=quest_name value=''>
&bull; <i>��� �������</i><BR>
 <?

print"<BR><INPUT type=submit name='getquest' value='�������� �������'>";
?></FORM>
<?
}else{

?>
<form action="" method="post">
<IMG style='cursor: hand' src='<?=IMGBASE?>/i/clear.gif' width=13 height=13 alt='���������� �� �������' onclick='if (confirm("�� �������, ��� ������ ���������� �� ����� �������?")) {location="zadaniya_bezdna.php?del=<?=$est['id']?>"}'> <?=$est['text']?> <span onmouseout='hideshow();' onmouseover='fastshow("0.00/1")'><?=$est['ubil']?>/<?=$est['ubit']?></span>.<br>�������: <?=$est["ed"]?> �����.
<?
if($est['ubil']>=$est['ubit']){print'<input name="ok" type="submit" value="��������">';}
if($_POST['ok'] and $est['ubil']>=$est['ubit']){
mysql_query("DELETE FROM `podzem_zad_bezdnalog` WHERE id='".$est['id']."' AND owner='".$user['id']."'");
mysql_query("UPDATE `users` SET honorpoints=honorpoints+".$est['ed']." WHERE id='".$user['id']."'");
print "<script>location.href='?warning=1&ed=".$est['ed']."'</script>";
exit;}
?>
</form>
<BR><BR>
<?
}
?>
 <?
if($_GET['buy']=='stats' and $user['ed']>='3000'){
mysql_query("UPDATE `users` SET `stats`=`stats`+3,`ed`=`ed`-3000 WHERE `id`='".mysql_real_escape_string($_SESSION['uid'])."'");
print"<b style='color=red'>�� ��������� +3 �����.</b>";
}
if($_GET['buy']=='master' and $user['ed']>='5000'){
mysql_query("UPDATE `users` SET `master`=`master`+3,`ed`=`ed`-5000 WHERE `id`='".mysql_real_escape_string($_SESSION['uid'])."'");
print"<b style='color=red'>�� ��������� +3 ������.</b>";
}
if($_GET['buy']=='kr' and $user['ed']>='100'){
mysql_query("UPDATE `users` SET `money`=`money`+10,`ed`=`ed`-100 WHERE `id`='".mysql_real_escape_string($_SESSION['uid'])."'");
print"<b style='color=red'>�� ��������� +10 ��.</b>";
}
if($_GET['buy']=='exp' and $user['ed']>='3000'){
mysql_query("UPDATE `users` SET `exp`=`exp`+3000,`ed`=`ed`-3000 WHERE `id`='".mysql_real_escape_string($_SESSION['uid'])."'");
print"<b style='color=red'>�� ��������� +3000 �����.</b>";
}
 ?>
<BR>
<FIELDSET style='padding: 5,5,5,5'><LEGEND> ����: <B><?=$user['honorpoints']?>.</B> </LEGEND>
<!--<TABLE>
 
<TR><TD>����� (��� 3)</TD><TD style='padding-left: 10'>�� 3000 ��.</TD><TD style='padding-left: 10'>
<? if($user['ed']>='3000'){?>
<INPUT type='button' value='������' onClick="if (confirm('������: �����?\n\n����� �����, �� ������� ��������� �������������� ���������.\n��������, ����� ��������� ����.')) {location='zadaniya_bezdna.php?buy=stats'}">
<? }else{ ?>
<INPUT type='button' disabled value='������' onClick="if (confirm('������: �����������?\n\n����� �����, �� ������� ��������� �������������� ���������.\n��������, ����� ��������� ����.')) {location=''}">
<? }?>
</TD></TR>
 
<TR><TD>������ (��� 3)</TD><TD style='padding-left: 10'>�� 5000 ��.</TD><TD style='padding-left: 10'>
<? if($user['ed']>='5000'){?>
<INPUT type='button' value='������' onClick="if (confirm('������: ������?\n\n������ ��� ����������� ������������ ���� �������� ����, ������, ����� � �.�.')) {location='zadaniya_bezdna.php?buy=master'}">
<? }else{ ?>
<INPUT type='button' disabled value='������' onClick="if (confirm('������: ������?\n\n������ ��� ����������� ������������ ���� �������� ����, ������, ����� � �.�.')) {location=''}">
<? }?>
</TD></TR>
 
<TR><TD>������ (10 ��.)</TD><TD style='padding-left: 10'>�� 100 ��.</TD><TD style='padding-left: 10'>
<? if($user['ed']>='100'){?>
<INPUT type='button' value='������' onClick="if (confirm('������: ������ (10 ��.)?\n\n������� ����� �������� ������������ ���������.')) {location='zadaniya_bezdna.php?buy=kr'}">
<? }else{ ?>
<INPUT type='button' disabled value='������' onClick="if (confirm('������: ������ (10 ��.)?\n\n������� ����� �������� ������������ ���������.')) {location=''}">
<? }?>
</TD></TR>
 
<TR><TD>���� (1000)</TD><TD style='padding-left: 10'>�� 3000 ��.</TD><TD style='padding-left: 10'>
<? if($user['ed']>='3000'){?>
<INPUT type='button' value='������'onclick="if (confirm('������: ����?\n\n����������� - ��� �������������� ���� ��� ���������.')) {location='zadaniya_bezdna.php?buy=opit'}">
<? }else{ ?>
<INPUT type='button' disabled value='������'onclick="if (confirm('������: ����?\n\n����������� - ��� �������������� ���� ��� ���������.')) {location=''}">
<? }?>
</TD></TR>
</TABLE>-->
</FIELDSET>
<BR>
<!--���������: <?=$user['reput']?><BR>-->
<TD nowrap valign=top><BR><DIV align=right><INPUT type='button' onclick='location="zadaniya.php"' value=��������> <INPUT type='button' onclick='location="vxod.php"' value="���������"></DIV></TD>
</TR>
</TABLE>

</BODY>
</HTML>


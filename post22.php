<?php
	session_start();
	if ($_SESSION['uid'] == null) header("Location: index.php");
	include "connect.php";
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
	include "functions.php";
	if ($user['room'] != 27) { header("Location: main.php");  die(); }
	if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }

$title = array("�������� ���������", "������� � ��������");

//��������� �����
if($_REQUEST['room'] == '' and $_REQUEST['setobject'] == '' and $_REQUEST['razdel'] == '' and $_REQUEST['setkredit'] == '')
{?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="/i/main2.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Expires Content=0>
<SCRIPT src='/i/commoninf.js'></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="/i/sl2.24.js"></SCRIPT>
<STYLE>
.pH3			{ COLOR: #8f0000;  FONT-FAMILY: Arial;  FONT-SIZE: 12pt;  FONT-WEIGHT: bold; }
</STYLE>
<SCRIPT>
var sd4 = "100025030";
function fastshow(dsc, dx, dy) { top.fullfastshow(document, mmoves, window.event, dsc, dx, dy); }
function hideshow() { top.fullhideshow(mmoves); }
</SCRIPT>
</HEAD>
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=e2e0e0>
<div id=hint4 class=ahint></div>
<TABLE width=100%><TD valign=top height=100%>
<TABLE width=100% cellspacing=0 cellpadding=4 bgcolor=d2d2d2>
<FORM METHOD=POST name=F1>
<INPUT type=hidden name="room" value="1">
<INPUT type=hidden name="sd4" value="100025030">
<tr><td class='pH3'>&nbsp;&nbsp;&nbsp;&nbsp;�������� ���������
</FONT></td><td align=right valign=top><?=nick3($_SESSION['uid'])?> &nbsp;</td></tr></table>
<BR><BR>
&bull; <B>�������� �������</B><BR>
�� ������ ��������� ������� ������ ���������, ���� ���� �� ��������� � ������ ������. ���� � ����� �������� ������� �� ����������.<BR>
<BR>
&bull; <B>������� � ��������</B><BR>
�� ������ ��������� �������� ��������� ������ ���������, ���� ���� �� ��������� � offline ��� ������ ������.<BR>
�� ������ ��������� ��������� ����� ����� ���������.<BR>
<BR>
&bull; <B>�������� ����</B><BR>
�� ������ �������� ����, ������� ���� ���������� ��� ������� ��������.<BR>
������� �������� �� ����� 7 ����, �� �� ����� ������ ��� � ������� ��� �� ������� �� � ������ ����� ��� ���������.
�� ��������� ����� �����, ������� ������������ ������� ��� ���������.
<BR>
<small><BR>������������� ����� ��������, ��� �� ����� ��������������� �� �������� ��� ������������ �����/�������/��������� � �� ����������� 100% ��� ��������. � ������ ����-�������� �������������, �����/�������/��������� ����� ���� �������.</small>
</TD><TD valign=top width=200><TABLE cellpadding=0 cellspacing=0 width=100%><TR><TD width=100%><SPAN></SPAN><TD><HTML>
<link href="/i/move/design6.css" rel="stylesheet" type="text/css"><script language="javascript" type="text/javascript">
function fastshow2 (content, eEvent ) {
var el = document.getElementById("mmoves");
eEvent = eEvent || window.event;
if( !eEvent )
return;
var o = eEvent.target || eEvent.srcElement;
if (content!='' && el.style.visibility != "visible") {el.innerHTML = '<small>'+content+'</small>';}
var x = window.event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft - el.offsetWidth + 5;
var y = window.event.clientY + document.documentElement.scrollTop + document.body.scrollTop+20;
if (x + el.offsetWidth + 3 > document.body.clientWidth + document.body.scrollLeft) { x=(document.body.clientWidth + document.body.scrollLeft - el.offsetWidth - 5); if (x < 0) {x=0}; }
if (y + el.offsetHeight + 3 > document.body.clientHeight  + document.body.scrollTop) { y=(document.body.clientHeight + document.body.scrollTop - el.offsetHeight - 3); if (y < 0) {y=0}; }
if (x<0) {x=0;}
if (y<0) {y=0;}
el.style.left = x + "px";
el.style.top  = y + "px";
if (el.style.visibility != "visible") {
el.style.visibility = "visible";
}
}
function hideshow () {
document.getElementById("mmoves").style.visibility = 'hidden';
}
</script>
<table  border="0" cellpadding="0" cellspacing="0">
<tr align="right" valign="top">
<td>


</td>
<td>

<TABLE height=15 border="0" cellspacing="0" cellpadding="0">
<TR>
<TD rowspan=3 valign="bottom"><a href="?rnd=0.313154328583547"><img src="http://img.combats.com/i/move/rel_1.gif" width="15" height="16" alt="��������" border="0" /></a></TD>
<TD colspan="3"><img src="http://img.combats.com/i/move/navigatin_462.gif" width="80" height="4" /></TD>
</TR>
<TR>
<TD><IMG src="http://img.combats.com/i/move/navigatin_481.gif" width="9" height="8"></TD>
<TD width=64 bgcolor=black><DIV class="MoveLine"><IMG src="http://img.combats.com/i/move/wait2.gif" id="MoveLine" class="MoveLine"></DIV></TD>
<TD><IMG src="http://img.combats.com/i/move/navigatin_50.gif" width="7" height="8"></TD>
</TR>
<TR>
<TD colspan="3"><IMG src="http://img.combats.com/i/move/navigatin_tt1_532.gif" width="80" height="5"></TD>
</TR>
</TABLE>


<table  border="0" cellspacing="0" cellpadding="0">
<tr>
<td nowrap="nowrap" id="moveto">
<table width="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#DEDEDE">

<tr>
<td bgcolor="#D3D3D3"><img src="http://img.combats.com/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><a href="city.php?cp=3&rnd=0.426783563714359" onclick="return check_access();" class="menutop" title="����� ��������: 15 ���.
������ � ������� ".$loc['count']." ���.">����������� �������</a></td>
</tr>

	<!--<tr>
<td bgcolor="#D3D3D3"><img src="http://img.combats.com/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><a href="?rnd=0.412412448766478&path=1.100.106.1" onclick="return check_access();" class="menutop" title="����� ��������: 3 ���.
������ � ������� 0 ���.">������ ��������</a></td>
</tr>-->
</table>
</td>
</tr>
</table>
<!-- <br /><span class="menutop"><nobr>�������� ���������</nobr></span>-->
</td>
</tr>
</table>
<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px; white-space: nowrap;"></div>
<script language="javascript" type="text/javascript">
var progressEnd = 64;		// set to number of progress <span>'s.
var progressColor = '#00CC00';	// set to progress bar color
var mtime = parseInt('6');
if (!mtime || mtime<=0) {mtime=0;}
var progressInterval = Math.round(mtime*1000/progressEnd);	// set to time between updates (milli-seconds)
var is_accessible = true;
var progressAt = progressEnd;
var progressTimer;
function progress_clear() {
progressAt = 1;
is_accessible = false;
set_moveto(true);
}
function progress_update() {
progressAt++;
//if (progressAt > progressEnd) progress_clear();
if (progressAt > progressEnd) {
is_accessible = true;
if (window.solo_store && solo_store) { solo(solo_store, "\"); } // go to stored
set_moveto(false);
} else {
if( !( progressAt % 2 ) )
document.getElementById('MoveLine').style.left = progressAt - 64;
progressTimer = setTimeout('progress_update()',progressInterval);
}
}
function set_moveto (val) {
document.getElementById('moveto').disabled = val;
if (document.getElementById('bmoveto')) {
document.getElementById('bmoveto').disabled = val;
}
}
function progress_stop() {
clearTimeout(progressTimer);
progress_clear();
}
function check(it) {
return is_accessible;
}
function check_access () {
return is_accessible;
}
function ch_counter_color (color) {
/*	progressColor = color;
for (var i = 1; i <= progressAt; i++) {
document.getElementById('progress'+i).style.backgroundColor = progressColor;
}*/
}
if (mtime>0) {
progress_clear();
progress_update();
}
</script>
</HTML>
</TD></TR>
<TR><TD colspan=2>
<NOBR>
������: <?=$user['money']?> ��.<BR><br>
<A href="?room=2&setlogin=&0.82142741688088">�������� ��������</A><BR>
<A href="?room=3&setlogin=&0.44089167010311">������� � ��������</A><BR>
<FONT color=gray>�������� ����</FONT><BR>
<BR>
<FONT color=gray>������</FONT><BR>
</NOBR></TR></TD></TABLE>
</TD>
</TABLE>
</FORM>
	<? include("mail_ru.php");?>
</BODY>
</HTML>
<?}

//������� �� ���� �����, ��� �����
if ($_REQUEST['setlogin']) {
	$res=mysql_fetch_array(mysql_query("SELECT `id`, `level`, `room`, `align`, (select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = users.`id`) as `online`,`login` FROM `users` WHERE `login` ='".mysql_escape_string($_REQUEST['setlogin'])."';"));
	$step=3;
}
//������� ����� ��� ��������
if ($_REQUEST['to_id']) {
	$res=mysql_fetch_array(mysql_query("SELECT `id`, `level`, `room`, `align`, (select `id` from `online` WHERE `online`.`date` >= ".(time()-60)." AND `online`.`id` = users.`id`),`login` as `online` FROM `users` WHERE `id` ='".mysql_escape_string($_REQUEST['to_id'])."';"));
	$step=3;
}
//����� ����� ��� ������...
if ($step==3){
	$id_person_x=$res['id'];
	if (!$id_person_x) {$mess='�������� �� ������'; $step=2;}
	elseif ($id_person_x==$user['id']) {$mess='������� ���������� ������ ����'; $step=2;}
	elseif ($res['align']==4) {$mess='�� ����������� ���� �������� ��������� ���������'; $step=2;}
	elseif ($user['align']==4) {$mess='�� ����������� ���� �������� ��������� ���������'; $step=2;}
	//elseif ($res['online']<1) $mess='�������� �� ������';
	//elseif ($res['room']!=$user['room']) $mess='�� ������ ���������� � ����� ������� � ��� ���� ������ �������� ����';
	elseif ($res['level']<1) {$mess='� ���������� �� 1-�� ������ �������� ��������� ���������'; $step=2;}
	elseif ($user['level']<4) {$mess='���������� �� 4-�� ������ �������� ��������� ���������'; $step=2;}
	elseif ($user['in_tower']>0) {$mess='�������� ��������� � ����� ������'; $step=2;}
	else{
		$idkomu=$id_person_x;
		$komu=mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` ='".$idkomu."';"));
		if($_REQUEST['room'] == 2)
			$step=4;
		else
			$step=5;
	}
}
//���� ������
if (!empty($_REQUEST['room']) and $_POST['setlogin'] == '' and $_REQUEST['razdel'] == '' and $_REQUEST['setobject'] == '' and $_REQUEST['setkredit'] == '' and $_REQUEST['message'] == '' and $_REQUEST['letter'] == '' or $step==2)
{

	if($_REQUEST['room'] == 2)
		$title = $title[0];
	else
		$title = $title[1];
	if(!empty($_REQUEST['room']))
		$room = $_REQUEST['room'];
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="/i/main2.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Expires Content=0>
<SCRIPT src='/i/commoninf.js'></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="/i/sl2.24.js"></SCRIPT>
<!--�������� ���� ������� ����������� ����� ����� ����-->
<STYLE>
.pH3			{ COLOR: #8f0000;  FONT-FAMILY: Arial;  FONT-SIZE: 12pt;  FONT-WEIGHT: bold; }
</STYLE>
<SCRIPT>
var sd4 = "830919346";
function fastshow(dsc, dx, dy) { top.fullfastshow(document, mmoves, window.event, dsc, dx, dy); }
function hideshow() { top.fullhideshow(mmoves); }
</SCRIPT>
</HEAD>
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=e2e0e0>
<div id=hint4 class=ahint></div>
<TABLE width=100%><TD valign=top height=100%>
<TABLE width=100% cellspacing=0 cellpadding=4 bgcolor=d2d2d2>
<FORM METHOD=POST name=F1>
<INPUT type=hidden name="room" value="".$room."">
<INPUT type=hidden name="sd4" value="830919346">
<tr><td class='pH3'>&nbsp;&nbsp;&nbsp;&nbsp;�������� ���������
. &nbsp; <?=$title?>
</FONT></td><td align=right valign=top><?=nick3($_SESSION['uid'])?> &nbsp;</td></tr></table>
<SCRIPT>findlogin('".$title."','post.php','setlogin', '', '', '<INPUT type=hidden name=room value=".$room.">')</SCRIPT>
<?
	if($_REQUEST['setlogin'] == '' and $_GET['room'] == '')
		echo '<font color=red><B>�� �� ����� �����</b></font>';
	else
		echo '<font color=red><b>'.$mess.'</b></font>';
	$mess = '';
?>
</TD><TD valign=top width=200><TABLE cellpadding=0 cellspacing=0 width=100%><TR><TD width=100%><SPAN></SPAN><TD><HTML>

<link href="/i/move/design6.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript">
function fastshow2 (content, eEvent ) {
var el = document.getElementById("mmoves");
eEvent = eEvent || window.event;
if( !eEvent )
return;
var o = eEvent.target || eEvent.srcElement;
if (content!='' && el.style.visibility != "visible") {el.innerHTML = '<small>'+content+'</small>';}
var x = window.event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft - el.offsetWidth + 5;
var y = window.event.clientY + document.documentElement.scrollTop + document.body.scrollTop+20;
if (x + el.offsetWidth + 3 > document.body.clientWidth + document.body.scrollLeft) { x=(document.body.clientWidth + document.body.scrollLeft - el.offsetWidth - 5); if (x < 0) {x=0}; }
if (y + el.offsetHeight + 3 > document.body.clientHeight  + document.body.scrollTop) { y=(document.body.clientHeight + document.body.scrollTop - el.offsetHeight - 3); if (y < 0) {y=0}; }
if (x<0) {x=0;}
if (y<0) {y=0;}
el.style.left = x + "px";
el.style.top  = y + "px";
if (el.style.visibility != "visible") {
el.style.visibility = "visible";
}
}
function hideshow () {
document.getElementById("mmoves").style.visibility = 'hidden';
}
</script>
<table  border="0" cellpadding="0" cellspacing="0">
<tr align="right" valign="top">
<td>


</td>
<td>

<TABLE height=15 border="0" cellspacing="0" cellpadding="0">
<TR>
<TD rowspan=3 valign="bottom"><a href="?rnd=0.975075419010967"><img src="http://img.combats.com/i/move/rel_1.gif" width="15" height="16" alt="��������" border="0" /></a></TD>
<TD colspan="3"><img src="http://img.combats.com/i/move/navigatin_462.gif" width="80" height="4" /></TD>
</TR>
<TR>
<TD><IMG src="http://img.combats.com/i/move/navigatin_481.gif" width="9" height="8"></TD>
<TD width=64 bgcolor=black><DIV class="MoveLine"><IMG src="http://img.combats.com/i/move/wait2.gif" id="MoveLine" class="MoveLine"></DIV></TD>
<TD><IMG src="http://img.combats.com/i/move/navigatin_50.gif" width="7" height="8"></TD>
</TR>
<TR>
<TD colspan="3"><IMG src="http://img.combats.com/i/move/navigatin_tt1_532.gif" width="80" height="5"></TD>
</TR>
</TABLE>


<table  border="0" cellspacing="0" cellpadding="0">
<tr>
<td nowrap="nowrap" id="moveto">
<table width="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#DEDEDE">

<tr>
<td bgcolor="#D3D3D3"><img src="http://img.combats.com/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><a href="city.php?cp=3" onclick="return check_access();" class="menutop" title="����� ��������: 15 ���.
������ � ������� ".$loc['userINloc']."">����������� �������</a></td>
</tr>

<!--<tr>
<td bgcolor="#D3D3D3"><img src="http://img.combats.com/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><a href="?rnd=0.781869150354051&path=1.100.106.1" onclick="return check_access();" class="menutop" title="����� ��������: 3 ���.
</tr>-->
</table>
</td>
</tr>
</table>
<!-- <br /><span class="menutop"><nobr>�������� ���������</nobr></span>-->
</td>
</tr>
</table>
<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px; white-space: nowrap;"></div>
<script language="javascript" type="text/javascript">
var progressEnd = 64;		// set to number of progress <span>'s.
var progressColor = '#00CC00';	// set to progress bar color
var mtime = parseInt('13');
if (!mtime || mtime<=0) {mtime=0;}
var progressInterval = Math.round(mtime*1000/progressEnd);	// set to time between updates (milli-seconds)
var is_accessible = true;
var progressAt = progressEnd;
var progressTimer;
function progress_clear() {
progressAt = 1;
is_accessible = false;
set_moveto(true);
}
function progress_update() {
progressAt++;
//if (progressAt > progressEnd) progress_clear();
if (progressAt > progressEnd) {
is_accessible = true;
if (window.solo_store && solo_store) { solo(solo_store, "\"); } // go to stored
set_moveto(false);
} else {
if( !( progressAt % 2 ) )
document.getElementById('MoveLine').style.left = progressAt - 64;
progressTimer = setTimeout('progress_update()',progressInterval);
}
}
function set_moveto (val) {
document.getElementById('moveto').disabled = val;
if (document.getElementById('bmoveto')) {
document.getElementById('bmoveto').disabled = val;
}
}
function progress_stop() {
clearTimeout(progressTimer);
progress_clear();
}
function check(it) {
return is_accessible;
}
function check_access () {
return is_accessible;
}
function ch_counter_color (color) {
/*	progressColor = color;
for (var i = 1; i <= progressAt; i++) {
document.getElementById('progress'+i).style.backgroundColor = progressColor;
}*/
}
if (mtime>0) {
progress_clear();
progress_update();
}
</script>
</HTML>
</TD></TR>
<TR><TD colspan=2>
<NOBR>
������: <?=$user['money']?> ��.<BR><br><br>
<?	if($_REQUEST['room']==2){?>
	<B>�������� ��������</B><BR>
	<A href="?room=3&setlogin=">������� � ��������</A><BR>
	<FONT color=gray>�������� ����</FONT><BR>
	<BR>
	<FONT color=gray>������</FONT><BR>
<?	}
	else
	{?>
	<A href="?room=2&setlogin=">�������� ��������</A><BR>
	<B>������� � ��������</B><BR>
	<FONT color=gray>�������� ����</FONT><BR>
	<BR>
	<FONT color=gray>������</FONT><BR>
<?}?>
</NOBR></TR></TD></TABLE>
</TD>
</TABLE>
</FORM>

</BODY>
</HTML>
<?}


//����� �����, �������� �������
if ($step==4)
{
	if ((is_numeric($_REQUEST['setobject']) && $_REQUEST['setobject']>0) && (is_numeric($_REQUEST['to_id']) && $_REQUEST['to_id']>0) && !$_REQUEST['gift'] && $_REQUEST['sd4']==$user['id']) {
		$res = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `id` = '{$_REQUEST['setobject']}' AND `dressed` = 0 AND `setsale` = 0 AND `present` = '' AND `destinyinv` = '' LIMIT 1;"));
		if (!$res['id']) {$mess="������� �� ������ � �������";}
		elseif ($user['money']<1) {$mess='������������ ����� �� ������ ��������';}
		else {
			if (mysql_query("update `inventory` set `owner` = ".$komu['id']." where `id`='".$res['id']."' and `owner`= '".$user['id']."';")) {
				mysql_query("update `users` set `money`=`money`-1 where `id`='".$user['id']."'");
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".$_SESSION['uid']."','������ ������� ������� ".$res['name']." id:(cap".$res['id'].") [".$res['duration']."/".$res['maxdur']."] �� ".$user['login']." � ".$komu['login'].", ����� 1 ��.','1','".time()."');");
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".$idkomu."','������ ������� ������� ".$res['name']." id:(cap".$res['id'].") [".$res['duration']."/".$res['maxdur']."] �� ".$user['login']." � ".$komu['login'].", ����� 1 ��.','1','".time()."');");
				$mess='������ �������� "'.$res['name'].'" � ��������� '.$komu['login'];
				$user['money']-=1;
				$us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '".$komu['id']."' LIMIT 1;"));
				if($us[0]){
					addchp ('<font color=red>��������!</font> ��� ������ ������� ������� <b>'.$res['name'].'</b> �� <span oncontextmenu=OpenMenu()>'.$user['login'].'</span>   ','{[]}'.$komu['login'].'{[]}');
				} else {
					// ���� � ���
					mysql_query("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$komu['id']."','','".'<font color=red>��������!</font> ��� ������ ������� ������� <b>'.$res['name'].'</b> �� <span oncontextmenu=OpenMenu()>'.$user['login'].'</span>  '."');");
				}
			}
		}
	}
	$step=4;
}

//�������� �������� � ���������
if($step==5)
{
	//��������� ����������
	if ($_REQUEST['sendMessage'] && $_REQUEST['to_id'] && $_REQUEST['sd4']==$user['id'] && $user['money'] >= 0.1) {
		$_REQUEST['message']=htmlentities($_POST['title'],ENT_NOQUOTES);
		mysql_query("UPDATE `users` set money=money-'0.05' where id='".$user['id']."'");
		//mysql_query("INSERT INTO `inventory` (`owner`,`name`,`type`,`massa`,`cost`,`img`,`letter`,`maxdur`,`isrep`)VALUES('".$idkomu."','��������� ����������','200',1,0,'paper100.gif','�� ��������� "".$user['login']."": ".$_POST['message']."',1,0) ;");
		telegraph($komu['login'],$_POST['message']);
		//$mess='��������� ��������� "'.$komu['login'].'" ����� ����������.';
	}
	//��������� ������
	if ($_REQUEST['sendletter'] && $_REQUEST['to_id'] && $_REQUEST['sd4']==$user['id'] && $user['money'] >= 0.1) {
		$_REQUEST['letter']=htmlentities($_POST['title'],ENT_NOQUOTES);
		mysql_query("UPDATE `users` set money=money-'1' where id='".$user['id']."'");
		mysql_query("INSERT INTO `inventory` (`owner`,`name`,`type`,`massa`,`cost`,`img`,`letter`,`maxdur`,`isrep`)VALUES('".$idkomu."','��������� �� �����','200',1,0,'paper100.gif','�� ��������� ".$user['login'].": ".$_POST['letter']."',1,0) ;");
		tele_check($komu['login'],$_POST['letter']);
		$mess='��������� ��������� "'.$komu['login'].'" ����� ����������.';
	}
	//�������� ��
	if ($_REQUEST['setkredit']>=0.01) {
		$_REQUEST['setkredit'] = round($_REQUEST['setkredit'],2);
		if (is_numeric($_REQUEST['setkredit']) && ($_REQUEST['setkredit']>0) && ($_REQUEST['setkredit'] <= $user['money'])) {
			if (mysql_query("UPDATE `users` set money=money-".strval($_REQUEST['setkredit'])." where id='".$user['id']."'") && mysql_query("UPDATE `users` set money=money+".strval($_REQUEST['setkredit'])." where id='".$idkomu."'")) {
				$mess='������ �������� '.strval($_REQUEST['setkredit']).' �� � ��������� '.$komu['login'];
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".$_SESSION['uid']."','������ �������� ".strval($_REQUEST['setkredit'])." ��. �� ".$user['login']." � ".$komu['login']." ',1,'".time()."');");
				mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".$idkomu."','������ �������� ".strval($_REQUEST['setkredit'])." ��. �� ".$user['login']." � ".$komu['login']." ',1,'".time()."');");
				$user['money']-=$_REQUEST['setkredit'];
				$us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '".$idkomu."' LIMIT 1;"));
				if($us[0] != ''){
					addchp ('<font color=red>��������!</font> ��� ������ �������� ������� '.strval($_REQUEST['setkredit']).' ��. �� <span oncontextmenu=OpenMenu()>'.$user['login'].'</span>   ','{[]}'.$komu['login'].'{[]}');
				} else {
					// ���� � ���
					mysql_query("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$komu['id']."','','".'<font color=red>��������!</font> ��� ������ �������� ������� '.strval($_REQUEST['setkredit']).' ��. �� <span oncontextmenu=OpenMenu()>'.$user['login'].'</span>  '."');");
				}
			}
			else {
				$mess="��������� ������";
			}
		}
		else {
			$mess="������������ �����";
		}
	}
	$step=5;
}

//������� �� ��������
if($_REQUEST['razdel'] != '')
	$step = 4;

//����������� ��������� � ���������
if($step==4)
{?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="/i/main2.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<SCRIPT src='/i/commoninf.js'></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="/i/sl2.24.js"></SCRIPT>
<STYLE>
.pH3			{ COLOR: #8f0000;  FONT-FAMILY: Arial;  FONT-SIZE: 12pt;  FONT-WEIGHT: bold; }
</STYLE>
<SCRIPT>
var sd4 = "564587655";
function fastshow(dsc, dx, dy) { top.fullfastshow(document, mmoves, window.event, dsc, dx, dy); }
function hideshow() { top.fullhideshow(mmoves); }
</SCRIPT>
</HEAD>
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=e2e0e0>
<div id=hint4 class=ahint></div>
<TABLE width=100%><TD valign=top height=100%>
<TABLE width=100% cellspacing=0 cellpadding=4 bgcolor=d2d2d2>
<FORM METHOD=POST name=F1>
<INPUT type=hidden name="set_login" value="".$res['login']."">
<INPUT type=hidden name="room" value="2">
<INPUT type=hidden name="sd4" value="564587655">
<tr><td class='pH3'>&nbsp;&nbsp;&nbsp;&nbsp;�������� ���������
. &nbsp; �������� ��������
</FONT></td><td align=right valign=top><?=nick3($_SESSION['uid'])?> &nbsp;</td></tr></table>


� ���� ����������: <font color=red><?=nick3($idkomu['id'])?></font> &nbsp;&nbsp;
<INPUT TYPE=button value="�������" onclick="findlogin('�������� ������','post.php','setlogin', '', '', '<INPUT type=hidden name=room value=2>'); return false;"><BR>
��������� � Mountain Town<BR>
��������� ����� ��������: 30 ���.<br>
<font color=red><b><?=$mess?></b></font>
<TABLE width=100% cellspacing=0 cellpadding=0 bgcolor=A5A5A5>
<TR><TD>
<TABLE width=100% cellspacing=0 cellpadding=3 bgcolor=d4d2d2><TR>
	//������� �� ����� ������ �������
<?	if($_GET['razdel']==0)
	{?>
	<TD bgcolor=A5A5A5 align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=0">��������������</A></TD>
	<TD align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=1">��������</A></TD>
	<TD align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=2">��������</A></TD>
	<TD align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=4">����</A></TD>
	<TD align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=3">������</A></TD>
<?	}
	if($_GET['razdel']==1)
	{?>
	<TD align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=0">��������������</A></TD>
	<TD bgcolor=A5A5A5 align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=1">��������</A></TD>
	<TD align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=2">��������</A></TD>
	<TD align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=4">����</A></TD>
	<TD align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=3">������</A></TD>
<?	}
	if($_GET['razdel']==2)
	{?>
	<TD align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=0">��������������</A></TD>
	<TD align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=1">��������</A></TD>
	<TD bgcolor=A5A5A5 align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=2">��������</A></TD>
	<TD align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=4">����</A></TD>
	<TD align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=3">������</A></TD>
<?	}
	if($_GET['razdel']==3)
	{?>
	<TD align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=0">��������������</A></TD>
	<TD align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=1">��������</A></TD>
	<TD align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=2">��������</A></TD>
	<TD align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=4">����</A></TD>
	<TD bgcolor=A5A5A5 align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=3">������</A></TD>
<?	}
	if($_GET['razdel']==4)
	{?>
	<TD align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=0">��������������</A></TD>
	<TD align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=1">��������</A></TD>
	<TD align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=2">��������</A></TD>
	<TD bgcolor=A5A5A5 align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=4">����</A></TD>
	<TD align=center><A HREF="?to_id=".$idkomu['id']."&room=2&edit=1&razdel=3">������</A></TD>
	<?}?>
</TR></TABLE>
</TD></TR>
<TR>
<?
	$d = mysql_fetch_array(mysql_query("SELECT sum(`massa`) FROM `inventory` WHERE `owner` = '".$_SESSION['uid']."' AND `dressed` = 0; "));
	$maxmass=$user['sila']*4;
?>
<TD align=center><B>������ (�����: <?=$d[0]?>/<?=$maxmass?>)</B></TD>
</TR>
<TR><TD><!--������-->
<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=2 BGCOLOR=A5A5A5>
<?	if ($_GET['razdel'] == 0) { $_SESSION['razdel'] = 0; }
	if ($_GET['razdel'] == 1) { $_SESSION['razdel'] = 1; }
	if ($_GET['razdel'] == 2) { $_SESSION['razdel'] = 2; }
	if ($_GET['razdel'] == 3) { $_SESSION['razdel'] = 3; }
	if ($_GET['razdel'] == 4) { $_SESSION['razdel'] = 4; }
	if ($_SESSION['razdel']==null) {
		$data = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '".$_SESSION['uid']."' AND `dressed` = 0 AND `setsale` = 0 AND `present` = '' AND `destinyinv` = '' AND `type` < 25 AND `podzem` != 1 ORDER by `update` DESC; ");
	}
	if ($_SESSION['razdel']==1) {
		$data = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '".$_SESSION['uid']."' AND `dressed` = 0 AND `setsale` = 0 AND `present` = '' AND `destinyinv` = '' AND `type` = 25 AND `podzem` != 1 ORDER by `update` DESC; ");
	}
	if ($_SESSION['razdel']==2) {
		$data = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '".$_SESSION['uid']."' AND `dressed` = 0 AND `setsale` = 0 AND `present` = '' AND `destinyinv` = '' AND `type` > 50 AND `podzem` != 1 ORDER by `update` DESC; ");
	}
	if ($_SESSION['razdel']==3) {
		$data = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '".$_SESSION['uid']."' AND `dressed` = 0 AND `setsale` = 0 AND `present` = '' AND `destinyinv` = '' AND `type` = 50 AND `podzem` != 1 ORDER by `update` DESC; ");
	}
	if ($_SESSION['razdel']==4) {

	}

	while($row = mysql_fetch_array($data)) {
		$row['count'] = 1;
		if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }?>
<TR bgcolor=<?=$color?>><TD align=center ><IMG SRC="i/sh/<?=$row['img']?> BORDER=0>
<BR>
<A HREF="post.php?room=2&to_id=".$idkomu."&id_th=".$row['id']."&setobject=".$row['id']."&sd4=".$user['id']."&tmp=".rand(0,50000000).""".'onclick="return confirm(\'�������� ������� '.$row['name'].'?\')">��������&nbsp;��&nbsp;1&nbsp;��.</A>

</TD>
<TD valign=top>
<?		showitem ($row);?>
</TD></TR>
<?	}
	if (mysql_num_rows($data) == 0) {?>
<tr><td align=center bgcolor=#C7C7C7>�����</td></tr>
<?	}?>
</TABLE>
</TD></TR>
</TABLE>

</TD><TD valign=top width=200><TABLE cellpadding=0 cellspacing=0 width=100%><TR><TD width=100%><SPAN></SPAN><TD><HTML>
<link href="/i/move/design6.css" rel="stylesheet" type="text/css"><script language="javascript" type="text/javascript">
function fastshow2 (content, eEvent ) {
var el = document.getElementById("mmoves");
eEvent = eEvent || window.event;
if( !eEvent )
return;
var o = eEvent.target || eEvent.srcElement;
if (content!='' && el.style.visibility != "visible") {el.innerHTML = '<small>'+content+'</small>';}
var x = window.event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft - el.offsetWidth + 5;
var y = window.event.clientY + document.documentElement.scrollTop + document.body.scrollTop+20;
if (x + el.offsetWidth + 3 > document.body.clientWidth + document.body.scrollLeft) { x=(document.body.clientWidth + document.body.scrollLeft - el.offsetWidth - 5); if (x < 0) {x=0}; }
if (y + el.offsetHeight + 3 > document.body.clientHeight  + document.body.scrollTop) { y=(document.body.clientHeight + document.body.scrollTop - el.offsetHeight - 3); if (y < 0) {y=0}; }
if (x<0) {x=0;}
if (y<0) {y=0;}
el.style.left = x + "px";
el.style.top  = y + "px";
if (el.style.visibility != "visible") {
el.style.visibility = "visible";
}
}
function hideshow () {
document.getElementById("mmoves").style.visibility = 'hidden';
}
</script>
<table  border="0" cellpadding="0" cellspacing="0">
<tr align="right" valign="top">
<td>


</td>
<td>

<TABLE height=15 border="0" cellspacing="0" cellpadding="0">
<TR>
<TD rowspan=3 valign="bottom"><a href="post.php"><img src="http://img.combats.com/i/move/rel_1.gif" width="15" height="16" alt="��������" border="0" /></a></TD>
<TD colspan="3"><img src="http://img.combats.com/i/move/navigatin_462.gif" width="80" height="4" /></TD>
</TR>
<TR>
<TD><IMG src="http://img.combats.com/i/move/navigatin_481.gif" width="9" height="8"></TD>
<TD width=64 bgcolor=black><DIV class="MoveLine"><IMG src="http://img.combats.com/i/move/wait2.gif" id="MoveLine" class="MoveLine"></DIV></TD>
<TD><IMG src="http://img.combats.com/i/move/navigatin_50.gif" width="7" height="8"></TD>
</TR>
<TR>
<TD colspan="3"><IMG src="http://img.combats.com/i/move/navigatin_tt1_532.gif" width="80" height="5"></TD>
</TR>
</TABLE>


<table  border="0" cellspacing="0" cellpadding="0">
<tr>
<td nowrap="nowrap" id="moveto">
<table width="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#DEDEDE">

<tr>
<td bgcolor="#D3D3D3"><img src="http://img.combats.com/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><a href="city.php?cp=3&rnd=0.40708144596568" onclick="return check_access();" class="menutop" title="����� ��������: 15 ���.
������ � ������� ".$loc['count']." ���.">����������� �������</a></td>
</tr>

<!--<tr>
<td bgcolor="#D3D3D3"><img src="http://img.combats.com/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><a href="?rnd=0.418053237424392&path=1.100.106.1" onclick="return check_access();" class="menutop" title="����� ��������: 3 ���.
������ � ������� 0 ���.">������ ��������</a></td>
</tr>-->
</table>
</td>
</tr>
</table>
<!-- <br /><span class="menutop"><nobr>�������� ���������</nobr></span>-->
</td>
</tr>
</table>
<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px; white-space: nowrap;"></div>
<script language="javascript" type="text/javascript">
var progressEnd = 64;		// set to number of progress <span>'s.
var progressColor = '#00CC00';	// set to progress bar color
var mtime = parseInt('0');
if (!mtime || mtime<=0) {mtime=0;}
var progressInterval = Math.round(mtime*1000/progressEnd);	// set to time between updates (milli-seconds)
var is_accessible = true;
var progressAt = progressEnd;
var progressTimer;
function progress_clear() {
progressAt = 1;
is_accessible = false;
set_moveto(true);
}
function progress_update() {
progressAt++;
//if (progressAt > progressEnd) progress_clear();
if (progressAt > progressEnd) {
is_accessible = true;
if (window.solo_store && solo_store) { solo(solo_store, "\"); } // go to stored
set_moveto(false);
} else {
if( !( progressAt % 2 ) )
document.getElementById('MoveLine').style.left = progressAt - 64;
progressTimer = setTimeout('progress_update()',progressInterval);
}
}
function set_moveto (val) {
document.getElementById('moveto').disabled = val;
if (document.getElementById('bmoveto')) {
document.getElementById('bmoveto').disabled = val;
}
}
function progress_stop() {
clearTimeout(progressTimer);
progress_clear();
}
function check(it) {
return is_accessible;
}
function check_access () {
return is_accessible;
}
function ch_counter_color (color) {
/*	progressColor = color;
for (var i = 1; i <= progressAt; i++) {
document.getElementById('progress'+i).style.backgroundColor = progressColor;
}*/
}
if (mtime>0) {
progress_clear();
progress_update();
}
</script>
</HTML>
</TD></TR>
<TR><TD colspan=2>
<NOBR>
������: <?=$user['money']?> ��.<BR>
<BR><BR>
<B>�������� ��������</B><BR>
<A href="?room=3&setlogin=">������� � ��������</A><BR>
<FONT color=gray>�������� ����</FONT><BR>
<BR>
<FONT color=gray>������</FONT><BR>
</NOBR></TR></TD></TABLE>
</TD>
</TABLE>
</FORM>
<?	include("mail_ru.php");?>
</BODY>
</HTML>
<?}


//�������� �� � ��������
//if(!empty($_REQUEST['setlogin']) and $_REQUEST['room'] == 3)
if($step==5)
{?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="/i/main2.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<SCRIPT src='/i/commoninf.js'></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="/i/sl2.24.js"></SCRIPT>
<STYLE>
.pH3			{ COLOR: #8f0000;  FONT-FAMILY: Arial;  FONT-SIZE: 12pt;  FONT-WEIGHT: bold; }
</STYLE>
<SCRIPT>
var sd4 = "45929980";
function fastshow(dsc, dx, dy) { top.fullfastshow(document, mmoves, window.event, dsc, dx, dy); }
function hideshow() { top.fullhideshow(mmoves); }
</SCRIPT>
</HEAD>
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=e2e0e0>
<div id=hint4 class=ahint></div>
<TABLE width=100%><TD valign=top height=100%>
<TABLE width=100% cellspacing=0 cellpadding=4 bgcolor=d2d2d2>
<FORM ACTION=post.php METHOD=POST name=F1>
 <INPUT TYPE=hidden name=room value=3>
 <INPUT TYPE=hidden name=to_id value=".$idkomu.">";
<INPUT type=hidden name="sd4" value="".$user['id']."">";
<tr><td class='pH3'>&nbsp;&nbsp;&nbsp;&nbsp;�������� ���������
. &nbsp; ������� � ��������
</FONT></td><td align=right valign=top><?=nick3($_SESSION['uid'])?>&nbsp;</td></tr></table>


<font color=red><b><?=$mess?></b></font>
<br>
� ���� ����������: <font color=red><?=nick3($idkomu['id'])?></font>&nbsp;&nbsp;
<INPUT TYPE=button value="�������" onclick="try { findlogin('�������� ������','post.php','setlogin', '', '', '<INPUT type=hidden name=room value=3>') } catch(e) { alert( e.message ); }"><BR>
��������� � ���� ������<BR>

<BR><FIELDSET><LEGEND><B>�������� �������</B> </LEGEND>
� ��� �� �����: <FONT COLOR=339900><B><?=$user['money']?></B></FONT> ��.<BR>
�������� �������, ���������� 0.01 ��.<BR>
������� ������������ �����: <INPUT TYPE=text NAME=setkredit maxlength=8 size=6><INPUT TYPE=submit onClick="if(!confirm('��������� ������?')) { return false; }" VALUE="��������"><BR>
</FIELDSET>
<FIELDSET><LEGEND><B>��������</B> </LEGEND>
������ �������: <B>0.05 ��.</B><BR>
���������: (����������� 100 ��������)<BR>
<INPUT TYPE=text NAME=message id=message maxlength=100 size=65><INPUT TYPE=submit VALUE="���������" id="sendMessage" name="sendMessage" onClick="if(!confirm('������� ���������?')) { return false; }"><BR>
</FIELDSET>
<FIELDSET><LEGEND><B>������</B> </LEGEND>
������ �������: <B>1 ��.</B><BR>
���������: (����� �������� 30 ���.)<BR>
<TEXTAREA NAME=letter id=letter cols=65 rows=10 onkeyup="ch_l()" onchange="ch_l()"></TEXTAREA><BR>(�������� <SPAN id='count1'>500</SPAN> ����.)<INPUT TYPE=submit VALUE="���������" name="sendletter" id="sendLetter\ onClick="if(!confirm('������� ������?')) { return false; }"><BR>
</FIELDSET>
<SCRIPT>
function ch_l() {
count1.innerHTML = F1.letter.value.length>500?0:(500 - F1.letter.value.length);
}
ch_l();
</SCRIPT>

</TD><TD valign=top width=200><TABLE cellpadding=0 cellspacing=0 width=100%><TR><TD width=100%><SPAN></SPAN><TD><HTML>
<link href="/i/move/design6.css" rel="stylesheet" type="text/css"><script language="javascript" type="text/javascript">
function fastshow2 (content, eEvent ) {
var el = document.getElementById("mmoves");
eEvent = eEvent || window.event;
if( !eEvent )
return;
var o = eEvent.target || eEvent.srcElement;
if (content!='' && el.style.visibility != "visible") {el.innerHTML = '<small>'+content+'</small>';}
var x = window.event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft - el.offsetWidth + 5;
var y = window.event.clientY + document.documentElement.scrollTop + document.body.scrollTop+20;
if (x + el.offsetWidth + 3 > document.body.clientWidth + document.body.scrollLeft) { x=(document.body.clientWidth + document.body.scrollLeft - el.offsetWidth - 5); if (x < 0) {x=0}; }
if (y + el.offsetHeight + 3 > document.body.clientHeight  + document.body.scrollTop) { y=(document.body.clientHeight + document.body.scrollTop - el.offsetHeight - 3); if (y < 0) {y=0}; }
if (x<0) {x=0;}
if (y<0) {y=0;}
el.style.left = x + "px";
el.style.top  = y + "px";
if (el.style.visibility != "visible") {
el.style.visibility = "visible";
}
}
function hideshow () {
document.getElementById("mmoves").style.visibility = 'hidden';
}
</script>
<table  border="0" cellpadding="0" cellspacing="0">
<tr align="right" valign="top">
<td>


</td>
<td>

<TABLE height=15 border="0" cellspacing="0" cellpadding="0">
<TR>
<TD rowspan=3 valign="bottom"><a href="?rnd=0.566608008208018"><img src="http://img.combats.com/i/move/rel_1.gif" width="15" height="16" alt="��������" border="0" /></a></TD>
<TD colspan="3"><img src="http://img.combats.com/i/move/navigatin_462.gif" width="80" height="4" /></TD>
</TR>
<TR>
<TD><IMG src="http://img.combats.com/i/move/navigatin_481.gif" width="9" height="8"></TD>
<TD width=64 bgcolor=black><DIV class="MoveLine"><IMG src="http://img.combats.com/i/move/wait2.gif" id="MoveLine" class="MoveLine"></DIV></TD>
<TD><IMG src="http://img.combats.com/i/move/navigatin_50.gif" width="7" height="8"></TD>
</TR>
<TR>
<TD colspan="3"><IMG src="http://img.combats.com/i/move/navigatin_tt1_532.gif" width="80" height="5"></TD>
</TR>
</TABLE>


<table  border="0" cellspacing="0" cellpadding="0">
<tr>
<td nowrap="nowrap" id="moveto">
<table width="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#DEDEDE">

<tr>
<td bgcolor="#D3D3D3"><img src="http://img.combats.com/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><a href="city.php?cp=3&rnd=0.40708144596568" onclick="return check_access();" class="menutop" title="����� ��������: 15 ���.
������ � ������� ".$loc['count']." ���.">����������� �������</a></td>
</tr>

<!--<tr>
<td bgcolor="#D3D3D3"><img src="http://img.combats.com/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><a href="?rnd=0.390776196981083&path=1.100.106.1" onclick="return check_access();" class="menutop" title="����� ��������: 3 ���.
������ � ������� 0 ���.">������ ��������</a></td>
</tr>-->
</table>
</td>
</tr>
</table>
<!-- <br /><span class="menutop"><nobr>�������� ���������</nobr></span>-->
</td>
</tr>
</table>
<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px; white-space: nowrap;"></div>
<script language="javascript" type="text/javascript">
var progressEnd = 64;		// set to number of progress <span>'s.
var progressColor = '#00CC00';	// set to progress bar color
var mtime = parseInt('0');
if (!mtime || mtime<=0) {mtime=0;}
var progressInterval = Math.round(mtime*1000/progressEnd);	// set to time between updates (milli-seconds)
var is_accessible = true;
var progressAt = progressEnd;
var progressTimer;
function progress_clear() {
progressAt = 1;
is_accessible = false;
set_moveto(true);
}
function progress_update() {
progressAt++;
//if (progressAt > progressEnd) progress_clear();
if (progressAt > progressEnd) {
is_accessible = true;
if (window.solo_store && solo_store) { solo(solo_store, "\"); } // go to stored
set_moveto(false);
} else {
if( !( progressAt % 2 ) )
document.getElementById('MoveLine').style.left = progressAt - 64;
progressTimer = setTimeout('progress_update()',progressInterval);
}
}
function set_moveto (val) {
document.getElementById('moveto').disabled = val;
if (document.getElementById('bmoveto')) {
document.getElementById('bmoveto').disabled = val;
}
}
function progress_stop() {
clearTimeout(progressTimer);
progress_clear();
}
function check(it) {
return is_accessible;
}
function check_access () {
return is_accessible;
}
function ch_counter_color (color) {
/*	progressColor = color;
for (var i = 1; i <= progressAt; i++) {
document.getElementById('progress'+i).style.backgroundColor = progressColor;
}*/
}
if (mtime>0) {
progress_clear();
progress_update();
}
</script>
</HTML>
</TD></TR>
<TR><TD colspan=2>
<NOBR>
������: <?=$user['money']?> ��.<BR><br><br>
<A href="?room=2&setlogin=">�������� ��������</A><BR>
<B>������� � ��������</B><BR>
<FONT color=gray>�������� ����</FONT><BR>
<BR>
<FONT color=gray>������</FONT><BR>
</NOBR></TR></TD></TABLE>
</TD>
</TABLE>
</FORM>
	<? include("mail_ru.php");?>
</BODY>
</HTML>
<?}
?>
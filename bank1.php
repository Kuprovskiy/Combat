<HTML><HEAD>
<link rel=stylesheet type="text/css" href="http://img.combats.com/i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<SCRIPT src='http://img.combats.com/i/commoninf.js'></SCRIPT>
<SCRIPT LANGUAGE="JavaScript1.2" SRC="http://img.combats.com/i/misc/keypad.js"></SCRIPT>
<style type="text/css">
<!--
.btkey {
	display: block; text-align: center;
	PADDING-RIGHT: 1px; PADDING-LEFT: 1px;
	FONT-SIZE: 6.5pt; FONT-FAMILY: verdana,sans-serif,arial;
	width: 18;
	CURSOR: hand;
	border: 1px solid #D6D3CE;
	COLOR: #000000; BACKGROUND-COLOR: #ffffff;
}
-->
</style>
</HEAD>
<body bgcolor=e2e0e0>
<TABLE width=100%>
<TR><TD><H3>����</TD>
<TD align=right width=30%><HTML>
<link href="http://img.combats.com/i/move/design6.css" rel="stylesheet" type="text/css"><script language="javascript" type="text/javascript">
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
<TD rowspan=3 valign="bottom"><a href="?rnd=0.611383738844829"><img src="http://img.combats.com/i/move/rel_1.gif" width="15" height="16" alt="��������" border="0" /></a></TD>
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
<td bgcolor="#D3D3D3" nowrap><a href="?rnd=0.388580867987006&path=1.106.1" onclick="return check_access();" class="menutop" title="����� ��������: 15 ���.
������ � ������� 0 ���.">����</a></td>
</tr>
</table>
</td>
</tr>
</table>
<!-- <br /><span class="menutop"><nobr>����</nobr></span>-->
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
if (window.solo_store && solo_store) { solo(solo_store, ""); } // go to stored
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

</TD>
</TR>
</TABLE>
<!-- ���������� ������ -->
<FORM action="bank.pl" method=POST name=F1>
<INPUT TYPE=hidden name=sid value="230451324010">
<TABLE width=100%>
<TR>
<TD valign=top width=30%><H4>���������� ������</H4> &nbsp;
<b>���� �:</b> 2096350233 <a href="?close_session=0.276816824252336" title="�������� ������ c ������� ������">[x]</a><br>
</TD>
<TD valign=top align=center width=40%>
<TABLE><TR><TD>
<FIELDSET><LEGEND><B>� ��� �� �����</B> </LEGEND>
<TABLE>
<TR><TD>��������:</TD><TD><B>0.00</B></TD></TR>
<TR><TD>������������:</TD><TD><B>0.02</B></TD></TR>
<TR><TD colspan=2><HR></TD></TR>
<TR><TD>��� ���� ��������:</TD><TD><B>0.53 ��.</B></TD></TR>
</TABLE>
</FIELDSET>
</TD></TR></TABLE>
</TD>
<TD valign=top align=right width=30%><FONT COLOR=red>��������!</FONT> ��������� ������ ����� �������, � ������� ��������� �������� �������� � ��������������� �������.</TD>
</TR>
</TABLE>
<TABLE cellspacing=5><TR>
<TD valign=top width=50%><FIELDSET><LEGEND><B>��������� ����</B> </LEGEND>
����� <INPUT TYPE=text NAME=add_sum size=6 maxlength=10> ��. <INPUT TYPE=submit name=add_kredit value="�������� ������� �� ����" onclick="if (isNaN(parseFloat(document.F1.add_sum.value))) {alert('������� �����'); return false;} else {return confirm('�� ������ �������� �� ���� ���� '+parseFloat(document.F1.add_sum.value)+' ��. ?')}"><BR>

</FIELDSET></TD>
<TD valign=top width=50%><FIELDSET><LEGEND><B>����� �� �����</B> </LEGEND>
����� <INPUT TYPE=text NAME=get_sum size=6 maxlength=10> ��. <INPUT TYPE=submit name=get_kredit value="����� ������� �� �����" onclick="if (isNaN(parseFloat(document.F1.get_sum.value))) {alert('������� �����'); return false;} else {return confirm('�� ������ ����� �� ������ ����� '+parseFloat(document.F1.get_sum.value)+' ��. ?')}"><BR>

</FIELDSET></TD>
</TR><TR>
<TD valign=top><FIELDSET><LEGEND><B>��������� ������� �� ������ ����</B> </LEGEND>
����� <INPUT TYPE=text NAME=tansfer_sum size=6 maxlength=10> ��.<BR>
����� ����� ���� ��������� ������� <INPUT TYPE=text NAME=num2 size=12 maxlength=15><BR>
<INPUT TYPE=submit name=transfer_kredit value="��������� ������� �� ������ ����" onclick="if (isNaN(parseFloat(document.F1.tansfer_sum.value)) || isNaN(parseInt(document.F1.num2.value)) ) {alert('������� ����� � ����� �����'); return false;} else {return confirm('�� ������ ��������� �� ������ ����� '+parseFloat(document.F1.tansfer_sum.value)+' ��. �� ���� ����� '+parseInt(document.F1.num2.value)+' ?')}"><BR>

�������� ���������� <B>3.00 %</B> �� �����, �� �� ����� <B>1.00 ��</B>.
</FIELDSET></TD>
<TD valign=top><FIELDSET><LEGEND><B>���� ����������� � ������� ������</B> </LEGEND>
������ �� 04.09.10 19:42<BR>
1 ���. = <b>1.2821</b> �������� ���<BR>
1 ���. = <b>1.0000</b> ����<BR>
1 ���. = <b>10.1335</b> ���. ������<BR>
1 ���. = <b>0.8315</b> ����. ������ ����������<BR>
1 ���. = <b>39.3505</b> ���������� ������<BR>
<A href='http://capitalcity.combats.com/bank.pl?history=1' target='_blank'>�����</A>
</FIELDSET></TD>
</TR><TR>
<TD valign=top><FIELDSET><LEGEND><B>�������� �����</B> </LEGEND>
�������� ����������� �� �������.<BR>
���� <B>1 ���.</B> = <B>30.00 ��.</B><BR>
����� <INPUT TYPE=text NAME=convert_sum size=6 maxlength=10> ���.
<INPUT TYPE=submit name=convert_ekredit value="��������" onclick="if (isNaN(parseFloat(document.F1.convert_sum.value))) {alert('������� ������������ �����'); return false;} else {return confirm('�� ������ �������� '+parseFloat(document.F1.convert_sum.value)+' ���. �� ������� ?')}">
</FIELDSET></TD>
<TD></TD>
</TR><TR>
<TD valign=top><FIELDSET><LEGEND><B>���������</B> </LEGEND>
� ��� ��������� ������� ������ ����� � ������ �� email. ���� �� �� ������� � ����� email, ��� ��������, ��� �� �������� ���� ����� ����� � ������ � ����, �� ������ ��������� ������� ������ �� email. ��� �������� ��� �� ����� �������� � ������ ����� � ������ ������ ������ email. �� ���� �� ���� �������� ���� ����� ����� �/��� ������, ��� ��� ����� �� �������!<BR>
<INPUT TYPE=submit name=stop_send_email value="��������� ������� ������ �� email">
<HR><B>������� ������</B><BR>
<table>
<tr><TD>����� ������</TD><TD><INPUT TYPE=password name=new_psw></TD><TD><img border=0 SRC="http://img.combats.com/i/misc/klav_transparent.gif"  style='cursor: hand' onClick="KeypadShow(1, 'F1', 'psw', 'keypad1');"></TD></tr>
<tr><TD>������� ����� ������ ��������</TD><TD><INPUT TYPE=password name=new_psw2></TD><TD><img border=0 SRC="http://img.combats.com/i/misc/klav_transparent.gif" style='cursor: hand' onClick="KeypadShow(1, 'F1', 'psw2', 'keypad1');"></TD></tr>
</table>
<INPUT TYPE=submit name=change_psw value="������� ������"><BR>
<div id="keypad1" align=center style="display: none;"></div>
</FIELDSET></TD>
<TD valign=top><FIELDSET><LEGEND><B>��������� ��������</B> </LEGEND>

<TABLE cellpadding="2" cellspacing="0" border="0">

<TR><TD><font class=date>09.03.10 16:26</font> �� ����� �� ����� <b>10.00 ��.</b>, �������� <b>0 ��.</b> <i>(�����: 0.00 ��., 0.02 ���.)</i></TD></TR>

<TR><TD><font class=date>08.03.10 20:55</font> �� ����� �� ����� <b>10.00 ��.</b>, �������� <b>0 ��.</b> <i>(�����: 10.00 ��., 0.02 ���.)</i></TD></TR>

<TR><TD><font class=date>08.03.10 09:02</font> �� ����� �� ����� <b>150.00 ��.</b>, �������� <b>0 ��.</b> <i>(�����: 20.00 ��., 0.02 ���.)</i></TD></TR>

<TR><TD><font class=date>07.03.10 20:29</font> �� �������� <b>1000.00 ��.</b> �� ���� 1571191636 ��������� "������� �������", �������� <b>30 ��.</b> <i>(�����: 170.00 ��., 0.02 ���.)</i></TD></TR>

<TR><TD><font class=date>07.03.10 20:26</font> �� ����� �� ����� <b>7.00 ��.</b>, �������� <b>0 ��.</b> <i>(�����: 1200.00 ��., 0.02 ���.)</i></TD></TR>

<TR><TD><font class=date>07.03.10 20:26</font> �� �������� <b>5.00 ��.</b> �� ���� 270738770 ��������� "mr ganj", �������� <b>1.00 ��.</b> <i>(�����: 1207.00 ��., 0.02 ���.)</i></TD></TR>

<TR><TD><font class=date>07.03.10 20:25</font> �� �������� �� ���� <b>13.00 ��.</b>, �������� <b>0 ��.</b> <i>(�����: 1213.00 ��., 0.02 ���.)</i></TD></TR>

<TR><TD><font class=date>07.03.10 20:20</font> �� �������� �� ���� <b>1000.00 ��.</b>, �������� <b>0 ��.</b> <i>(�����: 1200.00 ��., 0.02 ���.)</i></TD></TR>

<TR><TD><font class=date>07.03.10 20:18</font> �� ����� �� ����� <b>1000.00 ��.</b>, �������� <b>0 ��.</b> <i>(�����: 200.00 ��., 0.02 ���.)</i></TD></TR>

<TR><TD><font class=date>06.03.10 20:42</font> �� �������� �� ���� <b>1200.00 ��.</b>, �������� <b>0 ��.</b> <i>(�����: 1200.00 ��., 0.02 ���.)</i></TD></TR>
</TABLE>
</FIELDSET>
</TD>
</TR>
<TR>
<TD colspan="2" valign=top><FIELDSET><LEGEND><B>�������� ������</B> </LEGEND>
����� �� ������ ���������� ����� ���������� ��� ����. ������ ������ ������, ��� ���� ���� ������ � ������. �������� ������ ����� ��� ���� ������.<BR>
<TEXTAREA NAME=notepad ROWS=10 COLS=67 style="width:100%"></TEXTAREA><BR>
<INPUT TYPE=submit name=save_notepad value="��������� ���������">
</FIELDSET>
</TD>
</TR></TABLE>

<DIV><!--Rating@Mail.ru COUNTER-->
<SCRIPT language=JavaScript><!--
d=document;a='';a+=';r='+escape(d.referrer)
js=10//--></SCRIPT>
<SCRIPT language=JavaScript1.1><!--
a+=';j='+navigator.javaEnabled()
js=11//--></SCRIPT>
<SCRIPT language=JavaScript1.2><!--
s=screen;a+=';s='+s.width+'*'+s.height
a+=';d='+(s.colorDepth?s.colorDepth:s.pixelDepth)
js=12//--></SCRIPT>
<SCRIPT language=JavaScript1.3><!--
js=13//--></SCRIPT>
<SCRIPT language=JavaScript><!--
d.write('<a href="http://top.mail.ru/jump?from=341269"'+
' target=_blank><img src="http://top.list.ru/counter'+
'?id=341269;t=50;js='+js+a+';rand='+Math.random()+
'" alt="�������@Mail.ru"'+' border=0 height=31 width=88></a>')
if(js>11)d.write('<'+'!-- ')//--></SCRIPT>
<NOSCRIPT>
<A href="http://top.mail.ru/jump?from=341269" target=_blank><IMG height=31 alt="�������@Mail.ru" src="http://img.combats.com/i/mainpage/counter.gif" width=88 border=0></A>
</NOSCRIPT>
<SCRIPT language=JavaScript><!--
if(js>11)d.write('--'+'>')//--></SCRIPT>
<!--/COUNTER--></DIV>
</FORM>
</BODY>
</HTML>

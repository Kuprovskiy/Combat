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
<TR><TD><H3>Банк</TD>
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
<TD rowspan=3 valign="bottom"><a href="?rnd=0.611383738844829"><img src="http://img.combats.com/i/move/rel_1.gif" width="15" height="16" alt="Обновить" border="0" /></a></TD>
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
<td bgcolor="#D3D3D3" nowrap><a href="?rnd=0.388580867987006&path=1.106.1" onclick="return check_access();" class="menutop" title="Время перехода: 15 сек.
Сейчас в комнате 0 чел.">Банк</a></td>
</tr>
</table>
</td>
</tr>
</table>
<!-- <br /><span class="menutop"><nobr>Сейф</nobr></span>-->
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
<!-- управление счетом -->
<FORM action="bank.pl" method=POST name=F1>
<INPUT TYPE=hidden name=sid value="230451324010">
<TABLE width=100%>
<TR>
<TD valign=top width=30%><H4>Управление счетом</H4> &nbsp;
<b>Счёт №:</b> 2096350233 <a href="?close_session=0.276816824252336" title="Окончить работу c текущим счетом">[x]</a><br>
</TD>
<TD valign=top align=center width=40%>
<TABLE><TR><TD>
<FIELDSET><LEGEND><B>У вас на счету</B> </LEGEND>
<TABLE>
<TR><TD>Кредитов:</TD><TD><B>0.00</B></TD></TR>
<TR><TD>Еврокредитов:</TD><TD><B>0.02</B></TD></TR>
<TR><TD colspan=2><HR></TD></TR>
<TR><TD>При себе наличных:</TD><TD><B>0.53 кр.</B></TD></TR>
</TABLE>
</FIELDSET>
</TD></TR></TABLE>
</TD>
<TD valign=top align=right width=30%><FONT COLOR=red>Внимание!</FONT> Некоторые услуги банка платные, о размере взымаемой комиссии написано в соответствующем разделе.</TD>
</TR>
</TABLE>
<TABLE cellspacing=5><TR>
<TD valign=top width=50%><FIELDSET><LEGEND><B>Пополнить счет</B> </LEGEND>
Сумма <INPUT TYPE=text NAME=add_sum size=6 maxlength=10> кр. <INPUT TYPE=submit name=add_kredit value="Положить кредиты на счет" onclick="if (isNaN(parseFloat(document.F1.add_sum.value))) {alert('Укажите сумму'); return false;} else {return confirm('Вы хотите положить на свой счет '+parseFloat(document.F1.add_sum.value)+' кр. ?')}"><BR>

</FIELDSET></TD>
<TD valign=top width=50%><FIELDSET><LEGEND><B>Снять со счета</B> </LEGEND>
Сумма <INPUT TYPE=text NAME=get_sum size=6 maxlength=10> кр. <INPUT TYPE=submit name=get_kredit value="Снять кредиты со счета" onclick="if (isNaN(parseFloat(document.F1.get_sum.value))) {alert('Укажите сумму'); return false;} else {return confirm('Вы хотите снять со своего счета '+parseFloat(document.F1.get_sum.value)+' кр. ?')}"><BR>

</FIELDSET></TD>
</TR><TR>
<TD valign=top><FIELDSET><LEGEND><B>Перевести кредиты на другой счет</B> </LEGEND>
Сумма <INPUT TYPE=text NAME=tansfer_sum size=6 maxlength=10> кр.<BR>
Номер счета куда перевести кредиты <INPUT TYPE=text NAME=num2 size=12 maxlength=15><BR>
<INPUT TYPE=submit name=transfer_kredit value="Перевести кредиты на другой счет" onclick="if (isNaN(parseFloat(document.F1.tansfer_sum.value)) || isNaN(parseInt(document.F1.num2.value)) ) {alert('Укажите сумму и номер счета'); return false;} else {return confirm('Вы хотите перевести со своего счета '+parseFloat(document.F1.tansfer_sum.value)+' кр. на счет номер '+parseInt(document.F1.num2.value)+' ?')}"><BR>

Комиссия составляет <B>3.00 %</B> от суммы, но не менее <B>1.00 кр</B>.
</FIELDSET></TD>
<TD valign=top><FIELDSET><LEGEND><B>Курс еврокредита к мировой валюте</B> </LEGEND>
Данные на 04.09.10 19:42<BR>
1 екр. = <b>1.2821</b> долларов США<BR>
1 екр. = <b>1.0000</b> ЕВРО<BR>
1 екр. = <b>10.1335</b> укр. гривен<BR>
1 екр. = <b>0.8315</b> англ. фунтов стерлингов<BR>
1 екр. = <b>39.3505</b> российских рублей<BR>
<A href='http://capitalcity.combats.com/bank.pl?history=1' target='_blank'>Архив</A>
</FIELDSET></TD>
</TR><TR>
<TD valign=top><FIELDSET><LEGEND><B>Обменный пункт</B> </LEGEND>
Обменять еврокредиты на кредиты.<BR>
Курс <B>1 екр.</B> = <B>30.00 кр.</B><BR>
Сумма <INPUT TYPE=text NAME=convert_sum size=6 maxlength=10> екр.
<INPUT TYPE=submit name=convert_ekredit value="Обменять" onclick="if (isNaN(parseFloat(document.F1.convert_sum.value))) {alert('Укажите обмениваемую сумму'); return false;} else {return confirm('Вы хотите обменять '+parseFloat(document.F1.convert_sum.value)+' екр. на кредиты ?')}">
</FIELDSET></TD>
<TD></TD>
</TR><TR>
<TD valign=top><FIELDSET><LEGEND><B>Настройки</B> </LEGEND>
У вас разрешена высылка номера счета и пароля на email. Если вы не уверены в своем email, или убеждены, что не забудете свой номер счета и пароль к нему, то можете запретить высылку пароля на email. Это убережет вас от кражи кредитов с вашего счета в случае взлома вашего email. Но если вы сами забудете свой номер счета и/или пароль, вам уже никто не поможет!<BR>
<INPUT TYPE=submit name=stop_send_email value="Запретить высылку пароля на email">
<HR><B>Сменить пароль</B><BR>
<table>
<tr><TD>Новый пароль</TD><TD><INPUT TYPE=password name=new_psw></TD><TD><img border=0 SRC="http://img.combats.com/i/misc/klav_transparent.gif"  style='cursor: hand' onClick="KeypadShow(1, 'F1', 'psw', 'keypad1');"></TD></tr>
<tr><TD>Введите новый пароль повторно</TD><TD><INPUT TYPE=password name=new_psw2></TD><TD><img border=0 SRC="http://img.combats.com/i/misc/klav_transparent.gif" style='cursor: hand' onClick="KeypadShow(1, 'F1', 'psw2', 'keypad1');"></TD></tr>
</table>
<INPUT TYPE=submit name=change_psw value="Сменить пароль"><BR>
<div id="keypad1" align=center style="display: none;"></div>
</FIELDSET></TD>
<TD valign=top><FIELDSET><LEGEND><B>Последние операции</B> </LEGEND>

<TABLE cellpadding="2" cellspacing="0" border="0">

<TR><TD><font class=date>09.03.10 16:26</font> Вы сняли со счета <b>10.00 кр.</b>, комиссия <b>0 кр.</b> <i>(Итого: 0.00 кр., 0.02 екр.)</i></TD></TR>

<TR><TD><font class=date>08.03.10 20:55</font> Вы сняли со счета <b>10.00 кр.</b>, комиссия <b>0 кр.</b> <i>(Итого: 10.00 кр., 0.02 екр.)</i></TD></TR>

<TR><TD><font class=date>08.03.10 09:02</font> Вы сняли со счета <b>150.00 кр.</b>, комиссия <b>0 кр.</b> <i>(Итого: 20.00 кр., 0.02 екр.)</i></TD></TR>

<TR><TD><font class=date>07.03.10 20:29</font> Вы перевели <b>1000.00 кр.</b> на счет 1571191636 персонажа "синдром бажання", комиссия <b>30 кр.</b> <i>(Итого: 170.00 кр., 0.02 екр.)</i></TD></TR>

<TR><TD><font class=date>07.03.10 20:26</font> Вы сняли со счета <b>7.00 кр.</b>, комиссия <b>0 кр.</b> <i>(Итого: 1200.00 кр., 0.02 екр.)</i></TD></TR>

<TR><TD><font class=date>07.03.10 20:26</font> Вы перевели <b>5.00 кр.</b> на счет 270738770 персонажа "mr ganj", комиссия <b>1.00 кр.</b> <i>(Итого: 1207.00 кр., 0.02 екр.)</i></TD></TR>

<TR><TD><font class=date>07.03.10 20:25</font> Вы положили на счет <b>13.00 кр.</b>, комиссия <b>0 кр.</b> <i>(Итого: 1213.00 кр., 0.02 екр.)</i></TD></TR>

<TR><TD><font class=date>07.03.10 20:20</font> Вы положили на счет <b>1000.00 кр.</b>, комиссия <b>0 кр.</b> <i>(Итого: 1200.00 кр., 0.02 екр.)</i></TD></TR>

<TR><TD><font class=date>07.03.10 20:18</font> Вы сняли со счета <b>1000.00 кр.</b>, комиссия <b>0 кр.</b> <i>(Итого: 200.00 кр., 0.02 екр.)</i></TD></TR>

<TR><TD><font class=date>06.03.10 20:42</font> Вы положили на счет <b>1200.00 кр.</b>, комиссия <b>0 кр.</b> <i>(Итого: 1200.00 кр., 0.02 екр.)</i></TD></TR>
</TABLE>
</FIELDSET>
</TD>
</TR>
<TR>
<TD colspan="2" valign=top><FIELDSET><LEGEND><B>Записная книжка</B> </LEGEND>
Здесь вы можете записывать любую информацию для себя. Номера счетов друзей, кто кому чего должен и прочее. Записная книжка общая для всех счетов.<BR>
<TEXTAREA NAME=notepad ROWS=10 COLS=67 style="width:100%"></TEXTAREA><BR>
<INPUT TYPE=submit name=save_notepad value="Сохранить изменения">
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
'" alt="Рейтинг@Mail.ru"'+' border=0 height=31 width=88></a>')
if(js>11)d.write('<'+'!-- ')//--></SCRIPT>
<NOSCRIPT>
<A href="http://top.mail.ru/jump?from=341269" target=_blank><IMG height=31 alt="Рейтинг@Mail.ru" src="http://img.combats.com/i/mainpage/counter.gif" width=88 border=0></A>
</NOSCRIPT>
<SCRIPT language=JavaScript><!--
if(js>11)d.write('--'+'>')//--></SCRIPT>
<!--/COUNTER--></DIV>
</FORM>
</BODY>
</HTML>

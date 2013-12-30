<?php
    session_start();
    //if ($_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    $user = mysql_fetch_array(mysql_query("SELECT level,vip,align,deal,login,klan FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
//  include "functions.php";
    header("Cache-Control: no-cache");

if ($_GET['ch'] != null){
?>
<DIV style="POSITION: absolute" class=TabTabsLayer align=right>
<TABLE border=0 cellSpacing=0 cellPadding=0>
<TBODY>
<TR>
<TD class=TabCrossingSF><IMG style="DISPLAY: none" width=8 height=18></TD>
<TD style="WIDTH: 29px" class=TabTextS align=right oTable="undefined" sName="chat" nWidth="1008" nHeight="260" nOrder="0" bSelected="true"><NOBR>Чат</NOBR></TD>
<TD class=TabCrossingS oTable="undefined"><IMG style="DISPLAY: none" width=8 height=18></TD>
<TD style="WIDTH: 157px" class=TabText align=right oTable="undefined" sName="syslog" nWidth="1008" nHeight="260" nOrder="1" bSelected="false"><NOBR>Системные сообщения</NOBR></TD>
<TD class=TabCrossingE oTable="undefined"><IMG style="DISPLAY: none" width=8 height=18></TD></TR></TBODY></TABLE></DIV>
<DIV align="center"><SELECT name="href" onchange="sel(this.value);"><OPTION value="" selected="">Включить радио!<OPTION value="http://cluster.quantumart.ru/broadcast/default.aspx?media=dfm">Динамит FM
<OPTION value="http://cluster.quantumart.ru/broadcast/default.aspx?media=maximum">MAXIMUM<OPTION value="http://www.loveradio.ru/love-radio-32k.m3u">Love радио Ru
<OPTION value="http://audio.rambler.ru/play.html?id=802">XIT FM RU<OPTION value="http://w02-sw01.akadostream.ru:8108/shanson48.mp3">Шансон Ru
<OPTION value="http://www.europaplus.ua/europaplus64.m3u">Euro Plus UA<OPTION value="http://real.svitonline.com/radio-melodia32k.m3u">Радио Мелодия
<OPTION value="http://radio.svitonline.com/radio-molode32k.m3u">Молоде радіо<OPTION value="http://radiostream.akado.ru/playlist/radio.m3u?station=europaplus&stream=128">Euro Plus Ru<OPTION value="http://radio.svitonline.com/radio-mfm32k.m3u">Радио МФМ<OPTION value="http://www.nashe.ua/radio.m3u">Наше Радио UA <OPTION value="http://ipfm.net/stolitsa_hi.m3u">Перец FM<OPTION value="http://www.prosto.fm/files/Prosto64.m3u">Просто Ради.О
<OPTION value="http://radio.svitonline.com/radio-stilnoe32k.m3u"> Шансон UA <OPTION value="http://sradio.tv/stream/215.m3u">Люкс FM
<OPTION value="http://217.194.240.240:8000/virusfm_64k.m3u">Virus FM <OPTION value="http://www.danceradio.ru/radio.m3u">MB DanceRadio
<OPTION value="http://audio.rambler.ru/play.html?id=1020">Маяк<OPTION value="http://audio.rambler.ru/play.html?id=1016">Милицейское
<OPTION value="http://www.nashe.ru/nashe-64.m3u">Наше Радио Ru<OPTION value="http://www.nu-clear.ru/streams/mp3-192.m3u">Чистое Радио
<OPTION value="http://audio.rambler.ru/play.html?id=808">Радио Попса<OPTION value="http://radiomania.rambler.ru/play.html?id=890">Радио 7
<OPTION value="http://81.177.16.221:2007/34.m3u">Радио Ома<OPTION value="http://roks.ru/air/roks_med.m3u">Радио РОКС<OPTION value="http://radiostream.akado.ru/playlist/radio.m3u?station=kissfm&stream=128">KISS FM<OPTION value="http://w02-sw01.akadostream.ru:8000/silverrain128.mp3.m3u">Серебряный дождь<OPTION value="http://audio.rambler.ru/play.html?id=1002">Эхо Москвы
<OPTION value="http://radiostream.akado.ru/playlist/radio.m3u?station=radioretro&stream=48">Ретро FM<OPTION value="mms://87.242.72.62/cityfm?WMBitrate=83200&WMContentBitrate=83200">Радио СИТИ-FM<OPTION value="http://realaudio.aradio.ru/autoradio/">Авторадио
<OPTION value="mms://87.242.72.62/relaxfm?WMBitrate=83200&WMContentBitrate=83200">Радио Relax FM</OPTION></SELECT></DIV><DIV id="mus" align="center"></DIV></br>
<script> function sel(href){ if(href=='') mus.innerHTML=""; else mus.innerHTML="<EMBED type=application/x-mplayer2 src="+href+" width=282 height=72  showcontrols=1 showdisplay=0 showstatusbar=1>" ; } sel(''); </script>
&nbsp;[<b>Комментатор</b>] Администрация virt-life.com приветствует Вас ! Желаем приятного общения, великих побед! Игра будет постоянно развиваться и дополняться !
    <HTML>
    <HEAD>
        <link rel=stylesheet type="text/css" href="i/main.css">
        <meta http-equiv="Content-type" content="text/html; charset=windows-1251">
        <SCRIPT LANGUAGE="JavaScript" SRC="i/ch.js"></SCRIPT>
        <SCRIPT LANGUAGE="JavaScript" SRC="i/sl2.js"></SCRIPT>
        <style type="text/css">


.hoversmile{
}

a.hoversmile:hover {
    /*border: solid black 1px;*/
    background-color:gray;
}

.ssm-smile {
   width:400px;
   height:140px;
   background-color:#f2f0f0;
   text-align: center;
   border: 2px groove black;
  opacity: 0.8; filter: alpha (opacity=80);
}
.ssm-smile-title {
  height:10px;
  font-size:120%;
  FONT-FAMILY:Tahoma;
  background:url(../i/smilestitle.gif);
  /*background-color:#6699FF; */
}
.ssm-smile-body {
  padding: 5px;
  overflow-y:scroll;
  height: 110px;
}

.menu {
  background-color: #d2d0d0;
  border-color: #ffffff #626060 #626060 #ffffff;
  border-style: solid;
  border-width: 1px;
  position: absolute;
  left: 0px;
  top: 0px;
  visibility: hidden;
}

.menuItem {
  border: 0px solid #000000;
  color: #003388;
  display: block;
  font-family: MS Sans Serif, Arial, Tahoma,sans-serif;
  font-size: 8pt;
  font-weight: bold;
  padding: 2px 12px 2px 8px;
  text-decoration: none;
  cursor:pointer;
}

.menuItem:hover {
  background-color: #a2a2a2;
  color: #0066FF;
}

span {
  FONT-SIZE: 10pt;
  FONT-FAMILY: Verdana, Arial, Helvetica, Tahoma, sans-serif;
  text-decoration: none;
  FONT-WEIGHT: bold;
  cursor: pointer;
}

.my_clip_button {   border: 0px solid #000000;
  color: #003388;
  display: block;
  font-family: MS Sans Serif, Arial, Tahoma,sans-serif;
  font-size: 8pt;
  font-weight: bold;
  padding: 2px 12px 2px 8px;
  text-decoration: none; }
.my_clip_button.hover { background-color: #a2a2a2; color: #0066FF; }

</style>
<SCRIPT>
function S(name){
    var sData = top.frames['bottom'].window.document;
    sData.F1.text.focus();
    sData.F1.text.value = sData.F1.text.value + ':'+name+': ';
}

function SSm(name){
        /* старое под IE;
        var sData = dialogArguments;
        sData.F1.text.focus();
        sData.F1.text.value = sData.F1.text.value + ':'+name+': ';*/
        ssminput=top.frames['bottom'].document.getElementById('ssmtext');
        ssminput.focus();
        ssminput.value+=':'+name+': ';
}

</SCRIPT>
    </head>
        <body leftmargin=0 topmargin=0 marginheight=0 marginwidth=0 bgcolor=#eeeeee onload="top.RefreshChat()">
        <div id=mes style="padding: 0px 0px 5px 0px;"></div>
    <!--    <DIV ID=oMenu CLASS=menu onmouseout="closeMenu()"></DIV>-->
        <DIV ID="oMenu"  onmouseout="closeMenu()" style="position:absolute; border:1px solid #666; background-color:#CCC; display:none; "></DIV>
<?php
// height:90%;
    }
    else {
?>
<HTML><HEAD><link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<SCRIPT LANGUAGE="JavaScript">
top.ChatTranslit = false;

var map_en = new Array('s`h','S`h','S`H','s`Х','sh`','Sh`','SH`',"'o",'yo',"'O",'Yo','YO','zh','w','Zh','ZH','W','ch','Ch','CH','sh','Sh','SH','e`','E`',"'u",'yu',"'U",'Yu',"YU","'a",'ya',"'A",'Ya','YA','a','A','b','B','v','V','g','G','d','D','e','E','z','Z','i','I','j','J','k','K','l','L','m','M','n','N','o','O','p','P','r','R','s','S','t','T','u','U','f','F','h','H','c','C','`','y','Y',"'")
var map_ru = new Array('сх','Сх','СХ','сХ','щ','Щ','Щ','ё','ё','Ё','Ё','Ё','ж','ж','Ж','Ж','Ж','ч','Ч','Ч','ш','Ш','Ш','э','Э','ю','ю','Ю','Ю','Ю','я','я','Я','Я','Я','а','А','б','Б','в','В','г','Г','д','Д','е','Е','з','З','и','И','й','Й','к','К','л','Л','м','М','н','Н','о','О','п','П','р','Р','с','С','т','Т','у','У','ф','Ф','х','Х','ц','Ц','ъ','ы','Ы','ь')

function convert(str)
{   for(var i=0;i<map_en.length;++i) while(str.indexOf(map_en[i])>=0) str = str.replace(map_en[i],map_ru[i]);
    return str;
}

function send(adm) {

document.write(adm); }

function translate() {  // translates latin to russian
    var strarr = new Array();
    strarr = document.F1.text.value.split(' ');
    for(var k=0;k<strarr.length;k++) {
        if(strarr[k].indexOf("http://") < 0 && strarr[k].indexOf('@') < 0 && strarr[k].indexOf("www.") < 0 && !(strarr[k].charAt(0)==":" && strarr[k].charAt(strarr[k].length-1)==":")) {
            if ((k<strarr.length-1)&&(strarr[k]=="to" || strarr[k]=="private")&&(strarr[k+1].charAt(0)=="[")) {
                while ( (k<strarr.length-1) && (strarr[k].charAt(strarr[k].length-1)!="]") ) k++;
            } else { strarr[k] = convert(strarr[k]) }
        }
    }
    document.F1.text.value = strarr.join(' ');
}


function sw_translit()
{
   top.ChatTranslit = ! top.ChatTranslit;
   if (top.ChatTranslit) {
       document.all('b___translit').src = b___translit_on.src;
       document.all('b___translit').alt = b___translit_on.alt;
   } else {
       document.all('b___translit').src = b___translit_off.src;
       document.all('b___translit').alt = b___translit_off.alt;
   }
}


function sw_filter()
{
   top.ChatOm = ! top.ChatOm;
   if (top.ChatOm) {
       document.all('b___filter').src = b___filter_on.src;
       document.all('b___filter').alt = b___filter_on.alt;
       document.F1.om.value = '1';
   } else {
       document.all('b___filter').src = b___filter_off.src;
       document.all('b___filter').alt = b___filter_off.alt;
       document.F1.om.value = '';
   }
}

function sw_sys()
{
   top.ChatSys = ! top.ChatSys;
   if (top.ChatSys) {
       document.all('b___sys').src = b___sys_on.src;
       document.all('b___sys').alt = b___sys_on.alt;
       document.F1.sys.value = '1';
   } else {
       document.all('b___sys').src = b___sys_off.src;
       document.all('b___sys').alt = b___sys_off.alt;
       document.F1.sys.value = '';
   }
}

function sw_slow()
{
   if (top.ChatSlow) {
     if (top.ChatTimerID >= 0) { // выключаем чат
         top.StopRefreshChat();
         document.all('b___slow').src = b___chat_off.src; document.all('b___slow').alt = b___chat_off.alt;
     } else { // Запускаем чат на нормальную скорость
         top.ChatSlow = false;
         top.ChatDelay=top.ChatNormDelay;
         top.RefreshChat();
         document.all('b___slow').src = b___slow_off.src; document.all('b___slow').alt = b___slow_off.alt;
     }
   } else { // замедляем чат
     top.ChatSlow = true;
     document.all('b___slow').src = b___slow_on.src; document.all('b___slow').alt = b___slow_on.alt;
     top.ChatDelay=top.ChatSlowDelay;
     top.RefreshChat();
   }
}

function subm()
{
if (top.ChatTranslit) translate();
}

var b___translit_on = new Image; b___translit_on.src="i/b___translit_on.gif"; b___translit_on.alt="(включено) Преобразовывать транслит в русский текст";
var b___translit_off = new Image; b___translit_off.src="i/b___translit_off.gif"; b___translit_off.alt="(выключено) Преобразовывать транслит в русский текст";
var b___filter_on = new Image; b___filter_on.src="i/b___filter_on.gif"; b___filter_on.alt="(включено) Показывать в чате только сообщения адресованные мне";
var b___filter_off = new Image; b___filter_off.src="i/b___filter_off.gif"; b___filter_off.alt="(выключено) Показывать в чате только сообщения адресованные мне";
var b___sys_on = new Image; b___sys_on.src="i/b___sys_on.gif"; b___sys_on.alt="(включено) Показывать в чате системные сообщения";
var b___sys_off = new Image; b___sys_off.src="i/b___sys_off.gif"; b___sys_off.alt="(выключено) Показывать в чате системные сообщения";
var b___slow_on = new Image; b___slow_on.src="i/b___slow_on.gif"; b___slow_on.alt="(включено) Медленное обновление чата (раз в минуту)";
var b___slow_off = new Image; b___slow_off.src="i/b___slow_off.gif"; b___slow_off.alt="(выключено) Медленное обновление чата (раз в минуту)";
var b___chat_off = new Image; b___chat_off.src="i/b___chat_off.gif"; b___chat_off.alt="Обновление чата выключено!";


function IsIE(elem){ //также эта функция есть выше
    //----------IE,FF,Opera----------------------------no support Safari, Chrome
    ss=top.frames['chat'].document.getElementById('mes').offsetHeight;
    if (ss>0 && (ss-140)>0) ss-=144;
        elem.style.position = 'absolute';
    elem.style.top=ss+'px';
}


function rslength() // изменяет размер строки ввода текста
{
    var size = document.body.clientWidth-(2*30)-31-59-256-18-30-30;
if (size<100) { size=100 }
document.F1.text.width = size;
document.all('T2').width = size;
}


function clearc()
{
    //alert("!!");
    if (document.forms[0].text.value == '') {
        if(confirm('Очистить окно чата?')) top.frames['chat'].document.all("mes").innerHTML='';
        } else { document.F1.text.value=''; }

    document.F1.text.focus();
}

window.onresize=rslength;

</SCRIPT>

<script language="VBScript">
sub flashsound_FSCommand(byval command, byval args)
call flashsound_DoFSCommand(command, args)
end sub
</script>

<SCRIPT language=JavaScript>
function flashsound_DoFSCommand(command, args) {
    top.frames['bottom'].document.getElementById('soundM').innerHTML='';
}

function SoundB(){
    if (top.SoundOff==true)
        top.frames['bottom'].document.getElementById('but_sound').src='i/zvuk.gif';
    else top.frames['bottom'].document.getElementById('but_sound').src='i/zvuk_off.gif';
    top.SoundOff=!top.SoundOff;
}
</SCRIPT>



</HEAD>
<body leftmargin=0 topmargin=0 marginheight=0 marginwidth=0 bgcolor=#E6E6E6 onload="top.strt(); rslength();" onfocus="document.forms[0].text.focus()">
<FORM action="ch.php" target="refreshed" method=GET name="F1" onsubmit="subm(); top.NextRefreshChat();">
<INPUT TYPE="hidden" name="color" value="000000">
<INPUT TYPE="hidden" name="sys" value="">
<INPUT TYPE="hidden" name="om" value="">
<INPUT TYPE="hidden" name="lid" value="">

<table width="100%" height="30" cellspacing="0" cellpadding="0">
    <tr valign="top" style="background-image:url(/i/move/beg_chat_03.gif); background-position: top; background-repeat:repeat-x; ">
      <td width="9"><img src="/i/move/bkf_l_r1_02.gif" width="9" height="30"></td>
<td width="30"><IMG SRC="i/b___.gif" WIDTH=30 HEIGHT=30 BORDER=0 ALT="Чат"></td>

<div id="soundM" style="position:absoluite;"></div>



<td valign="middle" id="T2"><input type="text" id="ssmtext" name="text" maxlength="200" size=80 style="width:100%"></TD>
<td nowrap id="T3"><a href="javascript:void(0)" onclick="if (top.ChatTranslit) {translate();}document.forms[0].submit()" title="Добавить текст в чат"><IMG SRC="i/b___ok.gif" WIDTH=30 HEIGHT=30 BORDER=0 ALT="Добавить текст в чат"></a><IMG SRC="Reg/1x1.gif" WIDTH="8" HEIGHT="1" BORDER=0 ALT=""><a href="javascript:void(0)" onclick="clearc();" title="Очистить строку ввода"><IMG SRC="i/b___clear.gif" WIDTH=30 HEIGHT=30 BORDER=0 ALT="Очистить строку ввода"></a><a href="javascript:void(0)" onclick="sw_filter();" title="(выключено) Показывать в чате только сообщения адресованные мне"><IMG SRC="i/b___filter_off.gif" WIDTH=30 HEIGHT=30 BORDER=0 name="b___filter" ALT="(выключено) Показывать в чате только сообщения адресованные мне"></a><a href="javascript:void(0)" onclick="sw_sys();" title="(выключено) Показывать в чате системные сообщения"><IMG SRC="i/b___sys_off.gif" WIDTH=30 HEIGHT=30 BORDER=0 name="b___sys" ALT="(выключено) Показывать в чате системные сообщения"></a><a href="javascript:void(0)" onclick="sw_slow();" title="(выключено) Медленное обновление чата (раз в минуту)"><IMG SRC="i/b___slow_off.gif" WIDTH=30 HEIGHT=30 BORDER=0 name="b___slow" ALT="(выключено) Медленное обновление чата (раз в минуту)"></a><img src="i/b___translit_off.gif" alt="(выключено) Преобразовывать транслит в русский текст (правила перевода см. в энциклопедии)" name="b___translit" width="30" height="30" id="b___translit" style="cursor: hand;" onclick="sw_translit();"><a href="javascript:void(0)" onclick="SoundB()" title="Звуки"><IMG SRC="i/zvuk_off.gif" id="but_sound" WIDTH=30 HEIGHT=30 BORDER=0></a><a href="javascript:void(0)" onclick="smiles()" title="Смайлики"><IMG SRC="Reg/1x1.gif" WIDTH="8" HEIGHT="1" BORDER=0 ALT=""><IMG SRC="i/b___smile.gif" WIDTH=30 HEIGHT=30 BORDER=0 ALT="Смайлики"></a><IMG SRC="/i/misc/qlaunch/b___cl1.gif" WIDTH=30 HEIGHT=30 BORDER=0 ALT="Смайлики"></TD>
<td width="19" id="T4" background="/i/b___bg2.gif"><img src="i/b___1.gif" width="19" height="30" alt="" /></td>
<td align="right" nowrap="nowrap" bgcolor="BAB7B3" id="T5" background="/i/b___bg2.gif">

<?php

        echo "<a href=\"javascript:void(0)\" title=\"Настройки/Инвентарь\"><IMG SRC=\"i/a___inv.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Настройки/Инвентарь\" onclick=\"top.cht('main.php?edit='+Math.random())\"></a>";
    if ($user['level']>=4) {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('give.php')\" title=\"Передачи\"><IMG SRC=\"i/b__give.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Передачи\" ></a>";
    }
        echo "<a href=\"javascript:void(0)\" title=\"Алхимики онлайн\"><IMG SRC=\"i/a___dlr.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Алхимики онлайн\" onclick=\"top.cht('dealer.php')\"></a>";
    if ($user['level']>=6) {
        echo "<a href=\"javascript:void(0)\" title=\"Путь\"><IMG SRC=\"i/a___ang.png\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Путь\" onclick=\"top.cht('/angel.html')\"></a>";
    }
     if ($user['vip']==1)  {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('vip.php')\" title=\"ViP Панель\"><IMG SRC=\"i/a___vip.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"ViP Панель\"></a>";
    }
    if (($user['align']>2) && ($user['align']<3))  {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('a.php')\" title=\"Панель Ангела\"><IMG SRC=\"i/a___haos.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Панель Ангела\"></a>";
    }
    if (($user['align']>1) && ($user['align']<2)) {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('palklan.php?'+Math.random())\" title=\"Клан\"><IMG SRC=\"i/clan.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Клан\"></a>";
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('orden.php')\" title=\"Склонность\"><IMG SRC=\"i/a___pal.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Склонность\"></a>";
    }
    if (in_array($_SESSION['uid'], $smalladms)) echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('orden.php')\" title=\"Склонность\"><IMG SRC=\"i/a___pal.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Склонность\"></a>";

    if (($user['align']>3) && ($user['align']<4)) {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('orden.php')\" title=\"Склонность\"><IMG SRC=\"i/b__orden.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Склонность\"></a>";
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('tarklan.php?'+Math.random())\" title=\"Клан\"><IMG SRC=\"i/clan.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Клан\"></a>";
            }
    if ($user['deal']==5 OR ($user['align']>=0.98 && $user['align']<0.99))  {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('orden.php')\" title=\"Склонность\"><IMG SRC=\"i/b__orden.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Склонность\"></a>";
    }
    if ($user['align']==0.99)  {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('orden.php')\" title=\"Склонность\"><IMG SRC=\"i/b__light.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Склонность\"></a>";
    }
    if ($user['align']==7 OR $user['align']==7.001 OR $user['align']==7.002)  {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('orden.php')\" title=\"Склонность\"><IMG SRC=\"i/b__neit.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Склонность\"></a>";
    }
    if ($user['align']==10 OR $user['login']==Модератор)  {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('orden.php')\" title=\"Склонность\"><IMG SRC=\"i/b__otm.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Склонность\"></a>";
    }
    if ($user['klan']) {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('klan1.php?'+Math.random())\" title=\"Клан\"><IMG SRC=\"i/clan.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Клан\"></a>";
    }
    if ($user['align']==2.5 || $user['align']==2.7 || $user['align']==77 || $user['align']==2.6)  {
    echo "<a href=\"javascript:void(0)\" title=\"Орден Чести\"><IMG SRC=\"i/a___chest.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Орден Чести\" onclick=\"top.cht('ordenchesti.php')\"></a>";
    }
    if ($user['level']>=0)  {
    echo "<a href=\"javascript:void(0)\" title=\"Друзья\"><IMG SRC=\"i/a___friend3.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Друзья\" onclick=\"top.cht('friend.php')\"></a>";
    }
?>
<a href="javascript:void(0)" title="Выход из игры"><IMG SRC="i/a___ext.gif" WIDTH=30 HEIGHT=30 BORDER=0 ALT="Выход из игры" onclick="if (confirm('Выйти из игры?')) top.window.location='index.php?exit=0.560057875997465'"></a></TD>
<td width="70" valign="middle" background="/i/b___bg2.gif" bgcolor="BAB7B3" id="T6">
<script>
    var html='';
        if (navigator.userAgent.match(/MSIE/)) {
            // IE gets an OBJECT tag
            html += '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="70" height="26"><param name="movie" value="i/clock.swf?hours=<?=date("H")?>&minutes=<?=date("i")?>&sec=<?=date("s")?>" /><param name="quality" value="high" /></object>';
        }
        else {
            // all other browsers get an EMBED tag
            html += '<embed src="i/clock.swf?hours=<?=date("H")?>&minutes=<?=date("i")?>&sec=<?=date("s")?>" quality="best" width="70" height="26" allowScriptAccess="always" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />';
        }
        document.write(html);
</script>
</td>
<td width="9" valign="middle" background="/i/b___bg2.gif" bgcolor="BAB7B3"><img src="/i/move/bkf_l_r1_06.gif" width="9" height="30"></td>

</TR>
</TABLE>

<SCRIPT language="JavaScript">
var user = top.getCookie("ChatColor");
if ((user != null)&&(user != "")) document.F1.color.value = user;
document.F1.text.focus();
function smiles(){
if (document.all && document.all.item && !window.opera && !document.layers){
    //rof IE only
   var x = event.screenX - 150;
   var y = event.screenY - 320;
   var sFeatures = 'dialogLeft:'+x+'px;dialogTop:'+y+'px;dialogHeight:310px;dialogWidth:300px;help:no;status:no;unadorned:yes';
   window.showModelessDialog("smiles.html", window, sFeatures);
}
else{ //все остальные браузеры
//смайлы лежать здесь, в ch.php и ch2.91.js
var sm=['001','005','007','006','010','018','022','019','026','034','033','037','038','036','040','039','043','049','052','056','059','057','062','066','068','073','082','080','079','083','086','085','114','118','119','123','161','158','164','167','166','170','174','177','175','179','178','186','189','188','190','202','205','203','206','221','237','239','238','243','246','254','253','255','277','276','275','278','284','289','288','294','293','295','310','313','324','336','347','346','345','348','349','351','352','361','362','366','367','382','393','411','415','413','419','422','434','442','447','453','467','471','472','475','551','554','559','564','568','573','600','601','602','603','604','605','606','607','608','609','610','611','612','613','614','615','616','617','618','619','620','621','622','000','029','030','077','126','127','131','155','156','267','297','319','350','353','354','357','358','368','376','385','386','414','417','457','459','469','473','474','477','552','558','560','570','574','575','576','579','950','951','952','953','954','955','956','957','958','959','960','002','003','004','008','009','011','012','013','014','015','016','021','023','024','025','027','028','031','032','623','624','625','626','627','628','629','630','631','632','633','634','635','636','637','638','639','640','641','642','643','644','645','646','647','648','650','651','652','653','654','655','656','657'];

    function createMessage(title, body) {
        var container = document.createElement('div');
        var i=0;
        body='';
        while(i<sm.length){
            var s = sm[i++];
            //javascript:top.AddToPrivate('Baks', top.CtrlPress)
            body +='<a class="hoversmile" href="javascript:void(0)" onClick="SSm(\''+s+'\')"><IMG SRC=i/smiles/smiles_'+s+'.gif BORDER=0 ALT="" ></a>';
        }
        //container.innerHTML = '<div id="ssmsmilediv" class="ssm-smile"><div class="ssm-smile-title">'+title+'</div><div class="ssm-smile-body">'+body+'</div><input class="ssm-smile-ok" type="button" value="Закрыть"/></div>';
        container.innerHTML = '<div id="ssmsmilediv" class="ssm-smile"><div class="ssm-smile-body">'+body+'</div><input class="ssm-smile-ok" type="button" value="Закрыть"/></div>';

        return container.firstChild;
    }

    function positionMessage(elem) {
        var ua = navigator.userAgent.toLowerCase();
        // Определим Internet Explorer
        if (ua.indexOf("msie") != -1 && ua.indexOf("opera") == -1 && ua.indexOf("webtv") == -1) {
            IsIE(elem);
         }
        else{
            //------------all browser------------------not support IE
            elem.style.position = 'fixed';
            elem.style.bottom =0+'px';
        }

        elem.style.right = 2+'px';
    }

    function addCloseOnClick(messageElem) {
        var input = messageElem.getElementsByTagName('INPUT')[0];
        input.onclick = function() {
            messageElem.parentNode.removeChild(messageElem);
        }
    }

    function setupMessageButton(title, body) {
        var messageElem = createMessage(title, body);
        positionMessage(messageElem);
        addCloseOnClick(messageElem);
        top.frames['chat'].document.body.appendChild(messageElem);
    }
    try{
        el=top.frames['chat'].document.getElementById('ssmsmilediv');
        el.parentNode.removeChild(el);
    }
    catch(err){
    }
    setupMessageButton('Смайлики ;)', '');
}
}
</SCRIPT>
</FORM>
<?php
}
?>
</body>
</html>

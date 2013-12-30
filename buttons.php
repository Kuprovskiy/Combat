<?php
header ("Content-type: text/html; charset=windows-1251");
session_start();
if (@$_SESSION['uid'] == null) header("Location: index.php");
include "connect.php";
$user = mysql_fetch_array(mq("SELECT id,level,vip,align,admin,deal,login,klan FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
header("Cache-Control: no-cache");
$inclan=mqfa1("select klan from users where id='$_SESSION[uid]'");
if ($_GET['ch'] != null){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<script LANGUAGE='JavaScript'> 
document.ondragstart = test;
document.oncontextmenu = test;
function test() {
 return false
}
</SCRIPT>
<!--<DIV style="POSITION: absolute" class=TabTabsLayer align=right>
<TABLE border=0 cellSpacing=0 cellPadding=0>
<TBODY>
<TR>
<TD class=TabCrossingSF><IMG style="DISPLAY: none" width=8 height=18></TD>
<TD style="WIDTH: 29px" class=TabTextS align=right oTable="undefined" sName="chat" nWidth="1008" nHeight="260" nOrder="0" bSelected="true"><NOBR>Чат</NOBR></TD>
<TD class=TabCrossingS oTable="undefined"><IMG style="DISPLAY: none" width=8 height=18></TD>
<TD style="WIDTH: 157px" class=TabText align=right oTable="undefined" sName="syslog" nWidth="1008" nHeight="260" nOrder="1" bSelected="false"><NOBR>Системные сообщения</NOBR></TD>
<TD class=TabCrossingE oTable="undefined"><IMG style="DISPLAY: none" width=8 height=18></TD></TR></TBODY></TABLE></DIV>-->
<HTML>
<HEAD>
<link rel=stylesheet type="text/css" href="<?=IMGBASE?>/i/main.css">
<meta http-equiv="Content-type" content="text/html; charset=windows-1251">
<SCRIPT LANGUAGE="JavaScript" SRC="<?=IMGBASE?>/i/ch.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="<?=IMGBASE?>/i/sl2.js"></SCRIPT>
<style type="text/css">
.hoversmile{
}
a.hoversmile:hover {
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
  background:url(<?=IMGBASE?>/i/smilestitle.gif);
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
.actbt
{
cursor: default; font-size: 10pt; color: #000; font-weight: bold;  height: 18px; text-align: center; font-family: Arial; top: 0px; background-image: url(test/active_bg.gif);
}
.nactbt
{
cursor: default; font-size: 10pt; height: 18px; color: #fff; text-align: center; font-family: Arial; top: 0px; background-image: url(test/nonact_bg.gif);
}
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
function clickbut(but_name) {
        document.getElementById('td_sys').style.backgroundImage = "url(test/nonact_bg.gif)";
        document.getElementById('td_sys').style.color = "#ffffff";
        document.getElementById('td_sys').style.fontWeight = "normal";
        document.getElementById('td_all').style.backgroundImage = "url(test/nonact_bg.gif)";
        document.getElementById('td_all').style.color = "#ffffff";
        document.getElementById('td_all').style.fontWeight = "normal";
        document.getElementById('td_log').style.backgroundImage = "url(test/nonact_bg.gif)";
        document.getElementById('td_log').style.color = "#ffffff";
        document.getElementById('td_log').style.fontWeight = "normal";
        document.getElementById('td_clan').style.backgroundImage = "url(test/nonact_bg.gif)";
        document.getElementById('td_clan').style.color = "#ffffff";
        document.getElementById('td_clan').style.fontWeight = "normal";
    document.getElementById('ch1').innerHTML = "<img src=test/nonact_left.gif>";
    document.getElementById('ch2').innerHTML = "<img src=test/a_0.gif>";
    document.getElementById('ch3').innerHTML = "<img src=test/a_0.gif>";
    document.getElementById('ch4').innerHTML = "<img src=test/a_0.gif>";
    document.getElementById('ch7').innerHTML = "<img src=test/nonact_right.gif>";
    if (but_name == 'all') {
      document.getElementById('ch1').innerHTML = "<img src=test/active_left.gif>";
      document.getElementById('ch2').innerHTML = "<img src=test/a_l.gif>";
      document.getElementById('mes_sys').style.display = "none";
      document.getElementById('mes').style.display = "inline";
      document.getElementById('logs').style.display = "none";
      document.getElementById('mes_clan').style.display = "none";
    } else if (but_name == 'sys')  {
      document.getElementById('ch2').innerHTML = "<img src=test/a_r.gif>";
      if (document.getElementById('td_log').style.display=='none') {
        document.getElementById('<?
          if ($inclan) echo "ch4"; else echo "ch7";
        ?>').innerHTML = "<img src=test/<?
          if ($inclan) echo "a_l"; else echo "active_right";
        ?>.gif>";        
      } else {
        document.getElementById('<?
          if ($inclan) echo "ch4"; else echo "ch3";
        ?>').innerHTML = "<img src=test/a_l.gif>";
      }
      document.getElementById('mes').style.display = "none";
      document.getElementById('mes_sys').style.display = "inline";
      document.getElementById('logs').style.display = "none";
      document.getElementById('mes_clan').style.display = "none";
    } else if (but_name == 'log')  {
      document.getElementById('ch3').innerHTML = "<img src=test/a_r.gif>";
      document.getElementById('ch7').innerHTML = "<img src=test/active_right.gif>";
      document.getElementById('mes').style.display = "none";
      document.getElementById('mes_sys').style.display = "none";
      document.getElementById('logs').style.display = "inline";
      document.getElementById('mes_clan').style.display = "none";
    } else if (but_name == 'clan')  {
      document.getElementById('ch4').innerHTML = "<img src=test/a_r.gif>";
      if (document.getElementById('td_log').style.display=='none') {
        document.getElementById('ch7').innerHTML = "<img src=test/active_right.gif>";
      } else {
        document.getElementById('ch3').innerHTML = "<img src=test/a_l.gif>";
      }
      document.getElementById('mes').style.display = "none";
      document.getElementById('mes_sys').style.display = "none";
      document.getElementById('mes_clan').style.display = "inline";
      document.getElementById('logs').style.display = "none";
    }                      
    document.getElementById('td_' + but_name).style.backgroundImage = "url(test/active_bg.gif)";
    document.getElementById('td_' + but_name).style.color = "#000000";
    document.getElementById('td_' + but_name).style.fontWeight = "bold";
  if (but_name == 'log') window.scrollTo(0,0);
  else window.scrollBy(0,10000);
}
</SCRIPT>
</head>
<body leftmargin=0 topmargin=0 marginheight=0 marginwidth=0 bgcolor=#eeeeee onload="top.RefreshChat()">
<div style="z-index:100; position: fixed; top: 0px; right: 0px;"><table border=0 cellspacing=0 cellpadding=0><tr>
<td style="width:10px"><div id="ch1"><img src="test/active_left.gif"></div></td>
<td style="width:38px" valign="top"><div class="actbt" id="td_all" onclick="clickbut('all');">Чат</div>
</td>
<td style="width: 10px;"><div id="ch2" ><img src="test/a_l.gif"></div></td>
<td style="width:160px;" valign="top"><div class="nactbt" id="td_sys" onclick="clickbut('sys');">Системные&nbsp;сообщения</div></td>
<td style="width:10px;<? if (!$inclan) echo "display:none"; ?>"><div id="ch4" ><img src="test/a_0.gif"></div></td>
<td style="<? if (!$inclan) echo "display:none"; else echo "width:80px"; ?>" valign="top"><div class="nactbt" id="td_clan" onclick="clickbut('clan');">Клан-чат</div></td>
<td style="display:none;width:10px" id="ch3"><img src="test/a_0.gif"></td>
<td valign="top"><div style="display:none;width:50px" id="td_log" class="nactbt" onclick="clickbut('log');" valign="top">Лог&nbsp;боя</div>
</td>
<td>
<div id="ch7"><img src="test/nonact_right.gif"></div>
</td></tr></table></div>
<div id="mes" style="visibility:visible; width:100%; z-index:0; top:25px; left:0px; position:absolute;padding-bottom:5px">
<?php
$lastIPs = mqfaa("SELECT ip FROM iplog WHERE owner = $user[id] ORDER BY date DESC limit 2");
if (count($lastIPs) == 2 && $lastIPs[0]['ip'] != $lastIPs[1]['ip']) {
echo '<b style="color: red">Внимание!</b> ' . date('d.m.Y H:i') . ' <b style="color: red">ВНИМАНИЕ!</b> В предыдущий раз этим персонажем заходили с другого компьютера.<br>';
}
?>
</div>
<div id="mes_sys" style="visibility:visible; width:100%; z-index:0; top:18px; left:0px; position:absolute; display:none;padding-bottom:5px"></div>
<div id="mes_clan" style="visibility:visible; width:100%; z-index:0; top:18px; left:0px; position:absolute; display:none;padding-bottom:5px"></div>
<div id="logs" style="visibility:visible; width:100%; z-index:0; top:18px; left:0px; position:absolute; display:none;padding-bottom:5px;padding-top:10px"></div>
<DIV ID="oMenu"  onmouseout="closeMenu()" style="position:absolute; border:1px solid #666; background-color:#CCC; display:none; "></DIV>
<DIV ID="oMenu"  onmouseout="closeMenu()" style="position:absolute; border:1px solid #666; background-color:#CCC; display:none; "></DIV>
<?php
} else {
  if((int)date("H") > 5 && (int)date("H") < 22) $now="chat";
  else $now="chat";
  if (date("H") <=5) {
    $tme=mktime(6, 1,0);
  } elseif (date("H")<22) {
    $tme=mktime(22, 1,0);
  } else {
    $tme=mktime (6, 1, 0, date("n"), date("j")+1,0);
  }
  $left=$tme-time();
?>
<HTML>
<HEAD>
<link rel=stylesheet type="text/css" href="<?=IMGBASE?>/i/main.css">
<script>
function refr() {
  if (document.F1.text.value=='') {
    document.location.href='<?=$_SERVER["PHP_SELF"]?>?<?=time()?>';
  } else {
    setTimeout('refr()',1000);
  }
}
setTimeout('refr()',<?=($left*1000)?>);
</script>
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
     if (top.ChatTimerID >= 0 && 0) { // выключаем чат
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
var b___translit_on = new Image; b___translit_on.src="<?=IMGBASE?>/i/<?=$now?>/b___translit_on.gif"; b___translit_on.alt="(включено) Преобразовывать транслит в русский текст";
var b___translit_off = new Image; b___translit_off.src="<?=IMGBASE?>/i/<?=$now?>/b___translit_off.gif"; b___translit_off.alt="(выключено) Преобразовывать транслит в русский текст";
var b___filter_on = new Image; b___filter_on.src="<?=IMGBASE?>/i/<?=$now?>/b___filter_on.gif"; b___filter_on.alt="(включено) Показывать в чате только сообщения адресованные мне";
var b___filter_off = new Image; b___filter_off.src="<?=IMGBASE?>/i/<?=$now?>/b___filter_off.gif"; b___filter_off.alt="(выключено) Показывать в чате только сообщения адресованные мне";
var b___sys_on = new Image; b___sys_on.src="<?=IMGBASE?>/i/<?=$now?>/b___sys_on.gif"; b___sys_on.alt="(включено) Показывать в чате системные сообщения";
var b___sys_off = new Image; b___sys_off.src="<?=IMGBASE?>/i/<?=$now?>/b___sys_off.gif"; b___sys_off.alt="(выключено) Показывать в чате системные сообщения";
var b___slow_on = new Image; b___slow_on.src="<?=IMGBASE?>/i/<?=$now?>/b___slow_on.gif"; b___slow_on.alt="(включено) Медленное обновление чата (раз в минуту)";
var b___slow_off = new Image; b___slow_off.src="<?=IMGBASE?>/i/<?=$now?>/b___slow_off.gif"; b___slow_off.alt="(выключено) Медленное обновление чата (раз в минуту)";
var b___chat_off = new Image; b___chat_off.src="<?=IMGBASE?>/i/<?=$now?>/b___chat_off.gif"; b___chat_off.alt="Обновление чата выключено!";
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
        if(confirm('Очистить окно чата?')) {
          top.frames['chat'].document.all("mes").innerHTML='';
          top.frames['chat'].document.all("mes_sys").innerHTML='';
        }
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
        top.frames['bottom'].document.getElementById('but_sound').src='<?=IMGBASE?>/i/<?=$now?>/zvuk.gif';
    else top.frames['bottom'].document.getElementById('but_sound').src='<?=IMGBASE?>/i/<?=$now?>/zvuk_off.gif';
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
<tr valign="top" style="background-image:url(<?=IMGBASE?>/i/<?=$now?>/beg_chat_03.gif); background-position: top; background-repeat:repeat-x; ">
<td width="9"><img src="<?=IMGBASE?>/i/<?=$now?>/bkf_l_r1_02.gif" width="9" height="30"></td>
<td width="30"><IMG SRC="<?=IMGBASE?>/i/<?=$now?>/b___.gif" WIDTH=30 HEIGHT=30 BORDER=0 ALT="Чат"></td>
<div id="soundM" style="position:absoluite;"></div>
<div id="soundM2" style="position:absoluite;"></div>
<td valign="middle" id="T2"><input type="text" id="ssmtext" name="text" maxlength="300" size=80 style="width:100%"></TD>
<td nowrap id="T3"><a href="javascript:void(0)" onclick="if (top.ChatTranslit) {translate();}document.forms[0].submit()" title="Добавить текст в чат"><IMG SRC="<?=IMGBASE?>/i/<?=$now?>/b___ok.gif" WIDTH=30 HEIGHT=30 BORDER=0 ALT="Добавить текст в чат"></a><IMG SRC="<?=IMGBASE?>/Reg/1x1.gif" WIDTH="8" HEIGHT="1" BORDER=0 ALT=""><a href="javascript:void(0)" onclick="clearc();" title="Очистить строку ввода"><IMG SRC="<?=IMGBASE?>/i/<?=$now?>/b___clear.gif" WIDTH=30 HEIGHT=30 BORDER=0 ALT="Очистить строку ввода"></a><a href="javascript:void(0)" onclick="sw_filter();" title="(выключено) Показывать в чате только сообщения адресованные мне"><IMG SRC="<?=IMGBASE?>/i/<?=$now?>/b___filter_off.gif" WIDTH=30 HEIGHT=30 BORDER=0 name="b___filter" ALT="(выключено) Показывать в чате только сообщения адресованные мне"></a><a href="javascript:void(0)" onclick="sw_sys();" title="(выключено) Показывать в чате системные сообщения"><IMG SRC="<?=IMGBASE?>/i/<?=$now?>/b___sys_off.gif" WIDTH=30 HEIGHT=30 BORDER=0 name="b___sys" ALT="(выключено) Показывать в чате системные сообщения"></a><a href="javascript:void(0)" onclick="sw_slow();" title="(выключено) Медленное обновление чата (раз в минуту)"><IMG SRC="<?=IMGBASE?>/i/<?=$now?>/b___slow_off.gif" WIDTH=30 HEIGHT=30 BORDER=0 name="b___slow" ALT="(выключено) Медленное обновление чата (раз в минуту)"></a><img src="<?=IMGBASE?>/i/<?=$now?>/b___translit_off.gif" alt="(выключено) Преобразовывать транслит в русский текст (правила перевода см. в энциклопедии)" name="b___translit" width="30" height="30" id="b___translit" style="cursor: hand;" onclick="sw_translit();"><a href="javascript:void(0)" onclick="SoundB()" title="Звуки"><IMG SRC="<?=IMGBASE?>/i/<?=$now?>/zvuk_off.gif" id="but_sound" WIDTH=30 HEIGHT=30 BORDER=0></a><a href="javascript:void(0)" onclick="smiles()" title="Смайлики"><IMG SRC="<?=IMGBASE?>/Reg/1x1.gif" WIDTH="8" HEIGHT="1" BORDER=0 ALT=""><IMG SRC="<?=IMGBASE?>/i/<?=$now?>/b___smile.gif" WIDTH=30 HEIGHT=30 BORDER=0 ALT="Смайлики"></a>
<IMG title="Избранное" SRC="<?=IMGBASE?>/i/<?=$now?>/b___cl1.gif" style="cursor:pointer" onclick="top.cht('main.php?edit=1&razdel=8&'+Math.random())" WIDTH=30 HEIGHT=30 BORDER=0 ALT="">
</TD>
<td width="19" id="T4" background="<?=IMGBASE?>/i/b___bg2.gif"><img src="<?=IMGBASE?>/i/<?=$now?>/b___1.gif" width="19" height="30" alt="" /></td>
<td align="right" nowrap="nowrap" bgcolor="BAB7B3" id="T5" background="<?=IMGBASE?>/i/<?=$now?>/b___bg2.gif">
<?php
    echo "<a href=\"javascript:void(0)\" title=\"Настройки/Инвентарь\"><IMG SRC=\"".IMGBASE."/i/$now/a___inv.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Настройки/Инвентарь\" onclick=\"top.cht('main.php?edit='+Math.random())\"></a>";
        if ($user['level']>=8) {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('give.php')\" title=\"Передачи\"><IMG SRC=\"".IMGBASE."/i/$now/b__give.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Передачи\" ></a>";
    }
        echo "<a href=\"javascript:void(0)\" title=\"Алхимики онлайн\"><IMG SRC=\"".IMGBASE."/i/$now/a___dlr.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Алхимики онлайн\" onclick=\"top.cht('dealer.php')\"></a>";

     if ($user['vip']==1)  {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('vip.php')\" title=\"ViP Панель\"><IMG SRC=\"".IMGBASE."/i/$now/a___vip.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"ViP Панель\"></a>";
    }
     if ($user['vip']==5)  {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('vips.php')\" title=\"ViP Панель\"><IMG SRC=\"".IMGBASE."/i/$now/a___vip.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"ViP Панель\"></a>";
    }
     if ($user['admin']==1)  {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('admin.php')\" title=\"Админ Панель\"><IMG SRC=\"".IMGBASE."/i/$now/admin.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Админ Панель\"></a>";
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('php.php')\" title=\"Нагрузка Сервера\"><IMG SRC=\"".IMGBASE."/i/$now/php.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Нагрузка Сервера\"></a>";
     }
    if (($user['align']>2) && ($user['align']<3))  {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('who.php')\" title=\"Кто Где\"><IMG SRC=\"".IMGBASE."/i/$now/who.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Кто Где\"></a>";
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('palklan.php')\" title=\"Орден Света\"><IMG SRC=\"".IMGBASE."/i/$now/clanpal.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Орден Света\"></a>";
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('tarklan.php')\" title=\"Тарманы\"><IMG SRC=\"".IMGBASE."/i/$now/clantar.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Тарманы\"></a>";
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('cpanel.php')\" title=\"Панель Ангела\"><IMG SRC=\"".IMGBASE."/i/$now/a___ang.png\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Панель Ангела\"></a>";
    }
    if ((($user['align']>1) && ($user['align']<2)) || ($inclan=="Radminion")) {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('palklan.php?'+Math.random())\" title=\"Клан\"><IMG SRC=\"".IMGBASE."/i/$now/clan.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Клан\"></a>";
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('orden.php')\" title=\"Склонность\"><IMG SRC=\"".IMGBASE."/i/$now/a___pal.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Склонность\"></a>";
    }
    if ((($user['align']>3) && ($user['align']<4)) || ($inclan=="Radminion")) {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('orden.php')\" title=\"Склонность\"><IMG SRC=\"".IMGBASE."/i/$now/b__orden.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Склонность\"></a>";
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('tarklan.php?'+Math.random())\" title=\"Клан\"><IMG SRC=\"".IMGBASE."/i/$now/clan.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Клан\"></a>";
            }
    if ($user['deal']==5 OR ($user['align']>=0.98 && $user['align']<0.99))  {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('orden.php')\" title=\"Склонность\"><IMG SRC=\"".IMGBASE."/i/$now/b__orden.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Склонность\"></a>";
    }
    if ($user['align']==0.99)  {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('orden.php')\" title=\"Склонность\"><IMG SRC=\"".IMGBASE."/i/$now/b__light.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Склонность\"></a>";
    }
    if ($user['align']==7 || $user['align']==7.001 || $user['align']==7.002 || $user['align']==7.003 || $user['align']==7.004)  {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('orden.php')\" title=\"Склонность\"><IMG SRC=\"".IMGBASE."/i/$now/b__neit.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Склонность\"></a>";
    }
    if ($user['align']==10 OR $user['align']==10.1)  {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('orden.php')\" title=\"Склонность\"><IMG SRC=\"".IMGBASE."/i/$now/b__otm.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Склонность\"></a>";
    }
    if ($user['klan']) {
        echo "<a href=\"javascript:void(0)\" onclick=\"top.cht('klan1.php?'+Math.random())\" title=\"Клан\"><IMG SRC=\"".IMGBASE."/i/$now/clan.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Клан\"></a>";
    }
    if ($user['level']>=1)  {
    echo "<a href=\"javascript:void(0)\" title=\"Друзья\"><IMG SRC=\"".IMGBASE."/i/$now/a___friend3.gif\" WIDTH=30 HEIGHT=30 BORDER=0 ALT=\"Друзья\" onclick=\"top.cht('friend.php')\"></a>";
    }
?>
<a href="javascript:void(0)" title="Выход из игры"><IMG SRC="<?=IMGBASE?>/i/<?=$now?>/a___ext.gif" WIDTH=30 HEIGHT=30 BORDER=0 ALT="Выход из игры" onclick="if (confirm('Выйти из игры?')) top.window.location='index.php?exit=0.560057875997465'"></a></TD>
<td width="70" valign="middle" background="<?=IMGBASE?>/i/<?=$now?>/b___bg2.gif" bgcolor="BAB7B3" id="T6">
<script>
    var html='';
        if (navigator.userAgent.match(/MSIE/)) {
            // IE gets an OBJECT tag
            html += '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="70" height="26"><param name="movie" value="<?=IMGBASE?>/i/clock.swf?hours=<?=date("H")?>&minutes=<?=date("i")?>&sec=<?=date("s")?>" /><param name="quality" value="high" /></object>';
        }
        else {
            // all other browsers get an EMBED tag
            html += '<embed src="<?=IMGBASE?>/i/clock.swf?hours=<?=date("H")?>&minutes=<?=date("i")?>&sec=<?=date("s")?>" quality="best" width="70" height="26" allowScriptAccess="always" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />';
        }
        document.write(html);
</script>
</td>
<td width="9" valign="middle" background="<?=IMGBASE?>/i/<?=$now?>/b___bg2.gif" bgcolor="BAB7B3"><img src="<?=IMGBASE?>/i/<?=$now?>/bkf_l_r1_06.gif" width="9" height="30"></td>
</TR>
</TABLE>
<SCRIPT language="JavaScript">
var user = top.getCookie("ChatColor");
if ((user != null)&&(user != "")) document.F1.color.value = user;
document.F1.text.focus();
function smiles(){
if (document.all && document.all.item && !window.opera && !document.layers){
	   var x = event.screenX - 0;
	   var y = event.screenY - 0;
   var sFeatures = 'dialogLeft:'+x+'px;dialogTop:'+y+'px;dialogHeight:500px;dialogWidth:500px;help:no;status:no;unadorned:yes';
   window.showModelessDialog("smiles.html", window, sFeatures);
}
else{ 
var sm=['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50','51','52','53','54','55','56','57','58','59','60','61','62','63','64','65','66','67','68','69','70','71','72','73','74','75','76','77','78','79','80','81','82','83','84','85','86','87','88','89','90','91','92','93','94','95','96','97','98','101','102','103','104','105','106','107','108','109','110','111','112','113','114','115','116','117','118','119','120','121','122','123','124','125','126','127','128','129','130','131','132','133','134','135','136','137','138','139','140','141','142','143','144','145','146','147','148','149','150','151','152','153','154','155','156','157','158','159','160','161','162','163','164','165','166','167','168','169','170','171','172','173','174','175','176','177','178','179','180','181','182','183','184','185','186','187','188','189','190','191','192','193','194','195','196','197','198','199','200','201','202'];                                                                                                                                                                                                                                             
	function createMessage(title, body) {
		var container = document.createElement('div');
		var i=0;
		body='';
		while(i<sm.length){
			var s = sm[i++];
			body +='<a class="hoversmile" href="javascript:void(0)" onClick="SSm(\''+s+'\')"><IMG SRC=img/smiles/smiles_'+s+'.gif BORDER=0 ALT="" ></a>';
		}
		container.innerHTML = '<div id="ssmsmilediv" class="ssm-smile"><div class="ssm-smile-body">'+body+'</div><input class="ssm-smile-ok" type="button" value="Закрыть"/></div>';
		
		return container.firstChild;
	}
	function positionMessage(elem) {
		var ua = navigator.userAgent.toLowerCase();

		if (ua.indexOf("msie") != -1 && ua.indexOf("opera") == -1 && ua.indexOf("webtv") == -1) {
			IsIE(elem);
		 }
		else{

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
<script LANGUAGE='JavaScript'> 
document.ondragstart = test;
document.oncontextmenu = test;
function test() {
 return false
}
</SCRIPT>
</body>
</html>
<HTML>
<HEAD>
<TITLE>Бойцовский Клуб</TITLE>
<META content="oldbk2.com, игра, online" http-equiv=Keywords name=Keywords>
<META content="oldbk2.com" http-equiv=Description name=Description>
<META content="text/html; charset=windows-1251" http-equiv=Content-type>
<script>
var delay = 10;     // Каждые n сек. увеличение HP на 50%
var Mdelay = 12;
top.server = "http://oldbk2.com";
function get_mainframe() {return top.frames['main']; }
function get_maindoc() { return this.document; }
var main_uid= 'main';</script>
<script type="text/javascript" src="js/battle2.js?2" charset="utf-8"></script>
<script LANGUAGE='JavaScript'> 
document.ondragstart = test;
document.oncontextmenu = test;
function test() {
 return false
}
</SCRIPT>
<SCRIPT language=JavaScript>
<!--
var CtrlPress = false;

var SoundOff=true;
var VolumeControl=25;
function hlchat() {
  if (top.frames['chat'].document.getElementById("mes").style.display=='none' && top.frames['chat'].document.getElementById('td_all').style.color!='#00ffaa') {
    top.frames['chat'].document.getElementById('td_all').style.color='#0000ff';
  }
}
function soundD(){
  if (top.frames['chat'].document.getElementById("mes").style.display=='none') {
    top.frames['chat'].document.getElementById('td_all').style.color='#00ffaa';
    top.frames['chat'].document.getElementById('td_all').style.fontWeight='bold';
  }
  if (SoundOff==false){
    //if (top.frames['bottom'].document.getElementById('soundM').innerHTML=='') {
    if (navigator.userAgent.match(/MSIE/)) {
    // IE gets an OBJECT tag
      musicTag = '<object name="flashsound" id="flashsound" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="1" height="1"><param name="movie" value="sound/Sound.swf?LevelVolume='+VolumeControl+'" /><param name="quality" value="high" /><param name="allowScriptAccess" value="sameDomain" /><</object>';
    } else {
      musicTag = '<embed name="flashsound" id="flashsound" src="sound/Sound.swf?LevelVolume='+VolumeControl+'" quality="best" width="1" height="1" allowScriptAccess="always" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />';
    }
    top.frames['bottom'].document.getElementById('soundM').innerHTML=musicTag;
    //}
  }
}


function soundB(b){
  if (typeof soundD.started=='undefined') soundD.started=new Array();
  if (SoundOff==false && typeof soundD.started[b]=='undefined'){
    soundD.started[b]=1;
    //if (top.frames['bottom'].document.getElementById('soundM').innerHTML=='') {
    if (navigator.userAgent.match(/MSIE/)) {
    // IE gets an OBJECT tag
      musicTag = '<object name="flashsound" id="flashsound" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="1" height="1"><param name="movie" value="sound/battle.swf?LevelVolume='+VolumeControl+'" /><param name="quality" value="high" /><param name="allowScriptAccess" value="sameDomain" /><</object>';
    } else {
      musicTag = '<embed name="flashsound" id="flashsound" src="sound/battle.swf?LevelVolume='+VolumeControl+'" quality="best" width="1" height="1" allowScriptAccess="always" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />';
    }
    top.frames['bottom'].document.getElementById('soundM2').innerHTML=musicTag;
    setTimeout('top.frames[\'bottom\'].document.getElementById(\'soundM2\').innerHTML=\'\';',24000);
    //}
  }
}



function AddTo(login){
    if (CtrlPress) {
        login = login.replace('%', '%25');
        while (login.indexOf('+')>=0) login = login.replace('+', '%2B');
        while (login.indexOf('#')>=0) login = login.replace('#', '%23');
        while (login.indexOf('?')>=0) login = login.replace('?', '%3F');
        window.open('inf.php?login='+login, '_blank')
    } else {

        var o = top.frames['main'].Hint3Name;
        if ((o != null)&&(o != "")) {
            top.frames['main'].document.getElementById(o).value=login;
            top.frames['main'].document.getElementById(o).focus();
        } else {
            top.frames['bottom'].window.document.F1.text.focus();
            if (top.frames['bottom'].document.forms[0].text.value=='to ['+login+'] ') top.frames['bottom'].document.forms[0].text.value = 'private ['+login+'] ';
            else {
              if (top.frames['bottom'].document.forms[0].text.value=='private ['+login+'] ') top.frames['bottom'].document.forms[0].text.value = 'to ['+login+'] ';
              else top.frames['bottom'].document.forms[0].text.value = 'to ['+login+'] '+top.frames['bottom'].document.forms[0].text.value;
            }
        }
    }
}
function AddToPrivate(login, nolookCtrl){
    if (CtrlPress && !nolookCtrl) {
        login = login.replace('%', '%25');
        while (login.indexOf('+')>=0) login = login.replace('+', '%2B');
        while (login.indexOf('#')>=0) login = login.replace('#', '%23');
        while (login.indexOf('?')>=0) login = login.replace('?', '%3F');
        window.open('inf.php?login='+login, '_blank')
    } else {
        top.frames['bottom'].window.document.F1.text.focus();
        top.frames['bottom'].document.forms[0].text.value = 'private ['+login+'] ' + top.frames['bottom'].document.forms[0].text.value;
    }
}
function setCookie(name, value) {document.cookie=name+"="+escape(value)+"; path=/";}
function getCookie(Name) {
var search = Name + "="
if (document.cookie.length > 0){
    offset = document.cookie.indexOf(search)
    if (offset != -1) {
        offset += search.length
        end = document.cookie.indexOf(";", offset)
        if (end == -1) end = document.cookie.length
        return unescape(document.cookie.substring(offset, end))
    }
}}

var rnd = Math.random();


var wr_document_all = function (d, v)
{
	try
	{
		var x = d.getElementById(v);
		if (x) return x;
		var x = d.getElementsByName(v);
		if (x) return x[0];
	}
	catch (e)
	{
	}
};

var wr_document_all2 = function (d, v)
{
	try
	{
		var x = d.getElementById(v);
		if (x) return [x];
		var x = d.getElementsByName(v);
		if (x) return x;
	}
	catch (e)
	{
		return [];
	}
};


//-- Обновление чата
var ChatTimerID = -1;       // id таймера для чата
var ChatDelay = 15;         // через сколько сек. рефрешить чат
var ChatNormDelay = 15;     // через сколько сек. рефрешить чат при нормальном обновлении
var ChatSlowDelay = 55;     // через сколько сек. рефрешить чат при медленном обновлении
var ChatOm = false;         // фильтр сообщений в чате
var ChatSys = false;        // фильтр системных сообщений в чате
var ChatSlow = false;       // обновление чата раз в минуту
var ChatTranslit = false;   // преобразование транслита
var lid = 0;                // номер последнего сообщения в чате
function RefreshChat()
{   var s = '&lid='+lid;
    if (ChatOm) { s=s+'&om=1'; }
    if (ChatSys) { s=s+'&sys=1'; }
    if (ChatTimerID>=0) { clearTimeout(ChatTimerID); }
    ChatTimerID = setTimeout('RefreshChat()', ChatDelay*1000);
    top.frames['refreshed'].location='ch.php?show='+Math.random()+s;

}
// останавливает обновление чата
function StopRefreshChat(){
    if (ChatTimerID>=0) {clearTimeout(ChatTimerID); }
    ChatTimerID = -1;
}
// сбрасывает таймер счетчика
function NextRefreshChat(){
    if (ChatTimerID>=0) {clearTimeout(ChatTimerID); }
    ChatTimerID = setTimeout('RefreshChat()', ChatDelay*1000);
}

function switchtochat(b) {
  top.frames['chat'].document.getElementById('ch1').style.right='218px';
  top.frames['chat'].document.getElementById('td_all').style.right='180px';
  top.frames['chat'].document.getElementById('ch2').style.right='170px';
  top.frames['chat'].document.getElementById('td_sys').style.right='10px';
  top.frames['chat'].document.getElementById('ch3').style.right='0px';
  top.frames['chat'].document.getElementById('ch3').style.display='none';
  top.frames['chat'].document.getElementById('td_log').style.display='none';  
  if (top.frames['chat'].document.getElementById('logs').style.display!='none') {
    top.frames['chat'].clickbut('all');
  }
}


var lastbattle=0;
function switchtolog(b) {
  top.frames['chat'].document.getElementById('ch1').style.right='308px';
  top.frames['chat'].document.getElementById('td_all').style.right='270px';
  top.frames['chat'].document.getElementById('ch2').style.right='260px';
  top.frames['chat'].document.getElementById('td_sys').style.right='100px';
  top.frames['chat'].document.getElementById('ch3').style.right='90px';
  top.frames['chat'].document.getElementById('ch3').style.display='';
  top.frames['chat'].document.getElementById('td_log').style.display='';  
  if (b>lastbattle)  {
    lastbattle=b;
    top.frames['chat'].clickbut('log');
  }
}
// Прокрутка текста чата вниз
function srld(){
  if (top.frames['chat'].document.getElementById('logs').style.display=='none') {
    top.frames['chat'].window.scrollBy(0, 65000);
  }
}
// Установка lid
function slid(newlid)
{   var o = top.frames['bottom'].F1;
    if (o) {lid=newlid;o.lid.value=newlid;}
}

// Перезагружаем список online, делаем это не сразу, а с паузой
var OnlineDelay = 12;       // пауза в сек. перед релоудом списка online
var OnlineTimerOn = -1;     // id таймера
var OnlineOldPosition = 0;  // Позиция списка перед релоудом
var OnlineStop = true;      // ручное обновление чата
function rld(now) {
    if (OnlineTimerOn < 0 || now) {
        var tm = now ? 2000 : OnlineDelay*1000;
        OnlineTimerOn = setTimeout('onlineReload('+now+')', tm);
    }
}
function onlineReload(now) {
    if (OnlineTimerOn >= 0) clearTimeout(OnlineTimerOn);
    OnlineTimerOn = -1;
    if (! OnlineStop || now) {
        top.frames['online'].location='ch.php?online='+Math.round(Math.random()*100000);
        //top.frames['online'].navigate('ch.php?online='+Math.round(Math.random()*100000));
    }
    rld();
}

var changeroom=1;
var localroom=1;

setInterval(function (){
                if (localroom!=changeroom){
                    localroom=changeroom;
                    top.frames['online'].location='ch.php?online='+Math.round(Math.random()*100000);
                }
            }, 5000);

//-- Очистка чата
var ChatClearTimerID = -1;  // id таймера для чата
var ChatClearDelay = 900;   // через сколько сек. чистим чат
var ChatClearSize = 10000;  // Сколько байт оставляем после чистки
function RefreshClearChat(){
    if (ChatClearTimerID>=0) { clearTimeout(ChatClearTimerID); }
    ChatClearTimerID = setTimeout('RefreshClearChat()', ChatClearDelay*1000);
    var s = top.frames['chat'].document.getElementById("mes").innerHTML;
    if (s.length > ChatClearSize) { // Надо чистить
        var j = s.lastIndexOf('<BR>', s.length-ChatClearSize);
        top.frames['chat'].document.getElementById("mes").innerHTML = s.substring(j, s.length);
    }
    var s = top.frames['chat'].document.getElementById("mes_sys").innerHTML;
    if (s.length > ChatClearSize) { // Надо чистить
        var j = s.lastIndexOf('<BR>', s.length-ChatClearSize);
        top.frames['chat'].document.getElementById("mes_sys").innerHTML = s.substring(j, s.length);
    }
    var s = top.frames['chat'].document.getElementById("mes_clan").innerHTML;
    if (s.length > ChatClearSize) { // Надо чистить
        var j = s.lastIndexOf('<BR>', s.length-ChatClearSize);
        top.frames['chat'].document.getElementById("mes_clan").innerHTML = s.substring(j, s.length);
    }
}

//-- Прочие функции
var oldlocation = '';
function cht(nm){
    if (oldlocation == '') {
        oldlocation = top.frames['main'].location.href;
        var i = oldlocation.indexOf('?', 0);
        if (i>0) { oldlocation=oldlocation.substring(0, i) }
    }
    //top.frames['main'].navigate(nm);
    top.frames['main'].location=nm;
}
function returned(){
    if (oldlocation != '') { top.frames['main'].location=oldlocation+'?tmp='+Math.random(); oldlocation=''; }
    else { top.frames['main'].location='main.php?edit='+Math.random() }
}
function myscroll(){
    OnlineOldPosition = top.frames['online'].document.body.scrollTop;
}
function CLR1(){
    top.frames["bottom"].document.F1.text.value='';
    top.frames["bottom"].document.F1.text.focus();
}
function CLR2(){
    top.frames['chat'].document.getElementById("mes").innerHTML='';
    top.frames['chat'].document.getElementById("oMenu").style.top="0px";
}
function strt(){// Начинаем
    ChatTimerID = setTimeout('RefreshChat()', 1000);
    OnlineTimerOn = setTimeout('onlineReload(true)', 2*1000);
    ChatClearTimerID = setTimeout('RefreshClearChat()', ChatClearDelay*1000);
}



var user = getCookie("battle");
if ((user == null)||(user == "")) {
    document.write('<BODY>Внимание! Вы или не ввели ваш логин/пароль на титульной странице или в вашем браузере отключена поддержка Cookie. Необходимо их включить (это абсолютно безопасно!) для продолжения игры.<BR>');
    document.write('В меню браузера Internet Explorer выберите "Сервис" => "Свойства обозревателя" перейдите на закладку "Конфиденциальность" и передвиньте ползунок в положение "Средний". И попробуйте снова зайти с <A HREF="/">титульной страницы</A>.<BR>В браузере IE версии 5 меню: "Сервис" => "Свойства обозревателя" => "Безопасность" => "Интернет" кнопка "Другой" => файлы "cookie"<BR>Если у вас IE 4-й версии, возможно вам не удастся зайти, с проблемой этой версии браузера мы работаем, но пока единственным решением является: обновление браузера до 5-й или 6-й версии.<BR>Если ничего не помогает, проверьте настройки вашего FireWall, если он установлен, то может не пропускать активные страницы и cookie.</BODY>');
} else {if (document.all && document.all.item && !window.opera && !document.layers) {
document.write(
'<frameset rows="37, *, 30, 5, 0" FRAMEBORDER="0" BORDER="0" FRAMESPACING="0">'+
'<frame name="topless" src="top.php" target="_top" scrolling=NO NORESIZE FRAMEBORDER="0" BORDER="0" FRAMESPACING="0" MARGINWIDTH="0" MARGINHEIGHT="0">'+
'<frameset cols="9, *, 9" FRAMEBORDER="0" BORDER="0" FRAMESPACING="0">'+
'<frame src="left.html" target="_top" scrolling=NO NORESIZE FRAMEBORDER="0" BORDER="0" FRAMESPACING="0" MARGINWIDTH="0" MARGINHEIGHT="0">'+
'<frameset rows="*, 0" FRAMEBORDER="0" BORDER="0" FRAMESPACING="0">'+
'<frameset rows="72%, *"  flameborder="0"  >'+
'<frame name="main" src="main.php?top='+rnd+'"  frameborder="0" style="border-bottom-width: 3px; border-bottom-style:solid; border-bottom-color:#B0B0B0;cursor:s-resize"  >'+
'<frameset cols="*,220" frameborder="0">'+
'<frame name="chat" src="buttons.php?ch='+rnd+'" target="_top" scrolling=YES FRAMEBORDER="0" BORDER="0" FRAMESPACING="0" MARGINWIDTH="3" MARGINHEIGHT="3">'+
'<frame name="online" src="ch.php?online='+rnd+'" target="_blank" scrolling=YES FRAMEBORDER=0 BORDER=0 FRAMESPACING=0 MARGINWIDTH=3 MARGINHEIGHT=0>'+
'</frameset>'+     
'</frameset>'+
'<frame name="refreshed" target="_top" scrolling="no" noresize src="refreshed.html">'+
'</frameset>'+
'<frame src="right.html" target="_top" scrolling=NO NORESIZE FRAMEBORDER="0" BORDER="0" FRAMESPACING="0" MARGINWIDTH="0" MARGINHEIGHT="0">'+
'</frameset>'+
'<frame name="bottom" scrolling="no" noresize src="buttons.php?'+rnd+'">'+
'<frame src="bottom.html" target="_top" scrolling=NO NORESIZE FRAMEBORDER="0" BORDER="0" FRAMESPACING="0" MARGINWIDTH="0" MARGINHEIGHT="0">'+
'<frame name="xbottom" src="bottom.php?'+rnd+'" target="_top" scrolling=NO NORESIZE FRAMEBORDER="0" BORDER="0" FRAMESPACING="0" MARGINWIDTH="0" MARGINHEIGHT="0">'+
'</frameset>');
} else { 
//alert("Внимание! Ваш браузер отличается от Internet Explorer 7.0 или выше, поэтому безошибочная работа игры не гарантируется.");
document.write(
'<frameset rows="37, *, 30, 5, 0" FRAMEBORDER="0" BORDER="0" FRAMESPACING="0">'+
'<frame name="topless" src="top.php" target="_top" scrolling=NO NORESIZE FRAMEBORDER="0" BORDER="0" FRAMESPACING="0" MARGINWIDTH="0" MARGINHEIGHT="0">'+
'<frameset cols="9, *, 9" FRAMEBORDER="0" BORDER="0" FRAMESPACING="0">'+
'<frame src="left.html" target="_top" scrolling=NO NORESIZE FRAMEBORDER="0" BORDER="0" FRAMESPACING="0" MARGINWIDTH="0" MARGINHEIGHT="0">'+
'<frameset rows="*, 0" FRAMEBORDER="0" BORDER="0" FRAMESPACING="0">'+
'<frameset rows="72%, *"  flameborder="0"  >'+
'<frame name="main" src="main.php?top='+rnd+'"  frameborder="0" style="border-bottom-width: 3px; border-bottom-style:solid; border-bottom-color:#B0B0B0;cursor:s-resize"  >'+
'<frameset cols="*,220" frameborder="0">'+
'<frame name="chat" src="buttons.php?ch='+rnd+'" target="_top" scrolling=YES FRAMEBORDER="0" BORDER="0" FRAMESPACING="0" MARGINWIDTH="3" MARGINHEIGHT="3">'+
'<frame name="online" src="ch.php?online='+rnd+'" target="_blank" scrolling=YES FRAMEBORDER=0 BORDER=0 FRAMESPACING=0 MARGINWIDTH=3 MARGINHEIGHT=0>'+
'</frameset>'+     
'</frameset>'+
'<frame name="refreshed" target="_top" scrolling="no" noresize src="refreshed.html">'+
'</frameset>'+
'<frame src="right.html" target="_top" scrolling=NO NORESIZE FRAMEBORDER="0" BORDER="0" FRAMESPACING="0" MARGINWIDTH="0" MARGINHEIGHT="0">'+
'</frameset>'+
'<frame name="bottom" scrolling="no" noresize src="buttons.php?'+rnd+'">'+
'<frame src="bottom.html" target="_top" scrolling=NO NORESIZE FRAMEBORDER="0" BORDER="0" FRAMESPACING="0" MARGINWIDTH="0" MARGINHEIGHT="0">'+
'<frame name="xbottom" src="bottom.php?'+rnd+'" target="_top" scrolling=NO NORESIZE FRAMEBORDER="0" BORDER="0" FRAMESPACING="0" MARGINWIDTH="0" MARGINHEIGHT="0">'+
'</frameset>');
}
}
//-->
</SCRIPT>
<NOSCRIPT>
<FONT COLOR="red">Внимание!</FONT> В вашем браузере отключена поддержка JavaScript. Необходимо их включить (это абсолютно безопасно!) для продолжения игры.<BR>
В меню браузера Internet Explorer выберите "Сервис" => "Свойства обозревателя" перейдите на закладку "Безопасность". Для зоны <B>Интернет</B> нажмите кнопку "Другой". Установите уровень безопасности "Средний", этого достаточно. Или же, в списке параметров найдите раздел "Сценарии" и там нужно разрешить выполнение Активных сценариев.<br>
<FONT COLOR="red">Attention!</FONT> Your browser does not support JavaScript. To continue the game, please turn the support on (it's absolutely safe).<BR>
In the Internet Explorer browser menu choose "Tools" => "Internet Options" and go to "Security". For the <B>Internet</B> zone press the "Custom level" button. State the "Medium", this will be enough. You can also find the "Scripting" page in the list of the parameters and allow Active Scripting there.
</NOSCRIPT></BODY></HTML>
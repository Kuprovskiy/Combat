<?php

include('anti_ddos/index.php');

class antiDdos 
{
    // дебаг 
    public $debug = false;
    // директория для хранения файлов индефикации запросов
    public $dir = 'tmp/'; 
    // номер icq администратора
    public $icq = '';
    // сообщение при выключенном сайте 
    public $off_message = 'Временные неполадки, пожалуйста, подождите.'; 
    // индивидуальный индефикатор
    private $indeficator = null;
    // сообщение при бане, работают шаблоны, можно использовать - {ICQ}, {IP}, {UA}, {DATE}
    public $ban_message = 'Вы были заблокированы';
    // команда выполнения бана в файрволле
    public $exec_ban = 'iptables -A INPUT -s {IP} -j DROP';
    // тип защиты от ддоса:
    /* Возможные значения $ddos 1-5:  
    | 1. Простая проверка по кукам, по умолчанию(рекомендую)
    | 2. Двойная проверка через $_GET antiddos и meta refresh
    | 3. Запрос на авторизацию WWW-Authenticate
    | 4. полное отключение сайта, боты не блокируются!!!
    | 5. выключать сайт если нагрузка слишком большая на сервере, боты не блокируются!!!
    */
    var $ddos = 1;
    // часть домена поисковых ботов, см strpos()
    private $searchbots = array('googlebot.com', 'yandex.ru', 'ramtel.ru', 'rambler.ru', 'aport.ru', 'sape.ru', 'msn.com', 'yahoo.net');
    // временная переменные нужные для работы скрипта
    private $attack = false;
    private $is_bot = false;
    private $ddosuser; 
    private $ddospass;
    private $load; 
    public $maxload = 80;
     
    function __construct($debug)
    { 
        @session_start() or die('session_start() filed!');
        $this->indeficator = md5(sha1('botik' . strrev(getenv('HTTP_USER_AGENT')))); 
        $this->ban_message = str_replace(array('{ICQ}', '{IP}', '{UA}', '{DATE}'),
                                         array($this->icq, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], date('d.m.y H:i')), 
                                         $this->ban_message
                                        ); 
        if (eregi(ip2long($_SERVER['REMOTE_ADDR']), file_get_contents($this->dir . 'banned_ips')))
            die($this->ban_message); 
        $this->exec_ban = str_replace('{IP}', $_SERVER['REMOTE_ADDR'], $this->exec_ban);
        $this->debug = $debug; 
        if(!function_exists('sys_getloadavg'))
        { 
            function sys_getloadavg()
            { 
                return array(0,0,0);
            } 
        }
        $this->load = sys_getloadavg(); 
        if(!$this->sbots())
        {
            $this->attack = true;
            $f = fopen($this->dir . ip2long($_SERVER["REMOTE_ADDR"]), "a");
            fwrite($f, "query\n");
            fclose($f);
        }
    }

    /**
    * Старуем
    **/
    function start()
    {
        if($this->attack == false)
            return; 
        switch($this->ddos)
        { 
            case 1:
                $this->addos1(); 
                break; 
            case 2:
                $this->addos2(); 
                break; 
            case 3:
                $this->ddosuser = substr(ip2long($_SERVER['REMOTE_ADDR']), 0, 4); 
                $this->ddospass = substr(ip2long($_SERVER['REMOTE_ADDR']), 4, strlen(ip2long($_SERVER['REMOTE_ADDR']))); 
                $this->addos3();
                break; 
            case 4: 
                die($this->off_message);
                break; 
            case 5: 
                if ($this->load[0] > $this->maxload)
                { 
                    header('HTTP/1.1 503 Too busy, try again later');  
                    die('<center><h1>503 Server too busy.</h1></center><hr><small><i>Server too busy. Please try again later. Apache server on ' . $_SERVER['HTTP_HOST'] . ' at port 80</i></small>');
                }  
                break; 
            default:
                break; 
        } 
        if ($_COOKIE['ddos'] == $this->indeficator)
            @unlink($this->dir . ip2long($_SERVER["REMOTE_ADDR"]));  
    }

    /**
    * Функция проверяет не является ли клиент поисковым ботом
    **/
    function sbots()
    {
        $tmp = array();
        foreach($this->searchbots as $bot) 
        {
            $tmp[] = strpos(gethostbyaddr($_SERVER['REMOTE_ADDR']), $bot) !== false; 
            if($tmp[count($tmp) - 1] == true)
            { 
                $this->is_bot = true;
                break; 
            } 
        }
        return $this->is_bot; 
    } 

    /** 
    * Функция бана 
    **/
    private function ban() 
    { 
        if (! system($this->exec_ban))
        {  
            $f = fopen($this->dir . 'banned_ips', "a");  
            fwrite($f, ip2long($_SERVER['REMOTE_ADDR']) . '|');
            fclose($f);  
        } 
        die($this->ban_message);
    } 
    /** 
    * Первый тип защиты
    **/ 
    function addos1() 
    {
        if (empty($_COOKIE['ddos']) or !isset($_COOKIE['ddos']))  
        {  
            $counter = @file($this->dir . ip2long($_SERVER["REMOTE_ADDR"]));
            setcookie('ddos', $this->indeficator, time() + 3600 * 24 * 7 * 356); // ставим куки на год. 
            if (count($counter) > 10) {  
                if (! $this->debug)
                    $this->ban();  
                else  
                    die("Блокированы.");
            }  
            if (! $_COOKIE['ddos_log'] == '1')  
            {
                if (! $_GET['antiddos'] == 1)  
                {  
                    setcookie('ddos_log', '1', time() + 3600 * 24 * 7 * 356); //чтоб не перекидывало постоянно рефрешем.
                    if(headers_sent()) 
                        die('Header already sended, check it, line '.__LINE__); 
                    header("Location: ./?antiddos=1");
                }  
            }  
        } elseif ($_COOKIE['ddos'] !== $this->indeficator)
        {
            if (! $this->debug)
                $this->ban();
            else
                die("Блокированы.");
        }
    }

    /**
    * Второй тип защиты
    **/
    function addos2()
    {
        if (empty($_COOKIE['ddos']) or $_COOKIE['ddos'] !== $this->indeficator)  
        {
            if (empty($_GET['antiddos']))  
            {
                if (! $_COOKIE['ddos_log'] == '1')  
                    //проверям есть ли запись в куках что был запрос
                    die('<meta http-equiv="refresh" content="0;URL=?antiddos=' . $this->indeficator . '" />');  
            } elseif ($_GET['antiddos'] == $this->indeficator)
            {  
                setcookie('ddos', $this->indeficator, time() + 3600 * 24 * 7 * 356);
                setcookie('ddos_log', '1', time() + 3600 * 24 * 7 * 356); //типо запрос уже был чтоб не перекидывало постоянно рефрешем.  
            }
            else  
            {
                if (!$this->debug)  
                    $this->ban();
                else  
                {
                    echo "May be shall not transform address line?";  
                    die("Блокированы.");
                }  
            }
        }  
    }
     
    /**
    * Третий тип защиты 
    **/
    function addos3() 
    {
        if (! isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] !== $this->ddosuser || $_SERVER['PHP_AUTH_PW'] !== $this->ddospass)  
        {
            header('WWW-Authenticate: Basic realm="Vvedite parol\':  ' . $this->ddospass . ' | Login: ' . $this->ddosuser . '"');  
            header('HTTP/1.0 401 Unauthorized');
            if (! $this->debug)  
                $this->ban();
            else
                die("Блокированы.");
            die("<h1>401 Unauthorized</h1>");
        }
    }
}
?>
<?
$_SESSION['otkuda']=$_SERVER['HTTP_REFERER'];
?>
<html>
<head>
<script LANGUAGE='JavaScript'> 
document.ondragstart = test;
//запрет на перетаскивание
//запрет на выделение элементов страницы
document.oncontextmenu = test;
//запрет на выведение контекстного меню
function test() {
 return false
}
</SCRIPT>
<HTML>
	<HEAD>
  <meta http-equiv="Content-type"
 content="text/html; charset=windows-1251">
  <meta http-equiv="Cache-Control"
 content="no-cache">
  <meta http-equiv="PRAGMA"
 content="NO-CACHE">
  <meta http-equiv="Expires"
 content="0">
<meta name="author" content="lostcombats.com"> 
<meta name='yandex-verification' content='61dd6566b82e2a5a' />
<meta name="google-site-verification" content="v09JYmqobPnh0I7395mlG1Zp5snt-dedVRPoEmrCul8" />
<link rel="icon" href="/favicon.ico" type="image/x-icon">
		<meta name="Keywords" content="игра, играть, игрушки, онлайн,online, интернет, internet, RPG, fantasy, фэнтези, меч, топор, магия, кулак, удар, блок, атака, защита, Бойцовский Клуб, бой, битва, отдых, обучение, развлечение, виртуальная реальность, рыцарь, маг, знакомства, чат, лучший, форум, свет, тьма, bk, games, клан, банк, магазин, клан">
		<meta name="Description" content="Отличная RPG онлайн игра посвященная боям и магии. Тысячи жизней, миллионы смертей, два бога, сотни битв между Светом и Тьмой.">
		<TITLE>Бойцовский клуб</TITLE>
		<STYLE type="text/css">
<!--
body {
	background-color: #000000;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
A:link {
	COLOR: #F9F7EA;
	TEXT-DECORATION: none;
	font-weight: normal;
}
A:visited {
	COLOR: #F9F7EA;
	TEXT-DECORATION: none;
	font-weight: normal;
}
A:active {
	COLOR: #77684D;
	TEXT-DECORATION: none;
	font-weight: normal;
}
A:hover {
	COLOR: #7E7765; TEXT-DECORATION: underline
}

.inup {	FONT-SIZE: 8pt;
	COLOR: #DFDDD3;
	FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;
	BACKGROUND-COLOR: #151616;
	border: 1px double #817A63;
}
.style2 {color: #A7A495}

.btn {	FONT-SIZE: 7.5pt;
	COLOR: #DFDDD3;
	FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;
	BACKGROUND-COLOR: #2B2B18;
	border: 1px double #817A63;
}


.btkey {
	display: block; text-align: center;
	PADDING-RIGHT: 1px; PADDING-LEFT: 1px;
	FONT-SIZE: 7.5pt; FONT-FAMILY: verdana,sans-serif,arial;
	width: 20;
	CURSOR: hand;
	border: 1px solid #D6D3CE;
	COLOR: #DFDDD3; BACKGROUND-COLOR: #2B2B18;
}

.message {
	FONT-SIZE: 7.5pt; FONT-FAMILY: verdana,sans-serif,arial;
	COLOR: white;
}

.menu {
	FONT-SIZE: 10pt; FONT-FAMILY: verdana;
	COLOR: white;
}
-->
		</STYLE>

<!-- Put this script tag to the place, where the Share button will be -->
	</HEAD>
	<BODY class="menu">
		<SCRIPT>
var now = new Date()
var day = now.getDate();
var mon = now.getMonth();
var swnd = window.location + "";
			</SCRIPT>
		<TABLE width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0" class="menu">
			<TR height="30%">
				<TD align="center">
                               <TABLE width="100%" height="100%" border="0">
					<td align="center"><img class="baner" src="http://lostcombats.com/i/glavnaya/g1.gif"></td>
                                        
                                                   <TR>
						
					</TR>
				</TABLE></TD>
			</TR>
			<TR height="205">
				<TD colspan="2" width="100%" align="center" scope="col"><SCRIPT>

// -=-=-=-=-=- BACKGROUND -=-=-=-=-=-

var k = 0;
if ((mon >= 2) && (mon <= 4)) { // Spring

		document.write('<TABLE width="100%"  border="0" cellspacing="0" cellpadding="0" class="menu" background="http://img.combats.ru/i/mainpage/start_2011_spr_03.jpg" style="background-repeat: repeat-x">');


} else if ((mon >= 5) && (mon <=7)) { // Summer

		document.write('<TABLE width="100%"  border="0" cellspacing="0" cellpadding="0" class="menu" background="" style="background-repeat: repeat-x">');

} else if ((mon >= 8) && (mon <= 10)) { // Autumn
	document.write('<TABLE width="100%"  border="0" cellspacing="0" cellpadding="0" class="menu" background="http://img.combats.ru/i/mainpage/start_11aut1_03.jpg" style="background-repeat: repeat-x">');
} else { // Winter
	document.write('<TABLE width="100%"  border="0" cellspacing="0" cellpadding="0" class="menu" background="http://img.combats.ru/i/mainpage/start_2011_win_03.jpg" style="background-repeat: repeat-x">');
} 
	
					</SCRIPT>
					<TR height="205" valign="top">
						<TD  width="195" align="right" valign="bottom" style="padding-bottom: 42; "><SCRIPT>
 


						</SCRIPT></A></TD>
						<TD align="center"><SCRIPT>
 
// -=-=-=-=-=- LOGO -=-=-=-=-=-
 
if ((mon >= 2) && (mon <= 4)) { // Spring
//	if ((swnd.indexOf('cruel-world.ru') >= 0) || (swnd.indexOf('cruel-world.ru') >= 0) || (swnd.indexOf('cruel-world.ru') >= 0) || (swnd.indexOf('cruel-world.ru') >= 0)) {
		document.write('<IMG src="/i/mainpage/start_2011_spr_05.jpg" width="428" height="205" border="0" usemap="#Map">');
//	} else {
//		document.write('<IMG src="/i/mainpage/start_09spr2_04.jpg" width="428" height="205" border="0" usemap="#Map">');
//	}
} else if ((mon >= 5) && (mon <=7)) { // Summer
//	if (k == 1) {
		document.write('<IMG src="http://img.combats.ru/i/mainpage/start_13sum_05.jpg" width="428" height="205" border="0" usemap="#Map">');
//	} else {
//		document.write('<IMG src="/i/mainpage/start_09sum2_051.jpg" width="428" height="205" border="0" usemap="#Map">');
//	}
} else if ((mon >= 8) && (mon <= 10)) { // Autumn
	document.write('<IMG src="http://lostcombats.com/i/glavnaya/glavs.gif" width="428" height="205" border="0" usemap="#Map">');
} else { // Winter
//	if (((mon == 11) && (day > 15)) || ((mon == 0) && (day <= 15))) {
	if ((mon >= 0) && (mon <= 1)) {
		document.write('<IMG src="/i/mainpage/start_2011_winng_05.jpg" width="428" height="205" border="0" usemap="#Map">');
	} else {
		document.write('<IMG src="/i/mainpage/start_2011_win_05.jpg" width="428" height="205" border="0" usemap="#Map">');
	}
}
 
						</SCRIPT></TD>
						<TD width="195" valign="bottom" style="padding-bottom: 42; padding-right: 5; " align="right"><SCRIPT>
 

 
						</SCRIPT></A></TD>
					</TR>
				</TABLE></TD>
			</TR>
			<TR valign="top" height="50%">
				<TD colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class='menu'>
					<TR>
						<TD align="left" valign="bottom" noWrap style="padding-left:10; " width="25%">

<IMG height="75" src="http://img.combats.ru/i/mainpage/18adult.gif" width="175">
</TD>
						<TD align="center" width="50%" style="padding-left: 10; "><TABLE width="100%" border="0" class="menu">

<FORM action="/enter.php" method="post" name="F1">
							<TR>
								<TD align="center">
									<BR>
									<INPUT class="inup" onblur="if ('' == value ) { value = 'Логин'; } " onfocus="if ( 'Логин' == value ) { value = ''; } " value="Логин" name="login" style="width: 144; ">
								</TD>
							</TR>
							<TR>
								<TD align="center"><TABLE cellspacing="0" cellpadding="0" class="menu">
									<TR valign="bottom">
										<TD><INPUT style="width:114; " class="inup" type="password" size="25" value="" name="psw"></TD>
										<TD style="padding: 0, 0, 1, 5; " valign="bottom">
											<IMG border="0" SRC="http://img.combats.ru/i/misc/klav_transparent.gif" style="cursor: hand; " onClick="KeypadShow(); " title="Виртуальная клавиатура">
										</TD>
									</TR>
								</TABLE></TD>
							</TR>
							<TR>
								
                                                                <TD height="19" align="center">
									<INPUT type="submit" class="btn" value=" Войти " onclick="this.blur(); ">
								</TD>
							</TR>
							<TR>
								<TD align="center">
									<INPUT type="button" class="btn" value=" Регистрация " onclick="this.blur(); window.location='/register.php'; ">
								</TD>
							</TR>
						</TABLE></TD>
						<TD width="25%" align="right" style="padding-right: 10; " valign="bottom">
							<IMG height="75" src="http://img.combats.ru/i/mainpage/change_warn.gif" width="185">
						</TD>
					</TR>
					<TR>
						<TD align="center" colspan="10"><SCRIPT>

var rKey = '';
var eKey = '';

var chRus = 'абвгдеёжзийклмнопрстуфхцчшщъыьэюя';
var chEng = 'abcdefghijklmnopqrstuvwxyz';
var chDec = '0123456789';
var spSim = '!@#$%^&*()_+|=-`~[]{}.,?><;:/';

function KeyShow(shiftFl, tmp) {
	var trshap = '';
	for (var j = 0; j < tmp.length; j++) { 
		ich = tmp.charAt(j);
		if (shiftFl) ich = ich.toUpperCase();
		trshap += '<TD><INPUT type="button" class="btkey" value="' + ich + '" onclick="document.forms[\'F1\'].psw.value += this.value; this.blur();"></TD>';
	}
	return trshap;
}

function KeyCreate(tmp) {
	var out = '';
	var cnt = tmp.length;
	for (var j = 0; j < cnt; j++) {
		tt = Math.floor((tmp.length - 1) * Math.random());
		out += tmp.charAt(tt);
		tmp = tmp.substring(0, tt).concat(tmp.substring(tt + 1));
	}
	return out;
}

function KeypadShow() {
	if ( document.all['keypad'].style.display == 'block' ) document.all['keypad'].style.display='none';
	else { document.all['keypad'].style.display='block'; document.all['keypad'].innerHTML = keyTable; }
}

var keyTable = '';
function shKeypad(fl) {

	chRus1 = chRus;
	chEng1 = chEng;
	chDec1 = chDec;
	spSim1 = spSim;
	if(fl) {
		chRus1 = KeyCreate(chRus1);
		chEng1 = KeyCreate(chEng1);
		chDec1 = KeyCreate(chDec1);
		spSim1 = KeyCreate(spSim1);
		}
	keyTable = '<BR><BR><TABLE align="center" border="0">';
	keyTable += '<TR>' + KeyShow(0, chEng1) + '<TD colspan="7" align="right"><INPUT style="width=164; " type="button" class="btn" value="&larr;" onclick="tt = document.forms[\'F1\'].psw.value; document.forms[\'F1\'].psw.value = tt.substring(0, tt.length - 1);"></TD></TR>';
	keyTable += '<TR>' + KeyShow(1, chEng1) + '<TD colspan="7" align="right"><INPUT style="width=164; " type="button" class="btn" value="Очистить все" onclick="document.forms[\'F1\'].psw.value=\'\';"></TD></TR>';
	keyTable += '<TR>' + KeyShow(0, chDec1) + '<TD colspan="16" align="right"><INPUT style="width=164; " type="button" class="btn" value="По алфавиту" onclick="shKeypad(); document.all[\'keypad\'].innerHTML = keyTable;"></TD><TD colspan="7" align="right"><INPUT style="width=164; " type="button" class="btn" value="Перемешать" onclick="shKeypad(1); document.all[\'keypad\'].innerHTML = keyTable;"></TD></TR>';
	keyTable += '<TR><TD style="height: 8px; "></TD></TR>';
	keyTable += '<TR>' + KeyShow(0, chRus1) + '</TR>';
	keyTable += '<TR>' + KeyShow(1, chRus1) + '</TR>';
	keyTable += '<TR><TD style="height: 8px;"></TD></TR>';
	keyTable += '<TR>' + KeyShow(0, spSim1) + '</TR>';
	keyTable += '</TABLE>';
}

shKeypad(1);

						</SCRIPT><DIV id="keypad" align="center" style="display: none; "></DIV></TD>
					</TR>
					</FORM>
					<TR>
						<TD colspan=3 align="center" noWrap>
							<BR>
<A href="http://oldbk2.com/forum.php?conf=17" target="_blank">Законы</A>&nbsp; &nbsp;
<A href="http://oldbk2.com/forum.php?conf=13" target="_blank">Новости</A>&nbsp; &nbsp;
<a href="http://oldbk2.com/forum.php"target="_blank">Форум</a>&nbsp; &nbsp;
<A href="http://oldbk2.com/reit_pers.php" target="_blank">Рейтинг персонажей</A>&nbsp; &nbsp;
<A href="http://oldbk2.com/reit_refer.php" target="_blank">Рейтинг рефералов</A>&nbsp; &nbsp;
<A href="/rememberpassword.php"><NOBR>Забыли пароль?</NOBR></A>&nbsp; &nbsp;

						</TD>
					</TR>
				</TABLE>
				<TABLE width=100% align="center" style="padding-right: 10; " valign="top" width="30%">

                                                                     <div align="left"><?include('mail_ru.php')?></div>
                                </TABLE>
                                 <TABLE width="100%">
					<TR>
						<TD style="padding-left: 10; ">
						</TD>
						<TD align="right" style="padding-right: 10; " valign="top" width="30%">
							<TABLE cellpadding="0" cellspacing="0" class="menu">
								<TR>
									<TD align="right" valign="top" style="padding-bottom: 5; ">
										<BR>

									</TD>
								</TR>
								<TR valign="bottom">
									<TD>
										<A href="capitamiken@gmail.com">Отдел развития и партнерства </A>
									
                                                                          </TD>
								</TR>
							</TABLE>
						</TD>
					</TR>
				</TABLE></TD>
			</TR>
		</TABLE>

<AREA shape="rect" coords="70,155,105,200" href="http://lostcombats.com/i/clear.gif" title="Русская версия">
<AREA shape="rect" coords="70,155,105,200" href="http://lostcombats.com/i/clear.gif" title="Русская версия">


</BODY>
</HTML>

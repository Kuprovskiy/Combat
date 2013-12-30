<?php
//ob_start("ob_gzhandler");
ob_start();
session_start();
include "connect.php";
    include "functions.php";
    include "functions/info.php";
    $own=$user;
function chars($val){
	$search = array('#\&#si','#\"#si','#\<#si','#\>#si');
	$replace = array('&amp;','&quot;','&lt;','&gt;');
	$val = preg_replace($search, $replace, $val);
	return $val;
}
	function bbcode($val){
	$val=htmlspecialchars($val);
	$search = array(
		'#\[b\](.*?)\[/b\]#is',
		'#\&amp;lt;I\&amp;gt;(.*?)\&amp;lt;/I\&amp;gt;#si',
		'#\&amp;lt;U\&amp;gt;(.*?)\&amp;lt;/U\&amp;gt;#si',
		'#\&amp;lt;CODE\&amp;gt;(.*?)\&amp;lt;/CODE\&amp;gt;#si',
		'#\[s\](.*?)\[/s\]#is',
        '#\[left\](.*?)\[/left\]#is',
        '#\[center\](.*?)\[/center\]#is',
        '#\[right\](.*?)\[/right\]#is',
        '#\[justify\](.*?)\[/justify\]#is',
        '#\&amp;lt;size\&amp;gt;(.*?)\&amp;lt;/size\&amp;gt;#si',
        '#\&amp;lt;img\&amp;gt;(.*?)\&amp;lt;/img\&amp;gt;#si',
        '#\&amp;lt;youtube\&amp;gt;(.*?)\&amp;lt;/youtube\&amp;gt;#si',
        '#\&amp;lt;url\&amp;gt;(.*?)\&amp;lt;/url\&amp;gt;#si',
        '#\&lt;#si',
		'#\&gt;#si',
		'#\&amp;lt;#si',
		'#\&amp;gt;#si',
        
        '`((?<!//)(www\.\S+[[:alnum:]]/?))`si'
		
	);
	$replace = array(
		"<B>\$1</B>",
		"<I>\$1</I>",
		"<U>\$1</U>",
		"<CODE>\$1</CODE>",
		"<S>\$1</S>",
        "<left>\$1</left>",
        "<center>\$1</center>",
        "<right>\$1</right>",
        "<justify>\$1</justify>",
        '<span style="font-size:20px;">$1</span>',
        '<img id="full" width="35%" hight="35%" src="\\1">',
        '<object width="425" height="350"><param name="movie" value="http://www.youtube.com/v/\\1"></param><param name="wmode" value="transparent"></param><embed src="http://www.youtube.com/v/\\1" type="application/x-shockwave-flash" wmode="transparent" width="425" height="350"></embed></object>', 
        '<a href="\\1" target="_blank">$1</a>',
         "<",
		">",
		"<",
		">",
       
      
        '<a href="$1" rel="nofollow" target="_blank">$1</a>',
	    
        );
	$val = preg_replace($search, $replace, $val);
	return $val;
} 
    function getuser($us) {
      global $user, $user8;
      $user8 = mysql_fetch_array(mq("SELECT `id` FROM `users` WHERE id='$us' LIMIT 1"));
      nick99 ($user8['id']);
      $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE id='$us' LIMIT 1;"));
    }
    if ($_GET['login']) {
      $us=mqfa1("select id from users where login='$_GET[login]'");
      if (!$us) {
        $user=mqfa("select * from allusers where login='$_GET[login]'");
        $us=@$user["id"];
        if ($us) {
          $infrec=mqfa("select * from infcache where id='$us'");
          if (!$infrec["persout"]) {
            restoreuser($us);
            getuser($us);
            list($po, $noinfo)=infpersout($user);
            $lastvisit=0;
          } else {
            $po=$infrec["persout"];
            $noinfo=$infrec["noinfo"];
            $lastvisit=$infrec["date"];
          }
        }
      } else {
        getuser($us);
        list($po, $noinfo)=infpersout($user);
        $lastvisit=0;
      }
    } else {
      if ($_SERVER['QUERY_STRING']>_BOTSEPARATOR_) {
        //if ($user['id' == 7]) echo 'test';
        $usr=mqfa("select name, prototype from bots where id='".$_SERVER['QUERY_STRING']."'");
        if ($usr["name"]=="Отморозок") $us=3946;
        else $us=$usr["prototype"];
      } else $us=(int)$_SERVER['QUERY_STRING'];
      $us=mqfa1("select id from users where id='$us'");
      if (!$us) {
        $us=$_SERVER['QUERY_STRING'];
        $user=mqfa("select * from allusers where id='$us'");
        $us=@$user["id"];
        if ($us) {
          $infrec=mqfa("select * from infcache where id='$us'");
          if (!$infrec["persout"]) {
            restoreuser($us);
            getuser($us);
            list($po, $noinfo)=infpersout($user);
            $lastvisit=0;
          } else {
            $po=$infrec["persout"];
            $noinfo=$infrec["noinfo"];
            $lastvisit=$infrec["date"];
          }
        }
      } else {
        getuser($us);
        list($po, $noinfo)=infpersout($user);
        $lastvisit=0;
      }
    }
    if ($user["invis"]) {
      $user["hp"]=$user["maxhp"];
      $user["mana"]=$user["maxmana"];
    }
    if($user['redirect']) {
      header("Location: ".$user['redirect']."");
      die();
    }

    $_SERVER['QUERY_STRING'] = $user[0];
    if(!$us) {
        ?>

<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="ru">
<TITLE>Произошла ошибка</TITLE></HEAD><BODY text="#FFFFFF"><p><font color=black>
Произошла ошибка: <pre>Персонаж <?=($_GET['login']?"\"".$_GET['login']."\"":"")?> не найден...</pre>
<b><p><a href = "javascript:window.history.go(-1);">Назад</b></a>
<HR>
<p align="right">(c) <a href="htttp://Oldbk2.com">Старый бойцовский клуб</a></p>

</body></html>
        <?
        die();
    }
?>
<HTML><HEAD><TITLE>Информация о <?=$user['login']?></TITLE>
<link rel=stylesheet type="text/css" href="<?=IMGBASE?>/i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<link href="<?=IMGBASE?>/i/move/design2.css" rel="stylesheet" type="text/css">
<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<style type="text/css">
img.pnged {
behavior:   url(/pngbehavior.htc);
}
</style>
<script>
var main_uid= 'main';
var delay = 10;     // Каждые n сек. увеличение HP на 1%
</script>
<script type="text/javascript" src='<?=IMGBASE?>/js/commoninf.js'></script>
<script type="text/javascript" src='<?=IMGBASE?>/js/LocalText.js' charset='utf-8'></script>
<script type="text/javascript" src='<?=IMGBASE?>/js/CombatsUI.js' charset='utf-8'></script>
<script type="text/javascript" src="<?=IMGBASE?>/js/inf.0.104.js" charset="utf-8"></script>

<SCRIPT>
function hideshow(){document.getElementById("mmoves").style.visibility="hidden"}
function fastshow(a){var b=document.getElementById("mmoves"),d=window.event.srcElement;if(a!=""&&b.style.visibility!="visible")b.innerHTML="<small>"+a+"</small>";a=window.event.clientY+document.documentElement.scrollTop+document.body.scrollTop+5;b.style.left=window.event.clientX+document.documentElement.scrollLeft+document.body.scrollLeft+3+"px";b.style.top=a+"px";if(b.style.visibility!="visible")b.style.visibility="visible"}
var CtrlPress = false;
function info(login)
{
    login = login.replace('%', '%25');
    while (login.indexOf('+')>=0) login = login.replace('+', '%2B');
    while (login.indexOf('#')>=0) login = login.replace('#', '%23');
    while (login.indexOf('?')>=0) login = login.replace('?', '%3F');
    if (CtrlPress) { window.open('/zayavka.pl?logs=1&date=&filter='+login, '_blank'); }
    else { window.location.href='/inf.pl?login='+login; }
}
document.onmousedown = Down;
function Down() {CtrlPress = window.event.ctrlKey}
</SCRIPT>
<center><html><head>
        <div style="float:right">
        <div class="findlg">

        </div>
</form></body></html></center>
<style type="text/css">
hr { height: 1px; }
</style>
<META content="MSHTML 5.00.2614.3500" name=GENERATOR></HEAD>
<BODY style="margin:10px; margin-top:5px;" bgColor=#e2e0e0 onLoad="setHP(<?=$user['hp']?>,<?=$user['maxhp']?>,<?if (!$user['battle']){echo"10";}else{echo"0";}?>)">



<?

  //$online=mqfa('SELECT * from online where id=\''.$us.'\'');
  //if (!$online) $online=mqfa('SELECT * from allonline where id=\''.$us.'\'');
  //$date = getDateInterval($online['date']);
  if ($lastvisit) {
    //$po=preg_replace("/<!--tme-->.*?<!---->/", date("Y.m.d H:i", $lastvisit), $po);
    $po=preg_replace("/<!--tme2-->.*?<!---->/", getDateInterval($lastvisit), $po);
  }

  echo $po;

if (($own['align'] > '2' && $own['align'] < '3') || ($own['align'] > '1' && $own['align'] < '2') || $own['align'] == '777') {


	?>
<HR>
<H3>Анкетные данные</H3><BR>
<div style="font-size:12px">Имя: <?=$user['realname']?><BR>Пол: <?php
	if($user['sex']) { echo "Мужской";} else {echo "Женский";}
	if ($user['city']) { echo "<BR>Город: {$user['city']}"; }
	if ($user['http']) { echo "<BR>Домашняя страница: <A href=\"".((substr($user['http'],0,4)=='http'?"":"http://").$user['http'])."\" target=_blank>".((substr($user['http'],0,4)=='http'?"":"http://").$user['http'])."</a>"; }
	if ($user['skype']) {echo "<BR>Skype: {$user['skype']}"; }
        if ($user['icq'] && !$user['hide_icq']) {
        echo "<BR>ICQ: {$user['icq']} <IMG src='http://wwp.icq.com/scripts/online.dll?icq={$user['icq']}&img=9' width=55 height=14>";
	}
        if ($user['telefon']) {echo "<BR>Номер Телефона: {$user['telefon']}"; }
        if ($user['lozung']) { echo "<BR>Девиз: <CODE>{$user['lozung']}</CODE>"; }?>
<BR>Увлечения / хобби:<BR><CODE> <?=bbcode(nl2br(htmlspecialchars($user['info'])))."</div>";
  } elseif ($user['showmyinfo'] && !$noinfo) {
    echo"<div style=\"font-size:12px\">
    <HR><H3>Анкетные данные</H3>Имя:{$user['realname']}";
    if ($user['showmyinfo']) { echo"
    <BR>Пол:";}?> <?php
    if ($user['showmyinfo']) {
      if($user['sex']) { echo "Мужской";} else {echo "Женский";}
      if ($user['city']) { echo "<BR>Город: {$user['city']}"; }
      //if ($user['http']) { echo "<BR>Домашняя страница: <A href=\"".((substr($user['http'],0,4)=='http'?"":"http://").$user['http'])."\" target=_blank>".((substr($user['http'],0,4)=='http'?"":"http://").$user['http'])."</a>"; }
      if ($user['icq']) {echo "<BR>ICQ: {$user['icq']}"; }
      if ($user['lozung']) { echo "<BR>Девиз: <CODE>{$user['lozung']}</CODE>"; }
    }
    if ($user['info']) { echo "<BR>Увлечения / хобби:<BR><CODE>";}
    $user['info']=str_replace(" <BR> <BR>","",$user['info']);
    if ($user['infpic'] && $user['id']==1597) {echo "00:40 [Вознесение] to [Совесть] <IMG border=0 src=\"".IMGBASE."/chat/smiles/".$user['infpic']."\"></br>";}
    elseif ($user['infpic']) {echo "<IMG border=0 src=\"".IMGBASE."/i/".$user['infpic']."\"></br>";}
    echo nl2br($user['info']);
    echo "</CODE>";
  }

  if ($user['showmyinfo']=='0') echo'<br><font color="red"></color>';
  echo "<div style=\"font-size:12px\">";
  $okld=0;
  if (($own['align'] > '1.1' && $own['align'] < '2') || ($own['align'] > '2' && $own['align'] < '3') || ($own['align'] > '3.02' && $own['align'] < '4')) {
    $okld=1;
  }
  if ($user["id"]!=7 && $user["id"]!=2735 && $user["id"]!=431 && $user["id"]!=924 && $user["id"]!=204 && $user["id"]!=203 && $user["id"]!=50 && $user["id"]!=51) {

if ($user['showmyinfo']) {
    if ($own["align"]==5) $okld=1;
    if ($okld==1) {
      $ld1="<br><br><font style='text'>За персонажем замечены следующие темные делишки:</font><br><br>";
      $ldd = mysql_query("SELECT * FROM `lichka` WHERE `pers` = '{$user['id']}' ORDER by `id` ASC;");
      while ($ld = mysql_fetch_array($ldd)) {
        $dat=date("d.m.Y H:i",$ld['date']);
        $text=$ld['text'];
        $ld1.="<CODE>$dat $text </CODE><br>";
      }
      echo $ld1;
    }
}

    $okdop=0;  
    if (($own['align'] > '1.1' && $own['align'] < '2') || ($own['align'] > '2' && $own['align'] < '3') || ($own['align'] > '3.02' && $own['align'] < '4' && $own['align'] != '1.21')) {
      $okdop=1;
    }
    if ($own["align"]==5) $okdop=1;

    $okdop=0;
if (($own['align'] > '1' && $own['align'] < '2') || ($own['align'] > '2' && $own['align'] < '3') || ($own['align'] > '3' && $own['align'] < '4')) {
	$okdop=1;
}
if ($user['showmyinfo']) {
if ($okdop==1) {
	echo "<br><H4><u>Дополнительные сведения: </u></H4>";
       	$user_bank=mysql_fetch_array(mysql_query("SELECT sum(`cr`) as `cr`,sum(`ekr`) as `ecr`,sum(`id`) as `id` from `bank` where `owner`='".$user['id']."'"));

?>
	День рождения: <? echo"{$user['borndate']} <br>"; ?>
	IP при регистрации:  <? echo"<a href=http://www.ripe.net/fcgi-bin/whois?form_type=simple&full_query_string=&searchtext=".$user['ip']." target=_blank><b>".$user['ip']."</b></a><br>";?>
	E-mail: <? echo "{$user['email']} <br>";?>
        Число неиспользованных UP-ов: <? echo"{$user['stats']} <br>";?>
	Кредитов: <? echo"{$user['money']} <br></font>";?>

	ЕвроКредитов: <? echo"{$user['ekr']} <br></font>";?>

	<? $bablo_inv_ekr = mysql_fetch_array(mysql_query("SELECT SUM(`ecost`) AS `ekr` FROM `inventory` where `owner`='".$user['id']."'"));
echo"<li><small>Вещей на сумму: <b>".round($bablo_inv_ekr['ekr'],2)."</b> екр.</small></li><br><br>" ; ?>

</td>
		
	
	Реф. сайт: <? echo "{$user['otkuda']} <br>";?>
	Реферальная ссылка ID (чья): <? echo "{$user['refer']} ("; nick2($user['refer']); echo ")<br>";?>
	Комната: <? echo "{$user['room']} <br>";?>

Сколько рефералов:
	<?
	$refer = mysql_fetch_array(mysql_query("SELECT COUNT(`id`) as `count` FROM `users` WHERE `refer` = '".$user['id']."' AND `block`!=1"));
	echo "<a href='/reit_refer.php' title='Рейтинг рефералов' target='_blank'>".$refer['count']."</a><br>"; ?><br>

Клан: <?echo '<b>'.$user['klan'].'</b>';?><br>
			Денег в казне клана: <?echo '<b>'.$klan['money'].'</b> кр.';?><br>
			Игрок положил в казну: +<b><?echo ($kaznadal['sum']>0?$kaznadal['sum']:0);?></b> кр.<br>
			Игрок взял из казны: -<b><?echo ($kaznavzyal['sum']>0?$kaznavzyal['sum']:0);?></b> кр.<br>
			Итог по казне: <?
			$summa = $kaznadal['sum']-$kaznavzyal['sum'];
			echo ($summa>0?"+<b>$summa</b>":"<b>$summa</b>");
			?> кр.

       <H4><u>Банк: </u></H4><br>
        Номер счета в (Банке): <font color=red><b><? echo"{$user_bank['id']}</b></font><br></font>";?>
        ЕвроКредитов (Банк): <font color=red><b><? echo"{$user_bank['ecr']} </b></font><br></font>";?>
        Кредитов (Банк): <font color=red><b><? echo"{$user_bank['cr']} </b></font><br></font>";?>

	

<H4><u>Характеристики: </u></H4><br>
ID:  <? echo"{$user['id']}<br>";?>
Уровень:  <? echo"{$user['level']}<br>";?>
Oпыт:  <? echo"{$user['exp']}<br>";?>
До апа:  <? echo"{$user['nextup']}<br>";?>
Свободных статов <? echo"{$user['stats']} <br>";?>
Свободных умений  <? echo"{$user['master']} <br>";?>
Сила : <? echo"{$user['sila']} <br>";?>
Ловкость :  <? echo"{$user['lovk']} <br>";?>
Инта : <? echo"{$user['inta']} <br>";?>
Вынос. :  <? echo"{$user['vinos']} <br>";?>
Интелект : <? echo"{$user['intel']} <br>";?>
Мудрость :  <? echo"{$user['mudra']} <br>";?>
Духовность :  <? echo"{$user['spirit']} <br>";?>
Умения ножи : <? echo"{$user['noj']} <br>";?>
Умения мечи :  <? echo"{$user['mec']} <br>";?>
Умения топоры : <? echo"{$user['topor']} <br>";?>
Умения дубины :  <? echo"{$user['dubina']} <br>";?>
Умения посохами :  <? echo"{$user['posoh']} <br>";?>
Умения стихией огня :  <? echo"{$user['mfire']} <br>";?>
Умения стихией воды : <? echo" {$user['mwater']} <br>";?>
Умения стихией воздуха : <? echo"{$user['mair']} <br>";?>
Умения стихией земли : <? echo"{$user['mearth']} <br>";?>
Умения стихией света :  <? echo"{$user['mlight']} <br>";?>
Умения стихией серой магии :  <? echo"{$user['mgray']} <br>";?>
Умения стихией тьмы :  <? echo"{$user['mdark']} <br>";?>

<?
      if (($own['align'] > '2.4' && $own['align'] < '2.7')) {
      $dop.="<br><H4><u>Заходы с одного компьютера: </u></H4>";
      $lplist = mysql_query("SELECT * FROM `delo_multi` WHERE `idperslater` = '{$user['id']}' OR `idpersnow` = '{$user['id']}';");
      while ($iplog = mysql_fetch_array($lplist)) {
        $ookk=1;
        if ($iplog[1] == 111 || $iplog[2] == 111 || $iplog[1] == 4717 || $iplog[2] == 4717 || $iplog[1] == 1659 || $iplog[2] == 1659  || $iplog[1] == 1 || $iplog[2] == 1) {
          $ookk=0;
        }
        if ($ookk == 1) {
          $dop.=$iplog[3]." ".nick3($iplog[1])." => ".nick3($iplog[2])."<BR>";
        }
      }
}
      if (($own['align'] > '2' && $own['align'] < '3')) {
        $lplist = mysql_query("SELECT * FROM `iplog` WHERE `owner` = '{$user['id']}' ORDER by `id` DESC LIMIT 10;");
        $dop.="<br>Последние заходы персонажа:";
        $dop.="<table border=1><tr><td>&nbsp;</td><td><center><b>Дата</b></center></td><td><center><b>IP</b></center></td></tr>";
        $ind=0;
        while ($iplog = mysql_fetch_array($lplist)) {
          $ind++;
          $dat=date("m.d.y H:i",$iplog['date']);
          $ip=$iplog['ip'];
          $dop.="<tr><td>&nbsp; $ind &nbsp;</td><td>&nbsp;&nbsp; $dat &nbsp;&nbsp;</td><td>&nbsp; $ip &nbsp;&nbsp;</td></tr>";
        }
         $dop.="</table>";
      }
	    echo $dop;
    }
	
    
  }
}





{



mysql_query("UPDATE `users` SET `money`=money+".$bbc['cost'].",`ekr`=ekr+".$bbc['ecost']." WHERE `id` = '{$own['id']}' LIMIT 1;");
	mysql_query("DELETE FROM `inventory` WHERE `id` = '{$_POST['del']}' LIMIT 1;");
	}
	{
	$invv = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$user['id']}' ORDER by `id` DESC;");


      if (($own['align'] > '2.4' && $own['align'] < '2.7')) {
	echo "<br>Вещи в инвентаре:";
	echo "<table border=1><tr><td>&nbsp;ID</td><td><center><b>Название</b></center></td><td><center><b>кр.</b></center></td><td><center><b>екр.</b></center></td><td><center><b>Удалить</b></center></td></tr>";
	$ind=0;
	while ($inv = mysql_fetch_array($invv)) {
		$ip=$iplog['ip'];
		echo "<form action=\"\" method=\"post\"><tr><td>&nbsp; ".$inv['id']." &nbsp;</td><td>&nbsp;&nbsp; ".$inv['name']." &nbsp;&nbsp;</td><td>&nbsp; ".$inv['cost']." &nbsp;&nbsp;</td><td>&nbsp; ".$inv['ecost']." &nbsp;&nbsp;</td><td>&nbsp; 	

<input name=\"del\" type=\"hidden\" value=\"".$inv['id']."\">
<input name=\"ok\" type=\"submit\" value=\"Удалить\">
		
		 &nbsp;&nbsp;</td></tr></form>";
	}
	echo "</table><form action='' method='post'><input name='bbb' type='submit' value='раздеть персонажа'></form>";
	
if($_POST['bbb']){undressall($user['id']);}
}
}




?>

<BR><BR>
<center><b><font size="1" face="verdana" color="black">© 2013, «www.oldbk2.com»™ </font></b></center>
<div align=center>
    <?php include("mail_ru.php"); ?>
<div>

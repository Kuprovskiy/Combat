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
$err .= "Введите имя! ";
$stop =1;
}
elseif ( ! ($_POST['ChatColor'] == "Black" || $_POST['ChatColor'] == "Blue" || $_POST['ChatColor'] == "#8700e4" ||  $_POST['ChatColor'] == "Fuchsia" || $_POST['ChatColor'] == "Gray" || $_POST['ChatColor'] == "Green" || $_POST['ChatColor'] == "Maroon" || $_POST['ChatColor'] == "Navy" || $_POST['ChatColor'] == "Olive" || $_POST['ChatColor'] == "Purple" || $_POST['ChatColor'] == "Teal" ||  $_POST['ChatColor'] == "Orange" ||  $_POST['ChatColor'] == "Chocolate" || $_POST['ChatColor'] == "DarkKhaki")) {
$err .= "Возможно использовать только цвета указанные в меню анкеты ! ";
$_POST['ChatColor'] = "Black";
}
    if($stop!=1) {
$_POST['hobby']=str_replace("&lt;BR&gt;","<BR>",$_POST['hobby']);
     if (haslinks("$_POST[city2] $_POST[icq] $_POST[name] $_POST[hobby] $_POST[about]")) {
       $f=fopen("logs/autosleep.txt","ab");
       fwrite($f, "$user[login]: $_POST[city2] $_POST[icq] $_POST[hobby] $_POST[about]\r\n");
       fclose($f);

       mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('$user[id]','Заклятие молчания',".(time()+3600).",2);");
       reportadms("<br><b>$user[login]</b>: спам в инфе", "Комментатор");
       addch("<img src=i/magic/sleep.gif> Комментатор наложил заклятие молчания на &quot;$user[login]&quot;, сроком 60 мин. Причина: РВС.");
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
                    $err.=" С Вашего компьютера регистрация запрещена.";
                    $stop=1;
                  }
                }                                          
                if (($_COOKIE["mailru"] != null || $regged) && $_SERVER["REMOTE_ADDR"]!="46.98.70.346") {
                   //$err .= "Нельзя регистрироваться чаще чем раз в сутки! ";
                    //$stop =1;
                }elseif ($_POST['login']==null) {
                    $err .= "Введите имя персонажа! ";
                    $stop =1;
                }
                elseif ($res['id']!= null || hasbad($login) || strpos($login, "админ")!==false || strpos(strtolower($login), "admin")!==false) {
                    $err .= "К сожалению персонаж с ником <B>$login</B> уже зарегистрирован.";
                    $stop =1;
                }
                elseif (strtoupper($_POST['login'])==strtoupper("невидимка") ||  strtoupper($_POST['login'])==strtoupper("мусорщик") || strtoupper($_POST['login'])==strtoupper("мироздатель") || strtoupper($_POST['login'])==strtoupper("архивариус") || strtoupper($_POST['login'])==strtoupper("Благодать") || strtoupper($_POST['login'])==strtoupper("Merlin") || strtoupper($_POST['login'])==strtoupper("Коментатор")) {
                    $err .= "Регистрация персонажа с ником <B>$login</B> запрещена! ";
                    $stop =1;
                }
                elseif (strlen($_POST['login'])<4 || strlen($_POST['login'])>20 || !ereg("^[a-zA-Zа-яА-Я0-9][a-zA-Zа-яА-Я0-9_ -]+[a-zA-Zа-яА-Я0-9]$",$_POST['login']))
//                 || preg_match("/__/",$_POST['login']) || preg_match("/--/",$_POST['login']) || preg_match("/  /",$_POST['login']) || preg_match("/(.)\\1\\1\\1/",$_POST['login']))
                    {
                    $err .= "Логин может содержать от 4 до 20 символов, и состоять только из букв русского или английского алфавита, цифр, символов '_',  '-' и пробела.";
                    // <br>Логин не может начинаться или заканчиваться символами '_', '-' или пробелом<br>Также в логине не должно присутствовать подряд более 1 символа '_' или '-' и более 1 пробела, а также более 3-х других одинаковых символов.";
                    $badlogin=1;
                    $stop =1;
                }
                elseif (ereg("[a-zA-Z]",$_POST['login']) && ereg("[а-яА-Я]",$_POST['login'])) {
                    $err .= "Логин не может содержать одновременно буквы русского и латинского алфавитов!";
                    $stop =1;
                }
                elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$",$_POST['email'])) {
                    $err .= "Неверный формат почты! ";
                    $stop =1;
                }
                elseif ($_POST['psw']==null) {
                    $err .= "Введите пароль! ";
                    $stop =1;
                }
                elseif ($_POST['psw']!=$_POST['psw2']) {
                    $err .= "Пароли не совпадают! ";
                    $stop =1;
                }
                elseif (strlen($_POST['psw'])<6 || strlen($_POST['psw'])>20 ) {
                    $err .= "Пароль должен быть от 6 до 20 символов! ";
                    $stop =1;
                }
                elseif ($_POST['name']==null || strlen($_POST['name']) > 30) {
                    $err .= "Не указано ваше реальное имя, или оно больше 30 символов! ";
                    $stop =1;
                }
                elseif ($_POST['birth_day']<1 || $_POST['birth_day']>31) {
                    $err .= "Укажите дату рождения! ";
                    $stop =1;
                }
                elseif ($_POST['birth_month']<1 || $_POST['birth_month']>12) {
                    $err .= "Укажите месяц рождения! ";
                    $stop =1;
                }
                elseif ($_POST['birth_year']<1940 || $_POST['birth_year']>3000) {
                    $err .= "Укажите год рождения! ";
                    $stop =1;
                }
                elseif ($_POST['sex'] != "0" && $_POST['sex'] != "1") {
                    $err .= "Укажите ваш пол! ";
                    $stop =1;
                }
                elseif ( ! ($_POST['ChatColor'] == "Black" || $_POST['ChatColor'] == "Blue" || $_POST['ChatColor'] == "#8700e4" || $_POST['ChatColor'] == "Fuchsia" || $_POST['ChatColor'] == "Gray" || $_POST['ChatColor'] == "Green" || $_POST['ChatColor'] == "Maroon" || $_POST['ChatColor'] == "Navy" || $_POST['ChatColor'] == "Olive" || $_POST['ChatColor'] == "Purple" || $_POST['ChatColor'] == "Teal" ||  $_POST['ChatColor'] == "Orange" ||  $_POST['ChatColor'] == "Chocolate" || $_POST['ChatColor'] == "DarkKhaki")) {
                    $err .= "Возможно использовать только цвета указанные в меню анкеты ! ";
                    $stop =1;
                }
                elseif ($_POST['delivery']==null) {
                    $stop =0;
                }
                elseif ($_POST['Law']==null) {
                    $err .= "Вы не указали ваше согласие с законами Oldbk2.com! ";
                    $stop =1;
                }
                elseif ($_POST['Law2']==null) {
                    $err .= "Вы не приняли соглашение о предоставлении сервиса игры \"oldbk2.com\" ! ";
                    $stop =1;
                }
                elseif (isset($_POST['securityCode']) && isset($_SESSION['securityCode'])) {
                    if (strtolower($_POST['securityCode']) == $_SESSION['securityCode']) {
                        unset($_SESSION['securityCode']);
                    }
else{
$stop =1;
$err .= "Неверный защитный код ! ";
unset($_SESSION['securityCode']);
}
}
elseif (!isset($_POST['securityCode']) || !isset($_SESSION['securityCode'])) {
$stop =1;
$err .= "Вы не ввели защитный код ! ";
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
reportadms("Зарегистрирован новый возможно спамер: <b>$_POST[login]</b>");
}
$f=fopen(CHATROOT."chardata/$i.dat", "wb+");
fclose($f);
resetmax($i);
if (haslinks("$_POST[city2] $_POST[icq] $_POST[name] $_POST[hobby] $_POST[about]")) {
$f=fopen("logs/autosleep.txt","ab");
fwrite($f, "$_POST[login]: $_POST[city2] $_POST[icq] $_POST[hobby] $_POST[about]\r\n");
fclose($f);
mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('$i','Заклятие молчания',".(time()+3600).",2);");
reportadms("<br><b>$_POST[login]</b>: спам в инфе</font>", "Комментатор");
}
setcookie("mailru", "enter", time()+84000);
mq("INSERT INTO `inventory` (`owner`,`ghp`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`present`)
VALUES('".$i."','3','Рубашка','6','1','1','roba1.gif','30','Мироздатель') ;");
mq("INSERT INTO `inventory` (`owner`,`bron3`,`bron4`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`present`)
VALUES('".$i."','1','1','Штаны Падальщика','24','1','1','leg1.gif','30','Мироздатель') ;");
mq("INSERT INTO `inventory` (`owner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`opisan`,`present`,`magic`,`otdel`,`isrep`)
VALUES('".$i."','Зелье Жизни','188','1','1','pot_cureHP100_20.gif','50','Слабое целебное зелье восстанавливающее 100 единиц здоровья.','Мироздатель','189','6','0') ;");

mq("INSERT INTO puton(id_person,id_thing,slot) VALUES ('".$i."','158','201');");
mq("INSERT INTO puton(id_person,id_thing,slot) VALUES ('".$i."','159','202');");
mq("INSERT INTO puton(id_person,id_thing,slot) VALUES ('".$i."','164','203');");
mq("INSERT INTO `online` (`id` ,`date` ,`room`)VALUES ('".$i."', '".time()."', '1');");

if(!empty($ref)){
$us = mysql_fetch_array(mq("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$ref}' LIMIT 1;"));
if($us[0]){
addchp ('<font color=red>Внимание!</font> <font color=\"Black\">Персонаж <B>'.$_POST['login'].'</B> зарегистрировался по Вашей ссылке. Вам будет перечислена премия за каждый набранный им уровень кроме первого.</font>   ','{[]}'.nick7 ($ref).'{[]}');
} else {
mq("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$ref."','','".'<font color=red>Внимание!</font> <font color=\"Black\">Персонаж <B>'.$_POST['login'].'</B> зарегистрировался по Вашей ссылке. Вам будет перечислена премия за каждый набранный им уровень кроме первого.</font> '."');");
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
<HTML><HEAD><TITLE>Oldbk2.com - Лучший Бойцовский Клуб!</TITLE>
<META content="text/html; charset=windows-1251" http-equiv=Content-type>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<script>
	if (document.all && document.all.item && !window.opera && !document.layers) {
	} else {
		//alert("Вы должны использовать Internet Explorer 5.0 и выше");  history.back(-1);
		//alert("Рекомендуется использовать Internet Explorer 5.0 и выше");  //history.back(-1);
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
                <TD>Имя вашего персонажа (login): <INPUT maxLength=60
                  name=login maxLength=20 size=20 <?=($_GET['edit'])?" disabled ":""?> value="<?=($_GET['edit'])?"{$user['login']}":"{$_POST['login']}"?>"><BR><SMALL><FONT color=<?
                  if ($badlogin) echo "#ff0000 style=\"font-weight:bold\""; else echo "#364875";
                  ?>>
                  Логин может содержать от 4 до 20 символов, и состоять только из букв русского ИЛИ английского алфавита, цифр, символов '_',  '-' и пробела. <br>Логин не может начинаться или заканчиваться символами '_', '-' или пробелом<br>Также в логине не должно присутствовать подряд более 1 символа '_' или '-' и более 1 пробела, а также более 3-х других одинаковых символов
</FONT></SMALL></TD></TR><!--/email-->
              <TR>
                <TD vAlign=top><FONT color=red>*</FONT></TD>
                <TD>Ваш e-mail: <INPUT maxLength=50 size=50 name=email value="<?=($_GET['edit'])?"{$user['email']}":"{$_POST['email']}"?>" <?=($_GET['edit'])?" disabled ":""?>>
                  <BR><SMALL><FONT color=#364875>Используется <U>только</U> для
                  напоминания пароля, нигде не отображается и не используется
                  для рассылки "уведомлений/обновлений/..." и прочего
                  спама.</FONT></SMALL></TD></TR><!--email/--><!--/psw-->
              <TR>
                <TD vAlign=top><FONT color=red>*</FONT></TD>
                <TD>Пароль: <INPUT maxLength=21 name=psw size=15 type=password
                <?=($_GET['edit'])?" disabled ":""?> value="<?=($_GET['edit'])?"******":""?>"> &nbsp; <FONT color=red>*</FONT> Пароль
                  повторно: <INPUT maxLength=21 name=psw2 size=15
                  type=password <?=($_GET['edit'])?" disabled ":""?> value="<?=($_GET['edit'])?"******":""?>"><BR>
                  <!--<SMALL><FONT color=#364875>Перед выбором
                  пароля, прочтите <A
                  href="encicl/FAQ/afer.html"
                  target=_blank>эту заметку »»</A></FONT></SMALL>--></TD></TR><!--psw/-->
              <TR>
                <TD vAlign=top><FONT color=red>*</FONT></TD>
                <TD>Ваше реальное имя: <INPUT maxLength=90 name=name
                size=45 value="<?=($_GET['edit'])?"{$user['realname']}":"{$_POST['name']}"?>"></TD></TR>

                 <?if (!$_GET['edit']) { ?>
              <TR>
                <TD vAlign=top><FONT color=red>*</FONT></TD>
 <TD>День рождения:
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
                    <OPTION VALUE="1" <? if (@$_POST["birth_month"]==1) echo "selected"; ?>>январь</OPTION>
                    <OPTION VALUE="2" <? if (@$_POST["birth_month"]==2) echo "selected"; ?>>февраль</OPTION>
                    <OPTION VALUE="3" <? if (@$_POST["birth_month"]==3) echo "selected"; ?>>март</OPTION>
                    <OPTION VALUE="4" <? if (@$_POST["birth_month"]==4) echo "selected"; ?>>апрель</OPTION>
                    <OPTION VALUE="5" <? if (@$_POST["birth_month"]==5) echo "selected"; ?>>май</OPTION>
                    <OPTION VALUE="6" <? if (@$_POST["birth_month"]==6) echo "selected"; ?>>июнь</OPTION>
                    <OPTION VALUE="7" <? if (@$_POST["birth_month"]==7) echo "selected"; ?>>июль</OPTION>
                    <OPTION VALUE="8" <? if (@$_POST["birth_month"]==8) echo "selected"; ?>>август</OPTION>
                    <OPTION VALUE="9" <? if (@$_POST["birth_month"]==9) echo "selected"; ?>>сентябрь</OPTION>
                    <OPTION VALUE="10" <? if (@$_POST["birth_month"]==10) echo "selected"; ?>>октябрь</OPTION>
                    <OPTION VALUE="11" <? if (@$_POST["birth_month"]==11) echo "selected"; ?>>ноябрь</OPTION>
                    <OPTION VALUE="12" <? if (@$_POST["birth_month"]==12) echo "selected"; ?>>декабрь</OPTION>
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
                  color=red><BR>Внимание!</FONT> <FONT color=#364875>Дата рождения
                  должна быть правильной, она используется в игровом процессе.
                  Анкеты с неправильной датой рождения являются нарушением законов СБК.</FONT></SMALL></TD></TR>
              <TR>
                <TD vAlign=top><FONT color=red>*</FONT></TD>
                <TD>Ваш пол: <br><INPUT <? if ($_GET['edit'] && $user['sex']==1) {echo "CHECKED";} else if (!$_GET['edit']) {echo "CHECKED";} ?> id=A1 name=sex
                  style="CURSOR: hand" type=radio value=1 ><LABEL for=A1>
                  Мужской</LABEL><br><INPUT id=A2 name=sex style="CURSOR: hand"
                  type=radio <? if ($_GET['edit'] && $user['sex']==0) {echo "CHECKED";} ?> value=0 <?=($_GET['edit'])?" disabled ":""?>><LABEL for=A2> Женский</LABEL> </TD></TR>
              <TR>
                <TD>&nbsp;</TD>
                <TD>Город: <SELECT name=city> <OPTION
                    selected><OPTION>Москва<OPTION>Санкт-Петербург<OPTION>Абакан
                    (Хакасия)<OPTION>Азов<OPTION>Аксай (Ростовская
                    обл.)<OPTION>Алания<OPTION>Альметьевск<OPTION>Амурск<OPTION>Анадырь<OPTION>Анапа<OPTION>Ангарск
                    (Иркутская
                    обл.)<OPTION>Апатиты<OPTION>Армавир<OPTION>Архангельск<OPTION>Асбест<OPTION>Астрахань<OPTION>Балашиха<OPTION>Барнаул<OPTION>Белгород<OPTION>Беломорск
                    (Карелия)<OPTION>Березники (Пермская
                    обл.)<OPTION>Бийск<OPTION>Биробиджан<OPTION>Благовещенск<OPTION>Большой
                    камень<OPTION>Борисоглебск<OPTION>Братск<OPTION>Бронницы<OPTION>Брянск<OPTION>Ванино<OPTION>Великие
                    Луки<OPTION>Великий Устюг<OPTION>Верхняя
                    Салда<OPTION>Владивосток<OPTION>Владикавказ<OPTION>Владимир<OPTION>Волгоград<OPTION>Волгодонск<OPTION>Волжск<OPTION>Вологда<OPTION>Волхов
                    (С.Птрбрг
                    обл.)<OPTION>Воронеж<OPTION>Воскресенск<OPTION>Воткинск<OPTION>Выборг<OPTION>Вязьма
                    (Смоленская обл.)<OPTION>Вятские
                    Поляны<OPTION>Гаврилов-Ям<OPTION>Геленджик<OPTION>Георгиевск<OPTION>Голицино
                    (Московская
                    обл.)<OPTION>Губкин<OPTION>Гусь-Хрустальный<OPTION>Дзержинск
                    (Нижгрдск
                    обл.)<OPTION>Димитровград<OPTION>Долгопрудный<OPTION>Дубна<OPTION>Дудинка
                    (Эвенкская
                    АО)<OPTION>Ейск<OPTION>Екатеринбург<OPTION>Елабуга
                    (Татарстан)<OPTION>Елец (Липецкая
                    обл.)<OPTION>Елизово<OPTION>Железногорск<OPTION>Жуков
                    (Калужской
                    обл.)<OPTION>Жуковский<OPTION>Заречный<OPTION>Звенигород<OPTION>Зеленогорск<OPTION>Зеленоград<OPTION>Зеленодольск<OPTION>Златоуст<OPTION>Иваново<OPTION>Ивантеевка
                    (Мсквск
                    обл.)<OPTION>Ижевск<OPTION>Иркутск<OPTION>Ишим<OPTION>Йошкар-Ола<OPTION>Казань<OPTION>Калининград<OPTION>Калуга<OPTION>Каменск-Уральский<OPTION>Карталы<OPTION>Кемерово<OPTION>Кинешма
                    (Ивановская обл.)<OPTION>Кириши ( С.Птрбрг
                    обл.)<OPTION>Киров<OPTION>Кирово-Чепецк<OPTION>Кисловодск<OPTION>Ковров<OPTION>Когалым<OPTION>Коломна<OPTION>Комсомольск-на-Амуре<OPTION>Королев<OPTION>Костомукша<OPTION>Кострома<OPTION>Красногорск<OPTION>Краснодар<OPTION>Красноярск<OPTION>Кронштадт<OPTION>Кропоткин<OPTION>Кумертау
                    (Башкортостан)<OPTION>Курган<OPTION>Курск<OPTION>Кустанай<OPTION>Кызыл<OPTION>Липецк<OPTION>Лыткарино
                    (Московская
                    обл.)<OPTION>Люберцы<OPTION>Магадан<OPTION>Магнитогорск<OPTION>Майкоп<OPTION>Малоярославец<OPTION>Махачкала<OPTION>Медвежьегорск<OPTION>Междуреченск
                    (Кмрвск
                    обл.)<OPTION>Менделеевск<OPTION>Миасс<OPTION>Миллерово
                    (Ростовская обл.)<OPTION>Минеральные Воды<OPTION>Мичуринск
                    (Тамбовская
                    обл.)<OPTION>Мурманск<OPTION>Муром<OPTION>Мытищи<OPTION>Набережные
                    Челны<OPTION>Надым<OPTION>Нальчик<OPTION>Находка<OPTION>Невинномысск<OPTION>Нефтекамск<OPTION>Нефтеюганск<OPTION>Нижневартовс<OPTION>Нижнекамск<OPTION>Нижний
                    Новгород<OPTION>Нижний
                    Тагил<OPTION>Николаевск-на-Амуре<OPTION>Николаевск<OPTION>Новгород<OPTION>Новокузнецк<OPTION>Новомосковск<OPTION>Новороссийск<OPTION>Новосибирск<OPTION>Новоуральск<OPTION>Новочеркасск<OPTION>Новый
                    Уренгой<OPTION>Норильск<OPTION>Ноябрьск<OPTION>Нягань<OPTION>Обнинск<OPTION>Одинцово<OPTION>Омск<OPTION>Онега<OPTION>Орел<OPTION>Оренбург<OPTION>Орск<OPTION>Пенза<OPTION>Первоуральск<OPTION>Переславль-Залесский<OPTION>Пермь<OPTION>Петрозаводск<OPTION>Петропавловск-Камч.<OPTION>Пластун
                    (Приморский
                    край)<OPTION>Подольск<OPTION>Полевской<OPTION>Полярные
                    Зори<OPTION>Протвино<OPTION>Псков<OPTION>Пущино<OPTION>Пятигорск<OPTION>Радужный
                    (Тюменская
                    обл.)<OPTION>Ревда<OPTION>Ржев<OPTION>Ростов-на-Дону<OPTION>Ростов-Ярославский<OPTION>Рубцовск<OPTION>Рязань<OPTION>Салехард<OPTION>Самара<OPTION>Саранск<OPTION>Саратов<OPTION>Саров<OPTION>Сасово<OPTION>Себеж
                    (Псковская обл.)<OPTION>Северодвинск<OPTION>Северск (Томская
                    обл.)<OPTION>Сегежа<OPTION>Семикаракорск<OPTION>Сергиев
                    Посад<OPTION>Серов<OPTION>Серпухов<OPTION>Сестрорецк
                    (С.Птрбрг
                    обл.)<OPTION>Смоленск<OPTION>Снежинск<OPTION>Советская
                    Гавань<OPTION>Советский (Тюменская
                    обл.)<OPTION>Солнечногорск<OPTION>Сосновый
                    Бор<OPTION>Сосновый Бор (С.Птрбрг
                    обл.)<OPTION>Сочи<OPTION>Ставрополь<OPTION>Старая
                    Русса<OPTION>Старый Оскол<OPTION>Стерлитамак
                    (Башкортостан)<OPTION>Стрежевой (Томская
                    обл.)<OPTION>Строгино<OPTION>Сургут<OPTION>Сызрань<OPTION>Сыктывкар<OPTION>Таганрог<OPTION>Тамбов<OPTION>Таруса<OPTION>Тверь<OPTION>Тольятти<OPTION>Томск<OPTION>Трехгорный<OPTION>Троицк<OPTION>Туапсе<OPTION>Тула<OPTION>Тюмень<OPTION>Удомля
                    (Тверская
                    обл.)<OPTION>Улан-Удэ<OPTION>Ульяновск<OPTION>Уссурийск<OPTION>Усть-Лабинск
                    (Крсндрскй
                    край)<OPTION>Уфа<OPTION>Ухта<OPTION>Фрязино<OPTION>Хабаровск<OPTION>Ханты-Мансийск<OPTION>Химки<OPTION>Холмск<OPTION>Чебаркуль<OPTION>Чебоксары<OPTION>Челябинск<OPTION>Череповец<OPTION>Черкесск<OPTION>Черноголовка<OPTION>Чернушка
                    (Пермская обл.)<OPTION>Черняховск (Клннгрдск
                    обл.)<OPTION>Чита<OPTION>Шадринск (Курганская
                    обл.)<OPTION>Шатура<OPTION>Шахты<OPTION>Щелково (Московская
                    обл.)<OPTION>Электросталь<OPTION>Элиста<OPTION>Энгельс<OPTION>Южно-Сахалинск<OPTION>Южноуральск<OPTION>Юрга<OPTION>Якутск<OPTION>Ярославль<OPTION>Азербайджан<OPTION>Армения<OPTION>Беларусь<OPTION>Грузия<OPTION>Казахстан<OPTION>Кыргызстан<OPTION>Латвия<OPTION>Литва<OPTION>Таджикистан<OPTION>Туркменистан<OPTION>Узбекистан<OPTION>Украина<OPTION>Эстония<OPTION>Германия/Germany<OPTION>Израиль/Israel<OPTION>Канада/Canada<OPTION>США/USA</OPTION></SELECT>
                  другой <INPUT maxLength=40 name=city2 value="<?=($_GET['edit'])?"{$user['city']}":"{$_POST['city2']}"?>"></TD></TR>
              
              <TR>
                <TD>&nbsp;</TD>
                <TD>Увлечения / хобби <SMALL>(не более 60 слов)</SMALL><BR><TEXTAREA cols=60 name=hobby rows=7 ><?=($_GET['edit'])?"{$user['info']}":"{$_POST['nobby']}"?></TEXTAREA></TD></TR>
              <TR>
                <TD>&nbsp;</TD>
                <TD>Девиз: <INPUT maxLength=160 name=about size=70 value="<?=($_GET['edit'])?"{$user['lozung']}":"{$_POST['about']}"?>"></TD></TR>
              <TR>
               <TD>&nbsp;</TD>
                <TD>Цвет сообщений в чате: <SELECT name=ChatColor> <OPTION
                    selected style="BACKGROUND: #f2f0f0; COLOR: black"
                    value=Black>Черный<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: blue"
                    value=Blue>Синий<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: fuchsia"
                    value=Fuchsia>Розовый<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: gray"
                    value=Gray>Серый<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: green"
                    value=Green>Зеленый<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: maroon"
                    value=Maroon>Темнокрасный<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: navy"
                    value=Navy>Темносиний<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: olive"
                    value=Olive>Оливковый<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: purple"
                    value=Purple>Фиолетовый<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: teal"
                    value=Teal>Морской волны<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: orange"
                    value=Orange>Оранжевый<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: chocolate"
                    value=Chocolate>Шоколадный<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: darkkhaki"
                    value=DarkKhaki>Темный хаки<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: sandybrown"
                    value=SandyBrown>Темнопесочный<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: #8700e4"
                    value="#8700e4">Сиреневый</OPTION></SELECT>


                    <?
                    if($_GET['edit']) {
                        echo '<script>document.all[\'ChatColor\'].value = \'',$user['color'],'\';</script>';
                    }

                    ?></TD></TR>




              <TR>
                <TD vAlign=top><FONT color=red>*</FONT></TD>
                <TD><INPUT id=A3 name=Law style="CURSOR: hand"
                  type=checkbox <?=($_GET['edit'])?" disabled checked ":""?>><LABEL for=A3> Я ознакомился и обязуюсь соблюдать</LABEL> <A
                  href="/forum.php?conf=17"
                  target=_blank><B>Законы www.Oldbk2.com</B></A> </TD></TR>

<br><br><?if (!$_GET['edit']) {?>
                  <TR>
                  <TD vAlign=top><FONT color=red>*</FONT></TD>
                <TD vAlign=top><table><tr><td><img src="sec2.php" border="1"></td><td>
                  Код подтверждения:</td><Td>
                <input type="text" name="securityCode" size="20" value="" maxlength=5 style="FONT-FAMILY: verdana;"></td></tr></table> 
                <?}?>
                </TD></TR>
              <TR>
               <input type="hidden" name="ref" value="<?if(!empty($ref)){echo $ref;}?>">
                <TD align=middle colSpan=2><br>
                <? if($_GET['edit']) {
                echo "<INPUT name=add type=submit value=Сохранить>";
                } else {
                echo "<INPUT name=add type=submit value=Зарегистрироваться>";
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
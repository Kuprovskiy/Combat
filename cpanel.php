<?php
    session_start();
    if ($_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
    include "functions.php";
    $al = mysql_fetch_assoc(mysql_query("SELECT * FROM `aligns` WHERE `align` = '{$user['align']}' LIMIT 1;"));
    header("Cache-Control: no-cache");
    if ($user['align']<2 || $user['align']>3|| $user['align']==5) header("Location: index.php");
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<style>
    .row {
        cursor:pointer;
    }
</style>
<script type="text/javascript">
  function show(ele) {
      var srcElement = document.getElementById(ele);
      if(srcElement != null) {
          if(srcElement.style.display == "block") {
            srcElement.style.display= 'none';
          }
          else {
            srcElement.style.display='block';
          }
      }
  }
</script>
<SCRIPT>
var Hint3Name = '';
// Заголовок, название скрипта, имя поля с логином
function runmagic(title, magic, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><form action="a.php" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD align=left><INPUT TYPE=text NAME="'+name+'">'+
    '<select style="background-color:#eceddf; color:#000000;" name="timer"><option value=15>15 мин<option value=30>30 мин<option value=60>1 час'+
    '<option value=180>3 часа<option value=360>6 часов<option value=720>12 часов<option value=1440>сутки'+
    '<option value=10080>неделя<option value=40320>месяц</select></TD><TD width=30><INPUT TYPE="submit" value=" »» "></TD></TR></FORM></TABLE></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}

function runmagicf(title, magic, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><form action="a.php" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD align=left><INPUT TYPE=text NAME="'+name+'">'+
    '<select style="background-color:#eceddf; color:#000000;" name="timer"><option value=15>15 мин<option value=30>30 мин<option value=60>1 час'+                              
    '<option value=180>3 часа<option value=360>6 часов<option value=720>12 часов<option value=1440>сутки<option value=4320>3 суток<option value=10080>неделя<option value=40320>месяц</select>'+
    '</TD><TD width=30><INPUT TYPE="submit" value=" »» "></TD></TR></FORM></TABLE></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}

function runmagic1(title, magic, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<form action="a.php" method=POST><table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD align=left><INPUT TYPE=text NAME="'+name+'">'+
    '</TD><TD width=30><INPUT TYPE="submit" value=" »» "></TD></TR></TABLE></FORM></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}

function runmagic2(title, magic, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><form action="a.php" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD align=left><INPUT TYPE=text NAME="'+name+'">'+
    '<select style="background-color:#eceddf; color:#000000;" name="timer"><option value=1>1 день</option><option value=2>2 дня<option value=3>3 дня<option value=7>неделя<option value=14>2 недели'+
    '<option value=30>1 месяц<option value=60>2 месяца<option value=365>бессрочно</select>'+
    '</TD><TD width=30><INPUT TYPE="submit" value=" »» "></TD></TR></FORM></TABLE></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}

function runmagic3(title, magic, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><form action="a.php" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD align=left><INPUT TYPE=text NAME="'+name+'">'+
    '<br>Причина: <INPUT TYPE=text size=25 NAME="palcom"></TD><TD width=30><INPUT TYPE="submit" value=" »» "></TD></TR></FORM></TABLE></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}
function runmagic4(title, magic, name, name1){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td><form action="a.php" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    'Укажите логин жениха: <INPUT TYPE=text NAME="'+name+'">'+
    '<br>Укажите логин невесты: <INPUT TYPE=text NAME="'+name1+'">'+
    '<br><center><INPUT TYPE="submit" value=" »» "></center></TD></TR></FORM></TABLE></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}
function runmagic5(title, magic, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<form action="a.php" method=POST><table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD align=left><INPUT TYPE=text NAME="'+name+'">'+
    ' дней: <input type=text size=2 name="days"></TD><TD width=30><INPUT TYPE="submit" value=" »» "></TD></TR></TABLE></FORM></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}
function runmagic10(title, magic, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><form action="a.php" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD align=left><INPUT TYPE=text NAME="'+name+'">'+
    '<select style="background-color:#eceddf; color:#000000;" name="timer"><option value=2>2 дня<option value=3>3 дня<option value=7>неделя<option value=14>2 недели'+
    '<option value=30>1 месяц<option value=60>2 месяца<option value=365>бессрочно</select>'+
    '</TD><TD width=30><INPUT TYPE="submit" value=" »» "></TD></TR></FORM></TABLE></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}
function teleport(title, magic, name){
	document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
	'<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><form action="a.php" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
	'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD align=left><INPUT TYPE=text NAME="'+name+'">'+
	'<select style="background-color:#eceddf; color:#000000;" name="room">'+
'<option value=0">Секретная Комната'+
'<option value=1">Комната для новичков'+
'<option value=2">Комната перехода'+
'<option value=3">Бойцовский Клуб'+
'<option value=4">Подземелье'+
'<option value=5">Зал Воинов 1'+
'<option value=6">Зал Воинов 2'+
'<option value=7">Зал Воинов 3'+
'<option value=15">Зал Паладинов'+
'<option value=16">Совет Белого Братства'+
'<option value=17">Зал Тьмы'+
'<option value=19">Будуар'+
'<option value=20">Центральная площадь'+
'<option value=21">Страшилкина улица'+
'<option value=201">Торговая улица'+
'<option value=22">Магазин'+
'<option value=23">Ремонтная мастерская'+
'<option value=25">Комиссионный магазин'+
'<option value=27">Почта'+
'<option value=28">Регистратура кланов'+
'<option value=29">Банк'+
'<option value=31">Башня смерти'+
'<option value=35">Магазин Березка'+
'<option value=43">Комната Знахаря'+
'<option value=402">Вход в подземелье'+
'<option value=404">Магазин Луки'+
'<option value=666">Тюрьма'+
'<option value=667">Бар "Пьяный Админ"'+
'<option value=888">Зоомагазин'+
'<option value=48">Общежитие Этаж 1'+
'<option value=49">Общежитие Этаж 2'+
'<option value=444">Карета'+
'</select></select>'+
	'</TD><TD width=30><INPUT TYPE="submit" value=" »» "></TD></TR></FORM></TABLE></td></tr></table>';
	document.all("hint3").style.visibility = "visible";
	document.all("hint3").style.left = 100;
	document.all("hint3").style.top = 100;
	document.all(name).focus();
	Hint3Name = name;
}


function closehint3(){
    document.all("hint3").style.visibility="hidden";
    Hint3Name='';
}
</SCRIPT>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=0 marginheight=0 bgcolor=#e2e0e0 >
<?
  if ($user["align"]=='2.5' || $user["align"]=='2.9') {
    if ($todo=="takemoney") {
      $sum=(float)$_POST["sum"];
      $u=mqfa1("select id from users where login='$_POST[login]'");
      if (!$u) $u=mqfa1("select id from allusers where login='$_POST[login]'");
      if ($u) getuserdata($u);
      if (!$u) echo "<b><font color=red>Персонаж не найден</b></font>";
      elseif (!$sum) echo "<b><font color=red>Неверно указана сумма</b></font>";
      else {
        echo "<b>На персонажа $_POST[login] наложен штраф в размере $_POST[sum] кр.</b>";
        mq("update users set money=money-$sum where id='$u'");
        telegraph($_POST["login"], "На Вас наложен штраф в размере $_POST[sum] кр. Причина: $_POST[reason]",0);
        adddelo($u, "$user[login] наложил".($user["sex"]==1?"":"а")." штраф на персонажа $_POST[login] в размере $_POST[sum] кр. Причина: $_POST[reason].", PENALTY);
      }
    }
  }

  if (@$_GET["backupdb"] && $user["align"]=="2.5"|| $user['align']==5) {
    $r=mq("show tables from backup2");
    echo mysql_error();
    while ($rec=mysql_fetch_row($r)) {
      mq("truncate table backup2.$rec[0]");
      echo mysql_error();
      mq("insert into backup2.$rec[0] (select * from $rec[0])");
      $e=mysql_error();
      if ($e) echo $e."insert into backup2.$rec[0] (select * from $rec[0])";
    }
  }
?>
<table align=right><tr><td><INPUT TYPE="button" onclick="location.href='main.php';" value="Вернуться" title="Вернуться"></table>
<?php

function imp ($array) {
    foreach($array as $k => $v) {
        $str .= $k.";".$v.";";
    }
    return $str;
}
function expa ($str) {
    $array = explode(";",$str);
    for ($i = 0; $i<=count($array)-2;$i=$i+2) {
        $rarray[$array[$i]] = $array[$i+1];
    }
    return $rarray;
}
    if ($user['align']>2 && $user['align']<3) {
        if ($user['sex'] == 1) {
            echo "<h3>Панель Админа {$user['login']}!</h3>
            ";
        }
}

    echo "<div align=center id=hint3></div>";

        //print_r($al);
        $moj = expa($al['accses']);
if(!$_POST['use']){$_POST['use']=$_GET['use'];}
        if(in_array($_POST['use'],array_keys($moj))) {
            //echo $_GET['use'];
            $i=mqfa1("select id from users where login='$_POST[target]'");
            if (!$i) {
              $i=mqfa1("select id from allusers where login='$_POST[target]'");
              if ($i) restoreuser($i);
            }
            switch($_POST['use']) {
                case "delbattle":
                  $b=mqfa1("select battle from users where login='$_POST[target]'");
                  if ($b) {
                    mysql_query("UPDATE users SET `battle` =0, `nich` = `nich`+'1',`fullhptime` = ".time().",`fullmptime` = ".time().",`udar` = '0' WHERE `battle` = $b");
                    mq("update battle set win=0 where id='$b'");
                    mq("delete from bots where battle='$b'");
                    $fp = fopen ("backup/logs/battle$b.txt","a"); //открытие
                    flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
                    fputs($fp , '<hr><span class=date>'.date("H:i").'</span> Бой закончен. Ничья.<BR>'); //работа с файлом
                    fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
                    flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
                    fclose ($fp); //закрытие
                    echo "<b>Бой персонажа $_POST[target] удалён.</b>";
                  } else echo "<b><font color=red>Персонаж $_POST[target] не в бою.</font></b>";
                break;
                case "credit":
                  $u=mqfa1("select id from users where login='$_POST[target]'");
                  if ($u) {
                    $i=mqfa1("select id from effects where type=31 and owner='$u' or owner=$u+"._BOTSEPARATOR_);
                    if ($i) {
                      echo "На персонаже <b>$_POST[target]</b> уже есть заклятие кредита.";
                    } else {
                      $_POST["days"]=(int)$_POST["days"];
                      if ($_POST["days"]) {
                        mq("insert into effects (name, type, time, owner) values ('Кредит', 31, ".(60*60*24*$_POST["days"]+time()).", '$u')");
                        echo "На персонажа $_POST[target] наложен кредит сроком $_POST[days] дней.";
                      } else echo "Введено неверное количество дней.";
                    }
                  } else echo "Персонаж $_POST[target] не найден.";
                break;
                case "credit_off":
                  $u=mqfa1("select id from users where login='$_POST[target]'");
                  if ($u) {
                    $i=mqfa1("select id from effects where type=31 and owner='$u'");
                    if ($i) {
                      mq("delete from effects where owner='$u' and type=31");
                      mq("delete from obshagaeffects where owner='$u' and type=31");
                      echo "С персонажа $_POST[target] снято заклятие кредита.";
                    } else echo "На персонажа $_POST[target] нет заклятия кредита.";
                  } else echo "Персонаж $_POST[target] не найден.";
                break;
                case "gender":
                    include("./magic/gender.php");
                break;
                case "sleep":
                    include("./magic/sleep.php");
                break;
                case "sleepf":
                    include("./magic/sleepf.php");
                break;
                case "sleep_off":
                    include("./magic/sleep_off.php");
                break;
                case "sleepf_off":
                    include("./magic/sleepf_off.php");
                break;
                case "haos":
                    include("./magic/haos.php");
                break;
                case "haos_off":
                    include("./magic/haos_off.php");
                break;
                case "obezl":
                    include("./magic/obezl.php");
                break;
                case "obezl_off":
                    include("./magic/obezl_off.php");
                break;
                case "death":
                    include("./magic/death.php");
                break;
                case "death_off":
                    include("./magic/death_off.php");
                break;
                case "chains":
                    include("./magic/stop.php");
                break;
                case "chainsoff":
                    include("./magic/start.php");
                break;
                case "jail":
                    include("./magic/jail.php");
                break;
                case "jail_off":
                    include("./magic/jail_off.php");
                break;
                case "ldadd":
                    include("./magic/ldadd.php");
                break;
                case "attackk":
                    include("./magic/attackk.php");
                break;
                case "attack":
                    include("./magic/attack.php");
                break;
                case "battack":
                    include("./magic/battack.php");
                break;
                case "attackt":
                    include("./magic/attackt.php");
                break;
                case "pal_off":
                    include("./magic/pal_off.php");
                break;
                case "tar_off":
                    include("./magic/tar_off.php");
                break;
                case "marry":
                    include("./magic/marry.php");
                break;
                case "unmarry":
                    include("./magic/unmarry.php");
                break;
                case "ct_all":
                    include("./magic/act_all.php");
                break;
                case "check":
                    include("./magic/check.php");
                break;
                case "vampir":
                    include("./magic/vampir.php");
                break;
                case "bexit":
                    include("./magic/bexit.php");
                break;
                case "devastate":
                    include("./magic/devastate.php");
                break;
                case "brat":
                    include("./magic/brat.php");
                break;
                case "piot":
                    include("./magic/piot.php");
                break;
                case "nepiot":
                    include("./magic/nepiot.php");
                break;
                case "bratl":
                    include("./magic/bratl.php");
                break;
                case "dneit":
                    include("./magic/dneit.php");
                break;
                case "ddark":
                    include("./magic/ddark.php");
                break;
                case "dlight":
                    include("./magic/dlight.php");
                break;
                case "vragon":
                    include("./magic/vragon.php");
                break;
                case "vragoff":
                    include("./magic/vragoff.php");
                break;
                case "a_ogon":
                    include("./magic/a_ogon.php");
                break;
                case "a_voda":
                    include("./magic/a_voda.php");
                break;
                case "a_vozduh":
                    include("./magic/a_vozduh.php");
                break;
                case "a_zemlya":
                    include("./magic/a_zemlya.php");
                break;
                case "iz_ogon":
                    include("./magic/iz_ogon.php");
                break;
                case "iz_voda":
                    include("./magic/iz_voda.php");
                break;
                case "iz_vozduh":
                    include("./magic/iz_vozduh.php");
                break;
                case "iz_zemlya":
                    include("./magic/iz_zemlya.php");
                break;
                case "defence":
                    include("./magic/defence.php");
                break;
                case "teleport":
                    include("./magic/teleport.php");
                break;
                case "hidden":
                    include("./magic/hidden.php");
                break;
            }
        }
        echo "<table>";
        echo "<tr><td align=center><br><br>";
        foreach($moj as $k => $v) {
            //echo $k;
            switch($k) {
                case "sleep": $script_name="runmagic"; $magic_name="Наложить заклятие молчания"; break;
                case "sleepf":
                if ($user['align']>2 && $user['align']<3|| $user['align']==5|| $user['deal']==5) {
                    $script_name="runmagicf"; $magic_name="Наложить заклятие форумного молчания";
                }
                else {
                    $script_name="runmagic"; $magic_name="Наложить заклятие форумного молчания";
                }
                break;
                case "sleep_off": $script_name="runmagic1"; $magic_name="Снять заклятие молчания"; break;
                case "sleepf_off": $script_name="runmagic1"; $magic_name="Снять заклятие форумного молчания"; break;
                case "haos": $script_name="runmagic2"; $magic_name="Наложить заклятие хаоса"; break;
                case "haos_off": $script_name="runmagic1"; $magic_name="Снять заклятие хаоса"; break;
                case "death": $script_name="runmagic1"; $magic_name="Наложить заклятие смерти"; break;
                case "death_off": $script_name="runmagic1"; $magic_name="Снять заклятие смерти"; break;
                case "chains": $script_name="runmagic2"; $magic_name="Наложить Путы"; break;
                case "chainsoff": $script_name="runmagic1"; $magic_name="Снять Путы"; break;
                case "jail": $script_name="runmagic2"; $magic_name="Отправить в Заточение"; break;
                case "jail_off": $script_name="runmagic1"; $magic_name="Выпустить из заточения"; break;
                case "piot": $script_name="runmagic1"; $magic_name="С кем пить идем?"; break;
                case "nepiot": $script_name="runmagic1"; $magic_name="Выгнать из бара"; break;
                case "obezl": $script_name="runmagic2"; $magic_name="Наложить заклятие обезличивания"; break;
                case "obezl_off": $script_name="runmagic1"; $magic_name="Снять заклятие обезличивания"; break;
                case "pal_off": $script_name="runmagic1"; $magic_name="Лишить звания Паладин"; break;
                case "attackk": $script_name="runmagic1"; $magic_name="Кулачное Нападение"; break;
                case "attack": $script_name="runmagic1"; $magic_name="Нападение"; break;
                case "battack": $script_name="runmagic1"; $magic_name="Кровавое нападение"; break;
                case "attackt": $script_name="runmagic1"; $magic_name="Темное Нападение"; break;
                case "marry": $script_name="runmagic4"; $magic_name="Зарегистрировать брак"; break;
                case "unmarry": $script_name="runmagic4"; $magic_name="Расторгнуть брак"; break;
                case "hidden": $script_name="runmagic1"; $magic_name="Заклятие невидимости"; break;
                case "teleport": $script_name="teleport"; $magic_name="Телепортация"; break;
                case "check": $script_name="runmagic1"; $magic_name="Поставить проверку"; break;
                case "ct_all": $script_name="runmagic1"; $magic_name="Вылечить от травм"; break;
                case "pal_buttons": $script_name="runmagic"; $magic_name="Отметить о прохождении проверки"; break;
                case "vampir": $script_name="runmagic1"; $magic_name="Вампиризм (выпить энергию другого игрока)"; break;
                case "brat": $script_name="runmagic1"; $magic_name="Помочь темному собрату (вмешаться в поединок)"; break;
                case "bratl": $script_name="runmagic1"; $magic_name="Рассеять Тьму"; break;
                case "dneit": $script_name="runmagic1"; $magic_name="Присвоить склонность (Нейтральное братство)"; break;
                case "dlight": $script_name="runmagic1"; $magic_name="Присвоить склонность (Светлое братство)"; break;
                case "ddark": $script_name="runmagic1"; $magic_name="Присвоить склонность (Темное братство)"; break;
                case "note": $script_name="runmagic"; $magic_name="Редактировать личное дело"; break;
                case "sys": $script_name="runmagic"; $magic_name="Отправить в чат системное сообщение"; break;
                case "scanner": $script_name="runmagic"; $magic_name="Показать лог действий модератора"; break;
                case "rep": $script_name="runmagic"; $magic_name="Отчет о переводах"; break;
                case "rost": $script_name="runmagic"; $magic_name="Присвоить статус"; break;
                case "ldadd": $script_name=""; $magic_name=""; break;
                case "bexit": $script_name="runmagic1"; $magic_name="Выйти из боя"; break;
                case "a_ogon": $script_name="runmagic1"; $magic_name="Астрал стихий (огонь)"; break;
                case "iz_ogon": $script_name="runmagic1"; $magic_name="Изгнание астрала стихий (огонь)"; break;
                case "a_voda": $script_name="runmagic1"; $magic_name="Астрал стихий (вода)"; break;
                case "iz_voda": $script_name="runmagic1"; $magic_name="Изгнание астрала стихий (вода)"; break;
                case "a_vozduh": $script_name="runmagic1"; $magic_name="Астрал стихий (воздух)"; break;
                case "iz_vozduh": $script_name="runmagic1"; $magic_name="Изгнание астрала стихий (воздух)"; break;
                case "a_zemlya": $script_name="runmagic1"; $magic_name="Астрал стихий (земля)"; break;
                case "iz_zemlya": $script_name="runmagic1"; $magic_name="Изгнание астрала стихий (земля)"; break;
                case "defence": $script_name="runmagic1"; $magic_name="Наложить Защиту от Оружия"; break;
                case "devastate": $script_name="runmagic1"; $magic_name="Наложить Сокрушение"; break;
                case "gender": $script_name="runmagic1"; $magic_name="Сменить пол"; break;
                case "delbattle": $script_name="runmagic1"; $magic_name="Удалить бой"; break;
                case "credit": $script_name="runmagic5"; $magic_name="Наложить заклятие кредита"; break;
                case "credit_off": $script_name="runmagic1"; $magic_name="Снять заклятие кредита"; break;
		case "teleport": $script_name="runmagic1"; $magic_name="Телепортация"; break;
		case "hidden": $script_name="runmagic1"; $magic_name="Невидимость"; break;
            }
                        if($k=="vragon"){echo"<a onclick=\"if (confirm('Вы уверены что хотите вызвать Общего Врага?')) window.location='a.php?use=vragon'\" href='#'><img src='i/magic/16.gif' title='Вызвать Общего Врага'></a> ";}
                        elseif($k=="vragoff"){echo"<a onclick=\"if (confirm('Вы уверены что хотите отозвать Общего Врага?')) window.location='a.php?use=vragoff'\" href='#'><img src='i/magic/34.gif' title='Отозвать Общего Врага'></a> ";}
            elseif ($script_name) {print "<a onclick=\"javascript:$script_name('$magic_name','$k','target','target1') \" href='#'><img src='i/magic/".$k.".gif' title='".$magic_name."'></a> ";}
}
        echo "</td></tr></table>";



/* НЕ ПАШЕД СОВСЕМ
    if ($user['align']>2 && $user['align']<3 && $_SESSION['uid']==311) {
if($_GET['delpers']=="on"){
set_time_limit (120);
//$us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-1209600).""));
    $deletid1 = mysql_query("SELECT `id`,`login` FROM `users` WHERE `block`='1' and `level`='0'");
$i=0;
while ($deletid=mysql_fetch_array($deletid1)) {
$i++;
mysql_query("DELETE FROM `bank` WHERE `owner` = ".$deletid['id']."");
mysql_query("DELETE FROM `battle` WHERE `t1` = ".$deletid['id']."");
mysql_query("DELETE FROM `battle` WHERE `t2` = ".$deletid['id']."");
mysql_query("DELETE FROM `confirmpasswd` WHERE `login` = ".$deletid['login']."");
mysql_query("DELETE FROM `delo` WHERE `pers` = ".$deletid['id']."");
mysql_query("DELETE FROM `delo_multi` WHERE `idpersnow` = ".$deletid['id']."");
mysql_query("DELETE FROM `delo_multi` WHERE `idperslater` = ".$deletid['id']."");
mysql_query("DELETE FROM `deztow_charstams` WHERE `owner` = ".$deletid['id']."");
mysql_query("DELETE FROM `deztow_turnir` WHERE `winner` = ".$deletid['id']."");
mysql_query("DELETE FROM `dilerdelo` WHERE `owner` = ".$deletid['login']."");
mysql_query("DELETE FROM `effects` WHERE `owner` = ".$deletid['id']."");
mysql_query("DELETE FROM `friends` WHERE `user` = ".$deletid['id']."");
mysql_query("DELETE FROM `friends` WHERE `friend` = ".$deletid['id']."");
mysql_query("DELETE FROM `friends` WHERE `enemy` = ".$deletid['id']."");
mysql_query("DELETE FROM `friends` WHERE `notinlist` = ".$deletid['id']."");
mysql_query("DELETE FROM `inventory` WHERE `owner` = ".$deletid['id']."");
mysql_query("DELETE FROM `invites` WHERE `owner` = ".$deletid['id']."");
mysql_query("DELETE FROM `iplog` WHERE `owner` = ".$deletid['id']."");
mysql_query("DELETE FROM `kaznalog` WHERE `user` = ".$deletid['id']."");
mysql_query("DELETE FROM `komplekt` WHERE `owner` = ".$deletid['id']."");
mysql_query("DELETE FROM `lichka` WHERE `pers` = ".$deletid['id']."");
mysql_query("DELETE FROM `lottery_log` WHERE `id_user` = ".$deletid['id']."");
mysql_query("DELETE FROM `online` WHERE `id` = ".$deletid['id']."");
mysql_query("DELETE FROM `person_on` WHERE `id_person` = ".$deletid['id']."");
mysql_query("DELETE FROM `puton` WHERE `id_person` = ".$deletid['id']."");
mysql_query("DELETE FROM `telegraph` WHERE `owner` = ".$deletid['id']."");
mysql_query("DELETE FROM `trade` WHERE `to_id` = ".$deletid['id']."");
mysql_query("DELETE FROM `trade` WHERE `login` = ".$deletid['login']."");
mysql_query("DELETE FROM `visit_podzem` WHERE `login` = ".$deletid['login']."");
mysql_query("DELETE FROM `vxod` WHERE `login` = ".$deletid['login']."");
mysql_query("DELETE FROM `vxodd` WHERE `login` = ".$deletid['login']."");

if(!function_exists("delete_directory")) {
function delete_directory($dirname) {
 if (is_dir($dirname))
 $dir_handle = opendir($dirname);
 if (!$dir_handle)
 return false;
 while($file = readdir($dir_handle)) {
 if ($file != "." && $file != "..") {
 if (!is_dir($dirname."/".$file))
 unlink($dirname."/".$file);
 else
 delete_directory($dirname.'/'.$file);
 }
 }
 closedir($dir_handle);
 rmdir($dirname);
 return true;
 }}
delete_directory(MEMCACHE_PATH."/komplekt/".$deletid['id']);
unlink("tmp/zayavka/".$deletid['id'].".txt");
mysql_query("DELETE FROM `users` WHERE `id` = ".$deletid['id']."");
}
echo "Удалено ".$i." персонажей.<br>";
}
?>
<br>Удалить всех заблокированных персонажей 0 уровня, а также не играющих долгое время. <INPUT TYPE=button onClick="if (confirm('Вы уверены что хотите удалить персонажей?')) window.location='a.php?delpers=on'" value="Удалить">
        <?}

*/



    if ($user['align']>2 && $user['align']<3|| $user['align']==5|| $user['deal']==5) {
            echo "<form method=post action=\"a.php\">Добавить в \"дело\" игрока заметку о нарушении правил, прокрутке и пр. <br>
                    <table><tr><td>Введите логин </td><td><input type='text' name='ldnick' value='$ldtarget'></td><td> сообщение <input type='text' size='50' name='ldtext' value=''></td><td><input type='hidden' name='use' value='ldadd'><input type=submit value='Добавить'></td></tr>";
    if ($user['align']>2 && $user['align']<3) {
                if ($ldblock) {
                    echo "<tr><td colspan=4><input type='checkbox' name='red' class='input' checked> Записать, как причину отправки в хаос/блокировки</td></tr>";
                }
                else {
                    echo "<tr><td colspan=4><input type='checkbox' name='red' class='input' > Записать, как причину отправки в хаос/блокировки</td></tr>";
                }
            }
            echo "</table></form>";
        }
    if (($user['align']>2 && $user['align']<3) || $user['align']==5|| $user['deal']==5) {
    $online = mysql_fetch_row(mysql_query("select COUNT(*) from `online`  WHERE `real_time` >= ".(time()-60).";"));
    if($_POST['add'] OR $_POST['add2']) {
        @setcookie("time",time());
    }
    if ($_POST['action']!="") {
            switch ($_POST['action']) {

            case "sysmsg":
            if (filesize(CHATROOT."chat.txt")>20*1024) {
                //file_put_contents("chat.txt", file_get_contents("chat.txt", NULL, NULL, 3*1024), LOCK_EX);
                //@chmod("$fp", 0644);
                // удаление последней строки
                $file=file(CHATROOT."chat.txt");
                $fp=fopen(CHATROOT."chat.txt","w");
                flock ($fp,LOCK_EX);
                for ($s=0;$s<count($file)/1.5;$s++) {
                    unset($file[$s]);
                }
                fputs($fp, implode("",$file));
                fputs($fp ,"\r\n:[".time ()."]:[!sys2all!!]:[<font color=\"#ff0000\"><b>Внимание!</b></font> <b>".($_POST['msg'])."</b> (<font color=red><b>".$user['login']."</b></font>) ]:[1]\r\n"); //работа с файлом
                flock ($fp,LOCK_UN);
                fclose($fp);
            }
            else {
                $fp = fopen (CHATROOT."chat.txt","a"); //открытие
                flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
                fputs($fp ,"\r\n:[".time ()."]:[!sys2all!!]:[<font color=\"#ff0000\"><b>Внимание!</b></font> <b>".($_POST['msg'])."</b> (<font color=red><b>".$user['login']."</b></font>) ]:[1]\r\n"); //работа с файлом
                fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
                flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
                fclose ($fp); //закрытие
            }
                //echo "Отправлено системное сообщение в чат.";

                break;
                }
        }
?>
<HTML>
<script>
var xmlHttpp=[]
function ajax_func(func,iid,getpar,postpar){
  xmlHttpp[iid]=GetXmlHttpObject1()
  if (xmlHttpp[iid]==null){
    alert ("Browser does not support HTTP Request")
    return
    }
  document.getElementById(iid).innerHTML="<img src='./i/loading2.gif' />";
  var url="./ajax/"+func+".php"
  url=url+"?"+getpar
  xmlHttpp[iid].open("POST",url,true);
  xmlHttpp[iid].onreadystatechange=function() {
    if (xmlHttpp[iid].readyState==4 || xmlHttpp[iid].readyState=="complete") {
      if (document.getElementById(iid)=='[object HTMLInputElement]')
    document.getElementById(iid).value=xmlHttpp[iid].responseText;
      else
    document.getElementById(iid).innerHTML=xmlHttpp[iid].responseText;
    document.getElementById('chat').scrollTop = document.getElementById('chat').scrollHeight+10;
      }
    }
  xmlHttpp[iid].setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  xmlHttpp[iid].send(postpar);
}

function GetXmlHttpObject1()
{
var xmlHttp1=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp1=new XMLHttpRequest();
 }
catch (e)
 {
 //Internet Explorer
 try
  {
  xmlHttp1=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp1;
}
</script>
</HTML>
<?
}
if (($user['align']>2) && ($user['align']<3|| $user['align']==5|| $user['deal']==5)) {
?>
<hr><div id='content' style='width:100%;'>

<div style='width:100%; height:40%;' id=adm_act>
<div style='float:left;'>Отправить системное сообщение в чат</div><div style='float:left; margin-left:10px;'>
<input name='sysmsg' id='sysmsg' size=100>
<input type="button" OnClick=" document.getElementById('action').value='sysmsg'; document.getElementById('msg').value=document.getElementById('sysmsg').value; document.actform.submit(); " value="Отправить">
<?
  $r=mq("select users.login, users.room, effects.time from effects left join users on users.id=effects.owner where type=1022 and time>".time());
  if (mysql_num_rows($r)>0) {
    echo "<br><br>Невидимки:<table>
    <tr><td><b>Номер</b></td><td><b>Логин</b></td><td><b>Локация</b><td></td></tr>";
    while ($rec=mysql_fetch_assoc($r)) {
      echo "<tr><td>".substr($rec["time"],strlen($rec["time"])-4)."</td><td>$rec[login]</td><td>".$rooms[$rec["room"]]."</td></tr>";
    }
    echo "</table>";
  }
  $r=mq("select users.id from `users` where left(borndate,5)=date_format(curdate(),'%d-%m')");
  if (mysql_num_rows($r)>0) {
    echo "<br><br>Дни рождения сегодня:<table><tr><td>Логин</td><td>Онлайн</td></tr>";
    while ($rec=mysql_fetch_assoc($r)) {
      echo "<tr><td>";
      nick2($rec["id"]);
      echo "</td><td>";
      $online1 = mysql_fetch_array(mysql_query('SELECT o.date,o.real_time FROM `users` as u, `online` as o WHERE u.`id` = o.`id` AND u.`id` = \''.$rec['id'].'\' LIMIT 1;'));
      $lv=time()-$online1["date"];
      if ($lv<60) echo "<b>Сейчас</b>";
      else echo date("d.m H:i", $online1['date']);
      echo "</td></tr>";
    }
    echo "</table>";
  }

  $r=mq("select users.id from `users` where left(borndate,5)=date_format(date_add(curdate(), interval 1 day),'%d-%m')");
  if (mysql_num_rows($r)>0) {
    echo "<br><br>Дни рождения завтра:<table><tr><td>Логин</td><td>Онлайн</td></tr>";
    while ($rec=mysql_fetch_assoc($r)) {
      echo "<tr><td>";
      nick2($rec["id"]);
      echo "</td><td>";
      $online1 = mysql_fetch_array(mysql_query('SELECT o.date,o.real_time FROM `users` as u, `online` as o WHERE u.`id` = o.`id` AND u.`id` = \''.$rec['id'].'\' LIMIT 1;'));
      $lv=time()-$online1["date"];
      if ($lv<60) echo "<b>Сейчас</b>";
      else echo date("d.m H:i", $online1['date']);
      echo "</td></tr>";
    }
    echo "</table>";
  }


?>
<br>Сейчас в клубе: <?=$online[0];?>

</div>
<form method=POST name='actform'>
<input type=hidden name='action' id='action'>
<input type=hidden name='msg' id='msg'>
</form>
</div>
<?
/*
<div id='content' style='width:100%;'>
<div style='float:left;'>Отправить системное сообщение в чат</div><div style='float:left; margin-left:10px;'><input name='sysmsg' id='sysmsg' size=100> <input type=button OnClick=" document.getElementById('action').value='sysmsg'; document.getElementById('msg').value=document.getElementById('sysmsg').value; document.actform.submit(); "></div>
<div style='clear:both;'></div>
</div>
<form method=POST name='actform'>
<input type=hiddn name='action' id='action'>
<input type=hiddn name='msg' id='msg'>
</form> */
}

    if ($user['align']>2 && $user['align']<3|| $user['align']==5|| $user['deal']==5) {
            echo "<HR>";
            if($_POST['grn'] && $_POST['gr']) {
                echo telegraph($_POST['grn'],$_POST['gr']);
            }
            echo '<h4>Телеграф</h4>Вы можете отправить короткое сообщение любому персонажу, даже если он находится в offline или другом городе.
<form method=post style="margin:5px;">Логин: <input type=text size=20 name="grn"> Текст сообщения: <input type=text size=80 name="gr"> <input type=submit value="отправить"></form>';
        }

    if ($user['align']>2 && $user['align']<3|| $user['align']==5|| $user['deal']==5) {

            echo "<a name=\"searchitem\"></a><hr><form action=\"a.php#searchitem\" method=\"post\"><b>Посмотреть операции с предметом</b><br>
            ID предмета: <input type=text size=8 name=\"operationsitem\" value=\"".@$_POST["operationsitem"]."\"> <input type=checkbox id=\"inarchive\" name=\"inarchive\"> <label for=\"inarchive\">Искать в архиве</label> <input type=\"submit\" value=\"Посмотреть\">
            </form>";
            if (@$_POST["operationsitem"]) {
              if (@$_POST["inarchive"]) $r = mq("SELECT * FROM archive.delo WHERE text like '%$_POST[operationsitem]%' ORDER by `id`");
              else $r = mq("SELECT * FROM `delo` WHERE text like '%$_POST[operationsitem]%' ORDER by `id`");
              
              while($rec=mysql_fetch_assoc($r)) {
                $dat=date("d.m.y H:i",$rec['date']);
                echo "<span class=date>$dat</span> $rec[text]<br>";
              }

            }
            echo "</hr>";

            if (!$_POST['logs']) {$_POST['logs']=date("d.m.y");}
            echo '<hr><TABLE><TR><TD colspan=3><FORM METHOD=POST ACTION=a.php>
            Просмотреть переводы персонажа: <INPUT TYPE=text NAME=filter value="'.$_POST['filter'].'"> за <INPUT TYPE=text NAME=logs size=12 value="'.$_POST['logs'].'"> <INPUT TYPE=submit value="Просмотреть!">
            <INPUT TYPE=submit name="all" value="Посмотреть архив переводов">
            </form></TD>
            </tr><tr><td><FORM METHOD=POST ACTION=a.php><INPUT TYPE=hidden NAME=filter value="'.$_POST['filter'].'">
            <INPUT TYPE=hidden NAME=logs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['logs'],3,2), substr($_POST['logs'],0,2)-1, "20".substr($_POST['logs'],6,2))).'">
            <INPUT TYPE=submit value="   «   "></form></TD>
            <TD valign=top align=center>Переводы персонажа <b>"'.$_POST['filter'].'"</b> за  <b>'.$_POST['logs'].'</b></TD>
            <TD><FORM METHOD=POST ACTION=a.php><INPUT TYPE=hidden NAME=logs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['logs'],3,2), substr($_POST['logs'],0,2)+1, "20".substr($_POST['logs'],6,2))).'">
            <INPUT TYPE=hidden NAME=filter value="'.$_POST['filter'].'"> <INPUT TYPE=submit value="   »   "></form></TD>
            </TR></TABLE></form>';
            if ($_POST['filter']) {
                $perevod = mysql_fetch_array(mysql_query("SELECT login,id,align FROM `users` WHERE `login` = '{$_POST['filter']}' LIMIT 1;"));
                $per_ok=0;
    if ($user['align']>2 && $user['align']<3|| $user['align']==5|| $user['deal']==5) {
                    $per_ok=1;
                }
                $iid=$perevod['id'];
                $logsat=$_POST['logs'];
                if ($per_ok==1) {
                    if (@$_POST["all"]) {
                      $logs = mq("SELECT * FROM archive.`delo` WHERE `pers` = '{$perevod['id']}' ORDER by `id` ASC;");
                    } else {
                      $ddate1=mktime(0, 0, 0, substr($_POST['logs'],3,2), substr($_POST['logs'],0,2), "20".substr($_POST['logs'],6,2));
                      $ddate2=mktime(23, 59, 59, substr($_POST['logs'],3,2), substr($_POST['logs'],0,2), "20".substr($_POST['logs'],6,2));
                      $logs = mysql_query("SELECT * FROM `delo` WHERE `pers` = '{$perevod['id']}' AND `date` > '$ddate1' AND `date` < '$ddate2' ORDER by `id` ASC;");
                    }
                    while($row = @mysql_fetch_array($logs)) {
                        $dat=date("d.m.y H:i",$row['date']);
                        echo "<span class=date>{$dat}</span> {$row['text']}<br>";
                    }
                }

            }
            echo "<hr>";
        }

    if ($user['align']>2 && $user['align']<3|| $user['align']==5|| $user['deal']==5) {
            if ($_POST['putekr']) {
                if (($_POST['ekr']) && ($_POST['bank']) && ($_POST['tonick'])) {
                    $tonick = mysql_fetch_array(mysql_query("SELECT login,id FROM `users` WHERE `login` = '{$_POST['tonick']}' LIMIT 1;"));
                    $bank = mysql_fetch_array(mysql_query("SELECT owner,id FROM `bank` WHERE `id` = '{$_POST['bank']}' LIMIT 1;"));
                    if  (ereg("auto-",$user['login']) || ereg("auto-",$user['login'])) {
                        $botfull=$user['login'];
                        list($bot, $botlogin) = explode("-", $user['login']);
                        $botnick = mysql_fetch_array(mysql_query("SELECT login,id FROM `users` WHERE `login` = '{$botlogin}' LIMIT 1;"));
                        $user['login']=$botnick['login'];
                        $user['id']=$botnick['id'];
                    }
                    if ($bank['owner'] && $tonick['id'] && $bank['owner'] == $tonick['id']) {
                        $_POST['ekr'] = round($_POST['ekr'],2);
                        if (mysql_query("UPDATE `bank` set `ekr` = ekr+'{$_POST['ekr']}' WHERE `id` = '{$_POST['bank']}' LIMIT 1;")) {
                            if ($bot && $botlogin) {
                                mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr) values ('{$_SESSION['uid']}','{$botfull}','{$_POST['bank']}','{$_POST['tonick']}','{$_POST['ekr']}');");
                                mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr) values ('{$user['id']}','{$botfull}','{$_POST['bank']}','{$_POST['tonick']}','{$_POST['ekr']}');");
                            }
                            else {
                                mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr) values ('{$user['id']}','{$user['login']}','{$_POST['bank']}','{$_POST['tonick']}','{$_POST['ekr']}');");
                            }
                            mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$tonick['id']}','Получено ".$_POST['ekr']." екр на счет №".$_POST['bank']." от дилера ".$user['login']."',1,'".time()."');");
                            $us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$tonick['id']}' LIMIT 1;"));
                            if($us[0]){
                                addchp ('<font color=red>Внимание!</font> На ваш счет №'.$_POST['bank'].' переведено '.$_POST['ekr'].' екр. от дилера '.$user['login'].'  ','{[]}'.$_POST['tonick'].'{[]}');
                            } else {
                                // если в офе
                                mysql_query("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>Внимание!</font> На ваш счет №'.$_POST['bank'].' переведено '.$_POST['ekr'].' екр. от дилера '.$user['login'].'  '."');");
                            }
                            print "<b><font color=red>Успешно зачислено {$_POST['ekr']} екр. на счет {$_POST['bank']} персонажа {$_POST['tonick']}!</font></b>";
                        }
                        else {
                            print "<b><font color=red>Произошла ошибка!</font></b>";
                        }
                    }
                    else {
                        print "<b><font color=red>Счет номер {$_POST['bank']} не принадлежит персонажу {$_POST['tonick']}!</font></b>";
                    }
                }
                else {
                    print "<b><font color=red>Введите сумму, номер счета и ник персонажа!</font></b>";
                }
            }
            if ($_POST['komotdel']) {
                if ($_POST['komlog'] && $_POST['price']) {
                    $_POST['price'] = round($_POST['price'],2);
                    $tonick = mysql_fetch_array(mysql_query("SELECT login,id,align,klan FROM `users` WHERE `login` = '{$_POST['komlog']}' LIMIT 1;"));
                    if  (ereg("auto-",$user['login']) || ereg("auto-",$user['login'])) {
                        $botfull=$user['login'];
                        list($bot, $botlogin) = explode("-", $user['login']);
                        $botnick = mysql_fetch_array(mysql_query("SELECT login,id FROM `users` WHERE `login` = '{$botlogin}' LIMIT 1;"));
                        $user['login']=$botnick['login'];
                        $user['id']=$botnick['id'];
                    }
                    if ($tonick['login']) {
                        if ($bot && $botlogin) {
                            mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['komlog']}','{$_POST['price']}','5');");
                            mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$botfull}','0','{$_POST['komlog']}','{$_POST['price']}','5');");
                        }
                        else {
                            mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['komlog']}','{$_POST['price']}','5');");
                        }
                        mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$tonick['id']}','&quot;".$_POST['komlog']."&quot; произвел оплату в комм. отдел через дилера ".$user['login']."  ',1,'".time()."');");
                        mysql_query("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tonick['id']."','&quot;".$_POST['komlog']."&quot; произвел оплату в комм. отдел через дилера &quot;".$user['login']."&quot;  ','".time()."');");
                        print "<b><font color=red>Оплата в комм. отдел {$_POST['price']} екр. для персонажа {$_POST['komlog']} произведена успешно!</font></b>";
                    }
                    else {
                        print "<b><font color=red>Такой персонаж не существует!</font></b>";
                    }
                }
            }
            if ($_POST['obraz']) {
                if ($_POST['obrazlog']) {
                    $tonick = mysql_fetch_array(mysql_query("SELECT login,id,align,klan FROM `users` WHERE `login` = '{$_POST['obrazlog']}' LIMIT 1;"));
                    if  (ereg("auto-",$user['login']) || ereg("auto-",$user['login'])) {
                        $botfull=$user['login'];
                        list($bot, $botlogin) = explode("-", $user['login']);
                        $botnick = mysql_fetch_array(mysql_query("SELECT login,id FROM `users` WHERE `login` = '{$botlogin}' LIMIT 1;"));
                        $user['login']=$botnick['login'];
                        $user['id']=$botnick['id'];
                    }
                    if ($tonick['login']) {
                        if ($bot && $botlogin) {
                            mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['obrazlog']}','100','6');");
                            mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$botfull}','0','{$_POST['obrazlog']}','100','6');");
                        }
                        else {
                            mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['obrazlog']}','100','6');");
                        }
                        mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$tonick['id']}','&quot;".$_POST['obrazlog']."&quot; оплатил личный образ через дилера ".$user['login']."',1,'".time()."');");
                        mysql_query("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tonick['id']."','&quot;".$_POST['obrazlog']."&quot; оплатил личный образ через дилера &quot;".$user['login']."&quot;  ','".time()."');");
                        print "<b><font color=red>Оплата личного образа для персонажа {$_POST['obrazlog']} произведена успешно!</font></b>";
                    }
                    else {
                        print "<b><font color=red>Такой персонаж не существует!</font></b>";
                    }
                }
            }
            if ($_POST['openbank']) {
                if ($_POST['charlog']) {
                    $tonick = mysql_fetch_array(mysql_query("SELECT login,id,money FROM `users` WHERE `login` = '{$_POST['charlog']}' LIMIT 1;"));
                    if  (ereg("auto-",$user['login']) || ereg("auto-",$user['login'])) {
                        $botfull=$user['login'];
                        list($bot, $botlogin) = explode("-", $user['login']);
                        $botnick = mysql_fetch_array(mysql_query("SELECT login,id FROM `users` WHERE `login` = '{$botlogin}' LIMIT 1;"));
                        $user['login']=$botnick['login'];
                        $user['id']=$botnick['id'];
                    }
                    if ($tonick['login']) {
                        if (mysql_query("UPDATE `users` set `money` = `money`+'0.5' WHERE `id` = '{$tonick['id']}' LIMIT 1;")) {
                            mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$tonick['id']}','Получено 0.5 кр. на открытие счета в банке от дилера ".$user['login']."',1,'".time()."');");
                            print "<b><font color=red>Успешно переведены 0.5 кр персонажу {$_POST['charlog']}!</font></b>";
                        }
                        else {
                            print "<b><font color=red>Произошла ошибка!</font></b>";
                        }
                    }
                    else {
                        print "<b><font color=red>Такой персонаж не существует!</font></b>";
                    }
                }
            }

            if ($_POST['givesklonka']) {
                if ($_POST['sklonkalog'] && $_POST['sklonka']) {
                    $tonick = mysql_fetch_array(mysql_query("SELECT login,id,align,klan FROM `users` WHERE `login` = '{$_POST['sklonkalog']}' LIMIT 1;"));
                    if  (ereg("auto-",$user['login']) || ereg("auto-",$user['login'])) {
                        $botfull=$user['login'];
                        list($bot, $botlogin) = explode("-", $user['login']);
                        $botnick = mysql_fetch_array(mysql_query("SELECT login,id FROM `users` WHERE `login` = '{$botlogin}' LIMIT 1;"));
                        $user['login']=$botnick['login'];
                        $user['id']=$botnick['id'];
                    }
                    if ($tonick['login']) {
                        if ($tonick['align'] || $tonick['klan']) {
                            print "<b><font color=red>Персонаж уже имеет склонность либо состоит в клане!</font></b>";
                        }
                        else {
                            if (mysql_query("UPDATE `users` set `align` = '{$_POST['sklonka']}' WHERE `id` = '{$tonick['id']}' LIMIT 1;")) {
                                if ($_POST['sklonka'] == 7) {$skl="нейтральная"; $skl2="нейтральную";}
                                else {$skl="темная"; $skl2="темную";}
                                if ($bot && $botlogin) {
                                    mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['sklonkalog']}','0',{$_POST['sklonka']});");
                                    mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$botfull}','0','{$_POST['sklonkalog']}','0',{$_POST['sklonka']});");
                                }
                                else {
                                    mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['sklonkalog']}','0',{$_POST['sklonka']});");
                                }
                                mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$tonick['id']}','Куплена ".$skl." склонность от дилера ".$user['login']."',1,'".time()."');");
                                if ($user['sex'] == 1) {$action="присвоил";}
                                else {$action="присвоила";}
                                mysql_query("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tonick['id']."','Дилер &quot;".$user['login']."&quot; ".$action." &quot;".$_POST['sklonkalog']."&quot; ".$skl2." склонность','".time()."');");
                                print "<b><font color=red>Успешно присвоена  {$skl} склонность персонажу {$_POST['sklonkalog']}!</font></b>";
                            }
                            else {
                                print "<b><font color=red>Произошла ошибка!</font></b>";
                            }
                        }
                    }
                    else {
                        print "<b><font color=red>Такой персонаж не существует!</font></b>";
                    }
                }
            }

            echo "<h4>Дилерская панель</h4><form method=post action=\"a.php\"><b>Зачислить екры на счет </b>
                <table><tr><td>Введите сумму </td><td><input type='text' name='ekr' value=''></td><td> Номер счета <input type='text' name='bank' value=''></td><td> Ник персонажа <input type='text' name='tonick' value=''></td><td><input type=submit name=putekr value='Зачислить'></td></tr></table>";
            echo "<br><form method=post action=\"a.php\"><b>Проверить логин / номер счета </b>
                <table><tr><td>Логин </td><td><input type='text' name='charlogin' value=''></td><td> Номер счета <input type='text' name='charbank' value=''></td><td><input type=submit name=checkbank value='Проверить'></td></tr></table>";
            echo "<br><form method=post action=\"a.php\"><b>Передать деньги на открытие счета</b>
                <table><tr><td>Логин </td><td><input type='text' name='charlog' value=''></td><td></td><td><input type=submit name=openbank value='Передать'></td></tr></table>";
            echo "<br><form method=post action=\"a.php\"><b>Присвоить склонность</b>
                <table><tr><td>Логин </td><td><input type='text' name='sklonkalog' value=''></td><td>Склонность <select name='sklonka'>
                    <option value='0'></option>
                    <option value='2'>Нейтральная</option>
                    <option value='0.98'>Темная</option></select><td><input type=submit name=givesklonka value='Присвоить'></td></tr></table>";
            echo "<br><form method=post action=\"a.php\"><b>Оплатить в ком.отдел</b>
                <table><tr><td>Логин </td><td><input type='text' name='komlog' value=''></td><td>Введите сумму <input type='text' name='price' value=''></td><td><input type=submit name=komotdel value='Оплатить'></td></tr></table>";
            echo "<br><form method=post action=\"a.php\"><b>Оплатить личный образ</b>
                <table><tr><td>Логин </td><td><input type='text' name='obrazlog' value=''></td><td></td><td><input type=submit name=obraz value='Оплатить'></td></tr></table>";

            if ($_POST['checkbank']) {
                if ($_POST['charlogin']) {
                    $tonick = mysql_fetch_array(mysql_query("SELECT login,id FROM `users` WHERE `login` = '{$_POST['charlogin']}' LIMIT 1;"));
                    $bankdb = mysql_query("SELECT owner,id FROM `bank` WHERE `owner` = '{$tonick['id']}'");
                    print "Персонажу {$_POST['charlogin']} принадлежат счета: <br>";
                    while ($bank=mysql_fetch_array($bankdb)) {
                        print "№ {$bank['id']} <br>";
                    }
                }
                else if  ($_POST['charbank']) {
                    $bank = mysql_fetch_array(mysql_query("SELECT owner,id FROM `bank` WHERE `id` = '{$_POST['charbank']} 'LIMIT 1;"));
                    $tonick = mysql_fetch_array(mysql_query("SELECT login,id FROM `users` WHERE `id` = '{$bank['owner']}' LIMIT 1;"));
                    print "Счет № {$_POST['charbank']} принадлежит персонажу {$tonick['login']} <br>";
                }
            }
            echo "<hr>";
            if (!$_POST['dlogs']) {$_POST['dlogs']=date("d.m.y");}

    if ($user['align']>2 && $user['align']<3|| $user['align']==5|| $user['deal']==5) {
            echo '<TABLE><TR><TD colspan=3><FORM METHOD=POST ACTION=a.php>
            Просмотреть покупки с Берёзки: за <INPUT TYPE=text NAME=dlogs size=12 value="'.$_POST['dlogs'].'"> <INPUT TYPE=submit name="berfilter" value="Просмотреть!"></form></TD>
            </tr><tr><td><FORM METHOD=POST ACTION=a.php><INPUT TYPE=hidden NAME=berfilter value="1">
            <INPUT TYPE=hidden NAME=dlogs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['dlogs'],3,2), substr($_POST['dlogs'],0,2)-1, "20".substr($_POST['dlogs'],6,2))).'">
            <INPUT TYPE=submit value="   «   "></form></TD>
            <TD valign=top align=center>Покупки в Берёзке за  <b>'.$_POST['dlogs'].'</b></TD>
            <TD><FORM METHOD=POST ACTION=a.php><INPUT TYPE=hidden NAME=dlogs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['dlogs'],3,2), substr($_POST['dlogs'],0,2)+1, "20".substr($_POST['dlogs'],6,2))).'">
            <INPUT TYPE=hidden NAME=dfilter value="'.$_POST['dfilter'].'"> <INPUT TYPE=submit value="   »   "></form></TD>
            </TR></TABLE></form>';

            if ($_POST['berfilter']) {
              $r=mq("select sum(berlog.qty) as qty, berezka.name, berezka.ecost as cost, berezka.name from berlog left join berezka on berezka.id=berlog.item where berlog.dat='20".substr($_POST['dlogs'],6,2)."-".substr($_POST['dlogs'],3,2)."-".substr($_POST['dlogs'],0,2)."' group by berlog.item");
              echo "<table>
              <tr>
              <td><b>Предмет</b></td>
              <td><b>Цена</b></td>
              <td><b>Сумма</b></td></tr>";
              while ($rec=mysql_fetch_assoc($r)) {
                echo "<tr><td>$rec[name]</td><td align=\"center\">$rec[qty]</td><td align=\"center\">".($rec["qty"]*$rec["cost"])."</td></tr>";
              }
              echo "</table>";
            }
            echo '<TABLE><TR><TD colspan=3><FORM METHOD=POST ACTION=a.php>
            Просмотреть дилерские переводы персонажа: <INPUT TYPE=text NAME=dfilter value="'.$_POST['dfilter'].'"> за <INPUT TYPE=text NAME=dlogs size=12 value="'.$_POST['dlogs'].'"> <INPUT TYPE=submit value="Просмотреть!"></form></TD>
            </tr><tr><td><FORM METHOD=POST ACTION=a.php><INPUT TYPE=hidden NAME=dfilter value="'.$_POST['dfilter'].'">
            <INPUT TYPE=hidden NAME=dlogs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['dlogs'],3,2), substr($_POST['dlogs'],0,2)-1, "20".substr($_POST['dlogs'],6,2))).'">
            <INPUT TYPE=submit value="   «   "></form></TD>
            <TD valign=top align=center>Дилерские переводы персонажа <b>"'.$_POST['dfilter'].'"</b> за  <b>'.$_POST['dlogs'].'</b></TD>
            <TD><FORM METHOD=POST ACTION=a.php><INPUT TYPE=hidden NAME=dlogs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['dlogs'],3,2), substr($_POST['dlogs'],0,2)+1, "20".substr($_POST['dlogs'],6,2))).'">
            <INPUT TYPE=hidden NAME=dfilter value="'.$_POST['dfilter'].'"> <INPUT TYPE=submit value="   »   "></form></TD>
            </TR></TABLE></form>';
            }
            elseif ($user['deal']==1|| $user['deal']==5) {
            echo '<TABLE><TR><TD colspan=3><FORM METHOD=POST ACTION=a.php>
            Просмотреть дилерские переводы <INPUT TYPE=hidden NAME=dfilter value="'.$user['login'].'">за <INPUT TYPE=text NAME=dlogs size=12 value="'.$_POST['dlogs'].'"> <INPUT TYPE=submit value="Просмотреть!"></form></TD>
            </tr><tr><td><FORM METHOD=POST ACTION=a.php><INPUT TYPE=hidden NAME=dfilter value="'.$_POST['dfilter'].'">
            <INPUT TYPE=hidden NAME=dlogs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['dlogs'],3,2), substr($_POST['dlogs'],0,2)-1, "20".substr($_POST['dlogs'],6,2))).'">
            <INPUT TYPE=submit value="   «   "></form></TD>
            <TD valign=top align=center>Дилерские переводы персонажа <b>"'.$_POST['dfilter'].'"</b> за  <b>'.$_POST['dlogs'].'</b></TD>
            <TD><FORM METHOD=POST ACTION=a.php><INPUT TYPE=hidden NAME=dlogs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['dlogs'],3,2), substr($_POST['dlogs'],0,2)+1, "20".substr($_POST['dlogs'],6,2))).'">
            <INPUT TYPE=hidden NAME=dfilter value="'.$_POST['dfilter'].'"> <INPUT TYPE=submit value="   »   "></form></TD>
            </TR></TABLE></form>';
            }
            if ($_POST['dfilter']) {
                $perevod1 = mysql_fetch_array(mysql_query("SELECT `login`,`id`,`align` FROM `users` WHERE `login` = '{$_POST['dfilter']}' LIMIT 1;"));
                $aa=$perevod1['id'];
    if ($user['align']>2 && $user['align']<3|| $user['align']==5) {
                    $logsat=$_POST['dlogs'];
                    $ddate33="20".substr($_POST['dlogs'],6,2)."-".substr($_POST['dlogs'],3,2)."-".substr($_POST['dlogs'],0,2)."";
                    $dlogs = mysql_query("SELECT * FROM `dilerdelo` WHERE `dilerid` = '{$perevod1['id']}' AND `date` like '$ddate33%' ORDER by `id` ASC;");
                    while($row = @mysql_fetch_array($dlogs)) {
                        switch($row['addition']) {
                            case "2":
                                $sklo="нейтральная";
                                echo "<span class=date>{$row['date']}</span> Продана {$sklo} склонность персонажу  {$row['owner']} (50 екр.)<br>";
                                break;
                            case "3":
                                $sklo="темная";
                                echo "<span class=date>{$row['date']}</span> Продана {$sklo} склонность персонажу  {$row['owner']} (50 екр.)<br>";
                                break;
                            case "5":
                                echo "<span class=date>{$row['date']}</span> Переведено {$row['ekr']} екр. в комотдел для персонажа {$row['owner']} <br>";
                                break;
                            case "6":
                                echo "<span class=date>{$row['date']}</span> Оплачен личный образ для персонажа {$row['owner']} (100 екр.)<br>";
                                break;
                            case "0":
                                echo "<span class=date>{$row['date']}</span> Переведено {$row['ekr']} екр. персонажу  {$row['owner']} (счет №{$row['bank']})<br>";
                                break;
                        }
                    }
                }
            }
        }

    if ($user['align']>2 && $user['align']<3|| $user['align']==5|| $user['deal']==5) {
            echo "<form method=post><fieldset><legend>IP</legend>
                    <table><tr><td>Логин</td><td><input type='text' name='ip' value='",$_POST['ip'],"'></td><td><input type=submit value='посмотреть IP'></td></tr>
                    <tr><td>IP</td><td><input type='text' name='ipfull' value='",$_POST['ipfull'],"'></td><td><input type=submit value='посмотреть ники'></td></tr></table>";
            if ($_POST['ip']) {
                $dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['ip']."';"));
                echo "<font color=red>",$dd[1]," - ",$dd[0],"</font><BR>";
            }elseif($_POST['ipfull']) {
                $data = mysql_query("SELECT `ip`, `login` FROM `users` WHERE `ip` = '".$_POST['ipfull']."';");
                while($dd=mysql_fetch_array($data)) {
                    echo "<font color=red>",$dd[1]," - ",$dd[0],"</font><BR>";
                }
            }
            echo "</fieldset></form>";
        }

    if ($user['align']>2 && $user['align']<3) {
                echo "<form method=post><fieldset><legend>Поменять статус</legend>
                    <table><tr><td>Логин</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>Статус</td><td><input type='text' name='status' value='",$_POST['status'],"'></td><td><input type=submit value='изменить статус'></td></tr></table>";
                if ($_POST['login'] && $_POST['status']) {
                    $dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
                    if($dd) {
                        mysql_query("UPDATE `users` SET `status` = '".$_POST['status']."' WHERE `login` = '".$_POST['login']."';");
                        echo "<font color=red>Статус ",$dd[1]," изменен на ",$_POST['status'],"</font><BR>";
                    }
                }
}
                echo "</fieldset></form>";
 if ($user['admin']>1) {

      if (@$_POST["blockips"]) {
        $f=fopen("blockips.txt","wb");
        $_POST["blockips"]=str_replace("\\n","\r\n",$_POST["blockips"]);
        fwrite($f, $_POST["blockips"]);
      
      echo "<input type=\"submit\" value=\"Сохранить базу\" onclick=\"document.location.href='a.php?backupdb=1'\">";
                echo "<form action=\"a.php\" method=\"post\">
                <textarea name=\"blockips\" style=\"width:200px;height:150px\">".implode("",file("blockips.txt"))."</textarea>
                <br><input type=submit value=\"Блокировать IP\">
                </form>
                <form action=\"a.php\" method=\"post\">
                <input type=\"hidden\" name=\"todo\" value=\"takemoney\">
                <table>
                <tr><td align=right>Ник:</td><td><input type=\"text\" name=\"login\" value=\"$_POST[login]\"></td></tr>
                <tr><td align=right>Сумма:</td><td><input type=\"text\" name=\"sum\" value=\"$_POST[sum]\"></td></tr>
                <tr><td align=right>Причина:</td><td><input type=\"text\" name=\"reason\" value=\"$_POST[reason]\"></td></tr>
                </table>
                <br><input type=submit value=\"Наложить штраф\">
                </form>";
   }
}
 if ($user['align']>2 && $user['align']<3) {
               echo "<form method=post><fieldset><legend>Принять в орден / поменять крест</legend>
                    <table><tr><td>Логин</td><td><input type='text' name='login' value='",$_POST['login'],"'></td></tr>
                    <tr><td>Крест</td><td><select name='krest'>
                    <option value='1.1'>Паладин Поднебесья</option>
                    <option value='1.2'>Инквизитор</option>
                    <option value='1.4'>Таможенный Паладин</option>
                    <option value='1.5'>Паладин Солнечной Улыбки</option>
                    <option value='1.7'>Паладин Огненной Зари</option>
                    <option value='1.75'>Хранитель Знаний</option>
                    <option value='1.9'>Паладин Неба</option>
                    <option value='1.91'>Старший Паладин Неба</option>
                    <option value='1.92'>Кавалер Ордена</option>";
                if (($user['align'] == '2.5') || ($user['align']=='2.6')) {
                    echo "<option value='1.99'>Верховный Паладин</option>";
                }

                echo "</select></td></tr>
                    <tr><td><input type=submit value='Назначить'></td></tr></table>";
                echo "</fieldset></form>";
                if ($_POST['login'] && $_POST['krest']) {
                    switch($_POST['krest']){
                        case 1.1:
                            $rang = 'Паладин Поднебесья';
                        break;
                        case 1.2:
                            $rang = 'Инквизитор';
                        break;
                        case 1.4:
                            $rang = 'Таможенный Паладин';
                        break;
                        case 1.5:
                            $rang = 'Паладин Солнечной Улыбки';
                        break;
                        case 1.7:
                            $rang = 'Паладин Огненной Зари';
                        break;
                        case 1.75:
                            $rang = 'Хранитель Знаний';
                        break;
                        case 1.9:
                            $rang = 'Паладин Неба';
                        break;
                        case 1.91:
                            $rang = 'Старший Паладина Неба';
                        break;
                        case 1.92:
                            $rang = 'Кавалер Ордена';
                        break;
                        case 1.99:
                            $rang = 'Верховный Паладин';
                        break;
                    }
                    $dd = mysql_fetch_array(mysql_query("SELECT `id`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
                    if ($user['sex'] == 1) {$action="присвоил";}
                        else {$action="присвоила";}
                        if ($user['align'] > '2' && $user['align'] < '3')  {
                            $angel="Ангел";
                        }
                        elseif ($user['align'] > '1' && $user['align'] < '2') {
                            $angel="Паладин";
                        }
                    if($dd) {

                        mysql_query("UPDATE `users` SET `align` = '".$_POST['krest']."',`status` = '$rang' WHERE `login` = '".$_POST['login']."';");
                        $target=$_POST['login'];
                        $mess="$angel &quot;{$user['login']}&quot; $action &quot;$target&quot; звание $rang";
                        mysql_query("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$dd['id']."','$mess','".time()."');");
                        mysql_query("INSERT INTO `paldelo`(`id`,`author`,`text`,`date`) VALUES ('','".$_SESSION['uid']."','$mess','".time()."');");


                    }
                }
        }
    if ($user['align']>2 && $user['align']<3) {
                echo "<form method=post><fieldset><legend>Принять в Армаду / поменять должность</legend>
                    <table><tr><td>Логин</td><td><input type='text' name='login' value='",$_POST['login'],"'></td></tr>
                    <tr><td>Должность</td><td><select name='tarmanka'>
                    <option value='3.01'>Тарман-Служитель</option>
                    <option value='3.05'>Тарман-Надсмотрщик</option>
                    <option value='3.07'>Тарман-Убийца</option>
                    <option value='3.09'>Тарман-Палач</option>
                    <option value='3.091'>Тарман-Владыка</option>
                    <option value='3.06'>Каратель</option>
                    <option value='3.075'>Гвардеец-13</option>
                    <option value='3.092'>Ветеран Армады</option>";
                if (($user['align'] == '2.5') || ($user['align']=='2.6')) {
                    echo "<option value='3.99'>Патриарх</option>";
                }

                echo "</select></td></tr>
                    <tr><td><input type=submit value='Назначить'></td></tr></table>";
                echo "</fieldset></form>";
                if ($_POST['login'] && $_POST['tarmanka']) {
                    switch($_POST['tarmanka']){
                        case 3.01:
                            $rang = 'Тарман-Служитель';
                        break;
                        case 3.05:
                            $rang = 'Тарман-Надсмотрщик';
                        break;
                        case 3.07:
                            $rang = 'Тарман-Убийца';
                        break;
                        case 3.09:
                            $rang = 'Тарман-Палач';
                        break;
                        case 3.091:
                            $rang = 'Тарман-Владыка';
                        break;
                        case 3.06:
                            $rang = 'Каратель';
                        break;
                        case 3.075:
                            $rang = 'Гвардеец-13';
                        break;
                        case 3.092:
                            $rang = 'Ветеран Армады';
                        break;
                        case 3.99:
                            $rang = 'Патриарх';
                        break;
                    }
                    $dd = mysql_fetch_array(mysql_query("SELECT `id`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
                    if ($user['sex'] == 1) {$action="присвоил";}
                        else {$action="присвоила";}
                        if ($user['align'] > '2' && $user['align'] < '3')  {
                            $angel="Ангел";
                        }
                        elseif ($user['align'] > '1' && $user['align'] < '2') {
                            $angel="Паладин";
                        }
                    if($dd) {

                        mysql_query("UPDATE `users` SET `align` = '".$_POST['tarmanka']."',`status` = '$rang' WHERE `login` = '".$_POST['login']."';");
                        $target=$_POST['login'];
                        $mess="$angel &quot;{$user['login']}&quot; $action &quot;$target&quot; звание $rang";
                        mysql_query("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$dd['id']."','$mess','".time()."');");
                        mysql_query("INSERT INTO `paldelo`(`id`,`author`,`text`,`date`) VALUES ('','".$_SESSION['uid']."','$mess','".time()."');");


                    }
                }
     if ($user['admin']==1)  {
include "a1.php";
}
        }

include "zaschita/razblock.php";

    if ($user['align']>2 && $user['align']<3) {
if ($_POST['sbr_par']) {
    $sb_pers = mysql_fetch_array(mysql_query("SELECT id,nextup,level FROM `users` WHERE `login` = '{$_POST['sbr_par']}' LIMIT 1;"));
    undressall($sb_pers['id']);

    $levelstats=statsat($sb_pers['nextup']);
    mq("delete from effects where (sila<>0 or lovk<>0 or inta<>0 or vinos<>0 or intel<>0) and owner='$sb_pers[id]'");
    mq("delete from obshagaeffects where (sila<>0 or lovk<>0 or inta<>0 or vinos<>0 or intel<>0) and owner='$sb_pers[id]'");
    mq("UPDATE `users` SET `stats` = ".($levelstats['stats']-9).", `sila`=3,`lovk`=3,`inta`=3,`mudra`=0,`intel`=0,`spirit`= ".$levelstats["spirit"].", sexy=0,`vinos`= ".$levelstats["vinos"].",`maxhp`= ".$levelstats["vinos"]."*6,`maxmana`= 0,`mana`= 0 WHERE `id`='$sb_pers[id]' LIMIT 1");
    mq("UPDATE `userdata` SET `stats` = ".($levelstats['stats']-9).", `sila`=3,`lovk`=3,`inta`=3,`mudra`=0,`intel`=0,`spirit`= ".$levelstats["spirit"].", sexy=0,`vinos`= ".$levelstats["vinos"]." WHERE `id`='$sb_pers[id]' LIMIT 1");

//mysql_query("DELETE FROM `effects` WHERE `owner` = '".$sb_pers['id']."' and `type`=188");
            //if (mysql_query("UPDATE `users` SET `stats` = ".$expstats[$sb_pers['nextup']].", `sila`=3,`lovk`=3,`inta`=3,`mudra`=0,`intel`=0,`spirit`=0,`vinos`= ".$vinoslvl[$sb_pers['level']].",`maxhp`= ".$vinoslvl[$sb_pers['level']]."*6,`maxmana`= 0,`mana`= 0 WHERE `id`= ".(int)$sb_pers['id']." LIMIT 1;")) {
                echo "<font color=red>Все прошло удачно. Персонаж может перераспределить параметры.</font>";
                /*}
            else echo "<font color=red>Произошла ошибка!</font>";*/

    }
if ($_POST['zaderz_del1']) { if (mq("delete from effects where type=9;")) {echo "<font color=red><b>Все прошло успешно</b></font>";} else {echo "<font color=red><b>Что то не вышло</b></font>";} }
if ($_POST['res_user1']) { $res_pers1 = mysql_fetch_array(mysql_query("SELECT id FROM `allusers` WHERE `id` = '{$_POST['res_user1']}' LIMIT 1;")); restoreuser($res_pers1['id']); }
if ($_POST['cler_user1']) { $cler_pers1 = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE `id` = '{$_POST['cler_user1']}' LIMIT 1;")); clearuser($cler_pers1['id']); }
if ($_POST['zaderz_del2']) { if (mq("delete from effects where type=9 and owner  = '{$_POST['zaderz_del2']}';")) {echo "<font color=red><b>Все прошло успешно</b></font>";} else {echo "<font color=red><b>Что то не вышло</b></font>";} }
?>
<br><fieldset>
<legend style='font-weight:bold; color:#8F0000;'>Сброс параметров персонажа</legend>
<form method=post>Логин: <input type=text name='sbr_par'> <input type=submit value='Отпустить параметры'></form>
</fieldset><br><br>
<?}     if ($user['admin']==1)  {?>
<br><fieldset>
<legend style='font-weight:bold; color:#8F0000;'>Админская панелька</legend>
<INPUT TYPE=button onClick="window.open('/functions/dobavitj_vesh_magazins.php', 'dobavitj_vesh', 'location=yes,menubar=yes,status=yes,resizable=yes,toolbar=yes,scrollbars=yes,scrollbars=yes')" class="btn" style="border: 1px double #9a9996;font-size: 12px;color: #dfdfdf;background-color:#504F4C;" value="Добавить вещь в магазин">
<INPUT TYPE=button onClick="window.open('/functions/dobavitj_vesh_berezkas.php', 'dobavitj_vesh', 'location=yes,menubar=yes,status=yes,resizable=yes,toolbar=yes,scrollbars=yes,scrollbars=yes')" class="btn" style="border: 1px double #9a9996;font-size: 12px;color: #dfdfdf;background-color:#504F4C;" value="Добавить вещь в березку">
<form method=post><input type=submit name='zaderz_del1' value='Удалить задержки на клан у всех'></form>
<!--form method=post>ID персонажа: <input type=text name='res_user1'> <input type=submit value='Восстановить персонажа'></form-->
<form method=post>ID персонажа: <input type=text name='cler_user1'> <input type=submit value='Отправить персонажа'></form>
<INPUT TYPE=button onClick="window.open('adminion.php', 'dobavitj_vesh', 'location=yes,menubar=yes,status=yes,resizable=yes,toolbar=yes,scrollbars=yes,scrollbars=yes')" class="btn" style="border: 1px double #9a9996;font-size: 12px;color: #dfdfdf;background-color:#504F4C;" value="Админ панель">
<form method=post>ID: <input type=text name='zaderz_del2'> <input type=submit value='Удалить задержки на клан'></form> <form method=post>Название: <input type=text name='zaderz_del31232'> <input type=submit value='Удалить клан'></form>
</fieldset><br>
<? include "p123.php"; } ?>
</body>
</html>
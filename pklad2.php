<?php
	ob_start("ob_gzhandler");	
	session_start();
	if (!($_SESSION['uid'] > 0)) header("Location: index.php");
	include "connect.php";
	$user = mysql_fetch_array(mysql_query("SELECT `align`,`id`,`level`,`login`,`money`,`room`,`weap`,`battle`,`zayavka`,`pole_kopka_kol_now`,`pole_kopka_kol_bonus`,`pole_kopka_update`,`pole_kopka_min`,`pole_kopka_max`,`pole_kopka_kol_all`,`pole_kopka_present`,`pole_kopka_last_visit` FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
    $pole_time=mysql_fetch_array(mysql_query("SELECT * FROM `variables` WHERE var='pole_random';"));
	$tp=time();
	include "functions.php";
//	if ($user['room'] != 58) { header("Location: main.php");  die(); } 
	if ($user['level'] < 4) { header("Location: main.php");  die(); } 
	if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }

    // блокировка на повторный вход (3600 сек)
    if ($user['id'] != 7) {
        if (!isset($_SESSION['pole_kopka_access'])) {
            if ($user['pole_kopka_last_visit']) { // если только зашел и раньше бывал
                if ((time() - $user['pole_kopka_last_visit']) < 3600) {
                    $_SESSION['pole_kopka_access'] = false;
                    header("Location: city.php?got=1&level49=1");
                    die();
                }
            }
            $_SESSION['pole_kopka_access'] = true;
        }
        // обновляем при каждой перезагрузке, чтобы были данные в случае, если закроет браузер
        mysql_query("UPDATE users SET pole_kopka_last_visit = " . time() . " WHERE id = " . $user['id']);
    }
    
    //if ($user['id'] == 7) {
        // бонусы
        if ($user['pole_kopka_kol_bonus']) {
            // за каждые 100 в рюкзак лопату новичка
            if ($user['pole_kopka_present'] != $user['pole_kopka_kol_bonus']) {
                if (is_integer($user['pole_kopka_kol_bonus'] / 100)) {
                    mysql_query("INSERT INTO `inventory` (`name`,`type`,`duration`,`maxdur`,`owner`,`img`,`present`,`isrep`) VALUES ('Копалка новичка','3','0','20','".$user['id']."','kopalka1.gif','Мусорщик','0')");
                    addchp("<font color=\"Black\">private [" . $user['login'] . "]  Внимание! За 100 бонусных копок, Вы получили копалку. Осмотрите Ваш инвентарь.</font>", "Комментатор");
                    mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$user['id']}','\"".$user['login']."\" получил Копалку новичка за 100 бонусных копок',1,'".time()."');") or die(mysql_error());
                }
                if (is_integer($user['pole_kopka_kol_bonus'] / 200)) {
                    mysql_query("update `bank` set `ekr`=`ekr`+'2' where `owner`='" . $user['id'] . "' LIMIT 1;");
                    addchp("<font color=\"Black\">private [" . $user['login'] . "]  Внимание! За 200 бонусных копок, Вы получили бонус в размере 2 екр, которые зачисленны на Ваш счет в банке.</font>", "Комментатор");
                    mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$user['id']}','\"".$user['login']."\" получил 2 екр за 200 бонусных копок',1,'".time()."');") or die(mysql_error());
                }
                mysql_query('UPDATE users SET pole_kopka_present = ' . $user['pole_kopka_kol_bonus'] . ' WHERE id = ' . $user['id']) or die(mysql_error());
            } 
        }
    //}


echo"
<table><td></td><td width=\"100%\" valign=\"top\">
<HTML><HEAD>
<link rel=stylesheet type=\"text/css\" href=\"../i/main.css\">
<meta content=\"text/html; charset=windows-1251\" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<SCRIPT LANGUAGE=\"JavaScript\" SRC=\"../i/sl2.js\"></SCRIPT>
";

if ($user['id'] != 7) {
    echo "
    <script LANGUAGE='JavaScript'>   
    document.ondragstart = test;
    //запрет на перетаскивание
    document.onselectstart = test;
    //запрет на выделение элементов страницы
    document.oncontextmenu = test;
    //запрет на выведение контекстного меню
    function test() {
     return false
    }
    </SCRIPT>
    ";
}
 ?>
<script Language="JavaScript"> 
<!-- hide
 var timeStr1;
 var time=0;
 
  function clock(time) {
        time=time-1;
       	if (time>=10) timeStr= "00:" + time;
            else timeStr= "00:0" + time;
 
        if (time>-1) {
          document.getElementById('timer').innerHTML = timeStr;
          document.getElementById('sbmit').disabled = true;
          if (document.inner_user.suyla[1].checked) {
            setTimeout("clock("+time+")",1000);}
          }
        else
          {
          document.getElementById('timer_katartu').style.display='none';
          document.getElementById('sbmit').disabled = false;
          document.getElementById('sbmit').innerHTML="<input type=submit class=input name=tik value='Вскопать'>";
          }
    }
 
  function chSuyla(Tip) {
    document.getElementById('soo'+Tip).style.color='black';
    switch(Tip) {
    case 1:
        //document.getElementById('soo2').style.color='#A99E99';
        //document.getElementById('soo3').style.color='#A99E99';
        document.getElementById('sooi1').disabled = false;
        document.getElementById('timer_katartu').style.display='none';
        document.getElementById('sbmit').innerHTML="<input type=submit class=input name=tik value='Вскопать'>";
        document.inner_user.suyla[0].checked = true;
        break
    case 2:
        //document.getElementById('soo1').style.color='#A99E99';
        //document.getElementById('soo3').style.color='#A99E99';
        document.getElementById('sooi1').disabled = true;
        document.getElementById('sbmit').innerHTML="";
        document.getElementById('timer_katartu').innerHTML="(подождите <b><span id='timer'></span></b> сек.)";
        document.getElementById('timer_katartu').style.display='';
        document.inner_user.suyla[1].checked = true;
        clock(600);
        break
    case 3:
        //document.getElementById('soo2').style.color='#A99E99';
        //document.getElementById('soo1').style.color='#A99E99';
        document.getElementById('sooi1').disabled = true;
        document.inner_user.suyla[2].checked = true;
        document.getElementById('timer_katartu').style.display='none';
        document.getElementById('sbmit').innerHTML="<input type=submit class=input name=tik value='Вскопать'>";
        break
 
     }
  }
 
 
// -->
</script> 
<?
echo "
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=#e2e0e0 onLoad=chSuyla(2)>

<SCRIPT src='../i/commoninf.js'></SCRIPT>
<div id=hint4 class=ahint></div>
<DIV id=hint1></DIV>
<div id=mainform style='position:absolute; left:30px; top:30px'></div>
";

 ?>

<?
if($_POST['bonuskopka']){
 if($user['money'] >= 75){
mysql_query("update `users` set `pole_kopka_kol_bonus`=`pole_kopka_kol_bonus`+'1',`pole_kopka_kol_now`=`pole_kopka_kol_now`+'1',`pole_kopka_kol_all`=`pole_kopka_kol_all`+'1',`money`=`money`-'75' where `id`='".$user['id']."'");
$user['pole_kopka_kol_now'] += 1;
echo"Вы купили +1 доп. копку!";
}else{echo"Не достаточно кр!";}
}

if($_POST['x3']){
 if($user['money'] >= 95){
mysql_query("update `users` set `pole_kopka_update`='3',`pole_kopka_min`=`pole_kopka_min`*'3',`pole_kopka_max`=`pole_kopka_max`*'3',`money`=`money`-'95' where `id`='".$user['id']."'");
echo"Вы улучшили глубину х3!";
}else{echo"Не достаточно кр!";}
}

if($_POST['x5']){
 if($user['money'] >= 150){
mysql_query("update `users` set `pole_kopka_update`='5',`pole_kopka_min`=`pole_kopka_min`*'5',`pole_kopka_max`=`pole_kopka_max`*'5',`money`=`money`-'150' where `id`='".$user['id']."'");
echo"Вы улучшили глубину х5!";
}else{echo"Не достаточно кр!";}
}

if($_POST['x2']){
 if($user['money'] >= 50){
mysql_query("update `users` set `pole_kopka_update`='2',`pole_kopka_min`=`pole_kopka_min`*'2',`pole_kopka_max`=`pole_kopka_max`*'2',`money`=`money`-'50' where `id`='".$user['id']."'");
echo"Вы улучшили глубину х2!";
}else{echo"Не достаточно кр!";}
}

if($_POST['buy1']){
    if($user['money'] >= 85){
           $lopata = mysql_fetch_array(mysql_query("select `name` from `inventory` where `owner`='".$user['id']."' AND (`name`='Копалка новичка' OR `name`='Копалка мастера')"));
 if(!$lopata){
mysql_query("INSERT INTO `inventory` (`name`,`type`,`duration`,`maxdur`,`owner`,`img`,`present`,`isrep`) VALUES ('Копалка новичка','3','0','20','".$user['id']."','kopalka1.gif','Мусорщик','0')");
mysql_query("UPDATE `users` set `money`=`money`-'85',`pole_kopka_kol_now`='7',`pole_kopka_kol_all`='7',`pole_kopka_min`='5',`pole_kopka_max`='14',`pole_kopka_kol_bonus`='0',`pole_kopka_update`='0' where `id`='".$user['id']."'");
echo"Вы купили копалку новичка!";
mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$user['id']}','\"".$user['login']."\" купил Копалку новичка за 5 кр',1,'".time()."');");
}else{echo"У Вас уже есть копалка! Для начала необходимо выбросить старую!";}
}else{echo"У вас не хватает кр!";}
}

if($_POST['buy2']){
    if($user['money'] >= 100){
           $lopata = mysql_fetch_array(mysql_query("select `name` from `inventory` where `owner`='".$user['id']."' AND (`name`='Копалка новичка' OR `name`='Копалка мастера')"));
 if(!$lopata){
mysql_query("INSERT INTO `inventory` (`name`,`type`,`duration`,`maxdur`,`owner`,`img`,`present`,`isrep`) VALUES ('Копалка мастера','3','0','40','".$user['id']."','kopalka2.gif','Мусорщик','0')");
mysql_query("UPDATE `users` set `money`=`money`-'100',`pole_kopka_kol_now`='9',`pole_kopka_kol_all`='9',`pole_kopka_min`='8',`pole_kopka_max`='19',`pole_kopka_kol_bonus`='0',`pole_kopka_update`='0' where `id`='".$user['id']."'");
echo"Вы купили копалку мастера!";
mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$user['id']}','\"".$user['login']."\" купил Копалку мастера за 10 кр',1,'".time()."');");
}else{echo"У Вас уже есть копалка! Для начала необходимо выбросить старую!";}
}else{echo"У вас не хватает кр!";}
}


if($_POST['sufle']){
for($i=0; $i<41; $i++) {
$hrand = rand(1,11)/10;
$rand = rand(1,9);
$rekrr = 30/30;
$rekr = rand(1,$rekrr)/10;
$bonus = rand(1,13)/10;
$bonuss = $rekr * $bonus;
$rekrr = $rekr + $bonuss;
if($rand == 1){$h = 100;}
elseif($rand == 2){$h = 80;}
elseif($rand == 3){$h = 70;}
elseif($rand == 4){$h = 60;}
elseif($rand == 5){$h = 50;}
elseif($rand == 6){$h = 40;}
elseif($rand == 7 || $rand == 8 || $rand == 9){$h = 0;}

$hh = $h * $hrand;
$h = $h + $hh;

mysql_query("UPDATE `pole` set `type`='".$rand."',`heals`='".$h."',`ekr`='".$rekrr."' where `id`='".$i."'");
}
}


if($_POST['view']){
      $id = mysql_real_escape_string($_POST['id']) ;
      $now_water = mysql_fetch_array(mysql_query("select `type` from `pole` where `id`='".$id."'"));
      if($now_water['type'] != 0){
      
     $lopata = mysql_fetch_array(mysql_query("select `name` from `inventory` where `owner`='".$user['id']."' AND `dressed`='1' AND (`name`='Копалка новичка' OR `name`='Копалка мастера')"));
     if($lopata['name']){
mysql_query("update `pole` set `type`='0' where `id`='".$id."'");
$randview = rand(1,5);
$randkr = rand(1,150)/10;
$randizn = rand(1,4);
if($randview == 1 || $randview == 2 || $randview == 3){
mysql_query("update `users` set `money`=`money`+'".$randkr."' where `id`='".$user['id']."'");
echo"Вы достали из воды ".$randkr." кр!";
mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$user['id']}','\"".$user['login']."\" достал из воды на Поле Кладоискателей ".$randkr." кр',1,'".time()."');");
}
else{
$randizn = rand(1,4);
$lopatas = mysql_fetch_array(mysql_query("SELECT `prototype`,`duration`,`id` FROM `inventory` WHERE `id`='".$user['weap']."' AND `owner` = '".$user['id']."' AND `dressed` = '1'"));
mysql_query("UPDATE `inventory` set `duration`=`duration`+'".$randizn."' where `id`='".$lopatas['id']."'");
echo"Вы наткнулись на камень! Ваша копалка поломалась на ".$randizn." ед.";
}
}else{echo"Возьмите копалку в руки, либо купите ее!";}
}else{echo"Здесь уже черпали!";}
}

if($_POST['tik']){
     $lopata = mysql_fetch_array(mysql_query("select `name` from `inventory` where `owner`='".$user['id']."' AND `dressed`='1' AND (`name`='Копалка новичка' OR `name`='Копалка мастера')"));
     if($lopata['name']){

         if($user['pole_kopka_kol_now'] > 0){
    $id = mysql_real_escape_string($_POST['id']) ;
    $randhp = rand($user['pole_kopka_min'],$user['pole_kopka_max']);
     $shans = rand(1,3);
     $iznos = rand(1,5);
    $pole = mysql_fetch_array(mysql_query("select * from `pole` where `id`='".$id."'"));
if($pole['type'] != 0){
if($iznos == 1){
$lopatas = mysql_fetch_array(mysql_query("SELECT `prototype`,`duration`,`id` FROM `inventory` WHERE `id`='".$user['weap']."' AND `owner` = '".$user['id']."' AND `dressed` = '1'"));
mysql_query("UPDATE `inventory` set `duration`=`duration`+'1' where `id`='".$lopatas['id']."'");
echo"Ваша копалка поломалась на 1 ед!<br>";
}


if($shans == 1 || $shans == 2){$bon = $pole['ekr'];}
else{$bon = 0;}
$hp = $pole['heals'] - $randhp;
if($hp > 0){
mysql_query("update `pole` set `heals`=`heals`-'".$randhp."' where `id`='".$id."'");
mysql_query("update `users` set `pole_kopka_kol_now`=`pole_kopka_kol_now`-'1' where `id`='".$user['id']."'");
$user['pole_kopka_kol_now'] -= 1;
echo"Вы уменьшили глубину сектора на ".$randhp." единиц!";
}
else{
mysql_query("update `pole` set `heals`='0',`type`='0' where `id`='".$id."'");
mysql_query("update `users` set `pole_kopka_kol_now`=`pole_kopka_kol_now`-'1' where `id`='".$user['id']."'");
mysql_query("update `bank` set `ekr`=`ekr`+'".$bon."' where `owner`='".$user['id']."' LIMIT 1;");
$user['pole_kopka_kol_now'] -= 1;
echo"Вы выкопали ".$bon." екр! Ищите в Банке, если у Вас есть счет. Если счета нету, срочно откройте его. :)";
mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$user['id']}','\"".$user['login']."\" выкопал на Поле Кладоискателей ".$bon." екр',1,'".time()."');");
}
}else{echo"Этот сектор уже был вскопан!";}
}else{echo"У Вас больше не осталось свободных копок!";}
}else{echo"<font color=red><b>Необходимо купить и взять в руки копалку!</b></font>";}
}


print "<center><font style='font-size: 16px; color: maroon; font-weight: bold;'>Поле Кладоискателей</font></br /><font size=-2>Правила Поля Кладоискателей:<br> 1. Купите копалку, нажав кнопку 'Инструменты' 2. Купив инструмент, Вы можете начать копать екр. 3. Если  написано 'Поле выкопано', значит более шустрые игроки до Вас уже все выкопали.  Но не расстраивайтесь ! Ждите, когда на Поле прорастут следующие кредиты и еврокредиты, а скорость роста зависит от активности игроков в проекте . 4. Обращаем Ваше внимание, что Поле Кладоискателей в процессе работ, будет подвергаться измененениям.</font><br />";

if($user['id'] == '50'){ if($tp<=$pole_time['value'])
{
    $p_wait=round((($pole_time['value']-$tp)/60),1);
    if($p_wait<=480)
    echo '<center><font color=red size=-2>Заходите снова через '.$p_wait.' минут</font></center>';
}}

?>

<FORM action="city.php" method=GET>
<? if ($user["room"] ==58) echo "<input type=hidden name=got value=\"1\"><input type=hidden name=level49 value=\"1\">"; ?>
<INPUT TYPE="submit" value="Обратно к Новой земле" name=""> <INPUT type='button' value='Обновить' style='width: 75px' onclick='location="/pklad2.php"'></FORM>
 <TABLE border=0 width=30% cellspacing="0" cellpadding="1" bgcolor=#d4d2d2 align=center><TR>
			<TD width=15%  align=center bgcolor="<?=($_GET['razdel']==0)?"#A5A5A5":"#C7C7C7"?>"><A HREF="?razdel=0">Поле</A></TD>
			<TD width=15%  align=center bgcolor="<?=($_GET['razdel']==1)?"#A5A5A5":"#C7C7C7"?>"><A HREF="?razdel=1">Инструменты</A></TD>
	</TR>
	</TABLE>
<?echo"</font>";
if ($_GET['razdel']==0) {
         $lopata = mysql_fetch_array(mysql_query("select `name`,`img`,`duration`,`maxdur` from `inventory` where `owner`='".$user['id']."' AND `name`='Копалка новичка' OR `name`='Копалка мастера' AND `dressed`='1'"));
if($lopata){
    echo"<center><small>Кол-во копок: <b>".$user['pole_kopka_kol_now']."</b>";
    if($user['pole_kopka_kol_bonus'] > 0){echo" (<font color=green><b>".$user['pole_kopka_kol_bonus']."</b> бонусные</font>)";}
    echo" | Глубина копки: <b>-".$user['pole_kopka_min']."</b> .. <b>-".$user['pole_kopka_max']."</b>";
    if($user['pole_kopka_update'] > 0){echo" (<font color=green><b>x".$user['pole_kopka_update']."</b></font>)";}
    echo"</small></center>";
}
else{echo"<center><small>У вас нет копалки!</small></center>";}
echo"<table width=100% align=center border=0>
<td valign=top align=center>";
          echo"<table width=1000 height=400 border=1 cellspacing=0 cellpadding=0 valign=top>";
          

          $pole=mysql_query("SELECT * FROM `pole`");
                $chislo = mysql_num_rows($pole);
        if ($chislo > 0) {
echo "<tr valign='top' height=75>";
for($i=0; $i<mysql_num_rows($pole); $i++) {
     $poles=mysql_fetch_array($pole);
    if($poles['type'] == 1){$col = "Teal";}
    elseif($poles['type'] == 2){$col = "gray";}
    elseif($poles['type'] == 3){$col = "silver";}
    elseif($poles['type'] == 4){$col = "pink";}
     elseif($poles['type'] == 5){$col = "DarkGray";}
      elseif($poles['type'] == 6){$col = "DarkSlateBlue";}
       elseif($poles['type'] == 7 || $poles['type'] == 8 || $poles['type'] == 9){$col = "lightblue";}
       elseif($poles['type'] == 0){$col = "Navy";}
     if (fmod($i, 10)==0) echo "</tr><tr valign='top' align='center'>";
      echo "<td valign='top' bgcolor='".$col."' width='90' height='90'>";
echo"<font color=white>B - ".$poles['id']."";
if($poles['type'] >= 1 && $poles['type'] <= 6){
echo"<FORM name=inner_user action=pklad2.php method=POST>
<input type=hidden name=suyla value='1' onclick='chSuyla(1)'><span id='soo1' onclick='chSuyla(1)'><input type=hidden name='player' class='inp' id='sooi1' value=''></span> 
<input type=hidden name=suyla value='2' onclick='chSuyla(2)'><span id='soo2'><span style='display:none' id='timer_katartu'></span></span> 
<input type=hidden name=suyla value='3' onclick='chSuyla(3)'><span id='soo3'></span>
<INPUT TYPE=hidden value=".$poles['name']." name=id><span id=sbmit><input type=submit disable class=input name=tik value='Вскопать'></span><br><img src=i/pklad/ucon.gif></FORM>";
}
elseif($poles['type'] == 7 || $poles['type'] == 8 || $poles['type'] == 9){echo"<FORM action=pklad2.php method=POST><INPUT TYPE=hidden value=".$poles['name']." name=id><input type=submit class=input name=view value='Зачерпнуть'><br><img src=http://theimba.ru/img/smiles/1_14.gif></FORM>";}
elseif($poles['type'] == 0){echo"<p><font color=white>Поле выкопано</font><br><img src=i/pklad/1_14.gif><p>";}
echo"<img src=i/pklad/bott.png>".$poles['heals']."</font>";

echo "</td>";

        }
      echo "</table>";
}

echo"</td>
</table>";
?>
<FORM action=pklad2.php method=POST>
<?
if($user['id'] == '50' OR $user['id'] == '2735'){
echo" <input type=submit class=input name=sufle value='Перемешать'>";
}
}
if ($_GET['razdel']==1) {
echo"<FORM action=pklad2.php method=POST><center>Внимание для копания вам необходима копалка!</center><br>";
     $lopata = mysql_fetch_array(mysql_query("select `name`,`img`,`duration`,`maxdur` from `inventory` where `owner`='".$user['id']."' AND (`name`='Копалка новичка' OR `name`='Копалка мастера') AND `dressed`='1'"));
echo"У Вас в руках:<br>";
if($lopata){
echo"<small>".$lopata['name']." [".$lopata['duration']."/".$lopata['maxdur']."]</small><br><img src=i/sh/".$lopata['img']."><hr>
<input type=submit class=input name=bonuskopka value='Купить +1 копку'> <small>Позволяет копнуть на 1 раз больше. Цена: <b>2</b> Кр</small><hr>";
if($user['pole_kopka_update'] == 0){
echo"<center><small><b>ВНИМАНИЕ! Улучшить глубину копалки можно лиш один раз, выбирайте сразу насколько сильно вы хотите ее улучшить!</b></small></center>
<input type=submit class=input name=x2 value='Улучшить глубину х2'> <small>Увеличивает глубину копания копалкой в 2 раза! Цена: <b>20</b> Кр</small><br>
<input type=submit class=input name=x3 value='Улучшить глубину х3'> <small>Увеличивает глубину копания копалкой в 3 раза! Цена: <b>45</b> Кр</small><br>
<input type=submit class=input name=x5 value='Улучшить глубину х5'> <small>Увеличивает глубину копания копалкой в 5 раза! Цена: <b>110</b> Кр</small>";
}else{echo"Вы уже улучшили глубину для этой копалки! Ваше улучшение <b>x".$user['pole_kopka_update']."</b>";}
echo"<hr>";
}
else{echo"<font color=red><b>нет копалки!</b></font><p>";}
echo"<b>Вы можете купить:</b><br><small>ВНИМАНИЕ! Купив новую копалку вы теряете все доп. копки и улучшенную глубину прежней копалки!</small>";
echo"<table width=400 valign=top><tr valign=top><td width=200 align=left><center><small>Копалка новичка<br><img src=i/sh/kopalka1.gif></center>Кол-во копаний: <b>7</b><br>Глубина копки: <b>-5</b> .. <b>-14</b><br>Стоимость: <b>5</b> Кр</small><center><input type=submit class=input name=buy1 value='Купить'></center></td><td width=200 align=left><center><small>Копалка мастера<br><img src=i/sh/kopalka2.gif></center>Кол-во копаний: <b>9</b><br>Глубина копки: <b>-8</b> .. <b>-19</b><br>Стоимость: <b>10</b> Кр</small><center><input type=submit class=input name=buy2 value='Купить'></td></tr></table>";
}

echo '<FONT style="FONT-SIZE: 10pt; COLOR: red"><B><div id="rezultat"></div></B></FONT>';
?>

</FORM>
</BODY>
</HTML>


<?php
    session_start();
    if (@$_SESSION['uid'] == null) {
      header("Location: index.php");
      die;
    }
    include "connect.php";
    include "functions.php";
    if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }
if(in_array($user["room"], $canalrooms)) {print "<script>location.href='canalizaciya.php'</script>";}

if(in_array($user["room"], $canalenters)){
  $podzemroom=$user["room"]+1;
  include "config/podzemdata.php";  
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
</HEAD>
<BODY style="BACKGROUND-IMAGE: url(<?=IMGBASE?>/i/misc/showitems/dungeon.jpg); BACKGROUND-REPEAT: no-repeat; BACKGROUND-POSITION: right top" bgColor=#e2e0e0>
<?php if ($user['id'] != 7) { ?>
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
<?php } ?>

<?
  if (@$_GET["start"] && $user["room"]==64 && time()<1318780801) {
    unset($_GET["start"]);
    $diff=1318780801-time();
    echo "<b><font color=red>Викторина начнётся через ".secs2hrs($diff)."</font></b>";
  }
  if (@$_GET["start"] && $user["room"]==71) {
    unset($_GET["start"]);
    echo "<b><font color=red>Не стоит туда входить, маги в любой момент могут начать читсть заклинание.</font></b>";
  }
  if (@$_GET["start"] && $user["room"]==64 && time()>1318780801+(60*60)) {
    unset($_GET["start"]);
    echo "<b><font color=red>Вход на викторину уже закрыт.</font></b>";
  }
  if(@$_GET["warning"] && strlen($_GET["warning"])>1) echo "<b><font color=red>$_GET[warning]</font></b>";
?>
<div id=hint4 class=ahint></div>

<TABLE width=100%>
<TR><TD valign=top width=100%><center><h3><?=$rooms[$user["room"]]?></h3></center>
<?
$select = mysql_query ("SELECT `time` FROM `visit_podzem` WHERE room='$podzemroom' and `login`='".$user['login']."' and `time`>'0'");
if($el = mysql_fetch_array ($select)) {
  $wait_sec=$el["time"];
  $new_t=time();
  $left_time=$wait_sec-$new_t;
  $left_min=floor($left_time/60);
  $left_sec=$left_time-$left_min*60;
  if (($user["align"]=="2.5" || $user["align"]=="2.9" || (($user["align"]=="1.1" || $user["align"]=="3.01") && $user["room"]!=51)) && $wait_sec>$new_t) {
    $wait_sec=1;
    mq("update `visit_podzem` set time=1 WHERE `login`='$user[login]' and `time`>'0' and room='$user[room]'");
  }
  if ($wait_sec>$new_t) {
    if (@$_GET["donate"]) {
      if ($user["money"]>=$podzemdata[$podzemroom]["passprice"]) {
        mq("update users set money=money-".$podzemdata[$podzemroom]["passprice"]." where id='$user[id]'");
        mq("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" пожертвовал на благоустройство пещеры \"".$podzemdata[$podzemroom]["passprice"]."\" кр. ($user[money]/$user[ekr]). ',7,'".time()."');");
        $wait_sec=0;
      } else {
        echo "<b><font color=red>У вас недостаточно денег</font></b>";
      }
    }
  }
  if($wait_sec>$new_t) {
    print" <font style='font-size:12px'>Вы можете посетить ".$podzemdata[$podzemroom]["name1"]." через
    <font style='font-size:11px; color:#000;'> ".secs2hrs($left_time)."</font><br>";
    if (@$podzemdata[$podzemroom]["passprice"]) {
      echo "Пожертвовав ".$podzemdata[$podzemroom]["passprice"]." кр. на благоустройство ".$podzemdata[$podzemroom]["name2"].", это можно сделать прямо сейчас. <a onclick=\"return confirm('Пожертвовать ".$podzemdata[$podzemroom]["passprice"]." кр. на благоустройство ".$podzemdata[$podzemroom]["name2"]."?');\" href=\"vxod1.php?donate=1\">Пожертвовать</a>.";
    }
  } else {
    mysql_query("DELETE FROM visit_podzem WHERE login='".$user['login']."' and room='$podzemroom'");
    print "<script>location.href='main.php?act=none'</script>";
    exit;
  }
} else {
  $login = $user['login'];
  $ya=mysql_query("select login from vxodd where login='$login'");
  $wawe = "0";
  if($daw=mysql_fetch_array($ya)){$wawe="1";}
  $naw=mysql_query("select login from vxod where login='$login'");
  $nawe = "0";
  if($ser=mysql_fetch_array($naw)){$nawe="1";}
  $rt=mysql_query("select id,level from users where login='$login'");
  $est=mysql_fetch_array($rt);
  $user_id = $est["id"];
  $user_lvl = $est["level"];
  if($_GET['warning']==1){print"<font style='color:#CC0000'>&nbsp;Вы покинули группу</font>";}
  if($_GET['warning']==2){print"<font style='color:#CC0000'>&nbsp;Увы! Не угадали пароль!</font>";}
  if($_GET['warning']==3){print"<font style='color:#CC0000'>&nbsp;Вы подали заявку, сначала отзовите её!</font>";}
  if($_GET['warning']==4){print"<font style='color:#CC0000'>&nbsp;Вы уже в группе!</font>";}
  if($_GET['warning']==5){print"<font style='color:#CC0000'>&nbsp;Группа уже собранна!</font>";}
  if($_GET['warning']==6){print"<font style='color:#CC0000'>&nbsp;Максимальная плата для вашего уровня: ";
  if ($user["level"]<5) echo "15 кр";
  elseif ($user["level"]<7) echo "35 кр";
  else echo "65 кр";
  echo "!</font>";}
  if($_GET['warning']==7){print"<font style='color:#CC0000'>&nbsp;Недостаточно денег для оплаты.</font>";}
  if($_GET['warning']==8){print"<font style='color:#CC0000'>&nbsp;Со склонностью хаос оплата походов запрещена.</font>";}
  print"<TABLE cellpadding=1 cellspacing=0>";

$i=0;
function isonlinelogin($l) {
  $i=mqfa1("select distinct(users.id) from `online` left join users on users.id=online.id WHERE `date` >= ".(time()-60)." and users.login='$l'");
  return $i;
}
$Q=mysql_query("SELECT * FROM vxod where room='$user[room]'");
while($DATA=mysql_fetch_array($Q)){/////////////1
   $cr=$DATA["glav_id"];
   $z_login[$i]=$DATA["login"];
   $date[$i]=$DATA["date"];
   $comment[$i]=$DATA["comment"];
   $password[$i]=$DATA["pass"];

   $mine_z[$i] = 0;

   $Q2=mysql_query("SELECT glav_id FROM vxodd WHERE glav_id='$cr'");
   $t1_all[$i]=0;
   while($DATAS=mysql_fetch_array($Q2)){
   $t1_all[$i]++;
   }
   $creator[$i]=$DATA["glav_id"];
   $i++;
                                   }///////////////1

for($n=0;$n<$i;$n++)
{/////////////открытие
print "<FORM id='REQUEST'>
<TR><TD>
<font class=date>$date[$n]</font><font style='font-size:12px; color:#000000;'>
<!--(<IMG SRC='/i/misc/commut/noblock.gif' WIDTH=20 HEIGHT=20 ALT='Быстрый Бой
(Бой идет со случайно назначенными ударами/блоками и средним уровнем брони)'>)-->";

  $QUER=mysql_query("SELECT login,lvl,fee FROM vxodd WHERE glav_id='$creator[$n]' ORDER BY id ASC");
  while($DATAS=mysql_fetch_array($QUER)){
    if ($_SESSION["uid"]==7) {
      $ol=isonlinelogin($DATAS["login"]);
      if (!$ol) {
        mq("DELETE FROM vxod WHERE login='$DATAS[login]'");
        mq("DELETE FROM vxodd WHERE glav_id='".mqfa1("select id from users where login='$DATAS[login]'")."'");
        mq("DELETE FROM vxodd WHERE login='$DATAS[login]'");
      }
    }

  $p1=$DATAS["login"];
  $p_login=$DATAS["login"];
  $p_lvl=$DATAS["lvl"];
     if($p1!=""){
$p1="<b>$p1</b> [$p_lvl] ".($DATAS["fee"]?" <font color=blue>за $DATAS[fee] кр.</font>":"")."<a href='inf.php?login=$p1' target='_blank'><img src='i/inf.gif' border=0></a> ";
if($t1_all[$n]==1){print "$p1";}else{print "$p1,";}

                }
                                        }
if(!empty($comment[$n])){print"| $comment[$n] </font>";}

if($wawe=='0'){

  if(!empty($password[$n])){print"<INPUT style=\"font-size:12px;\" type='password' name='pass' size=5> ";}
  print"<input style=\"font-size:12px;\" name='naw_id' type='hidden' value='$creator[$n]'>  
  <INPUT style='font-size:12px;' TYPE=submit name=add value='Присоед.'>
  плата: <input type=\"text\"  name=\"fee\" style='font-size:12px;width:20px' maxlength=2> кр.
  ";}
print "</TD>
</TR></FORM>";

}/////////закрытие
?>

<TR><TD>


</TD></TR>
<TR height=1><TD height=1 bgcolor=#A0A0A0 colspan=2><SPAN></SPAN></TD></TR>
</TABLE>






<?


if($wawe=='0'){
print"<FORM id='REQUEST'>
<FIELDSET style='padding-left: 5; width=50%; color:#000000;'>
<LEGEND><B> Группа </B> </LEGEND>
Комментарий <INPUT style=\"font-size:12px;\" TYPE=text NAME=cmt maxlength=40 size=40><BR>
Пароль <INPUT style=\"font-size:12px;\" TYPE=password NAME=pass maxlength=6 size=25><BR>
<!--<input type=checkbox name=bistrob value=bistrob>
<IMG SRC='/i/misc/commut/noblock.gif' WIDTH=20 HEIGHT=20 ALT='Быстрый Бой
(Бой идет со случайно назначенными ударами/блоками и средним уровнем брони)'>Быстрый бой<br>-->
<INPUT style='font-size:12px;' TYPE=submit name=open value='Создать группу'>&nbsp;<BR>

</FIELDSET>
</FORM>";
}else{

print"<FORM id='REQUEST'>
<FIELDSET style='padding-left: 5; width=50%'>
<LEGEND><B> Группа </B> </LEGEND>";
if($nawe==1){print"<INPUT style=\"font-size:12px;\" type='submit' name='start' value='Начать'> &nbsp;";}
print"<INPUT style=\"font-size:12px;\" type='submit' name='del' value='Покинуть группу'>
</FIELDSET>
</FORM>";}

///////////////Подача заявки////////////////////
if($_GET['open'])
{
$der=mysql_query("SELECT glav_id FROM vxodd WHERE login='".$user['login']."'");
if($deras=mysql_fetch_array($der)){
print "<script>location.href='?warning=4'</script>";
exit;
}
$time=date("H:i");
$SQL2 = mysql_query("INSERT INTO vxod(date,login,glav_id,comment,pass,room) VALUES('$time','$login','$user_id','".$_GET['cmt']."','".$_GET['pass']."','$user[room]')");
$SQL2 = mysql_query("INSERT INTO vxodd(login,glav_id,lvl) VALUES('$login','$user_id','$user_lvl')");
if($SQL2){
print "<script>location.href='main.php?act=none'</script>";
exit;}else{print"Ошибка!!! Сообщите администратору!";}
}
//////////////Удаление заявки//////////////////////
if($_GET['del'])
{
$e = mysql_query("DELETE FROM vxod WHERE login='$login'");
$es = mysql_query("DELETE FROM vxodd WHERE glav_id='$user_id'");
$ed = mysql_query("DELETE FROM vxodd WHERE login='$login'");
if($e){
print "<script>location.href='?warning=1'</script>";
exit;
}else{print"Ошибка!!! Сообщите администратору!";}
}
/////////////Присоединится///////////////
if($_GET['add'])
{
$der=mysql_query("SELECT glav_id,id FROM vxodd WHERE login='".$user['login']."'");
if($deras=mysql_fetch_array($der)){
print "<script>location.href='?warning=4'</script>";
exit;
}
$den=mysql_query("SELECT id FROM vxodd WHERE glav_id='".$_GET['naw_id']."'");
if(mysql_num_rows($den) >= (in_array($user["room"]+1, $caverooms)?5:4)){
print "<script>location.href='?warning=5'</script>";
exit;
}

  if($_GET['naw_id']){
    $fee=(int)$_GET["fee"];
    if ($fee<0) $fee=0;
    $badfee=0;
    if ($fee>15 && $user["level"]<5) $badfee=1;
    elseif ($fee>35 && $user["level"]<7) $badfee=1;
    elseif ($fee>65) $badfee=1;
    elseif ($fee>$user["money"]) $badfee=2;
    if ($user["align"]==4 && $fee>0) $badfee=3;
    $p=mqfa1("select pass from vxod where glav_id='$_GET[naw_id]'");
    if ($badfee) {
      print "<script>location.href='?warning=".(5+$badfee)."'</script>";
      exit;
    } elseif ($p==$_GET["pass"]) {
      $rt=mysql_query("select level from users where login='$login'");
      $est=mysql_fetch_array($rt);
      $s = mysql_query("INSERT INTO vxodd(login,glav_id,lvl,fee) VALUES('$login','".$_GET['naw_id']."','".$est["level"]."','$fee')");
      if($s){
        print "<script>location.href='?act=none'</script>";
        exit;
      } else {
        print"Ошибка!!! Сообщите администратору!";
      }
    } else {
      print "<script>location.href='?warning=2'</script>";
      exit;
    }
  } else {
    print "<script>location.href='?warning=2'</script>";
    exit;
  }
}
//////////////////Начинаем////////////////////
if($_GET['start']){
  if (in_array($user["room"]+1, $caverooms)) {
    $nc=1; 
    $locs=array();
  } else $nc=0;
  $zax=mysql_query("select login, fee from vxodd where glav_id='".$user['id']."'");
  $level=0;
  while($nana=mysql_fetch_array($zax)) {
    $n_login = $nana["login"];
    $rty=mysql_query("select id,level,login,sex,shadow, money, ekr from users where login='$n_login'");
    $esth=mysql_fetch_array($rty);
    if ($nana["fee"]) {
      if ($nana["fee"]>$esth["money"]) continue;
      mq("update users set money=money+$nana[fee] where id='$user[id]'");
      mq("update users set money=money-$nana[fee] where id='$esth[id]'");
      $user["money"]+=$nana["fee"];
      $esth["money"]-=$nana["fee"];
      adddelo($user["id"], "Персонаж $user[login] получил $nana[fee] кр. за поход по локации \"".$rooms[$user["room"]+1]."\" от персонажа $esth[login] ($user[money]/$user[ekr]).", 1);
      adddelo($esth["id"], "Персонаж $esth[login] заплатил $nana[fee] кр. за поход по локации \"".$rooms[$user["room"]+1]."\" персонажу $user[login] ($esth[money]/$esth[ekr]).", 1);
    }
    if ($esth["level"]>$level) $level=$esth["level"];
    $est_id = $esth["id"];
    $est_login = $esth["login"];
    $vremya=$podzemdata[$podzemroom]["delay"]*60+time();
    mq('insert into visit_podzem (login,time, room) values("'.$n_login.'","'.$vremya.'", \''.$podzemroom.'\')');
    $vrem=30*60+time();
    if (!$nc) mq('insert into labirint(user_id, login, location, vector, glav_id, glava, t, l,key1,key2,key3,el,name,visit_time) values("'.$est_id.'", "'.$est_login.'", "'.$podzemdata[$podzemroom]["location"].'", "'.$podzemdata[$podzemroom]["vector"].'", "'.$user['id'].'", "'.$user['login'].'","'.$podzemdata[$podzemroom]["t"].'","'.$podzemdata[$podzemroom]["l"].'","99","96","92","47","'.mqfa1("select name from podzem2 where room='$user[room]' order by style").'","'.$vrem.'")');
    else {
      include_once("config/cavedata.php");
      mq("insert into caveparties set user='$esth[id]', leader='$user[id]', login='$esth[login]', shadow='$esth[sex]/$esth[shadow]', x='".$cavedata[$user["room"]+1]["x1"]."', y='".$cavedata[$user["room"]+1]["y1"]."', dir='".$cavedata[$user["room"]+1]["dir1"]."', floor=1");
    }
    mq("UPDATE `users`,`online` SET ".($nc?"users.caveleader='$user[id]',":"")." `users`.`room` = '".($user["room"]+1)."',`online`.`room` = '".($user["room"]+1)."' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '".$esth["id"]."' ;");
  }
  if ($nc) {
    $r=mq("select * from cavemaps where room='" . ($user['room'] * 10) . "'");
    while ($rec=mysql_fetch_assoc($r)) {
      $map=unserialize($rec["map"]);
      foreach ($map as $k=>$v) {
        foreach ($v as $k2=>$v2) {
          $obj=substr($v2, 0, 1);
          if ($obj=="b" || $obj=="a" || $obj=="w") {
            $tmp=explode("/", $v2);
            if ($user["room"]==73 || $user["room"]==90) $i=2;
            else $i=1;
            if ($obj=="b") $t=0;
            elseif ($obj=="w") $t=1;
            else $t=2;
            while ($tmp[$i]) {
              mq("insert into cavebots set leader='$user[id]', x='$k2', y='$k', startx='$k2', starty='$k', bot='$tmp[$i]', cnt='".($tmp[$i+1])."', floor='$rec[floor]', type='$t'");
              $i+=2;
            }
            if ($user["room"]==73) {
              $map[$k][$k2]="s/$tmp[1]";
            } else $map[$k][$k2]=2;
          }
        }
      }
      mq("insert into caves set leader='$user[id]', map='".serialize($map)."', level='$level', floor='$rec[floor]'");
      savecavedata(array(), $user["id"], $rec["floor"]);
    }
  } else {
    mq("update labirint set level='$level' where glav_id='$user[id]'");
    $r=mq("select name from podzem2 where room='$user[room]'");
    while ($rec=mysql_fetch_assoc($r)) {
      $ferrr = mysql_query("SELECT * FROM podzem3 WHERE glava='default' and name='$rec[name]'");
      $retr = mysql_fetch_array($ferrr);
      mysql_query('insert into podzem3(glava,name,n1,n2,n3,n4,n5,n6,n7,n8,n9,n11,n12,n13,n14,n15,n16,n17,n18,n19,n21,n22,n23,n24,n25,n26,n27,n28,n29,n31,n32,n33,n34,n35,n36,n37,n38,n39,n41,n42,n43,n44,n45,n46,n47,n48,n49,n51,n52,n53,n54,n55,n56,n57,n58,n59,n61,n62,n63,n64,n65,n66,n67,n68,n69,n71,n72,n73,n74,n75,n76,n77,n78,n79,n81,n82,n83,n84,n85,n86,n87,n88,n89,n91,n92,n93,n94,n95,n96,n97,n98,n99,sunduk1,sunduk2,sunduk3,sunduk4,sunduk5,sunduk6,sunduk7) values("'.$login.'","'.$rec["name"].'","'.$retr["n1"].'","'.$retr["n2"].'","'.$retr["n3"].'","'.$retr["n4"].'","'.$retr["n5"].'","'.$retr["n6"].'","'.$retr["n7"].'","'.$retr["n8"].'","'.$retr["n9"].'","'.$retr["n11"].'","'.$retr["n12"].'","'.$retr["n13"].'","'.$retr["n14"].'","'.$retr["n15"].'","'.$retr["n16"].'","'.$retr["n17"].'","'.$retr["n18"].'","'.$retr["n19"].'","'.$retr["n21"].'","'.$retr["n22"].'","'.$retr["n23"].'","'.$retr["n24"].'","'.$retr["n25"].'","'.$retr["n26"].'","'.$retr["n27"].'","'.$retr["n28"].'","'.$retr["n29"].'","'.$retr["n31"].'","'.$retr["n32"].'","'.$retr["n33"].'","'.$retr["n34"].'","'.$retr["n35"].'","'.$retr["n36"].'","'.$retr["n37"].'","'.$retr["n38"].'","'.$retr["n39"].'","'.$retr["n41"].'","'.$retr["n42"].'","'.$retr["n43"].'","'.$retr["n44"].'","'.$retr["n45"].'","'.$retr["n46"].'","'.$retr["n47"].'","'.$retr["n48"].'","'.$retr["n49"].'","'.$retr["n51"].'","'.$retr["n52"].'","'.$retr["n53"].'","'.$retr["n54"].'","'.$retr["n55"].'","'.$retr["n56"].'","'.$retr["n57"].'","'.$retr["n58"].'","'.$retr["n59"].'","'.$retr["n61"].'","'.$retr["n62"].'","'.$retr["n63"].'","'.$retr["n64"].'","'.$retr["n65"].'","'.$retr["n66"].'","'.$retr["n67"].'","'.$retr["n68"].'","'.$retr["n69"].'","'.$retr["n71"].'","'.$retr["n72"].'","'.$retr["n73"].'","'.$retr["n74"].'","'.$retr["n75"].'","'.$retr["n76"].'","'.$retr["n77"].'","'.$retr["n78"].'","'.$retr["n79"].'","'.$retr["n81"].'","'.$retr["n82"].'","'.$retr["n83"].'","'.$retr["n84"].'","'.$retr["n85"].'","'.$retr["n86"].'","'.$retr["n87"].'","'.$retr["n88"].'","'.$retr["n89"].'","'.$retr["n91"].'","'.$retr["n92"].'","'.$retr["n93"].'","'.$retr["n94"].'","'.$retr["n95"].'","'.$retr["n96"].'","'.$retr["n97"].'","'.$retr["n98"].'","'.$retr["n99"].'","'.$retr["sunduk1"].'","'.$retr["sunduk2"].'","'.$retr["sunduk3"].'","'.$retr["sunduk4"].'","'.$retr["sunduk5"].'","'.$retr["sunduk6"].'","'.$retr["sunduk7"].'")');

      $ferrr = mysql_query("SELECT * FROM podzem4 WHERE glava='default' and name='$rec[name]'");
      $retr = mysql_fetch_array($ferrr);
      mysql_query('insert into podzem4(glava,name,n1,n2,n3,n4,n5,n6,n7,n8,n9,n11,n12,n13,n14,n15,n16,n17,n18,n19,n21,n22,n23,n24,n25,n26,n27,n28,n29,n31,n32,n33,n34,n35,n36,n37,n38,n39,n41,n42,n43,n44,n45,n46,n47,n48,n49,n51,n52,n53,n54,n55,n56,n57,n58,n59,n61,n62,n63,n64,n65,n66,n67,n68,n69,n71,n72,n73,n74,n75,n76,n77,n78,n79,n81,n82,n83,n84,n85,n86,n87,n88,n89,n91,n92,n93,n94,n95,n96,n97,n98,n99,v1,v2,v3,v4,v5,v6,v7,v8,v9,v11,v12,v13,v14,v15,v16,v17,v18,v19,v21,v22,v23,v24,v25,v26,v27,v28,v29,v31,v32,v33,v34,v35,v36,v37,v38,v39,v41,v42,v43,v44,v45,v46,v47,v48,v49,v51,v52,v53,v54,v55,v56,v57,v58,v59,v61,v62,v63,v64,v65,v66,v67,v68,v69,v71,v72,v73,v74,v75,v76,v77,v78,v79,v81,v82,v83,v84,v85,v86,v87,v88,v89,v91,v92,v93,v94,v95,v96,v97,v98,v99) values("'.$login.'","'.$rec["name"].'","'.$retr["n1"].'","'.$retr["n2"].'","'.$retr["n3"].'","'.$retr["n4"].'","'.$retr["n5"].'","'.$retr["n6"].'","'.$retr["n7"].'","'.$retr["n8"].'","'.$retr["n9"].'","'.$retr["n11"].'","'.$retr["n12"].'","'.$retr["n13"].'","'.$retr["n14"].'","'.$retr["n15"].'","'.$retr["n16"].'","'.$retr["n17"].'","'.$retr["n18"].'","'.$retr["n19"].'","'.$retr["n21"].'","'.$retr["n22"].'","'.$retr["n23"].'","'.$retr["n24"].'","'.$retr["n25"].'","'.$retr["n26"].'","'.$retr["n27"].'","'.$retr["n28"].'","'.$retr["n29"].'","'.$retr["n31"].'","'.$retr["n32"].'","'.$retr["n33"].'","'.$retr["n34"].'","'.$retr["n35"].'","'.$retr["n36"].'","'.$retr["n37"].'","'.$retr["n38"].'","'.$retr["n39"].'","'.$retr["n41"].'","'.$retr["n42"].'","'.$retr["n43"].'","'.$retr["n44"].'","'.$retr["n45"].'","'.$retr["n46"].'","'.$retr["n47"].'","'.$retr["n48"].'","'.$retr["n49"].'","'.$retr["n51"].'","'.$retr["n52"].'","'.$retr["n53"].'","'.$retr["n54"].'","'.$retr["n55"].'","'.$retr["n56"].'","'.$retr["n57"].'","'.$retr["n58"].'","'.$retr["n59"].'","'.$retr["n61"].'","'.$retr["n62"].'","'.$retr["n63"].'","'.$retr["n64"].'","'.$retr["n65"].'","'.$retr["n66"].'","'.$retr["n67"].'","'.$retr["n68"].'","'.$retr["n69"].'","'.$retr["n71"].'","'.$retr["n72"].'","'.$retr["n73"].'","'.$retr["n74"].'","'.$retr["n75"].'","'.$retr["n76"].'","'.$retr["n77"].'","'.$retr["n78"].'","'.$retr["n79"].'","'.$retr["n81"].'","'.$retr["n82"].'","'.$retr["n83"].'","'.$retr["n84"].'","'.$retr["n85"].'","'.$retr["n86"].'","'.$retr["n87"].'","'.$retr["n88"].'","'.$retr["n89"].'","'.$retr["n91"].'","'.$retr["n92"].'","'.$retr["n93"].'","'.$retr["n94"].'","'.$retr["n95"].'","'.$retr["n96"].'","'.$retr["n97"].'","'.$retr["n98"].'","'.$retr["n99"].'","'.$retr["v1"].'","'.$retr["v2"].'","'.$retr["v3"].'","'.$retr["v4"].'","'.$retr["v5"].'","'.$retr["v6"].'","'.$retr["v7"].'","'.$retr["v8"].'","'.$retr["v9"].'","'.$retr["v11"].'","'.$retr["v12"].'","'.$retr["v13"].'","'.$retr["v14"].'","'.$retr["v15"].'","'.$retr["v16"].'","'.$retr["v17"].'","'.$retr["v18"].'","'.$retr["v19"].'","'.$retr["v21"].'","'.$retr["v22"].'","'.$retr["v23"].'","'.$retr["v24"].'","'.$retr["v25"].'","'.$retr["v26"].'","'.$retr["v27"].'","'.$retr["v28"].'","'.$retr["v29"].'","'.$retr["v31"].'","'.$retr["v32"].'","'.$retr["v33"].'","'.$retr["v34"].'","'.$retr["v35"].'","'.$retr["v36"].'","'.$retr["v37"].'","'.$retr["v38"].'","'.$retr["v39"].'","'.$retr["v41"].'","'.$retr["v42"].'","'.$retr["v43"].'","'.$retr["v44"].'","'.$retr["v45"].'","'.$retr["v46"].'","'.$retr["v47"].'","'.$retr["v48"].'","'.$retr["v49"].'","'.$retr["v51"].'","'.$retr["v52"].'","'.$retr["v53"].'","'.$retr["v54"].'","'.$retr["v55"].'","'.$retr["v56"].'","'.$retr["v57"].'","'.$retr["v58"].'","'.$retr["v59"].'","'.$retr["v61"].'","'.$retr["v62"].'","'.$retr["v63"].'","'.$retr["v64"].'","'.$retr["v65"].'","'.$retr["v66"].'","'.$retr["v67"].'","'.$retr["v68"].'","'.$retr["v69"].'","'.$retr["v71"].'","'.$retr["v72"].'","'.$retr["v73"].'","'.$retr["v74"].'","'.$retr["v75"].'","'.$retr["v76"].'","'.$retr["v77"].'","'.$retr["v78"].'","'.$retr["v79"].'","'.$retr["v81"].'","'.$retr["v82"].'","'.$retr["v83"].'","'.$retr["v84"].'","'.$retr["v85"].'","'.$retr["v86"].'","'.$retr["v87"].'","'.$retr["v88"].'","'.$retr["v89"].'","'.$retr["v91"].'","'.$retr["v92"].'","'.$retr["v93"].'","'.$retr["v94"].'","'.$retr["v95"].'","'.$retr["v96"].'","'.$retr["v97"].'","'.$retr["v98"].'","'.$retr["v99"].'")');
    }
  }
?>
<!--<script>top.frames['topp'].location='topp.php?top='+Math.round(Math.random()*100000);</script>-->
<script>top.frames['online'].location='ch.php?online='+Math.round(Math.random()*100000);</script>
<?
mysql_query("DELETE FROM vxod WHERE login='$login'");
mysql_query("DELETE FROM vxodd WHERE glav_id=".$user['id']."");
mysql_query("DELETE FROM vxodd WHERE login='$login'");
print "<script>location.href='".($nc?"cave_test":"canalizaciya").".php'</script>";
exit;
}
}
?>

<TD nowrap valign=top>


<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px; white-space: nowrap;"></div>
<?
  include "config/routes.php";
  foreach ($routes[$user["room"]] as $k=>$v) $links[$rooms[$v]]="city.php?got=1&level$v=1";
  echo moveline($links);
?>
<BR>
<DIV align=right><INPUT onClick="document.location.href='vxod1.php?<? echo time(); ?>'" value=Обновить type=button>
<? if ($user["room"]==51) { ?><INPUT style="font-size:12px;" type='button' onClick="location='zadaniya.php'" value="Задания"><? } ?>
</DIV></TD></TR></TBODY></TABLE>
</TD>
</TR>
</TABLE>
<div id="goto" style="text-align:right;white-space:nowrap">&nbsp;</div>
<?
  if (@$_POST["stroke"]) {
    $_POST["stroke"]=(int)$_POST["stroke"];
    $s=mqfa1("select stones from buystrokes where id='$_POST[stroke]'");
    $tg=mqfa("select sum(koll) as koll from inventory where name='Алхимические камни' and owner='$user[id]'");
    if ($tg["koll"]<500-$s) {
      mq("update buystrokes set stones=stones+$tg[koll] where id='$_POST[stroke]'");
      addqueststep($user["id"], 20, $tg["koll"]);
      mq("delete from inventory where owner='$user[id]' and name='Алхимические камни'");
    } else {
      takesmallitems("Алхимические камни", 500-$s, $user["id"]);
      mq("update buystrokes set stones=500 where id='$_POST[stroke]'");
      //mq("update inventory set koll=koll-".(500-$s).", massa='".(number_format(($tg["koll"]-$s)*0.1,1))."' where id='$tg[id]'");
      addqueststep($user["id"], 20, 500-$s);
    }
  }
  if (@$_POST["changeto"]) {
    $n=mqfa("select name, img from smallitems where id='$_POST[changeto]' and name like '%Эссенция%'");
    if ($n) mq("update inventory set name='$n[name]', img='$n[img]' where name='Камень затаённого солнца' and owner='$user[id]'");
    echo "<b>Обмен выполнен успешно.</b>";
  }
  if ($user["room"]==301) {
    /*$s=mqfa1("select sum(koll) from inventory where owner='$user[id]' and name='Алхимические камни'");
    if ($s) {
      echo "<form action=\"vxod1.php\" method=\"post\">
      Вы можете сдать найденные в пещере камни Алхимику для активации алтаря с целью получить книги о новых приёмах для воинов и магов. Для каждой книги необходимо 500 камней.<br>
      Приём: <select name=\"stroke\">";
      $r=mq("select id, name, stones from buystrokes where stones<500 order by name");
      while ($rec=mysql_fetch_assoc($r)) {
        echo "<option value=\"$rec[id]\">$rec[name] ($rec[stones])</option>";
      }
      echo "</select>
      <input type=submit value=\"Отдать камни\">
      </form>";
    }*/
    $s=mqfa1("select sum(koll) from inventory where owner='$user[id]' and name='Камень затаённого солнца'");
    if ($s) {
      echo "<form action=\"vxod1.php\" method=\"post\">
      Вы можете обменять у алхимика камни затаённого солнца на любую эссенцию.<br>
      Обменять на: <select name=\"changeto\">";
      $r=mq("select id, name from smallitems where name like '%Эссенция%' order by name");
      while ($rec=mysql_fetch_assoc($r)) {
        echo "<option value=\"$rec[id]\">$rec[name]</option>";
      }
      echo "</select>
      <input type=submit value=\"Обменять\">
      </form>";
    }
  }
?><br><br>
</BODY>
</HTML>
<?
} else {
  header("location: main.php");
}
?>
<?php include("mail_ru.php"); ?>

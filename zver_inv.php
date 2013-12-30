<?php
ob_start("ob_gzhandler");
    session_start();
    if (!(@$_SESSION['uid'] > 0)) header("Location: index.php");
    include "connect.php";
    include "functions.php";
    if ($user["battle"]) {
      header('Location: fbattle.php'); die();
    }
?>
<HTML><HEAD>
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<link rel=stylesheet type="text/css" href="i/main.css">

<SCRIPT LANGUAGE="JavaScript" >
var Hint3Name = '';
// Заголовок, название скрипта, имя поля с логином
function findlogin(title, script, name){
    document.all("hint3").innerHTML = '<table border=0 width=100% cellspacing="0" cellpadding="2"><tr><form action="'+script+'" method=POST name=slform><td colspan=2>'+
        text+'</TD></TR><TR><TD width=50% align=left><INPUT TYPE="submit" name="tmpname423" value="Да" style="width:70%"></TD><TD width=50% align=right><INPUT type=button style="width:70%" value="Нет" onclick="closehint3();"></TD></TR></FORM></TABLE>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}


function returned2(s){
    if (top.oldlocation != '') { top.frames['main'].navigate(top.oldlocation+'?'+s+'tmp='+Math.random()); top.oldlocation=''; }
    else { top.frames['main'].navigate('main.php?'+s+'tmp='+Math.random()) }
}

function closehint3(){
    document.all("hint3").style.visibility="hidden";
    Hint3Name='';
}
</script>
</HEAD>
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=e2e0e0>
<?
$zver=mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$user['zver_id']}' LIMIT 1;"));
if($_GET['stat'] and $zver['stats']>0){
if($_GET['stat']=='sila'){$stav = "sila=sila+1";}
if($_GET['stat']=='lovk'){$stav = "lovk=lovk+1";}
if($_GET['stat']=='inta'){$stav = "inta=inta+1";}
if($_GET['stat']=='vinos'){$stav = "vinos=vinos+1,maxhp=maxhp+6,hp=hp+6";}
mysql_query("UPDATE `users` SET $stav,stats=stats-1 WHERE `id` = '".$user['zver_id']."' and `stats`>0");
print "<script>location.href='zver_inv.php'</script>";
exit;
}
///////////////////Навыки////////////////////////
if($zver['vid']==1){$navik = "sila=sila+1"; $vig = 'sila=sila'; $rus_n = 'Демоническая Сила';}     //Чертяка
if($zver['vid']==2){$navik = "lovk=lovk+1"; $vig = 'lovk=lovk'; $rus_n = 'Кошачья Ловкость';} //кошка
if($zver['vid']==3){$navik = "inta=inta+1"; $vig = 'inta=inta'; $rus_n = 'Интуиция Совы';}   //Сова
if($zver['vid']==4){ $rus_n = 'Свинцовый Щит';}   //Свин
if($zver['vid']==5){ $rus_n = 'Верный Друг';}   //Пёс
if($zver['vid']==6){$rus_n = 'Сила Стихий';}   //Светляк
//////////////прогнать зверя/////////////////
if($_GET['vignat']){
if($user['zver_id']!=0){
//mysql_query("UPDATE `users` SET user_id='',zver_id='',$vig-".$zver['level']." WHERE `id` = '".$user['id']."'");
adddelo($user["id"], "$user[login] выгнал своего зверя ".mqfa1("select login from users where id='$user[zver_id]'"), 0);
mq("UPDATE `users` SET user_id='',zver_id='' WHERE `id` = '".$user['id']."'");
mq("DELETE FROM `users` WHERE id='".$zver['id']."'");
print "<script>location.href='zver_inv.php?warning=4'</script>";
exit;
}
}
/////////////////////exp//////////////////////////////
if($zver['exp']>='110' and $zver['level']=='0'){
mysql_query("UPDATE `users` SET `level`=`level`+1,`nextup`='410',`stats`=`stats`+10 WHERE `id` = '".$user['zver_id']."'");
include_once("config/animals.php");
setanimal($user['zver_id'],1);
//mysql_query("UPDATE `users` SET $navik WHERE `id` = '".$user['id']."'");
print "<script>location.href='zver_inv.php'</script>"; exit();
}
if($zver['exp']>='410' and $zver['level']=='1'){
mysql_query("UPDATE `users` SET `level`=`level`+1,`nextup`='1300',`stats`=`stats`+11 WHERE `id` = '".$user['zver_id']."'");
//mysql_query("UPDATE `users` SET $navik WHERE `id` = '".$user['id']."'");
include_once("config/animals.php");
setanimal($user['zver_id'],2);
print "<script>location.href='zver_inv.php'</script>"; exit();
}
if($zver['exp']>='1300' and $zver['level']=='2'){
mysql_query("UPDATE `users` SET `level`=`level`+1,`nextup`='2500',`stats`=`stats`+12 WHERE `id` = '".$user['zver_id']."'");
//mysql_query("UPDATE `users` SET $navik WHERE `id` = '".$user['id']."'");
include_once("config/animals.php");
setanimal($user['zver_id'],3);
print "<script>location.href='zver_inv.php'</script>"; exit();
}
if($zver['exp']>='2500' and $zver['level']=='3'){
mysql_query("UPDATE `users` SET `level`=`level`+1,`nextup`='5000',`stats`=`stats`+13 WHERE `id` = '".$user['zver_id']."'");
//mysql_query("UPDATE `users` SET $navik WHERE `id` = '".$user['id']."'");
include_once("config/animals.php");
setanimal($user['zver_id'],4);
print "<script>location.href='zver_inv.php'</script>"; exit();
}
if($zver['exp']>='5000' and $zver['level']=='4'){
mysql_query("UPDATE `users` SET `level`=`level`+1,`nextup`='12500',`stats`=`stats`+14 WHERE `id` = '".$user['zver_id']."'");
//mysql_query("UPDATE `users` SET $navik WHERE `id` = '".$user['id']."'");
include_once("config/animals.php");
setanimal($user['zver_id'],5);
print "<script>location.href='zver_inv.php'</script>"; exit();
}
if($zver['exp']>='12500' and $zver['level']=='5'){
mysql_query("UPDATE `users` SET `level`=`level`+1,`nextup`='30000',`stats`=`stats`+15 WHERE `id` = '".$user['zver_id']."'");
//mysql_query("UPDATE `users` SET $navik WHERE `id` = '".$user['id']."'");
include_once("config/animals.php");
setanimal($user['zver_id'],6);
print "<script>location.href='zver_inv.php'</script>"; exit();
}
if($zver['exp']>='30000' and $zver['level']=='6'){
mysql_query("UPDATE `users` SET `level`=`level`+1,`nextup`='300000',`stats`=`stats`+15 WHERE `id` = '".$user['zver_id']."'");
//mysql_query("UPDATE `users` SET $navik WHERE `id` = '".$user['id']."'");
include_once("config/animals.php");
setanimal($user['zver_id'],7);
print "<script>location.href='zver_inv.php'</script>"; exit();
}
if($zver['exp']>='300000' and $zver['level']=='7'){
mysql_query("UPDATE `users` SET `level`=`level`+1,`nextup`='3000000',`stats`=`stats`+15 WHERE `id` = '".$user['zver_id']."'");
//mysql_query("UPDATE `users` SET $navik WHERE `id` = '".$user['id']."'");
include_once("config/animals.php");
setanimal($user['zver_id'],8);
print "<script>location.href='zver_inv.php'</script>"; exit();
}
if($zver['exp']>='3000000' and $zver['level']=='8'){
mysql_query("UPDATE `users` SET `level`=`level`+1,`nextup`='10000000',`stats`=`stats`+15 WHERE `id` = '".$user['zver_id']."'");
//mysql_query("UPDATE `users` SET $navik WHERE `id` = '".$user['id']."'");
include_once("config/animals.php");
setanimal($user['zver_id'],9);
print "<script>location.href='zver_inv.php'</script>"; exit();
}
if($zver['exp']>='10000000' and $zver['level']=='9'){
mysql_query("UPDATE `users` SET `level`=`level`+1,`nextup`='520000000',`stats`=`stats`+15 WHERE `id` = '".$user['zver_id']."'");
//mysql_query("UPDATE `users` SET $navik WHERE `id` = '".$user['id']."'");
include_once("config/animals.php");
setanimal($user['zver_id'],10);
print "<script>location.href='zver_inv.php'</script>"; exit();
}
if($zver['exp']>='52000000' and $zver['level']=='10'){
mysql_query("UPDATE `users` SET `level`=`level`+1,`nextup`='100000000',`stats`=`stats`+15 WHERE `id` = '".$user['zver_id']."'");
//mysql_query("UPDATE `users` SET $navik WHERE `id` = '".$user['id']."'");
include_once("config/animals.php");
setanimal($user['zver_id'],11);
print "<script>location.href='zver_inv.php'</script>"; exit();
}
?>
<TABLE width=100% cellspacing=0 cellpadding=0>
<TR>
    <TD valign=top style='padding-left: 10'>
<? if($user['zver_id']!=0){ ?>
    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
    <tr valign="top">
        <td align="center" width=120 style='padding-right:10'><B><? echo "".$zver['login'].""; ?></B> [<? echo "".$zver['level'].""; ?>]</td>
<td rowspan=2>
<BR>
<span style="font-size:11px; color:#003">
<SPAN title="Уровень жизни животного в бою">HP</SPAN>: <? echo "".$zver['maxhp'].""; ?><BR><BR>

<SPAN title="Сила определяет урон наносимый атаками животного в бою">Сила</SPAN>: <? echo "".$zver['sila']."";
if($zver['stats']>0){print"&nbsp;<a href='?stat=sila'><img src='i/plus.gif' height=11 width=11 border=0></a>";}

?>
<BR>
<SPAN title="Ловкость определяет уровень уворота и антиуворота животного в бою">Ловкость</SPAN>: <? echo "".$zver['lovk']."";
if($zver['stats']>0){print"&nbsp;<a href='?stat=lovk'><img src='i/plus.gif' height=11 width=11 border=0></a>";}
?>
<BR>
<SPAN title="Интуиция определяет шанс нанести критический удар или защитится от него">Интуиция</SPAN>: <? echo "".$zver['inta']."";
if($zver['stats']>0){print"&nbsp;<a href='?stat=inta'><img src='i/plus.gif' height=11 width=11 border=0></a>";}
?>
<BR>
<SPAN title="От выносливости зависит уровень жизни животного и защита от урона">Выносливость</SPAN>: <? echo "".$zver['vinos']."";
if($zver['stats']>0){print"&nbsp;<a href='?stat=vinos'><img src='i/plus.gif' height=11 width=11 border=0></a>";}
?>
<BR>
<SPAN style="font-size:9px; color:#00C" title="Свободные статы">Свободные статы: [<font style="color:#F00"><? echo "".$zver['stats'].""; ?></font>]</SPAN>
<BR><BR>
<SPAN title="Уровень животного не может быть выше уровня хозяина">Уровень</SPAN>: <? echo "".$zver['level'].""; ?><BR>
<SPAN title="Животное получает опыт сражаясь за владельца">Опыт</SPAN>: <? echo "".$zver['exp'].""; ?> / <? echo "".$zver['nextup'].""; ?><BR>
<SPAN title="Голодное животное не принимает участия в боях">Сытость</SPAN>: <? echo "".$zver['sitost'].""; ?><BR>
<BR></span>
<NOBR>Освоенные навыки:<BR>
<span style="font-size:11px; color:#003">
<?
  print"$rus_n +";
  if ($zver["vid"]==6 && $zver["level"]>5) {
    echo $zver["level"]*2-5;
  } elseif ($zver["vid"]==5) {
    echo $zver["level"]*6;
  } elseif ($zver["vid"]==4) {
    echo $zver["level"]*2;
  } else echo $zver['level'].""; ?>
 </span>
</NOBR>
<BR>
</td>
</tr>
<tr>
<td>
<IMG src="i\shadow/<? echo "".$zver['shadow'].""; ?>" width=120 height=220>
</td>
</tr>
</TABLE>
<? }else{ ?>
<div id=hint4 class=ahint><?
  if(@$_GET['warning']==4) echo"<font color=red><b>Вы прогнали зверя!</b></font>";
  else echo "<b>У вас нет зверя!</b>";
?></div>
<? } ?>
</td><td width=50% valign=top>
<TABLE width=100% cellspacing=0 cellpadding=0>
<TD>


<? if ($user["zver_id"]) { ?> <INPUT TYPE=button value="Выгнать" style="cursor:hand;" onclick="if (confirm('Вы уверены, что хотите навсегда прогнать <? echo "".$zver['login'].""; ?>?')) window.location='zver_inv.php?vignat=1'"><? } ?>
</TD><TD valign=top align=right>
<INPUT TYPE=button value="Обновить" onClick="javascript:location.href='zver_inv.php'">
<INPUT TYPE=button value="Вернуться" onClick="javascript:location.href='main.php'"></div>
</TABLE>
<?
if($_GET['warning']==1){echo"<font color=red><b>Вы выкинули '".$_GET['n']."'.</b></font>";}
if($_GET['warning']==2){echo"<font color=red><b>".$zver['login']." съел".($zver["sex"]?"":"а")." \"".$_GET['n']."\".</b></font>";}
if($_GET['warning']==3){
  echo"<font color=red><b>".$zver['login']." не хочет есть \"".mqfa1("select name from inventory where id='$_GET[n]'")."\".</b></font>";
}
if($_GET['warning']==5){
  echo"<font color=red><b>".$zver['login']." недостаточно высокого уровня чтобы съесть \"".mqfa1("select name from inventory where id='$_GET[n]'")."\".</b></font>";
}
print"<table width=500 border='0' cellspacing='0' cellpadding='0' align='center' bgcolor='#EBE9ED'>

                <tr>
                        <td width='21' style='background-repeat: repeat-y;'></td>
                        <td>
<table width=665 height=90>
<tr>
</table>";
$items=mysql_query("SELECT * FROM inventory WHERE type='eda' and maxdur<100000 and owner='".$user['id']."'");
$itemsd=mysql_query("SELECT * FROM inventory WHERE type='eda' and maxdur<100000 and owner='".$user['id']."'");
$pic_1 = "#C7C7C7";
$pic_2 = "#D5D5D5";
$pic_type = true;

while($item = mysql_fetch_array($items)){

    if($pic_type){$_pic1 = $pic_1;$pic_type = !$pic_type;}else{$_pic1 = $pic_2;$pic_type = !$pic_type;}
print"
<DIV align=right><!--Рюкзак-->
<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=2 BGCOLOR=A5A5A5>


<TR bgcolor=$_pic1>
<TD align=center>
<IMG SRC='i/sh/".$item['img']."' WIDTH='60' HEIGHT='60' >
<BR><a href='?go=go&id=".$item['id']."'>Скормить</a>
<TD valign=top><font style='color:#009'><b>".$item['name']."</b></font>
(Масса: ".$item['massa'].")

<BR>
<b>Цена: ".$item['cost']." кр.</b> <BR>
Долговечность: ".$item['duration']."/".$item['maxdur']."</FONT><BR>";
if ($item["nlevel"]>0) echo "<B>Требуется минимальное:</B><BR>&bull; Уровень: ".$item['nlevel']."<BR>";
echo "<B>Параметры:</B><BR>&bull; Сытость: +20<BR>

<small>Описание:<BR>".$item['opisan']."</small><BR>
<!--<small>Сделано в Lost city</small><BR>-->
<small><font color=brown>Предмет не подлежит ремонту</font></small><BR>
</TD>
</TR>


</TABLE>
</DIV>";
}
////////////////////////////////////////////////////////////////////////
//////////////////////скармлеваем///////////////////////////////////////
if($_GET['go']=='go'){
/////////////////////проверка существует ли еда для зверя////////////////////////
$items=mysql_fetch_array(mysql_query("SELECT * FROM inventory WHERE id='".$_GET['id']."' and type='eda' and owner='".$user['id']."'"));
if($items){
////////////////////так она есть терь проверяем будет ли есть ее наш зверь!!!////////////////////////
if($zver['vid']==$items['vid'] || $zver['vid']==floor($items['vid']/10) || $zver['vid']==$items['vid']%10 || ($zver["vid"]==4 && $items["vid"]!=1 && $items["vid"]!=6)){
  if ($items["nlevel"]<=$zver['level'] || $items["id"]<1955892) {
    if ($items["nlevel"]<$zver['level']) {
      if ($zver["level"]-$items["nlevel"]==1) $sitost=16;
      elseif ($zver["level"]-$items["nlevel"]==2) $sitost=12;
      elseif ($zver["level"]-$items["nlevel"]==3) $sitost=8;
      elseif ($zver["level"]-$items["nlevel"]==4) $sitost=4;
      else $sitost=1;
    } else $sitost=20;
    if ($items["id"]<1955892) $sitost=20;
    if ($zver["vid"]==4 && $items["vid"]!=4) $sitost=$sitost/2;
    mysql_query("UPDATE users SET sitost=sitost+".$sitost." WHERE id='".$user['zver_id']."'");
    mysql_query("DELETE FROM inventory WHERE id='".$_GET['id']."' and type='eda' and owner='".$user['id']."'");
    header("location: ?warning=2&n=".urlencode($items['name']));
    exit;
  } elseif ($items["nlevel"]>$zver['level']) {
    header("location: ?warning=5&n=$items[id]");
    die;
  } else {
    header("location: ?warning=3&n=$items[id]");
    die;
  }
}else{
header("location: ?warning=3&n=$items[id]");
exit;}
           }else{exit;}
             }
////////////////////////////////////////////////////////////////////////
//////////////////////////удаляем///////////////////////////////////////
if($_GET['del']=='del'){
/////////////////////проверка существует ли еда для зверя////////////////////////
$items=mysql_fetch_array(mysql_query("SELECT name FROM inventory WHERE id='".$_GET['id']."' and type='eda' and owner='".$user['id']."'"));
if($items){
////////////////////так она есть////////////////////////
mysql_query("DELETE FROM inventory WHERE id='".$_GET['id']."' and type='eda' and owner='".$user['id']."'");
header("location: zver_inv.php?warning=1&n=".$items['name']."");
exit;
           }else{exit;}
             }
////////////////////////////////////////////////////////////////////////
if(!$itemd = mysql_fetch_array($itemsd)){
print"<DIV align=right><!--Рюкзак-->
<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=2 BGCOLOR=A5A5A5>
<TR><TD bgcolor=e2e0e0 align=center>У вас нет подходящей еды в рюкзаке</TD></TR>
</TABLE>
</DIV>";
}
print"<td width='21' style='background-repeat: repeat-y;' ></td>

</table>


<div id=hint3 class=ahint></div>
</td>
</TABLE>";
?>
</BODY>
</HTML>

<?php
    session_start();
    if (@$_SESSION['uid'] == null) {
      header("Location: index.php");
      die;
    }
    include "connect.php";
    include "functions.php";
    include "startpodzemel.php";
    if ($_SESSION["uid"]==7) {
      include_once "questfuncs.php";
      //takesmallitem(9);
      /*takesmallitem(1);
      takesmallitem(2);
      takesmallitem(3);
      takesmallitem(4);
      takesmallitem(5);
      takesmallitem(6);
      takesmallitem(7);
      takesmallitem(8);
      takeitem(9);
      takeitem(10);
      takeitem(11);*/
    }
    if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }
$df=mysql_query("select `location`,`name`,`glava` from `labirint` where `user_id`='".$_SESSION['uid']."'");
$fd=mysql_fetch_array($df);
$cd=mysql_query("select `n18` from `podzem3` where `glava`='".$fd['glava']."' and `name`='Канализация 1 этаж'");
$vb=mysql_fetch_array($cd);
if($fd['location'] == '28' and $fd['name']=='Канализация 1 этаж' and $vb['n18']=='8'){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link rel=stylesheet type="text/css" href="i/main.css">
<title>Luka</title>
</head>
<body bgcolor=e5e2d4>
<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
<td align="center" valign="top">


<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
<td width="20%" align="center" valign="top">
<table width="100" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    <TD><? print"".$user['login']."";?>
<?=showpersout($user["id"],0,1);?>
</TD>
    </td>
  </tr>
</table>

</td>
<td align="60%" align="left" valign="top">


<table width="90%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" style="padding-left:20px"><H3 align="center" style="color:#000099">Лука</H3>
<i>
<?
$gag = mysql_query("SELECT * FROM qwest WHERE login='".$user['login']."'");
while($qw = mysql_fetch_array($gag))
{
$name_qwest = $qw["name_items"];
if($name_qwest=="Ключиик"){$qwest="1"; $name_qw = "kluchiik";}
}
$sasd = mysql_query("SELECT * FROM `qwest` WHERE `login`='".$user['login']."' and `name_qwest`='$name_qw'");
$qwus = mysql_fetch_array($sasd);
$qwest_status = $qwus["status"];
$qwes = mysql_query("SELECT * FROM `inventory` WHERE type='200' and name='Ключиик' and owner=".$user["id"]."");
$qwesta = mysql_fetch_array($qwes);
if($qwesta){$ok_qwest = "1";}


if(!$_GET['d']){print"Запах... ОНИ! Мою хороошую, мою чистую канализацию испортилиии...";}
if($_GET['d']=='1'){print"ОН... Он был тут первым... САМЫМ! Гайки, болты, вентили... чинииил... Лука помогал ему... А он... ОН! он ПРЕДАААЛ!! Луку... ЛУКУ ОБИИИИДЕЛ! Он... он теперь не с намиии... ПОМОЙКАаа... Запаааах... Найди.. УБЕЕЙ! И принеси мне ключик... А Лука, Лука даст тебе Гайку силы или Гайку мудрости!!";}
if($_GET['d']=='1.1'){print"Ты НАШООЛ их.? Лука хочет менять! Лука тебе даст жетоны, а ты дашь Луке ИХ! Согла-а-асен?";}

if($qwest_status!='ok'){
if($ok_qwest=='1'){if($_GET['d']=='1.2'){print"Ооо... Лука рад... Лука очень благодарен тебе... Лука даст тебе подарок... Лука даст тебе одно из двух... Лука даст Гайку силы или Гайку мудрости... выберай...";}}

if($ok_qwest=='1')
{
if($_GET['d']=='1.3'){
$sql="INSERT INTO `inventory`(name,duration,maxdur,cost,nlevel,nsila,nlovk,ninta,nvinos,nintel,gsila,glovk,ginta,gintel,ghp,mfkrit,mfakrit,mfuvorot,mfauvorot,img,owner,bron1,bron2,bron3,bron4,type,massa,isrep,otdel,podzem) VALUES ('Гайка силы','0','30','90','4','15','8','10','10','','3','','','','60','50','30','','','g_sila.gif','".$user['id']."','5','5','5','5','2','2','1','41','1')";
$res=mysql_query($sql);
mysql_query("DELETE FROM `inventory` WHERE owner='".$user['id']."' and `type`='200' and `name`='Ключиик'");
mysql_query("UPDATE `qwest` SET `status`='ok' WHERE `name_qwest`='kluchiik' and `login`='".$user['login']."'");
if(!$res){echo mysql_error();}
print"<font style='font-size:11px; color:red;'>Вы получили 'Гайку силы'.</font><br><br>
Лука говорит спасибо...";}
}
if($ok_qwest=='1')
{
if($_GET['d']=='1.4'){
$sql="INSERT INTO `inventory`(name,duration,maxdur,cost,nlevel,nsila,nlovk,ninta,nvinos,nintel,gsila,glovk,ginta,gintel,ghp,mfkrit,mfakrit,mfuvorot,mfauvorot,img,owner,bron1,bron2,bron3,bron4,type,massa,isrep,otdel,podzem) VALUES ('Гайка силы','0','30','90','4','5','4','4','10','15','','','','3','80','','50','50','','g_mudr.gif','".$user['id']."','5','5','5','5','2','2','1','41','1')";
$res=mysql_query($sql);
mysql_query("DELETE FROM `inventory` WHERE owner='".$user['id']."' and `type`='200' and `name`='Ключиик'");
mysql_query("UPDATE `qwest` SET `status`='ok' WHERE `name_qwest`='kluchiik' and `login`='".$user['login']."'");
if(!$res){echo mysql_error();}
print"<font style='font-size:11px; color:red;'>Вы получили 'Гайку мудрости'.</font><br><br>
Лука говарит спасибо...";}
}
                        }


if($_GET['d']=='2'){print"Цена-аа... У Луки много жетонов. Лука не жаадный. Лука берет:<br />
3 Гайки и отдает жетон.<br />
1 Болт и отдает жетон.<br />
1 Вентиль и отдает 3 жетона.<br />
Серебряные, если:<br>
3 Гайки чистые и отдает жетон.<br />
1 Длинный Болт и отдает жетон.<br />
1 Вентиль Рабочий и отдает  3 жетон.<br>
А Золотые, если:<br />
2 Гайки с Резьбой и отдает жетон.<br />
1 Болт Нужный и отдает 2 жетон.<br />
";}
////////b/////////////

if($_GET['d']=='3'){
    include_once "questfuncs.php";
    $sear = mysql_query("SELECT koll,id FROM `inventory` WHERE `type`='200' and `name`='Гайка' and owner='".$user["id"]."'");
        while($alls = mysql_fetch_array($sear))
           {
                $total_mass += $alls['koll'];
                $alls_id = $alls['id'];
           }
    $vear = mysql_query("SELECT koll,id FROM `inventory` WHERE `type`='200' and `name`='Вентиль' and owner='".$user["id"]."'");
        while($vls = mysql_fetch_array($vear))
           {
                $total_mass_v += $vls['koll'];
                $vls_id = $vls['id'];
           }
    $vearb = mysql_query("SELECT koll,id FROM `inventory` WHERE `type`='200' and `name`='Болт' and owner='".$user["id"]."'");
        while($bls = mysql_fetch_array($vearb))
           {
                $total_mass_b += $bls['koll'];
                $bls_id = $bls['id'];
           }
$vear_gr = mysql_query("SELECT koll,id FROM `inventory` WHERE `type`='200' and `name`='Чистая гайка' and owner='".$user["id"]."'");
while($bls_gr = mysql_fetch_array($vear_gr))
           {
                $total_mass_gr += $bls_gr['koll'];
                $gr_id = $bls_gr['id'];
           }
$vear_grez = mysql_query("SELECT koll,id FROM `inventory` WHERE `type`='200' and `name`='Гайка с резьбой' and owner='".$user["id"]."'");
while($bls_grez = mysql_fetch_array($vear_grez))
           {
                $total_mass_grez += $bls_grez['koll'];
                $grez_id = $bls_grez['id'];
           }
$vear_db = mysql_query("SELECT koll,id FROM `inventory` WHERE `type`='200' and `name`='Длинный болт' and owner='".$user["id"]."'");
while($db_db = mysql_fetch_array($vear_db))
           {
                $total_mass_db += $db_db['koll'];
                $db_id = $db_db['id'];
           }
$vear_dbn = mysql_query("SELECT koll,id FROM `inventory` WHERE `type`='200' and `name`='Нужный болт' and owner='".$user["id"]."'");
while($db_dbn = mysql_fetch_array($vear_dbn))
           {
                $total_mass_dbn += $db_dbn['koll'];
                $dbn_id = $db_dbn['id'];
           }
$vear_dbnv = mysql_query("SELECT koll,id FROM `inventory` WHERE `type`='200' and `name`='Рабочий вентиль' and owner='".$user["id"]."'");
while($db_dbnv = mysql_fetch_array($vear_dbnv))
           {
                $total_mass_dbnv += $db_dbnv['koll'];
                $dbnv_id = $db_dbnv['id'];
           }
           if($total_mass<3){$vsego="0"; $ziton="0";}
           if($total_mass>=3){$vsego="3"; $ziton="1";}
           if($total_mass>=6){$vsego="6"; $ziton="2";}
           if($total_mass>=9){$vsego="9"; $ziton="3";}
           if($total_mass>=12){$vsego="12"; $ziton="4";}
           if($total_mass>=15){$vsego="15"; $ziton="5";}
           if($total_mass>=18){$vsego="18"; $ziton="6";}
           if($total_mass>=21){$vsego="21"; $ziton="7";}
           if($total_mass>=24){$vsego="24"; $ziton="8";}
           if($total_mass>=27){$vsego="27"; $ziton="9";}
           if($total_mass>=30){$vsego="30"; $ziton="10";}
           if($total_mass>=33){$vsego="33"; $ziton="11";}
           if($total_mass>=36){$vsego="36"; $ziton="12";}
           if($total_mass>=39){$vsego="39"; $ziton="13";}
           if($total_mass>=42){$vsego="42"; $ziton="14";}
           if($total_mass>=45){$vsego="45"; $ziton="15";}
           if($total_mass>=48){$vsego="48"; $ziton="16";}
           if($total_mass>=51){$vsego="51"; $ziton="17";}
           if($total_mass>=54){$vsego="54"; $ziton="18";}
           if($total_mass>=57){$vsego="57"; $ziton="19";}
           if($total_mass>=60){$vsego="60"; $ziton="20";}
           $ostalos = $total_mass-$vsego;
           takesmallitems("Гайка", $vsego, $user["id"]);
   /*if($ostalos=='0'){mysql_query("DELETE FROM `inventory` WHERE `name`='Гайка' and `x_mis`='0' and owner='".$user["id"]."'");}
           else{
           $ze_m = $ostalos*0.1;
           mysql_query("UPDATE `inventory` SET `koll`='$ostalos',`x_mis`='1',`massa`='$ze_m' WHERE `id`='$alls_id'");
           mysql_query("DELETE FROM `inventory` WHERE `name`='Гайка' and `x_mis`='0' and owner='".$user["id"]."'");
           mysql_query("UPDATE `inventory` SET `x_mis`='0' WHERE `id`='$alls_id'");// x_mis ставим 0
               }*/
           if($total_mass_v<=0){$vsego_v="0"; $ziton_v="0";}
           if($total_mass_v>=1){$vsego_v="1"; $ziton_v="3";}
           if($total_mass_v>=2){$vsego_v="2"; $ziton_v="6";}
           if($total_mass_v>=3){$vsego_v="3"; $ziton_v="9";}
           if($total_mass_v>=4){$vsego_v="4"; $ziton_v="12";}
           if($total_mass_v>=5){$vsego_v="5"; $ziton_v="15";}
           if($total_mass_v>=6){$vsego_v="6"; $ziton_v="18";}
           if($total_mass_v>=7){$vsego_v="7"; $ziton_v="21";}
           if($total_mass_v>=8){$vsego_v="8"; $ziton_v="24";}
           if($total_mass_v>=9){$vsego_v="9"; $ziton_v="27";}
           if($total_mass_v>=10){$vsego_v="10"; $ziton_v="30";}
           if($total_mass_v>=11){$vsego_v="11"; $ziton_v="33";}
           if($total_mass_v>=12){$vsego_v="12"; $ziton_v="36";}
           if($total_mass_v>=13){$vsego_v="13"; $ziton_v="39";}
           if($total_mass_v>=14){$vsego_v="14"; $ziton_v="42";}
           if($total_mass_v>=15){$vsego_v="15"; $ziton_v="45";}
           if($total_mass_v>=16){$vsego_v="16"; $ziton_v="48";}
           if($total_mass_v>=17){$vsego_v="17"; $ziton_v="51";}
           if($total_mass_v>=18){$vsego_v="18"; $ziton_v="54";}
           if($total_mass_v>=19){$vsego_v="19"; $ziton_v="57";}
           if($total_mass_v>=20){$vsego_v="20"; $ziton_v="60";}
           $ostalos_v = $total_mass_v-$vsego_v;
           takesmallitems("Вентиль", $vsego_v, $user["id"]);
    /*if($ostalos_v=='0'){mysql_query("DELETE FROM `inventory` WHERE `name`='Вентиль' and `x_mis`='0' and owner='".$user["id"]."'");}
           else{
           $ze_v = $ostalos_v*0.2;
           mysql_query("UPDATE `inventory` SET `koll`='$ostalos_v',`x_mis`='1',`massa`='$ze_v' WHERE `id`='$vls_id'");
           mysql_query("DELETE FROM `inventory` WHERE `name`='Вентиль' and `x_mis`='0' and owner='".$user["id"]."'");
           mysql_query("UPDATE `inventory` SET `x_mis`='0' WHERE `id`='$vls_id'");// x_mis ставим 0
               }*/
           if($total_mass_b<=0){$vsego_b="0"; $ziton_b="0";}
           if($total_mass_b>=1){$vsego_b="1"; $ziton_b="1";}
           if($total_mass_b>=2){$vsego_b="2"; $ziton_b="2";}
           if($total_mass_b>=3){$vsego_b="3"; $ziton_b="3";}
           if($total_mass_b>=4){$vsego_b="4"; $ziton_b="4";}
           if($total_mass_b>=5){$vsego_b="5"; $ziton_b="5";}
           if($total_mass_b>=6){$vsego_b="6"; $ziton_b="6";}
           if($total_mass_b>=7){$vsego_b="7"; $ziton_b="7";}
           if($total_mass_b>=8){$vsego_b="8"; $ziton_b="8";}
           if($total_mass_b>=9){$vsego_b="9"; $ziton_b="9";}
           if($total_mass_b>=10){$vsego_b="10"; $ziton_b="10";}
           if($total_mass_b>=11){$vsego_b="11"; $ziton_b="11";}
           if($total_mass_b>=12){$vsego_b="12"; $ziton_b="12";}
           if($total_mass_b>=13){$vsego_b="13"; $ziton_b="13";}
           if($total_mass_b>=14){$vsego_b="14"; $ziton_b="14";}
           if($total_mass_b>=15){$vsego_b="15"; $ziton_b="15";}
           if($total_mass_b>=16){$vsego_b="16"; $ziton_b="16";}
           if($total_mass_b>=17){$vsego_b="17"; $ziton_b="17";}
           if($total_mass_b>=18){$vsego_b="18"; $ziton_b="18";}
           if($total_mass_b>=19){$vsego_b="19"; $ziton_b="19";}
           if($total_mass_b>=20){$vsego_b="20"; $ziton_b="20";}
           $ostalos_b = $total_mass_b-$vsego_b;
           takesmallitems("Болт", $vsego_b, $user["id"]);
    /*if($ostalos_b=='0'){mysql_query("DELETE FROM `inventory` WHERE `name`='Болт' and `x_mis`='0' and owner='".$user["id"]."'");}
           else{
           $ze_b = $ostalos_b*0.1;
           mysql_query("UPDATE `inventory` SET `koll`='$ostalos_b',`x_mis`='1',`massa`='$ze_b' WHERE `id`='$bls_id'");
           mysql_query("DELETE FROM `inventory` WHERE `name`='Болт' and `x_mis`='0' and owner='".$user["id"]."'");
           mysql_query("UPDATE `inventory` SET `x_mis`='0' WHERE `id`='$bls_id'");// x_mis ставим 0
               }*/
           if($total_mass_gr<3){$vsego_gr="0"; $ziton_gr="0";}
           if($total_mass_gr>=3){$vsego_gr="3"; $ziton_gr="1";}
           if($total_mass_gr>=6){$vsego_gr="6"; $ziton_gr="2";}
           if($total_mass_gr>=9){$vsego_gr="9"; $ziton_gr="3";}
           if($total_mass_gr>=12){$vsego_gr="12"; $ziton_gr="4";}
           if($total_mass_gr>=15){$vsego_gr="15"; $ziton_gr="5";}
           if($total_mass_gr>=18){$vsego_gr="18"; $ziton_gr="6";}
           if($total_mass_gr>=21){$vsego_gr="21"; $ziton_gr="7";}
           if($total_mass_gr>=24){$vsego_gr="24"; $ziton_gr="8";}
           if($total_mass_gr>=27){$vsego_gr="27"; $ziton_gr="9";}
           if($total_mass_gr>=30){$vsego_gr="30"; $ziton_gr="10";}
          if($total_mass_gr>=33){$vsego_gr="33"; $ziton_gr="11";}
           if($total_mass_gr>=36){$vsego_gr="36"; $ziton_gr="12";}
           if($total_mass_gr>=39){$vsego_gr="39"; $ziton_gr="13";}
           if($total_mass_gr>=42){$vsego_gr="42"; $ziton_gr="14";}
           if($total_mass_gr>=45){$vsego_gr="45"; $ziton_gr="15";}
           if($total_mass_gr>=48){$vsego_gr="48"; $ziton_gr="16";}
           if($total_mass_gr>=51){$vsego_gr="51"; $ziton_gr="17";}
           if($total_mass_gr>=54){$vsego_gr="54"; $ziton_gr="18";}
           if($total_mass_gr>=57){$vsego_gr="57"; $ziton_gr="19";}
           if($total_mass_gr>=60){$vsego_gr="60"; $ziton_gr="20";}
$ostalos_gr = $total_mass_gr-$vsego_gr;
           takesmallitems("Чистая гайка", $vsego_gr, $user["id"]);
/*if($ostalos_gr=='0'){mysql_query("DELETE FROM `inventory` WHERE `name`='Чистая гайка' and `x_mis`='0' and owner='".$user["id"]."'");}else{
$ze_gr = $ostalos_gr*0.1;
mysql_query("UPDATE `inventory` SET `koll`='$ostalos_gr',`x_mis`='1',`massa`='$ze_gr' WHERE `id`='$gr_id'");
mysql_query("DELETE FROM `inventory` WHERE `name`='Чистая гайка' and `x_mis`='0' and owner='".$user["id"]."'");
mysql_query("UPDATE `inventory` SET `x_mis`='0' WHERE `id`='$gr_id'");// x_mis ставим 0
               }*/

           if($total_mass_grez<2){$vsego_grez="0"; $ziton_grez="0";}
           if($total_mass_grez>=2){$vsego_grez="2"; $ziton_grez="1";}
           if($total_mass_grez>=4){$vsego_grez="4"; $ziton_grez="2";}
           if($total_mass_grez>=6){$vsego_grez="6"; $ziton_grez="3";}
           if($total_mass_grez>=8){$vsego_grez="8"; $ziton_grez="4";}
           if($total_mass_grez>=10){$vsego_grez="10"; $ziton_grez="5";}
           if($total_mass_grez>=12){$vsego_grez="12"; $ziton_grez="6";}
           if($total_mass_grez>=14){$vsego_grez="14"; $ziton_grez="7";}
           if($total_mass_grez>=16){$vsego_grez="16"; $ziton_grez="8";}
           if($total_mass_grez>=18){$vsego_grez="18"; $ziton_grez="9";}
           if($total_mass_grez>=20){$vsego_grez="20"; $ziton_grez="10";}
           if($total_mass_grez>=22){$vsego_grez="22"; $ziton_grez="11";}
           if($total_mass_grez>=24){$vsego_grez="24"; $ziton_grez="12";}
           if($total_mass_grez>=26){$vsego_grez="26"; $ziton_grez="13";}
           if($total_mass_grez>=28){$vsego_grez="28"; $ziton_grez="14";}
           if($total_mass_grez>=30){$vsego_grez="30"; $ziton_grez="15";}
           if($total_mass_grez>=32){$vsego_grez="32"; $ziton_grez="16";}
           if($total_mass_grez>=34){$vsego_grez="34"; $ziton_grez="17";}
           if($total_mass_grez>=36){$vsego_grez="36"; $ziton_grez="18";}
           if($total_mass_grez>=38){$vsego_grez="38"; $ziton_grez="19";}
           if($total_mass_grez>=40){$vsego_grez="40"; $ziton_grez="20";}

$ostalos_grez = $total_mass_grez-$vsego_grez;
           takesmallitems("Гайка с резьбой", $vsego_grez, $user["id"]);
/*if($ostalos_grez=='0'){mysql_query("DELETE FROM `inventory` WHERE `name`='Гайка с резьбой' and `x_mis`='0' and owner='".$user["id"]."'");}else{
$ze_grez = $ostalos_grez*0.1;
mysql_query("UPDATE `inventory` SET `koll`='$ostalos_grez',`x_mis`='1',`massa`='$ze_grez' WHERE `id`='$grez_id'");
mysql_query("DELETE FROM `inventory` WHERE `name`='Гайка с резьбой' and `x_mis`='0' and owner='".$user["id"]."'");
mysql_query("UPDATE `inventory` SET `x_mis`='0' WHERE `id`='$grez_id'");// x_mis ставим 0
               }*/
if($total_mass_db<=0){$vsego_db="0"; $ziton_db="0";}
           if($total_mass_db>=1){$vsego_db="1"; $ziton_db="1";}
           if($total_mass_db>=2){$vsego_db="2"; $ziton_db="2";}
           if($total_mass_db>=3){$vsego_db="3"; $ziton_db="3";}
           if($total_mass_db>=4){$vsego_db="4"; $ziton_db="4";}
           if($total_mass_db>=5){$vsego_db="5"; $ziton_db="5";}
           if($total_mass_db>=6){$vsego_db="6"; $ziton_db="6";}
           if($total_mass_db>=7){$vsego_db="7"; $ziton_db="7";}
           if($total_mass_db>=8){$vsego_db="8"; $ziton_db="8";}
           if($total_mass_db>=9){$vsego_db="9"; $ziton_db="9";}
           if($total_mass_db>=10){$vsego_db="10"; $ziton_db="10";}
           if($total_mass_db>=11){$vsego_db="11"; $ziton_db="11";}
           if($total_mass_db>=12){$vsego_db="12"; $ziton_db="12";}
           if($total_mass_db>=13){$vsego_db="13"; $ziton_db="13";}
           if($total_mass_db>=14){$vsego_db="14"; $ziton_db="14";}
           if($total_mass_db>=15){$vsego_db="15"; $ziton_db="15";}
           if($total_mass_db>=16){$vsego_db="16"; $ziton_db="16";}
           if($total_mass_db>=17){$vsego_db="17"; $ziton_db="17";}
           if($total_mass_db>=18){$vsego_db="18"; $ziton_db="18";}
           if($total_mass_db>=19){$vsego_db="19"; $ziton_db="19";}
           if($total_mass_db>=20){$vsego_db="20"; $ziton_db="20";}
           $ostalos_db = $total_mass_db-$vsego_db;
           takesmallitems("Длинный болт", $vsego_db, $user["id"]);
    /*if($ostalos_db=='0'){mysql_query("DELETE FROM `inventory` WHERE `name`='Длинный болт' and `x_mis`='0' and owner='".$user["id"]."'");}
           else{
           $ze_db = $ostalos_db*0.2;
           mysql_query("UPDATE `inventory` SET `koll`='$ostalos_db',`x_mis`='1',`massa`='$ze_db' WHERE `id`='$db_id'");
           mysql_query("DELETE FROM `inventory` WHERE `name`='Длинный болт' and `x_mis`='0' and owner='".$user["id"]."'");
           mysql_query("UPDATE `inventory` SET `x_mis`='0' WHERE `id`='$db_id'");// x_mis ставим 0
               }*/
if($total_mass_dbn<=0){$vsego_dbn="0"; $ziton_dbn="0";}
           if($total_mass_dbn>=1){$vsego_dbn="1"; $ziton_dbn="2";}
           if($total_mass_dbn>=2){$vsego_dbn="2"; $ziton_dbn="4";}
           if($total_mass_dbn>=3){$vsego_dbn="3"; $ziton_dbn="6";}
           if($total_mass_dbn>=4){$vsego_dbn="4"; $ziton_dbn="8";}
           if($total_mass_dbn>=5){$vsego_dbn="5"; $ziton_dbn="10";}
           if($total_mass_dbn>=6){$vsego_dbn="6"; $ziton_dbn="12";}
           if($total_mass_dbn>=7){$vsego_dbn="7"; $ziton_dbn="14";}
           if($total_mass_dbn>=8){$vsego_dbn="8"; $ziton_dbn="16";}
           if($total_mass_dbn>=9){$vsego_dbn="9"; $ziton_dbn="18";}
           if($total_mass_dbn>=10){$vsego_dbn="10"; $ziton_dbn="20";}
           if($total_mass_dbn>=11){$vsego_dbn="11"; $ziton_dbn="22";}
           if($total_mass_dbn>=12){$vsego_dbn="12"; $ziton_dbn="24";}
           if($total_mass_dbn>=13){$vsego_dbn="13"; $ziton_dbn="26";}
           if($total_mass_dbn>=14){$vsego_dbn="14"; $ziton_dbn="28";}
           if($total_mass_dbn>=15){$vsego_dbn="15"; $ziton_dbn="30";}
           if($total_mass_dbn>=16){$vsego_dbn="16"; $ziton_dbn="32";}
           if($total_mass_dbn>=17){$vsego_dbn="17"; $ziton_dbn="34";}
           if($total_mass_dbn>=18){$vsego_dbn="18"; $ziton_dbn="36";}
           if($total_mass_dbn>=19){$vsego_dbn="19"; $ziton_dbn="38";}
           if($total_mass_dbn>=20){$vsego_dbn="20"; $ziton_dbn="40";}
           $ostalos_dbn = $total_mass_dbn-$vsego_dbn;
           takesmallitems("Нужный болт", $vsego_dbn, $user["id"]);
    /*if($ostalos_dbn=='0'){mysql_query("DELETE FROM `inventory` WHERE `name`='Нужный болт' and `x_mis`='0' and owner='".$user["id"]."'");}
           else{
           $ze_dbn = $ostalos_dbn*0.2;
           mysql_query("UPDATE `inventory` SET `koll`='$ostalos_dbn',`x_mis`='1',`massa`='$ze_dbn' WHERE `id`='$dbn_id'");
           mysql_query("DELETE FROM `inventory` WHERE `name`='Нужный болт' and `x_mis`='0' and owner='".$user["id"]."'");
           mysql_query("UPDATE `inventory` SET `x_mis`='0' WHERE `id`='$dbn_id'");// x_mis ставим 0
               }*/

if($total_mass_dbnv<=0){$vsego_dbnv="0"; $ziton_dbnv="0";}
           if($total_mass_dbnv>=1){$vsego_dbnv="1"; $ziton_dbnv="3";}
           if($total_mass_dbnv>=2){$vsego_dbnv="2"; $ziton_dbnv="6";}
           if($total_mass_dbnv>=3){$vsego_dbnv="3"; $ziton_dbnv="9";}
           if($total_mass_dbnv>=4){$vsego_dbnv="4"; $ziton_dbnv="12";}
           if($total_mass_dbnv>=5){$vsego_dbnv="5"; $ziton_dbnv="15";}
           if($total_mass_dbnv>=6){$vsego_dbnv="6"; $ziton_dbnv="18";}
           if($total_mass_dbnv>=7){$vsego_dbnv="7"; $ziton_dbnv="21";}
           if($total_mass_dbnv>=8){$vsego_dbnv="8"; $ziton_dbnv="24";}
           if($total_mass_dbnv>=9){$vsego_dbnv="9"; $ziton_dbnv="27";}
           if($total_mass_dbnv>=10){$vsego_dbnv="10"; $ziton_dbnv="30";}
           if($total_mass_dbnv>=11){$vsego_dbnv="11"; $ziton_dbnv="33";}
           if($total_mass_dbnv>=12){$vsego_dbnv="12"; $ziton_dbnv="36";}
           if($total_mass_dbnv>=13){$vsego_dbnv="13"; $ziton_dbnv="39";}
           if($total_mass_dbnv>=14){$vsego_dbnv="14"; $ziton_dbnv="42";}
           if($total_mass_dbnv>=15){$vsego_dbnv="15"; $ziton_dbnv="45";}
           if($total_mass_dbnv>=16){$vsego_dbnv="16"; $ziton_dbnv="48";}
           if($total_mass_dbnv>=17){$vsego_dbnv="17"; $ziton_dbnv="51";}
           if($total_mass_dbnv>=18){$vsego_dbnv="18"; $ziton_dbnv="54";}
           if($total_mass_dbnv>=19){$vsego_dbnv="19"; $ziton_dbnv="57";}
           if($total_mass_dbnv>=20){$vsego_dbnv="20"; $ziton_dbnv="60";}
           $ostalos_dbnv = $total_mass_dbnv-$vsego_dbnv;
           takesmallitems("Рабочий вентиль", $vsego_dbnv, $user["id"]);
    /*if($ostalos_dbnv=='0'){mysql_query("DELETE FROM `inventory` WHERE `name`='Рабочий вентиль' and `x_mis`='0' and owner='".$user["id"]."'");}
           else{
           $ze_dbnv = $ostalos_dbnv*0.2;
           mysql_query("UPDATE `inventory` SET `koll`='$ostalos_dbnv',`x_mis`='1',`massa`='$ze_dbnv' WHERE `id`='$dbnv_id'");
           mysql_query("DELETE FROM `inventory` WHERE `name`='Рабочий вентиль' and `x_mis`='0' and owner='".$user["id"]."'");
           mysql_query("UPDATE `inventory` SET `x_mis`='0' WHERE `id`='$dbnv_id'");// x_mis ставим 0
               }*/

if($ziton_dbnv!='0'){//1
takesmallitem(48, 0, "Обмен у Луки", $ziton_dbnv);
/*$g_dbnv = mysql_fetch_array(mysql_query("SELECT id, `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Серебряный Жетон'"));
$koll_dbnv = $g_dbnv["koll"];
$mas_dbnv = $ziton_dbnv*0.1;
if($koll_dbnv>'0'){
mysql_query("UPDATE `inventory` SET koll=koll+$ziton_dbnv,massa=massa+$mas_dbnv WHERE owner='".$user['id']."' and `type`='200' and `name`='Серебряный Жетон'");
}else{
$mas_dbnv = $ziton_dbnv*0.1;

$fo = mysql_query("INSERT INTO `inventory`(name,duration,maxdur,koll,img,owner,type,isrep,podzem,massa) VALUES('Серебряный Жетон','0','1','$ziton_dbnv','silverzeton.gif','".$user['id']."','200','0','1','$mas_dbnv')");
}*/
}//1

if($ziton_dbn!='0'){//1
takesmallitem(49, 0, "Обмен у Луки", $ziton_dbn);
/*$g_dbn = mysql_fetch_array(mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Золотой Жетон'"));
$koll_dbn = $g_dbn["koll"];
$mas_dbn = $ziton_dbn*0.1;
if($koll_dbn>'0'){
mysql_query("UPDATE `inventory` SET koll=koll+$ziton_dbn,massa=massa+$mas_dbn WHERE owner='".$user['id']."' and `type`='200' and `name`='Золотой Жетон'");
}else{
$mas_dbn = $ziton_dbn*0.1;

$fo = mysql_query("INSERT INTO `inventory`(name,duration,maxdur,koll,img,owner,type,isrep,podzem,massa) VALUES('Золотой Жетон','0','1','$ziton_dbn','ziton_z.gif','".$user['id']."','200','0','1','$mas_dbn')");
}*/
}//1

if($ziton_db!='0'){//1
takesmallitem(48, 0, "Обмен у Луки", $ziton_db);
/*$g_db = mysql_fetch_array(mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Серебряный Жетон'"));
$koll_db = $g_db["koll"];
$mas_db = $ziton_db*0.1;
if($koll_db>'0'){
mysql_query("UPDATE `inventory` SET koll=koll+$ziton_db,massa=massa+$mas_db WHERE owner='".$user['id']."' and `type`='200' and `name`='Серебряный Жетон'");
}else{
$mas_db = $ziton_db*0.1;

$fo = mysql_query("INSERT INTO `inventory`(name,duration,maxdur,koll,img,owner,type,isrep,podzem,massa) VALUES('Серебряный Жетон','0','1','$ziton_db','silverzeton.gif','".$user['id']."','200','0','1','$mas_db')");
}*/
}//1

if($ziton_grez!='0'){//1
takesmallitem(49, 0, "Обмен у Луки", $ziton_grez);
/*
$g_grez = mysql_fetch_array(mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Золотой Жетон'"));
$koll_grez = $g_grez["koll"];
$mas_grez = $ziton_grez*0.1;
if($koll_grez>'0'){
mysql_query("UPDATE `inventory` SET koll=koll+$ziton_grez,massa=massa+$mas_grez WHERE owner='".$user['id']."' and `type`='200' and `name`='Золотой Жетон'");
}else{
$mas_grez = $ziton_grez*0.1;

$fo = mysql_query("INSERT INTO `inventory`(name,duration,maxdur,koll,img,owner,type,isrep,podzem,massa) VALUES('Золотой Жетон','0','1','$ziton_grez','ziton_z.gif','".$user['id']."','200','0','1','$mas_grez')");
}*/
}//1

if($ziton_gr!='0'){//1
takesmallitem(48, 0, "Обмен у Луки", $ziton_gr);
/*$g_gr = mysql_fetch_array(mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Серебряный Жетон'"));
$koll_gr = $g_gr["koll"];
$mas_gr = $ziton_gr*0.1;
if($koll_gr>'0'){
mysql_query("UPDATE `inventory` SET koll=koll+$ziton_gr,massa=massa+$mas_gr WHERE owner='".$user['id']."' and `type`='200' and `name`='Серебряный Жетон'");
}else{
$mas_gr = $ziton_gr*0.1;

$fo = mysql_query("INSERT INTO `inventory`(name,duration,maxdur,koll,img,owner,type,isrep,podzem,massa) VALUES('Серебряный Жетон','0','1','$ziton_gr','silverzeton.gif','".$user['id']."','200','0','1','$mas_gr')");
}*/
}//1

if($ziton!='0'){//1
takesmallitem(47, 0, "Обмен у Луки", $ziton);
/*$g = mysql_fetch_array(mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Жетон'"));
$koll = $g["koll"];
$mas = $ziton*0.1;
if($koll>'0'){
mysql_query("UPDATE `inventory` SET koll=koll+$ziton,massa=massa+$mas WHERE owner='".$user['id']."' and `type`='200' and `name`='Жетон'");
}else{
$mas = $ziton*0.1;

$fo = mysql_query("INSERT INTO `inventory`(name,duration,maxdur,koll,img,owner,type,isrep,podzem,massa) VALUES('Жетон','0','1','$ziton','ziton.gif','".$user['id']."','200','0','1','$mas')");
}*/
}//1

if($ziton_v!='0'){//1
takesmallitem(47, 0, "Обмен у Луки", $ziton_v);
/*$gv = mysql_fetch_array(mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Жетон'"));
$kollv = $gv["koll"];
$mas = $ziton_v*0.1;
if($kollv>'0'){
mysql_query("UPDATE `inventory` SET koll=koll+$ziton_v,massa=massa+$mas WHERE owner='".$user['id']."' and `type`='200' and `name`='Жетон'");
}else{
$mas = $ziton_v*0.1;
$fov = mysql_query("INSERT INTO `inventory`(name,duration,maxdur,koll,img,owner,type,isrep,podzem,massa) VALUES('Жетон','0','1','$ziton_v','ziton.gif','".$user['id']."','200','0','1','$mas')");
}*/
}//1

if($ziton_b!='0'){//1
takesmallitem(47, 0, "Обмен у Луки", $ziton_b);
/*$gb = mysql_fetch_array(mysql_query("SELECT `koll` FROM `inventory` WHERE `owner`='".$user['id']."' and `type`='200' and `name`='Жетон'"));
$kollb = $gb["koll"];
$mas = $ziton_b*0.1;
if($kollb>'0'){
mysql_query("UPDATE `inventory` SET koll=koll+$ziton_b,massa=massa+$mas WHERE owner='".$user['id']."' and `type`='200' and `name`='Жетон'");
}else{
$mas = $ziton_b*0.1;
$fob = mysql_query("INSERT INTO `inventory`(name,duration,maxdur,koll,img,owner,type,isrep,podzem,massa) VALUES('Жетон','0','1','$ziton_b','ziton.gif','".$user['id']."','200','0','1','$mas')");
}*/
}//1

    if($ziton<=0 and $ziton_v<=0 and $ziton_b<=0){print" ИХ больше у тебя нету... Неси еще, Луке нужно больше ИХ! ";}
    if($ziton>0){print"<br />Вы отдали: <b>$vsego</b> шт. Гаек <br> Получили: <b>$ziton</b> шт. Жетонов.";}
    if($ziton_v>0){print"<br />Вы отдали: <b>$vsego_v</b> шт. Вентиль <br> Получили: <b>$ziton_v</b> шт. Жетонов.";}
    if($ziton_b>0){print"<br />Вы отдали: <b>$vsego_b</b> шт. Болтов <br> Получили: <b>$ziton_b</b> шт. Жетонов.";}
    if($ziton_gr>0){print"<br />Вы отдали: <b>$vsego_gr</b> шт. Чистых гаек <br> Получили: <b>$ziton_gr</b> шт. Серебряных Жетонов.";}
if($ziton_grez>0){print"<br />Вы отдали: <b>$vsego_grez</b> шт. Гаек с резьбой <br> Получили: <b>$ziton_grez</b> шт. Золотых Жетонов.";}
if($ziton_db>0){print"<br />Вы отдали: <b>$vsego_db</b> шт. Длинный болт <br> Получили: <b>$ziton_db</b> шт. Серебряных Жетонов.";}
if($ziton_dbn>0){print"<br />Вы отдали: <b>$vsego_dbn</b> шт. Нужный болт <br> Получили: <b>$ziton_dbn</b> шт. Золотых Жетонов.";}
if($ziton_dbnv>0){print"<br />Вы отдали: <b>$vsego_dbnv</b> шт. Рабочий вентиль <br> Получили: <b>$ziton_dbnv</b> шт. Серебряных Жетонов.";}
    }
//////////////////////
if($_GET['d']=='4'){print"А?...";}
if($_GET['d']=='5'){print"Лука и Мартын тут живут давно... чииинят трубыы. Лука Чинит. Лука не любит пауков... Лука любит жетоны... Они красивые... Лука любит играть с ними... Мартыын к паукам ушел... Теперь Лука один, чииинит...";}
if($qwest!='1'){
if($_GET['d']=='6'){print"Да да! Мартын гаад... он украл у Луки важную вещь 'Ключиик'... убей Мартына... забери 'Ключиик'... принеси его к Луке... Лука вознаградит тебя...";}
if($_GET['d']=='7'){
if($qwest!='1'){
$T1 = mysql_query("INSERT INTO qwest (user_id,login,name_qwest,name_items,id_items,dlja,zadanie,kw,status) VALUES('".$user['id']."','".$user['login']."','kluchiik','Ключиик','','Лука','Найти ключиик','0','no')");
print"<font style='font-size:11px; color:red;'>Вы приняли задание.(Найти 'ключиик').</font><br><br>
Хорошо... Лука будет ждать...";
}else{print"<font style='font-size:11px; color:red;'>Вы уже приняли задание.(Найти 'ключиик').</font><br><br>
Ну что? Лука ждёт...";}}
                }
?>
</i>


<BR><BR>

<?

//Вопросы)

if(!isset($_GET['d'])){print"&bull;<A href='?act=luka&d=1'> Запах?? Ты вообще о чем? </A><BR>";}
if(!isset($_GET['d'])){print"&bull;<A href='?act=luka&d=1.1'> Я тут гайки-вентили нашел, тебе они случайно не нужны? </A><BR>";}
if($qwest_status!='ok'){if($ok_qwest=='1'){if(!isset($_GET['d'])){print"&bull;<A href='?act=luka&d=1.2'> Вот твой ключиик! </A><BR>";}}}
if(!isset($_GET['d'])){print"&bull;<A href='main.php?act=none'> Я, пожалуй, пойду.</A><BR>";}

if($_GET['d']=='1'){print"&bull;<A href='?act=luka'> Понятно. Но я хотел поговорить о другом. </A><BR>";}
if($_GET['d']=='1'){print"&bull;<A href='main.php?act=none'> Я, пожалуй, пойду.</A><BR>";}

if($_GET['d']=='1.1'){print"&bull;<A href='?act=luka&d=2'> Я хочу знать, сколько жетонов ты мне дашь. </A><BR>";}
if($_GET['d']=='1.1'){print"&bull;<A href='?act=luka&d=3'> Я хочу поменять ИХ на жетоны. </A><BR>";}
if($_GET['d']=='1.1'){print"&bull;<A href='?act=luka'> С гайками все ясно. Вернемся назад. </A><BR>";}
if($_GET['d']=='1.1'){print"&bull;<A href='main.php?act=none'> Я, пожалуй, пойду.</A><BR>";}

if($ok_qwest=='1'){if($_GET['d']=='1.2'){print"&bull;<A href='?act=luka&d=1.3'> Выбираю Гайку силы.</A><BR>";}}
if($ok_qwest=='1'){if($_GET['d']=='1.2'){print"&bull;<A href='?act=luka&d=1.4'> Выбираю Гайку мудрости.</A><BR>";}}
if($ok_qwest=='1'){if($_GET['d']=='1.2'){print"&bull;<A href='main.php?act=none'> Я, пожалуй, пойду..</A><BR>";}}
if($_GET['d']=='1.3'){print"&bull;<A href='main.php?act=none'> Я, пожалуй, пойду.</A><BR>";}
if($_GET['d']=='1.4'){print"&bull;<A href='main.php?act=none'> Я, пожалуй, пойду.</A><BR>";}

if($_GET['d']=='2'){print"&bull;<A href='?act=luka&d=3'> Я хочу поменять ИХ на жетоны. </A><BR>";}
if($_GET['d']=='2'){print"&bull;<A href='?act=luka'> Спасибо, за прайс-лист. </A><BR>";}
if($_GET['d']=='2'){print"&bull;<A href='main.php?act=none'> Я, пожалуй, пойду.</A><BR>";}



if($_GET['d']=='3'){print"&bull;<A href='?act=luka&d=4'> Я хотел еще спросить... </A><BR>";}
if($_GET['d']=='3'){print"&bull;<A href='main.php?act=none'> Хорошо, пойду еще принесу.</A><BR>";}

if($_GET['d']=='4'){print"&bull;<A href='?act=luka&d=1.1'> Что ты там говорил про гайки-вентили? </A><BR>";}
if($_GET['d']=='4'){print"&bull;<A href='?act=luka&d=5'> Расскажи мне о себе. </A><BR>";}
if($_GET['d']=='4'){print"&bull;<A href='main.php?act=none'> Я, пожалуй, пойду.</A><BR>";}

if($_GET['d']=='5'){print"&bull;<A href='?act=luka&d=1.1'> Что ты там говорил про гайки-вентили? </A><BR>";}
if($qwest!='1'){if($_GET['d']=='5'){print"&bull;<A href='?act=luka&d=6'> Может помочь чем? </A><BR>";}}
if($_GET['d']=='5'){print"&bull;<A href='main.php?act=none'> Я, пожалуй, пойду.</A><BR>";}

if($_GET['d']=='6'){print"&bull;<A href='?act=luka&d=7'> Я помогу тебе... принесу я ключиик... жди! </A><BR>";}
if($_GET['d']=='6'){print"&bull;<A href='main.php?act=none'> Да ну тя сам разберайся.</A><BR>";}

if($_GET['d']=='7'){print"&bull;<A href='main.php?act=none'> Я, пойду.(конец диалога).</A><BR>";}



print"</i><BR><BR>";


?></td>
  </tr>
</table>


</td>
<td width="20%" align="center" valign="top">

<?
$bot="Лука";
$buser = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '$bot' LIMIT 1;"));
?>
    <table width="100" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td >
    <TD><? print"$bot"; ?>
<TABLE border=0 cellSpacing=0 cellPadding=0 width="100%">
<TBODY>
<TR vAlign=top>
<TD>
<TABLE border=0 cellSpacing=0 cellPadding=0 width="100%">
<TBODY>

<TR><TD style="BACKGROUND-IMAGE:none">
<?php if ($buser['helm'] > 0) {
$dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$buser['helm']}' LIMIT 1;"));
if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
showhrefmagic($dress);
} else {
print "<img src=\"i/sh/".$dress['img']."\" width=60 height=60 onMouseMove=\"TipShow('<b>".$dress['name']."<br>Прочность: ".$dress['duration']."/".$dress['maxdur'].""; if($dress['ghp']>0){print"<br>Уровень жизни: + ".$dress['ghp']."";} if($dress['text']!=null){print"<br>На шлеме выгравировано: <br><font color=#FFFF00>".$dress['text']."</font>";} print"</b>', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}}else{
print "<img src=\"i/w9.gif\" width=60 height=60 onMouseMove=\"TipShow('<b>Пустой слот шлем</b>\', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}?>


<TR><TD style="BACKGROUND-IMAGE:none">
<?php if ($buser['naruchi'] > 0) {
$dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$buser['naruchi']}' LIMIT 1;"));
if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
showhrefmagic($dress);
} else {
print "<img src=\"i/sh/".$dress['img']."\" width=60 height=40 onMouseMove=\"TipShow('<b>".$dress['name']."<br>Прочность: ".$dress['duration']."/".$dress['maxdur'].""; if($dress['ghp']>0){print"<br>Уровень жизни: + ".$dress['ghp']."";} if($dress['text']!=null){print"<br>На наручах выгравировано: <br><font color=#FFFF00>".$dress['text']."</font>";} print"</b>', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}}else{
print "<img src=\"i/w18.gif\" width=60 height=40 onMouseMove=\"TipShow('<b>Пустой слот наручи</b>\', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}?>

<TR><TD style="BACKGROUND-IMAGE: none">
<?php if ($buser['weap'] > 0) {
$dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$buser['weap']}' LIMIT 1;"));
if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
showhrefmagic($dress);
} else {
print "<img src=\"i/sh/".$dress['img']."\" width=60 height=60 onMouseMove=\"TipShow('<b>".$dress['name']."<br>Прочность: ".$dress['duration']."/".$dress['maxdur'].""; if($dress['ghp']>0){print"<br>Уровень жизни: + ".$dress['ghp']."";} if($dress['text']!=null){print"<br>На оружии выгравировано: <br><font color=#FFFF00>".$dress['text']."</font>";} print"</b>', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}}else{
print "<img src=\"i/w3.gif\" width=60 height=60 onMouseMove=\"TipShow('<b>Пустой слот оружие</b>\', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}?>

<TR><TD style="BACKGROUND-IMAGE: none">
<?php if ($buser['bron'] > 0) {
$dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$buser['bron']}' LIMIT 1;"));
if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
showhrefmagic($dress);
} else {
print "<img src=\"i/sh/".$dress['img']."\" width=60 height=80 onMouseMove=\"TipShow('<b>".$dress['name']."<br>Прочность: ".$dress['duration']."/".$dress['maxdur'].""; if($dress['ghp']>0){print"<br>Уровень жизни: + ".$dress['ghp']."";} if($dress['text']!=null){print"<br>На одежде выгравировано: <br><font color=#FFFF00>".$dress['text']."</font>";} print"</b>', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}}else{
print "<img src=\"i/w4.gif\" width=60 height=80 onMouseMove=\"TipShow('<b>Пустой слот броня</b>\', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}?>

<TR><TD style="BACKGROUND-IMAGE: none">
<?php if ($buser['pojas'] > 0) {
$dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$buser['pojas']}' LIMIT 1;"));
if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
showhrefmagic($dress);
} else {
print "<img src=\"i/sh/".$dress['img']."\" width=60 height=40 onMouseMove=\"TipShow('<b>".$dress['name']."<br>Прочность: ".$dress['duration']."/".$dress['maxdur'].""; if($dress['ghp']>0){print"<br>Уровень жизни: + ".$dress['ghp']."";} if($dress['text']!=null){print"<br>На поясе выгравировано: <br><font color=#FFFF00>".$dress['text']."</font>";} print"</b>', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}}else{
print "<img src=\"i/w5.gif\" width=60 height=40 onMouseMove=\"TipShow('<b>Пустой слот пояс</b>\', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}?>
</TBODY></TABLE>
</TD>

<TD>
<TABLE border=0 cellSpacing=0 cellPadding=0 width="100%">
<TBODY><TR>
<TD height=20 vAlign=center>
<TABLE style="LINE-HEIGHT: 1" cellSpacing=0 cellPadding=0>
<TBODY><TR>
<TD style="POSITION: relative; FONT-SIZE: 9px" noWrap>
<SPAN style="Z-INDEX: 1; POSITION: absolute; COLOR: #ffffff; FONT-WEIGHT: bold; TOP:-2px; LEFT: 0px" id=HP>
<? echo setHP($buser['hp'],$buser['maxhp'],$battle);?></SPAN>
<?
if($buser['maxmana']){
print"<SPAN style=\"Z-INDEX: 1; POSITION: absolute; COLOR: #ffffff; FONT-WEIGHT: bold; TOP:-4px; LEFT: 0px\" id=HP>";
echo setMP($buser['mana'],$buser['maxmana'],$battle);
print"</SPAN>";
}
?>
<SPAN style="WIDTH: 1px; HEIGHT: 10px"></SPAN></TD></TR></TBODY></TABLE></TD></TR>
<TR><TD height=220 vAlign=top width=120 align=left>
<DIV style="Z-INDEX: 1; POSITION: relative; WIDTH: 120px; HEIGHT: 220px" bgcolor="black">
<IMG border=0 src="i/shadow/1/1000.gif" width=120 height=218>
<DIV style="Z-INDEX: 2; POSITION: absolute; WIDTH: 120px; HEIGHT: 220px; TOP: 0px; LEFT: 0px"></DIV></DIV></TD></TR>
<TR><TD>
<IMG border=0 alt="" src="img/slot_bottom0.gif" width=120 height=40>
</TD></TR></TBODY></TABLE></TD>
<TD><TABLE border=0 cellSpacing=0 cellPadding=0 width="100%"><TBODY>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php if ($buser['sergi'] > 0) {
$dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$buser['sergi']}' LIMIT 1;"));
if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
showhrefmagic($dress);
} else {
print "<img src=\"i/sh/".$dress['img']."\" width=60 height=20 onMouseMove=\"TipShow('<b>".$dress['name']."<br>Прочность: ".$dress['duration']."/".$dress['maxdur'].""; if($dress['ghp']>0){print"<br>Уровень жизни: + ".$dress['ghp']."";} if($dress['text']!=null){print"<br>На серьгах выгравировано: <br><font color=#FFFF00>".$dress['text']."</font>";} print"</b>', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}}else{
print "<img src=\"i/w1.gif\" width=60 height=20 onMouseMove=\"TipShow('<b>Пустой слот серьги</b>\', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}?>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php if ($buser['kulon'] > 0) {
$dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$buser['kulon']}' LIMIT 1;"));
if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
showhrefmagic($dress);
} else {
print "<img src=\"i/sh/".$dress['img']."\" width=60 height=20 onMouseMove=\"TipShow('<b>".$dress['name']."<br>Прочность: ".$dress['duration']."/".$dress['maxdur'].""; if($dress['ghp']>0){print"<br>Уровень жизни: + ".$dress['ghp']."";} if($dress['text']!=null){print"<br>На кулоне выгравировано: <br><font color=#FFFF00>".$dress['text']."</font>";} print"</b>', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}}else{
print "<img src=\"i/w2.gif\" width=60 height=20 onMouseMove=\"TipShow('<b>Пустой слот кулон</b>\', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}?>

<TR><TD><TABLE border=0 cellSpacing=0 cellPadding=0>
<TBODY> <TR>
<TD style="BACKGROUND-IMAGE: none">
<?php if ($buser['r1'] > 0) {
$dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$buser['r1']}' LIMIT 1;"));
if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
showhrefmagic($dress);
} else {
print "<img src=\"i/sh/".$dress['img']."\" width=20 height=20 onMouseMove=\"TipShow('<b>".$dress['name']."<br>Прочность: ".$dress['duration']."/".$dress['maxdur'].""; if($dress['ghp']>0){print"<br>Уровень жизни: + ".$dress['ghp']."";} if($dress['text']!=null){print"<br>На кольце выгравировано: <br><font color=#FFFF00>".$dress['text']."</font>";} print"</b>', event);\" onMouseOut=\"TipHide();\"></TD>";
}}else{
print "<img src=\"i/w6.gif\" width=20 height=20 onMouseMove=\"TipShow('<b>Пустой слот кольцо</b>\', event);\" onMouseOut=\"TipHide();\"></TD>";
}?>
<TD style="BACKGROUND-IMAGE: none">
<?php if ($buser['r2'] > 0) {
$dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$buser['r2']}' LIMIT 1;"));
if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
showhrefmagic($dress);
} else {
print "<img src=\"i/sh/".$dress['img']."\" width=20 height=20 onMouseMove=\"TipShow('<b>".$dress['name']."<br>Прочность: ".$dress['duration']."/".$dress['maxdur'].""; if($dress['ghp']>0){print"<br>Уровень жизни: + ".$dress['ghp']."";} if($dress['text']!=null){print"<br>На кольце выгравировано: <br><font color=#FFFF00>".$dress['text']."</font>";} print"</b>', event);\" onMouseOut=\"TipHide();\"></TD>";
}}else{
print "<img src=\"i/w6.gif\" width=20 height=20 onMouseMove=\"TipShow('<b>Пустой слот кольцо</b>\', event);\" onMouseOut=\"TipHide();\"></TD>";
}?>
<TD style="BACKGROUND-IMAGE: none">
<?php if ($buser['r3'] > 0) {
$dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$buser['r3']}' LIMIT 1;"));
if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
showhrefmagic($dress);
} else {
print "<img src=\"i/sh/".$dress['img']."\" width=20 height=20 onMouseMove=\"TipShow('<b>".$dress['name']."<br>Прочность: ".$dress['duration']."/".$dress['maxdur'].""; if($dress['ghp']>0){print"<br>Уровень жизни: + ".$dress['ghp']."";} if($dress['text']!=null){print"<br>На кольце выгравировано: <br><font color=#FFFF00>".$dress['text']."</font>";} print"</b>', event);\" onMouseOut=\"TipHide();\"></TD>";
}}else{
print "<img src=\"i/w6.gif\" width=20 height=20 onMouseMove=\"TipShow('<b>Пустой слот кольцо</b>\', event);\" onMouseOut=\"TipHide();\"></TD>";
}?>
</TR></TBODY></TABLE></TD></TR>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php if ($buser['perchi'] > 0) {
$dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$buser['perchi']}' LIMIT 1;"));
if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
showhrefmagic($dress);
} else {
print "<img src=\"i/sh/".$dress['img']."\" width=60 height=40 onMouseMove=\"TipShow('<b>".$dress['name']."<br>Прочность: ".$dress['duration']."/".$dress['maxdur'].""; if($dress['ghp']>0){print"<br>Уровень жизни: + ".$dress['ghp']."";} if($dress['text']!=null){print"<br>На перчатках выгравировано: <br><font color=#FFFF00>".$dress['text']."</font>";} print"</b>', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}}else{
print "<img src=\"i/w11.gif\" width=60 height=40 onMouseMove=\"TipShow('<b>Пустой слот перчатки</b>\', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}?>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php if ($buser['shit'] > 0) {
$dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$buser['shit']}' LIMIT 1;"));
if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
showhrefmagic($dress);
} else {
print "<img src=\"i/sh/".$dress['img']."\" width=60 height=60 onMouseMove=\"TipShow('<b>".$dress['name']."<br>Прочность: ".$dress['duration']."/".$dress['maxdur'].""; if($dress['ghp']>0){print"<br>Уровень жизни: + ".$dress['ghp']."";} if($dress['text']!=null){print"<br>На щите выгравировано: <br><font color=#FFFF00>".$dress['text']."</font>";} print"</b>', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}}else{
print "<img src=\"i/w10.gif\" width=60 height=60 onMouseMove=\"TipShow('<b>Пустой слот щит</b>\', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}?>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php if ($buser['leg'] > 0) {
$dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$buser['leg']}' LIMIT 1;"));
if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
showhrefmagic($dress);
} else {
print "<img src=\"i/sh/".$dress['img']."\" width=60 height=80 onMouseMove=\"TipShow('<b>".$dress['name']."<br>Прочность: ".$dress['duration']."/".$dress['maxdur'].""; if($dress['ghp']>0){print"<br>Уровень жизни: + ".$dress['ghp']."";} if($dress['text']!=null){print"<br>На поножах выгравировано: <br><font color=#FFFF00>".$dress['text']."</font>";} print"</b>', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}}else{
print "<img src=\"i/w19.gif\" width=60 height=80 onMouseMove=\"TipShow('<b>Пустой слот поножи</b>\', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}?>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php if ($buser['boots'] > 0) {
$dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$buser['boots']}' LIMIT 1;"));
if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
showhrefmagic($dress);
} else {
print "<img src=\"i/sh/".$dress['img']."\" width=60 height=40 onMouseMove=\"TipShow('<b>".$dress['name']."<br>Прочность: ".$dress['duration']."/".$dress['maxdur'].""; if($dress['ghp']>0){print"<br>Уровень жизни: + ".$dress['ghp']."";} if($dress['text']!=null){print"<br>На сапогах выгравировано: <br><font color=#FFFF00>".$dress['text']."</font>";} print"</b>', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}}else{
print "<img src=\"i/w12.gif\" width=60 height=40 onMouseMove=\"TipShow('<b>Пустой слот обувь</b>\', event);\" onMouseOut=\"TipHide();\"></TD></TR>";
}?>
</TBODY></TABLE></TD></TR></TBODY></TABLE></TD>
    </td>
  </tr>
</table>

</td></tr></table>
</td></tr></table>
</body>
</html>
<?
}
?>
<?
//����������, ����� ������

//���-�� ������������ ����
$days = 7; // 7 ����
//���� �� ������ ������ ������������� �����
$coust_1 = 1;
$coust_2 = 3;
$coust_3 = 10;
//���� �� 1 ����
$coust_day_1 = $coust_1 / $days;
$coust_day_2 = $coust_2 / $days;
$coust_day_3 = $coust_3 / $days;
//���-�� ����� �� ������ �����
$mass_1 = 25;
$mass_2 = 40;
$mass_3 = 70;
$mass_4 = 1000;
//���-�� �������� �� ������ �����
$podarok_1 = 50;
$podarok_2 = 150;
$podarok_3 = 200;
$podarok_4 = 2000;
//���-�� �������� �� �����
$animal_1 = 0;
$animal_2 = 1;
$animal_3 = 2;
$animal_4 = 4;

//������� ���������, �� �������� ������ ������ � �����
$obshaga_etaz = "105";
$etaz_1 = "101";
$etaz_2 = "102";
$etaz_3 = "103";
$etaz_4 = "104"; //��� ����

$title = array("�� ���������� ����� � ���������", "�� ���������� ����� c ��������� � ���������", "�� ���������� ����� � ������ � ���������");
$title_room = array("���. ���� 1", "���. ���� 2", "���. ���� 3", "VIP-�������");

session_start();
if ($_SESSION['uid'] == null) header("Location: index.php");
include "connect.php";
//$user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
include "functions.php";
if ($user["room"]!=101 && $user["room"]!=102 && $user["room"]!=103 && $user["room"]!=104 && $user["room"]!=105) {
  header("location: main.php");
  die;
}
if ($user['prison']) {
  header("location: jail.php");
  die;
}
$obshaga = mysql_fetch_array(mq("SELECT * FROM `obshaga` WHERE `pers` = '{$_SESSION['uid']}' LIMIT 1;"));
$coust_day=0;
if($obshaga['etaz']==1) $coust_day=$coust_day_1;
if($obshaga['etaz']==2) $coust_day=$coust_day_2;
if($obshaga['etaz']==3) $coust_day=$coust_day_3;

if ($obshaga["sleep"]) {
  if ($user["room"]-100!=$obshaga["etaz"]) {
    $user["room"]=$obshaga["etaz"]+100;
    mq("UPDATE `users`,`online` SET `users`.`room` = '".($obshaga["etaz"]+100)."',`online`.`room` = '".($obshaga["etaz"]+100)."' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
  }
  $_REQUEST['etaz']=$obshaga["etaz"];
  $_GET['etaz']=$obshaga["etaz"];
}
$skoka = mqfa1("SELECT count(id) FROM `obshagastorage` WHERE `pers` = '{$_SESSION['uid']}' and gift=0");
$skoka_a = mqfa1("SELECT count(id) FROM `obshagaanimals` WHERE `pers` = '{$_SESSION['uid']}'");
$skoka_p = mqfa1("SELECT count(id) FROM `obshagastorage` WHERE `pers` = '{$_SESSION['uid']}' and gift=1");
if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }
$mess ="";

//$arenda_begin = date("Y-m-d H:i:s"); //��������� ���� ������
//$arenda_end = date("Y-m-d H:i:s", mktime(date("H"),date("i"),date("s"),date("m"),date("d")+$days,date("Y"))); //��������� ���� + N ����
$arenda_begin = time();
$arenda_end = $arenda_begin+$days*86400; // ������ + 7 ����

//��� ����� �� ������
if ($obshaga['balanse']<0 && $_GET['etaz'])
    $mess = "<font color=red><b>��������� ������ ����� ������</b></font>";
if ($_GET['etaz'] == "1" && $obshaga['arenda']=="")
    $mess = "<font color=red><b>�� ������ �� ���������</b></font>";
//��������� ������
if($user['vip']>0)
{
    $result = mysql_fetch_array(mq("SELECT * FROM `obshaga` WHERE `pers` = '{$_SESSION['uid']}' LIMIT 1;"));
    if($result == false) //��������� ������ ������� ������
        mq("INSERT INTO `obshaga` (`id`, `pers`, `arenda`, `etaz`) VALUES (NULL, '".$_SESSION['uid']."' , '4', '4');");
}

if ($obshaga && @$_GET["arenda"]) {
  if ($_GET["arenda"]==1 || $_GET["arenda"]==3 || $_GET["arenda"]==10) {
    $_GET["arenda"]=(int)$_GET["arenda"];

    $cnt1=mqfa1("select count(id) from obshagastorage where pers='$user[id]' and gift=0");
    $cnt2=mqfa1("select count(id) from obshagastorage where pers='$user[id]' and gift=1");
    $cnt3=mqfa1("select count(id) from obshagaanimals where pers='$user[id]'");

    if ($_GET["arenda"]==1) {$max1=25;$max2=50;$max3=0;$e=1;}
    if ($_GET["arenda"]==3) {$max1=40;$max2=150;$max3=1;$e=2;}
    if ($_GET["arenda"]==10) {$max1=70;$max2=200;$max3=2;$e=3;}
    if ($cnt1>$max1 || $cnt2>$max2 || $cnt3>$max3) {
      $mess="<b><font color=red>� ��� ������� ����� �������� ��� ������� ���� ������.</font></b><br>";
    } elseif ($obshaga["balanse"]<$_GET["arenda"] && $obshaga["etaz"]>0) {
      $mess="<b><font color=red>�� ������� ��������� ����� ��� ����� ������.</font></b><br>";
    } elseif ($user["money"]+$obshaga["balanse"]-$_GET["arenda"]<0) {
      $mess="<b><font color=red>� ��� ������������ �����.</font></b><br>";
    } else {
      mq("update obshaga set balanse=balanse-$_GET[arenda], etaz='$e' where pers='$user[id]'");
      $obshaga["balanse"]-=$_GET["arenda"];
      if ($obshaga["balanse"]<0) {
        mq("update obshaga set balanse=0 where id='$obshaga[id]'");
        mq("update users set money=money+$obshaga[balanse] where id='$user[id]'");
        $user["money"]+=$obshaga["balanse"];
      }
      if ($obshaga["etaz"]) $mess="<b>�� ������� ���������� �����.</b><br>";
      else $mess="<b>�� ���������� �����.</b><br>";
    }
  }

  $_GET["arenda"]=0;
  //$mess = "<font color=red><b>������������ ����� � �������</b></font>";
}

if($_GET['arenda'] == "1" && $user["money"]>=1 ) {
   mq("UPDATE `users` set money=money-'1' where id='".$_SESSION['uid']."'");
   $user["money"]-=1;
   $result = mysql_fetch_array(mq("SELECT * FROM `obshaga` WHERE `pers` = '{$_SESSION['uid']}' LIMIT 1;"));
   if($result == false) {//��������� ������ ������� ������
     mq("INSERT INTO `obshaga` (`id`, `pers`, `arenda`, `etaz`, `date_begin`, `date_end`, `balanse`, `timebalanse`) VALUES (NULL, '".$_SESSION['uid']."', '1', '1', '".$arenda_begin."', '".$arenda_end."', '0', ".$arenda_begin.");");
   } elseif ($obshaga["balanse"]>=0) {
     mq("update obshaga set etaz=1, date_begin='$arenda_begin', date_end='$arenda_end', timebalanse='$arenda_begin' where pers='$user[id]'");
   }
   mq("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".$_SESSION['uid']."','�������� ".$user['login']." ��������� ����� � ���������','1','".time()."');");
$mess = "<font color=red><b>".$title[0]."</b></font>";
} elseif($_GET['arenda'] == "1") $mess = "<font color=red><b>������������ ����� � �������</b></font>";

if($_GET['arenda'] == "3" && $user["money"]>=3) {
    mq("UPDATE `users` set money=money-'3' where id='".$_SESSION['uid']."'");
    $user["money"]-=3;
    $result = mysql_fetch_array(mq("SELECT * FROM `obshaga` WHERE `pers` = '{$_SESSION['uid']}' LIMIT 1;"));
    if($result == false) {//��������� ������ ������� ������
      mq("INSERT INTO `obshaga` (`id`, `pers`, `arenda`, `etaz`, `date_begin`, `date_end`, `balanse`, timebalanse) VALUES (NULL, '".$_SESSION['uid']."', '3', '2', '".$arenda_begin."', '".$arenda_end."', '0', ".$arenda_begin.");");
    } elseif ($obshaga["balanse"]>=0) {
     mq("update obshaga set etaz=2, date_begin='$arenda_begin', date_end='$arenda_end', timebalanse='$arenda_begin' where pers='$user[id]'");
   }
   mq("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".$_SESSION['uid']."','�������� ".$user['login']." ��������� ����� c ��������� � ���������','1','".time()."');");
$mess = "<font color=red><b>".$title[1]."</b></font>";
} elseif($_GET['arenda'] == "3") $mess = "<font color=red><b>������������ ����� � �������</b></font>";

if($_GET['arenda'] == "10" && $user["money"]>=10) {
  $user["money"]-=10;
    mq("UPDATE `users` set money=money-'10' where id='".$_SESSION['uid']."'");
    $result = mysql_fetch_array(mq("SELECT * FROM `obshaga` WHERE `pers` = '{$_SESSION['uid']}' LIMIT 1;"));
    if($result == false) {//��������� ������ ������� ������
      mq("INSERT INTO `obshaga` (`id`, `pers`, `arenda`, `etaz`, `date_begin`, `date_end`, `balanse`, timebalanse) VALUES (NULL, '".$_SESSION['uid']."', '10', '3', '".$arenda_begin."', '".$arenda_end."', '0', ".$arenda_begin.");");
   } elseif ($obshaga["balanse"]>=0) {
     mq("update obshaga set etaz=3, date_begin='$arenda_begin', date_end='$arenda_end', timebalanse='$arenda_begin' where pers='$user[id]'");
   }
   mq("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".$_SESSION['uid']."','�������� ".$user['login']." ��������� ����� �� ������','1','".time()."');");
$mess = "<font color=red><b>".$title[2]."</b></font>";
} elseif($_GET['arenda'] == "10") $mess = "<font color=red><b>������������ ����� � �������</b></font>";

//��������� ������
if($obshaga['arenda'] == 1)
   $day_add = round($_REQUEST['payarenda'] / $coust_day_1)*86400;
if($obshaga['arenda'] == 3)
   $day_add = round($_REQUEST['payarenda'] / $coust_day_2)*86400;
if($obshaga['arenda'] == 10)
   $day_add = round($_REQUEST['payarenda'] / $coust_day_3)*86400;
if((int)$_REQUEST['payarenda']>0) {
  $_REQUEST['payarenda']=(int)$_REQUEST['payarenda'];
  if ($_REQUEST['payarenda']<=$user["money"]) {
   mq("UPDATE `users` set money=money-'".$_REQUEST['payarenda']."' where id='".$_SESSION['uid']."'");
   $user["money"]-=$_REQUEST['payarenda'];
   mq("UPDATE `obshaga` set balanse=balanse+'".$_REQUEST['payarenda']."' where pers='".$_SESSION['uid']."'");
   if ($obshaga["etaz"]==0 && $obshaga["balanse"]+$_REQUEST['payarenda']>=0) mq("delete from obshaga where pers='$user[id]'");
   //mq("UPDATE `obshaga` set date_end=ADDDATE(date_end, INTERVAL ".$day_add." DAY) where pers='".$_SESSION['uid']."'");
   mq("UPDATE `obshaga` set date_end=date_end+".$day_add." where pers='".$_SESSION['uid']."'");
   mq("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".$_SESSION['uid']."','�������� ".$user['login']." ������� ������ ������� � ��������� �� ".$_REQUEST['payarenda']."','1','".time()."');");
   $mess = "<font color=red><b>�� �������� ������ �� ".$_REQUEST['payarenda']." ��.</b></font>";
  } else {
    $mess = "<font color=red><b>������������ ����� � �������.</b></font>";
  }
}


function itemback($id) {
  global $user;
  $gift=mqfa("select gift, name, koll, duration, maxdur from inventory where id='$id'");
  if ($gift) {
    mq("update `inventory` SET `owner` = ".$user['id']." ".($gift["gift"]?", dategoden=dategoden+".time():"")." WHERE `id` ='$id'");
    return $gift;
  } else {
    mq("insert into inventory (select * from allinventory where id='$id')");
    $gift=mqfa("select gift, name, koll, duration, maxdur from inventory where id='$id'");
    mq("update `inventory` SET `owner` = ".$user['id']." ".($gift["gift"]?", dategoden=dategoden+".time():"")." WHERE `id` ='$id'");
    return $gift;
  }
}

//����������� ������
if($_GET['closearenda']==1 && !$obshaga["sleep"]) {
  if ($obshaga['balanse']>=0) mq("DELETE FROM obshaga WHERE pers='".$_SESSION['uid']."'");
  else mq("update obshaga set etaz=0 where pers='".$_SESSION['uid']."'");
  $data = mq("SELECT * FROM `obshagastorage` WHERE `pers` = ".$_SESSION['uid'].";");
  while($it = mysql_fetch_array($data)) {
    itemback($it['id_it']);
    mq("update `inventory` SET `owner` = ".$user['id']." WHERE `id` = ".$it['id_it'].";");
  }
  mq("delete from `obshagastorage` WHERE `pers` = ".$_SESSION['uid'].";");
  if (!$user["zver_id"]) {
    $a=mqfa1("select animal from obshagaanimals where pers='$user[id]'");
    if ($a) mq("update users set zver_id='$a' where id='$user[id]'");
  }
  mq("delete from obshagaanimals where pers='$user[id]'");
  mq("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".$_SESSION['uid']."','�������� ".$user['login']." ��������� ������ � ���������','1','".time()."');");
  $mess = "<font color=red><b>�� ���������� ������</b></font>";
}

//������������ �� ������
if (count($_GET)==0) {
  if ($user["room"]>100 && $user["room"]<105) $_GET["etaz"]=$user["room"]-100;
}

if(isset($_GET['etaz']) && $_GET['etaz']=="0" && $user["room"]!=$obshaga_etaz) {
  mq("UPDATE `users`,`online` SET `users`.`room` = '".$obshaga_etaz."',`online`.`room` = '".$obshaga_etaz."' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
  $user["room"]=$obshaga_etaz;
}
if($_GET['etaz']=="1" && $obshaga['balanse'] >= 0 && $user["room"]!=$etaz_1) {
  mq("UPDATE `users`,`online` SET `users`.`room` = '".$etaz_1."',`online`.`room` = '".$etaz_1."' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
  $user["room"]=$etaz_1;
}
if($_GET['etaz']=="2" && $user["room"]!=$etaz_2) {
  mq("UPDATE `users`,`online` SET `users`.`room` = '".$etaz_2."',`online`.`room` = '".$etaz_2."' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
  $user["room"]=$etaz_2;
}
if($_GET['etaz']=="3" && $user["room"]!=$etaz_3) {
  mq("UPDATE `users`,`online` SET `users`.`room` = '".$etaz_3."',`online`.`room` = '".$etaz_3."' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
  $user["room"]=$etaz_3;
}
if($_GET['etaz']=="4" && $user["room"]!=$etaz_4) {
  mq("UPDATE `users`,`online` SET `users`.`room` = '".$etaz_4."',`online`.`room` = '".$etaz_4."' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
  $user["room"]=$etaz_4;
}


//��������� ������� ��� ��������� � ����������� ��� ����������
if($_GET['to_sleep']==1 && $obshaga['balanse']>=0 && $obshaga["etaz"]) {
  $r=mq("SELECT * FROM `effects` WHERE owner = '{$_SESSION['uid']}' and type<>2 and type<>186 and type<>9990 and type<>9992 and type<>9993 and type<>".CAVEEFFECT." and type<>".NYBLESSING." and (sila>0 or lovk>0 or inta>0 or vinos>0 or intel>0 or mudra>0 or mfdmag>0 or mfdfire>0 or mfdwater>0 or mfdair>0 or mfdearth>0 or mfdhit>0 or mfdkol>0 or mfdrub>0 or mfdrej>0 or mfddrob>0 or mfval<>'' or type=201 or type=202 or ghp>0 or type=54 or type=28 or type=29 or hpforvinos<>0 or gmana>0 or type=".ADDICTIONEFFECT." or type=".HPADDICTIONEFFECT." or type=".MANAADDICTIONEFFECT.")");
  $cond="";
  while ($it=mysql_fetch_assoc($r)) {
    $left_time = $it['time'] - time();
    mq("INSERT INTO obshagaeffects (`id`, `type`, `name`, `time`, `sila`, `lovk`, `inta`, `vinos`, `intel`, `mudra`, mf, mfval, mfdmag, mfdhit, `owner`, `lastup`, `stihiya`, ghp, gmana, hpforvinos,  mfdkol, mfdrub, mfdrej, mfddrob, mfdfire, mfdwater, mfdair, mfdearth) VALUES ('','".$it['type']."','".$it['name']."', '".$left_time."','".$it['sila']."','".$it['lovk']."','".$it['inta']."','".$it['vinos']."','".$it['intel']."','".$it['mudra']."','".$it['mf']."','".$it['mfval']."','".$it['mfdmag']."','".$it['mfdhit']."','".$it['owner']."','".$it['lastup']."','".$it['stihiya']."','$it[ghp]','$it[gmana]', '$it[hpforvinos]',  '$it[mfdkol]', '$it[mfdrub]', '$it[mfdrej]', '$it[mfddrob]', '$it[mfdfire]', '$it[mfdwater]', '$it[mfdair]', '$it[mfdearth]');");
    $cond.="or id='$it[id]'";
  }
  if ($cond) mq("DELETE FROM effects WHERE owner='".$_SESSION['uid']."' and type<>2 and (0 $cond)");
  mq("update `obshaga` SET `sleep` = ".time()." WHERE pers =".$_SESSION['uid'].";");
  updeffects();
}

if ($obshaga["sleep"] && $obshaga["balanse"]<0) $_GET['to_awake']=1;

if ($obshaga["balanse"]<0) {
  if ($user["room"]!=105) {
    mq("UPDATE `users`,`online` SET `users`.`room` = '105',`online`.`room` = '105' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
    $user["room"]=105;
  }
}

if($_GET['to_awake']==1 && $obshaga["sleep"]) {
  include "functions/wake.php";
  wake($user["id"]);
}
//���������� ���������� ��� ������ ������
if($obshaga['etaz']==1)
{
    $mass = $mass_1;
    $podarok = $podarok_1;
    $animal = $animal_1;
    }
if($obshaga['etaz']==2)
{
    $mass = $mass_2;
    $podarok = $podarok_2;
    $animal = $animal_2;
    }
if($obshaga['etaz']==3)
{
    $mass = $mass_3;
    $podarok = $podarok_3;
    $animal = $animal_3;
    }
if($obshaga['etaz']==4)
{
    $mass = $mass_4;
    $podarok = $podarok_4;
    $animal = $animal_4;
    }

if($_POST['notes']!="") {
  mq("update `obshaga` SET `text` = '{$_POST['notes']}' WHERE `pers` = ".$_SESSION['uid'].";");
}

function puttocage() {
  global $user;
  mq("insert into obshagaanimals set pers='$user[id]', animal='$user[zver_id]'");
  mq("update users set zver_id=0 where id='$user[id]'");
  $user["zver_id"]=0;
}

if (@$_GET["tocage"] && $user["zver_id"]) {
  if ($skoka_a<$animal) puttocage();
}

if (@$_GET["takeanimal"]) {
  $a=mqfa1("select animal from obshagaanimals where id='$_GET[takeanimal]' and pers='$user[id]'");
  if ($a) {
    if ($user["zver_id"]) puttocage();
    mq("update users set zver_id='$a' where id='$user[id]'");
    mq("delete from obshagaanimals where id='$_GET[takeanimal]'");
    $user["zver_id"]=$a;
  }
}



//���������� �������
//�������� ������
if($_GET['back']) {
    $it = mysql_fetch_array(mq("SELECT * FROM `obshagastorage` WHERE `id` = ".$_GET['back']." and pers='$user[id]';"));
    if ($it) {
      $rec=itemback($it["id_it"]);
      checkitemchange(unserialize($it["item"]));
      /*$rec=mqfa("select id, name, koll, duration, maxdur, gift from inventory where id='$it[id_it]'");
      if ($rec["koll"] && 0) {
        $i=mqfa1("select id from inventory where owner='$user[id]' and name='$rec[name]'");
        if ($i) {
          mq("update inventory set koll=koll+$rec[koll] where id='$i'");
          $item = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = ".$it['id_it'].";"));
          mq("delete from inventory where id='$it[id_it]'");
          $taken=1;
        }
      }

      if (!@$taken) {
        mq("update `inventory` SET `owner` = ".$user['id']."  ".($it["gift"]?", dategoden=dategoden+".time():"")." WHERE `id` = ".$it['id_it'].";");
        //$item = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE id` = ".$it['id_it'].";"));
      }*/
      mq("delete from `obshagastorage` WHERE `id` = ".$_GET['back'].";");
      mq("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".$_SESSION['uid']."','�������� ".$user['login']." ������ �� ������� ������� \"".$rec['name']."\" ".($rec["koll"]?"($rec[koll])":"")." id:(cap$it[id_it]) [".$rec['duration']."/".$rec['maxdur']."]','1','".time()."');");
      $mess = "<font color=red><b>�� ������� ������� \"".$rec['name']."\" ".($rec["koll"]?"(x $rec[koll])":"")." �� �������</b></font>";
    }
/*  $it = mysql_fetch_array(mq("SELECT * FROM `obshagastorage` WHERE `id` = ".$_GET['back'].";"));
    mq("update `inventory` SET `owner` = ".$user['id']." WHERE `id` = ".$it['id_it'].";");
    $item = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `dressed`=0 AND `setsale` = 0 AND `owner` =".$user['id']." AND `id` = ".$_GET['id_item'].";"));
    mq("delete from `obshagastorage` WHERE `id` = ".$_GET['back'].";");
    mq("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".$_SESSION['uid']."','�������� ".$user['login']." ������ �� ������� ������� \"".$item['name']."\" id:(cap".$item['id'].") [".$item['duration']."/".$item['maxdur']."]','1','".time()."');");
    $mess = "<font color=red><b>�� ������� ������� \"".$item['name']."\" �� �������</b></font>";*/
}
// �������� ������
if($_GET['add']) {
    $it = mqfa("SELECT * FROM `inventory` WHERE `dressed`=0 AND `setsale` = 0 AND `owner` =".$user['id']." AND `id` = ".$_GET['add']." and (dategoden=0 or (gift=1 and dategoden>".time()."))");
    if($it['owner'] ==$user['id']) {
      if ($it["gift"]==1) {
        $cnt=$skoka_p;
        $max=$podarok;
      } else {
        $cnt=$skoka;
        $max=$mass;
      }
        if($cnt>=$max)
            $mess = "<font color=red><b>�� �������� �������</b></font>";
        else{
            $mess = "<font color=red><b>�� �������� ������� \"".$it['name']."\" ".($it["koll"]?"($it[koll])":"")." � ������</b></font>";
            mq("update `inventory` SET `owner` = owner+"._BOTSEPARATOR_." ".($it["gift"]?", dategoden=dategoden-".time():"")." WHERE `id` = ".$it['id'].";");
            foreach ($it as $k=>$v) $it[$k]=str_replace("\\", "/", $v);
            mq("insert `obshagastorage` (id_it, pers, gift, item, prototype) values (".$it['id'].",".$user['id'].", ".$it['gift'].", '".addslashesa(serialize($it))."', '$it[prototype]');");
            mq("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".$_SESSION['uid']."','�������� ".$user['login']." ������� � ������ ������� \"".$it['name']."\" ".($it["koll"]?"($it[koll])":"")." id:(cap".$it['id'].") [".$it['duration']."/".$it['maxdur']."]','1','".time()."');");
            checkitemchange($it);
        }
    }
}

//��������� �������
$cur_time_balanse = time();
$diff = $cur_time_balanse - $obshaga['timebalanse'];
if($diff>86400)
mq("UPDATE `obshaga` set balanse=round(balanse-(".$coust_day."*$diff/86400),2), timebalanse = ".$cur_time_balanse." where pers='".$_SESSION['uid']."'");

//��������� ������ ����� ���������
//$user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
$obshaga = mysql_fetch_array(mq("SELECT * FROM `obshaga` WHERE `pers` = '{$_SESSION['uid']}' LIMIT 1;"));
$skoka = mysql_num_rows(mq("SELECT id FROM `obshagastorage` WHERE `pers` = '{$_SESSION['uid']}' and gift=0 ;"));
$skoka_p = mysql_num_rows(mq("SELECT id FROM `obshagastorage` WHERE `pers` = '{$_SESSION['uid']}' and gift=1 ;"));

//�����, ���� �� ���� ����
if(($user['room']=="101" && $obshaga['etaz']=="2") || ($user['room']=="101" && $obshaga['etaz']=="3"))
    $mess = "<table><tr><td valign=\"top\"><font color=red><b>�� ������ �� ��������� �� ���� �����</b></font></td><td><img src=\"".IMGBASE."/i/rooms/100_floor.jpg\"></td></tr></table>";
if($user['room']=="102" && $obshaga['etaz']=="3")
    $mess = "<table><tr><td valign=\"top\"><font color=red><b>�� ������ �� ��������� �� ���� �����</b></font></td><td><img src=\"".IMGBASE."/i/rooms/100_floor.jpg\"></td></tr></table>";

//����� ������
if($user['room']=="101")
    $title_room = $title_room[0];
if($user['room']=="102")
    $title_room = $title_room[1];
if($user['room']=="103")
    $title_room = $title_room[2];
if($user['room']=="104")
    $title_room = $title_room[3];
//����� ������� ���������� ��� ����������� �����������
if($obshaga['etaz']==1)
{
    $title = $title[0];
    $coust = $coust_1;
    $coust_day = $coust_day_1;
    $mass = $mass_1;
    $podarok = $podarok_1;
    $animal = $animal_1;
    }
if($obshaga['etaz']==2)
{
    $title = $title[1];
    $coust = $coust_2;
    $coust_day = $coust_day_2;
    $mass = $mass_2;
    $podarok = $podarok_2;
    $animal = $animal_2;
    }
if($obshaga['etaz']==3)
{
    $title = $title[2];
    $coust = $coust_3;
    $coust_day = $coust_day_3;
    $mass = $mass_3;
    $podarok = $podarok_3;
    $animal = $animal_3;
    }
if($obshaga['etaz']==4)
{
    $mass = $mass_4;
    $podarok = $podarok_4;
    $animal = $animal_4;
    }

//����� ��� ������
if (!$obshaga || ($obshaga && @$_GET["changearenda"]) || ((!$obshaga["etaz"] || ($_REQUEST['etaz'] == "" && $obshaga['etaz'] == 0 && $_REQUEST['room']=="" && $_REQUEST['add']=="" && $_REQUEST['back']=="") || ($_GET['etaz'] == "1" && $obshaga['arenda']=="" && $_GET['room']=="") || $user['vip']>0 || $user['vip']>1  && ($_GET['etaz']=="0" || $obshaga['arenda']==4) && $_GET['etaz'] !=4 && $_REQUEST['room'] == "") && $obshaga["balanse"]>=0)) {
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="<?=IMGBASE?>/i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<SCRIPT src='<?=IMGBASE?>/i/commoninf.js'></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="<?=IMGBASE?>/i/sl2.27.js?1"></SCRIPT>
<STYLE>
.pH3            { COLOR: #8f0000;  FONT-FAMILY: Arial;  FONT-SIZE: 12pt;  FONT-WEIGHT: bold; }
</STYLE>
<SCRIPT>
var sd4 = "869518824";
function fastshow(dsc, dx, dy) { top.fullfastshow(document, mmoves, window.event, dsc, dx, dy); }
function hideshow() { top.fullhideshow(mmoves); }
</SCRIPT>
</HEAD>
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=e2e0e0>
<div id=hint4 class=ahint></div>
<TABLE width=100%><TD valign=top height=100%>
<TABLE width=100% cellspacing=0 cellpadding=4 bgcolor=d2d2d2>
<FORM METHOD=POST name=F1>
<tr><td class='pH3'>&nbsp;&nbsp;&nbsp;&nbsp;���������</FONT></td><td align=right valign=top><? echo fullnick($user); ?>&nbsp;</td></tr></table>
<TABLE cellpadding=0 cellspacing=0>
<? if($mess != "") echo $mess."<br>"; ?>
<TR><TD>�������: ��� ����������. ��� ������������. ��� �������� ���������. ������������ ����� � ��������� �������� ����� ������ � ��������.</TD>
<TR><TD align=right><i>���������</i></TD></TR></TABLE><BR>
<?
  if (@$_GET["warning"]) echo "<tr><td><b><font color=red>$_GET[warning]</font></b></td></tr>";
  if (@$_GET["changearenda"]) {
    function ending1($c) {
      $c1=$c%10;
      if ($c1==1) return "";
      if ($c==2 || $c==3 || $c==4) return "�";
      return "��";
    }
    function ending2($c) {
      $c1=$c%10;
      if ($c1==1) return "��";
      if ($c==2 || $c==3 || $c==4) return "��";
      return "���";
    }
    function ending3($c) {
      $c1=$c%10;
      if ($c1==1) return "�";
      if ($c==2 || $c==3 || $c==4) return "�";
      return "��";
    }
    $cnt1=mqfa1("select count(id) from obshagastorage where pers='$user[id]' and gift=0");
    $cnt2=mqfa1("select count(id) from obshagastorage where pers='$user[id]' and gift=1");
    $cnt3=mqfa1("select count(id) from obshagaanimals where pers='$user[id]'");
    echo "�� ������ ������� ���������� ���������:<br><br>
    <small>��� ����� ������ �� ����� ������� ������ ���� ����������� �����.
    ���������� �����, ��������� � �������� �� ����� ������ �� ������ ��������� ���������� �������� ��� ���������� ����������� ���������. </small><br><br>
    � ��� � ���������: $cnt1 �������".ending1($cnt1).", $cnt2 �����".ending2($cnt2).", $cnt3 ����".ending3($cnt3).".<br><br>";
  }
if($user['vip']>0) {
echo "�� VIP ������������ ����, ������� ������ ��� �� � ����";
} else {
  if ($obshaga["etaz"]!=1) {
?>
���������� ����� � ���������<BR>
����: <? echo $coust_1 ?> ��. + <? echo $coust_1 ?> ��. � ������.<BR>

 &bull; ������ �������: <? echo $mass_1 ?> �����<BR>
 &bull; ��������: <? echo $podarok_1 ?> ��.<BR>
 &bull; ���� ��� ��������: <? echo $animal_1 ?> <BR>
 &bull; �����<BR>

<A href="/obshaga.php?arenda=1" onClick="return confirm('�� �������, ��� ������ ��������� 1 ��.?')"><?
  if (@$_GET["changearenda"]) echo "������� ������";
  else echo "����������";
?></A>
<HR><? } ?>
<? if ($obshaga["etaz"]!=2) { ?>
���������� ����� � ���������<BR>
����: <? echo $coust_2 ?> ��. + <? echo $coust_2 ?> ��. � ������.<BR>

 &bull; ������ �������: <? echo $mass_2 ?> �����<BR>
 &bull; ��������: <? echo $podarok_2 ?> ��.<BR>
 &bull; ���� ��� ��������: <? echo $animal_2 ?> <BR>
 &bull; �����<BR>

<A href="/obshaga.php?arenda=3" onClick="return confirm('�� �������, ��� ������ ��������� 3 ��.?')"><?
  if (@$_GET["changearenda"]) echo "������� ������";
  else echo "����������";
?></A>
<HR>
<? } ?>
<? if ($obshaga["etaz"]!=3) { ?>
���������� ����� �� ������<BR>
����: <? echo $coust_3 ?> ��. + <? echo $coust_3 ?> ��. � ������.<BR>

 &bull; ������ �������: <? echo $mass_3 ?> �����<BR>
 &bull; ��������: <? echo $podarok_3 ?> ��.<BR>
 &bull; ���� ��� ��������: <? echo $animal_3 ?> <BR>
 &bull; �����<BR>

<A href="/obshaga.php?arenda=10" onClick="return confirm('�� �������, ��� ������ ��������� 10 ��.?')"><?
  if (@$_GET["changearenda"]) echo "������� ������";
  else echo "����������";
?></A>
<HR><? }
   if (@$_GET["changearenda"]) echo "<a href=\"obshaga.php\">�� ������ ������</a>";
 } ?>



</TD><TD valign=top width=200><TABLE cellpadding=0 cellspacing=0 width=100%><TR><TD width=100%><SPAN></SPAN><TD><HTML>
<link href="<?=IMGBASE?>/i/move/design6.css" rel="stylesheet" type="text/css"><script language="javascript" type="text/javascript">
function fastshow2 (content, eEvent ) {
var el = document.getElementById("mmoves");
eEvent = eEvent || window.event;
if( !eEvent )
return;
var o = eEvent.target || eEvent.srcElement;
if (content!='' && el.style.visibility != "visible") {el.innerHTML = '<small>'+content+'</small>';}
var x = window.event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft - el.offsetWidth + 5;
var y = window.event.clientY + document.documentElement.scrollTop + document.body.scrollTop+20;
if (x + el.offsetWidth + 3 > document.body.clientWidth + document.body.scrollLeft) { x=(document.body.clientWidth + document.body.scrollLeft - el.offsetWidth - 5); if (x < 0) {x=0}; }
if (y + el.offsetHeight + 3 > document.body.clientHeight  + document.body.scrollTop) { y=(document.body.clientHeight + document.body.scrollTop - el.offsetHeight - 3); if (y < 0) {y=0}; }
if (x<0) {x=0;}
if (y<0) {y=0;}
el.style.left = x + "px";
el.style.top  = y + "px";
if (el.style.visibility != "visible") {
el.style.visibility = "visible";
}
}
function hideshow () {
document.getElementById("mmoves").style.visibility = 'hidden';
}
</script>
<table  border="0" cellpadding="0" cellspacing="0">
<tr align="right" valign="top">
<td>


</td>
<td>

<TABLE height=15 border="0" cellspacing="0" cellpadding="0">
<TR>
<TD rowspan=3 valign="bottom"><a href="?rnd=0.313154328583547"><img src="<?=IMGBASE?>/i/move/rel_1.gif" width="15" height="16" alt="��������" border="0" /></a></TD>
<TD colspan="3"><img src="<?=IMGBASE?>/i/move/navigatin_462.gif" width="80" height="4" /></TD>
</TR>
<TR>
<TD><IMG src="<?=IMGBASE?>/i/move/navigatin_481.gif" width="9" height="8"></TD>
<TD width=64 bgcolor=black><DIV class="MoveLine"><IMG src="<?=IMGBASE?>/i/move/wait2.gif" id="MoveLine" class="MoveLine"></DIV></TD>
<TD><IMG src="<?=IMGBASE?>/i/move/navigatin_50.gif" width="7" height="8"></TD>
</TR>
<TR>
<TD colspan="3"><IMG src="<?=IMGBASE?>/i/move/navigatin_tt1_532.gif" width="80" height="5"></TD>
</TR>
</TABLE>


<table  border="0" cellspacing="0" cellpadding="0">
<tr>
<td nowrap="nowrap" id="moveto">
<table width="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#DEDEDE">

<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><a href="city.php?strah=1&got=1" onClick="return check_access();" class="menutop" title="����� ��������: 10 ���."><? echo $rooms[49]; ?></a></td>
</tr>

<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><a href="city.php?cp=1&got=1" onClick="return check_access();" class="menutop" title="����� ��������: 10 ���."><? echo $rooms[50]; ?></a></td>
</tr>

<? if($user['vip']==0){?>
<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><a href="?etaz=1" onClick="return check_access();" class="menutop" title="����� ��������: 3 ���.
������ � ������� <? echo $count['etaz1'] ?> ���.">���. ���� 1</a></td>
</tr>
<? }else{ ?>
<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><small><b>���. ���� 1</b></small></td>
</tr>
<? }

if($user['vip']>0){ ?>

<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><a href="?etaz=4" onClick="return check_access();" class="menutop" title="����� ��������: 3 ���.
������ � ������� <? echo $count['etaz1'] ?> ���.">����-VIP</a></td>
</tr>
<? }else{ ?>
<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><small><b>����-VIP</b></small></td>
</tr>
<? } ?>
</table>
</td>
</tr>
</table>
<!-- <br /><span class="menutop"><nobr>���������</nobr></span>-->
</td>
</tr>
</table>
<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px; white-space: nowrap;"></div>
<script language="javascript" type="text/javascript">
var progressEnd = 64;       // set to number of progress <span>'s.
var progressColor = '#00CC00';  // set to progress bar color
var mtime = parseInt('14');
if (!mtime || mtime<=0) {mtime=0;}
var progressInterval = Math.round(mtime*1000/progressEnd);  // set to time between updates (milli-seconds)
var is_accessible = true;
var progressAt = progressEnd;
var progressTimer;
function progress_clear() {
progressAt = 1;
is_accessible = false;
set_moveto(true);
}
function progress_update() {
progressAt++;
//if (progressAt > progressEnd) progress_clear();
if (progressAt > progressEnd) {
is_accessible = true;
if (window.solo_store && solo_store) { solo(solo_store, ""); } // go to stored
set_moveto(false);
} else {
if( !( progressAt % 2 ) )
document.getElementById('MoveLine').style.left = progressAt - 64;
progressTimer = setTimeout('progress_update()',progressInterval);
}
}
function set_moveto (val) {
document.getElementById('moveto').disabled = val;
if (document.getElementById('bmoveto')) {
document.getElementById('bmoveto').disabled = val;
}
}
function progress_stop() {
clearTimeout(progressTimer);
progress_clear();
}
function check(it) {
return is_accessible;
}
function check_access () {
return is_accessible;
}
function ch_counter_color (color) {
/*  progressColor = color;
for (var i = 1; i <= progressAt; i++) {
document.getElementById('progress'+i).style.backgroundColor = progressColor;
}*/
}
if (mtime>0) {
progress_clear();
progress_update();
}
</script>
</HTML>
</TD></TR>
<TR><TD colspan=2>
<NOBR>
������: <? echo $user['money'] ?> ��.<BR><BR>
<B>������</B>
</NOBR></TR></TD></TABLE>
</TD>
</TABLE>
</BODY>
</HTML>
<? } ?>


<?
//����� � �������

if (!@$_GET["changearenda"] && (($obshaga['etaz']>0 && $_GET['etaz'] == "" && $_GET['room'] == "" && $user['vip']=="0") || ($obshaga["etaz"] && $_GET['etaz'] == "0" && $user['vip']==0) || $obshaga['balanse']<0 && $user['vip']=="0")) {
?>

<HTML><HEAD>
<link rel=stylesheet type="text/css" href="<?=IMGBASE?>/i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<SCRIPT src='<?=IMGBASE?>/i/commoninf.js'></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="<?=IMGBASE?>/i/sl2.27.js?1"></SCRIPT>
<STYLE>
.pH3            { COLOR: #8f0000;  FONT-FAMILY: Arial;  FONT-SIZE: 12pt;  FONT-WEIGHT: bold; }
</STYLE>
<SCRIPT>
var sd4 = "869518824";
function fastshow(dsc, dx, dy) { top.fullfastshow(document, mmoves, window.event, dsc, dx, dy); }
function hideshow() { top.fullhideshow(mmoves); }
</SCRIPT>
</HEAD>
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=e2e0e0>
<div id=hint4 class=ahint></div>
<TABLE width=100%><TD valign=top height=100%>
<TABLE width=100% cellspacing=0 cellpadding=4 bgcolor=d2d2d2>
<FORM METHOD=POST name=F1>
<tr><td class='pH3'>&nbsp;&nbsp;&nbsp;&nbsp;���������</FONT></td><td align=right valign=top><? echo fullnick($user); ?>&nbsp;</td></tr></table>
<? if($mess != "") echo $mess."<BR>"; 
if (@$_GET["warning"]) echo "<b><font color=red>$_GET[warning]</font></b><br>";
?>
<TABLE cellpadding=0 cellspacing=0>
<TR><TD>�������: ��� ����������. ��� ������������. ��� �������� ���������. ������������ ����� � ��������� �������� ����� ������ � ��������.</TD>
<TR><TD align=right><i>���������</i></TD></TR></TABLE><br>
<?
  if ($obshaga["etaz"]>0) echo $title."<br>";
?>                             <!-- H:i:s-->
������ ������: <? echo date("d.m.Y", $obshaga['date_begin']) ?><BR>
 <?// H:i:s 
if ($obshaga["etaz"]>0) echo "�������� ��: ".date("d.m.Y", time()+round($obshaga['balanse'] / $coust_day)*86400) ?> (������ <? if($obshaga['balanse'] < 0) echo "<font color=red>".number_format($obshaga['balanse'], 2, '.', '')."</font>"; else echo number_format($obshaga['balanse'], 2, '.', ''); ?> ��.) <IMG src="<?=IMGBASE?>/i/up.gif" width=11 height=11 title="��������" onClick="usescript('������ ������','obshaga.php', 'payarenda', '<? echo $obshaga['arenda'] ?>', '����� ������:<BR>', 1, '<INPUT type=hidden name=sd4 value='+sd4+'>')" style="cursor:hand"><BR>
<? if ($obshaga["etaz"]>0) { ?>
���� � ������: <? echo $coust ?> ��.<BR>
&nbsp;&bull; ������ �������: <? echo $mass ?> �����<BR>
&nbsp;&bull; ��������: <? echo $podarok ?> ��.<BR>
&nbsp&bull; ���� ��� ��������: <? echo $animal ?> <BR>
&nbsp&bull; �����<BR>

<BR>
<A href="/obshaga.php?closearenda=1" onClick="return confirm('�� �������, ��� ������ ���������� ������?')">���������� ������</A><BR>
<SMALL>
��� ������ ������, ��� ���� �� ������� ����������� � ��� ���������.<BR>
���� �������� ���������� ���. ���� � ��� ��� ���� ������ ��������, �� ����������� �� ����.<BR>
������� ������� �� ������������.<BR>
���� �� ������ �������� ������, �� ��� ���� ����������� � �� �� ������� ��������������� �������, ���� �� �������� ����.<BR>
</SMALL>
<div>&nbsp;</div>
<A href="/obshaga.php?changearenda=1">������� ������</A><BR>
<SMALL>
��� ����� ������ �� ����� ������� ������ ���� ����������� �����.<br>
���������� �����, ��������� � �������� �� ����� ������ �� ������ ��������� ���������� �������� ��� ���������� ����������� ���������.
<? } ?>
<!--<A href="/obshaga.php?changelist=1">������� ������</A><BR>
<SMALL>
��� ����� ������ �� ����� ������� ������ ���� ����������� �����.<BR>
����� ������, ���������� ������ �� ��������� ������ ���������.<BR>
���������� �����, ��������� � �������� �� ����� ������ �� ������ ��������� ���������� �������� ��� ���������� ����������� ���������.<BR>
</SMALL>-->

</TD><TD valign=top width=200><TABLE cellpadding=0 cellspacing=0 width=100%><TR><TD width=100%><SPAN></SPAN><TD><HTML>
<link href="<?=IMGBASE?>/i/move/design6.css" rel="stylesheet" type="text/css"><script language="javascript" type="text/javascript">
function fastshow2 (content, eEvent ) {
var el = document.getElementById("mmoves");
eEvent = eEvent || window.event;
if( !eEvent )
return;
var o = eEvent.target || eEvent.srcElement;
if (content!='' && el.style.visibility != "visible") {el.innerHTML = '<small>'+content+'</small>';}
var x = window.event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft - el.offsetWidth + 5;
var y = window.event.clientY + document.documentElement.scrollTop + document.body.scrollTop+20;
if (x + el.offsetWidth + 3 > document.body.clientWidth + document.body.scrollLeft) { x=(document.body.clientWidth + document.body.scrollLeft - el.offsetWidth - 5); if (x < 0) {x=0}; }
if (y + el.offsetHeight + 3 > document.body.clientHeight  + document.body.scrollTop) { y=(document.body.clientHeight + document.body.scrollTop - el.offsetHeight - 3); if (y < 0) {y=0}; }
if (x<0) {x=0;}
if (y<0) {y=0;}
el.style.left = x + "px";
el.style.top  = y + "px";
if (el.style.visibility != "visible") {
el.style.visibility = "visible";
}
}
function hideshow () {
document.getElementById("mmoves").style.visibility = 'hidden';
}
</script>
<table  border="0" cellpadding="0" cellspacing="0">
<tr align="right" valign="top">
<td>


</td>
<td>

<TABLE height=15 border="0" cellspacing="0" cellpadding="0">
<TR>
<TD rowspan=3 valign="bottom"><a href="?rnd=0.0448253387343236"><img src="<?=IMGBASE?>/i/move/rel_1.gif" width="15" height="16" alt="��������" border="0" /></a></TD>
<TD colspan="3"><img src="<?=IMGBASE?>/i/move/navigatin_462.gif" width="80" height="4" /></TD>
</TR>
<TR>
<TD><IMG src="<?=IMGBASE?>/i/move/navigatin_481.gif" width="9" height="8"></TD>
<TD width=64 bgcolor=black><DIV class="MoveLine"><IMG src="<?=IMGBASE?>/i/move/wait2.gif" id="MoveLine" class="MoveLine"></DIV></TD>
<TD><IMG src="<?=IMGBASE?>/i/move/navigatin_50.gif" width="7" height="8"></TD>
</TR>
<TR>
<TD colspan="3"><IMG src="<?=IMGBASE?>/i/move/navigatin_tt1_532.gif" width="80" height="5"></TD>
</TR>
</TABLE>


<table  border="0" cellspacing="0" cellpadding="0">
<tr>
<td nowrap="nowrap" id="moveto">
<table width="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#DEDEDE">

<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><a href="city.php?strah=1&got=1" onClick="return check_access();" class="menutop" title="����� ��������: 10 ���."><? echo $rooms[49]; ?></a></td>
</tr>

<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><a href="city.php?cp=1&got=1" onClick="return check_access();" class="menutop" title="����� ��������: 10 ���."><? echo $rooms[50]; ?></a></td>
</tr>

<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><a href="?etaz=1" onClick="return check_access();" class="menutop" title="����� ��������: 3 ���.
������ � ������� <? echo $count['etaz1'] ?> ���.">���. ���� 1</a></td>
</tr>

<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><font size=1><b>����-VIP</b></font></td>
</tr>

</table>
</td>
</tr>
</table>
<!-- <br /><span class="menutop"><nobr>���������</nobr></span>-->
</td>
</tr>
</table>
<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px; white-space: nowrap;"></div>
<script language="javascript" type="text/javascript">
var progressEnd = 64;       // set to number of progress <span>'s.
var progressColor = '#00CC00';  // set to progress bar color
var mtime = parseInt('0');
if (!mtime || mtime<=0) {mtime=0;}
var progressInterval = Math.round(mtime*1000/progressEnd);  // set to time between updates (milli-seconds)
var is_accessible = true;
var progressAt = progressEnd;
var progressTimer;
function progress_clear() {
progressAt = 1;
is_accessible = false;
set_moveto(true);
}
function progress_update() {
progressAt++;
//if (progressAt > progressEnd) progress_clear();
if (progressAt > progressEnd) {
is_accessible = true;
if (window.solo_store && solo_store) { solo(solo_store, ""); } // go to stored
set_moveto(false);
} else {
if( !( progressAt % 2 ) )
document.getElementById('MoveLine').style.left = progressAt - 64;
progressTimer = setTimeout('progress_update()',progressInterval);
}
}
function set_moveto (val) {
document.getElementById('moveto').disabled = val;
if (document.getElementById('bmoveto')) {
document.getElementById('bmoveto').disabled = val;
}
}
function progress_stop() {
clearTimeout(progressTimer);
progress_clear();
}
function check(it) {
return is_accessible;
}
function check_access () {
return is_accessible;
}
function ch_counter_color (color) {
/*  progressColor = color;
for (var i = 1; i <= progressAt; i++) {
document.getElementById('progress'+i).style.backgroundColor = progressColor;
}*/
}
if (mtime>0) {
progress_clear();
progress_update();
}
</script>
</HTML>
</TD></TR>
<TR><TD colspan=2>
<NOBR>
������: <? echo $user['money'] ?> ��.<BR><BR>
<B>������</B>
</NOBR></TR></TD></TABLE>
</TD>
</TABLE>

</BODY>
</HTML>
<? } ?>

<!-- ����� -->
<?
if($obshaga['balanse'] >= 0 && ($obshaga['etaz'] == "1" || $obshaga['etaz'] == "2" || $obshaga['etaz'] == "3") && $_GET['etaz'] != "" &&  $_GET['etaz'] != "0" && $user['vip']==0 || $_GET['room'] != "" && $user['vip']==0 || $user['vip']>0 && $user['room']==104) {?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="<?=IMGBASE?>/i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<SCRIPT src='<?=IMGBASE?>/i/commoninf.js'></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="<?=IMGBASE?>/i/sl2.27.js?1"></SCRIPT>
<STYLE>
.pH3            { COLOR: #8f0000;  FONT-FAMILY: Arial;  FONT-SIZE: 12pt;  FONT-WEIGHT: bold; }
</STYLE>
<SCRIPT>
var sd4 = "869518824";
function fastshow(dsc, dx, dy) { top.fullfastshow(document, mmoves, window.event, dsc, dx, dy); }
function hideshow() { top.fullhideshow(mmoves); }
</SCRIPT>
</HEAD>
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=e2e0e0>
<div id=hint4 class=ahint></div>
<TABLE width=100%><TD valign=top height=100%>
<TABLE width=100% cellspacing=0 cellpadding=4 bgcolor=d2d2d2>
<FORM METHOD=POST name=F1>
<tr><td class='pH3'>&nbsp;&nbsp;&nbsp;&nbsp;<? echo $title_room ?></FONT></td><td align=right valign=top><? echo fullnick($user); ?> &nbsp;</td></tr></table>
<?
if($mess!="")
    echo $mess."<br>";
if($_GET['etaz']=="4" && $user['vip']>0 && $user['room']=="104" || $_GET['room']=="7" && $user['vip']>0 && $user['room']=="104")
{
echo    "&nbsp;&bull; ������ �������: ".$mass." �����<BR>";
echo "&nbsp;&bull; ��������: ".$podarok." ��.<BR>";
echo "&nbsp&bull; ���� ��� ��������: ".$animal." <BR>";
echo "&nbsp&bull; �����<BR>";
}
//�������
if(($_GET['room']=="1" && $obshaga['etaz']=="1" && $user['room']=="101" || $_GET['room']=="1" && $obshaga['etaz']=="2" && $user['room']=="102" || $_GET['room']=="1" && $obshaga['etaz']=="3" && $user['room']=="103") || ($_GET['etaz']=="1" && $obshaga['etaz']=="1" && $user['room']=="101" && !@$_GET['room'] || $_GET['etaz']=="2" && $obshaga['etaz']=="2" && $user['room']=="102" && !@$_GET['room'] || $_GET['etaz']=="3" && $obshaga['etaz']=="3" && $user['room']=="103" && !@$_GET['room']) || $_GET['room']=="1" && $user['vip']>0 && $user['room']=="104") {
?>
�� ���������� � ����� �������. ������, ��� �� ������ - �������� ������.<BR>
�� ������ �������� ������ ��� ������ ����� ������� �� ����� 10000 ��������.
<TEXTAREA rows=15 style='width: 90%;' name='notes'><? echo $obshaga['text'] ?></TEXTAREA><BR>
<INPUT type='hidden' name='room' value='1'>
<INPUT type='submit' name='savenotes' value='��������� �����'>
<? }
//������
if($_GET['room']=="2" && $user['room']=="101" && $obshaga['etaz'] == "1" ||  $_GET['room']=="2" && $user['room']=="102" && $obshaga['etaz'] == "2" || $_GET['room']=="2" && $user['room']=="103" && $obshaga['etaz'] == "3" || $_GET['room']=="2" && $user['room']=="104" && $user['vip']>0) {
?>
������: <? echo $skoka ?>/ <? echo $mass ?><BR><BR>
<TABLE width=100% cellpadding=0 cellspacing=0><TR bgcolor=#A0A0A0>
<TD width=50%>� �������</TD><TD>� �������</TD>
<TR>
<TD valign=top><!--������-->
<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=2 BGCOLOR=A5A5A5>
<?
//����������� �������

$data = mq("SELECT * FROM `obshagastorage` WHERE `pers` = '{$_SESSION['uid']}' AND gift=0 order by id desc");
while($it = mysql_fetch_array($data)) {
    $row=unserialize($it["item"]);
    //mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$it['id_it']}' LIMIT 1;"));
    $row['count'] = 1;
    if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
    echo "<TR bgcolor={$color}><TD align=center width=20%><IMG SRC=\"i/sh/{$row['img']}\" BORDER=0><BR>";
    echo "<A HREF=?back=".$it['id']."&id_item=".$it['id_it']."&room=2>� ���������</A><br></td><td>";
    showitem ($row);
    echo "</TD></TR>";
}
?>
</TABLE>
</TD><TD valign=top><!--������-->
<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=2 BGCOLOR=A5A5A5>
<?
//����������� ���������
$data = mq("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0  and gift=0 and `setsale`=0 and (dategoden=0 || name LIKE '%������%') and name<>'' order by `update` desc");
while($row = mysql_fetch_array($data)) {
    $row['count'] = 1;
    if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
    echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"i/sh/{$row['img']}\" BORDER=0>";
    echo "<BR><A HREF=?add=".$row['id']."&room=2>� ������</A></TD>";
    echo "<TD valign=top>";
    showitem ($row);
    echo "</TD></TR>";
    }
    echo "</table>";
    echo "</TD>";
    echo "</TR></TABLE>";
}
//��������
if($_GET['room']=="6" && $user['room']=="101" && $obshaga['etaz'] == "1" ||  $_GET['room']=="6" && $user['room']=="102" && $obshaga['etaz'] == "2" || $_GET['room']=="6" && $user['room']=="103" && $obshaga['etaz'] == "3" || $_GET['room']=="6" && $user['room']=="104" && $user['vip']>0) {
?>
������: <? echo $skoka_p ?>/ <? echo $podarok ?><BR><BR>
<TABLE width=100% cellpadding=0 cellspacing=0><TR bgcolor=#A0A0A0>
<TD width=50%>��� �������</TD><TD>� �������</TD>
<TR>
<TD valign=top><!--������-->
<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=2 BGCOLOR=A5A5A5>
<?
//����������� ��� �������
$data = mq("SELECT * FROM `obshagastorage` WHERE `pers` = '{$_SESSION['uid']}' and gift = 1 order by id desc");
while($it = mysql_fetch_array($data)) {
  $row=unserialize($it["item"]);
  //  $row = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$it['id_it']}' LIMIT 1;"));
    $row['count'] = 1;
    if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
    echo "<TR bgcolor={$color}><TD align=center width=20%><IMG SRC=\"i/sh/{$row['img']}\" BORDER=0><BR>";
    echo "<A HREF=?back=".$it['id']."&id_item=".$it['id_it']."&room=6>� ���������</A><br></td><td>";
    showitem ($row);
    echo "</TD></TR>";
}
?>
</TABLE>
</TD><TD valign=top><!--������-->
<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=2 BGCOLOR=A5A5A5>
<?
//����������� ���������
$data = mq("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND gift=1 and (dategoden=0 or dategoden>".time().") AND present != \"\" order by `update` desc;");
while($row = mysql_fetch_array($data)) {
    $row['count'] = 1;
    if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
    echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"i/sh/{$row['img']}\" BORDER=0>";
    echo "<BR><A HREF=?add=".$row['id']."&room=6>��� ������</A></TD>";
    echo "<TD valign=top>";
    showitem ($row);
    echo "</TD></TR>";
    }
    echo "</table>";
    echo "</TD>";
    echo "</TR></TABLE>";
}


if($_GET['room']=="8" && $user['room']=="102" && $obshaga['etaz'] == "2" || $_GET['room']=="8" && $user['room']=="103" && $obshaga['etaz'] == "3" || $_GET['room']=="8" && $user['room']=="104" && $user['vip']>0) {
?>
������: <? echo $skoka_a ?> / <? echo $animal?><BR><BR>
<TABLE width=100% cellpadding=0 cellspacing=0><TR bgcolor=#A0A0A0>
<TD width=50%>� ������</TD><TD>��� ����</TD>
<TR>
<TD valign=top>
<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=2 BGCOLOR=A5A5A5>
<?
//����������� ��� �������
$r = mq("SELECT obshagaanimals.id, users.login, users.sex, users.shadow FROM `obshagaanimals` left join users on obshagaanimals.animal=users.id WHERE `pers` = '{$_SESSION['uid']}'");
$i=0;
while($rec = mysql_fetch_assoc($r)) {
if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
  echo "<TR bgcolor={$color}><TD align=center width=20%><b>$rec[login]</b><br><br>";
  echo "<A HREF=\"?takeanimal=".$rec['id']."&room=8\">�������</A><br></td><td>";
  echo "<img src=\"".IMGBASE."/i/shadow/$rec[sex]/$rec[shadow]\"></TD></TR>";
}
?>
</TABLE>
</TD><TD valign=top><!--������-->
<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=2 BGCOLOR=A5A5A5>
<?
//����������� �����
  if ($user["zver_id"]) {
    $rec=mqfa("select login, sex, shadow from users where id='$user[zver_id]'");
    echo "<TR bgcolor=#C7C7C7><TD align=center style='width:150px'>";
    echo "<b>$rec[login]</b><BR><br>";
    if ($skoka_a<$animal) echo "<A HREF=?tocage=1&room=8>�������� � ������</A></TD>";
    echo "<TD valign=top><img src=\"".IMGBASE."/i/shadow/$rec[sex]/$rec[shadow]\">";
    echo "</TD></TR>";
  }
  echo "</table>";
  echo "</TD>";
  echo "</TR></TABLE>";
}


//���
if($_GET['room']=="4" && $user['room']=="101" && $obshaga['etaz'] == "1" && $obshaga['sleep'] == "0" ||  $_GET['room']=="4" && $user['room']=="102" && $obshaga['etaz'] == "2" && $obshaga['sleep'] == "0" || $_GET['room']=="4" && $user['room']=="103" && $obshaga['etaz'] == "3" && $obshaga['sleep'] == "0" || $_GET['room']=="4" && $user['room']=="104" && $user['vip']>0 && $obshaga['sleep'] == "0") {
?>
<table>
<tr><td valign="top">
�� ������ �������, ����� � ������� ����.<BR>
�� ����� ��� ��� ��������� ������� �� ��� ������������������. ��� �������� ���, ��������, ���������, ��� � �����.
��� �� ������ �� ��������� ��������� � ������������ ������ �������������<BR><BR>
���������:<br><B>�� �����������</B><br><br><A href="/obshaga.php?to_sleep=1&room=4" >������</A><BR>
</SMALL>
</td>
<td><img src="<?=IMGBASE?>i/rooms/100_room.jpg"></td>
</tr></table>
<? }
if($_GET['room']=="4" && $user['room']=="101" && $obshaga['etaz'] == "1" && $obshaga['sleep'] ||  $_GET['room']=="4" && $user['room']=="102" && $obshaga['etaz'] == "2" && $obshaga['sleep'] || $_GET['room']=="4" && $user['room']=="103" && $obshaga['etaz'] == "3" && $obshaga['sleep'] || $_GET['room']=="4" && $user['room']=="104" && $user['vip']>0 && $obshaga['sleep'])  {
?>
�� ������ �������, ����� � ������� ����.<BR>
�� ����� ��� ��� ��������� ������� �� ��� ������������������. ��� �������� ���, ��������, ���������, ��� � �����.<BR>
��� �� ������ �� ��������� ��������� � ������������ ������ �������������<BR><BR>

<DIV style='background-color: #A0A0A0'>
���������: <B>�� �����</B><BR>
<A href="/obshaga.php?to_awake=1&room=4" >����������</A><BR>
</DIV>
<? } ?>

</TD><TD valign=top width=200><TABLE cellpadding=0 cellspacing=0 width=100%><TR><TD width=100%><SPAN></SPAN><TD><HTML>
<link href="<?=IMGBASE?>/i/move/design6.css" rel="stylesheet" type="text/css"><script language="javascript" type="text/javascript">
function fastshow2 (content, eEvent ) {
var el = document.getElementById("mmoves");
eEvent = eEvent || window.event;
if( !eEvent )
return;
var o = eEvent.target || eEvent.srcElement;
if (content!='' && el.style.visibility != "visible") {el.innerHTML = '<small>'+content+'</small>';}
var x = window.event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft - el.offsetWidth + 5;
var y = window.event.clientY + document.documentElement.scrollTop + document.body.scrollTop+20;
if (x + el.offsetWidth + 3 > document.body.clientWidth + document.body.scrollLeft) { x=(document.body.clientWidth + document.body.scrollLeft - el.offsetWidth - 5); if (x < 0) {x=0}; }
if (y + el.offsetHeight + 3 > document.body.clientHeight  + document.body.scrollTop) { y=(document.body.clientHeight + document.body.scrollTop - el.offsetHeight - 3); if (y < 0) {y=0}; }
if (x<0) {x=0;}
if (y<0) {y=0;}
el.style.left = x + "px";
el.style.top  = y + "px";
if (el.style.visibility != "visible") {
el.style.visibility = "visible";
}
}
function hideshow () {
document.getElementById("mmoves").style.visibility = 'hidden';
}
</script>
<table  border="0" cellpadding="0" cellspacing="0">
<tr align="right" valign="top">
<td>


</td>
<td>

<TABLE height=15 border="0" cellspacing="0" cellpadding="0">
<? //���� 1
if($user['room'] == "101"){
?>
<TR>
<TD rowspan=3 valign="bottom"><a href="obshaga.php?etaz=1"><img src="<?=IMGBASE?>/i/move/rel_1.gif" width="15" height="16" alt="��������" border="0" /></a></TD>
<TD colspan="3"><img src="<?=IMGBASE?>/i/move/navigatin_462.gif" width="80" height="4" /></TD>
</TR>
<? }
//���� 2
if($user['room'] == "102"){
?>
<TR>
<TD rowspan=3 valign="bottom"><a href="obshaga.php?etaz=2"><img src="<?=IMGBASE?>/i/move/rel_1.gif" width="15" height="16" alt="��������" border="0" /></a></TD>
<TD colspan="3"><img src="<?=IMGBASE?>/i/move/navigatin_462.gif" width="80" height="4" /></TD>
</TR>
<? }
//���� 3
if($user['room'] == "103"){
?>
<TR>
<TD rowspan=3 valign="bottom"><a href="obshaga.php?etaz=3"><img src="<?=IMGBASE?>/i/move/rel_1.gif" width="15" height="16" alt="��������" border="0" /></a></TD>
<TD colspan="3"><img src="<?=IMGBASE?>/i/move/navigatin_462.gif" width="80" height="4" /></TD>
</TR>
<? }
//���� VIP
if($user['room'] == "104"){
?>
<TR>
<TD rowspan=3 valign="bottom"><a href="obshaga.php?etaz=4"><img src="<?=IMGBASE?>/i/move/rel_1.gif" width="15" height="16" alt="��������" border="0" /></a></TD>
<TD colspan="3"><img src="<?=IMGBASE?>/i/move/navigatin_462.gif" width="80" height="4" /></TD>
</TR>
<? } ?>
<TR>
<TD><IMG src="<?=IMGBASE?>/i/move/navigatin_481.gif" width="9" height="8"></TD>
<TD width=64 bgcolor=black><DIV class="MoveLine"><IMG src="<?=IMGBASE?>/i/move/wait2.gif" id="MoveLine" class="MoveLine"></DIV></TD>
<TD><IMG src="<?=IMGBASE?>/i/move/navigatin_50.gif" width="7" height="8"></TD>
</TR>
<TR>
<TD colspan="3"><IMG src="<?=IMGBASE?>/i/move/navigatin_tt1_532.gif" width="80" height="5"></TD>
</TR>
</TABLE>


<table  border="0" cellspacing="0" cellpadding="0">
<tr>
<td nowrap="nowrap" id="moveto">
<table width="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#DEDEDE">
<?
//�������� �� 1��
if($user['room']=="101"){
    if($obshaga['sleep']=="0") {?>
<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><a href="obshaga.php?etaz=0" onClick="return check_access();" class="menutop" title="����� ��������: 3 ���.
������ � ������� <? $count['obshaga'] ?> ���.">���������</a></td>
</tr>
<? if($obshaga['etaz']=="2" || $obshaga['etaz']=="3"){ ?>
<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><a href="?etaz=2" onClick="return check_access();" class="menutop" title="����� ��������: 3 ���.
������ � ������� <? $count['etaz2'] ?> ���.">���. ���� 2</a></td>
</tr>
<? }
else {
?>
<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><font size="1"><b>���. ���� 2</b></font></td>
<?
}
} else{?>
<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><font size="1"><b>���������</b></font></td>
</tr>
<? }
}
//�������� �� 2��
if($user['room']=="102"){
    if($obshaga['sleep']=="0") {?>
<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><a href="obshaga.php?etaz=1" onClick="return check_access();" class="menutop" title="����� ��������: 3 ���.
������ � ������� <? $count['obshaga'] ?> ���.">���. ���� 1</a></td>
</tr>
<? if($obshaga['etaz']=="3"){ ?>
<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><a href="?etaz=3" onClick="return check_access();" class="menutop" title="����� ��������: 3 ���.
������ � ������� <? $count['etaz2'] ?> ���.">���. ���� 3</a></td>
</tr>
<? }
else {
?>
<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><font size="1"><b>���. ���� 3</b></font></td>
<?
}
} else{?>
<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><font size="1"><b>���. ���� 1</b></font></td>
</tr>
<? }
}
//�������� �� 3��
if($user['room']=="103"){
    if($obshaga['sleep']==0) {?>
<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><a href="obshaga.php?etaz=2" onClick="return check_access();" class="menutop" title="����� ��������: 3 ���.
������ � ������� <? $count['etaz2'] ?> ���.">���. ���� 2</a></td>
</tr>
<? }
else { ?>
<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><font size="1"><b>���. ���� 2</b></font></td>
</tr>
<? }
}
if($user['room']=="104"){
    if($obshaga['sleep']==0) {?>
<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><a href="obshaga.php?etaz=0" onClick="return check_access();" class="menutop" title="����� ��������: 3 ���.
������ � ������� <? $count['etaz2'] ?> ���.">���������</a></td>
</tr>
<? }
else { ?>
<tr>
<td bgcolor="#D3D3D3"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" /></td>
<td bgcolor="#D3D3D3" nowrap><font size="1"><b>���������</b></font></td>
</tr>
<? }
}?>

</tr>
</table>
</td>
</tr>
</table>
<!-- <br /><span class="menutop"><nobr>���. ���� 1</nobr></span>-->
</td>
</tr>
</table>
<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px; white-space: nowrap;"></div>
<script language="javascript" type="text/javascript">
var progressEnd = 64;       // set to number of progress <span>'s.
var progressColor = '#00CC00';  // set to progress bar color
var mtime = parseInt('3');
if (!mtime || mtime<=0) {mtime=0;}
var progressInterval = Math.round(mtime*1000/progressEnd);  // set to time between updates (milli-seconds)
var is_accessible = true;
var progressAt = progressEnd;
var progressTimer;
function progress_clear() {
progressAt = 1;
is_accessible = false;
set_moveto(true);
}
function progress_update() {
progressAt++;
//if (progressAt > progressEnd) progress_clear();
if (progressAt > progressEnd) {
is_accessible = true;
if (window.solo_store && solo_store) { solo(solo_store, ""); } // go to stored
set_moveto(false);
} else {
if( !( progressAt % 2 ) )
document.getElementById('MoveLine').style.left = progressAt - 64;
progressTimer = setTimeout('progress_update()',progressInterval);
}
}
function set_moveto (val) {
document.getElementById('moveto').disabled = val;
if (document.getElementById('bmoveto')) {
document.getElementById('bmoveto').disabled = val;
}
}
function progress_stop() {
clearTimeout(progressTimer);
progress_clear();
}
function check(it) {
return is_accessible;
}
function check_access () {
return is_accessible;
}
function ch_counter_color (color) {
/*  progressColor = color;
for (var i = 1; i <= progressAt; i++) {
document.getElementById('progress'+i).style.backgroundColor = progressColor;
}*/
}
if (mtime>0) {
progress_clear();
progress_update();
}
</script>
</HTML>
</TD></TR>
<TR><TD colspan=2>
<NOBR>
������: <? echo $user['money'] ?> ��.<BR><BR>
<?
if($_GET['room']=="7" && $user['vip']>0 && $user['room']=="104" || $_GET['etaz']=="4" && $user['vip']>0 && $user['room']=="104")
{
    echo "<B>��������</B><BR>";
    echo "<A href=/obshaga.php?room=1>�������</A><BR>";
    echo "<A href=/obshaga.php?room=2>������</A><BR>";
    echo "<A href=/obshaga.php?room=6>��������</A><BR>";
    echo "<A href=/obshaga.php?room=4>�����</A><BR>";
    if ($obshaga['etaz']!="1") echo "<A href=/obshaga.php?room=8>������</A><BR>";
    }
//���� ��� 1�� � 2��
if(($_GET['room']=="1" && $obshaga['etaz'] == "1" && $user['room']=="101" || $_GET['room']=="1" && $obshaga['etaz'] == "2" && $user['room']=="102" || $_GET['room']=="1" && $obshaga['etaz'] == "3" && $user['room']=="103") || ($_GET['etaz']=="1" && $obshaga['etaz'] == "1" && $user['room']=="101" && !@$_GET['room'] || $_GET['etaz']=="2" && $obshaga['etaz'] == "2" && $user['room']=="102" && !@$_GET['room'] || $_GET['etaz']=="3" && $obshaga['etaz'] == "3" && $user['room']=="103" && !@$_GET['room']) || $_GET['room']=="1" && $user['vip']>0 && $user['room']=="104") {
if($user['vip']>0)
  echo "<A href=/obshaga.php?room=7>��������</a><BR>";
  echo "<B>�������</B><BR>";
  echo "<A href=/obshaga.php?room=2>������</A><BR>";
  echo "<A href=/obshaga.php?room=6>��������</A><BR>";
  echo "<A href=/obshaga.php?room=4>�����</A><BR>";
  if ($obshaga['etaz']!="1") echo "<A href=/obshaga.php?room=8>������</A><BR>";
}
if($_GET['room']=="2" && $obshaga['etaz'] == "1" && $user['room']=="101" || $_GET['room']=="2" && $obshaga['etaz'] == "2" && $user['room']=="102" || $_GET['room']=="2" && $obshaga['etaz'] == "3" && $user['room']=="103" || $_GET['room']=="2" && $user['vip']>0 && $user['room']=="104")
{
if($user['vip']>0) echo "<A href=/obshaga.php?room=7>��������</a><BR>";
    echo "<A href=/obshaga.php?room=1>�������</A><BR>";
    echo "<b>������</b><BR>";
    echo "<A href=/obshaga.php?room=6>��������</A><BR>";
        echo "<A href=/obshaga.php?room=4>�����</A><BR>";
    if ($obshaga['etaz']!="1") echo "<A href=/obshaga.php?room=8>������</A><BR>";
    }

if($_GET['room']=="6" && $obshaga['etaz'] == "1" && $user['room']=="101" || $_GET['room']=="6" && $obshaga['etaz'] == "2" && $user['room']=="102" || $_GET['room']=="6" && $obshaga['etaz'] == "3" && $user['room']=="103" || $_GET['room']=="6" && $user['vip']>0 && $user['room']=="104") {
  if($user['vip']>0) echo "<A href=/obshaga.php?room=7>��������</a><BR>";
  echo "<A href=/obshaga.php?room=1>�������</A><BR>";
  echo "<A href=/obshaga.php?room=2>������</A><BR>";
  echo "<b>��������</b><BR>";
  echo "<A href=/obshaga.php?room=4>�����</A><BR>";
  if ($obshaga['etaz']!="1") echo "<A href=/obshaga.php?room=8>������</A><BR>";
}
if($_GET['room']=="4" && $obshaga['etaz'] == "1" && $user['room']=="101" || $_GET['room']=="4" && $obshaga['etaz'] == "2" && $user['room']=="102" || $_GET['room']=="4" && $obshaga['etaz'] == "3" && $user['room']=="103" || $_GET['room']=="4" && $user['vip']>0 && $user['room']=="104") {
  if($user['vip']>0) echo "<A href=/obshaga.php?room=7>��������</a><BR>";
  echo "<A href=/obshaga.php?room=1>�������</A><BR>";
  echo "<A href=/obshaga.php?room=2>������</A><BR>";
  echo "<A href=/obshaga.php?room=6>��������</A><BR>";
  echo "<b>�����</b><br>";
  if ($obshaga['etaz']!="1") echo "<A href=/obshaga.php?room=8>������</A><BR>";
}

if($_GET['room']=="8" && $obshaga['etaz'] == "1" && $user['room']=="101" || $_GET['room']=="8" && $obshaga['etaz'] == "2" && $user['room']=="102" || $_GET['room']=="8" && $obshaga['etaz'] == "3" && $user['room']=="103" || $_GET['room']=="8" && $user['vip']>0 && $user['room']=="104") {
  if($user['vip']>0) echo "<A href=/obshaga.php?room=7>��������</a><BR>";
  echo "<A href=/obshaga.php?room=1>�������</A><BR>";
  echo "<A href=/obshaga.php?room=2>������</A><BR>";
  echo "<A href=/obshaga.php?room=6>��������</A><BR>";
  echo "<A href=/obshaga.php?room=4>�����</A><BR>";
  if ($obshaga['etaz']!="1") echo "<b>������</b><BR>";
}



if(($user['room']=="101" && ($obshaga['etaz']=="2" || $obshaga['etaz']=="3")) || ($user['room']=="102" && $obshaga['etaz']=="3"))
    echo "<b>�������</b><BR>";
?>
</NOBR></TR></TD></TABLE>
</TD>
</TABLE>
</BODY>
</HTML>
<? }?>

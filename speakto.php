<?php
    session_start();
    if ($_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    include "functions.php";
    include "startpodzemel.php";
    if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }

  $ros=mysql_query("SELECT * FROM `labirint` WHERE `user_id`='{$_SESSION['uid']}'");
  $mir=mysql_fetch_array($ros);
  $mesto = $mir['location'];
  $vektor = $mir['vector'];
  $glava = $mir['glava'];
  if ($mesto==$_GET["speak"]-1) {
    $pl=mqfa1("select n$_GET[speak] from podzem3 where  `glava`='".$mir['glava']."' and `name`='$mir[name]'");
    if (strpos($pl,"c")==0) $char=str_replace("c","",$pl);
  }
  if (!@$char) {
    header("location: canalizaciya.php");
    die;
  }
  include "podzem/chardata.php";
  if ($char==1) {
    $st=mqfa1("select step from quests where user='$user[id]' and quest=11");
    if ($st>10) $char=3;
    if ($st>100) $char=4;
    if ($st>500) $char=5;
  }
  if ($char==2) {
    $st=mqfa1("select step from quests where user='$user[id]' and quest=14");
    if ($st>10) $char=6;
    if ($st>100) $char=7;
    if ($st>500) $char=8;
  }
  $speakto=$chardata[$char];
  if (!@$_GET["step"]) $step=1; else $step=$_GET["step"];
  if ($char==1 || $char==3 || $char==4 || $char==5) {
    if ($step==1) {
      $speach="����������, ������!";
      $answers=array("2"=>"�� �������� �� ���, ������ ������?", "3"=>"�������� ��� ��� ���� � ������.", "5"=>"� ������ �������, ����� ���� �����?");
    }
    if ($step==2) {
      $i=mqfa1("select id from inventory where owner='$user[id]' and (prototype=1780 or prototype=1779)");
      if (!$i) {
        $speach="������, ������ �� �� ������? ��� ���� ������ � �������, � �������:
        �� ������� ������� �������, �� ������ �� ������, ��� ���� �����, ������ ������.";
        takeshopitem(1779, "shop", "����������", 1);
        takeshopitem(1780, "shop", "����������", 1);
      } else {
        $speach="��� ������ � ��� �������.";
      }
    }
    if ($step==3) {
      $speach="������ - ��� ����� ������� ����, ���� ����� ������ � ������ ��� � ������� ������. ����� �������� ����, ��� ����� ������ ���� �������.
      � ��� �� ������� �������� �������� �������.";
      $answers=array("4"=>"���� �� �� ���������?", "2"=>"�� �������� �� ���, ������ ������?", "5"=>"� ������ �������, ����� ���� �����?");
    }
    if ($step==4) {
      $speach="� ���� ���� ��� �������. � ��� �� ������, ���� � �� ���, �� ���� ��� ������ ���� �����������: ";
      $r=mq("select users.login from quests left join users on users.id=quests.user where quests.quest=6 order by quests.step desc limit 0, 10");
      $i=0;
      $prizes=array();
      while ($rec=mysql_fetch_assoc($r)) $prizes[$rec["login"]]=1;
      $r=mq("select users.login, sum(step) as ss from quests left join users on users.id=quests.user where (quests.quest=6 or quests.quest=5) group by quests.user order by ss desc limit 0, 10");
      while ($rec=mysql_fetch_assoc($r)) $prizes[$rec["login"]]=1;
      foreach ($prizes as $k=>$v) $prizes2[]=$k;
      shuffle($prizes2);
      foreach ($prizes2 as $k=>$v) {
        $i++;
        if ($i>1) $speach.=", ";
        $speach.=$v;
      }
      $speach.=".";
      $answers=array("2"=>"�� �������� �� ���, ������ ������?", "5"=>"� ������ �������, ����� ���� �����?");
    }
    if ($step==5) {
      $cnt=mqfa("select id, koll from inventory where owner='$user[id]' and name='����' and type=200");
      if ($cnt) {
        $speach="�������!";
        addqueststep($user["id"],11,$cnt["koll"]);
        $st=mqfa1("select step from quests where user='$user[id]' and quest=11");
        if ($st>10) $char=3;
        if ($st>100) $char=4;
        if ($st>500) $char=5;
        $speakto=$chardata[$char];
      }
      else $speach="����� ������� ������, ����� � �������!";
      mq("delete from inventory where id='$cnt[id]'");
      $answers=array("2"=>"�� �������� �� ���, ������ ������?", "3"=>"�������� ��� ��� ���� � ������.");
    }
    
  }
  if ($char==2 || $char==6 || $char==7 || $char==8) {
    $bye="����, ������!";
    if ($step==1) {
      $speach="������, ������!";
      $answers=array("2"=>"� ��� �������� ������, �� ����������?", "5"=>"�������� ��� ��� ���� � ������.", "7"=>"� ��� �������� �������, ����� ���� �����?");
    }
    if ($step==2) {
      $speach="����������, ������, ����� ������ ��������. ������� ����� ��������, ����� ������ ���������.";
      $cnt=mqfa1("select koll from inventory where owner='$user[id]' and name='��������'");
      if ($cnt>0) {
        $answers=array("3"=>"� ��� ���� $cnt ��. ��������.","1"=>"� ���������.");
      } else {
        $answers=array("4"=>"� ���� ��� ��������.");
      }
    }
    if ($step==3) {
      $cnt=mqfa("select id, koll from inventory where owner='$user[id]' and name='��������'");
      if ($cnt["koll"]>=100) {
        include_once("questfuncs.php");
        $totake=$cnt["koll"]-($cnt["koll"]%100);
        $speach="�������, ������, ����� ������� $totake �������� � ���� ".($totake/100)." ���������.";
        $i=0;
        while ($i<$totake/100) {
          takeitem(13,1,1);
          $i++;
        }
        if ($cnt["koll"]%100==0) mq("delete from inventory where id='$cnt[id]'");
        else mq("update inventory set koll=koll-$totake where id='$cnt[id]'");
      } else {
        $speach="����, ������. ����� ������ ��������� �� ����� ��������.";
      }
      $answers=array("5"=>"�������� ��� ��� ���� � ������.");
    }
    if ($step==4) {
      $speach="��� �������, ������! ����� �� ��� ��������� ������ ���.";
      $answers=array("5"=>"�������� ��� ��� ���� � ������.", "7"=>"� ��� �������� �������, ����� ���� �����?");
    }
    if ($step==5) {
      $speach="������ ����� ������� ����, ������� ������, ����� ������. ��� ����� ������ ����, ������� ����, ������.";
      $answers=array("6"=>"� ��� ������� ���� ����?", "2"=>"� ��� �������� ������, �� ����������?", "7"=>"� ��� �������� �������, ����� ���� �����?");
    }
    if ($step==6) {
      $speach="������ ����� ������� ������: ";
      $r=mq("select users.login, quests.step from quests left join users on users.id=quests.user where quests.quest=5 order by quests.step desc limit 0, 10");
      $i=0;
      while ($rec=mysql_fetch_assoc($r)) {
        $i++;
        if ($i>1) $speach.=", ";
        $speach.=" $rec[login] ($rec[step])";
      }
      $speach.=".";
      $answers=array("2"=>"� ��� �������� ������, �� ����������?", "7"=>"� ��� �������� �������, ����� ���� �����?");
    }
    if ($step==7) {
      $cnt=mqfa("select id, koll from inventory where owner='$user[id]' and name='������' and type=200");
      if ($cnt) {
        $speach="�������, ������!";
        addqueststep($user["id"],14,$cnt["koll"]);
        $st=mqfa1("select step from quests where user='$user[id]' and quest=14");
        if ($st>10) $char=6;
        if ($st>100) $char=7;
        if ($st>500) $char=8;
        $speakto=$chardata[$char];
        mq("delete from inventory where id='$cnt[id]'");      
      } else $speach="����� ������� �������, ����� ����� �������!";
      $answers=array("2"=>"� ��� �������� ������, �� ����������?", "5"=>"�������� ��� ��� ���� � ������.");
    }
  }
  if (!@$bye) $bye="�, �������, �����.";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link rel=stylesheet type="text/css" href="i/main.css">
<title></title>
</head>
<body bgcolor=e5e2d4>
<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
<td align="center" valign="top">


<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
<td width="20%" align="center" valign="top">
<?
  print $user['login'];
  echo showpersout($user["id"], 0, 1);
?>
</td>
<td align="60%" align="left" valign="top">


<table width="90%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" style="padding-left:20px;padding-right:20px"><H3 align="center" style="color:#000099"><?=$speakto["name"];?></H3>
<?
  echo "$speach<br><br>";
  foreach ($answers as $k=>$v) {
    echo "&bull; <a href=\"speakto.php?speak=$_GET[speak]&step=$k\">$v</a><br>";
  }
  echo "&bull; <a href=\"canalizaciya.php\">$bye</a><br>";
?></td>
  </tr>
</table>


</td>
<td width="20%" align="center" valign="top">
<?
echo $speakto["name"];
echo showpersout($speakto["id"],0,1);
?>

</td></tr></table>
</td></tr></table>
</body>
</html>
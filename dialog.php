<?php
  session_start();
  if ($_SESSION['uid'] == null) header("Location: index.php");
  include "connect.php";
  include "functions.php";
  if ($user["sex"]==0) {
    $a="а";
    $as="ась";
    $la="ла";
  } else {
    $a="";
    $as="ся";
    $la="";
  }
  if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }
  include "config/chardata.php";
  include_once "questfuncs.php";
  $char=$_GET["char"];
  $speakto=$chardata[$char];
  if ($chardata[$char]["room"]!=$user["room"] && $char!=3) {
    header("location:main.php");die;
  }
  
  if (@$chardata[$char]["x"] || $chardata[$char]["y"]) {
    $cparty=mqfa("select * from caveparties where user='$user[id]' and leader='$user[caveleader]'");
    if ($cparty["dir"]==0) $x1=$cparty["x"]-1; elseif ($cparty["dir"]==3) $x1=$cparty["x"]+1; else $x1=$cparty["x"];
    if ($cparty["dir"]==1) $y1=$cparty["y"]-1; elseif ($cparty["dir"]==3) $y1=$cparty["y"]+1; else $y1=$cparty["y"];
    if ($x1!=$chardata[$char]["x"] || $y1!=$chardata[$char]["y"] || $cparty["floor"]!=$chardata[$char]["floor"]) {
      header("location:main.php");die;
    }
  }
  if (!@$_GET["step"]) $step=1; else $step=$_GET["step"];

  if ($user["sex"]==1) {
    $a="";
  } else {
    $a="а";
  }
  if ($char==1) {

  }
  $char=(int)$char;
  include "dialogs/$char.php";
  if (!@$bye) $bye="Я, пожалуй, пойду.";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link rel=stylesheet type="text/css" href="i/main.css">
<title></title>
<?php if ($user['id'] != 99999) { ?>
    <script LANGUAGE='JavaScript'>
    document.oncontextmenu = test;
    function test() {
     return false
    }
    </SCRIPT>
<?php } ?>
</head>
<body bgcolor=#d7d7d7>
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
    <td align="left" style="padding-left:20px;padding-right:20px"><H3 align="center" style="color:#000099"><?=$speakto["roomname"];?></H3>
<?
  echo "<div style=\"text-align:justify\">$speach</div><br>";
  foreach ($answers as $k=>$v) {
    echo "&bull; <a href=\"dialog.php?char=$char&step=$k\">$v</a><br>";
  }
  if (@$speakto["workname"]) {
    $proc=floor($done/$speakto["steps"]*100);
    if ($proc>100) $proc=100;
    echo "<br><center><b>$speakto[workname]</b> (".($done>$speakto["steps"]?$speakto["steps"]:floor($done))."/$speakto[steps])<br>
    </center><br><div style=\"position:relative;width:300px;margin-left:auto;margin-right:auto\">
    <div style=\"color:#ffffff;font-weight:bold;position:absolute;left:20px;top:2px\">$proc %</div>
    <table cellspacing=0 cellpadding=0>
    <tr>
    ".($proc>0?"<td bgcolor=\"green\" height=20 width=".($proc*3)." style=\"font-size:1px\">&nbsp;</td>":"")."
    ".($proc<100?"<td bgcolor=\"red\" height=20 width=".((100-$proc)*3)." style=\"font-size:1px\">&nbsp;</td></tr>":"")."
    </table>
    </div><br>";
  }
?></td>
  </tr>
</table>


</td>
<?
  if ($speakto["id"]) {
    echo "<td width=\"20%\" align=\"center\" valign=\"top\">";
    echo $speakto["name"];
    echo showpersout($speakto["id"],0,1);
    echo "</td>";
  }
?>
</tr></table>
</td></tr></table>
<?
  if (@$speakto["quest"]) {
    $cond="";
    if (@$speakto["quest1"]) $cond.=" or quest='$speakto[quest1]' ";
    if (@$speakto["quest2"]) $cond.=" or quest='$speakto[quest2]' ";
    
    $cond="";
    if (@$speakto["quest1"]) $cond.=" or quest='$speakto[quest1]' ";
    if (@$speakto["quest2"]) $cond.=" or quest='$speakto[quest2]' ";
    if (@$speakto["quest3"]) $cond.=" or quest='$speakto[quest3]' ";
    if (@$speakto["quest4"]) $cond.=" or quest='$speakto[quest4]' ";
    if (@$speakto["quest5"]) $cond.=" or quest='$speakto[quest5]' ";
    $r=mq("select sum(step), users.login, users.klan, users.level from quests left join users on quests.user=users.id where quest='$speakto[quest]' group by users.id order by 1 desc limit 0, 10");

    echo "<br><table align=\"center\">
    <tr><td width=\"330\" valign=\"top\">";
                    
    echo "<b>10 лучших воинов".($cond?" в этой битве":"").":</b><br><br>";
    echo "<table>";
    $i=0;
    while ($rec=mysql_fetch_assoc($r)) {
      $i++;
      echo "<tr><td height=\"20\">$i</td><td><img src=\"".IMGBASE."i/klan/$rec[klan].gif\"></td><td><b>$rec[login]</b> [$rec[level]]</td></tr>";
    }
    echo "</table>";
    
    echo "</td><td width=\"330\" valign=\"top\">";

    if ($cond) {
      echo "<b>10 лучших воинов за весь поход:</b><br><br>";
      $r=mq("select sum(step), users.login, users.klan, users.level, quests.user from quests left join users on quests.user=users.id where quest='$speakto[quest]' $cond group by quests.user order by 1 desc limit 0, 10");
      echo "<table>";
      $i=0;
      while ($rec=mysql_fetch_assoc($r)) {
        $i++;
        if (!$rec["login"]) {
          $ur=mqfa("select login, klan, level from allusers where id='$rec[user]'");
          $rec["login"]=$ur["login"];
          $rec["klan"]=$ur["klan"];
          $rec["level"]=$ur["level"];
        }
        echo "<tr><td height=\"20\">$i</td><td><img src=\"".IMGBASE."i/klan/$rec[klan].gif\"></td><td><b>$rec[login]</b> [$rec[level]]</td></tr>";
      }
      echo "</table>";
    }
echo "</td><td width=\"330\" valign=\"top\">";
echo "<b>10 лучших кланов:</b><br><br>";
echo implode("",file("data/clantop.html"));
echo "</td></tr></table>";
}
?>
</body>
</html>
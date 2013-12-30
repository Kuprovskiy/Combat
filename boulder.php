<?php
  session_start();
  if ($_SESSION['uid'] == null) header("Location: index.php");
  include "connect.php";
  include "functions.php";
  if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }

  if ($user["room"]!=81) {header("location: main.php");die;}
            

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
<BODY bgColor=#e2e0e0>
<?
  if(@$_GET["warning"] && strlen($_GET["warning"])>1) echo "<b><font color=red>$_GET[warning]</font></b>";
?>
<div id=hint4 class=ahint></div>

<TABLE width=100%>
<TR><TD valign=top width=100%><center><h3><?=$rooms[$user["room"]]?></h3></center>
<br>
<center><table width="800" align="center"><tr>
<td valign="top">
<?
  $quest=getvar("quest");
  if (!$quest) {
    include_once("questfuncs.php");
    if (!canmakequest(4)) {
      echo "<b><font color=red>Вам необходим отдых после предыдущей попытки ещё хотя бы ".ceil($questtime/60)." мин.</font></b>";
    } elseif ($user["sila"]<25) {
      echo "Вы ничем не сможете помочь силачам, только будете мешать.";
    } else { 
      if ($_GET["push"]) {
        if ($user["hp"]<$user["maxhp"]) {
          echo "<b><font color=red>Для того, чтобы толкать камень, вам необходимо полностью восстановить силы.</font></b><br><br>";
          $_GET["push"]=0;
        }
        if ($_GET["push"]) {
          $i=mqfa1("select id from effects where owner='$user[id]' and (type=11 or type=12 or type=13 or type=14)");
          if ($i) {
            echo "<b><font color=red>Вы травмированы и сейчас ничем не сможете помочь.</font></b><br><br>";
            $_GET["push"]=0;
          }
        }
      }
      $pushing=mqfa1("select id from questusers where user='$user[id]'");
      if (@$_GET["push"] && !$pushing) {
        $s=getvar("queststart");
        if (!$s) {
          setvar("queststart", time()+60);
        }
        mq("insert into questusers set user='$user[id]'");
        include "functions/checkboulder.php";
        if ($success) {
          echo "<b><font color=\"red\">Камень удачно столкнули с горы!</font></b>";
          $quest=0;
        } else echo "<b>Вы изо всех сил пытаетесь столкнуть камень...</b><br><br><i>(необходимо подождать около минуты не выходя из локации)</i>";
      } else {
        if ($pushing) {
          echo "<b>Вы изо всех сил пытаетесь столкнуть камень...</b><br><br><i>(необходимо подождать около минуты не выходя из локации)</i>";
        } else {
          echo "На вершине горы расположен огромный валун. Чтобы столкнуть его, необходима сила великая.
          Чтобы это сделать, нужно, чтобы как можно больше человек толкало его одновременно.<br><br><center>
          <a href=\"boulder.php?push=1\">Толкать камень</a><br></center>";
        }
      }
    }
  } else echo "Камень сброшен с горы, он надёжно запечатал вход в здание, и теперь можно смело нападать на цвергов!";

?>
</td><td width="250" align="center">
<? if (!$quest) echo "<img src=\"/i/quests/boulder.jpg\">"; ?></td></tr></table>
<TD nowrap valign=top>


<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px; white-space: nowrap;"></div>
<?
  include "config/routes.php";
  foreach ($routes[$user["room"]] as $k=>$v) $links[$rooms[$v]]="city.php?got=1&level$v=1";
  echo moveline($links);
?>
<BR>
<DIV align=right><INPUT onClick="document.location.href='vxod.php?<? echo time(); ?>'" value=Обновить type=button>
<? if ($user["room"]==51) { ?><INPUT style="font-size:12px;" type='button' onClick="location='zadaniya.php'" value="Задания"><? } ?>
</DIV></TD></TR></TBODY></TABLE>
</TD>
</TR>
</TABLE>
<div id="goto" style="text-align:right;white-space:nowrap">&nbsp;</div>
<br><br>
<h3>Предыдущие попытки:</h3>
<?
  echo mqfa1("select log from events where id=1");
?><br><br>
</BODY>
</HTML>
<?php include("mail_ru.php"); ?>
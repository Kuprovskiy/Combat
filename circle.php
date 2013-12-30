<?php
  session_start();
  if ($_SESSION['uid'] == null) header("Location: index.php");
  include "connect.php";
  include "functions.php";
  if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }

  if ($user["room"]!=80) {header("location: main.php");die;}
            

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
    } elseif ($user["intel"]<25 || $user["maxmana"]<=0) {
      echo "Вы ничем не сможете помочь чародеям.";
    } else { 
      if ($_GET["read"] && ($user["mana"]<$user["maxmana"])) {
        echo "<b><font color=red>Для чтения заклинания вам необходима вся мана.</font></b><br><br>";
        $_GET["read"]=0;
      }
      if (@$_GET["read"]) {
        $r=mq("select users.id, users.intel, users.mana, users.login from users left join online on users.id=online.id left join qtimes on qtimes.user=users.id where qtimes.q4<".time()." and online.date>=".(time()-90)." and users.intel>25 and users.mana=maxmana and users.room=80");
        if (mysql_num_rows($r)<=1) {
          echo "<b><font color=red>Для чтения заклинания необходима группа магов, не стоит пытаться прочесть заклинание одному.</font></b><br><br>";
        } else {
          $power=0;
          $cond="0";
          $logins="";
          while ($rec=mysql_fetch_assoc($r)) {
            makequest(4, 1, $rec["id"]);
            $power+=$rec["intel"]*$rec["mana"];
            $cond.=" or id=$rec[id] ";
            $logins.=" $rec[login]";
          }
          mq("update variables set value=concat(value, '\r\n".date("H:i")." $logins $power') where var='questlog'");
          if ($user["sex"]) $a="ёл"; else $a="ла";
          if ($power>=2000000) {
            echo "<b>Заклинание сработало успешно.</b>";
            sysmsg("<b>$user[login]</b> проч$a заклинание, стены башни задрожали, из окон пошёл дым, раздался вой тварей. Похоже, всё удалось, и теперь можно смело атаковать.");
            mq("update variables set value=1 where var='quest'");
            mq("update variables set value='$logins' where var='questusers'");
          } else {
            echo "<font color=red><b>Силы чародеев нехватило, чтобы рассеять магию цвергов.</b></font>";
            sysmsg("<b>$user[login]</b> проч$a заклинание, но силы чародеев оказались недостаточны.");
          }
          mq("update users set mana=0, fullmptime=".time()." where $cond");
        }
      } else {
        echo "Верховный чародей создал магический круг, который даст возможность чародеям объединить свои усилия.
        Все чародеи, кто вступили в круг, объединят свои силы, и любой, кто начнёт читать заклинание,
        использует силу всех остальных. <br><br><center>
        <a href=\"circle.php?read=1\">Начать читать заклинание</a><br></center>";
      }
    }
  } else echo "Заклинание сотворено успешно и теперь можно смело нападать на тварей!";

?>
</td><td width="250" align="center">
<img src="<?=IMGBASE?>/i/magiccircle.gif"></td></tr></table>
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
</BODY>
</HTML>
<?php include("mail_ru.php"); ?>
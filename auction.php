<?php
  session_start();
  if ($_SESSION['uid'] == null) header("Location: index.php");
  include "connect.php";
  include "functions.php";
  if ($user['room'] != 42){ header("Location: main.php"); die(); }
  if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
</HEAD>
<body bgcolor=e2e0e0><div id=hint3 class=ahint></div><div id=hint4 class=ahint></div>
<TABLE border=0 width=100% cellspacing="0" cellpadding="0">
<FORM action="city.php" method=GET>
<tr><td><h3>Аукционный дом</td><td align=right>
<!--<INPUT TYPE="button" value="Подсказка" style="background-color:#A9AFC0" onClick="window.open('help/lotery.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">-->
<INPUT TYPE="submit" value="Вернуться" name="torg"></td></tr>
</FORM>
</table>
Торги проводятся каждую неделю. Окончание торгов (одновременно начало следующих) - 00:00 в воскресенье (в ночь с воскресенья на понедельник).<br>
Лот покупает персонаж, который сделал наибольшую ставку в момент окончания торгов. Персонажи, которые сделали ставки меньше максимальной, получают ставки обратно.<br>
<div>&nbsp;</div>
<?
  if ($_POST["todo"]=="steak") {
    $_POST["qty"]=(int)$_POST["qty"];
    if ($_POST["qty"]<=0) {
      $error="Количество введено неверно.";
    } else {
      mq("lock tables inventory write, lots write, smallitems write, droplog write");
      $lot=(int)$_POST["lot"];
      $rec=mqfa("select * from lots where id='$lot'");
      if ($rec && $rec["user"]!=$user["id"]) {
        $_POST["item"]=(int)$_POST["item"];
        $item=mqfa1("select name from smallitems where id='$_POST[item]'");
        if (!hassmallitems($item, $_POST["qty"])) {
          $error="У вас недостаточно предметов для такой ставки.";
        }
        if ($rec["item"]>$_POST["item"] || ($rec["item"]==$_POST["item"] && $rec["qty"]>=$_POST["qty"])) {
          $error="Ваша ставка не превышает максимальную.";
        }
        if (!@$error) {
          include_once("questfuncs.php");
          if ($rec["item"]) takesmallitem($rec["item"], $rec["user"], "Возврат с торгов", $rec["qty"]);
          takesmallitems($item, $_POST["qty"], $user["id"]);
          mq("update lots set user='$user[id]', item='$_POST[item]', qty='$_POST[qty]' where id='$lot'");
        }
      }
      mq("unlock tables");
    }
    if (@$error) echo "<b><font color=red>$error</font></b><br><br>";
  }
?>
<b>Пещера кристаллов</b><br><br>
<table>
<tr><td><b>Название лота</b></td><td>&nbsp;</td><td><b>Текущая ставка</b></td></tr>
<?
  $r=mq("select * from lots where room=57 && id > 2 order by id");
  $extra=unserialize(mqfa1("select extra from userdata where id='$user[id]'"));
  while ($rec=mysql_fetch_assoc($r)) {
    echo "<form action=\"auction.php\" method=\"post\">
    <input type=\"hidden\" name=\"todo\" value=\"steak\">
    <input type=\"hidden\" name=\"lot\" value=\"$rec[id]\">
    <tr><td>$rec[name]</td><td>&nbsp;</td><td>";
    if ($rec["item"]) echo mqfa1("select name from smallitems where id='$rec[item]'")." ($rec[qty] шт.)";
    else echo "нет";
    echo "</td><td>&nbsp;</td><td>";
    $cant=0;
    if ($rec["id"]==1 && $extra["stats"][$rec["room"]]>=3) $cant=1;
    if ($rec["id"]==2 && $extra["master"][$rec["room"]]>=1) $cant=1;
    if ($cant) echo "Вы не можете принять участие в этих торгах.";
    elseif ($rec["user"]==$user["id"]) echo "Ваша ставка";
    else {
      echo "Поставить: <select name=\"item\">";
      if ($rec["item"]<=53) echo "<option value=\"53\">Жетон кристаллов</option>";
      if ($rec["item"]<=54) echo "<option value=\"54\">Знак кристаллов 1</option>";
      if ($rec["item"]<=55) echo "<option value=\"55\">Знак кристаллов 2</option>";
      echo "<option value=\"56\">Знак кристаллов 3</option>";
      echo "</select> <input type=\"text\" name=\"qty\" style=\"width:20px\"> шт.
      <input type=\"submit\" value=\"Сделать ставку\">";
    }
    echo "</td></tr></form>";
  }
?></table>

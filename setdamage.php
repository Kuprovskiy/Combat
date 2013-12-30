<?
die;
  session_start();       // && $_SESSION["uid"]!=2879
  if ($_SESSION["uid"]!=7) die;
  include "connect.php";
  if (@$_POST["item"] && ($_POST["tbl"]=="shop" || $_POST["tbl"]=="berezka")) {
    $_POST["chkol"]=(int)$_POST["chkol"];
    $_POST["chrub"]=(int)$_POST["chrub"];
    $_POST["chrej"]=(int)$_POST["chrej"];
    $_POST["chdrob"]=(int)$_POST["chdrob"];
    $_POST["chmag"]=(int)$_POST["chmag"];
    mq("update $_POST[tbl] set chkol='$_POST[chkol]', chrub='$_POST[chrub]', chrej='$_POST[chrej]', chdrob='$_POST[chdrob]', chmag='$_POST[chmag]' where id='$_POST[item]'");
    if ($_POST["chkol"]+$_POST["chrub"]+$_POST["chrej"]+$_POST["chdrob"]+$_POST["chmag"]!=100) echo "<script>alert('Неверные данные!')</script>";
  }
  $r=mq("select * from shop where type=3 and count>0 order by razdel, name");
  echo "<table>
  <tr><td></td>
  <td><b>Колящие</b></td>
  <td><b>Рубящие</b></td>
  <td><b>Режущие</b></td>
  <td><b>Дробящие</b></td>
  <td><b>Магические</b></td>
  </tr>
  ";
  while ($rec=mysql_fetch_assoc($r)) {
    echo "<form action=\"setdamage.php#s$rec[id]\" method=post>
    <input type=hidden name=item value=$rec[id]>
    <input type=hidden name=tbl value=shop>
    <tr><td><a name=s$rec[id]></a>$rec[name]</td>
    <td><input type=text size=3 name=\"chkol\" value=\"$rec[chkol]\"></td>
    <td><input type=text size=3 name=\"chrub\" value=\"$rec[chrub]\"></td>
    <td><input type=text size=3 name=\"chrej\" value=\"$rec[chrej]\"></td>
    <td><input type=text size=3 name=\"chdrob\" value=\"$rec[chdrob]\"></td>
    <td><input type=text size=3 name=\"chmag\" value=\"$rec[chmag]\"></td>
    <td><input type=submit value=\"Сохранить\"></td>
    </tr></form>";
  }
  echo "</table>";

  $r=mq("select * from berezka where type=3 and count>0 order by razdel, name");
  echo "<hr><table>
  <tr><td></td>
  <td><b>Колящие</b></td>
  <td><b>Рубящие</b></td>
  <td><b>Режущие</b></td>
  <td><b>Дробящие</b></td>
  <td><b>Магические</b></td>
  </tr>
  ";
  while ($rec=mysql_fetch_assoc($r)) {
    echo "<form action=\"setdamage.php#b$rec[id]\" method=post>
    <input type=hidden name=item value=$rec[id]>
    <input type=hidden name=tbl value=berezka>
    <tr><td><a name=b$rec[id]></a>$rec[name]</td>
    <td><input type=text size=3 name=\"chkol\" value=\"$rec[chkol]\"></td>
    <td><input type=text size=3 name=\"chrub\" value=\"$rec[chrub]\"></td>
    <td><input type=text size=3 name=\"chdrob\" value=\"$rec[chdrob]\"></td>
    <td><input type=text size=3 name=\"chrej\" value=\"$rec[chrej]\"></td>
    <td><input type=text size=3 name=\"chmag\" value=\"$rec[chmag]\"></td>
    <td><input type=submit value=\"Сохранить\"></td>
    </tr></form>";
  }
  echo "</table>";
?>
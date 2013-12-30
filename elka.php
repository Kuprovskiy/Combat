<?php
  session_start();
  if ($_SESSION['uid'] == null) header("Location: index.php");
  include "connect.php";
  $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
  include "functions.php";
  if ($user["room"]!=24 && $user["room"]!=46) {
    header("location: main.php");
    die;
  }
  if (@$_GET["goto"]) {
    if ($_GET["goto"]==20) {
      $r=mq("select id, dressed from inventory where owner='$user[id]' and prototype=1 and name like 'Маска%'");
      while ($rec=mysql_fetch_assoc($r)) {
        if ($rec["dressed"]) dropitem(8);
        mq("delete from inventory where id='$rec[id]'");
      }
    }
    include "goto.php";
  }
  if ($user['battle'] != 0) {header('location: fbattle.php');die();}
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="/i/main.css">
<link href="/i/move/design6.css" rel="stylesheet" type="text/css">
<script src="/i/js/move.js"></script>
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<META HTTP-EQUIV="imagetoolbar" CONTENT="no">
<style type="text/css">
img.aFilter { filter:Glow(color=<? if (WINTER) echo "f1c301"; else echo "d7d7d7";?>,Strength=4,Enabled=0); cursor:hand }
hr { height: 1px; }
</style>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=#d4d4d4>
<div id="mmoves3" style="background-color:#FFFFCC; visibility:hidden; z-index: 101; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px;"></div>
<div id="barcontainer" style="position:absolute; right:20px; top:0px; width:1px; height:1px; z-index:101; overflow:visible;">
<TABLE height=15 border="0" cellspacing="0" cellpadding="0">
<TR>
<TD rowspan=3 valign="bottom"><a href="?rnd=0.604083970286585"><img src="/i/move/rel_1.gif" width="15" height="16" alt="Обновить" border="0" /></a></TD>
<TD colspan="3"><img src="/i/move/navigatin_462s.gif" width="80" height="4" /></TD>
</TR>
<TR>
<TD><IMG src="/i/move/navigatin_481.gif" width="9" height="8"></TD>
<TD width=64 bgcolor=black><DIV class="MoveLine"><IMG src="/i/move/wait2.gif" id="MoveLine" class="MoveLine"></DIV></TD>
<TD><IMG src="/i/move/navigatin_50.gif" width="7" height="8"></TD>
</TR>
<TR>
<TD colspan="3"><IMG src="/i/move/navigatin_tt1_532.gif" width="80" height="5"></TD>
</TR>
</TABLE>
</div>
<?
  if ($user["room"]==24) {
    echo "<h3>Новогодняя елка!</h3>";
    if ($_POST['fail']) {
      echo '<font color=red>Операция была отменена.</font>';
    }
    if ($_POST['comment']) {
      if (time()-$_SESSION["lastelka"]<60) echo '<font color=red>Писать на ёлке можно не чаще чем раз в минуту.</font>';
      else {
        mysql_query('INSERT INTO `elka` (`who`,`date`,`text`) values (\''.nick3 ($user['id']).'\',\''.date("d.m.Y H:i").'\',\''.strip_tags($_POST['comment']).'\');');
        $_SESSION["lastelka"]=time();
      }
    }
    if (@$_GET["delmsg"] && $user["align"]=="2.5") {
      mq("delete from elka where id='$_GET[delmsg]'");
    }
    $data = mysql_query("SELECT * FROM `elka` ORDER by `id` DESC LIMIT ".($_GET['page']*20).",20;");
    $data1 = mysql_query("SELECT id FROM `elka`");
    echo "<table width=\"100%\"><tr><td style=\"padding-right:20px\">";
    if (@$_GET["puton"]) {
      $_GET["puton"]=(int)$_GET["puton"];
      $rec=mqfa("select koll, prototype, owner from inventory where id='$_GET[puton]'");
      if ($rec && $rec["owner"]==$user["id"] && $rec["prototype"]>=2348 && $rec["prototype"]<=2352) {
        mq("delete from inventory where id='$_GET[puton]'");
        addqueststep($user["id"], 2, $rec["koll"]);
        $v=getqueststep(2);
        if ($v>100) $v=100;
        if ($user["level"]>9) $v*=3;
        elseif ($user["level"]>6) $v*=2;
        $mf="";$mfval="";$ghp=0;$gmana=0;
        if ($rec["prototype"]==2348) {
          $name="Благословение ёлки: Жизнь";
          $ghp=$v;
        }
        if ($rec["prototype"]==2349) {
          $name="Благословение ёлки: Магия";
          $gmana=$v;
        }
        if ($rec["prototype"]==2350) {
          $name="Благословение ёлки: Опасность";
          $mf="mfkrit";$mfval=$v;
        }
        if ($rec["prototype"]==2351) {
          $name="Благословение ёлки: Устойчивость";
          $mf="mfakrit";$mfval=$v;
        }
        if ($rec["prototype"]==2352) {
          $name="Благословение ёлки: Реакция";
          $mf="mfauvorot";$mfval=$v;
        }
        $i=mqfa1("select id from effects where owner='$user[id]' and type=".NYBLESSING);
        if ($i) mq("update effects set time=".(60*60*24+time()).", name='$name', ghp=$ghp, gmana=$gmana, mf='$mf', mfval='$mfval' where id='$i'");
        else mq("insert into effects set owner='$user[id]', type=".NYBLESSING.", name='$name', time=".(60*60*24+time()).", ghp=$ghp, gmana=$gmana, mf='$mf', mfval='$mfval'");
        resetmax($user["id"]);
        echo "Вы получили <b>$name</b><br><br>";
      }
    }
    if (@$_GET["mask"] && 0) {
      include_once("questfuncs.php");
      if (canmakequest(4)) {
        resetmax($user["id"]);
        $addit=mqfa("SELECT sum(gsila) as gsila, sum(glovk) as glovk, sum(ginta) as ginta, sum(gintel) as gintel, sum(ghp) as ghp FROM `inventory` WHERE dressed = 1 AND owner = '$user[id]' ");
        $addit2=mqfa("SELECT sum(sila) as gsila, sum(lovk) as glovk, sum(inta) as ginta, sum(intel) as gintel FROM `effects` WHERE owner = '$user[id]'");
        foreach ($addit2 as $k=>$v) $addit[$k]+=$addit2[$k];
        $sila=15+$addit["gsila"]-$user["sila"]+rand(0,5)-2-ceil($user["stats"]/3);
        $lovk=15+$addit["glovk"]-$user["lovk"]+rand(0,5)-2-ceil($user["stats"]/3);
        $inta=15+$addit["ginta"]-$user["inta"]+rand(0,5)-2-ceil($user["stats"]/3);
        $intel=$addit["gintel"]-$user["intel"];
        $hp=120+$addit["ghp"]-$user["maxhp"];
        mq("insert into inventory (owner, gsila, glovk, ginta, gintel, ghp, duration, maxdur, nlevel, img, type, name, prototype, present) values ('$user[id]', '$sila', '$lovk', '$inta', '$intel', '$hp', 0, 1, 1, 'mask".rand(1,19).".gif',8,'Маска',1, 'Снегурочка')");
        echo "<b><font color=red>Вы получили маску.<br>".($user["stats"]?"Т. к. у Вас имеются нераспределённые статы, её параметры ниже.":"")."<br><br></font></b>";
        makequest(4);
      } else {
        echo "<b><font color=red>Можно получить не более 1 маски каждые полчаса.</font></b><br><br>";
      }
    }
    if (@$_GET["snow"]) {
      echo "За подарками - к Деду Морозу, за закалкой, варежками, ёлочными украшениями или новогодним кольцом мороза - в ледяную пещеру.<br><br>";
    }
    if (@$_GET["open"]) {
      $tme=localtime();
      if ($tme[5]>112) {
        $q=mqfa1("select step from quests where user='$user[id]' and quest=7");
        if (!$q) {
          $money=$user["level"]*50;
          echo "Дед Мороз дал вам $money кр. и кое-какие вещички:<br>";
          $ret=takeshopitem(1392,"shop","Дед Мороз", "", 0, array("goden"=>30));
          echo "<img src=\"".IMGBASE."/i/sh/$ret[img]\" title=\"$ret[name]\">";
          $ret=takeshopitem(1391,"shop","Дед Мороз", "", 0, array("goden"=>30));
          echo "<img src=\"".IMGBASE."/i/sh/$ret[img]\" title=\"$ret[name]\">";
          $ret=takeshopitem(1539,"shop","Дед Мороз", "", 0, array("goden"=>30));
          echo "<img src=\"".IMGBASE."/i/sh/$ret[img]\" title=\"$ret[name]\">";
          $ret=takeshopitem(1971,"shop","Дед Мороз", "", 0, array("goden"=>30));
          echo "<img src=\"".IMGBASE."/i/sh/$ret[img]\" title=\"$ret[name]\">";
          $ret=takeshopitem(1986,"shop","Дед Мороз", "", 0, array("goden"=>30));
          echo "<img src=\"".IMGBASE."/i/sh/$ret[img]\" title=\"$ret[name]\">";
          $ret=takeshopitem(1985,"shop","Дед Мороз", "", 0, array("goden"=>30));
          echo "<img src=\"".IMGBASE."/i/sh/$ret[img]\" title=\"$ret[name]\">";
          $ret=takeshopitem(1984,"shop","Дед Мороз", "", 0, array("goden"=>30));
          echo "<img src=\"".IMGBASE."/i/sh/$ret[img]\" title=\"$ret[name]\">";
          $ret=takeshopitem(1592,"shop","Дед Мороз", "", 0, array("goden"=>30));
          echo "<img src=\"".IMGBASE."/i/sh/$ret[img]\" title=\"$ret[name]\">";
          $ret=takeshopitem(1537,"shop","Дед Мороз", "", 0, array("goden"=>30));
          echo "<img src=\"".IMGBASE."/i/sh/$ret[img]\" title=\"$ret[name]\">";
          $ret=takeshopitem(1536,"shop","Дед Мороз", "", 0, array("goden"=>30));
          echo "<img src=\"".IMGBASE."/i/sh/$ret[img]\" title=\"$ret[name]\">";
          $ret=takeshopitem(1535,"shop","Дед Мороз", "", 0, array("goden"=>30));
          echo "<img src=\"".IMGBASE."/i/sh/$ret[img]\" title=\"$ret[name]\">";
          $ret=takeshopitem(1777,"shop","Дед Мороз", "", 0, array("goden"=>30));
          echo "<img src=\"".IMGBASE."/i/sh/$ret[img]\" title=\"$ret[name]\">";
          $ret=takeshopitem(101716,"berezka","Дед Мороз", "", 0, array("goden"=>30));
          echo "<img src=\"".IMGBASE."/i/sh/$ret[img]\" title=\"$ret[name]\">";
          $ret=takeshopitem(101764,"berezka","Дед Мороз", "", 0, array("goden"=>30));
          echo "<img src=\"".IMGBASE."/i/sh/$ret[img]\" title=\"$ret[name]\">";
          $ret=takeshopitem(101765,"berezka","Дед Мороз", "", 0, array("goden"=>30));
          echo "<img src=\"".IMGBASE."/i/sh/$ret[img]\" title=\"$ret[name]\">";
          $ret=takeshopitem(101766,"berezka","Дед Мороз", "", 0, array("goden"=>30));
          echo "<img src=\"".IMGBASE."/i/sh/$ret[img]\" title=\"$ret[name]\">";
          $ret=takeshopitem(100615,"berezka","Дед Мороз", "", 0, array("goden"=>30));
          echo "<img src=\"".IMGBASE."/i/sh/$ret[img]\" title=\"$ret[name]\">";
          $ret=takeshopitem(101618,"berezka","Дед Мороз", "", 0, array("goden"=>30));
          echo "<img src=\"".IMGBASE."/i/sh/$ret[img]\" title=\"$ret[name]\">";
          mq("update users set money=money+$money where id='$user[id]'");
          echo "<br><br>";
          addqueststep($user["id"],7);
        } else echo "<b><font color=red>Не более одного подарка в одни руки.</font></b><br><br>";
      } else echo "<b><font color=red>До Нового Года подарков не положено.</font></b><br><br>";
    }
    echo "<u>Посетители оставили надписи на стволе елки:</u>";
    $pgs = ceil(mysql_num_rows($data1)/20);
    for ($i=0;$i<$pgs;++$i) {
        echo ' <a href="?page=',$i,'">',($i+1),'</a> ';
    }
    echo "<BR>";
    while($row = mysql_fetch_array($data)) {
      if ($user["align"]=="2.5") echo "<a onclick=\"return confirm('Are you sure?')\" href=\"elka.php?delmsg=$row[id]\"><img src=\"i/clear.gif\" border=\"0\"></a>";
      echo $row['who'],' - ',$row['text'],'<BR>';
    }
    echo "<form action='elka.php' method='post'>
    Оставить сообщение: <INPUT TYPE=\"text\" name=\"comment\" SIZE=\"50\" VALUE=\"\" maxlength=150>
    <input type=\"submit\" name=\"\" value=\"Добавить\">
    </form>
    </td><td valign=top width=530>
    <div>
    <div id=\"ione\" style=\"width:530px;height:260px;background-image:url(/i/city/ctree1.gif);position:relative;\">";
    buildset(90,"на ево",165,55,"Ледяная пещера");
    buildset(20,"right",165,400,"Центральная площадь");
    buildset(21101012,"fund_hram",200,200,"Новогодний Магазин");
    buildset(1,"snowwhite",25,290,"Снегурочка","elka.php?snow=1");
    buildset(1,"dead",35,90,"Дед Мороз","elka.php?open=1");
    echo "</div>";
  } else {
    echo "<h3>Танцевальный зал</h3>";
    echo "<table width=\"100%\"><tr><td valign=\"top\">";
    if (@$_GET["join"]) {
      $m=mqfa1("select prototype from inventory where id='$user[helm]'");
      if ($m==1) {
        mq("insert into dance (user) values ('$_SESSION[uid]')");
      } else echo "<b><font color=red>Для участия в бале вам необходимо надеть маску!</font></b><br><br>";
    }
    echo "Для участия в бале-маскараде, возьмите маску у Снегурочки и оденьте её. Если во время начала бала вы будете без маски, то участие принять не сможете.<br>
    Так же во время начала бала пропадёт действие всех эликсиров и заклятий.<br>
    Бал не начнётся, если в нём будут участвовать менее 5 человек. Так же строго запрещено выносить маски за пределы зала, поэтому на выходе все маски будут изъяты.
    Если Вы возьмёте маску и покинете зал, то следующую сможете взять только через полчаса.
    <br><br><br>Следующий бал-маскарад начнётся в ".date("H:i",mqfa1("select value from variables where var='dance'")).".<br><br>";
    $j=mqfa1("select user from dance where user='$user[id]'");
    if ($j) echo "Вы подали заявку на участие в бале. Наденьте маску и ждите начала.<br><br>
    <center><input type=\"button\" value=\"Обновить\" onclick=\"document.location.href='elka.php?".time()."'\"></center>";
    else echo "<center><input type=button onclick=\"document.location.href='elka.php?join=1';\" value=\"Принять участие\"></center>";
    echo "</td><td valign=top width=530>
    <div>
    <div id=\"ione\" style=\"width:530px;height:260px;background-image:url(/i/city/dancehall.gif);position:relative;\">";
    buildset(24,"right",165,385,"Новогодняя ёлка");
    echo "</div>";
  }
  echo "<div id=\"btransfers\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" id=\"bmoveto\">
  <tr><td bgcolor=\"#D3D3D3\">";
  //echo $loclinks;
?></td></tr></table>
<?
  echo "<br><h3>Больше всего ёлку украшали:</h3>";
  $r=mq("select sum(step), users.login, users.klan, users.level, quests.user from quests left join users on quests.user=users.id where quest='2' group by quests.user order by 1 desc limit 0, 10");
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
    echo "<tr><td height=\"20\">$i</td><td><img src=\"".IMGBASE."i/klan/$rec[klan].gif\"></td><td><b>$rec[login]</b> [$rec[level]] <a target=\"_blank\" href=\"inf.php?$rec[user]\"><img src=\"".IMGBASE."/i/inf.gif\" border=\"0\"></a></td></tr>";
  }
  echo "</table>";
?>
<div style="display:none; height:0px " id="moveto">0</div>
<?
  $_SESSION['perehod']=time()+10;
  if($_SESSION['perehod']>time()){$vrme=$_SESSION['perehod']-time();}else{$vrme=0;}
?>
<script language="javascript" type="text/javascript">
  var progressEnd = 64;       // set to number of progress <span>'s.
  var progressColor = '#00CC00';  // set to progress bar color
  var mtime = parseInt('<?=$vrme?>');
  if (!mtime || mtime<=0) mtime=0;
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
      document.getElementById('barcontainer').style.right='3px';
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
    progressColor = color;
    for (var i = 1; i <= progressAt; i++) {
      document.getElementById('progress'+i).style.backgroundColor = progressColor;
    }
  }
  if (mtime>0) {
    progress_clear();
    progress_update();
  }
</script>
</div>
</td></tr></table>
<?
  echo "<table width=\"100%\"><tr><td><table width=\"100%\">";
  if ($user["room"]==24) {
    $r=mq("select * from inventory where owner='$user[id]' and prototype>=2348 and prototype<=2352");
    $i=0;
    while ($rec=mysql_fetch_assoc($r)) {
      $i++;
      echo itemrow($rec, "elka.php?puton=$rec[id]", "украсить", $i);
    }
  }
  echo "</table></td><td width=\"530\" valign=\"top\">";
  echo "</td></tr></table>";
?>
<div id="hint3" class="ahint"></div>

</BODY>
</HTML>

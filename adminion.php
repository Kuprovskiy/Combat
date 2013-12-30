<?
session_start();
if ($_SESSION['uid'] == null) header("Location: index.php");	
include "connect.php";
$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));	
include "functions.php";
$al = mysql_fetch_assoc(mysql_query("SELECT * FROM `aligns` WHERE `align` = '{$user['align']}' LIMIT 1;"));
header("Cache-Control: no-cache");
if ($user['align']<2.5 || $user['align']>2.6) header("Location: index.php");
header('Content-type: text/html;charset=windows-1251');
function persout($rec) {
  $effs=unserialize($rec["effects"]);
  $strokes1="";
  $i2=0;
  foreach ($effs as $k=>$v) {
    if ($v["img"] && $v["type"]==1) {
      $i2++;
      list($left, $top)=effectpos($i2);
      $strokes1.=effect($left, $top, $v["img"], $v["name"]);
    }
  }
  $rec["persout1"]=str_replace("<!--strokes-->", $strokes1, $rec["persout1"]);
  $rec["persout1"]=str_replace("<a href=\"zver_inv.php\">", "", $rec["persout1"]);
  return $rec["persout1"];
}
function md5m($src) {
  $tar = Array(16);
  $res = Array(16);
  $src = utf8_encode ($src);
  for ($i = 0; $i < strlen($src) || $i < 16; $i++) {
    $res[$i] = ord($src{$i}) ^ $i * 4;
  }
  for ($i = 0; $i < 4; $i++) {
    for ($j = 0; $j < 4; $j++) {
      $tar[$i * 4 + $j] = ($res[$j * 4 + $i] + 256) % 256;
    }
  }
  return ($tar);
}
function array2HStr($src) {
  $hex = Array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F");
  $res = "";
  for ($i = 0; $i < 16; $i++) {
    $res = $res . ($hex[$src[$i] >> 4] . $hex[$src[$i] % 16]);
  }
  return ($res);
} 
?>
<head>
<style>
td, body, input, option {font-family:arial;font-size:14px}
</style>
</head>
<body>
<?
echo "<font color=\"#ffffff\">$_SERVER[REMOTE_ADDR]</font>";
  function slotname($slot) {
    $slot1="";
    switch($slot) {
      case 1: $slot1 = 'sergi'; break;
      case 2: $slot1 = 'kulon'; break;
      case 3: $slot1 = 'weap'; break;
      case 41: $slot1 = 'plaw'; break;
      case 42: $slot1 = 'bron'; break;
      case 43: $slot1 = 'rybax'; break;
      case 5: $slot1 = 'r1'; break;
      case 6: $slot1 = 'r2'; break;
      case 7: $slot1 = 'r3'; break;
      case 8: $slot1 = 'helm'; break;
      case 9: $slot1 = 'perchi'; break;
      case 10: $slot1 = 'shit'; break;
      case 11: $slot1 = 'boots'; break;
      case 12: $slot1 = 'm1'; break;
      case 13: $slot1 = 'm2'; break;
      case 14: $slot1 = 'm3'; break;
      case 15: $slot1 = 'm4'; break;
      case 16: $slot1 = 'm5'; break;
      case 17: $slot1 = 'm6'; break;
      case 18: $slot1 = 'm7'; break;
      case 19: $slot1 = 'm8'; break;
      case 20: $slot1 = 'm9'; break;
      case 21: $slot1 = 'm10'; break;
      case 22: $slot1 = 'naruchi'; break;
      case 23: $slot1 = 'belt'; break;
      case 24: $slot1 = 'leg'; break;
      case 25: $slot1 = 'm11'; break;
      case 26: $slot1 = 'm12'; break;
    }
    return $slot1;

  }
  $todo=@$_GET["todo"];
  $userid=@$_GET["user"];
  if ($userid) $userid=mqfa1("select id from users where id='$userid'");
  if ($userid) $userrec=mqfa("select * from users where id='$userid'");
  if (!$userid) $userid=99999;
  $str=@$_GET["str"];
  $str2=@$_GET["str2"];
  $slot=@$_GET["slot"];
  $slotname=slotname($slot);
  if (@$_POST["todo"]=="createbot") {
    $id=mqfa1("select max(id)+1 from users where id>11111 and id<12000");
    mq("insert into users set id='$id', login='$_POST[login]', level='$_POST[level]', sila='$_POST[sila]', lovk='$_POST[lovk]', inta='$_POST[inta]', vinos='$_POST[vinos]', hp='$_POST[hp]', maxhp='$_POST[hp]', shadow='$_POST[shadow]', sex='$_POST[sex]', bot=1, pass='ThisIsBot', showmyinfo=1");
    echo mysql_error();
    //$id=mysql_insert_id();
    echo "Bot $_POST[login] created: $id<br><br>";
  }
  if ($todo=="givestats") {
    mq("update users set stats=stats+$str where id='$userid'");
    mq("update userdata set stats=stats+$str, extrastats=extrastats+$str where id='$userid'");
    mq("update allusers set stats=stats+$str where id='$userid'");
    mq("update alluserdata set stats=stats+$str, extrastats=extrastats+$str where id='$userid'");
    adddelo($userid, "Получены дополнительные статы ($str шт.) за $str2",10);
  }
  if ($todo=="switchbs") {
    $v=mqfa1("select value from variables where var='deztowtype'");
    if ($v==1) mq("update variables set value='2' where var='deztowtype'");
    else mq("update variables set value='1' where var='deztowtype'");
  }
  if ($todo=="givemedal") {
    mq("update users set medals=concat(medals,'$str;') where id='$userid'");
  }
  if ($todo=="recountstats") {    
    fixstats($userid);
  }

  if ($todo=="savelog") {
    $log=implode("", file("backup/logs/battle$str.txt"));
    if ($log) {
      $r=mq("select battleunits.mfddrob, battleunits.mfdkol, battleunits.mfdwater, battleunits.manausage, battleunits.minusmfdmag, battleunits.minusmfdwater, battleunits.minusmfdair, battleunits.mfparir, battleunits.mfmagp, battleunits.mfwater, battleunits.mfcontr, battleunits.noj, battleunits.mech, battleunits.topor, battleunits.dubina, battleunits.mfire, battleunits.mwater, battleunits.mair, battleunits.mearth, battleunits.mfdmag, minusmfdearth, cost, cost2, mfdhit, mfdhit1,mfdhit2, mfdhit3, mfdhit4, mfdhit5, battleunits.mfhitp, battleunits.mfdrob, battleunits.mech, battleunits.noj, battleunits.topor, battleunits.dubina, mfkrit, mfakrit, mfuvorot, mfauvorot, persout1, archive.battleunits.sila, archive.battleunits.lovk, archive.battleunits.inta, archive.battleunits.vinos, archive.battleunits.intel, archive.battleunits.mudra, archive.battleunits.effects, battleunits.level, users.login from archive.battleunits left join users on archive.battleunits.user=users.id where archive.battleunits.battle='$str'");    
      $bus="<HTML><HEAD>
  <link rel=stylesheet type=\"text/css\" href=\"".IMGBASE."/i/main.css\">
  <meta content=\"text/html; charset=windows-1251\" http-equiv=Content-type>
  <META Http-Equiv=Cache-Control Content=no-cache>
  <meta http-equiv=PRAGMA content=NO-CACHE>
  <META Http-Equiv=Expires Content=0>
  </HEAD>
  <body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=e2e0e0>
      <br><br><table align=\"center\"><tr>";
      $i=0;
      while ($rec=mysql_fetch_assoc($r)) {
        $bus.="<td align=\"center\"><b>$rec[login]</b> [$rec[level]]<br><br>".persout($rec)."</td>";
        $i++;
        if ($i%5==0) $bus.="</tr><tr>";
      }
      $bus.="</tr></table><br><br>";
      include "functions/stats.php";
      $f=fopen("savedlogs/$str.html", "wb+");
      $log.="<br><br>".getstats($str);
      fwrite($f, "$bus$log");
      fclose($f);
      echo "<a href=\"savedlogs/$str.html\">/savedlogs/$str.html</a><br><br>";
    } else echo "<b><font color=red>Нет такого боя</font></b><br>";
  }

  if ($todo=="countstats") {
    $rec=mqfa("select id, master, noj, mec, topor, dubina, posoh, luk, mfire, mwater, mair, mearth, mlight, mgray, mdark, sila, lovk, inta, vinos, intel, mudra, spirit, stats from users where id='$userid'");
    $rec2=mqfa("select $rec[noj]-sum(gnoj) as noj, $rec[mec]-sum(gmech) as mec, $rec[topor]-sum(gtopor) as topor, $rec[dubina]-sum(gdubina) as dubina, $rec[posoh]-sum(gposoh) as posoh, $rec[luk]-sum(gluk) as luk, $rec[mfire]-sum(gfire) as mfire, $rec[mwater]-sum(gwater) as mwater, $rec[mair]-sum(gair) as mair, $rec[mearth]-sum(gearth) as mearth, $rec[mlight]-sum(glight) as mlight, $rec[mgray]-sum(ggray) as mgray, $rec[mdark]-sum(gdark) as mdark,
    $rec[sila]-sum(gsila) as sila, $rec[lovk]-sum(glovk) as lovk, $rec[inta]-sum(ginta), $rec[vinos] as vinos, $rec[intel]-sum(gintel) as intel, $rec[mudra] as mudra, $rec[spirit] as spirit, $rec[stats] as stats from inventory where owner='$userid' and dressed=1");
    $i=mqfa1("select id from inventory where owner='$userid' and dressed=1");
    $urec=mqfa("select * from userdata where id='$userid'");
    function ers($urec, $rec, $stat) {
      if ($stat=="noj" || $stat=="mec" || $stat=="topor" || $stat=="dubina" || $stat=="posoh" || $stat=="luk") $max=5;
      else $max=10;
      if ($urec[$stat]!=$rec[$stat] || $urec[$stat]<0 || $urec[$stat]>$max) return "style=\"color:#ff0000;font-weight:bold\"";
    }
    echo "<table>
    <tr><td></td><td>Noj</td><td>Mec</td><td>Topor</td><td>Dubina</td><td>Posoh</td><td>Luk</td>
    <td>Mfire</td><td>Mwater</td><td>Mair</td><td>Mearth</td><td>Mlight</td><td>Mgray</td><td>Mdark</td>
    <td>Master</td><td>Sila</td><td>Lovk</td><td>Inta</td><td>Vinos</td><td>Intel</td><td>Mudra</td><td>Spirit</td>
    </tr>
    <tr><td>Dressed:</td><td>$rec[noj]/$rec2[noj]</td><td>$rec[mec]/$rec2[mec]</td><td>$rec[topor]/$rec2[topor]</td><td>$rec[dubina]/$rec2[dubina]</td><td>$rec[posoh]/$rec2[posoh]</td><td>$rec[luk]/$rec2[luk]</td><td>$rec[mfire]/$rec2[mfire]</td><td>$rec[mwater]/$rec2[mwater]</td><td>$rec[mair]/$rec2[mair]</td><td>$rec[mearth]/$rec2[mearth]</td><td>$rec[mlight]/$rec2[mlight]</td><td>$rec[mgray]/$rec2[mgray]</td><td>$rec[mdark]/$rec2[mdark]</td><td>$rec[master]</td>
    <td>$rec[sila]</td><td>$rec[lovk]</td><td>$rec[inta]</td><td>$rec[vinos]</td><td>$rec[intel]</td><td>$rec[mudra]</td><td>$rec[spirit]</td><td>$rec[stats]</td></tr>
    <tr><td>Userdata:</td><td align=\"center\" ".ers($urec, $rec2, "noj").">$urec[noj]</td>
    <td align=\"center\" ".ers($urec, $rec2, "mec").">$urec[mec]</td>
    <td align=\"center\" ".ers($urec, $rec2, "topor").">$urec[topor]</td>
    <td align=\"center\" ".ers($urec, $rec2, "dubina").">$urec[dubina]</td>
    <td align=\"center\" ".ers($urec, $rec2, "posoh").">$urec[posoh]</td>
    <td align=\"center\" ".ers($urec, $rec2, "luk").">$urec[luk]</td>
    <td align=\"center\" ".ers($urec, $rec2, "mfire").">$urec[mfire]</td>
    <td align=\"center\" ".ers($urec, $rec2, "mwater").">$urec[mwater]</td>
    <td align=\"center\" ".ers($urec, $rec2, "mair").">$urec[mair]</td>
    <td align=\"center\" ".ers($urec, $rec2, "mearth").">$urec[mearth]</td>
    <td align=\"center\" ".ers($urec, $rec2, "mlight").">$urec[mlight]</td>
    <td align=\"center\" ".ers($urec, $rec2, "mgray").">$urec[mgray]</td>
    <td align=\"center\" ".ers($urec, $rec2, "mdark").">$urec[mdark]</td>
    <td align=\"center\" ".($urec["master"]!=$rec["master"] || $rec["master"]<0?"style=\"color:#ff0000;font-weight:bold\"":"").">$urec[master]</td>
    <td>$urec[sila]</td><td>$urec[lovk]</td><td>$urec[inta]</td><td>$urec[vinos]</td><td>$urec[intel]</td><td>$urec[mudra]</td><td>$urec[spirit]</td><td>$urec[stats]</td>
    </tr></table>";
  }
  if ($todo=="userclan") {
    $str2=mqfa1("select klan from users where id='$userid'");
  }
  if ($todo=="endbattle") {
    $b=mqfa1("select battle from users where id='$userid'");
    mq("update users set battle=0 where battle='$b'");
  }                                
  if ($todo=="setalign") {
    mq("update users set align='$_GET[align]'".($_GET["align"]=='1.1'?", klan=''":"")." where id='$userid'");
  }
  if ($todo=="setclansite") {
    mq("update clans set homepage='$str' where short='$str2'");
  }
  if ($todo=="setclanalign") {
    mq("update clans set align='$_GET[align]' where short='$str'");
    echo "update clans set align='$_GET[align]' where short='$str'";
    echo mysql_error();
    mq("update users set align='$_GET[align]' where klan='$str'");
  }
  
  if ($todo=="setinvisible") {
    $magictime=time()+(60*120);
    $eff=mqfa1("select id from effects where owner='$userid' and type=1022");
    if ($eff) {
      mq("update effects set time='$magictime' where id='$eff'");
    } elseif ($userid) {
      mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('$userid','Заклятие невидимости','{$magictime}',1022);");
      mq("UPDATE `users` SET `invis` = '1' WHERE `id` = '$userid';");
    } else {
      echo "<font color=red><b>Персонаж не выбран!<b></font>";
    }
  }
  if ($todo=="delfromstorage") {
    mq("delete from inventory where id in (select id_it from clanstorage where owner='$userid')");
    mq("delete from clanstorage where owner='$userid'");
  }
  if ($todo=="deleffects") {
    mq("update effects set time=1 where owner='$userid'");
  }
  if ($todo=="setclandem") {
    mq("update clans set clandem='$_GET[clandem]' where short='$str'");
  }
  if ($todo=="itemimage") {
    $item=mqfa1("select $slotname from users where id='$userid'");
    if ($item) mq("update inventory set img='$str' where id='$item'");
  }
  if (@$_GET["delaccount"]) {
    $rec=mqfa("select * from bank where id='$_GET[delaccount]'");
    mq("update users set money=money+$rec[cr], ekr=ekr+$rec[ecr] where id='$rec[owner]'");
    //mq("delete from bank where id='$_GET[delaccount]'");
  }
  if (@$_GET["pass123"]) mq("update bank set pass=md5('1234') where id='$_GET[pass123]'");
  if ($todo=="setpass") {
    mq("update users set pass=md5('$str') where id='$userid'");
    echo mqfa1("select email from users where id='$userid'");
  }
  if ($todo=="delanimal") {
    $a=mqfa1("select zver_id from users where id='$userid'");
    if ($a) {
      mq("update users set zver_id=0 where id='$userid'");
      mq("delete from users where id='$a'");
    } else echo "User don't have animal.";
  }
  if ($todo=="bs1min") mq("update variables set value=value-60 where var='startbs'");
  if ($todo=="bsplus1min") mq("update variables set value=value+60 where var='startbs'");
  if ($todo=="bs10min") mq("update variables set value=value-600 where var='startbs'");
  if ($todo=="bsplus10min") mq("update variables set value=value+600 where var='startbs'");
  if ($todo=="bs60min") mq("update variables set value=value-3600 where var='startbs'");
  if ($todo=="bsplus60min") mq("update variables set value=value+3600 where var='startbs'");
  if ($todo=="startbs") mq("update variables set value=0 where var='startbs'");
  if ($todo=="setprice") mq("update inventory set cost='$_GET[cost]' where id='$_GET[item]'");
  if ($todo=="setshadow") mq("update users set shadow='$str' where id='$userid'");

  if ($todo=="siege1min") mq("update variables set value=value-60 where var='siege'");
  if ($todo=="siegeplus1min") mq("update variables set value=value+60 where var='siege'");
  if ($todo=="siege10min") mq("update variables set value=value-600 where var='siege'");
  if ($todo=="siegeplus10min") mq("update variables set value=value+600 where var='siege'");
  if ($todo=="siege60min") mq("update variables set value=value-3600 where var='siege'");
  if ($todo=="siegeplus60min") mq("update variables set value=value+3600 where var='siege'");
  if ($todo=="startsiege") mq("update variables set value=11 where var='siege'");

  if ($todo=="setpass2") {
    mq("update users set pass2='".md5(array2HStr(md5m($str)))."' where id='$userid'");
  }
  if ($todo=="evaluate") {
    echo "Value: ".playervalue($userid)."<br>";
  }
  if ($_POST["todo"]=="refillshop") {
    $r=mq("select id, name from shop where count=0 order by id");
    while ($rec=mysql_fetch_assoc($r)) {
      if (@$_POST["item$rec[id]"]) mq("update shop set count=10000 where id='$rec[id]'");
    }
  }
  if ($todo=="gotoroom") {
    if ($str==(int)$str)
    mq("UPDATE `users`,`online` SET `users`.`room` = '$str',`online`.`room` = '$str' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '$userid' ;");
  }
  if ($todo=="chatto0") {
    mq("UPDATE `users` set chattime=0 where id='$userid'");
  }
  if ($todo=="givechest") {
    include "questfuncs.php";
    $i=(int)$str;
    while ($i>0) {
      $i--;
      takeitemfromshop(1767,"shop", $userid);
      echo mysql_error();
    }
  }
  if ($todo=="giveitem") {
    include "questfuncs.php";
    if ($str==(int)$str) takeitemfromshop($str,"shop", $userid);
  }
  if ($todo=="viewdelo" || $todo=="viewarchdelo") {
    $r=mq("select text, date from ".($todo=="viewarchdelo"?"archive.":"")."delo where pers='$userid' order by `date` desc");
    echo "<table>";
    while ($rec=mysql_fetch_assoc($r)) {
      echo "<tr><td>$rec[date] ".date("d.m.Y H:i:s",$rec['date'])."</td><td>$rec[text]</td></tr>";
    }
    echo "</table>";
  }
  if ($todo=="dropitem") {
    dropitemid($slot, $userid);
  }
  if ($todo=="addchatmsg") {
    addchp ($str,"", $userid);
  }
  if ($todo=="viewchat") {
    $f=file(CHATROOT."chat.txt");
    $log=mqfa1("select login from users where id='$userid'");
    foreach ($f as $k=>$v) {
      if (strpos($v, $log)) {
        $dat=substr($v, 2, 10);
        $v=substr($v, 13);
        echo date("H:i", $dat)." $v<br>";
      }
    }
  }  
  if ($todo=="viewallchat") {
    $f=file(CHATROOT."chat.txt");
    $log=mqfa1("select login from users where id='$userid'");
    foreach ($f as $k=>$v) {
      if (strpos($v, "!sys!!")) continue;
      $dat=substr($v, 2, 10);
      $v=substr($v, 13);
      echo date("H:i", $dat)." $v<br>";
    }
  }  
  if ($todo=="outfrombs") {
    undressall($userid);
    mq("DELETE FROM `inventory` WHERE `owner` = '$userid' AND `bs` = 1;");

    mq("UPDATE `inventory` SET `owner` = '$userid' WHERE `owner` = '".($userid+_BOTSEPARATOR_)."';");

    // эхх старые статы ставим в строй
    $tec = mysql_fetch_array(mq("SELECT * FROM `deztow_realchars` WHERE `owner` = '$userid'"));
    if($tec[0]) {
        // сномим зарубку
        //mq("DELETE FROM `deztow_realchars` WHERE `owner` = '$userid';");
        // если есть шаблон - меняем
        $u = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '$userid' LIMIT 1;"));
        //теперь выставляем статы))
        $stats = ($u['sila']+$u['lovk']+$u['inta']+$u['vinos']+$u['intel']+$u['mudra']+$u['stats'])-($tec['sila']+$tec['lovk']+$tec['inta']+$tec['vinos']+$tec['intel']+$tec['mudra']);
        $master = ($u['noj']+$u['mec']+$u['topor']+$u['dubina']+$u['mfire']+$u['mwater']+$u['mair']+$u['mearth']+$u['mlight']+$u['mgray']+$u['mdark']+$u['master']);
        mq("UPDATE `users` SET `sila`='".$tec['sila']."', `lovk`='".$tec['lovk']."',`inta`='".$tec['inta']."',`vinos`='".$tec['vinos']."',`intel`='".$tec['intel']."',`mudra`='".$tec['mudra']."',`spirit`='".$tec['spirit']."',`stats`='".$tec['stats']."',`align`='".$tec['align']."',
        `nextup` = '".$tec['nextup']."', `level` = '".$tec['level']."',`noj`='".$tec['noj']."',`mec`='".$tec['mec']."',`topor`='".$tec['topor']."',`dubina`='".$tec['dubina']."',`posoh`='".$tec['posoh']."',`mfire`='".$tec['mfire']."',`mwater`='".$tec['mwater']."',`mair`='".$tec['mair']."',`mearth`='".$tec['mearth']."',`mlight`='".$tec['mlight']."',`mgray`='".$tec['mgray']."',`mdark`='".$tec['mdark']."',`master`='".$tec['master']."'
        WHERE `id` = '$userid' LIMIT 1;");
        // закончили

    }

    // effects
    $eff = mysql_fetch_array(mq("SELECT * FROM `effects` WHERE `owner` = '".$u['id']."' AND (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14);"));
    mq("DELETE FROM `effects` WHERE `owner` = '".$u['id']."' AND `type` <> 11 AND `type` <> 12 AND `type` <> 13 AND `type` <> 14;");
    //mq("INSERT `effects` (`type`, `name`, `time`, `sila`, `lovk`, `inta`, `vinos`, `owner`)
    //          values ('".$eff['type']."','".$eff['name']."','".$eff['time']."','".$eff['sila']."','".$eff['lovk']."','".$eff['inta']."','".$eff['vinos']."','".$eff['owner']."');");
    if($tec[0]) {
        mq("UPDATE `users` SET `sila`=`sila`-'".$eff['sila']."', `lovk`=`lovk`-'".$eff['lovk']."', `inta`=`inta`-'".$eff['inta']."' WHERE `id` = '".$eff['owner']."' LIMIT 1;");
    }
    mq("UPDATE `effects` SET `owner` = '$userid' WHERE `owner` = '$userid';");
  }
  if ($todo=="mftoabs") {
    echo "mftoabs($str)=".mftoabs($str)."<br>";
  }
  if ($todo=="showvar") {
    $var=getvar($str);
    if (!$var) echo date('d.m.Y H:i:s', $str);
    else echo "$var / ".date('d.m.Y H:i:s', $var)."<br>";
  }
  if ($todo=="drawbattle") {
    $str=stripslashes($str);
    $str=stripslashes($str);
    $fp = fopen ("backup/logs/battle$str.txt","a"); //открытие
    flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
    fputs($fp , '<hr><span class=date>'.date("H:i").'</span> '.($str2?"$str2":"").' Бой закончен. Ничья.<BR>'); //работа с файлом
    fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
    flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
    fclose ($fp); //закрытие
    mq("update battle set win=0 where id='$str'");
    mysql_query("UPDATE users SET `battle` =0, `nich` = `nich`+'1',`fullhptime` = ".time().",`fullmptime` = ".time().",`udar` = '0' WHERE `battle` = $str");
  }
  if ($todo=="checkstats") {
    $user=mqfa("select * from users where id='$userid'");
    $user11 = mysql_query("SELECT gsila,glovk,ginta,gintel FROM `inventory` WHERE dressed = 1 AND owner = $userid ");
    while($user12 = mysql_fetch_array($user11)){
      $sil=$sil+$user12['gsila'];
      $lov=$lov+$user12['glovk'];
      $int=$int+$user12['ginta'];
      $intel=$intel+$user12['gintel'];
    }

    $user22 = mysql_query("SELECT sila,lovk,inta FROM `effects` WHERE type = 188 AND owner = '$userid' union SELECT sila,lovk,inta FROM `obshagaeffects` WHERE type = 188 AND owner = '$userid'");
    while($user33 = mysql_fetch_array($user22)){
      if($user33['sila']>0){$sil=$sil+$user33['sila'];}
      if($user33['lovk']>0){$lov=$lov+$user33['lovk'];}
      if($user33['inta']>0){$int=$int+$user33['inta'];}
    }

    $sil2 = $user['sila']-$sil;
    $lov2 = $user['lovk']-$lov;
    $int2 = $user['inta']-$int;
    $intel2 = $user['intel']-$intel;
    $vyn2=$user['vinos'];
    $mudra=$user["mudra"];
    $spirit=$user["spirit"];
    $will=$user["will"];
    $freedom=$user["freedom"];
    $god=$user["god"];
    $sexy=$user["sexy"];
    $totstats=$sil2+$lov2+$int2+$intel2+$vyn2+$mudra+$spirit+$will+$freedom+$god+$sexy+$user["stats"];
    include "config/expstats.php";
    echo "$totstats / ".($expstats[$user['nextup']]+9+$vinoslvl[$user['level']]);
  }

  if ($todo=="resetmaster") {
    undressall($userid);
    $nu=mqfa1("select nextup from users where id='$userid'");
    $levelstats=statsat($nu);
    mq("UPDATE `users` SET `master` = $levelstats[master],noj=0,mec=0,topor=0,dubina=0,posoh=0, luk=0, mfire=0, mwater=0, mair=0, mearth=0, mlight=0, mgray=0, mdark=0 WHERE `id`='$userid'");
    echo mysql_error();
    mq("UPDATE `userdata` SET `master` = $levelstats[master],noj=0,mec=0,topor=0,dubina=0,posoh=0, luk=0, mfire=0, mwater=0, mair=0, mearth=0, mlight=0, mgray=0, mdark=0 WHERE `id`='$userid'");
    echo mysql_error();
  }
  if ($todo=="resetstats") {
    $user=mqfa("select * from users where id='$userid'");
    $levelstats=statsat($user['nextup']);
    undressall($userid);
    mysql_query("delete from effects where (sila<>0 or lovk<>0 or inta<>0 or vinos<>0 or intel<>0) and owner='$userid'");
    mysql_query("delete from obshagaeffects where (sila<>0 or lovk<>0 or inta<>0 or vinos<>0 or intel<>0) and owner='$userid'");
    mysql_query("UPDATE `users` SET `stats` = ".($levelstats['stats']-9).", `sila`=3,`lovk`=3,`inta`=3,`mudra`=0,`intel`=0,`spirit`= ".$levelstats["spirit"].", sexy=0,`vinos`= ".$levelstats["vinos"].",`maxhp`= ".$levelstats["vinos"]."*6,`maxmana`= 0,`mana`= 0 WHERE `id`='$userid' LIMIT 1;");
    mysql_query("UPDATE `userdata` SET `stats` = ".($levelstats['stats']-9).", `sila`=3,`lovk`=3,`inta`=3,`mudra`=0,`intel`=0,`spirit`= ".$levelstats["spirit"].", sexy=0,`vinos`= ".$levelstats["vinos"]." WHERE `id`='$userid' LIMIT 1;");
  }

  if ($todo=="copy2luka") {
    $rec=mqfa("select * from shop where id='$_GET[item]'");
    $sql="";
    foreach ($rec as $k=>$v) {
      if ($k=="id" || $k=="ecost" || $k=="gift" || $k=="sitost" || $k=="vid" || $k=="zoo" || $k=="zeton") continue;
      $sql.=", $k='$v'";
    }
    mq("insert into shop_luka set $_GET[zetontype]zeton='$_GET[cost]' $sql");
    echo mysql_error();
  }
  if ($todo=="nextup") {
    mq("update users set exp=nextup where id='$userid'");
    $user=mqfa("select nextup from users where id='$userid'");
    mq("UPDATE `users` SET `nextup` = ".$exptable[$user['nextup']][5].",`stats` = stats+".$exptable[$user['nextup']][0].",
    `master` = `master`+".$exptable[$user['nextup']][1].", `vinos` = `vinos`+".$exptable[$user['nextup']][2].",
    `maxhp` = `maxhp`+".($exptable[$user['nextup']][2]*6).",
    `money` = `money`+'".$exptable[$user['nextup']][3]."',`level` = `level`+".$exptable[$user['nextup']][4]."
    WHERE `id` = '$userid'");
    mq("update userdata set `stats` = stats+".$exptable[$user['nextup']][0].",
    `master` = `master`+".$exptable[$user['nextup']][1].", `vinos` = `vinos`+".$exptable[$user['nextup']][2].",
    `spirit` = `spirit`+".$exptable[$user['nextup']][6]." WHERE `id` = '$userid'");
    $user=mqfa("select login, level, exp, nextup from users where id='$userid'");
    echo "Level: <b>$user[login]: <font color=\"red\">$user[level]</font></b>, exp: $user[exp], next up: $user[nextup]";
  }

function takeshopitem1($item, $table="shop", $present="", $onlyonetrip="", $destiny=0, $fields=0, $uid=0) {
  global $user;
  if (!$uid) $uid=$user["id"];
  $r=mq("show fields from $table");
  $r2=mq("show fields from inventory");
  while ($rec=mysql_fetch_assoc($r2)) $flds[$rec["Field"]]=1;
  $rec1=mqfa("select * from $table where id='$item'");
  if ($present) {
    $rec1["present"]=$present;
    $rec1["cost"]=0;
    $rec1["ecost"]=0;
  }
  if ($fields) foreach ($fields as $k=>$v) $rec1[$k]=$v;
  $sql="";
  while ($rec=mysql_fetch_assoc($r)) {
    if (!@$flds[$rec["Field"]]) continue;
    if ($present) {
      if ($rec["Field"]=="maxdur") $rec1[$rec["Field"]]=1;
      if ($rec["Field"]=="cost") $rec1[$rec["Field"]]=2;
    }
    if ($rec["Field"]=="dategoden") $goden=$rec1[$rec["Field"]];
    if ($rec["Field"]=="id" || $rec["Field"]=="prototype" || $rec["Field"]=="dategoden") continue;
    $sql.=", `$rec[Field]`='".$rec1[$rec["Field"]]."' ";
  }  
  if ($fields["goden"]) $goden=$fields["goden"];           
  mq("insert into inventory set ".($present?"present='$present',":"").(@$rec1["podzem"]?"podzem=1,":"")." owner='$uid', prototype='$item' ".($onlyonetrip?", foronetrip=1":"").($goden?", dategoden='".($goden*60*60*24+time())."'":"").", destinyinv='$destiny' $sql");
  return array("img"=>$rec1["img"], "name"=>$rec1["name"]);
}

  if ($todo=="takeitem") {
    $uid=$_SESSION["uid"];
    $_SESSION["uid"]=7;
    if (!$str2) $flds=0;
    else $flds=array("goden"=>$str2);
    takeshopitem1($str, "shop", "", "", 2, $flds, 7);
    $_SESSION["uid"]=$uid;
  }

  if ($todo=="searchitem") {
    $item=mqfa("select * from shop where name='$str'");
    $id=$item["id"];
    if (!$id) echo "<b><font color=red>Item $str not found!</b></font>";
    else {
      echo "Item: $str, ID: <b><font color=red>$id</font></b>";
      showitem($item);
      $str=$id;
    }
  }

  if ($todo=="searchid") {
    $id=mqfa1("select id from users where login='$str'");
    if (!$id) echo "<b><font color=red>User $str not found!</b></font>";
    else {
      //echo "User: $str, ID: <b><font color=red>$id</font></b>
      //<a href=\"/inf.php?$id\" target=\"_blank\"><img src=\"/i/inf.gif\" border=\"0\"></a>";
      $userid=$id;
    }
  }

  if ($todo=="showemail") {
    $rec=mqfa("select id, email, login from users where id='$userid'");
    if (!$rec) echo "<b><font color=red>User $userid not found!</b></font>";
    else {
      echo "User: $rec[login], E-mail: <b><font color=red>$rec[email]</font></b>
      <a href=\"/inf.php?$userid\" target=\"_blank\"><img src=\"/i/inf.gif\" border=\"0\"></a>";
      $userid=$id;
    }
  }
  
  if ($todo=="recall") {
    mq("UPDATE `users`,`online` SET `users`.`room` = '1',`online`.`room` = '1' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '$userid' ");
  }

  if ($todo=="setclan") {
    $align=mqfa1("select align from clans where short='$str'");
    if ($align || $str=='adminion') {
      if ($userid==99999) $align="2.5";
      mq("update users set klan='$str', align='$align' where id='$userid'");
      mq("update allusers set klan='$str', align='$align' where id='$userid'");
      mq("update userdata set align='$align' where id='$userid'");
      mq("update alluserdata set align='$align' where id='$userid'");
    }
  }
  
  if ($todo=="viewaccounts") {
    if (@$_GET["takecr"]) mq("update bank set cr=cr-$_GET[takecr] where id='$_GET[account]'");
    if (@$_GET["takeecr"]) mq("update bank set ekr=ekr-$_GET[takeecr] where id='$_GET[account]'");
    $r=mq("select * from bank where owner='$userid'");
    echo "<table>";
    while ($rec=mysql_fetch_assoc($r)) {
      echo "<tr><td>$rec[id]</td><td>$rec[cr] кр</td><td>$rec[ekr] екр</td><td><a href=\"adminion.php?user=$userid&delaccount=$rec[id]&todo=viewaccounts\">Удалить счет</a></td><td><a href=\"adminion.php?user=$userid&pass123=$rec[id]&todo=viewaccounts\">Установить пароль 1234</a></td>
      <form action=\"adminion.php\"><input type=\"hidden\" name=\"todo\" value=\"viewaccounts\">
      <input type=\"hidden\" name=\"user\" value=\"$userid\">
      <input type=\"hidden\" name=\"account\" value=\"$rec[id]\">
      <td>Кредиты: <input type=\"text\" name=\"takecr\" size=\"1\">
      Екры: <input type=\"text\" name=\"takeecr\" size=\"1\">
      <input type=\"submit\" value=\"Снять\">
      </td>
      </form>
      </tr>";
    }
    echo "</table>";
  }
  
  if ($todo=="copypers") {
    $r=mq("select * from inventory where owner='$userid' and dressed=1");
    while ($rec=mysql_fetch_assoc($r)) {
      $sql="";
      foreach ($rec as $k=>$v) {
        if ($k=='id') continue;
        if ($k=='owner') $v='2735';
        if ($k=='dressed') $v=0;
        if ($sql) $sql.=", ";
        $sql.="`$k`='$v'";
      }
      mq("insert into inventory set $sql");
    }
  }

  if ($todo=="sethead") {
    $klan=mqfa1("select klan from users where id='$userid'");
    if ($klan) {
      mq("update clans set glava='$userid' where short='$klan'");
      $rec=mqfa("select id, glava, vozm from clans where short='$klan'");
      $vozm=unserialize($rec["vozm"]);
      $i=0;
      while ($i<=13) {
        $vozm[$rec["glava"]][$i]=1;
        $i++;
      }
      mq("update clans set vozm='".serialize($vozm)."' where id='$rec[id]'");
      mq("update users set status='<font color=#008080><b>Глава клана</b></font>' where id='$userid'");
    }
  }

  if ($todo=="allrights") {
    $klan=mqfa1("select klan from users where id='$userid'");
    if ($klan) {
      $rec=mqfa("select id, vozm from clans where short='$klan'");
      $vozm=unserialize($rec["vozm"]);
      $i=0;
      while ($i<=13) {
        $vozm[$userid][$i]=1;
        $i++;
      }
      mq("update clans set vozm='".serialize($vozm)."' where id='$rec[id]'");
    }
  }

  if ($todo=="backup") {
    $r=mq("show tables from backup");
    while ($rec=mysql_fetch_row($r)) {
      mq("truncate table backup.$rec[0]");
      echo mysql_error();
      mq("insert into backup.$rec[0] (select * from $rec[0])");
      $e=mysql_error();
      if ($e) echo $e."insert into backup.$rec[0] (select * from $rec[0])";
    }
  }

  if ($todo=="resetmax") {
    resetmax($userid);
    //mq("update users set maxhp=vinos*6 where id='$userid'");
  }

  if ($todo=="undress") {
    undressall($userid);
    mq("update users set sergi='', kulon='', perchi='', weap='', bron='', rybax='', plaw='', r1='', r2='', r3='', helm='', shit='', boots='', belt='', naruchi='', leg='', m1='', m2='', m3='', m4='', m5='', m6='', m7='', m8='', m9='', m10='', m11='', m12='' where id='$userid'");
    mq("update inventory set dressed=0 where owner='$userid'");
  }

  if ($todo=="heal") {
    $r=mq("select id from effects where owner='$userid' and (type=11 or type=12 or type=13 or type=14)");
    while ($rec=mysql_fetch_assoc($r)) {
      deltravma($rec["id"]);
    }
    mq("UPDATE `users` set hp=maxhp, mana=maxmana where `id` = '$userid' ");
  }

  if ($todo=="killbot") {
    mq("UPDATE `bots` set hp=1 where hp>0 and `prototype` = '$userid' ");
  }

  if ($todo=="changelogin" && $userid && $str) {
    $i=mqfa1("select id from users where login='$str'");
    if (!$i) $i=mqfa1("select id from allusers where login='$str'");
    if (!$i) {
      $old=mqfa1("select login from users where id='$userid'");
      mq("update users set login='$str' where id='$userid'");
      mq("update users set married='$str' where married='$old'");
      mq("update inventory set present='$str' where present='$old'");
    } else echo "<b>Login $str exists!</b>";
  }

  if ($todo=="givesteps") {
    //mq("UPDATE `users` set krit=100, counter=100, block2=100, hit=100, hp2=100, parry=100, s_duh=10000, mana=maxmana where `id` = '$userid' ");
    //mq("UPDATE `person_on` set pr_active=1, pr_wait_for=0 where `id_person` = '$userid' ");
    $dat=implode("",file(CHATROOT."bus/$userid.dat"));
    $dat=unserialize($dat);
    $dat["hit"]=25;
    $dat["krit"]=25;
    $dat["block2"]=25;
    $dat["counter"]=25;
    $dat["parry"]=25;
    $dat["hp2"]=25;
    $dat["s_duh"]=10000;
    $f=fopen(CHATROOT."bus/$userid.dat", "wb+");
    fwrite($f, serialize($dat));
    fclose($f);

    $b=mqfa1("select battle from users where id='$userid'");
    if ($b) {
      $effs=mqfa1("select priems from battleunits where user='$userid' and battle='$b'");
      $effs=unserialize($effs);
      foreach ($effs as $k=>$v) {
        $effs[$k]["pr_wait_for"]=0;
        $effs[$k]["pr_active"]=1;
        $effs[$k]["wait"]=0;
        $effs[$k]["active"]=1;
      }
      mq("update battleunits set priems='".serialize($effs)."' where user='$userid' and battle='$b'");
    }                                                                        
  }

  if ($todo=="remtime") {
    $b=mqfa1("select battle from users where id='$userid'");
    mq("update battle set timeout=100 where id='$b'");
  }

  if ($todo=="time1min") {
    $b=mqfa1("select battle from users where id='$userid'");
    mq("update battle set timeout=1 where id='$b'");
  }


  if ($todo=="lastbattle") {
    $rec=mqfa("select * from battle where t1='$userid' or t2='$userid' or t1 like '$userid;' or t2 like '$userid;' or t1 like ';$userid' or t2 like ';$userid' order by id desc ");
    if ($rec) echo "Battle: <a href=\"/logs.php?log=$rec[id]\">$rec[id]</a>";
  }

  if ($todo=="opencanal") {
    $user=mqfa1("select login from users where id='$userid'");
    mq("update `visit_podzem` set time=1 WHERE `login`='".$user."' and `time`>'0'");
  }

  if ($todo=="takestats") {
    mq("update users set $_GET[stat]=$_GET[stat]-$str where id='$userid'");
  }
  if ($userid) {
    echo "Пользователь: $userrec[login], ID: <b><font color=red>$userid</font></b>
    <a href=\"/inf.php?$userid\" target=\"_blank\"><img src=\"/i/inf.gif\" border=\"0\"></a> $userrec[money]/$userrec[ekr]";
  }  
  if ($str2) {
    echo "<table><tr><td>Clan: <b>".mqfa1("select name from clans where short='$str2'")."</b>
    </td><td><a href=\"/claninf.php?$str2\" target=\"_blank\"><img src=\"".IMGBASE."/i/klan/$str2.gif\" border=\"0\"></a></td>
    <td><a href=\"/claninf.php?$str2\" target=\"_blank\"><img src=\"".IMGBASE."/i/klan/{$str2}_big.gif\" border=\"0\"></a></td></tr></table>";
  }  
  //mysql_query("update users set maxhp=300 where id='7'");
  //mysql_query("update users set hp=maxhp where id='7'");
  //mysql_query("update users set mana=300, maxmana=300, battle=0, mec=20, sila=20, lovk=20, inta=20, vinos=20, money=2000, intel=99, level=4 where id='7'");
?>
<script>
function submitfm(t) {
  document.form1.todo.value=t;
  document.form1.submit();
}
</script>
<div>&nbsp;</div>
<form action="adminion.php" name="form1">
<input type="hidden" name="todo">
ID пользователя: <input type=text name="user" size=3 value="<?=$userid?>">
Строка значений: <input type=text name="str" size=3 value="<?=$str?>">
String param2: <input type=text name="str2" size=3 value="<?=$str2?>">
Slot: <select name=slot>
<option value=1>sergi</option>
<option value=2>kulon</option>
<option value=3>weap</option>
<option value=43>rybax</option>
<option value=42>bron</option>
<option value=41>plaw</option>
<option value=5>r1</option>
<option value=6>r2</option>
<option value=7>r3</option>
<option value=8>helm</option>
<option value=9>perchi</option>
<option value=10>shit</option>
<option value=11>boots</option>
<option value=12>m1</option>
<option value=13>m2</option>
<option value=14>m3</option>
<option value=15>m4</option>
<option value=16>m5</option>
<option value=17>m6</option>
<option value=18>m7</option>
<option value=19>m8</option>
<option value=20>m9</option>
<option value=21>m10</option>
<option value=22>naruchi</option>
<option value=23>belt</option>
<option value=24>leg</option>
<option value=25>m11</option>
<option value=26>m12</option>
</select>
Тип правления:
<select name=clandem>
<option value=1>Анархия</option>
<option value=2>Монархия</option>
<option value=3>Диктатура</option>
<option value=4>Демократия</option>
</select>
Склонность: <select name=align>
<option value="0.98">Тёмный</option>
<option value="0.99">Светлый</option>
<option value="7">Нейтрал</option>
<option value="1.1">Паладин</option>
<option value="3.01">Тарман</option>
<option value="2.5">Ангел</option>
</select>
<br>
<input type=button onclick="submitfm('backup');" value="Backup DB">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('nextup');" value="Next up">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('setshadow');" value="Set shadow">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('searchid');" value="Search ID">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('searchitem');" value="Search item">&nbsp;&nbsp;&nbsp;<br>
<input type=button onclick="submitfm('takeitem');" value="Take shop item">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('lastbattle');" value="Last battle">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('recall');" value="Recall">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('heal');" value="Heal">&nbsp;&nbsp;&nbsp;<br>
<input type=button onclick="submitfm('givesteps');" value="Give steps">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('changelogin');" value="Change login">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('remtime');" value="Remove timeout">&nbsp;&nbsp;&nbsp;<br>
<input type=button onclick="submitfm('time1min');" value="Timeout 1 minute">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('opencanal');" value="Enter canalisation">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('viewinventory');" value="Посмотреть инвентарь">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('killbot');" value="Kill bot">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('undress');" value="Снять всё">&nbsp;&nbsp;&nbsp;<br>
<input type=button onclick="submitfm('resetmax');" value="Reset max">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('checkstats');" value="Check stats">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('resetstats');" value="Сброс статов">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('resetmaster');" value="Сброс умений">&nbsp;&nbsp;&nbsp;<br>
<input type=button onclick="submitfm('viewdelo');" value="View operations">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('viewarchdelo');" value="View archive operations">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('sethead');" value="Set clan head">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('allrights');" value="Give all rights">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('setclan');" value="Set clan">&nbsp;&nbsp;&nbsp;<br>
<input type=button onclick="submitfm('givechest');" value="Give chest">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('evaluate');" value="Evaluate player">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('dropitem');" value="Drop item">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('gotoroom');" value="Go to room">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('giveitem');" value="Give item">&nbsp;&nbsp;&nbsp;<br>
<input type=button onclick="submitfm('drawbattle');" value="Draw battle">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('addchatmsg');" value="Add 2 chat">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('chatto0');" value="Chat to 0">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('viewchat');" value="View chat">&nbsp;&nbsp;&nbsp;<br>
<input type=button onclick="submitfm('viewallchat');" value="View all chat">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('itemimage');" value="Set item image">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('mftoabs');" value="mftoabs()">&nbsp;&nbsp;&nbsp;<br>
<input type=button onclick="submitfm('viewstorage');" value="View storage">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('copypers');" value="Copy user">&nbsp;&nbsp;&nbsp;<br>
<input type=button onclick="submitfm('viewaccounts');" value="Посмотреть банковские счета">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('setclandem');" value="Set clandem">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('setpass2');" value="Установить 2 пароль">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('showemail');" value="Show email">&nbsp;&nbsp;&nbsp;<br>
<input type=button onclick="submitfm('delfromstorage');" value="Delete items from storage">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('setalign');" value="Set align">&nbsp;&nbsp;&nbsp;<br>
<input type=button onclick="submitfm('setpass');" value="Установить пароль">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('delanimal');" value="Delete animal">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('setinvis')" value="Set invisible">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('setclanalign')" value="Set clan align">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('endbattle')" value="End battle">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('viewquesttop')" value="View quest top">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('deleffects')" value="Delete effects">&nbsp;&nbsp;&nbsp;<br>
<input type=button onclick="submitfm('setclansite')" value="Set clan site">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('userclan')" value="User's clan">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('outfrombs')" value="Take from BS">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('viewbus')" value="View battleunits">&nbsp;&nbsp;&nbsp;<br>
<input type=button onclick="submitfm('viewitems')" value="View items">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('countitems')" value="Count items">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('recountstats')" value="Пересчет статов">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('countstats')" value="Show stats">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('givemedal')" value="Give medal">&nbsp;&nbsp;&nbsp;<br>
<input type=button onclick="submitfm('givestats')" value="Give extra stats">&nbsp;&nbsp;&nbsp;
<input type=button onclick="submitfm('savelog')" value="Save log">&nbsp;&nbsp;&nbsp;<br>
<input type=button onclick="submitfm('showvar')" value="Show variable">&nbsp;&nbsp;&nbsp;
<hr>
<input type=button onclick="submitfm('bsplus1min');" value="+1 min BS">
<input type=button onclick="submitfm('bsplus10min');" value="+10 min BS">
<input type=button onclick="submitfm('bsplus60min');" value="+60 min BS">
<input type=button onclick="submitfm('bs1min');" value="-1 min BS">
<input type=button onclick="submitfm('bs10min');" value="-10 min BS">
<input type=button onclick="submitfm('bs60min');" value="-60 min BS">
<input type=button onclick="submitfm('switchbs');" value="Change BS type">
<input type=button onclick="if (confirm('Are you sure?')) submitfm('startbs');" value="Start BS">

<input type=button onclick="submitfm('siegeplus1min');" value="+1 min siege">
<input type=button onclick="submitfm('siegeplus10min');" value="+10 min siege">
<input type=button onclick="submitfm('siegeplus60min');" value="+60 min siege">
<input type=button onclick="submitfm('siege1min');" value="-1 min siege">
<input type=button onclick="submitfm('siege10min');" value="-10 min siege">
<input type=button onclick="submitfm('siege60min');" value="-60 min siege">
<input type=button onclick="if (confirm('Are you sure?')) submitfm('startsiege');" value="Start Siege">

<br>
<select name="stat">
<option value="sila">sila</option>
<option value="inta">inta</option>
<option value="lovk">lovk</option>
<option value="vinos">vinos</option>
<option value="intel">intel</option>
</select>
<input type=button onclick="submitfm('takestats');" value="Take stats">

</form>
<?
  if ($todo=="viewitems") {
    $r=mq("select * from inventory where owner='$userid' and name='$str'");
    echo "<table>";
    while ($rec=mysql_fetch_assoc($r)) {
      echo "<tr><td>$rec[name]</td><td>$rec[koll]&nbsp;&nbsp;&nbsp;</td><td>$rec[id]</td></tr>";
    }
    $r=mq("select inventory.* from obshagastorage left join inventory on inventory.id=obshagastorage.id_it where obshagastorage.pers='$userid' and inventory.name='$str'");
    while ($rec=mysql_fetch_assoc($r)) {
      echo "<tr><td>$rec[name]</td><td>$rec[koll]</td><td>$rec[id]</td></tr>";
    }
    echo "</table>";
  }
  if ($todo=="countitems") {
    $r=mq("select * from inventory where name='$str' and owner>0");
    $items=array();
    while ($rec=mysql_fetch_assoc($r)) {
      $items[$rec["owner"]]+=$rec["koll"];
    }
    $r=mq("select inventory.* from obshagastorage left join inventory on inventory.id=obshagastorage.id_it where obshagastorage.pers='$userid' and inventory.name='$str'");
    while ($rec=mysql_fetch_assoc($r)) {
      $items[$rec["owner"]]+=$rec["koll"];
    }
    echo "<table><tr><td><b>User</b></td><td><b>Qty</b></td></tr>";
    foreach ($items as $k=>$v) {
      if ($v<500) continue;
      echo "<tr><td><a href=inf.php?$k target=_blank>$k</a></td><td>$v</td></tr>";
    }
    echo "</table>";
  }
  if ($todo=="viewquesttop") {
    $r=mq("select quests.step, quests.user, users.login from quests left join users on quests. user=users.id where quests.quest='$str' order by quests.step desc limit 0, 20");
    echo "<table>";
    while ($rec=mysql_fetch_assoc($r)) {
      echo "<tr><td>$rec[step]</td><td><b>$rec[login] ($rec[user])</b></td></tr>";      
    }
    echo "</table>";
  }
  if (@$_GET["viewlogs"]) {
    echo '<TABLE width=100% cellspacing=0 cellpadding=0><TR>
    <TD valign=top>&nbsp;<A HREF="zayavka.php?logs='.
    date("d.m.y",mktime(0, 0, 0, substr($_REQUEST['logs'],3,2), substr($_REQUEST['logs'],0,2)-1, "20".substr($_REQUEST['logs'],6,2)))
    .'&filter='.(($_REQUEST['filter'])?$_REQUEST['filter']:$user['login']).'">< Предыдущий день</A></TD>
    <TD valign=top align=center><H3>Записи о завершенных боях за '.(($_REQUEST['logs']!=1)?"{$_REQUEST['logs']}":"".date("d.m.y")).'</H3></TD>
    <TD  valign=top align=right><A HREF="zayavka.php?logs='.
    date("d.m.y",mktime(0, 0, 0, substr($_REQUEST['logs'],3,2), substr($_REQUEST['logs'],0,2)+1, "20".substr($_REQUEST['logs'],6,2)))
    .'&filter='.(($_REQUEST['filter'])?$_REQUEST['filter']:$user['login']).'">Следующий день ></A>&nbsp;</TD>
    </TR><TR><TD colspan=3 align=center>Показать только бои персонажа: <INPUT TYPE=text NAME=filter value="'.(($_REQUEST['filter'])?$_REQUEST['filter']:$user['login']).'"> за <INPUT TYPE=text NAME=logs size=12 value="'.(($_REQUEST['logs']!=1)?"{$_REQUEST['logs']}":"".date("d.m.y")).'"> <INPUT TYPE=submit value="фильтр!"></TD>
    </TR></TABLE>';

    //$u = mysql_fetch_array(mysql_query("SELECT `id` FROM `users` WHERE `login` = '".(($_REQUEST['filter'])?"{$_REQUEST['filter']}":"{$user['login']}")."' LIMIT 1;"));
    $u[0]=$userid;

    $data = mysql_query("SELECT * FROM `battle` WHERE ((`t1` LIKE '%;{$u[0]};%' OR `t1` LIKE '{$u[0]}' OR `t1` LIKE '{$u[0]};%' OR `t1` LIKE '%;{$u[0]}') OR (`t2` LIKE '%;{$u[0]};%' OR `t2` LIKE '{$u[0]}' OR `t2` LIKE '{$u[0]};%' OR `t2` LIKE '%;{$u[0]}')) ORDER by `id` desc limit 0, 100");
    while($row = @mysql_fetch_array($data)) {
      echo "<span class=date>{$row['date']}</span>";
      //$z = split(";",$row['t1']);
      /*foreach($z as $k=>$v) {
          if ($k > 0) {  echo ","; }
          nick2($v);
      }*/
      echo $row['t1hist'];
      if ($row['win'] == 1) { echo '<img src='.IMGBASE.'/i/flag.gif>'; }
      echo " против ";
      //$z = split(";",$row['t2']);
      /*foreach($z as $k=>$v) {
          if ($k > 0) {  echo ","; }
          nick2($v);
      }*/
      echo $row['t2hist'];
      if ($row['win'] == 2) { echo '<img src='.IMGBASE.'/i/flag.gif>'; }
      if ($row['type'] == 10) {
      $rr = "<IMG SRC=\"".IMGBASE."/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"Кровавый поединок\"> ";
      } elseif ($row['blood'] && ($row['type'] == 5 OR $row['type'] == 4)) {
        $rr = "<IMG SRC=\"".IMGBASE."/i/fighttype5.gif\" WIDTH=20 HEIGHT=20 ALT=\"кулачный бой\"><IMG SRC=\"".IMGBASE."/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"Кровавый поединок\"> ";
      } elseif ($row['blood'] && ($row['type'] == 2 OR $row['type'] == 3 OR $row['type'] == 6)) {
        $rr = "<IMG SRC=\"".IMGBASE."/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"Кровавый поединок\"> ";
      } elseif ($row['type'] == 5 OR $row['type'] == 4) {
        $rr = "<IMG SRC=\"".IMGBASE."/i/fighttype4.gif\" WIDTH=20 HEIGHT=20 ALT=\"кулачный бой\"> ";
      } elseif ($row['type'] == 3 OR $row['type'] == 2) {
        $rr = "<IMG SRC=\"".IMGBASE."/i/fighttype3.gif\" WIDTH=20 HEIGHT=20 ALT=\"групповой бой\"> ";
      } elseif ($row['type'] == 1) {
        $rr = "<IMG SRC=\"".IMGBASE."/i/fighttype1.gif\" WIDTH=20 HEIGHT=20 ALT=\"физический бой\"> ";
      } 
      echo $rr;
      echo " <a href='logs.php?log={$row['id']}' target=_blank>>></a><BR>";
      $i++;
    }
    if($i==0) {
      echo '<CENTER><BR><BR><B>В этот день не было боев, или же, летописец опять потерял свитки...</B><BR><BR><BR></CENTER>';
    }
    echo '<HR><BR>';
  }
  $dtt=mqfa1("select value from variables where var='deztowtype'");
?>
БС начало: <span class=date><?=date("d.m.y H:i",mqfa1("select value from variables where var='startbs'"))?></span>
<?
  if ($dtt==1) echo "common battle";
  if ($dtt==2) echo "masters' battle";
?><BR>
Siege start: <span class=date><?
$s=mqfa1("select value from variables where var='siege'");
if ($s>10) echo date("d.m.y H:i",$s);
elseif ($s==1) echo "Under walls";
elseif ($s==2) echo "On walls";
else echo "Owner defeated";
?></span><BR>
Онлайн: <? echo mnr("select distinct(users.ip) from `online` left join users on users.id=online.id WHERE `date`>=".time()."-60")?>
&nbsp;&nbsp;&nbsp;Сегодня: <? echo mnr("select distinct(users.ip) from `online` left join users on users.id=online.id WHERE `date`>=".time()."-(60*60*24)")?>
&nbsp;&nbsp;&nbsp;Last week: <? echo mnr("select distinct(users.ip) from `online` left join users on users.id=online.id WHERE `date`".time()."-(60*60*24*7)")?><br><br>
<a href="adminion.php?setprices=1">Set art prices</a>
<a href="adminion.php?toluka=1">Move to luka</a>
<a href="adminion.php?deztow=1">Who in death tower</a>
<a href="adminion.php?online=1">Кто в онлайне</a>
<a href="adminion.php?shop=1">Ran out in shop</a>
<a href="adminion.php?createbot=1">Create bot</a>
<a href="adminion.php?viewlogs=1&user=<?=$userid?>">View logs</a>
<a href="adminion.php?cleardb=1">Clear db</a>
<?
  if ($todo=="viewstorage") {
    $login=mqfa1("select login from users where id='$userid'");
    $r=mq("SELECT * FROM `_delo` WHERE text LIKE '%$login%' AND text LIKE '%сундук%' order by id desc");
    echo "<table>";
    while ($rec=mysql_fetch_assoc($r)) {
      echo "<tr><td>".date('d.m.Y h:m', $rec["date"])."</td><td>$rec[text]</td></tr>";
    }
    echo "</table>";
  }
  if (@$_GET["createbot"]) {
    echo "<form action=\"adminion.php?createbot=1\" method=\"post\">
    <input type=hidden name=todo value=createbot>
    <table>
    <tr><td>Name:</td><Td><input type=text name=\"login\" value=\"".@$_POST["login"]."\"></td></tr>
    <tr><td>Level:</td><Td><input type=text name=\"level\" value=\"".@$_POST["level"]."\"></td></tr>
    <tr><td>Sila:</td><Td><input type=text name=\"sila\" value=\"".@$_POST["sila"]."\"></td></tr>
    <tr><td>Lovk:</td><Td><input type=text name=\"lovk\" value=\"".@$_POST["lovk"]."\"></td></tr>
    <tr><td>Inta:</td><Td><input type=text name=\"inta\" value=\"".@$_POST["inta"]."\"></td></tr>
    <tr><td>Vinos:</td><Td><input type=text name=\"vinos\" value=\"".@$_POST["vinos"]."\"></td></tr>
    <tr><td>HP:</td><Td><input type=text name=\"hp\" value=\"".@$_POST["hp"]."\"></td></tr>
    <tr><td>Shadow:</td><Td><input type=text name=\"shadow\" value=\"".@$_POST["shadow"]."\"></td></tr>
    <tr><td>Sex:</td><Td><select name=sex><option value=1>Male</option>
    <option value=0 ".(@$_POST["sex"]===0?"selected":"").">Female</option>
    </td></tr>
    <tr><td></td><td><input type=submit value=\"Create\"></td></tr>
    </form>";
  }
  if (@$_GET["setprices"]) {
    $r=mq("select * from inventory where artefact=1 order by name limit 62, 20");
    while ($rec=mysql_fetch_assoc($r)) {

      echo "<a name=\"item$rec[id]\"></a><hr><form action=\"adminion.php#item$rec[id]\">
      <input type=hidden name=setprices value=1>
      <input type=hidden name=todo value=\"setprice\">
      <input type=hidden name=item value=\"$rec[id]\">
      <input type=text name=cost value=\"$rec[cost]\">
      <input type=submit value=\"Save\">
      </form>";
      echo showitem($rec);
    }
  }

  if ($todo=="viewinventory") {
    if (@$_GET["delitem"]) mq("delete from inventory where id='$_GET[delitem]' and dressed=0");
    $r=mq("select * from inventory where owner='$userid' and dressed=0");
    while ($rec=mysql_fetch_assoc($r)) {
      if ($rec["dressed"]) echo "<b>Dressed</b>"; else echo "<a href=\"adminion.php?todo=viewinventory&user=$userid&delitem=$rec[id]\" onclick=\"return confirm('Delete $rec[name]');\">Delete</a>";
      echo showitem($rec)."</small>";
    }
  }

  if (@$_GET["toluka"]) {
    $r=mq("select * from shop where nlevel=8 and count>0 and name not in (select name from shop_luka) order by name");
    while ($rec=mysql_fetch_assoc($r)) {
      echo "<a name=\"item$rec[id]\"></a><hr><form action=\"adminion.php#item$rec[id]\">
      <input type=hidden name=toluka value=1>
      <input type=hidden name=todo value=\"copy2luka\">
      <input type=hidden name=item value=\"$rec[id]\">
      <input type=text name=cost value=\"$rec[cost]\">
      <select name=zetontype>
      <option value=\"\">Простой</option>
      <option value=\"silver\">Серебрянный</option>
      <option selected value=\"gold\">Золотой</option>
      </select>
      <input type=submit value=\"Save\">
      </form>";
      echo showitem($rec);
    }
  }
  if (@$_GET["deztow"]) {
    $r=mq("select id, login from users where in_tower=1");
    echo "<br><br><b>In tower:</b><br>";
    while ($rec=mysql_fetch_assoc($r)) {
      echo "$rec[login]<br>";
    }
    $r=mq("select users.id, users.login from deztow_stavka left join users on deztow_stavka.owner=users.id");
    echo "<br><b>Stakes:</b><br>";
    while ($rec=mysql_fetch_assoc($r)) {
      echo "$rec[login]<br>";
    }
  }
  if (@$_GET["online"]) {
    $r=mq("select users.login, users.level, users.id from `online` left join users on users.id=online.id WHERE `date`>=".time()."-60 order by users.login");
    echo "<br>";
    while ($rec=mysql_fetch_assoc($r)) {
      echo "$rec[login] [$rec[level]] <a href=\"/inf.php?$rec[id]\" target=\"_blank\"><img src=\"/i/inf.gif\" border=\"0\"></a><br>";
    }
  }
  if (@$_GET["shop"]) {
    $r=mq("select id, name from shop where count=0 order by id");
    echo "<br>";
    echo "<form method=\"post\" action=\"adminion.php?shop=1\"><input type=hidden name=todo value=refillshop>";
    echo "<table>";
    while ($rec=mysql_fetch_assoc($r)) {
      echo "<tr><td>$rec[name]</td><td><input type=checkbox name=\"item$rec[id]\">";
    }
    echo "</table><input type=submit value=\"Add\"></form>";
  }
  function cleardir($dir, $id) {
    $d=opendir($dir);
    $i=0;
    while ($f=readdir($d)) {
      $n=str_replace(".txt","",$f);
      $n=str_replace("battle","",$n);
      if ($n==(int)$n && $n<$id) {
        $i++;
        unlink("$dir/$f");
      }
      if ($i>10000) break;
    }
    echo "Deleted $i files<br>";
  }
  if (@$_GET["cleardb"]) {
    $id=mqfa1("select max(id) from battle where to_days(now())-to_days(`date`)>1");
    mq("delete from battle where id<=$id");
    mq("delete from bots where battle not in (select id from battle)");
    mq("delete from battleunits where battle not in (select id from battle)");
    mq("delete from archive.battleunits where battle not in (select id from battle)");
    mq("delete from battleunits where battle in (select id from battle where teams='N;')");
    mq("delete from battleeffects where battle not in (select id from battle)");
    mq("delete from logs where id not in (select id from battle)");
    $mintime=time()-(60*60*24*14);
    mq("insert into archive.delo (select * from delo where date<=$mintime)");
    mq("delete from delo where date<=$mintime");
    mq("insert into archive.lichka (select * from lichka where date<=$mintime)");
    mq("delete from lichka where date<=$mintime");

    mq("insert into archive.iplog (select * from iplog where date<=$mintime)");
    mq("delete from iplog where date<=$mintime");    
    mq("insert into archive.delo_multi(SELECT * FROM `delo_multi` WHERE date_add(date, interval 14 day)<now())");
    mq("delete FROM `delo_multi` WHERE date_add(date, interval 14 day)<now()");
    mq("delete FROM treats where effect not in (select id from effects)");
    mq("insert into archive.kaznalog (select * from kaznalog where id not in (select id from archive.kaznalog))");
    $i=mqfa1("select id from kaznalog where `date` like '".date('d.m.y', time()-(60*60*24*30))."%'");
    if ($i) mq("delete from kaznalog where id<=$i");
    
    mq("OPTIMIZE TABLE `battle`, `battleunits`, `inventory`, `logs`, `delo` ");
    $id=mqfa1("select min(id) from battle");
    cleardir("backup/logs", $id);
    $d=opendir("/dev/shm/bus");
    while ($f=readdir($d)) {
      if ($f=="." || $f=="..") continue;
      $id=str_replace(".dat","",$f);
      if ($id>__BOTSEPARATOR__) {
        $inbattle=mqfa1("select battle from bots where id='$id'");
      } else {
        $inbattle=mqfa1("select battle from users where id='$id'");
      }
      if (!$inbattle) unlink("/dev/shm/bus/$f");
    }
    $r=mq("select users.id from `online` left join users on users.id=online.id WHERE `date`>=".time()."-60 order by users.login");
    $online=array();
    while ($rec=mysql_fetch_assoc($r)) {
      $online["$rec[id]"]=1;
    }
    $d=opendir("/dev/shm/chardata");
    while ($f=readdir($d)) {
      if ($f=="." || $f=="..") continue;
      $tmp=explode(".", $f);
      if (!$online[$tmp[0]]) unlink("/chardata/$f");
    }
  }

  //$id=mqfa1("select min(id) from battle");
  //cleardir("backup/logs", $id);
  //echo "<br><br>";
  $r=mq("select users.id from `online` left join users on users.id=online.id WHERE `date`>=".time()."-60");
  while ($rec=mysql_fetch_assoc($r)) {
    $i=mqfa1("select id from allusers where id='$rec[id]'");
    if (!$i) echo "Not found user: <a href=\"inf.php?$rec[id]\" target=\"_blank\">".mqfa1("select login from users where id='$rec[id]'")."</a><br>";
  }

  function effect($left, $top, $img, $name) {
    $name=str_replace("<b>","", $name);
    $name=str_replace("</b>","", $name);
    $name=str_replace("<br>"," ", $name);
    return "<div style=\"position:absolute; left:{$left}px; top:{$top}px; width:40px; height:25px; z-index:3\"><acronym title='$name'><IMG width=40 height=25 src='$img'></acronym> </div>";
  }

  if ($todo=="viewbus") {
    $r=mq("select battleunits.mfddrob, battleunits.mfdkol, battleunits.mfdwater, battleunits.manausage, battleunits.minusmfdmag, battleunits.minusmfdwater, battleunits.minusmfdair, battleunits.mfparir, battleunits.mfmagp, battleunits.mfwater, battleunits.mfcontr, battleunits.noj, battleunits.mech, battleunits.topor, battleunits.dubina, battleunits.mfire, battleunits.mwater, battleunits.mair, battleunits.mearth, battleunits.mfdmag, minusmfdearth, cost, cost2, mfdhit, mfdhit1,mfdhit2, mfdhit3, mfdhit4, mfdhit5, battleunits.mfhitp, battleunits.mfdrob, battleunits.mech, battleunits.noj, battleunits.topor, battleunits.dubina, mfkrit, mfakrit, mfuvorot, mfauvorot, persout1, archive.battleunits.sila, archive.battleunits.lovk, archive.battleunits.inta, archive.battleunits.vinos, archive.battleunits.intel, archive.battleunits.mudra, archive.battleunits.effects, battleunits.level, users.login from archive.battleunits left join users on archive.battleunits.user=users.id where archive.battleunits.battle='$str'");    
    echo mysql_error();
    echo "<table>";
    $i=0;
    while ($rec=mysql_fetch_assoc($r)) {
      $po=persout($rec);
      echo "<td><br><center><b>$rec[login]</b> [$rec[level]]</center>
      <table><tr><td>Сила: $rec[sila]</td><td>
      Ловкость: $rec[lovk]</td></tr>
      <tr><td>Интуиция: $rec[inta]</td><td>Вынословисть: $rec[vinos]</td></tr>
      <tr><td>Интеллект: $rec[intel]</td><td>Мудрость: $rec[mudra]</td></tr>
      <tr><td>Крит: $rec[mfkrit]</td><td>Антикрит: $rec[mfakrit]</td></tr>
      <tr><td>Уворот: $rec[mfuvorot]</td><td>Точность: $rec[mfauvorot]</td></tr>
      <tr><td>Мечи: $rec[mech]</td><td>Топоры: $rec[topor]</td></tr>
      <tr><td>Ножи: $rec[noj]</td><td>Дубины: $rec[dubina]</td></tr>
      <tr><td>Парирование: $rec[mfparir]</td><td>Контрудар: $rec[mfcontr]</td></tr>
      <tr><td>Сила урона: $rec[mfhitp]</td><td>Дробящего: $rec[mfdrob]</td></tr>
      <tr><td>Мощность магии: $rec[mfmagp]</td><td>Мощность воды: $rec[mfwater]</td></tr>
      <tr><td>Магия огня: $rec[mfire]</td><td>Магия воды: $rec[mwater]</td></tr>
      <tr><td>Магия земли: $rec[mearth]</td><td>Магия воздуха: $rec[mair]</td></tr>
      <tr><td>Меч: $rec[mech]</td><td>Кинжал: $rec[noj]</td></tr>
      <tr><td>Топор: $rec[topor]</td><td>Дубина: $rec[dubina]</td></tr>
      <tr><td>Цена жмода: $rec[cost]</td><td>Цена жмода2: $rec[cost2]</td></tr>
      <tr><td>Защита от магии: $rec[mfdmag]</td><td>Защита от воды: $rec[mfdwater]</td></tr>
      <tr><td>Понижение расхода маны: $rec[manausage]</td><td>Понижение защиты от огня: $rec[minusmfdfire]</td></tr>
      <tr><td>Понижение антимагии: $rec[minusmfdmag]</td><td>Понижение защиты от земли: $rec[minusmfdearth]</td></tr>
      <tr><td>Понижение защиты от воды: $rec[minusmfdwater]</td><td>Понижение защиты от воздуха: $rec[minusmfdair]</td></tr>
      <tr><td colspan=2>Защита от урона: $rec[mfdhit] ($rec[mfdhit1]/$rec[mfdhit2]/$rec[mfdhit3]/$rec[mfdhit4]/$rec[mfdhit5])</td></tr>
      <tr><td>Защита от колющего: $rec[mfdkol]</td><td>Дробящего: $rec[mfddrob]</td></tr>
      </table>
      $po</td>";
      $i++;
      if ($i%5==0) echo "</tr><tr>";
    }
    echo "</table>";
  }
  echo "Time: ".date("H:i:s")."<br><br>";
?>

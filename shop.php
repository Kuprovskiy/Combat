<?php
  $unlimitedbackpack=array(7, 2372);
    session_start();
    if ($_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    $presents=array(2093, 2092, 1834, 1832, 1833);
    //$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
    include "functions.php";
    if (@$_POST["otdel"]) $_GET["otdel"]=$_POST["otdel"];
    $d = mysql_fetch_array(mysql_query("SELECT sum(`massa`) FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `setsale` = 0 ; "));
    if ($user['room'] != 22 && $user['room'] != 59 && $user['room'] != 37) { header("Location: main.php");  die(); }
    if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }

    if ($_GET['sed']) {
        $grass = mqfaa("SELECT name FROM smallitems WHERE id >= 24 AND id <= 36");
        $grassCond = "name = '" . $grass[0]['name'] . "'";
        for ($i = 1; $i < count($grass); $i++ ) {
            $grassCond .= " OR name = '" . $grass[$i]['name'] . "'";
        }
        $dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `dressed`= 0 AND `id` = '{$_GET['sed']}' AND `owner` = '{$_SESSION['uid']}'  AND `podzem`=0 AND `clan` = '' AND `setsale`=0  and `ecost`=0 AND `gift`=0 AND `honor`=0 and (cost>0 OR $grassCond) LIMIT 1;"));
        //$dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `dressed`= 0 AND `id` = '{$_GET['sed']}' AND `owner` = '{$_SESSION['uid']}'  AND `podzem`=0 AND `clan` = '' AND `setsale`=0  and `ecost`=0 AND `gift`=0 AND `honor`=0 and cost>0 LIMIT 1;"));
        if ($dress) {
            if($dress["podzem"] == 0 && $dress["clan"]==''){
            if ($dress['cost']) {
                $price=$dress['cost']*SELLCOEF;
            } else {
                $price=2;
            }
            $allcost=round($price*(1-($dress['duration']/$dress['maxdur'])),2)*($dress["koll"]?$dress["koll"]:1);
            destructitem($dress['id']);
            mysql_query("UPDATE `users` set `money` = `money`+$allcost WHERE id = {$_SESSION['uid']}");
            //$allcost=$dress['cost'];
            //mysql_query("UPDATE `users` set `money` = `money`+ '".$dress['cost']."' WHERE id = {$_SESSION['uid']}");
            mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" продал в магазин товар: \"".$dress['name']."\" ".($dress["koll"]?"(x$dress[koll])":"")." id:(cap".$dress['id'].") [".$dress['duration']."/".$dress['maxdur']."] за ".$allcost." кр ($user[money]/$user[ekr]). ',1,'".time()."');");
            echo "<font color=red><b>Вы продали \"{$dress['name']}\" за ".$allcost." кр.</b></font>";
            }
        }
    }

    if (@$_GET["buyres"]) {
      $_GET["buyres"]=(int)@$_GET["buyres"];
      $rec=mqfa("select id, resname, rescnt, name from shop where id='$_GET[buyres]' and shop='$user[room]'");
      if ($rec["rescnt"] && hassmallitems($rec["resname"], $rec["rescnt"], $user["id"])) {
        if ($user["room"]==59 || in_array($rec['id'],$presents)) takeshopitem($_GET["buyres"], "shop", "", "", 0, array("cost"=>1));
        else takeshopitem($_GET["buyres"], "shop", 0, 0, 0, array("podzem"=>1));
        adddelo($user["id"], "$user[login] купил $rec[name] (id:".mysql_insert_id().") за $rec[rescnt] шт. $rec[resname].",1);
        takesmallitems($rec["resname"], $rec["rescnt"], $user["id"]);
        echo "<font color=red><b>Вы купили $rec[name]</b></font>";        
      } else echo "<font color=red><b>Недостаточно ресурсов в наличии.</b></font>";
    }

    if (($_GET['set'] OR $_POST['set'])) {
        if ($_GET['set']) { $set = $_GET['set']; }
        if ($_POST['set']) { $set = $_POST['set']; }
        if (!$_POST['count']) { $_POST['count'] =1; }
        $dress = mysql_fetch_array(mysql_query("SELECT * FROM `shop` WHERE `id` = '{$set}' and shop='$user[room]' LIMIT 1;"));
        $needItems   = mqfa("SELECT * FROM shop_rel WHERE id = $set");
        $isNeedItems = 0;
        if ($needItems) {
            $isNeedItems = mysql_result(mysql_query("SELECT id FROM inventory WHERE owner = $user[id] AND prototype = $needItems[rid] AND koll >= $needItems[count] LIMIT 1"), 0, 0);
        }
        if ($dress['honor_cost']>0 && $user['honorpoints']>=$dress['honor_cost']*$_POST['count'])  $hasmoney=1;
        elseif ($dress["buyformoney"] && $dress['cost']>0 && $user['money']>=$dress['cost']*$_POST['count']) $hasmoney=1;
        if (($dress['massa']*$_POST['count']+$d[0]) > (get_meshok()) || !placeinbackpack($_POST['count']) && !in_array($user['id'],$unlimitedbackpack)) {
          echo "<font color=red><b>Недостаточно места в рюкзаке.</b></font>";
        } elseif($needItems && !$isNeedItems) {
          echo "<font color=red><b>Не хватает ресурсов для покупки.</b></font>";  
        } elseif($hasmoney && $dress['count'] >= $_POST['count']) {
            for($k=1;$k<=$_POST['count'];$k++) {
                if(mysql_query("INSERT INTO `inventory`
                (`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`isrep`,
                    `gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gmana`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gposoh`,`gluk`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nposoh`,`nluk`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
                    `mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`gmp`,`gmeshok`,`destinyinv`,`gift`,`mfkritpow`,`mfantikritpow`,`mfparir`,`mfshieldblock`,`mfcontr`,`mfrub`,`mfkol`,`mfdrob`,`mfrej`,`mfdhit`,`mfdmag`,`mfhitp`,`mfmagp`,`opisan`,`second`,`vid`,`sitost`,`dvur`,`chkol`,`chrub`,`chrej`,`chdrob`,`chmag`,`mfproboj`,`stats`,
                    `mfdkol`,`mfdrub`,`mfdrej`,`mfddrob`,bronmin1,bronmin2,bronmin3,bronmin4,blockzones,
                    mffire, mfwater, mfair, mfearth, mflight, mfdark, minusmfdmag, minusmfdfire, 
                    minusmfdair, minusmfdwater, minusmfdearth, manausage, includemagic, includemagicdex, 
                    includemagicmax, includemagicname, includemagicuses, includemagiccost, includemagicusesperday,
                    mfdair, mfdwater, mfdearth, mfdfire, mfddark, mfdlight, setid, honor                    
                )
                VALUES
                ('{$dress['id']}','{$_SESSION['uid']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gmana']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gposoh']}','{$dress['gluk']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nposoh']}','{$dress['nluk']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
                '{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}','{$dress['razdel']}','{$dress['gmp']}','{$dress['gmeshok']}','{$dress['destiny']}','{$dress['gift']}','{$dress['mfkritpow']}','{$dress['mfantikritpow']}','{$dress['mfparir']}','{$dress['mfshieldblock']}','{$dress['mfcontr']}','{$dress['mfrub']}','{$dress['mfkol']}','{$dress['mfdrob']}','{$dress['mfrej']}','{$dress['mfdhit']}','{$dress['mfdmag']}','{$dress['mfhitp']}','{$dress['mfmagp']}','{$dress['opisan']}','{$dress['second']}','{$dress['vid']}','{$dress['sitost']}','{$dress['dvur']}','{$dress['chkol']}','{$dress['chrub']}','{$dress['chrej']}','{$dress['chdrob']}','{$dress['chmag']}','{$dress['mfproboj']}','{$dress['stats']}',
                '{$dress['mfdkol']}','{$dress['mfdrub']}','{$dress['mfdrej']}','{$dress['mfddrob']}','{$dress['bronmin1']}','{$dress['bronmin2']}','{$dress['bronmin3']}','{$dress['bronmin4']}','{$dress['blockzones']}',
                $dress[mffire], $dress[mfwater], $dress[mfair], $dress[mfearth], $dress[mflight], $dress[mfdark], 
                '$dress[minusmfdmag]', '$dress[minusmfdfire]', '$dress[minusmfdair]', '$dress[minusmfdwater]', '$dress[minusmfdearth]',
                '$dress[manausage]', '$dress[includemagic]', '$dress[includemagicdex]', '$dress[includemagicmax]', '$dress[includemagicname]',
                '$dress[includemagicuses]', '$dress[includemagiccost]', '$dress[includemagicusesperday]',
                '$dress[mfdair]', '$dress[mfdwater]', '$dress[mfdearth]', '$dress[mfdfire]', '$dress[mfddark]', '$dress[mfdlight]', '$dress[setid]', '".($dress["honor_cost"]?1:0)."'
                ) ;"))
                {
                    $good = 1;
                }
                else {
                //echo mysql_error();
                    $good = 0;
                }
            }
            if ($good) {
                mysql_query("UPDATE `shop` SET `count`=`count`-{$_POST['count']} WHERE `id` = '{$set}' LIMIT 1;");
                if ($needItems && $isNeedItems) {
                    mysql_query("UPDATE inventory SET koll = (koll - $needItems[count]) WHERE owner = $user[id] AND id = $isNeedItems");
                    mysql_query("DELETE FROM inventory WHERE koll = 0 AND owner = $user[id] AND id = $isNeedItems");
                }
                echo "<font color=red><b>Вы купили {$_POST['count']} шт. \"{$dress['name']}\".</b></font>";
                if ($dress['honor_cost']>0) {
                  mq("UPDATE `users` set `honorpoints` = `honorpoints`- '".($_POST['count']*$dress['honor_cost'])."' WHERE id = {$_SESSION['uid']} ;");
                  $user['honorpoints']-=$_POST['count']*$dress['honor_cost'];
                  $allcost=$_POST['count']*$dress['honor_cost']." <img src=/i/zub_low1.gif alt=\"Белый зуб\">";
                } else {
                  mq("UPDATE `users` set `money` = `money`- '".($_POST['count']*$dress['cost'])."' WHERE id = {$_SESSION['uid']} ;");
                  $user['money'] -= $_POST['count']*$dress['cost'];
                  $allcost=$_POST['count']*$dress['cost']." кр.";
                }
                $limit=$_POST['count'];
                $invdb = mysql_query("SELECT `id` FROM `inventory` WHERE `name` = '".$dress['name']."' ORDER by `id` DESC LIMIT ".$limit." ;" );
                //$invdb = mysql_query("SELECT id FROM `inventory` WHERE `name` = '".{$dress['name']}."' ORDER by `id` DESC LIMIT $limit ;" );
                if ($limit == 1) {
                    $dressinv = mysql_fetch_array($invdb);
                    $dressid = "cap".$dressinv['id'];
                    $dresscount=" ";
                }
                else {
                    $dressid="";
                    while ($dressinv = mysql_fetch_array($invdb))  {
                        $dressid .= "cap".$dressinv['id'].",";
                    }
                    $dresscount="(x".$_POST['count'].") ";
                }
                mq("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" купил товар: \"".$dress['name']."\" ".$dresscount."id:(".$dressid.") [0/".$dress['maxdur']."] за ".$allcost." ($user[money]/$user[ekr])',1,'".time()."');");
            }
        }
        else {
            echo "<font color=red><b>Недостаточно ".($dress["honor_cost"]?"денег":"денег")." или нет вещей в наличии.</b></font>";
        }
    }

?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<SCRIPT LANGUAGE="JavaScript">
function AddCount(name, txt, e) {
  if (!e) var e = window.event;
  if (e.pageX || e.pageY) {
    posx = e.pageX;
    posy = e.pageY;
  } else if (e.clientX || e.clientY) {
    posx = e.clientX + document.body.scrollLeft;
    posy = e.clientY + document.body.scrollTop;
  }

    document.getElementById("hint3").innerHTML = '<FORM METHOD=POST ACTION="shop.php"><input type="hidden" name="otdel" value="<?=@$_GET["otdel"]?>">'+
    '<table border=0 width=100% cellspacing=1 cellpadding=0 bgcolor="#CCC3AA"><tr><td align=center><B>Купить неск. штук</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</TD></tr><tr><td colspan=2>'+
    '<table border=0 width=100% cellspacing=0 cellpadding=0 bgcolor="#FFF6DD"><tr><INPUT TYPE="hidden" name="set" value="'+name+'"><td colspan=2 align=center><B><I>'+txt+'</td></tr><tr><td width=80% align=right>'+
    'Количество (шт.) <INPUT TYPE="text" NAME="count" id="count" size=4></td><td width=20%>&nbsp;<INPUT TYPE="submit" value=" »» ">'+
    '</TD></TR></TABLE></td></tr></table></form>';
    document.getElementById("hint3").style.visibility = "visible";
    document.getElementById("hint3").style.left = posx-20;
    document.getElementById("hint3").style.top = posy+5;
    document.getElementById("count").focus();
}
// Закрывает окно
function closehint3()
{
    document.getElementById("hint3").style.visibility="hidden";
}
</SCRIPT>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=#e0e0e0>
<?
if (@$_GET["warning"]) {
  echo "<b><font color=red>$_GET[warning]</font></b>";
}
?>
<TABLE border=0 width=100% cellspacing="0" cellpadding="0">
<FORM action="city.php" method=GET>
<tr><td><h3><?=$rooms[$user["room"]];?></td><td align=right>
<INPUT TYPE="button" value="Подсказка" style="background-color:#A9AFC0" onClick="window.open('help/shop.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">
<?
  if ($user["room"] ==59) echo "<input type=hidden name=got value=\"1\"><input type=hidden name=torg value=\"1\">";
?>
<INPUT TYPE="submit" value="Вернуться" name="<?
  if ($user["room"]==22) echo "cp";
  if ($user["room"]==37) echo "park";
  if ($user["room"]==59) echo "torg";
?>"></td></tr>
</FORM>
</table>
<TABLE border=0 width=100% cellspacing="0" cellpadding="4">
<TR>
    <FORM METHOD=POST ACTION="shop.php">
    <input type="hidden" name="otdel" value="<?=@$_GET["otdel"]?>">
    <INPUT TYPE="hidden" name="sid" value="">
    <INPUT TYPE="hidden" name="id" value="1">
    <TD valign=top align=left>
<!--Магазин-->
<TABLE border=0 width=100% cellspacing="0" cellpadding="0" bgcolor="#A5A5A5">
<TR>
    <TD align=center><B>Отдел "<?php
    if (@$_REQUEST["present"]) {
      echo "Сделать подарки";
    } else {
      if ($user["room"]==59 && !@$_GET["otdel"]) $_GET["otdel"]=55;
      if ($_POST['sale']) {
          echo "Скупка";
      } else
  switch ($_GET['otdel']) {
      case null:
          echo "Оружие: кастеты,ножи";
          $_GET['otdel'] = 1;
      break;
      case 1:
          echo "Оружие: кастеты,ножи";
      break;

      case 11:
          echo "Оружие: топоры";
      break;

      case 12:
          echo "Оружие: дубины,булавы";
      break;

      case 13:
          echo "Оружие: мечи";
      break;
      case 30:
          echo "Оружие: магические посохи";
      break;

      case 2:
          echo "Одежда: сапоги";
      break;

      case 21:
          echo "Одежда: перчатки";
      break;
      case 8:
          echo "Одежда: рубахи";
      break;
      case 22:
          echo "Одежда: легкая броня";
      break;

      case 23:
          echo "Одежда: тяжелая броня";
      break;

      case 24:
          echo "Одежда: шлемы";
      break;

      case 25:
          echo "Наручи";
      break;

      case 26:
          echo "Пояса";
      break;

      case 27:
          echo "Поножи";
      break;

      case 3:
          echo "Щиты";
      break;

      case 4:
          echo "Ювелирные товары: серьги";
      break;

      case 41:
          echo "Ювелирные товары: ожерелья";
      break;

      case 42:
          echo "Ювелирные товары: кольца";
      break;

      case 5:
          echo "Заклинания: нейтральные";
      break;

      case 51:
          echo "Заклинания: боевые и защитные";
      break;
      case 53:
          echo "Заклинания: усиления оружия";
      break;
            case 6:
          echo "Амуниция";
      break;
      case 188:
          echo "Эликсиры";
      break;
      case 7:
          echo "Сувениры: открытки";
      break;
      case 71:
          echo "Сувениры: подарки";
      break;
      case 49:
          echo "Еда";
      break;
      case 54:
          echo "Магия огня";
          break;
      case 55:
          echo "Школа оружия";
          break;
      case 56:
          echo "Магия воды";
          break;
      case 57:
          echo "Магия воздуха";
          break;
      case 58:
          echo "Магия земли";
          break;
      case 59:
          echo "Прочая магия";
          break;
      case 62:
          echo "Книги знаний";
          break;
  }
    }


    ?>"</B>

    </TD>
</TR>
<TR><TD><!--Рюкзак-->
<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">
<?
if($_REQUEST['present'] && $user["level"]>=4 && $user["align"]!=4) {
    
    if($_POST['to_login'] && $_POST['flower']) {
        $to=mqfa("SELECT * FROM `users` WHERE `login` = '{$_POST['to_login']}'");
        if (!$to) $to=mqfa("SELECT * FROM `allusers` WHERE `login` = '{$_POST['to_login']}'");
        $item=mqfa1("select owner from inventory where `id` = '".$_POST['flower']."' AND `owner` = '{$_SESSION['uid']}'  AND (`otdel` = 7 OR `otdel` = 71)");
        $sl=mqfa1("SELECT `id` FROM `effects` WHERE `type`=2 AND `owner`='$user[id]'");
        if ($sl) {
          echo "<b><font color=red>С заклятием молчания нельзя дарить подарки.</font></b>";
        } elseif (!$item) {
          echo "<b><font color=red>Предмет на найден</font></b>";
        } elseif (!$to) {
          echo "<b><font color=red>Получатель подарка не найден</font></b>";
        } elseif ($_POST['to_login'] == $user['login']) {
          echo "<b><font color=red>Очень щедро дарить что-то самому себе ;)</font></b>";
        } elseif ($to['room'] > 500 && $to['room'] < 561) {
          echo "<b><font color=red>Персонаж в данный момент участвует в турнире в Башне Смерти. Попробуйте позже.</font></b>";
        } elseif ($to["level"]<4) {
          echo "<b><font color=red>Дарить подарки можно только персонажам с 4-го уровня.</font></b>";
        } else {
            if($_POST['from']==1) { $from = 'Аноним'; }
            elseif($_POST['from']==2 && $user['klan']) { $from = ' клана '.$user['klan']; }
            else {$from = $user['login'];}
            if (haslinks($_POST['podarok2']) || haslinks($_POST["txt"])) {
              $f=fopen("logs/autosleep.txt","ab");
              $_POST["txt"]=str_replace("\r","",$_POST["txt"]);
              $_POST["txt"]=str_replace("\n","",$_POST["txt"]);
              fwrite($f, "$user[login]: $_POST[podarok2] $_POST[txt]\r\n");
              fclose($f);
              mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".$user['id']."','Заклятие молчания',".(time()+1800).",2);");
              reportadms("<br><b>$user[login]</b>(спам в подарке): $_POST[podarok2] $_POST[txt]", "Комментатор");
              addch("<img src=i/magic/sleep.gif> Комментатор наложил заклятие молчания на &quot;{$user['login']}&quot;, сроком 30 мин. Причина: РВС.");
            } else {
              $_POST['txt']=rembadsymbols($_POST["txt"]);
              $_POST['podarok2']=rembadsymbols($_POST['podarok2']);
              if ($to) if(mysql_query("UPDATE `inventory` SET `owner` = '".$to['id']."', `present` = '".$from."', `opisan` = '".$_POST['txt']."', `letter` = '".$_POST['podarok2']."' WHERE  `present` = '' AND `id` = '".$_POST['flower']."' AND `owner` = '{$_SESSION['uid']}' AND `dressed` = 0  AND `setsale`=0")) {
                  $res = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$_POST['flower']}' LIMIT 1; "));
                  $buket_name=$res['name'];
                  mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','Подарен предмет \"".$res['name']."\" id:(cap".$res['id'].") [".$res['duration']."/".$res['maxdur']."] от \"".$from."\" к \"".$to['login']."\"','1','".time()."');");
                  mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$to['id']}','Подарен предмет \"".$res['name']."\" id:(cap".$res['id'].") [".$res['duration']."/".$res['maxdur']."] от \"".$from."\" к \"".$to['login']."\"','1','".time()."');");
                  if(($_POST['from']==1) || ($_POST['from']==2)) {
                      $action="подарил";
                      mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$to['id']}','Подарен предмет \"".$res['name']."\" id:(cap".$res['id'].") [".$res['duration']."/".$res['maxdur']."] от \"".$user['login']."\" к \"".$to['login']."\"','5','".time()."');");
                  }
                  else {
                      if ($user['sex'] == 0) {$action="подарила";}
                      else {$action="подарил";}
                  }
                  $us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$to['id']}' LIMIT 1;"));
                  if($us[0]){
                      addchp ('<font color=red>Внимание!</font> <span oncontextmenu=OpenMenu()>'.$from.'</span> '.$action.' вам <B>'.$buket_name.'</B>.   ','{[]}'.$_POST['to_login'].'{[]}');
                  } else {
                      // если в офе
                      mysql_query("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$to['id']."','','".'<font color=red>Внимание!</font> <span oncontextmenu=OpenMenu()>'.$from.'</span> '.$action.' вам <B>'.$buket_name.'</B>.   '."');");
                  }
                  echo "<b><font color=red>Подарок удачно доставлен к \"",$_POST['to_login'],"\"</font></b>";
              }
              echo mysql_error();
            }
        }
    }

        ?>

<!-- Подарить подарок -->
<form method="post">
<TABLE cellspacing=0 cellpadding=0 width=100% bgcolor=#e0e0e2><TD>
<INPUT TYPE=hidden name=present value=1>
Вы можете сделать подарок дорогому человеку. Ваш подарок будет отображаться в информации о персонаже.
<OL>
<LI>Укажите логин персонажа, которому хотите сделать подарок<BR>
Login <INPUT TYPE=text NAME=to_login value="">
<LI>Цель подарка. Будет отображаться в информации о персонаже (не более 60 символов)<BR>
<INPUT TYPE=text NAME=podarok2 value="" maxlength=60 size=50>
<LI>Напишите текст сопроводительной записки (в информации о персонаже не отображается)<BR>
<TEXTAREA NAME=txt ROWS=6 COLS=80></TEXTAREA>
<LI>Выберите, от чьего имени подарок:<BR>
<INPUT TYPE=radio NAME=from value=0 checked> <? nick2($user['id']);?><BR>
<INPUT TYPE=radio NAME=from value=1 > анонимно<BR>
<INPUT TYPE=radio NAME=from value=2 > от имени клана<BR>
<LI>Нажмите кнопку <B>Подарить</B> под предметом, который хотите преподнести в подарок:<BR>
</OL>
<input type="hidden" name="flower" id="flower" value="">
<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">
<?

//print_r($_POST);

    $data = mq("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `gift`=1 AND `setsale`=0 AND (`clan` = '' or isnull(clan)) AND `present` = '' ORDER by `id` DESC; ");
    if (!@$_SESSION['flowers']) $_SESSION['flowers']=array();
    while($row = mysql_fetch_array($data)) {
        if(!in_array($row['id'],array_keys($_SESSION['flowers']))) {
            $row['count'] = 1;
            if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
            echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"".IMGBASE."/i/sh/{$row['img']}\" BORDER=0>";
            ?>
            <BR><input type="submit" onclick="document.all['flower'].value='<?=$row['id']?>';" value="Подарить">
            </TD>
            <?php
            echo "<TD valign=top>";
            showitem ($row);
            echo "</TD></TR>";
        }
    }
?>
</table>
</form>
        <?
    }
    else
if ($_REQUEST['sale']) {
    $grass = mqfaa("SELECT name FROM smallitems WHERE id >= 24 AND id <= 36");
    $grassCond = "name = '" . $grass[0]['name'] . "'";
    for ($i = 1; $i < count($grass); $i++ ) {
        $grassCond .= " OR name = '" . $grass[$i]['name'] . "'";
    }
    $data = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `clan` = ''  AND `setsale`=0  AND `podzem`=0 AND `ecost`=0 AND `gift`=0 AND `honor`=0 and (cost>0 OR $grassCond) ORDER by `update` DESC; ");
    while($row = mysql_fetch_array($data)) {
        $row['count'] = 1;
        if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
        echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"".IMGBASE."/i/sh/{$row['img']}\" BORDER=0>";

        if ($row['cost']) {
            $price=$row['cost']*SELLCOEF;
        } else {
            $price=2;
        }

        ?>
        <BR><A HREF="shop.php?sed=<?=$row['id']?>&sid=&sale=1">продать за <?=round($price*(1-($row['duration']/$row['maxdur'])),2)*($row["koll"]?$row["koll"]:1)?></A>

        </TD>
        <?php
        echo "<TD valign=top>";
        showitem ($row);
        echo "</TD></TR>";
    }
} else
{
    $data = mq("SELECT * FROM `shop` WHERE `count` > 0 AND `razdel` = '{$_GET['otdel']}' AND `zoo` = '0' and shop='$user[room]' ORDER by `nlevel` ASC, cost, id desc");
    while($row = mysql_fetch_array($data)) {
        if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
        echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"".IMGBASE."/i/sh/{$row['img']}\" BORDER=0>";
          if (($row["cost"]>0 && $row['buyformoney']) || $row["honor_cost"]>0) { ?>
        <BR><A HREF="shop.php?otdel=<?=$_GET['otdel']?>&set=<?=$row['id']?>">купить</A>
        <IMG SRC="<?=IMGBASE?>/i/up.gif" WIDTH=11 HEIGHT=11 BORDER=0 ALT="Купить несколько штук" style="cursor:pointer" onClick="AddCount('<?=$row['id']?>', '<?=$row['name']?>', event)">
        <? }
          if ($row["resname"]) {
            echo "<br><a href=\"shop.php?buyres=$row[id]&otdel=$_GET[otdel]\">Купить за ресурсы</a><br>
            ($row[resname] $row[rescnt] шт.)";
          }
        ?>        
        </TD>
        <?php
        echo "<TD valign=top>";
        showitem ($row);
        echo "</TD></TR>";
    }
}
?>
</TABLE>
</TD></TR>
</TABLE>

    </TD>
    <TD valign=top width=280>

	<CENTER><b>Масса всех ваших вещей: <?php echo $d[0]; ?>/<?=get_meshok()?><BR>
	У вас в наличии: <FONT COLOR="#339900"><?=$user['money']?></FONT> кр.</B></CENTER>
<?  if ($user["room"]==37) { ?>
<CENTER>Зубы: <SMALL><img src=/i/zub_low1.gif alt=Белый зуб><?=$user[honorpoints]?></SMALL></CENTER>
<?}?>

<div style="MARGIN-LEFT:15px; MARGIN-TOP: 10px;">

    <? if ($user["room"]==22) { ?><INPUT TYPE="submit" onclick="document.all('hint3').innerHTML=''" value="Продать вещи" name="sale"><BR><? } ?>

<div style="background-color:#d2d0d0;padding:1"><center><font color="#oooo"><B>Отделы магазина</B></center></div>
<?
  function shoplink($otdel, $name, $caption=0) {
    return "<A HREF=\"shop.php?otdel=$otdel\">".($otdel==$_GET["otdel"]?"<DIV style='background-color: #C7C7C7'>":"").($caption?"":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;").$name.($otdel==$_GET["otdel"]?"</div></a>":"</a><br>")."";
  }
  if ($user["room"]==22) {
    echo shoplink(1, "Оружие: Кастеты,ножи",1);
    echo shoplink(11, "Топоры");
    echo shoplink(12, "Дубины,булавы");
    echo shoplink(13, "Мечи");
    echo shoplink(30, "Магические посохи");
    
    echo shoplink(2, "Одежда: сапоги", 1);
    echo shoplink(21, "перчатки");
    echo shoplink(8, "рубахи");
    echo shoplink(22, "легкая броня");
    echo shoplink(23, "тяжелая броня");
    echo shoplink(24, "шлемы");
    echo shoplink(25, "наручи");
    echo shoplink(26, "пояса");
    echo shoplink(27, "поножи");
    echo shoplink(3, "Щиты", 1);
    echo shoplink(4, "Ювелирные товары: серьги", 1);
    echo shoplink(41, "ожерелья");
    echo shoplink(42, "кольца");
    echo shoplink(5, "Заклинания: нейтральные", 1);
    echo shoplink(51, "боевые и защитные");
    echo shoplink(53, "усиления оружия");
    echo shoplink(6, "Амуниция", 1);
    echo shoplink(188, "Эликсиры");
  echo shoplink(7, "Сувениры: открытки", 1);
  echo shoplink(71, "подарки");
  } elseif ($user["room"]==59) {
    echo shoplink(55, "Школа оружия");
    echo shoplink(54, "Магия огня");
    echo shoplink(56, "Магия воды");
    echo shoplink(57, "Магия воздуха");
    echo shoplink(58, "Магия земли");
    echo shoplink(59, "Прочая магия");
    echo shoplink(62, "Книги знаний");
  } else {
    echo shoplink(1, "Оружие: Кастеты,ножи",1);
    echo shoplink(11, "Топоры");
    echo shoplink(12, "Дубины,булавы");
    echo shoplink(13, "Мечи");
    echo shoplink(30, "Магические посохи");   
    echo shoplink(2, "Одежда: сапоги", 1);
    echo shoplink(21, "перчатки");
    echo shoplink(22, "рубахи");
    echo shoplink(23, "легкая броня");
    echo shoplink(24, "тяжелая броня");
    echo shoplink(25, "шлемы");
    echo shoplink(26, "наручи");
    echo shoplink(27, "пояса");
    echo shoplink(28, "поножи");
    echo shoplink(3, "Щиты", 1);
    echo shoplink(4, "Ювелирные товары: серьги", 1);
    echo shoplink(41, "ожерелья");
    echo shoplink(42, "кольца");
    echo shoplink(5, "Заклинания: нейтральные", 1);
    echo shoplink(51, "боевые и защитные");
    echo shoplink(53, "усиления оружия");
    echo shoplink(6, "Амуниция", 1);
    echo shoplink(188, "Эликсиры");
  }
?>
<? 
  if ($user["room"]==22 ) { 
    if ($user["level"]>=4 && $user["align"]!=4) echo "<A HREF=\"shop.php?present=1\">Сделать подарки</A><BR>";
    echo shoplink(49, "Еда", 1);

  } ?>
    </div>
    </form>
    </TD>
</TR>
</TABLE><div id="hint3" class="ahint"></div>

<br><div align=left>

    <?php include("mail_ru.php"); ?>

<div>

</BODY>
</HTML>

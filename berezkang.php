<?php
    session_start();
    if ($_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
    include "functions.php";
    $d = mysql_fetch_array(mysql_query("SELECT sum(`massa`) FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `setsale` = 0 ; "));
    if ($user['room'] != 21101012) { header("Location: main.php");  die(); }
    if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }
if ($_GET['elka']){
mq("UPDATE `users`,`online` SET `users`.`room` = '24',`online`.`room` = '24' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}';");
print "<script>location.href='elka.php'</script>";
}	
    if ($_GET['sed']) {

        $dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `dressed`= 0 AND `id` = '{$_GET['sed']}' AND `owner` = '{$_SESSION['uid']}'  AND `podzem`=0 LIMIT 1;"));

        $name=$dress["name"];
        $name=str_replace(" (мф)","",$name);
        $name=str_replace(" +1","",$name);
        $name=str_replace(" +2","",$name);
        $name=str_replace(" +3","",$name);
        $name=str_replace(" +4","",$name);
        $name=str_replace(" +5","",$name);
        $ec=mqfa1("select ecost from berezka where name='$name'");

        if($dress["podzem"] == 0 && $ec=$dress["ecost"]){
          $price=floor($dress['ecost']*(($dress["maxdur"]-$dress["duration"])/$dress["maxdur"])*10)/10*SELLCOEF;
          destructitem($dress['id']);
          //$allcost=round($price-$dress['duration']*($dress['ecost']/($dress['maxdur']*10)),2);
          //mysql_query("UPDATE `users` set `ekr` = `ekr`+ '".(round($price-$dress['duration']*($dress['ecost']/($dress['maxdur']*10)),2))."' WHERE id = {$_SESSION['uid']}");
          //$allcost=$dress['ecost']/2;
          mysql_query("UPDATE `users` set `ekr` = `ekr`+ '".$price."' WHERE id = {$_SESSION['uid']}");
          mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" продал в магазин товар: \"".$dress['name']."\" id:(cap".$dress['id'].") [".$dress['duration']."/".$dress['maxdur']."] за ".$price." екр. ',1,'".time()."');");
          echo "<font color=red><b>Вы продали \"{$dress['name']}\" за ".$price." екр.</b></font>";
        }
    }


    if (($_GET['set'] OR $_POST['set'])) {
        if ($_GET['set']) { $set = $_GET['set']; }
        if ($_POST['set']) { $set = $_POST['set']; }
        if (!$_POST['count']) { $_POST['count'] =1; } else $_POST['count']=(int)$_POST['count'];
        $dress = mysql_fetch_array(mysql_query("SELECT * FROM `berezka_ng` WHERE `id` = '{$set}' LIMIT 1;"));
        if (($dress['massa']*$_POST['count']+$d[0]) > (get_meshok())) {
            echo "<font color=red><b>Недостаточно места в рюкзаке.</b></font>";
        }
        elseif(($user['ekr']>= ($dress['ecost']*$_POST['count'])) && ($dress['count'] >= $_POST['count'])) {
            $dress["name"]=str_replace("'","\\'",$dress["name"]);
            mq("insert into berlog set dat=curdate(), item='$set', qty='$_POST[count]'");
            for($k=1;$k<=$_POST['count'];$k++) {
                if(mysql_query("INSERT INTO `inventory`
                (`prototype`,`owner`,`name`,`type`,`massa`,`ecost`,`img`,`maxdur`,`isrep`,
                    `gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gmana`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gposoh`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nposoh`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
                    `mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`gmp`,`gmeshok`,`artefact`,`destinyinv`,`gift`,`mfkritpow`,`mfantikritpow`,`mfparir`,`mfshieldblock`,`mfcontr`,`mfrub`,`mfkol`,`mfdrob`,`mfrej`,`mfdhit`,`mfdmag`,`mfhitp`,`mfmagp`,`opisan`,`dvur`,`second`,`chkol`,`chrub`,`chrej`,`chdrob`,`chmag`,`mfproboj`,`stats`,
                    `mfdkol`,`mfdrub`,`mfdrej`,`mfddrob`,bronmin1,bronmin2,bronmin3,bronmin4,blockzones,
                    mffire, mfwater, mfair, mfearth, mflight, mfdark, minusmfdmag, minusmfdfire, 
                    minusmfdair, minusmfdwater, minusmfdearth, manausage, includemagic, includemagicdex, 
                    includemagicmax, includemagicname, includemagicuses, includemagiccost, includemagicusesperday, includemagicusesperbattle,
                    mfdair, mfdwater, mfdearth, mfdfire, mfddark, mfdlight, setid, cost
                )
                VALUES
                ('{$dress['id']}','{$_SESSION['uid']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['ecost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gmana']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gposoh']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nposoh']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
                '{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}','{$dress['razdel']}','{$dress['gmp']}','{$dress['gmeshok']}','{$dress['artefact']}','{$dress['destiny']}','{$dress['gift']}','{$dress['mfkritpow']}','{$dress['mfantikritpow']}','{$dress['mfparir']}','{$dress['mfshieldblock']}','{$dress['mfcontr']}','{$dress['mfrub']}','{$dress['mfkol']}','{$dress['mfdrob']}','{$dress['mfrej']}','{$dress['mfdhit']}','{$dress['mfdmag']}','{$dress['mfhitp']}','{$dress['mfmagp']}','{$dress['opisan']}','{$dress['dvur']}','{$dress['second']}','{$dress['chkol']}','{$dress['chrub']}','{$dress['chrej']}','{$dress['chdrob']}','{$dress['chmag']}','{$dress['mfproboj']}','{$dress['stats']}',
                '{$dress['mfdkol']}','{$dress['mfdrub']}','{$dress['mfdrej']}','{$dress['mfddrob']}','{$dress['bronmin1']}','{$dress['bronmin2']}','{$dress['bronmin3']}','{$dress['bronmin4']}','{$dress['blockzones']}',
                '$dress[mffire]', '$dress[mfwater]', '$dress[mfair]', '$dress[mfearth]', '$dress[mflight]', '$dress[mfdark]', 
                '$dress[minusmfdmag]', '$dress[minusmfdfire]', '$dress[minusmfdair]', '$dress[minusmfdwater]', '$dress[minusmfdearth]',
                '$dress[manausage]', '$dress[includemagic]', '$dress[includemagicdex]', '$dress[includemagicmax]', '$dress[includemagicname]',
                '$dress[includemagicuses]', '$dress[includemagiccost]', '$dress[includemagicusesperday]', '$dress[includemagicusesperbattle]',
                '$dress[mfdair]', '$dress[mfdwater]', '$dress[mfdearth]', '$dress[mfdfire]', '$dress[mfddark]', '$dress[mfdlight]', '$dress[setid]', '$dress[cost]'
                ) ;"))
                {
                    $good = 1;
                }
                else {
                    $good = 0;
                    echo mysql_error();
                }
            }
            if ($good) {
                mysql_query("UPDATE `berezka_ng` SET `count`=`count`-{$_POST['count']} WHERE `id` = '{$set}' LIMIT 1;");
                echo "<font color=red><b>Вы купили {$_POST['count']} шт. \"".stripslashes($dress['name'])."\".</b></font>";
                mysql_query("UPDATE `users` set `ekr` = `ekr`- '".($_POST['count']*$dress['ecost'])."' WHERE id = {$_SESSION['uid']} ;");
                $user['ekr'] -= $_POST['count']*$dress['ecost'];
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
                $allcost=$_POST['count']*$dress['ecost'];
                mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" купил товар: \"".$dress['name']."\" ".$dresscount."id:(".$dressid.") [0/".$dress['maxdur']."] за ".$allcost." екр. ',1,'".time()."');");
            }
        }
        else {
            echo "<font color=red><b>Недостаточно денег или нет вещей в наличии.</b></font>";
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
function AddCount(name, txt)
{
    document.all("hint3").innerHTML = '<table border=0 width=100% cellspacing=1 cellpadding=0 bgcolor="#CCC3AA"><tr><td align=center><B>Купить неск. штук</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</TD></tr><tr><td colspan=2>'+
    '<table border=0 width=100% cellspacing=0 cellpadding=0 bgcolor="#FFF6DD"><tr><INPUT TYPE="hidden" name="set" value="'+name+'"><td colspan=2 align=center><B><I>'+txt+'</td></tr><tr><td width=80% align=right>'+
    'Количество (шт.) <INPUT TYPE="text" NAME="count" size=4></td><td width=20%>&nbsp;<INPUT TYPE="submit" value=" »» ">'+
    '</TD></TR></TABLE></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = event.x+document.body.scrollLeft-20;
    document.all("hint3").style.top = event.y+document.body.scrollTop+5;
    document.all("count").focus();
}
// Закрывает окно
function closehint3()
{
    document.all("hint3").style.visibility="hidden";
}
</SCRIPT>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=#e0e0e0>
<TABLE border=0 width=100% cellspacing="0" cellpadding="0">
<tr><td><h3>Новогодний Магазин</td><td align=right>
<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px; white-space: nowrap;"></div>
<?
  include "config/routes.php";
  foreach ($routes[$user["room"]] as $k=>$v) $links[$rooms[$v]]="?elka=1&level$v=1";
  echo moveline($links);
?>
<td>
</table>
<TABLE border=0 width=100% cellspacing="0" cellpadding="4">
<TR>
    <FORM METHOD=POST ACTION="berezkang.php">
    <INPUT TYPE="hidden" name="sid" value="">
    <INPUT TYPE="hidden" name="id" value="1">
    <TD valign=top align=left>
<!--Магазин-->
<TABLE border=0 width=100% cellspacing="0" cellpadding="0" bgcolor="#A5A5A5">
<TR>
    <TD align=center><B>Отдел "<?php
    if ($_POST['sale']) {
        echo "Скупка";
    } else
switch ($_GET['otdel']) {
    case null:
        echo "Оружие: кастеты,ножи";
        $_GET['otdel'] = 1;
    break;
    case 1:
        echo "Оружие: ёлки";
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

    case 14:
        echo "Оружие: луки и арбалеты";
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

    case 22:
        echo "Одежда: легкая броня";
    break;
    case 8:
        echo "Одежда: рубашки, футболки";
    break;
    case 9:
        echo "Одежда: плащи, накидки";
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
    case 52:
        echo "Орудия труда";
    break;
    case 53:
        echo "Заклинания: усиления оружия";
    break;
    case 6:
        echo "Амуниция";
    break;
        echo "Сувениры: открытки";
    break;
    case 71:
        echo "Сувениры: подарки";
    break;
    case 72:
        echo "Именные вещи";
    break;
    case 73:
        echo "Коллекционные вещи";
    break;
}


    ?>"</B>

    </TD>
</TR>
<TR><TD><!--Рюкзак-->
<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">
<?
if($_REQUEST['present']) {

    if($_POST['to_login'] && $_POST['flower']) {
        $to = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$_POST['to_login']}' LIMIT 1;"));
        $item=mqfa1("select owner from inventory where `id` = '".$_POST['flower']."' AND `owner` = '{$_SESSION['uid']}'");
        if (!$item) {
            echo "<b><font color=red>Предмет на найден</font></b>";
        } elseif ($_POST['to_login'] == $user['login']) {
            echo "<b><font color=red>Очень щедро дарить что-то самому себе ;)</font></b>";
        }
        elseif ($to['room'] > 500 && $to['room'] < 561) {
            echo "<b><font color=red>Персонаж в данный момент участвует в турнире в Башне Смерти. Попробуйте позже.</font></b>";
        }
        else {

            if($_POST['from']==1) { $from = 'Аноним'; }
            elseif($_POST['from']==2 && $user['klan']) { $from = ' клана '.$user['klan']; }
            else {$from = $user['login'];}
            if ($to) if(mysql_query("UPDATE `inventory` SET `owner` = '".$to['id']."', `present` = '".$from."', `letter` = '".$_POST['podarok2']."' WHERE  `present` = '' AND `id` = '".$_POST['flower']."' AND `owner` = '{$_SESSION['uid']}' AND `dressed` = 0  AND `setsale`=0")) {
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

    $data = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `gift`=1 AND `setsale`=0 AND `present` = '' ORDER by `id` DESC; ");
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
    $data = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `honor` = 0 AND `dressed` = 0  AND `setsale`=0  AND `podzem`=0 AND `gift`=0 AND `honor`=0 AND type<>199 and `ecost`>0 ORDER by `update` DESC; ");
    while($row = mysql_fetch_array($data)) {
        $row['count'] = 1;
        if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
        echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"".IMGBASE."/i/sh/{$row['img']}\" BORDER=0>";

        $price=$row['ecost']*SELLCOEF;
        ?>
        <!--<BR><A HREF="berezkang.php?sed=<?=$row['id']?>&sid=&sale=1">продать за <?=round($price-$row['duration']*($row['ecost']/($row['maxdur']*10)),2)?></A>-->
            <BR><A HREF="berezkang.php?sed=<?=$row['id']?>&sid=&sale=1">продать за <?=floor($row['ecost']*SELLCOEF*(($row["maxdur"]-$row["duration"])/$row["maxdur"])*10)/10?> екр</A>

        </TD>
        <?php
        echo "<TD valign=top>";
        showitem ($row);
        echo "</TD></TR>";
    }
} else
{
    $data = mysql_query("SELECT * FROM `berezka_ng` WHERE `count` > 0 AND `razdel` = '{$_GET['otdel']}' ORDER by `ecost` ASC, `ecost` ASC");
    while($row = mysql_fetch_array($data)) {
        if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
        echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"".IMGBASE."/i/sh/{$row['img']}\" BORDER=0>";
        ?>
        <BR><A HREF="berezkang.php?otdel=<?=$_GET['otdel']?>&set=<?=$row['id']?>&sid=">купить</A>
        <IMG SRC="<?=IMGBASE?>/i/up.gif" WIDTH=11 HEIGHT=11 BORDER=0 ALT="Купить несколько штук" style="cursor:hand" onClick="AddCount('<?=$row['id']?>', '<?=$row['name']?>')"></TD>
        <?php
        echo "<TD valign=top>";
        showitem ($row);
        echo "</TD></TR>";
    }
}
    $user8 = mysql_fetch_array(mysql_query("SELECT ekr FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
?>
</TABLE>
</TD></TR>
</TABLE>
<?
    if ($_GET['otdel']==72) {
      echo "Вы можете приобрести любые вещи из ассортимента Берёзки с любым или другими изображениями и названием по своему выбору. Так-же вы покупаете любую вещь и устанавливаете на неё любую картинку, и у неё меняется название по вашему желанию. При этом можно улучшить модификаторы вещи.
      После приобретения какой-либо другой персонаж прибрести такую же больше не сможет.<br>";
      $d=opendir("i/sh/nameditems");
      while ($f=readdir($d)) {
        if ($f=="." || $f=="..") continue;
        echo "<img src=\"".IMGBASE."/i/sh/nameditems/$f\">";
      }
    }
?>
    </TD>
    <TD valign=top width=280>

    <CENTER><B>Масса всех ваших вещей: <?php


    echo $d[0];
    ?>/<?=get_meshok()?><BR>
    У вас в наличии: <FONT COLOR="#339900"><?=$user8['ekr']?></FONT> екр.</B></CENTER>
    <div style="MARGIN-LEFT:15px; MARGIN-TOP: 10px;">

    <!--<INPUT TYPE="submit" value="Продать вещи" name="sale"><BR>-->

<div style="background-color:#d2d0d0;padding:1"><center><font color="#oooo"><B>Отделы магазина</B></center></div>
<?
  function shoplink($otdel, $name, $caption=0) {
    return "<A HREF=\"berezkang.php?otdel=$otdel\">".($otdel==$_GET["otdel"]?"<DIV style='background-color: #C7C7C7'>":"").($caption?"":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;").$name.($otdel==$_GET["otdel"]?"</div></a>":"</a><br>")."";
  }
  echo shoplink(1, "Елки",1);
  //echo shoplink(11, "Топоры");
  //echo shoplink(12, "Дубины,булавы");
  //echo shoplink(13, "Мечи");
  //echo shoplink(30, "Магические посохи");
  //echo shoplink(14, "Луки и арбалеты");
  echo shoplink(2, "Cапоги", 1);
  echo shoplink(21, "Перчатки");
  //echo shoplink(8, "рубашки, футболки");
  echo shoplink(9, "Накидки");
  //echo shoplink(22, "легкая броня");
  //echo shoplink(23, "Тяжелая броня");
  echo shoplink(24, "Шлемы");
  //echo shoplink(25, "наручи");
  //echo shoplink(26, "пояса");
  //echo shoplink(27, "поножи");
  //echo shoplink(3, "Щиты", 1);
  //echo shoplink(4, "Ювелирные товары: серьги", 1);
  //echo shoplink(41, "ожерелья");
  //echo shoplink(42, "кольца");
  //echo shoplink(5, "Заклинания: нейтральные", 1);
  //echo shoplink(51, "боевые и защитные");
  //echo shoplink(53, "усиления оружия");
  //echo shoplink(52, "Орудия труда", 1);
  /*echo shoplink(6, "Амуниция", 1);
  //echo shoplink(188, "Эликсиры");
  echo shoplink(7, "Открытки",);*/
  echo shoplink(71, "Сувениры: подарки", 1);
  //echo shoplink(73, "Коллекционные вещи", 1);
  //echo shoplink(72, "Именные вещи", 1);
?>
<!--<A HREF="shop.php?present=1">Сделать подарки</A><BR>-->
<?
  //echo shoplink(50, "Еда", 1);
  //echo shoplink(52, "Орудия труда", 1);
?>
    </div>
<div id="hint3" class="ahint"></div>
    </TD>
    </FORM>
</TR>
</TABLE>

<br><div align=left>

    <?php include("mail_ru.php"); ?>

<div>

</BODY>
</HTML>
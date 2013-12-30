<?php
    session_start();
    if ($_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
    include "functions.php";
    $d = mysql_fetch_array(mysql_query("SELECT sum(`massa`) FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `setsale` = 0 ; "));
    if ($user['room'] != 37) { header("Location: main.php");  die(); }
    if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }

    if (($_GET['set'] OR $_POST['set'])) {
        if ($_GET['set']) { $set = $_GET['set']; }
        if ($_POST['set']) { $set = $_POST['set']; }
        if (!$_POST['count']) { $_POST['count'] =1; } else $_POST['count']=(int)$_POST['count'];
        $dress = mysql_fetch_array(mysql_query("SELECT * FROM `".($_GET["otdel"]==24?"":"honor_")."shop` WHERE `id` = '{$set}' LIMIT 1;"));
        if (($dress['massa']*$_POST['count']+$d[0]) > (get_meshok())) {
            echo "<font color=red><b>Недостаточно места в рюкзаке.</b></font>";                                          
        } elseif(($user['honorpoints']>= ($dress['honor_cost']*$_POST['count'])) && ($dress['count'] >= $_POST['count']) && $dress["honor_cost"]>0) {

            for($k=1;$k<=$_POST['count'];$k++) {
              if ($_GET["otdel"]==24) takeshopitem($set);
              else {
                if(mysql_query("INSERT INTO `inventory`
                (`prototype`,`owner`,`name`,`type`,`massa`,`honor_cost`,`img`,`maxdur`,`isrep`,
                    `gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gmana`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
                    `mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`gmp`,`gmeshok`,`artefact`,`destinyinv`,`gift`,`mfkritpow`,`mfantikritpow`,`mfparir`,`mfshieldblock`,`mfcontr`,`mfrub`,`mfkol`,`mfdrob`,`mfrej`,`mfdhit`,`mfdmag`,`mfhitp`,`mfmagp`,`honor`,`dvur`,`second`,
                    chkol, chrej, chrub, chdrob, chmag
                )
                VALUES
                ('{$dress['id']}','{$_SESSION['uid']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['honor_cost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gmana']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
                '{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}','{$dress['razdel']}','{$dress['gmp']}','{$dress['gmeshok']}','{$dress['artefact']}','{$dress['destiny']}','{$dress['gift']}','{$dress['mfkritpow']}','{$dress['mfantikritpow']}','{$dress['mfparir']}','{$dress['mfshieldblockj']}','{$dress['mfcontr']}','{$dress['mfrub']}','{$dress['mfkol']}','{$dress['mfdrob']}','{$dress['mfrej']}','{$dress['mfdhit']}','{$dress['mfdmag']}','{$dress['mfhitp']}','{$dress['mfmagp']}','{$dress['honor']}','{$dress['dvur']}','{$dress['second']}',
                $dress[chkol], $dress[chrej], $dress[chrub], $dress[chdrob], $dress[chmag]
                ) ;"))
                {
                    $good = 1;
                }
                else {
                    $good = 0;
                }
              }
            }
            if ($good || 1) {
                //mysql_query("UPDATE `honor_shop` SET `count`=`count`-{$_POST['count']} WHERE `id` = '{$set}' LIMIT 1;");
                echo "<font color=red><b>Вы купили {$_POST['count']} шт. \"{$dress['name']}\".</b></font>";
                mysql_query("UPDATE `users` set `honorpoints` = `honorpoints`- '".($_POST['count']*$dress['honor_cost'])."' WHERE id = {$_SESSION['uid']} ;");
                $user['honorpoints'] -= $_POST['count']*$dress['honor_cost'];
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
                $allcost=$_POST['count']*$dress['honor_cost'];
                mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" купил товар: \"".$dress['name']."\" ".$dresscount."id:(".$dressid.") [0/".$dress['maxdur']."] за ".$allcost." благородства. ',1,'".time()."');");
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
<FORM action="city.php" method=GET>
<tr><td><h3>Магазин Благородства</td><td align=right>
<INPUT TYPE="button" value="Подсказка" style="background-color:#A9AFC0" onClick="window.open('help/shop.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">
<INPUT TYPE="submit" value="Вернуться" name="strah"></td></tr>
</FORM>
</table>
<TABLE border=0 width=100% cellspacing="0" cellpadding="4">
<TR>
    <FORM METHOD=POST ACTION="gotzamok.php">
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

    case 14:
        echo "Оружие: луки и арбалеты";
    break;

    case 2:
        echo "Одежда: сапоги";
    break;

    case 21:
        echo "Одежда: перчатки";
    break;

    case 22:
        echo "&Одежда: легкая броня";
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
    case 6:
        echo "Амуниция";
    break;
        echo "Сувениры: открытки";
    break;
    case 71:
        echo "Сувениры: подарки";
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
{
    $data = mysql_query("SELECT * FROM `".($_GET["otdel"]==24?"":"honor_")."shop` WHERE honor_cost>0 and `razdel` = '{$_GET['otdel']}' ORDER by `nlevel` ASC");
    while($row = mysql_fetch_array($data)) {
      $row["count"]=10000;
        if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
        echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"".IMGBASE."/i/sh/{$row['img']}\" BORDER=0>";
        ?>
        <BR><A HREF="gotzamok.php?otdel=<?=$_GET['otdel']?>&set=<?=$row['id']?>&sid=">купить</A>
        <IMG SRC="<?=IMGBASE?>/i/up.gif" WIDTH=11 HEIGHT=11 BORDER=0 ALT="Купить несколько штук" style="cursor:hand" onClick="AddCount('<?=$row['id']?>', '<?=$row['name']?>')"></TD>
        <?php
        echo "<TD valign=top>";
        showitem ($row);
        echo "</TD></TR>";
    }
}
    $user8 = mysql_fetch_array(mysql_query("SELECT honorpoints FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
?>
</TABLE>
</TD></TR>
</TABLE>

    </TD>
    <TD valign=top width=280>

    <CENTER><B>Масса всех ваших вещей: <?php


    echo $d[0];
    ?>/<?=get_meshok()?><BR>
    У вас в наличии: <FONT COLOR="#339900"><?=$user8['honorpoints']?></FONT> благородства.</B></CENTER>
    <div style="MARGIN-LEFT:15px; MARGIN-TOP: 10px;">


<div style="background-color:#d2d0d0;padding:1"><center><font color="#oooo"><B>Отделы магазина</B></center></div>
<A HREF="gotzamok.php?otdel=1&sid=&0.162486541405194">Оружие: кастеты,ножи</A><BR>
<A HREF="gotzamok.php?otdel=11&sid=&0.337606814894404">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;топоры</A><BR>
<A HREF="gotzamok.php?otdel=12&sid=&0.286790872806733">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;дубины,булавы</A><BR>
<A HREF="gotzamok.php?otdel=13&sid=&0.0943516060419363">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;мечи</A><BR>
<A HREF="gotzamok.php?otdel=14&sid=&0.0943516060419363">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;луки и арбалеты</A><BR>
<A HREF="gotzamok.php?otdel=2&sid=&0.76205958316951">Одежда: сапоги</A><BR>
<A HREF="gotzamok.php?otdel=21&sid=&0.648260824682342">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;перчатки</A><BR>
<A HREF="gotzamok.php?otdel=22&sid=&0.520447517792988">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;легкая броня</A><BR>
<A HREF="gotzamok.php?otdel=23&sid=&0.99133839275569">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;тяжелая броня</A><BR>
<A HREF="gotzamok.php?otdel=24&sid=&0.567932791291376">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;шлемы</A><BR>
<A HREF="gotzamok.php?otdel=25&sid=&0.567932791296566">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;наручи</A><BR>
<A HREF="gotzamok.php?otdel=26&sid=&0.567932791291655">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;пояса</A><BR>
<A HREF="gotzamok.php?otdel=27&sid=&0.567932791291687">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;поножи</A><BR>
<A HREF="gotzamok.php?otdel=3&sid=&0.725667864710179">Щиты</A><BR>
<A HREF="gotzamok.php?otdel=4&sid=&0.321709306035984">Ювелирные товары: серьги</A><BR>
<A HREF="gotzamok.php?otdel=41&sid=&0.902093651333512">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ожерелья</A><BR>
<A HREF="gotzamok.php?otdel=42&sid=&0.510210803380268">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;кольца</A><BR>
<A HREF="gotzamok.php?otdel=5&sid=&0.648834385828923">Заклинания: нейтральные</A><BR>
<A HREF="gotzamok.php?otdel=51&sid=&0.722009624500359">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;боевые и защитные</A><BR>
<A HREF="gotzamok.php?otdel=6&sid=&0.925798340638547">Амуниция</A><BR>
<A HREF="gotzamok.php?otdel=7&sid=&0.925798340638547">Сувениры: открытки</A><BR>
<A HREF="gotzamok.php?otdel=71&sid=&0.925798340638547">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;подарки</A><BR>
<A HREF="gotzamok.php?present=1">Сделать подарки</A><BR>
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

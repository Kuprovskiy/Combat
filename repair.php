<?php
    session_start();
    $repcond = "`isrep` = 1 AND `honor` = 0 AND `artefact` = 0 AND `type` != 25 and type<>49 AND `type` < 200 and type<>188  AND `setsale`=0 and `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 and duration>0";
    $gravcond="or prototype=1832 or prototype=1833 or prototype=2092 or prototype=2093 or prototype=1834";


    if ($_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
    include "functions.php";
    $d = mysql_fetch_array(mysql_query("SELECT sum(`massa`) FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0; "));
    if ($user['room'] != 23)  { header("Location: main.php"); die(); }
    if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }

    if($_POST['set'] && $_POST['count'] && ($user['money'] >= 50)) {
    
        if (mysql_query("UPDATE `inventory` SET `text` = '{$_POST['count']}' WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `id` = '{$_POST['set']}' AND `setsale`=0 and (type=3 $gravcond) LIMIT 1;")) {
            mysql_query("UPDATE `users` set `money` = `money`- '50' WHERE id = {$_SESSION['uid']}");
        }
    }
    if($_GET['rep'] && ($_GET['sid']==2)) {
        mq("UPDATE `inventory` SET `text` = '' WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `id` = '{$_GET['rep']}' LIMIT 1;");
    }

    if($_GET['sid'] && $_GET['rep']) {
        switch($_GET['sid']) {
            case 1:
                                                                                                                                  
                $row = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE $repcond AND `id` = '{$_GET['rep']}' LIMIT 1;"));
                if($row['duration'] >0) {
                    //$onecost=$row['cost']/($row['maxdur']*10);
                    //if($onecost < 0.1) {$onecost=0.1;}
                    $onecost=0.1;
                    if($onecost <= $user['money'])  {
                        if(mysql_query("UPDATE `inventory` SET `duration` = `duration`-1 WHERE `id` = {$_GET['rep']}")) {
                            $err = "<font color=red><b>Произведен ремонт предмета \"{$row['name']}\"  за  ".round($onecost,2)."  кр. </b></font>";
                            mysql_query("UPDATE `users` set `money` = `money`- '".(round($onecost,2))."' WHERE id = {$_SESSION['uid']}");
                            $newduration=$row['duration']-1;
                            mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','Отремонтирован предмет \"".$row['name']."\" id:(cap".$row['id'].") [".$newduration."/".$row['maxdur']."] у \"".$user['login']."\" за ".round($onecost,2)." кр. ',1,'".time()."');");
                            $user['money']=$user['money'] - round($onecost,2);
                            if(rand(1,10)==1) {
                                $err .= "<font color=red><b>К сожалению максимальная долговечность предмета из-за ремонта уменьшилась.</b></font>";
                                mysql_query("UPDATE `inventory` SET `maxdur` = `maxdur`-1 WHERE `id` = {$_GET['rep']}");
                            }
                        }
                    }
                    else {
                        $err = "<font color=red><b>Недостаточно денег.</b></font>";
                    }
                }
            break;
            case 10:
                $row = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE $repcond AND `id` = '{$_GET['rep']}' LIMIT 1;"));
                if($row['duration'] >= 10) {
                    //$onecost=$row['cost']/($row['maxdur']*10);
                    //if($onecost < 0.1) {$onecost=0.1;}
                    $onecost=0.1;
                    if(($onecost*10) <= $user['money'])  {

                        if(mysql_query("UPDATE `inventory` SET `duration` = `duration`-10 WHERE `id` = {$_GET['rep']}"))
                        {
                            $err = "<font color=red><b>Произведен ремонт предмета \"{$row['name']}\"  за  ".(round($onecost,2)*10)."  кр. </b></font>";
                            mysql_query("UPDATE `users` set `money` = `money`- '".(round($onecost,2)*10)."' WHERE id = {$_SESSION['uid']}");
                            $newduration=$row['duration']-10;
                            mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','Отремонтирован предмет \"".$row['name']."\" id:(cap".$row['id'].") [".$newduration."/".$row['maxdur']."] у \"".$user['login']."\" за ".(round($onecost,2)*10)." кр. ',1,'".time()."');");
                            $user['money']=$user['money'] - (round($onecost,2)*10);
                            if(rand(1,7)==1) {
                                $err .= "<font color=red><b>К сожалению максимальная долговечность предмета из-за ремонта уменьшилась.</b></font>";
                                mysql_query("UPDATE `inventory` SET `maxdur` = `maxdur`-1 WHERE `id` = {$_GET['rep']}");
                            }
                        }
                    } else {
                        $err = "<font color=red><b>Недостаточно денег.</b></font>";
                    }
                }
            break;
            case 'full':
                $row = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE $repcond and `id` = '{$_GET['rep']}' LIMIT 1;"));
                $full = $row['duration'];
                if($row['duration'] >1) {
                    //$onecost=$row['cost']/($row['maxdur']*10);
                    //if($onecost < 0.1) {$onecost=0.1;}
                    $onecost=0.1;
                    if(round($onecost*$full) <= $user['money'])  {
                        if(mysql_query("UPDATE `inventory` SET `duration` = '0' WHERE `id` = {$_GET['rep']}"))
                            {
                            $err = "<font color=red><b>Произведен ремонт предмета \"{$row['name']}\"  за  ".(round($onecost,2)*$full)."  кр. </b></font>";
                            mysql_query("UPDATE `users` set `money` = `money`- '".(round($onecost,2)*$full)."' WHERE id = {$_SESSION['uid']}");
                            mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','Отремонтирован предмет \"".$row['name']."\" id:(cap".$row['id'].") [0/".$row['maxdur']."] у \"".$user['login']."\" за ".(round($onecost,2)*$full)." кр. ',1,'".time()."');");
                            $user['money']=$user['money'] - (round($onecost,2)*$full);
                            if(rand(1,5)==1) {
                                $err .= "<font color=red><b>К сожалению максимальная долговечность предмета из-за ремонта уменьшилась.</b></font>";
                                mysql_query("UPDATE `inventory` SET `maxdur` = `maxdur`-1 WHERE `id` = {$_GET['rep']}");
                            }
                        }
                    }
                    else {
                        $err = "<font color=red><b>Недостаточно денег.</b></font>";
                    }
                }
            break;
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
function AddCount(name)
{
    document.all("hint3").innerHTML = ' <FORM METHOD=POST ACTION="repair.php?razdel=1"><table border=0 width=100% cellspacing=1 cellpadding=0 bgcolor="#CCC3AA"><tr><td align=center><B>Гравировка</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</TD></tr><tr><td colspan=2>'+
    '<table border=0 width=100% cellspacing=0 cellpadding=0 bgcolor="#FFF6DD"><tr><INPUT TYPE="hidden" name="set" value="'+name+'"><td colspan=2 align=center><small>Какую надпись желаете выгравировать:</small></td></tr><tr><td width=80% align=right>'+
    '<INPUT TYPE="text" NAME="count" size=30></td><td width=20%>&nbsp;<INPUT TYPE="submit" value=" »» ">'+
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
<? if ($user['id'] != 7) { ?>
<script LANGUAGE='JavaScript'>   
document.ondragstart = test;
//запрет на перетаскивание
document.onselectstart = test;
//запрет на выделение элементов страницы
document.oncontextmenu = test;
//запрет на выведение контекстного меню
function test() {
 return false
}
</SCRIPT>
<? } ?>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=#e0e0e0>
<TABLE border=0 width=100% cellspacing="0" cellpadding="0">
<FORM action="city.php" method=GET>
<tr><td><h3>Ремонтная мастерская</td><td align=right>
<INPUT TYPE="button" value="Подсказка" style="background-color:#A9AFC0" onclick="window.open('help/shop.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">
<INPUT TYPE="submit" value="Вернуться" name="cp"></td></tr>
</FORM>
</table>
<TABLE border=0 width=100% cellspacing="0" cellpadding="4">
<TR>
    <FORM METHOD=POST ACTION="repair.php">
    <INPUT TYPE="hidden" name="sid" value="">
    <INPUT TYPE="hidden" name="id" value="1">
    <TD valign=top align=left>

    <TABLE border=0 width=100% cellspacing="0" cellpadding="0" bgcolor="#A5A5A5">
    <TR><TD>
        <TABLE border=0 width=100% cellspacing="0" cellpadding="1" bgcolor=#d4d2d2><TR>
            <td align=center bgcolor=#C7C7C7><B>Залы:</B></TD>
            <TD  align=center bgcolor="<?=($_GET['razdel']==0)?"#A5A5A5":"#C7C7C7"?>"><A HREF="?razdel=0">Ремонт</A></TD>
            <TD  align=center bgcolor="<?=($_GET['razdel']==1)?"#A5A5A5":"#C7C7C7"?>"><A HREF="?razdel=1">Гравировка</A></TD>

    </TR>
    <TR>
    <td colspan=5 bgcolor=#A5A5A5>
        <CENTER><B><?
            switch ($_GET['razdel']) {
                case 0: echo "Починка поврежденных предметов"; break;
                case 1: echo "Нанесение надписей на оружие"; break;
                case 2: echo "Перезарядка встроеной магии</B><BR><i>Если в предмет встроена магия, мы поможем ее перезарядить за умеренную плату. Учтите, ничто не вечно под луной, в том числе и магия, рано или поздно встроенный свиток исчерпает все свои ресурсы, и мы уже не сможем его перезарядить.</i>"; break;
                case 3: echo "Модификация предметов</B><BR><I>Наши мастера помогут вам модифицировать ваши доспехи. К сожалению, технология не позволяет повторно модифицировать вещи. Чем выше у вас интеллект, тем яснее вы сможете объяснить мастерам желаемый результат. Результат может быть непредсказуем!</I><B>"; break;
            }
        ?></B></CENTER>
    </td>
    </tr>
    </TABLE>
    </TR>
<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">
<?php
if ($_GET['razdel']==0) {
    $data = mysql_query("SELECT * FROM `inventory` WHERE $repcond ORDER by `update` DESC; ");
    while($row = mysql_fetch_array($data)) {
        $row['count'] = 1;
        if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
        echo "<TR bgcolor={$color}><TD align=center ><IMG SRC=\"i/sh/{$row['img']}\" BORDER=0>";
        //$onecost=$row['cost']/($row['maxdur']*10);
        //if ($onecost < 0.1) {$onecost=0.1;}
        $onecost=0.1;
        ?>
        <BR><small>
            <? if($row['duration'] >0){?><A HREF="?rep=<?=$row['id']?>&sid=1">Ремонт 1 ед. за <?=round($onecost,2)?> кр.</A><BR><?}  else { echo "не нуждается в ремонте";}?>
            <? if($row['duration'] >=10){?><A HREF="?rep=<?=$row['id']?>&sid=10">Ремонт 10 ед. за <?=round(($onecost*10),2)?> кр.</A><BR><?}?>
            <? if($row['duration'] >1){?><A HREF="?rep=<?=$row['id']?>&sid=full">Полный ремонт за <?=round(($row['duration']*$onecost),2)?> кр.</A><?}?>
        </small>
        </TD>
        <?php
        echo "<TD valign=top>";
        showitem ($row);
        echo "</TD></TR>";
    }
}

if ($_GET['razdel']==1) {
    $data = mq("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND ((`type` = 3  AND `name` NOT LIKE '%Букет%') $gravcond) AND `setsale`=0 ORDER by `update` DESC; ");
    while($row = mysql_fetch_array($data)) {
        $row['count'] = 1;
        if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
        echo "<TR bgcolor={$color}><TD align=center ><IMG SRC=\"i/sh/{$row['img']}\" BORDER=0>";
        ?>
        <BR><small>
            <? if($row['text']== null){?><A HREF="#" onclick="AddCount(<?=$row['id']?>)">Нанести надпись за 50 кр.</A><BR><?}  else {
            ?><A HREF="?razdel=1&rep=<?=$row['id']?>&sid=2">Стереть надпись</A><BR><?}?>
        </small>
        </TD>
        <?php
        echo "<TD valign=top>";
        showitem ($row);
        echo "</TD></TR>";
    }
}

if ($_GET['razdel']==2) {
    if($_GET['it']) {
        $row = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `includemagicmax` > 0 AND `id` = '{$_GET['it']}' LIMIT 1;"));
        if($user['money'] < $row['includemagiccost'] && $row['includemagicdex'] ==0) {
            $err= "<font color=red><b>У вас не хватает денег на перезарядку.</b></font>";
        }
        else {
            if($row['includemagicuses'] <=1) {
                $err= "<font color=red><b>Мы сожалеем, свиток исчерпал все свои ресурсы, и мы уже не можем его перезарядить.</b></font>";
                mysql_query("UPDATE `users` set `money` = `money`- '".($row['includemagiccost'])."' WHERE id = {$_SESSION['uid']}");
                mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','Перезаряжена магия \"".$row['name']."\" id:(cap".$row['id'].") [".$newduration."/".$row['maxdur']."] у \"".$user['login']."\" за ".round($onecost,2)." кр. ',1,'".time()."');");
                mysql_query("UPDATE `inventory` SET `includemagic` = '', `includemagicdex` = '', `includemagicmax` = '', `includemagicname` = '', `includemagicuses` = '', `includemagiccost` = '' WHERE `id` = '{$_GET['it']}' LIMIT 1;");
            } else {
                $err= "<font color=red><b>Магия успешно перезаряжена.</b></font>";
                mysql_query("UPDATE `users` set `money` = `money`- '".($row['includemagiccost'])."' WHERE id = {$_SESSION['uid']}");
                mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','Перезаряжена магия \"".$row['name']."\" id:(cap".$row['id'].") [".$newduration."/".$row['maxdur']."] у \"".$user['login']."\" за ".round($onecost,2)." кр. ',1,'".time()."');");
                mysql_query("UPDATE `inventory` SET `includemagicdex` = `includemagicmax`, `includemagicuses` = `includemagicuses`-1 WHERE `id` = '{$_GET['it']}' LIMIT 1;");
            }
        }
    }


    $data = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `includemagicmax` > 0 AND `setsale`=0 ORDER by `update` DESC; ");
    while($row = mysql_fetch_array($data)) {
        $row['count'] = 1;
        if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
        echo "<TR bgcolor={$color}><TD align=center ><IMG SRC=\"i/sh/{$row['img']}\" BORDER=0>";
        ?>
        <BR>
        <small>
            <?
                if($row['includemagicdex'] ==0) {
                    ?><A HREF="?razdel=2&it=<?=$row['id']?>">Перезарядить за <?=$row['includemagiccost']?> кр.</A><BR><?
                }
                else {
                    echo 'Не нуждается в перезарядке';
                }
            ?>
        </small>
        </TD>
        <?php
        echo "<TD valign=top>";
        showitem ($row);
        echo "</TD></TR>";
    }
}

if ($_GET['razdel']==3) {

    if($_GET['mf']) {
      $row = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `type` < 25 AND `type` != 0 AND `type` != 12 AND `honor` = 0 AND `artefact` = 0 AND `podzem` != 1 AND `owner` = '{$_SESSION['uid']}' AND `id` = '{$_GET['mf']}' AND `name` NOT LIKE '% (мф)%' AND `name` NOT LIKE '%Букет%'  AND `name` NOT LIKE '%Мешок%' AND `setsale`=0 LIMIT 1;"));
      if ($row) {
        if (!$row["cost"]) $row['cost']=$row['ecost']*11;
        $row["cost"]*=0.3;
        if($user['money'] < $row['cost'] OR !$row) {
            $err= "<font color=red><b>У вас не хватает денег на модификацию.</b></font>";
        }
        else {
            srand(make_seed());
            $type = rand(1,4);
            $mfintel=round($user['intel']/10-10);
            if ($mfintel > -1) {$mfintel = -1;}
            $statintel=round($user['intel']/25-2);
            if ($statintel > -1) {$statintel = -1;}
            $nstatintel=round(2-$user['intel']/25);
            if ($nstatintel < 1) {$nstatintel = 1;}
            srand(make_seed());
            $mf1=rand($mfintel,20);
            srand(make_seed());
            $mf2=rand($mfintel,20);
            srand(make_seed());
            $st1=rand($statintel,2);
            srand(make_seed());
            $st2=rand(-2,$nstatintel);
            srand(make_seed());
            $min=rand($statintel,2);
            srand(make_seed());
            $max=rand($statintel,4);

            if ($st1>0) $st1=0;

            switch ($type) {
                case 1:
                    // крит
                    $mfkrit = $mf1;
                    $mfantiuvorot = $mf2;
                    $inta = $st1;
                    $hp = rand(0,15);
                    $ninta = $st2;
                break;
                case 2:
                    // ловкость
                    $mfuvorot = $mf1;
                    $mfantikrit = $mf2;
                    $lovk = $st1;
                    $hp = rand(1,15);
                    $nlovk = $st2;
                break;
                case 3:
                    // сила
                    $mfminu = $min;
                    $mfmaxu = $max;
                    $sila = $st1;
                    $hp = rand(6,20);
                    $nsila = $st2;
                break;
                case 4:
                    // вынос
                    $nvinos = $st2;
                    $mfantikrit = $mf1;
                    $bron1 = rand(0,3);
                    $bron2 = rand(0,3);
                    $bron3 = rand(0,3);
                    $bron4 = rand(0,3);
                    $hp = rand(0,15);
                break;
            }


            if(mysql_query("UPDATE `inventory` SET
                            `ghp` = `ghp`+'".(int)$hp."',
                            `bron1` = `bron1`+'".(int)$bron1."',
                            `bron2` = `bron2`+'".(int)$bron2."',
                            `bron3` = `bron3`+'".(int)$bron3."',
                            `bron4` = `bron4`+'".(int)$bron4."',
                            `mfkrit` = `mfkrit`+'".(int)$mfkrit."',
                            `mfakrit` = `mfakrit`+'".(int)$mfantikrit."',
                            `mfuvorot` = `mfuvorot`+'".(int)$mfuvorot."',
                            `mfauvorot` = `mfauvorot`+'".(int)$mfantiuvorot."',
                            `gsila` = `gsila`+'".(int)$sila."',
                            `glovk` = `glovk`+'".(int)$lovk."',
                            `ginta` = `ginta`+'".(int)$inta."',
                            `nsila` = `nsila`+'".(int)$nsila."',
                            `nlovk` = `nlovk`+'".(int)$nlovk."',
                            `ninta` = `ninta`+'".(int)$ninta."',
                            `nvinos` = `nvinos`+'".(int)$nvinos."',
                            ".(SELLCOEF==1?"":"`cost` = `cost` + '".round($row['cost']/10)."',")."
                            `name` = CONCAT(`name`, ' (мф)')
            WHERE `id` = '{$_GET['mf']}' LIMIT 1;") or die(mysql_error())) {
                //echo $row['cost'];qqq
                mysql_query("UPDATE `users` set `money` = `money`- '".($row['cost'])."' WHERE id = {$_SESSION['uid']}") or die(mysql_error());
                mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','Моцифицирована вещь \"".$row['name']."\" id:(cap".$row['id'].") [".$newduration."/".$row['maxdur']."] у \"".$user['login']."\" за ".round($row["cost"],2)." кр. ',1,'".time()."');") or die(mysql_error());
                $err= "<font color=red><b>Вещь модифицирована.</b></font>";
            }

        }
      } else {
        $err= "<font color=red><b>Вещь не может быть модифицирована!</b></font>";
      }
    }


    $data = mysql_query("SELECT * FROM `inventory` WHERE `type` < 25 AND `type` != 12 AND `artefact` = 0  AND `honor` = 0  AND `podzem` != 1 AND `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `name` NOT LIKE '% (мф)%' AND `name` NOT LIKE '%Букет%'  AND `name` NOT LIKE '%Мешок%' AND `name` NOT LIKE '%Копалка новичка%' AND `name` NOT LIKE '%Копалка мастера%' AND `setsale`=0 AND otdel != 50 ORDER by `update` DESC; ");
    while($row = mysql_fetch_array($data)) {
        $row['count'] = 1;
        if (!$row["cost"]) $row["cost"]=$row["ecost"]*11;
        if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
        echo "<TR bgcolor={$color}><TD align=center ><IMG SRC=\"i/sh/{$row['img']}\" BORDER=0>";
        ?>
        <BR><small>
            <A HREF="?razdel=3&mf=<?=$row['id']?>" onclick="if(!confirm('Вы действительно хотите модифицировать эту вещь?')){ return false;}">Модифицировать за <?=$row['cost']*0.3?> кр.</A><BR>
        </small>
        </TD>
        <?php
        echo "<TD valign=top>";
        showitem ($row);
        echo "</TD></TR>";
    }
}
?>
</TABLE>

</TD>

    <TD align=center>
    </TD>
<TD valign=top width=280><BR>
    <CENTER><B>Масса всех ваших вещей:

    <?=(int)$d[0];?>/<?=$user['sila']*4?><BR>
    У вас в наличии: <FONT COLOR="#339900"><?=$user['money']?></FONT> кр.</B></CENTER>
    <BR>
    <?=$err?>
</TD>
    </FORM>
</TR>
</TABLE>

<div id="hint3" class="ahint"></div>
</form>
<br><div align=left>

    <?php include("mail_ru.php"); ?>

<div>
</body>
</html>

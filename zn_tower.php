<?php

session_start();
if ($_SESSION['uid'] == null) header("Location: index.php");
include "connect.php";
include "functions.php";
$user=mysql_fetch_array(mysql_query("SELECT * from users where id='".$_SESSION['uid']."'"));
//if($user['room'] != '9001'){
    //mysql_query("UPDATE `users`,`online` SET `users`.`room` = '9001',`online`.`room` = '9001' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
   // header('location: city.php');
//}

if ($_GET['sed']>0 && $_GET['dissolve']==1 && is_numeric($_GET['sed'])) {
    $znTowerLevel = mysql_result(mysql_query("SELECT reputation FROM zn_tower WHERE user_id = " . $_SESSION['uid']), 0, 0);
    if ($znTowerLevel < 100) {
        $levelCond = "AND `nlevel`<='6' ";
    } elseif ($znTowerLevel < 1000) {
        $levelCond = "AND `nlevel`<='8' ";
    } else {
        $levelCond = "AND `nlevel`<='10' ";
    }
    $dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0  AND `nlevel`>=4 $levelCond AND gift = 0 AND destinyinv = 0 AND (type = 11 OR type = 1 OR type = 2 OR type = 9 OR type = 4 OR type = 8 OR type = 22 OR type = 23 OR type = 24 OR type = 5) AND id='".(int)$_GET['sed']."'"));
    if (mt_rand(1,10)<=3) {
        //echo mysql_error();
        if ($dress['id']>0) {
            $rlevel=array(4,7,9);
            if ($dress['nlevel']<7) {
                $rnn=0; $rune_level=$rlevel[$rnn];
            } elseif($dress['nlevel']<9) { 
                $rnn=mt_rand(0,1); $rune_level=$rlevel[$rnn];
            } else { 
                $rnn=mt_rand(1,2); $rune_level=$rlevel[$rnn];
            }
            if (mt_rand(1,10000)==7777) {
                $rune_level=99;
            }
            //$runlist=array(
            $rune_align=array("Игнис ","Аква ","Аура ","Тера ");
            $rune_lvl=array(4=>"Рота", 7=>"Триа", 9=>"Квад", 99=>"Уни");
            $rune_type=array("","хи","хэ","ви","во","кэ","ки","ми","си","мо","со");
            $rune_for =array("","Серьги","Ожерелье","Кольцо","Перчатки","Поножи","Обувь","Шлем","Наручи","Броня","Пояс");
            $params=array();
            $params[0][4]=array('mfrub=>1','mfmagp=>1','mfkrit=>5','mfdhit=>10','mfkrit=>5','mfdhit=>10','mfdmag=>10');
            $params[1][4]=array('mfrej=>1','mfmagp=>1','mfakrit=>5','mfdhit=>10','mfakrit=>5','mfdhit=>10','mfdmag=>10');
            $params[2][4]=array('mfkol=>1','mfmagp=>1','mfuvorot=>5','mfdhit=>10','mfuvorot=>5','mfdhit=>10','mfdmag=>10');
            $params[3][4]=array('mfdrob=>1','mfmagp=>1','mfauvorot=>5','mfdhit=>10','mfauvorot=5','mfdhit=>10','mfdmag=>10');
            $params[0][7]=array('ginta=>1','mfrub=>3','mfmagp=>3','mfkrit=>10','mfkrit=>10','mfdhit=>15','mfdmag=>15');
            $params[1][7]=array('glovk=>1','mfrej=>3','mfmagp=>3','mfakrit=>10','mfakrit=>10','mfdhit=>15','mfdmag=>15');
            $params[2][7]=array('gintel=>1','mfkol=>3','mfmagp=>3','mfuvorot=>10','mfdhit=>15','mfdmag=>15','gmana=>10');
            $params[3][7]=array('gsila=>1','mfdrob=>3','mfmagp=>3','mfauvorot=>10','mfdhit=>15','mfdmag=>15','ghp=>10');
            $params[0][9]=array('ginta=>2','mfrub=>5','mfmagp=>5','mfkrit=>15','mfkrit=>15','mfdhit=>25','mfdmag=>25');
            $params[1][9]=array('glovk=>2','mfrej=>5','mfmagp=>5','mfakrit=>15','mfakrit=>15','mfdhit=>25','mfdmag=>25');
            $params[2][9]=array('gintel=>2','mfkol=>5','mfmagp=>5','mfuvorot=>15','mfdhit=>15','mfdmag=>25','gmana=>20');
            $params[3][9]=array('gsila=>2','mfdrob=>5','mfmagp=>5','mfauvorot=>15','mfdhit=>15','mfdmag=>25','ghp=>20');
            $params[0][99]=array('ginta=>4','mfrub=>10','mfmagp=>10','mfkrit=>30','mfkrit=>30','mfdhit=>75','mfdmag=>75');
            $params[1][99]=array('glovk=>4','mfrej=>10','mfmagp=>10','mfakrit=>30','mfakrit=>30','mfdhit=>75','mfdmag=>75');
            $params[2][99]=array('gintel=>4','mfkol=>10','mfmagp=>10','mfuvorot=>30','mfdhit=>75','mfdmag=>75','gmana=>100');
            $params[3][99]=array('gsila=>4','mfdrob=>10','mfmagp=>10','mfauvorot=>30','mfdhit=>75','mfdmag=>75','ghp=>100');
            //);
            $rt=mt_rand(1,10);
            $ra=mt_rand(0,3);
            $rune_name=$rune_align[$ra].$rune_lvl[$rune_level].$rune_type[$rt];
            $stroka_par=$params[$ra][$rune_level][mt_rand(0,6)];
            $pp=explode("=>", $stroka_par);
            $stroka1="`{$pp[0]}`";
            $stroka2="'{$pp[1]}'";
            $rimg="rune_{$rnn}_{$ra}_{$rt}.gif";
            if($rune_level==99){$rimg="rune_super_1.gif";$rune_name="Униборо";$rune_level=9;}
            if (mysql_query("
                INSERT INTO `inventory` 
                (
                    `owner`,
                    `name`,
                    `type`,
                    `massa`,
                    `cost`,
                    `img`,
                    `maxdur`,
                    `isrep`,
                    `nlevel`,
                    `magic`,
                    `opisan`,
                    {$stroka1}
                )
                VALUES
                (
                    '{$_SESSION['uid']}',
                    '{$rune_name}',
                    '60',
                    '1',
                    '1',
                    '$rimg',
                    '1',
                    0,
                    '{$rune_level}',
                    '245',
                    'Этой руной можно улучшить предмет (".$rune_for[$rt].")',
                    {$stroka2}
                );
            ")) {
                destructitem($dress['id']);
                mysql_query("UPDATE zn_tower SET reputation = reputation + 1 WHERE user_id = " . $_SESSION['uid']);
                echo "<font color=red><b>Предмет удачно растворен. <br>Получена {$rune_name} за {$dress['name']}</b></font>";
            }
        }
    } else {
        destructitem($dress['id']);
        echo "<font color=red><b>Предмет растворен неудачно.</b></font>";
    }
}

?>
	
<HTML>
    
<HEAD>
    <?php if ($user['id'] != 7) { ?>
    <script LANGUAGE='JavaScript'>
    document.ondragstart = test;
    document.oncontextmenu = test;
    function test() {
     return false
    }
    </SCRIPT>
    <?php } ?>
    <link rel=stylesheet type="text/css" href="/i/main.css">
    <meta content="text/html; charset=windows-1251" http-equiv=Content-type>
    <META Http-Equiv=Cache-Control Content=no-cache>
    <meta http-equiv=PRAGMA content=NO-CACHE>
    <META Http-Equiv=Expires Content=0>
    <script src="js/lib/jquery.js" type="text/javascript"></script>
</HEAD>

<body bgcolor=e2e0e0 style="background-image: url(i/misc/iqtower_in.png);background-repeat:no-repeat;background-position:top right">

    <div id=hint4 class=ahint></div>
    <TABLE width=100%>
        <TR>
            <TD valign=top width=100%>
                <center>
                    <font style="font-size:24px; color:#000033">
                        <h3>Храм знаний. Алтарь предметов.</h3>
                    </font>
                </center>
            </TD>
            <TD nowrap valign=top>
                <BR>
                <DIV align=right>
                    <INPUT style="font-size:12px;" type='button' onClick="location='zn_tower.php'" value=Обновить>
                    <INPUT style="font-size:12px;" type='button' onClick="location='city.php?tower=1&level1000'" value=Вернуться>
                </DIV>
            </TD>
        </TR>
        <?php
            $last_visit = mysql_result(mysql_query("SELECT last_visit FROM zn_tower WHERE user_id = " . $_SESSION['uid']), 0, 0);
            $tflv = time() - $last_visit;
            if ($tflv < 3600*6) {
        ?>
        <tr>
            <td>    
                <div>
                    <font color="red">
                        <b>Вы можете посетить Алтарь предметов через <?php echo secs2hrs(3600*6 - $tflv) ?></b>
                    </font>
                </div>
            </td>
        </tr>
        <?php  } else { ?>
        <tr>
            <td>    
                <div>
                    <font color="red">
                        <b><?=$err?></b>
                    </font>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <TABLE BORDER=0 WIDTH=75% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">
                    <?php
                        $ci=0;
                        //$data = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0  AND `nlevel`>=4 and type<>25 and type<>30 and type<>188 and type<>3 and type<50 ORDER by `update` DESC; ");
                        $znTowerLevel = mysql_result(mysql_query("SELECT reputation FROM zn_tower WHERE user_id = " . $_SESSION['uid']), 0, 0);
                        if ($znTowerLevel < 100) {
                            $levelCond = "AND `nlevel`<='6' ";
                        } elseif ($znTowerLevel < 1000) {
                            $levelCond = "AND `nlevel`<='8' ";
                        } else {
                            $levelCond = "AND `nlevel`<='10' ";
                        }
                        $data = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0  AND `nlevel`>=4 $levelCond AND gift = 0 AND destinyinv = 0 AND (type = 11 OR type = 1 OR type = 2 OR type = 9 OR type = 4 OR type = 8 OR type = 22 OR type = 23 OR type = 24 OR type = 5) ORDER by `update` DESC; ");
                        while ($row = mysql_fetch_array($data)) {
                            $ci++;
                            $row['count'] = 1;
                            if ($i==0) { 
                                $i = 1; $color = '#C7C7C7';
                            } else { 
                                $i = 0; $color = '#D5D5D5'; 
                            }
                    ?>
                    <TR bgcolor=<?php echo $color ?>>
                        <TD align=center style='width:150px'>
                            <IMG SRC="/i/sh/<?php echo $row['img'] ?>" BORDER=0>
                            <BR>
                            <A HREF="zn_tower.php?sed=<?=$row['id']?>&sid=&dissolve=1">растворить</A>
                        </TD>
                        <TD valign=top><?php showitem ($row); ?></TD>
                    </TR>
                    <?php 
                        }
                        if($ci==0){
                            echo "<TR bgcolor=\"#C7C7C7\"><TD valign=top>";
                                echo "У вас нет подходящих предметов для расплавления.";
                            echo "</TD></TR>";
                        }
                    ?>
                </TABLE>
            </td>
        </tr>
        <?php } ?>
    </TABLE>
    
</BODY>

</HTML>

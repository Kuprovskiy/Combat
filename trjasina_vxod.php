<?php

session_start();  
include "connect.php";
include "functions.php";
$now = time();

?>

<HTML>
    
<HEAD>
    <link rel=stylesheet type="text/css" href="/i/main.css">
    <meta content="text/html; charset=windows-1251" http-equiv=Content-type>
    <META Http-Equiv=Cache-Control Content=no-cache>
    <meta http-equiv=PRAGMA content=NO-CACHE>
    <META Http-Equiv=Expires Content=0>
    <script type='text/javascript' SRC='time.js'></script>
    <?php if ($user['id'] != 7) { ?>
    <script type='text/javascript'>
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
    <?php } ?>
</HEAD>

<body bgcolor=e2e0e0 style="background-image: url(http://lostcombats.com/i/misc/trjasina.png);background-repeat:no-repeat;background-position:top right"> 
    
<!--FORM action="city.php" method=GET>
    <center>
        <INPUT class=input TYPE="button" value="Подсказка" onClick="window.open('help/secretlab.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">
        <INPUT class=input TYPE=button value="Вернуться" onClick="location.href='city.php?got=1&level45=1';">
        <a href = "http://lostcombats.com/i/map.gif" target="_blank">Карта Прохода</a>
    </center>
</FORM-->
<!--TABLE width=100%>
    <tr>
        <td valign=top width=100%>
            <center><font style="font-size: 16px; color: maroon; font-weight: bold;">Тайный проход из Клуба к Замку Законников</font></center>
        </td>
    </tr>
</table-->

<table border=0 width=100% cellspacing="0" cellpadding="0">
    <form action="city.php" method=GET>
        <tr>
            <td><h3>Вход в трясину</h3></td>
            <td align=right>
                <!--input style="font-size:12px;" type="button" value="Подсказка" style="background-color:#A9AFC0" onclick="window.open('help/lottery.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')"-->
                <input style="font-size:12px;" type='button' onClick="location='trjasina_vxod.php'" value="Обновить">
                <input style="font-size:12px;" type='button' onClick="location.href='city.php?got=1&level45=1';" value="Вернуться">
            </td>
        </tr>
    </FORM>
</table>

<div style="width:72%"> 

<div id=hint4 class=ahint></div>

<?php

if ($user['level'] >=7 ) {
    //Ring 1
    $boots = mysql_fetch_array(mysql_query("SELECT `prototype` FROM `inventory` WHERE `id`='".mysql_real_escape_string($user['boots'])."' AND `owner` = '".mysql_real_escape_string($user['id'])."' AND `dressed` > '0' AND `isrep` = '1'  AND `setsale`='0'"));
//  if($boots['prototype'] == 1109) {

    $owntravma = mysql_fetch_array(mysql_query("SELECT `type`,`id`,`sila`,`lovk`,`inta` FROM `effects` WHERE `owner` = '".mysql_real_escape_string($user['id'])."' AND (type=12 OR type=13 OR type=11 OR type=21 OR type=22 OR type=23);"));
    if (!$owntravma) {
        if ($user['anti_boloto'] <= $now) {
            //afk
            if ($_POST['afk']) {
                mysql_query("update `users` set `bol_status`='0' where `id`='".mysql_real_escape_string($user['id'])."'");
                echo"Ваш статус в группе: Отошел!<br>";
                echo"<script>location='trjasina_vxod.php'</script>";
            }
            //ready
            if ($_POST['ready']) {
                mysql_query("update `users` set `bol_status`='1' where `id`='".mysql_real_escape_string($user['id'])."'");
                echo"Ваш статус в группе: Я ГОТОВ!<br>";
                echo"<script>location='trjasina_vxod.php'</script>";
            }
            //Вступаем
            if ($_POST['add']) {
                $id =  $_POST['naw_id'];
                $kto =  $_POST['add_id'];
                $kto_nik = mysql_fetch_array(mysql_query("SELECT `login` FROM `users` WHERE `id` = '".mysql_real_escape_string($kto)."'"));
                if ($_POST['pass'] == $_POST['naw_pass']) {
                    $per_gro = mysql_fetch_array(mysql_query("SELECT * FROM `bol_group` WHERE `id` = '".mysql_real_escape_string($id)."'"));
                    if (!$per_gro['p1']){ $p = 'p1';  $pn = 'p1_nik';}
                    elseif (!$per_gro['p2']){ $p = 'p2' ;   $pn = 'p2_nik';}
                    elseif (!$per_gro['p3']){ $p = 'p3';  $pn = 'p3_nik';}
                    elseif (!$per_gro['p4']){ $p = 'p4' ; $pn = 'p4_nik';}
                    else{ $slot = 1;}
                    mysql_query("UPDATE `bol_group` set `sostav`=`sostav`+'1',`".mysql_real_escape_string($p)."`='".mysql_real_escape_string($kto)."', `".mysql_real_escape_string($pn)."`='".mysql_real_escape_string($kto_nik['login'])."' WHERE id = '".mysql_real_escape_string($id)."'");
                    mysql_query("UPDATE `users` set `boloto_groups`='".mysql_real_escape_string($id)."' WHERE `id` = '".mysql_real_escape_string($kto)."'");
                    mysql_query("insert into `vault_user_navig` (`group_id`,`login`,`l`,`t`,`loc`) VALUES ('".mysql_real_escape_string($id)."','".$user['login']."','100','100','2001') ");
                    echo"Вы удачно вступили в группу!";
                    echo"<script>location='trjasina_vxod.php'</script>";
                } else {
                    echo"Пароль не верный!";
                }
            }
            //Выходит
            if ($_POST['exit']) {
                $id = $_POST['id'] ;
                $kto = $_POST['kto'] ;
                $per_gro = mysql_fetch_array(mysql_query("SELECT * FROM `bol_group` WHERE `id` = '".mysql_real_escape_string($id)."'"));
                if ($per_gro['p1'] == $user['id']) { $p = 'p1';  $pn = 'p1_nik';}
                elseif ($per_gro['p2'] == $user['id']){ $p = 'p2' ;   $pn = 'p2_nik';}
                elseif ($per_gro['p3'] == $user['id']){ $p = 'p3';  $pn = 'p3_nik';}
                elseif ($per_gro['p4'] == $user['id']) { $p = 'p4' ; $pn = 'p4_nik';}
                else $slot = 1;
                mysql_query("UPDATE `bol_group` set `sostav`=`sostav`-'1',`".mysql_real_escape_string($p)."`='0', `".mysql_real_escape_string($pn)."`='' WHERE id = '".mysql_real_escape_string($id)."'");
                mysql_query("UPDATE `users` set `boloto_groups`='0',`bol_status`='0' WHERE `id` = '".mysql_real_escape_string($kto)."'");
                mysql_query("delete from `vault_user_navig` where `group_id`='".$id."' and `login`='".$user['login']."'");
                echo "Вы вышли с группы!<BR>";
                echo "<script>location='trjasina_vxod.php'</script>";
            }
            //Расформировка
            if ($_POST['closed']) {
                $id = $_POST['id'] ;
                $kto = $_POST['kto'] ;
                $per_gro = mysql_fetch_array(mysql_query("SELECT * FROM `bol_group` WHERE `id` = '".mysql_real_escape_string($id)."'"));
                mysql_query("UPDATE `users` set `boloto_groups`=0, `bol_status`=0 WHERE `id` = '".mysql_real_escape_string($per_gro['p1'])."' or `id` = '".mysql_real_escape_string($per_gro['p2'])."' or `id` = '".mysql_real_escape_string($per_gro['p3'])."' or `id` = '".mysql_real_escape_string($per_gro['p4'])."'");
                mysql_query("delete from `bol_group` where `id`='".mysql_real_escape_string($id)."'");
                mysql_query("delete from `vault_user_navig` where `group_id`='".$id."'");
                echo"Вы расформировали группу!<BR>";
                echo"<script>location='trjasina_vxod.php'</script>";
            }
            //СТАРТ!!!
            if ($_POST['start']) {
                $id = $_POST['id'] ;
                $kto = $_POST['kto'] ;
                $group = mysql_fetch_array(mysql_query("SELECT * FROM `bol_group` WHERE `id` = '".mysql_real_escape_string($user['boloto_groups'])."'"));
                $per_gro = mysql_fetch_array(mysql_query("SELECT * FROM `bol_group` WHERE `id` = '".mysql_real_escape_string($id)."'"));
                $mol4 = $time + 5000;
                if ($group['p1'] != 0) {
                    //mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".mysql_real_escape_string($group['p1'])."','Заклинание молчания',".(time()+5000).",'2');");
                    if (mysql_fetch_array(mysql_query("SELECT `bol_status` FROM `users` WHERE `id` = '".mysql_real_escape_string($group['p1'])."' AND `bol_status`='1'"))){
                        $i1=1;
                    } else {
                        $i1=0;
                    }
                } else {
                  $i1=1;
                }
                if ($group['p2'] != 0) {
                    //mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".mysql_real_escape_string($group['p2'])."','Заклинание молчания',".(time()+5000).",'2');");
                    if (mysql_fetch_array(mysql_query("SELECT `bol_status` FROM `users` WHERE `id` = '".mysql_real_escape_string($group['p2'])."' AND `bol_status`='1'"))) {
                        $i2=1;
                    } else {
                        $i2=0;
                    }
                } else {
                    $i2=1;
                }
                if ($group['p3'] != 0) {
                    //mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".mysql_real_escape_string($group['p3'])."','Заклинание молчания',".(time()+5000).",'2');");
                    if (mysql_fetch_array(mysql_query("SELECT `bol_status` FROM `users` WHERE `id` = '".mysql_real_escape_string($group['p3'])."' AND `bol_status`='1'"))) {
                        $i3=1;
                    } else {
                        $i3=0;
                    }
                } else {
                    $i3=1;
                }
                if ($group['p4'] != 0) {
                    //mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".mysql_real_escape_string($group['p4'])."','Заклинание молчания',".(time()+5000).",'2');");
                    if (mysql_fetch_array(mysql_query("SELECT `bol_status` FROM `users` WHERE `id` = '".mysql_real_escape_string($group['p4'])."' AND `bol_status`='1'"))) {
                        $i4=1;
                    } else {
                        $i4=0;
                    }
                } else {
                    $i4=1;
                }
                if ($i1 == 1 && $i2 == 1 && $i3 == 1 && $i4 == 1) {
                    mysql_query("UPDATE `users` set `room`='2001', `bol_poxod`=`bol_poxod`+'1' WHERE `id` = '".mysql_real_escape_string($per_gro['p1'])."' or `id` = '".mysql_real_escape_string($per_gro['p2'])."' or `id` = '".mysql_real_escape_string($per_gro['p3'])."' or `id` = '".mysql_real_escape_string($per_gro['p4'])."'");
                    mysql_query("UPDATE `bol_group` set `status`='1',`game_time`='".(time()+4800)."' where `id` = '".mysql_real_escape_string($id)."'");
                    mysql_query("insert into `vault_res` (`id`) VALUES ('".mysql_real_escape_string($user['boloto_groups'])."')");
                    echo"Проход открылся - можете идти!";
                    die("<script>location='trjasina.php'</script>");
                } else {
                    echo"<font color=red><b>Необходимо, чтобы все игроки группы были в статусе \"ГОТОВ\"!</b></font><BR>";
                }
            }

            ///Создаем группу
            if ($_POST['new']) {
                if ($user['money'] >= 40) {
                    $lider = $_POST['lider'];
                    $pass = $_POST['pass'];
                    $comm = $_POST['komm'];
                    $name = mysql_fetch_array(mysql_query("SELECT `login` FROM `users` WHERE `id` = '".mysql_real_escape_string($lider)."' LIMIT 1;"));
                    mysql_query("INSERT INTO `bol_group` (`pass`,`lider`,`p1`,`comment`,`lider_nik`,`p1_nik`,`level`) VALUES ('".mysql_real_escape_string($pass)."','".mysql_real_escape_string($lider)."','".mysql_real_escape_string($lider)."','".mysql_real_escape_string($comm)."','".mysql_real_escape_string($name['login'])."','".mysql_real_escape_string($name['login'])."','".mysql_real_escape_string($user['level'])."')");
                    $id_group = mysql_result(mysql_query("SELECT MAX(id) FROM `bol_group` WHERE `lider` = '".mysql_real_escape_string($user['id'])."'"),0);
                    mysql_query("UPDATE `users` SET `boloto_groups`='".mysql_real_escape_string($id_group)."',`money`=`money`-'40',`bol_status`='1' WHERE `id`='".mysql_real_escape_string($user['id'])."'");
                    mysql_query("insert into `vault_user_navig` (`group_id`,`login`,`l`,`t`,`loc`) VALUES ('".mysql_real_escape_string($id_group)."','".$user['login']."','100','100','2001') ");
                    echo"Вы успешно создали группу!<br>";
                    echo"<script>location='trjasina_vxod.php'</script>";
                } else {
                  echo"<font color=red><b>У вас нет 40 Кр. для создания группы!</b></font>";
                }
            }
            echo"<br>Доступные для вступления группы:<br>";
            $data = mysql_query("SELECT * FROM `bol_group` where `status`='0' AND `level`='".$user['level']."'");
            $chislo = mysql_num_rows($data);
            if ($chislo > 0) {
                while($row = mysql_fetch_array($data)) {
                    echo"№<b>".$row['id']."</b> ";
                    $QUER=mysql_query("SELECT `login`,`level`,`bol_status` FROM `users` WHERE `boloto_groups`='".mysql_real_escape_string($row['id'])."' ORDER BY `id` ASC");
                    while($DATAS=mysql_fetch_array($QUER)) {
                        $bf = $row['id'];
                        $p1=$DATAS["login"];
                        $p_login=$DATAS["login"];
                        $p_lvl=$DATAS["level"];
                        $status=$DATAS["bol_status"];
                        if($status == 1){$st="<small>[<font color=green>ok</font>]</small>";}
                        else{$st="<small>[<font color=red>afk</font>]</small>";}
                        if($p1!=""){
                            $p1="$st <b>$p1</b> [$p_lvl]<a href='inf.php?login=$p1' target='_blank'><img src='i/inf.gif' border=0></a> ";
                            if($t1_all[$n]==1){print "$p1";}else{print "$p1,";}
                        }
                    }
                    if (!empty($row[comment])){print"| [<small>$row[comment]</small>] </font>";}
                    if ($user['boloto_groups'] == 0) {
                        echo"<form action='trjasina_vxod.php' method=post>";
                        if (!empty($row[pass])){print"<input name='naw_pass' type='hidden' value='$row[pass]'><INPUT type='password' name='pass' maxlength=6 size=7>";}
                        echo "
                            <input name='naw_id' type='hidden' value='$bf'>
                            <input  name='lvl' type='hidden' value='$row[level]'>
                            <input  name='add_id' type='hidden' value='$user[id]'>
                            <INPUT  TYPE=submit name=add value='Вступить!'></FORM>
                        ";
                    }
                    echo"<br>";
                }
            } else {
                echo"<b>Нет ни одной подходящей Вам группы!</b>";
            }
            echo"<P>";
            if ($user['boloto_groups'] == 0){
            echo "
                <hr><table align=left><td align=center><b>Создать свою группу!</b><br><em>Если пароль не нужен, оставьте поле пустым!</em></td><tr>
                <td align=left><form action='trjasina_vxod.php' method=post>
                <input type=hidden name=lider value=".$user['id'].">
                <input type=password name=pass maxlength=6 size=22>&nbsp;Пароль<br>
                <input type=text name=komm maxlength=20 size=22>&nbsp;Комментарий<br>
                <input class=input type=submit name=new value='Создать группу за 40 кр.'></form>
                </td></tr></table>
            ";
            } else {
                echo"<HR>Вы уже состоите в группе №<b>".$user['boloto_groups']."</b> !<HR>";
                echo"<form action='trjasina_vxod.php' method=post>";
                $vibor = mysql_fetch_array(mysql_query("SELECT `lider` FROM `bol_group` WHERE `id` = '".mysql_real_escape_string($user['boloto_groups'])."'"));
            if ($user['id'] == $vibor['lider']) {
                echo"<input type=hidden name=id value=".$user['boloto_groups']."><input type=hidden name=kto value=".$user['id']."><input class=input type=submit name=closed value='Расформировать группу!'>";
                echo"<input class=input type=submit name=start value='ПОЕХАЛИ!'>";
            } else{
                echo"<input type=hidden name=id value=".$user['boloto_groups']."><input type=hidden name=kto value=".$user['id']."><input class=input type=submit name=exit value='Покинуть группу!'>";
            }
            if($user['bol_status'] == 1) {
                echo"<input class=input type=submit name=afk value='Статус: Отошел'>";
            } elseif($user['bol_status'] == 0) {
                echo"<input class=input type=submit name=ready value='Статус: Я ГОТОВ'>";
            }
                echo"</FORM>";
            }
        } else {
            echo"<center><font color=red><b>Проход открыт лишь раз в 5 часов!</b></font></center>";
            if ($user['anti_boloto']>$now) {
                echo "
                    <table cellspacing=0 cellpadding=3 align=center>
                    <td><font color=black><b><small>До следущего похода: </small></b></font></td>
                    <td id=gametime style='COLOR: blue; size: 1;'></td>
                    </table>
                    <script>ShowTime('gametime',",$user['anti_boloto']-$now,",0);</script>
                ";
            }
        }
    } else {
        echo"<center><font color=red><b>С травмами и действующими элексирами сюда заходить нельзя!</b></font></center>";
    }
//    } else {
//      echo"<center><font color=red><b>Необходимо купить и одеть болотные сапоги!</b></font></center>";
//    }
} else {
    echo"<center><font color=red><b>Доступ сюда только с 7 уровня!</b></font></center>";
}
?>

</div>

</body>

</html>
<?php

session_start();
if ($_SESSION['uid'] == null) header("Location: index.php");
include "connect.php";
include "functions.php";
if ($user['battle'] != 0) { 
    header('location: fbattle.php'); 
    die(); 
}

// подача заявления
if (isset($_GET['groom']) && isset($_GET['bride'])) {
    // должны быть введены
    if (trim($_GET['groom']) && trim($_GET['bride'])) {
        $groom = mysql_fetch_array(mysql_query("SELECT `id`,`align`,`married`,`sex`,`login` FROM `users` WHERE `login` = '" . mysql_real_escape_string(trim($_GET['groom'])) . "' LIMIT 1;"));
        $bride = mysql_fetch_array(mysql_query("SELECT `id`,`align`,`married`,`sex`,`login` FROM `users` WHERE `login` = '" . mysql_real_escape_string(trim($_GET['bride'])) . "' LIMIT 1;"));
        if (!$groom['id'] || !$bride['id']) { // должны существовать
            $_msg = 'Персонаж "' . htmlspecialchars($_GET['groom']) . '" или "' . htmlspecialchars($_GET['bride']) . '" не существует!';
        } elseif ($user['id'] != $groom['id'] && $user['id'] != $bride['id']) { // подающий заявку должен быть женихом или невестой
            $_msg = 'Вы не имеете права подавать заявку за других игроков';
        } elseif ($groom['id'] == $bride['id']) { // невеста и жених не один человек
            $_msg = 'Не шутите так';
        } elseif ($groom['sex'] != 1) {
            $_msg = 'Неправильный пол жениха!';
        } elseif ($bride['sex'] != 0) {
            $_msg = 'Неправильный пол невесты!';
        } elseif ($groom['married']) {
            $_msg = 'Персонаж "' . $groom['login'] . '" уже состоит в браке!';
        } elseif ($bride['married']) {
            $_msg = 'Персонаж "' . $bride['login'] . '" уже состоит в браке!';
        } elseif (mysql_result(mysql_query('SELECT COUNT(*) FROM church WHERE groom = ' . $groom['id']), 0, 0) || mysql_result(mysql_query('SELECT COUNT(*) FROM church WHERE bride = ' . $bride['id']), 0, 0)) {
            $_msg = 'Нельзя подавать более одного заявления';
        } elseif ($bride['login'] == 'Demian Black') {
            $_msg = 'С данным персонажем брак запрещен';
        } else {
            mysql_query("INSERT INTO church SET groom = $groom[id], bride = $bride[id], status = $user[sex], date = " . strtotime("+30 day") . ", added = " . time()) or die(mysql_error());
            $_msg = 'Заявление успешно подано.<br />Персонаж "' . ($user['sex'] ? $bride['login'] : $groom['login']) . '" ' . ($user['sex'] ? 'должна' : 'должен') . ' подтвердить подачу заявления, иначе оно будет аннулировано в течении 3-ех дней';
        }
    } else {
        $_msg = 'Не введены данные Женихи или Невесты'; 
    }
}

if (isset($_GET['action']) && isset($_GET['pair'])) {
    $pair = mysql_fetch_assoc(mysql_query("SELECT * FROM church WHERE id = " . mysql_real_escape_string($_GET['pair'])));
    if ($pair) {
        if ($_GET['action'] == 'confirm') {
            if ($pair['status']) {
                $i = 'bride';
            } else {
                $i = 'groom';
            }
            if ($user['id'] == $pair[$i]) {
                mysql_query('UPDATE church SET status = 2 WHERE id = ' . mysql_real_escape_string($_GET['pair']));
                $_msg = 'Вы успешно подтвердили заявление';
            } else {
                $_msg = 'Вы не имеете права подтверждать заявку за других игроков';
            }
        } elseif ($_GET['action'] == 'delete') {
            if ($user['id'] == $pair['groom'] || $user['id'] == $pair['bride']) {
                mysql_query('DELETE FROM church WHERE id = ' . mysql_real_escape_string($_GET['pair']));
                $_msg = 'Вы успешно отменили заявление';
            } else {
                $_msg = 'Вы не имеете права отменять заявку за других игроков';
            }
        }
    } else {
        $_msg = 'Заявка не найдена';
    }
}

$wList = mqfaa("SELECT * FROM church WHERE status < 2");
$mList = mqfaa("SELECT * FROM church WHERE status = 2");

?>

<html>
    
<head>

    <link rel=stylesheet type="text/css" href="/i/main.css">
    <meta content="text/html; charset=windows-1251" http-equiv=Content-type>
    <meta Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
    <meta http-equiv=PRAGMA content=NO-CACHE>
    <meta Http-Equiv=Expires Content=0>
    <style style="text/css">
        p, #table *, input {
            font-size: 9pt;
        }
        #table {
            border-collapse:collapse;
        }
        #table, #table td, #table th {
            border:1px solid #7F7F7F;
        }
        #table td, #table th {
            padding: 0.3em;
            text-align: center;
        }
        h4 {
            text-align: left;
            margin-top: 0px;
        }
        div {
            margin-bottom: 2em;
        }
    </style>
    
</head>

<body bgcolor=e2e0e0 style="background-image: url(i/misc/church.png);background-repeat:no-repeat;background-position:top right"> 
    
<table border=0 width=100% cellspacing="0" cellpadding="0">
        <TR>
            <TD valign=top width=100%>
                <center>
                    <h3>Церковь.</h3>
                    <p style="padding: 0px 18em;margin:0px;"><marquee scrollamount="2" scrolldelay="10" direction="left">Услуги священника платные   <img src="i/magic/marry.gif"> Брак 100 кр., развод <img src="i/magic/unmarry.gif"> 200 кр.</marquee></p>
                    <p>&nbsp;</p>
                </center>
            </TD>
            <TD nowrap valign=top>
                <DIV align=right>
                    <INPUT style="font-size:12px;" type='button' onClick="location='church.php'" value="Обновить">
                    <input style="font-size:12px;" type='button' onClick="location='city.php?cp=1'" value="Вернуться">
                    <p>
                        <input type="button" onclick="alert('Будет открыт в ближайшее время');return false;" value="Свадебный магазин" /><br />
                        <input type="button" onclick="alert('В данный момент бракосочетание не производится');return false;" value="Зал Бракосочетаний" />
                    </p>
                </DIV>
            </TD>
        </TR>
</table>

<?php if (isset($_msg) && $_msg) { ?>
<p style="text-align: center; color:red"><strong><?php echo $_msg; ?></strong></p>
<?php } ?>

<div style="float: right;">
    <h4 style="text-align: right;">Подача заявления на венчание</h4>
    <form action="" method="GET">
        <p style="text-align: right;">
            Логин Жениха:&nbsp;<input size="18" type="text" name="groom" value="" /><br />
            Логин Невесты:&nbsp;<input size="18" type="text" name="bride" value="" />
        </p>
        <p style="text-align: right;"><input type="submit" value="подать заявление" /></p>
    </form>
</div>
<div style="float: left;">
    <div>
        <h4>Заявления ожидающие подтверждения</h4>
        <?php if ($wList) { ?>
            <table id="table">
                <tr>
                    <th style="">Жених</th>
                    <th>Невеста</th>
                    <th>Статус</th>
                </tr>
                <?php foreach ($wList as $w) { ?>
                    <tr>
                        <td><?php echo nick3($w['groom']) ?></td>
                        <td><?php echo nick3($w['bride']) ?></td>
                        <td>
                            <input type="button" onclick="location='?action=confirm&pair=<?php echo $w['id'] ?>'" value="подтверждение от <?php echo ($w['status'] ? 'невесты' : 'жениха') ?>" />
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else {  ?>
            <p>список пуст</p>
        <?php } ?>
    </div>

    <div>
        <h4>Список церемоний венчания в церкви</h4>
        <?php if ($mList) { ?>
            <table id="table">
                <tr>
                    <th style="">Жених</th>
                    <th>Невеста</th>
                    <th>Дата</th>
                    <th></th>
                </tr>
                <?php foreach ($mList as $m) { ?>
                    <tr>
                        <td><?php echo nick3($m['groom']) ?></td>
                        <td><?php echo nick3($m['bride']) ?></td>
                        <td><?php echo date('d.m.Y', $m['date']) ?></td>
                        <td><input type="button" onclick="location='?action=delete&pair=<?php echo $m['id'] ?>'" value="отменить" /></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else {  ?>
            <p>список пуст</p>
        <?php } ?>
    </div>
</div>

</body>

</html>

<?php

session_start();
if ($_SESSION['uid'] == null) header("Location: index.php");
include "connect.php";
include "functions.php";
if ($user['battle'] != 0) { 
    header('location: fbattle.php'); 
    die(); 
}

// ������ ���������
if (isset($_GET['groom']) && isset($_GET['bride'])) {
    // ������ ���� �������
    if (trim($_GET['groom']) && trim($_GET['bride'])) {
        $groom = mysql_fetch_array(mysql_query("SELECT `id`,`align`,`married`,`sex`,`login` FROM `users` WHERE `login` = '" . mysql_real_escape_string(trim($_GET['groom'])) . "' LIMIT 1;"));
        $bride = mysql_fetch_array(mysql_query("SELECT `id`,`align`,`married`,`sex`,`login` FROM `users` WHERE `login` = '" . mysql_real_escape_string(trim($_GET['bride'])) . "' LIMIT 1;"));
        if (!$groom['id'] || !$bride['id']) { // ������ ������������
            $_msg = '�������� "' . htmlspecialchars($_GET['groom']) . '" ��� "' . htmlspecialchars($_GET['bride']) . '" �� ����������!';
        } elseif ($user['id'] != $groom['id'] && $user['id'] != $bride['id']) { // �������� ������ ������ ���� ������� ��� ��������
            $_msg = '�� �� ������ ����� �������� ������ �� ������ �������';
        } elseif ($groom['id'] == $bride['id']) { // ������� � ����� �� ���� �������
            $_msg = '�� ������ ���';
        } elseif ($groom['sex'] != 1) {
            $_msg = '������������ ��� ������!';
        } elseif ($bride['sex'] != 0) {
            $_msg = '������������ ��� �������!';
        } elseif ($groom['married']) {
            $_msg = '�������� "' . $groom['login'] . '" ��� ������� � �����!';
        } elseif ($bride['married']) {
            $_msg = '�������� "' . $bride['login'] . '" ��� ������� � �����!';
        } elseif (mysql_result(mysql_query('SELECT COUNT(*) FROM church WHERE groom = ' . $groom['id']), 0, 0) || mysql_result(mysql_query('SELECT COUNT(*) FROM church WHERE bride = ' . $bride['id']), 0, 0)) {
            $_msg = '������ �������� ����� ������ ���������';
        } elseif ($bride['login'] == 'Demian Black') {
            $_msg = '� ������ ���������� ���� ��������';
        } else {
            mysql_query("INSERT INTO church SET groom = $groom[id], bride = $bride[id], status = $user[sex], date = " . strtotime("+30 day") . ", added = " . time()) or die(mysql_error());
            $_msg = '��������� ������� ������.<br />�������� "' . ($user['sex'] ? $bride['login'] : $groom['login']) . '" ' . ($user['sex'] ? '������' : '������') . ' ����������� ������ ���������, ����� ��� ����� ������������ � ������� 3-�� ����';
        }
    } else {
        $_msg = '�� ������� ������ ������ ��� �������'; 
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
                $_msg = '�� ������� ����������� ���������';
            } else {
                $_msg = '�� �� ������ ����� ������������ ������ �� ������ �������';
            }
        } elseif ($_GET['action'] == 'delete') {
            if ($user['id'] == $pair['groom'] || $user['id'] == $pair['bride']) {
                mysql_query('DELETE FROM church WHERE id = ' . mysql_real_escape_string($_GET['pair']));
                $_msg = '�� ������� �������� ���������';
            } else {
                $_msg = '�� �� ������ ����� �������� ������ �� ������ �������';
            }
        }
    } else {
        $_msg = '������ �� �������';
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
                    <h3>�������.</h3>
                    <p style="padding: 0px 18em;margin:0px;"><marquee scrollamount="2" scrolldelay="10" direction="left">������ ���������� �������   <img src="i/magic/marry.gif"> ���� 100 ��., ������ <img src="i/magic/unmarry.gif"> 200 ��.</marquee></p>
                    <p>&nbsp;</p>
                </center>
            </TD>
            <TD nowrap valign=top>
                <DIV align=right>
                    <INPUT style="font-size:12px;" type='button' onClick="location='church.php'" value="��������">
                    <input style="font-size:12px;" type='button' onClick="location='city.php?cp=1'" value="���������">
                    <p>
                        <input type="button" onclick="alert('����� ������ � ��������� �����');return false;" value="��������� �������" /><br />
                        <input type="button" onclick="alert('� ������ ������ �������������� �� ������������');return false;" value="��� ��������������" />
                    </p>
                </DIV>
            </TD>
        </TR>
</table>

<?php if (isset($_msg) && $_msg) { ?>
<p style="text-align: center; color:red"><strong><?php echo $_msg; ?></strong></p>
<?php } ?>

<div style="float: right;">
    <h4 style="text-align: right;">������ ��������� �� ��������</h4>
    <form action="" method="GET">
        <p style="text-align: right;">
            ����� ������:&nbsp;<input size="18" type="text" name="groom" value="" /><br />
            ����� �������:&nbsp;<input size="18" type="text" name="bride" value="" />
        </p>
        <p style="text-align: right;"><input type="submit" value="������ ���������" /></p>
    </form>
</div>
<div style="float: left;">
    <div>
        <h4>��������� ��������� �������������</h4>
        <?php if ($wList) { ?>
            <table id="table">
                <tr>
                    <th style="">�����</th>
                    <th>�������</th>
                    <th>������</th>
                </tr>
                <?php foreach ($wList as $w) { ?>
                    <tr>
                        <td><?php echo nick3($w['groom']) ?></td>
                        <td><?php echo nick3($w['bride']) ?></td>
                        <td>
                            <input type="button" onclick="location='?action=confirm&pair=<?php echo $w['id'] ?>'" value="������������� �� <?php echo ($w['status'] ? '�������' : '������') ?>" />
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else {  ?>
            <p>������ ����</p>
        <?php } ?>
    </div>

    <div>
        <h4>������ ��������� �������� � ������</h4>
        <?php if ($mList) { ?>
            <table id="table">
                <tr>
                    <th style="">�����</th>
                    <th>�������</th>
                    <th>����</th>
                    <th></th>
                </tr>
                <?php foreach ($mList as $m) { ?>
                    <tr>
                        <td><?php echo nick3($m['groom']) ?></td>
                        <td><?php echo nick3($m['bride']) ?></td>
                        <td><?php echo date('d.m.Y', $m['date']) ?></td>
                        <td><input type="button" onclick="location='?action=delete&pair=<?php echo $m['id'] ?>'" value="��������" /></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else {  ?>
            <p>������ ����</p>
        <?php } ?>
    </div>
</div>

</body>

</html>

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
        $name=str_replace(" (��)","",$name);
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
          mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" ������ � ������� �����: \"".$dress['name']."\" id:(cap".$dress['id'].") [".$dress['duration']."/".$dress['maxdur']."] �� ".$price." ���. ',1,'".time()."');");
          echo "<font color=red><b>�� ������� \"{$dress['name']}\" �� ".$price." ���.</b></font>";
        }
    }


    if (($_GET['set'] OR $_POST['set'])) {
        if ($_GET['set']) { $set = $_GET['set']; }
        if ($_POST['set']) { $set = $_POST['set']; }
        if (!$_POST['count']) { $_POST['count'] =1; } else $_POST['count']=(int)$_POST['count'];
        $dress = mysql_fetch_array(mysql_query("SELECT * FROM `berezka_ng` WHERE `id` = '{$set}' LIMIT 1;"));
        if (($dress['massa']*$_POST['count']+$d[0]) > (get_meshok())) {
            echo "<font color=red><b>������������ ����� � �������.</b></font>";
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
                echo "<font color=red><b>�� ������ {$_POST['count']} ��. \"".stripslashes($dress['name'])."\".</b></font>";
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
                mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" ����� �����: \"".$dress['name']."\" ".$dresscount."id:(".$dressid.") [0/".$dress['maxdur']."] �� ".$allcost." ���. ',1,'".time()."');");
            }
        }
        else {
            echo "<font color=red><b>������������ ����� ��� ��� ����� � �������.</b></font>";
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
    document.all("hint3").innerHTML = '<table border=0 width=100% cellspacing=1 cellpadding=0 bgcolor="#CCC3AA"><tr><td align=center><B>������ ����. ����</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</TD></tr><tr><td colspan=2>'+
    '<table border=0 width=100% cellspacing=0 cellpadding=0 bgcolor="#FFF6DD"><tr><INPUT TYPE="hidden" name="set" value="'+name+'"><td colspan=2 align=center><B><I>'+txt+'</td></tr><tr><td width=80% align=right>'+
    '���������� (��.) <INPUT TYPE="text" NAME="count" size=4></td><td width=20%>&nbsp;<INPUT TYPE="submit" value=" �� ">'+
    '</TD></TR></TABLE></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = event.x+document.body.scrollLeft-20;
    document.all("hint3").style.top = event.y+document.body.scrollTop+5;
    document.all("count").focus();
}
// ��������� ����
function closehint3()
{
    document.all("hint3").style.visibility="hidden";
}
</SCRIPT>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=#e0e0e0>
<TABLE border=0 width=100% cellspacing="0" cellpadding="0">
<tr><td><h3>���������� �������</td><td align=right>
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
<!--�������-->
<TABLE border=0 width=100% cellspacing="0" cellpadding="0" bgcolor="#A5A5A5">
<TR>
    <TD align=center><B>����� "<?php
    if ($_POST['sale']) {
        echo "������";
    } else
switch ($_GET['otdel']) {
    case null:
        echo "������: �������,����";
        $_GET['otdel'] = 1;
    break;
    case 1:
        echo "������: ����";
    break;

   case 11:
        echo "������: ������";
    break;

    case 12:
        echo "������: ������,������";
    break;

    case 13:
        echo "������: ����";
    break;

    case 14:
        echo "������: ���� � ��������";
    break;

    case 30:
        echo "������: ���������� ������";
    break;

    case 2:
        echo "������: ������";
    break;

    case 21:
        echo "������: ��������";
    break;

    case 22:
        echo "������: ������ �����";
    break;
    case 8:
        echo "������: �������, ��������";
    break;
    case 9:
        echo "������: �����, �������";
    break;
    case 23:
        echo "������: ������� �����";
    break;

    case 24:
        echo "������: �����";
    break;

    case 25:
        echo "������";
    break;

    case 26:
        echo "�����";
    break;

    case 27:
        echo "������";
    break;

    case 3:
        echo "����";
    break;

    case 4:
        echo "��������� ������: ������";
    break;

    case 41:
        echo "��������� ������: ��������";
    break;

    case 42:
        echo "��������� ������: ������";
    break;

    case 5:
        echo "����������: �����������";
    break;

    case 51:
        echo "����������: ������ � ��������";
    break;
    case 52:
        echo "������ �����";
    break;
    case 53:
        echo "����������: �������� ������";
    break;
    case 6:
        echo "��������";
    break;
        echo "��������: ��������";
    break;
    case 71:
        echo "��������: �������";
    break;
    case 72:
        echo "������� ����";
    break;
    case 73:
        echo "������������� ����";
    break;
}


    ?>"</B>

    </TD>
</TR>
<TR><TD><!--������-->
<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">
<?
if($_REQUEST['present']) {

    if($_POST['to_login'] && $_POST['flower']) {
        $to = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$_POST['to_login']}' LIMIT 1;"));
        $item=mqfa1("select owner from inventory where `id` = '".$_POST['flower']."' AND `owner` = '{$_SESSION['uid']}'");
        if (!$item) {
            echo "<b><font color=red>������� �� ������</font></b>";
        } elseif ($_POST['to_login'] == $user['login']) {
            echo "<b><font color=red>����� ����� ������ ���-�� ������ ���� ;)</font></b>";
        }
        elseif ($to['room'] > 500 && $to['room'] < 561) {
            echo "<b><font color=red>�������� � ������ ������ ��������� � ������� � ����� ������. ���������� �����.</font></b>";
        }
        else {

            if($_POST['from']==1) { $from = '������'; }
            elseif($_POST['from']==2 && $user['klan']) { $from = ' ����� '.$user['klan']; }
            else {$from = $user['login'];}
            if ($to) if(mysql_query("UPDATE `inventory` SET `owner` = '".$to['id']."', `present` = '".$from."', `letter` = '".$_POST['podarok2']."' WHERE  `present` = '' AND `id` = '".$_POST['flower']."' AND `owner` = '{$_SESSION['uid']}' AND `dressed` = 0  AND `setsale`=0")) {
                $res = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$_POST['flower']}' LIMIT 1; "));
                $buket_name=$res['name'];
                mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','������� ������� \"".$res['name']."\" id:(cap".$res['id'].") [".$res['duration']."/".$res['maxdur']."] �� \"".$from."\" � \"".$to['login']."\"','1','".time()."');");
                mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$to['id']}','������� ������� \"".$res['name']."\" id:(cap".$res['id'].") [".$res['duration']."/".$res['maxdur']."] �� \"".$from."\" � \"".$to['login']."\"','1','".time()."');");
                if(($_POST['from']==1) || ($_POST['from']==2)) {
                    $action="�������";
                    mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$to['id']}','������� ������� \"".$res['name']."\" id:(cap".$res['id'].") [".$res['duration']."/".$res['maxdur']."] �� \"".$user['login']."\" � \"".$to['login']."\"','5','".time()."');");
                }
                else {
                    if ($user['sex'] == 0) {$action="��������";}
                    else {$action="�������";}
                }
                $us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$to['id']}' LIMIT 1;"));
                if($us[0]){
                    addchp ('<font color=red>��������!</font> <span oncontextmenu=OpenMenu()>'.$from.'</span> '.$action.' ��� <B>'.$buket_name.'</B>.   ','{[]}'.$_POST['to_login'].'{[]}');
                } else {
                    // ���� � ���
                    mysql_query("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$to['id']."','','".'<font color=red>��������!</font> <span oncontextmenu=OpenMenu()>'.$from.'</span> '.$action.' ��� <B>'.$buket_name.'</B>.   '."');");
                }
                echo "<b><font color=red>������� ������ ��������� � \"",$_POST['to_login'],"\"</font></b>";
            }
            echo mysql_error();
        }
    }

        ?>

<!-- �������� ������� -->
<form method="post">
<TABLE cellspacing=0 cellpadding=0 width=100% bgcolor=#e0e0e2><TD>
<INPUT TYPE=hidden name=present value=1>
�� ������ ������� ������� �������� ��������. ��� ������� ����� ������������ � ���������� � ���������.
<OL>
<LI>������� ����� ���������, �������� ������ ������� �������<BR>
Login <INPUT TYPE=text NAME=to_login value="">
<LI>���� �������. ����� ������������ � ���������� � ��������� (�� ����� 60 ��������)<BR>
<INPUT TYPE=text NAME=podarok2 value="" maxlength=60 size=50>
<LI>�������� ����� ���������������� ������� (� ���������� � ��������� �� ������������)<BR>
<TEXTAREA NAME=txt ROWS=6 COLS=80></TEXTAREA>
<LI>��������, �� ����� ����� �������:<BR>
<INPUT TYPE=radio NAME=from value=0 checked> <? nick2($user['id']);?><BR>
<INPUT TYPE=radio NAME=from value=1 > ��������<BR>
<INPUT TYPE=radio NAME=from value=2 > �� ����� �����<BR>
<LI>������� ������ <B>��������</B> ��� ���������, ������� ������ ����������� � �������:<BR>
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
            <BR><input type="submit" onclick="document.all['flower'].value='<?=$row['id']?>';" value="��������">
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
        <!--<BR><A HREF="berezkang.php?sed=<?=$row['id']?>&sid=&sale=1">������� �� <?=round($price-$row['duration']*($row['ecost']/($row['maxdur']*10)),2)?></A>-->
            <BR><A HREF="berezkang.php?sed=<?=$row['id']?>&sid=&sale=1">������� �� <?=floor($row['ecost']*SELLCOEF*(($row["maxdur"]-$row["duration"])/$row["maxdur"])*10)/10?> ���</A>

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
        <BR><A HREF="berezkang.php?otdel=<?=$_GET['otdel']?>&set=<?=$row['id']?>&sid=">������</A>
        <IMG SRC="<?=IMGBASE?>/i/up.gif" WIDTH=11 HEIGHT=11 BORDER=0 ALT="������ ��������� ����" style="cursor:hand" onClick="AddCount('<?=$row['id']?>', '<?=$row['name']?>')"></TD>
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
      echo "�� ������ ���������� ����� ���� �� ������������ ������ � ����� ��� ������� ������������� � ��������� �� ������ ������. ���-�� �� ��������� ����� ���� � �������������� �� �� ����� ��������, � � �� �������� �������� �� ������ �������. ��� ���� ����� �������� ������������ ����.
      ����� ������������ �����-���� ������ �������� ��������� ����� �� ������ �� ������.<br>";
      $d=opendir("i/sh/nameditems");
      while ($f=readdir($d)) {
        if ($f=="." || $f=="..") continue;
        echo "<img src=\"".IMGBASE."/i/sh/nameditems/$f\">";
      }
    }
?>
    </TD>
    <TD valign=top width=280>

    <CENTER><B>����� ���� ����� �����: <?php


    echo $d[0];
    ?>/<?=get_meshok()?><BR>
    � ��� � �������: <FONT COLOR="#339900"><?=$user8['ekr']?></FONT> ���.</B></CENTER>
    <div style="MARGIN-LEFT:15px; MARGIN-TOP: 10px;">

    <!--<INPUT TYPE="submit" value="������� ����" name="sale"><BR>-->

<div style="background-color:#d2d0d0;padding:1"><center><font color="#oooo"><B>������ ��������</B></center></div>
<?
  function shoplink($otdel, $name, $caption=0) {
    return "<A HREF=\"berezkang.php?otdel=$otdel\">".($otdel==$_GET["otdel"]?"<DIV style='background-color: #C7C7C7'>":"").($caption?"":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;").$name.($otdel==$_GET["otdel"]?"</div></a>":"</a><br>")."";
  }
  echo shoplink(1, "����",1);
  //echo shoplink(11, "������");
  //echo shoplink(12, "������,������");
  //echo shoplink(13, "����");
  //echo shoplink(30, "���������� ������");
  //echo shoplink(14, "���� � ��������");
  echo shoplink(2, "C�����", 1);
  echo shoplink(21, "��������");
  //echo shoplink(8, "�������, ��������");
  echo shoplink(9, "�������");
  //echo shoplink(22, "������ �����");
  //echo shoplink(23, "������� �����");
  echo shoplink(24, "�����");
  //echo shoplink(25, "������");
  //echo shoplink(26, "�����");
  //echo shoplink(27, "������");
  //echo shoplink(3, "����", 1);
  //echo shoplink(4, "��������� ������: ������", 1);
  //echo shoplink(41, "��������");
  //echo shoplink(42, "������");
  //echo shoplink(5, "����������: �����������", 1);
  //echo shoplink(51, "������ � ��������");
  //echo shoplink(53, "�������� ������");
  //echo shoplink(52, "������ �����", 1);
  /*echo shoplink(6, "��������", 1);
  //echo shoplink(188, "��������");
  echo shoplink(7, "��������",);*/
  echo shoplink(71, "��������: �������", 1);
  //echo shoplink(73, "������������� ����", 1);
  //echo shoplink(72, "������� ����", 1);
?>
<!--<A HREF="shop.php?present=1">������� �������</A><BR>-->
<?
  //echo shoplink(50, "���", 1);
  //echo shoplink(52, "������ �����", 1);
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
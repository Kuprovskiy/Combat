<?php
    session_start();
    if ($_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
    include "functions.php";
if ($_GET['naz']) {
            mysql_query("UPDATE `users`,`online` SET `users`.`room` = '403',`online`.`room` = '403' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
mysql_query("UPDATE `labirint` SET `location` = '28',`l`='478',`t`='214' WHERE `user_id` = '{$_SESSION['uid']}'");
print "<script>location.href='canalizaciya.php'</script>";
exit;
            }

    $d = mysql_fetch_array(mysql_query("SELECT sum(`massa`) FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `setsale` = 0 ; "));
    if ($user['room'] != 404) { header("Location: main.php");  die(); }
    if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }




    if (($_GET['set'] OR $_POST['set'])) {
        if ($_GET['set']) { $set = $_GET['set']; }
        if ($_POST['set']) { $set = $_POST['set']; }
        $zrec=mqfa("select zeton, goldzeton, silverzeton from shop_luka where id='$set'");
        if ($zrec["zeton"]) {$zetonname="�����";$zetonfield="zeton";}
        if ($zrec["silverzeton"]) {$zetonname="���������� �����";$zetonfield="silverzeton";}
        if ($zrec["goldzeton"]) {$zetonname="������� �����";$zetonfield="goldzeton";}
        if (!$_POST['count']) { $_POST['count'] =1; }
$vear = mysql_query("SELECT koll,id FROM `inventory` WHERE `type`='200' and `name`='$zetonname' and owner='".$user["id"]."'");
 while($vls = mysql_fetch_array($vear))
{
      $zetons += $vls['koll'];
      $vls_id = $vls['id'];
}

        $dress = mysql_fetch_array(mysql_query("SELECT * FROM `shop_luka` WHERE `id` = '{$set}' LIMIT 1;"));
        if (($dress['massa']*$_POST['count']+$d[0]) > (get_meshok())) {
            echo "<font color=red><b>������������ ����� � �������.</b></font>";
        }
        elseif(($zetons >= ($dress[$zetonfield]*$_POST['count'])) && ($dress['count'] >= $_POST['count'])) {

            for($k=1;$k<=$_POST['count'];$k++) {
                if(takelukaitem($set)
                /*mysql_query("INSERT INTO `inventory`
                (`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`isrep`,
                    `gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
                    `mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`gmp`,`gmeshok`,`podzem`,`dvur`,`second`, gmana
                )
                VALUES
                ('{$dress['id']}','{$_SESSION['uid']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},0.00,'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
                '{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}','{$dress['razdel']}','{$dress['gmp']}','{$dress['gmeshok']}','1','{$dress['dvur']}','{$dress['second']}','{$dress['gmana']}'
                ) ;")*/)
                {
                  checkitemchange(array("prototype"=>$set));
                  $good = 1;
                }
                else {
                    $good = 0;
                }
            }
            if ($good) {
                mysql_query("UPDATE `shop_luka` SET `count`=`count`-{$_POST['count']} WHERE `id` = '{$set}' LIMIT 1;");
                echo "<font color=red><b>�� ������ {$_POST['count']} ��. \"{$dress['name']}\".</b></font>";
            $vsego = $zetons-($_POST['count']*$dress[$zetonfield]);
if($vsego<='0'){
mysql_query("DELETE FROM `inventory` WHERE `type`='200' and `name`='$zetonname' and owner='".$user["id"]."'");
}else{
  takesmallitems($zetonname, $_POST['count']*$dress[$zetonfield], $user["id"]);
  //mysql_query("UPDATE `inventory` set `koll` = '$vsego' WHERE `type`='200' and `name`='$zetonname' and owner='".$user["id"]."'");
}


                $zetons -= $_POST['count']*$dress[$zetonfield];
                $limit=$_POST['count'];
                $invdb = mysql_query("SELECT `id` FROM `inventory` WHERE `name` = '".$dress['name']."' ORDER by `id` DESC LIMIT ".$limit." ;" );
                //$invdb = mysql_query("SELECT id FROM `inventory` WHERE `name` = '".{$dress['name']}."' ORDER by `id` DESC LIMIT $limit ;" );
                if ($limit == 1) {
                    $dressinv = mysql_fetch_array($invdb);
                    $dressid = "cap".$dressinv['id'];
                    $dresscount=" ";
                } else {
                    $dressid="";
                    while ($dressinv = mysql_fetch_array($invdb))  {
                        $dressid .= "cap".$dressinv['id'].",";
                    }
                    $dresscount="(x".$_POST['count'].") ";
                }
                $allcost=$_POST['count']*$dress[$zetonfield];
                mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" ����� �����: \"".$dress['name']."\" ".$dresscount."id:(".$dressid.") [0/".$dress['maxdur']."] �� ".$allcost." $zetonname. ',1,'".time()."');");
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
<FORM action="shop_luka.php" method=GET>
<tr><td><h3>������� ����</td><td align=right>
<INPUT TYPE="button" value="���������" style="background-color:#A9AFC0" onClick="window.open('help/shop.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">
<INPUT TYPE="submit" value="���������" name="naz"></td></tr>
</FORM>
</table>
<TABLE border=0 width=100% cellspacing="0" cellpadding="4">
<TR>
    <FORM METHOD=POST ACTION="shop_luka.php">
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
        echo "������: �������,����";
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
    case 8:
        echo "������: �������, ��������";
    break;
    case 9:
        echo "������: �����, �������";
    break;
    case 21:
        echo "������: ��������";
    break;

    case 22:
        echo "&������: ������ �����";
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
    case 6:
        echo "��������";
    break;

}


    ?>"</B>

    </TD>
</TR>
<TR><TD><!--������-->
<TABLE BORDER=1 WIDTH=100% CELLSPACING="0" CELLPADDING="0" BGCOLOR="#A5A5A5">
<?
    $data = mysql_query("SELECT * FROM `shop_luka` WHERE `count` > 0 AND `razdel` = '{$_GET['otdel']}' AND (`zeton` != '0' or `silverzeton` != '0' or `goldzeton` != '0')");
    while($row = mysql_fetch_array($data)) {
        if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
        echo "<TR bordercolor='#000000' bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"".IMGBASE."/i/sh/{$row['img']}\" BORDER=0>";
        ?>
        <BR><A HREF="shop_luka.php?otdel=<?=$_GET['otdel']?>&set=<?=$row['id']?>&sid=">������</A>
        <IMG SRC="<?=IMGBASE?>/i/up.gif" WIDTH=11 HEIGHT=11 BORDER=0 ALT="������ ��������� ����" style="cursor:hand" onClick="AddCount('<?=$row['id']?>', '<?=$row['name']?>')"></TD>
        <?php
        echo "<TD valign=top style=\"padding-left:10px;padding-bottom:5px\">";
        showitem ($row);
        echo "</TD></TR>";
    }

?>
</TABLE>
</TD></TR>
</TABLE>

    </TD>
    <TD valign=top width=280>

    <CENTER><B>����� ���� ����� �����: <?php
$vear = mysql_query("SELECT koll,id FROM `inventory` WHERE `type`='200' and `name`='�����' and owner='".$user["id"]."'");
 while($vls = mysql_fetch_array($vear))
{
      $zetons += $vls['koll'];
      $vls_id = $vls['id'];
}

    echo $d[0];
    ?>/<?=get_meshok()?><BR>

    <div style="MARGIN-LEFT:15px; MARGIN-TOP: 10px;">


<div style="background-color:#d2d0d0;padding:1;"><center><font color="#oooo"><B>������ ��������</B></center></div>
<div style="text-align:left">
<A HREF="shop_luka.php?otdel=1&sid=&0.162486541405194">������: �������,����</A><BR>
<A HREF="shop_luka.php?otdel=11&sid=&0.337606814894404">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;������</A><BR>
<A HREF="shop_luka.php?otdel=12&sid=&0.286790872806733">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;������,������</A><BR>
<A HREF="shop_luka.php?otdel=13&sid=&0.0943516060419363">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;����</A><BR>
<A HREF="shop_luka.php?otdel=30&sid=&0.0943516060419363">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;���������� ������</A><BR>
<A HREF="shop_luka.php?otdel=2&sid=&0.76205958316951">������: ������</A><BR>
<A HREF="shop_luka.php?otdel=21&sid=&0.648260824682342">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��������</A><BR>
<A HREF="shop_luka.php?otdel=8&sid=&0.520447517792988">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�������, ��������</A><BR>
<A HREF="shop_luka.php?otdel=9&sid=&0.520447517792988">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�����, �������</A><BR>
<A HREF="shop_luka.php?otdel=22&sid=&0.520447517792988">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;������ �����</A><BR>
<A HREF="shop_luka.php?otdel=23&sid=&0.99133839275569">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;������� �����</A><BR>
<A HREF="shop_luka.php?otdel=24&sid=&0.567932791291376">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�����</A><BR>
<A HREF="shop_luka.php?otdel=25&sid=&0.567932791291376">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;������</A><BR>
<A HREF="shop_luka.php?otdel=26&sid=&0.567932791291376">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�����</A><BR>
<A HREF="shop_luka.php?otdel=27&sid=&0.567932791291376">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;������</A><BR>
<A HREF="shop_luka.php?otdel=3&sid=&0.725667864710179">����</A><BR>
<A HREF="shop_luka.php?otdel=4&sid=&0.321709306035984">��������� ������: ������</A><BR>
<A HREF="shop_luka.php?otdel=41&sid=&0.902093651333512">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��������</A><BR>
<A HREF="shop_luka.php?otdel=42&sid=&0.510210803380268">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;������</A><BR>
<A HREF="shop_luka.php?otdel=5&sid=&0.648834385828923">����������: �����������</A><BR>
<A HREF="shop_luka.php?otdel=51&sid=&0.722009624500359">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;������ � ��������</A><BR>
<A HREF="shop_luka.php?otdel=6&sid=&0.925798340638547">��������</A><BR>
</div>
    </div>
<div id="hint3" class="ahint"></div>
    </TD>
    </FORM>
</TR>
</TABLE>

</BODY>
</HTML>

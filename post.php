<?php
    session_start();
    if ($_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
    include "functions.php";
    if ($user['room'] != 27) { header("Location: main.php");  die(); }
    if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }
    $cond="AND `dressed` = 0 AND `dressed` = 0 AND `setsale` = 0 AND `present` = '' AND `destinyinv` = '' AND `artefact` = 0 AND `honor` =0 AND `podzem`=0 and type<>189 and type<>199 and type<>54";
?><HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<SCRIPT src='i/commoninf.js'></SCRIPT>
<SCRIPT>
var Hint3Name = '';
// ���������, �������� �������, ��� ���� � �������
function findlogin(title, script, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><form action="'+script+'" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"><td colspan=2>'+
    '������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD width=50% align=right><INPUT TYPE=text NAME="'+name+'"></TD><TD width=50%><INPUT TYPE="submit" value=" �� "></TD></TR></FORM></TABLE></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}


function returned2(s){
    if (top.oldlocation != '') { top.frames['main'].location=top.oldlocation+'?'+s+'tmp='+Math.random(); top.oldlocation=''; }
    else { top.frames['main'].location='main.php?edit='+Math.random() }
}
<?
$step=1;
if ($step==1) $idkomu=0;
?>
function closehint3(){
    document.all("hint3").style.visibility="hidden";
    Hint3Name='';
}


var transfersale = true;
<?


if (@!$_REQUEST['razdel']) { $_REQUEST['razdel']=1; }
if (@$_REQUEST['FindLogin']) {
    $res=mysql_fetch_array(mysql_query("SELECT `id`, `level`, `room`, `align`, (select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = users.`id`) as `online`,`login`,in_tower FROM `users` WHERE `login` ='".mysql_real_escape_string($_REQUEST['FindLogin'])."';"));
    if (!$res) $res=mqfa("SELECT id, level, room, align, login, in_tower, 0 as online from allusers where login='".mysql_real_escape_string($_REQUEST['FindLogin'])."'");
    $tologin = $res['login'];
    $step=3;
}
if (@$_REQUEST['to_id']) {
    $res=mysql_fetch_array(mysql_query("SELECT `id`, `level`, `room`, `align`, (select `id` from `online` WHERE `online`.`date` >= ".(time()-60)." AND `online`.`id` = users.`id`) as `online`,`login`,in_tower FROM `users` WHERE `id` ='".mysql_escape_string($_REQUEST['to_id'])."';"));
    if (!$res) $res=mqfa("SELECT id, level, room, align, login, in_tower, 0 as online from allusers where id='".mysql_real_escape_string($_REQUEST['to_id'])."'");
    $tologin = $res['login'];
    $step=3;
}
if (@$step==3){
    $step=0;
    $id_person_x=$res['id'];
    if (@!$id_person_x) $mess='�������� �� ������';
    elseif ($id_person_x==$user['id'] && $user['id'] != 7) $mess='������� ���������� ������ ����';
    elseif ($res['align']==4) $mess='�� ����������� ���� �������� ��������� ���������';
    elseif ($user['align']==4) $mess='�� ����������� ���� �������� ��������� ���������';
    //elseif ($res['online']<1) $mess='�������� �� ������';
    //elseif ($res['room']!=$user['room']) $mess='�� ������ ���������� � ����� ������� � ��� ���� ������ �������� ����';
    elseif ($res['level']<1) $mess='� ���������� �� 1-�� ������ �������� ��������� ���������';
    elseif ($user['level']<8) $mess='���������� �� 8-�� ������ �������� ��������� ���������';
    elseif ($res['in_tower']>0) $mess='�������� ��������� � ����� ������ ��� �� ���� �����';
    else{
        $idkomu=$id_person_x;
        $komu=mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` ='".$idkomu."';"));
        $mess=$_REQUEST['FindLogin'];
        $step=3;
    }
} else $mess='� ���������� �� 1-�� ������ �������� ��������� ���������';

if ($step==3) {
  if ($_REQUEST['sendMessage']) {
    $e=mqfa1("select id from effects where owner='$user[id]' and type=2");
    if ($e) $_REQUEST['sendMessage']=0;
  }
    if ($_REQUEST['sendMessage'] && $_REQUEST['to_id'] && $_REQUEST['sd4']==$user['id'] && $user['money'] >= 0.1) {
      //$_REQUEST['message']=htmlentities($_POST['message'],ENT_NOQUOTES);
      $_REQUEST['message']=strip_tags($_REQUEST['message']);
      $hl=haslinks($_REQUEST['message']);
      $bad=hasbad($txt);
      if ($hl) {
        $f=fopen("logs/autosleep.txt","ab");
        fwrite($f, "$user[login]: $_REQUEST[message]\r\n");
        fclose($f);
        mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".$user['id']."','�������� ��������',".(time()+1800).",2);");
        reportadms("<br><b>$user[login]</b>: $_REQUEST[message]", "�����������");
        addch("<img src=i/magic/sleep.gif> ����������� ������� �������� �������� �� &quot;{$user['login']}&quot;, ������ 30 ���. �������: ���.");
      } else {
        mysql_query("UPDATE `users` set money=money-'0.1' where id='".$user['id']."'");
        mysql_query("INSERT INTO `inventory` (`owner`,`name`,`type`,`massa`,`cost`,`img`,`letter`,`maxdur`,`isrep`)VALUES('".$idkomu."','��������� ����������','200',1,0,'paper100.gif','�� ��������� \"{$user['login']}\": \n ".$_REQUEST['message']."',1,0) ;");
        tele_check($komu['login'],$_REQUEST['message']);
        $mess='��������� ��������� "'.$komu['login'].'" ����� ����������.';
      }
    } elseif ($_REQUEST['setkredit']>=1 && $_REQUEST['to_id'] && $_REQUEST['sd4']==$user['id']) {
        $_REQUEST['setkredit'] = round($_REQUEST['setkredit'],2);
        if (is_numeric($_REQUEST['setkredit']) && ($_REQUEST['setkredit']>0) && ($_REQUEST['setkredit']*1.05 <= $user['money'])) {
            if (!cangive($_REQUEST["setkredit"])) {
              $mess="������������ ����� ��������� �����.";
            } elseif (mysql_query("UPDATE `users` set money=money-".strval($_REQUEST["setkredit"]*1.05)." where id='".$user['id']."'") && mysql_query("UPDATE `users` set money=money+".strval($_REQUEST[setkredit])." where id='".$idkomu."'")) {
                updbalance($user['id'], $idkomu, $_REQUEST["setkredit"]);
                $mess='������ �������� '.strval($_REQUEST[setkredit]).' �� � ��������� '.$komu['login'];
                mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','������ �������� ".strval($_REQUEST[setkredit])." ��. �� \"".$user['login']."\" � \"".$komu['login']."\" ',1,'".time()."');");
                mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$idkomu}','������ �������� ".strval($_REQUEST[setkredit])." ��. �� \"".$user['login']."\" � \"".$komu['login']."\" ',1,'".time()."');");
                $user['money']-=$_REQUEST[setkredit]*1.05;
                $us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$idkomu}' LIMIT 1;"));
                if($us[0]){
                    addchp ('<font color=red>��������!</font> ��� ������ �������� ������� '.strval($_REQUEST[setkredit]).' ��. �� <span oncontextmenu=OpenMenu()>'.$user['login'].'</span>   ','{[]}'.$_POST['to_login'].'{[]}');
                } else {
                    // ���� � ���
                    mysql_query("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$to['id']."','','".'<font color=red>��������!</font> ��� ������ �������� ������� '.strval($_REQUEST[setkredit]).' ��. �� <span oncontextmenu=OpenMenu()>'.$user['login'].'</span>  '."');");
                }
            }
            else {
                $mess="��������� ������";
            }
        } else {
            $mess="������������ �����";
        }
    } elseif ((is_numeric($_REQUEST['setobject']) && $_REQUEST['setobject']>0) && (is_numeric($_REQUEST['to_id']) && $_REQUEST['to_id']>0) && !$_REQUEST['gift'] && $_REQUEST['sd4']==$user['id']) {
        $res = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `id` = '{$_REQUEST['setobject']}' $cond LIMIT 1;"));
        $prc=itemprice($res);
        if (!$res['id']) {
            $mess="������� �� ������ � �������";
        } elseif(mqfa1('SELECT COUNT(*) FROM clanstorage WHERE id_it = ' . $res['id'])) {
            $mess="��� ���� ����������� �����. �� �� ������ �� ����������.";
        } elseif (!cangive($prc["price"])) {
          $mess="���� ������������ ���� ��������� �����.";
        } elseif ($user['money']<1) {
            $mess='������������ ����� �� ������ ��������';
        } else {
            if (mysql_query("update `inventory` set `owner` = ".$komu['id']." where `id`='".$res['id']."' and `owner`= '".$user['id']."';")) {
                updbalance($user['id'], $komu['id'], $prc["price"]);
                mysql_query("update `users` set `money`=`money`-1 where `id`='".$user['id']."'");
                mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','������ ������� ������� \"".$res['name']."\" id:(cap".$res['id'].") [".$res['duration']."/".$res['maxdur']."] �� \"".$user['login']."\" � \"".$komu['login']."\", ����� 1 ��.','1','".time()."');");
                mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$idkomu}','������ ������� ������� \"".$res['name']."\" id:(cap".$res['id'].") [".$res['duration']."/".$res['maxdur']."] �� \"".$user['login']."\" � \"".$komu['login']."\", ����� 1 ��.','1','".time()."');");
                $mess='������ �������� "'.$res['name'].'" � ��������� '.$komu['login'];
                $user['money']-=1;
                $us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$komu['id']}' LIMIT 1;"));
                if($us[0]){
                    addchp ('<font color=red>��������!</font> ��� ������ ������� ������� <b>'.$res['name'].'</b> �� <span oncontextmenu=OpenMenu()>'.$user['login'].'</span>   ','{[]}'.$_POST['to_login'].'{[]}');
                } else {
                    // ���� � ���
                    mysql_query("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$to['id']."','','".'<font color=red>��������!</font> ��� ������ ������� ������� <b>'.$res['name'].'</b> �� <span oncontextmenu=OpenMenu()>'.$user['login'].'</span>  '."');");
                }
            }
        }
    }


}
?>

function reloadit(){
   if (tologin != '') { location="post.php?FindLogin=0&to_id=<? echo $idkomu; ?>&sd4=<? echo $user['id']; ?>&0.760742158507544" }
}

</SCRIPT>
</HEAD>
<body bgcolor=e2e0e0><div id=hint3 class=ahint></div><div id=hint4 class=ahint></div>
<H3>�����</H3>
<TABLE width=100% cellspacing=0 cellpadding=0>
<TR><TD>
<? if ($step==3) {
echo '� ���� ����������: <font color=red><SCRIPT>drwfl("'.@$komu['login'].'",'.@$komu['id'].',"'.@$komu['level'].'","'.@$komu['align'].'","'.@$komu['klan'].'")</SCRIPT></font>';
?> <INPUT TYPE=button value="�������" onClick="findlogin('�������� ���������','post.php','FindLogin')"><BR><?
}else{
    $roww = mysql_fetch_array(mysql_query("SELECT * FROM `trade` WHERE `baer` = {$user['id']} LIMIT 1;"));
    mysql_query("DELETE FROM `trade` WHERE `baer` = {$user['id']} LIMIT 1;");
    if (!$roww['id']) {
?> <SCRIPT>findlogin('�������� ���������','post.php','FindLogin');</SCRIPT><? }
else
 {
    ?> <SCRIPT>transfer(<?=$roww['to_id']?>, '<?=$roww['login']?>', '<?=str_replace("\r\n","",$roww['txt'])?>', <?=$roww['kr']?>, <?=$roww['id']?>, '');</SCRIPT><?
 }
}
?>

</td><TD align=right>
    <INPUT TYPE=button value="���������" style="background-color:#A9AFC0" onClick="window.open('help/transfer.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">
    <INPUT TYPE=button value="���������" onClick="location.href='city.php?cp=3';">
</td></tr><tr><td colspan=2 align=right><? if ($step!=4) {?> <FONT COLOR=red><B><? echo $mess; ?></B></FONT> <? } ?></td></tr></table>

<TABLE width=100% cellspacing=0 cellpadding=0>
<FORM ACTION="post.php" METHOD=POST>
<TR>
    <TD valign=top align=left width=30%>
<?
    if ($step==3) { ?>
    <INPUT TYPE=hidden name=to_id value="<? echo $idkomu; ?>">
    <INPUT TYPE=hidden name=sd4 value="<? echo $user['id']; ?>">
    <br/>
                        <br/>
                        <fieldset>
                        <legend><b>�������� �������</b></legend>
                            <BR>� ��� �� �����: <FONT COLOR=339900><B><? echo $user['money']; ?></B></FONT> ��.<BR>
                            �������� �������, ���������� 1 ��. �������� �������� 5% <br/>
                            ������� ������������ �����: <INPUT TYPE=text NAME=setkredit maxlength=8 size=6>&nbsp;<INPUT TYPE=submit onClick="if(!confirm('��������� ������?')) { return false; }" VALUE="��������">
                        </fieldset>
                        <br/>
        <? $e=mqfa1("select id from effects where owner='$user[id]' and type=2");
           if (!$e) { ?>
                        <fieldset>
                        <legend><b>��������</b></legend>
                        �� ������ ��������� �������� ��������� ������ ���������, ���� ���� �� ��������� � offline ��� ������ ������.<br/>
                        ������ �������: <b>0.1 ��.</b> <br/>
                        ���������: (�������� 100 ��������)
                        <input type="text" name="message" id="message" size="52"> <input type="submit"  id="sendMessage" name="sendMessage" value="���������" onClick="if(!confirm('������� ���������?')) { return false; }">
                        </fieldset>
        <? } else echo "<b><font color=\"red\">�� �� ������ ����� ��������� ���������� �� ����� �������� �������� ��������.</font></b>";
    }
?>
    </TD>
</FORM>

<FORM ACTION="post.php" METHOD=POST>
<INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>">
<TD valign=top align=right>

<?
if ($step==3) {


    if (@$_GET['razdel'] == '0') { $_SESSION['razdel'] = 0; }
    if (@$_GET['razdel'] == 1) { $_SESSION['razdel'] = 1; }
    if (@$_GET['razdel'] == 2) { $_SESSION['razdel'] = 2; }
    if (@$_GET['razdel'] == 3) { $_SESSION['razdel'] = 3; }

?>
<TABLE border=0 width=100% cellspacing="0" cellpadding="0" bgcolor="#A5A5A5">
<TR><TD>
    <TABLE border=0 width=100% cellspacing="0" cellpadding="3" bgcolor=#d4d2d2><TR>
    <TD  align=center bgcolor="<?=($_SESSION['razdel']==null)?"#A5A5A5":"#C7C7C7"?>"><A HREF="?to_id=<? echo $idkomu; ?>&edit=1&razdel=0&sd4=<? echo $user['id']; ?>">��������������</A></TD>
    <TD  align=center bgcolor="<?=($_SESSION['razdel']==1)?"#A5A5A5":"#C7C7C7"?>"><A HREF="?to_id=<? echo $idkomu; ?>&edit=1&razdel=1&sd4=<? echo $user['id']; ?>">��������</A></TD>
    <TD  align=center bgcolor="<?=($_SESSION['razdel']==3)?"#A5A5A5":"#C7C7C7"?>"><A HREF="?to_id=<? echo $idkomu; ?>&edit=1&razdel=3&sd4=<? echo $user['id']; ?>">���</A></TD>
    <TD  align=center bgcolor="<?=($_SESSION['razdel']==2)?"#A5A5A5":"#C7C7C7"?>"><A HREF="?to_id=<? echo $idkomu; ?>&edit=1&razdel=2&sd4=<? echo $user['id']; ?>">������</A></TD>
    </TR></TABLE>
</TD></TR>
<TR>
    <TD align=center><B>������ (�����: <?php

    $d = mysql_fetch_array(mysql_query("SELECT sum(`massa`) FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0; "));

    echo $d[0];
    ?>/<?=$user['sila']*4?>)</B></TD>
</TR>
<TR><TD align=center><!--������-->
<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">
<?php
    if ($_SESSION['razdel']==null) {
      $data = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' $cond AND `type` < 25 ORDER by `update` DESC; ");
    }
    if ($_SESSION['razdel']==1) {                                                                           
      $data = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' $cond AND `type` = 25 ORDER by `update` DESC; ");
    }
    if ($_SESSION['razdel']==2) {
      $data = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' $cond AND `type` > 50 ORDER by `update` DESC; ");
    }
    if ($_SESSION['razdel']==3) {
      $data = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' $cond AND `type` = 50 ORDER by `update` DESC; ");
    }

    while($row = mysql_fetch_array($data)) {
        $row['count'] = 1;
        if (@$i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
        echo "<TR bgcolor={$color}><TD align=center ><IMG SRC=\"i/sh/{$row['img']}\" BORDER=0>";
        ?>
        <BR>
            <? echo "<A HREF=\"post.php?to_id=".$idkomu."&id_th=".$row['id']."&setobject=".$row['id']."&sd4=".$user['id']."&tmp=".rand(0,50000000)."\"".'onclick="return confirm(\'�������� ������� '.$row['name'].'?\')">��������&nbsp;��&nbsp;1&nbsp;��.</A>';
            //echo "<br><A HREF=\"post.php?to_id=".$idkomu."&id_th=".$row['id']."&setobject=".$row['id']."&gift=1&sd4=".$user['id']."&tmp=".rand(0,50000000)."\"".'onclick="return confirm(\'�������� ������� '.$row['name'].'?\')">��������</A>';
            // echo "<br><A HREF=#".' onClick="findmoney(\'������� ��������\',\'post.php\',\'cost\','.$row['id'].')">�������</A>';?>

        </TD>
        <?php
        echo "<TD valign=top>";
        showitem ($row);
        echo "</TD></TR>";
    }
    if (mysql_num_rows($data) == 0) {
        echo "<tr><td align=center bgcolor=#C7C7C7>�����</td></tr>";
    }
?>



</TABLE>
</TD></TR>
</TABLE><?php
 }
?>


</TD></TR>
</FORM>
</TABLE>
<br><div align=right>

    <?php include("mail_ru.php"); ?>

<div>
</BODY>
</HTML>

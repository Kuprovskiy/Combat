<?php
    session_start();
    if ($_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
    include "functions.php";
    $al = mysql_fetch_assoc(mysql_query("SELECT * FROM `aligns` WHERE `align` = '{$user['align']}' LIMIT 1;"));
    header("Cache-Control: no-cache");
    if ($user['align']<2 || $user['align']>3|| $user['align']==5) header("Location: index.php");
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<style>
    .row {
        cursor:pointer;
    }
</style>
<script type="text/javascript">
  function show(ele) {
      var srcElement = document.getElementById(ele);
      if(srcElement != null) {
          if(srcElement.style.display == "block") {
            srcElement.style.display= 'none';
          }
          else {
            srcElement.style.display='block';
          }
      }
  }
</script>
<SCRIPT>
var Hint3Name = '';
// ���������, �������� �������, ��� ���� � �������
function runmagic(title, magic, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><form action="a.php" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    '������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD align=left><INPUT TYPE=text NAME="'+name+'">'+
    '<select style="background-color:#eceddf; color:#000000;" name="timer"><option value=15>15 ���<option value=30>30 ���<option value=60>1 ���'+
    '<option value=180>3 ����<option value=360>6 �����<option value=720>12 �����<option value=1440>�����'+
    '<option value=10080>������<option value=40320>�����</select></TD><TD width=30><INPUT TYPE="submit" value=" �� "></TD></TR></FORM></TABLE></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}

function runmagicf(title, magic, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><form action="a.php" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    '������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD align=left><INPUT TYPE=text NAME="'+name+'">'+
    '<select style="background-color:#eceddf; color:#000000;" name="timer"><option value=15>15 ���<option value=30>30 ���<option value=60>1 ���'+                              
    '<option value=180>3 ����<option value=360>6 �����<option value=720>12 �����<option value=1440>�����<option value=4320>3 �����<option value=10080>������<option value=40320>�����</select>'+
    '</TD><TD width=30><INPUT TYPE="submit" value=" �� "></TD></TR></FORM></TABLE></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}

function runmagic1(title, magic, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<form action="a.php" method=POST><table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    '������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD align=left><INPUT TYPE=text NAME="'+name+'">'+
    '</TD><TD width=30><INPUT TYPE="submit" value=" �� "></TD></TR></TABLE></FORM></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}

function runmagic2(title, magic, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><form action="a.php" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    '������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD align=left><INPUT TYPE=text NAME="'+name+'">'+
    '<select style="background-color:#eceddf; color:#000000;" name="timer"><option value=1>1 ����</option><option value=2>2 ���<option value=3>3 ���<option value=7>������<option value=14>2 ������'+
    '<option value=30>1 �����<option value=60>2 ������<option value=365>���������</select>'+
    '</TD><TD width=30><INPUT TYPE="submit" value=" �� "></TD></TR></FORM></TABLE></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}

function runmagic3(title, magic, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><form action="a.php" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    '������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD align=left><INPUT TYPE=text NAME="'+name+'">'+
    '<br>�������: <INPUT TYPE=text size=25 NAME="palcom"></TD><TD width=30><INPUT TYPE="submit" value=" �� "></TD></TR></FORM></TABLE></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}
function runmagic4(title, magic, name, name1){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td><form action="a.php" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    '������� ����� ������: <INPUT TYPE=text NAME="'+name+'">'+
    '<br>������� ����� �������: <INPUT TYPE=text NAME="'+name1+'">'+
    '<br><center><INPUT TYPE="submit" value=" �� "></center></TD></TR></FORM></TABLE></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}
function runmagic5(title, magic, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<form action="a.php" method=POST><table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    '������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD align=left><INPUT TYPE=text NAME="'+name+'">'+
    ' ����: <input type=text size=2 name="days"></TD><TD width=30><INPUT TYPE="submit" value=" �� "></TD></TR></TABLE></FORM></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}
function runmagic10(title, magic, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><form action="a.php" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    '������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD align=left><INPUT TYPE=text NAME="'+name+'">'+
    '<select style="background-color:#eceddf; color:#000000;" name="timer"><option value=2>2 ���<option value=3>3 ���<option value=7>������<option value=14>2 ������'+
    '<option value=30>1 �����<option value=60>2 ������<option value=365>���������</select>'+
    '</TD><TD width=30><INPUT TYPE="submit" value=" �� "></TD></TR></FORM></TABLE></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}
function teleport(title, magic, name){
	document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
	'<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><form action="a.php" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
	'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD align=left><INPUT TYPE=text NAME="'+name+'">'+
	'<select style="background-color:#eceddf; color:#000000;" name="room">'+
'<option value=0">��������� �������'+
'<option value=1">������� ��� ��������'+
'<option value=2">������� ��������'+
'<option value=3">���������� ����'+
'<option value=4">����������'+
'<option value=5">��� ������ 1'+
'<option value=6">��� ������ 2'+
'<option value=7">��� ������ 3'+
'<option value=15">��� ���������'+
'<option value=16">����� ������ ��������'+
'<option value=17">��� ����'+
'<option value=19">������'+
'<option value=20">����������� �������'+
'<option value=21">����������� �����'+
'<option value=201">�������� �����'+
'<option value=22">�������'+
'<option value=23">��������� ����������'+
'<option value=25">������������ �������'+
'<option value=27">�����'+
'<option value=28">������������ ������'+
'<option value=29">����'+
'<option value=31">����� ������'+
'<option value=35">������� �������'+
'<option value=43">������� �������'+
'<option value=402">���� � ����������'+
'<option value=404">������� ����'+
'<option value=666">������'+
'<option value=667">��� "������ �����"'+
'<option value=888">����������'+
'<option value=48">��������� ���� 1'+
'<option value=49">��������� ���� 2'+
'<option value=444">������'+
'</select></select>'+
	'</TD><TD width=30><INPUT TYPE="submit" value=" �� "></TD></TR></FORM></TABLE></td></tr></table>';
	document.all("hint3").style.visibility = "visible";
	document.all("hint3").style.left = 100;
	document.all("hint3").style.top = 100;
	document.all(name).focus();
	Hint3Name = name;
}


function closehint3(){
    document.all("hint3").style.visibility="hidden";
    Hint3Name='';
}
</SCRIPT>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=0 marginheight=0 bgcolor=#e2e0e0 >
<?
  if ($user["align"]=='2.5' || $user["align"]=='2.9') {
    if ($todo=="takemoney") {
      $sum=(float)$_POST["sum"];
      $u=mqfa1("select id from users where login='$_POST[login]'");
      if (!$u) $u=mqfa1("select id from allusers where login='$_POST[login]'");
      if ($u) getuserdata($u);
      if (!$u) echo "<b><font color=red>�������� �� ������</b></font>";
      elseif (!$sum) echo "<b><font color=red>������� ������� �����</b></font>";
      else {
        echo "<b>�� ��������� $_POST[login] ������� ����� � ������� $_POST[sum] ��.</b>";
        mq("update users set money=money-$sum where id='$u'");
        telegraph($_POST["login"], "�� ��� ������� ����� � ������� $_POST[sum] ��. �������: $_POST[reason]",0);
        adddelo($u, "$user[login] �������".($user["sex"]==1?"":"�")." ����� �� ��������� $_POST[login] � ������� $_POST[sum] ��. �������: $_POST[reason].", PENALTY);
      }
    }
  }

  if (@$_GET["backupdb"] && $user["align"]=="2.5"|| $user['align']==5) {
    $r=mq("show tables from backup2");
    echo mysql_error();
    while ($rec=mysql_fetch_row($r)) {
      mq("truncate table backup2.$rec[0]");
      echo mysql_error();
      mq("insert into backup2.$rec[0] (select * from $rec[0])");
      $e=mysql_error();
      if ($e) echo $e."insert into backup2.$rec[0] (select * from $rec[0])";
    }
  }
?>
<table align=right><tr><td><INPUT TYPE="button" onclick="location.href='main.php';" value="���������" title="���������"></table>
<?php

function imp ($array) {
    foreach($array as $k => $v) {
        $str .= $k.";".$v.";";
    }
    return $str;
}
function expa ($str) {
    $array = explode(";",$str);
    for ($i = 0; $i<=count($array)-2;$i=$i+2) {
        $rarray[$array[$i]] = $array[$i+1];
    }
    return $rarray;
}
    if ($user['align']>2 && $user['align']<3) {
        if ($user['sex'] == 1) {
            echo "<h3>������ ������ {$user['login']}!</h3>
            ";
        }
}

    echo "<div align=center id=hint3></div>";

        //print_r($al);
        $moj = expa($al['accses']);
if(!$_POST['use']){$_POST['use']=$_GET['use'];}
        if(in_array($_POST['use'],array_keys($moj))) {
            //echo $_GET['use'];
            $i=mqfa1("select id from users where login='$_POST[target]'");
            if (!$i) {
              $i=mqfa1("select id from allusers where login='$_POST[target]'");
              if ($i) restoreuser($i);
            }
            switch($_POST['use']) {
                case "delbattle":
                  $b=mqfa1("select battle from users where login='$_POST[target]'");
                  if ($b) {
                    mysql_query("UPDATE users SET `battle` =0, `nich` = `nich`+'1',`fullhptime` = ".time().",`fullmptime` = ".time().",`udar` = '0' WHERE `battle` = $b");
                    mq("update battle set win=0 where id='$b'");
                    mq("delete from bots where battle='$b'");
                    $fp = fopen ("backup/logs/battle$b.txt","a"); //��������
                    flock ($fp,LOCK_EX); //���������� �����
                    fputs($fp , '<hr><span class=date>'.date("H:i").'</span> ��� ��������. �����.<BR>'); //������ � ������
                    fflush ($fp); //�������� ��������� ������ � ������ � ����
                    flock ($fp,LOCK_UN); //������ ����������
                    fclose ($fp); //��������
                    echo "<b>��� ��������� $_POST[target] �����.</b>";
                  } else echo "<b><font color=red>�������� $_POST[target] �� � ���.</font></b>";
                break;
                case "credit":
                  $u=mqfa1("select id from users where login='$_POST[target]'");
                  if ($u) {
                    $i=mqfa1("select id from effects where type=31 and owner='$u' or owner=$u+"._BOTSEPARATOR_);
                    if ($i) {
                      echo "�� ��������� <b>$_POST[target]</b> ��� ���� �������� �������.";
                    } else {
                      $_POST["days"]=(int)$_POST["days"];
                      if ($_POST["days"]) {
                        mq("insert into effects (name, type, time, owner) values ('������', 31, ".(60*60*24*$_POST["days"]+time()).", '$u')");
                        echo "�� ��������� $_POST[target] ������� ������ ������ $_POST[days] ����.";
                      } else echo "������� �������� ���������� ����.";
                    }
                  } else echo "�������� $_POST[target] �� ������.";
                break;
                case "credit_off":
                  $u=mqfa1("select id from users where login='$_POST[target]'");
                  if ($u) {
                    $i=mqfa1("select id from effects where type=31 and owner='$u'");
                    if ($i) {
                      mq("delete from effects where owner='$u' and type=31");
                      mq("delete from obshagaeffects where owner='$u' and type=31");
                      echo "� ��������� $_POST[target] ����� �������� �������.";
                    } else echo "�� ��������� $_POST[target] ��� �������� �������.";
                  } else echo "�������� $_POST[target] �� ������.";
                break;
                case "gender":
                    include("./magic/gender.php");
                break;
                case "sleep":
                    include("./magic/sleep.php");
                break;
                case "sleepf":
                    include("./magic/sleepf.php");
                break;
                case "sleep_off":
                    include("./magic/sleep_off.php");
                break;
                case "sleepf_off":
                    include("./magic/sleepf_off.php");
                break;
                case "haos":
                    include("./magic/haos.php");
                break;
                case "haos_off":
                    include("./magic/haos_off.php");
                break;
                case "obezl":
                    include("./magic/obezl.php");
                break;
                case "obezl_off":
                    include("./magic/obezl_off.php");
                break;
                case "death":
                    include("./magic/death.php");
                break;
                case "death_off":
                    include("./magic/death_off.php");
                break;
                case "chains":
                    include("./magic/stop.php");
                break;
                case "chainsoff":
                    include("./magic/start.php");
                break;
                case "jail":
                    include("./magic/jail.php");
                break;
                case "jail_off":
                    include("./magic/jail_off.php");
                break;
                case "ldadd":
                    include("./magic/ldadd.php");
                break;
                case "attackk":
                    include("./magic/attackk.php");
                break;
                case "attack":
                    include("./magic/attack.php");
                break;
                case "battack":
                    include("./magic/battack.php");
                break;
                case "attackt":
                    include("./magic/attackt.php");
                break;
                case "pal_off":
                    include("./magic/pal_off.php");
                break;
                case "tar_off":
                    include("./magic/tar_off.php");
                break;
                case "marry":
                    include("./magic/marry.php");
                break;
                case "unmarry":
                    include("./magic/unmarry.php");
                break;
                case "ct_all":
                    include("./magic/act_all.php");
                break;
                case "check":
                    include("./magic/check.php");
                break;
                case "vampir":
                    include("./magic/vampir.php");
                break;
                case "bexit":
                    include("./magic/bexit.php");
                break;
                case "devastate":
                    include("./magic/devastate.php");
                break;
                case "brat":
                    include("./magic/brat.php");
                break;
                case "piot":
                    include("./magic/piot.php");
                break;
                case "nepiot":
                    include("./magic/nepiot.php");
                break;
                case "bratl":
                    include("./magic/bratl.php");
                break;
                case "dneit":
                    include("./magic/dneit.php");
                break;
                case "ddark":
                    include("./magic/ddark.php");
                break;
                case "dlight":
                    include("./magic/dlight.php");
                break;
                case "vragon":
                    include("./magic/vragon.php");
                break;
                case "vragoff":
                    include("./magic/vragoff.php");
                break;
                case "a_ogon":
                    include("./magic/a_ogon.php");
                break;
                case "a_voda":
                    include("./magic/a_voda.php");
                break;
                case "a_vozduh":
                    include("./magic/a_vozduh.php");
                break;
                case "a_zemlya":
                    include("./magic/a_zemlya.php");
                break;
                case "iz_ogon":
                    include("./magic/iz_ogon.php");
                break;
                case "iz_voda":
                    include("./magic/iz_voda.php");
                break;
                case "iz_vozduh":
                    include("./magic/iz_vozduh.php");
                break;
                case "iz_zemlya":
                    include("./magic/iz_zemlya.php");
                break;
                case "defence":
                    include("./magic/defence.php");
                break;
                case "teleport":
                    include("./magic/teleport.php");
                break;
                case "hidden":
                    include("./magic/hidden.php");
                break;
            }
        }
        echo "<table>";
        echo "<tr><td align=center><br><br>";
        foreach($moj as $k => $v) {
            //echo $k;
            switch($k) {
                case "sleep": $script_name="runmagic"; $magic_name="�������� �������� ��������"; break;
                case "sleepf":
                if ($user['align']>2 && $user['align']<3|| $user['align']==5|| $user['deal']==5) {
                    $script_name="runmagicf"; $magic_name="�������� �������� ��������� ��������";
                }
                else {
                    $script_name="runmagic"; $magic_name="�������� �������� ��������� ��������";
                }
                break;
                case "sleep_off": $script_name="runmagic1"; $magic_name="����� �������� ��������"; break;
                case "sleepf_off": $script_name="runmagic1"; $magic_name="����� �������� ��������� ��������"; break;
                case "haos": $script_name="runmagic2"; $magic_name="�������� �������� �����"; break;
                case "haos_off": $script_name="runmagic1"; $magic_name="����� �������� �����"; break;
                case "death": $script_name="runmagic1"; $magic_name="�������� �������� ������"; break;
                case "death_off": $script_name="runmagic1"; $magic_name="����� �������� ������"; break;
                case "chains": $script_name="runmagic2"; $magic_name="�������� ����"; break;
                case "chainsoff": $script_name="runmagic1"; $magic_name="����� ����"; break;
                case "jail": $script_name="runmagic2"; $magic_name="��������� � ���������"; break;
                case "jail_off": $script_name="runmagic1"; $magic_name="��������� �� ���������"; break;
                case "piot": $script_name="runmagic1"; $magic_name="� ��� ���� ����?"; break;
                case "nepiot": $script_name="runmagic1"; $magic_name="������� �� ����"; break;
                case "obezl": $script_name="runmagic2"; $magic_name="�������� �������� �������������"; break;
                case "obezl_off": $script_name="runmagic1"; $magic_name="����� �������� �������������"; break;
                case "pal_off": $script_name="runmagic1"; $magic_name="������ ������ �������"; break;
                case "attackk": $script_name="runmagic1"; $magic_name="�������� ���������"; break;
                case "attack": $script_name="runmagic1"; $magic_name="���������"; break;
                case "battack": $script_name="runmagic1"; $magic_name="�������� ���������"; break;
                case "attackt": $script_name="runmagic1"; $magic_name="������ ���������"; break;
                case "marry": $script_name="runmagic4"; $magic_name="���������������� ����"; break;
                case "unmarry": $script_name="runmagic4"; $magic_name="����������� ����"; break;
                case "hidden": $script_name="runmagic1"; $magic_name="�������� �����������"; break;
                case "teleport": $script_name="teleport"; $magic_name="������������"; break;
                case "check": $script_name="runmagic1"; $magic_name="��������� ��������"; break;
                case "ct_all": $script_name="runmagic1"; $magic_name="�������� �� �����"; break;
                case "pal_buttons": $script_name="runmagic"; $magic_name="�������� � ����������� ��������"; break;
                case "vampir": $script_name="runmagic1"; $magic_name="��������� (������ ������� ������� ������)"; break;
                case "brat": $script_name="runmagic1"; $magic_name="������ ������� ������� (��������� � ��������)"; break;
                case "bratl": $script_name="runmagic1"; $magic_name="�������� ����"; break;
                case "dneit": $script_name="runmagic1"; $magic_name="��������� ���������� (����������� ��������)"; break;
                case "dlight": $script_name="runmagic1"; $magic_name="��������� ���������� (������� ��������)"; break;
                case "ddark": $script_name="runmagic1"; $magic_name="��������� ���������� (������ ��������)"; break;
                case "note": $script_name="runmagic"; $magic_name="������������� ������ ����"; break;
                case "sys": $script_name="runmagic"; $magic_name="��������� � ��� ��������� ���������"; break;
                case "scanner": $script_name="runmagic"; $magic_name="�������� ��� �������� ����������"; break;
                case "rep": $script_name="runmagic"; $magic_name="����� � ���������"; break;
                case "rost": $script_name="runmagic"; $magic_name="��������� ������"; break;
                case "ldadd": $script_name=""; $magic_name=""; break;
                case "bexit": $script_name="runmagic1"; $magic_name="����� �� ���"; break;
                case "a_ogon": $script_name="runmagic1"; $magic_name="������ ������ (�����)"; break;
                case "iz_ogon": $script_name="runmagic1"; $magic_name="�������� ������� ������ (�����)"; break;
                case "a_voda": $script_name="runmagic1"; $magic_name="������ ������ (����)"; break;
                case "iz_voda": $script_name="runmagic1"; $magic_name="�������� ������� ������ (����)"; break;
                case "a_vozduh": $script_name="runmagic1"; $magic_name="������ ������ (������)"; break;
                case "iz_vozduh": $script_name="runmagic1"; $magic_name="�������� ������� ������ (������)"; break;
                case "a_zemlya": $script_name="runmagic1"; $magic_name="������ ������ (�����)"; break;
                case "iz_zemlya": $script_name="runmagic1"; $magic_name="�������� ������� ������ (�����)"; break;
                case "defence": $script_name="runmagic1"; $magic_name="�������� ������ �� ������"; break;
                case "devastate": $script_name="runmagic1"; $magic_name="�������� ����������"; break;
                case "gender": $script_name="runmagic1"; $magic_name="������� ���"; break;
                case "delbattle": $script_name="runmagic1"; $magic_name="������� ���"; break;
                case "credit": $script_name="runmagic5"; $magic_name="�������� �������� �������"; break;
                case "credit_off": $script_name="runmagic1"; $magic_name="����� �������� �������"; break;
		case "teleport": $script_name="runmagic1"; $magic_name="������������"; break;
		case "hidden": $script_name="runmagic1"; $magic_name="�����������"; break;
            }
                        if($k=="vragon"){echo"<a onclick=\"if (confirm('�� ������� ��� ������ ������� ������ �����?')) window.location='a.php?use=vragon'\" href='#'><img src='i/magic/16.gif' title='������� ������ �����'></a> ";}
                        elseif($k=="vragoff"){echo"<a onclick=\"if (confirm('�� ������� ��� ������ �������� ������ �����?')) window.location='a.php?use=vragoff'\" href='#'><img src='i/magic/34.gif' title='�������� ������ �����'></a> ";}
            elseif ($script_name) {print "<a onclick=\"javascript:$script_name('$magic_name','$k','target','target1') \" href='#'><img src='i/magic/".$k.".gif' title='".$magic_name."'></a> ";}
}
        echo "</td></tr></table>";



/* �� ����� ������
    if ($user['align']>2 && $user['align']<3 && $_SESSION['uid']==311) {
if($_GET['delpers']=="on"){
set_time_limit (120);
//$us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-1209600).""));
    $deletid1 = mysql_query("SELECT `id`,`login` FROM `users` WHERE `block`='1' and `level`='0'");
$i=0;
while ($deletid=mysql_fetch_array($deletid1)) {
$i++;
mysql_query("DELETE FROM `bank` WHERE `owner` = ".$deletid['id']."");
mysql_query("DELETE FROM `battle` WHERE `t1` = ".$deletid['id']."");
mysql_query("DELETE FROM `battle` WHERE `t2` = ".$deletid['id']."");
mysql_query("DELETE FROM `confirmpasswd` WHERE `login` = ".$deletid['login']."");
mysql_query("DELETE FROM `delo` WHERE `pers` = ".$deletid['id']."");
mysql_query("DELETE FROM `delo_multi` WHERE `idpersnow` = ".$deletid['id']."");
mysql_query("DELETE FROM `delo_multi` WHERE `idperslater` = ".$deletid['id']."");
mysql_query("DELETE FROM `deztow_charstams` WHERE `owner` = ".$deletid['id']."");
mysql_query("DELETE FROM `deztow_turnir` WHERE `winner` = ".$deletid['id']."");
mysql_query("DELETE FROM `dilerdelo` WHERE `owner` = ".$deletid['login']."");
mysql_query("DELETE FROM `effects` WHERE `owner` = ".$deletid['id']."");
mysql_query("DELETE FROM `friends` WHERE `user` = ".$deletid['id']."");
mysql_query("DELETE FROM `friends` WHERE `friend` = ".$deletid['id']."");
mysql_query("DELETE FROM `friends` WHERE `enemy` = ".$deletid['id']."");
mysql_query("DELETE FROM `friends` WHERE `notinlist` = ".$deletid['id']."");
mysql_query("DELETE FROM `inventory` WHERE `owner` = ".$deletid['id']."");
mysql_query("DELETE FROM `invites` WHERE `owner` = ".$deletid['id']."");
mysql_query("DELETE FROM `iplog` WHERE `owner` = ".$deletid['id']."");
mysql_query("DELETE FROM `kaznalog` WHERE `user` = ".$deletid['id']."");
mysql_query("DELETE FROM `komplekt` WHERE `owner` = ".$deletid['id']."");
mysql_query("DELETE FROM `lichka` WHERE `pers` = ".$deletid['id']."");
mysql_query("DELETE FROM `lottery_log` WHERE `id_user` = ".$deletid['id']."");
mysql_query("DELETE FROM `online` WHERE `id` = ".$deletid['id']."");
mysql_query("DELETE FROM `person_on` WHERE `id_person` = ".$deletid['id']."");
mysql_query("DELETE FROM `puton` WHERE `id_person` = ".$deletid['id']."");
mysql_query("DELETE FROM `telegraph` WHERE `owner` = ".$deletid['id']."");
mysql_query("DELETE FROM `trade` WHERE `to_id` = ".$deletid['id']."");
mysql_query("DELETE FROM `trade` WHERE `login` = ".$deletid['login']."");
mysql_query("DELETE FROM `visit_podzem` WHERE `login` = ".$deletid['login']."");
mysql_query("DELETE FROM `vxod` WHERE `login` = ".$deletid['login']."");
mysql_query("DELETE FROM `vxodd` WHERE `login` = ".$deletid['login']."");

if(!function_exists("delete_directory")) {
function delete_directory($dirname) {
 if (is_dir($dirname))
 $dir_handle = opendir($dirname);
 if (!$dir_handle)
 return false;
 while($file = readdir($dir_handle)) {
 if ($file != "." && $file != "..") {
 if (!is_dir($dirname."/".$file))
 unlink($dirname."/".$file);
 else
 delete_directory($dirname.'/'.$file);
 }
 }
 closedir($dir_handle);
 rmdir($dirname);
 return true;
 }}
delete_directory(MEMCACHE_PATH."/komplekt/".$deletid['id']);
unlink("tmp/zayavka/".$deletid['id'].".txt");
mysql_query("DELETE FROM `users` WHERE `id` = ".$deletid['id']."");
}
echo "������� ".$i." ����������.<br>";
}
?>
<br>������� ���� ��������������� ���������� 0 ������, � ����� �� �������� ������ �����. <INPUT TYPE=button onClick="if (confirm('�� ������� ��� ������ ������� ����������?')) window.location='a.php?delpers=on'" value="�������">
        <?}

*/



    if ($user['align']>2 && $user['align']<3|| $user['align']==5|| $user['deal']==5) {
            echo "<form method=post action=\"a.php\">�������� � \"����\" ������ ������� � ��������� ������, ��������� � ��. <br>
                    <table><tr><td>������� ����� </td><td><input type='text' name='ldnick' value='$ldtarget'></td><td> ��������� <input type='text' size='50' name='ldtext' value=''></td><td><input type='hidden' name='use' value='ldadd'><input type=submit value='��������'></td></tr>";
    if ($user['align']>2 && $user['align']<3) {
                if ($ldblock) {
                    echo "<tr><td colspan=4><input type='checkbox' name='red' class='input' checked> ��������, ��� ������� �������� � ����/����������</td></tr>";
                }
                else {
                    echo "<tr><td colspan=4><input type='checkbox' name='red' class='input' > ��������, ��� ������� �������� � ����/����������</td></tr>";
                }
            }
            echo "</table></form>";
        }
    if (($user['align']>2 && $user['align']<3) || $user['align']==5|| $user['deal']==5) {
    $online = mysql_fetch_row(mysql_query("select COUNT(*) from `online`  WHERE `real_time` >= ".(time()-60).";"));
    if($_POST['add'] OR $_POST['add2']) {
        @setcookie("time",time());
    }
    if ($_POST['action']!="") {
            switch ($_POST['action']) {

            case "sysmsg":
            if (filesize(CHATROOT."chat.txt")>20*1024) {
                //file_put_contents("chat.txt", file_get_contents("chat.txt", NULL, NULL, 3*1024), LOCK_EX);
                //@chmod("$fp", 0644);
                // �������� ��������� ������
                $file=file(CHATROOT."chat.txt");
                $fp=fopen(CHATROOT."chat.txt","w");
                flock ($fp,LOCK_EX);
                for ($s=0;$s<count($file)/1.5;$s++) {
                    unset($file[$s]);
                }
                fputs($fp, implode("",$file));
                fputs($fp ,"\r\n:[".time ()."]:[!sys2all!!]:[<font color=\"#ff0000\"><b>��������!</b></font> <b>".($_POST['msg'])."</b> (<font color=red><b>".$user['login']."</b></font>) ]:[1]\r\n"); //������ � ������
                flock ($fp,LOCK_UN);
                fclose($fp);
            }
            else {
                $fp = fopen (CHATROOT."chat.txt","a"); //��������
                flock ($fp,LOCK_EX); //���������� �����
                fputs($fp ,"\r\n:[".time ()."]:[!sys2all!!]:[<font color=\"#ff0000\"><b>��������!</b></font> <b>".($_POST['msg'])."</b> (<font color=red><b>".$user['login']."</b></font>) ]:[1]\r\n"); //������ � ������
                fflush ($fp); //�������� ��������� ������ � ������ � ����
                flock ($fp,LOCK_UN); //������ ����������
                fclose ($fp); //��������
            }
                //echo "���������� ��������� ��������� � ���.";

                break;
                }
        }
?>
<HTML>
<script>
var xmlHttpp=[]
function ajax_func(func,iid,getpar,postpar){
  xmlHttpp[iid]=GetXmlHttpObject1()
  if (xmlHttpp[iid]==null){
    alert ("Browser does not support HTTP Request")
    return
    }
  document.getElementById(iid).innerHTML="<img src='./i/loading2.gif' />";
  var url="./ajax/"+func+".php"
  url=url+"?"+getpar
  xmlHttpp[iid].open("POST",url,true);
  xmlHttpp[iid].onreadystatechange=function() {
    if (xmlHttpp[iid].readyState==4 || xmlHttpp[iid].readyState=="complete") {
      if (document.getElementById(iid)=='[object HTMLInputElement]')
    document.getElementById(iid).value=xmlHttpp[iid].responseText;
      else
    document.getElementById(iid).innerHTML=xmlHttpp[iid].responseText;
    document.getElementById('chat').scrollTop = document.getElementById('chat').scrollHeight+10;
      }
    }
  xmlHttpp[iid].setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  xmlHttpp[iid].send(postpar);
}

function GetXmlHttpObject1()
{
var xmlHttp1=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp1=new XMLHttpRequest();
 }
catch (e)
 {
 //Internet Explorer
 try
  {
  xmlHttp1=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp1;
}
</script>
</HTML>
<?
}
if (($user['align']>2) && ($user['align']<3|| $user['align']==5|| $user['deal']==5)) {
?>
<hr><div id='content' style='width:100%;'>

<div style='width:100%; height:40%;' id=adm_act>
<div style='float:left;'>��������� ��������� ��������� � ���</div><div style='float:left; margin-left:10px;'>
<input name='sysmsg' id='sysmsg' size=100>
<input type="button" OnClick=" document.getElementById('action').value='sysmsg'; document.getElementById('msg').value=document.getElementById('sysmsg').value; document.actform.submit(); " value="���������">
<?
  $r=mq("select users.login, users.room, effects.time from effects left join users on users.id=effects.owner where type=1022 and time>".time());
  if (mysql_num_rows($r)>0) {
    echo "<br><br>���������:<table>
    <tr><td><b>�����</b></td><td><b>�����</b></td><td><b>�������</b><td></td></tr>";
    while ($rec=mysql_fetch_assoc($r)) {
      echo "<tr><td>".substr($rec["time"],strlen($rec["time"])-4)."</td><td>$rec[login]</td><td>".$rooms[$rec["room"]]."</td></tr>";
    }
    echo "</table>";
  }
  $r=mq("select users.id from `users` where left(borndate,5)=date_format(curdate(),'%d-%m')");
  if (mysql_num_rows($r)>0) {
    echo "<br><br>��� �������� �������:<table><tr><td>�����</td><td>������</td></tr>";
    while ($rec=mysql_fetch_assoc($r)) {
      echo "<tr><td>";
      nick2($rec["id"]);
      echo "</td><td>";
      $online1 = mysql_fetch_array(mysql_query('SELECT o.date,o.real_time FROM `users` as u, `online` as o WHERE u.`id` = o.`id` AND u.`id` = \''.$rec['id'].'\' LIMIT 1;'));
      $lv=time()-$online1["date"];
      if ($lv<60) echo "<b>������</b>";
      else echo date("d.m H:i", $online1['date']);
      echo "</td></tr>";
    }
    echo "</table>";
  }

  $r=mq("select users.id from `users` where left(borndate,5)=date_format(date_add(curdate(), interval 1 day),'%d-%m')");
  if (mysql_num_rows($r)>0) {
    echo "<br><br>��� �������� ������:<table><tr><td>�����</td><td>������</td></tr>";
    while ($rec=mysql_fetch_assoc($r)) {
      echo "<tr><td>";
      nick2($rec["id"]);
      echo "</td><td>";
      $online1 = mysql_fetch_array(mysql_query('SELECT o.date,o.real_time FROM `users` as u, `online` as o WHERE u.`id` = o.`id` AND u.`id` = \''.$rec['id'].'\' LIMIT 1;'));
      $lv=time()-$online1["date"];
      if ($lv<60) echo "<b>������</b>";
      else echo date("d.m H:i", $online1['date']);
      echo "</td></tr>";
    }
    echo "</table>";
  }


?>
<br>������ � �����: <?=$online[0];?>

</div>
<form method=POST name='actform'>
<input type=hidden name='action' id='action'>
<input type=hidden name='msg' id='msg'>
</form>
</div>
<?
/*
<div id='content' style='width:100%;'>
<div style='float:left;'>��������� ��������� ��������� � ���</div><div style='float:left; margin-left:10px;'><input name='sysmsg' id='sysmsg' size=100> <input type=button OnClick=" document.getElementById('action').value='sysmsg'; document.getElementById('msg').value=document.getElementById('sysmsg').value; document.actform.submit(); "></div>
<div style='clear:both;'></div>
</div>
<form method=POST name='actform'>
<input type=hiddn name='action' id='action'>
<input type=hiddn name='msg' id='msg'>
</form> */
}

    if ($user['align']>2 && $user['align']<3|| $user['align']==5|| $user['deal']==5) {
            echo "<HR>";
            if($_POST['grn'] && $_POST['gr']) {
                echo telegraph($_POST['grn'],$_POST['gr']);
            }
            echo '<h4>��������</h4>�� ������ ��������� �������� ��������� ������ ���������, ���� ���� �� ��������� � offline ��� ������ ������.
<form method=post style="margin:5px;">�����: <input type=text size=20 name="grn"> ����� ���������: <input type=text size=80 name="gr"> <input type=submit value="���������"></form>';
        }

    if ($user['align']>2 && $user['align']<3|| $user['align']==5|| $user['deal']==5) {

            echo "<a name=\"searchitem\"></a><hr><form action=\"a.php#searchitem\" method=\"post\"><b>���������� �������� � ���������</b><br>
            ID ��������: <input type=text size=8 name=\"operationsitem\" value=\"".@$_POST["operationsitem"]."\"> <input type=checkbox id=\"inarchive\" name=\"inarchive\"> <label for=\"inarchive\">������ � ������</label> <input type=\"submit\" value=\"����������\">
            </form>";
            if (@$_POST["operationsitem"]) {
              if (@$_POST["inarchive"]) $r = mq("SELECT * FROM archive.delo WHERE text like '%$_POST[operationsitem]%' ORDER by `id`");
              else $r = mq("SELECT * FROM `delo` WHERE text like '%$_POST[operationsitem]%' ORDER by `id`");
              
              while($rec=mysql_fetch_assoc($r)) {
                $dat=date("d.m.y H:i",$rec['date']);
                echo "<span class=date>$dat</span> $rec[text]<br>";
              }

            }
            echo "</hr>";

            if (!$_POST['logs']) {$_POST['logs']=date("d.m.y");}
            echo '<hr><TABLE><TR><TD colspan=3><FORM METHOD=POST ACTION=a.php>
            ����������� �������� ���������: <INPUT TYPE=text NAME=filter value="'.$_POST['filter'].'"> �� <INPUT TYPE=text NAME=logs size=12 value="'.$_POST['logs'].'"> <INPUT TYPE=submit value="�����������!">
            <INPUT TYPE=submit name="all" value="���������� ����� ���������">
            </form></TD>
            </tr><tr><td><FORM METHOD=POST ACTION=a.php><INPUT TYPE=hidden NAME=filter value="'.$_POST['filter'].'">
            <INPUT TYPE=hidden NAME=logs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['logs'],3,2), substr($_POST['logs'],0,2)-1, "20".substr($_POST['logs'],6,2))).'">
            <INPUT TYPE=submit value="   �   "></form></TD>
            <TD valign=top align=center>�������� ��������� <b>"'.$_POST['filter'].'"</b> ��  <b>'.$_POST['logs'].'</b></TD>
            <TD><FORM METHOD=POST ACTION=a.php><INPUT TYPE=hidden NAME=logs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['logs'],3,2), substr($_POST['logs'],0,2)+1, "20".substr($_POST['logs'],6,2))).'">
            <INPUT TYPE=hidden NAME=filter value="'.$_POST['filter'].'"> <INPUT TYPE=submit value="   �   "></form></TD>
            </TR></TABLE></form>';
            if ($_POST['filter']) {
                $perevod = mysql_fetch_array(mysql_query("SELECT login,id,align FROM `users` WHERE `login` = '{$_POST['filter']}' LIMIT 1;"));
                $per_ok=0;
    if ($user['align']>2 && $user['align']<3|| $user['align']==5|| $user['deal']==5) {
                    $per_ok=1;
                }
                $iid=$perevod['id'];
                $logsat=$_POST['logs'];
                if ($per_ok==1) {
                    if (@$_POST["all"]) {
                      $logs = mq("SELECT * FROM archive.`delo` WHERE `pers` = '{$perevod['id']}' ORDER by `id` ASC;");
                    } else {
                      $ddate1=mktime(0, 0, 0, substr($_POST['logs'],3,2), substr($_POST['logs'],0,2), "20".substr($_POST['logs'],6,2));
                      $ddate2=mktime(23, 59, 59, substr($_POST['logs'],3,2), substr($_POST['logs'],0,2), "20".substr($_POST['logs'],6,2));
                      $logs = mysql_query("SELECT * FROM `delo` WHERE `pers` = '{$perevod['id']}' AND `date` > '$ddate1' AND `date` < '$ddate2' ORDER by `id` ASC;");
                    }
                    while($row = @mysql_fetch_array($logs)) {
                        $dat=date("d.m.y H:i",$row['date']);
                        echo "<span class=date>{$dat}</span> {$row['text']}<br>";
                    }
                }

            }
            echo "<hr>";
        }

    if ($user['align']>2 && $user['align']<3|| $user['align']==5|| $user['deal']==5) {
            if ($_POST['putekr']) {
                if (($_POST['ekr']) && ($_POST['bank']) && ($_POST['tonick'])) {
                    $tonick = mysql_fetch_array(mysql_query("SELECT login,id FROM `users` WHERE `login` = '{$_POST['tonick']}' LIMIT 1;"));
                    $bank = mysql_fetch_array(mysql_query("SELECT owner,id FROM `bank` WHERE `id` = '{$_POST['bank']}' LIMIT 1;"));
                    if  (ereg("auto-",$user['login']) || ereg("auto-",$user['login'])) {
                        $botfull=$user['login'];
                        list($bot, $botlogin) = explode("-", $user['login']);
                        $botnick = mysql_fetch_array(mysql_query("SELECT login,id FROM `users` WHERE `login` = '{$botlogin}' LIMIT 1;"));
                        $user['login']=$botnick['login'];
                        $user['id']=$botnick['id'];
                    }
                    if ($bank['owner'] && $tonick['id'] && $bank['owner'] == $tonick['id']) {
                        $_POST['ekr'] = round($_POST['ekr'],2);
                        if (mysql_query("UPDATE `bank` set `ekr` = ekr+'{$_POST['ekr']}' WHERE `id` = '{$_POST['bank']}' LIMIT 1;")) {
                            if ($bot && $botlogin) {
                                mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr) values ('{$_SESSION['uid']}','{$botfull}','{$_POST['bank']}','{$_POST['tonick']}','{$_POST['ekr']}');");
                                mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr) values ('{$user['id']}','{$botfull}','{$_POST['bank']}','{$_POST['tonick']}','{$_POST['ekr']}');");
                            }
                            else {
                                mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr) values ('{$user['id']}','{$user['login']}','{$_POST['bank']}','{$_POST['tonick']}','{$_POST['ekr']}');");
                            }
                            mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$tonick['id']}','�������� ".$_POST['ekr']." ��� �� ���� �".$_POST['bank']." �� ������ ".$user['login']."',1,'".time()."');");
                            $us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$tonick['id']}' LIMIT 1;"));
                            if($us[0]){
                                addchp ('<font color=red>��������!</font> �� ��� ���� �'.$_POST['bank'].' ���������� '.$_POST['ekr'].' ���. �� ������ '.$user['login'].'  ','{[]}'.$_POST['tonick'].'{[]}');
                            } else {
                                // ���� � ���
                                mysql_query("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> �� ��� ���� �'.$_POST['bank'].' ���������� '.$_POST['ekr'].' ���. �� ������ '.$user['login'].'  '."');");
                            }
                            print "<b><font color=red>������� ��������� {$_POST['ekr']} ���. �� ���� {$_POST['bank']} ��������� {$_POST['tonick']}!</font></b>";
                        }
                        else {
                            print "<b><font color=red>��������� ������!</font></b>";
                        }
                    }
                    else {
                        print "<b><font color=red>���� ����� {$_POST['bank']} �� ����������� ��������� {$_POST['tonick']}!</font></b>";
                    }
                }
                else {
                    print "<b><font color=red>������� �����, ����� ����� � ��� ���������!</font></b>";
                }
            }
            if ($_POST['komotdel']) {
                if ($_POST['komlog'] && $_POST['price']) {
                    $_POST['price'] = round($_POST['price'],2);
                    $tonick = mysql_fetch_array(mysql_query("SELECT login,id,align,klan FROM `users` WHERE `login` = '{$_POST['komlog']}' LIMIT 1;"));
                    if  (ereg("auto-",$user['login']) || ereg("auto-",$user['login'])) {
                        $botfull=$user['login'];
                        list($bot, $botlogin) = explode("-", $user['login']);
                        $botnick = mysql_fetch_array(mysql_query("SELECT login,id FROM `users` WHERE `login` = '{$botlogin}' LIMIT 1;"));
                        $user['login']=$botnick['login'];
                        $user['id']=$botnick['id'];
                    }
                    if ($tonick['login']) {
                        if ($bot && $botlogin) {
                            mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['komlog']}','{$_POST['price']}','5');");
                            mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$botfull}','0','{$_POST['komlog']}','{$_POST['price']}','5');");
                        }
                        else {
                            mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['komlog']}','{$_POST['price']}','5');");
                        }
                        mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$tonick['id']}','&quot;".$_POST['komlog']."&quot; �������� ������ � ����. ����� ����� ������ ".$user['login']."  ',1,'".time()."');");
                        mysql_query("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tonick['id']."','&quot;".$_POST['komlog']."&quot; �������� ������ � ����. ����� ����� ������ &quot;".$user['login']."&quot;  ','".time()."');");
                        print "<b><font color=red>������ � ����. ����� {$_POST['price']} ���. ��� ��������� {$_POST['komlog']} ����������� �������!</font></b>";
                    }
                    else {
                        print "<b><font color=red>����� �������� �� ����������!</font></b>";
                    }
                }
            }
            if ($_POST['obraz']) {
                if ($_POST['obrazlog']) {
                    $tonick = mysql_fetch_array(mysql_query("SELECT login,id,align,klan FROM `users` WHERE `login` = '{$_POST['obrazlog']}' LIMIT 1;"));
                    if  (ereg("auto-",$user['login']) || ereg("auto-",$user['login'])) {
                        $botfull=$user['login'];
                        list($bot, $botlogin) = explode("-", $user['login']);
                        $botnick = mysql_fetch_array(mysql_query("SELECT login,id FROM `users` WHERE `login` = '{$botlogin}' LIMIT 1;"));
                        $user['login']=$botnick['login'];
                        $user['id']=$botnick['id'];
                    }
                    if ($tonick['login']) {
                        if ($bot && $botlogin) {
                            mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['obrazlog']}','100','6');");
                            mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$botfull}','0','{$_POST['obrazlog']}','100','6');");
                        }
                        else {
                            mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['obrazlog']}','100','6');");
                        }
                        mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$tonick['id']}','&quot;".$_POST['obrazlog']."&quot; ������� ������ ����� ����� ������ ".$user['login']."',1,'".time()."');");
                        mysql_query("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tonick['id']."','&quot;".$_POST['obrazlog']."&quot; ������� ������ ����� ����� ������ &quot;".$user['login']."&quot;  ','".time()."');");
                        print "<b><font color=red>������ ������� ������ ��� ��������� {$_POST['obrazlog']} ����������� �������!</font></b>";
                    }
                    else {
                        print "<b><font color=red>����� �������� �� ����������!</font></b>";
                    }
                }
            }
            if ($_POST['openbank']) {
                if ($_POST['charlog']) {
                    $tonick = mysql_fetch_array(mysql_query("SELECT login,id,money FROM `users` WHERE `login` = '{$_POST['charlog']}' LIMIT 1;"));
                    if  (ereg("auto-",$user['login']) || ereg("auto-",$user['login'])) {
                        $botfull=$user['login'];
                        list($bot, $botlogin) = explode("-", $user['login']);
                        $botnick = mysql_fetch_array(mysql_query("SELECT login,id FROM `users` WHERE `login` = '{$botlogin}' LIMIT 1;"));
                        $user['login']=$botnick['login'];
                        $user['id']=$botnick['id'];
                    }
                    if ($tonick['login']) {
                        if (mysql_query("UPDATE `users` set `money` = `money`+'0.5' WHERE `id` = '{$tonick['id']}' LIMIT 1;")) {
                            mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$tonick['id']}','�������� 0.5 ��. �� �������� ����� � ����� �� ������ ".$user['login']."',1,'".time()."');");
                            print "<b><font color=red>������� ���������� 0.5 �� ��������� {$_POST['charlog']}!</font></b>";
                        }
                        else {
                            print "<b><font color=red>��������� ������!</font></b>";
                        }
                    }
                    else {
                        print "<b><font color=red>����� �������� �� ����������!</font></b>";
                    }
                }
            }

            if ($_POST['givesklonka']) {
                if ($_POST['sklonkalog'] && $_POST['sklonka']) {
                    $tonick = mysql_fetch_array(mysql_query("SELECT login,id,align,klan FROM `users` WHERE `login` = '{$_POST['sklonkalog']}' LIMIT 1;"));
                    if  (ereg("auto-",$user['login']) || ereg("auto-",$user['login'])) {
                        $botfull=$user['login'];
                        list($bot, $botlogin) = explode("-", $user['login']);
                        $botnick = mysql_fetch_array(mysql_query("SELECT login,id FROM `users` WHERE `login` = '{$botlogin}' LIMIT 1;"));
                        $user['login']=$botnick['login'];
                        $user['id']=$botnick['id'];
                    }
                    if ($tonick['login']) {
                        if ($tonick['align'] || $tonick['klan']) {
                            print "<b><font color=red>�������� ��� ����� ���������� ���� ������� � �����!</font></b>";
                        }
                        else {
                            if (mysql_query("UPDATE `users` set `align` = '{$_POST['sklonka']}' WHERE `id` = '{$tonick['id']}' LIMIT 1;")) {
                                if ($_POST['sklonka'] == 7) {$skl="�����������"; $skl2="�����������";}
                                else {$skl="������"; $skl2="������";}
                                if ($bot && $botlogin) {
                                    mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['sklonkalog']}','0',{$_POST['sklonka']});");
                                    mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$botfull}','0','{$_POST['sklonkalog']}','0',{$_POST['sklonka']});");
                                }
                                else {
                                    mysql_query("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['sklonkalog']}','0',{$_POST['sklonka']});");
                                }
                                mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$tonick['id']}','������� ".$skl." ���������� �� ������ ".$user['login']."',1,'".time()."');");
                                if ($user['sex'] == 1) {$action="��������";}
                                else {$action="���������";}
                                mysql_query("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tonick['id']."','����� &quot;".$user['login']."&quot; ".$action." &quot;".$_POST['sklonkalog']."&quot; ".$skl2." ����������','".time()."');");
                                print "<b><font color=red>������� ���������  {$skl} ���������� ��������� {$_POST['sklonkalog']}!</font></b>";
                            }
                            else {
                                print "<b><font color=red>��������� ������!</font></b>";
                            }
                        }
                    }
                    else {
                        print "<b><font color=red>����� �������� �� ����������!</font></b>";
                    }
                }
            }

            echo "<h4>��������� ������</h4><form method=post action=\"a.php\"><b>��������� ���� �� ���� </b>
                <table><tr><td>������� ����� </td><td><input type='text' name='ekr' value=''></td><td> ����� ����� <input type='text' name='bank' value=''></td><td> ��� ��������� <input type='text' name='tonick' value=''></td><td><input type=submit name=putekr value='���������'></td></tr></table>";
            echo "<br><form method=post action=\"a.php\"><b>��������� ����� / ����� ����� </b>
                <table><tr><td>����� </td><td><input type='text' name='charlogin' value=''></td><td> ����� ����� <input type='text' name='charbank' value=''></td><td><input type=submit name=checkbank value='���������'></td></tr></table>";
            echo "<br><form method=post action=\"a.php\"><b>�������� ������ �� �������� �����</b>
                <table><tr><td>����� </td><td><input type='text' name='charlog' value=''></td><td></td><td><input type=submit name=openbank value='��������'></td></tr></table>";
            echo "<br><form method=post action=\"a.php\"><b>��������� ����������</b>
                <table><tr><td>����� </td><td><input type='text' name='sklonkalog' value=''></td><td>���������� <select name='sklonka'>
                    <option value='0'></option>
                    <option value='2'>�����������</option>
                    <option value='0.98'>������</option></select><td><input type=submit name=givesklonka value='���������'></td></tr></table>";
            echo "<br><form method=post action=\"a.php\"><b>�������� � ���.�����</b>
                <table><tr><td>����� </td><td><input type='text' name='komlog' value=''></td><td>������� ����� <input type='text' name='price' value=''></td><td><input type=submit name=komotdel value='��������'></td></tr></table>";
            echo "<br><form method=post action=\"a.php\"><b>�������� ������ �����</b>
                <table><tr><td>����� </td><td><input type='text' name='obrazlog' value=''></td><td></td><td><input type=submit name=obraz value='��������'></td></tr></table>";

            if ($_POST['checkbank']) {
                if ($_POST['charlogin']) {
                    $tonick = mysql_fetch_array(mysql_query("SELECT login,id FROM `users` WHERE `login` = '{$_POST['charlogin']}' LIMIT 1;"));
                    $bankdb = mysql_query("SELECT owner,id FROM `bank` WHERE `owner` = '{$tonick['id']}'");
                    print "��������� {$_POST['charlogin']} ����������� �����: <br>";
                    while ($bank=mysql_fetch_array($bankdb)) {
                        print "� {$bank['id']} <br>";
                    }
                }
                else if  ($_POST['charbank']) {
                    $bank = mysql_fetch_array(mysql_query("SELECT owner,id FROM `bank` WHERE `id` = '{$_POST['charbank']} 'LIMIT 1;"));
                    $tonick = mysql_fetch_array(mysql_query("SELECT login,id FROM `users` WHERE `id` = '{$bank['owner']}' LIMIT 1;"));
                    print "���� � {$_POST['charbank']} ����������� ��������� {$tonick['login']} <br>";
                }
            }
            echo "<hr>";
            if (!$_POST['dlogs']) {$_POST['dlogs']=date("d.m.y");}

    if ($user['align']>2 && $user['align']<3|| $user['align']==5|| $user['deal']==5) {
            echo '<TABLE><TR><TD colspan=3><FORM METHOD=POST ACTION=a.php>
            ����������� ������� � ������: �� <INPUT TYPE=text NAME=dlogs size=12 value="'.$_POST['dlogs'].'"> <INPUT TYPE=submit name="berfilter" value="�����������!"></form></TD>
            </tr><tr><td><FORM METHOD=POST ACTION=a.php><INPUT TYPE=hidden NAME=berfilter value="1">
            <INPUT TYPE=hidden NAME=dlogs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['dlogs'],3,2), substr($_POST['dlogs'],0,2)-1, "20".substr($_POST['dlogs'],6,2))).'">
            <INPUT TYPE=submit value="   �   "></form></TD>
            <TD valign=top align=center>������� � ������ ��  <b>'.$_POST['dlogs'].'</b></TD>
            <TD><FORM METHOD=POST ACTION=a.php><INPUT TYPE=hidden NAME=dlogs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['dlogs'],3,2), substr($_POST['dlogs'],0,2)+1, "20".substr($_POST['dlogs'],6,2))).'">
            <INPUT TYPE=hidden NAME=dfilter value="'.$_POST['dfilter'].'"> <INPUT TYPE=submit value="   �   "></form></TD>
            </TR></TABLE></form>';

            if ($_POST['berfilter']) {
              $r=mq("select sum(berlog.qty) as qty, berezka.name, berezka.ecost as cost, berezka.name from berlog left join berezka on berezka.id=berlog.item where berlog.dat='20".substr($_POST['dlogs'],6,2)."-".substr($_POST['dlogs'],3,2)."-".substr($_POST['dlogs'],0,2)."' group by berlog.item");
              echo "<table>
              <tr>
              <td><b>�������</b></td>
              <td><b>����</b></td>
              <td><b>�����</b></td></tr>";
              while ($rec=mysql_fetch_assoc($r)) {
                echo "<tr><td>$rec[name]</td><td align=\"center\">$rec[qty]</td><td align=\"center\">".($rec["qty"]*$rec["cost"])."</td></tr>";
              }
              echo "</table>";
            }
            echo '<TABLE><TR><TD colspan=3><FORM METHOD=POST ACTION=a.php>
            ����������� ��������� �������� ���������: <INPUT TYPE=text NAME=dfilter value="'.$_POST['dfilter'].'"> �� <INPUT TYPE=text NAME=dlogs size=12 value="'.$_POST['dlogs'].'"> <INPUT TYPE=submit value="�����������!"></form></TD>
            </tr><tr><td><FORM METHOD=POST ACTION=a.php><INPUT TYPE=hidden NAME=dfilter value="'.$_POST['dfilter'].'">
            <INPUT TYPE=hidden NAME=dlogs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['dlogs'],3,2), substr($_POST['dlogs'],0,2)-1, "20".substr($_POST['dlogs'],6,2))).'">
            <INPUT TYPE=submit value="   �   "></form></TD>
            <TD valign=top align=center>��������� �������� ��������� <b>"'.$_POST['dfilter'].'"</b> ��  <b>'.$_POST['dlogs'].'</b></TD>
            <TD><FORM METHOD=POST ACTION=a.php><INPUT TYPE=hidden NAME=dlogs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['dlogs'],3,2), substr($_POST['dlogs'],0,2)+1, "20".substr($_POST['dlogs'],6,2))).'">
            <INPUT TYPE=hidden NAME=dfilter value="'.$_POST['dfilter'].'"> <INPUT TYPE=submit value="   �   "></form></TD>
            </TR></TABLE></form>';
            }
            elseif ($user['deal']==1|| $user['deal']==5) {
            echo '<TABLE><TR><TD colspan=3><FORM METHOD=POST ACTION=a.php>
            ����������� ��������� �������� <INPUT TYPE=hidden NAME=dfilter value="'.$user['login'].'">�� <INPUT TYPE=text NAME=dlogs size=12 value="'.$_POST['dlogs'].'"> <INPUT TYPE=submit value="�����������!"></form></TD>
            </tr><tr><td><FORM METHOD=POST ACTION=a.php><INPUT TYPE=hidden NAME=dfilter value="'.$_POST['dfilter'].'">
            <INPUT TYPE=hidden NAME=dlogs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['dlogs'],3,2), substr($_POST['dlogs'],0,2)-1, "20".substr($_POST['dlogs'],6,2))).'">
            <INPUT TYPE=submit value="   �   "></form></TD>
            <TD valign=top align=center>��������� �������� ��������� <b>"'.$_POST['dfilter'].'"</b> ��  <b>'.$_POST['dlogs'].'</b></TD>
            <TD><FORM METHOD=POST ACTION=a.php><INPUT TYPE=hidden NAME=dlogs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['dlogs'],3,2), substr($_POST['dlogs'],0,2)+1, "20".substr($_POST['dlogs'],6,2))).'">
            <INPUT TYPE=hidden NAME=dfilter value="'.$_POST['dfilter'].'"> <INPUT TYPE=submit value="   �   "></form></TD>
            </TR></TABLE></form>';
            }
            if ($_POST['dfilter']) {
                $perevod1 = mysql_fetch_array(mysql_query("SELECT `login`,`id`,`align` FROM `users` WHERE `login` = '{$_POST['dfilter']}' LIMIT 1;"));
                $aa=$perevod1['id'];
    if ($user['align']>2 && $user['align']<3|| $user['align']==5) {
                    $logsat=$_POST['dlogs'];
                    $ddate33="20".substr($_POST['dlogs'],6,2)."-".substr($_POST['dlogs'],3,2)."-".substr($_POST['dlogs'],0,2)."";
                    $dlogs = mysql_query("SELECT * FROM `dilerdelo` WHERE `dilerid` = '{$perevod1['id']}' AND `date` like '$ddate33%' ORDER by `id` ASC;");
                    while($row = @mysql_fetch_array($dlogs)) {
                        switch($row['addition']) {
                            case "2":
                                $sklo="�����������";
                                echo "<span class=date>{$row['date']}</span> ������� {$sklo} ���������� ���������  {$row['owner']} (50 ���.)<br>";
                                break;
                            case "3":
                                $sklo="������";
                                echo "<span class=date>{$row['date']}</span> ������� {$sklo} ���������� ���������  {$row['owner']} (50 ���.)<br>";
                                break;
                            case "5":
                                echo "<span class=date>{$row['date']}</span> ���������� {$row['ekr']} ���. � �������� ��� ��������� {$row['owner']} <br>";
                                break;
                            case "6":
                                echo "<span class=date>{$row['date']}</span> ������� ������ ����� ��� ��������� {$row['owner']} (100 ���.)<br>";
                                break;
                            case "0":
                                echo "<span class=date>{$row['date']}</span> ���������� {$row['ekr']} ���. ���������  {$row['owner']} (���� �{$row['bank']})<br>";
                                break;
                        }
                    }
                }
            }
        }

    if ($user['align']>2 && $user['align']<3|| $user['align']==5|| $user['deal']==5) {
            echo "<form method=post><fieldset><legend>IP</legend>
                    <table><tr><td>�����</td><td><input type='text' name='ip' value='",$_POST['ip'],"'></td><td><input type=submit value='���������� IP'></td></tr>
                    <tr><td>IP</td><td><input type='text' name='ipfull' value='",$_POST['ipfull'],"'></td><td><input type=submit value='���������� ����'></td></tr></table>";
            if ($_POST['ip']) {
                $dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['ip']."';"));
                echo "<font color=red>",$dd[1]," - ",$dd[0],"</font><BR>";
            }elseif($_POST['ipfull']) {
                $data = mysql_query("SELECT `ip`, `login` FROM `users` WHERE `ip` = '".$_POST['ipfull']."';");
                while($dd=mysql_fetch_array($data)) {
                    echo "<font color=red>",$dd[1]," - ",$dd[0],"</font><BR>";
                }
            }
            echo "</fieldset></form>";
        }

    if ($user['align']>2 && $user['align']<3) {
                echo "<form method=post><fieldset><legend>�������� ������</legend>
                    <table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������</td><td><input type='text' name='status' value='",$_POST['status'],"'></td><td><input type=submit value='�������� ������'></td></tr></table>";
                if ($_POST['login'] && $_POST['status']) {
                    $dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
                    if($dd) {
                        mysql_query("UPDATE `users` SET `status` = '".$_POST['status']."' WHERE `login` = '".$_POST['login']."';");
                        echo "<font color=red>������ ",$dd[1]," ������� �� ",$_POST['status'],"</font><BR>";
                    }
                }
}
                echo "</fieldset></form>";
 if ($user['admin']>1) {

      if (@$_POST["blockips"]) {
        $f=fopen("blockips.txt","wb");
        $_POST["blockips"]=str_replace("\\n","\r\n",$_POST["blockips"]);
        fwrite($f, $_POST["blockips"]);
      
      echo "<input type=\"submit\" value=\"��������� ����\" onclick=\"document.location.href='a.php?backupdb=1'\">";
                echo "<form action=\"a.php\" method=\"post\">
                <textarea name=\"blockips\" style=\"width:200px;height:150px\">".implode("",file("blockips.txt"))."</textarea>
                <br><input type=submit value=\"����������� IP\">
                </form>
                <form action=\"a.php\" method=\"post\">
                <input type=\"hidden\" name=\"todo\" value=\"takemoney\">
                <table>
                <tr><td align=right>���:</td><td><input type=\"text\" name=\"login\" value=\"$_POST[login]\"></td></tr>
                <tr><td align=right>�����:</td><td><input type=\"text\" name=\"sum\" value=\"$_POST[sum]\"></td></tr>
                <tr><td align=right>�������:</td><td><input type=\"text\" name=\"reason\" value=\"$_POST[reason]\"></td></tr>
                </table>
                <br><input type=submit value=\"�������� �����\">
                </form>";
   }
}
 if ($user['align']>2 && $user['align']<3) {
               echo "<form method=post><fieldset><legend>������� � ����� / �������� �����</legend>
                    <table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td></tr>
                    <tr><td>�����</td><td><select name='krest'>
                    <option value='1.1'>������� ����������</option>
                    <option value='1.2'>����������</option>
                    <option value='1.4'>���������� �������</option>
                    <option value='1.5'>������� ��������� ������</option>
                    <option value='1.7'>������� �������� ����</option>
                    <option value='1.75'>��������� ������</option>
                    <option value='1.9'>������� ����</option>
                    <option value='1.91'>������� ������� ����</option>
                    <option value='1.92'>������� ������</option>";
                if (($user['align'] == '2.5') || ($user['align']=='2.6')) {
                    echo "<option value='1.99'>��������� �������</option>";
                }

                echo "</select></td></tr>
                    <tr><td><input type=submit value='���������'></td></tr></table>";
                echo "</fieldset></form>";
                if ($_POST['login'] && $_POST['krest']) {
                    switch($_POST['krest']){
                        case 1.1:
                            $rang = '������� ����������';
                        break;
                        case 1.2:
                            $rang = '����������';
                        break;
                        case 1.4:
                            $rang = '���������� �������';
                        break;
                        case 1.5:
                            $rang = '������� ��������� ������';
                        break;
                        case 1.7:
                            $rang = '������� �������� ����';
                        break;
                        case 1.75:
                            $rang = '��������� ������';
                        break;
                        case 1.9:
                            $rang = '������� ����';
                        break;
                        case 1.91:
                            $rang = '������� �������� ����';
                        break;
                        case 1.92:
                            $rang = '������� ������';
                        break;
                        case 1.99:
                            $rang = '��������� �������';
                        break;
                    }
                    $dd = mysql_fetch_array(mysql_query("SELECT `id`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
                    if ($user['sex'] == 1) {$action="��������";}
                        else {$action="���������";}
                        if ($user['align'] > '2' && $user['align'] < '3')  {
                            $angel="�����";
                        }
                        elseif ($user['align'] > '1' && $user['align'] < '2') {
                            $angel="�������";
                        }
                    if($dd) {

                        mysql_query("UPDATE `users` SET `align` = '".$_POST['krest']."',`status` = '$rang' WHERE `login` = '".$_POST['login']."';");
                        $target=$_POST['login'];
                        $mess="$angel &quot;{$user['login']}&quot; $action &quot;$target&quot; ������ $rang";
                        mysql_query("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$dd['id']."','$mess','".time()."');");
                        mysql_query("INSERT INTO `paldelo`(`id`,`author`,`text`,`date`) VALUES ('','".$_SESSION['uid']."','$mess','".time()."');");


                    }
                }
        }
    if ($user['align']>2 && $user['align']<3) {
                echo "<form method=post><fieldset><legend>������� � ������ / �������� ���������</legend>
                    <table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td></tr>
                    <tr><td>���������</td><td><select name='tarmanka'>
                    <option value='3.01'>������-���������</option>
                    <option value='3.05'>������-�����������</option>
                    <option value='3.07'>������-������</option>
                    <option value='3.09'>������-�����</option>
                    <option value='3.091'>������-�������</option>
                    <option value='3.06'>��������</option>
                    <option value='3.075'>��������-13</option>
                    <option value='3.092'>������� ������</option>";
                if (($user['align'] == '2.5') || ($user['align']=='2.6')) {
                    echo "<option value='3.99'>��������</option>";
                }

                echo "</select></td></tr>
                    <tr><td><input type=submit value='���������'></td></tr></table>";
                echo "</fieldset></form>";
                if ($_POST['login'] && $_POST['tarmanka']) {
                    switch($_POST['tarmanka']){
                        case 3.01:
                            $rang = '������-���������';
                        break;
                        case 3.05:
                            $rang = '������-�����������';
                        break;
                        case 3.07:
                            $rang = '������-������';
                        break;
                        case 3.09:
                            $rang = '������-�����';
                        break;
                        case 3.091:
                            $rang = '������-�������';
                        break;
                        case 3.06:
                            $rang = '��������';
                        break;
                        case 3.075:
                            $rang = '��������-13';
                        break;
                        case 3.092:
                            $rang = '������� ������';
                        break;
                        case 3.99:
                            $rang = '��������';
                        break;
                    }
                    $dd = mysql_fetch_array(mysql_query("SELECT `id`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
                    if ($user['sex'] == 1) {$action="��������";}
                        else {$action="���������";}
                        if ($user['align'] > '2' && $user['align'] < '3')  {
                            $angel="�����";
                        }
                        elseif ($user['align'] > '1' && $user['align'] < '2') {
                            $angel="�������";
                        }
                    if($dd) {

                        mysql_query("UPDATE `users` SET `align` = '".$_POST['tarmanka']."',`status` = '$rang' WHERE `login` = '".$_POST['login']."';");
                        $target=$_POST['login'];
                        $mess="$angel &quot;{$user['login']}&quot; $action &quot;$target&quot; ������ $rang";
                        mysql_query("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$dd['id']."','$mess','".time()."');");
                        mysql_query("INSERT INTO `paldelo`(`id`,`author`,`text`,`date`) VALUES ('','".$_SESSION['uid']."','$mess','".time()."');");


                    }
                }
     if ($user['admin']==1)  {
include "a1.php";
}
        }

include "zaschita/razblock.php";

    if ($user['align']>2 && $user['align']<3) {
if ($_POST['sbr_par']) {
    $sb_pers = mysql_fetch_array(mysql_query("SELECT id,nextup,level FROM `users` WHERE `login` = '{$_POST['sbr_par']}' LIMIT 1;"));
    undressall($sb_pers['id']);

    $levelstats=statsat($sb_pers['nextup']);
    mq("delete from effects where (sila<>0 or lovk<>0 or inta<>0 or vinos<>0 or intel<>0) and owner='$sb_pers[id]'");
    mq("delete from obshagaeffects where (sila<>0 or lovk<>0 or inta<>0 or vinos<>0 or intel<>0) and owner='$sb_pers[id]'");
    mq("UPDATE `users` SET `stats` = ".($levelstats['stats']-9).", `sila`=3,`lovk`=3,`inta`=3,`mudra`=0,`intel`=0,`spirit`= ".$levelstats["spirit"].", sexy=0,`vinos`= ".$levelstats["vinos"].",`maxhp`= ".$levelstats["vinos"]."*6,`maxmana`= 0,`mana`= 0 WHERE `id`='$sb_pers[id]' LIMIT 1");
    mq("UPDATE `userdata` SET `stats` = ".($levelstats['stats']-9).", `sila`=3,`lovk`=3,`inta`=3,`mudra`=0,`intel`=0,`spirit`= ".$levelstats["spirit"].", sexy=0,`vinos`= ".$levelstats["vinos"]." WHERE `id`='$sb_pers[id]' LIMIT 1");

//mysql_query("DELETE FROM `effects` WHERE `owner` = '".$sb_pers['id']."' and `type`=188");
            //if (mysql_query("UPDATE `users` SET `stats` = ".$expstats[$sb_pers['nextup']].", `sila`=3,`lovk`=3,`inta`=3,`mudra`=0,`intel`=0,`spirit`=0,`vinos`= ".$vinoslvl[$sb_pers['level']].",`maxhp`= ".$vinoslvl[$sb_pers['level']]."*6,`maxmana`= 0,`mana`= 0 WHERE `id`= ".(int)$sb_pers['id']." LIMIT 1;")) {
                echo "<font color=red>��� ������ ������. �������� ����� ���������������� ���������.</font>";
                /*}
            else echo "<font color=red>��������� ������!</font>";*/

    }
if ($_POST['zaderz_del1']) { if (mq("delete from effects where type=9;")) {echo "<font color=red><b>��� ������ �������</b></font>";} else {echo "<font color=red><b>��� �� �� �����</b></font>";} }
if ($_POST['res_user1']) { $res_pers1 = mysql_fetch_array(mysql_query("SELECT id FROM `allusers` WHERE `id` = '{$_POST['res_user1']}' LIMIT 1;")); restoreuser($res_pers1['id']); }
if ($_POST['cler_user1']) { $cler_pers1 = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE `id` = '{$_POST['cler_user1']}' LIMIT 1;")); clearuser($cler_pers1['id']); }
if ($_POST['zaderz_del2']) { if (mq("delete from effects where type=9 and owner  = '{$_POST['zaderz_del2']}';")) {echo "<font color=red><b>��� ������ �������</b></font>";} else {echo "<font color=red><b>��� �� �� �����</b></font>";} }
?>
<br><fieldset>
<legend style='font-weight:bold; color:#8F0000;'>����� ���������� ���������</legend>
<form method=post>�����: <input type=text name='sbr_par'> <input type=submit value='��������� ���������'></form>
</fieldset><br><br>
<?}     if ($user['admin']==1)  {?>
<br><fieldset>
<legend style='font-weight:bold; color:#8F0000;'>��������� ��������</legend>
<INPUT TYPE=button onClick="window.open('/functions/dobavitj_vesh_magazins.php', 'dobavitj_vesh', 'location=yes,menubar=yes,status=yes,resizable=yes,toolbar=yes,scrollbars=yes,scrollbars=yes')" class="btn" style="border: 1px double #9a9996;font-size: 12px;color: #dfdfdf;background-color:#504F4C;" value="�������� ���� � �������">
<INPUT TYPE=button onClick="window.open('/functions/dobavitj_vesh_berezkas.php', 'dobavitj_vesh', 'location=yes,menubar=yes,status=yes,resizable=yes,toolbar=yes,scrollbars=yes,scrollbars=yes')" class="btn" style="border: 1px double #9a9996;font-size: 12px;color: #dfdfdf;background-color:#504F4C;" value="�������� ���� � �������">
<form method=post><input type=submit name='zaderz_del1' value='������� �������� �� ���� � ����'></form>
<!--form method=post>ID ���������: <input type=text name='res_user1'> <input type=submit value='������������ ���������'></form-->
<form method=post>ID ���������: <input type=text name='cler_user1'> <input type=submit value='��������� ���������'></form>
<INPUT TYPE=button onClick="window.open('adminion.php', 'dobavitj_vesh', 'location=yes,menubar=yes,status=yes,resizable=yes,toolbar=yes,scrollbars=yes,scrollbars=yes')" class="btn" style="border: 1px double #9a9996;font-size: 12px;color: #dfdfdf;background-color:#504F4C;" value="����� ������">
<form method=post>ID: <input type=text name='zaderz_del2'> <input type=submit value='������� �������� �� ����'></form> <form method=post>��������: <input type=text name='zaderz_del31232'> <input type=submit value='������� ����'></form>
</fieldset><br>
<? include "p123.php"; } ?>
</body>
</html>
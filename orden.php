<?php
    session_start();
    if ($_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    $user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
    include "functions.php";
    $al = mysql_fetch_assoc(mq("SELECT * FROM `aligns` WHERE `align` = '{$user['align']}' LIMIT 1;"));
    if (($user['align']<0.97 || $user['align']>10) && !in_array($_SESSION['uid'], $smalladms)) {
      header("Location: main.php");
      die;
    }
?><html><head>
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<link rel=stylesheet type="text/css" href="i/main.css">
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
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><form action="orden.php" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    '������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD align=left><INPUT TYPE=text id="'+name+'" NAME="'+name+'">'+
    '<select style="background-color:#eceddf; color:#000000;" name="timer"><option value=15>15 ���<option value=30>30 ���<option value=60>1 ���'+
    '<option value=180>3 ����<option value=360>6 �����<option value=720>12 �����<option value=1440>�����</select>'+
    '</TD><TD width=30><INPUT TYPE="submit" value=" �� "></TD></TR></FORM></TABLE></td></tr></table>';
    document.getElementById("hint3").style.visibility = "visible";
    document.getElementById("hint3").style.left = 100;
    document.getElementById("hint3").style.top = 100;
    document.getElementById(name).focus();
    Hint3Name = name;
}

function runmagicf(title, magic, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><form action="orden.php" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    '������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD align=left><INPUT TYPE=text id="'+name+'" NAME="'+name+'">'+
    '<select style="background-color:#eceddf; color:#000000;" name="timer"><option value=15>15 ���<option value=30>30 ���<option value=60>1 ���'+
    '<option value=180>3 ����<option value=360>6 �����<option value=720>12 �����<option value=1440>�����<option value=4320>3 �����<option value=10080>������</select>'+
    '</TD><TD width=30><INPUT TYPE="submit" value=" �� "></TD></TR></FORM></TABLE></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}

function runmagict(title, magic, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><form action="orden.php" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    '������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD align=left><INPUT TYPE=text id="'+name+'" NAME="'+name+'">'+
    ' �����:<input type=text size=4 name=takeekr>'+
    '</TD><TD width=30><INPUT TYPE="submit" value=" �� "></TD></TR></FORM></TABLE></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}


function runmagic1(title, magic, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<form action="orden.php" method=POST><table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    '������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD align=left><INPUT TYPE=text id="'+name+'" NAME="'+name+'">'+
    '</TD><TD width=30><INPUT TYPE="submit" value=" >> "></TD></TR></TABLE></FORM></td></tr></table>';
    document.getElementById("hint3").style.visibility = "visible";
    document.getElementById("hint3").style.left = 100;
    document.getElementById("hint3").style.top = 100;
    document.getElementById(name).focus();
    Hint3Name = name;
}

function runmagic5(title, magic, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<form action="orden.php" method=POST><table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    '������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD align=left><INPUT TYPE=text id="'+name+'" NAME="'+name+'">'+
    ' �-��: <input type=text name=qty size=1></TD><TD width=30><INPUT TYPE="submit" value=" �� "></TD></TR></TABLE></FORM></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}

function runmagic2(title, magic, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><form action="orden.php" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    '������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD align=left><INPUT TYPE=text id="'+name+'" NAME="'+name+'">'+
    '<select style="background-color:#eceddf; color:#000000;" name="timer"><option value=2>2 ���<option value=3>3 ���<option value=7>������<option value=14>2 ������'+
    '<option value=30>1 �����<option value=60>2 ������<option value=365>���������</select>'+
    '</TD><TD width=30><INPUT TYPE="submit" value=" �� "></TD></TR></FORM></TABLE></td></tr></table>';
    document.getElementById("hint3").style.visibility = "visible";
    document.getElementById("hint3").style.left = 100;
    document.getElementById("hint3").style.top = 100;
    document.getElementById(name).focus();
    Hint3Name = name;
}

function runmagic3(title, magic, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><form action="orden.php" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    '������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD align=left><INPUT TYPE=text id="'+name+'" NAME="'+name+'">'+
    '<br>�������: <INPUT TYPE=text size=25 NAME="palcom"></TD><TD width=30><INPUT TYPE="submit" value=" �� "></TD></TR></FORM></TABLE></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}
function runmagic4(title, magic, name, name1){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td><form action="orden.php" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+
    '������� ����� ������: <INPUT TYPE=text id="'+name+'" NAME="'+name+'">'+
    '<br>������� ����� �������: <INPUT TYPE=text NAME="'+name1+'">'+
    '<br><center><INPUT TYPE="submit" value=" �� "></center></TD></TR></FORM></TABLE></td></tr></table>';
    document.getElementById("hint3").style.visibility = "visible";
    document.getElementById("hint3").style.left = 100;
    document.getElementById("hint3").style.top = 100;
    document.getElementById(name).focus();
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
    document.getElementById("hint3").style.visibility="hidden";
    Hint3Name='';
}
</SCRIPT>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=0 marginheight=0 bgcolor=#e2e0e0 >
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

 if ($_POST['name']) {
    if (mq("insert into shop (name,duration,maxdur,cost,nlevel,nsila,nlovk,ninta,nvinos,nintel,nmudra,nnoj,ntopor,ndubina,nmech,nalign,minu,maxu,gsila,glovk,ginta,gintel,ghp,mfkrit,mfakrit,mfuvorot,mfauvorot,gnoj,gtopor,gdubina,gmech,img,count,bron1,bron2,bron3,bron4,magic,type,massa,needident,nfire,nwater,nair,nearth,nlight,ngray,ndark,gfire,gwater,gair,gearth,glight,ggray,gdark,letter,isrep,razdel) values ('".$_POST['name']."','".$_POST['duration']."','".$_POST['maxdur']."','".$_POST['cost']."','".$_POST['nlevel']."','".$_POST['nsila']."','".$_POST['nlovk']."','".$_POST['ninta']."','".$_POST['nvinos']."','".$_POST['nintel']."','".$_POST['nmudra']."','".$_POST['nnoj']."','".$_POST['ntopor']."','".$_POST['ndubina']."','".$_POST['nmech']."','".$_POST['nalign']."','".$_POST['minu']."','".$_POST['maxu']."','".$_POST['gsila']."','".$_POST['glovk']."','".$_POST['ginta']."','".$_POST['gintel']."','".$_POST['ghp']."','".$_POST['mfkrit']."','".$_POST['mfakrit']."','".$_POST['mfuvorot']."','".$_POST['mfauvorot']."','".$_POST['gnoj']."','".$_POST['gtopor']."','".$_POST['gdubina']."','".$_POST['gmech']."','".$_POST['img']."','".$_POST['count']."','".$_POST['bron1']."','".$_POST['bron2']."','".$_POST['bron3']."','".$_POST['bron4']."','".$_POST['magic']."','".$_POST['type']."','".$_POST['massa']."','".$_POST['needident']."','".$_POST['nfire']."','".$_POST['nwater']."','".$_POST['nair']."','".$_POST['nearth']."','".$_POST['nlight']."','".$_POST['ngray']."','".$_POST['ndark']."','".$_POST['gfire']."','".$_POST['gwater']."','".$_POST['gair']."','".$_POST['gearth']."','".$_POST['glight']."','".$_POST['ggray']."','".$_POST['gdark']."','".$_POST['letter']."','".$_POST['isrep']."','".$_POST['razdel']."');"))
    {
    echo "OK";
    }
else { echo "NO";}

 }
?>
<?php
    if ($user['align'] == '0.99') {
        if ($user['sex'] == 1) {
            echo "<h3>����������� � ����, ������ {$user['login']}!</h3>
            ";
        }
        else {
            echo "<h3>����������� � ����, ������ {$user['login']}!</h3>
            ";
        }
    }
    if ($user['align'] == '7') {
        if ($user['sex'] == 1) {
            echo "<h3>������ � ����, ������ {$user['login']}!</h3>
            ";
        }
        else {
            echo "<h3>������ � ����, ������ {$user['login']}!</h3>
            ";
        }
    }
    if ($user['align'] == '10' OR $user['login']==MadMoronMan) {
        if ($user['sex'] == 1) {
            echo "<h3>MadMoronMan � ����, ������ {$user['login']}!</h3>
            ";
        }
        else {
            echo "<h3>MadMoronMan � ����, ������ {$user['login']}!</h3>
            ";
        }
    }
    if ($user['align'] == '3') {
        if ($user['sex'] == 1) {
            echo "<h3>�������� � ����, ������ {$user['login']}!</h3>
            ";
        }
        else {
            echo "<h3>�������� � ����, ������ {$user['login']}!</h3>
            ";
        }
    }
    elseif ($user['align'] > '1' && $user['align'] < '2') {
        if ($user['sex'] == 1) {
            echo "<h3>�� �������� � ����� ����, ���� {$user['login']}!</h3>
            ";
        }
        else {
            echo "<h3>�� �������� � ����� ����, ������ {$user['login']}!</h3>
            ";
        }
    }
    elseif ($user['align'] > '3' && $user['align']< '4') {
        if ($user['sex'] == 1) {
            echo "<h3>�� �������� � ����� ����, ���� {$user['login']}!</h3>
            ";
        }
        else {
            echo "<h3>�� �������� � ����� ����, ������ {$user['login']}!</h3>
            ";
        }
    }
    else if ($user['deal']==5) {
        if ($user['sex'] == 1) {
            echo "<h3>������� �����, ���� {$user['login']}!</h3>
            ";
        }
        else {
            echo "<h3>������� �����, ������ {$user['login']}!</h3>
            ";
        }
    }

    echo "<div align=center id=hint3></div>";
        //print_r($al);
        $moj = expa($al['accses']);
        function ending($n) {
          if ($n==1) return "��";
          if ($n==2 || $n==3 || $n==4) return "��";
          return "���";
        }
        if (in_array($_SESSION['uid'], $smalladms)) $moj=array("sleep"=>"on", "sleepf"=>"on", "sleep_off"=>"on", "sleepf_off"=>"on", "bratl"=>"on", "heal"=>"on", "ct_all"=>"on");
        if ($_POST["use"]=="takeekr" && ($user["align"]==2.5 || $user["align"]==5)) {
          $ui=mqfa("select id, ekr from users where login='$_POST[target]'");
          $_POST["takeekr"]=(float)$_POST["takeekr"];
          if ($_POST["takeekr"]<=0) {
            echo "<b><font color=red>����� ������� �������.</font></b>";
          } elseif ($ui) {
            if ($ui["ekr"]<$_POST["takeekr"]) {
              echo "<b><font color=red>� ��������� ������������ ���.</font></b>";
            } else {
              mq("update users set ekr=ekr-$_POST[takeekr] where id='$ui[id]'");
              adddelo($ui["id"], "����� $user[login] ������ $_POST[takeekr] ��� � ��������� $_POST[target].", 1);
              echo "<b>������� ������� $_POST[takeekr] ��� � ��������� $_POST[target].</font></b>";
            }
          } else echo "<b><font color=red>�������� �� ������.</font></b>";
        }
        if ($_POST["use"]=="givechest" && ($user["align"]==2.5 || $user["align"]==5)) {
          $ui=mqfa1("select id from users where login='$_POST[target]'");
          $qty=(int)$_POST["qty"];
          if ($qty<=0) {
            echo "�������� ����������.";
          } elseif ($ui) {
            include "questfuncs.php";
            $i=0;
            while ($i<$qty) {
              takeitemfromshop(1767,"shop", $ui);
              $i++;
            }
            echo "�������: $qty ��. ������ ��������� <b>$_POST[target]</b>.";
            $f=fopen("logs/chestlog.txt","ab");
            fwrite($f,date("Y-m-d H:i")." $_SERVER[REMOTE_ADDR] $_SESSION[uid] => $_POST[target] ($qty)\r\n");
            fclose($f);
            addchp ('<font color=red>�� �������� �������: '.$qty.' ������'.ending($qty).'.</font>','{[]}'.nick7 ($ui).'{[]}');
          } else echo "�������� <b>$_POST[target]</b> �� ������.";
        }
        if(@$_POST["use"] && in_array($_POST['use'],array_keys($moj))) {
          include_once "questfuncs.php";
            switch($_POST['use']) {
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
                case "jail":
                    include("./magic/jail.php");
                break;
                case "jail_off":
                    include("./magic/jail_off.php");
                break;
                case "ldadd":
                    include("./magic/ldadd.php");
                break;
                case "attack":
                    include("./magic/eattack.php");
                break;
                case "attackt":
                    include("./magic/attackt.php");
                break;
                case "battack":
                    include("./magic/ebattack.php");
                break;
                case "pal_off":
                    include("./magic/pal_off.php");
                break;
                case "marry":
                    include("./magic/marry.php");
                break;
                case "unmarry":
                    include("./magic/unmarry.php");
                break;
                case "ct_all":
                    include("./magic/ct_all.php");
                break;
                case "treat":
                    include("./magic/treat.php");
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
                case "attackk":
                include("./magic/attackk.php");
                break;
                case "brat":
                    include("./magic/brat.php");
                break;
                case "bratl":
                    include("./magic/bratl.php");
                break;
                case "piot":
                    include("./magic/piot.php");
                break;
                case "nepiot":
                    include("./magic/nepiot.php");
                break;
                case "tar_off":
                    include("./magic/tar_off.php");
                break;
                case "heal":
                    include("./magic/heal.php");
                break;
                case "defence":
                    include("./magic/defence.php");
                break;
                case "devastate":
                    include("./magic/devastate.php");
                break;
				 case "teleport":
                    include("./magic/teleport.php");
                break;
            }
        }
        echo "<table>";
        echo "<tr><td><br><br>";
        foreach($moj as $k => $v) {
            //echo $k;
            switch($k) {
                case "sleep": $script_name="runmagic"; $magic_name="�������� �������� ��������"; break;
                case "sleepf":
                if (($user['align'] > '2' && $user['align'] < '3') || $user['align'] == '1.99'  || $user['align'] == '3.99'  || $user['align'] == '3.999'  || $user['align'] == '777') {
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
                case "jail": $script_name="runmagic2"; $magic_name="��������� � ���������"; break;
                case "jail_off": $script_name="runmagic1"; $magic_name="��������� �� ���������"; break;
                case "piot": $script_name="runmagic1"; $magic_name="� ��� ���� ����?"; break;
                case "nepiot": $script_name="runmagic1"; $magic_name="������� �� ����"; break;
                case "obezl": $script_name="runmagic2"; $magic_name="�������� �������� �������������"; break;
                case "obezl_off": $script_name="runmagic1"; $magic_name="����� �������� �������������"; break;
                case "pal_off": $script_name="runmagic1"; $magic_name="������ ������ �������"; break;
                case "tar_off": $script_name="runmagic1"; $magic_name="������ ������ ������"; break;
                case "attack": $script_name="runmagic1"; $magic_name="���������"; break;
                case "heal": $script_name="runmagic1"; $magic_name="��������������"; break;
                case "battack": $script_name="runmagic1"; $magic_name="�������� ���������"; break;
                case "marry": $script_name="runmagic4"; $magic_name="���������������� ����"; break;
                case "unmarry": $script_name="runmagic4"; $magic_name="����������� ����"; break;
            //  case "hidden": $script_name="runmagic1"; $magic_name="�������� �����������"; break;
        //      case "teleport": $script_name="teleport"; $magic_name="������������"; break;
                case "check": $script_name="runmagic1"; $magic_name="��������� ��������"; break;
                case "attackk": $script_name="runmagic1"; $magic_name="�������� ���������"; break;
                case "attackt": $script_name="runmagic1"; $magic_name="����������� ���������"; break;
                case "ct_all": $script_name="runmagic1"; $magic_name="�������� �� �����"; break;
                case "treat": $script_name="runmagic1"; $magic_name="������ ������"; break;
                case "chains": $script_name="runmagic1"; $magic_name="�������� ����"; break;
                case "chainsoff": $script_name="runmagic1"; $magic_name="����� ����"; break;
        //      case "pal_buttons": $script_name="runmagic"; $magic_name="�������� � ����������� ��������"; break;
                case "vampir": $script_name="runmagic1"; $magic_name="��������� (������ ������� ������� ������)"; break;
                case "brat": $script_name="runmagic1"; $magic_name="������ ������� ������� (��������� � ��������)"; break;
                case "bratl": $script_name="runmagic1"; $magic_name="�������� ����"; break;
        //      case "dneit": $script_name="runmagic"; $magic_name="��������� ���������� (����������� ��������)"; break;
        //      case "dpal": $script_name="runmagic"; $magic_name="��������� ���������� (����� ��������)"; break;
        //      case "ddark": $script_name="runmagic"; $magic_name="��������� ���������� (������ ��������)"; break;
        //      case "note": $script_name="runmagic"; $magic_name="������������� ������ ����"; break;
        //      case "sys": $script_name="runmagic"; $magic_name="��������� � ��� ��������� ���������"; break;
        //      case "scanner": $script_name="runmagic"; $magic_name="�������� ��� �������� ����������"; break;
        //      case "rep": $script_name="runmagic"; $magic_name="����� � ���������"; break;
        //      case "rost": $script_name="runmagic"; $magic_name="��������� ������"; break;
                case "ldadd": $script_name=""; $magic_name=""; break;
                case "bexit": $script_name="runmagic1"; $magic_name="����� �� ���"; break;
                case "defence": $script_name="runmagic1"; $magic_name="�������� ������ �� ������"; break;
                case "devastate": $script_name="runmagic1"; $magic_name="�������� ����������"; break;
				case "teleport": $script_name="teleport"; $magic_name="������������"; break;
            }
            if ($script_name) {print "<a onclick=\"javascript:$script_name('$magic_name','$k','target','target1') \" href='#'><img src='i/magic/".$k.".gif' title='".$magic_name."'></a>&nbsp;";}
        }
        if ($user["align"]==5 || $user["align"]==2.5) {
          print "<input type=button value=\"���� ������\" onclick=\"javascript:runmagic5('������ ������','givechest','target','target1') \">&nbsp;";
          print "<input type=button value=\"������� ���\" onclick=\"javascript:runmagict('������� ���','takeekr','target','target1') \">&nbsp;";
        }
        echo "</td></tr></table>";

        if (($user['align'] > '1' && $user['align'] < '2') || ($user['align'] > '3' && $user['align'] < '4') || $user['align'] == '5') {
            echo "<form method=post action=\"orden.php\">�������� � \"����\" ������ ������� � ��������� ������, ��������� � ��. <br>
                    <table><tr><td>������� ����� </td><td><input type='text' name='ldnick' value='$ldtarget'></td><td> ��������� <input type='text' size='50' name='ldtext' value=''></td><td><input type='hidden' name='use' value='ldadd'><input type=submit value='��������'></td></tr>";
              if (($user['align'] > '1.4' && $user['align'] < '2') || ($user['align'] > '2' && $user['align'] < '3') || ($user['align'] > '3.05' && $user['align'] < '3.999') || $user['align'] == '3.99' || $user['align'] == '5') {
                if ($ldblock) {
                    echo "<tr><td colspan=4><input type='checkbox' name='red' class='input' checked> ��������, ��� ������� �������� � ����/����������</td></tr>";
                }
                else {
                    echo "<tr><td colspan=4><input type='checkbox' name='red' class='input' > ��������, ��� ������� �������� � ����/����������</td></tr>";
                }
            }
            echo "</table></form>";
        }

        if (($user['align'] > '1' && $user['align'] < '2') || ($user['align'] > '3.05' && $user['align'] < '4')) {
            echo "<HR>";
            if($_POST['grn'] && $_POST['gr']) {
                echo telegraph($_POST['grn'],$_POST['gr']);
            }
            echo '<h4>��������</h4>�� ������ ��������� �������� ��������� ������ ���������, ���� ���� �� ��������� � offline ��� ������ ������.
<form method=post style="margin:5px;">�����: <input type=text size=20 name="grn"> ����� ���������: <input type=text size=80 name="gr"> <input type=submit value="���������"></form>';
        }

        if (($user['align'] > '1.6' && $user['align'] < '1.75')  || ($user['align'] > '1.75' && $user['align'] < '2')  || ($user['align'] > '3.04' && $user['align'] < '3.10')  || $user['align']=='3.99'  || $user['align']=='5') {

            if (!$_POST['logs']) {$_POST['logs']=date("d.m.y");}
            echo '<hr><TABLE><TR><TD colspan=3><FORM METHOD=POST ACTION=orden.php>
            ����������� �������� ���������: <INPUT TYPE=text NAME=filter value="'.$_POST['filter'].'"> �� <INPUT TYPE=text NAME=logs size=12 value="'.$_POST['logs'].'"> <INPUT TYPE=submit value="�����������!">
            </form></TD>
            </tr><tr><td><FORM METHOD=POST ACTION=orden.php><INPUT TYPE=hidden NAME=filter value="'.$_POST['filter'].'">
            <INPUT TYPE=hidden NAME=logs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['logs'],3,2), substr($_POST['logs'],0,2)-1, "20".substr($_POST['logs'],6,2))).'">
            <INPUT TYPE=submit value="   �   "></form></TD>
            <TD valign=top align=center>�������� ��������� <b>"'.$_POST['filter'].'"</b> ��  <b>'.$_POST['logs'].'</b></TD>
            <TD><FORM METHOD=POST ACTION=orden.php><INPUT TYPE=hidden NAME=logs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['logs'],3,2), substr($_POST['logs'],0,2)+1, "20".substr($_POST['logs'],6,2))).'">
            <INPUT TYPE=hidden NAME=filter value="'.$_POST['filter'].'"> <INPUT TYPE=submit value="   �   "></form></TD>
            </TR></TABLE></form>';
            if ($_POST['filter']) {
                $perevod = mysql_fetch_array(mq("SELECT login,id,align FROM `users` WHERE `login` = '{$_POST['filter']}' LIMIT 1;"));
                $per_ok=0;
                if (($user['align'] > '1' && $user['align'] < '2')  || ($user['align'] > '3' && $user['align'] < '4')) {
                    $per_ok=1;
}
                if ($user["align"]==5) $per_ok=1;
                $iid=$perevod['id'];
                $logsat=$_POST['logs'];
                if ($per_ok==1) {
                    if (@$_POST["all"]) {
                      $logs = mq("SELECT * FROM archive.`delo` WHERE `pers` = '{$perevod['id']}' ORDER by `id` ASC;");
                    } else {
                      $ddate1=mktime(0, 0, 0, substr($_POST['logs'],3,2), substr($_POST['logs'],0,2), "20".substr($_POST['logs'],6,2));
                      $ddate2=mktime(23, 59, 59, substr($_POST['logs'],3,2), substr($_POST['logs'],0,2), "20".substr($_POST['logs'],6,2));
                      $logs = mq("SELECT * FROM `delo` WHERE `pers` = '{$perevod['id']}' AND `date` > '$ddate1' AND `date` < '$ddate2' ORDER by `id` ASC;");
                    }
                    while($row = @mysql_fetch_array($logs)) {
                        $dat=date("d.m.y H:i",$row['date']);
                        echo "<span class=date>{$dat}</span> {$row['text']}<br>";
                    }
                }

            }
            echo "<hr>";
        }

        if ($user['deal']==5){
            if ($_POST['putekr']) {
                if (($_POST['ekr']) && ($_POST['bank']) && ($_POST['tonick'])) {
                    $tonick = mysql_fetch_array(mq("SELECT login,id FROM `users` WHERE `login` = '{$_POST['tonick']}' LIMIT 1;"));
                    $bank = mysql_fetch_array(mq("SELECT owner,id FROM `bank` WHERE `id` = '{$_POST['bank']}' LIMIT 1;"));
                    if  (ereg("auto-",$user['login']) || ereg("auto-",$user['login'])) {
                        $botfull=$user['login'];
                        list($bot, $botlogin) = explode("-", $user['login']);
                        $botnick = mysql_fetch_array(mq("SELECT login,id FROM `users` WHERE `login` = '{$botlogin}' LIMIT 1;"));
                        $user['login']=$botnick['login'];
                        $user['id']=$botnick['id'];
                    }
                    if ($bank['owner'] && $tonick['id'] && $bank['owner'] == $tonick['id']) {
                        $_POST['ekr'] = round($_POST['ekr'],2);
                        if (mq("UPDATE `bank` set `ekr` = ekr+'{$_POST['ekr']}' WHERE `id` = '{$_POST['bank']}' LIMIT 1;")) {
                            if ($bot && $botlogin) {
                                mq("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr) values ('{$_SESSION['uid']}','{$botfull}','{$_POST['bank']}','{$_POST['tonick']}','{$_POST['ekr']}');");
                                mq("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr) values ('{$user['id']}','{$botfull}','{$_POST['bank']}','{$_POST['tonick']}','{$_POST['ekr']}');");
                            }
                            else {
                                mq("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr) values ('{$user['id']}','{$user['login']}','{$_POST['bank']}','{$_POST['tonick']}','{$_POST['ekr']}');");
                            }
                            mq("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$tonick['id']}','�������� ".$_POST['ekr']." ��� �� ���� �".$_POST['bank']." �� ������ ".$user['login']."',1,'".time()."');");
                            $us = mysql_fetch_array(mq("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$tonick['id']}' LIMIT 1;"));
                            if($us[0]){
                                addchp ('<font color=red>��������!</font> �� ��� ���� �'.$_POST['bank'].' ���������� '.$_POST['ekr'].' ���. �� ������ '.$user['login'].'  ','{[]}'.$_POST['tonick'].'{[]}');
                            } else {
                                // ���� � ���
                                mq("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> �� ��� ���� �'.$_POST['bank'].' ���������� '.$_POST['ekr'].' ���. �� ������ '.$user['login'].'  '."');");
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
                    $tonick = mysql_fetch_array(mq("SELECT login,id,align,klan FROM `users` WHERE `login` = '{$_POST['komlog']}' LIMIT 1;"));
                    if  (ereg("auto-",$user['login']) || ereg("auto-",$user['login'])) {
                        $botfull=$user['login'];
                        list($bot, $botlogin) = explode("-", $user['login']);
                        $botnick = mysql_fetch_array(mq("SELECT login,id FROM `users` WHERE `login` = '{$botlogin}' LIMIT 1;"));
                        $user['login']=$botnick['login'];
                        $user['id']=$botnick['id'];
                    }
                    if ($tonick['login']) {
                        if ($bot && $botlogin) {
                            mq("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['komlog']}','{$_POST['price']}','5');");
                            mq("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$botfull}','0','{$_POST['komlog']}','{$_POST['price']}','5');");
                        }
                        else {
                            mq("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['komlog']}','{$_POST['price']}','5');");
                        }
                        mq("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$tonick['id']}','&quot;".$_POST['komlog']."&quot; �������� ������ � ����. ����� ����� ������ ".$user['login']."  ',1,'".time()."');");
                        mq("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tonick['id']."','&quot;".$_POST['komlog']."&quot; �������� ������ � ����. ����� ����� ������ &quot;".$user['login']."&quot;  ','".time()."');");
                        print "<b><font color=red>������ � ����. ����� {$_POST['price']} ���. ��� ��������� {$_POST['komlog']} ����������� �������!</font></b>";
                    }
                    else {
                        print "<b><font color=red>����� �������� �� ����������!</font></b>";
                    }
                }
            }
            if ($_POST['obraz']) {
                if ($_POST['obrazlog']) {
                    $tonick = mysql_fetch_array(mq("SELECT login,id,align,klan FROM `users` WHERE `login` = '{$_POST['obrazlog']}' LIMIT 1;"));
                    if  (ereg("auto-",$user['login']) || ereg("auto-",$user['login'])) {
                        $botfull=$user['login'];
                        list($bot, $botlogin) = explode("-", $user['login']);
                        $botnick = mysql_fetch_array(mq("SELECT login,id FROM `users` WHERE `login` = '{$botlogin}' LIMIT 1;"));
                        $user['login']=$botnick['login'];
                        $user['id']=$botnick['id'];
                    }
                    if ($tonick['login']) {
                        if ($bot && $botlogin) {
                            mq("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['obrazlog']}','100','6');");
                            mq("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$botfull}','0','{$_POST['obrazlog']}','100','6');");
                        }
                        else {
                            mq("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['obrazlog']}','100','6');");
                        }
                        mq("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$tonick['id']}','&quot;".$_POST['obrazlog']."&quot; ������� ������ ����� ����� ������ ".$user['login']."',1,'".time()."');");
                        mq("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tonick['id']."','&quot;".$_POST['obrazlog']."&quot; ������� ������ ����� ����� ������ &quot;".$user['login']."&quot;  ','".time()."');");
                        print "<b><font color=red>������ ������� ������ ��� ��������� {$_POST['obrazlog']} ����������� �������!</font></b>";
                    }
                    else {
                        print "<b><font color=red>����� �������� �� ����������!</font></b>";
                    }
                }
            }
            if ($_POST['openbank']) {
                if ($_POST['charlog']) {
                    $tonick = mysql_fetch_array(mq("SELECT login,id,money FROM `users` WHERE `login` = '{$_POST['charlog']}' LIMIT 1;"));
                    if  (ereg("auto-",$user['login']) || ereg("auto-",$user['login'])) {
                        $botfull=$user['login'];
                        list($bot, $botlogin) = explode("-", $user['login']);
                        $botnick = mysql_fetch_array(mq("SELECT login,id FROM `users` WHERE `login` = '{$botlogin}' LIMIT 1;"));
                        $user['login']=$botnick['login'];
                        $user['id']=$botnick['id'];
                    }
                    if ($tonick['login']) {
                        if (mq("UPDATE `users` set `money` = `money`+'0.5' WHERE `id` = '{$tonick['id']}' LIMIT 1;")) {
                            mq("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$tonick['id']}','�������� 0.5 ��. �� �������� ����� � ����� �� ������ ".$user['login']."',1,'".time()."');");
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
                    $tonick = mysql_fetch_array(mq("SELECT login,id,align,klan FROM `users` WHERE `login` = '{$_POST['sklonkalog']}' LIMIT 1;"));
                    if  (ereg("auto-",$user['login']) || ereg("auto-",$user['login'])) {
                        $botfull=$user['login'];
                        list($bot, $botlogin) = explode("-", $user['login']);
                        $botnick = mysql_fetch_array(mq("SELECT login,id FROM `users` WHERE `login` = '{$botlogin}' LIMIT 1;"));
                        $user['login']=$botnick['login'];
                        $user['id']=$botnick['id'];
                    }
                    if ($tonick['login']) {
                        if ($tonick['align'] || $tonick['klan']) {
                            print "<b><font color=red>�������� ��� ����� ���������� ���� ������� � �����!</font></b>";
                        }
                        else {
                            if (mq("UPDATE `users` set `align` = '{$_POST['sklonka']}' WHERE `id` = '{$tonick['id']}' LIMIT 1;")) {
                                if ($_POST['sklonka'] == 7) {$skl="�����������"; $skl2="�����������";}
                                else {$skl="������"; $skl2="������";}
                                if ($bot && $botlogin) {
                                    mq("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['sklonkalog']}','0',{$_POST['sklonka']});");
                                    mq("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$botfull}','0','{$_POST['sklonkalog']}','0',{$_POST['sklonka']});");
                                }
                                else {
                                    mq("INSERT INTO `dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['sklonkalog']}','0',{$_POST['sklonka']});");
                                }
                                mq("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$tonick['id']}','������� ".$skl." ���������� �� ������ ".$user['login']."',1,'".time()."');");
                                if ($user['sex'] == 1) {$action="��������";}
                                else {$action="���������";}
                                mq("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tonick['id']."','����� &quot;".$user['login']."&quot; ".$action." &quot;".$_POST['sklonkalog']."&quot; ".$skl2." ����������','".time()."');");
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

            echo "<h4>��������� ������</h4><form method=post action=\"orden.php\"><b>��������� ���� �� ���� </b>
                <table><tr><td>������� ����� </td><td><input type='text' name='ekr' value=''></td><td> ����� ����� <input type='text' name='bank' value=''></td><td> ��� ��������� <input type='text' name='tonick' value=''></td><td><input type=submit name=putekr value='���������'></td></tr></table>";
            echo "<br><form method=post action=\"orden.php\"><b>��������� ����� / ����� ����� </b>
                <table><tr><td>����� </td><td><input type='text' name='charlogin' value=''></td><td> ����� ����� <input type='text' name='charbank' value=''></td><td><input type=submit name=checkbank value='���������'></td></tr></table>";
            echo "<br><form method=post action=\"orden.php\"><b>�������� ������ �� �������� �����</b>
                <table><tr><td>����� </td><td><input type='text' name='charlog' value=''></td><td></td><td><input type=submit name=openbank value='��������'></td></tr></table>";
            echo "<br><form method=post action=\"orden.php\"><b>��������� ����������</b>
                <table><tr><td>����� </td><td><input type='text' name='sklonkalog' value=''></td><td>���������� <select name='sklonka'>
                    <option value='0'></option>
                    <option value='2'>�����������</option>
                    <option value='0.98'>������</option></select><td><input type=submit name=givesklonka value='���������'></td></tr></table>";
            echo "<br><form method=post action=\"orden.php\"><b>�������� � ���.�����</b>
                <table><tr><td>����� </td><td><input type='text' name='komlog' value=''></td><td>������� ����� <input type='text' name='price' value=''></td><td><input type=submit name=komotdel value='��������'></td></tr></table>";
            echo "<br><form method=post action=\"orden.php\"><b>�������� ������ �����</b>
                <table><tr><td>����� </td><td><input type='text' name='obrazlog' value=''></td><td></td><td><input type=submit name=obraz value='��������'></td></tr></table>";

            if ($_POST['checkbank']) {
                if ($_POST['charlogin']) {
                    $tonick = mysql_fetch_array(mq("SELECT login,id FROM `users` WHERE `login` = '{$_POST['charlogin']}' LIMIT 1;"));
                    $bankdb = mq("SELECT owner,id FROM `bank` WHERE `owner` = '{$tonick['id']}'");
                    print "��������� {$_POST['charlogin']} ����������� �����: <br>";
                    while ($bank=mysql_fetch_array($bankdb)) {
                        print "� {$bank['id']} <br>";
                    }
                }
                else if  ($_POST['charbank']) {
                    $bank = mysql_fetch_array(mq("SELECT owner,id FROM `bank` WHERE `id` = '{$_POST['charbank']} 'LIMIT 1;"));
                    $tonick = mysql_fetch_array(mq("SELECT login,id FROM `users` WHERE `id` = '{$bank['owner']}' LIMIT 1;"));
                    print "���� � {$_POST['charbank']} ����������� ��������� {$tonick['login']} <br>";
                }
            }
            echo "<hr>";
            if (!$_POST['dlogs']) {$_POST['dlogs']=date("d.m.y");}

            if ($user['align'] > '2' && $user['align'] < '3') {
            echo '<TABLE><TR><TD colspan=3><FORM METHOD=POST ACTION=orden.php>
            ����������� ��������� �������� ���������: <INPUT TYPE=text NAME=dfilter value="'.$_POST['dfilter'].'"> �� <INPUT TYPE=text NAME=dlogs size=12 value="'.$_POST['dlogs'].'"> <INPUT TYPE=submit value="�����������!"></form></TD>
            </tr><tr><td><FORM METHOD=POST ACTION=orden.php><INPUT TYPE=hidden NAME=dfilter value="'.$_POST['dfilter'].'">
            <INPUT TYPE=hidden NAME=dlogs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['dlogs'],3,2), substr($_POST['dlogs'],0,2)-1, "20".substr($_POST['dlogs'],6,2))).'">
            <INPUT TYPE=submit value="   �   "></form></TD>
            <TD valign=top align=center>��������� �������� ��������� <b>"'.$_POST['dfilter'].'"</b> ��  <b>'.$_POST['dlogs'].'</b></TD>
            <TD><FORM METHOD=POST ACTION=orden.php><INPUT TYPE=hidden NAME=dlogs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['dlogs'],3,2), substr($_POST['dlogs'],0,2)+1, "20".substr($_POST['dlogs'],6,2))).'">
            <INPUT TYPE=hidden NAME=dfilter value="'.$_POST['dfilter'].'"> <INPUT TYPE=submit value="   �   "></form></TD>
            </TR></TABLE></form>';
            }
            elseif ($user['deal']==5) {
            echo '<TABLE><TR><TD colspan=3><FORM METHOD=POST ACTION=orden.php>
            ����������� ��������� �������� <INPUT TYPE=hidden NAME=dfilter value="'.$user['login'].'">�� <INPUT TYPE=text NAME=dlogs size=12 value="'.$_POST['dlogs'].'"> <INPUT TYPE=submit value="�����������!"></form></TD>
            </tr><tr><td><FORM METHOD=POST ACTION=orden.php><INPUT TYPE=hidden NAME=dfilter value="'.$_POST['dfilter'].'">
            <INPUT TYPE=hidden NAME=dlogs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['dlogs'],3,2), substr($_POST['dlogs'],0,2)-1, "20".substr($_POST['dlogs'],6,2))).'">
            <INPUT TYPE=submit value="   �   "></form></TD>
            <TD valign=top align=center>��������� �������� ��������� <b>"'.$_POST['dfilter'].'"</b> ��  <b>'.$_POST['dlogs'].'</b></TD>
            <TD><FORM METHOD=POST ACTION=orden.php><INPUT TYPE=hidden NAME=dlogs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['dlogs'],3,2), substr($_POST['dlogs'],0,2)+1, "20".substr($_POST['dlogs'],6,2))).'">
            <INPUT TYPE=hidden NAME=dfilter value="'.$_POST['dfilter'].'"> <INPUT TYPE=submit value="   �   "></form></TD>
            </TR></TABLE></form>';
            }
            if ($_POST['dfilter']) {
                $perevod1 = mysql_fetch_array(mq("SELECT `login`,`id`,`align` FROM `users` WHERE `login` = '{$_POST['dfilter']}' LIMIT 1;"));
                $aa=$perevod1['id'];
                if (($user['align'] > '2' && $user['align'] < '3') || ($user['deal']==5)) {
                    $logsat=$_POST['dlogs'];
                    $ddate33="20".substr($_POST['dlogs'],6,2)."-".substr($_POST['dlogs'],3,2)."-".substr($_POST['dlogs'],0,2)."";
                    $dlogs = mq("SELECT * FROM `dilerdelo` WHERE `dilerid` = '{$perevod1['id']}' AND `date` like '$ddate33%' ORDER by `id` ASC;");
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

        if (($user['align'] > '1.6' && $user['align'] < '2') || ($user['align'] > '3.07' && $user['align'] < '3.10') || $user['align']=='3.99' || $user['align']=='5'){
            echo "<form method=post><fieldset><legend>IP</legend>
                    <table><tr><td>�����</td><td><input type='text' name='ip' value='",$_POST['ip'],"'></td><td><input type=submit value='���������� IP'></td></tr>
                    <tr><td>IP</td><td><input type='text' name='ipfull' value='",$_POST['ipfull'],"'></td><td><input type=submit value='���������� ����'></td></tr></table>";
            if ($_POST['ip']) {
                $dd = mysql_fetch_array(mq("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['ip']."';"));
                echo "<font color=red>",$dd[1]," - ",$dd[0],"</font><BR>";
            }elseif($_POST['ipfull']) {
                $data = mq("SELECT `ip`, `login` FROM `users` WHERE `ip` = '".$_POST['ipfull']."';");
                while($dd=mysql_fetch_array($data)) {
                    echo "<font color=red>",$dd[1]," - ",$dd[0],"</font><BR>";
                }
            }
            echo "</fieldset></form>";
        }

        if (($user['align'] == '1.99') || ($user['align']=='3.99')) {
                echo "<form method=post><fieldset><legend>�������� ������</legend>
                    <table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������</td><td><input type='text' name='status' value='",$_POST['status'],"'></td><td><input type=submit value='�������� ������'></td></tr></table>";
                if ($_POST['login'] && $_POST['status']) {
                    $dd = mysql_fetch_array(mq("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
                    if($dd) {
                        mq("UPDATE `users` SET `status` = '".$_POST['status']."' WHERE `login` = '".$_POST['login']."';");
                        echo "<font color=red>������ ",$dd[1]," ������� �� ",$_POST['status'],"</font><BR>";
                    }
                }
                echo "</fieldset></form>";
}
        if ($user['align'] == '1.99') {
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
                    }
                    $dd = mysql_fetch_array(mq("SELECT `id`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
                    if ($user['sex'] == 1) {$action="��������";}
                        else {$action="���������";}

                        if ($user['align']=='1.99') {
                            $angel="��������� �������";
                        }
                    if($dd) {

                        mq("UPDATE `users` SET `align` = '".$_POST['krest']."',`status` = '$rang' WHERE `login` = '".$_POST['login']."';");
                        $target=$_POST['login'];
                        $mess="$angel &quot;{$user['login']}&quot; $action &quot;$target&quot; ������ $rang";
                        mq("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$dd['id']."','$mess','".time()."');");
                        mq("INSERT INTO `paldelo`(`id`,`author`,`text`,`date`) VALUES ('','".$_SESSION['uid']."','$mess','".time()."');");


                    }
                }
        }
        if ($user['align'] == '3.99') {
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
                    }
                    $dd = mysql_fetch_array(mq("SELECT `id`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
                    if ($user['sex'] == 1) {$action="��������";}
                        else {$action="���������";}
                        if ($user['align']=='3.99') {
                            $angel="��������";
                        }
                    if($dd) {

                        mq("UPDATE `users` SET `align` = '".$_POST['tarmanka']."',`status` = '$rang' WHERE `login` = '".$_POST['login']."';");
                        $target=$_POST['login'];
                        $mess="$angel &quot;{$user['login']}&quot; $action &quot;$target&quot; ������ $rang";
                        mq("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$dd['id']."','$mess','".time()."');");
                        mq("INSERT INTO `paldelo`(`id`,`author`,`text`,`date`) VALUES ('','".$_SESSION['uid']."','$mess','".time()."');");


                    }
                }
        }
include "zaschita/razblock.php";
    $google = 1;
    $user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
    if ($user['align']<2.4) die();
    //$online = mysql_fetch_row(mq("select COUNT(*) from `online`  WHERE `real_time` >= ".(time()-60).";"));
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
                fputs($fp ,"\r\n:[".time ()."]:[!sys2all!!]:[<font color=\"#CB0000\">".($_POST['msg'])."</font>]:[1]\r\n"); //������ � ������
                flock ($fp,LOCK_UN);
                fclose($fp);
            }
            else {
                $fp = fopen (CHATROOT."chat.txt","a"); //��������
                flock ($fp,LOCK_EX); //���������� �����
                fputs($fp ,"\r\n:[".time ()."]:[!sys2all!!]:[<font color=\"#CB0000\">".($_POST['msg'])."</font>]:[1]\r\n"); //������ � ������
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
</body>
</html>
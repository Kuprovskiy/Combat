<?php
    session_start();
    if ($_SESSION['uid'] == null) header("Location: index.php");
    function otdelname($otdel) {
      if ($otdel==1) return "����, �������";
      if ($otdel==11) return "������";
      if ($otdel==12) return "������,������";
      if ($otdel==13) return "����";
      if ($otdel==30) return "���������� ������";
      if ($otdel==2) return "������";
      if ($otdel==21) return "��������";
      if ($otdel==22) return "������ �����";
      if ($otdel==23) return "������ �����";
      if ($otdel==24) return "�����";
      if ($otdel==25) return "������";
      if ($otdel==26) return "�����";
      if ($otdel==27) return "������";
      if ($otdel==3) return "����";
      if ($otdel==4) return "������";
      if ($otdel==41) return "��������";
      if ($otdel==42) return "������";
    }

    $_GET["type"]=(int)@$_GET["type"];

    include "connect.php";
    include './functions.php';
    if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }

    if ($user['room']!='31' && $user['room']!='56' && $user['room']!='71') die('��� ������������� ������ ���������� ���������� � �������� "����� ������"');

    if ($user["room"]==31) {
      $statsroom=0;
      $maxmaster=0;
      $maxstats=100;
    } elseif ($user["room"]==71) {
      $statsroom=$user["room"];
      $maxmaster=0;
      $maxstats=100;
    } else {
      $statsroom=$user["room"];
      $maxmaster=10;
      $maxstats=145;
    }

    //undressall($_SESSION['uid']);
    //$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));

    //
    if ((int)$_GET['delsn']>0) {
      mysql_query("DELETE FROM `deztow_charstams` WHERE `id`=".(int)$_GET['delsn']." AND name='".$_GET['ddname']."' AND `owner`=".(int)$_SESSION['uid']);
    }
    if ($_SERVER["REQUEST_METHOD"]=="POST" && !$_POST["name"]) $_POST["name"]="$_POST[sila]-$_POST[lovk]-$_POST[inta]-$_POST[vinos]";
    if($_POST['name']){
        // checksumm
      $_POST["mec"]=abs((int)$_POST["mec"]);
      $_POST["noj"]=abs((int)$_POST["noj"]);
      $_POST["topor"]=abs((int)$_POST["topor"]);
      $_POST["dubina"]=abs((int)$_POST["dubina"]);
      $_POST["posoh"]=abs((int)$_POST["posoh"]);
      $_POST["mfire"]=abs((int)$_POST["mfire"]);
      $_POST["mwater"]=abs((int)$_POST["mwater"]);
      $_POST["mair"]=abs((int)$_POST["mair"]);
      $_POST["mearth"]=abs((int)$_POST["mearth"]);
      $_POST["mlight"]=abs((int)$_POST["mlight"]);
      $_POST["mgray"]=abs((int)$_POST["mgray"]);
      $_POST["mdark"]=abs((int)$_POST["mdark"]);

      $_POST["sila"]=abs((int)$_POST["sila"]);
      $_POST["lovk"]=abs((int)$_POST["lovk"]);
      $_POST["inta"]=abs((int)$_POST["inta"]);
      $_POST["vinos"]=abs((int)$_POST["vinos"]);
      $_POST["intel"]=abs((int)$_POST["intel"]);
      $_POST["mudra"]=abs((int)$_POST["mudra"]);


      $_POST["mec"]=abs($_POST["mec"]);$_POST["noj"]=abs($_POST["noj"]);$_POST["topor"]=abs($_POST["topor"]);$_POST["dubina"]=abs($_POST["dubina"]);$_POST["posoh"]=abs($_POST["posoh"]);
      $_POST["mfire"]=abs($_POST["mfire"]);$_POST["mwater"]=abs($_POST["mwater"]);$_POST["mair"]=abs($_POST["mair"]);$_POST["mearth"]=abs($_POST["mearth"]);
      $_POST["mlight"]=abs($_POST["mlight"]);$_POST["mgray"]=abs($_POST["mgray"]);$_POST["mdark"]=abs($_POST["mdark"]);

      if ($maxstats == abs($_POST['sila'])+abs($_POST['lovk'])+abs($_POST['inta'])+abs($_POST['vinos'])+abs($_POST['intel'])+abs($_POST['mudra'])
      && $maxmaster==$_POST['mec']+$_POST['noj']+$_POST['topor']+$_POST['dubina']+$_POST['posoh']+$_POST['mfire']+$_POST['mwater']
      +$_POST['mair']+$_POST['mearth']+$_POST['mlight']+$_POST['mgray']+$_POST['mdark']
      && $_POST["mec"]<=5 && $_POST["noj"]<=5 && $_POST["topor"]<=5 && $_POST["dubina"]<=5 && $_POST["posoh"]<=5
      && abs($_POST['sila'])>=3 && abs($_POST['lovk'])>=3 && abs($_POST['inta'])>=3 && abs($_POST['vinos'])>=3) {
        $sql="";
        foreach ($dressslots as $k=>$v) {
          $sql.=", $v=0";
        }
        mq("INSERT `deztow_charstams` (`owner`,`name`,`sila`,`lovk`,`inta`,`vinos`,`intel`,`mudra`, room,
        mec, noj, topor, dubina, posoh, mfire, mair, mwater, mearth, mlight, mgray, mdark)
        values ('".$user['id']."','".$_POST['name']."','".abs($_POST['sila'])."','".abs($_POST['lovk'])."',
        '".abs($_POST['inta'])."','".abs($_POST['vinos'])."','".abs($_POST['intel'])."','".abs($_POST['mudra'])."', '$statsroom',
        '$_POST[mec]', '$_POST[noj]', '$_POST[topor]', '$_POST[dubina]', '$_POST[posoh]',
        '$_POST[mfire]', '$_POST[mair]', '$_POST[mwater]', '$_POST[mearth]', '$_POST[mlight]', 
        '$_POST[mgray]', '$_POST[mdark]') ON DUPLICATE KEY UPDATE
        `sila` = '".abs($_POST['sila'])."', `lovk` = '".abs($_POST['lovk'])."', `inta` = '".abs($_POST['inta'])."',
        `vinos` = '".abs($_POST['vinos'])."', `intel` = '".abs($_POST['intel'])."', `mudra` = '".abs($_POST['mudra'])."',
        mec='$_POST[mec]', noj='$_POST[noj]', topor='$_POST[topor]', dubina='$_POST[dubina]', posoh='$_POST[posoh]',
        mfire='$_POST[mfire]', mair='$_POST[mair]', mwater='$_POST[mwater]', mearth='$_POST[mearth]', mlight='$_POST[mlight]', 
        mgray='$_POST[mgray]', mdark='$_POST[mdark]'");
      } else {
        $err=1;
        echo "<font color=red><b>���-�� �� �� �� �������... ����� ���������. ���������� ������������ ��� ����� ".($maxmaster>0?", �������� ������� �� ���� ��������� 5 ������ � �������� ������ - 10":"")."!</b></font><br>";
      }
      if (!$err) echo "<font color=red><b>���������.</b></font>";
    }
    $tec=mqfa("SELECT * FROM `deztow_charstams` WHERE `owner` = '{$_SESSION['uid']}' AND `id`='".$_GET['id']."' and room='$statsroom'");
    if (isset($_GET["undressitem"])) {
      mq("update deztow_charstams set ".$dressslots[$_GET["undressitem"]]."=0 where id='$tec[id]'");
      $tec=mysql_fetch_array(mq("SELECT * FROM `deztow_charstams` WHERE `owner` = '{$_SESSION['uid']}' AND `id`='".$_GET['id']."' and room='$statsroom';"));
    }
    function maketec1() {
      global $tec1, $tec;
      $tec1=getdressstats($tec);
      adddressstats($tec1, $tec);
    }
    maketec1();
    if (@$_GET["dressitem"]) {
      $_GET["dressitem"]=(int)$_GET["dressitem"];
      $rec=mqfa("select id, name, type, second, dvur, nsila, nlovk, ninta, nvinos, nintel, nmudra from inventory where owner='$user[room]' and id='$_GET[dressitem]'");
      if ($rec && $rec["nsila"]<=$tec1["sila"] && $rec["nlovk"]<=$tec1["lovk"] && $rec["ninta"]<=$tec1["inta"]
      && $rec["nvinos"]<=$tec1["vinos"] && $rec["nintel"]<=$tec1["intel"] && $rec["nmudra"]<=$tec1["mudra"]
      && $rec["nnoj"]<=$tec1["noj"] && $rec["nmec"]<=$tec1["mec"] && $rec["ndubina"]<=$tec1["dubina"] && $rec["ntopor"]<=$tec1["topor"]
      && $rec["nfire"]<=$tec1["mfire"] && $rec["nwater"]<=$tec1["mwater"] && $rec["nair"]<=$tec1["mair"] && $rec["nearth"]<=$tec1["mearth"]
      && $rec["nlight"]<=$tec1["mlight"] && $rec["ngray"]<=$tec1["mgray"] && $rec["ndark"]<=$tec1["mdark"]) {
        if ($rec["type"]==3) {
          if ($rec["dvur"]) {
            mq("update deztow_charstams set weap='$_GET[dressitem]', shit=0 where id='$tec[id]'");
          } elseif ($rec["second"]) {
            $dvur=0;
            if ($tec["weap"]) $dvur=mqfa1("select dvur from inventory where id='$tec[weap]'");
            if ($tec["weap"] && !$dvur) {
              $_GET["dressitem"]=mqfa1("select id from inventory where owner='".($user["room"]+1)."' and name='$rec[name]'");
              mq("update deztow_charstams set shit='$_GET[dressitem]' where id='$tec[id]'");
            } else mq("update deztow_charstams set weap='$_GET[dressitem]' where id='$tec[id]'");
          } else {
            mq("update deztow_charstams set weap='$_GET[dressitem]' where id='$tec[id]'");
          }
        } else {
          $slot=slotbytype($rec["type"], $tec);
          if ($slot=="r2") $_GET["dressitem"]=mqfa1("select id from inventory where owner='".($user["room"]+1)."' and name='$rec[name]'");
          if ($slot=="r3") $_GET["dressitem"]=mqfa1("select id from inventory where owner='".($user["room"]+2)."' and name='$rec[name]'");
          $dvur=0;
          if ($slot=="shit") $dvur=mqfa1("select dvur from inventory where id='$tec[weap]'");
          if ($slot=="shit" && $dvur) {
            mq("update deztow_charstams set weap=0, shit='$_GET[dressitem]' where id='$tec[id]'");
          } else {
            mq("update deztow_charstams set $slot='$_GET[dressitem]' where id='$tec[id]'");
          }
        }
      }
      $tec=mysql_fetch_array(mq("SELECT * FROM `deztow_charstams` WHERE `owner` = '{$_SESSION['uid']}' AND `id`='".$_GET['id']."' and room='$statsroom';"));
      maketec1();
    }
    if($_GET['setdef']){
      //$tec = mysql_fetch_array(mysql_query("SELECT * FROM `deztow_charstams` WHERE `owner` = '{�.$_SESSION['uid']}' AND `id`='".$_POST['setdef']."';"));
      mq("UPDATE `deztow_charstams` SET `def` = 1 WHERE `owner` = '{$_SESSION['uid']}' AND  `id` = ".$_GET['setdef'].";");
      mq("UPDATE `deztow_charstams` SET `def` = 0 WHERE `owner` = '{$_SESSION['uid']}' AND  `id` <> ".$_GET['setdef']." and room='$statsroom';");
      echo "<font color=red><b>���������.</b></font>".mysql_error();
    }
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
</HEAD>
<body bgcolor=e2e0e0>
<div style="text-align:right;margin-bottom:-30px">
<input type="button" value="���������" onclick="document.location.href='battleenter.php';">
</div>
<h3>������� �������������</h3>
<!--����� �� ��������� ������� � ��? -->
<? if ($user["room"]==31) {
  echo "� ����� ����� ����� ������ ��� ��������� �� ������� 8-�� ������.";
} elseif ($user["room"]==71) {
  echo "� ��������� ����� ������ ��� ��������� �� ������� 8-�� ������.";
} else {
  echo "� ������ ���������� ��� ��������� �� ������� 9-�� ������.";
}
?>
��������� ���� ����� ���, ��� �� ������, � ���������� � �������!
��������� �� ��������� �������, ���������� ���.
�� ������ ��������� �������������� ����� ��������, � ������ �� �� ������� �� �������!
<BR><BR>
<table width=100% bordercolor=silver border=1 cellpadding=0 cellspacing=0>
    <tr bgcolor=silver>
        <td>��������</td><td width=25%>�� ��.</td><td>�������</td>
    </tr>
    <?php
     $data = mysql_query("SELECT * FROM `deztow_charstams` WHERE `owner` = '{$_SESSION['uid']}' and room='$statsroom';");
     while($row = mysql_fetch_array($data)) {
        echo "<tr onclick='location.href=\"towerstamp.php?id={$row['id']}\";' style='cursor:pointer;'><td><B>{$row['name']}</B></td><td><a href='?setdef=$row[id]'>".($row['def']?"<font color=red>�� ���������</font>":"����������")."</a></td>
        <td><a href='?delsn=".$row['id']."&ddname=".$row['name']."'>X</a></td></tr>\n";
     }
    ?>
</table><BR>
<INPUT TYPE=button value="��������" onclick="window.location.href='towerstamp.php';">
<script>
    function countall() {
      if (parseInt(document.getElementById('sila').value)<3) document.getElementById('sila').value=3;
      if (parseInt(document.getElementById('lovk').value)<3) document.getElementById('lovk').value=3;
      if (parseInt(document.getElementById('inta').value)<3) document.getElementById('inta').value=3;
      if (parseInt(document.getElementById('vinos').value)<3) document.getElementById('vinos').value=3;
        document.getElementById('stats').value = <?
        echo $maxstats;
        //=($user['sila']+$user['lovk']+$user['inta']+$user['vinos']+$user['intel']+$user['mudra']+$user['stats'])
        ?>-Math.abs(document.getElementById('sila').value)-Math.abs(document.getElementById('lovk').value)-Math.abs(document.getElementById('inta').value)-Math.abs(document.getElementById('vinos').value)-Math.abs(document.getElementById('intel').value)-Math.abs(document.getElementById('mudra').value);
    }
</script>
<table><tr><td valign="top">
<form method="POST" action="towerstamp.php?id=<? echo (int)$_GET["id"]; ?>">
    ����.: <input type="text" name="name" value="<?=$tec['name']?>">
    <table cellpadding=0 cellspacing=0 >
        <tr bgcolor=silver>
            <td>�������������� &nbsp;</td><td>����.</td>
        </tr>
        <tr>
            <td>����</td><td><input type="text" id="sila" size=4 onblur="countall();" value="<?=$tec['sila']?>" name="sila"> <?=$tec["sila"]!=$tec1["sila"]?"($tec1[sila])":""?></td>
        </tr>
        <tr>
            <td>��������</td><td><input type="text" id="lovk" size=4 onblur="countall();" value="<?=$tec['lovk']?>" name="lovk"> <?=$tec["lovk"]!=$tec1["lovk"]?"($tec1[lovk])":""?></td>
        </tr>
        <tr>
            <td>��������</td><td><input type="text" id="inta" size=4 onblur="countall();" value="<?=$tec['inta']?>" name="inta"> <?=$tec["inta"]!=$tec1["inta"]?"($tec1[inta])":""?></td>
        </tr>
        <tr>
            <td>������������</td><td><input type="text" id="vinos" size=4 onblur="countall();" value="<?=$tec['vinos']?>" name="vinos"></td>
        </tr>
        <tr>
            <td>���������</td><td><input type="text" id="intel" size=4 onblur="countall();" value="<?=$tec['intel']?>" name="intel"> <?=$tec["intel"]!=$tec1["intel"]?"($tec1[intel])":""?></td>
        </tr>
        <tr>
            <td>��������</td><td><input type="text" id="mudra" size=4 onblur="countall();" value="<?=$tec['mudra']?>" name="mudra"></td>
        </tr>
        <tr>
            <td>���������</td><td><input type="text" id="stats" name="stats" size=4 disabled value="<?
            echo $maxstats; //($user['sila']+$user['lovk']+$user['inta']+$user['vinos']+$user['intel']+$user['mudra']+$user['stats'])
            ?>"></td>
        </tr>
        <?
          if ($user["room"]!=31 && $user["room"]!=71) {
            echo "<tr><td><b>�������� �������:</b></td></tr>
            <tr><td>����</td><td><input type=\"text\" id=\"mec\" size=4 onblur=\"countmaster();\" value=\"$tec[mec]\" name=\"mec\"> ".($tec1["mec"]!=$tec["mec"]?"($tec1[mec])":"")."</td></tr>
            <tr><td>������, ������</td><td><input type=\"text\" id=\"dubina\" size=4 onblur=\"countmaster();\" value=\"$tec[dubina]\" name=\"dubina\"></td></tr>
            <tr><td>����, �������</td><td><input type=\"text\" id=\"noj\" size=4 onblur=\"countmaster();\" value=\"$tec[noj]\" name=\"noj\"></td></tr>
            <tr><td>������, ������</td><td><input type=\"text\" id=\"topor\" size=4 onblur=\"countmaster();\" value=\"$tec[topor]\" name=\"topor\"></td></tr>
            <tr><td>���������� ������</td><td><input type=\"text\" id=\"posoh\" size=4 onblur=\"countmaster();\" value=\"$tec[posoh]\" name=\"posoh\"></td></tr>
            <tr><td><b>�������� ������:</b></td></tr>
            <tr><td>����� ����</td><td><input type=\"text\" id=\"mfire\" size=4 onblur=\"countmaster();\" value=\"$tec[mfire]\" name=\"mfire\"></td></tr>
            <tr><td>����� ����</td><td><input type=\"text\" id=\"mwater\" size=4 onblur=\"countmaster();\" value=\"$tec[mwater]\" name=\"mwater\"></td></tr>
            <tr><td>����� �������</td><td><input type=\"text\" id=\"mair\" size=4 onblur=\"countmaster();\" value=\"$tec[mair]\" name=\"mair\"></td></tr>
            <tr><td>����� �����</td><td><input type=\"text\" id=\"mearth\" size=4 onblur=\"countmaster();\" value=\"$tec[mearth]\" name=\"mearth\"></td></tr>
            <tr><td>����� �����</td><td><input type=\"text\" id=\"mlight\" size=4 onblur=\"countmaster();\" value=\"$tec[mlight]\" name=\"mlight\"></td></tr>
            <tr><td>����� �����</td><td><input type=\"text\" id=\"mgray\" size=4 onblur=\"countmaster();\" value=\"$tec[mgray]\" name=\"mgray\"></td></tr>
            <tr><td>����� ����</td><td><input type=\"text\" id=\"mdark\" size=4 onblur=\"countmaster();\" value=\"$tec[mdark]\" name=\"mdark\"></td></tr>
            <tr><td>���������</td><td><input type=\"text\" id=\"master\" name=\"master\" size=4 disabled value=\"$maxmaster\"></td></tr>
            <script>
            function countmaster() {
              if (document.getElementById('mec').value=='') document.getElementById('mec').value=0;
              if (document.getElementById('topor').value=='') document.getElementById('topor').value=0;
              if (document.getElementById('dubina').value=='') document.getElementById('dubina').value=0;
              if (document.getElementById('noj').value=='') document.getElementById('noj').value=0;
              if (document.getElementById('posoh').value=='') document.getElementById('posoh').value=0;

              if (parseInt(document.getElementById('mec').value)>5) document.getElementById('mec').value=5;
              if (parseInt(document.getElementById('topor').value)>5) document.getElementById('topor').value=5;
              if (parseInt(document.getElementById('dubina').value)>5) document.getElementById('dubina').value=5;
              if (parseInt(document.getElementById('noj').value)>5) document.getElementById('noj').value=5;
              if (parseInt(document.getElementById('posoh').value)>5) document.getElementById('posoh').value=5;

              if (document.getElementById('mfire').value=='') document.getElementById('mfire').value=0;
              if (document.getElementById('mwater').value=='') document.getElementById('mwater').value=0;
              if (document.getElementById('mair').value=='') document.getElementById('mair').value=0;
              if (document.getElementById('mearth').value=='') document.getElementById('mearth').value=0;
              if (document.getElementById('mlight').value=='') document.getElementById('mlight').value=0;
              if (document.getElementById('mgray').value=='') document.getElementById('mgray').value=0;
              if (document.getElementById('mdark').value=='') document.getElementById('mdark').value=0;

              if (parseInt(document.getElementById('mfire').value)>10) document.getElementById('mfire').value=10;
              if (parseInt(document.getElementById('mwater').value)>10) document.getElementById('mwater').value=10;
              if (parseInt(document.getElementById('mair').value)>10) document.getElementById('mair').value=10;
              if (parseInt(document.getElementById('mearth').value)>10) document.getElementById('mearth').value=10;
              if (parseInt(document.getElementById('mlight').value)>10) document.getElementById('mlight').value=10;
              if (parseInt(document.getElementById('mgray').value)>10) document.getElementById('mgray').value=10;
              if (parseInt(document.getElementById('mdark').value)>10) document.getElementById('mdark').value=10;

              document.getElementById('master').value=$maxmaster-(parseInt(document.getElementById('mec').value)+parseInt(document.getElementById('dubina').value)+parseInt(document.getElementById('noj').value)+parseInt(document.getElementById('topor').value)+parseInt(document.getElementById('posoh').value)+parseInt(document.getElementById('mfire').value)+parseInt(document.getElementById('mwater').value)+parseInt(document.getElementById('mair').value)+parseInt(document.getElementById('mearth').value)+parseInt(document.getElementById('mlight').value)+parseInt(document.getElementById('mgray').value)+parseInt(document.getElementById('mdark').value));
            }
            </script>
            ";
          }
        ?>
    </table>
    <input type="submit" OnClick="countall(); if (document.getElementById('stats').value!=0) { alert('������ ������������� ������! '); return false; } <? if ($user["room"]!=31) echo "countmaster(); if (document.getElementById('master').value!=0) { alert('������ ������������� ��������! '); return false; }"; ?>" value="���������/��������">
</form>
<br>
<?
  if (@$_GET["id"] && $user["room"]!=31 && $user["room"]!=71) {
    echo "<b>���������� ����������:</b><br><br>";
    $i=0;
    $rzs=array(1,11,12,13,30,2,21,22,23,24,25,26,27,3,4,41,42);
    foreach ($rzs as $k=>$v) {
      $i++;
      echo "<a href=\"towerstamp.php?id=$_GET[id]&type=$v#equip\">".otdelname($v)."</a><br>";
    }
    echo "<br><a href=\"towerstamp.php?id=$_GET[id]#equip\">�� ���������</a><br>";
    

  }
?>
</td><td valign="top" style="padding-left:40px">
<?
  if ($tec && $user["room"]!=31 && $user["room"]!=71) {
    echo "<a name=\"dressed\"></a><center><b>����������:</b></center><br>
    �� ��������� ������:<br><br>";
    do {
      $dropped=0;
      $dress=array();
      $r=mq("select id, img, name, nsila, nlovk, ninta, nvinos, nintel, nmudra, nmech, nnoj, ndubina, ntopor, nposoh 
      from inventory where ".dresscond($tec, "id"));
      while ($rec=mysql_fetch_assoc($r)) {
        if ($rec["nsila"]>$tec1["sila"] || $rec["nlovk"]>$tec1["lovk"] || $rec["ninta"]>$tec1["inta"] || $rec["nintel"]>$tec1["intel"] || $rec["nmudra"]>$tec1["mudra"] 
        || $rec["nmech"]>$tec1["mec"] || $rec["nnoj"]>$tec1["noj"] || $rec["ndubina"]>$tec1["dubina"] || $rec["ntopor"]>$tec1["topor"] || $rec["nposoh"]>$tec1["posoh"]) {
          $dropped=1;
          foreach ($dressslots as $k=>$v) {
            if ($tec[$v]==$rec["id"]) {
              //echo "Undressing $v ($rec[name])<br>";
              mq("update deztow_charstams set $v=0 where id='$tec[id]'");
            }
          }
        }
        $dress[$rec["id"]]="<a href=\"towerstamp.php?id=$_GET[id]&undressitem=qqq#dressed\"><img title=\"$rec[name]\" border=\"0\" src=\"".IMGBASE."/i/sh/$rec[img]\"></a>";
      }
      if ($dropped) {
        $tec=mqfa("SELECT * FROM `deztow_charstams` WHERE `owner` = '{$_SESSION['uid']}' AND `id`='".$_GET['id']."' and room='$statsroom'");
        maketec1();
      }
    } while ($dropped);
    foreach ($dressslots as $k=>$v) {
      if (@$dress[$tec[$v]]) $dressed[$v]=str_replace("qqq","$k",$dress[$tec[$v]]);
    }
    function showdressed($dressed, $user) {
      global $dressslots;
      $ret="<table cellspacing=0 cellpadding=0>
      <tr><td width=\"60\">";
      $i=0;
      foreach ($dressslots as $k=>$v) {
        $i++;
        if ($dressed[$v]) $ret.=$dressed[$v];
        elseif ($v!="rybax" && $v!="plaw") $ret.="<img src=\"".IMGBASE."/i/empty$v.gif\">";
        if ($i==7) $ret.="<td><img src=\"".IMGBASE."/i/shadow/$user[sex]/$user[shadow]\"></td><td width=\"60\">";
      }
      $ret.="</td></tr></table>";
      return $ret;
    }
    echo showdressed($dressed, $user);
    echo "<a name=\"equip\"></a><div>&nbsp;</div><h3>".(@$_GET["type"]?otdelname($_GET["type"]):"��������� ����������").":</h3>";
    $cond="";
    foreach ($dressslots as $k=>$v) {
      if ($v=="weap" || $v=="shit") $cond.=" and (id<>".$tec[$v]." or second=1) ";
      elseif ($v!="r1" && $v!="r2" && $v!="r3") $cond.=" and id<>".$tec[$v];
    }
    if ($_GET["type"]) $r=mq("select * from inventory where owner='$user[room]' and otdel='$_GET[type]' order by id");
    else $r=mq("select * from inventory where owner='$user[room]' and nsila<=$tec1[sila] and nlovk<=$tec1[lovk] and ninta<=$tec1[inta] and nvinos<=$tec1[vinos] and nintel<=$tec1[intel] and nmudra<=$tec1[mudra] and nmech<=$tec1[mec] and nnoj<=$tec1[noj] and ndubina<=$tec1[dubina] and ntopor<=$tec1[topor] and nposoh<=$tec1[posoh] $cond order by id");
    echo "<table cellspacing=0 style=\"border:solid #cccccc 1px\">";
    $i=0;
    $tec1["level"]=9;
    while ($rec=mysql_fetch_assoc($r)) {
      $i++;
      $rec["count"]=-1;
      echo "<tr><td ".($i%2==0?"bgcolor=\"#cccccc\" style=\"border-right:solid #eeeeee 1px;padding-left:20px;padding-right:20px\"":"style=\"border-right:solid #cccccc 1px;padding-left:20px;padding-right:20px\"")." valign=\"top\" align=\"center\"><br>
      <b>$rec[name]</b><br><br>
      <a href=\"towerstamp.php?id=$_GET[id]&dressitem=$rec[id]&type=$_GET[type]#dressed\"><img title=\"$rec[name]\" border=\"0\" src=\"".IMGBASE."/i/sh/$rec[img]\"></a></td>
      <td style=\"padding: 10px 20px 10px 20px\" valign=\"top\" ".($i%2==0?"bgcolor=\"#cccccc\"":"").">".itemreqs($rec, $tec1)."<div>&nbsp;</div>".itemmfs($rec)."</td>";
      echo "</tr>";
    }
    echo "</table>";
  }
?>
</td></tr></table>
</body>
</html>

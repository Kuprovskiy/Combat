<?php
session_start();
if ($_SESSION['uid'] == null) header("Location: index.php");
include "connect.php";
$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '".mysql_real_escape_string($_SESSION['uid'])."' LIMIT 1;"));
include "functions.php";
$al = mysql_fetch_assoc(mysql_query("SELECT * FROM `aligns` WHERE `align` = '".mysql_real_escape_string($user['align'])."' LIMIT 1;"));
header("Cache-Control: no-cache");
if ($user['align']<2 || $user['align']>3) header("Location: index.php");
?>
<HTML>
<HEAD>
<link rel=stylesheet type="text/css" href="i/maina.css">
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
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=0 marginheight=0>
<table align=right><tr><td><INPUT TYPE="button" class=btn onClick="location.href='main.php';" value="���������" title="���������"></table>
<table align=right><tr><td><INPUT TYPE="button" class=btn onClick="location.href='admin.php';" value="��������" title="��������"></table>
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


			
//������ �����	
	if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>������ ���������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>level</td><td><input type='text' name='level' value='",$_POST['level'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['level']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `level` = '".$_POST['level']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>������ ��������� ",$dd[1]," ������� �� ",$_POST['level'],"</font><BR>";
					}
				}
	echo "</fieldset></form>";	}
//������� ���	
	if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>������� ���</legend>
					<table><tr><td>�� �����</td><td><input type='text' name='id' value='",$_POST['id'],"'></td><td>����� ���</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['id'] && $_POST['login']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `id` FROM `users` WHERE `id` = '".$_POST['id']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `login` = '".$_POST['login']."' WHERE `id` = '".$_POST['id']."';");
						echo "<font color=red>��� ��� ",$dd[1]," ������� �� ",$_POST['login'],"</font><BR>";
					}
				}
	echo "</fieldset></form>";	}
//������� ������	
	if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>������� ������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>����� ������</td><td><input type='text' name='pass' value='",$_POST['pass'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['pass']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `pass` = '".$_POST['pass']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>������ ��������� ",$dd[1]," ������� �� ",$_POST['pass'],"</font><BR>";
					}
				}
	echo "</fieldset></form>";	}
//������� 2������	
	if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>������� ������  ������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>����� ������  ������</td><td><input type='text' name='pass2' value='",$_POST['pass2'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['pass2']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `pass2` = '".$_POST['pass2']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>������ ��������� ",$dd[1]," ������� �� ",$_POST['pass2'],"</font><BR>";
					}
				}
	echo "</fieldset></form>";	}
//������� ����	
	if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>������� ����</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>����� ����</td><td><input type='text' name='klan' value='",$_POST['klan'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['klan']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `klan` = '".$_POST['klan']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>���� ��������� ",$dd[1]," ������� �� ",$_POST['klan'],"</font><BR>";
					}
				}
	echo "</fieldset></form>";	}
//������� �����			
			if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�����</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>stats</td><td><input type='text' name='stats' value='",$_POST['stats'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['stats']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `stats` = '".$_POST['stats']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>�� ������ ������ ",$dd[1]," ��������� ����� ",$_POST['stats'],"</font><BR>";
					}
				}
				echo "</fieldset></form>";	}		
//������� ������			
			if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>master</td><td><input type='text' name='master' value='",$_POST['master'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['master']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `master` = '".$_POST['master']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>�� ������ ������ ",$dd[1]," ��������� ������ ",$_POST['master'],"</font><BR>";
					}
				}
				echo "</fieldset></form>";	}									
//�������� ������				
				if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� ������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������</td><td><input type='text' name='status' value='",$_POST['status'],"'></td><td><input type=submit value='��������' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['status']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `status` = '".$_POST['status']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>������ ",$dd[1]," ������� �� ",$_POST['status'],"</font><BR>";
					}
				}
echo "</fieldset></form>";	}		
//Be�����				
				if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>������� ��</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������?</td><td><input type='text' name='bejenec' value='",$_POST['bejenec'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['bejenec']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `bejenec` = '".$_POST['bejenec']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>������� ",$dd[1]," ������� �� ",$_POST['bejenec'],"</font><BR>";
					}
				}
echo "</fieldset></form>";	}
//medal			
				if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>���</td><td><input type='text' name='medals' value='",$_POST['medals'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['medals']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `medals` = '".$_POST['medals']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>������ ",$dd[1]," ������� �� ",$_POST['medals'],"</font><BR>";
					}
				}
echo "</fieldset></form>";	}
//aligns			
				if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>align</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>align</td><td><input type='text' name='align' value='",$_POST['align'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['align']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `align` = '".$_POST['align']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>align ",$dd[1]," ������� �� ",$_POST['align'],"</font><BR>";
					}
				}
echo "</fieldset></form>";	}
//deal				
				if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>deal</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>deal</td><td><input type='text' name='deal' value='",$_POST['deal'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['deal']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `deal` = '".$_POST['deal']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>deal ��������� ",$dd[1]," ������� �� ",$_POST['deal'],"</font><BR>";
					}
				}
echo "</fieldset></form>";	}
//�������� ���				
				if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>������� �������� ���</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>����� ���</td><td><input type='text' name='realname' value='",$_POST['realname'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['realname']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `realname` = '".$_POST['realname']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>�������� ��� ��������� ",$dd[1]," ������� �� ",$_POST['realname'],"</font><BR>";
					}
				}
echo "</fieldset></form>";	}
//borndate				
				if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>������� ����</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>����� ����</td><td><input type='text' name='borndate' value='",$_POST['borndate'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['borndate']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `borndate` = '".$_POST['borndate']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>���� �������� ��������� ",$dd[1]," ������� �� ",$_POST['borndate'],"</font><BR>";
					}
				}
echo "</fieldset></form>";	}
//email				
				if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>������� ����</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>����� ����</td><td><input type='text' name='email' value='",$_POST['email'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['email']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `email` = '".$_POST['email']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>���� ��������� ",$dd[1]," ������� �� ",$_POST['email'],"</font><BR>";
					}
				}
echo "</fieldset></form>";	}
//icq				
				if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>������� icq</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>����� icq</td><td><input type='text' name='icq' value='",$_POST['icq'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['icq']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `icq` = '".$_POST['icq']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>icq ��������� ",$dd[1]," ������� �� ",$_POST['icq'],"</font><BR>";
					}
				}
echo "</fieldset></form>";	}
//sex				
				if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>������� ���</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>����� ���</td><td><input type='text' name='sex' value='",$_POST['sex'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['sex']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `sex` = '".$_POST['sex']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��� ��������� ",$dd[1]," ������� �� ",$_POST['sex'],"</font><BR>";
					}
				}
echo "</fieldset></form>";	}
//�������� ��������				
				if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>������� �������� ��������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>����� �. ��������</td><td><input type='text' name='http' value='",$_POST['http'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['http']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `http` = '".$_POST['http']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>�������� �������� ��������� ",$dd[1]," ������� �� ",$_POST['http'],"</font><BR>";
					}
				}
echo "</fieldset></form>";	}
//���� ��������� � ����				
				if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>������� ���� ��������� � ����</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>����� ����</td><td><input type='text' name='color' value='",$_POST['color'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['color']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `color` = '".$_POST['color']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>���� ��������� ��������� ",$dd[1]," ������� �� ",$_POST['color'],"</font><BR>";
					}
				}
echo "</fieldset></form>";	}
//������ ���������				
				if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>������ ���������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������</td><td><input type='text' name='win' value='",$_POST['win'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['win']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `win` = '".$_POST['win']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>������ ��������� ",$dd[1]," ������� �� ",$_POST['win'],"</font><BR>";
					}
				}
echo "</fieldset></form>";	}
//��������� ���������				
				if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>��������� ���������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>���������</td><td><input type='text' name='lose' value='",$_POST['lose'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['lose']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `lose` = '".$_POST['lose']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ��������� ",$dd[1]," ������� �� ",$_POST['lose'],"</font><BR>";
					}
				}
echo "</fieldset></form>";	}
//���� ���������				
				if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>���� ���������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>����</td><td><input type='text' name='nich' value='",$_POST['nich'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['nich']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `nich` = '".$_POST['nich']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>���� ��������� ",$dd[1]," ������� �� ",$_POST['nich'],"</font><BR>";
					}
				}
echo "</fieldset></form>";	}
//�������� 2				
				if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������?</td><td><input type='text' name='room' value='",$_POST['room'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['room']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `room` = '".$_POST['room']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>������ ",$dd[1]," ������� �� ",$_POST['room'],"</font><BR>";
					}
				}
echo "</fieldset></form>";	}

//Fbattle code delete-��� �� ����� �� ���				
				if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� � ���</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>��������(0)</td><td><input type='text' name='battle' value='",$_POST['battle'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['battle']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `battle` = '".$_POST['battle']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>battle ",$dd[1]," ������� �� ",$_POST['battle'],"</font><BR>";						
					}
				}
echo "</fieldset></form>";	}

//Shadow-Obraz				
				if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>������ �����(������ ����.gif)</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>����</td><td><input type='text' name='shadow' value='",$_POST['shadow'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['shadow']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `shadow` = '".$_POST['shadow']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>����� ",$dd[1]," ������� �� ",$_POST['shadow'],"</font><BR>";
					}
				}
echo "</fieldset></form>";	}
//Kr
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� ��</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������� ��?</td><td><input type='text' name='money' value='",$_POST['money'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['money']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `money` = '".$_POST['money']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1]," �� ",$_POST['money'],"</font><BR>";
					}
				}
echo "</fieldset></form>";	}
//Ekr
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� E��</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������� e��?</td><td><input type='text' name='ekr' value='",$_POST['ekr'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['ekr']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `ekr` = '".$_POST['ekr']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1]," E�P ",$_POST['ekr'],"</font><BR>";
					}
				}
echo "</fieldset></form>";	}
//zub
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� ���</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������� ���?</td><td><input type='text' name='zubs' value='",$_POST['zubs'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['zubs']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `zubs` = '".$_POST['zubs']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1]," ��� ",$_POST['zubs'],"</font><BR>";
					}
				}
echo "</fieldset></form>";	}
//���� �����
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� O���</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������� O���?</td><td><input type='text' name='honorpoints' value='",$_POST['honorpoints'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['honorpoints']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `honorpoints` = '".$_POST['honorpoints']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1]," O��� ",$_POST['honorpoints'],"</font><BR>";
					}
				}
echo "</fieldset></form>";	}
//hp
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� hp</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������� </td><td><input type='text' name='hp' value='",$_POST['hp'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['hp']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `hp` = '".$_POST['hp']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['hp']," </font><BR>";
					}
				}
echo "</fieldset></form>";	}
//���hp
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� maxhp</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������� </td><td><input type='text' name='maxhp' value='",$_POST['maxhp'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['maxhp']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `maxhp` = '".$_POST['maxhp']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['maxhp']," </font><BR>";
					}
				}
echo "</fieldset></form>";	}
//mana
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� Mana</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������� </td><td><input type='text' name='mana' value='",$_POST['mana'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['mana']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `mana` = '".$_POST['mana']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['mana']," </font><BR>";
					}
				}
echo "</fieldset></form>";	}
//maxmana
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� maxMana</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������� </td><td><input type='text' name='maxmana' value='",$_POST['maxmana'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['maxmana']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `maxmana` = '".$_POST['maxmana']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['maxmana']," </font><BR>";
					}
				}
echo "</fieldset></form>";	}
//exp
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� ���</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������� </td><td><input type='text' name='exp' value='",$_POST['exp'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['exp']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `exp` = '".$_POST['exp']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['exp']," </font><BR>";
					}
				}
echo "</fieldset></form>";	}
//nextup
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� next���</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������� </td><td><input type='text' name='nextup' value='",$_POST['nextup'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['nextup']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `nextup` = '".$_POST['nextup']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['nextup']," </font><BR>";
					}
				}
echo "</fieldset></form>";	}
//���� sila
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� ����</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>�������? </td><td><input type='text' name='sila' value='",$_POST['sila'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['sila']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `sila` = '".$_POST['sila']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['sila']," </font><BR>";
					}
				}
echo "</fieldset></form>";	}
//�������� lovk
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� ��������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>�������? </td><td><input type='text' name='lovk' value='",$_POST['lovk'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['lovk']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `lovk` = '".$_POST['lovk']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['lovk']," </font><BR>";
					}
				}
echo "</fieldset></form>";	}
//��������  inta
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� ��������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>�������? </td><td><input type='text' name='inta' value='",$_POST['inta'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['inta']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `inta` = '".$_POST['inta']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['inta']," </font><BR>";
					}
				}
echo "</fieldset></form>";	}
//������������  vinos
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� ������������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>�������? </td><td><input type='text' name='vinos' value='",$_POST['vinos'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['vinos']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `vinos` = '".$_POST['vinos']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['vinos']," </font><BR>";
					}
				}
echo "</fieldset></form>";	}
//��������� intel
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� ���������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>�������? </td><td><input type='text' name='intel' value='",$_POST['intel'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['intel']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `intel` = '".$_POST['intel']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['intel']," </font><BR>";
					}
				}
echo "</fieldset></form>";	}
//��������  mudra
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� ��������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>�������? </td><td><input type='text' name='mudra' value='",$_POST['mudra'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['mudra']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `mudra` = '".$_POST['mudra']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['mudra']," </font><BR>";
					}
				}
echo "</fieldset></form>";	}
//����������  spirit
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� ����������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>�������? </td><td><input type='text' name='spirit' value='",$_POST['spirit'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['spirit']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `spirit` = '".$_POST['spirit']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['spirit']," </font><BR>";
					}
				}
echo "</fieldset></form>";	}
//����  will
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� ����</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>�������? </td><td><input type='text' name='will' value='",$_POST['will'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['will']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `will` = '".$_POST['will']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['will']," </font><BR>";
					}
				}
echo "</fieldset></form>";	}
//������� ����  freedom
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� ������� ����</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>�������? </td><td><input type='text' name='freedom' value='",$_POST['freedom'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['freedom']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `freedom` = '".$_POST['freedom']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['freedom']," </font><BR>";
					}
				}
echo "</fieldset></form>";	}
//��������������  god
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� ��������������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>�������? </td><td><input type='text' name='god' value='",$_POST['god'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['god']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `god` = '".$_POST['god']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['god']," </font><BR>";
					}
				}
echo "</fieldset></form>";	}
//���������� �������� ������  mec
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� ���������� � ������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>�������? </td><td><input type='text' name='mec' value='",$_POST['mec'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['mec']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `mec` = '".$_POST['mec']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['mec']," </font><BR>";
					}
				}
echo "</fieldset></form>";	}
//���������� �������� ��������, ��������  dubina
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� ���������� � ��������, ��������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>�������? </td><td><input type='text' name='dubina' value='",$_POST['dubina'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['dubina']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `dubina` = '".$_POST['dubina']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['dubina']," </font><BR>";
					}
				}
echo "</fieldset></form>";	}
//���������� �������� ������, ���������  noj
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� ���������� � ������, ���������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>�������? </td><td><input type='text' name='noj' value='",$_POST['noj'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['noj']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `noj` = '".$_POST['noj']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['noj']," </font><BR>";
					}
				}
echo "</fieldset></form>";	}
//���������� �������� ��������, ��������  topor
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� ���������� � ��������, ��������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>�������? </td><td><input type='text' name='topor' value='",$_POST['topor'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['topor']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `topor` = '".$_POST['topor']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['topor']," </font><BR>";
					}
				}
echo "</fieldset></form>";	}
//���������� �������� ����������� ��������  posoh
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� ���������� � ����������� ��������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>�������? </td><td><input type='text' name='posoh' value='",$_POST['posoh'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['posoh']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `posoh` = '".$_POST['posoh']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['posoh']," </font><BR>";
					}
				}
echo "</fieldset></form>";	}
//nanesyoniy udar
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� <img src=i/misc/micro/hit.gif></legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������� </td><td><input type='text' name='hit' value='",$_POST['hit'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['hit']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `hit` = '".$_POST['hit']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['hit']," </font><img src=/i/misc/micro/hit.gif><BR>";
					}
				}
echo "</fieldset></form>";	}
//krit udar
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� <img src=/i/misc/micro/krit.gif></legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������� </td><td><input type='text' name='krit' value='",$_POST['krit'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['krit']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `krit` = '".$_POST['krit']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['krit']," </font><img src=i/misc/micro/krit.gif><BR>";
					}
				}
echo "</fieldset></form>";	}
//����
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� <img src=/i/misc/micro/counter.gif></legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������� </td><td><input type='text' name='counter' value='",$_POST['counter'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['counter']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `counter` = '".$_POST['counter']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['counter']," </font><img src=/i/misc/micro/counter.gif><BR>";
					}
				}
echo "</fieldset></form>";	}
//����
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� <img src=/i/misc/micro/block.gif></legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������� </td><td><input type='text' name='block2' value='",$_POST['block2'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['block2']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `block2` = '".$_POST['block2']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['block2']," </font><img src=/i/misc/micro/block.gif><BR>";
					}
				}
echo "</fieldset></form>";	}
//parry
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� <img src=/i/misc/micro/parry.gif></legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������� </td><td><input type='text' name='parry' value='",$_POST['parry'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['parry']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `parry` = '".$_POST['parry']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['parry']," </font><img src=/i/misc/micro/parry.gif><BR>";
					}
				}
echo "</fieldset></form>";	}
//hp2
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� <img src=/i/misc/micro/hp.gif></legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������� </td><td><input type='text' name='hp2' value='",$_POST['hp2'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['hp2']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `hp2` = '".$_POST['hp2']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['hp2']," </font><img src=/i/misc/micro/hp.gif><BR>";
					}
				}
echo "</fieldset></form>";	}
//s_duh
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>�������� <img src=/i/misc/micro/spirit.gif></legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>������� </td><td><input type='text' name='s_duh' value='",$_POST['s_duh'],"'></td><td><input type=submit value='�����' class=btn></td></tr></table>";
				if ($_POST['login'] && $_POST['s_duh']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `s_duh` = '".$_POST['s_duh']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>��������� ",$dd[1],"  ",$_POST['s_duh']," </font><img src=/i/misc/micro/spirit.gif><BR>";
					}
				}
echo "</fieldset></form>";	}


?>
<?}
////����� ������ by Cruel
?>
</body>
</html>
<?php
	session_start();
	if ($_SESSION['uid'] == null) header("Location: index.php");
	include "connect.php";
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
	include "functions.php";
	$al = mysql_fetch_assoc(mysql_query("SELECT * FROM `aligns` WHERE `align` = '{$user['align']}' LIMIT 1;"));
	header("Cache-Control: no-cache");
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

</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=0 marginheight=0 bgcolor=#e2e0e0 >
<table align=right><tr><td><INPUT TYPE="button" onclick="location.href='main.php';" value="Вернуться" title="Вернуться"></table>

<?php
if ($user['align'] == '2.7'  || $user['align'] == '77'  || $user['align'] == '2.5' || $user['align'] == '2.6') {
		
			echo "<h3>Панель Благородства персонажа {$user['login']}!</h3>";
		}

		if ($user['align'] == '2.7'  || $user['align'] == '77'  || $user['align'] == '2.5' || $user['align'] == '2.6') {
				echo "<form method=post><fieldset><legend>Начислить благородство</legend>
					<table><tr><td>Логин</td><td><input type='text' name='login' value='",$_POST['login'],"'></td><td>Благородства</td><td><input type='text' name='honorpoints' value='",$_POST['honorpoints'],"'></td><td><input type=submit value='Начислить'></td></tr></table>";
				if ($_POST['login'] && $_POST['honorpoints']) {
					$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if($dd) {
						mysql_query("UPDATE `users` SET `honorpoints` = `honorpoints`+'".$_POST['honorpoints']."' WHERE `login` = '".$_POST['login']."';");
						echo "<font color=red>Начислено ",$_POST['honorpoints']," благородства</font><BR>";
					}
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
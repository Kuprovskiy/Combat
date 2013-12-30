<?php
ob_start("ob_gzhandler");
	session_start();
	if ($_SESSION['uid'] == null) header("Location: index.php");
	include "connect.php";	
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
	include "functions.php";
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

var Hint3Name = '';
// Заголовок, название скрипта, имя поля с логином
function findlogin(title, script, name){
	document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
	'<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><form action="'+script+'" method=POST><INPUT TYPE=hidden name=sd4 value="6"><td colspan=2>'+
	'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD width=50% align=right><INPUT TYPE=text NAME="'+name+'"></TD><TD width=50%><INPUT TYPE="submit" value=" »» "></TD></TR></FORM></TABLE></td></tr></table>';
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
function closehint3(){
	document.all("hint3").style.visibility="hidden";
    Hint3Name='';
}
</script>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=0 marginheight=0 bgcolor=#e2e0e0><div id=hint3 class=ahint></div>
<table width=100%>
<tr>
	<td align=right>
		<INPUT TYPE="button" onclick="location.href='main.php';" value="Вернуться" title="Вернуться">
	</td>
</tr>
<tr>
	<td valign=top>
		<center>
			<h3><A HREF="javascript:top.AddToPrivate('tar', top.CtrlPress)" target=refreshed><img src="i/lock.gif" width=20 height=15></A> Тарманы </h3>		
		<table>
			<tr>
			<td>
				<?
					$data=mysql_query("SELECT `id`, `login`, `status`, `level`, `room`, `align`, (select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = users.`id`) as `online` FROM `users` WHERE `align` > 3 and `align` < 3.999 order by  align desc, login asc ;");	
					while ($row = mysql_fetch_array($data)) {
						if ($row['online']>0) {
							echo '<A HREF="javascript:top.AddToPrivate(\'',$row['login'],'\', top.CtrlPress)" target=refreshed><img src="i/lock.gif" width=20 height=15></A>';
							nick2($row['id']);
							if($row['room'] > 500 && $row['room'] < 561) {
								$rrm = 'Башня смерти, участвует в турнире';
							}
							else {
								$rrm = $rooms[$row['room']];
							}
							echo ' - ',$row['status'],' - <i>',$rrm,'</i><BR>';
						}
					}
					$data=mysql_query("SELECT `id`, `login`, `status`, `level`, `room`, `align`, (select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = users.`id`) as `online` FROM `users` WHERE `align` > 3 and `align` < 3.999 order by  align desc, login asc ;");	
					while ($row = mysql_fetch_array($data)) {
						if ($row['online']<1) {
							echo '<img src="i/lock1.gif" width=20 height=15>';
							nick2($row['id']);
							echo ' - ',$row['status'],' - <i><small><font color=gray>персонаж не в клубе</font></small></i><BR>';
						}
					}
				?>
			</td>
			</tr>
		</table>
		</center>
	</td>

</tr>
</table>
</body>
</html>
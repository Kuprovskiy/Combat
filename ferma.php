<?php
	session_start();
	if ($_SESSION['uid'] == null) header("Location: index.php");
	include "connect.php";
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
	include "functions.php";
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
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=e2e0e0>
	<div id=hint4 class=ahint></div>
	<TABLE cellspacing=0 cellpadding=2 width=100%>
<TD style="width: 40%; vertical-align: top; "><TABLE cellspacing=0 cellpadding=2 style="width: 100%; ">
<TD align=center><h4>Ваша ферма</h4></TD>
</TR>
<TR>
</head>
<TD bgcolor=efeded nowrap>
<?

?>

<object width='620' height='434'><param name='movie' value='http://www.GamesForWork.com/games/swf/The Farmer may 7th 2007.swf'></param><embed src='http://www.GamesForWork.com/games/swf/The Farmer may 7th 2007.swf' type='application/x-shockwave-flash' width='620' height='434'></embed></object>

<TR><TD style="text-align: left; "><small><small> <b>http://lostcombats.com/<?echo $user["id"]?></b><br>
<Br></small></div></TD>
</TR>
</TABLE></TD>
<TD style="width: 5%; vertical-align: top; ">&nbsp;</TD>
<TD style="width: 25%; vertical-align: top; text-align: right; "><INPUT type='button' value='Обновить' style='width: 75px' onclick='location="/ferma.php"'>
&nbsp;<INPUT TYPE=button value="Вернутся" style='width: 75px' onClick="location.href='main.php'"></TD>
</TR>
</TABLE>
<br><div align=left>
	<?php include("mail_ru.php"); ?>
<div>
</body>
</html>
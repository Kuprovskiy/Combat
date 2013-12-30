<?
if(!empty($_GET['exit'])){session_start(); session_destroy();}
	if((int)date("H") > 5 && (int)date("H") < 22) {$sutk="day";}else{$sutk="night";}
?>
<html>
	
<html>
<head>
  <title>NewabK</title>
  <link href="i/main.css"
 type="text/css" rel="stylesheet">
  <meta http-equiv="Content-type"
 content="text/html; charset=windows-1251">
  <meta http-equiv="Cache-Control"
 content="no-cache">
  <meta http-equiv="PRAGMA"
 content="NO-CACHE">
  <meta http-equiv="Expires"
 content="0">
  <meta name="keywords"
 content="игра, играть, игрушки, онлайн,online, интернет, internet, RPG, fantasy, фэнтези, меч, топор, магия, кулак, удар, блок, атака, защита, Бойцовский Клуб, бой, битва, отдых, обучение, развлечение, виртуальная реальность, рыцарь, маг, знакомства, чат, лучший, форум, свет, тьма, bk, games, клан, банк, магазин, клан, БК, combats, Бойцовский клуб, История, Предметы БК, БК 2003, Броня Печали, Ветераны, Старый клуб, Старый БК, Старый бойцовский клуб, Ностальгия, antibk, antikombatz, online, online rpg, rpg">
  <style type="text/css">
body {background-color: #000;}
/* Тело страницы */
.page {width: 95%; margin: 0px auto; overflow: hidden; zoom: 1;}
/* Контент */
.leftcol {background-repeat: no-repeat; width: 80%; height: 519; background-image: url(fon_day.jpg); float: left }
.rightcol { width: 20%; height: 100%; float: right}
.logo {background-repeat: no-repeat; background-image: url(townlogo.jpg); width: 100%; height: 60px;}
#forms{margin-top: 30px;}
#forms input{
margin-left: 10px;
margin-bottom: 2px;
margin-right: 0;
margin-top: 2px;
text-align: right;
color: #bababa;
border-width: thin;
border-style: solid;
border-color: #474747;
background-color: #282828;
float:right;
font-size:14px;
padding:4px 2px;
width:200px;
}
.btn {	FONT-SIZE: 7.5pt;
	COLOR: #bababa;
	FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;
	BACKGROUND-COLOR: #282828;
	border: 1px double #474747;
}
  </style>
</head>
<body>
<center><font color=white></font></center>
<table width=100% height=100%><td><img src=fon_<?=$sutk?>.jpg></td><td width=100% height=100%>&nbsp;</td><td align=right>


<img src=townlogo.jpg>
<TABLE align=right>
<FORM method=post action=/enter.php>
<TBODY>
<TR align=right><TD><div id="forms"><INPUT onclick="value=''" value=nickname maxLength=40 name=login><INPUT onclick="value=''" value="" maxLength=21 type=password name=psw></div></TD></TR>
<TR align=right><TD colSpan=2 align=right><INPUT class=btn onclick="this.blur(); " value=" Войти -> " type=submit></TD></TR></FORM></TBODY></TABLE>


<div align="right"><br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<a href="rememberpassword.php"><img
 src="index/passremember.jpg"></a><br>
<a href="register.php"><img
 src="index/reg.jpg"></a><br>
<br>
<a href="forum.php"><img
 src="index/forum.jpg"></a><br>
<a href="news.php"><img
 src="index/news.jpg"></a><br>
<a href="reit_pers.php"><img
 src="index/rating.jpg"></a><br>
<div
 style="font-size: 10px; letter-spacing: normal; font-style: normal; font-family: verdana; color: rgb(186, 186, 186); height: 20px;"
 align="right">
NewabK
2010 &copy;</div>
<div align="right"><?include('mail_ru.php')?></div>
</div>
</div>
</div>
<p></p>
<p></p>
<div>
</div>
</td></table>
</body>
</html>

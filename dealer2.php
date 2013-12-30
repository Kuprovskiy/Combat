<?php
session_start();
if ($_SESSION['uid'] == null) header("Location: index.php");
include "connect.php";
$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
include "functions.php";
header("Cache-Control: no-cache");
?>
<HTML>
<HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<style>
.td {font-size:11px}
.row {cursor:pointer;}
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
</head>
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=e2e0e0>
    <div id=hint4 class=ahint></div>
    <TABLE cellspacing=0 cellpadding=2 width=100%>
<TD style="width: 40%; vertical-align: top; "><TABLE cellspacing=0 cellpadding=2 style="width: 100%; ">
<TD align=center><h4>Алхимики</h4></TD>
</TR>
<TR>
<TD bgcolor=efeded nowrap>
<?
                    $data=mysql_query("SELECT `id`, `login`, `status`, `level`, `room`, `align`, (select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = users.`id`) as `online` FROM `users` WHERE `deal` IN ('1','2','3','4','5','6','7') order by online DESC, login asc ;");
                    while ($row = mysql_fetch_array($data)) {
                        if ($row['online']>0) {
                            echo '<A HREF="javascript:top.AddToPrivate(\'',nick7($row['id']),'\', top.CtrlPress)" target=refreshed><img src="i/lock.gif" width=20 height=15></A>';
                            nick2($row['id']);
                            if ($row['id'] == $user['deal']) {
                                echo ' - '.$row['status'].'';
                            }
                                $rrm = $rooms[$row['room']];
                            echo ' - <i>',$rrm,'</i><BR>';
                        }
                        if ($row['online']<1) {
                            echo '<font color=gray><img src="i/offline.gif" width=20 height=15 alt="Нет в клубе">';
                            nick2($row['id']);
                            if ($row['id'] == $user['deal']) {
                                echo ' - ',$row['status'],'';
                            }
                            echo ' - нет в клубе</font><BR>';
                        }
                    }
?>
<TR><TD style="text-align: left; "><small>Продаёт еврокредиты и прочие платные услуги сервиса<BR>
Вы можете отправить личное сообщение, даже если Вы и Алхимик находитесь в разных городах<br>
Курс покупки ЕвроКредитов:
</TR>
</TABLE></TD>
<TD style="width: 5%; vertical-align: top; ">&nbsp;</TD>
<TD style="width: 25%; vertical-align: top; text-align: right; "><INPUT type='button' value='Обновить' style='width: 75px' onclick='location="/dealer.php"'>
&nbsp;<INPUT TYPE=button value="Вернуться" style='width: 75px' onclick="location.href='main.php'"></TD>
</TR>
</TABLE>

<TABLE> 
<tr> 
<td align="right"> 
<? include "calculator.html"; ?>
</td>


<div style="width:200px;height:250px;border:1px solid #2D6AB4;background-color:#F0F0F0;">
<div style="background-color:#2D6AB4;height:18px;text-align:center;width:196px; margin:2px 0px 0px 2px;">
<a target="new" style="color:#FFFFFF;font-size:14px;font-weight:Bold;font-family:arial; text-decoration:none;" href="http://ru.fxexchangerate.com/">Курс: (1 доллар х 5 екр)</a></div>
<script type="text/javascript">var fm="RUB";var ft="USD";var hb="2D6AB4";var hc="FFFFFF";var bb="F0F0F0";var bo="2D6AB4";var tz="timezone";var wh="200x250";var lg="ru";</script>
<script type="text/javascript" src="http://www.fxexchangerate.com/converter.php"></script></div>

<TD valign="top"> 
<FIELDSET>
<LEGEND><B style="color: Blue;">Только эти.. других нет..</B> </LEGEND> Cпособы оплаты: <strong>Webmoney</strong>.
</FIELDSET>  
<br>
<FIELDSET>
<br><LEGEND><b>Webmoney</b></LEGEND> 
<strong>   Z</strong>235636282790 - $ <br>
<strong>   R</strong>232081361000 - Руб. <br>
<strong>   E</strong>374748637824 - Евро.  <br> 
<strong>   U</strong>122542544368 - Грн. <br> 
 </FIELDSET>
<TABLE> 
<tr> 

<img src="http://lostcombats.com/i/art.gif"
<td width="50%" valign="top"> 
<script type="text/javascript" src="http://www.24webclock.com/clock24.js"></script>
<table border="0" bgcolor="#a0a0a0" cellspacing=1 cellpadding=3 class="clock24st" style="line-height:14px; padding:0;">
<tr><td bgcolor="#FFFFFF" class="clock24std" style="font-family:arial; font-size:12px;">
<img src="http://lostcombats.com/i/deal.gif" width="14" height="14" border="0" alt="Не смотри на время ;) " align="left" hspace="2"></a>
<span class="clock24s" id="clock24_73787" style="color:#6393C3;">часы для сайта</span></a></td></tr>
</table>
<script type="text/javascript">
var clock24_73787 = new clock24('73787',180,'%yyyy/%mm/%dd %W %HH:%nn:%ss %P','ru');
clock24_73787.daylight('RU'); clock24_73787.refresh();
</script>
</tr>
<tr>
<td valign="top">
</TABLE> 
</TD> 
</TR> 
</TBODY> 
</TABLE> 
</td>
</tr>
</table>

<div align=left>
<?php include("mail_ru.php"); ?>
</div>
</body>
</html>
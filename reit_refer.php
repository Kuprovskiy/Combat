<?
include "connect.php";
include "functions.php";
?>
<HTML><HEAD><TITLE>Рейтинг рефералов </TITLE>
<META content=INDEX,FOLLOW name=robots>
<META content="1 days" name=revisit-after>
<META http-equiv=Content-type content="text/html; charset=windows-1251">
<META http-equiv=Pragma content=no-cache>
<META http-equiv=Cache-control content=private>
<META http-equiv=Expires content=0><LINK href="i/main.css" type=text/css rel=stylesheet>
<META content="MSHTML 6.00.2600.0" name=GENERATOR></HEAD>
<BODY bottomMargin=0 vLink=#333333 aLink=#000000 link=#000000 bgColor=#666666
leftMargin=0 topMargin=0 rightMargin=0 marginheight="0" marignwidth="0">
<TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <TR>
    <TD vAlign=top width="15%">
      <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
        <TBODY>
        <TR>
          <TD width="100%" height=36></TD></TR>
       </TBODY></TABLE>
    </TD>
    <TD vAlign=top width="70%">
      <DIV align=center><IMG height=21 src="i/deviz.gif" width=459 border=0></DIV>
      <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
        <TBODY>
        <TR>
          <TD width="30%" height=15></TD>
          <TD width="40%" height=15 align=center ><IMG height=15 src="i/top.gif" width=269 border=0></TD>
          <TD width="30%" height=15></TD></TR>
        <TR>
          <TD width="30%" bgColor=#f2e5b1 height=24></TD>
          <TD width="40%" align=center bgColor=#f2e5b1 height=24><IMG height=24 src="i/bottom.gif" width=269 border=0></TD>
          <TD width="30%" bgColor=#f2e5b1 height=24></TD></TR></TBODY>
    </TABLE>
      <TABLE cellSpacing=0 cellPadding=0 width="100%" bgColor=#f2e5b1 border=0><TBODY>
        <TR>
          <TD width="100%" colSpan=3><BR></TD>
        </TR>
        <TR>
          <TD width="85%" colSpan=2></td>
          <TD vAlign=top width="15%" rowSpan=2><BR><BR>
            <DIV align=right>
            <TABLE height="90%" cellSpacing=0 cellPadding=0 border=0>
              <TBODY>
              <TR>
               <TD vAlign=top background=""><IMG height=292 src="i/paper1.jpg" width=39
                  border=0></TD></TR></TBODY></TABLE></DIV>
        </TD>
        </TR>
        <TR>
          <TD vAlign=top width="10%"><IMG height=243 alt="" src="i/pict_anketa.jpg" width=126
            border=0><BR><BR><BR><BR></TD>
          <TD vAlign=top width="75%"><!-- Begin of text -->

<center><b><font color=#8f0000 size=4>TOP 10. Рейтинг рефералов Бойцовского клуба</font></b></center>
<br><br>
Хотите попасть в рейтинг? Нажмите на кнопку <font color=green><b>Реферальная система</b></font> в главном окне игры и узнайте подробнее.
<br><br>

<table width=400 border=0 align=center><tr><td align=center><b>Персонаж</b></td><td align=center><b>Количество приведенных</b></td></tr>
<?
$nu=1;
		$data=mysql_query("SELECT id,refer FROM `users` WHERE refer !='396' and refer>0 and borntime>'2013-06-03 00:00:00'");
					while ($row = mysql_fetch_array($data)) {
					$masspers[$row['refer']]++;
					}
arsort($masspers);
					foreach ($masspers as $key => $value) {
					echo"<tr><td>".$nu++.". ";nick2($key);echo"</td><td align=center>".$value."</td></tr>";
					if($nu>=11){break;}
					}
?>
</table>
<br><br>
<small><font color=red><b>* Статистика ведется с 03.06.2013</b></font></small>
<br><br>
        <TR>
         </TR>
        <TR>
          <TD align=left width="100%" bgColor=#666666 colSpan=3>
            </TD></TR></TBODY></TABLE>
            <center>
            <?php include("mail_ru.php"); ?>
            </center>
    </TD>
    <TD vAlign=top width="15%">
      <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
        <TBODY>
        <TR>
          <TD width="100%" height=36></TD></TR>
        </TBODY></TABLE></TD></TR></TBODY></TABLE>
<SCRIPT language=Javascript></SCRIPT>
</BODY></HTML>

<?
//  session_start();
    //if ($_SESSION['uid'] == null) header("Location: index.php");
//  $google = 1;
    include "connect.php";
//  $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
    include "functions.php";
?>
<HTML><HEAD><TITLE>Рейтинг персонажей </TITLE>
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
        <TR>
          </TR></TBODY></TABLE>
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

<center><b><font color=#8f0000 size=4>Рейтинг персонажей Старого Бойцовского Клуба</font></b></center>

<br><br><br>

<table width=400 border=0 align=center><tr><td align=center><b>Персонаж</b></td><td align=center><b>Победы</b></td></tr>
<?
$nu=1;
        $data=mysql_query("SELECT id,win,login,vid FROM `users` WHERE bot=0 and klan not like 'adminion' and (align<2 or align>=3) and align not like '777' and align not like '4' and deal like '0' and block like '0' and (vid<1 or vid>6) ORDER BY win DESC LIMIT 150");
                    while ($row = mysql_fetch_array($data)) {
                    echo "<tr><td>".$nu++.". ";
                                                    nick2($row['id'],0);
                    echo"</td><td align=center>".$row['win']."</td></tr>";

                    }
?>

</table>


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
        <TR>
         </TR></TBODY></TABLE></TD></TR></TBODY></TABLE>
<SCRIPT language=Javascript></SCRIPT>
</BODY></HTML>

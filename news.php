<?
	session_start();
	//if ($_SESSION['uid'] == null) header("Location: index.php");
	$google = 1;
	include "connect.php";
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
	include "functions.php";
?>
<HTML><HEAD><TITLE>Новости Бойцовского клуба </TITLE>
<META content=INDEX,FOLLOW name=robots>
<META content="1 days" name=revisit-after>
<META http-equiv=Content-type content="text/html; charset=windows-1251">
<META http-equiv=Pragma content=no-cache>
<META http-equiv=Cache-control content=private>
<META http-equiv=Expires content=0><LINK href="i/main.css" type=text/css rel=stylesheet>
	<table width="100%" align="center" border="0" height="100%" cellpadding="0" cellspacing="0">
		<tr>
		<td width="15" height="41" background="i/des/on/l_t.jpg">&nbsp;</td>
		<td height="41" background="i/des/on/top.jpg">
		 <table align="center" height="24" border="0" cellpadding="0" cellspacing="0">
		    <tr>
		      <td width="41" height="24" background="i/des/on/1.gif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		      <td height="24" background="i/des/on/f.gif" valign="center"></td>
		      <td width="41" height="24" background="i/des/on/2.gif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		    </tr>
		   </table>
		</td>
		<td width="15" height="41" background="i/des/on/r_t.jpg">&nbsp;</td>
	</tr>	
	<tr>
		<td width="15" background="i/des/on/left_bg_repeat.jpg">&nbsp;</td>
		<td background="i/des/on/center_bg.jpg">
<style>
.pleft {
	PADDING-RIGHT: 0px; PADDING-LEFT: 20px; PADDING-BOTTOM: 7px; MARGIN: 0px; PADDING-TOP: 3px
}
</style>
<SCRIPT language=JavaScript>
function cs(s1, s2)
{
   if (document.getSelection) { alert("Под NN не работает!"); }
   if (document.selection) {
	 var str = document.selection.createRange();
     var s = document.F1.text.value;
     if (s1 == '//') {
       if ((str.text != "") && (s.indexOf(str.text)<0)) {
	     var str2 = '> ';
		 var j = 0;
		 for(var i=0; i<str.text.length; i++) {
		   str2 += str.text.charAt(i); j++;
		   if (str.text.charAt(i) == "\n") { str2 += "> "; j=0; }
		   if ((j>55)&&(str.text.charAt(i) == ' ')) { str2 += "\n> "; j=0; }
		 }
         document.F1.text.value = s+"<I>\n"+str2+"\n</I>\n";
	   } else {
	     alert("Не выделен текст!\nДля вставки цитаты, сначала выделите на странице нужный текст, а затем нажмите эту кнопку.");
	   }
	 } else {
      if ((str.text != "") && (s.indexOf(str.text)>=0)) {
	    if (str.text.indexOf(s1) == 0) {return '';}
		str.text = s1+str.text+s2;
      } else { document.F1.text.value = s+s1+s2; }
	 }
   }
   document.F1.text.focus();
   return false;
}
</SCRIPT>
<META content="MSHTML 6.00.2600.0" name=GENERATOR></HEAD>
<BODY bottomMargin=0 vLink=#333333 aLink=#000000 link=#000000  leftMargin=0 topMargin=0 rightMargin=0 marginheight="0" marignwidth="0">
<TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <TR>
    <TD vAlign=top width="70%">
      <TABLE cellSpacing=0 cellPadding=0 width="100%"  border=0><TBODY>
        <TR>
          <TD vAlign=top width="10%"><?php
				if(($_GET['conf'] == null) && ($_GET['topic'] == null)) { $_GET['conf'] = 1; }
			
				//include("connect.php");
				
				
			?><BR><BR><BR><BR></TD>
          <TD vAlign=top width="75%"><!-- Begin of text -->
		  <?

			 
		if($_POST['add'] && $user['id'] && $user['align']>2.4 && $user['align']<2.6) {
		//if((time()-60)>$_COOKIE['time']) {
			$google = 1;
			//$text1 = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]","<a href=\"\\0\" target=_blank>\\0</a>", $_POST['text']);
			$text1=$_POST['text'];
			mysql_query("INSERT INTO `news` (`type`,`topic`,`text`,`parent`,`author`,`date`) 
			VALUES (2,'{$_POST['title']}','".strip_tags(nl2br($text1),"<b><i><img><u><code><a><BR>")."','{$_GET['conf']}','".nick3($_SESSION['uid'])."','".date("d.m.y H:i:s")."');");
//			@setcookie("time",time());
//		} else {
//			echo "<span class=private>Подождите ".($_COOKIE['time']-(time()-60))." секунд.</span>";
//		}	
		}
	
		if($_POST['add2'] && $user['id']) {
		if((time()-30)>$_COOKIE['time']) {
		
			//$text1 = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]","<a href=\"\\0\" target=_blank>\\0</a>", $_POST['text']);
			$text1=$_POST['text'];
			mysql_query("INSERT INTO `news` (`type`,`topic`,`text`,`parent`,`author`,`date`) 
			VALUES (2,'{$_POST['title']}','".strip_tags(nl2br($text1),"<b><i><u><code><BR><a>")."','{$_GET['topic']}','".nick3($_SESSION['uid'])."','".date("d.m.y H:i:s")."') ;");
			mysql_query("UPDATE `news` SET `updated` = now() WHERE `id` = '{$_GET['topic']}';");
			@setcookie("time",time());
		} else {
			echo "<span class=private>Подождите ".($_COOKIE['time']-(time()-30))." секунд.</span>";
		}
		}	 
		
		if ($_GET['dp'] && ($user['align']>2 && $user['align']<3))
		{
			if ($user['align']>1.1 && $user['align']<2) {$angel="Паладином";}
			if ($user['align']>2 && $user['align']<3) {$angel="Ангелом";}
			mysql_query("UPDATE `news` SET `text` = '<font color=red>Удалено $angel ".nick3($_SESSION['uid'])."</font>' WHERE `id` = {$_GET['dp']} LIMIT 1;");
		}
		
		if ($_GET['dt'] &&  ($user['align']>2 && $user['align']<3))
		{
			mysql_query("DELETE FROM `news`WHERE `id` = {$_GET['dt']} LIMIT 1;");
		}
			 
		if ($_GET['com'] && $_GET['cpr'] && (($user['align']>1.6 && $user['align']<2) || ($user['align']>2 && $user['align']<3)))
		{
		//	echo $_GET['cpr'];
			mysql_query("UPDATE `news` SET `text` = CONCAT(`text`,'<BR><font color=red>".nick3($_SESSION['uid']).": ".$_GET['cpr']."</font>') WHERE `id` = {$_GET['com']} LIMIT 1;");
		}	 
		
		  if(!$_GET['conf']) {
			$row = mysql_fetch_array(mysql_query("SELECT * FROM `news` WHERE `id` = '{$_GET['topic']}'"));
				$top=$row['parent'];
			?>
			 <CENTER>
            <TABLE width="88%" border=0>
              <TBODY>
              <TR>
                <TD noWrap align=center> <A href="news.php?conf=<?echo "$top";?>">Назад в новости</A> </TD></TR></TBODY></TABLE></CENTER><br><br>
			<?
				
				echo "<table width=100%><td align=left><H2>{$row['topic']}</H2></td><td align=right><span class=date>{$row['date']}</span>";
				if($user['align']>2 && $user['align']<3) {
						echo " <a href='?topic={$_GET['topic']}&dp={$row['id']}'><img src='i/clear.gif'></a>";
						echo " <a onclick='var obj; if (obj = prompt(\"Введите комментарий\",\"\")) { window.location=\"forum.php?topic=".$_GET['topic']."&cpr=\"+obj+\"&com=".$row['id']."\"; }' href='#'>[комментарий]</a>";
					}
				echo "</td></tr></table><BR>{$row['text']}<br><br><HR>";
		  
				$data = mysql_query("SELECT * FROM `news` WHERE `parent` = '{$_GET['topic']}' ORDER by `id` ASC;");
				while($row = mysql_fetch_array($data))	 {
					echo "{$row['author']} (<span class=date>{$row['date']}</span>)";
					if($user['align']>2 && $user['align']<3) {
						echo " <a href='?topic={$_GET['topic']}&dp={$row['id']}'><img src='i/clear.gif'></a>";
						echo " <a onclick='var obj; if (obj = prompt(\"Введите комментарий\",\"\")) { window.location=\"forum.php?topic=".$_GET['topic']."&cpr=\"+obj+\"&com=".$row['id']."\"; }' href='#'>[комментарий]</a>";
					}
					echo "<BR>{$row['text']}<HR>";
				}
				if ($closed==1) {
					echo "<br><div align=center>$closepal</div><br><br>";
				}
				else {
					if ( $_SESSION['uid'] && $_SESSION['align'] != 4) {
		  ?>
            <A name=answer></A>
            <FORM name=F1 action="news.php?topic=<?=$_GET['topic']?>" method=post>
            <TABLE 
            style="BORDER-RIGHT: 1px outset; BORDER-TOP: 1px outset; BORDER-LEFT: 1px outset; BORDER-BOTTOM: 1px outset" 
            cellSpacing=0 cellPadding=2 bgColor=#f6e5b1 border=0 name="F1">
              <TBODY>
              <TR>
                <TD>
                  <H4>Написать комментарий</H4></TD></TR>
              <TR>
                <TD>
                  <TABLE width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD align=middle><TEXTAREA name=text rows=12 cols=85></TEXTAREA></TD>
                      <TD></TD></TR></TBODY></TABLE></TD></TR><INPUT 
              type=hidden value=0 name=n> <INPUT type=hidden value=1025804759 
              name=id> <INPUT type=hidden name=redirect> 
              <TR>
                <TD align=right><INPUT type=submit value=Добавить name=add2> 
                </TD></TR></FORM></TBODY></TABLE>
            <P> <BR><BR></P></TD></TR><?
					}
					else {
						echo "<br><br>";
					}
				}
		}
		else {
			$row = mysql_fetch_array(mysql_query("SELECT * FROM `news` WHERE `id` = '{$_GET['conf']}'"));
			
			?>
			
<INPUT TYPE=button value="Вернуться" onClick="location.href='main.php';">
<centeR>
<img src="i/news.gif" border=0>
			</center>
			<?
		
			
			$data = mysql_query("SELECT * FROM `news` WHERE `parent` = '{$_GET['conf']}' ORDER by `id` DESC;");					
			while($row = mysql_fetch_array($data))	 {
				$logi = '';
				$userlist = '';
				$data2 = mysql_query("SELECT `author` FROM (SELECT `author`,`id` FROM `news` WHERE `parent` = '{$row['id']}' ORDER by `id` DESC LIMIT 10) AS sTable ORDER BY id ASC;");
				while($row2 = mysql_fetch_array($data2))	 {
					$userlist = strip_tags($row2[0],"");
					list ($username,$level)=split (" \[",$userlist);
					$logi .= ", ".$username;

				}
				$query="select count(*) as CountNumber from table where i=2"; 
				$datacount = mysql_fetch_array(mysql_query("SELECT count(*) as CountNumber FROM `news` WHERE `parent` = '{$row['id']}';"));
				$count=$datacount["CountNumber"];
				$lasttimedb = mysql_fetch_array(mysql_query("SELECT `date` FROM `news` WHERE `parent` = '{$row['id']}' ORDER by `id` DESC LIMIT 1;"));
				$lasttime=$lasttimedb['date'];
				
				echo "<hr><table width=100%><tr><td align=left><H6>{$row['topic']}</H4></td><td aling=right width=30%><span class=date>{$row['date']}</span> ";
				
				if ($user['align']>2 && $user['align']<3){
					echo " <a href='?conf={$_GET['conf']}&dt={$row['id']}'><img src='i/clear.gif'></a></div>";
				}
				echo "</td></tr></table>";
				echo "<BR>{$row['text']}<br>";
				echo "<table width=100%><tr><td align=right>Комментариев: [<b>$count</b>] <a href='?topic={$row['id']}'>Оставить комментарий</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td></tr></table><br>";
			}
			
			if ($user['align']>2 && $user['align']<3){
			
			
			?>
            <A name=answer></A>
            <FORM name=F1 action="news.php?conf=<?=$_GET['conf']?>" method=post>
            <TABLE 
            style="BORDER-RIGHT: 1px outset; BORDER-TOP: 1px outset; BORDER-LEFT: 1px outset; BORDER-BOTTOM: 1px outset" 
            cellSpacing=0 cellPadding=2 bgColor=#f6e5b1 border=0 name="F1">
              <TBODY>
              <TR>
                <TD>
                  <H4>Добавить новость</H4> Заголовок новости <input type=text class="inup" name=title size=57 maxlength=65></TD></TR>
              <TR>
                <TD>
                  <TABLE width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD align=middle><TEXTAREA name=text rows=12 cols=85></TEXTAREA></TD>
                     </TR></TBODY></TABLE></TD></TR><INPUT 
              type=hidden value=0 name=n> <INPUT type=hidden value=1025804759 
              name=id> <INPUT type=hidden name=redirect> 
              <TR>
                <TD align=right>
				
				 <table width=100%>
                <tr>
                    <td>
                                            
                    </td>
                    <td align=right>
                        <input type="submit" class="btn" value="Добавить" name="add">
                        <input type="hidden" name="n" value="klans">
                        <input type="hidden" id="act" name="act" value="add_branch"/>
                    </td>
                </tr>
            </table>
				
                </TD></TR></FORM></TBODY></TABLE>
            <P> <BR><BR></P></TD></TR><?
				}
				else {
					echo "<br><br>";
					}

		}
			
			
			?>
</TBODY></TABLE>
			<center>
			
			<?php include("mail_ru.php"); ?>

			</center>
	</TD>
    </TR></TBODY></TABLE>
<SCRIPT language=Javascript></SCRIPT>
</BODY>

</td>
		<td width="15" background="i/des/on/right_bg_repeat.jpg">&nbsp;</td>
	</tr>
	
	<tr>
		<td width="15" height="15" background="i/des/on/l_b.jpg">&nbsp;</td>
		<td height="15" background="i/des/on/bottom.jpg"></td>
		<td width="15" height="15" background="i/des/on/r_b.jpg">&nbsp;</td>
	</tr>
</table>
</HTML>

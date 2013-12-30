<?php
include "options.php";
if(!empty($_GET['exit'])){session_start(); session_destroy();}
?>
<HTML>
	<HEAD>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
		<meta name="Keywords" content="игра, играть, игрушки, онлайн,online, интернет, internet, RPG, fantasy, фэнтези, меч, топор, магия, кулак, удар, блок, атака, защита, Бойцовский Клуб, бой, битва, отдых, обучение, развлечение, виртуальная реальность, рыцарь, маг, знакомства, чат, лучший, форум, свет, тьма, bk, games, клан, банк, магазин, клан">
		<meta name="Description" content="Отличная RPG онлайн игра посвященная боям и магии. Тысячи жизней, миллионы смертей, два бога, сотни битв между Светом и Тьмой.">
		<TITLE>Fight Club</TITLE>
		<link rel="stylesheet" type="text/css" href="<?=url?>/css/index/index.css"/>
		<script type="text/javascript" src="<?=url?>/js/index/index.js"></script>
		<script type="text/javascript" src="<?=url?>/js/index/CombatsUI.js"></script>
	</HEAD>
	<BODY class="menu">
		<TABLE width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0" class="menu">
			<TR height="30%">
				<TD align="center"><TABLE width="100%" height="100%" border="0">
					<TR>
						<TD width="200" valign="bottom" style="padding-bottom: 10">&nbsp;</TD>
												<TD width="200" align="right" valign="bottom" style="padding-bottom: 10; ">&nbsp;</TD>
					</TR>
				</TABLE></TD>
			</TR>
			<TR height="205">
				<TD colspan="2" width="100%" align="center" scope="col"><SCRIPT>DocumentWriteBackgroundTop()</SCRIPT>
					<TR height="205" valign="top">
						<TD  width="195" align="right" valign="bottom" style="padding-bottom: 42; "><SCRIPT>DocumentWritePeopleAward()</SCRIPT></TD>
						<TD align="center"><SCRIPT>DocumentWriteLogo()</SCRIPT></TD>
						<TD width="195" valign="bottom" style="padding-bottom: 42; padding-right: 5; " align="right"><SCRIPT>DocumentWriteRunetAward()</SCRIPT></TD>
					</TR>
				</TABLE></TD>
			</TR>
			<TR valign="top" height="50%">
				<TD colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class='menu'>
					<TR>
						<TD align="left" valign="bottom" noWrap style="padding-left:10; " width="25%"><SCRIPT>DocumentWriteAgeWarning()</SCRIPT></TD>
						<TD align="center" width="50%" style="padding-left: 10; "><TABLE width="100%" border="0" class="menu" id="LoginForm">
							<SCRIPT>DocumentWriteLoginFormStart()</SCRIPT>
							<TR>
								<TD align="center">
									<BR>
									<SCRIPT>DocumentWriteLoginFormFields()</SCRIPT>
								</TD>
							</TR>
							<TR>
								<TD align="center"><TABLE cellspacing="0" cellpadding="0" class="menu">
									<TR valign="bottom">
										<TD><INPUT style="width:114; " class="inup" type="password" size="25" value="" name="psw"></TD>
										<TD style="padding: 0, 0, 1, 5; " valign="bottom"><SCRIPT>DocumentWriteVirtualKeyboardIcon()</SCRIPT></TD>
									</TR>
								</TABLE></TD>
							</TR>
							<TR>
								<TD height="19" align="center"><SCRIPT>DocumentWriteEnterButton()</SCRIPT></TD>
							</TR>
							<TR>
								<TD align="center"><SCRIPT>DocumentWriteRegisterButton()</SCRIPT></TD>
							</TR>
						</TABLE></TD>
						<TD width="25%" align="right" style="padding-right: 10; " valign="bottom"><SCRIPT>DocumentWriteContentChangeWarning()</SCRIPT></TD>
					</TR>
					<TR>
						<TD align="center" colspan="10"><DIV id="keypad" align="center" style="display: none; "></DIV></TD>
					</TR>
					</FORM>
					<TR>
						<TD colspan=3 align="center" noWrap>
							<BR>
							<SCRIPT>DocumentWriteFooterLinks()</SCRIPT>
						</TD>
					</TR>
				</TABLE><TABLE width="100%">
					<TR>
						<TD style="padding-left: 10; "><nobr>
                    <!--Rating@Mail.ru COUNTER--><span id="MailRuCounter"/><script>document.getElementById("MailRuCounter").appendChild(CombatsUI.CounterMailRu())</script><!--/COUNTER-->
<!--begin of Top100 logo-->
<a href="http://top100.rambler.ru/top100/">
<img src="http://top100-images.rambler.ru/top100/banner-88x31-rambler-black2.gif" alt="Rambler's Top100" width=88 height=31 border=0></a>
<!--end of Top100 logo -->
<SPAN style='display: none'><!--begin of Rambler's Top100 code -->
<a href="http://top100.rambler.ru/top100/">
<img src="http://counter.rambler.ru/top100.cnt?602896" alt="" width=1 height=1 border=0></a>
<!--end of Top100 code--></SPAN>
						</nobr></TD>
						<TD align="right" style="padding-right: 10; " valign="top" width="30%">
							<TABLE cellpadding="0" cellspacing="0" class="menu">
								<TR>
									<TD align="right" valign="top" style="padding-bottom: 5; ">
										<BR>
										
									</TD>
								</TR>
								<TR valign="bottom">
									<TD><SCRIPT>DocumentWritePRMail()</SCRIPT></TD>
								</TR>
							</TABLE>
						</TD>
					</TR>
				</TABLE></TD>
			</TR>
		</TABLE>
		<MAP name="Map">
			<SCRIPT>DocumentWriteLanguageSwitchMap()</SCRIPT>
		</MAP>
<script LANGUAGE='JavaScript'> 
document.ondragstart = test;
document.oncontextmenu = test;
function test() {
 return false
}
</SCRIPT>
	</BODY>
</HTML>

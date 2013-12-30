<html>
<head>
<script LANGUAGE='JavaScript'> 
document.ondragstart = test;
document.oncontextmenu = test;
function test() {
return false
}
</SCRIPT>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<meta http-equiv="imagetoolbar" content="no" />
<link href="/top/design2.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript"> 
function showtable (tblname) {
	hidesel(tblname);
	hidemenu(0);
	document.getElementById('menu'+tblname).style.display = 'block';
	//document.getElementById('menu'+tblname).style.width = '';
	document.getElementById('menu'+tblname).style.overflow = 'hidden';
}
function hidesel (tblname) {
	for (var i=1;i<=5;i++) {
		if (i!=tblname) {document.getElementById('el'+i).style.backgroundColor='';document.getElementById('el'+i).style.color='';}
	}	
}
function hidemenu (time) {
	for (var i=1;i<=4;i++) {
		document.getElementById('menu'+i).style.display = 'none';
		//document.getElementById('menu'+i).style.width = '1px';
		document.getElementById('menu'+i).style.overflow = 'hidden';
	}	
}
function jumptopath (path,topframe) {
	var rnd=Math.random();
	if (!topframe) {
		top.frames['main'].location.href = ''+path+'';
} else {
top.location.href = ''+path+'';
}
}
function loadpers() {
document.getElementById('el4').style.backgroundColor='#404040';
document.getElementById('el4').style.color='#FFFFFF';
showtable('4');
}
</script>

<script type="text/javascript">
	var wr_telegrafo_win = new top.wrIWinBcTele();
	
	var wrTelegrafoNet_raw = function (resFun, _xyz_)
	{
		this.resFun = resFun;
		this.fromNet = false;
		this._xyz_ = _xyz_;
		
		this.init = function ()
		{
			var _this = this;
			try {
				if (window.XMLHttpRequest) {
					this.net = new XMLHttpRequest();
				}
				else {
					this.net = new ActiveXObject("Microsoft.XMLHTTP");
				}
				this.net.open(this._getMethod(), this._getURL(), true);
				this.net.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				this.net.onreadystatechange = function () { _this._state_change(); };
				this.net.send(this._getPostVars());
			}
			catch (e) {
				this._result();
			}
		};

		this._getMethod = function ()
		{
			return 'POST';
		};
		
		this._getPostVars = function ()
		{
			return '_xyz_=telegrafo' + this._xyz_;
		};
		
		this._getURL = function ()
		{
			return '/correo.php';
		};
		
		
		this._state_change = function ()
		{
			this.fromNet = false;
			try {
				if (this.net.readyState == 4) {
					if (this.net.status == 200) {
						this.fromNet = this.net.responseText;
						if (this.fromNet.substring(0, 26) != '<!-- telegrafo wr data -->')
								this.fromNet = '';
						this._result();
					}
					else {
						this._result();
					}
				}
			}
			catch (e) {
				this._result();
			}
		};

		this._result = function ()
		{
			this.resFun(this);
		};
		
		this.getResult = function ()
		{
			return this.fromNet;
		};
		
	};
	
	var wrTelegrafoNet = function (resFun, _xyz_)
	{
		wrTelegrafoNet_raw.call(this, resFun, _xyz_);
		this.init();
	};
	
	var wrTelegrafoProcess = false;
	var wrTelegrafoShow = function (_var)
	{
		if (! _var) _var = '';
		if (wrTelegrafoProcess) return;
		wrTelegrafoProcess = true;
		var x = wrTelegrafoNet(
			function (_x)
			{
				var html = _x.getResult();
				if (html && html != '???' && wr_telegrafo_win && html.substring()) 
				{
					wr_telegrafo_win.open();
					wr_telegrafo_win.setHtml(html);
				}
				
				wrTelegrafoProcess = false;
			},
			_var
		);
	};
	
	var wrLetterImgInf = false;
	var wrPostInfoShow = function (_is)
	{
		if (_is)
		{
			if (wrLetterImgInf) return;
			var img = document.createElement('img');
			img.src="/top/letter.png";
			img.style.cssText = "margin: 0; padding: 0; position: absolute; top: 0; left: 65px; z-index: 100000;";
			img.alt = 'У вас новая почта';
			img.title = 'У вас новая почта';
			document.body.appendChild(img);
			wrLetterImgInf = img;
		}
		else
		{
			if (wrLetterImgInf)
			{
				try
				{
					wrLetterImgInf.parentNode.removeChild(wrLetterImgInf);
					wrLetterImgInf = false;
				}
				catch (e)
				{
				}
			}
		}
		
	}
</script>
</head>
<body onload="document.body.style.display='block';loadpers();" style="display: none;">
<div style="background: url(top/top_lite_cap_11.gif) repeat-x bottom; width: 100%;">
<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="background: url(top/top_lite_cap_03.gif) repeat-x top; ">
<tr>
<td align="left"><img src="top/top_lite_cap_01.gif" /><SPAN id='mailspan' style="position: absolute"></SPAN></td>
<!-- <td rowspan=2 style="text-align: center; vertical-align: middle; width: 100%"></td> -->
<td align="right" class="main_text"><table cellspacing="0" cellpadding="0" border="0" width="500">
<tr valign="bottom">
<td width="31" height="14"><img height="14" src="top/mennu112_06_lite.gif" width="31" /></td>
<td align="center"><table height="14" cellspacing="0" cellpadding="0" width="100%" background="top/mennu112_06.gif" border="0">
<tr align="middle">
<td id="el1" class="main_text" onclick="this.style.backgroundColor='#404040'; this.style.color='#FFFFFF'; showtable('1');">Знания</td>
<td width="1"><img height="11" src="top/mennu112_09.gif" width="1" /></td>
<td id="el2" class="main_text" onclick="this.style.backgroundColor='#404040'; this.style.color='#FFFFFF'; showtable('2');">Общение</td>
<td width="1"><img height="11" src="top/mennu112_09.gif" width="1" /></td>
<td id="el3" class="main_text" onclick="this.style.backgroundColor='#404040'; this.style.color='#FFFFFF'; showtable('3');">Безопасность</td>
<td width="1"><img height="11" src="top/mennu112_09.gif" width="1" /></td>
<td id="el4" class="main_text" onclick="this.style.backgroundColor='#404040'; this.style.color='#FFFFFF'; showtable('4');">Персонаж</td>
<td width="1"><img height="11" src="top/mennu112_09.gif" width="1" /></td>
<td id="el5" class="main_text" onclick="if (confirm('Выйти из игры?')) top.location.href='index.php?exit=0.560057875997465';">Выход&nbsp;</td>
</tr>
</table></td>
<td width="38"><img height="14" src="top/mennu112_04_lite.gif" width="37" /></td>
</tr>
</table></td>
</tr>
<tr>
<td align="left"><img src="top/top_lite_cap_07.gif" /><img src="top/top_lite_cap_08.gif" /></td>
<td align="right"><table cellspacing="0" cellpadding="0" width="500" style="background-image:url(top/top_lite_dream_15.gif);" border="0">
<tr>
<td align="left"><img height="17" src="top/top_lite_dream_13.gif" width="20" /></td>
<td valign="top">

<table cellspacing="0" cellpadding="0" width="100%" border="0">
<tr>
	<td align="right" nowrap="nowrap" class="menutop" width="100%">
		<span id="menu1" style="display:none; overflow:hidden"> 
			<a class="menutop" onclick="this.blur();" href="/encicl/" target="_blank">Библиотека</a> |
			<a class="menutop" onclick="this.blur();" href="/encicl/index.php?section=0&page=error" target="_blank">FAQ</a> | 
			<a class="menutop" onclick="this.blur();" href="/forum.php?conf=17" target="_blank">Законы</a>
		</span> 
		<span id="menu2" style="display:none; overflow:hidden">
                                                               
			<a class="menutop" onclick="this.blur();" href="/forum.php" target="_blank">Форум</a> | 
			<a class="menutop" onclick="this.blur();" href="reit_pers.php" target="_blank">Рейтинг игроков</a> |
			<a class="menutop" onclick="this.blur();" href="reit_refer.php" target="_blank">Рейтинг рефералов</a>
		</span> 
		<span id="menu3" style="display:none; overflow:hidden">
			<a class="menutop" onclick="this.blur(); jumptopath('/main.php?changepsw=1'); return false;" href="#">Смена пароля</a>
		</span> 
		<span id="menu4" style="display:none;  overflow:hidden">
			<a class="menutop" onclick="this.blur(); jumptopath('/ref.php'); return false;" href="#">Заработок</font></a> | 

			<a class="menutop" onclick="this.blur(); jumptopath('/main.php?edit=1'); return false;" href="#">Инвентарь</a> | 
			<a class="menutop" onclick="this.blur(); jumptopath('/umenie.php'); return false;" href="#">Умения</a> | 
			<a class="menutop" onclick="this.blur(); jumptopath('/main.php?edit=1&transreport=1'); return false;" href="#">Отчет о переводах</a> |
			<a class="menutop" onclick="this.blur(); jumptopath('/zayavka.php'); return false;" href="#">Поединки</a> | 
			<a class="menutop" onclick="this.blur();" href="/register.php?edit=1" target="_blank">Анкета</a>

		</span>
		
	</td>
</tr>
</table>


</td>
<td align="right"><img height="17" src="top/top_lite_dream_18.gif" width="22" /></td>
</tr>
</table></td>
</tr>
</table></div><table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr>
<td valign="top" style="background-image:url(top/sand_top_20s.gif); background-repeat:repeat-x;"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr valign="top">
<td><img src="top/sand_lit_20.gif" width="15" height="6" /><img src="top/sand_top_20s.gif" width="31" height="6" /></td>
<td width="100%"><img src="top/sand_top_20s.gif" width="31" height="6" /></td>
<td><img src="top/sand_lit_27.gif" width="24" height="6" /></td>
</tr>
</table></td>
</tr>
</table>
</body>
</html>
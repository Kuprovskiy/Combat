<?php
    session_start();
    if ($_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    include "functions.php";
    $itemcond="and destinyinv=0 and foronetrip=0 AND `bs`=0  and ecost=0 AND `podzem`=0  AND `type`<50 and present='' and artefact=0 and honor_cost=0 and honor=0 and (clan='' or clan='$user[klan]')";

    function setrestriction($id) {
      mq("insert into effects set owner='$id', name='Запрет на вступление в кланы', time=".(time()+(60*60*24*28)).", type=".CLANRESTRICTION);
      mq("delete from effects where owner='$id' and type=20");
      mq("delete from alleffects where owner='$id' and type=20");    
    }

    if (!$user["klan"]) {header("location: main.php");die;}
    if ($user['battle'] != 0) { header('location: fbattle.php');die();}

    $klan = mysql_fetch_array(mq("SELECT * FROM `clans` WHERE `short` = '{$user['klan']}' LIMIT 1;"));
    $klan["members"]=unserialize($klan["members"]);
    foreach ($klan["members"] as $k=>$v) {
      $klan["members"][$k]["klan"]=$klan["short"];
      $v["klan"]=$klan["short"];
      $members[$v["id"]]=$v;
    }

    if (@$_GET["takeback"] && $klan["glava"]==$user["id"]) {
      $rec=mqfa("select * from inventory where id='$_GET[takeback]' and clan='$user[klan]'");
      $au=0;
      if (!$rec) {
        mq("lock tables telegraph write, users write, allusers write, online write, inventory write, allinventory write, clanstorage write, allobshagastorage write, obshagastorage write, delo write");
        $rec=mqfa("select * from allinventory where id='$_GET[takeback]' and clan='$user[klan]'");
        $au=1;
      }
      if ($rec) {
        if (!$au) {
          if($rec["dressed"]) {
            $usr=mqfa("select sergi, kulon, weap, plaw, bron, rybax, r1, r2, r3, helm, perchi, shit, boots, m1, m2, m3, m4, m5, m6, m7, m8, m9, m10, naruchi, belt, leg, m11, m12, p1, p2 from users where id='$rec[owner]'");
            $slot="";
            foreach ($usr as $k=>$v) {
              if ($v==$rec["id"]) $slot=$k;
            }
            dropitemid(0, $rec["owner"], $slot);
          }
        } else {
          mq("insert into inventory (select * from allinventory where id='$rec[id]')");
          if ($rec["dressed"]) {
            $usr=mqfa("select sergi, kulon, weap, plaw, bron, rybax, r1, r2, r3, helm, perchi, shit, boots, m1, m2, m3, m4, m5, m6, m7, m8, m9, m10, naruchi, belt, leg, m11, m12, p1, p2 from allusers where id='$rec[owner]'");
            $slot="";
            foreach ($usr as $k=>$v) {
              if ($v==$rec["id"]) mq("update allusers set $k=0 where id='$rec[owner]'");
            }
          }
        }
        $skoka = mqfa1("SELECT count(id) FROM `clanstorage` WHERE `klan` = '{$user['klan']}' and taken=0");
        if($klan['clanlevel']<4 && $skoka>=50){err("Количество вещей превышает лимит Вашего клана.");}
        elseif($klan['clanlevel']<7 && $klan['clanlevel']>3 && $skoka>=100){err("Количество вещей превышает лимит Вашего клана.");}
        elseif($klan['clanlevel']>=7 && $skoka>=200){err("Количество вещей превышает лимит Вашего клана.");}
        else{
          mq("update `inventory` SET `owner` = 0,`clan` = '{$user['klan']}', dressed=0 WHERE `id` ='$rec[id]'");
          mq("update `allinventory` SET `owner` = 0,`clan` = '{$user['klan']}', dressed=0 WHERE `id` ='$rec[id]'");
          mq("delete from obshagastorage where id_it='$rec[id]'");
          mq("delete from allobshagastorage where id_it='$rec[id]'");
          telegraph(mqfa1("select login from ".($au?"all":"")."users where id='$rec[owner]'"),"В хранилище клана $user[klan] возвращён предмет $rec[name].",0);
          mq("insert into delo set pers='$user[id]', `text`='\"$user[login]\" вернул в хранилище клана $user[klan] предмет \"".addslashesa($rec["name"])."\", id: $rec[id]', type=6, `date`=".time());          
          $takebackreport="Вы вернули вещь в хранилище.";

          mq("update `clanstorage` set taken=0, item='".serialize($rec)."' where id_it='$rec[id]'");
          //mq("insert `clanstorage` (`id_it`,`owner`,`klan`) values ('$rec[id]', '$rec[owner]','{$user['klan']}');");
        }

      }
      if ($au) mq("unlock tables");
    }

    $klanexptable = array(
    "0" => array (0,500000),
    "500000" => array (1,2000000),
    "2000000" => array (1,5500000),
    "5500000" => array (1,10500000),
    "10500000" => array (1,20500000),
    "20500000" => array (1,30500000),
    "30500000" => array (1,40500000),
    "40500000" => array (1,55000000),
    "55000000" => array (1,75000000),
    "75000000" => array (1,95000000),
    "95000000" => array (1,110000000));    
    if ($klan && $klan['clanexp'] >= $klan['needexp']) {
      mq("UPDATE `clans` SET `needexp` = ".$klanexptable[$klan['needexp']][1].",`clanlevel` = `clanlevel`+".$klanexptable[$klan['needexp']][0]."
      WHERE `id` = '$klan[id]'");
      $klan = mysql_fetch_array(mq("SELECT * FROM `clans` WHERE `short` = '{$user['klan']}' LIMIT 1;"));
      $klan["members"]=unserialize($klan["members"]);
      foreach ($klan["members"] as $k=>$v) {
        $klan["members"][$k]["klan"]=$klan["short"];
        $v["klan"]=$klan["short"];
        $members[$v["id"]]=$v;
      }
    }
    
    $polno = array();
    $polno = unserialize($klan['vozm']);
    if ($user["id"]==7) {
      $i=0;
      while ($i<20) {
        $polno[7][$i]=1;
        $i++;
      }
    }
    if ($user["in_tower"]) $polno=array();

if($_GET['trunklog']==1 && $klan["glava"]==$user['id']) {?>
<HTML><HEAD>                               <!--http://img.combats.com-->
<link rel=stylesheet type="text/css" href="<?=IMGBASE?>/i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<title>Просмотр операций с хранилищем</title>
</HEAD>
<style type="text/css">
td.dash{
border-bottom-style: dotted;
border-color: black;
border-width: 1px;
}
td.solid{
border-bottom-style: solid;
border-color: black;
border-width: 2px;
}
</style>
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=FFF6DD>
<table border=0 width=500 cellspacing="0" cellpadding="2" bgcolor=CCC3AA><tr><td align=center colspan=2>
<font color=#003388><b>Просмотр операций с хранилищем</b></font>
</TD></TR></TABLE><table width=500 CELLSPACING=num>
<?
if(is_numeric($_GET['page'])){

$numb=round($_GET['page']*15, 0);
}
else{

$numb=0;

}
                $data = mq("SELECT * FROM `delo` WHERE `text` like '%хранилище клана ".$user['klan']."%' or `text` like '%хранилища клана ".$user['klan']."%' ORDER BY date DESC LIMIT $numb, 15;");
                while($it = mysql_fetch_array($data)) {
$i++;
if($i==1){echo"<tr><td class=solid>&nbsp;</td><td align=left class=solid><b>&nbsp;&nbsp;Когда</b></td><td align=left class=solid><b>&nbsp;&nbsp;&nbsp;&nbsp;Кто</b></td><td align=right class=solid><b>Предмет</b></td></tr>";}
if(strpos($it['text'],"хранилище клана")){$pp="<img src=\"".IMGBASE."/i/kazna_get.gif\" alt=\"забрал\">";}else{$pp="<img src=\"".IMGBASE."/i/kazna_put.gif\" alt=\"положил\">";}
$p=strpos($it["text"],"предмет");
$it["text"]=substr($it["text"],$p+9);
$p=strpos($it["text"],"\"");
$it["text"]=substr($it["text"],0,$p);
echo"<tr><td class=dash align=center width=10>".$pp."</td><td class=dash align=left width=10>&nbsp;&nbsp;<nobr>".date('d.m.Y',$it['date'])."</nobr></td><td class=dash align=left>&nbsp;<nobr>".clannick3($it['pers'])."</nobr></td><td class=dash align=right>".$it['text']."</td></tr>";
}

?>
</table>
<?

echo "Страницы: ";
$data2 = mq("SELECT id FROM `delo` WHERE `text` like '%хранилище клана ".$user['klan']."%' or `text` like '%хранилища клана ".$user['klan']."%'");

    $all = mysql_num_rows($data2)-1;
    $pgs = $all/15;
    for ($i=0;$i<=$pgs;++$i) {
        if ($_GET['page']==$i) {
            echo '<font class=number>',($i+1),'</font>&nbsp;';
        }
        else {
            echo '<a href="?trunklog=1&page=',$i,'">',($i+1),'</a>&nbsp;';
        }
    }
?>
</HTML>
<?
exit();
}

if($_GET['kaznalog']==1 && $polno[$user['id']][5]==1){?>
<HTML><HEAD>                               <!--http://img.combats.com-->
<link rel=stylesheet type="text/css" href="<?=IMGBASE?>/i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<title>Просмотр операций с казной</title>
</HEAD>
<style type="text/css">
td.dash{
border-bottom-style: dotted;
border-color: black;
border-width: 1px;
}
td.solid{
border-bottom-style: solid;
border-color: black;
border-width: 2px;
}
</style>
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=FFF6DD>
<table border=0 width=100% cellspacing="0" cellpadding="2" bgcolor=CCC3AA><tr><td align=center colspan=2>
<font color=#003388><b>Просмотр операций с казной</b></font>
</TD></TR></TABLE><table width=100% CELLSPACING=num>
<?
if(is_numeric($_GET['page'])){

$numb=round($_GET['page']*15, 0);
}
else{

$numb=0;

}
                $data = mq("SELECT * FROM `kaznalog` WHERE `klan`= '".$user['klan']."' ORDER BY id DESC LIMIT $numb, 15;");
                while($it = mysql_fetch_array($data)) {
$i++;
if($i==1){echo"<tr><td class=solid>&nbsp;</td><td align=left class=solid><b>&nbsp;&nbsp;Когда</b></td><td align=left class=solid><b>&nbsp;&nbsp;&nbsp;&nbsp;Кто</b></td><td align=right class=solid><b>Сколько</b></td></tr>";}
if($it['action']==0){$pp="<img src=\"".IMGBASE."/i/kazna_get.gif\" alt=\"забрал\">";}else{$pp="<img src=\"".IMGBASE."/i/kazna_put.gif\" alt=\"положил\">";}
echo"<tr><td class=dash align=center width=10>".$pp."</td><td class=dash align=left width=10>&nbsp;&nbsp;<nobr>".$it['date']."</nobr></td><td class=dash align=left>&nbsp;<nobr>".clannick3($it['user'])."</nobr></td><td class=dash align=right>".$it['sum']."&nbsp;кр.</td></tr>";
}

?>
</table>
<?

echo "Страницы: ";
$data2 = mq("SELECT * FROM `kaznalog` WHERE `klan`= '{$user['klan']}';");

    $all = mysql_num_rows($data2)-1;
    $pgs = $all/15;
    for ($i=0;$i<=$pgs;++$i) {
        if ($_GET['page']==$i) {
            echo '<font class=number>',($i+1),'</font>&nbsp;';
        }
        else {
            echo '<a href="?kaznalog=1&page=',$i,'">',($i+1),'</a>&nbsp;';
        }
    }
?>
</HTML>
<?
exit();
}
?>
<HTML><HEAD>                               <!--http://img.combats.com-->
<link rel=stylesheet type="text/css" href="<?=IMGBASE?>/i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<SCRIPT LANGUAGE="JavaScript" SRC="<?=IMGBASE?>/i/selectlogin.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="<?=IMGBASE?>/i/commoninf1.js"></SCRIPT>
<!--<SCRIPT LANGUAGE="JavaScript" SRC="<?=IMGBASE?>/i/js/dialog_029_ru.js"></SCRIPT>-->
<SCRIPT language="javascript">
function fastshow (content) {
    var el = document.getElementById("mmoves3");
    var o = window.event.srcElement;
    var sx = 0;
    var sy = 20;
    if (content!='' && el.style.visibility != "visible") {el.innerHTML = '<small>'+content+'</small>';}
    var x = window.event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft + sx;
    var y = window.event.clientY + document.documentElement.scrollTop + document.body.scrollTop + sy;

    if (window.event.clientX + el.offsetWidth + sx > document.body.clientWidth) { x-=(window.event.clientX + el.offsetWidth + sx - document.body.clientWidth); if (x < 0) {x=0}; }
    if (window.event.clientY + el.offsetHeight + sy > document.body.clientHeight) { y-=(window.event.clientY + el.offsetHeight + sy - document.body.clientHeight); if (y < 0) {y=0}; }

    el.style.left = x + "px";
    el.style.top  = y + "px";

    if (el.style.visibility != "visible") {
        el.style.visibility = "visible";
    }
}
function hideshow () {  document.getElementById("mmoves3").style.visibility = 'hidden'; }
</SCRIPT>
<STYLE>
FORM {margin: 0; padding: 0;}
B { color: #003388; }
.tz                     { font-weight:bold; color: #003388; background-color: #CCCCCC; cursor:hand; text-align: center; width: 12%;}
.tzOver         { font-weight:bold; color: #003388; background-color: #C0C0C0; cursor:hand; text-align: center; width: 12%;}
.tzSet          { font-weight:bold; color: #003388; background-color: #A6B1C6; cursor:default; text-align: center; width: 12%;}
.dtz            { display: none;}
.readonly       { background-color: #E0E0E0; }
</STYLE>
<style type="text/css">
<!--

A {
    FONT-WEIGHT: bold;
    COLOR: #4a4a4a;
    TEXT-DECORATION: none;
    font-size: 12px;
}
A:visited {
    FONT-WEIGHT: bold;
    COLOR: #4a4a4a;
TEXT-DECORATION: none   font-size: 14px;
}
A:active {
    COLOR: #6f0000  font-size: 14px;
    color: #4a4a4a;
}
A:hover {
    COLOR: #B1B1B1  font-size: 14px;
    color: #613435;
}
.style2 {
    text-align: center;
    border-top-width: 1px;
    border-right-width: 1px;
    border-bottom-width: 1px;
    border-left-width: 1px;
    border-top-style: dashed;
    border-right-style: dotted;
    border-bottom-style: dashed;
    border-left-style: dashed;
    border-top-color: #ACA499;
    border-right-color: #ACA499;
    border-bottom-color: #ACA499;
    border-left-color: #ACA499;
}
body {
    background-color: #dedede;
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 0px;
    text-align: left;
    font-size: 12px;
    margin-left: 0px;
}
#apDiv1 {
    position:absolute;
    width:111px;
    height:115px;
    z-index:1;
    left: 279px;
    top: 16px;
}
#apDiv2 {
    position:absolute;
    width:49px;
    height:33px;
    z-index:1;
    left: 21px;
    top: 181px;
}
#apDiv3 {
    position:absolute;
    width:157px;
    height:108px;
    z-index:1;
    left: 84px;
    top: 46px;
}
#apDiv4 {
    position:absolute;
    width:46px;
    height:78px;
    z-index:1;
    left: 256px;
    top: 9px;
}

td.off {
    background-image: url(<?=IMGBASE?>/i/misc/clans/klan_img_08.jpg);
}
td.on {
    background-image: url(<?=IMGBASE?>/i/misc/clans/klan_img_08h.jpg);
}

th.clan {font-size: 13px; color: 990000; text-align: left; padding-left: 2px;}
th.clansel {background-color: #A6B1C6;};
th.clanover {background-color: #A6B1C6;};
.style4 {
    text-align: center;
    border: 1px solid #ACA499;
}

-->
</style>

<SCRIPT language="JavaScript">
function w(login,id,align,klan,level,boss,titul,online,block, city, color, icon, rank){
    var s = '';
    var oTable = document.getElementById('users_table');
    var oTr = oTable.tBodies[0].appendChild(document.createElement('tr'));
    oTr.style.display = (online ? 'block' : 'none');
    oTr.tag = online;
    var oTd = document.createElement('td');
    oTd.width = 400;

    if (!color) color='000000';
    var icon = '';

if (!icon || icon==klan) {
if (klan) {
icon='<IMG SRC="<?=IMGBASE?>/i/klan/' + klan + '.gif" WIDTH=24 HEIGHT=15 ALT="">';
}
} else {
icon='<IMG SRC="<?=IMGBASE?>/i/misc/tituls/' + icon + '.gif" ALT="">';
}
if (block != '' && block != '0') icon = '';
if (online!=0) {
if (city!="") {
s+='<IMG style="filter:gray()" SRC=<?=IMGBASE?>/i/lock.gif WIDTH=20 HEIGHT=15 ALT="В другом городе">';
} else {
s+='<a href="javascript:top.AddToPrivate(\''+login+'\',true)"><IMG SRC=<?=IMGBASE?>/i/lock.gif WIDTH=20 HEIGHT=15 ALT="Приватно"></a>';
}
} else { s+='<IMG SRC="<?=IMGBASE?>/i/offline.gif" WIDTH=20 HEIGHT=15 BORDER=0 ALT="Нет в клубе">'; }
if (city!="") {
s+='<img src="<?=IMGBASE?>/i/misc/forum/fo'+city+'.gif" width=17 height=15>';
}
s+=' <IMG SRC=<?=IMGBASE?>/i/align'+align+'.gif WIDTH=12 HEIGHT=15>';
if (klan!='') {s+='<A HREF="/encicl/klan/'+klan+'.html" target=_blank><IMG SRC="<?=IMGBASE?>/i/klan/'+klan+'.gif" WIDTH=24 HEIGHT=15 ALT=""></A>'}
s+='<a href="javascript:top.AddTo(\''+login+'\')" style="COLOR: #003388;">';
if (online!=0) {s+=login;} else {s+='<FONT color=gray><strong>'+login+'</strong>'}
s+='</a>['+level+']<a href=/inf.pl?'+id+' target=_blank><IMG SRC=<?=IMGBASE?>/i/inf.gif WIDTH=12 HEIGHT=11 ALT="Информация о персонаже"></a> ';
oTd.innerHTML = s;
oTr.appendChild(oTd);
var oTd = document.createElement('td');
oTd.align = 'right';
s = icon;
if (block != '' && block != '0') {
s += ' <font color=red><b>заблокирован</b></font> &nbsp; ';
icon = '';
} else {
if (boss != '' && boss != '0') { s+=' <b><font color=' + color + '>глава клана</font></b> &nbsp; ' }
else { if (titul != '') { s += '<b><font color=' + color + '>' + titul + '</font></b> &nbsp; '} }
}
if (online==0) {s+='</FONT>'};
oTd.innerHTML = s;
oTr.appendChild(oTd);
var oTd = document.createElement('td');
s = '';
oTd.innerHTML = s;
oTr.appendChild(oTd);
}
var TkTZ='';
var nTZ = '';
function High(cell, set) {
cell.className = (set ? "clansel" : "");
}
function Set(nm) {
document.all('d'+TkTZ).style.display = 'inline';
}
function highl(nm, i)
{
if (TkTZ == nm) {
document.all(nm).className = 'tzSet'
} else {
if (i==1) { document.all(nm).className = 'tzOver' }
else { document.all(nm).className = 'tz' }
}
}
function setTZ(nm, m)
{
if (TkTZ != '') {
if (!m) document.all(TkTZ).className = 'tz';
document.all('d'+TkTZ).style.display = 'none';
document.getElementById(TkTZ.substr(2)).className = 'off';
}
TkTZ = nm || 'TZ14';
document.getElementById(TkTZ.substr(2)).className = 'on';
if (!m)  document.all(TkTZ).className = 'tzSet';
document.all('d'+TkTZ).style.display = 'inline';
}
function mout(obj) {
if (TkTZ != '' && obj.id != document.getElementById(TkTZ.substr(2)).id) {
obj.className='off';
}
}
function AddEvent(edit) {
var prefix = (edit ? '' : 'add_');
if (!document.getElementById(prefix + 'event_header').value.length) {
alert('Вы не ввели заголовок!');
return;
}
if (!document.getElementById(prefix + 'event_text').value.length || document.getElementById(prefix + 'event_text').value.length > 600) {
alert('Сообщение отсутствует или слишком длинное!');
return;
}
if (edit) {
document.forms.editevent.submit();
} else {
document.forms.addevent.submit();
}
}
function Unprepare(str) {
if (!str) return '';
str = str.replace(/&quot;/gi, '"');
str = str.replace(/&rsquo;/gi, '’');
str = str.replace(/&lt;/gi, '<');
str = str.replace(/&gt;/gi, '>');
str = str.replace(/&amp;/gi, '&');
return str;
}
</SCRIPT>
</HEAD>
<body <? if (@$_GET["takeback"]) echo "onload=\"setTZ('TZ13', 1)\"";
elseif (@$_POST['login1'] || @$_POST['login2'] || @$_POST['login3']) echo "onload=\"setTZ('TZ11', 1)\"";
elseif ($_REQUEST['getmoney']!=1 && $_REQUEST['addmoney']!=1 && !$_REQUEST['add'] && !$_POST['about_clan'] && !$_REQUEST['back']&& !$_REQUEST['login']){echo "onload=\"setTZ('TZ14', 1);\""; }
?> background="<?=IMGBASE?>/i/misc/clans/klan_img_44.jpg">
<div id="mmoves3" style="background-color:#FFFFCC; visibility:hidden; z-index: 101; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px;"></div>
<div id=hint4 class=ahint></div>
<div id=hint3 class=ahint></div>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td height="18" valign="bottom"><img src="<?=IMGBASE?>/i/misc/clans/klan_img_03.jpg" width="75" height="18"></td>
<td width="1062" align="right" valign="bottom"><img src="<?=IMGBASE?>/i/misc/clans/klan_img_0113.jpg" width="59" height="18" alt="Вернуться" onmouseover="this.style.cursor = 'hand';" onclick="location.href='main.php'"></td>
</tr>
<tr>
<td height="32"><img src="<?=IMGBASE?>/i/misc/clans/klan_s3r3_07.jpg" width="75" height="32"></td>
<td width="100%" background="<?=IMGBASE?>/i/misc/clans/klan_img_08.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr valign=middle>
<th height="32"><IMG SRC="<?=IMGBASE?>/i/klan/<?=$klan['short']?>.gif" WIDTH=24 HEIGHT=15></th>
<th class=clan nowrap><?=$klan['name']?></th>
<th width="44"><img src="<?=IMGBASE?>/i/misc/clans/klan_img_09.jpg" width="44" height="32"></th>
<td class="off" onmouseover="this.className='on'" onmouseout="mout(this)" onclick="setTZ('TZ14', 1)" id="14"><a href="#">События </a></th>
<th width="44"><img src="<?=IMGBASE?>/i/misc/clans/klan_img_11.jpg" width="44" height="32"></th>
<td class="off" onmouseover="this.className='on'" onclick="setTZ('TZ11', 1)" onmouseout="mout(this)" id="11"><a href="#">Управление </a></td>
<th width="44"><img src="<?=IMGBASE?>/i/misc/clans/klan_img_13.jpg" width="44" height="32"></th>
<td class="off" onmouseover="this.className='on'" onmouseout="mout(this)" onclick="setTZ('TZ17', 1)" id="17" onmouseout="mout(this)"><a href="#">Хранилище </a></td>
<?// echo'<th><img src="http://img.combats.com/i/misc/clans/klan_img_15.jpg" width="44" height="32"></th>
//<td class="off" onmouseover="this.className=\'on\'" onclick="setTZ(\'TZ12\', 1)" id="12" onmouseout="mout(this)"><a href="#">Дипломатия </a></td>';
?>
<th width="44"><img src="<?=IMGBASE?>/i/misc/clans/klan_img_17.jpg" width="44" height="32"></th>
<td class="off" onmouseover="this.className='on'" onmouseout="mout(this)" onclick="setTZ('TZ13', 1)" id="13"><a href="#"><nobr>Вещи клана</nobr></a></td>
<th width="44"><img src="<?=IMGBASE?>/i/misc/clans/klan_img_19.jpg" width="44" height="32"></th>
<td class="off" onmouseover="this.className='on'" onmouseout="mout(this)" onclick="setTZ('TZ18', 1)" id="18"><a href="#">Права </a></td>
<th width="44"><img src="<?=IMGBASE?>/i/misc/clans/klan_img_21.jpg" width="44" height="32"></th>
<td nowrap class="off" onmouseover="this.className='on'" onmouseout="mout(this)" onclick="setTZ('TZ15', 1)" id="15"><a href="#">О клане </a></td>
<th width="44"><img src="<?=IMGBASE?>/i/misc/clans/klan_img_23.jpg" width="44" height="32"></th>
<td nowrap class="off" onmouseover="this.className='on'" onmouseout="mout(this)" onclick="setTZ('TZ16', 1)" id="16"><a href="#">Соклановцы</a></td>
</tr>
</table></td>
<td align="right" background="<?=IMGBASE?>/i/misc/clans/klan_img_08.jpg"><img src="<?=IMGBASE?>/i/misc/clans/klan_img_25.jpg" width="15" height="32"></td>
</tr>
<tr>
<td background="<?=IMGBASE?>/i/misc/clans/klan_img_28.jpg" height="12" colspan="5"><img src="<?=IMGBASE?>/i/misc/clans/klan_img_27.jpg" width="75" height="12"></td>
</tr>
<tr>
<td background="<?=IMGBASE?>/i/misc/clans/klan_img_44.jpg" colspan="5">
<FORM action="klan1.php" method=POST id=main name=main>
<TABLE cellspacing=0 cellpadding=0 width=100%>
<tr><td colspan=2><FONT COLOR=red></FONT>&nbsp;</td></tr>
</table>
<div class=dtz ID=dTZ11>
<?
if ($klan['clandem']==0) {
echo'Тип управления кланом: <B>неизвестно</B><BR>';
}elseif ($klan['clandem']==1) {
echo'Тип управления кланом: <B>Анархия</B><BR>';
}elseif ($klan['clandem']==2) {
echo'Тип управления кланом: <B>Монархия</B><BR>';
}elseif ($klan['clandem']==3) {
echo'Тип управления кланом: <B>Диктатура</B><BR>';
}elseif ($klan['clandem']==4) {
echo'Тип управления кланом: <B>Демократия</B><BR>';
}
        if($_POST['kik'] && $_POST['leave']) {
            $sok = mysql_fetch_array(mq('SELECT * FROM `users` WHERE  `klan` = \''.$klan['short'].'\' AND `id` = \''.$_SESSION['uid'].'\' LIMIT 1;'));
            if ($sok) {
                mq("update clans set cnt=cnt-1 where id='$klan[id]'");
                setrestriction($sok["id"]);
                mq('update `users` set `klan` = \'\', `align` = 0 WHERE `id` = '.$sok['id'].';');
                mq('update `allusers` set `klan` = \'\', `align` = 0 WHERE `id` = '.$sok['id'].';');
                mq('update `userdata` set `align` = 0 WHERE `id` = '.$sok['id'].';');
                mq('update `alluserdata` set `align` = 0 WHERE `id` = '.$sok['id'].';');
                header("Location: main.php");
                die();
            }
        }

/*


a:2:{i:111;a:14:{i:0;i:1;i:1;i:1;i:2;i:1;i:3;i:1;i:4;i:1;i:5;i:1;i:6;i:1;i:7;i:1;i:8;i:1;i:9;i:1;i:10;i:1;i:11;i:1;i:12;i:1;i:13;i:1;}i:311;a:14:{i:0;i:1;i:1;i:1;i:2;i:1;i:3;i:1;i:4;i:1;i:5;i:1;i:6;i:1;i:7;i:1;i:8;i:1;i:9;i:1;i:10;i:1;i:11;i:1;i:12;i:1;i:13;i:1;}}

*/

if($_POST['login']){echo"<script>setTZ('TZ11', 1)</script>";}
    if ($klan['glava']==$user['id'] OR $polno[$user['id']][0]==1 OR $polno[$user['id']][9]==1 OR $polno[$user['id']][10]==1 OR $polno[$user['id']][13]==1) {
        echo "<form method=post>";
        if ($polno[$user['id']][9]==1) {echo '<INPUT TYPE="button" onclick="findlogin(\'Пригласить в клан\', \'klan1.php\', \'login2\');" value="Пригласить в клан" title="Пригласить в клан"> (это вам обойдется в <B>0</B> кр.)<BR><FONT style=dsc>(перед приемом в клан, персонаж должен пройти проверку у паладинов)</FONT><BR>';}
        if ($polno[$user['id']][10]==1) {echo '<INPUT TYPE="button" onclick="findlogin(\'Выгнать из клана\', \'klan1.php\', \'login1\');" value="Выгнать из клана" title="Выгнать из клана"> (это вам обойдется в <B>0</B> кр.)<BR>';}
        if ($klan['glava']==$user['id']) echo '<INPUT TYPE="button" onclick="findlogin(\'Сменить главу клана\', \'klan1.php\', \'login3\');" value="Сменить главу клана" title="Сменить главу клана"> (глава клана в праве сложить с себя полномочия, назначив главой клана другого персонажа)<BR>';
        if ($polno[$user['id']][0]==1 OR $klan['glava']==$user['id']) echo '<INPUT TYPE="button" onclick="findlogin(\'Редактировать права участника клана\', \'klan1.php\', \'login\');" value="Редактировать права участника клана" title="Редактировать права участника клана"><BR>';

        if ($_POST['login']) {
        $_POST['status']=htmlspecialchars($_POST['status']);
        if(preg_match("/__/",$_POST['status']) || preg_match("/--/",$_POST['status']))
        {
        echo"В тексте не должно присутствовать подряд более 1 символа '_' или '-'.";
        }else{
            $sok=false; 
            /*  Можно включить, когда кеш сокланов будет обновляцца в момент изменения прав
            foreach ($members as $k=>$v) {
              if ($v["login"]==$_POST['login']) {
                $sok=$v;
                break;
              }
            }*/
            if (!$sok) $sok=mqfa('SELECT * FROM `users` WHERE  `klan` = \''.$klan['short'].'\' AND `login` = \''.$_POST['login'].'\'');
            if (!$sok) $sok=mqfa('SELECT * FROM `allusers` WHERE  `klan` = \''.$klan['short'].'\' AND `login` = \''.$_POST['login'].'\'');
            $st = strip_tags(str_replace("&lt;","<",str_replace("&gt;",">",$_POST['status'])),"<B><I><U>");
            if($klan['glava']==$sok['id']) {
                $st = "<font color=#008080><b>Глава клана</b></font>";
            }
}
            if($sok) {
                if($_POST['save']) {
                    if ($_POST['priv']=='on') { $polno[$sok['id']][0]=1; } else { $polno[$sok['id']][0]=0;}
                    if ($_POST['event']=='on') { $polno[$sok['id']][1]=1; } else { $polno[$sok['id']][1]=0;}
                    if ($_POST['addevent']=='on') { $polno[$sok['id']][2]=1; } else { $polno[$sok['id']][2]=0;}
                    if ($_POST['skazna']=='on') { $polno[$sok['id']][3]=1; } else { $polno[$sok['id']][3]=0;}
                    if ($_POST['useskazna']=='on') { $polno[$sok['id']][4]=1; } else { $polno[$sok['id']][4]=0;}
                    if ($_POST['kaznalog']=='on') { $polno[$sok['id']][5]=1; } else { $polno[$sok['id']][5]=0;}
                    if ($_POST['givekazna']=='on') { $polno[$sok['id']][6]=1; } else { $polno[$sok['id']][6]=0;}
                    if ($_POST['usekazna']=='on') { $polno[$sok['id']][7]=1; } else { $polno[$sok['id']][7]=0;}
                    if ($_POST['union']=='on') { $polno[$sok['id']][8]=1; } else { $polno[$sok['id']][8]=0;}
                    if ($_POST['klantake']=='on') { $polno[$sok['id']][9]=1; } else { $polno[$sok['id']][9]=0;}
                    if ($_POST['klanout']=='on') { $polno[$sok['id']][10]=1; } else { $polno[$sok['id']][10]=0;}
                    if ($_POST['editklaninfo']=='on') { $polno[$sok['id']][11]=1; } else { $polno[$sok['id']][11]=0;}
                    if ($_POST['manageunion']=='on') { $polno[$sok['id']][12]=1; } else { $polno[$sok['id']][12]=0;}
                    if ($_POST['editevents']=='on') { $polno[$sok['id']][13]=1; } else { $polno[$sok['id']][13]=0;}
                    mq('UPDATE `users` SET `status` = \''.$st.'\' WHERE `id` = \''.$sok['id'].'\';');
                    mq('UPDATE `allusers` SET `status` = \''.$st.'\' WHERE `id` = \''.$sok['id'].'\';');
                    if ($polno[$user['id']][0]==1 OR $klan['glava']==$user['id']) {
                        mq('UPDATE `clans` SET `vozm` = \''.serialize($polno).'\' WHERE `id` = \''.$klan['id'].'\';');
                    }
                    $sok['status'] = $st;
                                 echo"<script>setTZ('TZ11', 1)</script>";
                }
                echo '<BR><fieldset ><legend>Редактирование прав "',$sok['login'],'"</legend>
                    Звание в клане <input type=text value="',$sok['status'],'" name=status><BR>';
                if ($klan['glava']==$user['id'] or $_SESSION['uid']==311) {
                    echo '<input type=checkbox name=priv ';
                        if ($polno[$sok['id']][0]==1) { echo ' checked '; }
                    echo '>Редактирование прав участников в клане<BR>';
                    echo '<input type=checkbox name=event ';
                        if ($polno[$sok['id']][1]==1) { echo ' checked '; }
                    echo '>Просмотр событий клана<BR>';
                    echo '<input type=checkbox name=addevent ';
                        if ($polno[$sok['id']][2]==1) { echo ' checked '; }
                    echo '>Создание событий клана<BR>';
                    echo '<input type=checkbox name=editevents ';
                        if ($polno[$sok['id']][13]==1) { echo ' checked '; }
                    echo '>Редактирование событий клана<BR>';
                    echo '<input type=checkbox name=skazna ';
                        if ($polno[$sok['id']][3]==1) { echo ' checked '; }
                    echo '>Просмотр хранилища<BR>';
                    echo '<input type=checkbox name=useskazna ';
                        if ($polno[$sok['id']][4]==1) { echo ' checked '; }
                    echo '>Использование вещей из хранилища<BR>';
                    echo '<input type=checkbox name=kaznalog ';
                        if ($polno[$sok['id']][5]==1) { echo ' checked '; }
                    echo '>Просмотр казны и списка игроков, пополнявших казну<BR>';
                    echo '<input type=checkbox name=givekazna ';
                        if ($polno[$sok['id']][6]==1) { echo ' checked '; }
                    echo '>Пополнение казны<BR>';
                    echo '<input type=checkbox name=usekazna ';
                        if ($polno[$sok['id']][7]==1) { echo ' checked '; }
                    echo '>Использование казны<BR>';
                //  echo '<input type=checkbox name=union ';
                //      if ($polno[$sok['id']][8]==1) { echo ' checked '; }
                //  echo '>Клановые союзы и альянсы<BR>';
                    echo '<input type=checkbox name=klantake ';
                        if ($polno[$sok['id']][9]==1) { echo ' checked '; }
                    echo '>Прием в клан<BR>';
                    echo '<input type=checkbox name=klanout ';
                        if ($polno[$sok['id']][10]==1) { echo ' checked '; }
                    echo '>Изгнание из клана<BR>';
                    echo '<input type=checkbox name=editklaninfo ';
                        if ($polno[$sok['id']][11]==1) { echo ' checked '; }
                    echo '>Редактирование информации о клане<BR>';
                //  echo '<input type=checkbox name=manageunion ';
                //      if ($polno[$sok['id']][12]==1) { echo ' checked '; }
                //  echo '>Управление союзами и альянсами<BR>';

                }
                echo '<input type=hidden value="',$sok['login'],'" name=login><input type=submit value="Сохранить" name=save></fieldset>';
            }


        }
        if ($_POST['login3'] && $klan['glava']==$user['id']) {
            $sok=mqfa('SELECT * FROM `users` WHERE  `klan` = \''.$klan['short'].'\' AND `login` = \''.$_POST['login3'].'\'');
            if (!$sok) {
              $sok=mqfa('SELECT * FROM `allusers` WHERE  `klan` = \''.$klan['short'].'\' AND `login` = \''.$_POST['login3'].'\'');
            }
            if (!$sok) echo "<font color=red>Персонаж $_POST[login3] не найден.</font>";
            else {
              //mq('update `users` set `money` = `money` - 30 WHERE `id` = '.$_SESSION['uid'].';');
              //mq('update `users` set `klan` = \'\', `align` = 0 WHERE `id` = '.$sok['id'].';');
              mq('update `clans` set `glava` = \''.$sok['id'].'\' WHERE `id` = '.$klan['id'].';');
              mq('update `users` set `status` = \'<font color=#008080><b>Глава клана</b></font>\' WHERE `id` = '.$sok['id'].';');
              mq('update `allusers` set `status` = \'<font color=#008080><b>Глава клана</b></font>\' WHERE `id` = '.$sok['id'].';');
              mq('update `users` set `status` = \'боец\' WHERE `id` = '.$user['id'].';');
              $klan['glava'] = $sok['id'];
            }
        }
        if($_POST['login2'] && $polno[$user['id']][9]==1) {
            $sok = mqfa('SELECT * FROM `users` WHERE  `klan` = \'\' AND `align` = \'0\' AND `login` = \''.$_POST['login2'].'\'');
            if (!$sok) $sok = mqfa('SELECT * FROM `allusers` WHERE  `klan` = \'\' AND `align` = \'0\' AND `login` = \''.$_POST['login2'].'\'');
            $eff = mqfa("SELECT * FROM `effects` WHERE `owner` = '".$sok['id']."' AND `type` = 20");
            if (!$eff) {
              $eff=mqfa("SELECT * FROM `alleffects` WHERE `owner` = '".$sok['id']."' AND `type` = 20 and time>".time());
            }
            if (!$eff) {
              echo "<script>alert('У персонажа $sok[login] нет проверки!');</script>";
            } else {
              $maxclan[0]=8;
              $maxclan[1]=12;
              $maxclan[2]=16;
              $maxclan[3]=20;
              $maxclan[4]=24;
              $maxclan[5]=28;
              $maxclan[6]=32;
              $maxclan[7]=36;
              $maxclan[8]=40;
              $maxclan[9]=44;
              $maxclan[10]=48;
              $maxclan[11]=52;
              //$cnt=mqfa1("select count(id) from users where klan='$klan[short]'");
              if ($klan["cnt"]>=$maxclan[$klan["clanlevel"]]) {
                echo "<script>alert('Нет свободных мест в клане. Для принятия новичков необходимо увеличить уровень клана или выгнать кого-то.');</script>";
              } elseif ($sok['level']==0) {
                echo "<script>alert('Приём в клан с первого уровня.');</script>";
              } else {
                mq("update clans set cnt=cnt+1 where id='$klan[id]'");
                $klan["cnt"]++;
                echo '<script>alert(\'Персонаж "',$sok['login'],'" успешно принят в клан.\');</script>';
                mq("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$sok['id']."','Принят в клан ".$klan['short']."','".time()."')");
                mq('update `users` set `status`= \'боец\', `klan` = \''.$klan['short'].'\', `align` = \''.$klan['align'].'\' WHERE `id` = '.$sok['id'].'');
                mq('update `allusers` set `status`= \'боец\', `klan` = \''.$klan['short'].'\', `align` = \''.$klan['align'].'\' WHERE `id` = '.$sok['id'].'');
                mq('update `userdata` set `align` = \''.$klan['align'].'\' WHERE `id` = '.$sok['id'].'');
                mq('update `alluserdata` set `align` = \''.$klan['align'].'\' WHERE `id` = '.$sok['id'].'');
              }
            }
        }
        if($_POST['login1'] && $polno[$user['id']][10]==1) {
            $sok=mqfa('SELECT * FROM `users` WHERE  `klan` = \''.$klan['short'].'\' AND `login` = \''.$_POST['login1'].'\'');
            if (!$sok) $sok=mqfa('SELECT * FROM `allusers` WHERE  `klan` = \''.$klan['short'].'\' AND `login` = \''.$_POST['login1'].'\'');
            if ($sok && $klan['glava']!=$sok['id']) {
                mq("update clans set cnt=cnt-1 where id='$klan[id]'");
                echo '<font color=red>Персонаж "',$sok['login'],'" покинул клан.</font>';
                setrestriction($sok["id"]);
                //mq('update `users` set `money` = `money` - 30 WHERE `id` = '.$_SESSION['uid'].';');
                mq("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$sok['id']."','Покинул клан ".$klan['short']."','".time()."')");
                mq('update `users` set `klan` = \'\', `align` = 0 WHERE `id` = '.$sok['id'].'');
                mq('update `allusers` set `klan` = \'\', `align` = 0 WHERE `id` = '.$sok['id'].'');
                mq('update `userdata` set `align` = 0 WHERE `id` = '.$sok['id'].'');
                mq('update `alluserdata` set `align` = 0 WHERE `id` = '.$sok['id'].'');
            } else echo '<font color=red>Персонаж "'.$_POST['login1'].'" не найден.</font>';
        }
    }

if ($_REQUEST['putmoney']>=1 && $_REQUEST['addmoney']==1 && $polno[$user['id']][6]==1){
        $_REQUEST['putmoney'] = round($_REQUEST['putmoney'],2);
        if (!cangive($_REQUEST['putmoney'])) {
          echo"<script>setTZ('TZ11', 1)</script><font color=red>Сумма денег превышает допустимый лимит</font><br>";
        } elseif (is_numeric($_REQUEST['putmoney']) && ($_REQUEST['putmoney']>0) && ($_REQUEST['putmoney'] <= $user['money'])) {          
          if (mq("UPDATE `clans` set money=money+".strval($_REQUEST[putmoney])." where glava='".$klan['glava']."'")) {
            mq("update userdata set balance=balance-$_REQUEST[putmoney] where id='$user[id]'");
            mq("insert into delo set pers='$user[id]', `text`='\"$user[login]\" положил в казну клана $user[klan] $_REQUEST[putmoney] кр. ($user[money]/$user[ekr])', type=6, `date`=".time());
            mq("UPDATE `users` set money=money-".strval($_REQUEST[putmoney])." where id='".$user['id']."'");
    mq("INSERT INTO `kaznalog` (`klan`, `user`, `sum`, `action`, `date`)VALUES ('".$user['klan']."', '".$_SESSION['uid']."', '".strval($_REQUEST[putmoney])."', '1', '".date('d.m.y H:i')."');");

                echo"<script>setTZ('TZ11', 1)</script><font color=red>Удачно пополнена казна клана на ".$_REQUEST['putmoney']." кр.</font><br>";
                                $klan = mysql_fetch_array(mq("SELECT * FROM `clans` WHERE `short` = '{$user['klan']}' LIMIT 1;"));
  } else {echo"<script>setTZ('TZ11', 1)</script><font color=red>Произошла ошибка!</font><br>";}




}else{  echo"<script>setTZ('TZ11', 1)</script><font color=red>Недостаточно денег</font><br>";}

}


?>
<?  if ($klan['glava']!=$user['id']) echo '<br><INPUT type="hidden" name="kik" value="1"><INPUT TYPE=submit value="Покинуть клан" name=leave onclick="return confirm(\'Вы действительно хотите покинуть клан?\')" title="Покинуть клан"> (это вам обойдется в <B>0 кр.</B>)';?>
<br>
</FORM>
<?

if ($_REQUEST['money']>=1 && $_REQUEST['getmoney']==1 && $polno[$user['id']][7]==1){
        $_REQUEST['money'] = round($_REQUEST['money'],2);

        if (is_numeric($_REQUEST['money']) && ($_REQUEST['money']>0) && ($_REQUEST['money'] <= $klan['money'])) {
            mq("insert into delo set pers='$user[id]', `text`='\"$user[login]\" забрал из казны клана $user[klan] $_REQUEST[money] кр. ($user[money]/$user[ekr])', type=6, `date`=".time());
            if (mq("UPDATE `clans` set money=money-".strval($_REQUEST[money])." where glava='".$klan['glava']."'")) {
mq("UPDATE `users` set money=money+".strval($_REQUEST[money])." where id='".$user['id']."'");
    mq("INSERT INTO `kaznalog` (`klan`, `user`, `sum`, `action`, `date`)VALUES ('".$user['klan']."', '".$_SESSION['uid']."', '".strval($_REQUEST[money])."', '0', '".date('d.m.y H:i')."');");
                echo"<script>setTZ('TZ11', 1)</script><font color=red>Удачно взято ".$_REQUEST['money']." кр. из казны клана.</font><br>";
                                $klan = mysql_fetch_array(mq("SELECT * FROM `clans` WHERE `short` = '{$user['klan']}' LIMIT 1;"));}
 else{echo"<script>setTZ('TZ11', 1)</script><font color=red>Произошла ошибка!</font><br>";}




}else{  echo"<script>setTZ('TZ11', 1)</script><font color=red>Недостаточно денег</font><br>";}

}




 ?>

<?if($polno[$user['id']][5]==1){?>
<H4>Казна клана</H4>

<SCRIPT>
function ShowKaznaLogs(p) {
if (!p) p = 0;
wnd = top.wnd = top.CheckDialogsDiv();
s = top.AjaxGet('/klan1.php?kaznalist=1&p=' + p + '&rnd=' + Math.floor(Math.random()*1000));
s = crtmagic(0, "Просмотр операций с казной", s);
wnd.innerHTML = s;
wnd.style.visibility = "visible";
wnd.style.left = 100;
wnd.childNodes[0].width = 400;
wnd.style.zIndex = 200;
wnd.style.top = document.body.scrollTop+50;
}
</SCRIPT>
Денег в казне клана: <?=$klan['money']?>&nbsp;&nbsp;<input type=button value="Список операций" onClick="window.open('klan1.php?kaznalog=1', 'kaznalog', 'height=400,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes,resizable=no')"><BR>
<?} if($polno[$user['id']][7]==1){?>
<FORM><input type=hidden name=getmoney value=1>Забрать из казны: <INPUT type=text name='money' value='0'> <INPUT type=submit value='>>'><BR></FORM>
<?} if($polno[$user['id']][6]==1){?>
<hr><FORM><input type=hidden name=addmoney value=1>Положить деньги в казну: <INPUT type=text name='putmoney' value='0'> <INPUT type=submit value='>>'><BR></FORM>
<BR>
<?}?>
</div>
<div class=dtz ID=dTZ17 style='padding: 0 5 0 5;'>
<FIELDSET>
<LEGEND><H4>Хранилище</H4></LEGEND>
Внимание! Вещи, которые помещаются в хранилище, становятся собственностью клана. После этого их невозможно продать в магазин, глава клана в любой момент может вернуть эти вещи обратно в хранилище и бывший владелец теряет все права собственности данных вещей.
Хранилище предназначено только для хранения клановых а не личных вещей. Поместив вещь в хранилище, вы в будущем не сможете её продать, глава клана сможет её у вас забрать и также вы потеряете возможность использовать эту вещь, если покинете клан.<br>
<?
if ($klan["glava"]==$user["id"]) echo '<input type=button value="Список операций" onClick="window.open(\'klan1.php?trunklog=1\', \'kaznalog\', \'height=400,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes,resizable=no\')">';
if($polno[$user['id']][3]==1 || $_SESSION["uid"]==7){
                if($_GET['back'] && $polno[$user['id']][4]==1) {
                    $it = mysql_fetch_array(mq("SELECT * FROM `clanstorage` WHERE `id` = ".$_GET['back']." and klan='$user[klan]' and taken=0"));
                    if ($it) {
                      if($polno[$user['id']][4]==1 OR $user['id']==$glava[0]) {
                        $i=mqfa1("select id from inventory where id='$it[id_it]'");
                        if (!$i) mq("insert into inventory (select * from allinventory where id='$it[id_it]')");
                        mq("insert into delo set pers='$user[id]', `text`='\"$user[login]\" забрал из хранилища клана $user[klan] предмет \"".addslashesa(mqfa1("select name from inventory where id='$it[id_it]'"))."\", id: $it[id_it]', type=6, `date`=".time());
                        err("<script>setTZ('TZ17', 1)</script>Вы забрали вещь из хранилища.");
                        mq("update `inventory` SET `owner` = ".$user['id']." WHERE `id` = ".$it['id_it'].";");
                        mq("update `clanstorage` set taken='$user[id]' WHERE `id` = ".$_GET['back'].";");
                      } else addcheater("take item from storage");
                    }
                    echo"<script>setTZ('TZ17', 1)</script>";
                }
                // положить шмотку
                if($_GET['add'] && $polno[$user['id']][4]==1) {
                    $it = mysql_fetch_assoc(mq("SELECT * FROM `inventory` WHERE `dressed`=0 AND setsale=0 AND owner=$user[id] $itemcond AND `id` = ".$_GET['add'].";"));
                    $price=itemprice($it);
                    if($it['owner'] ==$user['id']) {
                      $skoka = mysql_num_rows(mq("SELECT id FROM `clanstorage` WHERE `klan` = '{$user['klan']}' and taken=0;"));
                      if($klan['clanlevel']<4 && $skoka>=50){err("Количество вещей превышает лимит Вашего клана.");}
                      elseif($klan['clanlevel']<7 && $klan['clanlevel']>3 && $skoka>=100){err("Количество вещей превышает лимит Вашего клана.");}
                      elseif($klan['clanlevel']>=7 && $skoka>=200){err("Количество вещей превышает лимит Вашего клана.");}
                      elseif ($it["clan"]=='' && !cangive($price["price"])) {
                        err("Цена вещи превышает допустимый лимит");
                      } else{
                        if ($it["clan"]!='') mq("update userdata set balance=balance-$price[price] where id='$user[id]'");
                        mq("insert into delo set pers='$user[id]', `text`='\"$user[login]\" положил в хранилище клана $user[klan] предмет \"".addslashesa($it["name"])."\", id: $it[id]', type=6, `date`=".time());
                        err("Вы положили вещь в хранилище.");
                        $i=mqfa1("select id from clanstorage where id_it='$it[id]'");
                          mq("update `inventory` SET `owner` = '',`clan` = '{$user['klan']}' WHERE `id` = ".$it['id'].";");
                        if ($i) {
                          mq("update clanstorage set taken=0, item='".serialize($it)."' where id='$i'");
                          mq("update inventory set owner=0 where id='$it[id]'");
                        } else {
                          mq("update `inventory` SET owner=0, clan='{$user['klan']}' WHERE `id` = ".$it['id'].";");
                          mq("insert `clanstorage` (`id_it`,`owner`,`klan`, item) values (".$it['id'].",".$user['id'].",'{$user['klan']}', '".serialize($it)."');");
                        }
                      }
                      echo"<script>setTZ('TZ17', 1)</script>";
                    } else addcheater("putting into storage");
                }
?>
<table width=100% cellpadding=5>
<tr>
<td>
<TABLE width=100% cellpadding=0 cellspacing=0><TR bgcolor=#A0A0A0>
<? 
//$data = mq("SELECT clanstorage.id as clanid, clanstorage.owner as clanowner, inventory.* FROM clanstorage left join inventory on inventory.id=clanstorage.id_it WHERE clanstorage.`klan` = '{$user['klan']}' ;");
$data=mq("SELECT id as clanid, owner as clanowner, item FROM clanstorage WHERE `klan` = '{$user['klan']}' and taken=0 order by id desc");
$tekush = mysql_num_rows($data);
 if($klan['clanlevel']<4){$vsego=50;}
 elseif($klan['clanlevel']<7 && $klan['clanlevel']>3){$vsego=100;}
 else{$vsego=200;}

 ?>
<TD width=50%><table width=100%><tr><td width=50%>В хранилище <?=$tekush?>/<?=$vsego?></td><td><!--Передачи 0/200--></td></tr></table></TD><TD>В рюкзаке</TD>
</TR>
<TR>
<TD valign=top><!--Рюкзак-->
<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=2 BGCOLOR=A5A5A5>
<?

                if(!$_GET['do']) {


                echo '<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">';
                while($row = mysql_fetch_array($data)) {
                  $item=unserialize($row["item"]);
                    //$row = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$it['id_it']}' LIMIT 1;"));
                     $item['count'] = 1;
                        if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
                    echo "<TR bgcolor={$color}><TD align=center width=20%><IMG SRC=\"".IMGBASE."/i/sh/{$item['img']}\" BORDER=0>
                    <BR><small>
                    Положил:<BR> ".clannick3($row['clanowner'])." <BR></small>";
                    ?>
                    <? if($polno[$user['id']][4]==1){
                    ?><A HREF="?back=<?=$row['clanid']?>">забрать</A><BR><?
                    }
                    else {
                    echo '<small>Вы не можете забрать эту вещь из хранилища</small>';
                    }
                    ?>
                    </TD>
                <?php
                    echo "<TD valign=top>";
                    showitem ($item);
                    echo "</TD></TR>";
                }
                echo "</TABLE></TD><TD valign=top><!--Рюкзак-->
                    <TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=2 BGCOLOR=A5A5A5>"; }
                    $data = mq("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0  AND `setsale`=0 ".$itemcond." ORDER by `update` DESC; ");
                    while($row = mysql_fetch_array($data)) {
                        $row['count'] = 1;
                        if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
                        echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"".IMGBASE."/i/sh/{$row['img']}\" BORDER=0>";
                        ?>
                                                <? if($polno[$user['id']][4]==1){?>
                        <BR><A HREF="?add=<?=$row['id']?>&sid=&sale=1">положить</A><?
                                }
                                else {
                                echo '<br><small>Вы не можете положить эту вещь в хранилище</small>';
                            }
                            ?>
                        </TD>
                        <?php
                        echo "<TD valign=top>";
                        showitem ($row);
                            echo "</TD></TR>";
                    }
                    echo "</table>";
}else
echo' Недостаточно прав для просмотра хранилища';?>
</TD>
</TR>

</TABLE>
</TD>
</TR></TABLE>
</td>
</tr>
</table>


<br>
</div>
<div class=dtz ID=dTZ12>
<FIELDSET><LEGEND><H4>Клановые войны</H4></LEGEND>
<table cellspacing=0 cellpadding=2 border=0 width="100%">
<TR>
<TD>В данный момент Ваш клан не ведет войн.</TD>
</TR>
</table>
</FIELDSET>
<? if($polno[$user['id']][8]==1){?>
<FIELDSET><LEGEND><H4>Союзы и альянсы</H4></LEGEND>
<table cellspacing=0 cellpadding=2 border=0 width="100%">

<SCRIPT>
function AddUnion(is_alliance) {
var name = (is_alliance ? 'Alliance' : 'Union');
var s = '<form><input type=hidden name="action" value="apply' + (is_alliance ? 'alliance' : '') + '"> \
<table width=100% width=340> \
<tr><td nowrap>Название ' + (is_alliance ? "альянса" : "союза") + ':</td><td><input type=text name="' + name + '" style="width: 120px;"></td></tr>';
s += '<tr style="padding: 0 5 0 5;"><td colspan=2><small>' + (is_alliance ? 'Название альянса должно состоять из <b>трех</b> слов' : 'Название союза должно состоять из <b>двух</b> слов') + '</small></td></tr>';
if (is_alliance) {
s += '<tr><td nowrap>Название союза:</td><td><SELECT name="' + name + 'Klan" style="width: 120px;" ><option>Цитадель Тьмы</option><option>союз Атона</option><option>Союз BWB</option><option>союз Brothers</option><option>Орден Tremere</option><option>Истинных нейтралов</option><option>Empires 911</option><option>Союз мерков</option><option>Нейтральный союз</option></SELECT></td></tr>';
} else {
s += '<tr><td nowrap>Название клана:</td><td><SELECT name="' + name + 'Klan" style="width: 120px;" ><option>ADF</option><option>ARTofDEATH</option><option>Adepts</option><option>Agents</option><option>AlcoholConsumers</option><option>AmazonesOfTheNorth</option><option>Amber</option><option>Amore</option><option>AnarchyXVI</option><option>AngelsOfDark</option><option>AngelsOfDeath</option><option>Angelsnights</option><option>AngelsofDeath</option><option>Angerofdarkness</option><option>AoD</option><option>AoS</option><option>ApoRecruits</option><option>Apocalipsys</option><option>ApocalipsysPhoenixes</option><option>Archangellight</option><option>Armageddon</option><option>Armelite</option><option>ArmyofBrothers</option><option>Artel</option><option>Artfox</option><option>Astreya</option><option>Atlants</option><option>Atln</option><option>AuthorityHolders</option><option>Avalanche</option><option>Avanpost</option><option>Avengers</option><option>AzureDragons</option><option>BAM</option><option>BBoys</option><option>BEG</option><option>BLooDLusT</option><option>BMR</option><option>BOPH</option><option>BOTD</option><option>BOWW</option><option>BShadows</option><option>BWL</option><option>Bajari</option><option>Bakililar</option><option>Baku</option><option>BalticOrder</option><option>Balticsclan</option><option>Barbarians</option><option>Bats</option><option>Beggars</option><option>Bersercs</option><option>Best</option><option>BlKn</option><option>BlackCompany</option><option>BlackDeathClan</option><option>BlackDiamond</option><option>BlackDragons</option><option>BlackFog</option><option>BlackFraers</option><option>BlackJoker</option><option>BlackLight</option><option>BlackPanthers</option><option>BlackSnakes</option><option>BloodAngels</option><option>BloodBrothers</option><option>BloodHuntes</option><option>BloodKnights</option><option>BloodPhoenix</option><option>BloodSuckers</option><option>BloodyAvengers</option><option>Bloodysunset</option><option>BoC</option><option>BoD</option><option>BoF</option><option>BoK</option><option>BoRunes</option><option>BoS</option><option>BoU</option><option>BoW</option><option>Bods</option><option>Boondocksaints</option><option>Bozgurd</option><option>BraveHearts</option><option>Brigada</option><option>BrotherhoodOfFlood</option><option>BrotherhoodofReason</option><option>BrothersOfJustice</option><option>Brujah</option><option>Bruts</option><option>CBA</option><option>CID</option><option>COH</option><option>CPO</option><option>CSKA</option><option>Calipso</option><option>Camelot</option><option>CannibalS</option><option>Casuals</option><option>CelestialBrotherhood</option><option>Celts</option><option>ChC</option><option>ChampionsOfEvil</option><option>CharmeD</option><option>ChildrenOfTheShadow</option><option>Chroniclers</option><option>Church</option><option>ClanOfDurin</option><option>ClanofPleasure</option><option>CoD</option><option>CoF</option><option>CoU</option><option>Coma</option><option>Cossacks</option><option>CossacksofheLL</option><option>CrB</option><option>CrazyPeople</option><option>CrusadersClan</option><option>CursedLegion</option><option>CyberS</option><option>DCR</option><option>DDT</option><option>DEVIL</option><option>DFK</option><option>DFM</option><option>DGoD</option><option>DHunters</option><option>DNF</option><option>DOV</option><option>DPPS</option><option>DRV</option><option>DSS</option><option>DTP</option><option>DWH</option><option>DaA</option><option>DamnedLoggers</option><option>DamnedSouls</option><option>Damnedlegions</option><option>DarkBrotherhood</option><option>DarkBrothersHood</option><option>DarkCelestialclan</option><option>DarkClan</option><option>DarkD</option><option>DarkDruids</option><option>DarkEclipse</option><option>DarkFire</option><option>DarkFuture</option><option>DarkH</option><option>DarkImmortals</option><option>DarkJustice</option><option>DarkLaw</option><option>DarkLegion</option><option>DarkMagic</option><option>DarkOd</option><option>DarkOrchestra</option><option>DarkOrder</option><option>DarkPhantom</option><option>DarkR</option><option>DarkRunes</option><option>DarkRunesAdepts</option><option>DarkSIN</option><option>DarkSINRecruits</option><option>DarkShine</option><option>DarkSouls</option><option>DarkStars</option><option>DarkSun</option><option>DarkWarriors</option><option>DarkWitnesses</option><option>DarkZenit</option><option>DarkandLight</option><option>Darkempire</option><option>Darkkey</option><option>DeaS</option><option>DeadAnarchists</option><option>DeadLords</option><option>DeathDragons</option><option>DecepticonS</option><option>DefOL</option><option>Defenders</option><option>Demiurge</option><option>DesertClan</option><option>Desorden</option><option>Desperado</option><option>Destroyers</option><option>Destructors</option><option>DevilsSun</option><option>Devs</option><option>DiggersSociety</option><option>DoW</option><option>DragonBreath</option><option>DragonLance</option><option>DragonRiders</option><option>Dragons</option><option>DreamLab</option><option>Druggists</option><option>Dside</option><option>Dsoe</option><option>Dungeon</option><option>DungeonKeepers</option><option>DungeonWarriors</option><option>Dwarfs</option><option>Dynamo</option><option>DynamoKyiv</option><option>EFamily</option><option>Eagles</option><option>Elite</option><option>EliteBrothers</option><option>EliteVampires</option><option>Empire</option><option>EmpireLegions</option><option>Enclav</option><option>Endless</option><option>EoD</option><option>Equal</option><option>Equillibrium</option><option>Espidis</option><option>EssenceofDarkness</option><option>Eternal</option><option>EvilFighters</option><option>Executors</option><option>Exorcium</option><option>FCK</option><option>FGods</option><option>FOF</option><option>FOLL</option><option>FOR</option><option>FTO</option><option>FabulousLegendary</option><option>FairOrden</option><option>FaithfulFriends</option><option>FallenAngels</option><option>FallenXaos</option><option>Family</option><option>Fearless</option><option>FearlessWarriors</option><option>FemidaJudges</option><option>Fierybird</option><option>FightCats</option><option>Fighters</option><option>FireDragons</option><option>FirstLine</option><option>FlY</option><option>FlameOfwaR</option><option>FlaringLegion</option><option>FoB</option><option>FoM</option><option>FogKnights</option><option>FogPhantoms</option><option>Forestelfs</option><option>Forpost</option><option>FoundoutBlood</option><option>FreeFighters</option><option>FreeLovers</option><option>FreePlay</option><option>Freemen</option><option>Gargouille</option><option>Ghosts</option><option>Gladiators</option><option>GlamourGirls</option><option>GlobalFigthers</option><option>GoD</option><option>GodsClan</option><option>GoldenPyramid</option><option>Gothica</option><option>GrayCircle</option><option>GreyBrotherhood</option><option>GreyDevils</option><option>GreyFlame</option><option>GreyForce</option><option>GreyKnights</option><option>GreyLegion</option><option>GreyShadows</option><option>Greys</option><option>Guards</option><option>Guild On the Dark Side</option><option>GuildofDragons</option><option>HARMONY</option><option>HELP</option><option>HIM</option><option>HONOR</option><option>Haiducii</option><option>Hamster</option><option>Harbour</option><option>HeliosSparta</option><option>Hell</option><option>HellRaised</option><option>HellRiders</option><option>Hellraisers</option><option>HeroesOfSword</option><option>HolyKnights</option><option>Hooligans</option><option>Hope</option><option>Hug</option><option>HuntersOfDestiny</option><option>IDOLs</option><option>IGO</option><option>IIH</option><option>ILLuminati</option><option>INQRS</option><option>IcE</option><option>IceAge</option><option>ImRecruits</option><option>ImmortalFighters</option><option>Immortals</option><option>Indigo</option><option>InfatuatioN</option><option>Inferno</option><option>InvisibleS</option><option>Invisibles</option><option>IronF</option><option>JackalClan</option><option>JackalsJunior</option><option>JediClan</option><option>JoD</option><option>JudgesOfHell</option><option>Justice</option><option>KAS</option><option>KBS</option><option>KGL</option><option>KHonour</option><option>KNIGHTS</option><option>KNL</option><option>KOD</option><option>KOG</option><option>KOH</option><option>KORT</option><option>KTClan</option><option>Kabans</option><option>KamikadzE</option><option>Kazaki</option><option>KeepersOfSevSphears</option><option>KeepersOfTheBalance</option><option>KeepersOfVictory</option><option>KeepersofHeaven</option><option>KiA</option><option>KillerClan</option><option>Kings</option><option>KlanWolf</option><option>Knights</option><option>KnightsLight</option><option>KnightsOfDarkness</option><option>KnightsOfFire</option><option>KnightsOfIce</option><option>KnightsOfTheOldCode</option><option>KoDG</option><option>KoS</option><option>KoV</option><option>Kofs</option><option>LKeepers</option><option>LOF</option><option>LORDS</option><option>LaSombra</option><option>LadiesClub</option><option>LastLegion</option><option>Lawyers</option><option>LegacyOfKain</option><option>LegioFlavia</option><option>LightLigtning</option><option>Lilania</option><option>Limb</option><option>LinD</option><option>Lions</option><option>Lirika</option><option>LivonicOrder</option><option>LoA</option><option>LoD</option><option>LoU</option><option>LongRecruits</option><option>Longriders</option><option>LostParadise</option><option>LuN</option><option>LuckyGentelmen</option><option>MADS</option><option>MBK</option><option>MCats</option><option>MIB</option><option>MOD</option><option>MTSV</option><option>MWR</option><option>MadHamsters</option><option>MaddY</option><option>Malkavians</option><option>Maniacs</option><option>Maverick</option><option>MercatorLiber</option><option>Mercenaries</option><option>MiceOfTheMurderer</option><option>MiddleDragons</option><option>MoonDancers</option><option>MoonKnights</option><option>MoonShadows</option><option>MoonWorkers</option><option>Mooneyes</option><option>Morgenshtern</option><option>Mortals</option><option>MountainBrotherhood</option><option>Murders</option><option>Mysty</option><option>NBS</option><option>NDevils</option><option>NUnion</option><option>NWO</option><option>Navigators</option><option>NavySEALs</option><option>NeA</option><option>Nekromants</option><option>NeutralStalkers</option><option>NeverSayNever</option><option>NewK</option><option>NewKrovatka</option><option>NewYankees</option><option>NightBlades</option><option>NightFighters</option><option>NightJudges</option><option>NightLanding</option><option>NightStrangers</option><option>Nightmare</option><option>NightmareFighters</option><option>Nights</option><option>Ninja</option><option>NoLg</option><option>NoNames</option><option>NovgorodRetinue</option><option>OIG</option><option>OKO</option><option>ONYX</option><option>OSK</option><option>OldBaku</option><option>Olymp</option><option>Orda</option><option>OrdenOfDruids</option><option>OrdenOfKayenitKnights</option><option>OrderOfTemplers</option><option>OrderOfWildLynx</option><option>OrderPilgrims</option><option>Ortodox</option><option>Others</option><option>PANDEMONIUM</option><option>PAP</option><option>PIVO</option><option>PPil</option><option>Padonki</option><option>Panic</option><option>PathToNowhere</option><option>Patriots</option><option>Peacekeepers</option><option>PeopleofDragon</option><option>PhantomsOfTime</option><option>PiratesofBK</option><option>PoDG</option><option>Pozitiv</option><option>Preatorians</option><option>Prec</option><option>RBC</option><option>RCOH</option><option>RDM</option><option>RFH</option><option>RFaction</option><option>RIP</option><option>RISE</option><option>ROTD</option><option>RSR</option><option>RWBoys</option><option>RaF</option><option>Raidofdark</option><option>RainingBlood</option><option>Reality</option><option>RebelS</option><option>Recruits</option><option>RecruitsAH</option><option>RecruitsAdepts</option><option>RecruitsBOR</option><option>RecruitsBlackCo</option><option>RecruitsBrigada</option><option>RecruitsFallenAngels</option><option>RecruitsHaiducii</option><option>RecruitsMIB</option><option>RecruitsMercenaries</option><option>RecruitsSB</option><option>RecruitsSiberia</option><option>RecruitsWH</option><option>RedinarD</option><option>RedinarDKadets</option><option>RedinarDRecruits</option><option>Reignofdark</option><option>Renaissance</option><option>ReoFi</option><option>Requiem</option><option>ResidentForce</option><option>Resurrected</option><option>Revivedagain</option><option>Revolt</option><option>RisenFromFire</option><option>Rising</option><option>Ritter</option><option>RoD</option><option>RoF</option><option>RogatyeTrupoedy</option><option>Rohan</option><option>Romantic</option><option>RoyalForce</option><option>Rus</option><option>SBW</option><option>SCR</option><option>SDA</option><option>SDeath</option><option>SHaiducii</option><option>SITO</option><option>SPB</option><option>SPoAN</option><option>SUN</option><option>SacredInquisition</option><option>SaintBrotherS</option><option>Saints</option><option>Samuraj</option><option>SanctumSanctorum</option><option>ScorpionS</option><option>SeaWolfs</option><option>Seaclan</option><option>Searchers</option><option>SecondReality</option><option>Sensey</option><option>SeriousDamageBringers</option><option>Seven</option><option>Shaolin</option><option>Sharks</option><option>Shk</option><option>ShockWave</option><option>SiB</option><option>Siberia</option><option>SilentDale</option><option>SkullsTS</option><option>SkyDragons</option><option>SlavSpas</option><option>Slayers</option><option>SlySnakes</option><option>Smol</option><option>SnakeS</option><option>SoD</option><option>SoR</option><option>SoT</option><option>SonicEmpire</option><option>SotD</option><option>SoulKeepers</option><option>SoulReavers</option><option>SouthBrotherhood</option><option>SpaceBrotherS</option><option>SpartakFC</option><option>Speedfire</option><option>SpiritOfTiGer</option><option>Spirits</option><option>SpiritsOfDestiny</option><option>StD</option><option>Stalkers</option><option>StarW</option><option>StaunchAlly</option><option>SteelD</option><option>SteelHearts</option><option>SteelKnights</option><option>StreetFighters</option><option>SuiciderS</option><option>Swakhop</option><option>TANKS</option><option>TBR</option><option>TDB</option><option>THC</option><option>TIK</option><option>TRIOclan</option><option>TSW</option><option>TTF</option><option>Tampliers</option><option>Team</option><option>TemnayaDrujina</option><option>Templars</option><option>Teneviki</option><option>Terrans</option><option>Terrible</option><option>TeutonicOrder</option><option>ThD</option><option>TheDodgers</option><option>TheLegacy</option><option>TheLordOfTheRings</option><option>TheThing</option><option>TheTimeWarriors</option><option>TheUndead</option><option>TheWheelOfTime</option><option>ThugzMansion</option><option>TibetMonks</option><option>TimeKnights</option><option>Timekillers</option><option>Tirrow</option><option>TloJackals</option><option>Totenkopf</option><option>TradeAndGames</option><option>Tremere</option><option>TriAda</option><option>Tushkans</option><option>TwilightKnights</option><option>TwilightPatrol</option><option>UknownHeroes</option><option>Ukr</option><option>UltimateSkaters</option><option>UnRe</option><option>UnSeen</option><option>UnT</option><option>Undefeated</option><option>UndergroundShadows</option><option>Undertakers</option><option>Underworld</option><option>UnknownClan</option><option>VIP</option><option>VKL</option><option>VampireS</option><option>Vampirehell</option><option>VendettA</option><option>VeniVediVici</option><option>VersuS</option><option>Virgo</option><option>VoF</option><option>VoiskoDonskoe</option><option>VolnaiDruzhina</option><option>Volnye</option><option>VrangelWarriors</option><option>WBR</option><option>WBoys</option><option>WIN</option><option>WISH</option><option>WMD</option><option>WRGuard</option><option>WTBclan</option><option>WWJuniors</option><option>WaM</option><option>Wanderers</option><option>Warbears</option><option>Warmakers</option><option>Warriors</option><option>WarriorsOfHonor</option><option>WarriorsOfLight</option><option>WarriorsOfVirtue</option><option>WarriorsoftheMind</option><option>WaterCrow</option><option>Werewolf</option><option>WesternBrotherhood</option><option>WheelWarriors</option><option>WhiteKnights</option><option>WhiteLions</option><option>Wild</option><option>WildHearts</option><option>WildPlain</option><option>Winterfell</option><option>Wizards</option><option>WoD</option><option>WoF</option><option>WoJ</option><option>WoV</option><option>WolvesofOdin</option><option>WomeNsLegion</option><option>WordClan</option><option>WorldElfs</option><option>WuTangClan</option><option>WuTangRecruits</option><option>XXIUnicorn</option><option>XXIUnipony</option><option>XxX</option><option>Yakudza</option><option>ZENIT</option><option>Zeitgeist</option><option>ZoDiak</option><option>ZthLegion</option><option>abk</option><option>adminion</option><option>alkahest</option><option>aton</option><option>bloodhearts</option><option>boanarchy</option><option>borw</option><option>darkjudges</option><option>darkvirus</option><option>deathknights</option><option>desperate</option><option>drunkpunks</option><option>evial</option><option>fctrade</option><option>firefeniks</option><option>hdn</option><option>izbrannie</option><option>koblood</option><option>legion</option><option>legionsumraka</option><option>lostsouls</option><option>lucifiers</option><option>nachtschatten</option><option>newtime</option><option>paxromana</option><option>qualitative</option><option>rMalks</option><option>radminion</option><option>renegades</option><option>rockers</option><option>sacred</option><option>screamofdeath</option><option>scythians</option><option>skomorokh</option><option>skull</option><option>stonelotus</option><option>storm</option><option>tirones</option><option>tramps</option><option>tribunal</option><option>urukhai</option><option>vKOD</option><option>vsL</option><option>whiteguards</option><option>whiteston</option></SELECT></td></tr>';
}
s += '<tr><td colspan=2 align=center><input type=submit value="Подать заявку"></td></tr></table></form>';
wnd = top.wnd = top.CheckDialogsDiv();
s = crtmagic(0, "Создание " + (is_alliance ? "альянса" : "союза"), s);
wnd.innerHTML = s;
wnd.style.visibility = "visible";
wnd.style.left = 100;
wnd.style.zIndex = 200;
wnd.style.top = document.body.scrollTop+50;
}
function JoinUnion() {
var s = '<form><input type=hidden name="action" value="joinunion"> \
<table width=100% width=340> \
<tr><td nowrap>Выберите союз:</td><td><select name=UnionKlan>';

s += '<option value="Цитадель Тьмы">Цитадель Тьмы</option>';

s += '<option value="союз Атона">союз Атона</option>';

s += '<option value="Союз BWB">Союз BWB</option>';

s += '<option value="союз Brothers">союз Brothers</option>';

s += '<option value="Орден Tremere">Орден Tremere</option>';

s += '<option value="Истинных нейтралов">Истинных нейтралов</option>';

s += '<option value="Empires 911">Empires 911</option>';

s += '<option value="Союз мерков">Союз мерков</option>';

s += '<option value="Нейтральный союз">Нейтральный союз</option>';
s += '</select></td></tr> \
<tr><td colspan=2 align=center><input type=submit value="Подать заявку"></td></tr></table></form>';
wnd = top.wnd = top.CheckDialogsDiv();
s = crtmagic(0, "Присоединиться к союзу", s);
wnd.innerHTML = s;
wnd.style.visibility = "visible";
wnd.style.left = 100;
wnd.style.zIndex = 200;
wnd.style.top = document.body.scrollTop+50;
}
function JoinAlliance() {
var s = '<form><input type=hidden name="action" value="joinalliance"><table width=100% width=340>';
s += '<tr><td align=center>нет доступных альянсов</td></tr></table></form>';
wnd = top.wnd = top.CheckDialogsDiv();
s = crtmagic(0, "Присоединиться к альянсу", s);
wnd.innerHTML = s;
wnd.style.visibility = "visible";
wnd.style.left = 100;
wnd.style.zIndex = 200;
wnd.style.top = document.body.scrollTop+50;
}
</SCRIPT>
<? if($polno[$user['id']][12]==1){ ?>

<tr>
<td>
<input type="button" value="Создать союз" onclick="AddUnion()">
<input type="button" value="Присоединиться к союзу" onclick="JoinUnion()">
&nbsp;
<input type="button" value="Присоединиться к альянсу" onclick="JoinAlliance()">
<input type="button" value="Создать альянс" onclick="AddUnion(1)">
</td>
</tr>
<?}?>
<TR>
<TD style='padding: 5;'>
<br><center>В данный момент у вашего клана нет дипломатических отношений.</center></br>
</TD>
</TR>
<tr><td align=center>Заявки на союзы</td></tr>
<tr valign=top>
<td style="padding: 2;">
<table width=100% cellpadding=2 cellspacing=2 border=1>
<tr valign=top>
<td width=50% style='border: 1px solid #cccccc;'>
<center><b>Ваши заявки на установление союза</b></center>
<br><center>Вы ни с кем не подавали заявки</center><br>
</td>
<td width=50% style='border: 1px solid #cccccc;'>
<center><b>Заявки на установление союза с вами</b></center>
<br><center>С Вами никто не подавал заявки</center><br>
</td>
</tr>
</table>
</td>
</tr>
<tr><td align=center>Заявки на альянсы</td></tr>
<tr valign=top>
<td style="padding: 2;">
<table width=100% cellpadding=2 cellspacing=2 border=1>
<tr valign=top>
<td width=50% style='border: 1px solid #cccccc;'>
<center><b>Ваши заявки на установление альянса</b></center>
<br><center>Вы ни с кем не подавали заявки</center><br>
</td>
<td width=50% style='border: 1px solid #cccccc;'>
<center><b>Заявки на установление альянса с вами</b></center>
<br><center>С Вами никто не подавал заявки</center><br>
</td>
</tr>
</table>
</td>
</tr>
</table>
<br>
</FIELDSET>
<?}?>
<BR>
</div>

<div class=dtz ID=dTZ13>
<FIELDSET><LEGEND><H4>Имущество клана</H4></LEGEND>
<table cellspacing=0 cellpadding=2 border=0 width="100%">
<tr>
<td nowrap width="20%">
<?
  if (@$takebackreport) err($takebackreport);
  if ($klan["glava"]==$user['id']) {
    //$r=mq("select * from inventory where clan='$user[klan]' and id not in (select id_it from clanstorage where klan='$user[klan]')");
    $r=mq("select * from clanstorage where klan='$user[klan]' and taken>0 order by id desc");
    echo '<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#c5c5c5">
    <tr>';
    $i=0;
    while($rec1=mysql_fetch_array($r)) {
      $i++;
      $rec=unserialize($rec1["item"]);
      $rec['count'] = 1;
      if ($i%2==0) { $color = '#C7C7C7';} else { $color = '#D5D5D5'; }
      echo "<TD align=center width=20%><IMG SRC=\"".IMGBASE."/i/sh/{$rec['img']}\" BORDER=0>
      <BR><small> Владелец:<BR> ".clannick3($rec1['taken'])." <BR></small>
      <a href=\"klan1.php?takeback=$rec[id]\">Забрать</a>";
      echo "</TD>";
      /*echo "<TD valign=top>";
      showitem($rec);
      echo "</TD></TR>";*/
      $i++;
      if ($i%5==0) echo "</tr><tr><td>&nbsp;</td></tr><tr>";
    }
    echo "</tr></TABLE>";
  }
?>
</td>
</tr>
</table>
</FIELDSET>
</div>
<div class=dtz ID=dTZ14>
<FIELDSET><LEGEND><H4><?
if ($user["in_tower"]==1 || $user["in_tower"]==71) echo "Во время турнира Башни Смерти клановая панель недоступна.";
elseif ($user["in_tower"]) echo "В Пещере кристаллов клановая панель недоступна.";
else echo "События";
?></H4></LEGEND>
<?if($polno[$user['id']][1]==1){?>
<TABLE width="100%" cellpadding=0 cellspacing=0 border=0>
<TR valign=top>
<TD align=left  width="80%">

<STYLE>
.event td {border: 1px solid #BBBBBB; padding: 3;}
.calend {font-family : Verdana; font-size : 11px; color : #000000; line-height: 17px; }
a.day {text-decoration: underline; font-weight: normal;}
</STYLE>
<SCRIPT>
function Edit(id) {
document.getElementById('new_event').style.display = 'none';
var X = event.clientX + document.body.scrollLeft;
var Y = event.clientY + document.body.scrollTop;
document.getElementById('edit_event_header').value =
Unprepare(document.getElementById('h' + id).innerHTML);
var txt = document.getElementById('e' + id).innerHTML;
var re = new RegExp("<div>.*?</div>", "gi");
txt = Unprepare(txt.replace(re, ""));
txt = Unprepare(txt.replace(/<BR>/gi, "\n"));
var doc = document.getElementById('edit_event_text');
doc.style.top = Y;
doc.style.left = X;
doc.value = txt;
var table = document.getElementById('edit_event');
table.style.top = Y;
table.style.left = X + 20;
table.style.display = 'block';
document.getElementById('ts').value = id;
}
</SCRIPT>
<table cellspacing=0 cellpadding=2 border=0 width=460 id="edit_event" style="display: none; border: 1px solid #999999; position: absolute; z-index: 100; background: e2e0e0; margin-left: -10;">
<tr><td align=center width=460><b>Редактировать событие</b></td><td width=13 align=right><img src="<?=IMGBASE?>/i/clear.gif" alt="Закрыть" onmouseover="this.style.cursor = 'hand';" onclick="document.getElementById('edit_event').style.display = 'none'"></td></tr>
<tr>
<td colspan="2">
<FORM id=editevent action=klan1.php name=editevent method=POST>
<input type=hidden name=edit_event value=1>
<input type=hidden name=ts value="" id="ts">
<table width='100%' border=0>
<tr>
<td width='120'>Заголовок:</td>
<td><input style='width: 340px;' type=text name=event_header value='' id='edit_event_header' maxlength=200></td>
</tr>
<tr>
<td width='120'>Текст:<br><font size=1>(не более 600 символов)</font></td>
<td><textarea name=event_text style='width: 340px; height: 140px;' id="edit_event_text"></textarea></td>
</tr>
<tr>
<td align=center colspan="2"><input type=button value='Сохранить' onclick='AddEvent(1)'></td>
</tr>
</table>
</FORM>
</td>
</tr>
</table>
<table border=0 width="100%">
<tr>
<td style='padding: 0 5 0 5;' align=right>


<?




        if($_POST['edit_event']==1 && $_POST['event_header'] && $_POST['event_text'] && $polno[$user['id']][13]==1) {
$_POST['event_header']=htmlspecialchars($_POST['event_header']);
$_POST['event_text']=htmlspecialchars($_POST['event_text']);
$_POST['event_text']=str_replace("\\n","<BR>",$_POST['event_text']);
if(preg_match("/__/",$_POST['event_header']) || preg_match("/--/",$_POST['event_header']))
{
echo"В заголовке не должно присутствовать подряд более 1 символа '_' или '-'.";
}elseif(preg_match("/__/",$_POST['event_text']) || preg_match("/--/",$_POST['event_text'])){
echo"В тексте события не должно присутствовать подряд более 1 символа '_' или '-'.";
}else{
if(is_numeric($_POST['ts'])){
$_POST['event_text']=$_POST['event_text']."<div><br><br><font color=red><i>".date('d.m.y H:i')." Событие отредактировано</i></font> ".clannick3($_SESSION['uid'])."</div>";
mq("update clanevents set `title`= '".$_POST['event_header']."',`text`= '".$_POST['event_text']."' WHERE id='".$_POST['ts']."'");

echo "<p align=left><font color=red>Событие отредактировано.</font></p>";
}
}
        }

        if($_POST['add_event']==1 && $_POST['event_header'] && $_POST['event_text'] && $polno[$user['id']][2]==1) {
$_POST['event_header']=htmlspecialchars($_POST['event_header']);
$_POST['event_text']=htmlspecialchars($_POST['event_text']);
$_POST['event_text']=str_replace("\\n","<BR>",$_POST['event_text']);
if(preg_match("/__/",$_POST['event_header']) || preg_match("/--/",$_POST['event_header']))
{
echo"В заголовке не должно присутствовать подряд более 1 символа '_' или '-'.";
}elseif(preg_match("/__/",$_POST['event_text']) || preg_match("/--/",$_POST['event_text'])){
echo"В тексте события не должно присутствовать подряд более 1 символа '_' или '-'.";
}else{
    mq("INSERT INTO `clanevents` (`title`, `text`,`owner`,`klan`)VALUES ('".$_POST['event_header']."', '".$_POST['event_text']."', '".$_SESSION['uid']."', '".$user['klan']."');");
echo "<p align=left><font color=red>Событие добавлено.</font></p>";
}
        }

        if($_GET['action']=='del' && is_numeric($_GET['id']) && $polno[$user['id']][13]==1) {
mq("DELETE FROM `clanevents` WHERE `id`='{$_GET['id']}'");
echo "<p align=left><font color=red>Событие удалено.</font></p>";

        }









if(is_numeric($_GET['page'])){

$numb=round($_GET['page']*10, 0);
}
else{

$numb=0;

}
if($_SESSION['uid']==-7){

                $datas = mq("SELECT short FROM `clans`;");
                while($its = mysql_fetch_array($datas)) {
echo"<A HREF=\"/klan1.php?klanm=".$its['short']."\"><img src=\"".IMGBASE."/i/klan/".$its['short'].".gif\" title=".$its['short']." width=24 height=15></A> ";

if($_GET['klanm']){
$_GET['klanm'] = addslashes($_GET['klanm']);
$klanm=$_GET['klanm'];
}else{
$klanm=$user['klan'];
}           }

}else{$klanm=$user['klan'];}

                $data = mq("SELECT * FROM `clanevents` WHERE `klan`= '".$klanm."' ORDER BY date DESC LIMIT $numb, 10");


                while($it = mysql_fetch_array($data)) {
                echo '<table width=100% border=1 cellpadding=0 cellspacing=0 class=event style=\'margin: 0 0 20 0;\'>';

echo"<tr valign=middle>
<td width='150' nowrap style='border-right: 0; border-bottom: 0; padding: 0 0 0 5;' bgcolor=\"#c8c7c3\"><em>$it[date]</em></td>
<td align=left width=\"70%\" style='border-left: 0; border-right: 0; border-bottom: 0;' bgcolor=\"#c8c7c3\"><strong id=\"h$it[id]\">$it[title]</strong></td>
<td align=right nowrap bgcolor=\"#c8c7c3\" style='border-left: 0; border-bottom: 0;' width=\"20%\">";
echo clannick3($it[owner]); echo"</td>
</tr>
<tr valign=top>
<td colspan=3 style='padding: 5; margin: 5' bgcolor=\"#e9e8e6\">
<table style='float: left; margin: 5 5 0 0;' cellspacing=3>";
if($polno[$user['id']][13]==1 && $klanm==$user['klan']){
echo"<tr><td><img src=\"".IMGBASE."/i/news.gif?2\" alt=\"Редактировать\" onmouseover=\"this.style.cursor = 'hand';\" onclick=\"Edit($it[id])\"></td></tr>
<tr><td><img src=\"".IMGBASE."/i/clear.gif\" alt=\"удалить\" onmouseover=\"this.style.cursor = 'hand';\" onclick=\"if (confirm('Вы действительно хотите удалить эту запись?')) {document.location = 'klan1.php?action=del&id=$it[id]'}\"></td></tr>";
}
echo"</table>
<div style=\"padding: 0; margin: 0;\" id=\"e$it[id]\">$it[text]</div>
</td>
</tr>
</table>
";
                }










echo "Страницы: ";
$data2 = mq("SELECT * FROM `clanevents` WHERE `klan`= '{$klanm}';");

if($_GET['klanm']){$koko="&klanm=".$klanm;}
    $all = mysql_num_rows($data2)-1;
    $pgs = $all/10;
    for ($i=0;$i<=$pgs;++$i) {
        if ($_GET['page']==$i) {
            echo '<font class=number>',($i+1),'</font>&nbsp;';
        }
        else {
            echo '<a href="?page=',$i,'',$koko,'">',($i+1),'</a>&nbsp;';
        }
    }


?>






</td>
</tr>
</table>
</TD>
<TD align=center width="20%" style='padding: 0 5 0 0;'>
<?if($polno[$user['id']][2]==1){?>
<table><tr><td align=right><input type=button name="add_event" value="Добавить событие" onclick="if (document.getElementById('new_event').style.display!='block') { if (document.getElementById('edit_event')) { document.getElementById('edit_event').style.display = 'none'; } document.getElementById('new_event').style.display = 'block'; }" ></td></tr></table>
<?}?>
<table cellspacing=0 cellpadding=2 border=0 width=460 id="new_event" style="display: none; border: 1px solid #999999; position: absolute; z-index: 100; background: e2e0e0; margin-left: -460;">
<tr><td align=center width=460><b>Новое событие</b></td><td width=13 align=right><img src="<?=IMGBASE?>/i/clear.gif" alt="Закрыть" onmouseover="this.style.cursor = 'hand';" onclick="document.getElementById('new_event').style.display = 'none'"></td></tr>
<tr>
<td colspan="2">
<FORM id=addevent action=klan1.php name=addevent method=POST>
<input type=hidden name=add_event value=1>
<table width='100%' border=0>
<tr>
<td width='120'>Заголовок:</td>
<td><input style='width: 340px;' type=text name=event_header value='' id='add_event_header' maxlength=200></td>
</tr>
<tr>
<td width='120'>Текст:<br><font size=1>(не более 600 символов)</font></td>
<td><textarea name=event_text style='width: 340px; height: 140px;' id="add_event_text"></textarea></td>
</tr>
<tr>
<td align=center colspan="2"><input type=button value='Добавить событие' onclick='AddEvent(0)'></td>
</tr>
</table>
</FORM>
</td>
</tr>
</table>
<br>


<SCRIPT>
function ShowCalendar(url, obj, obj) {
}
</SCRIPT>

<DIV id="cal_obj">

 <?php


if($_GET['data'] && $_GET['data']<13 && $_GET['data']>0){
$sl=$_GET['data']+1;
$pre=$_GET['data']-1;

$m=$_GET['data'];
}else{
$sl=date('m')+1;
$pre=date('m')-1;
$m = date('m');
}
$Y = date('Y');
$var_date = mktime(0, 0, 0, $m, 1, $Y);

switch ($m){
    case 1: $mm='январь'; break;
    case 2: $mm='февраль'; break;
    case 3: $mm='март'; break;
    case 4: $mm='апрель'; break;
    case 5: $mm='май'; break;
    case 6: $mm='июнь'; break;
    case 7: $mm='июль'; break;
    case 8: $mm='август'; break;
    case 9: $mm='сентябрь'; break;
    case 10: $mm='октябрь'; break;
    case 11: $mm='ноябрь'; break;
    case 12: $mm='декабрь'; break;
    }

  $dayofmonth = date('t',$var_date);

  // Счётчик для дней месяца

  $day_count = 1;



  // 1. Первая неделя

  $num = 0;

  for($i = 0; $i < 7; $i++)

  {

    // Вычисляем номер дня недели для числа

    $dayofweek = date('w',

                      mktime(0, 0, 0, $m, $day_count, $Y));

    // Приводим к числа к формату 1 - понедельник, ..., 6 - суббота

    $dayofweek = $dayofweek - 1;

    if($dayofweek == -1) $dayofweek = 6;



    if($dayofweek == $i)

    {

      // Если дни недели совпадают,

      // заполняем массив $week

      // числами месяца

      $week[$num][$i] = $day_count;

      $day_count++;

    }

    else

    {

      $week[$num][$i] = "";

    }

  }



  // 2. Последующие недели месяца

  while(true)

  {

    $num++;

    for($i = 0; $i < 7; $i++)

    {

      $week[$num][$i] = $day_count;

      $day_count++;

      // Если достигли конца месяца - выходим

      // из цикла

      if($day_count > $dayofmonth) break;

    }

    // Если достигли конца месяца - выходим

    // из цикла

    if($day_count > $dayofmonth) break;

  }

if($pre<=0){$strel="&laquo;";}else{
$strel="<a href=\"/klan1.php?data=".$pre."\" class=\"usermenu\">&laquo;</A>";
}
if($sl>=13){$strel2="&raquo;";}else{
$strel2="<a href=\"klan1.php?data=".$sl."\" class=\"usermenu\">&raquo;</A>";
}
?>
<TABLE width="163" border="0" align="center" cellPadding="2" cellSpacing="2">
<TR>
<TD align="center" bgcolor="#e6e2c8" class="usermenu"><?=$strel?></TD>
<TD colSpan="5" align="center" bgcolor="#e6e2c8" class="usermenu"><?=date('Y')?> <?=$mm?></TD>
<TD align="center" bgcolor="#e6e2c8" class="usermenu"><?=$strel2?></TD>
</TR>
<TR>
<TD bgcolor="#F8F3E0" class="calend"><strong>Пн</strong></TD>
<TD bgcolor="#F8F3E0" class="calend"><strong>Вт</strong></TD>
<TD bgcolor="#F8F3E0" class="calend"><strong>Ср</strong></TD>
<TD bgcolor="#F8F3E0" class="calend"><strong>Чт</strong></TD>
<TD bgcolor="#F8F3E0" class="calend"><strong>Пт</strong></TD>
<TD bgcolor="#F8F3E0" class="calend"><strong>Сб</strong></TD>
<TD bgcolor="#F8F3E0" class="calend"><strong>Вс</strong></TD>
</TR>
<?
  for($i = 0; $i < count($week); $i++)

  {

    echo "<tr>";

    for($j = 0; $j < 7; $j++)

    {

      if(!empty($week[$i][$j]))

      {

        // Если имеем дело с субботой и воскресенья

        // подсвечиваем их
        if($j == 5 || $j == 6){
if (date('d')==$week[$i][$j] && date('m')==$m){$week[$i][$j]="<a href=\"/klan1.php?data=1278115963&action=view\" style='text-decoration: underline; font-weight: normal; color: red;'>".$week[$i][$j]."</a>";}
             echo "<td><font color=red>".$week[$i][$j]."</font></td>";

        }else{
if (date('d')==$week[$i][$j] && date('m')==$m){$week[$i][$j]="<a href=\"/klan1.php?data=1278115963&action=view\" style='text-decoration: underline; font-weight: normal; color: black;'>".$week[$i][$j]."</a>";}
echo "<td>".$week[$i][$j]."</td>";
         }
      }

      else echo "<td>&nbsp;</td>";

    }

    echo "</tr>";

  }

  echo "</table>";

?>
</DIV>

</TD>
</TR>
</TABLE>
<br>
</FIELDSET>
<?}elseif (!$user["in_tower"]) echo'Недостаточно прав для просмотра событий';?>
</div>
<div class=dtz ID=dTZ18>
<FIELDSET><LEGEND><H4>Ваши права в клане</H4></LEGEND>
<? //echo'Ваш титул в клане: <img src="/i/klan/'.$user['klan'].'.gif"> <b style=\'color: black;\'>Маджахеды-смертники идут на барикады!!!111</b> <br>';
?>
<br>У Вас есть следующие возможности:
<ul>
<?





if($polno[$user['id']][0]==1){

echo"<li>Редактирование прав участников в клане</li>";

}
if($polno[$user['id']][1]==1){

echo"<li>Просмотр событий клана</li>";

}
if($polno[$user['id']][2]==1){

echo"<li>Создание событий клана</li>";

}
if($polno[$user['id']][13]==1){

echo"<li>Редактирование событий клана</li>";

}
if($polno[$user['id']][3]==1){

echo"<li>Просмотр хранилища</li>";

}
if($polno[$user['id']][4]==1){

echo"<li>Использование вещей из хранилища</li>";

}
if($polno[$user['id']][5]==1){

echo"<li>Просмотр казны и списка игроков, пополнявших казну</li>";

}
if($polno[$user['id']][6]==1){

echo"<li>Пополнение казны</li>";

}
if($polno[$user['id']][7]==1){

echo"<li>Использование казны</li>";

}
if($polno[$user['id']][8]==1){

echo"<li>Клановые союзы и альянсы</li>";

}
if($polno[$user['id']][9]==1){

echo"<li>Прием в клан</li>";

}
if($polno[$user['id']][10]==1){

echo"<li>Изгнание из клана</li>";

}
if($polno[$user['id']][11]==1){

echo"<li>Редактирование информации о клане</li>";

}
if($polno[$user['id']][12]==1){

echo"<li>Управление союзами и альянсами</li>";

}


?>






























</ul>
</FIELDSET>
</div>
<div class=dtz ID=dTZ15>
<FIELDSET><LEGEND><H4>Информация о клане на клановой странице</H4></LEGEND>
<TABLE width="100%" cellpadding=2 cellspacing=2 border=0>
<TR valign=top>
<TD WIDTH=50%>
<TABLE>

<TR>
<TD align=left  width="200">Знак клана:</TD>
<TD><IMG SRC="<?=IMGBASE?>/i/klan/<?=$klan['short']?>.gif" style='margin:0;'></TD>
</TR>

<TR>
<TD align=left  width="200">Уровень клана:</TD>
<TD><?=$klan['clanlevel']?></TD>
</TR>
<TR>
<TD align=left  width="200">Рейтинг:</TD>
<TD><B><?=$klan['clanreit']?></B></TD>
</TR>
<TR>
<TD align=left width="200" valign=top>Клановый опыт:</TD>
<TD>
<SCRIPT>
le=120;
<?$x=$klanexptable;
$x=array_keys($x);
$x=$x[$klan['clanlevel']];
$rznost=floor($klan['clanexp']-$x);
$rznost2=floor($klan['needexp']-$x);
$procy=floor($rznost/($rznost2/100));?>
//  var sz1 = Math.round( ( le/) * <?=$klan['needexp']?> );
var sz1 = Math.round( (le * <?=$procy?>)/100);
if (sz1 > le) sz1 = le;
var sz2 = le - sz1;
document.write('<table><tr valign=middle><td nowrap style="font-size:9px" style="position: relative; vertical-align: middle;" valign=middle height=11 align=center><div style="position: absolute; top: 1; left: 5; z-index: 1; font-weight: bold; color: #FFFFFF; width: 120px; text-align: center; font-size:9px"><?=$klan['clanexp']?> (<?=$procy?>%)</div><img id="QSmr1" src="<?=IMGBASE?>/i/misc/bk_life_yellow.gif" alt="Набрано опыта: <?=$procy?>%" width="'+sz1+'px" height="10"><img id="QSmr2" src="<?=IMGBASE?>/i/misc/bk_life_loose.gif" alt="Набрано опыта: <?=$procy?>%" width="'+sz2+'" height="10"><span style="width:1px; height:10px"></span></td></tr></table>');
if ( document.all('QSmr1') )
document.all('QSmr1').width=sz1;
if ( document.all('QSmr2') )
document.all('QSmr2').width=sz2;
</SCRIPT>
</TD>
</TR>
<TR>
<TD align=left  width="200">Тип управления:</TD>
<?
if ($klan['clandem']==0) {
echo'<TD><B>неизвестно</B>';
}elseif ($klan['clandem']==1) {
echo'<TD><B>Анархия</B></TD>';
}elseif ($klan['clandem']==2) {
echo'<TD><B>Монархия</B></TD>';
}elseif ($klan['clandem']==3) {
echo'<TD><B>Диктатура</B></TD>';
}elseif ($klan['clandem']==4) {
echo'<TD><B>Демократия</B></TD>';
}
?>
</TR>
<TR>
<TD align=left  width="200">Страница клана:</TD>
<TD><a href="/claninf.php?<?=$klan['name']?>" target="_blank"><?=$klan['name']?></a></TD>
</TR>
<TR>
<TD align=left  width="200">О клане:</TD>
<TD>
<?
if($polno[$user['id']][11]==1){

if($_POST['about_clan'])
{
$_POST['about_clan']=htmlspecialchars($_POST['about_clan']);
$_POST['about_clan']=str_replace("\\n","<BR>",$_POST['about_clan']);
if(preg_match("/__/",$_POST['about_clan']) || preg_match("/--/",$_POST['about_clan']))
{
echo"В тексте не должно присутствовать подряд более 1 символа '_' или '-'.";
}else{
mq("update `clans` set `descr` = '".$_POST['about_clan']."' WHERE `id` = '".$klan['id']."';");
$klan['descr']=$_POST['about_clan'];
echo "<script>setTZ('TZ15', 1)</script><div align=left><font color=red>Информация обновлена.</font></div>";
}
}
?>
<FORM action=klan1.php name=about method=POST>
<textarea id="about_clan" name="about_clan" cols=50 rows=10><?=$klan['descr']?></textarea><br>
<input type=button value="Записать" onclick="document.forms.about.submit();">
<SCRIPT>document.getElementById("about_clan").value = document.getElementById("about_clan").value.replace(/<br>/gi, "\n\r");</SCRIPT>
</FORM>
<?}else{?>
<?=$klan['descr']?>
<?}?>
</TD>
</TR>
</TABLE>
</TD>
<TD WIDTH=50%>
<table>
<tr valign=top>
<td style='padding: 0 10 0 0;'>Статистика кланового опыта: </td>
<td>
<table cellpadding=0 cellspacing=0>
<tr style='margin-bottom: 5;'><td>&bull; За сегодня:</td><td align=right> <b><?=$klan["clanexp"]-$klan["dayexp"]?></b></td></tr>
<tr><td>&bull; За неделю:</td><td align=right> <b><?=$klan["clanexp"]-$klan["weekexp"]?></b></td></tr>
<tr><td>&bull; За месяц:</td><td align=right> <b><?=$klan["clanexp"]-$klan["monthexp"]?></b></td></tr>
</table>
</td>
</tr>
</table>

<STYLE>
.TExp {border: 1px solid black; border-bottom: 0;}
.TExp td {border-bottom: 1px solid black; text-align: center;}
.TExp td.header {font-size: 11px; font-weight: bold; padding: 4; border-right: 1px solid black; width: 11%; background: #cccccc;}
</STYLE>
<TABLE cellpadding=3 cellspacing=0 class=TExp>
<TR class=heade>
<TD class=header>Уровень</TD>
<TD class=header>Игроки</TD>
<TD class=header>Союз</TD>
<TD class=header>Создать<br>союз</TD>
<TD class=header>Альянс</TD>
<TD class=header>Создать<br>альянс</TD>
<TD class=header>Хранилище</TD>
<TD class=header>Передач<br>на игрока</TD>
<TD class=header>Передач<br>всего</TD>
</TR>
<? if ($klan['clanlevel']==0) {
echo"<TR style='background: #92D050;'>";
}else{
echo"<TR >";}
?>
<TD>0</TD>
<TD>8</TD>
<TD>Нет</TD>
<TD>Нет</TD>
<TD>Нет</TD>
<TD>Нет</TD>
<TD>50</TD>
<TD>20</TD>
<TD>200</TD>
</TR>
<? if ($klan['clanlevel']==1) {
echo"<TR style='background: #92D050;'>";
}else{
echo"<TR >";}
?>
<TD>1</TD>
<TD>12</TD>
<TD>Да</TD>
<TD>Нет</TD>
<TD>Нет</TD>
<TD>Нет</TD>
<TD>50</TD>
<TD>20</TD>
<TD>200</TD>
</TR>
<? if ($klan['clanlevel']==2) {
echo"<TR style='background: #92D050;'>";
}else{
echo"<TR >";}
?>
<TD>2</TD>
<TD>16</TD>
<TD>Да</TD>
<TD>Нет</TD>
<TD>Нет</TD>
<TD>Нет</TD>
<TD>50</TD>
<TD>20</TD>
<TD>200</TD>
</TR>
<? if ($klan['clanlevel']==3) {
echo"<TR style='background: #92D050;'>";
}else{
echo"<TR >";}
?>
<TD>3</TD>
<TD>20</TD>
<TD>Да</TD>
<TD>Нет</TD>
<TD>Нет</TD>
<TD>Нет</TD>
<TD>50</TD>
<TD>20</TD>
<TD>200</TD>
</TR>
<? if ($klan['clanlevel']==4) {
echo"<TR style='background: #92D050;'>";
}else{
echo"<TR >";}
?>
<TD>4</TD>
<TD>24</TD>
<TD>Да</TD>
<TD>Да</TD>
<TD>Нет</TD>
<TD>Нет</TD>
<TD>100</TD>
<TD>40</TD>
<TD>200</TD>
</TR>
<? if ($klan['clanlevel']==5) {
echo"<TR style='background: #92D050;'>";
}else{
echo"<TR >";}
?>
<TD>5</TD>
<TD>28</TD>
<TD>Да</TD>
<TD>Да</TD>
<TD>Нет</TD>
<TD>Нет</TD>
<TD>100</TD>
<TD>40</TD>
<TD>200</TD>
</TR>
<? if ($klan['clanlevel']==6) {
echo"<TR style='background: #92D050;'>";
}else{
echo"<TR >";}
?>
<TD>6</TD>
<TD>32</TD>
<TD>Да</TD>
<TD>Да</TD>
<TD>Нет</TD>
<TD>Нет</TD>
<TD>100</TD>
<TD>40</TD>
<TD>200</TD>
</TR>
<? if ($klan['clanlevel']==7) {
echo"<TR style='background: #92D050;'>";
}else{
echo"<TR >";}
?>
<TD>7</TD>
<TD>36</TD>
<TD>Да</TD>
<TD>Да</TD>
<TD>Нет</TD>
<TD>Нет</TD>
<TD>200</TD>
<TD>80</TD>
<TD>200</TD>
</TR>

<? if ($klan['clanlevel']==8) {
echo"<TR style='background: #92D050;'>";
}else{
echo"<TR >";}
?>
<TD>8</TD>
<TD>40</TD>
<TD>Да</TD>
<TD>Да</TD>
<TD>Да</TD>
<TD>Да</TD>
<TD>200</TD>
<TD>80</TD>
<TD>200</TD>
</TR>

<? if ($klan['clanlevel']==9) {
echo"<TR style='background: #92D050;'>";
}else{
echo"<TR >";}
?>
<TD>9</TD>
<TD>44</TD>
<TD>Да</TD>
<TD>Да</TD>
<TD>Да</TD>
<TD>Да</TD>
<TD>200</TD>
<TD>80</TD>
<TD>200</TD>
</TR>

<? if ($klan['clanlevel']==10) {
echo"<TR style='background: #92D050;'>";
}else{
echo"<TR >";}
?>
<TD>10</TD>
<TD>48</TD>
<TD>Да</TD>
<TD>Да</TD>
<TD>Да</TD>
<TD>Да</TD>
<TD>200</TD>
<TD>80</TD>
<TD>200</TD>
</TR>

<? if ($klan['clanlevel']==11) {
echo"<TR style='background: #92D050;'>";
}else{
echo"<TR >";}
?>
<TD>11</TD>
<TD>52</TD>
<TD>Да</TD>
<TD>Да</TD>
<TD>Да</TD>
<TD>Да</TD>
<TD>200</TD>
<TD>80</TD>
<TD>200</TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>
</div>
<div class=dtz ID=dTZ16>
<TABLE cellspacing=0 width="100%" cellpadding=2><TR><TD align=center width="60%">
<h4><a href="javascript:top.AddToPrivate('klan',true)"><IMG SRC=<?=IMGBASE?>/i/lock.gif WIDTH=20 HEIGHT=15 ALT="Приватно"></a>Соклановцы</TD><TD align=right><input type=button value="Только Online" onclick="ShowAllUsers()" id="users_button"></TD></TR>
<TR><TD bgcolor=efeded nowrap colspan=2>
<table cellpadding=0 cellspacing=0 border=0 id="users_table">
</table><table width=100% border=0>
<?

					$data=mysql_query("SELECT `id`, `login`, `status`, `level`, `room`, `align`, (select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = users.`id`) as `online` FROM `users` WHERE `klan` = '".$klan['short']."' order by online DESC, login asc ;");
					while ($row = mysql_fetch_array($data)) {
						if ($row['online']>0) {
							echo '<tr><td width=20><A HREF="javascript:top.AddToPrivate(\'',nick7($row['id']),'\', top.CtrlPress)" target=refreshed><img src="i/lock.gif" width=20 height=15></A></td>';
                           echo"<td nowrap=nowrap>";nick2($row['id']); echo"</td>";
							if ($row['id'] == $klan['glava']) {
								echo '<td align=center width=90%><img src="/i/klan/'.$klan['name'].'.gif"><b>Глава клана</b></td></tr>';
							} else {
								echo '<td align=center width=90%><img src="/i/klan/'.$klan['name'].'.gif"><b>',$row['status'],'</b></td></tr>';

							}
						}
						else if ($row['online']<1) {
							echo '<tr><td><img src="i/offline.gif" width=20 height=15 alt="Нет в клубе"></td>';
                           echo"<td nowrap=nowrap>";nick2($row['id']); echo"</td>";
							if ($row['id'] == $klan['glava']) {
								echo '<td align=center width=90%><img src="/i/klan/'.$klan['name'].'.gif"><b>Глава клана</b></td></tr>';
							} else {
								echo '<td align=center width=90%><img src="/i/klan/'.$klan['name'].'.gif"><b>',$row['status'],'</b></td></tr>';
							}
						}
					}
?></table>
<script>
var mode = false;
function ShowAllUsers() {
  for (var i = 0; i < <?=$i?>; i++) {
    document.getElementById('c1'+i).style.display = (mode ? '' : 'none');
    document.getElementById('c2'+i).style.display = (mode ? '' : 'none');
    document.getElementById('c3'+i).style.display = (mode ? '' : 'none');
  }
  mode = !mode;
  document.getElementById('users_button').value = (mode ? 'Показать всех' : 'Только online');
}
</script>
</TD></TR><TR><TD>
<?
/*$R_ONLINE = mq("SELECT `klan` FROM users WHERE `klan` = '{$user['klan']}';");
$total = 0;
        while(mysql_fetch_array($R_ONLINE)){
        $total++;
        }*/
?>
Всего: <B><?=$klan["cnt"]?></B><BR>
<small>(список обновляется раз в сутки)</small>
</TD></TR></TABLE>
</div>
</TD>
</TR>
</TABLE>
</td>
</tr>
</table>
</BODY>
</HTML>
<?php include("mail_ru.php"); ?>

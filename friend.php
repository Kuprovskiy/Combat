<?php
// nick
function nick21 ($id) {
    if($id > _BOTSEPARATOR_) {
        $bots = mysql_fetch_array(mysql_query ('SELECT * FROM `bots` WHERE `id` = '.$id.' LIMIT 1;'));
        $id=$bots['prototype'];
        $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
        $user['login'] = $bots['name'];
        $user['hp'] = $bots['hp'];
        $user['id'] = $bots['id'];
    } else {
        $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
        if (!$user) $user = mysql_fetch_array(mysql_query("SELECT * FROM `allusers` WHERE `id` = '{$id}' LIMIT 1;"));
    }

    if($user[0]) {
    ?>
    <img src="<?=IMGBASE?>/i/align_<?echo ($user['align']>0 ? $user['align']:"0");?>.gif"><?php if ($user['klan'] <> '') { echo '<img title="'.$user['klan'].'" src="'.IMGBASE.'/i/klan/'.$user['klan'].'.gif">'; }?><B><?=$user['login']?></B> [<?
    if (id==2236) echo "?"; else echo $user['level'];
    ?>]<a href=inf.php?<?=$user['id']?> target=_blank><IMG SRC=<?=IMGBASE?>/i/inf.gif WIDTH=12 HEIGHT=11 ALT="���. � <?=$user['login']?>"></a>
<?
    return 1;
    }
}

ob_start("ob_gzhandler");
    session_start();
    if ($_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    $friend = mysql_fetch_array(mysql_query("SELECT * FROM `friends` WHERE `user` = '{$_SESSION['uid']}' LIMIT 1;"));
    $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
        if($user['level']<0){header("Location: index.php"); exit();}
    include "functions.php";

  getfeatures($user);
  $maxfriends=$user["friendly"]*5+20;

  if ($user["align"]==5) $maxfriends=1000;

if($_POST['sd4'] && $_POST['friendadd']){
$_POST['friendadd']=htmlspecialchars($_POST['friendadd']);
if(preg_match("/__/",$_POST['friendadd']) || preg_match("/--/",$_POST['friendadd'])){
echo"<font color=red>�������� �� ������.</font>";
}else{
    $igogo = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE `login` = '{$_POST['friendadd']}' LIMIT 1;"));
    if (!$igogo) $igogo = mysql_fetch_array(mysql_query("SELECT id FROM `allusers` WHERE `login` = '{$_POST['friendadd']}' LIMIT 1;"));
}
$_POST['comment']=htmlspecialchars($_POST['comment']);
$igogo2 = mysql_fetch_array(mysql_query("SELECT enemy,friend,notinlist FROM `friends` WHERE `user` = '".$user['id']."' and (`friend`=".$igogo['id']." or `enemy`=".$igogo['id']." or `notinlist`=".$igogo['id'].") LIMIT 1;"));
if(!$igogo['id']){echo"<font color=red>�������� �� ������.</font>";}
elseif($igogo['id']==$user['id']){echo"<font color=red>���� �������� ������.</font>";}
elseif(preg_match("/__/",$_POST['comment']) || preg_match("/--/",$_POST['comment'])){echo"<font color=red>������ �������� �����.</font>";}
elseif($igogo2['enemy'] or $igogo2['friend'] or $igogo2['notinlist']){echo"<font color=red>�������� ��� ���� � ����� ������.</font>";}
else{
  $f=mqfa1("select count(user) from friends where user='$user[id]'");
  if ($f<$maxfriends) {
    if($_POST['group']==0){$notinlist=0; $friend=$igogo['id']; $enemy=0;}
    elseif($_POST['group']==1){$notinlist=0; $friend=0; $enemy=$igogo['id'];}
    else{$notinlist=$igogo['id']; $friend=0; $enemy=0;}
    mysql_query("INSERT INTO `friends` (`user`, `friend`, `enemy`, `notinlist`, `comment`) VALUES(".$user['id'].", ".$friend.", ".$enemy.", ".$notinlist.", '".$_POST['comment']."');");
    echo"<font color=red>�������� <b>".$_POST['friendadd']."</b> ��������.</font>";
  }
}
}

if($_POST['friendremove']){
$_POST['friendremove']=htmlspecialchars($_POST['friendremove']);
if(preg_match("/__/",$_POST['friendremove']) || preg_match("/--/",$_POST['friendremove'])){
echo"<font color=red>�������� �� ������.</font>";
}else{
    $igogo = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE `login` = '{$_POST['friendremove']}' LIMIT 1;"));
    if (!$igogo) $igogo = mysql_fetch_array(mysql_query("SELECT id FROM `allusers` WHERE `login` = '{$_POST['friendremove']}' LIMIT 1;"));
}
if(!$igogo['id']){echo"<font color=red>�������� �� ������.</font>";}
else{$igogo2 = mysql_fetch_array(mysql_query("SELECT enemy,friend,notinlist FROM `friends` WHERE `user` = '".$user['id']."' and (`friend`=".$igogo['id']." or `enemy`=".$igogo['id']." or `notinlist`=".$igogo['id'].") LIMIT 1;"));
if(!$igogo2['enemy'] && !$igogo2['friend'] && !$igogo2['notinlist']){echo"<font color=red>�������� �� ������ � ����� ������.</font>";}else{
if($igogo2['friend']>0){$per="`friend`='".$igogo2['friend']."'";}
if($igogo2['enemy']>0){$per="`enemy`='".$igogo2['enemy']."'";}
if($igogo2['notinlist']>0){$per="`notinlist`='".$igogo2['notinlist']."'";}
if(mysql_query("DELETE FROM `friends` WHERE `user`='".$user['id']."' and ".$per.";")){echo"<font color=red>������ �������� <b>".$_POST['friendremove']."</b> ������� �������.</font>";}
}


}

}



if($_POST['friendedit']){



$_POST['friendedit']=htmlspecialchars($_POST['friendedit']);
if(preg_match("/__/",$_POST['friendedit']) || preg_match("/--/",$_POST['friendedit'])){
echo"<font color=red>�������� �� ������.</font>";
}else{
    $igogo = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE `login` = '{$_POST['friendedit']}' LIMIT 1;"));
    if (!$igogo) $igogo = mysql_fetch_array(mysql_query("SELECT id FROM `allusers` WHERE `login` = '{$_POST['friendedit']}' LIMIT 1;"));
}
$_POST['comment']=htmlspecialchars($_POST['comment']);
if(!$igogo['id']){echo"<font color=red>�������� �� ������.</font>";}
elseif($igogo['id']==$user['id']){echo"<font color=red>���� ��������������� ������.</font>";}
elseif(preg_match("/__/",$_POST['comment']) || preg_match("/--/",$_POST['comment'])){echo"<font color=red>������ �������� �����.</font>";}
else{

if($_POST['group']==0){$notinlist=0; $friend=$igogo['id']; $enemy=0;}
elseif($_POST['group']==1){$notinlist=0; $friend=0; $enemy=$igogo['id'];}
else{$notinlist=$igogo['id']; $friend=0; $enemy=0;}
$igogo2 = mysql_fetch_array(mysql_query("SELECT enemy,friend,notinlist FROM `friends` WHERE `user` = '".$user['id']."' and (`friend`=".$igogo['id']." or `enemy`=".$igogo['id']." or `notinlist`=".$igogo['id'].") LIMIT 1;"));
if(!$igogo2['enemy'] && !$igogo2['friend'] && !$igogo2['notinlist']){echo"<font color=red>�������� �� ������ � ����� ������.</font>";}else{
if($igogo2['friend']>0){$per="`friend`='".$igogo2['friend']."'";}
if($igogo2['enemy']>0){$per="`enemy`='".$igogo2['enemy']."'";}
if($igogo2['notinlist']>0){$per="`notinlist`='".$igogo2['notinlist']."'";}
$comment = $_POST['comment'];
mysql_query("UPDATE `friends` SET `friend` = ".$friend.",`enemy` = ".$enemy.",`notinlist` = ".$notinlist.",`comment` = '".$comment."'  WHERE `user`='".$user['id']."' and ".$per."");
echo"<font color=red>������ �������� <b>".$_POST['friendedit']."</b> ������� ��������.</font>";
}


}

}



?>
<HTML><HEAD>
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<link rel=stylesheet type="text/css" href="<?=IMGBASE?>/i/main.css">
<link href="<?=IMGBASE?>/i/move/design3.css" rel="stylesheet" type="text/css">

<SCRIPT LANGUAGE="JavaScript" SRC="<?=IMGBASE?>/i/sl2.21.js"></SCRIPT>
<SCRIPT src='<?=IMGBASE?>/i/commoninf2.js'></SCRIPT>
<SCRIPT>
var nlevel=0;
var from = Array('+', ' ', '#');
var to = Array('%2B', '+', '%23');

function editcontact(title, script, name, login, flogin, group, groups, subgroup, subgroups, comment)
{   var s = '<table width=250 cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>';
    s +='<form action="'+script+'" method=POST><table width=250 cellspacing=0 cellpadding=4 bgcolor=FFF6DD><tr><td align=center>';
    s +='<table width=1% border=0 cellspacing=0 cellpadding=2 align=center><tr><td align=right>';
    flogin = flogin.replace( /^<SCRIPT>drwfl\((.*)\)<\/SCRIPT>$/i, 'drw($1)' );
    s +='<small><b>�������:</b></small></td><td><INPUT TYPE=hidden NAME="'+name+'" VALUE="'+login+'">'+( flogin.match(/^drw\(/) ? eval(flogin) : flogin )+'</td></tr>';
    if (groups && groups.length>0) {
        s+='<tr><td align=right><small><b>������:</b></small></td><td align><SELECT NAME=group style="width: 140px">';
        for(i=0; i< groups.length; i++) {
            s+='<option value="'+i+'"'+( group == i ? ' selected' : '' ) +'>'+groups[i];
        }
        s+='</SELECT></td></tr>';
    };

    s += '<tr><td align=right><small><b>�����������:</b></small></td><td width="1%"><INPUT TYPE=text NAME="comment" VALUE="'+comment+'" style="width: 105px">&nbsp;';
    s += '<INPUT type=image SRC=/i/b__ok.gif WIDTH=25 HEIGHT=18 ALT="���������" style="border:0; vertical-align: middle"></TD></TR></TABLE><INPUT TYPE=hidden name=sd4 value=""></TD></TR></TABLE></form></td></tr></table>';
document.all("hint4").innerHTML = s;
document.all("hint4").style.visibility = "visible";
document.all("hint4").style.left = 100;
document.all("hint4").style.top = document.body.scrollTop+50;
document.all("comment").focus();
Hint3Name = '';
}
function findlogin2(title, script, name, groups, subgroups)
{   var s = '<table width=270 cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>';
s +='<form action="'+script+'" method=POST><table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td align=center>';
s +='<table width=90% cellspacing=0 cellpadding=2 align=center><tr><td align=left colspan="2">';
s +='������� ����� ���������:<br><small>(����� �������� �� ������ � ����)</small></td></tr>';
s += '<tr><td align=right><small><b>�����:</b></small></td><td><INPUT TYPE=text name="'+name+'" id="'+name+'" style="width:140px"></td></tr>';
if (groups && groups.length>0) {
s+='<tr><td align=right><small><b>������:</b></small></td><td width=140><SELECT NAME=group style="width:140px">';
for(i=0; i< groups.length; i++) {
s+='<option value="'+i+'">'+groups[i];
}
s+='</SELECT></td></tr>';
};

s += '<tr><td align=right><small><b>�����������:</b></small></td><td><INPUT TYPE=text NAME="comment" VALUE="" style="width:105px">&nbsp;';
s += '<INPUT type=image SRC=/i/b__ok.gif WIDTH=25 HEIGHT=18 ALT="�������� �������" style="border:0; vertical-align: middle"></TD></TR></TABLE><INPUT TYPE=hidden name=sd4 value="1"></TD></TR></TABLE></form></td></tr></table>';
document.getElementById("hint4").innerHTML = s;
document.getElementById("hint4").style.visibility = "visible";
document.getElementById("hint4").style.left = 100;
document.getElementById("hint4").style.top = document.body.scrollTop+50;
Hint3Name = name;
document.getElementById(name).focus();
}
function w(login,id,align,klan,level,online, city, battle){
var s='';
if (online!="") {
if (city!="") {
s+='<IMG style="filter:gray()" SRC=<?=IMGBASE?>/i/lock.gif WIDTH=20 HEIGHT=15 ALT="� ������ ������">';
} else {
s+='<a href="javascript:top.AddToPrivate(\''+login+'\',true)"><IMG SRC=<?=IMGBASE?>/i/lock.gif WIDTH=20 HEIGHT=15 ALT="��������"'+(battle!=0?' style="filter: invert()"':'')+'></a>';
}
if (city!="") {
s+='<img src="<?=IMGBASE?>/i/misc/forum/fo'+city+'.gif" width=17 height=15>';
}
s+=' <IMG SRC=<?=IMGBASE?>/i/align'+align+'.gif WIDTH=12 HEIGHT=15>';
if (klan!='') {s+='<A HREF="/encicl/klan/'+klan+'.html" target=_blank><IMG SRC="<?=IMGBASE?>/i/klan/'+klan+'.gif" WIDTH=24 HEIGHT=15 ALT=""></A>'}
s+='<a href="javascript:top.AddTo(\''+login+'\')">'+login+'</a>['+level+']<a href=/inf.pl?'+id+' target=_blank><IMG SRC=<?=IMGBASE?>/i/inf.gif WIDTH=12 HEIGHT=11 ALT="���������� � ���������"></a>';
s+='</td><td bgcolor=efeded nowrap>';
if (city!="") {
s+="��� � ���� ������";
} else {
s+=online;
}
}
else {
s+='<IMG SRC="<?=IMGBASE?>/i/offline.gif" WIDTH=20 HEIGHT=15 BORDER=0 ALT="��� � �����">';
if (city!="") {
s+='<img src="<?=IMGBASE?>/i/misc/forum/fo'+city+'.gif" width=17 height=15>';
}
if (align == "") align="0";
s+=' <IMG SRC=<?=IMGBASE?>/i/align'+align+'.gif WIDTH=12 HEIGHT=15>';
if (klan!='') {s+='<A HREF="/encicl/klan/'+klan+'.html" target=_blank><IMG SRC="<?=IMGBASE?>/i/klan/'+klan+'.gif" WIDTH=24 HEIGHT=15 ALT=""></A>'}
if (level) {
if (nlevel==0) {
nlevel=1; //s="<BR>"+s;
}
s+='<FONT color=gray><b>'+login+'</b>['+level+']<a href=/inf.pl?'+id+' target=_blank><IMG SRC=<?=IMGBASE?>/i/inf.gif WIDTH=12 HEIGHT=11 ALT="���������� � ���������"></a></td><td bgcolor=efeded nowrap>��� � �����';
} else {
if (nlevel==1) {
nlevel=2; //s="<BR>"+s;
}
mlogin = login;
for(var i=0;i<from.length;++i) while(mlogin.indexOf(from[i])>=0)  mlogin= mlogin.replace(from[i],to[i]);
s+='<FONT color=gray><i>'+login+'</i> <a href=/inf.pl?login='+mlogin+' target=_blank><IMG SRC=<?=IMGBASE?>/i/inf_dis.gif WIDTH=12 HEIGHT=11 ALT="���������� � ���������"></a></td><td bgcolor=efeded nowrap>��� � ���� ������';
}
s+='</FONT>';
}
document.write(s+'<BR>');
}
function m(login,id,align,klan,level){
var s='';
s+='<a href="javascript:top.AddToPrivate(\''+login+'\',true)"><IMG SRC=<?=IMGBASE?>/i/lock.gif WIDTH=20 HEIGHT=15 ALT="��������"></a>';
s+=' <IMG SRC=<?=IMGBASE?>/i/align'+align+'.gif WIDTH=12 HEIGHT=15>';
if (klan!='') {
s+='<A HREF="/encicl/klan/'+klan+'.html" target=_blank><IMG SRC="<?=IMGBASE?>/i/klan/'+klan+'.gif" WIDTH=24 HEIGHT=15 ALT=""></A>'
}
s+='<a href="javascript:top.AddTo(\''+login+'\')">'+login+'</a>['+level+']<a href=/inf.pl?'+id+' target=_blank><IMG SRC=<?=IMGBASE?>/i/inf.gif WIDTH=12 HEIGHT=11 ALT="���������� � ���������"></a>';
document.write(s+'<BR>');
}
function drw(name, id, level, align, klan, img, sex)
{
var s="";
if (align!="0") s+="<A HREF='"+getalignurl(align)+"' target=_blank><IMG SRC='<?=IMGBASE?>/i/align_"+align+".gif' WIDTH=12 HEIGHT=15 ALT=\""+getalign(align)+"\"></A>";
if (klan) s+="<A HREF='claninf.php?"+klan+"' target=_blank><IMG SRC='<?=IMGBASE?>/i/klan/"+klan+".gif' WIDTH=24 HEIGHT=15 ALT=''></A>";
s+="<B>"+name+"</B>";
if (level!=-1) s+=" ["+level+"]";
if (id!=-1 && !img) s+="<A HREF='/inf.php?"+id+"' target='_blank'><IMG SRC=<?=IMGBASE?>/i/inf.gif WIDTH=12 HEIGHT=11 ALT='���. � "+name+"'></A>";
if (img) s+="<A HREF='http://capitalcity.combats.com/encicl/obraz_"+(sex?"w":"m")+"1.html?l="+img+"' target='_blank'><IMG SRC=<?=IMGBASE?>/i/inf.gif WIDTH=12 HEIGHT=11 ALT='����� "+name+"'></A>";
return s;
}
</SCRIPT>

</HEAD>
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=e2e0e0>
<div id=hint4 class=ahint style="position:absolute;left:0px;top:0px"></div>
<TABLE cellspacing=0 cellpadding=2 width="100%">
<TR>
<TD style="vertical-align: top; "><TABLE cellspacing=0 cellpadding=2 width="100%">
<TR>
<TD colspan="4" align="center"><h4>������</h4></TD>
</TR>
<?
                    $data=mysql_query("SELECT `notinlist`,`comment` FROM `friends` WHERE `user` = '".$user['id']."' and `notinlist`>0;");
                    while ($row = mysql_fetch_array($data)) {
                    $us=mysql_fetch_array(mysql_query("SELECT `id`,`login`,`klan`,invis,`level`,`align`,`room`, (select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = users.`id`) as `online` FROM `users` WHERE `id` = '".$row['notinlist']."';"));
                    if (!$us) $us=mysql_fetch_array(mysql_query("SELECT `id`,`login`,`klan`,`level`,`align`,`room`, (select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = allusers.`id`) as `online` FROM `allusers` WHERE `id` = '".$row['notinlist']."';"));?>


<TR valign="top">
<TD bgcolor=efeded nowrap>
<?
if ($us['online']>0 && !$us["invis"]) {
    echo '<A HREF="javascript:top.AddToPrivate(\'',nick7($us['id']),'\', top.CtrlPress)" target=refreshed><img src="'.IMGBASE.'/i/lock.gif" width=20 height=15></A>';
nick21($us['id']);
    if($us['room'] > 500 && $us['room'] < 561) {
       $rrm = '����� ������, ��������� � �������';
    } elseif (incastle($us['room'])) $rrm = "�������� �����";
    else  $rrm = $rooms[$us['room']];
    echo ' <i>',$rrm,'</i><BR>';
}else{

    echo '<font color=gray><img src="'.IMGBASE.'/i/offline.gif" width=20 height=15 alt="��� � �����">';
    nick21($us['id']);
    echo '</font> - ��� � �����<BR>';

}


?>
</TD>
<TD bgcolor=efeded width="40%"><small><FONT class=dsc><i><?=$row['comment']?></i></FONT></small><TD>
<TD width="1%"><INPUT type=image SRC=/i/b__ok.gif WIDTH=25 HEIGHT=18 ALT="�������������" style="float: right" onclick='editcontact("�������������� ��������", "friend.php", "friendedit", "<?=$us['login']?>", "<SCRIPT>drwfl(\"<?=$us['login']?>\",<?=$row['notinlist']?>,\"<?=$us['level']?>\",<?=$us['align']?>,\"<?=$us['klan']?>\")</SCRIPT>", "2", new Array( "������","�������","�� � ������" ), "", new Array(  ), "<?=$row['comment']?>");'></TD>
</TR>
<?
}
                    $data=mysql_query("SELECT `enemy`,`comment` FROM `friends` WHERE `user` = '".$user['id']."' and `enemy`>0;");
                    while ($row = mysql_fetch_array($data)) {
                    $us=mysql_fetch_array(mysql_query("SELECT `id`,`login`,`klan`,invis,`level`,`align`,`room`, (select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = users.`id`) as `online` FROM `users` WHERE `id` = '".$row['enemy']."';"));
                    if (!$us) $us=mysql_fetch_array(mysql_query("SELECT `id`,`login`,`klan`,`level`,`align`,`room`, (select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = allusers.`id`) as `online` FROM `allusers` WHERE `id` = '".$row['enemy']."';"));

    $n++;
if($n==1){
?>
<TR>
<TD colspan="4" nowrap align="center" style="height: 40px" valign="bottom"><h4>�������</h4></TD>
</TR>
<?}?>

<TR valign="top">
<TD bgcolor=efeded nowrap>
<?

if ($us['online']>0 && !$us["invis"]) {
    echo '<A HREF="javascript:top.AddToPrivate(\'',nick7($us['id']),'\', top.CtrlPress)" target=refreshed><img src="'.IMGBASE.'/i/lock.gif" width=20 height=15></A>';
nick21($us['id']);
    if($us['room'] > 500 && $us['room'] < 561) {
       $rrm = '����� ������, ��������� � �������';
    } elseif (incastle($us['room'])) $rrm = "�������� �����";
    else  $rrm = $rooms[$us['room']];
    echo ' - <i>',$rrm,'</i><BR>';
}else{

    echo '<font color=gray><img src="'.IMGBASE.'/i/offline.gif" width=20 height=15 alt="��� � �����">';
    nick21($us['id']);
    echo '</font> - ��� � �����<BR>';

}


?>
</TD>
<TD bgcolor=efeded width="40%"><small><FONT class=dsc><i><?=$row['comment']?></i></FONT></small><TD>
<TD width="1%"><INPUT type=image SRC=/i/b__ok.gif WIDTH=25 HEIGHT=18 ALT="�������������" style="float: right" onclick='editcontact("�������������� ��������", "friend.php", "friendedit", "<?=$us['login']?>", "<SCRIPT>drwfl(\"<?=$us['login']?>\",<?=$row['enemy']?>,\"<?=$us['level']?>\",<?=$us['align']?>,\"<?=$us['klan']?>\")</SCRIPT>", "1", new Array( "������","�������","�� � ������" ), "", new Array(  ), "<?=$row['comment']?>");'></TD>
</TR>
<?
}

                    $data=mysql_query("SELECT `friend`,`comment` FROM `friends` WHERE `user` = '".$user['id']."' and `friend`>0;");
                    while ($row = mysql_fetch_array($data)) {
                    $us=mysql_fetch_array(mysql_query("SELECT `id`,`login`,`klan`,`level`, invis,`align`,`room`, (select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = users.`id`) as `online` FROM `users` WHERE `id` = '".$row['friend']."' ORDER BY online DESC, login ASC;"));
                    if (!$us) $us=mysql_fetch_array(mysql_query("SELECT `id`,`login`,`klan`,`level`,`align`,`room`, (select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = allusers.`id`) as `online` FROM `allusers` WHERE `id` = '".$row['friend']."' ORDER BY online DESC, login ASC;"));
    $i++;
if($i==1){
?>
<TR>
<TD colspan="4" nowrap align="center" style="height: 40px" valign="bottom"><h4>������</h4></TD>
</TR>
<?}?>
<TR valign="top">
<TD bgcolor=efeded nowrap>
<?

if ($us['online']>0 && !$us["invis"]) {
    echo '<A HREF="javascript:top.AddToPrivate(\'',nick7($us['id']),'\', top.CtrlPress)" target=refreshed><img src="'.IMGBASE.'/i/lock.gif" width=20 height=15></A>';
nick21($us['id']);
    if($us['room'] > 500 && $us['room'] < 561) {
       $rrm = '����� ������, ��������� � �������';
    }  elseif (incastle($us['room'])) $rrm = "�������� �����";
    else  $rrm = $rooms[$us['room']];
    echo ' - <i>',$rrm,'</i><BR>';
}else{

    echo '<font color=gray><img src="'.IMGBASE.'/i/offline.gif" width=20 height=15 alt="��� � �����">';
    nick21($us['id']);
    echo '</font> - ��� � �����<BR>';

}


?>
</TD>
<TD bgcolor=efeded width="40%"><small><FONT class=dsc><i><?=$row['comment']?></i></FONT></small><TD>
<TD width="1%"><INPUT type=image SRC=/i/b__ok.gif WIDTH=25 HEIGHT=18 ALT="�������������" style="float: right" onclick='editcontact("�������������� ��������", "friend.php", "friendedit", "<?=$us['login']?>", "<SCRIPT>drwfl(\"<?=$us['login']?>\",<?=$row['friend']?>,\"<?=$us['level']?>\",<?=$us['align']?>,\"<?=$us['klan']?>\")</SCRIPT>", "7", new Array( "������","�������","�� � ������" ), "", new Array(  ), "<?=$row['comment']?>");'></TD>
</TR>
<?
}
  $f=mqfa1("select count(user) from friends where user='$user[id]'");
?>
<TR>
<TD colspan="4">
<?   if ($f<$maxfriends) { ?>
<INPUT type='button' style='width: 100px' value='��������' onclick='findlogin2("�������� � ������", "friend.php", "friendadd", new Array("������","�������","�� � ������"), new Array())'>
&nbsp;&nbsp;&nbsp;<? } ?>
<INPUT type='button' style='width: 100px' value='�������' onclick='findlogin("������� �� ������", "friend.php", "friendremove", "", 0)'></TD>
</TR>
<? 
if ($f>=$maxfriends) echo "<tr><td colspan=4><b><font color=red>��������� ������������ ���������� �����. ��� ���������� ����� ���������� ������� ����-�� �� ������ ��� ��������� ����������� �����������.</font></b></td></tr>"; ?>
</TABLE></TD>
<TD style="width: 5%; vertical-align: top; ">&nbsp;</TD>
<TD style="width: 30%; vertical-align: top; "><TABLE cellspacing=0 cellpadding=2>
<TR>
<TD style="width: 25%; vertical-align: top; text-align: right; "><INPUT type='button' value='��������' style='width: 75px' onclick='location="/friend.php?friends=0.834468433941264"'>
&nbsp;<INPUT TYPE=button value="���������" style='width: 75px' onclick="top.returned()"></TD>
</TR>
<TR>
<TD align=center><h4>���������� on-line</h4></TD>
</TR>
<TR>
<TD bgcolor=efeded nowrap style="text-align: center; "><table>
                <?
                    $data=mq("SELECT users.id, users.login, users.level, users.align FROM `users` left join online on users.id=online.id WHERE ((users.align>1 and users.align<2) or (users.align>3 and users.align<4)) and users.invis=0 and online.date>= ".(time()-60)." order by align desc, login asc;");
                    //$data=mysql_query("SELECT `id`, `login`, `level`, `align`, (select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = users.`id`) as `online` FROM `users` WHERE (align>1 and align<2) or (align>3 and align<4) and invis=0 order by align desc, login asc ;");
                    while ($row = mysql_fetch_array($data)) {
                        if ($row['id']>0) {
                            echo '<tr><td><A HREF="javascript:top.AddToPrivate(\'',$row['login'],'\', top.CtrlPress)" target=refreshed><img src="'.IMGBASE.'/i/lock.gif" width=20 height=15></A>';
                            nick21($row['id']);
                            echo'</tr></td>';
                        }
                    }
                ?>
</table></TD>
</TR>
<TR>
<TD style="text-align: left; "><small>��������� ������!<BR>��� ����� �������� � ������������ ������� ����� �������� ������� ���������� � ��� �����������, ���� ������� ��������� ������ ������ ����������� on-line�.<BR>������ ���� � ����� �����!</small></div></TD>
</TR>
<TR> 
<TD align=center><h4>������������� on-line</h4></TD> 
</TR> 
<TR> 
<TD bgcolor=efeded nowrap style="text-align: center; "><table> 
<?
$data=mq("SELECT users.id, users.login, users.level, users.align FROM `users` left join online on users.id=online.id WHERE ((users.align=2.5) or (users.align=2.51)) and users.invis=0 and online.date>= ".(time()-60)." order by align desc, login asc;");
while ($row = mysql_fetch_array($data)) {
if ($row['id']>0) { echo '<tr><td><A HREF="javascript:top.AddToPrivate(\'',$row['login'],'\', top.CtrlPress)" target=refreshed><img src="'.IMGBASE.'/i/lock.gif" width=20 height=15></A>';
nick21($row['id']);
echo'</tr></td>'; } }
?>
</table></TD> 
</TR>
<TR>
<TD style="text-align: left; "><small>��������� � ����������� ������� � �������.</small></div></TD>
</TR>
</TABLE></TD>
</TR>
</TABLE></TD>
</TR>
</TABLE>
<?php include("mail_ru.php"); ?>
</HTML>

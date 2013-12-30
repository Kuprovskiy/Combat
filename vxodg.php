<?php
	session_start();
	if ($_SESSION['uid'] == null) header("Location: index.php");
	include "connect.php";
	include "functions.php";
	if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }
	
if($user['room']==699){print "<script>location.href='canalizaciyag.php'</script>";}

$der=mysql_query("SELECT glav_id FROM vxodg WHERE login='".$user['login']."'");
if($deras=mysql_fetch_array($der)){
header('location: vxodg.php?warning=3');
die();
}

if($user['room']==698){
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
</HEAD>

<body bgcolor=e2e0e0 style="background-image: url(i/misc/showitems/dungeon.jpg);background-repeat:no-repeat;background-position:top right">





<div id=hint4 class=ahint></div>

<TABLE width=100%>
<TR><TD valign=top width=100%><center><font style="font-size:24px; color:#000033"><h3>Вход в Грибницу</h3></font></center>

<?
$ders=mysql_query("SELECT `login`,`glav_id` FROM vxod");
while($derass=mysql_fetch_array($ders)){
$dgr=mysql_query("SELECT `id` FROM `users` WHERE login='".$derass['login']."'");
$degas=mysql_fetch_array($dgr);
$onlines = mysql_query("select `id`,`real_time` from `online`  WHERE id='".$degas['id']."' and `real_time` >= ".(time()-60).";");
if(!$nes = mysql_fetch_array($onlines)){
if($derass['glav_id']==$degas['id']){
$e = mysql_query("DELETE FROM vxod WHERE login='".$derass['login']."'");
}
$ed = mysql_query("DELETE FROM vxod WHERE login='".$derass['login']."'");
}

}
?>

<?
$select = mysql_query ("SELECT `time` FROM `visit_podzemg` WHERE `login`='".$user['login']."' and `time`>'0'");
if($el = mysql_fetch_array ($select))
{
$wait_sec=$el["time"];
$new_t=time();
$left_time=$wait_sec-$new_t;
$left_min=floor($left_time/3600);
$left_sec=floor(($left_time-$left_min*3600)/60);
//if($wait_sec>$new_t){print" <small>(Вы можете посетить грибницу через $left_min ч. $left_sec мин. )</small>";}

//else{
mysql_query("DELETE FROM visit_podzemg WHERE login='".$user['login']."'");
print "<script>location.href='vxodg.php'</script>";
exit;
//}
}else{

$login = $user['login'];
$ya=mysql_query("select login from vxod where login='$login'");
$wawe = "0";
if($daw=mysql_fetch_array($ya)){$wawe="1";}

$naw=mysql_query("select login from vxod where login='$login'");
$nawe = "0";
if($ser=mysql_fetch_array($naw)){$nawe="1";}

$rt=mysql_query("select id,level from users where login='$login'");
$est=mysql_fetch_array($rt);
$user_id = $est["id"];
$user_lvl = $est["level"];

if($_GET['warning']==1){print"<font style='color:#CC0000'>&nbsp;Вы покинули группу</font>";}
if($_GET['warning']==2){print"<font style='color:#CC0000'>&nbsp;Увы! Не угадали пароль!</font>";}
if($_GET['warning']==3){print"<font style='color:#CC0000'>&nbsp;Вы подали заявку! Отзавите!</font>";}
if($_GET['warning']==4){print"<font style='color:#CC0000'>&nbsp;Вы уже в группе!</font>";}
if($_GET['warning']==5){print"<font style='color:#CC0000'>&nbsp;Группа уже собранна!</font>";}
print"<TABLE cellpadding=1 cellspacing=0>";

$i=0;
$Q=mysql_query("SELECT * FROM vxod");
while($DATA=mysql_fetch_array($Q)){/////////////1
   $cr=$DATA["glav_id"];
   $z_login[$i]=$DATA["login"];
   $date[$i]=$DATA["date"];
   $comment[$i]=$DATA["comment"];
   $password[$i]=$DATA["pass"];

   $mine_z[$i] = 0;

   $Q2=mysql_query("SELECT `glav_id` FROM `vxod` WHERE `glav_id`='$cr'");
   $t1_all[$i]=0;
   while($DATAS=mysql_fetch_array($Q2)){
   $t1_all[$i]++;
   }
   $creator[$i]=$DATA["glav_id"];
   $i++;
                                   }///////////////1

for($n=0;$n<$i;$n++)
{/////////////открытие
print "<FORM id='REQUEST'>
<TR><TD>
<font class=date>$date[$n]</font><font style='font-size:12px; color:#000000;'>
(<IMG SRC='i/misc/commut/noblock.gif' WIDTH=20 HEIGHT=20 ALT='Быстрый Бой
(Бой идет со случайно назначенными ударами/блоками и средним уровнем брони)'>)";

  $QUER=mysql_query("SELECT `login`,`lvl` FROM `vxod` WHERE glav_id='$creator[$n]' ORDER BY id ASC");
  while($DATAS=mysql_fetch_array($QUER)){
  $p1=$DATAS["login"];
  $p_login=$DATAS["login"];
  $p_lvl=$DATAS["lvl"];
     if($p1!=""){
$p1="<b>$p1</b> [$p_lvl]<a href='inf.php?login=$p1' target='_blank'><img src='i/inf.gif' border=0></a> ";
if($t1_all[$n]==1){print "$p1";}else{print "$p1,";}

                }
                                        }
if(!empty($comment[$n])){print"| $comment[$n] </font>";}

if($wawe=='0'){

if(!empty($password[$n])){print"<input name='naw_pass' type='hidden' value='$password[$n]'><INPUT style=\"font-size:12px;\" type='password' name='pass' size=5> ";}
print"<input style=\"font-size:12px;\" name='naw_id' type='hidden' value='$creator[$n]'>
<INPUT style='font-size:12px;' TYPE=submit name=add value='Присоед.'>";}
print "</TD>
</TR></FORM>";

}/////////закрытие
?>

<TR><TD>


</TD></TR>
<TR height=1><TD height=1 bgcolor=#A0A0A0 colspan=2><SPAN></SPAN></TD></TR>
</TABLE>






<?


if($wawe=='0'){
print"<FORM id='REQUEST'>
<FIELDSET style='padding-left: 5; width=60%; color:#000000;'>
<LEGEND><B> Группа </B> </LEGEND>
Комментарий <INPUT style=\"font-size:12px;\" TYPE=text NAME=cmt maxlength=40 size=40><BR>
Пароль <INPUT style=\"font-size:12px;\" TYPE=password NAME=pass maxlength=6 size=25><BR>

<INPUT style='font-size:12px;' TYPE=submit name=open value='Создать группу'>&nbsp;<BR>

</FIELDSET>
</FORM>";
}else{

print"<FORM id='REQUEST'>
<FIELDSET style='padding-left: 5; width=50%'>
<LEGEND><B> Группа </B> </LEGEND>";
if($nawe==1){print"<INPUT style=\"font-size:12px;\" type='submit' name='start' value='Начать'> &nbsp;";}
print"<INPUT style=\"font-size:12px;\" type='submit' name='del' value='Покинуть группу'>
</FIELDSET>
</FORM>";}

///////////////Подача заявки////////////////////
if($_GET['open'])
{
$der=mysql_query("SELECT glav_id FROM vxodd WHERE login='".$user['login']."'");
if($deras=mysql_fetch_array($der)){
print "<script>location.href='?warning=4'</script>";
exit;
}
$time=date("H:i");
$SQL2 = mysql_query("INSERT INTO vxod(date,login,glav_id,comment,pass,room) VALUES('$time','$login','$user_id','".mysql_real_escape_string($_GET['cmt'])."','".mysql_real_escape_string($_GET['pass'])."')");
$SQL2 = mysql_query("INSERT INTO vxodd(login,glav_id,lvl) VALUES('$login','$user_id','$user_lvl')");
if($SQL2){
print "<script>location.href='vxodg.php'</script>";
}
}
//////////////Удаление заявки//////////////////////
if($_GET['del'])
{
$e = mysql_query("DELETE FROM vxod WHERE login='$login'");
$es = mysql_query("DELETE FROM vxod WHERE glav_id='$user_id'");
$ed = mysql_query("DELETE FROM vxod WHERE login='$login'");
if($e){
print "<script>location.href='vxodg.php?warning=1'</script>";
exit;
}else{print"Ошибка!!! Сообщите администратору!";}
}
/////////////Присоединится///////////////
if($_GET['add'])
{
$der=mysql_query("SELECT `glav_id`,`id` FROM `vxod` WHERE login='".$user['login']."'");
if($deras=mysql_fetch_array($der)){
print "<script>location.href='vxodg.php?warning=4'</script>";
exit;
}
$den=mysql_query("SELECT `id` FROM `vxod` WHERE glav_id='".mysql_real_escape_string($_GET['naw_id'])."'");
if(mysql_num_rows($den) >= 4){
print "<script>location.href='vxodg.php?warning=5'</script>";
exit;
}

if($_GET['pass'] == $_GET['naw_pass']){ 
  $rt=mysql_query("select level from users where login='$login'");
  $est=mysql_fetch_array($rt);
  $s = mysql_query("INSERT INTO `vxod`(login,glav_id,lvl) VALUES('$login','".mysql_real_escape_string($_GET['naw_id'])."','".mysql_real_escape_string($est["level"])."')");
  if($s){
  print "<script>location.href='vxodg.php'</script>";
  exit;}else{print"Ошибка!!! Сообщите администратору!";}
}else{
print "<script>location.href='vxodg.php?warning=2'</script>";
exit;
}
}
//////////////////Начинаем////////////////////
if($_GET['start']){
$zax=mysql_query("select `login` from `vxod` where glav_id='".$user['id']."'");
while($nana=mysql_fetch_array($zax))
{
$n_login = $nana["login"];
$rty=mysql_query("select id,level,login from users where login='$n_login'");
$esth=mysql_fetch_array($rty);
$est_id = $esth["id"];
$est_login = $esth["login"];
$vremya=240*60+time();
mysql_query("INSERT INTO visit_podzemg (login,time) VALUES ('$n_login','$vremya')");
$vrem=240*60+time();	
mysql_query('insert into labirint(user_id, login, location, vector, glav_id, glava, t, l,key1,key2,key3,el,name,visit_time) values("'.$est_id.'", "'.$est_login.'", "7", "90", "'.$user['id'].'", "'.$user['login'].'","237","464","99","96","92","47","Грибница - 1 Этаж","'.$vrem.'")');
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '699',`online`.`room` = '699' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '".$esth["id"]."' ;");
}

$ferrr = mysql_query("SELECT * FROM podzem3 WHERE glava='default' and name='Грибница - 1 Этаж'");
$retr = mysql_fetch_array($ferrr);
mysql_query('insert into podzem3(glava,name,n1,n2,n3,n4,n5,n6,n7,n8,n9,n11,n12,n13,n14,n15,n16,n17,n18,n19,n21,n22,n23,n24,n25,n26,n27,n28,n29,n31,n32,n33,n34,n35,n36,n37,n38,n39,n41,n42,n43,n44,n45,n46,n47,n48,n49,n51,n52,n53,n54,n55,n56,n57,n58,n59,n61,n62,n63,n64,n65,n66,n67,n68,n69,n71,n72,n73,n74,n75,n76,n77,n78,n79,n81,n82,n83,n84,n85,n86,n87,n88,n89,n91,n92,n93,n94,n95,n96,n97,n98,n99,sunduk1,sunduk2,sunduk3,sunduk4,sunduk5,sunduk6,sunduk7) values("'.$login.'","Грибница - 1 Этаж","'.$retr["n1"].'","'.$retr["n2"].'","'.$retr["n3"].'","'.$retr["n4"].'","'.$retr["n5"].'","'.$retr["n6"].'","'.$retr["n7"].'","'.$retr["n8"].'","'.$retr["n9"].'","'.$retr["n11"].'","'.$retr["n12"].'","'.$retr["n13"].'","'.$retr["n14"].'","'.$retr["n15"].'","'.$retr["n16"].'","'.$retr["n17"].'","'.$retr["n18"].'","'.$retr["n19"].'","'.$retr["n21"].'","'.$retr["n22"].'","'.$retr["n23"].'","'.$retr["n24"].'","'.$retr["n25"].'","'.$retr["n26"].'","'.$retr["n27"].'","'.$retr["n28"].'","'.$retr["n29"].'","'.$retr["n31"].'","'.$retr["n32"].'","'.$retr["n33"].'","'.$retr["n34"].'","'.$retr["n35"].'","'.$retr["n36"].'","'.$retr["n37"].'","'.$retr["n38"].'","'.$retr["n39"].'","'.$retr["n41"].'","'.$retr["n42"].'","'.$retr["n43"].'","'.$retr["n44"].'","'.$retr["n45"].'","'.$retr["n46"].'","'.$retr["n47"].'","'.$retr["n48"].'","'.$retr["n49"].'","'.$retr["n51"].'","'.$retr["n52"].'","'.$retr["n53"].'","'.$retr["n54"].'","'.$retr["n55"].'","'.$retr["n56"].'","'.$retr["n57"].'","'.$retr["n58"].'","'.$retr["n59"].'","'.$retr["n61"].'","'.$retr["n62"].'","'.$retr["n63"].'","'.$retr["n64"].'","'.$retr["n65"].'","'.$retr["n66"].'","'.$retr["n67"].'","'.$retr["n68"].'","'.$retr["n69"].'","'.$retr["n71"].'","'.$retr["n72"].'","'.$retr["n73"].'","'.$retr["n74"].'","'.$retr["n75"].'","'.$retr["n76"].'","'.$retr["n77"].'","'.$retr["n78"].'","'.$retr["n79"].'","'.$retr["n81"].'","'.$retr["n82"].'","'.$retr["n83"].'","'.$retr["n84"].'","'.$retr["n85"].'","'.$retr["n86"].'","'.$retr["n87"].'","'.$retr["n88"].'","'.$retr["n89"].'","'.$retr["n91"].'","'.$retr["n92"].'","'.$retr["n93"].'","'.$retr["n94"].'","'.$retr["n95"].'","'.$retr["n96"].'","'.$retr["n97"].'","'.$retr["n98"].'","'.$retr["n99"].'","'.$retr["sunduk1"].'","'.$retr["sunduk2"].'","'.$retr["sunduk3"].'","'.$retr["sunduk4"].'","'.$retr["sunduk5"].'","'.$retr["sunduk6"].'","'.$retr["sunduk7"].'")');



$ferrr = mysql_query("SELECT * FROM podzem4 WHERE glava='default' and name='Грибница - 1 Этаж'");
$retr = mysql_fetch_array($ferrr);
mysql_query('insert into podzem4(glava,name,n1,n2,n3,n4,n5,n6,n7,n8,n9,n11,n12,n13,n14,n15,n16,n17,n18,n19,n21,n22,n23,n24,n25,n26,n27,n28,n29,n31,n32,n33,n34,n35,n36,n37,n38,n39,n41,n42,n43,n44,n45,n46,n47,n48,n49,n51,n52,n53,n54,n55,n56,n57,n58,n59,n61,n62,n63,n64,n65,n66,n67,n68,n69,n71,n72,n73,n74,n75,n76,n77,n78,n79,n81,n82,n83,n84,n85,n86,n87,n88,n89,n91,n92,n93,n94,n95,n96,n97,n98,n99,v1,v2,v3,v4,v5,v6,v7,v8,v9,v11,v12,v13,v14,v15,v16,v17,v18,v19,v21,v22,v23,v24,v25,v26,v27,v28,v29,v31,v32,v33,v34,v35,v36,v37,v38,v39,v41,v42,v43,v44,v45,v46,v47,v48,v49,v51,v52,v53,v54,v55,v56,v57,v58,v59,v61,v62,v63,v64,v65,v66,v67,v68,v69,v71,v72,v73,v74,v75,v76,v77,v78,v79,v81,v82,v83,v84,v85,v86,v87,v88,v89,v91,v92,v93,v94,v95,v96,v97,v98,v99) values("'.$login.'","Грибница - 1 Этаж","'.$retr["n1"].'","'.$retr["n2"].'","'.$retr["n3"].'","'.$retr["n4"].'","'.$retr["n5"].'","'.$retr["n6"].'","'.$retr["n7"].'","'.$retr["n8"].'","'.$retr["n9"].'","'.$retr["n11"].'","'.$retr["n12"].'","'.$retr["n13"].'","'.$retr["n14"].'","'.$retr["n15"].'","'.$retr["n16"].'","'.$retr["n17"].'","'.$retr["n18"].'","'.$retr["n19"].'","'.$retr["n21"].'","'.$retr["n22"].'","'.$retr["n23"].'","'.$retr["n24"].'","'.$retr["n25"].'","'.$retr["n26"].'","'.$retr["n27"].'","'.$retr["n28"].'","'.$retr["n29"].'","'.$retr["n31"].'","'.$retr["n32"].'","'.$retr["n33"].'","'.$retr["n34"].'","'.$retr["n35"].'","'.$retr["n36"].'","'.$retr["n37"].'","'.$retr["n38"].'","'.$retr["n39"].'","'.$retr["n41"].'","'.$retr["n42"].'","'.$retr["n43"].'","'.$retr["n44"].'","'.$retr["n45"].'","'.$retr["n46"].'","'.$retr["n47"].'","'.$retr["n48"].'","'.$retr["n49"].'","'.$retr["n51"].'","'.$retr["n52"].'","'.$retr["n53"].'","'.$retr["n54"].'","'.$retr["n55"].'","'.$retr["n56"].'","'.$retr["n57"].'","'.$retr["n58"].'","'.$retr["n59"].'","'.$retr["n61"].'","'.$retr["n62"].'","'.$retr["n63"].'","'.$retr["n64"].'","'.$retr["n65"].'","'.$retr["n66"].'","'.$retr["n67"].'","'.$retr["n68"].'","'.$retr["n69"].'","'.$retr["n71"].'","'.$retr["n72"].'","'.$retr["n73"].'","'.$retr["n74"].'","'.$retr["n75"].'","'.$retr["n76"].'","'.$retr["n77"].'","'.$retr["n78"].'","'.$retr["n79"].'","'.$retr["n81"].'","'.$retr["n82"].'","'.$retr["n83"].'","'.$retr["n84"].'","'.$retr["n85"].'","'.$retr["n86"].'","'.$retr["n87"].'","'.$retr["n88"].'","'.$retr["n89"].'","'.$retr["n91"].'","'.$retr["n92"].'","'.$retr["n93"].'","'.$retr["n94"].'","'.$retr["n95"].'","'.$retr["n96"].'","'.$retr["n97"].'","'.$retr["n98"].'","'.$retr["n99"].'","'.$retr["v1"].'","'.$retr["v2"].'","'.$retr["v3"].'","'.$retr["v4"].'","'.$retr["v5"].'","'.$retr["v6"].'","'.$retr["v7"].'","'.$retr["v8"].'","'.$retr["v9"].'","'.$retr["v11"].'","'.$retr["v12"].'","'.$retr["v13"].'","'.$retr["v14"].'","'.$retr["v15"].'","'.$retr["v16"].'","'.$retr["v17"].'","'.$retr["v18"].'","'.$retr["v19"].'","'.$retr["v21"].'","'.$retr["v22"].'","'.$retr["v23"].'","'.$retr["v24"].'","'.$retr["v25"].'","'.$retr["v26"].'","'.$retr["v27"].'","'.$retr["v28"].'","'.$retr["v29"].'","'.$retr["v31"].'","'.$retr["v32"].'","'.$retr["v33"].'","'.$retr["v34"].'","'.$retr["v35"].'","'.$retr["v36"].'","'.$retr["v37"].'","'.$retr["v38"].'","'.$retr["v39"].'","'.$retr["v41"].'","'.$retr["v42"].'","'.$retr["v43"].'","'.$retr["v44"].'","'.$retr["v45"].'","'.$retr["v46"].'","'.$retr["v47"].'","'.$retr["v48"].'","'.$retr["v49"].'","'.$retr["v51"].'","'.$retr["v52"].'","'.$retr["v53"].'","'.$retr["v54"].'","'.$retr["v55"].'","'.$retr["v56"].'","'.$retr["v57"].'","'.$retr["v58"].'","'.$retr["v59"].'","'.$retr["v61"].'","'.$retr["v62"].'","'.$retr["v63"].'","'.$retr["v64"].'","'.$retr["v65"].'","'.$retr["v66"].'","'.$retr["v67"].'","'.$retr["v68"].'","'.$retr["v69"].'","'.$retr["v71"].'","'.$retr["v72"].'","'.$retr["v73"].'","'.$retr["v74"].'","'.$retr["v75"].'","'.$retr["v76"].'","'.$retr["v77"].'","'.$retr["v78"].'","'.$retr["v79"].'","'.$retr["v81"].'","'.$retr["v82"].'","'.$retr["v83"].'","'.$retr["v84"].'","'.$retr["v85"].'","'.$retr["v86"].'","'.$retr["v87"].'","'.$retr["v88"].'","'.$retr["v89"].'","'.$retr["v91"].'","'.$retr["v92"].'","'.$retr["v93"].'","'.$retr["v94"].'","'.$retr["v95"].'","'.$retr["v96"].'","'.$retr["v97"].'","'.$retr["v98"].'","'.$retr["v99"].'")');


?>

<script>top.frames['online'].location='ch.php?online='+Math.round(Math.random()*100000);</script>
<?
mysql_query("DELETE FROM `vxod` WHERE `login`='$login'");
mysql_query("DELETE FROM `vxod` WHERE `glav_id`=".$user['id']."");
mysql_query("DELETE FROM `vxod` WHERE `login`='$login'");
print "<script>location.href='canalizaciyag.php'</script>";
exit;
}
}
?>

<TD nowrap valign=top><HTML>


<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px; white-space: nowrap;"></div>

</HTML>
<BR><DIV align=right><INPUT style="font-size:12px;" type='button' onClick="var f;if( f=document.getElementById('REQUEST')){f.action+='#e1';f.submit()} else{location='vxodg.php'}" value=Обновить>

<INPUT style="font-size:12px;" type='button' onClick="location='city.php?bps=1'" value=Вернуться><br>
</DIV></TD>
</TR>
</TABLE>
</BODY>
</HTML>
<?
}
?>
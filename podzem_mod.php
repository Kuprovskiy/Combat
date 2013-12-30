<?
function useteleport($n) {
  include "podzem/teleports.php";
  mq("UPDATE `labirint` SET `name` = '".$teleports[$n]["name"]."',`location`='".$teleports[$n]["location"]."',`vector`='".$teleports[$n]["vector"]."',`l`='".$teleports[$n]["l"]."',`t`='".$teleports[$n]["t"]."' WHERE `user_id` ='$_SESSION[uid]'");
  print "<script>location.href='main.php?act=none'</script>";
  die;  
}

$rs=mysql_query("select * from labirint where user_id='".$_SESSION['uid']."'");
$t=mysql_fetch_array($rs);


$f = mysql_query("SELECT * FROM podzem3 WHERE glava='$glava' and name='".$t['name']."'");
while($rt = mysql_fetch_array($f)) {

  if($vector=='0'){$loc4=$location+30;}
  if($vector=='0'){$loc3=$location+20;}
  if($vector=='0'){$loc2=$location+10;}

  if($vector=='180'){$loc4=$location-30;}
  if($vector=='180'){$loc3=$location-20;}
  if($vector=='180'){$loc2=$location-10;}

  if($vector=='90'){$loc4=$location+3;}
  if($vector=='90'){$loc3=$location+2;}
  if($vector=='90'){$loc2=$location+1;}

  if($vector=='270'){$loc4=$location-3;}
  if($vector=='270'){$loc3=$location-2;}
  if($vector=='270'){$loc2=$location-1;}

  $mesto = $location;
  if($location == '01'){$mesto = '1';}
  if($location == '02'){$mesto = '2';}
  if($location == '03'){$mesto = '3';}
  if($location == '04'){$mesto = '4';}
  if($location == '05'){$mesto = '5';}
  if($location == '06'){$mesto = '6';}
  if($location == '07'){$mesto = '7';}
  if($location == '08'){$mesto = '8';}
  if($location == '09'){$mesto = '9';}

  include"podzem/raschet_bot.php";
  ////////////////////////////////////////////////
  //////////////Объекты////////////////
  if (substr($repa["n$mesto"],0,3)=="obj") {
    $obj=explode("-",$repa["n$mesto"]);
    if ($obj["1"]=="tpt") useteleport($obj[2]);
  }

  if($repa["n$mesto"]=='teleport' || $repa["n$mesto"]=='teleport3') {
    mysql_query("UPDATE `labirint` SET `name` = 'Канализация 2 этаж',`location`='24',`vector`='90',`l`='430',`t`='214' WHERE `user_id` = '{$_SESSION['uid']}'");
    print "<script>location.href='main.php?act=none'</script>";
    exit;
  }

  if($repa["n$mesto"]=='teleport2'){                                              //,`vector`='90',`l`='430',`t`='214'
    mysql_query("UPDATE `labirint` SET `name` = 'Канализация 3 этаж',`location`='78',`vector`='180',`l`='478',`t`='154'  WHERE `user_id` = '{$_SESSION['uid']}'");
    print "<script>location.href='main.php?act=none'</script>";
    exit;
  }


  if($repa["n$mesto"]=='teleport1'){
    mysql_query("UPDATE `labirint` SET `name` = 'Канализация 1 этаж',`location`='47',`vector`='270',`l`='465',`t`='190' WHERE `user_id` = '{$_SESSION['uid']}'");
    print "<script>location.href='main.php?act=none'</script>";
    exit;
  }

  if($repa["n$mesto"]=='20'){
    mysql_query("UPDATE `users`,`online` SET `users`.`room` = '404',`online`.`room` = '404' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
    print "<script>location.href='main.php?act=none'</script>";
    exit;
  }

  if($repa["n$loc2"]=='20' and $vector==$repa["v$loc2"]){
    $s.='<div style="position:absolute; left:60px; top:34px;"><img src="'.IMGBASE.'/labirint3/sclad.gif" width="255" border="0" height="172" alt="Бывший склад мартына."></div>';
  }

  if($repa["n$loc3"]=='20' and $vector==$repa["v$loc3"]){
    $s.='<div style="position:absolute; left:107px; top:55px;"><img src="'.IMGBASE.'/labirint3/sclad2.jpg" width="162" border="0" height="110" alt="Бывший склад мартына."></div>';
  }

  if($repa["n$loc4"]=='20' and $vector==$repa["v$loc4"]){
    $s.='<div style="position:absolute; left:130px; top:66px;"><img src="'.IMGBASE.'/labirint3/sclad3.jpg" width="117" border="0" height="80" alt="Бывший склад мартына."></div>';
  }

  if($repa["n$loc2"]=='el' and $vector==$repa["v$loc2"]){
    $s.='<div style="position:absolute; left:150px; top:115px;"><a href="?act=el"><img src="'.IMGBASE.'/labirint3/zel.gif" width="80" border="0" height="80" alt="Зелье"></a></div>';
  }

  if($repa["n$loc3"]=='el' and $vector==$repa["v$loc3"]){
    $s.='<div style="position:absolute; left:165px; top:115px;"><img src="'.IMGBASE.'/labirint3/zel.gif" width="50" border="0" height="50" alt="Зелье"></div>';
  }

  if($repa["n$loc2"]=='teleport' and $vector==$repa["v$loc2"]){
    $s.='<div style="position:absolute; left:150px; top:115px;"><img src="'.IMGBASE.'/labirint3/telep.gif" width="80" border="0" height="80" alt="Телепорт"></div>';
  }

  if($repa["n$loc2"]=='teleport3' and $vector==90){
    $s.='<div style="position:absolute; left:150px; top:115px;"><img src="'.IMGBASE.'/labirint3/telep.gif" width="80" border="0" height="80" alt="Телепорт на 2 этаж"></div>';
  }

  if($repa["n$loc3"]=='teleport' and $vector==$repa["v$loc3"]){
    $s.='<div style="position:absolute; left:165px; top:115px;"><img src="'.IMGBASE.'/labirint3/telep.gif" width="50" border="0" height="50" alt="Телепорт"></div>';
  }
  //////////////////2etaz/////////////

  if($repa["n$loc2"]=='teleport1' and $vector==$repa["v$loc2"]){
    $s.='<div style="position:absolute; left:150px; top:115px;"><img src="'.IMGBASE.'/labirint3/telep.gif" width="80" border="0" height="80" alt="Телепорт на 1 Этаж"></div>';
  }

  if($repa["n$loc2"]=='teleport2' and $vector==180){
    $s.='<div style="position:absolute; left:150px; top:115px;"><img src="'.IMGBASE.'/labirint3/telep.gif" width="80" border="0" height="80" alt="Телепорт на 3 Этаж"></div>';
  }

  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  if(($repa["n$mesto"]=='11.1' or $repa["n$mesto"]=='11.0') and $vector==$repa["v$mesto"]){
    $s.='<div qonmouseout="closeMenu();" style="position:absolute; left:180px; top:165px;"><img src="'.IMGBASE.'/labirint3/1/kanal.gif" width="40" height="40" border="0" alt="Водосток" style="CURSOR:pointer;" onClick="stok('.$mesto.');"></div>';
  }

  if(($repa["n$loc2"]=='11.1' or $repa["n$loc2"]=='11.0') and $vector==$repa["v$loc2"]){
    $s.='<div  style="position:absolute; left:180px; top:140px;"><img src="'.IMGBASE.'/labirint3/1/kanal.gif" width="25" height="25" border="0" alt="Водосток"></div>';
  }

  if(($repa["n$loc3"]=='11.1' or $repa["n$loc3"]=='11.0') and $vector==$repa["v$loc3"]){
    $s.='<div  style="position:absolute; left:182px; top:130px;"><img src="'.IMGBASE.'/labirint3/1/kanal.gif" width="15" height="15" border="0" alt="Водосток"></div>';
  }

  if(($repa["n$loc4"]=='11.1' or $repa["n$loc4"]=='11.0') and $vector==$repa["v$loc4"]){
    $s.='<div  style="position:absolute; left:182px; top:125px;"><img src="'.IMGBASE.'/labirint3/1/kanal.gif" width="10" height="10" border="0" alt="Водосток"></div>';
  }

  /////////////
  if(($repa["n$loc2"]=='12.1' or $repa["n$loc2"]=='12.0') and $vector==$repa["v$loc2"]){
    $s.='<div qonmouseout="closeMenu();" style="position:absolute; left:160px; top:170px;"><img src="'.IMGBASE.'/labirint3/1/stok.gif" width="60" height="15" border="0" alt="Водосток" style="CURSOR:pointer;" onClick="stok2('.$loc2.');"></div>';
  }

  if(($repa["n$loc3"]=='12.1' or $repa["n$loc3"]=='12.0') and $vector==$repa["v$loc3"]){
    $s.='<div  style="position:absolute; left:175px; top:150px;"><img src="'.IMGBASE.'/labirint3/1/stok.gif" width="40" height="8" border="0" alt="Водосток"></div>';
  }

  if(($repa["n$loc4"]=='12.1' or $repa["n$loc4"]=='12.0') and $vector==$repa["v$loc4"]){
    $s.='<div  style="position:absolute; left:178px; top:138px;"><img src="'.IMGBASE.'/labirint3/1/stok.gif" width="20" height="5" border="0" alt="Водосток"></div>';
  }

  ////////////////klju4i/////////////////////////
  if($repa["n$mesto"]=='key1' or $repa["n$loc2"]=='key1' or $repa["n$loc3"]=='key1' or $repa["n$loc4"]=='key1'){$nomers='1';}
  if($repa["n$mesto"]=='key2' or $repa["n$loc2"]=='key2' or $repa["n$loc3"]=='key2' or $repa["n$loc4"]=='key2'){$nomers='2';}
  if($repa["n$mesto"]=='key3' or $repa["n$loc2"]=='key3' or $repa["n$loc3"]=='key3' or $repa["n$loc4"]=='key3'){$nomers='3';}
  if($repa["n$mesto"]=='key4' or $repa["n$loc2"]=='key4' or $repa["n$loc3"]=='key4' or $repa["n$loc4"]=='key4'){$nomers='4';}
  if($repa["n$mesto"]=='key5' or $repa["n$loc2"]=='key5' or $repa["n$loc3"]=='key5' or $repa["n$loc4"]=='key5'){$nomers='5';}
  if($repa["n$mesto"]=='key6' or $repa["n$loc2"]=='key6' or $repa["n$loc3"]=='key6' or $repa["n$loc4"]=='key6'){$nomers='6';}
  if($repa["n$mesto"]=='key7' or $repa["n$loc2"]=='key7' or $repa["n$loc3"]=='key7' or $repa["n$loc4"]=='key7'){$nomers='7';}
  if($repa["n$mesto"]=='key8' or $repa["n$loc2"]=='key8' or $repa["n$loc3"]=='key8' or $repa["n$loc4"]=='key8'){$nomers='8';}
  if($repa["n$mesto"]=='key9' or $repa["n$loc2"]=='key9' or $repa["n$loc3"]=='key9' or $repa["n$loc4"]=='key9'){$nomers='9';}
  if($repa["n$mesto"]=='key10' or $repa["n$loc2"]=='key10' or $repa["n$loc3"]=='key10' or $repa["n$loc4"]=='key10'){$nomers='10';}
  if ($_SERVER["REMOTE_ADDR"]=="127.0.0.1") {
    echo "n$mesto".$repa ["n$mesto"]."--$vector--".$repa["v$mesto"]."<br><br>";
    echo "--".$repa["v$mesto"]."--";
  }
  
  if (substr($repa["n$loc2"],0,3)=="obj" && $step1["fwd"]) {
    $tmp=explode("-",$repa["n$loc2"]);
    if ($tmp[1]=="tpt") echo "<div style=\"position:absolute; left:150px; top:115px;\"><img src=\"".IMGBASE."/labirint3/telep.gif\" width=\"80\" border=\"0\" height=\"80\" alt=\"Телепорт\"></div>";
  }
  
  if (strpos($repa["n$loc2"],"s")===0 && $step1["fwd"]) {
    $s.='<div  style="position:absolute; left:75px; top:25px;"><img src="'.IMGBASE.'/labirint3/surfaces/'.str_replace("s","",$repa["n$loc2"]).'.gif"></div>';
  }
  if(substr($repa["n$loc3"],0,3)=="obj" && $step2['fwd']){
    $tmp=explode("-",$repa["n$loc3"]);
    if ($tmp[1]=="tpt") echo "<div style=\"position:absolute; left:160px; top:110px;\"><img src=\"".IMGBASE."/labirint3/telep.gif\" width=\"60\" border=\"0\" height=\"60\" alt=\"Телепорт\"></div>";
  }
  if(substr($repa["n$loc4"],0,3)=="obj" && $step3['fwd']){
    $tmp=explode("-",$repa["n$loc4"]);
    if ($tmp[1]=="tpt") echo "<div style=\"position:absolute; left:170px; top:110px;\"><img src=\"".IMGBASE."/labirint3/telep.gif\" width=\"40\" border=\"0\" height=\"40\" alt=\"Телепорт\"></div>";
  }

  if(($repa["n$mesto"]=='key1' or $repa["n$mesto"]=='key2' or $repa["n$mesto"]=='key3' or $repa["n$mesto"]=='key4' or $repa["n$mesto"]=='key5' or $repa["n$mesto"]=='key6' or $repa["n$mesto"]=='key7' or $repa["n$mesto"]=='key8' or $repa["n$mesto"]=='key9' or $repa["n$mesto"]=='key10') and $vector==$repa["v$mesto"]){
    $s.='<div qonmouseout="closeMenu();" style="position:absolute; left:160px; top:165px;"><img src="'.IMGBASE.'/labirint3/'.$repa["n$mesto"].'.gif" width="60" height="60" border="0" alt="Ключ №'.$nomers.'" style="CURSOR:pointer;" onClick="key('.$mesto.','.$nomers.');"></div>';
  }
  if(($repa["n$loc2"]=='key1' or $repa["n$loc2"]=='key2' or $repa["n$loc2"]=='key3' or $repa["n$loc2"]=='key4' or $repa["n$loc2"]=='key5' or $repa["n$loc2"]=='key6' or $repa["n$loc2"]=='key7' or $repa["n$loc2"]=='key8' or $repa["n$loc2"]=='key9' or $repa["n$loc2"]=='key10') and $vector==$repa["v$loc2"]){
    $s.='<div  style="position:absolute; left:175px; top:140px;"><img src="'.IMGBASE.'/labirint3/'.$repa["n$loc2"].'.gif" width="40" height="40" border="0" alt="Ключ №'.$nomers.'"></div>';
  }
  if($step2['fwd'] and ($repa["n$loc3"]=='key1' or $repa["n$loc3"]=='key2' or $repa["n$loc3"]=='key3' or $repa["n$loc3"]=='key4' or $repa["n$loc3"]=='key5' or $repa["n$loc3"]=='key6' or $repa["n$loc3"]=='key7' or $repa["n$loc3"]=='key8' or $repa["n$loc3"]=='key9' or $repa["n$loc3"]=='key10') and $vector==$repa["v$loc3"]){
    $s.='<div  style="position:absolute; left:175px; top:130px;"><img src="'.IMGBASE.'/labirint3/'.$repa["n$loc3"].'.gif" width="25" height="25" border="0" alt="Ключ №'.$nomers.'"></div>';
  }
  if($step3['fwd'] and ($repa["n$loc4"]=='key1' or $repa["n$loc4"]=='key2' or $repa["n$loc4"]=='key3' or $repa["n$loc4"]=='key4' or $repa["n$loc4"]=='key5' or $repa["n$loc4"]=='key6' or $repa["n$loc4"]=='key7' or $repa["n$loc4"]=='key8' or $repa["n$loc4"]=='key9' or $repa["n$loc4"]=='key10') and $vector==$repa["v$loc4"]){
    $s.='<div  style="position:absolute; left:182px; top:125px;"><img src="'.IMGBASE.'/labirint3/'.$repa["n$loc4"].'.gif" width="15" height="15" border="0" alt="Ключ №'.$nomers.'"></div>';
  }
  
  

  if($step3['fwd'] and ($repa["n$loc4"]=='13.1' or $repa["n$loc4"]=='13.0')){
    $s.='<div  style="position:absolute; left:178px; top:120px;"><img src="'.IMGBASE.'/img/podzem/sun.gif" width="25" height="25" border="0" alt="Сундук"></div>';
  }
  if($step3['fwd'] and ($repa["n$loc4"]=='14.1' or $repa["n$loc4"]=='14.0')){
    $s.='<div  style="position:absolute; left:178px; top:120px;"><img src="'.IMGBASE.'/img/podzem/2.gif" width="25" height="25" border="0" alt="Сундук"></div>';
  }
  if($step3['fwd'] and ($repa["n$loc4"]=='15.0' || $repa["n$loc4"]=='15.1' || $repa["n$loc4"]=='15.2' || $repa["n$loc4"]=='15.3' || $repa["n$loc4"]=='15.4' || $repa["n$loc4"]=='16.1' || $repa["n$loc4"]=='16.0' || $repa["n$loc4"]=='17.0' || $repa["n$loc4"]=='17.1' || $repa["n$loc4"]=='17.2' || $repa["n$loc4"]=='18.1')){
    $s.='<div  style="position:absolute; left:178px; top:120px;"><img src="'.IMGBASE.'/img/podzem/2.gif" width="25" height="25" border="0" alt="Сундук"></div>';
  }
  //////////////////////3/////////////////////////
  if($step3['fwd'] and $rt["n$loc4"]!='') {
  if($k_b=='1'){
  $s.='<div style="position:absolute; left:165px; top:65px;"><img src="'.IMGBASE.'/labirint3/'.$ob.'.gif" width="50" height="85" title="'.$b_n.'"></div>';
  }
  if($k_b=='2'){
  $s.='<div style="position:absolute; left:140px; top:65px;"><img src="'.IMGBASE.'/labirint3/'.$ob.'.gif" width="50" height="85" title="'.$b_n.'"></div>';
  $s.='<div style="position:absolute; left:190px; top:65px;"><img src="'.IMGBASE.'/labirint3/'.$ob2.'.gif" width="50" height="85" title="'.$b_n2.'"></div>';
  }
  if($k_b=='3'){
  $s.='<div style="position:absolute; left:135px; top:70px;"><img src="'.IMGBASE.'/labirint3/'.$ob.'.gif" width="50" height="80" title="'.$b_n.'"></div>';
  $s.='<div style="position:absolute; left:190px; top:70px;"><img src="'.IMGBASE.'/labirint3/'.$ob3.'.gif" width="50" height="80" title="'.$b_n3.'"></div>';
  $s.='<div style="position:absolute; left:165px; top:80px;"><img src="'.IMGBASE.'/labirint3/'.$ob2.'.gif" width="50" height="80" title="'.$b_n2.'"></div>';
  }
  }
  $obraz11=mysql_fetch_array(mysql_query("SELECT user_id FROM `labirint` WHERE `glava`='$glava' LIMIT 1;"));
  global $mir;
  $rogs=mysql_query("SELECT labirint.login,labirint.location, users.shadow, users.sex FROM `labirint` left join users on labirint.user_id=users.id WHERE `glava`='$glava' and name='$mir[name]'");
  echo mysql_error();
  $i=0;
  while($mores=mysql_fetch_array($rogs)){
  //$obraz22=mysql_fetch_array(mysql_query("SELECT `shadow` FROM `users` WHERE `id` = '$mores[user_id]' LIMIT 1;"));
  $i++;
  $nus=mysql_num_rows($rogs);

  if($vector == 0){$lac = $location+30;}
  if($vector == 90){$lac = $location+3;}
  if($vector == 180){$lac = $location-30;}
  if($vector == 270){$lac = $location-3;}
  if($step3['fwd'] and $lac==$mores['location'] and $nus>=2) {
  if($nus==2){
  $l = '170';
  }
  if($nus==3){
  if($i==1){$l = '140';}
  if($i==2){$l = '170';}
  if($i==3){$l = '200';}
  }
  if($nus==4){
  if($i==1){$l = '140';}
  if($i==2){$l = '160';}
  if($i==3){$l = '180';}
  if($i==4){$l = '200';}
  }
  $s.='<div style="position:absolute; left:'.$l.'px; top:70px;"><img src="'.IMGBASE.'/i/shadow/'.$mores["sex"].'/'.$mores['shadow'].'" width="35" height="75" title="'.$mores['login'].'"></div>';
  }
  }
  if($step3['fwd'] and $repa["n$loc4"]>='1' and $repa["n$loc4"]<='10'){
    $s.='<div style="position:absolute; left:124px; top:66px;"><img src="'.IMGBASE.'/labirint3/rewet.gif" width="122" border="0" height="82" title="Решетка (нужен ключ №'.$repa["n$loc4"].')"></div>';
  }
  /////////////////////////////////////////////
  if($step2['fwd'] and ($repa["n$loc3"]=='13.1' or $repa["n$loc3"]=='13.0')){
    $s.='<div  style="position:absolute; left:170px; top:120px;"><img src="'.IMGBASE.'/img/podzem/sun.gif" width="40" height="40" border="0" alt="Сундук"></div>';
  }
  if($step2['fwd'] and ($repa["n$loc3"]=='14.1' or $repa["n$loc3"]=='14.0')){
    $s.='<div  style="position:absolute; left:170px; top:120px;"><img src="'.IMGBASE.'/img/podzem/2.gif" width="40" height="40" border="0" alt="Сундук"></div>';
  }
  if($step2['fwd'] and ($repa["n$loc3"]=='15.3' or $repa["n$loc3"]=='15.2' or $repa["n$loc3"]=='15.1' or $repa["n$loc3"]=='15.0' or $repa["n$loc3"]=='16.1' or $repa["n$loc3"]=='16.0' or $repa["n$loc3"]=='17.0' or $repa["n$loc3"]=='17.1' or $repa["n$loc3"]=='17.2' || $repa["n$loc3"]=='18.1')){
    $s.='<div  style="position:absolute; left:170px; top:120px;"><img src="'.IMGBASE.'/img/podzem/2.gif" width="40" height="40" border="0" alt="Сундук"></div>';
  }
  /////////////////////2///////////////////////
  if($step2['fwd'] and $rt["n$loc3"]!='') {

  if($k_b3=='1'){
  $s.='<div style="position:absolute; left:155px; top:60px;"><img src="'.IMGBASE.'/labirint3/'.$ob3.'.gif" width="65" height="110" title="'.$b_n3.'"></div>';
  }

  if($k_b3=='2'){
  $s.='<div style="position:absolute; left:120px; top:60px;"><img src="'.IMGBASE.'/labirint3/'.$ob3.'.gif" width="65" height="110" title="'.$b_n3.'"></div>';
  $s.='<div style="position:absolute; left:185px; top:60px;"><img src="'.IMGBASE.'/labirint3/'.$ob32.'.gif" width="65" height="110" title="'.$b_n32.'"></div>';
  }

  if($k_b3=='3'){
  $s.='<div style="position:absolute; left:115px; top:60px;"><img src="'.IMGBASE.'/labirint3/'.$ob3.'.gif" width="65" height="110" title="'.$b_n3.'"></div>';
  $s.='<div style="position:absolute; left:190px; top:60px;"><img src="'.IMGBASE.'/labirint3/'.$ob33.'.gif" width="65" height="110" title="'.$b_n33.'"></div>';
  $s.='<div style="position:absolute; left:155px; top:70px;"><img src="'.IMGBASE.'/labirint3/'.$ob32.'.gif" width="65" height="110" title="'.$b_n32.'"></div>';
  }
  }
  //$rogs=mysql_query("SELECT login,location FROM `labirint` WHERE `glava`='$glava'");
  //$rogs=mysql_query("SELECT labirint.login,labirint.location, users.shadow FROM `labirint` left join users on labirint.user_id=users.id WHERE `glava`='$glava'");
  mysql_data_seek($rogs,0);
  $i=0;
  while($mores=mysql_fetch_array($rogs)){
  $i++;
  $nus=mysql_num_rows($rogs);
  if($vector == 0){$lac = $location+20;}
  if($vector == 90){$lac = $location+2;}
  if($vector == 180){$lac = $location-20;}
  if($vector == 270){$lac = $location-2;}
  if($step2['fwd'] and $lac==$mores['location'] and $nus>=2) {
  if($nus==2){
  $l = '160';
  }
  if($nus==3){
  if($i==1){$l = '130';}
  if($i==2){$l = '160';}
  if($i==3){$l = '190';}
  }
  if($nus==4){
  if($i==1){$l = '120';}
  if($i==2){$l = '150';}
  if($i==3){$l = '180';}
  if($i==4){$l = '210';}
  }
  $s.='<div style="position:absolute; left:'.$l.'px; top:50px;"><img src="'.IMGBASE.'/i/shadow/'.$mores["sex"].'/'.$mores['shadow'].'" width="50" height="110" title="'.$mores['login'].'"></div>';
  }
  }
  if($step2['fwd'] and $repa["n$loc3"]>='1' and $repa["n$loc3"]<='10'){
  $s.='<div  style="position:absolute; left:103px; top:50px;"><img src="'.IMGBASE.'/labirint3/rewet.gif" width="172" border="0" height="120" alt="Решетка (нужен ключ №'.$repa["n$loc3"].')"></div>';
  $s.='<div style="position:absolute; left:124px; top:66px;"><img src="'.IMGBASE.'/labirint3/rewet.gif" width="122" border="0" height="82" alt="Решетка (нужен ключ №'.$repa["n$loc3"].')"></div>';
  }
  ///////////////////////////////////////////
  if($step1['fwd'] and ($repa["n$loc2"]=='13.1' or $repa["n$loc2"]=='13.0')){
    $s.='<div qonmouseout="closeMenu();" style="position:absolute; left:155px; top:130px;"><img src="'.IMGBASE.'/img/podzem/sun.gif" width="60" height="60" border="0" alt="Сундук" style="CURSOR:pointer;" onClick="sunduk('.$loc2.');"></div>';
  }
  if($step1['fwd'] and ($repa["n$loc2"]=='14.1' or $repa["n$loc2"]=='14.0')){
    $s.='<div qonmouseout="closeMenu();" style="position:absolute; left:155px; top:130px;"><img src="'.IMGBASE.'/img/podzem/2.gif" width="60" height="60" border="0" alt="Сундук" style="CURSOR:pointer;" onClick="sunduk2('.$loc2.');"></div>';
  }
  if($step1['fwd'] and ($repa["n$loc2"]=='15.3' or $repa["n$loc2"]=='15.2' or $repa["n$loc2"]=='15.1' or $repa["n$loc2"]=='15.0')){
    $s.='<div qonmouseout="closeMenu();" style="position:absolute; left:155px; top:130px;"><img src="'.IMGBASE.'/img/podzem/2.gif" width="60" height="60" border="0" alt="Сундук" style="CURSOR:pointer;" onClick="sunduk2('.$loc2.');"></div>';
  }
  if($step1['fwd'] and ($repa["n$loc2"]=='16.1' or $repa["n$loc2"]=='16.0' or $repa["n$loc2"]=='17.0' or $repa["n$loc2"]=='17.1' or $repa["n$loc2"]=='17.2' || $repa["n$loc2"]=='18.1')){
    $s.='<div qonmouseout="closeMenu();" style="position:absolute; left:155px; top:130px;"><img src="'.IMGBASE.'/img/podzem/2.gif" width="60" height="60" border="0" alt="Сундук" style="CURSOR:pointer;" onClick="sunduk2('.$loc2.');"></div>';
  }

  /////////////////////1/////////////////////
  if (strpos($rt["n$loc2"],"c")===0 && $step1['fwd']) {
    include "podzem/chardata.php";
    $char=str_replace("c","",$rt["n$loc2"]);
    if ($char==1) {
      $st=mqfa1("select step from quests where user='$_SESSION[uid]' and quest=11");
      if ($st>10) $char=3;
      if ($st>100) $char=4;
      if ($st>500) $char=5;
    }
    if ($char==2) {
      $st=mqfa1("select step from quests where user='$_SESSION[uid]' and quest=14");
      if ($st>10) $char=6;
      if ($st>100) $char=7;
      if ($st>500) $char=8;
    }
    if ($char==20667) {
        $s.='<div qonmouseout="closeMenu();" style="position:absolute; left:135px; top:40px;"><img src="'.IMGBASE.'/labirint3/chars/'.$char.'.gif" width="100" height="160" title="Слуга Валентая" style="CURSOR:pointer;" onClick="opendialog2('.$loc2.', event);"></div>';
    } else {
        $s.='<div qonmouseout="closeMenu();" style="position:absolute; left:135px; top:40px;"><img src="'.IMGBASE.'/labirint3/chars/'.$char.'.gif" width="100" height="160" title="'.$chardata[$char]["name"].'" style="CURSOR:pointer;" onClick="opendialog('.$loc2.', event);"></div>';
    }
  }

  if($step1['fwd'] and $rt["n$loc2"]!='') {
  if($k_b2=='1'){
    if($rt["n$loc2"]=='8'){
      $s.='<div qonmouseout="closeMenu();" style="position:absolute; left:135px; top:40px;"><img src="'.IMGBASE.'/labirint3/'.$ob2.'.gif" width="100" height="160" title="'.$b_n2.'" style="CURSOR:pointer;" onClick="Opendialog('.$loc2.', event);"></div>';
    }else{
      $s.='<div qonmouseout="closeMenu();" style="position:absolute; left:135px; top:40px;"><img src="'.IMGBASE.'/labirint3/'.$ob2.'.gif" width="100" height="160" title="'.$b_n2.'" style="CURSOR:pointer;" onClick="OpenMenu('.$loc2.', event);"></div>';
    }
  }
  if($k_b2=='2'){
  $s.='<div qonmouseout="closeMenu();" style="position:absolute; left:90px; top:40px;"><img src="'.IMGBASE.'/labirint3/'.$ob2.'.gif" width="100" height="160" title="'.$b_n2.'" style="CURSOR:pointer;" onClick="OpenMenu('.$loc2.', event);"></div>';
  $s.='<div qonmouseout="closeMenu();" style="position:absolute; left:180px; top:40px;"><img src="'.IMGBASE.'/labirint3/'.$ob22.'.gif" width="100" height="160" title="'.$b_n22.'" style="CURSOR:pointer;" onClick="OpenMenu('.$loc2.', event);"></div>';
  }
  if($k_b2=='3'){
  $s.='<div qonmouseout="closeMenu();" style="position:absolute; left:80px; top:40px;"><img src="'.IMGBASE.'/labirint3/'.$ob2.'.gif" width="100" height="160" title="'.$b_n2.'" style="CURSOR:pointer;" onClick="OpenMenu('.$loc2.', event);"></div>';
  $s.='<div qonmouseout="closeMenu();" style="position:absolute; left:195px; top:40px;"><img src="'.IMGBASE.'/labirint3/'.$ob23.'.gif" width="100" height="160" title="'.$b_n23.'" style="CURSOR:pointer;" onClick="OpenMenu('.$loc2.', event);"></div>';
  $s.='<div qonmouseout="closeMenu();" style="position:absolute; left:140px; top:60px;"><img src="'.IMGBASE.'/labirint3/'.$ob22.'.gif" width="100" height="160" title="'.$b_n22.'" style="CURSOR:pointer;" onClick="OpenMenu('.$loc2.', event);"></div>';
  }

  }
  //$rogs=mysql_query("SELECT login,location FROM `labirint` WHERE `glava`='$glava'");
  //$rogs=mysql_query("SELECT labirint.login,labirint.location, users.shadow FROM `labirint` left join users on labirint.user_id=users.id WHERE `glava`='$glava'");
  mysql_data_seek($rogs,0);
  $i=0;
  while($mores=mysql_fetch_array($rogs)){
  $i++;
  $nus=mysql_num_rows($rogs);
  if($vector == 0){$lac = $location+10;}
  if($vector == 90){$lac = $location+1;}
  if($vector == 180){$lac = $location-10;}
  if($vector == 270){$lac = $location-1;}
  if($step1['fwd'] and $lac==$mores['location'] and $nus>=2) {
  if($nus==2){
  $l = '150';
  }
  if($nus==3){
  if($i==1){$l = '90';}
  if($i==2){$l = '150';}
  if($i==3){$l = '180';}
  }
  if($nus==4){
  if($i==1){$l = '100';}
  if($i==2){$l = '140';}
  if($i==3){$l = '180';}
  if($i==4){$l = '210';}
  }
  $s.='<div style="position:absolute; left:'.$l.'px; top:40px;"><img src="'.IMGBASE.'/i/shadow/'.$mores["sex"].'/'.$mores['shadow'].'" width="75" height="160" title="'.$mores['login'].'"></div>';
  }

  }
  ////////////////////////////////////////
  if($step1['fwd'] and $repa["n$loc2"]>='1' and $repa["n$loc2"]<='10'){
  $s.='<div  style="position:absolute; left:50px; top:31px;"><img src="'.IMGBASE.'/labirint3/rewet.gif" width="265" border="0" height="180" alt="Решетка (нужен ключ №'.$repa["n$loc2"].')"></div>';
  $s.='<div  style="position:absolute; left:103px; top:50px;"><img src="'.IMGBASE.'/labirint3/rewet.gif" width="172" border="0" height="120" alt="Решетка (нужен ключ №'.$repa["n$loc2"].')"></div>';
  }

  $mesto = $location;
  if($location == '01'){$mesto = '1';}
  if($location == '02'){$mesto = '2';}
  if($location == '03'){$mesto = '3';}
  if($location == '04'){$mesto = '4';}
  if($location == '05'){$mesto = '5';}
  if($location == '06'){$mesto = '6';}
  if($location == '07'){$mesto = '7';}
  if($location == '08'){$mesto = '8';}
  if($location == '09'){$mesto = '9';}
  //////////////0-ja////////////////
  if($step1['fwd'] and $repa["n$mesto"]>='1' and $repa["n$mesto"]<='10'){
  $s.='<div  style="position:absolute; left:55px; top:31px;"><img src="'.IMGBASE.'/labirint3/rewet.gif" width="265" border="0" height="180" alt="Решетка (нужен ключ №'.$repa["n$mesto"].')"></div>';
  }


}

?>

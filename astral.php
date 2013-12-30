<?php
session_start();
if ($_SESSION['uid'] == null) header("Location: index.php");

function star_sign($month, $day) {
 
	  if ($month == "01") { 
         if ($day >= 21) {return "11";} else {return "10";}}
      else if ($month == "02") {
         if ($day >= 21) {return "12";} else {return "11";} }
       else if ($month == "03") {
         if ($day >= 21) {return "1";} else {return "12";} }
       else if ($month == "04") {
         if ($day >= 21) {return "2";} else {return "1";} }
       else if ($month == "05") {
         if ($day >= 21) {return "3";} else {return "2";} }
       else if ($month == "06") {
         if ($day >= 22) {return "4";} else {return "3";} }
       else if ($month == "07") {
         if ($day >= 23) {return "5";} else {return "4";} }
       else if ($month == "08") {
	     if ($day >= 24) {return "6";} else {return "5";} }
       else if ($month == "09") {
         if ($day >= 24) {return "7";} else {return "6";} }
       else if ($month == "10") {
         if ($day >= 24) {return "8";} else {return "7";} }
       else if ($month == "11") {
         if ($day >= 23) {return "9";} else {return "8";} }
       else if ($month == "12") {
         if ($day >= 22) {return "10";} else {return "9";}}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$shans = rand(1,100);

if($user['battle']!=0 and $shans<'50' and $user['udar']>=1){

$effs = mysql_fetch_array(mq("SELECT * FROM `effects` WHERE `owner` = '".$user['id']."' AND `type` = '400' AND `isp`='0'"));

if($effs){
///////////
//if($effs['stihiya']=='ogon'){$bosa = "Огненная Элементаль (проекция)"; $bid = "15";}//id bota
//if($effs['stihiya']=='voda'){$bosa = "Водная Элементаль (проекция)"; $bid = "19";}//id bota
//if($effs['stihiya']=='vozduh'){$bosa = "Воздушная Элементаль (проекция)"; $bid = "23";}//id bota
//if($effs['stihiya']=='zemlya'){$bosa = "Земная Элементаль (проекция)"; $bid = "24";}//id bota

if($effs['stihiya']=='ogon'){$bosa = "Огненная Элементаль (проекция)"; $bid = "103";}//id bota
if($effs['stihiya']=='voda'){$bosa = "Водная Элементаль (проекция)"; $bid = "102";}//id bota
if($effs['stihiya']=='vozduh'){$bosa = "Воздушная Элементаль (проекция)"; $bid = "101";}//id bota
if($effs['stihiya']=='zemlya'){$bosa = "Земная Элементаль (проекция)"; $bid = "100";}//id bota
///////////

$nom = star_sign(substr($user['borndate'],3,2), substr($user['borndate'],0,2));
/*if($effs['stihiya']=='ogon' and ($nom == 5 or $nom == 9 or $nom == 1) or 
$effs['stihiya']=='voda' and ($nom == 4 or $nom == 8 or $nom == 12) or 
$effs['stihiya']=='vozduh' and ($nom == 3 or $nom == 7 or $nom == 11) or 
$effs['stihiya']=='zemlya' and ($nom == 2 or $nom == 6 or $nom == 10))
*/{
///////////
mq("UPDATE `effects` SET `isp` = '1' WHERE `id`='".$effs['id']."' AND `owner` = '{$_SESSION['uid']}' LIMIT 1;");

mq("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('".$bosa."','".$bid."','".$user['battle']."','900');");
		$bot = mysql_insert_id();
		
		$bd = mysql_fetch_array(mq ('SELECT * FROM `battle` WHERE `id` = '.$user['battle'].' LIMIT 1;'));
		$battle = unserialize($bd['teams']);
		$battle[$bot] = $battle[$user['id']];
		foreach($battle[$bot] as $k => $v) {
			$battle[$k][$bot] = array(0,0,time());
		}
		$t1 = explode(";",$bd['t1']);		
		if (in_array ($user['id'],$t1)) {$ttt = 1;} else {	$ttt = 2;}					
		addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick5($bot,"B".$ttt).' вмешался впоединок за '.nick5($user['id'],"B".$ttt).'<BR>');
					
		mq('UPDATE `battle` SET `teams` = \''.serialize($battle).'\', `t'.$ttt.'`=CONCAT(`t'.$ttt.'`,\';'.$bot.'\')  WHERE `id` = '.$user['battle'].' ;');
		
		mq("UPDATE `battle` SET `to1` = '".time()."', `to2` = '".time()."' WHERE `id` = ".$user['battle']." LIMIT 1;");
////////////////
}///////////////////////////////////////////////////////////////////против//////////////////////////////////////////////////////////
/*else{
///////////
mq("UPDATE `effects` SET `isp` = '1' WHERE `id`='".$effs['id']."' AND `owner` = '{$_SESSION['uid']}' LIMIT 1;");
mq("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('".$bosa."','".$bid."','".$user['battle']."','900');");
		$bot = mysql_insert_id();
		
		$bd = mysql_fetch_array(mq ('SELECT * FROM `battle` WHERE `id` = '.$user['battle'].' LIMIT 1;'));
		$battle = unserialize($bd['teams']);
		$battle[$bot] = $battle[$_POST['enemy']];
		foreach($battle[$bot] as $k => $v) {
			$battle[$k][$bot] = array(0,0,time());
		}
		$t1 = explode(";",$bd['t1']);		
		if (in_array ($_POST['enemy'],$t1)) {$ttt = 1;} else {	$ttt = 2;}					
		addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick5($bot,"B".$ttt).' вмешался впоединок за '.nick5($_POST['enemy'],"B".$ttt).'<BR>');
		mq('UPDATE `battle` SET `teams` = \''.serialize($battle).'\', `t'.$ttt.'`=CONCAT(`t'.$ttt.'`,\';'.$bot.'\')  WHERE `id` = '.$user['battle'].' ;');
		mq("UPDATE `battle` SET `to1` = '".time()."', `to2` = '".time()."' WHERE `id` = ".$user['battle']." LIMIT 1;");
////////////////
}*/
////////////////
}}
?>
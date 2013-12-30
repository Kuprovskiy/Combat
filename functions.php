<?
include_once "connect.php";
define("ADDICTIONEFFECT", 32);
define("HPADDICTIONEFFECT", 33);
define("MANAADDICTIONEFFECT", 34);
define("TRAVMARESISTANCE", 35);
define("TRAVMARESISTANCE2", 38);
define("LIGHTSTEPS", 40);
define("CAVEEFFECT", 60);
define("NYBLESSING", 61);
define("MAKESNOWBALL", 62);
define("FORGOTTENMASTERS", 185);
define("PENALTY", 8);
define("CLANRESTRICTION", 9);
define("SELLABLEDROP", 3);
define("WARROOM", 70);
define("PROTFROMATTACK", 72);
$charstamfields=array(72);
function getuserdata($id=0) {
  if (!$id) $id=@$_SESSION["uid"];
  if (!$id) return array();
  if (!@$_SESSION["allchecked"]) {
    $_SESSION["allchecked"]=1;
    $r=mq("SELECT id FROM `allusers` WHERE `id` = '{$id}'");
    if (mysql_num_rows($r)==0) {
      mq("replace into allusers (select * from users where id='{$id}')");
    }
  }
  $rec=mqfa("SELECT * FROM `users` WHERE `id` = '{$id}'");
  $rec["data"]=getudata($id);
  if ($rec['hp']<=0 && incastle($rec["room"])) { 
    $siege=getvar("siege");
    if ($siege<10) {
      moveuser($id, 20);
      addchp ('<font color=red>Внимание!</font>Вы выбыли из битвы за клановый замок.', '{[]}'.$rec['login'].'{[]}');
      $rec["room"]=20;
    }
  }
  if ($rec["hp"]<$rec["maxhp"] && time()>$rec["fullhptime"] && !$rec["battle"] && $rec["in_tower"]<>62 && ($rec["hp"]>0 || canregendead($rec))) {
    regenhp($rec, 0);
    if ($rec["hp"]==$rec["maxhp"]) $rec["hp"]--;
  }  
  return $rec;
}
if (!@$user) $user=getuserdata();
if (isset($user['hp']) && $user['hp']<=0 && incastle($user["room"])) { 
  $siege=getvar("siege");
  if ($siege<10) {
    addchp ('<font color=red>Внимание!</font>Вы выбыли из битвы за клановый замок.', '{[]}'.$user['login'].'{[]}');
    gotoroom(49,0);
  }
}
if (isset($user['hp']) && $user['hp']<=0 && $user["room"]==63) {
  outoffield($user["id"]);
}
if ($user["prison"]) {
  $fn=str_replace("/","",$_SERVER["PHP_SELF"]);
  if ($fn!="jail.php") {
    header("location: jail.php");
    die;
  }
}
if(!function_exists("format_string")) {
function format_string(&$string)
   {
 $string=str_replace("\\n","<BR>",$string);
 $string = addslashes(preg_replace(array('/\s+/','/,+/','/\-+/','/\0/s','/%00/'), array(' ',',','-',' ',' '),trim(stripcslashes($string))));
 $string=str_replace("<BR>","\\n",$string);
   return $string;
   }
}
array_walk($_REQUEST,"format_string");
array_walk($_POST,"format_string");
array_walk($_GET,"format_string");
if (!empty($_SERVER['HTTP_CLIENT_IP']))   {
  $ip=$_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   {
  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
  $ip=$_SERVER['REMOTE_ADDR'];
}
if($user['block'] == 1) {
die();
}
function close_dangling_tags($html){
  preg_match_all("#<([a-z]+)( .*)?(?!/)>#iU",$html,$result);
  $openedtags=$result[1];
  preg_match_all("#</([a-z]+)>#iU",$html,$result);
  $closedtags=$result[1];
  $len_opened = count($openedtags);
  if(count($closedtags) == $len_opened){
    return $html;
  }
  $openedtags = array_reverse($openedtags);
  for($i=0;$i < $len_opened;$i++) {
    if (!in_array($openedtags[$i],$closedtags)){
      $html .= '</'.$openedtags[$i].'>';
    } else {
      unset($closedtags[array_search($openedtags[$i],$closedtags)]);
    }
  }
  return $html;
}
if ($user["id"]) mq("UPDATE `online` SET `real_time` = ".time().", date = ".time()." WHERE `id` = {$user['id']};");
define('_BOTSEPARATOR_',10000000);
$exptable = array(
/*   stat,umen,vinos,hp,kred, level, up, spirit*/
"0" => array (0,0,0,0,0,20,0),
"20" => array (1,0,0,0,0,45,0),
"45" => array (1,0,0,1,0,75,0),
"75" => array (1,0,0,2,0,110,0),
"110" => array (3,1,1,40,1,160,0),
"160" => array (1,0,0,0,0,215,0),
"215" => array (1,0,0,1,0,280,0),
"280" => array (1,0,0,2,0,350,0),
"350" => array (1,0,0,4,0,410,0),
"410" => array (3,1,1,80,1,530,0),
"530" => array (1,0,0,0,0,670,0),
"670" => array (1,0,0,2,0,830,0),
"830" => array (1,0,0,4,0,950,0),
"950" => array (1,0,0,8,0,1100,0),
"1100" => array (1,0,0,12,0,1300,0),
"1300" => array (3,1,1,160,1,1450,0),
"1450" => array (1,0,0,1,0,1650,0),
"1650" => array (1,0,0,5,0,1850,0),
"1850" => array (1,0,0,10,0,2050,0),
"2050" => array (1,0,0,15,0,2200,0),
"2200" => array (1,0,0,20,0,2500,0),
"2500" => array (5,1,1,200,1,2900,0),
"2900" => array (1,0,0,3,0,3350,0),
"3350" => array (1,0,0,10,0,3800,0),
"3800" => array (1,0,0,15,0,4200,0),
"4200" => array (1,0,0,20,0,4600,0),
"4600" => array (1,0,0,25,0,5000,0),
"5000" => array (3,1,1,250,1,6000,0),
"6000" => array (1,0,0,6,0,7000,0),
"7000" => array (1,0,0,20,0,8000,0),
"8000" => array (1,0,0,30,0,9000,0),
"9000" => array (1,0,0,40,0,10000,0),
"10000" => array (1,0,0,40,0,11000,0),
"11000" => array (1,0,0,40,0,12000,0),
"12000" => array (1,0,0,50,0,12500,0),
"12500" => array (3,1,1,300,1,14000,0),
"14000" => array (1,0,0,9,0,15500,0),
"15500" => array (1,0,0,25,0,17000,0),
"17000" => array (1,0,0,45,0,19000,0),
"19000" => array (1,0,0,45,0,21000,0),
"21000" => array (1,0,0,45,0,23000,0),
"23000" => array (1,0,0,55,0,27000,0),
"27000" => array (1,0,0,45,0,30000,0),
"30000" => array (5,1,1,350,1,60000,0),
"60000" => array (1,0,0,1,0,75000,0),
"75000" => array (1,0,0,100,0,150000,0),
"150000" => array (1,0,0,150,0,175000,0),
"175000" => array (1,0,0,50,0,200000,0),
"200000" => array (1,0,0,100,0,225000,0),
"225000" => array (1,0,0,50,0,250000,0),
"250000" => array (1,0,0,100,0,260000,0),
"260000" => array (1,0,0,50,0,280000,0),
"280000" => array (1,0,0,100,0,300000,0),
"300000" => array (5,1,1,500,1,400000,0),
"400000" => array (0,0,0,100,0,500000,0),
"500000" => array (0,0,0,100,0,600000,0),
"600000" => array (0,0,0,100,0,700000,0),
"700000" => array (0,0,0,100,0,800000,0),
"800000" => array (0,0,0,100,0,900000,0),
"900000" => array (0,0,0,100,0,1000000,0),
"1000000" => array (0,0,0,100,0,1100000,0),
"1100000" => array (0,0,0,100,0,1200000,0),
"1200000" => array (0,0,0,100,0,1500000,0),
"1500000" => array (1,0,0,500,0,1750000,0),
"1750000" => array (1,0,0,200,0,2000000,0),
"2000000" => array (1,0,0,300,0,2175000,0),
"2175000" => array (1,0,0,100,0,2300000,0),
"2300000" => array (1,0,0,100,0,2400000,0),
"2400000" => array (1,0,0,1,0,2500000,0),
"2500000" => array (1,0,0,200,0,2600000,0),
"2600000" => array (1,0,0,100,0,2800000,0),
"2800000" => array (1,0,0,200,0,3000000,0),
"3000000" => array (7,1,2,1000,1,6000000,0),
"6000000" => array (1,0,0,1,0,6500000,0),
"6500000" => array (1,0,0,200,0,7500000,0),
"7500000" => array (1,0,0,1,0,8500000,0),
"8500000" => array (1,0,0,250,0,9000000,0),
"9000000" => array (1,0,0,400,0,9250000,0),
"9250000" => array (1,0,0,50,0,9500000,0),
"9500000" => array (1,0,0,400,0,9750000,0),
"9750000" => array (1,0,0,350,0,9900000,0),
"9900000" => array (1,0,0,500,0,10000000,0),
"10000000" => array (9,1,3,2000,1,13000000,0),
"13000000" => array (2,0,0,200,0,14000000,0),
"14000000" => array (2,0,0,200,0,15000000,0),
"15000000" => array (2,0,0,200,0,16000000,0),
"16000000" => array (2,0,0,200,0,17000000,0),
"17000000" => array (2,0,0,200,0,17500000,0),
"17500000" => array (2,0,0,200,0,18000000,0),
"18000000" => array (2,0,0,200,0,19000000,0),
"19000000" => array (2,0,0,200,0,19500000,0),
"19500000" => array (2,0,0,200,0,20000000,0),
"20000000" => array (2,0,0,200,0,30000000,0),
"30000000" => array (2,0,1,250,0,32000000,0),
"32000000" => array (2,0,0,1,0,34000000,0),
"34000000" => array (2,0,0,250,0,35000000,0),
"35000000" => array (2,0,1,250,0,36000000,0),
"36000000" => array (2,0,0,250,0,38000000,0),
"38000000" => array (2,0,0,100,0,40000000,0),
"40000000" => array (2,0,1,150,0,42000000,0),
"42000000" => array (2,0,0,200,0,44000000,0),
"44000000" => array (2,0,0,250,0,45000000,0),
"45000000" => array (2,0,1,300,0,46000000,0),
"46000000" => array (2,0,0,100,0,48000000,0),
"48000000" => array (2,0,0,200,0,50000000,0),
"50000000" => array (2,0,1,300,0,52000000,0),
"52000000" => array (10,1,5,1500,1,55000000,0),
"55000000" => array (1,0,1,500,0,60000000,1),
"60000000" => array (1,0,1,700,0,65000000,1),
"65000000" => array (1,0,1,400,0,70000000,1),
"70000000" => array (1,0,1,450,0,75000000,1),
"75000000" => array (1,0,1,300,0,80000000,1),
"80000000" => array (1,0,1,350,0,85000000,1),
"85000000" => array (1,0,1,400,0,90000000,1),
"90000000" => array (1,0,1,450,0,95000000,1),
"95000000" => array (1,0,1,550,0,100000000,1),
"100000000" => array (5,0,5,600,0,120000000,5),
"120000000" => array (9,0,20,2000,1,130000000,6),
"130000000" => array (1,0,1,500,0,175000000,1),
"175000000" => array (1,0,1,500,0,220000000,1),
"220000000" => array (9,0,20,2200,1,300000000,6),
"300000000" => array (1,0,1,600,0,400000000,1),
);
  function statsat($nu) {
    global $exptable;
    $stats=0;
    $master=0;
    $vinos=0;
    $spirit=0;
    foreach ($exptable as $k=>$v) {
      if ($k==$nu) break;
      $stats+=$v[0];
      $master+=$v[1];
      $vinos+=$v[2];
      $spirit+=$v[6];
      $money+=$v[3];
    }
    return array("stats"=>$stats+12, "master"=>$master+1, "vinos"=>$vinos+3, "spirit"=>$spirit, "money"=>$money);
  }
  if ($user["nextup"] && $user['exp'] >= $user['nextup'] && !$user['in_tower'] && $user["id"]) {
    if ($user["nextup"]==125000000000 && $user["tol6"]) checkitemchange();
    if ($user["nextup"]!=12500000000 || $user["tol6"]) {
      if ($user["nextup"]==1250000000) mq("delete from inventory where owner='$user[id]' and prototype=6 limit 1");
      getadditdata($user);
      mq("UPDATE `users` SET `nextup` = ".$exptable[$user['nextup']][5].",`stats` = stats+".$exptable[$user['nextup']][0].",
      `master` = `master`+".$exptable[$user['nextup']][1].", `vinos` = `vinos`+".$exptable[$user['nextup']][2].",
      `spirit` = `spirit`+".$exptable[$user['nextup']][6].",
      `maxhp` = `maxhp`+".($exptable[$user['nextup']][2]*6).",
      `money` = `money`+'".$exptable[$user['nextup']][3]."',`level` = `level`+".$exptable[$user['nextup']][4]."
      WHERE `id` = '{$user['id']}'");
      mq("update userdata set `stats` = stats+".$exptable[$user['nextup']][0].",
      `master` = `master`+".$exptable[$user['nextup']][1].", `vinos` = `vinos`+".$exptable[$user['nextup']][2].",
      `spirit` = `spirit`+".$exptable[$user['nextup']][6]." WHERE `id` = '$user[id]'");
      if($exptable[$user['nextup']][4]) {
        if($user['sex']==0){$aa="ла";}addch("<img src=".IMGBASE."/i/magic/1x1.gif><font color=\"Black\"><B>{$user['login']}</B> достиг".$aa." уровня ".($user['level']+1)."!</font>");
		$tempt = array_keys($exptable);
                {           

}
if($exptable[$user['nextup']][4]==1 && $user['level']=='1')
                 {           
                  mysql_query("UPDATE `users` SET `money`=`money`+20 WHERE `id`='$user[refer]'");

mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$user['id']}','Получено 20 кр за реферала ',1,'".time()."');");

	$us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$user['refer']}' LIMIT 1;"));
         if($us[0]){
	addchp ('<font color=red>Внимание!</font> <font color=\"Black\">Персонаж <B>'.$user['login'].'</B> перешел на '.($user['level']+1).' уровень. Вам перечислено 20 кр.</font>   ','{[]}'.nick7 ($user['refer']).'{[]}');
	} else {
	   	  mysql_query("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$user['refer']."','','".'<font color=red>Внимание!</font> <font color=\"Black\">Персонаж <B>'.$user['login'].'</B> перешел на '.($user['level']+1).' уровень. Вам перечислено 20 кр.</font> '."')");
	}
}
if($exptable[$user['nextup']][4]==1 && $user['level']=='2')
                 {           
                  mysql_query("UPDATE `users` SET `money`=`money`+20 WHERE `id`='$user[refer]'");

mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$user['id']}','Получено 20 кр за реферала ',1,'".time()."');");

	$us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$user['refer']}' LIMIT 1;"));
         if($us[0]){
	addchp ('<font color=red>Внимание!</font> <font color=\"Black\">Персонаж <B>'.$user['login'].'</B> перешел на '.($user['level']+1).' уровень. Вам перечислено 20 кр.</font>   ','{[]}'.nick7 ($user['refer']).'{[]}');
	} else {
	   	  mysql_query("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$user['refer']."','','".'<font color=red>Внимание!</font> <font color=\"Black\">Персонаж <B>'.$user['login'].'</B> перешел на '.($user['level']+1).' уровень. Вам перечислено 20 кр.</font> '."')");
	}
}
if($exptable[$user['nextup']][4]==1 && $user['level']=='3')
                 {           
                  mysql_query("UPDATE `users` SET `money`=`money`+50 WHERE `id`='$user[refer]'");

mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$user['id']}','Получено 50 кр за реферала ',1,'".time()."');");

	$us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$user['refer']}' LIMIT 1;"));
         if($us[0]){
	addchp ('<font color=red>Внимание!</font> <font color=\"Black\">Персонаж <B>'.$user['login'].'</B> перешел на '.($user['level']+1).' уровень. Вам перечислено 50 кр.</font>   ','{[]}'.nick7 ($user['refer']).'{[]}');
	} else {
	   	  mysql_query("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$user['refer']."','','".'<font color=red>Внимание!</font> <font color=\"Black\">Персонаж <B>'.$user['login'].'</B> перешел на '.($user['level']+1).' уровень. Вам перечислено 50 кр.</font> '."')");
	}
}
if($exptable[$user['nextup']][4]==1 && $user['level']=='4')
                 {           
                  mysql_query("UPDATE `users` SET `money`=`money`+50 WHERE `id`='$user[refer]'");

mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$user['id']}','Получено 50 кр за реферала ',1,'".time()."');");

	$us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$user['refer']}' LIMIT 1;"));
         if($us[0]){
	addchp ('<font color=red>Внимание!</font> <font color=\"Black\">Персонаж <B>'.$user['login'].'</B> перешел на '.($user['level']+1).' уровень. Вам перечислено 50 кр.</font>   ','{[]}'.nick7 ($user['refer']).'{[]}');
	} else {
	   	  mysql_query("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$user['refer']."','','".'<font color=red>Внимание!</font> <font color=\"Black\">Персонаж <B>'.$user['login'].'</B> перешел на '.($user['level']+1).' уровень. Вам перечислено 50 кр.</font> '."')");
	}
}
if($exptable[$user['nextup']][4]==1 && $user['level']=='5')
                 {           
                  mysql_query("UPDATE `users` SET `money`=`money`+50 WHERE `id`='$user[refer]'");

mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$user['id']}','Получено 50 кр за реферала ',1,'".time()."');");

	$us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$user['refer']}' LIMIT 1;"));
         if($us[0]){
	addchp ('<font color=red>Внимание!</font> <font color=\"Black\">Персонаж <B>'.$user['login'].'</B> перешел на '.($user['level']+1).' уровень. Вам перечислено 50 кр.</font>   ','{[]}'.nick7 ($user['refer']).'{[]}');
	} else {
	   	  mysql_query("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$user['refer']."','','".'<font color=red>Внимание!</font> <font color=\"Black\">Персонаж <B>'.$user['login'].'</B> перешел на '.($user['level']+1).' уровень. Вам перечислено 50 кр.</font> '."')");
	}
}
if($exptable[$user['nextup']][4]==1 && $user['level']=='6')
                 {           
                  mysql_query("UPDATE `users` SET `money`=`money`+50 WHERE `id`='$user[refer]'");

mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$user['id']}','Получено 50 кр за реферала ',1,'".time()."');");

	$us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$user['refer']}' LIMIT 1;"));
         if($us[0]){
	addchp ('<font color=red>Внимание!</font> <font color=\"Black\">Персонаж <B>'.$user['login'].'</B> перешел на '.($user['level']+1).' уровень. Вам перечислено 50 кр.</font>   ','{[]}'.nick7 ($user['refer']).'{[]}');
	} else {
	   	  mysql_query("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$user['refer']."','','".'<font color=red>Внимание!</font> <font color=\"Black\">Персонаж <B>'.$user['login'].'</B> перешел на '.($user['level']+1).' уровень. Вам перечислено 50 кр.</font> '."')");
	}
}
if($exptable[$user['nextup']][4]==1 && $user['level']=='7')
                 {           
                  mysql_query("UPDATE `users` SET `money`=`money`+150 WHERE `id`='$user[refer]'");

mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$user['id']}','Получено 150 кр за реферала ',1,'".time()."');");

	$us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$user['refer']}' LIMIT 1;"));
         if($us[0]){
	addchp ('<font color=red>Внимание!</font> <font color=\"Black\">Персонаж <B>'.$user['login'].'</B> перешел на '.($user['level']+1).' уровень. Вам перечислено 150 кр.</font>   ','{[]}'.nick7 ($user['refer']).'{[]}');
	} else {
	   	  mysql_query("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$user['refer']."','','".'<font color=red>Внимание!</font> <font color=\"Black\">Персонаж <B>'.$user['login'].'</B> перешел на '.($user['level']+1).' уровень. Вам перечислено 150 кр.</font> '."')");
	}
      }
	  if($exptable[$user['nextup']][4]==1 && $user['level']=='8')
                 {           
                  mysql_query("UPDATE `users` SET `money`=`money`+500 WHERE `id`='$user[refer]'");

mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$user['id']}','Получено 500 кр за реферала ',1,'".time()."');");

	$us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$user['refer']}' LIMIT 1;"));
         if($us[0]){
	addchp ('<font color=red>Внимание!</font> <font color=\"Black\">Персонаж <B>'.$user['login'].'</B> перешел на '.($user['level']+1).' уровень. Вам перечислено 500 кр.</font>   ','{[]}'.nick7 ($user['refer']).'{[]}');
	} else {
	   	  mysql_query("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$user['refer']."','','".'<font color=red>Внимание!</font> <font color=\"Black\">Персонаж <B>'.$user['login'].'</B> перешел на '.($user['level']+1).' уровень. Вам перечислено 500 кр.</font> '."')");
	}
      }
	   if($exptable[$user['nextup']][4]==1 && $user['level']=='9')
                 {           
                  mysql_query("UPDATE `users` SET `money`=`money`+1000 WHERE `id`='$user[refer]'");

mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$user['id']}','Получено 1000 кр за реферала ',1,'".time()."');");

	$us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$user['refer']}' LIMIT 1;"));
         if($us[0]){
	addchp ('<font color=red>Внимание!</font> <font color=\"Black\">Персонаж <B>'.$user['login'].'</B> перешел на '.($user['level']+1).' уровень. Вам перечислено 1000 кр.</font>   ','{[]}'.nick7 ($user['refer']).'{[]}');
	} else {
	   	  mysql_query("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$user['refer']."','','".'<font color=red>Внимание!</font> <font color=\"Black\">Персонаж <B>'.$user['login'].'</B> перешел на '.($user['level']+1).' уровень. Вам перечислено 1000 кр.</font> '."')");
	}
      }
        
      }
    }
  }
  $testusers=array(13166, 13419, 14086, 14085, 14094, 14265, 14266, 14267, 14268, 14269, 14270, 14271, 15459, 15456, 15451, 15454, 15455, 15453, 15458, 15457);
  $djs=array();
  $nodrink=array("101", "102","103","104");
  $noattack=array();
  if ($user["id"]==3671) $noattackrooms=array();
  else $noattackrooms=array(WARROOM, 31, 35, 101, 102, 103, 104, 105, 402, 403, 404, 43, 45, 47, 48, 51, 52, 54, 56, 57, 58, 62, 63, 71, 301, 302,
  700, 701, 702, 703, 704, 705, 706, 707, 708, 709, 710, 711, 712, 713, 714, 715, 716, 717, 718, 719, 720, 721, 456,
  11111, 1300, 9000, 9001, 7777, 23);
  $dressslots = array('helm','naruchi','weap','rybax','bron','plaw','belt','sergi','kulon','r1','r2','r3','perchi','shit','leg','boots');
  $userslots = array('sergi','kulon','weap','r1','r2','r3','helm','perchi','shit','boots','m1','m2','m3','m4','m5','m6','m7','m8','m9','m10','naruchi','belt','leg','m11','m12','plaw','bron','rybax', 'p1', 'p2');
  $rooms = array ("Секретная Комната","Комната для новичков","Комната перехода","Бойцовский Клуб","Подземелье","Зал Воинов 1","Зал Воинов 2","Зал Воинов 3","Торговый зал",
  "Рыцарский зал","Башня рыцарей-магов","2 Этаж","Таверна","Астральные этажи","Огненный мир","Зал Паладинов","Совет Белого Братства","Зал Тьмы","Царство Тьмы","Будуар",
  "Центральная площадь","Страшилкина улица","Магазин","Ремонтная мастерская","Новогодняя елка","Комиссионный магазин","Парк развлечений","Почта","Регистратура кланов","Банк","Суд",
  "Башня смерти","Готический замок","Лабиринт хаоса","Цветочный магазин","Магазин Березка","Зал Стихий","Старинный Магазин","Готический замок - арсенал","Готический замок - внутренний двор",
  "Готический замок - мастерские","Готический замок - комнаты отдыха","Аукционный дом","Комната Знахаря",
  "Лагерь демонов","Парк развлечений","Бальный зал","Вход в ледяную пещеру","Ледяная пещера",
  "Страшилкина улица", "Клановый Замок", "Вход в Пещеру Ужаса", 51=>"Пещера Ужаса", "Пещера Ужаса",
  56=>"Вход в Пещеру кристаллов", 57=>"Пещера Кристаллов", 58=>"Поле Кладоискателей", 59=>"Книжный магазин",
  60=>"Вход в заброшенный дворец", 61=>"Заброшенный дворец", 62=>"Портал", 63=>"Поле битв",
  64=>"Вход в пещеру загадок", 65=>"Пещера загадок",
  70=>"Улица Вязов", 71=>"Вход в башню", 72=>"Подгорная Башня смерти", 
  73=>"Вход в катакомбы", 74=>"Катакомбы", 
  75=>"Вход в Потерянный вход", 76=>"Потерянный вход",
  77=>"Вход в Сторожевую башню", 78=>"Сторожевая Башня", 
  80=>"Магический круг", 81=>"Вершина горы",
  82=>"Вход в Бездну", 83 => "Бездна",
  "90"=>"Вход в ледяную пещеру", 91=>"Ледяная пещера",
  101=>"Общ. Этаж 1", 102=>"Общ. Этаж 2", 103=>"Общ. Этаж 3", 104=>"VIP-комната", 105=>"Общежитие",
  "200"=> "Турнир", 201=>"Гарем", 
 
"401"=> "Врата Ада",
// БС
"501" => "Восточная Крыша","502" => "Бойница","503" => "Келья 3","504" => "Келья 2","505" => "Западная Крыша 2","506" => "Келья 4","507" => "Келья 1",
"508" => "Служебная комната","509" => "Зал Отдыха 2","510" => "Западная Крыша 1","511" => "Выход на Крышу","512" => "Зал Статуй 2","513" => "Храм",
"514" => "Восточная комната","515" => "Зал Отдыха 1","516" => "Старый Зал 2","517" => "Старый Зал 1","518" => "Красный Зал 3","519" => "Зал Статуй 1",
"520" => "Зал Статуй 3","521" => "Трапезная 3","522" => "Зал Ожиданий","523" => "Оружейная","524" => "Красный Зал-Окна","525" => "Красный Зал",
"526" => "Гостинная","527" => "Трапезная 1","528" => "Внутренний Двор","529" => "Внутр.Двор-Вход","530" => "Желтый Коридор","531" => "Мраморный Зал 1",
"532" => "Красный Зал 2","533" => "Библиотека 1","534" => "Трапезная 2","535" => "Проход Внутр. Двора","536" => "Комната с Камином","537" => "Библиотека 3",
"538" => "Выход из Мрам.Зала","539" => "Красный Зал-Коридор","540" => "Лестница в Подвал 1","541" => "Южный Внутр. Двор","542" => "Трапезная 4",
"543" => "Мраморный Зал 3","544" => "Мраморный Зал 2","545" => "Картинная Галерея 1","546" => "Лестница в Подвал 2","547" => "Проход Внутр. Двора 2",
"548" => "Внутр.Двор-Выход","549" => "Библиотека 2","550" => "Картинная Галерея 3","551" => "Картинная Галерея 2","552" => "Лестница в Подвал 3",
"553" => "Терасса","554" => "Оранжерея","555" => "Зал Ораторов","556" => "Лестница в Подвал 4","557" => "Темная Комната","558" => "Винный Погреб",
"559" => "Комната в Подвале","560" => "Подвал",
"402" => "Вход в водосток","404" => "Магазин Луки","403" => "Заброшенная канализация","666" => "Тюрьма","667" => "Бар \"Пьяный Админ\" ",
"668" => "Зоомагазин",
"700"=>"Ворота замка","701"=>"Юго-западная башня","702"=>"Западная стена","703"=>"Северо-западная башня","704"=>"Северная стена",
"705"=>"Северо-восточная башня","706"=>"Восточная стена","707"=>"Юго-восточная башня", 708=>"Внутренний двор", 709=>"Внутренний двор - северная стена", 
710=>"Западная стена - крыша", 711=>"Восточная стена - крыша", 712=>"Юго-западная башня - крыша", 713=>"Северо-западная башня - крыша", 
714=>"Южная стена - крыша", 715=>"Юго-восточная башня - крыша", 716=>"Северо-восточная башня - крыша", 717=>"Северная стена - крыша", 
718=>"Обитель монахов", 719=>"Домик мага", 720=>"Харчевня", 721=>"Цветник", 457=>"Вход в Трясину",
1300=>"Памятник",
660=>"Парк развлечений",
650=>"Большая торговая улица",
800000=>"Улица Вязов",
2005=>"Вокзал",
100100=>"Стелла",
670=>"Новая земля",
2222=>"Церковь",
7777=>"Лотерея",
200001=>"Маленькая скамейка",
200002=>"Средняя скамейка",
200003=>"Большая скамейка",
393=>"Проклятый Холм",
9000=>"Храм знаний",
9001=>"Алтарь предметов",
9002=>"Алтарь рун",
21101012=>"Новогодний Магазин",
11111=>"Памятник Ангела"
);
  $canalrooms=array(403, 48, 52);
  $canalenters=array(402, 47, 51, 60, 64, 73, 75, 77, 82, 90, 301);
  $caverooms=array(302, 61, 65, 74, 76, 78, 83, 91);
  $battlefields=array(57, 63, 72);
  $battleenters=array(56, 71);
  header("Cache-Control: no-cache");
function getvar($v) { return mqfa1("select value from variables where var='$v'"); }
function setvar($var, $val) { mq("update variables set value='$val' where var='$var'"); }
function dresscond($user, $field="id") {
  global $dressslots;
  $ret="";
  foreach ($dressslots as $k=>$v) {
    if ($ret && !$user[$v]) continue;
    if ($ret) $ret.=" or ";
    $ret.="$field='$user[$v]'";
  }
  return $ret;
}
function getdressstats($user) {
  $cond=dresscond($user);
  return mqfa("select sum(gsila) as sila, sum(glovk) as lovk, sum(ginta) as inta, sum(gintel) as intel,
  sum(gmech) as mec, sum(gnoj) as noj, sum(gtopor) as topor, sum(gdubina) as dubina, sum(gposoh) as posoh,
  sum(gfire) as mfire, sum(gwater) as mwater, sum(gair) as mair, sum(gearth) as mearth,
  sum(glight) as mlight, sum(ggray) as mgray, sum(gdark) as mdark, sum(ghp) as hp, sum(gmana) as mana from inventory where $cond");
}
function adddressstats(&$d1, $d2) {
  $d1["sila"]+=$d2["sila"];
  $d1["lovk"]+=$d2["lovk"];
  $d1["inta"]+=$d2["inta"];
  $d1["intel"]+=$d2["intel"];
  $d1["mec"]+=$d2["mec"];
  $d1["noj"]+=$d2["noj"];
  $d1["topor"]+=$d2["topor"];
  $d1["dubina"]+=$d2["dubina"];
  $d1["posoh"]+=$d2["posoh"];
  $d1["mfire"]+=$d2["mfire"];
  $d1["mwater"]+=$d2["mwater"];
  $d1["mair"]+=$d2["mair"];
  $d1["mearth"]+=$d2["mearth"];
  $d1["mlight"]+=$d2["mlight"];
  $d1["mgray"]+=$d2["mgray"];
  $d1["mdark"]+=$d2["mdark"];
  $d1["vinos"]=(int)$d1["vinos"]+$d2["vinos"];
  $d1["mudra"]=(int)$d1["mudra"]+$d2["mudra"];
  $d1["spirit"]=(int)$d1["spirit"]+$d2["spirit"];
}
function nick_p ($user) {
    $id = $user['id'];
    ?>
<span id="HP" style="font-size:10px"></span>&nbsp;<img src="<?=IMGBASE?>/i/misc/bk_life_loose.gif" alt="Уровень жизни" name="HP1" width="1" height="8" id="HP1"><img src="<?=IMGBASE?>/i/misc/bk_life_loose.gif" alt="Уровень жизни" name="HP2" width="1" height="8" id="HP2"><span style="width:1px; height:10px"></span><img src="<?=IMGBASE?>/i/herz.gif" width="10" height="9" alt="Уровень жизни">
<? }
  function nick ($user) {
  $id = $user['id'];
  $effect = mysql_fetch_array(mq("SELECT `time` FROM `effects` WHERE `owner` = '{$id}' and `type` = '1022' LIMIT 1;"));
  if($effect) {
    $user['level'] = '??';
    $user['login'] = '</a><b><i>невидимка</i></b>';
    $user['align'] = '0';
    $user['klan'] = '';
    $user['id'] = '';
    $user['hp'] = '??';
    $user['maxhp'] = '??';
    $user['mana'] = '??';
    $user['maxmana'] = '??';
    }
    ?>
    <img src="<?=IMGBASE?>/i/align_<?echo ($user['align']>0 ? $user['align']:"0");?>.gif"><?php if ($user['klan'] <> '') { echo '<img title="'.$user['klan'].'" src="'.IMGBASE.'/i/klan/'.$user['klan'].'.gif">'; } ?><B><?=$user['login']?></B> [<?
    if (id==2236) echo "?"; else echo $user['level'];
    ?>]<a href=inf.php?<?=$user['id']?> target=_blank><IMG SRC=<?=IMGBASE?>/i/inf.gif WIDTH=12 HEIGHT=11 ALT="Инф. о <?=$user['login']?>"></a>
<span id="HP" style="font-size:10px"></span>&nbsp;<img src="<?=IMGBASE?>/i/misc/bk_life_loose.gif" alt="Уровень жизни" name="HP1" width="1" height="8" id="HP1"><img src="<?=IMGBASE?>/i/misc/bk_life_loose.gif" alt="Уровень жизни" name="HP2" width="1" height="8" id="HP2"><span style="width:1px; height:10px"></span><img src="<?=IMGBASE?>/i/herz.gif" width="10" height="9" alt="Уровень жизни">
<? }
function incastle($r) { return ($r>=700 && $r<800); }
function nick99 ($id) {
  global $user;
  if ($id==$user["id"]) $user1=$user;
  else $user1 = mysql_fetch_array(mq("SELECT fullhptime,fullmptime,hp,mana,id,battle,level,maxhp,maxmana,mudra,in_tower FROM `users` WHERE `id` = '".$id."' LIMIT 1;"));
  $id = $user1['id'];
  if (!isset($user1["data"])) $user1["data"]=getudata($id);
  if(!$user1['battle']){
    if ($user1["hp"]<0) mq("UPDATE `users` SET `hp` = '0' WHERE  `hp` < '0' AND `id` = '".$id."' LIMIT 1;");
    if ($user1["mana"]<0) mq("UPDATE `users` SET `mana` = '0' WHERE  `mana` < '0' AND `id` = '".$id."' LIMIT 1;");
    $owntravmadb=mq("SELECT type, id, sila, lovk, inta, intel, mudra, ghp, gmana, owner, name, isp, mfdhit, mfdmag, mfdkol, mfdrej, mfdrub, mfddrob, mfdfire, mfdair, mfdwater, mfdearth, time FROM effects WHERE (`time` <= ".time()."  or (`time` <= ".time()."+600 and isp=0) ) AND `owner` = ".$id.";");
    $he=0;
    $canremove=1;
    if (mysql_num_rows($owntravmadb)>0) {
      $i=mqfa1("select id from fieldmembers where user='$id'");
      if ($i) $canremove=0;
    } 
    if ($canremove) {
      while ($owntravma = mysql_fetch_array($owntravmadb)) {
        if (!$owntravma["isp"] && $owntravma["time"]>time()) {
          $mins=ceil(($owntravma["time"]-time())/60);
          if ($mins>0) addchp ('<font color=red>Внимание!</font> Через '.$mins.' мин. закончится действие эффекта <b>'.$owntravma["name"].'</b>', '{[]}'.nick7($id).'{[]}');
          mq("update effects set isp=1 where id='$owntravma[id]'");
          continue;
        }
        $he=1;
        if($owntravma['type']==31) {
          $magictime=time()+(365*60*1440); 
          mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`, mfdhit, mfdmag, mf, mfval) values ('".$id."','Просроченный кредит','$magictime',31, -500, -500, 'mfhitp/mfmagp', '-75/-75');");
          mq("update users set align=0, klan='' where id='$id'");
          mq("update userdata set align=0 where id='$id'");
          mq("update allusers set align=0, klan='' where id='$id'");
          mq("update alluserdata set align=0 where id='$id'");
        }
        if($owntravma['type']==22) {
          $magictime=time()+(365*60*1440); 
          mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".$id."','Путы','$magictime',10);");
          mq("UPDATE `users` SET `spellfreedom` ='0' WHERE  `id` = '".$id."' LIMIT 1;");
        }
        if ($owntravma["type"]==MAKESNOWBALL) {
          addchp ('<font color=red>Внимание!</font> Вы слепили снежок.', '{[]}'.nick7($id).'{[]}');
          takeshopitem(2345, "shop", 0, 0, 2, 0);
        } elseif ($owntravma['type']==54) {
          if (strpos($owntravma["name"], "Знание")) {
            if ($owntravma["name"]=="Тайное Знание (том 1)") $num=1;
            if ($owntravma["name"]=="Тайное Знание (том 2)") $num=2;
            if ($owntravma["name"]=="Тайное Знание (том 3)") $num=4;
            if ($owntravma["name"]=="Тайное Знание (том 4)") $num=8;
            if ($owntravma["name"]=="Рыцарское Знание (том 1)") $num=16;
            if ($owntravma["name"]=="Рыцарское Знание (том 2)") $num=32;
            if ($owntravma["name"]=="Рыцарское Знание (том 3)") $num=64;
            if ($owntravma["name"]=="Рыцарское Знание (том 4)") $num=128;
            if ($owntravma["name"]=="Тайное Знание (утерянный том)") $num=256;
            if ($owntravma["name"]=="Тайное Знание (секретный том)") $num=512;
            $slots=mqfa1("select slotbooks from userdata where id='$id'");
            if ($slots%($num*2)<$num) {
              if ($owntravma["name"]=="Тайное Знание (секретный том)") mq("update userdata set slots=slots+2 where id='$id'");
              else mq("update userdata set slots=slots+1 where id='$id'");
              mq("update userdata set slotbooks=slotbooks+$num where id='$id'");
              addchp ('<font color=red>Внимание!</font> Вы изучили <b>'.$owntravma["name"].'</b>.', '{[]}'.nick7($id).'{[]}');
            }
          } else {
            global $strokes;
            include_once("incl/strokedata.php");
            foreach ($strokes as $k=>$v) {
              $tmp=$v->name;
              $tmp=str_replace("[", "", $tmp);
              $tmp=str_replace("]", "", $tmp);
              $tmp=str_replace("0", "", $tmp);
              $tmp=str_replace("1", "", $tmp);
              $tmp=str_replace("2", "", $tmp);
              $tmp=str_replace("3", "", $tmp);
              $tmp=str_replace("4", "", $tmp);
              $tmp=str_replace("5", "", $tmp);
              $tmp=str_replace("6", "", $tmp);
              $tmp=str_replace("7", "", $tmp);
              $tmp=str_replace("8", "", $tmp);
              $tmp=str_replace("9", "", $tmp);
              $tmp=trim($tmp);
              if ($tmp==$owntravma["name"] && @$v->id_priem) {
                mq("insert into userstrokes (user, stroke) values ('$user1[id]', '$v->id_priem')");
              }
            }
            if ($owntravma["name"]=="Статика") {
              mq("insert into userstrokes (user, stroke) values ('$user1[id]', '256')");
              mq("insert into userstrokes (user, stroke) values ('$user1[id]', '257')");
              mq("insert into userstrokes (user, stroke) values ('$user1[id]', '258')");
            }
            addchp ('<font color=red>Внимание!</font> Вы изучили <b>'.$owntravma["name"].'</b> (приём).', '{[]}'.nick7($id).'{[]}');
          }                 
        } elseif ($owntravma["type"]==ADDICTIONEFFECT || $owntravma["type"]==HPADDICTIONEFFECT || $owntravma["type"]==MANAADDICTIONEFFECT) {
          remaddiction($id, $owntravma);
          addchp ('<font color=red>Внимание!</font> У вас прошло пагубное пристрастие.', '{[]}'.nick7($id).'{[]}');
        } else addchp ('<font color=red>Внимание!</font> Закончилось действие эффекта <b>'.$owntravma["name"].'</b>', '{[]}'.nick7($id).'{[]}');

        mq("DELETE FROM `effects` WHERE `id` = '".$owntravma['id']."' LIMIT 1;");
        if ($owntravma['type']==49 || $owntravma["type"]==26 || $owntravma["gmana"] || $owntravma["ghp"]) {
          resetmax($user1["id"]);
        }       

        if($owntravma['type']==21){
          mq("UPDATE `users` SET  `prison`='0', `room`='20' WHERE `id` = ".$owntravma['owner']." LIMIT 1;");
          mq("UPDATE `online` SET  `room`='20' WHERE `id` = ".$owntravma['owner']." LIMIT 1;");
        }

        if($owntravma['type']==11 or $owntravma['type']==12 or $owntravma['type']==13 or $owntravma['type']==14){
          mq("UPDATE `users` SET `sila`=`sila`+'".$owntravma['sila']."', `lovk`=`lovk`+'".$owntravma['lovk']."', `inta`=`inta`+'".$owntravma['inta']."' WHERE `id` = '".$owntravma['owner']."' LIMIT 1;");
        }

        if ($owntravma['type']==188 || $owntravma['type']==28 || $owntravma['type']==29) {
          if ($owntravma['time']!=1) addaddict($id, $owntravma);
          checkaddict($id, $owntravma);
        }

        if($owntravma['type']==188 || $owntravma['type']>395 || ($owntravma["type"]==187 && ($owntravma["sila"] || $owntravma["lovk"] || $owntravma["inta"] || $owntravma["intel"] || $owntravma["mudra"]))){
          mq("UPDATE `users` SET `sila`=`sila`-'".$owntravma['sila']."', `lovk`=`lovk`-'".$owntravma['lovk']."', `inta`=`inta`-'".$owntravma['inta']."', `intel`=`intel`-'".$owntravma['intel']."', `mudra`=`mudra`-'".$owntravma['mudra']."' WHERE `id` = '".$owntravma['owner']."' LIMIT 1;");
          if ($owntravma['mudra']) resetmax($owntravma['owner']);
        }

        if($owntravma['type']==1022){
          mq("UPDATE `users` SET  `invis`='0' WHERE `id` = ".$owntravma['owner']." LIMIT 1;");
        } elseif($owntravma['type']==1022 && $user1['battle']>0) {
          mq("UPDATE `users` SET  `invis`='0' WHERE `id` = ".$owntravma['owner']." LIMIT 1;");
      //  addlog($user1['battle'],"<span class=sysdate>".date("H:i")."</span> Закончилось действие эффекта <b>"невидимость"</b> для <b>".$user1['login']."</b><BR>");
        }

        if($owntravma['type']==4){
          mq("UPDATE `users` SET `align`='0' WHERE `id` = '".$owntravma['owner']."' LIMIT 1;");
          mq("UPDATE `userdata` SET `align`='0' WHERE `id` = '".$owntravma['owner']."' LIMIT 1;");
          mq("update deztow_realchars set align=0 where owner='".$owntravma['owner']."'");
        }
      }
    }
    if ($he) updeffects($id);

    getfeatures($user1);

    if (($user1["hp"]>0 || !$user1["in_tower"]) && $user1["hp"]<$user1["maxhp"] && $user["in_tower"]<>62) {
      if ($user1["hp"]==0 && incastle($user["room"])) {
        $s=mqfa1("select value from variables where var='siege'");
        if ($s<10) $noheal=1;
      }
      if (!@$noheal) { 
      
        /*if ($user1["sturdy"]==5) $mult=1.3;
        else $mult=$user1["sturdy"]*0.05+1;
        $he=haseffect($user1["data"], 28);
        if ($he!==false) {
          $mult*=0.04*$user1["data"]["effects"][$he]["addict"]+2;
        } elseif (haseffect($user1["data"], HPADDICTIONEFFECT)!==false) {
          getadditdata($user1);
          $mult=$mult/(addictval($user1["hpaddict"])*0.05+1);
        }*/
        regenhp($user1);
        /*$fulltime=timetoheal($user1);

        if($user1['maxhp']<=100){
          if ((time()-$user1['fullhptime'])/60 >= 1) {
            mq("UPDATE `users` SET `hp` = if(`hp`+(((".time()."-`fullhptime`)/60)*(`maxhp`/10)*$mult)<maxhp, `hp`+(((".time()."-`fullhptime`)/60)*(`maxhp`/10)*$mult),maxhp), `fullhptime` = ".time()." WHERE  `hp` < `maxhp` AND `id` = '".$id."'");
          }
        } else {
          mq("UPDATE `users` SET `hp` = if(`hp`+(((".time()."-`fullhptime`)/60)*(`maxhp`/10)*$mult)<maxhp, `hp`+(((".time()."-`fullhptime`)/60)*(`maxhp`/10)*$mult),maxhp), `fullhptime` = ".time()." WHERE  `hp` < `maxhp` AND `id` = '".$id."'");
        }*/
      }
    }

    if ($user1["mana"]<$user1["maxmana"]) {
      if ($user1["mudra"]>=100) $manamult=5;
      elseif ($user1["mudra"]>=75) $manamult=3.75;
      else $manamult=1;
      $manamult*=$user1["sane"]*0.05+1;
      $he=haseffect($user1["data"], 29);
      if ($he!==false) {
        $manamult*=0.01*$user1["data"]["effects"][$he]["addict"]+2;
      } elseif (haseffect($user1["data"], MANAADDICTIONEFFECT)!==false) {
        getadditdata($user1);
        $manamult=$manamult/(addictval($user1["manaaddict"])*0.05+1);
      }

      if($user1['maxmana']<=100) {
        if ((time()-$user1['fullmptime'])/60 >= 1) {
          mq("UPDATE `users` SET `mana` = if(`mana`+((".time()."-`fullmptime`)/60)*(`maxmana`/10)*$manamult<maxmana, `mana`+((".time()."-`fullmptime`)/60)*(`maxmana`/10)*$manamult, maxmana), `fullmptime` = ".time()." WHERE  `mana` < `maxmana` AND `id` = '".$id."' LIMIT 1;");
        }
      } else {
        mq("UPDATE `users` SET `mana` = if(`mana`+((".time()."-`fullmptime`)/60)*(`maxmana`/10)*$manamult<maxmana, `mana`+((".time()."-`fullmptime`)/60)*(`maxmana`/10)*$manamult, maxmana), `fullmptime` = ".time()." WHERE  `mana` < `maxmana` AND `id` = '".$id."' LIMIT 1;");
      }
    }
  }
  if ($user1["hp"]>$user1["maxhp"]) mq("UPDATE `users` SET `hp` = `maxhp`, `fullhptime` = ".time().", s_duh='1000'  WHERE  `hp` > `maxhp` AND `id` = '".$id."' LIMIT 1;");
  if ($user1["mana"]>$user1["maxmana"]) mq("UPDATE `users` SET `mana` = `maxmana`, `fullmptime` = ".time()." WHERE  `mana` > `maxmana` AND `id` = '".$id."' LIMIT 1;");
}


// nick
function nick2 ($id, $showinvis=1) {
    if($id > _BOTSEPARATOR_) {
        $bots = mysql_fetch_array(mq ('SELECT * FROM `bots` WHERE `id` = '.$id.' LIMIT 1;'));
        $id=$bots['prototype'];
        $user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
        $user['login'] = $bots['name'];
        $user['hp'] = $bots['hp'];
        $user['id'] = $bots['id'];
    } else {
        $user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
        if (!$user) $user = mysql_fetch_array(mq("SELECT * FROM `allusers` WHERE `id` = '{$id}' LIMIT 1;"));
    }

    if($user[0]) {
      if ($showinvis) {
        $effect = mysql_fetch_array(mq("SELECT `time` FROM `effects` WHERE `owner` = '{$id}' and `type` = '1022' LIMIT 1;"));
        if($effect) {
          $user['level'] = '??';
          $user['login'] = '</a><b><i>невидимка</i></b>';
          $user['align'] = '0';
          $user['klan'] = '';
          $user['id'] = '';
          $user['hp'] = '??';
          $user['maxhp'] = '??';
          $user['mana'] = '??';
          $user['maxmana'] = '??';
        }
      }
    ?>
    <img src="<?=IMGBASE?>/i/align_<?echo ($user['align']>0 ? $user['align']:"0");?>.gif"><?php if ($user['klan'] <> '') { echo '<img title="'.$user['klan'].'" src="'.IMGBASE.'/i/klan/'.$user['klan'].'.gif">'; }?><B><?=$user['login']?></B> [<?
    if (id==2236) echo "?"; else echo $user['level'];
    ?>]<a href=inf.php?<?=$user['id']?> target=_blank><IMG SRC=<?=IMGBASE?>/i/inf.gif WIDTH=12 HEIGHT=11 ALT="Инф. о <?=$user['login']?>"></a>
<?
    return 1;
    }
}

function fullnick($user1, $showinvis=0, $class=0) {
  global $user;
  static $cache;
  if ($user1==$user["id"]) $user1=$user;
  if (!is_array($user1)) {
    if ($cache[$showinvis][$user1]) return ($class?"<span class=\"$class\">":"").$cache[$showinvis][$user1].($class?"</span>":"");
    $id=$user1;
    $user1=mqfa("select id, align, klan, login, level, invis from users where id='$id'");
    if (!$user1) $user1=mqfa("select id, align, klan, login, level, invis from allusers where id='$id'");
  } elseif ($cache[$showinvis][$user1["id"]]) return ($class?"<span class=\"$class\">":"").$cache[$showinvis][$user1["id"]].($class?"</span>":"");;

  if ($showinvis && $user1["invis"]) {
    $user1["level"]="??";$user1["login"]="невидимка";
    $user1["align"]=0;$user1["klan"]="";
  }
  $ret="<img src=\"".IMGBASE."/i/align_".($user1['align']>0?$user1['align']:"0").".gif\"> ".($user1['klan']?"<img title=\"$user1[klan]\" src=\"".IMGBASE."/i/klan/$user1[klan].gif\">":"")." <B>$user1[login]</B> [$user1[level]] ".($user1["login"]=="невидимка"?"":"<a href=inf.php?$user1[id] target=_blank><IMG SRC=".IMGBASE."/i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"Инф. о $user1[login]\"></a>");
  $cache[$showinvis][$user1["id"]]=$ret;
  return ($class?"<span class=\"$class\">":"").$ret.($class?"</span>":"");
}

// nick
function nick4 ($id,$st) {
    if($id > _BOTSEPARATOR_) {
        $bots = mysql_fetch_array(mq ('SELECT * FROM `bots` WHERE `id` = '.$id.' LIMIT 1;'));
        $id=$bots['prototype'];
        $user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
        $user['login'] = $bots['name'];
        $user['hp'] = $bots['hp'];
        $user['id'] = $bots['id'];
    } else {
        $user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
        if (!$user) $user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
    }

    if($user[0]) {
    $effect = mysql_fetch_array(mq("SELECT `time` FROM `effects` WHERE `owner` = '{$id}' and `type` = '1022' LIMIT 1;"));
    if($effect) {
        $user['level'] = '??';
        $user['login'] = '</a><b><i>невидимка</i></b>';
        $user['align'] = '0';
        $user['klan'] = '';
        $user['id'] = '';
        $user['hp'] = '??';
        $user['maxhp'] = '??';
        $user['mana'] = '??';
        $user['maxmana'] = '??';
    }
        return "<span onclick=\"top.AddTo('".$user['login']."')\" oncontextmenu=\"return OpenMenu(event,".$user['level'].")\" class={$st}>".$user['login']."</span> [".$user['hp']."/".$user['maxhp']."]";
    }
}

// nick
function nick7 ($id) {
  if($id > _BOTSEPARATOR_) {
    $bots = mysql_fetch_array(mq ('SELECT name FROM `bots` WHERE `id` = '.$id.' LIMIT 1;'));
    $user['login'] = $bots['name'];
  } else {
    $user = mysql_fetch_array(mq("SELECT login FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
    if (!$user) $user = mysql_fetch_array(mq("SELECT login FROM `allusers` WHERE `id` = '{$id}' LIMIT 1;"));
  }
  if($user) {
    //$effect = mysql_fetch_array(mq("SELECT `time` FROM `effects` WHERE `owner` = '{$id}' and `type` = '1022' LIMIT 1;"));
    if($user["invis"]) $user['login'] = '</a><b><i>невидимка</i></b>';
    return $user['login'];
  }
}

// nick
function nick5 ($id,$st) {
    if($id > _BOTSEPARATOR_) {
        $bots = mysql_fetch_array(mq ('SELECT * FROM `bots` WHERE `id` = '.$id.' LIMIT 1;'));
        $id=$bots['prototype'];
        $user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
        $user['login'] = $bots['name'];
        $user['hp'] = $bots['hp'];
        $user['id'] = $bots['id'];
    } else {
        $user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
        if (!$user) $user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
    }

    if($user[0]) {
    $effect = mysql_fetch_array(mq("SELECT `time` FROM `effects` WHERE `owner` = '{$id}' and `type` = '1022' LIMIT 1;"));
    if($effect) {
        $user['level'] = '??';
        $user['login'] = '</a><b><i>невидимка</i></b>';
        $user['align'] = '0';
        $user['klan'] = '';
        $user['id'] = '';
        $user['hp'] = '??';
        $user['maxhp'] = '??';
        $user['mana'] = '??';
        $user['maxmana'] = '??';
    }
        return "<span class={$st}>".$user['login']."</span>";
    }
}

// nick
function nick6 ($id) {
    if($id > _BOTSEPARATOR_) {
        $bots = mysql_fetch_array(mq ('SELECT * FROM `bots` WHERE `id` = '.$id.' LIMIT 1;'));
        $id=$bots['prototype'];
        $user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
        $user['login'] = $bots['name'];
        $user['hp'] = $bots['hp'];
        $user['id'] = $bots['id'];
    } else {
        $user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
        if (!$user) $user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
    }


    if($user[0]) {
    $effect = mysql_fetch_array(mq("SELECT `time` FROM `effects` WHERE `owner` = '{$id}' and `type` = '1022' LIMIT 1;"));
    if($effect) {
        $user['level'] = '??';
        $user['login'] = '</a><b><i>невидимка</i></b>';
        $user['align'] = '0';
        $user['klan'] = '';
        $user['id'] = '';
        $user['hp'] = '??';
        $user['maxhp'] = '??';
        $user['mana'] = '??';
        $user['maxmana'] = '??';
    }
        if ($id==2236) $user['level']="?";
        return "".$user['login']."</b> [".$user['level']."111]  <a href=inf.php?".$user['id']." target=_blank><IMG SRC=".IMGBASE."/i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"Инф. о ".$user['login']."\"></a><B>";
    }
}
// nick3
function nick3 ($id) {
  global $user;
  static $cache;
  if (@$cache[$id]) return $cache[$id];
  if ($id==$user["id"]) {
    $user1=$user;
  } else {
    if($id > _BOTSEPARATOR_) {
        $bots = mysql_fetch_array(mq ('SELECT * FROM `bots` WHERE `id` = '.$id.' LIMIT 1;'));
        $id=$bots['prototype'];
        $user1 = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
        $user1['login'] = $bots['name'];
        $user1['hp'] = $bots['hp'];
        $user1['id'] = $bots['id'];
    } else {
        $user1 = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
        if (!$user1) $user1 = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
    }
  }


    if($user1["login"]) {
    //$effect = mysql_fetch_array(mq("SELECT `time` FROM `effects` WHERE `owner` = '{$id}' and `type` = '1022' LIMIT 1;"));
    if($user1["invis"]) {
        $user1['level'] = '??';
        $user1['login'] = '</a><b><i>невидимка</i></b>';
        $user1['align'] = '0';
        $user1['klan'] = '';
        $user1['id'] = '';
        $user1['hp'] = '??';
        $user1['maxhp'] = '??';
        $user1['mana'] = '??';
        $user1['maxmana'] = '??';
    }
    if ($user1["id"]==2236) $user1['level']="?";
        $mm .= "<img src=\"".IMGBASE."/i/align_".($user1['align']>0 ? $user1['align']:"0").".gif\">";
        if ($user1['klan'] <> '') {
            $mm .= '<img title="'.$user1['klan'].'" src="'.IMGBASE.'/i/klan/'.$user1['klan'].'.gif">'; }
            $mm .= "<B>{$user1['login']}</B> [{$user1['level']}]<a href=inf.php?{$user1['id']} target=_blank><IMG SRC=".IMGBASE."/i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"Инф. о {$user1['login']}\"></a>";
    }
  $cache[$id]=$mm;
  return $mm;
}

function setHPpodzem($hp,$maxhp,$battle) {
        if ( $hp < $maxhp*0.33 ) {
            $polosa = IMGBASE.'/i/1red.gif';
        }
        elseif ( $hp < $maxhp*0.66 ) {
            $polosa = IMGBASE.'/i/1yellow.gif';
        }
        else {
            $polosa = IMGBASE.'/i/1green.gif';
        }
        $rr = "<div ";
        if (!$battle) {
            $rr .= ' id=HP ';
        }
        $rr .= "><IMG SRC='{$polosa}' WIDTH=";
        $rr .= round(150*($hp/$maxhp));
        $rr .= ' HEIGHT=10 ALT="Уровень жизни" name=HP1><IMG SRC="'.IMGBASE.'/i/1silver.gif" WIDTH=';
        $rr .= (150-round(150*($hp/$maxhp)));
        $rr .= ' HEIGHT=10 ALT="Уровень жизни" name=HP2>';
        $rr .= '<b style="font-size:11px"> '.$hp.'/'.$maxhp.'</b></div>';
        return $rr;
}
// полоска НР
function setHP($hp,$maxhp,$battle) {
        if ( $hp < $maxhp*0.33 ) {
            $polosa = IMGBASE.'/i/1red.gif';
        }
        elseif ( $hp < $maxhp*0.66 ) {
            $polosa = IMGBASE.'/i/1yellow.gif';
        }
        else {
            $polosa = IMGBASE.'/i/1green.gif';
        }
        $rr = "<div style=\"position:absolute; left:-1px; top:-7px;\"";
        if (!$battle) {
            $rr .= ' id=HP ';
        }
        $rr .= "><IMG SRC='{$polosa}' WIDTH=";
        $rr .= round(122*($hp/$maxhp));
        $rr .= ' HEIGHT=9 ALT="Уровень жизни"><IMG SRC="'.IMGBASE.'/i/1silver.gif" WIDTH=';
        $rr .= (122-round(122*($hp/$maxhp)));
        $rr .= ' HEIGHT=9 ALT="Уровень жизни">';
        $rr .= '</div>';
        $rr .= '<div style="position:absolute; left:5px; top:-7px; color:#FFFFFF;"><b>'.$hp.'/'.$maxhp.'</b></div>';
        return $rr;
}
  function setHP2($hp,$maxhp,$battle) {
    if ( $hp < $maxhp*0.33 ) {
      $polosa = IMGBASE.'/i/1red.gif';
    } elseif ( $hp < $maxhp*0.66 ) {
      $polosa = IMGBASE.'/i/1yellow.gif';
    } else {
      $polosa = IMGBASE.'/i/1green.gif';
    }

    $rr = "<IMG SRC='{$polosa}' WIDTH=";
    $rr .= round(120*($hp/$maxhp));
    $rr .= ' HEIGHT=9 ALT="Уровень жизни"><IMG SRC="'.IMGBASE.'/i/1silver.gif" WIDTH=';
    $rr .= (120-round(120*($hp/$maxhp)));
    $rr .= ' HEIGHT=9 ALT="Уровень жизни">';

    $rr .= '<div style="position: absolute; left: 5px; top:0px; z-index: 1; font-weight: bold; color:#FFFFFF;"><b>'.$hp.'/'.$maxhp.'</b></div>';
    return $rr;
  }

function setMP($mp,$maxmp,$battle) {
        $rr = "<div style='position:absolute; left:-1px; top:5px; color:#FFFFFF;'";
        if (!$battle) {
            $rr .= ' id=MP ';
        }
        $rr .= "><IMG SRC='".IMGBASE."/i/1blue.gif' WIDTH=";
        $rr .= round(120*($mp/$maxmp));
        $rr .= ' HEIGHT=9 ALT="Уровень маны"><IMG SRC="'.IMGBASE.'/i/1silver.gif" WIDTH=';
        $rr .= (120-round(120*($mp/$maxmp)));
        $rr .= ' HEIGHT=9 ALT="Уровень маны">';
        $rr .= '</div>';
        $rr .= '<div style="position:absolute; left:5px; top:5px; color:#FFFFFF;"><b>'.$mp.'/'.$maxmp.'</b></div>';
        return $rr;
}

function setMP2($mp,$maxmp,$battle) {

  $rr = "<IMG SRC='".IMGBASE."/i/1blue.gif' WIDTH=";
  $rr .= round(120*($mp/$maxmp));
  $rr .= ' HEIGHT=9 ALT="Уровень маны"><IMG SRC="'.IMGBASE.'/i/1silver.gif" WIDTH=';
  $rr .= (120-round(120*($mp/$maxmp)));
  $rr .= ' HEIGHT=9 ALT="Уровень маны">';

  $rr .= '<div style=\'position: absolute; left: 5px; top:0px; z-index: 1; font-weight: bold; color: #80FFFF\'><b>'.$mp.'/'.$maxmp.'</b></div>';
  return $rr;
}

function echoscroll($slot, $to="") {
  echo getscroll($slot, $to);
}

function getscroll($slot, $to="") {
  global $user;
  $ret="";
  if ($user['battle']) {
    $script = 'fbattle';
  } else {
    $script = 'main';
  }
  if ($user[$slot] > 0) {
    $row['id'] = $user[$slot];
    $dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user[$slot]}' LIMIT 1;"));
    if ($dress['magic']) {
      $magic = magicinf ($dress['magic']);
      $ret.="<a  onclick=\"";
      if ($magic['targeted']==1) {
        $ret.="okno('Введите название предмета', '".$script.".php?use={$row['id']}', 'target'); ";
      } else if($magic['targeted']==2) {
        $ret.="findlogin('Введите имя персонажа', '".$script.".php?use={$row['id']}', 'target', '$to'); ";
      } else if ($magic['targeted']==4) {
        $ret.="note('Запрос', '".$script.".php?use={$row['id']}', 'target'); ";
      } else {
        $ret.="if(confirm('Использовать сейчас?')) { window.location='".$script.".php?use=".$row['id']."';}";
      }
      $ret.="\"href='#'>";
    }
    $ret.='<img src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=40 title="'.$dress['name'].'  Прочность '.$dress['duration'].'/'.$dress['maxdur'].'"  Прочность '.$dress['duration'].'/'.$dress['maxdur'].'" height=25 alt="Использовать  '.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur'].'"></a>';
  } else { 
    $ret.="<img src=".IMGBASE."/i/w13.gif width=40 height=25  alt='пустой слот магия' title='пустой слот магия'>"; 
  }
  return $ret;
}

// ссылка на магию
function showhrefmagic($dress) {
  echo gethrefmagic($dress);
}

function gethrefmagic($dress) {
  global $user;
  if ($user['battle']) {
    $script = 'fbattle';
  } else {
    $script = 'main';
  }
  $magic = magicinf ($dress['includemagic']);
  $ret="<a  onclick=\"";
  if($magic['targeted']==1) {
    $ret.="okno('Введите название предмета', '{$script}.php?use={$dress['id']}', 'target')";
  }elseif($magic['targeted']==2) {
    $ret.="findlogin('".$magic['name']."', '{$script}.php?use={$dress['id']}', 'target')";
  }else
  if($magic['targeted']==4) {
    $ret.="note('Запрос', '".$script.".php?use={$row['id']}', 'target'); ";
  } else {
    $ret.="if (confirm('Использовать сейчас?')) window.location='".$script.".php?use=".$dress['id']."';";
  }
  $ret.="\"href='#'>";
  
  //echo "<img ".((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2)?" style='background-image:url(i/blink.gif);' ":"")." src='i/sh/{$dress['img']}' style=\"margin:0px,0px,-100%,0px;\"><BR><img src='mg.php?p=".($dress['includemagicdex']/$dress['includemagicmax']*100)."&i={$dress['img']}' style=\"filter:shadow(color=red, direction=90, strength=3);\" alt=\"".$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['minu']>0)?"\nУрон {$dress['minu']}-{$dress['maxu']}":"").(($dress['text']!=null)?"\nНа оружии выгравировано '{$dress['text']}'":"")."\" ><BR>";
  $ret.="<img src=\"".IMGBASE."/i/sh/$dress[img]\" style=\"filter:shadow(color=red, direction=90, strength=5);\" title=\"".$dress['name']."  Прочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"  Уровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['minu']>0)?"  Урон {$dress['minu']}-{$dress['maxu']}":"").(($dress['text']!=null)?"  На оружии выгравировано '{$dress['text']}'":"")."  Встроена магия: ".$magic['name']."\" alt=\"".$dress['name']."  Прочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"  Уровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['minu']>0)?"  Урон {$dress['minu']}-{$dress['maxu']}":"").(($dress['text']!=null)?"  На оружии выгравировано '{$dress['text']}'":"")."  Встроена магия: ".$magic['name']."\" ><BR>";
  //'mg2.php?p=".($dress['includemagicdex']/$dress['includemagicmax']*100)."&i={$dress['img']}'
        //<img  ".((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2)?" style='background-image:url(i/blink.gif);' ":"")." src='i/sh/{$dress['img']}' style=\"margin:0px,0px,-250000%,0px;\"><BR>
  return $ret;
}

function plusorminus($n, $shownum=1) {
  if (!$shownum) {
    if ($n>=2) return "++";
    if ($n>0) return "+";
    if ($n<0) return "-";
  }
  if ($n>=0) return "+$n";
  else return $n;
}

function effectpos($i) {
  $left=80;$top=175;
  switch ($i) {
    case '1':$left=0;$top=0;break;
    case '2':$left=40;$top=0;break;
    case '3':$left=80;$top=0;break;
    case '4':$left=0;$top=25;break;
    case '5':$left=40;$top=25;break;
    case '6':$left=80;$top=25;break;
    case '7':$left=0;$top=50;break;
    case '8':$left=40;$top=50;break;
    case '9':$left=80;$top=50;break;
    case '10':$left=0;$top=75;break;
    case '11':$left=40;$top=75;break;
    case '12':$left=80;$top=75;break;
    case '13':$left=0;$top=100;break;
    case '14':$left=40;$top=100;break;
    case '15':$left=80;$top=100;break;
    case '16':$left=0;$top=125;break;
    case '17':$left=40;$top=125;break;
    case '18':$left=80;$top=125;break;
    case '19':$left=0;$top=150;break;
    case '20':$left=40;$top=150;break;
    case '21':$left=80;$top=150;break;
    case '22':$left=0;$top=175;break;
    case '23':$left=40;$top=175;break;
    case '24':$left=80;$top=175;break;
  }
  return array($left, $top);
}

function year_text($days) { # склонение слова "год"
  $s=substr($days,strlen($days)-1,1);
  if (strlen($days)>=2) {
    if (substr($days,strlen($days)-2,1)=='1') {return $days." лет ";$ok=true;}
  }
  if (!$ok) {
    if ($days==0){return "";}
    elseif ($s==0 or $s>=5) {return $days." лет ";}
    elseif ($s==1) {return $days." год ";}
    elseif ($s>=2 && $s<=4) {return $days." года ";}
  }
}
function month_text($days) { # склонение слова "месяц"
  $s=substr($days,strlen($days)-1,1);
  if (strlen($days)>=2) {
    if (substr($days,strlen($days)-2,1)=='1') {return $days." месяцев ";$ok=true;}
  }
  if (!$ok) {
    if ($days==0){return "";}
    elseif ($s==0 or $s>=5) {return $days." месяцев ";}
    elseif ($s==1) {return $days." месяц ";}
    elseif ($s>=2 && $s<=4) {return $days." месяца ";}
  }
}
function week_text($days) { # склонение слова "неделя"
  $s=substr($days,strlen($days)-1,1);
  if (strlen($days)>=2) {
    if (substr($days,strlen($days)-2,1)=='1') {return $days." недель ";$ok=true;}
  }
  if (!$ok) {
    if ($days==0){return "";}
    elseif ($s==0 or $s>=5) {return $days." недель ";}
    elseif ($s==1) {return $days." неделю ";}
    elseif ($s>=2 && $s<=4) {return $days." недели ";}
  }
}
function days_text($days) { # склонение слова "дней"
  $s=substr($days,strlen($days)-1,1);
  if (strlen($days)>=2) {
    if (substr($days,strlen($days)-2,1)=='1') {return $days." дней ";$ok=true;}
  }
  if (!$ok) {
    if ($days==0){return "";}
    elseif ($s==0 or $s>=5) {return $days." дней ";}
    elseif ($s==1) {return $days." день ";}
    elseif ($s>=2 && $s<=4) {return $days." дня ";}
  }
}
function hour_text($days) { # склонение слова "час"
  $s=substr($days,strlen($days)-1,1);
  if (strlen($days)>=2) {
    if (substr($days,strlen($days)-2,1)=='1') {return $days." часов ";$ok=true;}
  }
  if (!$ok) {
    if ($days==0){return "";}
    elseif ($s==0 or $s>=5) {return $days." часов ";}
    elseif ($s==1) {return $days." час ";}
    elseif ($s>=2 && $s<=4) {return $days." часа ";}
  }
}
function minute_text($days) { # склонение слова "минута"
  $s=substr($days,strlen($days)-1,1);
  if (strlen($days)>=2) {
    if (substr($days,strlen($days)-2,1)=='1') {return $days." минут ";$ok=true;}
  }
  if (!$ok) {
    if ($days==0){return "1 минуту";}
    elseif ($s==0 or $s>=5) {return $days." минут ";}
    elseif ($s==1) {return $days." минуту ";}
    elseif ($s>=2 && $s<=4) {return $days." минуты ";}
  }
}

function getDateInterval($pointDate) {
  $pointNow = time(); // получили метку текущего времени

  $times = array('year' => 60*60*24*365, 'month' =>60*60*24*31, 'week' =>60*60*24*7, 'day' => 60*60*24, 'hour' => 60*60, 'minute' => 60);

  $pointInterval = $pointDate > $pointNow ? $pointDate - $pointNow : $pointNow - $pointDate; // получили метку разности двух дат

  $returnDate = array(); // создаём пока пустой массив возвращаемой даты

  $returnDate['year'] = floor($pointInterval / $times['year']); // высчитываем годы
  $pointInterval = $pointInterval % $times['year']; // находим остаток

  $returnDate['month'] = floor($pointInterval / $times['month']); // высчитываем месяцы
  $pointInterval = $pointInterval % $times['month']; // находим остаток

  $returnDate['week'] = floor($pointInterval / $times['week']); // высчитываем недели
  $pointInterval = $pointInterval % $times['week']; // находим остаток

  $returnDate['day'] = floor($pointInterval / $times['day']); // высчитываем дни
  $pointInterval = $pointInterval % $times['day']; // находим остаток

  $returnDate['hour'] = floor($pointInterval / $times['hour']); // высчитываем часы
  $pointInterval = $pointInterval % $times['hour']; // находим остаток

  $returnDate['minute'] = floor($pointInterval / $times['minute']); // высчитываем минуты
  $pointInterval = $pointInterval % $times['minute']; // находим остаток

  $year = year_text($returnDate['year']);
  $month = month_text($returnDate['month']);
  $week = week_text($returnDate['week']);
  $days = days_text($returnDate['day']);
  $hour = hour_text($returnDate['hour']);
  $minute = minute_text($returnDate['minute']);

  if ($days>0 or $week>0 or $month>0 or $year>0) $minute="";
  if ($week>0 or $month>0 or $year>0) $hour="";
  if ($month>0 or $year>0) $week="";

  return $year.$month.$week.$days.$hour.$minute;

}


// показать перса в инфе
function showpersout($id,$pas = 0,$battle = 0,$me = 0,$show_pr = 0) {
  global $mysql, $rooms, $user, $personline;
  if ($user["id"]==$id) $user1=$user;
  else $user1 = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
  include "config/questbots.php";
  if (@$questbots[$id]) {
    $user1["hp"]=questbothp();
    $user1["maxhp"]=questbothp();
  }
  $invis=$user1["invis"];

  $ret="<CENTER>";
  if(!$battle) {
    $ret.="<A HREF=\"javascript:top.AddToPrivate('$user1[login]', top.CtrlPress)\" target=refreshed><img src=\"".IMGBASE."/i/lock.gif\" width=20 height=15></A>".($user1['align']>0?"<img src=\"".IMGBASE."/i/align_".$user1['align'].".gif\">":"").($user1['klan']<>''?'<img title="'.$user1['klan'].'" src="'.IMGBASE.'/i/klan/'.$user1['klan'].'.gif">':"")."<B>$user1[login]</B> [";
    if ($id==2236) $ret.="?";
    else $ret.=$user1['level'];
    $ret.="]<a href=inf.php?$user1[id] target=_blank><IMG SRC=".IMGBASE."/i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"Инф. о $user1[login]\"></a>";
  }
  if ($user1['block']) {
    $ret.="<BR><FONT class=private>Персонаж заблокирован!</font>";
  }
  if ($user1['prison']) {
    $ret.="<BR><FONT class=private>Персонаж в заточении!</font>";
  }
  if ($user1['bar']) {
    $ret.="<BR><FONT class=private>Пьянствует в баре!</font>";
  }
  //echo setHP($user1['hp'],$user1['maxhp'],$battle);
  if ($user1['maxmana']) {
    //echo setMP($user1['mana'],$user1['maxmana'],$battle);
  }
  $po=0;
  if ($user1["battle"] && !$invis) {
    $rec=mqfa("select sila, lovk, inta, persout0 from battleunits where battle='$user1[battle]' and user='$user1[id]'");
    if ($rec) {
      $user1["sila"]=$rec["sila"];
      $user1["lovk"]=$rec["lovk"];
      $user1["inta"]=$rec["inta"];
      $tmp=setHP2($user1['hp'],$user1['maxhp'],1);

      $po=str_replace("<!--hp-->", $tmp, $po);
      if (@$user1['maxmana']) {
        $tmp=setMP2($user1['mana'],$user1['maxmana'],1);
        $po=str_replace("<!--mana-->", $tmp, $po);
      }
    }
  }

  $ret.="<TABLE cellspacing=0 cellpadding=0 style=\"border-top-width: 1px;border-right-width: 1px;border-bottom-width: 1px;
  border-left-width: 1px;border-top-style: solid;border-right-style: solid;border-bottom-style: solid;
  border-left-style: solid;border-top-color: #FFFFFF;border-right-color: #666666;border-bottom-color: #666666;
  border-left-color: #FFFFFF;padding: 2px;\"><TR>
  <TD>";
  if ($po) {
    $ret.=$po;
  } else {
    $ret.="<TABLE border=0 cellSpacing=1 cellPadding=0 width=\"100%\">
    <TBODY>
    <TR vAlign=top>
    <TD>";
    $ret.="<TABLE border=0 cellSpacing=0 cellPadding=0 width=\"100%\">
    <TBODY>
    <TR><TD style=\"BACKGROUND-IMAGE:none\">";
    //$invis = mysql_fetch_array(mq("SELECT `time` FROM `effects` WHERE `owner` = '{$id}' and `type` = '1022' LIMIT 1;"));
    
    if($battle && $invis && $user1['id'] != $_SESSION['uid']) {
      $user1['level'] = '??';
      $user1['login'] = '</a><b><i>невидимка</i></b>';
      $user1['align'] = '0';
      $user1['klan'] = '';
      $user1['id'] = '';
      $user1['hp'] = '??';
      $user1['maxhp'] = '??';
      $user1['mana'] = '??';
      $user1['maxmana'] = '??';
      $user1['sila'] ='??';
      $user1['lovk'] ='??';
      $user1['inta'] ='??';
      $user1['vinos'] ='??';
      $showme = $user1['id'];
      if ($user1['helm'] >=0) {
        $ret.='<img src="'.IMGBASE.'/i/helm.gif" width=60 height=60>';
      }
      $ret.="</TD></TR><TR><TD style=\"BACKGROUND-IMAGE:none\">";
      if ($user1['naruchi'] >=0) {
        $ret.='<img src="'.IMGBASE.'/i/naruchi.gif" width=60 height=40>';
      }
      $ret.="</TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
      if ($user1['weap'] >=0) {
        $ret.='<img src="'.IMGBASE.'/i/weap.gif" width=60 height=60>';
      }
      $ret.="</TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
      if ($user1['bron'] >=0) {
        $ret.='<img src="'.IMGBASE.'/i/bron.gif" width=60 height=80>';
      }
      $ret.="</TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
      if ($user1['belt'] >=0) {
        $ret.='<img src="'.IMGBASE.'/i/belt.gif" width=60 height=40>';
      }
    } else {
      if ($user1['helm'] > 0) {
        $dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['helm']}' LIMIT 1;"));
        if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
          $ret.=gethrefmagic($dress);
        } else {
          $ret.='<img  '.((($dress['maxdur']-2)<=$dress['duration'] && !$pas)?" style='background-image:url(".IMGBASE."/i/blink.gif);' ":"").' src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=60 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа шлеме выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа шлеме выгравировано '{$dress['text']}'":"").'" >';
        }
      } else {
        $ret.='<img src="'.IMGBASE.'/i/w9.gif" width=60 height=60 alt="Пустой слот шлем" title="Пустой слот шлем">';
      }
      $ret.="</TD></TR><TR><TD style=\"BACKGROUND-IMAGE:none\">";
      if ($user1['naruchi'] > 0) {
        $dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['naruchi']}' LIMIT 1;"));
        if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
          $ret.=gethrefmagic($dress);
        } else {
          $ret.='<img  '.((($dress['maxdur']-2)<=$dress['duration'] && !$pas)?" style='background-image:url(".IMGBASE."/i/blink.gif);' ":"").' src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=40 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа наручах выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа наручах выгравировано '{$dress['text']}'":"").'" >';
        }
      } else {
        $ret.='<img src="'.IMGBASE.'/i/w18.gif" width=60 height=40 title="Пустой слот наручи" alt="Пустой слот наручи">';
      }
      $ret.="</TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
      if ($user1['weap'] > 0) {
        $dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['weap']}' LIMIT 1;"));
        if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
          $ret.=gethrefmagic($dress);
        } else {
          $ret.='<img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(".IMGBASE."/i/blink.gif);' ":"").' src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=60 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['minu']>0)?"\nУрон {$dress['minu']}-{$dress['maxu']}":"").(($dress['text']!=null)?"\nНа оружии выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['minu']>0)?"\nУрон {$dress['minu']}-{$dress['maxu']}":"").(($dress['text']!=null)?"\nНа оружии выгравировано '{$dress['text']}'":"").'" >';
        }
      } else {
        $ret.='<img src="'.IMGBASE.'/i/w3.gif" width=60 height=60 alt="Пустой слот оружие" title="Пустой слот оружие">';
      }
      $ret.="</TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
      if ($user1['bron'] > 0 || $user1['rybax'] > 0 || $user1['plaw'] > 0) {
        $title="";
        if ($user1['plaw']) {
          $d=$user1['plaw'];
          if ($user1["bron"]) {
            $dress = mqfa("SELECT name, duration, maxdur, ghp, gmana, text FROM `inventory` WHERE `id` = '$user1[bron]'");
            $title.="\n--------------------\n$dress[name]\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа одежде вышито '{$dress['text']}'":"");
          }
          if ($user1["rybax"]) {
            $dress = mqfa("SELECT name, duration, maxdur, ghp, gmana, text FROM `inventory` WHERE `id` = '$user1[rybax]'");
            $title.="\n--------------------\n$dress[name]\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа одежде вышито '{$dress['text']}'":"");
          }
        } elseif ($user1['bron']) {
          $d=$user1['bron'];
          if ($user1["rybax"]) {
            $dress = mqfa("SELECT name, duration, maxdur, ghp, gmana, text FROM `inventory` WHERE `id` = '$user1[rybax]'");
            $title.="\n--------------------\n$dress[name]\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа одежде вышито '{$dress['text']}'":"");
          }
        } elseif ($user1['rybax']) $d=$user1['rybax'];
        $dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '$d' LIMIT 1;"));
        if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
          $ret.=gethrefmagic($dress);
        } else {
          $ret.='<img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(".IMGBASE."/i/blink.gif);' ":"").' src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=80 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа одежде вышито '{$dress['text']}'":"").$title.'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа одежде вышито '{$dress['text']}'":"").$title.'" >';
        }
      } else {
        $ret.='<img src="'.IMGBASE.'/i/w4.gif" width=60 height=80 alt="Пустой слот броня" title="Пустой слот броня">';
      }
      $ret.="</TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
      if ($user1['belt'] > 0) {
        $dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['belt']}' LIMIT 1;"));
        if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
          $ret.=gethrefmagic($dress);
        } else {
          $ret.='<img  '.((($dress['maxdur']-2)<=$dress['duration'] && !$pas)?" style='background-image:url(".IMGBASE."/i/blink.gif);' ":"").' src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=40 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа поясе выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа поясе выгравировано '{$dress['text']}'":"").'" >';
        }
      } else {
        $ret.='<img src="'.IMGBASE.'/i/w5.gif" width=60 height=40 alt="Пустой слот пояс" title="Пустой слот пояс">';
      }
    }
    $ret.="</TD></TR></TBODY></TABLE>";
  
    $ret.="</TD><TD><TABLE border=0 cellSpacing=0 cellPadding=0 width=\"100%\">
    <TR><TD height=20 vAlign=middle>
    <table cellspacing=\"0\" cellpadding=\"0\" style='line-height: 1'>";
    if($battle!='0' or $user1['id']==99){ 
      $ret.="<tr><td nowrap style=\"font-size:9px\"><div style=\"position: relative\">";
      if($user1['id']==99) {
        $vrag_b = mysql_fetch_array(mq("SELECT `hp` FROM `bots` WHERE  `prototype` = 99 LIMIT 1 ;"));
        if($vrag_b){$user1['hp']=$vrag_b['hp'];}

      }
      $ret.=setHP2($user1['hp'],$user1['maxhp'],$battle);
      $ret.="</div></td>";
      $ret.="</tr>";
    } else {
      $ret.="<tr><td nowrap style=\"font-size:9px\"><div style=\"position: relative\">
      <table cellspacing=\"0\" cellpadding=\"0\" style='line-height: 1'><td nowrap style=\"font-size:9px;position: relative\"><SPAN id=\"HP\" style='position: absolute; left: 5; z-index: 1; font-weight: bold; color: #FFFFFF'></SPAN><img src=\"".IMGBASE."/i/misc/bk_life_loose.gif\" alt=\"Уровень жизни\" name=\"HP1\" width=\"1\" height=\"9\" id=\"HP1\"><img src=\"".IMGBASE."/i/misc/bk_life_loose.gif\" alt=\"Уровень жизни\" name=\"HP2\" width=\"1\" height=\"9\" id=\"HP2\"></td></table></div>
      </td></tr>";
    }

    if($battle!='0') {
      if ($user1['maxmana']) { 
        $ret.="<tr><td nowrap height=10 style=\"font-size:9px;\"><div style=\"position: relative\">";
        $ret.=setMP2($user1['mana'],$user1['maxmana'],$battle);
        $ret.="</div></td></tr>";
      }
    } else {
      if ($user1['maxmana']) {
        $ret.="<tr><tr><td nowrap style=\"font-size:9px\"><div style=\"position: relative\">";
        $ret.=setMP2($user1['mana'],$user1['maxmana'],$battle);
        $ret.="</div></td></tr>";
      }
    }
    $zver=mysql_fetch_array(mq("SELECT shadow,login,level,vid FROM `users` WHERE `id` = '".$user1['zver_id']."' LIMIT 1;"));
    $ret.="</table></TD></TR><TR><TD height=220 vAlign=top width=120 align=left>
    <DIV style=\"Z-INDEX: 1; POSITION: relative; WIDTH: 120px; HEIGHT: 220px\" bgcolor=\"black\">";
    
    $strtxt = "<b>".$user1['login']."</b><br>";
    $strtxt .= "Сила: ".$user1['sila']."<BR>";
    $strtxt .= "Ловкость: ".$user1['lovk']."<BR>";
    $strtxt .= "Интуиция: ".$user1['inta']."<BR>";
    $strtxt .= "Выносливость: ".$user1['vinos']."<BR>";
    if ($user1['level'] > 3) {
      $strtxt .= "Интеллект: ".$user1['intel']."<BR>";
    }
    if ($user1['level'] > 6) {
      $strtxt .= "Мудрость: ".$user1['mudra']."<BR>";
    }
    if ($user1['level'] > 9) {
      $strtxt .= "Духовность: ".$user1['spirit']."<BR>";
    }
    if ($user1['level'] > 12) {
      $strtxt .= "Воля: ".$user1['will']."<BR>";
    }
    if ($user1['level'] > 15) {
      $strtxt .= "Свобода духа: ".$user1['freedom']."<BR>";
    }
    if ($user1['level'] > 18) {
      $strtxt .= "Божественность: ".$user1['god']."<BR>";
    }

    if(!$pas && !$battle){
      if ($zver && $zver["vid"]) {
        $ret.="<div style=\"position:absolute; left:80px; top:145px; width:40px; height:73px; z-index:2\">
        <a href=\"zver_inv.php\">
        <IMG width=40 height=73 src='".IMGBASE."/i/shadow/".$zver['shadow']."' onmouseout='ghideshow();'  onmouseover='gfastshow(\"$zver[login] [$zver[level]] (Перейти к настройкам)\");'>
        </a></div>";
      }
      $ret.="<a href=\"/main.php?edit=1\"><IMG border=0 src=\"".IMGBASE."/i/shadow/$user1[sex]/$user1[shadow]\" width=120 height=218 onmouseout='ghideshow();'  onmouseover='gfastshow(\"$user1[login] (Перейти в \\\"Инвентарь\\\")\");' ></a>";
      //$ret.=showeffects($id);
    } elseif ($show_pr) {
      if ($zver && $zver["vid"]) {
        $ret.="<div style=\"position:absolute; left:80px; top:145px; width:40px; height:73px; z-index:2\">
        <a href=\"zver_inv.php\">
        <IMG width=40 height=73 src='".IMGBASE."/i/shadow/$zver[shadow]' onmouseout='ghideshow();'  onmouseover=\"gfastshow('$zver[login] [$zver[level]] (Перейти к настройкам)');\">
        </a></div>";
      }
      $ret.="<IMG border=0 src=\"".IMGBASE."/i/shadow/$user1[sex]/$user1[shadow]\" width=120 height=218 onmouseout='ghideshow();'  onmouseover='gfastshow(\"$strtxt\");'>";
      $ret.=showeffects($id);

      /*$ch_eff1 = mq ('SELECT * FROM `effects` WHERE `owner` = '.$_SESSION['uid'].' and (`type`=187 or `type`=188 or `type`=201 or `type`=202 or `type`=1022 or `type`=54)');
      $i=0;
      while($ch_eff = mysql_fetch_array($ch_eff1)){
        $i++;
        list($left, $top)=effectpos($i);
        $inf_el = mysql_fetch_array(mq ('SELECT img FROM `shop` WHERE `name` = \''.$ch_eff['name'].'\';'));
        if (!$inf_el) {
          $inf_el = mysql_fetch_array(mq ('SELECT img FROM `berezka` WHERE `name` = \''.$ch_eff['name'].'\';'));
        }
        if (!$inf_el) {
          $inf_el = mysql_fetch_array(mq ('SELECT img FROM `items` WHERE `name` = \''.$ch_eff['name'].'\';'));
        }
        if($ch_eff['type']==395) {
          $inf_el['img']='defender.gif'; 
          $opp='награда'; 
          $chas=60; 
          $chastxt="час.";
        } elseif (
          $ch_eff['type']==201) {
            $inf_el['img']='spell_protect10.gif'; 
            $opp='заклятие'; 
            $chas=1; 
            $chastxt="мин.";
          } elseif($ch_eff['type']==202) {
            $inf_el['img']='spell_powerup10.gif'; 
            $opp='заклятие'; 
            $chas=1; 
            $chastxt="мин.";
          } elseif ($ch_eff['type']==1022) {
            $inf_el['img']='hidden.gif'; 
            $opp='заклятие'; 
            $chas=1; 
            $chastxt="мин.";
          } else {
            if ($ch_eff["type"]==187) $opp='заклятие';
            else $opp='эликсир'; 
            $chas=1; $chastxt="мин.";
          }
          $ret.="<div style=\"position:absolute; left:{$left}px; top:{$top}px; width:40px; height:25px; z-index:2\"><IMG width=40 height=25 src='".IMGBASE."/i/misc/icon_$inf_el[img]' onmouseout='ghideshow();' onmouseover='gfastshow(\"<B>$ch_eff[name]</B> ($opp)<BR> еще ".ceil(($ch_eff['time']-time())/60/$chas)." $chastxt\")';> </div>";
        }
        $ch_priem1 = mq ('SELECT pr_name FROM `person_on` WHERE `id_person` = '.$_SESSION['uid'].' and `pr_active`=2');

        while($ch_priem = mysql_fetch_array($ch_priem1)){
          $i++;
          list($left, $top)=effectpos($i);
          $inf_priem = mysql_fetch_array(mq ('SELECT name,opisan FROM `priem` WHERE `priem` = \''.$ch_priem['pr_name'].'\';'));
          $ret.="<div style=\"position:absolute; left:{$left}px; top:{$top}px; width:40px; height:25px; z-index:2\"><IMG width=40 height=25 src='".IMGBASE."/i/priem/$ch_priem[pr_name].gif' onmouseout='hideshow();' onmouseover='fastshow(\"<B>$inf_priem[name]</B> (прием)<BR><BR> $inf_priem[opisan]\")';> </div>";
        }*/
      } elseif ($zver && (!$invis || !$battle) && $zver["vid"]) {
        $ret.="<div style=\"position:absolute; left:80px; top:145px; width:40px; height:73px; z-index:2\">
        <IMG width=40 height=73 src='".IMGBASE."/i/shadow/$zver[shadow]' alt=\"$zver[login] [$zver[level]]\">
        </div>
        <IMG border=0 src=\"".IMGBASE."/i/shadow/$user1[sex]/$user1[shadow]\" width=120 height=218>";
      } elseif ($battle && $invis) {
        $ret.="<IMG border=0 src=\"".IMGBASE."/i/shadow/invis.gif\" width=120 height=218 onmouseout='ghideshow();'  onmouseover='gfastshow(\"$strtxt\");'>";
      } elseif ($battle) {
        if($zver && $zver["vid"]){
          $ret.="<div style=\"position:absolute; left:60px; top:118px; width:40px; height:73px; z-index:2\">
          <a href=\"zver_inv.php\">
          <IMG width=40 height=73 src='".IMGBASE."/i/shadow/$zver[shadow]' alt=\"$zver[login] [$zver[level]] (Перейти к настройкам)\">
          </a></div>";
        }
        $ret.="<IMG border=0 src=\"/i/shadow/$user1[sex]/$user1[shadow]\" width=120 height=218 onmouseout='ghideshow();'  onmouseover='gfastshow(\"$strtxt\");'>";
      } else {
        $ret.="<IMG border=0 src=\"".IMGBASE."/i/shadow/$user1[sex]/$user1[shadow]\" width=120 height=218>";
      }
      $ret.="<DIV style=\"Z-INDEX: 2; POSITION: absolute; WIDTH: 120px; HEIGHT: 220px; TOP: 0px; LEFT: 0px\"></DIV></DIV></TD></TR>
      <TR><TD>";

      if ($battle && $invis && $user1['id'] != $_SESSION['uid']) {
        $ret.='<IMG border=0 alt="" src="'.IMGBASE.'/i/slot_invis.gif" width=120 height=40>';
      } elseif ($user1['vip']>=1) {
	    $ret.='<IMG border=0 alt="" src="'.IMGBASE.'/i/slot_bottom60.gif" width=120 height=40>';
      } elseif ($user1['align']>1 && $user1['align']<2) {
        $ret.='<IMG border=0 alt="" src="'.IMGBASE.'/i/slot_bottom1.gif" width=120 height=40>';
      } elseif ($user1['align']>=3 && $user1['align']<4) {
        $ret.='<IMG border=0 alt="" src="'.IMGBASE.'/i/slot_bottom3.gif" width=120 height=40>';
      } elseif ($user1['align']==7) {
        $ret.='<IMG border=0 alt="" src="'.IMGBASE.'/i/slot_bottom7.gif" width=120 height=40>';
      } elseif ($user1['align']==0.99) {
        $ret.='<IMG border=0 alt="" src="'.IMGBASE.'/i/slot_bottom1.gif" width=120 height=40>';
      } elseif ($user1['align']==0.98) {
        $ret.='<IMG border=0 alt="" src="'.IMGBASE.'/i/slot_bottom3.gif" width=120 height=40>';
      } else{
        $ret.='<IMG border=0 alt="" src="'.IMGBASE.'/i/slot_bottom0.gif" width=120 height=40>';
      }
      $ret.="</TD></TR></TABLE></TD>
      <TD><TABLE border=0 cellSpacing=0 cellPadding=0 width=\"100%\"><TBODY>
      <TR><TD style=\"BACKGROUND-IMAGE: none\">";
      if ($battle && $invis && $user1['id'] != $_SESSION['uid']) {
        if ($user1['sergi'] >= 0) {
          $ret.='<img src="'.IMGBASE.'/i/serg.gif" width=60 height=20>';
        }
        $ret.="</TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
        if ($user1['kulon'] >= 0) {
          $ret.='<img src="'.IMGBASE.'/i/ojur.gif" width=60 height=20>';
        }
        $ret.="</TD></TR>
        <TR><TD><TABLE border=0 cellSpacing=0 cellPadding=0>
        <TBODY> <TR>
        <TD style=\"BACKGROUND-IMAGE: none\">";
        if ($user1['r1'] >= 0) {
          $ret.='<img src="'.IMGBASE.'/i/ring.gif" width=20 height=20>';
        }
        $ret.="</td><TD style=\"BACKGROUND-IMAGE: none\">";
        if ($user1['r2'] >= 0) {
          $ret.='<img src="'.IMGBASE.'/i/ring.gif" width=20 height=20>';
        }
        $ret.="</td>
        <TD style=\"BACKGROUND-IMAGE: none\">";
        if ($user1['r3'] >= 0) {
          $ret.='<img src="'.IMGBASE.'/i/ring.gif" width=20 height=20>';
        }       
        $ret.="</td>
        </TR></TBODY></TABLE></TD></TR>
        <TR><TD style=\"BACKGROUND-IMAGE: none\">";
        if ($user1['perchi'] >= 0) {
          $ret.='<img src="'.IMGBASE.'/i/perchi.gif" width=60 height=40>';
        }
        $ret.="</TD></TR>
        <TR><TD style=\"BACKGROUND-IMAGE: none\">";
        if ($user1['shit'] >= 0) {
          $ret.='<img src="'.IMGBASE.'/i/shit.gif" width=60 height=60>';
        }
        $ret.="</TD></TR>
        <TR><TD style=\"BACKGROUND-IMAGE: none\">";
        if ($user1['leg'] >= 0) {
          $ret.='<img src="'.IMGBASE.'/i/leg.gif" width=60 height=80>';
        }
        $ret.="</TD></TR>
        <TR><TD style=\"BACKGROUND-IMAGE: none\">";
        if ($user1['boots'] >= 0) {
          $ret.='<img src="'.IMGBASE.'/i/boots.gif" width=60 height=40>';
        }
      } else {
        if ($user1['sergi'] > 0) {
          $dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['sergi']}' LIMIT 1;"));
          if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
            $ret.=gethrefmagic($dress);
          } else {
            $ret.='<img '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(".IMGBASE."/i/blink.gif);' ":"").' src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=20 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа серьгах выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа серьгах выгравировано '{$dress['text']}'":"").'" >';
          }
        } else {
          $ret.='<img src="'.IMGBASE.'/i/w1.gif" width=60 height=20 alt="Пустой слот серьги" title="Пустой слот серьги">';
        }
        $ret.="</TD></TR>
        <TR><TD style=\"BACKGROUND-IMAGE: none\">";
        if ($user1['kulon'] > 0) {
          $dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['kulon']}' LIMIT 1;"));
          if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
            $ret.=gethrefmagic($dress);
          } else {
            $ret.='<img  '.((($dress['maxdur']-2)==$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(".IMGBASE."/i/blink.gif);' ":"").' src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=20 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа ожерелье выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа ожерелье выгравировано '{$dress['text']}'":"").'" >';
          }
        } else {
          $ret.='<img src="'.IMGBASE.'/i/w2.gif" width=60 height=20 alt="Пустой слот ожерелье" title="Пустой слот ожерелье">';
        }
        $ret.="</TD></TR><TR><TD><TABLE border=0 cellSpacing=0 cellPadding=0>
        <TBODY> <TR>
        <TD style=\"BACKGROUND-IMAGE: none\">";
        if ($user1['r1'] > 0) {
          $dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['r1']}' LIMIT 1;"));
          if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
            $ret.=gethrefmagic($dress);
          } else {
            $ret.='<img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(".IMGBASE."/i/blink.gif);' ":"").' src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=20 height=20 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа кольце выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа кольце выгравировано '{$dress['text']}'":"").'" >';
          }
        } else {
          $ret.='<img src="'.IMGBASE.'/i/w6.gif" width=20 height=20 alt="Пустой слот кольцо" title="Пустой слот кольцо">';
        }
        $ret.="</td>
        <TD style=\"BACKGROUND-IMAGE: none\">";
        if ($user1['r2'] > 0) {
          $dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['r2']}' LIMIT 1;"));
          if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
            $ret.=gethrefmagic($dress);
          } else {
            $ret.='<img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(".IMGBASE."/i/blink.gif);' ":"").' src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=20 height=20 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа кольце выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа кольце выгравировано '{$dress['text']}'":"").'" >';
          }
        } else {
          $ret.='<img src="'.IMGBASE.'/i/w6.gif" width=20 height=20 alt="Пустой слот кольцо" title="Пустой слот кольцо">';
        }
        $ret.="</td>
        <TD style=\"BACKGROUND-IMAGE: none\">";
        if ($user1['r3'] > 0) {
          $dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['r3']}' LIMIT 1;"));
          if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
            $ret.=gethrefmagic($dress);
          } else {
            $ret.='<img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(".IMGBASE."/i/blink.gif);' ":"").' src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=20 height=20 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа кольце выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа кольце выгравировано '{$dress['text']}'":"").'" >';
          }
        } else {
          $ret.='<img src="'.IMGBASE.'/i/w6.gif" width=20 height=20 alt="Пустой слот кольцо" title="Пустой слот кольцо">';
        }
        $ret.="</td>
        </TR></TBODY></TABLE></TD></TR>
        <TR><TD style=\"BACKGROUND-IMAGE: none\">";
        if ($user1['perchi'] > 0) {
          $dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['perchi']}' LIMIT 1;"));
          if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
            $ret.=gethrefmagic($dress);
          } else {
            $ret.='<img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(".IMGBASE."/i/blink.gif);' ":"").' src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=40 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа перчатках выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа перчатках выгравировано '{$dress['text']}'":"").'" >';
          }
        } else {
          $ret.='<img src="'.IMGBASE.'/i/w11.gif" width=60 height=40 alt="Пустой слот перчатки" title="Пустой слот перчатки">';
        }
        $ret.="</TD></TR>
        <TR><TD style=\"BACKGROUND-IMAGE: none\">";
        if ($user1['shit'] > 0) {
          $dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['shit']}' LIMIT 1;"));
          if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
            $ret.=gethrefmagic($dress);
          } else {
            $ret.='<img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(".IMGBASE."/i/blink.gif);' ":"").' src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=60 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['minu']>0)?"\nУрон {$dress['minu']}-{$dress['maxu']}":"").(($dress['text']!=null)?"\nНа ".($dress["type"]==3?"оружии":"щите")." выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа ".($dress["type"]==3?"оружии":"щите")." выгравировано '{$dress['text']}'":"").'" >';
          }
        } else {
          $ret.='<img src="'.IMGBASE.'/i/w10.gif" width=60 height=60 alt="Пустой слот щит" title="Пустой слот щит">';
        }
        $ret.="</TD></TR>
        <TR><TD style=\"BACKGROUND-IMAGE: none\">";
        if ($user1['leg'] > 0) {
          $dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['leg']}' LIMIT 1;"));
          if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
            $ret.=gethrefmagic($dress);
          } else {
            $ret.='<img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(".IMGBASE."/i/blink.gif);' ":"").' src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=80 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа поножах выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа поножах выгравировано '{$dress['text']}'":"").'" >';
          }
        } else {
          $ret.='<img src="'.IMGBASE.'/i/w19.gif" width=60 height=80 alt="Пустой слот поножи" title="Пустой слот поножи">';
        }
        $ret.="</TD></TR>
        <TR><TD style=\"BACKGROUND-IMAGE: none\">";
        if ($user1['boots'] > 0) {
          $dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['boots']}' LIMIT 1;"));
          if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
            $ret.=gethrefmagic($dress);
          } else {
            $ret.='<img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(".IMGBASE."/i/blink.gif);' ":"").' src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=40 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа ботинках выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа ботинках выгравировано '{$dress['text']}'":"").'" >';
          }
        } else {
          $ret.='<img src="'.IMGBASE.'/i/w12.gif" width=60 height=40 alt="Пустой слот обувь" title="Пустой слот обувь">';
        }
      }
      $ret.="</TD></TR></TBODY></TABLE></TD></TR>";
      if (!$pas && !$battle && ($user1['m1'] > 0 or $user1['m2'] > 0 or $user1['m3'] > 0 or $user1['m4'] > 0 or $user1['m5'] > 0 or $user1['m6'] > 0 or $user1['m7'] > 0 or $user1['m8'] > 0 or $user1['m9'] > 0 or $user1['m10'] > 0 or $user1['m11'] > 0 or $user1['m12'] > 0)) {
        $ret.="<TR><TD colspan=3>";
        $ret.=getscroll('m1'); $ret.=getscroll('m2'); $ret.=getscroll('m3'); $ret.=getscroll('m4'); $ret.=getscroll('m5'); $ret.=getscroll('m6');
        $ret.="</TD></TR><TR>
        <TD colspan=3>";
        $ret.=getscroll('m7'); $ret.=getscroll('m8'); $ret.=getscroll('m9'); $ret.=getscroll('m10'); $ret.=getscroll('m11'); $ret.=getscroll('m12');
        $ret.="</TD></TR>";
      }
      $ret.="</TBODY></TABLE>";
    }
    $ret.="</TD></TR>
    <TR><TD></TD>";
    if ($invis) $data["id"]=null;
    else $data = mysql_fetch_array(mq("select * from `online` WHERE `date` >= ".(time()-60)." AND `id` = ".$user1['id'].";"));
/*      $dd = mq("SELECT * FROM `effects` WHERE `owner` = ".$user1['id'].";");
        $ddtravma = mysql_fetch_array(mq("SELECT * FROM `effects` WHERE `owner` = ".$user1['id']." and (`type`=11 or `type`=12 or `type`=13 or `type`=14) order by `type` desc limit 1;"));
        if ($ddtravma['type'] == 14) {$trt="неизлечимая";}
        elseif ($ddtravma['type'] == 13) {$trt="тяжелая";}
        elseif ($ddtravma['type'] == 12) {$trt="средняя";}
        elseif ($ddtravma['type'] == 11) {$trt="легкая";}
        else {$trt=0;} */
    $ret.="</A>
    </TABLE>
    </CENTER><CENTER>
    <TABLE cellPadding=0 cellSpacing=0 width=\"100%\"><TBODY>";
    if (!$battle) {
      if ($pas){ 
        $ret.="<TR><TD align=middle colSpan=2><B>Capital city</B></TD></TR>
        <TR><TD colSpan=2>
        <SMALL>";
        $online = mysql_fetch_array(mq('SELECT u.* ,o.date,u.* ,o.real_time FROM `users` as u, `online` as o WHERE u.`id` = o.`id` AND u.`id` = \''.$user1['id'].'\' LIMIT 1;'));
        if ($invis) $invis = mqfa1("select `time` from effects where owner='$user1[id]' and type='1022'");
        if ($invis>time()) {
          $data['id']=null;
          if ($id==7) $online['date']-=60*240-($invis-time());
          else $online['date']-=60*120-($invis-time());
          
        }
        if ($online) $personline=1;
        else $personline=0;
        if ($data['id'] != null or ($user1['id'] == 99 && vrag=="on")) {
          if(incastle($user1['room'])) {
            $rrm = 'Клановый замок';
          } elseif($user1['room'] > 500 && $user1['room'] < 561) {
            $rrm = 'Башня смерти, участвует в турнире';
          } elseif($user1['id'] == 99) {
            $rrm = "Центральная площадь";
            $vrag_b = mysql_fetch_array(mq("SELECT `battle` FROM `bots` WHERE  `prototype` = 99 LIMIT 1 ;"));
            $user1['battle']=$vrag_b['battle'];
          } else {
            $rrm = $rooms[$user1['room']];
          } 
          $ret.='<center>
            Персонаж сейчас находится в клубе.<br>
             <B>"'.$rrm.'"</B><br></center>
          ';
        } else {
if ($user1['id'] == 50) {$ret.="<center>Персонаж не в клубе";} elseif (!$user1["bot"]) {
            $ret.="<center>Персонаж не в клубе, но был тут:</center><center><!--tme-->".date("Y.m.d H:i", $online['date'])."<!----><IMG src=\"".IMGBASE."/i/clok3_2.png\" alt=\"Время сервера\" title=\"Время сервера\"></center>";
            $ret.="<center>(<!--tme2-->".getDateInterval($online['date'])."<!----> назад)</center>";
          }
        }
        if ($user1['battle'] > 0 && !$invis) {
          $ret.='<center>Персонаж сейчас в <a target=_blank href="logs.php?log='.$user1['battle'].'"><IMG height=12 width=12 src="'.IMGBASE.'/i/fighttype1.gif"> поединке</a></center>';
          $personline=1;
        }
        $ret.="</CENTER></SMALL></TD></TR>";
      }
/*          if ($trt) {
                echo "<TR><TD><IMG height=25 src=\"i/travma.gif\" width=40></TD><TD><SMALL>У персонажа $trt травма.</SMALL></TD></TR>";
            }
            while($row = mysql_fetch_array($dd)) {
                if ($row['time'] < time()) {
                    $row['time'] = time();
                }
                if ($row['type'] == 11 OR $row['type'] == 12 OR $row['type'] == 13 OR $row['type'] == 14) {
                    if ($row['sila']) echo "<TR><TD><IMG height=25 src=\"i/travma.gif\" width=40></TD><TD><SMALL>\"{$row['name']}\" - Ослаблен параметр \"сила\", еще ".floor(($row['time']-time())/60/60)." ч. ".round((($row['time']-time())/60)-(floor(($row['time']-time())/3600)*60))." мин.</SMALL></TD></TR>";
                    if ($row['lovk']) echo "<TR><TD><IMG height=25 src=\"i/travma.gif\" width=40></TD><TD><SMALL>\"{$row['name']}\" - Ослаблен параметр \"ловкость\", еще ".floor(($row['time']-time())/60/60)." ч. ".round((($row['time']-time())/60)-(floor(($row['time']-time())/3600)*60))." мин.</SMALL></TD></TR>";
                    if ($row['inta']) echo "<TR><TD><IMG height=25 src=\"i/travma.gif\" width=40></TD><TD><SMALL>\"{$row['name']}\" - Ослаблен параметр \"интуиция\", еще ".floor(($row['time']-time())/60/60)." ч. ".round((($row['time']-time())/60)-(floor(($row['time']-time())/3600)*60))." мин.</SMALL></TD></TR>";
                }
                if ($row['type'] == 2) {
                    echo "<TR><TD><IMG height=25 src=\"i/magic/sleep.gif\" width=40></TD><TD><SMALL>На персонажа наложено заклятие молчания. Будет молчать еще ".floor(($row['time']-time())/60/60)." ч. ".round((($row['time']-time())/60)-(floor(($row['time']-time())/3600)*60))." мин.</SMALL></TD></TR>";
                }
                if ($row['type'] == 10) {
                    echo "<TR><TD><IMG height=25 src=\"i/magic/chains.gif\" width=40></TD><TD><SMALL>На персонажа наложены путы. Не может двигатся еще ".floor(($row['time']-time())/60/60)." ч. ".round((($row['time']-time())/60)-(floor(($row['time']-time())/3600)*60))." мин.</SMALL></TD></TR>";
                }
                if ($row['type'] == 3) {
                    echo "<TR><TD><IMG height=25 src=\"i/magic/sleepf.gif\" width=40></TD><TD><SMALL>На персонажа наложено заклятие форумного молчания. Будет молчать еще ".floor(($row['time']-time())/60/60)." ч. ".round((($row['time']-time())/60)-(floor(($row['time']-time())/3600)*60))." мин.</SMALL></TD></TR>";
                }
            }*/
      $ret.="</TBODY></TABLE></CENTER></TD>
      <TD valign=top ".(!$pas?"style='width:350px;'":"").">
      <table><tr><td><BR>";
      if ($pas) {
        $user11 = mq("SELECT gsila,glovk,ginta,gintel FROM `inventory` WHERE (dressed = 1 AND owner = {$user1['id']}) or ".dresscond($user1));
        while($user12 = mysql_fetch_array($user11)){
          $sil=$sil+$user12['gsila'];
          $lov=$lov+$user12['glovk'];
          $int=$int+$user12['ginta'];
          $intel=$intel+$user12['gintel'];                                                                      
        }
        $user22 = mq("SELECT sila,lovk,inta,intel,mudra,type FROM `effects` WHERE (type = 188 or type=187 or type=".ADDICTIONEFFECT." or type=11 or type=12 or type=13 or type=14) AND owner = {$user1['id']}");
        while ($user33 = mysql_fetch_array($user22)) {
          if ($user33["type"]==11 || $user33["type"]==12 || $user33["type"]==13 || $user33["type"]==14) {
            $user33["sila"]=-$user33["sila"];
            $user33["lovk"]=-$user33["lovk"];
            $user33["inta"]=-$user33["inta"];
            $user33["intel"]=-$user33["intel"];
            $user33["mudra"]=-$user33["mudra"];
          }
          if($user33['sila']<>0){$sil=$sil+$user33['sila']; $cv_s="<FONT color=#007C00>"; $cv_s2="</FONT>";}
          if($user33['lovk']<>0){$lov=$lov+$user33['lovk']; $cv_l="<FONT color=#007C00>"; $cv_l2="</FONT>";}
          if($user33['inta']<>0){$int=$int+$user33['inta']; $cv_i="<FONT color=#007C00>"; $cv_i2="</FONT>";}
          if($user33['intel']<>0){$intel=$intel+$user33['intel']; $cv_it="<FONT color=#007C00>"; $cv_it2="</FONT>";}
          if($user33['mudra']<>0){$mudra=$mudra+$user33['mudra']; $cv_m="<FONT color=#007C00>"; $cv_m2="</FONT>";}
        }

        $user22 = mq("SELECT sila,lovk,inta,intel,mudra,type FROM `obshagaeffects` WHERE (type = 188 or type = 187 or type=".ADDICTIONEFFECT." or type=11 or type=12 or type=13 or type=14) AND owner = {$user1['id']}");
        while ($user33 = mysql_fetch_array($user22)) {
          if ($user33["type"]==11 || $user33["type"]==12 || $user33["type"]==13 || $user33["type"]==14) {
            $user33["sila"]=-$user33["sila"];
            $user33["lovk"]=-$user33["lovk"];
            $user33["inta"]=-$user33["inta"];
            $user33["intel"]=-$user33["intel"];
            $user33["mudra"]=-$user33["mudra"];
          }
          if($user33['sila']<>0){$sil=$sil+$user33['sila']; $cv_s="<FONT color=#007C00>"; $cv_s2="</FONT>";}
          if($user33['lovk']<>0){$lov=$lov+$user33['lovk']; $cv_l="<FONT color=#007C00>"; $cv_l2="</FONT>";}
          if($user33['inta']<>0){$int=$int+$user33['inta']; $cv_i="<FONT color=#007C00>"; $cv_i2="</FONT>";}
          if($user33['intel']<>0){$intel=$intel+$user33['intel']; $cv_it="<FONT color=#007C00>"; $cv_it2="</FONT>";}
          if($user33['mudra']<>0){$mudra=$mudra+$user33['mudra']; $cv_m="<FONT color=#007C00>"; $cv_m2="</FONT>";}
        }

        if (@$animal["sila"]) $sil+=$animal["sila"];
        if (@$animal["lovk"]) $lov+=$animal["lovk"];
        if (@$animal["inta"]) $int+=$animal["inta"];
        $sil2 = $user1['sila']-$sil;
        $lov2 = $user1['lovk']-$lov;
        $int2 = $user1['inta']-$int;
        $intel2 = $user1['intel']-$intel;
        $mudra2 = $user1["mudra"]-$mudra;

        if($sil<>0){$ss = "<small>($sil2 ".plusorminus($sil).")</small>";}
        if($lov<>0){$sl = "<small>($lov2 ".plusorminus($lov).")</small>";}
        if($int<>0){$si = "<small>($int2 ".plusorminus($int).")</small>";}
        if($intel<>0){$sii = "<small>($intel2 ".plusorminus($intel).")</small>";}
        if (@$animal["sila"]) {}

        $ret.="Сила: $cv_s<b>$user1[sila]</b>$cv_s2 $ss<BR>
        Ловкость: $cv_l<b>$user1[lovk]</b>$cv_l2 $sl<BR>
        Интуиция: $cv_i<b>$user1[inta]</b>$cv_i2 $si<BR>
        Выносливость: <b>$user1[vinos]</b><BR>";
        if ($user1['level'] > 3) {
          $ret.="Интеллект: $cv_it<b>$user1[intel]</b>$cv_it2 $sii<BR>";
        }
        if ($user1['level'] > 6) {
          if (!$mudra) $ret.="Мудрость: <b>$user1[mudra]</b><BR>";
          else $ret.="Мудрость: <b>$user1[mudra]</b> <small>($mudra2 + $mudra)</small><BR>";
        }
        if ($user1['level'] > 9) {
          $ret.="Духовность: <b>$user1[spirit]</b><BR>";
        }
        if ($user1['level'] > 12) {
          $ret.="Воля: <b>$user1[will]</b><BR>";
        }
        if ($user1['level'] > 15) {
          $ret.="Свобода духа: <b>$user1[freedom]</b><BR>";
        }
        if ($user1['level'] > 18) {
          $ret.="Божественность: <b>$user1[god]</b><BR>";
        }
      } else {
        $ret.="Сила: $user1[sila]<BR>
        Ловкость: $user1[lovk]<BR>
        Интуиция: $user1[inta]<BR>
        Выносливость: $user1[vinos]<BR>";
        if ($user1['level'] > 3) {
          $ret.="Интеллект: $user1[intel]<BR>";
        }
        if ($user1['level'] > 6) {
          $ret.="Мудрость: $user1[mudra]<BR>";
        }
        if ($user1['level'] > 9) {
          $ret.="Духовность: $user1[spirit]<BR>";
        }
        if ($user1['level'] > 12) {
          $ret.="Воля: $user1[will]<BR>";
        }
        if ($user1['level'] > 15) {
          $ret.="Свобода духа: $user1[freedom]<BR>";
        }
        if ($user1['level'] > 18) {
          $ret.="Божественность: $user1[god]<BR>";
        }
      }
      if (!$pas && (($user1['stats'] > 0) OR ($user1['master'] > 0))) {
        $ret.="&nbsp;<a href=\"umenie.php\">+ Способности</a>";
      }
      if ($pas){
        $ret.="<HR>";
        if ($_SESSION['uid'] == $id) {
          $ret.="<small>Опыт: <b>$user1[exp] </b> <a href='/exp.php' target=_blank> ($user1[nextup])</a><BR></small>";
          $ret.=forlevelup($user1);
        }
        $ret.="<small>Уровень: $user1[level]<BR></small>";
        if ($user1['otnoshenie']) {echo "";}
        if ($user1['showmyinfo']) {
          $ret.="<small>Побед: {$user1['win']}<BR></small>
          <small>Поражений: {$user1['lose']}<BR></small>
          <small>Ничьих: {$user1['nich']}<BR></small>";
        }
      } else {
        if ($_SESSION['uid'] == $id) {
          $ret.="<BR><BR>
          Опыт: <b>$user1[exp] </b> <a href='/exp.php' target=_blank> ($user1[nextup])</a><BR>";
          $ret.=forlevelup($user1);
        }
        $ret.="Уровень: $user1[level]<BR>
        Побед: $user1[win]<BR>
        Поражений: $user1[lose]<BR>
        Ничьих: $user1[nich]<BR>";
      }
      if (!$pas) {
        $ret.="Деньги: <b>$user1[money]</b> кр.<BR>
        Еврокредиты: <b>$user1[ekr]</b> екр.<BR>
         </b>";
      }
      if($user1['klan'] && !$pas) {
        $ret.="Клан: {$user1['klan']}<BR>";
      } elseif($user1['klan']) {
        $ret.="<small>Клан: <a href='/claninf.php?".close_dangling_tags($user1['klan'])."' target=_blank>".close_dangling_tags($user1['klan'])."</a> - ".close_dangling_tags($user1['status'])."<BR></small>";
      } elseif($user1['align'] > 0) {
        if (($user1['align'] > 1) && ($user1['align'] < 2)) $ret.="<small><b>Паладинский орден</B> - <b>{$user1['status']}</b><BR></small>";
        if (($user1['align'] > 3) && ($user1['align'] < 4)) $ret.="<small><b>Армада</B> - <b>{$user1['status']}</b><BR></small>";
        if (($user1['align'] == 3)) $ret.="<small><b>Темное братство</B><BR>";
        if (($user1['align'] == 2)) $ret.="<small><b>Нейтральное братство</B><BR>";
        if (($user1['align'] == 7.01)) $ret.="<small><b>Орден Очищения Стихий - Мастер Очищения Огня</B><BR></small>";
        if (($user1['align'] == 7.02)) $ret.="<small><b>Орден Очищения Стихий - Мастер Очищения Воды</B><BR></small>";
        if (($user1['align'] == 7.03)) $ret.="<small><b>Орден Очищения Стихий - Мастер Очищения Воздуха</B><BR></small>";
        if (($user1['align'] == 7.04)) $ret.="<small><b>Орден Очищения Стихий - Мастер Очищения Земли</B><BR></small>";
      }

      if ($pas) {
        $date1 = explode(" ", $user1['borntime']);
        $date2 = explode("-", $date1[0]);
        $date3 = "".$date2[2].".".$date2[1].".".$date2[0]."".$date2[3]."";
        $ret.="<small>Место рождения: <b>$user1[borncity]</b><BR></small>";
        if ($user1['secondgraj']) {
          $ret.="<small>Второе гражданство:<b> {$user1['secondgraj']}</b><BR></small>";
        }
        if ($user1['bejenec']) {
          $ret.="<small>Беженец из:<b> {$user1['bejenec']}</b><BR></small>";
        }
        if ($user1['otnoshenie']) {
          $ret.="<small>День рождения персонажа: до начала времен...<BR></small>";
        }
        if ($user1['showmyinfo']) {
          $ret.="<small>День рождения персонажа: {$user1['borntime']}<BR></small>";
        }
        if ($user1['namehistory']) {
          $ret.="<small>История имен: {$user1['namehistory']}<BR></small>";
        }
        if ($user1['level']>=0) {
          /*$ret.='                                                                                                                                                                                                                               <!--http://tekken.su-->
          <DIV id="dv22" style="display:"><A href="#" onclick="dv11.style.display=\'\'; dv22.style.display=\'none\'; return false"><small>Дополнительная информация</small></A></DIV><DIV id="dv11" style="display: none"><SMALL><B>Звание</B>: <IMG title=Новобранец src=/img/rank/rang/0.gif> [0/0] </SMALL><br>
          <SMALL>Авторитет: <B>0</B> <BR>Уважение: <FONT color=gray><B>0</B></FONT></SMALL><br>
          <SMALL>Побед над Ботиками: <B>0</B></SMALL></DIV>';*/
        }
        $ret.="<hr>";

        getadditdata($user1);
        $tites="";
        $alchtitles=array(1=>"Ставший на путь алхимии", 2=>"Ученик алхимика", 3=>"Старший ученик алхимика", 4=>"Подмастерье алхимика", 5=>"Познавший тайну алхимии", 6=>"Младший алхимик", 7=>"Алхимик", 8=>"Опытный алхимик", 9=>"Мастер алхимии", 10=>"Грандмастер алхимии");
        if ($user1["alchemylevel"]) $titles.="<img title=\"".$alchtitles[$user1["alchemylevel"]]."\" src=\"".IMGBASE."/i/titles/alchemy$user1[alchemylevel].gif\"> ";
        if ($titles) $ret.="$titles<hr>";

        if($user1['palcom'] && $pas) {
          $ret.="Сообщение от паладинов:<BR><FONT class=private>";
          $ret.="$user1[palcom]</font>";
        }
        
        $effect = mysql_fetch_array(mq("SELECT `time`,`type` FROM `effects` WHERE `owner` = '{$user1['id']}' and (`type` = '4' or `type` = '21') LIMIT 1;"));
        if ($effect['time']) {
          $eff=$effect['time'];
          $tt=time();
          $time_still=$eff-$tt;
          $tmp = floor($time_still/2592000);
          $id=0;
          if ($tmp > 0) {
            $id++;
            if ($id<3) {$out .= $tmp." мес. ";}
            $time_still = $time_still-$tmp*2592000;
          }
          $tmp = floor($time_still/604800);
          if ($tmp > 0) {
            $id++;
            if ($id<3) {$out .= $tmp." нед. ";}
            $time_still = $time_still-$tmp*604800;
          }
          $tmp = floor($time_still/86400);
          if ($tmp > 0) {
            $id++;
            if ($id<3) {$out .= $tmp." дн. ";}
            $time_still = $time_still-$tmp*86400;
          }
          $tmp = floor($time_still/3600);
          if ($tmp > 0) {
            $id++;
            if ($id<3) {$out .= $tmp." ч. ";}
            $time_still = $time_still-$tmp*3600;
          }
          $tmp = floor($time_still/60);
          if ($tmp > 0) {
            $id++;
            if ($id<3) {$out .= $tmp." мин. ";}
          }
          if ($effect['type']=='21') {
            $ret.="<br>В заточении еще <i>$out</i>";
          } else {      
            $ret.="<br>Хаос еще <i>$out</i>";
          }
      }
    }
    $ret.="</td></tr></table>";
  } else {
    $ret.="</table>";
  }
  return $ret;
}

function damfreq($f) {
  if ($f>80) return "регулярны";
  if ($f>60) return "часты";
  if ($f>30) return "временами";
  if ($f>20) return "малы";
  if ($f>10) return "редки";
  return "ничтожно редки";
}

function aligntype($a) {
  $lightaligns=array("0.99","1.1","1.2","1.21","1.5","1.7","1.75","1.9","1.91","1.92","1.99","2.1","2.2","2.5");
  $darkaligns=array("0.98","0.9801","0.9802","2.5", "3.001","3.01","3.02","3.05","3.06","3.07","3.075","3.09","3.091","3.092");
  $neutralaligns=array("7", "7.001", "7.002", "7.003", "7.004", "7.01", "7.02", "7.03");
  if (in_array($a,$lightaligns)) return 1;
  if (in_array($a,$darkaligns)) return 2;
  if (in_array($a,$neutralaligns)) return 3;
  return 0;
}

function samealign($a1, $a2) {
  if ($a1==$a2) return true;
  if (aligntype($a1)==aligntype($a2) && aligntype($a1)) return true;
  return false;
}

function canhold($user, $row) {
  global $caverooms;
  if ($row["prototype"]==1905 || $row["prototype"]==1906) {
    if ($user['level'] >= $row['nlevel']) return true;
    else return false;
  }
  if (incommontower($user) && $row["bs"]!=$user["in_tower"]) return false;
  if (
  ($row['nsila']==0 || $user['sila'] >= $row['nsila']) &&
  ($row['nlovk']==0 || $user['lovk'] >= $row['nlovk']) &&
  ($row['ninta']==0 || $user['inta'] >= $row['ninta']) &&
  ($row['nvinos']==0 || $user['vinos'] >= $row['nvinos']) &&
  ($row['nintel']==0 || $user['intel'] >= $row['nintel']) &&
  ($row['nmudra']==0 || $user['mudra'] >= $row['nmudra']) &&
  ($user['level'] >= $row['nlevel']) &&
  ((samealign($user['align'], $row['nalign']) && (float)$user['align']>=(float)$row['nalign']) || ($row['nalign'] == 0)) &&
  ($user['noj'] >= $row['nnoj']) &&
  ($user['topor'] >= $row['ntopor']) &&
  ($user['dubina'] >= $row['ndubina']) &&
  ($user['mec'] >= $row['nmech']) &&
  ($user['posoh'] >= $row['nposoh']) &&
  ($user['mfire'] >= $row['nfire']) &&
  ($user['mwater'] >= $row['nwater']) &&
  ($user['mair'] >= $row['nair']) &&
  ($user['mearth'] >= $row['nearth']) &&
  ($user['mlight'] >= $row['nlight']) &&
  ($user['mgray'] >= $row['ngray']) &&
  ($user['mdark'] >= $row['ndark']) &&
  ($row['duration'] < $row['maxdur']) &&
  (!$row['dategoden'] || $row['dategoden']>time()) &&
  (!$row["incave"] || in_array($user["room"], $caverooms) || in_array($user["room"], $canalrooms)) && 
  ($row['needident'] == 0)) return true;
  return false;
}

function wearable($t) {
  return ($t<26 || $t==50 || $t==187);
}

function showitem ($row, $link="", $noimg=0) {
  if(($row['type']>=25 && $row['maxdur'] <= $row['duration']) || (($row['dategoden'] && $row['dategoden'] <= time()))) {
    if (!$row["gift"] && strpos($row["name"], "Роба Блаженного Жреца")===false && strpos($row["name"], "Героический плащ")===false && strpos($row["name"], "Очень героический плащ")===false) destructitem($row['id']);
  }
  if ($row['magic']) $magic = magicinf($row['magic']);
  else $magic=false;
  if ($row['includemagic']) $incmagic=magicinf($row['includemagic']);
  //$incmagic = mysql_fetch_array(mq('SELECT * FROM `magic` WHERE `id` = \''.$row['includemagic'].'\' LIMIT 1;'));
  else $incmagic=false;
  $incmagic['name'] = $row['includemagicname'];
  $incmagic['cur'] = $row['includemagicdex'];
  $incmagic['max'] = $row['includemagicmax'];
  if(!$magic && $incmagic){
    $magic['chanse'] = $incmagic['chanse'];
    $magic['time'] = $incmagic['time'];
    $magic['targeted'] = $incmagic['targeted'];
  }
  global $user;
  // if shop
  if (@!$row['count'] && !$noimg) {
    echo "<TR bgcolor=#C7C7C7><td align=center width=100>";
    if ($incmagic['max']) {
        echo "<img src='mg2.php?p=".($incmagic['cur']/$incmagic['max']*100)."&i={$row['img']}' style=\"filter:shadow(color=red, direction=90, strength=3);\"><BR>";//<img ".((($row['maxdur']-2)<=$row['duration']  && $dress['duration'] > 2)?" style='background-image:url(i/blink.gif);' ":"")." src='i/sh/{$row['img']}' style=\"margin:0px,0px,-100000%,0px;\"><BR>
    } else {
        echo "<img ".((($row['maxdur']-2)<=$row['duration']  && $dress['duration'] > 2)?" style='background-image:url(".IMGBASE."/i/blink.gif);' ":"")." src='".IMGBASE."/i/sh/{$row['img']}'><BR>";
    }
    if (wearable($row["type"]) && canhold($user, $row)) {
        if (/*($row['type']==50) OR*/ ($row['type']==25) OR ($row['magic'] && ($row["magic"]<60 || $row["magic"]>90)) OR ($incmagic['cur'])) {
            //echo "<a  onclick=\"var obj; if (confirm('Использовать сейчас?')){ ".
            //(($magic['targeted']==1)?" obj = prompt('Введите название предмета (он должен быть у вас в рюкзаке)','');":"").
            //(($magic['targeted']==2)?" obj = prompt('Введите имя персонажа','');":"").
            //" window.navigate('main.php?edit=1&target='+obj+'&use={$row['id']}'); } \" href='#'>исп-ть</a><BR> ";
            echo "<a  onclick=\"";
            if($magic['id']==43) {
                echo "okno('Название встраиваемого свитка', 'main.php?edit=1&use={$row['id']}', 'target')";
            }elseif($row['magic']==245) {
                echo "okno('Введите название предмета', 'main.php?edit=1&use={$row['id']}', 'target')";
            }elseif($magic['targeted']==1) {
                echo "okno('Введите название предмета', 'main.php?edit=1&use={$row['id']}', 'target')";
            }elseif($magic['targeted']==2) {
                echo "findlogin('Введите имя персонажа', 'main.php?edit=1&use={$row['id']}', 'target')";
            }elseif($magic['targeted']==3) {
                echo "oknos('Введите имя зверя', 'main.php?edit=1&use={$row['id']}', 'target')";
            }elseif($magic['targeted']==4) {
                echo "note('Запрос', 'main.php?edit=1&use={$row['id']}', 'target')";
            }else {
                echo "UseMagick('$row[name]','main.php?edit=1&use=$row[id]', '$row[img]', '', 24575, '', ',,,,,,',0)";
                //echo "window.location='main.php?edit=1&use=".$row['id']."';";
            }
            echo "\"href='#'>исп-ть</a><BR> ";
        }
        if (($row['type']!=50) && ($row['type']!=12) && $row["duration"]<$row["maxdur"]) echo "<a ".($row["destinyinv"]==1?"onclick=\"UseMagick('$row[name]','?edit=1&dress=$row[id]', '$row[img]', '', 24575, '', ',,,,,,',1)\" href=\"#\"":"href='?edit=1&dress={$row['id']}'").">надеть</a> ";
    } elseif (($row['type']==50 || $row['type']==54) OR ($row['type']==25) OR ($row['magic']) OR ($incmagic['cur'])) {
        //if ($user['id'] == 7) {
            //echo '<pre>';
            //print_r($magic);
            //echo '</pre>';
        //}
      echo "<a  onclick=\"";
      if($magic['id']==43) {
          echo "okno('Название встраиваемого свитка', 'main.php?edit=1&use={$row['id']}', 'target')";
      }elseif($row['magic']==245) {
          echo "okno('Введите название предмета', 'main.php?edit=1&use={$row['id']}', 'target')";
      }elseif($magic['targeted']==1) {
          echo "okno('Введите название предмета', 'main.php?edit=1&use={$row['id']}', 'target')";
      }elseif($magic['targeted']==2) {
          echo "findlogin('Введите имя персонажа', 'main.php?edit=1&use={$row['id']}', 'target')";
      }elseif($magic['targeted']==3) {
          echo "oknos('Введите имя зверя', 'main.php?edit=1&use={$row['id']}', 'target')";
      }elseif($magic['targeted']==4) {
          echo "note('Запрос', 'main.php?edit=1&use={$row['id']}', 'target')";
      } else {
        echo "UseMagick('$row[name]','main.php?edit=1&use=$row[id]', '$row[img]', '', 24575, '', ',,,,,,',0)";
        //echo "window.location='main.php?edit=1&use=".$row['id']."';";
      } /*else {
          echo "window.location='main.php?edit=1&use=".$row['id']."';";
      }*/
      echo "\" href='#'>исп-ть</a><BR> ";
    }
    if ($row["koll"]) echo "<div style=\"font-size:3px\">&nbsp;</div>
    <a title=\"Собрать\" href=\"/main.php?$link&stack=$row[id]\"><img border=\"0\" src=\"".IMGBASE."/i/stack.gif\"></a>
    <a title=\"Разделить\" onclick=\"splitstack('$row[name]','main.php?edit=1&unstack=$row[id]', '$row[img]', 1);return false;\" href=\"javascript:void(0)\"><img border=\"0\" src=\"".IMGBASE."/i/unstack.gif\"></a>
    <a title=\"Разделить поровну\" onclick=\"splitstack('$row[name]','main.php?edit=1&split=$row[id]', '$row[img]', 2);return false;\" href=\"javascript:void(0)\"><img border=\"0\" src=\"".IMGBASE."/i/splitstack.gif\"></a>&nbsp;";
    elseif ($row["type"]!=199 || $_SESSION["uid"]==924) echo "<img style=\"cursor:hand;\" title=\"Добавить/удалить из избранного\" onclick=\"document.location.href='main.php?$link&tofav=$row[id]'\" src=".IMGBASE."/i/misc/qlaunch/add_itm2.gif>&nbsp;&nbsp;";
    if ($row["type"]!=199 || $_SESSION["uid"]==924) echo "<img src=".IMGBASE."/i/clear.gif style=\"cursor:hand;\" onclick=\"if (confirm('Предмет {$row['name']} будет утерян, вы уверены?')) window.location='main.php?edit=1&destruct=".$row['id']."'\">";
    echo "</td><td>";
  }

  // end if shop
  echo itemdata($row);
  echo "</td></TR>";
}

function itemneeds($id) {
    $str = '';
    $item = mqfa("SELECT * FROM shop_rel WHERE id = $id");
    if ($item) {
      $name = mysql_result(mysql_query('SELECT name FROM shop WHERE id = ' . $item['rid']), 0, 0);
      if ($name) {
        $str .= '<br>Требуется предмет:';
        $str .= ' ' . $name . ' (x' . $item['count'] . ')';
      }
    }
    return $str;
}

function itemdata($row) {
  $ret="";
  $magic = magicinf($row['magic']);
  if ($row['destinyinv']>0) {
    $ret.="<a href=#>$row[name]".((isset($row['items_count'])&&$row['items_count']>1)?' (x'.$row['items_count'].')':'')."</a><img src=".IMGBASE."/i/align_{$row['nalign']}.gif> (Масса: ".(((float)$row['massa']) * (isset($row['items_count'])?$row['items_count']:1)).")<img src=\"".IMGBASE."/i/klan/{$row['clan']}.gif\"><img src=".IMGBASE."/i/destiny{$row['destinyinv']}.gif alt=\"Этот предмет связан с Вами общей судьбой. Вы не можете передать его кому-либо еще.\"><img src=".IMGBASE."/i/artefact{$row['artefact']}.gif>".(($row['present'])?' <IMG SRC="'.IMGBASE.'/i/podarok.gif" WIDTH="16" HEIGHT="18" BORDER=0 TITLE="Этот предмет вам подарил '.$row['present'].'. Вы не сможете передать этот предмет кому-либо еще." ALT="Этот предмет вам подарил '.$row['present'].'. Вы не сможете передать этот предмет кому-либо еще.">':"")."<BR>";
  } elseif ($row['destiny']>0) {
    $ret.="<a href=#>$row[name]".((isset($row['items_count'])&&$row['items_count']>1)?' (x'.$row['items_count'].')':'')."</a><img src=".IMGBASE."/i/align_{$row['nalign']}.gif> (Масса: ".(((float)$row['massa']) * (isset($row['items_count'])?$row['items_count']:1)).")<img src=\"".IMGBASE."/i/klan/{$row['clan']}.gif\"><img src=".IMGBASE."/i/destiny{$row['destiny']}.gif alt=\"Этот предмет будет связан с Вами общей судьбой. Вы не сможете передать его кому-либо еще.\"><img src=".IMGBASE."/i/artefact{$row['artefact']}.gif>".(($row['present'])?' <IMG SRC="'.IMGBASE.'/i/podarok.gif" WIDTH="16" HEIGHT="18" BORDER=0 TITLE="Этот предмет вам подарил '.$row['present'].'. Вы не сможете передать этот предмет кому-либо еще." ALT="Этот предмет вам подарил '.$row['present'].'. Вы не сможете передать этот предмет кому-либо еще.">':"")."<BR>";
  } else {
    $ret.="<a href=#>$row[name]".((isset($row['items_count'])&&$row['items_count']>1)?' (x'.$row['items_count'].')':'')."</a>";
    if($row['koll']>'0') $ret.=" <b>(x$row[koll])</b>";
    $ret.="<img src=\"".IMGBASE."/i/align_{$row['nalign']}.gif\"> (Масса: ".(((float)$row['massa']) * (isset($row['items_count'])?$row['items_count']:1)).")<img src=\"".IMGBASE."/i/klan/{$row['clan']}.gif\"><img src=".IMGBASE."/i/destiny{$row['destiny']}.gif><img src=".IMGBASE."/i/artefact{$row['artefact']}.gif>".(($row['present'])?' <IMG SRC="'.IMGBASE.'/i/podarok.gif" WIDTH="16" HEIGHT="18" BORDER=0 TITLE="Этот предмет вам подарил '.$row['present'].'. Вы не сможете передать этот предмет кому-либо еще." ALT="Этот предмет вам подарил '.$row['present'].'. Вы не сможете передать этот предмет кому-либо еще.">':"")."<BR>";
  }

  if($row['ecost']>0) { $ret.="<b>Цена: {$row['ecost']} екр.".($_SESSION["uid"]==7?"/$row[cost]":"")."</b> &nbsp; &nbsp;"; } 
  elseif($row['cost']>0 && $row['silverzeton']==0 && $row['goldzeton']==0 && $row['zeton']==0 && $row["honor_cost"]==0) { $ret.="<b>Цена: {$row['cost']} кр.</b> &nbsp; &nbsp;"; }
  if($row['honor_cost']>0) { $ret.="<b>Цена: (<SMALL><img src=/i/zub_low1.gif alt=\"Белый зуб\">{$row['honor_cost']}</SMALL>)</b> &nbsp; &nbsp;"; }
  if($row['zeton']>0) { $ret.="<br><b>Жетон: {$row['zeton']}</b>&nbsp<br>"; }
  if($row['silverzeton']>0) { $ret.="<br><b>Серебряный жетон: {$row['silverzeton']}</b>&nbsp<br>"; }
  if($row['goldzeton']>0) { $ret.="<br><b>Золотой жетон: {$row['goldzeton']}</b>&nbsp<br>"; }
  if(@$row['count']) {
    $ret.="<small>(количество: {$row['count']})</small>";
  }

  //if ($_SERVER['REMOTE_ADDR'] == '195.62.137.42') {
    $ret .= itemneeds($row['prototype']?$row['prototype']:$row['id']);
  //}
  $ret.="<br>";
  //if($row['type']!=200){
    $ret.="Долговечность: {$row['duration']}/{$row['maxdur']}<BR>";
  //}

  if (!$row['needident']) {
    if ($row["prototype"]==101772 || $row["id"]==101772) $magic["time"]=120*60;
    if ($row["prototype"]==101773 || $row["id"]==101773) $magic["time"]=360*60;
    if ($row["prototype"]==101774 || $row["id"]==101774) $magic["time"]=720*60;
    $ret.=(($magic['chanse'])?"Вероятность срабатывания: ".$magic['chanse']."%<BR>":"")."
    ".(($magic['time'])?"Продолжительность действия магии: ".secs2hrs($magic['time']*60, 1)."<BR>":"");
    if ($row["goden"]>0) {
      $gs="$row[goden] дн.";
    } elseif ($row["goden"]<0) {
      $gs=abs($row["goden"])." час".($row["goden"]<-4?"ов":($row["goden"]<-1?"ов":""));
    }
    if ($row["dategoden"]>time()) {
        if ($row['goden']) {
            $ret.="Срок годности: $gs ".((!$row['count'])?"(до ".date("Y.m.d H:i",$row['dategoden']).")":"")."<BR>";
        } else {
            $ret.="Срок годности: ".((!$row['count'])?"до ".date("Y.m.d H:i",$row['dategoden']):"")."<BR>";
        }
    }
    elseif ($row["goden"]) $ret.="Срок годности: $gs<BR>";
    $ret.=itemreqs($row);
    $ret.=itemmfs($row);
    if ($row["dategoden"] && $row["dategoden"]<time() && $row["owner"]<_BOTSEPARATOR_) $ret.="<small><font color=maroon>Предмет устарел</font></small><BR>";
  } else $ret.="<font color=maroon><B>Свойства предмета не идентифицированы</B></font><BR>";
  return $ret;
}

function itemreqs($row, $user1=0) {
  global $user, $caverooms;
  if (!$user1) $user1=&$user;
  return (($row['nsila'] OR $row['nlovk'] OR $row['ninta'] OR $row['nvinos'] OR $row['nlevel'] OR $row['nintel'] OR $row['nmudra'] OR $row['nnoj'] OR $row['ntopor'] OR $row['ndubina'] OR $row['nmech'] OR $row['nfire'] OR $row['nwater'] OR $row['nair'] OR $row['nearth'] OR $row['nearth'] OR $row['nlight'] OR $row['ngray'] OR $row['ndark'] OR $row['incave'])?"<b>Требуется минимальное:</b><BR>":"")."
  ".(($row['incave']>0)?"• ".(!in_array($user["room"], $caverooms)?"<font color=red>":"")."Место использования: подземелья</font><BR>":"")."
  ".(($row['nlevel']>0)?"• ".(($row['nlevel'] > $user1['level'])?"<font color=red>":"")."Уровень: {$row['nlevel']}</font><BR>":"")."
  ".(($row['nsila']>0)?"• ".(($row['nsila'] > $user1['sila'])?"<font color=red>":"")."Сила: {$row['nsila']}</font><BR>":"")."
  ".(($row['nlovk']>0)?"• ".(($row['nlovk'] > $user1['lovk'])?"<font color=red>":"")."Ловкость: {$row['nlovk']}</font><BR>":"")."
  ".(($row['ninta']>0)?"• ".(($row['ninta'] > $user1['inta'])?"<font color=red>":"")."Интуиция: {$row['ninta']}</font><BR>":"")."
  ".(($row['nvinos']>0)?"• ".(($row['nvinos'] > $user1['vinos'])?"<font color=red>":"")."Выносливость: {$row['nvinos']}</font><BR>":"")."
  ".(($row['nintel']>0)?"• ".(($row['nintel'] > $user1['intel'])?"<font color=red>":"")."Интеллект: {$row['nintel']}</font><BR>":"")."
  ".(($row['nmudra']>0)?"• ".(($row['nmudra'] > $user1['mudra'])?"<font color=red>":"")."Мудрость: {$row['nmudra']}</font><BR>":"")."
  ".(($row['nnoj']>0)?"• ".(($row['nnoj'] > $user1['noj'])?"<font color=red>":"")."Мастерство владения ножами и кастетами: {$row['nnoj']}</font><BR>":"")."
  ".(($row['ntopor']>0)?"• ".(($row['ntopor'] > $user1['topor'])?"<font color=red>":"")."Мастерство владения топорами и секирами: {$row['ntopor']}</font><BR>":"")."
  ".(($row['ndubina']>0)?"• ".(($row['ndubina'] > $user1['dubina'])?"<font color=red>":"")."Мастерство владения дубинами и булавами: {$row['ndubina']}</font><BR>":"")."
  ".(($row['nmech']>0)?"• ".(($row['nmech'] > $user1['mec'])?"<font color=red>":"")."Мастерство владения мечами: {$row['nmech']}</font><BR>":"")."
  ".(($row['nposoh']>0)?"• ".(($row['nposoh'] > $user1['posoh'])?"<font color=red>":"")."Мастерство владения магическими посохами: {$row['nposoh']}</font><BR>":"")."
  ".(($row['nfire']>0)?"• ".(($row['nfire'] > $user1['mfire'])?"<font color=red>":"")."Мастерство владения стихией Огня: {$row['nfire']}</font><BR>":"")."
  ".(($row['nwater']>0)?"• ".(($row['nwater'] > $user1['mwater'])?"<font color=red>":"")."Мастерство владения стихией Воды: {$row['nwater']}</font><BR>":"")."
  ".(($row['nair']>0)?"• ".(($row['nair'] > $user1['mair'])?"<font color=red>":"")."Мастерство владения стихией Воздуха: {$row['nair']}</font><BR>":"")."
  ".(($row['nearth']>0)?"• ".(($row['nearth'] > $user1['mearth'])?"<font color=red>":"")."Мастерство владения стихией Земли: {$row['nearth']}</font><BR>":"")."
  ".(($row['nlight']>0)?"• ".(($row['nlight'] > $user1['mlight'])?"<font color=red>":"")."Мастерство владения магией Света: {$row['nlight']}</font><BR>":"")."
  ".(($row['ngray']>0)?"• ".(($row['ngray'] > $user1['mgray'])?"<font color=red>":"")."Мастерство владения серой магией: {$row['ngray']}</font><BR>":"")."
  ".(($row['ndark']>0)?"• ".(($row['ndark'] > $user1['mdark'])?"<font color=red>":"")."Мастерство владения магией Тьмы: {$row['ndark']}</font><BR>":"");
}

function itemmfs($row) {
  global $user;
  static $setnames;
  include_once("config/setnames.php");
  if ($row['magic']) $magic = magicinf ($row['magic']);
  else $magic=false;
  $ret["mfs"]="";
  $ret["itemmfs"]="";
  $ret["features"]="";
  $ret["addit"]="";
  if ($row['minu']) $ret[($row["type"]==3?"item":"")."mfs"].="• Минимальное наносимое повреждение: {$row['minu']}<BR>";
  if ($row['maxu']) $ret[($row["type"]==3?"item":"")."mfs"].="• Максимальное наносимое повреждение: {$row['maxu']}<BR>";
  if ($row['gsila'] || ($row['stats'] && $row["owner"]==$user["id"])) $ret["mfs"].="• Сила: ".(($row['gsila']>0)?"+":"")."{$row['gsila']} ".($row['stats'] && $row["owner"]==$user["id"]?"<a onclick=\"return confirm('Увеличить параметр сила?')\" href=\"main.php?edit=1&raisestat=sila&item=$row[id]\"><img src=\"".IMGBASE."/i/plus.gif\" height=11 width=11 border=0></a>":"")."<BR>";
  if ($row['glovk'] || ($row['stats'] && $row["owner"]==$user["id"])) $ret["mfs"].="• Ловкость: ".(($row['glovk']>0)?"+":"")."{$row['glovk']} ".($row['stats'] && $row["owner"]==$user["id"]?"<a onclick=\"return confirm('Увеличить параметр ловкость?')\" href=\"main.php?edit=1&raisestat=lovk&item=$row[id]\"><img src=\"".IMGBASE."/i/plus.gif\" height=11 width=11 border=0></a>":"")."<BR>";
  if ($row['ginta'] || ($row['stats'] && $row["owner"]==$user["id"])) $ret["mfs"].="• Интуиция: ".(($row['ginta']>0)?"+":"")."{$row['ginta']} ".($row['stats'] && $row["owner"]==$user["id"]?"<a onclick=\"return confirm('Увеличить параметр интуиция?')\" href=\"main.php?edit=1&raisestat=inta&item=$row[id]\"><img src=\"".IMGBASE."/i/plus.gif\" height=11 width=11 border=0></a>":"")."<BR>";
  if ($row['gintel'] || ($row['stats'] && $row["owner"]==$user["id"])) $ret["mfs"].="• Интеллект: ".(($row['gintel']>0)?"+":"")."{$row['gintel']} ".($row['stats'] && $row["owner"]==$user["id"]?"<a onclick=\"return confirm('Увеличить параметр интеллект?')\" href=\"main.php?edit=1&raisestat=intel&item=$row[id]\"><img src=\"".IMGBASE."/i/plus.gif\" height=11 width=11 border=0></a>":"")."<BR>";
  if ($row['stats']) $ret["mfs"].="• Количество увеличений: +$row[stats]<BR>";
  if ($row['ghp']) $ret["mfs"].="• Уровень жизни: ".plusorminus($row['ghp'])."<BR>";
  if ($row['gmana']) $ret["mfs"].="• Уровень маны: +{$row['gmana']}<BR>";
  if ($row['mfkrit']) $ret["mfs"].="• Мф. критических ударов: ".(($row['mfkrit']>0)?"+":"")."{$row['mfkrit']}%<BR>";
  if ($row['mfakrit']) $ret["mfs"].="• Мф. против крит. ударов: ".(($row['mfakrit']>0)?"+":"")."{$row['mfakrit']}%<BR>";
  if ($row['mfkritpow']) $ret["mfs"].="• Мф. мощности крит. удара: ".(($row['mfkritpow']>0)?"+":"")."{$row['mfkritpow']}%<BR>";
  if ($row['mfantikritpow']) $ret["mfs"].="• Мф. против мощ. крит. удара: ".(($row['mfantikritpow']>0)?"+":"")."{$row['mfantikritpow']}%<BR>";
  if ($row['mfparir']) $ret["mfs"].="• Мф. парирования: ".(($row['mfparir']>0)?"+":"")."{$row['mfparir']}%<BR>";
  if ($row['mfshieldblock']) $ret["mfs"].="• Мф. блока щитом: ".(($row['mfshieldblock']>0)?"+":"")."{$row['mfshieldblock']}%<BR>";
  if ($row['mfcontr']) $ret["mfs"].="• Мф. контрудара: ".(($row['mfcontr']>0)?"+":"")."{$row['mfcontr']}%<BR>";
  if ($row['mfuvorot']) $ret["mfs"].="• Мф. увертывания: ".(($row['mfuvorot']>0)?"+":"")."{$row['mfuvorot']}%<BR>";
  if ($row['mfauvorot']) $ret["mfs"].="• Мф. против увертывания: ".(($row['mfauvorot']>0)?"+":"")."{$row['mfauvorot']}%<BR>";
  if ($row['mfproboj']) $ret[($row["type"]==3?"item":"")."mfs"].="• Мф. пробоя брони: ".(($row['mfauvorot']>0)?"+":"")."{$row['mfproboj']}%<BR>";
  if ($row['gnoj']) $ret[($row["type"]==3?"item":"")."mfs"].="• Мастерство владения ножами и кастетами: +{$row['gnoj']}<BR>";
  if ($row['gtopor']) $ret[($row["type"]==3?"item":"")."mfs"].="• Мастерство владения топорами и секирами: +{$row['gtopor']}<BR>";
  if ($row['gdubina']) $ret[($row["type"]==3?"item":"")."mfs"].="• Мастерство владения дубинами и булавами: +{$row['gdubina']}<BR>";
  if ($row['gmech']) $ret[($row["type"]==3?"item":"")."mfs"].="• Мастерство владения мечами: +{$row['gmech']}<BR>";
  if ($row['gposoh']) $ret[($row["type"]==3?"item":"")."mfs"].="• Мастерство владения магическими посохами: +{$row['gposoh']}<BR>";
  if ($row['gfire']) $ret["mfs"].="• Мастерство владения стихией Огня: +{$row['gfire']}<BR>";
  if ($row['gwater']) $ret["mfs"].="• Мастерство владения стихией Воды: +{$row['gwater']}<BR>";
  if ($row['gair']) $ret["mfs"].="• Мастерство владения стихией Воздуха: +{$row['gair']}<BR>";
  if ($row['gearth']) $ret["mfs"].="• Мастерство владения стихией Земли: +{$row['gearth']}<BR>";
  if ($row['glight']) $ret["mfs"].="• Мастерство владения магией Света: +{$row['glight']}<BR>";
  if ($row['ggray']) $ret["mfs"].="• Мастерство владения серой магией: +{$row['ggray']}<BR>";
  if ($row['gdark']) $ret["mfs"].="• Мастерство владения магией Тьмы: +{$row['gdark']}<BR>";
  if ($row['bron1']) $ret["mfs"].="• Броня головы: $row[bronmin1] - $row[bron1]<BR>";
  if ($row['bron2']) $ret["mfs"].="• Броня корпуса: $row[bronmin2] - $row[bron2]<BR>";
  if ($row['bron3']) $ret["mfs"].="• Броня пояса: $row[bronmin3] - $row[bron3]<BR>";
  if ($row['bron4']) $ret["mfs"].="• Броня ног: $row[bronmin4] - $row[bron4]<BR>";

  if ($row['mfdhit']) $ret[($row["type"]==8 || $row["type"]==4 || $row["type"]==24 || $row["type"]==11?"item":"")."mfs"].="• Защита от урона: ".(($row['mfdhit']>0)?"+":"")."$row[mfdhit]<BR>";

  if ($row['mfdkol']) $ret[($row["type"]==8 || $row["type"]==4 || $row["type"]==24 || $row["type"]==11?"item":"")."mfs"].="• Защита от колющего урона: ".(($row['mfdkol']>0)?"+":"")."{$row['mfdkol']}<BR>";
  if ($row['mfdrub']) $ret[($row["type"]==8 || $row["type"]==4 || $row["type"]==24 || $row["type"]==11?"item":"")."mfs"].="• Защита от рубящего урона: ".(($row['mfdrub']>0)?"+":"")."{$row['mfdrub']}<BR>";
  if ($row['mfdrej']) $ret[($row["type"]==8 || $row["type"]==4 || $row["type"]==24 || $row["type"]==11?"item":"")."mfs"].="• Защита от режущего урона: ".(($row['mfdrej']>0)?"+":"")."{$row['mfdrej']}<BR>";
  if ($row['mfddrob']) $ret[($row["type"]==8 || $row["type"]==4 || $row["type"]==24 || $row["type"]==11?"item":"")."mfs"].="• Защита от дробящего урона: ".(($row['mfddrob']>0)?"+":"")."{$row['mfddrob']}<BR>";
  if ($row['mfdmag']) $ret["mfs"].="• Защита от магии: ".(($row['mfdmag']>0)?"+":"")."{$row['mfdmag']}<BR>";
  if ($row['mfdfire']) $ret["mfs"].="• Защита от магии огня: ".(($row['mfdfire']>0)?"+":"")."{$row['mfdfire']}<BR>";
  if ($row['mfdwater']) $ret["mfs"].="• Защита от магии воды: ".(($row['mfdwater']>0)?"+":"")."{$row['mfdwater']}<BR>";
  if ($row['mfdair']) $ret["mfs"].="• Защита от магии воздуха: ".(($row['mfdair']>0)?"+":"")."{$row['mfdair']}<BR>";
  if ($row['mfdearth']) $ret["mfs"].="• Защита от магии земли: ".(($row['mfdearth']>0)?"+":"")."{$row['mfdearth']}<BR>";
  if ($row['mfdlight']) $ret["mfs"].="• Защита от магии света: ".(($row['mfdlight']>0)?"+":"")."{$row['mfdlight']}<BR>";
  if ($row['mfddark']) $ret["mfs"].="• Защита от магии тьмы: ".(($row['mfddark']>0)?"+":"")."{$row['mfddark']}<BR>";
  if ($row['manausage']) $ret["mfs"].="• Уменьшение расхода маны: ".(($row['manausage']>0)?"+":"")."{$row['manausage']}%<BR>";
  if ($row['minusmfdmag']) $ret["mfs"].="• Подавление защиты от магии: ".(($row['minusmfdmag']>0)?"+":"")."{$row['minusmfdmag']}<BR>";
  if ($row['minusmfdfire']) $ret["mfs"].="• Подавление защиты от Огня: ".(($row['minusmfdfire']>0)?"+":"")."{$row['minusmfdfire']}<BR>";
  if ($row['minusmfdair']) $ret["mfs"].="• Подавление защиты от Воздуха: ".(($row['minusmfdair']>0)?"+":"")."{$row['minusmfdair']}<BR>";
  if ($row['minusmfdwater']) $ret["mfs"].="• Подавление защиты от Воды: ".(($row['minusmfdwater']>0)?"+":"")."{$row['minusmfdwater']}<BR>";
  if ($row['minusmfdearth']) $ret["mfs"].="• Подавление защиты от Земли: ".(($row['minusmfdearth']>0)?"+":"")."{$row['minusmfdearth']}<BR>";
  if ($row['mfhitp']) $ret[($row["type"]==3?"item":"")."mfs"].="• Мф. мощности урона: ".(($row['mfhitp']>0)?"+":"")."{$row['mfhitp']}%<BR>";
  if ($row['mfrub']) $ret[($row["type"]==3?"item":"")."mfs"].="• Мф. мощности рубящего урона: ".(($row['mfrub']>0)?"+":"")."{$row['mfrub']}%<BR>";
  if ($row['mfkol']) $ret[($row["type"]==3?"item":"")."mfs"].="• Мф. мощности колющего урона: ".(($row['mfkol']>0)?"+":"")."{$row['mfkol']}%<BR>";
  if ($row['mfdrob']) $ret[($row["type"]==3?"item":"")."mfs"].="• Мф. мощности дробящего урона: ".(($row['mfdrob']>0)?"+":"")."{$row['mfdrob']}%<BR>";
  if ($row['mfrej']) $ret[($row["type"]==3?"item":"")."mfs"].="•  Мф. мощности режущего урона: ".(($row['mfrej']>0)?"+":"")."{$row['mfrej']}%<BR>";
  if ($row['mfmagp']) $ret["mfs"].="• Мф. мощности магии стихий: ".(($row['mfmagp']>0)?"+":"")."{$row['mfmagp']}%<BR>";
  if ($row['mffire']) $ret["mfs"].="• Мф. мощности магии огня: ".(($row['mffire']>0)?"+":"")."{$row['mffire']}%<BR>";
  if ($row['mfwater']) $ret["mfs"].="• Мф. мощности магии воды: ".(($row['mfwater']>0)?"+":"")."{$row['mfwater']}%<BR>";
  if ($row['mfair']) $ret["mfs"].="• Мф. мощности магии воздуха: ".(($row['mfair']>0)?"+":"")."{$row['mfair']}%<BR>";
  if ($row['mfearth']) $ret["mfs"].="• Мф. мощности магии земли: ".(($row['mfearth']>0)?"+":"")."{$row['mfearth']}%<BR>";
  if ($row['mflight']) $ret["mfs"].="• Мф. мощности магии света: ".(($row['mflight']>0)?"+":"")."{$row['mflight']}%<BR>";
  if ($row['mfdark']) $ret["mfs"].="• Мф. мощности магии тьмы: ".(($row['mfdark']>0)?"+":"")."{$row['mfdark']}%<BR>";
  if ($row['chkol']) $ret["features"].="•  Колющие атаки: ".damfreq($row['chkol'])."<BR>";
  if ($row['chrej']) $ret["features"].="•  Режущие атаки: ".damfreq($row['chrej'])."<BR>";
  if ($row['chrub']) $ret["features"].="•  Рубящие атаки: ".damfreq($row['chrub'])."<BR>";
  if ($row['chdrob']) $ret["features"].="•  Дробящие атаки: ".damfreq($row['chdrob'])."<BR>";
  if ($row['chmag']) $ret["features"].="•  Магические атаки: ".damfreq($row['chmag'])."<BR>";
  if ($row['gmeshok']) $ret["mfs"].="• Увеличивает рюкзак: +{$row['gmeshok']}<BR>";
  if ($row['blockzones']) $ret["itemmfs"].="•  Зоны блокирования ".plusorminus($row["blockzones"], 0)."<BR>";
  if ($row['gmp']) $ret["addit"].="Расход маны: $row[gmp]<BR>";
  if ($row['type']!=3 && $row['dvur']) $ret["mfs"].="•  Точек удара за ход: +1<BR>";

  if ($row['onlyone']) $ret["addit"].="Уникальный предмет. Максимум 1 ед.<br>";
  if ($row['letter']) $ret["addit"].="Количество символов: ".strlen($row['letter'])."<br>";
  if ($row['letter']) $ret["addit"].="На бумаге записан текст:<div style='background-color:FAF0E6;'> ".nl2br($row['letter'])."</div>";
  if ($magic['name'] && $row['type'] != 50) $ret["addit"].="<font color=maroon>Наложены заклятия:</font> ".$magic['name']."<BR>";
  if ($row['includemagicname']) $ret["addit"].="<font color=maroon>Наложены заклятия:</font> ".$row['includemagicname']."<BR>";
  if ($row['text']) $ret["addit"].="На ".($row["type"]==3?"ручке":($row["type"]==2?"ожерелье":"кольце"))." выгравирована надпись:<center>".$row['text']."</center><BR>";
  if ($row['opisan']) $ret["addit"].="<small><b>".($row["gift"]?"":"Описание:")."</b><br>".$row['opisan']."</small><BR>";
  if ($row['setid']) $ret["addit"].="<small>Часть комплекта: <b>".$setnames[$row["setid"]]."</b><BR>";
  if ($incmagic['max']) $ret["addit"].=" Встроено заклятие <img src=\"".IMGBASE."/i/magic/".$incmagic['img']."\" alt=\"".$incmagic['name']."\"> ".$incmagic['cur']." шт.".($row["includemagicusesperday"]?", $row[includemagicusesperday] шт. в день":"")."   ".($row["includemagicusesperbattle"]?", $row[includemagicusesperbattle] шт. за бой":"")."<BR>";
  if ($row['podzem']==1 || $row['podzem']==3) $ret["addit"].="<br><font style='font-size:11px; color:#990000'>Предмет из подземелья</font><BR>";
  if ($row['podzem']==2) $ret["addit"].="<br><font style='font-size:11px; color:#990000'>Подарок от алхимика</font><BR>";
  if ($row['second'] && $row['type']==3) $ret["addit"].="<font style='font-size:11px; color:#990000'>второе оружие</font><BR>";
  if ($row['dvur'] && $row["type"]==3) $ret["addit"].="<font style='font-size:11px; color:#990000'>двуручное оружие</font><BR>";
  if ($row['type']!=3 && $row['second']) $ret["addit"].="<font style='font-size:11px; color:#990000'>даёт возможность использовать дополнительное заклинание каждый ход</font><BR>";
  if (!$row['isrep']) $ret["addit"].="<small><font color=maroon>Предмет не подлежит ремонту</font></small><BR>";

  return ($ret["mfs"]?"<b>Действует на:</b><BR>$ret[mfs]":"").
  ($ret["itemmfs"]?"<b>Свойства предмета:</b><BR>$ret[itemmfs]":"").
  ($ret["features"]?"<b>Особенности:</b><BR>$ret[features]":"").
  $ret["addit"];

  return $ret;
}
// magic
function magicinf ($id) {
  /*static $cache;
  if (@$cache[$id]) {
    return $cache[$id];
  }
  $ret=mysql_fetch_array(mq("SELECT * FROM `magic` WHERE `id` = '{$id}' LIMIT 1;"));
  $cache[$id]=$ret;
  return $ret;*/
  static $magics;
  if (!$magics) {
    $d=implode("",file("data/magics.dat"));
    $magics=unserialize($d);
    //$r=mq("select * from magic");
    //while ($rec=mysql_fetch_assoc($r)) $magics[$rec["id"]]=$rec;
  }  
  return $magics[$id];
}

function lefttime($time) {
  return secs2hrs($time-time());
  return max(0, ceil(($time-time())/60))." мин.";
}

function showeffects($userid) {
  global $user;
  getadditdata($user);
  $r=mq('SELECT * FROM `effects` WHERE `owner` ='.$userid.' and (type=11 or type=12 or type=13 or type=14 or type=22 or type=26 or type=31 or type=32 or type=33 or type=34 or type=35 or type=38 or type=49 or type=185 or type=186 or `type`=187 or `type`=188 or `type`=395 or `type`=396 or `type`=201 or `type`=202 or `type`=1022 or `type`=54 or type=28 or type=29 or type=30 or type=40 or type=9999 or type=9994 or type=9990 or type=9991 or type=9992 or type=9993 or type='.CAVEEFFECT.' or type='.NYBLESSING.' or type='.MAKESNOWBALL.')');
  $i=0;
  $ret="";
  while($rec=mysql_fetch_array($r)) {
    $i++;
    list($left, $top)=effectpos($i);
    /*$inf_el = mysql_fetch_array(mq ('SELECT img FROM `shop` WHERE `name` = \''.$rec['name'].'\';'));
    if (!$inf_el) {
      $inf_el = mysql_fetch_array(mq ('SELECT img FROM `berezka` WHERE `name` = \''.$rec['name'].'\';'));
    }

    if (!$inf_el) {
      $inf_el = mysql_fetch_array(mq ('SELECT img FROM `items` WHERE `name` = \''.$rec['name'].'\';'));
    }
    if (!$inf_el) {
      $inf_el = mysql_fetch_array(mq ('SELECT img FROM `items` WHERE `name` = \''.$rec['name'].'\';'));
    }*/
    $effect=effectdata($rec);
    if ($rec["type"]==54) $rec['name']="Изучение: $rec[name]".(strpos($rec["name"], "Знание")?"":" (приём)");
    $ret.="<div style=\"position:absolute; left:{$left}px; top:{$top}px; width:40px; height:25px; z-index:2\">
    <IMG width=40 height=25 src='".IMGBASE."/i/misc/icon_$effect[img]' onmouseout='ghideshow();' onmouseover='gfastshow(\"<B>".$rec['name']."</B> ($effect[type])<BR> ещё ".lefttime($rec["time"]).($effect["mfs"]?"<div>&nbsp;</div>$effect[mfs]":"")."\")';></div>";
  }
  return $ret;
}

// показать перса в инфе
function showpersinv($id) {
    global $mysql, $user;
    if ($id==$user["id"]) $user1=$user;
    else $user1=mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
    $r=mq("select * from inventory where id='$user1[helm]' or id='$user1[naruchi]' or id='$user1[weap]' or id='$user1[plaw]' or id='$user1[bron]' or id='$user1[rybax]' or id='$user1[belt]' or id='$user1[sergi]' or id='$user1[kulon]' or id='$user1[r1]' or id='$user1[r2]' or id='$user1[r3]' or id='$user1[perchi]' or id='$user1[shit]' or id='$user1[leg]' or id='$user1[boots]' or id='$user1[m1]' or id='$user1[m2]' or id='$user1[m3]' or id='$user1[m4]' or id='$user1[m5]' or id='$user1[m6]' or id='$user1[m7]' or id='$user1[m8]' or id='$user1[m9]' or id='$user1[m10]' or id='$user1[m11]' or id='$user1[m12]' or id='$user1[p1]' or id='$user1[p2]'");
    $dressed=array();
    while ($rec=mysql_fetch_assoc($r)) {
      $dressed[$rec["id"]]=$rec;
    }

?>
    <CENTER>
    <img src="<?=IMGBASE?>/i/align_<?echo ($user1['align']>0 ? $user1['align']:"0");?>.gif"><?php if ($user1['klan'] <> '') { echo '<img src="'.IMGBASE.'/i/klan/'.$user1['klan'].'.gif">'; } ?><B><?=$user1['login']?></B> [<?
    if ($id==2236) echo "?";
    else echo $user1['level'];
    ?>]<a href=inf.php?<?=$user1['id']?> target=_blank><IMG SRC=<?=IMGBASE?>/i/inf.gif WIDTH=12 HEIGHT=11 ALT="Инф. о <?=$user1['login']?>"></a>
    <?
    //echo setHP($user1['hp'],$user1['maxhp'],$battle);
    if ($user1['maxmana']) {
        //echo setMP($user1['mana'],$user1['maxmana'],$battle);
    }
    ?>
<TABLE cellspacing=0 cellpadding=0 style="  border-top-width: 1px;
    border-right-width: 1px;
    border-bottom-width: 1px;
    border-left-width: 1px;
    border-top-style: solid;
    border-right-style: solid;
    border-bottom-style: solid;
    border-left-style: solid;
    border-top-color: #FFFFFF;
    border-right-color: #666666;
    border-bottom-color: #666666;
    border-left-color: #FFFFFF;
    padding: 2px;">

<TR>
<TD>
<TABLE border=0 cellSpacing=1 cellPadding=0 width="100%">
<TBODY>
<TR vAlign=top>
<TD>
<TABLE border=0 cellSpacing=0 cellPadding=0 width="100%">
<TBODY>

<TR><TD style="BACKGROUND-IMAGE:none">
<?php
        if ($user1['helm'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['helm']}' LIMIT 1;"));
            $dress=$dressed[$user1["helm"]];
            $mess="Снять ".$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +".$dress['ghp']:"").(($dress['gmana']>0)?"\nУровень маны +".$dress['gmana']:"").(($dress['text']!=null)?"\nНа шлеме выгравировано ".$dress['text']:"");
            echo '<a href="?edit=1&drop=8"><img title="'.$mess.'" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=60></a>';
        }
        else{
            $mess='Пустой слот шлем';
            echo '<img title="'.$mess.'" src="'.IMGBASE.'/i/w9.gif" width=60 height=60>';
        }
    ?></TD></TR>

<TR><TD style="BACKGROUND-IMAGE:none">
<?php
        if ($user1['naruchi'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['naruchi']}' LIMIT 1;"));
            $dress=$dressed[$user1["naruchi"]];
            $mess="Снять ".$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +".$dress['ghp']:"").(($dress['gmana']>0)?"\nУровень маны +".$dress['gmana']:"").(($dress['text']!=null)?"\nНа наручах выгравировано ".$dress['text']:"");
            echo '<a href="?edit=1&drop=22"><img title="'.$mess.'" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=40></a>';
        }
        else{
            $mess='Пустой слот наручи';
            echo '<img title="'.$mess.'" src="'.IMGBASE.'/i/w18.gif" width=60 height=40>';
        }
    ?></TD></TR>

<TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user1['weap'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['weap']}' LIMIT 1;"));
            $dress=$dressed[$user1["weap"]];
            $mess="Снять ".$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['minu']>0)?"\nУрон {$dress['minu']}-{$dress['maxu']}":"").(($dress['gmana']>0)?"\nУровень маны +".$dress['gmana']:"").(($dress['text']!=null)?"\nНа оружии выгравировано ".$dress['text']:"");
            echo '<a href="?edit=1&drop=3"><img src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=60 title="'.$mess.'"></a>';
        }
        else{
            $mess='Пустой слот оружие';
            echo '<img title="'.$mess.'" src="'.IMGBASE.'/i/w3.gif" width=60 height=60 >';
        }
    ?></TD></TR>

<TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user1['bron'] > 0 || $user1['plaw'] > 0 || $user1['rybax'] > 0) {
          if ($user1['plaw']) {
            $d=$user1['plaw'];
            $n=1;
          } elseif ($user1['bron']) {
            $d=$user1['bron'];
            $n=2;
          } elseif ($user1['rybax']) {
            $d=$user1['rybax'];
            $n=3;
          }
          //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$d}' LIMIT 1;"));
          $dress=$dressed[$d];
          $mess="Снять ".$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +".$dress['ghp']:"").(($dress['gmana']>0)?"\nУровень маны +".$dress['gmana']:"").(($dress['text']!=null)?"\nНа одежде вышито ".$dress['text']:"");
          echo '<a href="?edit=1&drop=4'.$n.'"><img title="'.$mess.'" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=80></a>';
        } else {
          $mess='Пустой слот броня';
          echo '<img title="'.$mess.'" src="'.IMGBASE.'/i/w4.gif" width=60 height=80>';
        }
    ?></TD></TR>

<TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user1['belt'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['belt']}' LIMIT 1;"));
            $dress=$dressed[$user1["belt"]];
            $mess="Снять ".$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +".$dress['ghp']:"").(($dress['gmana']>0)?"\nУровень маны +".$dress['gmana']:"").(($dress['text']!=null)?"\nНа поясе вышито ".$dress['text']:"");
            echo '<a href="?edit=1&drop=23"><img title="'.$mess.'" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=40></a>';
        }
        else{
            $mess='Пустой слот пояс';
            echo '<img title="'.$mess.'" src="'.IMGBASE.'/i/w5.gif" width=60 height=40>';
        }
    ?></TD></TR>
</TBODY></TABLE>
</TD>

<TD>
<TABLE border=0 cellSpacing=0 cellPadding=0 width="100%">
<TR>
<TD height=20 vAlign=middle>
<table cellspacing="0" cellpadding="0" style='line-height: 1'>
<tr>
<td nowrap style="font-size:9px">
<div style="position: relative">
<table cellspacing="0" cellpadding="0" style='line-height: 1'><td nowrap style="font-size:9px" style="position: relative"><SPAN id="HP" style='position: absolute; left: 5; z-index: 1; font-weight: bold; color: #FFFFFF'></SPAN><img src="<?=IMGBASE?>/i/misc/bk_life_loose.gif" alt="Уровень жизни" name="HP1" width="1" height="9" id="HP1"><img src="<?=IMGBASE?>/i/misc/bk_life_loose.gif" alt="Уровень жизни" name="HP2" width="1" height="9" id="HP2"></td></table></div></td>
</tr>
<?
if($user1['maxmana']){ ?>
<tr><tr><td nowrap style="font-size:9px">
<div style="position: relative"><?
echo setMP2($user1['mana'],$user1['maxmana'],$battle);
echo "</div></td>
</tr>";}

?>

</table>
</TD></TR>
<TR><TD height=220 vAlign=top width=120 align=left>
<DIV style="Z-INDEX: 1; POSITION: relative; WIDTH: 120px; HEIGHT: 220px; position:relative;" bgcolor="black">
<?
$zver=mysql_fetch_array(mq("SELECT shadow,login,level,vid FROM `users` WHERE `id` = '".$user1['zver_id']."' LIMIT 1;"));
if($zver && $zver["vid"]){
?>
<div style="position:absolute; left:80px; top:145px; width:40px; height:73px; z-index:2">
<a href="zver_inv.php">
<IMG width=40 height=73 src='<?=IMGBASE?>/i/shadow/<?print"".$zver['shadow']."";?>' onmouseout='ghideshow();'  onmouseover='gfastshow("<?=$zver['login']?> [<?=$zver['level']?>] (Перейти к настройкам)");'>
</a></div>
<? }?>
<IMG border=0 src="<?=IMGBASE?>/i/shadow/<?=$user1['sex']?>/<?print"".$user1['shadow']."";?>" width=120 height=218>
<?
  echo showeffects($user["id"]);
?>
<DIV style="Z-INDEX: 2; POSITION: absolute; WIDTH: 120px; HEIGHT: 220px; TOP: 0px; LEFT: 0px"></DIV></DIV></TD></TR>
<TR>
<TD>
<?
  echo "<table cellspacing=0 cellpadding=0>
  <tr>
  <td>".($user1["p1"]?"<a href=\"main.php?edit=1&drop=28\" title=\"Снять ".($dressed[$user1["p1"]]["name"])."\"><img src=\"".IMGBASE."/i/sh/".($dressed[$user1["p1"]]["img"])."\"></a>":"<img alt=\"Пустой слот левый карман\" title=\"Пустой слот левый карман\" src=".IMGBASE."/i/w15.gif>")."</td>
  <td><img alt=\"Пустой слот карман\" src=".IMGBASE."/i/w15.gif></td>
  <td>".($user1["p2"]?"<a href=\"main.php?edit=1&drop=29\" title=\"Снять ".($dressed[$user1["p2"]]["name"])."\"><img src=\"".IMGBASE."/i/sh/".($dressed[$user1["p2"]]["img"])."\"></a>":"<img alt=\"Пустой слот правый карман\" title=\"Пустой слот правый карман\" src=".IMGBASE."/i/w15.gif>")."</td>
  </tr>
  <td><img src=".IMGBASE."/i/w20.gif></td>
  <td><img src=".IMGBASE."/i/w20.gif></td>
  <td><img src=".IMGBASE."/i/w20.gif></td>
  <tr>
  </tr></table>";
/*if ($user1['vip']>=1) {
echo'<IMG border=0 alt="" src="'.IMGBASE.'/i/slot_bottom60.gif" width=120 height=40>';
}elseif ($user1['align']>1 && $user1['align']<2) {
echo'<IMG border=0 alt="" src="'.IMGBASE.'/i/slot_bottom1.gif" width=120 height=40>';
}elseif ($user1['align']>=3 && $user1['align']<4) {
echo'<IMG border=0 alt="" src="'.IMGBASE.'/i/slot_bottom3.gif" width=120 height=40>';
}elseif ($user1['align']==7) {
echo'<IMG border=0 alt="" src="'.IMGBASE.'/i/slot_bottom7.gif" width=120 height=40>';
}else{
echo'<IMG border=0 alt="" src="'.IMGBASE.'/i/slot_bottom0.gif" width=120 height=40>';
}*/
?>
</TD>
</TR></TBODY></TABLE></TD>
<TD><TABLE border=0 cellSpacing=0 cellPadding=0 width="100%">
<TBODY><TR><TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user1['sergi'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['sergi']}' LIMIT 1;"));
            $dress=$dressed[$user1["sergi"]];
            $mess="Снять ".$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +".$dress['ghp']:"").(($dress['gmana']>0)?"\nУровень маны +".$dress['gmana']:"").(($dress['text']!=null)?"\nНа серьгах выгравировано ".$dress['text']:"");
            echo '<a href="?edit=1&drop=1"><img src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=20 title="'.$mess.'"></a>';
        }
        else{
            $mess='Пустой слот серьги';
            echo '<img src="'.IMGBASE.'/i/w1.gif" width=60 height=20 title="'.$mess.'">';
        }
    ?></TD></TR>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user1['kulon'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['kulon']}' LIMIT 1;"));
            $dress=$dressed[$user1["kulon"]];
            $mess="Снять ".$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +".$dress['ghp']:"").(($dress['gmana']>0)?"\nУровень маны +".$dress['gmana']:"").(($dress['text']!=null)?"\nНа кулоне выгравировано ".$dress['text']:"");
            echo '<a href="?edit=1&drop=2"><img src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=20 title="'.$mess.'"></a>';
        }
        else{
            $mess='Пустой слот ожерелье';
            echo '<img src="'.IMGBASE.'/i/w2.gif" width=60 height=20 title="'.$mess.'">';
        }
    ?></TD></TR>

<TR><TD><TABLE border=0 cellSpacing=0 cellPadding=0>
<TBODY> <TR>
<TD style="BACKGROUND-IMAGE: none"><?php
        if ($user1['r1'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['r1']}' LIMIT 1;"));
            $dress=$dressed[$user1["r1"]];
            $mess="Снять ".$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +".$dress['ghp']:"").(($dress['gmana']>0)?"\nУровень маны +".$dress['gmana']:"").(($dress['text']!=null)?"\nНа кольце выгравировано ".$dress['text']:"");
            echo '<a href="?edit=1&drop=5"><img title="'.$mess.'" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=20 height=20></a>';
        }
        else{
            $mess='Пустой слот кольцо';
            echo '<img title="'.$mess.'" src="'.IMGBASE.'/i/w6.gif" width=20 height=20 >';
        }
    ?></td>
<TD style="BACKGROUND-IMAGE: none"><?php
        if ($user1['r2'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['r2']}' LIMIT 1;"));
            $dress=$dressed[$user1["r2"]];
            $mess="Снять ".$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +".$dress['ghp']:"").(($dress['gmana']>0)?"\nУровень маны +".$dress['gmana']:"").(($dress['text']!=null)?"\nНа кольце выгравировано ".$dress['text']:"");
            echo '<a title="'.$mess.'" href="?edit=1&drop=6"><img src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=20 height=20></a>';
        }
        else{
            $mess='Пустой слот кольцо';
            echo '<img src="'.IMGBASE.'/i/w6.gif" width=20 height=20 title="'.$mess.'">';
        }
    ?></td>
<TD style="BACKGROUND-IMAGE: none"><?php
        if ($user1['r3'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['r3']}' LIMIT 1;"));
            $dress=$dressed[$user1["r3"]];
            $mess="Снять ".$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +".$dress['ghp']:"").(($dress['gmana']>0)?"\nУровень маны +".$dress['gmana']:"").(($dress['text']!=null)?"\nНа кольце выгравировано ".$dress['text']:"");
            echo '<a href="?edit=1&drop=7"><img title="'.$mess.'" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=20 height=20></a>';
        }
        else{
            $mess='Пустой слот кольцо';
            echo '<img title="'.$mess.'" src="'.IMGBASE.'/i/w6.gif" width=20 height=20 alt="Пустой слот кольцо" >';
        }
    ?></td>
</TR></TBODY></TABLE></TD></TR>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user1['perchi'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['perchi']}' LIMIT 1;"));
            $dress=$dressed[$user1["perchi"]];
            $mess="Снять ".$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +".$dress['ghp']:"").(($dress['gmana']>0)?"\nУровень маны +".$dress['gmana']:"").(($dress['text']!=null)?"\nНа перчатках выгравировано ".$dress['text']:"");
            echo '<a href="?edit=1&drop=9"><img title="'.$mess.'" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=40></a>';
        }
        else{
            $mess='Пустой слот перчатки';
            echo '<img title="'.$mess.'" src="'.IMGBASE.'/i/w11.gif" width=60 height=40>';
        }
    ?></TD></TR>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user1['shit'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['shit']}' LIMIT 1;"));
            $dress=$dressed[$user1["shit"]];
            $mess="Снять ".$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['minu']>0)?"\nУрон {$dress['minu']}-{$dress['maxu']}":"").(($dress['ghp']>0)?"\nУровень жизни +".$dress['ghp']:"").(($dress['gmana']>0)?"\nУровень маны +".$dress['gmana']:"").(($dress['text']!=null)?"\nНа ".($dress["type"]==3?"оружии":"щите")." выгравировано ".$dress['text']:"");
            echo '<a href="?edit=1&drop=10"><img title="'.$mess.'" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=60></a>';
        }
        else{
            $mess='Пустой слот щит';
            echo '<img title="'.$mess.'" src="'.IMGBASE.'/i/w10.gif" width=60 height=60>';
        }
    ?></TD></TR>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user1['leg'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['leg']}' LIMIT 1;"));
            $dress=$dressed[$user1["leg"]];
            $mess="Снять ".$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +".$dress['ghp']:"").(($dress['gmana']>0)?"\nУровень маны +".$dress['gmana']:"").(($dress['text']!=null)?"\nНа поножах выгравировано ".$dress['text']:"");
            echo '<a href="?edit=1&drop=24"><img title="'.$mess.'" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=80></a>';
        }
        else{
            $mess='Пустой слот поножи';
            echo '<img title="'.$mess.'" src="'.IMGBASE.'/i/w19.gif" width=60 height=80>';
        }
    ?></TD></TR>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user1['boots'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['boots']}' LIMIT 1;"));
            $dress=$dressed[$user1["boots"]];
            $mess="Снять ".$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +".$dress['ghp']:"").(($dress['gmana']>0)?"\nУровень маны +".$dress['gmana']:"").(($dress['text']!=null)?"\nНа сапогах выжжено ".$dress['text']:"");
            echo '<a href="?edit=1&drop=11"><img title="'.$mess.'" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=40></a>';
        }
        else{
            $mess='Пустой слот обувь';
            echo '<img title="'.$mess.'" src="'.IMGBASE.'/i/w12.gif" width=60 height=40>';
        }
    ?></TD></TR>

</TBODY></TABLE></TD></TR>

<?if ($user1['m1'] > 0 or $user1['m2'] > 0 or $user1['m3'] > 0 or $user1['m4'] > 0 or $user1['m5'] > 0 or $user1['m6'] > 0 or $user1['m7'] > 0 or $user1['m8'] > 0 or $user1['m9'] > 0 or $user1['m10'] > 0 or $user1['m11'] > 0 or $user1['m12'] > 0) {?>
<TR>
    <TD colspan=3>
    <?
        $emptyslot='<img onMouseOut="HideOpisShmot()" onMouseOver="OpisShmot(event,\'пустой слот магия\')" src='.IMGBASE.'/i/w13.gif  width=40 height=25>';
        if ($user1['m1'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['m1']}' LIMIT 1;"));
            $dress=$dressed[$user1["m1"]];
            $mess='Снять '.$dress['name'].'<br>Прочность '.$dress['duration'].'/'.$dress['maxdur'];
            echo '<a href="?edit=1&drop=12"><img  onMouseOut="HideOpisShmot()" onMouseOver="OpisShmot(event,\''.$mess.'\')" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=40 height=25></a>';
        } else echo $emptyslot;
        if ($user1['m2'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['m2']}' LIMIT 1;"));
            $dress=$dressed[$user1["m2"]];
            $mess='Снять '.$dress['name'].'<br>Прочность '.$dress['duration'].'/'.$dress['maxdur'];
            echo '<a href="?edit=1&drop=13"><img  onMouseOut="HideOpisShmot()" onMouseOver="OpisShmot(event,\''.$mess.'\')" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=40 height=25></a>';
        } else echo $emptyslot;
        if ($user1['m3'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['m3']}' LIMIT 1;"));
            $dress=$dressed[$user1["m3"]];
            $mess='Снять '.$dress['name'].'<br>Прочность '.$dress['duration'].'/'.$dress['maxdur'];
            echo '<a href="?edit=1&drop=14"><img  onMouseOut="HideOpisShmot()" onMouseOver="OpisShmot(event,\''.$mess.'\')" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=40 height=25></a>';
        } else echo $emptyslot;
        if ($user1['m4'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['m4']}' LIMIT 1;"));
            $dress=$dressed[$user1["m4"]];
            $mess='Снять '.$dress['name'].'<br>Прочность '.$dress['duration'].'/'.$dress['maxdur'];
            echo '<a href="?edit=1&drop=15"><img  onMouseOut="HideOpisShmot()" onMouseOver="OpisShmot(event,\''.$mess.'\')" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=40 height=25></a>';
        } else echo $emptyslot;
        if ($user1['m5'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['m5']}' LIMIT 1;"));
            $dress=$dressed[$user1["m5"]];
            $mess='Снять '.$dress['name'].'<br>Прочность '.$dress['duration'].'/'.$dress['maxdur'];
            echo '<a href="?edit=1&drop=16"><img  onMouseOut="HideOpisShmot()" onMouseOver="OpisShmot(event,\''.$mess.'\')" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=40 height=25></a>';
        } else echo $emptyslot;
        if ($user1['m6'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['m6']}' LIMIT 1;"));
            $dress=$dressed[$user1["m6"]];
            $mess='Снять '.$dress['name'].'<br>Прочность '.$dress['duration'].'/'.$dress['maxdur'];
            echo '<a href="?edit=1&drop=17"><img  onMouseOut="HideOpisShmot()" onMouseOver="OpisShmot(event,\''.$mess.'\')" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=40 height=25></a>';
        } else echo $emptyslot;
    ?>
    </TD>
</TR>
<TR>
    <TD colspan=3>
    <?
        if ($user1['m7'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['m7']}' LIMIT 1;"));
            $dress=$dressed[$user1["m7"]];
            $mess='Снять '.$dress['name'].'<br>Прочность '.$dress['duration'].'/'.$dress['maxdur'];
            echo '<a href="?edit=1&drop=18"><img onMouseOut="HideOpisShmot()" onMouseOver="OpisShmot(event,\''.$mess.'\')" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=40 height=25></a>';
        } else echo $emptyslot;
        if ($user1['m8'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['m8']}' LIMIT 1;"));
            $dress=$dressed[$user1["m8"]];
            $mess='Снять '.$dress['name'].'<br>Прочность '.$dress['duration'].'/'.$dress['maxdur'];
            echo '<a href="?edit=1&drop=19"><img onMouseOut="HideOpisShmot()" onMouseOver="OpisShmot(event,\''.$mess.'\')" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=40 height=25></a>';
        } else echo $emptyslot;
        if ($user1['m9'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['m9']}' LIMIT 1;"));
            $dress=$dressed[$user1["m9"]];
            $mess='Снять '.$dress['name'].'<br>Прочность '.$dress['duration'].'/'.$dress['maxdur'];
            echo '<a href="?edit=1&drop=20"><img onMouseOut="HideOpisShmot()" onMouseOver="OpisShmot(event,\''.$mess.'\')" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=40 height=25></a>';
        } else echo $emptyslot;
        if ($user1['m10'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['m10']}' LIMIT 1;"));
            $dress=$dressed[$user1["m10"]];
            $mess='Снять '.$dress['name'].'<br>Прочность '.$dress['duration'].'/'.$dress['maxdur'];
            echo '<a href="?edit=1&drop=21"><img  onMouseOut="HideOpisShmot()" onMouseOver="OpisShmot(event,\''.$mess.'\')" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=40 height=25></a>';
        } else echo $emptyslot;
        if ($user1['m11'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['m11']}' LIMIT 1;"));
            $dress=$dressed[$user1["m11"]];
            $mess='Снять '.$dress['name'].'<br>Прочность '.$dress['duration'].'/'.$dress['maxdur'];
            echo '<a href="?edit=1&drop=25"><img  onMouseOut="HideOpisShmot()" onMouseOver="OpisShmot(event,\''.$mess.'\')" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=40 height=25></a>';
        } else echo $emptyslot;
        if ($user1['m12'] > 0) {
            //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user1['m12']}' LIMIT 1;"));
            $dress=$dressed[$user1["m12"]];
            $mess='Снять '.$dress['name'].'<br>Прочность '.$dress['duration'].'/'.$dress['maxdur'];
            echo '<a href="?edit=1&drop=26"><img  onMouseOut="HideOpisShmot()" onMouseOver="OpisShmot(event,\''.$mess.'\')" src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=40 height=25></a>';
        } else echo $emptyslot;
    ?>
    </TD>
</TR>
<? }?>

</TBODY></TABLE></TD></TR>
<TR><TD></TD>

</TABLE>
</CENTER> <?php
}

function updatebyarray($arr, $table, $id) {
  $sql="";
  foreach ($arr as $k=>$v) {
    if ($sql) $sql.=", ";
    $sql.="$k='$v'";
  }
  mq("update $table set $sql where id='$id'");
}

// раздеть перса
function undressall($id, $intower=-1) {
  global $mysql, $userslots;
  if ($intower==-1) {
    //$user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
    for($i=1;$i<=26;$i++){
      if ($i==4) {
        dropitemid(41,$id);
        dropitemid(42,$id);
        dropitemid(43,$id);
      } else dropitemid($i,$id);
    }
    dropitemid(28,$id);
    dropitemid(29,$id);
    mq("update inventory set dressed=0 where owner='$id' and type>0");
    resetsets($id);
    if ($intower==-1) $intower=mqfa1("select in_tower from users where id='$id'");
    /*if ($intower!=1) {
      $stats=mqfa("select sila, lovk, inta, vinos, intel, mudra, sexy, spirit from userdata where id='$id'");
      updatebyarray($stats, "users", $id);
    }*/
    resetmax($id);
  } else {
    if ($intower==-1) $intower=mqfa1("select in_tower from users where id='$id'");
    if ($intower!=1) {
      $stats=mqfa("select sila, lovk, inta, vinos, intel, mudra, sexy, spirit, noj, mec");
    }
  }
  $sql="";
  foreach ($userslots as $k=>$v) {
    if ($sql) $sql.=", ";
    $sql.="$v=0";
  }
  mq("update users set $sql where id='$id'");
}
// скинуть шмот с ид
function dropitemid($slot,$id, $slot1="") {
    global $mysql, $user;
    if (!$slot1) {
      switch($slot) {
          case 1: $slot1 = 'sergi'; break;
          case 2: $slot1 = 'kulon'; break;
          case 3: $slot1 = 'weap'; break;
          case 41: $slot1 = 'plaw'; break;
          case 42: $slot1 = 'bron'; break;
          case 43: $slot1 = 'rybax'; break;
          case 5: $slot1 = 'r1'; break;
          case 6: $slot1 = 'r2'; break;
          case 7: $slot1 = 'r3'; break;
          case 8: $slot1 = 'helm'; break;
          case 9: $slot1 = 'perchi'; break;
          case 10: $slot1 = 'shit'; break;
          case 11: $slot1 = 'boots'; break;
          case 12: $slot1 = 'm1'; break;
          case 13: $slot1 = 'm2'; break;
          case 14: $slot1 = 'm3'; break;
          case 15: $slot1 = 'm4'; break;
          case 16: $slot1 = 'm5'; break;
          case 17: $slot1 = 'm6'; break;
          case 18: $slot1 = 'm7'; break;
          case 19: $slot1 = 'm8'; break;
          case 20: $slot1 = 'm9'; break;
          case 21: $slot1 = 'm10'; break;
          case 22: $slot1 = 'naruchi'; break;
          case 23: $slot1 = 'belt'; break;
          case 24: $slot1 = 'leg'; break;
          case 25: $slot1 = 'm11'; break;
          case 26: $slot1 = 'm12'; break;
          case 27: $slot1 = 'setitem'; break;
          case 28: $slot1 = 'p1'; break;
          case 29: $slot1 = 'p2'; break;
      }
    }
        if (mq("UPDATE `users`, `inventory` SET `users`.{$slot1} = 0, `inventory`.dressed = 0,
            `users`.sila = `users`.sila - `inventory`.gsila,
            `users`.lovk = `users`.lovk - `inventory`.glovk,
            `users`.inta = `users`.inta - `inventory`.ginta,
            `users`.intel = `users`.intel - `inventory`.gintel,
            `users`.hp = if(users.maxhp - inventory.ghp<users.hp,users.maxhp - inventory.ghp,users.hp),
            `users`.maxhp = `users`.maxhp - `inventory`.ghp,
            `users`.maxmana = `users`.maxmana - `inventory`.gmana,
            `users`.noj = `users`.noj - `inventory`.gnoj,
            `users`.topor = `users`.topor - `inventory`.gtopor,
            `users`.dubina = `users`.dubina - `inventory`.gdubina,
            `users`.mec = `users`.mec - `inventory`.gmech,
            `users`.posoh = `users`.posoh - `inventory`.gposoh,
            `users`.mfire = `users`.mfire - `inventory`.gfire,
            `users`.mwater = `users`.mwater - `inventory`.gwater,
            `users`.mair = `users`.mair - `inventory`.gair,
            `users`.mearth = `users`.mearth - `inventory`.gearth,
            `users`.mlight = `users`.mlight - `inventory`.glight,
            `users`.mgray = `users`.mgray - `inventory`.ggray,
            `users`.mdark = `users`.mdark - `inventory`.gdark
            WHERE `inventory`.id = `users`.{$slot1} AND `inventory`.dressed = 1 AND `inventory`.owner ='$id' AND `users`.id ='$id'"))
            //mq("UPDATE `users` SET `hp` = `maxhp`, `fullhptime` = ".time()." WHERE  `hp` > `maxhp` AND `id` = '{$id}' LIMIT 1;");
    {
        if ($id==$user["id"]) $user[$slot1]=0;
        return  true;
    }
}
// снять предмет
function dropitem($slot, $slot1="") {
    global $user, $mysql;
    switch($slot) {
        case 1: $slot1 = 'sergi'; break;
        case 2: $slot1 = 'kulon'; break;
        case 3: $slot1 = 'weap'; break;
        case 41: $slot1 = 'plaw'; break;
        case 42: $slot1 = 'bron'; break;
        case 43: $slot1 = 'rybax'; break;
        break;
        case 5: $slot1 = 'r1'; break;
        case 6: $slot1 = 'r2'; break;
        case 7: $slot1 = 'r3'; break;
        case 8: $slot1 = 'helm'; break;
        case 9: $slot1 = 'perchi'; break;
        case 10: $slot1 = 'shit'; break;
        case 11: $slot1 = 'boots'; break;
        case 12: $slot1 = 'm1'; break;
        case 13: $slot1 = 'm2'; break;
        case 14: $slot1 = 'm3'; break;
        case 15: $slot1 = 'm4'; break;
        case 16: $slot1 = 'm5'; break;
        case 17: $slot1 = 'm6'; break;
        case 18: $slot1 = 'm7'; break;
        case 19: $slot1 = 'm8'; break;
        case 20: $slot1 = 'm9'; break;
        case 21: $slot1 = 'm10'; break;
        case 22: $slot1 = 'naruchi'; break;
        case 23: $slot1 = 'belt'; break;
        case 24: $slot1 = 'leg'; break;
        case 25: $slot1 = 'm11'; break;
        case 26: $slot1 = 'm12'; break;
        case 27: $slot1 = 'setitem'; break;
        case 28: $slot1 = 'p1'; break;
        case 29: $slot1 = 'p2'; break;
    }
    if (!$slot1) return;
        if (mq("UPDATE users, inventory SET users.{$slot1} = 0, inventory.dressed = 0,
            users.sila = users.sila - inventory.gsila,
            users.lovk = users.lovk - inventory.glovk,
            users.inta = users.inta - inventory.ginta,
            users.intel = users.intel - inventory.gintel,
            users.maxhp = users.maxhp - inventory.ghp,
            users.maxmana = users.maxmana - inventory.gmana,
            users.noj = users.noj - inventory.gnoj,
            users.topor = users.topor - inventory.gtopor,
            users.dubina = users.dubina - inventory.gdubina,
            users.mec = users.mec - inventory.gmech,
            users.posoh = users.posoh - inventory.gposoh,
            users.mfire = users.mfire - inventory.gfire,
            users.mwater = users.mwater - inventory.gwater,
            users.mair = users.mair - inventory.gair,
            users.mearth = users.mearth - inventory.gearth,
            users.mlight = users.mlight - inventory.glight,
            users.mgray = users.mgray - inventory.ggray,
            users.mdark = users.mdark - inventory.gdark
            WHERE inventory.id = users.{$slot1} AND inventory.dressed = 1 AND inventory.owner = {$user['id']} AND users.id = {$user['id']};"))
            mq("UPDATE `users` SET `hp` = `maxhp`, `fullhptime` = ".time()." WHERE  `hp` > `maxhp` AND `id` = '{$user['id']}' LIMIT 1;");
    {
        $user[$slot1]=0;
        return  true;
    }
}

function resetsets($user1=0, $noreport=0) {
  global $user, $dressslots;
  if (!$user1) $user1=$user;
  elseif (!is_array($user1)) $user1=mqfa("select id, setitem, ".implode(",", $dressslots)." from users where id='$user1'");
  if ($user1["setitem"]) $setitem=mqfa("select dressed, gsila, glovk, ginta, gintel, ghp, gmana, gnoj, gtopor, gdubina, gmech, gposoh, gluk, gfire, gwater, gair, gearth, glight, gdark, ggray from inventory where id='$user1[setitem]'");
  if (!$user1["setitem"] || !@$setitem) {
    mq("insert into inventory (owner, duration, maxdur, destinyinv) values ('$user1[id]', 0, 100000, 3)");
    $user1["setitem"]=mysql_insert_id();
    mq("update users set setitem='$user1[setitem]' where id='$user1[id]'");
  } else {
    if ($setitem["dressed"]) {
      unset($setitem["dressed"]);
      foreach ($setitem as $k=>$v) {
        if ($v) {
          $sql="";
          foreach ($setitem as $k2=>$v2) {
            if ($sql) $sql.=", ";
            if ($k2=="gmech") $k2="gmec";
            $p=substr($k2,1);
            if ($k2=="gfire" || $k2=="gwater" || $k2=="gair" || $k2=="gearth" || $k2=="glight" || $k2=="gdark" || $k2=="ggray") $p="m$p";
            if ($k2=="gmana" || $k2=="ghp") $p="max$p";
            $sql.=" $p=$p-$v2";
          }
          mq("update users set $sql where id='$user1[id]'");
          //echo "update users set $sql where id='$user1[id]'<br>";
          break;
        }
      }
    }
  }
  $r=mq("select count(id)+sum(dvur) as cid, setid from inventory where ".dresscond($user1)." group by setid");
  $set=array("duration"=>0, "maxdur"=>100000, "minu"=>0, "maxu"=>0, "gsila"=>0, "glovk"=>0, "ginta"=>0, "gintel"=>0, "ghp"=>0, "gmana"=>0, "mfkrit"=>0, "mfakrit"=>0, "mfuvorot"=>0, "mfauvorot"=>0, "mfrej"=>0, "mfdrob"=>0, "mfkol"=>0, "mfrub"=>0, "mfdhit"=>0, "mfdkol"=>0, "mfdrub"=>0, "mfdrej"=>0, "mfddrob"=>0, "mfdmag"=>0, "mfdfire"=>0, "mfdwater"=>0, "mfdair"=>0, "mfdearth"=>0, "mfdlight"=>0, "mfddark"=>0, "minusmfdmag"=>0, "minusmfdfire"=>0, "minusmfdair"=>0, "minusmfdwater"=>0, "minusmfdearth"=>0, "mfantikritpow"=>0, "mfkritpow"=>0, "mfcontr"=>0, "mfshieldblock"=>0, "mfparir"=>0, "mfhitp"=>0, "mfmagp"=>0, "mffire"=>0, "mfair"=>0, "mfwater"=>0, "mfearth"=>0, "mflight"=>0, "mfdark"=>0, "manausage"=>0, "gnoj"=>0, "gtopor"=>0, "gdubina"=>0, "gmech"=>0, "gposoh"=>0, "gluk"=>0, "bron1"=>0, "bronmin1"=>0, "bron2"=>0, "bronmin2"=>0, "bron3"=>0, "bronmin3"=>0, "bron4"=>0, "bronmin4"=>0, "gfire"=>0, "gwater"=>0, "gair"=>0, "gearth"=>0, "glight"=>0, "ggray"=>0, "gdark"=>0, "gmp"=>0, "gmeshok"=>0, "mfproboj"=>0, "blockzones"=>0);
  $sets="";
  while ($rec1=mysql_fetch_assoc($r)) {
    $rec=mqfa("select * from setstats where itemsfrom<=$rec1[cid] and itemsto>=$rec1[cid] and setid='$rec1[setid]'");
    if ($rec) {
      if ($sets) $sets.=", ";
      $sets.=" <b>$rec[name]</b>";
      foreach ($rec as $k=>$v) {
        if ($k=="id" || $k=="name" || $k=="itemsfrom" || $k=="itemsto" || $k=="setid") continue;
        //if ($k=="gsila" || $k=="glovk" || $k=="ginta" || $k=="gintel") continue;
        $set[$k]+=$v;                                                // || $k=="gnoj" || $k=="gtopor" || $k=="gdubina" || $k=="gmech" || $k=="gposoh" || $k=="gluk" || $k=="gair" || $k=="gearth" || $k=="gfire" || $k=="gwater" || $k=="glight" || $k=="gdark" || $k=="ggray"
      }          
    }
  }  
  if ($sets) {
    if (!$noreport) echo "На вас надеты комплекты: $sets";
    $mfs=array("gsila", "glovk", "ginta", "gintel", "ghp", "gmana", "gnoj", "gtopor", "gdubina", "gmech", "gposoh", "gluk", "gfire", "gwater", "gair", "gearth", "glight", "gdark", "ggray");
    foreach ($mfs as $k=>$v) {
      if ($set[$v]) {
        $sql="";
        foreach ($mfs as $k1=>$k2) {
          if ($sql) $sql.=", ";
          if ($k2=="gmech") $p="mec";
          else {
            $p=substr($k2,1);
            if ($k2=="gfire" || $k2=="gwater" || $k2=="gair" || $k2=="gearth" || $k2=="glight" || $k2=="gdark" || $k2=="ggray") $p="m$p";
            if ($k2=="gmana" || $k2=="ghp") $p="max$p";
          }
          $sql.=" $p=$p+$set[$k2]";
        }
        //echo "update users set $sql where id='$user1[id]'<br>";
        mq("update users set $sql where id='$user1[id]'");
        break;
      }
    }
  }
  
  $sql="";
  foreach ($set as $k=>$v) {
    $sql.=", $k='$v'";
  }
  mq("update inventory set dressed=1 $sql where id='$user1[setitem]'");

  //dressitem($user1["setitem"]);
}

//сможет держать
function derj($id) {
    global $user, $mysql;
        if ($dd = mq("SELECT i.`id` FROM`users` as u, `inventory` as i
            WHERE
            i.needident = 0 AND
            i.id = {$id} AND
            i.duration < i.maxdur  AND
            i.owner = {$user['id']} AND
            u.sila >= i.nsila AND
            u.lovk >= i.nlovk AND
            u.inta >= i.ninta AND
            u.vinos >= i.nvinos AND
            u.intel >= i.nintel AND
            u.mudra >= i.nmudra AND
            u.level >= i.nlevel AND
            ((".(int)$user['align']." = i.nalign) or (i.nalign = 0)) AND
            u.noj >= i.nnoj AND
            u.topor >= i.ntopor AND
            u.dubina >= i.ndubina AND
            u.mec >= i.nmech AND
            u.mfire >= i.nfire AND
            u.mwater >= i.nwater AND
            u.mair >= i.nair AND
            u.mearth >= i.nearth AND
            u.mlight >= i.nlight AND
            u.mgray >= i.ngray AND
            u.mdark >= i.ndark AND
            i.setsale = 0 AND
            duration < maxdur and
            u.id = {$user['id']};"))
            {
                $dd = mysql_fetch_array($dd);
                //echo $dd[0]." ";
                if($dd[0] > 0) {
                    return true;
                } else {
                    return false;
                }
            }
}
// обновляем рандом
function make_seed() {
        list($usec, $sec) = explode(' ', microtime());
        return (float) $sec + ((float) $usec * 100000);
    }

function getslot($i, $user1=0) {
  global $userslots, $user;
  if (!$user1) $user1=$user;
  foreach ($userslots as $k=>$v) if ($user1[$v]==$i) return $v;
}

function fallitems() {
  global $user, $userslots;
  $cond="0";
  foreach ($userslots as $k=>$v) {
    if ($user[$v]) $cond.=" or id='$user[$v]' ";
  }
  $r=mq("select id from inventory where ($cond) and (
  ($user[sila] < nsila and nsila>0) or
  ($user[lovk] < nlovk and nlovk>0) or
  ($user[inta] < ninta and ninta>0) or
  $user[vinos] < nvinos or
  ($user[intel] < nintel and nintel>0) or
  $user[mudra] < nmudra or
  $user[level] < nlevel or
  $user[noj] < nnoj or
  $user[topor] < ntopor or
  $user[dubina] < ndubina or
  $user[mec] < nmech or
  $user[posoh] < nposoh or
  $user[mfire] < nfire or
  $user[mwater] < nwater or
  $user[mair] < nair or
  $user[mearth] < nearth or
  $user[mlight] < nlight or
  $user[mgray] < ngray or
  $user[mdark] < ndark or
  duration >= maxdur
  )");
  while ($rec=mysql_fetch_assoc($r)) {
    dropitem(0,getslot($rec["id"]));
  }
}

// пусть падают
function ref_drop ($id) {
  global $user, $mysql, $userslots;
  $cond="0";
  foreach ($userslots as $k=>$v) {
    if ($user[$v]) $cond.=" or id='$user[$v]' ";
  }
  $r=mq("select * from inventory where $cond");
  $inventory=array();
  while ($rec=mysql_fetch_assoc($r)) {
    $inventory[]=$rec;
  }
  $rs=0;
  do {
    $dropped=0;
    foreach ($inventory as $k=>$rec) {
      if (!canhold($user, $rec)) {
        unset($inventory[$k]);
        $dropped++;
        dropitem(0,getslot($rec["id"]));
        $rs=1;
      }
    }
    if ($dropped>0) $user=mqfa("select * from users where id='$user[id]'");
  } while ($dropped>0);
  if ($rs) resetsets($id, 1);
  return;

  $slot = array('sergi','kulon','weap','bron','r1','r2','r3','helm','perchi','shit','boots','m1','m2','m3','m4','m5','m6','m7','m8','m9','m10','naruchi','belt','leg','m11','m12');

  for ($i=0;$i<=26;$i++) {
    if ($user[$slot[$i]] && !derj($user[$slot[$i]])) {
      if ($i==3) continue;
      dropitem($i+1);
      $user[$slot[$i]] = null;
      //$vasa = 1;
    }
  }
  $slots=array("plaw"=>41, "bron"=>42, "rybax"=>43);
  foreach ($slots as $k=>$v) {
    if ($user[$k] && !derj($user[$k])) {
      dropitem($v);
      $user[$k] = null;
    }
  }
  //if ($vasa) { header("Location:main.php?edit=1"); }
}

function slotbytype($t, $user) {
  if ($t==1) return 'sergi';
  if ($t==2) return 'kulon';
  if ($t==3) return 'weap';
  if ($t==4) return 'bron';
  if ($t==5) {
    if (!$user["r1"]) return 'r1';
    elseif (!$user["r2"]) return 'r2';
    else return 'r3';
  }
  if ($t==6) return 'rybax';
  if ($t==7) return 'plaw';
  if ($t==8) return 'helm';
  if ($t==9) return 'perchi';
  if ($t==10) return 'shit';
  if ($t==11) return 'boots';
  if ($t==22) return 'naruchi';
  if ($t==23) return 'belt';
  if ($t==24) return 'leg';
}

// одеть предмет
function dressitem ($id) {
    global $mysql, $user;
    //mq("LOCK TABLES `users` as u WRITE, `inventory` as i WRITE;");
    $item = mysql_fetch_array(mq("SELECT * FROM `inventory` as i WHERE  `duration` < `maxdur` AND `id` = '{$id}' AND `owner` = '{$_SESSION['uid']}' AND `dressed` = 0; "));
    //$user = mysql_fetch_array(mq("SELECT * FROM `users` as u WHERE `id` = '{$user['id']}' LIMIT 1;"));
    if (!canhold($user, $item)) return false;
    switch($item['type']) {
        case 1: $slot1 = 'sergi'; break;
        case 2: $slot1 = 'kulon'; break;
        case 3: $slot1 = 'weap'; break;
        case 4: $slot1 = 'bron'; break;
        case 5: $slot1 = 'r1'; break;
        case 6: $slot1 = 'rybax'; break;
        case 7: $slot1 = 'plaw'; break;
        case 8: $slot1 = 'helm'; break;
        case 9: $slot1 = 'perchi'; break;
        case 10: $slot1 = 'shit'; break;
        case 11: $slot1 = 'boots'; break;
//      case 12: $slot1 = 'm1'; break;
        case 22: $slot1 = 'naruchi'; break;
        case 23: $slot1 = 'belt'; break;
        case 24: $slot1 = 'leg'; break;
        //case 0: $slot1 = 'setitem'; break;
    }
    if($item['second']>0 && $item['type']==3 && $user['weap']>0){$slot1 = 'shit'; $item['type']=10;}
    if($item['type']==5)
    {
        if(!$user['r1']) { $slot1 = 'r1';}
        elseif(!$user['r2']) { $slot1 = 'r2';}
        elseif(!$user['r3']) { $slot1 = 'r3';}
        else {
            $slot1 = 'r1';
            dropitem(5);
        }
    } elseif($item['type']==7) {
      dropitem(41);
    } elseif($item['type']==4) {
      dropitem(42);
    }  elseif($item['type']==6) {
      dropitem(43);
    } elseif($item['type']==25) {
        if(!$user['m1']) { $slot1 = 'm1';}
        elseif(!$user['m2']) { $slot1 = 'm2';}
        elseif(!$user['m3']) { $slot1 = 'm3';}
        elseif(!$user['m4']) { $slot1 = 'm4';}
        elseif(!$user['m5']) { $slot1 = 'm5';}
        elseif(!$user['m6']) { $slot1 = 'm6';}
        elseif(!$user['m7']) { $slot1 = 'm7';}
        elseif(!$user['m8']) { $slot1 = 'm8';}
        elseif(!$user['m9']) { $slot1 = 'm9';}
        elseif(!$user['m10']) { $slot1 = 'm10';}
        elseif(!$user['m11']) { $slot1 = 'm11';}
        elseif(!$user['m12']) { $slot1 = 'm12';}
        else {
          $slot1 = 'm1';
          dropitem(12);
        }
    } elseif($item['type']==187) {
      if(!$user['p1']) $slot1 = 'p1';
      elseif(!$user['p2']) $slot1 = 'p2';
      else {
        $slot1 = 'p1';
        dropitem(28);
      }
    } elseif ($slot1 != 'setitem') {
      dropitem($item['type']);
    }
    if (!$slot1) return;
    if (!($item['type']==25 && $user['level'] < 4)) {
        if (mq("UPDATE `users` as u, `inventory` as i SET u.{$slot1} = {$id}, i.dressed = 1,
            u.sila = u.sila + i.gsila,
            u.lovk = u.lovk + i.glovk,
            u.inta = u.inta + i.ginta,
            u.intel = u.intel + i.gintel,
            u.maxhp = u.maxhp + i.ghp,
            u.maxmana = u.maxmana + i.gmana,
            u.noj = u.noj + i.gnoj,
            u.topor = u.topor + i.gtopor,
            u.dubina = u.dubina + i.gdubina,
            u.mec = u.mec + i.gmech,
            u.posoh = u.posoh + i.gposoh,
            u.mfire = u.mfire + i.gfire,
            u.mwater = u.mwater + i.gwater,
            u.mair = u.mair + i.gair,
            u.mearth = u.mearth + i.gearth,
            u.mlight = u.mlight + i.glight,
            u.mgray = u.mgray + i.ggray,
            u.mdark = u.mdark + i.gdark
                WHERE
            i.needident = 0 AND
            i.id = {$id} AND
            i.dressed = 0 AND
            i.owner = {$user['id']} AND
            i.setsale = 0 AND
            u.id = {$user['id']};"))
//          if ($item['clan']) {
//          mq("UPDATE `clanstorage` SET `dressed` = '1' WHERE `it_id` = '{$item['id']}';")}
{
            if ($item["destinyinv"]==1) mq("update inventory set  destinyinv=2 where id='$item[id]'");
            $user[$slot1] = $item['id'];
            return  true;
            }
        }
    //mq("UNLOCK TABLES;");
    //$user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$user['id']}' LIMIT 1;"));
}

function dresstoweritem ($user, $id, $slot) {
  //mq("LOCK TABLES `users` as u WRITE, `inventory` as i WRITE;");
  $item = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$id}'"));
  //$user = mysql_fetch_array(mq("SELECT * FROM `users` as u WHERE `id` = '{$user['id']}' LIMIT 1;"));
  mq("update users set $slot='$id', sila=sila+'$item[gsila]', lovk=lovk+'$item[glovk]', 
  inta=inta+'$item[ginta]', intel=intel+'$item[gintel]', maxhp=maxhp+$item[ghp],
  maxmana=maxmana+'$item[gmana]' where id='$user'");
          /*u.noj = u.noj + i.gnoj,
          u.topor = u.topor + i.gtopor,
          u.dubina = u.dubina + i.gdubina,
          u.mec = u.mec + i.gmech,
          u.posoh = u.posoh + i.gposoh,
          u.mfire = u.mfire + i.gfire,
          u.mwater = u.mwater + i.gwater,
          u.mair = u.mair + i.gair,
          u.mearth = u.mearth + i.gearth,
          u.mlight = u.mlight + i.glight,
          u.mgray = u.mgray + i.ggray,
          u.mdark = u.mdark + i.gdark*/
}


// одеть предмет
function dressitemkomplekt ($id,$idd,$slot1) {
    global $mysql, $user;
//dad3a37aa9d50688b5157698acfd7aee
//1d564716d0441731c9aee86bdc892cfc
    $item = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE owner=".$_SESSION['uid']." AND dressed = 0 and duration < maxdur and id='".$idd."' limit 1"));
    if ($item['id']=='') $item = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE owner=".$_SESSION['uid']." AND dressed = 0 and duration < maxdur and name='".$id."' order by duration desc limit 1"));
    if (!$item) return;
    if (!$slot1) {
      switch($item['type']) {
        case 1: $slot1 = 'sergi'; break;
        case 2: $slot1 = 'kulon'; break;
        case 3: $slot1 = 'weap'; break;
        case 4: $slot1 = 'bron'; break;
        case 5: $slot1 = 'r1'; break;
        case 6: $slot1 = 'rybax'; break;
        case 7: $slot1 = 'plaw'; break;
        case 8: $slot1 = 'helm'; break;
        case 9: $slot1 = 'perchi'; break;
        case 10: $slot1 = 'shit'; break;
        case 11: $slot1 = 'boots'; break;
  //      case 12: $slot1 = 'm1'; break;
        case 22: $slot1 = 'naruchi'; break;
        case 23: $slot1 = 'belt'; break;
        case 24: $slot1 = 'leg'; break;
      }
      if($item['type']==5) {
        if(!$user['r1']) $slot1 = 'r1';
        elseif(!$user['r2']) $slot1 = 'r2';
        elseif(!$user['r3']) $slot1 = 'r3';
        else {
          $slot1 = 'r1';
          dropitem(5);
        }
      } elseif($item['type']==25) {
        if(!$user['m1']) $slot1 = 'm1';
        elseif(!$user['m2']) $slot1 = 'm2';
        elseif(!$user['m3']) $slot1 = 'm3';
        elseif(!$user['m4']) $slot1 = 'm4';
        elseif(!$user['m5']) $slot1 = 'm5';
        elseif(!$user['m6']) $slot1 = 'm6';
        elseif(!$user['m7']) $slot1 = 'm7';
        elseif(!$user['m8']) $slot1 = 'm8';
        elseif(!$user['m9']) $slot1 = 'm9';
        elseif(!$user['m10']) $slot1 = 'm10';
        elseif(!$user['m11']) $slot1 = 'm11';
        elseif(!$user['m12']) $slot1 = 'm12';
        else {
          $slot1 = 'm1';
          dropitem(25);
        }
      } elseif ($item['type']==4) {
        dropitem(42);
      } elseif ($item['type']==6) {
        dropitem(43);
      } elseif ($item['type']==7) {
        dropitem(41);
      } else {
        dropitem($item['type']);
      }
    }
    if (!($item['type']==25 && $user['level'] < 4)) {
        if (mq("UPDATE `users` as u, `inventory` as i SET u.{$slot1} = {$item['id']}, i.dressed = 1,
            u.sila = u.sila + i.gsila,
            u.lovk = u.lovk + i.glovk,
            u.inta = u.inta + i.ginta,
            u.intel = u.intel + i.gintel,
            u.maxhp = u.maxhp + i.ghp,
            u.maxmana = u.maxmana + i.gmana,
            u.noj = u.noj + i.gnoj,
            u.posoh = u.posoh + i.gposoh,
            u.topor = u.topor + i.gtopor,
            u.dubina = u.dubina + i.gdubina,
            u.mec = u.mec + i.gmech,
            u.mfire = u.mfire + i.gfire,
            u.mwater = u.mwater + i.gwater,
            u.mair = u.mair + i.gair,
            u.mearth = u.mearth + i.gearth,
            u.mlight = u.mlight + i.glight,
            u.mgray = u.mgray + i.ggray,
            u.mdark = u.mdark + i.gdark
                WHERE
            i.needident = 0 AND
            i.id = {$item['id']} AND
            i.dressed = 0 AND
            i.owner = {$user['id']} AND
            ((".(int)$user['align']." = i.nalign) or (i.nalign = 0)) AND
            i.setsale = 0 AND
            u.id = {$user['id']};"))
//          if ($item['clan']) {
//          mq("UPDATE `clanstorage` SET `dressed` = '1' WHERE `it_id` = '{$item['id']}';")}
 {
            $user[$slot1] = $item['id'];
            if ($item["second"]) {
              return array("1"=>$item["id"]);
            } elseif ($item["type"]==3) {
              return array("0"=>$item["id"]);
            }
            return  0;
            }
        }
   // mq("UNLOCK TABLES;");
    //$user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$user['id']}' LIMIT 1;"));
}

// убить предмет
function destructitem($id, $used=0) {
    global $user, $mysql;
    $dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `id` = '{$id}' LIMIT 1;"));
    switch($dress['type']) {
      case 1: $slot1 = 'sergi'; break;
      case 2: $slot1 = 'kulon'; break;
      case 3: $slot1 = 'weap'; break;
      case 4: $slot1 = 'bron'; break;
      case 5: $slot1 = 'r1'; break;
      case 6: $slot1 = 'r2'; break;
      case 7: $slot1 = 'r3'; break;
      case 8: $slot1 = 'helm'; break;
      case 9: $slot1 = 'perchi'; break;
      case 10: $slot1 = 'shit'; break;
      case 11: $slot1 = 'boots'; break;
//      case 12: $slot1 = 'm1'; break;
      case 22: $slot1 = 'naruchi'; break;
      case 23: $slot1 = 'belt'; break;
      case 24: $slot1 = 'leg'; break;
    }
    if($dress['type']==5) {
      if($user['r1']==$dress['id']) { $slot1 = 'r1';}
      elseif($user['r2']==$dress['id']) { $slot1 = 'r2';}
      elseif($user['r3']==$dress['id']) { $slot1 = 'r3';}
    } elseif($dress['type']==25) {
      if($user['m1']==$dress['id']) { $slot1 = 'm1';}
      elseif($user['m2']==$dress['id']) { $slot1 = 'm2';}
      elseif($user['m3']==$dress['id']) { $slot1 = 'm3';}
      elseif($user['m4']==$dress['id']) { $slot1 = 'm4';}
      elseif($user['m5']==$dress['id']) { $slot1 = 'm5';}
      elseif($user['m6']==$dress['id']) { $slot1 = 'm6';}
      elseif($user['m7']==$dress['id']) { $slot1 = 'm7';}
      elseif($user['m8']==$dress['id']) { $slot1 = 'm8';}
      elseif($user['m9']==$dress['id']) { $slot1 = 'm9';}
      elseif($user['m10']==$dress['id']) { $slot1 = 'm10';}
      elseif($user['m11']==$dress['id']) { $slot1 = 'm11';}
      elseif($user['m12']==$dress['id']) { $slot1 = 'm12';}
    } elseif ($dress["type"]==187) {
      if($user['p1']==$dress['id']) { $slot1 = 'p1';}
      elseif($user['p2']==$dress['id']) { $slot1 = 'p2';}
    }
    if ($dress["bs"]==71) {
      mq("update inventory set owner=0 where id='$dress[id]'");
      if ($dress['dressed'] == 1) {
        mq("UPDATE `users` SET `".$slot1."` = 0 WHERE `id` = '{$_SESSION['uid']}';");
        $user[$slot1]=0;
      }
      return;
    }
    if ($used && $dress["type"]==188) {
      takeshopitem(2459);
    } elseif ($dress["type"]==188) {
      if ($dress["dategoden"] && $dress["dategoden"]<=time()) takeshopitem(2460);
    }
    if (($dress['owner']==$user['id'])) {
      mq("DELETE FROM `obshagastorage` WHERE `id_it` = '$id' LIMIT 1;");
      mq("DELETE FROM `clanstorage` WHERE `id_it` = '{$id}' LIMIT 1;");
      mq("DELETE FROM `inventory` WHERE `id` = '{$id}' LIMIT 1;");
      mq("DELETE FROM `allinventory` WHERE `id` = '{$id}' LIMIT 1;");
      mq("DELETE FROM `charmed_items` WHERE `id` = '{$id}' LIMIT 1;");
      //mq("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','Выброшен предмент {$dress['name']}. Цена:{$dress['cost']} кр.',1,'".time()."');");
      //echo "<font color=red><b>Предмет \"{$dress['name']}\" утерян.</b></font>";
      if ($dress['dressed'] == 1) {
        mq("UPDATE `users` SET `".$slot1."` = 0 WHERE `id` = '{$_SESSION['uid']}';");
        $user[$slot1]=0;
      }
      checkitemchange($dress);
    }
}

// использовать магию
function usemagic($id,$target) {
    global $user, $mysql, $fbattle, $noattackrooms;
    $wd=date('N');
    if (incastle($user["room"]) && $wd==7) {
      $siege=getvar("siege");
      if ($siege>10) {
        $i=700;
        while ($i<750) {
          $i++;
          $noattackrooms[]=700;
        }
      }
    }

    $row = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `id` = '{$id}' LIMIT 1;"));
    if (incommontower($user) && $row["bs"]!=$user["in_tower"]) return false;
    if ((canhold($user, $row) && $user["mana"]>=$row["gmp"]) || $row['magic'] == 48 || $row['magic'] == 50 || $row['magic'] == 42 || $row['magic'] == 139 || $row['magic'] == 203) {
        $magic = mysql_fetch_array(mq("SELECT * FROM `magic` WHERE `id` = '{$row['magic']}' LIMIT 1;"));
        if ($target) $ti=mqfa1("select id from users where login='$target'"); else $ti=0;
        if (!$user["battle"]) $i=mqfa1("select id from fieldmembers where user='$user[id]' or user='$ti'");
        else $i=0;
        if ($i) {
          echo "<div align=right><font color=red><b>Это нельзя сделать ожидая начала боя или на персонажа, который ожидает начала боя.</b></font></div>";
          return false;
        }
        if(!$row['magic']) {
          if ($row["includemagicusesperday"]) {
            $u=mqfa1("select count(id) from includemagicuses where dat=curdate() and item='$row[id]'");
            if ($u>=$row["includemagicusesperday"]) $cc=0;
            else $cc=1;
          } else $cc=1;
          if (!$cc) {
            echo "<div align=right><font color=red><b>Этот предмет сегодня больше нельзя использовать!</b></font></div>";
            return false;
          } else {
            $incmagic = mysql_fetch_array(mq('SELECT * FROM `magic` WHERE `id` = \''.$row['includemagic'].'\' LIMIT 1;'));
            $incmagic['name'] = $row['includemagicname'];
            $incmagic['cur'] = $row['includemagicdex'];
            $incmagic['max'] = $row['includemagicmax'];
            if($incmagic['cur'] <= 0) {
                    return false;
            }
            $magic['targeted'] = $incmagic['targeted'];
            echo "<div align=right><font color=red><b>";

            if (strpos($incmagic['file'],"sharp_all")===0) {
              $sharpamount=str_replace("sharp_all","",$incmagic['file']);
              $sharpamount=str_replace(".php","",$sharpamount);
              $twohanded=0;
              include "./magic/sharp_all.php";
            } elseif (strpos($incmagic['file'],"sharp_dvur")===0) {
              $sharpamount=str_replace("sharp_dvur","",$incmagic['file']);
              $sharpamount=str_replace(".php","",$sharpamount);
              $twohanded=1;
              include "./magic/sharp_all.php";
            } else include("./magic/".$incmagic['file']);
            echo "</b></font></div>";
          }
        } else {
          echo "<div align=right><font color=red><b>";
          if (strpos($magic['file'],"sharp_all")===0) {
            $sharpamount=str_replace("sharp_all","",$magic['file']);
            $sharpamount=str_replace(".php","",$sharpamount);
            $twohanded=0;
            include "./magic/sharp_all.php";
          } elseif (strpos($magic['file'],"sharp_dvur")===0) {
            $sharpamount=str_replace("sharp_dvur","",$magic['file']);
            $sharpamount=str_replace(".php","",$sharpamount);
            $twohanded=1;
            include "./magic/sharp_all.php";
          } else {
            if ($magic["id"]==139) $row["gsila"]=25;
            if ($magic["id"]==144) $row["glovk"]=25;
            if ($magic["id"]==145) $row["ginta"]=25;
            if ($magic["id"]==146) $row["gintel"]=25;
            include("./magic/".$magic['file']);
          }
          echo "</b></font></div>";
        }

        if ($bet) {
            if($row['maxdur'] <= ($row['duration']+1)) {
              echo "<!--";
              destructitem($row['id'], 1);
              echo "-->";
            } else {
              if(!$row['magic']) {
                if ($row["includemagicusesperday"]) mq("insert into includemagicuses (dat, item) values (curdate(), '$row[id]')");
                mq("UPDATE `inventory` SET `includemagicdex` =`includemagicdex`-{$bet} WHERE `id` = {$row['id']} LIMIT 1;");
              } else {
                mq("UPDATE `inventory` SET `duration` =`duration`+{$bet} WHERE `id` = {$row['id']} LIMIT 1;");
              }
            }
            if ($row["gmp"]) {
              if ($user["battle"]) {
                $fbattle->takemana($row["gmp"], $user["id"], 0);                
              } else {
                $user["mana"]-=$row["gmp"];
                mq("update users set mana=mana-$row[gmp], fullmptime=".time()." where id='$user[id]'");  
              }
            }
            return 1;
        }
        echo " ";
        //echo mysql_error();
    } else echo "<font color=red>Не хватает требований!</font>";
}

function inclmagic($f, $row, $user, $magic) {
  if (strpos($f,"sharp_all")===0) {
    $sharpamount=str_replace("sharp_all","",$f);
    $sharpamount=str_replace(".php","",$sharpamount);
    $twohanded=0;
    include "./magic/sharp_all.php";
  } elseif (strpos($f,"sharp_dvur")===0) {
    $sharpamount=str_replace("sharp_dvur","",$f);
    $sharpamount=str_replace(".php","",$sharpamount);
    $twohanded=1;
    include "./magic/sharp_all.php";
  } else include("./magic/$f");
}

function addch ($text,$room=0) {
  global $user;
  if ($room==0) $room = $user['room'];
  if($fp = @fopen (CHATROOT."chat.txt","a")){ //открытие
    flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
    fputs($fp ,":[".time()."]:[!sys!!]:[".($text)."]:[".$room."]\r\n"); //работа с файлом
    fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
    flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
    fclose ($fp); //закрытие
  }
}

function cavesys($text) {
  global $user;
  if($fp = @fopen (CHATROOT."chat.txt","a")){
    flock ($fp,LOCK_EX);
    fputs($fp ,":[".time()."]:[!cavesys!!]:[$text]:[$user[caveleader]]\r\n");
    fflush ($fp);
    flock ($fp,LOCK_UN);
    fclose ($fp);
  }
}


function privatemsg($text, $to) {
  global $user;
  if ($room==0) $room = $user['room'];
  $fp = fopen (CHATROOT."chat.txt","a"); //открытие
  flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
  fputs($fp ,":[".time()."]:[{[]}$to{[]}]:[".($text)."]:[".$room."]\r\n"); //работа с файлом
  fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
  flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
  fclose ($fp); //закрытие
}

function addchp ($text,$who,$room=0) {
  global $user;
  if ($room==0) $room = $user['room'];
  $fp = fopen (CHATROOT."chat.txt","a"); //открытие
  flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
  fputs($fp ,":[".time()."]:[{$who}]:[".($text)."]:[".$room."]\r\n"); //работа с файлом
  fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
  flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
  fclose ($fp); //закрытие
}

function addchnavig ($text,$who,$url) {
  addchp ("<font color=red>Внимание!</font> $text<BR>'; top.frames['main'].location='$url'; var z = '   ","{[]}$who{[]}");
}

function err($t) {
  echo '<font color=red>',$t,'</font>';
}

if ($user['id'] == 7) {
    //$trs = mqfaa("SELECT id FROM effects WHERE owner = 7");
    //foreach ($trs as $tr) {
    //   deltravma($tr['id']);
    //}
    //settravma(7, 11);
}

// ставим травму
function settravma($id,$type,$time=86400,$kill=false,$force=0) {
  $user = mysql_fetch_array(mq("SELECT align, level, features FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
  if((($user['align'] == 2 && mt_rand(1,100) > 20) && !$kill) OR ($user['level'] == 0)) {
      return false;
  } else {
    $travmalist = array ("разбитый нос","сотрясение первой степени","потрепанные уши","прикушенный язык","перелом переносицы","растяжение ноги","растяжение руки","подбитый глаз","синяк под глазом","кровоточащее рассечение","отбитая <пятая точка>","заклинившая челюсть","выбитый зуб <мудрости>","косоглазие");
    $travmalist2 = array ("отбитые почки","вывих <вырезано цензурой>","сотрясение второй степени","оторванное ухо","вывих руки","оторванные уши","поврежденный позвоночник","отбитые почки","поврежденный копчик","разрыв сухожилия","перелом ребра","перелом двух ребер","вывих ноги","сломанная челюсть");
    $travmalist3 = array ("пробитый череп","разрыв селезенки","смещение позвонков","открытый перелом руки","открытый перелом <вырезано цензурой>","излом носоглотки","непонятные, но множественные травмы","сильное внутреннее кровотечение","раздробленная коленная чашечка","перелом шеи","смещение позвонков","открытый перелом ключицы","перелом позвоночника","вывих позвоночника","сотрясение третьей степени");
    $owntravma = mysql_fetch_array(mq("SELECT `type`,`id`,`sila`,`lovk`,`inta` FROM `effects` WHERE `owner` = ".$id." AND (`type`=11 OR `type`=12 OR `type`=13) ORDER by `type` DESC LIMIT 1 ;"));
    if($type != 0 && $type != 100) $owntravma['type']= $type;
    elseif ($type != 0 && $type == 100 && $owntravma['type']==0) {
      $type=mt_rand(1,100);
      if ($type < 10) {$owntravma['type']=25;}
      elseif ($type < 60) {$owntravma['type']="set";}
      elseif ($type < 85) {$owntravma['type']=11;}
      else {$owntravma['type']=12;}
    } elseif ($owntravma['type'] == 0) {
      $tr=mt_rand(1,3);
      switch($tr){
        case 1: $owntravma['type']=0; break;
        case 2: $owntravma['type']=11; break;
        case 3: $owntravma['type']=12; break;
      }
    }

    $mult=1;
    //if ($user["align"]==7) $mult*=0.8;
    getfeatures($user);
    $mult*=1-($user["resistant"]*0.05);
    $res=mqfa1("select id from effects where owner='$id' and (type=".TRAVMARESISTANCE." or type=".TRAVMARESISTANCE2.")");
    if ($res && !$force) return;

    switch($owntravma['type']) {
      case 20:
          $zz = mt_rand(1,3); $s=0;$l=0;$i=0;
          switch($zz){
              case 1: $s=($user['level'] + $st)*3; break;
              case 2: $l=($user['level'] + $st)*3; break;
              case 3: $i=($user['level'] + $st)*3; break;
          }
          $trv = $travmalist3[mt_rand(0,count($travmalist3)-1)];
//          $time = 60*60*mt_rand(15,24);
          $time*=$mult;
          //mq("DELETE FROM `effects` WHERE `id` = '".$owntravma['id']."' LIMIT 1;");
          mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$id."','".$trv."',".(time()+$time).",13,'".$s."','".$l."','".$i."','0');");
          //mq("UPDATE `users` SET `sila`=`sila`+'".$owntravma['sila']."', `lovk`=`lovk`+'".$owntravma['lovk']."', `inta`=`inta`+'".$owntravma['inta']."' WHERE `id` = '".$id."' LIMIT 1;");
          mq("UPDATE `users` SET `sila`=`sila`-'".$s."', `lovk`=`lovk`-'".$l."', `inta`=`inta`-'".$i."' WHERE `id` = '".$id."' LIMIT 1;");
          undressall($id);
          return $trv;
      break;
      case 1:
          $zz = mt_rand(1,3); $s=0;$l=0;$i=0;
          switch($zz){
              case 1: $s=($user['level'] + $st); break;
              case 2: $l=($user['level'] + $st); break;
              case 3: $i=($user['level'] + $st); break;
          }
          $trv = $travmalist2[mt_rand(0,count($travmalist2)-1)];
          $time*=$mult;
          mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$id."','".$trv."',".(time()+$time).",11,'".$s."','".$l."','".$i."','0');");
          mq("UPDATE `users` SET `sila`=`sila`-'".$s."', `lovk`=`lovk`-'".$l."', `inta`=`inta`-'".$i."' WHERE `id` = '".$id."' LIMIT 1;");
          ref_drop($id);
          return $trv;
      break;
      case 0:
          $st=mt_rand(0,2);
          $zz = mt_rand(1,3); $s=0;$l=0;$i=0;
          switch($zz){
              case 1: $s=$user['level'] + $st; break;
              case 2: $l=$user['level'] + $st; break;
              case 3: $i=$user['level'] + $st; break;
          }
          $trv = $travmalist[mt_rand(0,count($travmalist)-1)];
          $time = 60*60*mt_rand(1,5)*$mult;
          mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$id."','".$trv."',".(time()+$time).",11,'".$s."','".$l."','".$i."','0');");
          mq("UPDATE `users` SET `sila`=`sila`-'".$s."', `lovk`=`lovk`-'".$l."', `inta`=`inta`-'".$i."' WHERE `id` = '".$id."' LIMIT 1;");
          ref_drop($id);
          return $trv;
      break;
      case "set":
          $st=mt_rand(0,2);
          $zz = mt_rand(1,3); $s=0;$l=0;$i=0;
          switch($zz){
              case 1: $s=$user['level'] + $st; break;
              case 2: $l=$user['level'] + $st; break;
              case 3: $i=$user['level'] + $st; break;
          }
          $trv = $travmalist[mt_rand(0,count($travmalist)-1)];
          $time = 60*60*mt_rand(1,5)*$mult;
          mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$id."','".$trv."',".(time()+$time).",11,'".$s."','".$l."','".$i."','0');");
          mq("UPDATE `users` SET `sila`=`sila`-'".$s."', `lovk`=`lovk`-'".$l."', `inta`=`inta`-'".$i."' WHERE `id` = '".$id."' LIMIT 1;");
          ref_drop($id);
          return $trv;
      break;
      case 11:
          $zz = mt_rand(1,3); $s=0;$l=0;$i=0;
          switch($zz){
              case 1: $s=($user['level'] + $st)*2;  break;
              case 2: $l=($user['level'] + $st)*2;  break;
              case 3: $i=($user['level'] + $st)*2;  break;
          }
          $trv = $travmalist2[mt_rand(0,count($travmalist2)-1)];
          $time = 60*60*mt_rand(5,15)*$mult;;
          //mq("DELETE FROM `effects` WHERE `id` = '".$owntravma['id']."' LIMIT 1;");
          mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$id."','".$trv."',".(time()+$time).",12,'".$s."','".$l."','".$i."','0');");
          //mq("UPDATE `users` SET `sila`=`sila`+'".$owntravma['sila']."', `lovk`=`lovk`+'".$owntravma['lovk']."', `inta`=`inta`+'".$owntravma['inta']."' WHERE `id` = '".$id."' LIMIT 1;");
          mq("UPDATE `users` SET `sila`=`sila`-'".$s."', `lovk`=`lovk`-'".$l."', `inta`=`inta`-'".$i."' WHERE `id` = '".$id."' LIMIT 1;");
          undressall($id);
          return $trv;
      break;
      case 12:
          $zz = mt_rand(1,3); $s=0;$l=0;$i=0;
          switch($zz){
              case 1: $s=($user['level'] + $st)*3; break;
              case 2: $l=($user['level'] + $st)*3; break;
              case 3: $i=($user['level'] + $st)*3; break;
          }
          $trv = $travmalist3[mt_rand(0,count($travmalist3)-1)];
          $time = 60*60*mt_rand(15,24)*$mult;;
          //mq("DELETE FROM `effects` WHERE `id` = '".$owntravma['id']."' LIMIT 1;");
          mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$id."','".$trv."',".(time()+$time).",13,'".$s."','".$l."','".$i."','0');");
          //mq("UPDATE `users` SET `sila`=`sila`+'".$owntravma['sila']."', `lovk`=`lovk`+'".$owntravma['lovk']."', `inta`=`inta`+'".$owntravma['inta']."' WHERE `id` = '".$id."' LIMIT 1;");
          mq("UPDATE `users` SET `sila`=`sila`-'".$s."', `lovk`=`lovk`-'".$l."', `inta`=`inta`-'".$i."' WHERE `id` = '".$id."' LIMIT 1;");
          undressall($id);
          return $trv;
      break;
      case 13:
        $zz = mt_rand(1,3); $s=0;$l=0;$i=0;
        switch($zz){
          case 1: $s=($user['level'] + $st)*3; break;
          case 2: $l=($user['level'] + $st)*3; break;
          case 3: $i=($user['level'] + $st)*3; break;
        }
        $trv = $travmalist3[mt_rand(0,count($travmalist3)-1)];
        $time = 60*60*mt_rand(3,4)*$mult;
        //mq("DELETE FROM `effects` WHERE `id` = '".$owntravma['id']."' LIMIT 1;");
        mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$id."','".$trv."',".(time()+$time).",14,'".$s."','".$l."','".$i."','0');");
        mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".$id."','Защита от травм',".(60*60*24+time()).",'".TRAVMARESISTANCE."')");
        //mq("UPDATE `users` SET `sila`=`sila`+'".$owntravma['sila']."', `lovk`=`lovk`+'".$owntravma['lovk']."', `inta`=`inta`+'".$owntravma['inta']."' WHERE `id` = '".$id."' LIMIT 1;");
        mq("UPDATE `users` SET `sila`=`sila`-'".$s."', `lovk`=`lovk`-'".$l."', `inta`=`inta`-'".$i."' WHERE `id` = '".$id."' LIMIT 1;");
        undressall($id);
        return $trv;
      break;
    }
  }
}
// удаляем травму
function deltravma($id) {
    $owntravmadb = mq("SELECT `type`,`id`,`sila`,`lovk`,`inta`,`owner` FROM `effects` WHERE `id` = ".$id." AND (type=11 OR type=12 OR type=13 OR type=14);");
    while ($owntravma = mysql_fetch_array($owntravmadb)) {
        mq("DELETE FROM `effects` WHERE `id` = '".$owntravma['id']."' LIMIT 1;");
        mq("UPDATE `users` SET `sila`=`sila`+'".$owntravma['sila']."', `lovk`=`lovk`+'".$owntravma['lovk']."', `inta`=`inta`+'".$owntravma['inta']."' WHERE `id` = '".$owntravma['owner']."' LIMIT 1;");
    }
}
// отображаем травму
function showtrawma() {
}
// telegrafick
function telegraph($to,$text, $output=1) {
    global $user;
    $ur = mysql_fetch_array(mq("select `id` from `users` WHERE `login` = '{$to}' LIMIT 1;"));
    if (!$ur) $ur=mqfa("select `id` from `allusers` WHERE `login` = '{$to}'");
    $us = mysql_fetch_array(mq("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$ur['id']}' LIMIT 1;"));
    if(!$ur) {
      if ($output) echo "<font color=red><b>Персонаж не найден.</b></font>";
    }
    elseif($us[0]){
      addchp (' ('.date("Y.m.d H:i").') <font color=darkblue>Сообщение телеграфом от </font><span oncontextmenu=OpenMenu()>'.nick7 ($user['id']).'</span>: '.$text.'  ','{[]}'.$to.'{[]}');
      if ($output) echo "<font color=red><b>Персонаж получил ваше сообщение</b></font>";
    } else {
      // если в офе
      if ($output) echo "<font color=red><b>Сообщение будет доставлено, как только персонаж будет on-line.</b></font>";
      mq("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$ur['id']."','','".'['.date("d.m.Y H:i").'] <font color=darkblue>Сообщение по телеграфу от </font><span oncontextmenu=OpenMenu()>'.nick7 ($user['id']).'</span>: '.$text.'  '."');");
    }
}
// telegrafick
function tele_check($to,$text) {
    global $user;
    $ur = mysql_fetch_array(mq("select `id` from `users` WHERE `login` = '{$to}' LIMIT 1;"));
    $us = mysql_fetch_array(mq("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$ur['id']}' LIMIT 1;"));
    if(!$ur) {
        echo "<font color=red><b>Персонаж не найден.</b></font>";
    }
    elseif($us[0]){
        addchp (' ('.date("Y.m.d H:i").') <font color=darkblue>Сообщение телеграфом от </font><span oncontextmenu=OpenMenu()>'.nick7 ($user['id']).'</span>: '.$text.'  ','{[]}'.$to.'{[]}');
    } else {
        // если в офе
        mq("INSERT INTO `telegraph` (`owner`,`date`,`text`) values ('".$ur['id']."','','".'['.date("d.m.Y H:i").'] <font color=darkblue>Сообщение по телеграфу от </font><span oncontextmenu=OpenMenu()>'.nick7 ($user['id']).'</span>: '.$text.'  '."');");
    }
}

function get_meshok(){
  global $user;
  $d=mysql_fetch_array(mq("SELECT sum(`gmeshok`) FROM `inventory` WHERE `owner` = '{$user['id']}' AND `setsale` = 0 AND `gmeshok`>0 ; "));
  return (40*$user["level"]+$user['vinos']+$d[0]);
}
function get_meshok_to($to){
  $d = mysql_fetch_array(mq("SELECT sum(`gmeshok`) FROM `inventory` WHERE `owner` = '{$to}' AND  `setsale` = 0 AND `gmeshok`>0 ; "));
  $s = mysql_fetch_array(mq("SELECT level, vinos FROM `users` WHERE `id` = '{$to}' LIMIT 1 ; "));
  return (40*$s["level"]+$s['vinos']+$d[0]);
  return ($s['sila']*4+$d[0]);
}

function backpacksize($u=0) {
  global $user;
  if ($u) {
    if ($u==2372) return 1000;
    if (!is_array($u)) $u=mqfa("select level, features from users where id='$u'");
    getfeatures($u);
    $l=$u["level"];
    $t=$u["thrifty"];
  } else {
    if ($user["id"]==2372) return 1000;
    $l=$user["level"];
    getfeatures($user);
    $t=$user["thrifty"];
  }
  if ($l==0) return $t*10+5;
  if ($l==1) return $t*10+15;
  if ($l==2) return $t*10+25;
  if ($l==3) return $t*10+35;
  if ($l==4) return $t*10+50;
  if ($l==5) return $t*10+75;
  if ($l==6) return $t*10+100;
  if ($l==7) return $t*10+110;
  if ($l==8) return $t*10+120;
  if ($l==9) return $t*10+140;
  if ($l==10) return $t*10+165;
  if ($l==11) return $t*10+190;
  if ($l>=12) return $t*10+200;
}

function addlog($id,$log) {
    $fp = fopen (DOCUMENTROOT."backup/logs/battle".$id.".txt","a"); //открытие
    flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
    fputs($fp , $log); //работа с файлом
    fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
    flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
    fclose ($fp); //закрытие
    //chmod("backup/logs/battle".$id.".txt",0777);
}

function dressitem2 ($id) {
    global $mysql, $user;
    $item = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE  `duration` < `maxdur` AND `id` = '{$id}' AND `dressed` = 0; "));
    switch($item['type']) {
        case 1: $slot1 = 'sergi'; break;
        case 2: $slot1 = 'kulon'; break;
        case 3: $slot1 = 'weap'; break;
        case 4: $slot1 = 'bron'; break;
        case 5: $slot1 = 'r1'; break;
        case 6: $slot1 = 'r2'; break;
        case 7: $slot1 = 'r3'; break;
        case 8: $slot1 = 'helm'; break;
        case 9: $slot1 = 'perchi'; break;
        case 10: $slot1 = 'shit'; break;
        case 11: $slot1 = 'boots'; break;
        case 12: $slot1 = 'm1'; break;
        case 22: $slot1 = 'naruchi'; break;
        case 23: $slot1 = 'belt'; break;
        case 24: $slot1 = 'leg'; break;
    }
    if($item['type']==5)
    {
        if(!$user['r1']) { $slot1 = 'r1';}
        elseif(!$user['r2']) { $slot1 = 'r2';}
        elseif(!$user['r3']) { $slot1 = 'r3';}
        else {
            $slot1 = 'r1';
            dropitem(5);
        }
    }
    elseif($item['type']==25)
    {
        if(!$user['m1']) { $slot1 = 'm1';}
        elseif(!$user['m2']) { $slot1 = 'm2';}
        elseif(!$user['m3']) { $slot1 = 'm3';}
        elseif(!$user['m4']) { $slot1 = 'm4';}
        elseif(!$user['m5']) { $slot1 = 'm5';}
        elseif(!$user['m6']) { $slot1 = 'm6';}
        elseif(!$user['m7']) { $slot1 = 'm7';}
        elseif(!$user['m8']) { $slot1 = 'm8';}
        elseif(!$user['m9']) { $slot1 = 'm9';}
        elseif(!$user['m10']) { $slot1 = 'm10';}
        elseif(!$user['m11']) { $slot1 = 'm11';}
        elseif(!$user['m12']) { $slot1 = 'm12';}
        else {
            $slot1 = 'm1';
            dropitem(12);
        }
    }
    else {
        dropitem($item['type']);
    }
    //echo $slot1,$id,$user['id'],$user['align'],$item['id'];
    if (!($item['type']==25 && $user['level'] < 4)) {
        if (mq("UPDATE `users` as u, `inventory` as i SET u.{$slot1} = {$id}, i.dressed = 1,
            u.sila = u.sila + i.gsila,
            u.lovk = u.lovk + i.glovk,
            u.inta = u.inta + i.ginta,
            u.intel = u.intel + i.gintel,
            u.maxhp = u.maxhp + i.ghp,
            u.maxmana = u.maxmana + i.gmana,
            u.noj = u.noj + i.gnoj,
            u.topor = u.topor + i.gtopor,
            u.dubina = u.dubina + i.gdubina,
            u.mec = u.mec + i.gmech,
            u.posoh = u.posoh + i.gposoh,
            u.mfire = u.mfire + i.gfire,
            u.mwater = u.mwater + i.gwater,
            u.mair = u.mair + i.gair,
            u.mearth = u.mearth + i.gearth,
            u.mlight = u.mlight + i.glight,
            u.mgray = u.mgray + i.ggray,
            u.mdark = u.mdark + i.gdark
                WHERE
            i.needident = 0 AND
            i.id = {$id} AND
            i.dressed = 0 AND
            i.owner = {$user['id']} AND
            u.sila >= i.nsila AND
            u.lovk >= i.nlovk AND
            u.inta >= i.ninta AND
            u.vinos >= i.nvinos AND
            u.intel >= i.nintel AND
            u.mudra >= i.nmudra AND
            u.level >= i.nlevel AND
            ((".(int)$user['align']." = i.nalign) or (i.nalign = 0)) AND
            u.id = {$user['id']};")) {
            $user[$slot1] = $item['id'];
            return  true;}
        }

}

function notminus($n) {
  if ($n<0) return 0;
  return $n;
}

function getnick($id) {
  if($id > _BOTSEPARATOR_) {
    return mqfa1('SELECT name FROM `bots` WHERE `id` = '.$id);
  } else {
    return mqfa1("SELECT login FROM `users` WHERE `id` = '{$id}'");
  }
}

function getid($nick, $battle) {
  $i=mqfa1("select id from bots where battle='$battle' and name='$nick'");
  if ($i) return $i;
  $i=mqfa1("select id from users where battle='$battle' and login='$nick'");
  if ($i) return $i;
}

function remquotesjs($s) { //         Javascript
  $ret=str_replace("'",'\'+String.fromCharCode(39)+\'',$s);
  $ret=str_replace('"','\'+String.fromCharCode(34)+\'',$ret);
  $ret=str_replace(">",'\'+String.fromCharCode(62)+\'',$ret);
  $ret=str_replace("<",'\'+String.fromCharCode(60)+\'',$ret);
  $ret=str_replace("\r","",$ret);
  $ret=str_replace("\n","",$ret);
  return $ret;
}

function takeshopitem($item, $table="shop", $present="", $onlyonetrip="", $destiny=0, $fields=0, $uid=0, $koll=1, $reason="", $podzem=0) {
  global $user;
  if (!$uid) $uid=$user["id"];
  $r=mq("show fields from $table");
  $r2=mq("show fields from inventory");
  while ($rec=mysql_fetch_assoc($r2)) $flds[$rec["Field"]]=1;
  $rec1=mqfa("select * from $table where id='$item'");
  if ($rec1["koll"]) {
    mq("insert into droplog set user=$uid, item='$rec1[name]', reason='$reason', dat=now()");
    mq("update inventory set koll=koll+$koll, massa=massa+".($rec1["massa"]*$koll)." where owner='$uid' and prototype='$item' limit 1");
    if (mysql_affected_rows()>0) return array("img"=>$rec1["img"], "name"=>$rec1["name"]);
    $rec1["koll"]=$koll;
    $rec1["massa"]*=$koll;
  }
  if ($rec1["onlyone"]) {
    $i=mqfa1("select id from inventory where owner='$uid' and prototype='$item'");
    if (!$i) $i=mqfa1("select item from obshagastorage where pers='$uid' and prototype='$item'");
    if ($i) return array("error"=>"У вас слишком много таких вещей.");
  }
  if ($present) {
    $rec1["present"]=$present;
    $rec1["cost"]=0;
    $rec1["ecost"]=0;
  }
  if ($fields) foreach ($fields as $k=>$v) $rec1[$k]=$v;
  $sql="";
  while ($rec=mysql_fetch_assoc($r)) {
    if (!@$flds[$rec["Field"]]) continue;
    if ($present) {
    if ($present!="Сундук") { if ($rec["Field"]=="maxdur") $rec1[$rec["Field"]]=1; }
      if ($rec["Field"]=="cost") $rec1[$rec["Field"]]=2;
    }
    if ($rec["Field"]=="dategoden") $goden=$rec1[$rec["Field"]];
    if ($rec["Field"]=="goden") $goden=$rec1[$rec["Field"]];
    if ($rec["Field"]=="id" || $rec["Field"]=="prototype" || $rec["Field"]=="dategoden") continue;
    $sql.=", `$rec[Field]`='".$rec1[$rec["Field"]]."' ";
  }
  if ($podzem) {
    $rec1["podzem"] = $podzem;
  }
  if ($fields["goden"]) $goden=$fields["goden"];
  // временные шмотки из потерянного входа
  $acond = ($item >= 2554 && $item <= 2559) ? ', dategoden = ' . (7200 + time()) : '' ;
  mq("insert into inventory set ".($present?"present='$present',":"").(@$rec1["podzem"]?"podzem='$rec1[podzem]',":"")." owner='$uid', prototype='$item' ".($onlyonetrip?", foronetrip=1":"").($goden?", dategoden='".($goden*60*60*24+time())."'":"").", destinyinv='$destiny' $sql" . $acond);
  return array("img"=>$rec1["img"], "name"=>$rec1["name"], "id"=>mysql_insert_id());
}

function takelukaitem($item) {
  $r=mq("show fields from shop_luka");
  $rec1=mqfa("select * from shop_luka where id='$item'");
  $sql="";
  while ($rec=mysql_fetch_assoc($r)) {
    if ($rec["Field"]=="id" || $rec["Field"]=="shshop" || $rec["Field"]=="count" || $rec["Field"]=="zeton" || $rec["Field"]=="goldzeton" || $rec["Field"]=="silverzeton" || $rec["Field"]=="destiny") continue;
    if ($rec["Field"]=="razdel") {
      $sql.=", `otdel`='".$rec1[$rec["Field"]]."' ";
    } else {
      if ($rec["Field"]=="goden") $goden=$rec1[$rec["Field"]];
      $sql.=", `$rec[Field]`='".$rec1[$rec["Field"]]."' ";
    }
  }
  mq("insert into inventory set podzem=1, owner='$_SESSION[uid]', prototype='$item' ".($goden?", dategoden='".($goden*60*60*24+time())."'":"")." $sql");
  if (!mysql_error()) return true;
  else return false;
}


function checkuserbylogin($l) {
  $r=mq("select id from users where login='$l' limit 1");
  if (mysql_num_rows($r)==0) {
    $id=mqfa1("select * from allusers where login='$l'");
    restoreuser($id);
  }
}

function checkuserbyid($id) {
  $r=mq("select id from users where id='$id' limit 1");
  if (mysql_num_rows($r)==0) {
    restoreuser($id);
  }
}

function checklog($log) {
  $i=mqfa1("select id from battle where id='$log'");
  if (!$i) mq("insert into battle (select * from allbattle where id='$log')");
  $i=mqfa1("select id from logs where id='$log'");
  if (!$i) mq("insert into logs (select * from alllogs where id='$log')");
  if (!file_exists("backup/logs/battle$log.txt")) {
    copy("backup/alllogs/battle$log.txt","backup/logs/battle$log.txt");
  }
}

function restoreuser($id) {
  if (!mqfa1("select COUNT(*) from users where id='$id'")) {
    mq("insert into users (select * from allusers where id='$id')");
  }
  $z=mysql_result(mysql_query("select zver_id from allusers where id='$id'"), 0, 0);
  if ($z) mq("insert into users (select * from allusers where id='$z')");
  mq("insert into online (select * from allonline where id='$id')");
  mq("insert into inventory (select * from allinventory where owner='$id')");
  mq("insert into puton (select * from allputon where id_person='$id')");
  mq("insert into userdata (select * from alluserdata where id='$id')");
  mq("insert into userstats (select id, exp, win, lose, nich from allusers where id='$id')");
  mq("insert into effects (select * from alleffects where owner='$id')");
  mq("insert into obshagaeffects (select * from allobshagaeffects where owner='$id')");
  mq("insert into obshagastorage (select * from allobshagastorage where pers='$id')");
}

function addqueststep($user, $quest, $v=1) {
  if ($user>_BOTSEPARATOR_) return;
  $i=mqfa1("select id from quests where user='$user' and quest='$quest'");
  if ($i) mq("update quests set step=step+$v where id='$i'");
  else mq("insert into quests set step='$v', user='$user', quest='$quest'");
}

function getqueststep($quest, $userid=0) {
  global $user;
  if (!$userid) $userid=$user["id"];
  return mqfa1("select step from quests where user='$userid' and quest='$quest'");
}

function gotoroom($r, $redir=1, $delcanal=0, $movetime=0) {  
  global $user;
  if (incastle($r) && !incastle($user["room"])) {
    $s=mqfa1("select value from variables where var='siege'");
    if ($s<10) return;
  }
  mq("UPDATE `users`,`online` SET `users`.`room` = '$r',`online`.`room` = '$r', users.movetime=".(time()+$movetime)." WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
  if ($delcanal) mq("delete from labirint where user_id='$user[id]'");
  if ($redir) redirectbyroom($r,1);
}

function moveuser($u, $r) {
  mq("UPDATE `users`,`online` SET `users`.`room` = '$r',`online`.`room` = '$r' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '$u'");
}

function errorreport() {
  if (@$_GET["error"]=="weight") echo '<div align=right><font color=red><b>У вас переполнен рюкзак, вы не можете передвигаться...</b></font></div>';
  if (@$_GET["warning"]) echo '<div align=right><font color=red><b>'.$_GET["warning"].'</b></font></div>';
}

function resetmax($id, $returnsql=0, $undress=1) {
  global $dressslots, $user;
  $stats=mqfa("select vinos, mudra, ".implode(", users.", $dressslots)." from users where id='$id'");
  $cond="";
  foreach ($dressslots as $k=>$v) $cond.=" or id=$stats[$v]";
  $addit=mqfa("select sum(ghp) as ghp, sum(gmana) as gmana from inventory where (owner='$id' and dressed=1 and type<>25) $cond");
  $addit["ghp"]=(int)$addit["ghp"];
  $effects=mqfa("select sum(ghp) as ghp, sum(gmana) as gmana from effects where owner='$id'");
  $oeffects=mqfa("select sum(ghp) as ghp, sum(gmana) as gmana from obshagaeffects where owner='$id'");
  $addit["ghp"]+=$effects["ghp"]+$oeffects["ghp"];
  $addit["gmana"]+=$effects["gmana"]+$oeffects["gmana"];
  $addit["gmana"]=(int)$addit["gmana"];
  if ($stats["vinos"]>=125) $addit["ghp"]+=250;
  elseif ($stats["vinos"]>=100) $addit["ghp"]+=250;
  elseif ($stats["vinos"]>=75) $addit["ghp"]+=175;
  elseif ($stats["vinos"]>=50) $addit["ghp"]+=100;
  elseif ($stats["vinos"]>=25) $addit["ghp"]+=50;
  $addit["ghp"]+=30;

  if ($stats["mudra"]>=125) $addit["gmana"]+=250;
  elseif ($stats["mudra"]>=100) $addit["gmana"]+=250;
  elseif ($stats["mudra"]>=75) $addit["gmana"]+=175;
  elseif ($stats["mudra"]>=50) $addit["gmana"]+=100;
  elseif ($stats["mudra"]>=25) $addit["gmana"]+=50;

  $hfv=6+mqfa1("select sum(hpforvinos) from effects where owner='$id'");

  if ($returnsql) return ", maxhp=vinos*$hfv+$addit[ghp], maxmana=mudra*10+$addit[gmana]";
  mq("update users set maxhp=vinos*$hfv+$addit[ghp], maxmana=mudra*10+$addit[gmana] where id='$id' and bot=0");
  mq("update users set hp=if(hp>maxhp, maxhp, hp), mana=if(mana>maxmana, maxmana, mana) where id='$id'");
  if ($id==$user["id"]) {
    $user["maxhp"]=$stats["vinos"]*$hfv+$addit["ghp"];
    $user["hp"]=min($user["hp"], $user["maxhp"]);
    $user["maxmana"]=$stats["mudra"]*10+$addit["gmana"];
    $user["mana"]=min($user["mana"], $user["maxmana"]);
  }
  //mq("update users set mana=maxmana where (id='$id' and mana>maxmana)");
}

function redirectbyroom($r,$force=0) {
  global $canalenters;
  $fn=str_replace("/","",$_SERVER["PHP_SELF"]);
  if (($r==20 || $r==45 || $r==49 || $r==54) && ($fn!="city.php" || $force)) {header("location: city.php");die;}
  if ($r==59 || $r==22) {header("location: shop.php");die;}
  if (in_array($r,$canalenters)) {header("location: vxod.php");die;}
  if ($r==402 || $r==47) {header("location: city.php");die;}
  if ($r==1) {header("location: main.php");die;}
  if (incastle($r)) {header("location: castle.php");die;}
}

function takefromzayavka($ui) {
  $z=mqfa1("select zayavka from users where id='$ui'");
  if ($z) {
    //mq("update users set zayavka=0 where id='$ui'");
    $rec=mqfa("select * from zayavka where id='$z'");
    if ($rec["type"]!=3 && $rec["type"]!=2) {
      mq("update users set zayavka=0 where zayavka='$z'");
      mq("delete from zayavka where id='$z'");
    } else {
      $tmp=explode(";",$rec["team1"]);
      foreach ($tmp as $k=>$v) if ($v==$ui) unset($tmp[$k]);
      $team1=implode(";", $tmp);
      $tmp=explode(";",$rec["team2"]);
      foreach ($tmp as $k=>$v) if ($v) if ($v==$ui) unset($tmp[$k]);
      $team2=implode(";", $tmp);
      mq("update zayavka set team1='$team1', team2='$team2' where id='$z'");
    }
    /*
    $tmp=explode(";",$rec["team1"]);
    foreach ($tmp as $k=>$v) if ($v) mq("update users set zayavka=0 where id='$v'");
    $tmp=explode(";",$rec["team2"]);
    foreach ($tmp as $k=>$v) if ($v) mq("update users set zayavka=0 where id='$v'");
    mq("delete from zayavka where id='$z'");*/
  }
}

function playervalue($p) {
  //$dressval=mqfa1("select SUM(minu+maxu+gsila+glovk+ginta+gintel+(ghp/5)+(gmana/5)+(mfkrit/6)+(mfakrit/6)+(mfakrit/6)+(mfuvorot/6)+(mfauvorot/6)+mfkritpow+mfantikritpow+mfdmag+(manausage*3)+(mfdfire/2)+(mfdwater/2)+(mfdair/2)+(mfdearth/2)+(mfdlight/2)+(mfddark/2)+(minusmfdmag*5)+(minusmfdfire*3)+(minusmfdwater*3)+(minusmfdair*3)+(minusmfdearth*3)+mfdhit+mfproboj+mfrub+mfkol+mfdrob+mfrej+mfcontr+mfparir+mfshieldblock+mfhitp+(mfmagp*2)+mfparir+(gnoj*4)+(gtopor*4)+(gdubina*4)+(gmech*4)+gposoh+(gluk*4)+(bron1/4)+(bron2/4)+(bron3/4)+(bron4/4)+(gfire*2)+(gwater*2)+(gair*2)+(gearth*2)+(glight*2)+(ggray*2)+(gdark*2)) from inventory where owner='$p' and dressed=1");
  $dressval=mqfa1("select sum(cost) from inventory where owner='$p' and dressed=1 and type<>25");
  $stats=mqfa("select level, sila, lovk, inta, vinos, intel, mudra, spirit from users where id='$p'");
  if ($stats["level"]>8) $dressval*=pow(1.2, $stats["level"]-8);
  return array("value"=>$stats["level"]*25+$stats["sila"]+$stats["lovk"]+$stats["inta"]+$stats["vinos"]+$stats["intel"]+$stats["mudra"]+$stats["spirit"]+$dressval, "mage"=>($stats["sila"]+$stats["lovk"]+$stats["inta"]>$stats["intel"]+$stats["mudra"]?0:1));
  //$mqfa1("select (level*25)+sila+lovk+inta+vinos+intel+mudra+spirit+ as val FROM users WHERE id = '$p'");
}

function substractmf($mf1, $mf2, $min=0.1){
  if ($mf1>$mf2) return 1+mftoabs($mf1-$mf2);
  else {
    $ret=1-mftoabs($mf2-$mf1);
    if ($ret<$min) return $min;
    return $ret;
  }
}

function chancebymf3($mf, $antimf, $min, $max, $c=50) {
  if ($mf>$antimf) {
    $antimf=$antimf/pow(1.2,$mf/$antimf);
    $ch=ceil((1-(($antimf+$c)/($mf+$c)))*$max);
  } else $ch=0;
  //$ch=ceil($ch*100);
  if ($ch>$max) return $max;
  return $ch;
}

function chancebymf2($mf, $antimf, $min, $max, $c=50) {
  if ($mf>$antimf) $ch=ceil((1-(($antimf+$c)/($mf+$c)))*$max);
  else $ch=0;
  //$ch=ceil($ch*100);
  if ($ch>$max) return $max;
  return $ch;
}

function chancebymf($mf, $antimf, $min=1, $max=99, $mid=10, $div=250){
  if ($mf<=$antimf) return 0;
  $diff=1-pow(0.5,abs($mf-$antimf)/$div);
  if ($mf>$antimf) {
    return ($max-$mid)*$diff+$mid;
  } else {
    return ($mid-$min)*(1-$diff)+$min;
  }
  $min=$min/100;
  $max=$max/100;
  $diffup=(1/(1+(abs($mf-$antimf)/(($max-$mid)*100))));
  $diffdown=(1/(1+(abs($mf-$antimf)/(($mid=$min)*100))));
  $ret=$mid;
  if ($mf>$antimf) $ret=$ret*(2-$diff);
  else $ret=$ret*$diff;
  if ($ret<$min) $ret=$min;
  if ($ret>$max) $ret=$max;
  return round($ret*100);
}

function getrandfromarray($a) {
  $r=rand(1,100);
  $sum=0;
  foreach ($a as $k=>$v) {
    if ($sum>$r) return $ret;
    $ret=$k;
    $sum+=$v;
  }
  return $ret;
}

function mftoabs($mf, $val=250) {
  return 1-pow(0.5,$mf/$val);
}

function sysmsg($msg) {
  if (filesize(CHATROOT."chat.txt")>20*1024) {
    //file_put_contents("chat.txt", file_get_contents("chat.txt", NULL, NULL, 3*1024), LOCK_EX);
    //@chmod("$fp", 0644);
    // г¤ «Ґ­ЁҐ Ї®б«Ґ¤­Ґ© бва®ЄЁ
    $file=file(CHATROOT."chat.txt");
    $fp=fopen(CHATROOT."chat.txt","w");
    flock ($fp,LOCK_EX);
    for ($s=0;$s<count($file)/1.5;$s++) {
      unset($file[$s]);
    }
    fputs($fp, implode("",$file));
    fputs($fp ,"\r\n:[".time ()."]:[!sys2all!!]:[<font color=\"#CB0000\">$msg</font>]:[1]\r\n"); //а Ў®в  б д ©«®¬
    flock ($fp,LOCK_UN);
    fclose($fp);
  } else {
    $fp = fopen (CHATROOT."chat.txt","a"); //®вЄалвЁҐ
    flock ($fp,LOCK_EX); //Ѓ‹ЋЉ€ђЋ‚ЉЂ ”Ђ‰‹Ђ
    fputs($fp ,"\r\n:[".time ()."]:[!sys2all!!]:[<font color=\"#CB0000\">$msg</font>]:[1]\r\n"); //а Ў®в  б д ©«®¬
    fflush ($fp); //Ћ—€™…Ќ€… ”Ђ‰‹Ћ‚ЋѓЋ Ѓ“”…ђЂ € ‡ЂЏ€‘њ ‚ ”Ђ‰‹
    flock ($fp,LOCK_UN); //‘Ќџ’€… Ѓ‹ЋЉ€ђЋ‚Љ€
    fclose ($fp); //§ ЄалвЁҐ
  }

}

function getchance($p) {
  /*static $ch;
  if (!@$ch) {
    srand();
    $ch=1;
  }*/
  if (mt_rand(1,100)<=$p) return 1;
  else return 0;
}

function adduserdata($data, $value, $userid=0) {
  global $user;
  if (!$userid) $userid=$user["id"];
  getadditdata($user);
  $user[$data]+=$value;
  mq("update userdata set $data=$data+$value where id='$userid'");
}

function bottouser($i) {
  static $cache;
  if ($i<_BOTSEPARATOR_) return $i;
  elseif (@$cache[$i]) return $cache[$i];
  else {
    $cache[$i]=mqfa1("select prototype from bots where id='$i'");;
    return $cache[$i];
  }
}

function roomobject($left, $top, $src, $name, $room, $is=0, $link="") {
  global $user;
  if (!$is) $is=getImageSize($src);
  return '<div '.($user["id"]==0?' onmouseover="this.style.display=\'none\'"':'').' style="cursor:pointer;position:absolute; left:'.$left.'px; top:'.$top.'px; width:'.$is[0].'px; height:'.$is[1].'px; z-index:90;"><img src="'.IMGBASE.$src.'" alt="" class="aFilter" onMouseOver="imover(this)" onMouseOut="imout(this); " title="'.$name.'" onclick="'.($room?"solo('$room','$name', '')":($link?"document.location.href='$link';":"")).'"/></div>';
}

function movebar() {
  return '
<div id="snow"></div>

<div style="position:absolute; right:0px; top:0px; width:95px; height:17px; z-index:101; overflow:visible;">
<TABLE height=15 border="0" cellspacing="0" cellpadding="0">
<TR>
<TD rowspan=3 valign="bottom"><a href="?rnd=0.0522273087263743"><img src="/i/move/rel_1.gif" width="15" height="16" alt="Обновить" border="0" /></a></TD>
<TD colspan="3"><img src="/i/move/navigatin_462s.gif" width="80" height="4" /></TD>
</TR>
<TR>
<TD><IMG src="/i/move/navigatin_481.gif" width="9" height="8"></TD>
<TD width=64 bgcolor=black><DIV class="MoveLine"><IMG src="/i/move/wait2.gif" id="MoveLine" class="MoveLine"></DIV></TD>
<TD><IMG src="/i/move/navigatin_50.gif" width="7" height="8"></TD>
</TR>
<TR>
<TD colspan="3"><IMG src="/i/move/navigatin_tt1_532.gif" width="80" height="5"></TD>
</TR>
</TABLE>
</div>
</div>
  ';
}

function echoroom($objs, $bg="", $wd=500, $ht=240) {
  global $user;
  if (!$bg && $user["id"]!=50) $bg="$user[room]_bg.gif";
  $ret="<div style=\"position:relative\" id=\"ione\"><img src=\"".IMGBASE."i/rooms/$bg\" id=\"img_ione\" width=\"$wd\" height=\"$ht\" alt=\"\" border=\"1\"/>";
  foreach ($objs as $k=>$v) $ret.=$v;
  $ret.=movebar();
  $ret.="</div><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"1\"><tr><td>";
  $ret.="<tr><td align=\"right\"><div align=\"right\" id=\"btransfers\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" id=\"bmoveto\">
<tr><td bgcolor=\"#D3D3D3\">
</td>
</tr>
</table></td></tr>
</table>";
  return $ret;
}

function buildset($id,$img,$top,$left,$des, $link="", $msg="") {
 global $loclinks;
 if (!$id) {
   echo "<img style=\"position:absolute;left:{$left}px;top:{$top}px\" src=\"/img/city/{$img}.gif\" alt=\"{$des}\" title=\"{$des}\">";
   return;
 }
 if (!$link && !$msg) $loclinks.="<span style=\"white-space:nowrap; padding-left:3px; padding-right:3px; height:10px\"><img src=\"".IMGBASE."/i/move/links.gif\" width=\"9\" height=\"7\" />&nbsp;<a href=\"#\" class=\"menutop\" title=\"Время перехода: 10 сек.\" id=\"bmo_$id\" onmouseover=\"bimover(this);\" onmouseout=\"bimout(this);\" onclick=\"return bsolo(this);\">$des</a></span>";
 $imga = ImageCreateFromGif("img/city/".$img.".gif");
 #Get image width / height
 $x = ImageSX($imga);
 $y = ImageSY($imga);
 $ext='gif';
 unset($imga);
 echo "<div style=\"cursor:pointer; position:absolute; left:{$left}px; top:{$top}px; width:{$x}; height:${y}; z-index:90; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);\"
 ><img src=\"/img/city/{$img}.{$ext}\" width=\"${x}\" height=\"${y}\" alt=\"{$des}\" title=\"{$des}\" class=\"aFilter\" onmouseover=\"imover(this)\" onmouseout=\"imout(this);\"
 id=\"mo_{$id}\" onclick=\"".($link?"document.location.href='$link';":($msg?"alert('$msg');return false;":"solo('".$id."','".$des."', '')"))."\" /></div>";
}

function getmicrotime() {
  list($usec, $sec) = explode(" ", microtime());
  return floor(((float)$usec + (float)$sec)*1000);
}

function timepassed() {
  global $tme1;
  //if ($_SERVER["REMOTE_ADDR"]=="127.0.0.1" || $_SESSION["uid"]==7) echo "Passed: ".(getmicrotime()-$tme1)." ms<br>";
}

function isonline($user) {
  return mqfa1("select `date`>=".(time()-300)." from online where id='$user'");
}

function addslashesa($s){
  return str_replace("'","\\'",$s);
}

function hitpower($user, $type) {
  if ($type=="kol") $ret=($user["sila"]*0.6)+$user["lovk"]*0.4;
  if ($type=="rub") $ret=($user["sila"]*0.6)+$user["lovk"]*0.2+$user["inta"]*0.2;
  if ($type=="rej") $ret=$user["sila"]*0.6+$user["inta"]*0.4;
  if ($type=="drob") $ret=$user["sila"];
  if ($type=="mag") $ret=(($user["sila"]/2)+($user["lovk"])/2)*($user["intel"]/200+1);
  $ret=$user["sila"];
  if ($user["dvur"]) $ret*=1.5;
  return ceil($ret);
}

function secs2hrs($s, $short=0) {
  if ($s<60) return "$s сек.";
  $retstr="";
  if ($s<3600) {
    $min=floor($s/60);
    if ($min || !$short) $retstr.="$min мин. ";
    $sec=$s%60;
    if ($sec || !$short) $retstr.="$sec сек.";
    return $retstr;
  }
  $ret="";
  $ret=floor($s/3600);
  $s=$s%3600;

  $d=floor($ret/24);
  $h=$ret%24;
  if ($d && ($d>1 || $h ||$s)) {
    $retstr.="$d д. ";
    if ($h || !$short) $retstr.="$h ч. ";
    $min=floor($s/60);
    if ($min || !$short) $retstr.="$min мин.";
    return $retstr;
  } elseif ($d) $h+=$d*24;
  if ($h) {
    $retstr="$h ч. ";
    $min=floor($s/60);
    if ($min || !$short) $retstr.="$min мин.";
    return $retstr;
  }
  return floor($s/60)." мин. ".($s%60)." сек.";
}

function adddelo($user, $txt, $type) {
  // 9 - оплата прохода по пещере
  mq("INSERT INTO `delo` (`pers`, `text`, `type`, `date`) VALUES ('$user','$txt', $type,'".time()."');");
}

function hassmallitems($item, $qty=1, $userid=0) {
  global $user;
  if (!$userid) $userid=$user["id"];
  $cnt=mqfa1("select sum(koll) from inventory where owner='$userid' and name='$item' and setsale=0 and (dategoden=0 or dategoden>".time().")");
  if ($cnt>=$qty) return $cnt;
  else return 0;
}

function takesmallitems($item, $qty, $user) {
  if ($qty==0) return;
  if ($qty==-1) {
    mq("delete from inventory where owner='$user' and name='$item' and setsale=0");
  } else {
    $r=mq("select id, koll, massa from inventory where owner='$user' and name='$item' and setsale=0");
    while ($rec=mysql_fetch_assoc($r)) {
      if ($rec["koll"]<=$qty) {
        mq("delete from inventory where id='$rec[id]'");
      } else {
        $m=$rec["massa"]/$rec["koll"];
        mq("update inventory set koll=koll-$qty, massa='".($m*($rec["koll"]-$qty))."' where id='$rec[id]'");
      }
      $qty-=$rec["koll"];
      if ($qty<0) return;
    }
  }
}

function firstzeros($n){
  if ($n<10) return "0$n";
  return $n;
}

function showtime($secs, $atfinish="") {
  static $tn;
  if (!@$tn) $tn=0;
  $tn++;
  $t=firstzeros(floor($secs/60)).":".firstzeros($secs%60);
  $ret="<span id=\"tme$tn\">$t</span>";
  if ($secs>0) $ret.="<script type=\"text/javascript\">
  showtime('tme$tn',$secs,\"$atfinish\");
  </script>";
  else $ret="<script type=\"text/javascript\">
  $atfinish
  </script>";
  return $ret;
}

function hasbad($txt) {
  $txt=str_replace("-","",$txt);
  $txt=str_replace("_","",$txt);
  $txt=str_replace(".","",$txt);            
  $txt=str_replace("Стеба","",$txt);
  $txt=str_replace("СТЕБА","",$txt);
  $txt=str_replace("стеба","",$txt);
  $txt=str_replace("ребан","",$txt);
  $txt=str_replace("рёбан","",$txt);
  $txt=str_replace("РЕБАН","",$txt);
  $txt=str_replace("РЁБАН","",$txt);
  $txt=str_replace("ебанк","",$txt);
  $txt=str_replace("Ебанк","",$txt);
  $txt=str_replace("страхуй","",$txt);
  $txt=str_replace("психуй","",$txt);
  $txt=str_replace("СТРАХУЙ","",$txt);
  $txt=str_replace("ПСИХУЙ","",$txt);
  $txt=str_replace("колеба","",$txt);
  $txt=str_replace("КОЛЕБА","",$txt);
  $txt=str_replace("учеба","",$txt);
  $txt=str_replace("УЧЕБА","",$txt);
  $txt=str_replace("учёба","",$txt);
  $txt=str_replace("УЧЁБА","",$txt);
  $bad=preg_match('/.*?хуй.*?/i', " $txt ");
  if (!$bad) $bad=preg_match('/.*?пизд.*?/i', " $txt ");
  if (!$bad) $bad=preg_match('/.*?ебан.*?/i', " $txt ");
  if (!$bad) $bad=preg_match('/.*?ёбан.*?/i', " $txt ");
  if (!$bad) $bad=preg_match('/.*?пидар.*?/i', " $txt ");
  if (!$bad) $bad=preg_match('/.*?huj.*?/i', " $txt ");
  if (!$bad) $bad=preg_match('/.*?pizd.*?/i', " $txt ");
  if (!$bad) $bad=preg_match('/.*?eban.*?/i', " $txt ");
  if (!$bad) $bad=preg_match('/.*?joban.*?/i', " $txt ");
  if (!$bad) $bad=preg_match('/.*?бляд.*?/i', " $txt ");
  return $bad;
}

function haslinks($txt) {
  if ($_SESSION["uid"]==7 && $_SERVER["REMOTE_ADDR"]!="127.0.0.1") return false;    

  $txt=strtolower($txt);
  $txt=str_replace("rambler.ru","",$txt);
  $txt=str_replace("mail.ru","",$txt);
  $txt=str_replace("youtube.com","",$txt);
  $txt=str_replace("gmail.com","",$txt);
  $txt=str_replace("rebornold.ru","",$txt);
  $txt=str_replace("@",".",$txt);
  $txt=str_replace("_",".",$txt);
  $txt=str_replace("*",".",$txt);
  $txt=str_replace("?",".",$txt);
  $txt=str_replace("=",".",$txt);
  $txt=str_replace("-",".",$txt);
  $txt=str_replace(",",".",$txt);
  $txt=str_replace("(","",$txt);
  $txt=str_replace(")","",$txt);
  $txt=str_replace("&lt;","",$txt);
  $txt=str_replace("&gt;","",$txt);
  $txt1=$txt;
  $txt=" $txt ";

  $txt=preg_replace("/\s*\.\s*/", ".", $txt);
  $txt=preg_replace("/(\s|\.)r(\s|\.){0,}u(\s|\.|\/)/i", ".ru ", $txt);
  $txt=preg_replace("/(\s|\.)u(\s|\.){0,}a(\s|\.|\/)/i", ".ru ", $txt);
  $txt=preg_replace("/(\s|\.)o\s{0,}r(\s|\.)\s{0,}g(\s|\.)/i", ".org", $txt);
  $txt=preg_replace("/(\s|\.)c(\s|\.){0,}o(\s|\.){0,}m(\s|\.|\/)/i", ".com ", $txt);

  $txt=str_replace("c o m","com",$txt);
  $txt=str_replace("r u","ru",$txt);
  $txt=str_replace(" ру ",".ru",$txt);
  $txt=str_replace(" pу ",".ru",$txt);
  $txt=str_replace(" рy ",".ru",$txt);
  $txt=str_replace(" com ",".com ",$txt);
  $txt=str_replace(" net ",".net ",$txt);
  $txt=str_replace("combats ru","combats.ru",$txt);
  $txt=str_replace("COMBATS RU","combats.ru",$txt);
  $txt=str_replace("wars az","wars.az",$txt);
  //$txt=str_replace("  "," ",$txt);
  if (strpos(strtolower($txt),"warbk")) return true;
  $txt=str_replace("["," [ ",$txt);
  $txt=str_replace("]"," ] ",$txt);
  $txt=str_replace("..",".",$txt);
  $txt=str_replace("..",".",$txt);
  $txt=str_replace("цом","com",$txt);
  $txt=str_replace("ur.stabmoc","combats.ru",$txt);
  $txt=" $txt ";
  //$txt=str_replace(" ","",$txt);
  //$txt=str_replace("_",".",$txt);
  //$txt=str_replace("*",".",$txt);
  //$txt=str_replace("-",".",$txt);
                 //(https?:\/\/|\s|^)
                 
    
    if (strpos($txt,".com") !== false) return true;
    if (strpos($txt,". com") !== false) return true;
    if (strpos($txt,".ru") !== false) return true;
                     
/*
  $txt=str_replace("с","c", $txt);
  $txt=str_replace("о","o", $txt);
  $txt=str_replace("м","m", $txt);
  $txt=str_replace("С","c", $txt);
  $txt=str_replace("О","o", $txt);
  $txt=str_replace("М","m", $txt);
  $txt=str_replace("К","c", $txt);
  $txt=str_replace("Б","b", $txt);
  $txt=str_replace("М","m", $txt);
  $txt=str_replace("а","a", $txt);
  $txt=str_replace("Т","t", $txt);
  $txt=str_replace("к","c", $txt);
  $txt=str_replace("б","b", $txt);
  $txt=str_replace("А","a", $txt);
  $txt=str_replace("Т","t", $txt);
  $txt=str_replace("З","Z", $txt);
  $txt=str_replace("з","z", $txt);
  $txt=str_replace("(точcа)",".", $txt);
  $txt=preg_replace("/.ru([а-яА-Я])/",".ru \\1",$txt);
*/

  //if ($_SESSION["uid"]==7) {
  //  $f=fopen("ot.txt", "ab+");
  //  fwrite($f,$txt);
  //  fclose($f);
  //} 
  
  
  //if (strpos($txt,".to") !== false) return true;
  if (strpos($txt,"t o /") !== false) return true;
  if (strpos($txt,"h e o l . b i z") !== false) return true;
  if (strpos($txt,"devilwar") !== false) return true;
  if (strpos($txt,"legendarybk") !== false) return true;
  if (strpos($txt,"l a s t c a r n a g e . o r g") !== false) return true;
  if (strpos($txt,"goo_gl") !== false) return true;
  if (strpos($txt,".to/") !== false) return true;
  if (strpos($txt,"goo.gl") !== false) return true;
  if (strpos($txt,"u.to") !== false) return true;
  if (strpos($txt,"legendworld") !== false) return true;
  if (strpos($txt,"worldofchaos") !== false) return true; 
  if (strpos($txt,"жарcаз") !== false) return true;
  if (strpos($txt,"казварс") !== false) return true;
  if (strpos($txt,"cazbc") !== false) return true;
  if (strpos($txt,"точcаkz") !== false) return true;
  if (strpos($txt,"obk2") !== false) return true;
  if (strpos($txt,"о б к 2") !== false) return true;
  if (strpos($txt,"sbk2") !== false) return true;
  if (strpos($txt,"s b k 2") !== false) return true;
  //if (strpos($txt,"http://") !== false) return true;
  if (strpos($txt,"obk") !== false) return true;
  if (strpos($txt,"обк2") !== false) return true;
  if (strpos($txt,"Обк2") !== false) return true;
  if (strpos($txt,"bget") !== false) return true;
  if (strpos($txt,"тoчcаcom")  !== false) return true;
  if (strpos($txt,"lcombats") !== false) return true;
  if (strpos($txt,"combats") !== false) return true;
  if (strpos($txt,"c o m b a t s") !== false) return true;
  if (strpos($txt,"h t t p") !== false) return true;
  if (strpos($txt,"w w w") !== false) return true;
  if (strpos($txt,"world-fight") !== false) return true;
  if (strpos($txt,"n b k - l i v e") !== false) return true;
  if (strpos($txt,"cruel-world.ru") !== false) return true;
  if (strpos($txt,"goo.gl/p8rk8") !== false) return true;
  if (strpos($txt,"goo.gl/lr") !== false) return true;
  if (strpos($txt,"goo.gl/pzh1") !== false) return true;
  if (strpos($txt,"*ком") !== false) return true;
  if (strpos($txt,"ру-лол") !== false) return true;
  if (strpos($txt,"oasis(точка)evolutions(точка)ru") !== false) return true;


  if (preg_match('/combat[sc].*2/ie', " $txt ")) return 1;                 
  if (preg_match('/(s2\.)([cс][oо][mм])(\/\S*)?/ie', " $txt ")) return 1;
  return preg_match('/(([a-zA-Zа-яА-Я0-9\-_\.]+\.)(c.o.m|com|ru|org|co.cc|net|ua|do\.am|su[^p]|us|tk|us|kz|az|biz|рф|info|lv|in|org)(\/|\s|-|_|\.|:))/ie', " $txt ")+strpos($txt,"register.php");
  return preg_match('/(([a-zA-Zа-яА-Я0-9\-_\.]+\.)(com)\S)/ie', " $txt ")+strpos($txt,"register.php");
  return preg_match("/meydan\\.in^[a-zA-Z]+/i", " $txt ")+strpos($txt,"register.php");
  return preg_match('/(([a-zA-Zа-яА-Я0-9\-_\.]+\.)(c.?o.?m|ru|org|co.cc|net|ua|do\.am|su[^p]|us|tk|us|kz|az|biz|рф|info|lv|in)[a-z])/ie', " $txt ")+strpos($txt,"register.php");
  return preg_match('/(([a-zA-Zа-яА-Я0-9\-_\.]+\.)(c.?o.?m|com|ru|org|co.cc|net|ua|do\.am|su[^p]|us|tk|us|kz|az|biz|рф|info)(\/|\S))/ie', " $txt ")+strpos($txt,"register.php");
}                                                        

function getdamage($user_dress, $weapnum, $use2h=1) {
  $profs=array("chkol", "chrub", "chrej", "chdrob", "chmag");
  $minu=0; $maxu=0;
  if ($weapnum==1) $wd=$user_dress["minimax"];
  else $wd=$user_dress["minimax1"];
  foreach ($profs as $k=>$v) {
    if ($wd[$v]==0) continue;
    $mm=getprofdamage($user_dress, $weapnum, $v, 1, $use2h);
    $minu+=$mm[0]*$wd[$v]/100;
    $maxu+=$mm[1]*$wd[$v]/100;
    $minukrit+=$mm[2]*$wd[$v]/100;
    $maxukrit+=$mm[3]*$wd[$v]/100;
    if (DAMAGEDEBUG) echo "<b>$v</b>: $mm[0]/$mm[1] ($wd[$v])<br>";

  }
  return array(round($minu), round($maxu), round($minukrit), round($maxukrit));
}

function getprofdamage($user_dress, $weapnum, $prof, $fistbonus=1, $use2h=1) {
  $newdamage=0;
  $new2h=1;

  if ($prof!="rub" && $prof!="kol" && $prof!="rej" && $prof!="drob" && $prof!="mag") $prof=substr($prof,2);
  if ($weapnum==1) $wd=$user_dress["minimax"];
  else $wd=$user_dress["minimax1"];
  if ($wd["weptype"]) $wt=$wd["weptype"];
  else $wt=getweaptype($wd["otdel"]);
  $minu=0;
  $maxu=0;

  if ($weapnum==1) {
    $weapon1=$user_dress["minimax"];
    $weapon2=$user_dress["minimax1"];
  } else {
    $weapon1=$user_dress["minimax1"];
    $weapon2=$user_dress["minimax"];
  }

  if ($wt=="kulak") {
    $minu=2;
    $maxu=4;
    if ($fistbonus) {
      if ($user_dress["sila"]>100) $power=$user_dress["sila"]+50;
      elseif ($user_dress["sila"]<25) $power=$user_dress["sila"]*2;
      else $power=$user_dress["sila"]*1.5;
    } else $power=$user_dress["sila"];
  } else {
    if ($wt=="noj") $power=$user_dress["sila"]*0.6+($user_dress["lovk"]*0.4);
    if ($wt=="topor") $power=$user_dress["sila"]*0.7+($user_dress["lovk"]*0.2);
    if ($wt=="dubina") $power=$user_dress["sila"]*0.9;
    if ($wt=="mech") $power=$user_dress["sila"]*0.6+($user_dress["inta"]*0.4);
    if ($wt=="posoh") $power=$user_dress["intel"]*0.33;
    if ($wt=="buket") $power=$user_dress["sila"]*0.3+$user_dress["lovk"]*0.3;
    //$power=$minu;
  }
  if ($user_dress["dvur"] && $use2h) {
    if ($new2h) $power*=1.3;
    else $power*=1.1;
  }

  if ($user_dress["power"] && $prof!="mag") $power*=1+($user_dress["power"]/100);

  //$power=floor($power);

  if (DAMAGEDEBUG) echo "Power: $power<br>";
  /*if ($weapnum==1) {
    $minu+=$user_dress["minu"]-$user_dress["minimax1"]["minu"];
    $maxu+=$user_dress["maxu"]-$user_dress["minimax1"]["maxu"];
  } else {
    $minu+=$user_dress["minu"]-$user_dress["minimax"]["minu"];
    $maxu+=$user_dress["maxu"]-$user_dress["minimax"]["maxu"];
  }*/

  $minu+=$user_dress["minu"]-$weapon2["minu"];
  $maxu+=$user_dress["maxu"]-$weapon2["maxu"];

  if ($user_dress["dvur"]) {
    if ($new2h) $user_dress[$wt]*=1.5;
    else $user_dress[$wt]*=1.2;
  }

  if ($newdamage) {
    if ($minu<14) $minu+=ceil($minu*0.075)*($user_dress[$wt]-$weapon2["g$wt"]); 
    else $minu*=1+(($user_dress[$wt]-$weapon2["g$wt"])*0.075);
    if ($maxu<14) $maxu+=ceil($maxu*0.075)*($user_dress[$wt]-$weapon2["g$wt"]); 
    else $maxu*=1+(($user_dress[$wt]-$weapon2["g$wt"])*0.075);
  }

  if (DAMAGEDEBUG) echo "Weapon damage: $minu/$maxu<br>";

  //if ($user_dress["dvur"]) $power*=1.2;


  $minu+=$power/3;
  $maxu+=$power/3;

  $minu+=$power/5;
  $maxu+=$power/5;

  if (DAMAGEDEBUG) echo "Start damage: $minu/$maxu ($power)<br>";

  $k1=1+$power/300;
  if (DAMAGEDEBUG) echo "Skill($wt): $user_dress[$wt]<br>";
  if (DAMAGEDEBUG) echo "Profile: $prof<br>";                   
  if (!$newdamage) $k2=1+(($user_dress[$wt]-$weapon2["g$wt"])*0.075);
  else $k2=1;
  $k2e=1; //if elemental attack
  if (DAMAGEDEBUG) echo "Hitp: $user_dress[mfhitp]+{$user_dress["mf$prof"]}<br>";
  if ($prof=="mag") $k3=($user_dress["mfmagp"]+$user_dress["intel"]/2)/100+1;
  else $k3=($user_dress["mfhitp"]-$weapon2["mfhitp"]+$user_dress["mf$prof"]-$weapon2["mf$prof"])/100+1; //mf hitp
  if ($user_dress["level"]<=8) {
    $k4=0.97;
  } else {
    $k4=0.97-(0.07*($user_dress["level"]-8));
  }

  $minu*=$k1*$k2*$k2e*$k3*$k4;
  $maxu*=$k1*$k2*$k2e*$k3*$k4;

  if ($user_dress["sila"]>=125) {
    $minu+=10;
    $maxu+=10;
  }

  $minukrit=$minu*2*(($user_dress["mfkritpow"]-$weapon2["mfkritpow"])/100+1);
  $maxukrit=$maxu*2*(($user_dress["mfkritpow"]-$weapon2["mfkritpow"])/100+1);

  if (DAMAGEDEBUG) echo "Final damage ($k1 $k2 $k3): $minu/$maxu $minukrit/$maxukrit<br>
  Krit: $minukrit / $maxukrit * 1.".($user_dress["mfkritpow"]-$weapon2["mfkritpow"])."<br>";

  //$minu=round($minu);
  //$maxu=round($maxu);
  //$minukrit=round($minukrit);
  //$maxukrit=round($maxukrit);
  return array($minu, $maxu, $minukrit, $maxukrit);
}

function getweaptype($otdel) {
  if($otdel== 1) {
    return "noj";
  } elseif($otdel==12) {
    return "dubina";
  } elseif($otdel==11) {
    return "topor";
  } elseif($otdel==13) {
    return "mech";
  } elseif($otdel==30) {
    return "posoh";
  } elseif ($otdel) {
    return "buket";
  } else {
    return "kulak";
  }

}

function notnegative($n) {
  if ($n<0) return 0;
  return $n;
}

function getadditdata(&$user) {
  if (isset($user["deals"])) return;
  $u=mqfa("select * from userdata where id='$user[id]'");
  if (!$u) {
    mq("insert into userdata (id) values ('$user[id]')");
    $u=mqfa("select * from userdata where id='$user[id]'");
  }
  foreach ($u as $k=>$v) {
    if ($k=="sila" || $k=="lovk" || $k=="inta" || $k=="vinos" || $k=="intel" || $k=="mudra" || $k=="spirit" || $k=="sexy" || $k=="stats" || $k=="master"
    || $k=="noj" || $k=="mec" || $k=="topor" || $k=="dubina" || $k=="posoh" || $k=="luk" || $k=="mfire" || 
    $k=="mwater" || $k=="mair" || $k=="mearth" || $k=="mlight" || $k=="mgray" || $k=="mdark" || $k=="master" || $k=="align") $k="b_$k";
    if ($k!="id") $user[$k]=$v;
  }
}

function getfeatures(&$user, $id=0) {
  $i=0;
  if ($id) $num=mqfa1("select features from users where id='$id'");
  else $num=$user["features"];
  $ret=array();
  while ($i<11) {
    $ret[]=$num-(8*floor($num/8));
    $num=floor($num/8);
    $i++;
  }
  $user["friendly"]=$ret[0];
  $user["sociable"]=$ret[1];
  $user["dodgy"]=$ret[2];
  $user["resistant"]=$ret[3];
  $user["fast"]=$ret[4];
  $user["smart"]=$ret[5];
  $user["thrifty"]=$ret[6];
  $user["communicable"]=$ret[7];
  $user["sturdy"]=$ret[8];
  $user["sane"]=$ret[9];
  $user["sleep"]=$ret[10];
}

function bottombuttons() {
  global $user, $canalrooms;
  $ret="<script>
var hl = false;
function highlight(on) {
var lst = document.getElementById('ione');
if (lst) {
hl = hl ? false : true;
lst = lst.children;
for (var i=0; i<lst.length; i++) {
if ( lst[i].firstChild && lst[i].firstChild.className == 'aFilter' )
hl?imover(lst[i].firstChild):imout(lst[i].firstChild);
}}}</script>
  <input type=\"button\" value=\"Объекты\" onClick=\"highlight()\" class=\"btn\"> ";
  $clubrooms=array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 15, 16, 19);
  $battlerooms=array(1, 5, 6, 7, 8, 9, 10, 15, 16, 19);
  if ($user["recalltime"]<time() && !in_array($user["room"], $canalrooms) && $user["room"]!=20) $ret.=" <INPUT TYPE=button value=\"Возврат\" onClick=\"location.href='main.php?recall=1';\" style=\"border: 1px double #9a9996;font-size: 12px;color: #dfdfdf;background-color:#504F4C;\"> ";
  if (in_array($user["room"], $battlerooms)) $ret.=" <INPUT TYPE=button name=combats value=\"Поединки\" onClick=\"location.href='zayavka.php';\" style=\"border: 1px double #9a9996;font-size: 12px;color: #dfdfdf;background-color:#504F4C;\"> ";
  $ret.="<INPUT TYPE=button onClick=\"window.open('/forum.php', 'forum', 'location=yes,menubar=yes,status=yes,resizable=yes,toolbar=yes,scrollbars=yes,scrollbars=yes')\" class=\"btn\" style=\"border: 1px double #9a9996;font-size: 12px;color: #dfdfdf;background-color:#504F4C;\" value=\"Форум\"> ";
  if (in_array($user["room"], $clubrooms)) $ret.="<INPUT TYPE=button onClick=\"location.href='main.php?newbies=1'\" style=\"width:115px;border: 1px double #9a9996;font-size: 12px;color: #dfdfdf;background-color:#504F4C;\" value=\"Комната новичков\">";
  return $ret;
}

function addcheater($reason) {
  global $user;
  $f=fopen("logs/cheaters.txt", "ab+");
  fwrite($f,date("Y-m-d H:i")." $_SERVER[REMOTE_ADDR] $_SESSION[uid] => $user[login] $reason\r\n");
  fclose($f);  
}

function logerror($error) {
  global $user;
  $f=fopen("logs/error.log", "ab+");
  fwrite($f,date("Y-m-d H:i")." $_SERVER[REMOTE_ADDR] $_SESSION[uid] => $user[login] $error\r\n");
  fclose($f);
}

function canmove($spd=10) {
  global $user, $warning;
  $i=mqfa1("select id from fieldmembers where room='$user[room]' and user='$user[id]'");
  if ($i) {
    include "config/fielddata.php";
    if (!@$fielddata[$user["room"]]["leaveroom"]) {
      $warning="Чтобы передвигатся вам необходимо отказатся от заявки.";
      echo "<font color=red><b>$warning</b></font>";
      return false;
    }
  }
  if($_SESSION['perehod']>time()){
    $warning="Не так быстро...";
    echo "<font color=red><b>$warning</b></font>";
    return false;
  } 
  
  $sl=mqfa1("select sleep from obshaga where pers='$user[id]'");
  if ($sl) {
    //if ($sl <= time()) {
      //mysql_query("UPDATE obshaga SET sleep = 0 WHERE pers='$user[id]'");
    //} else {
      return false;
    //}
  }

  if ($_SESSION['perehod']>time() && !@$_GET["strah"] && !@$_GET["cp"]) {
    $warning="Не так быстро...";
    echo "<div align=right><font color=red><b>Не так быстро...</b></font></div>";
    return false;
  }
  $d = mysql_fetch_array(mq("SELECT sum(`massa`) FROM `inventory` WHERE `owner` = '{$user['id']}' AND `dressed` = 0 AND `setsale` = 0 ; "));
  if($d[0] > get_meshok()) {
    $warning="У вас переполнен рюкзак, вы не можете передвигаться...";
    echo "<font color=red><b>У вас переполнен рюкзак, вы не можете передвигатся...</b></font><br>";
    $_GET['got']=0;
    return false;
  }
  
  $eff = mysql_fetch_array(mq("SELECT * FROM `effects` WHERE `owner` = '".$user['id']."' AND (`type` = 14 OR `type` = 13 OR `type` = 12) ORDER BY type DESC;"));
//if ($user['id'] == 7) {
  if($eff) {
    $spikeCount = mysql_result(mysql_query("SELECT COUNT(*) FROM inventory WHERE (id='$user[weap]' OR id='$user[shit]') AND (prototype = 1905 OR prototype = 1906)"), 0, 0);
    if (!$spikeCount) {
        $warning="У вас ".($eff['type']==12?'средняя':'тяжелая')." травма, вы не можете передвигаться...";
        echo "<font color=red><b>У вас ".($eff['type']==12?'средняя':'тяжелая')." травма, вы не можете передвигаться...</b></font><br>";
        return false;
    } else {
        if ($eff['type'] == 12) {
            if ($spikeCount > 1) {
                $spd *= 2;
            } else {
                $spd *= 4;
            }
        } else {
            if ($spikeCount > 1) {
                $spd *= 4;
            } else {
                $warning="У вас тяжелая травма, вы не можете передвигаться...";
                echo "<font color=red><b>У вас тяжелая травма, вы не можете передвигаться...</b></font><br>";
                return false;
            }
        }
    }
  }
//} else {
//  if($eff) {
//    $r=mq("select prototype from inventory where id='$user[weap]' or id='$user[shit]'");
//    $weaps=array();
//    $spikeCount = 0;
//    while ($rec=mysql_fetch_assoc($r)) {
//      $weaps[$rec["prototype"]]=1;
//    }
//    if (!@$weaps["1905"] && !@$weaps["1906"]) {
//      $warning="У вас ".($eff['type']==12?'средняя':'тяжелая')." травма, вы не можете передвигаться...";
//      echo "<font color=red><b>У вас ".($eff['type']==12?'средняя':'тяжелая')." травма, вы не можете передвигаться...</b></font><br>";
//      return false;
//    } elseif ($_SERVER["REMOTE_ADDR"]!="127.0.0.1") $spd*=5;
//  }
//}
  
  $chain = mysql_fetch_array(mq("SELECT * FROM `effects` WHERE `owner` = '".$user['id']."' AND (`type` = 10);"));
  if($chain) {
    $warning="На Вас наложены путы, вы не можете передвигатся...";
    echo "<font color=red><b>$warning</b></font><br>";
    return false;
  }
  if ($user['zayavka'] > 0) {
    $i=mqfa1("select id from zayavka where id='$user[zayavka]'");
    if ($i) {
      $warning="Вы подали заявку на бой. Вот и ожидайте начала боя...";
      echo "<font color=red><b>Вы подали заявку на бой. Вот и ожидайте начала боя...</b></font>";
      $_GET['got'] =0;
      return false;
    } else {
      mq("update users set zayavka=0 where zayavka='$user[zayavka]'");
    }
  }
  //$_SESSION['perehod']=time()+$spd;
  return $spd;
}

function getudata($u=0, $nolock=0, $res=0) {
  global $user;
  if (!$u) $u=$user["id"];
  if ($res) {
    $f=$res;
  } else $f=fopen(CHATROOT."chardata/$u.dat", "r");
  if (!$nolock) flock($f, LOCK_SH);
  $s=filesize(CHATROOT."chardata/$u.dat");
  if ($s) {
    $data=fread($f, $s);
    $data=unserialize($data);
  } else $data=array();
  if (!$nolock) flock($f, LOCK_UN);
  if (!$res) fclose($f);

  return $data;
}

function updeffects($u=0) {
  global $user;
  if (!$u) {
    $u=$user["id"];
    $user1=$user;
  } else {
    $user1=mqfa("select * from users where id='$u'");
  }
  $f1=fopen(CHATROOT."chardata/$u.dat", "r+");
  flock($f1, LOCK_EX);
  $data=getudata($u, 1, $f1);
  $data["effects"]=array();
  $r=mq("select * from effects where owner='$u'");
  $i=0;
  while ($rec=mysql_fetch_assoc($r)) {
    if ($rec["type"]==28 || $rec["type"]==29) {
      getadditdata($user1);
      if ($rec["type"]==28) $at="hp";
      if ($rec["type"]==29) $at="mana";
      $rec["addict"]=addictval($user1["{$at}addict"]);
    }
    $i++;
    $data["effects"][$i]=$rec;
  }
  //$f=fopen(CHATROOT."chardata/$u.dat", "wb+");
  ftruncate($f1, 0);
  rewind($f1);
  fwrite($f1, serialize($data));
  flock($f1, LOCK_UN);
  fclose($f1);
  if ($u==$user["id"]) $user["data"]=$data;
}

function haseffect($data, $type) {
  if ($type==HPADDICTIONEFFECT || $type==MANAADDICTIONEFFECT) {
    if (incommontower()) return false;
  }
  foreach ($data["effects"] as $k=>$v) if ($v["type"]==$type) return $k; 
  return false;
}


function reportadms($msg) {
  addchp("<font color=\"Black\">private [Capita] private [BoyFromHell] private [Chivas RegaL] $msg</font>", "Комментатор");

}

function addicttype($item) {
  if ($item["type"]==28 || $item["type"]==HPADDICTIONEFFECT || $item["prototype"]==1971) return "hp";
  if ($item["type"]==29 || $item["type"]==MANAADDICTIONEFFECT || $item["prototype"]==1972) return "mana";
  if ($item["gsila"] || $item["sila"]<>0) return "sila";
  if ($item["glovk"] || $item["lovk"]<>0) return "lovk";
  if ($item["ginta"] || $item["inta"]<>0) return "inta";
  if ($item["gintel"] || $item["intel"]<>0) return "intel";
  if ($item["mfdhit"]<>0 && $item["mfdmag"]==0) return "hit";
  if ($item["mfdmag"]<>0 && $item["mfdhit"]==0) return "mag";
  $mfs=array("mfdkol", "mfdrub", "mfdrej", "mfddrob", "mfdfire", "mfdwater", "mfdair", "mfdearth");
  foreach ($mfs as $k=>$v) if ($item[$v]) return substr($v,3);
}

function updeffect($user, $effect, $time, $item, $hasaddict, $name="") {
  if ($hasaddict) {
    $addict=addicttype($item);
    mq("update userdata set {$addict}addict={$addict}addict+".floor(($time-($effect["time"]-time()))/$time*100)." where id='$user'");
  }
  mq("UPDATE `effects` set `time` = '".(time()+$time)."' ".($name?", name='$name'":"")." WHERE id='$effect[id]'");
}

function checkaddict($uid, $item) {
  global $user;
  $addict=addicttype($item);
  if ($addict) {
    if ($uid==$user["id"]) $user1=$user;
    else $user1=array("id"=>$uid);
    getadditdata($user1);
    $val=addictval($user1["{$addict}addict"]);
    if ($val) {      
      if ($addict=="hit" || $addict=="mag" || $addict=="kol" || $addict=="rub" || $addict=="rej" || $addict=="drob" || $addict=="fire" || $addict=="water" || $addict=="air" || $addict=="earth") {
        $mfd=-$item["mfd$addict"]*($val*0.05+1);
        mq("insert into effects (owner, name, time, type, mfd$addict) values ('$uid', 'Пагубное пристрастие [$val]', ".($val*60*60*24+time()).", 32, $mfd)");
        addchp ('<font color=red>Внимание!</font> Вы ощутили отрицательное влияние пристрастия к эликсиру.', '{[]}'.nick7($uid).'{[]}');
      }
      if ($addict=="hp" || $addict=="mana") {
        mq("insert into effects (owner, name, time, type) values ('$uid', 'Пагубное пристрастие [$val]', ".($val*60*60*24+time()).", ".($addict=="hp"?33:34).")");
        addchp ('<font color=red>Внимание!</font> Вы ощутили отрицательное влияние пристрастия к эликсиру.', '{[]}'.nick7($uid).'{[]}');
      }
      if (($addict=="sila" || $addict=="lovk" || $addict=="inta" || $addict=="intel") && $val>=5) {
        mq("insert into effects (owner, name, time, type, $addict) values ('$uid', 'Пагубное пристрастие [$val]', ".($val*60*60*24+time()).", 32, -$val)");
        mq("update users set $addict=$addict-$val where id='$user1[id]'");
        addchp ('<font color=red>Внимание!</font> Вы ощутили отрицательное влияние пристрастия к эликсиру.', '{[]}'.nick7($uid).'{[]}');
      }
    }
  }
}

function addaddict($user, $item) {
  $addict=addicttype($item);
  if ($addict) mq("update userdata set {$addict}addict={$addict}addict+100 where id='$user'");
}

function addictval($a) {
  $l=0;
  $step=300;
  $curr=0;
  while (true) {
    if ($a<$curr+$step) return $l;
    $l++;
    $curr+=$step;
    $step+=40;
    if ($l==25) return $l;
  }
}

function remaddiction ($user, $owntravma) {
  if ($owntravma["type"]==ADDICTIONEFFECT) {
    $at=addicttype($owntravma);
    if ($at=="sila" || $at=="lovk" || $at=="inta" || $at=="intel") {
      mq("update users set sila=sila-$owntravma[sila], lovk=lovk-$owntravma[lovk], inta=inta-$owntravma[inta], intel=intel-$owntravma[intel] where id='$user'");
    }
    mq("update userdata set {$at}addict=0 where id='$user'");
  } elseif ($owntravma["type"]==HPADDICTIONEFFECT) {
    mq("update userdata set hpaddict=0 where id='$user'");
  } elseif ($owntravma["type"]==MANAADDICTIONEFFECT) {
    mq("update userdata set manaaddict=0 where id='$user'");
  }
}

function joinbattle($battleid, $users, $lock=1) {
  if ($lock) mq("lock tables battle write");
  $rec=mqfa("select win, teams, t1, t2 from battle where id='$battleid'");
  if ($rec["win"]!=3) {
    mq("unlock tables");
    return false;
  }
  $usercond="";
  $battle = unserialize($rec['teams']);
  foreach ($users as $k=>$v) {
    $team=explode(";",$rec["t$v[team]"]);
    foreach ($battle as $k2=>$v2) {
      if (in_array($k2, $team)) break;
    }
    $battle[$v['id']]=$battle[$k2];
    foreach($battle[$v["id"]] as $k2 => $v2) {
        $battle[$v['id']][$k2] =array(0,0,time());
        $battle[$k2][$v['id']] = array(0,0,time());
    }
    $rec["t$v[team]"].=";$v[id]";
    if ($v["id"]<_BOTSEPARATOR_) {                                                               
      addlog($battleid, "<span class=date>".date("H:i")."</span> ".nick5($v['id'],"B$v[team]")." вмешался в поединок!<BR>");
      if ($usercond) $usercond.=" or ";
      $usercond.=" id='$v[id]' ";
    } else {                                          
      addlog($battleid, "<span class=date>".date("H:i")."</span> <span class=\"B$v[team]\">$v[login]</span> вмешался в поединок!<BR>");
    }
  }
  mq("update battle set t1='$rec[t1]', t2='$rec[t2]',  teams='".serialize($battle)."' where id='$battleid'");
  if ($lock) mq("unlock tables");
  if ($usercond) mq("update users set battle='$battleid' where $usercond");
  return true;
}

function createbot($bot, $battle, $login="") {
  $rec=mqfa("select login, maxhp from users where id='$bot'");
  if ($login) $rec["login"]=$login;
  if ($battle) {
    $r=mq("select name from bots where battle='$battle' and name like '$rec[login]%'");
    $bots=array();
    while ($rec1=mysql_fetch_assoc($r)) $bots[$rec1["name"]]=1;
    if (!$bots[$rec["login"]]) {
      $botname=$rec["login"];
    } else {
      $i=1;
      while ($i<1000) {
        if (!$bots["$rec[login] ($i)"]) {
          $botname="$rec[login] ($i)";
          break;
        }
        $i++;
      }
    }
  } else $botname=$rec["login"];
  mq("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('$botname','$bot','$battle','$rec[maxhp]');");
  return array("id"=>mysql_insert_id(), "login"=>$botname);
}

function moveline($links, $tme="qqq") {
  if ($tme=="qqq") $tme=$_SESSION["movetime"]-time();
  $ret="<div style=\"display:none; height:0px\" id=\"moveto\">0</div>
  <TABLE height=16 border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <TR>
  <TD rowspan=3 valign=\"top\"><a href=\"?rnd=".rand()."\"><img src=\"".IMGBASE."/i/move/rel_1.gif\" width=\"15\" height=\"16\" alt=\"Обновить\" border=\"0\" /></a></TD>
  <TD colspan=\"3\"><img src=\"".IMGBASE."/i/move/navigatin_462s.gif\" width=\"80\" height=\"3\" /></TD>
  </TR>
  <TR>
  <TD><IMG src=\"".IMGBASE."/i/move/navigatin_481.gif\" width=\"9\" height=\"8\"></TD>
  <TD width=64 bgcolor=black><DIV class=\"MoveLine\" style=\"width:64px;overflow:hidden\"><img style=\"position:relative;\" src=\"".IMGBASE."/i/move/wait2.gif\" id=\"MoveLine\" width=\"64\" height=\"6\" class=\"MoveLine\"></DIV></TD>
  <TD><IMG src=\"".IMGBASE."/i/move/navigatin_50.gif\" width=\"7\" height=\"8\"></TD>
  </TR>
  <TR>
  <TD colspan=\"3\"><IMG src=\"".IMGBASE."/i/move/navigatin_tt1_532.gif\" width=\"80\" height=\"5\"></TD>
  </TR>
  </TABLE>
  </div>
  <div id=\"mmoves\" style=\"background-color:#FFFFCC; visibility:hidden; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px; white-space: nowrap;\"></div>
  <table border=0 cellSpacing=1 cellPadding=0 width=\"100%\" bgColor=#dedede id=\"bmoveto\">";
  foreach ($links as $k=>$v) {  
    $ret.="<tr>
    <td bgcolor=#d3d3d3><img src=\"/i/move/links.gif\" width=9 height=7></TD>
    <td bgcolor=#d3d3d3 nowrap><small><A class=menutop title=\"Время перехода: 10 сек.&#10;Сейчас в комнате  чел.\" onclick=\"solo('$v', '$k');return false;\" href=\"#\">$k</A>
    </small></td></tr>";
  }
  $ret.="</table>";
$ret.="<script language=\"javascript\" type=\"text/javascript\">
var progressEnd = 64;       // set to number of progress <span>'s.
var progressColor = '#00CC00';  // set to progress bar color
var mtime = parseInt('$tme');
if (!mtime || mtime<=0) {mtime=0;}
var progressInterval = Math.round(mtime*1000/progressEnd);  // set to time between updates (milli-seconds)
var is_accessible = true;
var progressAt = progressEnd;
var progressTimer;
function progress_clear() {
progressAt = 1;
is_accessible = false;
set_moveto(true);
}
function progress_update() {
progressAt++;
//if (progressAt > progressEnd) progress_clear();
if (progressAt > progressEnd) {
is_accessible = true;
if (window.solo_store && solo_store) { solo(solo_store, \"\"); } // go to stored
set_moveto(false);
} else {
if( !( progressAt % 2 ) )
document.getElementById('MoveLine').style.left = (progressAt - 64)+'px';
progressTimer = setTimeout('progress_update()',progressInterval);
}
}
function set_moveto (val) {
document.getElementById('moveto').disabled = val;
if (document.getElementById('bmoveto')) {
document.getElementById('bmoveto').disabled = val;
}
}
function progress_stop() {
clearTimeout(progressTimer);
progress_clear();
}
function check(it) {
return is_accessible;
}
function check_access () {
return is_accessible;
}
function ch_counter_color (color) {          
  if (color=='red') document.getElementById('MoveLine').src='".IMGBASE."/i/move/wait2red.gif';
  else document.getElementById('MoveLine').src='".IMGBASE."/i/move/wait2.gif';
}
if (mtime>0) {
progress_clear();
progress_update();
}

var solo_store;
function solo(n, name) {
if (check_access()==true) {
window.location.href = n;
} else if (name && n) {
  solo_store = n;
  document.getElementById('goto').innerHTML='Вы перейдете в: <strong>' + name +'</strong> (<a href=\"#\" onclick=\"return clear_solo();\">отмена</a>)';
  ch_counter_color('red');
}
return false;
}
function clear_solo () {
  document.getElementById('goto').innerHTML='';
  solo_store = false;
  ch_counter_color('#00CC00');
  return false;
}
</script>";
  return $ret;
}

function cutgrass($quest) {
  global $user, $questtime;
  include_once("questfuncs.php");
  $inhands=mqfa("select prototype, minu from inventory where id='$user[weap]'");
  $sickles[1768]=array("grass"=>1);
  $sickles[2221]=array("grass"=>2, "chance"=>10);
  $sickles[2222]=array("grass"=>3, "chance"=>20);
  $sickles[100006]=array("grass"=>2, "chance"=>25);
  $sickles[100007]=array("grass"=>3, "chance"=>30);
  if ($inhands["prototype"]!=1768 && $inhands["prototype"]!=2221 && $inhands["prototype"]!=2222 && $inhands["prototype"]!=100006 && $inhands["prototype"]!=100007) {
    return "Для срезания травы вам необходим серп!";
  } elseif ($user["shit"]) {
    return "Для срезания травы вам необходимо освободить левую руку!";
  } elseif (canmakequest($quest)) {
    getadditdata($user);
    $taken=array();
    $i=0;
    while ($i<$sickles[$inhands["prototype"]]["grass"]) {
      if ($i==0 || getchance($sickles[$inhands["prototype"]]["chance"])) {
        //if (mt_rand(1, 100) <= 5) {
          //$rnd=rand(69, 72);  
        //} else {
          $rnd=rand(24,26+$user["alchemylevel"]);
        //}
        if ($quest==6) $taken[]=takesmallitem($rnd, 0, "Нашёл в замке");
        else $taken[]=takesmallitem($rnd, 0, "Нашёл в поле");
      }
      $i++;
    }
    $r=rand(0,10);
    if ($r==5) mq("update inventory set duration=duration+1 where id='$user[weap]'");
    $ret="После долгих поисков Вы обнаружили ";
    $i=0;
    $imgs="";
    foreach ($taken as $k=>$v) {
      $i++;
      if ($i>1) {
        $ret.=", ";
        $imgs.=" ";
      }
      $ret.=$v["name"];
      $imgs.="<img src=\"".IMGBASE."/i/sh/$v[img]\">";
    }
    $ret.=".<br><br>
    <center>$imgs</center><br>";
    if (!getchance($inhands["minu"]-1)) {
      makequest($quest);
      $ret.="Чтобы продолжить поиски трав вам необходим отдых как минимум час.";
    } else {
      $ret.="<font color=green><b>Работа прошла без особых усилий, и вы можете продолжать поиски.</b></font>";
    }
    return $ret;
  } else {
    return "Вы ещё недостаточно отдохнули после предыдущего поиска трав.
    Отдохните ещё минимум ".ceil($questtime/60)." мин.";
  }
}

function statsback($user, $room=0) {
  global $dressslots;
  $rec1=basestats($user);
  $nu=mqfa1("select nextup from users where id='$user'");
  mq("update inventory set dressed=0 where owner='$user'");
  mq("update users set in_tower=0, sila='$rec1[sila]', lovk='$rec1[lovk]', inta='$rec1[inta]', vinos='$rec1[vinos]', intel='$rec1[intel]', mudra='$rec1[mudra]', spirit='$rec1[spirit]', stats='$rec1[stats]', hp='$rec1[maxhp]', maxhp='$rec1[maxhp]', mana='$rec1[maxmana]', maxmana='$rec1[maxmana]', level='".levelatnextup($nu)."',
  mec='$rec1[mec]', topor='$rec1[topor]', dubina='$rec1[dubina]', noj='$rec1[noj]', posoh='$rec1[posoh]', 
  mfire='$rec1[mfire]', mwater='$rec1[mwater]', mair='$rec1[mair]', mearth='$rec1[mearth]', 
  mlight='$rec1[mlight]', mgray='$rec1[mgray]', mdark='$rec1[mdark]', master='$rec1[master]',
  align='$rec1[align]', ".($room?"room='$room',":"")."
  ".implode("=0, ", $dressslots)."=0 where id='$user'");
}

function levelatnextup($exp) {
  global $exptable;
  $ret=0;
  foreach ($exptable as $k=>$v) {
    if ($v[5]>$exp) return $ret;
    if ($v[4]) $ret++;
  }
  return $ret;
}

function fixstats($usr, $output=0) {
  $usr=(int)$usr;
  mq("lock tables users write, userdata write, inventory write, effects write, obshagaeffects write, errorstats write");
  $user=mqfa("select sila, lovk, inta, intel, mudra, spirit, vinos, in_tower, noj, topor, dubina, mec, posoh, luk, mfire, mwater, mair, mearth, mlight, mgray, mdark from users where id='$usr'");
  if (!$user["in_tower"]) {
    $udata=mqfa("select sila, lovk, inta, intel, mudra, spirit, vinos, noj, topor, dubina, mec, posoh, luk, mfire, mwater, mair, mearth, mlight, mgray, mdark from userdata where id='$usr'");
    if ($output) echo "Base: $user[intel]/$udata[intel]<br>";
    $dressed=mqfa("select sum(gsila) as sila, sum(glovk) as lovk, sum(ginta) as inta, sum(gintel) as intel,
    sum(gnoj) as noj, sum(gmech) as mec, sum(gtopor) as topor, sum(gdubina) as dubina, sum(gluk) as luk, sum(gposoh) as posoh,
    sum(gfire) as mfire, sum(gwater) as mwater, sum(gair) as mair, sum(gearth) as mearth,
    sum(glight) as mlight, sum(ggray) as mgray, sum(gdark) as mdark
     from inventory where owner='$usr' and dressed=1");
    foreach ($dressed as $k=>$v) $user[$k]-=$v;
    if ($output) echo "Dressed: $user[intel]/$udata[intel]<br>";
    $dressed=mqfa("select sum(sila) as sila, sum(lovk) as lovk, sum(inta) as inta, sum(intel) as intel, sum(mudra) as mudra from effects where owner='$usr' and type<>11 and type<>12 and type<>13 and type<>14");
    foreach ($dressed as $k=>$v) $user[$k]-=$v;
    if ($output) echo "Effects: $user[intel]/$udata[intel]<br>";
    $dressed=mqfa("select sum(sila) as sila, sum(lovk) as lovk, sum(inta) as inta, sum(intel) as intel, sum(mudra) as mudra from effects where owner='$usr' and (type=11 or type=12 or type=13 or type=14)");
    foreach ($dressed as $k=>$v) $user[$k]+=$v;
    if ($output) echo "Injuries: $user[intel]/$udata[intel]<br>";
    $dressed=mqfa("select sum(sila) as sila, sum(lovk) as lovk, sum(inta) as inta, sum(intel) as intel, sum(mudra) as mudra from obshagaeffects where owner='$usr' and type<>11 and type<>12 and type<>13 and type<>14");
    foreach ($dressed as $k=>$v) $user[$k]-=$v;
    if ($output) echo "$user[intel]/$udata[intel]<br>";
    $dressed=mqfa("select sum(sila) as sila, sum(lovk) as lovk, sum(inta) as inta, sum(intel) as intel, sum(mudra) as mudra from obshagaeffects where owner='$usr' and (type=11 or type=12 or type=13 or type=14)");
    foreach ($dressed as $k=>$v) $user[$k]+=$v;
    if ($output) echo "$user[intel]/$udata[intel]<br>";
    $sql="update users set sila=sila+".($udata["sila"]-$user["sila"]).", lovk=lovk+".($udata["lovk"]-$user["lovk"]).", inta=inta+".($udata["inta"]-$user["inta"]).", intel=intel+".($udata["intel"]-$user["intel"]).", mudra=mudra+".($udata["mudra"]-$user["mudra"]).", spirit=spirit+".($udata["spirit"]-$user["spirit"]).", 
    noj=noj+".($udata["noj"]-$user["noj"]).", mec=mec+".($udata["mec"]-$user["mec"]).", topor=topor+".($udata["topor"]-$user["topor"]).",
    dubina=dubina+".($udata["dubina"]-$user["dubina"]).", posoh=posoh+".($udata["posoh"]-$user["posoh"]).", 
    luk=luk+".($udata["luk"]-$user["luk"]).", mfire=mfire+".($udata["mfire"]-$user["mfire"]).", 
    mwater=mwater+".($udata["mwater"]-$user["mwater"]).", mair=mair+".($udata["mair"]-$user["mair"]).", 
    mearth=mearth+".($udata["mearth"]-$user["mearth"]).", mlight=mlight+".($udata["mlight"]-$user["mlight"]).", 
    mgray=mgray+".($udata["mgray"]-$user["mgray"]).", mdark=mdark+".($udata["mdark"]-$user["mdark"])."
    where id='$usr'";
    if ($output) echo $sql;
    mq($sql);
    mq("delete from errorstats where user='$usr'");
  } elseif ($output)  echo "<b>User in tower!</b><br>";
  mq("unlock tables");
}

function fastshow($str) {
  return "onmouseout=\"hideshow();\" onmouseover=\"fastshow2('$str', this, event)\"";
}

function placeinbackpack($qty, $userid=0) {
  global $user;
  if (!$userid) $userid=$user["id"];
  if ($userid==$user["id"]) $user1=$user;
  else $user1=mqfa("select id, in_tower, level, features from users where id='$user1[id]'");
  $cnt=mqfa1("select count(id) from inventory where owner='$user1[id]' and bs='$user1[in_tower]' and dressed=0 and `setsale`=0");
  return $cnt+$qty<=backpacksize($user1);
}

function regenhp(&$us, $update=1) {
  if ($us["hp"]<$us["maxhp"] && time()>$us["fullhptime"] && $us["in_tower"]<>62) {
    $fulltime=timetoheal($us);
    $delta=ceil((time()-$us["fullhptime"])/$fulltime*$us["maxhp"]);
    if ($delta>0) {
      $us["hp"]=min($us["hp"]+$delta, $us["maxhp"]);
      if ($update) mq("update users set hp=if(hp+$delta>maxhp,maxhp,hp+$delta), fullhptime=".time()." where id='$us[id]'");
      if ($us["id"]==$user["id"]) $user["hp"]=$us["hp"];
    }
  }
  return $us["hp"];
}

function basestats($user) {
  $rec1=mqfa("select * from userdata where id='$user'");
  $hp=30;
  $mana=$rec1["mudra"]*10;
  if ($rec1["mudra"]>=100) $mana+=250;
  elseif ($rec1["mudra"]>=75) $mana+=175;
  elseif ($rec1["mudra"]>=50) $mana+=100;
  elseif ($rec1["mudra"]>=25) $mana+=50;

  $hfv=6;
  $r=mq("select sila, lovk, inta, vinos, hpforvinos, intel, mudra, type, ghp from effects where owner='$user'");
  while ($rec=mysql_fetch_assoc($r)) {
    if ($rec["type"]==11 || $rec["type"]==12 || $rec["type"]==13 || $rec["type"]==14) {
      $rec1["sila"]-=$rec["sila"];
      $rec1["lovk"]-=$rec["lovk"];
      $rec1["inta"]-=$rec["inta"];
      $rec1["vinos"]-=$rec["vinos"];
      $rec1["intel"]-=$rec["intel"];
      $rec1["mudra"]-=$rec["mudra"];
    } else {
      $rec1["sila"]+=$rec["sila"];
      $rec1["lovk"]+=$rec["lovk"];
      $rec1["inta"]+=$rec["inta"];
      $rec1["vinos"]+=$rec["vinos"];
      $rec1["intel"]+=$rec["intel"];
      $rec1["mudra"]+=$rec["mudra"];
    }
    $hp+=$rec["ghp"];
    $hfv+=$rec["hpforvinos"];
  }
  $hp+=$rec1["vinos"]*$hfv;
  if ($rec1["vinos"]>=100) $hp+=250;
  elseif ($rec1["vinos"]>=75) $hp+=175;
  elseif ($rec1["vinos"]>=50) $hp+=100;
  elseif ($rec1["vinos"]>=25) $hp+=50;
  $rec1["maxhp"]=$hp;
  $rec1["maxmana"]=$mana;
  return $rec1;
}

function drawbattle($b) {
  mq("UPDATE users SET `battle` =0,`fullhptime` = ".time().",`fullmptime` = ".time().",`udar` = '0', hit=0, krit=0, parry=0, counter=0, hp2=0 WHERE `battle` = $b");
  mq("update battle set win=0 where id='$b'");
  $fp = fopen ("backup/logs/battle$b.txt","a"); //открытие
  flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
  fputs($fp , '<hr><span class=date>'.date("H:i").'</span> Бой закончен. Ничья.<BR>'); //работа с файлом
  fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
  flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
  fclose ($fp); //закрытие
}

function manausage($priem) {
  global $strokes, $user;
  if (@$strokes[$priem]->manabylevel) return $strokes[$priem]->manabylevel[$user["level"]];
  return $strokes[$priem]->mana;
}

function remdressed($u) {
  global $userslots;
  foreach ($userslots as $k=>$v) {
    if ($sql) $sql.=", ";
    $sql.="$v=0";
  }
  mq("update users set $sql where id=$u");
}

function outoffield($i, $room=0) {
    global $user;
  global $charstamfields;  
  if (!$room) $room=mqfa1("select room from users where id='$i'");
  mq("update users set room=room-1, in_tower=0 where id='$i' and in_tower>0");
  if (in_array($room, $charstamfields)) {
    remdressed($i);
    mq("UPDATE `effects` SET `owner` =$i WHERE `owner` = '".($i+_BOTSEPARATOR_)."'");
    statsback($i);
    if ($room==72) {
      $xy=mqfa("select x, y from fieldparties where user='$i' order by id desc");
      $cond="";
      $r=mq("select id, name from inventory where owner=$i and bs=$room-1");
      while ($rec=mysql_fetch_assoc($r)) {
        if ($cond) $cond.=" or ";
        $cond.=" item='$rec[id]' ";
        //mq("insert into pbsitemslog SET user = '$user[login]', item = '$rec[id]', text = 'Выбросил - $rec[name]'");
      }
      if ($cond) mq("update fielditems set x='".($xy["x"]*2)."', y='".($xy["y"]*2)."' where $cond");
      mq("update inventory set owner=0, dressed=0 where owner=$i and bs=$room-1");
    }
  }
  $ud=mqfa("select id, team, field from fieldparties where user='$i' order by id desc");
  mq("delete from fieldparties where id='$ud[id]'");
  if ($ud["team"]) mq("update fields set team$ud[team]=replace(team$ud[team],'-$i-','-') where id='$ud[field]'");
}

function incommontower($u=0) {
  global $user;
  if ($u) return $u["in_tower"] && $u["in_tower"]!=2 && $u["in_tower"]!=62;
  else return $user["in_tower"] && $user["in_tower"]!=2 && $user["in_tower"]!=62;
}

function inbattletower($user) {
   return $user["in_tower"]==62;
}

function canregendead($user) {
  if (incastle($user["room"])) return false;
  if ($user["in_tower"]==1 || $user["in_tower"]==2 || $user["in_tower"]==62 || $user["in_tower"]==71) return false;
  return true;
}

function questbothp() {
  global $user;
  if ($user["level"]<=7) return 1500;
  if ($user["level"]==8) return 2500;
  if ($user["level"]==9) return 3500;
  if ($user["level"]==10) return 4500;
  if ($user["level"]==11) return 5000;
  if ($user["level"]==12) return 6000;
}

function itemprice($rec) {
  $essences=array("Эссенция силы", "Эссенция ветра", "Эссенция гор", "Эссенция океана", "Эссенция пламени");
  $grasses=array("Корень нирина", "Листья примулы", "Цветок алканы", "Стебель аралии", "Ветка страстоцвета", "Листья гардении", "Ягоды азафоэтиды", "Цветок вербены", "Лист галангала", "Ягоды ветиверии", "Стебель портулака", "Лист эриодикта", "Ягоды хриностата");
  if ($rec["name"]=="Страница книги алхимии") {
    $minprice=3*$rec["koll"];
    $maxprice=60*$rec["koll"];
    $price=40*$rec["koll"];
  } elseif (strpos($rec["name"], "Самодельный эликсир")===0) {
    $minprice=1;
    if ($rec["nlevel"]<=1) $maxprice=1;
    elseif ($rec["nlevel"]==2) $maxprice=2;
    elseif ($rec["nlevel"]==3) $maxprice=5;
    elseif ($rec["nlevel"]==4) $maxprice=10;
    elseif ($rec["nlevel"]==5) $maxprice=40;
    elseif ($rec["nlevel"]==6) $maxprice=70;
    elseif ($rec["nlevel"]==7) $maxprice=150;
    elseif ($rec["nlevel"]>=8) $maxprice=300;
    $price=1;
    if ($rec["name"]=="Самодельный эликсир") $maxprice=300;
  } elseif (in_array($rec["name"], $essences)) {
    //$minprice=5*$rec["koll"];
    $minprice=1;
    $maxprice=20*$rec["koll"];
    $price=10*$rec["koll"];
  } elseif (in_array($rec["name"], $grasses)) {
    $minprice=1;
    $maxprice=6;
  } elseif ($rec['type'] == 60) {
    $minprice=1;
    $maxprice=5;
  } elseif ($rec["podzem"]==SELLABLEDROP) {
    $minprice=1;
    $maxprice=$rec["cost"]*2;
  } else {
    $minprice=max($rec["ecost"]*10*SELLCOEF, $rec["cost"]*SELLCOEF);
    $maxprice=max($rec["ecost"]*22,$rec["cost"]*1.1);
    if (strpos($rec["name"], "(мф)")) $maxprice*=1.5;
    $price=max($rec["ecost"]*11,$rec["cost"]);
  }
  if ($rec["gift"]==1) $price=0;
  if (strpos($rec["name"],"Букет")!==false) $price=0;
  return array("minprice"=>$minprice, "maxprice"=>$maxprice, "price"=>$price);
}

function cangive($sum) {
  global $user;
  if ($user["in_tower"]==1) return true;
  getadditdata($user);
  $money=statsat($user["nextup"]);
  $money["money"] = $money["money"] * 3;
  if ($user["level"]<=5) $q=0.2;
  elseif ($user["level"]==6) $q=0.21;
  elseif ($user["level"]==7) $q=0.22;
  elseif ($user["level"]==8) $q=0.23;
  elseif ($user["level"]==9) $q=0.24;
  else $q=0.25;
  if ($user["balance"]-$sum<-($money["money"]*$q)) return false;
  return true;
}

function updbalance($from, $to, $sum) {
  if (!$sum) return;
  mq("update userdata set balance=balance-$sum where id='$from'");
  mq("update userdata set balance=balance+$sum where id='$to'");
}

function clannick3($id) {
  global $members;
  if (!$members[$id]) return nick3($id);
  else return fullnick($members[$id]);
}                                       

function rembadsymbols($s) {
  $s=stripslashes($s);
  $s=str_replace("\\","/",$s);
  $s=addslashesa($s);
  return $s;
}

function checkitemchange($item=0) {
  global $user;
  if (!$user["in_tower"]) {
    if ($user["level"]<6 && ($item["prototype"]==6 || !$item)) {
      $i=mqfa1("select id from inventory where owner='$user[id]' and prototype=6");
      if ($i && !$user["tol6"]) {
        mq("update users set tol6=1 where id='$user[id]'");
        $user["tol6"]=1;
      } elseif (!$i && $user["tol6"]) {
        mq("update users set tol6=0 where id='$user[id]'");
        $user["tol6"]=0;
      }
    }
  }
}

function getweight($user) {
  return mqfa("SELECT sum(massa) as weight, count(id) as cnt from inventory WHERE owner=$user[id] and dressed=0 and setsale=0 ".(incommontower($user)?" and bs=$user[in_tower]":""));
}

function forlevelup($user) {
  if ($user["nextup"]==1250000000 && $user["exp"]>=$user["nextup"]) return "<small><font color=red>Для достижения 6-го уровня вам необходим кристалл знаний.</font></small><br>";
}

function logdate() {return "<span class=date>".date("H:i")."</span>";}

function addfieldlog($field, $str, $nodate=0) {mq("update fieldlogs set log=concat(log, '".($nodate?"":logdate())." $str') where id='$field'");}

function topsethp() {
  global $user;
  if ($user["hp"]>=$user["maxhp"] || $user["battle"]) return "top.setHP($user[hp], $user[maxhp], 0)";
  /*if (haseffect($user["data"], 28)!==false) {
    $fulltime=300;
  } elseif (haseffect($user["data"], HPADDICTIONEFFECT)!==false) {
    getadditdata($user);
    $fulltime=30*addictval($user["hpaddict"])+600;
  } else $fulltime=600;
  getfeatures($user);
  if ($user["sturdy"]==5) $fulltime=$fulltime/1.3;
  else $fulltime=$fulltime/($user["sturdy"]*0.05+1);*/
  $fulltime=timetoheal($user);
  $delay=round(1/($user["maxhp"]/$fulltime)*1000);  
  return "top.setHP($user[hp], $user[maxhp], $delay);";
}

function timetoheal(&$user) {
  getfeatures($user);
  if (haseffect($user["data"], 28)!==false) {
    $fulltime=300-(addictval($user["hpaddict"])*3);
  } elseif (haseffect($user["data"], HPADDICTIONEFFECT)!==false) {
    $fulltime=30*addictval($user["hpaddict"])+600;
  } else $fulltime=600;
  if ($user["sturdy"]==5) $fulltime=$fulltime/1.3;
  elseif ($user["sturdy"]>0) $fulltime=$fulltime/($user["sturdy"]*0.05+1);
  
  /*$eff = mqfaa("SELECT hprestore FROM effects WHERE hprestore != 0 AND owner = " . $user['id']);
  if ($eff) {
    $sum = 0;
    foreach ($eff as $v) {
        $sum += $v['hprestore'];
    }
    $fulltime = $fulltime - (($fulltime * $sum) / 100);
    if (!$fulltime) {
      $fulltime = 1;
    }
  }*/
  return $fulltime;
}

function mfname($mf) {
  static $mfnames;
  if (!@$mfnames) $mfnames=array("mfuvorot"=>"Мф. увёртывания", "mfauvorot"=>"Мф. против увёртывания", "mfkrit"=>"Мф. крит. удара", "mfakrit"=>"Мф. против крит. удара", "mfparir" =>"Мф. парирования", "mfcontr"=>"Мф. контрудара", "mfdhit"=>"Защита от урона", "mfdkol"=>"Защита от колющего урона", "mfdrub"=>"Защита от рубящего урона", "mfdrej"=>"Защита от режущего урона", "mfddrob"=>"Защита от дробящего урона", "mfdmag"=>"Защита от магии", "mfdfire"=>"Защита от магии огня", "mfdwater"=>"Защита от магии воды", "mfdair"=>"Защита от магии воздуха", "mfdearth"=>"Защита от магии земли", "mfdlight"=>"Защита от магии света", "mfddark"=>"Защита от магии тьмы", "mfdgray"=>"Защита от серой магии", "manausage"=>"Уменьшение расхода маны", "mfmagp"=>"Мф. мощности магии", "mfhitp"=>"Мф. мощности урона", "mffire"=>"Мф. мощности магии огня", "mfwater"=>"Мф. мощности магии воды", "mfair"=>"Мф. мощности магии воздуха", "mfearth"=>"Мф. мощности магии земли", "mfdark"=>"Мф. мощности магии тьмы", "mflight"=>"Мф. мощности магии света", "mfgray"=>"Мф. мощности серой магии", "minusmfdmag"=>"Подавление защиты от маги", "minu"=>"Минимальное наносимое повреждение", "maxu"=>"Максимальное наносимое повреждение");
  return $mfnames[$mf];
}

function effectdata($effect) {
  global $user;
  static $effectimgs;
  if (!@$effectimgs) $effectimgs=array(
    "Зелье Прозрения"=>"pot_base_50_inst.gif",
    "Самодельный эликсир"=>"elixir.gif",
    "Самодельный эликсир [0]"=>"elixir.gif",
    "Самодельный эликсир [1]"=>"elixir.gif",
    "Самодельный эликсир [2]"=>"elixir.gif",
    "Самодельный эликсир [3]"=>"elixir.gif",
    "Самодельный эликсир [4]"=>"elixir.gif",
    "Самодельный эликсир [5]"=>"elixir.gif",
    "Самодельный эликсир [6]"=>"elixir.gif",
    "Самодельный эликсир [7]"=>"elixir.gif",
    "Самодельный эликсир [8]"=>"elixir.gif",
    "Самодельный эликсир [9]"=>"elixir.gif",
    "Самодельный эликсир [10]"=>"elixir.gif",
    "Зелье Могущества"=>"pot_base_50_str.gif",
    "Эликсир Неуязвимости"=>"pot_base_50_damageproof.gif",
    "Эликсир Стихий"=>"pot_base_50_magicproof.gif",
    "Водное Усилениие"=>"spell_powerup2.gif",
    "Зелье Разума"=>"pot_base_50_intel.gif",
    "Нектар Неуязвимости"=>"pot_base_200_alldmg3.gif",
    "Огненное Усилениие"=>"spell_powerup1.gif",
    "Холодный разум"=>"spell_stat_intel.gif",
    "Нектар Отрицания"=>"pot_base_200_allmag3.gif",
    "Зелье Стремительности"=>"pot_base_50_dex.gif",
    "Зелье Тяжелых Молотов"=>"pot_base_50_drobproof.gif",
    "Зелье Хозяина Канализации"=>"pot_base_0_ny1.gif",
    "Эликсир Ветра"=>"pot_base_50_airproof.gif",
    "Зелье Пронзающих Игл"=>"pot_base_50_kolproof.gif",
    "Зелье Сверкающих Лезвий"=>"pot_base_50_rezproof.gif",
    "Земное Усилениие"=>"spell_powerup4.gif",
    "Зелье Свистящих Секир"=>"pot_base_50_rubproof.gif",
    "Великое зелье Стойкости"=>"pot_base_200_alldmg2.gif",
    "Защита от Огня"=>"spell_protect1.gif",
    "Эликсир Пламени"=>"pot_base_50_fireproof.gif",
    "Эликсир Песков"=>"pot_base_50_earthproof.gif",
    "Предвидение"=>"spell_godstat_int.gif",
    "Эликсир Морей"=>"pot_base_50_waterproof.gif",
    "Эликсир Морей"=>"pot_base_50_waterproof.gif",
    "Сила Великана"=>"spell_godstat_str.gif",
    "Воздушное Усилениие"=>"spell_powerup3.gif",
    "Неуязвимость Стихиям"=>"spell_godprotect.gif",
    "Снадобье Забытых Мастеров"=>"pot_base_100_master.gif",
    "Заклятие невидимости"=>"hidden.gif",
    "Неуязвимость Оружию"=>"spell_godprotect10.gif",
    "Защита от Земли"=>"spell_protect4.gif",
    "Великое зелье Отрицания"=>"pot_base_200_allmag2.gif",
    "Скорость Змеи"=>"spell_godstat_dex.gif",
    "Уязвимость стихиям"=>"spell_unprotect.gif",
    "Слабость"=>"spell_undamage10.gif",
    "Мудрость Веков"=>"spell_godstat_wis.gif",
    "Ледяной интеллект"=>"spell_godstat_intel.gif",
    "Защита от Воздуха"=>"spell_protect3.gif",
    "Уязвимость оружию"=>"spell_unprotect10.gif",
    "Превосходство"=>"booklearn_2.gif",
    "Защита от Воды"=>"spell_protect2.gif",
    "Победитель Башни Смерти"=>"icon_prize396.gif",
    "Кристаллизация"=>"booklearn_spell15.gif",
    "Заземление: минус"=>"booklearn_spell35.gif",
    "Каменный щит"=>"booklearn_spell37.gif",
    "Жажда крови"=>"booklearn_8.gif",
    "Усиленные удары"=>"booklearn_7.gif",
    "Рыцарское Знание (том 1)"=>"booklearn_slot.gif",
    "Оледенение: разбить"=>"booklearn_spell19.gif",
    "Ледяное спасение"=>"booklearn_spell20.gif",
    "Глаз за глаз"=>"booklearn_spell3.gif",
    "Каменный удар"=>"booklearn_spell7.gif",
    "Закалка"=>"temper.gif",
    "Окорочок"=>"food.jpg",
    "Хлеб с мясом"=>"food.jpg",
    "Собрать снег"=>"makesnowball.gif",
    "Жажда жизни +1"=>"lt1.gif",
    "Жажда жизни +2"=>"lt2.gif",
    "Жажда жизни +3"=>"lt3.gif",
    "Жажда жизни +4"=>"lt4.gif",
    "Жажда жизни +5"=>"lt5.gif",
    "Жажда жизни +6"=>"lt6.gif",
    "Иссушение -1"=>"mlt1.gif",
    "Иссушение -2"=>"mlt2.gif",
    "Иссушение -3"=>"mlt3.gif",
    "Иссушение -4"=>"mlt4.gif",
    "Иссушение -5"=>"mlt5.gif",
    "Хлеб с мясом"=>"food.jpg",
    "Бутерброд с мясом"=>"food.jpg",
    "Окорочок"=>"food.jpg",
    "Бутерброд -Завтрак рыцаря-"=>"food.jpg",
    "Эликсир восстановления"=>"regeneration.gif",
    "Эликсир потока"=>"manaregen.gif",
    "Закалка"=>"temper.gif",
    "Кредит"=>"credit.gif",
    "Просроченный кредит"=>"unpaidcredit.gif",
    "Победитель общего побоища"=>"winner.gif",
    "Мягкая поступь (5)"=>"lightsteps5.gif",
    "Мягкая поступь (15)"=>"lightsteps15.gif",
    "Мягкая поступь (30)"=>"lightsteps30.gif",
    "Защита от травм"=>"travmaresist.gif",
    "Защита Мироздателя"=>"protection.gif",
    "Заземление: плюс"=>"booklearn_spell34.gif",
    "Ледяное сердце"=>"booklearn_spell22.gif",
    "Хлебнуть крови"=>"booklearn_1.gif",
    "Воздушный Щит"=>"booklearn_spell27.gif",
    "Тайное Знание (том 1)"=>"booklearn_slot.gif",
    "Жертва воздуху"=>"booklearn_spell28.gif",
    "Серое мастерство"=>"booklearn_spell5.gif",
    "Жертва земле"=>"booklearn_spell32.gif",
    "Энергия воздуха"=>"booklearn_spell30.gif",
    "Язык пламени"=>"booklearn_spell14.gif",
  );
  $mfs="";
  if ($effect["type"]==30) {
    $ret.=$img="pregnant.gif";
    $type="эффект";
  } elseif ($effect["type"]==11 || $effect["type"]==12 || $effect["type"]==13 || $effect["type"]==14) {
    if ($effect["type"]==11) {
        $img="eff_travma1.gif";
        $type="легкая травма";
    } elseif ($effect["type"]==12) {        
        $img="eff_travma2.gif";
        $type="средняя травма";
    } elseif ($effect["type"]==13) {
        $img="eff_travma3.gif";
        $type="тяжелая травма";
    } else {
        $img="eff_travma3.gif";
        $type="неизлечимая травма";
    }
    if ($effect["sila"]) $mfs.="Сила: -$effect[sila]<br>";
    if ($effect["lovk"]) $mfs.="Ловкость: -$effect[lovk]<br>";
    if ($effect["inta"]) $mfs.="Интуиция: -$effect[inta]<br>";
    if ($effect["intel"]) $mfs.="Интеллект: -$effect[intel]<br>";
  } elseif ($effect["type"]>395 && $effect["type"]<1000) {
    $img="prize$effect[type].gif";
  } elseif ($effect['type']==9999) { // болезнь
      $img="standart_disease.gif";
      $type="болезнь";
  } elseif ($effect['type']==9994) { // яд
      //$img="altarcurse.gif";
      $img="poison.gif";
      $type="яд";
  } elseif ($effect['type']==9990) { // благословение
      $img="blago_admin.gif";
      $type="заклятие";
  } elseif ($effect['type']==9991) {  // благословение
      $img="blago_admin1.gif";
      $type="заклятие";
  } elseif ($effect['type']==9992) {  // проклятие
      $img="altarcurse.gif";
      $type="заклятие";
  } elseif ($effect['type']==9993) {  // благословение
      $img="altarcurse.gif";
      $type="благословение";
  } elseif ($effect["type"]==NYBLESSING) {
    $img="nyblessing.gif";
  } elseif ($effect["type"]==ADDICTIONEFFECT) {
    if ($effect["mfdhit"]) $img="mfdhit.gif";if ($effect["mfdkol"]) $img="mfdkol.gif";if ($effect["mfdrub"]) $img="mfdrub.gif";if ($effect["mfdrej"]) $img="mfdrej.gif";if ($effect["mfddrob"]) $img="mfddrob.gif";
    if ($effect["mfdmag"]) $img="mfdmag.gif";if ($effect["mfdfire"]) $img="mfdfire.gif";if ($effect["mfdwater"]) $img="mfdwater.gif";if ($effect["mfdair"]) $img="mfdair.gif";if ($effect["mfdearth"]) $img="mfdearth.gif";
    if ($effect["sila"]) $img="sila.gif";if ($effect["lovk"]) $img="lovk.gif";if ($effect["inta"]) $img="inta.gif";if ($effect["intel"]) $img="intel.gif";
    $type="эффект";
  } elseif ($effect["type"]==HPADDICTIONEFFECT) {
    $img="hpaddict.gif";
    $type="эффект";
    $v=str_replace("Пагубное пристрастие [", "", $effect["name"]);
    $v=str_replace("]", "", $v);
    $mfs.="Скорость восстановления жизни (%): -".(5*$v);
  } elseif ($effect["type"]==MANAADDICTIONEFFECT) {
    $img="manaaddict.gif";
    $type="эффект";
    $v=str_replace("Пагубное пристрастие [", "", $effect["name"]);
    $v=str_replace("]", "", $v);
    $mfs.="Скорость восстановления маны (%): -".(5*$v);
  } elseif ($effect['type']==395) {
    $img='defender.gif'; 
  } elseif ($effect['type']==201) {
    $img='spell_protect10.gif'; 
    $mfs.="Защита от урона: +100<br>";
  } elseif ($effect['type']==202) {
    $img='spell_powerup10.gif'; 
    $mfs.="Сила удара: +25<br>";
  } elseif ($effect['type']==1022) {
    $img='hidden.gif'; 
  } else {
    if (@$effectimgs[$effect["name"]]) $img=$effectimgs[$effect["name"]];
  }
  if (!@$img) {
    $inf_el = mysql_fetch_array(mq ('SELECT img FROM `shop` WHERE `name` = \''.$effect['name'].'\';'));
    if (!$inf_el) {
      $inf_el = mysql_fetch_array(mq ('SELECT img FROM `berezka` WHERE `name` = \''.$effect['name'].'\''));
    }
    if (!$inf_el) {
      $inf_el = mysql_fetch_array(mq ('SELECT img FROM `items` WHERE `name` = \''.$effect['name'].'\';'));
    }
    mq("insert into effectimgs set effect='$effect[name]', img='$inf_el[img]' on duplicate key update img=img");
    $img=$inf_el["img"];
  }
  if ($effect["type"]==40) {
    $mfs.="Скорость перемещения в подземельях (%): +60";
    $type="заклятие";
  }
  if (!$mfs) {
    if ($effect["type"]==28) $mfs.="Восстановление жизни (%): +".(100+addictval($user["hpaddict"]));
    if ($effect["hprestore"]) $mfs.="Восстановление жизни (%): " . $effect['hprestore'];
    if ($effect["type"]==29) $mfs.="Восстановление маны (%): +".(100+addictval($user["manaaddict"]));
    if ($effect["sila"]) $mfs.="Сила: ".plusorminus($effect["sila"])."<br>";
    if ($effect["lovk"]) $mfs.="Ловкость: ".plusorminus($effect["lovk"])."<br>";
    if ($effect["inta"]) $mfs.="Интуиция: ".plusorminus($effect["inta"])."<br>";
    if ($effect["intel"]) $mfs.="Интеллект: ".plusorminus($effect["intel"])."<br>";    
    if ($effect["ghp"]) $mfs.="Уровень жизни: ".plusorminus($effect["ghp"])."<br>";    
    if ($effect["gmana"]) $mfs.="Уровень маны: ".plusorminus($effect["gmana"])."<br>";    
    if ($effect["hpforvinos"]) $mfs.="Уровень жизни за выносливость: ".plusorminus($effect["hpforvinos"])."<br>";    
    if ($effect["mfdhit"]) $mfs.="Защита от урона: ".plusorminus($effect["mfdhit"])."<br>";    
    if ($effect["mfdkol"]) $mfs.="Защита от колющего урона: ".plusorminus($effect["mfdkol"])."<br>";    
    if ($effect["mfdrub"]) $mfs.="Защита от рубящего урона: ".plusorminus($effect["mfdrub"])."<br>";    
    if ($effect["mfdrej"]) $mfs.="Защита от режущего урона: ".plusorminus($effect["mfdrej"])."<br>";    
    if ($effect["mfddrob"]) $mfs.="Защита от дробящего урона: ".plusorminus($effect["mfddrob"])."<br>";    
    if ($effect["mfdfire"]) $mfs.="Защита от магии огня: ".plusorminus($effect["mfdfire"])."<br>";    
    if ($effect["mfdwater"]) $mfs.="Защита от магии воды: ".plusorminus($effect["mfdwater"])."<br>";    
    if ($effect["mfdair"]) $mfs.="Защита от магии воздуха: ".plusorminus($effect["mfdair"])."<br>";    
    if ($effect["mfdearth"]) $mfs.="Защита от магии земли: ".plusorminus($effect["mfdearth"])."<br>";    
    if ($effect["mfdmag"]) $mfs.="Защита от магии: ".plusorminus($effect["mfdmag"])."<br>";    
    if ($effect["mf"]) {
      $tmp=explode("/", $effect["mf"]);
      $tmp2=explode("/", $effect["mfval"]);
      foreach ($tmp as $k=>$v) {
        $mfs.=mfname($v).": ".plusorminus($tmp2[$k])."<br>";
      }
    }
  }
  if (!@$type) {
    if ($effect["type"]>395 && $effect["type"]<1000) $type='награда';
    elseif ($effect['type']==395) $type='награда';
    elseif ($effect['type']==49) $type='еда';
    elseif ($effect['type']==31 || $effect['type']==35  || $effect['type']==38 || $effect['type']==186 || $effect["type"]==24) $type='эффект';
    elseif ($effect["type"]==26 || $effect["type"]==187 || $effect['type']==201 || $effect['type']==202 || $effect['type']==1022) $type='заклятие'; 
    elseif ($effect["type"]==54 || $effect["type"]==MAKESNOWBALL || $effect["type"]==NYBLESSING) $type='эффект';
    else $type='эликсир';
  }
  return array("img"=>$img, "type"=>$type, "mfs"=>$mfs);
}

function setDisease($id, $return = 1) {
  global $user;
  //die($user['id']);
  $d = mqfa("SELECT * FROM diseases WHERE id = " . $id) or die(mysql_error());
  mysql_query("
    UPDATE users 
    SET 
      sila  = ($d[sila] + sila), 
      lovk  = ($d[lovk] + lovk), 
      inta  = ($d[inta] + inta), 
      vinos = ($d[vinos] + vinos)
    WHERE id = $user[id]
  ") or die(mysql_error());
  mysql_query("
    INSERT INTO effects 
    SET
      type  = $d[type],
      name  = '$d[name]',
      time  = " . (time() + $d['duration']) . ",
      sila  = $d[sila], 
      lovk  = $d[lovk], 
      inta  = $d[inta], 
      vinos = $d[vinos],
      owner = $user[id]
  ") or die(mysql_error());
  $msg = 'Вы заразились ' . (($d['type'] == 9999) ? 'болезнью' : 'ядом' ) . ' <b>' . $d['name'] . '</b>';
  addchp ('<font color=red>Внимание!</font> ' . $msg, '{[]}'.$user['login'].'{[]}');
  if ($return) {
    return $msg;  
  }
}

function mainpersout($user) {
  $ret1.= '<TABLE cellspacing=0 cellpadding=0 style="border-top-width: 1px;border-right-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-top-style: solid;border-right-style: solid;border-bottom-style: solid;border-left-style: solid;border-top-color: #FFFFFF;border-right-color: #666666;border-bottom-color: #666666;border-left-color: #FFFFFF;padding: 2px;">
  <TR><TD>
  <TABLE border=0 cellSpacing=1 cellPadding=0 width="100%" >
  <TBODY>
  <TR vAlign=top>
  <TD>
  <TABLE cellSpacing=0 cellPadding=0 width="100%">
  <TBODY>
  <TR><TD style="BACKGROUND-IMAGE:none">';
  $ret0=$ret1;
  $invis=$user["invis"];
  //$invis = mysql_fetch_array(mq("SELECT `time` FROM `effects` WHERE `owner` = '{$id}' and `type` = '1022' LIMIT 1;"));
  if($invis) {
    $user['level'] = '??';
    $user['login'] = '</a><b><i>невидимка</i></b>';
    $user['align'] = '0';
    $user['klan'] = '';
    $user['id'] = '';
    $user['hp'] = '??';
    $user['maxhp'] = '??';
    $user['mana'] = '??';
    $user['maxmana'] = '??';
    $user['sila'] ='??';
    $user['lovk'] ='??';
    $user['inta'] ='??';
    $user['vinos'] ='??';
    $user['sexy'] ='??';
    $showme = $user['id'];
    $ret0.= '<img src="'.IMGBASE.'/i/helm.gif" width=60 height=60>';
    $ret0.= '</TD></TR>
    <TR><TD style="BACKGROUND-IMAGE:none">';
    if ($user['naruchi'] >=0) $ret0.= '<img src="'.IMGBASE.'/i/naruchi.gif" width=60 height=40>';
    $ret0.= '</TD></TR><TR><TD style="BACKGROUND-IMAGE: none">';
    if ($user['weap'] >=0) $ret0.= '<img src="'.IMGBASE.'/i/weap.gif" width=60 height=60>';
    $ret0.= '</TD></TR><TR><TD style="BACKGROUND-IMAGE: none">';
    if ($user['bron'] >=0) $ret0.= '<img src="'.IMGBASE.'/i/bron.gif" width=60 height=80>';
    $ret0.= '</TD></TR><TR><TD style="BACKGROUND-IMAGE: none">';
    if ($user['belt'] >=0) $ret0.= '<img src="'.IMGBASE.'/i/belt.gif" width=60 height=40>';
  }

  $cond=dresscond($user);
  if ($cond) {
    $r=mq("select id, img, includemagicdex, includemagic, includemagicmax, name, duration, maxdur, ghp, gmana, minu, maxu, text from inventory where $cond");
    while ($rec=mysql_fetch_assoc($r)) {
      $dressed[$rec["id"]]=$rec;
    }
  }

  if ($user['helm'] > 0) {
    $dress = $dressed[$user["helm"]];
    //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user['helm']}' LIMIT 1;"));
    $tmp0='<img  '.((($dress['maxdur']-2)<=$dress['duration'])?" style='background-image:url(".IMGBASE."/i/blink.gif);' ":"").' src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=60 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа шлеме выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа шлеме выгравировано '{$dress['text']}'":"").'" >';
    if ($dress['includemagicdex']) {
      $tmp1=showhrefmagicb($dress);
    } else $tmp1=$tmp0;    
    $ret1.=$tmp1;if (!$invis) $ret0.=$tmp0;
  } else {
    $tmp='<img src="'.IMGBASE.'/i/w9.gif" width=60 height=60 alt="Пустой слот шлем" >';
    $ret1.=$tmp;
    if (!$invis) $ret0.=$tmp;
  }

  $ret0.= '</TD></TR><TR><TD style="BACKGROUND-IMAGE:none">';
  $ret1.= '</TD></TR><TR><TD style="BACKGROUND-IMAGE:none">';
  if ($user['naruchi'] > 0) {
    $dress = $dressed[$user["naruchi"]];
    //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user['naruchi']}' LIMIT 1;"));
    $tmp0='<img src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=40 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа наручах выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа наручах выгравировано '{$dress['text']}'":"").'" >';
    if ($dress['includemagicdex']) {
      $tmp1=showhrefmagicb($dress);
    } else $tmp1=$tmp0;
    $ret1.=$tmp1;if (!$invis) $ret0.=$tmp0;    
  } else {
    $tmp= '<img src="'.IMGBASE.'/i/w18.gif" width=60 height=40 alt="Пустой слот наручи" >';
    $ret1.=$tmp;
    if (!$invis) $ret0.=$tmp;
  }
  $ret0.= '</TD></TR><TR><TD style="BACKGROUND-IMAGE: none">';
  $ret1.= '</TD></TR><TR><TD style="BACKGROUND-IMAGE: none">';
  if ($user['weap'] > 0) {
    $dress = $dressed[$user["weap"]];
    $tmp0='<img src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=60 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['minu']>0)?"\nУрон {$dress['minu']}-{$dress['maxu']}":"").(($dress['text']!=null)?"\nНа оружии выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['minu']>0)?"\nУрон {$dress['minu']}-{$dress['maxu']}":"").(($dress['text']!=null)?"\nНа оружии выгравировано '{$dress['text']}'":"").'" >';
    //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user['weap']}' LIMIT 1;"));
    if ($dress['includemagicdex']) {
      $tmp1=showhrefmagicb($dress);
    } else $tmp1=$tmp0;
    $ret1.=$tmp1;if (!$invis) $ret0.=$tmp0;
  } else {
    $tmp= '<img src="'.IMGBASE.'/i/w3.gif" width=60 height=60 alt="Пустой слот оружие" >';
    $ret1.=$tmp;
    if (!$invis) $ret0.=$tmp;
  }
  $ret0.= '</TD></TR><TR><TD style="BACKGROUND-IMAGE: none">';
  $ret1.= '</TD></TR><TR><TD style="BACKGROUND-IMAGE: none">';
  if ($user['bron'] > 0 || $user['rybax'] > 0 || $user['plaw'] > 0) {
    $title="";
    if ($user['plaw']) {
      $d=$user['plaw'];
      if ($user["bron"]) {
        $dress = $dressed[$user["bron"]];
        //$dress = mqfa("SELECT name, duration, maxdur, ghp, gmana, text FROM `inventory` WHERE `id` = '$user[bron]'");
        $title.="\n--------------------\n$dress[name]\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа одежде вышито '{$dress['text']}'":"");
      }
      if ($user["rybax"]) {
        $dress = $dressed[$user["rybax"]];
        //$dress = mqfa("SELECT name, duration, maxdur, ghp, gmana, text FROM `inventory` WHERE `id` = '$user[rybax]'");
        $title.="\n--------------------\n$dress[name]\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа одежде вышито '{$dress['text']}'":"");
      }
    } elseif ($user['bron']) {
      $d=$user['bron'];
      if ($user["rybax"]) {
        $dress = $dressed[$user["rybax"]];
        //$dress = mqfa("SELECT name, duration, maxdur, ghp, gmana, text FROM `inventory` WHERE `id` = '$user[rybax]'");
        $title.="\n--------------------\n$dress[name]\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа одежде вышито '{$dress['text']}'":"");
      }
    } elseif ($user['rybax']) $d=$user['rybax'];
    $dress = $dressed[$d];
    $tmp0='<img src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=80 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа одежде вышито '{$dress['text']}'":"").$title.'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа одежде вышито '{$dress['text']}'":"").$title.'" >';
    //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '$d' LIMIT 1;"));
    if ($dress['includemagicdex']) {
      $tmp1=showhrefmagicb($dress);
    } else $tmp1=$tmp0;
    $ret1.=$tmp1;if (!$invis) $ret0.=$tmp0;
  } else {
    $tmp= '<img src="'.IMGBASE.'/i/w4.gif" width=60 height=80 alt="Пустой слот броня" >';
    $ret1.=$tmp;
    if (!$invis) $ret0.=$tmp;
  }
  $ret0.= '</TD></TR><TR><TD style="BACKGROUND-IMAGE: none">';
  $ret1.= '</TD></TR><TR><TD style="BACKGROUND-IMAGE: none">';
  if ($user['belt'] > 0) {
    $dress = $dressed[$user['belt']];
    $tmp0='<img src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=40 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа поясе выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа поясе выгравировано '{$dress['text']}'":"").'" >';
    //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user['belt']}' LIMIT 1;"));
    if ($dress['includemagicdex']) {
      $tmp1=showhrefmagicb($dress);
    } else $tmp1=$tmp0;
    $ret1.=$tmp1;if (!$invis) $ret0.=$tmp0;
  } else {
    $tmp= '<img src="'.IMGBASE.'/i/w5.gif" width=60 height=40 alt="Пустой слот пояс" >';
    $ret1.=$tmp;
    if (!$invis) $ret0.=$tmp;
  }


  $tmp='</TD></TR></TBODY></TABLE></TD><TD><TABLE border=0 cellSpacing=0 cellPadding=0 width="100%">
  <TR><TD height=20 vAlign=middle><table cellspacing="0" cellpadding="0">
  <tr><td nowrap height=10 style="font-size:9px;height:9px;line-height:9px;overflow:hidden"><div style="position: relative;height:10px;overflow:hidden">
  <!--hp--></div></td></tr>';
  $ret0.=$tmp;$ret1.=$tmp;
  if($user['id']==99){
    $vrag_b = mysql_fetch_array(mq("SELECT `hp` FROM `bots` WHERE  `prototype` = 99 LIMIT 1 ;"));
    if($vrag_b){$user['hp']=$vrag_b['hp'];}
  }

  if($user['maxmana'] && $uid<_BOTSEPARATOR_){
    $ret0.='<tr><td nowrap height=10 style="font-size:9px;line-height:9px;height:9px"><div style="position: relative;height:10px;overflow:hidden"><!--mana--></div></td></tr>';
    $ret1.='<tr><td nowrap height=10 style="font-size:9px;line-height:9px;height:9px"><div style="position: relative;height:10px;overflow:hidden"><!--mana--></div></td></tr>';
  }
  $zver=mysql_fetch_array(mq("SELECT shadow,login,level,vid FROM `users` WHERE `id` = '".$user['zver_id']."' LIMIT 1;"));

  $ret0.= '</table></TD></TR><TR><TD height=220 vAlign=top width=120 align=left><DIV style="Z-INDEX: 1; POSITION: relative; WIDTH: 120px; HEIGHT: 220px;background-color:#000000">';
  $ret1.= '</table></TD></TR><TR><TD height=220 vAlign=top width=120 align=left><DIV style="Z-INDEX: 1; POSITION: relative; WIDTH: 120px; HEIGHT: 220px;background-color:#000000">';

  $strtxt = "<nobr><b>".$user['login']."</b></nobr><br>";
  $strtxt .= "<nobr>Сила: <!--sila-->".$user['sila']."</nobr><BR>";
  $strtxt .= "<nobr>Ловкость: <!--lovk-->".$user['lovk']."</nobr><BR>";
  $strtxt .= "<nobr>Интуиция: <!--inta-->".$user['inta']."</nobr><BR>";
  $strtxt .= "<nobr>Выносливость: ".$user['vinos']."<nobr><BR>";
  if ($user['level'] > 3) $strtxt .= "<nobr>Интеллект: ".$user['intel']."</nobr><BR>";
  if ($user['level'] > 6) $strtxt .= "<nobr>Мудрость: ".$user['mudra']."</nobr><BR>";
  if ($user['level'] > 9) $strtxt .= "<nobr>Духовность: ".$user['spirit']."</nobr><BR>";
  if ($user['level'] > 12) $strtxt .= "<nobr>Воля: ".$user['will']."</nobr><BR>";
  if ($user['level'] > 15) $strtxt .= "<nobr>Свобода духа: ".$user['freedom']."</nobr><BR>";
  if ($user['level'] > 18) $strtxt .= "<nobr>Божественность: ".$user['god']."</nobr><BR>";

  if($zver && $zver["vid"]){
    $tmp="<div style=\"position:absolute; left:80px; top:147px; width:40px; height:73px; z-index:4\">
    <IMG width=40 height=73 src='".IMGBASE."/i/shadow/$zver[shadow]' alt=\"$zver[login] [$zver[level]]\"></div>";
    $ret1.=$tmp;
    if (!$invis) $ret0.=$tmp;
  }

  $ret1.= "<IMG style=\"position:relative;z-index:3\" border=0 src=\"".IMGBASE."/i/shadow/$user[sex]/$user[shadow]\" width=120 height=218 onmouseout='hideshow();'  onmouseover='fastshow2(\"$strtxt\", this, event);'>";
  if($invis) {
    $ret0.="<IMG style=\"position:relative;z-index:3\" border=0 src=\"".IMGBASE."/i/shadow/invis.gif\" width=120 height=218 onmouseout='hideshow();'  onmouseover='fastshow2(\"$strtxt\", this, event);'>";
  } else $ret0.= "<IMG style=\"position:relative;z-index:3\" border=0 src=\"".IMGBASE."/i/shadow/$user[sex]/$user[shadow]\" width=120 height=218 onmouseout='hideshow();'  onmouseover='fastshow2(\"$strtxt\", this, event);'>";
  

  $ret0.= "<!--strokes--><DIV style=\"Z-INDEX: 2; POSITION: absolute; WIDTH: 120px; HEIGHT: 220px; TOP: 0px; LEFT: 0px\"></DIV></DIV></TD></TR><TR><TD>";
  $ret1.= "<!--strokes--><DIV style=\"Z-INDEX: 2; POSITION: absolute; WIDTH: 120px; HEIGHT: 220px; TOP: 0px; LEFT: 0px\"></DIV></DIV></TD></TR><TR><TD>";
  $ret1.="<!--belt-->";

  if($invis) {
    $ret0.='<IMG border=0 alt="" src="'.IMGBASE.'/i/slot_invis.gif" width=120 height=40>';
  } elseif ($user['vip']>=1) {
    $ret0.='<IMG border=0 alt="" src="'.IMGBASE.'/i/slot_bottom60.gif" width=120 height=40>';
  } elseif ($user['align']>1 && $user['align']<2) {
    $ret0.='<IMG border=0 alt="" src="'.IMGBASE.'/i/slot_bottom1.gif" width=120 height=40>';
  } elseif ($user['align']>=3 && $user['align']<4) {
    $ret0.='<IMG border=0 alt="" src="'.IMGBASE.'/i/slot_bottom3.gif" width=120 height=40>';
  } elseif ($user['align']==7) {
    $ret0.='<IMG border=0 alt="" src="'.IMGBASE.'/i/slot_bottom7.gif" width=120 height=40>';
  } elseif ($user['align']==0.99) {
    $ret0.='<IMG border=0 alt="" src="'.IMGBASE.'/i/slot_bottom1.gif" width=120 height=40>';
  } elseif ($user['align']==0.98) {
    $ret0.='<IMG border=0 alt="" src="'.IMGBASE.'/i/slot_bottom3.gif" width=120 height=40>';
  } else{
    $ret0.='<IMG border=0 alt="" src="'.IMGBASE.'/i/slot_bottom0.gif" width=120 height=40>';
  }

  $ret0.= "</TD></TR></TABLE></TD><TD><TABLE border=0 cellSpacing=0 cellPadding=0 width=\"100%\"><TBODY><TR><TD style=\"BACKGROUND-IMAGE: none\">";
  $ret1.= "</TD></TR></TABLE></TD><TD><TABLE border=0 cellSpacing=0 cellPadding=0 width=\"100%\"><TBODY><TR><TD style=\"BACKGROUND-IMAGE: none\">";

  if($invis) {
    if ($user['sergi'] >= 0) {
      $ret0.= '<img src="'.IMGBASE.'/i/serg.gif" width=60 height=20>';
    }
    $ret0.= "</TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
    if ($user['kulon'] >= 0) {
      $ret0.= '<img src="'.IMGBASE.'/i/ojur.gif" width=60 height=20>';
    }
    $ret0.= "</TD></TR><TR><TD><TABLE border=0 cellSpacing=0 cellPadding=0><TBODY> <TR><TD style=\"BACKGROUND-IMAGE: none\">";
    if ($user['r1'] >= 0) {
      $ret0.= '<img src="'.IMGBASE.'/i/ring.gif" width=20 height=20>';
    }
    $ret0.= "</td><TD style=\"BACKGROUND-IMAGE: none\">";
    if ($user['r2'] >= 0) {
        $ret0.= '<img src="'.IMGBASE.'/i/ring.gif" width=20 height=20>';
    }
    $ret0.= "</td><TD style=\"BACKGROUND-IMAGE: none\">";
    if ($user['r3'] >= 0) {
      $ret0.= '<img src="'.IMGBASE.'/i/ring.gif" width=20 height=20>';
    }
    $ret0.= "</td></TR></TBODY></TABLE></TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
    if ($user['perchi'] >= 0) {
      $ret0.= '<img src="'.IMGBASE.'/i/perchi.gif" width=60 height=40>';
    }
    $ret0.= "</TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
    if ($user['shit'] >= 0) {
      $ret0.= '<img src="'.IMGBASE.'/i/shit.gif" width=60 height=60>';
    }
    $ret0.= "</TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
    if ($user['leg'] >= 0) {
      $ret0.= '<img src="'.IMGBASE.'/i/leg.gif" width=60 height=80>';
    }
    $ret0.= "</TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
    if ($user['boots'] >= 0) {
      $ret0.= '<img src="'.IMGBASE.'/i/boots.gif" width=60 height=40>';
    }
  } 

  if ($user['sergi'] > 0) {
    $dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user['sergi']}' LIMIT 1;"));
    $tmp0='<img src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=20 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа серьгах выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа серьгах выгравировано '{$dress['text']}'":"").'" >';
    if ($dress['includemagicdex']) {
      $tmp1=showhrefmagicb($dress);
    } else $tmp1=$tmp0;
    $ret1.=$tmp1;if (!$invis) $ret0.=$tmp0;
  } else {
    $tmp= '<img src="'.IMGBASE.'/i/w1.gif" width=60 height=20 alt="Пустой слот серьги" >';
    $ret1.=$tmp;
    if (!$invis) $ret0.=$tmp;
  }
  $ret0.= "</TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
  $ret1.= "</TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
  if ($user['kulon'] > 0) {
    $dress = $dressed[$user['kulon']];
    $tmp0='<img src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=20 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа ожерелье выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа ожерелье выгравировано '{$dress['text']}'":"").'" >';
    //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user['kulon']}' LIMIT 1;"));
    if ($dress['includemagicdex']) {
      $tmp1=showhrefmagicb($dress);
    } else $tmp1=$tmp0;
    $ret1.=$tmp1;if (!$invis) $ret0.=$tmp0;
  } else {
    $tmp= '<img src="'.IMGBASE.'/i/w2.gif" width=60 height=20 alt="Пустой слот ожерелье" >';
    $ret1.=$tmp;
    if (!$invis) $ret0.=$tmp;
  }
  $ret0.= "</TD></TR><TR><TD><TABLE border=0 cellSpacing=0 cellPadding=0><TBODY> <TR><TD style=\"BACKGROUND-IMAGE: none\">";
  $ret1.= "</TD></TR><TR><TD><TABLE border=0 cellSpacing=0 cellPadding=0><TBODY> <TR><TD style=\"BACKGROUND-IMAGE: none\">";
  if ($user['r1'] > 0) {
    $dress = $dressed[$user['r1']];
    $tmp0='<img src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=20 height=20 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа кольце выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа кольце выгравировано '{$dress['text']}'":"").'" >';
    //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user['r1']}' LIMIT 1;"));
    if ($dress['includemagicdex']) {
      $tmp1=showhrefmagicb($dress);
    } else $tmp1=$tmp0;
    $ret1.=$tmp1;if (!$invis) $ret0.=$tmp0;
  } else {
    $tmp= '<img src="'.IMGBASE.'/i/w6.gif" width=20 height=20 alt="Пустой слот кольцо" >';
    $ret1.=$tmp;
    if (!$invis) $ret0.=$tmp;
  }
  $ret0.= "</td><TD style=\"BACKGROUND-IMAGE: none\">";
  $ret1.= "</td><TD style=\"BACKGROUND-IMAGE: none\">";
  if ($user['r2'] > 0) {
    $dress = $dressed[$user['r2']];
    $tmp0='<img src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=20 height=20 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа кольце выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа кольце выгравировано '{$dress['text']}'":"").'" >';
    //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user['r2']}' LIMIT 1;"));
    if ($dress['includemagicdex']) {
      $tmp1=showhrefmagicb($dress);
    } else $tmp1=$tmp0;
    $ret1.=$tmp1;if (!$invis) $ret0.=$tmp0;
  } else {
    $tmp= '<img src="'.IMGBASE.'/i/w6.gif" width=20 height=20 alt="Пустой слот кольцо" >';
    $ret1.=$tmp;
    if (!$invis) $ret0.=$tmp;
  }
  $ret0.= "</td><TD style=\"BACKGROUND-IMAGE: none\">";
  $ret1.= "</td><TD style=\"BACKGROUND-IMAGE: none\">";
  if ($user['r3'] > 0) {
    $dress = $dressed[$user['r3']];
    $tmp0='<img src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=20 height=20 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа кольце выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа кольце выгравировано '{$dress['text']}'":"").'" >';
    //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user['r3']}' LIMIT 1;"));
    if ($dress['includemagicdex']) {
      $tmp1=showhrefmagicb($dress);
    } else $tmp1=$tmp0;
    $ret1.=$tmp1;if (!$invis) $ret0.=$tmp0;
  } else {
    $tmp= '<img src="'.IMGBASE.'/i/w6.gif" width=20 height=20 alt="Пустой слот кольцо" >';
    $ret1.=$tmp;
    if (!$invis) $ret0.=$tmp;
  }
  $ret0.= "</td></TR></TBODY></TABLE></TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
  $ret1.= "</td></TR></TBODY></TABLE></TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
  if ($user['perchi'] > 0) {
    $dress = $dressed[$user['perchi']];
    $tmp0='<img src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=40 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа перчатках выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа перчатках выгравировано '{$dress['text']}'":"").'" >';
    //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user['perchi']}' LIMIT 1;"));
    if ($dress['includemagicdex']) {
      $tmp1=showhrefmagicb($dress);
    } else $tmp1=$tmp0;
    $ret1.=$tmp1;if (!$invis) $ret0.=$tmp0;
  } else {
    $tmp= '<img src="'.IMGBASE.'/i/w11.gif" width=60 height=40 alt="Пустой слот перчатки" >';
    $ret1.=$tmp;
    if (!$invis) $ret0.=$tmp;
  }
  $ret0.= "</TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
  $ret1.= "</TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
  if ($user['shit'] > 0) {
    $dress = $dressed[$user['shit']];
    $tmp0='<img src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=60 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['minu']>0)?"\nУрон {$dress['minu']}-{$dress['maxu']}":"").(($dress['text']!=null)?"\nНа ".($dress["type"]==3?"оружии":"щите")." выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа ".($dress["type"]==3?"оружии":"щите")." выгравировано '{$dress['text']}'":"").'" >';
    //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user['shit']}' LIMIT 1;"));
    if ($dress['includemagicdex']) {
      $tmp1=showhrefmagicb($dress);
    } else $tmp1=$tmp0;
    $ret1.=$tmp1;if (!$invis) $ret0.=$tmp0;
  } else {
    $tmp= '<img src="'.IMGBASE.'/i/w10.gif" width=60 height=60 alt="Пустой слот щит" >';
    $ret1.=$tmp;
    if (!$invis) $ret0.=$tmp;
  }
  $ret0.= "</TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
  $ret1.= "</TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
  if ($user['leg'] > 0) {
    $dress = $dressed[$user['leg']];
    $tmp0='<img src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=80 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа поножах выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа поножах выгравировано '{$dress['text']}'":"").'" >';
    //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user['leg']}' LIMIT 1;"));
    if ($dress['includemagicdex']) {
      $tmp1=showhrefmagicb($dress);
    } else $tmp1=$tmp0;
    $ret1.=$tmp1;if (!$invis) $ret0.=$tmp0;
  } else {
    $tmp= '<img src="'.IMGBASE.'/i/w19.gif" width=60 height=80 alt="Пустой слот поножи" >';
    $ret1.=$tmp;
    if (!$invis) $ret0.=$tmp;
  }
  $ret0.= "</TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
  $ret1.= "</TD></TR><TR><TD style=\"BACKGROUND-IMAGE: none\">";
  if ($user['boots'] > 0) {
    $dress = $dressed[$user['boots']];
    $tmp0='<img src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=60 height=40 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа ботинках выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа ботинках выгравировано '{$dress['text']}'":"").'" >';
    //$dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user['boots']}' LIMIT 1;"));
    if ($dress['includemagicdex']) {
      $tmp1=showhrefmagicb($dress);
    } else $tmp1=$tmp0;
    $ret1.=$tmp1;if (!$invis) $ret0.=$tmp0;
  } else {
    $tmp= '<img src="'.IMGBASE.'/i/w12.gif" width=60 height=40 alt="Пустой слот обувь" >';
    $ret1.=$tmp;
    if (!$invis) $ret0.=$tmp;
  }

  $tmp="</TD></TR></TBODY></TABLE></TD></TR>
  </TBODY></TABLE>
  </TD></TR><TR><TD></TD></tr></TABLE>";
  $ret0.=$tmp;
  $ret1.=$tmp;
  return array($ret0, $ret1);
}

function givemoney($userid, $sum, $reason) {
  mq("update users set money=money+$sum where id='$userid'");
  adddelo($userid, "Получено $sum кр. $reason", 1);
}

function rusandlatin($str) {
  $p1=preg_match("/[a-zA-Z]/",$str);
  $p2=preg_match("/[а-яА-Я]/",$str);
  if ($p1 && $p2) return 1;
  return 0;
}

function getcavedata($caveleader, $floor) {
  return unserialize(implode("", file(CHATROOT."cavedata/$caveleader-$floor.dat")));
}

function savecavedata($cavedata, $caveleader, $floor) {
  $f1=fopen(CHATROOT."cavedata/$caveleader-$floor.dat", "wb+");
  flock($f1, LOCK_EX);
  fwrite($f1, serialize($cavedata));
  flock($f1, LOCK_UN);
  fclose($f1);
}

function itemrow($row, $link, $linkname, $i) {
  if ($i%2==0)  $color = '#C7C7C7'; else $color = '#D5D5D5';
  $ret="<tr><td bgcolor=\"$color\" align=center style=\"width:130px;padding:5px\"><img src=\"".IMGBASE."/i/sh/$row[img]\" border=0>";
  if ($linkname) $ret.="<br><a href=\"$link\">$linkname</A>";
  $ret.="</td><td bgcolor=\"$color\" valign=top>".itemdata($row, "", 1)."</td></tr>";
  return $ret;
}

function takehp($u, $hp) {
  global $user;
  mq("update users set hp=if(hp<$hp, 0, hp-$hp), fullhptime=".time()." where id='$u'");
  if ($u==$user["id"]) $user["hp"]=max($user["hp"]-$hp,0);
}

function cancarry($m) {
  global $user;
  if (!$u) $u=$user["id"];
  $bp=mqfa("select sum(massa) as massa, sum(gmeshok) as gmeshok from inventory where owner='$u' and dressed=0 and setsale=0");
  $mw=40*$user["level"]+$user["vinos"]+$bp["gmeshok"];
  if ($bp["massa"]+$m>$mw) return false;
  return true;
}

function useitem($item, $qty=1, $uid=0) {
  global $user;
  if (!$uid) $uid=$user["id"];
  $rec=mqfa("select id, duration, maxdur, koll, massa from inventory where prototype='$item' and owner='$uid'");
  if ($rec) {
    if ($rec["koll"]) {
      if ($rec["koll"]==1) mq("delete from inventory where id='$rec[id]'");
      else mq("update inventory set koll=koll-1, massa=".round($rec["massa"]/$rec["koll"]*($rec["koll"]-1),1)." where id='$rec[id]'");
    } else {
      if ($rec["duration"]+1==$rec["maxdur"]) mq("delete from inventory where id='$rec[id]'");
      else mq("update inventory set duration=duration+1 where id='$rec[id]'");
    }
  }
}
$tme1=getmicrotime();
if ($user && $user["level"]==0 && $user["room"]!=1) gotoroom(1,0);
if ($user["hp"]>$user["maxhp"]) {
$user["hp"]=$user["maxhp"];
mq("update users set hp=maxhp where id='$user[id]'");
}
if ($user["mana"]>$user["maxmana"]) {
$user["mana"]=$user["maxmana"];
mq("update users set mana=maxmana where id='$user[id]'");
}
if (APR1 && $user["level"]==0 && $user["room"]!=1) {
gotoroom(1,1,1);
}
if ($user["id"]==7) $user["invis"];

?>
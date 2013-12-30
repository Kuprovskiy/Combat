<?php
session_start();
if ($_SESSION['uid'] == null) header("Location: index.php");
include "connect.php";
include "functions.php";
nick99 ($_SESSION['uid']);
define("WINTER","winter/");
$der=mysql_query("SELECT glav_id FROM vxodd WHERE login='".$user['login']."'");
if($deras=mysql_fetch_array($der) && $_GET['bps']){
header('location: vxod.php?warning=3');
die();
}
$user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
if ($_GET['strah'] && ($user['room']==42 or $user['room']==31 or $user['room']==679 or $user['room']==680 or $user['room']==681 or $user['room']==682 or $user['room']==683 or $user['room']==34 or $user['room']==690 or $user['room']==2000 or $user['room']==35 or $user['room']==684 or $user['room']==28 or $user['room']==29 or $user['room']==1211 or $user['room']==402 or $user['room']==20 or $user['room']==888 or $user['room']==3700 or $user['room']==3701 or $user['room']==876 or $user['room']==981 or $user['room']==700 or $user['room']==29 or $user['room']==9001 or $user['room']==777 or $user['room']==101 or $user['room']==102 or $user['room']==103 or $user['room']==104 or $user['room']==105 or $user['room']==106)) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '21',`online`.`room` = '21' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}';");
$user['room']=21;
}
if ($_GET['tower'] && ($user['room']==9000 or $user['room']==9001)) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '9000',`online`.`room` = '9000' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}';");
$user['room']=9000;
}
if ($_GET['cp'] && ($user['room']==22 or $user['room']==23 or $user['room']==25 or $user['room']==27 or $user['room']==700 or $user['room']==208 or $user['room']==1011 or $user['room']==11111 or $user['room']==671 or $user['room']==698 or $user['room']==21 or $user['room']==668 or $user['room']==669 or $user['room']==670 or $user['room']==691 or $user['room']==876 or $user['room']==888 or $user['room']==209 or $user['room']==5000 or $user['room']==981 or $user['room']==100100 or $user['room']==692 or $user['room']==9001 or $user['room']==7777 or $user['room']==2222)) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '20',`online`.`room` = '20' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}';");
$user['room']=20;
}
if ($_GET['park'] && ($user['room']==20 or $user['room']==670 or $user['room']==700000 or $user['room']==200001 or $user['room']==200002 or $user['room']==37 or $user['room']==200003 or $user['room']==51 or $user['room']==54)) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '660',`online`.`room` = '660' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}';");
$user['room']=660;
}
if ($_GET['torg'] && ($user['room']==21 or $user['room']==800000 or $user['room']==700 or $user['room']==31 or $user['room']==59 or $user['room']==42 or $user['room']==71 or $user['room']==62 or $user['room']==668)) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '650',`online`.`room` = '650' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}';");
$user['room']=650;
}
if ($_GET['bps'] && ($user['room']==20 or $user['room']==56 or $user['room']==58 or $user['room']==690 or $user['room']==60 or $user['room']==691 or $user['room']==672 or $user['room']==698 or $user['room']==798 or $user['room']==673 or $user['room']==674 or $user['room']==675 or $user['room']==676 or $user['room']==677 or $user['room']==679 or $user['room']==684 or $user['room']==2000 or $user['room']==209 or $user['room']==896 or $user['room']==898 or $user['room']==876 or $user['room']==100100 or $user['room']==100101 or $user['room']==406 or $user['room']==90 or $user['room']==91 or $user['room']==64)) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '670',`online`.`room` = '670' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}';");
$user['room']=670;

}
if ($_GET['sklon'] && ($user['room']==21 or $user['room']==800001 or $user['room']==800002 or $user['room']==73 or $user['room']==75 or $user['room']==77 or $user['room']==402 or $user['room']==800003 or $user['room']==800004)) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '800000',`online`.`room` = '800000' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}';");
$user['room']=800000;
}
if ($_GET['xram'] && ($user['room']==20 or $user['room']==693)) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '692',`online`.`room` = '692' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}';");
$user['room']=692;
}
if ($_GET['zalcer'] && ($user['room']==692 or $user['room']==694)) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '693',`online`.`room` = '693' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}';");
$user['room']=693;
}
if ($_GET['hill'] && ($user['room']==82 or $user['room']==650)) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '393',`online`.`room` = '393' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}';");
$user['room']=393;
}

if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }
if ($user['in_tower'] == 1) { header('Location: towerin.php'); die(); }
header("Cache-Control: no-cache");
$d = mysql_fetch_array(mysql_query("SELECT sum(`massa`) FROM `inventory` WHERE `owner` = '{$user['id']}' AND `dressed` = 0 AND `setsale` = 0 ; "));
if($d[0] > get_meshok() && $_GET['got']) {
echo "<font color=red><b>У вас переполнен рюкзак, вы не можете передвигатся...</b></font>";
$_GET['got'] =0;
}
$eff = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$u['id']."' AND (`type` = 14 OR `type` = 13);"));
if($eff && $_GET['got']) {
echo "<font color=red><b>У вас тяжелая травма, вы не можете передвигатся...</b></font>";
$_GET['got'] =0;
}
$chain = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$u['id']."' AND (`type` = 10);"));
if($chain && $_GET['got']) {
echo "<font color=red><b>На Вас наложены путы, вы не можете передвигатся...</b></font>";
$_GET['got'] =0;
}
if($d[0] > get_meshok() && $_GET['strah']) {
echo "<font color=red><b>У вас переполнен рюкзак, вы не можете передвигатся...</b></font>";
$_GET['strah'] =0;
}
$eff = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$u['id']."' AND (`type` = 14 OR `type` = 13);"));
if($eff && $_GET['strah']) {
echo "<font color=red><b>У вас тяжелая травма, вы не можете передвигатся...</b></font>";
$_GET['strah'] =0;
}
$chain = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$u['id']."' AND (`type` = 14 OR `type` = 13);"));
if($chain && $_GET['strah']) {
echo "<font color=red><b>На Вас наложены путы, вы не можете передвигатся...</b></font>";
$_GET['strah'] =0;
}
if($d[0] > get_meshok() && $_GET['cp']) {
echo "<font color=red><b>У вас переполнен рюкзак, вы не можете передвигатся...</b></font>";
$_GET['cp'] =0;
}
$eff = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$u['id']."' AND (`type` = 14 OR `type` = 13);"));
if($eff && $_GET['cp']) {
echo "<font color=red><b>У вас тяжелая травма, вы не можете передвигатся...</b></font>";
$_GET['cp'] =0;
}
$chain = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$u['id']."' AND (`type` = 10);"));
if($chain && $_GET['cp']) {
echo "<font color=red><b>На Вас наложены путы, вы не можете передвигатся...</b></font>";
$_GET['cp'] =0;
}
if($d[0] > get_meshok() && $_GET['bps']) {
echo "<font color=red><b>У вас переполнен рюкзак, вы не можете передвигатся...</b></font>";
$_GET['bps'] =0;
}
$eff = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$u['id']."' AND (`type` = 14 OR `type` = 13);"));
if($eff && $_GET['bps']) {
echo "<font color=red><b>У вас тяжелая травма, вы не можете передвигатся...</b></font>";
$_GET['bps'] =0;
}
$chain = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$u['id']."' AND (`type` = 10);"));
if($chain && $_GET['bps']) {
echo "<font color=red><b>На Вас наложены путы, вы не можете передвигатся...</b></font>";
$_GET['bps'] =0;
}

// при выходе из Алтаря предметов запоминаем время выхода, в след. раз только через час
if (isset($_GET['level9000']) && $user['room'] == '9001') {
    $znlv = mysql_result(mysql_query("SELECT last_visit FROM zn_tower WHERE user_id = " . $_SESSION['uid']), 0, 0);
    if ((time()-$znlv) > 3600*6) {
        mysql_query("UPDATE zn_tower SET last_visit = " . time() . " WHERE user_id = " . $user['id']);
    }
} 


  if ($_GET['got']) {
    $mt=canmove();
    if (!$mt) {
      $_GET['got'] =0;
    } else {
      $_SESSION['movetime']=time()+$mt;
      include_once("config/routes.php");
      if (WINTER) {
      } else {
        //unset($routes["45"][0]);
      }
      $gotoroom=0;
      foreach ($_GET as $k=>$v) {
        if (strpos($k,"level")===0) {
          $gotoroom=str_replace("level","",$k);
          break;
        }
      }
      if (@$routes[$user["room"]] && in_array($gotoroom, $routes[$user["room"]])) {
        if (incastle($gotoroom) && !incastle($user["room"])) {
          $s=mqfa1("select value from variables where var='siege'");
          if ($s<10) {
            $gotoroom=0;
            if ($user["room"]!=105) echo "<font color=red><b>Во время осады нельзя входить в замок.</b></font>";
            $warning="Во время осады нельзя входить в замок.";
          }
        } 
        if ($gotoroom) {
          if ($user["room"]==20) {
            if (haseffect($user["data"], MAKESNOWBALL)) mq("delete from effects where owner='$user[id]' and type=".MAKESNOWBALL);
          }
          gotoroom($gotoroom);
          $user["room"]=$gotoroom;
        }
      }
    }
    
  }


if ($user['room']==20) {
if ($_GET['got'] && $_GET['level1']) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '3',`online`.`room` = '3' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
$_SESSION['perehod']=0;
header('location: main.php?got=1&room3=1');
die();
}
		if ($_GET['got'] && $_GET['level7']) {
			header('location: city.php?strah=1');
		}
		if ($_GET['got'] && $_GET['level8']) {
			header('location: city.php?park=1');
		}
		if ($_GET['got'] && $_GET['level2']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '22',`online`.`room` = '22' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: shop.php');
		}
		if ($_GET['got'] && $_GET['level2222']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '2222',`online`.`room` = '2222' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: church.php');
		}
		if ($_GET['got'] && $_GET['level35000']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '700',`online`.`room` = '700' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: castle.php');
		}
		if ($_GET['got'] && $_GET['level455432545']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '11111',`online`.`room` = '11111' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: statues.php');
		}
		if ($_GET['got'] && $_GET['level455432546']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '24',`online`.`room` = '24' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: elka.php');
		}
		if ($_GET['got'] && $_GET['level7777']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '7777',`online`.`room` = '7777' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: lottery.php');
		}

		if ($_GET['got'] && $_GET['level7777']) {
			if ($user['level'] < 8000) {
				print "<script>alert('Временно не работает!')</script>";
			}
			else {
				mysql_query("UPDATE `users`,`online` SET `users`.`room` = '7777',`online`.`room` = '7777' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
				header('location: lottery.php');
			}
		}  

		if ($_GET['got'] && $_GET['level31']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '691',`online`.`room` = '691' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: daros.php');
		}
		if ($_GET['got'] && $_GET['level9000']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '9000',`online`.`room` = '9000' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: city.php?tower=1');
		}
		if ($_GET['got'] && $_GET['level5']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '692',`online`.`room` = '692' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: city.php');
		}
		if ($_GET['got'] && $_GET['level4']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '23',`online`.`room` = '23' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: repair.php');
		}
		if ($_GET['got'] && $_GET['level36']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '671',`online`.`room` = '671' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: casino.php');
		}
		if ($_GET['got'] && $_GET['level11']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '668',`online`.`room` = '668' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: zoo.php');
		}
		if ($_GET['got'] && $_GET['level3']) {
			if ($user['align'] == 4) {
				print "<script>alert('Хаосникам вход в комиссионный магазин запрещен!')</script>";
			}
			elseif ($user['level'] < 7) {
				print "<script>alert('Вход в комиссионный магазин только с 7 го уровня!')</script>";
			}
			else {
				mysql_query("UPDATE `users`,`online` SET `users`.`room` = '25',`online`.`room` = '25' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
				header('location: comission.php');
			}
		}
		if ($_GET['got'] && $_GET['level6']) {
			if ($user['level'] < 8) {
				print "<script>alert('Вход на почту только с 8 го уровня!')</script>";
			}
			else {
				mysql_query("UPDATE `users`,`online` SET `users`.`room` = '27',`online`.`room` = '27' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
				header('location: post.php');
			}
		}  






		if ($_GET['got'] && $_GET['level13']) {
			if ($user['level'] < 3) {
				print "<script>alert('Вход только с 3 го уровня!')</script>";
			}
			else {
				mysql_query("UPDATE `users`,`online` SET `users`.`room` = '876',`online`.`room` = '876' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
				header('location: elka.php');
			}
		}





		if ($_GET['got'] && $_GET['room666']) {
			header('location: jail.php');
		}
		if ($_GET['got'] && $_GET['room667']) {
			header('location: bar.php');
		}
		if ($_GET['got'] && $_GET['level35']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '5000',`online`.`room` = '5000' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: butik.php');
		}
		if ($_GET['got'] && $_GET['level130000']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '100100',`online`.`room` = '100100' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: stella.php');
		}
		//if ($_GET['got'] && $_GET['level21']) {
			//mysql_query("UPDATE `users`,`online` SET `users`.`room` = '100101',`online`.`room` = '100101' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			//header('location: stella.php');
		//}

	}
	elseif($user['room']==21) {
		if ($_GET['got'] && $_GET['level4']) {
			header('location: city.php?cp=1');
		}
		if ($_GET['got'] && $_GET['level650']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '650',`online`.`room` = '650' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: city.php?torg=1');
		}
		if ($_GET['got'] && $_GET['level5']) {
			if (($user['level'] < '4') OR $user['level']>8) {
				print "<script>alert('Вход в подземелье только с 4 лвл! Либо вы выросли для посещения данного места.')</script>";
			}
			else {
				mysql_query("UPDATE `users`,`online` SET `users`.`room` = '402',`online`.`room` = '402' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
				header('location: post.php');
			}
		}
		if ($_GET['got'] && $_GET['level6']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '34',`online`.`room` = '34' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: fshop.php');
		}
		if ($_GET['got'] && $_GET['level12']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '29',`online`.`room` = '29' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: bank.php');
		}
		if ($_GET['got'] && $_GET['level10']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '35',`online`.`room` = '35' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: berezka.php');
		}
		if ($_GET['got'] && $_GET['level33']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '105',`online`.`room` = '105' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: obshaga.php');
		}
		if ($_GET['got'] && $_GET['level2']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '28',`online`.`room` = '28' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: klanedit.php');
		}
		if ($_GET['got'] && $_GET['level7']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '31',`online`.`room` = '31' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: tower.php');
		}

		//if ($_GET['got'] && $_GET['level7']) {
			//if (($user['level'] < '50') OR $user['level']>80000) {
				//print "<script>alert('БС откроется завтра!!!')</script>";
			//}
			//else {
				//mysql_query("UPDATE `users`,`online` SET `users`.`room` = '31',`online`.`room` = '31' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
				//header('location: tower.php');
			//}
		//}


		if ($_GET['got'] && $_GET['level1']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '1211',`online`.`room` = '1211' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: kladb.php');
		}
		if ($_GET['got'] && $_GET['level3300000']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '6002',`online`.`room` = '6002' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: craft.php');
		}
		if ($_GET['got'] && $_GET['level38']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '690',`online`.`room` = '690' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: pole.php');
		}
		if ($_GET['got'] && $_GET['level12000']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '3701',`online`.`room` = '3701' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: elrona.php');
		}
		if ($_GET['got'] && $_GET['level11']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '42',`online`.`room` = '42' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: lotery.php');
		}
		if ($_GET['got'] && $_GET['level684']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '684',`online`.`room` = '684' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: mines.php');
		}
		if ($_GET['got'] && $_GET['level2000']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '2000',`online`.`room` = '2000' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: boloto_vxod.php');
		}


	}

elseif($user['room']==670) {
if ($_GET['got'] && $_GET['level4']) {
header('location: city.php?park=1');
}
if ($_GET['got'] && $_GET['level7']) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '60',`online`.`room` = '60' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
header('location: cave.php');
}
if ($_GET['got'] && $_GET['level5']) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '56',`online`.`room` = '56' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
header('location: cave.php');
}
if ($_GET['got'] && $_GET['level47']) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '90',`online`.`room` = '90' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
header('location: cave.php');
}
if ($_GET['got'] && $_GET['level48']) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '64',`online`.`room` = '64' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
header('location: cave.php');
}
//if ($_GET['got'] && $_GET['level10']) {
//mysql_query("UPDATE `users`,`online` SET `users`.`room` = '58',`online`.`room` = '58' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
//header('location: pklad.php');
//}

if ($_GET['got'] && $_GET['level10']) {
if (($user['login'] != 'Support' && $user['level'] < '4') OR ($user['level']>150 && $user["align"]!="2.5" && $user["align"]!="2.9")) {
print "<script>alert('Вход в Поле Кладоискателей с 4 уровня !')</script>";
}else {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '58',`online`.`room` = '58' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
header('location: pklad.php');
}
}
		if ($_GET['got'] && $_GET['level8']) {
			if (($user['level'] < '5') OR $user['level']>11) {
				print "<script>alert('Вход в грибницу только с 5 лвл! Либо вы выросли для посещения данного места.')</script>";
			}
			else {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '698',`online`.`room` = '698' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: vxodg.php');
			}
		}

}

elseif($user['room']==9000) {
if ($_GET['got'] && $_GET['level1']) {
header('location: city.php?tower=1');
}
if ($_GET['got'] && $_GET['level9000']) {
header('location: dialog.php?char=20136');
}
if ($_GET['got'] && $_GET['level9001']) {
//$isEnter = mysql_fetch_array(mq("SELECT * FROM `zn_tower` WHERE `user_id` = '{$_SESSION['uid']}' LIMIT 1;"));
//$isEnter = mysql_result(mq("SELECT COUNT(*) FROM zn_tower WHERE user_id = $user[id] && reputation > 0"), 0, 0);
//if ($isEnter['reputation']==0) {
//print "<script>alert('Сперва Вам следует обратиться к Хранителю Знаний')</script>";
//header('location: dialog.php?char=20136');
//}else {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '9001',`online`.`room` = '9001' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
header('location: zn_tower.php');
//}
}
if ($_GET['got'] && $_GET['level9002']) {
print "<script>alert('Алтарь рун пока не работает')</script>";
}
if ($_GET['got'] && $_GET['level20']) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '20',`online`.`room` = '20' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
header('location: city.php?cp=1');
}
}
	elseif($user['room']==692) {

		if ($_GET['got'] && $_GET['level1']) {
			header('location: city.php?cp=1');
		}


					if ($_GET['got'] && $_GET['level1']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '20',`online`.`room` = '20' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: city.php');
		}
					if ($_GET['got'] && $_GET['level2']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '693',`online`.`room` = '693' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: city.php');
		}


	}

	elseif($user['room']==693) {

		if ($_GET['got'] && $_GET['level1']) {
			header('location: city.php?zalcer=1');
		}


					if ($_GET['got'] && $_GET['level1']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '692',`online`.`room` = '692' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: city.php');
		}
					if ($_GET['got'] && $_GET['level299']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '981',`online`.`room` = '981' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: brakshop.php');
		}
					if ($_GET['got'] && $_GET['level2']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '694',`online`.`room` = '694' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: xram.php');
		}



	}


elseif($user['room']==393) {
if ($_GET['got'] && $_GET['level1']) {
header('location: city.php?hill=1');
}
if ($_GET['got'] && $_GET['level2']) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '650',`online`.`room` = '650' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
header('location: city.php');
}
if ($_GET['got'] && $_GET['level3']) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '82',`online`.`room` = '82' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
header('location: cave.php');
}
}

	elseif($user['room']==700000) {

		if ($_GET['got'] && $_GET['level1']) {
			header('location: city.php?altar=1');
		}


					if ($_GET['got'] && $_GET['level1']) {
			if (($user['altar'] < '1') OR $user['altar']>100) {
				print "<script>alert('Вы не выполнили квест Арквиерро!')</script>";
			}
			else {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '700001',`online`.`room` = '700001' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: iqtower.php');
		}
		}
					if ($_GET['got'] && $_GET['level5']) {
			if ($user['reputxz']==0) {
				print "<script>alert('Вы не выполнили квест Арквиерро!')</script>";
			}
			else {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '700001',`online`.`room` = '700001' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: iqtower.php');
		}
		}
					if ($_GET['got'] && $_GET['level2']) {
			if ($user['reputxz']==0) {
				print "<script>alert('Вы не выполнили квест Арквиерро!')</script>";
			}
			else {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '700002',`online`.`room` = '700002' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: iqtower2.php');
		}
		}
					if ($_GET['got'] && $_GET['level3']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '700003',`online`.`room` = '700003' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: dialog_arcvierro.php');
		}
					if ($_GET['got'] && $_GET['level4']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '660',`online`.`room` = '660' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: city.php?park=1');
		}



	}

elseif($user['room']==800000) {
if ($_GET['got'] && $_GET['level1']) {
header('location: city.php?sklon=1');}
if ($_GET['got'] && $_GET['level2']) {
if (($user['login'] != 'Support' && $user['level'] < '4') OR ($user['level']>150 && $user["align"]!="2.5" && $user["align"]!="2.9")) {
print "<script>alert('Вход в водосток только с 4 лвл! Либо вы выросли для посещения данного места.')</script>";
}else {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '402',`online`.`room` = '402' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
header('location: post.php');
}
}
if ($_GET['got'] && $_GET['level3']) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '77',`online`.`room` = '77' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
header('location: cave.php');
}
if ($_GET['got'] && $_GET['level4']) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '650',`online`.`room` = '650' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
header('location: city.php?torg=1');
}
if ($_GET['got'] && $_GET['level5']) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '73',`online`.`room` = '73' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
header('location: cave.php');
}
if ($_GET['got'] && $_GET['level6']) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '75',`online`.`room` = '75' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
header('location: cave.php');
}
if ($_GET['got'] && $_GET['level7']) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '800000',`online`.`room` = '800000' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
header('location: city.php');
}
}

elseif($user['room']==660) {

		if ($_GET['got'] && $_GET['level1']) {
			header('location: city.php?park=1');
		}
			if ($_GET['got'] && $_GET['level1']) {
	                                           $skam1=mysql_num_rows(mysql_query("SELECT id from online where room=200001"));
		                      if($skam1>2){
                                                                 print "<script>alert('Двое уже уединились. Подыщите другую скамейку.')</script>";
			 }
			else{
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '200001',`online`.`room` = '200001' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: skam_small.php');
		}
                                           }
			if ($_GET['got'] && $_GET['level8']) {
	                                           $skam1=mysql_num_rows(mysql_query("SELECT id from online where room=200001"));
		                      if($skam1>2){
                                                                 print "<script>alert('Двое уже уединились. Подыщите другую скамейку.')</script>";
			 }
			else{
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '200001',`online`.`room` = '200001' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: skam_small.php');
		}
                                           }
			if ($_GET['got'] && $_GET['level9']) {
	                                           $skam2=mysql_num_rows(mysql_query("SELECT id from online where room=200002"));
		                      if($skam2>4){
                                                                 print "<script>alert('На скамейке больше нет места. Подыщите другую скамейку.')</script>";
			 }
			else{
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '200002',`online`.`room` = '200002' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: skam_medium.php');
		}
		}
			if ($_GET['got'] && $_GET['level10']) {
	                                           $skam3=mysql_num_rows(mysql_query("SELECT id from online where room=200003"));
		                      if($skam3>7){
                                                                 print "<script>alert('На скамейке больше нет места. Подыщите другую скамейку.')</script>";
			 }
			else{
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '200003',`online`.`room` = '200003' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: skam_large.php');
		}
		}
			if ($_GET['got'] && $_GET['level3']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '670',`online`.`room` = '670' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: city.php?bps=1');
		}
			if ($_GET['got'] && $_GET['level51']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '51',`online`.`room` = '51' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: vxod.php');
		}
			if ($_GET['got'] && $_GET['level54']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '54',`online`.`room` = '54' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: city.php?altar=1');
		}
			if ($_GET['got'] && $_GET['level55']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '37',`online`.`room` = '37' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: shop.php');
		}
			if ($_GET['got'] && $_GET['level4']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '20',`online`.`room` = '20' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: city.php?cp=1');
		}



	}

	elseif($user['room']==650) {

		if ($_GET['got'] && $_GET['level1']) {
			header('location: city.php?torg=1');
		}
		                                                                 if ($_GET['got'] && $_GET['level3']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '42',`online`.`room` = '42' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: auction.php');
		}
		                                                                if ($_GET['got'] && $_GET['level9']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '59',`online`.`room` = '59' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: shop.php');
		}

if ($_GET['got'] && $_GET['level2']) {
if (($user['login'] != 'Support' && $user['level'] < '8') OR ($user['level']>150 && $user["align"]!="2.5" && $user["align"]!="2.9")) {
print "<script>alert('Вход только с 8-го уровня.')</script>";
}else {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '71',`online`.`room` = '71' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
header('location: battleenter.php');
}
}

		                                                                 if ($_GET['got'] && $_GET['level5']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '62',`online`.`room` = '62' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: battleenter.php');
		}
        if ($_GET['got'] && $_GET['level11']) {
            mysql_query("UPDATE `users`,`online` SET `users`.`room` = '668',`online`.`room` = '668' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
            header('location: zoo.php');
        }
					if ($_GET['got'] && $_GET['level7']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '800000',`online`.`room` = '800000' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: city.php?sklon=1');
		}
					if ($_GET['got'] && $_GET['level54']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '393',`online`.`room` = '393' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: city.php?hill=1');
		}
					if ($_GET['got'] && $_GET['level4']) {
			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '21',`online`.`room` = '21' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: city.php?strah=1');
		}



	}

elseif($user['room']==684 && $_GET['got'] && $_GET['level7']) {

			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '685',`online`.`room` = '685' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: undershop.php');
		
	}
elseif($user['room']==685 && $_GET['got'] && $_GET['level684']) {

			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '684',`online`.`room` = '684' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: mines.php');

	}
elseif($user['room']==2000 && $_GET['got'] && $_GET['level2000']) {

			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '2000',`online`.`room` = '2000' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: boloto_vxod.php');
		
	}
elseif($user['room']==209 && $_GET['got'] && $_GET['level10']) {

			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '209',`online`.`room` = '209' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: obraz.php');
		
	}

elseif($user['room']==684 && $_GET['got'] && $_GET['level8']) {

			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '686',`online`.`room` = '686' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: cshop.php');
}

elseif($user['room']==686  && $_GET['level684']) {

			mysql_query("UPDATE `users`,`online` SET `users`.`room` = '684',`online`.`room` = '684' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
			header('location: mines.php');
		
	}
 //elseif ($user["room"]!=9000) echo "<script>document.location.replace('main.php".($warning?"?warning=$warning":"")."');</script>";

?>
<HTML>
<HEAD>
<script LANGUAGE='JavaScript'> 
document.ondragstart = test;
document.oncontextmenu = test;
function test() {
 return false
}
</SCRIPT>
<link rel=stylesheet type="text/css" href="i/main.css">
<link href="i/move/design6.css" rel="stylesheet" type="text/css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<META HTTP-EQUIV="imagetoolbar" CONTENT="no">
<style type="text/css">img.aFilter {filter: Glow(color = d7d7d7, Strength = 4, Enabled = 0);cursor: hand}hr {height: 1px;}</style>
<SCRIPT LANGUAGE="JavaScript">
function findlogin(title, script, name){
document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
'<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><form action="'+script+'" method=POST><INPUT TYPE=hidden name=sd4 value="6"><td colspan=2>'+
'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD width=50% align=right><INPUT TYPE=text NAME="'+name+'"></TD><TD width=50%><INPUT TYPE="submit" value=" »» "></TD></TR></FORM></TABLE></td></tr></table>';
document.all("hint3").style.visibility = "visible";
document.all("hint3").style.left = 470;
document.all("hint3").style.top = 230;
document.all(name).focus();
Hint3Name = name;
}
function closehint3(){
document.all("hint3").style.visibility="hidden";
Hint3Name='';
}
var solo_store;
function solo(n, name, instant) {
if (instant!="" || check_access()==true) {
window.location.href = '?got=1&level'+n+'=1&rnd='+Math.random();
} else if (name && n) {
solo_store = n;
var add_text = (document.getElementById('add_text') || document.createElement('div'));
add_text.id = 'add_text';
add_text.innerHTML = 'Вы перейдете в: <strong>' + name +'</strong> (<a href="#" onclick="return clear_solo();">отмена</a>)';
document.getElementById('ione').parentNode.parentNode.nextSibling.firstChild.appendChild(add_text);
ch_counter_color('red');
}
return false;
}
function clear_solo () {
document.getElementById('add_text').removeNode(true);
solo_store = false;
ch_counter_color('#00CC00');
return false;
}
var from_map = false;
function imover(im) {
if( im.filters )
im.filters.Glow.Enabled=true;
if ( from_map == false && im.id.match(/mo_(\d)/) && document.getElementById('b' + im.id)) {
from_map = true;
if( document.getElementById('b' + im.id).runtimeStyle )
document.getElementById('b' + im.id).runtimeStyle.color = '#666666';
from_map = false;
}
}
function imover2(im) {
if( im.filters ){
if( im.filters.Glow.Enabled==true ){
im.filters.Glow.Enabled=false;
}else{
im.filters.Glow.Enabled=true;
}
}
}
function highlight(){
im=$(".aFilter");
$(".aFilter").each(
function(index){
imover2(this);
});
}
function imout(im) {
if( im.filters )
im.filters.Glow.Enabled=false;
if ( from_map == false && im.id.match(/mo_(\d)/) && document.getElementById('b' + im.id)) {
from_map = true;
if( document.getElementById('b' + im.id).runtimeStyle )
document.getElementById('b' + im.id).runtimeStyle.color = document.getElementById('b' + im.id).style.color;
from_map = false;
}
}
function bimover (im) {
if ( from_map==false && document.getElementById(im.id.substr(1)) ) {
from_map = true;
imover(document.getElementById(im.id.substr(1)));
from_map = false;
}
}
function bimout (im) {
if ( from_map==false && document.getElementById(im.id.substr(1)) ) {
from_map = true;
imout(document.getElementById(im.id.substr(1)));
from_map = false;
}
}
function bsolo (im) {
if (document.getElementById(im.id.substr(1))) {
document.getElementById(im.id.substr(1)).click();
}
return false;
}
function fullfastshow(a,b,c,d,e,f){if(typeof b=="string")b=a.getElementById(b);var g=c.srcElement?c.srcElement:c,h=g;c=g.offsetLeft;for(var j=g.offsetTop;h.offsetParent&&h.offsetParent!=a.body;){h=h.offsetParent;c+=h.offsetLeft;j+=h.offsetTop;if(h.scrollTop)j-=h.scrollTop;if(h.scrollLeft)c-=h.scrollLeft}if(d!=""&&b.style.visibility!="visible"){b.innerHTML="<small>"+d+"</small>";if(e){b.style.width=e;b.whiteSpace=""}else{b.whiteSpace="nowrap";b.style.width="auto"}if(f)b.style.height=f}d=c+g.offsetWidth+10;e=j+5;if(d+b.offsetWidth+3>a.body.clientWidth+a.body.scrollLeft){d=c-b.offsetWidth-5;if(d<0)d=0}if(e+b.offsetHeight+3>a.body.clientHeight+a.body.scrollTop){e=a.body.clientHeight+ +a.body.scrollTop-b.offsetHeight-3;if(e<0)e=0}b.style.left=d+"px";b.style.top=e+"px";if(b.style.visibility!="visible")b.style.visibility="visible"}function fullhideshow(a){if(typeof a=="string")a=document.getElementById(a);a.style.visibility="hidden";a.style.left=a.style.top="-9999px"}
function gfastshow(dsc, dx, dy) { fullfastshow(document, mmoves3, window.event, dsc, dx, dy); }
function ghideshow() { fullhideshow(mmoves3); }
function Down() {top.CtrlPress = window.event.ctrlKey}
document.onmousedown = Down;
</SCRIPT>
</HEAD>
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor="#d7d7d7" onLoad="top.setHP(<?=$user['hp']?>,<?=$user['maxhp']?>,<?if (!$user['battle']){echo"10";}else{echo"0";}?>)">
<div id="mmoves3" style="background-color:#FFFFCC; visibility:hidden; z-index: 101; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px;"></div>
<?
if($_GET['nap']=="attack" && $user['room']==20){include "magic/cityattack.php";}
?>
<div id=hint3 class=ahint></div>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<TR>
<TD valign=top align=left width=250>
<?=showpersout($_SESSION['uid'])?>
</TD>
<TD valign=top align=right>
<IMG SRC=i/1x1.gif WIDTH=1 HEIGHT=5><BR>
<table  border="0" cellpadding="0" cellspacing="0">
<tr align="right" valign="top">
<td>
<TABLE width=100% height=100% border=0 cellspacing="0" cellpadding="0">
<TR><TD align=right colspan=2>
<div align=right id=per></div>        

<?
  include_once("questfuncs.php");
  if (0) {
    if (@$_GET["attackevil"]) {
      battlewithbot(1796, "Горный демон", "Защита города", "20", 1);
    }
    echo "</td><td width=\"230\" valign=\"top\"><img src=\"".IMGBASE."i/empty.gif\" width=\"230\" height=\"1\">
    Настало время нанести ответный удар по демонам! Сколько ещё будем терпеть их нападения?!
    Надо всем вместе напасть на их лагерь и убить всех до единого!<br><br>
    <a href=\"main.php?got=1&room=44\">Смело мы в бой пойдём!</a>
    </td>";
  } elseif ($user["room"]==660 && $_GET["findgrass"]) {
    echo "</td><td width=\"230\" valign=\"top\"><br />
    <img src=\"".IMGBASE."/i/empty.gif\" width=\"230\" height=\"1\">";
    echo "<div style=\"padding:10px\">".cutgrass(2)."</div>";
  } elseif ($user["room"]==660 && $_GET["findgrass2"]) {
    include "functions/cutgrass2.php";
    echo "</td><td width=\"230\" valign=\"top\"><br />
    <img src=\"".IMGBASE."/i/empty.gif\" width=\"230\" height=\"1\">";
    echo "<div style=\"padding:10px\">".cutgrass2(2)."</div>";
  } elseif ($user["room"]==660 && $_GET["hunt"] && WINTER && 0) {
    if (canmakequest(10)) {
      battlewithbot(4793, "Серый Волк", "Охота", 10, 0, 1, 0,0);
    } else {
      echo "<div style=\"padding:10px\">
      Вы ещё недостаточно отдохнули после предыдущей охоты.
      Отдохните ещё минимум ".ceil($questtime/60)." мин.
      </div>";
    }
  } elseif ($user['room'] == 210101010101010 && canmakequest(1) && $user["id"]!=4101010101010849) {
    if (@$_GET["openchest"]) {
      if (!placeinbackpack(1)) {
        echo "<center><b><font color=red>У вас недостаточно места в рюкзаке.</font></b></center>";
      } else {
        $rnd=rand(0,1);
        if (LETTERQUEST) {
          $taken=takesmallitem(60);
        } else {
          if ($rnd==1) {
            $rnd=rand(2,6);
            $taken=takeitem($rnd);
          } else {
            $rnd=rand(1,8);
            $taken=takesmallitem($rnd);
          }
        }
        makequest(1);
        $rand=rand(1,3);
        echo "</td><td width=\"230\" valign=\"top\"><br />
        <img src=\"".IMGBASE."/i/empty.gif\" width=\"230\" height=\"1\">";
        echo "<div style=\"padding:10px\">В сундучке вы обнаружили $taken[name] и ".($rand*0.5)." кр.<br><br>
        <center><img src=\"".IMGBASE."/i/sh/$taken[img]\"></center><br>
        Приходите через 24 часа за новым подарком.
        </div>";
        mq("update users set money=money+".($rand*0.5)." where id='$_SESSION[uid]'");
      }
    } else {
      echo "<div style=\"padding:10px\">Посередине площади расположен сундук мироздателя, в котором раз в день можно получить небольшой подарочек.</div>
      <center><a href=\"$_SERVER[PHP_SELF]?openchest=1\"><img border=\"0\" src=\"".IMGBASE."/img/podzem/2.gif\"></a></center>";
    }
    echo "</td>";
  }
  ?>
<?
if ($user['room'] == 20) {
	if((int)date("H") > 6 && (int)date("H") < 22) {
		$fon = 'cp';

	} else {
		$fon = 'cpnight';

	}
echo "<table width=1><tr><td><div style=\"position:relative; cursor: pointer;\" id=\"ione\"><img src=\"img/city/",$fon,".jpg\" id=\"img_ione alt=\"\" border=\"0\"/>";
buildset(1,"bk",17,142,"Бойцовский клуб");
buildset(2,"shop",135,157,"Магазин");
buildset(3,"comission",143,50,"Комисионка");
buildset(4,"repair",140,213,"Ремонтная мастерская");
buildset(6,"post",130,300,"Почта"); 
buildset(455432545,"2pm",150,165,"Памятник Ангела", '', 'Закрыто');
//buildset(455432546,"sn_ton",155,200,"Новогодняя елка");
buildset(9000,"xram",150,257,"Храм"); 
buildset(35000,"vokzal",134,74,"Вокзал");
//buildset(130000,"stella",150,90,"Стелла");
buildset(7777,"loto",107,376,"Лотерея",  '', 'Лотерея на данный момент не работает!');
buildset(2222,"optovii",159,384,"Оптовый магазин", '', 'Для Вас вход закрыто!');
buildset(8,"left",153,16,"Парк Развлечений");
buildset(7,"right",153,446,"Страшилкина улица");
$hinttop=18;
$hintright=113;
//if (WINTER) echo "<div id=\"snow\"></div><script src=\"i/js/snow.js\"></script>";
}
elseif ($user['room'] == 9000) {
echo "<table width=1><tr><td><div style=\"position:relative; cursor: pointer; width: 550px; text-align: right;\" id=\"ione\"><img src=\"".IMGBASE."/img/city/hram-bg_.gif\" alt=\"\" border=\"0\"/>";
buildset(9000,"hram-bot",38,270,"Хранитель Знаний");
buildset(9001,"hram-altar-left",82,101,"Алтарь предметов"); 
buildset(9002,"hram-altar-right",94,361,"Алтарь рун");
buildset(20,"hram-exit",55,350,"Центральная площадь");
$locs[]=array("name"=>"$rooms[9001]", "img"=>"hram-altar-left","x"=>101, "y"=>82, "room"=>"9001", "link"=>"zn_tower.php");
foreach ($locs as $k=>$v) {
buildset($v["room"],$v["img"],$v["y"],$v["x"],$v["name"], @$v["link"]);
$hinttop=18;
$hintright=113;
if (WINTER) echo "<div id=\"snow\"></div><script src=\"i/js/snows.js\"></script>";
}

}
elseif ($user['room'] == 21) {
	if((int)date("H") > 6 && (int)date("H") < 22) {
		$fon = 'losttown001_1';

	} else {
		$fon = 'strahnight';

	}
echo "<table width=1><tr><td><div style=\"position:relative; cursor: pointer;\" id=\"ione\"><img src=\"img/city/",$fon,".jpg\" id=\"img_ione alt=\"\" border=\"0\"/>";
buildset(33,"obshaga",77,31,"Общежитие");
buildset(2,"clanreg",99,118,"Регистратура кланов");
buildset(7,"tower",3,190,"Башня смерти");
buildset(12,"bank",112,282,"Банк");
buildset(10,"euroshop",132,367,"Магазин Берёзка");
buildset(6,"fshop",145,102,"Цветочный магазин");
buildset(4,"left",150,16,"Центральная площадь");
buildset(650,"right",150,442,"Большая Торговая Улица");


$hinttop=18;
$hintright=113;
if (WINTER) echo "<div id=\"snow\"></div><script src=\"i/js/snows.js\"></script>";
}
elseif ($user['room'] == 800000) {
	if((int)date("H") > 6 && (int)date("H") < 22) {
		$fon = 'losttown001_1';

	} else {
		$fon = 'strahnight';

	}
echo "<table width=1><tr><td><div style=\"position:relative; cursor: pointer;\" id=\"ione\"><img src=\"img/city/",$fon,".jpg\" id=\"img_ione alt=\"\" border=\"0\"/>";
buildset(4,"left",183,5,"Большая Торговая Улица");
buildset(5,"temple_of_darkness",77,5,"Катакомбы");
buildset(3,"temple_street_110_stella",43,147,"Сторожевая Башня");
buildset(6,"temple_of_balance",125,260,"Потерянный вход");
buildset(2,"temple_of_light",102,410,"Вход в водосток");
buildset(7,"noway",185,455,"Проход закрыт");
$hinttop=18;
$hintright=113;
if (WINTER) echo "<div id=\"snow\"></div><script src=\"i/js/snows.js\"></script>";
}
elseif ($user['room'] == 670) {
	if((int)date("H") > 6 && (int)date("H") < 22) {
		$fon = 'losttown001_1';

	} else {
		$fon = 'strahnight';

	}
echo "<table width=1><tr><td><div style=\"position:relative; cursor: pointer;\" id=\"ione\"><img src=\"img/city/",$fon,".jpg\" id=\"img_ione alt=\"\" border=\"0\"/>";
buildset(5,"cap_rune_temple_US",135,380,"Вход в Пещеру кристаллов");
  if ($user['level'] <400) {
      buildset(10,"cursed_hole",128,100,"Поле Кладоискателей");
    } else 
       buildset(10,"cursed_hole",128,100,"Поле Кладоискателей");
//buildset(47,"left",183,5,"Ледяная пещера");
//buildset(48,"strelka",155,30,"Пещера Загадок");
//buildset(8,"sn_dung",120,50,"Грибница");
buildset(48,"left",183,5,"Пещера Загадок");
buildset(4,"right",185,455,"Парк Развлечений");
buildset(7,"chaos_shop_fs",135,250,"Заброшенный дворец");
$hinttop=18;
$hintright=113;
if (WINTER) echo "<div id=\"snow\"></div><script src=\"i/js/snows.js\"></script>";
}
elseif ($user['room'] == 660) {
	if((int)date("H") > 6 && (int)date("H") < 22) {
		$fon = 'u2bg';

	} else {
		$fon = 'cap_bg_lunapark';

	}
echo "<table width=1><tr><td><div style=\"position:relative; cursor: pointer;\" id=\"ione\"><img src=\"img/city/",$fon,".jpg\" id=\"img_ione alt=\"\" border=\"0\"/>";
buildset(8,"skam_small",170,347,"Маленькая Скамейка");
buildset(9,"skam_medium",172,78,"Средняя Скамейка");
buildset(10,"skam_large",176,385,"Большая Скамейка");
//buildset(51,"hell_en",200,80,"Пещера Ужаса");
//buildset(54,"strelka",155,30,"Пещера Алхимика");
//buildset(55,"strelka",155,30,"Старинный Магазин");
//buildset(3,"left",180,15,"Новая Земля");
buildset(4,"right",150,440,"Центральная площадь");
$hinttop=18;
$hintright=113;
if (WINTER) echo "<div id=\"snow\"></div><script src=\"i/js/snows.js\"></script>";
}
elseif ($user['room'] == 650) {
	if((int)date("H") > 6 && (int)date("H") < 22) {
		$fon = 'bg_trade_street_day';

	} else {
		$fon = 'strahnight';

	}
echo "<table width=1><tr><td><div style=\"position:relative; cursor: pointer;\" id=\"ione\"><img src=\"img/city/",$fon,".jpg\" id=\"img_ione alt=\"\" border=\"0\"/>";

buildset(5,"ts_portal",100,315,"Портал");
buildset(11,"zooshop",111,260,"Зоомагазин");
buildset(4,"left",180,15,"Страшилкина улица");
buildset(54,"strelka",155,30,"Проклятый Холм");
buildset(2,"court",95,390,"Здание Суда",  '', 'Здание Суда закрыто на ремонт!');
buildset(9,"bookshop",140,57,"Книжный магазин");
buildset(3,"auction",90,110,"Аукцион",  '', 'Аукцион на реконструкции!');
buildset(7,"right",150,450,"Улица Вязов");
$hinttop=18;
$hintright=113;
if (WINTER) echo "<div id=\"snow\"></div><script src=\"i/js/snows.js\"></script>";
}
elseif ($user['room'] == 62) {
	if((int)date("H") > 6 && (int)date("H") < 22) {
		$fon = 'Moon_magic_portal2';

	} else {
		$fon = 'Moon_magic_portal2';

	}
echo "<table width=1><tr><td><div style=\"position:relative; cursor: pointer;\" id=\"ione\"><img src=\"i/city/",$fon,".jpg\" id=\"img_ione alt=\"\" border=\"0\"/>";

buildset(650,"mn_dun_telep_exit",220,450,"Большая Торговая Улица");
//buildset(11,"zooshop",111,260,"Зоомагазин");
//buildset(4,"left",180,15,"Страшилкина улица");
///buildset(54,"strelka",155,30,"Проклятый Холм");
//buildset(2,"court",95,390,"Здание Суда",  '', 'Здание Суда закрыто на ремонт!');
//buildset(9,"bookshop",140,57,"Книжный магазин");
//buildset(3,"auction",90,110,"Аукцион",  '', 'Аукцион на реконструкции!');
///buildset(7,"right",150,450,"Улица Вязов");
$hinttop=18;
$hintright=113;
if (WINTER) echo "<div id=\"snow\"></div><script src=\"i/js/snows.js\"></script>";
}
elseif ($user['room'] == 393) {
echo "<table width=1><tr><td><div style=\"position:relative; cursor: pointer;\" id=\"ione\"><img src=\"img/city/city_weird_hill_day.jpg\" alt=\"\" border=\"0\"/>";
buildset(3,"Ruiny_Dung_Day",20,100,"Бездна");
buildset(2,"cap_down_arrow",210,455,"Большая Торговая Улица");
$hinttop=18;
$hintright=113;
if (WINTER) echo "<div id=\"snow\"></div><script src=\"i/js/snows.js\"></script>";
}
elseif ($user["room"]==54) {
  function checkalchlevel() {
    global $user;
    $cnt=mqfa1("select sum(koll) from inventory where name='Страница книги алхимии' and owner='$user[id]' and setsale=0");
    if ($user["alchemy"]>=50 && $user["alchemylevel"]==0) adduserdata("alchemylevel", 1);
    elseif ($user["alchemy"]>=100 && $user["alchemylevel"]==1 && $cnt>=50) {
      takesmallitems("Страница книги алхимии", 50, $user["id"]);
      adduserdata("alchemylevel", 1);
    } elseif ($user["alchemy"]>=200 && $user["alchemylevel"]==2 && $cnt>=100) {
      takesmallitems("Страница книги алхимии", 100, $user["id"]);
      adduserdata("alchemylevel", 1);
    } elseif ($user["alchemy"]>=400 && $user["alchemylevel"]==3 && $cnt>=200) {
      takesmallitems("Страница книги алхимии", 200, $user["id"]);
      adduserdata("alchemylevel", 1);
    } elseif ($user["alchemy"]>=600 && $user["alchemylevel"]==4 && $cnt>=300) {
      takesmallitems("Страница книги алхимии", 300, $user["id"]);
      adduserdata("alchemylevel", 1);
    } elseif ($user["alchemy"]>=1000 && $user["alchemylevel"]==5 && $cnt>=400) {
      takesmallitems("Страница книги алхимии", 400, $user["id"]);
      adduserdata("alchemylevel", 1);
    } elseif ($user["alchemy"]>=1500 && $user["alchemylevel"]==6 && $cnt>=500) {
      takesmallitems("Страница книги алхимии", 500, $user["id"]);
      adduserdata("alchemylevel", 1);
    } elseif ($user["alchemy"]>=2000 && $user["alchemylevel"]==7 && $cnt>=600) {
      takesmallitems("Страница книги алхимии", 600, $user["id"]);
      adduserdata("alchemylevel", 1);
    } elseif ($user["alchemy"]>=3000 && $user["alchemylevel"]==8 && $cnt>=700) {
      takesmallitems("Страница книги алхимии", 700, $user["id"]);
      adduserdata("alchemylevel", 1);
    } elseif ($user["alchemy"]>=5000 && $user["alchemylevel"]==9 && $cnt>=1000) {
      takesmallitems("Страница книги алхимии", 1000, $user["id"]);
      adduserdata("alchemylevel", 1);
    }
  }
  if (@$_GET["alh"]) {
    $tigel=mqfa("select id, prototype from inventory where (prototype=1901 or prototype=2313 or prototype=2314) and owner='$user[id]' and duration<maxdur order by prototype desc");
    if (!$tigel) {
      echo "<font color=red><b>Для приготовления зелий вам необходим тигель.</b></font><br>";
      $_GET["alh"]=0;
    }
    $i=mqfa1("select id from inventory where name='Бутылка' and owner='$user[id]'");
    if (!$i) {
      echo "<font color=red><b>Для приготовления зелий вам необходима бутылка.</b></font><br>";
      $_GET["alh"]=0;
    }
    if (!canmakequest(16)) {
      echo "<font color=red><b>Вам необходим отдых после последней работы.</b></font><br>";
      $_GET["alh"]=0;
    }
    if ($tigel["prototype"]==1901) $failchance=30;
    elseif ($tigel["prototype"]==2313) $failchance=25;
    elseif ($tigel["prototype"]==2314) $failchance=20;
  }
  if (@$_GET["book"]==1) {
    echo "<div style=\"width:650px;text-align:justify\"><br><center><b>Книга начинающего алхимика.</b></center><br>
    <div style=\"padding-right:10px\">
    &nbsp;&nbsp;&nbsp;Искусство алхимии - это искусство варить зелья, дающие воинам разные дополнительные способности в боях. Для приготовления зелий
    необходимы различные травы.<br>
    &nbsp;&nbsp;&nbsp;Варить зелья надо осторожно, попытка создать слишком сложный эликсир или из неправильных компонентов может привести к печальным последствиям.
    Впрочем, бывали случаи, что даже слабые алхимики варили довольно сложные зелья, но ещё больше случаев, когда всё заканчивалось печально.<br>
    &nbsp;&nbsp;&nbsp;Нередко зелье не удаётся создать даже тогда, когда количество трав не превышает способности алхимика, но зелье по крайней мере не взрывается.
    Любой начинающий алхимик может без труда использовать три основные алхимические травы - корень нирина, листья примулы и цветок алканы,
    и может создавать эликсиры, в которые входит не более трёх трав. Корень нирина и листья примулы используются, чтобы ускорить движения
    воинов в боях. У каждой травы своя уникальная сущность, поэтому зелья, в которых исползуюся разные травы, нестабильные.
    Чтобы погасить этот эффект, необходимо использовать цветок алканы, который сам по себе никакого эффекта зелью не даёт, но
    неитрализует отрицательное взаимодействие трав.</div>
    <center>
      <a href=\"city.php\">Закрыть книгу</a>
    </center><br>
    </div>";
  } elseif (@$_GET["book"]==2) {
    echo "<div style=\"width:650px;text-align:justify\"><br><center><b>Основы алхимии.</b></center><br>
Искусство алхимии сложный труд. Лишь избранные достигают вершин. Знания великих алхимиков сохранены в томах рецептов. Только достойному грандмастер гильдии алхимиков покажет древние секреты и разрешит переписать их в свою книгу. Чем выше ваши заслуги перед гильдией, тем больше секретов раскроет вам старый мастер. <br>
Каждая новая ступень алхимии раскроет вам секреты новых трав, что позволит вам создавать все более и более могущественные эликсиры. С каждым новым уровнем вы сможете создавать не только более мощные эликсиры, но и постигните секреты новых эликсиров, обладающих новыми свойствами. Но помните, что более мощные эликсиры они и более сложные и на создание нового эликсира вам потребуется больше ингредиентов.<br>
Все алхимики распределены на 10 ступеней. Каждый алхимик имеет знак отличия, по которому его заслуги перед гильдией понятны другим. Ступени эти таковы:<br>
<br>
1. ставший на путь алхимии<br>
2. ученик алхимика<br>
3. старший ученик алхимика<br>
4. подмастерье алхимика<br>
5. познавший тайну алхимии<br>
6. младший алхимик<br>
7. алхимик<br>
8. опытный алхимик<br>
9. мастер алхимии<br>
10. грандмастер алхимии<br>
<br>
Для получения звания \"ставший на путь алхимии\" необходимо заработать 50 очков умения алхимии. Ставшие на путь алхимии могут использовать в своих эликсирах до 6 трав и так же помимо основных компонентов они могут использовать стебель аралии, который позволяет воинам предугадать и избежать наиболее опасных атак противника.<br>
Последующие звания получат только те, кто собрал книгу алхимии и чем опытнее алхимик, тем толще том. Том же вы можете получить у мастера алхимика, а вот страницы каждому придется собирать самому. Страницы в томе не простые, а магические. Добыть их можно в пещере.
    <center><br>
      <a href=\"city.php\">Закрыть книгу</a>
    </center><br>
</div>";
  } elseif (@$_GET["alh"]) {
    function alchval($n) {
      if ($n==1) return $n;
      elseif ($n<=3) return 2;
      elseif ($n<=5) return 3;
      elseif ($n<=8) return 4;
      elseif ($n<=11) return 5;
      elseif ($n<=14) return 6;
      elseif ($n<=18) return 7;
      elseif ($n<=23) return 8;
      elseif ($n<=29) return 9;
      elseif ($n<=36) return 10;
      elseif ($n<=40) return 11;
      elseif ($n<=45) return 12;
      elseif ($n<=51) return 13;
      elseif ($n<=58) return 14;
      elseif ($n<=66) return 15;
      elseif ($n<=72) return 16;
      elseif ($n<=80) return 17;
      elseif ($n<=89) return 18;
      elseif ($n<=99) return 19;
      else return 20;
    }
    if (@$_GET["put"]) {
      $put=mqfa("select name, koll from inventory where id='$_GET[put]' and owner='$user[id]' and type=189");
      if (!$put) {
        echo "<div style=\"width:650px;text-align:center\">Предмет не найден.</div>";
      } else {
        if (@$_GET["put"]) {
          if ($put["koll"]==1) mq("delete from inventory where id='$_GET[put]'");
          else mq("update inventory set koll=koll-1 where id='$_GET[put]'");
          $c=mqfa1("select id from cauldrons where user='$user[id]' and grass='$put[name]'");
          if ($c) mq("update cauldrons set koll=koll+1 where id='$c'");
          else mq("insert into cauldrons set user='$user[id]', grass='$put[name]', koll=1");
          echo "<div style=\"padding-right:200px\">Вы положили в котёл $put[name].</div>";
        }
      }
    }
    if (@$_GET["empty"]) {
      mq("delete from cauldrons where user='$user[id]'");
      echo "<div style=\"width:650px;text-align:center\">Вы опустошили тигель.</div>";
    }

    if (!@$_GET["make"]) {
      echo "<table width=\"650\"><tr><td>
      <h3>У вас есть следующие ресурсы:</h3>
      <table align=center><tr>";
      $r=mq("select id, name, koll, img from inventory where type=189 and owner='$user[id]' and (name='Цветок алканы' or name='Листья примулы' or name='Корень нирина' or name='Стебель аралии' or name='Ветка страстоцвета' or name='Листья гардении' or name='Ягоды азафоэтиды' or name='Цветок вербены' or name='Лист галангала' or name='Ягоды ветиверии' or name='Стебель портулака' or name='Лист эриодикта' or name='Ягоды хриностата' or name='Стабилизатор')");
      while ($rec=mysql_fetch_assoc($r)) {
        echo "<td align=\"center\"><b>$rec[koll]</b><br><a title=\"$rec[name]\" href=\"city.php?alh=1&put=$rec[id]\"><img borer=\"0\" src=\"".IMGBASE."/i/sh/$rec[img]\"></a></td>";
      }
      echo "</tr></table>
      <br>
      <center>
        <input type=button onclick=\"document.location.href='city.php?alh=1&make=1'\" value=\"Варить зелье\">&nbsp;&nbsp;&nbsp;&nbsp;
        <input type=button onclick=\"document.location.href='city.php?alh=1&empty=1'\" value=\"Вылить зелье из тигеля\">
      </center>";
      getadditdata($user);

      echo "<br>Владение алхимией: <b>$user[alchemylevel]</b> ($user[alchemy])<br>Будьте внимательны! Если вы положите траву в котёл, достать её оттуда уже будет невозможно. 
      Так же не переоцените свои возможности,
      последствия приготовления зелий, которые превосходят по сложности ваш уровень алхимии, могут быть весьма печальные.
      </td></tr></table>";
    } else {
      getadditdata($user);
      $totalbylevel=array(3,6,10,15,20,30,40,50,60,75,100);
      $maxcnt=$totalbylevel[$user["alchemylevel"]];
      $r=mq("select grass, koll from cauldrons where user='$user[id]'");
      $cauldron=array();
      $total=0;
      $hasstabil=0;
      while ($rec=mysql_fetch_assoc($r)) {
        if ($rec["grass"]=="Стабилизатор") {
          $hasstabil=1;
          continue;
        }
        $cauldron[$rec["grass"]]=$rec["koll"];
        $total+=$rec["koll"];
      }
      $failed=0;
      if (count($cauldron)>1 && (count($cauldron)>$cauldron["Цветок алканы"]+2 || !$cauldron["Цветок алканы"])) {
        $failed=1;
      }
      if ($total>$maxcnt || $failed) {
        if ($maxcnt-$total>=10) $chance=20+$total-$maxcnt;
        elseif ($maxcnt-$total>=5) $chance=10+$total-$maxcnt;
        else $chance=5+$total-$maxcnt;
        $chance+=20;
        if ($failed || getchance($chance)) {
          echo "<b>Вы использовали неправильные ингредиенты или переоценили свои возможности. Зелье взорвалось.</b>";
          $failed=1;
          addchp(($user["invis"]?"Невидимка":"Персонаж &quot;{$user['login']}&quot;")." переоценил".($user["sex"]==1?"":"а")." свои возможности, и зелье взорвалось.","Комментатор", $user["room"]);
          settravma($user["id"],1,60*30+(rand(0,30)*60),1,1);
          mq("update inventory set duration=duration+1 where id='$tigel[id]' and owner='$user[id]' and duration<maxdur limit 1");
        }
      }
      $sql="";
      foreach ($cauldron as $k=>$v) {
        if ($k=="Корень нирина") $sql.=", mfuvorot='".(alchval($v)*5)."'";
        if ($k=="Листья примулы") $sql.=", mfauvorot='".(alchval($v)*5)."'";
        if ($k=="Стебель аралии") $sql.=", mfakrit='".(alchval($v)*5)."'";
        if ($k=="Ветка страстоцвета") $sql.=", mfkrit='".(alchval($v)*5)."'";
        if ($k=="Листья гардении") $sql.=", mfparir='".(alchval($v))."'";
        if ($k=="Ягоды азафоэтиды") $sql.=", mfcontr='".(alchval($v))."'";
        if ($k=="Цветок вербены") $sql.=", mfdhit='".(alchval($v)*10)."'";
        if ($k=="Лист галангала") $sql.=", mfdmag='".(alchval($v)*10)."'";
        if ($k=="Ягоды ветиверии") $sql.=", manausage='".(alchval($v))."'";
        if ($k=="Стебель портулака") $sql.=", mfmagp='".(alchval($v*3))."'";
        if ($k=="Лист эриодикта") $sql.=", mfhitp='".(alchval($v)*2)."'";
        if ($k=="Ягоды хриностата") $sql.=", minusmfdmag='".(alchval($v))."'";                
      }
      if (!$failed) {
        if ((getchance($failchance) && !$hasstabil) || !$sql) {
          adduserdata("alchemy", ceil($total/2));
          checkalchlevel();
          echo "<b>Попытка сварить зелье не удалась.</b>";
          $failed=1;
          addchp(($user["invis"]?"Невидимка":"Персонаж &quot;{$user['login']}&quot;")." пытал".($user["sex"]==1?"ся":"ась")." сварить зелье, но что-то не удалось.","Комментатор", $user["room"]);
          if (rand(1,3)==2) mq("update inventory set duration=duration+1 where id='$tigel[id]' and owner='$user[id]' and duration<maxdur limit 1");
        } 
      }
      if (!$failed) {
        adduserdata("alchemy", $total);
        checkalchlevel();
        echo "<b>Зелье сварено успешно.</b>";
        addchp(($user["invis"]?"Невидимка":"Персонаж &quot;{$user['login']}&quot;")." удачно сварил".($user["sex"]==1?"":"а")." зелье.","Комментатор", $user["room"]);
        if ($total>=100) $nlevel=10;
        elseif ($total>=75) $nlevel=9;
        elseif ($total>=60) $nlevel=8;
        elseif ($total>=50) $nlevel=7;
        elseif ($total>=40) $nlevel=6;
        elseif ($total>=30) $nlevel=5;
        elseif ($total>=20) $nlevel=4;
        elseif ($total>=10) $nlevel=3;
        elseif ($total>=6) $nlevel=2;
        elseif ($total>=3) $nlevel=1;
        else $nlevel=0;
        mq("insert into inventory set owner='$user[id]', type=188, name='Самодельный эликсир [$nlevel]', img='elixir.gif', massa=1, duration=0, maxdur=3, nlevel=".min($nlevel, 8).", magic=186, otdel=188 $sql");
        $brec=mqfa("select id, koll from inventory where owner='$user[id]' and name='Бутылка'");
        if ($brec["koll"]<=1) mq("delete from inventory where id='$brec[id]'");
        else mq("update inventory set koll=koll-1 where id='$brec[id]'");
      }
      mq("delete from cauldrons where user='$user[id]'");
      makequest(16);
      $_GET["alh"]=0;
    }
  }
  if (!@$_GET["alh"] && !@$_GET["book"]) {
    $fon='54_bg';
    $locs[]=array("name"=>"$rooms[660]", "img"=>"2_Right","x"=>485, "y"=>180, "room"=>"660", "link"=>"city.php?park=1");
    $locs[]=array("name"=>"Пройти вглубь пещеры", "img"=>"2_Left","x"=>35, "y"=>110, "room"=>301);
    $locs[]=array("name"=>"Приготовить зелье", "img"=>"54_cauldron","x"=>15, "y"=>140, "room"=>"54", "link"=>"city.php?alh=1");
    $locs[]=array("name"=>"Книга начинающего алхимика", "img"=>"54_book1","x"=>190, "y"=>210, "room"=>"54", "link"=>"city.php?book=1");
    $locs[]=array("name"=>"Основы алхимии", "img"=>"54_book2","x"=>330, "y"=>210, "room"=>"54", "link"=>"city.php?book=2");
    echo "<table width=1><tr><td><div style=\"position:relative\" id=\"ione\"><img src=\"/img/city/",$fon,".jpg\" alt=\"\" border=\"0\"/>";
    foreach ($locs as $k=>$v) {
      buildset($v["room"],$v["img"],$v["y"],$v["x"],$v["name"], @$v["link"]);
    }

$hinttop=18;
$hintright=113;
if (WINTER) echo "<div id=\"snow\"></div><script src=\"i/js/snows.js\"></script>";
  }
}
?>
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

<tr><td align="right"><div align="right" id="btransfers"><table cellpadding="0" cellspacing="0" border="0" id="bmoveto">
<tr><td bgcolor="#D3D3D3">
<? if ($user['room'] == 20) { ?>
<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop"  id="bmo_1" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Бойцовский Клуб</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" id="bmo_2" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Магазин</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" id="bmo_4" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Ремонтная мастерская</a></span>


<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" id="bmo_6" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Почта</a></span>


<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" id="bmo_35000" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Вокзал</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" id="bmo_3" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Комиссионный магазин</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" id="bmo_7" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Страшилкина улица</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" id="bmo_8" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Парк Развлечений</a></span>


<?} elseif ($user['room'] == 650) { ?>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" id="bmo_4" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Страшилкина улица</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" id="bmo_9" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Книжный магазин</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" id="bmo_11" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Зоомагазин</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" id="bmo_5" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Портал</a></span>


<?} elseif ($user['room'] == 21) { ?>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" id="bmo_4" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Центральная площадь</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" id="bmo_33" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Общежитие</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" id="bmo_10" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Магазин Березка</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" id="bmo_7" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Башня Смерти</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" id="bmo_12" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Банк</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" id="bmo_6" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Цветочный магазин</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" id="bmo_2" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Регистратура кланов</a></span>




<?} elseif ($user['room'] == 660) { ?>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" id="bmo_4" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Центральная площадь</a></span>

<?}?>

<? 
if($_SESSION['perehod']>time()){$vrme=$_SESSION['perehod']-time();}else{$vrme=0;}
?>
</td>
</tr>
</table></div></td></tr>
</table>
<div style="display:none; height:0px " id="moveto">0</div>
</td>
</tr>
</table>
<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px; white-space: nowrap;"></div>
<script language="javascript" type="text/javascript"> 
var progressEnd = 64;		// set to number of progress <span>'s.
var progressColor = '#00CC00';	// set to progress bar color
var mtime = parseInt('<?=$vrme?>');
if (!mtime || mtime<=1) {mtime=3;}
var progressInterval = Math.round(mtime*1000/progressEnd);	// set to time between updates (milli-seconds)
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
if (window.solo_store && solo_store) { solo(solo_store, ""); } // go to stored
set_moveto(false);
} else {
if( !( progressAt % 2 ) )
document.getElementById('MoveLine').style.left = progressAt - 64;
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
/*	progressColor = color;
for (var i = 1; i <= progressAt; i++) {
document.getElementById('progress'+i).style.backgroundColor = progressColor;
}*/
}
if (mtime>0) {
progress_clear();
progress_update();
}
</script>
<HR>
<div id="buttons_on_image" style="cursor:pointer; font-weight:bold; color:#D8D8D8; font-size:10px;">

<?
//if($user['room'] == 20  && (int)date("H") >=6  && (int)date("H") <22){
//echo'<span onMouseMove="this.runtimeStyle.color = \'white\';" onMouseOut="this.runtimeStyle.color = this.parentElement.style.color;" onclick="">Нападение доступно с 22 до 6 ч.</span> &nbsp;';
//}else 
if($user['room'] == 20) {
echo'<span onMouseMove="this.runtimeStyle.color = \'white\';" onMouseOut="this.runtimeStyle.color = this.parentElement.style.color;" onClick="findlogin(\'Напасть\', \'city.php?nap=attack\', \'target\'); ">Напасть</span> &nbsp;';
?>
<?}?>


<? if ($user["room"]==660) { ?>
<? if (WINTER && 0) echo "<span onMouseMove=\"this.runtimeStyle.color = 'white';\" onMouseOut=\"this.runtimeStyle.color = this.parentElement.style.color;\" onclick=\"document.location.href='city.php?hunt=1';\">Охотиться</span> &nbsp;"; ?>

<? }?>
<script>
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

|
<span onMouseMove="this.style.color = 'white';" onMouseOut="this.style.color = '';" onClick="highlight()">Объекты</span> 
|
<span onMouseMove="this.runtimeStyle.color = 'white';" onMouseOut="this.runtimeStyle.color = this.parentElement.style.color;" onclick="window.open('forum.php', 'forum', 'location=yes,menubar=yes,status=yes,resizable=yes,toolbar=yes,scrollbars=yes,scrollbars=yes')">Форум</span> &nbsp;
<!--
<span onMouseMove="this.runtimeStyle.color = 'white';" onMouseOut="this.runtimeStyle.color = this.parentElement.style.color;" onclick="window.open('help/city1.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">Подсказка</span> &nbsp;
-->

</div>
<script language="javascript" type="text/javascript"> 
<!--
if (document.getElementById('ione')) {
document.getElementById('ione').appendChild(document.getElementById('buttons_on_image'));
document.getElementById('buttons_on_image').style.position = 'absolute';
document.getElementById('buttons_on_image').style.bottom = '8px';
document.getElementById('buttons_on_image').style.right = '23px';
} else {
document.getElementById('buttons_on_image').style.display = 'none';
}
-->
</script>
    <small>
        <?php
         $online = mq("select * from `online`  WHERE `real_time` >= ".(time()-60).";");
        ?>
    <B>Внимание!</B> Никогда и никому не говорите пароль от своего персонажа. Не вводите пароль на других сайтах, типа "новый город", "лотерея", "там, где все дают на халяву". Пароль не нужен ни паладинам, ни кланам, ни администрации, <U>только взломщикам</U> для кражи вашего героя.<BR>
    <I>Администрация.</I></small>
    <BR>
    <BR>

        
    <?php
    if ($_SESSION["uid"]==99999) {
function takeshopitem1($item) {
  $r=mq("show fields from items");
  $rec1=mqfa("select * from shop where id='$item'");
  $sql="";
  while ($rec=mysql_fetch_assoc($r)) {
    if ($present) {
      if ($rec["Field"]=="maxdur") $rec1[$rec["Field"]]=1;
      if ($rec["Field"]=="cost") $rec1[$rec["Field"]]=2;
    }
    if ($rec["Field"]=="id" || $rec["Field"]=="prototype") continue;
    if ($rec["Field"]=="goden") $goden=$rec1[$rec["Field"]];
    $sql.=", `$rec[Field]`='".$rec1[$rec["Field"]]."' ";
  }
  mq("insert into inventory set owner='$_SESSION[uid]', prototype='$item' ".($goden?", dategoden='".($goden*60*60*24+time())."'":"")." $sql");
  echo mysql_error();
  return array("img"=>$rec1["img"], "name"=>$rec1["name"]);
}
    }
   ?>
</TD>
</TR>
</TABLE></td></tr></table>
<?
  $f=mqfa1("select value from variables where var='fireworks'");
  if ($f>time()) echo implode("",file("clipart/fworks.html"));
  //if ($user["room"]==20) echo implode("",file("clipart/fworks.html"));
?>
</BODY>
</HTML>
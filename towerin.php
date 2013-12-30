<?php
ob_start("ob_gzhandler");

	session_start();
	if ($_SESSION['uid'] == null) header("Location: index.php");
	include "connect.php";	
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
	include "functions.php";	
	if ($user['in_tower'] != 1) { header('Location: main.php'); die(); }
	if ($user['battle'] != 0) { header('Location: fbattle.php'); die(); }
	$rooms[0] = "";
	// характеристики комнат
	$rhar = array(
					"501" => array (
									20,		0,502,505,0
							),
					"502" => array (
									15,		0,0,0,501
							),
					"503" => array (
									15,		0,0,507,0
							),	
					"504" => array (
									15,		0,0,508,0
							),	
					"505" => array (
									20,		501,0,510,0
							),	
					"506" => array (
									15,		0,507,511,0
							),	
					"507" => array (
									15,		503,508,0,506
							),	
					"508" => array (
									25,		504,0,513,507
							),	
					"509" => array (
									20,		0,0,515,0
							),	
					"510" => array (
									20,		505,511,0,0
							),	
					"511" => array (
									20,		506,0,0,510
							),	
					"512" => array (
									30,		0,513,519,0
							),	
					"513" => array (
									25,		508,514,0,512
							),	
					"514" => array (
									20,		0,0,0,513
							),	
					"515" => array (
									20,		509,0,522,0
							),	
					"516" => array (
									25,		0,517,523,0
							),		
					"517" => array (
									25,		0,518,0,516
							),	
					"518" => array (
									35,		0,519,525,517
							),	
					"519" => array (
									35,		512,520,526,518
							),	
					"520" => array (
									35,		0,521,0,519
							),	
					"521" => array (
									15,		0,0,528,0
							),	
					"522" => array (
									20,		515,0,529,0
							),	
					"523" => array (
									15,		516,0,530,0
							),	
					"524" => array (
									20,		0,525,531,0
							),	
					"525" => array (
									35,		518,526,532,524
							),	
					"526" => array (
									40,		519,527,533,525
							),	
					"527" => array (
									35,		0,0,0,526
							),	
					"528" => array (
									15,		521,529,535,0
							),	
					"529" => array (
									20,		522,0,0,528
							),	
					"530" => array (
									20,		523,531,537,0
							),	
					"531" => array (
									35,		524,0,538,530
							),	
					"532" => array (
									20,		525,533,539,0
							),	
					"533" => array (
									20,		526,534,540,532
							),	
					"534" => array (
									15,		0,0,0,533
							),								
					"535" => array (
									20,		528,0,541,0
							),	
					"536" => array (
									20,		0,537,0,535
							),	
					"537" => array (
									35,		530,0,543,536
							),	
					"538" => array (
									20,		531,0,544,0
							),	
					"539" => array (
									20,		532,0,545,0
							),	
					"540" => array (
									15,		533,0,546,0
							),	
					"541" => array (
									20,		535,542,547,0
							),	
					"542" => array (
									15,		0,543,0,541
							),	
					"543" => array (
									40,		537,0,549,542
							),	
					"544" => array (
									40,		538,545,550,543
							),	
					"545" => array (
									40,		539,0,551,544
							),	
					"546" => array (
									15,		540,0,552,0
							),	
					"547" => array (
									20,		541,548,553,0
							),	
					"548" => array (
									20,		0,549,0,547
							),	
					"549" => array (
									35,		543,550,0,548
							),	
					"550" => array (
									40,		544,551,554,549
							),	
					"551" => array (
									40,		545,0,555,550
							),	
					"552" => array (
									15,		546,0,556,0
							),	
					"553" => array (
									20,		547,0,557,0
							),	
					"554" => array (
									20,		550,555,0,0
							),	
					"555" => array (
									35,		551,0,0,554
							),	
					"556" => array (
									15,		552,0,559,0
							),	
					"557" => array (
									15,		553,0,0,0
							),	
					"558" => array (
									20,		0,559,0,0
							),	
					"559" => array (
									20,		556,560,0,558
							),	
					"560" => array (
									20,		0,0,0,559
							)
					
	);
	// устанавливаем блокировки
	mysql_query("LOCK TABLES `bots` WRITE, `users` WRITE, `deztow_items` WRITE, `inventory` WRITE, `battle` WRITE, 
				`logs` WRITE, `deztow_turnir` WRITE, `effects` WRITE,`shop` WRITE, `online` WRITE, `deztow_gamers_inv` WRITE,
				`deztow_realchars` WRITE, `deztow_eff` WRITE, `variables` WRITE;");
	
	$ls = mysql_fetch_array(mysql_query("select count(`id`), SUM(`bot`) from `users` WHERE `in_tower` = 1;"));
	$tur_data = mysql_fetch_array(mysql_query("SELECT * FROM `deztow_turnir` WHERE `active` = TRUE"));	
	// поднял шмотку
	if($_GET['give']) {
		$obj = mysql_fetch_array(mysql_query("SELECT * FROM `deztow_items` WHERE `id` = '".$_GET['give']."' AND `room` = '".$user['room']."' LIMIT 1;"));
		if($obj) { 
			if($_SESSION['timei']-time()<=0) {
				$_SESSION['timei'] = time()+3;
				mysql_query("DELETE FROM `deztow_items` WHERE `id` = '".$_GET['give']."' AND `room` = '".$user['room']."' LIMIT 1;");
				$dress = mysql_fetch_array(mysql_query("SELECT * FROM `shop` WHERE `id` = '".$obj['iteam_id']."' LIMIT 1;"));
				mysql_query("INSERT INTO `inventory`
				(`bs`,`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`isrep`,
					`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
					`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`
				)
				VALUES
				(1,'{$dress['id']}','{$_SESSION['uid']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
				'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron3']}','{$dress['bron2']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}','{$dress['razdel']}'
				) ;");
			}
			else {
				echo "<font color=red>Вы сможте поднять вещь через ".($_SESSION['timei']-time())." секунд...</font>";
			}
		} else {
			echo "<font color=red>Кто-то быстрее...</font>";
		}
		
	}
	
	// нападение
	if($_POST['attack']) {
		// остальные типы боев
			$jert = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$_POST['attack']}' LIMIT 1;")); 			
			if($jert['room'] == $user['room'] && $jert['id']!=$user['id']) {
				//арх
				if($jert['id'] == 233) {
					$arha = mysql_fetch_array(mysql_query ('SELECT * FROM `bots` WHERE `prototype` = '.$jert['id'].' LIMIT 1;'));
					$jert['battle'] = $arha['battle'];
					$jert['id'] = $arha['id'];
					$bot=1;
				}
				if($jert['battle'] > 0) {					
					//вмешиваемся
					$bd = mysql_fetch_array(mysql_query ('SELECT * FROM `battle` WHERE `id` = '.$jert['battle'].' LIMIT 1;'));
					$battle = unserialize($bd['teams']);
					$ak = array_keys($battle[$jert['id']]);
					$battle[$user['id']] = $battle[$ak[0]];
					foreach($battle[$user['id']] as $k => $v) {
						$battle[$k][$user['id']] = array(0,0,time());
						$battle[$user['id']][$k] = array(0,0,time());
					}
					$t1 = explode(";",$bd['t1']);		
					// проставляем кто-где
					if (in_array ($jert['id'],$t1)) {
						$ttt = 2;
						$ttt2 = 1;
					} else {	
						$ttt = 1;
						$ttt2 = 2;
					}
					addch ("<b>".nick7($user['id'])."</b> вмешался в <a href=logs.php?log=".$id." target=_blank>поединок »»</a>.  ",$user['room']);
									
					//mysql_query('UPDATE `logs` SET `log` = CONCAT(`log`,\'<span class=date>'.date("H:i").'</span> '.nick5($user['id'],"B".$ttt).' вмешался в поединок!<BR>\') WHERE `id` = '.$jert['battle'].'');
				
					addlog($jert['battle'],'<span class=date>'.date("H:i").'</span> '.nick5($user['id'],"B".$ttt).' вмешался в поединок!<BR>');
				
					mysql_query('UPDATE `battle` SET `teams` = \''.serialize($battle).'\', `t'.$ttt.'`=CONCAT(`t'.$ttt.'`,\';'.$user['id'].'\'), `to'.$ttt.'` = \''.time().'\', `to'.$ttt2.'` = \''.(time()-1).'\'  WHERE `id` = '.$jert['battle'].' ;');
					mysql_query("UPDATE users SET `battle` =".$jert['battle'].",`zayavka`=0 WHERE `id`= ".$user['id']);
					mysql_query('UPDATE `deztow_turnir` SET `log` = CONCAT(`log`,\''."<span class=date>".date("d.m.y H:i")."</span>  ".nick3($user['id'])." вмешался в поединок против ".nick3($jert['id'])." <a href=\"logs.php?log={$jert['battle']}\" target=_blank>»»</a><BR>".'\') WHERE `active` = TRUE;');
				
					header("Location:fbattle.php");
					die("<script>location.href='fbattle.php';</script>");
				}
				else
				{
					// начинаем бой
					//arch
					if($bot) {
						mysql_query("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('Архивариус','233','','".$jert['hp']."');");
						$jert['id'] = mysql_insert_id();
					}
					
					$teams = array();					
					$teams[$user['id']][$jert['id']] = array(0,0,time());
					$teams[$jert['id']][$user['id']] = array(0,0,time());	
					$sv = array(1,2,3,4,5);
					//$tou = array_rand($sv,1);
					mysql_query("INSERT INTO `battle` 
						(
							`id`,`coment`,`teams`,`timeout`,`type`,`status`,`t1`,`t2`,`to1`,`to2`,`blood`
						) 
						VALUES
						(
							NULL,'','".serialize($teams)."','".$sv[rand(0,3)]."','10','0','".$user['id']."','".$jert['id']."','".time()."','".time()."','1'
						)");
						
					$id = mysql_insert_id();
				
					// апдейтим врага
					if($bot) {
						mysql_query("UPDATE `bots` SET `battle` = {$id} WHERE `id` = {$jert['id']} LIMIT 1;");
					} else {
						mysql_query("UPDATE `users` SET `battle` = {$id} WHERE `id` = {$jert['id']} LIMIT 1;");					
					}
				
					// создаем лог
					
				
					$rr = "<b>".nick3($user['id'])."</b> и <b>".nick3($jert['id'])."</b>";	
					addch ("<B><b>".nick7($user['id'])."</b> , применив магию нападения, внезапно напал на <b>".nick7($jert['id'])."</b>.   ",$user['room']);
				
					//mysql_query("INSERT INTO `logs` (`id`,`log`) VALUES('{$id}','Часы показывали <span class=date>".date("Y.m.d H.i")."</span>, когда ".$rr." бросили вызов друг другу. <BR>');");
					
					addlog($id,"Часы показывали <span class=date>".date("Y.m.d H.i")."</span>, когда ".$rr." бросили вызов друг другу. <BR>");

					
					mysql_query("UPDATE users SET `battle` ={$id},`zayavka`=0 WHERE `id`= {$user['id']} OR `id` = {$jert['id']}");	
					mysql_query('UPDATE `deztow_turnir` SET `log` = CONCAT(`log`,\''."<span class=date>".date("d.m.y H:i")."</span>  ".nick3($user['id'])." напал на ".nick3($jert['id'])." завязался <a href=\"logs.php?log={$id}\" target=_blank>бой »»</a><BR>".'\') WHERE `active` = TRUE');
					header("Location:fbattle.php");
					die("<script>location.href='fbattle.php';</script>");
				}			
			} else {
				echo '<font color=red>Жертва ускользнула из комнаты...</font>';
			}			
	}
	
	// переходы
	$_GET['path'] = (int)$_GET['path'];	
	if($rhar[$user['room']][$_GET['path']] > 0 && $_GET['path'] < 5 && $_GET['path'] > 0 && ($_SESSION['time'] <= time())) {
		$rr = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `type` = 10 AND `owner` = {$user['id']};"));
		if(!$rr) {
		// ушел из комнаты
		$list = mysql_query("SELECT `id`,`room`,`login` FROM `users` WHERE `room` = '".$user['room']."' AND `in_tower`=1;");
		while($u = mysql_fetch_array($list)) {
			if($u['id']!=$user['id']) addchp ('<font color=red>Внимание!</font> <B>'.$user['login'].'</B> отправился в <B>'.$rooms[$rhar[$user['room']][$_GET['path']]].'</B>.   ',''.$u['login'].'');
		}
		// пришел в комнату
		$list = mysql_query("SELECT `id`,`room`,`login` FROM `users` WHERE `room` = '".$rhar[$user['room']][$_GET['path']]."' AND `in_tower`=1;");
		while($u = mysql_fetch_array($list)) {
			addchp ('<font color=red>Внимание!</font> <B>'.$user['login'].'</B> вошел в комнату.   ',''.$u['login'].'');				
		}
		mysql_query("UPDATE `users`,`online` SET `users`.`room` = '".$rhar[$user['room']][$_GET['path']]."',`online`.`room` = '".$rhar[$user['room']][$_GET['path']]."' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
		$_SESSION['time'] = time()+$rhar[$rhar[$user['room']][$_GET['path']]][0];
		header('Location:towerin.php');	
		die("<script>location.href='towerin.php';</script>");
		} else {
			err('Вы парализованы и не можете двигатся...');
		}
	}
	
	// проиграл бс
	$list = mysql_query("SELECT * FROM `users` WHERE `in_tower`=1 AND `battle`=0;");
	while($u = mysql_fetch_array($list)) {	
	//$u = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `in_tower`=1 AND `battle`=0 AND `id` = '".$u['id']."';"));
	if($u['hp'] <= 0) {	
		undressall($u['id']);
		$rep = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '".$u['id']."' AND `bs` = 1;");
		while($r = mysql_fetch_array($rep)) {			
			mysql_query("INSERT `deztow_items` (`iteam_id`, `name`, `img`, `room`) values ('".$r['prototype']."', '".$r['name']."', '".$r['img']."', '".$u['room']."');");					
		}
		mysql_query("DELETE FROM `inventory` WHERE `owner` = '".$u['id']."' AND `bs` = 1;");		
		$rep = mysql_query("SELECT * FROM `deztow_gamers_inv` WHERE `owner` = '".$u['id']."';");
		while($r = mysql_fetch_array($rep)) {
			mysql_query("UPDATE `inventory` SET `owner` = '".$u['id']."' WHERE `owner` = '0' AND `id` = '".$r['id_item']."';");
		}
		
		// эхх старые статы ставим в строй
		$tec = mysql_fetch_array(mysql_query("SELECT * FROM `deztow_realchars` WHERE `owner` = '{$u['id']}';"));
		if($tec[0]) {
			// сномим зарубку
			mysql_query("DELETE FROM `deztow_realchars` WHERE `owner` = '{$u['id']}';");
			// если есть шаблон - меняем
			$u = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$u['id']}' LIMIT 1;"));		
			//теперь выставляем статы))
			$stats = ($u['sila']+$u['lovk']+$u['inta']+$u['vinos']+$u['intel']+$u['mudra']+$u['stats'])-($tec['sila']+$tec['lovk']+$tec['inta']+$tec['vinos']+$tec['intel']+$tec['mudra']);
			$master = ($u['noj']+$u['mec']+$u['topor']+$u['dubina']+$u['mfire']+$u['mwater']+$u['mair']+$u['mearth']+$u['mlight']+$u['mgray']+$u['mdark']+$u['master']);
			mysql_query("UPDATE `users` SET `sila`='".$tec['sila']."', `lovk`='".$tec['lovk']."',`inta`='".$tec['inta']."',`vinos`='".$tec['vinos']."',`intel`='".$tec['intel']."',`mudra`='".$tec['mudra']."',`stats`='".$tec['stats']."',
			`nextup` = '".$tec['nextup']."', `level` = '".$tec['level']."',`noj`=0,`mec`=0,`topor`=0,`dubina`=0,`mfire`=0,`mwater`=0,`mair`=0,`mearth`=0,`mlight`=0,`mgray`=0,`mdark`=0,`master`='".$tec['master']."'
			WHERE `id` = '".$u['id']."' LIMIT 1;");
			
			// закончили
			
		}
		
		// effects
		$eff = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$u['id']."' AND (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14);"));
		mysql_query("DELETE FROM `effects` WHERE `owner` = '".$u['id']."' AND `type` <> 11 AND `type` <> 12 AND `type` <> 13 AND `type` <> 14;");
		//mysql_query("INSERT `effects` (`type`, `name`, `time`, `sila`, `lovk`, `inta`, `vinos`, `owner`) 
		//			values ('".$eff['type']."','".$eff['name']."','".$eff['time']."','".$eff['sila']."','".$eff['lovk']."','".$eff['inta']."','".$eff['vinos']."','".$eff['owner']."');");
		if($tec[0]) {
			mysql_query("UPDATE `users` SET `sila`=`sila`-'".$eff['sila']."', `lovk`=`lovk`-'".$eff['lovk']."', `inta`=`inta`-'".$eff['inta']."' WHERE `id` = '".$eff['owner']."' LIMIT 1;");
		}
		
		$effs = mysql_query("SELECT * FROM `deztow_eff` WHERE `owner` = '".$u['id']."';");
		mysql_query("DELETE FROM `deztow_eff` WHERE `owner` = '".$u['id']."';");
		while($eff = mysql_fetch_array($effs)) {
			//if($eff['type']==11 OR $eff['type']==12 OR $eff['type']==13) {
			//	//settravma($u['id']);
			//	mysql_query("INSERT `effects` (`type`, `name`, `time`, `sila`, `lovk`, `inta`, `vinos`, `owner`) 
			//		values ('".$eff['type']."','".$eff['name']."','".$eff['time']."','".$eff['sila']."','".$eff['lovk']."','".$eff['inta']."','".$eff['vinos']."','".$eff['owner']."');");
			//	mysql_query("UPDATE `users` SET `sila`=`sila`-'".$eff['sila']."', `lovk`=`lovk`-'".$eff['lovk']."', `inta`=`inta`-'".$eff['inta']."' WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			//} else {
				mysql_query("INSERT `effects` (`type`, `name`, `time` `owner`) 
				values ('".$eff['type']."','".$eff['name']."','".$eff['time']."','".$eff['owner']."');");		
			//}
		}
		
		//if ($u['id'] != 233){
		//	settravma($u['id'],100,86400,1);
		//}
		
		
		//$tr = $travmalist[rand(0,count($travmalist)-1)];
		//mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`) values ('".$u['id']."','".$tr."',".(time()+86400).",1,'-1');");
		mysql_query("UPDATE `users` SET `in_tower` = 0, `room` = '31' WHERE `id` = '".$u['id']."';");
		mysql_query("UPDATE `online` SET  `room` = '31' WHERE `id` = '".$u['id']."';");
		
		mysql_query('UPDATE `deztow_turnir` SET `log` = CONCAT(`log`,\''."<span class=date>".date("d.m.y H:i")."</span> ".nick3($u['id'])." повержен и выбывает из турнира<BR>".'\') WHERE `active` = TRUE');
		addchp ('<font color=red>Внимание!</font> Вы выбыли из турнира Башни Смерти.    ', ''.$u['login'].'');
				
		//header('Location:tower.php');
		//die("<script>location.href='tower.php';</script>");
	}
	// дохнет арх	
	}
	
	//выиграл БС
	if(($ls[0]-$ls[1]) < 2 && ($tur_data['start_time']+60) <= time()) {
		//
		echo "";
		$tur = mysql_fetch_array(mysql_query("select * from `deztow_turnir` WHERE `active` = TRUE;"));
		
		undressall($user['id']);
		$rep = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '".$user['id']."' AND `bs` = 1;");
		while($r = mysql_fetch_array($rep)) {			
			mysql_query("INSERT `deztow_items` (`iteam_id`, `name`, `img`, `room`) values ('".$r['prototype']."', '".$r['name']."', '".$r['img']."', '".$user['room']."');");					
		}
		mysql_query("DELETE FROM `inventory` WHERE `owner` = '".$user['id']."' AND `bs` = 1;");		
		$rep = mysql_query("SELECT * FROM `deztow_gamers_inv` WHERE `owner` = '".$user['id']."';");
		while($r = mysql_fetch_array($rep)) {
			mysql_query("UPDATE `inventory` SET `owner` = '".$user['id']."' WHERE `owner` = '0' AND `id` = '".$r['id_item']."';");
		}
		
		// эхх старые статы ставим в строй
		$tec = mysql_fetch_array(mysql_query("SELECT * FROM `deztow_realchars` WHERE `owner` = '{$user['id']}';"));
		if($tec[0]) {
			// сномим зарубку
			mysql_query("DELETE FROM `deztow_realchars` WHERE `owner` = '{$user['id']}';");
			// если есть шаблон - меняем
			$u = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$user['id']}' LIMIT 1;"));		
			//теперь выставляем статы))
			$stats = ($u['sila']+$u['lovk']+$u['inta']+$u['vinos']+$u['intel']+$u['mudra']+$u['stats'])-($tec['sila']+$tec['lovk']+$tec['inta']+$tec['vinos']+$tec['intel']+$tec['mudra']);
			$master = ($u['noj']+$u['mec']+$u['topor']+$u['dubina']+$u['mfire']+$u['mwater']+$u['mair']+$u['mearth']+$u['mlight']+$u['mgray']+$u['mdark']+$u['master']);
			mysql_query("UPDATE `users` SET `sila`='".$tec['sila']."', `lovk`='".$tec['lovk']."',`inta`='".$tec['inta']."',`vinos`='".$tec['vinos']."',`intel`='".$tec['intel']."',`mudra`='".$tec['mudra']."',`stats`='".$tec['stats']."',
			`nextup` = '".$tec['nextup']."', `level` = '".$tec['level']."',`noj`=0,`mec`=0,`topor`=0,`dubina`=0,`mfire`=0,`mwater`=0,`mair`=0,`mearth`=0,`mlight`=0,`mgray`=0,`mdark`=0,`master`='".$tec['master']."'
			WHERE `id` = '".$user['id']."' LIMIT 1;");			
			// закончили
		}
		
		// effects		
		mysql_query("DELETE FROM `effects` WHERE `owner` = '".$user['id']."' AND `type` <> 11 AND `type` <> 12 AND `type` <> 13 AND `type` <> 14;");				
		$eff = mysql_query("SELECT * FROM `deztow_eff` WHERE `owner` = '".$user['id']."';");
		while($r = mysql_fetch_array($eff)) {
			mysql_query("INSERT `effects` (`type`, `name`, `time`, `sila`, `lovk`, `inta`, `vinos`, `owner`) 
					values ('".$eff[1]."','".$eff[2]."','".$eff[3]."','".$eff[4]."','".$eff[5]."','".$eff[6]."','".$eff[7]."','".$eff[8]."');");
			//mysql_query("UPDATE `users` SET `sila`=`sila`-'".$eff[4]."', `lovk`=`lovk`-'".$eff[5]."', `inta`=`inta`-'".$eff[6]."' WHERE `id` = '".$eff[8]."' LIMIT 1;");
		}
		//$eff = mysql_query("SELECT * FROM `deztow_eff` WHERE `owner` = '".$u['id']."';");
		//mysql_query("DELETE FROM `deztow_eff` WHERE `owner` = '".$u['id']."';");
		//while($r = mysql_fetch_array($eff)) {
		//	settravma($u['id']);
		//}
		
		mysql_query("UPDATE `users` SET `money`=`money`+'".$tur['coin']."',`in_tower` = 0, `room` = '31' WHERE `id` = '".$user['id']."';");
		mysql_query("UPDATE `online` SET  `room` = '31' WHERE `id` = '".$user['id']."';");
		
		mysql_query('UPDATE `deztow_turnir` SET `winner` = \''.$user['id'].'\', `winnerlog`=\''.nick3($user['id']).'\',`endtime` = \''.time().'\',`active` = FALSE, `log` = CONCAT(`log`,\''."<span class=date>".date("d.m.y H:i")."</span> Турнир завершен. Победитель: ".nick3($user['id'])." Приз: <B>".$tur['coin']."</B> кр. <BR>".'\') WHERE `active` = TRUE');
		addchp ('<font color=red>Внимание!</font> Поздравляем! Вы победитель турнира Башни смерти! Получаете <B>'.$tur['coin'].'</B> кр.     ', ''.$user['login'].'');
		mysql_query('UPDATE `variables` SET `value` = \''.(time()+60*60*1).'\' WHERE `var` = \'startbs\';');
		
		header('Location:tower.php');
		die("<script>location.href='tower.php';</script>");
	}
	
	// cнимаем блокировку
	mysql_query("UNLOCK TABLES;");
	if ($user['hp'] <= 0) { header('Location: tower.php'); die(); }
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META HTTP-EQUIV=Expires CONTENT=0>
<META HTTP-EQUIV=imagetoolbar CONTENT=no>
<STYLE>
.H3			{ COLOR: #8f0000;  FONT-FAMILY: Arial;  FONT-SIZE: 12pt;  FONT-WEIGHT: bold;}
</STYLE>
<SCRIPT src='i/commoninf.js'></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" >
var Hint3Name = '';
// Заголовок, название скрипта, имя поля с логином
function findlogin(title, script, name){
	document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
	'<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><form action="'+script+'" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"><td colspan=2>'+
	'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD width=50% align=right><INPUT TYPE=text NAME="'+name+'"></TD><TD width=50%><INPUT TYPE="submit" value=" »» "></TD></TR></FORM></TABLE></td></tr></table>';
	document.all("hint3").style.visibility = "visible";
	document.all("hint3").style.left = 100;
	document.all("hint3").style.top = 100;
	document.all(name).focus();
	Hint3Name = name;
}


function returned2(s){
	if (top.oldlocation != '') { top.frames['main'].navigate(top.oldlocation+'?'+s+'tmp='+Math.random()); top.oldlocation=''; }
	else { top.frames['main'].navigate('main.php?'+s+'tmp='+Math.random()) }
}
<? 
$step=1;
if ($step==1) $idkomu=0;
?>
function closehint3(){
	document.all("hint3").style.visibility="hidden";
    Hint3Name='';
}
</script>
</HEAD>
<body leftmargin=2 topmargin=2 marginwidth=2 marginheight=2 bgcolor=e2e0e0 onload="top.setHP(<?=$user['hp']?>,<?=$user['maxhp']?>,1); ;">
<div id=hint4 class=ahint></div>
<TABLE width=100% cellspacing=0 cellpadding=0>

<TR><TD><?nick($user);?></TD>
<script>top.setHP(230,230,1); </script>
<TD class='H3' align=right><?=$rooms[$user['room']];?>&nbsp; &nbsp;
<IMG SRC=i/tower/attack.gif WIDTH=66 HEIGHT=24 ALT="Напасть на..." style="cursor:hand" onclick="findlogin('Напасть на','towerin.php','attack')">
</TD>
<TR>
<TD valign=top>
<FONT COLOR=red></FONT>

<?

	$its = mysql_query("SELECT * FROM `deztow_items` WHERE `room` = '".$user['room']."';");
	if(mysql_num_rows($its)>0) {
		echo '<H4>В комнате разбросаны вещи:</H4>';
	}
	while($it = mysql_fetch_array($its)) {
		echo ' <A HREF="towerin.php?give=',$it['id'],'"><IMG SRC="i/sh/',$it['img'],'" ALT="Подобрать предмет \'',$it['name'],'\'"></A>';
	}

?>
</TD>
<TD colspan=3 valign=top align=right nowrap>
<link href="i/move/design4.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript">
function fastshow2 (content) {
	var el = document.getElementById("mmoves");
	var o = window.event.srcElement;
	if (content == '') { el.innerHTML =  '';}
	if (content!='' && el.style.visibility != "visible") {el.innerHTML = '<small>'+content+'</small>';}
	var x = window.event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft - el.offsetWidth + 5;
	var y = window.event.clientY + document.documentElement.scrollTop + document.body.scrollTop+20;
	if (x + el.offsetWidth + 3 > document.body.clientWidth + document.body.scrollLeft) { x=(document.body.clientWidth + document.body.scrollLeft - el.offsetWidth - 5); if (x < 0) {x=0}; }
	if (y + el.offsetHeight + 3 > document.body.clientHeight  + document.body.scrollTop) { y=(document.body.clientHeight + document.body.scrollTop - el.offsetHeight - 3); if (y < 0) {y=0}; }
	if (x<0) {x=0;}
	if (y<0) {y=0;}
	el.style.left = x + "px";
	el.style.top  = y + "px";
	if (el.style.visibility != "visible") {
		el.style.visibility = "visible";
	}
}
function hideshow () {
	document.getElementById("mmoves").style.visibility = 'hidden';
}
</script>

<script language="javascript" type="text/javascript">
var solo_store;
function solo(n, name) {
	if (check_access()==true) {
		window.location.href = '?path='+n+'&rnd='+Math.random();
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
	im.filters.Glow.Enabled=true;
	if ( from_map == false && im.id.match(/mo_(\d)/) && document.getElementById('b' + im.id)) {
		from_map = true;
		document.getElementById('b' + im.id).runtimeStyle.color = '#666666';
		from_map = false;
	}

}
function imout(im) {
	im.filters.Glow.Enabled=false;
	if ( from_map == false && im.id.match(/mo_(\d)/) && document.getElementById('b' + im.id)) {
		from_map = true;
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
function Down() {top.CtrlPress = window.event.ctrlKey}
document.onmousedown = Down;

var fireworks_types = new Array('04',21, '03',21, '05',21, '06',21, '07',27, '08',27, '02',34, '09',34, 
				'10',34, '11',42, '14', 27, '16', 32, '15', 37 );

function fireworks (x,y,type) {
	return start_fireworks(x,y,type);
}

function start_fireworks (x,y,type) {
	myFW = new JSFX.FireworkDisplay(1, "i/fireworks/fw"+fireworks_types[type*2], fireworks_types[type*2+1], x, y);
	myFW.start();
	return false;
}

function stop_fireworks (id) {
	document.getElementById(id).style.display = 'none';
	document.getElementById(id).removeNode(true);
	return false;
}

</script>
<style type="text/css">
    img.aFilter { filter:Glow(color=,Strength=,Enabled=0); cursor:hand }
	hr { height: 1px; }
</style>

<table  border="0" cellpadding="0" cellspacing="0">
	<tr align="right" valign="top">
		<td>

			<table cellpadding="0" cellspacing="0" border="0" width="1"><tr><td>
			<div style="position:relative; cursor: pointer;" id="ione"><img src="i/tower/<?=(500+$user['room'])?>.jpg" alt="" border="1"/>
			
			</div></td></tr>
			
				<tr><td align="right"><div align="right" id="btransfers"><table cellpadding="0" cellspacing="0" border="0" id="bmoveto">
				<tr><td bgcolor="#D3D3D3">
				
				</td>
				</tr>
				</table></div></td></tr>
			
			</table>
			
			</td>
		<td>
			
			<table width="80" border="0" cellspacing="0" cellpadding="0">
            	<tr>
            		
					<td><table width="80"  border="0" cellspacing="0" cellpadding="0">
                    	<tr>
                    		<td colspan="3" align="center"><img src="i/move/navigatin_46.gif" width="80" height="4" /></td>
                    		</tr>
                    	<tr>
                    		<td colspan="3" align="center"><table width="80"  border="0" cellspacing="0" cellpadding="0">
                    				<tr>
                    					<td><img src="i/move/navigatin_48.gif" width="9" height="8" /></td>
                    					<td width="100%" bgcolor="#000000"><table border="0" cellspacing="0" cellpadding="0">
                    							<tr>
                    								<td nowrap="nowrap" align="center"><div align="center" style="font-size:4px;padding:0px;border:solid black 0px; text-align:center" id="prcont"></div>
                        									<script language="javascript" type="text/javascript">
												var s="";for (i=1; i<=32; i++) {s+='<span id="progress'+i+'">&nbsp;</span>';if (i<32) {s+='&nbsp;'};}document.getElementById('prcont').innerHTML=s;
								  				</script>
                    									</td>
                    								</tr>
                    							</table></td>
                    					<td><img src="i/move/navigatin_50.gif" width="7" height="8" /></td>
                    					</tr>
                    				</table></td>
                    		</tr>
	
	<tr>
		<td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><img src="i/move/navigatin_51.gif" width="31" height="8" /></td>
				</tr>
				<tr>
					<td><img src="i/move/navigatin_54.gif" width="9" height="20" /><img src="i/move/navigatin_55i.gif" width="22" height="20" border="0" /></td>
				</tr>
				<tr>
					<td><a onclick="return check('m7');" <?if($rooms[$rhar[$user['room']][4]]) { echo 'id="m7"';}?> href="?rnd=0.817371946556865&path=4"><img src="i/move/navigatin_59<?if(!$rooms[$rhar[$user['room']][4]]) { echo 'i';}?>.gif" width="21" height="20" border="0" o<?if(!$rooms[$rhar[$user['room']][4]]) { echo 'i';}?>nmousemove="fastshow2('<?=$rooms[$rhar[$user['room']][4]]?>');" onmouseout="hideshow();" /></a><img src="i/move/navigatin_60.gif" width="10" height="20" border="0" /></td>
				</tr>
				<tr>
					<td><img src="i/move/navigatin_63.gif" width="11" height="21" /><img src="i/move/navigatin_64i.gif" width="20" height="21" border="0" /></td>
				</tr>
				<tr>
					<td><img src="i/move/navigatin_68.gif" width="31" height="8" /></td>
				</tr>
		</table></td>
		<td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a onclick="return check('m1');" <?if($rooms[$rhar[$user['room']][1]]) { echo 'id="m1"';}?> href="?rnd=0.817371946556865&path=1"><img src="i/move/navigatin_52<?if(!$rooms[$rhar[$user['room']][1]]) { echo 'i';}?>.gif" width="19" height="22" border="0" <?if(!$rooms[$rhar[$user['room']][1]]) { echo 'i';}?>onmousemove="fastshow2('<?=$rooms[$rhar[$user['room']][1]]?>');" onmouseout="hideshow();" /></a></td>
				</tr>
				<tr>
					<td><a href="?rnd=0.817371946556865"><img src="i/move/navigatin_58.gif" width="19" height="33" border="0" o nmousemove="fastshow2('<strong>Обновить</strong><br />Переходы:<br />Картинная галерея 1<br />Зал ораторов<br />Картинная галерея 3');" onmouseout="hideshow();" /></a></td>
				</tr>
				<tr>
					<td><a onclick="return check('m5');" <?if($rooms[$rhar[$user['room']][3]]) { echo 'id="m5"';}?> href="?rnd=0.817371946556865&path=3"><img src="i/move/navigatin_67<?if(!$rooms[$rhar[$user['room']][3]]) { echo 'i';}?>.gif" width="19" height="22" border="0" <?if(!$rooms[$rhar[$user['room']][3]]) { echo 'i';}?>onmousemove="fastshow2('<?=$rooms[$rhar[$user['room']][3]]?>');" onmouseout="hideshow();" /></a></td>
				</tr>
		</table></td>
		<td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><img src="i/move/navigatin_53.gif" width="30" height="8" /></td>
				</tr>
				<tr>
					<td><img src="i/move/navigatin_56i.gif" width="21" height="20" border="0" /><img src="i/move/navigatin_57.gif" width="9" height="20" /></td>
				</tr>
				<tr>
					<td><img src="i/move/navigatin_61.gif" width="8" height="21" /><a onclick="return check('m3');" <?if($rooms[$rhar[$user['room']][2]]) { echo 'id="m3"';}?> href="?rnd=0.817371946556865&path=2"><img src="i/move/navigatin_62<?if(!$rooms[$rhar[$user['room']][2]]) { echo 'i';}?>.gif" width="22" height="21" border="0" <?if(!$rooms[$rhar[$user['room']][2]]) { echo 'i';}?>onmousemove="fastshow2('<?=$rooms[$rhar[$user['room']][2]]?>');" onmouseout="hideshow();" /></a></td>
				</tr>
				<tr>
					<td><img src="i/move/navigatin_65i.gif" width="21" height="20" border="0" /><img src="i/move/navigatin_66.gif" width="9" height="20" /></td>
				</tr>
				<tr>
					<td><img src="i/move/navigatin_69.gif" width="30" height="8" /></td>
				</tr>
		</table></td>
	</tr>
	
                   	</table></td>
           		</tr>
          	</table>
			
			<table  border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td nowrap="nowrap" id="moveto">
						<table width="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#DEDEDE">
							
						</table>
					</td>
				</tr>
			</table>
			
			<!-- <br /><span class="menutop"><nobr>Картинная галерея 2</nobr></span>-->
			</td>
	</tr>
</table>
<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px; white-space: nowrap;"></div>
<script language="javascript" type="text/javascript">
var progressEnd = 32;		// set to number of progress <span>'s.
var progressColor = '#00CC00';	// set to progress bar color
var mtime = parseInt('<?=($_SESSION['time']-time())?>');
if (!mtime || mtime<=0) {mtime=0;}
var progressInterval = Math.round(mtime*1000/progressEnd);	// set to time between updates (milli-seconds)
var is_accessible = true;
var progressAt = progressEnd;
var progressTimer;
function progress_clear() {
	for (var i = 1; i <= progressEnd; i++) document.getElementById('progress'+i).style.backgroundColor = 'transparent';
	progressAt = 0;
	
	for (var t = 1; t <= 8; t++) {
		if (document.getElementById('m'+t) ) {
			var tempname = document.getElementById('m'+t).children[0].src;
			if (tempname.match(/b\.gif$/)) {
					document.getElementById('m'+t).children[0].id = 'backend';
			}
			var newname;
			newname = tempname.replace(/(b)?\.gif$/,'i.gif');
			document.getElementById('m'+t).children[0].src = newname;
		}
	}
	
	is_accessible = false;
	set_moveto(true);
}
function progress_update() {
	progressAt++;
	//if (progressAt > progressEnd) progress_clear();
	if (progressAt > progressEnd) {
		
		for (var t = 1; t <= 8; t++) {
			if (document.getElementById('m'+t) ) {
				var tempname = document.getElementById('m'+t).children[0].src;
				var newname;
				newname = tempname.replace(/i\.gif$/,'.gif');
				if (document.getElementById('m'+t).children[0].id == 'backend') {
					tempname = newname.replace(/\.gif$/,'b.gif');
					newname = tempname;
				}
				document.getElementById('m'+t).children[0].src = newname;
			}
		}
		
		is_accessible = true;
		if (window.solo_store && solo_store) { solo(solo_store); } // go to stored
		set_moveto(false);
	} else {document.getElementById('progress'+progressAt).style.backgroundColor = progressColor;
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
	progressColor = color;
	for (var i = 1; i <= progressAt; i++) {
		document.getElementById('progress'+i).style.backgroundColor = progressColor;
	}
}
// brrr
if (mtime>0) {
	progress_clear();
	progress_update();
} else {
	for (var i = 1; i <= progressEnd; i++) {
		document.getElementById('progress'+i).style.backgroundColor = progressColor;
	}
}
</script>

</TD>
</TR>
</TABLE>
<BR>Всего живых участников на данный момент: <B><?	
	echo "<B>".($ls[0]-$ls[1])."</B> + <B>".$ls[1]."</B>";
?></B>...<BR>
<div id=hint3 class=ahint></div>
<script>top.onlineReload(true)</script>
</BODY>
</HTML>

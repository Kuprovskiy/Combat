<?php
	session_start();
	include 'connect.php';
	$user = mysql_fetch_array(mysql_query('SELECT u.block,u.id,u.color,u.invis,u.align,u.klan,u.chattime,u.sid,u.login,u.level,u.room,o.date FROM `users` as u, `online` as o WHERE u.`id` = o.`id` AND u.`id` = \''.$_SESSION['uid'].'\' LIMIT 1;'));
if($user['block']>0){session_destroy();}
	if (!($_SESSION['uid'] >0)) {
		echo "<script>top.window.location='index.php?exit=0.560057875997465'</script>";	die();
	}
//if($user['klan']!='adminion'){session_destroy();}
//	$invis = mysql_fetch_array(mysql_query("SELECT * FROM `online` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
	header("Cache-Control: no-cache");

	include 'functions.php';
        nick99 ($user['id']);
	if($_GET['online'] != null) {
			if ($_GET['room'] && (int)$_GET['room'] < 900) { $user['room'] = (int)$_GET['room']; }
			$data = mysql_query('select align,u.id,klan,level,login,battle,o.date,invis, (SELECT `id` FROM `effects` WHERE `type` = 2 AND `owner` = u.id LIMIT 1) as slp, (SELECT `id` FROM `effects` WHERE (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14) AND `owner` = u.id LIMIT 1) as trv,deal FROM `online` as o, `users` as u WHERE o.`id` = u.`id` AND (o.`date` >= '.(time()-90).' OR u.`in_tower` = 1) AND o.`room` = '.$user['room'].' ORDER by `u`.`login`;');

?>
<HTML><HEAD><link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>

<SCRIPT>

	function w(name,id,align,klan,level,slp,trv,deal,battle,name2) {
			if (align.length>0) {
				altext="";
				if (align>2 && align<2.5) altext = "�����";
				if (align == 2.5) altext = "�����";
                if (align == 2.6) altext = "�����";
				if (align>2.6 && align<3) altext = "�����";
				if (align>3.00 && align<4) altext = "Ҹ���� ��������";
				if (align>1 && align<2 && klan !="FallenAngels") altext = "�������";
				if (align>1 && align<2 && klan =="FallenAngels") altext = "������ �����";
				if ( align == 0.98 ) altext ="Ҹ����";
				if ( align == 777 ) altext ="����� ���������";
				if ( align == 4 ) altext ="� �����";
				if ( align == 7 ) altext ="�������";
				if ( align == 0.99 ) altext ="�������";
				if (!name2) name2=name;
				align='<img src="i/align_'+align+'.gif" title="'+altext+'" width=13 height=15>';
				}
                        if(battle>0){filter = 'style="filter:invert"';}else{filter = '';}
			if (klan.length>0) { klan='<A HREF="/claninf.php?'+klan+'" target=_blank><img src="i/klan/'+klan+'.gif" title="'+klan+'" width=24 height=15></A>';}
			document.write('<A HREF="javascript:top.AddToPrivate(\''+name+'\', top.CtrlPress)" target=refreshed><img src="i/lock.gif" '+filter+' title="������" width=20 height=15></A>'+align+'<a href="(\''+name+'\',true)"></a>'+klan+'<a href="javascript:top.AddTo(\''+name+'\')" target=refreshed>'+name2+'</a>['+level+']<a href="inf.php?'+id+'" target=_blank title="���. � '+name+'">'+'<IMG SRC="i/inf.gif" WIDTH=12 HEIGHT=11 BORDER=0 ALT="���. � '+name+'"></a>');
			if (slp>0) { document.write(' <IMG SRC="i/sleep2.gif" WIDTH=24 HEIGHT=15 BORDER=0 ALT="�������� �������� ��������">'); }
			if (trv>0) { document.write(' <IMG SRC="i/travma2.gif" WIDTH=24 HEIGHT=15 BORDER=0 ALT="������������">'); }
			document.write('<BR>');
	}
	top.rld();
</SCRIPT>
<title><?=$rooms[$user['room']],' (',mysql_num_rows($data)?>)</title>
</HEAD>
<body mardginwidth=0 leftmardgin=0 leftmargin=0 marginwidth=0 bgcolor=#faf2f2 onscroll="top.myscroll()" onload="document.body.scrollTop=top.OnlineOldPosition">
<center>
<?php
if (!$_GET['room']) {
?>
<BR><INPUT TYPE=button value="��������" onclick="location='ch.php?online=708984'">
<?php }
if($user['room']==20 && vrag=="on"){$plroom=1;}
if($user['room']==1){$plroom=4;}
if($user['room']==403){$plroom=1;}
 ?>
</center>
<font style="COLOR:#8f0000;FONT-SIZE:10pt"><B><?=$rooms[$user['room']],' (',mysql_num_rows($data)+$plroom?>)</B></font>
<table border=0><tr><td nowrap><fant color="fffff">
<script>
<?php
if($user['room']==1){
			$vrag11 = mysql_fetch_array(mysql_query('select align,u.id,klan,level,login,o.date, (SELECT `id` FROM `effects` WHERE `type` = 2 AND `owner` = u.id LIMIT 1) as slp, (SELECT `id` FROM `effects` WHERE (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14) AND `owner` = u.id LIMIT 1) as trv,deal FROM `online` as o, `users` as u WHERE u.`id`=98 ;'));
		echo 'w(\'',$vrag11['login'],'\',',$vrag11['id'],',\'',$vrag11['align'],'\',\'',$vrag11['klan'],'\',\'',$vrag11['level'],'\',\'',$vrag11['slp'],'\',\'',$vrag11['trv'],'\',\'',(int)$row['deal'],'\',\'',$vrag_b11['battle'],'\');';
			$vrag22 = mysql_fetch_array(mysql_query('select align,u.id,klan,level,login,o.date, (SELECT `id` FROM `effects` WHERE `type` = 2 AND `owner` = u.id LIMIT 1) as slp, (SELECT `id` FROM `effects` WHERE (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14) AND `owner` = u.id LIMIT 1) as trv,deal FROM `online` as o, `users` as u WHERE u.`id`=171 ;'));
		echo 'w(\'',$vrag22['login'],'\',',$vrag22['id'],',\'',$vrag22['align'],'\',\'',$vrag22['klan'],'\',\'',$vrag22['level'],'\',\'',$vrag22['slp'],'\',\'',$vrag22['trv'],'\',\'',(int)$row['deal'],'\',\'',$vrag_b22['battle'],'\');';
		$vrag33 = mysql_fetch_array(mysql_query('select align,u.id,klan,level,login,o.date, (SELECT `id` FROM `effects` WHERE `type` = 2 AND `owner` = u.id LIMIT 1) as slp, (SELECT `id` FROM `effects` WHERE (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14) AND `owner` = u.id LIMIT 1) as trv,deal FROM `online` as o, `users` as u WHERE u.`id`=17 ;'));
		echo 'w(\'',$vrag33['login'],'\',',$vrag33['id'],',\'',$vrag33['align'],'\',\'',$vrag33['klan'],'\',\'',$vrag33['level'],'\',\'',$vrag33['slp'],'\',\'',$vrag33['trv'],'\',\'',(int)$row['deal'],'\',\'',$vrag_b33['battle'],'\');';
}
if($user['room']==403){
			$vrag22 = mysql_fetch_array(mysql_query('select align,u.id,klan,level,login,o.date, (SELECT `id` FROM `effects` WHERE `type` = 2 AND `owner` = u.id LIMIT 1) as slp, (SELECT `id` FROM `effects` WHERE (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14) AND `owner` = u.id LIMIT 1) as trv,deal FROM `online` as o, `users` as u WHERE u.`id`=24 ;'));
		echo 'w(\'',$vrag22['login'],'\',',$vrag22['id'],',\'',$vrag22['align'],'\',\'',$vrag22['klan'],'\',\'',$vrag22['level'],'\',\'',$vrag22['slp'],'\',\'',$vrag22['trv'],'\',\'',(int)$row['deal'],'\',\'',$vrag_b22['battle'],'\');';
}

if($user['room']==20 && vrag=="on"){
			$vrag = mysql_fetch_array(mysql_query('select align,u.id,klan,level,login,o.date, (SELECT `id` FROM `effects` WHERE `type` = 2 AND `owner` = u.id LIMIT 1) as slp, (SELECT `id` FROM `effects` WHERE (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14) AND `owner` = u.id LIMIT 1) as trv,deal FROM `online` as o, `users` as u WHERE u.`id`=99 ;'));
				$vrag_b = mysql_fetch_array(mysql_query("SELECT `battle` FROM `bots` WHERE  `prototype` = 99 LIMIT 1 ;"));

		echo 'w(\'',$vrag['login'],'\',',$vrag['id'],',\'',$vrag['align'],'\',\'',$vrag['klan'],'\',\'',$vrag['level'],'\',\'',$vrag['slp'],'\',\'',$vrag['trv'],'\',\'',(int)$row['deal'],'\',\'',$vrag_b['battle'],'\');';
}
		while($row=mysql_fetch_array($data))
		{
			//if ($row['slp']=='NULL')  { $row['slp'] = 0; }
                        if ($row['invis']>0 && $row['id']==$_SESSION['uid'])  { $row['login2'] = $row['login']."</a> (the invisible)"; }
			if($row['invis']==0 or $row['id']==$_SESSION['uid']){
			echo 'w(\'',$row['login'],'\',',$row['id'],',\'',$row['align'],'\',\'',$row['klan'],'\',\'',$row['level'],'\',\'',$row['slp'],'\',\'',$row['trv'],'\',\'',(int)$row['deal'],'\',\'',$row['battle'],'\',\'',$row['login2'],'\');';
			}
		}
?>
</script>
</td></tr></table>
<?php
if (!$_GET['room']) {
?>
	<SCRIPT>document.write('<INPUT TYPE=checkbox onclick="if(this.checked == true) { top.OnlineStop = false; } else { top.OnlineStop=true; }" '+(top.OnlineStop?'':'checked')+'> ��������� ���������.')
	</SCRIPT></body></html>
<?php
	die();
}
	}
	elseif (@$_GET['show'] != null) {
		echo "here";
		if($_SESSION['sid'] != $user['sid']) {
			//$_SESSION['uid'] = null;
			//die ("<script>top.location.href='index.php';</script>");
		}
		$cha = file("tmpdisk/chat.txt");
		header('Content-Type: text/html; charset=windows-1251');
		//echo "<script>";
		$ks = 0;
		die;
		foreach($cha as $k => $v) {
		echo "$v<br>";
			//echo "alert('df');";
			preg_match("/:\[(.*)\]:\[(.*)\]:\[(.*)]:\[(.*)\]/",$v,$math);
			//print_r($data);
			$math[3] = stripslashes($math[3]);
			if ((@$math[2] == '{[]}'.$user['login'].'{[]}') && (@$math[1] >= @$user['chattime'])) {
				echo "top.frames['chat'].document.all(\"mes\").innerHTML += '<span class=date2>".date("H:i",$math[1])."</span> ".$math[3]." <BR>';";
				$ks++;
				$lastpost = $math[1];
			}
			elseif(substr($math[2],0,4) == '{[]}' && (@$math[1] >= @$user['chattime'])) {
				//exit;
			}
			elseif ((@$math[2] == '!sys!!') && (@$math[1] >= @$user['chattime']) && ($user['room']==$math[4]) && $_GET['om'] != 1) {
				if($_GET['sys'] == 1 OR strpos($math[3],"<img src=i/magic/" ) !== FALSE) {
					echo "top.frames['chat'].document.all(\"mes\").innerHTML += '<span class=date>".date("H:i",$math[1])."</span> ".$math[3]." <BR>';";
					$ks++;
					$lastpost = $math[1];
				}
			}
			elseif (@$math[2] == '!sys2all!!' && @$math[1] >= @$user['chattime']) {
				echo "top.frames['chat'].document.all(\"mes\").innerHTML += '<span class=date>".date("H:i",$math[1])."</span> ".$math[3]." <BR>';";
				$ks++;
				$lastpost = $math[1];
			}
			elseif (@$math[1] >= @$user['chattime']) {
/*				if (strpos($math[3],"private [pal-" ) !== FALSE) {
					$chans = mysql_fetch_array(mysql_query("SELECT `name` FROM `chanels` WHERE `klan`='pal' AND `user` = '".$user['id']."';"));
					$chans = explode(",",$chans['name']) ;
					$pos = strpos($math[3],"[pal-" )+5;
					if(in_array(substr($math[3],$pos,1),$chans)) {
						$math[3] = preg_replace("/private \[pal-([1-9])]/Ue", "'<a href='.chr(92).'\'javascript:top.AddToPrivate(\"pal-\\1\",false)'.chr(92).'\' class=private>private [ pal-\\1 ]</a>'", $math[3]);
						//$math[3] = str_replace("private [{$user['login']}]", "<a href=javascript:top.AddToPrivate(\"{$math[2]}\",false) class=private>private [ {$user['login']} ]</a>",$math[3]);
						echo "top.frames['chat'].document.all(\"mes\").innerHTML += '<span class=date2>".date("H:i",$math[1])."</span> [<a href=\'javascript:top.AddTo(\"{$math[2]}\")\'><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] ".$math[3]." <BR>';";
						$ks++;
						$lastpost = $math[1];
					}
				}
			else*/if (@$math[1] >= @$user['chattime']) {
/*				if (strpos($math[3],"private [tar-" ) !== FALSE) {
					$chans = mysql_fetch_array(mysql_query("SELECT `name` FROM `chanels` WHERE `klan`='tar' AND `user` = '".$user['id']."';"));
					$chans = explode(",",$chans['name']) ;
					$pos = strpos($math[3],"[tar-" )+5;
					if(in_array(substr($math[3],$pos,1),$chans)) {
						$math[3] = preg_replace("/private \[tar-([1-9])]/Ue", "'<a href='.chr(92).'\'javascript:top.AddToPrivate(\"tar-\\1\",false)'.chr(92).'\' class=private>private [ tar-\\1 ]</a>'", $math[3]);
						//$math[3] = str_replace("private [{$user['login']}]", "<a href=javascript:top.AddToPrivate(\"{$math[2]}\",false) class=private>private [ {$user['login']} ]</a>",$math[3]);
						echo "top.frames['chat'].document.all(\"mes\").innerHTML += '<span class=date2>".date("H:i",$math[1])."</span> [<a href=\'javascript:top.AddTo(\"{$math[2]}\")\'><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] ".$math[3]." <BR>';";
						$ks++;
						$lastpost = $math[1];
					}
				}
				elseif (strpos($math[3],"private [klan-{$user['klan']}-" ) !== FALSE) {
					$chans = mysql_fetch_array(mysql_query("SELECT `name` FROM `chanels` WHERE `klan`='".$user['klan']."' AND `user` = '".$user['id']."';"));
					$chans = explode(",",$chans['name']) ;
					$pos = strpos($math[3],"[klan-{$user['klan']}-" )+strlen($user['klan'])+7;
					if(in_array(substr($math[3],$pos,1),$chans)) {
						$math[3] = preg_replace("/private \[klan-".$user['klan']."-([1-9])]/Ue", "'<a href='.chr(92).'\'javascript:top.AddToPrivate(\"klan-\\1\",false)'.chr(92).'\' class=private>private [ klan-\\1 ]</a>'", $math[3]);
						//$math[3] = str_replace("private [{$user['login']}]", "<a href=javascript:top.AddToPrivate(\"{$math[2]}\",false) class=private>private [ {$user['login']} ]</a>",$math[3]);
						echo "top.frames['chat'].document.all(\"mes\").innerHTML += '<span class=date2>".date("H:i",$math[1])."</span> [<a href=\'javascript:top.AddTo(\"{$math[2]}\")\'><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] ".$math[3]." <BR>';";
						$ks++;
						$lastpost = $math[1];
					}
				}
				else*/if (strpos($math[3],"private [pal]" ) !== FALSE) {
					if((int)$user['align']==1 OR $user['id'] == 1) {
						$math[3] = preg_replace("/private \[pal]/Ue", "'<a href='.chr(92).'\'javascript:top.AddToPrivate(\"pal\",false)'.chr(92).'\' class=private>private [ pal ]</a>'", $math[3]);
						//$math[3] = str_replace("private [{$user['login']}]", "<a href=javascript:top.AddToPrivate(\"{$math[2]}\",false) class=private>private [ {$user['login']} ]</a>",$math[3]);
						echo "top.frames['chat'].document.all(\"mes\").innerHTML += '<span class=date2>".date("H:i",$math[1])."</span> [<a href=\'javascript:top.AddTo(\"{$math[2]}\")\'><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] ".$math[3]." <BR>';";
						$ks++;
						$lastpost = $math[1];
					}
				}
				elseif (strpos($math[3],"private [tar]" ) !== FALSE) {
					if((int)$user['align']==3 OR $user['id'] == 1) {
						$math[3] = preg_replace("/private \[tar]/Ue", "'<a href='.chr(92).'\'javascript:top.AddToPrivate(\"tar\",false)'.chr(92).'\' class=private>private [ tar ]</a>'", $math[3]);
						//$math[3] = str_replace("private [{$user['login']}]", "<a href=javascript:top.AddToPrivate(\"{$math[2]}\",false) class=private>private [ {$user['login']} ]</a>",$math[3]);
						echo "top.frames['chat'].document.all(\"mes\").innerHTML += '<span class=date2>".date("H:i",$math[1])."</span> [<a href=\'javascript:top.AddTo(\"{$math[2]}\")\'><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] ".$math[3]." <BR>';";
						$ks++;
						$lastpost = $math[1];
					}
				}
				elseif (((strpos($math[3],"private [klan-{$user['klan']}]" ) !== FALSE) )) {
					if($user['klan']!='') {
					
					
					
						$math[3] = preg_replace("/private \[klan\-{$user['klan']}\]/Ue", "'<a href='.chr(92).'\'javascript:top.AddToPrivate(\"klan\",false)'.chr(92).'\' class=private>private [ klan ]</a>'", $math[3]);
						//$math[3] = str_replace("private [{$user['login']}]", "<a href=javascript:top.AddToPrivate(\"{$math[2]}\",false) class=private>private [ {$user['login']} ]</a>",$math[3]);
						echo "top.frames['chat'].document.all(\"mes\").innerHTML += '<span class=date2>".date("H:i",$math[1])."</span> [<a href=\'javascript:top.AddTo(\"{$math[2]}\")\'><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] ".$math[3]." <BR>';";
						$ks++;
						$lastpost = $math[1];
					}
				}
				elseif (((strpos($math[3],"private [{$user['login']}]" ) !== FALSE) OR ($math[2] == $user['login']))) {
					$sound=false;
					preg_match_all("/private \[(.*)\]/siU",$math[3],$mmm,PREG_PATTERN_ORDER);
					foreach($mmm[1] as $res){
						$res=trim($res);
						if ($sound==false)
							$sound=($res==$user['login'])?true:false;
						if (strlen($res)<3 || strlen($res)>25 || !ereg("^[�a-zA-Z�-��-�0-9-][�a-zA-Z�-��-�0-9_ -]+[a-zA-Z�-��-�0-9�-]$",$res)  || preg_match("/__/",$res) || preg_match("/--/",$res) || preg_match("/  /",$res) || preg_match("/(.)\\1\\1\\1/",$res)){
							$math[3]=str_replace($res,$user['login'],$math[3]);
						}
					}
					$math[3] = preg_replace("/private \[(.*)\]/Ue", "'<a href='.chr(92).'\'javascript:top.AddToPrivate(\"'.(('\\1' != '".$user['login']."')?'\\1':'".$math[2]."').'\",false)'.chr(92).'\' class=private>private [ <span oncontextmenu=\"return OpenMenu(event,".$user['level'].")\">\\1</span> ]</a>'", $math[3]);
					//$math[3] = str_replace("private [{$user['login']}]", "<a href=javascript:top.AddToPrivate(\"{$math[2]}\",false) class=private>private [ {$user['login']} ]</a>",$math[3]);
					$sssss="top.frames['chat'].document.all(\"mes\").innerHTML += '<span class=date2>".date("H:i",$math[1])."</span> [<a href=\'javascript:top.AddTo(\"{$math[2]}\")\'><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] ".$math[3]." <BR>';";
					if ($sound==true) 
						$sssss.="top.soundD();";
					echo $sssss;
					//echo "top.frames['chat'].document.all(\"mes\").innerHTML += '<span class=date2>".date("H:i",$math[1])."</span> [<a href=\'javascript:top.AddTo(\"{$math[2]}\")\'><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] ".$math[3]." <BR>';";
					$ks++;
					$lastpost = $math[1];
				}
				elseif(( strpos($math[3],"private" ) === FALSE ) && ($user['room']==$math[4]))
				{
					$times = ''; $soundON='';
					if ((strpos($math[3],"[".$user['login']."]") > 0) OR ($math[2] == $user['login'])) {
						$times = 'date2';
						//$math[3] = preg_replace("/to \[".$user['login']."\]/U", "<B>".$math[2]."</B>", $math[3]);
						$math[3] = str_replace("to [".$user['login']."]","<B>to [".$user['login']."]</B>",$math[3] );
						$soundON='top.soundD();';
					} elseif($_GET['om'] != 1) {
						$times = 'date';
					}
					if($_GET['om'] != 1 OR $times == 'date2') {
						echo $soundON."top.frames['chat'].document.all(\"mes\").innerHTML += '<span class={$times}>".date("H:i",$math[1])."</span> [<a href=\'javascript:top.AddTo(\"{$math[2]}\")\'><span oncontextmenu=\'return OpenMenu(event,".$user['level'].")\'>{$math[2]}</span></a>] ".$math[3]." <BR>';";
						$ks++;
						$lastpost = $math[1];
					}
				}
			}
		}
}
		if ($ks > 0) {
			mysql_query("UPDATE `users` SET `chattime` = '".($lastpost+3)."' WHERE `id` = {$user['id']};");
		}
		echo "</script><script> top.srld();</script>";
			if ((int)$user['id']!=1)
			mysql_query("UPDATE `online` SET `date` = ".time()." WHERE `id` = {$user['id']};");
			die();
	}
	else
	{
		if (strpos($_GET['text'],"private" ) !== FALSE && $user['level'] == 0) {
			preg_match_all("/\[(.*)\]/U", $_GET['text'], $matches);
			//echo "<script>alert('". $matches[1]."')</script>";
			for ($ii=0;$ii<count($matches[1]);$ii++){
				$dde = mysql_fetch_array(mysql_query("SELECT `id` FROM `users` WHERE (`klan` = 'adminion' OR `deal` = 1 OR (`align`>1 AND `align`<2) OR (`align`>3 AND `align`<4)) AND `login` = '".trim($matches[1][$ii])."' LIMIT 1 ;"));
				if (!$dde['id']) {
					exit;
				}
			}
		}
		if (@trim($_GET['text']) != null) {
			$rr = mysql_fetch_array(mysql_query("SELECT `id`  FROM `effects` WHERE `type` = 2 AND `owner` = {$user['id']};"));

		if ($rr[0] == null) {
			$_GET['text'] = substr($_GET['text'],0,200);
			$_GET['text'] = str_replace('<','&lt;',$_GET['text']);
			$_GET['text'] = str_replace(']:[','] : [',$_GET['text']);
			$_GET['text'] = str_replace('>','&gt;',$_GET['text']);


			$_GET['text'] = ereg_replace('private \[klan-([a-zA-Z]*)\]','',$_GET['text']);

			if ($user['klan'] == '') {
				$_GET['text'] = str_replace('private [klan]','',$_GET['text']);
				$_GET['text'] = str_replace('private [klan]','private [klan-'.$user['klan'].']',$_GET['text']);
			}
			else {
			   // $k1 = Array("/:\[klan-1\]:/","/:\[klan-2\]:/","/:\[klan-3\]:/","/:\[klan-4\]:/","/:\[klan-5\]:/","/:\[klan-6\]:/","/:\[klan-7\]:/","/:\[klan-8\]:/","/:\[klan-9\]:/");
				//$k2 = Array("[klan-".$user['klan']."-1]","[klan-".$user['klan']."-2]","[klan-".$user['klan']."-3]","[klan-".$user['klan']."-4]","[klan-".$user['klan']."-5]","[klan-".$user['klan']."-6]","[klan-".$user['klan']."-7]","[klan-".$user['klan']."-8]","[klan-".$user['klan']."-9]");
				$_GET['text'] = str_replace('private [klan]','private [klan-'.$user['klan'].']',$_GET['text']);

/*				$_GET['text'] = ereg_replace('private \[klan-([1-9])\]','private [klan-'.$user['klan'].'-\\1]',$_GET['text']);

				$chans = mysql_fetch_array(mysql_query("SELECT `name` FROM `chanels` WHERE `klan`='".$user['klan']."' AND `user` = '".$user['id']."';"));
				$chans = explode(",",$chans['name']) ;
				$pos = strpos($_GET['text'],"[klan-{$user['klan']}-" )+strlen($user['klan'])+7;
                if(!in_array(substr($_GET['text'],$pos,1),$chans)) {
					$_GET['text'] = ereg_replace("private \[klan-{$user['klan']}-[1-9]\]",'',$_GET['text']);
				}

*/				//$_GET['text'] = preg_replace($k1, $k2, $_GET['text'],3);
			}
				if((int)$user['align'] != 1 AND $user['id'] != 1) {
				$_GET['text'] = str_replace('private [pal]','',$_GET['text']);
//				$_GET['text'] = ereg_replace("private \[pal-[1-9]\]",'',$_GET['text']);
			}/* else {
				$chans = mysql_fetch_array(mysql_query("SELECT `name` FROM `chanels` WHERE `klan`='pal' AND `user` = '".$user['id']."';"));
				$chans = explode(",",$chans['name']) ;
				$pos = strpos($_GET['text'],"[pal-" )+5;
                if(!in_array(substr($_GET['text'],$pos,1),$chans)) {
					$_GET['text'] = ereg_replace("private \[pal-[1-9]\]",'',$_GET['text']);
				}
			}*/
				if((int)$user['align'] != 3 AND $user['id'] != 1) {
				$_GET['text'] = str_replace('private [tar]','',$_GET['text']);
//				$_GET['text'] = ereg_replace("private \[tar-[1-9]\]",'',$_GET['text']);
			}/* else {
				$chans = mysql_fetch_array(mysql_query("SELECT `name` FROM `chanels` WHERE `klan`='tar' AND `user` = '".$user['id']."';"));
				$chans = explode(",",$chans['name']) ;
				$pos = strpos($_GET['text'],"[tar-" )+5;
                if(!in_array(substr($_GET['text'],$pos,1),$chans)) {
					$_GET['text'] = ereg_replace("private \[tar-[1-9]\]",'',$_GET['text']);
				}
			}*/

if($user['level']<=1){
			$_GET['text'] = eregi_replace('o(.)*l(.)*d(.)*c(.)*o(.)*m(.)*b(.)*a(.)*t(.)*s','<b><font color=red> � � ���-���!</font></b>',$_GET['text']);
			$_GET['text'] = eregi_replace('a(.)*r(.)*d(.)*a(.)*n(.)*i(.)*y(.)*a','<b><font color=red> � � ���-���!</font></b>',$_GET['text']);
			$_GET['text'] = eregi_replace('l(.)*f(.)*i(.)*g(.)*h(.)*t','<b><font color=red> � � ���-���!</font></b>',$_GET['text']);
			$_GET['text'] = eregi_replace('a(.)*r(.)*d(.)*a(.)*n(.)*u(.)*y(.)*a','<b><font color=red> � � ���-���!</font></b>',$_GET['text']);
			$_GET['text'] = eregi_replace('o(.)*l(.)*d(.)*b(.)*k','<b><font color=red> � � ���-���!</font></b>',$_GET['text']);
			$_GET['text'] = eregi_replace('n(.)*e(.)*w(.)*-(.)*b(.)*k','<b><font color=red> � � ���-���!</font></b>',$_GET['text']);
			$_GET['text'] = eregi_replace('a(.)*r(.)*d(.)*a(.)*n(.)*u(.)*y(.)*a','<b><font color=red> � � ���-���!</font></b>',$_GET['text']);
			$_GET['text'] = eregi_replace('l(.)*a(.)*s(.)*t(.)*w(.)*o(.)*r(.)*l(.)*d(.)*s','<b><font color=red> � � ���-���!</font></b>',$_GET['text']);
			$_GET['text'] = eregi_replace('t(.)*e(.)*k(.)*k(.)*e(.)*n','<b><font color=red> � � ���-���!</font></b>',$_GET['text']);
			$_GET['text'] = eregi_replace('n(.)*e(.)*w(.)*a(.)*b(.)*k','<b><font color=red> � � ���-���!</font></b>',$_GET['text']);

}
			//$smiles = Array("/:flowers:/","/:inv:/","/:hug:/","/:horse:/","/:str:/","/:susel:/","/:smile:/","/:laugh:/","/:fingal:/","/:eek:/","/:smoke:/","/:hi:/","/:bye:/","/:king:/","/:king2:/","/:boks2:/","/:boks:/","/:gent:/","/:lady:/","/:tongue:/","/:smil:/","/:rotate:/","/:ponder:/","/:bow:/","/:angel:/","/:angel2:/","/:hello:/","/:dont:/","/:idea:/", "/:mol:/", "/:super:/","/:beer:/","/:drink:/","/:baby:/","/:tongue2:/", "/:sword:/", "/:agree:/","/:loveya:/","/:kiss:/","/:kiss2:/", "/:kiss3:/", "/:kiss4:/","/:rose:/","/:love:/","/:love2:/", "/:confused:/", "/:yes:/","/:no:/","/:shuffle:/","/:nono:/","/:maniac:/","/:privet:/","/:ok:/","/:ninja:/","/:pif:/", "/:smash:/","/:alien:/","/:pirate:/","/:gun:/","/:trup:/","/:mdr:/", "/:sneeze:/","/:mad:/","/:friday:/","/:cry:/","/:grust:/","/:rupor:/","/:fie:/", "/:nnn:/","/:row:/","/:red:/","/:lick:/","/:help:/","/:wink:/","/:jeer:/","/:tease:/","/:kruger:/","/:girl:/","/:Knight1:/","/:rev:/","/:smile100:/","/:smile118:/","/:smile149:/","/:smile166:/","/:smile237:/","/:smile245:/","/:smile28:/","/:smile289:/","/:smile314:/","/:smile36:/","/:smile39:/","/:smile44:/","/:smile70:/","/:smile87:/","/:smile434:/","/:vamp:/");
			$smiles = Array("/:001:/","/:005:/","/:007:/","/:006:/","/:010:/","/:018:/","/:022:/","/:019:/","/:026:/","/:034:/","/:033:/","/:037:/","/:038:/","/:036:/","/:040:/","/:039:/","/:043:/","/:049:/","/:052:/","/:056:/","/:059:/","/:057:/","/:062:/","/:066:/","/:068:/","/:073:/","/:082:/","/:080:/","/:079:/","/:083:/","/:086:/","/:085:/","/:114:/","/:118:/","/:119:/","/:123:/","/:161:/","/:158:/","/:164:/","/:167:/","/:166:/","/:170:/","/:174:/","/:177:/","/:175:/","/:179:/","/:178:/","/:186:/","/:189:/","/:188:/","/:190:/","/:202:/","/:205:/","/:203:/","/:206:/","/:221:/","/:237:/","/:239:/","/:238:/","/:243:/","/:246:/","/:254:/","/:253:/","/:255:/","/:277:/","/:276:/","/:275:/","/:278:/","/:284:/","/:289:/","/:288:/","/:294:/","/:293:/","/:295:/","/:310:/","/:313:/","/:324:/","/:336:/","/:347:/","/:346:/","/:345:/","/:348:/","/:349:/","/:351:/","/:352:/","/:1000:/","/:361:/","/:362:/","/:366:/","/:367:/","/:382:/","/:393:/","/:411:/","/:415:/","/:413:/","/:419:/","/:422:/","/:434:/","/:442:/","/:447:/","/:453:/","/:467:/","/:471:/","/:472:/","/:475:/","/:551:/","/:554:/","/:559:/","/:564:/","/:568:/","/:573:/","/:600:/","/:601:/","/:602:/","/:603:/","/:604:/","/:605:/","/:606:/","/:607:/","/:608:/","/:609:/","/:610:/","/:611:/","/:612:/","/:613:/","/:614:/","/:615:/","/:616:/","/:617:/","/:618:/","/:619:/","/:620:/","/:621:/","/:622:/","/:000:/","/:029:/","/:030:/","/:077:/","/:126:/","/:127:/","/:131:/","/:155:/","/:156:/","/:267:/","/:297:/","/:319:/","/:350:/","/:353:/","/:354:/","/:357:/","/:358:/","/:368:/","/:376:/","/:385:/","/:386:/","/:414:/","/:417:/","/:457:/","/:459:/","/:469:/","/:473:/","/:474:/","/:477:/","/:552:/","/:558:/","/:560:/","/:570:/","/:574:/","/:575:/","/:576:/","/:579:/","/:950:/","/:951:/","/:952:/","/:953:/","/:954:/","/:955:/","/:956:/","/:957:/","/:958:/","/:959:/","/:960:/","/:002:/","/:003:/","/:004:/","/:008:/","/:009:/","/:011:/","/:012:/","/:013:/","/:014:/","/:015:/","/:016:/","/:021:/","/:023:/","/:024:/","/:025:/","/:027:/","/:028:/","/:031:/","/:032:/","/:623:/","/:624:/","/:625:/","/:626:/","/:627:/","/:628:/","/:629:/","/:630:/","/:631:/","/:632:/","/:633:/","/:634:/","/:635:/","/:636:/","/:637:/","/:638:/","/:639:/","/:640:/","/:641:/","/:642:/","/:643:/","/:644:/","/:645:/","/:646:/","/:647:/","/:648:/","/:650:/","/:651:/","/:652:/","/:653:/","/:654:/","/:655:/","/:656:/","/:657:/");
			$smiles2 = Array("<img style=\"cursor:pointer;\" onclick=S(\"001\") src=chat/smiles/smiles_001.gif>","<img style=\"cursor:pointer;\" onclick=S(\"005\") src=chat/smiles/smiles_005.gif>","<img style=\"cursor:pointer;\" onclick=S(\"007\") src=chat/smiles/smiles_007.gif>","<img style=\"cursor:pointer;\" onclick=S(\"006\") src=chat/smiles/smiles_006.gif>","<img style=\"cursor:pointer;\" onclick=S(\"010\") src=chat/smiles/smiles_010.gif>","<img style=\"cursor:pointer;\" onclick=S(\"018\") src=chat/smiles/smiles_018.gif>","<img style=\"cursor:pointer;\" onclick=S(\"022\") src=chat/smiles/smiles_022.gif>","<img style=\"cursor:pointer;\" onclick=S(\"019\") src=chat/smiles/smiles_019.gif>","<img style=\"cursor:pointer;\" onclick=S(\"026\") src=chat/smiles/smiles_026.gif>","<img style=\"cursor:pointer;\" onclick=S(\"034\") src=chat/smiles/smiles_034.gif>","<img style=\"cursor:pointer;\" onclick=S(\"033\") src=chat/smiles/smiles_033.gif>","<img style=\"cursor:pointer;\" onclick=S(\"037\") src=chat/smiles/smiles_037.gif>","<img style=\"cursor:pointer;\" onclick=S(\"038\") src=chat/smiles/smiles_038.gif>","<img style=\"cursor:pointer;\" onclick=S(\"036\") src=chat/smiles/smiles_036.gif>","<img style=\"cursor:pointer;\" onclick=S(\"040\") src=chat/smiles/smiles_040.gif>","<img style=\"cursor:pointer;\" onclick=S(\"039\") src=chat/smiles/smiles_039.gif>","<img style=\"cursor:pointer;\" onclick=S(\"043\") src=chat/smiles/smiles_043.gif>","<img style=\"cursor:pointer;\" onclick=S(\"049\") src=chat/smiles/smiles_049.gif>","<img style=\"cursor:pointer;\" onclick=S(\"052\") src=chat/smiles/smiles_052.gif>","<img style=\"cursor:pointer;\" onclick=S(\"056\") src=chat/smiles/smiles_056.gif>","<img style=\"cursor:pointer;\" onclick=S(\"059\") src=chat/smiles/smiles_059.gif>","<img style=\"cursor:pointer;\" onclick=S(\"057\") src=chat/smiles/smiles_057.gif>","<img style=\"cursor:pointer;\" onclick=S(\"062\") src=chat/smiles/smiles_062.gif>","<img style=\"cursor:pointer;\" onclick=S(\"066\") src=chat/smiles/smiles_066.gif>","<img style=\"cursor:pointer;\" onclick=S(\"068\") src=chat/smiles/smiles_068.gif>","<img style=\"cursor:pointer;\" onclick=S(\"073\") src=chat/smiles/smiles_073.gif>","<img style=\"cursor:pointer;\" onclick=S(\"082\") src=chat/smiles/smiles_082.gif>","<img style=\"cursor:pointer;\" onclick=S(\"080\") src=chat/smiles/smiles_080.gif>","<img style=\"cursor:pointer;\" onclick=S(\"079\") src=chat/smiles/smiles_079.gif>","<img style=\"cursor:pointer;\" onclick=S(\"083\") src=chat/smiles/smiles_083.gif>","<img style=\"cursor:pointer;\" onclick=S(\"086\") src=chat/smiles/smiles_086.gif>","<img style=\"cursor:pointer;\" onclick=S(\"085\") src=chat/smiles/smiles_085.gif>","<img style=\"cursor:pointer;\" onclick=S(\"114\") src=chat/smiles/smiles_114.gif>","<img style=\"cursor:pointer;\" onclick=S(\"118\") src=chat/smiles/smiles_118.gif>","<img style=\"cursor:pointer;\" onclick=S(\"119\") src=chat/smiles/smiles_119.gif>","<img style=\"cursor:pointer;\" onclick=S(\"123\") src=chat/smiles/smiles_123.gif>","<img style=\"cursor:pointer;\" onclick=S(\"161\") src=chat/smiles/smiles_161.gif>","<img style=\"cursor:pointer;\" onclick=S(\"158\") src=chat/smiles/smiles_158.gif>","<img style=\"cursor:pointer;\" onclick=S(\"164\") src=chat/smiles/smiles_164.gif>","<img style=\"cursor:pointer;\" onclick=S(\"167\") src=chat/smiles/smiles_167.gif>","<img style=\"cursor:pointer;\" onclick=S(\"166\") src=chat/smiles/smiles_166.gif>","<img style=\"cursor:pointer;\" onclick=S(\"170\") src=chat/smiles/smiles_170.gif>","<img style=\"cursor:pointer;\" onclick=S(\"174\") src=chat/smiles/smiles_174.gif>","<img style=\"cursor:pointer;\" onclick=S(\"177\") src=chat/smiles/smiles_177.gif>","<img style=\"cursor:pointer;\" onclick=S(\"175\") src=chat/smiles/smiles_175.gif>","<img style=\"cursor:pointer;\" onclick=S(\"179\") src=chat/smiles/smiles_179.gif>","<img style=\"cursor:pointer;\" onclick=S(\"178\") src=chat/smiles/smiles_178.gif>","<img style=\"cursor:pointer;\" onclick=S(\"186\") src=chat/smiles/smiles_186.gif>","<img style=\"cursor:pointer;\" onclick=S(\"189\") src=chat/smiles/smiles_189.gif>","<img style=\"cursor:pointer;\" onclick=S(\"188\") src=chat/smiles/smiles_188.gif>","<img style=\"cursor:pointer;\" onclick=S(\"190\") src=chat/smiles/smiles_190.gif>","<img style=\"cursor:pointer;\" onclick=S(\"202\") src=chat/smiles/smiles_202.gif>","<img style=\"cursor:pointer;\" onclick=S(\"205\") src=chat/smiles/smiles_205.gif>","<img style=\"cursor:pointer;\" onclick=S(\"203\") src=chat/smiles/smiles_203.gif>","<img style=\"cursor:pointer;\" onclick=S(\"206\") src=chat/smiles/smiles_206.gif>","<img style=\"cursor:pointer;\" onclick=S(\"221\") src=chat/smiles/smiles_221.gif>","<img style=\"cursor:pointer;\" onclick=S(\"237\") src=chat/smiles/smiles_237.gif>","<img style=\"cursor:pointer;\" onclick=S(\"239\") src=chat/smiles/smiles_239.gif>","<img style=\"cursor:pointer;\" onclick=S(\"238\") src=chat/smiles/smiles_238.gif>","<img style=\"cursor:pointer;\" onclick=S(\"243\") src=chat/smiles/smiles_243.gif>","<img style=\"cursor:pointer;\" onclick=S(\"246\") src=chat/smiles/smiles_246.gif>","<img style=\"cursor:pointer;\" onclick=S(\"254\") src=chat/smiles/smiles_254.gif>","<img style=\"cursor:pointer;\" onclick=S(\"253\") src=chat/smiles/smiles_253.gif>","<img style=\"cursor:pointer;\" onclick=S(\"255\") src=chat/smiles/smiles_255.gif>","<img style=\"cursor:pointer;\" onclick=S(\"277\") src=chat/smiles/smiles_277.gif>","<img style=\"cursor:pointer;\" onclick=S(\"276\") src=chat/smiles/smiles_276.gif>","<img style=\"cursor:pointer;\" onclick=S(\"275\") src=chat/smiles/smiles_275.gif>","<img style=\"cursor:pointer;\" onclick=S(\"278\") src=chat/smiles/smiles_278.gif>","<img style=\"cursor:pointer;\" onclick=S(\"284\") src=chat/smiles/smiles_284.gif>","<img style=\"cursor:pointer;\" onclick=S(\"289\") src=chat/smiles/smiles_289.gif>","<img style=\"cursor:pointer;\" onclick=S(\"288\") src=chat/smiles/smiles_288.gif>","<img style=\"cursor:pointer;\" onclick=S(\"294\") src=chat/smiles/smiles_294.gif>","<img style=\"cursor:pointer;\" onclick=S(\"293\") src=chat/smiles/smiles_293.gif>","<img style=\"cursor:pointer;\" onclick=S(\"295\") src=chat/smiles/smiles_295.gif>","<img style=\"cursor:pointer;\" onclick=S(\"310\") src=chat/smiles/smiles_310.gif>","<img style=\"cursor:pointer;\" onclick=S(\"313\") src=chat/smiles/smiles_313.gif>","<img style=\"cursor:pointer;\" onclick=S(\"324\") src=chat/smiles/smiles_324.gif>","<img style=\"cursor:pointer;\" onclick=S(\"336\") src=chat/smiles/smiles_336.gif>","<img style=\"cursor:pointer;\" onclick=S(\"347\") src=chat/smiles/smiles_347.gif>","<img style=\"cursor:pointer;\" onclick=S(\"346\") src=chat/smiles/smiles_346.gif>","<img style=\"cursor:pointer;\" onclick=S(\"345\") src=chat/smiles/smiles_345.gif>","<img style=\"cursor:pointer;\" onclick=S(\"348\") src=chat/smiles/smiles_348.gif>","<img style=\"cursor:pointer;\" onclick=S(\"349\") src=chat/smiles/smiles_349.gif>","<img style=\"cursor:pointer;\" onclick=S(\"351\") src=chat/smiles/smiles_351.gif>","<img style=\"cursor:pointer;\" onclick=S(\"352\") src=chat/smiles/smiles_352.gif>","<img style=\"cursor:pointer;\" onclick=S(\"1000\") src=chat/smiles/smiles_1000.gif>","<img style=\"cursor:pointer;\" onclick=S(\"361\") src=chat/smiles/smiles_361.gif>","<img style=\"cursor:pointer;\" onclick=S(\"362\") src=chat/smiles/smiles_362.gif>","<img style=\"cursor:pointer;\" onclick=S(\"366\") src=chat/smiles/smiles_366.gif>","<img style=\"cursor:pointer;\" onclick=S(\"367\") src=chat/smiles/smiles_367.gif>","<img style=\"cursor:pointer;\" onclick=S(\"382\") src=chat/smiles/smiles_382.gif>","<img style=\"cursor:pointer;\" onclick=S(\"393\") src=chat/smiles/smiles_393.gif>","<img style=\"cursor:pointer;\" onclick=S(\"411\") src=chat/smiles/smiles_411.gif>","<img style=\"cursor:pointer;\" onclick=S(\"415\") src=chat/smiles/smiles_415.gif>","<img style=\"cursor:pointer;\" onclick=S(\"413\") src=chat/smiles/smiles_413.gif>","<img style=\"cursor:pointer;\" onclick=S(\"419\") src=chat/smiles/smiles_419.gif>","<img style=\"cursor:pointer;\" onclick=S(\"422\") src=chat/smiles/smiles_422.gif>","<img style=\"cursor:pointer;\" onclick=S(\"434\") src=chat/smiles/smiles_434.gif>","<img style=\"cursor:pointer;\" onclick=S(\"442\") src=chat/smiles/smiles_442.gif>","<img style=\"cursor:pointer;\" onclick=S(\"447\") src=chat/smiles/smiles_447.gif>","<img style=\"cursor:pointer;\" onclick=S(\"453\") src=chat/smiles/smiles_453.gif>","<img style=\"cursor:pointer;\" onclick=S(\"467\") src=chat/smiles/smiles_467.gif>","<img style=\"cursor:pointer;\" onclick=S(\"471\") src=chat/smiles/smiles_471.gif>","<img style=\"cursor:pointer;\" onclick=S(\"472\") src=chat/smiles/smiles_472.gif>","<img style=\"cursor:pointer;\" onclick=S(\"475\") src=chat/smiles/smiles_475.gif>","<img style=\"cursor:pointer;\" onclick=S(\"551\") src=chat/smiles/smiles_551.gif>","<img style=\"cursor:pointer;\" onclick=S(\"554\") src=chat/smiles/smiles_554.gif>","<img style=\"cursor:pointer;\" onclick=S(\"559\") src=chat/smiles/smiles_559.gif>","<img style=\"cursor:pointer;\" onclick=S(\"564\") src=chat/smiles/smiles_564.gif>","<img style=\"cursor:pointer;\" onclick=S(\"568\") src=chat/smiles/smiles_568.gif>","<img style=\"cursor:pointer;\" onclick=S(\"573\") src=chat/smiles/smiles_573.gif>","<img style=\"cursor:pointer;\" onclick=S(\"600\") src=chat/smiles/smiles_600.gif>","<img style=\"cursor:pointer;\" onclick=S(\"601\") src=chat/smiles/smiles_601.gif>","<img style=\"cursor:pointer;\" onclick=S(\"602\") src=chat/smiles/smiles_602.gif>","<img style=\"cursor:pointer;\" onclick=S(\"603\") src=chat/smiles/smiles_603.gif>","<img style=\"cursor:pointer;\" onclick=S(\"604\") src=chat/smiles/smiles_604.gif>","<img style=\"cursor:pointer;\" onclick=S(\"605\") src=chat/smiles/smiles_605.gif>","<img style=\"cursor:pointer;\" onclick=S(\"606\") src=chat/smiles/smiles_606.gif>","<img style=\"cursor:pointer;\" onclick=S(\"607\") src=chat/smiles/smiles_607.gif>","<img style=\"cursor:pointer;\" onclick=S(\"608\") src=chat/smiles/smiles_608.gif>","<img style=\"cursor:pointer;\" onclick=S(\"609\") src=chat/smiles/smiles_609.gif>","<img style=\"cursor:pointer;\" onclick=S(\"610\") src=chat/smiles/smiles_610.gif>","<img style=\"cursor:pointer;\" onclick=S(\"611\") src=chat/smiles/smiles_611.gif>","<img style=\"cursor:pointer;\" onclick=S(\"612\") src=chat/smiles/smiles_612.gif>","<img style=\"cursor:pointer;\" onclick=S(\"613\") src=chat/smiles/smiles_613.gif>","<img style=\"cursor:pointer;\" onclick=S(\"614\") src=chat/smiles/smiles_614.gif>","<img style=\"cursor:pointer;\" onclick=S(\"615\") src=chat/smiles/smiles_615.gif>","<img style=\"cursor:pointer;\" onclick=S(\"616\") src=chat/smiles/smiles_616.gif>","<img style=\"cursor:pointer;\" onclick=S(\"617\") src=chat/smiles/smiles_617.gif>","<img style=\"cursor:pointer;\" onclick=S(\"618\") src=chat/smiles/smiles_618.gif>","<img style=\"cursor:pointer;\" onclick=S(\"619\") src=chat/smiles/smiles_619.gif>","<img style=\"cursor:pointer;\" onclick=S(\"620\") src=chat/smiles/smiles_620.gif>","<img style=\"cursor:pointer;\" onclick=S(\"621\") src=chat/smiles/smiles_621.gif>","<img style=\"cursor:pointer;\" onclick=S(\"622\") src=chat/smiles/smiles_622.gif>","<img style=\"cursor:pointer;\" onclick=S(\"000\") src=chat/smiles/smiles_000.gif>","<img style=\"cursor:pointer;\" onclick=S(\"029\") src=chat/smiles/smiles_029.gif>","<img style=\"cursor:pointer;\" onclick=S(\"030\") src=chat/smiles/smiles_030.gif>","<img style=\"cursor:pointer;\" onclick=S(\"077\") src=chat/smiles/smiles_077.gif>","<img style=\"cursor:pointer;\" onclick=S(\"126\") src=chat/smiles/smiles_126.gif>","<img style=\"cursor:pointer;\" onclick=S(\"127\") src=chat/smiles/smiles_127.gif>","<img style=\"cursor:pointer;\" onclick=S(\"131\") src=chat/smiles/smiles_131.gif>","<img style=\"cursor:pointer;\" onclick=S(\"155\") src=chat/smiles/smiles_155.gif>","<img style=\"cursor:pointer;\" onclick=S(\"156\") src=chat/smiles/smiles_156.gif>","<img style=\"cursor:pointer;\" onclick=S(\"267\") src=chat/smiles/smiles_267.gif>","<img style=\"cursor:pointer;\" onclick=S(\"297\") src=chat/smiles/smiles_297.gif>","<img style=\"cursor:pointer;\" onclick=S(\"319\") src=chat/smiles/smiles_319.gif>","<img style=\"cursor:pointer;\" onclick=S(\"350\") src=chat/smiles/smiles_350.gif>","<img style=\"cursor:pointer;\" onclick=S(\"353\") src=chat/smiles/smiles_353.gif>","<img style=\"cursor:pointer;\" onclick=S(\"354\") src=chat/smiles/smiles_354.gif>","<img style=\"cursor:pointer;\" onclick=S(\"357\") src=chat/smiles/smiles_357.gif>","<img style=\"cursor:pointer;\" onclick=S(\"358\") src=chat/smiles/smiles_358.gif>","<img style=\"cursor:pointer;\" onclick=S(\"368\") src=chat/smiles/smiles_368.gif>","<img style=\"cursor:pointer;\" onclick=S(\"376\") src=chat/smiles/smiles_376.gif>","<img style=\"cursor:pointer;\" onclick=S(\"385\") src=chat/smiles/smiles_385.gif>","<img style=\"cursor:pointer;\" onclick=S(\"386\") src=chat/smiles/smiles_386.gif>","<img style=\"cursor:pointer;\" onclick=S(\"414\") src=chat/smiles/smiles_414.gif>","<img style=\"cursor:pointer;\" onclick=S(\"417\") src=chat/smiles/smiles_417.gif>","<img style=\"cursor:pointer;\" onclick=S(\"457\") src=chat/smiles/smiles_457.gif>","<img style=\"cursor:pointer;\" onclick=S(\"459\") src=chat/smiles/smiles_459.gif>","<img style=\"cursor:pointer;\" onclick=S(\"469\") src=chat/smiles/smiles_469.gif>","<img style=\"cursor:pointer;\" onclick=S(\"473\") src=chat/smiles/smiles_473.gif>","<img style=\"cursor:pointer;\" onclick=S(\"474\") src=chat/smiles/smiles_474.gif>","<img style=\"cursor:pointer;\" onclick=S(\"477\") src=chat/smiles/smiles_477.gif>","<img style=\"cursor:pointer;\" onclick=S(\"552\") src=chat/smiles/smiles_552.gif>","<img style=\"cursor:pointer;\" onclick=S(\"558\") src=chat/smiles/smiles_558.gif>","<img style=\"cursor:pointer;\" onclick=S(\"560\") src=chat/smiles/smiles_560.gif>","<img style=\"cursor:pointer;\" onclick=S(\"570\") src=chat/smiles/smiles_570.gif>","<img style=\"cursor:pointer;\" onclick=S(\"574\") src=chat/smiles/smiles_574.gif>","<img style=\"cursor:pointer;\" onclick=S(\"575\") src=chat/smiles/smiles_575.gif>","<img style=\"cursor:pointer;\" onclick=S(\"576\") src=chat/smiles/smiles_576.gif>","<img style=\"cursor:pointer;\" onclick=S(\"579\") src=chat/smiles/smiles_579.gif>","<img style=\"cursor:pointer;\" onclick=S(\"950\") src=chat/smiles/smiles_950.gif>","<img style=\"cursor:pointer;\" onclick=S(\"951\") src=chat/smiles/smiles_951.gif>","<img style=\"cursor:pointer;\" onclick=S(\"952\") src=chat/smiles/smiles_952.gif>","<img style=\"cursor:pointer;\" onclick=S(\"953\") src=chat/smiles/smiles_953.gif>","<img style=\"cursor:pointer;\" onclick=S(\"954\") src=chat/smiles/smiles_954.gif>","<img style=\"cursor:pointer;\" onclick=S(\"955\") src=chat/smiles/smiles_955.gif>","<img style=\"cursor:pointer;\" onclick=S(\"956\") src=chat/smiles/smiles_956.gif>","<img style=\"cursor:pointer;\" onclick=S(\"957\") src=chat/smiles/smiles_957.gif>","<img style=\"cursor:pointer;\" onclick=S(\"958\") src=chat/smiles/smiles_958.gif>","<img style=\"cursor:pointer;\" onclick=S(\"959\") src=chat/smiles/smiles_959.gif>","<img style=\"cursor:pointer;\" onclick=S(\"960\") src=chat/smiles/smiles_960.gif>","<img style=\"cursor:pointer;\" onclick=S(\"002\") src=chat/smiles/smiles_002.gif>","<img style=\"cursor:pointer;\" onclick=S(\"003\") src=chat/smiles/smiles_003.gif>","<img style=\"cursor:pointer;\" onclick=S(\"004\") src=chat/smiles/smiles_004.gif>","<img style=\"cursor:pointer;\" onclick=S(\"008\") src=chat/smiles/smiles_008.gif>","<img style=\"cursor:pointer;\" onclick=S(\"009\") src=chat/smiles/smiles_009.gif>","<img style=\"cursor:pointer;\" onclick=S(\"011\") src=chat/smiles/smiles_011.gif>","<img style=\"cursor:pointer;\" onclick=S(\"012\") src=chat/smiles/smiles_012.gif>","<img style=\"cursor:pointer;\" onclick=S(\"013\") src=chat/smiles/smiles_013.gif>","<img style=\"cursor:pointer;\" onclick=S(\"014\") src=chat/smiles/smiles_014.gif>","<img style=\"cursor:pointer;\" onclick=S(\"015\") src=chat/smiles/smiles_015.gif>","<img style=\"cursor:pointer;\" onclick=S(\"016\") src=chat/smiles/smiles_016.gif>","<img style=\"cursor:pointer;\" onclick=S(\"021\") src=chat/smiles/smiles_021.gif>","<img style=\"cursor:pointer;\" onclick=S(\"023\") src=chat/smiles/smiles_023.gif>","<img style=\"cursor:pointer;\" onclick=S(\"024\") src=chat/smiles/smiles_024.gif>","<img style=\"cursor:pointer;\" onclick=S(\"025\") src=chat/smiles/smiles_025.gif>","<img style=\"cursor:pointer;\" onclick=S(\"027\") src=chat/smiles/smiles_027.gif>","<img style=\"cursor:pointer;\" onclick=S(\"028\") src=chat/smiles/smiles_028.gif>","<img style=\"cursor:pointer;\" onclick=S(\"031\") src=chat/smiles/smiles_031.gif>","<img style=\"cursor:pointer;\" onclick=S(\"032\") src=chat/smiles/smiles_032.gif>","<img style=\"cursor:pointer;\" onclick=S(\"623\") src=chat/smiles/smiles_623.gif>","<img style=\"cursor:pointer;\" onclick=S(\"624\") src=chat/smiles/smiles_624.gif>","<img style=\"cursor:pointer;\" onclick=S(\"625\") src=chat/smiles/smiles_625.gif>","<img style=\"cursor:pointer;\" onclick=S(\"626\") src=chat/smiles/smiles_626.gif>","<img style=\"cursor:pointer;\" onclick=S(\"627\") src=chat/smiles/smiles_627.gif>","<img style=\"cursor:pointer;\" onclick=S(\"628\") src=chat/smiles/smiles_628.gif>","<img style=\"cursor:pointer;\" onclick=S(\"629\") src=chat/smiles/smiles_629.gif>","<img style=\"cursor:pointer;\" onclick=S(\"630\") src=chat/smiles/smiles_630.gif>","<img style=\"cursor:pointer;\" onclick=S(\"631\") src=chat/smiles/smiles_631.gif>","<img style=\"cursor:pointer;\" onclick=S(\"632\") src=chat/smiles/smiles_632.gif>","<img style=\"cursor:pointer;\" onclick=S(\"633\") src=chat/smiles/smiles_633.gif>","<img style=\"cursor:pointer;\" onclick=S(\"634\") src=chat/smiles/smiles_634.gif>","<img style=\"cursor:pointer;\" onclick=S(\"635\") src=chat/smiles/smiles_635.gif>","<img style=\"cursor:pointer;\" onclick=S(\"636\") src=chat/smiles/smiles_636.gif>","<img style=\"cursor:pointer;\" onclick=S(\"637\") src=chat/smiles/smiles_637.gif>","<img style=\"cursor:pointer;\" onclick=S(\"638\") src=chat/smiles/smiles_638.gif>","<img style=\"cursor:pointer;\" onclick=S(\"639\") src=chat/smiles/smiles_639.gif>","<img style=\"cursor:pointer;\" onclick=S(\"640\") src=chat/smiles/smiles_640.gif>","<img style=\"cursor:pointer;\" onclick=S(\"641\") src=chat/smiles/smiles_641.gif>","<img style=\"cursor:pointer;\" onclick=S(\"642\") src=chat/smiles/smiles_642.gif>","<img style=\"cursor:pointer;\" onclick=S(\"643\") src=chat/smiles/smiles_643.gif>","<img style=\"cursor:pointer;\" onclick=S(\"644\") src=chat/smiles/smiles_644.gif>","<img style=\"cursor:pointer;\" onclick=S(\"645\") src=chat/smiles/smiles_645.gif>","<img style=\"cursor:pointer;\" onclick=S(\"646\") src=chat/smiles/smiles_646.gif>","<img style=\"cursor:pointer;\" onclick=S(\"647\") src=chat/smiles/smiles_647.gif>","<img style=\"cursor:pointer;\" onclick=S(\"648\") src=chat/smiles/smiles_648.gif>","<img style=\"cursor:pointer;\" onclick=S(\"650\") src=chat/smiles/smiles_650.gif>","<img style=\"cursor:pointer;\" onclick=S(\"651\") src=chat/smiles/smiles_651.gif>","<img style=\"cursor:pointer;\" onclick=S(\"652\") src=chat/smiles/smiles_652.gif>","<img style=\"cursor:pointer;\" onclick=S(\"653\") src=chat/smiles/smiles_653.gif>","<img style=\"cursor:pointer;\" onclick=S(\"654\") src=chat/smiles/smiles_654.gif>","<img style=\"cursor:pointer;\" onclick=S(\"655\") src=chat/smiles/smiles_655.gif>","<img style=\"cursor:pointer;\" onclick=S(\"656\") src=chat/smiles/smiles_656.gif>","<img style=\"cursor:pointer;\" onclick=S(\"657\") src=chat/smiles/smiles_657.gif>");
			//$smiles2 = Array("<img style=\"cursor:pointer;\" onclick=S(\"flowers\") src=i/smiles/flowers.gif>","<img style=\"cursor:pointer;\" onclick=S(\"inv\") src=i/smiles/inv.gif>","<img style=\"cursor:pointer;\" onclick=S(\"hug\") src=i/smiles/hug.gif>","<img style=\"cursor:pointer;\" onclick=S(\"horse\") src=i/smiles/horse.gif>","<img style=\"cursor:pointer;\" onclick=S(\"str\") src=i/smiles/str.gif>","<img style=\"cursor:pointer;\" onclick=S(\"susel\") src=i/smiles/susel.gif>","<img style=\"cursor:pointer;\" onclick=S(\"smile\") src=i/smiles/smile.gif>","<img style=\"cursor:pointer;\" onclick=S(\"laugh\") src=i/smiles/laugh.gif>","<img style=\"cursor:pointer;\" onclick=S(\"fingal\") src=i/smiles/fingal.gif>","<img style=\"cursor:pointer;\" onclick=S(\"eek\") src=i/smiles/eek.gif>","<img style=\"cursor:pointer;\" onclick=S(\"smoke\") src=i/smiles/smoke.gif>","<img style=\"cursor:pointer;\" onclick=S(\"hi\") src=i/smiles/hi.gif>","<img style=\"cursor:pointer;\" onclick=S(\"bye\") src=i/smiles/bye.gif>","<img style=\"cursor:pointer;\" onclick=S(\"king\") src=i/smiles/king.gif>","<img style=\"cursor:pointer;\" onclick=S(\"king2\") src=i/smiles/king2.gif>","<img style=\"cursor:pointer;\" onclick=S(\"boks2\") src=i/smiles/boks2.gif>","<img style=\"cursor:pointer;\" onclick=S(\"boks\") src=i/smiles/boks.gif>","<img style=\"cursor:pointer;\" onclick=S(\"gent\") src=i/smiles/gent.gif>","<img style=\"cursor:pointer;\" onclick=S(\"lady\") src=i/smiles/lady.gif>","<img style=\"cursor:pointer;\" onclick=S(\"tongue\") src=i/smiles/tongue.gif>","<img style=\"cursor:pointer;\" onclick=S(\"smil\") src=i/smiles/smil.gif>","<img style=\"cursor:pointer;\" onclick=S(\"rotate\") src=i/smiles/rotate.gif>","<img style=\"cursor:pointer;\" onclick=S(\"ponder\") src=i/smiles/ponder.gif>","<img style=\"cursor:pointer;\" onclick=S(\"bow\") src=i/smiles/bow.gif>","<img style=\"cursor:pointer;\" onclick=S(\"angel\") src=i/smiles/angel.gif>","<img style=\"cursor:pointer;\" onclick=S(\"angel2\") src=i/smiles/angel2.gif>","<img style=\"cursor:pointer;\" onclick=S(\"hello\") src=i/smiles/hello.gif>","<img style=\"cursor:pointer;\" onclick=S(\"dont\") src=i/smiles/dont.gif>","<img style=\"cursor:pointer;\" onclick=S(\"idea\") src=i/smiles/idea.gif>", "<img style=\"cursor:pointer;\" onclick=S(\"mol\") src=i/smiles/mol.gif>", "<img style=\"cursor:pointer;\" onclick=S(\"super\") src=i/smiles/super.gif>","<img style=\"cursor:pointer;\" onclick=S(\"beer\") src=i/smiles/beer.gif>","<img style=\"cursor:pointer;\" onclick=S(\"drink\") src=i/smiles/drink.gif>","<img style=\"cursor:pointer;\" onclick=S(\"baby\") src=i/smiles/baby.gif>","<img style=\"cursor:pointer;\" onclick=S(\"tongue2\") src=i/smiles/tongue2.gif>", "<img style=\"cursor:pointer;\" onclick=S(\"sword\") src=i/smiles/sword.gif>", "<img style=\"cursor:pointer;\" onclick=S(\"agree\") src=i/smiles/agree.gif>","<img style=\"cursor:pointer;\" onclick=S(\"loveya\") src=i/smiles/loveya.gif>","<img style=\"cursor:pointer;\" onclick=S(\"kiss\") src=i/smiles/kiss.gif>","<img style=\"cursor:pointer;\" onclick=S(\"kiss2\") src=i/smiles/kiss2.gif>", "<img style=\"cursor:pointer;\" onclick=S(\"kiss3\") src=i/smiles/kiss3.gif>", "<img style=\"cursor:pointer;\" onclick=S(\"kiss4\") src=i/smiles/kiss4.gif>","<img style=\"cursor:pointer;\" onclick=S(\"rose\") src=i/smiles/rose.gif>","<img style=\"cursor:pointer;\" onclick=S(\"love\") src=i/smiles/love.gif>","<img style=\"cursor:pointer;\" onclick=S(\"love2\") src=i/smiles/love2.gif>", "<img style=\"cursor:pointer;\" onclick=S(\"confused\") src=i/smiles/confused.gif>", "<img style=\"cursor:pointer;\" onclick=S(\"yes\") src=i/smiles/yes.gif>","<img style=\"cursor:pointer;\" onclick=S(\"no\") src=i/smiles/no.gif>","<img style=\"cursor:pointer;\" onclick=S(\"shuffle\") src=i/smiles/shuffle.gif>","<img style=\"cursor:pointer;\" onclick=S(\"nono\") src=i/smiles/nono.gif>","<img style=\"cursor:pointer;\" onclick=S(\"maniac\") src=i/smiles/maniac.gif>","<img style=\"cursor:pointer;\" onclick=S(\"privet\") src=i/smiles/privet.gif>","<img style=\"cursor:pointer;\" onclick=S(\"ok\") src=i/smiles/ok.gif>","<img style=\"cursor:pointer;\" onclick=S(\"ninja\") src=i/smiles/ninja.gif>","<img style=\"cursor:pointer;\" onclick=S(\"pif\") src=i/smiles/pif.gif>", "<img style=\"cursor:pointer;\" onclick=S(\"smash\") src=i/smiles/smash.gif>","<img style=\"cursor:pointer;\" onclick=S(\"alien\") src=i/smiles/alien.gif>","<img style=\"cursor:pointer;\" onclick=S(\"pirate\") src=i/smiles/pirate.gif>","<img style=\"cursor:pointer;\" onclick=S(\"gun\") src=i/smiles/gun.gif>","<img style=\"cursor:pointer;\" onclick=S(\"trup\") src=i/smiles/trup.gif>","<img style=\"cursor:pointer;\" onclick=S(\"mdr\") src=i/smiles/mdr.gif>", "<img style=\"cursor:pointer;\" onclick=S(\"sneeze\") src=i/smiles/sneeze.gif>","<img style=\"cursor:pointer;\" onclick=S(\"mad\") src=i/smiles/mad.gif>","<img style=\"cursor:pointer;\" onclick=S(\"friday\") src=i/smiles/friday.gif>","<img style=\"cursor:pointer;\" onclick=S(\"cry\") src=i/smiles/cry.gif>","<img style=\"cursor:pointer;\" onclick=S(\"grust\") src=i/smiles/grust.gif>","<img style=\"cursor:pointer;\" onclick=S(\"rupor\") src=i/smiles/rupor.gif>","<img style=\"cursor:pointer;\" onclick=S(\"fie\") src=i/smiles/fie.gif>", "<img style=\"cursor:pointer;\" onclick=S(\"nnn\") src=i/smiles/nnn.gif>","<img style=\"cursor:pointer;\" onclick=S(\"row\") src=i/smiles/row.gif>","<img style=\"cursor:pointer;\" onclick=S(\"red\") src=i/smiles/red.gif>","<img style=\"cursor:pointer;\" onclick=S(\"lick\") src=i/smiles/lick.gif>","<img style=\"cursor:pointer;\" onclick=S(\"help\") src=i/smiles/help.gif>","<img style=\"cursor:pointer;\" onclick=S(\"wink\") src=i/smiles/wink.gif>","<img style=\"cursor:pointer;\" onclick=S(\"jeer\") src=i/smiles/jeer.gif>","<img style=\"cursor:pointer;\" onclick=S(\"tease\") src=i/smiles/tease.gif>","<img style=\"cursor:pointer;\" onclick=S(\"kruger\") src=i/smiles/kruger.gif>","<img style=\"cursor:pointer;\" onclick=S(\"girl\") src=i/smiles/girl.gif>","<img style=\"cursor:pointer;\" onclick=S(\"Knight1\") src=i/smiles/Knight1.gif>","<img style=\"cursor:pointer;\" onclick=S(\"rev\") src=i/smiles/rev.gif>","<img style=\"cursor:pointer;\" onclick=S(\"smile100\") src=i/smiles/smile100.gif>","<img style=\"cursor:pointer;\" onclick=S(\"smile118\") src=i/smiles/smile118.gif>","<img style=\"cursor:pointer;\" onclick=S(\"smile149\") src=i/smiles/smile149.gif>","<img style=\"cursor:pointer;\" onclick=S(\"smile166\") src=i/smiles/smile166.gif>","<img style=\"cursor:pointer;\" onclick=S(\"smile237\") src=i/smiles/smile237.gif>","<img style=\"cursor:pointer;\" onclick=S(\"smile245\") src=i/smiles/smile245.gif>","<img style=\"cursor:pointer;\" onclick=S(\"smile28\") src=i/smiles/smile28.gif>","<img style=\"cursor:pointer;\" onclick=S(\"smile289\") src=i/smiles/smile289.gif>","<img style=\"cursor:pointer;\" onclick=S(\"smile314\") src=i/smiles/smile314.gif>","<img style=\"cursor:pointer;\" onclick=S(\"smile36\") src=i/smiles/smile36.gif>","<img style=\"cursor:pointer;\" onclick=S(\"smile39\") src=i/smiles/smile39.gif>","<img style=\"cursor:pointer;\" onclick=S(\"smile44\") src=i/smiles/smile44.gif>","<img style=\"cursor:pointer;\" onclick=S(\"smile70\") src=i/smiles/smile70.gif>","<img style=\"cursor:pointer;\" onclick=S(\"smile87\") src=i/smiles/smile87.gif>","<img style=\"cursor:pointer;\" onclick=S(\"smile434\") src=i/smiles/smile434.gif>","<img style=\"cursor:pointer;\" onclick=S(\"vamp\") src=i/smiles/vamp.gif>");
$_GET['text'] = preg_replace($smiles, $smiles2, $_GET['text'],3);
			//$_GET['text'] = stripslashes ($_GET['text']);
			//$_GET['text'] = htmlspecialchars($_GET['text']);

			if($user['invis']=='1') {
				$user['login'] = '</a><b><i>���������</i></b>';
			}

			if (filesize("tmpdisk/chat.txt")>100*1024) {
				//file_put_contents("chat.txt", file_get_contents("chat.txt", NULL, NULL, 3*1024), LOCK_EX);
				//@chmod("$fp", 0644);
				// �������� ��������� ������
			if ($user['id'] != '13328') {
				$file=file("tmpdisk/chat.txt");
				$fp=fopen("tmpdisk/chat.txt","w");
				flock ($fp,LOCK_EX);
				for ($s=0;$s<count($file)/1.6;$s++) {
					unset($file[$s]);
				}
				fputs($fp, implode("",$file));
				fputs($fp ,"\r\n:[".time ()."]:[{$user['login']}]:[<font color=\"".(($user['color'])?$user['color']:"#000000")."\">".($_GET['text'])."</font>]:[".$user['room']."]\r\n"); //������ � ������
				flock ($fp,LOCK_UN);
				fclose($fp);
				}
			}
			else {
			if ($user['id'] != '13328') {
				$fp = fopen ("tmpdisk/chat.txt","a"); //��������
				flock ($fp,LOCK_EX); //���������� �����
				fputs($fp ,":[".time ()."]:[{$user['login']}]:[<font color=\"".(($user['color'])?$user['color']:"#000000")."\">".($_GET['text'])."</font>]:[".$user['room']."]\r\n"); //������ � ������
				fflush ($fp); //�������� ��������� ������ � ������ � ����
				flock ($fp,LOCK_UN); //������ ����������
				fclose ($fp); //��������
				}
			}
			if (strpos($_GET['text'],"to [�����������]" ) !== FALSE) {
				if (strpos($_GET['text'],"to [�����������] �������" ) !== FALSE) {
				$commas = array('������� ����� ������� ������, �� �� ������ ������ ����������. &copy;������',
								'Virt-Life���� ����� �����. ���������, ��������� ����: - ���, �������� ��������! - �� ������� ��� � �������? &copy;������',
								'������ �������� �� ����������� ������� � ���� � �������� �� ���� . ����� ��� ����������: � ���, ������? � ��, ��� ������� ������ ��������. � ��� �� �� ��� ��������-�� �������? � � �� �-��? ������ ������ �� ����������� � ����� ��������... &copy;����-��������',
								'����� ������� � ����� ������. ����� ������, ����� � ������� ������ ���� ������ �������, ���� ��� ���������. ����� ������� ������ ������ �� �����: - �������! - �� ������� �����! &copy;Arkada',
								'"������ �� �����" - ������ ���� ������� ��������� ������ ��� ���� ��������',
								'���� ���������� 16.08.03 12:00, ����� ����� ����� MIB � ����� ��������� ������� ����� ���� �����. 12:01 ��� ��������. ������ �� Merlin',
								'����: ����� �������� �� ����!!! Merlin: ������������ ���� ��� ����� �� ������������ �������. &copy;XyliGUNka',
								'� �������� �� ������� ������ ������� ��������� ������ &copy;�������',
								'� ����� � ����� �������� ������������� 90-60-90! - �� �����!! � ������������ �������? &copy;Akrobat',
								'-�� �� �����!!! ���� � �������, ������ �������! -��� � � ��� � ����! -� ���, ��� ��� ��� �����?! -����� ��?! � ����-�� ������� �� ��� ������� ��������?!! &copy;Arkada',
								'-�������, Virt-Life - ������ ����? ���������, ������ ����� ����������.. &copy;������',
								'���� ������� ������� ������������. ����������� ���� � ��������� ������. &copy;������',
								'����. �����. ����� ���� ���� �� ����������� �������. ������ ��������� ����. "��� merlin", - ������� ����� ����. "��, ��� �", - ������� merlin. &copy;������',
								'������� ���� �������, merlin ������� �������� ������� ����. "�������" - ������� merlin. &copy;������',
								'�������, ������, ������� ���, � ���� �����! &copy;Thomas Malton',
								'���� ������������, ����� <�������� ��������> ��������������� ������������ � ����!'
								);
				addchp($commas[rand(0,count($commas)-1)],"�����������");
				} else {
				$commas = array('��� ����� �� ����� � ������� �������� ������������...',
								'��� ���������� ������ �� � ���?',
								'�������!',
								'��� �����, ����������� - ����!',
								'� ������� ��������, �� ���� �������������� ���� ���!',
								'������!',
								'���������� �� ��������!',
								'�������: - ������� ��������, ������ ���� ���������� �� ����������� ������� ������������? - ��� ��� �� ��� ���!!',
								'��� �����!',
								'������ ������� (� ������)',
								'���...',
								'����� � ��� �������� ���������.',
								'��� ��� �����������? �� ��� �???',
								'���� ��...',
								'��� �����!',
								'���� ������������, ����� <�������� ��������> ��������������� ������������ � ����!',
								'(��������� �����������) ��� �����???',
								'�� �������� �������',
								'���! ������ �� ��� ������!',
								'�-�-�...',
								'� � ��� ��� ��������� �������?',
								'� ����� �����, ��� ����� 90�60�90. ���������, ��� ��� 486 000.',
								'����� ���� �������� ����, ���� ������?',
								'������ ������!',
								'���� ��������� �������� <�������� ��������>',
								'��� ���� ��� � ��������� ���� �������� ����� ���������.',
								'�� � ��� ��������������� �����?',
								'����� ������. ����� ������. ����� ������. ����� ������. �����, ������...',
								'� �����������! � �� ���???',
								'������� �� � �������� �� ������� ������. ����� �� ����� - 18 ������.',
                                '�������, ������� �������, � ��������� ��� ����. - ����, ������, - ������� ����.',
                                '���� ������ �� ������� ����� ����, ��� ����� ���������� ������� � ����� ����. ������ �����: ������� ��������!',
								'������� � ������ ���������� ������������ ������� ��������� � ���������. ������ ���-�� �� ���������.',
								'��� �-�� �������������? �����������',
								'� �� ������ ��� �������, - ����� ���� ������ ������ ����������, ����� ���� ��� �������� � ������ ���� ������ � ����.',
								'������� ������ ���� � ����� ������ ����� ��������� ��� ������ ��������.',
								'������ ������ � �������� ��������� �� ��� �������� ������, ��� ������ � �������� ����������.',
								'�������-�� �� ���������� �� ���������� ��������, - ������ ��������� ���������, ������ �� �������� ���������.',
								'��� �� ���������� ��������, - ������ ����� ���, ������� ����� �������.',
								'��������� ������� �������� ������������ �������. ���: ������� �� � ���',
								'� ������ ���� ���� ���������� "� �������"? - ������� ������� ��������� �������.', 
								'8 ����� ������ � "���������" ������� ������������� �������� ����.', 
								'����, �� ������ �� �������� �������, � �����-�� ������� �������� - ������� ��� ���� �����, ����� ������� �������, � ����� � ������ �����. ��� ���� ������� ��� � ��� ���� �������!',
								'����� ��������, ��� 20% ����� ������ 80% ������. ������� ����������, ��� 80% ����� �������, ��� ��� ������ � ��� 20%',
								'� ������� ��� �������, � ���� ������ � ����������, �� ��� ��� ������ �� ����� ����� �������� ������ � ��������, �� ������� � ������ ������� "�� ����� � 1" ��� �� �����',
								'� ������, ����� � ����� ����� ���������� �������� � �����? ��� ��� ������ ������.',
								'� ����������� ����� �� ���� �������� �������� ��� ������ ������� �� ����� ���.',
								'"���� �������� ���������� ������ ������������, ���� �� ��������� �� ���� 60 ��/���, ������ �������� ����� ����������, �� ��������� ���������� �� ������, ��������� ������� �� �������� ����������, ���������� ��������� �� �������� � ������ �� �������� �� ������ ������ ���, ������, ������ �����, �� ������ ����".',
								'��������� �� ������',
								'������� ����� �����, � ������� - �������. ����������-����������� ���� ����� 153. ������� ������� ������� � ���.',
								'���� ����������� ������� - ��� ����� ����� ��� ��� ������� ������� ���� � ������ �����.',
								'�������, ������ 5 ����������� ��������. �������, ������ 5 ����������� ��������. 3 �������� � 2 �����',
								'���� �������! - ������ ����, ������ ������ � ������ � ����� � ����.',
								'������� ������ ����� ������ �����: "����, ���� ����, ������ ������. ������ - ����".',
								'����� ������� ������� ���������� ����, ������� �� ��������� ������ ����� ����� 100 ��������.',
								'����� ������� ������� ���������� ����, ������� �� ��������� ������ ����� ����� 100 ��������.',
								'�� ����� ��� ��� ����� ������ �����: ��� �������, ��� �������... � ������ �������� ���� ���� �������: 255.255.255.0',
								'�������� - ��� �������, ������� �� �������, ����� ���-�� ���������...',
								'"���� �����..." (�������������� ��������� ���������� ����������).',
								'������� �� ������, �������� �� ������, ������ �� ������, ��� �� ������, ��������� �� ������... ��� ����� �� ������! ����� �� ��� � ���, ������...',
								'������ ������� ������ ����������� - �������� ������ �� ��������. ����������� �� �������� ���� �����... - ��������� ���� ������!',
								'��������� ������ �� ��� ������� ���������� ���������, ��������� � �������: ���, ������ ������� �����! �������� �� �����.',
								'������� ������ �� ����� ����, ���� �� - ���������������!',
								'��� ���������, �� ��� ����� ����� �������... ���� �� ��� ����, ���� �� ����� ���������.',
								'����, ����� ����� � �������, �� ������ �������, �������� ���������� � �������� ��������, ������, ��������� �� ���-���� ������ ������ 50 ����� ��� ��������.',
								'���� �������� �� ������ - ��� �������� �� ���� ����. ���� ������ - �� ������...',
								'���� ������! � ������ ������!',
								'����� � ����� � ����� ��� �����, ��� ����� � ���� �� ����� ���������!',
								'��� �� ����� ����� ����? ���, �� ��������� ������ ���� ���.',
								'�� ����� ����-��������� �� �������� ����� ����������: ��-��� ��������� ������� ���������',
								'�� ������� ������ �� �� �������?',
								'� �� �����, ����� ���, ��� ����������� ������� �������� ������� ������',
								'���������, �������, �����, �� ���������� ��� ����, ��� ����! ��� ������?',
								'��� ��� ����� � �����, ���� �� �� ����������� ������ �����!(� ������ ���������)',
								'������, �� �������?',
								'���� � ������� ������ � �������� ������',
								'����� ������ ������ ���� ����� � ������, ��� ����� ����� � ������������!',
								'���� �� ������ ������ �������, ����-������� � �� ��� ������',
								'���� ������� ������ � �� ���������, ������, ��� ����.',
								'� ��� ���, ��������, ����� ����� ���� ����������?',
								'������ ���� ��� ��������� � ���������, ��� �������',
								'������������ ���������!',
								'�� ������ ������� ������� �� ������� � ������ ���� �� �� ����!',
								'��� � ��� ��� ������, � ����� ������� ������ ���������...',
								'��������, ��� ����� ����������� � �������, ����������!',
								'������� ������ - ������� ����!',
								'"��� �� ����� ��������!"- ��������� �������, �������� ������.
"��-��" - ��������� ���, �������� �������� ��-�� ������ �����.',
								'��������� �������, ���� ������� �� ����������!',
								'������, ��� ��� ���� ��� �� ����� - � ������ ����� ����������, ��� ��� ��� �������.',
								'������ ��������, ������ ��������.',
								'����� ���� ��� ��������,��� ���� ��� �����!',
								'���� ���� �� �����! � ������� ������� � �������� ������.',
								'� ����� � ����� �������� ������������� 90-60-90! - �� �����!! � ������������ �����!?',
								'� ��� ������ � �������� ��� � ���, ��� � ������� ���������� � ����� �� ������������ ��������� ������ ����� ����������',
								'���� ������ ����������, ����� ����� ��� 20�� � � ��� �� �������� � �� �����',
								'��������, ������������� � ����� 20 ���, ����� ������� ������� � ���������� ������ �� -1000.',
								'��� ��� ��� ������..The server ��� ������ ���-�� busy, � �� ��� Try again later ���� administrator �� �������� )))',
								'������ ������ �������-��������!!!������ �� ����� ���� �� ����, ���� ���������� � ���',
								'�� ��� ��� � ������� ������ ����.',
								'"� ������ ����... � ������ ����..." - �������, ���������� ���� � �����������...',
								'������� ����� ������ ������.',
								'�� ������ "���", ���� �� �� �����������!',
								'����� ��������, ��� ������� - �� ���������� ��� �� �� �����...',
								'�������������� ���� - ��� �� ����� �� ����!',
								'������ ��������, ����� ���� ��� � �� ��������, ������ ��� � ���� ���� ����� ����. � �������������',
								'��� ����� ������� � ����� ��������� �� ������������ �� ����...�� ��� ���� :)',
								'���� ���� ������ ������, �� ������ ��� � �������� � ����� ������.',
								'������� ��� ����� �� ����� - ������ ��� ����� ������!',
								'����������� ����...�����.',
								'�� ���� ��� �����, ��� ����� �� � ���� ��������� � ����������� ',
								'Ҹ����, �������...� �������� ������ ����� ����.',
								'���������� � ����� � ������. �� ����� - ���������� � �������.',
								'���� ������� ����� �� ������, ��� �������� �������� ����.',
								'������ ����. �������: ������� � ����� �����',
								'������� ������: 
- ������: ��������, ����������� � �.�. ������ ������ ������� ���: ',
								'�� ����� ����"- ������ �����, � ������ ��������� �����',
								'� � ��������. �� ��� �� ������ ���� - ���� �������',
								'�� ���������� ����! ��� ����� ����� ����� ������� �����!',
								'������� �� � ����� --������ ������ ���������,
��� "�����"�"���".',
								'����� �������? ����� ����� ������. ������� ���� ��� ������.',
								'�� �� ��������, ��� � ��������� � ������... ������ ������ ������� �����',
								'���� �� �������� ������ �� ��....�� ����� � ������! � �� 911',
								'��������� ����� ��� ����:���� � ������ ����� � ���',
								'������ ��� ������ � ��������, ����� ������� ������',
								'���� �� ��� � ����� ������� ',
								'"����-���� -��� ���,��� ������ ������ ����� ����� � ���������,� ���������� � �����"-',
								'����� ��� 21�� ������� ?',
								'����� ������� ����� ������ "-----" , ��� ��� ���� ������ ������.',
								'������ � ���������� ����� � �������!
',
								'� ���� ����������-��? �������� ��������-����� ��������-�������� �����.... �� ������ �� ��� � ����
',
								'� ���� � ����� ������� �������� � ����� �� ???
',
								'��������� ������� ��������� ��� ������� � ��. ������� ���� � ��� ��� ����� ??? 
',
								
								'� �����!!!');
				addchp($commas[rand(0,count($commas)-1)],"�����������");
				}
			}


		}
			die ("<script>top.CLR1();top.RefreshChat();</script>");

		}
	}
?>
</body>
</html>
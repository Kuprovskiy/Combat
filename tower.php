<?php
  $minid=757;
    session_start();
    define("FREEGAME",0);
    if ($_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
    include "functions.php";
    if ($user['align'] == 4) {
        header('Location: city.php?strah=1'); 
        die();
    }
    if ($user['room'] != 31) { header("Location: main.php");  die(); }
    if ($user['in_tower'] == 1 || $user['in_tower'] == 2) { header('Location: towerin.php'); die(); }

    class predbannik_bs {
        var $mysql; // mysql
        var $userid = 0; // мой ижентификатор
        var $turnir_id = 0; // айти турнира
        var $turnir_info = 0;

        // создаем класс
        function predbannik_bs () {
            global $mysql, $user;
            $this->mysql = $mysql;
            $this->userid = $user;
            $this->turnirstart = mysql_fetch_array(mysql_query("SELECT `value` FROM `variables` WHERE `var` = 'startbs' LIMIT 1;"));
            $this->turnirstart = $this->turnirstart[0];
        }

        // проверить идет ли турнир?
        function get_turnir () {
            $data = mysql_fetch_array(mysql_query("SELECT * FROM `deztow_turnir` WHERE `active` = TRUE"));
            $this->turnir_id = $data[0];
            return $data;
        }

        //==================================================================
        // начало турнира!!!!!!!
        function start_turnir () {
            if($this->turnir_id) {
                return false;
            }
            mysql_query("LOCK TABLES `shop` WRITE, `deztow_items` WRITE, `deztow_realchars` WRITE, `deztow_charstams` WRITE, `deztow_eff` WRITE, `deztow_gamers_inv` WRITE,`effects` WRITE, `deztow_turnir` WRITE, `deztow_stavka` WRITE, `users` WRITE, `inventory` WRITE, `online` WRITE;");
            $minroom = 501;
            $maxroom = 560;
            // вычисляем кто прошел в турнир
            $data = mysql_query("SELECT dt.owner FROM `deztow_stavka` as dt, `online` as o WHERE o.id = dt.owner AND room = 31 AND o.`date` >= '".(time()-300)."' ORDER by `kredit` DESC, dt.`time` ASC  LIMIT 40;");
            $stavka = mysql_fetch_array(mysql_query("SELECT SUM(`kredit`)*0.7 FROM `deztow_stavka`;"));
            // удаляем сразу, чтоб другим не повадно было
            if($data) {
                mysql_query("TRUNCATE TABLE `deztow_stavka`;");
                mysql_query("TRUNCATE TABLE `deztow_gamers_inv`;");
            }
            while($row=mysql_fetch_array($data)) {
                // делаем каждому чару бекап в базу специальную, раздеваем и все такое
                undressall($row[0]); // раздели
                $shmot = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '".$row[0]."';");// бекапим весь шмот
                mysql_query("UPDATE `inventory` SET `owner` = 0 WHERE `owner` = '".$row[0]."';");
                while($sh = mysql_fetch_array($shmot)) {
                    mysql_query("INSERT `deztow_gamers_inv` (`id_item`,`owner`) values ('".$sh[0]."','".$row[0]."');");
                }
                // effects
                $effs = mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$row[0]."';"); // бекапим ефекты
                while($eff = mysql_fetch_array($effs)) {
                    deltravma($eff['id']);
                    mysql_query("INSERT `deztow_eff` (`type`, `name`, `time`, `sila`, `lovk`, `inta`, `vinos`, `owner`)
                    values ('".$eff['type']."','".$eff['name']."','".$eff['time']."',
                    '".$eff['sila']."','".$eff['lovk']."','".$eff['inta']."','".$eff['vinos']."','".$eff['owner']."');");
                }
                mysql_query("DELETE FROM `effects` WHERE `owner` = '".$row[0]."';");
                // stats
                $tec = mysql_fetch_array(mysql_query("SELECT * FROM `deztow_charstams` WHERE `owner` = '{$row[0]}' AND `def`='1';"));
                if($tec[0] && $row[0] != 233) {
                    // умелки
                    $u = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$row[0]}' LIMIT 1;"));
                    $master = ($u['noj']+$u['mec']+$u['topor']+$u['dubina']+$u['mfire']+$u['mwater']+$u['mair']+$u['mearth']+$u['mlight']+$u['mgray']+$u['mdark']+$u['master']);
                    // если есть шаблон - меняем
                    mysql_query("INSERT `deztow_realchars` (`owner`,`name`,`sila`,`lovk`,`inta`,`vinos`,`intel`,`mudra`,`stats`,`nextup`,`level`,`master`) values
                    ('".$u['id']."','".$u['login']."','".$u['sila']."','".$u['lovk']."','".$u['inta']."','".$u['vinos']."','".$u['intel']."',
                    '".$u['mudra']."','".$u['stats']."','".$u['nextup']."','".$u['level']."','".$master."');");
                    //создали запись, теперь выставляем статы))
                    $stats = ($u['sila']+$u['lovk']+$u['inta']+$u['vinos']+$u['intel']+$u['mudra']+$u['stats'])-($tec['sila']+$tec['lovk']+$tec['inta']+$tec['vinos']+$tec['intel']+$tec['mudra']);
                    mysql_query("UPDATE `users` SET `sila`='".$tec['sila']."', `lovk`='".$tec['lovk']."',`inta`='".$tec['inta']."',`vinos`='".$tec['vinos']."',`intel`='".$tec['intel']."',`mudra`='".$tec['mudra']."',`stats`='".$stats."',
                    `noj`=0,`mec`=0,`topor`=0,`dubina`=0,`mfire`=0,`mwater`=0,`mair`=0,`mearth`=0,`mlight`=0,`mgray`=0,`mdark`=0,`master`='".$master."'
                    WHERE `id` = '".$u['id']."' LIMIT 1;");
                    // закончили
                }

                // пихаем учасников в БС
                $rum = rand($minroom,$maxroom);
                mysql_query("UPDATE `users` SET `in_tower` = 1, `room` = '".$rum."' WHERE `id` = '".$row[0]."';");
                mysql_query("UPDATE `online` SET `room` = '".$rum."' WHERE `id` = '".$row[0]."' LIMIT 1 ;");
                // в список участников
                $i++;
                if($i>1) { $lors .= ", "; }
                $lors .= nick3($row[0]);
            }

            // arch================
                undressall(233);
                mysql_query("DELETE FROM `inventory` WHERE `owner` = '233';");
                $rum = rand($minroom,$maxroom);
                mysql_query("UPDATE `users` SET `in_tower` = 1, `chattime` = '999999999999', `room` = '".$rum."' WHERE `id` = '233';");
                mysql_query("UPDATE `online` SET `room` = '".$rum."' WHERE `id` = '233' LIMIT 1 ;");
                $i++;
                $lors .= ", ".nick3(233);
            //=====================

            // разбрасываем шмот по комнатам
            mysql_query("TRUNCATE TABLE `deztow_items`;");
            // айдишники магазинных прототипов
            $shmots = array("1","1","92","92","93","93","19","19","20","20","20","23","23","24","14","87","87","6","6",
                                "17","17","17","17","11","11","12","12","12","28","28","43","43","36","36","36","37","37","37",
                                "38","38","38","50","50","57","52","52","51","51","48","48","47","47","49","49","59","59","60",
                                "60","61","61","63","64","64","65","65","66","66","68","68","69","69","72","72","4","5","79","79",
                                "80","76","75","75","94","94","95","95","82","91","91","34","34","86","86","86","9","9","101","101",
                                "101","101","97","97","97","97","98","98","98","98","99","99","99","99","100","100","100","100",
                                "102","102","102","103","103","103","104","105","105","106","106","107","107","108","108","109",
                                "110","111","112","112","113","113","114","120","121",
                                "121","121","121"
                            );
            while($sh = array_shift($shmots)) {
                $shopid = mysql_fetch_array(mysql_query("SELECT * FROM `shop` WHERE `id` = '".$sh."' LIMIT 1;"));
                mysql_query("INSERT `deztow_items` (`iteam_id`, `name`, `img`, `room`) values ('".$shopid['id']."', '".$shopid['name']."', '".$shopid['img']."', '".rand($minroom,$maxroom)."');");
            }
            // формируем лог
            $log = '<span class=date>'.date("d.m.y H:i").'</span> Начало турнира. Участники: '.$lors.'<BR>';
            // создаем запись о турнире
            mysql_query("INSERT `deztow_turnir` (`type`,`winner`,`coin`,`start_time`,`log`,`endtime`,`active`) values ('".rand(1,7)."','','".$stavka[0]."','".time()."','".$log."','0','1');");
            mysql_query("UNLOCK TABLES;");
        }
        //==================================================================

        // проверить ставку
        function get_stavka () {
            $data = mysql_fetch_array(mysql_query("SELECT `kredit` FROM `deztow_stavka` WHERE `owner` = '".$this->userid['id']."' LIMIT 1;"));
            return $data[0];
        }

        // поставить
        function set_stavka ($kredit) {
          if (FREEGAME) {
            mysql_query("INSERT `deztow_stavka` (`owner`,`kredit`,`time`) values ('".$this->userid['id']."','".FREEGAME."','".time()."' ); ");
          } else {
            if($kredit >= 3 && $this->userid['level'] > 3 && $this->userid['money'] >= $kredit) {
              mysql_query("INSERT `deztow_stavka` (`owner`,`kredit`,`time`) values ('".$this->userid['id']."','".(float)$kredit."','".time()."' ); ");
              mysql_query("UPDATE `users` set `money` = `money`- '".$kredit."' WHERE id = {$_SESSION['uid']}");
              // ON DUPLICATE KEY UPDATE `kredit` = '".$kredit."';");
              echo mysql_error();
            }
          }
        }

        // поставить
        function up_stavka ($kredit) {
          if($kredit >= 1 && $this->userid['level'] > 3 && $this->userid['money'] >= $kredit) {
            mysql_query("UPDATE `deztow_stavka` SET `kredit` = `kredit`+'".(float)$kredit."' WHERE `owner` = '".$this->userid['id']."';");
            mysql_query("UPDATE `users` set `money` = `money`- '".$kredit."' WHERE id = {$_SESSION['uid']}");
            //echo mysql_error();
          }
        }

        // получить сумму ставок
        function get_fond () {
            $data = mysql_fetch_array(mysql_query("SELECT SUM(`kredit`)*0.7, count(`kredit`) FROM `deztow_stavka`;"));
            $this->turnir_info = array(round($data[0],2),$data[1]);
            return $this->turnir_info;
        }
    }

    $bania = new predbannik_bs;
    include "config/extrausers.php";
    if (in_array($user["id"], $noattack)) {
      $_POST=array();
    }
    if($_POST['docoin']) {
      $i=mqfa1("select id from effects where owner='$user[id]' and name='Просроченный кредит'");
      if (!$i) $bania->set_stavka ($_POST['coin']) ;
      else echo "<b><font color=\"red\">Персонажи с просроченным кредитом не могут участвовать в турнире Башни Смерти.</font></b>";
    }
    if($_POST['upcoin']) {
        if (!FREEGAME) $bania->up_stavka ($_POST['coin']) ;
    }
    if($_GET['st']=='startmegaturnirnow') {
        //$bania->start_turnir ();
    }
    $tr = $bania-> get_turnir();
    // старт рурнира
    if($tr['id']== 0 && $bania->turnirstart <= time()) {
        //$bania->start_turnir ();
    }

    $bania->get_fond();
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=#e2e0e0>
<?
  if (0) {
    include "questfuncs.php";
    if (@$_GET["attackevil"]) {
      battlewithbot(1796, "Горный демон", "Защита города", "10", 1);
    }
    echo "<br><center>
    <table width=600><tr><td><img hspace=5 src=\"/i/shadow/1/monctep.jpg\"><img hspace=5 src=\"/i/shadow/1/monctep.jpg\"><img hspace=5 src=\"/i/shadow/1/monctep.jpg\"></td><td>
    Небольшая группа наглых демонов прбралась к самой Башню Смерти!!! Пока им не удалось её открыть и пробратся к артефактам, которые в ней находятся.
    Надо немедля их уничтожить, пока ещё не поздно.<br><br>
    <a href=\"tower.php?attackevil=1\">Напасть на врага!!!</a></center>
    </td></tr></table>
    <FORM action=\"city.php\" method=GET>
    <center><INPUT TYPE=\"submit\" value=\"Вернуться\" name=\"strah\"></center>
    </form>
    ";
    die;
  }
?>
    <TABLE border=0 width=100% cellspacing="0" cellpadding="0">
    <td align=right>
    <FORM action="city.php" method=GET>
        <INPUT TYPE="button" value="Профили характеристик" style="background-color:#A9AFC0" onClick="window.open('towerstamp.php', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">
        <INPUT TYPE="button" onClick="location.href('tower.php');" value="Обновить">
        <INPUT TYPE="button" value="Подсказка" style="background-color:#A9AFC0" onClick="window.open('help/tower.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">
        <INPUT TYPE="submit" value="Вернуться" name="strah">
    </table>
    </form>
    <FORM method=POST>

<?
if($tr['id'] == 0){ ?>
    <h3>Башня смерти.</h3>
   <?
    if (in_array($user["id"], $noattack)) {
      echo "Для вас Башня Смерти закрыта.";
      die;
    }
    $dtt=mqfa1("select value from variables where var='deztowtype'");
    if (FREEGAME) echo "<b><font color=\"red\">ВНИМАНИЕ!!! Участие в следующем турнире бесплатное! Призовой фонд: по ".(0.7*FREEGAME)." кр. за каждого участника.</font></b><br>";
    if ($dtt==1) echo "Следующий турнир: общая битва (все персонажи 8-го уровня, сумма параметров и навыков у всех одинаковая, аммуниция доступна только из Башни Смерти, после окончания турнира у победителя остаётся только чек на предъявителя, если он его нашёл).";
    if ($dtt==2) echo "Следующий турнир: битва мастеров (все персонажи участвуют со своим уровнем, аммуницией и параметрами, в БС так же доступна аммуниция и в каждой комнате лежит по 1 кр., который останется у персонажа независимо от исхода турнира).";
?>
    <h4>Прием заявок на следующий турнир</h4><BR>
    <table><tr><td>Начало турнира: <span class=date><?=date("d.m.y H:i",$bania->turnirstart)?></span><BR>
    Призовой фонд на текущий момент: <B><?=$bania->turnir_info[0];?></B> кр.<BR>
    Всего подано заявок: <B><?=$bania->turnir_info[1];?></B><BR>
    </td><td align=center width=500>
    <?
        if($bania->get_stavka ()) {
          if (FREEGAME) {
            echo "Вы уже подали заявку на участие в турнире.";
          } else {
            echo "Вы уже поставили <B><FONT COLOR=red>".round($bania->get_stavka (),2)." кр.</B></FONT> хотите увеличить ставку? У вас в наличии <b>".round($user['money'],2)." кр.</b><BR>";
            echo '<input type="text" name="coin" value="1.00" size="8"> <input type="submit" value="увеличить ставку" name="upcoin"><BR>';
          }
        }
        else
        {   if ($user["level"]>=4) {
              if (!FREEGAME) echo "Сколько ставите кредитов? (минимальная ставка <b>3.00 кр.</B> у вас в наличии <b>".round($user['money'],2)." кр.</b>)<BR>";
              ?><input type="<? if (FREEGAME) echo "hidden"; else echo "text"; ?>" name="coin" value="3.00" size="8"> <input type="submit" value="Подать заявку" name="docoin"><BR><?
            } else echo "Участие в турнире только с 4-го уровня.";
        }

        if (!FREEGAME) echo "Чем выше ваша ставка, тем больше шансов принять участие в турнире. Подробнее о башне смерти читайте в разделе \"Подсказка\".";


        }
        else {
            //$ls = mysql_fetch_array(mysql_query("select count(`id`) from `users` WHERE `in_tower` = 1;"));
            //if ($ls[0]==0) mq("update deztow_turnir set active=0");
            $lss = mq("select `id`, login, level, align, klan from `users` WHERE in_tower=1 or in_tower=2");
            $i=0;
            while($user1=mysql_fetch_array($lss)) {
                $i++;
                if($i>1) { $lors .= ", "; }
                $lors.="<img src=\"".IMGBASE."/i/align_".($user1['align']>0 ? $user1['align']:"0").".gif\">";
                if ($user1['klan'] <> '') $lors.= '<img title="'.$user1['klan'].'" src="'.IMGBASE.'/i/klan/'.$user1['klan'].'.gif">'; 
                $lors.= "<B>{$user1['login']}</B> [{$user1['level']}]<a href=inf.php?{$user1['id']} target=_blank><IMG SRC=".IMGBASE."/i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"Инф. о {$user1['login']}\"></a>";
                //$lors .= nick3($in[0]);
            }
        ?>
            <H4>Турнир начался.</H4>
            Призовой фонд: <B><?=$tr['coin']?> кр.</B><BR>
            <?=$tr['log']?><BR>
            Всего живых участников на данный момент: <B><?=mysql_num_rows($lss)?></B> (<?=$lors?>)
            <?
              if (mysql_num_rows($lss)==0 && time()-$tr["start_time"]>600 && !$tr["endtime"]) {
                $dtt=mqfa1("select value from variables where var='deztowtype'");
                mq('UPDATE `deztow_turnir` SET `endtime` = \''.time().'\',`active` = FALSE WHERE `active` = TRUE');                
                sysmsg('Турнир Башни смерти закончился вничью.');
                if ($dtt==1) {
                  $d=date('N');
                  if ($d==5 || $d==6) {
                    $tme=mktime(14,0);
                  } else $tme=mktime(19,0);
                  if (date('H')>12) $tme+=60*60*24;
                } else {
                  $d=date('N');
                  if ($d==7) $tme=mktime(16,0);
                  else $tme=mktime(21,0);
                }
                if ($tme<time()-(60*15)) $tme=time()+(60*15);
                mq('UPDATE `variables` SET `value` = \''.$tme.'\' WHERE `var` = \'startbs\';');
                mq('UPDATE `variables` SET `value` = \''.($dtt==1?"2":"1").'\' WHERE `var` = \'deztowtype\';');
              }
            ?>
            <BR>
            <P align=right><INPUT TYPE="button" onClick="location.href('tower.php');" value="Обновить"></P>

        <?
        }
    ?></td></tr></table>
    <center><h4>Внимание! Персонаж с травмой не может зайти в БС!</h4></center>
    <center><h4>Внимание! Принять участие могут уровни от 4 и старше!</h4></center>

    <BR><BR><BR><BR>
<?
  $r=mq("select count(deztow_turnir.id) as cid, winner, deztow_turnir.winner as id, users.login, users.klan from deztow_turnir left join users on users.id=deztow_turnir.winner where active=0 and deztow_turnir.id>$minid group by winner order by cid desc, max(deztow_turnir.id) limit 0, 10");
  echo "<P><H4>Наибольшее количество побед</H4><table>";
  while ($rec=mysql_fetch_assoc($r)) {
    if (!$rec["login"]) $rec["login"]=mqfa1("select login from allusers where id='$rec[id]'");
    echo "<tr><td width=\"30\"><b>$rec[cid]</b></td><td>$rec[login] ".($rec["klan"]?"<img title=\"$rec[klan]\" src=\"i/klan/$rec[klan].gif\">":"")." <a target=\"_blank\" href=\"inf.php?$rec[id]\"><img src=\"/i/inf.gif\" border=\"0\"></a></td></tr>";
  }                                                                 //".($user["klan"]?"<img title=\"$user[klan]\" src=\"i/klan/$user[klan].gif">":"")."
  echo "</table>";
  echo mysql_error();
    $row = mysql_query("SELECT * FROM `deztow_turnir` WHERE `active` = FALSE ORDER by `id` DESC LIMIT 10;");
?>
<P><H4>Победители 10-ти предыдущих турниров</H4>
<OL>
<?
    while($data = mysql_fetch_array($row)) {
        ?>
        <LI>    Победитель: <?=$data['winnerlog']?"$data[winnerlog]":"<b>нет</b> (турнир закончился вничью)"?> Начало турнира <FONT class=date><?=date("d.m.y H:i",$data['start_time'])?></FONT> продолжительность <FONT class=date><?=floor(($data['endtime']-$data['start_time'])/60/60)?> ч. <?=floor(($data['endtime']-$data['start_time'])/60-floor(($data['endtime']-$data['start_time'])/60/60)*60)?> мин.</FONT> приз: <B><?=$data['coin']?> кр.</B> <A HREF="/towerlog.php?id=<?=$data['id']?>" target=_blank>история турнира »»</A><BR>
        </LI>
        <?
    }
?>
</OL>
<?
  $data = mysql_fetch_array(mysql_query("SELECT * FROM `deztow_turnir` where active=0 and id>$minid ORDER by `coin` DESC LIMIT 1;"));
  if ($data) { ?>
<H4>Максимальный выигрыш</H4>
Победитель: <?=$data['winnerlog']?> Начало турнира <FONT class=date><?=date("d.m.y H:i",$data['start_time'])?></FONT> продолжительность <FONT class=date><?=floor(($data['endtime']-$data['start_time'])/60/60)?> ч. <?=floor(($data['endtime']-$data['start_time'])/60-floor(($data['endtime']-$data['start_time'])/60/60)*60)?> мин.</FONT> приз: <B><?=$data['coin']?> кр.</B> <A HREF="/towerlog.php?id=<?=$data['id']?>" target=_blank>история турнира »»</A><BR>
<?
  }
  $data = mysql_fetch_array(mysql_query("SELECT * FROM `deztow_turnir` where active=0 and id>$minid ORDER by (`endtime`-`start_time`) DESC LIMIT 1;"));
  if ($data) { ?>
<H4>Самый продолжительный турнир</H4>
Победитель: <?=$data['winnerlog']?> Начало турнира <FONT class=date><?=date("d.m.y H:i",$data['start_time'])?></FONT> продолжительность <FONT class=date><?=floor(($data['endtime']-$data['start_time'])/60/60)?> ч. <?=floor(($data['endtime']-$data['start_time'])/60-floor(($data['endtime']-$data['start_time'])/60/60)*60)?> мин.</FONT> приз: <B><?=$data['coin']?> кр.</B> <A HREF="/towerlog.php?id=<?=$data['id']?>" target=_blank>история турнира »»</A><BR>
<? } ?>
</BODY>
</HTML>

#!/usr/bin/php
<?php
define("INCRON", 1);

include "connect.php";



define("LDSIMPLEBATTLE", 1);

$userslots=array('sergi','kulon','weap','r1','r2','r3','helm','perchi','shit','boots','m1','m2','m3','m4','m5','m6','m7','m8','m9','m10','naruchi','belt','leg','m11','m12','plaw','bron','rybax', 'p1', 'p2');
$dressslots = array('helm','naruchi','weap','rybax','bron','plaw','belt','sergi','kulon','r1','r2','r3','perchi','shit','leg','boots');
$caverooms=array(302);

function remfieldmember($user, $rec=0, $del=1) {
  if (!$rec) $rec=mqfa("select id, started from fieldmembers where user='$user'");
  if (!$rec["started"]) return;
  $diff=time()-$rec["started"];
  mq("update effects set time=time+$diff where owner='$user' and type<>31");
  if ($del) mq("delete from fieldmembers where id='$rec[id]'");
}

//  session_start();
    include "functions.php";
    
    
    
// ����� �� 200 �������
/*
$online = mysql_query("select id, real_time from `online`  WHERE `real_time` >= ".(time()-60).";");
$users_count = mysql_num_rows($online)+6;
if ($users_count>=200 && !mqfa1("SELECT COUNT(*) FROM visitors_counter WHERE date = CURDATE()")) {
    while ($row = mysql_fetch_assoc($online)) {
        mysql_query('UPDATE users SET money = money + 20 WHERE id = ' . $row['id']);
    }
    mysql_query('INSERT INTO visitors_counter SET count = ' . $users_count . ', date = CURDATE()');
    sysmsg("������ � ����� 200 ���. � ����� � ����, ���� ��� ������������ � ���� ��������� �������."); 
}
*/

// ��������� �������
$cLottery = mysql_result(mysql_query('SELECT COUNT(*) FROM lottery WHERE end = 0 AND date < NOW()'), 0, 0);
if ($cLottery) {
    file_get_contents('http://xn--2-btb1a.xn--p1ai/lottery.php?cronstartlotery=whf784whfy7w8jfyw8hg745g3y75h7f23785yh38259648gjn6f6734h798h2q398fgsdhnit734');
    $cLottery = mysql_result(mysql_query('SELECT COUNT(*) FROM lottery WHERE end = 0 AND date < NOW()'), 0, 0);
    if (!$cLottery) {
        sysmsg("��������� ������! ���������� ��������� ����� �������. ����� ������������ � ������������ � �������� �������, �������� ������ ������� � Old City.");    
    }
}
    
$tme1=getmicrotime();
//  include "functions.php";
/* Virt-Life cron file */
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
/*
//��������� ������� �����
$mtime = microtime();
//��������� ������� � ������������
$mtime = explode(" ",$mtime);
//���������� ���� ����� �� ������ � �����������
$mtime = $mtime[1] + $mtime[0];
//���������� ��������� ����� � ����������
$tstart = $mtime;*/





// hp operations

//  mysql_query("UPDATE `users` SET `maxhp` = (IFNULL((SELECT SUM(`ghp`) FROM `inventory` WHERE dressed=1 AND owner = `users`.id),0) + (users.vinos*6));");
//  mysql_query("UPDATE `users` SET `maxmana` = (IFNULL((SELECT SUM(`gmana`) FROM `inventory` WHERE dressed=1 AND owner = `users`.id),0) + (users.mudra*10));");

    // ������ ����
/*  $its = mysql_query("SELECT `id`,`owner`,`name` FROM `inventory` WHERE  `dressed` = 0 AND ((`maxdur` <= `duration`) OR (`dategoden` > 0 AND `dategoden` <= '".time()."'));");
    while($it = mysql_fetch_array($its))
    {
        //destructitem($it['id']);
        mysql_query("DELETE FROM `inventory` WHERE `id` = '".$it['id']."' LIMIT 1;");
        mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','\"".$it['name']."\"  ���������� id:(cap".$it['id'].").',1,'".time()."');");
    }


*/
    //============================ LAB HAOS =========================================
    /*  mysql_query("TRUNCATE TABLE `lab_inv`;");
        mysql_query("TRUNCATE TABLE `lab_bots`;");
        mysql_query("TRUNCATE TABLE `lab_trap`;");
        // cheki
        $paymers = rand (50,100);
        for($i=1;$i<=$paymers;$i++) {
            mysql_query("INSERT INTO `lab_inv` (`id_room`,`type`,`value`) values ('".rand(0,1000)."','1','".(rand(1,10)/100)."');");
        }
        for($i=1;$i<=50;$i++) {
            mysql_query("INSERT INTO `lab_inv` (`id_room`,`type`,`value`) values ('".rand(0,1000)."','2','".(rand(1,10)/100)."');");
        }
        // roomsi
        for($i=1;$i<=1000;$i++) {
            mysql_query("UPDATE `lab_rooms` SET p1='".rand(0,1000)."',p2='".rand(0,1000)."',p3='".rand(0,1000)."',p4='".rand(0,1000)."',`exit`=0 WHERE `id` = '".$i."' LIMIT 1;");
        }
        for($i=1;$i<=800;$i++) {
            mysql_query("INSERT INTO `lab_bots` (`id_room`,`id_bot`) values ('".rand(0,1000)."','".(rand(1,4)+78)."');");
        }
        for($i=1;$i<=5;$i++) {
            mysql_query("INSERT INTO `lab_bots` (`id_room`,`id_bot`) values ('".rand(0,1000)."','83');");
        }
        for($i=1;$i<=300;$i++) {
            mysql_query("INSERT INTO `lab_trap` (`id_room`,`type`) values ('".rand(0,1000)."','".(rand(1,4))."');");
        }
        mysql_query("UPDATE `lab_rooms` SET `exit`=1 WHERE id = ".rand(1,1000)." LIMIT 1;");
    */



    //====================================================================================
  $r=mq("select fieldmembers.id, fieldmembers.groupid, fieldmembers.user, fieldmembers.started from fieldmembers left join online on fieldmembers.user=online.id where online.date<".(time()-60));
  $remgroups=array();
  while ($rec=mysql_fetch_assoc($r)) {
    if ($rec["groupid"]) {
      if (@$remgroups[$rec["groupid"]]) continue;
      $remgroups[$rec["groupid"]]=1;
      $login=mqfa1("select login from users where id='$rec[user]'");
      $r2=mq("select fieldmembers.id, fieldmembers.user, fieldmembers.started, users.login from fieldmembers left join users on users.id=fieldmembers.user where users.id<>$rec[id] and fieldmembers.groupid='$rec[groupid]'");
      while ($rec2=mysql_fetch_assoc($r2)) {
        privatemsg("���� ������ ��� ������ ���������� ����������, �. �. �������� $login ����� �� ����.", $rec2["login"]);
        remfieldmember($rec2["user"], $rec2);
      }
      //mq("delete from fieldmembers where groupid='$rec[groupid]'");
    } else {
      remfieldmember($rec["user"], $rec);
      //mq("delete from fieldmembers where id='$rec[id]'");
    }
  }

    // start BS
    $tr = mysql_fetch_array(mysql_query("SELECT * FROM `deztow_turnir` WHERE `active` = TRUE"));
    if (!$tr) {
      $turnirstart = mysql_fetch_array(mysql_query("SELECT `value` FROM `variables` WHERE `var` = 'startbs' LIMIT 1;"));
      $dd = mysql_fetch_array(mysql_query("SELECT count(`kredit`) FROM `deztow_stavka`;"));
      if($dd[0] < 2 && $turnirstart[0] <= time()) {
        mysql_query('UPDATE `variables` SET `value` = \''.(time()+6*60*60).'\' WHERE `var` = \'startbs\';');
		sysmsg("������ ����� ������ �������� ����� 6 �����");
      }
      $fromprev=time()-mqfa1("select max(endtime) from deztow_turnir");
    }
    if(!$tr && $turnirstart[0] <= time() && $dd[0] >= 2 && $fromprev>0) {
      $type=mqfa1("select value from variables where var='deztowtype'");
      // �������� ��
      //mysql_query("LOCK TABLES `shop` WRITE, `deztow_items` WRITE, `deztow_realchars` WRITE, `deztow_charstams` WRITE, `deztow_eff` WRITE, `deztow_gamers_inv` WRITE,`effects` WRITE, `deztow_turnir` WRITE, `deztow_stavka` WRITE, `users` WRITE, `inventory` WRITE, `online` WRITE;");
      $minroom = 501;
      $maxroom = 560;
      // ��������� ��� ������ � ������
      $stavka = mysql_fetch_array(mysql_query("SELECT SUM(`kredit`)*0.7 FROM `deztow_stavka`;"));
      // ������� ������ � �������
      mq("INSERT `deztow_turnir` (`type`,`winner`,`coin`,`start_time`,`log`,`endtime`,`active`) values ('".rand(1,7)."','','".$stavka[0]."','".time()."','".$log."','0','1');");
      $dtid=mysql_insert_id();
      $data=mq("SELECT dt.owner FROM `deztow_stavka` as dt, `online` as o, users WHERE (SELECT count(`id`) FROM `effects` WHERE `effects`.`owner` = dt.owner AND ( type=11 OR type=12 OR type=13 OR type=14)) = 0  AND o.id = dt.owner AND users.id = dt.owner AND users.room = 31 AND o.`date` >= '".(time()-300)."' ORDER by `kredit` DESC, dt.`time` ASC  LIMIT 100;");
      // ������� �����, ���� ������ �� ������� ����
      if($data) {
        mysql_query("TRUNCATE TABLE `deztow_stavka`;");
        mysql_query("TRUNCATE TABLE `deztow_gamers_inv`;");
      }
      $invcond="";
      $dtcond="";
      $slotsto0="";
      foreach ($userslots as $k=>$v) {
        $slotsto0.=", $v='0'";
      }

      while($row=mysql_fetch_array($data)) {
        $invcond.=" or id='$row[0]' ";
        if ($type==1) {
          // ������ ������� ���� ����� � ���� �����������, ��������� � ��� �����
          // �������
          //undressall($row[0], 0, 0);
          //$shmot = mysql_query("SELECT * FROM `inventory` WHERE `owner` = '".$row[0]."' and setsale=0;");// ������� ���� ����
          //while($sh = mysql_fetch_array($shmot)) {
          //  mysql_query("INSERT `deztow_gamers_inv` (`id_item`,`owner`) values ('".$sh[0]."','".$row[0]."');");
          //}
          // effects
          /*$effs = mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$row[0]."';"); // ������� ������
          while($eff = mysql_fetch_assoc($effs)) {
              mysql_query("INSERT `deztow_eff` (`type`, `name`, `time`, `sila`, `lovk`, `inta`, `vinos`, `intel`, `mfdmag`, `mfdhit`, `owner`)
              values ('".$eff["type"]."','".$eff["name"]."','".$eff["time"]."','".$eff["sila"]."','".$eff["lovk"]."','".$eff["inta"]."','".$eff["vinos"]."','".$eff["intel"]."','".$eff["mfdmag"]."','".$eff["mfdhit"]."','".$eff["owner"]."');");
              //deltravma($eff['id']);
          }
          mysql_query("DELETE FROM `effects` WHERE `owner` = '".$row[0]."';");*/

          $tec = mysql_fetch_array(mysql_query("SELECT * FROM `deztow_charstams` WHERE `owner` = '{$row[0]}' and room=0 order by `def`='1' desc;"));
          if (!$tec) {
            $tec=array(25,25,25,25);
            $tec["sila"]=25;
            $tec["lovk"]=25;
            $tec["inta"]=25;
            $tec["vinos"]=25;
          }
          if($tec[0] && $row[0] != 83) {
            // ������
            //mq("UPDATE `inventory` SET dressed=0 WHERE `owner` = '".$row[0]."'");
            if ($tec["vinos"]>=125) $ghp=250;
            elseif ($tec["vinos"]>=100) $ghp=250;
            elseif ($tec["vinos"]>=75) $ghp=175;
            elseif ($tec["vinos"]>=50) $ghp=100;
            elseif ($tec["vinos"]>=25) $ghp=50;
            else $ghp=0;
            //".$stats."
            mq("UPDATE `users` SET`in_tower_align`=`align`, `sila`='".$tec['sila']."', `lovk`='".$tec['lovk']."',`inta`='".$tec['inta']."',`vinos`='".$tec['vinos']."',`intel`='".$tec['intel']."',`mudra`='".$tec['mudra']."', spirit=0, level=8, `stats`='0',
            `noj`=0,`mec`=0,`topor`=0,`dubina`=0,`posoh`=0,`mfire`=0,`mwater`=0,`mair`=0,`mearth`=0,`mlight`=0,`mgray`=0,`mdark`=0,`master`='9',`maxhp`='".($tec['vinos']*6+$ghp)."',`hp`='".($tec['vinos']*6+$ghp)."',`mana`='".($tec['mudra']*10)."',`maxmana`='".($tec['mudra']*10)."',  in_tower=-1
            $slotsto0
            WHERE `id` = '".$row[0]."' LIMIT 1;");
            // ���������
          }
          //resetmax($row[0], 0, 1);
        }
      }
      if ($type==1) {
        mq("update inventory set dressed=0 where 0 ".str_replace("id=","owner=",$invcond));
        mq("update effects set owner=owner+"._BOTSEPARATOR_." where 0 ".str_replace("id=","owner=",$invcond)."");
      }
      //mq("update users set invis=0 where 0 $invcond");
      $r=mq("select id, login, level, align, klan from users where (0 $invcond)");
      $lors="";
      while ($rec=mysql_fetch_assoc($r)) {
        if($lors) $lors .= ", ";
        $lors.="<img src=\"i/align_".($rec['align']>0 ? $rec['align']:"0").".gif\">";
        if ($rec['klan'] <> '') $lors.='<img title="'.$rec['klan'].'" src="i/klan/'.$rec['klan'].'.gif">';
        $lors.= "<B>$rec[login]</B> [$rec[level]]<a href=inf.php?$rec[id] target=_blank><IMG SRC=i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"���. � $rec[login]\"></a>";
      }           
      // ��������� ���
      $log = '<span class=date>'.date("d.m.y H:i").'</span> ������ �������. ���������: '.$lors.'<BR>';
      mq("update `deztow_turnir` set log='$log' where id='$dtid'");
      mq("UPDATE `users` SET invis=0, in_tower=$type, `room` = floor(rand()*60)+501 WHERE 0 $invcond");
      sysmsg("�������� ".($type==1?"����� �����":"����� ��������")." � <b>����� ������</b>. ����� ����������: ".mysql_num_rows($data).".");
    } elseif (!$tr) {
      
      $i=mqfa1("select id from deztow_items");
      if (!$i) {
        // ������������ ���� �� ��������
        
        $type=mqfa1("select value from variables where var='deztowtype'");
        $minroom = 501;
        $maxroom = 560;
        
        // ��������� ���������� ����������
        $shmots = array(2905, 2917, 2928, 2894, 2921, 2918, 2895, 2906, 2929, 2899, 2910, 2922, 2933, 2932, 2909, 2898, 2900, 2934, 2923, 2911, 2938, 2927, 2916, 2904,
        2937, 2926, 2915, 2903, 2936, 2925, 2914, 2902, 2978, 2967, 2956, 2944, 2980, 2969, 2958, 2947, 2976, 2965, 2954, 2942, 2973, 2939, 2962, 2951,
        2974, 2963, 2952, 2940, 2977, 2966, 2955, 2943, 2979, 2968, 2957, 2945, 2983, 2961, 2950, 2972, 2971, 2960, 2949, 2982, 2981, 2970, 2959, 2948,



        "2774","2796","2762","2785","2770","2781","2792","2803","2678","2690","2712","2701","2761","2795","2684","2706","2681","2692","2703","2714",
        "2673","2685","2696","2707","2686","2775","2789","2778","2679","2774","2765","2788","2777","2783","2791","2805","2794","2983","2771",
        "2804","2782","2793","2787","2803","2781","2770","2981","2914","2936","2925","2787","2764","2798","2946","2679","2768","2776","2912",
        "2946","2931","2976","2908","2920","2976","2897","2695","2973","2773","2928","2894","2905","2900","2917","2939","2935","2901",
        "2924","2929","2940","2966","2921","2930","2975","2697","2686","2775","2896","2964","2686","2775","2896","2953","2708","2708",
        "2797","2919","2941","2763","2674","2907","2933","2715","2971","2960","2926","2983","2805","2916","2927","2972","2961","2950",
        "2982","2931","2920","2899","2763","2907","2941","2967","2978","2956","2944","2981","2959","2948","2908","2679","2920","2768","2912","2946",
        "2976","2954","2965","2942","2894","2973","2962","2951","2939","2906","2952","2940","2974","2969","2979","2957","2945","2968","2909",
        "2966","2921","2943","2955","97","97","97","98","99","2977","2786","2930","2975","2686","2775","2896","2964","2919","2953","2907","2763",
        "2674","2941","2956","2952","3018","86","101","97","100","121","102","120","103","9","111","103","120","114",
        "121","171","171","121","121","102","2774","2796","2762","2785","2770","2781","2792","2803","2678","2690","2712","2701","2761","2795","2684","2706","2681",
        "2692","2703","2714","2673","2685","2696","2707","2686","2775","2789","2778","2679","2774","2765","2788","2777","2783","2791","2805","2794","2983","2771",
        "2804","2782","2793","2787","2803","2781","2770","2981","2914","2936","2925","2787","2764","2798","2946","2679","2768","2776","2912","2946","2931","2976",
        "2908","2920","2976","2897","2695","2973","2773","2928","2894","2905","2900","2917","2939","2935","2901","2924","2929","2940","2966","2921","2930",
        "2975","2697","2686","2775","2896","2964","2686","2775","2896","2953","2708","2708","2797","2919","2941","2763","2674","2907","2933","2715","2971",
        "2960","2926","2983","2805","2916","2927","2972","2961","2950","2982","2931","2920","2899","2763","2907","2941","2967","2978","2956","2944","2981","2959",
        "2948","2908","2679","2920","2768","2912","2946","2976","2954","2965","2942","2894","2973","2962","2951","2939","2906","2952","2940","2974","2969",
        "2979","2957","2945","2968","2909","2966","2921","2943","2955","2977","2786","2930","2975","2686","2775","2896","2964","2919","2953","2907","2763",
        "2674","2941","2956","2952","3018","86","101","97","97","97","97","98","99","100","121","102","120","103","9","111",
        "103","120","121","171","171","121","121","102","2774","2796","2762","2785","2770","2781","2792","2803","2678","2690","2712","2701","2761","2795","2684","2706",
        "2681","2692","2703","2714","2673","2685","2696","2707","2686","2775","2789","2778","2679","2774","2765","2788","2777","2783","2791","2805","2794","2983","2771",
        "2804","2782","2793","2787","2803","2781","2770","2981","2914","2936","2925","2787","2764","2798","2946","2679","2768","2776","2912","2946","2931","2976","2908",
        "2920","2976","2897","2695","2973","2773","2928","2894","2905","2900","2917","2939","2935","2901","2924","2929","2940","2966","2921","2930","2975","2697",
        "2686","2775","2896","2964","2686","2775","2896","2953","2708","2708","2797","2919","2941","2763","2674","2907","2933","2715","2971","2960","2926","2983",
        "2805","2916","2927","2972","2961","2950","2982","2931","2920","2899","2763","2907","2941","2967","2978","2956","2944","2981","2959","2948","2908","2679","2920","2768",
        "2912","2946","2976","2954","2965","2942","2894","2973","2962","2951","2939","2906","2952","2940","2974","2969","2979","2957","2945","2968","2909","2966","2921",
        "2943","2955","2977","2786","2930","2975","2686","2775","2896","2964","2919","2953","2907","2763","2674","2941","2956","2952","3018","86","101","97","97","97","97","98",
        "99","100","121","102","120","103","9","111","103","120","121","171","171","121","121","102","2774","2796","2762","2785","2770","2781","2792",
        "2803","2678","2690","2712","2701","2761","2795","2684","2706","2681","2692","2703","2714","2673","2685","2696","2707","2686","2775","2789","2778","2679","2774","2765","2788","2777","2783","2791",
        "2805","2794","2983","2771","2804","2782","2793","2787","2803","2781","2770","2981","2914","2936","2925","2787","2764","2798","2946","2679","2768","2776","2912","2946","2931","2976",
        "2908","2920","2976","2897","2695","2973","2773","2928","2894","2905","2900","2917","2939","2935","2901","2924","2929","2940","2966","2921","2930","2975","2697","2686","2775",
        "2896","2964","2686","2775","2896","2953","2708","2708","2797","2919","2941","2763","2674","2907","2933","2715","2971","2960","2926","2983","2805","2916",
        "2927","2972","2961","2950","2982","2931","2920","2899","2763","2907","2941","2967","2978","2956","2944","2981","2959","2948","2908","2679","2920","2768","2912","2946","2976","2954","2965",
        "2942","2894","2973","2962","2951","2939","2906","2952","2940","2974","2969","2979","2957","2945","2968","2909","2966","2921","2943","2955","2977","2786","2930","2975","2686","2775",
        "2896","2964","2919","2953","2907","2763","2674","2941","2956","2952","3018","86","101","97","97","97","97","98","99","100","121","102","120","103","9",
        "111","103","120","121","171","171","121","121","102"
        );
        $wmot=unserialize(implode("",file("/var/www/donagan/data/www/xn--2-btb1a.xn--p1ai/data/deztowshmot.dat")));
        while($sh = array_shift($shmots)) {
                $shopid = mysql_fetch_array(mysql_query("SELECT * FROM `shop` WHERE `id` = '".$sh."' LIMIT 1;"));

                mysql_query("INSERT `deztow_items` (`iteam_id`, `name`, `img`, `room`) values ('".$shopid['id']."', '".$shopid['name']."', '".$shopid['img']."', '".rand($minroom,$maxroom)."');");
            }

        if ($type!=1) {
          $shopid = mqfa("SELECT * FROM `shop` WHERE `id` = '1766'");
          $i=$minroom;
          while ($i<=$maxroom) {
            mysql_query("INSERT `deztow_items` (`iteam_id`, `name`, `img`, `room`) values ('".$shopid['id']."', '".$shopid['name']."', '".$shopid['img']."', '".$i."');");
            $i++;
          }
        }
      }
    }

    define("USERBATTLE",0);

    $r=mq("select id, win from battle where needbb=2 and win=3");
    $r2=mq("select id, win from battle where needbb=1 and win=3 and (timeout*90+to1<".time()." or timeout*90+to2<".time().")");
    if (mysql_num_rows($r)>0 || mysql_num_rows($r2)>0) include "fbattle.php";
    include_once "incl/strokedata.php";
    $battles=array();

    while ($rec=mysql_fetch_assoc($r)) {
      mq("LOCK TABLES `bots` WRITE, `puton` WRITE, `userdata` WRITE, `priem` WRITE, `deztow_realchars` write, `shop` WRITE, `person_on` WRITE, `podzem3` WRITE, `canal_bot` WRITE, `labirint` WRITE, `battle` WRITE, `logs` WRITE, `users` WRITE, `inventory` WRITE, `magic` WRITE, `effects` WRITE, `clans` WRITE, `online` WRITE, `telegraph` WRITE, `allusers` WRITE, `quests` WRITE, `battleeffects` WRITE, `items` WRITE, `podzem2` WRITE, `battleunits` WRITE, `berezka` WRITE, `qtimes` WRITE, `smallitems` WRITE, `podzem_zad_login` write, `caveparties` write, `caveitems` write, `cavebots` write, errorstats write, caves write, userstrokes write, variables write, droplog write;");      
      $fbattle=new fbattle($rec["id"]);
      foreach ($fbattle->battle as $k=>$v) {
        if ($k>_BOTSEPARATOR_) {
          foreach ($v as $k2=>$v2) {
            if ($k2<_BOTSEPARATOR_) continue;
            if ($fbattle->battle[$k][$k2][0] && $fbattle->battle[$k2][$k][0] && $fbattle->userdata[$k]["hp"]>0 && $fbattle->userdata[$k2]["hp"]>0) {
              $fbattle->makechange($k, $k2);
              $fbattle->write_log();
              $fbattle->battle[$k][$k2]=array(0,0,time());
              $fbattle->battle[$k2][$k]=array(0,0,time());
              if ($cond) $tocond.=" or ";
              $battles[$rec["id"]]=1;
            }
          }
          $fbattle->checkbotstrokes($k);
        }
      }
      if ($fbattle->needupdate) $fbattle->update_battle();
      $fbattle->updatebattleunits();
      mq("unlock tables");
    }
    while ($rec=mysql_fetch_assoc($r2)) {
      mq("LOCK TABLES `bots` WRITE, `puton` WRITE, `userdata` WRITE, `priem` WRITE, `deztow_realchars` write, `shop` WRITE, `person_on` WRITE, `podzem3` WRITE, `canal_bot` WRITE, `labirint` WRITE, `battle` WRITE, `logs` WRITE, `users` WRITE, `inventory` WRITE, `magic` WRITE, `effects` WRITE, `clans` WRITE, `online` WRITE, `telegraph` WRITE, `allusers` WRITE, `quests` WRITE, `battleeffects` WRITE, `items` WRITE, `podzem2` WRITE, `battleunits` WRITE, `berezka` WRITE, `qtimes` WRITE, `smallitems` WRITE, `podzem_zad_login` write, `caveparties` write, `caveitems` write, `cavebots` write, errorstats write, caves write, userstrokes write, variables write, droplog write;");      
      $fbattle=new fbattle($rec["id"]);
      foreach ($fbattle->battle as $k=>$v) {
        if ($k>_BOTSEPARATOR_) {
          foreach ($v as $k2=>$v2) {
            if ($k2>_BOTSEPARATOR_) continue;
            if ($fbattle->userdata[$k]["hp"]>0 && $fbattle->userdata[$k2]["hp"]>0) {
              $fbattle->battle[$k2][$k][0]=664;
              $fbattle->battle[$k2][$k][1]=664;
              $fbattle->makechange($k, $k2);
              $fbattle->write_log();
              $fbattle->battle[$k][$k2]=array(0,0,time());
              $fbattle->battle[$k2][$k]=array(0,0,time());
              if ($cond) $tocond.=" or ";
              $battles[$rec["id"]]=1;
            }
          }
          $fbattle->checkbotstrokes($k);
        }
      }
      if ($fbattle->needupdate) $fbattle->update_battle();
      $fbattle->updatebattleunits();
      mq("unlock tables");
    }


    $cond="";
    foreach ($battles as $k=>$v) {
      if ($cond) $cond.=" or ";
      $cond.=" id='$k' ";
    }
    if ($cond) {
      mq("update battle set to1=".time().", to2=".time()." where $cond");
    }
    /*
    //mysql_query("LOCK TABLES `inventory` WRITE, `battle` WRITE, `bots` WRITE, `users` WRITE");


    $t1=floor(time()-900);
    $bots = mysql_query ("SELECT bots.*, battle.teams FROM `bots` left join battle on battle.id=bots.battle WHERE bots.hp > 0 and bots.battle in (SELECT id FROM `battle` WHERE `win`='3' and `to1`>'".$t1."' and `to2`>'".$t1."');");
    //$bots = mysql_query ("SELECT * FROM `bots` WHERE `hp` > 0 and battle in (SELECT id FROM `battle` WHERE `win`='3' and `to1`>'".$t1."' and `to2`>'".$t1."');");
    $bb = new botbattle;
    while ($bot = mysql_fetch_array($bots)) {
        //$bd = mysql_fetch_array(mysql_query ('SELECT * FROM `battle` WHERE `id` = '.$bot['battle'].' LIMIT 1;'));
        //$battle = unserialize($bd['teams']);
        $battle = unserialize($bot['teams']);
        // ������� �����������, ������ ������.
        if ($battle[$bot['id']]) {
        foreach ($battle[$bot['id']] as $k => $v) {

            if($battle[$bot['id']][$k][0] == 0 && $k > 10000000) {

            $lid = mysql_query ('SELECT user_id FROM `users` WHERE `id` = '.$bot['prototype'].';');
            if($lad = mysql_fetch_array($lid)){
            if($lad['user_id']!='0'){$es = $lad['user_id'];}else{$es = $bot['id'];}

            $bb->razmen_init($bot['id'],$k,$bot['battle'],$es);}

            }
        }
        $bb->updatebattle();

        }
        //mysql_query('UPDATE `battle` SET `teams` = \''.serialize($battle).'\' WHERE `id` = '.$bot['battle'].' ;');
    }
    //mysql_query("UNLOCK TABLES;");
    */

    $tme=localtime();
    if ($tme[1]%10==0) {
      mq("insert into stats (dat, visitors) values (now(), ".mnr("select distinct(users.ip) from `online` left join users on users.id=online.id WHERE `date` >= unix_timestamp()-60").")");
    }

  function maketeams($t1, $t2) {
    print_r($t1);
    print_r($t2);
    foreach($t1 as $k=>$v) {
      foreach($t2 as $kk => $vv) {
        $teams[$v][$vv] = array(0,0,time());
        $teams[$vv][$v] = array(0,0,time());
      }
    }
    return $teams;
  }

  function startgroupbattle($users, $quest, $minusers=5, $timeout=3, $comment="", $type=3, $blood=0, $closed=1) {
    foreach($users as $k=>$v) {
      if (!isonline($v)) unset($users[$k]);
    }
    if (count($users)<$minusers) return false;
    $team1=array();
    $team2=array();
    $i=0;
    foreach ($users as $k=>$v) {
      $i++;
      if ($i%2) $team1[]=$v;
      else $team2[]=$v;
    }

    $teams=maketeams($team1, $team2);

    mysql_query("INSERT INTO `battle` (`id`,`coment`,`teams`,`timeout`,`type`,`status`,`t1`,`t2`,`to1`,`to2`,`blood`,`quest`, `closed`)
    VALUES (NULL,'$coment','".serialize($teams)."','$timeout','$type','0','".implode(";",$team1)."','".implode(";",$team2)."','".time()."','".time()."','".$blood."', '$quest', '$closed')");
    $id = mysql_insert_id();
    // ������� ���
    $rr = "<b>";
    foreach( $team1 as $k=>$v ) {
      if ($k!=0) { $rr.=", "; $rrc.=", "; }
      $rr .= nick3($v);
      $rrc .= nick7($v);
      addchp ('<font color=red>��������!</font> ��� ��� �������!<BR>\'; top.frames[\'main\'].location=\'fbattle.php\'; var z = \'   ','{[]}'.nick7 ($v).'{[]}');
    }
    $rr .= "</b> � <b>"; $rrc .= "</b> � <b>";
    foreach( $team2 as $k=>$v ) {
      if ($k!=0) { $rr.=", "; $rrc.=", ";}
      $rr .= nick3($v);
      $rrc .= nick7($v);
      addchp ('<font color=red>��������!</font> ��� ��� �������!<BR>\'; top.frames[\'main\'].location=\'fbattle.php\'; var z = \'   ','{[]}'.nick7 ($v).'{[]}');
    }
    $rr .= "</b>";
    addch ("<a href=logs.php?log=".$id." target=_blank>��������</a> ����� <B>".$rrc."</B> �������.   ",$user['room']);
    mysql_query("INSERT INTO `logs` (`id`,`log`) VALUES('{$id}','���� ���������� <span class=date>".date("Y.m.d H.i")."</span>, ����� ".$rr." ������� ����� ���� �����. <BR>');");
    addlog($id,"���� ���������� <span class=date>".date("Y.m.d H.i")."</span>, ����� ".$rr." ������� ����� ���� �����. <BR>");

    // ���� � ���!!!
    foreach($team1 as $k=>$v) {
      mysql_query("UPDATE users SET `battle`='$id',`zayavka`=0 WHERE `id`=$v");
    }
    foreach($team2 as $k=>$v) {
      mysql_query("UPDATE users SET `battle`='$id',`zayavka`=0 WHERE `id`=$v");
    }
    return true;
  }

  function deleffect($rec) {
    mq("delete from effects where id='$rec[id]'");
    mq("update users set sila=sila-$rec[sila], lovk=lovk-$rec[lovk], inta=inta-$rec[inta], intel=intel-$rec[intel] where id='$rec[owner]'");
    mq("delete from effects where id='$rec[id]'");
  }

  function remelix($u) {
    $r=mq("select * from effects where owner='$u' and type=188");
    while ($rec=mysql_fetch_assoc($r)) {
      deleffect($rec);
    }
    mq("delete from effects where (type=201 or type=202) and owner='$u'");
  }
  /*
  $dance=mqfa1("select value from variables where var='dance'");
  if ($dance<=time()) {
    $r=mq("select user from dance");
    while ($rec=mysql_fetch_assoc($r)) {
      $user=mqfa("select room, battle, helm from users where id='$rec[user]'");
      if ($user["room"]==46 && $user["battle"]==0) {
        $p=mqfa1("select prototype from inventory where id='$user[helm]'");
        if ($p!=1) continue;
        undressall($rec["user"], 8);
        $users[]=$rec["user"];
      }
    }
    if (startgroupbattle($users, 4)) {
      foreach ($users as $k=>$v) remelix($v);
      mq("truncate table dance");
      mq("update variables set value=value+3600 where var='dance'");
    } else {
      mq("update variables set value=value+600 where var='dance'");
    }
  }*/

  $i=mqfa1("select value from variables where var='startbs2'");
  if ($i<=time()) {  
    include "functions/movedtbots.php";
    $dtf=mqfa("select id, start from fields where room=72");
    if (!$dtf) {
      $r=mq("select user from fieldmembers where valid=1 and room=71 order by stake desc limit 0, 40");
      $cond="";
      while ($rec=mysql_fetch_assoc($r)) {
        if ($cond) $cond.=" or ";
        $cond.=" id='$rec[user]' ";
      }
      if (mysql_num_rows($r)>1) {
        $slotsto0="";
        foreach ($userslots as $k=>$v) {
          $slotsto0.=", $v='0'";
        }

        $starts[]=array(2,4);
        $starts[]=array(4,4);
        $starts[]=array(3,2);
        $starts[]=array(7,2);
        $starts[]=array(6,4);
        $starts[]=array(7,5);
        $starts[]=array(9,2);
        $starts[]=array(10,4);
        $starts[]=array(9,6);
        $starts[]=array(11,3);
        $starts[]=array(13,2);
        $starts[]=array(15,3);
        $starts[]=array(8,8);
        $starts[]=array(1,8);
        $starts[]=array(3,8);
        $starts[]=array(2,10);
        $starts[]=array(4,10);
        $starts[]=array(2,11);
        $starts[]=array(6,9);
        $starts[]=array(11,7);
        $starts[]=array(14,8);
        $starts[]=array(12,9);
        $starts[]=array(11,10);
        $starts[]=array(9,11);
        $starts[]=array(6,11);
        $starts[]=array(14,11);
        $starts[]=array(15,12);
        $starts[]=array(15,13);
        $starts[]=array(13,13);
        $starts[]=array(11,13);
        $starts[]=array(8,14);
        $starts[]=array(6,14);
        $starts[]=array(4,14);
        $starts[]=array(5,12);
        $starts[]=array(6,14);
        $starts[]=array(8,16);
        $starts[]=array(9,18);
        $starts[]=array(7,17);
        $starts[]=array(10,17);
        $starts[]=array(10,20);
        $starts[]=array(13,16);
        $starts[]=array(12,17);
        $starts[]=array(13,20);
        shuffle($starts);

        $map=mqfa1("select map from cavemaps where room=71");
        $map=unserialize($map);
        mq("lock tables fields write, fielditems write, users write, online write, fieldparties write, fieldmembers write, obshagaeffects write, inventory write, deztow_charstams write, effects write, setstats write, variables write, fieldlogs write");
        mq("delete from fieldparties where user=11137 or user=11138 or user=11139");
        mq("insert into fields set map='".serialize($map)."', room=72, start=".time());
        $field=mysql_insert_id();                        
        mq("update fielditems set field='$field' where id<1000");
        $x=1;
        $r=mq("select id, login, shadow, sex, level, klan from users where $cond");
        $members=0;
        $x=1;$y=3;
        $membersstr="";
        while ($rec=mysql_fetch_assoc($r)) {
          $start=array_pop($starts);
          mq("insert into fieldparties set user='$rec[id]', field='$field', x='$start[0]', y='$start[1]', dir='".rand(0,3)."', login='$rec[login]', shadow='$rec[sex]/$rec[shadow]'");
          addchnavig("������� ������ ����� ������", $rec["login"], "field.php");
          $members++;

          $tec = mqfa("SELECT * FROM `deztow_charstams` WHERE `owner` = '$rec[id]' and room=71 order by def desc");
          if (!$tec) {
            $tec=array(25,25,25,25);
            $tec["sila"]=25;
            $tec["lovk"]=25;
            $tec["inta"]=25;
            $tec["vinos"]=25;
          }
          if ($tec["vinos"]>=125) $ghp=250;
          elseif ($tec["vinos"]>=100) $ghp=250;
          elseif ($tec["vinos"]>=75) $ghp=175;
          elseif ($tec["vinos"]>=50) $ghp=100;
          elseif ($tec["vinos"]>=25) $ghp=50;
          else $ghp=0;
          mq("UPDATE `users` SET`in_tower_align`=`align`, `sila`='".$tec['sila']."', `lovk`='".$tec['lovk']."',`inta`='".$tec['inta']."',`vinos`='".$tec['vinos']."',`intel`='".$tec['intel']."',`mudra`='".$tec['mudra']."', spirit=0, level=8, `stats`='0',
          `noj`=0,`mec`=0,`topor`=0,`dubina`=0,`posoh`=0,`mfire`=0,`mwater`=0,`mair`=0,`mearth`=0,`mlight`=0,`mgray`=0,`mdark`=0,`master`='9',`maxhp`='".($tec['vinos']*6+$ghp)."',`hp`='".($tec['vinos']*6+$ghp)."',`mana`='".($tec['mudra']*10)."',`maxmana`='".($tec['mudra']*10)."', in_tower=-1
          $slotsto0
          WHERE `id` = '$rec[id]'");
          if ($membersstr) $membersstr.=", ";
          $membersstr.=fullnick($rec);
        }
        mq("insert into fieldlogs set team1='<span class=date>".date("d.m.y H:i")."</span>', id='$field', log='<H3>����� ������. ����� � ������� ".date("d.m.y H:i").".</H3><span class=date>".date("H:i")."</span> ������ �������. ���������: $membersstr<br>', room=72, started=".time());

        $start=array_pop($starts);
        foreach ($wps as $k=>$v) {
          if ($v[0]==$start[0] && $v[1]==$start[1]) {
            $dir=$v[2];
            break;
          }
        }
        mq("insert into fieldparties set user='11137', field='$field', x='$start[0]', y='$start[1]', login='����� �����', shadow='1/cvergbeast.gif', dir='$dir'");

        $start=array_pop($starts);
        foreach ($wps as $k=>$v) {
          if ($v[0]==$start[0] && $v[1]==$start[1]) {
            $dir=$v[2];
            break;
          }
        }
        mq("insert into fieldparties set user='11138', field='$field', x='$start[0]', y='$start[1]', login='������� �����', shadow='1/cvergbeast.gif', dir='$dir'");

        $start=array_pop($starts);
        foreach ($wps as $k=>$v) {
          if ($v[0]==$start[0] && $v[1]==$start[1]) {
            $dir=$v[2];
            break;
          }
        }
        mq("insert into fieldparties set user='11139', field='$field', x='$start[0]', y='$start[1]', login='�������� �����', shadow='1/cvergbeast.gif', dir='$dir'");

        sysmsg("������� ������ ��������� ����� ������. ����� ����������: $members");

        mq("update inventory set dressed=0 where ".str_replace("id=","owner=",$cond));
        mq("UPDATE `effects` SET `owner` = owner+"._BOTSEPARATOR_." where ".str_replace("id=","owner=",$cond));
        mq("update users set invis=0, caveleader='$field', room=72, in_tower=71, hp=maxhp, mana=maxmana where $cond");
        $cond=str_replace("id=", "user=", $cond);
        mq("delete from fieldmembers where $cond");
        include "/functions/makedtitems.php";
        mq("unlock tables");
      } else {
        sysmsg("������ ��������� ����� ������ ������� �� 2 ����.");
        mq("update variables set value=".(60*60*2+time())." where var='startbs2'");
      }
    } elseif ($dtf["start"]+180<time()) {
      $data=unserialize(implode("", file("fielddata/$dtf[id]-1.dat")));
      movedtbots("$dtf[id]-1");
    }
  }

  $ldfield=mqfa("select id, team1, team2, pts1, pts2 from fields where room=63");
  if ($ldfield["team1"]=="--") $ldfield["team1"]="-";
  if ($ldfield["team2"]=="--") $ldfield["team2"]="-";
  if (($ldfield["team1"]=="-" || $ldfield["team2"]=="-") && !$ldfield["pts1"] && !$ldfield["pts2"]) {
    $winner=0;
    if ($ldfield["team1"]!="-") $winner=1;
    elseif ($ldfield["team2"]!="-") $winner=2;
    if ($winner) {
      mq("update fields set pts$winner=1, team1='-', team2='-' where id='$ldfield[id]'");
      if (!LDSIMPLEBATTLE) sysmsg("� ����� ����� � ���� �������".($winner==1?" ����":"� ����").".");
      $winners=mqfa1("select value from variables where var='ldteam$winner'");
      $winners=explode("-", $winners);
      foreach ($winners as $k=>$v) {
        if (!$v) continue;
        mq("INSERT INTO `effects` set owner=$v, name='���������� ������ �������', time=".(60*60*24+time()).", type=186, mfdhit=100, mfdmag=100, mf='mfhitp/mfmagp', mfval='20/20'");
        addchp ('���� ������� �������� � ����� �������.','{[]}'.nick7 ($v).'{[]}');
      }
    } else {
      mq("update fields set pts1=-1, pts2=-1 where id='$ldfield[id]'");
      if (!LDSIMPLEBATTLE) sysmsg("����� ����� � ���� ����������� ������.");
    }
    mq("update users set room=62, in_tower=0 where room=63");
  }

  if (date('G')==22 && $ldfield) {
    mq("delete from fields where id='$ldfield[id]'");
  }
  if (date('G')>=23 && !$ldfield) {
    $r=mq("select user from fieldmembers where valid=1 and room=62 order by id");
    $cond="";
    while ($rec=mysql_fetch_assoc($r)) {
      if ($cond) $cond.=" or ";
      $cond.=" users.id='$rec[user]' ";
    }
    $r=mq("select users.id, users.align, sum(cost) as cost from users left join inventory on inventory.owner=users.id where ($cond) and inventory.dressed=1 and inventory.type<>25 group by users.id");
    $cost1=0;
    $cost2=0;
    $other=array();
    $tostart=array();

    while ($rec=mysql_fetch_assoc($r)) {
      $at=aligntype($rec["align"]);
      if (LDSIMPLEBATTLE) $at=0; 
      if ($at==1) {
        $cost1+=$rec["cost"];
        $tostart[0][]=$rec["id"];
      } elseif ($at==2) {
        $cost2+=$rec["cost"];
        $tostart[1][]=$rec["id"];
      } else {
        $other[]=$rec;
      }
    }

    while (count($other)>0) {
      $maxc=-1;
      $mi=0;
      foreach ($other as $k=>$v) {
        if ($v["cost"]>$maxc) {
          $mi=$k;
          $maxc=$v["cost"];
        }
      }
      $rec=$other[$mi];
      if ($cost1<$cost2) {
        $cost1+=$rec["cost"];
        $tostart[0][]=$rec["id"];
      } else {
        $cost2+=$rec["cost"];
        $tostart[1][]=$rec["id"];
      }
      unset($other[$mi]);
    }
    if (count($tostart[0])>count($tostart[1])) $max=count($tostart[0]); else $max=count($tostart[1]);
    $map=array();
    $y=0;
    $ht=21;
    while ($y<=$ht) {
      $x=0;
      while ($x<=$max*2+2) {
        if (($x%2!=$y%2 && $x>0 && $y>0) && ($x==1 || $y==1 || $y==$ht || $x==1 || $x==$max*2+1)) $map[$y][$x]=1;
        elseif ($x>0 && $y>0 && $x%2==0 && $y%2==0 && $x<$max*2+1 && $y<$ht) {
          $map[$y][$x]="s/1/2";
        } else $map[$y][$x]=0;
        $x++;
      }
      $y++;
    }

    mq("lock tables fields write, users write, online write, fieldparties write, fieldmembers write, obshagaeffects write, inventory write, deztow_charstams write, effects write, setstats write, variables write");
    mq("update variables set value='-".implode("-",$tostart[0])."-' where var='ldteam1'");
    mq("update variables set value='-".implode("-",$tostart[1])."-' where var='ldteam2'");
    mq("insert into fields set map='".serialize($map)."', team1='-".implode("-",$tostart[0])."-', team2='-".implode("-",$tostart[1])."-', room=63");
    $field=mysql_insert_id();
    $cond="";
    $x=1;
    foreach ($tostart[0] as $k=>$v) {
      $rec=mqfa("select login, shadow, sex from users where id='$v'");
      mq("insert into fieldparties set user='$v', field='$field', x='$x', y='1', dir='3', login='$rec[login]', shadow='$rec[sex]/$rec[shadow]', team=1");
      $x++;
      if ($cond) $cond.=" or ";
      $cond.=" id='$v' ";
      addchnavig((LDSIMPLEBATTLE?"�������� ����� �������.":"����� ����� � ���� ��������!"), $rec["login"], "field.php");
    }
    $x=1;
    foreach ($tostart[1] as $k=>$v) {
      $rec=mqfa("select login, shadow, sex from users where id='$v'");
      mq("insert into fieldparties set user='$v', field='$field', x='$x', y='10', dir='1', login='$rec[login]', shadow='$rec[sex]/$rec[shadow]', team=2");
      $x++;
      $cond.=" or id='$v' ";
      addchnavig("����� ����� � ���� ��������!", $rec["login"], "field.php");
    }
    if (LDSIMPLEBATTLE) sysmsg("�������� ����� �������. ����� ����������: ".(count($tostart[0])+count($tostart[1])));
    else sysmsg("�������� ����� ����� � ����. ����� ���������� �� ����: ".count($tostart[0])." �� ����: ".count($tostart[1]));
    mq("update users set caveleader='$field', room=63, in_tower=62, s_duh=100*(spirit+if(level>=10,40,if(level>=9,30,if(level>=8,20,10)))), hp=maxhp, mana=maxmana where $cond");
    $cond=str_replace("id=", "user=", $cond);
    mq("delete from fieldmembers where $cond");
    mq("unlock tables");
  }

  //��� ����� ����� ��� �����
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
  $r=mq("SELECT * FROM `clans` WHERE clanexp>=needexp");
  while ($klan=mysql_fetch_assoc($r)) {
    mq("UPDATE `clans` SET `needexp` = ".$klanexptable[$klan['needexp']][1].",`clanlevel` = `clanlevel`+".$klanexptable[$klan['needexp']][0]."
    WHERE `id` = '$klan[id]'");
  }


  $siege=mqfa1("select value from variables where var='siege'");
  if ($siege<=2) {
    $r=mq("select users.id from `online` left join users on users.id=online.id WHERE users.room>=700 and users.room<800 and users.battle=0 and (`date`<".time()."-60 or users.hp<=0 ".($siege==0?" or users.klan=''":"").")");
    while ($rec=mysql_fetch_assoc($r)) moveuser($rec["id"], 49);
  }
  if ($siege==1 || $siege==2) {
    $owner=mqfa1("select value from variables where var='castleowner'");
    $c=mqfa1("select count(id) from users where room>=700 and room<800 and klan='$owner'");
    if ($c==0) { 
      sysmsg("��� ��������� ����� ���������. ��������� �������� ����� �� �������� ������. ���������� ����������: ".mqfa1("select count(id) from users where room>=700 and room<800"));
      $siege=0;
      mq("update variables set value=0 where var='siege'");
      mq("update variables set value='' where var='castleowner'");
    } else {
      $c=mqfa1("select count(id) from users where room>=700 and room<800 and klan<>'$owner'");
      if ($c==0) { 
        sysmsg("����� ���������� ��������, ����� ������� �� ������� ����������.");
        $siege=0;
        mq("update variables set value='".(strtotime("next Sunday") + (21 * 3600))."' where var='siege'");
      }
    }
  } elseif (!$siege) {
    $r=mq("select distinct klan from users where room>=700 and room<800");
    if (mysql_num_rows($r)<=1) {
      $rec=mysql_fetch_assoc($r);
      mq("update variables set value='".(strtotime("next Sunday") + (21 * 3600))."' where var='siege'");
      mq("update variables set value='$rec[klan]' where var='castleowner'");
      if ($rec["klan"]) sysmsg("����� �� ����� ��������. ��������: ���� <b>".mqfa1("select name from clans where short='$rec[klan]'")."</b>.");
    }
  } elseif ($siege<=time()) {
    $r=mq("select users.id from `online` left join users on users.id=online.id WHERE users.room>=700 and users.room<800 and `date`<".time()."-60");
    while ($rec=mysql_fetch_assoc($r)) moveuser($rec["id"], 49);
    $r=mq("select effects.id, users.room from effects left join users on effects.owner=users.id where effects.type=1022");
    while ($rec=mysql_fetch_assoc($r)) {
      if (incastle($rec["room"])) {
        mq("update effects set time=1 where id='$rec[id]'");
      }
    }
    $o=getvar("castleowner");
    if (!$o) {
      setvar("siege", 0);
      sysmsg("�������� ����� �� �������� �����, ����� ����������: ".mqfa1("select count(id) from users where room>=700 and room<800").".");
    } else {
      setvar("siege", 2);
      sysmsg("�������� ����� ��������� �����. ����������: ".mqfa1("select count(id) from users where room>=700 and room<800 and klan='$o'").", ����������: ".mqfa1("select count(id) from users where room>=700 and room<800 and klan<>'$o'").".");
    }
  }

  $q=getvar("queststart");
  if ($q && $q<time()) {
    include "functions/checkexplosion.php";
    /*if ($q==10) {
      include DOCUMENTROOT."functions/checkboulder.php";
    } else setvar("queststart", 10);*/
  }

  $a=getvar("auction");
  if ($a<time()) {
    $r=mq("select * from lots");
    while ($rec=mysql_fetch_assoc($r)) {
      if (!$rec["user"]) continue;
      if ($rec["id"]==1) {
        mq("lock tables userdata write, users write");
        $e=mqfa1("select extra from userdata where id='$rec[user]'");
        if ($e) $e=unserialize($e); else $e=array();
        if (@$e["stats"][$rec["room"]]<3) {
          @$e["stats"][$rec["room"]]++;
          mq("update userdata set extra='".serialize($e)."', extrastats=extrastats+1, stats=stats+1 where id='$rec[user]'");
          mq("update users set stats=stats+1 where id='$rec[user]'");
        }
        mq("unlock tables");
      }
      if ($rec["id"]==2) {
        mq("lock tables userdata write, users write");
        $e=mqfa1("select extra from userdata where id='$rec[user]'");
        if ($e) $e=unserialize($e); else $e=array();
        if (@$e["master"]["$rec[room]"]<1) {
          @$e["master"][$rec["room"]]++;
          mq("update userdata set extra='".serialize($e)."', extramaster=extramaster+1, master=master+1 where id='$rec[user]'");
          mq("update users set master=master+1 where id='$rec[user]'");
        }
        mq("unlock tables");
      }
      if ($rec["id"]==3) $taken=takeshopitem(2316, "shop", "����������", "", 2, 0, $rec["user"]);
      if ($rec["id"]==4) $taken=takeshopitem(1678, "shop", "����������", "", 2, 0, $rec["user"]);
      if ($rec["id"]==5) $taken=takeshopitem(101773, "berezka", "����������", "", 2, 0, $rec["user"]);
      if ($rec["id"]==6) $taken=takeshopitem(101708, "berezka", "����������", "", 2, 0, $rec["user"]);
      if ($rec["id"]==7) $taken=takeshopitem(6, "shop", "����������", "", 2, 0, $rec["user"]);
      if ($rec["id"]==8) $taken=takeshopitem(2262, "shop", "����������", "", 2, array("nintel"=>0, "ngray"=>0), $rec["user"]);
      if ($rec["id"]==9) $taken=takeshopitem(1995, "shop", "", "", 0, 0, $rec["user"]);
      adddelo($rec["user"], "�������� �� ��������: \"$rec[name]\"".(@$taken["id"]?"(id: $taken[id])":""), 1);
    }
    mq("update lots set item=0, qty=0, user=0");
    $tme=mktime(0,0);
    $tme+=60*60*24*7;
    setvar("auction", $tme);
  }
  mq("delete from effects where (type=2 or type=3) and time<".time());

    //====================================================================================
/*
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
//���������� ����� ��������� � ������ ����������
$tend = $mtime;
//��������� �������
$totaltime = ($tend - $tstart);
//������� �� �����
printf ("PGT: %f ������", $totaltime);  */
echo "Finished";

$nowtime = time();

$info_pole = mysql_fetch_array(mysql_query("select * from `variables` where `var`='pole_random'"));

//echo"��������� ��������:".$info_pole['value'];
$ff_time = time();
$f_time = $ff_time +  14400; 

if($info_pole['value'] == ''){
    echo"OK";
for($i=0; $i<41; $i++) {
$hrand = rand(1,11)/10;
$rand = rand(1,9);
$rekrr = 30/30;
$rekr = rand(1,$rekrr)/10;
$bonus = rand(1,13)/10;
$bonuss = $rekr * $bonus;
$rekrr = $rekr + $bonuss;
if($rand == 1){$h = 100;}
elseif($rand == 2){$h = 80;}
elseif($rand == 3){$h = 70;}
elseif($rand == 4){$h = 60;}
elseif($rand == 5){$h = 50;}
elseif($rand == 6){$h = 40;}
elseif($rand == 7 || $rand == 8 || $rand == 9){$h = 0;}

$hh = $h * $hrand;
$h = $h + $hh;

mysql_query("UPDATE `pole` set `type`='".$rand."',`heals`='".$h."',`ekr`='".$rekrr."' where `id`='".$i."'");
}
mysql_query("update `variables` set `value`='".$f_time."' where `var`='".$info_pole['var']."'");}



else{
echo"OK";
if($info_pole['value'] < $nowtime){

echo"OK";
for($i=0; $i<41; $i++) {
$hrand = rand(1,11)/10;
$rand = rand(1,9);
$rekrr = 30/30;
$rekr = rand(1,$rekrr)/10;
$bonus = rand(1,13)/10;
$bonuss = $rekr * $bonus;
$rekrr = $rekr + $bonuss;
if($rand == 1){$h = 100;}
elseif($rand == 2){$h = 80;}
elseif($rand == 3){$h = 70;}
elseif($rand == 4){$h = 60;}
elseif($rand == 5){$h = 50;}
elseif($rand == 6){$h = 40;}
elseif($rand == 7 || $rand == 8 || $rand == 9){$h = 0;}

$hh = $h * $hrand;
$h = $h + $hh;

mysql_query("UPDATE `pole` set `type`='".$rand."',`heals`='".$h."',`ekr`='".$rekrr."' where `id`='".$i."'");
}
mysql_query("update `variables` set `value`=`value`+'14400' where `var`='".$info_pole['var']."'");
}
}
?>

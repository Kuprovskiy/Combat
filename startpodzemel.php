<?
define("BOTSWITH1HP", 0);
function startpod($who,$bot,$nomer,$user){
  global $mir;
  $quest=0;
  $query=mysql_query("SELECT id FROM users WHERE login='$who'");
  $db=mysql_fetch_array($query);
  $name2="";
  $name3="";
  if($bot=='c1'){$name = "����������"; $d1 = "����������";}
  if($bot=='c2'){$name = "�����"; $d1 = "�����";}

  if($bot=='1'){$name = "����"; $d1 = "����";}
  else if($bot=='2'){$name = "�����"; $d1 = "�����";}
  else if($bot=='3'){$name = "���"; $d1 = "���";}


  else if($bot=='4'){$name = "��������"; $d1 = "��������";}
  else if($bot=='5'){$name = "���������"; $d1 = "���������";}
  else if($bot=='6'){$name = "������"; $d1 = "������";}
  else if($bot=='7'){$name = "������"; $d1 = "������";}
  else if($bot=='8'){$name = "����"; $d1 = "����";}
  else if($bot=='c20667'){$name = "����� ��������"; $d1 = "����� ��������";}

  //////////////////2 ����/////////////////////
  else if($bot=='9'){$name = "�����"; $d1 = "�����";}
  else if($bot=='10'){$name = "����������"; $d1 = "����������";}
  else if($bot=='11'){$name = "��������"; $d1 = "��������";}
  else if($bot=='12'){$name = "��������"; $d1 = "��������";}
  else if($bot=='13'){$name = "����"; $d1 = "����";}
  else if($bot=='14'){$name = "������"; $d1 = "������";}
  else if($bot=='15'){$name = "�������"; $d1 = "�������";}
  else if($bot=='16'){$name = "�����"; $d1 = "�����";}
  else if($bot=='17'){$name = "��������"; $d1 = "��������";}
  else if($bot=='18'){$name = "������"; $d1 = "������"; $quest=3;}
  else if($bot>=29 && $bot<=31){
    list($name,$fuck)=botname($bot);
    $d1=$name; }
////////////////////////���������� 1000 ���������////////////////////////////////////
else if($bot=='19'){$name = "�������� ����"; $d1 = "�������� ����";}
else if($bot=='20'){$name = "���"; $d1 = "���";}
else if($bot=='21'){$name = "������ ������"; $d1 = "������ ������";}
else if($bot=='22'){$name = "��������� ������"; $d1 = "��������� ������";}
else if($bot=='23'){$name = "���� ������"; $d1 = "���� ������";}

else if($bot=='24'){$name = "���"; $d1 = "���";}
else if($bot=='25'){$name = "������� �����"; $d1 = "������� �����";}
else if($bot=='26'){$name = "�������� �����"; $d1 = "�������� �����";}
else if($bot=='27'){$name = "������"; $d1 = "������";}
else if($bot=='28'){$name = "�����"; $d1 = "�����";}

else if($bot=='19.19'){$name = "�������� ����"; $name2 = "�������� ����"; $d1 = "�������� ����(1)"; $d2 = "�������� ����(2)";}
else if($bot=='20.20'){$name = "���"; $name2 = "���"; $d1 = "���(1)"; $d2 = "���(2)";}
else if($bot=='21.21'){$name = "������ ������"; $name2 = "������ ������"; $d1 = "������ ������(1)"; $d2 = "������ ������(2)";}
else if($bot=='22.22'){$name = "��������� ������"; $name2 = "��������� ������"; $d1 = "��������� ������(1)"; $d2 = "��������� ������(2)";}
else if($bot=='23.23'){$name = "���� ������"; $name2 = "���� ������"; $d1 = "���� ������(1)"; $d2 = "���� ������(2)";}

else if($bot=='24.24'){$name = "���"; $name2 = "���"; $d1 = "���(1)"; $d2 = "���(2)";}
else if($bot=='25.25'){$name = "������� �����"; $name2 = "������� �����"; $d1 = "������� �����(1)"; $d2 = "������� �����(2)";}
else if($bot=='26.26'){$name = "�������� �����"; $name2 = "�������� �����"; $d1 = "�������� �����(1)"; $d2 = "�������� �����(2)";}
else if($bot=='27.27'){$name = "������"; $name2 = "������"; $d1 = "������(1)"; $d2 = "������(2)";}
else if($bot=='28.28'){$name = "�����"; $name2 = "�����"; $d1 = "�����(1)"; $d2 = "�����(2)";}

else if($bot=='19.19.19'){$name = "�������� ����"; $name2 = "�������� ����"; $name3 = "�������� ����"; $d1 = "�������� ����(1)"; $d2 = "�������� ����(2)"; $d3 = "�������� ����(3)";}
else if($bot=='20.20.20'){$name = "���"; $name2 = "���"; $name3 = "���"; $d1 = "���(1)"; $d2 = "���(2)"; $d3 = "���(3)";}
else if($bot=='21.21.21'){$name = "������ ������"; $name2 = "������ ������"; $name3 = "������ ������"; $d1 = "������ ������(1)"; $d2 = "������ ������(2)"; $d3 = "������ ������(3)";}
else if($bot=='22.22.22'){$name = "��������� ������"; $name2 = "��������� ������"; $name3 = "��������� ������"; $d1 = "��������� ������(1)"; $d2 = "��������� ������(2)"; $d3 = "��������� ������(3)";}
else if($bot=='23.23.23'){$name = "���� ������"; $name2 = "���� ������"; $name3 = "���� ������"; $d1 = "���� ������(1)"; $d2 = "���� ������(2)"; $d3 = "���� ������(3)";}

else if($bot=='24.24.24'){$name = "���"; $name2 = "���"; $name3 = "���"; $d1 = "���(1)"; $d2 = "���(2)"; $d3 = "���(3)";}
else if($bot=='25.25.25'){$name = "������� �����"; $name2 = "������� �����"; $name3 = "������� �����"; $d1 = "������� �����(1)"; $d2 = "������� �����(2)"; $d3 = "������� �����(3)";}
else if($bot=='26.26.26'){$name = "�������� �����"; $name2 = "�������� �����"; $name3 = "�������� �����"; $d1 = "�������� �����(1)"; $d2 = "�������� �����(2)"; $d3 = "�������� �����(3)";}
else if($bot=='27.27.27'){$name = "������"; $name2 = "������"; $name3 = "������"; $d1 = "������(1)"; $d2 = "������(2)"; $d3 = "������(3)";}
else if($bot=='28.28.28'){$name = "�����"; $name2 = "�����"; $name3 = "�����"; $d1 = "�����(1)"; $d2 = "�����(2)"; $d3 = "�����(3)";}
//////////////////////////////////////////
  
  ////////////////////////////////////////////////////////////
  else if($bot=='1.1'){$name = "����"; $name2 = "����"; $d1 = "����(1)"; $d2 = "����(2)";}
  else if($bot=='1.2'){$name = "����"; $name2 = "�����"; $d1 = "����"; $d2 = "�����";}
  else if($bot=='1.3'){$name = "����"; $name2 = "���"; $d1 = "����"; $d2 = "���";}
  else if($bot=='2.2'){$name = "�����"; $name2 = "�����"; $d1 = "�����(1)"; $d2 = "�����(2)";}
  else if($bot=='2.3'){$name = "�����"; $name2 = "���"; $d1 = "�����"; $d2 = "���";}
  else if($bot=='3.3'){$name = "���"; $name2 = "���"; $d1 = "���(1)"; $d2 = "���(2)";}

  //////////////////2 ����/////////////////////
  else if($bot=='9.9'){$name = "�����"; $name2 = "�����"; $d1 = "�����(1)"; $d2 = "�����(2)";}
  else if($bot=='10.10'){$name = "����������"; $name2 = "����������"; $d1 = "����������(1)"; $d2 = "����������(2)";}
  else if($bot=='11.11'){$name = "��������"; $name2 = "��������"; $d1 = "��������(1)"; $d2 = "��������(2)";}
  else if($bot=='12.12'){$name = "��������"; $name2 = "��������"; $d1 = "��������(1)"; $d2 = "��������(2)"; }
  else if($bot=='13.13'){$name = "����"; $name2 = "����"; $d1 = "����(1)"; $d2 = "����(2)";}
  else if($bot=='14.14'){$name = "������"; $name2 = "������"; $d1 = "������(1)"; $d2 = "������(2)";}
  else if($bot=='15.15'){$name = "�������"; $name2 = "�������"; $d1 = "�������(1)"; $d2 = "�������(2)";}
  else if($bot=='16.16'){$name = "�����"; $name2 = "�����"; $d1 = "�����(1)"; $d2 = "�����(2)";}
  else if($bot=='17.17'){$name = "��������"; $name2 = "��������"; $d1 = "��������(2)"; $d2 = "��������(2)";}
  else if($bot=='18.18'){$name = "������"; $name2 = "������"; $d1 = "������(1)"; $d2 = "������(2)";}
  //////////////////////////////////////////
  else if($bot=='1.1.1'){$name = "����"; $name2 = "����"; $name3 = "����"; $d1 = "����(1)"; $d2 = "����(2)"; $d3 = "����(3)";}
  else if($bot=='1.1.2'){$name = "����"; $name2 = "����"; $name3 = "�����"; $d1 = "����(1)"; $d2 = "����(2)"; $d3 = "�����";}
  else if($bot=='1.1.3'){$name = "����"; $name2 = "����"; $name3 = "���"; $d1 = "����(1)"; $d2 = "����(2)"; $d3 = "���";}
  else if($bot=='1.2.2'){$name = "����"; $name2 = "�����"; $name3 = "�����"; $d1 = "����"; $d2 = "�����(1)"; $d3 = "�����(2)";}
  else if($bot=='1.3.2'){$name = "����"; $name2 = "���"; $name3 = "�����"; $d1 = "����"; $d2 = "���"; $d3 = "�����";}
  else if($bot=='1.3.3'){$name = "����"; $name2 = "���"; $name3 = "���"; $d1 = "����"; $d2 = "���(1)"; $d3 = "���(2)";}
  else if($bot=='2.2.2'){$name = "�����"; $name2 = "�����"; $name3 = "�����"; $d1 = "�����(1)"; $d2 = "�����(2)"; $d3 = "�����(3)";}
  else if($bot=='2.2.3'){$name = "�����"; $name2 = "�����"; $name3 = "���"; $d1 = "�����(1)"; $d2 = "�����(2)"; $d3 = "���";}
  else if($bot=='2.3.3'){$name = "�����"; $name2 = "���"; $name3 = "���"; $d1 = "�����"; $d2 = "���(1)"; $d3 = "���(2)";}
  else if($bot=='3.3.3'){$name = "���"; $name2 = "���"; $name3 = "���"; $d1 = "���(1)"; $d2 = "���(2)"; $d3 = "���(3)";}

  else if($bot=='9.9.9'){$name = "�����"; $name2 = "�����"; $name3 = "�����"; $d1 = "�����(1)"; $d2 = "�����(2)"; $d3 = "�����(3)";}
  else if($bot=='10.10.10'){$name = "����������"; $name2 = "����������"; $name3 = "����������"; $d1 = "����������(1)"; $d2 = "����������(2)"; $d3 = "����������(3)";}
  else if($bot=='11.11.11'){$name = "��������"; $name2 = "��������"; $name3 = "��������"; $d1 = "��������(1)"; $d2 = "��������(2)"; $d3 = "��������(3)";}
  else if($bot=='12.12.12'){$name = "��������"; $name2 = "��������"; $name3 = "��������"; $d1 = "��������(1)"; $d2 = "��������(2)";  $d3 = "��������(3)";}
  else if($bot=='13.13.13'){$name = "����"; $name2 = "����"; $name3 = "����"; $d1 = "����(1)"; $d2 = "����(2)"; $d3 = "����(3)";}
  else if($bot=='14.14.14'){$name = "������"; $name2 = "������"; $name3 = "������"; $d1 = "������(1)"; $d2 = "������(2)"; $d3 = "������(3)";}
  else if($bot=='15.15.15'){$name = "�������"; $name2 = "�������"; $name3 = "�������"; $d1 = "�������(1)"; $d2 = "�������(2)"; $d3 = "�������(3)";}
  else if($bot=='16.16.16'){$name = "�����"; $name2 = "�����"; $name3 = "�����"; $d1 = "�����(1)"; $d2 = "�����(2)"; $d3 = "�����(3)";}
  else if($bot=='17.17.17'){$name = "��������"; $name2 = "��������"; $name3 = "��������"; $d1 = "��������(2)"; $d2 = "��������(2)"; $d3 = "��������(3)";}
  else if($bot=='18.18.18'){$name = "������"; $name2 = "������"; $name3 = "������"; $d1 = "������(1)"; $d2 = "������(2)"; $d3 = "������(3)";}
          $mine_id=$db["id"];

          $ass = mysql_query("SELECT glav_id,glava FROM labirint WHERE user_id='$mine_id'");
          $lab = mysql_fetch_array($ass);
          $glav_id = $lab["glav_id"];
          $glava = $lab["glava"];
  mysql_query("UPDATE labirint SET boi='$nomer',di='0' WHERE user_id='$mine_id'");
  $T1 = mysql_query("INSERT INTO canal_bot (glava,boi,bot,nomer) VALUES('$glava','$nomer','$bot','$nomer')");



  //////////////////////////////////////////////////////
  $sex = mysql_query("SELECT maxhp,id FROM users WHERE login='$name'");
  $dded=mysql_fetch_array($sex);
  if (BOTSWITH1HP) $dded["maxhp"]=1;
  mysql_query("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('".$d1."','".$dded["id"]."','','".$dded["maxhp"]."');");
  $bot = mysql_insert_id();
  $teams = array();

  $teams[$user['id']][$bot] = array(0,0,time());
  $teams[$bot][$user['id']] = array(0,0,time());

  mysql_query("INSERT INTO `battle`(`id`,`coment`,`teams`,`timeout`,`type`,`status`,`t1`,`t2`,`to1`,`to2`, quest, date)VALUES(NULL,'','".serialize($teams)."','10','1','0','".$user['id']."','".$bot."','".time()."','".time()."', '$quest', '".date("Y-m-d H:i")."')");
  $id = mysql_insert_id();
                      // �������� ����
  mysql_query("UPDATE `bots` SET `battle` = {$id} WHERE `id` = {$bot} LIMIT 1;");
                      // ������� ���
  $rr = "<b>".nick3($user['id'])."</b> � <b>".nick3($bot)."</b>";
  addlog($id,"���� ���������� <span class=date>".date("Y.m.d H.i")."</span>, ����� ".$rr." ������� ����� ���� �����. <BR>");
  mysql_query("UPDATE users SET `battle` ={$id},`zayavka`=0 WHERE `id`= {$user['id']};");

  if($name2!=''){
  $sex2 = mysql_query("SELECT maxhp,id FROM users WHERE login='$name2'");
  $dded2=mysql_fetch_array($sex2);
  if (BOTSWITH1HP) $dded2["maxhp"]=1;
  mysql_query("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('".$d2."','".$dded2["id"]."','{$id}','".$dded2["maxhp"]."');");
  $bot2 = mysql_insert_id();

  $bd2 = mysql_fetch_array(mysql_query ("SELECT * FROM `battle` WHERE `id` = '{$id}' LIMIT 1;"));
  $battle2 = unserialize($bd2['teams']);
  $battle2[$bot2] = $battle2[$bot];
  foreach($battle2[$bot2] as $k2 => $v2) {
  $battle2[$k2][$bot2] = array(0,0,time());
  }
  $t12 = explode(";",$bd2['t1']);
  // ����������� ���-���
  if (in_array ($user['id'],$t12)) {$ttt2 = 2;} else {    $ttt2 = 1;}

  $sdds2 = mysql_query("UPDATE `battle` SET `teams` = '".serialize($battle2)."', `t".$ttt2."`=CONCAT(`t".$ttt2."`,';".$bot2."')  WHERE `id` = '{$id}'");
  mysql_query("UPDATE `battle` SET `to1` = '".time()."', `to2` = '".time()."' WHERE `id` = '{$id}' LIMIT 1;");
  }

  if($name3!=''){
  $sex3 = mysql_query("SELECT maxhp,id FROM users WHERE login='$name3'");
  $dded3=mysql_fetch_array($sex3);
  if (BOTSWITH1HP) $dded3["maxhp"]=1;
  mysql_query("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('".$d3."','".$dded3["id"]."','{$id}','".$dded3["maxhp"]."');");
  $bot3 = mysql_insert_id();

  $bd3 = mysql_fetch_array(mysql_query ("SELECT * FROM `battle` WHERE `id` = '{$id}' LIMIT 1;"));
  $battle3 = unserialize($bd3['teams']);
  $battle3[$bot3] = $battle3[$bot];
  foreach($battle3[$bot3] as $k3 => $v3) {
  $battle3[$k3][$bot3] = array(0,0,time());
  }
  $t13 = explode(";",$bd3['t1']);
  // ����������� ���-���
  if (in_array ($user['id'],$t13)) {$ttt3 = 2;} else {    $ttt3 = 1;}

  $sdds3 = mysql_query("UPDATE `battle` SET `teams` = '".serialize($battle3)."', `t".$ttt3."`=CONCAT(`t".$ttt3."`,';".$bot3."')  WHERE `id` = '{$id}'");

  mysql_query("UPDATE `battle` SET `to1` = '".time()."', `to2` = '".time()."' WHERE `id` = '{$id}' LIMIT 1;");
  }

  //////////////////////////////////////////////////////
  die("<script>location.href='fbattle.php';</script>");
  //////////////////////////////////////////////////////
}

?>

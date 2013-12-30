<?php
  if ($_SERVER["REMOTE_ADDR"]=="127.0.0.1") {
    define("BATTLEDEBUG",0);
    define("SHOWSOLVEDMF",0);
    define("DIEAFTERSOLVEDMF",0);
  } else {
    define("BATTLEDEBUG",0);
    define("SHOWSOLVEDMF",0);
    define("DIEAFTERSOLVEDMF",0);
  }
//ini_set("display_errors", 1);

  ob_start("ob_gzhandler");
  session_start();
//  if ($_SESSION['uid']==7) {header("Location: fbattle2.php"); die();}

  if (!($_SESSION['uid'] >0)) {
    header("Location: index.php"); mysql_query('UPDATE `users` SET `hp2` = 0,`hp3` = 0,`hit` = 0,`s_duh` = 0,`krit` = 0,`counter` = 0,`block2` = 0,`parry` = 0  WHERE `id` = '.$_SESSION['uid'].'');
    mysql_query("DELETE FROM `person_on` WHERE `id_person`='".$_SESSION['uid']."'");
  }
  include './connect.php';
  // ставим блокировку на таблицу
  include_once("incl/strokedata.php");

  mysql_query("LOCK TABLES `bots` WRITE, `puton` WRITE, `priem` WRITE, `shop` WRITE, `person_on` WRITE, `podzem3` WRITE, `canal_bot` WRITE, `labirint` WRITE, `battle` WRITE, `logs` WRITE, `users` WRITE, `inventory` WRITE, `magic` WRITE, `effects` WRITE, `clans` WRITE, `online` WRITE, `telegraph` WRITE, `allusers` WRITE, `quests` WRITE, `battleeffects` WRITE, `items` WRITE;");
  echo mysql_error();
  $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
  if ($user["mana"]<0) $user["mana"]=0;
  //$klan = mysql_fetch_array(mysql_query("SELECT name, clanexp FROM `clans` WHERE `name` = '{$user['klan']}' LIMIT 1;"));
  include './functions.php';
  if (@$_POST['end'] != null) {
    header("Location: main.php"); mysql_query('UPDATE `users` SET `hp2` = 0,`hp3` = 0,`hit` = 0,`s_duh` = 0,`krit` = 0,`counter` = 0,`block2` = 0,`parry` = 0  WHERE `id` = '.$_SESSION['uid'].'');
    mysql_query("DELETE FROM `person_on` WHERE `id_person`='".$_SESSION['uid']."'");
  }
  if(!$_SESSION['btime']){$chk=time()-$_SESSION['btime'];}
  if(@$chk && $chk<=2 && $_SESSION['btime']){ unset($attack); unset($defend); unset($_POST['attack']); unset($_POST['defend']);}else{$_SESSION['btime']=time(); }

// ========================================================================================================================================================
// начало исполняемого кода битвы
//=========================================================================================================================================================
  $s_duh=$user['s_duh'];$hit=$user['hit'];$krit=$user['krit'];$block=$user['block2'];$parry=$user['parry'];$hp=$user['hp2'];$counter=$user['counter'];
  $chkwear1 = mysql_query('SELECT id FROM `inventory` WHERE (`type` = 3 AND `dressed` = 1) AND `owner` = '.$user['id'].';');
  $sumwear=0;
  while ($chkwear = mysql_fetch_array($chkwear1)) {
    $sumwear++;
  }

function logstrokeend($priem) {
  global $strokes, $user;
  addlog($user['battle'],'<span class=date>'.date("H:i").'</span> Закончилось действие приёма "<FONT color=#A00000><b>'.$strokes[$priem]->name.'</b></font>".<BR>');
}

function notzero($d) {
  if ($d<1) return 1; else return ceil($d);
}

function checkshit($ui) {
  $ui=bottouser($ui);
  return mqfa1('SELECT id FROM `inventory` where  `owner` = '.$ui.' AND `dressed` = 1 and (`type` = 10 or otdel=30) ');
}

function checkanimalexp($id, $exp) {
  $level=mysql_query("select level from users where id='$id'");
  $level=mysql_fetch_assoc($level);
  $level=$level["level"];
  if ($level==0) $me=50;
  if ($level==1) $me=60;
  if ($level==2) $me=110;
  if ($level==3) $me=115;
  if ($level==4) $me=175;
  if ($level==5) $me=250;
  if ($level==6) $me=500;
  if ($level==7) $me=2700;
  if ($level==8) $me=9000;
  if ($level==9) $me=10000;
  if ($exp>$me) return $me;
  return $exp;
}


class prieminfo{
  var $id_priem;
  var $name;
  var $type;
  var $priem;
  var $n_block;
  var $n_counter;
  var $n_hit;
  var $n_hp;
  var $n_krit;
  var $n_parry;
  var $minlevel;
  var $wait;
  var $maxuses;
  var $minhp;
  var $sduh_proc;
  var $sduh;
  var $hod;
  var $intel;
  var $mana;
  var $opisan;
  var $m_magic1;
  var $m_magic2;
  var $m_magic3;
  var $m_magic4;
  var $m_magic5;
  var $m_magic6;

  var $m_magic7;
  var $needsil;
  var $needvyn;
  function prieminfo($s,$priem) { # либо по id ($s) либо по названию $priem
    if ($s) {
$res=mysql_fetch_array (mysql_query("select * from priem where id_priem='".$s."';"));
  //    $res=db_use('array',"select * from priem where id_priem='".$s."';");
    }else{
$res=mysql_fetch_array (mysql_query("select * from priem where priem='".$priem."';"));
 //     $res=db_use('array',"select * from priem where priem='".$priem."';");
    }
    $this->id_priem=$res['id_priem'];#$id_priem;
    $this->name=$res['name'];
    $this->type=$res['type'];
    $this->priem=$res['priem'];
    $this->n_block=$res['n_block'];
    $this->n_counter=$res['n_counter'];
    $this->n_hit=$res['n_hit'];
    $this->n_hp=$res['n_hp'];
    $this->n_krit=$res['n_krit'];
    $this->n_parry=$res['n_parry'];
    $this->minlevel=$res['minlevel'];
    $this->wait=$res['wait'];
    $this->maxuses=@$res['maxuses'];
    $this->minhp=$res['minhp'];
    $this->sduh_proc=$res['sduh_proc'];
    $this->sduh=$res['sduh'];
    $this->hod=$res['hod'];
    $this->intel=$res['intel'];
    $this->mana=$res['mana'];
    $this->opisan=$res['opisan'];
    $this->m_magic1=$res['m_magic1'];
    $this->m_magic2=$res['m_magic2'];
    $this->m_magic3=$res['m_magic3'];
    $this->m_magic4=$res['m_magic4'];
    $this->m_magic5=$res['m_magic5'];
    $this->m_magic6=$res['m_magic6'];
    $this->m_magic7=$res['m_magic7'];
    $this->needsil=$res['need_sil'];
    $this->needvyn=$res['need_vyn'];
    $this->target=(int)$res['target'];
  }
  function check_hars($n) {
global $user; # проверка. n=0: все хар-ки n=1: только жизнь и мана
    if($n==0) {

      if(($this->minlevel<=$user['level']) && ($this->intel<=$user['intel']) && ($this->needsil<=$user['sila']) && ($this->needvyn<=$user['vinos']) && ($this->m_magic1<=$user['mfire']) && ($this->m_magic2<=$user['mwater']) && ($this->m_magic3<=$user['mair']) && ($this->m_magic4<=$user['mearth']) && ($this->m_magic5<=$user['mlight']) && ($this->m_magic6<=$user['mgray']) && ($this->m_magic7<=$user['mdark']) ) {
        return true;
      }else{return false;}
    }elseif($n==1){
      if($this->check_hars(0) && ($this->mana<=$user['mana']) && ($this->minhp<=$user['hp'])) {
        return true;     # !!!!!!!!!!!!!!!! НЕ ДОДЕЛАНО !!!!!!!!!!!!!!!!!!!!!!
      }else{return false;}
    }
  }
  function checkbattlehars($myinfo,$hit,$krit,$parry,$counter,$block,$s_duh,$hp) { # влад магией, статы + хар-ки битвы
global $user;
$s_duh = floor($s_duh/100);
  if (
  $hit>=$this->n_hit &&
  $krit>=$this->n_krit &&
  $parry>=$this->n_parry &&
  $counter>=$this->n_counter &&
  $hp>=$this->n_hp &&
  $block>=$this->n_block &&
  $user['level']>=$this->minlevel &&
  $user['hp']>=$this->minhp &&
  $s_duh>=$this->sduh &&
  $user['intel']>=$this->intel &&
  $user['mana']>=$this->mana &&
  $user['mfire']>=$this->m_magic1 &&
  $user['mwater']>=$this->m_magic2 &&
  $user['mair']>=$this->m_magic3 &&
  $user['mearth']>=$this->m_magic4 &&
  $user['mlight']>=$this->m_magic5 &&
  $user['mgray']>=$this->m_magic6 &&
  $user['mdark']>=$this->m_magic7 &&
  $user['sila']>=$this->needsil &&
  $user['vinos']>=$this->needvyn ) {
mysql_query("update person_on set `pr_active`= 1 WHERE id_person='".$_SESSION['uid']."' and pr_name='".$this->priem."' and `pr_active` < 2");
  return true;}


/*echo"

  ".$hit.">=".$this->n_hit." &&
  ".$krit.">=".$this->n_krit." &&
  ".$parry.">=".$this->n_parry." &&
  ".$counter.">=".$this->n_counter." &&
  ".$hp.">=".$this->n_hp." &&
  ".$block.">=".$this->n_block." &&
  ".$user['level'].">=".$this->minlevel." &&
  ".$user['hp'].">=".$this->minhp." &&
  (".$s_duh." && (".$s_duh.">=".$this->sduh." OR ".$this->sduh_proc.")) &&
  ".$user['intel'].">=".$this->intel." &&
  ".$user['mana'].">=".$this->mana." &&
  ".$user['mfire'].">=".$this->m_magic1." &&
  ".$user['mwater'].">=".$this->m_magic2." &&
  ".$user['mair'].">=".$this->m_magic3." &&
  ".$user['mearth'].">=".$this->m_magic4." &&
  ".$user['mlight'].">=".$this->m_magic5." &&
  ".$user['mgray'].">=".$this->m_magic6." &&
  ".$user['mdark'].">=".$this->m_magic7." &&
  ".$user['sila'].">=".$this->needsil." &&
  ".$user['vinos'].">=".$this->needvyn.""

;*/
  }
  }


class ActivePriems {
  var $priems;
  function ActivePriems($id_person){
   // $res=db_use('query',"select * from person_on where type=3 and id_person='".$id_person."'");
   $res=mq("select id, pr_active,pr_cur_uses,pr_wait_for,pr_name from person_on where type=3 and id_person='".$id_person."'");
   $arr=array ();
   while ($s=mysql_fetch_assoc($res)) {
     $arr[$s['pr_name']]['active']=$s['pr_active'];
     $arr[$s['pr_name']]['uses']=$s['pr_cur_uses'];
     $arr[$s['pr_name']]['wait']=$s['pr_wait_for'];
     $arr[$s['pr_name']]['id']=$s['id'];
   }
   $this->priems=$arr;
  }
}


  if (@$_GET['uszver'] && $user['zver_id']>0 && !$user["in_tower"]) {

    $zver=mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$user['zver_id']}' LIMIT 1;"));
    $q=mqfa1("select quest from battle where id='$user[battle]'");
    if($zver && $q!=4){
    if($zver['sitost']>=3){
//      $nb = mysql_fetch_array(mysql_query("SELECT id FROM `bots` WHERE battle='".$user['battle']."' and `name` LIKE '".$zver['login']."';"));
        $nb = mysql_fetch_array(mysql_query("SELECT id FROM `bots` WHERE battle='".$user['battle']."' and prototype='".$user['zver_id']."';"));
        if(!$nb){
        mysql_query("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('".$zver['login']."','".$zver['id']."','".$user['battle']."','".$zver['hp']."');");
        $bot = mysql_insert_id();

        $bd = mysql_fetch_array(mysql_query ('SELECT * FROM `battle` WHERE `id` = '.$user['battle'].' LIMIT 1;'));
        $battle = unserialize($bd['teams']);
        $battle[$bot] = $battle[$user['id']];
        foreach($battle[$bot] as $k => $v) {
            $battle[$k][$bot] = array(0,0,time());
        }
        $t1 = explode(";",$bd['t1']);
        if (in_array ($user['id'],$t1)) {$ttt = 1;} else {  $ttt = 2;}
        addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick5($user['id'],"B".$ttt).' призвал своего зверя '.nick5($bot,"B".$ttt).'<BR>');

        mysql_query('UPDATE `battle` SET `teams` = \''.serialize($battle).'\', `t'.$ttt.'`=CONCAT(`t'.$ttt.'`,\';'.$bot.'\')  WHERE `id` = '.$user['battle'].' ;');

        mysql_query("UPDATE `battle` SET `to1` = '".time()."', `to2` = '".time()."' WHERE `id` = ".$user['battle']." LIMIT 1;");

        $bet=1;
        echo "Ваш зверь призван в бой.";

        }else{echo "Ваш зверь уже был призван в бой.";}
        }else{echo "Ваш зверь слишком голодный.";}
        }else{echo "У вас нет зверя!";}




  }
















    class fbattle {
            public $mysql = null; // идентификатор мускуль сессии
            public $status = null; // статус сражения  ---- 0 - нет битвы; 1 - есть битва
            public $battle = array(); //массив с драчующимися
            public $battle_data = array(); // данные по битве
            public $enemy = null; // идентификатор противника
            public $damage = array(); // массив с нанесенным уроном
            public $t1 = array(); // первая команда
            public $t2 = array(); // вторая команда
            public $team_enemy = array(); // команда противника (ссылка на тимсы)
            public $team_mine = array(); // своя команда
            public $user = array(); // инфа на игрока
            public $enemyhar = array(); // инфа на противника
            public $enemy_dress = array(); // шмот врага
            public $user_dress = array(); // свой  шмот
            public $en_class, $my_class; // цвета для лога
            public $bots = array (); public $botsid = array ();//Массив с ботами
            public $log = ""; // агреггатор лога
            public $to1; public $to2; //таймауты
            public $exp = array(); // экспа
            public $log_debug = "";

  function getforcefield($i) {
    if (!@$this->forcefields[$i]) {
      $fr=mqfa("select id, value, priem from battleeffects where user='$i' and battle='".$this->battle_data["id"]."' and effect='".FORCEFIELD."'");
      if ($fr && $fr["value"]<=0) mq("delete from battleeffects where id='$fr[id]'");
      if (@$fr["value"]<0) $fr["value"]=0;
      $this->forcefields[$i]["value"]=@$fr["value"];
      $this->forcefields[$i]["id"]=@$fr["id"];
      $this->forcefields[$i]["priem"]=@$fr["priem"];
    }
    return $this->forcefields[$i];
  }

  function takehp($v, $i) {
    $ff=$this->getforcefield($i);
    if ($v<0) $v=0;
    if ($ff["value"]>0) {
      if ($ff["value"]>$v) {
        mq("update battleeffects set value=value-$v where id='$ff[id]'");
        $this->forcefields[$i]["value"]-=$v;
      } else {
        $this->forcefields[$i]["value"]=0;
        mq("delete from battleeffects where id='$ff[id]'");
        logstrokeend($ff["priem"]);
      }
      $v-=$ff["value"];
    }
    if ($v>0) {
      if ($i>_BOTSEPARATOR_) mq('UPDATE `bots` SET `hp` = `hp` - '.$v.' WHERE `id` = '.$i.'');
      else mq('UPDATE users SET `hp` = `hp` - '.$v.' WHERE `id` = '.$i.'');
    }
  }

  function addhp2($me, $damage) {
    if ($me==1) {
      if (!@$this->enemyhar["maxhp"]) $this->enemyhar["maxhp"]=mqfa1("select maxhp from users where id=".bottouser($this->enemy));
      $id=$this->user["id"];
      $maxhp=$this->enemyhar["maxhp"];
    } else {
      if (!@$this->enemyhar["id"]) $this->enemyhar["id"]=$this->enemy;
      $maxhp=$this->user["maxhp"];
      $id=$this->enemyhar["id"];
    }
    if ($damage>0) {
      mq("update users set hp2=hp2+".($damage/$maxhp*10)." where id='$id'");
    }
  }

  function hitpower($user, $type) {
    if ($type=="kol") return ($user["sila"]*0.6)+$user["lovk"]*0.4;
    if ($type=="rub") return ($user["sila"]*0.6)+$user["lovk"]*0.2+$user["inta"]*0.2;
    if ($type=="rej") return $user["sila"]*0.6+$user["inta"]*0.4;
    if ($type=="drob") return $user["sila"];
    if ($type=="mag") return (($user["sila"]/2)+($user["lovk"])/2)*($user["intel"]/200+1);
    return $user["sila"];
  }

  function checkpriemsuv(&$priems, $class, $user) {
    global $strokes;
    $ret=array();
    foreach ($priems as $k=>$v) {
      if (@$strokes[$k]->uvorot && $v["active"]>1) {
        if (@$strokes[$k]->counter) $ret["counter"]=1;
        $ret["uvorot"]=1;
        addlog2($this->battle_data["id"], $class, $user, $k);
        $priems[$k]["active"]=1;
        mq("update person_on set pr_active=1  WHERE id='".$v["id"]."'");
      }
    }
    return $ret;
  }

  function checkpriemskrit(&$priems, $class, $user) {
    global $strokes;
    $ret=array();
    foreach ($priems as $k=>$v) {
      if ($k=="krit_blindluck" && $v["active"]>1) {
        $ret["krit"]=1;
        addlog2($this->battle_data["id"], $class, $user, $k);
        $priems[$k]["active"]=1;
        mq("update person_on set pr_active=1  WHERE id='".$v["id"]."'");
      }
    }
    return $ret;
  }


  function checkpriems1(&$priems, $class, $user, $iskrit=0) {
    global $strokes;
    $ret=array("damageplus"=>0);
    foreach ($priems as $k=>$v) {
      if ($v["active"]==2 && $strokes[$k]->type==1) {
        if (@$strokes[$k]->needkrit && !$iskrit) continue;
        if (!@$strokes[$k]->actuntilmove) {
          mysql_query("update person_on set pr_active=1  WHERE id='$v[id]'");
          addlog2($this->battle_data["id"],$class,$user['id'],$k);
          $priems[$k]["active"]=1;
        }
        if (@$strokes[$k]->skiparmor) $ret["skiparmor"]=1;
        if (@$strokes[$k]->damageplus) $ret["damageplus"]+=$strokes[$k]->damageplus;
        if (@$strokes[$k]->damageplusbylevel) $ret["damageplus"]+=$user['level']*$strokes[$k]->damageplusbylevel;
        if (@$strokes[$k]->maxkrit) $ret["maxkrit"]=1;
      }
    }
    return $ret;
  }

  function checkpriems2(&$priems, $class, $user) {
    global $strokes;
    $ret=array("damageminus"=>0, "damagemult"=>1);
    foreach ($priems as $k=>$v) {
      if ($v["active"]==2 && $strokes[$k]->type==2) {
        if (@$strokes[$k]->needkrit && !$iskrit) continue;
        if (!@$strokes[$k]->actuntilmove) {
          mysql_query("update person_on set pr_active=1  WHERE id='$v[id]'");
          $priems[$k]["active"]=1;
          addlog2($this->battle_data["id"],$class,$user,$k);
        }
        if (@$strokes[$k]->damageminus) $ret["damageminus"]+=$strokes[$k]->damageminus;
        if (@$strokes[$k]->damagemult) $ret["damagemult"]*=$strokes[$k]->damagemult;
        if (@$strokes[$k]->maxdamage) $ret["maxdamage"]=$strokes[$k]->maxdamage;
      }
    }
    return $ret;
  }

  function processstrokeeffect2($res, $damage) {
    if (@$res["damageminus"]) $damage-=$res["damageminus"];
    if (@$res["damagemult"]) $damage*=$res["damagemult"];
    if (@$res["maxdamage"]) $damage=$res["maxdamage"];
    return $damage;
  }

  function makehit($who, $mf, $enemy, $attack, $defend, $num, $dontshowuv=0){
    global $user;
    if ($num==1) $hitnum="";
    else $hitnum="1";
    if ($who=="me") {
      $uvorot = $this->get_chanse($mf["he"]['uvorot']);
      $krit = $this->get_chanse($mf["me"]['krit']);
    } else {
      $uvorot = $this->get_chanse($mf["me"]['uvorot']);
      $krit = $this->get_chanse($mf["he"]['krit']);
    }

    if ($who=="me") {
      $res=$this->checkpriemsuv($this->enemypriems->priems,$this->en_class,$enemy);
      /*$ch_priem1 = mysql_query ('SELECT pr_name,id_person FROM `person_on` WHERE (`id_person` = '.$this->user['id'].' or `id_person` = '.$enemy.') and `pr_active`>1');
      while($ch_priem = mysql_fetch_array($ch_priem1)){
        if($ch_priem['pr_name']=='parry_prediction' && $ch_priem['id_person']==$this->user['id']) {
          $uve = 1; $notakt=1; mysql_query("update person_on set pr_active=1  WHERE id_person='".$ch_priem['id_person']."' and pr_name='".$ch_priem['pr_name']."'");
          addlog2($user['battle'],$this->my_class,$this->user['id'],$ch_priem['pr_name']);
          $uvorot=1;
        }
      }*/
    } else {
      $res=$this->checkpriemsuv($this->userpriems->priems,$this->my_class,$this->user['id']);
      /*$ch_priem1 = mysql_query ('SELECT pr_name,id_person FROM `person_on` WHERE `id_person` = '.$enemy.' and `pr_active`>1');
      while($ch_priem = mysql_fetch_array($ch_priem1)){
        if($ch_priem['pr_name']=='parry_prediction') {
          $uvorot = 1;
          mysql_query("update person_on set pr_active=1  WHERE id_person='".$ch_priem['id_person']."' and pr_name='".$ch_priem['pr_name']."'");addlog2($user['battle'],$this->en_class,$enemy,$ch_priem['pr_name']);
          $notakt=1;
        }
      }*/
    }
    if (@$res["uvorot"]) {
      $uvorot=1;
    }

    if (!$uvorot && !$krit) {
      if ($who=="me") {
        $res=$this->checkpriemskrit($this->userpriems->priems,$this->my_class,$this->user['id']);
        /*$ch_priem1 = mysql_query ('SELECT pr_name,id_person FROM `person_on` WHERE (`id_person` = '.$this->user['id'].') and `pr_active`=2');
        while($ch_priem = mysql_fetch_array($ch_priem1)){
          if($ch_priem['pr_name']=='krit_blindluck') {
            $krit=1;
            mysql_query("update person_on set pr_active=1  WHERE id_person='".$ch_priem['id_person']."' and pr_name='".$ch_priem['pr_name']."'");addlog2($user['battle'],$this->my_class,$ch_priem['id_person'],$ch_priem['pr_name']);
            $dontaddkrit1=1;
          }
        }*/
      } else {
        $res=$this->checkpriemskrit($this->enemypriems->priems,$this->en_class,$enemy);
        /*$ch_priem1 = mysql_query ('SELECT pr_name,id_person FROM `person_on` WHERE (`id_person` = '.$enemy.') and `pr_active`=2');
        while($ch_priem = mysql_fetch_array($ch_priem1)){
          if($ch_priem['pr_name']=='krit_blindluck') {
            mysql_query("update person_on set pr_active=1  WHERE id_person='".$ch_priem['id_person']."' and pr_name='".$ch_priem['pr_name']."'");addlog2($user['battle'],$this->en_class,$ch_priem['id_person'],$ch_priem['pr_name']);
            $dontaddkrit1=1;
            $krit=1;
          }
        }*/
      }
      if (@$res["krit"]) {
        $krit=1;
      }
    }


    if ($uvorot) {
      // я увернулся;
      if (!$dontshowuv) {
        if ($who=="me") {
          $this->add_log ($this->razmen_log("uvorot",$this->battle[$enemy][$this->user['id']][$num==1?0:3],$this->get_wep_type($this->enemyhar[$num==1?"weap":"shit"]),0,$enemy,$this->en_class,$this->user['id'],$this->my_class,0,0));
        } else {
          $this->add_log ($this->razmen_log("uvorot",$attack,$this->get_wep_type($this->user[$num==1?"weap":"shit"]),0,$this->user['id'],$this->my_class,$enemy,$this->en_class,0,0));
        }
      }
      if (@$res["counter"]) return 3;
      else return 1;
    } elseif($krit) {
      if ($who=="me") {
        // его кританули
        $minpower=$mf['me']["udar$hitnum"];
        $mf["me"]["udar$hitnum"]=$mf["me"]["kritudar$hitnum"];
        if(!$this->get_block ("he",$attack,$this->battle[$enemy][$this->user['id']][1],$enemy)) {
          $hs = 0.5; $m = 'a';
        } else {
          $hs = 1; $m = '';
          if (rand(1,100)<=$this->enemy_dress["mfparir"]) {
            $hs = 0.5; $m = 'a';
            mysql_query('UPDATE `users` SET `parry` = `parry` + 1 WHERE `id` = '.$enemy.'');
          } elseif (rand(1,100)<=$this->enemy_dress["mfshieldblock"]) {
            $hs = 0.5; $m = 'a';
          }
        }
        $minpower*=$hs;

        $res=$this->checkpriems1($this->userpriems->priems,$this->my_class,$this->user,1);
        if ($res["maxkrit"]) $mf["me"]["udar$hitnum"]=$mf["me"]["maxkritudar$hitnum"];
        if ($res["skiparmor"]) {
          echo "My skiparmor ".$mf["me"]["kritudarskiparmor$hitnum"];
          $mf["me"]["udar$hitnum"]=$mf["me"]["kritudarskiparmor$hitnum"];
        }
        if ($res["damageplus"]) $mf["me"]["udar$hitnum"]+=$res["damageplus"];

        $res=$this->checkpriems2($this->enemypriems->priems,$this->en_class,$this->enemyhar["id"]);
        $mf["me"]["udar$hitnum"]=$this->processstrokeeffect2($res, $mf["me"]["udar$hitnum"]);
        if ($res["maxdamage"]) $hs=1;

        $mf['me']["udar$hitnum"]=notzero($mf['me']["udar$hitnum"]);
        $this->damage[$this->user['id']] += ceil($mf['me']["udar$hitnum"]*$hs);
        $this->exp[$this->user['id']] += $this->solve_exp ($this->user['id'],$enemy,ceil($mf['me']["udar$hitnum"]*$hs));

        $this->enemyhar['hp']-=ceil($mf['me']["udar$hitnum"]*$hs);
        $this->add_log ($this->razmen_log("krit".$m,$attack,$this->get_wep_type($this->user['weap']),ceil($mf['me']["udar$hitnum"]*$hs),$this->user['id'],$this->my_class,$enemy,$this->en_class,$this->enemyhar['hp'],$this->enemyhar['maxhp']));
        if (!@$dontaddkrit1) mysql_query('UPDATE `users` SET `krit` = `krit` + 1, `hp3` = `hp3` + '.ceil($mf['me']["udar$hitnum"]*$hs).' WHERE `id` = '.$this->user['id'].'');
        $this->addhp2(1, ceil($mf['me']["udar$hitnum"]*$hs));
        $this->takehp(ceil($mf['me']["udar$hitnum"]*$hs), $enemy);
      } else {
        // меня кританули
        $minpower=$mf['he']["udar$hitnum"];
        $mf["he"]["udar$hitnum"]=$mf["he"]["kritudar$hitnum"];
        if(!$this->get_block ("me",$this->battle[$enemy][$this->user['id']][$num==1?0:3],$defend,$enemy)) {
          $hs = 1; $m = 'a';
        } else {
          $hs = 2; $m = '';
          if (rand(1,100)<=$this->user_dress["mfparir"]) {
            //$this->add_log ($this->razmen_log("parry",$this->battle[$enemy][$this->user['id']][0],$this->get_wep_type($this->enemyhar['weap']),0,$enemy,$this->en_class,$this->user['id'],$this->my_class,0,0));
            //$mf['he']['udar']=ceil($mf['he']['udar']/2);
            $hs = 1; $m = 'a';
            mysql_query('UPDATE `users` SET `parry` = `parry` + 1 WHERE `id` = '.$this->user['id'].'');
          } elseif (rand(1,100)<=$this->user_dress["mfshieldblock"]) {
            $hs = 1; $m = 'a';
          }
        }
        $minpower*=$hs;

        $res=$this->checkpriems1($this->enemypriems->priems,$this->en_class,$this->enemyhar,1);
        if ($res["maxkrit"]) $mf["he"]["udar$hitnum"]=$mf["he"]["maxkritudar$hitnum"];
        if ($res["skiparmor"]) {
          echo "His skiparmor";
          $mf["he"]["udar$hitnum"]=$mf["he"]["kritudarskiparmor$hitnum"];
        }
        if ($res["damageplus"]) $mf["he"]["udar$hitnum"]+=$res["damageplus"];

        $res=$this->checkpriems2($this->userpriems->priems,$this->my_class,$this->user["id"]);
        $mf["he"]["udar$hitnum"]=$this->processstrokeeffect2($res, $mf["he"]["udar$hitnum"]);
        if ($res["maxdamage"]) $hs=1;

        $mf['he']["udar$hitnum"]=notzero($mf['he']["udar$hitnum"]);
        $this->damage[$enemy] += ceil($mf['he']["udar$hitnum"]*$hs);

        $jv = ($this->user['hp']-ceil($mf['he']["udar$hitnum"]*$hs));
        $this->exp[$enemy] += $this->solve_exp ($enemy,$this->user['id'],ceil($mf['he']["udar$hitnum"]*$hs));
        $this->user['hp']-=ceil($mf['he']["udar$hitnum"]*$hs);
        $this->add_log ($this->razmen_log("krit".$m,$this->battle[$enemy][$this->user['id']][0],$this->get_wep_type($this->enemyhar['weap']),ceil($mf['he']["udar$hitnum"]*$hs),$enemy,$this->en_class,$this->user['id'],$this->my_class,$this->user['hp'],$this->user['maxhp']));
        if (!@$dontaddkrit2) mysql_query('UPDATE `users` SET `krit` = `krit` + 1, `hp3` = `hp3` + '.ceil($mf['he']["udar$hitnum"]*$hs).' WHERE `id` = '.$enemy.'');
        //$user_n = mysql_fetch_array(mysql_query("SELECT hp3, maxhp FROM `users` WHERE `id` = '{$enemy}' LIMIT 1;"));
        //$ch_n=floor($user_n['hp3']/($user_n['maxhp']/10));
        $this->addhp2(0, ceil($mf['he']["udar$hitnum"]*$hs));
        //mysql_query('UPDATE `users` SET `hp2` = '.$ch_n.'  WHERE `id` = '.$enemy.'');
        $this->takehp(ceil($mf['he']["udar$hitnum"]*$hs), $this->user['id']);
      }
      return 2;
    } else {
      if ($who=="me") {
        if($this->get_block ("he",$attack,$this->battle[$enemy][$this->user['id']][1],$enemy)) {
          // я попал куда надо
          if (rand(1,100)<=$this->enemy_dress["mfparir"]) {
            $this->add_log ($this->razmen_log("parry",$attack,$this->get_wep_type($this->user['weap']),0,$this->user['id'],$this->my_class,$enemy,$this->en_class,0,0));
            $mf['me']["udar$hitnum"]=ceil($mf['me']["udar$hitnum"]/2);
            mysql_query('UPDATE `users` SET `parry` = `parry` + 1 WHERE `id` = '.$enemy.'');
          } elseif (rand(1,100)<=$this->enemy_dress["mfshieldblock"]) {
            $this->add_log ($this->razmen_log("shieldblock",$attack,$this->get_wep_type($this->user['weap']),0,$this->user['id'],$this->my_class,$enemy,$this->en_class,0,0));
            $mf['me']["udar$hitnum"]=ceil($mf['me']["udar$hitnum"]/2);
            mysql_query('UPDATE `users` SET `parry` = `parry` + 1 WHERE `id` = '.$enemy.'');
          } else {

            $res=$this->checkpriems1($this->userpriems->priems,$this->my_class,$this->user);
            if ($res["skiparmor"]) {
              echo "My skiparmor ".$mf["me"]["udarskiparmor$hitnum"];
              $mf["me"]["udar$hitnum"]=$mf["me"]["udarskiparmor$hitnum"];
            }
            if ($res["damageplus"]) $mf["me"]["udar$hitnum"]+=$res["damageplus"];
            $res=$this->checkpriems2($this->enemypriems->priems,$this->en_class,$this->enemyhar["id"]);
            $mf["me"]["udar$hitnum"]=$this->processstrokeeffect2($res, $mf["me"]["udar$hitnum"]);

            $mf['me']["udar$hitnum"]=notzero($mf['me']["udar$hitnum"]);
            $this->damage[$this->user['id']] += ($mf['me']["udar$hitnum"]);

            $this->exp[$this->user['id']] += $this->solve_exp ($this->user['id'],$enemy,$mf['me']["udar$hitnum"]);

            $ff=$this->getforcefield($enemy);
            if ($ff["value"]>=$mf['me']["udar$hitnum"]) {
              //$this->enemyhar['hp']-=$mf['me']["udar$hitnum"];
              $this->add_log ($this->razmen_log("udartoff",$attack,$this->get_wep_type($this->user['weap']),$mf['me']["udar$hitnum"],$this->user['id'],$this->my_class,$enemy,$this->en_class,$this->enemyhar['hp'],$this->enemyhar['maxhp']));
            } else {
              $this->enemyhar['hp']=$this->enemyhar['hp']-$mf['me']["udar$hitnum"]+$ff["value"];
              $this->add_log ($this->razmen_log("udar",$attack,$this->get_wep_type($this->user['weap']),$mf['me']["udar$hitnum"]-$ff["value"],$this->user['id'],$this->my_class,$enemy,$this->en_class,$this->enemyhar['hp'],$this->enemyhar['maxhp']));
            }
            mysql_query('UPDATE `users` SET `hit` = `hit` + 1,`hp3` = `hp3` + '.$mf['me']["udar$hitnum"].'  WHERE `id` = '.$this->user['id'].'');
            //$user_n = mysql_fetch_array(mysql_query("SELECT hp3, maxhp FROM `users` WHERE `id` = '{$this->user['id']}' LIMIT 1;"));
            //$ch_n=floor($user_n['hp3']/($user_n['maxhp']/10));
            //mysql_query('UPDATE `users` SET `hp2` = '.$ch_n.'  WHERE `id` = '.$this->user['id'].'');
            $this->addhp2(1, ceil($mf['me']["udar$hitnum"]));
            $this->takehp($mf['me']["udar$hitnum"], $enemy);
          }
        } else {
          // я мазила
          $this->add_log ($this->razmen_log("block",$attack,$this->get_wep_type($this->user['weap']),0,$this->user['id'],$this->my_class,$enemy,$this->en_class,0,0));
          mysql_query('UPDATE `users` SET `block2` = `block2` + 1 WHERE `id` = '.$enemy.'');
        }
      } else {
        if($this->get_block ("me",$this->battle[$enemy][$this->user['id']][$num==1?0:3],$defend,$enemy)) {
          // противник попал куда надо
          //проверяем использование према защиты
          if($this->get_block ("me",$this->battle[$enemy][$this->user['id']][$num==1?0:3],$defend,$enemy)) {

            //////////////////////////////////
            if (mt_rand(1,100)<=$this->user_dress["mfparir"]) {
              $this->add_log ($this->razmen_log("parry",$this->battle[$enemy][$this->user['id']][0],$this->get_wep_type($this->enemyhar['weap']),0,$enemy,$this->en_class,$this->user['id'],$this->my_class,0,0));
              $mf['he']["udar$hitnum"]=ceil($mf['he']["udar$hitnum"]/2);
              mysql_query('UPDATE `users` SET `parry` = `parry` + 1 WHERE `id` = '.$this->user['id'].'');
            } elseif (mt_rand(1,100)<=$this->user_dress["mfshieldblock"]) {
              $this->add_log ($this->razmen_log("shieldblock",$this->battle[$enemy][$this->user['id']][0],$this->get_wep_type($this->enemyhar['weap']),0,$enemy,$this->en_class,$this->user['id'],$this->my_class,0,0));
              $mf['he']["udar$hitnum"]=ceil($mf['he']["udar$hitnum"]/2);
              mysql_query('UPDATE `users` SET `block2` = `block2` + 1 WHERE `id` = '.$this->user['id'].'');
            } else {
              $res=$this->checkpriems1($this->enemypriems->priems,$this->en_class,$this->enemyhar);
              if ($res["skiparmor"]) {
                echo "His skiparmor";
                $mf["he"]["udar$hitnum"]=$mf["he"]["udarskiparmor$hitnum"];
              }
              if ($res["damageplus"]) $mf["he"]["udar$hitnum"]+=$res["damageplus"];
              $res=$this->checkpriems2($this->userpriems->priems,$this->my_class,$this->user["id"]);
              $mf["he"]["udar$hitnum"]=$this->processstrokeeffect2($res, $mf["he"]["udar$hitnum"]);

              $mf['he']["udar$hitnum"]=notzero($mf['he']["udar$hitnum"]);
              $this->damage[$enemy] += ($mf['he']["udar$hitnum"]);
              $jv = ($this->user['hp']-$mf['he']["udar$hitnum"]);
              $this->exp[$enemy] += $this->solve_exp ($enemy,$this->user['id'],$mf['he']["udar$hitnum"]);

              $ff=$this->getforcefield($this->user['id']);
              if ($ff["value"]>=$mf['he']["udar$hitnum"]) {
                $this->add_log ($this->razmen_log("udartoff",$this->battle[$enemy][$this->user['id']][0],$this->get_wep_type($this->enemyhar['weap']),$mf['he']["udar$hitnum"],$enemy,$this->en_class,$this->user['id'],$this->my_class,$this->user['hp'],$this->user['maxhp']));
              } else {
                $this->user['hp']=$this->user['hp']-$mf['he']["udar$hitnum"]+$ff["value"];
                $this->add_log ($this->razmen_log("udar",$this->battle[$enemy][$this->user['id']][0],$this->get_wep_type($this->enemyhar['weap']),$mf['he']["udar$hitnum"]-$ff["value"],$enemy,$this->en_class,$this->user['id'],$this->my_class,$this->user['hp'],$this->user['maxhp']));
              }
              mysql_query('UPDATE `users` SET `hit` = `hit` + 1,`hp3` = `hp3` + '.$mf['he']["udar$hitnum"].'  WHERE `id` = '.$enemy.'');

              //$user_n = mysql_fetch_array(mysql_query("SELECT hp3, maxhp FROM `users` WHERE `id` = '{$enemy}' LIMIT 1;"));
              //$ch_n=floor($user_n['hp3']/($user_n['maxhp']/10));
              //mysql_query('UPDATE `users` SET `hp2` = '.$ch_n.'  WHERE `id` = '.$enemy.'');
              $this->addhp2(0, ceil($mf['he']["udar$hitnum"]));

              $this->takehp($mf['he']["udar$hitnum"], $this->user['id']);
            }
          }
        } else {
          // противник мазила
          $this->add_log ($this->razmen_log("block",$this->battle[$enemy][$this->user['id']][$num==1?0:3],$this->get_wep_type($this->enemyhar[$num==1?'weap':'shit']),0,$enemy,$this->en_class,$this->user['id'],$this->my_class,0,0));
          mysql_query('UPDATE `users` SET `block2` = `block2` + 1 WHERE `id` = '.$this->user['id'].'');
        }
      }
      return 0;
    }
  }

/*-------------------------------------------------------------------
 создание класса и сбор основной инфы
--------------------------------------------------------------------*/
  function fbattle ($battle_id) {
      global $mysql, $user, $_POST, $textp;

      // соединяем мускуль и юзера
      $this->mysql = $mysql;
      $this->user = $user;
      // перебираем варианты
      if ($battle_id > 0) {
          // ставим статус битвы на "есть битва"
          $this->status = 1;
          // вставляем драчующихся
          $this->battle_data = mysql_fetch_array(mysql_query ('SELECT * FROM `battle` WHERE `id` = '.$battle_id.' LIMIT 1;'));
           //echo "<pre>";
           //print_r($this->battle_data);
          if($this->battle_data['room']<=0){mysql_query('UPDATE `battle` SET `room` ='.$user['room'].'  WHERE `id` = '.$battle_id.';');}
          $this->sort_teams();
          // получили дамагу
          $this->damage = unserialize($this->battle_data['damage']);
          // кто драчуется?
          $this->battle = unserialize($this->battle_data['teams']);
          // получаем экспу
          $this->exp = unserialize($this->battle_data['exp']);
          // таймі
          $this->to1 = $this->battle_data['to1'];
          $this->to2 = $this->battle_data['to2'];

          // ============СИСТЕМА БОТОВ=================
          $bots = mysql_query ('SELECT * FROM `bots` WHERE `battle` = '.$battle_id.' AND `hp` > 0;');
          while ($bot = mysql_fetch_array($bots)) {
            $this->bots[$bot['id']] = $bot;
            // листаем противников, и выставляем удары для живых персонажей
            if($bot['hp'] > 0) {
              foreach ($this->battle[$bot['id']] as $k => $v) {
                if($this->battle[$bot['id']][$k][0] == 0 && $k < 10000000) {
                  mt_srand(microtime(true));
                  //$chkwear_bot1 = mysql_query('SELECT id FROM `inventory` WHERE (`type` = 3 AND `dressed` = 1) AND `owner` = '.$bot['prototype'].';');
                  //while ($chkwear_bot = mysql_fetch_array($chkwear_bot1)) {
                  //  $sumwear_bot++;
                  //}
                  $sumwear_bot=mqfa1('SELECT count(id) FROM `inventory` WHERE (`type` = 3 AND `dressed` = 1) AND `owner` = '.$bot['prototype']);
                  if($sumwear_bot==2){$udar2=rand(1,5);}else{$udar2=0;}
                  $this->battle[$bot['id']][$k] = array(rand(1,5),rand(1,5),time(),$udar2);
                  $this->battle[$k][$bot['id']] = array(0,0,time(),0);
                }

                if($this->battle[$k][$bot['id']][0] == 0 && $k < 10000000) {
                  if(in_array($user['id'],array_keys($this->battle[$bot['id']]))) {
                  //echo "111";
                  // если я противник бота
                  if ($this->my_class=='B2') {
                    if($this->to2 <= $this->to1) {
                    $endr= ((time()-$this->to2) > $this->battle_data['timeout']*60);
                  }
                } else {
                  if($this->to2 >= $this->to1) {
                    $endr= ((time()-$this->to1) > $this->battle_data['timeout']*60);
                  }
                }

                if($endr && !$uje) {
                  $uje = true;
                  // если сдул - заканчиваем бой
                  $this->add_log("<span class=date>".date("H:i")."</span> Бой закончен по таймауту.<BR>");
                  //$this->write_log ();
                  foreach ($this->battle[$bot['id']] as $k => $v) {
                    if($k > _BOTSEPARATOR_) {
                      $bots = mysql_fetch_array(mysql_query ('SELECT `hp` FROM `bots` WHERE `id` = '.$k.' LIMIT 1;'));
                      $us['hp'] = $bots['hp'];
                    } else {
                      $us = mysql_fetch_array(mysql_query('SELECT `hp` FROM `users` WHERE `id` = '.$k.' LIMIT 1;'));
                    }
                    if($us && (int)$us['hp']>0) {
                      $tr = settravma($k,0,86400,1);
                      $this->add_log('<span class=date>'.date("H:i").'</span> '.nick7($k).' получил повреждение: <font color=red>'.$tr.'</font><BR>');
                    }
                  }
                  //$this->write_log ();
                  foreach ($this->battle[$bot['id']] as $k => $v) {
                    mysql_query('UPDATE users SET `hp` =0, `fullhptime` = '.time().' WHERE `id` = '.$k.';');
                    mysql_query('UPDATE users SET `mana` =0, `fullmptime` = '.time().' WHERE `id` = '.$k.';');
                  }
                }
              }
            }
          }
          $this->update_battle ();
        }
      }
      //==============================================
      $this->user_hasshit=checkshit($user['id']);
      if(@$_POST['enemy'] > 0) {
        // ударяемся
        $this->razmen_init ($_POST['enemy'],$_POST['attack'],$_POST['defend'],@$_POST['attack1']);
        if($user['room']!=403 && $user['room']!=20){include "astral.php";}
        if (!BATTLEDEBUG) header ("Location:fbattle.php?fd=$_POST[enemy]");
      } else {
        $this->sort_teams();
        $this->fast_death();

        // вібираем вражину
        $this->enemy = (int)$this->select_enemy();
        if($this->enemy > 0) {
          // табличка удара-блока
          $this->return = 1;
        } else {
          //проверяем тайм
          if ($this->get_timeout() && $this->user['hp'] > 0) {
            // табличка тайма
            $this->return = 3;
          } else {
            // ожидаем хода...
            $this->return = 2;
          }
        }
      }
      if (@$_POST['victory_time_out2']) {
        $this->end_draft();
      }
      if (@$_POST['victory_time_out']) {
        $this->end_gora();
      }
      if ($this->battle_end()) {
        $this->return = 2;
      }

      $this->write_log(); // пишем лог
      $this->write_debug(); // пишем лог
      return @$this->return;
    } else {
      // ставим статус битвы на "нет битвы"
      $this->status = 0;
      //header ("Location:main.php");
      //die();
      //$this->return = 5;
      //return $this->return;
    }
  }
/*-------------------------------------------------------------------
  проверка и выставление конца боя
--------------------------------------------------------------------*/

function battle_end () {
  if($this->battle_data) {
    $ss = @array_keys($this->battle);

    $t1life = 0;
    $t2life = 0;
    // проверяем живность команд
    foreach ($this->t1 as $k => $v) {
      if (in_array($v,array_keys($this->battle))) {
        $t1life++;
      }
    }
    foreach ($this->t2 as $k => $v) {
      if (in_array($v,array_keys($this->battle))) {
        $t2life++;
      }
    }
    if($t2life == 0 OR $t1life == 0) {
      $charge = mysql_fetch_array(mysql_query ('SELECT `win` FROM `battle` WHERE `id` = '.$this->battle_data['id'].' LIMIT 1;'));
    }
    if(($t2life == 0 OR $t1life == 0) && ($charge[0] == 3 || $charge[0] == 9)) {
      // ============================= конец боя ==========================
      // оцениваем игроков
      //$cost1 =0; $cost2 =0; $kula4ka = 0; $t2c =0; $t1c =0; $lvs1=0; $lvs2=0; $bxp = 0;
      foreach ($this->t1 as $k => $v) {
        /*if($v > _BOTSEPARATOR_) {
          $bots = mysql_fetch_array(mysql_query ('SELECT * FROM `bots` WHERE `id` = '.$v.' LIMIT 1;'));
          $gamer = mysql_fetch_array(mysql_query("select 1+IFNULL((select SUM(cost) FROM inventory WHERE owner = users.id AND dressed=1),0), `align`,`level` FROM users WHERE id = ".$bots['prototype']." LIMIT 1;"));
          $kulak = mysql_fetch_array(mysql_query("select SUM(cost) FROM inventory WHERE owner = ".$bots['prototype']." AND dressed=1 LIMIT 1;"));
        } else {
          $gamer = mysql_fetch_array(mysql_query("select 1+IFNULL((select SUM(cost) FROM inventory WHERE owner = users.id AND dressed=1),0), `align`,`level` FROM users WHERE id = ".$v." LIMIT 1;"));
          $kulak = mysql_fetch_array(mysql_query("select SUM(cost) FROM inventory WHERE owner = ".$v." AND dressed=1 LIMIT 1;"));
        }  */
        $nks1[] = nick7($v);
        $nks1hist[] = nick3($v);
        /*$td1 += $this->damage[$v];

        $bxp += $baseexp[$gamer[2]];
        $bxp1 += $baseexp[$gamer[2]];
        //$exp1 += $this->damage[$v];

        $cost1 += $gamer[0];
        $kula4ka += $kulak[0];
        $al1 = $gamer[1];
        $t1c ++;
        $lvs1 += $gamer[2];  */
      }

      //  $lvs1 = $lvs1/$t1c+1;
      foreach ($this->t2 as $k => $v) {
        /*if($v > _BOTSEPARATOR_) {
          $bots = mysql_fetch_array(mysql_query ('SELECT * FROM `bots` WHERE `id` = '.$v.' LIMIT 1;'));
          $gamer = mysql_fetch_array(mysql_query("select 1+IFNULL((select SUM(cost) FROM inventory WHERE owner = users.id AND dressed=1),0), `align`,`level` FROM users WHERE id = ".$bots['prototype']." LIMIT 1;"));
          $kulak = mysql_fetch_array(mysql_query("select SUM(cost) FROM inventory WHERE owner = ".$bots['prototype']." AND dressed=1 LIMIT 1;"));
        } else {
          $gamer = mysql_fetch_array(mysql_query("select 1+IFNULL((select SUM(cost) FROM inventory WHERE owner = users.id AND dressed=1),0), `align`,`level` FROM users WHERE id = ".$v." LIMIT 1;"));
          $kulak = mysql_fetch_array(mysql_query("select SUM(cost) FROM inventory WHERE owner = ".$v." AND dressed=1 LIMIT 1;"));
        }    */
        $nks2[] = nick7($v);
        $nks2hist[] = nick3($v);
        /*$td2 += $this->damage[$v];

        $bxp += $baseexp[$gamer[2]];
        $bxp2 += $baseexp[$gamer[2]];
        //$exp2 += $this->damage[$v];

        $cost2 += $gamer[0];
        $kula4ka += $kulak[0];
        $al2 = $gamer[1];
        $lvs2 += $gamer[2];
        $t2c++;  */
      }
      /*$lvs2 = $lvs2/$t2c+1;
      //echo mysql_error();
      //echo $cost1,' ',$cost2;
      if(($t1c==1) && ($t2c==1)) {
        $one2one=true;
        // одинаковые ли склонности?
        if ($al1==3 && ($al2 > 1 && $al2 < 2)) { $dual = true; }
        if ($al2==3 && ($al1 > 1 && $al1 < 2)) { $dual = true; }
      } else {
        $one2one=false;
      }
      */
      // тима победителей

      $maxdamage=0;
      $maxdamageuser=0;
      if(in_array($ss[0],$this->t1)) {
        mysql_query('UPDATE `battle` SET `win` = 1 WHERE `id` = '.$this->user['battle'].' ;');
        if ($this->battle_data["quest"]==2) mq("update users set bot=0 where id=3313");
        mq("DELETE FROM`effects` WHERE `owner` = '744' and `type` = '10'");
        $flag = 1;
        foreach ($this->t1 as $k => $v) {
          if ($this->battle_data["quest"]) {
            addqueststep($v, $this->battle_data["quest"], 1/count($this->t1));
            if ($this->damage[$v]>$maxdamage) {
              $maxdamage=$this->damage[$v];
              $maxdamageuser=$v;
            }
          }
          $this->t1[$k] = nick5($v," ");
          $this->exp[$v] = round($this->exp[$v]);
          $warrior=mqfa("select * from users where id='$v'");
          ///////////////////////при победе = для подземки/////////////////////////////////////
          $gess = mysql_query ('SELECT * FROM `labirint` WHERE `user_id` = '.$this->user['id'].'');
          if($hokke = mysql_fetch_array($gess)) {
            $glav_id = $hokke["glav_id"];
            $glava = $hokke["glava"];
            $nm = $hokke["boi"];
            /////////////////////////////////////////////////////////////
            $DR = mysql_fetch_array(mysql_query("SELECT * FROM `canal_bot` WHERE `glava`='$glava' and `boi`= '$nm'"));
            if($DR) {
              $bot = $DR["bot"];
              $nomer = $DR["nomer"];
              ////////////////////////////////////////////////////////////////
              $shans1 = rand(0,100);
              $shans2 = rand(0,100);
              $shans3 = rand(0,100);
              ////////////////////////////////////////////////////////////////
              $est=0;$d1=0;$d2=0;
              if($bot=='1' or $bot=='2' or $bot=='3' or $bot=='1.1' or $bot=='1.2' or $bot=='1.3' or $bot=='2.2' or $bot=='2.3' or $bot=='3.3' or $bot=='1.1.1' or $bot=='1.1.2' or $bot=='1.1.2' or $bot=='1.2.2' or $bot=='1.3.2' or $bot=='1.3.3' or $bot=='2.2.2' or $bot=='2.2.3' or $bot=='2.3.3' or $bot=='3.3.3' or $bot=='1.3.2'){
                if($bot=='1' and $bot=='2' and $bot=='3')
                {if($shans1<'50'){$d1=1;} }
                if($bot=='1.1' or $shans2<'50' and $bot=='1.2' or $shans2<'50' and $bot=='1.3' or $shans2<'50' and $bot=='2.2' or $shans2<'50' and $bot=='2.3' or $shans2<'50' and $bot=='3.3')
                {if($shans1<'50'){$d1=1;}if($shans2<'50'){$d2=1;}}
                if($bot=='1.1.1' or $shans3<'50' and $bot=='1.1.2' or $shans3<'50' and $bot=='1.1.2' or $shans3<'50' and $bot=='1.2.2' or $shans3<'50' and $bot=='1.3.2' or $shans3<'50' and $bot=='1.3.3' or $shans3<'50' and $bot=='2.2.2' or $shans3<'50' and $bot=='2.2.3' or $shans3<'50' and $bot=='2.3.3' or $shans3<'50' and $bot=='3.3.3' or $shans3<'50' and $bot=='1.3.2')
                {if($shans1<'50'){$d1=1;}if($shans2<'50'){$d2=1;}if($shans3<'50'){$d3=1;}}
                $est = $d1+$d2+$d3+500;
                if($est>'500'){mysql_query("UPDATE podzem3 SET n$nomer='$est' WHERE glava='$glava' and name='".$hokke["name"]."'");}
                else{mysql_query("UPDATE podzem3 SET n$nomer='' WHERE glava='$glava' and name='".$hokke["name"]."'");}
              }

              if($bot=='4' or $bot=='5' or $bot=='6' or $bot=='8'){
              if($shans1<'99'){$est=504;}
              if($est>'500'){mysql_query("UPDATE podzem3 SET n$nomer='$est' WHERE glava='$glava' and name='".$hokke["name"]."'");}
              else{mysql_query("UPDATE podzem3 SET n$nomer='' WHERE glava='$glava' and name='".$hokke["name"]."'");}
              }

              if($bot=='7'){
              if($shans1<'99'){$est=510;}
              if($est=='510'){mysql_query("UPDATE podzem3 SET n$nomer='$est' WHERE glava='$glava' and name='".$hokke["name"]."'");}
              else{mysql_query("UPDATE podzem3 SET n$nomer='' WHERE glava='$glava' and name='".$hokke["name"]."'");}
              if($this->user['medal2']=='0'){mysql_query("UPDATE `users` SET `medal2`='1' WHERE `id`=".$this->user['id']."");}
              }
              //////////////////////////2 etaz//////////////////////////////

              if($bot=='9' or $bot=='11' or $bot=='9.9' or $bot=='11.11' or $bot=='9.9.9' or $bot=='11.11.11'){

              if($bot=='9' or $bot=='11'){if($shans1<'99'){$d1=1;} }
              if($bot=='9.9' or $bot=='11.11'){if($shans1<'99'){$d1=1;} if($shans2<'99'){$d2=1;} }
              if($bot=='9.9.9' or $bot=='11.11.11'){if($shans1<'99'){$d1=1;} if($shans2<'99'){$d2=1;} if($shans3<'99'){$d3=1;} }
              $est = $d1+$d2+$d3+600;
              if($est>'600'){mysql_query("UPDATE podzem3 SET n$nomer='$est' WHERE glava='$glava' and name='".$hokke["name"]."'");}
              else{mysql_query("UPDATE podzem3 SET n$nomer='' WHERE glava='$glava' and name='".$hokke["name"]."'");}

              }//////////Чистая гайка/////////////////
              if($bot=='13' or $bot=='13.13' or $bot=='13.13.13'){

              if($bot=='13'){if($shans1<'99'){$d1=1;} }
              if($bot=='13.13'){if($shans1<'99'){$d1=1;} if($shans2<'99'){$d2=1;} }
              if($bot=='13.13.13'){if($shans1<'99'){$d1=1;} if($shans2<'99'){$d2=1;} if($shans3<'99'){$d3=1;} }
              $est = $d1+$d2+$d3+603;
              if($est>'603'){mysql_query("UPDATE podzem3 SET n$nomer='$est' WHERE glava='$glava' and name='".$hokke["name"]."'");}
              else{mysql_query("UPDATE podzem3 SET n$nomer='' WHERE glava='$glava' and name='".$hokke["name"]."'");}

              }//////////Гайка с резьбой/////////////////
              if($bot=='10' or $bot=='10.10' or $bot=='10.10.10'){

              if($bot=='10'){if($shans1<'99'){$d1=1;} }
              if($bot=='10.10'){if($shans1<'99'){$d1=1;} if($shans2<'99'){$d2=1;} }
              if($bot=='10.10.10'){if($shans1<'99'){$d1=1;} if($shans2<'99'){$d2=1;} if($shans3<'99'){$d3=1;} }
              $est = $d1+$d2+$d3+606;
              if($est>'606'){mysql_query("UPDATE podzem3 SET n$nomer='$est' WHERE glava='$glava' and name='".$hokke["name"]."'");}
              else{mysql_query("UPDATE podzem3 SET n$nomer='' WHERE glava='$glava' and name='".$hokke["name"]."'");}

              }//////////длинный болт/////////////////
              if($bot=='12' or $bot=='12.12' or $bot=='12.12.12' or $bot=='15' or $bot=='15.15' or $bot=='15.15.15' or $bot=='16' or $bot=='16.16' or $bot=='16.16.16'){

              if($bot=='12' or $bot=='15' or $bot=='16'){if($shans1<'99'){$d1=1;} }
              if($bot=='12.12' or $bot=='15.15' or $bot=='16.16'){if($shans1<'99'){$d1=1;} if($shans2<'99'){$d2=1;} }
              if($bot=='12.12.12' or $bot=='15.15.15' or $bot=='16.16.16'){if($shans1<'99'){$d1=1;} if($shans2<'99'){$d2=1;} if($shans3<'99'){$d3=1;} }
              $est = $d1+$d2+$d3+609;
              if($est>'609'){mysql_query("UPDATE podzem3 SET n$nomer='$est' WHERE glava='$glava' and name='".$hokke["name"]."'");}
              else{mysql_query("UPDATE podzem3 SET n$nomer='' WHERE glava='$glava' and name='".$hokke["name"]."'");}

              }//////////Нужный болт/////////////////
              if($bot=='14' or $bot=='14.14' or $bot=='14.14.14' or $bot=='17' or $bot=='17.17' or $bot=='17.17.17' or $bot=='18' or $bot=='18.18' or $bot=='18.18.18'){

              if($bot=='14' or $bot=='17' or $bot=='18'){if($shans1<'99'){$d1=1;} }
              if($bot=='14.14' or $bot=='17.17' or $bot=='18.18'){if($shans1<'99'){$d1=1;} if($shans2<'99'){$d2=1;} }
              if($bot=='14.14.14' or $bot=='17.17.17' or $bot=='18.18.18'){if($shans1<'99'){$d1=1;} if($shans2<'99'){$d2=1;} if($shans3<'99'){$d3=1;} }
              $est = $d1+$d2+$d3+612;
              if($est>'612'){mysql_query("UPDATE podzem3 SET n$nomer='$est' WHERE glava='$glava' and name='".$hokke["name"]."'");}
              else{mysql_query("UPDATE podzem3 SET n$nomer='' WHERE glava='$glava' and name='".$hokke["name"]."'");}

              }//////////Рабочий винтель/////////////////
            }
            mysql_query("UPDATE `labirint` SET `boi`='0' WHERE `user_id`=".$this->user['id']."");
            mysql_query("DELETE FROM `canal_bot` WHERE `nomer`='$nomer' and `glava`='$glava' and `boi`='$nm'");
          }
          //////////////////////////////////////////////////////////////////

          if($warrior['align']==4) {
            $proc_exp=floor(proc_exp/2);
          } else {
            $proc_exp=proc_exp;
          }
          if ($warrior["zver_id"]) $zv=mysql_fetch_array(mysql_query("SELECT `prototype`,`id` FROM `bots` WHERE `prototype` = '".$warrior['zver_id']."' and `battle` = ".$warrior['battle'].""));
          else $zv=0;

          if($zv) {
            $proc_exp=floor(($proc_exp/3)*2);
            $id_bota = $zv['id'];
            //$esp = $this->damage[$id_bota];
            $esp = floor($this->exp[$warrior['id']]/3);
            if($esp<0){$esp='0';}
            if (!@$animalexp[$warrior['id']]) {
              $esp=checkanimalexp($warrior['zver_id'], $esp, $warrior['battle']);
              if ($esp) {
                mysql_query('UPDATE `users` SET `exp` = `exp`+'.$esp.',`sitost` = `sitost`-3 WHERE id = '.$warrior['zver_id'].';');
                addchp ('<font color=red>Внимание!</font> Ваш зверь получил <b>'.$esp.'</b> опыта.   ','{[]}'.nick7($warrior['id']).'{[]}');
              }
            }
            $animalexp[$warrior['id']]=1;
          } else $animalexp="";

          if ($warrior['klan']) {
            $klanexp1 = floor($this->exp[$v]/5);
            addchp ('<font color=red>Внимание!</font> Бой закончен. Всего вами нанесено урона: <b>'.$this->damage[$v].' HP</b>. Получено кланового опыта: <b>'.$klanexp1.'</b>.  Получено опыта: <b>'.$this->exp[$v].'</b> ('.$proc_exp.'%).','{[]}'.nick7($v).'{[]}');
            mysql_query('UPDATE `users` SET `hp2` = 0,`hp3` = 0,`hit` = 0,`s_duh` = 0,`krit` = 0,`counter` = 0,`block2` = 0,`parry` = 0,`udar` = 0  WHERE `id` = '.$v.'');
            mysql_query("DELETE FROM `person_on` WHERE `id_person`='".$v."'");
            mysql_query("UPDATE `effects` SET `isp` = '0' WHERE `owner` = '".$v."'");
          } else {
            addchp ('<font color=red>Внимание!</font> Бой закончен. Всего вами нанесено урона: <b>'.$this->damage[$v].' HP</b>. Получено опыта: <b>'.$this->exp[$v].'</b> ('.$proc_exp.'%).','{[]}'.nick7($v).'{[]}');
            mysql_query('UPDATE `users` SET `hp2` = 0,`hp3` = 0,`hit` = 0,`s_duh` = 0,`krit` = 0,`counter` = 0,`block2` = 0,`parry` = 0,`udar` = 0  WHERE `id` = '.$v.'');
            mysql_query("DELETE FROM `person_on` WHERE `id_person`='".$v."'");
            mysql_query("UPDATE `effects` SET `isp` = '0' WHERE `owner` = '".$v."'");
          }

          $vrag_w = mysql_fetch_array(mysql_query("SELECT `name` FROM `bots` WHERE  `id` = ".$v." LIMIT 1 ;"));
          if($vrag_w['name']=="Общий Враг"){
            mysql_query('UPDATE users SET `win`=`win` +1 WHERE `id` = 99;');
          }
          mysql_query('UPDATE users SET `win`=`win` +1, `exp` = `exp`+'.$this->exp[$v].', `fullhptime` = '.time().', `fullmptime` = '.time().',`udar` = "0" WHERE `id` = '.$v.';');
          //mysql_query("UPDATE clans SET `clanexp`=`clanexp`+10 WHERE `name` =  '{$this->user['klan']}';");
          if ($warrior['klan']) {
            $klanexp = $this->exp[$warrior['id']]/5;
            mysql_query("UPDATE clans SET `clanexp`=`clanexp`+'{$klanexp}' WHERE `short` =  '{$warrior['klan']}';");
          }
        }
        $winers .= implode("</B>, <B>",$this->t1);
        $lomka=$this->t2;
      } elseif(in_array($ss[0],$this->t2) && $this->battle_data["quest"]!=2) {
        mysql_query('UPDATE `battle` SET `win` = 2 WHERE `id` = '.$this->user['battle'].' ;');
        $flag = 2;
        $maxdamage=0;
        $maxdamageuser=0;
        foreach ($this->t2 as $k => $v) {
          $warrior=mqfa("select * from users where id='$v'");
          if ($this->battle_data["quest"]) {
            addqueststep($v, $this->battle_data["quest"], 1/count($this->t2));
            if ($this->damage[$v]>$maxdamage) {
              $maxdamage=$this->damage[$v];
              $maxdamageuser=$v;
            }
          }
          mysql_query('UPDATE `battle` SET `win` = 2 WHERE `id` = '.$warrior['battle'].' ;');
          $this->t2[$k] = nick5($v,"");
          $this->exp[$v] = round($this->exp[$v]);
          ////////////////при пройгрыше = для подземки///////////////////
          $sd=mysql_query("SELECT glav_id,boi,glava,dead FROM `labirint` WHERE `user_id`=".$this->user['id']." and `di`='0'");
          if($dd=mysql_fetch_array($sd)) {
            $glav_id = $dd["glav_id"];
            $glava = $dd["glava"];
            $nm = $dd["boi"];
            mysql_query("DELETE FROM `canal_bot` WHERE `boi`='$nm' and `glava`='$glava'");
            if($dd["dead"]=='0'){$d = 1;}
            if($dd["dead"]=='1'){$d = 2;}
            if($dd["dead"]=='2'){$d = 3;}
            mysql_query("UPDATE `labirint` SET `location`='16',`vector`='0',`dead`='$d',`t`='226',`l`='454',`boi`='0',`di`='1',`name`='Канализация 1 этаж' WHERE `user_id`=".$this->user['id']."");
          }
          ///////////////////////////////////
          if($warrior['align']==4){$proc_exp=floor(proc_exp/2);}else{$proc_exp=proc_exp;}
          if ($warrior['zver_id']) $zv=mysql_fetch_array(mysql_query("SELECT `prototype`,`id` FROM `bots` WHERE `prototype` = '".$warrior['zver_id']."' and `battle` = ".$warrior['battle'].""));
          else $zv=0;
          if($zv){
            $proc_exp=floor(($proc_exp/3)*2);
            $id_bota = $zv['id'];
            //$esp = $this->damage[$id_bota];
            $esp = floor($this->exp[$v]/3);
            if($esp<0){$esp='0';}
            if (!@$animalexp[$warrior['id']]) {
              $esp=checkanimalexp($warrior['zver_id'], $esp, $warrior['battle']);
              $animalexp[$warrior['id']]=1;
              mysql_query('UPDATE `users` SET `exp` = `exp`+'.$esp.',`sitost` = `sitost`-3 WHERE `id` = '.$warrior['zver_id'].';');
              addchp ('<font color=red>Внимание!</font> Ваш зверь получил <b>'.$esp.'</b> опыта.   ','{[]}'.nick7($warrior['id']).'{[]}');
            }
          }
          if ($warrior['klan']) {
            $klanexp1 = floor($this->exp[$v]/5);
            addchp ('<font color=red>Внимание!</font> Бой закончен. Всего вами нанесено урона: <b>'.(int)$this->damage[$v].' HP</b>. Получено кланового опыта: <b>'.$klanexp1.'</b>. Получено опыта: <b>'.$this->exp[$v].'</b> ('.$proc_exp.'%).','{[]}'.nick7($v).'{[]}');
          } else {
            addchp ('<font color=red>Внимание!</font> Бой закончен. Всего вами нанесено урона: <b>'.(int)$this->damage[$v].' HP</b>. Получено опыта: <b>'.$this->exp[$v].'</b> ('.$proc_exp.'%).  ','{[]}'.nick7 ($v).'{[]}');
          }
          mysql_query('UPDATE `users` SET `hp2` = 0,`hp3` = 0,`hit` = 0,`s_duh` = 0,`krit` = 0,`counter` = 0,`block2` = 0,`parry` = 0,`udar` = 0  WHERE `id` = '.$v.'');
          mysql_query("DELETE FROM `person_on` WHERE `id_person`='".$v."'");
          mysql_query("UPDATE `effects` SET `isp` = '0' WHERE `owner` = '".$v."'");
          $vrag_w = mysql_fetch_array(mysql_query("SELECT `name` FROM `bots` WHERE  `id` = ".$v." LIMIT 1 ;"));
          if($vrag_w['name']=="Общий Враг"){mysql_query('UPDATE users SET `win`=`win` +1 WHERE `id` = 99;');}
          mysql_query('UPDATE users SET `win`=`win`+1, `exp` = `exp`+'.$this->exp[$v].', `fullhptime` = '.time().', `fullmptime` = '.time().',`udar` = "0" WHERE `id` = '.$v.';');
          if ($warrior["klan"]) {
            $klanexp = $this->exp[$warrior['id']]/5;
            mysql_query("UPDATE clans SET `clanexp`=`clanexp`+'{$klanexp}' WHERE `short` =  '{$warrior['klan']}';");
          }
        }
        $winers .= implode("</B>, <B>",$this->t2);
        $lomka=$this->t1;
      } elseif ($this->battle_data["quest"]!=2) mysql_query("UPDATE battle SET `win` = 0 WHERE `id` = {$warrior['battle']}");
      if ($this->battle_data["quest"]==4 && $maxdamageuser) {
        include_once("questfuncs.php");
        takeitem(11, 1, 0, $maxdamageuser);
        addchp ('Феерверк получил персонаж '.mqfa1("select login from users where id='$maxdamageuser'"),"Комментатор", 46);
      }
      //if ($this->battle_data["quest"]==2 && !@$flag) {
        //return;
      //}
      mysql_query("UPDATE `users`, `bots` SET `users`.`fullhptime` = ".(time()+300).",`users`.`hp` = `bots`.`hp` WHERE `users`.id=83 AND `bots`.prototype=83;");


      // ===================ломаем шмот=============
      if ($lomka) {
        foreach ($lomka as $k => $v) {
          if (rand(1,3)==1){
             $us = mysql_query('UPDATE `inventory` SET `duration`=`duration`+1 WHERE `type` <> 25 AND `dressed` = 1 AND `owner` = \''.$v.'\';');
           }
           $this->exp[$v] = 0;
           addchp ('<font color=red>Внимание!</font> Бой закончен. Всего вами нанесено урона: <b>'.(int)$this->damage[$v].' HP</b>. Получено опыта: <b>0</b>.   ', '{[]}'.nick7 ($v).'{[]}');
           mysql_query('UPDATE `users` SET `hp2` = 0,`hp3` = 0,`hit` = 0,`s_duh` = 0,`krit` = 0,`counter` = 0,`block2` = 0,`parry` = 0 ,`udar` = 0 WHERE `id` = '.$v.'');
           mysql_query("DELETE FROM `person_on` WHERE `id_person`='".$v."'");
           mysql_query("UPDATE `effects` SET `isp` = '0' WHERE `owner` = '".$v."'");
           $vrag_w = mysql_fetch_array(mysql_query("SELECT `name` FROM `bots` WHERE  `id` = ".$v." LIMIT 1 ;"));
           if($vrag_w['name']=="Общий Враг"){mysql_query('UPDATE users SET `lose`=`lose` +1 WHERE `id` = 99;');}
           mysql_query('UPDATE `users` SET `lose`=`lose` +1 WHERE `id` = \''.$v.'\';');
           // если поединок был кровавым - еще и ставм травмы
         }
       }

       foreach ($this->t1 as $k => $v) {
         $us = mysql_query('SELECT duration, maxdur, name FROM `inventory` WHERE `type` <> 25 AND `dressed` = 1 AND `owner` = \''.$v.'\';');
         while ($rrow=mysql_fetch_row($us)) {
           if (($rrow[1]-$rrow[0])==1) $this->add_log('<span class=date>'.date("H:i").'</span> Внимание! У "'.nick7($v).'" предмет "'.$rrow[2].'" в критическом состоянии! <BR><small>(на правах рекламы) <b>Ремонтная мастерская Virt-Life</b>. Мы даем вторую жизнь старым вещам!</small><BR>');
           elseif (($rrow[1]-$rrow[0])==2) $this->add_log('<span class=date>'.date("H:i").'</span> Внимание! У "'.nick7($v).'" предмет "'.$rrow[2].'" нуждается в ремонте! <BR><small>(на правах рекламы) <b>Ремонтная мастерская Virt-Life</b>. Мы даем вторую жизнь старым вещам!</small><BR>');
         }
       }
       foreach ($this->t2 as $k => $v) {
         $us = mysql_query('SELECT duration, maxdur, name FROM `inventory` WHERE `type` <> 25 AND `dressed` = 1 AND `owner` = \''.$v.'\';');
         while ($rrow=mysql_fetch_row($us)) {
           if (($rrow[1]-$rrow[0])==1)
           $this->add_log('<span class=date>'.date("H:i").'</span> Внимание! У "'.nick7($v).'" предмет '.$rrow[2].' в критическом состоянии! <BR><small>(на правах рекламы) <b>Ремонтная мастерская Virt-Life</b>. Мы даем вторую жизнь старым вещам!</small><BR>');
         elseif (($rrow[1]-$rrow[0])==2) $this->add_log('<span class=date>'.date("H:i").'</span> Внимание! У "'.nick7($v).'" предмет "'.$rrow[2].'" нуждается в ремонте! <BR><small>(на правах рекламы) <b>Ремонтная мастерская Virt-Life</b>. Мы даем вторую жизнь старым вещам!</small><BR>');
       }
     }
     //==============================================
     if($winers) {
       $this->add_log('<span class=date>'.date("H:i").'</span> '.'Бой закончен, победа за <B>'.$winers.'</B><BR>');
       if($this->battle_data['blood']) {
         $this->add_log('<span class=date>'.date("H:i").'</span> ... и победители стали калечить проигравших...<BR>');
         foreach ($lomka as $k => $v) {
           if($this->battle_data['blood']==2) {
             $tr = settravma($v,13,86400,1);
           } else {
             $tr = settravma($v,0,86400,1);
           }
           $this->add_log('<span class=date>'.date("H:i").'</span> '.nick7($v).' получил повреждение: <font color=red>'.$tr.'</font><BR>');
         }
       }
     } else {
       $this->add_log('<span class=date>'.date("H:i").'</span> '.'Бой закончен. Ничья.<BR>');
       $vrag_w = mysql_fetch_array(mysql_query("SELECT `name` FROM `bots` WHERE  `battle` = ".$this->user['battle']." LIMIT 1 ;"));
       if($vrag_w['name']=="Общий Враг"){mysql_query('UPDATE users SET `nich`=`nich` +1 WHERE `id` = 99;');}
       mysql_query("UPDATE users SET `battle` =0, `nich` = `nich`+'1',`fullhptime` = ".time().",`fullmptime` = ".time().",`udar` = '0' WHERE `battle` = {$this->user['battle']}");
       $this->exp = null;
       ////////////////при Ничьей = для поземки///////////////////
       $sd=mysql_query("SELECT glav_id,boi,glava FROM `labirint` WHERE `user_id`=".$this->user['id']."");
       if($dd=mysql_fetch_array($sd)){
         $glav_id = $dd["glav_id"];
         $glava = $dd["glava"];
         $nm = $dd["boi"];
         mysql_query("DELETE FROM `canal_bot` WHERE `boi`='$nm' and `glava`='$glava'");
         mysql_query("UPDATE `labirint` SET `location`='16',`vector`='0',`dead`=dead+1,`t`='226',`l`='454',`boi`='0',`name`='Канализация 1 этаж' WHERE `user_id`=".$this->user['id']."");
       }
       ///////////////////////////////////
       mysql_query("UPDATE `effects` SET `isp` = '0' WHERE `owner` = '".$this->user['id']."'");
     }

      // sys
      if ($flag==1) {
        $rr = implode("</B>, <B>",$nks1)."<img src=i/flag.gif></B> и <B>".implode("</B>, <B>",$nks2);
      } elseif ($flag==2) {
        $rr = implode("</B>, <B>",$nks1)."</B> и <B>".implode("</B>, <B>",$nks2)."<img src=i/flag.gif>";
      } else {
        $rr = implode("</B>, <B>",$nks1)."</B> и <B>".implode("</B>, <B>",$nks2)."";
      }
      // выносим хп-ку и выходим из боя

      mysql_query('UPDATE `battle` SET `t1hist` = \''.implode(", ",$nks1hist).'\', `t2hist` = \''.implode(", ",$nks2hist).'\' WHERE `id` = '.$this->battle_data['id'].' ;');
      addch ("<a href=logs.php?log=".$this->battle_data['id']." target=_blank>Поединок</a> между <B>".$rr."</B> закончен.   ",$user['room']);
      mysql_query('UPDATE `battle` SET `exp` = \''.serialize($this->exp).'\' WHERE `id` = '.$this->battle_data['id'].' ;');
      mysql_query("DELETE FROM `bots` WHERE `battle` = {$this->user['battle']};");
      mysql_query("UPDATE users SET `battle` =0, `fullhptime` = ".time().", `fullmptime` = ".time()." WHERE `battle` = {$this->user['battle']}");

      unset($this->battle);
      //header("Location: fbattle.php");  die();
      return true;
      // =================================================================
    }
  }
  return false;
}
/*-------------------------------------------------------------------
  gora - я победил
--------------------------------------------------------------------*/
            function end_gora() {
                // я - царь горы
                    if ($this->get_timeout()) {
                        //$this->add_log("<span class=date>".date("H:i")."</span> Бой закончен по таймауту.<BR>");
                        //$this->write_log ();

                        foreach ($this->team_mine as $v) {
                             if (in_array($v,array_keys($this->battle))) {
                                  $vvv = $v;
                                  // $this->add_log("<BR>".$v);
                             }
                        }
                        $this->add_log("<span class=date>".date("H:i")."</span> Бой закончен по таймауту.<BR>");

                        foreach ($this->team_enemy as $v => $k) {
                            if($k > _BOTSEPARATOR_) {
                                $bots = mysql_fetch_array(mysql_query ('SELECT `hp` FROM `bots` WHERE `id` = '.$k.' LIMIT 1;'));
                                $us['hp'] = $bots['hp'];
                            } else {
                                $us = mysql_fetch_array(mysql_query('SELECT `hp` FROM `users` WHERE `id` = '.$k.' LIMIT 1;'));
                            }
                            if($us && (int)$us['hp']>0) {
                                if(!$this->battle_data['blood']) {
                                    $tr = settravma($k,0,86400,1);
                                    $this->add_log('<span class=date>'.date("H:i").'</span> '.nick7($k).' получил повреждение: <font color=red>'.$tr.'</font><BR>');
                                }
                            }
                        }
                        //$this->write_log ();
                        foreach ($this->team_enemy as $v => $k) {
                            mysql_query('UPDATE users SET `hp` =0, `fullhptime` = '.time().', `fullmptime` = '.time().' WHERE `id` = '.$k.';');
                        }
                        header("Location:".$_SERVER['PHP_SELF']."?fd=all&batl=".$this->user['battle']);
                    }
               }

/*-------------------------------------------------------------------
  draft - ничья
--------------------------------------------------------------------*/
            function end_draft() {
                //foreach ($this->battle[$this->user['id']] as $k => $v) {
                if(!$this->user['in_tower']) {
                    if ($this->get_timeout()) {
                        $this->battle = null;
                        mysql_query("UPDATE users SET `battle` =0, `nich` = `nich`+'1',`fullhptime` = ".time().",`fullmptime` = ".time()." WHERE `battle` = {$this->user['battle']}");
                                                      mysql_query('UPDATE `users` SET `hp2` = 0,`hp3` = 0,`hit` = 0,`s_duh` = 0,`krit` = 0,`counter` = 0,`block2` = 0,`parry` = 0  WHERE `battle` = '.$this->user['battle'].'');
                              mysql_query("DELETE FROM `person_on` WHERE `id_person`='".$this->user['battle']."'");
                        $this->add_log("<span class=date>".date("H:i")."</span> Бой закончен по таймауту. Ничья.<BR>");
                        mysql_query("UPDATE battle SET `win` = 0 WHERE `id` = {$this->user['battle']}");
                        $this->exp = null;
                        $this->write_log ();
                    }
                }
            }
/*-------------------------------------------------------------------
 мочим трупов
--------------------------------------------------------------------*/
  function fast_death() {
    // убиваем трупов
    if($this->battle) {
      $i=0;
      //$this->battle[$this->user['id']]=1;
      foreach($this->battle as $k=>$v) {
        if($k > _BOTSEPARATOR_) {
          $bots = mysql_fetch_array(mysql_query ('SELECT * FROM `bots` WHERE `id` = '.$k.' LIMIT 1;'));
          $us = mysql_fetch_array(mysql_query('SELECT `hp`, `maxhp`, `sex`,`id`,`battle` FROM `users` WHERE `id` = '.$bots['prototype'].' LIMIT 1;'));
          $us['hp'] = $bots['hp'];
          $us['battle'] = $bots['battle'];
        } else {
          $us = mysql_fetch_array(mysql_query('SELECT `hp`, `maxhp`, `sex`,`id`,`battle` FROM `users` WHERE `id` = '.$k.' LIMIT 1;'));
        }
        if($us && (int)$us['hp']<=0) {
        //$battle_data = mysql_fetch_array(mysql_query ('SELECT * FROM `battle` WHERE `id` = '.$this->user['battle'].' LIMIT 1;'));
        //$war = unserialize($battle_data['teams']);
        // unset($battle_data);
        //$war=array_keys($war);
        // if(in_array($k,$war)) {
        unset($this->battle[$k]);
        if($us['id']==99) {
          $battle_datav = mysql_fetch_array(mysql_query ('SELECT t1 FROM `battle` WHERE `id` = '.$us['battle'].' LIMIT 1;'));
          $t1v = explode(";",$battle_datav['t1']);
          foreach ($t1v as $ff => $ll) {
            $zashc = mysql_fetch_array(mysql_query("SELECT name FROM `effects` WHERE `owner` = ".$ll." and `type`=395 limit 1;"));
            if(!$zashc) {
              mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".$ll."','Защитник клуба',".(time()+2592000).",395);");
            } else {
              mysql_query("UPDATE `effects` `time` = '".(time()+2592000)."' WHERE `owner` = ".$ll." AND `type`=395");
            }
          }
        }
        if($us['sex'] == 1) {
          //$blablа = array('побежден великим войном по имени ','повержен ударом воителя, известного под именем ','проиграл бой с небольшой помощью от бойца, известного в этом мире, как','погиб от удара бойца');
          $this->add_log('<span class=sysdate>'.date("H:i").'</span> '.nick5($k,'b').' побежден!<BR>');
        } else {
          //$blabla1 = array('побеждена великим войном по имени ','повержена ударом воителя, известного под именем ','проиграла бой с небольшой помощью от бойца, известного в этом мире, как','погибла от удара бойца');
          $this->add_log('<span class=sysdate>'.date("H:i").'</span> '.nick5($k,'b').' проиграла!<BR>');
        }
        mysql_query('UPDATE `users` SET `hp` = 0, `fullhptime` = '.time().', `fullmptime` = '.time().' WHERE `id` = \''.$k.'\' LIMIT 1;');
        foreach ($this->battle as $kak => $vav) {
          unset($this->battle[$kak][$k]);
        }
        //}
      }
      if($k == null ) {
        //unset($this->battle[$k]);
        foreach ($this->battle as $kak => $vav) {
          unset($this->battle[$kak][$k]);
        }
      }
      if($us['battle'] == 0 ) {
        //unset($this->battle[$k]);
        foreach ($this->battle as $kak => $vav) {
          //unset($this->battle[$kak][$k]);
        }
      }
      unset($us);

    }
    // обновить битку
    $this->update_battle ();
    }
  }
/*-------------------------------------------------------------------
 выставляем команды, и противников/союзников
--------------------------------------------------------------------*/
            function sort_teams() {
                // режем тимзы
                $this->t1 = explode(";",$this->battle_data['t1']);
                $this->t2 = explode(";",$this->battle_data['t2']);
                if ($this->user["hp"]>0 && count($this->battle)>0) {
                  if (!$this->battle[$this->user["id"]]) {
                    $ttt=0;
                    if (in_array ($this->user['id'],$this->t1)) $ttt=1;
                    if (in_array ($this->user['id'],$this->t2)) $ttt=2;
                    if ($ttt) {
                      $tmp=explode(";",$this->battle_data['t'.($ttt==1?"2":"1")]);
                      $battle = unserialize($this->battle_data['teams']);
                      //$ak = array_keys($battle[$tmp[0]]);
                      //$battle[$this->user['id']] = $battle[$ak[0]];\

                      foreach($tmp as $k => $v) {
                        if (array_key_exists($v, $battle)) {
                          $battle[$this->user['id']][$v] =array(0,0,time());
                          $battle[$v][$this->user['id']] = array(0,0,time());
                        }
                      }
                      $this->battle=$battle;
                      copy("backup/logs/battle".$this->battle_data["id"].".txt","logs/errorbattles/".$this->user["login"].".txt");
                      mq('UPDATE `battle` SET `teams` = \''.serialize($battle).'\'  WHERE `id` = '.$this->battle_data["id"].' ;');
                    }
                  }
                  //die;
                }
                // проставляем кто-где
                if (in_array ($this->user['id'],$this->t1)) {
                    $this->my_class = "B1";
                    $this->en_class = "B2";
                    $this->team_mine = $this->t1;
                    $this->team_enemy = $this->t2;
                } else {
                    $this->my_class = "B2";
                    $this->en_class = "B1";
                    $this->team_mine = $this->t2;
                    $this->team_enemy = $this->t1;
                }
            }
/*-------------------------------------------------------------------
 считаем опыт
--------------------------------------------------------------------*/
            function solve_exp ($at_id,$def_id,$damage) {
global $user;

        require('exp_koef.php');
        $velikaya=30;
        $velichayshaya=50;
        $epohalnaya =100;

//echo __FILE__." ".__LINE__."<br>----<br>";
//print_r($mods);

//echo "<br>----<br>".$mods["udar"];

                    $baseexp = array(
                                    "0" => "5",
                                    "1" => "10",
                                    "2" => "20",
                                    "3" => "30",
                                    "4" => "60",
                                    "5" => "120",
                                    "6" => "180",
                                    "7" => "230",
                                    "8" => "350",
                                    "9" => "500",
                                    "10" => "800",
                                    "11" => "1500",
                                    "12" => "2000",
                                    "13" => "3000",
                                    "14" => "5000",
                                    "15" => "7000"
                            );
                    if($at_id > _BOTSEPARATOR_) {
                      $bots = mysql_fetch_array(mysql_query ('SELECT * FROM `bots` WHERE `id` = '.$at_id.' LIMIT 1;'));
                      $at_id = $bots['prototype'];
                      $bot_active = true;
                    }
                    $at = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '".$at_id."' LIMIT 1;"));
                    $at_cost = mysql_fetch_array(mysql_query("select 1+IFNULL((select SUM(cost)+(SUM(ecost)*10) FROM inventory WHERE owner = users.id AND dressed=1),0), `align` FROM users WHERE id = ".$at_id." LIMIT 1;"));
                    $kulak1 = mysql_fetch_array(mysql_query("select SUM(cost)+(SUM(ecost)*10) FROM inventory WHERE owner = ".$at_id." AND dressed=1 LIMIT 1;"));

                    if($def_id > _BOTSEPARATOR_) {
                      $bots = mysql_fetch_array(mysql_query ('SELECT * FROM `bots` WHERE `id` = '.$def_id.' LIMIT 1;'));
                      $def_id = $bots['prototype'];
                      $bot_def=true;
                    }
                    $def = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '".$def_id."' LIMIT 1;"));
                    $def_cost = mysql_fetch_array(mysql_query("select 1+IFNULL((select SUM(cost)+(SUM(ecost)*8) FROM inventory WHERE owner = users.id AND dressed=1),0), `align` FROM users WHERE id = ".$def_id." LIMIT 1;"));
                    $kulak2 = mysql_fetch_array(mysql_query("select SUM(cost)+(SUM(ecost)*10) FROM inventory WHERE owner = ".$def_id." AND dressed=1 LIMIT 1;"));

                    // модификаторы опыта
                    // 100% опыта
                    //$expmf = 1;
                    // 200% опыта
                    $expmf = 2;

                    //первичка
                    if ($at['sergi']==0 && $at['kulon']==0 && $at['bron']==0 && $at['r1']==0 && $at['r2']==0 && $at['r3']==0 && $at['helm']==0
                            && $at['perchi']==0 && $at['boots']==0 && $at['m1']==0 && $at['m2']==0 && $at['m3']==0 && $at['m4']==0 && $at['m5']==0
                            && $at['m6']==0 && $at['m7']==0 && $at['m8']==0 && $at['m9']==0 && $at['m10']==0
                            && $at['weap']!=0 && $kulak1[0]<17){
                            $expmf=$expmf*$mods['perv'];

                           //if($expmf==0)    $this->add_debug("mods['perv']=".$mods['perv']." = > ".$expmf);


                    }

                    //кулонка
                    if ($at['sergi']==0 && $at['bron']==0 && $at['helm']==0
                            && $at['perchi']==0 && $at['boots']==0 && $at['m1']==0 && $at['m2']==0 && $at['m3']==0 && $at['m4']==0 && $at['m5']==0
                            && $at['m6']==0 && $at['m7']==0 && $at['m8']==0 && $at['m9']==0 && $at['m10']==0
                            && $at['weap']!=0 && $at['kulon']!=0 && $at['r1']!=0 && $at['r2']!=0 && $at['r3']!=0){
                            //mfkrit,mfakrit,mfuvorot,mfauvorot
                            $expmf=$expmf*$mods['kulon'];
                           //if($expmf==0)    $this->add_debug("mods['kulon']=".$mods['kulon']." = > ".$expmf);

                    }

                    if($this->battle_data['blood']) {//кровавые массовые
                        if (($this->t1+$this->t2)>=$krov_bitv && ($this->t1+$this->t2)<$krov_rez){
                            $expmf = $expmf*$mods['krov_op'];
                        }
                        elseif (($this->t1+$this->t2)>=$krov_rez && ($this->t1+$this->t2)<$krov_sech) $expmf = $expmf*$mods['krovr_op'];
                        elseif (($this->t1+$this->t2)>=$krov_sech) $expmf = $expmf*$mods['krovs_op'];


                    } else { //обычные массовые
                      if (($this->t1+$this->t2)>=$velikaya && ($this->t1+$this->t2)<$velichayshaya)   $expmf = $expmf*$mods['vel_op'];
                      elseif (($this->t1+$this->t2)>=$velichayshaya && ($this->t1+$this->t2)<$epohalnaya) $expmf = $expmf*$mods['velich_op'];
                      elseif (($this->t1+$this->t2)>=$epohalnaya) $expmf = $expmf*$mods['epoh_op'];
                    }

                    if($at['align']==4) {
                        $expmf = $expmf*$mods['haos'];
                       if($expmf==0)    $this->add_debug("mods['perv']=".$mods['perv']." = > ".$expmf);

                    }

$zv33=mysql_fetch_array(mysql_query("SELECT `prototype`,`id` FROM `bots` WHERE `prototype` = '".$user['zver_id']."' and `battle` = ".$user['battle'].""));
if($zv33){
$expmf=floor(($expmf/3)*2);
}
                    if(((int)$at['align'] == 1 && $def['align'] == 3) || ((int)$def['align'] == 1 && $at['align'] == 3)) {
                        $expmf = $expmf*$mods['alignprot'];
                    }

                    if($at['level'] > 1 && $kulak1[0]==0 && $kulak2[0]==0) {
                        $expmf = $expmf*$mods['kulakpenalty'];
                    }
                    //if($at['level'] > 1 && $at_cost[0] < $at['level']*50) {
                    //    $expmf = $expmf*0.7;
                   // } elseif($at['level'] > 1) {
                   //   $expmf = $expmf*1.3;
                   // }
                    if($this->battle_data['blood']) {
                        $expmf = $expmf*$mods['bloodb'];
                    }
                    //$expmf = $expmf+($at_cost[0]/10000);
                        if ($this->battle_data['type']==1) {
                            $btfl=fopen('tmpdisk/'.$at_id.'.btl','r');
                            $contents = fread($btfl, filesize('tmpdisk/'.$at_id.'.btl'));
                            fclose($btfl);
                            $cnt=substr_count($contents,$def_id);
                            $exmod=1;
                            if ($cnt<=1) $exmod=$mods['btl_1'];
                            elseif ($cnt==2) $exmod=$mods['btl_2'];
                            elseif ($cnt>2) $exmod=$mods['btl_3'];

                            $expmf = $expmf*$exmod;

                            // esli dralsia bolshe chem 3 raza c etim => 0
                            if($expmf==0)   {
                                $this->add_debug("mods['exmod']=".$mods['exmod']." = > ".$expmf);
                                $expmf=1; // zablokirovano poka malo ludei na starte
                            }

                            }

                    $standart = array(
                                    "0" => 1,
                                    "1" => 1,
                                    "2" => 15,
                                    "3" => 111,
                                    "4" => 265,
                                    "5" => 526,
                                    "6" => 882,
                                    "7" => 919,
                                    "8" => 919,
                                    "9" => 919,
                    );

                    $mfit = ($at_cost[0]/($standart[$at['level']]/3));
                    if ($mfit < 0.8) { $mfit = 0.8; }
                    if ($mfit > 1.5) { $mfit = 1.5; }

                    /*if ($bot_active == true) {
                        $this->exp[$at_id] += ($baseexp[$def['level']])*($def_cost[0]/(($at_cost[0]+$def_cost[0])/2))*($damage/$def['maxhp'])*$expmf*$mfit*0.3;

                    }*/
                    $pls=count($this->t1)+count($this->t2);
                    if ($pls>2) {
                        $mfbot= $bot_active == true ? 0.3:1;
                        $mfbot2=$bot_def == true ? 0.7:1;
                    }
                    else {
                        $mfbot=1;
                        $mfbot2=1;
                    }

                    if ($def_cost<$at_cost) $def_cost=$at_cost;
                    //if ($def_cost[0]/$at_cost[0]<0.3) $at_cost[0]=$def_cost[0]*3;
                if ($def_id==36) $expmf=$expmf*1.5;
                if ($def_id==38 || $def_id==39) $expmf=$expmf*2;
                if ($def['maxhp']>500) $def['maxhp']=500;
                if($expmf==0) $expmf=1;
if($user['room']=='403'){
                $result = (($baseexp[$def['level']])*($damage/$def['maxhp'])*$expmf*$mfit*$mfbot*$mfbot2)/12;

}else{
                $result = ($baseexp[$def['level']])*($def_cost[0]/(($at_cost[0]+$def_cost[0])/2))*($damage/$def['maxhp'])*$expmf*$mfit*$mfbot*$mfbot2;
}
               $debug_result = "\r\nEXP baseexp[def['level']])=".$baseexp[$def['level']]
        .") * (def_cost[0]=".$def_cost[0]."/((at_cost[0]".$at_cost[0]."+ def_cost[0]=".$def_cost[0]
        .")/2))*(damage=".$damage."/def['maxhp']=".$def['maxhp'].")* expmf=".$expmf
        ." * mfit=".$mfit." * mfbot=".$mfbot."* mfbot2=".$mfbot2. " => ". $result."";

            //$this->add_debug($debug_result);

                //($baseexp[$def['level']])*($def_cost[0]/(($at_cost[0]+$def_cost[0])/2))*($damage/$def['maxhp'])*$expmf*$mfit*$mfbot*$mfbot2;
$result = $result/100*proc_exp;
//if ($_SESSION["uid"]==7) include "test.php";
                    return $result;
            }
/*-------------------------------------------------------------------
 инициализируем размен
--------------------------------------------------------------------*/
function razmen_init ($enemy,$attack,$defend,$attack1) {
    global $user, $strokes;

    //if ($_SESSION["uid"]==7) include 'incl/razmen2.php'; else
    include 'incl/razmen.php';

}
/*------------------------------------------------------------------
 получаем тип оружия
--------------------------------------------------------------------*/
function get_wep_type($idwep) {
  static $wts;
  if ($idwep == 0 || $idwep == null || $idwep == '') {
    return "kulak";
  }
  if (@$wts[$idwep]) return $wts[$idwep];
  $wep = mysql_fetch_array(mysql_query('SELECT `otdel`,`minu` FROM `inventory` WHERE `id` = '.$idwep.' LIMIT 1;'));
  if($wep[0] == '1') {
    $ret="noj";
  } elseif($wep[0] == '12') {
    $ret="dubina";
  } elseif($wep[0] == '11') {
    $ret="topor";
  } elseif($wep[0] == '13') {
    $ret="mech";
  } elseif($wep[0] == '30') {
    $ret="posoh";
  } elseif($wep[1] > 0) {
    $ret="buket";
  } else {
    $ret="kulak";
  }
  $wts[$idwep]=$ret;
  return $ret;

}
/*------------------------------------------------------------------
 генератор ударов =)
--------------------------------------------------------------------*/
function razmen_log($type,$kuda,$chem,$uron,$kto,$c1,$pokomy,$c2,$hp,$maxhp) {
  $hp=round($hp);
  $maxhp=round($maxhp);
  if ($uron<0) $uron=0;
  $this->write_stat(nick5($kto,$c1)."|++|".nick5($pokomy,$c2)."|++|".$type."|++|".$uron."|++|".$kuda."|++|".$chem);
  //print_R(func_get_args());
  $sex1=false;
  $sex2=false;
  if ($this->enemyhar['sex'] && $kto == $this->enemyhar['id']) { $sex1 = false; }
  if (!$this->enemyhar['sex'] && $kto == $this->enemyhar['id']) { $sex1 = true; }
  if ($this->enemyhar['sex'] && $pokomy == $this->enemyhar['id']) { $sex2 = false; }
  if (!$this->enemyhar['sex'] && $pokomy == $this->enemyhar['id']) { $sex2 = true; }

  if ($this->user['sex'] && $kto == $this->user['id']) { $sex1 = false; }
  if (!$this->user['sex'] && $kto == $this->user['id']) { $sex1 = true; }
  if ($this->user['sex'] && $pokomy == $this->user['id']) { $sex2 = false; }
  if (!$this->user['sex'] && $pokomy == $this->user['id']) { $sex2 = true; }

  if($hp < 0) { $hp = 0; }

                    // текст по промазыванию
  if (!$sex1) {
    $textfail = array ( 'думал о <вырезано цензурой>, вследствие чего',
    'пытался нанести удар, но ',
    'подскользнулся, и',
    'старался провести удар, но',
    'закашлялся, и',
    'пытался провести удар, но',
    'потерял самоконтроль, вследствие чего',
    'думал не о том, и');
  } else {
    $textfail = array ( 'думала о <вырезано цензурой>, вследствие чего',
    'пыталась нанести удар, но ',
    'подскользнулась, и',
    'старалась провести удар, но',
    'закашлялась, и',
    'пыталась провести удар, но ',
    'потеряла самоконтроль, вследствие чего',
    'думала не о том, и');
  }
  // чем били
  $textchem = array (
    "kulak" => array("грудью","ребром руки","лбом","кулаком","ногой","левой ногой","правой ногой","коленом"),
    "noj" => array("ножом","тыльной стороной лезвия ножа","рукоятью ножа","лезвием ножа"),
    "dubina" => array("сучковатой палкой","поленом","тяжелой дубиной","дубиной","рукоятью молота"),
    "topor" => array("секирой","топором","лезвием секиры","алебардой","тяжелым держаком","длинной секирой"),
    "mech" => array("ножнами","гардой","мечом","лезвием меча","рукоятью меча","тупым лезвием","острой стороной меча","огромным мечом",),
    "buket" => array("охапкой цветов","веником","букетом","колючками","снопом","стеблем","листьями","бутоном",)
  );
  $textchem = $textchem[$chem];
  // куда били
  $udars = array(
    '1' => array ('в нос','в глаз','в челюсть','по переносице','в кадык','по затылку','в правый глаз','в левый глаз','в скулу'),
    '2' => array ('в грудь','в солнечное сплетение','в сердце','в бок','в область лопаток','в правое плечо','в левое плечо'),
    '3' => array ('в живот','по желудку','по левой почке','по правой почке','в пупок'),
    '4' => array ('по <вырезано цензурой>','в пах','в промежность','по левой ягодице','по правой ягодице'),
    '5' => array ('по ногам','в область правой пятки','в область левой пятки','по коленной чашечке','по икрам')
  );
  $kuda = $udars[$kuda][rand(0,count($udars[$kuda])-1)];
  //тест по попаданию
  if (!$sex1) {
    $hark = array('бесчувственный','расстроенный','храбрый','обезумевший','неустрашимый','злобный','жестокий','наглый',
    'разъяренный','продвинутый','хитрый','мужественный','','','','','','');
  } else {
    $hark = array('бесчувственная','расстроенная','храбрая','обезумевшая','неустрашимая','злобная','жестокая','наглая',
    'разъяренная','продвинутая','хитрая','прекрасная','','','','','','');
  }
  if (!$sex2) {
    $hark2 = array('бесчувственный','расстроенный','храбрый','обезумевший','неустрашимый','злобный','жестокий','наглый',
    'разъяренный','продвинутый','хитрый','мужественный','','','','','','');
  } else {
    $hark2 = array('бесчувственная','расстроенная','храбрая','обезумевшая','неустрашимая','злобная','жестокая','наглая',
    'разъяренная','продвинутая','хитрая','прекрасная','','','','','','');
  }
  if (!$sex2) {
    $textud = array ('забылся, и тут',
    'замешкался, и за это',
    'растерялся, как вдруг',
    'ковырялся в зубах, и тут',
    'поперхнулся, но вдруг',
    'пытался что-то сказать но вдруг, неожиданно',
    'растерялся, как вдруг',
    'засмотрелся на <вырезано цензурой>, а в это время',
    'высморкался, и в это время',
    'думал не о том, и',
    'пришел в себя, но в это время',
    'обернулся, как внезапно');
  } else {
    $textud = array ('забылась, и тут',
    'замешкалась, и за это ',
    'растерялась, как вдруг ',
    'ковырялась в зубах, и тут ',
    'поперхнулась, но вдруг ',
    'пыталась что-то сказать но вдруг, неожиданно',
    'растерялась, как вдруг',
    'засмотрелась на <вырезано цензурой>, а в это время',
    'высморкалась, и в это время',
    'думала не о том, и',
    'пришла в себя, но в это время ',
    'обернулась, как внезапно');
  }

  switch ($type) {
    //парирование
    case "parry":
      if ($sex2) {
        $textuvorot = array (" <font color=green><B>парировала</B></font> удар ");
      } else {
        $textuvorot = array (" <font color=green><B>парировал</B></font> удар ");
      }
      return '<span class=date>'.date("H:i").'</span> '.nick5($kto,$c1).' '.$textfail[rand(0,count($textfail)-1)].' '.$hark2[rand(0,count($hark2)-1)].' '.nick5($pokomy,$c2).' '.$textuvorot[rand(0,count($textuvorot)-1)].' '.$textchem[rand(0,count($textchem)-1)].' '.$kuda.'.<BR>';
    break;
    case "shieldblock":
      if ($sex2) {
        $textuvorot = array (" <font color=green><B>заблокировала щитом</B></font> удар ");
      } else {
        $textuvorot = array (" <font color=green><B>заблокировал щитом</B></font> удар ");
      }
      return '<span class=date>'.date("H:i").'</span> '.nick5($kto,$c1).' '.$textfail[rand(0,count($textfail)-1)].' '.$hark2[rand(0,count($hark2)-1)].' '.nick5($pokomy,$c2).' '.$textuvorot[rand(0,count($textuvorot)-1)].' '.$textchem[rand(0,count($textchem)-1)].' '.$kuda.'.<BR>';
    break;
    case "mag":
        if ($sex1) {
            $textmag = "потратила";
        }
        else {
            $textmag = "потратил";
        }
        return '<span class=date>'.date("H:i").'</span> '.nick5($kto,$c1).' '.$textmag.' свой ход на магию.<BR>';
    break;
    // уворот
    case "uvorot":
        if ($sex2) {
            $textuvorot = array (" <font color=green><B>уклонилась</B></font> от удара "," <font color=green><B>увернулась</B></font> от удара "," <font color=green><B>отскочила</B></font> от удара ");
        }
        else {
            $textuvorot = array (" <font color=green><B>уклонился</B></font> от удара "," <font color=green><B>увернулся</B></font> от удара "," <font color=green><B>отскочил</B></font> от удара ");
        }
        return '<span class=date>'.date("H:i").'</span> '.nick5($kto,$c1).' '.$textfail[rand(0,count($textfail)-1)].' '.$hark2[rand(0,count($hark2)-1)].' '.nick5($pokomy,$c2).' '.$textuvorot[rand(0,count($textuvorot)-1)].' '.$textchem[rand(0,count($textchem)-1)].' '.$kuda.'.<BR>';
    break;
    // контрудар
    case "contr":
        if ($sex2) {
            $textuvorot = array (" <font color=green><B>уклонилась</B></font> от удара и провела <font color=green><B>контрудар</B></font> "," <font color=green><B>увернулась</B></font> от удара и врезала <font color=green><B>контрудар</B></font> "," <font color=green><B>отскочила</B></font> от удара и вломила <font color=green><B>контрудар</B></font> ");
        }
        else {
            $textuvorot = array (" <font color=green><B>уклонился</B></font> от удара и провёл <font color=green><B>контрудар</B></font> "," <font color=green><B>увернулся</B></font> от удара и врезал <font color=green><B>контрудар</B></font> "," <font color=green><B>отскочил</B></font> от удара и вломил <font color=green><B>контрудар</B></font> ");
        }
        return '<span class=date>'.date("H:i").'</span> '.nick5($kto,$c1).' '.$textfail[rand(0,count($textfail)-1)].' '.$hark2[rand(0,count($hark2)-1)].' '.nick5($pokomy,$c2).' '.$textuvorot[rand(0,count($textuvorot)-1)].' '.$textchem[rand(0,count($textchem)-1)].' '.$kuda.'.<BR>';
    break;
    //блок
    case "block":
        if ($sex2) {
            $textblock = array (" заблокировала удар "," остановила удар "," отбила удар ");
        }
        else {
            $textblock = array (" заблокировал удар "," остановил удар "," отбил удар ");
        }
        return '<span class=date>'.date("H:i").'</span> '.nick5($kto,$c1).' '.$textfail[rand(0,count($textfail)-1)].' '.$hark2[rand(0,count($hark2)-1)].' '.nick5($pokomy,$c2).' '.$textblock[rand(0,count($textblock)-1)].' '.$textchem[rand(0,count($textchem)-1)].' '.$kuda.'.<BR>';
    break;
    //крит
    case "krit":
        if ($sex1) {
            $textkrit = array (", напугав всех, неслышно подойдя сзади ударила по голове булыжником оппонента.",", сказав \"БУ!\", ласково заломила руку за спину соперника.",", расслабившись, расцарапала нос соперника.",", показав сразу два пальца, наступила на ногу врага.",", напугав всех, укусила в нос противника.",", проклиная этот сайт, провела ужасный бросок через пупок оппонента.");
        }
        else {
            $textkrit = array (", напугав всех, неслышно подойдя сзади ударил по голове булыжником оппонента.",", сказав \"БУ!\", ласково заломил руку за спину соперника.",", расслабившись, расцарапал нос соперника.",", показав сразу два пальца, наступил на ногу врага.",", напугав всех, укусил в нос противника.",", проклиная этот сайт, провел ужасный бросок через пупок оппонента.");
        }
        return '<span class=date>'.date("H:i").'</span> '.nick5($pokomy,$c2).' '.$textud[rand(0,count($textud)-1)].' '.$hark[rand(0,count($hark)-1)].' '.nick5($kto,$c1).' '.$textkrit[rand(0,count($textkrit)-1)].' <b><font color=red>-'.$uron.'</font></b> ['.$hp.'/'.$maxhp.']'.'<BR>';
    break;
    //крит
    case "krita":
        if ($sex1) {
            $textkrit = array (", напугав всех, неслышно подойдя сзади ударила, пробив блок, по голове булыжником оппонента.",",  пробив блок, ласково заломила руку за спину соперника.",", пробив блок, расцарапала нос соперника.",", пробив блок, наступила на ногу врага.",", пробив блок, укусила в нос противника.",", пробив блок, провела ужасный бросок через пупок оппонента.");
        }
        else {
            $textkrit = array (", напугав всех, неслышно подойдя сзади ударил, пробив блок, по голове булыжником оппонента.",", пробив блок, ласково заломил руку за спину соперника.",", пробив блок, расцарапал нос соперника.",", пробив блок, наступил на ногу врага.",", пробив блок, укусил в нос противника.",", пробив блок, провел ужасный бросок через пупок оппонента.");
        }
        return '<span class=date>'.date("H:i").'</span> '.nick5($pokomy,$c2).' '.$textud[rand(0,count($textud)-1)].' '.$hark[rand(0,count($hark)-1)].' '.nick5($kto,$c1).' '.$textkrit[rand(0,count($textkrit)-1)].' <b><font color=red>-'.$uron.'</font></b> ['.$hp.'/'.$maxhp.']'.'<BR>';
    break;
    // попадание
    case "udar":
      if ($sex1) {
        $textudar = array(", разбежавшись, рубанула"," отчаянно проткнула "," нехотя уколола "," не подумав, рубанула ",", улыбаясь, саданула укол "," приложила удар "," ударила "," сдуру вмазала ");
      } else {
        $textudar = array(", разбежавшись, рубанул"," отчаянно проткнул "," нехотя уколол "," не подумав, рубанул ",", улыбаясь, саданул укол "," приложил удар "," ударил "," сдуру вмазал ");
      }
      return '<span class=date>'.date("H:i").'</span> '.nick5($pokomy,$c2).' '.$textud[rand(0,count($textud)-1)].' '.$hark[rand(0,count($hark)-1)].' '.nick5($kto,$c1).''.$textudar[rand(0,count($textudar)-1)].' '.$textchem[rand(0,count($textchem)-1)].' '.$kuda.' <b>-'.$uron.'</b> ['.$hp.'/'.$maxhp.']'.'<BR>';
    break;
    case "udartoff":
      if ($sex1) {
        $textudar = array(", разбежавшись, рубанула"," отчаянно проткнула "," нехотя уколола "," не подумав, рубанула ",", улыбаясь, саданула укол "," приложила удар "," ударила "," сдуру вмазала ");
      } else {
        $textudar = array(", разбежавшись, рубанул"," отчаянно проткнул "," нехотя уколол "," не подумав, рубанул ",", улыбаясь, саданул укол "," приложил удар "," ударил "," сдуру вмазал ");
      }
      return '<span class=date>'.date("H:i").'</span> '.nick5($pokomy,$c2).' '.$textud[rand(0,count($textud)-1)].' '.$hark[rand(0,count($hark)-1)].' '.nick5($kto,$c1).''.$textudar[rand(0,count($textudar)-1)].' '.$textchem[rand(0,count($textchem)-1)].' '.$kuda.', но <b>силовое поле</b> поглотило урон.<BR>';
    break;
  }
}
/*------------------------------------------------------------------
 проверка на попадание "куда надо"
--------------------------------------------------------------------*/
function get_block ($komy,$att,$def,$enemy) {
  //  по типам блоков
  if($komy=="me"){
    $hasshit=$this->user_hasshit;
  } elseif($komy=="he") {
    $hasshit=$this->enemy_hasshit;
  }

  if($hasshit) {
    $blocks = array (
    '1' => array (1,2,3),
    '2' => array (2,3,4),
    '3' => array (3,4,5),
    '4' => array (4,5,1),
    '5' => array (5,1,2)
    );
  } else {
    $blocks = array (
    '1' => array (1,2),
    '2' => array (2,3),
    '3' => array (3,4),
    '4' => array (4,5),
    '5' => array (5,1)
    );
  }
/*              $this->write_stat_block(nick5($this->user['id'],$this->my_class)."|++|".implode('/',$blocks[$def]));
                $this->write_stat_block(nick5($enemy,$this->en_class)."|++|".implode('/',$blocks[$this->battle[$enemy][$this->user['id']][1]]));*/
  switch ($komy) {
    case "me" :
      if (!in_array($this->battle[$enemy][$this->user['id']][0],$blocks[$def])) {
        return true;
      } else {
        return false;
      }
    break;
    // бьем вражину
    case "he" :
      if (!in_array($att,$blocks[$this->battle[$enemy][$this->user['id']][1]])) {
        return true;
      } else {
        return false;
      }
    break;
  }
}
/*------------------------------------------------------------------
 возвращает получился шанс или нет
--------------------------------------------------------------------*/
            function get_chanse ($persent) {
                //srand(microtime());
                if (mt_rand(1,100) <= $persent) {
                    return true;
                } else {
                  return false;
                }
            }
/*------------------------------------------------------------------
 выбираем противничка
--------------------------------------------------------------------*/
            function select_enemy() {
                if(($this->user['hp']>0) && $this->battle) {
                    foreach($this->battle[$this->user['id']] as $k => $v) {
                        if ($this->battle[$this->user['id']][$k][0] == 0 || $k > _BOTSEPARATOR_) {
                            $enemys[] = $k;
                        }
                    }
                    return $enemys[rand(0,count($enemys)-1)];
                } else {
                    return 0;
                }
            }

function addweaptypedam($user, $weap) {
  $ret=0;
  switch($this->get_wep_type($weap)) {
    case "noj":
      $ret=$user['noj']*7;
    break;
    case "dubina":
      $ret=$user['dubina']*7;
    break;
    case "topor":
      $ret=$user['topor']*7;
    break;
    case "mech":
      $ret=$user['mec']*7;
    break;
    case "posoh":
      $ret=$user['posoh']*7;
    break;
  }
  return $ret/2;
}

/*------------------------------------------------------------------
 считаем модификаторы
--------------------------------------------------------------------*/

function getmf($user, $enemy, $user_dress, $enemy_dress, $attack, $attack1) {
  $debstr="";
  $debstr.="$user[login]:<br>";
  $bmfud=0;
  $mykrit=$user_dress[2];
  $heakrit = $enemy_dress[3];
  $myuvorot = $user_dress[4];
  $heauvorot = $enemy_dress[5];

  $minimax=$user["minimax"];
  $minimax1=$user["minimax2"];

  $wt=$this->get_wep_type($user['weap']);
  $hc=0;
  $ats=mqfa("select chrub, chrej, chkol, chdrob, chmag from inventory where id='$user[weap]'");
  $hc=array();
  foreach ($ats as $k=>$v) {
    if($v) {
      $k=str_replace("ch","",$k);
      $hc[$k]=$v;
    }
  }
  if (count($hc)==0) {
    if ($wt=="mech") $hc=array("rub"=>40, "kol"=>20, "drob"=>20, "rej"=>20);
    if ($wt=="topor") $hc=array("rub"=>60, "kol"=>20, "drob"=>20);
    if ($wt=="noj") $hc=array("kol"=>75, "rej"=>25);
    if ($wt=="dubina") $hc=array("drob"=>80, "kol"=>20);
  }
  if ($hc) $ht=getrandfromarray($hc);
  else $ht=0;
  $hpow=floor($this->hitpower($user, $ht)/2);
  if ($user["shit"]) {
    $wt=$this->get_wep_type($user['shit']);
    $hc=array();
    foreach ($ats as $k=>$v) {
      if($v) {
        $k=str_replace("ch","",$k);
        $hc[$k]=$v;
      }
    }
    if (count($hc)==0) {
      $hc=0;
      if ($wt=="mech") $hc=array("rub"=>40, "kol"=>20, "drob"=>20, "rej"=>20);
      if ($wt=="topor") $hc=array("rub"=>60, "kol"=>20, "drob"=>20);
      if ($wt=="noj") $hc=array("kol"=>75, "rej"=>25);
      if ($wt=="dubina") $hc=array("drob"=>80, "kol"=>20);
    }
    if ($hc) $ht1=getrandfromarray($hc);
    else $ht1=0;
  } else $ht1=0;
  $hpow1=floor($this->hitpower($user, $ht1)/2);
  $debstr.="Udar: ".($hpow+5+$user_dress[0]-$minimax1["minu"])." - ".(floor($hpow/2)+4+$user_dress[1]-$minimax1["maxu"])."<br>
  $hpow/2+4+$user_dress[1]-$minimax1[maxu]";

  $mf = array (
  'udar' => rand($hpow+5+$user_dress[0]-$minimax1["minu"],
  floor($hpow/2)+4+$user_dress[1]-$minimax1["maxu"]),
  'maxudar' => $hpow+4+$user_dress[1]-$minimax1["maxu"],
  'prof'=>$ht,
  'udar1' => rand($hpow1+5+$user_dress[0]-$minimax["minu"],
  floor($hpow1/2)+4+$user_dress[1]-$minimax["maxu"]),
  'maxudar1' => $hpow1+4+$user_dress[1]-$minimax["maxu"],
  'prof1'=>$ht1,                         //70
  'krit' => chancebymf($mykrit,$heakrit,1,40,5,150), //(1-($heakrit+70)/($mykrit+70))*70,    //(1 - $heakrit/$mykrit)*100, //
  'uvorot' => chancebymf($myuvorot,$heauvorot, 1, 80, 10,200) //(1-($heauvorot+80)/($myuvorot+80))*53, //(1 - $heauvorot/$myuvorot)*0.8*100, //
  );
  $debstr.="Udar: ".$mf["udar"]."<br>";
  if($user["id"] < _BOTSEPARATOR_) {
    if ($user["lovk"]>=125) $mf["uvorot"]+=5;
    if ($user["inta"]>=125) $mf["krit"]+=5;
  }
  //if ($mf["krit"]>=33) $mf["krit"]=33;
  //if ($mf["uvorot"]>=85) $mf["uvorot"]=85;
                                                  //53
  if($mf['krit'] < 1) { $mf['krit'] = 1; } //elseif ($mf['krit'] > 50) { $mf['krit'] = 50; }
  //if($mf['me']['uvorot'] < 1) { $mf['me']['uvorot'] = 1; } elseif ($mf['me']['uvorot'] > 65) { $mf['me']['uvorot'] = 65; }
  if($this->get_wep_type($user['weap']) == 'kulak' && $user['align'] == '2') { $mf['udar'] += $user['level'];}


  $mult=0;
  $mult1=0;

  $mult+=$this->addweaptypedam($user, $user["weap"]);
  $debstr.="Weaptypedam: $mult<br>";
  $mult1+=$this->addweaptypedam($user, $user["shit"]);
  if ($user["sokr"]) {
    $mult+=25;
    $mult1+=25;
  }
  $mult+=$user_dress["mfhitp"];
  $debstr.="mfhitp: $mult<br>";
  $mult1+=$user_dress["mfhitp"];
  if ($mf['prof']) $mult+=$user_dress["mf".$mf['prof']];
  if ($mf['prof1']) $mult1+=$user_dress["mf".$mf['prof1']];
  $mf['udar']*=$mult/100+1;
  $mf['udar1']*=$mult1/100+1;
  $mf['maxudar']*=$mult/100+1;
  $mf['maxudar1']*=$mult1/100+1;

  if (BATTLEDEBUG) $debstr.="Increased: ".$mf["udar"]."<br>";


  if ($user['sila']>=25) $bmfud+=1;
  if ($user['sila']>=50) $bmfud+=2;

  $mf['udar']+=$bmfud;
  $mf['udar1']+=$bmfud;

  $b1=mt_rand($enemy_dress[5+$attack]/3,$enemy_dress[5+$attack]);
  $b2=mt_rand($enemy_dress[5+$attack1]/3,$enemy_dress[5+$attack1]);

  if ($enemy["id"]<_BOTSEPARATOR_ && $user["id"]<_BOTSEPARATOR_) {
    $b1=$b1/2;
    $b2=$b2/2;
  }


  $mf["kritudar"]=$mf["udar"];
  $mf["kritudar1"]=$mf["udar1"];
  $mf["maxkritudar"]=$mf["maxudar"];
  $mf["maxkritudar1"]=$mf["maxudar1"];

  $debstr.="krit: $mf[kritudar] ($mf[maxkritudar])<br>";
  $mf['udarskiparmor']=$mf["udar"];
  $mf['udarskiparmor1']=$mf["udar1"];
  $mf['udar']-=$b1;
  $mf['udar1']-=$b2;
  $mf['maxudar']-=$b1;
  $mf['maxudar1']-=$b2;
  $debstr.="bron: $b1/$b2<br>";

  $debstr.="mfdhit: $enemy_dress[mfdhit] => ";

  $hemfd=pow(0.5,$enemy_dress["mfdhit"]/250);
  if ($enemy_dress["mfdhit"]>250) $hemfdsa=pow(0.5,($enemy_dress["mfdhit"]-250)/250);
  else $hemfdsa=1;

  if (BATTLEDEBUG) $debstr.=" * $hemfd ";

  $mf['udar']*=$hemfd;
  $mf['udar1']*=$hemfd;
  $mf['udarskiparmor']*=$hemfdsa;
  $mf['udarskiparmor1']*=$hemfdsa;
  $mf['maxudar']*=$hemfd;
  $mf['maxudar1']*=$hemfd;

  $mf["kritudar"]*=$hemfd;
  $mf["kritudar1"]*=$hemfd;
  $mf["maxkritudar"]*=$hemfd;
  $mf["maxkritudar1"]*=$hemfd;


  $debstr.=$mf["udar"]."<br>";


  //$b1=pow(0.5,$enemy_dress[5+$attack]/100);
  //$b2=pow(0.5,$enemy_dress[5+$attack1]/100);
  //$mf['udar']*=$b1;
  //$mf['udar1']*=$b2;





  //$mf["kritudar"]+=$mf["udar"];//+rand(0,$mf["kritudar"])
  //$mf["kritudar1"]+=$mf["udar1"];//+rand(0,$mf["kritudar1"])

  $deltaproboj=($mf["kritudar"]-$mf['udar'])*($user_dress["mfproboj"]);
  if ($mf['udar']<0) $mf['udar']=0;
  $mf['udar']=($mf['udar']<0?0:$mf['udar'])+$deltaproboj;

  $deltaproboj=($mf["maxkritudar"]-$mf['maxudar'])*($user_dress["mfproboj"]);
  if ($mf['maxudar']<0) $mf['maxudar']=0;
  $mf['maxudar']=($mf['maxudar']<0?0:$mf['maxudar'])+$deltaproboj;

  $debstr.="Proboj: $deltaproboj ($user_dress[mfproboj])<br>";

  $deltaproboj=($mf["kritudar1"]-$mf['udar1'])*($user_dress["mfproboj1"]);
  if ($mf['udar1']<0) $mf['udar1']=0;
  $mf['udar1']=($mf['udar1']<0?0:$mf['udar1'])+$deltaproboj;

  $deltaproboj=($mf["maxkritudar1"]-$mf['maxudar1'])*($user_dress["mfproboj1"]);
  if ($mf['maxudar1']<0) $mf['maxudar1']=0;
  $mf['maxudar1']=($mf['maxudar1']<0?0:$mf['maxudar1'])+$deltaproboj;


  if($mf['udar'] < 1) { $mf['udar'] = 1; }
  if($mf['udar1'] < 1) { $mf['udar1'] = 1; }

  if($mf['maxudar'] < 1) { $mf['maxudar'] = 1; }
  if($mf['maxudar1'] < 1) { $mf['maxudar1'] = 1; }


  $mf["kritudarskiparmor"]=$mf["udarskiparmor"]+$mf["kritudar"];
  $mf["kritudarskiparmor1"]=$mf["udarskiparmor1"]+$mf["kritudar1"];

  $mf["kritudar"]=$mf["udar"]+$mf["kritudar"];
  $mf["kritudar1"]=$mf["udar1"]+$mf["kritudar1"];

  $mf["maxkritudar"]=$mf["maxudar"]+$mf["maxkritudar"];
  $mf["maxkritudar1"]=$mf["maxudar1"]+$mf["maxkritudar1"];

  //$mf["kritudar"]+=$mf["udar"]/2;
  //$mf["kritudar1"]+=$mf["udar1"]/2;
  $debstr.=" Kritpow: $enemy_dress[mfkritpow]/$user_dress[mfantikritpow]<br>";
  $hs=substractmf($enemy_dress["mfkritpow"], $user_dress["mfantikritpow"], 0.25);

  $debstr.="Krit before anti: $mf[kritudar] ($hs)<br>";

  if ($mf['kritudar']*$hs<$mf["udar"]) {
    $mf["kritudar"]=$mf["udar"];
    $mf["kritudar1"]=$mf["udar1"];
  } else {
    $mf["kritudar"]*=$hs;
    $mf["kritudar1"]*=$hs;
  }


  $debstr.="Krit: $mf[kritudar]<br>";

  if ($mf["kritudar"]<$mf["udar"]*2) $mf["kritudar"]=$mf["udar"]*2;
  if ($mf["kritudar1"]<$mf["udar1"]*2) $mf["kritudar1"]=$mf["udar1"]*2;
  //if ($mf["kritudar"]>$mf["udar"]*4) $mf["kritudar"]=$mf["udar"]*4;
  //if ($mf["kritudar1"]>$mf["udar1"]*4) $mf["kritudar1"]=$mf["udar1"]*4;
  //echo "<pre>";
  //foreach ($this->user_dress as $k=>$v) {
  //  echo "$k: $v/".$this->enemy_dress[$k]."\r\n";
  //}
  //die;
  $debstr.="Final krit: $mf[kritudar]/$mf[kritudar1]<br>";
  $debstr.="Final hit: $mf[udar]/$mf[udar1]<br>";
  if ($mf["krit"]<2) $mf["krit"]=0;
  if (BATTLEDEBUG) echo "$debstr<br>";

  $ff=$this->getforcefield($enemy["id"]);
  if ($ff["value"]>0) $mf["krit"]=0;

  return $mf;
}

function addextramf(&$user, &$user_dress, $hasshit) {

  if($user["id"] < _BOTSEPARATOR_) {
    if ($user["lovk"]>=125) {
      $user_dress["mfakrit"]+=40;
      $user_dress["mfuvorot"]+=105;
      $user_dress["mfparir"]+=15;
    } elseif ($user["lovk"]>=100) {
      $user_dress["mfakrit"]+=40;
      $user_dress["mfuvorot"]+=105;
      $user_dress["mfparir"]+=15;
    } elseif ($user["lovk"]>=75) {
      $user_dress["mfakrit"]+=15;
      $user_dress["mfuvorot"]+=35;
      $user_dress["mfparir"]+=15;
    } elseif ($user["lovk"]>=50) {
      $user_dress["mfakrit"]+=15;
      $user_dress["mfuvorot"]+=35;
      $user_dress["mfparir"]+=5;
    } elseif ($user["lovk"]>=25) {
      $user_dress["mfparir"]+=5;
    }

    if ($user["inta"]>=125) {
      $user_dress["mfkrit"]+=105;
      $user_dress["mfauvorot"]+=45;
      $user_dress["mfkritpow"]+=25;
    } elseif ($user["lovk"]>=100) {
      $user_dress["mfkrit"]+=105;
      $user_dress["mfauvorot"]+=45;
      $user_dress["mfkritpow"]+=25;
    } elseif ($user["lovk"]>=75) {
      $user_dress["mfkrit"]+=35;
      $user_dress["mfauvorot"]+=15;
      $user_dress["mfkritpow"]+=25;
    } elseif ($user["lovk"]>=50) {
      $user_dress["mfkrit"]+=35;
      $user_dress["mfauvorot"]+=15;
      $user_dress["mfkritpow"]+=10;
    } elseif ($user["lovk"]>=25) {
      $user_dress["mfkritpow"]+=10;
    }

    if ($user["sila"]>=125) {
      $user["minimax"]["minu"]+=10;
      $user["minimax"]["maxu"]+=10;
      $user["minimax1"]["minu"]+=10;
      $user["minimax1"]["maxu"]+=10;
      $user_dress["mfhitp"]+=25;
    } elseif ($user["lovk"]>=100) {
      $user_dress["mfhitp"]+=25;
    } elseif ($user["lovk"]>=75) {
      $user_dress["mfhitp"]+=17;
    } elseif ($user["lovk"]>=50) {
      $user_dress["mfhitp"]+=10;
    } elseif ($user["lovk"]>=25) {
      $user_dress["mfhitp"]+=5;
    }



    if ($user["vinos"]>=125) {
      $user_dress["mfdhit"]+=25;
    }
  }

  $user_dress["mfdmag"]+=$user["vinos"]*1.5;

  $user_dress["mfproboj"]+=5;

  $user_dress["mfproboj1"]=$user_dress["mfproboj"]-$user["minimax"]["mfproboj"];
  $user_dress["mfproboj"]=$user_dress["mfproboj"]-$user["minimax2"]["mfproboj"];

  $user_dress["mfproboj"]=mftoabs($user_dress["mfproboj"],100);
  $user_dress["mfproboj1"]=mftoabs($user_dress["mfproboj1"],100);

  $user_dress["mfcontr"]=mftoabs($user_dress["mfcontr"],100)*100;
  $user_dress["mfcontr"]+=10;
  if ($user_dress["mfcontr"]>80) $user_dress["mfcontr"]=80;



  $user_dress["mfparir"]=mftoabs($user_dress["mfparir"],100);
  $user_dress["mfparir"]+=10;
  if ($user_dress["mfparir"]>80) $user_dress["mfcontr"]=80;

  $user_dress["mfshieldblock"]=mftoabs($user_dress["mfshieldblock"],100);
  if ($user_dress["mfshieldblock"]>80) $user_dress["mfshieldblock"]=80;

  if (!$hasshit) $user_dress["mfshieldblock"]=0;

  $user_dress["mfantikritpow"]+=$user["vinos"]/2;

  $user_dress["mfdhit"]+=$user["vinos"]*1.5;
  $bmfbron=0;
  $bmfkrit=0;
  $bmfakrit=0;
  $bmfuv=0;
  $bmfauv=0;
  /*
  if ($user['lovk']>=25) $bmfauv+=25;
  if ($user['lovk']>=50) $bmfuv+=25;
  if ($user['inta']>=25) $bmfakrit+=25;
  if ($user['inta']>=50) $bmfkrit+=25;
  if ($user['vinos']>=25) $bmfbron+=2;
  if ($user['vinos']>=50) $bmfbron+=4;*/

  $chpercbron=floor($bmfbron/100*30);
  $bmfbron += $user["zo"][0]>0 ? $chpercbron:0;//свиток защиты !

  $user_dress[6]+=$bmfbron;
  $user_dress[7]+=$bmfbron;
  $user_dress[8]+=$bmfbron;
  $user_dress[9]+=$bmfbron;
  $user_dress[10]+=$bmfbron;


  $user_dress["mfakrit"]+=$user['inta']*5;
  $user_dress["mfkrit"]+=$user['inta']*5;

  $user_dress["mfuvorot"]+=$user['lovk']*5;
  $user_dress["mfauvorot"]+=$user['lovk']*5;

  $user_dress[2]=$user_dress["mfkrit"];
  $user_dress[3]=$user_dress["mfakrit"];

  $user_dress[4]=$user_dress["mfuvorot"];
  $user_dress[5]=$user_dress["mfauvorot"];

  /*$user_dress[2]+=$user['inta']*5+$bmfkrit;
  $user_dress[3]+=$user['inta']*5+$bmfakrit;

  $user_dress[4]+=$user['lovk']*5+$bmfuv;
  $user_dress[5]+=$user['lovk']*5+$bmfauv;*/
}

function solve_mf($enemy,$myattack,$myattack1, $short=0) {

  $mf = array ();
  if (count($this->enemy_dress)==0) {
    if($enemy > _BOTSEPARATOR_) {
      $bots = mysql_fetch_array(mysql_query ('SELECT * FROM `bots` WHERE `id` = '.$enemy.' LIMIT 1;'));
      $this->enemyhar = mysql_fetch_array(mysql_query('SELECT * FROM `users` WHERE `id` = \''.$bots['prototype'].'\' LIMIT 1;'));
      $this->enemy_dress = mysql_fetch_array(mysql_query('SELECT sum(minu) as minu, sum(maxu) as maxu, sum(mfkrit) as mfkrit, sum(mfakrit) as mfakrit, sum(mfuvorot) as mfuvorot, sum(mfauvorot) as mfauvorot, sum(bron1) as bron1, sum(bron2) as bron2, sum(bron2) as bron22, sum(bron3) as bron3, sum(bron4) as bron4, sum(mfkritpow) as mfkritpow, sum(mfantikritpow) as mfantikritpow, sum(mfparir) as mfparir, sum(mfshieldblock) as mfshieldblock, sum(mfcontr) as mfcontr, sum(mfdhit) as mfdhit, sum(mfhitp) as mfhitp, sum(mfkol) as mfkol, sum(mfrej) as mfrej, sum(mfrub) as mfrub, sum(mfdrob) as mfdrob, sum(mfproboj) as mfproboj, sum(mfdmag) as mfdmag FROM `inventory` WHERE `dressed`=1 AND `owner` = \''.$bots['prototype'].'\' LIMIT 1;'));
      $this->enemyhar['hp'] = $bots['hp'];
      $this->enemyhar["id"]=$enemy;
    } else {
      $this->enemyhar = mysql_fetch_array(mysql_query('SELECT * FROM `users` WHERE `id` = \''.$enemy.'\' LIMIT 1;'));
      $this->enemy_dress = mysql_fetch_array(mysql_query('SELECT sum(minu) as minu, sum(maxu) as maxu, sum(mfkrit) as mfkrit, sum(mfakrit) as mfakrit, sum(mfuvorot) as mfuvorot, sum(mfauvorot) as mfauvorot, sum(bron1) as bron1, sum(bron2) as bron2, sum(bron2) as bron22, sum(bron3) as bron3, sum(bron4) as bron4, sum(mfkritpow) as mfkritpow, sum(mfantikritpow) as mfantikritpow, sum(mfparir) as mfparir, sum(mfshieldblock) as mfshieldblock, sum(mfcontr) as mfcontr, sum(mfdhit) as mfdhit, sum(mfhitp) as mfhitp, sum(mfkol) as mfkol, sum(mfrej) as mfrej, sum(mfrub) as mfrub, sum(mfdrob) as mfdrob, sum(mfproboj) as mfproboj, sum(mfdmag) as mfdmag FROM `inventory` WHERE `dressed`=1 AND `owner` = \''.$enemy.'\' LIMIT 1;'));
    }
    $effs=mqfa("select sum(mfdmag) as mfdmag, sum(mfdhit) as mfdhit from effects where owner='".$enemy."' and time>".time());
    foreach ($effs as $k=>$v) $this->enemy_dress["$k"]+=$v;
  }
  if (count($this->user_dress)==0) {
    $this->user_dress = mysql_fetch_array(mysql_query('SELECT sum(minu) as minu, sum(maxu) as maxu, sum(mfkrit) as mfkrit, sum(mfakrit) as mfakrit, sum(mfuvorot) as mfuvorot, sum(mfauvorot) as mfauvorot, sum(bron1) as bron1, sum(bron2) as bron2, sum(bron2) as bron22, sum(bron3) as bron3, sum(bron4) as bron4, sum(mfkritpow) as mfkritpow, sum(mfantikritpow) as mfantikritpow, sum(mfparir) as mfparir, sum(mfshieldblock) as mfshieldblock, sum(mfcontr) as mfcontr, sum(mfdhit) as mfdhit, sum(mfhitp) as mfhitp, sum(mfkol) as mfkol, sum(mfrej) as mfrej, sum(mfrub) as mfrub, sum(mfdrob) as mfdrob, sum(mfproboj) as mfproboj, sum(mfdmag) as mfdmag FROM `inventory` WHERE `dressed`=1 AND `owner` = \''.$this->user['id'].'\''));
    $effs=mqfa("select sum(mfdmag) as mfdmag, sum(mfdhit) as mfdhit from effects where owner='".$this->user["id"]."' and time>".time());
    foreach ($effs as $k=>$v) $this->user_dress["$k"]+=$v;
  }

  $this->user["minimax"] = mysql_fetch_array( mysql_query('SELECT minu,maxu, mfproboj FROM `inventory` WHERE `id` = \''.$this->user['weap'].'\' LIMIT 1;'));
  $this->user["minimax2"] = mysql_fetch_array( mysql_query('SELECT minu,maxu, mfproboj FROM `inventory` WHERE `id` = \''.$this->user['shit'].'\' AND `second`=1 LIMIT 1;'));

  $this->enemyhar["minimax"]=mqfa("select minu, maxu, mfproboj from inventory where id='".$this->enemyhar["weap"]."'");
  $this->enemyhar["minimax2"]=mqfa("select minu, maxu, mfproboj from inventory where id='".$this->enemyhar["shit"]."'");

  $this->user["zo"]=mysql_fetch_row(mysql_query("SELECT id FROM effects WHERE type=201 AND owner=".$this->user["id"]." LIMIT 1;"));
  $this->enemyhar["zo"]=mysql_fetch_row(mysql_query("SELECT id FROM effects WHERE type=201 AND owner=".$this->enemyhar['id']." LIMIT 1;"));

  $this->addextramf($this->user, $this->user_dress, $this->user_hasshit);
  $this->addextramf($this->enemyhar, $this->enemy_dress, $this->enemy_hasshit);

  if ($this->user["mudra"]>=125) $this->enemy_dress["mfdmag"]*=0.97;
  if ($this->enemyhar["mudra"]>=125) $this->user_dress["mfdmag"]*=0.97;

  if ($short) return;

  //БОНУСЫ!
  $this->user["sokr"]=mysql_fetch_row(mysql_query("SELECT id FROM effects WHERE type=202 AND owner=".(int)$this->user['id']." LIMIT 1;"));
  $this->enemyhar["sokr"]=mysql_fetch_row(mysql_query("SELECT id FROM effects WHERE type=202 AND owner=".(int)$this->enemyhar['id']." LIMIT 1;"));


  $_tmp=$this->user_dress["mfparir"]-($this->enemy_dress["mfparir"]/2);
  $this->enemy_dress["mfparir"]-=$this->user_dress["mfparir"]/2;
  $this->user_dress["mfparir"]=$_tmp;

  if ($this->user_dress["mfparir"]>50) $this->user_dress["mfparir"]=50;
  if ($this->user_dress["mfparir"]<1) $this->user_dress["mfparir"]=1;

  if ($this->enemy_dress["mfparir"]>50) $this->enemy_dress["mfparir"]=50;
  if ($this->enemy_dress["mfparir"]<1) $this->enemy_dress["mfparir"]=1;

  /*if ($this->enemyhar['sila']>=25) $bmfud1+=1;
  if ($this->enemyhar['sila']>=50) $bmfud1+=2;
  if ($this->enemyhar['lovk']>=25) $bmfauv1+=25;
  if ($this->enemyhar['lovk']>=50) $bmfuv1+=25;
  if ($this->enemyhar['inta']>=25) $bmfakrit1+=25;
  if ($this->enemyhar['inta']>=50) $bmfkrit1+=25;
  if ($this->enemyhar['vinos']>=25) $bmfbron1+=2;
  if ($this->enemyhar['vinos']>=50) $bmfbron1+=4;*/
  //*************








  mt_srand(time());

  $mf["me"]=$this->getmf($this->user, $this->enemyhar, $this->user_dress, $this->enemy_dress, $myattack, $myattack1);




  $mf["he"]=$this->getmf($this->enemyhar, $this->user, $this->enemy_dress, $this->user_dress, $this->battle[$enemy][$this->user['id']][0], $this->battle[$enemy][$this->user['id']][0]);



  $mf["me"]["udar"]=ceil($mf["me"]["udar"]);
  $mf["me"]["udar1"]=ceil($mf["me"]["udar1"]);
  $mf["he"]["udar"]=ceil($mf["he"]["udar"]);
  $mf["he"]["udar1"]=ceil($mf["he"]["udar1"]);
  $mf["me"]["kritudar"]=ceil($mf["me"]["kritudar"]);
  $mf["me"]["kritudar1"]=ceil($mf["me"]["kritudar1"]);
  $mf["he"]["kritudar"]=ceil($mf["he"]["kritudar"]);
  $mf["he"]["kritudar1"]=ceil($mf["he"]["kritudar1"]);
  if($enemy > _BOTSEPARATOR_) {
      $mf['he']['krit'] -= 6;
  }
  //$mf["me"]["krit"]=100;
  if (SHOWSOLVEDMF) {
    echo "<pre>";
    print_r($mf);
    if (DIEAFTERSOLVEDMF) die;
  }
  return $mf;
}

/*------------------------------------------------------------------
 сейвим бой
--------------------------------------------------------------------*/
            function update_battle () {
                return mysql_query('UPDATE `battle` SET `exp` = \''.serialize($this->exp).'\', `teams` = \''.serialize($this->battle).'\', `damage` = \''.serialize($this->damage).'\' WHERE `id` = '.$this->battle_data['id'].' ;');
            }
/*------------------------------------------------------------------
 генератор фраз комментатора
--------------------------------------------------------------------*/
            function get_comment () {
                $boycom = array (
                    'А танцуешь ты лучше.',
'А мы что, в прятки тут играем?',
'А вы разве пингвинов никогда не видели?',
'А, ведь когда-то, вы были красивыми… А теперь? Ну и рожи! Жуть!',
'А потом еще труп пинать будут.',
'А я вчера ночью за соседями подглядывал. Они точно так же кувыркались',
'А ведь вы живых людей дубасите...',
'А вот я вчера в зоопарке был...',
'А вы в стройбате не служили?',
'А вы видели, чтобы так на улице делали!?',
'А вы знали что ёжики размножаются в интернете?',
'А жить-то, как хочется:',
'А из-за чего вы собственно дерётесь?',
'А чего ржёте, вы ещё остальных не видели',
'А что произойдёт если ты испугаешся до полусмерти дважды?!',
'Больше так не делай. Ты же не садист?',
'Без комментариев...',
'Больно ведь!',
'Быстро ты за монитор спрятался!',
'Все хотят попасть в рай, но никто не хочет умирать!',
'Вчера с такой девчонкой познакомился.',
'Всего 5 минут знакомы, а дерутся, словно супруги с 20-ти летним стажем...',
'Все. Я так больше не могу.',
'В конце концов, кто-то победит?',
'Вы чего, с дерева упали? ',
'Возятся как сонные мухи... давайте я вам лучше анекдот расскажу: ...',
'Вот видишь, как полезно чистить зубы на ночь?',
'Вот вы все руками махаете, а за вами уже очередь',
'Вот попадёте вы в плен и вас там будут долго бить. Но вы ничего не расскажете... и не потому, что вы такой стойкий, просто вы ничего не знаете',
'Вы бы лучше пошли потренировались!',
'Вы все еще разминаетесь? Позовите, когда кости в муку друг другу разминать будете.',
'Вы же бойцы! Имейте совесть!',
'Гаси недоумка!',
'Да, если бы я смог это остановить, то получил бы нобелевскую премию "За мир" ',
'Да куда они бьют?!',
'Давайте быстрее! За вами уже очередь образовалась.',
'Давайте обойдемся сегодня таймаутом. А? А то мне уже кошмары скоро будут сниться.',
'Дерутся как девчонки!',
'Дети, посмотрите налево... Ой!.. Нет, туда лучше не смотреть.',
'Если так будет продолжаться, то скоро мы заснем!',
'Если бы у меня было кресло-качалка, я бы в нём качался...',
'Если вы что-то сказать хотите, то лучше молчите :)',
'Жестокость не порок.',
'Жизнь вне нашего клуба - это пустая трата кислорода!!!',
'Жми! Дави! Кусай! Царапай!',
'За такие бои надо в хаос отправлять!',
'Знаете откуда в комиссионном магазине столько вещей? Это я после ваших гулянок собираю и сдаю туда. Иногда вместе с частями тела, застрявшими в них.',
'Здесь люди так близки друг к другу. Просто иначе ударить нельзя.',
'И пролитая кровь еще пульсирует...',
'Инвалидов развелось...',
'Какой бой!!!',
'Какой боец, такой конец',
'Кто!? Кто здесь?!',
'Кто вас этому научил?',
'Кузнечик, блин...',
'Куплю импортный проигрыватель грампластинок.',
'Лошадью ходи!',
'Лучше враг, чем друг - враг.',
'Ладно, вы тут пока друг друга за волосы таскайте, а я пойду, пообедаю.',
'Мне ваш балет уже надоел!',
'Может, начнется-таки настоящий бой???',
'Мысли лезут в голову изнутри, а удары снаружи.',
'Ну и где ваши коронные удары? Где живописные падения я спрашиваю!',
'Ну, нельзя же так наотмашь лупить!',
'Надо раньше было думать, теперь смертельно поздно...',
'На такое зрелище билеты продавать можно. Народ ухохочется!',
'Нет! Не надо драки! А... ладно деритесь, все равно не умеете.',
'Нет, ну должен быть повод, должен же быть повод?',
'Нет, я отказываюсь это комментировать!',
'Не таких обламывали!',
'Ну выпили вы рюмку, ну две... ну литр, ну два... так зачем же после этого драку затевать?!',
'Ну и кто за этот погром платить будет?',
'Ну и оскал у вас. Из вашей улыбки кастеты делать можно.',
'Ну, что же ты..? Не печалься. Выше голову, так по ней удобней попасть.',
'Ничего... Блок тоже удар.',
'Обернись!!!.... Поздно...',
'Ого! Научите меня так не делать.',
'Осторожно! Сделаешь дырочку, уже не запломбируешь!',
'Оно вам надо???',
'Обычное дело...там что-то отклеилось.',
'Ой, и заболтался я с вами...',
'Он же не промахнётся если ты не отойдёшь!',
'По-моему, кому-то светит инвалидность.',
'Подкинь ему грабли, на которые он еще не наступал.',
'Прав был кот Леопольд, давайте жить дружно?',
'При ударе в живот нарушается кислотно-щелочной баланс.',
'Проверь, не торчит ли у тебя нож из живота.',
'Перестаньте мне орать!',
'Подкинь ему грабли, на которые он еще не наступал.',
'Прыгают тут как блохи... Все, я пошел за дихлофосом!',
'Разбудите меня когда эта порнография закончится...',
'Ребенок сильнее ударил бы!',
'Славно вмазал!',
'Славно они веселятся',
'Смотрю вот на вас, и слезы наворачиваются.',
'Сначала учатся ходить, а потом только в драку лезут.',
'Так они друг другу что-нибудь сломают.',
'Так ты ему все кости переломаешь!',
'У меня в подъезде точно так же соседа отмудохали',
'Убогих развелось...',
'Ух ты, какой прыткий!',
'Фашист!! Надо ж, так по больному месту врезать...',
'Хватит бить его об угол моей кабинки! Мне же потом ее чинить.',
'Хулиганы, прекратите немедленно!',
'Хочешь, подскажу, куда он ударит?',
'Хорошо, что у меня ловкости больше чем у вас всех, а то б вы и меня в инвалидную коляску посадили бы.',
'Хороший бой!',
'Хороший удар!',
'Хиляк-разрядник!',
'Что ты его за волосы схватил?! Отпусти немедленно!',
'Щас я вас настигну, вот тогда мы и похохочем',
'Это была какая-то неизвестная мне техника...',
'Это же противник, а не глина! Хватит мяться!',
'Это не бой, это издевательское избиение.',
'Это поубавит спеси',
'Это и был твой план "Б" ?',
'Это была какая-то неизвестная мне техника...',
'Я же предупреждал, - будет больно.',
'Я не страдаю безумием. Я наслаждаюсь им каждую минуту :)',
'Я красивый, я сильный, я умный, я добрый. А вот вы? Вы себя-то видели?!',
'Я тоже умею драться, но не буду...',
'(тревожно озираясь) я вам по секрету скажу... за вами наблюдают!',
'<вырезано цензурой> после боя я этих <вырезано цензурой> обоих в <вырезано цензурой> и <вырезано цензурой>',
'<вырезано цензурой> каратисты фиговы');

                // рандомайзим и шансуем ;)
                if (rand(0,3)==1) {
                    return '<span class=date>'.date("H:i").'</span> <i>Комментатор: '.$boycom[rand(0,count($boycom)-1)].'</i><BR>';
                }
                else {
                    return false;
                }
            }
/*------------------------------------------------------------------
 есть ли тайм в советском союзе?
--------------------------------------------------------------------*/
            function get_timeout () {
                if($this->battle) {
                    if ($this->my_class=='B1') {
                        if($this->to2 <= $this->to1) {
                            return ((time()-$this->to2) > $this->battle_data['timeout']*60);
                        } else {
                            return false;
                        }
                    } else {
                        if($this->to2 >= $this->to1) {
                            return ((time()-$this->to1) > $this->battle_data['timeout']*60);
                        } else {
                            return false;
                        }
                    }
                }
            }
/*-------------------------------------------------------------------
  работа с логами
--------------------------------------------------------------------*/
            function add_log ($text) {

                        $this->log .= $text;
            }

            function write_log () {
if($this->log){$this->log=$this->log."<hr>";}


                //mysql_query('UPDATE `logs` SET `log` = CONCAT(`log`,\''.$this->log.'\') WHERE `id` = '.$this->user['battle'].'');

                $fp = fopen ("backup/logs/battle".$this->user['battle'].".txt","a"); //открытие
                flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
                fputs($fp , $this->log); //работа с файлом
                fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
                flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
                fclose ($fp); //закрытие
                $this->log = '';
            }

            function write_stat ($text) {
                $fp = fopen ("backup/stat/battle".$this->user['battle'].".txt","a"); //открытие
                flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
                fputs($fp , $text."\n"); //работа с файлом
                fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
                flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
                fclose ($fp); //закрытие
            }
            function write_stat_block ($text) {
                $fp = fopen ("backup/stat/battle_block".$this->user['battle'].".txt","a"); //открытие
                flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
                fputs($fp , $text."\n"); //работа с файлом
                fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
                flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
                fclose ($fp); //закрытие
            }

            function add_debug ($text) {
                $this->log_debug .= $text;
            }

            function write_debug () {
                //mysql_query('UPDATE `logs` SET `log` = CONCAT(`log`,\''.$this->log.'\') WHERE `id` = '.$this->user['battle'].'');
echo $this->log_debug;

                $fp = fopen ("backup/debug/battle".$this->user['battle'].".txt","a"); //открытие
                flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
                fputs($fp , $this->log_debug) ; //работа с файлом
                fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
                flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
                fclose ($fp); //закрытие
                $this->log_debug = '';

//die();
            }


    }

// ========================================================================================================================================================
// конец исполняемого кода битвы
//=========================================================================================================================================================
$fbattle = new fbattle($user['battle']);
if (@$_REQUEST['special']) {
  if (@$strokes[$_REQUEST['special']]->target) {
    $i=mqfa1("select id from bots where name='$_POST[main]' and battle='".$fbattle->battle_data["id"]."'");
    if (!$i) $i=mqfa1("select id from users where login='$_POST[main]'");
    if (!$i) {
      echo "<b><font color=red>Персонаж $_POST[main] на найден.</b></font>";
      $_REQUEST['special']=0;
    } elseif ($strokes[$_REQUEST['special']]->target=="enemy") {
      if (!in_array($i, $fbattle->team_enemy)) {
        $i=0;
        $_REQUEST['special']=0;
        echo "<b><font color=red>Этот приём нельзя использовать на своего.</b></font>";
      }
      if (@$fbattle->battle[$i]) {
        $fbattle->enemy=$i;
        $_SESSION['enemy']=$i;
      }
    } elseif ($strokes[$_REQUEST['special']]->target=="ally") {
      if (in_array($i, $fbattle->team_enemy)) {
        $i=0;
        $_REQUEST['special']=0;
        echo "<b><font color=red>Этот приём нельзя использовать на врага.</b></font>";
      }
      if (@$fbattle->battle[$i]) {
        $stroketarget=$i;
      }
      if (!$stroketarget) {
        echo "<b><font color=red>Персонаж не участвует в бою или уже умер.</font>";
        $_REQUEST['special']=0;
      }
    }
    if (@$strokes[$_REQUEST['special']]->move && $fbattle->battle[$user['id']][$_SESSION['enemy']][0]) {
      echo "<b><font color=red>Персонаж $_POST[main] ещё не ответил.</b></font>";
      $_REQUEST['special']=0;
      $_SESSION['enemy']=$fbattle->select_enemy();;
      $fbattle->enemy=$_SESSION['enemy'];
    }
  }
}

if (@$_REQUEST['special'] && $user["hp"]>0) {
  include_once("incl/strokedata.php");
  $priem2=str_replace(array('"',"'","\\"),array('','',''),$_REQUEST['special']);

  $res=mysql_query("select slot,id_thing from puton where id_person='".$_SESSION['uid']."' and slot>=201 and slot<=210;");

  while ($s=mysql_fetch_array($res)) {
    $res4=mysql_fetch_array(mysql_query("select priem from priem where id_priem='".$s['id_thing']."';"));
    $puton[$s['slot']]=$res4['priem'];
  }

  $igogo=new ActivePriems($_SESSION['uid']);

  for ($i=201;$i<=210;$i++) {
    if($puton[$i]==$priem2){$priem=$priem2; break;}
  }

  $have_priem=true;$p=&new prieminfo(0,$priem);

  if ($have_priem) {
    # проверить можно ли
    $enable=true;
    # проверить по статам
    if ($p->checkbattlehars(@$myinfo,$hit,$krit,$parry,$counter,$block,$s_duh,$hp)) {

      # можно ипользовать если: прошел срок wait - это в случае если задан wait в параметрах приема
      $act=&$igogo->priems[$priem];
      if ($p->wait) {
        if ($act['wait']>0) {
          $enable=false;echo "<font color=red>нельзя использовать: еще идет задержка </font>";
        }
        if ($act['active']!=1) {
          $enable=false;echo "<font color=red>нельзя использовать: уже активен</font>";
        }
      }else{
       if ($act['active']!=1) {$enable=false;echo "<font color=red>нельзя использовать: уже активен</font>";}
      }
    }else{
      $enable=false;echo "<font color=red>нельзя использовать: не хватает требований</font>";
    }
    if ($enable) {
      $ok=false;
      if (@$strokes[$ch_priem[$priem]]) $ok=true;
      switch ($priem) {
        case 'block_addchange':$ok=true;
      }
      if ($strokes[$priem]) $ok=true;
      if ($ok) {
        #1) $act['active'] - активен -> UPDATE
        #2) $act['active']<1 - неактивен НО есть $act['uses']>0 -> UPDATE
        #3) $act['uses'] <1 -> INSERT
        if ($act['uses']>0) {
          mysql_query("update person_on set pr_cur_uses=pr_cur_uses+1".($p->wait?',wait='.$p->wait:'')."
          WHERE id_person='".$_SESSION['uid']."' and type=3 and pr_name='".$priem."'");
        }
        /////здесь будут заюзываться приемы/////
        $emptyhit=0;
        include 'incl/usepriems.php';
        if (@$strokes[$priem]->refresh) {
          header ("Location:fbattle.php?fd=".$fbattle->enemy);
          //die;
        }
        if(@$_POST['enemy'] > 0 && $emptyhit) {
          // ударяемся
          if($user['room']!=403 && $user['room']!=20){include "astral.php";}
          $fbattle->razmen_init ($_POST['enemy'],$_POST['attack'],$_POST['defend'],$_POST['attack1']);
          $fbattle->update_battle ();
          $fbattle->write_log();
          header ("Location:fbattle.php");
          //die;
        }

/*$myinfo->priems->priems[$priem]['active']=1;
$myinfo->priems->priems[$priem]['uses']++;
# обновить что потратили
db_use('query',"update battle_units set s_duh=".($p->sduh?'s_duh-'.$p->sduh:'s_duh-s_duh*'.(0+$p->sduh_proc)).",
hit=hit-'".(0+$p->n_hit)."',krit=krit-'".(0+$p->n_krit)."',counter=counter-'".(0+$p->n_counter)."',
block=block-'".(0+$p->n_block)."',parry=parry-'".(0+$p->n_parry)."',hp=hp-'".(0+$p->n_hp)."'
WHERE id_person='".$myinfo->id_person."' and id_battle='".$id_battle."'");
$s_duh=$s_duh-($p->sduh?$p->sduh:$s_duh*$p->sduh_proc);
$hit=$hit-$p->n_hit;$krit=$krit-$p->krit;$counter=$counter-$p->n_counter;$block=$block-$p->n_block;
$parry=$parry-$p->n_parry;$hp=$hp-$p->n_hp; */
      }#/ok
    }#enable
  } else {
    echo "<font color=red>нет такого приема на персонаже</font>";
  }
}

$s_duh=$user['s_duh'];$hit=$user['hit'];$krit=$user['krit'];$block=$user['block2'];$parry=$user['parry'];$hp=$user['hp2'];$counter=$user['counter'];

$enemynick=getnick($fbattle->enemy);
?>
<HTML>
<HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<SCRIPT>
<?
if($fbattle->user_hasshit){?>
var def_zones = 'головы, груди и живота;груди, живота и пояса;живота, пояса и ног;пояса, ног и головы;ног, головы и груди'.split(';');
<?}else{?>
var def_zones = 'головы и груди,груди и живота,живота и пояса,пояса и ног,ног и головы'.split(',');
<?}

if($sumwear==2){?>
var attacks =  2;   // кол. атак
<?}else{?>
var attacks =  1;   // кол. атак
<?}?>

</SCRIPT>
<SCRIPT src='i/combats_096_ru.js'></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="i/sl2.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="i/ch.js"></SCRIPT>

<SCRIPT>

function fullfastshow(a,b,c,d,e,f){if(typeof b=="string")b=a.getElementById(b);var g=c.srcElement?c.srcElement:c,h=g;c=g.offsetLeft;for(var j=g.offsetTop;h.offsetParent&&h.offsetParent!=a.body;){h=h.offsetParent;c+=h.offsetLeft;j+=h.offsetTop;if(h.scrollTop)j-=h.scrollTop;if(h.scrollLeft)c-=h.scrollLeft}if(d!=""&&b.style.visibility!="visible"){b.innerHTML="<small>"+d+"</small>";if(e){b.style.width=e;b.whiteSpace=""}else{b.whiteSpace="nowrap";b.style.width="auto"}if(f)b.style.height=f}d=c+g.offsetWidth+10;e=j+5;if(d+b.offsetWidth+3>a.body.clientWidth+a.body.scrollLeft){d=c-b.offsetWidth-5;if(d<0)d=0}if(e+b.offsetHeight+3>a.body.clientHeight+a.body.scrollTop){e=a.body.clientHeight+ +a.body.scrollTop-b.offsetHeight-3;if(e<0)e=0}b.style.left=d+"px";b.style.top=e+"px";if(b.style.visibility!="visible")b.style.visibility="visible"}function fullhideshow(a){if(typeof a=="string")a=document.getElementById(a);a.style.visibility="hidden";a.style.left=a.style.top="-9999px"}

function gfastshow(dsc, dx, dy) { fullfastshow(document, mmoves3, window.event, dsc, dx, dy); }
function ghideshow() { fullhideshow(mmoves3); }





function Prv(logins)
{
    top.frames['bottom'].window.document.F1.text.focus();
    top.frames['bottom'].document.forms[0].text.value = logins + top.frames['bottom'].document.forms[0].text.value;
}
function setattack() {attack=true}
function setdefend() {defend=true}
</SCRIPT>
<script>
            function refreshPeriodic()
            {
                <?if($fbattle->battle) {    ?>location.href='<?=$_SERVER['PHP_SELF']?>?batl=<?=@$_REQUEST['batl']?>';//reload();
                <?}?>
                timerID=setTimeout("refreshPeriodic()",30000);
            }
            <? if ($_SERVER["REMOTE_ADDR"]!="127.0.0.1") echo 'timerID=setTimeout("refreshPeriodic()",30000);'; ?>
</script>
<style type="text/css">
.menu {
  background-color: #d2d0d0;
  border-color: #ffffff #626060 #626060 #ffffff;
  border-style: solid;
  border-width: 1px;
  position: absolute;
  left: 0px;
  top: 0px;
  visibility: hidden;
}

a.menuItem {
  border: 0px solid #000000;
  color: #003388;
  display: block;
  font-family: MS Sans Serif, Arial, Tahoma,sans-serif;
  font-size: 8pt;
  font-weight: bold;
  padding: 2px 12px 2px 8px;
  text-decoration: none;
}

a.menuItem:hover {
  background-color: #a2a2a2;
  color: #0066FF;
}
span {

  FONT-FAMILY: Verdana, Arial, Helvetica, Tahoma, sans-serif;
  text-decoration: none;
  FONT-WEIGHT: bold;
  cursor: pointer;
}
.my_clip_button {   border: 0px solid #000000;
  color: #003388;
  display: block;
  font-family: MS Sans Serif, Arial, Tahoma,sans-serif;
  font-size: 8pt;
  font-weight: bold;
  padding: 2px 12px 2px 8px;
  text-decoration: none; }
.my_clip_button.hover { background-color: #a2a2a2; color: #0066FF; }
</style>

</HEAD>
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=e2e0e0 onLoad="top.setHP(<?=$user['hp']?>,<?=$user['maxhp']?>)">
<?
/*if ($_SESSION["uid"]==7) {
  print_r($fbattle->exp);
  echo "-------------";
}*/
?>
<div id="mmoves3" style="background-color:#FFFFCC; visibility:hidden; z-index: 101; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px;"></div>

<div id=hint3 class=ahint></div>
<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; z-index: 100; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px;"></div>
<FORM action="<?=$_SERVER['PHP_SELF']?>" method=POST name="f1" id="f1" onKeyUp="set_action();">
<TABLE width=100% cellspacing=0 cellpadding=0 border=0>
<input type=hidden value='<?=($user['battle']?$user['battle']:$_REQUEST['batl'])?>' name=batl><input type=hidden value='<?=@$enemy?>' name=enemy1>
<INPUT TYPE=hidden name=myid value="1053012363">
<TR><TD valign=top>
<TABLE width=250 cellspacing=0 cellpadding=0 id="f1t"><TR>
<TD valign=top width=250 nowrap><CENTER>

<?
showpersout($user['id'],1,1,1,1);
?>

</TD></TR>
</TABLE>

</td>
<td  valign=top width=80%>
<?
  switch(@$fbattle->return) {
    case 1 :
      if($fbattle->enemy < _BOTSEPARATOR_){
        $unemli = mysql_fetch_array(mysql_query("SELECT login,id,level,invis FROM `users` WHERE `id` = '".$fbattle->enemy."' LIMIT 1;"));
      } else {
        $unemli = mysql_fetch_array(mysql_query("SELECT name,id,prototype FROM `bots` WHERE `id` = '".$fbattle->enemy."' LIMIT 1;"));
        $lvl_bo = mysql_fetch_array(mysql_query("SELECT id,level,invis FROM `users` WHERE `id` = '".$unemli['prototype']."' LIMIT 1;"));
        if($lvl_bo){$unemli['level']=$lvl_bo['level']; $unemli['id']=$lvl_bo['id'];}else{$unemli['level']=$user['level'];}
        $unemli['login']=$unemli['name'];
      }
    ?>
       <TABLE width=100% cellspacing=0 cellpadding=0><TR><TD colspan=2><h3>Поединок</TD></TR>
       <TR><TD><?echo "<b><font color=#003388>".$user['login']." [".$user['level']."]<a href=inf.php?".$user['id']." target=_blank><IMG SRC=i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"Инф. о ".$user['login']."\"></a></b></font>";?></TD>
<? if(@$unemli['invis']==1) {?>
<TD align=right><?echo "<b><font color=#000>невидимка</b></font>";?></TD>
<?}else{?>
                    <TD align=right><?echo "<b><font color=#003388>".$unemli['login']." [".$unemli['level']."]<a href=inf.php?".$unemli['id']." target=_blank><IMG SRC=i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"Инф. о ".$unemli['login']."\"></a></b></font>";?></TD>
<?}?>
                </TR></TABLE>

                <CENTER>
<?

if($user['level'] > 3) {


    if (@$_GET['use']) {
        $dressed=mysql_fetch_row(mysql_query("SELECT id FROM inventory WHERE id=".(int)$_GET['use']." AND dressed='1'"));
        if ((int)$dressed[0]>0) {
            $my_class = $fbattle->my_class;
            ob_start();
            usemagic($_GET['use'],"".$_POST['target']);
            $bb = explode("<!--",ob_get_clean());
            $bb = str_replace('"',"&quot;",(strip_tags($bb[0])));
            Header("Location: ".$_SERVER['PHP_SELF']."?buf=".$bb);
            }
        else die();
    }

    if (@$_GET['buf']) {
        echo "<font color=red><b>".$_GET['buf']."</b></font><BR>";
    }



    echoscroll('m1'); echoscroll('m2'); echoscroll('m3'); echoscroll('m4'); echoscroll('m5'); echoscroll('m6');
    echoscroll('m7'); echoscroll('m8'); echoscroll('m9'); echoscroll('m10'); echoscroll('m11'); echoscroll('m12');
}
?>

                    <TABLE cellspacing=0 cellpadding=0>
                    <TR>
                        <TD align=center bgcolor=f2f0f0><b>Атака</b></TD>
                        <TD>&nbsp;</TD>
                        <TD align=center bgcolor=f2f0f0><b>Защита</b></TD>
                    </TR>
                    <TR><TD>
<?///ново///?>

<SCRIPT>DrawDots(1);</SCRIPT>
</TD><TD>&nbsp;</TD><TD>
<script>DrawDots(0);</script>


<?/*
                    <TABLE cellspacing=0 cellpadding=0>
                        <TR><TD><INPUT TYPE=radio ID=A1 NAME=attack value=1 onClick="setattack()"><LABEL FOR=A1>удар в голову</LABEL></TD></TR>
                        <TR><TD><INPUT TYPE=radio ID=A2 NAME=attack value=2 onClick="setattack()"><LABEL FOR=A2>удар в корпус</LABEL></TD></TR>
                        <TR><TD><INPUT TYPE=radio ID=A3 NAME=attack value=3 onClick="setattack()"><LABEL FOR=A3>удар в пояс(пах)</LABEL></TD></TR>
                        <TR><TD><INPUT TYPE=radio ID=A4 NAME=attack value=4 onClick="setattack()"><LABEL FOR=A4>удар по ногам</LABEL></TD></TR>

                    </TABLE>
                </TD><TD>&nbsp;</TD><TD>

                <TABLE cellspacing=0 cellpadding=0>
                    <TR><TD><INPUT TYPE=radio ID=D1 NAME=defend value=1 onClick="setdefend()"><LABEL FOR=D1>блок головы и корпуса</LABEL></TD></TR>
                    <TR><TD><INPUT TYPE=radio ID=D2 NAME=defend value=2 onClick="setdefend()"><LABEL FOR=D2>блок корпуса и пояса</LABEL></TD></TR>
                    <TR><TD><INPUT TYPE=radio ID=D3 NAME=defend value=3 onClick="setdefend()"><LABEL FOR=D3>блок пояса и ног</LABEL></TD></TR>
                    <TR><TD><INPUT TYPE=radio ID=D4 NAME=defend value=4 onClick="setdefend()"><LABEL FOR=D4>блок головы и ног</LABEL></TD></TR>
                </TABLE>
*/?>
                </TD></TR>
                <TR>
                    <TD colspan=3 align=center bgcolor=f2f0f0>
<table cellspacing=0 cellpadding=0 width=100%><tr><td><td align=center>
<?
$_SESSION['batl']=$user['battle'];
 ///ново////?>
<script>DrawButtons();</script>
<?/*
&nbsp;<INPUT TYPE=submit name=go value="Вперед !!!" onClick="this.disabled = true; submit();">
*/?>
</td>

<td align=right><a onClick="location.href='<?=$_SERVER['PHP_SELF']?>?batl=<?=@$_REQUEST['batl']?>';"><img src='i/ico_refresh.gif' width=16 height=19 style='cursor:pointer' alt='Обновить'></a></td></tr></table></TD>

                </TR>

                <INPUT TYPE=hidden name=enemy value="<?=$fbattle->enemy?>">
            </TABLE>
<?
$_SESSION['enemy']=$fbattle->enemy;


$res=mysql_query("select slot,id_thing from puton where id_person='".$_SESSION['uid']."' and slot>=201 and slot<=210;");

 while ($s=mysql_fetch_array($res)) {

    $puton[$s['slot']]=$s['slot']; // =new prieminfo($s['id_thing'],0);
    $puton2[$s['slot']]=$s['id_thing'];

  }
$igogo=new ActivePriems($_SESSION['uid']);
?>
<br><script><?
#function DrawRes(SP_HIT, SP_KRT, SP_CNTR, SP_BLK, SP_PRY, SP_HP, SP_SPR, spirit_level){
echo"
DrawRes(".(0+$hit).", ".(0+$krit).", ".(0+$counter).", ".(0+$block).", ".(0+$parry).", ".(0+floor($hp)).", ".(floor($s_duh/100)).", ".str_pad(floor($s_duh/100),strlen($s_duh)+1,'.00',STR_PAD_RIGHT).");
";
#DrawTrick(can_use, img,  txt, free_cast, dsc, resource, select_target, target, target_login, magic_type, name){
#target - friend/enemy/any  друж цель
#free_cast - будет подтверждение
#resource - hit krit counter block parry hp sduh mana zader ispolzovaniy, tratit hod = когда нет freecast
#$myinfo->priems=new ActivePriems($myinfo->id_person);
$inssql="";

//////если есть одетые приемы, то втыкаем их в бой!..
for ($i=201;$i<=210;$i++) {
  $p=&$puton[$i];
  $p2=new prieminfo($puton2[$i],0);
  if ($p) {
    $act=&$igogo->priems[$p2->priem];
    if(!$act){
      if ($inssql) $inssql.=", ";
      $inssql.="( '".$_SESSION['uid']."',
      '".$_SESSION['uid']."', NOW() , 3, ".time().", NULL , '".$p2->priem."',1,0,1, $p2->target)";
    }
  }
}
if ($inssql) mysql_query("INSERT INTO `person_on` ( `id_person` , `id_paladin` , `timestamp` , `type` , `timestamp2` ,
    `comment` , `pr_name` , `pr_active` , `pr_wait_for` , `pr_cur_uses` , `pr_target`) VALUES $inssql");
for ($i=201;$i<=210;$i++) {
  $p=&$puton[$i];
  $p2=new prieminfo($puton2[$i],0);

  if ($p) {
    $act=&$igogo->priems[$p2->priem];
    $enable=true;



  # проверить по статам
  if ($p2->checkbattlehars(@$myinfo /*not used*/,$hit,$krit,$parry,$counter,$block,$s_duh,$hp)) {
    if ($inssql) $igogo=new ActivePriems($_SESSION['uid']);
    $act=&$igogo->priems[$p2->priem];
    # можно ипользовать если: прошел срок wait - это в случае если задан wait в параметрах приема
    if ($p2->wait) {
      if ($act['wait']>0) {
        $enable=false;
      }
      if ($act['active']!=1) {
        $enable=false;
      }
    } else {
      if ($act['active']!=1) $enable=false;
    }
  } else {
    $enable=false;
  }
  # wait если есть активный - вывод сколько еще
  # uses - определить
  echo "DrawTrick(";
  echo ($enable?'1,':'0,').
  "'".$p2->priem."','"
  .$p2->name."',"
  .($p2->hod?0:1).",'"
  .mysql_escape_string($p2->opisan)."','"
  .(0+$p2->n_hit).",".(0+$p2->n_krit).",".(0+$p2->n_counter).",".(0+$p2->n_block).",".(0+$p2->n_parry).",".(0+$p2->n_hp).",".(0+$p2->sduh).",".(0+$p2->mana).",".(0+$p2->wait).",".($p2->wait?($act['wait']>0?$act['wait']:0):0).",".($p2->maxuses?0+$act['uses']:0).",".(0+$p2->maxuses)."',".($p2->target?"1":"0").",'','','".remquotesjs($p2->target==1?"$enemynick":"$user[login]")."','".$p2->priem."');";
} else {
  echo"</script><IMG style=\"\" width=40 height=25 src='/i/misc/icons/clear.gif'><script>";
}
}

unset($i);
echo"</script>";
if($user['zver_id']>0 && !$user["in_tower"] && $fbattle->battle_data["quest"]!=4){
$nb = mysql_fetch_array(mysql_query("SELECT id FROM `bots` WHERE battle='".$fbattle->battle_data["id"]."' and prototype= '".$user['zver_id']."';"));
if($nb){$temn = "style=\"filter:gray(), Alpha(Opacity='70');\""; $ogogo=""; $ogogo2="";}else{$ogogo="<a href=\"?uszver=1\">"; $ogogo2="</a>";$temn="";}
echo "<br>".$ogogo."<img src=i/sh/pet_unleash.gif ".$temn." onmouseout='hideshow();' onmouseover='fastshow(\"<B>Выпустить зверя</B>\")'>".$ogogo2;
}

?>
            </CENTER>
            <?
        break;
        case 2 :
            if(($user['hp']>0) && $fbattle->battle) {
                echo '<FONT COLOR=red>Ожидаем хода противника...</FONT><BR><CENTER><INPUT TYPE=submit value="Обновить" name=',(($user['battle']>0)?"battle":"end"),'><BR></CENTER>';
            }
            elseif($user['hp'] <= 0 && $fbattle->battle) {
                if ($fbattle->battle_data["quest"]==2) {
                  mq("update users set battle=0 where id='$user[id]'");
                  echo '<FONT COLOR=red>Вы выбыли из строя...</FONT><BR><CENTER><INPUT TYPE=button value="Вернуться" onclick="document.location.href=\'main.php\';"><BR></CENTER>';
                } else echo '<FONT COLOR=red>Ожидаем, пока бой закончат другие игроки...</FONT><BR><CENTER><INPUT TYPE=submit value="Обновить" name=',(($user['battle']>0)?"battle":"end"),'><BR></CENTER>';
                ref_drop ($user['id']);

            }
        break;
        case 3 :
            echo "<center><BR>Противник долго не делает свой ход, вы можете закончить бой победителем<BR>
                    <INPUT TYPE=submit value=\"Да, я победил!!!\" name=victory_time_out id=\"refreshb\"><BR>";
                if(!$fbattle->user['in_tower'] && $fbattle->user['room']!=200) {
                    echo "или признать ничью<BR>
                    <INPUT TYPE=submit id=\"refreshb\" value=\"Считаем, что этого боя не было\" name=victory_time_out2><BR>";
                }
            echo "или<BR>
                    <INPUT TYPE=submit value=\"Подождать еще немного\" name=",(($user['battle']>0)?"battle":"end"),">
                    </center>";
        break;
    }

    if(@$enemy == 0){
        // проверяем на вшивость
        if(!$fbattle->battle) {
            if($user['battle']) { $ll = $user['battle'];} elseif($_REQUEST['batl']) { $ll = $_REQUEST['batl']; }else{$ll = $_SESSION['batl'];}
            $data = @mysql_fetch_array(mysql_query ("SELECT damage,exp FROM `battle` WHERE `id` = {$ll}"));
            $damage = unserialize($data['damage']);
            $exp = unserialize($data['exp']);
                        if(empty($damage[$user['id']])){$damage[$user['id']]=0;}
            echo '<CENTER><BR>
                    <B><FONT COLOR=red>Бой закончен! Всего вами нанесено урона: ',$damage[$user['id']],' HP. Получено опыта: ',(int)$exp[$user['id']],'.</FONT></B>
                    <BR><INPUT TYPE=submit value="Вернуться" name="end"><BR></CENTER>';
//mysql_query('UPDATE `users` SET `hp2` = 0,`hp3` = 0,`hit` = 0,`s_duh` = 0,`krit` = 0,`counter` = 0,`block2` = 0,`parry` = 0  WHERE `id` = '.$_SESSION['uid'].'');
mysql_query("DELETE FROM `person_on` WHERE `id_person`='".$_SESSION['uid']."'");
        }
    } else {
?>


</CENTER>

<? }
if($fbattle->battle) {
?>
<HR>
<div id=mes align=center>
<?

//print_r($t1);
  if ($fbattle->battle_data["quest"]!=2) {
    foreach ($fbattle->t1 as $k => $v) {
    if (in_array($v,array_keys($fbattle->battle))) {
        @++$i;
        if ($i > 1) { $cc = ', '; } else { $cc = ''; }
        @$ffs .= $cc.nick4($v,"B1");
        @$zz .= "private [".nick7($v)."] ";
     }
    }
    /*if (strpos($ffs,"[-") || strpos($ffs,"[0")) {
      $fbattle->fast_death();
      header("location:fbattle.php");
    }*/
    $i=0;
  }
?>
<IMG SRC=i/lock.gif WIDTH=20 HEIGHT=15 BORDER=0 ALT="приват" style="cursor:pointer" onClick="Prv('<?=$zz?> ')">
<?=$ffs?>
 <b>против</b>
<?
    $ffs =''; $zz ='';
    foreach ($fbattle->t2 as $k => $v) {
        if (in_array($v,array_keys($fbattle->battle))) {
        ++$i;
        if ($i > 1) { $cc = ', '; } else { $cc = ''; }
        $ffs .= $cc.nick4($v,"B2");
        $zz .= "private [".nick7($v)."] ";
        }
    }
    /*if (strpos($ffs,"[-") || strpos($ffs,"[0")) {
      $fbattle->fast_death();
      header("location:fbattle.php");
    }*/
    $i=0;
?>
<IMG SRC=i/lock.gif WIDTH=20 HEIGHT=15 BORDER=0 ALT="приват" style="cursor:pointer" onClick="Prv('<?=$zz?> ')">
<?=$ffs?>
<HR>
</div>
<?
} else {
    echo "<HR>";
}
    if($user['battle']) { $ll = $user['battle'];} elseif($_REQUEST['batl']) { $ll = $_REQUEST['batl']; }else{$ll = $_SESSION['batl'];}
    //$log = mysql_fetch_array(mysql_query("SELECT `log` FROM `logs` WHERE `id` = '".$ll."';"));
    //$log = file("./logs/battle".$ll.".txt");
    $fs = filesize("backup/logs/battle".$ll.".txt");
    $fh = fopen("backup/logs/battle".$ll.".txt", "r");// or die("Can't open file!");
    fseek($fh, -4256, SEEK_END);
    $log[0] = fread($fh, 4256);
    //echo $file;
    fclose($fh);

    $log = explode("<BR>",$log[0]);
    $ic = count($log)-2;

    //echo (int)$fs;

    if ($fs >= 4256) { //($ic-30 >= 0) {
        $max = 1;
        //$max = 1;
    } else {
        $max = 0;
    }
    for($i=$ic;$i>=0+$max;--$i) {


if(eregi("<hr>",$log[$i])){
            $log[$i] = str_replace("<hr>","",$log[$i]);
                        $log[$i] = $log[$i]."<hr>";
}

        if(eregi(">".$user['login']."</span>",$log[$i])) {
            $log[$i] = str_replace("<span class=date>","<span class=date2>",$log[$i]);
        }
if(eregi("<hr>",$log[$i])){
        echo $log[$i];
}else{
    echo $log[$i],"<BR>";
}
    }
    unset($ic);
if ($max == 1 ) {
?>
Обрезано для уменьшения объема информации. Полную версию смотрите <a href="logs.php?log=<?=$user['battle']?>" target="_blank">здесь&raquo;</a>
<BR><?}
if(!$user['in_tower']){
?>
<font class=dsc>(Бой идет с таймаутом <?=$fbattle->battle_data['timeout']?> мин.)</font><BR>
<? } ?>
<BR>
На данный момент вами нанесено урона: <B><?=(int)$fbattle->damage[$user['id']]?> HP</B>.

</td>
<TD  valign=top align=rigth>
<TABLE width=250 cellspacing=0 cellpadding=0><TR>
<TD valign=top width=250 nowrap><CENTER>
<?


if(@$fbattle->return == 1){
    showpersout($fbattle->enemy,1,1,1,0);
}else{

    if ($fbattle->battle_data['type']==4 OR $fbattle->battle_data['type']==5) {
        $a = array(6,16);
        echo "<img src='i/im/",$a[rand(0,1)],".gif'>";
    } elseif (@$fbattle->return > 1) {
        echo "<img src='i/im/",rand(1,34),".jpg'>";
    } elseif(@$exp[$user['id']] > 0) {
        echo "<img src='i/im/",rand(113,115),".jpg'>";
    } else {
        echo "<img src='i/im/",rand(110,112),".jpg'>";
    }
}

?>
</TD></TR>
</TABLE>

</TD></TR>
</TABLE>

</td></tr>
</TABLE>
</FORM>

<!-- <DIV ID=oMenu CLASS=menu onmouseout="closeMenu()"></DIV> -->
<DIV ID="oMenu"  onmouseout="closeMenu()" style="position:absolute; border:1px solid #666; background-color:#CCC; display:none; "></DIV>

</BODY>
</HTML>
<?php
//showtime();
    mysql_query("UNLOCK TABLES;");

//  $fbattle->solve_mf($fbattle->enemy,5);
    //print_r($fbattle->exp);
?>
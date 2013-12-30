<?php
    session_start();
    include "incl/strokedata.php";
    if (@$_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    //$user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));

    include "functions.php";
    getfeatures($user);
    getadditdata($user);
    if ($user["in_tower"]) {
      $user["b_noj"]=$user["noj"];
      $user["b_mec"]=$user["mec"];
      $user["b_topor"]=$user["topor"];
      $user["b_dubina"]=$user["dubina"];
      $user["b_posoh"]=$user["posoh"];
      $user["b_mfire"]=$user["mfire"];
      $user["b_mwater"]=$user["mwater"];
      $user["b_mair"]=$user["mair"];
      $user["b_mearth"]=$user["mearth"];
      $user["b_mlight"]=$user["mlight"];
      $user["b_mgray"]=$user["mgray"];
      $user["b_mdark"]=$user["mdark"];
    }

    if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }

    $features["friendly"]=array(name=>"Дружелюбный", "descr"=>"Cписок друзей больше на ",
    "bonus1"=>5,"bonus2"=>10,"bonus3"=>15,"bonus4"=>20,"bonus5"=>25);
    $features["sociable"]=array(name=>"Общительный", "descr"=>"Увеличение максимального размера раздела \"Увлечения / хобби\" на ",
    "bonus1"=>"200 символов","bonus2"=>"400 символов","bonus3"=>"500 символов","bonus4"=>"600 символов","bonus5"=>"1000 символов");
    $features["dodgy"]=array("name"=>"Изворотливый", "descr"=>"Снижение стоимости передач на ", "needlevel"=>4,
    "bonus1"=>"0,1 кр","bonus2"=>"0,2 кр","bonus3"=>"0,3 кр","bonus4"=>"0,4 кр","bonus5"=>"0,5 кр");
    $features["dodgy"]=array("name"=>"Изворотливый", "descr"=>"Снижение стоимости передач на ", "needlevel"=>4,
    "bonus1"=>"0,1 кр","bonus2"=>"0,2 кр","bonus3"=>"0,3 кр","bonus4"=>"0,4 кр","bonus5"=>"0,5 кр");
    $features["resistant"]=array("name"=>"Стойкий", "descr"=>"Время травмы меньше на ", "needlevel"=>4,
    "bonus1"=>"5%","bonus2"=>"10%","bonus3"=>"15%","bonus4"=>"20%","bonus5"=>"25%");
    $features["fast"]=array("name"=>"Быстрый", "descr"=>"Кнопка \"Возврат\" появляется раньше на ", "needlevel"=>4,
    "bonus1"=>"5 мин","bonus2"=>"10 мин","bonus3"=>"15 мин","bonus4"=>"20 мин","bonus5"=>"25 мин");
    $features["smart"]=array("name"=>"Сообразительный", "descr"=>"Получаемый опыт больше на ", "needlevel"=>4,
    "bonus1"=>"1 %","bonus2"=>"2 %","bonus3"=>"3 %","bonus4"=>"4 %","bonus5"=>"5 %");
    $features["thrifty"]=array("name"=>"Запасливый", "descr"=>"Больше места в рюкзаке на ", "needlevel"=>4,
    "bonus1"=>"10 ед","bonus2"=>"20 ед","bonus3"=>"30 ед","bonus4"=>"40 ед","bonus5"=>"50 ед");    
    $features["communicable"]=array("name"=>"Коммуникабельный", "descr"=>"Лимит передач в день ", "needlevel"=>4,
    "bonus1"=>"+20","bonus2"=>"+40","bonus3"=>"+60","bonus4"=>"+80","bonus5"=>"+100");    
    $features["sturdy"]=array("name"=>"Двужильный", "descr"=>"Здоровье восстанавливается быстрее на ", "needvinos"=>10,
    "bonus1"=>"5%","bonus2"=>"10%","bonus3"=>"15%","bonus4"=>"20%","bonus5"=>"30%");    
    $features["sane"]=array("name"=>"Здравомыслящий", "descr"=>"Мана восстанавливается быстрее на ", "needmudra"=>20,
    "bonus1"=>"5%","bonus2"=>"10%","bonus3"=>"15%","bonus4"=>"20%","bonus5"=>"25%");    
    $features["sleep"]=array("name"=>"Здоровый сон", "descr"=>"Во время сна время действия негативных эффектов течет со скоростью ", "needlevel"=>5,
    "bonus1"=>"10%","bonus2"=>"20%","bonus3"=>"30%","bonus4"=>"40%","bonus5"=>"50%");    
     
    
function getfsum($user) {                                                                                                                         
  return $user["friendly"]+$user["sociable"]+$user["dodgy"]+$user["resistant"]+$user["fast"]+$user["smart"]+$user["thrifty"]+$user["communicable"]+$user["sturdy"]+$user["sane"]+$user["sleep"];
}


function addstroke($id_priem) {
  global $user;
  $doit=true;
  $res=mq("SELECT slot,id_thing FROM puton WHERE slot>=201 AND slot<=220 AND id_person='".$_SESSION['uid']."' order by slot");
  $j=200;
  while ($s=mysql_fetch_array($res)) {
    $j++;
    if ($s['id_thing']==$id_priem) {$doit=false;break;}
    if (!$x && $s['slot']!=$j) $x=$j; elseif (!$x && $j==210+$user["slots"]) $x=1000;
  }
  if (!$x) $x=$j+1;
  if ($doit) {
    if ($x==1000) {
      $x=210+$user["slots"];mq("UPDATE puton SET id_thing='".$id_priem."' WHERE id_person='".$_SESSION['uid']."' AND slot='".$x. "';");
    }else{
      mq("INSERT INTO puton(id_person,id_thing,slot) VALUES ('".$_SESSION['uid']."','".$id_priem."','".$x."');");
    }
  }
}

if ($_GET['clear_abil']) {
  if ($_GET['clear_abil']=='all') {
    mq("delete from puton where slot>=201 and slot<=220 and id_person='".$_SESSION['uid']."'");
  } else {
    $res=mysql_fetch_array(mq("SELECT id_priem FROM priem WHERE priem='".$_GET['clear_abil']."';"));
    mq("DELETE FROM puton WHERE id_person='".$_SESSION['uid']."' AND id_thing='".$res['id_priem']."';");
  }
  $all=$_GET['all'];
  $showcat=$_GET['show_cat'];
}



if (@$_GET["delset"]) {
  $_GET["delset"]=(int)$_GET["delset"];
  mq("delete from complect where id='$_GET[delset]' and user='$user[id]'");
}

if (@$_GET["complect"]) {
  mq("delete from puton where slot>=201 and slot<=220 and id_person='".$_SESSION['uid']."'");
  $_GET["complect"]=(int)$_GET["complect"];
  $data=unserialize(mqfa1("select data from complect where user='$user[id]' and id='$_GET[complect]'"));
  foreach ($data as $k=>$v) addstroke($v);
}

if (@$_GET["saveset"]) {
  $all=$_GET['all'];
  $showcat=@$_GET['show_cat'];
  $data=array();
  $r=mq("SELECT slot,id_thing FROM puton WHERE slot>=201 AND slot<=220 AND id_person='".$_SESSION['uid']."' order by slot");
  while ($rec=mysql_fetch_assoc($r)) {
    $data[]=$rec["id_thing"];
  }
  $_GET["saveset"]=str_replace("\\","",$_GET["saveset"]);
  $_GET["saveset"]=str_replace("'","",$_GET["saveset"]);
  $_GET["saveset"]=str_replace("\"","",$_GET["saveset"]);
  if (count($data)>0) mq("insert into complect (user, name, type, data) values ('$user[id]', '$_GET[saveset]', 2, '".serialize($data)."')");
}

if (@$_GET['set_abil']) {
  $all=$_GET['all'];
  $showcat=$_GET['show_cat'];
  $id_priem=mqfa1("SELECT id_priem, buystroke FROM priem WHERE priem='".$_GET['set_abil']."' and hide=0 and (buystroke=0 or id_priem in (select stroke from userstrokes where user='$user[id]'))");
  //$res=db_use('array',"SELECT id_priem FROM priem WHERE priem='".$_GET['set_abil']."';");
  if ($id_priem) addstroke($id_priem);
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
    global $user, $strokes;
    if ($s) $priem=$strokes["ids"][$s];
    foreach ($strokes[$priem] as $k=>$v) {
      if ($k=="need_vyn") $k="needvyn";
      if ($k=="need_sil") $k="needsil";
      if ($k=="mana") $v=manausage($priem);
      $this->$k=$v;
    }
    $this->hod=$strokes[$priem]->move;
    $this->priem=$priem;
    if (strpos($this->opisan,"mana33")) {
      if ($user["maxmana"]==0) $this->opisan=str_replace("mana33","33% от максимальной маны",$this->opisan);
      else $this->opisan=str_replace("mana33",round($user["maxmana"]*0.33),$this->opisan);
    }    
    return;
    
    
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
    $this->startwait=$res['startwait'];
    $this->maxuses=$res['maxuses'];
    $this->minhp=$res['minhp'];
    $this->sduh_proc=$res['sduh_proc'];
    $this->sduh=$res['sduh'];
    $this->hod=$res['hod'];
    $this->intel=$res['intel'];
    $this->mana=$res['mana'];
    $this->opisan=$res['opisan'];
    if (strpos($this->opisan,"mana33")) {
      if ($user["maxmana"]==0) $this->opisan=str_replace("mana33","33% от максимальной маны",$this->opisan);
      else $this->opisan=str_replace("mana33",round($user["maxmana"]*0.33),$this->opisan);
    }
    $this->m_magic1=$res['m_magic1'];
    $this->m_magic2=$res['m_magic2'];
    $this->m_magic3=$res['m_magic3'];
    $this->m_magic4=$res['m_magic4'];
    $this->m_magic5=$res['m_magic5'];
    $this->m_magic6=$res['m_magic6'];
    $this->m_magic7=$res['m_magic7'];
    $this->needsil=$res['need_sil'];
    $this->needvyn=$res['need_vyn'];    
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
  function checkbattlehars($myinfo,$hit,$krit,$parry,$counter,$block,$s_duh) { # влад магией, статы + хар-ки битвы
  if (
  $hit>=$this->n_hit &&
  $krit>=$this->n_krit &&
  $parry>=$this->n_parry &&
  $counter>=$this->n_counter &&
  $hp>=$this->n_hp &&
  $block>=$this->n_block &&
  $user['level']>=$this->minlevel &&
  $user['hp']>=$this->minhp &&
  ($s_duh && ($s_duh>=$this->sduh OR $this->sduh_proc)) &&
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
  return true;}
  }
  }




function printpriem($prinfo,$myinfo,$n) {
global $harnames,$all,$showcat, $user, $strokes;

#1
echo "
";
$check1=$prinfo->check_hars(0);
if (!@$strokes[$prinfo->priem]) {$check12=false;
}else {$check12=true;}
if ($n==0) {
    echo "<A HREF='/umenie.php?clear_abil=".$prinfo->priem."&all=".$_GET['all'].($showcat?'&show_cat='.$showcat:'')."&r=".rand(0,50000000)."&all=".(0+$_GET['all']).($showcat?'&show_cat='.$showcat:'')."'><IMG style=\"cursor:pointer\" ";
}elseif ($n==1 && $check1) {
    echo "<A HREF='/umenie.php?set_abil=".$prinfo->priem."&all=".(0+$_GET['all']).($showcat?'&show_cat='.$showcat:'')."&r=".rand(0,50000000)."'><IMG style=\"cursor:pointer\" ";
}elseif(($n==1 && !$check1) OR $n==2 or ($n==0 && !$check1)) {
    echo"<IMG style=\"-moz-opacity:.70; opacity:.70;filter:gray(), Alpha(Opacity='70');\" ";
}
if (($n==1 or $n==0) && !$check12) {
echo "style=\"-moz-opacity:.70; opacity:.70;filter:gray(), Alpha(Opacity='70');\"";
}
        echo "width=40 height=25 src='".IMGBASE."/i/priem/".$prinfo->priem.".gif'
            onmouseout='hideshow();' onmouseover='fastshow2(\"<B>".$prinfo->name."</B><BR>";
        if ($prinfo->n_hit) {echo "<IMG width=7 height=8 src=".IMGBASE."/i/misc/micro/hit.gif> ".
                    $prinfo->n_hit."&nbsp;&nbsp; ";
                    }
        if ($prinfo->n_counter) {echo"<IMG width=7 height=8 src=".IMGBASE."/i/misc/micro/counter.gif> ".$prinfo->n_counter."&nbsp;&nbsp; ";}
        if ($prinfo->n_parry) {echo"<IMG width=7 height=8 src=".IMGBASE."/i/misc/micro/parry.gif> ".$prinfo->n_parry."&nbsp;&nbsp; ";}
        if ($prinfo->n_krit) {echo"<IMG width=7 height=8 src=".IMGBASE."/i/misc/micro/krit.gif> ".$prinfo->n_krit."&nbsp;&nbsp; ";}
        if ($prinfo->n_block) {echo"<IMG width=7 height=8 src=".IMGBASE."/i/misc/micro/block.gif> ".$prinfo->n_block."&nbsp;&nbsp; ";}
        if ($prinfo->n_hp) {echo"<IMG width=7 height=8 src=".IMGBASE."/i/misc/micro/hp.gif> ".$prinfo->n_hp."&nbsp;&nbsp; ";}
        echo "<BR>";
        if ($prinfo->sduh) {echo"Сила духа: ".$prinfo->sduh."<BR>";
        }elseif ($prinfo->sduh_proc) {echo"Сила духа: ".$prinfo->sduh_proc."%<BR>";}
        if ($prinfo->mana) {echo"Расход маны: ".$prinfo->mana."<BR>";}
        if ($prinfo->wait) {echo"Задержка: ".$prinfo->wait."<BR>";}
        if ($prinfo->startwait) {echo"Начальная задержка: ".$prinfo->startwait."<BR>";}
        if ($prinfo->hod) {echo"&bull; Прием тратит ход<BR>";   }
        if ($prinfo->minlevel OR $prinfo->intel OR
        $prinfo->minhp OR $prinfo->m_magic1 OR $prinfo->m_magic2
        OR $prinfo->m_magic3 OR $prinfo->m_magic4 OR $prinfo->m_magic6) {
            echo "<BR><B>Минимальные требования: </B><BR>";
            if ($prinfo->intel) {
                echo ($prinfo->intel>$user['intel']?"<font color=red>":"").
                "Интеллект: ".$prinfo->intel."<BR>".
                ($prinfo->intel>$user['intel']?"</font>":"");
            }
            if ($prinfo->needvyn) {
                echo ($prinfo->needvyn>$user['vinos']?"<font color=red>":"").
                "Выносливость: ".$prinfo->needvyn."<BR>".
                ($prinfo->needvyn>$user['vinos']?"</font>":"");
            }
            if ($prinfo->needsil) {
                echo ($prinfo->needsil>$user['sila']?"<font color=red>":"").
                "Сила: ".$prinfo->needsil."<BR>".
                ($prinfo->needsil>$user['sila']?"</font>":"");
            }

            if ($prinfo->m_magic1) {
                echo ($prinfo->m_magic1>$user['mfire']?"<font color=red>":"").
                "Мастерство владения стихией Огня: ".$prinfo->m_magic1."<BR>".
                ($prinfo->m_magic1>$user['mfire']?"</font>":"");
            }
            if ($prinfo->m_magic2) {
                echo ($prinfo->m_magic2>$user['mwater']?"<font color=red>":"").
                "Мастерство владения стихией Воды: ".$prinfo->m_magic2."<BR>".
                ($prinfo->m_magic2>$user['mwater']?"</font>":"");
            }
            if ($prinfo->m_magic3) {
                echo ($prinfo->m_magic3>$user['mair']?"<font color=red>":"").
                "Мастерство владения стихией Воздуха: ".$prinfo->m_magic3."<BR>".
                ($prinfo->m_magic3>$user['mair']?"</font>":"");
            }
            if ($prinfo->m_magic4) {
                echo ($prinfo->m_magic4>$user['mearth']?"<font color=red>":"").
                "Мастерство владения стихией Земли: ".$prinfo->m_magic4."<BR>".
                ($prinfo->m_magic4>$user['mearth']?"</font>":"");
            }
            if ($prinfo->m_magic5) {
                echo ($prinfo->m_magic5>$user['mlight']?"<font color=red>":"").
                "Мастерство владения магией Света: ".$prinfo->m_magic5."<BR>".
                ($prinfo->m_magic5>$user['mlight']?"</font>":"");
            }
            if ($prinfo->m_magic6) {
                echo ($prinfo->m_magic6>$user['mgray']?"<font color=red>":"").
                "Мастерство владения Серой магией: ".$prinfo->m_magic6."<BR>".
                ($prinfo->m_magic6>$user['mgray']?"</font>":"");
            }
            if ($prinfo->m_magic7) {
                echo ($prinfo->m_magic7>$user['mdark']?"<font color=red>":"").
                "Мастерство владения магией Тьмы: ".$prinfo->m_magic7."<BR>".
                ($prinfo->m_magic7>$user['mdark']?"</font>":"");
            }
            if ($prinfo->minhp) {
                echo "Уровень жизни (HP): ".$prinfo->minhp."<BR>";
            }
            if ($prinfo->minlevel) {
                echo ($prinfo->minlevel>$user['level']?"<font color=red>":"").
                "Уровень: ".$prinfo->minlevel."<BR>".
                ($prinfo->minlevel>$user['level']?"</font>":"");
            }
        }
        echo"<BR>".$prinfo->opisan."\",this,event)'>".($n==2?'':"</A>");


}
if (!$user["in_tower"] && (@$_GET["raisefeature"]=="friendly" || @$_GET["raisefeature"]=="sociable" || @$_GET["raisefeature"]=="dodgy" || @$_GET["raisefeature"]=="resistant" || @$_GET["raisefeature"]=="fast" || @$_GET["raisefeature"]=="smart" || @$_GET["raisefeature"]=="thrifty" || @$_GET["raisefeature"]=="communicable" || @$_GET["raisefeature"]=="sturdy" || @$_GET["raisefeature"]=="sane" || @$_GET["raisefeature"]=="sleep")) {
  if ($features[$_GET["raisefeature"]]["needlevel"] && $user["level"]<$features[$_GET["raisefeature"]]["needlevel"]+$user[$_GET["raisefeature"]]) {
  } elseif ($features[$_GET["raisefeature"]]["needvinos"] && $user["vinos"]<$features[$_GET["raisefeature"]]["needvinos"]+($user[$_GET["raisefeature"]]*5)) {
  } elseif ($features[$_GET["raisefeature"]]["needmudra"] && $user["mudra"]<$features[$_GET["raisefeature"]]["needmudra"]+($user[$_GET["raisefeature"]]*5)) {
  } elseif ($user[$_GET["raisefeature"]]<5 && getfsum($user)<$user["level"]+1) {
    $user[$_GET["raisefeature"]]++;                                                                                                                                                                                                                                                    
    //echo ($user["friendly"]+($user["sociable"]*8)+($user["dodgy"]*8*8)+($user["resistant"]*8*8*8)+($user["fast"]*8*8*8*8)+($user["smart"]*8*8*8*8*8)+($user["thrifty"]*8*8*8*8*8*8)+($user["communicable"]*8*8*8*8*8*8*8)+($user["sturdy"]*8*8*8*8*8*8*8*8)+($user["sane"]*8*8*8*8*8*8*8*8*8)+($user["sleep"]*8*8*8*8*8*8*8*8*8*8));
    mq("update users set features='".($user["friendly"]+($user["sociable"]*8)+($user["dodgy"]*8*8)+($user["resistant"]*8*8*8)+($user["fast"]*8*8*8*8)+($user["smart"]*8*8*8*8*8)+($user["thrifty"]*8*8*8*8*8*8)+($user["communicable"]*8*8*8*8*8*8*8)+($user["sturdy"]*8*8*8*8*8*8*8*8)+($user["sane"]*8*8*8*8*8*8*8*8*8)+($user["sleep"]*8*8*8*8*8*8*8*8*8*8))."' where id='$user[id]'");
    err("<font color=red> Вы выбрали особенность \"<B>".$features[$_GET["raisefeature"]]["name"]."</B>\" (".$features[$_GET["raisefeature"]]["descr"].$features[$_GET["raisefeature"]]["bonus".$user[$_GET["raisefeature"]]].".)</font><br>");
  }
}


if (@$_GET['edit']) {
//str - сила
//dex - ловокость
//inst - интуиция
//power - выносливость
//intel - интеллект
//wis - мудрость
//duh - духовность

  $summ = floor($_GET['str']+$_GET['dex']+$_GET['inst']+$_GET['power']+$_GET['intel']+$_GET['wis']+$_GET['spirit']+$_GET['will']+$_GET['freedom']+$_GET['god']+$_GET['sexy']);
  if(!is_numeric($summ)){$summ=0;}
  $summu = floor($_GET['m_axe']+$_GET['m_molot']+$_GET['m_sword']+$_GET['m_tohand']+$_GET['m_staff']+$_GET['m_magic1']+$_GET['m_magic2']+$_GET['m_magic3']+$_GET['m_magic4']+$_GET['m_magic5']+$_GET['m_magic6']+$_GET['m_magic7']);
  if(!is_numeric($summu)){$summu=0;}
  if ($user['stats'] >0 && $user['sid']==$_GET['s4i'] && $summ<=$user['stats'] && $summ>0 && $_GET['str']>0){ 
    mq("UPDATE `users` SET `sila` = `sila`+{$_GET['str']}, `stats`=`stats`-{$_GET['str']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1");
    if (!$user["in_tower"]) mq("UPDATE `userdata` SET `sila` = `sila`+{$_GET['str']}, `stats`=`stats`-{$_GET['str']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1");
    err("<font color=red>Увеличение способности<B> \"Сила\" </B>произведено удачно</font><br>");
  }

  if ($user['stats'] >0 && $user['sid']==$_GET['s4i'] && $summ<=$user['stats'] && $summ>0 && $_GET['dex']>0){ 
    mq("UPDATE `users` SET `lovk` = `lovk`+{$_GET['dex']}, `stats`=`stats`-{$_GET['dex']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1");
    if (!$user["in_tower"]) mq("UPDATE `userdata` SET `lovk` = `lovk`+{$_GET['dex']}, `stats`=`stats`-{$_GET['dex']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1");
    err("<font color=red>Увеличение способности<B> \"Ловкость\" </B>произведено удачно</font><br>");
  }

  if ($user['stats'] >0 && $user['sid']==$_GET['s4i'] && $summ<=$user['stats'] && $summ>0 && $_GET['inst']>0){    
    mq("UPDATE `users` SET `inta` = `inta`+{$_GET['inst']}, `stats`=`stats`-{$_GET['inst']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    if (!$user["in_tower"]) mq("UPDATE `userdata` SET `inta` = `inta`+{$_GET['inst']}, `stats`=`stats`-{$_GET['inst']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    err("<font color=red>Увеличение способности<B> \"Интуиция\" </B>произведено удачно</font><br>");
  }

  if ($user['stats'] >0 && $user['sid']==$_GET['s4i'] && $summ<=$user['stats'] && $summ>0 && $_GET['power']>0){   
    mq("UPDATE `users` SET `vinos` = `vinos`+{$_GET['power']}, `maxhp` = `maxhp`+".($_GET['power']*6).", `stats`=`stats`-{$_GET['power']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1");
    if (!$user["in_tower"]) mq("UPDATE `userdata` SET `vinos` = `vinos`+{$_GET['power']}, `stats`=`stats`-{$_GET['power']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1");
    resetmax($user["id"]);
    err("<font color=red>Увеличение способности<B> \"Выносливость\" </B>произведено удачно</font><br>");
  }

  if (($user['stats'] >0 && $user['sid']==$_GET['s4i']) && ($user['level'] > 3) && $summ<=$user['stats'] && $summ>0 && $_GET['intel']>0) {
    mq("UPDATE `users` SET `intel` = `intel`+{$_GET['intel']}, `stats`=`stats`-{$_GET['intel']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1");
    if (!$user["in_tower"]) mq("UPDATE `userdata` SET `intel` = `intel`+{$_GET['intel']}, `stats`=`stats`-{$_GET['intel']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1");
    err("<font color=red>Увеличение способности<B> \"Интеллект\" </B>произведено удачно</font><br>");
  }

  if (($user['stats'] >0) && ($user['level'] > 6) && $user['sid']==$_GET['s4i'] && $summ<=$user['stats'] && $summ>0 && $_GET['wis']>0){   
    mq("UPDATE `users` SET `mudra` = `mudra`+{$_GET['wis']}, `maxmana` = `maxmana`+".($_GET['wis']*10).", `stats`=`stats`-{$_GET['wis']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1");
    if (!$user["in_tower"]) mq("UPDATE `userdata` SET `mudra` = `mudra`+{$_GET['wis']}, `stats`=`stats`-{$_GET['wis']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1");
    resetmax($user["id"]);
    err("<font color=red>Увеличение способности<B> \"Мудрость\" </B>произведено удачно</font><br>");
  }

  if (($user['stats'] >0) && ($user['level'] > 9) && $user['sid']==$_GET['s4i'] && $summ<=$user['stats'] && $summ>0 && $_GET['spirit']>0) {
    mq("UPDATE `users` SET `spirit` = `spirit`+{$_GET['spirit']}, `stats`=`stats`-{$_GET['spirit']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1");
    if (!$user["in_tower"]) mq("UPDATE `userdata` SET `spirit` = `spirit`+{$_GET['spirit']}, `stats`=`stats`-{$_GET['spirit']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1");
    err("<font color=red>Увеличение способности<B> \"Духовность\" </B>произведено удачно</font><br>");
  }

  if (($user['stats'] >0) && ($user['level'] > 12) && $user['sid']==$_GET['s4i'] && $summ<=$user['stats'] && $summ>0 && $_GET['will']>0) {
    mq("UPDATE `users` SET `will` = `will`+{$_GET['will']}, `stats`=`stats`-{$_GET['will']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1");
    err("<font color=red>Увеличение способности<B> \"Воля\" </B>произведено удачно</font><br>");
  }

  if (($user['stats'] >0) && ($user['level'] > 15) && $user['sid']==$_GET['s4i'] && $summ<=$user['stats'] && $summ>0 && $_GET['freedom']>0) {
    mq("UPDATE `users` SET `freedom` = `freedom`+{$_GET['freedom']}, `stats`=`stats`-{$_GET['freedom']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1");
    err("<font color=red>Увеличение способности<B> \"Свобода духа\" </B>произведено удачно</font><br>");
  }

  if (($user['stats'] >0) && ($user['level'] > 18) && $user['sid']==$_GET['s4i'] && $summ<=$user['stats'] && $summ>0 && $_GET['god']>0) {
    mq("UPDATE `users` SET `god` = `god`+{$_GET['god']}, `stats`=`stats`-{$_GET['god']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    err("<font color=red>Увеличение способности<B> \"Божественность\" </B>произведено удачно</font><br>");
  }

  if ($user['master'] >0 && $user['b_noj'] < 5 && $user['sid']==$_GET['s4i'] && ($user['level'] > 0) &&  $summu<=$user['master'] && $summu>0 && $_GET['m_sword']>0){    
    $user["noj"]+=$_GET['m_sword'];
    $user["b_noj"]+=$_GET['m_sword'];
    mq("UPDATE `users` SET `noj` = `noj`+{$_GET['m_sword']}, `master`=`master`-{$_GET['m_sword']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    if (!$user["in_tower"]) mq("UPDATE `userdata` SET `noj` = `noj`+{$_GET['m_sword']}, `master`=`master`-{$_GET['m_sword']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    err("<font color=red>Увеличение умения <B> \"Мастерство владения ножами, кастетами\" </B>произведено удачно</font><br>");
  }
  if ($user['master'] >0 && $user['b_mec'] < 5 && $user['sid']==$_GET['s4i'] && ($user['level'] > 0) &&  $summu<=$user['master'] && $summu>0 && $_GET['m_axe']>0){  
    $user["mec"]+=$_GET['m_axe'];
    $user["b_mec"]+=$_GET['m_axe'];
    mq("UPDATE `users` SET `mec` = `mec`+{$_GET['m_axe']}, `master`=`master`-{$_GET['m_axe']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    if (!$user["in_tower"]) mq("UPDATE `userdata` SET `mec` = `mec`+{$_GET['m_axe']}, `master`=`master`-{$_GET['m_axe']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    err("<font color=red>Увеличение умения <B> \"Мастерство владения мечами\" </B>произведено удачно</font><br>");
  }
  if ($user['master'] >0 && $user['b_dubina'] < 5 && $user['sid']==$_GET['s4i'] && ($user['level'] > 0) &&  $summu<=$user['master'] && $summu>0 && $_GET['m_molot']>0) {
    $user["dubina"]+=$_GET['m_molot'];
    $user["b_dubina"]+=$_GET['m_molot'];
    mq("UPDATE `users` SET `dubina` = `dubina`+{$_GET['m_molot']}, `master`=`master`-{$_GET['m_molot']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    if (!$user["in_tower"]) mq("UPDATE `userdata` SET `dubina` = `dubina`+{$_GET['m_molot']}, `master`=`master`-{$_GET['m_molot']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    err("<font color=red>Увеличение умения <B> \"Мастерство владения дубинами, булавами\" </B>произведено удачно</font><br>");
  }
  if ($user['master'] >0 && $user['b_topor'] < 5 && $user['sid']==$_GET['s4i'] && ($user['level'] > 0) &&  $summu<=$user['master'] && $summu>0 && $_GET['m_tohand']>0) {
    $user["topor"]+=$_GET['m_tohand'];
    $user["b_topor"]+=$_GET['m_tohand'];
    mq("UPDATE `users` SET `topor` = `topor`+{$_GET['m_tohand']}, `master`=`master`-{$_GET['m_tohand']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    if (!$user["in_tower"]) mq("UPDATE `userdata` SET `topor` = `topor`+{$_GET['m_tohand']}, `master`=`master`-{$_GET['m_tohand']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    err("<font color=red>Увеличение умения <B> \"Мастерство владения топорами, секирами\" </B>произведено удачно</font><br>");
  }
  if ($user['master'] >0 && $user['b_posoh'] < 5 && $user['sid']==$_GET['s4i'] && ($user['level'] > 0) &&  $summu<=$user['master'] && $summu>0 && $_GET['m_staff']>0) {
    $user["posoh"]+=$_GET['m_staff'];
    $user["b_posoh"]+=$_GET['m_staff'];
    mq("UPDATE `users` SET `posoh` = `posoh`+{$_GET['m_staff']}, `master`=`master`-{$_GET['m_staff']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    if (!$user["in_tower"]) mq("UPDATE `userdata` SET `posoh` = `posoh`+{$_GET['m_staff']}, `master`=`master`-{$_GET['m_staff']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    err("<font color=red>Увеличение умения <B> \"Мастерство владения магическими посохами\" </B>произведено удачно</font><br>");
  }
  if ($user['master'] >0 && $user['b_mfire'] < 10 && $user['sid']==$_GET['s4i'] && ($user['level'] > 3) &&  $summu<=$user['master'] && $summu>0 && $_GET['m_magic1']>0) {
    $user["mfire"]+=$_GET['m_magic1'];
    $user["b_mfire"]+=$_GET['m_magic1'];
    mq("UPDATE `users` SET `mfire` = `mfire`+{$_GET['m_magic1']}, `master`=`master`-{$_GET['m_magic1']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    if (!$user["in_tower"]) mq("UPDATE `userdata` SET `mfire` = `mfire`+{$_GET['m_magic1']}, `master`=`master`-{$_GET['m_magic1']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    err("<font color=red>Увеличение умения <B> \"Мастерство владения стихией Огня\" </B>произведено удачно</font><br>");
  }
  if ($user['master'] >0 && $user['b_mwater'] < 10 && $user['sid']==$_GET['s4i'] && ($user['level'] > 3) &&  $summu<=$user['master'] && $summu>0 && $_GET['m_magic2']>0) {
    $user["mwater"]+=$_GET['m_magic2'];
    $user["b_mwater"]+=$_GET['m_magic2'];
    mq("UPDATE `users` SET `mwater` = `mwater`+{$_GET['m_magic2']}, `master`=`master`-{$_GET['m_magic2']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    if (!$user["in_tower"]) mq("UPDATE `userdata` SET `mwater` = `mwater`+{$_GET['m_magic2']}, `master`=`master`-{$_GET['m_magic2']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    err("<font color=red>Увеличение умения <B> \"Мастерство владения стихией Воды\" </B>произведено удачно</font><br>");
  }
  if ($user['master'] >0 && $user['b_mair'] < 10 && $user['sid']==$_GET['s4i'] && ($user['level'] > 3) &&  $summu<=$user['master'] && $summu>0 && $_GET['m_magic3']>0) {
    $user["mair"]+=$_GET['m_magic3'];
    $user["b_mair"]+=$_GET['m_magic3'];
    mq("UPDATE `users` SET `mair` = `mair`+{$_GET['m_magic3']}, `master`=`master`-{$_GET['m_magic3']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    if (!$user["in_tower"]) mq("UPDATE `userdata` SET `mair` = `mair`+{$_GET['m_magic3']}, `master`=`master`-{$_GET['m_magic3']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    err("<font color=red>Увеличение умения <B> \"Мастерство владения стихией Воздуха\" </B>произведено удачно</font><br>");
  }
  if ($user['master'] >0 && $user['b_mearth'] < 10 && $user['sid']==$_GET['s4i'] && ($user['level'] > 3) &&  $summu<=$user['master'] && $summu>0 && $_GET['m_magic4']>0) {
    $user["mearth"]+=$_GET['m_magic4'];
    $user["b_mearth"]+=$_GET['m_magic4'];
    mq("UPDATE `users` SET `mearth` = `mearth`+{$_GET['m_magic4']}, `master`=`master`-{$_GET['m_magic4']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    if (!$user["in_tower"]) mq("UPDATE `userdata` SET `mearth` = `mearth`+{$_GET['m_magic4']}, `master`=`master`-{$_GET['m_magic4']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    err("<font color=red>Увеличение умения <B> \"Мастерство владения стихией Земли\" </B>произведено удачно</font><br>");
  }
  if ($user['master'] >0 && $user['b_mlight'] < 10 && $user['sid']==$_GET['s4i'] && ($user['level'] > 3) &&  $summu<=$user['master'] && $summu>0 && $_GET['m_magic5']>0) {
    $user["mlight"]+=$_GET['m_magic5'];
    $user["b_mlight"]+=$_GET['m_magic5'];
    mq("UPDATE `users` SET `mlight` = `mlight`+{$_GET['m_magic5']}, `master`=`master`-{$_GET['m_magic5']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    if (!$user["in_tower"]) mq("UPDATE `userdata` SET `mlight` = `mlight`+{$_GET['m_magic5']}, `master`=`master`-{$_GET['m_magic5']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    err("<font color=red>Увеличение умения <B> \"Мастерство владения магией Света\" </B>произведено удачно</font><br>");
  }
  if ($user['master'] >0 && $user['b_mgray'] < 10 && $user['sid']==$_GET['s4i'] && ($user['level'] > 3) &&  $summu<=$user['master'] && $summu>0 && $_GET['m_magic6']>0) {
    $user["mgray"]+=$_GET['m_magic6'];
    $user["b_mgray"]+=$_GET['m_magic6'];
    mq("UPDATE `users` SET `mgray` = `mgray`+{$_GET['m_magic6']}, `master`=`master`-{$_GET['m_magic6']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    if (!$user["in_tower"]) mq("UPDATE `userdata` SET `mgray` = `mgray`+{$_GET['m_magic6']}, `master`=`master`-{$_GET['m_magic6']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    err("<font color=red>Увеличение умения <B> \"Мастерство владения серой магией\" </B>произведено удачно</font><br>");
  }
  if ($user['master'] >0 && $user['mdark'] < 10 && $user['sid']==$_GET['s4i'] && ($user['level'] > 3) &&  $summu<=$user['master'] && $summu>0 && $_GET['m_magic7']>0) {
    $user["mdark"]+=$_GET['m_magic7'];
    $user["b_mdark"]+=$_GET['m_magic7'];
    mq("UPDATE `users` SET `mdark` = `mdark`+{$_GET['m_magic7']}, `master`=`master`-{$_GET['m_magic7']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    if (!$user["in_tower"]) mq("UPDATE `userdata` SET `mdark` = `mdark`+{$_GET['m_magic7']}, `master`=`master`-{$_GET['m_magic7']} WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
    err("<font color=red>Увеличение умения <B> \"Мастерство владения магией Тьмы\" </B>произведено удачно</font><br>");
  }
  $user1 = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
  foreach ($user1 as $k=>$v) $user[$k]=$v;
}


?>
<HTML>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<SCRIPT src='i/commoninf2.js'></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="i/sl2.242.js"></SCRIPT>
                                   <!--http://img.combats.ru-->
<script type="text/javascript" src='/i/js/inf.0.104.js?1' charset='utf-8'></script>

<style>
.tz     { font-weight:bold; color: #003388; background-color: #CCCCCC; cursor:pointer; text-align: center; }
.tzS        { font-weight:bold; color: #000000; background-color: #CCCCCC; text-align: center; }
.tzOver     { font-weight:bold; color: #003388; background-color: #C0C0C0; cursor:pointer; text-align: center; }
.tzSet      { font-weight:bold; color: #003388; background-color: #A6B1C6; cursor:default; text-align: center; }
.dtz        { display: none }
.nonactive  {-moz-opacity:.70; opacity:.30;filter:progid:DXImageTransform.Microsoft.BasicImage(grayscale=1); filter:progid:DXImageTransform.Microsoft.Alpha(opacity=30);}
</style>
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=e2e0e0>
<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; z-index: 100; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px;"></div>

<div id=hint4 class=ahint style="position:absolute;"></div>
<SCRIPT>
function kmp(){
    document.all("hint4").innerHTML = '<table width=400 cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>Запомнить набор приемов</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=5 bgcolor=FFF6DD><tr><form action="/umenie.php"><input type=hidden name=all value="<? echo (int)@$_GET["all"];?>"><input type=hidden name=show_cat value="<? echo @$showcat; ?>"><td>Запомнить набор приемов, для быстрого переключения.<BR>'+
    'Введите название набора: <INPUT TYPE=text name="saveset" maxlength=30><INPUT TYPE=hidden NAME="make_abil" value="save"></TD></TR><TR><TD align=center><INPUT TYPE=submit value="Запомнить"></TD></TR></FORM></TABLE></td></tr></table>';
    document.all("hint4").style.visibility = "visible";
    document.all("hint4").style.left = 300;
    document.all("hint4").style.top = 120;
    document.all("value").focus();
}

var clevel='';
var currentID=1078509722;

function dw(s) {document.write(s);}

function highl(nm, i)
{   if (clevel == nm) { document.all(nm).className = 'tzSet' }
    else {
        if (i==1) { document.all(nm).className = 'tzOver' }
        else { document.all(nm).className = 'tz' }
    }
}
function setlevel(nm)
{
    if (clevel != '') {
        document.all(clevel).className = 'tz';
        document.all('d'+clevel).style.display = 'none';
    }
    clevel = nm || 'L1';
    document.all(clevel).className = 'tzSet';
    document.all('d'+clevel).style.display = 'inline';
}

</SCRIPT>

<TABLE width=100%>
    <TD>
<?  //$data=mq("SELECT `id`, `login`,`level`,`align` FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
                    //while ($row = mysql_fetch_array($data)) {
  echo fullnick($user);
  //nick2($user['id']);
//}?>
<TD valign=top align=right>
<INPUT TYPE=button value='Обновить' style='width: 75px' onclick='location="/umenie.php"'>
<INPUT TYPE=button value="Вернуться" style='width: 75px' onclick="location.href='main.php'"></div>
</TABLE>
<TABLE border=0 cellspacing=0 cellpadding=0 width=100%>
<TD width=30% valign=top>
<TABLE border=0 cellspacing=1 cellpadding=0 width=100%>
<TR>
<TD class=tzS>Характеристики персонажа</TD>
<TR><TD style='padding-left: 5'>
<STYLE>
IMG.skill{width:9px;height:9px;cursor:pointer}
TD.skill{font-weight:bold}
TD.skills{font-weight:bold;color:#600000}
TD.skillb{font-weight:bold;color:#006000}
</STYLE>
<TABLE cellSpacing=0>
<TR id="str" onmousedown="ChangeSkill(event,this)" onmouseup="DropTimer()" onclick="OnClick(event,this);">
<TD>&bull; Сила: </TD>
<TD width=40 class="skill" align="right" wdth=30><?=$user['sila']?><BR></small></TD>
<TD width=60 noWrap></TD>
<TD><IMG id="minus_str" SRC=<?=IMGBASE?>/i/minus.gif class="nonactive" ALT="уменьшить">&nbsp;<IMG SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить" id="plus_str"></TD>
</TR>
<TR id="dex" onmousedown="ChangeSkill( event, this )" onmouseup="DropTimer()"  onclick="OnClick(event,this);">
<TD>&bull; Ловкость: </TD>
<TD width=40 class="skill" align="right" wdth=30><?=$user['lovk']?><BR></small></TD>
<TD width=60 noWrap></TD>
<TD><IMG id="minus_dex" SRC=<?=IMGBASE?>/i/minus.gif class="nonactive" ALT="уменьшить">&nbsp;<IMG SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить" id="plus_dex"></TD>
</TR>
<TR id="inst" onmousedown="ChangeSkill( event, this )" onmouseup="DropTimer()"  onclick="OnClick(event,this);">
<TD>&bull; Интуиция: </TD>
<TD width=40 class="skill" align="right" wdth=30><?=$user['inta']?><BR></small></TD>
<TD width=60 noWrap></TD>
<TD><IMG id="minus_inst" SRC=<?=IMGBASE?>/i/minus.gif class="nonactive" ALT="уменьшить">&nbsp;<IMG SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить" id="plus_inst"></TD>
</TR>
<TR id="power" onmousedown="ChangeSkill( event, this )" onmouseup="DropTimer()"  onclick="OnClick(event,this);">
<TD>&bull; Выносливость: </TD>
<TD width=40 class="skill" align="right" wdth=30><?=$user['vinos']?><BR></small></TD>
<TD width=60 noWrap></TD>
<TD><IMG id="minus_power" SRC=<?=IMGBASE?>/i/minus.gif class="nonactive" ALT="уменьшить">&nbsp;<IMG SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить"  id="plus_power"></TD>
</TR>

<?php
if ($user['level'] > 3) {
?>
<TR id="intel" onmousedown="ChangeSkill( event, this )" onmouseup="DropTimer()"  onclick="OnClick(event,this);">
<TD>&bull; Интеллект: </TD>
<TD width=40 class="skill" align="right" wdth=30><?=$user['intel']?></TD>
<TD width=60 noWrap></TD>
<TD><IMG id="minus_intel" SRC=<?=IMGBASE?>/i/minus.gif class="nonactive" ALT="уменьшить">&nbsp;<IMG SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить"  id="plus_intel"></TD>
</TR>
<?php
}
if ($user['level'] > 6) {
?>
<TR id="wis" onmousedown="ChangeSkill( event, this )" onmouseup="DropTimer()"  onclick="OnClick(event,this);">
<TD>&bull; Мудрость: </TD>
<TD width=40 class="skill" align="right" wdth=30><?=$user['mudra']?></TD>
<TD width=60 noWrap></TD>
<TD><IMG id="minus_wis" SRC=<?=IMGBASE?>/i/minus.gif class="nonactive" ALT="уменьшить">&nbsp;<IMG SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить"  id="plus_wis"></TD>
</TR>
<?php
}
if ($user['level'] > 9) {
?>
<TR id="spirit" onmousedown="ChangeSkill( event, this )" onmouseup="DropTimer()"  onclick="OnClick(event,this);">
<TD>&bull; Духовность: </TD>
<TD width=40 class="skill" align="right" wdth=30><?=$user['spirit']?></TD>
<TD width=60 noWrap></TD>
<TD><IMG id="minus_spirit" SRC=<?=IMGBASE?>/i/minus.gif class="nonactive" ALT="уменьшить">&nbsp;<IMG SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить"  id="plus_spirit"></TD>
</TR>
<?php
}
if ($user['level'] > 12) {
?>
<TR id="will" onmousedown="ChangeSkill( event, this )" onmouseup="DropTimer()"  onclick="OnClick(event,this);">
<TD>&bull; Воля: </TD>
<TD width=40 class="skill" align="right" wdth=30><?=$user['will']?></TD>
<TD width=60 noWrap></TD>
<TD><IMG id="minus_will" SRC=<?=IMGBASE?>/i/minus.gif class="nonactive" ALT="уменьшить">&nbsp;<IMG SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить"  id="plus_will"></TD>
</TR>
<?php
}
if ($user['level'] > 15) {
?>
<TR id="freedom" onmousedown="ChangeSkill( event, this )" onmouseup="DropTimer()"  onclick="OnClick(event,this);">
<TD>&bull; Свобода духа: </TD>
<TD width=40 class="skill" align="right" wdth=30><?=$user['freedom']?></TD>
<TD width=60 noWrap></TD>
<TD><IMG id="minus_freedom" SRC=<?=IMGBASE?>/i/minus.gif class="nonactive" ALT="уменьшить">&nbsp;<IMG SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить"  id="plus_freedom"></TD>
</TR>
<?php
}
if ($user['level'] > 18) {
?>
<TR id="god" onmousedown="ChangeSkill( event, this )" onmouseup="DropTimer()"  onclick="OnClick(event,this);">
<TD>&bull; Божественность: </TD>
<TD width=40 class="skill" align="right" wdth=30><?=$user['god']?></TD>
<TD width=60 noWrap></TD>
<TD><IMG id="minus_god" SRC=<?=IMGBASE?>/i/minus.gif class="nonactive" ALT="уменьшить">&nbsp;<IMG SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить"  id="plus_god"></TD>
</TR>
<?php
}
?>
</TABLE>
<INPUT type="button" value="сохранить" disabled id="save_button0" onclick="SaveSkill()">
<INPUT type="checkbox" onClick="ChangeButtonState(0)">
<BR><BR>
<FONT COLOR=green>
<?
  if($user['stats']>0) echo "&nbsp;Возможных увеличений: <SPAN id=UP>$user[stats]</SPAN><BR>";
  if($user['master']>0) echo "&nbsp;Свободных умений: <SPAN id=m_UP>$user[master]</SPAN><BR>";
  $fsum=getfsum($user);
  if ($fsum<$user["level"]+1 && !$user["in_tower"]) echo "&nbsp;Свободных особенностей: ".($user["level"]+1-$fsum)."<br>";
?>
</FONT>
<BR><BR>
</FONT>
</TABLE>
<SCRIPT>
var nUP = <?=$user['stats']?>;
var oUP = document.getElementById( "UP" );
var nm_UP = <?=$user['master']?>;
var m_UP = document.getElementById( "m_UP" );
var arrChange = { };
var arrMin = {
str: 3, dex: 3, inst: 3, power: 3};
var skillsArr = new Array ();
skillsArr["m_axe"] = <?=$user['mec']?>;
skillsArr["m_bow"] = 0;
skillsArr["m_crossbow"] = 0;
skillsArr["m_molot"] = <?=$user['dubina']?>;
skillsArr["m_staff"] = <?=$user['posoh']?>;
skillsArr["m_sword"] = <?=$user['noj']?>;
skillsArr["m_tohand"] = <?=$user['topor']?>;
skillsArr["m_magic1"] = <?=$user['mfire']?>;
skillsArr["m_magic2"] = <?=$user['mwater']?>;
skillsArr["m_magic3"] = <?=$user['mair']?>;
skillsArr["m_magic4"] = <?=$user['mearth']?>;
skillsArr["m_magic5"] = <?=$user['mlight']?>;
skillsArr["m_magic6"] = <?=$user['mgray']?>;
skillsArr["m_magic7"] = <?=$user['mdark']?>;
function SetAllSkills(isOn) {
var arrSkills = new Array("str", "dex", "inst", "power", "intel", "wis", "spirit", "will", "freedom", "god");
for (var i in arrSkills) {
var clname = ( isOn ) ? "skill" : "nonactive";
if( oNode = document.getElementById( "plus_" + arrSkills[i] ) ) oNode.className=clname;
}
}
var t;
function OnClick(eEvent, This) {
DropTimer();
var oNode = eEvent.target || eEvent.srcElement;
if( oNode.nodeName != "IMG" ) return;
var nDelta = ( oNode.nextSibling ) ? -1 : 1;
MakeSkillStep(nDelta, This, 0);
}
function DropTimer() {
if (t) {
clearTimeout(t);
t = 0;
}
}
function ChangeSkill( eEvent, This ) {
var oNode = eEvent.target || eEvent.srcElement;
if( oNode.nodeName != "IMG" ) return;
var nDelta = ( oNode.nextSibling ) ? -1 : 1;
t=setTimeout(function() {MakeSkillStep(nDelta, This, 1)}, 500);
}
function MakeSkillStep(nDelta, This, IsRecurse) {
if ((nUP - nDelta ) < 0) return;
var id = This.id;
if (!arrChange[ id ]) arrChange[ id ] = 0;
if ((arrChange[ id ] + nDelta) < 0 ) {
if (oNode = document.getElementById( "minus_" + id ))
oNode.className = "nonactive";
return;
}
SetAllSkills(( nUP - nDelta ));
arrChange[ id ] += nDelta;
This.cells[ 1 ].innerHTML = parseFloat( This.cells[ 1 ].innerHTML ) + nDelta;
if( oNode = document.getElementById( id + "_inst" ) )
oNode.innerHTML = parseFloat( oNode.innerHTML ) + nDelta;
oUP.innerHTML = nUP -= nDelta;
if ( !arrChange[ id ] ) {
if( oNode = document.getElementById( "minus_" + id ) ) oNode.className = "nonactive";
} else {
if( oNode = document.getElementById( "minus_" + id ) ) oNode.className = "skill";
}
if (IsRecurse) t = setTimeout(function(){MakeSkillStep(nDelta, This, 1)}, 50);
}
function ChangeAbility( id, nDelta, inst, maxval) {
IsTimerStarted = 0;
if( ( nm_UP - nDelta ) < 0 ) return;
if( !arrChange[ id ] ) arrChange[ id ] = 0;
if( ( arrChange[ id ] + nDelta ) == 0 )  {
if( oNode = document.getElementById( "minus_" + id ) ) oNode.className = "nonactive";
}
if (nDelta > 0 && ( arrChange[ id ] + nDelta + inst ) == maxval) {
skillsArr[id] = 1;
if( oNode = document.getElementById( "plus_" + id ) ) oNode.className = "nonactive";
}
if( ( arrChange[ id ] + nDelta ) < 0 ) return;
if (nDelta > 0 && ( arrChange[ id ] + nDelta + inst ) > maxval) return;
arrChange[ id ] += nDelta;
if( ( nm_UP - nDelta ) == 0 )  {
for (var i in skillsArr) {
if( oNode = document.getElementById( "plus_" + i ) ) oNode.className = "nonactive";
}
}
if( oNode = document.getElementById( id + "_base" ) )
oNode.innerHTML = parseFloat( oNode.innerHTML ) + nDelta;
if( oNode = document.getElementById( id + "_inst" ) )
oNode.innerHTML = parseFloat( oNode.innerHTML ) + nDelta;
m_UP.innerHTML = nm_UP -= nDelta;
if ( nDelta > 0 ) {
prefix = "minus_";
} else {
prefix = "plus_";
skillsArr[id] = 0;
for (var i in skillsArr) {
if (skillsArr[i]==0)  {
if( oNode = document.getElementById( "plus_" + i ) ) oNode.className = "skill";
}
}
}
if( oNode = document.getElementById( prefix + id ) ) oNode.className = "skill";
}
function SaveSkill( This ) {
var sHref = "umenie.php?edit=save&s4i=<?=$user['sid']?>&";
for( var i in arrChange )
if( arrChange[ i ] > 0 )
sHref += "&" + i + "=" + arrChange[ i ];
document.location.href=sHref;
<? /*if (This) {
This.href = sHref;
} else {
document.URL = sHref;
}*/ ?>
return true;
}
function SaveAbility(This) {
var sHref = "umenie.php?edit=save&s4i=<?=$user['sid']?>&";
for( var i in arrChange )
if( arrChange[ i ] > 0 )
sHref += "&" + i + "=" + arrChange[ i ];
document.location.href=sHref;
<? /*if (This) {
This.href = sHref;
} else {
document.URL = sHref;
}*/ ?>
return true;
}
function ChangeButtonState(bid) {
var button = document.getElementById( "save_button"+bid );
if (button.disabled) {
button.disabled = 0;
} else {
button.disabled = 1;
}
}
</SCRIPT>
<? if($user['level']<2){ ?>
<SMALL>Подробнее о Силе, Ловкости, Интуиции и Выносливости вы можете прочитать <A href="http://capitalcity.combats.com/encicl/3_0.html#a14" target=_blank>здесь</A></SMALL><BR><br>
<? }?>
<TD width=1 bgcolor=#A0A0A0><SPAN></SPAN></TD>
<TD valign=top>
<TABLE border=0 cellspacing=1 cellpadding=0 width=100%>
<TR>

<? if($user['level']>0){ ?>
<TD class=tz id=L1 width=150 onmouseover="highl('L1',1)" onmouseout="highl('L1',0)" onclick="setlevel('L1')">Мастерство</TD>
<? }?>

<!--<TD>
<TD class=tz id=L2 width=150 onmouseover="highl('L2',1)" onmouseout="highl('L2',0)" onclick="setlevel('L2')">Магия</TD>-->
<TD>
<? if($user['level']>1){ ?>
<TD class=tz id=L3 width=150 onmouseover="highl('L3',1)" onmouseout="highl('L3',0)" onclick="setlevel('L3')">Особенности</TD>
<? }?>

<TD>
<TD class=tz id=L4 width=150 onmouseover="highl('L4',1)" onmouseout="highl('L4',0)" onclick="setlevel('L4')">Приемы</TD>

<TD>
<? if($user['level']>5){ ?>
<TD class=tz id=L7 width=150 onmouseover="highl('L7',1)" onmouseout="highl('L7',0)" onclick="setlevel('L7')">Знания</TD>
<? }?>
<TD>
<TD class=tz id=L5 width=150 onmouseover="highl('L5',1)" onmouseout="highl('L5',0)" onclick="setlevel('L5')">Состояние</TD>

<TD>
<? if($user['level']>3){ ?>
<TD class=tz id=L6 width=150 onmouseover="highl('L6',1)" onmouseout="highl('L6',0)" onclick="setlevel('L6')">Репутация</TD>
<? }?>
<TD class=tz >&nbsp</TD>
</TR>
</TABLE>
<TABLE border=0 cellspacing=1 cellpadding=0 width=100%>
<TD width=100% style='padding-left: 7'>
<div class=dtz ID=dL1>

<? if($user['level']>0){ 
?>

<table>
<tr><td colspan="4"><b>Оружие:</b></td></tr>

<tr>
<TD>&nbsp;&bull;&nbsp;Мастерство владения мечами: </TD>
<TD width=40 class="skill<? if ($user["b_mec"]!=$user["mec"]) echo "b"; ?>" align="right" width=30 id='m_axe_base'><?=$user['mec']?></TD>
<TD width=60 noWrap><small><? if ($user["b_mec"]!=$user["mec"]) echo "(<span id=\"m_axe_inst\">$user[b_mec]</span>+".($user["mec"]-$user["b_mec"]).")"; ?></small></TD>

<TD>

<IMG id="minus_m_axe" SRC=<?=IMGBASE?>/i/minus.gif class=nonactive ALT="уменьшить" onmouseup="ChangeAbility('m_axe', -1, <?=$user['mec']?>, <? echo $user["mec"]-$user["b_mec"]+5; ?>);">&nbsp;
<IMG id="plus_m_axe" SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить" onmouseup="ChangeAbility('m_axe', 1, <?=$user['mec']?>, <? echo $user["mec"]-$user["b_mec"]+5; ?>)">
</TD>
</tr>



<tr>
<TD>&nbsp;&bull;&nbsp;Мастерство владения дубинами, булавами: </TD>
<TD width=40 class="skill<? if ($user["b_dubina"]!=$user["dubina"]) echo "b"; ?>" align="right" width=30 id='m_molot_base'><?=$user['dubina']?></TD>
<TD width=60 noWrap><small><? if ($user["b_dubina"]!=$user["dubina"]) echo "(<span id=\"m_molot_inst\">$user[b_dubina]</span>+".($user["dubina"]-$user["b_dubina"]).")"; ?></small></TD>

<TD>

<IMG id="minus_m_molot" SRC=<?=IMGBASE?>/i/minus.gif class=nonactive ALT="уменьшить" onmouseup="ChangeAbility('m_molot', -1, <?=$user['dubina']?>, <? echo $user["dubina"]-$user["b_dubina"]+5; ?>)">&nbsp;
<IMG id="plus_m_molot" SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить" onmouseup="ChangeAbility('m_molot', 1, <?=$user['dubina']?>, <? echo $user["dubina"]-$user["b_dubina"]+5; ?>)">
</TD>
</tr>

<tr>
<TD>&nbsp;&bull;&nbsp;Мастерство владения ножами, кастетами: </TD>
<TD width=40 class="skill<? if ($user["b_noj"]!=$user["noj"]) echo "b"; ?>" align="right" width=30 id='m_sword_base'><?=$user['noj']?></TD>
<TD width=60 noWrap><small><? if ($user["b_noj"]!=$user["noj"]) echo "(<span id=\"m_sword_inst\">$user[b_noj]</span>+".($user["noj"]-$user["b_noj"]).")"; ?></small></TD>

<TD>
<IMG id="minus_m_sword" SRC=<?=IMGBASE?>/i/minus.gif class=nonactive ALT="уменьшить" onmouseup="ChangeAbility('m_sword', -1, <?=$user['noj']?>, <? echo $user["noj"]-$user["b_noj"]+5; ?>)">&nbsp;
<IMG id="plus_m_sword" SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить" onmouseup="ChangeAbility('m_sword', 1, <?=$user['noj']?>, <? echo $user["noj"]-$user["b_noj"]+5; ?>)">
</TD>
</tr>

<tr>
<TD>&nbsp;&bull;&nbsp;Мастерство владения топорами, секирами: </TD>
<TD width=40 class="skill<? if ($user["b_topor"]!=$user["topor"]) echo "b"; ?>" align="right" width=30 id='m_tohand_base'><?=$user['topor']?><BR></TD>
<TD width=60 noWrap><small><? if ($user["b_topor"]!=$user["topor"]) echo "(<span id=\"m_tohand_inst\">$user[b_topor]</span>+".($user["topor"]-$user["b_topor"]).")"; ?></small></TD>

<TD>

<IMG id="minus_m_tohand" SRC=<?=IMGBASE?>/i/minus.gif class=nonactive ALT="уменьшить" onmouseup="ChangeAbility('m_tohand', -1, <?=$user['topor']?>, <? echo $user["topor"]-$user["b_topor"]+5; ?>)">&nbsp;
<IMG id="plus_m_tohand" SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить" onmouseup="ChangeAbility('m_tohand', 1, <?=$user['topor']?>, <? echo $user["topor"]-$user["b_topor"]+5; ?>)">
</TD>
</tr>

<tr>
<TD>&nbsp;&bull;&nbsp;Мастерство владения магическими посохами: </TD>
<TD width=40 class="skill<? if ($user["b_posoh"]!=$user["posoh"]) echo "b"; ?>" align="right" width=30 id='m_staff_base'><?=$user['posoh']?></small><BR></TD>
<TD width=60 noWrap><small><? if ($user["b_posoh"]!=$user["posoh"]) echo "(<span id=\"m_staff_inst\">$user[b_posoh]</span>+".($user["posoh"]-$user["b_posoh"]).")"; ?></small></TD>

<TD>

<IMG id="minus_m_staff" SRC=<?=IMGBASE?>/i/minus.gif class=nonactive ALT="уменьшить" onmouseup="ChangeAbility('m_staff', -1, <?=$user['posoh']?>, <? echo $user["posoh"]-$user["b_posoh"]+5; ?>)">&nbsp;
<IMG id="plus_m_staff" SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить" onmouseup="ChangeAbility('m_staff', 1, <?=$user['posoh']?>, <? echo $user["posoh"]-$user["b_posoh"]+5; ?>)">
</TD>
</tr>


<?if($user['level'] > 3){?>
<tr><td colspan="4"><b>Магия:<b></td></tr>

<tr>
<TD>&nbsp;&bull;&nbsp;Мастерство владения стихией Огня: </TD>
<TD width=40 class="skill<? if ($user["b_mfire"]!=$user["mfire"]) echo "b"; ?>" align="right" width=30 id='m_magic1_base'><?=$user['mfire']?></small><BR></TD>
<TD width=60 noWrap><small><? if ($user["b_mfire"]!=$user["mfire"]) echo "(<span id=\"m_magic1_inst\">$user[b_mfire]</span>+".($user["mfire"]-$user["b_mfire"]).")"; ?></small></TD>

<TD>

<IMG id="minus_m_magic1"  SRC=<?=IMGBASE?>/i/minus.gif class=nonactive ALT="уменьшить" onmouseup="ChangeAbility('m_magic1', -1, <?=$user['mfire']?>, <? echo $user["mfire"]-$user["b_mfire"]+10; ?>)">&nbsp;
<IMG id="plus_m_magic1"  SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить" onmouseup="ChangeAbility('m_magic1', 1, <?=$user['mfire']?>, <? echo $user["mfire"]-$user["b_mfire"]+10; ?>)">
</TD>
</tr>

<tr>
<TD>&nbsp;&bull;&nbsp;Мастерство владения стихией Воды: </TD>
<TD width=40 class="skill<? if ($user["b_mwater"]!=$user["mwater"]) echo "b"; ?>" align="right" width=30 id='m_magic2_base'><?=$user['mwater']?></small><BR></TD>
<TD width=60 noWrap><small><? if ($user["b_mwater"]!=$user["mwater"]) echo "(<span id=\"m_magic2_inst\">$user[b_mwater]</span>+".($user["mwater"]-$user["b_mwater"]).")"; ?></small></TD>

<TD>

<IMG id="minus_m_magic2"  SRC=<?=IMGBASE?>/i/minus.gif class=nonactive ALT="уменьшить" onmouseup="ChangeAbility('m_magic2', -1, <?=$user['mwater']?>, <? echo $user["mwater"]-$user["b_mwater"]+10; ?>)">&nbsp;
<IMG id="plus_m_magic2"  SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить" onmouseup="ChangeAbility('m_magic2', 1, <?=$user['mwater']?>, <? echo $user["mwater"]-$user["b_mwater"]+10; ?>)">
</TD>
</tr>

<tr>
<TD>&nbsp;&bull;&nbsp;Мастерство владения стихией Воздуха: </TD>
<TD width=40 class="skill<? if ($user["b_mair"]!=$user["mair"]) echo "b"; ?>" align="right" width=30 id='m_magic3_base'><?=$user['mair']?></small><BR></TD>
<TD width=60 noWrap><small><? if ($user["b_mair"]!=$user["mair"]) echo "(<span id=\"m_magic3_inst\">$user[b_mair]</span>+".($user["mair"]-$user["b_mair"]).")"; ?></small></TD>

<TD>

<IMG id="minus_m_magic3"  SRC=<?=IMGBASE?>/i/minus.gif class=nonactive ALT="уменьшить" onmouseup="ChangeAbility('m_magic3', -1, <?=$user['mair']?>, <? echo $user["mair"]-$user["b_mair"]+10; ?>)">&nbsp;
<IMG id="plus_m_magic3"  SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить" onmouseup="ChangeAbility('m_magic3', 1, <?=$user['mair']?>, <? echo $user["mair"]-$user["b_mair"]+10; ?>)">
</TD>
</tr>

<tr>
<TD>&nbsp;&bull;&nbsp;Мастерство владения стихией Земли: </TD>
<TD width=40 class="skill<? if ($user["b_mearth"]!=$user["mearth"]) echo "b"; ?>" align="right" width=30 id='m_magic4_base'><?=$user['mearth']?></small><BR></TD>
<TD width=60 noWrap><small><? if ($user["b_mearth"]!=$user["mearth"]) echo "(<span id=\"m_magic4_inst\">$user[b_mearth]</span>+".($user["mearth"]-$user["b_mearth"]).")"; ?></small></TD>

<TD>

<IMG id="minus_m_magic4"  SRC=<?=IMGBASE?>/i/minus.gif class=nonactive ALT="уменьшить" onmouseup="ChangeAbility('m_magic4', -1, <?=$user['mearth']?>, <? echo $user["mearth"]-$user["b_mearth"]+10; ?>)">&nbsp;
<IMG id="plus_m_magic4"  SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить" onmouseup="ChangeAbility('m_magic4', 1, <?=$user['mearth']?>, <? echo $user["mearth"]-$user["b_mearth"]+10; ?>)">
</TD>
</tr>

<tr>
<TD>&nbsp;&bull;&nbsp;Мастерство владения магией Света: </TD>
<TD width=40 class="skill<? if ($user["b_mlight"]!=$user["mlight"]) echo "b"; ?>" align="right" width=30 id='m_magic5_base'><?=$user['mlight']?></small><BR></TD>
<TD width=60 noWrap><small><? if ($user["b_mlight"]!=$user["mlight"]) echo "(<span id=\"m_magic5_inst\">$user[b_mlight]</span>+".($user["mlight"]-$user["b_mlight"]).")"; ?></small></TD>

<TD>

<IMG id="minus_m_magic5"  SRC=<?=IMGBASE?>/i/minus.gif class=nonactive ALT="уменьшить" onmouseup="ChangeAbility('m_magic5', -1, <?=$user['mlight']?>, <? echo $user["mlight"]-$user["b_mlight"]+10; ?>)">&nbsp;
<IMG id="plus_m_magic5"  SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить" onmouseup="ChangeAbility('m_magic5', 1, <?=$user['mlight']?>, <? echo $user["mlight"]-$user["b_mlight"]+10; ?>)">
</TD>
</tr>

<tr>
<TD>&nbsp;&bull;&nbsp;Мастерство владения серой магией: </TD>
<TD width=40 class="skill<? if ($user["b_mgray"]!=$user["mgray"]) echo "b"; ?>" align="right" width=30 id='m_magic6_base'><?=$user['mgray']?></small><BR></TD>
<TD width=60 noWrap><small><? if ($user["b_mgray"]!=$user["mgray"]) echo "(<span id=\"m_magic6_inst\">$user[b_mgray]</span>+".($user["mgray"]-$user["b_mgray"]).")"; ?></small></TD>

<TD>

<IMG id="minus_m_magic6"  SRC=<?=IMGBASE?>/i/minus.gif class=nonactive ALT="уменьшить" onmouseup="ChangeAbility('m_magic6', -1, <?=$user['mgray']?>, <? echo $user["mgray"]-$user["b_mgray"]+10; ?>)">&nbsp;
<IMG id="plus_m_magic6"  SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить" onmouseup="ChangeAbility('m_magic6', 1, <?=$user['mgray']?>, <? echo $user["mgray"]-$user["b_mgray"]+10; ?>)">
</TD>
</tr>

<tr>
<TD>&nbsp;&bull;&nbsp;Мастерство владения магией Тьмы: </TD>
<TD width=40 class="skill<? if ($user["b_mdark"]!=$user["mdark"]) echo "b"; ?>" align="right" width=30 id='m_magic7_base'><?=$user['mdark']?></small><BR></TD>
<TD width=60 noWrap><small><? if ($user["b_mdark"]!=$user["mdark"]) echo "(<span id=\"m_magic7_inst\">$user[b_mdark]</span>+".($user["mdark"]-$user["b_mdark"]).")"; ?></small></TD>

<TD>

<IMG id="minus_m_magic7"  SRC=<?=IMGBASE?>/i/minus.gif class=nonactive ALT="уменьшить" onmouseup="ChangeAbility('m_magic7', -1, <?=$user['mdark']?>, <? echo $user["mdark"]-$user["b_mdark"]+10; ?>)">&nbsp;
<IMG id="plus_m_magic7"  SRC=<?=IMGBASE?>/i/plus.gif class=skill ALT="увеличить" onmouseup="ChangeAbility('m_magic7', 1, <?=$user['mdark']?>, <? echo $user["mdark"]-$user["b_mdark"]+10; ?>)">
</TD>
</tr>
<?}?>
</table>
<TABLE>
<TR valign="middle">
<TD><INPUT type="button" value="сохранить" disabled id="save_button1" onclick="SaveAbility()"></TD>
<TD><INPUT type="checkbox" onClick="ChangeButtonState(1)"></TD>
</TR>
</TABLE>
<?}?>

</div>
<div class=dtz ID=dL2>
<BR>
</div>
<div class=dtz ID=dL3>
<div style="padding:20px">
  <?
    if (!$user["in_tower"]) {
      if ($fsum<$user["level"]+1) {
        foreach ($features as $k=>$v) {
          $good=1;
          if (@$v["needlevel"] && $v["needlevel"]+$user[$k]>$user["level"]) $good=0;
          if (@$v["needvinos"] && $v["needvinos"]+($user[$k]*5)>$user["vinos"]) $good=0;
          if (@$v["needmudra"] && $v["needmudra"]+($user[$k]*5)>$user["mudra"]) $good=0;
          if ($good) {
            if ($user[$k]<5) echo "&bull; <A href=\"umenie.php?raisefeature=$k\" onclick=\"return confirm('Вы уверены, что хотите выбрать особенность &quot;$v[name]&quot;?')\">$v[name]".($user[$k]>0?" - ".($user[$k]+1):"")."</A><BR>
            <SMALL>$v[descr] ".$v["bonus".($user[$k]+1)].".</SMALL><BR><BR>";
          }
        }
        echo "<br>";
      }
    }
    echo "
    <b>Выбранные особенности:</b><br><br>";
    foreach ($features as $k=>$v) {
      if ($user[$k]) echo "&bull; $v[name] ".($user[$k]>1?" - $user[$k]":"")."<br><SMALL>$v[descr] ".$v["bonus".($user[$k])].".</SMALL><br><br>";
    }
  ?>  
  </div>
<BR>
</div>
<div class=dtz ID=dL4>
<?


echo"<SCRIPT>
var p_name;

function redirectto (s) {
    location = s;
}

function show_div(o) {
    if (p_name) {document.all[p_name].style.display=\"none\"};
    p_name = o;
    document.all[o].style.display=\"\";
}
</SCRIPT>
<table border=0 cellspacing=0 cellpadding=0 ><tr valign=\"top\"><td valign=\"top\" width=\"100%\" style=\"padding-right:20px\">
<B>Выбранные приёмы:</B>
<TABLE width=195 cellpadding=0 cellspacing=0>
<TR>
</TR><TR><TD colspan=5 height=3><SPAN></SPAN></TD></TR><TR>";

 #201...220 - приемы

$res=mq("select slot,id_thing from puton where id_person='".$_SESSION['uid']."' and slot>=201 and slot<=220;");
//  $res=db_use('query',"select slot,id_thing from puton where id_person='".$this->id_person."' and slot>=201 and slot<=210;");
 while ($s=mysql_fetch_array($res)) {

   $puton[$s['slot']]=$s['slot']; // =new prieminfo($s['id_thing'],0);
   $puton2[$s['slot']]=$s['id_thing'];
 }


for ($i=201;$i<=205;$i++) {
    echo"<TD>";

    if ($puton[$i]) {
        printpriem(new prieminfo($puton2[$i],0),$myinfo,0);
    } else {
        echo"<IMG style=\"\" width=40 height=25 src='".IMGBASE."/i/misc/icons/clear.gif'>";
    }
    echo "</TD>";
}unset($i);

for ($i=211;$i<=215;$i++) {
    if ($i-210>$user["slots"]) break;
    echo"<TD>";

    if ($puton[$i]) {
        printpriem(new prieminfo($puton2[$i],0),$myinfo,0);
    } else {
        echo"<IMG style=\"\" width=40 height=25 src='".IMGBASE."/i/misc/icons/clear.gif'>";
    }
    echo "</TD>";
}unset($i);

echo "</TR><TR><TD colspan=5 height=3><SPAN></SPAN></TD></TR><TR>";
for ($i=206;$i<=210;$i++) {
    echo"<TD>";
    if ($puton[$i]) {
        printpriem(new prieminfo($puton2[$i],0),$myinfo,0);
    } else {
        echo"<IMG style=\"\" width=40 height=25 src='".IMGBASE."/i/misc/icons/clear.gif'>";
    }
    echo "</TD>";
}unset($i);

for ($i=216;$i<=220;$i++) {
    if ($i-210>$user["slots"]) break;
    echo"<TD>";

    if ($puton[$i]) {
        printpriem(new prieminfo($puton2[$i],0),$myinfo,0);
    } else {
        echo"<IMG style=\"\" width=40 height=25 src='".IMGBASE."/i/misc/icons/clear.gif'>";
    }
    echo "</TD>";
}unset($i);


function print_priems($res,$myinfo) {
global $all;
$x=0;
while ($i<mysql_num_rows($res)) {
    $i++;$j++;$s=mysql_fetch_array($res);
    #if ($j>9) {$j=1;echo "</TR><TR>";}
    $priem1=new prieminfo($s['id_priem'],0);
    $check1=$priem1->check_hars(0);
    if ((!$_GET['all'] && $check1) OR ($_GET['all'])) {$x=1;    printpriem($priem1,$myinfo, ($s['ifa']?2:1)); }
}
return $x;
}
$nazvs1=array(1=>"hit",2=>"block",3=>"counter",4=>"krit",5=>"parry",6=>"multi",7=>"hp",8=>"blood",9=>"spirit",10=>"fire",11=>"water",12=>"air",13=>"earth",14=>"light_magic",15=>"gray_magic",16=>"dark_magic");
$nazvs2=array(1=>"Приемы атаки",2=>"Приемы защиты",3=>"Приемы контрударов",4=>"Приемы критических ударов",5=>"Приемы парирования",6=>"Комбо-приемы",7=>"Приемы крови",8=>"Приемы жертвы",9=>"Приемы силы духа",10=>"Заклинания Огня",11=>"Заклинания Воды",12=>"Заклинания Воздуха",13=>"Заклинания Земли",14=>"Заклинания магии Света",15=>"Заклинания Серой магии",16=>"Заклинания магии Тьмы");
echo "</TABLE><BR><DIV id='hidden_div_all' style='display: none'><B>Приёмы для выбора:</B>
<TABLE cellpadding=0 cellspacing=0><TR><TD>";
$res= mq("select pr.id_priem, (select p.id_thing from puton p where p.id_person='".$_SESSION['uid']."' and p.id_thing=pr.id_priem) as ifa from priem pr where pr.hide='0' and (buystroke=0 or pr.id_priem in (select stroke from userstrokes where user='$user[id]')) order by minlevel");
//$res=db_use('query',"select pr.id_priem, (select p.id_thing from puton p where p.id_person='".$myinfo->id_person."' and p.id_thing=pr.id_priem) as ifa from priem pr");
print_priems($res,$myinfo);
echo "</TD></TR></TABLE></DIV>";
if (@$_GET["all"]) $all=$_GET["all"];
for($i=1;$i<=16;$i++) {
if ($all OR (($i<10) OR ($i==10 && $user['mfire']>=7) OR ($i==11 && $user['mwater']>=7) OR ($i==12 && $user['mair']>=7) OR ($i==13 && $user['mearth']>=7) OR ($i==14 && $user['mlight']>=2) OR ($i==15 && $user['mgray']>=2) OR ($i==16 && $user['mdark']>=2) )) {
    echo "<DIV id='hidden_div_".$nazvs1[$i]."' style='display: none'><SPAN><B>".$nazvs2[$i]."</B><BR></SPAN><TABLE cellpadding=0 border=0 cellspacing=0><TR><TD>";
      $res= mq("select pr.id_priem, (select p.id_thing from puton p where p.id_person='".$_SESSION['uid']."' and p.id_thing=pr.id_priem) as ifa from priem pr where pr.type='".$i."' and pr.hide='0' and (buystroke=0 or pr.id_priem in (select stroke from userstrokes where user='$user[id]'));");
      $shows[$i]=print_priems($res,$myinfo);echo "</TD></TR></TABLE></DIV>";
    }
}

echo"</td><td valign=\"top\" style=\"padding-right:20px\">

<FIELDSET><LEGEND>Категории</LEGEND><SMALL><NOBR>
<A href=\"#\" onclick='show_div(\"hidden_div_all\"); return(false)'>Все</A><BR>";
for($i=1;$i<=16;$i++) {
//str - сила
//dex - ловокость
//inst - интуиция
//power - выносливость
//intel - интеллект
//wis - мудрость
//
/*
skillsArr["m_axe"] = <?=$user['mec']?>;
skillsArr["m_molot"] = <?=$user['dubina']?>;
skillsArr["m_sword"] = <?=$user['noj']?>;
skillsArr["m_tohand"] = <?=$user['topor']?>;
skillsArr["m_magic1"] = <?=$user['mfire']?>;
skillsArr["m_magic2"] = <?=$user['mwater']?>;
skillsArr["m_magic3"] = <?=$user['mair']?>;
skillsArr["m_magic4"] = <?=$user['mearth']?>;
skillsArr["m_magic5"] = <?=$user['mlight']?>;
skillsArr["m_magic6"] = <?=$user['mgray']?>;
skillsArr["m_magic7"] = <?=$user['mdark']?>;*/
if (((($i<10) OR ($i==10 && $user['mfire']>=7) OR ($i==11 && $user['mwater']>=7) OR ($i==12 && $user['mair']>=7) OR ($i==13 && $user['mearth']>=7) OR ($i==14 && $user['mlight']>=2) OR ($i==15 && $user['mgray']>=2) OR ($i==16 && $user['mdark']>=2)) && $shows[$i]) OR ($_GET['all'])) {
echo "<A href=\"#\" onclick='show_div(\"hidden_div_".$nazvs1[$i]."\"); return(false)'>".$nazvs2[$i]."</A><BR>";
}
}
echo"</FIELDSET></NOBR></SMALL>
<SCRIPT>show_div(\"".($showcat?$showcat:'hidden_div_all')."\");</SCRIPT></td><td valign=\"top\" align=\"right\">
<table cellspacing=0 cellpadding=0 align=right><tr>
<form name=F1 action=\"?\" method=\"GET\">
<input type=\"hidden\" name=\"show_abil\" value=\"1\">
<input type=\"hidden\" name=\"rnd\" value=\"".rand(1,5000000)."\">
<td>
<FIELDSET><LEGEND>Показывать приёмы</LEGEND>

&nbsp;<INPUT TYPE=radio ID=A1 NAME=all value=0 ".($_GET['all']?'':'checked ')."onclick=\"form.submit()\"> <LABEL FOR=A1>доступные мне</LABEL><BR>
&nbsp;<INPUT TYPE=radio ID=A2 NAME=all value=1 ".($_GET['all']?'checked ':'')."onclick=\"form.submit()\"> <LABEL FOR=A2>все</LABEL>

</FIELDSET>
<BR>
<a href=\"/umenie.php?clear_abil=all&all=".(0+$_GET['all']).($showcat?'&show_cat='.$showcat:'')."&".rand(1,5000000)."\">Очистить</a><br>
<br>
<a href=\"javascript:kmp()\">Запомнить</a>
<p style=\"MARGIN-LEFT: 10px;\" align=\"left\"><small>";
$res=mq("select * from complect where user='".$_SESSION['uid']."' and type=2 order by name");
unset ($i);
while ($i<mysql_num_rows($res)) {
  $i++;$s=mysql_fetch_array($res);
  $s['name']=str_replace("'","",$s["name"]);
  echo "<img src=\"http://img.combats.com/i/clear.gif\" width=\"13\" height=\"13\" alt=\"Удалить набор\"
  onclick=\"if (confirm('Удалить набор ".$s['name']."?')) {location='umenie.php?delset=".$s['id']."&all".(0+$_GET['all']).($showcat?'&show_cat='.$showcat:'')."&".rand(0,50000000)."'}\" style=\"cursor:pointer\">
      <a href=\"/umenie.php?complect=".$s['id']."&all".(0+$_GET['all']).($showcat?'&show_cat='.$showcat:'')."&".rand(0,50000000)."\">".$s['name']."</a><br>";
}
unset($i);


echo "</small></p>

</td>
</form>
</tr></table>

</td><td>&nbsp;</td>
</tr></table>

<BR><BR><BR><BR>
"; ?></div>
<div class=dtz ID=dL5>
<SMALL>
</SMALL>
<b>Эффекты:</b><br>

<?
 $rsb = mq("SELECT * FROM `effects` WHERE `owner` = ".$user['id']." and (`type`=188 or `type`=11 or `type`=12 or `type`=13 or `type`=14  or `type`=22  or `type`=202 or `type`=201 or `type`=400 or `type`=1022 or type=9 or type=9999 or type=9994 or type=9990 or type=9992 or type=9993) order by `type` desc;");
 while ($row =mysql_fetch_array($rsb)) {
   if ($row["type"]==9 || $row["type"]==9999 || $row["type"]==9994 || $row["type"]==9990 || $row["type"]==9992 || $row["type"]==9993) {
     echo "<br><SMALL> <b>$row[name]</b>. Ещё <i>".secs2hrs($row["time"]-time())."</i></SMALL>";   
   }

if ($row['type'] == 22) {

    if ($row['time']) {
        $eff=$row['time'];
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
echo "<br><SMALL><IMG height=15 src=\"".IMGBASE."/i/sh/spell_freedom30.gif\" width=24 alt=\"Магия свободы\"> Свобода. Магия истинного хаоса еще <i>$out</i></SMALL>";
unset($out);
}
}

if ($row['type'] == 202) {

    if ($row['time']) {
        $eff=$row['time'];
        $tt=time();
        $time_still=$eff-$tt;
        $tmp = floor($time_still/3600);
    $id=0;
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
echo "<br><SMALL><IMG height=15 src=\"".IMGBASE."/i/magic/spell_powerup10.gif\" width=24 alt=\"Сокрушение\"> Сокрушение. Увеличен физический урон на 25% еще <i>$out</i></SMALL>";
unset($out);
}
}
if ($row['type'] == 201) {

    if ($row['time']) {
        $eff=$row['time'];
        $tt=time();
        $time_still=$eff-$tt;
        $tmp = floor($time_still/3600);
    $id=0;
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
echo "<br><SMALL><IMG height=15 src=\"".IMGBASE."/i/magic/spell_protect10.gif\" width=24 alt=\"Защита от оружия\"> Защита от оружия. Уменьшен наносимый по Вам физический урон на 30% еще <i>$out</i></SMALL>";
unset($out);
}
}
if ($row['type'] == 188) {

    if ($row['time']) {
        $eff=$row['time'];
        $tt=time();
        $time_still=$eff-$tt;
        $tmp = floor($time_still/3600);
    $id=0;
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
echo "<br><SMALL> ";
if ($row["name"]=="Зелье Могущества") echo "<img src=\"".IMGBASE."/i/misc/icon_pot_base_50_str.gif\">";
if ($row["name"]=="Зелье Стремительности") echo "<img src=\"".IMGBASE."/i/misc/icon_pot_base_50_dex.gif\">";
if ($row["name"]=="Зелье Разума") echo "<img src=\"".IMGBASE."/i/misc/icon_pot_base_50_intel.gif\">";
if ($row["name"]=="Зелье Прозрения") echo "<img src=\"".IMGBASE."/i/misc/icon_pot_base_50_inst.gif\">";
if ($row["name"]=="Самодельный эликсир") echo "<img src=\"".IMGBASE."/i/misc/icon_elixir.gif\">";

echo " <b>$row[name]</b> ";
if ($row["sila"]) echo " сила + $row[sila] ";
if ($row["lovk"]) echo " ловкость + $row[lovk] ";
if ($row["inta"]) echo " интуиция + $row[inta] ";
if ($row["vinos"]) echo " выносливость + $row[vinos] ";
if ($row["intel"]) echo " интеллект + $row[intel] ";
if ($row["mf"]) {
  $tmp=explode("-", $row["mf"]);
  $tmp2=explode("-", $row["mfval"]);
  $i=0;
  $mfnames=array("mfuvorot"=>"мф. увёртывания", "mfauvorot"=>"мф. против увёртывания");
  foreach ($tmp as $k=>$v) {
    $i++;
    if ($i>1) echo ", ";
    echo "$mfnames[$v]: +$tmp2[$k]";
  }
}
echo " ещё <i>$out</i></SMALL>";
unset($out);
}
}

if ($row['type'] == 1022) {

    if ($row['time']) {
        $eff=$row['time'];
        $tt=time();
        $time_still=$eff-$tt;
        $tmp = floor($time_still/3600);
    $id=0;
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
echo "<br><SMALL><IMG height=15 src=\"".IMGBASE."/i/magic/hidden.gif\" width=24 alt=\"Невидимость\"> Невидимость еще <i>$out</i></SMALL>";
unset($out);
}
}
if ($row['type'] == 400) {

    if ($row['time']) {
        $eff=$row['time'];
        $tt=time();
        $time_still=$eff-$tt;
        $tmp = floor($time_still/3600);
    $id=0;
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
if ($row['stihiya']==ogon) {
echo "<br><SMALL><IMG height=15 src=\"".IMGBASE."/i/sh/element_fire7.gif\" width=24 alt=\"Астрал стихий (огонь)\"> Астрал стихий (огонь) еще <i>$out</i></SMALL>";
}elseif ($row['stihiya']==voda) {
echo "<br><SMALL><IMG height=15 src=\"".IMGBASE."/i/sh/element_water7.gif\" width=24 alt=\"Астрал стихий (вода)\"> Астрал стихий (вода) еще <i>$out</i></SMALL>";
}elseif ($row['stihiya']==vozduh) {
echo "<br><SMALL><IMG height=15 src=\"".IMGBASE."/i/sh/element_air7.gif\" width=24 alt=\"Астрал стихий (воздух)\"> Астрал стихий (воздух) еще <i>$out</i></SMALL>";
}elseif ($row['stihiya']==zemlya) {
echo "<br><SMALL><IMG height=15 src=\"".IMGBASE."/i/sh/element_eath7.gif\" width=24 alt=\"Астрал стихий (земля)\"> Астрал стихий (земля) еще <i>$out</i></SMALL>";
}
unset($out);
}
}


    if ($row['type']==11 or $row['type']==12 or $row['type']==13 or $row['type']==14) {
        if ($row['type'] == 14) {$trt="неизлечимая";}
        elseif ($row['type'] == 13) {$trt="тяжелая";}
        elseif ($row['type'] == 12) {$trt="средняя";}
        elseif ($row['type'] == 11) {$trt="легкая";}

        echo "<br><IMG height=15 src=\"".IMGBASE."/i/travma2.gif\" width=24 alt=\"Ослаблены характеристики\"><SMALL>У Вас $trt травма <b>\"{$row['name']}\"</b> - еще ".floor(($row['time']-time())/60/60)." ч. ".round((($row['time']-time())/60)-(floor(($row['time']-time())/3600)*60))." мин.</SMALL>";
}
                if ($row['type'] == 11 OR $row['type'] == 12 OR $row['type'] == 13 OR $row['type'] == 14) {
                    if ($row['sila']) echo "<SMALL><br>Ослаблен параметр \"сила\".</SMALL>";
                    if ($row['lovk']) echo "<SMALL><br>Ослаблен параметр \"ловкость\".</SMALL>";
                    if ($row['inta']) echo "<SMALL><br>Ослаблен параметр \"интуиция\".</SMALL>";
                }
}
echo "<div>&nbsp;</div><b>Выносливость</b><ul style=\"margin-top:0px;margin-bottom:0px\"><li>уровень жизни (HP) +30</li></ul>";
if ($user["vinos"]>=25) {
  echo "<br><b>Стальное тело</b><ul style=\"margin-top:0px;margin-bottom:0px\">";
  if ($user["vinos"]>=125) echo "
  <li>Уровень жизни (HP): +250 </li>
  <li>Защита от урона (%): +25</li>";
  elseif ($user["vinos"]>=100) echo "
  <li>Уровень жизни (HP): +250 </li>";
  elseif ($user["vinos"]>=75) echo "
  <li>Уровень жизни (HP): +175 </li>";
  elseif ($user["vinos"]>=50) echo "
  <li>Уровень жизни (HP): +100 </li>";
  elseif ($user["vinos"]>=25) echo "
  <li>Уровень жизни (HP): +50 </li>";
  echo "</ul>";
}
if ($user["lovk"]>=25) {
  echo "<br><b>Скорость молнии</b><ul style=\"margin-top:0px;margin-bottom:0px\">";
  if ($user["lovk"]>=125) echo "
  <li>Абс. мф. увёртывания (%): +5</li>
  <li>Мф. против крит. удара (%): +40</li>
  <li>Мф. увёртывания (%): +105</li>
  <li>Мф. парирования (%): +15</li>";
  elseif ($user["lovk"]>=100) echo "
  <li>Мф. против крит. удара (%): +40</li>
  <li>Мф. увёртывания (%): +105</li>
  <li>Мф. парирования (%): +15</li>";
  elseif ($user["lovk"]>=75) echo "
  <li>Мф. против крит. удара (%): +15</li>
  <li>Мф. увёртывания (%): +35</li>
  <li>Мф. парирования (%): +15</li>";
  elseif ($user["lovk"]>=50) echo "
  <li>Мф. против крит. удара (%): +15</li>
  <li>Мф. увёртывания (%): +35</li>
  <li>Мф. парирования (%): +5</li>";
  elseif ($user["lovk"]>=25) echo "
  <li>Мф. парирования (%): +5</li>";
  echo "</ul>";
}
if ($user["sila"]>=25) {
  echo "<br><b>Чудовищная сила</b><ul style=\"margin-top:0px;margin-bottom:0px\">";
  if ($user["sila"]>=125) echo "
  <li>Минимальный урон: +10</li>
  <li>Максимальный урон: +10</li>
  <li>Мф. мощности удара (%): +25</li>";
  elseif ($user["sila"]>=100) echo "
  <li>Мф. мощности удара (%): +25</li>";
  elseif ($user["sila"]>=75) echo "
  <li>Мф. мощности удара (%): +17</li>";
  elseif ($user["sila"]>=50) echo "
  <li>Мф. мощности удара (%): +10</li>";
  elseif ($user["sila"]>=25) echo "
  <li>Мф. мощности удара (%): +5</li>";
  echo "</ul>";
}

if ($user["intel"]>=25) {
  echo "<br><b>Разум</b><ul style=\"margin-top:0px;margin-bottom:0px\">";
  if ($user["intel"]>=125) echo "
  <li>Мф. мощности стихий (%): +35</li>";
  elseif ($user["intel"]>=100) echo "
  <li>Мф. мощности стихий (%): +25</li>";
  elseif ($user["intel"]>=75) echo "
  <li>Мф. мощности стихий (%): +17</li>";
  elseif ($user["intel"]>=50) echo "
  <li>Мф. мощности стихий (%): +10</li>";
  elseif ($user["intel"]>=25) echo "
  <li>Мф. мощности стихий (%): +5</li>";
  echo "</ul>";
}


if ($user["inta"]>=25) {
  echo "<br><b>Предчувствие</b><ul style=\"margin-top:0px;margin-bottom:0px\">";
  if ($user["inta"]>=125) echo "
  <li>Абс. мф. крит. удара (%): +5</li>
  <li>Мф. критического удара (%): +105</li>
  <li>Мф. против увёртывания (%): +45</li>
  <li>Мф. мощности крит. удара (%): +25</li>";
  elseif ($user["inta"]>=100) echo "
  <li>Мф. критического удара (%): +105</li>
  <li>Мф. против увёртывания (%): +45</li>
  <li>Мф. мощности крит. удара (%): +25</li>";
  elseif ($user["inta"]>=75) echo "
  <li>Мф. критического удара (%): +35</li>
  <li>Мф. против увёртывания (%): +15</li>
  <li>Мф. мощности крит. удара (%): +25</li>";
  elseif ($user["inta"]>=50) echo "
  <li>Мф. критического удара (%): +35</li>
  <li>Мф. против увёртывания (%): +15</li>
  <li>Мф. мощности крит. удара (%): +10</li>";
  elseif ($user["inta"]>=25) echo "
  <li>Мф. мощности крит. удара (%): +10</li>";
  echo "</ul>";
}

if ($user["mudra"]>=25) {
  echo "<br><b>Сила мудрости</b><ul style=\"margin-top:0px;margin-bottom:0px\">";
  if ($user["mudra"]>=125) echo "
  <li>Уровень маны: +250 </li>
  <li>Скорость восстановления маны: +500%</li>
  <li>Подавление защиты от магии: +3%</li>";
  elseif ($user["mudra"]>=100) echo "
  <li>Уровень маны: +250 </li>
  <li>Скорость восстановления маны: +500%</li>";
  elseif ($user["mudra"]>=75) echo "
  <li>Уровень маны: +175 </li>
  <li>Скорость восстановления маны: +375%</li>";
  elseif ($user["mudra"]>=50) echo "
  <li>Уровень маны: +100 </li>";
  elseif ($user["mudra"]>=25) echo "
  <li>Уровень маны: +50 </li>";
  echo "</ul>";
}

if ($user["spirit"]>=25) {
  if ($user["spirit"]>=100) $n="Очищение";
  if ($user["spirit"]>=75) $n="Путь Духа";
  if ($user["spirit"]>=50) $n="Духовное Исцеление";
  else $n="Духовная Защита";
  echo "<br><b>$n</b><ul style=\"margin-top:0px;margin-bottom:0px\">";
  if ($user["spirit"]>=100) echo "<li>Смерть очищает вас от негативных эффектов заклинаний, проклятий, болезней и ядов в текущем бою</li>";
  if ($user["spirit"]>=75) echo "<li>Воскрешение и Спасение тратят вдвое меньше силы духа</li>";
  if ($user["spirit"]>=50) echo "<li>Каждый бой вы начинаете под действием магии <img src=\"".IMGBASE."/i/sh/preservation.gif\"> \"Спасение\"</li>";
  if ($user["spirit"]>=25) echo "<li>Жизнь после смерти дает вам прием \"Призрачная Защита\"</li>";
  echo "</ul>";
}

echo "<br><b>Пристрастия</b><ul style=\"margin-top:0px;margin-bottom:0px\">";
$addictions=array("sila"=>"Сила", "lovk"=>"Ловкость", "inta"=>"Интуиция", "intel"=>"Интеллект", "hit"=>"Защита от урона", "mag"=>"Защита от магии", "kol"=>"Защита от колющего урона", "rej"=>"Защита от режущего урона", "drob"=>"Защита от дробящего урона", "rub"=>"Защита от рубящего урона", "fire"=>"Защита от магии огня", "water"=>"Защита от магии воды", "air"=>"Защита от магии воздуха", "earth"=>"Защита от магии земли", "mana"=>"Скорость восстановления маны", "hp"=>"Скорость восстановления жизни");
foreach ($addictions as $k=>$v) {
  if ($user["{$k}addict"]>=300) echo "<li>$v [".addictval($user["{$k}addict"])."]</li>";
}
echo "</ul>";
$setitem=mqfa("select * from inventory where id='$user[setitem]'");
if ($setitem["dressed"] && ($setitem['gmeshok'] OR $setitem['honor'] OR $setitem['mfhitp'] OR $setitem['mfmagp'] OR $setitem['gsila'] OR $setitem['mfdhit'] OR $setitem['mfdmag']  OR $setitem['mfkritpow']  OR $setitem['mfantikritpow'] OR $setitem['mfparir']  OR $setitem['mfshieldblock'] OR $setitem['mfcontr']  OR $setitem['mfrub'] OR $setitem['mfkol']  OR $setitem['mfdrob'] OR $setitem['mfrej'] OR $setitem['mfkrit'] OR $setitem['mfakrit']  OR $setitem['mfuvorot'] OR $setitem['mfauvorot']  OR $setitem['glovk'] OR $setitem['ghp'] OR $setitem['gmana'] OR $setitem['ginta'] OR $setitem['gintel'] OR $setitem['gnoj'] OR $setitem['gtopor'] OR $setitem['gdubina'] OR $setitem['gmech'] OR $setitem['gfire'] OR $setitem['gwater'] OR $setitem['gair'] OR $setitem['gearth'] OR $setitem['gearth'] OR $setitem['glight'] OR $setitem['ggray'] OR $setitem['gdark'] OR $setitem['minu'] OR $setitem['maxu'] OR $setitem['bron1'] OR $setitem['bron2'] OR $setitem['bron3'] OR $setitem['bron4'] OR $setitem['mffire'] OR $setitem['mfwater'] OR $setitem['mfearth'] OR $setitem['mfair'] || $setitem["manausage"] || $setitem["mfdair"] || $setitem["mfdwater"] || $setitem["mfdearth"] || $setitem["mfdfire"])) {
  echo "<div>&nbsp;</div><b>Бонус комплектов</b><div style=\"padding-left:24px\">";
  echo itemmfs($setitem);
  echo "</div>";
}
$stats=mqfa("select exp, win, lose, nich from userstats where id='$user[id]'");
?>
</div>
</div>
<div class=dtz ID=dL6>
<div style="padding:20px">
<?php 
$znTowerLevel = mysql_result(mysql_query("SELECT reputation FROM zn_tower WHERE user_id = " . $_SESSION['uid']), 0, 0);
$znRep = '';
$znRepNext = 100;
if ($znTowerLevel) {
    if ($znTowerLevel >= 100 && $znTowerLevel <= 999) {
        $znRep     = 'Посвящённый 1-го круга, ';
        $znRepNext = 999;
        
    }
    if ($znTowerLevel >= 1000) {
        $znRep = 'Посвящённый 2-го круга, ';
        $znRepNext = 999;
    }
} else {
    $znTowerLevel = 0;
}
echo '&bull; <strong>Храм Знаний</strong> - ' . $znRep . $znTowerLevel . '/' . $znRepNext;
?>
<hr />
&nbsp; &nbsp; &nbsp; <B>За сегодня</B><BR>
&bull; набрано опыта: <?=$user["exp"]-$stats["exp"]?><BR>
<? if ($user["klan"]) echo "&bull; кланового опыта: ".round(($user["exp"]-$stats["exp"])/5)."<br>"; ?>
&bull; одержано побед: <?=$user["win"]-$stats["win"]?><BR>
&bull; проиграно битв: <?=$user["lose"]-$stats["lose"]?><BR>
&bull; безрезультатно: <?=$user["nich"]-$stats["nich"]?><BR>
&bull; опыта за бой: <?
  if ($user["win"]+$user["lose"]+$user["nich"]-$stats["win"]-$stats["lose"]-$stats["nich"]>0) 
  echo round(($user["exp"]-$stats["exp"])/($user["win"]+$user["lose"]+$user["nich"]-$stats["win"]-$stats["lose"]-$stats["nich"]));
  else echo 0;
  echo "<BR>";
?>
</div>
<div style="padding-left:20px">
<?
  $r=mq("SELECT room, `time` FROM `visit_podzem` WHERE `login`='".$user['login']."' and `time`>'".time()."'");
  while ($rec=mysql_fetch_assoc($r)) {
    echo "До посещения локации \"".$rooms[$rec["room"]]."\" ".secs2hrs($rec["time"]-time())."<br>";
  }
  $rec=mqfa("select * from qtimes where user='$user[id]'");
  if ($rec["q1"]>time()) echo "Сундучёк мироздателя через ".secs2hrs($rec["q1"]-time())."<br>";
  if ($rec["q2"]>time()) echo "Поиск травы в чистом поле через ".secs2hrs($rec["q2"]-time())."<br>";
  if ($rec["q6"]>time()) echo "Поиск травы в клановом замке через ".secs2hrs($rec["q6"]-time())."<br>";
  if ($rec["q16"]>time()) echo "Приготовление зелья в лаборатории алхимика через ".secs2hrs($rec["q16"]-time())."<br>";
  if ($rec["q18"]>time()) echo "Бой с подземными тварями через ".secs2hrs($rec["q18"]-time())."<br>";
?></div>
<BR>
</div>
<div class=dtz ID=dL7>
<BR>
<?
  function remnumbers($s) {
    $s=str_replace("0","",$s);
    $s=str_replace("1","",$s);
    $s=str_replace("4","",$s);
    $s=str_replace("5","",$s);
    $s=str_replace("6","",$s);
    $s=str_replace("7","",$s);
    $s=str_replace("8","",$s);
    $s=str_replace("9","",$s);
    return $s;
  }

  include_once "incl/strokedata.php";
  foreach ($strokes as $k=>$v) {
    if ($k=="wis_air_charge_shock" || $k=="wis_air_charge_gain" || $k=="wis_air_charge_dmg") continue;
    $bookdata[$k]="<b>$v->name</b>";
  }
  $bookdata["wis_water_shield"]="<b>Иней</b>";
  $bookdata["wis_earth_dmg"]="<b>Булыжник</b>";
  $bookdata["wis_fire_flametongue"]="<b>Язык пламени</b>";
  $bookdata["wis_earth_strike"]="<b>Каменный удар</b>";
  $bookdata["wis_earth_flower"]="<b>Каменный цветок</b>";
  
  
  /*
  $bookdata["hit_empower"]="<b>Усиленные удары</b>";
  
  $bookdata["wis_air_spark"]="<b>Искра</b>";
  $bookdata["wis_fire_sacrifice"]="<b>Жетрва огню</b>";
  $bookdata["wis_gray_mastery"]="<b>Серое мастерство</b>";
  $bookdata["block_magicshield"]="<b>Магическая защита</b>";  
  $bookdata["wis_water_break"]="<b>Оледенение: разбить</b>";
  $bookdata["wis_earth_summon"]="<b>Призвать каменного стража</b>";
  $bookdata["wis_air_speed"]="<b>Скорость молнии</b>";
  $bookdata["wis_light_shield"]="<b>Защита света</b>";
  $bookdata["wis_fire_flametongue"]="<b>Язык пламени</b>";
  $bookdata["wis_air_sacrifice"]="<b>Жертва воздуху</b>";
  $bookdata["counter_ward"]="<b>Осторожность</b>";
  $bookdata["wis_water_cleance"]="<b>Чистота воды</b>";*/

  $bookdata["slot1"]="<b>Тайное Знание (том 1)</b>";
  $bookdata["slot2"]="<b>Тайное Знание (том 2)</b>";
  $bookdata["slot3"]="<b>Тайное Знание (том 3)</b>";
  $bookdata["slot4"]="<b>Тайное Знание (том 4)</b>";
  $bookdata["slot5"]="<b>Рыцарское Знание (том 1)</b>";
  $bookdata["slot6"]="<b>Рыцарское Знание (том 2)</b>";
  $bookdata["slot7"]="<b>Рыцарское Знание (том 3)</b>";
  $bookdata["slot8"]="<b>Рыцарское Знание (том 4)</b>";
  $bookdata["slot9"]="<b>Тайное Знание (утерянный том)</b>";
  $bookdata["slot10"]="<b>Тайное Знание (секретный том)</b>";
  $i=1;
  $slots=mqfa1("select slotbooks from userdata where id='$user[id]'");
  $pow=1;
  $books=array();
  while ($i<=10) {
    if ($slots%($pow*2)>=$pow)  $books["slot$i"]=1;
    $pow*=2;
    $i++;
  }
  $r=mq("select stroke from userstrokes where user='$user[id]'");
  while ($rec=mysql_fetch_assoc($r)) {
    $k=remnumbers($strokes["ids"][$rec["stroke"]]);
    if ($k=="wis_air_charge_shock" || $k=="wis_air_charge_gain" || $k=="wis_air_charge_dmg") continue;
    $books[$k]=1;
  }
  echo "<table>";
  foreach ($books as $k=>$v) echo "<tr><td><img src=\"".IMGBASE."/i/books/$k.gif\"></td><td>$bookdata[$k]</td></tr>";
  echo "</table>";
?>
</div>
<SCRIPT>
<?
 if($_GET['set_abil'] || $_GET['clear_abil'] || $_GET['show_abil'] || $_GET["saveset"] || $_GET["delset"] || $_GET["complect"] || $_GET["showstrokes"]){ ?>
setlevel('L4');
<?}elseif($user['level']>0){ ?>
setlevel('L1');
<? }else{ ?>
setlevel('L5');
<?}?>
</SCRIPT>
</TABLE>
</TABLE>
<?php include("mail_ru.php"); ?>
</BODY>
</HTML>

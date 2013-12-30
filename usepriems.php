<?
  function sort_teamsc() {
    global $user;
    // режем тимзы
    $battle_data = mysql_fetch_array(mysql_query ('SELECT t1 FROM `battle` WHERE `id` = '.$user['battle'].' LIMIT 1;'));

    $t1 = explode(";",$battle_data['t1']);
    if (in_array ($user['id'],$t1)) {
      $color = "B1";
    } else {
      $color = "B2";
    }

    return $color;
  }

  if(!function_exists("addlog2")) {
    function addlog2($id,$color,$idpers,$nazv) {
      $hmm = mysql_fetch_array(mysql_query("SELECT id,sex FROM `users` WHERE `id` = '{$idpers}' LIMIT 1;"));
      if(!function_exists("nick666")) {
        function nick666 ($id,$st) {
          if($id > _BOTSEPARATOR_) {
            $bots = mysql_fetch_array(mysql_query ('SELECT name,hp,id,prototype FROM `bots` WHERE `id` = '.$id.' LIMIT 1;'));
            $id=$bots['prototype'];
            $user = mysql_fetch_array(mysql_query("SELECT login,hp,id FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
            $user['login'] = $bots['name'];
            $user['hp'] = $bots['hp'];
            $user['id'] = $bots['id'];
          } else {
            $user = mysql_fetch_array(mysql_query("SELECT login FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
          }
          if($user[0]) {
             return "<span class={$st}>".$user['login']."</span>";
          }
        }
      }
      if($hmm['sex'] == 1) {
        $aa="";
        $em="ему";
      } else {
        $em="ей";
        $aa="a";
      }

      if($nazv=='novice_def'){
        $textp='<span class=date>'.date("H:i").'</span> '.nick666($hmm['id'],$color).', вспомнив слова своего сэнсея, из последних сил провел'.$aa.' прием <b>"Прикрыться"</b>.<BR>';
      }
      if($nazv=='block_activeshield'){
        $textp='<span class=date>'.date("H:i").'</span> Кроличья лапка, подкова в перчатке и прием <b>"Активная защита"</b> помогли '.nick666($hmm['id'],$color).' продержаться ещё немного.<BR>';
      }
      if($nazv=='block_absolute'){
        $textp='<span class=date>'.date("H:i").'</span> Кроличья лапка, подкова в перчатке и прием <b>"Абсолютная защита"</b> помогли '.nick666($hmm['id'],$color).' продержаться ещё немного.<BR>';
      }
      if($nazv=='block_fullshield'){
        $textp='<span class=date>'.date("H:i").'</span> Кроличья лапка, подкова в перчатке и прием <b>"Полная защита"</b> помогли '.nick666($hmm['id'],$color).' продержаться ещё немного.<BR>';
      }

      $fp = fopen ("backup/logs/battle".$id.".txt","a"); //открытие
      flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
      fputs($fp , $textp); //работа с файлом
      fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
      flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
      fclose ($fp); //закрытие
      //chmod("backup/logs/battle".$id.".txt",666);
    }
  }

//////////////////////////////////////////////////////////////////////////

  if ($priem=='hp_regen'){
    $plhp = 2*$user['level'];
    $obnhp = $user['hp']+$plhp;
    $osthp3=5*($user['maxhp']/10);
    if($obnhp>$user['maxhp']) $obnhp=$user['maxhp'];
    if($user['hp3']<$osthp3) $osthp3=$user['hp3'];

    mysql_query("update person_on set pr_active=3  WHERE id_person='".$_SESSION['uid']."' and pr_name='".$priem."'");
    mysql_query("update users set `hp`= `hp` +(2*`level`), `hp2`= `hp2`-5, `hp3`= `hp3`-".$osthp3."   WHERE id='".$_SESSION['uid']."'");
    mysql_query("update users set `hp`= `maxhp` WHERE id='".$_SESSION['uid']."' and `hp`> `maxhp`");
    $user['hp2']=$user['hp2']-5;
    if($user['sex'] == 1) {
      addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick5($user['id'],sort_teamsc()).', понял, пропустив очередной удар, что поможет ему только прием <b>"Утереть Пот"</b>.<Font Color=#006699><b> +'.$plhp.'</b></font> ['.$obnhp.'/'.$user[maxhp].']<BR>');
    } else {
      addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick5($user['id'],sort_teamsc()).', поняла, пропустив очередной удар, что поможет ей только прием <b>"Утереть Пот"</b>.<Font Color=#006699><b> +'.$plhp.'</b></font> ['.$obnhp.'/'.$user[maxhp].']<BR>');
    }
  }

//////////////////////////////////////////////////////////////////////////

  if ($priem=='block_activeshield'){
    mysql_query("update person_on set pr_active=2  WHERE id_person='".$_SESSION['uid']."' and pr_name='".$priem."'");
    mysql_query("update users set `block2`= `block2` -3   WHERE id='".$_SESSION['uid']."'");
    $user['block2']=$user['block2']-3;
  }

//////////////////////////////////////////////////////////////////////////

  if ($priem=='block_absolute'){
    mysql_query("update person_on set pr_active=2  WHERE id_person='".$_SESSION['uid']."' and pr_name='".$priem."'");
    mysql_query("update users set `block2`= `block2` -7   WHERE id='".$_SESSION['uid']."'");
    $user['block2']=$user['block2']-7;
  }

//////////////////////////////////////////////////////////////////////////

  if ($priem=='block_fullshield'){
    mysql_query("update person_on set pr_active=2  WHERE id_person='".$_SESSION['uid']."' and pr_name='".$priem."'");
    mysql_query("update users set `block2`= `block2` -5   WHERE id='".$_SESSION['uid']."'");
    $user['block2']=$user['block2']-5;
  }

//////////////////////////////////////////////////////////////////////////

  if ($priem=='hit_strong'){
    mysql_query("update person_on set pr_active=2  WHERE id_person='".$_SESSION['uid']."' and pr_name='".$priem."'");
    mysql_query("update users set `hit`= `hit` -3   WHERE id='".$_SESSION['uid']."'");
    $user['hit']=$user['hit']-3;
  }

//////////////////////////////////////////////////////////////////////////

  if ($priem=='hit_luck'){
    mysql_query("update person_on set pr_active=2  WHERE id_person='".$_SESSION['uid']."' and pr_name='".$priem."'");
    mysql_query("update users set `hit`= `hit` -5   WHERE id='".$_SESSION['uid']."'");
    $user['hit']=$user['hit']-5;
  }

//////////////////////////////////////////////////////////////////////////
if ($priem=='hit_overhit'){
$schhp=floor(5*$user['level']);
                                                        $ch_priem1 = mysql_query ('SELECT pr_name,id_person FROM `person_on` WHERE `id_person` = '.$_SESSION['enemy'].' and `pr_active`=2');
                                                        while($ch_priem = mysql_fetch_array($ch_priem1)){
if($ch_priem['pr_name']=='novice_def'){$schhp=floor($schhp-3);  mysql_query("update person_on set pr_active=1  WHERE id_person='".$ch_priem['id_person']."' and pr_name='".$ch_priem['pr_name']."'"); if(sort_teamsc()=='B1'){$color_p='B2';}else{$color_p='B1';} addlog2($user['battle'],$color_p,$ch_priem['id_person'],$ch_priem['pr_name']);}
if($ch_priem['pr_name']=='block_activeshield' ){$schhp=floor($schhp/2);  mysql_query("update person_on set pr_active=1  WHERE id_person='".$ch_priem['id_person']."' and pr_name='".$ch_priem['pr_name']."'"); if(sort_teamsc()=='B1'){$color_p='B2';}else{$color_p='B1';} addlog2($user['battle'],$color_p,$ch_priem['id_person'],$ch_priem['pr_name']);}
if($ch_priem['pr_name']=='block_absolute'){$schhp=1;  mysql_query("update person_on set pr_active=1  WHERE id_person='".$ch_priem['id_person']."' and pr_name='".$ch_priem['pr_name']."'"); if(sort_teamsc()=='B1'){$color_p='B2';}else{$color_p='B1';} addlog2($user['battle'],$color_p,$ch_priem['id_person'],$ch_priem['pr_name']);}
if($ch_priem['pr_name']=='block_fullshield' ){$schhp=1;  mysql_query("update person_on set pr_active=1  WHERE id_person='".$ch_priem['id_person']."' and pr_name='".$ch_priem['pr_name']."'"); if(sort_teamsc()=='B1'){$color_p='B2';}else{$color_p='B1';} addlog2($user['battle'],$color_p,$ch_priem['id_person'],$ch_priem['pr_name']);}
                                                        }
if ($_SESSION['enemy'] > _BOTSEPARATOR_){
$bots = mysql_fetch_array(mysql_query ('SELECT `hp` FROM `bots` WHERE `id` = '.$_SESSION['enemy'].' LIMIT 1;'));
mysql_query("update bots set `hp`= `hp` - $schhp   WHERE id='".$_SESSION['enemy']."'");
$en['hp'] = $bots['hp'];
$en['maxhp'] = $user['maxhp'];
}else{
$en = mysql_fetch_array(mysql_query ('SELECT `hp`,`maxhp` FROM `users` WHERE `id` = '.$_SESSION['enemy'].' LIMIT 1;'));
mysql_query("update users set `hp`= `hp` - $schhp   WHERE id='".$_SESSION['enemy']."'");
}
$hzhz = $en['hp']-$schhp;
mysql_query("update person_on set pr_active=3  WHERE id_person='".$_SESSION['uid']."' and pr_name='".$priem."'");
mysql_query("update users set `hit`= `hit` -7,`s_duh`= `s_duh` -100   WHERE id='".$_SESSION['uid']."'");
$user['hit']=$user['hit']-7;
$user['s_duh']=$user['s_duh']-100;
if(sort_teamsc()=='B1'){$color_p='B2';}else{$color_p='B1';}
if($user['sex'] == 1) {
addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick5($user['id'],sort_teamsc()).', вспомнив слова своего сэнсея, из последних сил применил прием <b>"Подлый удар"</b> на '.nick5($_SESSION['enemy'],$color_p).'. <Font Color=#006699><b> -'.$schhp.'</b></font> ['.$hzhz.'/'.$en['maxhp'].']<BR>');
} else {
addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick5($user['id'],sort_teamsc()).', вспомнив слова своего сэнсея, из последних сил применила прием <b>"Подлый удар"</b> на '.nick5($_SESSION['enemy'],$color_p).'. <Font Color=#006699><b> -'.$schhp.'</b></font> ['.$hzhz.'/'.$en['maxhp'].']<BR>');
}
$battle_datamy = mysql_fetch_array(mysql_query ('SELECT damage FROM `battle` WHERE `id` = '.$user['battle'].' LIMIT 1;'));
$damagemy = unserialize($battle_datamy['damage']);
$damagemy[$_SESSION['uid']]=$damagemy[$_SESSION['uid']]+$schhp;
mysql_query('UPDATE `battle` SET  `damage` = \''.serialize($damagemy).'\' WHERE `id` = '.$user['battle'].' ;');
}
//////////////////////////////////////////////////////////////////////////
if ($priem=='hit_willpower'){
if ( $user['hp'] > $user['maxhp']*0.33 ) {
$schhp=floor((5*$user['level'])+7);
}else{
$schhp1=floor((5*$user['level'])+7);
$schhp2=floor($schhp1/4);
$schhp=floor($schhp1+$schhp2);
}
$obnhp = $user['hp']+$schhp;
if($obnhp>$user['maxhp']){$obnhp=$user['maxhp'];}
mysql_query("update person_on set pr_active=3  WHERE id_person='".$_SESSION['uid']."' and pr_name='".$priem."'");
mysql_query("update users set `hp`= `hp` + $schhp  WHERE id='".$_SESSION['uid']."'");
mysql_query("update users set `hp`= `maxhp` WHERE id='".$_SESSION['uid']."' and `hp`> `maxhp`");
mysql_query("update users set `hit`= `hit` -5,`s_duh`= `s_duh` -100 WHERE id='".$_SESSION['uid']."'");
$user['hit']=$user['hit']-5;
$user['s_duh']=$user['s_duh']-100;
if($user['sex'] == 1) {
addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick5($user['id'],sort_teamsc()).', нетрезво оценив положение, решил, что его спасение это прием <b>"Воля к победе"</b>.<Font Color=#006699><b> +'.$schhp.'</b></font> ['.$obnhp.'/'.$user[maxhp].']<BR>');
} else {
addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick5($user['id'],sort_teamsc()).', нетрезво оценив положение, решила, что ее спасение это прием <b>"Воля к победе"</b>.<Font Color=#006699><b> +'.$schhp.'</b></font> ['.$obnhp.'/'.$user[maxhp].']<BR>');
}
}
//////////////////////////////////////////////////////////////////////////
if ($priem=='krit_wildluck'){
mysql_query("update person_on set pr_active=2  WHERE id_person='".$_SESSION['uid']."' and pr_name='".$priem."'");
mysql_query("update users set `krit`= `krit` -3   WHERE id='".$_SESSION['uid']."'");
$user['krit']=$user['krit']-3;
}

//////////////////////////////////////////////////////////////////////////

if ($priem=='krit_blindluck'){
mysql_query("update person_on set pr_active=2  WHERE id_person='".$_SESSION['uid']."' and pr_name='".$priem."'");
mysql_query("update users set `krit`= `krit` -5   WHERE id='".$_SESSION['uid']."'");
$user['krit']=$user['krit']-5;
}

//////////////////////////////////////////////////////////////////////////
if ($priem=='parry_prediction'){
mysql_query("update person_on set pr_active=2  WHERE id_person='".$_SESSION['uid']."' and pr_name='".$priem."'");
mysql_query("update users set `parry`= `parry` -3   WHERE id='".$_SESSION['uid']."'");
$user['parry']=$user['parry']-3;
}
//////////////////////////////////////////////////////////////////////////
if ($priem=='novice_hp'){
$plhp = mt_rand(2,5);
$obnhp = $user['hp']+$plhp;
if($obnhp>$user['maxhp']){$obnhp=$user['maxhp'];}
mysql_query("update person_on set pr_active=3,pr_wait_for=4  WHERE id_person='".$_SESSION['uid']."' and pr_name='".$priem."'");
mysql_query("update users set `hp`= ".$obnhp."   WHERE id='".$_SESSION['uid']."'");
$user['hp']=$user['hp']+$plhp;
addlog($user['battle'],'<span class=date>'.date("H:i").'</span> Кроличья лапка, подкова в перчатке и прием <b>"Собрать зубы"</b> помогли '.nick5($user['id'],sort_teamsc()).' продержаться ещё немного.<Font Color=#006699><b> +'.$plhp.'</b></font> ['.$obnhp.'/'.$user[maxhp].']<BR>');
}
//////////////////////////////////////////////////////////////////////////
if ($priem=='novice_def'){
mysql_query("update person_on set pr_active=2,pr_wait_for=3  WHERE id_person='".$_SESSION['uid']."' and pr_name='".$priem."'");
}
//////////////////////////////////////////////////////////////////////////
if ($priem=='novice_hit'){
mysql_query("update person_on set pr_active=2,pr_wait_for=4  WHERE id_person='".$_SESSION['uid']."' and pr_name='".$priem."'");
}
//////////////////////////////////////////////////////////////////////////
if ($priem=='wis_fire_incenerate04' or $priem=='wis_fire_incenerate05' or $priem=='wis_fire_incenerate06' or $priem=='wis_fire_incenerate07' or $priem=='wis_fire_incenerate08' or $priem=='wis_fire_incenerate11' or $priem=='wis_fire_incenerate09' or $priem=='wis_fire_incenerate10'){
  if($priem=='wis_fire_incenerate04'){$schhp=27;$mimans=15;$textprim=4;}
  elseif($priem=='wis_fire_incenerate05'){$schhp=33;$mimans=23;$textprim=5;}
  elseif($priem=='wis_fire_incenerate06'){$schhp=39;$mimans=34;$textprim=6;}
  elseif($priem=='wis_fire_incenerate07'){$schhp=47;$mimans=52;$textprim=7;}
  elseif($priem=='wis_fire_incenerate08'){$schhp=58;$mimans=62;$textprim=8;}
  elseif($priem=='wis_fire_incenerate09'){$schhp=69;$mimans=74;$textprim=9;}
  elseif($priem=='wis_fire_incenerate10'){$schhp=83;$mimans=89;$textprim=10;}
  else {$schhp=101;$mimans=107;$textprim=11;}
  $anti=getantimagic($fbattle->enemy);
  $schhp=ceil($schhp*($user["intel"]/50+1)*$anti);
  if ($_SESSION['enemy'] > _BOTSEPARATOR_){
    $bots = mysql_fetch_array(mysql_query ('SELECT `hp` FROM `bots` WHERE `id` = '.$_SESSION['enemy'].' LIMIT 1;'));
    mysql_query("update bots set `hp`= `hp` - $schhp   WHERE id='".$_SESSION['enemy']."'");
    $en['hp'] = $bots['hp'];
    $en['maxhp'] = $user['maxhp'];
  }else{
    $en = mysql_fetch_array(mysql_query ('SELECT `hp`,`maxhp` FROM `users` WHERE `id` = '.$_SESSION['enemy'].' LIMIT 1;'));
    mysql_query("update users set `hp`= `hp` - $schhp   WHERE id='".$_SESSION['enemy']."'");
  }
  $hzhz = $en['hp']-$schhp;
  mysql_query("update person_on set pr_active=2  WHERE id_person='".$_SESSION['uid']."' and pr_name='".$priem."'");
  mysql_query("update users set `mana`= `mana`- $mimans   WHERE id='".$_SESSION['uid']."'");
  if(sort_teamsc()=='B1'){$color_p='B2';}else{$color_p='B1';}
  if($user['sex'] == 1) {
    addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick5($user['id'],sort_teamsc()).', наконец сфокусировал свое внимание на поединке и наколдовал "<FONT color=#A00000><b>Испепеление ['.$textprim.']</b></font>" на '.nick5($_SESSION['enemy'],$color_p).'. <Font Color=#006699><b> -'.$schhp.'</b></font> ['.$hzhz.'/'.$en['maxhp'].']<BR>');
  } else {
    addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick5($user['id'],sort_teamsc()).', наконец сфокусировала свое внимание на поединке и наколдовала "<FONT color=#A00000><b>Испепеление ['.$textprim.']</b></font>" на '.nick5($_SESSION['enemy'],$color_p).'. <Font Color=#006699><b> -'.$schhp.'</b></font> ['.$hzhz.'/'.$en['maxhp'].']<BR>');
  }
  $battle_datamy = mysql_fetch_array(mysql_query ('SELECT damage FROM `battle` WHERE `id` = '.$user['battle'].' LIMIT 1;'));
  $damagemy = unserialize($battle_datamy['damage']);
  $damagemy[$_SESSION['uid']]=$damagemy[$_SESSION['uid']]+$schhp;
  mysql_query('UPDATE `battle` SET  `damage` = \''.serialize($damagemy).'\' WHERE `id` = '.$user['battle'].' ;');
  $_POST['attack']=665;
  $_POST['defend']=665;
  if($sumwear==2){
    $_POST['attack1']=665;
  }
  $_POST['enemy']=$_SESSION['enemy'];
  $emptyhit=1;
  $fbattle->damage[$fbattle->user['id']]+=$schhp;
  $fbattle->exp[$fbattle->user['id']] += $fbattle->solve_exp ($fbattle->user['id'],$_SESSION['enemy'],$schhp);
}

if ($priem=="block_addchange") {
  $target=getid($_POST["main"], $fbattle->battle_data["id"]);
  if ($priem=='block_addchange' && $target){
    mysql_query("update users set `block2`= `block2` -1   WHERE id='".$_SESSION['uid']."'");
    $user['block2']=$user['block2']-1;
    $found=0;
    if(($fbattle->user['hp']>0) && $fbattle->battle) {
      foreach($fbattle->battle[$fbattle->user['id']] as $k => $v) {
        if ($fbattle->battle[$fbattle->user['id']][$k][0] == 0) {
            if ($k==$target) {
              $found=1;
              break;
            }
        }
      }
    }
    if ($found) {
      $fbattle->enemy=$target;
      $enemy=$target;
    }
  }
}
//////////////////////////////////////////////////////////////////////////
?>
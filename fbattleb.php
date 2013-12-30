<?php
  define("DTBATTLE", 11);
  define("UNLIMCHAOS", 12);
  define("SNOWBALLSDROP", 1);
  define("SNOWBALL",1);
  $finishscript="";
  $notacticrestrrooms=array(72);

  if (!defined("DOCUMENTROOT")) {
    if ($_SERVER["REMOTE_ADDR"]=="127.0.0.1") define("DOCUMENTROOT","d:/vlife2/");
    else define("DOCUMENTROOT","/srv/www/virt-life.com/htdocs/");
  }
  if (!defined("USERBATTLE"))  define("USERBATTLE", 1);
  define("MAXMFD", 1050);
  define("MAXMFDMAG", 850);
  define("UNKILLABLEBOT", 11135);
  define("HELLRISER", 3946);
  $leveldefs=array(0, 10, 20, 30, 50, 60, 70, 80, 100, 125, 150, 200, 250, 300, 350);
  $strokenames=array(
    11111=>array("novice_hit"=>"Мощный удар", "novice_def"=>"Ослабить удар"),
    11112=>array("novice_hit"=>"Мощный удар", "novice_def"=>"Ослабить удар"),
    11113=>array("novice_hit"=>"Мощный удар", "novice_def"=>"Ослабить удар"),
    11114=>array("novice_hit"=>"Мощный удар", "novice_def"=>"Ослабить удар"),
    11115=>array("novice_hit"=>"Мощный удар", "novice_def"=>"Ослабить удар"),
    11116=>array("novice_hit"=>"Мощный удар", "novice_def"=>"Ослабить удар"),
  );
  $strokebots=array(
  7=>array("novice_hit", "novice_def", "novice_hp", "bot_hitshock"),
  11111=>array("novice_hit", "novice_def"),
  11112=>array("novice_hit", "novice_def"),
  11113=>array("novice_hit", "novice_def", "bot_bite"),
  11114=>array("novice_hit", "novice_def", "bot_bite"),
  11115=>array("novice_hit", "novice_def", "bot_bite", "bot_regen"),
  11116=>array("novice_hit", "novice_def", "bot_bite", "bot_regen"),
  11117=>array("hit_shock", "block_target"),
  11118=>array("hit_shock", "block_target"),
  11119=>array("hit_shock", "block_target"),
  11120=>array("hit_shock", "block_target"),
  11121=>array("novice_hit", "novice_def", "novice_hp"),
  5080=>array("novice_hit", "novice_def", "novice_hp"),
  11122=>array("novice_hit", "novice_def", "novice_hp"),
  11123=>array("novice_hit", "novice_def", "novice_hp"),
  11124=>array("novice_hit", "novice_def", "novice_hp"),
  11125=>array("novice_hit", "novice_def", "novice_hp"),
  11126=>array("novice_hit", "novice_def", "novice_hp"),
  11127=>array("novice_hit", "novice_def", "novice_hp"),
  11128=>array("novice_hit", "novice_def", "novice_hp"),
  11129=>array("novice_hit", "novice_def", "novice_hp"),
  11130=>array("novice_hit", "novice_def", "novice_hp"),
  11131=>array("novice_hit", "novice_def", "novice_hp"),
  11132=>array("novice_hit", "novice_def", "novice_hp"),
  11146=>array("bot_heal", "bot_bladedance", "bot_hitshock"),
  11148=>array("bot_curse", "hit_willpower"),
  11150=>array("bot_skiparmor", "hit_luck", "bot_regen75"),    
  );
  $cavebots=array(3=>"Обезьяноподобного", 4=>"Зеленоглазого", 5=>"Ящера", 6=>"Твари Рогатой", 7=>"Зеброкота", 8=>"Головастика", 50=>"Отморозка");
  $newbus=array();
  define("NOIFRAME", 1);
  if ($_SERVER["REMOTE_ADDR"]=="127.0.0.1") {
    define("BATTLEDEBUG",0);
    define("DAMAGEDEBUG",0);
    define("SHOWSOLVEDMF",0);
    define("DIEAFTERSOLVEDMF",0);
    define("NOREFRESH",0);
    define("VIEWDAMAGE",0);
    define("BOTHPFROMBASE",0);
    define("ALLCONTR",0);
    define("NOBLOCKS",0);
    define("NOUVOROTS",0);
  } else {
    define("BATTLEDEBUG",0);
    define("DAMAGEDEBUG",0);
    define("SHOWSOLVEDMF",0);
    define("DIEAFTERSOLVEDMF",0);
    define("NOREFRESH",0);
    define("VIEWDAMAGE",0);
    define("BOTHPFROMBASE",0);
    define("ALLCONTR",0);
    define("NOBLOCKS",0);
    define("NOUVOROTS",0);
  }

  function drawtrick($can_use, $img,  $txt, $free_cast, $dsc, $resource, $select_target, $target, $target_login, $magic_type, $name) {
    $res=explode(',', $resource);
    // 0=HIT, 1=KRT, 2=CNTR, 3=BLK, 4=PRY, 5=HP, 6=spirit, 7=mana, 8=cool_down, 9=cool_down_left, 10=limit, 11=limit_left, 12=startwait
    $ret="";
    if ($can_use){
      if ($select_target){
          $ret.="<A style='cursor: pointer' onclick=\"tricklogin('</b>Выберите".
               ($target=='friend'?' дружественную цель':(target=='enemy'?' врага':(target=='any'?' цель':""))).
               " для приема <b nobr nowrap>$txt', 'fbattleb.php', 'target',  '$target_login', '".
               "$magic_type', '<INPUT type=hidden name=special value=$name>'".($free_cast?'':', 1').')">';
      } else {
  //      s += free_cast ? '<A HREF="/fbattleb.php?special=' + name + '&r=' + rnd + '">': "<A style='cursor: pointer' onclick=\"b_confirm('fbattleb.php', '" + txt + "', '" + magic_type + "', '<INPUT type=hidden name=special value=" + name+ ">', 1)\">";
          $ret.="<A HREF=\"/fbattleb.php?special=$name&r=".time()."\">";
      }
    }
    $ret.="<IMG style=\"".($can_use?'cursor:pointer': " -moz-opacity:.70; opacity:.70;filter:gray(), Alpha(Opacity='70');").'" width=40 height=25 '."src='i/priem/".$img.".gif'";
    if ($txt){
      $ret.= "onmouseout='hideshow();' onmouseover='fastshow2(\"<B>".$txt."</B><BR>" ;
      $ret.= ($res[0]=='0'? '': "<IMG width=8 height=8 src=/i/misc/micro/hit.gif> ".$res[0].'&nbsp;&nbsp;');
      $ret.= ($res[1]=='0'? '': '<IMG width=8 height=8 src=/i/misc/micro/krit.gif> '.$res[1].'&nbsp;&nbsp;');

      $ret.=  ($res[2]=='0'? '': '<IMG width=8 height=8 src=/i/misc/micro/counter.gif> '.$res[2].'&nbsp;&nbsp;');

      $ret.=  ($res[3]=='0'? '': '<IMG width=8 height=8 src=/i/misc/micro/block.gif> '.$res[3].'&nbsp;&nbsp;');
      $ret.=  ($res[4]=='0'? '': '<IMG width=8 height=8 src=/i/misc/micro/parry.gif> '.$res[4].'&nbsp;&nbsp;');
      $ret.=  ($res[5]=='0'? '': '<IMG width=8 height=8 src=/i/misc/micro/hp.gif> '.$res[5].'&nbsp;&nbsp;');
      $ret.=  ($res[6] == '0' ? '': '<BR>Сила духа: '.$res[6]) ;
      $ret.=  ($res[7] == '0' ? '': '<BR>Расход маны: '.$res[7] ) ;
      $ret.=  ($res[8] == '0' ? '': '<BR>Задержка: '.$res[8].($res[9]=='0'?'':' (ещё '.$res[9].")")) ;
      if ($res[8]==0 && $res[9]>0) $ret.='<BR>Задержка: ещё '.$res[9];
      $ret.=  ($res[12] == '0' ? '': '<BR>Начальная задержка: '.$res[12] ) ;
      $ret.=  ($res[10] == '0' ? '': '<BR>Использований: '.$res[11].'/'.$res[10]);
      // + (res[11] == '' ? '' : ' (ещё ' + res[11] + ")")) ;
      $ret.=  ($free_cast? '': '<BR>&bull; Приём тратит ход') ;
      $ret.=  '<br><br>'.$dsc."\", this, event)'" ;
    }
    $ret.= '>'.($can_use?'</A><IMG SRC="Reg/1x1.gif" WIDTH="2" HEIGHT="1" BORDER=0 ALT="">': '<IMG SRC="Reg/1x1.gif" WIDTH="2" HEIGHT="1" BORDER=0 ALT="">');
  //if (img=='wis_fire_incenerate10')window.clipboardData.setData('Text',s);
    return $ret;
  }

  function bnick4($id,$st) {
    global $fbattle, $finishscript, $user;
    $ud=$fbattle->userdata[$id];
    if (!$ud["maxhp"]) {
      $fbattle->makeuserdata($id);  
      $ud=$fbattle->userdata[$id];
    }
    if ($ud["login"]=="невидимка") {
      $ud["hp"]="??";
      $ud["maxhp"]="??";
      $ud["level"]=0;
      $inf="";
    } else $inf="<a href=\"/inf.php?$id\" target=\"_blank\"><img alt=\"".$ud["login"]."\" border=\"0\" src=\"".IMGBASE."/i/inf.gif\"></a>";
    $ret="<span onclick=\"top.AddTo('".$ud['login']."')\" oncontextmenu=\"return OpenMenu(event,".$ud['level'].")\" id=\"enemy$id\" class={$st}>".($fbattle->battle[$id][$fbattle->user['id']][0]>0?"<u>":"").$ud['login'].($fbattle->battle[$id][$fbattle->user['id']][0]>0?"</u>":"")."</span> [".$ud['hp']."/".$ud['maxhp']."] $inf";
    $tmo=($fbattle->battle_data["timeout"]*60-(time()-$fbattle->battle[$id][$user["id"]][2])-30)*1000;
    if ($tmo<1) $tmo=1;
    if ($fbattle->battle[$id][$fbattle->user['id']][0]) {
      if ($user["hp"]>0) $finishscript.="setTimeout(\"top.frames['main'].document.getElementById('enemy$id').style.color='#ff0000'\",$tmo);";
    }
    return $ret;
  }

  function takespirit($u, $v) {
    global $user, $fbattle;
    $v=round($v*100);
    $s=$fbattle->battleunits[$u]["additdata"]["s_duh"];
    $fbattle->battleunits[$u]["additdata"]["s_duh"]-=$v;
    if ($fbattle->battleunits[$u]["additdata"]["s_duh"]<0) $fbattle->battleunits[$u]["additdata"]["s_duh"]=0;
    if ($s!=$fbattle->battleunits[$u]["additdata"]["s_duh"]) $fbattle->needupdateaddit[$u]=1;

    /*mq("update users set s_duh=if(s_duh<$v, 0, s_duh-$v) where id='$u'");
    if ($u==$user["id"] && USERBATTLE) {
      $user["s_duh"]-=$v;
      if ($user["s_duh"]<0) $user["s_duh"]=0;
    }*/
  }
  function nextitem($sql, $oper) {
    if ($sql) return "$sql, $oper";
    else return $oper;
  }
  function geteffectval($val, $len, $maxlen) {
    $mid=$maxlen/2+0.5;
    if ($len!=$mid) {
      return round($val+(($len-floor($mid))/($maxlen-$mid)*$val/2));
    }
    return $val;    
  }  
  function rightattack($n) {
    if ((($n>0 && $n<=5) || $n>600) && $n==floor($n)) return $n;
    else return 0;
  }
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
  
  function eqstrokes($s1, $s2) {
    $signs=array("wis_water_sign", "wis_fire_sign", "wis_air_sign", "wis_earth_sign");
    if (in_array($s1, $signs) && in_array($s2, $signs)) return true;
    if ($s1=="wis_air_shield" || $s2=="wis_air_shield") {
      if ($s1==$s2) return true;
      return $s1=="wis_gray_forcefield11" || $s1=="wis_gray_forcefield10" || $s1=="wis_gray_forcefield09" || $s1=="wis_gray_forcefield08" || $s1=="wis_gray_forcefield07" ||
      $s2=="wis_gray_forcefield11" || $s2=="wis_gray_forcefield10" || $s2=="wis_gray_forcefield09" || $s2=="wis_gray_forcefield08" || $s2=="wis_gray_forcefield07";
    }
    $s1=str_replace(array(0,1,2,3,4,5,6,7,8,9), array("","","","","","","","","",""), $s1);
    $s2=str_replace(array(0,1,2,3,4,5,6,7,8,9), array("","","","","","","","","",""), $s2);
    return $s1==$s2;
  }
  
  function gethpdata($u) {

  }

  function effect($left, $top, $img, $name) {
    return "<div style=\"position:absolute; left:{$left}px; top:{$top}px; width:40px; height:25px; z-index:5\"><IMG width=40 height=25 src='$img' onmouseout='hideshow();' onmouseover='fastshow2(\"$name\", this, event)'> </div>";
  }

  function echoscrolls($s) {
    global $fbattle, $user;
    if (count($fbattle->battleunits[$user["id"]]["additdata"]["scrolls"])>0 && $fbattle->battle_data["type"]!=4) {
      foreach ($fbattle->battleunits[$user["id"]]["additdata"]["scrolls"] as $k=>$dress) {
        if ($dress) {
          if ($dress['magic'] && !$fbattle->battleunits[$user["id"]]["additdata"]["scrollused"] && !$dress["wait"]) {
            $magic = magicinf ($dress['magic']);
            $ret.="<a  onclick=\"";
            if($magic['targeted']==1) {
              $ret.="okno('Введите название предмета', 'fbattleb.php?use=$dress[id]', 'target'); ";
            } else
            if($magic['targeted']==2) {
              $ret.="findlogin('Введите имя персонажа', 'fbattleb.php?use=$dress[id]', 'target', ''); ";
            } else
            if($magic['targeted']==4) {
              $ret.="note('Запрос', 'fbattleb.php?use=$dress[id]', 'target'); ";
            } else {
              $ret.="if(confirm('Использовать сейчас?')) { window.location='fbattleb.php?use=".$dress['id']."';}";
            }
            $ret.="\" href='#'>";
          }
          $ret.='<img '.($fbattle->battleunits[$user["id"]]["additdata"]["scrollused"] || $dress["wait"]?"style=\"filter:gray(), Alpha(Opacity='70');\"":"").' src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=40 onmouseout="hideshow();" onmouseover="fastshow2(\''.$dress['name'].'<br>Прочность '.$dress['duration'].'/'.$dress['maxdur'].($dress["wait"]?"<br>Задержка: $dress[wait]":"").'\', this, event)"  height=25></a>';
        } else $ret.="<img src=\"".IMGBASE."/i/w13.gif\" width=40 height=25  onmouseout='hideshow()' onmouseover='fastshow2(\"пустой слот магия\",this, event)'>";
      }
    } else {
      $i=0;
      while ($i<12) {
        $ret.="<img src=\"".IMGBASE."/i/w13.gif\" width=40 height=25 onmouseout='hideshow()' onmouseover='fastshow2(\"пустой слот магия\",this, event)'>";
        $i++;
      }
    }
    return $ret;
  }

  function combatscroll($slot, $to="") {
    global $user;
    $script = 'fbattle';
    $ret="";
    if ($user[$slot] > 0) {
        $row['id'] = $user[$slot];
        $dress = mysql_fetch_array(mq("SELECT * FROM `inventory` WHERE `id` = '{$user[$slot]}' LIMIT 1;"));
        if (!$dress) return "<img src=\"".IMGBASE."/i/w13.gif\" width=40 height=25 onmouseout='hideshow()' onmouseover='fastshow2(\"пустой слот магия\",this, event)'>";
        if ($dress['magic']) {
          $magic = magicinf ($dress['magic']);
          $ret.="<a  onclick=\"";
          if($magic['targeted']==1) {
            $ret.="okno('Введите название предмета', '".$script.".php?use={$row['id']}', 'target'); ";
          } else
          if($magic['targeted']==2) {
            $ret.="findlogin('Введите имя персонажа', '".$script.".php?use={$row['id']}', 'target', '$to'); ";
          } else
          if($magic['targeted']==4) {
            $ret.="note('Запрос', '".$script.".php?use={$row['id']}', 'target'); ";
          }else {
            $ret.="if(confirm('Использовать сейчас?')) { window.location='".$script.".php?use=".$row['id']."';}";
          }
          $ret.="\" href='#'>";
        }
        $ret.='<img src="'.IMGBASE.'/i/sh/'.$dress['img'].'" width=40 title="'.$dress['name'].'  Прочность '.$dress['duration'].'/'.$dress['maxdur'].'"  Прочность '.$dress['duration'].'/'.$dress['maxdur'].'" height=25 alt="Использовать  '.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur'].'"></a>';
    } else { $ret.="<img src=\"".IMGBASE."/i/w13.gif\" width=40 height=25 onmouseout='hideshow()' onmouseover='fastshow2(\"пустой слот магия\",this, event)'>"; }
    return $ret;
  }

  function getscrolls() {
    $i=0;
    $ret=array();
    while ($i<12) {
      $i++;
      $ret[$i]=getscrolldata("m$i");
    }
    return $ret;
    return combatscroll('m1',$enemynick).combatscroll('m2',$enemynick).combatscroll('m3',$enemynick).combatscroll('m4',$enemynick).combatscroll('m5',$enemynick).combatscroll('m6',$enemynick)
    .combatscroll('m7',$enemynick).combatscroll('m8',$enemynick).combatscroll('m9',$enemynick).combatscroll('m10',$enemynick).combatscroll('m11',$enemynick).combatscroll('m12',$enemynick);
  }

  function getscrolldata($slot) {
    global $user;
    if ($user[$slot] > 0) {
      return mqfa("SELECT id, magic, img, name, duration, maxdur FROM `inventory` WHERE `id` = '{$user[$slot]}'");
    } else return 0;
  }

  function lowerdamage($d, $level) {
    if ($d<1) return 1;
    return $d;

    $d1=$d;
    $i=0;
    $i1=0;
    $ret=0;
    //$level;
    while ($d>0) {
      if ($d>25) $t=25; else $t=$d;
      $d-=$t;
      $ret+=$t*(1-mftoabs($i));
      if ($i0<10) $i0++;
      //$i+=$level;
      if ($i1<5) $i+=ceil($level*2.5);
      elseif ($i1<10) $i+=ceil($level*2.0);
      elseif ($i1<15) $i+=ceil($level*1.5);
      elseif ($i1<20) $i+=ceil($level*1.0);
      //else $i+=$level*0.6;
      $i1++;
    }
    return $ret;
  }

  function showhrefmagicb($dress) {
    global $user;
    if ($user['battle']) {
      $script = 'fbattle';
    } else {
      $script = 'main';
    }
    $magic = magicinf ($dress['includemagic']);
    $ret="<a  onclick=\"";
    if($magic['targeted']==1) {
      $ret.="okno('Введите название предмета', '{$script}.php?use={$dress['id']}', 'target')";
    }elseif($magic['targeted']==2) {
      $ret.="findlogin('".$magic['name']."', '{$script}.php?use={$dress['id']}', 'target')";
    }else
    if($magic['targeted']==4) {
      $ret.="note('Запрос', '".$script.".php?use={$row['id']}', 'target'); ";
    }else {
      $ret.="if (confirm('Использовать сейчас?')) window.location='".$script.".php?use=".$dress['id']."';";
    }
    $ret.="\" href='#'>";

    $ret.="<img src='mg2.php?p=".($dress['includemagicdex']/$dress['includemagicmax']*100)."&i={$dress['img']}' style=\"filter:shadow(color=red, direction=90, strength=3);\" title=\"".$dress['name']."  Прочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"  Уровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['minu']>0)?"  Урон {$dress['minu']}-{$dress['maxu']}":"").(($dress['text']!=null)?"  На оружии выгравировано '{$dress['text']}'":"")."  Встроена магия: ".$magic['name']."\" alt=\"".$dress['name']."  Прочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"  Уровень жизни ".plusorminus($dress['ghp']):"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['minu']>0)?"  Урон {$dress['minu']}-{$dress['maxu']}":"").(($dress['text']!=null)?"  На оружии выгравировано '{$dress['text']}'":"")."  Встроена магия: ".$magic['name']."\" ><BR>";
    return $ret;
  }

  function enemyeffects($user, $battle) {
    global $strokes;
    $strokes1="";
    $r=mq("select priem, value, effect, length from battleeffects where user='$user' and battle='$battle' and effect>=1 and effect<=14 and length>0 order by id desc");
    $i=0;
    while ($rec=mysql_fetch_assoc($r)) {
      $i++;
      if ($rec["effect"]==FIREDAMAGE || $rec["effect"]==WATERDAMAGE) {
        $hint=" (".($rec["length"])." ход";
        if ($rec["length"]>1 && $rec["length"]<=4) $hint.="а";
        if ($rec["length"]>4) $hint.="ов";
        $hint.=")";
      }
      list($left, $top)=effectpos($i);
      $priem1=$rec["priem"];
      if ($rec["priem"]=="wis_fire_mark" || $rec["priem"]=="wis_water_mark" || $rec["priem"]=="wis_earth_mark" || $rec["priem"]=="wis_air_mark") $rec["priem"].=$rec["value"]/$strokes[$rec["priem"]]->value;
      $strokes1.="<div style=\"position:absolute; left:{$left}px; top:{$top}px; width:40px; height:25px; z-index:3\"><IMG width=40 height=25 src='".IMGBASE."/i/priem/$rec[priem].gif' onmouseout='hideshow();' onmouseover='fastshow2(\"<B>".$strokes[$priem1]->name."</B><center>$hint</center>\", this, event)';> </div>";
    }
    return $strokes1;
  }

  function efftostr($effect, $value, $priem, $fulleffect) {
    global $strokes;
    if ($effect==DECHEAL) return "уменьшение эффектов лечения (%): $value<br>";
    if ($effect==INCEARTHDAMAGE) return "увеличение урона магией земли (%): $value<br>";
    if ($effect==EXTRAMF) {
      $str="";
      $i=0;
      while ($i<3) {
        $i++;
        if ($fulleffect["value".($i==1?"":$i)]) {
          if ($i==1) $mf=@$strokes[$priem]->mf;
          if ($i==2) $mf=@$strokes[$priem]->mf2;
          if ($i==3) $mf=@$strokes[$priem]->mf3;
          if (!$mf) continue;
          if ($str) $str.=", ";
          if ($mf=="mfhitp") $str.="Мф. мощности урона (%): ";
          if ($mf=="mfmagp") $str.="Мф. мощности магии (%): ";
          if ($mf=="mffire") $str.="Мф. мощности магии огня (%): ";
          if ($mf=="mfwater") $str.="Мф. мощности магии воды (%): ";
          if ($mf=="mfair") $str.="Мф. мощности магии воздуха (%): ";
          if ($mf=="mfearth") $str.="Мф. мощности магии земли (%): ";
          if ($mf=="mfdhit") $str.="Защита от урона: ";
          if ($mf=="mfdkol") $str.="Защита от колющего урона: ";
          if ($mf=="mfdrub") $str.="Защита от рубящего урона: ";
          if ($mf=="mfdrej") $str.="Защита от режущего урона: ";
          if ($mf=="mfddrob") $str.="Защита от дробящего урона: ";
          if ($mf=="mfdmag") $str.="Защита от магии: ";
          if ($mf=="mfdfire") $str.="Защита от магии огня: ";
          if ($mf=="mfdwater") $str.="Защита от магии воды: ";
          if ($mf=="mfdearth") $str.="Защита от магии земли: ";
          if ($mf=="mfdair") $str.="Защита от магии воздуха: ";
          if ($mf=="mfdlight") $str.="Защита от магии света: ";
          if ($mf=="mfddark") $str.="Защита от магии тьмы: ";
          if ($mf=="mfdgray") $str.="Защита от серой магии: ";
          if ($mf=="mfkrit") $str.="Мф. крит. удара: ";
          if ($mf=="mfakrit") $str.="Мф. против крит. удара: ";
          if ($mf=="mfuvorot") $str.="Мф. увёртывания: ";
          if ($mf=="mfauvorot") $str.="Мф. против увёртывания: ";
          if ($mf=="skipuv") return "Шанс увернуться, парировать или отбить щитом (%): -$value<br>";
          if ($mf=="manausage") $str.="Уменьшение расхода маны (%): ";
          if ($mf=="bron") $str.="Броня всех зон (%): ";
          if ($mf=="sila") $str.="Сила: ";
          if ($mf=="lovk") $str.="Ловкость: ";
          if ($mf=="inta") $str.="Интуиция: ";
          
          if ($mf=="mfkrit") $str.="Мф. критического удара: ";
          if ($fulleffect["value".($i==1?"":$i)]>0) $str.="+";
          $str.=$fulleffect["value".($i==1?"":$i)];
        }
      }
      if ($str) return "$str<br>";
    }
    if ($effect==PROFDAMAGEMULT) {
      if ($strokes[$priem]->prof=="kol") return "Защита от колющего урона (%): ".plusorminus($value)."<br>";
      if ($strokes[$priem]->prof=="rej") return "Защита от режущего урона (%): ".plusorminus($value)."<br>";
      if ($strokes[$priem]->prof=="rub") return "Защита от рубящего урона (%): ".plusorminus($value)."<br>";
      if ($strokes[$priem]->prof=="drob") return "Защита от дробящего урона (%): ".plusorminus($value)."<br>";
    }
    if ($effect==WATERDAMAGE) return "Наносит урон магией воды<br>";
    if ($effect==FIREDAMAGE) return "Наносит урон магией огня<br>";
    if ($effect==EARTHDAMAGE) return "Наносит урон магией земли<br>";
    if ($effect==AIRDAMAGE) return "Наносит урон магией воздуха<br>";
    if ($effect==DAMAGEMULT) return "Защита от урона (%): ".plusorminus($value)."<br>Защита от магии (%): ".plusorminus($value)."<br>";
    if ($effect==MAGDAMAGEMULT) return "Защита от магии (%): ".plusorminus($value)."<br>";
    if ($effect==MAGICDEF) return "Защита от магии (%): ".plusorminus($value)."<br>";
    if ($effect==FIREDEF) return "Защита от магии огня (%): ".plusorminus($value)."<br>";
    if ($effect==WATERDEF) return "Защита от магии воды (%): ".plusorminus($value)."<br>";
    if ($effect==EARTHDEF) return "Защита от магии земли (%): ".plusorminus($value)."<br>";
    if ($effect==AIRDEF) return "Защита от магии воздуха (%): ".plusorminus($value)."<br>";
    if ($effect==VIEWSTROKES) return "Тактика раскрыта<br>";
    if ($effect==SHOCK) return "Персонаж оглушён<br>";
    if ($effect==LOWERDAMAGE && $value==5) return "Весь урон снижен вдвое<br>";
    if ($effect==INJURY) return "Персонаж может получить травму при поражении<br>";
    if ($effect==HEAL) return "Восстанавливает жизнь каждый ход<br>";
    if ($effect==HEALMANA) return "Восстанавливает ману каждый ход<br>";
    if ($effect==DEFEND) return "Следующий удар по персонажу попадёт по защитнику<br>";
    if ($effect==DELTASTUN) return "Ускорено время восстановления от оглушения на $value ход<br>";
    if ($effect==MINUSFIREDEF) return "Защита от магии огня: -$value<br>";
    if ($effect==MINUSWATERDEF) return "Защита от магии воды: -$value<br>";
    if ($effect==MINUSAIRDEF) return "Защита от магии воздуха: -$value<br>";
    if ($effect==MINUSEARTHDEF) return "Защита от магии земли: -$value<br>";
    if ($effect==NOCASTMOVE) return "Любое следующее заклинание не тратит хода<br>";
    if ($effect==EXTRAMAGSKILL) return "Навык магии стихий: ".plusorminus($value)."<br>";
    if ($effect==MAGICDAMAGE1) return "Следующее заклятие нанесёт не более 1 повреждения<br>";
    if ($effect==CASTCOST) return "Уменьшение стоимости заклинаний (%): -$value<br>";
    if ($effect==EXTRADAMAGE) return "Мощность урона (%): ".plusorminus($value)."<br>";
    if ($effect==EXTRAMAGDAMAGE) return "Мощность магии (%): ".plusorminus($value)."<br>";
  }

  function effecthint($eff, $priem) {
    $ret="";
    if ($eff["effect"]) $ret.=efftostr($eff["effect"], $eff["value"], $priem, $eff);
    if ($eff["effect2"]) $ret.=efftostr($eff["effect2"], $eff["value2"], $priem, $eff);
    if ($eff["effect3"]) $ret.=efftostr($eff["effect3"], $eff["value3"], $priem, $eff);
    return $ret;
  }

  function showbattlepers($id, $me, $battle, $mystrokes=0) {
    global $mysql, $rooms, $fbattle, $user, $strokes, $pershp;
    $uid=$id;
    $fbattle->getbu($id);
    $ret=$fbattle->battleunits[$id]["persout$me"];
    if ($me) {
      $user1=$user;
      $user1["maxhp"]=$fbattle->userdata[$id]["maxhp"];
      $user1["maxmana"]=$fbattle->userdata[$id]["maxmana"];
    } else {
      if($id > _BOTSEPARATOR_) {
        $user1["maxhp"]=$fbattle->userdata[$id]["maxhp"];// mysql_fetch_array(mq("SELECT maxhp, sex FROM `users` WHERE `id` = '$bot[prototype]' LIMIT 1;"));
        $user1["hp"]=$fbattle->userdata[$id]["hp"];
        $user1["sex"]=$fbattle->battleunits[$id]["sex"];
        $user1['id'] = $id;
        if (BOTHPFROMBASE) {
          $bot=mqfa('SELECT name, prototype, hp FROM `bots` WHERE `id` = '.$id);
          $user1['hp'] = $bot['hp'];
        }
        //$id=$bot["prototype"];
      } else {
        $user1 = mqfa("SELECT hp, mana, sex FROM `users` WHERE `id` = '{$id}'");
        $user1["maxhp"]=$fbattle->userdata[$id]["maxhp"];
        $user1["maxmana"]=$fbattle->userdata[$id]["maxmana"];
      }
      $user1["invis"]=$fbattle->battleunits[$id]["invis"];
    }
    foreach ($fbattle->battleunits[$id]["effects"] as $k=>$v) {
      if ($v["effect"]==VIEWSTROKES && $v["caster"]==$user["id"]) $vs=1;
    }
    if ($me || @$vs) {
      if (!$mystrokes) {
        $fbattle->getpriems($id);
        $mystrokes=$fbattle->battleunits[$id]["priems"];
      }
      $strokes1="";
      $i=0;
      $i=0;
      foreach ($fbattle->battleunits[$id]["effects"] as $k=>$v) {
        $hint="";
        $i++;
        if ($k=="castlebonus") continue;
        if ($v["effect"]==INJURY && $v["value"]<10) continue;
        if ($v["img"] && $v["type"]==1) {
          list($left, $top)=effectpos($i);
          $strokes1.=effect($left, $top, $v["img"], $v["name"]);
        } else {              
          if (@$strokes[$k]->lefttext) $hint=$strokes[$k]->lefttext;
          elseif ($v["length"]<100 && !$strokes[$k]->eternal) {
            $hint="".($v["length"])." ход";
            if ($v["length"]>1 && $v["length"]<=4) $hint.="а";
            if ($v["length"]>4) $hint.="ов";
            $hint.="<br>";
          }
          $hint.=effecthint($v, $k);
          if ($strokes[$k]->type==4 && !@$strokes[$k]->selfcast || $k=="hp_travma") {
            $hint.="<br><nobr>Автор: <b>".$fbattle->nick5($v["caster"], "", 1)."</b></nobr></br>";
          }
          list($left, $top)=effectpos($i);
          $k1=$k;
          $tail="";
          if (@$strokes[$k]->additive) {
            $k=remnumbers($k);
            $tail=$v["cnt"];
          }
          if (strpos($k, "-")) {
            $tmp=explode("-",$k);
            $k=$tmp[0];
            if ($tmp[1]=="oncaster") continue;
          }
          $k.=$tail;
          $strokes1.="<div style=\"position:absolute; left:{$left}px; top:{$top}px; width:40px; height:25px; z-index:5\"><IMG ".(@$v["effect"]==IMMUNITY?"style=\"cursor:pointer; filter:gray(), Alpha(Opacity='70');\"":"")." width=40 height=25 src='".IMGBASE."/i/priem/$k.gif' onmouseout='hideshow();' onmouseover='fastshow2(\"<B>".($v["effect"]==IMMUNITY?"Иммунитет":$strokes[$k1]->name)."</B>".($k1=="wis_air_shield"?"($v[value])":"")."<br>$hint\", this, event)';> </div>";
        }
      }
      /*while ($rec=mysql_fetch_assoc($r)) {
        $i++;
        if ($rec["effect"]==FIREDAMAGE || $rec["effect"]==WATERDAMAGE) {
          $hint=" (".($rec["length"])." ход";
          if ($rec["length"]>1 && $rec["length"]<=4) $hint.="а";
          if ($rec["length"]>4) $hint.="ов";
          $hint.=")";
        }
        list($left, $top)=effectpos($i);
        $strokes1.="<div style=\"position:absolute; left:{$left}px; top:{$top}px; width:40px; height:25px; z-index:5\"><IMG width=40 height=25 src='".IMGBASE."/i/priem/$rec[priem].gif' onmouseout='hideshow();' onmouseover='fastshow2(\"<B>".$strokes[$rec["priem"]]->name."</B><center>$hint</center>\", this, event)';> </div>";
      }*/
      if ($fbattle->battleunits[$id]["resurrect"]>0) {
        $i++;
        list($left, $top)=effectpos($i);
        $strokes1.= "<div style=\"position:absolute; left:{$left}px; top:{$top}px; width:40px; height:25px; z-index:5\"><IMG width=40 height=25 src='".IMGBASE."/i/sh/preservation.gif' onmouseout='hideshow();' onmouseover='fastshow2(\"<B>Спасение</B> (заклятие)\", this, event)'> </div>";
      }
      if ($fbattle->battleunits[$id]["forcefield"]>0) {
        $i++;
        list($left, $top)=effectpos($i);
        $strokes1.= "<div style=\"position:absolute; left:{$left}px; top:{$top}px; width:40px; height:25px; z-index:5\"><IMG width=40 height=25 src='".IMGBASE."/i/priem/wis_gray_forcefield07.gif' onmouseout='hideshow();' onmouseover='fastshow2(\"<B>Силовое поле</B> (".$fbattle->battleunits[$id]["forcefield"].")\", this, event)'> </div>";
      }
      if ($fbattle->battleunits[$id]["manabarrier"]>0) {
        $i++;
        list($left, $top)=effectpos($i);
        $strokes1.="<div style=\"position:absolute; left:{$left}px; top:{$top}px; width:40px; height:25px; z-index:5\"><IMG width=40 height=25 src='".IMGBASE."/i/priem/wis_gray_manabarrier04.gif' onmouseout='hideshow();' onmouseover='fastshow2(\"<B>Магический Барьер</B> (магия)<br>Барьер способен поглотить ещё <b>".$fbattle->battleunits[$id]["manabarrier"]."</b> ед. урона\", this, event)'> </div>";
      }

      foreach ($mystrokes as $k=>$v) {
        if ($strokes[$k]->eternal) continue;
        if ($strokes[$k]->maxuses && $v["uses"]>1 && $strokes[$k]->showinpersout) {
          $i++;
          list($left, $top)=effectpos($i);
          $strokes1.="<div style=\"position:absolute; left:{$left}px; top:{$top}px; width:40px; height:25px; z-index:5\"><IMG width=40 height=25 src='".IMGBASE."/i/priem/$k".($v["uses"]-1).".gif' onmouseout='hideshow();' onmouseover='fastshow2(\"<B>".$strokes[$k]->name."</B> (приём)<BR><BR> ".$strokes[$k]->opisan."\", this, event)';> </div>";
        } elseif (@$strokes[$k]->eternal && $v["active"]==3) {
          $i++;
          list($left, $top)=effectpos($i);
          $strokes1.= "<div style=\"position:absolute; left:{$left}px; top:{$top}px; width:40px; height:25px; z-index:5\"><IMG width=40 height=25 src='".IMGBASE."/i/priem/$k.gif' onmouseout='hideshow();' onmouseover='fastshow2(\"<B>".$strokes[$k]->name."</B> (приём)<BR><BR> ".$strokes[$k]->opisan."\", this, event)';> </div>";
        } elseif ($v["active"]==2) {
          $i++;
          list($left, $top)=effectpos($i);
          $strokes1.= "<div style=\"position:absolute; left:{$left}px; top:{$top}px; width:40px; height:25px; z-index:5\"><IMG width=40 height=25 src='".IMGBASE."/i/priem/$k.gif' onmouseout='hideshow();' onmouseover='fastshow2(\"<B>".$strokes[$k]->name."</B> (приём)<BR><BR> ".$strokes[$k]->opisan."\", this, event)';> </div>";
        }
      }
      $ret=str_replace("<!--strokes-->", $strokes1, $ret);
    } else {
      $effs="";
      $i=0;
      foreach ($fbattle->battleunits[$uid]["effects"] as $k=>$v) {
        if ($k=="castlebonus") continue;
        if ($v["img"] && $v["type"]==1) {
          $i++;
          list($left, $top)=effectpos($i);
          $effs.=effect($left, $top, $v["img"], $v["name"]);
        }
        if ($v["type"]==1) continue;
        $i++;
        $hint="";
        if (@$strokes[$k]->lefttext) $hint=$strokes[$k]->lefttext;
        elseif ($v["length"]<100) {
          $hint="".($v["length"])." ход";
          if ($v["length"]>1 && $v["length"]<=4) $hint.="а";
          if ($v["length"]>4) $hint.="ов";
          $hint.="<br>";
        }
        $hint.=effecthint($v, $k);

        if ($strokes[$k]->type==4 && !@$strokes[$k]->selfcast || $k=="hp_travma") {
          $hint.="<br><nobr>Автор: <b>".$fbattle->nick5($v["caster"], "", 1)."</b></nobr></br>";
        }
        list($left, $top)=effectpos($i);
        $k1=$k;
        $tail="";
        if (@$strokes[$k]->additive) {
          //$cnt=$v["value"]/$strokes[$k]->value;
          $k=remnumbers($k);
          $tail="$v[cnt]";
        }
        if (strpos($k,"-")) {
          $tmp=explode("-",$k);
          $k=$tmp[0];
          if ($tmp[1]=="oncaster") continue;
        }
        $k.=$tail;                                                                                                                                                         
        $effs.="<div style=\"position:absolute; left:{$left}px; top:{$top}px; width:40px; height:25px; z-index:5\"><IMG ".(@$v["effect"]==IMMUNITY?"style=\"cursor:pointer; filter:gray(), Alpha(Opacity='70');\"":"")." width=40 height=25 src='".IMGBASE."/i/priem/$k.gif' onmouseout='hideshow();' onmouseover='fastshow2(\"<B>".($v["effect"]==IMMUNITY?"Иммунитет":$strokes[$k1]->name)."</B><br>$hint\", this, event)';> </div>";
      }                                 //enemyeffects($uid, $battle)
      $ret=str_replace("<!--strokes-->", $effs, $ret);
    }
    if ($user1["invis"] && !$me) $tmp="<IMG SRC='".IMGBASE."/i/1green.gif' WIDTH=120
    HEIGHT=9 ALT=\"Уровень жизни\">
    <div style=\"position: absolute; left: 5px; top:0px; z-index: 1; font-weight: bold; color:#FFFFFF;\"><b>??/??</b></div>";
    else $tmp=setHP2($user1['hp'],$user1['maxhp'],$battle);
    $pershp=$user1['hp'];
    if ($user1["hp"]<=0 && $fbattle->battle[$user1["id"]]) {
      $fbattle->killplayer($user1);
      $fbattle->needrefresh=1;
    }
    $ret=str_replace("<!--hp-->", $tmp, $ret);
    if (@$user1['maxmana'] && (!$user1["invis"] || $me)) {
      $tmp=setMP2($user1['mana'],$user1['maxmana'],$battle);
      $ret=str_replace("<!--mana-->", $tmp, $ret);
    }
    if ($me) {
      if ($fbattle->battleunits[$id]["p1"]) $p1=unserialize($fbattle->battleunits[$id]["p1"]); else $p1="";
      if ($fbattle->battleunits[$id]["p2"]) $p2=unserialize($fbattle->battleunits[$id]["p2"]); else $p2="";
      $tmp="<table cellspacing=0 cellpadding=0>
      <tr>
      <td>".($p1?"<a href=\"fbattleb.php?use=p1\" title=\"Использовать $p1[name]\"><img src=\"".IMGBASE."/i/sh/$p1[img]\"></a>":"<img alt=\"Пустой слот левый карман\" src=\"".IMGBASE."/i/w15.gif\">")."</td>
      <td><img alt=\"Пустой слот карман\" src=\"".IMGBASE."/i/w15.gif\"></td>
      <td>".($p2?"<a href=\"fbattleb.php?use=p2\" title=\"Использовать $p2[name]\"><img src=\"".IMGBASE."/i/sh/$p2[img]\"></a>":"<img alt=\"Пустой слот правый карман\" src=\"".IMGBASE."/i/w15.gif\">")."</td>
      </tr>
      <tr>
      <td><img src=\"".IMGBASE."/i/w20.gif\"></td>
      <td><img src=\"".IMGBASE."/i/w20.gif\"></td>
      <td><img src=\"".IMGBASE."/i/w20.gif\"></td>
      </tr></table>";
      $ret=str_replace("<!--belt-->", $tmp, $ret);
    }
    return $ret;
  }


//  ob_start("ob_gzhandler");
  if (USERBATTLE) {
    ob_start();
    session_start();

    if (!@$_SESSION['uid']) {
      header("Location: index.php"); 
      //mq('UPDATE `users` SET `hp2` = 0,`hp3` = 0,`hit` = 0,`s_duh` = 0,`krit` = 0,`counter` = 0,`block2` = 0,`parry` = 0  WHERE `id` = '.$_SESSION['uid'].'');
      //mq("DELETE FROM `person_on` WHERE `id_person`='".$_SESSION['uid']."'");
      die;
    }
    include './connect.php';

  // ставим блокировку на таблицу

    if($_SESSION['btime']) $chk=time()-$_SESSION['btime'];
    if($_SESSION['btime'] && $chk<=2){
      if ($_SERVER["REQUEST_METHOD"]=="POST") sleep(1);
      $_SESSION['btime']=time();
      //unset($attack);unset($defend);
      //unset($_POST['attack']);unset($_POST['defend']);
    }else{$_SESSION['btime']=time();}

         mq("LOCK TABLES fielditems write, bots WRITE, `puton` WRITE, `userdata` WRITE, `priem` WRITE, `deztow_realchars` write, `shop` WRITE, `person_on` WRITE, `podzem3` WRITE, `canal_bot` WRITE, `canal_bot_bezdna` WRITE, `labirint` WRITE, `battle` WRITE, `logs` WRITE, `users` WRITE, `inventory` WRITE, `magic` WRITE, `effects` WRITE, `clans` WRITE, `online` WRITE, `telegraph` WRITE, `allusers` WRITE, `quests` WRITE, `battleeffects` WRITE, `items` WRITE, `podzem2` WRITE, `battleunits` WRITE, `berezka` WRITE, `qtimes` WRITE, `smallitems` WRITE, `podzem_zad_login` write, `caveparties` write, `caveitems` write, `cavebots` write, errorstats write, caves write, userstrokes write, variables write, droplog write, fieldparties write, fields write, obshagaeffects write, invisbattles write, clanstorage write, allinventory write, fieldlogs write, effectimgs write, includemagicuses write, podzem_predmet write, podzem_big3 write;");
    include './functions.php';
    include_once("incl/strokedata.php");

    if (!@$_SESSION["fallen"]) {
      $_SESSION["fallen"]=1;
      fallitems();
    }
    if ($user["mana"]<0) {
      $user["mana"]=0;
      mq("update users set mana=0 where id='$user[id]'");
    }
    if (@$_POST['end'] != null) {
      header("Location: main.php"); 
      //mq('UPDATE `users` SET `hp2` = 0,`hp3` = 0,`hit` = 0,`s_duh` = 0,`krit` = 0,`counter` = 0,`block2` = 0,`parry` = 0  WHERE `id` = '.$_SESSION['uid'].'');
      mq("DELETE FROM `person_on` WHERE `id_person`='".$_SESSION['uid']."'");
      $_SESSION["fallen"]=0;
      fallitems();
    }
  }

// ========================================================================================================================================================
// начало исполняемого кода битвы
//=========================================================================================================================================================

  /*if (USERBATTLE) {
    $s_duh=$user['s_duh'];$hit=$user['hit'];$krit=$user['krit'];$block=$user['block2'];$parry=$user['parry'];$hp=$user['hp2'];$counter=$user['counter'];
  }*/
  
  /*$chkwear1 = mq('SELECT id FROM `inventory` WHERE (`type` = 3 AND `dressed` = 1) AND `owner` = '.$user['id'].';');
  $sumwear=0;
  while ($chkwear = mysql_fetch_array($chkwear1)) {
    $sumwear++;
  }*/

function notzero($d) {
  if ($d<1) return 1; else return ceil($d);
}

function checkanimalexp($id, $exp) {
  $level=mq("select level from users where id='$id'");
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
  var $needshield;
  function prieminfo($s,$priem) { # либо по id ($s) либо по названию $priem
    global $strokes, $user;
    if ($s) $priem=$strokes["ids"][$s];
    /*foreach ($strokes as $k=>$v) if ($v->id_priem==$s) {
      $priem=$k;
      break;
    }*/

    /*if ($s) {
      $res=mysql_fetch_array (mq("select * from priem where id_priem='".$s."';"));
    }else{
      $res=mysql_fetch_array (mq("select * from priem where priem='".$priem."';"));
    }*/
    $this->id_priem=$strokes[$priem]->id_priem;
    $this->name=$strokes[$priem]->name;
    $this->type=$strokes[$priem]->basetype;
    $this->priem=$priem;
    $this->n_block=@$strokes[$priem]->n_block;
    $this->n_counter=@$strokes[$priem]->n_counter;
    $this->n_hit=@$strokes[$priem]->n_hit;
    $this->n_hp=@$strokes[$priem]->n_hp;
    $this->n_krit=@$strokes[$priem]->n_krit;
    $this->n_parry=@$strokes[$priem]->n_parry;
    $this->minlevel=@$strokes[$priem]->minlevel;
    $this->wait=@$strokes[$priem]->wait;
    $this->startwait=@$strokes[$priem]->startwait;
    $this->sduh_proc=@$strokes[$priem]->sduh_proc;
    $this->sduh=@$strokes[$priem]->sduh;
    $this->hod=@$strokes[$priem]->move;
    $this->intel=@$strokes[$priem]->intel;
    $this->mana=manausage($priem);
    $this->opisan=@$strokes[$priem]->opisan;
    $this->needshield=@$strokes[$priem]->needshield;
    if (strpos($this->opisan,"mana33")) {
      if ($user["maxmana"]==0) $this->opisan=str_replace("mana33","33% от максимальной маны",$this->opisan);
      else $this->opisan=str_replace("mana33",round($user["maxmana"]*0.33),$this->opisan);
    }
    $this->m_magic1=@$strokes[$priem]->m_magic1;
    $this->m_magic2=@$strokes[$priem]->m_magic2;
    $this->m_magic3=@$strokes[$priem]->m_magic3;
    $this->m_magic4=@$strokes[$priem]->m_magic4;
    $this->m_magic5=@$strokes[$priem]->m_magic5;
    $this->m_magic6=@$strokes[$priem]->m_magic6;
    $this->m_magic7=@$strokes[$priem]->m_magic7;
    $this->needsil=@$strokes[$priem]->need_sil;
    $this->needvyn=@$strokes[$priem]->need_vyn;
    $this->maxuses=@$strokes[$priem]->maxuses;
    $this->target=(int)@$strokes[$priem]->basetarget;
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
      } else {
        return false;
      }
    }
  }
  function checkbattlehars($myinfo,$uses) { # влад магией, статы + хар-ки битвы
    global $user, $fbattle, $strokes;
    if (($user["room"]==57 || $user["in_tower"]==1 || $user["in_tower"]==71) && @$strokes[$this->priem]->buystroke) return false;
    $fbattle->getbu($user["id"]);
    $hit=$fbattle->battleunits[$user["id"]]["additdata"]["hit"];
    $krit=$fbattle->battleunits[$user["id"]]["additdata"]["krit"];
    $parry=$fbattle->battleunits[$user["id"]]["additdata"]["parry"];
    $counter=$fbattle->battleunits[$user["id"]]["additdata"]["counter"];
    $block=$fbattle->battleunits[$user["id"]]["additdata"]["block2"];
    $hp=$fbattle->battleunits[$user["id"]]["additdata"]["hp2"];
    $s_duh=$fbattle->battleunits[$user["id"]]["additdata"]["s_duh"]/100;
    if ($this->needshield) {
      if (!$fbattle->checkshit($user["id"])) return false;
    }
    if (@$strokes[$this->priem]->losehpproc && round($user["hp"]/$user["maxhp"]*100)<=$strokes[$this->priem]->losehpproc) return false;

    if (@$strokes[$this->priem]->hplt && round($user["hp"]/$user["maxhp"]*100)>=$strokes[$this->priem]->hplt) return false;
    if (
    ($uses<=@$this->maxuses || !$this->maxuses) &&
    $hit>=$this->n_hit && $krit>=$this->n_krit && $parry>=$this->n_parry && $counter>=$this->n_counter &&
    $hp>=$this->n_hp && $block>=$this->n_block && $fbattle->battleunits[$user["id"]]['level']>=$this->minlevel && $user['hp']>=$this->minhp &&
    ($s_duh>=$this->sduh || $s_duh>0) && $fbattle->battleunits[$user["id"]]['intel']>=$this->intel && $user['mana']>=$this->mana &&
    $fbattle->battleunits[$user["id"]]['mfire']>=$this->m_magic1 && $fbattle->battleunits[$user["id"]]['mwater']>=$this->m_magic2 && $fbattle->battleunits[$user["id"]]['mair']>=$this->m_magic3 &&
    $fbattle->battleunits[$user["id"]]['mearth']>=$this->m_magic4 && $fbattle->battleunits[$user["id"]]['mlight']>=$this->m_magic5 && $fbattle->battleunits[$user["id"]]['mgray']>=$this->m_magic6 &&    
    $fbattle->battleunits[$user["id"]]['mdark']>=$this->m_magic7 && $fbattle->battleunits[$user["id"]]['sila']>=$this->needsil && $fbattle->battleunits[$user["id"]]['vinos']>=$this->needvyn) return true;
  }
}

  if (@$_GET['uszver'] && $user["hp"]>0 && $user['zver_id']>0 && !incommontower($user)) {

    $zver=mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$user['zver_id']}' LIMIT 1;"));
    $q=mqfa1("select quest from battle where id='$user[battle]'");
    if($zver && $q!=4){
    if($zver['sitost']>=1){
//      $nb = mysql_fetch_array(mq("SELECT id FROM `bots` WHERE battle='".$user['battle']."' and `name` LIKE '".$zver['login']."';"));
        $nb = mysql_fetch_array(mq("SELECT id FROM `bots` WHERE battle='".$user['battle']."' and prototype='".$user['zver_id']."';"));
        if(!$nb){
        mq("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('".$zver['login']."','".$zver['id']."','".$user['battle']."','".$zver['maxhp']."');");
        $bot = mysql_insert_id();

        $bd = mysql_fetch_array(mq ('SELECT * FROM `battle` WHERE `id` = '.$user['battle'].' LIMIT 1;'));
        $battle = unserialize($bd['teams']);
        $battle[$bot] = $battle[$user['id']];
        foreach($battle[$bot] as $k => $v) {
          $battle[$k][$bot] = array(0,0,time());
        }
        $t1 = explode(";",$bd['t1']);
        if (in_array ($user['id'],$t1)) {$ttt = 1;} else {  $ttt = 2;}
        addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick5($user['id'],"B".$ttt).' призвал '.($zver["vid"]?"своего зверя":"в бой").' '.nick5($bot,"B".$ttt).'<BR>');

        mq('UPDATE `battle` SET `teams` = \''.serialize($battle).'\', `t'.$ttt.'`=CONCAT(`t'.$ttt.'`,\';'.$bot.'\')  WHERE `id` = '.$user['battle'].' ;');

        mq("UPDATE `battle` SET `to1` = '".time()."', `to2` = '".time()."' WHERE `id` = ".$user['battle']." LIMIT 1;");

        $bet=1;
        $report="Ваш зверь призван в бой.";
        mq("update battleunits set petunleashed=1 where user='$user[id]' and battle='$user[battle]'");
    } else { $report="Ваш зверь уже был призван в бой.";}
    } else {$report="Ваш зверь слишком голодный.";}
    } else {$report="У вас нет зверя!";}
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
  public $needupdate=0;
  public $needupdatebu=0;
  public $needrefresh=0;
  public $toupdatebattle=array(); // что апдейтить в бою
  public $needupdateaddit=array(); // кого надо апдейтить additdata

  function makeuserdata($id, $usr=0, $weapons=0) {
    if (!$usr) {
      if ($id>_BOTSEPARATOR_) {
        $rec=mqfa("select hp, prototype, name from bots where id='$id'");
        $prototype=$rec["prototype"];
        $usr=mqfa("select weap, shit, invis, maxhp, level from users where id='$prototype'");
        $usr["hp"]=$rec["hp"];
        $usr["login"]=$rec["name"];
      } else $usr=mqfa("select weap, shit, invis, login, hp, maxhp, mana, maxmana, level from users where id='$id'");
    }
    if (!$weapons) {
      if ($usr["weap"]) $weapons=1;

      if ($this->battle_data["type"]!=4) {
        if($id>_BOTSEPARATOR_) {
          include_once "config/botdata.php";
          if ($botdata[$prototype]) {
            if ($botdata[$prototype]["wd2"]) {
              $weapons=2;
            } else {
              $weapons=1;
            }
          }
          if (!$prototype) $prototype=mqfa1("select prototype from bots where id='$id'");
        } else $prototype=$id;
        if ($usr["weap"]) $wd=mqfa("select otdel from inventory where id='".$usr["weap"]."'"); else $wd=0;
        if ($usr["shit"]) $wd2=mqfa("select otdel gintel from inventory where id='".$usr["shit"]."'");
        $wd["weptype"]=$this->otdeltoweptype($wd["otdel"]);
        $wd2["weptype"]=$this->otdeltoweptype($wd2["otdel"]);
        if ($wd2["weptype"]!="kulak") $weapons++;
        if (!$weapons) $weapons=1;
        $weapons2=mqfa1('SELECT count(id) FROM `inventory` WHERE (`type` = 3 or (type<>3 and dvur=1))  AND `dressed` = 1 AND `owner` = '.$prototype);
        if ($weapons2>$weapons) $weapons=$weapons2;
      } else {
        $weapons=1;
      }
    }
    $this->userdata[$id]["weapons"]=$weapons;
    if ($usr["invis"]) $this->userdata[$id]["login"]="невидимка";
    else $this->userdata[$id]["login"]=$usr["login"];
    $this->userdata[$id]["hp"]=$usr["hp"];
    $this->userdata[$id]["maxhp"]=$usr["maxhp"];
    $this->userdata[$id]["mana"]=$usr["mana"];
    $this->userdata[$id]["maxmana"]=$usr["maxmana"];
    $this->userdata[$id]["level"]=$usr["level"];
    $this->needupdate=1;
  }

  function findlogin($l) {
    foreach ($this->userdata as $k=>$v) {
      if ($v["login"]==$l) {
        return array("id"=>$k, "team"=>(in_array($k,$this->t1)?1:2));
      }
    }
    return false;
  }

  function fullnick($u) {
    return "<b>".$this->userdata[$u]["login"]."</b> [".$this->userdata[$u]["level"]."] <a href=\"inf.php?$u\" target=\"_blank\"><IMG SRC=\"".IMGBASE."/i/inf.gif\" WIDTH=12 HEIGHT=11 ALT=\"Инф. о ".$this->userdata[$u]["login"]."\"></a>";
  }

  function bottouser($id) {
    if ($id<_BOTSEPARATOR_) return $id;
    if ($this->battleunits[$id]) return $this->battleunits[$id]["prototype"];
    $this->getbu($id);
    return $this->battleunits[$id]["prototype"];
  }

  function addlog2($id,$color,$idpers,$nazv,$p1=0,$p2=0,$p3=0, $p4=0, $write=1) {
    global $strokes, $strokenames;
    if ($color=="B1") $color2="B2";
    else $color2="B1";
    /*if ($idpers<_BOTSEPARATOR_) $hmm = mysql_fetch_array(mysql_query("SELECT id,sex FROM `users` WHERE `id` = '{$idpers}' LIMIT 1;"));
    else {
      $hmm["id"]=$idpers;
      $hmm["sex"] = mqfa1("SELECT sex FROM `users` WHERE `id` = '".bottouser($idpers)."'");
    }*/
    $hmm["id"]=$idpers;
    $hmm["sex"]=$this->battleunits[$idpers]["sex"];
    if($hmm['sex'] == 1) {
      $aa="";
      $em="ему";
      $his="его";
    } else {
      $em="ей";
      $aa="a";
      $his="её";
    }
    $btu=$this->bottouser($idpers);
    if (@$strokenames[$btu][$nazv]) $strokename=$strokenames[$btu][$nazv];
    else $strokename=$strokes[$nazv]->name;

    if ($nazv=="agressiveresolve") {
      $textp='<span class=date>'.date("H:i").'</span> '.$this->nick5($hmm['id'],$color).', отменил'.$aa.' приём <b>"'.$strokes[$p2]->name.'"</b> у '.$this->nick5($p1,$color2).' с помощью приёма <b>"Агрессивная защита"</b>.<BR>';
    } elseif ($nazv=="multi_agressiveshield" || $nazv=="block_revenge") {
      $textp='<span class=date>'.date("H:i").'</span> '.$this->nick5($hmm['id'],$color).', решив стать героем, провел'.$aa.' прием <b>"'.$strokename.'"</b> на '.$this->nick5($p1,$color2).' <b>-'.$p2.'</b> '.$p3.' ]<BR>';
    } elseif(substr($nazv,0,11)=='magicdamage'){
      $textp='<span class=date>'.date("H:i").'</span> '.$this->nick5($hmm['id'],$color).', получил'.$aa.' повреждение от '.$p4.' <b>-'.$p1.'</b> [ '.($p2<0?0:$p2).' / '.$p3.' ]<BR>';
    } elseif(substr($nazv,0,11)=='manadamage'){
      $textp='<span class=date>'.date("H:i").'</span> '.$this->nick5($hmm['id'],$color).', утратил'.$aa.' ману от заземления <b>-'.$p1.'</b>.<BR>';
    } elseif($nazv=='heal'){
      $textp='<span class=date>'.date("H:i").'</span> '.$this->nick5($hmm['id'],$color).' восстановил'.$aa.' здоровье от приёма <b>'.$strokes[$p4]->name.'</b> <font Color=green><b>+'.$p1.'</b></font> '.$this->loghp($idpers).'<BR>';
    } elseif($nazv=='healmana'){
      $textp='<span class=date>'.date("H:i").'</span> '.$this->nick5($hmm['id'],$color).', восстановил'.$aa.', ману от приёма <b>'.$strokes[$p4]->name.'</b> <font Color=green><b>+'.$p1.'</b></font> [ '.$p2.' / '.$p3.' ]<BR>';
    } elseif($nazv=='heal2'){
      $textp='<span class=date>'.date("H:i").'</span> '.$this->nick5($hmm['id'],$color).', использовал'.$aa.', приём <b>'.$strokes[$p4]->name.'</b> <font Color=green><b>+'.$p1.'</b></font> [ '.$p2.' / '.$p3.' ]<BR>';
    } elseif ($strokes[$nazv])  {
      $textp='<span class=date>'.date("H:i").'</span> ';
      $nick=$this->nick5($hmm['id'],$color);
      $priem=$strokename;
      $txts=array(
        "$nick, нетрезво оценив положение, решил$aa, что поможет $em только прием <b>\"$priem\"</b>.",
        "$nick, не придумал$aa ничего лучше чем применить прием <b>\"$priem\"</b>.",
        "$nick, сам$aa не поняв зачем, применил$aa прием <b>\"$priem\"</b>.",
        "$nick, вспомнив слова своего сэнсея, из последних сил провел$aa прием <b>\"$priem\"</b>.",
        "$nick, решив стать героем, провел$aa прием <b>\"$priem\"</b>.",
        "$nick, понял$aa, пропустив очередной удар в голову, что $his спасение - это прием <b>\"$priem\"</b>.",
        "$nick, понимая, что ситуация становится критической, применил$aa прием <b>\"$priem\"</b>.",
        "$nick, замыслив недоброе, использовал$aa прием <b>\"$priem\"</b>.",
        "$nick, выкрикнув: \"А ещё я вот так могу!\", использовал$aa прием <b>\"$priem\"</b>."
      );
      $textp.=$txts[rand(0,count($txts)-1)];
      $textp.="<BR>";
    }

    //if (!$write) return $textp;
    $this->add_log($textp);
    /*$fp = fopen ("backup/logs/battle".$id.".txt","a"); //открытие
    flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
    fputs($fp , $textp); //работа с файлом
    fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
    flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
    fclose ($fp); //закрытие
    //chmod("/backup/logs/battle".$id.".txt",666);*/

  }

  function logstroke($u, $priem, $data, $target=0) {
    global $strokes;
    $user=$this->nick5($u);
    $stroke="<b>\"".$strokes[$priem]->name."\"</b>";
    if ($this->battleunits[$u]["sex"]==1) {
      $a="";$his="его";
    } else {
      $a="а";$his="её";
    }
    if ($data["deltahp"]) {
      $r=rand(0,3);
      if ($r==0) $result="Кроличья лапка, подкова в перчатке и прием $stroke помогли $user продержаться ещё немного.";
      elseif ($r==1) $result="$user, нетрезво оценив ситуацию решил$a, что $his спасение это прием $stroke.";
      elseif ($r==2) $result="$user понял$a, пропустив очередной удар в голову, что $his срасение прем $stroke.";
      else $result="$user, пораскинув мозгами по земле, сообразил$a, что $his выручат приём $stroke или вмешательство высших сил.";
      $this->logline("$result <Font Color=#006699><b> +".$data["deltahp"]."</b></font> ".($this->loghp($u))."<BR>");
    } elseif ($data["damage"]) {
      $this->logline($this->nick5($u).", вспомнив слова своего сэнсея, из последних сил применил".($this->battleunits[$u]["sex"]==1?"":"а")." прием <b>\"".$strokes[$priem]->name.'"</b> на '.$this->nick5($target).'. <Font Color=#006699><b> -'.$data["damage"].'</b></font> '.$this->loghp($target).']<BR>');
    }
  }

  function usepriem($u, $priem) {
    global $strokes, $user;
    if ($strokes[$priem]->type==3) {
      $logdata=array();
      if ($strokes[$priem]->deltahp) {
        $heal=$strokes[$priem]->deltahp;
        if ($strokes[$priem]->deltahprand) {
          $heal+=mt_rand(0, $strokes[$priem]->deltahprand);
        }
        if ($strokes[$priem]->deltahplevel) {
          $heal+=$user["level"]*$strokes[$priem]->deltahplevel;
        }
        $logdata["deltahp"]=$this->addhp($heal, $u, @$strokes[$priem]->nospirit);
        $this->logstroke($u, $priem, $logdata);
      }
      if ($strokes[$priem]->instantdamage) {
        if ($strokes[$priem]->instantdamage=="level5") $dam=$user["level"]*5;
        else $dam=$strokes[$priem]->instantdamage;
        if (@$strokes[$priem]->instantdamagerand) $dam+=mt_rand(0, $strokes[$priem]->instantdamagerand);

        $res=$this->checkpriems2($this->battleunits[$user["id"]]["priems"],$this->my_class,$user["id"]);
        $dam=$this->processstrokeeffect2($res, $dam);

        $dam=$this->takehp($dam, $user["id"], 0, 1, $u);
        $logdata["damage"]=$dam;
        $this->logstroke($u, $priem, $logdata, $user["id"]);
      }
      if (@$strokes[$priem]->actto2) $act=2;
      else $act=(@$strokes[$priem]->actastarget?$stroketarget:3);
      $this->actpriem($priem, 0, $u, $act, 1, 1);
    } else {
      $this->actpriem($priem, 0, $u, 2, 0, 1);
    }
    $this->taketactics($u, $priem);
  }

  function getid($n) {
    if ($n=="Невидимка" && $_SESSION["invis"]) return $_SESSION["invis"];
    foreach ($this->userdata as $k=>$v) if ($v["login"]==$n) return $k;
  }

  function getpersout($id, $me, $sila=0, $lovk=0, $inta=0, $vinos=0, $intel=0, $user=0) {
    global $userslots;

    $uid=$id;
    if (!$user) {
      if($id > _BOTSEPARATOR_) {
        $bots = mysql_fetch_array(mq('SELECT * FROM `bots` WHERE `id` = '.$id.' LIMIT 1;'));
        $id=$bots['prototype'];
        $user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
        $user['login'] = $bots['name'];
        $user['hp'] = $bots['hp'];
        $user['id'] = $bots['id'];
      } else {
        $user = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
      }
    }
    if ($this->battle_data["type"]==4) {
      foreach ($userslots as $k=>$v) {
        $user[$v]=0;
      }
    }
    if ($user["zver_id"] && !incommontower($user)) {
      $rec=mqfa("select level, vid, sitost from users where id='$user[zver_id]'");
      if ($rec["sitost"]>0) {
        if ($rec["vid"]==1) $user["sila"]+=$rec["level"];
        if ($rec["vid"]==2) $user["lovk"]+=$rec["level"];
        if ($rec["vid"]==3) $user["inta"]+=$rec["level"];
      }
    }
    if ($sila) $user["sila"]=$sila;
    if ($lovk) $user["lovk"]=$lovk;
    if ($inta) $user["inta"]=$inta;
    if ($vinos) $user["vinos"]=$vinos;
    if ($intel) $user["intel"]=$intel;

    return mainpersout($user);
  }

  function lognick($u) {
    $this->getbu($u);
    if ($this->battleunits[$u]["invis"]) $l="Невидимка";
    else $l=$this->userdata[$u]["login"];
    return "<span class=\"B".(in_array($u, $this->t1)?"1":"2")."\">$l</span>";
  }

  function instantdamage($user, $damage, $mag=0, $from=0) {
    global $leveldefs;
    $this->getbu($user);
    if ($mag) {
      $def=$this->battleunits[$user]["mfdmag"]-$this->battleunits[$from]["minusmfdmag"]*10+$leveldefs[$this->battleunits[$user]["level"]];
      if ($def>MAXMFDMAG) $def=MAXMFDMAG;
    } else {
      $def=$this->battleunits[$user]["mfdhit"];
      if ($def>MAXMFD+$leveldefs[$this->battleunits[$user]["level"]]) $def=MAXMFD+$leveldefs[$this->battleunits[$user]["level"]];
    }
    if ($def<500+$leveldefs[$this->battleunits[$user]["level"]]) return $damage;                                              
    else {
      return ceil($damage*(1-mftoabs($def-500-$leveldefs[$this->battleunits[$user]["level"]])));
    }
  }
  
  function makechange($u1, $u2) {
    $this->getbu($u1);
    $this->getbu($u2);

    $this->user=$this->battleunits[$u1];
    $this->user["id"]=$u1;
    $this->user["login"]=$this->userdata[$u1]["login"];
    $this->user["hp"]=$this->userdata[$u1]["hp"];
    $this->user["maxhp"]=$this->userdata[$u1]["maxhp"];

    $this->currentenemy=$u2;

    $this->enemy_dress=array();
    $this->user_dress=array();
    foreach ($this->battleunits[$u1]["effects"] as $k=>$v) {
      if ($v["effect"]==DEFEND && ($this->battle[$u2][$u1][0]==665 || $this->battle[$enemy][$this->user['id']][0]==664)) continue;
      $this->processbattleeffect($u1, $k, $v, $u2);
    }
    foreach ($this->battleunits[$u2]["effects"] as $k=>$v) {
      if ($v["effect"]==DEFEND && ($this->battle[$u1][$u2][0]==665 || $this->battle[$u1][$u2][0]==664)) continue;
      $this->processbattleeffect($u2, $k, $v, $u1);
    }
    $mf=$this->solve_mf($u1, $u2, $this->battle[$u1][$u2][0], $this->battle[$u1][$u2][3], $this->battle[$u1][$u2][4], $this->battle[$u1][$u2][5], $this->battle[$u1][$u2][6]);

    $this->actstrokesbymove($u1);
    $this->actstrokesbymove($u2);

    if ($this->battle[$u2][$u1][0]==664) {
      $this->battleunits[$u2]["mfuvorot"]=0;
      $this->enemy_dress["mfuvorot"]=0;
      $mf["he"]["uvorot"]=0;
    }

    if ($attack==664) {      
      $this->battleunits[$u1]["mfuvorot"]=0;
      $this->user_dress["mfuvorot"]=0;
      $mf["me"]["uvorot"]=0;
    }

    if ($this->battle[$u2][$u1][0]==664 && $this->battle[$u2][$u1][1]==664) {
      // пропустил по тайму;
      $this->add_log($this->razmen_log("skip",$this->battle[$u2][$u1][0],$this->get_wep_type($this->enemyhar['weap']),0,$u2,$this->en_class,$u1,$this->my_class,0,0,664), 1);
    } else {
      $attacks=array($this->battle[$u2][$u1][0], $this->battle[$u2][$u1][3], $this->battle[$u2][$u1][4], $this->battle[$u2][$u1][5], $this->battle[$u2][$u1][6]);
      $i=0;
      foreach ($attacks as $k=>$v) {
        $i++;
        if (!$v) continue;
        if ($i==1 || $i==3 || $i==5) $hn="";
        else $hn="1";
        $rez=$this-> makehit("he", $mf, $this->user["id"], $u2, $attack, $this->battle[$u1][$u2][1], $k+1, 1);
        if ($rez==1 || $rez==3 || $rez==4) {
          if ($rez==3 || $rez==4 || getchance($this->user_dress["mfcontr"])) {
            if ($rez!=3) {
              @$this->addtactic($u1, "counter", 1, $u2);
              $this->needupdate=1;
            }
            $this->add_log ($this->razmen_log("contr",$v,$this->enemyhar["minimax$hn"]["weptype"],0,$u2,$this->en_class,$u1,$this->my_class,0,0, $this->battle[$u1][$u2][1]), 1);
            $this->makehit("me", $mf, $this->user["id"], $u2, $attack, $this->battle[$u1][$u2][1], 1);
          } else {
            $this->add_log ($this->razmen_log("uvorot",$v,$this->enemyhar["minimax$hn"]["weptype"],0,$u2,$this->en_class,$u1,$this->my_class,0,0, $this->battle[$u1][$u2][1]), 1);
          }
        }
        if ($this->cowardshifts[$u2]) {
          $this->battleunits[$this->user["id"]]["defender"]=0;
          $this->cowardshifts[$u2]=0;
        }
      }
    }

    if ($this->battle[$u1][$u2][0]==664 && $this->battle[$u1][$u2][1]==664) {
      // пропустил по тайму;
      $this->add_log($this->razmen_log("skip",$this->battle[$u1][$u2][0],$this->get_wep_type($this->enemyhar['weap']),0,$u1,$this->en_class,$u2,$this->my_class,0,0,664), 1);
    } else {
      $attacks=array($this->battle[$u1][$u2][0], $this->battle[$u1][$u2][3], $this->battle[$u1][$u2][4], $this->battle[$u1][$u2][5], $this->battle[$u1][$u2][6]);
      $i=0;
      foreach ($attacks as $k=>$v) {
        $i++;
        if (!$v) continue;
        if ($i==1 || $i==3 || $i==5) $hn="";
        else $hn="1";
        $rez=$this->makehit("me", $mf, $u1, $u2, $v, $this->battle[$u1][$u2][1], $k+1, 1);
        if ($rez==1 || $rez==3 || $rez==4) {
          if ($rez==3 || $rez==4 || getchance($this->enemy_dress["mfcontr"])) {
            $this->addtactic($u2, "counter", 1, $u1);
            $this->needupdate=1;
            $this->add_log ($this->razmen_log("contr",$attack,$this->user["minimax$hn"]["weptype"],0,$this->user['id'],$this->my_class,$u2,$this->en_class,0,0, $this->battle[$u2][$this->user['id']][1]), 1);
            if ($k+1>$this->battleunits[$u2]["weapons"])  $k=0;
            $this->makehit("he", $mf, $u1, $u2, $this->battle[$u2][$this->user['id']][0], $this->battle[$u1][$u2][1], $k+1);
          } else {
            $this->add_log ($this->razmen_log("uvorot",$v,$this->user["minimax$hn"]["weptype"],0,$this->user['id'],$this->my_class,$u2,$this->en_class,0,0, $this->battle[$u2][$this->user['id']][1]), 1);
          }
        }
        if ($this->cowardshifts[$u1]) {
          $this->battleunits[$u2]["defender"]=0;
          $this->cowardshifts[$u1]=0;
        }
      }
    }
    $this->remmagstorm($u1);
    $this->remmagstorm($u2);
  }

  function addmagstorm($u) {
    static $stormsadded;
    $this->getbu($u);
    $this->getadditdata($u);
    if (!@$stormsadded) $stormsadded=array();
    if (!@$stormsadded[$u]) {
      $stormsadded[$u]=1;
      if (!@$this->battleunits[$u]["additdata"]["storm"]) $this->battleunits[$u]["additdata"]["storm"]=0;
      if ($this->battleunits[$u]["additdata"]["storm"]<6) {
        $this->battleunits[$u]["additdata"]["storm"]++;
        $this->needupdateaddit[$u]=1;
      }
    }
  }

  function remmagstorm($u) {
    $this->getadditdata($u);
    if ($this->battleunits[$u]["additdata"]["storm"]>0) {
      $this->battleunits[$u]["additdata"]["storm"]=0;
      $this->needupdateaddit[$u]=1;
    }
  }

  function actstrokesbymove($u) {
    global $strokes;
    foreach ($this->battleunits[$u]["priems"] as $k=>$v) {
      if ($v["wait"]>0) {
        $this->battleunits[$u]["priems"][$k]["wait"]--;
        $this->needupdatebu=1;
        $this->toupdatebu[$u]["priems"]=1;
      }
      if ($v["active"]!=1) {
        if ($strokes[$k]->type==4) {
          $this->updstroke($u, 1, 0, $k);
        }
        if ($strokes[$k]->type==3 && !@$strokes[$k]->noautoact) {
          $this->updstroke($u, 1, 0, $k);
        }
      }
    }
  }

  function canusepriem($u, $priem) {
    global $strokes;
    $this->getadditdata($u);
    if (
    $this->battleunits[$u]["additdata"]["hit"]<@$strokes[$priem]->n_hit ||
    $this->battleunits[$u]["additdata"]["block2"]<@$strokes[$priem]->n_block ||
    $this->battleunits[$u]["additdata"]["parry"]<@$strokes[$priem]->n_parry ||
    $this->battleunits[$u]["additdata"]["krit"]<@$strokes[$priem]->n_krit ||
    $this->battleunits[$u]["additdata"]["hp2"]<@$strokes[$priem]->n_hp ||
    $this->battleunits[$u]["additdata"]["counter"]<@$strokes[$priem]->n_counter ||
   ($this->battleunits[$u]["additdata"]["s_duh"]<=0 && @$strokes[$priem]->sduh>0) ||
    $this->battleunits[$u]["priems"][$priem]["wait"]>0 || 
    $this->battleunits[$u]["priems"][$priem]["active"]!=1) return false;

    return true;
  }

  function addbot($prototype, $userinteam, $name="") {
    $ud=mqfa("select login, maxhp from users where id='$prototype'");
    if (!$name) $name=$ud["login"];
    $logins=array();
    foreach ($this->userdata as $k=>$v) $logins[$v["login"]]=1;
    if ($logins[$name]) {
      $i=1;
      while (true) {
        if(!$logins["$name ($i)"]) {
          $name="$name ($i)";
          break;
        }
        $i++;
      }
    }
    mq("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('$name','$prototype','".$this->battle_data["id"]."','$ud[maxhp]');");
    $bot = mysql_insert_id();
    $this->battle[$bot] = $this->battle[$userinteam];
    foreach($this->battle[$bot] as $k => $v) {
      $this->battle[$k][$bot] = array(0,0,time());
    }
    $t1 = explode(";",$this->battle_data['t1']);
    if (in_array ($userinteam,$t1)) {$ttt = 1;} else {  $ttt = 2;}

    mq('UPDATE `battle` SET `t'.$ttt.'`=CONCAT(`t'.$ttt.'`,\';'.$bot.'\')  WHERE `id` = '.$this->battle_data["id"].' ;');

    $this->needupdate=1;
    return $bot;
  }

  function taketactics($u, $priem) {
    global $strokes;
    if ($strokes[$priem]->n_hit) $this->battleunits[$u]["additdata"]["hit"]-=$strokes[$priem]->n_hit;
    if ($strokes[$priem]->n_block) $this->battleunits[$u]["additdata"]["block2"]-=$strokes[$priem]->n_block;
    if ($strokes[$priem]->n_parry) $this->battleunits[$u]["additdata"]["parry"]-=$strokes[$priem]->n_parry;
    if ($strokes[$priem]->n_krit) $this->battleunits[$u]["additdata"]["krit"]-=$strokes[$priem]->n_krit;
    if ($strokes[$priem]->n_counter) $this->battleunits[$u]["additdata"]["counter"]-=$strokes[$priem]->n_counter;
    if ($strokes[$priem]->n_hp) $this->battleunits[$u]["additdata"]["hp2"]-=$strokes[$priem]->n_hp;
    if ($strokes[$priem]->sduh) $this->battleunits[$u]["additdata"]["s_duh"]=max(0, $this->battleunits[$u]["additdata"]["s_duh"]-$strokes[$priem]->sduh*100);

    if (@$strokes[$priem]->takealltactics) {
      $this->battleunits[$u]["additdata"]["hit"]=0;
      $this->battleunits[$u]["additdata"]["block2"]=0;
      $this->battleunits[$u]["additdata"]["parry"]=0;
      $this->battleunits[$u]["additdata"]["krit"]=0;
      $this->battleunits[$u]["additdata"]["counter"]=0;
      $this->battleunits[$u]["additdata"]["hp2"]=0;
    }
    $this->needupdateaddit[$u]=1;
  }
  
  function checkbotstrokes($bot) {
    global $strokes;
    if ($bot<_BOTSEPARATOR_ || $this->userdata[$bot]["hp"]<=0) return;
    $this->getbu($bot);
    $str=array();
    $str=array_keys($this->battleunits[$bot]["priems"]);
    shuffle($str);
    foreach ($str as $k=>$v) {
      if ($this->canusepriem($bot, $v) && ($this->battleunits[$u]["additdata"]["s_duh"]>0 || !@$strokes[$priem]->deltahp)) {
        $this->usepriem($bot, $v);
        if ($strokes[$v]->effect==DEFEND) {
          $this->addeffect($this->battleunits[$bot]["effects"]["wis_earth_summon"]["caster"], $strokes[$v]->effect, $strokes[$v]->value, 0, $v, array(), 0, 0, @$strokes[$priem]->effect2, @$strokes[$priem]->value2, $bot);
        } 
      }
    }
  }

  function checkshit($ui) {
    $this->getbu($ui);
    return $this->battleunits[$ui]["hasshield"];
    $ui=bottouser($ui);
    return mqfa1('SELECT id FROM `inventory` where  `owner` = '.$ui.' AND `dressed` = 1 and (`type` = 10 or otdel=30) ');
  }

  function showkillown() {
    global $user;
    if ($user["level"]>=10 && count($this->team_mine)>0 && $this->battle_data["type"]!=3 && $this->battle_data["type"]!=10 && ($this->battle_data["leader1"]==$user["id"] || $this->battle_data["leader2"]==$user["id"]) && $this->battle_data["type"]!=UNLIMCHAOS) return "<a href=\"javascript:void(0)\" onClick=\"findlogin('Исключить персонажа из боя', 'fbattleb.php?killown=1', 'target', '')\"><img onmouseover='fastshow2(\"<B>Исключить из боя</B>\", this, event)' onmouseout='hideshow();' border=\"\" src=\"".IMGBASE."/i/sh/killplayer.gif\"></a>";
    else return "";
  }

  function checkend() {
    global $user;
    if ($this->battle_end()) {
      $this->return = 2;
      $this->write_log ();
      $user["battle"]=0;
    }
  }

  function nick5 ($id, $st="", $plain=0) {
    $this->getbu($id);
    if (!$st) {
      if (in_array($id,$this->t1)) {$st="B1";} else {$st="B2";}
    }
    if ($this->battleunits[$id]["invis"]) { 
      if ($plain) return "невидимка";
      return "<span class={$st}></a><b><i>невидимка</i></b></span>";
    } else {
      if ($plain) return $this->userdata[$id]["login"];
      else return "<span class={$st}>".$this->userdata[$id]["login"]."</span>";
    }
  }

  function nick7 ($id) {
    return $this->userdata[$id]["login"];
  }


  function getpriems($u) {
    $this->getbu($u);
    /*foreach ($this->battleunits[$u]["priems"] as $k=>$v) {
      $this->battleunits[$u]["priems"][$k]["active"]=$this->battleunits[$u]["priems"][$k]["pr_active"];
      $this->battleunits[$u]["priems"][$k]["uses"]=$this->battleunits[$u]["priems"][$k]["pr_cur_uses"];
      $this->battleunits[$u]["priems"][$k]["wait"]=$this->battleunits[$u]["priems"][$k]["pr_wait_for"];
    }*/
    return $this->battleunits[$u]["priems"];
  }

  function minval($u1, $u2) {
    if ($this->battleunits[$u1]["level"]>$this->battleunits[$u2]["level"]) return $this->battleunits[$u1]["cost"]*(1+(($this->battleunits[$u1]["level"]-$this->battleunits[$u2]["level"])/2));
    else return $this->battleunits[$u1]["cost"]*(pow(0.9, $this->battleunits[$u2]["level"]-$this->battleunits[$u1]["level"]));
  }

  function ispvp() {
    $ip=0;
    foreach ($this->t1 as $k=>$v) {
      if ($v<_BOTSEPARATOR_) {
        $ip++;
        break;
      }
    }
    foreach ($this->t2 as $k=>$v) {
      if ($v<_BOTSEPARATOR_) {
        $ip++;
        break;
      }
    }
    if ($ip==2) return true;
    return false;
  }
  
  function addtactic($user, $tactic, $cnt, $from, $force=0) {
    global $strokebots;
    if (!$force) {
      foreach ($this->battleunits[$user]["effects"] as $k=>$v) {
        if ($v["effect"]==SHOCK) return;
      }
    }
    if ($user<_BOTSEPARATOR_ && $this->ispvp() && !$force) {
      if ($this->cantgettatic($user, $from)) return;
    }
    if ($user<_BOTSEPARATOR_ || @$strokebots[$this->battleunits[$user]["prototype"]]) {
      $this->getadditdata($user);
      $this->battleunits[$user]["additdata"][$tactic]+=$cnt;
      if ($this->battleunits[$user]["additdata"][$tactic]>25) $this->battleunits[$user]["additdata"][$tactic]=25;
      $this->needupdateaddit[$user]=1;
    }
    //@$this->toupdate[$user][$tactic]+=$cnt;
    //$this->needupdate=1;
  }
  
  function getshock($u) {
    $this->getbu($u);
    foreach ($this->battleunits[$u]["effects"] as $k=>$v) {
      if ($v["effect"]==SHOCK) return true;
    }
    return false;
  }
     
  function resolvestrokes(&$priems, $u) {
    global $strokes;
    //foreach ($priems as $k2=>$v2) $priems[$k2]["active"]=1;
    foreach ($this->battleunits[$u]["priems"] as $k=>$v) {
      if ($v["active"]==2 && !@$strokes[$k]->unresolvable) { 
        $this->logstrokeend($k, $u);
        $this->battleunits[$u]["priems"][$k]["active"]=1;
        $this->toupdatebu[$u]["priems"]=1;
        $this->needupdatebu=1;
      }
    }
    foreach ($this->battleunits[$u]["effects"] as $k=>$v) {
      if ($v["good"] && !@$strokes[$k]->unresolvableeffect && ($strokes[$k]->type<>4 || @$strokes[$k]->resolvable)) {
        $this->remeffect($u, $k, $v);
        $this->logstrokeend($k, $u);
      }
    }
  }

  function steelstrokes(&$priems, &$enemypriems, $u, $e) {
    global $strokes;
    foreach ($enemypriems as $k2=>$v2) {
      if ($enemypriems[$k2]["active"]==2) {
        if (@$priems[$k2]["active"]!=2) {
          if (@$priems[$k2]) {
            $priems[$k2]["active"]=2;
            $this->battleunits[$u]["priems"][$k2]["active"]=2;
            $this->battleunits[$u]["priems"][$k2]["active"]=2;
          } else {
            $priems[$k2]=$enemypriems[$k2];
            $this->battleunits[$u]["priems"][$k2]=$this->battleunits[$e]["priems"][$k2];
          }
          $this->toupdatebu[$u]["priems"]=1;
          $this->toupdatebu[$e]["priems"]=1;
          $this->needupdatebu=1;
        }
      }
    }
    foreach ($this->battleunits[$e]["effects"] as $k=>$v) {    
      if ($v["good"] && !@$strokes[$k]->unresolvableeffect) {
        if (!$this->battleunits[$u]["effects"][$k]) {
          $this->battleunits[$u]["effects"][$k]=$v;
          if ($v["effect"]==EXTRAMF) {
            $this->remeffectmf($e, $k);
            $this->addeffectmf($u, $k);
          }
          $this->toupdatebu[$u]["effects"]=1;
          $this->toupdatebu[$e]["effects"]=1;
          $this->needupdatebu=1;
        }
      }      
    }
  }

  function remeffectmf($user, $priem, $effect=0) {
    global $strokes;
    if (!$effect) $effect=$this->battleunits[$user]["effects"][$priem];
    if ($strokes[$priem]->mf=="sila") {
      $this->toupdatebu[$user][$strokes[$priem]->mf]-=$effect["value"];
      if (@$strokes[$priem]->mf2) $this->toupdatebu[$user][$strokes[$priem]->mf2]-=$effect["value2"];
    } else {
      $upd.=$strokes[$priem]->mf."=".$strokes[$priem]->mf."-$effect[value]";
      if (@$strokes[$priem]->mf2) {
        $upd.=", ";
        $upd.=$strokes[$priem]->mf2."=".$strokes[$priem]->mf2."-$effect[value2]";
      }
      mq("update battleunits set $upd where user='$user' and battle='".$this->battle_data["id"]."'");
    }
  }

  function addeffectmf($user, $priem) {
    global $strokes;
    $v=$this->battleunits[$user]["effects"][$priem];
    if ($strokes[$priem]->mf=="sila") {
      $this->toupdatebu[$user][$strokes[$priem]->mf]+=$v["value"];
      if (@$strokes[$priem]->mf2) $this->toupdatebu[$user][$strokes[$priem]->mf2]+=$v["value2"];
    } else {
      $upd.=$strokes[$priem]->mf."=".$strokes[$priem]->mf."+$v[value]";
      if (@$strokes[$priem]->mf2) {
        $upd.=", ";
        $upd.=$strokes[$priem]->mf2."=".$strokes[$priem]->mf2."+$v[value2]";
      }
      mq("update battleunits set $upd where user='$user' and battle='".$this->battle_data["id"]."'");
    }
  }
  
  function updstroke($user, $act, $use, $priem) {
    global $strokes;
    $priems=array();
    if ($use) {
      if ($priem=="spirit_13_prot_100" || $priem=="spirit_12_prot_100" || $priem=="spirit_11_prot_100" || $priem=="spirit_14_prot_100") {
        $priems=array("spirit_13_prot_100", "spirit_12_prot_100", "spirit_11_prot_100", "spirit_14_prot_100");
      }
      if ($priem=="spirit_1_protfire100" || $priem=="spirit_2_protwater100" || $priem=="spirit_3_protair100" || $priem=="spirit_4_protearth100") {
        $priems=array("spirit_1_protfire100", "spirit_2_protwater100", "spirit_3_protair100", "spirit_4_protearth100");
      }
      if ($priem=="wis_earth_shield" || $priem=="wis_earth_shield2" || $priem=="wis_fire_shield" || $priem=="wis_air_shield07" || $priem=="wis_air_shield08"
      || $priem=="wis_air_shield09" || $priem=="wis_air_shield10" || $priem=="wis_water_shield07" || $priem=="wis_water_shield08" || $priem=="wis_water_shield09") {
        $priems=array("wis_earth_shield", "wis_earth_shield2", "wis_fire_shield", "wis_air_shield07", "wis_air_shield08", "wis_air_shield09", "wis_air_shield10", "wis_water_shield07", "wis_water_shield08", "wis_water_shield09");
      }
      if ($priem=="novice_def" || $priem=="novice_hit" || $priem=="novice_hp") {
        $priems=array("novice_def", "novice_hit", "novice_hp");
      }
      if (strpos($priem, "wis_air_charge_")===0) {
        $priems=array("wis_air_charge_shock","wis_air_charge_gain","wis_air_charge_dmg");
      }
      if ($strokes[$priem]->type==4 && !@$strokes[$priem]->move && !@$strokes[$priem]->dontactother) {
        foreach ($this->battleunits[$user]["priems"] as $k=>$v) {
          if ($strokes[$k]->type==4 && !@$strokes[$k]->move && !@$strokes[$k]->dontactother) $this->battleunits[$user]["priems"][$k]["active"]=$act;
        }
      }
    }
    foreach ($this->battleunits[$user]["priems"] as $k=>$v) {
      if (in_array($k, $priems)) $this->battleunits[$user]["priems"][$k]["wait"]=$strokes[$priem]->wait;
      if (!eqstrokes($k,$priem)) continue;
      if ($use) {
        if (@$strokes[$priem]->wait) $this->battleunits[$user]["priems"][$k]["wait"]=$strokes[$priem]->wait;
        $this->battleunits[$user]["priems"][$k]["uses"]++;
      }
      $this->battleunits[$user]["priems"][$k]["active"]=$act;
    }
    $this->toupdatebu[$user]["priems"]=1;
    $this->needupdatebu=1;
  }      
  
  function actpriem($priem, $id, $user, $active, $makelast, $use=0) {
    global $strokes;
    if ($active) {
      $this->updstroke($user, $active, $use, $priem);
    }
    if ($makelast && !@$strokes[$priem]->noshock) {
      $this->needupdatebu=1;
      $this->toupdatebu[$user]["laststroke"]=$priem;
    }
  }
  
  function addstroke($priem, $user, $active) {
    global $strokes;
    $this->updstroke($user, $active, 0, $priem);
    $this->battleunits[$user]["priems"][$priem]["active"]=$active;
    $this->battleunits[$user]["priems"][$priem]["active"]=$active;
    $this->toupdatebu[$user]["priems"]=1;
    $this->needupdatebu=1;
  }  
  
  function shockpriem($priem, $user, $shock) {
    global $strokes;
    foreach ($this->battleunits[$user]["priems"] as $k=>$v) {
      if (!eqstrokes($k, $priem)) continue;
      $this->battleunits[$user]["priems"][$k]["wait"]+=$shock;
    }
    $this->toupdatebu[$user]["priems"]=1;
    $this->needupdatebu=1;
  }
  
  function getunit($u, $t1, $t2, $e=0, $skip=0) {
    $rets=array();
    if (in_array($u, $this->t1)) $in1=1;
    else $in1=0;
    if (($in1 && $t1) || (!$in1 && $t2)) foreach ($this->t1 as $k=>$v) if (($this->userdata[$v]["hp"]>0 || $v==$u || $v==$e) && $v!=$skip) $rets[]=$v;
    if (($in1 && $t2) || (!$in1 && $t1)) foreach ($this->t2 as $k=>$v) if (($this->userdata[$v]["hp"]>0 || $v==$u || $v==$e) && $v!=$skip) $rets[]=$v;
    $r=array_rand($rets);
    return $rets[$r];
  }  

  function logstrokeend($priem, $owner=0) {
    global $strokes, $user;
    static $logged;
    if (@$logged[$owner][$priem]) return;
    $logged[$owner][$priem]=1;
    $this->add_log('<span class=date>'.date("H:i").'</span> Закончилось действие '.($strokes[$priem]->iseffect?"эффекта":"приёма").' "<FONT color=#A00000><b>'.(@$strokes[$priem]->name?$strokes[$priem]->name:$priem).'</b></font>" у '.$this->nick5($owner).'.<BR>');
  }

  function gettargets($priem, $stroketarget) {
    global $strokes;
    srand();
    $targets=@$strokes[$priem]->targets;
    //foreach ($targets as $k=>$v) if ($this->userdata[$v]["hp"]<=0) unset($targets[$k]);
    if (!@$targets) return array($stroketarget);
    if (@$strokes[$priem]->targetsrnd) $targets+=rand(0,$strokes[$priem]->targetsrnd);
    if (@$strokes[$priem]->target=="enemy" || @$strokes[$priem]->currenttarget) $targetteam=$this->team_enemy;
    else $targetteam=$this->team_mine;
    foreach ($targetteam as $k=>$v) {
      if (@$strokes[$priem]->healself) $c1=$v==$this->user["id"];
      else $c1=false;
      if ($c1 || $v==$stroketarget || $this->userdata[$v]["hp"]<=0) unset($targetteam[$k]);
    }
    if (@$strokes[$priem]->healself && $stroketarget==$this->user["id"]) $targets++;
    if ($targets-1>count($targetteam)) $targets=count($targetteam)+1;
    if ($targets>1) {
      if ($targets>2) $othertargets=array_rand($targetteam, $targets-1);
      else $othertargets[0]=array_rand($targetteam);
    } else $othertargets=array();
    $ret[]=$stroketarget;
    if (@$strokes[$priem]->healself && $stroketarget!=$this->user["id"]) $ret[]=$this->user["id"];
    foreach ($othertargets as $k=>$v) $ret[]=$targetteam[$v];
    return $ret;
  }
  
  function getdeltastun($u) {
    foreach ($this->battleunits[$u]["effects"] as $k=>$v) {
      if ($v["effect"]==DELTASTUN) return $v["value"];
    }
  }

  function addimmunity($to, $priem) {
    global $strokes;
    $this->battleunits[$to]["effects"]["$priem-i"]["effect"]=IMMUNITY;
    $this->battleunits[$to]["effects"]["$priem-i"]["length"]=$strokes[$priem]->immunity;
  }

  function haseffect($id, $effect) {
    $this->getbu($id);
    foreach ($this->battleunits[$id]["effects"] as $k=>$v) if (strpos($k, $effect)===0) return ($v["cnt"]?$v["cnt"]:1);
    return false;
  }

  function haseffecttype($id, $effect) {
    $this->getbu($id);
    foreach ($this->battleunits[$id]["effects"] as $k=>$v) if ($v["effect"]==$effect || @$v["effect2"]==$effect || @$v["effect3"]==$effect) return $k;
    return false;
  }

  function effectval($id, $effect) {
    $this->getbu($id);
    foreach ((array)@$this->battleunits[$id]["effects"] as $k=>$v) {
      if ($v["effect"]==$effect) return $v["value"]; 
      if (@$v["effect2"]==$effect) return $v["value2"]; 
      if (@$v["effect3"]==$effect) return $v["value3"]; 
    }
    return 0;
  }

  //эффект от приёма ещё не на максимуме
  function notmaxeffect($user, $priem) {
    global $strokes;
    if (!$strokes[$priem]->max) return true;
    $this->getbu($u);
    if ($strokes[$priem]->max>$this->battleunits[$user]["effects"][$priem]["cnt"]) return true;
    return false;
  }
                        
  function addeffect($to, $effect, $val, $iskrit, $priem, $logdata, $logit=1, $mana=0, $effect2=0, $val2=0, $caster=0, $effect3=0, $val3=0) {
    global $strokes, $user;
    if ($effect==SHOCK) $deltalen=-$this->getdeltastun($to);
    if ($effect2==SHOCK) $deltalen=-$this->getdeltastun($to);
    if ($effect3==SHOCK) $deltalen=-$this->getdeltastun($to);
    if (@$this->battleunits[$to]["defender"]) $to=$this->battleunits[$to]["defender"];
    
    if (!$caster) $caster=$user["id"];
    $this->getbu($to);
    if ($val=="hp0025") $val=ceil($this->userdata[$to]["maxhp"]*0.025);
    if ($val=="intel04") $val=ceil($user["intel"]*0.4);
    if ($val=="-mwater") $val=-$this->battleunits[$caster]["mwater"];
    if ($val2 && $val2=="-mwater") $val2=-$this->battleunits[$caster]["mwater"];
    if (!$val2 && $effect2) $val2=$val;
    if (!$val3 && $effect3) $val3=$val;

    if ($priem=="wis_fire_mark" || $priem=="wis_water_mark" || $priem=="wis_air_mark" || $priem=="wis_earth_mark") {
      foreach ($this->battleunits[$to]["effects"] as $k=>$v) {
        if ($k!=$priem && ($k=="wis_fire_mark" || $k=="wis_water_mark" || $k=="wis_air_mark" || $k=="wis_earth_mark")) {
          $this->remeffect($to, $k, $v);
          $this->logstrokeend($k, $to);
        }
      }
    }
    if (@$strokes[$priem]->eternal) {
      if (@$strokes[$priem]->good) $this->battleunits[$to]["effects"][$priem]["good"]=$strokes[$priem]->good;
      $this->battleunits[$to]["effects"][$priem]["effect"]=$effect;
      if ($effect2) $this->battleunits[$to]["effects"][$priem]["effect2"]=$effect2;
      if ($effect3) $this->battleunits[$to]["effects"][$priem]["effect3"]=$effect3;
      $this->battleunits[$to]["effects"][$priem]["caster"]=$caster;
      if ($strokes[$priem]->additive) {
        @$this->battleunits[$to]["effects"][$priem]["value"]+=$val;
        if ($val2) @$this->battleunits[$to]["effects"][$priem]["value2"]+=$val2;
        if ($val3) @$this->battleunits[$to]["effects"][$priem]["value3"]+=$val3;
        $this->battleunits[$to]["effects"][$priem]["cnt"]++;
      } else {
        $this->battleunits[$to]["effects"][$priem]["value"]=$val;
        if ($val2) @$this->battleunits[$to]["effects"][$priem]["value2"]=$val2;
        if ($val3) @$this->battleunits[$to]["effects"][$priem]["value3"]=$val3;
          $this->battleunits[$to]["effects"][$priem]["cnt"]=1;
      }
      //if (@$strokes[$priem]->manaamove) $this->battleunits[$to]["effects"][$priem]["manaamove"]=$strokes[$priem]->manaamove;
      if ($mana) $this->battleunits[$to]["effects"][$priem]["mana"]=$mana;
      $this->toupdatebu[$to]["effects"]=1;
      $this->needupdatebu=1;
    } else {
      if ($effect==FORCEFIELD) {
        @$this->toupdatebu[$to]["forcefield"]=$val-$this->battleunits[$to]["forcefield"];
        @$this->toupdatebu[$to]["manabarrier"]=-$this->battleunits[$to]["manabarrier"];
        $this->battleunits[$to]["manabarrier"]=0;
        $this->needupdatebu=1;
        $logdata["strokeonly"]=1;
        if ($logit) logstroke($priem, $logdata);
        if ($this->haseffect($to, "wis_air_shield")) $this->remeffect($to, "wis_air_shield");
        return;
      }
      if ($effect==MAGICBARRIER) {
        @$this->toupdatebu[$to]["manabarrier"]=$val-$this->battleunits[$to]["manabarrier"];
        @$this->toupdatebu[$to]["forcefield"]=-$this->battleunits[$to]["forcefield"];
        $this->battleunits[$to]["forcefield"]=0;
        $this->toupdatebu[$to]["mbstroke"]=(int)str_replace("wis_gray_manabarrier","",$priem);
        $this->needupdatebu=1;
        $logdata["strokeonly"]=1;
        if ($logit) logstroke($priem, $logdata);
        if ($this->haseffect($to, "wis_air_shield")) $this->remeffect($to, "wis_air_shield");
        return;
      }
      if ($effect==AIRSHIELD) {
        if ($this->battleunits[$to]["forcefield"]) {
          $this->toupdatebu[$to]["forcefield"]=-$this->battleunits[$to]["forcefield"];
          $this->battleunits[$to]["forcefield"]=0;
        }
        if ($this->battleunits[$to]["manabarrier"]) {
          $this->toupdatebu[$to]["manabarrier"]=-$this->battleunits[$to]["manabarrier"];
          $this->battleunits[$to]["manabarrier"]=0;
        }

      }
      
      if ($strokes[$priem]->additive) {
        $effname=$priem;
        foreach ($this->battleunits[$to]["effects"] as $k=>$v) {
          if (eqstrokes($k, $priem)) {
            $effname=$k;
          }
        }
        if ($this->notmaxeffect($to, $effname)) {
          $this->battleunits[$to]["effects"][$effname]["value"]+=$val;
          //if (@$strokes[$priem]->manaamove) $this->battleunits[$to]["effects"][$effname]["manaamove"]+=$strokes[$priem]->manaamove;
          if (@$mana) $this->battleunits[$to]["effects"][$effname]["mana"]+=$mana;
          if ($effect2) {
            $this->battleunits[$to]["effects"][$effname]["effect2"]=$effect2;
            $this->battleunits[$to]["effects"][$effname]["value2"]+=$val2;
          }
          if ($effect3) {
            $this->battleunits[$to]["effects"][$effname]["effect3"]=$effect3;
            $this->battleunits[$to]["effects"][$effname]["value3"]+=$val3;
          }
          $this->battleunits[$to]["effects"][$priem]["cnt"]++;
        } else $effectfailed=1;
      } else {
        if (@$strokes[$priem]->multiple) {
          $i=0;
          while ($this->battleunits[$to]["effects"]["$priem-$i"]) $i++;
          $effname="$priem-$i";
        } else {
          $effname=$priem;
          foreach ($this->battleunits[$to]["effects"] as $k=>$v) {
            if ($effect==DEFEND && $v["effect"]==DEFEND) return 0;
            if (eqstrokes($k, $priem)) {
              unset($this->battleunits[$to]["effects"][$k]);
              $effectfailed=1;
            }
          }
        }
        $this->battleunits[$to]["effects"][$effname]["value"]=$val;
        if ($effect2) {
          $this->battleunits[$to]["effects"][$effname]["effect2"]=$effect2;
          $this->battleunits[$to]["effects"][$effname]["value2"]=$val2;
        }        
        if ($effect3) {
          $this->battleunits[$to]["effects"][$effname]["effect3"]=$effect3;
          $this->battleunits[$to]["effects"][$effname]["value3"]=$val3;
        }        
        //if (@$strokes[$priem]->manaamove) $this->battleunits[$to]["effects"][$effname]["manaamove"]=$strokes[$priem]->manaamove;
        if ($mana) $this->battleunits[$to]["effects"][$effname]["mana"]=$mana;
      }
      $this->battleunits[$to]["effects"][$effname]["effect"]=$effect;
      if (@$strokes[$priem]->good) $this->battleunits[$to]["effects"][$effname]["good"]=$strokes[$priem]->good;
      if (@$strokes[$priem]->length) {
        $this->battleunits[$to]["effects"][$effname]["length"]=$strokes[$priem]->length+$deltalen;
      }
      else $this->battleunits[$to]["effects"][$effname]["length"]=1;
      $this->battleunits[$to]["effects"][$effname]["caster"]=$caster;

      $this->toupdatebu[$to]["effects"]=1;
      $this->needupdatebu=1;
      /*$rec=mqfa("select id, value from battleeffects where battle='$user[battle]' and user='$to' and effect='".$effect."' and priem='$priem'");
      if ($rec) {
        if ($strokes[$priem]->additive) {
          if ($strokes[$priem]->max>$rec["value"]) mq("update battleeffects set length=".$strokes[$priem]->length.", value= value + '".$val."', caster='$caster', mana='$mana' where id='$rec[id]'");
        } else mq("update battleeffects set length=".$strokes[$priem]->length.", value='".$val."', caster='$caster', mana='$mana' where id='$rec[id]'");
      } else mq("insert into battleeffects set battle='$user[battle]', user='$to', effect='".$effect."', value='".$val."', length=".$strokes[$priem]->length.", priem='$priem', caster='$caster', mana='$mana'");*/
    }
    if ($effect==EXTRAMF && !@$effectfailed) {
      if (@$strokes[$priem]->mf2) {
        if ($strokes[$priem]->additive) $this->battleunits[$to]["effects"][$priem]["value2"]+=$val2;
        else $this->battleunits[$to]["effects"][$priem]["value2"]=$val2;
      }
      if ($strokes[$priem]->mf=="sila") {        
        $this->toupdatebu[$to][$strokes[$priem]->mf]+=$val;
        if (@$strokes[$priem]->mf2) $this->toupdatebu[$to][$strokes[$priem]->mf2]+=$val2;
      } else {
        if ($strokes[$priem]->mf=="bron") {
          $upd1="bronmin1=bronmin1+$val, bron1=bron1+$val, bronmin2=bronmin2+$val, bron2=bron2+$val, bronmin3=bronmin3+$val, bron3=bron3+$val, bronmin4=bronmin4+$val, bron4=bron4+$val, bronmin5=bronmin5+$val, bron5=bron5+$val";
        } else {
          $upd1=$strokes[$priem]->mf."=".$strokes[$priem]->mf."+".$val;
        }
        mq("update battleunits set $upd1 ".(@$strokes[$priem]->mf2?", ".$strokes[$priem]->mf2."=".$strokes[$priem]->mf2."+".$val2:"")." where battle='$user[battle]' and user='$to'");
      }
    }
    if ($effect2==EXTRAMF && !@$effectfailed) {
      mq("update battleunits set ".$strokes[$priem]->mf."=".$strokes[$priem]->mf."+".$val2." ".(@$strokes[$priem]->mf2?", ".$strokes[$priem]->mf2."=".$strokes[$priem]->mf2."+".$val2:"")." where battle='$user[battle]' and user='$to'");
    }
    if ($effect==EXTRAMAGSKILL && !@$effectfailed) {
      $this->toupdatebu[$to]["magskill"]=$val;
    }
    $logdata["effect"]=1;
    if ($strokes[$priem]->selfcast) {
      $logdata["selfcast"]=1;
      if ($logit) logstroke($priem, $logdata);
    } else {
      if ($strokes[$priem]->target=="ally") $logdata["enemy"]=$this->nick5($to,$this->my_class);
      else $logdata["enemy"]=$this->nick5($to,$this->en_class);
      if ($logit) logstroke($priem, $logdata);
    }
    foreach ((array)@$this->toupdatebu[$to]["unseteffects"] as $k=>$v) {
      if ($v==$priem) {
        unset($this->toupdatebu[$to]["unseteffects"][$k]);
      }
    }
    return 1;    
  }
  
  function undefend($user, $leavedefender=0) {
    foreach ($this->rezmfs[$user] as $k=>$v) {
      $this->battleunits[$user][$k]=$v;
      if ($user==$this->user["id"]) $this->user_dress[$k]=$v;
      else $this->enemy_dress[$k]=$v;
    }
    if (!$leavedefender) $this->battleunits[$user]["defender"]=0;
  }

  function defend($user, $defender, $priem=0, $force=0, $block=0) {
    if ($priem=="block_target") $block=1;
    $this->getbu($user);
    $this->getbu($defender);
    if ($this->userdata[$defender]["hp"]<=0 && !$force) return;
    $mfs=array("sila", "lovk", "inta", "vinos", "intel", "spirit", "cost", "hasshield", "mfakrit", "mfuvorot", "bron1", "bronmin1", "bron2", "bronmin2", "bron3", "bronmin3", "bron4", "bronmin4", "bron5", "bronmin5", "mfantikritpow", "mfparir", "mfshieldblock", "mfdhit", "mfdhit1", "mfdhit2", "mfdhit3", "mfdhit4", "mfdhit5", "mfdkol", "mfdrej", "mfdrub", "mfddrob", "mfdmag", "mfdfire", "mfdwater", "mfdair", "mfdearth", "mfdlight", "mfddark","resurrect","forcefield","manabarrier","mbstroke","sex","invis","level");
    
    foreach ($mfs as $k=>$v) {
      $this->rezmfs[$user][$v]=$this->battleunits[$user][$v];
      $this->battleunits[$user][$v]=$this->battleunits[$defender][$v];
//      echo "$user [$v] = ".$this->battleunits[$defender][$v]."<br>";
    }
    if ($user==$this->user["id"]) $this->user_dress=$this->battleunits[$user];
    else $this->enemy_dress=$this->battleunits[$user];
//    die;
    $this->battleunits[$user]["defender"]=$defender;
    $this->battleunits[$user]["defenderblock"]=$block;
    if ($priem) {
      $this->logstrokeend($priem, $user);
      unset($this->battleunits[$user]["effects"][$priem]);
      $this->toupdatebu[$user]["effects"]=1;
      $this->needupdatebu=1;    
    }
  }

  function remeffect($user, $priem, $effect=0) {
    global $strokes;
    if (!$effect) $effect=$this->battleunits[$user]["effects"][$priem];
    if (@$strokes[$priem]->effectoncaster) {
      $this->remeffect($this->battleunits[$user]["effects"][$priem]["caster"], "$priem-oncaster", $this->battleunits[$this->battleunits[$user]["effects"][$priem]["caster"]]["effects"]["$priem-oncaster"]);
    }
    if ($effect["effect"]==EXTRAMF) {
      if ($strokes[$priem]->mf=="sila") {
        $this->remeffectmf($user, $priem, $effect);
      } else {
        if ($strokes[$priem]->mf=="bron") {
          $upd1="bronmin1=bronmin1-$effect[value], bron1=bron1-$effect[value], bronmin2=bronmin2-$effect[value], bron2=bron2-$effect[value], bronmin3=bronmin3-$effect[value], bron3=bron3-$effect[value], bronmin4=bronmin4-$effect[value], bron4=bron4-$effect[value], bronmin5=bronmin5-$effect[value], bron5=bron5-$effect[value]";
          $i=0;
          while ($i<5) {
            $i++;
            $this->battleunits[$user]["bronmin$i"]-=$effect["value"];
            $this->battleunits[$user]["bron$i"]-=$effect["value"];
          }
        } else {
          $upd1=$strokes[$priem]->mf."=".$strokes[$priem]->mf."-$effect[value]";
          $this->battleunits[$user][$strokes[$priem]->mf]-=$effect["value"];
        }
        if (@$strokes[$priem]->mf2) $this->battleunits[$user][$strokes[$priem]->mf2]-=$effect["value2"];
        mq("update battleunits set $upd1 ".(@$strokes[$priem]->mf2?", ".$strokes[$priem]->mf2."=".$strokes[$priem]->mf2."-$effect[value2]":"")." where user='$user' and battle='".$this->battle_data["id"]."'");
      }
    }
    if ($effect["effect"]==EXTRAMAGSKILL) {
      mq("update battleunits set mfire=mfire-$effect[value], mwater=mwater-$effect[value], mair=mair-$effect[value], mearth=mearth-$effect[value]  where user='$user' and battle='".$this->battle_data["id"]."'");
      $this->battleunits[$user]["mfire"]-=$effect["value"];
      $this->battleunits[$user]["mwater"]-=$effect["value"];
      $this->battleunits[$user]["mair"]-=$effect["value"];
      $this->battleunits[$user]["mearth"]-=$effect["value"];
    }
    if ($effect["effect"]==LIFE) {
      $this->takehp($this->userdata[$user]["hp"], $user, $this->userdata[$user]["hp"], 0);
    }
    unset($this->battleunits[$user]["effects"][$priem]);
    $this->toupdatebu[$user]["effects"]=1;
    $this->needupdatebu=1;
  }

  function processbattleeffect($userid, $priem, $effect, $enemy) {
    global $user, $strokes;
    if ($effect["type"]==1 && $effect["img"]) return;
    if ($effect["mana"]) {
      $this->takemana($effect["mana"], $effect["caster"], $strokes[$priem]->damagetype);
      if ($this->userdata[$effect["caster"]]["mana"]<=0) {
        $this->getbu($effect["caster"]);
        $this->logstrokeend($priem, $userid);
        $this->actpriem($priem, $id, $effect["caster"], 1, 0);
        $this->remeffect($userid, $priem, $effect);
      }
      //$this->takemana($effect["mana"], $effect["caster"]);
    }
    if ($effect["effect"]==FIREDAMAGE || $effect["effect"]==WATERDAMAGE || $effect["effect"]==EARTHDAMAGE || $effect["effect"]==AIRDAMAGE || ($this->battleunits[$userid]["effects"][$priem]["length"]<=1 && $effect["effect"]==DELAYEDDAMAGE)) {
      if (strpos($priem,"wis_fire_flamming")===0) $tmp="пожирающего пламени";
      if (strpos($priem,"wis_water_frost")===0) $tmp="оледенения";
      if (strpos($priem,"wis_water_poison")===0) $tmp="отравления";
      if (strpos($priem,"wis_water_cloud")===0) $tmp="ядовитого облака";
      if (strpos($priem,"wis_water_tempheal")===0) $tmp="эффекта <b>Ледяное спасение</b>";
      if (strpos($priem,"wis_earth_meteor")===0) $tmp="упавшего на голову метеорита";
      if (strpos($priem,"wis_water_sacrifice")===0) $tmp="эффекта <b>Жертва воде</b>";
      if (strpos($priem,"wis_earth_link_plus")===0) $tmp="эффекта <b>Заземление: плюс</b>";
      $mhp=$this->userdata[$userid]["maxhp"];
      $damage=$effect["value"];
      if ($effect["effect"]!=DELAYEDDAMAGE && $strokes[$priem]->length>1) $damage=geteffectval($damage, $effect["length"], $strokes[$priem]->length);
      
      $this->getpriems($userid);
      $res=$this->checkpriems2($this->battleunits[$userid]["priems"],($userid==$this->user["id"]?$this->my_class:$this->en_class),$userid,0,0,0);
      $damage=$this->processstrokeeffect2($res, $damage);
      if ($effect["effect2"]==HEALCASTER && $damage) {
        $this->getbu($effect["caster"]);
        $healed=$this->addhp($damage, $effect["caster"]);
        if(in_array($effect["caster"], $this->team_mine)) $this->addlog2($this->battle_data["id"], $this->my_class, $effect["caster"], "heal", $healed, $this->userdata[$effect["caster"]]["hp"], $this->userdata[$effect["caster"]]["maxhp"], $priem);
        else $this->addlog2($this->battle_data["id"], $this->en_class, $effect["caster"], "heal", $healed, $this->userdata[$effect["caster"]]["hp"], $this->userdata[$effect["caster"]]["maxhp"], $priem);
      }
      $damage=$this->takehp($damage, $userid, $this->userdata[$userid]["hp"], 1, $effect["caster"]);
      if ($userid==$this->user["id"]) $this->addlog2($this->battle_data["id"], $this->my_class, $userid, "magicdamage".$effect["effect"], $damage, $this->userdata[$userid]["hp"], $mhp, $tmp);
      else $this->addlog2($this->battle_data["id"], $this->en_class, $userid, "magicdamage". $effect["effect"], $damage, $this->userdata[$userid]["hp"], $mhp, $tmp);
      /*if ($userid==$user["id"]) {
        $mhp=$user["maxhp"];
        addlog2($user['battle'], $this->my_class, $userid, "magicdamage".$effect["effect"], $effect["value"], $user["hp"]-$effect["value"], $user["maxhp"], $tmp);
        $this->takehp($effect["value"], $userid, $user["hp"]);
        $this->addhp2($effect["caster"], $userid, $effect["value"]);
      } else {
        addlog2($user['battle'], $this->en_class, $userid, "magicdamage". $effect["effect"], $effect["value"], $this->enemyhar["hp"]-$effect["value"], $this->enemyhar["maxhp"], $tmp);
        $this->takehp($effect["value"], $userid, $this->enemyhar["hp"]);
        $this->addhp2($effect["caster"], $userid, $effect["value"]);
      }*/
      if ($effect["caster"] && !@$strokes[$priem]->noexp) $this->adddamage($effect["caster"], $damage, $userid);
    } elseif ($effect["effect"]==MANADAMAGE) {
      $damage=geteffectval($effect["value"], $effect["length"], $strokes[$priem]->length);
      $this->takemana($damage, $userid, 0, 0);
      if ($userid==$this->user["id"]) $this->addlog2($this->battle_data["id"], $this->my_class, $userid, "manadamage", $damage);
      else $this->addlog2($this->battle_data["id"], $this->en_class, $userid, "manadamage", $damage);
    } elseif ($effect["effect"]==EXTRAMF) {
      if ($effect["length"]<=1 && !@$strokes[$priem]->eternal) {        
        $this->remeffectmf($userid,$priem, $effect);
        /*if ($strokes[$priem]->mf=="bron") {
          $upd1="bronmin1=bronmin1-$effect[value], bron1=bron1-$effect[value], bronmin2=bronmin2-$effect[value], bron2=bron2-$effect[value], bronmin3=bronmin3-$effect[value], bron3=bron3-$effect[value], bronmin4=bronmin4-$effect[value], bron4=bron4-$effect[value], bronmin5=bronmin5-$effect[value], bron5=bron5-$effect[value]";
        } else {
          $upd1=$strokes[$priem]->mf."=".$strokes[$priem]->mf."-$effect[value]";
        }
        mq("update battleunits set $upd1 ".(@$strokes[$priem]->mf2?", ".$strokes[$priem]->mf2."=".$strokes[$priem]->mf2."-$effect[value2]":"")." where user='$userid' and battle='".$this->battle_data["id"]."'");*/
      }
    } elseif ($effect["effect"]==HEAL) {
      $mhp=$this->userdata[$userid]["maxhp"];
      $heal=geteffectval($effect["value"], $effect["length"], $strokes[$priem]->length);
      $heal=$this->addhp($heal, $userid);
      $newhp=$this->userdata[$userid]["hp"];
      if ($userid==$this->user["id"]) $this->addlog2($this->battle_data["id"], $this->my_class, $userid, "heal", $heal, $newhp, $mhp, $priem);
      else $this->addlog2($this->battle_data["id"], $this->en_class, $userid, "heal", $heal, $newhp, $mhp, $priem);
      //$heal=$newhp-$this->userdata[$userid]["hp"];
      /*if ($userid==$user["id"]) {
        $mhp=$user["maxhp"];
        $newhp=min($user["hp"]+$effect["value"], $mhp);
        addlog2($user['battle'], $this->my_class, $userid, "heal", $effect["value"], $newhp, $user["maxhp"], $priem);
        $effect["value"]=$newhp-$user["hp"];
        $this->addhp($effect["value"], $userid, $user["hp"]);
        $user["hp"]=$newhp;
      } else {
        $newhp=min($this->enemyhar["hp"]+$effect["value"], $this->enemyhar["maxhp"]);
        addlog2($user['battle'], $this->en_class, $userid, "heal", $effect["value"], $newhp, $this->enemyhar["maxhp"], $priem);
        $this->addhp($effect["value"], $userid, $this->enemyhar["hp"]);
        $effect["value"]=$newhp-$this->enemyhar["hp"];
        $this->enemyhar["hp"]=$newhp;
      }*/
      //$this->userdata[$userid]["hp"]=$newhp;
    } elseif ($effect["effect"]==HEALMANA || $effect["effect"]==HEALMANA110) {
      //if ($userid==$user["id"]) $mana=$user["mana"];
      //else $mana=$this->enemyhar["mana"];
      $mana=$this->userdata[$userid]["mana"];
      if ($effect["effect"]==HEALMANA110) $heal=rand(ceil($this->userdata[$userid]["maxmana"]/100),ceil($this->userdata[$userid]["maxmana"]/10));
      else $heal=geteffectval($effect["value"], $effect["length"], $strokes[$priem]->length);
      $mmana=$this->userdata[$userid]["maxmana"];
      $newmana=min($mana+$heal, $mmana);
      if ($userid==$this->user["id"]) $this->addlog2($this->battle_data["id"], $this->my_class, $userid, "healmana", $heal, $newmana, $mmana, $priem);
      else $this->addlog2($this->battle_data["id"], $this->en_class, $userid, "healmana", $heal, $newmana, $mmana, $priem);
      $this->addmana($heal, $userid);
    } elseif ($effect["effect"]==DEFEND) {
      if ($priem=="wis_air_shield07") {
        $defender=$this->getunit($userid,1,0,$enemy);
      } elseif ($priem=="wis_air_shield08") {
        $defender=$this->getunit($userid,1,1,$enemy,$userid);
      } elseif ($priem=="wis_air_shield09") {
        $defender=$this->getunit($userid,0,1,$enemy);
      } elseif ($priem=="wis_air_shield10") {
        $defender=$enemy;
      } else $defender=$effect["caster"];
      $this->defend($userid, $defender, $priem, 1);
      $this->actpriem($priem, 0, $defender, 1, 0);
    }
    if ($effect["effect2"]==HEALMANA) {
      $this->addmana($effect["value2"], $userid);
    } elseif ($effect["effect2"]==EXTRAMF) {
      if ($effect["length"]<=1 && !@$strokes[$priem]->eternal) mq("update battleunits set ".$strokes[$priem]->mf."=".$strokes[$priem]->mf."-$effect[value2] ".(@$strokes[$priem]->mf2?", ".$strokes[$priem]->mf2."=".$strokes[$priem]->mf2."-$effect[value2]":"")." where user='$userid' and battle='".$this->battle_data["id"]."'");
    }
    if (@$strokes[$priem]->eternal || @$strokes[$priem]->noautodec) return;
    if ($this->battleunits[$userid]["effects"][$priem]["length"]<100) $this->battleunits[$userid]["effects"][$priem]["length"]--;
    if ($this->battleunits[$userid]["effects"][$priem]["length"]<=0) {
      if ($effect["effect"]==DELAYEDEFFECT) {
        $this->addeffect($userid, $strokes[$priem]->delayedeffect, @$strokes[$priem]->delayedvalue, 0, "$priem-delayed", array(), 0, 0, @$strokes[$priem]->delayedeffect2, @$strokes[$priem]->delayedvalue2);
        $this->add_log('<span class=date>'.date("H:i").'</span> На персонажа '.$this->lognick($userid).' подействовал эффект "<FONT color=#A00000><b>'.$strokes["$priem-delayed"]->name.'</b></font>".<BR>');
      }
      if (@$strokes[$priem]->effectoncaster) {
        $this->remeffect($userid, $priem, $effect);
        $this->logstrokeend($priem, $userid);
      } elseif ($effect["effect"]!=DELAYEDDAMAGE && $effect["effect"]!=IMMUNITY) {
        $this->toupdatebu[$userid]["unseteffects"][]=$priem;
      } else {
        unset($this->battleunits[$userid]["effects"][$priem]);
      }
      //$this->logstrokeend($priem);
    }
    $this->toupdatebu[$userid]["effects"]=1;
    $this->needupdatebu=1;
  }
  
  function addextramf1($bu) {
    if ($bu["intel"]>=125) $bu["mfmagp"]+=35;
    elseif ($bu["intel"]>=100) $bu["mfmagp"]+=25;
    elseif ($bu["intel"]>=75) $bu["mfmagp"]+=17;
    elseif ($bu["intel"]>=50) $bu["mfmagp"]+=10;
    elseif ($bu["intel"]>=25) $bu["mfmagp"]+=5;
    return $bu;
  }

  function userclass($id) {
    if (in_array ($id,$this->t1)) return "B1"; else return "B2";
  }

  function checkmagmiss($user) {
    if ($this->battleunits[$user]["additdata"]["magmiss"]>0) {
      $this->battleunits[$user]["additdata"]["magmiss"]--;
      $this->needupdateaddit[$user]=1;
      return 0;
    } else {
      $this->battleunits[$user]["additdata"]["magmiss"]=2;
      $this->needupdateaddit[$user]=1;        
      return 1;
    }
  }

  function updateaddit() {
    foreach ($this->needupdateaddit as $k=>$v) {
      $f=fopen(CHATROOT."bus/$k.dat", "wb+");
      fwrite($f, serialize($this->battleunits[$k]["additdata"]));
      fclose($f);
    }
    $this->needupdateaddit=array();
  }

  function getadditdata($id) {
    $this->getbu($id);
    if (!isset($this->battleunits[$id]["additdata"])) {
      $dat=implode("",file(CHATROOT."bus/$id.dat"));
      $this->battleunits[$id]["additdata"]=unserialize($dat);
    }
  }
  
  function getbu($id) {
    global $user, $strokes, $newbus, $caverooms, $leveldefs, $strokebots;
    static $processing, $botcache;
    if (!@$botcache) $botcache=array();
    if (!@$processing) $processing=array();
    if (@$processing[$id]) return;
    if (!$id || $this->status==0) return;
    if (@$this->battleunits[$id]) return;
    $bu=mqfa("select * from battleunits where user='$id' and battle='".$this->battle_data["id"]."'");
    if (!$bu && $id>_BOTSEPARATOR_ && count($botcache)>0) {
      $bot=mqfa("select prototype, name from bots where id='$id'");
      if (@$botcache[$bot["prototype"]]) {
        mq("insert into battleunits set user='$id', ".$botcache[$bot["prototype"]]["sql"]);
        $this->userdata[$id]=$this->userdata[$botcache[$bot["prototype"]]["user"]];
        $this->userdata[$id]["login"]=$bot["name"];
        $setaddit=$botcache[$bot["prototype"]]["additdata"];
        $bu=mqfa("select * from battleunits where user='$id' and battle='".$this->battle_data["id"]."'");
      }
    }

    if ($bu) {
      if($bu["effects"]) $bu["effects"]=unserialize($bu["effects"]);
      else $bu["effects"]=array();
      if($bu["extra"]) $bu["extra"]=unserialize($bu["extra"]);
      else $bu["extra"]=array();
      if($bu["priems"]) {      
        $bu["priems"]=unserialize($bu["priems"]);
      } else $bu["priems"]=array();
      $this->battleunits[$id]=$bu;

      $this->battleunits[$id]["minimax"]=unserialize($this->battleunits[$id]["weapondata"]);
      $this->battleunits[$id]["minimax1"]=unserialize($this->battleunits[$id]["weapondata2"]);
      $extrad=$this->effectval($id, INCWEAPDAMAGE);
      if ($extrad) {
        $this->battleunits[$id]["maxu"]+=$extrad;
        if ($this->battleunits[$id]["minimax"]["maxu"]) $this->battleunits[$id]["minimax"]["maxu"]+=$extrad;
        if ($this->battleunits[$id]["minimax1"]["maxu"]) {
          $this->battleunits[$id]["maxu"]+=$extrad;
          $this->battleunits[$id]["minimax1"]["maxu"]+=$extrad;
        }
      }
      $this->battleunits[$id]["scrolls"]=unserialize($this->battleunits[$id]["scrolls"]);
      $this->addextramf($id);
      if (@$setaddit) {
        $this->battleunits[$id]["additdata"]=$setaddit;
        $this->needupdateaddit[$id]=1;
      } else {
        $dat=implode("",file(CHATROOT."bus/$id.dat"));
        $this->battleunits[$id]["additdata"]=unserialize($dat);
      }
      return;
    }
    $processing[$id]=1;
    //$leveldefs=array(0, 0, 0, 0, 0, 10, 15, 70, 150, 200, 300, 500, 600, 700, 800);
    $sql="";
    $xpbonus=0;
    global $dressslots;
    $usr=mqfa("select users.*, userdata.sila as b_sila, userdata.lovk as b_lovk, userdata.inta as b_inta, userdata.intel as b_intel, userdata.mudra as b_mudra
    from users left join userdata on users.id=userdata.id where users.id='".bottouser($id)."'");

    if ($id==$user["id"]) $usr["data"]=$user["data"];
    elseif ($id<_BOTSEPARATOR_ && ($usr["hp"]<$usr["maxhp"] || $usr["mana"]<$usr["maxmana"])) 
    $usr["data"]=getudata($id);

    if ($this->battle_data["type"]==4) {
      $usr["weap"]=0;
      $usr["shit"]=0;
    }

    $usr["id"]=$id;
    $usr["hp"]=regenhp($usr);
    $prototype=$id;
    if ($id>_BOTSEPARATOR_) {
      $tmp=mqfa("select name, prototype, hp from bots where id='$id'");
      $usr["login"]=$tmp["name"];
      if (strpos($tmp["name"], "Отморозок")===0) $usr["shadow"]="hell-raiser.gif";
      $prototype=$tmp["prototype"];
      $usr["hp"]=$tmp["hp"];
    } elseif ($this->battle_data["type"]==4) {
      $usr1=basestats($id);
      if ($usr["hp"]>$usr1["maxhp"]) $this->userdata[$id]["extrahp"]=$usr["hp"]-$usr1["maxhp"];
      if ($usr["mana"]>$usr1["maxmana"]) $this->userdata[$id]["extramana"]=$usr["mana"]-$usr1["maxmana"];
      foreach ($usr1 as $k=>$v) $usr[$k]=$v;
    }
    

    $sql="";
    getfeatures($usr);
    $expbonus+=$usr["smart"];

    $additdata=array("hit"=>0, "krit"=>0, "counter"=>0, "block2"=>0, "parry"=>0, "hp2"=>0);

    if ($this->battle_data["type"]!=4) {
      $cond="";
      foreach ($dressslots as $k=>$v) $cond.=" or id=$usr[$v]";
      $dress=mqfa('SELECT sum(ghp) as ghp, sum(minu) as minu, sum(maxu) as maxu, sum(mfkrit) as mfkrit, sum(mfakrit) as mfakrit, sum(mfuvorot) as mfuvorot, sum(mfauvorot) as mfauvorot, sum(bron1) as bron1, sum(bron2) as bron2, sum(bron2) as bron3, sum(bron3) as bron4, sum(bron4) as bron5, sum(bronmin1) as bronmin1, sum(bronmin2) as bronmin2, sum(bronmin2) as bronmin3, sum(bronmin3) as bronmin4, sum(bronmin4) as bronmin5, sum(mfkritpow) as mfkritpow, sum(mfantikritpow) as mfantikritpow, sum(mfparir) as mfparir, sum(mfshieldblock) as mfshieldblock, sum(mfcontr) as mfcontr, sum(mfdhit) as mfdhit, sum(mfdkol) as mfdkol, sum(mfdrub) as mfdrub, sum(mfdrej) as mfdrej, sum(mfddrob) as mfddrob, sum(mfhitp) as mfhitp, sum(mfmagp) as mfmagp, sum(mffire) as mffire, sum(mfwater) as mfwater, sum(mfair) as mfair, sum(mfearth) as mfearth, sum(mflight) as mflight, sum(mfdark) as mfdark, sum(mfkol) as mfkol, sum(mfrej) as mfrej, sum(mfrub) as mfrub, sum(mfdrob) as mfdrob, sum(mfproboj) as mfproboj, sum(mfdmag) as mfdmag, sum(mfdfire) as mfdfire, sum(mfdwater) as mfdwater, sum(mfdair) as mfdair, sum(mfdearth) as mfdearth, sum(mfdlight) as mfdlight, sum(mfddark) as mfddark, sum(minusmfdmag) as minusmfdmag, sum(minusmfdfire) as minusmfdfire, sum(minusmfdair) as minusmfdair, sum(minusmfdwater) as minusmfdwater, sum(minusmfdearth) as minusmfdearth, sum(blockzones) as blockzones, sum(manausage) as manausage, sum((type<>3)*second) as casts 
      , sum(gsila) as gsila, sum(glovk) as glovk, sum(ginta) as ginta, sum(gintel) as gintel, sum(cost)+(sum(ecost)*10) as cost, sum(cost) as cost2,
      sum(type=10) as hasshield
      from `inventory` WHERE (`dressed`=1 and type<>25 AND `owner` = \''.$prototype.'\')'.$cond);
      $r=mq("select magic from inventory where ((dressed=1 and type<>25 and owner=".$prototype.") $cond) and magic>60 and magic<=90 ");
      if (mysql_num_rows($r)>0) $additdata["magics"]=array();
      while ($rec=mysql_fetch_assoc($r)) {
        $mag=magicinf($rec["magic"]);
        $tmp=explode("/",$mag["file"]);
        $additdata["magics"][]=array("magic"=>$rec["magic"], "from"=>$tmp[0], "to"=>$tmp[1], "prof"=>$tmp[2], "chance"=>$mag["chanse"]);
      }
      if ($usr["level"]>6) {
        $dress["bron1"]*=($usr["level"]-6)*0.2+1;
        $dress["bron2"]*=($usr["level"]-6)*0.2+1;
        $dress["bron3"]*=($usr["level"]-6)*0.2+1;
        $dress["bron4"]*=($usr["level"]-6)*0.2+1;
        $dress["bron5"]*=($usr["level"]-6)*0.2+1;
      }
    }

    if ($id>_BOTSEPARATOR_) {
      if (strpos($tmp["name"], "Отморозок")===0) {
      } else {
        $dress["cost"]=0; 
        $dress["cost2"]=0;
      }
    }

    $dress["mfdhit"]+=$leveldefs[$usr["level"]];
    $dress["mfdmag"]+=$leveldefs[$usr["level"]];

    if ($this->battle_data["type"]==UNLIMCHAOS && $usr["level"]>9) $dress["mfhitp"]-=($usr["level"]-9)*12;

    include "config/questbots.php";
    if (@$questbots[$prototype] && USERBATTLE) {
      $cond="";
      if ($questbots[$prototype]["quest2"]) $cond.=" or quest='".$questbots[$prototype]["quest2"]."'";
      if ($questbots[$prototype]["quest3"]) $cond.=" or quest='".$questbots[$prototype]["quest3"]."'";
      if ($questbots[$prototype]["quest4"]) $cond.=" or quest='".$questbots[$prototype]["quest4"]."'";
      $s=mqfa1("select sum(step) from quests where user='$user[id]' and (quest='".$questbots[$prototype]["quest"]."' $cond)")-mqfa1("select step from quests where user='$user[id]' and quest='".$questbots[$prototype]["questlose"]."'");
      $s*=ceil($user["level"]/$questbots[$prototype]["levelsperstat"]);
      $i=0;
      while ($i<$s) {
        $i++;
        $r=rand(1,4);
        if ($r==1) $usr["sila"]++;
        if ($r==2) $usr["lovk"]++;
        if ($r==3) $usr["inta"]++;
        if ($r==4) $usr["vinos"]++;
      }
      //$usr["hp"]=$usr["hp"];
      $usr["maxhp"]=questbothp();
    } elseif ($user["room"]==302 && $id>_BOTSEPARATOR_) {
      $level=mqfa1("select level from caves where leader='$user[caveleader]'");
      $usr["sila"]=round($usr["sila"]*$level/10);
      $usr["lovk"]=round($usr["lovk"]*$level/10);
      $usr["inta"]=round($usr["inta"]*$level/10);
      $usr["vinos"]=round($usr["vinos"]*$level/10);
    } elseif (in_array($user["room"], $caverooms) && $id>_BOTSEPARATOR_ && USERBATTLE) {
      include "config/cavedata.php";

      $level=mqfa1("select level from caves where leader='$user[caveleader]'");
      $mult=pow(1+(0.05*$cavedata[$user["room"]]["difficulty"]), $level);
      $dress["mfhitp"]+=round($usr["sila"]*$mult);
      $dress["mfuvorot"]+=round($usr["lovk"]*5*$mult);
      $dress["mfauvorot"]+=round($usr["lovk"]*5*$mult);
      $dress["mfkrit"]+=round($usr["inta"]*5*$mult);
      $dress["mfakrit"]+=round($usr["inta"]*5*$mult);
      $dress["mfdhit"]+=round($usr["vinos"]*1.5*$mult);
      $dress["mfdmag"]+=round($usr["vinos"]*1.5*$mult);
    }

    //if ($id<_BOTSEPARATOR_) 
    $dress["mfdmag"]+=$usr["vinos"]*1.5;
    $dress["mfdhit"]+=$usr["vinos"]*1.5;
    if ($usr["vinos"]>=125) $dress["mfdhit"]+=25;

    //$dress["mfantikritpow"]+=ceil($usr["vinos"]/2);
    
    
    if ($dress["casts"]>0) $dress["casts"]=$dress["casts"]*10+$dress["casts"];

    $defs=array("mfdhit1"=>0,"mfdhit2"=>0,"mfdhit3"=>0,"mfdhit4"=>0,"mfdhit5"=>0);
    if ($this->battle_data["type"]!=4 && $usr["helm"]+$usr["bron"]+$usr["leg"]+$usr["boots"]>0) {
      $r=mq("select id, mfdhit from inventory where id='$usr[helm]' or id='$usr[bron]' or id='$usr[leg]' or id='$usr[boots]'");
      while ($rec=mysql_fetch_assoc($r)) {
        $dress["mfdhit"]-=$rec["mfdhit"];
        if ($rec["id"]==$usr["helm"]) $defs["mfdhit1"]+=$rec["mfdhit"];
        if ($rec["id"]==$usr["bron"]) {
          $defs["mfdhit2"]+=$rec["mfdhit"];
          $defs["mfdhit3"]+=$rec["mfdhit"];
        }
        if ($rec["id"]==$usr["leg"]) $defs["mfdhit4"]+=$rec["mfdhit"];
        if ($rec["id"]==$usr["boots"]) $defs["mfdhit5"]+=$rec["mfdhit"];
      }
      foreach ($defs as $k=>$v) $dress[$k]=$v;
    }

    if ($id==4778) foreach ($dress as $k=>$v) $dress[$k]=$dress[$k]/2;
    $effects=array();
    if (incastle($usr["room"]) && 0) {
      $effects["castlebonus"]["img"]=IMGBASE."/i/misc/icon_castlebonus";
      $effects["castlebonus"]["type"]=1;
      $effects["castlebonus"]["effect"]=DAMAGEMULT;
      $effects["castlebonus"]["value"]=55;
      $dress["mfhitp"]+=55;
      $dress["mfmagp"]+=55;
    }
    if ($usr["zver_id"] && $id<_BOTSEPARATOR_ && !incommontower($usr)) {
      $rec=mqfa("select level, vid, sitost, login, sex from users where id='$usr[zver_id]'");
      if ($rec["sitost"]>0 && $rec["vid"]) {
        if ($rec["vid"]==1) {
          $usr["sila"]+=$rec["level"];
          $dress["gsila"]+=$rec["level"];
          $effname="Демоническая Сила";
          $effresult="Сила +$rec[level]";
        }
        if ($rec["vid"]==2) {
          $usr["lovk"]+=$rec["level"];
          $dress["glovk"]+=$rec["level"];
          $effname="Кошачья Ловкость";
          $effresult="Ловкость +$rec[level]";
        }
        if ($rec["vid"]==3) {
          $usr["inta"]+=$rec["level"];
          $dress["ginta"]+=$rec["level"];
          $effname="Интуиция Совы";
          $effresult="Интуиция +$rec[level]";
        }
        if ($rec["vid"]==4) {
          $usr["bron1"]+=$rec["level"]*2;
          $usr["bron2"]+=$rec["level"]*2;
          $usr["bron3"]+=$rec["level"]*2;
          $usr["bron4"]+=$rec["level"]*2;
          $usr["bron5"]+=$rec["level"]*2;
          $effname="Свинцовый Щит";
          $effresult="Броня головы: +".($rec["level"]*2).", Броня корпуса: +".($rec["level"]*2).", Броня пояса: +".($rec["level"]*2).", Броня ног: +".($rec["level"]*2);
        }
        if ($rec["vid"]==5) {
          $this->userdata[$id]["hp"]=$usr["hp"];
          $this->userdata[$id]["login"]=$usr["login"];
          $this->userdata[$id]["mana"]=$usr["mana"];
          $this->userdata[$id]["maxhp"]=$usr["maxhp"];
          $this->userdata[$id]["maxmana"]=$usr["maxmana"];

          $maxhp=$dress["ghp"]+$usr["vinos"]*(6+mqfa1("select sum(hpforvinos) from effects where owner='$id'"));
          if ($usr["vinos"]>=125) $maxhp+=250;
          elseif ($usr["vinos"]>=100) $maxhp+=250;
          elseif ($usr["vinos"]>=75) $maxhp+=175;
          elseif ($usr["vinos"]>=50) $maxhp+=100;
          elseif ($usr["vinos"]>=25) $maxhp+=50;
          $maxhp+=30+mqfa1("select sum(ghp) from effects where owner='$id'");
          $maxhp+=$rec["level"]*6;
          $this->userdata[$id]["maxhp"]=$maxhp;
          if ($rec["level"]>0) {
            mq("update users set hp=if(hp+".($rec["level"]*6).">$maxhp,$maxhp,hp+".($rec["level"]*6)."), maxhp=$maxhp where id='$id'");
            $usr["maxhp"]=$maxhp;
            $usr["hp"]=min($usr["hp"]+$rec["level"]*6,$maxhp);
            $effresult="";
            if ($id==$user["id"]) $user["hp"]=$usr["hp"];
          }
          $effresult="Уровень жизни (HP) +".($rec["level"]*6);
          $effname="Верный Друг";
        }
        if ($rec["vid"]==6) {
          $dress["mfmagp"]+=$rec["level"];
          if ($rec["level"]>5) $dress["mfmagp"]+=$rec["level"]-5;
          $effresult="Мф. мощности магии стихий: +".($rec["level"]+max(0, $rec["level"]-5));
          $effname="Сила Стихий";
        }
        if ($rec["level"]>0) {
          $effects["$rec[id]"]["img"]=IMGBASE."/i/misc/pet$rec[vid].gif";
          $effects["$rec[id]"]["name"]="<b>$effname [$rec[level]]</b> (эффект)<br>".str_replace(",","<br>",$effresult);
          $effects["$rec[id]"]["type"]=1;
          if ($rec["sex"]==1) $a=""; else $a="а";
          $this->add_log("<span class=date>".date("H:i")."</span> ".($usr["invis"]?"<span class=\"".$this->userclass($id)."\">зверь невидимки</span>":"<span class=\"".$this->userclass($id)."\">$rec[login] (зверь $usr[login])")."</span> призвал$a заклятие <font color=#A00000><b>$effname [$rec[level]]</b></font> на <span class=\"".$this->my_class."\">".($usr["invis"]?"невидимка":"$usr[login]")."</span>. ($effresult)<BR>");
        }
      }
    }
   
    $zo=0;
    $r=mq('SELECT * FROM `effects` WHERE `owner` = '.$id.' and (mfval<>\'\' or ghp<>0 or gmana<>0 or type=31 or type=32 or type=11 or type=12 or type=13 or type=14 or `type`=187 or `type`=185 or `type`=188 or `type`=201 or `type`=202 or `type`=1022 or type='.PROTFROMATTACK.')');
    $effs=array();
    while($rec=mysql_fetch_array($r)){
      if ($rec["type"]==PROTFROMATTACK) {
        mq("delete from effects where id='$rec[id]'");
        continue;
      }
      if ($rec["type"]==11 || $rec["type"]==12 || $rec["type"]==13 || $rec["type"]==14) {
        $dress["gsila"]-=$rec["sila"];
        $dress["glovk"]-=$rec["lovk"];
        $dress["ginta"]-=$rec["inta"];
        $dress["gintel"]-=$rec["intel"];
        continue;
      }
      $dress["gsila"]+=$rec["sila"];
      $dress["glovk"]+=$rec["lovk"];
      $dress["ginta"]+=$rec["inta"];
      $dress["gintel"]+=$rec["intel"];
      $dress["gmudra"]+=$rec["mudra"];

      if ($rec["type"]==201) $zo=1;
      if ($rec["type"]==202) $sokr=1;
      if ($rec["mfdmag"]) $effs["mfdmag"]+=$rec["mfdmag"];
      if ($rec["mfdfire"]) $effs["mfdfire"]+=$rec["mfdfire"];
      if ($rec["mfdwater"]) $effs["mfdwater"]+=$rec["mfdwater"];
      if ($rec["mfdair"]) $effs["mfdair"]+=$rec["mfdair"];
      if ($rec["mfdearth"]) $effs["mfdearth"]+=$rec["mfdearth"];
      if ($rec["mfdhit"]) $effs["mfdhit"]+=$rec["mfdhit"];
      if ($rec["mfdkol"]) $effs["mfdkol"]+=$rec["mfdkol"];
      if ($rec["mfdrub"]) $effs["mfdrub"]+=$rec["mfdrub"];
      if ($rec["mfdrej"]) $effs["mfdrej"]+=$rec["mfdrej"];
      if ($rec["mfddrob"]) $effs["mfddrob"]+=$rec["mfddrob"];
      if ($rec["mf"]) {
        //$effs[$rec["mf"]]+=$rec["mfval"];
        $tmp=explode("/", $rec["mf"]);
        $tmp2=explode("/", $rec["mfval"]);
        foreach ($tmp as $k=>$v) {
          $effs[$v]+=$tmp2[$k];
        }
      }
      if ($rec["type"]==31) continue;
      $i++;
      list($left, $top)=effectpos($i);
      $effect=effectdata($rec);

      /*if($rec['type']==395){$opp='награда'; $chas=60; $chastxt="час.";}
      elseif($rec['type']==201){$opp='заклятие'; $chas=1; $chastxt="мин.";}
      elseif($rec['type']==202){$opp='заклятие'; $chas=1; $chastxt="мин.";}
      elseif($rec['type']==1022){$opp='заклятие'; $chas=1; $chastxt="мин.";}
      elseif ($rec['type']==187) {
        $opp='заклятие'; $chas=1; $chastxt="мин.";
      } elseif ($rec["type"]==ADDICTIONEFFECT) {
        $opp='эффект'; $chas=1; $chastxt="мин.";
      } else {
        $opp='эликсир'; $chas=1; $chastxt="мин.";
      }*/
      $effects["$rec[id]"]["img"]=IMGBASE."/i/misc/icon_$effect[img]";
      $effects["$rec[id]"]["name"]="<b>$rec[name]</b> ($effect[type])".($effect["mfs"]?"<div>&nbsp;</div>$effect[mfs]":"");
      $effects["$rec[id]"]["type"]=1;
    }


    if ($id<_BOTSEPARATOR_ && !incommontower($usr)) {
      getadditdata($usr);
      if ($usr["b_sila"]+$dress["gsila"]!=$usr["sila"] || $usr["b_lovk"]+$dress["glovk"]!=$usr["lovk"] || $usr["b_inta"]+$dress["ginta"]!=$usr["inta"]
      || $usr["b_intel"]+$dress["gintel"]!=$usr["intel"] || $usr["b_mudra"]+$dress["gmudra"]!=$usr["mudra"]) {
        $rec=mqfa("select id from errorstats where user='$id'");
        if (!$rec) mq("insert into errorstats set user='$id', reason='Battle: ".$this->battle_data["id"]." $usr[b_sila]+$dress[gsila]/$usr[sila], $usr[b_lovk]+$dress[glovk]/$usr[lovk], $usr[b_inta]+$dress[ginta]/$usr[inta], $usr[b_intel]+$dress[gintel]/$usr[intel], $usr[b_mudra]+$dress[gmudra]/$usr[mudra]'");
      }
    }

    //$zo=mqfa1("SELECT id FROM effects WHERE type=201 AND owner=$id and time>".time());
    if ($zo) $dress["mfdhit"]+=100;
    //$sokr=mqfa1("SELECT id FROM effects WHERE type=202 AND owner=$id and time>".time());
    if ($sokr) $dress["power"]+=25;
    //if ($sokr) $dress["mfhitp"]+=25;
    //$effs=mqfa("select sum(mfdmag) as mfdmag, sum(mfdhit) as mfdhit from effects where owner='".$id."' and time>".time());
    foreach ($effs as $k=>$v) $dress["$k"]+=$v;
    if ($this->battle_data["type"]!=4) {
      //$cost=mqfa1("select SUM(cost)+(SUM(ecost)*10) FROM inventory WHERE owner = ".$prototype." AND dressed=1");
      $cost=$usr["level"]*100+$dress["cost"];
    } else $cost=$usr["level"]*100;
    $tmp=$this->getpersout($id, 0, $usr["sila"], $usr["lovk"], $usr["inta"], $usr["vinos"], $usr["intel"], $usr);
    $po0=$tmp[0];
    if ($id<_BOTSEPARATOR_) $po1=$tmp[1];
    else $po1="";
    //$po0=$this->getpersout($id, 0, $usr["sila"], $usr["lovk"], $usr["inta"], $usr["vinos"], $usr["intel"], $usr);
    //if ($id<_BOTSEPARATOR_) $po1=$this->getpersout($id, 1);
    //else $po1="";
    //$weapons=mqfa1('SELECT count(id) FROM `inventory` WHERE (`type` = 3 or (type<>3 and dvur=1))  AND `dressed` = 1 AND `owner` = '.$prototype);
    //if ($weapons<1) $weapons=1;
    //$hasshield=mqfa1("SELECT id FROM `inventory` where  id='$usr[shit]' and `type` = 10");
    
    if ($dress["hasshield"]) {
      if ($dress["blockzones"]>0) $dress["blockzones"]=3;
      else $dress["blockzones"]=2;
    } elseif ($usr["weap"]) {
      if ($dress["blockzones"]==4 || ($dress["blockzones"]==3 && !$usr["shit"])) $dress["blockzones"]=3;
      elseif ($dress["blockzones"]>0) $dress["blockzones"]=2;
      else $dress["blockzones"]=1;
    } elseif (!$usr["weap"] && !$usr["shit"]) $dress["blockzones"]=2;

    if ($usr["weap"]) $weapons=1;

    if ($this->battle_data["type"]!=4) {
      if($id>_BOTSEPARATOR_) {
        include_once "config/botdata.php";
        if ($botdata[$prototype]) {
          $wd=$botdata[$prototype]["wd"];
          $dress["minu"]+=$wd["minu"];
          $dress["maxu"]+=$wd["maxu"];
          if ($botdata[$prototype]["wd2"]) {
            $wd2=$botdata[$prototype]["wd2"];
            $weapons=2;
            $dress["minu"]+=$wd2["minu"];
            $dress["maxu"]+=$wd2["maxu"];
          } else {
            $wd2=array("minu"=>0, "maxu"=>0, "mfproboj"=>0);
            $weapons=1;
          }
        }
      }
      if (!$wd) {
        if ($usr["weap"]) $wd=mqfa("select minu, maxu, dvur, mfproboj, otdel, chrub, chrej, chkol, chdrob, chmag, mfhitp, mfkol, mfrub, mfrej, mfdrob, mfkritpow, gnoj, gtopor, gmech, gdubina, gsila, glovk, ginta, gintel from inventory where id='".$usr["weap"]."'"); else $wd=0;
        if (!$wd) $wd=array("chdrob"=>90, "chkol"=>10);
        $dvur=$wd["dvur"];
        unset($wd["dvur"]);
        if ($usr["shit"]) $wd2=mqfa("select minu, maxu, mfproboj, otdel, chrub, chrej, chkol, chdrob, chmag, mfhitp, mfkol, mfrub, mfrej, mfdrob, mfkritpow, gnoj, gtopor, gmech, gdubina, gsila, glovk, ginta, gintel from inventory where id='".$usr["shit"]."'");
        $wd["weptype"]=$this->otdeltoweptype($wd["otdel"]);
        unset($wd["otdel"]);
        $wd2["weptype"]=$this->otdeltoweptype($wd2["otdel"]);
        unset($wd2["otdel"]);
        if ($wd2["weptype"]=="kulak") $wd2=array("minu"=>0, "maxu"=>0, "mfproboj"=>0);
        else $weapons++;
        if (!$weapons) $weapons=1;
        $weapons2=mqfa1('SELECT count(id) FROM `inventory` WHERE (`type` = 3 or (type<>3 and dvur=1))  AND `dressed` = 1 AND `owner` = '.$prototype);
        if ($weapons2>$weapons) {
          $weapons=$weapons2;
          if ($wd2["minu"]==0 && $wd2["maxu"]==0) {
            $wd["minu"]=0;
            $wd["maxu"]=0;
            $wd["mfproboj"]=0;
            $wd["mfhitp"]=0;
            $wd["mfkol"]=0;
            $wd["mfrub"]=0;
            $wd["mfrej"]=0;
            $wd["mfdrob"]=0;
            $wd["mfkritpow"]=0;
            $wd["gnoj"]=0;
            $wd["gmech"]=0;
            $wd["gdubina"]=0;
            $wd["gtopor"]=0;
            $wd2=$wd;
          }
        }
      }
    } else {
      $wd=array("minu"=>0, "maxu"=>0, "mfproboj"=>0);
      $wd2=array("minu"=>0, "maxu"=>0, "mfproboj"=>0);
      $weapons=1;
    }

    $upd="";
    if ($usr["hp"]>$usr["maxhp"]) {
      $usr["hp"]=$usr["maxhp"];
      if ($id==$user["id"]) $user["hp"]=$usr["hp"];
      $upd="hp='$usr[hp]'";
    }
    if ($usr["mana"]>$usr["maxmana"]) {
      $usr["mana"]=$usr["maxmana"];
      if ($id==$user["id"]) $user["mana"]=$usr["mana"];
      if ($upd) $upd.=", ";
      $upd.="mana='$usr[mana]'";
    }

    if ($upd) mq("update users set $upd where id='$id'");

    if ($id<_BOTSEPARATOR_ || @$strokebots[$prototype]) {
      if ($usr["level"]>=10) $md=40;
      elseif ($usr["level"]>=9) $md=30;
      elseif ($usr["level"]>=8) $md=20;
      else $md=10;
      $md+=$usr["spirit"];
      $sduh=floor($usr['hp']/$usr['maxhp']*100*$md);
      //mq("update users set ".(!inbattletower($usr)?"s_duh=$sduh,":"")." hp2=0, hp3=0, hit=0, krit=0, counter=0, block2=0, parry=0, udar=0 where id='$id'");
      if ($id==$user["id"]) {
        //if (!inbattletower($usr)) $user["s_duh"]=$sduh;
        $user["hp2"]=0;$user["hp3"]=0;$user["hit"]=0;$user["krit"]=0;$user["counter"]=0;
        $user["block2"]=0;$user["parry"]=0;$user["udar"]=0;
      }
    }
    $additdata["s_duh"]=$sduh;
    if ($usr["mana"]>$usr["maxmana"]) {
      $usr["mana"]=$usr["maxmana"];
      mq("update users set mana='$usr[mana]' where id='$id'");
    }
    //создание userdata
    $this->makeuserdata($id, $usr, $weapons);

    //$r=mq("select slot,id_thing from puton where id_person='$id' and slot>=201 and slot<=210;");
    //while ($rec=mysql_fetch_array($r)) $dress["slot".($rec["slot"]-200)]=$rec["id_thing"];
    $priems=array();
    $puton=array();
    $puton2=array();
    if ($id<_BOTSEPARATOR_) {
      $r=mq("select slot, id_thing from puton where id_person='".$id."' and slot>=201 and slot<=220;");
      while ($rec=mysql_fetch_assoc($r)) {
        $puton[]=$rec;
        $puton2[$rec["slot"]]=$rec["id_thing"];
      }
      if (count($puton)==0) {
        $puton=array(array( "slot"=> 202, "id_thing"=>158), array ("slot"=>203, "id_thing"=>159), array("slot"=>201, "id_thing"=>164)) ;
        $puton2[202]=158;
        $puton2[203]=159;
        $puton2[201]=164;
      }      
      
      for ($i=201;$i<=220;$i++) {
        $p=&$puton2[$i];
        if ($p) {
          if ($this->battle_data["type"]==UNLIMCHAOS) {
            $previd=$puton2[$i];
            $pr=$strokes["ids"][$puton2[$i]];
            if (!strpos($pr, "100")) {
              $pr=str_replace("10", "09", $pr);
              $pr=str_replace("11", "09", $pr);
              $puton2[$i]=$strokes[$pr]->id_priem;
              if ($puton[$i]!=$previd) {
                foreach ($puton as $k=>$v) {
                  if ($v["id_thing"]==$previd) $puton[$k]["id_thing"]=$puton2[$i];
                }
              }
            }
            $p2=new prieminfo(0, $pr);
          } else $p2=new prieminfo($puton2[$i],0);

          $priems[$p2->priem]=array("id_person"=>$id, "id_paladin`"=>$id, "timestamp"=>time(), "type"=>3, "timestamp2"=>time(), 
          "comment"=>"", "pr_name"=>$p2->priem, "active"=>1,
          "wait"=>(@$strokes[$p2->priem]->startwait?$strokes[$p2->priem]->startwait:0), "uses"=>1, "pr_target"=>$p2->target);
        }
      }
    } else {
      global $strokebots;
      if (@$strokebots[$prototype]) {
        foreach ($strokebots[$prototype] as $k=>$v) {
          $priems[$v]=array(
            "pr_name"=>$v,
            "active"=>1,
            "wait"=>(@$strokes[$v]->startwait?$strokes[$v]->startwait:0), 
            "uses"=>1
          );
        }
      }
    }
    
    
    $extra=array();
    $e=mqfa1("SELECT id FROM `effects` WHERE `owner` = '$id' AND `type` = '400' AND `isp`='0'");
    if ($e) $extra["ele"]=1;    
    $p1="";
    $p2="";
    if ($this->battle_data["type"]!=4 && ($usr["p1"] || $usr["p2"])) {
      $r=mq("select id, name, img, prototype from inventory where id='$usr[p1]' or id='$usr[p2]'");
      while ($rec=mysql_fetch_assoc($r)) {
        if ($rec["id"]==$usr["p1"]) $p1=serialize($rec);
        else $p2=serialize($rec);
      }
    }
    $cond="";
    if (in_array($id,$this->t1)) $t=$this->t1;
    else $t=$this->t2;
    foreach ($t as $k=>$v) {
      if ($cond) $cond.=" or ";
      $cond.=" user='$v' ";
    }

    $mp=mqfa1("select max(level*100+cost) from battleunits where battle='".$this->battle_data["id"]."' and ($cond) ");
    if ($mp<$cost) mq("update battle set leader".(in_array($id,$this->t1)?"1":"2")."='$id' where id='".$this->battle_data["id"]."'");
    $this->battle_data["leader".(in_array($id,$this->t1)?"1":"2")]=$id;
    foreach ($dress as $k=>$v) if ($k!="ghp" && $k!="gsila" && $k!="glovk" && $k!="ginta" && $k!="gintel" && $k!="gmudra") $sql.=", $k='$v'";
    $sql="battle='".$this->battle_data["id"]."', persout0='".addslashesa($po0)."',
    persout1='".addslashesa($po1)."', weapons='$weapons',
    sila='$usr[sila]', lovk='$usr[lovk]', inta='$usr[inta]', vinos='$usr[vinos]', intel='$usr[intel]', mudra='$usr[mudra]', spirit='$usr[spirit]',
    noj='$usr[noj]', mech='$usr[mec]', topor='$usr[topor]', dubina='$usr[dubina]', posoh='$usr[posoh]', luk='$usr[luk]',
    mfire='$usr[mfire]', mwater='$usr[mwater]', mair='$usr[mair]', mearth='$usr[mearth]', mlight='$usr[mlight]', mdark='$usr[mdark]', mgray='$usr[mgray]',
    zver_id='$usr[zver_id]', dvur='$dvur', changes=3, resurrect=".($usr["spirit"]>=50?1:0).", sex='$usr[sex]', invis='$usr[invis]', level='$usr[level]',
    room='$usr[room]', weapondata='".serialize($wd)."', weapondata2='".serialize($wd2)."', 
    puton='".serialize($puton)."', effects='".serialize($effects)."', extra='".serialize($extra)."', 
    priems='".serialize($priems)."', expbonus='$expbonus', p1='$p1', p2='$p2', prototype='".$prototype."' 
    $sql";
    if ($id > _BOTSEPARATOR_)
    $botcache[$prototype]=array("sql"=>$sql, "user"=>$id, "additdata"=>$additdata);
    mq("insert into battleunits set user='$id', $sql");

    if ($usr["invis"]) mq("insert into invisbattles set user='$id', battle='".$this->battle_data["id"]."'");
    $newbus[]=mysql_insert_id();
    //mq("insert into archive.battleunits (select * from battleunits where id='$v')");
    $this->battleunits[$id]=mqfa("select * from battleunits where user='$id' and battle='".$this->battle_data["id"]."'");
    //$f=fopen(CHATROOT."bus/$id.dat","wb+");
    //fwrite($f, serialize($additdata));
    //fclose($f);
    $this->needupdateaddit[$id]=1;
    $this->battleunits[$id]["additdata"]=$additdata;
    $this->battleunits[$id]["minimax"]=$wd;
    $this->battleunits[$id]["minimax1"]=$wd2;
    $this->battleunits[$id]["effects"]=$effects;
    $this->battleunits[$id]["extra"]=$extra;
    $this->battleunits[$id]["priems"]=$priems;
    $this->addextramf($id);
    unset($processing[$id]);
  }

  function getforcefield($i) {
    return $this->battleunits[$i]["forcefield"];
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

  function getmagicbarrier($i) {
    global $strokes;

    if ($this->battleunits[$i]["manabarrier"]>0) {
      $this->magicbarriers[$i]["value"]=$this->battleunits[$i]["manabarrier"];
      $this->magicbarriers[$i]["priem"]="wis_gray_manabarrier".($this->battleunits[$i]["mbstroke"]<10?"0":"").$this->battleunits[$i]["mbstroke"];
      $this->magicbarriers[$i]["manaforhp"]=$strokes[$this->magicbarriers[$i]["priem"]]->manaforhp;
      $this->magicbarriers[$i]["damagepart"]=$strokes[$this->magicbarriers[$i]["priem"]]->damagepart;
      $this->magicbarriers[$i]["chancenokrit"]=(int)@$strokes[$this->magicbarriers[$i]["priem"]]->chancenokrit;
    } else {
      $this->magicbarriers[$i]["value"]=0;
      $this->magicbarriers[$i]["chancenokrit"]=0;
    }
    return $this->magicbarriers[$i];


    if (!@$this->magicbarriers[$i]) {
      $fr=mqfa("select id, value, priem from battleeffects where user='$i' and battle='".$this->battle_data["id"]."' and effect='".MAGICBARRIER."'");
      if ($fr && $fr["value"]<=0) mq("delete from battleeffects where id='$fr[id]'");
      if ($fr) {
        if (@$fr["value"]<0) $fr["value"]=0;
        $this->magicbarriers[$i]["value"]=$fr["value"];
        $this->magicbarriers[$i]["id"]=$fr["id"];
        $this->magicbarriers[$i]["priem"]=$fr["priem"];
        $this->magicbarriers[$i]["manaforhp"]=$strokes[$fr["priem"]]->manaforhp;
        $this->magicbarriers[$i]["damagepart"]=$strokes[$fr["priem"]]->damagepart;
        $this->magicbarriers[$i]["chancenokrit"]=(int)@$strokes[$fr["priem"]]->chancenokrit;
      }
    }
    return $this->magicbarriers[$i];
  }

  function addbotwin($b,$s) {
    static $bots;
    $p=mqfa1("select prototype from bots where id='$b'");
    if (@$bots[$p]) return;
    $bots[$p]=1;
    $ib=mqfa1("select bot from users where id='$p'");
    if ($ib) {
      if ($s==1) mq("update users set win=win+1 where id='$p'");
      if ($s==2) mq("update users set lose=lose+1 where id='$p'");
      if ($s==3) mq("update users set nich=nich+1 where id='$p'");
    }
  }

  function takehp($v, $i, $hp, $useff=1, $from=0, $nosave=0, $damtype=0) {
    global $takenbybarrier, $strokes;
    if ($v<0) $v=0;
    if (!$v) return;
    $inc=$this->effectval($i, INCDAMAGE);
    if ($inc) $v*=$inc/100+1;
    if (@$this->battleunits[$i]["defender"]) $i=$this->battleunits[$i]["defender"];
    if ($from) {
      $mult=1;
      $this->getbu($from);
      foreach ($this->battleunits[$from]["effects"] as $k1=>$v1) if ($v1["effect"]==LOWERDAMAGE) $mult*=$v1["value"]/100;
      $v=ceil($v*$mult);
    }
    
    $hp=$this->userdata[$i]["hp"];
    if ($useff) {
      $ff=$this->getforcefield($i);
      if ($ff>0) {
        if ($ff>$v) {
          @$this->toupdatebu[$i]["forcefield"]-=$v;
          //mq("update battleeffects set value=value-$v where id='$ff[id]'");
          //$this->forcefields[$i]["value"]-=$v;
          $this->battleunits[$i]["forcefield"]-=$v;
        } else {
          //$this->forcefields[$i]["value"]=0;
          @$this->toupdatebu[$i]["forcefield"]-=$this->battleunits[$i]["forcefield"];
          $this->battleunits[$i]["forcefield"]=0;
          //mq("delete from battleeffects where id='$ff[id]'");
          $this->logstrokeend("Силовое поле", $i);
        }
        $this->needupdatebu=1;
        $v-=$ff;
      }
    }
    if ($v>0) {
      if ($useff) {
        $mb=$this->getmagicbarrier($i);
        if ($mb["value"]>0) {
          $taken=min($mb["value"], round($v*$mb["damagepart"]));
          $takenmana=$this->takemana(round($taken*$mb["manaforhp"]), $i, GRAYDAMAGE, 0);
          if ($this->userdata[$i]["mana"]<=0) {
            $taken=round($taken1/$mb["manaforhp"]);
            @$this->toupdatebu[$i]["manabarrier"]-=$this->magicbarriers[$i]["value"];
            $this->magicbarriers[$i]["value"]=0;
            $this->battleunits[$i]["manabarrier"]=0;
            $this->logstrokeend($mb["priem"], $i);
          } elseif ($mb["value"]>$taken) {
            @$this->toupdatebu[$i]["manabarrier"]-=$taken;
            //mq("update battleeffects set value=value-$taken where id='$mb[id]'");
            $this->magicbarriers[$i]["value"]-=$taken;
            $this->battleunits[$i]["manabarrier"]-=$taken;;
          } else {
            @$this->toupdatebu[$i]["manabarrier"]-=$taken;
            $this->magicbarriers[$i]["value"]=0;
            //mq("delete from battleeffects where id='$mb[id]'");
            $this->battleunits[$i]["manabarrier"]-=$taken;;
            $this->logstrokeend($mb["priem"], $i);
          }
          //$this->toupdate["$i"]["mana"]-=round($taken*$mb["manaforhp"]);
          $this->needupdate=1;
          $this->needupdatebu=1;
          $takenbybarrier[$i]=$takenmana;
          $v-=$taken;
        }
        if ($v>0 && $this->battleunits[$i]["effects"]["wis_air_shield"]) {
          if ($this->battleunits[$i]["effects"]["wis_air_shield"]["value"]>$v) {
            $this->battleunits[$i]["effects"]["wis_air_shield"]["value"]-=$v;
            $v=0;
          } else {
            $v-=$this->battleunits[$i]["effects"]["wis_air_shield"]["value"];            
            $this->remeffect($i, "wis_air_shield");
            $this->logstrokeend("wis_air_shield", $i);
          }
          if ($this->haseffecttype($from, STATICS)) {
            $this->addeffect($from, CHARGE, 1, 0, "wis_air_charged", array(), 0);
          }
          $this->toupdatebu[$i]["effects"]=1;
          $this->needupdatebu=1;      
        }
      }
      if ($v>0) {
        if ($this->battleunits[$i]["prototype"]==UNKILLABLEBOT) $v=rand(1,2);
        if ($this->battleunits[$from]["prototype"]==UNKILLABLEBOT) $v*=rand(10,20);
        if ($this->battleunits[$i]["prototype"]==HELLRISER && $damtype!=SNOWBALL) $v=1;
        if ($from) {
          $bd=$this->haseffecttype($from, BLOODDRINK);
          if ($bd) {
            $heal=round($v*0.75);
            $mh=array(19,23,29,37,47,59,73,89,107,128,154,185,220,260,310);
            if ($heal>$mh[$this->userdata[$i]["level"]]) $heal=$mh[$this->userdata[$i]["level"]];
            $heal=$this->addhp($heal, $from);
            $this->add_log('<span class=date>'.date("H:i").'</span> '.$this->nick7($from).' восстановил'.($this->battleunits[$from]["sex"]?"":"а").' жизнь от эффекта <b>'.$strokes[$bd]->name.'</b>: <b><font color="#006699">+'.$heal.'</b></font> ['.$this->userdata[$from]["hp"].'/'.$this->userdata[$from]["maxhp"].']<BR>');
            $this->deceffect($from, $bd);
          }
        }
        if (!@$this->toupdate["$i"]["hp"]) $this->toupdate["$i"]["hp"]=0;
        $this->toupdate["$i"]["hp"]-=$v;
        //$this->userdata[$i]["hp"]=$hp-$v;
        $this->userdata[$i]["hp"]-=$v;
        $this->needupdate=1;
      }
    }
    if ($v<0) return 0;
    if (!$nosave) $this->addreceiveddamage($i, -$v);
    return $v;
  }

  function deceffect($user, $effect) {
    $this->battleunits[$user]["effects"][$effect]["length"]--;
    if ($this->battleunits[$user]["effects"][$effect]["length"]<=0) {
      unset($this->battleunits[$user]["effects"][$effect]);
      $this->logstrokeend($effect, $user);
    }
    $this->toupdatebu[$user]["effects"]=1;
    $this->needupdatebu=1;
  }

  function takemana($v, $i, $damagetype=0, $useusage=1, $iscast=0) {
    if ($i>_BOTSEPARATOR_) return;
    if ($v<0) $v=0;
    if (!$v) return;
    if ($useusage) {
      $this->getbu($i);
      $skill=0;
      if ($damagetype==FIREDAMAGE) $skill=$this->battleunits[$i]["mfire"];
      if ($damagetype==WATERDAMAGE) $skill=$this->battleunits[$i]["mwater"];
      if ($damagetype==EARTHDAMAGE) $skill=$this->battleunits[$i]["mearth"];
      if ($damagetype==AIRDAMAGE) $skill=$this->battleunits[$i]["mair"];
      if ($damagetype==DARKDAMAGE) $skill=$this->battleunits[$i]["mdark"];
      if ($damagetype==LIGHTDAMAGE) $skill=$this->battleunits[$i]["mlight"];
      if ($damagetype==GRAYDAMAGE) $skill=$this->battleunits[$i]["mgray"];
      $v*=(100-($skill*0.72)-$this->battleunits[$i]["manausage"])/100;
    }
    if ($iscast) {
      $eff=$this->haseffecttype($i, CASTCOST);
      if ($eff) {
        if ($this->battleunits[$i]["effects"][$eff]["effect"]==CASTCOST) $cc=$this->battleunits[$i]["effects"][$eff]["value"];
        if ($this->battleunits[$i]["effects"][$eff]["effect2"]==CASTCOST) $cc=$this->battleunits[$i]["effects"][$eff]["value2"];
        if ($this->battleunits[$i]["effects"][$eff]["effect3"]==CASTCOST) $cc=$this->battleunits[$i]["effects"][$eff]["value3"];
        $v*=$cc/100;
      }
    }$v=round($v);
    if ($v>0) {                                                                                    
      //if ($i>_BOTSEPARATOR_) mq('UPDATE `bots` SET `hp` = `hp` - '.$v.' WHERE `id` = '.$i.'');
      //else mq('UPDATE users SET `hp` = `hp` - '.$v.' WHERE `id` = '.$i.'');
      if (!@$this->toupdate["$i"]["mana"]) $this->toupdate["$i"]["mana"]=0;
      $ret=min($v, $this->userdata[$i]["mana"]);
      $this->toupdate["$i"]["mana"]-=$ret;
      $this->userdata[$i]["mana"]=max($this->userdata[$i]["mana"]-$v, 0);
      $this->needupdate=1;
      return $ret;
    }
  }

  function adddamage($u, $d, $e) {
    $this->damage[$u]+=$d;
    $this->exp[$u]+=$this->solve_exp($u,$e,$d);
    $this->addhp2($u, $e, $d);
    $this->needupdate=1;
  }

  function addreceiveddamage($u, $d) {
    if ($u>_BOTSEPARATOR_) return;
    $this->battleunits[$u]["additdata"]["damage"][2]=$this->battleunits[$u]["additdata"]["damage"][1];
    $this->battleunits[$u]["additdata"]["damage"][1]=$this->battleunits[$u]["additdata"]["damage"][0];
    $this->battleunits[$u]["additdata"]["damage"][0]=$d;
    $this->needupdateaddit[$u]=1;
  }

  function addhp($v, $i, $nospirit=0, $nosave=0) {
    global $user;
    if ($v<0) return;
    $dec=$this->effectval($i, DECHEAL);
    if ($dec) $v=round($v*((100-$dec)/100));
    $this->getbu($i);
    /*if ($i==$user["id"]) {
      $user["hp"]+=$v;
      if ($user["hp"]>$user["maxhp"]) $user["hp"]=$user["maxhp"];
    }*/
    //if ($v<=0) return;
    //if ($i>_BOTSEPARATOR_) mq('UPDATE `bots` SET `hp` = `hp` - '.$v.' WHERE `id` = '.$i.'');
    //else mq('UPDATE users SET `hp` = `hp` - '.$v.' WHERE `id` = '.$i.'');
    if ($nospirit!=1) {
      $duh=$this->battleunits[$i]["additdata"]["s_duh"];
      //if ($i==$user["id"] && !USERBATTLE) $duh=$user["s_duh"];
      //else $duh=mqfa1("select s_duh from users where id='$i'");
    } else $duh=1;
    if ($duh>0) {      
      if ($this->userdata[$i]["hp"]+$v>=$this->userdata[$i]["maxhp"]) $v=$this->userdata[$i]["maxhp"]-$this->userdata[$i]["hp"];
      if (!@$this->toupdate["$i"]["hp"]) $this->toupdate["$i"]["hp"]=0;
      if ($v<0) $v=0;
      $this->toupdate["$i"]["hp"]+=$v;
      $this->userdata[$i]["hp"]+=$v;
      if ($i<_BOTSEPARATOR_) {
        $this->battleunits[$i]["additdata"]["healed"]+=$v;
        $this->needupdateaddit[$i]=1;
      }
      if ($i==$user["id"] && USERBATTLE) $this->user["hp"]+=$v;
      $this->needupdate=1;
      if (!$nospirit) takespirit($i, $v/$this->userdata[$i]["maxhp"]*10);
      elseif ($nospirit==2) takespirit($i, $v/$this->userdata[$i]["maxhp"]*10/2);
      if (!$nosave) $this->addreceiveddamage($i, $v);
      return $v;
    } 
    return 0;
  }
  
  function addmana($v, $i) {
    if ($v<0) return;
    if (!@$this->toupdate["$i"]["mana"]) $this->toupdate["$i"]["mana"]=0;
    $st=$this->userdata[$i]["mana"];
    $this->userdata[$i]["mana"]=min($this->userdata[$i]["mana"]+$v, $this->userdata[$i]["maxmana"]);
    $this->toupdate["$i"]["mana"]+=$v;
    $this->needupdate=1;
    if ($i<_BOTSEPARATOR_ && 0) {
      $this->battleunits[$i]["additdata"]["manahealed"]+=$this->userdata[$i]["mana"]-$st;
      $this->needupdateaddit[$i]=1;
    }
    return $this->userdata[$i]["mana"]-$st;
  }

  function checkbackeffects($attacker, $defender, $d, $magic=0) {
    global $strokes;
    if ($d<=0) return;
    foreach ($this->battleunits[$defender]["effects"] as $k=>$v) {
      if ($magic && !@$strokes[$k]->backeffectonmagic) continue;
      $val=0;
      if ($v["effect"]==BACKMINUSWATERDEF) $val=$v["value"];
      if ($v["effect2"]==BACKMINUSWATERDEF) $val=$v["value2"];
      if ($v["effect3"]==BACKMINUSWATERDEF) $val=$v["value3"];
      if ($val) {
        $this->addeffect($attacker, MINUSWATERDEF, $val, 0, "$k-back", array(), 0);
      }
      $val=0;
      if ($v["effect"]==DAMAGETOMANA) $val=$v["value"];
      if ($v["effect2"]==DAMAGETOMANA) $val=$v["value2"];
      if ($v["effect3"]==DAMAGETOMANA) $val=$v["value3"];
      if ($val>0) {
        $dm=$this->addmana(ceil($d*$val/100), $defender);
        if ($dm) $this->add_log('<span class=date>'.date("H:i").'</span> '.$this->nick7($defender).' восстановил'.($this->battleunits[$defender]["sex"]?"":"а").' ману от эффекта <b>'.$strokes[$k]->name.'</b>: <b><font color="#006699">+'.$dm.'</b></font> ['.$this->userdata[$defender]["mana"].'/'.$this->userdata[$defender]["maxmana"].']<BR>');
      }
      $val=0;
      if ($v["effect"]==BACKDAMAGE) $val=$v["value"];
      if ($v["effect2"]==BACKDAMAGE) $val=$v["value2"];
      if ($v["effect3"]==BACKDAMAGE) $val=$v["value3"];
      if ($val) {
        $d=$d*($val/100);
        $res=$this->checkpriems2($this->battleunits[$attacker]["priems"],($attacker==$this->user["id"]?$this->my_class:$this->en_class),$attacker,1);
        $damage=$this->processstrokeeffect2($res, $d);
        if ($strokes[$k]->backdamagemax) {
          if ($strokes[$k]->backdamagemax=="level50") $md=$this->userdata[$defender]["level"]*50;
          else $md=$strokes[$k]->backdamagemax;
          $damage=min($damage, $md);
        }
        $damage=$this->instantdamage($attacker, $damage, 1, $defender);
        $damage=$this->takehp($damage, $attacker, $this->userdata[$attacker]["hp"], 1, $defender);
        $this->add_log('<span class=date>'.date("H:i").'</span> '.$this->nick7($attacker).' получил'.($this->battleunits[$attacker]["sex"]?"":"а").' повреждение от <b>'.$strokes[$k]->backdamagename.'</b>: <b>-'.$damage.'</b> '.$this->loghp($attacker).'<BR>');
        if ($strokes[$k]->endaftereffect) {
          $this->remeffect($defender, $k, $v);
          $this->logstrokeend($k, $defender);
        }
      }
    }
  }

  function loghp($u) {
    if ($this->battleunits[$u]["invis"]) return "[??/??]";
    return '['.max(0,$this->userdata[$u]["hp"]).'/'.$this->userdata[$u]["maxhp"].']';
  }

  function logmana($u) {
    if ($this->battleunits[$u]["invis"]) return "[??/??]";
    return '['.max(0,$this->userdata[$u]["mana"]).'/'.$this->userdata[$u]["maxmana"].']';
  }

  function addhp2($user, $enemy, $damage) {
    if ($user>_BOTSEPARATOR_) return;
    foreach ($this->battleunits[$user]["effects"] as $k=>$v) {
      if ($v["effect"]==SHOCK) return;
    }    
    /*foreach ($this->userdata as $k=>$v) {
      if ($k==$enemy) $maxhp=$v["maxhp"];
    }*/
    if ($this->battleunits[$enemy]["level"]>8) {
      $maxhp=min($this->userdata[$enemy]["maxhp"],1000*pow(1.2,$this->battleunits[$enemy]["level"]-8));
    } else $maxhp=$this->userdata[$enemy]["maxhp"];
    if ($damage>0) {
      if ($user<_BOTSEPARATOR_ && $this->ispvp()) {
        if ($this->cantgettatic($user, $enemy)) $maxhp*=2;
      }
      $this->battleunits[$user]["additdata"]["hp2"]+=($damage/$maxhp*10);
      if ($this->battleunits[$user]["additdata"]["hp2"]>25) $this->battleunits[$user]["additdata"]["hp2"]=25;
      $this->needupdateaddit[$user]=1;
      //@$this->toupdate[$user]["hp2"]+=($damage/$maxhp*10);
      $this->needupdate=1;
      //mq("update users set hp2=hp2+".($damage/$maxhp*10)." where id='$id'");
    }
  }

  function cantgettatic($user, $from) {
    global $notacticrestrrooms;
    if (in_array($this->battle_data["room"], $notacticrestrrooms)) return false;
    $coef=1;
    /*if ($this->userdata[$user]["level"]>$this->userdata[$from]["level"]) {
      $i=$this->userdata[$from]["level"];
      while ($i<$this->userdata[$user]["level"]) {
        $i++;
        $coef*=1.2;
      }
    }
    if ($this->userdata[$user]["level"]<$this->userdata[$from]["level"]) {
      $i=$this->userdata[$user]["level"];
      while ($i<$this->userdata[$from]["level"]) {
        $i++;
        $coef/=1.2;
      }
    }*/
    if ($this->battleunits[$user]["cost2"]*0.56*$coef>$this->battleunits[$from]["cost2"]) return true;
    return false;
  }

  function checkpriemsuv(&$priems, $class, $user) {
    global $strokes;
    $ret=array();
    foreach ($priems as $k=>$v) {
      if (@$strokes[$k]->uvorot && $v["active"]>1) {
        if (@$strokes[$k]->counter) $ret["counter"]=1;
        if (@$strokes[$k]->nocounter) $ret["nocounter"]=1;
        $ret["uvorot"]=1;
        $this->addlog2($this->battle_data["id"], $class, $user, $k);
        $priems[$k]["active"]=1;
        $this->actpriem($k, $priems[$k]["id"], $user, 1, 1);
      }
    }
    return $ret;
  }

  function checkpriemsparry(&$priems, $class, $userdata, $enemylevel) {
    global $strokes;
    $ret=array();
    foreach ($priems as $k=>$v) {
      if (@$strokes[$k]->parry && $v["active"]>1) {
        $ret["parry"]=1;
        if (@$strokes[$k]->noparry) $ret["noparry"]=1;
        if (@$strokes[$k]->hpbyenlevel) {
          $dhp=$enemylevel*$strokes[$k]->hpbyenlevel;
          $userdata["hp"]+=$enemylevel*$strokes[$k]->hpbyenlevel;
          if ($userdata["hp"]>$userdata["maxhp"]) {
            $dhp-=$userdata["hp"]-$userdata["maxhp"];
            $userdata["hp"]=$userdata["maxhp"];
          }
          $this->addhp($dhp, $userdata["id"]);
          $this->addlog2($this->battle_data["id"],$class, $userdata["id"], "heal2", $dhp,$userdata["hp"],$userdata["maxhp"], $k);
        } else {
          $this->addlog2($this->battle_data["id"], $class, $userdata["id"], $k);
        }
        $priems[$k]["active"]=1;
        $this->actpriem($k, $priems[$k]["id"], $userdata["id"], 1, 1);
      }
    }
    return $ret;
  }

  function checkpriemskrit(&$priems, $class, $user) {
    global $strokes;
    $ret=array();
    foreach ($priems as $k=>$v) {
      if (($k=="krit_blindluck" || $k=="multi_hiddenpower") && $v["active"]>1) {
        $ret["krit"]=1;
        if ($k=="krit_blindluck") $ret["nokrit"]=1;
        $this->addlog2($this->battle_data["id"], $class, $user, $k);
        $priems[$k]["active"]=1;
        $this->actpriem($k, $priems[$k]["id"], $user, 1, 1);
      }
    }
    return $ret;
  }

  function checkpriems1(&$priems, $class, $user, $iskrit, $enemy) {
    global $strokes;
    $ret=array("damageplus"=>0, "damagemult"=>1);
    foreach ($priems as $k=>$v) {
      if ($v["active"]==2 && $strokes[$k]->type==1) {
        if (@$strokes[$k]->needkrit && !$iskrit) continue;
        if (!@$strokes[$k]->actuntilmove) {
          $this->actpriem($k, $priems[$k]["id"], $user["id"], 1, 1);
          $this->addlog2($this->battle_data["id"],$class,$user['id'],$k);
          $priems[$k]["active"]=1;
        }
        if (@$strokes[$k]->dieafter) $ret["dieafter"]=1;
        if (@$strokes[$k]->skiparmor) $ret["skiparmor"]=1;
        if (@$strokes[$k]->damagemult) $ret["damagemult"]*=$strokes[$k]->damagemult;
        if (@$strokes[$k]->damageplus) $ret["damageplus"]+=$strokes[$k]->damageplus;
        if (@$strokes[$k]->damageplusbylevel) $ret["damageplus"]+=$user['level']*$strokes[$k]->damageplusbylevel;
        if (@$strokes[$k]->maxkrit) $ret["maxkrit"]=1;
        if (@$strokes[$k]->effect) $this->addeffect($enemy, $strokes[$k]->effect, (int)@$strokes[$k]->value, 0, $k, array(), 0, 0, @$strokes[$k]->effect2, (int)@$strokes[$k]->value2, $user["id"]);
        if (@$strokes[$k]->selfeffect) $this->addeffect($user["id"], $strokes[$k]->selfeffect, (int)@$strokes[$k]->sevalue, 0, $k, array(), 0, 0, @$strokes[$k]->selfeffect2, (int)@$strokes[$k]->sevalue2, $user["id"]);
        if (@$strokes[$k]->silaforhit) {
          if ($this->battleunits[$user["id"]]["level"]<=7) @$this->toupdatebu[$user["id"]]["sila"]+=10;
          if ($this->battleunits[$user["id"]]["level"]==8) @$this->toupdatebu[$user["id"]]["sila"]+=13;
          if ($this->battleunits[$user["id"]]["level"]>=9) @$this->toupdatebu[$user["id"]]["sila"]+=14;
          $this->needupdatebu=1;
        }
      }
    }
    foreach ($this->battleunits[$user["id"]]["effects"] as $k=>$v) {
      if ($v["effect"]==EXTRADAMAGE) $ret["damagemult"]*=$v["value"]/100+1;
    }
    return $ret;
  }

  function checkpriems2($priems, $class, $user, $untilmoveonly=0, $magic=0, $usestroke=1, $prof=0) {
    global $strokes;
    if (@$this->battleunits[$user]["defender"]) $user=$this->battleunits[$user]["defender"];
    if ($user==$this->user["id"])  $enemy=$this->battleunits[$user]["enemy"];
    else $enemy=$this->user["id"];
    $ret=array("damageminus"=>0, "damagemult"=>1);
    foreach ($this->battleunits[$user]["priems"] as $k=>$v) {
      if ($v["active"]==2 && $strokes[$k]->type==2) {
        if (@$strokes[$k]->needkrit && !$iskrit) continue;
        if (!@$strokes[$k]->actuntilmove && $usestroke) {
          if ($untilmoveonly) continue;
          $this->actpriem($k, $this->battleunits[$user]["priems"][$k]["id"], $user, 1, 1);
          $this->battleunits[$user]["priems"][$k]["active"]=1;
          if (@$strokes[$k]->damage) {
            if ($strokes[$k]->damage=="level3") {
              $dam=$this->userdata[$user]["level"]*3;
            } elseif ($strokes[$k]->damage=="level6") {
              $dam=$this->userdata[$user]["level"]*6;
            } else $dam=$strokes[$k]->damage;
            $dam=$this->takehp($dam, $enemy, 0, 1, $user);
            $this->adddamage($user, $dam, $enemy);                                     
            $this->addlog2($this->battle_data["id"],$class,$user,$k, $enemy, $dam,$this->loghp($enemy));
          } else {
            $this->addlog2($this->battle_data["id"],$class,$user,$k);
          }
        }
        if (@$strokes[$k]->damageminus) $ret["damageminus"]+=$strokes[$k]->damageminus;
        if (@$strokes[$k]->damagemult) $ret["damagemult"]*=$strokes[$k]->damagemult;
        if (@$strokes[$k]->maxdamage) $ret["maxdamage"]=$strokes[$k]->maxdamage;
      }
    }
    foreach ($this->battleunits[$user]["effects"] as $k=>$v) {
      if ($magic) {
        if ($v["effect"]==MAGICDAMAGE1) {
          $ret["maxdamage"]=1;
          $this->addlog2($this->battle_data["id"],$class,$user,$k, $enemy, $dam,$this->userdata[$enemy]["hp"],$this->userdata[$enemy]["maxhp"]);
          $this->remeffect($user, $k, $v);
        }
        if ($v["effect"]==MAGDAMAGEMULT) $ret["damagemult"]*=1-($v["value"]/100);
      } 
      if ($v["effect"]==DAMAGEMULT) $ret["damagemult"]*=1-($v["value"]/100);
      if ($v["effect2"]==DAMAGEMULT) $ret["damagemult"]*=1-($v["value2"]/100);
      if ($v["effect"]==PROFDAMAGEMULT && $prof && $prof==$strokes[$k]->prof) {
        $ret["damagemult"]*=1-($v["value"]/100);
      }
    }
    return $ret;
  }

  function processstrokeeffect2($res, $damage) {
    if (@$res["damageminus"]) $damage-=$res["damageminus"];
    if (@$res["damagemult"]) $damage*=$res["damagemult"];
    if (@$res["maxdamage"]) $damage=$res["maxdamage"];
    return ceil($damage);
  }

  function makemagicdamage($user, $enemy, $magic) {
    if ($magic["magic"]==61 || $magic["magic"]==64) $from="ожога";
    if ($magic["magic"]==62) $from="обморожения";
    if ($magic["magic"]==63) $from="разряда";
    $dam=rand($magic["from"], $magic["to"])*(1-mftoabs($this->battleunits[$enemy]["mfdmag"]+$this->battleunits[$enemy]["mfd".$magic["prof"]]));
    $res=$this->checkpriems2($this->battleunits[$enemy]["priems"], ($enemy==$this->user["id"]?$this->my_class:$this->en_class), $enemy, 1, 1);
    $dam=$this->processstrokeeffect2($res, $dam);
    $dam=$this->takehp($dam, $enemy, $this->userdata["enemy"]["hp"], 1, $user);
    $this->adddamage($user, $dam, $enemy);
    $this->add_log('<span class=date>'.date("H:i").'</span> '.$this->nick5($enemy).' получил'.($this->battleunits[$enemy]["sex"]?"":"а").' повреждение от <b>'.$from.'</b>: <b>-'.$dam.'</b> '.$this->loghp($enemy).'<BR>');
  }

  function makehit($who, $mf, $user, $enemy, $attack, $defend, $num, $dontshowuv=0) {
    global $strokes;
    if ($num==1) {$hitnum="";$hn="";}
    elseif ($num==2) {$hitnum="1";$hn="1";}
    elseif ($num==3) {$hitnum="2";$hn="";}
    elseif ($num==4) {$hitnum="3";$hn="1";}
    else {$hitnum="4";$hn="";}
    if ($who=="me") {
      if ($num==1 && $this->cowardshifts[$user]) $iscowardshift=1;
      else $iscowardshift=0;
      if ($iscowardshift) {
        $uvorot = $this->get_chanse($mf["me"]["cowarduvorot"]);
        if ($uvorot && $this->battleunits[$user]["skipuv"]>0) {
          if ($this->get_chanse($this->battleunits[$user]["skipuv"])) $uvorot=0;
        }
      } else {
        $uvorot = $this->get_chanse($mf["he"]['uvorot']);
        if ($uvorot && $this->battleunits[$enemy]["skipuv"]>0) {
          if ($this->get_chanse($this->battleunits[$enemy]["skipuv"])) $uvorot=0;
        }
      }
      if ($iscowardshift) {
        $krit = $this->get_chanse($mf["me"]["cowardkrit"]);
        if ($krit) {
          $ff=$this->getforcefield($user);
          if ($ff>0) $krit=0;
        }
        if ($krit) {
          $mb=$this->getmagicbarrier($user);
          if (@$mb["chancenokrit"]) {
            if ($this->get_chanse($mb["chancenokrit"])) $krit=0;
          }
        }
      } else {
        $krit = $this->get_chanse($mf["me"]['krit']);
        if ($krit) {
          $ff=$this->getforcefield($enemy);
          if ($ff>0) $krit=0;
        }
        if ($krit) {
          $mb=$this->getmagicbarrier($enemy);
          if (@$mb["chancenokrit"]) {
            if ($this->get_chanse($mb["chancenokrit"])) $krit=0;
          }
        }
      }
      $prof=$mf["me"]["prof$hitnum"];
    } else {
      if ($num==1 && $this->cowardshifts[$enemy]) $iscowardshift=1;
      if ($iscowardshift) {
        $uvorot = $this->get_chanse($mf["he"]["cowarduvorot"]);
        if ($uvorot && $this->battleunits[$enemy]["skipuv"]>0) {
          if ($this->get_chanse($this->battleunits[$enemy]["skipuv"])) $uvorot=0;
        }
      } else {
        $uvorot = $this->get_chanse($mf["me"]['uvorot']);        
        if ($uvorot && $this->user_dress["skipuv"]>0) {
          if ($this->get_chanse($this->user_dress["skipuv"])) $uvorot=0;
        }
      }
      if ($iscowardshift) {
        $krit = $this->get_chanse($mf["he"]["cowardkrit"]);
        if ($krit) {
          $ff=$this->getforcefield($enemy);
          if ($ff>0) $krit=0;
        }
        if ($krit) {
          $mb=$this->getmagicbarrier($enemy);
          if (@$mb["chancenokrit"]) {
            if ($this->get_chanse($mb["chancenokrit"])) $krit=0;
          }
        }
      } else {
        $krit = $this->get_chanse($mf["he"]['krit']);
        if ($krit) {
          $ff=$this->getforcefield($user);
          if ($ff>0) $krit=0;
        }
        $mb=$this->getmagicbarrier($user);
        if ($krit) {
          $mb=$this->getmagicbarrier($user);
          if (@$mb["chancenokrit"]) {
            if ($this->get_chanse($mb["chancenokrit"])) $krit=0;
          }
        }
      }
      $prof=$mf["he"]["prof$hitnum"];
    }
    if ($who=="me") {
      $res=$this->checkpriemsuv($this->battleunits[$this->currentenemy]["priems"],$this->en_class,$enemy);
      if ($prof=="mag") $noblock=true;
      else $noblock=$this->get_block ("he",$attack,$this->battle[$enemy][$user][1],$enemy);
    } else {
      $res=$this->checkpriemsuv($this->battleunits[$this->user["id"]]["priems"],$this->my_class,$user);
      if ($enemy<_BOTSEPARATOR_) {
        $minimax=unserialize($this->battleunits[$enemy]["weapondata"]);
        if ($minimax["weptype"]=='posoh') {              
          $this->addmana(ceil($this->userdata[$enemy]["maxmana"]/100), $enemy);
        }
      }
      if ($prof=="mag") $noblock=true;
      else $noblock=$this->get_block ("me",$this->battle[$enemy][$user][$num==1?0:$num+1],$defend,$enemy);
    }
    if (@$res["uvorot"]) {
      $uvorot=1;
    }
    if (!$uvorot && !$krit) {
      if ($who=="me") {
        $res=$this->checkpriemskrit($this->battleunits[$this->user["id"]]["priems"],$this->my_class,$user);
      } else {
        $res=$this->checkpriemskrit($this->battleunits[$this->currentenemy]["priems"],$this->en_class,$enemy);
      }
      if (@$res["krit"]) $krit=1;
      if (@$res["nokrit"]) $dontaddkrit=1;
    }

    if (!$uvorot) {
      if ($who=="me") {
        foreach ((array)$this->battleunits[$user]["additdata"]["magics"] as $k=>$v) {
          if ($v["magic"]>=60 and $v["magic"]<90) {
            if (getchance($v["chance"])) {
              $this->makemagicdamage($user, $enemy, $v);
            }
          }
        }
      } else {
        foreach ((array)$this->battleunits[$enemy]["additdata"]["magics"] as $k=>$v) {
          if ($v["magic"]>=60 and $v["magic"]<90) {
            if (getchance($v["chance"])) {
              $this->makemagicdamage($enemy, $user, $v);
            }
          }
        }
      }
    }
    if ($uvorot) {
      // я увернулся;
      if (!$dontshowuv) {
        if ($who=="me") {
          $this->add_log ($this->razmen_log("uvorot",$attack,$this->user["minimax$hn"]["weptype"],0,$user,$this->my_class,$enemy,$this->en_class, 0, 0, $this->battle[$enemy][$user][1], $prof), 1);
        } else {
          $this->add_log ($this->razmen_log("uvorot",$this->battle[$enemy][$user][$num==1?0:$num+1],$this->enemyhar["minimax$hn"]["weptype"],0,$enemy,$this->en_class,$user,$this->my_class, 0, 0, $defend, $prof), 1);
        }
      }
      if (@$res["counter"] && !@$res["nocounter"]) $ret=4;
      elseif (@$res["counter"]) $ret=3;
      else $ret=1;
    } elseif($krit) {
      if ($who=="me") {
        // его кританули
        $minpower=$mf['me']["udar$hitnum"];
        $mf["me"]["udar$hitnum"]=$mf["me"]["kritudar$hitnum"];
        if(!$noblock) {
          $hs = 0.5; $m = 'a';
        } else {
          $hs = 1; $m = '';
          $res=$this->checkpriemsparry($this->battleunits[$this->currentenemy]["priems"],$this->en_class,$this->enemyhar, $this->user["level"]);
          $parry=$this->get_chanse($this->enemy_dress["mfparir"]);
          if ($parry && $this->user_dress["skipuv"]>0) {
            if ($this->get_chanse($this->user_dress["skipuv"])) $parry=0;
          }
          if (@$res["parry"] || $parry) {
            $hs = 0.5; $m = 'p';
            if (!@$res["noparry"]) @$this->addtactic($enemy, "parry", 1, $user);
          } else{
            $shieldblock=$this->get_chanse($this->enemy_dress["mfshieldblock"]);
            if ($shieldblock && $this->user_dress["skipuv"]>0) {
              if ($this->get_chanse($this->user_dress["skipuv"])) $shieldblock=0;
            }
            if ($shieldblock) {
              $hs = 0.5; $m = 'b';
            }
          }
        }
        $minpower*=$hs;

        $res=$this->checkpriems1($this->battleunits[$this->user["id"]]["priems"],$this->my_class,$this->user, 1, $enemy);
        if (@$res["maxkrit"]) $mf["me"]["udar$hitnum"]=$mf["me"]["maxkritudar$hitnum"];
        if (@$res["skiparmor"]) {
          $mf["me"]["udar$hitnum"]=$mf["me"]["kritudarskiparmor$hitnum"];
        }
        if ($res["damageplus"]) $mf["me"]["udar$hitnum"]+=$res["damageplus"];
        if ($res["damagemult"]) $mf["me"]["udar$hitnum"]*=$res["damagemult"];
        if (@$res["dieafter"]) {                                                                       
          $this->takehp($this->userdata[$user]["hp"], $user, $this->userdata[$user]["hp"], 0);
          //echo "$user dies";
          //die;
          //$this->toupdate[$user]["die"]=1;
          //$this->needupdate=1;
          //$this->needrefresh=1;
        }
        $res=$this->checkpriems2($this->battleunits[$this->currentenemy]["priems"],$this->en_class,$this->enemyhar["id"], 0, 0, 1, $mf["me"]["prof$hitnum"]);
        $mf["me"]["udar$hitnum"]=$this->processstrokeeffect2($res, $mf["me"]["udar$hitnum"]);
        if (@$res["maxdamage"]) $hs=1;

        $mf['me']["udar$hitnum"]=notzero($mf['me']["udar$hitnum"]);
        //$this->damage[$user] += ceil($mf['me']["udar$hitnum"]*$hs); 
        $this->exp[$user] += $this->solve_exp ($user,$enemy,min(ceil($mf['me']["udar$hitnum"]*$hs), $this->enemyhar['hp']));

        $starthp=$this->userdata[$enemy]["hp"];
        $d=$this->takehp(ceil($mf['me']["udar$hitnum"]*$hs), $enemy, $this->enemyhar['hp'], 1, $user);
        $this->damage[$user]+=$d;
        //$this->exp[$user]+=$this->solve_exp($user,$enemy,min($d, $this->enemyhar['hp'])); Remove exp for force field
        if ($hs==1 && $this->userdata[$enemy]["hp"]<=0) {
          $this->addeffect($enemy, INJURY, 5, 0, "hp_travma", array(), 0, 0, 0, 0, $user);
        }
        $this->enemyhar['hp']-=ceil($mf['me']["udar$hitnum"]*$hs);                                                                                                //$this->enemyhar['hp']
        $this->add_log ($this->razmen_log("krit".$m,$attack,$this->user["minimax$hn"]["weptype"],ceil($d),$user,$this->my_class,$enemy,$this->en_class,$this->userdata[$this->enemyhar['id']]["hp"],$this->enemyhar['maxhp'], $this->battle[$enemy][$user][1], $prof), 1);

        if (!@$dontaddkrit) {
          if ($m) @$this->addtactic($user, "krit", 1, $enemy);
          else @$this->addtactic($user, "krit", 2, $enemy);
          if ($this->user_dress["dvur"]) $this->addtactic($user, "krit", 1, $enemy);
        }
        $this->addhp2($user, $enemy, min(ceil($d), $starthp));
        $this->checkbackeffects($user, $enemy, min(ceil($d), $starthp));
      } else {
        // меня кританули
        $minpower=$mf['he']["udar$hitnum"];
        $mf["he"]["udar$hitnum"]=$mf["he"]["kritudar$hitnum"];
        if(!$noblock) {
          $hs = 0.5; $m = 'a';
        } else {
          $hs = 1; $m = '';

          $res=$this->checkpriemsparry($this->battleunits[$this->user["id"]]["priems"],$this->my_class,$this->user, $this->enemyhar["level"]);
          $parry=$this->get_chanse($this->user_dress["mfparir"]);
          if ($parry && $this->enemy_dress["skipuv"]>0) {
            if ($this->get_chanse($this->enemy_dress["skipuv"])) $parry=0;
          }

          if (@$res["parry"] || $parry) {
            $hs = 0.5; $m = 'p';
            if (!@$res["noparry"]) @$this->addtactic($user, "parry", 1, $enemy);
          } else{
            $shieldblock=$this->get_chanse($this->user_dress["mfshieldblock"]);
            if ($shieldblock && $this->enemy_dress["skipuv"]>0) {
              if ($this->get_chanse($this->enemy_dress["skipuv"])) $shieldblock=0;
            }
            if ($shieldblock) {
              $hs = 0.5; $m = 'b';
            }
          }
        }
        $minpower*=$hs;

        $res=$this->checkpriems1($this->battleunits[$this->currentenemy]["priems"],$this->en_class,$this->enemyhar, 1, $this->user["id"]);
        if ($res["maxkrit"]) $mf["he"]["udar$hitnum"]=$mf["he"]["maxkritudar$hitnum"];
        if ($res["skiparmor"]) {
          $mf["he"]["udar$hitnum"]=$mf["he"]["kritudarskiparmor$hitnum"];
        }
        if ($res["damageplus"]) $mf["he"]["udar$hitnum"]+=$res["damageplus"];
        if ($res["damagemult"]) $mf["he"]["udar$hitnum"]*=$res["damagemult"];
        if ($res["dieafter"]) {
          $this->takehp($this->userdata[$enemy]["hp"], $enemy, $this->userdata[$enemy]["hp"], 0);
          //echo "$enemy dies";
          //die;
          //$this->toupdate[$enemy]["die"]=1;
          //$this->needupdate=1;
          //$this->needrefresh=1;
        }
        $res=$this->checkpriems2($this->battleunits[$this->user["id"]]["priems"],$this->my_class,$user, 0, 0, 1, $mf["he"]["prof$hitnum"]);
        $mf["he"]["udar$hitnum"]=$this->processstrokeeffect2($res, $mf["he"]["udar$hitnum"]);
        if ($res["maxdamage"]) $hs=1;

        $mf['he']["udar$hitnum"]=notzero($mf['he']["udar$hitnum"]);
        //$this->damage[$enemy] += ceil($mf['he']["udar$hitnum"]*$hs);
        //$jv = ($this->user['hp']-ceil($mf['he']["udar$hitnum"]*$hs));
        $this->exp[$enemy] += $this->solve_exp ($enemy,$user,min(ceil($mf['he']["udar$hitnum"]*$hs),$this->user['hp']));
        $starthp=$this->userdata[$user]["hp"];
        $d=$this->takehp(ceil($mf['he']["udar$hitnum"]*$hs), $user, $this->user['hp'], 1, $enemy);

        $this->damage[$enemy]+=$d;
        //$this->exp[$enemy]+=$this->solve_exp($enemy,$user,min($d,$this->user['hp'])); Remove exp for force field

        if ($hs==1 && $this->userdata[$user]["hp"]<=0) {
          $this->addeffect($user, INJURY, 5, 0, "hp_travma", array(), 0, 0, 0, 0, $enemy);
        }


        $this->user['hp']-=$d;                                                                                                                                                                                           //$this->user['hp']
        $this->add_log ($this->razmen_log("krit".$m,$this->battle[$enemy][$user][$num==1?0:$num+1],$this->enemyhar["minimax$hn"]["weptype"],ceil($d),$enemy,$this->en_class,$user,$this->my_class,$this->userdata[$user]["hp"],$this->user['maxhp'], $defend, $prof), 1);
        if (!@$dontaddkrit) {
          if ($m) @$this->addtactic($enemy, "krit", 1, $user);
          else $this->addtactic($enemy, "krit", 2, $user);
          if ($this->enemy_dress["dvur"]) $this->addtactic($enemy, "krit", 1, $user);
        }
        $this->addhp2($enemy, $user, min(ceil($d), $starthp));
        $this->checkbackeffects($enemy, $user, min(ceil($d), $starthp));
      }
      $ret=2;
    } else {
      if ($who=="me") {
        if($noblock) {
          // я попал куда надо
          $res=$this->checkpriemsparry($this->battleunits[$this->currentenemy]["priems"],$this->en_class,$this->enemyhar, $this->user["level"]);
          $parry=$this->get_chanse($this->enemy_dress["mfparir"]);
          if ($parry && $this->user_dress["skipuv"]>0) {
            if ($this->get_chanse($this->user_dress["skipuv"])) $parry=0;
          }
          $shieldblock=$this->get_chanse($this->enemy_dress["mfshieldblock"]);
          if ($shieldblock && $this->user_dress["skipuv"]>0) {
            if ($this->get_chanse($this->user_dress["skipuv"])) $shieldblock=0;
          }

          if (@$res["parry"] || $parry) {
            $this->add_log ($this->razmen_log("parry",$attack,$this->user["minimax$hn"]["weptype"],0, $user, $this->my_class,$enemy,$this->en_class, 0, 0, $this->battle[$enemy][$user][1], $prof), 1);
            $mf['me']["udar$hitnum"]=ceil($mf['me']["udar$hitnum"]/2);
            if (!@$res["noparry"]) @$this->addtactic($enemy, "parry", 1, $user);
            //mq('UPDATE `users` SET `parry` = `parry` + 1 WHERE `id` = '.$enemy.'');
            $ret=0;
          } elseif ($shieldblock) {
            $this->add_log ($this->razmen_log("shieldblock",$attack,$this->user["minimax$hn"]["weptype"],0,$user,$this->my_class,$enemy,$this->en_class, 0, 0, $this->battle[$enemy][$user][1], $prof), 1);
            $mf['me']["udar$hitnum"]=ceil($mf['me']["udar$hitnum"]/2);
            @$this->addtactic($enemy, "block2", 1, $user);
            $ret=0;
          } else {
            $res=$this->checkpriems1($this->battleunits[$this->user["id"]]["priems"],$this->my_class,$this->user, 0, $enemy);
            if (@$res["skiparmor"]) {
              $mf["me"]["udar$hitnum"]=$mf["me"]["udarskiparmor$hitnum"];
            }
            if ($res["damageplus"]) $mf["me"]["udar$hitnum"]+=$res["damageplus"];
            if ($res["damagemult"]) $mf["me"]["udar$hitnum"]*=$res["damagemult"];
            if (@$res["dieafter"]) {
              $this->takehp($this->userdata[$user]["hp"], $user, $this->userdata[$user]["hp"], 0);
              //echo "$user dies";
              //die;
              //$this->toupdate[$user]["die"]=1;
              //$this->needupdate=1;
              //$this->needrefresh=1;
            }

            $res=$this->checkpriems2($this->battleunits[$this->currentenemy]["priems"],$this->en_class,$this->enemyhar["id"], 0, 0, 1, $mf["me"]["prof$hitnum"]);
            $mf["me"]["udar$hitnum"]=$this->processstrokeeffect2($res, $mf["me"]["udar$hitnum"]);

            $mf['me']["udar$hitnum"]=notzero($mf['me']["udar$hitnum"]);
            //@$this->damage[$user] += ($mf['me']["udar$hitnum"]);

            @$this->exp[$user] += $this->solve_exp ($user,$enemy,min($mf['me']["udar$hitnum"],$this->enemyhar["hp"]));

            $ff["value"]=$this->getforcefield($enemy);
            $starthp=$this->userdata[$enemy]["hp"];
            $d=$this->takehp($mf['me']["udar$hitnum"], $enemy, $this->enemyhar['hp'], 1, $user);

            @$this->damage[$user]+=$d;
            //@$this->exp[$user]+=$this->solve_exp($user,$enemy,min($d,$this->enemyhar["hp"])); Remove exp for force field

            if ($ff["value"]>=$mf['me']["udar$hitnum"]) {
              //$this->enemyhar['hp']-=$mf['me']["udar$hitnum"];
              $this->add_log ($this->razmen_log("udartoff",$attack,$this->user["minimax$hn"]["weptype"],$mf['me']["udar$hitnum"],$user,$this->my_class,$enemy,$this->en_class,$this->enemyhar['hp'], $this->enemyhar['maxhp'], $this->battle[$enemy][$user][1], $prof), 1);
            } else {
              $this->enemyhar['hp']=$this->enemyhar['hp']-$d;                                                                                                 //,$this->enemyhar['hp']
              $this->add_log ($this->razmen_log("udar",$attack,$this->user["minimax$hn"]["weptype"],$d,$user,$this->my_class,$enemy,$this->en_class,$this->userdata[$this->enemyhar['id']]["hp"], $this->enemyhar['maxhp'], $this->battle[$enemy][$user][1], $prof), 1);
            }
            @$this->addtactic($user, "hit", 1, $enemy);
            if ($this->user_dress["dvur"]) @$this->addtactic($user, "hit", 2, $enemy);
            $this->addhp2($user, $enemy, min(ceil($d),$starthp));
            $this->checkbackeffects($user, $enemy, min(ceil($d),$starthp));
            $ret=5;
          }
        } else {
          // я мазила
          $this->add_log ($this->razmen_log("block",$attack,$this->user["minimax$hn"]["weptype"],0,$this->user['id'],$this->my_class,$enemy,$this->en_class, 0, 0, $this->battle[$enemy][$user][1], $prof), 1);
          @$this->addtactic($enemy, "block2", 1, $user);
          //mq('UPDATE `users` SET `block2` = `block2` + 1 WHERE `id` = '.$enemy.'');
          $ret=0;
        }
      } else {
        if($noblock) {
          // противник попал куда надо
          //////////////////////////////////
          $res=$this->checkpriemsparry($this->battleunits[$this->user["id"]]["priems"],$this->my_class,$this->user, $this->enemyhar["level"]);
          $parry=$this->get_chanse($this->user_dress["mfparir"]);
          if ($parry && $this->enemy_dress["skipuv"]>0) {
            if ($this->get_chanse($this->enemy_dress["skipuv"])) $parry=0;
          }

          $shieldblock=$this->get_chanse($this->user_dress["mfshieldblock"]);
          if ($parry && $this->enemy_dress["skipuv"]>0) {
            if ($this->get_chanse($this->enemy_dress["skipuv"])) $shieldblock=0;
          }

          if (@$res["parry"] || $parry) {
            $this->add_log ($this->razmen_log("parry",$this->battle[$enemy][$user][$num==1?0:$num+1],$this->enemyhar["minimax$hn"]["weptype"],0,$enemy,$this->en_class,$user,$this->my_class, 0, 0, $defend, $prof), 1);
            $mf['he']["udar$hitnum"]=ceil($mf['he']["udar$hitnum"]/2);
            if (!@$res["noparry"]) @$this->addtactic($user, "parry", 1, $enemy);
            $ret=0;
          } elseif ($shieldblock) {
            $this->add_log ($this->razmen_log("shieldblock",$this->battle[$enemy][$user][$num==1?0:$num+1],$this->enemyhar["minimax$hn"]["weptype"],0,$enemy,$this->en_class,$user,$this->my_class, 0, 0, $defend, $prof), 1);
            $mf['he']["udar$hitnum"]=ceil($mf['he']["udar$hitnum"]/2);
            @$this->addtactic($user, "block2", 1, $enemy);
            $ret=0;
          } else {
            $res=$this->checkpriems1($this->battleunits[$this->currentenemy]["priems"],$this->en_class,$this->enemyhar,0,$this->user["id"]);
            if (@$res["skiparmor"]) {
              $mf["he"]["udar$hitnum"]=$mf["he"]["udarskiparmor$hitnum"];
            }
            if ($res["damageplus"]) $mf["he"]["udar$hitnum"]+=$res["damageplus"];
            if ($res["damagemult"]) $mf["he"]["udar$hitnum"]*=$res["damagemult"];
            if (@$res["dieafter"]) {
              $this->takehp($this->userdata[$enemy]["hp"], $enemy, $this->userdata[$enemy]["hp"], 0);
              //echo "$enemy dies";
              //die;
              //$this->toupdate[]["die"]=1;
              //$this->needupdate=1;
              //$this->needrefresh=1;
            }

            $res=$this->checkpriems2($this->battleunits[$this->user["id"]]["priems"],$this->my_class,$user, 0, 0, 1, $mf["he"]["prof$hitnum"]);
            $mf["he"]["udar$hitnum"]=$this->processstrokeeffect2($res, $mf["he"]["udar$hitnum"]);

            $mf['he']["udar$hitnum"]=notzero($mf['he']["udar$hitnum"]);
            //@$this->damage[$enemy] += ($mf['he']["udar$hitnum"]);
            //$jv = ($this->user['hp']-$mf['he']["udar$hitnum"]);
            @$this->exp[$enemy] += $this->solve_exp ($enemy,$user,min($mf['he']["udar$hitnum"], $this->user["hp"]));


            $ff["value"]=$this->getforcefield($user);
            $starthp=$this->userdata[$user]["hp"];
            $d=$this->takehp($mf['he']["udar$hitnum"], $user, $this->user['hp'], 1, $enemy);

            @$this->damage[$enemy]+=$d;
            //@$this->exp[$enemy]+=$this->solve_exp($enemy,$user,min($d, $this->user["hp"])); Remove exp for force field

            if ($ff["value"]>=$mf['he']["udar$hitnum"]) {
              $this->add_log ($this->razmen_log("udartoff",$this->battle[$enemy][$user][$num==1?0:$num+1],$this->enemyhar["minimax$hn"]["weptype"],$mf['he']["udar$hitnum"],$enemy,$this->en_class,$user,$this->my_class,$this->user['hp'], $this->user['maxhp'], $defend, $prof), 1);
            } else {
              $this->user['hp']=$this->user['hp']-$d;                                                                                                                                                               //,$this->user['hp']
              $this->add_log ($this->razmen_log("udar",$this->battle[$enemy][$user][$num==1?0:$num+1],$this->enemyhar["minimax$hn"]["weptype"],$d,$enemy,$this->en_class,$user,$this->my_class,$this->userdata[$user]["hp"], $this->user['maxhp'], $defend, $prof), 1);
            }
            @$this->addtactic($enemy, "hit", 1, $user);
            if ($this->enemy_dress["dvur"]) {
              @$this->addtactic($enemy, "hit", 2, $user);
            }
            $this->addhp2($enemy, $user, min(ceil($d), $starthp));
            $this->checkbackeffects($enemy, $user, min(ceil($d), $starthp));
            $ret=5;
          }
        } else {
          // противник мазила
          $this->add_log ($this->razmen_log("block",$this->battle[$enemy][$user][$num==1?0:$num+1],$this->enemyhar["minimax$hn"]["weptype"],0,$enemy,$this->en_class,$user,$this->my_class, 0, 0, $defend, $prof), 1);
          @$this->addtactic($user, "block2", 1, $enemy);
          $ret=0;
        }
      }
    }
    if ($ret==2 || $ret==5) {
      if ($who=="me") {
        if ($this->haseffect($user, "counter_deathwalk")) $this->addeffect($user, $strokes["counter_deathwalk"]->effect, $this->battleunits[$user]["level"], 0, "counter_deathwalk", array(), 0);
      } else {
        if ($this->haseffect($enemy, "counter_deathwalk")) $this->addeffect($enemy, $strokes["counter_deathwalk"]->effect, $this->battleunits[$enemy]["level"], 0, "counter_deathwalk", array(), 0);
      }
    }
    return $ret;
  }
  
  function checkbu($data) {
    if ($this->userdata[$data["id"]]["hp"]!=$data["hp"]) {
      $this->userdata[$data["id"]]["hp"]=$data["hp"];
      $this->needupdate=1;
    }
  }

/*-------------------------------------------------------------------
 создание класса и сбор основной инфы
--------------------------------------------------------------------*/
  function fbattle ($battle_id) {
    global $mysql, $user, $_POST, $textp, $leveldefs;

    // соединяем мускуль и юзера
    $this->mysql = $mysql;
    $this->user = $user;
    // перебираем варианты
    if ($battle_id > 0) {
      // ставим статус битвы на "есть битва"
      $this->status = 1;
      // вставляем драчующихся
      $this->battle_data = mysql_fetch_array(mq ('SELECT * FROM `battle` WHERE `id` = '.$battle_id.' LIMIT 1;'));

      if ($this->battle_data["type"]==UNLIMCHAOS) $leveldefs=array(250, 250, 250, 250, 250, 250, 250, 250, 250, 250, 250, 250, 250, 250, 250);

      if (USERBATTLE && !$this->battle_data && $battle_id==$user["battle"]) mq("update users set battle=0 where id='$user[id]'");
      if (!$this->battle_data["userdata"]) $this->userdata=array();
      else $this->userdata=unserialize($this->battle_data["userdata"]);
      if(USERBATTLE && $this->battle_data['room']<=0){mq('UPDATE `battle` SET `room` ='.$user['room'].'  WHERE `id` = '.$battle_id.';');}
      // получили дамагу
      $this->damage = unserialize($this->battle_data['damage']);
      // кто драчуется?
      $this->battle = unserialize($this->battle_data['teams']);

      $this->sort_teams();

      // получаем экспу
      $this->exp = unserialize($this->battle_data['exp']);
      // таймі
      $this->to1 = $this->battle_data['to1'];
      $this->to2 = $this->battle_data['to2'];

      // ============СИСТЕМА БОТОВ=================
      $bit1=0;
      $bit2=0;
      foreach ($this->battle as $k=>$v) {
        if ($k < _BOTSEPARATOR_) continue;
        $bot["id"]=$k;
        if (in_array($k, $this->t1)) {
          if (count($v)<count($this->t2)) {
            foreach ($this->t2 as $k2=>$v2) {
              $this->battle[$k][$v2]=array(0,0,time());
            }
          }
          $bit1=1;
        }
        if (in_array($k, $this->t2)) {
          if (count($v)<count($this->t1)) {
            foreach ($this->t1 as $k2=>$v2) {
              $this->battle[$k][$v2]=array(0,0,time());
            }
          }
          $bit2=1;
        }
        foreach ($this->battle[$bot['id']] as $k => $v) {
                                               // && ($k<_BOTSEPARATOR_ || !USERBATTLE)
          if($this->battle[$bot['id']][$k][0]==0) {
            mt_srand(microtime(true));
            //$chkwear_bot1 = mq('SELECT id FROM `inventory` WHERE (`type` = 3 AND `dressed` = 1) AND `owner` = '.$bot['prototype'].';');
            //while ($chkwear_bot = mysql_fetch_array($chkwear_bot1)) {
            //  $sumwear_bot++;
            //}
            //$sumwear_bot=mqfa1('SELECT count(id) FROM `inventory` WHERE (`type` = 3 AND `dressed` = 1) AND `owner` = '.$bot['prototype']);
            //$sumwear_bot=mqfa1("SELECT weapons from battleunits where user='$bot[id]' and battle='$battle_id'");
            $sumwear_bot=$this->userdata[$bot['id']]["weapons"];
            if($sumwear_bot>=5) $udar5=rand(1,5); else $udar5=0;
            if($sumwear_bot>=4) $udar4=rand(1,5); else $udar4=0;
            if($sumwear_bot>=3) $udar3=rand(1,5); else $udar3=0;
            if($sumwear_bot>=2) $udar2=rand(1,5); else $udar2=0;
            $this->battle[$bot['id']][$k] = array(rand(1,5),rand(1,5),time(),$udar2,$udar3,$udar4,$udar5);
            if ($this->battle[$k][$bot['id']][0]!=0 && $k<_BOTSEPARATOR_) $this->battle[$k][$bot['id']] = array(0,0,time(),0);
            if ($k>_BOTSEPARATOR_) $this->needupdate=1;
          }
          if($this->battle[$k][$bot['id']][0] == 0 && $k<_BOTSEPARATOR_) {
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

              if($endr && !$uje && 0) {
                $this->needupdate=1;
                $this->needrefresh=1;
                $uje = true;
                // если сдул - заканчиваем бой
                $this->add_log("<span class=date>".date("H:i")."</span> Бой закончен по таймауту.<BR>");
                //$this->write_log ();
                foreach ($this->battle[$bot['id']] as $k => $v) {
                  if($k > _BOTSEPARATOR_) {
                    $bots = mysql_fetch_array(mq ('SELECT `hp` FROM `bots` WHERE `id` = '.$k.' LIMIT 1;'));
                    $us['hp'] = $bots['hp'];
                  } else {
                    $us = mysql_fetch_array(mq('SELECT `hp` FROM `users` WHERE `id` = '.$k.' LIMIT 1;'));
                  }
                  if($us && (int)$us['hp']>0) {
                    $tr = settravma($k,0,86400,1);
                    if ($tr) $this->add_log('<span class=date>'.date("H:i").'</span> '.$this->nick7($k).' получил повреждение: <font color=red>'.$tr.'</font><BR>');
                  }
                }
                //$this->write_log ();
                foreach ($this->battle[$bot['id']] as $k => $v) {
                  $this->userdata[$k]["hp"]=0;
                  mq('UPDATE users SET `hp` =0, `fullhptime` = '.time().' WHERE `id` = '.$k.';');
                  mq('UPDATE users SET `mana` =0, `fullmptime` = '.time().' WHERE `id` = '.$k.';');
                }
              }
            }
          }
        }
      }
      $bb=$bit1+$bit2;
      if ($this->battle_data["needbb"]!=$bb) {
        mq("update battle set needbb='$bb' where id='".$this->battle_data["id"]."'");
      }

      if (USERBATTLE) {
        $this->getbu($user["id"]);
        //$this->checkbu($user);

        if ($this->battleunits[$user["id"]]["follow"] && $this->battleunits[$user["id"]]["follow"]!=$_POST['enemy'] &&
        $this->battle[$user["id"]][$this->battleunits[$user["id"]]["follow"]][0]==0) $_POST['enemy']=0;
//==============================================
        $this->user_hasshit=$this->checkshit($user['id']);
        $this->enemy=$this->getenemy();
        if(@$_POST['enemy'] && $this->enemy==$_POST['enemy'] && in_array($_POST['enemy'], $this->team_enemy)) {
          // ударяемся
          $this->razmen_init ($_POST['enemy'],$_POST['attack'],$_POST['defend'],@$_POST['attack1'],@$_POST['attack2'],@$_POST['attack3'],@$_POST['attack4']);
          //if (!NOREFRESH) header ("Location:fbattleb.php?fd=$_POST[enemy]");
        } else {
          foreach ((array)@$this->battle[$user["id"]] as $k=>$v) {
            if ($v[0] && $v[2]+$this->battle_data["timeout"]*60<time() && in_array($k, $this->team_enemy)) {
              if ($this->userdata[$k]["hp"]<=0) continue;
              $hitbytime=$k;
              $attack=$v[0];
              $defend=$v[1];
              $attack2=$v[3];
              $attack3=$v[4];
              $attack4=$v[5];
              $attack5=$v[5];
              $this->battle[$hitbytime][$user["id"]] = array(664,664);
              break;
            }
          }
          if ($hitbytime && in_array($hitbytime, $this->team_enemy)) {
            $this->razmen_init ($hitbytime,$attack,$defend,$attack2,$attack3,$attack4,$attack5);
          } else {
            $this->fast_death();
            // выбираем вражину
            $this->enemy=$this->getenemy();
            if (!$this->enemy) $this->enemy = (int)$this->select_enemy();

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
            if ($user["hp"]<=0) $this->return=2;
          }
        }
      }
      if (@$_POST['victory_time_out2']) {
        $this->end_draft();
      }
      if (@$_POST['victory_time_out']) {
        $this->end_gora();
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

  function sameteam($u1, $u2) {
    if (in_array($u1, $this->t1) && in_array($u2, $this->t1)) return true;
    if (in_array($u1, $this->t2) && in_array($u2, $this->t2)) return true;
    return false;
  }

  function getenemypriems() {
    if (!@$this->enemypriems) $this->enemypriems=$this->getpriems($this->enemy);
  }

/*-------------------------------------------------------------------
  проверка и выставление конца боя
--------------------------------------------------------------------*/

  function battle_end () {
    global $caverooms, $user, $cavebots;
    $this->fast_death();
    if($this->battle_data) {
      $t1=$this->t1;
      $t2=$this->t2;
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
      if ($this->battle_data["type"]==DTBATTLE && $t1life+$t2life>1) return false;
      elseif ($this->battle_data["type"]==DTBATTLE) {
        $w=array();
        $l=array();
        $this->t1=explode(";", $this->battle_data["t1"]);
        $this->t2=explode(";", $this->battle_data["t2"]);
        foreach ($this->t1 as $k=>$v) if (isset($this->battle[$v])) $w[]=$v;
        else $l[]=$v;
        foreach ($this->t2 as $k=>$v) if (isset($this->battle[$v])) $w[]=$v;
        else $l[]=$v;
        $this->t1=$w;
        $this->t2=$l;
        $t1life=1;
        $t2life=0;
      }
      $all=array_merge($this->t1, $this->t2);
      if($t2life == 0 OR $t1life == 0) {
        $charge = mysql_fetch_array(mq ('SELECT `win` FROM `battle` WHERE `id` = '.$this->battle_data['id'].' LIMIT 1;'));
      }
      if(($t2life == 0 OR $t1life == 0) && ($charge[0] == 3 || $charge[0] == 9)) {
        // ============================= конец боя ==========================

        foreach ($this->t1 as $k => $v) {
          $nks1[] = $this->nick7($v);
          $nks1hist[] = nick3($v);
          if ($v<_BOTSEPARATOR_ && !incommontower($user)) {
            $zver=mqfa("select zver_id, petunleashed from battleunits where user='$v' and battle=".$this->battle_data['id']);
            if ($zver["zver_id"]) {
              if ($zver["petunleashed"]) {
                mq("update users set sitost=sitost-".($this->battle_data["blood"]?10:5)." where id='$zver[zver_id]'");
                mq("update users set sitost=0 where id='$zver[zver_id]' and sitost<0");
              } else mq("update users set sitost=sitost-1 where id='$zver[zver_id]' and sitost>0");
            }
          }
        }
        foreach ($this->t2 as $k => $v) {
          $nks2[] = $this->nick7($v);
          $nks2hist[] = nick3($v);
          if ($v<_BOTSEPARATOR_ && !incommontower($user)) {
            $zver=mqfa("select zver_id, petunleashed from battleunits where user='$v' and battle=".$this->battle_data['id']);
            if ($zver["zver_id"]) {
              if ($zver["petunleashed"]) {
                mq("update users set sitost=sitost-".($this->battle_data["blood"]?10:5)." where id='$zver[zver_id]'");
                mq("update users set sitost=0 where id='$zver[zver_id]' and sitost<0");
              } else mq("update users set sitost=sitost-1 where id='$zver[zver_id]' and sitost>0");
            }
          }
        }
        if (incastle($this->battle_data["room"])) {
          foreach ($this->userdata as $k=>$v) {
            if ($v["hp"]<=0) {
              moveuser($k, 49);
              addchp ('<font color=red>Внимание!</font>Вы выбыли из битвы за клановый замок.', '{[]}'.$v['login'].'{[]}');
            }
          }
        }

        // тима победителей

        $maxdamage=0;
        $maxdamageuser=0;
        if(in_array($ss[0],$this->t1)) {
          mq('UPDATE `battle` SET `win` = 1 WHERE `id` = '.$this->user['battle'].' ;');
          if ($this->battle_data["quest"]==2) mq("update users set bot=0 where id=3313");
          $flag = 1;


          foreach ($this->t1 as $k => $v) {
            if ($this->battle_data["quest"]) addqueststep($v, $this->battle_data["quest"], 1/count($this->t1));
            if ($this->damage[$v]>$maxdamage) {
              $maxdamage=$this->damage[$v];
              $maxdamageuser=$v;
            }
            $this->t1[$k] = $this->nick5($v," ");
            $this->exp[$v] = round($this->exp[$v]);
            $warrior=mqfa("select * from users where id='$v'");
            getfeatures($warrior);

            if($warrior['align']==4) {
              $proc_exp=floor(proc_exp/2);
            } else {
              $proc_exp=proc_exp;
            }
            if ($warrior["zver_id"]) $zv=mqfa1("select petunleashed from battleunits where battle='$warrior[battle]' and user='$v'");
            //$zv=mysql_fetch_array(mq("SELECT `prototype`,`id` FROM `bots` WHERE `prototype` = '".$warrior['zver_id']."' and `battle` = ".$warrior['battle'].""));
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
                  mq('UPDATE `users` SET `exp` = `exp`+'.$esp.' WHERE id = '.$warrior['zver_id'].';');
                  addchp ('<font color=red>Внимание!</font> Ваш зверь получил <b>'.$esp.'</b> опыта.   ','{[]}'.nick7($warrior['id']).'{[]}');
                }
              }
              $this->exp[$v]=floor($this->exp[$v]/3*2);
              $animalexp[$warrior['id']]=1;
            } else $animalexp="";
            
            if ($warrior['klan']) {
              $klanexp1 = floor($this->exp[$v]/5);
              addchp ('<font color=red>Внимание!</font> Бой закончен. Всего вами нанесено урона: <b>'.(int)$this->damage[$v].' HP</b>. Получено кланового опыта: <b>'.$klanexp1.'</b>.  Получено опыта: <b>'.$this->exp[$v].'</b> ('.($proc_exp+$warrior["smart"]).'%).','{[]}'.nick7($v).'{[]}');
              //mq('UPDATE `users` SET `hp2` = 0,`hp3` = 0,`hit` = 0,`s_duh` = 0,`krit` = 0,`counter` = 0,`block2` = 0,`parry` = 0,`udar` = 0  WHERE `id` = '.$v.'');
              mq("DELETE FROM `person_on` WHERE `id_person`='".$v."'");
              mq("UPDATE `effects` SET `isp` = '0' WHERE `owner` = '".$v."'");
            } else {
              if ($v<_BOTSEPARATOR_) {
                addchp ('<font color=red>Внимание!</font> Бой закончен. Всего вами нанесено урона: <b>'.(int)$this->damage[$v].' HP</b>. Получено опыта: <b>'.$this->exp[$v].'</b> ('.($proc_exp+$warrior["smart"]).'%).','{[]}'.nick7($v).'{[]}');
                //mq('UPDATE `users` SET `hp2` = 0,`hp3` = 0,`hit` = 0,`s_duh` = 0,`krit` = 0,`counter` = 0,`block2` = 0,`parry` = 0,`udar` = 0  WHERE `id` = '.$v.'');
              }
              mq("DELETE FROM `person_on` WHERE `id_person`='".$v."'");
              mq("UPDATE `effects` SET `isp` = '0' WHERE `owner` = '".$v."'");
            }

            $vrag_w = mysql_fetch_array(mq("SELECT `name` FROM `bots` WHERE  `id` = ".$v." LIMIT 1 ;"));
            if($vrag_w['name']=="Общий Враг"){
              mq('UPDATE users SET `win`=`win` +1 WHERE `id` = 99;');
            }
            if ($this->battleunits[$v]["additdata"]) {
              $dat=$this->battleunits[$v]["additdata"];
            } else {
              $dat=implode("",file(CHATROOT."bus/$v.dat"));
              $dat=unserialize($dat);
            }
            if (!$dat["healed"]) $dat["healed"]=0;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               //.($dat["manahealed"]?", mana=if(mana>$dat[manahealed],mana-$dat[manahealed],1)":"")
            mq('UPDATE users SET `win`=`win` +1, `exp` = `exp`+'.$this->exp[$v].', `fullhptime` = '.time().', `fullmptime` = '.time().',`udar` = "0" '.($dat["healed"] || $this->userdata[$v]["extrahp"]?", hp=if(hp>$dat[healed],hp-$dat[healed]".($this->userdata[$v]["extrahp"]?"+".$this->userdata[$v]["extrahp"]:"").",if(hp>0,1".($this->userdata[$v]["extrahp"]?"+".$this->userdata[$v]["extrahp"]:"").",0))":"").' '.($this->userdata[$v]["extramana"]?", mana=if(".$this->userdata[$v]["extramana"]."+mana>maxmana,maxmana,".$this->userdata[$v]["extramana"]."+mana)":"").' WHERE `id` = '.$v.';');
            //mq("UPDATE clans SET `clanexp`=`clanexp`+10 WHERE `name` =  '{$this->user['klan']}';");
            if ($warrior['klan']) {
              $klanexp = $this->exp[$warrior['id']]/5;
              mq("UPDATE clans SET `clanexp`=`clanexp`+'{$klanexp}' WHERE `short` =  '{$warrior['klan']}';");
            }
          }

///////////////////////при победе = для подземки/////////////////////////////////////

$gess = mysql_query ('SELECT * FROM `labirint` WHERE `user_id` = '.$this->user['id'].'');

if($hokke = mysql_fetch_array($gess)){

$glav_id = $hokke["glav_id"];

$glava = $hokke["glava"];

$nm = $hokke["boi"];

/////////////////////////////////////////////////////////////

$DR = mysql_fetch_array(mysql_query("SELECT * FROM `canal_bot_bezdna` WHERE `glava`='$glava' and `boi`= '$nm'"));

if($DR){

$bot = $DR["bot"];

$nomer = $DR["nomer"];

////////////////////////////////////////////////////////////////

$shans1 = mt_rand(0,100);

$shans2 = mt_rand(0,100);

$shans3 = mt_rand(0,100);

$file = fopen("progs/pc.txt", "a+");

fputs($file, $shans1."-".$shans2."-".$shans3."\n");

fclose($file);

////////////////////////////////////////////////////////////////


//////////////////////////2 etaz//////////////////////////////

//////////длинный болт/////////////////




if($bot=='4.4'  or  $bot=='7.7'  or  $bot=='7.10'  or  $bot=='6.6'  or  $bot=='11.11'  or  $bot=='12.5'  or  $bot=='17.13'  or  $bot=='11.11.4'  or  $bot=='11.11.11'  or  $bot=='7.7.7'  or  $bot=='6.6.6'  or  $bot=='5.5.10'  or  $bot=='5.4.4'  or  $bot=='11.11.5'  or  $bot=='13.13.13'  or  $bot=='7.5.11.11'  or  $bot=='6.6.6.6'  or  $bot=='6.6.6.6.6.6.6' or  $bot=='6.6.6.6.6' or  $bot=='4.4.5.7.7.7.7.7'  or  $bot=='11.11.11.5'  or  $bot=='6.6.6.6.4'  or  $bot=='6.6.6.6.4.10'  or  $bot=='6.6.6.6.6.6' or

$bot=='1' 
 or  $bot=='2' 
  or  $bot=='3'
 or $bot=='4' 
   or  $bot=='5'
     or  $bot=='6' 
	  or  $bot=='7'  
	  or  $bot=='8'  or  $bot=='9'  or  $bot=='10'  or  $bot=='11'  or  $bot=='12'  or  $bot=='13'  or   $bot=='15'  or  $bot=='16'  or  $bot=='17'  or  $bot=='18'  or  $bot=='19'
){

mysql_query("UPDATE podzem_big3 SET n$nomer='' WHERE glava='$glava' and name='".$hokke["name"]."'");}

if($bot=='14' //Страж Даитон ghjgbcfnm lhjg
){
$shans_vesh=rand(0,100);
if($shans_vesh){$dvesh="503";
//запрос в базу инвентарь 

}else{$dvesh="";};
mysql_query("UPDATE podzem_big3 SET n$nomer='".$dvesh."' WHERE glava='$glava' and name='".$hokke["name"]."'");}

}}











//////////////////////////////////////////////////////////////////

          $winers .= implode("</B>, <B>",$this->t1);
          $winners=$t1;
          $lomka=$this->t2;

          include "incl/specialwin.php";
        } elseif(in_array($ss[0],$this->t2) && $this->battle_data["quest"]!=2) {

////////////////при пройгрыше = для поземки///////////////////

$sd=mysql_query("SELECT glav_id,boi,glava,dead FROM `labirint` WHERE `user_id`='".$this->user['id']."' and `di`='0'");

if($dd=mysql_fetch_array($sd)){

$glav_id = $dd["glav_id"];

$glava = $dd["glava"];

$nm = $dd["boi"];

mysql_query("DELETE FROM `canal_bot_bezdna` WHERE `boi`='$nm' and `glava`='$glava'");

if($dd["dead"]=='0'){$d = 1;}

if($dd["dead"]=='1'){$d = 2;}

if($dd["dead"]=='2'){$d = 3;}

$labirint=mysql_fetch_assoc(mysql_query("SELECT * FROM `labirint` where user_id='".$_SESSION['uid']."'"));

if($labirint['name']=='Бездна'){mysql_query("UPDATE `labirint` SET `location`='5',`vector`='0',`dead`='$d',`t`='226',`l`='454',`boi`='0',`di`='1',`name`='Бездна' WHERE `user_id`=".$this->user['id']."");}

elseif($labirint['name']=='Бездна 3 этаж'){mysql_query("UPDATE `labirint` SET `location`='5',`vector`='0',`dead`='$d',`t`='226',`l`='454',`boi`='0',`di`='1',`name`='Бездна 3 этаж' WHERE `user_id`=".$this->user['id']."");}

elseif($labirint['name']=='Бездна 2 этаж'){mysql_query("UPDATE `labirint` SET `location`='16',`vector`='0',`dead`='$d',`t`='226',`l`='454',`boi`='0',`di`='1',`name`='Бездна 2 этаж' WHERE `user_id`=".$this->user['id']."");}

elseif($labirint['name']=='Пещера тысячи проклятий'){mysql_query("UPDATE `labirint` SET `location`='04',`vector`='90',`dead`='$d',`t`='237',`l`='428',`boi`='0',`di`='1',`name`='Пещера тысячи проклятий' WHERE `user_id`=".$this->user['id']."");}

elseif($labirint['name']=='Пещера тысячи проклятий 2-Этаж'){mysql_query("UPDATE `labirint` SET `location`='04',`vector`='90',`dead`='$d',`t`='237',`l`='428',`boi`='0',`di`='1',`name`='Пещера тысячи проклятий' WHERE `user_id`=".$this->user['id']."");}



}

///////////////////////////////////

          mq('UPDATE `battle` SET `win` = 2 WHERE `id` = \''.$this->user['battle'].'\' ;');
          $flag = 2;
          $maxdamage=0;
          $maxdamageuser=0;
          foreach ($this->t2 as $k => $v) {
            $warrior=mqfa("select * from users where id='$v'");
            getfeatures($warrior);
            if ($this->battle_data["quest"]) addqueststep($v, $this->battle_data["quest"], 1/count($this->t2));
            if ($this->damage[$v]>$maxdamage) {
              $maxdamage=$this->damage[$v];
              $maxdamageuser=$v;
            }
            //mq('UPDATE `battle` SET `win` = 2 WHERE `id` = '.$warrior['battle'].' ;');
            $this->t2[$k] = $this->nick5($v,"");
            $this->exp[$v] = round($this->exp[$v]);
            if($warrior['align']==4){$proc_exp=floor(proc_exp/2);}else{$proc_exp=proc_exp;}
            if ($warrior["zver_id"]) $zv=mqfa1("select petunleashed from battleunits where battle='$warrior[battle]' and user='$v'");
            //$zv=mysql_fetch_array(mq("SELECT `prototype`,`id` FROM `bots` WHERE `prototype` = '".$warrior['zver_id']."' and `battle` = ".$warrior['battle'].""));
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
                mq('UPDATE `users` SET `exp` = `exp`+'.$esp.' WHERE `id` = '.$warrior['zver_id'].';');
                addchp ('<font color=red>Внимание!</font> Ваш зверь получил <b>'.$esp.'</b> опыта.   ','{[]}'.nick7($warrior['id']).'{[]}');
              }
              $this->exp[$v]=floor($this->exp[$v]/3*2);
            }
            if ($warrior['klan']) {
              $klanexp1 = floor($this->exp[$v]/5);
              addchp ('<font color=red>Внимание!</font> Бой закончен. Всего вами нанесено урона: <b>'.(int)$this->damage[$v].' HP</b>. Получено кланового опыта: <b>'.$klanexp1.'</b>. Получено опыта: <b>'.$this->exp[$v].'</b> ('.($proc_exp+$warrior["smart"]).'%).','{[]}'.nick7($v).'{[]}');
            } else {
              if ($v<_BOTSEPARATOR_) addchp ('<font color=red>Внимание!</font> Бой закончен. Всего вами нанесено урона: <b>'.(int)$this->damage[$v].' HP</b>. Получено опыта: <b>'.$this->exp[$v].'</b> ('.($proc_exp+$warrior["smart"]).'%).  ','{[]}'.nick7 ($v).'{[]}');
            }
            //mq('UPDATE `users` SET `hp2` = 0,`hp3` = 0,`hit` = 0,`s_duh` = 0,`krit` = 0,`counter` = 0,`block2` = 0,`parry` = 0,`udar` = 0  WHERE `id` = '.$v.'');
            mq("DELETE FROM `person_on` WHERE `id_person`='".$v."'");
            mq("UPDATE `effects` SET `isp` = '0' WHERE `owner` = '".$v."'");
            $vrag_w = mysql_fetch_array(mq("SELECT `name` FROM `bots` WHERE  `id` = ".$v." LIMIT 1 ;"));
            if($vrag_w['name']=="Общий Враг"){mq('UPDATE users SET `win`=`win` +1 WHERE `id` = 99;');}
            if ($this->battleunits[$v]["additdata"]) {
              $dat=$this->battleunits[$v]["additdata"];
            } else {
              $dat=implode("",file(CHATROOT."bus/$v.dat"));
              $dat=unserialize($dat);
            }
            if (!$dat["healed"]) $dat["healed"]=0;
            mq('UPDATE users SET `win`=`win`+1, `exp` = `exp`+'.$this->exp[$v].', `fullhptime` = '.time().', `fullmptime` = '.time().',`udar` = "0"'.($dat["healed"] || $this->userdata[$v]["extrahp"]?", hp=if(hp>$dat[healed],hp-$dat[healed]".($this->userdata[$v]["extrahp"]?"+".$this->userdata[$v]["extrahp"]:"").",if(hp>0,1".($this->userdata[$v]["extrahp"]?"+".$this->userdata[$v]["extrahp"]:"").",0))":"").' '.($dat["manahealed"]?", mana=if(mana>$dat[manahealed],mana-$dat[manahealed],1)":"").' WHERE `id` = '.$v.';');
            if ($warrior["klan"]) {
              $klanexp = $this->exp[$warrior['id']]/5;
              mq("UPDATE clans SET `clanexp`=`clanexp`+'{$klanexp}' WHERE `short` =  '{$warrior['klan']}';");
            }
          }
          $winers .= implode("</B>, <B>",$this->t2);
          $winners=$t2;
          $lomka=$this->t1;
        } else {
          if ($this->battle_data["quest"]!=2) mq("UPDATE battle SET `win` = 0 WHERE `id` = '".$this->battle_data["id"]."'");
          if (in_array($user["room"], $caverooms)) {
            $location=mqfa("select x, y, dir from caveparties where user='$user[id]'");
            if ($location["dir"]==0) {$y=$location["y"]*2;$x=($location["x"]-1)*2;}
            if ($location["dir"]==1) {$y=($location["y"]-1)*2;$x=$location["x"]*2;}
            if ($location["dir"]==2) {$y=$location["y"]*2;$x=($location["x"]+1)*2;}
            if ($location["dir"]==3) {$y=($location["y"]+1)*2;$x=$location["x"]*2;}
            mq("update cavebots set battle=0 where leader='$user[caveleader]' and x='$x' and y='$y'");
          }
        }
        include "config/questbots.php";
        include_once("questfuncs.php");
        foreach ((array)@$winners as $k=>$v) {
          $v=bottouser($v);
          if (@$questbots[$v]) {
            foreach ($lomka as $k1=>$v1) {
              addqueststep($v1, $questbots[$v]["questlose"], 5);
              makequest($questbots[$v]["questlose"],1,$v1);
            }
            break;
          }
        }

        //$dt=mqfa1("select value from variables where var='deztowtype'");
        $issiege=0;
        if (incastle($user["room"])) {
          $siege=getvar("siege");
          if ($siege<=10) $issiege=1;
        }
        if ($this->battle_data["type"]==UNLIMCHAOS) {
          if (count($this->userdata)>=5 && count($winners)>1) {
            if (count($this->userdata)<10) {
              $b=getchance(count($this->userdata)*10);
            } else $b=1;
            if ($b) {
              $winners1=$winners;
              foreach ($winners1 as $k=>$v) if ($v>_BOTSEPARATOR_) unset ($winners1[$k]);
              $b=$winners1[mt_rand(0, count($winners1)-1)];
              if ($b) {
                $r=mt_rand(1,3);
                if ($r==1) $a=takesmallitem(65, $b, "Бой $user[battle]");
                elseif ($r==2) $a=takesmallitem(66, $b, "Бой $user[battle]");
                else {
                  $r=mt_rand(1,4);
                  if ($r==4) $a=takeshopitem(5, "shop", 0, 0, 2, 0, $b);
                  elseif ($r==3) $a=takeshopitem(4, "shop", 0, 0, 2, 0, $b);
                  elseif ($r==2) $a=takeshopitem(2, "shop", 0, 0, 2, 0, $b);
                  else $a=takeshopitem(1, "shop", 0, 0, 2, 0, $b);;
                }
                addchp ('Персонаж <b>'.$this->nick7($b)."</b> получил предмет \"$a[name]\"","Комментатор", $this->user["room"]);
              }
            }
          }
        }

        include "incl/speciallose.php";
                                                                                                                      // || $user["id"]==7
        if ($this->battle_data["type"]==3 || $this->battle_data["type"]==5 || $this->battle_data["type"]==UNLIMCHAOS || ($user["in_tower"]==2) || $issiege) $canhavedrop=1;
        else $canhavedrop=0;
        if ($canhavedrop || LETTERQUEST) {          
          if (!$canhavedrop) $prc=1;
          elseif ($this->battle_data["room"]==63) $prc=100;  
          elseif ($issiege) $prc=90;
          elseif ($user["in_tower"]==2) $prc=40; 
          else $prc=20;
          //if ($user["id"]==7) $prc=100;
          foreach ($all as $k=>$v) {
            if ($v<_BOTSEPARATOR_) {       
              if ($this->damage[$v]>=$this->userdata[$v]["level"]*50) {
                if (getchance($prc)) {
                  $smallitem=0;
                  $item=0;
                  if ($canhavedrop) {
                    $rnd=rand(1,1000);
                    if ($rnd==2) $item=1982;
                    elseif ($rnd<=5) $item=1;
                    elseif ($rnd<=13) $item=2;
                    elseif ($rnd<=25) $item=4;
                    elseif ($rnd<=50) $item=5;
                    elseif (LETTERQUEST && $rnd<=150) $smallitem=62;
                    elseif ($rnd<=800) $smallitem=24+rand(0, 4);
                    elseif ($rnd<=850) $smallitem=37;
                    elseif ($rnd<=880) $smallitem=39;
                    elseif ($rnd<=900) $smallitem=42;
                    elseif ($rnd<=920) $smallitem=42;
                    elseif ($rnd<=930) $smallitem=43;
                    elseif ($rnd<=960) $smallitem=44;
                    elseif ($rnd<=980) $smallitem=45;
                    else $smallitem=46;
                  } elseif (LETTERQUEST) {
                    $smallitem=63;
                  }
                  if ($smallitem) $a=takesmallitem($smallitem, $v, "Бой $user[battle]");
                  else $a=takeshopitem($item, "shop", 0, 0, 2, 0, $v);
                  addchp ('Персонаж <b>'.$this->nick7($v)."</b> получил предмет \"$a[name]\"","Комментатор", $this->user["room"]);
                } elseif (SNOWBALLSDROP) {
                  $a=takeshopitem(2345, "shop", 0, 0, 2, 0, $v);
                  addchp ('Персонаж <b>'.$this->nick7($v)."</b> получил предмет \"$a[name]\"","Комментатор", $this->user["room"]);
                }
              }
            }
          }
        }

        foreach ((array)@$lomka as $k=>$v) {
          if ($v<_BOTSEPARATOR_) {
            $this->getbu($v);
            foreach ($this->battleunits[$v]["effects"] as $k1=>$v1) {
              if ($v1["effect"]==INJURY) {
                if (getchance($v1["value"])) {
                  $tr = settravma($v,1,60*30+(rand(0,30)*60),1);
                  if ($tr) $this->add_log('<span class=date>'.date("H:i").'</span> '.$this->nick7($v).' получил повреждение: <font color=red>'.$tr.'</font><BR>');
                }
              }
            }
          }
          $v=bottouser($v);
          if (@$questbots[$v]) {
            $c=0;
            foreach ($winners as $k1=>$v1) if ($v1<_BOTSEPARATOR_) $c++;
            foreach ($winners as $k1=>$v1) {
              $s=mqfa1("select step from quests where user='$v1' and quest='".$questbots[$v]["quest"]."'");
              if (rand(1,$questbots[$v]["itemchance"])<=$s) $giveitem[]=$v1;
              addqueststep($v1, $questbots[$v]["quest"], 1/$c);
            }
            if ($questbots[$v]["items"]) {
              //if (!@$giveitem) $this->add_log('<span class=date>'.date("H:i").'</span> Увы, Волк был сытым, и в зубах у него не было бедного зайца.<BR>');
              srand();
              shuffle($questbots[$v]["items"]);
              $item=array_pop($questbots[$v]["items"]);
              //$item=$questbots[$v]["items"][rand(0,count($questbots[$v]["items"]))-1];
              $smallitem=$questbots[$v]["smallitem"];
            }
            break;
          }
        }
        if (@$item && @$giveitem) {
          foreach ($giveitem as $k=>$v) {
            if ($smallitem) $a=takesmallitem($item, $v, "Бой $user[battle]");
            else $a=takeitem($item, 1, 0, $v);
            addchp ('Персонаж '.$this->nick7($v)." получил предмет \"$a[name]\"","Комментатор", $this->user["room"]);
          }
        }
        srand();
        foreach ((array)@$winners as $k=>$v) {
          if ($v>_BOTSEPARATOR_) continue;
          if (rand(0,10)==5 && 0) {
            $a=takesmallitem(18, $v, "Бой $user[battle]");
            $log=$this->nick7($v);
            addchp ("Персонаж $log получил предмет \"<b>$a[name]</b>\"","Комментатор", $this->user["room"]);
            $this->add_log('<span class=date>'.date("H:i")."</span> $log нашёл <b>$a[name]</b>.<BR>");
          }
        }

        if ($this->battle_data["quest"]==4 && $maxdamageuser) {
          include_once("questfuncs.php");
          takeitem(11, 1, 0, $maxdamageuser);
          addchp ('Феерверк получил персонаж '.$this->nick7($maxdamageuser),"Комментатор", 46);
        }
        //if ($this->battle_data["quest"]==2 && !@$flag) {
          //return;
        //}
        mq("UPDATE `users`, `bots` SET `users`.`fullhptime` = ".(time()+300).",`users`.`hp` = `bots`.`hp` WHERE `users`.id=83 AND `bots`.prototype=83;");


        // ===================ломаем шмот=============
        if ($lomka) {
          foreach ($lomka as $k => $v) {
            if (rand(1,3)==1){
              $us = mq('UPDATE `inventory` SET `duration`=`duration`+1 WHERE `type` <> 25 AND `type` <> 187 AND `dressed` = 1 AND `owner` = \''.$v.'\';');
            }
            if ($v<_BOTSEPARATOR_) {
              if ($this->userdata[$v]["level"]<=3) {
                $proc_exp=proc_exp;
                $this->exp[$v]=ceil($this->exp[$v]/7);
                mq("update users set exp=exp+".$this->exp[$v]." where id='$v'");
              } else $this->exp[$v]=0;
              addchp ('<font color=red>Внимание!</font> Бой закончен. Всего вами нанесено урона: <b>'.(int)$this->damage[$v].' HP</b>. Получено опыта: <b>'.$this->exp[$v].'</b> '.($this->exp[$v]?'('.($proc_exp).'%).':''), '{[]}'.nick7 ($v).'{[]}');
            } 
            //mq('UPDATE `users` SET `hp2` = 0,`hp3` = 0,`hit` = 0,`s_duh` = 0,`krit` = 0,`counter` = 0,`block2` = 0,`parry` = 0 ,`udar` = 0 WHERE `id` = '.$v.'');
            mq("DELETE FROM `person_on` WHERE `id_person`='".$v."'");
            mq("UPDATE `effects` SET `isp` = '0' WHERE `owner` = '".$v."'");
            $vrag_w = mysql_fetch_array(mq("SELECT `name` FROM `bots` WHERE  `id` = ".$v." LIMIT 1 ;"));
            if($vrag_w['name']=="Общий Враг"){mq('UPDATE users SET `lose`=`lose` +1 WHERE `id` = 99;');}
            mq('UPDATE `users` SET `lose`=`lose` +1 WHERE `id` = \''.$v.'\';');
            // если поединок был кровавым - еще и ставм травмы
          }
        }
        if ($this->battle_data["type"]!=4) {
          foreach ($this->t1 as $k => $v) {
            $us = mq('SELECT duration, maxdur, name FROM `inventory` WHERE `type` <> 25 AND `type` <> 187 and `dressed` = 1 AND `owner` = \''.$v.'\';');
            while ($rrow=mysql_fetch_row($us)) {
              if (($rrow[1]-$rrow[0])==1) $this->add_log('<span class=date>'.date("H:i").'</span> Внимание! У "'.$this->nick7($v).'" предмет "'.$rrow[2].'" в критическом состоянии! <BR><small>(на правах рекламы) <b>Ремонтная мастерская Virt-Life</b>. Мы даем вторую жизнь старым вещам!</small><BR>');
              elseif (($rrow[1]-$rrow[0])==2) $this->add_log('<span class=date>'.date("H:i").'</span> Внимание! У "'.$this->nick7($v).'" предмет "'.$rrow[2].'" нуждается в ремонте! <BR><small>(на правах рекламы) <b>Ремонтная мастерская Virt-Life</b>. Мы даем вторую жизнь старым вещам!</small><BR>');
            }
          }
          foreach ($this->t2 as $k => $v) {
            $us = mq('SELECT duration, maxdur, name FROM `inventory` WHERE `type` <> 25 AND `type` <> 187 AND `dressed` = 1 AND `owner` = \''.$v.'\';');
            while ($rrow=mysql_fetch_row($us)) {
              if (($rrow[1]-$rrow[0])==1) $this->add_log('<span class=date>'.date("H:i").'</span> Внимание! У "'.$this->nick7($v).'" предмет '.$rrow[2].' в критическом состоянии! <BR><small>(на правах рекламы) <b>Ремонтная мастерская Virt-Life</b>. Мы даем вторую жизнь старым вещам!</small><BR>');
              elseif (($rrow[1]-$rrow[0])==2) $this->add_log('<span class=date>'.date("H:i").'</span> Внимание! У "'.$this->nick7($v).'" предмет "'.$rrow[2].'" нуждается в ремонте! <BR><small>(на правах рекламы) <b>Ремонтная мастерская Virt-Life</b>. Мы даем вторую жизнь старым вещам!</small><BR>');
            }
          }
        }
        //==============================================
        if ($winners) {
          foreach ($winners as $k=>$v) if ($v>_BOTSEPARATOR_) $this->addbotwin($v,1);
          foreach ($lomka as $k=>$v) if ($v>_BOTSEPARATOR_) $this->addbotwin($v,2);
        } else {
          foreach ($t1 as $k=>$v) if ($v>_BOTSEPARATOR_) $this->addbotwin($v,3);
          foreach ($t2 as $k=>$v) if ($v>_BOTSEPARATOR_) $this->addbotwin($v,3);
        }

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
              if ($tr) $this->add_log('<span class=date>'.date("H:i").'</span> '.$this->nick7($v).' получил повреждение: <font color=red>'.$tr.'</font><BR>');
            }
          }
        } else {
          $this->add_log('<span class=date>'.date("H:i").'</span> '.'Бой закончен. Ничья.<BR>');
          foreach ($this->userdata as $k=>$v) {
            if ($k<_BOTSEPARATOR_) {
              if ($v["level"]<=1) {
                $proc_exp=proc_exp;
                $this->exp[$k]=ceil($this->exp[$k]/7);
                mq("update users set exp=exp+".$this->exp[$k]." where id='$k'");
              } else $this->exp[$k]=0;
              addchp ('<font color=red>Внимание!</font> Бой закончен. Всего вами нанесено урона: <b>'.(int)$this->damage[$k].' HP</b>. Получено опыта: <b>'.$this->exp[$k].'</b> '.($this->exp[$k]?'('.($proc_exp).'%).':''), '{[]}'.nick7 ($k).'{[]}');
            }
          }
          $vrag_w = mysql_fetch_array(mq("SELECT `name` FROM `bots` WHERE  `battle` = ".$this->user['battle']." LIMIT 1 ;"));
          if($vrag_w['name']=="Общий Враг"){mq('UPDATE users SET `nich`=`nich` +1 WHERE `id` = 99;');}
          mq("UPDATE users SET `nich` = `nich`+'1',`fullhptime` = ".time().",`fullmptime` = ".time().",`udar` = '0' WHERE `battle` = {$this->user['battle']}");

           ////////////////при пройгрыше = для подземки///////////////////
           $sd=mq("SELECT glav_id,boi,glava,dead,name FROM `labirint` WHERE `user_id`=".$this->user['id']." and `di`='0'");
           if($dd=mysql_fetch_array($sd)) {
             $glav_id = $dd["glav_id"];
             $glava = $dd["glava"];
             $nm = $dd["boi"];
             mq("DELETE FROM `canal_bot_bezdna` WHERE `boi`='$nm' and `glava`='$glava'");
             $podzname=mqfa1("select name from podzem2 where room='".($this->user["room"]-1)."' order by style");
             //mq("UPDATE `labirint` SET `location`='16',`vector`='0',`dead`='$d',`t`='226',`l`='454',`boi`='0',`di`='1',`name`='$podzname' WHERE `user_id`=".$warrior['id']."");
             mq("UPDATE `labirint` SET `location`='16',`vector`='0',`t`='226',`l`='454',`boi`='0',`di`='1',`name`='$podzname' WHERE `glav_id`=".$dd['glav_id']." and name='$dd[name]' and boi='$dd[boi]'");
             //echo "UPDATE `labirint` SET `location`='16',`vector`='0',`dead`=dead+1,`t`='226',`l`='454',`boi`='0',`di`='1',`name`='$podzname' WHERE `glav_id`=".$dd['glav_id']." and name='$dd[name]' and boi='$dd[boi]'<br>";
           }
           ///////////////////////////////////

          mq("UPDATE `effects` SET `isp` = '0' WHERE `owner` = '".$this->user['id']."'");
        }

        if ($this->battle_data["room"]==72) {
          foreach ($this->userdata as $k=>$v) {
            if ($v["hp"]>0) mq("insert into effects set owner='$k', name='Защита от нападений', time=".(time()+60).", isp=1, type=".PROTFROMATTACK);
          }
        }

        // sys
        if ($flag==1) {
          $rr = implode("</B>, <B>",$nks1)."<img src=".IMGBASE."/i/flag.gif></B> и <B>".implode("</B>, <B>",$nks2);
        } elseif ($flag==2) {
          $rr = implode("</B>, <B>",$nks1)."</B> и <B>".implode("</B>, <B>",$nks2)."<img src=".IMGBASE."/i/flag.gif>";
        } else {
          $rr = implode("</B>, <B>",$nks1)."</B> и <B>".implode("</B>, <B>",$nks2)."";
        }
        // выносим хп-ку и выходим из боя

        mq('UPDATE `battle` SET `t1hist` = \''.implode(", ",$nks1hist).'\', `t2hist` = \''.implode(", ",$nks2hist).'\' WHERE `id` = '.$this->battle_data['id'].' ;');
        addch ("<a href=logs.php?log=".$this->battle_data['id']." target=_blank>Поединок</a> между <B>".$rr."</B> закончен.   ",$user['room']);
        mq('UPDATE `battle` SET `exp` = \''.serialize($this->exp).'\' WHERE `id` = '.$this->battle_data['id'].' ;');
        mq("DELETE FROM `bots` WHERE `battle` = {$this->user['battle']};");
        mq("DELETE FROM battleunits WHERE `battle` = {$this->user['battle']};");
        mq("UPDATE users SET battle=0, `fullhptime` = ".time().", `fullmptime` = ".time()." WHERE `battle`=".$this->battle_data['id']);
        mq("DELETE FROM `battleeffects` WHERE `battle` = {$this->user['battle']};");
        foreach($t1 as $k=>$v) {
          unlink(CHATROOT."bus/$v.dat");
        }
        foreach($t2 as $k=>$v) {
          unlink(CHATROOT."bus/$v.dat");
        }
        unset($this->battle);
        //header("Location: fbattleb.php");  die();
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
              $this->needupdate=1;
              //$this->needrefresh=1;

              foreach ($this->team_enemy as $v => $k) {
                  if($k > _BOTSEPARATOR_) {
                      $bots = mysql_fetch_array(mq ('SELECT `hp` FROM `bots` WHERE `id` = '.$k.' LIMIT 1;'));
                      $us['hp'] = $bots['hp'];
                  } else {
                      $us = mysql_fetch_array(mq('SELECT `hp` FROM `users` WHERE `id` = '.$k.' LIMIT 1;'));
                  }
                  if($us && (int)$us['hp']>0) {
                      if(!$this->battle_data['blood']) {
                          $tr = settravma($k,0,86400,1);
                          if ($tr) $this->add_log('<span class=date>'.date("H:i").'</span> '.$this->nick7($k).' получил повреждение: <font color=red>'.$tr.'</font><BR>');
                      }
                  }
              }
              //$this->write_log ();
              foreach ($this->team_enemy as $v => $k) {
                $this->userdata[$k]["hp"]=0;
                mq('UPDATE users SET `hp` =0, `fullhptime` = '.time().', `fullmptime` = '.time().' WHERE `id` = '.$k.';');
              }
              //header("Location: fbattleb.php?fd=all&batl=".$this->user['battle']);
          }
  }

/*-------------------------------------------------------------------
  draft - ничья
--------------------------------------------------------------------*/
  function end_draft() {
      if(!$this->user['in_tower']) {
          if ($this->get_timeout()) {
              $this->battle = null;                                                                                                                                
              mq("UPDATE users SET `battle` =0, `nich` = `nich`+'1',`fullhptime` = ".time().",`fullmptime` = ".time()." WHERE `battle` =".$this->battle_data['id']);
              //mq('UPDATE `users` SET `hp2` = 0,`hp3` = 0,`hit` = 0,`s_duh` = 0,`krit` = 0,`counter` = 0,`block2` = 0,`parry` = 0  WHERE `battle` = '.$this->user['battle'].'');
              $this->add_log("<span class=date>".date("H:i")."</span> Бой закончен по таймауту. Ничья.<BR>");
              mq("UPDATE battle SET `win` = 0 WHERE `id` = {$this->user['battle']}");
              $this->exp = null;
              $this->write_log ();
          }
      }
  }

function killplayer($us) {
  if ($us==(int)$us) {
    $us=array("id"=>$us);
  }
  if (!in_array($us["id"],array_keys($this->battle))) return;
  //if (!isset($this->battle[$us["id"]])) return;
  $this->needupdate=1;
  //$us - id, sex, battle
  //$battle_data = mysql_fetch_array(mq ('SELECT * FROM `battle` WHERE `id` = '.$this->user['battle'].' LIMIT 1;'));
  //$war = unserialize($battle_data['teams']);
  // unset($battle_data);
  //$war=array_keys($war);
  // if(in_array($k,$war)) {
  $udata=$this->gethpduh($us["id"]);
  if ($udata["hp"]>0) {
    $this->userdata[$us["id"]]["hp"]=$udata["hp"];
    return;
  } elseif (!isset($us["maxhp"])) {
    if ($us["id"]<_BOTSEPARATOR_) {
      $us["maxhp"]=$udata["maxhp"];
      $us["sex"]=$udata["sex"];
    } else {
      $rec=mqfa("select maxhp, sex from users where id='$udata[prototype]'");
      $us["maxhp"]=$rec["maxhp"];
      $us["sex"]=$rec["sex"];
    }
  }
  $this->getbu($us["id"]);
  if ($this->battleunits[$us["id"]]["resurrect"]>0 && $udata["s_duh"]>=100 && $this->toupdatebu[$us["id"]]["resurrect"]!=-1) {
    
    //$this->addhp(ceil($udata["maxhp"]*0.35),$us["id"],0);
    $this->toupdate[$us["id"]]["sethp"]=round($udata["maxhp"]*0.35);
    $this->userdata[$i]["hp"]=round($udata["maxhp"]*0.35);
    if ($i==$this->user["id"]) $this->user["hp"]=round($udata["maxhp"]*0.35);

    $this->toupdate[$us["id"]]["setmana"]=round($this->userdata[$us["id"]]["maxmana"]*0.25);
    $this->userdata[$i]["mana"]=round($this->userdata[$us["id"]]["maxmana"]*0.25);
    if ($i==$this->user["id"]) $this->user["mana"]=round($this->userdata[$us["id"]]["maxmana"]*0.25);

    if ($this->battleunits[$us["id"]]["spirit"]>=75) $nduh=5; else $nduh=10;
    takespirit($us["id"], $nduh);
    //if ($udata["s_duh"]<$nduh) $this->toupdate[$us["id"]]["s_duh"]=-$udata["s_duh"];
    //else $this->toupdate[$us["id"]]["s_duh"]-=$nduh;
    @$this->toupdatebu[$us["id"]]["resurrect"]=-1;
    $this->needupdatebu=1;
    //$this->needrefresh=1;
    $nick=$this->nick5($us["id"],'b');
    if ($this->battleunits[$us["id"]]["spirit"]>=25) {
      $this->addstroke("spirit_block25", $us["id"], 2);
    }
    if($us['sex'] == 1) {
      //$blablа = array('побежден великим войном по имени ','повержен ударом воителя, известного под именем ','проиграл бой с небольшой помощью от бойца, известного в этом мире, как','погиб от удара бойца');      
      $this->add_log('<span class=sysdate>'.date("H:i").'</span> '.$nick.' побеждён... '.$nick.' спасён.<BR>');
    } else {
      //$blabla1 = array('побеждена великим войном по имени ','повержена ударом воителя, известного под именем ','проиграла бой с небольшой помощью от бойца, известного в этом мире, как','погибла от удара бойца');
      $this->add_log('<span class=sysdate>'.date("H:i").'</span> '.$nick.' проиграла... '.$nick.' спасена.<BR>');
    }
  } else {
    if ($us["id"]<_BOTSEPARATOR_) {
      $k=$this->userdata[$us["id"]]["killer"];
      $this->getbu($k);
      $killer=array("id"=>$k, "level"=>$this->userdata[$k]["level"]);
      $killed=$this->userdata[$us["id"]]["level"];
      //$killer=mqfa("select id, level, s_duh from users where id='".$this->userdata[$us["id"]]["killer"]."'");
      //$killed=mqfa1("select level from users where id='".$us["id"]."'");
      if ($killed>$killer["level"]) {
        takespirit($killer["id"], -1);
        //$this->toupdate[$killer["id"]]["s_duh"]=100;
      } elseif ($killed<$killer["level"]) {
        takespirit($killer["id"], 1);
        //if ($killer["s_duh"]>=100) $this->toupdate[$killer["id"]]["s_duh"]=-100;
        //elseif ($killer["s_duh"]>0) $this->toupdate[$killer["id"]]["s_duh"]=-$killer["s_duh"];
      }
    }

    if(bottouser($us['id'])==99) {
      //$battle_datav = mysql_fetch_array(mq ('SELECT t1 FROM `battle` WHERE `id` = '.$us['battle'].' LIMIT 1;'));
      $t1v = explode(";",$this->battle_data["t1"]);
      foreach ($t1v as $ff => $ll) {
        $zashc = mysql_fetch_array(mq("SELECT name FROM `effects` WHERE `owner` = ".$ll." and `type`=395 limit 1;"));
        if(!$zashc) {
          mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".$ll."','Защитник клуба',".(time()+2592000).",395);");
        } else {
          mq("UPDATE `effects` `time` = '".(time()+2592000)."' WHERE `owner` = ".$ll." AND `type`=395");
        }
      }
    }
    if($us['sex'] == 1) {
      //$blablа = array('побежден великим войном по имени ','повержен ударом воителя, известного под именем ','проиграл бой с небольшой помощью от бойца, известного в этом мире, как','погиб от удара бойца');
      $this->add_log('<span class=sysdate>'.date("H:i").'</span> '.$this->nick5($us["id"],'b').' побежден!<BR>');
    } else {
      //$blabla1 = array('побеждена великим войном по имени ','повержена ударом воителя, известного под именем ','проиграла бой с небольшой помощью от бойца, известного в этом мире, как','погибла от удара бойца');
      $this->add_log('<span class=sysdate>'.date("H:i").'</span> '.$this->nick5($us["id"],'b').' проиграла!<BR>');
    }
    if ($us["id"]<_BOTSEPARATOR_) mq('UPDATE `users` SET `hp` = 0, `fullhptime` = '.time().', `fullmptime` = '.time().' WHERE `id` = \''.$us["id"].'\' LIMIT 1;');
    $this->remplayer($us["id"]);
  }
  $this->needupdate=1;
}

function remplayer($user) {
  unset($this->battle[$user]);
  foreach ($this->battle as $k=>$v) {
    unset($this->battle[$k][$user]);
  }
  foreach ($this->battleunits[$user]["effects"] as $k=>$v) {
    $tmp=explode("-",$k);
    if ($tmp[1]=="oncaster") {
      $this->getbu($v["caster"]);
      $this->remeffect($v["caster"], $tmp[0]);
      $this->logstrokeend($tmp[0], $v["caster"]);
    }
  }
}

/*-------------------------------------------------------------------
 мочим трупов
--------------------------------------------------------------------*/
  function fast_death() {
    global $user;
    // убиваем трупов
    if($this->battle) {
      $i=0;
      //$this->battle[$this->user['id']]=1;
      foreach($this->battle as $k=>$v) {
        if (!@$this->userdata[$k]) {
          $this->getbu($k);
        } else {
          $us=$this->userdata[$k];
          $us["battle"]=$this->user["battle"];
        }
        if($us && (int)$us['hp']<=0) {
          $us["sex"]=mqfa1("select sex from users where id='".bottouser($k)."'");
          $us["battle"]=$this->user["id"];
          $us["id"]=$k;
          $this->killplayer($us);
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
    }
  }
/*-------------------------------------------------------------------
 выставляем команды, и противников/союзников
--------------------------------------------------------------------*/
  function sort_teams() {
    global $user;
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
    if ($this->battle_data["type"]==DTBATTLE) {
      $this->t1=array();
      $this->t2=array();
      foreach ($this->battle as $k=>$v) {
        if ($k==$user["id"]) $this->t1[]=$k;
        else $this->t2[]=$k;
      }
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
    $this->myteam=(in_array($this->user['id'],$this->t1)?1:2);
  }
/*-------------------------------------------------------------------
 считаем опыт
--------------------------------------------------------------------*/
function solve_exp ($at_id,$def_id,$damage) {
  if ($at_id>_BOTSEPARATOR_ || $damage<0) return 0;
  global $user, $chardata;
  $lowexpusers=array(5080, 11125, 11129);
  include_once("config/chardata.php");

  require('exp_koef.php');
  if ($user["in_tower"]==1 || $user["in_tower"]==2) $mods['bloodb']=2;
  $velikaya=30;
  $velichayshaya=50;
  $epohalnaya =100;

//echo __FILE__." ".__LINE__."<br>----<br>";
//print_r($mods);

//echo "<br>----<br>".$mods["udar"];

  $baseexp = array("0" => "5", "1" => "10", "2" => "20", "3" => "30", "4" => "60", "5" => "120", "6" => "180", "7" => "230", "8" => "350", "9" => "500", "10" => "800", "11" => "1500", "12" => "2000", "13" => "3000", "14" => "5000", "15" => "7000");
  if($at_id > _BOTSEPARATOR_ || $def_id > _BOTSEPARATOR_) $bot_active=true;
                    /*if($at_id > _BOTSEPARATOR_) {
                      $bots = mysql_fetch_array(mq ('SELECT * FROM `bots` WHERE `id` = '.$at_id.' LIMIT 1;'));
                      $at_id = $bots['prototype'];
                      $bot_active = true;
                    }*/
                    if ($at_id==$this->user["id"]) $at=$this->user;
                    elseif ($at_id==$this->enemyhar["id"]) $at=$this->enemyhar;
                    else $at = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '".bottouser($at_id)."'"));
                    $at_cost[0]=$this->battleunits[$at_id]["cost"]+1;
                    $kulak1=$this->battleunits[$at_id]["cost"];
                    //$at_cost = mysql_fetch_array(mq("select 1+IFNULL((select SUM(cost)+(SUM(ecost)*10) FROM inventory WHERE owner = users.id AND dressed=1),0), `align` FROM users WHERE id = ".$at_id." LIMIT 1;"));
                    //$kulak1 = mysql_fetch_array(mq("select SUM(cost)+(SUM(ecost)*10) FROM inventory WHERE owner = ".$at_id." AND dressed=1 LIMIT 1;"));

                    /*if($def_id > _BOTSEPARATOR_) {
                      $bots = mysql_fetch_array(mq ('SELECT * FROM `bots` WHERE `id` = '.$def_id.' LIMIT 1;'));
                      $def_id = $bots['prototype'];
                      $bot_def=true;
                    }*/
                    if ($def_id==$this->user["id"]) $def=$this->user;
                    elseif ($def_id==$this->enemyhar["id"]) $def=$this->enemyhar;
                    else $def = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '".bottouser($def_id)."'"));
                    $di=bottouser($def_id);
                    foreach ($chardata as $k=>$v) {
                      if ($v["id"]==$di) {
                        $qb=$k;
                        break;
                      }
                    }
                    if ($qb) {
                      if ($chardata[$qb]["incexp"]) {
                        $this->getbu($def_id);
                        $def["level"]+=floor(($this->battleunits[$def_id]["sila"]+$this->battleunits[$def_id]["lovk"]+$this->battleunits[$def_id]["inta"]+$this->battleunits[$def_id]["vinos"])/($chardata[$qb]["levelstats"]*5));
                        if ($def["level"]>15) $def["level"]=15;
                      }
                    }
                    $def_cost[0]=$this->battleunits[$def_id]["cost"]+1;
                    $kulak2=$this->battleunits[$def_id]["cost"];
                    if ($user["in_tower"]==1) {
                      $l=mqfa1("select level from deztow_realchars where owner='$at[id]'");
                      if ($l) {
                        $at["level"]=$l;
                        $def["level"]=$l;
                      }
                    } elseif ($user["in_tower"]==56) {
                      $at["level"]=7;
                      $def["level"]=7;
                      $def_cost[0]=1;
                      $kulak2=1;
                      $at_cost[0]=1;
                      $kulak1=1;
                    }
                    /*$def = mysql_fetch_array(mq("SELECT * FROM `users` WHERE `id` = '".$def_id."' LIMIT 1;"));
                    $def_cost = mysql_fetch_array(mq("select 1+IFNULL((select SUM(cost)+(SUM(ecost)*8) FROM inventory WHERE owner = users.id AND dressed=1),0), `align` FROM users WHERE id = ".$def_id." LIMIT 1;"));
                    $kulak2 = mysql_fetch_array(mq("select SUM(cost)+(SUM(ecost)*10) FROM inventory WHERE owner = ".$def_id." AND dressed=1 LIMIT 1;"));*/

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

/*$zv33=mysql_fetch_array(mq("SELECT `prototype`,`id` FROM `bots` WHERE `prototype` = '".$user['zver_id']."' and `battle` = ".$user['battle'].""));
if($zv33){
$expmf=floor(($expmf/3)*2);
}*/
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
                        if ($this->battle_data['type']==1 && 0) {
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
                    $standart = array("0" => 1, "1" => 1, "2" => 15, "3" => 111, "4" => 265, "5" => 526, "6" => 882, "7" => 919, "8" => 919, "9" => 919, "10" => 1119, "11" => 1300);
                    $mfit = ($at_cost[0]/($standart[$at['level']]/3));
                    if ($mfit < 0.8) { $mfit = 0.8; }
                    if ($mfit > 1.5) { $mfit = 1.5; }
                    if ($at['level']>=11) $mfit=0.8;

                    /*if ($bot_active == true) {
                        $this->exp[$at_id] += ($baseexp[$def['level']])*($def_cost[0]/(($at_cost[0]+$def_cost[0])/2))*($damage/$def['maxhp'])*$expmf*$mfit*0.3;

                    }*/
                    $pls=count($this->t1)+count($this->t2);
                    if ($pls>2) {
                      $mfbot= $bot_active == true ? 0.7:1;
                      $mfbot2=$bot_def == true ? 0.7:1;
                    } else {
                      $mfbot= $bot_active == true ? 0.98:1;
                      $mfbot2=$bot_def == true ? 0.98:1;
                    }
                        //$mfbot=1;
                        //$mfbot2=1;

                    if ($def_cost[0]<$at_cost[0]) $def_cost[0]=$at_cost[0];
                    //if ($def_cost[0]/$at_cost[0]<0.3) $at_cost[0]=$def_cost[0]*3;
                //if ($def_id==36) $expmf=$expmf*1.1;
                if ($def_id==38 || $def_id==39) $expmf=$expmf*2;
                if ($at_id==6954 && $this->battleunits[$at_id]["level"]<11) $expmf*=2.0;
                $max1=1000;
                $max2=600;
                if ($def['maxhp']>($def_id>_BOTSEPARATOR_?$max1:$max2)) $def['maxhp']=($def_id>_BOTSEPARATOR_?$max1:$max2);
                if ($bot_active) {
                   if ($user["level"]==1) $expmf*=0.80;
                   elseif ($user["level"]==2) $expmf*=0.60;
                   elseif ($user["level"]==3) $expmf*=0.40;
                   elseif ($user["level"]>0) $expmf*=0.20;
                }  
                if (in_array($def_id, $lowexpusers)) $expmf*=0.2;
                if($expmf==0) $expmf=1;

if($user['room']=='403' || $user['room']=='903'){
                $result = (($baseexp[$def['level']])*($damage/$def['maxhp'])*$expmf*$mfit*$mfbot*$mfbot2)/9;
} else {
                $result = ($baseexp[$def['level']])*($def_cost[0]/(($at_cost[0]+$def_cost[0])/2))*($damage/$def['maxhp'])*$expmf*$mfit*$mfbot*$mfbot2;
}

               $debug_result = "\r\nEXP baseexp[def['level']])=".$baseexp[$def['level']]
        .") * (def_cost[0]=".$def_cost[0]."/((at_cost[0]".$at_cost[0]."+ def_cost[0]=".$def_cost[0]
        .")/2))*(damage=".$damage."/def['maxhp']=".$def['maxhp'].")* expmf=".$expmf
        ." * mfit=".$mfit." * mfbot=".$mfbot."* mfbot2=".$mfbot2. " => ". $result."";
            //$this->add_debug($debug_result);

                //($baseexp[$def['level']])*($def_cost[0]/(($at_cost[0]+$def_cost[0])/2))*($damage/$def['maxhp'])*$expmf*$mfit*$mfbot*$mfbot2;
$result = $result/100*proc_exp;
if ($this->battleunits[$at_id]["expbonus"]) $result*=1+($this->battleunits[$at_id]["expbonus"]/100);
//if ($_SESSION["uid"]==7) include "test.php";
//echo "$damage/$result<br>";
//die;
                    return $result;
            }
/*-------------------------------------------------------------------
 инициализируем размен
--------------------------------------------------------------------*/
function razmen_init ($enemy,$attack,$defend,$attack1,$attack2,$attack3,$attack4) {
    global $user, $strokes;

    //if ($_SESSION["uid"]==7) include 'incl/razmen2.php'; else
    $this->currentenemy=$enemy;
    include 'incl/razmen.php';
    if($this->enemy > 0) {
      // табличка удара-блока
      $this->return = 1;
    } else {
      //проверяем тайм
      if ($this->get_timeout() && $user['hp'] > 0) {
        // табличка тайма
        $this->return = 3;
      } else {
        // ожидаем хода...
        $this->return = 2;
      }
    }
    if ($user["hp"]<=0) $this->return=2;
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
  $wep = mysql_fetch_array(mq('SELECT `otdel`,`minu` FROM `inventory` WHERE `id` = '.$idwep.' LIMIT 1;'));
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

function otdeltoweptype($otdel) {
  if($otdel== 1) {
    return "noj";
  } elseif($otdel==12) {
    return "dubina";
  } elseif($otdel==11) {
    return "topor";
  } elseif($otdel==13) {
    return "mech";
  } elseif($otdel==30) {
    return "posoh";
  } else {
    return "kulak";
  }
}
/*------------------------------------------------------------------
 генератор ударов =)
--------------------------------------------------------------------*/
function razmen_log($type,$kuda,$chem,$uron,$kto,$c1,$pokomy,$c2,$hp,$maxhp, $block, $prof=0) {
  global $takenbybarrier;
  if ($uron==0) $uron="-";
  if ($this->battleunits[$pokomy]["defender"]) {
    //if (!$this->battleunits[$pokomy]["defenderblock"]) $block=0;
    if (!$this->sameteam($pokomy, $this->battleunits[$pokomy]["defender"])) $c2=$c1;
    $pokomy=$this->battleunits[$pokomy]["defender"];
    $hp=$this->userdata[$pokomy]["hp"];
    $maxhp=$this->userdata[$pokomy]["maxhp"];
  }
  $ret="<!--$kto/$pokomy/$kuda/";
  if ($this->battleunits[$pokomy]["blockzones"]>=3) $bz=3; 
  elseif ($this->battleunits[$pokomy]["blockzones"]==2) $bz=2;
  else $bz=1;
  $b1=$block;
  $ret.=$b1;
  if ($bz>=2) {
    $b1++;
    $ret.=($b1>5?$b1-5:$b1);
  }
  if ($bz>=3) {
    $b1++;
    $ret.=($b1>5?$b1-5:$b1);
  }
  $ret.="/$uron/$type-->";
  $hp=round($hp);
  $maxhp=round($maxhp);
  $nick5pokomy=$this->nick5($pokomy,$c2);
  $hits=$this->hits($kuda, $block, $pokomy, $c1);
  if (strpos($nick5pokomy,"<i>невидимка</i>")) {
    $hp="??";
    $maxhp="??";
  }
  if ($uron<0) $uron=0;
  //$this->write_stat($this->nick5($kto,$c1)."|++|".$nick5pokomy."|++|".$type."|++|".$uron."|++|".$kuda."|++|".$chem);
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
  if ($kto>_BOTSEPARATOR_) {
    if ($this->battleunits[$kto]["prototype"]==11112) $textchem=array("лапой");
    if ($this->battleunits[$kto]["prototype"]==11112) $textchem=array("лапой", "когтями");
    if ($this->battleunits[$kto]["prototype"]==11113) $textchem=array("хвостом");
    if ($this->battleunits[$kto]["prototype"]==11114) $textchem=array("рогами", "лапой", "хвостом");
    if ($this->battleunits[$kto]["prototype"]==11115) $textchem=array("рогами", "лапой", "хвостом");
    if ($this->battleunits[$kto]["prototype"]==11116) $textchem=array("лапой", "когтями", "головой");
    if ($this->battleunits[$kto]["prototype"]==11141) $textchem=array("штыковой лопатой", "инструментом", "совком", "лопатой");
    if ($this->battleunits[$kto]["prototype"]==11142) $textchem=array("тусклым фонарём", "шахтёрским фонарём", "тяжёлым фонарём", "фонарём");
    if ($this->battleunits[$kto]["prototype"]==11143) $textchem=array("киркой", "тяпкой", "окровавленной тяпкой", "тяжёлой киркой");
    if ($this->battleunits[$kto]["prototype"]==11144) $textchem=array("огромным ковшом", "чем-то ложкообразным", "страшным ковшом", "ковшом", "черпаком", "здоровенным ковшом");
    if ($this->battleunits[$kto]["prototype"]==11145) $textchem=array("остриём меча", "рукояткой меча", "мечом", "плоской стороной лезвия меча", "острым мечом", "ножнами", "клинком меча");
    if ($this->battleunits[$kto]["prototype"]==11146) $textchem=array("остриём меча", "рукояткой меча", "мечом", "плоской стороной лезвия меча", "острым мечом", "ножнами", "клинком меча");
    if ($this->battleunits[$kto]["prototype"]==11147) $textchem=array("огромным ковшом", "чем-то ложкообразным", "страшным ковшом", "ковшом", "черпаком", "здоровенным ковшом");
    if ($this->battleunits[$kto]["prototype"]==11148) $textchem=array("навершием посоха", "красивым посохом");
    if ($this->battleunits[$kto]["prototype"]==11150) $textchem=array("молотом");
  }
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

  $damagetype="";

  if ($sex1) {
    if ($prof=="kol") {
      if ($chem=="kulak") $arr=array("ткнула");
      else $arr=array("уколола", "ткнула");
    }
    if ($prof=="rub") $arr=array("рубанула");
    if ($prof=="rej") $arr=array("резанула");
    if ($prof=="drob") $arr=array("ударила");
    if ($prof=="mag") $arr=array("поразила магией");
    $damagetype=$arr[rand(0,count($arr)-1)];
  } else {
    if ($prof=="kol") {
      if ($chem=="kulak") $arr=array("ткнул");
      else $arr=array("уколол", "ткнул");
    }
    if ($prof=="rub") $arr=array("рубанул");
    if ($prof=="rej") $arr=array("резанул");
    if ($prof=="drob") $arr=array("ударил");
    if ($prof=="mag") $arr=array("поразил магией");
    $damagetype=$arr[rand(0,count($arr)-1)];
  }

  if ($takenbybarrier[$pokomy]) {
    $extra=" мана: -$takenbybarrier[$pokomy] ";
    $takenbybarrier[$pokomy]=0;
  } else $extra="";

  switch ($type) {
    //парирование
    case "parry":
      if ($sex2) {
        $textuvorot = array (" <font color=green><B>парировала</B></font> удар ");
      } else {
        $textuvorot = array (" <font color=green><B>парировал</B></font> удар ");
      }
      $ret.='<span class=date>'.date("H:i")."</span> $hits ".$this->nick5($kto,$c1).' '.$textfail[rand(0,count($textfail)-1)].' '.$hark2[rand(0,count($hark2)-1)].' '.$nick5pokomy.' '.$textuvorot[rand(0,count($textuvorot)-1)].' '.$textchem[rand(0,count($textchem)-1)].' '.$kuda.'.<BR>';
    break;
    case "shieldblock":
      if ($sex2) {
        $textuvorot = array (" <font color=green><B>заблокировала щитом</B></font> удар ");
      } else {
        $textuvorot = array (" <font color=green><B>заблокировал щитом</B></font> удар ");
      }
      $ret.='<span class=date>'.date("H:i")."</span> $hits ".$this->nick5($kto,$c1).' '.$textfail[rand(0,count($textfail)-1)].' '.$hark2[rand(0,count($hark2)-1)].' '.$nick5pokomy.' '.$textuvorot[rand(0,count($textuvorot)-1)].' '.$textchem[rand(0,count($textchem)-1)].' '.$kuda.'.<BR>';
    break;
    case "mag":
        if ($sex1) {
            $textmag = "потратила";
        }
        else {
            $textmag = "потратил";
        }
        $ret.='<span class=date>'.date("H:i").'</span> '.$this->nick5($kto,$c1).' '.$textmag.' свой ход на магию.<BR>';
    break;
    case "skip":
        if ($sex1) {
          $textmag = "пропустила";
        } else {
          $textmag = "пропустил";
        }
        $ret.='<span class=date>'.date("H:i").'</span> '.$this->nick5($kto,$c1).' '.$textmag.' ход по таймауту.<BR>';
    break;
    // уворот
    case "uvorot":
        if ($sex2) {
            $textuvorot = array (" <font color=green><B>уклонилась</B></font> от удара "," <font color=green><B>увернулась</B></font> от удара "," <font color=green><B>отскочила</B></font> от удара ");
        }
        else {
            $textuvorot = array (" <font color=green><B>уклонился</B></font> от удара "," <font color=green><B>увернулся</B></font> от удара "," <font color=green><B>отскочил</B></font> от удара ");
        }
        $ret.='<span class=date>'.date("H:i")."</span> $hits ".$this->nick5($kto,$c1).' '.$textfail[rand(0,count($textfail)-1)].' '.$hark2[rand(0,count($hark2)-1)].' '.$nick5pokomy.' '.$textuvorot[rand(0,count($textuvorot)-1)].' '.$textchem[rand(0,count($textchem)-1)].' '.$kuda.'.<BR>';
    break;
    // контрудар
    case "contr":
        if ($sex2) {
            $textuvorot = array (" <font color=green><B>уклонилась</B></font> от удара и провела <font color=green><B>контрудар</B></font> "," <font color=green><B>увернулась</B></font> от удара и врезала <font color=green><B>контрудар</B></font> "," <font color=green><B>отскочила</B></font> от удара и вломила <font color=green><B>контрудар</B></font> ");
        }
        else {
            $textuvorot = array (" <font color=green><B>уклонился</B></font> от удара и провёл <font color=green><B>контрудар</B></font> "," <font color=green><B>увернулся</B></font> от удара и врезал <font color=green><B>контрудар</B></font> "," <font color=green><B>отскочил</B></font> от удара и вломил <font color=green><B>контрудар</B></font> ");
        }                                                                                                                           //'.$textchem[rand(0,count($textchem)-1)].' '.$kuda.'
        $ret.='<span class=date>'.date("H:i")."</span> $hits ".$this->nick5($kto,$c1).'  '.$textfail[rand(0,count($textfail)-1)].' '.$hark2[rand(0,count($hark2)-1)].' '.$nick5pokomy.' '.$textuvorot[rand(0,count($textuvorot)-1)].'.<BR>';
    break;
    //блок
    case "block":
        if ($sex2) {
            $textblock = array (" заблокировала удар "," остановила удар "," отбила удар ");
        }
        else {
            $textblock = array (" заблокировал удар "," остановил удар "," отбил удар ");
        }
        $ret.='<span class=date>'.date("H:i")."</span> $hits ".$this->nick5($kto,$c1).' '.$textfail[rand(0,count($textfail)-1)].' '.$hark2[rand(0,count($hark2)-1)].' '.$nick5pokomy.' '.$textblock[rand(0,count($textblock)-1)].' '.$textchem[rand(0,count($textchem)-1)].' '.$kuda.'.<BR>';
    break;
    //крит
    case "krit":
        if ($sex1) {
            $textkrit = array (", напугав всех, неслышно подойдя сзади $damagetype $kuda ".$textchem[rand(0,count($textchem)-1)]." оппонента.",", сказав \"БУ!\", ласково $damagetype соперника $kuda.",", расслабившись, $damagetype $kuda.",", показав сразу два пальца, $damagetype $kuda.",", напугав всех, $damagetype противника $kuda.",", проклиная этот сайт, $damagetype $kuda.");
        } else {
            $textkrit = array (", напугав всех, неслышно подойдя сзади $damagetype $kuda ".$textchem[rand(0,count($textchem)-1)]." оппонента.",", сказав \"БУ!\", ласково $damagetype соперника $kuda.",", расслабившись, $damagetype $kuda.",", показав сразу два пальца, $damagetype $kuda.",", напугав всех, $damagetype противника $kuda.",", проклиная этот сайт, $damagetype $kuda.");
        }
        $ret.='<span class=date>'.date("H:i")."</span> $hits ".$nick5pokomy.' '.$textud[rand(0,count($textud)-1)].' '.$hark[rand(0,count($hark)-1)].' '.$this->nick5($kto,$c1).' '.$textkrit[rand(0,count($textkrit)-1)].' <b><font color=red>-'.$uron.'</font></b> ['.$hp.'/'.$maxhp.'] '.$extra.'<BR>';
    break;
    //крит
    case "krita":
        if ($sex1) {
            $textkrit = array (", напугав всех, неслышно подойдя сзади $damagetype, пробив блок,  $kuda ".$textchem[rand(0,count($textchem)-1)]." оппонента.",", сказав \"БУ!\", пробив блок, ласково $damagetype соперника $kuda.",", расслабившись, $damagetype, пробив блок,  $kuda.",", показав сразу два пальца, $damagetype, пробив блок, $kuda.",", напугав всех, пробив блок, $damagetype противника $kuda.",", проклиная этот сайт, пробив блок, $damagetype $kuda.");
        } else {
            $textkrit = array (", напугав всех, неслышно подойдя сзади $damagetype, пробив блок,  $kuda ".$textchem[rand(0,count($textchem)-1)]." оппонента.",", сказав \"БУ!\", пробив блок, ласково $damagetype соперника $kuda.",", расслабившись, $damagetype, пробив блок,  $kuda.",", показав сразу два пальца, $damagetype, пробив блок,  $kuda.",", напугав всех, пробив блок, $damagetype противника $kuda.",", проклиная этот сайт, пробив блок, $damagetype $kuda.");
        }
        $ret.='<span class=date>'.date("H:i")."</span> $hits ".$nick5pokomy.' '.$textud[rand(0,count($textud)-1)].' '.$hark[rand(0,count($hark)-1)].' '.$this->nick5($kto,$c1).' '.$textkrit[rand(0,count($textkrit)-1)].' <b><font color=red>-'.$uron.'</font></b> ['.$hp.'/'.$maxhp.'] '.$extra.'<BR>';
    break;
    //крит
    case "kritp":
        if ($sex1) {
            $textkrit = array (", напугав всех, неслышно подойдя сзади $damagetype, пробив защиту,  $kuda ".$textchem[rand(0,count($textchem)-1)]." оппонента.",", сказав \"БУ!\", пробив защиту, ласково $damagetype соперника $kuda.",", расслабившись, $damagetype, пробив защиту,  $kuda.",", показав сразу два пальца, $damagetype, пробив защиту, $kuda.",", напугав всех, пробив защиту, $damagetype противника $kuda.",", проклиная этот сайт, пробив защиту, $damagetype $kuda.");
        } else {
            $textkrit = array (", напугав всех, неслышно подойдя сзади $damagetype, пробив защиту,  $kuda ".$textchem[rand(0,count($textchem)-1)]." оппонента.",", сказав \"БУ!\", пробив защиту, ласково $damagetype соперника $kuda.",", расслабившись, $damagetype, пробив защиту,  $kuda.",", показав сразу два пальца, $damagetype, пробив защиту,  $kuda.",", напугав всех, пробив защиту, $damagetype противника $kuda.",", проклиная этот сайт, пробив защиту, $damagetype $kuda.");
        }
        $ret.='<span class=date>'.date("H:i")."</span> $hits ".$nick5pokomy.' '.$textud[rand(0,count($textud)-1)].' '.$hark[rand(0,count($hark)-1)].' '.$this->nick5($kto,$c1).' '.$textkrit[rand(0,count($textkrit)-1)].' <b><font color=red>-'.$uron.'</font></b> ['.$hp.'/'.$maxhp.'] '.$extra.'<BR>';
    break;
    //крит
    case "kritb":
        if ($sex1) {
            $textkrit = array (", напугав всех, неслышно подойдя сзади $damagetype, пробив блок щита,  $kuda ".$textchem[rand(0,count($textchem)-1)]." оппонента.",", сказав \"БУ!\", пробив блок щита, ласково $damagetype соперника $kuda.",", расслабившись, $damagetype, пробив блок щита,  $kuda.",", показав сразу два пальца, $damagetype, пробив блок щита, $kuda.",", напугав всех, пробив блок, $damagetype противника $kuda.",", проклиная этот сайт, пробив блок щита, $damagetype $kuda.");
        } else {
            $textkrit = array (", напугав всех, неслышно подойдя сзади $damagetype, пробив блок щита,  $kuda ".$textchem[rand(0,count($textchem)-1)]." оппонента.",", сказав \"БУ!\", пробив блок щита, ласково $damagetype соперника $kuda.",", расслабившись, $damagetype, пробив блок щита,  $kuda.",", показав сразу два пальца, $damagetype, пробив блок щита,  $kuda.",", напугав всех, пробив блок, $damagetype противника $kuda.",", проклиная этот сайт, пробив блок щита, $damagetype $kuda.");
        }
        $ret.='<span class=date>'.date("H:i")."</span> $hits ".$nick5pokomy.' '.$textud[rand(0,count($textud)-1)].' '.$hark[rand(0,count($hark)-1)].' '.$this->nick5($kto,$c1).' '.$textkrit[rand(0,count($textkrit)-1)].' <b><font color=red>-'.$uron.'</font></b> ['.$hp.'/'.$maxhp.'] '.$extra.'<BR>';
    break;
    // попадание
    case "udar":
      if ($sex1) {
        $textudar = array(", разбежавшись, $damagetype"," отчаянно $damagetype "," нехотя $damagetype "," не подумав, $damagetype ",", улыбаясь, $damagetype "," $damagetype "," сдуру $damagetype ");
      } else {
        $textudar = array(", разбежавшись, $damagetype"," отчаянно $damagetype "," нехотя $damagetype "," не подумав, $damagetype ",", улыбаясь, $damagetype "," $damagetype "," сдуру $damagetype ");
      }
      $ret.='<span class=date>'.date("H:i")."</span> $hits ".$nick5pokomy.' '.$textud[rand(0,count($textud)-1)].' '.$hark[rand(0,count($hark)-1)].' '.$this->nick5($kto,$c1).''.$textudar[rand(0,count($textudar)-1)].' '.$textchem[rand(0,count($textchem)-1)].' '.$kuda.' <b>-'.$uron.'</b> ['.$hp.'/'.$maxhp.'] '.$extra.'<BR>';
    break;
    case "udartoff":
      if ($sex1) {
        $textudar = array(", разбежавшись, $damagetype"," отчаянно $damagetype "," нехотя $damagetype "," не подумав, $damagetype ",", улыбаясь, $damagetype "," $damagetype "," сдуру $damagetype ");
      } else {
        $textudar = array(", разбежавшись, $damagetype"," отчаянно $damagetype "," нехотя $damagetype "," не подумав, $damagetype ",", улыбаясь, $damagetype "," $damagetype "," сдуру $damagetype ");
      }
      $ret.='<span class=date>'.date("H:i")."</span> $hits ".$nick5pokomy.' '.$textud[rand(0,count($textud)-1)].' '.$hark[rand(0,count($hark)-1)].' '.$this->nick5($kto,$c1).''.$textudar[rand(0,count($textudar)-1)].' '.$textchem[rand(0,count($textchem)-1)].' '.$kuda.', но <b>силовое поле</b> поглотило урон.<BR>';
    break;
  }
  return $ret;
}

function hits($attack, $block, $enemy, $class) {
  $i=0;
  $ret="";
  $blocks=$this->getblocks($enemy, $block);
  while ($i<5) {
    $src="";
    $i++;
    if (in_array($i, $blocks)) $src.="1";
    else $src.="0";
    if ($attack==$i) $src.="1";
    else $src.="0";
    $ret.="<img src=\"".IMGBASE."/i/hits/$class$src.gif\">";
  }
  return $ret;
}
/*------------------------------------------------------------------
 проверка на попадание "куда надо"
--------------------------------------------------------------------*/
function get_block ($komy,$att,$def,$enemy) {
  //  по типам блоков
  if ($def==665 || $def==664) return true;
  if($komy=="me") $blocks=$this->getblocks($this->user["id"], $def);
  else $blocks=$this->getblocks($enemy, $def);
/*              $this->write_stat_block($this->nick5($this->user['id'],$this->my_class)."|++|".implode('/',$blocks[$def]));
                $this->write_stat_block($this->nick5($enemy,$this->en_class)."|++|".implode('/',$blocks[$this->battle[$enemy][$this->user['id']][1]]));*/
  if (NOBLOCKS) return true;
  if (!in_array($att,$blocks)) {
    return true;
  } else {
    return false;
  }
}

function getblocks($user, $def) {
  if ($def>100 || !$def) return array();
  $this->getbu($user);            
  //if ($this->battleunits[$user]["defender"] && !$this->battleunits[$user]["defenderblock"]) return array();
  if ($this->battleunits[$user]["defender"]) $user=$this->battleunits[$user]["defender"];
  if ($this->battleunits[$user]["blockzones"]>=3) $blockcnt=3;
  elseif ($this->battleunits[$user]["blockzones"]==2) $blockcnt=2;
  else $blockcnt=1;
  if($blockcnt==3) {
    $blocks = array (
    '1' => array (1,2,3),
    '2' => array (2,3,4),
    '3' => array (3,4,5),
    '4' => array (4,5,1),
    '5' => array (5,1,2)
    );
  } elseif($blockcnt==2) {
    $blocks = array (
    '1' => array (1,2),
    '2' => array (2,3),
    '3' => array (3,4),
    '4' => array (4,5),
    '5' => array (5,1)
    );
  } else {
    $blocks = array (
    '1' => array (1),
    '2' => array (2),
    '3' => array (3),
    '4' => array (4),
    '5' => array (5)
    );
  }
  return $blocks[$def];
}
/*------------------------------------------------------------------
 возвращает получился шанс или нет
--------------------------------------------------------------------*/
function get_chanse ($persent) {
    srand();
    $rnd=mt_rand(1,100);
    if ($rnd <= $persent) {
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
    foreach($this->team_enemy as $k=>$v) {
      if (!$this->battle[$this->user['id']][$v]) {
        $this->battle[$this->user['id']][$v]=array(0,0,time());
      }
    }
    foreach($this->battle[$this->user['id']] as $k => $v) {
      if (($this->battle[$this->user['id']][$k][0] == 0 || $k > _BOTSEPARATOR_) && isset($this->battle[$k])) {
          $enemys[] = $k;
      }
    }
    $e=$enemys[rand(0,count($enemys)-1)];
  } else {
    $e=0;
  }
  if ($e!=$this->battleunits[$this->user["id"]]["enemy"]) {
    $this->battleunits[$this->user["id"]]["enemy"]=$e;
    $this->toupdatebu[$this->user["id"]]["enemy"]=$e;
    $this->needupdatebu=1;
  }
  return $e;
}

function getenemy() {
  $this->getbu($this->user["id"]);
  if ($this->battleunits[$this->user["id"]]["follow"]) {
    $follow=$this->battleunits[$this->user["id"]]["follow"];
    if ($this->battle[$this->user['id']][$follow][0] == 0) return $follow;
  }
  $e=$this->battleunits[$this->user["id"]]["enemy"];
  if (!$e) return $e;
  if (($this->battle[$this->user['id']][$e][0] == 0 || $k > _BOTSEPARATOR_) && isset($this->battle[$e])) {
    if (in_array($e, $this->team_enemy)) return $e;
    return 0;
  }
  return 0;
}

function setnextenemy($u) {
  global $user;
  if ($u>_BOTSEPARATOR_) return;
  if ($u==$user["id"]) {
    $enemys=array();
    foreach($this->team_enemy as $k=>$v) {
      if (!$this->battle[$this->user['id']][$v]) {
        $this->battle[$this->user['id']][$v]=array(0,0,time());
      }
    }
    foreach($this->battle[$this->user['id']] as $k => $v) {
      if (($this->battle[$this->user['id']][$k][0] == 0 || $k > _BOTSEPARATOR_) && isset($this->battle[$k])) {
          $enemys[] = $k;
      }
    }
    if (count($enemys)==0) $e=0;
    else $e=$enemys[rand(0,count($enemys)-1)];
    if ($e!=$this->battleunits[$u]["enemy"]) {
      $this->toupdatebu[$u]["enemy"]=$e;
      $this->needupdatebu=1;
    }
    if ($u==$this->user["id"]) {
      $this->enemy=$e;
    }
    return $e;
  }
  //По идее дальше не должно идти т. к. меняем врага только у себя (во всяком случае дальнейшее возможно глючит).
  $enemys=array();
  $this->getbu($u);
  foreach($this->battle[$u] as $k => $v) {
    if (($this->battle[$u][$k][0] == 0 || $k > _BOTSEPARATOR_) && isset($this->battle[$k])) {
      $enemys[] = $k;
    }
  }
  if (count($enemys)==0) $e=0;
  else $e=$enemys[rand(0,count($enemys)-1)];
  if ($e!=$this->battleunits[$u]["enemy"]) {
    $this->toupdatebu[$u]["enemy"]=$e;
    $this->needupdatebu=1;
  }
  if ($u==$this->user["id"]) {
    $this->enemy=$e;
  }
  return $e;
}


function addweaptypedam($user, $weaptype) {
  $ret=0;
  switch($weaptype) {
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
  return $ret;
}

function getdefcoef($user, $enemy, $mag=0) {
  $l1=$this->battleunits[$user]["level"];
  $l2=$this->battleunits[$enemy]["level"];
  if ($l1<=8) $ret=1;
  else{
    if ($l2<=8) $l2=8;
    $i=8;
    $ret=1;
    while ($l1>$l2) {
      $l1--;
      $ret=$ret/1.2;
    }
  }
  if ($this->battle_data["type"]==UNLIMCHAOS) $ret=1;
  if ($enemy>_BOTSEPARATOR_) return $ret;
  //if ($mag) return $ret;
  $c1=$this->battleunits[$user]["cost"];
  $c2=$this->battleunits[$enemy]["cost"];
  $diff=$c1-$c2;
  $dl=floor($diff/100000);
  if ($dl<floor($c1/max($c2, 3000)) && $dl<5) {
    $dl=min(floor($c1/max($c2, 3000))-1,5);
  }
  if ($dl<0) $dl=0;
  $i=0;
  while ($i<$dl) {
    $i++;
    $ret=$ret/1.1;
  }
  return $ret;
}

/*------------------------------------------------------------------
 считаем модификаторы
--------------------------------------------------------------------*/

function getmf($user, $enemy, $user_dress, $enemy_dress, $attack, $attack1, $attack2, $attack3, $attack4) {
  $udars=array('',1,2,3,4);
  $debstr="";
  $debstr.="$user[login]:<br>";
  $bmfud=0;
  $mykrit=$user_dress["mfkrit"];
  $heakrit = $enemy_dress["mfakrit"];
  $myuvorot = $user_dress["mfuvorot"];
  $heauvorot = $enemy_dress["mfauvorot"];
  $user_dress["minimax"]=$user["minimax"];
  $user_dress["minimax1"]=$user["minimax1"];
  
  //print_r($user_dress["minimax"]);
  //print_r($user_dress["minimax1"]);
  //$wt=$this->get_wep_type($user['weap']);
  //$wt=$minimax["weptype"];
  $hc=0;
  if ($user["minimax"]["weptype"]) {
    //$ats=mqfa("select chrub, chrej, chkol, chdrob, chmag from inventory where id='$user[weap]'");
    $ats=array("chrub"=>$user["minimax"]["chrub"], "chrej"=>$user["minimax"]["chrej"], "chkol"=>$user["minimax"]["chkol"], "chdrob"=>$user["minimax"]["chdrob"], "chmag"=>$user["minimax"]["chmag"]);
    $hc=array();
    foreach ($ats as $k=>$v) {
      if($v) {
        $k=str_replace("ch","",$k);
        $hc[$k]=$v;
      }
    }
  }
  if ($hc) $ht=getrandfromarray($hc);
  else {
    $t=rand(0,3);
    if ($t==0) $ht="drob";
    if ($t==1) $ht="kol";
    if ($t==2) $ht="rub";
    if ($t==3) $ht="rej";
  }


  if ($user["minimax1"]["weptype"]) {
    //$wt=$this->get_wep_type($user['shit']);
    //$wt=$minimax1["weptype"];
    $hc=array();
    //$ats=mqfa("select chrub, chrej, chkol, chdrob, chmag from inventory where id='$user[shit]'");
    $ats=array("chrub"=>$user["minimax1"]["chrub"], "chrej"=>$user["minimax1"]["chrej"], "chkol"=>$user["minimax1"]["chkol"], "chdrob"=>$user["minimax1"]["chdrob"], "chmag"=>$user["minimax1"]["chmag"]);
    foreach ($ats as $k=>$v) {
      if($v) {
        $k=str_replace("ch","",$k);
        $hc[$k]=$v;
      }
    }
    if (count($hc)==0) {
      $hc=0;
      if ($user["minimax1"]["weptype"]=="mech") $hc=array("rub"=>40, "kol"=>20, "drob"=>20, "rej"=>20);
      if ($user["minimax1"]["weptype"]=="topor") $hc=array("rub"=>60, "kol"=>20, "drob"=>20);
      if ($user["minimax1"]["weptype"]=="noj") $hc=array("kol"=>75, "rej"=>25);
      if ($user["minimax1"]["weptype"]=="dubina") $hc=array("drob"=>80, "kol"=>20);
    }
    if ($hc) $ht1=getrandfromarray($hc);
    else {
      $t=rand(0,3);
      if ($t==0) $ht1="drob";
      if ($t==1) $ht1="kol";
      if ($t==2) $ht1="rub";
      if ($t==3) $ht1="rej";
    }
  } else $ht1="drob";

  //$hpow=hitpower($user_dress, $ht);
  //$hpow1=hitpower($user_dress, $ht1);
  //$debstr.="Udar: ".($hpow+$user_dress["minu"]-$minimax1["minu"])." - ".($hpow+$user_dress["maxu"]-$minimax1["maxu"])."<br>
  //$hpow+$user_dress[maxu]-$minimax1[maxu]<br>";

  $debstr.="Uvorot chance: $myuvorot/$heauvorot<br>Krit chance: $mykrit/$heakrit<br>";
  $hitdata=getprofdamage($user_dress, 1, $ht, ($enemy["weap"]?0:1));
  if ($user_dress["weapons"]>1) $hitdata1=getprofdamage($user_dress, ($user_dress["hasshield"]?1:2), $ht1);

  //$mf['krit']=chancebymf2($mykrit,$heakrit,1,60,5,150);
  //$mf['krit']=chancebymf($mykrit,$heakrit,1,75,10,250);
  $mf['krit']=chancebymf3($mykrit,$heakrit,1,70);
  //$mf['uvorot']=chancebymf($myuvorot,$heauvorot, 1, 80, 10, 200);
  //$mf['uvorot']=chancebymf($myuvorot,$heauvorot, 1, 83, 10, 250);  
  $mu=70;
  if ($this->userdata[$enemy["id"]]["level"]>=11) $mu=90;
  elseif ($this->userdata[$enemy["id"]]["level"]>=10) $mu=85;
  elseif ($this->userdata[$enemy["id"]]["level"]>=9) $mu=80;
  $mf['uvorot']=chancebymf3($myuvorot,$heauvorot, 1, $mu);
  
 

  $debstr.="$mf[uvorot]/$mf[krit]<br>";

  $attacks=array($attack, $attack1, $attack2, $attack3, $attack4);

  $b2=mt_rand($enemy_dress["bronmin$attack1"],$enemy_dress["bron$attack1"]);
  $b3=mt_rand($enemy_dress["bronmin$attack2"],$enemy_dress["bron$attack2"]);
  $b4=mt_rand($enemy_dress["bronmin$attack3"],$enemy_dress["bron$attack3"]);
  $b5=mt_rand($enemy_dress["bronmin$attack4"],$enemy_dress["bron$attack4"]);


  if ($ht=="mag") $hemfd=$enemy_dress["mfdmag"];
  else $hemfd=$enemy_dress["mfdhit"]+@$enemy_dress["mfd$ht"];
  if ($ht1=="mag") $hemfd1=$enemy_dress["mfdmag"];
  else $hemfd1=$enemy_dress["mfdhit"]+@$enemy_dress["mfd$ht1"];

  $hemfdkrit=$hemfd+$enemy_dress["mfantikritpow"];
  $hemfdkrit1=$hemfd1+$enemy_dress["mfantikritpow"];


  $defcoef=$this->getdefcoef($user["id"], $enemy["id"]);
  $hemfd*=$defcoef;
  $hemfd1*=$defcoef;
  $hemfdkrit*=$defcoef;
  $hemfdkrit1*=$defcoef;

  $i=0;

  if ($this->cowardshifts[$user["id"]]) {
    if ($ht=="mag") $cowardmfd=$user_dress["mfdmag"];
    else $cowardmfd=$user_dress["mfdhit"]+@$user_dress["mfd$ht"];

    $cowardmfdkrit=$cowardmfd+$user_dress["mfantikritpow"];
    $cowardmfdkrit1=$cowardmfd1+$user_dress["mfantikritpow"];

    $mf['cowardkrit']=chancebymf3($mykrit, $user_dress["mfakrit"],1,50);
    $mf['cowarduvorot']=chancebymf3($myuvorot, $user_dress["mfauvorot"], 1, 85);
  }

  while ($i<$user_dress["weapons"]) {
    if ($i>0) $hn=$i; else $hn="";
    
    if ($i%2==1) $chitdata=$hitdata1;
    else $chitdata=$hitdata;

    $debstr.="Starting hit$hn: $chitdata[0]/$chitdata[1]<br>";

    $mf["udar$hn"]=rand($chitdata[0], $chitdata[1]);
    $mf["udarskiparmor$hn"]=$mf["udar$hn"];
    $mf["maxudar$hn"]=$chitdata[1];

    $mf["kritudar$hn"]=rand($chitdata[2], $chitdata[3]);
    $mf["kritudarskiparmor$hn"]=$mf["kritudar$hn"];
    $mf["maxkritudar$hn"]=$chitdata[3];
    
    if ($this->cowardshifts[$user["id"]] && $i==0) $b=mt_rand($user_dress["bronmin".$attacks[$i]],$user_dress["bron".$attacks[$i]]);
    else $b=mt_rand($enemy_dress["bronmin".$attacks[$i]],$enemy_dress["bron".$attacks[$i]]);

    $debstr.="Armor$hn: $b<br>";

    $udarwa=$mf["udar$hn"];
    $kritudarwa=$mf["kritudar$hn"];

    $mf["udar$hn"]=notnegative($mf["udar$hn"]-$b);
    $mf["maxudar$hn"]=notnegative($mf["maxudar$hn"]-$b);
    $mf["kritudar$hn"]=notnegative($mf["kritudar$hn"]-$b);
    $mf["maxkritudar$hn"]=notnegative($mf["maxkritudar$hn"]-$b);


    $debstr.="Hit$hn: ".floor($mf["udar$hn"])." / ".floor($mf["maxudar$hn"])." / ".floor($mf["kritudar$hn"])
    ." / ".floor($mf["maxkritudar$hn"])." / ".floor($mf["udarskiparmor$hn"])." / ".floor($mf["kritudarskiparmor$hn"])."<br>";
    
    $debstr.="Without armor: $udarwa, with armor: ".$mf["udar$hn"]."<br>";    
    
    $deltaproboj=ceil(($udarwa-$mf["udar$hn"])*($user_dress["mfproboj$hn"]));

    $mf["udar$hn"]+=$deltaproboj;
    $mf["maxudar$hn"]+=$deltaproboj;

    if ($mf["udar$hn"]<1) $mf["udar$hn"]=1;
    if ($mf["maxudar$hn"]<1) $mf["maxudar$hn"]=1;

    $debstr.="Proboj: $deltaproboj / ";

    $deltaproboj=ceil(($kritudarwa-$mf["kritudar$hn"])*$user_dress["mfproboj".($hn+1)]);

    $debstr.="$deltaproboj ($user_dress[mfproboj])<br>";

    $mf["kritudar$hn"]+=$deltaproboj;
    $mf["maxkritudar$hn"]+=$deltaproboj;

    if ($mf["kritudar$hn"]<1) $mf["udar$hn"]=1;
    if ($mf["maxkritudar$hn"]<1) $mf["maxudar$hn"]=1;

    
    $debstr.="Mfd: $hemfd/$hemfd1<br>";

    if ($this->cowardshifts[$user["id"]] && $i==0) {
      $mfd=$cowardmfd+$user_dress["mfdhit".$attacks[$i]];
    } else {
      $mfd=($i%2==1?$hemfd1:$hemfd)+$enemy_dress["mfdhit".$attacks[$i]];
    }


    if ($mfd>250) $mfdsa=pow(0.5,(min($mfd-250,MAXMFD))/250); else $mfdsa=1;
    $mfd=min($mfd,MAXMFD);

    if ($this->cowardshifts[$user["id"]] && $i==0) {
      $mfdkrit=$cowardmfdkrit+$user_dress["mfdhit".$attacks[$i]];
    } else {
      $mfdkrit=($i%2==1?$hemfdkrit1:$hemfdkrit)+$enemy_dress["mfdhit".$attacks[$i]];
    }

    if ($mfdkrit>250) $mfdkritsa=pow(0.5,(min($mfdkrit-250,MAXMFD))/250); else $mfdkritsa=1;
    $mfdkrit=min($mfd,MAXMFD);

    $debstr.="Hit defence pts: $mfd/$mfdkrit<br>";
    $mfd=pow(0.5,$mfd/250);
    $mfdkrit=pow(0.5,$mfdkrit/250);
    $debstr.="Hit defence: $mfd/$mfdkrit<br>";
    $mf["udar$hn"]*=$mfd;
    $mf["maxudar$hn"]*=$mfd;
    $mf["kritudar$hn"]*=$mfdkrit;
    $mf["maxkritudar$hn"]*=$mfdkrit;
    $mf["udarskiparmor$hn"]*=$mfdsa;
    $mf["kritudarskiparmor$hn"]*=$mfdkritsa;

    $debstr.="Hit before lower: ".$mf["udar$hn"]." / ".floor($mf["maxudar$hn"])." / ".floor($mf["kritudar$hn"])
    ." / ".floor($mf["maxkritudar$hn"])." / ".floor($mf["udarskiparmor$hn"])." / ".floor($mf["kritudarskiparmor$hn"])."<br>";
    if ($enemy["id"]<_BOTSEPARATOR_) {
      $mf["udar$hn"]=lowerdamage($mf["udar$hn"], $enemy["level"]);
      $mf["maxudar$hn"]=lowerdamage($mf["maxudar$hn"], $enemy["level"]);
      $mf["kritudar$hn"]=lowerdamage($mf["kritudar$hn"], $enemy["level"]);
      $mf["maxkritudar$hn"]=lowerdamage($mf["maxkritudar$hn"], $enemy["level"]);
      $mf["udarskiparmor$hn"]=lowerdamage($mf["udarskiparmor$hn"], $enemy["level"]);
      $mf["kritudarskiparmor$hn"]=lowerdamage($mf["kritudarskiparmor$hn"], $enemy["level"]);
    }


    $mf["udar$hn"]=floor($mf["udar$hn"]);
    $mf["maxudar$hn"]=floor($mf["maxudar$hn"]);
    $mf["kritudar$hn"]=floor($mf["kritudar$hn"]);
    $mf["maxkritudar$hn"]=floor($mf["maxkritudar$hn"]);
    $mf["udarskiparmor$hn"]=floor($mf["udarskiparmor$hn"]);
    $mf["kritudarskiparmor$hn"]=floor($mf["kritudarskiparmor$hn"]);


    //if ($mf["kritudar$hn"]>$mf["udar$hn"]*3) $mf["kritudar$hn"]=$mf["udar$hn"]*3;

    $debstr.="Final hit$hn: ".$mf["udar$hn"]." / ".floor($mf["maxudar$hn"])." / ".floor($mf["kritudar$hn"])
    ." / ".floor($mf["maxkritudar$hn"])." / ".floor($mf["udarskiparmor$hn"])." / ".floor($mf["kritudarskiparmor$hn"])."<br>";

    $mf["prof$hn"]=($i%2==0?$ht:$ht1);
    $i++;                    
  }

  if ($user_dress["lovk"]>=125) $mf["uvorot"]+=5;
  if ($user_dress["inta"]>=125) $mf["krit"]+=5;
  if (NOUVOROTS) $mf["uvorot"]=0;

  //if($this->get_wep_type($user['weap']) == 'kulak' && $user['align'] == '2') { $mf['udar'] += $user['level'];}

  /*$mult=0;
  $mult1=0;

  $mult+=$this->addweaptypedam($user, $user["minimax"]["weptype"]);
  $debstr.="Weaptypedam: $mult<br>";
  $mult1+=$this->addweaptypedam($user, $user["minimax1"]["weptype"]);
  $mult+=$user_dress["mfhitp"];
  $debstr.="mfhitp: $mult<br>";
  $mult1+=$user_dress["mfhitp"];
  $debstr.="Profile damage: ".$user_dress["mf".$mf['prof']]."/".$user_dress["mf".$mf['prof1']]." ($mf[prof]/$mf[prof1])<br>";
  if ($mf['prof']) $mult+=$user_dress["mf".$mf['prof']];
  if ($mf['prof1']) $mult1+=$user_dress["mf".$mf['prof1']];
  $debstr.="Total mfhitp: $mult/$mult1<br>";
  $mf['udar']*=$mult/100+1;
  $mf['udar1']*=$mult1/100+1;
  $mf['udar2']*=$mult1/100+1;
  $mf['udar3']*=$mult1/100+1;
  $mf['udar4']*=$mult1/100+1;
  $mf['maxudar']*=$mult/100+1;
  $mf['maxudar1']*=$mult1/100+1;
  $mf['maxudar2']*=$mult1/100+1;
  $mf['maxudar3']*=$mult1/100+1;
  $mf['maxudar4']*=$mult1/100+1;

  if (BATTLEDEBUG) $debstr.="Increased: ".$mf["udar"]."<br>";*/

  /*if ($enemy["id"]<_BOTSEPARATOR_ && $user["id"]<_BOTSEPARATOR_) {
    $b1=$b1/2;
    $b2=$b2/2;
    $b3=$b3/2;
    $b4=$b4/2;
    $b5=$b5/2;
  }*/


  /*$mf['udarskiparmor']=$mf["udar"];
  $mf['udarskiparmor1']=$mf["udar1"];
  $mf['udarskiparmor2']=$mf["udar2"];
  $mf['udarskiparmor3']=$mf["udar3"];
  $mf['udarskiparmor4']=$mf["udar4"];

  $mf['udar']-=$b1;
  $mf['udar1']-=$b2;
  $mf['udar2']-=$b3;
  $mf['udar3']-=$b4;
  $mf['udar4']-=$b5;
  $mf['maxudar']-=$b1;
  $mf['maxudar1']-=$b2;
  $mf['maxudar2']-=$b3;
  $mf['maxudar3']-=$b4;
  $mf['maxudar4']-=$b5;
  $debstr.="bron: ({$enemy_dress["bronmin$attack"]}-{$enemy_dress["bron$attack"]}/{$enemy_dress["bronmin$attack1"]}-{$enemy_dress["bron$attack1"]}) $b1/$b2<br>";*/


  //if (BATTLEDEBUG) $debstr.=" * $hemfd/$hemfd1 ";

  /*$mf['udar']*=$hemfd;
  $mf['udar1']*=$hemfd1;
  $mf['udar2']*=$hemfd;
  $mf['udar3']*=$hemfd1;
  $mf['udar4']*=$hemfd;

  $mf['udarskiparmor']*=$hemfdsa;
  $mf['udarskiparmor1']*=$hemfdsa1;
  $mf['udarskiparmor3']*=$hemfdsa;
  $mf['udarskiparmor4']*=$hemfdsa1;
  $mf['udarskiparmor']*=$hemfdsa;*/

  /*$mf['maxudar']*=$hemfd;
  $mf['maxudar1']*=$hemfd1;
  $mf['maxudar2']*=$hemfd;
  $mf['maxudar3']*=$hemfd1;
  $mf['maxudar4']*=$hemfd;

  $mf["kritudar"]*=$hemfd;
  $mf["kritudar1"]*=$hemfd1;
  $mf["kritudar2"]*=$hemfd;
  $mf["kritudar3"]*=$hemfd1;
  $mf["kritudar4"]*=$hemfd;


  $mf["maxkritudar"]*=$hemfd;
  $mf["maxkritudar1"]*=$hemfd1;
  $mf["maxkritudar2"]*=$hemfd;
  $mf["maxkritudar3"]*=$hemfd1;
  $mf["maxkritudar4"]*=$hemfd;*/

  /*foreach ($udars as $k=>$v) {
    $v2=$k%2+1;
    if ($v2==1) $v2="";
    $deltaproboj=($mf["kritudar$v"]-$mf["udar$v"])*($user_dress["mfproboj$v2"]);
    if ($mf["udar$v"]<0) $mf["udar$v"]=0;
    $mf["udar$v2"]=$mf["udar$v2"]+$deltaproboj;

    $deltaproboj=($mf["maxkritudar$v"]-$mf["maxudar$v"])*($user_dress["mfproboj$v2"]);
    if ($mf["maxudar$v"]<0) $mf["maxudar$v"]=0;
    $mf["maxudar$v"]=$mf["maxudar$v"]+$deltaproboj;

    if($mf["udar$v"] < 1) $mf["udar$v"] = 1;
    if($mf["maxudar$v"] < 1) $mf["udar$v"] = 1;
    $mf["kritudarskiparmor$v"]=$mf["udarskiparmor$v"]+$mf["kritudar$v"];
    $mf["kritudar$v"]=$mf["udar$v"]+$mf["kritudar$v"];
    $mf["maxkritudar$v"]=$mf["maxudar$v"]+$mf["maxkritudar$v"];
  }*/



  /*$debstr.=" Kritpow: $enemy_dress[mfkritpow]/$user_dress[mfantikritpow]<br>";
  $hs=substractmf($enemy_dress["mfkritpow"], $user_dress["mfantikritpow"], 0.25);

  $debstr.="Krit before anti: $mf[kritudar] ($hs)<br>";

  foreach ($udars as $k=>$v) {
    if ($mf["kritudar$v"]*$hs<$mf["udar$v"]) {
      $mf["kritudar$v"]=$mf["udar$v"];
    } else {
      $mf["kritudar$v"]*=$hs;
    }
    $debstr.="Krit: ".$mf["kritudar$v"]."<br>";
    if ($mf["kritudar$v"]<$mf["udar$v"]*2) $mf["kritudar"]=$mf["udar$v"]*2;
  }

  $debstr.="Final krit: $mf[kritudar]/$mf[kritudar1]<br>";
  $debstr.="Final hit: $mf[udar]/$mf[udar1]<br>";*/

  if ($mf["krit"]<2) $mf["krit"]=0;
  if (BATTLEDEBUG) echo "$debstr<br>";

  return $mf;
}

function addextramf($id) {
  if ($this->battleunits[$id]["lovk"]>=125) {
    $this->battleunits[$id]["mfakrit"]+=40;
    $this->battleunits[$id]["mfuvorot"]+=105;
    $this->battleunits[$id]["mfparir"]+=15;
  } elseif ($this->battleunits[$id]["lovk"]>=100) {
    $this->battleunits[$id]["mfakrit"]+=40;
    $this->battleunits[$id]["mfuvorot"]+=105;
    $this->battleunits[$id]["mfparir"]+=15;
  } elseif ($this->battleunits[$id]["lovk"]>=75) {
    $this->battleunits[$id]["mfakrit"]+=15;
    $this->battleunits[$id]["mfuvorot"]+=35;
    $this->battleunits[$id]["mfparir"]+=15;
  } elseif ($this->battleunits[$id]["lovk"]>=50) {
    $this->battleunits[$id]["mfakrit"]+=15;
    $this->battleunits[$id]["mfuvorot"]+=35;
    $this->battleunits[$id]["mfparir"]+=5;
  } elseif ($this->battleunits[$id]["lovk"]>=25) {
    $this->battleunits[$id]["mfparir"]+=5;
  }

  if ($this->battleunits[$id]["inta"]>=125) {
    $this->battleunits[$id]["mfkrit"]+=105;
    $this->battleunits[$id]["mfauvorot"]+=45;
    $this->battleunits[$id]["mfkritpow"]+=25;
  } elseif ($this->battleunits[$id]["inta"]>=100) {
    $this->battleunits[$id]["mfkrit"]+=105;
    $this->battleunits[$id]["mfauvorot"]+=45;
    $this->battleunits[$id]["mfkritpow"]+=25;
  } elseif ($this->battleunits[$id]["inta"]>=75) {
    $this->battleunits[$id]["mfkrit"]+=35;
    $this->battleunits[$id]["mfauvorot"]+=15;
    $this->battleunits[$id]["mfkritpow"]+=25;
  } elseif ($this->battleunits[$id]["inta"]>=50) {
    $this->battleunits[$id]["mfkrit"]+=35;
    $this->battleunits[$id]["mfauvorot"]+=15;
    $this->battleunits[$id]["mfkritpow"]+=10;
  } elseif ($this->battleunits[$id]["inta"]>=25) {
    $this->battleunits[$id]["mfkritpow"]+=10;
  }

  if ($this->battleunits[$id]["sila"]>=125) {
    $this->battleunits[$id]["mfhitp"]+=25;
  } elseif ($this->battleunits[$id]["sila"]>=100) {
    $this->battleunits[$id]["mfhitp"]+=25;
  } elseif ($this->battleunits[$id]["sila"]>=75) {
    $this->battleunits[$id]["mfhitp"]+=17;
  } elseif ($this->battleunits[$id]["sila"]>=50) {
    $this->battleunits[$id]["mfhitp"]+=10;
  } elseif ($this->battleunits[$id]["sila"]>=25) {
    $this->battleunits[$id]["mfhitp"]+=5;
  }

  if ($this->battleunits[$id]["intel"]>=125) $this->battleunits[$id]["mfmagp"]+=35;
  elseif ($this->battleunits[$id]["intel"]>=100) $this->battleunits[$id]["mfmagp"]+=25;
  elseif ($this->battleunits[$id]["intel"]>=75) $this->battleunits[$id]["mfmagp"]+=17;
  elseif ($this->battleunits[$id]["intel"]>=50) $this->battleunits[$id]["mfmagp"]+=10;
  elseif ($this->battleunits[$id]["intel"]>=25) $this->battleunits[$id]["mfmagp"]+=5;

  $this->battleunits[$id]["mfproboj"]+=5;

  $this->battleunits[$id]["mfproboj1"]=$this->battleunits[$id]["mfproboj"]-$this->battleunits[$id]["minimax"]["mfproboj"];
  $this->battleunits[$id]["mfproboj"]=$this->battleunits[$id]["mfproboj"]-$this->battleunits[$id]["minimax1"]["mfproboj"];

  if ($this->battleunits[$id]["mfproboj"]>100) $this->battleunits[$id]["mfproboj"]=100;
  if ($this->battleunits[$id]["mfproboj1"]>100) $this->battleunits[$id]["mfproboj1"]=100;

  $this->battleunits[$id]["mfproboj"]=$this->battleunits[$id]["mfproboj"]/100;
  $this->battleunits[$id]["mfproboj1"]=$this->battleunits[$id]["mfproboj1"]/100;

  //$this->battleunits[$id]["mfproboj"]=mftoabs($this->battleunits[$id]["mfproboj"],100);
  //$this->battleunits[$id]["mfproboj1"]=mftoabs($this->battleunits[$id]["mfproboj1"],100);

  //$this->battleunits[$id]["mfcontr"]+=10;
  $this->battleunits[$id]["mfcontr"]=mftoabs($this->battleunits[$id]["mfcontr"],100)*100;
  if ($this->battleunits[$id]["mfcontr"]>80) $this->battleunits[$id]["mfcontr"]=80;
  if (ALLCONTR) $this->battleunits[$id]["mfcontr"]=100;

  $this->battleunits[$id]["mfakrit"]+=$this->battleunits[$id]['inta']*5;
  $this->battleunits[$id]["mfkrit"]+=$this->battleunits[$id]['inta']*5;
  $this->battleunits[$id]["mfuvorot"]+=$this->battleunits[$id]['lovk']*5;
  $this->battleunits[$id]["mfauvorot"]+=$this->battleunits[$id]['lovk']*5;  

  //$user_dress["mfparir"]=mftoabs($user_dress["mfparir"],100);
  //$user_dress["mfparir"]+=10;
  //if ($user_dress["mfparir"]>50) $user_dress["mfparir"]=80;

  $this->battleunits[$id]["mfshieldblock"]=mftoabs($this->battleunits[$id]["mfshieldblock"],100)*100;
  if ($this->battleunits[$id]["mfshieldblock"]>80) $this->battleunits[$id]["mfshieldblock"]=80;

  if (!$this->battleunits[$id]["hasshield"]) $this->battleunits[$id]["mfshieldblock"]=0;

  //$bmfbron=0;
  //$bmfkrit=0;
  //$bmfakrit=0;
  //$bmfuv=0;
  //$bmfauv=0;
  /*
  if ($user['lovk']>=25) $bmfauv+=25;
  if ($user['lovk']>=50) $bmfuv+=25;
  if ($user['inta']>=25) $bmfakrit+=25;
  if ($user['inta']>=50) $bmfkrit+=25;
  if ($user['vinos']>=25) $bmfbron+=2;
  if ($user['vinos']>=50) $bmfbron+=4;*/

  //$chpercbron=floor($bmfbron/100*30);
  //$bmfbron += $user["zo"][0]>0 ? $chpercbron:0;//свиток защиты !

  //$user_dress["bron1"]+=$bmfbron;
  //$user_dress["bron2"]+=$bmfbron;
  //$user_dress["bron3"]+=$bmfbron;
  //$user_dress["bron4"]+=$bmfbron;
  //$user_dress["bron5"]+=$bmfbron;

  /*$user_dress[2]=$user_dress["mfkrit"];
  $user_dress[3]=$user_dress["mfakrit"];

  $user_dress[4]=$user_dress["mfuvorot"];
  $user_dress[5]=$user_dress["mfauvorot"];*/

  /*$user_dress[2]+=$user['inta']*5+$bmfkrit;
  $user_dress[3]+=$user['inta']*5+$bmfakrit;

  $user_dress[4]+=$user['lovk']*5+$bmfuv;
  $user_dress[5]+=$user['lovk']*5+$bmfauv;*/
}

function solve_mf($user, $enemy,$myattack,$myattack1,$myattack2,$myattack3,$myattack4, $short=0) {

  $mf = array();
  if (!$enemy) return;
  $this->getbu($user);
  $this->getbu($enemy);
  if (count($this->enemy_dress)==0) {
    /*if($enemy > _BOTSEPARATOR_) {
      $bots = mysql_fetch_array(mq ('SELECT * FROM `bots` WHERE `id` = '.$enemy.' LIMIT 1;'));
      $this->enemyhar = mysql_fetch_array(mq('SELECT * FROM `users` WHERE `id` = \''.$bots['prototype'].'\' LIMIT 1;'));
      $this->enemyhar['hp'] = $bots['hp'];
      $this->enemyhar["id"]=$enemy;
    } else {
      $this->enemyhar = mysql_fetch_array(mq('SELECT * FROM `users` WHERE `id` = \''.$enemy.'\' LIMIT 1;'));
    }*/
    $this->enemyhar=$this->battleunits[$enemy];
    $this->enemyhar["id"]=$enemy;
    $this->enemyhar["login"]=$this->userdata[$enemy]["login"];
    $this->enemyhar["hp"]=$this->userdata[$enemy]["hp"];
    $this->enemyhar["maxhp"]=$this->userdata[$enemy]["maxhp"];
    $this->enemy_dress=$this->battleunits[$enemy];
    $this->enemy_dress["bron0"]=0;
    $this->enemy_dress["mf0"]=0;
    $this->enemy_dress["mfmag"]=0;
  }
  if (count($this->user_dress)==0) {
    $this->user_dress=$this->battleunits[$this->user['id']];
    //$this->user_dress = mysql_fetch_array(mq('SELECT sum(minu) as minu, sum(maxu) as maxu, sum(mfkrit) as mfkrit, sum(mfakrit) as mfakrit, sum(mfuvorot) as mfuvorot, sum(mfauvorot) as mfauvorot, sum(bron1) as bron1, sum(bron2) as bron2, sum(bron2) as bron3, sum(bron3) as bron4, sum(bron4) as bron5, sum(mfkritpow) as mfkritpow, sum(mfantikritpow) as mfantikritpow, sum(mfparir) as mfparir, sum(mfshieldblock) as mfshieldblock, sum(mfcontr) as mfcontr, sum(mfdhit) as mfdhit, sum(mfhitp) as mfhitp, sum(mfkol) as mfkol, sum(mfrej) as mfrej, sum(mfrub) as mfrub, sum(mfdrob) as mfdrob, sum(mfproboj) as mfproboj, sum(mfdmag) as mfdmag FROM `inventory` WHERE `dressed`=1 AND `owner` = \''.$this->user['id'].'\''));
    $this->user_dress["bron0"]=0;
    $this->user_dress["mf0"]=0;
    $this->enemy_dress["mfmag"]=0;
  }
  
  $this->user["minimax"]=$this->user_dress["minimax"];
  $this->user["minimax1"]=$this->user_dress["minimax1"];

  //$this->user["minimax"] = mqfa('SELECT minu,maxu, mfproboj FROM `inventory` WHERE `id` = \''.$this->user['weap'].'\'');
  //$this->user["minimax2"] = mqfa('SELECT minu,maxu, mfproboj FROM `inventory` WHERE `id` = \''.$this->user['shit'].'\' AND `second`=1');
  $this->enemyhar["minimax"]=$this->enemy_dress["minimax"];
  $this->enemyhar["minimax1"]=$this->enemy_dress["minimax1"];
  //$this->enemyhar["minimax"]=mqfa("select minu, maxu, mfproboj from inventory where id='".$this->enemyhar["weap"]."'");
  //$this->enemyhar["minimax2"]=mqfa("select minu, maxu, mfproboj from inventory where id='".$this->enemyhar["shit"]."'");

  //$this->addextramf($this->user["id"]);
  //$this->addextramf($enemy);
  if ($this->battleunits[$user]["mudra"]>=125) $this->battleunits[$user]["minusmfdmag"]+=3;
  if ($this->battleunits[$enemy]["mudra"]>=125) $this->battleunits[$enemy]["minusmfdmag"]+=3;
  if ($short) return;

  //БОНУСЫ!

  if ($this->user_dress["mfparir"]>50) $this->user_dress["mfparir"]=50;
  if ($this->enemy_dress["mfparir"]>50) $this->enemy_dress["mfparir"]=50;

  $_tmp=$this->user_dress["mfparir"]-($this->enemy_dress["mfparir"]/2);
  $this->enemy_dress["mfparir"]-=$this->user_dress["mfparir"]/2;
  $this->user_dress["mfparir"]=$_tmp;

  if ($this->battleunits[$enemy]["level"]>8) $this->user_dress["mfparir"]=$this->user_dress["mfparir"]/pow(1.2,$this->battleunits[$enemy]["level"]-8);
  if ($this->battleunits[$user]["level"]>8) $this->enemy_dress["mfparir"]=$this->enemy_dress["mfparir"]/pow(1.2,$this->battleunits[$user]["level"]-8);

  if ($this->user_dress["mfparir"]<1) $this->user_dress["mfparir"]=1;

  if ($this->enemy_dress["mfparir"]<1) $this->enemy_dress["mfparir"]=1;

  mt_srand(time());

  if (!$this->enemyhar["id"]) $this->enemyhar["id"]=$enemy;

  $mf["me"]=$this->getmf($this->user, $this->enemyhar, $this->user_dress, $this->enemy_dress, $myattack, $myattack1, $myattack2, $myattack3, $myattack4);
  $mf["me"]["dvur"]=$this->user_dress["dvur"];
  $mf["he"]["dvur"]=$this->enemy_dress["dvur"];
  $mf["he"]=$this->getmf($this->enemyhar, $this->user, $this->enemy_dress, $this->user_dress, $this->battle[$enemy][$this->user['id']][0], $this->battle[$enemy][$this->user['id']][3], $this->battle[$enemy][$this->user['id']][4], $this->battle[$enemy][$this->user['id']][5], $this->battle[$enemy][$this->user['id']][6]);

  $mf["me"]["udar"]=ceil($mf["me"]["udar"]);
  $mf["me"]["udar1"]=ceil($mf["me"]["udar1"]);
  $mf["me"]["udar2"]=ceil($mf["me"]["udar2"]);
  $mf["me"]["udar3"]=ceil($mf["me"]["udar3"]);
  $mf["me"]["udar4"]=ceil($mf["me"]["udar4"]);

  $mf["me"]["kritudar"]=ceil($mf["me"]["kritudar"]);
  $mf["me"]["kritudar1"]=ceil($mf["me"]["kritudar1"]);
  $mf["me"]["kritudar2"]=ceil($mf["me"]["kritudar2"]);
  $mf["me"]["kritudar3"]=ceil($mf["me"]["kritudar3"]);
  $mf["me"]["kritudar4"]=ceil($mf["me"]["kritudar4"]);

  $mf["he"]["udar"]=ceil($mf["he"]["udar"]);
  $mf["he"]["udar1"]=ceil($mf["he"]["udar1"]);
  $mf["he"]["udar2"]=ceil($mf["he"]["udar2"]);
  $mf["he"]["udar3"]=ceil($mf["he"]["udar3"]);
  $mf["he"]["udar4"]=ceil($mf["he"]["udar4"]);

  $mf["he"]["kritudar"]=ceil($mf["he"]["kritudar"]);
  $mf["he"]["kritudar1"]=ceil($mf["he"]["kritudar1"]);
  $mf["he"]["kritudar2"]=ceil($mf["he"]["kritudar2"]);
  $mf["he"]["kritudar3"]=ceil($mf["he"]["kritudar3"]);
  $mf["he"]["kritudar4"]=ceil($mf["he"]["kritudar4"]);

  if($enemy > _BOTSEPARATOR_) {
      $mf['he']['krit'] -= 6;
  }
  //$mf["me"]["krit"]=100;
  if (SHOWSOLVEDMF) {
    echo "<pre>";
    print_r($mf);
    echo "</pre>";
  }
  if (DIEAFTERSOLVEDMF) die;
  return $mf;
}

function updatebattleunits () {
  if (@$this->toupdatebu) {
    foreach ($this->toupdatebu as $k=>$v) {
      if (@$v["unseteffects"]) {
        foreach ($v["unseteffects"] as $k2=>$v2) {
          unset($this->battleunits[$k]["effects"][$v2]);
          $this->logstrokeend($v2, $k);
        }
      }
      $sql="";
      $mfs=array("mfdmag", "mfdhit", "mfhitp");
      foreach ($mfs as $k2=>$v2) if (@$v[$v2]) $sql=nextitem($sql, "$v2=$v2+$v[$v2]");
      $stats=array("sila", "lovk");
      $po=0;
      foreach ($stats as $k2=>$v2) {
        if (@$v[$v2]) {
          if (@$v[$v2]) $sql=nextitem($sql, "$v2=$v2+$v[$v2]");
          $this->battleunits["$k"]["persout0"]=preg_replace("/<!--$v2-->[0-9]*</", "<!--$v2-->".($this->battleunits["$k"]["$v2"]+$v[$v2])."<",$this->battleunits["$k"]["persout0"], -1, $cnt);
          $this->battleunits["$k"]["persout1"]=preg_replace("/<!--$v2-->[0-9]*</", "<!--$v2-->".($this->battleunits["$k"]["$v2"]+$v[$v2])."<",$this->battleunits["$k"]["persout1"]);
          $po=1;
        }
      }
      if ($po) $sql=nextitem($sql, "persout0='".addslashesa($this->battleunits["$k"]["persout0"])."', persout1='".addslashesa($this->battleunits["$k"]["persout1"])."'");
      if (@$v["enemy"]) {
        $sql=nextitem($sql, "enemy='$v[enemy]'");
      }
      if (isset($v["changes"])) {
        if ($v["changes"]==0) $sql=nextitem($sql, "changes=0");
        else $sql=nextitem($sql, "changes=changes + $v[changes]");
      }
      if (isset($v["magskill"])) {
        $sql=nextitem($sql, "mfire=mfire+$v[magskill], mwater=mwater+$v[magskill], mair=mair+$v[magskill], mearth=mearth+$v[magskill]");
        $this->battleunits[$k]["mfire"]+=$v["magskill"];
        $this->battleunits[$k]["mwater"]+=$v["magskill"];
        $this->battleunits[$k]["mair"]+=$v["magskill"];
        $this->battleunits[$k]["mearth"]+=$v["magskill"];
      }
      if (@$v["resurrect"]) {
        $sql=nextitem($sql, "resurrect=resurrect+$v[resurrect]");
        $this->battleunits[$k]["resurrect"]+=$v["resurrect"];
      }
      if (isset($v["p1"])) {
        $sql=nextitem($sql, "p1='$v[p1]'");
        $this->battleunits[$k]["p1"]=$v["p1"];
      }
      if (isset($v["p2"])) {
        $sql=nextitem($sql, "p2='$v[p2]'");
        $this->battleunits[$k]["p2"]=$v["p2"];
      }
      if (@$v["forcefield"]) {
        $sql=nextitem($sql, "forcefield=forcefield+$v[forcefield]");
        if ($v["forcefield"]>0)$this->battleunits[$k]["forcefield"]+=$v["forcefield"];
      }
      if (@$v["manabarrier"]) {
        $sql=nextitem($sql, "manabarrier=manabarrier+$v[manabarrier]");
        if ($v["manabarrier"]>0)$this->battleunits[$k]["manabarrier"]+=$v["manabarrier"];
      }
      if (@$v["mbstroke"]) {
        $sql=nextitem($sql, "mbstroke=$v[mbstroke]");
        $this->battleunits[$k]["mbstroke"]+=$v["mbstroke"];
      }
      if (isset($v["follow"])) {
        $sql=nextitem($sql, "follow='$v[follow]'");
      }
      if ($v["laststroke"]) {
        $sql=nextitem($sql, "laststroke='$v[laststroke]'");
      }
      if ($v["casts"]) {
        $sql=nextitem($sql, "casts='$v[casts]'");
      }
      if ($v["effects"]) {
        $sql=nextitem($sql, "effects='".serialize($this->battleunits[$k]["effects"])."'");
      }
      if ($v["priems"]) {
        $sql=nextitem($sql, "priems='".serialize($this->battleunits[$k]["priems"])."'");
      }
      if ($sql) mq("update battleunits set $sql where battle='".$this->battle_data["id"]."' and user='$k'");
    }
  }
  $this->toupdatebu=array();
}

/*------------------------------------------------------------------
 сейвим бой
--------------------------------------------------------------------*/
function update_battle () {
  global $user;
  $this->needupdate=0;
  if (@$this->toupdate) {
    foreach ($this->toupdate as $k=>$v) {
      $sql="";
      if (@$v["sethp"]) {
        $sql=nextitem($sql, "hp='$v[sethp]'");
        if ($k==$user["id"] && USERBATTLE) {
          $user["hp"]=$v["sethp"];
          if ($user["hp"]<0) {
            $user["hp"]=0;
            $this->needrefresh=1;
          }
          $this->userdata[$k]["hp"]=$v["sethp"];
        }
      } elseif (@$v["hp"]) {
        $sql=nextitem($sql, "hp=hp+$v[hp]");
        if ($k==$user["id"] && USERBATTLE) {
          $user["hp"]+=$v["hp"];
          if ($user["hp"]<0) {
            $user["hp"]=0;
            $this->needrefresh=1;
          }
        }
      }
      if (@$v["setmana"]) {
        $sql=nextitem($sql, "mana='$v[setmana]'");
        if ($k==$user["id"] && USERBATTLE) {
          $user["mana"]=$v["mana"];
          $this->userdata[$k]["mana"]=$v["setmana"];
        }
      } elseif (@$v["mana"]) {
        if ($k==$user["id"] && USERBATTLE) {
          $user["mana"]+=$v["mana"];
          if ($user["mana"]<0) $user["mana"]=0;
          if ($user["mana"]>$user["maxmana"]) $user["mana"]=$user["maxmana"];
        }
        if ($v["mana"]>0) $sql=nextitem($sql, "mana=if(mana+$v[mana]>maxmana, maxmana, mana+$v[mana])");
        else $sql=nextitem($sql, "mana=if(mana+$v[mana]>0, mana+$v[mana], 0)");
      }
      if (@$v["die"]) {
        $this->userdata[$k]["hp"]=0;
        $sql="hp=0";
      }
      if ($k>_BOTSEPARATOR_) {
        if ($sql) mq("update bots set $sql where id='$k'");
      } else {
        if (@$v["hit"]) {
          if ($k==$user["id"] && USERBATTLE) $user["hit"]=min($user["hit"]+$v["hit"],25);
          $sql=nextitem($sql, "hit=if(hit+$v[hit]>25,25,hit+$v[hit])");
        }
        if (@$v["krit"]) {
          if ($k==$user["id"] && USERBATTLE) $user["krit"]=min($user["krit"]+$v["krit"],25);
          $sql=nextitem($sql, "krit=if(krit+$v[krit]>25,25,krit+$v[krit])");
        }
        if (@$v["counter"]) {
          if ($k==$user["id"] && USERBATTLE) $user["counter"]=min($user["counter"]+$v["counter"],25);
          $sql=nextitem($sql, "counter=if(counter+$v[counter]>25,25,counter+$v[counter])");
        }
        if (@$v["block2"]) {
          if ($k==$user["id"] && USERBATTLE) $user["block2"]=min($user["block2"]+$v["block2"],25);
          $sql=nextitem($sql, "block2=if(block2+$v[block2]>25,25,block2+$v[block2])");
        }
        if (@$v["parry"]) {
          if ($k==$user["id"] && USERBATTLE) $user["parry"]=min($v["parry"]+$user["parry"],25);
          $sql=nextitem($sql, "parry=if(parry+$v[parry]>25,25,parry+$v[parry])");
        }
        if (@$v["hp2"]) {
          if (@$v["hp2"]>10) $v["hp2"]=10;
          if ($k==$user["id"] && USERBATTLE) $user["hp2"]=min($v["hp2"]+$user["hp2"],25);
          $sql=nextitem($sql, "hp2=if(hp2+$v[hp2]>25,25,hp2+$v[hp2])");
        }
        if (@$v["s_duh"]) {
          $sql=nextitem($sql, "s_duh=s_duh+$v[s_duh]");
          if ($k==$user["id"] && USERBATTLE) $user["s_duh"]+=$v["s_duh"];
        }
        if ($sql) mq("update users set $sql where id='$k'");
      }
      if (!@$this->userdata[$k]["maxhp"]) {
        $this->makeuserdata($k);
      }
      if ($this->userdata[$k]["hp"]<=0) {
        if ($k==$this->user["id"]) $this->userdata[$k]["killer"]=$this->enemy;
        else $this->userdata[$k]["killer"]=$this->user["id"];
      }
    }
  }
  $this->toupdate=array();
  $sql="";
  foreach ($this->toupdatebattle as $k=>$v) {
    if ($k=="to1" || $k=="to2") $sql.=", $k='$v' ";
  }
  foreach ($this->battle as $k=>$v) {
    if (isset($this->userdata[$k]) && $this->userdata[$k]["hp"]<=0) {
      $this->killplayer($k);
    }
  }
  if ($this->needupdate) {
    $this->update_battle();
  } else {  
    if ($this->log) {
      $this->write_log();
    }
    mq('UPDATE `battle` SET `userdata` = \''.serialize($this->userdata).'\', `exp` = \''.serialize($this->exp).'\', `teams` = \''.serialize($this->battle).'\', `damage` = \''.serialize($this->damage).'\' '.$sql.' WHERE `id` = '.$this->battle_data['id'].' ;');
  }
  if ($this->needupdatebu) $this->updatebattleunits();
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
  function logline($text) {
    $this->add_log("<span class=date>".date("H:i")."</span> $text <BR>");
  }
  function add_log ($text, $atstart=1) {
    if ($atstart) $this->log = $this->log.$text;
    else $this->log = $text.$this->log;
    $this->nologhr=0;
  }

  function write_log () {
    global $user;
    if($this->log){
      if (!$this->nologhr) $this->log=$this->log."<hr>";
    } else return;

    //mq('UPDATE `logs` SET `log` = CONCAT(`log`,\''.$this->log.'\') WHERE `id` = '.$this->user['battle'].'');
    $fp = fopen (DOCUMENTROOT."backup/logs/battle".$this->user['battle'].".txt","a"); //открытие
    flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
    fputs($fp , $this->log); //работа с файлом
    fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
    flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
    fclose ($fp); //закрытие
    $this->log = '';
  }

  function gethpduh($i) {
    if ($i>_BOTSEPARATOR_) {
      $rec=mqfa("select hp, prototype from bots where id='$i'");
      return $rec;
    } else {
      $this->getbu($i);
      $ret=mqfa("select hp, maxhp, sex from users where id='$i'");
      $ret["s_duh"]=$this->battleunits[$i]["additdata"]["s_duh"];
      return $ret;
    }
  }

      function write_stat ($text) {
          /*
          $fp = fopen ("backup/stat/battle".$this->user['battle'].".txt","a"); //открытие
          flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
          fputs($fp , $text."\n"); //работа с файлом
          fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
          flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
          fclose ($fp); //закрытие
          */
      }
      function write_stat_block ($text) {
          /*
          $fp = fopen ("backup/stat/battle_block".$this->user['battle'].".txt","a"); //открытие
          flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
          fputs($fp , $text."\n"); //работа с файлом
          fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
          flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
          fclose ($fp); //закрытие
          */
      }

      function add_debug ($text) {
          $this->log_debug .= $text;
      }

      function write_debug () {
          //mq('UPDATE `logs` SET `log` = CONCAT(`log`,\''.$this->log.'\') WHERE `id` = '.$this->user['battle'].'');
          /*
echo $this->log_debug;

          $fp = fopen ("backup/debug/battle".$this->user['battle'].".txt","a"); //открытие
          flock ($fp,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
          fputs($fp , $this->log_debug) ; //работа с файлом
          fflush ($fp); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
          flock ($fp,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
          fclose ($fp); //закрытие
          $this->log_debug = '';
          */

//die();
      }


    }

// ========================================================================================================================================================
// конец исполняемого кода битвы
//=========================================================================================================================================================

if (USERBATTLE) {
$fbattle = new fbattle($user['battle']);
if (@$_GET["killplayer"]) {
  $kp=(int)$_GET["killplayer"];
  if ($fbattle->battle[$kp]) {
    $lasthit=0;
    $hasenemy=0;
    foreach ($fbattle->battle[$kp] as $k1=>$v1) {
      if (!$fbattle->userdata[$k1]["hp"] || $fbattle->userdata[$k1]["hp"]<=0 || $fbattle->sameteam($kp, $k1)) continue;
      if ($v1[2]>$lasthit) $lasthit=$v1[2];
      if (!$v1[0]) $hasenemy=1;
    }
    if ($hasenemy && $fbattle->battle_data["timeout"]*60+$lasthit<time()) {
      $fbattle->toupdate[$kp]["die"]=1;
      $fbattle->needupdate=1;
      $fbattle->add_log("<span class=date>".date("H:i")."</span> <b>".mqfa1("select login from users where id='$kp'")."</b> проиграл по таймауту.<BR>");
      $fbattle->write_log();
    }
  }
}

$fbattle->getbu($user["id"]);
$fbattle->getadditdata($user["id"]);

if (@$_GET['use'] && $user["hp"]>0 && $fbattle->battle_data["type"]!=4) {
  if ($_GET["use"]=="p1" || $_GET["use"]=="p2") {
    if ($fbattle->battleunits[$user["id"]][$_GET["use"]]) {
      $p=unserialize($fbattle->battleunits[$user["id"]][$_GET["use"]]);
      if ($p["prototype"]==1904) {
        $fbattle->addmana(100, $user["id"]);
        $fbattle->logline($fbattle->nick5($user["id"])." понимая, что настало время действовать, использовал".($user["sex"]==1?"":"а")." <b>$p[name]</b> <b>+100</b> ".$fbattle->logmana($user["id"]));
      }
      if ($p["prototype"]==1903) {
        $added=$fbattle->addhp(ceil(($user["maxhp"]-$user["hp"])/10), $user["id"], 1);
        //$user["hp"]=min($user["hp"]+$added, $user["maxhp"]);
        $fbattle->logline($fbattle->nick5($user["id"])." понимая, что настало время действовать, использовал".($user["sex"]==1?"":"а")." <b>$p[name]</b> <b>+$added</b> ".$fbattle->loghp($user["id"]));
      }
      destructitem($p["id"]);
      $fbattle->toupdatebu[$user["id"]][$_GET["use"]]="";
      $fbattle->needupdatebu=1;
      $report="Успешно использован предмет \"$p[name]\".";
    }
  } else {
    function getscrollslot($s) {
      global $user;
      $i=0;
      while ($i<12) {
        $i++;
        if ($user["m$i"]==$s) return $i;
      }
    }

    $_GET['use']=(int)$_GET['use'];
    $wait=0;
    $slot=getscrollslot($_GET["use"]);
    if (!$fbattle->battleunits[$user["id"]]["additdata"]["scrollused"] && $fbattle->battleunits[$user["id"]]["additdata"]["scrolls"][$slot]["wait"]==0) {
      $scrollname=$fbattle->battleunits[$user["id"]]["additdata"]["scrolls"][$slot]["name"];
      $dressed=mysql_fetch_row(mq("SELECT id FROM inventory WHERE id=".$_GET['use']." AND dressed='1'"));
      if ((int)$dressed[0]>0) {
        $my_class = $fbattle->my_class;
        ob_start();
        if (usemagic($_GET['use'],"".$_POST['target'])) {
          //$scrolls=getscrolls();
          //mq("update battleunits set scrolls='".addslashesa(serialize($scrolls))."' where battle='$user[battle]' and user='$user[id]'");
          //$fbattle->battleunits[$user["id"]]["scrolls"]=$scrolls;
          $mi=magicinf($fbattle->battleunits[$user["id"]]["additdata"]["scrolls"][$slot]["magic"]);
          function samemagic($m1, $m2) {
            $tactics=array(31,32,33,34,35);
            if (in_array($m1, $tactics) && in_array($m2, $tactics)) return true;
            return $m1==$m2;
          }
          if ($mi["wait"]) {
            $i=0;
            while ($i<12) {
              $i++;
              if (samemagic($fbattle->battleunits[$user["id"]]["additdata"]["scrolls"][$i]["magic"],$mi["id"])) 
              $fbattle->battleunits[$user["id"]]["additdata"]["scrolls"][$i]["wait"]=$mi["wait"];
            }
          }
          $fbattle->battleunits[$user["id"]]["additdata"]["scrolls"][$slot]["duration"]++;
          if ($fbattle->battleunits[$user["id"]]["additdata"]["scrolls"][$slot]["duration"]>=$fbattle->battleunits[$user["id"]]["additdata"]["scrolls"][$slot]["maxdur"]) $fbattle->battleunits[$user["id"]]["additdata"]["scrolls"][$slot]=0;
          $fbattle->battleunits[$user["id"]]["additdata"]["scrollused"]=1;
          $fbattle->needupdateaddit[$user["id"]]=1;
        }
        $bb = explode("<!--",ob_get_clean());
        $bb = str_replace('"',"&quot;",(strip_tags($bb[0])));
        if (@$updatebattleunit) {
          if ($updatebattleunit>_BOTSEPARATOR_) $hp=mqfa1("select hp from bots where id='$updatebattleunit'");
          else $hp=mqfa1("select hp from users where id='$updatebattleunit'");
          $fbattle->userdata[$updatebattleunit]["hp"]=$hp;
          $fbattle->update_battle();
          //$fbattle->chardata[$updatebattleunit]["hp"]=$hp;
        }
        $report=$bb;
        if (@$scrollresult) {
          if (@$scrollresult["logtype"]==1) {
            if (@$scrollresult["damage"])
            $fbattle->logline($fbattle->nick5($user["id"])." $scrollresult[action] ".$fbattle->nick5($scrollresult["target"])." <b> -".$scrollresult["damage"]."</b></font> ".($fbattle->loghp($scrollresult["target"]))."<BR>");
          } elseif (@$scrollresult["selfcast"]) {
            $fbattle->logline($fbattle->nick5($user["id"])." использовал".($user["sex"]==1?"":"а")." заклятие <b>$scrollname</b>.<BR>");
          } elseif (@$scrollresult["deltahp"]) {
            $fbattle->getbu($scrollresult["target"]);
            $ghp=$fbattle->addhp($scrollresult["deltahp"], $scrollresult["target"]);
            if ($fbattle->battleunits[$scrollresult["target"]]["sex"]) $a=""; else $a="а";
            $fbattle->add_log('<span class=date>'.date("H:i").'</span> '.$fbattle->nick5($user["id"]).' использовал'.($user["sex"]?"":"а").' заклятие <b>'.$scrollname."</b> ".(($scrollresult["target"]!=$user['id'])?"на ".$fbattle->nick5($scrollresult["target"],$fbattle->my_class):"").' и восстановил'.($user["sex"]?"":"а").' уровень жизни <B>+'.$ghp.'</B> '.$fbattle->loghp($scrollresult["target"]).'<BR>');
            $report="Успешно использован свиток $scrollname";
          } else $report=$scrollresult["report"];
        }
        //Header("Location: ".$_SERVER['PHP_SELF']."?buf=".$bb);
      } else die();
    }
  }
}

if (@$_GET["killown"] && $fbattle->battle_data["type"]!=UNLIMCHAOS && $fbattle->battle_data["type"]!=3 && $fbattle->battle_data["type"]!=10 && ($fbattle->battle_data["leader1"]==$user["id"] || $fbattle->battle_data["leader2"]==$user["id"])) {
  $target=$fbattle->getid($_POST["target"]);
  if ($target==$user["id"]) {
    $report="<b><font color=red>Себя, пожалуй, не стоит исключать из боя.</b></font>";
  } elseif (!$target) {
    $report="<b><font color=red>Персонаж \"$_POST[target]\" не найден.</b></font>";
  } elseif (in_array($target, $fbattle->team_enemy)) {
    $report="<b><font color=red>Можно исключить из боя только персонажей своей команды.</b></font>";
  } else {
    $fbattle->toupdate[$target]["die"]=1;
    $fbattle->needupdate=1;
    $fbattle->add_log("<span class=date>".date("H:i")."</span> <span class=\"".$fbattle->my_class."\">".($user["invis"]?"Невидимка":$user["login"])."</span> исключил".($user["sex"]==1?"":"а")." из боя персонажа <span class=\"".$fbattle->my_class."\">".$fbattle->userdata[$target]["login"]."</span>.<BR>");
    $fbattle->write_log();
  }
}
if (@$_GET["changeenemy"]) {
  $target=$fbattle->getid($_POST["target"]);
  if ($fbattle->battleunits[$user["id"]]["changes"]<1) {
    $report="<b><font color=red>У вас больше нет смен противника.</b></font>";
  } elseif ($fbattle->battle[$user['id']][$target][0]) {
    $report="<b><font color=red>На этого персонажа уже поставлен удар.</b></font>";
  } elseif ($fbattle->battleunits[$user["id"]]["follow"] && ($fbattle->battle[$user["id"]][$fbattle->battleunits[$user["id"]]["follow"]][0]==0)) {
    $report="<b><font color=red>На вас использован приём преследование.</b></font>";
  } elseif ($target){
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
    
    if ($target==$fbattle->enemy) {
      $report="Это текущий противник.";
    } elseif ($found) {
      $fbattle->toupdatebu[$fbattle->user["id"]]["enemy"]=$target;
      $fbattle->toupdatebu[$fbattle->user["id"]]["changes"]=-1;
      $fbattle->needupdatebu=1;
      $fbattle->enemy=$target;
      $fbattle->battleunits[$user["id"]]["changes"]--;
      $enemy=$target;
    } else $report="<b><font color=red>Персонаж не найден.</b></font>";
  } else $report="<b><font color=red>Персонаж \"$_POST[target]\" не найден.</b></font>";
}
if (@$_REQUEST['special']) {
  if (!$fbattle->enemy) {
    if ((@$strokes[$_REQUEST['special']]->type==4 && (!@$strokes[$_REQUEST['special']]->selfcast || @$strokes[$_REQUEST['special']]->move)) ||
    (@$strokes[$_REQUEST['special']]->type==3 && (@$strokes[$_REQUEST['special']]->instantdamage || @$strokes[$_REQUEST['special']]->blockchanges))) {
      $_REQUEST['special']=0;
      $_POST["main"]='';
      $report="Для этого приёма необходим противник.";
    }
  }
  if (@$strokes[$_REQUEST['special']]->target) {
    $i=$fbattle->getid($_POST["main"]);
    if ($_POST["main"]==$user["login"]) $i=$user["id"];
    //$i=mqfa1("select id from bots where name='$_POST[main]' and battle='".$fbattle->battle_data["id"]."'");
    //if (!$i) $i=mqfa1("select id from users where login='$_POST[main]'");
    
    if (!$i) {
      $report="<b><font color=red>Персонаж $_POST[main] не найден.</b></font>";
      $_REQUEST['special']=0;
    } elseif ($strokes[$_REQUEST['special']]->target=="enemy") {
      if (!in_array($i, $fbattle->team_enemy)) {
        $i=0;
        $_REQUEST['special']=0;
        $report="<b><font color=red>Этот приём нельзя использовать на своего.</b></font>";
      } else {
        if ($fbattle->battle[$user["id"]][$i][0] && 0) { //запрет каста в того, по кому проставлен удар
          $i=0;
          $_REQUEST["special"]=0;
          $report="<b><font color=red>Вы ожидаете ответа от этого персонажа.</b></font>";
        } elseif (@$strokes[$_REQUEST['special']]->move) {
          if ($i<_BOTSEPARATOR_ && $fbattle->enemy>_BOTSEPARATOR_) {
            $i=0;
            $_REQUEST['special']=0;
            $report="<b><font color=red>Ваш текущий противник загораживает цель.</b></font>";
          } elseif ($i!=$fbattle->enemy) {
            $fbattle->getbu($i);
            $fbattle->getbu($fbattle->enemy);
            //if ($fbattle->battleunits[$i]["level"]>$fbattle->battleunits[$fbattle->enemy]["level"]) $minval=$fbattle->battleunits[$i]["cost"]*(1+(($fbattle->battleunits[$i]["level"]-$fbattle->battleunits[$fbattle->enemy]["level"])/2));
            //else $minval=$fbattle->battleunits[$i]["cost"]*(pow(0.9, $fbattle->battleunits[$fbattle->enemy]["level"]-$fbattle->battleunits[$i]["level"]));
            //$minval=$fbattle->minval($i, $fbattle->enemy);
            if ($fbattle->battleunits[$fbattle->enemy]["hasshield"]) {
              $report="<b><font color=red>Щит противника загораживает цель.</b></font>";
              $i=0;
              $_REQUEST['special']=0;
            } elseif ($fbattle->cantgettatic($i, $fbattle->enemy)) {
            //$fbattle->battleunits[$fbattle->enemy]["cost"]*1.5<$minval) {qqq
              $report="<b><font color=red>Ваш противник слишком слаб, чтобы вы могли прочесть заклинание на ".$fbattle->userdata[$i]["login"].".</b></font>";
              $i=0;
              $_REQUEST['special']=0;
            }
          }
        }
      }
      if (isset($fbattle->battle[$i])) {
        $stroketarget=$i;
      } elseif ($i) {
        $i=0;
        $_REQUEST['special']=0;
        $report="<b><font color=red>Персонаж уже мёртв или не в бою.</b></font>";
      }
    } elseif ($strokes[$_REQUEST['special']]->target=="ally") {
      if (in_array($i, $fbattle->team_enemy)) {
        $i=0;
        $_REQUEST['special']=0;
        $report="<b><font color=red>Этот приём нельзя использовать на врага.</b></font>";
      }
      if (@$fbattle->battle[$i]) {
        $stroketarget=$i;
      }
      if (!$stroketarget) {
        if (!$report) $report="<b><font color=red>Персонаж не участвует в бою или уже умер.</font>";
        $_REQUEST['special']=0;
      }
    } elseif ($strokes[$_REQUEST['special']]->target=="both") {
      if (@$strokes[$_REQUEST['special']]->deadtarget) {
        if (!@$fbattle->userdata[$i]) {
          $report="<b><font color=red>Персонаж не участвует в бою.</font>";
          $_REQUEST['special']=0;
        } elseif (@$fbattle->userdata[$i]["hp"]>0) {
          $report="<b><font color=red>Персонаж $_POST[main] ещё не умер.</font>";
          $_REQUEST['special']=0;
        } elseif (@$strokes[$_REQUEST['special']]->noeffect) {
          $fbattle->getbu($i);
          foreach ($fbattle->battleunits[$i]["effects"] as $k=>$v) {
            if ($v["effect"]==$strokes[$_REQUEST['special']]->noeffect){
              $report="<b><font color=red>На персонажа $_POST[main] уже использован этот приём.</font>";
              $_REQUEST['special']=0;
              break;
            }
          }
          if ($_REQUEST['special']) $stroketarget=$i;
        } else {
          $stroketarget=$i;
        }
      } else {
        if (@$fbattle->battle[$i]) {
          $stroketarget=$i;
        }
        if (!$stroketarget) {
          $report="<b><font color=red>Персонаж не участвует в бою или уже умер.</font>";
          $_REQUEST['special']=0;
        }
      }
    }
    if ($stroketarget && $_REQUEST['special']) {
      $fbattle->getbu($stroketarget);
      foreach ($fbattle->battleunits[$stroketarget]["effects"] as $k=>$v) {
        if ($v["effect"]==IMMUNITY) {
          $tmp=explode("-", $k);
          if (eqstrokes($tmp[0], $_REQUEST['special'])) {
            $report="<b><font color=red>У персонажа $_POST[main] иммунитет к этой магии.</b></font>";
            $_REQUEST['special']=0;
            $stroketarget=0;
            break;
          }
        }
      }
    }                                                
    if (@$strokes[$_REQUEST['special']]->move && (!$fbattle->enemy || $fbattle->battle[$user['id']][$fbattle->enemy][0])) {
      //echo "<b><font color=red>Персонаж $_POST[main] ещё не ответил.</b></font>";
      $_REQUEST['special']=0;
      $_SESSION['enemy']=$fbattle->getenemy();
      $fbattle->enemy=$_SESSION["enemy"];
    }
  } elseif (@$strokes[$_REQUEST['special']]->currenttarget) {
    $stroketarget=$fbattle->getenemy();
  }
  if ($stroketarget) $fbattle->getbu($stroketarget);
  if ($stroketarget && @$strokes[$_REQUEST['special']]->targeteffect) {
    if (!$fbattle->haseffect($stroketarget, $strokes[$_REQUEST['special']]->targeteffect)) {
      $report="<b><font color=red>На цели нет необходимого эффекта.</b></font>";
      $_REQUEST['special']=0;
    }
  }
  if ($stroketarget && @$strokes[$_REQUEST['special']]->targethp) {
    if ($fbattle->userdata[$stroketarget]["maxhp"]*$strokes[$_REQUEST['special']]->targethp/100<$fbattle->userdata[$stroketarget]["hp"]) {
      $report="<b><font color=red>У цели должно быть менее ".$strokes[$_REQUEST['special']]->targethp." % жизни.</b></font>";
      $_REQUEST['special']=0;
    }
  }
}

if (@$fbattle->enemy && @$_POST["emptyhit"] && $user["hp"]>0) {
  $lasthit=0;
  foreach ($fbattle->battle[$user["id"]] as $k=>$v) {
    if ($v[2]>$lasthit) $lasthit=$v[2];
  }
  $timeleft=$fbattle->battle_data["timeout"]*60+$lasthit-time();
  if ($timeleft<=1) {
    $fbattle->razmen_init ($fbattle->enemy,664,664,0,0,0,0);
    $fbattle->write_log();
  }
}

if (@$_REQUEST['special'] && $user["hp"]>0) {
  $priem2=str_replace(array('"',"'","\\"),array('','',''),$_REQUEST['special']);




  $res=unserialize($fbattle->battleunits[$user["id"]]["puton"]);
  foreach ($res as $k=>$v) {
    $puton[$v["slot"]]=$strokes["ids"][$v["id_thing"]];
  }
  /*$puton=array();

  $res=mq("select slot,id_thing from puton where id_person='".$_SESSION['uid']."' and slot>=201 and slot<=210;");
  while($s=mysql_fetch_array($res)) {
    $res4=mysql_fetch_array(mq("select priem from priem where id_priem='".$s['id_thing']."';"));
    $puton[$s['slot']]=$res4['priem'];
  }
  print_r($puton);*/

  $igogo=$fbattle->getpriems($_SESSION['uid']);
  for ($i=201;$i<=220;$i++) {
    if($puton[$i]==$priem2){$priem=$priem2; break;}
  }

  $have_priem=true;$p=&new prieminfo(0,$priem);

  if ($have_priem) {
    # проверить можно ли
    $enable=true;
    # проверить по статам
    if ($p->checkbattlehars(@$myinfo,$igogo[$priem]["uses"])) {

      # можно ипользовать если: прошел срок wait - это в случае если задан wait в параметрах приема
      $act=&$igogo[$priem];
      $sh=$fbattle->getshock($user["id"]);
      if ($sh && !@$strokes[$priem]->noshock) {
        $enable=false;echo "<font color=red>Вы находитесь в состоянии шока.</font>";
      } elseif ($p->wait) {
        if ($act['wait']>0) {
          $enable=false;$report="<font color=red>нельзя использовать: еще идет задержка </font>";
        }
        if ($act['active']!=1) {
          $enable=false;$report="<font color=red>нельзя использовать: уже активен</font>";
        }
      }else{
       if ($act['active']!=1) {$enable=false;echo "<font color=red>нельзя использовать: уже активен</font>";}
      }
    } else {
      $enable=false;$report="<font color=red>нельзя использовать: не хватает требований</font>";
    }
    if ($enable) {
      $ok=false;
      if (@$strokes[$ch_priem[$priem]]) $ok=true;
      if ($strokes[$priem]) $ok=true;
      if ($ok) {
        #1) $act['active'] - активен -> UPDATE
        #2) $act['active']<1 - неактивен НО есть $act['uses']>0 -> UPDATE
        #3) $act['uses'] <1 -> INSERT
        /*if ($act['uses']>0) {
          mq("update person_on set pr_cur_uses=pr_cur_uses+1".($p->wait?',pr_wait_for='.$p->wait:'')."
          WHERE id_person='".$_SESSION['uid']."' and type=3 and pr_name='".$priem."'");
        }*/
        /////здесь будут заюзываться приемы/////
        $emptyhit=0;
        $sumwear=$fbattle->battleunits[$user["id"]]["weapons"];
        include 'incl/usepriems.php';
        $takenbybarrier=array();
        if (@$strokes[$priem]->refresh) {
          //if (!NOREFRESH) header ("Location:fbattleb.php?fd=".$fbattle->enemy);
          $fbattle->needupdate=1;
          //die;
        }
        if(@$_POST['enemy']>0 && $emptyhit) {
          // ударяемся
          if($user['room']!=403 && $user['room']!=20 && $user['room']!=903){include "astral.php";}
          $fbattle->razmen_init ($_POST['enemy'],$_POST['attack'],$_POST['defend'],$_POST['attack1'],$_POST['attack2'],$_POST['attack3'],$_POST['attack4']);
          //if (!NOREFRESH) header ("Location:fbattleb.php");
          //die;
        }
        $fbattle->write_log();
        if (!$strokefailed) $report="Успешно использован приём ".$strokes[$priem]->name.".";
      }#/ok
    }#enable
  } else {
    echo "<font color=red>нет такого приема на персонаже</font>";
  }
}

$fbattle->checkbotstrokes($fbattle->battleunits[$user["id"]]["enemy"]);
if ($fbattle->needupdatebu) {
  $fbattle->updatebattleunits();
}
if ($fbattle->needupdate) {
  $fbattle->update_battle();
  if ($fbattle->return==1) {
    $enemypers=showbattlepers($fbattle->enemy, 0, $user["battle"]);
  }
  if (@$fbattle->needrefresh || $pershp<=0) {
    if ($pershp<=0) $fbattle->killplayer($fbattle->enemy);
    mq("UNLOCK TABLES;");
    foreach ($newbus as $k=>$v) {
      mq("insert into archive.battleunits (select * from battleunits where id='$v')");
    }
    header ("Location:fbattleb.php?".time()."&if=".@$_GET["if"]);
    $fbattle->updateaddit();
    die;
  }
} else {
  if ($fbattle->return==1) {
    $enemypers=showbattlepers($fbattle->enemy, 0, $user["battle"]);
  }
}

$fbattle->needupdate=0;

$s_duh=$fbattle->battleunits[$user["id"]]["additdata"]['s_duh'];
$hit=$fbattle->battleunits[$user["id"]]["additdata"]['hit'];
$krit=$fbattle->battleunits[$user["id"]]["additdata"]['krit'];
$block=$fbattle->battleunits[$user["id"]]["additdata"]['block2'];
$parry=$fbattle->battleunits[$user["id"]]["additdata"]['parry'];
$hp=$fbattle->battleunits[$user["id"]]["additdata"]['hp2'];
$counter=$fbattle->battleunits[$user["id"]]["additdata"]['counter'];
$fbattle->checkend();

if ($fbattle->battleunits[$user["id"]]["defender"]) $fbattle->undefend($user["id"]);


?>
<HTML>
<HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<SCRIPT>
var def_zones;
function upddefzones(z) {
  if (z>=3) def_zones = 'головы, груди и живота;груди, живота и пояса;живота, пояса и ног;пояса, ног и головы;ног, головы и груди'.split(';');
  if (z==2) def_zones = 'головы и груди,груди и живота,живота и пояса,пояса и ног,ног и головы'.split(',');
  if  (z<2) def_zones = 'головы,груди,живота,пояса,ног'.split(',');

}
var attacks=<?
  echo (int)@$fbattle->battleunits[$user["id"]]["weapons"];
?>;  // кол. атак
</SCRIPT>
<SCRIPT src='<?=IMGBASE?>/i/fbattle2.js?7'></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="<?=IMGBASE?>/i/sl2.js?3"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="<?=IMGBASE?>/i/ch.js"></SCRIPT>

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
            <? //if ($_SERVER["REMOTE_ADDR"]!="127.0.0.1") 
            echo 'timerID=setTimeout("refreshPeriodic()",30000);'; ?>
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
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor="#e2e0e0">
<div id="screen">
<form name="emptyhit" action="fbattleb.php" method="post" style="margin:0px;padding:0px;visibility:hidden;display:none">
<input type=hidden name="emptyhit" value="1">
</form>
<?
$fbattle->write_log();
//print_r($fbattle->battleunits[7]["minimax"]);
//print_r($fbattle->battleunits[7]["minimax1"]);
//print_r($fbattle->userdata);
//print_r($fbattle->exp);
//$fbattle->takehp(1,4);
//$fbattle->getadditdata($fbattle->battleunits[7]["enemy"]);
//print_r($fbattle->battleunits[$fbattle->battleunits[7]["enemy"]]["additdata"]);
//print_r($fbattle->battleunits[7][effects]);
//print_r($fbattle->battleunits[$fbattle->battleunits[7]["enemy"]][effects]);
//print_r($fbattle->userdata);
//echo $fbattle->razmen_log("krit",4,mech,64,7,B1,2811,B2,9200,10000);
//$fbattle->killplayer(Array(id=>"10514252", "login" => "Отморозок (1)", "hp" => 5000, "maxhp"=> 5000));
//die;
/*if ($_SESSION["uid"]==7) {
  print_r($fbattle->exp);
  echo "-------------";
}*/
  if (!$user["battle"] || !$fbattle->battle) $ret=4;
  elseif (@$fbattle->return==2) $ret=1;
  else $ret=@$fbattle->return;
?>
<div id="mmoves3" style="background-color:#FFFFCC; visibility:hidden; z-index: 101; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px;"></div>

<div id=hint3 class=ahint></div>
<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; z-index: 100; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px;"></div>
<FORM action="<?
  echo $_SERVER['PHP_SELF'];
  if (!NOIFRAME) echo "?if=1";
?>" method=POST name="f1" id="f1" onKeyUp="set_action();" 
<?
  if ($ret!=4 && !NOIFRAME && !SHOWSOLVEDMF && !DIEAFTERSOLVEDMF) echo "target=\"hitbox\"";
?>>
<TABLE width="100%" cellspacing=0 cellpadding=0 border=0>
<TR><TD valign=top>
<input type=hidden value='<?=($user['battle']?$user['battle']:$_REQUEST['batl'])?>' name=batl><input type=hidden value='<?=@$enemy?>' name=enemy1>
<INPUT TYPE=hidden name=myid value="1053012363">
<TABLE width=250 cellspacing=0 cellpadding=0 id="f1t"><TR>
<TD valign=top width=250 nowrap>
<?
  $mystrokes=$fbattle->getpriems($user["id"]);
  if ($user["battle"]) echo showbattlepers($user["id"], 1, $user["battle"],$mystrokes);
  else echo showpersout($user['id'],1,1,1,1);
?>

</TD></TR>
</TABLE>

</td>
<td  valign=top width="80%">
<?
  switch($ret) {
    case 1:
      /*if($fbattle->enemy < _BOTSEPARATOR_){
        $unemli = mysql_fetch_array(mq("SELECT login,id,level,invis FROM `users` WHERE `id` = '".$fbattle->enemy."' LIMIT 1;"));
      } else {
        $unemli = mysql_fetch_array(mq("SELECT name,id,prototype FROM `bots` WHERE `id` = '".$fbattle->enemy."' LIMIT 1;"));
        $lvl_bo = mysql_fetch_array(mq("SELECT id,level,invis FROM `users` WHERE `id` = '".$unemli['prototype']."' LIMIT 1;"));
        if($lvl_bo){$unemli['level']=$lvl_bo['level']; $unemli['id']=$lvl_bo['id'];$unemli["invis"]=$lvl_bo['invis'];}else{$unemli['level']=$user['level'];}
        $unemli['login']=$unemli['name'];
      }*/
      $unemli["invis"]=$fbattle->battleunits[$fbattle->enemy]["invis"];
      $unemli["login"]=$fbattle->userdata[$fbattle->enemy]["login"];
      $unemli["level"]=$fbattle->battleunits[$fbattle->enemy]["level"];

      if ($unemli['invis']) {
        $enemynick="Невидимка";
        $_SESSION["invis"]=$fbattle->enemy;//getnick($fbattle->enemy);
      } else {
        $unemli["id"]=$fbattle->enemy;
        $enemynick=$unemli['login'];//getnick($fbattle->enemy);
      }
    ?>
       <TABLE border=0 width="100%" cellspacing=0 cellpadding=0><TR><TD colspan=3 style="font-size:3px">&nbsp;</td></tr>
       <TR><TD width="50%"><?echo "<b><a style=\"color=#003388\" onclick=\"top.AddTo('$user[login]');return false\" href=\"javascript:void(0)\">".$user['login']." [".$user['level']."]</a> <a href=\"inf.php?".$user['id']."\" target=_blank><IMG SRC=\"".IMGBASE."/i/inf.gif\" WIDTH=12 HEIGHT=11 ALT=\"Инф. о ".$user['login']."\"></a></b>";?></TD>
<td align="center"><div style="font-size:20px;font-weight:bold;padding-left:10px;line-height:15px;<? if ($user["id"]!=7) echo "visibility:hidden"; ?>">
</div></td>
<? if(@$unemli['invis']==1) {?>
  <TD align="right" width="50%"><?
  if ($fbattle->return==1) echo "<b><font color=#000>невидимка</b></font>";?></TD>
<?}else{?>
  <TD align="right" width="50%"><?
    if ($fbattle->return==1) echo "<b><a id=\"enemynick\" style=\"color=#003388\" onclick=\"top.AddTo('$unemli[login]');return false\" href=\"javascript:void(0)\">".$unemli['login']." [".$unemli['level']."]</a> <a href=\"inf.php?".$unemli['id']."\" target=_blank><IMG SRC=\"".IMGBASE."/i/inf.gif\" WIDTH=12 HEIGHT=11 ALT=\"Инф. о ".$unemli['login']."\"></a></b>";
?></TD>
<?}?>
                </TR>
<?
  if($user['level'] > 3) {
    if (@$_GET['buf']) $report=$_GET['buf'];
    
    if (!$fbattle->battleunits[$user["id"]]["additdata"]["scrolls"]) {
      $s=getscrolls();
      //mq();
      //mq("update battleunits set scrolls='".addslashesa(serialize($s))."' where battle='$user[battle]' and user='$user[id]'");
      $fbattle->battleunits[$user["id"]]["additdata"]["scrolls"]=$s;
      $fbattle->needupdateaddit[$user["id"]]=1;
    }
  }

?>

                <tr><td height=23 align="center" colspan=3 style="font-weight:bold;color:#ff0000">&nbsp;<?=@$report?></td></tr>
                </TABLE>
  
                <CENTER>
<?
  /*if ($fbattle->battleunits[$user["id"]]["additdata"]["scrollused"]) {
    $s=$fbattle->battleunits[$user["id"]]["scrolls"];
    $s=str_replace("<img ","<img style=\"filter:gray(), Alpha(Opacity='70');\" ", $s);
    $s=str_replace("onclick","", $s);
    $s=str_replace("href","", $s);
    echo $s;
  } else */
  echo echoscrolls($fbattle->battleunits[$user["id"]]["additdata"]["scrolls"]); 

  if ($fbattle->return==1) {
  ?>

<TABLE cellspacing=0 cellpadding=0><TR><TD align=center bgcolor="#f2f0f0"><b>Атака</b></TD><TD>&nbsp;</TD><TD align=center bgcolor="#f2f0f0"><b>Защита</b></TD></TR>
<TR><TD>
<div id="dots1"></div>
</TD><TD>&nbsp;</TD><TD>
<div id="dots0"></div>
                </TD></TR>
                <TR>
                    <TD colspan=3 align=center bgcolor="#f2f0f0">
<table cellspacing=0 cellpadding=0 width="100%" border=0><tr><td width=60>&nbsp;</td>
<td align=center id="buttons">
<?
$_SESSION['batl']=$user['battle'];
 ///ново////?>
</td>

<td align="right">
<? if ($fbattle->battleunits[$user["id"]]["changes"]>0) { ?>
<a href="javascript:void(0)" onClick="findlogin('Смена противника', 'fbattleb.php?changeenemy=1', 'target', '')"><img src='<?=IMGBASE?>/i/ico_change.gif' width=16 height=19 style='cursor:pointer' <?=fastshow("Смена противника (".$fbattle->battleunits[$user["id"]]["changes"].")");?>></a>
<? } ?>
&nbsp;
<a onClick="location.href='<?=$_SERVER['PHP_SELF']?>?batl=<?=@$_REQUEST['batl']?>';"><img src='<?=IMGBASE?>/i/ico_refresh.gif' width=16 height=19 style='cursor:pointer' <?=fastshow("Обновить")?>></a>
</td></tr></table><INPUT TYPE=hidden name=enemy value="<?=$fbattle->enemy?>"></TD>
                </TR>
            </TABLE><? } else { ?>                                   
            <div style="height:130px;text-align:center;color:#ff0000"><br><br><?
            if ($user["hp"]>0) echo "Ожидаем хода противника...";
            else echo "Для вас бой окончен. Ожидаем, пока бой окончат другие игроки.";
            ?></div>
<table cellspacing=0 cellpadding=0 width=310 align=center border=0><tr><td width=60>&nbsp;</td>
<td align=center>
&nbsp;
<INPUT TYPE=button value="Обновить" onClick="this.disabled = true; document.location.href='fbattleb.php';">
</td>

<td align="right">
&nbsp;
<a onClick="location.href='<?=$_SERVER['PHP_SELF']?>?batl=<?=@$_REQUEST['batl']?>';"><img src='<?=IMGBASE?>/i/ico_refresh.gif' width=16 height=19 style='cursor:pointer' <?=fastshow("Обновить")?>></a>

</td></tr></table>
            <? } ?>
<?
$_SESSION['enemy']=$fbattle->enemy;

  $igogo=$mystrokes;

  /*$i=0;
  while ($i<10) {
    $i++;
    if ($fbattle->battleunits[$user["id"]]["slot$i"]) {
      $puton[$i+200]=$i+200; // =new prieminfo($s['id_thing'],0);
      $puton2[$i+200]=$fbattle->battleunits[$user["id"]]["slot$i"];
    }
  }*/

  $res=unserialize($fbattle->battleunits[$user["id"]]["puton"]);
  foreach ($res as $k=>$s) {
    $puton[$s['slot']]=$s['slot'];
    $puton2[$s['slot']]=$s['id_thing'];
  }

  /*$res=mq("select slot,id_thing from puton where id_person='".$_SESSION['uid']."' and slot>=201 and slot<=210;");
  while ($s=mysql_fetch_array($res)) {
    $puton[$s['slot']]=$s['slot']; // =new prieminfo($s['id_thing'],0);
    $puton2[$s['slot']]=$s['id_thing'];
  }*/
  //print_r($puton);print_r($puton2);
?>
<div style="font-size:4px">&nbsp;</div>
<TABLE width=238><tr><TD width=34 align=center><SMALL><IMG alt='Нанесенный удар' width=8 height=8 src='/i/misc/micro/hit.gif'><?=$hit?></TD>
<TD width=34 align=center><SMALL><IMG alt='Критический удар' width=7 height=8 src='/i/misc/micro/krit.gif'><?=$krit?></TD>
<TD width=34 align=center><SMALL><IMG alt='Проведенный контрудар' width=8 height=8 src='/i/misc/micro/counter.gif'><?=$counter?></TD>
<TD width=34 align=center><SMALL><IMG alt='Успешный блок' width=7 height=8 src='/i/misc/micro/block.gif'><?=$block?></TD>
<TD width=34 align=center><SMALL><IMG alt='Успешное парирование' width=8 height=8 src='/i/misc/micro/parry.gif'><?=$parry?></TD>
<TD width=34 align=center><SMALL><IMG alt='Нанесенный урон' width=8 height=8 src='/i/misc/micro/hp.gif'><?=floor($hp)?></TD>
<TD width=34 align=center><SMALL><IMG alt='Уровень духа (<?=(number_format($s_duh/100,2))?>)' width=7 height=8 src='/i/misc/micro/spirit.gif'><?=1*number_format($s_duh/100,2)?></TD>
</tr></TABLE>
<?
$inssql="";
//////если есть одетые приемы, то втыкаем их в бой!..,
/*for ($i=201;$i<=210;$i++) {
  $p=&$puton[$i];
  if ($p) {
    $p2=new prieminfo($puton2[$i],0);
    $act=&$igogo[$p2->priem];
    if(!$act){
      if ($inssql) $inssql.=", ";
      $inssql.="( '".$_SESSION['uid']."',
      '".$_SESSION['uid']."', NOW() , 3, ".time().", NULL , '".$p2->priem."',1,".(@$strokes[$p2->priem]->startwait?$strokes[$p2->priem]->startwait:0).",1, $p2->target)";
    } else break;
  }
}
if ($inssql) {
  mq("INSERT INTO `person_on` ( `id_person` , `id_paladin` , `timestamp` , `type` , `timestamp2` ,
  `comment` , `pr_name` , `pr_active` , `pr_wait_for` , `pr_cur_uses` , `pr_target`) VALUES $inssql");
  $igogo=new ActivePriems($_SESSION['uid']);
}*/

$sh=$fbattle->getshock($user["id"]);

for ($i=201;$i<=220;$i++) {
  if ($i==211) echo "<br>";
  $p=&$puton[$i];
  if ($p) {
    
    $p2=new prieminfo($puton2[$i],0);
    $act=$igogo[$p2->priem];
    $enable=true;
    # проверить по статам
    if ($sh && !@$strokes[$p2->priem]->noshock) {
      $enable=false;
    } elseif ($p2->checkbattlehars(@$myinfo, $igogo[$p2->priem]["uses"])) {
      # можно ипользовать если: прошел срок wait - это в случае если задан wait в параметрах приема
      if ($act['wait']>0) {
        $enable=false;
      } elseif (!$fbattle->notmaxeffect($user["id"], $p2->priem) && !$strokes[$p2->priem]->notonlyeffect) {
        $enable=false;
      } elseif (@$strokes[$p2->priem]->eternal && $act['active']==1) {
        foreach ($fbattle->battleunits[$user["id"]]["effects"] as $k=>$v) {
          if (@$strokes[$k]->eternal) $enable=false;
        }
      } elseif ($act['active']!=1) {
        $enable=false;
      }
    } else {
      $enable=false;
    }
    # wait если есть активный - вывод сколько еще
    # uses - определить
    echo drawtrick($enable, $p2->priem, $p2->name, ($p2->hod?0:1), mysql_escape_string($p2->opisan),
    (0+$p2->n_hit).",".(0+$p2->n_krit).",".(0+$p2->n_counter).",".(0+$p2->n_block).",".(0+$p2->n_parry).",".(0+$p2->n_hp).",".(0+$p2->sduh).",".(0+$p2->mana).",".(0+$p2->wait).",".($act['wait']>0?$act['wait']:0).",".(0+$p2->maxuses).",".($p2->maxuses?$act['uses']-1:0).",".($p2->startwait?$p2->startwait:0),
    ($p2->target?"1":"0"),'','', remquotesjs($p2->target==1?"$enemynick":"$user[login]"), $p2->priem);
    /*echo "DrawTrick(";
    echo ($enable?'1,':'0,').
    "'".$p2->priem."','"
    .$p2->name."',"
    .($p2->hod?0:1).",'"
    .mysql_escape_string($p2->opisan)."','"
    .(0+$p2->n_hit).",".(0+$p2->n_krit).",".(0+$p2->n_counter).",".(0+$p2->n_block).",".(0+$p2->n_parry).",".(0+$p2->n_hp).",".(0+$p2->sduh).",".(0+$p2->mana).",".(0+$p2->wait).",".($act['wait']>0?$act['wait']:0).",".(0+$p2->maxuses).",".($p2->maxuses?$act['uses']-1:0).",".($p2->startwait?$p2->startwait:0)."',".($p2->target?"1":"0").",'','','".remquotesjs($p2->target==1?"$enemynick":"$user[login]")."','".$p2->priem."');";*/
  } elseif ($i<=210) {
    //echo "</script>";
    echo"<IMG style=\"\" width=40 height=25 src='".IMGBASE."/i/misc/icons/clear.gif'>";
  }
}

unset($i);
//echo"</script>";
if($user['zver_id']>0 && !incommontower($user) && $fbattle->battle_data["quest"]!=4){
  //$nb = mysql_fetch_array(mq("SELECT id FROM `bots` WHERE battle='".$fbattle->battle_data["id"]."' and prototype= '".$user['zver_id']."';"));
  if($fbattle->battleunits[$user["id"]]["petunleashed"]){$temn = "style=\"filter:gray(), Alpha(Opacity='70');\""; $ogogo=""; $ogogo2="";}else{$ogogo="<a href=\"?uszver=1\">"; $ogogo2="</a>";$temn="";}
  echo $ogogo."<img src=\"".IMGBASE."/i/sh/pet_unleash.gif\" ".$temn." onmouseout='hideshow();' onmouseover='fastshow2(\"<B>Выпустить зверя</B>\", this, event)'>".$ogogo2;
}
  echo $fbattle->showkillown();
?>
            </CENTER>
            <?
        break;
        case 2 :
            if(($user['hp']>0) && $fbattle->battle) {
                echo '<FONT COLOR=red>Ожидаем хода противника...</FONT>
                <center>'.$fbattle->showkillown().'</center>
                <BR><CENTER><INPUT TYPE=submit value="Обновить" name=',(($user['battle']>0)?"battle":"end"),'><BR></CENTER>';
            }
            elseif($user['hp'] <= 0 && $fbattle->battle) {
                if ($fbattle->battle_data["quest"]==2) {
                  mq("update users set battle=0 where id='$user[id]'");
                  echo '<FONT COLOR=red>Вы выбыли из строя...</FONT><BR><CENTER><INPUT TYPE=button value="Вернуться" onclick="document.location.href=\'main.php?'.time().'\';"><BR></CENTER>';
                } else {
                  $timeloser=0;
                  foreach ($fbattle->team_mine as $k=>$v) {
                    if ($fbattle->battle[$v]) {
                      $lasthit=0;
                      $hasenemy=0;
                      foreach ($fbattle->battle[$v] as $k1=>$v1) {
                        if ($v1[2]>$lasthit) $lasthit=$v1[2];
                        if (!$v1[0]) $hasenemy=1;
                      }
                      if ($hasenemy && $fbattle->battle_data["timeout"]*60+$lasthit<time()) {
                        $timeloser=$v;
                        break;
                      }
                    }
                  }
                  if ($timeloser) echo "<center><BR>Персонаж ".mqfa1("select login from users where id='$timeloser'")." долго не делает свой ход, вы можете исключить его из боя.<BR>
                    <INPUT TYPE=button value=\"Признать его проигравшим\" onclick=\"document.location.href='fbattleb.php?killplayer=$timeloser';\"><BR>
                    <INPUT TYPE=submit value=\"Подождать еще немного\" name=",(($user['battle']>0)?"battle":"end"),"></center>";
                  else echo '<FONT COLOR=red>Ожидаем, пока бой закончат другие игроки...</FONT>
                  <center>'.$fbattle->showkillown().'</center><BR>
                  <CENTER><INPUT TYPE=submit value="Обновить" name=',(($user['battle']>0)?"battle":"end"),'><BR></CENTER>';
                }
                //ref_drop ($user['id']);

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
            $ll=(int)$ll;
            $data = @mysql_fetch_array(mq ("SELECT damage,exp FROM `battle` WHERE `id` = {$ll}"));
            $damage = unserialize($data['damage']);
            $exp = unserialize($data['exp']);
                        if(empty($damage[$user['id']])){$damage[$user['id']]=0;}
            echo '<CENTER><BR>
                    <B><FONT COLOR=red>Бой закончен! Всего вами нанесено урона: ',(int)$damage[$user['id']],' HP. Получено опыта: ',(int)$exp[$user['id']],'.</FONT></B>
                    <BR><INPUT TYPE=submit value="Вернуться" name="end"><BR></CENTER>';
//mq('UPDATE `users` SET `hp2` = 0,`hp3` = 0,`hit` = 0,`s_duh` = 0,`krit` = 0,`counter` = 0,`block2` = 0,`parry` = 0  WHERE `id` = '.$_SESSION['uid'].'');
mq("DELETE FROM `person_on` WHERE `id_person`='".$_SESSION['uid']."'");
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
    $i=0;
    foreach ($fbattle->t1 as $k => $v) {
      if (in_array($v,array_keys($fbattle->battle))) {
        //if ($fbattle->userdata[$v]["hp"]<=0) continue;
        $i++;
        if ($i > 1) { $cc = ', '; } else { $cc = ''; }
        @$ffs .= $cc.bnick4($v,"B1");
        @$zz .= "private [".$fbattle->userdata[$v]["login"]."] ";
      }
    }
    /*if (strpos($ffs,"[-") || strpos($ffs,"[0")) {
      $fbattle->fast_death();
      header("location:fbattleb.php");
    }*/
    if ($i>0) echo "<IMG SRC=\"".IMGBASE."/i/lock.gif\" WIDTH=20 HEIGHT=15 BORDER=0 ALT=\"приват\" style=\"cursor:pointer\" onClick=\"Prv('$zz')\">    
    $ffs <b>против</b>";
    elseif ($user["hp"]>0 && $fbattle->batle_data["win"]!=3 && $user["battle"]) {
      mq("update users set battle=0 where id='$user[id]'");
      logerror("User stuck in battle $user[battle].");
    }
    
    $i=0;
    $ffs =''; $zz ='';
    foreach ($fbattle->t2 as $k => $v) {
        if (in_array($v,array_keys($fbattle->battle))) {
          //if ($fbattle->userdata[$v]["hp"]<=0) continue;
          $i++;
          if ($i > 1) { $cc = ', '; } else { $cc = ''; }
          @$ffs .= $cc.bnick4($v,"B2");
          @$zz .= "private [".$fbattle->userdata[$v]["login"]."] ";
        }
    }
    if ($user["hp"]>0 && $i==0 && $fbattle->batle_data["win"]!=3 && $user["battle"]) {
      logerror("User stuck in battle $user[battle].");
      mq("update users set battle=0 where id='$user[id]'");
    }

    /*if (strpos($ffs,"[-") || strpos($ffs,"[0")) {
      $fbattle->fast_death();
      header("location:fbattleb.php");
    }*/
    $i=0;
?>
<IMG SRC="<?=IMGBASE?>/i/lock.gif" WIDTH=20 HEIGHT=15 BORDER=0 ALT="приват" style="cursor:pointer" onClick="Prv('<?=$zz?> ')">
<?=$ffs?>
<HR>
</div>
<?
} else {
    echo "<HR>";
}

  if (VIEWDAMAGE) {
    echo "<table><tr><td><pre>";
    print_r($fbattle->damage);
    echo "</pre></td><td><pre>";
    print_r($fbattle->exp);
    echo "</pre></td></tr></table>";
  }
  
    if($user['battle']) { $ll = $user['battle'];} elseif($_REQUEST['batl']) { $ll = $_REQUEST['batl']; }else{$ll = $_SESSION['batl'];}
    //$log = mysql_fetch_array(mq("SELECT `log` FROM `logs` WHERE `id` = '".$ll."';"));
    //$log = file("./logs/battle".$ll.".txt");
    $ll=(int)$ll;
    $fs = filesize(DOCUMENTROOT."backup/logs/battle".$ll.".txt");
    $fh = fopen(DOCUMENTROOT."backup/logs/battle".$ll.".txt", "r");// or die("Can't open file!");
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
    //echo "<div id=\"log\" ".($user["battle"]?"style=\"display:none\"":"").">";
    $logoutput="";
    for($i=$ic;$i>=0+$max;--$i) {


if(eregi("<hr>",$log[$i])){
            $log[$i] = str_replace("<hr>","",$log[$i]);
                        $log[$i] = $log[$i]."<hr>";
}

        if(eregi(">".$user['login']."</span>",$log[$i])) {
            $log[$i] = str_replace("<span class=date>","<span class=date2>",$log[$i]);
        }
if(eregi("<hr>",$log[$i])){
        $logoutput.=$log[$i];
}else{
    $logoutput.=$log[$i]."<BR>";
}
    }
    unset($ic);

if ($max == 1 ) {
$logoutput.="Обрезано для уменьшения объема информации. Полную версию смотрите <a href=\"logs.php?log=$ll\" target=\"_blank\">здесь&raquo;</a><br>";
} 
  if (!$user["battle"]) echo $logoutput;

if(!$user['in_tower']){
?>
<font class=dsc>(Бой идет с таймаутом <?=$fbattle->battle_data['timeout']?> мин.)</font><BR>
<? } ?>
<? if ($user["battle"]) { ?>
<BR>
На данный момент вами нанесено урона: <B><?=(int)$fbattle->damage[$user['id']]?> HP</B>.
<? } ?>
</td>
<TD  valign=top align="right">
<TABLE width=250 cellspacing=0 cellpadding=0><TR>
<TD valign=top width=250 nowrap>
<?


if(@$fbattle->return == 1){
  echo $enemypers;
//showpersout($fbattle->enemy,1,1,1,0);
}else{

    if ($fbattle->battle_data['type']==4 OR $fbattle->battle_data['type']==5) {
        $a = array(6,16);
        echo "<img src='".IMGBASE."/i/im/",$a[rand(0,1)],".gif'>";
    } elseif (@$fbattle->return > 1) {
        echo "<img src='".IMGBASE."/i/im/",rand(1,34),".jpg'>";
    } elseif(@$exp[$user['id']] > 0) {
        echo "<img src='".IMGBASE."/i/im/",rand(113,115),".jpg'>";
    } else {
        echo "<img src='".IMGBASE."/i/im/",rand(110,112),".jpg'>";
    }
}

?>
</TD></TR>
</TABLE>

</TD></TR>
</TABLE>

</FORM>
</div>
<?
  if ($fbattle->return==1) echo "<script>
  upddefzones(".$fbattle->battleunits[$user["id"]]["blockzones"].");
  DrawDots(1);
  DrawDots(0);
  DrawButtons();
  </script>";
  if (!$user["battle"]) echo "<script>top.switchtochat();</script>";
  echo "<script>$finishscript</script>";
  ///if ($_SERVER["REMOTE_ADDR"]=="127.0.0.1") include "autocombats2.php";
?>
<!-- <DIV ID=oMenu CLASS=menu onmouseout="closeMenu()"></DIV> -->
<DIV ID="oMenu"  onmouseout="closeMenu()" style="position:absolute; border:1px solid #666; background-color:#CCC; display:none; "></DIV>
<? if ($user["battle"]) { ?><script>top.switchtolog(<? echo $fbattle->battle_data["id"]; ?>);</script><? } ?>
<iframe width="1" height="1" frameborder="0" style="width:1px;height:1px;border:0px" name="hitbox"></iframe>
<div id="opt"></div>
<?
  if (@$_GET["if"] || @$_POST["if"]) echo "<script>
  top.frames['main'].document.getElementById('screen').innerHTML=document.getElementById('screen').innerHTML;
  </script>";
  if ($user["battle"]) {
    echo "<div id=\"log\" ".($user["battle"]?"style=\"display:none\"":"").">$logoutput</div><script>
    top.frames['chat'].document.getElementById('logs').innerHTML=document.getElementById('log').innerHTML;
    </script>";
  }

  if (!$fbattle->ispvp() && $fbattle->return==1) {
    echo "<div style=\"display:none\">";
    $lasthit=0;
    foreach ($fbattle->battle[$user["id"]] as $k=>$v) {
      if ($v[2]>$lasthit) $lasthit=$v[2];
    }
    $timeleft=$fbattle->battle_data["timeout"]*60+$lasthit-time();
    if (@$_GET["if"]) echo "<script>top.frames['main'].cleartmo();</script>";
    if ($user["hp"]>0) echo showtime($timeleft,'makeemptyhit()');
    echo "</div>";
  }
?>
</BODY>
</HTML>
<?php
//Проверка не залез ли в закончившийся бой
if ($fbattle->battle_data["win"]!=3 && in_array($user["room"], $noattackrooms)) {
  mq("update users set battle=0 where id='$user[id]'");
}
if ($fbattle->needupdate) {
  $fbattle->update_battle();
  //if (!NOREFRESH) {
  //  echo "<script>document.location.replace('fbattleb.php');</script>";
  //}
}
$fbattle->write_log();
if ($fbattle->battle_data["needbb"]) {
  foreach ($fbattle->battle as $k=>$v) {
    if ($k>_BOTSEPARATOR_) {
      foreach ($v as $k2=>$v2) {
        if ($k2<_BOTSEPARATOR_) continue;
        if ($fbattle->battle[$k][$k2][0] && $fbattle->battle[$k2][$k][0] && $fbattle->userdata[$k]["hp"]>0 && $fbattle->userdata[$k2]["hp"]>0 && time()-$fbattle->battle[$k][$k2][2]>20 && time()-$fbattle->battle[$k2][$k][2]>20) {
          $fbattle->makechange($k, $k2);
          $fbattle->write_log();
          $fbattle->battle[$k][$k2]=array(0,0,time());
          $fbattle->battle[$k2][$k]=array(0,0,time());
          $fbattle->needupdate=1;
        }
      }
      $fbattle->checkbotstrokes($k);
    }
  }
  if ($fbattle->needupdate) $fbattle->update_battle();
  $fbattle->updatebattleunits();
}
//  $fbattle->userdata["10514253"]["hp"]=0;
//  $fbattle->update_battle();
    if($user['room']!=403 && $user['room']!=20 && $user['room']!=903 && $fbattle->battleunits[$fbattle->user['id']]["extra"]["ele"] && @$_POST["enemy"]){include "astral.php";}
    $fbattle->updateaddit();

    mq("UNLOCK TABLES;");
    foreach ($newbus as $k=>$v) {
      mq("insert into archive.battleunits (select * from battleunits where id='$v')");
    }
//  $fbattle->solve_mf($fbattle->enemy,5);
//  print_r($fbattle->userdata);
  if ($user["id"]==7) echo timepassed();
}
?>

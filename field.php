<?
  $fielddata["57"]=array("btype"=>3, "steponenemy"=>0);
  $fielddata["63"]=array("btype"=>3, "attackanyhp"=>1, "steponenemy"=>0);
  $fielddata["72"]=array("btype"=>11, "outon0hp"=>1, "attackanyhp"=>1, "steponenemy"=>1);
  $roomnames=array(3=>"Комната с Камином",4=>"Картинная Галерея 2",5=>"Картинная Галерея 3",6=>"Трапезная",7=>"Зал Отдыха 1",8=>"Зал Отдыха 2",9=>"Зал Статуй 3",10=>"Картинная Галерея 1",11=>"Зал Статуй 1",12=>"Зал Статуй 2",13=>"Выход на Крышу",14=>"Западная Крыша 1",15=>"Западная Крыша 2",16=>"Оранжерея",17=>"Храм",18=>"Келья 1",19=>"Келья 2",20=>"Келья 3",21=>"Келья 4",22=>"Красный зал-коридор",23=>"Красный Зал",24=>"Терасса",25=>"Винный Погреб",26=>"Лестница в Подвал ",27=>"Внутр. двор - Выход1",28=>"Внутренний Двор",29=>"Библиотека ",30=>"Внутр. двор - Выход2",31=>"Гостиная",32=>"Восточная Крыша",33=>"Выход из Мраморного Зала",34=>"Южный Внутр. двор",35=>"Восточная Комната",36=>"Мраморный Зал",39=>"Желтый Коридор",40=>"Подвал",41=>"Старый Зал 2",42=>"Служебная Комната",43=>"Комната в Подвале",44=>"Темная Комната",45=>"Старый Зал 1",46=>"Зал Ожидания",47=>"Зал Ораторов",37=>"Оружейная Комната",38=>"Бойница",);

  session_start();
  include "connect.php";
  include "functions.php";

  function logattack($field, $user, $target, $battle) {
    addfieldlog($field, fullnick($user)." напал".($user["sex"]==1?"":"а")." на ".fullnick($target).", начался <a target=\"_blank\" href=\"/logs.php?log=$battle\">поединок &gt;&gt;</a>.<br>");
  }

  if ($user["hp"]<=0 && @$fielddata[$user["room"]]["outon0hp"]) {
    addfieldlog($user["caveleader"], fullnick($user)." ".($user["sex"]==1?"повержен":"проиграла")."<br>");
    outoffield($user["id"]);
    header("location: vxod.php");
    die;
  }
  if ($user["battle"]) {
    header("location: fbattle.php");
    die;
  }
  if (!in_array($user['room'],$battlefields)) {
    header("location: main.php");
    die;
  }
  if ($user["room"]==302) {
    $base=IMGBASE."/underdesigns/alchcave"; 
  } elseif ($user["room"]==63) {
    $base=IMGBASE."/underdesigns/field"; 
  } elseif ($user["room"]==72) {
    $base=IMGBASE."/underdesigns/deathtower"; 
  } else {
    $base=IMGBASE."/underdesigns/crystalcave1"; 
  }
  if (isset($_GET["direction"])) {
    $dir=(int)$_GET["direction"];
    if ($dir>=0 && $dir<=3) mq("update fieldparties set dir='$dir' where user='$user[id]'");
  }

  $field=mqfa("select pts1, pts2, map, start from fields where id='$user[caveleader]'");
  if ($field["start"]+60>time()) {
    $_SESSION["movetime"]=$field["start"]+60;
    $report="Вы не можете передвигатся ещё ".($_SESSION["movetime"]-time())." сек.";
  }
  $map=unserialize($field["map"]);

  $imgdata[3][0]=array("wd"=>173, "ht"=>317, "y"=>1, "x"=>array(-37, 89, 215));

  $imgdata[3][1]=array("wd"=>87, "ht"=>161, "y"=>41, "x"=>array(68, 132, 196));
  $imgdata[1][1]=array("wd"=>87, "ht"=>161, "y"=>41, "x"=>array(-171, -44, -44));
  $imgdata[5][1]=array("wd"=>87, "ht"=>161, "y"=>41, "x"=>array(308, 308, 435));

  $imgdata[3][2]=array("wd"=>58, "ht"=>107, "y"=>55, "x"=>array(104, 147, 189));
  $imgdata[1][2]=array("wd"=>58, "ht"=>107, "y"=>55, "x"=>array(-56, 29, 29));
  $imgdata[5][2]=array("wd"=>58, "ht"=>107, "y"=>55, "x"=>array(264, 264, 350));

  $imgdata[3][3]=array("wd"=>44, "ht"=>81, "y"=>61, "x"=>array(122, 154, 186));
  $imgdata[1][3]=array("wd"=>44, "ht"=>81, "y"=>61, "x"=>array(1, 65, 65));
  $imgdata[5][3]=array("wd"=>44, "ht"=>81, "y"=>61, "x"=>array(242, 242, 306));

  function placeparty() {
    global $map, $party, $user, $field;
    $afs=array();
    foreach ($party as $k=>$v) {
      if ($v["user"]>=11111 && $v["user"]<12000 && !$v["battle"]) {
        if (canmoveto($map[$v["y"]*2+2][$v["x"]*2], 2, $map[$v["y"]*2+1][$v["x"]*2])) $afs[$v["x"]][$v["y"]+1]=$v["user"];
        if (canmoveto($map[$v["y"]*2-2][$v["x"]*2], 2, $map[$v["y"]*2-1][$v["x"]*2])) $afs[$v["x"]][$v["y"]-1]=$v["user"];

        if (canmoveto($map[$v["y"]*2][$v["x"]*2+2], 2, $map[$v["y"]*2][$v["x"]*2+1])) $afs[$v["x"]+1][$v["y"]]=$v["user"];
        if (canmoveto($map[$v["y"]*2][$v["x"]*2-2], 2, $map[$v["y"]*2][$v["x"]*2-1])) $afs[$v["x"]-1][$v["y"]]=$v["user"];
      }
      $map[$v["y"]*2][$v["x"]*2]="u/".$v["user"];
    }
    if ($field["start"]+180>time()) return ;
    foreach ($party as $k=>$v) {
      if($v["user"]>=11111 && $v["user"]<12000) continue;
      if ($afs[$v["x"]][$v["y"]]) {
        include_once("questfuncs.php");
        mq("lock tables users write, fieldparties write, bots write, battle write, effects write, fieldlogs write");
        $b=mqfa1("select battle from users where id='$v[user]'");
        $b2=mqfa1("select battle from fieldparties where user='".$afs[$v["x"]][$v["y"]]."'");
        if (!$b && !$b2) {
          $e=mqfa1("select id from effects where owner='$v[user]' and type=".PROTFROMATTACK);
          if (!$e) {
            $btl=battlewithbot($afs[$v["x"]][$v["y"]], "", "", 1, 0, 0, 0, 0, 0, array(), 1, $v["user"], 11);
            logattack($user["caveleader"], mqfa("select id, login, level, align, sex, klan from users where id='".$afs[$v["x"]][$v["y"]]."'"), $v["user"], $btl);
            mq("update fieldparties set battle='$btl' where user='".$afs[$v["x"]][$v["y"]]."'");
            header("location: field.php");
            die;
          }
        }
        mq("unlock tables");
      }
    }
  }

  function updmap() {
    global $map, $user, $floor;
    mq("update fields set map='".serialize($map)."' where id='$user[caveleader]'");
  }

  function drawuser($user, $x, $y) {
    global $imgdata, $udata;
    $bn=1;
    $ret.="<img title=\"".$udata[$user]["login"]."\" ".($y==1 && $x==3?"onclick=\"attackmenu(event);\"":"")." width=\"".$imgdata[$x][$y]["wd"]."\" height=\"".$imgdata[$x][$y]["ht"]."\" src=\"".IMGBASE."/i/shadow/".$udata[$user]["shadow"]."\" style=\"position:absolute;left:".$imgdata[$x][$y]["x"][$bn]."px;top:".$imgdata[$x][$y]["y"]."px;".($x==3 && $y==1?"cursor:pointer;":"").($x==3?"z-index:".(99-($y*5)).";":"")."\">";
    return $ret;
  }

  function drawobject($cell, $x, $y) {
    global $objects, $imgdata, $user;
    $tmp=explode("/", $cell);
    $obj=$tmp[2];
    $ht=round($imgdata[$x][$y]["ht"]/2);
    if ($user["room"]==72) {
      $ht=round($imgdata[$x][$y]["ht"]*0.43);
      $wd=round($imgdata[$x][$y]["wd"]*1.5);      
      $left=$imgdata[$x][$y]["x"][1]-round(($wd-$imgdata[$x][$y]["wd"])/2);
      $top=$imgdata[$x][$y]["y"]+($ht*1.2);
    } elseif ($obj>600 && $obj<700) {
      $wd=round($imgdata[$x][$y]["wd"]*1.26);
      $left=$imgdata[$x][$y]["x"][1]-round(($wd-$imgdata[$x][$y]["wd"])/2);
      $top=$imgdata[$x][$y]["y"]+$ht;
    } elseif ($obj>=700 && $obj<800) {
      $wd=round($imgdata[$x][$y]["wd"]*1.24);
      $ht=$imgdata[$x][$y]["ht"];
      $left=$imgdata[$x][$y]["x"][1]-round(($wd-$imgdata[$x][$y]["wd"])/2);
      $top=$imgdata[$x][$y]["y"];
    } elseif ($obj==4) {
      $wd=round($imgdata[$x][$y]["wd"]*1.4);
      $ht=$imgdata[$x][$y]["ht"]*0.7;
      $left=$imgdata[$x][$y]["x"][1]-round(($wd-$imgdata[$x][$y]["wd"])/2);
      $top=$imgdata[$x][$y]["y"]+(0.5*$ht);
    } elseif ($obj<=3) {
      $wd=round($imgdata[$x][$y]["wd"]*0.9);
      $ht=$imgdata[$x][$y]["ht"]*0.5;
      $left=$imgdata[$x][$y]["x"][1];
      $top=$imgdata[$x][$y]["y"]+$ht;
    } else {
      $wd=$imgdata[$x][$y]["wd"];
      $left=$imgdata[$x][$y]["x"][1];
      $top=$imgdata[$x][$y]["y"]+$ht;
    }
    $ret.="
    ".($y==1 && $x==3?"<a href=\"field.php?useitem=1&".time()."\">":"")." 
    <img border=\"0\" title=\"$objects[$obj]\" width=\"$wd\" height=\"$ht\" src=\"/i/dungeon/objects/$user[room]/$obj.gif?1\" style=\"position:absolute;left:{$left}px;top:{$top}px;".($x==3?"z-index:".(99-($y*5)).";":"")."\">
    ".($y==1 && $x==3?"</a>":"");
    return $ret;      
  }

  function canmoveto($cell, $freecell=0, $passing=0) {
    if (!passablewall($passing)) return false;
    $obj=substr($cell,0,1);
    if ($obj=="e" || $obj=="u" || $obj=="s") return true;
    if (!$freecell && $cell) return false;
    if ($cell==$freecell) return true;
    return false;
  }

  function passablewall($n) {
    if ($n==0) return true;
    return false;
  }
  if ($user["room"]==72) {
    $floor=1;
    $data=unserialize(implode("", file(CHATROOT."fielddata/$user[caveleader]-$floor.dat")));
    if (!$data) {
      $data=array("wander"=>time());
      $f1=fopen(CHATROOT."fielddata/$user[caveleader]-$floor.dat", "wb+");
      flock($f1, LOCK_EX);
      fwrite($f1, serialize($data));
      flock($f1, LOCK_UN);
      fclose($f1);      
    }
    if (time()-$data["wander"]>10 && $field["start"]+180<time()) {
      include "functions/movedtbots.php";
      movedtbots("$user[caveleader]-$floor");
    }
  }

  $party=array();
  $r=mq("select user, x, y, dir, team, login, shadow, battle from fieldparties where field='$user[caveleader]' order by id");
  if (mysql_num_rows($r)==0) {
    gotoroom($user["room"]-1);
  }

  $aliveusers=0;
  while ($rec=mysql_fetch_assoc($r)) {
    if ($rec["user"]==$user["id"]) {
      $x=$rec["x"];
      $y=$rec["y"];
      $dir=$rec["dir"];
      $team=$rec["team"];
      $tmp=explode("/", $map[$y*2][$x*2]);
      $room=$tmp[1];
      $standingon=$map[$y*2][$x*2];
    }
    //unset($rec["user"]);
    $party[]=$rec;
    if ($rec["user"]<11111 || $rec["user"]>=12000) $aliveusers++;
    $udata[$rec["user"]]=$rec;
  }
  if (@$_GET["useitem"]) {
    if ($dir==0) {
      $x1=$x-1;
      $y1=$y;
    }
    if ($dir==1) {
      $x1=$x;
      $y1=$y-1;
    }
    if ($dir==2) {
      $x1=$x+1;
      $y1=$y;
    }
    if ($dir==3) {
      $x1=$x;
      $y1=$y+1;
    }
    $tx=$x1;
    $ty=$y1;
    include_once "questfuncs.php";
    if ($user["room"]==57) {
      if ($map[$y1*2][$x1*2]=="o/1/1") {
        if (!hassmallitems('Зелёный кристалл')) {
          takesmallitem(50, $user["id"], "", 1, $user["in_tower"]);
          $report="Вы получили зелёный кристалл";
        } else $report="У вас уже есть зелёный кристалл.";
      }
      if ($map[$y1*2][$x1*2]=="o/1/2") {
        if (!hassmallitems('Красный кристалл')) {
          takesmallitem(51, $user["id"], "", 1, $user["in_tower"]);
          $report="Вы получили красный кристалл";
        } else $report="У вас уже есть красный кристалл.";
      }
      if ($map[$y1*2][$x1*2]=="o/1/3") {
        if (!hassmallitems('Жёлтый кристалл')) {
          takesmallitem(52, $user["id"], "", 1, $user["in_tower"]);
          $report="Вы получили желтый кристалл";
        } else $report="У вас уже есть жёлтый кристалл.";
      }
      if ($map[$y1*2][$x1*2]=="o/1/4") {
        if (hassmallitems('Зелёный кристалл') && hassmallitems('Красный кристалл') && hassmallitems('Жёлтый кристалл')) {
          $report="Вы возложили кристаллы на алтарь.";
          mq("delete from inventory where owner='$user[id]' and (name='Зелёный кристалл' or name='Красный кристалл' or name='Жёлтый кристалл')");
          mq("update fields set pts$team=pts$team+1 where id='$user[caveleader]'");
          $field["pts$team"]++;

          mq("update fieldlogs set log=concat(log, '".logdate()." ".fullnick($user["id"])." возложил".($user["sex"]==1?"":"а")." кристаллы на алтарь. Счёт $field[pts1]:$field[pts2].<br>') where id='$user[caveleader]'");

          if ($field["pts$team"]>=10) {
            $pts2=ceil($field["pts".($team==1?"2":"1")]/2);
            $report.="<br>Ваша команда победила!";
            $cond="";
            foreach ($party as $k=>$v) {
              moveuser($v["user"], $user["room"]-1);
              if ($v["team"]==$team) {
                $wins=mqfa1("select wins$user[room] from userdata where id='$v[user]'")+1;
                if ($wins==1) {
                  takesmallitem(54, $v["user"], "В пещере кристаллов", 1);
                  $prize="Знак кристаллов 1";
                }
                if ($wins==2) {
                  takesmallitem(54, $v["user"], "В пещере кристаллов", 2);
                  $prize="Знак кристаллов 1, 2 шт";
                }
                if ($wins==3) {
                  takesmallitem(55, $v["user"], "В пещере кристаллов", 1);
                  $prize="Знак кристаллов 2";
                }
                if ($wins==4) {
                  takesmallitem(55, $v["user"], "В пещере кристаллов", 2);
                  $prize="Знак кристаллов 2, 2 шт";
                }
                if ($wins==5) {
                  takesmallitem(56, $v["user"], "В пещере кристаллов", 1);
                  $prize="Знак кристаллов 3";
                }
                mq("update userdata set wins$user[room]=".($wins>=5?"0":"$wins")." where id='$v[user]'");
                privatemsg("Ваша команда победила в пещере кристаллов. Получено жетон кристаллов 10 шт., $prize.", $v["login"]);
                takesmallitem(53, $v["user"], "В пещере кристаллов", 10);
              } else {
                privatemsg("Ваша команда проиграла в пещере кристаллов. ".($pts2>0?"Получено жетон кристаллов $pts2 шт.":""), $v["login"]);
                mq("update userdata set wins$user[room]=0 where id='$v[user]'");
                takesmallitem(53, $v["user"], "В пещере кристаллов", $pts2);
              }
              if ($cond) $cond.=" or ";
              $cond.=" user='$v[user]' ";
              statsback($v["user"]);
            }
            $r=mq("select distinct battle from users where ".str_replace("user", "id", $cond)." and battle>0");
            while ($rec=mysql_fetch_assoc($r)) {
              drawbattle($rec["battle"]);
            }
            $team1="";
            $team2="";
            foreach ($party as $k=>$v) {
              if ($v["team"]==1) {
                if ($team1) $team1.=", ";
                $team1.=fullnick("$v[user]");
              } else {
                if ($team2) $team2.=", ";
                $team2.=fullnick("$v[user]");
              }
            }
            $log="<span class=date>".date("d.m.y H:i")."</span> Поединок окончен, победители: ".($team==1?$team1:$team2)."<BR>";
            mq("update fieldlogs set pts1='$field[pts1]', pts2='$field[pts2]', log=concat(log, '$log') where id='$user[caveleader]'");

            mq("delete from fieldparties where $cond");
            mq("delete from fields where id='$user[caveleader]'");
            mq("delete from inventory where (name='Зелёный кристалл' or name='Красный кристалл' or name='Жёлтый кристалл') and (".str_replace("user", "owner", $cond).")");
          }
        } else $report="У вас нет всех необходимых кристаллов.";
      }
    } else include "underground/objects/$user[room].php";
  }
  placeparty();

  if ($user["room"]==72 && $aliveusers==1 && $udata[$user["id"]]) {
    $win=getvar("fieldwin".($user["room"]-1));
    $nextBattle = 60*60+time();
    mq("update variables set value=".$nextBattle." where var='startbs2'");
    //sysmsg("Битва в Подгорной Башне смерти окончена, победитель - <b>" . $user["login"] . "</b>. Следующая битва в " . date('H:i', $nextBattle));
    privatemsg("Вы победили в турнире Башни смерти. Приз: $win кр.", $user["login"]);
    outoffield($user["id"]);
    mq("update fieldlogs set log=concat(log, '".logdate()." Турнир закончен. Победитель: ".fullnick($user).".<br>'), winner='$user[id]', passed=".time()."-started, prize='$win' where id='$user[caveleader]'");
    setvar("fieldwin".($user["room"]-1), 0);
    givemoney($user["id"], $win, "за победу в Подгорной Башне смерти.");
    mq("delete from fields where id='$user[caveleader]'");
    mq("delete from fieldparties where field='$user[caveleader]'");
    header("location: vxod.php");
    echo "<script>document.location.replace('vxod.php')</script>";
    die;
  }
  //$map[]
  if (@$_GET["move"] && $_SESSION["movetime"]<time()) {
    if ($user["hp"]>$user["maxhp"]*0.1 || @$fielddata[$user["room"]]["attackanyhp"]) {
      $bad=0;
      if ($user["room"]==57) {
        if ($_GET["move"]=="y1" && $team==1 && $y>=13) {
          $bad=1;
          $report="На базу противника вход запрещён.";
        }
        if ($_GET["move"]=="y2" && $team==2 && $y<=3) {
          $bad=1;
          $report="На базу противника вход запрещён.";
        }
      }
      if (!$bad) {
        $map[$y*2][$x*2]=$standingon;
        $map1=$map;
        foreach ($party as $k=>$v) {
          if (!$fielddata[$user["room"]]["steponenemy"]) $map[$v["y"]*2][$v["x"]*2]=0;
          else $map[$v["y"]*2][$v["x"]*2]="s/0";
        }
        if ($_GET["move"]=="x1" && canmoveto($map[$y*2][$x*2+2],2,$map[$y*2][$x*2+1])) {
          mq("update fieldparties set x=x+1 where user='$user[id]'");
          $x++;
        }
        if ($_GET["move"]=="x2" && canmoveto($map[$y*2][$x*2-2],2,$map[$y*2][$x*2-1])) {
          mq("update fieldparties set x=x-1 where user='$user[id]'");
          $x--;
        }
        if ($_GET["move"]=="y1" && canmoveto($map[$y*2+2][$x*2],2,$map[$y*2+1][$x*2])) {
          mq("update fieldparties set y=y+1 where user='$user[id]'");
          $y++;
        }
        if ($_GET["move"]=="y2" && canmoveto($map[$y*2-2][$x*2],2,$map[$y*2-1][$x*2])) {
          mq("update fieldparties set y=y-1 where user='$user[id]'");
          $y--;
        }
        $map=$map1;
        foreach ($party as $k=>$v) if ($v["user"]==$user["id"]) {
          $party[$k]["x"]=$x;
          $party[$k]["y"]=$y;
        }
        $udata[$user["id"]]["x"]=$x;
        $udata[$user["id"]]["y"]=$y;
        if ($user["id"]!=7 && $_SERVER["REMOTE_ADDR"]!="127.0.0.1") $_SESSION["movetime"]=time()+10;
        placeparty();
      }
    } else $report="Вы слишком ослаблены, чтобы передвигаться.";
  }

  if (!@$_SESSION["movetime"]) {
    $_SESSION["movetime"]=time()+10;
    $_SESSION["itemtime"]=time()+5;
  }
  if (@$_GET["takeitem"]) {
    if ($_SESSION["itemtime"]<=time()) {
      $_GET["takeitem"]=(int)$_GET["takeitem"];
      mq("lock tables fielditems write, inventory write");
      $it=mqfa("select item, name, massa from fielditems where field='$user[caveleader]' and x='".($x*2)."' and y='".($y*2)."' and id='$_GET[takeitem]'");
      if ($it) {
        $d=getweight($user);
        $gm=get_meshok();
        $bps=backpacksize();
        if ($d["weight"]+$it["massa"]>$gm) {
          $report="Превышена максимальная масса предметов в рюкзаке.";
        } elseif ($d["cnt"]>=$bps) {
          $report="Превышено максимальное количество предметов в рюкзаке.";      
        } else {
          mq("update inventory set owner='$user[id]' where id='$it[item]'");
          //mq("insert into pbsitemslog SET user = '$user[login]', item = '$it[item]', text = 'Поднял - $it[name]'");
          $report="Вы нашли $it[name].";
          mq("update fielditems set x=0, y=0 where id='$_GET[takeitem]'");
          $_SESSION["itemtime"]=time()+5;
        }
      } else $report="Кто-то оказался быстрее...";
      mq("unlock tables");
    } else $report="Вы можете поднять вещь не ранее чем через ".($_SESSION["itemtime"]-time())." сек.";
  }
  if (@$_GET["attack"] && !$user["battle"]) {
    if ($user["hp"]>$user["maxhp"]*0.1 || !@$fielddata[$user["room"]]["attackanyhp"]) {
      if ($dir==0) {$by=$y*2; $bx=($x-1)*2;}
      if ($dir==1) {$by=($y-1)*2; $bx=$x*2;}
      if ($dir==2) {$by=$y*2; $bx=($x+1)*2;}
      if ($dir==3) {$by=($y+1)*2; $bx=$x*2;}
      $tmp=explode("/", $map[$by][$bx]);
      $bot=$tmp[1];
      foreach ($party as $k=>$v) if ($v["user"]==$bot) {
        $bot=$v;
        break;
      }
      if ($bot["user"]<11111 || $bot["user"]>11999) {
        $hp=mqfa("select hp, maxhp, battle from users where id='$bot[user]'");
      } else {
        $hp=mqfa("select battle from fieldparties where user='$bot[user]'");
        $hp["hp"]=100;$hp["maxhp"]=100;
      }
      if (!$hp["battle"] && $hp["hp"]<$hp["maxhp"]*0.1 && !@$fielddata[$user["room"]]["attackanyhp"]) {
        $report="Жертва слишком слаба";
      } else {
        if ($bot["user"]<11111 || $bot["user"]>11999) {
          if ($bot["team"]!=$team || !$team) {
            $i=mqfa1("select time from effects where owner='$bot[user]' and type=".PROTFROMATTACK);
            if ($i>time()) {
              $report="На этого персонажа можно напасть не раньше чем через ".($i-time())." сек.";
            } else {
              include "functions/attack.php";
              $error="";
              $error=attack($bot["user"], $fielddata[$user["room"]]["btype"], 0, 1, 0, 0, 1, 0, 0, 0, "", 1);
              if ($error) $report=$error;
              else {
                if ($joinedbattle) {
                  addch("<img src=i/magic/attack.gif> <B>$user[login]</B> вмешал".($user["sex"]==1?"ся":"ась")." в поединок против &quot;<b>".mqfa1("select login from users where id='$bot[user]'")."</b>&quot;");
                  addfieldlog($user["caveleader"], fullnick($user)." вмешал".($user["sex"]==1?"ся":"ась")." в <a target=\"_blank\" href=\"/logs.php?log=$joinedbattle\">поединок &gt;&gt;</a> против ".fullnick($bot["user"]).".<br>");
                } else {
                  addch("<img src=i/magic/attack.gif> <B>$user[login]</B> напал".($user["sex"]==1?"":"а")." на &quot;<b>".mqfa1("select login from users where id='$bot[user]'")."</b>&quot;");
                  logattack($user["caveleader"], $user, $bot["user"], $startedbattle);
                }
                //addch ("<B><b>$user[login]</b> напал на <b>".mqfa1("select login from users where id='$bot[user]'")."</b>.",$user['room']);
                header("location: fbattle.php");
                die;
              }
            }
          }
        } else {
          include_once("questfuncs.php");
          if ($hp["battle"]) {
            battlewithbot($bot["user"], "", "", 1, 0, 0, 0, 0, $hp["battle"]);
          } else {
            $btl=battlewithbot($bot["user"], "", "", 1, 0, 0, 0, 0, 0);
            mq("update fieldparties set battle='$btl' where user='$bot[user]'");
          }
        }
      }
    } else $report="Вы слишком ослаблены, чтобы нападать.";
  }

  //$base=".";
  if (@$_GET["exit"]) {
    //mq("delete from cavebots where leader='$user[id]'");
    //mq("delete from caves where leader='$user[id]'");
    //mq("delete from fieldparties where leader='$user[id]'");
    //mq("delete from caveitems where leader='$user[id]'");
    //gotoroom($user["room"]-1);
  }
?>
<head>
<link rel=stylesheet type="text/css" href="/i/main.css">
<style>
BODY {
  FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;
  font-size: 10px;
  margin: 0px 0px 0px 0px;

  scrollbar-face-color: #e3ac67;
  scrollbar-highlight-color: #e0c3a0;
  scrollbar-shadow-color: #b78d58;
  scrollbar-3dlight-color: #b78d58;
  scrollbar-arrow-color: #b78d58;
  scrollbar-track-color: #e0c3a0;
  scrollbar-darkshadow-color: #b78d58;
}
.menu {
  z-index: 100;
  background-color: #E4F2DF;
  border-style: solid; border-width: 2px; border-color: #77c3fc
  position: absolute;
  left: 0px;
  top: 0px;
  visibility: hidden;
  cursor:pointer;
}
a.menuItem {
border: 0px solid #000000;
background-color: #484848;
color: #000000;
display: block;
font-family: Verdana, Arial;
font-size: 8pt;
font-weight: bold;
padding: 2px 12px 2px 8px;
text-decoration: none;
}

a.menuItem:hover {
background-color: #d4cbaa;
color: #000000;
}

DIV.MoveLine{ width: 108px;height: 7px; size: 2px;font-size:2px; position: relative;overflow:hidden;}
IMG.MoveLine{ width:108px;height: 7px;border:0px solid;position:absolute;left:0px;top:0px }

.cw1 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/cw1.gif)}
.cw2 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/cw2.gif)}
.cw3 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/cw3.gif)}
.cw4 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/cw4.gif)}
.cw5 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/cw5.gif)}

.lw0 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/lw0.gif)}
.lw1 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/lw1.gif)}
.lw2 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/lw2.gif)}
.lw3 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/lw3.gif)}
.lw4 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/lw4.gif)}

.rw0 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/rw0.gif)}
.rw1 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/rw1.gif)}
.rw2 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/rw2.gif)}
.rw3 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/rw3.gif)}
.rw4 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/rw4.gif)}

.lsw0 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/lsw0.gif)}
.lsw1 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/lsw1.gif)}
.lsw2 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/lsw2.gif)}
.lsw3 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/lsw3.gif)}
.lsw4 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/lsw4.gif)}
.lsw42 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/lsw42.gif)}

.rsw0 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/rsw0.gif)}
.rsw1 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/rsw1.gif)}
.rsw2 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/rsw2.gif)}
.rsw3 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/rsw3.gif)}
.rsw4 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/rsw4.gif)}
.rsw42 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/rsw42.gif)}

.lw42 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/lw42.gif)}
.rw42 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/rw42.gif)}

.maptd {width:15px;height:15px}

</style>
<script>
var Hint3Name = '';
// Заголовок, название скрипта, имя поля с логином
function findlogin(title, script, name){
  document.all("hint3").innerHTML = '<form action="'+script+'" method=post><table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
  '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><INPUT TYPE=hidden name=sd4 value="6"><td colspan=2>'+
  'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD width=50% align=right><INPUT TYPE=text NAME="'+name+'"></TD><TD width=50%><INPUT TYPE="submit" value=" »» "></TD></TR></TABLE></td></tr></table></form>';
  document.getElementById("hint3").style.visibility = "visible";
  document.getElementById("hint3").style.left = 100;
  document.getElementById("hint3").style.top = 100;
  Hint3Name = name;
  document.all(name).focus();
}

function closehint3(){
  document.getElementById("hint3").style.visibility="hidden";
  Hint3Name='';
}

function attackmenu(e){
  var el, x, y;
  el = document.getElementById("oMenu");
  var posx = 0;
  var posy = 0;
  if (!e) var e = window.event;
  if (e.pageX || e.pageY) {
    posx = e.pageX;
    posy = e.pageY;
  } else if (e.clientX || e.clientY) {
    posx = e.clientX + document.body.scrollLeft;
    posy = e.clientY + document.body.scrollTop;
  }
  el.innerHTML = '<div style="color:#000;font-size:14px;padding:5px 10px 5px 10px" class=menuItem onmouseout="this.className=\'menuItem\';" onmouseover="this.className=\'menuItem2\';" onclick="this.disabled = true;document.location.href=\'field.php?attack=1&<?=time()?>\';closeMenu(event);"> <b>Напасть</b> </div>';
  el.style.left = posx + "px";
  el.style.top  = posy + "px";
  el.style.visibility = "visible";
}
</script>
</head>
<body style="margin:0px" bgcolor="#d7d7d7" <? if ($user["room"]!=63) echo "onLoad=\"".topsethp()."\""; ?>>
<div id="hint3" style="FONT-SIZE: 8px; COLOR: #000080; FONT-FAMILY: MS Sans Serif; TEXT-DECORATION: none; VISIBILITY: hidden; WIDTH: 240px; POSITION: absolute; BACKGROUND-COLOR: #fff6dd; layer-background-color: #FFF6DD"></div>
<div style="z-index: 100;  background-color: #E4F2DF;  border-style: solid; border-width: 2px; border-color: #77c3fc; position: absolute;  left: 0px;  top: 0px;  visibility: hidden;  cursor:pointer;" id="oMenu"></div>
<?
  function drawmap($map1, $players, $x, $y, $direction, $team, $udata) {
    global $base, $user, $botnames;
    //$x=$players[0]["x"];
    //$y=$players[0]["y"];
    $startx=max($x*2-8,0);
    $starty=max($y*2-8,0);
    //$direction=$players[0]["dir"];
    if ($direction==0) {
      $x1=$x*2+2;
      $x2=$x*2-8;
      $y1=$y*2+3;
      $y2=$y*2-4;
    }
    if ($direction==2) {
      $x1=$x*2-2;
      $x2=$x*2+8;
      $y1=$y*2-3;
      $y2=$y*2+4;
    }
    if ($direction==1) {
      $x1=$x*2-3;
      $x2=$x*2+4;
      $y1=$y*2+2;
      $y2=$y*2-8;
    }
    if ($direction==3) {
      $x1=$x*2+3;
      $x2=$x*2-4;
      $y1=$y*2-2;
      $y2=$y*2+8;
    }
    if ($x1<$x2) $dx=1; else $dx=-1;
    if ($y1<$y2) $dy=1; else $dy=-1;
    $x0=0;
    $y0=0;
    if ($direction%2==1) {
      $sy1=$y1;
      while ($x1!=$x2) {
        $y1=$sy1;
        $y0=-2;
        while ($y1!=$y2) {
          $sq=$map1[$y1][$x1];
          $map[$x0][$y0]=$sq;
          $y1+=$dy;
          $y0++;
        }
        $x0++;
        $x1+=$dx;
      }
    } else {
      $sx1=$x1;
      while ($y1!=$y2) {
        $x1=$sx1;
        $x0=-2;
        while ($x1!=$x2) {
          $sq=$map1[$y1][$x1];
          $map[$y0][$x0]=$sq;
          $x1+=$dx;
          $x0++;
        }
        $y0++;
        $y1+=$dy;
      }
    }
    $ret="<div style=\"width:530px;height:260px;background-image:url($base/podzem.jpg);background-repeat:no-repeat;overflow:hidden\">
    <table cellspacing=0 cellpadding=0><tr><td style=\"padding-left:10px;padding-top:10px\">
      <div style=\"position:relative;width:354px;height:239px;overflow:hidden;\">";

    $i=7;
    $centerwall=8;
    while ($i>0) {
      if ($map[3][$i]) $centerwall=$i;
      $i-=2;
    }
    $i=4;

    while ($i>=0) {
      if ($i==4) {
        if ($map[0][7]) $ret.="<div class=\"lw{$i}2\"></div>";
        if ($map[0][6]) $ret.="<div class=\"lsw{$i}2\"></div>";        
        if ($map[-1][6]) $ret.="<img width=\"37\" height=\"78\" src=\"/i/shadow/".$udata[$map[-1][6]]["shadow"]."\" style=\"position:absolute;left:-20px;top:60px\">";
      }
      $wall=$i*2-1;
      $sidewall=$i*2;
      if ($map[1][$sidewall] && $i>0) {
        $obj=explode("/",$map[1][$sidewall]);
        //$obj=$map[1][$sidewall][0];
        if ($obj[0]=="u") {
          $ret.=drawuser($obj[1], 1, $i);
          //if ($i==1) $ret.="<img width=\"86\" height=\"157\" src=\"/i/shadow/".$udata[$map[1][$sidewall]]["shadow"]."\" style=\"position:absolute;left:-5px;top:40px\">";
          //if ($i==2) $ret.="<img width=\"61\" height=\"112\" src=\"/i/shadow/".$udata[$map[1][$sidewall]]["shadow"]."\" style=\"position:absolute;left:35px;top:55px\">";
          //if ($i==3) $ret.="<img width=\"44\" height=\"94\" src=\"/i/shadow/".$udata[$map[1][$sidewall]]["shadow"]."\" style=\"position:absolute;left:40px;top:50px\">";
        } elseif ($obj[0]=="o") {
          $ret.=drawobject($map[1][$sidewall],  1, $i);          
          /*$o=substr($map[1][$sidewall],1);
          if ($o==4) {
            if ($i==1) $ret.="<img width=\"106\" height=\"101\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:-42px;top:90px\">";
            if ($i==2) $ret.="<img width=\"86\" height=\"84\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:137px;top:90px\">";
            if ($i==3) $ret.="<img width=\"65\" height=\"63\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:152px;top:87px\">";
          } else {
            if ($i==1) $ret.="<img width=\"65\" height=\"80\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:0px;top:110px\">";
            if ($i==2) $ret.="<img width=\"43\" height=\"56\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:17px;top:90px\">";
            if ($i==3) $ret.="<img width=\"32\" height=\"40\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:17px;top:100px\">";
          }*/
        }
      }
      if ($map[5][$sidewall] && $i>0) {
        $obj=explode("/",$map[5][$sidewall]);
        //$obj=$map[5][$sidewall][0];
        if ($obj[0]=="u") {
          $ret.=drawuser($obj[1], 5, $i);
          //$bot=$udata[$map[5][$sidewall]];
          //if ($i==1) $ret.="<img title=\"$bot[login]\" width=\"86\" height=\"157\" src=\"/i/shadow/$bot[shadow]\" style=\"position:absolute;left:260px;top:40px\">";
          //if ($i==2) $ret.="<img title=\"$bot[login]\" width=\"61\" height=\"112\" src=\"/i/shadow/$bot[shadow]\" style=\"position:absolute;left:270px;top:55px\">";
          //if ($i==3) $ret.="<img title=\"$bot[login]\" width=\"44\" height=\"94\" src=\"/i/shadow/$bot[shadow]\" style=\"position:absolute;left:260px;top:50px\">";
        } elseif ($obj[0]=="o") {
          $ret.=drawobject($map[5][$sidewall],  5, $i);          
          /*$o=substr($map[5][$sidewall],1);
          if ($o==4) {
            if ($i==1) $ret.="<img width=\"106\" height=\"101\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:302px;top:90px\">";
            if ($i==2) $ret.="<img width=\"86\" height=\"84\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:137px;top:90px\">";
            if ($i==3) $ret.="<img width=\"65\" height=\"63\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:152px;top:87px\">";
          } else {
            if ($i==1) $ret.="<img width=\"65\" height=\"80\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:320px;top:90px\">";
            if ($i==2) $ret.="<img width=\"43\" height=\"56\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:300px;top:100px\">";
            if ($i==3) $ret.="<img width=\"32\" height=\"40\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:317px;top:110px\">";
          }*/
        }
      }
      if ($map[1][$wall] && $i>0) $ret.="<div class=\"lw$i\"></div>";
      if($map[2][$sidewall]) $ret.="<div class=\"lsw$i\"></div>";
      if($map[4][$sidewall]) $ret.="<div class=\"rsw$i\"></div>";
      if ($map[5][$wall] && $i>0) $ret.="<div class=\"rw$i\"></div>";
      if ($map[3][$sidewall] && $i>0 && $sidewall<$centerwall) {
        $obj=explode("/",$map[3][$sidewall]);
        if ($obj[0]=="u") {
          //$bot=$udata[$map[3][$sidewall]]["shadow"];
          //$team1=$udata[$map[3][$sidewall]]["team"];
          $ret.=drawuser($obj[1], 3, $i);
          //if ($i==1) $ret.="<img title=\"".$udata[$map[3][$sidewall]]["login"]."\" ".($team1!=$team?"onclick=\"attackmenu(event);\"":"")." width=\"120\" height=\"220\" src=\"/i/shadow/$bot\" style=\"position:absolute;left:127px;top:0px;cursor:pointer;z-index:99\">";
          //if ($i==2) $ret.="<img title=\"".$udata[$map[3][$sidewall]]["login"]."\" width=\"80\" height=\"145\" src=\"/i/shadow/$bot\" style=\"position:absolute;left:147px;top:35px;z-index:95\">";
          //if ($i==3) $ret.="<img title=\"".$udata[$map[3][$sidewall]]["login"]."\" width=\"60\" height=\"110\" src=\"/i/shadow/$bot\" style=\"position:absolute;left:157px;top:40px;z-index:90\">";
        } elseif($obj[0]=="o") {
          $ret.=drawobject($map[3][$sidewall],  3, $i);          
          /*$o=substr($map[3][$sidewall],1);
          if ($o==4) {
            if ($i==1) $ret.="<a style=\"position:absolute;left:112px;top:80px;z-index:100\" href=\"field.php?useitem=1\"><img border=\"0\" width=\"130\" height=\"126\" src=\"/i/dungeon/objects/$o.gif\"></a>";
            if ($i==2) $ret.="<img width=\"86\" height=\"84\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:137px;top:90px;z-index:95\">";
            if ($i==3) $ret.="<img width=\"65\" height=\"63\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:147px;top:87px;z-index:90\">";
          } else {
            if ($i==1) $ret.="<a style=\"position:absolute;left:157px;top:110px;z-index:100\" href=\"field.php?useitem=1\"><img border=\"0\" width=\"65\" height=\"80\" src=\"/i/dungeon/objects/$o.gif\"></a>";
            if ($i==2) $ret.="<img width=\"43\" height=\"56\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:157px;top:105px;z-index:95\">";
            if ($i==3) $ret.="<img width=\"32\" height=\"40\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:157px;top:100px;z-index:90\">";
          }*/
        }
      }
      if ($map[3][$wall]) {
        $ret.="<div class=\"cw$i\"></div>";
        //$nocenter=1;
      }
      if ($i==4) {
        //if ($map[6][7]) $ret.="<div class=\"rw{$i}2\"></div>";
        if ($map[7][6]) $ret.="<img width=\"37\" height=\"78\" src=\"/i/shadow/".$map[7][6].".gif\" style=\"position:absolute;left:330px;top:60px\">";
      }
      $i--;
    }
    
    $ret.="</div>
    </td><td valign=\"top\">
    <div style=\"height:116px;position:relative;\">
    <div style=\"padding-top:11px;padding-left:33px\">
    <DIV class=\"MoveLine\"><IMG src=\"http://www.lostcombats.com/i/move/wait3.gif\" id=\"MoveLine\" class=\"MoveLine\"></DIV>
    <div style=\"visibility:hidden; height:0px\" id=\"moveto\">0</div>
    </div>";
    if ($direction==0) {
      $forwardlink="?move=x2&".time();
      $backlink="?move=x1&".time();
      $leftlink="?move=y1&".time();
      $rightlink="?move=y2&".time();
    }
    if ($direction==2) {
      $forwardlink="?move=x1&".time();
      $backlink="?move=x2&".time();
      $leftlink="?move=y2&".time();
      $rightlink="?move=y1&".time();
    }
    if ($direction==1) {
      $forwardlink="?move=y2&".time();
      $backlink="?move=y1&".time();
      $leftlink="?move=x2&".time();
      $rightlink="?move=x1&".time();
    }
    if ($direction==3) {
      $forwardlink="?move=y1&".time();
      $backlink="?move=y2&".time();
      $leftlink="?move=x1&".time();
      $rightlink="?move=x2&".time();
    }

    if (canmoveto($map[3][2], 0, $map[3][1])) $ret.="<div style='position:absolute; left:65px; top:38px;'><a onClick=\"return check('m1');\" id=\"m1\" href=\"$forwardlink\"><img src=\"/i/dungeon/forward.gif\"  border=\"0\" /></a></div>";
    if (canmoveto($map[3][-2], 0, $map[3][-1])) $ret.="<div style='position:absolute; left:65px; top:84px;'><a onClick=\"return check('m5');\" id=\"m5\" href=\"$backlink\"><img src=\"/i/dungeon/back.gif\" border=\"0\" /></a></div>";
    if (canmoveto($map[1][0], 0, $map[2][0])) $ret.="<div style='position:absolute; left:17px; top:49px;'><a onClick=\"return check('m7');\" id=\"m7\" href=\"$leftlink\"><img src=\"/i/dungeon/left.gif\" border=\"0\" /></a></div>";
    if (canmoveto($map[5][0], 0, $map[4][0])) $ret.="<div style='position:absolute; left:127px; top:48px;'><a onClick=\"return check('m3');\" id=\"m3\" href=\"$rightlink\"><img src=\"/i/dungeon/right.gif\" border=\"0\" /></a></div>";

    $ret.="<div style='position:absolute; left:37px; top:37px;'><a href=\"?direction=".($direction==0?3:$direction-1)."&".time()."\" title=\"Поворот налево\"><img src=\"/i/dungeon/turnleft.gif\" width=\"22\" height=\"20\" border=\"0\" /></a></div>";

    $ret.="<div style='position:absolute; left:112px; top:37px;'><a href=\"?direction=".(($direction+1)%4)."&".time()."\" title=\"Поворот направо\"><img src=\"/i/dungeon/turnright.gif\" width=\"21\" height=\"20\" border=\"0\" /></a></div>";

    $ret.="<div style='position:absolute; left:66px; top:62px;'><a href=\"$_SERVER[PHP_SELF]?".time()."\"><img src=\"/i/dungeon/ref.gif\" border=\"0\"/></a></div>";    
    $ret.="</div>
    <div style=\"margin-left:20px;position:relative\">";
    foreach ($players as $k=>$v) {
      if ($user["room"]==72 && $user["id"]!=$v["user"]) continue;
      if ($v["x"]-($startx/2)>=0 && $v["x"]-($startx/2)<=8 && $v["y"]-($starty/2)>=0 && $v["y"]-($starty/2)<=8 && $v["team"]==$team) {
        if ($user["room"]==63) $arrow=1;
        elseif ($team==0) {
          if ($v["user"]==$user["id"]) $arrow=1; else $arrow=2;
        } else $arrow=$k+1;
        $ret.="<img title=\"$v[login]\" style=\"position:absolute;left:".(($v["x"]-($startx/2))*15+3)."px;top:".(($v["y"]-($starty/2))*15+3)."px\" src=\"/i/dungeon/$arrow$v[dir].gif\">";
      }
    }
    $ret.="<table cellspacing=0 cellpadding=0>";
    $i=$starty;
    while ($i<$starty+18) {
      $ret.="<tr>";
      $i2=$startx;
      while ($i2<$startx+18) {
        $ret.="<td class=\"maptd\">";
        if ($map1[$i][$i2]) {
          $ret.="<img src=\"/i/dungeon/";
          if ($map1[$i][$i2-1]) $ret.="0"; else $ret.="1";
          if ($map1[$i-1][$i2]) $ret.="0"; else $ret.="1";
          if ($map1[$i][$i2+1]) $ret.="0"; else $ret.="1";
          if ($map1[$i+1][$i2]) $ret.="0"; else $ret.="1";
          $ret.=".gif\">";
        }
        $ret.="</td>";
        $i2+=2;
      }
      $ret.="</tr>";
      $i+=2;
    }
    $ret.="</table></div>
    </td></tr></table>";

    //$ret.="<font style='font-size:14px; color:#8f0000'><b>".$mir['name']."</b></font>&nbsp;&nbsp;&nbsp;&nbsp;<a style=\"cursor:hand;\" onclick=\"if (confirm('Вы уверены что хотите выйти?')) window.location='canalizaciya.php?act=cexit'\">&nbsp;<b style='font-size:14px; color:#000066;'>Выйти</b></a>";
    //$ret.='<div style="position:relative;  id="ione"><div align="right"><img src="'.IMGBASE.'/labirint3/'.$gefd['style'].'/podzem.jpg" width=530 height=260 border=1 galleryimg="no" /></div>';
    //$ret.="<div style='position:absolute; left:374px; top:123px;'><img src='".IMGBASE."/labirint3/".$gefd['style']."/yo.gif' border='0' width='150' height='130'></div>";
    
    $ret.="<div align=\"center\" style=\"position:absolute; left:389px; top:10px; font-size:6px;padding:0px;border:solid black 0px; text-align:center\" id=\"prcont\">
    <script language=\"javascript\" type=\"text/javascript\">
    var s=\"\";for (i=1; i<=32; i++) {s+='<span id=\"progress'+i+'\">&nbsp;</span>';if (i<32) {s+='&nbsp;'};}document.getElementById('prcont').innerHTML=s;
    </script></div>";
    /*foreach ($map as $k=>$v) {
      echo $k;print_r($v);
      echo "<br>";
    }*/

    $ret.="<TABLE><tr>
    <td nowrap=\"nowrap\" id=\"moveto\">
    </td></tr></TABLE>";
    $ret.="</div>";
    $ret.="<script language=\"javascript\" type=\"text/javascript\">
var progressEnd = 108;		// set to number of progress <span>'s.
var progressColor = '#00CC00';	// set to progress bar color
var mtime = parseInt('";
if (time()<$_SESSION["movetime"]) $ret.=$_SESSION["movetime"]-time();
else $ret.=0;
$ret.="');
if (!mtime || mtime <= 0 ) mtime = 0;
var progressInterval = Math.round( mtime * 1000 / progressEnd );
var is_accessible = true;
var progressAt = progressEnd;
var progressTimer;
function progress_clear() {
progressAt = 1;

for (var t = 1; t <= 8; t++) {
if( document.getElementById('m'+t) && ( t != 2 && t != 8 ))
document.getElementById('m'+t).style.backgroundImage = \"none\";
}
is_accessible = false;
set_moveto(true);
}
function progress_update() {
progressAt++;
if (progressAt > progressEnd) {
for (var t = 1; t <= 8; t++) {
if( document.getElementById('m'+t) && ( t != 2 && t != 8 ))
document.getElementById('m'+t).style.backgroundImage = \"\";
}
is_accessible = true;
if (window.solo_store && solo_store) { solo(solo_store, \"\"); } // go to stored
set_moveto(false);
} else {
if( !( progressAt % 2 ) )
document.getElementById('MoveLine').style.left = progressAt - progressEnd;
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
if (mtime>0) {
progress_clear();
progress_update();
}
</script>
";
    return $ret;
  }
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" align="left">
<center>
<b><font color=red><?=@$report?>&nbsp;</font></b>
</center><br>
<center><table width="370" border="0" cellspacing="1" cellpadding="0" bgcolor="#000000">
<?
  foreach ($party as $k=>$v) {
    if ($v["team"]!=$team || (!$team && $v["user"]!=$user["id"])) continue;
    if ($v["user"]==$user["id"]) {
      $usr=$user;
    } else {
      $usr=mqfa("select level, hp, maxhp from users where id='$v[user]'");
    }
    $wd=floor($usr["hp"]/$usr["maxhp"]*120);
    echo "<tr>
<td background=\"/img/bg_scroll_05.gif\" align=\"center\">
<a href=\"inf.php?$v[user]\" target=_blank title=\"Информация о $v[login]\">$v[login]</a> [$usr[level]]<a href='inf.php?$v[user]' target='_blank'><img src='/i/inf.gif' border=0></a>
</td>
<td background=\"/img/bg_scroll_05.gif\" nowrap style=\"font-size:9px;padding-bottom:3px\">
<div style=\"position: relative\">
  <table cellspacing=\"0\" cellpadding=\"0\" style='line-height: 1;padding-top:3px;padding-left:3px'>
  <tr>
    <td nowrap style=\"font-size:11px\">
    <div style=\"position: relative\"><span ".($v["user"]==$user["id"] && $user["in_tower"]!=62?"id=\"HP\"":"")." style='position: absolute; left: 5px; z-index: 1; font-weight: bold; color: #FFFFFF'>$usr[hp]/$usr[maxhp]</SPAN><img src=\"/i/1green.gif\" alt=\"Уровень жизни\" ".($v["user"]==$user["id"]?"name=\"HP1\"":"")." width=\"$wd\" height=\"11\" ".($v["user"]==$user["id"]?"id=\"HP1\"":"")."><img src=\"/i/misc/bk_life_loose.gif\" alt=\"Уровень жизни\" ".($v["user"]==$user["id"]?"name=\"HP2\"":"")." width=\"".(120-$wd)."\" height=\"11\" ".($v["user"]==$user["id"] && $user["in_tower"]!=62?"id=\"HP2\"":"").">
    </div>
    </td>
  </table>
</div>
</td>
<td background=\"/img/bg_scroll_05.gif\" align=\"center\"></td>
<td background=\"/img/bg_scroll_05.gif\" align=\"center\">";
if ($v["user"]==$user["id"] && $user["id"]==$user["caveleader"]) echo "<IMG alt=\"Лидер группы\" src=\"/i/misc/lead1.gif\" width=24 height=15><A href=\"#\" onClick=\"findlogin( 'Выберите персонажа которого хотите выгнать','field.php', 'kill')\"><IMG alt=\"Выгнать супостата\" src=\"/img/podzem/ico_kill_member1.gif\" WIDTH=\"14\" HEIGHT=\"17\"></A>&nbsp;<A href=\"#\" onClick=\"findlogin( 'Выберите персонажа которому хотите передать лидерство','field.php', 'change')\"><IMG alt=\"Новый царь\" src=\"/img/podzem/ico_change_leader1.gif\" WIDTH=\"14\" HEIGHT=\"17\"></A>";
echo "</td>
</tr>";
  }
?>
</table><br><br>
<? if ($user["room"]!=63 && $team) { ?>
<table>
<tr><td align="center"><b>Ваша команда</b><br>
<span style="font-size:30px;color:#00aa00"><?=$field["pts$team"]?></span>
</td><td width=30>&nbsp;</td><td align="center"><b>Противник</b><br>
<span style="font-size:30px;color:#aa0000"><?=$field["pts".($team==1?"2":"1")]?></span>
</td></tr>
</table>
<? } else {
  if ($user["id"]==2030 || $user["id"]==6513 || $user["id"]==4264 || $user["id"]==4486 || $user["id"]==7) {
    //echo "<center><a href=\"#\" onclick=\"findlogin('Исключить из боя','field.php','main')\">Исключить из боя</center>";
  }
}?>
</center>
<br><br />
<center>
<?
  $timeleft=$_SESSION["itemtime"]-time();
  if ($timeleft>0) {
    echo "
    <div id=\"waitmsg\" style=\"color:#ff0000;font-weight:bold\"></div>
    <script>
    function dectl() {
      timeleft--;
    }
    function checktimeleft() {
      if (timeleft>0) {
        document.getElementById('waitmsg').innerHTML='Вы можете поднять вещь не ранее чем через '+timeleft+' сек.';
        return false;
      }
      return true;
    }
    var timeleft=$timeleft;";
    while ($timeleft>0) {
      echo "setTimeout('dectl()', ".($timeleft*1000).");";
      $timeleft--;
    }
    echo "</script>";
  } else {
    echo "<script>
    function checktimeleft() {
      return true;
    }
    </script>";
  }
  echo "</center>";
  echo "<div style=\"padding-left:20px\">";
  $r=mq("select * from fielditems where field='$user[caveleader]' and x='".($x*2)."' and y='".($y*2)."'");
  if (mysql_num_rows($r)>0) echo "<h3 style=\"text-align:left\">В комнате разбросаны вещи:</h3><div style=\"font-size:3px\">&nbsp;</div>";
  while ($rec=mysql_fetch_assoc($r)) {
    echo "<a onclick=\"return checktimeleft();\" title=\"Поднять $rec[name]\" href=\"field.php?takeitem=$rec[id]\"><img src=\"".IMGBASE."/i/sh/$rec[img]\"></a> ";
  }
  echo "</div>";
  /*$r=mq("select * from caveitems where leader='$user[caveleader]' and x='".($x*2)."' and y='".($y*2)."'");
  if (mysql_num_rows($r)>0) echo "<font color=red>В комнате разбросаны вещи:</font><div style=\"font-size:3px\">&nbsp;</div>";
  while ($rec=mysql_fetch_assoc($r)) {
    echo "<a title=\"Поднять $rec[name]\" href=\"field.php?takeitem=$rec[id]\"><img src=\"".IMGBASE."/i/sh/$rec[img]\"></a> ";
  }*/
?>
    </td>
    <td width=540 valign="top">
<div style="text-align:right;padding-right:30px">
<font style='font-size:14px; color:#8f0000'><b><?
  if (@$roomnames[$room]) echo $roomnames[$room];
  else echo $rooms[$user["room"]];
  //echo mqfa1("select room from vdata.caverooms where id='$position'");
  //echo $rooms[$user["room"]];
?></b></font>&nbsp;&nbsp;&nbsp;&nbsp;
<!--<font style='font-size:14px; color:#8f0000'><b></b></font>&nbsp;&nbsp;&nbsp;&nbsp;<a style="cursor:hand;" onclick="if (confirm('Вы уверены что хотите выйти?')) window.location='field.php?exit=1'">&nbsp;<b style='font-size:14px; color:#000066;'>Выйти</b></a>-->
</div>
<?
  echo drawmap($map, $party, $x, $y, $dir, $team, $udata);
?>
</td></tr></table>
<? if ($user["id"]==7)  echo "$x:$y";

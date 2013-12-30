<?
  $roomnames=array(3=>"Комната с Камином",4=>"Картинная Галерея 2",5=>"Картинная Галерея 3",6=>"Трапезная",7=>"Зал Отдыха 1",8=>"Зал Отдыха 2",9=>"Зал Статуй 3",10=>"Картинная Галерея 1",11=>"Зал Статуй 1",12=>"Зал Статуй 2",13=>"Выход на Крышу",14=>"Западная Крыша 1",15=>"Западная Крыша 2",16=>"Оранжерея",17=>"Храм",18=>"Келья 1",19=>"Келья 2",20=>"Келья 3",21=>"Келья 4",22=>"Красный зал-коридор",23=>"Красный Зал",24=>"Терасса",25=>"Винный Погреб",26=>"Лестница в Подвал ",27=>"Внутр. двор - Выход1",28=>"Внутренний Двор",29=>"Библиотека ",30=>"Внутр. двор - Выход2",31=>"Гостиная",32=>"Восточная Крыша",33=>"Выход из Мраморного Зала",34=>"Южный Внутр. двор",35=>"Восточная Комната",36=>"Мраморный Зал",39=>"Желтый Коридор",40=>"Подвал",41=>"Старый Зал 2",42=>"Служебная Комната",43=>"Комната в Подвале",44=>"Темная Комната",45=>"Старый Зал 1",46=>"Зал Ожидания",47=>"Зал Ораторов",37=>"Оружейная Комната",38=>"Бойница",50=>"Этаж 1Б - Коридор",51=>"Этаж 1М - Коридор",52=>"Этаж 1М - Зал Поклонения",53=>"Этаж 1М - Вход",54=>"Этаж 1М - Тупик",55=>"Этаж 1М - Портал",56=>"Этаж 1Б - Казармы",57=>"Этаж 1Б - Оружейная",);
  session_start();
  include "connect.php";
  include "functions.php";
  if ($user["battle"]) {
    header("location: fbattle.php");
    die;
  }
  echo "<script>document.location.replace('cave.php');</script>";
  $objsizes=array(
  5=>array(120,220),
  6=>array(194,55),
  7=>array(120,60),
  8=>array(120,60),
  9=>array(120,60),
  10=>array(120,60),
  11=>array(120,60),
  12=>array(120,60),
  13=>array(60,60),
  14=>array(60,60),
  15=>array(121,39),
  16=>array(120,120),
  17=>array(120,70),
  18=>array(120,70),
  19=>array(120,120),
  20=>array(120,150),
  21=>array(252,174),
  22=>array(252,179),

  50=>array(60,60),
  51=>array(252,174),
  52=>array(198,55),
  53=>array(120,30),
  );
                             
  $objdata[3][0]=array("wd"=>1.44, "ht"=>1.44, "y"=>1, "x"=>176);
                             
  $objdata[3][1]=array("coef"=>1, "y"=>202, "x"=>176);
  $objdata[1][1]=array("coef"=>1, "y"=>202, "x"=>-65);
  $objdata[5][1]=array("coef"=>1, "y"=>202, "x"=>435);
                             
  $objdata[3][2]=array("coef"=>0.67, "y"=>162, "x"=>176);
  $objdata[1][2]=array("coef"=>0.67, "y"=>162, "x"=>18);
  $objdata[5][2]=array("coef"=>0.67, "y"=>162, "x"=>342);
                             
  $objdata[3][3]=array("coef"=>0.50, "y"=>141, "x"=>176);
  $objdata[1][3]=array("coef"=>0.50, "y"=>141, "x"=>50);
  $objdata[5][3]=array("coef"=>0.50, "y"=>141, "x"=>300);


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

  $eventdata[3][1]=array("x"=>176, "y"=>200, "q"=>1);

  $eventdata[3][2]=array("x"=>176, "y"=>149, "q"=>0.66);
  $eventdata[1][2]=array("x"=>16, "y"=>149, "q"=>0.66);
  $eventdata[5][2]=array("x"=>335, "y"=>149, "q"=>0.66);

  $eventdata[3][3]=array("x"=>176, "y"=>133, "q"=>0.5);
  $eventdata[1][3]=array("x"=>56,  "y"=>133, "q"=>0.5);
  $eventdata[5][3]=array("x"=>296, "y"=>133, "q"=>0.5);


  $bots=array(3=>11111, 4=>11112, 5=>11113, 6=>11114, 7=>11115, 8=>11116, 9=>11135, 10=>11133, 11=>11141, 12=>11142, 13=>11143, 14=>11144, 15=>11145, 16=>11146, 17=>11147, 18=>11148, 19=>11149, 20=>11150, 21=>11151, 22=>11152, 50=>3946);
  $botnames=array(3=>"Обезьяноподобный", 4=>"Зеленоглазый", 5=>"Ящер", 6=>"Тварь Рогатая", 7=>"Зеброкот", 8=>"Головастик", 9=>"Страж подгорья", 10=>"Цверг", 11=>"Смотритель мглы", 12=>"Сторож мглы", 13=>"Рабочий мглы", 14=>"Литейщик", 15=>"Надзиратель глубин", 16=>"Офицер глубин", 17=>"Наххр", 18=>"Служитель глубин", 19=>"Рубка глубин", 20=>"Берсерк", 21=>"Слизь", 22=>"Зубастая слизь", 50=>"Отморозок");
  $objects=array(5=>"Статуя трупожёра", 6=>"Истлевший скелет", 7=>"Камень", 8=>"Телепорт", 9=>"Портал Шута", 10=>"Портал Чернокнижника", 11=>"Портал Епископа", 12=>"Подозрительная трещина", 13=>"Сундук", 14=>"Сундук", 15=>"Водосток", 16=>"Кровать", 17=>"Сундук", 18=>"Сундук", 19=>"Фонтан лёгкой жизни", 20=>"Замаскированный обменник", 21=>"Баррикада", 22=>"Дверь", 50=>"Сундучок отморозка", 51=>"Решётка", 52=>"Прорубь", 53=>"Спуск", 500=>"Пустой сундук", 501=>"Сундук", 510=>"Баррикада", "601"=>"Телепорт на 1-й этаж", "602"=>"Телепорт на 2-й этаж");
  if ($user["room"]==65) {
    $objects["700"]=="Знак";
    $i=0;
    while ($i<36) {
      $i++;
      $objects[700+$i]="Указатель пути";
    }
  }

  $events=array(700=>array("name"=>"Провал", "w"=>65, "h"=>36), 701=>array("name"=>"Провал", "w"=>65, "h"=>36), 1=>array("name"=>"Без картинки"));

  $dialogs=array(11111=>"Чародей-травник", 11153=>"Отмороженный Бугай", 11154=>"Верховный Воевода");

  $noautoexit=0;

  function makedeath() {
    global $user, $floor, $loses, $x, $y, $dir;
    include "config/cavedata.php";
    mq("update caveparties set x='".$cavedata[$user["room"]]["x$floor"]."', y='".$cavedata[$user["room"]]["y$floor"]."', dir='".$cavedata[$user["room"]]["dir$floor"]."', loses=loses+1 where user='$user[id]'");
    $x=$cavedata[$user["room"]]["x$floor"];
    $y=$cavedata[$user["room"]]["y$floor"];
    $dir=$cavedata[$user["room"]]["dir$floor"];
    updparties();
    $loses++;
  }

  function pickupitem($item, $foronetrip, $notmore1) {
    global $user;
    if ($notmore1) {
      $i=mqfa1("select id from inventory where prototype='$item' and owner='$user[id]'");
      if ($i) return "Вы уже получили здесь всё необходимое.";
    }
    $taken=takeshopitem($item, "shop", "", $foronetrip, 0, array("podzem"=>1));
    return "Вы получили <b>$taken[name]</b>.";
  }

  function makeinjury() {
    global $user, $floor, $noautoexit, $loses, $x, $y, $dir;
    settravma($user["id"],20,rand(300,600),1,1);
    makedeath();
    $noautoexit=1;
  }

  function cavewall($w) {
    if ($w<100) return floor($w/10);
    else return floor($w/1000)+100;
  }

  function passablewall($n) {
    if ($n==0 || $n==31) return true;
    return false;
  }

  function canmoveto($cell, $freecell=0, $passing=0) {
    if (!passablewall($passing)) return false;
    $obj=substr($cell,0,1);
    if ($obj=="e" || $obj=="u" || $obj=="s") return true;
    if (!$freecell && $cell) return false;
    if ($cell==$freecell) return true;
    return false;
  }
  function gotoxy($tox, $toy, $tofloor=0) {
    global $map, $x, $y, $floor, $user;
    $floor1=$floor;
    $upd="";
    if ($tox) {
      $tox=$tox/2;
      if ($upd) $upd.=", ";
      $upd.=" x='$tox'";
      $x=$tox;
    }
    if ($toy) {
      $toy=$toy/2;
      if ($upd) $upd.=", ";
      $upd.=" y='$toy'";
      $y=$toy;
    }
    if ($tofloor && $tofloor!=$floor) {
      if ($upd) $upd.=", ";
      $upd.=" floor='$tofloor'";
      $floor=$tofloor;
    }
    mq("update caveparties set $upd where user='$user[id]'");
    if ($tofloor && $tofloor!=$floor1) {
      $map=mqfa1("select map from caves where leader='$user[caveleader]' and floor='$floor'");
      $map=unserialize($map);
    }
    updparties();
  }

  function updparties() {
    global $user, $x, $y, $floor, $dir, $party;
    foreach ($party as $k=>$v) {
      if ($v["user"]==$user["id"]) {
        $party[$k]["dir"]=$dir;
        $party[$k]["x"]=$x;
        $party[$k]["y"]=$y;
        $party[$k]["floor"]=$floor;
      }
    }
  }

  function loadmap() {
    global $user, $map, $floor;
    $map=mqfa1("select map from caves where leader='$user[caveleader]' and floor='$floor'");
    $map=unserialize($map);
  }

  if (!in_array($user['room'],$caverooms)) {
    header("location: main.php");
    die;
  }
  if ($user["room"]==302) {
    $base=IMGBASE."/underdesigns/alchcave"; 
  } elseif ($user["room"]==61) {
    $base=IMGBASE."/underdesigns/forsakenpalace"; 
  } elseif ($user["room"]==65) {
    $base=IMGBASE."/underdesigns/puzzlecave"; 
  } elseif ($user["room"]==72) {
    $base=IMGBASE."/underdesigns/deathtower"; 
  } elseif ($user["room"]==74) {
    $base=IMGBASE."/underdesigns/catacombs"; 
  } elseif ($user["room"]==91) {
    $base=IMGBASE."/underdesigns/icecave"; 
  } else {
    $base=IMGBASE."/underdesigns/crystalcave1"; 
  }
  if (isset($_GET["direction"])) {
    $dir=(int)$_GET["direction"];
    if ($dir>=0 && $dir<=3) mq("update caveparties set dir='$dir' where user='$user[id]'");
  }
  $party=array();
  $r=mq("select user, x, y, dir, login, shadow, floor, loses from caveparties where leader='$user[caveleader]' order by id");
  while ($rec=mysql_fetch_assoc($r)) {
    if ($rec["user"]==$user["id"]) {
      $x=$rec["x"];
      $y=$rec["y"];
      $dir=$rec["dir"];
      $floor=$rec["floor"];
      $loses=$rec["loses"];
    }
    //unset($rec["user"]);
    $party[]=$rec;
  }

  //if ($user["room"]==74) $maxloses=1;
  //else 
  $maxloses=3;

  if ($loses>=$maxloses && !$noautoexit) $_GET["exit"]=1;

  if (@$_POST["kill"] && $user["id"]==$user["caveleader"] && $_POST["kill"]!=$user["login"]) {
    foreach ($party as $k=>$v) {
      if ($v["login"]==$_POST["kill"]) {
        mq("delete from caveparties where user='$v[user]'");
        mq("update users set room=room-1, caveleader=0 where id='$v[user]'");
        mq("delete from inventory where owner='$v[user]' and foronetrip=1");
        unset($party[$k]);
        $report="Персонаж $v[login] исключён из похода.";
        break;
      }
    }
    if (!@$report) $report="Персонаж $_POST[kill] не найден.";
  }

  if (@$_POST["change"] && $user["id"]==$user["caveleader"] && $_POST["change"]!=$user["login"]) {
    foreach ($party as $k=>$v) {
      if ($v["login"]==$_POST["change"]) {
        mq("lock tables users write, caveparties write, cavebots write, caves write, caveitems write");
        mq("update users set caveleader='$v[user]' where caveleader='$user[id]'");
        mq("update cavebots set leader='$v[user]' where leader='$user[id]'");
        mq("update caves set leader='$v[user]' where leader='$user[id]'");
        mq("update caveparties set leader='$v[user]' where leader='$user[id]'");
        mq("update caveitems set leader='$v[user]' where leader='$user[id]'");
        $user["caveleader"]=$v["user"];
        $report="Персонажу $v[login] присвоено лидерство.";
        mq("unlock tables");
        break;
      }
    }
    if (!@$report) $report="Персонаж $_POST[change] не найден.";
  }


  if (@$_GET["useitem"] || @$_GET["usewallitem"]) mq("lock tables userdata write, obshagaeffects write, effects write, cavebots write, quests write, battle write, users write, droplog write, caveparties write, caves write, smallitems write, shop write, inventory write, bots write");
  loadmap();


  if (@$_GET["useitem"]) {
    if ($dir==0) {$tx=$x-1;$ty=$y;}
    if ($dir==1) {$tx=$x;$ty=$y-1;}
    if ($dir==2) {$tx=$x+1;$ty=$y;}
    if ($dir==3) {$tx=$x;$ty=$y+1;}

    if (@$_GET["useitem"]) {
      if (file_exists("underground/objects/$user[room].php")) include "underground/objects/$user[room].php";
    }

    list($t, $obj)=explode("/", $map[$ty*2][$tx*2]);
    if ($t=="o") {
      if ($obj==500) $report="В этот сундук уже кто-то заглядывал";
      if ($obj==501) {
        $map[$ty*2][$tx*2]="o/500";
        include_once("questfuncs.php");
        $rnd=rand(1,100);
        if ($rnd<=94) $taken=takesmallitem(37, 0, "Нашёл в пещере");
        elseif ($rnd<=97) $taken=takesmallitem(39, 0, "Нашёл в пещере");
        elseif ($rnd<=99) $taken=takesmallitem(40, 0, "Нашёл в пещере");
        else {
          $items=array(1946, 1947, 1948, 1949, 1950, 1951);
          $item=$items[rand(0,5)];
          $taken=takeshopitem($item, "shop", "", "", 0, array("podzem"=>1, "maxdur"=>5+rand(0,5), "isrep"=>0));        
        }
        $report="В сундуке вы нашли $taken[name].";
        mq("update caves set map='".serialize($map)."' where leader='$user[caveleader]' and floor='$floor'");
      }
      if ($obj==602 || $obj==601) {
        $floor=$obj-600;
        mq("update caveparties set floor=$floor where user='$user[id]'");
        $map=mqfa1("select map from caves where leader='$user[caveleader]' and floor='$floor'");
        $map=unserialize($map);
        $report="Перемещение прошло успешно";
      }
    }
    mq("unlock tables");
  }

  function updmap() {
    global $map, $user, $floor;
    mq("update caves set map='".serialize($map)."' where leader='$user[caveleader]' and floor='$floor'");
  }

  if (@$_GET["usewallitem"]) {
    if ($dir==0) {$tx=$x*2-1;$ty=$y*2;}
    if ($dir==1) {$tx=$x*2;$ty=$y*2-1;}
    if ($dir==2) {$tx=$x*2+1;$ty=$y*2;}
    if ($dir==3) {$tx=$x*2;$ty=$y*2+1;}
    $obj=$map[$ty][$tx];
    if ($obj%1000==101) {
      $map[11][8]="21";
      $map[6][11]="31";
      if ($map[$ty][$tx]<1000) $map[$ty][$tx]+=1000; else $map[$ty][$tx]-=1000;
      updmap();
    }
    if ($obj%1000==102) {
      if ($map[$ty][$tx]<1000) $map[$ty][$tx]+=1000; else $map[$ty][$tx]-=1000;
      $map[6][11]="31";updmap();
    }
    if ($obj%1000==103) {
      if ($map[$ty][$tx]<1000) $map[$ty][$tx]+=1000; else $map[$ty][$tx]-=1000;
      $map[11][8]="31";updmap();
    }
    if ($obj%1000==104) {
      if ($map[$ty][$tx]<1000) $map[$ty][$tx]+=1000; else $map[$ty][$tx]-=1000;
      $map[24][7]="31";updmap();
    }
    if ($obj%1000==105) {
      if ($map[$ty][$tx]<1000) $map[$ty][$tx]+=1000; else $map[$ty][$tx]-=1000;
      $map[14][21]="31";
      $map[24][7]="21";
      updmap();
    }
    if ($obj%1000==106) {
      if ($map[$ty][$tx]<1000) $map[$ty][$tx]+=1000; else $map[$ty][$tx]-=1000;
      $map[18][7]="31";updmap();
    }
    if ($obj%1000==107) {
      if ($map[$ty][$tx]<1000) $map[$ty][$tx]+=1000; else $map[$ty][$tx]-=1000;
      $map[14][13]="31";updmap();
    }
    if ($obj%1000==108) {
      if ($map[$ty][$tx]<1000) $map[$ty][$tx]+=1000; else $map[$ty][$tx]-=1000;
      $map[27][10]="31";updmap();
    }
    if ($obj%1000==109) {
      if ($map[$ty][$tx]<1000) $map[$ty][$tx]+=1000; else $map[$ty][$tx]-=1000;
      $map[11][18]="31";updmap();
    }
    if ($obj%1000==110) {
      if ($map[$ty][$tx]<1000) $map[$ty][$tx]+=1000; else $map[$ty][$tx]-=1000;
      $map[17][18]="31";updmap();
    }
    if ($obj%1000==111) {
      if ($map[$ty][$tx]<1000) $map[$ty][$tx]+=1000; else $map[$ty][$tx]-=1000;
      $map[11][18]="21";
      $map[8][21]="31";updmap();
    }
    if ($obj%1000==112) {
      if ($map[$ty][$tx]<1000) $map[$ty][$tx]+=1000; else $map[$ty][$tx]-=1000;
      $map[11][18]="21";
      $map[8][25]="31";updmap();
    }
    if ($obj%1000==113) {
      if ($map[$ty][$tx]<1000) $map[$ty][$tx]+=1000; else $map[$ty][$tx]-=1000;
      $map[11][18]="21";
      $map[8][21]="21";updmap();
    }
    if ($obj%1000==114) {
      if ($map[$ty][$tx]<1000) $map[$ty][$tx]+=1000; else $map[$ty][$tx]-=1000;
      $map[8][31]="31";updmap();
    }
    if ($obj%1000==115) {
      if ($map[$ty][$tx]<1000) $map[$ty][$tx]+=1000; else $map[$ty][$tx]-=1000;
      $map[15][28]="31";updmap();
    }
    if ($obj%1000==116) {
      if ($map[$ty][$tx]<1000) $map[$ty][$tx]+=1000; else $map[$ty][$tx]-=1000;
      $map[29][28]="31";updmap();      
    }
    if ($obj%1000==117) {
      if ($map[$ty][$tx]<1000) $map[$ty][$tx]+=1000; else $map[$ty][$tx]-=1000;
      $map[5][18]="31";updmap();      
    }
    if ($obj%1000==118) {
      if ($map[$ty][$tx]<1000) $map[$ty][$tx]+=1000; else $map[$ty][$tx]-=1000;
      $map[21][32]="31";updmap();
    }
    if ($obj%1000==119) {
      if ($map[$ty][$tx]<1000) $map[$ty][$tx]+=1000; else $map[$ty][$tx]-=1000;
      $map[27][28]="31";updmap();
    }
    
    if ($obj==18) $report="Вы не обнаружили ничего интересного.";
    if ($obj==19) $report="Уже проверено, сюда лучше не лазить.";
    if ($obj==11) {
      $map[$ty][$tx]="18";
      include_once("questfuncs.php");
      $rnd=rand(1,100);
      if ($rnd<=95) $taken=takesmallitem(37, 0, "Нашёл в пещере");
      else $taken=takesmallitem($rnd-54, 0, "Нашёл в пещере");
      $report="После длительных поисков вы обнаружили \"$taken[name]\".<br><br>
      <center><img src=\"".IMGBASE."/i/sh/$taken[img]\"></center>";
      mq("update caves set map='".serialize($map)."' where leader='$user[caveleader]' and floor='$floor'");
    }
    if ($obj==12) {
      include_once("questfuncs.php");
      include_once "config/cavedata.php";
      $report="За проёмом в стене вы обнаружили ход, который вывел вас куда-то...<br><br>";
      //mq("update caves set map='".serialize($map)."' where leader='$user[caveleader]' and floor='$floor'");
      mq("update caveparties set x='".$cavedata[$user["room"]]["x$floor"]."', y='".$cavedata[$user["room"]]["y$floor"]."', dir='".$cavedata[$user["room"]]["dir$floor"]."' where user='$user[id]'");
      $x=$cavedata[$user["room"]]["x$floor"];
      $y=$cavedata[$user["room"]]["y$floor"];
      $dir=$cavedata[$user["room"]]["dir$floor"];
      updparties();
    }
    if ($obj==13) {
      include_once("questfuncs.php");
      $map[$ty][$tx]="19";
      $report="Как только вы начали исследовать проём, на вас набросилось какое-то существо, начался поединок. Проём слишком узкий, чтобы туда мог залезть ещё кто-то, так что подмоги не ждите.<br><br>
      <center><a href=\"fbattle.php\">перейти к поединку</a></center>";
      $btl=battlewithbot(11134, "", "", 10, 0, 1, 0, 0, 0, array(), 1);
      mq("update caves set map='".serialize($map)."' where leader='$user[caveleader]' and floor='$floor'");
    }
    if ($obj==14) {
      include_once("questfuncs.php");
      $map[$ty][$tx]="19";
      $report="В проёме совсем темно, вы начинаете остороно ощупывать края, как неожиданно из темноты высовывается что-то очень зубастое и очень больно кусает вас за руку. Пожалуй, не стоит продолжать поиски, так как в темноте и в узком помещении преимущество явно не на вашей стороне.<br><br>";
      mq("update users set hp=1 where id='$user[id]'");
      $user["hp"]=1;
      mq("update caves set map='".serialize($map)."' where leader='$user[caveleader]' and floor='$floor'");
    }
    mq("unlock tables");
  }

  //$map[]
  $r=mq("select id, bot, x, y, cnt, type, battle from cavebots where leader='$user[caveleader]' and floor='$floor'");
  $mapbots=array();
  $ambushes=array();
  $cavedata=getcavedata($user["caveleader"], $floor);
  if (time()-$cavedata["wander"]>20) $wander=1;
  $wanderers=array();
  while ($rec=mysql_fetch_assoc($r)) {    
    if ($rec["type"]==1 && $wander && $rec["battle"]==0) {
      $wanderers[]=$rec;
      continue;
    }
    if (!@$mapbots[$rec["y"]][$rec["x"]]) $mapbots[$rec["y"]][$rec["x"]]="b";
    if (($rec["type"]==1 || $rec["type"]==2) && $rec["battle"]==0) $ambushes[$rec["y"]][$rec["x"]]=1;
    $mapbots[$rec["y"]][$rec["x"]].="/$rec[bot]/$rec[cnt]";
  }
  if ($wander) {    
    foreach ($wanderers as $k=>$v) {
      $d=rand(0, 3);
      $i=0;
      while ($i<4) {
        if ($d==0) {$tx=$v["x"]-2;$ty=$v["y"];}
        if ($d==1) {$tx=$v["x"];$ty=$v["y"]-2;}
        if ($d==2) {$tx=$v["x"]+2;$ty=$v["y"];}
        if ($d==3) {$tx=$v["x"];$ty=$v["y"]+2;}
        if ($map[$ty][$tx]==2 && $map[$v["y"]+(($v["y"]-$ty)/2)][$v["x"]+(($v["x"]-$tx)/2)]==0 && !@$mapbots[$ty][$tx]) {
          break;
        }
        $d++;
        $d=$d%4;
        $i++;
      }
      if ($i<4) {
        mq("update cavebots set x='$tx', y='$ty' where id='$v[id]'");
        $v["x"]=$tx;$v["y"]=$ty;
      }
      if (!@$mapbots[$v["y"]][$v["x"]]) $mapbots[$v["y"]][$v["x"]]="b";
      $ambushes[$v["y"]][$v["x"]]=1;
      $mapbots[$v["y"]][$v["x"]].="/$v[bot]/$v[cnt]";
    }
    $cavedata["wander"]=time();
    savecavedata($cavedata, $user["caveleader"], $floor);
  }
  foreach ($mapbots as $k=>$v) {
    foreach ($v as $k2=>$v2) {
      $map[$k][$k2]=$v2;
    }
  }

  if (@$_GET["move"] && $_SESSION["movetime"]<time()) {
    if ($_GET["move"]=="x1" && canmoveto($map[$y*2][$x*2+2],2,$map[$y*2][$x*2+1],2)) {
      //if (!mqfa1("select id from cavebots where leader='$user[caveleader]' and x=$x*2+2 and y=$y*2 and floor='$floor'")) 
      mq("update caveparties set x=x+1 where user='$user[id]'");
      $x++;
    }
    if ($_GET["move"]=="x2" && canmoveto($map[$y*2][$x*2-2],2,$map[$y*2][$x*2-1])) {
      //if (!mqfa1("select id from cavebots where leader='$user[caveleader]' and x=$x*2-2 and y=$y*2 and floor='$floor'")) 
      mq("update caveparties set x=x-1 where user='$user[id]'");
      $x--;
    }
    if ($_GET["move"]=="y1" && canmoveto($map[$y*2+2][$x*2],2,$map[$y*2+1][$x*2])) {
      //if (!mqfa1("select id from cavebots where leader='$user[caveleader]' and x=$x*2 and y=$y*2+2 and floor='$floor'")) 
      mq("update caveparties set y=y+1 where user='$user[id]'");
      $y++;
    }
    if ($_GET["move"]=="y2" && canmoveto($map[$y*2-2][$x*2],2,$map[$y*2-1][$x*2])) {
      //if (!mqfa1("select id from cavebots where leader='$user[caveleader]' and x=$x*2 and y=$y*2-2 and floor='$floor'")) 
      mq("update caveparties set y=y-1 where user='$user[id]'");
      $y--;
    }
    updparties();
    if (haseffect($user["data"], LIGHTSTEPS) && $user["room"]!=65) {
      $_SESSION["movetime"]=time()+4;
    } elseif ($user["id"]==2372) $_SESSION["movetime"]=time()+6;
    elseif ($user["room"]==61 && $user["id"]!=7) $_SESSION["movetime"]=time()+5;
    elseif ($_SERVER["REMOTE_ADDR"]=="127.0.0.1") $_SESSION["movetime"]=time()-1;
    elseif ($user["id"]!=7) $_SESSION["movetime"]=time()+10;
  }

  if (substr($map[$y*2][$x*2],0,1)==="e") {
    $tx=$x;
    $ty=$y;
    $tmp=explode("/",$map[$y*2][$x*2]);
    if (file_exists("underground/events/$user[room].php")) include "underground/events/$user[room].php";
    if ($tmp[1]==700) {
      mq("update caveparties set x=2, y=2, floor=2 where user='$user[id]'");
      $x=2;$y=2;$floor=2;
      updparties();
      loadmap();
      $report="Вы попали в провал и упали куда-то...";
    }
    if ($tmp[1]==701) {
      mq("update caveparties set x=4, y=6, floor=2 where user='$user[id]'");
      $x=4;$y=6;$floor=2;
      updparties();
      loadmap();
      $report="Вы попали в провал и упали куда-то...";
    }
  }

  $ax=0;$ay=0;
  if ($ambushes[$y*2+2][$x*2] && $map[$y*2+1][$x*2]==0) {$ax=$x;$ay=$y+1;}
  if ($ambushes[$y*2-2][$x*2] && $map[$y*2-1][$x*2]==0) {$ax=$x;$ay=$y-1;}
  if ($ambushes[$y*2][$x*2+2] && $map[$y*2][$x*2+1]==0) {$ax=$x+1;$ay=$y;}
  if ($ambushes[$y*2][$x*2-2] && $map[$y*2][$x*2-1]==0) {$ax=$x-1;$ay=$y;}


  if ($ax && $ay) {
    include_once("config/cavedata.php");
    if (!($cavedata[$user["room"]]["x$floor"]==$x && $cavedata[$user["room"]]["y$floor"]==$y)) {
      if ($ax<$x) $dir1=0;
      elseif ($ax>$x) $dir1=2;
      elseif ($ay<$y) $dir1=1;
      elseif ($ay>$y) $dir1=3;
      if ($dir!=$dir1) {
        $dir=$dir1;
        mq("update caveparties set dir='$dir' where user='$user[id]'");
        foreach ($party as $k=>$v) {
          if ($v["user"]==$user["id"]) $party[$k]["dir"]=$dir1;
        }
      }
      $_GET["attack"]=1;
    }
  }

  if (!@$_SESSION["movetime"]) {
    $_SESSION["movetime"]=time()+10;
  }
  if (@$_GET["takeitem"]) {
    $_GET["takeitem"]=(int)$_GET["takeitem"];
    $it=mqfa("select item, small from caveitems where leader='$user[caveleader]' and x='".($x*2)."' and y='".($y*2)."' and floor='$floor' and id='$_GET[takeitem]'");
    if ($it) {
      include_once("questfuncs.php");
      if ($it["small"]) {
        mq("delete from caveitems where leader='$user[caveleader]' and x='".($x*2)."' and y='".($y*2)."' and floor='$floor' and id='$_GET[takeitem]'");
        $taken=takesmallitem($it["item"], 0, "Нашёл в пещере");
        $report="Вы нашли $taken[name].";
      } else {
        if ($it["item"]==2347) {
          if ($user["level"]<=6) $taken=takeshopitem($it["item"], "shop", "", "", 0, array("podzem"=>1, "nlevel"=>6, "maxdur"=>20, "cost"=>57, "stats"=>5));
          elseif ($user["level"]<=7) $taken=takeshopitem($it["item"], "shop", "", "", 0, array("podzem"=>1, "maxdur"=>30, "nlevel"=>7, "cost"=>94, "stats"=>6));
          else $taken=takeshopitem($it["item"], "shop", "", "", 0, array("podzem"=>1, "nlevel"=>8, "maxdur"=>40, "cost"=>141, "stats"=>7));
          if (@$taken["error"]) {
            $report=$taken["error"];
          } else {
            mq("delete from caveitems where leader='$user[caveleader]' and x='".($x*2)."' and y='".($y*2)."' and floor='$floor' and id='$_GET[takeitem]'");
            $report="Вы нашли $taken[name].";
            adddelo($user["id"], "Получено в пещере: $rec[name] (id: $rec[id]).", 1);
          }
        } else {
          $taken=takeshopitem($it["item"], "shop", "", "", 0, array("podzem"=>1), 0, 1, "Нашёл в пещере");
          if (@$taken["error"]) {
            $report=$taken["error"];
          } else {
            mq("delete from caveitems where leader='$user[caveleader]' and x='".($x*2)."' and y='".($y*2)."' and floor='$floor' and id='$_GET[takeitem]'");
            $report="Вы нашли $taken[name].";
          }
        }
      }
    } else $report="Кто-то оказался быстрее...";
  }
  if (@$_GET["speak"]) {
    if ($dir==0) $x1=$x*2-2; elseif ($dir==2) $x1=$x*2+2; else $x1=$x*2;
    if ($dir==1) $y1=$y*2-2; elseif ($dir==3) $y1=$y*2+2; else $y1=$y*2;    
    $cell=$map[$y1][$x1];
    $tmp=explode("/", $cell);
    if ($tmp[0]=="d") {
      header("location: dialog.php?char=$tmp[2]");
      die;
    }
  }
  if (@$_GET["attack"]) {
    if ($dir==0) {$by=$y*2; $bx=($x-1)*2;}
    if ($dir==1) {$by=($y-1)*2; $bx=$x*2;}
    if ($dir==2) {$by=$y*2; $bx=($x+1)*2;}
    if ($dir==3) {$by=($y+1)*2; $bx=$x*2;}
    $r=mq("select bot, cnt, battle from cavebots where leader='$user[caveleader]' and x=$bx and y=$by and floor='$floor'");
    $rec=mysql_fetch_assoc($r);
    if ($rec) {
      include_once("questfuncs.php");
      $btl=$rec["battle"];
      if ($btl) {
        battlewithbot($bots[$rec["bot"]], "", "", 10, 0, 0, 0, 0, $btl);
      } else {        
        $firstbot=$bots[$rec[bot]];
        $otherbots=array();
        $rec["cnt"]--;
        while ($rec["cnt"]>0) {
          $otherbots[]=array("id"=>$bots[$rec["bot"]], "name"=>$botnames[$rec["bot"]]);
          $rec["cnt"]--;
        }
        while ($rec=mysql_fetch_assoc($r)) {
          while ($rec["cnt"]>0) {
            $otherbots[]=array("id"=>$bots[$rec["bot"]], "name"=>$botnames[$rec["bot"]]);
            $rec["cnt"]--;
          }
        }
        $btl=battlewithbot($firstbot, "", "", 10, 0, 0, 0, 0, 0, $otherbots);
        mq("update cavebots set battle='$btl' where leader='$user[caveleader]' and x='$bx' and y=$by and floor='$floor'");
      }
    }
  }

  if ($user["room"]==61 && $x==14 && $y==15) {
    $finished=1;
    foreach ($party as $k=>$v) {
      if ($v["x"]!=$x || $v["y"]!=$y) $finished=0;
    }
    if (!$finished) $report="Вам необходимо всей командой собратся здесь.";
    else $report="Вы нашли выход из лабиринта.<br><br><a href=\"cave.php?exit=1\">Выйти</a>";
  }

  //$base=".";
  if (@$_GET["exit"]) {
    if ($user["room"]==61 && $x==14 && $y==15 && $finished) {
      include_once("questfuncs.php");
      if (LETTERQUEST) {
        $taken=takesmallitem(61);
        privatemsg("Вы нашли <b>$taken[name].</b>", $user["login"]);
      }
    }
    if (count($party)==1) {
      mq("delete from cavebots where leader='$user[id]'");
      mq("delete from caves where leader='$user[id]'");
      mq("delete from caveparties where leader='$user[id]'");
      mq("delete from caveitems where leader='$user[id]'");
      mq("update users set caveleader=0 where id='$user[id]'");
    } else {
      mq("lock tables users write, caveparties write, cavebots write, caves write, caveitems write");
      mq("delete from caveparties where user='$user[id]'");
      mq("update users set caveleader=0 where id='$user[id]'");
      if ($user["caveleader"]==$user["id"]) {
        foreach ($party as $k=>$v) {
          if ($v["user"]!=$user["id"]) {
            mq("update users set caveleader='$v[user]' where caveleader='$user[id]'");
            mq("update cavebots set leader='$v[user]' where leader='$user[id]'");
            mq("update caves set leader='$v[user]' where leader='$user[id]'");
            mq("update caveparties set leader='$v[user]' where leader='$user[id]'");
            mq("update caveitems set leader='$v[user]' where leader='$user[id]'");
          }
        }
      }
      mq("unlock tables");
    }
    mq("delete from inventory where owner='$user[id]' and foronetrip=1");
    gotoroom($user["room"]-1);
  }
  $standingon=$map[$y*2][$x*2];
  foreach ($party as $k=>$v) {
    $map[$v["y"]*2][$v["x"]*2]="u/".$v["user"];
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

.cw1 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/cw1.gif?1)}
.cw2 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/cw2.gif?1)}
.cw3 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/cw3.gif?1)}
.cw4 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/cw4.gif?1)}
.cw5 {position:absolute;left:0px;top:0px;width:352px;height:240px;background-image:url(<?=$base?>/cw5.gif?1)}

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
function closehint3() {
  document.getElementById("hint3").style.visibility='hidden';
}
function findlogin(title, script, name){
  document.getElementById("hint3").innerHTML = '<form action="'+script+'" method=post><table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
  '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><INPUT TYPE=hidden name=sd4 value="6"><td colspan=2>'+
  'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD width=50% align=right><INPUT TYPE=text NAME="'+name+'"></TD><TD width=50%><INPUT TYPE="submit" value=" »» "></TD></TR></TABLE></td></tr></table></form>';
  document.getElementById("hint3").style.visibility = "visible";
  document.getElementById("hint3").style.left = 100;
  document.getElementById("hint3").style.top = 100;
  Hint3Name = name;
  document.all(name).focus();
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
  el.innerHTML = '<div style="color:#000;font-size:14px;padding:5px 10px 5px 10px" class=menuItem onmouseout="this.className=\'menuItem\';" onmouseover="this.className=\'menuItem2\';" onclick="this.disabled = true;document.location.href=\'cave.php?attack=1\';"> <b>Напасть</b> </div>';
  //el.innerHTML = '<div style="color:#000;font-size:14px;padding:5px 10px 5px 10px" class=menuItem onmouseout="this.className=\'menuItem\';" onmouseover="this.className=\'menuItem2\';"> <a href="javascript:void(0)" onclick="this.disabled = true;attack('+n+');closeMenu(event);">Напасть</a> </div><div style="text-align:right;padding: 0px 10px 5px 0px"><a href="javascript:void(0);" onclick="closeMenu(event);">X</a></div>';

  el.style.left = posx + "px";
  el.style.top  = posy + "px";
  el.style.visibility = "visible";
}

function speakmenu(e){
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
  el.innerHTML = '<div style="color:#000;font-size:14px;padding:5px 10px 5px 10px" class=menuItem onmouseout="this.className=\'menuItem\';" onmouseover="this.className=\'menuItem2\';" onclick="this.disabled =  true;document.location.href=\'cave.php?speak=1\';closeMenu(event);"> <b>Говорить</b> </div>';
  //el.innerHTML = '<div style="color:#000;font-size:14px;padding:5px 10px 5px 10px" class=menuItem onmouseout="this.className=\'menuItem\';" onmouseover="this.className=\'menuItem2\';"> <a href="javascript:void(0)" onclick="this.disabled = true;attack('+n+');closeMenu(event);">Напасть</a> </div><div style="text-align:right;padding: 0px 10px 5px 0px"><a href="javascript:void(0);" onclick="closeMenu(event);">X</a></div>';

  el.style.left = posx + "px";
  el.style.top  = posy + "px";
  el.style.visibility = "visible";
}

</script>
</head>
<body style="margin:0px" bgcolor="#d7d7d7" onLoad="<?=topsethp()?>">
<div id=hint3 class=ahint></div>
<div style="z-index: 100;  background-color: #E4F2DF;  border-style: solid; border-width: 2px; border-color: #77c3fc; position: absolute;  left: 0px;  top: 0px;  visibility: hidden;  cursor:pointer;" id="oMenu"></div>
<?
  if ($user["hp"]<=0) {
    makedeath();
  }
  function drawmap($map1, $players, $x, $y, $direction) {
    global $base, $user, $botnames, $imgdata;
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
    if ($direction%2==1) {
      $sy1=$y1;
      while ($x1!=$x2) {
        $y1=$sy1;
        $y0=-2;
        while ($y1!=$y2) {
          if ($map1[$y1][$x1]==2) $sq=0;
          elseif (isset($map1[$y1][$x1])) $sq=$map1[$y1][$x1];
          else $sq=0;
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
          if ($map1[$y1][$x1]==2) $sq=0;
          elseif (isset($map1[$y1][$x1])) $sq=$map1[$y1][$x1];
          else $sq=0;
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
    function drawbot($cell, $x, $y) {
      global $botnames, $imgdata;
      $data=explode("/", $cell);
      $i=1;
      $bc=(count($data)-1)/2;
      while ($data[$i]) {
        $bot=$data[$i];
        $botname=$botnames[$bot];
        $cnt=$data[$i+1];

        if ($i==1) {
          if ($bc==1) $bn=1;
          else $bn=0;
        } elseif ($i==3) {
          if ($bc==2) $bn=2;
          else $bn=1;
        } else $bn=2;
        $ret.="<img title=\"$botname".($cnt>1?" ($cnt)":"")."\" ".($y==1 && $x==3?"onclick=\"attackmenu(event);\"":"")." width=\"".$imgdata[$x][$y]["wd"]."\" height=\"".$imgdata[$x][$y]["ht"]."\" src=\"/i/dungeon/mobs/$bot.gif\" style=\"position:absolute;left:".$imgdata[$x][$y]["x"][$bn]."px;top:".$imgdata[$x][$y]["y"]."px;".($x==3 && $y==1?"cursor:pointer;":"").($x==3?"z-index:".(99-($y*5)).";":"")."\">";
        $i+=2;
      }
      return $ret;
    }

    function drawdialog($cell, $x, $y) {
      global $dialogs, $imgdata;
      $data=explode("/", $cell);
      $i=1;
      $d=$data[2];

      $bot=$data[$i];
      $botname=$botnames[$bot];
      $cnt=$data[$i+1];
                                 
      $ret="<img title=\"".$dialogs[$d]."\" ".($x==3 && $y==1?"onclick=\"speakmenu(event);\"":"")." width=\"".$imgdata[$x][$y]["wd"]."\" height=\"".$imgdata[$x][$y]["ht"]."\" src=\"/i/dungeon/npcs/$d.gif\" style=\"position:absolute;left:".$imgdata[$x][$y]["x"][1]."px;top:".$imgdata[$x][$y]["y"]."px;".($x==3 && $y==1?"cursor:pointer;":"").($x==3?"z-index:".(99-($y*5)).";":"")."\">";
      return $ret;
    }

    function drawuser($cell, $x, $y) {
      global $botnames, $imgdata, $party;
      $data=explode("/", $cell);
      $i=1;
      $bc=(count($data)-1);
      while ($data[$i]) {
        $u=$data[$i];
        if ($i==1) {
          if ($bc==1) $bn=1;
          else $bn=0;
        } elseif ($i==3) {
          if ($bc==2) $bn=2;
          else $bn=1;
        } else $bn=2;
        foreach ($party as $k=>$v) {
          if ($v["user"]==$u) {
            $udata=$v;
            break;
          }
        }
        $ret.="<img title=\"$udata[login]\" width=\"".$imgdata[$x][$y]["wd"]."\" height=\"".$imgdata[$x][$y]["ht"]."\" src=\"/i/shadow/".$udata["shadow"]."\" style=\"position:absolute;left:".$imgdata[$x][$y]["x"][$bn]."px;top:".$imgdata[$x][$y]["y"]."px;".($x==3?"z-index:".(99-($y*5)).";":"")."\">";
        $i++;
      }
      return $ret;
    }

    function drawobject($cell, $x, $y) {
      global $objects, $imgdata, $user, $objdata, $objsizes;
      $tmp=explode("/", $cell);
      if ($user["room"]==74 || $user["room"]==91) {
        $obj=$tmp[2];
      } else $obj=$tmp[1];
      $ht=round($imgdata[$x][$y]["ht"]/2);
      if (@$objsizes[$obj]) {
        $coef=$objdata[$x][$y]["coef"];
        //$is=getImageSize("i/dungeon/objects/$obj.gif");
        $wd=$objsizes[$obj][0]*$coef;
        $ht=$objsizes[$obj][1]*$coef;
        $left=round($objdata[$x][$y]["x"]-($wd/2));
        $top=$objdata[$x][$y]["y"]-$ht;
      } elseif ($obj==510) {
        $wd=round($imgdata[$x][$y]["wd"]*2.5);
        $ht=$imgdata[$x][$y]["ht"];
        $left=$imgdata[$x][$y]["x"][1]-round(($wd-$imgdata[$x][$y]["wd"])/2);
        $top=$imgdata[$x][$y]["y"];
      } elseif ($obj>600 && $obj<700) {
        $wd=round($imgdata[$x][$y]["wd"]*1.26);
        $left=$imgdata[$x][$y]["x"][1]-round(($wd-$imgdata[$x][$y]["wd"])/2);
        $top=$imgdata[$x][$y]["y"]+$ht;
      } elseif ($obj>=700 && $obj<800) {
        $wd=round($imgdata[$x][$y]["wd"]*1.24);
        $ht=$imgdata[$x][$y]["ht"];
        $left=$imgdata[$x][$y]["x"][1]-round(($wd-$imgdata[$x][$y]["wd"])/2);
        $top=$imgdata[$x][$y]["y"];
      } else {
        $wd=$imgdata[$x][$y]["wd"];
        $left=$imgdata[$x][$y]["x"][1];
        $top=$imgdata[$x][$y]["y"]+$ht;
      }
      $ret.="
      ".($y==1 && $x==3?"<a href=\"cave.php?useitem=1\">":"")." 
      <img border=\"0\" title=\"$objects[$obj]\" width=\"$wd\" height=\"$ht\" src=\"/i/dungeon/objects/$obj.gif?1\" style=\"position:absolute;left:{$left}px;top:{$top}px;".($x==3?"z-index:".(99-($y*5)).";":"")."\">
      ".($y==1 && $x==3?"</a>":"");
      return $ret;      
    }

    function drawevent($cell, $x, $y) {
      global $events, $eventdata;
      $tmp=explode("/", $cell);
      $obj=$tmp[1];
      if ($obj==1) return "";
      $wd=round($eventdata[$x][$y]["q"]*$events[$obj]["w"]);
      $ht=round($eventdata[$x][$y]["q"]*$events[$obj]["h"]);
      $left=round(-$events[$obj]["h"]/2+$eventdata[$x][$y]["x"]);
                                       
      $top=round($eventdata[$x][$y]["y"]-$events[$obj]["h"]);
      $ret.="
      <img border=\"0\" title=\"".$events[$obj]["name"]."\" width=\"$wd\" height=\"$ht\" src=\"/i/dungeon/events/$obj.gif\" style=\"position:absolute;left:{$left}px;top:{$top}px;".($x==3?"z-index:".(99-($y*5)).";":"")."\">";
      return $ret;
      
    }

    while ($i>=0) {
      if ($i==4) {
        if ($map[0][7]) $ret.="<div class=\"lw{$i}2\"></div>";
        if ($map[0][6]) $ret.="<div class=\"lsw{$i}2\"></div>";        
        if ($map[-1][6]) $ret.="<img width=\"37\" height=\"78\" src=\"/i/dungeon/mobs/".$map[-1][6].".gif\" style=\"position:absolute;left:-20px;top:60px\">";
      }
      $wall=$i*2-1;
      $sidewall=$i*2;
      if ($map[1][$sidewall] && $i>0) {
        $obj=substr($map[1][$sidewall],0,1);
        if ($obj=="b") {
          $ret.=drawbot($map[1][$sidewall],  1, $i);
          //if ($i==1) $ret.="<img width=\"86\" height=\"157\" src=\"/i/dungeon/mobs/".$map[1][$sidewall].".gif\" style=\"position:absolute;left:-5px;top:40px\">";
          //if ($i==2) $ret.="<img width=\"61\" height=\"112\" src=\"/i/dungeon/mobs/".$map[1][$sidewall].".gif\" style=\"position:absolute;left:35px;top:55px\">";
          //if ($i==3) $ret.="<img width=\"44\" height=\"94\" src=\"/i/dungeon/mobs/".$map[1][$sidewall].".gif\" style=\"position:absolute;left:55px;top:50px\">";
        } elseif ($obj=="u") {
          $ret.=drawuser($map[1][$sidewall],  1, $i, $players);
        } elseif ($obj=="o") {
          $ret.=drawobject($map[1][$sidewall],  1, $i);          
        } elseif ($obj=="e") {
          $ret.=drawevent($map[1][$sidewall],  1, $i);          
        } elseif ($obj=="d") {
          $ret.=drawdialog($map[1][$sidewall],  1, $i);          
        } elseif ($obj!="s") {
          $o=$map[1][$sidewall]-10000;
          if ($o==4) {
            if ($i==1) $ret.="<img width=\"106\" height=\"101\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:-42px;top:90px\">";
            if ($i==2) $ret.="<img width=\"86\" height=\"84\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:137px;top:90px\">";
            if ($i==3) $ret.="<img width=\"65\" height=\"63\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:152px;top:87px\">";
          } else {
            if ($i==1) $ret.="<img width=\"65\" height=\"80\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:0px;top:110px\">";
            if ($i==2) $ret.="<img width=\"43\" height=\"56\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:17px;top:90px\">";
            if ($i==3) $ret.="<img width=\"32\" height=\"40\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:17px;top:100px\">";
          }
        }
      }
      if ($map[5][$sidewall] && $i>0) {
        $obj=substr($map[5][$sidewall],0,1);
        if ($obj=="b") {
          $ret.=drawbot($map[5][$sidewall],  5, $i);
          //if ($i==1) $ret.="<img title=\"$botname\" width=\"86\" height=\"157\" src=\"/i/dungeon/mobs/$bot.gif\" style=\"position:absolute;left:260px;top:40px\">";
          //if ($i==2) $ret.="<img title=\"$botname\" width=\"61\" height=\"112\" src=\"/i/dungeon/mobs/$bot.gif\" style=\"position:absolute;left:270px;top:55px\">";
          //if ($i==3) $ret.="<img title=\"$botname\" width=\"44\" height=\"94\" src=\"/i/dungeon/mobs/$bot.gif\" style=\"position:absolute;left:250px;top:50px\">";
        } elseif ($obj=="u") {
          $ret.=drawuser($map[5][$sidewall],  5, $i, $players);
        } elseif ($obj=="o") {
          $ret.=drawobject($map[5][$sidewall],  5, $i);
        } elseif ($obj=="e") {
          $ret.=drawevent($map[5][$sidewall],  5, $i);
        } elseif ($obj=="d") {
          $ret.=drawdialog($map[5][$sidewall],  5, $i);
        } elseif ($obj!="s") {
          $o=$map[5][$sidewall]-10000;
          if ($o==4) {
            if ($i==1) $ret.="<img width=\"106\" height=\"101\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:302px;top:90px\">";
            if ($i==2) $ret.="<img width=\"86\" height=\"84\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:137px;top:90px\">";
            if ($i==3) $ret.="<img width=\"65\" height=\"63\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:152px;top:87px\">";
          } else {
            if ($i==1) $ret.="<img width=\"65\" height=\"80\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:320px;top:90px\">";
            if ($i==2) $ret.="<img width=\"43\" height=\"56\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:300px;top:100px\">";
            if ($i==3) $ret.="<img width=\"32\" height=\"40\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:317px;top:110px\">";
          }
        }
      }
      if ($i>0 && $map[1][$wall]) $ret.="<div class=\"lw$i\"></div>";
      if(!passablewall($map[2][$sidewall])) $ret.="<div class=\"lsw$i\"></div>";
      if(!passablewall($map[4][$sidewall])) $ret.="<div class=\"rsw$i\"></div>";
      if ($i>0 && $map[5][$wall]) $ret.="<div class=\"rw$i\"></div>";
      
      if ($map[3][$sidewall] && $i>0 && $sidewall<$centerwall) {
        $obj=substr($map[3][$sidewall],0,1);
        if ($obj=="b") {        
          $ret.=drawbot($map[3][$sidewall],  3, $i);
          //if ($i==1) $ret.="<img title=\"$botname\" onclick=\"attackmenu(event);\" width=\"120\" height=\"220\" src=\"/i/dungeon/mobs/$bot.gif\" style=\"position:absolute;left:127px;top:0px;cursor:pointer;z-index:99\">";
          //if ($i==2) $ret.="<img title=\"$botname\" width=\"80\" height=\"145\" src=\"/i/dungeon/mobs/$bot.gif\" style=\"position:absolute;left:147px;top:35px;z-index:95\">";
          //if ($i==3) $ret.="<img title=\"$botname\" width=\"60\" height=\"110\" src=\"/i/dungeon/mobs/$bot.gif\" style=\"position:absolute;left:157px;top:40px;z-index:90\">";
        } elseif ($obj=="u") {
          $ret.=drawuser($map[3][$sidewall],  3, $i, $players);
        } elseif ($obj=="o") {
          $ret.=drawobject($map[3][$sidewall],  3, $i);          
        } elseif ($obj=="e") {
          $ret.=drawevent($map[3][$sidewall],  3, $i);          
        } elseif ($obj=="d") {
          $ret.=drawdialog($map[3][$sidewall],  3, $i);          
        } elseif ($obj!="s") {
          $o=$map[3][$sidewall]-10000;
          if ($o==4) {
            if ($i==1) $ret.="<img width=\"130\" height=\"126\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:112px;top:80px\">";
            if ($i==2) $ret.="<img width=\"86\" height=\"84\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:137px;top:90px\">";
            if ($i==3) $ret.="<img width=\"65\" height=\"63\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:147px;top:87px\">";
          } else {
            if ($i==1) $ret.="<a style=\"position:absolute;left:157px;top:110px;z-index:100\" href=\"cave.php?useitem=1\"><img border=\"0\" width=\"65\" height=\"80\" src=\"/i/dungeon/objects/$o.gif\"></a>";
            if ($i==2) $ret.="<img width=\"43\" height=\"56\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:157px;top:105px\">";
            if ($i==3) $ret.="<img width=\"32\" height=\"40\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:157px;top:100px\">";
          }
        }
      }
      if ($map[3][$wall]) {
        if ($i>0) $ret.="<div class=\"cw$i\" ".($map[3][$wall]>2?"style=\"background-image:url('$base/cw$i".cavewall($map[3][$wall]).".gif')\"":"")."></div>";
        if ($i==1 && $map[3][$wall]>2) {
          if ($map[3][$wall]>1000) {
            $ret.="<a style=\"position:absolute;z-index:99;left:150px;top:35px\" href=\"cave.php?usewallitem=1\"><img border=\"0\" src=\"".IMGBASE."/i/empty.gif\" width=\"45\" height=\"100\"></a>";
          } elseif ($map[3][$wall]>100) {
            $ret.="<a style=\"position:absolute;z-index:99;left:150px;top:85px\" href=\"cave.php?usewallitem=1\"><img border=\"0\" src=\"".IMGBASE."/i/empty.gif\" width=\"100\" height=\"55\"></a>";
          } else $ret.="<a style=\"position:absolute;z-index:99;left:60px;top:113px\" href=\"cave.php?usewallitem=1\"><img border=\"0\" src=\"".IMGBASE."/i/empty.gif\" width=\"128\" height=\"55\"></a>";
        }
        //$nocenter=1;
      }
      if ($i==4) {
        //if ($map[6][7]) $ret.="<div class=\"rw{$i}2\"></div>";
        if ($map[7][6]) $ret.="<img width=\"37\" height=\"78\" src=\"/i/dungeon/mobs/".$map[7][6].".gif\" style=\"position:absolute;left:330px;top:60px\">";
      }
      $i--;
    }
    
    $ret.="</div>
    </td><td valign=\"top\">
    <div style=\"height:116px;position:relative\">
    <div style=\"padding-top:11px;padding-left:33px\">
    <DIV class=\"MoveLine\"><IMG src=\"http://www.virt-life.com/i/move/wait3.gif\" id=\"MoveLine\" class=\"MoveLine\"></DIV>
    <div style=\"visibility:hidden; height:0px\" id=\"moveto\">0</div>
    </div>";

    if ($direction==0) {
      $forwardlink="?move=x2";
      $backlink="?move=x1";
      $leftlink="?move=y1";
      $rightlink="?move=y2";
    }
    if ($direction==2) {
      $forwardlink="?move=x1";
      $backlink="?move=x2";
      $leftlink="?move=y2";
      $rightlink="?move=y1";
    }
    if ($direction==1) {
      $forwardlink="?move=y2";
      $backlink="?move=y1";
      $leftlink="?move=x2";
      $rightlink="?move=x1";
    }
    if ($direction==3) {
      $forwardlink="?move=y1";
      $backlink="?move=y2";
      $leftlink="?move=x1";
      $rightlink="?move=x2";
    }
    if (passablewall($map[3][1]) && canmoveto($map[3][2])) $ret.="<div style='position:absolute; left:65px; top:38px;'><a onClick=\"return check('m1');\" id=\"m1\" href=\"$forwardlink\"><img src=\"/i/dungeon/forward.gif\"  border=\"0\" /></a></div>";
    if (passablewall($map[3][-1]) && canmoveto($map[3][-2])) $ret.="<div style='position:absolute; left:65px; top:84px;'><a onClick=\"return check('m5');\" id=\"m5\" href=\"$backlink\"><img src=\"/i/dungeon/back.gif\" border=\"0\" /></a></div>";
    if (passablewall($map[2][0]) && canmoveto($map[1][0])) $ret.="<div style='position:absolute; left:17px; top:49px;'><a onClick=\"return check('m7');\" id=\"m7\" href=\"$leftlink\"><img src=\"/i/dungeon/left.gif\" border=\"0\" /></a></div>";
    if (passablewall($map[4][0]) && canmoveto($map[5][0])) $ret.="<div style='position:absolute; left:127px; top:48px;'><a onClick=\"return check('m3');\" id=\"m3\" href=\"$rightlink\"><img src=\"/i/dungeon/right.gif\" border=\"0\" /></a></div>";

    $ret.="<div style='position:absolute; left:37px; top:37px;'><a href=\"?direction=".($direction==0?3:$direction-1)."\" title=\"Поворот налево\"><img src=\"/i/dungeon/turnleft.gif\" width=\"22\" height=\"20\" border=\"0\" /></a></div>";

    $ret.="<div style='position:absolute; left:112px; top:37px;'><a href=\"?direction=".(($direction+1)%4)."\" title=\"Поворот направо\"><img src=\"/i/dungeon/turnright.gif\" width=\"21\" height=\"20\" border=\"0\" /></a></div>";

    $ret.="<div style='position:absolute; left:66px; top:62px;'><a href=\"$_SERVER[PHP_SELF]\"><img src=\"/i/dungeon/ref.gif\" border=\"0\"/></a></div>";
    $ret.="</div>
    <div style=\"margin-left:20px;position:relative\">";

    foreach ($players as $k=>$v) {
      if ($v["x"]-($startx/2)>=0 && $v["x"]-($startx/2)<=8 && $v["y"]-($starty/2)>=0 && $v["y"]-($starty/2)<=8) {
        $ret.="<img alt=\"$v[login]\" title=\"$v[login]\" style=\"position:absolute;left:".(($v["x"]-($startx/2))*15+3)."px;top:".(($v["y"]-($starty/2))*15+3)."px\" src=\"/i/dungeon/".($k+1)."$v[dir].gif\">";
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
          if (!passablewall($map1[$i][$i2-1])) $ret.="0"; else $ret.="1";
          if (!passablewall($map1[$i-1][$i2])) $ret.="0"; else $ret.="1";
          if (!passablewall($map1[$i][$i2+1])) $ret.="0"; else $ret.="1";
          if (!passablewall($map1[$i+1][$i2])) $ret.="0"; else $ret.="1";
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

    //$ret.="<font style='font-size:14px; color:#8f0000'><b>".$mir['name']."</b></font>&nbsp;&nbsp;&nbsp;&nbsp;<a style=\"cursor:pointer;\" onclick=\"if (confirm('Вы уверены что хотите выйти?')) window.location='canalizaciya.php?act=cexit'\">&nbsp;<b style='font-size:14px; color:#000066;'>Выйти</b></a>";
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
<br><center><table width="400" border="0" cellspacing="1" cellpadding="0" bgcolor="#000000">
<?
  foreach ($party as $k=>$v) {
    if ($v["user"]==$user["id"]) {
      $usr=$user;
    } else {
      $usr=mqfa("select level, hp, maxhp from users where id='$v[user]'");
    }
    $wd=floor($usr["hp"]/$usr["maxhp"]*120);
    echo "<tr>
<td background=\"/img/bg_scroll_05.gif\" align=\"center\">
<a href=\"inf.php?$v[user]\" target=_blank title=\"Информация о $v[login]\">$v[login]</a> [$usr[level]]<a href='inf.php?$v[user]' target='_blank'><img src='/i/inf.gif' border=0></a></td>
<td background=\"/img/bg_scroll_05.gif\" nowrap style=\"font-size:9px\">
<div style=\"position: relative;padding-left:5px\">
<table cellspacing=\"0\" cellpadding=\"0\" style='line-height: 1'><td nowrap style=\"font-size:9px\" style=\"position: relative\"><SPAN ".($k==$user["id"]?"id=\"HP\"":"")." style='position: absolute; left: 5; z-index: 1; font-weight: bold; color: #FFFFFF'>$usr[hp]/$usr[maxhp]</SPAN><img src=\"/i/1green.gif\" alt=\"Уровень жизни\" name=\"HP1\" width=\"$wd\" height=\"9\" id=\"HP1\"><img src=\"/i/misc/bk_life_loose.gif\" alt=\"Уровень жизни\" name=\"HP2\" width=\"".(120-$wd)."\" height=\"9\" id=\"HP2\"></td></table></div></td>
<td background=\"/img/bg_scroll_05.gif\" align=\"center\"></td>
<td background=\"/img/bg_scroll_05.gif\" align=\"center\">";
if ($v["user"]==$user["id"] && $user["id"]==$user["caveleader"]) echo "<IMG alt=\"Лидер группы\" src=\"/i/misc/lead1.gif\" width=24 height=15><A href=\"#\" onClick=\"findlogin( 'Выберите персонажа которого хотите выгнать','cave.php', 'kill')\"><IMG alt=\"Выгнать супостата\" src=\"/img/podzem/ico_kill_member1.gif\" WIDTH=\"14\" HEIGHT=\"17\"></A>&nbsp;<A href=\"#\" onClick=\"findlogin( 'Выберите персонажа которому хотите передать лидерство','cave.php', 'change')\"><IMG alt=\"Новый царь\" src=\"/img/podzem/ico_change_leader1.gif\" WIDTH=\"14\" HEIGHT=\"17\"></A>";
echo "</td>
</tr>";
  }
?>
</table><br>
<div style="padding-left:15px;padding-right:15px">
<b><font color=red><?=@$report?>&nbsp;</font></b></div>
</center><br>
<br><br />
<center>
<?
  $r=mq("select * from caveitems where leader='$user[caveleader]' and x='".($x*2)."' and y='".($y*2)."' and floor='$floor'");
  if (mysql_num_rows($r)>0) echo "<font color=red>В комнате разбросаны вещи:</font><div style=\"font-size:3px\">&nbsp;</div>";
  while ($rec=mysql_fetch_assoc($r)) {
    echo "<a title=\"Поднять $rec[name]\" href=\"cave.php?takeitem=$rec[id]\"><img src=\"".IMGBASE."/i/sh/$rec[img]\"></a> ";
  }
?></center><br>
<?
  if ($loses>=3) echo "<center><b><font color=red>Вас убили 3 раза, и вы покидете подземелье</font></b><br><br>
  <a href=\"cave.php?exit=1\">Вернуться</a></center><br>";
  if ($loses) echo "<div style=\"padding-left:20px\"><b>Количество смертей: $loses</b></div>";
?>
    </td>
    <td width=540>
<div style="text-align:right;padding-right:30px">
<font style='font-size:14px; color:#8f0000'><b><?
  $tmp=explode("/", $standingon);
  if (@$roomnames[$tmp[1]]) echo $roomnames[$tmp[1]];
  else echo $rooms[$user["room"]];
?></b></font>&nbsp;&nbsp;&nbsp;&nbsp;
<font style='font-size:14px; color:#8f0000'><b></b></font>&nbsp;&nbsp;&nbsp;&nbsp;<a style="cursor:pointer;" onclick="if (confirm('Вы уверены что хотите выйти?')) window.location='cave.php?exit=1'">&nbsp;<b style='font-size:14px; color:#000066;'>Выйти</b></a>
</div>
<?
  echo drawmap($map, $party, $x, $y, $dir);
?>
</td></tr></table>
<? if ($user["id"]==7)  echo "$x:$y";
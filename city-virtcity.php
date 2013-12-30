<php
include "connect.php";
include "functions.php";
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="<?=IMGBASE?>/i/main.css">
<link href="<?=IMGBASE?>/i/move/design6.css" rel="stylesheet" type="text/css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<META HTTP-EQUIV="imagetoolbar" CONTENT="no">

<style type="text/css">
#ID_ANIMATE {position:relative;width:520px;height:246px;overflow:hidden}
#ID_ANIMATE DIV{position:absolute;width:1px;height:1px;font-size:0px;z-index:1}
img.aFilter { filter:Glow(color=<? if (WINTER) echo "f1c301"; else echo "d7d7d7";?>,Strength=4,Enabled=0); cursor:hand }
hr { height: 1px; }
</style>

<SCRIPT LANGUAGE="JavaScript">
var Hint3Name='';
function findlogin(title, script, name){
    document.getElementById("hint3").innerHTML = '<form action="'+script+'" method=POST><table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><INPUT TYPE=hidden name=sd4 value="6"><td colspan=2>'+
    'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD width=50% align=right><INPUT TYPE=text id="'+name+'" id="'+name+'" NAME="'+name+'"></TD><TD width=50%><INPUT TYPE="submit" value=" >> "></TD></TR></TABLE></td></tr></table></FORM>';
    document.getElementById("hint3").style.visibility = "visible";
    document.getElementById("hint3").style.left = 200;
    document.getElementById("hint3").style.top = 100;
    Hint3Name = name;
    document.getElementById(name).focus();
}

function closehint3(){
    document.all("hint3").style.visibility="hidden";
    Hint3Name='';
}

var solo_store;
function solo(n, name, instant) {
if (instant!="" || check_access()==true) {
window.location.href = '?got=1&level'+n+'=1&rnd='+Math.random();
} else if (name && n) {
solo_store = n;
var add_text = (document.getElementById('add_text') || document.createElement('div'));
add_text.id = 'add_text';
add_text.innerHTML = 'Вы перейдете в: <strong>' + name +'</strong> (<a href="#" onclick="return clear_solo();">отмена</a>)';
document.getElementById('ione').parentNode.parentNode.nextSibling.firstChild.appendChild(add_text);
//ch_counter_color('red');
}
return false;
}
function clear_solo () {
document.getElementById('add_text').removeNode(true);
solo_store = false;
ch_counter_color('#00CC00');
return false;
}
var from_map = false;

function imover(im) {
if( im.filters ) im.filters.Glow.Enabled=true;
else im.style.MozOpacity=0.7;
if ( from_map == false && im.id.match(/mo_(\d)/) && document.getElementById('b' + im.id)) {
from_map = true;
if( document.getElementById('b' + im.id).runtimeStyle )
document.getElementById('b' + im.id).runtimeStyle.color = '#666666';
from_map = false;
}
}
function imout(im) {
if( im.filters ) im.filters.Glow.Enabled=false;
else im.style.MozOpacity=1;
if ( from_map == false && im.id.match(/mo_(\d)/) && document.getElementById('b' + im.id)) {
from_map = true;
if( document.getElementById('b' + im.id).runtimeStyle )
document.getElementById('b' + im.id).runtimeStyle.color = document.getElementById('b' + im.id).style.color;
from_map = false;
}
}

function imover1(im) {
if( im.filters )
im.filters.Glow.Enabled=true;
if ( from_map == false && im.id.match(/mo_(\d)/) && document.getElementById('b' + im.id)) {
from_map = true;
if( document.getElementById('b' + im.id).runtimeStyle )
document.getElementById('b' + im.id).runtimeStyle.color = '#666666';
from_map = false;
}
}


function bimover (im) {
if ( from_map==false && document.getElementById(im.id.substr(1)) ) {
from_map = true;
imover(document.getElementById(im.id.substr(1)));
from_map = false;
}
}
function bimout (im) {
if ( from_map==false && document.getElementById(im.id.substr(1)) ) {
from_map = true;
imout(document.getElementById(im.id.substr(1)));
from_map = false;
}
}
function bsolo (im) {
if (document.getElementById(im.id.substr(1))) {
document.getElementById(im.id.substr(1)).click();
}
return false;
}


function fullfastshow(a,b,c,d,e,f){if(typeof b=="string")b=a.getElementById(b);var g=c.srcElement?c.srcElement:c,h=g;c=g.offsetLeft;for(var j=g.offsetTop;h.offsetParent&&h.offsetParent!=a.body;){h=h.offsetParent;c+=h.offsetLeft;j+=h.offsetTop;if(h.scrollTop)j-=h.scrollTop;if(h.scrollLeft)c-=h.scrollLeft}if(d!=""&&b.style.visibility!="visible"){b.innerHTML="<small>"+d+"</small>";if(e){b.style.width=e;b.whiteSpace=""}else{b.whiteSpace="nowrap";b.style.width="auto"}if(f)b.style.height=f}d=c+g.offsetWidth+10;e=j+5;if(d+b.offsetWidth+3>a.body.clientWidth+a.body.scrollLeft){d=c-b.offsetWidth-5;if(d<0)d=0}if(e+b.offsetHeight+3>a.body.clientHeight+a.body.scrollTop){e=a.body.clientHeight+ +a.body.scrollTop-b.offsetHeight-3;if(e<0)e=0}b.style.left=d+"px";b.style.top=e+"px";if(b.style.visibility!="visible")b.style.visibility="visible"}function fullhideshow(a){if(typeof a=="string")a=document.getElementById(a);a.style.visibility="hidden";a.style.left=a.style.top="-9999px"}

function gfastshow(dsc, dx, dy) { fullfastshow(document, mmoves3, window.event, dsc, dx, dy); }
function ghideshow() { fullhideshow(mmoves3); }

function Down() {top.CtrlPress = window.event.ctrlKey}

    document.onmousedown = Down;
</SCRIPT>
</HEAD>
<body style="margin-top:0px;padding-top:0px" leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor="#d7d7d7" onLoad="<?=topsethp()?>">
<div id="mmoves3" style="background-color:#FFFFCC; visibility:hidden; z-index: 101; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px;"></div>
<?
if($_GET['nap']=="attack" && $user['room']==20){include "magic/cityattack.php";}
?>

<div id=hint3 class=ahint></div>
<?
  errorreport();
?>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<TR>
    <TD valign=top align=left width=250>
<?
  include_once("questfuncs.php");
  if (0) {
    if (@$_GET["attackevil"]) {
      battlewithbot(1796, "Горный демон", "Защита города", "20", 1);
    }
    smallshowpersout($_SESSION['uid']);
    echo "</td><td width=\"230\" valign=\"top\"><img src=\"".IMGBASE."i/empty.gif\" width=\"230\" height=\"1\">
    Настало время нанести ответный удар по демонам! Сколько ещё будем терпеть их нападения?!
    Надо всем вместе напасть на их лагерь и убить всех до единого!<br><br>
    <a href=\"main.php?got=1&room=44\">Смело мы в бой пойдём!</a>
    </td>";
  } elseif ($user["room"]==45 && $_GET["findgrass"]) {
    smallshowpersout($_SESSION['uid']);
    echo "</td><td width=\"230\" valign=\"top\"><br />
    <img src=\"".IMGBASE."/i/empty.gif\" width=\"230\" height=\"1\">";
    echo "<div style=\"padding:10px\">".cutgrass(2)."</div>";
  } elseif ($user["room"]==45 && $_GET["findgrass2"]) {
    include "functions/cutgrass2.php";
    smallshowpersout($_SESSION['uid']);
    echo "</td><td width=\"230\" valign=\"top\"><br />
    <img src=\"".IMGBASE."/i/empty.gif\" width=\"230\" height=\"1\">";
    echo "<div style=\"padding:10px\">".cutgrass2(2)."</div>";
  } elseif ($user["room"]==45 && $_GET["hunt"] && WINTER && 0) {
    smallshowpersout($_SESSION['uid']);
    if (canmakequest(10)) {
      battlewithbot(4793, "Серый Волк", "Охота", 10, 0, 1, 0,0);
    } else {
      echo "<div style=\"padding:10px\">
      Вы ещё недостаточно отдохнули после предыдущей охоты.
      Отдохните ещё минимум ".ceil($questtime/60)." мин.
      </div>";
    }
  } elseif ($user['room'] == 20 && canmakequest(1) && $user["id"]!=4849) {
    smallshowpersout($_SESSION['uid']);
    if (@$_GET["openchest"]) {
      if (!placeinbackpack(1)) {
        echo "<center><b><font color=red>У вас недостаточно места в рюкзаке.</font></b></center>";
      } else {
        $rnd=rand(0,1);
        if (LETTERQUEST) {
          $taken=takesmallitem(60);
        } else {
          if ($rnd==1) {
            $rnd=rand(2,6);
            $taken=takeitem($rnd);
          } else {
            $rnd=rand(1,8);
            $taken=takesmallitem($rnd);
          }
        }
        makequest(1);
        $rand=rand(1,3);
        echo "</td><td width=\"230\" valign=\"top\"><br />
        <img src=\"".IMGBASE."/i/empty.gif\" width=\"230\" height=\"1\">";
        echo "<div style=\"padding:10px\">В сундучке вы обнаружили $taken[name] и ".($rand*0.5)." кр.<br><br>
        <center><img src=\"".IMGBASE."/i/sh/$taken[img]\"></center><br>
        Приходите через 24 часа за новым подарком.
        </div>";
        mq("update users set money=money+".($rand*0.5)." where id='$_SESSION[uid]'");
      }
    } else {
      echo "<div style=\"padding:10px\">Посередине площади расположен сундук мироздателя, в котором раз в день можно получить небольшой подарочек.</div>
      <center><a href=\"$_SERVER[PHP_SELF]?openchest=1\"><img border=\"0\" src=\"".IMGBASE."/img/podzem/2.gif\"></a></center>";
    }
    echo "</td>";
  } else echo showpersout($_SESSION['uid']);
  ?>
    </TD>

    <TD valign=top align=right>





<table  border="0" cellpadding="0" cellspacing="0">
<tr align="right" valign="top">
<td>







<TABLE width=100% height=100% border=0 cellspacing="0" cellpadding="0">
    <TR><TD align=right colspan=2>
            <div align=right id=per></div>

        <?

if ($user['room']==20) {
    if((int)date("H") > 5 && (int)date("H") < 22) {
        if (WINTER) $fon = WINTER.'1_bgc';
        else  $fon = WINTER.'1_bg';
        $z_bk = WINTER.'1_Arena';
        $z_shop = WINTER.'1_Market';
        $z_comm = WINTER.'2_Gift';
        $z_mas = WINTER.'1_Smith';
        $z_pochta = WINTER.'2_Tavern';
        $z_berezka = WINTER.'1_Store';
//      $z_podzem = 'tree';
        $z_bank = WINTER.'1_Bank';
        $z_zoo = WINTER.'1_Steads';
        $z_ctree=WINTER."ctreen";
    } else {
        if (WINTER) $fon = WINTER.'1_bgcn';
        else  $fon = WINTER.'1_bgn';
        $z_bk = WINTER.'1_Arenan';
        $z_shop = WINTER.'1_Marketn';
        $z_comm = WINTER.'2_Giftn';
        $z_mas = WINTER.'1_Smithn';
        $z_pochta = WINTER.'2_Tavernn';
        $z_berezka = WINTER.'1_Storen';
//      $z_podzem = 'tree';
        $z_bank = WINTER.'1_Bankn';
        $z_zoo = WINTER.'1_Steadsn';
        $z_ctree=WINTER."ctree";
    }
    echo "<table width=1><tr><td><div style=\"position:relative\" id=\"ione\"><img src=\"".IMGBASE."/i/city/",$fon,".jpg\" alt=\"\" border=\"0\"/>";
    buildset(1,"$z_bk",25,14,"Бойцовский клуб");
    buildset(2,"$z_shop",203,39,"Магазин");
    buildset(3,"$z_comm",20,432,"Первый комиссионный магазин");
    buildset(4,"$z_mas",209,251,"Ремонтная мастерская");
    buildset(6,"$z_pochta",164,138,"Почта");
//  buildset(5,"2pm",160,165,"Памятник");
    buildset(11,"$z_zoo",240,421,"Зоомагазин");
    buildset(21,"1_Right",230,523,"Страшилкина улица");
    buildset(49,"1_Left",195,7,"Новая земля");
    buildset(12,"$z_bank",85,310,"Банк");
    buildset(10,"$z_berezka",140,455,"Магазин Березка");
    //if (WINTER) buildset(9,"$z_ctree",195,85,"Новогодняя елка");
  $hinttop=18;
  $hintright=113;
  if (WINTER) echo "<div id=\"snow\"></div><script src=\"i/js/snow.js\"></script>";
} elseif ($user['room']==21) {
    if((int)date("H") > 5 && (int)date("H") < 22) {
        $fon = WINTER.'2_bg';
                $z_podz=WINTER.'3_Mine';
                $z_1ureg=WINTER.'2_LV';
                $z_1ubkill=WINTER.'2_Mage';
                $z_fshop=WINTER.'2_Gift';
                $z_zamok2= WINTER.'2_Tavern';
                $z_loto= WINTER.'2_Loto';
    } else {
        $fon = WINTER.'2_bgn';
                $z_podz=WINTER.'3_Minen';
                $z_1ureg=WINTER.'2_LVn';
                $z_1ubkill=WINTER.'2_Magen';
                $z_fshop=WINTER.'2_Giftn';
                $z_zamok2= WINTER.'2_Tavernn';
                $z_loto= WINTER.'2_Loton';
    }
    echo "<table width=1><tr><td><div style=\"position:relative\" id=\"ione\"><img src=\"".IMGBASE."/i/city/",$fon,".jpg\" alt=\"\" border=\"0\"/>";
    buildset(5,"$z_podz",90,365,"Вход в водосток");
    buildset(2,"$z_1ureg",29,37,"Регистратура кланов");
//  buildset(10,"euroshop",150,85,"Сувенирный магазинчик");
    //if ($user['align'] == 4) { 
        //buildset(7,"$z_1ubkill",20,283,"Башня смерти", '', 'Хаосникам вход в БС запрещен!');
    //} else {
        buildset(7,"$z_1ubkill",20,283,"Башня смерти");
    //}
//  buildset(3,"2stop",150,428,"Проход закрыт");
    buildset(6,"$z_fshop",175,248,"Цветочный магазин");
    //buildset(20,"2_Right",265,500,"К лагерю цвергов", "dialog.php?char=6");
    buildset(70,"2_Right",265,500,"Подгорье");
    buildset(20,"2_Left",230,6,"Центральная площадь");

    buildset(1,"$z_zamok2",197,30,"Магазин Благородства");
    buildset(11,"$z_loto",199,349,"Аукционный дом");

  $hinttop=18;
  $hintright=113;
  if (WINTER) echo "<div id=\"snow\"></div><script src=\"i/js/snow.js\"></script>";
} elseif ($user["room"]==45) {
  if((int)date("H") > 5 && (int)date("H") < 22) {
    $fon = WINTER.'field';
  } else {
    $fon = WINTER.'fieldn';
  }
  echo "<table width=1><tr><td><div style=\"position:relative\" id=\"ione\"><img src=\"".IMGBASE."/i/city/",$fon,".jpg\" alt=\"\" border=\"0\"/>";
if ($user['id'] == 7 || $user['id'] == 50 || $user['id'] == 2735) {  buildset(457,"trjasina",164,72,"Вход в Трясину"); } else { buildset(2005,"trjasina",164,72,"Вход в Трясину", "", "В разработке"); }
  if (WINTER) buildset(53,"teleport",98,100,"Портал");
  else buildset(53,"teleport",98,105,"Портал");
  if (WINTER) buildset(51,"cave",80,316,"");
  else buildset(51,"cave",80,285,"");
  //if (WINTER) buildset(47,"2_Left",175,24,"Ледяная пещера");
  buildset(54,"2_Left",195,24,"Пещера Алхимика");
  buildset(49,"2_Right",200,446,$rooms[49]);
  buildset(2005,"vokzal",86,165,"Вокзал");
  $hinttop=250;
  $hintright=53;
  if (WINTER) echo "<div id=\"snow\"></div><script src=\"i/js/snow.js\"></script>";
  } elseif ($user["room"]==62) {
  if((int)date("H") > 5 && (int)date("H") < 22) {
    $fon = WINTER.'field';
  } else {
    $fon = WINTER.'fieldn';
  }
  echo "<table width=1><tr><td><div style=\"position:relative\" id=\"ione\"><img src=\"".IMGBASE."/i/city/",$fon,".jpg\" alt=\"\" border=\"0\"/>";
if ($user['id'] == 7 || $user['id'] == 50 || $user['id'] == 2735) {  buildset(457,"trjasina",164,72,"Вход в Трясину"); } else { buildset(2005,"trjasina",164,72,"Вход в Трясину", "", "В разработке"); }
  if (WINTER) buildset(53,"teleport",98,100,"Портал");
  else buildset(53,"teleport",98,105,"Портал");
  if (WINTER) buildset(51,"cave",80,316,"");
  else buildset(51,"cave",80,285,"");
  //if (WINTER) buildset(47,"2_Left",175,24,"Ледяная пещера");
  buildset(54,"2_Left",195,24,"Пещера Алхимика");
  buildset(49,"2_Right",200,446,$rooms[49]);
  buildset(2005,"vokzal",86,165,"Вокзал");
  $hinttop=250;
  $hintright=53;
  if (WINTER) echo "<div id=\"snow\"></div><script src=\"i/js/snow.js\"></script>";

} elseif ($user['room']==456) {
	if((int)date("H") > 5 && (int)date("H") < 22) {
		$fon = 'vok_14_main';
		$z_bk = '2klub';
		$z_shop = '2shop';
		$z_comm = '2comission';
		$z_mas = '2remont';
		$z_pochta = '2pochta';
		$z_vokzal = '2vokzal';
//		$z_podzem = 'tree';
		$z_hram = '2cerkov';
		$z_optovii = 'opt';
		$z_loto = 'loto';
		$z_stella = 'stella';
		
	} else {
		$fon = 'vok_14_main';
		$z_bk = '2klub';
		$z_shop = '2shop';
		$z_comm = '2comission';
		$z_mas = '2remont';
		$z_pochta = '2pochta';
		$z_vokzal = '2vokzal';
//		$z_podzem = 'tree';
		$z_hram = '2cerkov';
		$z_optovii = 'opt';
		$z_loto = 'loto';
		$z_stella = 'stella';
		
	}
	echo "<table width=1><tr><td><div style=\"position:relative; cursor: pointer;\" id=\"ione\"><img src=\"http://test.virt-life.com/imgg/i/city/",$fon,".jpg\" alt=\"\" border=\"0\"/>";
	
	
	//buildset(66,655,"vv_14",60,180,"Лиголи");
	//buildset(77,20,"vok_exit",170,446,"Центральна площадь");
	buildset(2005,"vok_teleport",170,400,"Касса");	
} elseif ($user['room']==49) {
  //if ($user['id'] == 7) {
    if (isset($_SESSION['pole_kopka_access'])) {
      if ($_SESSION['pole_kopka_access']) { // только вышел, записываем время
        mysql_query("UPDATE users SET pole_kopka_last_visit = " . time() . " WHERE id = " . $user['id']);
      } else { // если задержка
        $time_left = round((3600 - (time() - $user['pole_kopka_last_visit'])) / 60);
        echo "<div align=right><font color=red><b>Вы копали, Вы устали=) Вам стоит придти сюда через " . $time_left . " минут.</b></font></div>"; 
      }
      unset($_SESSION['pole_kopka_access']);
    }
  //}
  $fon = WINTER.'4_bg';
  $locs[]=array("name"=>"Общежитие", "img"=>WINTER."4_trade","x"=>220, "y"=>135, "room"=>105);
 if ($user['level'] < 4) { $locs[]=array("name"=>"Поле Кладоискателей", "img"=>WINTER."4_pklad","x"=>239, "y"=>257, "room"=>"58", "msg"=>"Вход на Поле Кладоискателей с 4 уровня !"); } else { $locs[]=array("name"=>"Поле Кладоискателей", "img"=>WINTER."4_pklad","x"=>239, "y"=>257, "room"=>58); }
  $locs[]=array("name"=>$rooms[59], "img"=>WINTER."4_bkm","x"=>60, "y"=>190, "room"=>59);
  $locs[]=array("name"=>"Поле битвы Света и Тьмы", "img"=>WINTER."4_bottom","x"=>145, "y"=>234, "room"=>62);
  //$locs[]=array("name"=>"К пещере загадок", "img"=>WINTER."4_bottom","x"=>225, "y"=>234, "room"=>64);
  $locs[]=array("name"=>$rooms[50], "img"=>WINTER."4_castle","x"=>60, "y"=>35, "room"=>700);
  $locs[]=array("name"=>"$rooms[61]", "img"=>WINTER."4_church","x"=>357, "y"=>3, "room"=>60);
  $locs[]=array("name"=>$rooms[56], "img"=>WINTER."4_shop","x"=>290, "y"=>133, "room"=>56);

  if (WINTER) $locs[]=array("name"=>"Чистое поле", "img"=>"2_Left","x"=>24, "y"=>175, "room"=>45);
  else $locs[]=array("name"=>"Чистое поле", "img"=>"2_Left","x"=>24, "y"=>205, "room"=>45);

  if (WINTER) $locs[]=array("name"=>"Центральная площадь", "img"=>"2_Right","x"=>505, "y"=>180, "room"=>20);
  else $locs[]=array("name"=>"Центральная площадь", "img"=>"2_Right","x"=>491, "y"=>214, "room"=>20);

  //$locs[]=array("name"=>"", "img"=>"stop1","x"=>300, "y"=>179, "room"=>0);
  //$locs[]=array("name"=>"", "img"=>"stop1","x"=>185, "y"=>235, "room"=>0);
  //$locs[]=array("name"=>"", "img"=>"stop3","x"=>397, "y"=>140, "room"=>0);
  
  if((int)date("H") > 5 && (int)date("H") < 22) {
  } else {
    $fon.="n";
    foreach ($locs as $k=>$v) $locs[$k]["img"].="n";
  }
  echo "<table width=1><tr><td><div style=\"position:relative\" id=\"ione\"><img src=\"".IMGBASE."/i/city/",$fon,".jpg\" alt=\"\" border=\"0\"/>";
  foreach ($locs as $k=>$v) {
    buildset($v["room"],$v["img"],$v["y"],$v["x"],$v["name"], @$v["link"], @$v["msg"]);
  }

  $hinttop=18;
  $hintright=113;
  if (WINTER) echo "<div id=\"snow\"></div><script src=\"i/js/snow.js\"></script>";
} elseif ($user["room"]==54) {
  function checkalchlevel() {
    global $user;
    $cnt=mqfa1("select sum(koll) from inventory where name='Страница книги алхимии' and owner='$user[id]' and setsale=0");
    if ($user["alchemy"]>=50 && $user["alchemylevel"]==0) adduserdata("alchemylevel", 1);
    elseif ($user["alchemy"]>=100 && $user["alchemylevel"]==1 && $cnt>=50) {
      takesmallitems("Страница книги алхимии", 50, $user["id"]);
      adduserdata("alchemylevel", 1);
    } elseif ($user["alchemy"]>=200 && $user["alchemylevel"]==2 && $cnt>=100) {
      takesmallitems("Страница книги алхимии", 100, $user["id"]);
      adduserdata("alchemylevel", 1);
    } elseif ($user["alchemy"]>=400 && $user["alchemylevel"]==3 && $cnt>=200) {
      takesmallitems("Страница книги алхимии", 200, $user["id"]);
      adduserdata("alchemylevel", 1);
    } elseif ($user["alchemy"]>=600 && $user["alchemylevel"]==4 && $cnt>=300) {
      takesmallitems("Страница книги алхимии", 300, $user["id"]);
      adduserdata("alchemylevel", 1);
    } elseif ($user["alchemy"]>=1000 && $user["alchemylevel"]==5 && $cnt>=400) {
      takesmallitems("Страница книги алхимии", 400, $user["id"]);
      adduserdata("alchemylevel", 1);
    } elseif ($user["alchemy"]>=1500 && $user["alchemylevel"]==6 && $cnt>=500) {
      takesmallitems("Страница книги алхимии", 500, $user["id"]);
      adduserdata("alchemylevel", 1);
    } elseif ($user["alchemy"]>=2000 && $user["alchemylevel"]==7 && $cnt>=600) {
      takesmallitems("Страница книги алхимии", 600, $user["id"]);
      adduserdata("alchemylevel", 1);
    } elseif ($user["alchemy"]>=3000 && $user["alchemylevel"]==8 && $cnt>=700) {
      takesmallitems("Страница книги алхимии", 700, $user["id"]);
      adduserdata("alchemylevel", 1);
    } elseif ($user["alchemy"]>=5000 && $user["alchemylevel"]==9 && $cnt>=1000) {
      takesmallitems("Страница книги алхимии", 1000, $user["id"]);
      adduserdata("alchemylevel", 1);
    }
  }
  if (@$_GET["alh"]) {
    $tigel=mqfa("select id, prototype from inventory where (prototype=1901 or prototype=2313 or prototype=2314) and owner='$user[id]' and duration<maxdur order by prototype desc");
    if (!$tigel) {
      echo "<font color=red><b>Для приготовления зелий вам необходим тигель.</b></font><br>";
      $_GET["alh"]=0;
    }
    $i=mqfa1("select id from inventory where name='Бутылка' and owner='$user[id]'");
    if (!$i) {
      echo "<font color=red><b>Для приготовления зелий вам необходима бутылка.</b></font><br>";
      $_GET["alh"]=0;
    }
    if (!canmakequest(16)) {
      echo "<font color=red><b>Вам необходим отдых после последней работы.</b></font><br>";
      $_GET["alh"]=0;
    }
    if ($tigel["prototype"]==1901) $failchance=30;
    elseif ($tigel["prototype"]==2313) $failchance=25;
    elseif ($tigel["prototype"]==2314) $failchance=20;
  }
  if (@$_GET["book"]==1) {
    echo "<div style=\"width:650px;text-align:justify\"><br><center><b>Книга начинающего алхимика.</b></center><br>
    <div style=\"padding-right:10px\">
    &nbsp;&nbsp;&nbsp;Искусство алхимии - это искусство варить зелья, дающие воинам разные дополнительные способности в боях. Для приготовления зелий
    необходимы различные травы.<br>
    &nbsp;&nbsp;&nbsp;Варить зелья надо осторожно, попытка создать слишком сложный эликсир или из неправильных компонентов может привести к печальным последствиям.
    Впрочем, бывали случаи, что даже слабые алхимики варили довольно сложные зелья, но ещё больше случаев, когда всё заканчивалось печально.<br>
    &nbsp;&nbsp;&nbsp;Нередко зелье не удаётся создать даже тогда, когда количество трав не превышает способности алхимика, но зелье по крайней мере не взрывается.
    Любой начинающий алхимик может без труда использовать три основные алхимические травы - корень нирина, листья примулы и цветок алканы,
    и может создавать эликсиры, в которые входит не более трёх трав. Корень нирина и листья примулы используются, чтобы ускорить движения
    воинов в боях. У каждой травы своя уникальная сущность, поэтому зелья, в которых исползуюся разные травы, нестабильные.
    Чтобы погасить этот эффект, необходимо использовать цветок алканы, который сам по себе никакого эффекта зелью не даёт, но
    неитрализует отрицательное взаимодействие трав.</div>
    <center>
      <a href=\"city.php\">Закрыть книгу</a>
    </center><br>
    </div>";
  } elseif (@$_GET["book"]==2) {
    echo "<div style=\"width:650px;text-align:justify\"><br><center><b>Основы алхимии.</b></center><br>
Искусство алхимии сложный труд. Лишь избранные достигают вершин. Знания великих алхимиков сохранены в томах рецептов. Только достойному грандмастер гильдии алхимиков покажет древние секреты и разрешит переписать их в свою книгу. Чем выше ваши заслуги перед гильдией, тем больше секретов раскроет вам старый мастер. <br>
Каждая новая ступень алхимии раскроет вам секреты новых трав, что позволит вам создавать все более и более могущественные эликсиры. С каждым новым уровнем вы сможете создавать не только более мощные эликсиры, но и постигните секреты новых эликсиров, обладающих новыми свойствами. Но помните, что более мощные эликсиры они и более сложные и на создание нового эликсира вам потребуется больше ингредиентов.<br>
Все алхимики распределены на 10 ступеней. Каждый алхимик имеет знак отличия, по которому его заслуги перед гильдией понятны другим. Ступени эти таковы:<br>
<br>
1. ставший на путь алхимии<br>
2. ученик алхимика<br>
3. старший ученик алхимика<br>
4. подмастерье алхимика<br>
5. познавший тайну алхимии<br>
6. младший алхимик<br>
7. алхимик<br>
8. опытный алхимик<br>
9. мастер алхимии<br>
10. грандмастер алхимии<br>
<br>
Для получения звания \"ставший на путь алхимии\" необходимо заработать 50 очков умения алхимии. Ставшие на путь алхимии могут использовать в своих эликсирах до 6 трав и так же помимо основных компонентов они могут использовать стебель аралии, который позволяет воинам предугадать и избежать наиболее опасных атак противника.<br>
Последующие звания получат только те, кто собрал книгу алхимии и чем опытнее алхимик, тем толще том. Том же вы можете получить у мастера алхимика, а вот страницы каждому придется собирать самому. Страницы в томе не простые, а магические. Добыть их можно в пещере.
    <center><br>
      <a href=\"city.php\">Закрыть книгу</a>
    </center><br>
</div>";
  } elseif (@$_GET["alh"]) {
    function alchval($n) {
      if ($n==1) return $n;
      elseif ($n<=3) return 2;
      elseif ($n<=5) return 3;
      elseif ($n<=8) return 4;
      elseif ($n<=11) return 5;
      elseif ($n<=14) return 6;
      elseif ($n<=18) return 7;
      elseif ($n<=23) return 8;
      elseif ($n<=29) return 9;
      elseif ($n<=36) return 10;
      elseif ($n<=40) return 11;
      elseif ($n<=45) return 12;
      elseif ($n<=51) return 13;
      elseif ($n<=58) return 14;
      elseif ($n<=66) return 15;
      elseif ($n<=72) return 16;
      elseif ($n<=80) return 17;
      elseif ($n<=89) return 18;
      elseif ($n<=99) return 19;
      else return 20;
    }
    if (@$_GET["put"]) {
      $put=mqfa("select name, koll from inventory where id='$_GET[put]' and owner='$user[id]' and type=189");
      if (!$put) {
        echo "<div style=\"width:650px;text-align:center\">Предмет не найден.</div>";
      } else {
        if (@$_GET["put"]) {
          if ($put["koll"]==1) mq("delete from inventory where id='$_GET[put]'");
          else mq("update inventory set koll=koll-1 where id='$_GET[put]'");
          $c=mqfa1("select id from cauldrons where user='$user[id]' and grass='$put[name]'");
          if ($c) mq("update cauldrons set koll=koll+1 where id='$c'");
          else mq("insert into cauldrons set user='$user[id]', grass='$put[name]', koll=1");
          echo "<div style=\"padding-right:200px\">Вы положили в котёл $put[name].</div>";
        }
      }
    }
    if (@$_GET["empty"]) {
      mq("delete from cauldrons where user='$user[id]'");
      echo "<div style=\"width:650px;text-align:center\">Вы опустошили тигель.</div>";
    }

    if (!@$_GET["make"]) {
      echo "<table width=\"650\"><tr><td>
      <h3>У вас есть следующие ресурсы:</h3>
      <table align=center><tr>";
      $r=mq("select id, name, koll, img from inventory where type=189 and owner='$user[id]' and (name='Цветок алканы' or name='Листья примулы' or name='Корень нирина' or name='Стебель аралии' or name='Ветка страстоцвета' or name='Листья гардении' or name='Ягоды азафоэтиды' or name='Цветок вербены' or name='Лист галангала' or name='Ягоды ветиверии' or name='Стебель портулака' or name='Лист эриодикта' or name='Ягоды хриностата' or name='Стабилизатор')");
      while ($rec=mysql_fetch_assoc($r)) {
        echo "<td align=\"center\"><b>$rec[koll]</b><br><a title=\"$rec[name]\" href=\"city.php?alh=1&put=$rec[id]\"><img borer=\"0\" src=\"".IMGBASE."/i/sh/$rec[img]\"></a></td>";
      }
      echo "</tr></table>
      <br>
      <center>
        <input type=button onclick=\"document.location.href='city.php?alh=1&make=1'\" value=\"Варить зелье\">&nbsp;&nbsp;&nbsp;&nbsp;
        <input type=button onclick=\"document.location.href='city.php?alh=1&empty=1'\" value=\"Вылить зелье из тигеля\">
      </center>";
      getadditdata($user);

      echo "<br>Владение алхимией: <b>$user[alchemylevel]</b> ($user[alchemy])<br>Будьте внимательны! Если вы положите траву в котёл, достать её оттуда уже будет невозможно. 
      Так же не переоцените свои возможности,
      последствия приготовления зелий, которые превосходят по сложности ваш уровень алхимии, могут быть весьма печальные.
      </td></tr></table>";
    } else {
      getadditdata($user);
      $totalbylevel=array(3,6,10,15,20,30,40,50,60,75,100);
      $maxcnt=$totalbylevel[$user["alchemylevel"]];
      $r=mq("select grass, koll from cauldrons where user='$user[id]'");
      $cauldron=array();
      $total=0;
      $hasstabil=0;
      while ($rec=mysql_fetch_assoc($r)) {
        if ($rec["grass"]=="Стабилизатор") {
          $hasstabil=1;
          continue;
        }
        $cauldron[$rec["grass"]]=$rec["koll"];
        $total+=$rec["koll"];
      }
      $failed=0;
      if (count($cauldron)>1 && (count($cauldron)>$cauldron["Цветок алканы"]+2 || !$cauldron["Цветок алканы"])) {
        $failed=1;
      }
      if ($total>$maxcnt || $failed) {
        if ($maxcnt-$total>=10) $chance=20+$total-$maxcnt;
        elseif ($maxcnt-$total>=5) $chance=10+$total-$maxcnt;
        else $chance=5+$total-$maxcnt;
        $chance+=20;
        if ($failed || getchance($chance)) {
          echo "<b>Вы использовали неправильные ингредиенты или переоценили свои возможности. Зелье взорвалось.</b>";
          $failed=1;
          addchp(($user["invis"]?"Невидимка":"Персонаж &quot;{$user['login']}&quot;")." переоценил".($user["sex"]==1?"":"а")." свои возможности, и зелье взорвалось.","Комментатор", $user["room"]);
          settravma($user["id"],1,60*30+(rand(0,30)*60),1,1);
          mq("update inventory set duration=duration+1 where id='$tigel[id]' and owner='$user[id]' and duration<maxdur limit 1");
        }
      }
      $sql="";
      foreach ($cauldron as $k=>$v) {
        if ($k=="Корень нирина") $sql.=", mfuvorot='".(alchval($v)*5)."'";
        if ($k=="Листья примулы") $sql.=", mfauvorot='".(alchval($v)*5)."'";
        if ($k=="Стебель аралии") $sql.=", mfakrit='".(alchval($v)*5)."'";
        if ($k=="Ветка страстоцвета") $sql.=", mfkrit='".(alchval($v)*5)."'";
        if ($k=="Листья гардении") $sql.=", mfparir='".(alchval($v))."'";
        if ($k=="Ягоды азафоэтиды") $sql.=", mfcontr='".(alchval($v))."'";
        if ($k=="Цветок вербены") $sql.=", mfdhit='".(alchval($v)*10)."'";
        if ($k=="Лист галангала") $sql.=", mfdmag='".(alchval($v)*10)."'";
        if ($k=="Ягоды ветиверии") $sql.=", manausage='".(alchval($v))."'";
        if ($k=="Стебель портулака") $sql.=", mfmagp='".(alchval($v*3))."'";
        if ($k=="Лист эриодикта") $sql.=", mfhitp='".(alchval($v)*2)."'";
        if ($k=="Ягоды хриностата") $sql.=", minusmfdmag='".(alchval($v))."'";                
      }
      if (!$failed) {
        if ((getchance($failchance) && !$hasstabil) || !$sql) {
          adduserdata("alchemy", ceil($total/2));
          checkalchlevel();
          echo "<b>Попытка сварить зелье не удалась.</b>";
          $failed=1;
          addchp(($user["invis"]?"Невидимка":"Персонаж &quot;{$user['login']}&quot;")." пытал".($user["sex"]==1?"ся":"ась")." сварить зелье, но что-то не удалось.","Комментатор", $user["room"]);
          if (rand(1,3)==2) mq("update inventory set duration=duration+1 where id='$tigel[id]' and owner='$user[id]' and duration<maxdur limit 1");
        } 
      }
      if (!$failed) {
        adduserdata("alchemy", $total);
        checkalchlevel();
        echo "<b>Зелье сварено успешно.</b>";
        addchp(($user["invis"]?"Невидимка":"Персонаж &quot;{$user['login']}&quot;")." удачно сварил".($user["sex"]==1?"":"а")." зелье.","Комментатор", $user["room"]);
        if ($total>=100) $nlevel=10;
        elseif ($total>=75) $nlevel=9;
        elseif ($total>=60) $nlevel=8;
        elseif ($total>=50) $nlevel=7;
        elseif ($total>=40) $nlevel=6;
        elseif ($total>=30) $nlevel=5;
        elseif ($total>=20) $nlevel=4;
        elseif ($total>=10) $nlevel=3;
        elseif ($total>=6) $nlevel=2;
        elseif ($total>=3) $nlevel=1;
        else $nlevel=0;
        mq("insert into inventory set owner='$user[id]', type=188, name='Самодельный эликсир [$nlevel]', img='elixir.gif', massa=1, duration=0, maxdur=3, nlevel=".min($nlevel, 8).", magic=186, otdel=188 $sql");
        $brec=mqfa("select id, koll from inventory where owner='$user[id]' and name='Бутылка'");
        if ($brec["koll"]<=1) mq("delete from inventory where id='$brec[id]'");
        else mq("update inventory set koll=koll-1 where id='$brec[id]'");
      }
      mq("delete from cauldrons where user='$user[id]'");
      makequest(16);
      $_GET["alh"]=0;
    }
  }
  if (!@$_GET["alh"] && !@$_GET["book"]) {
    $fon='54_bg';
    $locs[]=array("name"=>"$rooms[45]", "img"=>"2_Right","x"=>485, "y"=>180, "room"=>45);
    //$locs[]=array("name"=>"Ознакомительная экскурсия по пещере", "img"=>"2_Left","x"=>135, "y"=>130, "room"=>55);
    $locs[]=array("name"=>"Пройти вглубь пещеры", "img"=>"2_Left","x"=>35, "y"=>110, "room"=>301);
    $locs[]=array("name"=>"Приготовить зелье", "img"=>"54_cauldron","x"=>15, "y"=>140, "room"=>"54", "link"=>"city.php?alh=1");
    $locs[]=array("name"=>"Книга начинающего алхимика", "img"=>"54_book1","x"=>190, "y"=>210, "room"=>"54", "link"=>"city.php?book=1");
    $locs[]=array("name"=>"Основы алхимии", "img"=>"54_book2","x"=>330, "y"=>210, "room"=>"54", "link"=>"city.php?book=2");
    echo "<table width=1><tr><td><div style=\"position:relative\" id=\"ione\"><img src=\"".IMGBASE."/i/city/",$fon,".jpg\" alt=\"\" border=\"0\"/>";
    foreach ($locs as $k=>$v) {
      buildset($v["room"],$v["img"],$v["y"],$v["x"],$v["name"], @$v["link"]);
    }

    $hinttop=18;
    $hintright=113;
  }
} elseif ($user["room"]==70) {
  if((int)date("H") > 5 && (int)date("H") < 22) $n=""; else $n="n";
  $fon = WINTER."70_bg$n";

  echo "<table width=1><tr><td><div style=\"position:relative\" id=\"ione\"><img src=\"".IMGBASE."/i/city/",$fon,".jpg\" alt=\"\" border=\"0\"/>";
  $locs[]=array("name"=>"Катакомбы", "img"=>"70_catacombs$n","x"=>275, "y"=>135, "room"=>73);
  //$locs[]=array("name"=>"На вершину горы", "img"=>WINTER."4_bottom$n","x"=>245, "y"=>34, "room"=>81);
  $locs[]=array("name"=>"Потерянный вход", "img"=>"70_prison$n","x"=>80, "y"=>110, "room"=>"75");
  $locs[]=array("name"=>"Сторожевая Башня", "img"=>"70_storage$n","x"=>250, "y"=>205, "room"=>77);
  if ($user['align'] == 4) { 
    $locs[]=array("name"=>"Подгорная Башня смерти", "img"=>"70_tower$n","x"=>485, "y"=>135, "room"=>"71", "msg"=>"Хаосникам вход в ПБС запрещен!"); 
  } else { 
    include "config/fielddata.php";
    if ($user["level"]>=$fielddata['71']["minlevel"]) {
      $locs[]=array("name"=>"Подгорная Башня смерти", "img"=>"70_tower$n","x"=>485, "y"=>135, "room"=>"71"); 
    } else {
      $locs[]=array("name"=>"Подгорная Башня смерти", "img"=>"70_tower$n","x"=>485, "y"=>135, "room"=>"71", "msg"=>"Вход только с ".$fielddata['71']["minlevel"]."-го уровня.");
    }
  }
  $locs[]=array("name"=>"Страшилкина улица", "img"=>"3_Left","x"=>20, "y"=>220, "room"=>"21");
  foreach ($locs as $k=>$v) {
    buildset($v["room"],$v["img"],$v["y"],$v["x"],$v["name"], @$v["link"], @$v["msg"]);
  }
  $hinttop=18;
  $hintright=113;
  if (WINTER) echo "<div id=\"snow\"></div><script src=\"i/js/snow.js\"></script>";
}
/*elseif ($user['room'] == 26)
{
    if((int)date("H") > 5 && (int)date("H") < 22) {
        $fon = 'sub/u2bg';
                $z_zamok2= 'zamok2';
                $z_zamok1= 'zamok1';
                $z_loto= 'loto_stalkers';
    } else {
        $fon = 'sub/nu2bg';
                $z_zamok2= 'zamok2n';
                $z_zamok1= 'zamokn1';
                $z_loto= 'nloto_stalkers';
    }
    echo "<table width=1><tr><td><div style=\"position:relative; cursor: pointer;\" id=\"ione\"><img src=\"i/city/",$fon,".jpg\" alt=\"\" border=\"0\"/>";

    buildset(1,"$z_zamok2",5,315,"Готический замок");
    buildset(2,"$z_zamok1",50,60,"Серый замок");
    buildset(11,"$z_loto",140,80,"Лотерея Сталкеров");
//  buildset(5,"hell_en",206,80,"Врата Ада");

    buildset(3,"2stop",150,16,"Проход закрыт");
    buildset(4,"2strelka",150,428,"Центральная площадь");
    echo "</td></tr></table>";
}*/
$online = mysql_query("select real_time from `online`  WHERE `real_time` >= ".(time()-60).";");
//$vsego_u = mqfa1("select count(id) from `allusers`");
?>
<div id="snow"></div>
<div style="position:absolute; left:<?
  if ($user["room"]==45) echo 407;
  elseif ($user["room"]==54) echo 437;
  else echo 457;
?>px; top:0px; width:1px; height:1px; z-index:101; overflow:visible;">
<TABLE height=15 border="0" cellspacing="0" cellpadding="0">
<TR>
<TD rowspan=3 valign="bottom"><a href="?rnd=0.604083970286585"><img src="<?=IMGBASE?>/i/move/rel_1.gif" width="15" height="16" alt="Обновить" border="0" /></a></TD>
<TD colspan="3"><img src="<?=IMGBASE?>/i/move/navigatin_462s.gif" width="80" height="4" /></TD>
</TR>
<TR>
<TD><IMG src="<?=IMGBASE?>/i/move/navigatin_481.gif" width="9" height="8"></TD>
<TD width=64 bgcolor=black><DIV class="MoveLine"><IMG src="<?=IMGBASE?>/i/move/wait2.gif" id="MoveLine" class="MoveLine"></DIV></TD>
<TD><IMG src="<?=IMGBASE?>/i/move/navigatin_50.gif" width="7" height="8"></TD>
</TR>
<TR>
<TD colspan="3"><IMG src="<?=IMGBASE?>/i/move/navigatin_tt1_532.gif" width="80" height="5"></TD>
</TR>
</TABLE>
</div>
</div>

<tr><td align="right"><div align="right" id="btransfers"><table cellpadding="0" cellspacing="0" border="0" id="bmoveto">
<tr><td bgcolor="#D3D3D3">
<? if ($user['room'] == 20 && 0) { ?>
<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_1" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Бойцовский Клуб</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_2" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Магазин</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_4" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Ремонтная мастерская</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_3" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Комиссионный магазин</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_6" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Почтовое отделение</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_21" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Страшилкина улица</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_10" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Магазин Березка</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_12" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Банк</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_11" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Зоомагазин</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_49" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Новая земля</a></span>

<? if (WINTER) { ?><span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_9" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Новогодняя елка</a></span><? } ?>

<?} elseif ($user['room'] == 21 && 0) { ?>
<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_11" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Аукционный дом</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_6" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Цветочный магазин</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_2" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Регистратура кланов</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_1" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Магазин Благородства</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_5" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Вход в водосток</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_7" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Башня Смерти</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="<?=IMGBASE?>/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_20" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Центральная площадь</a></span>

<? } elseif ($user["room"]==45 && 0) {
  echo $loclinks;
} ?>
<?
if($_SESSION['movetime']>time()){$vrme=$_SESSION['movetime']-time();}else{$vrme=0;}
?>
</td>
</tr>
</table>
<?
  echo "<div style=\"padding-top:5px;text-align:right;padding-right:20px\">".bottombuttons()."</div>";
?>
</div></td></tr>
</table>
<div style="display:none; height:0px " id="moveto">0</div>
<!-- <br /><span class="menutop"><nobr>Центральная Площадь</nobr></span>-->
</td>
</tr>
</table>
<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px; white-space: nowrap;"></div>
<script language="javascript" type="text/javascript">
var progressEnd = 64;       // set to number of progress <span>'s.
var progressColor = '#00CC00';  // set to progress bar color
var mtime = parseInt('<?=$vrme?>');
if (!mtime || mtime<=0) {mtime=0;}
var progressInterval = Math.round(mtime*1000/progressEnd);  // set to time between updates (milli-seconds)
var is_accessible = true;
var progressAt = progressEnd;
var progressTimer;
function progress_clear() {
progressAt = 1;
is_accessible = false;
set_moveto(true);
}
function progress_update() {
progressAt++;
//if (progressAt > progressEnd) progress_clear();
if (progressAt > progressEnd) {
is_accessible = true;
if (window.solo_store && solo_store) { solo(solo_store, ""); } // go to stored
set_moveto(false);
} else {
if( !( progressAt % 2 ) )
document.getElementById('MoveLine').style.left = progressAt - 64;
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
/*  progressColor = color;
for (var i = 1; i <= progressAt; i++) {
document.getElementById('progress'+i).style.backgroundColor = progressColor;
}*/
}
if (mtime>0) {
progress_clear();
progress_update();
}
</script>
<HR>
<div id="buttons_on_image" style="cursor:pointer; font-weight:bold; color:<? if (WINTER) echo "#000000"; else echo "#D8D8D8"; ?>; font-size:10px;">
<? if ($user["room"]==45) { ?>
  <? if (WINTER && 0) echo "<span onMouseMove=\"this.runtimeStyle.color = 'white';\" onMouseOut=\"this.runtimeStyle.color = this.parentElement.style.color;\" onclick=\"document.location.href='city.php?hunt=1';\">Охотиться</span> &nbsp;"; ?>

  <!--<span onMouseMove="this.runtimeStyle.color = 'white';" onMouseOut="this.runtimeStyle.color = this.parentElement.style.color;" onclick="document.location.href='city.php?findgrass2=1';">Пойти за разрыв-травой</span> &nbsp;-->

  <!--span onMouseMove="this.runtimeStyle.color = '<? if (WINTER) echo "#aaaaaa"; else echo "white"; ?>';" onMouseOut="this.runtimeStyle.color = this.parentElement.style.color;" onclick="document.location.href='city.php?findgrass=1';">Искать алхимические травы</span-->
  <span style="color: white;" onclick="document.location.href='city.php?findgrass=1';">Искать алхимические травы</span> &nbsp;
  <!--<span onMouseMove="this.runtimeStyle.color = 'white';" onMouseOut="this.runtimeStyle.color = this.parentElement.style.color;" onclick="findlogin('Введите имя персонажа', 'city.php?nap=attack', 'target'); ">Напасть</span> &nbsp;-->
<? } else { ?>
  <span onMouseMove="this.runtimeStyle.color = '<? if (WINTER) echo "#aaaaaa"; else echo "white"; ?>';" onMouseOut="this.runtimeStyle.color = this.parentElement.style.color;" onclick="window.open('/forum.php', 'forum', 'location=yes,menubar=yes,status=yes,resizable=yes,toolbar=yes,scrollbars=yes,scrollbars=yes')">Форум</span> &nbsp;
  <? if($user['room'] == 20){?>
  <span onMouseMove="this.runtimeStyle.color = '<? if (WINTER) echo "#aaaaaa"; else echo "white"; ?>';" onMouseOut="this.runtimeStyle.color = this.parentElement.style.color;" onclick="findlogin('Введите имя персонажа', 'city.php?nap=attack', 'target'); ">Напасть</span> &nbsp;
  <?}?>
  <span onMouseMove="this.runtimeStyle.color = '<? if (WINTER) echo "#aaaaaa"; else echo "white"; ?>';" onMouseOut="this.runtimeStyle.color = this.parentElement.style.color;" onclick="window.open('help/city1.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">Подсказка</span> &nbsp;
<? } ?>
</div>
<script language="javascript" type="text/javascript">
<!--
if (document.getElementById('ione')) {
document.getElementById('ione').appendChild(document.getElementById('buttons_on_image'));
document.getElementById('buttons_on_image').style.position = 'absolute';
document.getElementById('buttons_on_image').style.top = '<?=$hinttop?>px';
document.getElementById('buttons_on_image').style.right = '<?=$hintright?>px';
} else {
document.getElementById('buttons_on_image').style.display = 'none';
}
-->
</script>
    <small>
    <BR>
    <B>Внимание!</B> Никогда и никому не говорите пароль от своего персонажа. Не вводите пароль на других сайтах, типа "новый город", "лотерея", "там, где все дают на халяву". Пароль не нужен ни паладинам, ни кланам, ни администрации, <U>только взломщикам</U> для кражи вашего героя.<BR>
    <I>Администрация.</I></small>
    <BR>
     <u>Cейчас в клубе</u>: <?=mysql_num_rows($online)?> чел.<br><img alt="Capital city" src=/i/misc/forum/fo1.gif> <b>Capital city</b>: <?=mysql_num_rows($online)?> чел.<BR><br>
    <?php include("mail_ru.php"); ?>
        <?php
         $online = mysql_fetch_array(mq('SELECT u.* ,o.date,u.* ,o.real_time FROM `users` as u, `online` as o WHERE u.`id` = o.`id` AND u.`id` = \''.$user['id'].'\' LIMIT 1;'));
        ?>

    <?php
    if ($_SESSION["uid"]==7) {
function takeshopitem1($item) {
  $r=mq("show fields from items");
  $rec1=mqfa("select * from shop where id='$item'");
  $sql="";
  while ($rec=mysql_fetch_assoc($r)) {
    if ($present) {
      if ($rec["Field"]=="maxdur") $rec1[$rec["Field"]]=1;
      if ($rec["Field"]=="cost") $rec1[$rec["Field"]]=2;
    }
    if ($rec["Field"]=="id" || $rec["Field"]=="prototype") continue;
    if ($rec["Field"]=="goden") $goden=$rec1[$rec["Field"]];
    $sql.=", `$rec[Field]`='".$rec1[$rec["Field"]]."' ";
  }
  mq("insert into inventory set owner='$_SESSION[uid]', prototype='$item' ".($goden?", dategoden='".($goden*60*60*24+time())."'":"")." $sql");
  echo mysql_error();
  return array("img"=>$rec1["img"], "name"=>$rec1["name"]);
}
    }
?>

    </TD>
</TR>
</TABLE></td></tr></table>
<?
  $f=mqfa1("select value from variables where var='fireworks'");
  if ($f>time()) echo implode("",file("clipart/fworks.html"));
  //if ($user["room"]==20) echo implode("",file("clipart/fworks.html"));
?>
</BODY>
</HTML>

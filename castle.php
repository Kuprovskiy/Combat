<?php
    session_start();
    if ($_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    include "functions.php";
    if ($user['battle'] != 0) { header('Location: fbattle.php'); die(); }
    if (!incastle($user["room"])) { header('Location: main.php'); die(); }
    include_once("config/routes.php");
    $castleowner=getvar("castleowner");
                   
//    if ($user["klan"]=="Adminion") $castleowner=$user["klan"];
    if ($castleowner && $user["klan"]!=$castleowner) $routes[700][1]=0;

    $siege=getvar("siege");
    if ($siege==2) {
      if ($user["klan"]!=$castleowner && $user["room"]>707) {
        sysmsg("Нападающие проникли на стену замка,");
        mq("update variables set value=1 where var='siege'");
        $siege=1;
      }
    }

    function defender($user) {
      return "
      <img src=\"".IMGBASE."/i/align_".($user["align"]>0?$user["align"]:"0").".gif\">".($user['klan']!=""?"<img title=\"".$user['klan'].'" src="'.IMGBASE.'/i/klan/'.$user['klan'].'.gif">':"")."<a href=\"javascript:void(0)\" onclick=\"top.AddTo('$user[login]');return false;\"><B>$user[login]</B></a> [$user[level]]";
    }

    function addsiegeroutes() {
      global $siege, $attackroom, $defenders, $onwall, $user, $routes, $castleowner;
      if ($siege==1 || $siege==2) {
        $attackroom=0;
        if ($user["room"]==700) $attackroom=714;
        if ($user["room"]==702) $attackroom=710;
        if ($user["room"]==704) $attackroom=717;
        if ($user["room"]==706) $attackroom=711;
        $defenders=mq("select id, login, level, klan from users where klan='$castleowner' and room='$attackroom'");
        $onwall=mysql_num_rows($defenders);
        if (!$onwall) {
          if ($user["room"]==700) $routes[$user["room"]][1]=714;
          if ($user["room"]==702) $routes[$user["room"]][2]=710;
          if ($user["room"]==704) $routes[$user["room"]][3]=717;
          if ($user["room"]==706) $routes[$user["room"]][0]=711;
        }
      }
    }
    addsiegeroutes();

    // переходы
    $_GET['path'] = (int)$_GET['path'];
    if($_GET['path'] && $user["movetime"] <= time()) {
      if (!canmove()) {
      } else {
        $gotoroom=0;
        $gotoroom=$routes[$user["room"]][$_GET["path"]-1];
        if ($gotoroom) {
          if (@$routes[$user["room"]] && in_array($gotoroom, $routes[$user["room"]])) {
            $siege=getvar("siege");
            if ($siege<10) {
              $list = mq("SELECT `id`,`room`,`login` FROM `users` WHERE `room` = '".$user['room']."'");
              while($u = mysql_fetch_array($list)) {
                if($u['id']!=$user['id']) addchp ('<font color=red>Внимание!</font> <B>'.$user['login'].'</B> отправился в <B>'.$rooms[$gotoroom].'</B>.   ','{[]}'.$u['login'].'{[]}');
              }
              // пришел в комнату
              $list = mq("SELECT `id`,`room`,`login` FROM `users` WHERE `room` = '$gotoroom'");
              while($u = mysql_fetch_array($list)) {
                addchp ('<font color=red>Внимание!</font> <B>'.$user['login'].'</B> вошел в комнату.   ','{[]}'.$u['login'].'{[]}');
              }
            }
            if ($_SERVER["REMOTE_ADDR"]=="127.0.0.1") $movetime=1;
            else $movetime=10;
            gotoroom($gotoroom, 0, 0, $movetime);
            $user["room"]=$gotoroom;
            $user["movetime"]=time()+$movetime;
            if ($gotoroom==20) {
              header("location: city.php");
              die;
            }
            // ушел из комнаты
            /*$list = mq("SELECT `id`,`room`,`login` FROM `users` WHERE `room` = '".$user['room']."'");
            while($u = mysql_fetch_array($list)) {
                if($u['id']!=$user['id']) addchp ('<font color=red>Внимание!</font> <B>'.$user['login'].'</B> отправился в <B>'.$rooms[$rhar[$user['room']][$_GET['path']]].'</B>.   ','{[]}'.$u['login'].'{[]}');
            }
            // пришел в комнату
            $list = mq("SELECT `id`,`room`,`login` FROM `users` WHERE `room` = '".$rhar[$user['room']][$_GET['path']]."' AND `in_tower`=1;");
            while($u = mysql_fetch_array($list)) {
                addchp ('<font color=red>Внимание!</font> <B>'.$user['login'].'</B> вошел в комнату.   ','{[]}'.$u['login'].'{[]}');
            }*/
          }
        }
        addsiegeroutes();
      }
    }

    // нападение
    if($_POST['attack']) {
      $siege=getvar("siege");
      if ($siege<10) {
        include "functions/attack.php";
        $error="";
        $k=mqfa1("select klan from users where login='$_POST[attack]'");
        if ($k && $k==$user["klan"]) {
          $error="Не стоит нападать на своих.";
        } elseif ($siege!=0 && $user["klan"]!=$castleowner) {
          if ($k!=$castleowner) $error="Сначала надо разобраться с защитниками.";
        }
        if (!$error) $error=attack($_POST["attack"], 3, 0, 1, $attackroom);
      } else $error="Битва за замок ещё не началась.";
    }
    if($_POST['help'] && $user["klan"]==$castleowner && $user["klan"]) {
      $siege=getvar("siege");
      if ($siege<10) {
        include "functions/attack.php";
        $error="";
        $target=mqfa("select id, klan, room from users where login='$_POST[help]'");
        if (!$target) $error="Персонаж $_POST[help] не найден.";
        elseif ($target["klan"]!=$user["klan"]) $error="Персонаж $_POST[help] не ваш соклан.";
        elseif ($target["room"]!=$user["room"]) $error="Персонаж $_POST[help] слишком далеко.";
        if (!$error) $error=attack(0, 3, 0, 1, $attackroom, $_POST["help"]);
      } else $error="Битва за замок ещё не началась.";
    }
    if ($user['hp']<=0 || $user["klan"]=='') { 
      $siege=getvar("siege");
      if (($siege<10 && $user["hp"]<=0) || ($user["klan"]=="" && $siege==0)) {
        gotoroom(49);
        addchp ('<font color=red>Внимание!</font>Вы выбыли из битвы за клановый замок.', '{[]}'.$user['login'].'{[]}');
        die(); 
      }
    }
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META HTTP-EQUIV=Expires CONTENT=0>
<META HTTP-EQUIV=imagetoolbar CONTENT=no>
<style>
img.aFilter { filter:Glow(color=d7d7d7,Strength=4,Enabled=0); cursor:hand }
</style>
<SCRIPT LANGUAGE="JavaScript"> 
function findlogin(title, script, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><form action="'+script+'" method=POST><INPUT TYPE=hidden name=sd4 value="6"><td colspan=2>'+
    'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD width=50% align=right><INPUT TYPE=text NAME="'+name+'"></TD><TD width=50%><INPUT TYPE="submit" value=" >> "></TD></TR></FORM></TABLE></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 200;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}
 
function closehint3(){
    document.all("hint3").style.visibility="hidden";
    Hint3Name='';
}
 
var solo_store;
var from_map = false;
 
function imover(im) {
if( im.filters )
im.filters.Glow.Enabled=true;
if ( from_map == false && im.id.match(/mo_(\d)/) && document.getElementById('b' + im.id)) {
from_map = true;
if( document.getElementById('b' + im.id).runtimeStyle )
document.getElementById('b' + im.id).runtimeStyle.color = '#666666';
from_map = false;
}
}
 
function imout(im) {
if( im.filters )
im.filters.Glow.Enabled=false;
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
 
function fullfastshow(a,b,c,d,e,f){if(typeof b=="string")b=a.getElementById(b);var g=c.srcElement?c.srcElement:c,h=g;c=g.offsetLeft;for(var j=g.offsetTop;h.offsetParent&&h.offsetParent!=a.body;){h=h.offsetParent;c+=h.offsetLeft;j+=h.offsetTop;if(h.scrollTop)j-=h.scrollTop;if(h.scrollLeft)c-=h.scrollLeft}if(d!=""&&b.style.visibility!="visible"){b.innerHTML="<small>"+d+"</small>";if(e){b.style.width=e;b.whiteSpace=""}else{b.whiteSpace="nowrap";b.style.width="auto"}if(f)b.style.height=f}d=c+g.offsetWidth+10;e=j+5;if(d+b.offsetWidth+3>a.body.clientWidth+a.body.scrollLeft){d=c-b.offsetWidth-5;if(d<0)d=0}if(e+b.offsetHeight+3>a.body.clientHeight+a.body.scrollTop){e=a.body.clientHeight+ +a.body.scrollTop-b.offsetHeight-3;if(e<0)e=0}b.style.left=d+"px";b.style.top=e+"px";if(b.style.visibility!="visible")b.style.visibility="visible"}function fullhideshow(a){if(typeof a=="string")a=document.getElementById(a);a.style.visibility="hidden";a.style.left=a.style.top="-9999px"}
function gfastshow(dsc, dx, dy) { fullfastshow(document, mmoves3, window.event, dsc, dx, dy); }
function ghideshow() { fullhideshow(mmoves3); }
</SCRIPT>
<STYLE>
.H3         { COLOR: #8f0000;  FONT-FAMILY: Arial;  FONT-SIZE: 12pt;  FONT-WEIGHT: bold;}
</STYLE>
<SCRIPT src='i/commoninf.js'></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" >
var Hint3Name = '';
// Заголовок, название скрипта, имя поля с логином
function findlogin(title, script, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
    '<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><form action="'+script+'" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"><td colspan=2>'+
    'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD width=50% align=right><INPUT TYPE=text NAME="'+name+'"></TD><TD width=50%><INPUT TYPE="submit" value=" »» "></TD></TR></FORM></TABLE></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}


function returned2(s){
    if (top.oldlocation != '') { top.frames['main'].navigate(top.oldlocation+'?'+s+'tmp='+Math.random()); top.oldlocation=''; }
    else { top.frames['main'].navigate('main.php?'+s+'tmp='+Math.random()) }
}
<?
$step=1;
if ($step==1) $idkomu=0;
?>
function closehint3(){
    document.all("hint3").style.visibility="hidden";
    Hint3Name='';
}
</script>
</HEAD>
<body leftmargin=2 topmargin=2 marginwidth=2 marginheight=2 bgcolor="#e2e0e0" onload="<?=topsethp()?>">
<div id=hint4 class=ahint></div>
<TABLE width=100% cellspacing=0 cellpadding=0>

<TR><TD><?nick($user);?></TD>
<TD class='H3' align=right><?=$rooms[$user['room']];?>&nbsp; &nbsp;
<? if ($siege<10) { ?><IMG SRC="<?=IMGBASE?>i/tower/attack.gif" WIDTH=66 HEIGHT=24 ALT="Напасть на..." style="cursor:hand" onclick="findlogin('Напасть на','castle.php','attack')">
<? if ($user["klan"]==$castleowner && $user["klan"]) { ?><IMG SRC="<?=IMGBASE?>i/tower/help.gif" WIDTH=66 HEIGHT=24 ALT="Помочь соклану..." style="cursor:hand" onclick="findlogin('Помочь соклану','castle.php','help')"><? } ?>
<? } ?>
</TD>
<TR>
<TD valign=top>
<FONT COLOR=red></FONT>

<?
if (@$error) echo "<b><font color=red>$error</font></b>";
if ($castleowner) {
  if ($onwall) {
    echo "<b><center>Защитники стены:</center</b></center>";
    while ($rec=mysql_fetch_assoc($defenders)) {
      echo defender($rec);
    }
  } else {
    $cl=mqfa("select name, clanbig from clans where short='$castleowner'");
    echo "<br><center><b>Владелец замка: $cl[name]</b></center><br>
    <center><img src=\"".IMGBASE."/i/klan/$cl[clanbig].gif\"></center><br><br>";
    //if ($user['id'] == 7 || $user['id'] == 2735) {
        if (time() < $siege) {
            echo '<center>Следующая осада Кланового Замка - ' . date('d.m.Y H:i', $siege) . '</center>';
        }
    //}
  }
}
    /*$its = mq("SELECT * FROM `deztow_items` WHERE `room` = '".$user['room']."';");
    if(mysql_num_rows($its)>0) {
        echo '<H4>В комнате разбросаны вещи:</H4>';
    }
    while($it = mysql_fetch_array($its)) {
        echo ' <A HREF="towerin.php?give=',$it['id'],'"><IMG SRC="i/sh/',$it['img'],'" ALT="Подобрать предмет \'',$it['name'],'\'"></A>';
    }*/

?>
</TD>
<TD colspan=3 valign=top align=right nowrap>
<!--<link href="<?=IMGBASE?>/i/move/design4.css" rel="stylesheet" type="text/css">-->
<script language="javascript" type="text/javascript">
function fastshow2 (content) {
    var el = document.getElementById("mmoves");
    var o = window.event.srcElement;
    if (content == '') { el.innerHTML =  '';}
    if (content!='' && el.style.visibility != "visible") {el.innerHTML = '<small>'+content+'</small>';}
    var x = window.event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft - el.offsetWidth + 5;
    var y = window.event.clientY + document.documentElement.scrollTop + document.body.scrollTop+20;
    if (x + el.offsetWidth + 3 > document.body.clientWidth + document.body.scrollLeft) { x=(document.body.clientWidth + document.body.scrollLeft - el.offsetWidth - 5); if (x < 0) {x=0}; }
    if (y + el.offsetHeight + 3 > document.body.clientHeight  + document.body.scrollTop) { y=(document.body.clientHeight + document.body.scrollTop - el.offsetHeight - 3); if (y < 0) {y=0}; }
    if (x<0) {x=0;}
    if (y<0) {y=0;}
    el.style.left = x + "px";
    el.style.top  = y + "px";
    if (el.style.visibility != "visible") {
        el.style.visibility = "visible";
    }
}
function hideshow () {
    document.getElementById("mmoves").style.visibility = 'hidden';
}
</script>

<script language="javascript" type="text/javascript">
var solo_store;
function solo(n, name) {
    if (check_access()==true) {
        window.location.href = '?path='+n+'&rnd='+Math.random();
    } else if (name && n) {
        solo_store = n;
        var add_text = (document.getElementById('add_text') || document.createElement('div'));
        add_text.id = 'add_text';
        add_text.innerHTML = 'Вы перейдете в: <strong>' + name +'</strong> (<a href="#" onclick="return clear_solo();">отмена</a>)';
        document.getElementById('ione').parentNode.parentNode.nextSibling.firstChild.appendChild(add_text);
        ch_counter_color('red');
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
    im.filters.Glow.Enabled=true;
    if ( from_map == false && im.id.match(/mo_(\d)/) && document.getElementById('b' + im.id)) {
        from_map = true;
        document.getElementById('b' + im.id).runtimeStyle.color = '#666666';
        from_map = false;
    }

}
function imout(im) {
    im.filters.Glow.Enabled=false;
    if ( from_map == false && im.id.match(/mo_(\d)/) && document.getElementById('b' + im.id)) {
        from_map = true;
        document.getElementById('b' + im.id).runtimeStyle.color = document.getElementById('b' + im.id).style.color;
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
function Down() {top.CtrlPress = window.event.ctrlKey}
document.onmousedown = Down;

var fireworks_types = new Array('04',21, '03',21, '05',21, '06',21, '07',27, '08',27, '02',34, '09',34,
                '10',34, '11',42, '14', 27, '16', 32, '15', 37 );

function fireworks (x,y,type) {
    return start_fireworks(x,y,type);
}

function start_fireworks (x,y,type) {
    myFW = new JSFX.FireworkDisplay(1, "<?=IMGBASE?>/i/fireworks/fw"+fireworks_types[type*2], fireworks_types[type*2+1], x, y);
    myFW.start();
    return false;
}

function stop_fireworks (id) {
    document.getElementById(id).style.display = 'none';
    document.getElementById(id).removeNode(true);
    return false;
}

</script>
<table  border="0" cellpadding="0" cellspacing="0">
    <tr align="right" valign="top">
        <td>

            <table cellpadding="0" cellspacing="0" border="0" width="1"><tr><td>
            <div style="position:relative; cursor: pointer;" id="ione">            
              <?                     //&& $siege>10
                if ($user["room"]==708) {
                  echo "
                  <a href=\"castle.php?path=5&".time()."\"><img border=\"0\" class=\"aFilter\" src=\"".IMGBASE."/i/rooms/castlehouse1.gif\" style=\"position:absolute;top:133px;left:0px\" onmouseover=\"imover(this)\" onmouseout=\"imout(this);\"></a>
                  <a href=\"castle.php?path=6&".time()."\"><img border=\"0\" class=\"aFilter\" src=\"".IMGBASE."/i/rooms/castlehouse2.gif\" style=\"position:absolute;top:120px;left:420px\" onmouseover=\"imover(this)\" onmouseout=\"imout(this);\"></a>
                  ";                       // && $siege>10
                } elseif ($user["room"]==709) {
                  echo "
                  <a href=\"castle.php?path=5&".time()."\"><img border=\"0\" class=\"aFilter\" src=\"".IMGBASE."/i/rooms/castlehouse1.gif\" style=\"position:absolute;top:133px;left:0px\" onmouseover=\"imover(this)\" onmouseout=\"imout(this);\"></a>
                  <a href=\"castle.php?path=6&".time()."\"><img border=\"0\" class=\"aFilter\" src=\"".IMGBASE."/i/rooms/castlehouse2.gif\" style=\"position:absolute;top:120px;left:420px\" onmouseover=\"imover(this)\" onmouseout=\"imout(this);\"></a>
                  ";
                }

                if ($user["room"]==718) {
                  echo "<div style=\"width:500px\">";
                  if ($siege<10) {
                    echo "<center><br><b>Во время осады монахи не оказывают свои услуги.</b></center>";
                  } else {
                    if (@$_GET["heal"] && $user["klan"]==$castleowner && $user["klan"]) {
                      if ($user["money"]>=3) {
                        $user["hp"]=$user["maxhp"];
                        $r=mq("select id from effects where owner='$user[id]' and (type=11 or type=12 or type=13 or type=14)");
                        while ($rec=mysql_fetch_assoc($r)) {
                          deltravma($rec["id"]);
                        }
                        mq("delete from effects where owner='$user[id]' and type=".TRAVMARESISTANCE);
                        mq("update users set hp=maxhp, mana=maxmana, money=money-3 where id='$user[id]'");
                        echo "<b>Сеанс лечения прошёл успешно.</b><br>";
                      } else {
                        echo "<b><font color=red>Недостаточно денег в наличии</font></b><br>";
                      }
                    } elseif (@$_GET["heal"]) echo "<b><font color=red>Лечение доступно только для владельцев замка</font></b><br>";
                    echo "Местные монахи за скромную плату могут излечить вас от любых телесных и душевных недугов,
                    будь то тяжёлая травма, которую никто другой не сможет вылечить, или обычная усталость.
                    За свою работу они берут только 3 кредита.<br><br>
                    <center><a href=\"castle.php?heal=1&".time()."\">Лечиться</a></center>";                    
                  }
                  echo "</div>";
                } elseif ($user["room"]==719) {
                  echo "<div style=\"width:500px\">";
                  if ($siege<10) {
                    echo "<center><br><b>Во время осады маг не оказывает свои услуги.</b></center>";
                  } else {
                    $buy=@$_GET["buy"];
                    if ($buy && $user["klan"]==$castleowner && $user["klan"]) {
                      if ($user["money"]>=1) {
                        $ok=0;
                        if ($buy==1) {
                          $current=mqfa("SELECT id, name FROM `effects` WHERE `owner` =$user[id] and type=187 and intel>0");
                          $eltime=3600*2;
                          if(!$current){
                            mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`intel`) values ('$user[id]','Холодный разум',".(time()+$eltime).",'187', 10)");
                            mq("UPDATE users set intel=intel+10 WHERE id=$user[id]");
                            $ok=1;
                          } else {
                            if ($current["name"]=="Холодный разум") {
                              mq("UPDATE `effects` set `time` = '".(time()+$eltime)."' WHERE id='$current[id]'");
                              $ok=1;
                            } else {
                              echo "<b><font color=red>Ещё не прошло действие предыдущего заклятия</font></b><br>";
                            }
                          }                        
                        }
                        if ($buy==2 || $buy==3) {
                          $eff=mqfa1("SELECT id FROM `effects` WHERE `owner` = '$user[id]' and `type` = '".(199+$buy)."'");
                          if ($eff) {
                            mq("update effects set time='".(time()+7200)."' where id='$eff'");
                          } else {
                            mq("INSERT into effects (`owner`,`name`,`time`,`type`) values ('$user[id]','".($buy==2?"Защита от оружия":"Сокрушение")."',".(time()+7200).",".(199+$buy).");");
                          }
                          $ok=1;
                        }
                        if ($buy>=4 && $buy<=11) {
                          if ($buy==4) {$mf="mfdfire";$mfval=100;$name="Защита от Огня";}
                          if ($buy==5) {$mf="mfdwater";$mfval=100;$name="Защита от Воды";}
                          if ($buy==6) {$mf="mfdair";$mfval=100;$name="Защита от Воздуха";}
                          if ($buy==7) {$mf="mfdearth";$mfval=100;$name="Защита от Земли";}
                          if ($buy==8) {$mf="mffire";$mfval=30;$name="Огненное Усилениие";}
                          if ($buy==9) {$mf="mfwater";$mfval=30;$name="Водное Усилениие";}
                          if ($buy==10) {$mf="mfair";$mfval=30;$name="Воздушное Усилениие";}
                          if ($buy==11) {$mf="mfearth";$mfval=30;$name="Земное Усилениие";}
                          $eff=mqfa("SELECT id, name, time FROM `effects` WHERE `owner` = $user[id] and mf='$mf' AND `type`=187");
                          if(!$eff){
                            mq("INSERT INTO `effects` (`owner`,`name`,`time`,`type`, mf, mfval) values ('$user[id]','$name',".(time()+7200).",187, '$mf', '$mfval')");
                            $ok=1;
                          } else {
                            if ($eff["name"]==$name) {
                              updeffect($user["id"], $eff, 7200, array("name"=>$name, $mf=>$mfval), 0);
                              //mq("UPDATE `effects` set `time` = '".(time()+7200)."' WHERE `id` = $eff[id]");
                              $ok=1;
                            } else {
                              echo "<b><font color=red>Ещё не прошло действие предыдущего заклятия</font></b><br>";
                            }
                          }
                        }
                        if ($ok) {
                          mq("update users set money=money-1 where id='$user[id]'");
                          echo "<b>Заклинание наложено успешно.</b><br>";
                        }
                      } else {
                        echo "<b><font color=red>Недостаточно денег в наличии</font></b><br>";
                      }
                    } elseif ($buy) echo "<b><font color=red>Маг предоставляет услуги только для владельцев замка</font></b><br>";
                    echo "В этом домике проживает маг, который за скромную плату в 1 кр. может наложить любые заклинания, которые он умеет.<br><br>
                    <center>
                      <a href=\"castle.php?buy=1&".time()."\"><img border=\"0\" src=\"".IMGBASE."/i/sh/spell_stat_intel.gif\"></a>
                      <a href=\"castle.php?buy=2&".time()."\"><img border=\"0\" src=\"".IMGBASE."/i/sh/spell_protect10.gif\"></a>
                      <a href=\"castle.php?buy=3&".time()."\"><img border=\"0\" src=\"".IMGBASE."/i/sh/spell_powerup10.gif\"></a>
                      <a href=\"castle.php?buy=4&".time()."\"><img border=\"0\" src=\"".IMGBASE."/i/sh/spell_protect1.gif\"></a>
                      <a href=\"castle.php?buy=5&".time()."\"><img border=\"0\" src=\"".IMGBASE."/i/sh/spell_protect2.gif\"></a>
                      <a href=\"castle.php?buy=6&".time()."\"><img border=\"0\" src=\"".IMGBASE."/i/sh/spell_protect3.gif\"></a>
                      <a href=\"castle.php?buy=7&".time()."\"><img border=\"0\" src=\"".IMGBASE."/i/sh/spell_protect4.gif\"></a>
                      <a href=\"castle.php?buy=8&".time()."\"><img border=\"0\" src=\"".IMGBASE."/i/sh/spell_powerup1.gif\"></a>
                      <a href=\"castle.php?buy=9&".time()."\"><img border=\"0\" src=\"".IMGBASE."/i/sh/spell_powerup2.gif\"></a>
                      <a href=\"castle.php?buy=10&".time()."\"><img border=\"0\" src=\"".IMGBASE."/i/sh/spell_powerup3.gif\"></a>
                      <a href=\"castle.php?buy=11&".time()."\"><img border=\"0\" src=\"".IMGBASE."/i/sh/spell_powerup4.gif\"></a>                                                              
                    </center>";
                  }
                  echo "</div>";
                } elseif ($user["room"]==720) {
                  echo "<div style=\"width:500px\">";
                  if ($siege<10) {
                    echo "<center><br><b>Харчевня закрыта до окончания осады.</b></center>";
                  } else {
                    if (@$_GET["el"] && $user["klan"]==$castleowner && $user["klan"]) {
                      $el=$_GET["el"];
                      if ($el==1) {
                        $price=1;
                        $mfdhit=50;
                        $at="hit";
                        $name="Эликсир Неуязвимости";
                      }
                      if ($el==2) {
                        $price=1;
                        $mfdmag=50;
                        $at="mag";
                        $name="Эликсир Стихий";
                      }
                      if ($el==3) {
                        $price=2;
                        $mfdhit=75;
                        $at="hit";
                        $name="Великое зелье Стойкости";
                      }
                      if ($el==4) {
                        $price=2;
                        $mfdmag=75;
                        $at="mag";
                        $name="Великое зелье Отрицания";
                      }
                      if ($el==5) {
                        $price=3;
                        $mfdmag=50;
                        $mfdhit=50;
                        $name="Зелье Хозяина Канализации";
                      }
                      if ($el==6) {
                        $price=4;
                        $mfdhit=100;
                        $at="hit";
                        $name="Нектар Неуязвимости";
                      }
                      if ($el==7) {
                        $price=4;
                        $mfdmag=100;
                        $at="mag";
                        $name="Нектар Отрицания";
                      }
                      if ($user["money"]<$price) {
                        echo "<font color=red><b>Недостаточно денег в наличии.</b></font>";
                      } else {
                        $cond="";
                        if (@$mfdhit && !@$mfdmag) $cond.=" and mfdhit>0 and mfdmag=0 ";
                        elseif (@$mfdmag && !@$mfdhit) $cond.=" and mfdmag>0 and mfdhit=0 ";
                        elseif (@$mfdmag && @$mfdhit) $cond.=" and mfdmag>0 and mfdhit>0 ";
                        $el=mqfa("SELECT id, name, time from effects WHERE owner=$user[id] $cond and type=188");
                        if ($el) {
                          //mq("update effects set time=".(60*60*6+time())." where id='$el[id]'");
                          if ($el["name"]!=$name) {
                            mq("update effects set name='$name', mfdhit='$mfdhit', mfdmag='$mfdmag' where id='$el[id]'");
                          }
                          mq("update users set money=money-$price where id='$user[id]'");
                          echo "<b>Вы выпили кружку зелья.</b><br>";
                          /*} else {
                            echo "<font color=red><b>Ещё не прошло действие старого эликсира.</b></font><br>";
                          }*/
                          updeffect($user["id"], $el, 60*60*6, array("name"=>$name, "mfd$at"=>1), ($_GET["el"]==5?0:1));
                        } else {
                          mq("insert into `effects` (`owner`,`name`,`time`,`type`, mfdhit, mfdmag) values ('".$user['id']."','$name',".(time()+(60*60*6)).",188, '$mfdhit', '$mfdmag')");
                          mq("update users set money=money-$price where id='$user[id]'");
                          echo "<b>Вы выпили кружку зелья.</b>";
                        }
                        if ($at) mq("delete from effects where owner='$user[id]' and type=".ADDICTIONEFFECT." and mfd$at<0");
                      }
                    } elseif (@$_GET["el"]) echo "<b><font color=red>Харчевня работает только для владельцев замка</font></b><br>";
                    echo "Лучшие напитки по лучшим ценам только для владельцев замка без каких-либо ограничений. На вынос не продаются.<div>&nbsp;</div>
                    <table align=\"center\">
                    <tr><td align=\"center\">1 кр.<br>
                    <a href=\"castle.php?el=1&".time()."\"><img border=\"0\" src=\"".IMGBASE."/i/sh/pot_base_50_damageproof.gif\"></a>
                    </td><td align=\"center\">1 кр.<br>
                    <a href=\"castle.php?el=2&".time()."\"><img border=\"0\" src=\"".IMGBASE."/i/sh/pot_base_50_magicproof.gif\"></a>
                    </td><td align=\"center\">2 кр.<br>
                    <a href=\"castle.php?el=3&".time()."\"><img border=\"0\" src=\"".IMGBASE."/i/sh/pot_base_200_alldmg2.gif\"></a></td>
                    <td align=\"center\">2 кр.<br>
                    <a href=\"castle.php?el=4&".time()."\"><img border=\"0\" src=\"".IMGBASE."/i/sh/pot_base_200_allmag2.gif\"></a></td>
                    <td align=\"center\">3 кр.<br>
                    <a href=\"castle.php?el=5&".time()."\"><img border=\"0\" src=\"".IMGBASE."/i/sh/pot_base_0_ny1.gif\"></a></td>
                    <td align=\"center\">4 кр.<br>
                    <a href=\"castle.php?el=6&".time()."\"><img border=\"0\" src=\"".IMGBASE."/i/sh/pot_base_200_alldmg3.gif\"></a>
                    </td><td align=\"center\">4 кр.<br>
                    <a href=\"castle.php?el=7&".time()."\"><img border=\"0\" src=\"".IMGBASE."/i/sh/pot_base_200_allmag3.gif\"></a></td></tr></table>";
                  }
                  echo "</div>";
                } elseif ($user["room"]==721) {
                  echo "<div style=\"width:600px\">";
                  if ($siege<10) {
                    echo "<center><br><b>Не стоит во время осады заниматься сбором трав.</b></center>";
                  } else {
                    if (@$_GET["findgrass"] && $user["klan"]==$castleowner && $user["klan"]) {                      
                      echo cutgrass(6);
                      echo "</div><br>";
                    } elseif (@$_GET["findgrass"]) echo "<b><font color=red>Траву могут срезать только владельцы замка</font></b><br>";
                    echo "<div style=\"width:600px\">Тут растёт множество разных алхимических трав, которые владельцы замка могут использовать для своих нужд,
                    Однако предназначение многих трав забыто или ещё не изучено, поэтому найти необходимую траву обычно не так просто.<br><br>
                    <center><a href=\"castle.php?findgrass=1&".time()."\">Срезать траву</a></center>";
                  }
                  echo "</div>";
                } else {
                  echo "<img src=\"".IMGBASE."/i/rooms/$user[room].gif\" alt=\"\" border=\"1\"/>";
                }
              ?>
              </div></td></tr>

                <tr><td align="right"><div align="right" id="btransfers"><table cellpadding="0" cellspacing="0" border="0" id="bmoveto">
                <tr><td bgcolor="#D3D3D3">

                </td>
                </tr>
                </table></div></td></tr>

            </table>

            </td>
        <td>

            <table width="80" border="0" cellspacing="0" cellpadding="0">
                <tr>

                    <td><table width="80"  border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td colspan="3" align="center"><img src="i/move/navigatin_46.gif" width="80" height="4" /></td>
                            </tr>
                        <tr>
                            <td colspan="3" align="center"><table width="80"  border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td><img src="i/move/navigatin_48.gif" width="9" height="8" /></td>
                                        <td width="100%" bgcolor="#000000"><table border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td nowrap="nowrap" align="center"><div align="center" style="font-size:4px;padding:0px;border:solid black 0px; text-align:center" id="prcont"></div>
                                                            <script language="javascript" type="text/javascript">
                                                var s="";for (i=1; i<=32; i++) {s+='<span id="progress'+i+'">&nbsp;</span>';if (i<32) {s+='&nbsp;'};}document.getElementById('prcont').innerHTML=s;
                                                </script>
                                                        </td>
                                                    </tr>
                                                </table></td>
                                        <td><img src="i/move/navigatin_50.gif" width="7" height="8" /></td>
                                        </tr>
                                    </table></td>
                            </tr>
    <tr>                                         
        <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td><img src="i/move/navigatin_51.gif" width="31" height="8" /></td>
                </tr>
                <tr>
                    <td><img src="i/move/navigatin_54.gif" width="9" height="20" /><img src="i/move/navigatin_55i.gif" width="22" height="20" border="0" /></td>
                </tr>
                <tr>
                    <td><a onclick="return check('m7');" <?if($routes[$user['room']][0]) { echo 'id="m7"';}?> href="?path=1&<?=time()?>"><img src="i/move/navigatin_59<?if(!$routes[$user['room']][0]) { echo 'i';}?>.gif" width="21" height="20" border="0" o<?if(!$routes[$user['room']][0]) { echo 'i';}?>nmousemove="fastshow2('<?=$rooms[$routes[$user['room']][0]]?>');" onmouseout="hideshow();" /></a><img src="i/move/navigatin_60.gif" width="10" height="20" border="0" /></td>
                </tr>
                <tr>
                    <td><img src="i/move/navigatin_63.gif" width="11" height="21" /><img src="i/move/navigatin_64i.gif" width="20" height="21" border="0" /></td>
                </tr>
                <tr>
                    <td><img src="i/move/navigatin_68.gif" width="31" height="8" /></td>
                </tr>
        </table></td>
        <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td><a onclick="return check('m1');" <?if($routes[$user['room']][1]) { echo 'id="m1"';}?> href="?path=2&<?=time()?>"><img src="i/move/navigatin_52<?if(!$routes[$user['room']][1]) { echo 'i';}?>.gif" width="19" height="22" border="0" <?if(!$routes[$user['room']][1]) { echo 'i';}?>onmousemove="fastshow2('<?=$rooms[$routes[$user['room']][1]]?>');" onmouseout="hideshow();" /></a></td>
                </tr>
                <tr>
                    <td><a href="?<?=time()?>"><img src="i/move/navigatin_58.gif" width="19" height="33" border="0" o nmousemove="fastshow2('<strong>Обновить</strong><br />Переходы:<br />Картинная галерея 1<br />Зал ораторов<br />Картинная галерея 3');" onmouseout="hideshow();" /></a></td>
                </tr>
                <tr>
                    <td><a onclick="return check('m5');" <?if($routes[$user['room']][3]) { echo 'id="m5"';}?> href="?path=4&<?=time()?>"><img src="i/move/navigatin_67<?if(!$routes[$user['room']][3]) { echo 'i';}?>.gif" width="19" height="22" border="0" <?if(!$routes[$user['room']][3]) { echo 'i';}?>onmousemove="fastshow2('<?=$rooms[$routes[$user['room']][3]]?>');" onmouseout="hideshow();" /></a></td>
                </tr>
        </table></td>
        <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td><img src="i/move/navigatin_53.gif" width="30" height="8" /></td>
                </tr>
                <tr>
                    <td><img src="i/move/navigatin_56i.gif" width="21" height="20" border="0" /><img src="i/move/navigatin_57.gif" width="9" height="20" /></td>
                </tr>
                <tr>
                    <td><img src="i/move/navigatin_61.gif" width="8" height="21" /><a onclick="return check('m3');" <?if($routes[$user['room']][2]) { echo 'id="m3"';}?> href="?&path=3&<?=time()?>"><img src="i/move/navigatin_62<?if(!$routes[$user['room']][2]) { echo 'i';}?>.gif" width="22" height="21" border="0" <?if(!$routes[$user['room']][2]) { echo 'i';}?>onmousemove="fastshow2('<? if ($routes[$user['room']][2]) echo $rooms[$routes[$user['room']][2]] ?>');" onmouseout="hideshow();" /></a></td>
                </tr>
                <tr>
                    <td><img src="i/move/navigatin_65i.gif" width="21" height="20" border="0" /><img src="i/move/navigatin_66.gif" width="9" height="20" /></td>
                </tr>
                <tr>
                    <td><img src="i/move/navigatin_69.gif" width="30" height="8" /></td>
                </tr>
        </table></td>
    </tr>

                    </table></td>
                </tr>
            </table>

            <table  border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td nowrap="nowrap" id="moveto">
                        <table width="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#DEDEDE">

                        </table>
                    </td>
                </tr>
            </table>

            <!-- <br /><span class="menutop"><nobr>Картинная галерея 2</nobr></span>-->
            </td>
    </tr>
</table>
<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px; white-space: nowrap;"></div>
<script language="javascript" type="text/javascript">
var progressEnd = 32;       // set to number of progress <span>'s.
var progressColor = '#00CC00';  // set to progress bar color
var mtime = parseInt('<?=($user['movetime']-time())?>');
if (!mtime || mtime<=0) {mtime=0;}
var progressInterval = Math.round(mtime*1000/progressEnd);  // set to time between updates (milli-seconds)
var is_accessible = true;
var progressAt = progressEnd;
var progressTimer;
function progress_clear() {
    for (var i = 1; i <= progressEnd; i++) document.getElementById('progress'+i).style.backgroundColor = 'transparent';
    progressAt = 0;

    for (var t = 1; t <= 8; t++) {
        if (document.getElementById('m'+t) ) {
            var tempname = document.getElementById('m'+t).children[0].src;
            if (tempname.match(/b\.gif$/)) {
                    document.getElementById('m'+t).children[0].id = 'backend';
            }
            var newname;
            newname = tempname.replace(/(b)?\.gif$/,'i.gif');
            document.getElementById('m'+t).children[0].src = newname;
        }
    }

    is_accessible = false;
    set_moveto(true);
}
function progress_update() {
    progressAt++;
    //if (progressAt > progressEnd) progress_clear();
    if (progressAt > progressEnd) {

        for (var t = 1; t <= 8; t++) {
            if (document.getElementById('m'+t) ) {
                var tempname = document.getElementById('m'+t).children[0].src;
                var newname;
                newname = tempname.replace(/i\.gif$/,'.gif');
                if (document.getElementById('m'+t).children[0].id == 'backend') {
                    tempname = newname.replace(/\.gif$/,'b.gif');
                    newname = tempname;
                }
                document.getElementById('m'+t).children[0].src = newname;
            }
        }

        is_accessible = true;
        if (window.solo_store && solo_store) { solo(solo_store); } // go to stored
        set_moveto(false);
    } else {document.getElementById('progress'+progressAt).style.backgroundColor = progressColor;
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
// brrr
if (mtime>0) {
    progress_clear();
    progress_update();
} else {
    for (var i = 1; i <= progressEnd; i++) {
        document.getElementById('progress'+i).style.backgroundColor = progressColor;
    }
}
</script>

</TD>
</TR>
</TABLE>
<!--<BR>Всего живых участников на данный момент: <B><?
    echo "<B>".($ls[0]-$ls[1])."</B> + <B>".$ls[1]."</B>";
?></B>...<BR>-->
<div id=hint3 class=ahint></div>
<script>top.onlineReload(true)</script>
</BODY>
</HTML>

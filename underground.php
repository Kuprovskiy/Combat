<?
  session_start();
  include "connect.php";
  include "functions.php";
  if ($user["room"]!=55 && $user["room"]!=57) {
    header("location: main.php");
    die;
  }
  if ($user["room"]==55) {
    $base=IMGBASE."/underdesigns/alchcave"; 
  } else {
    $base=IMGBASE."/underdesigns/crystalcave1"; 
  }
  //$base=".";
  if (@$_GET["move"] && $user["id"]!=99999) $_SESSION["movetime"]=time()+15;
  if (@$_GET["exit"]) {
    if ($user["room"]==55) gotoroom(54);
    else gotoroom(49);
  }
  if (!@$_GET["cavesize"]) $cs=$_SESSION["cavesize"];
  else $cs=$_GET["cavesize"];
  if ($cs!=1 && $cs!=2 && $cs!=3) $cs=1;
  define("CAVESIZE",$cs);
  if (CAVESIZE==2) $base="/underdesigns/crystalcavebig2";
  if (CAVESIZE==3) $base="/underdesigns/crystalcavebig3";
  $_SESSION["cavesize"]=$cs;
?>
<head>
<link rel=stylesheet type="text/css" href="/i/main.css">
<?
  if (@$_GET["cavesize"]) {
    if (CAVESIZE==1) $ht=600;
    elseif (CAVESIZE==2) $ht=730;
    else $ht=900;
    echo "<script>
    ch=parseInt(screen.height)-$ht;
    if (ch<90) ch=90;
    parent.document.getElementById('chatset').rows='*, '+ch+', 0';
    </script>";
  }
?>
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
  cursor:hand;
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

DIV.MoveLine{ width:<?
  if (CAVESIZE==1) echo 108;
  if (CAVESIZE==2) echo 162;
  if (CAVESIZE==3) echo 216;
?>px;height: 7px; size: 2px;font-size:2px; position: relative;overflow:hidden;}
IMG.MoveLine{ width:<?
  if (CAVESIZE==1) echo 108;
  if (CAVESIZE==2) echo 162;
  if (CAVESIZE==3) echo 216;
?>px;height: 7px;border:0px solid;position:absolute;left:0px;top:0px }
<?
  if (CAVESIZE==1) {$wd=352;$ht=240;}
  if (CAVESIZE==2) {$wd=528;$ht=360;}
  if (CAVESIZE==3) {$wd=704;$ht=480;}
?>
.cw1 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/cw1.gif)}
.cw2 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/cw2.gif)}
.cw3 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/cw3.gif)}
.cw4 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/cw4.gif)}
.cw5 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/cw5.gif)}

.lw0 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/lw0.gif)}
.lw1 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/lw1.gif)}
.lw2 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/lw2.gif)}
.lw3 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/lw3.gif)}
.lw4 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/lw4.gif)}

.rw0 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/rw0.gif)}
.rw1 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/rw1.gif)}
.rw2 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/rw2.gif)}
.rw3 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/rw3.gif)}
.rw4 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/rw4.gif)}

.lsw0 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/lsw0.gif)}
.lsw1 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/lsw1.gif)}
.lsw2 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/lsw2.gif)}
.lsw3 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/lsw3.gif)}
.lsw4 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/lsw4.gif)}
.lsw42 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/lsw42.gif)}

.rsw0 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/rsw0.gif)}
.rsw1 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/rsw1.gif)}
.rsw2 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/rsw2.gif)}
.rsw3 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/rsw3.gif)}
.rsw4 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/rsw4.gif)}
.rsw42 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/rsw42.gif)}

.lw42 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/lw42.gif)}
.rw42 {position:absolute;left:0px;top:0px;width:<?=$wd?>px;height:<?=$ht?>px;background-image:url(<?=$base?>/rw42.gif)}

.maptd {width:15px;height:15px}

</style>
</head>
<body style="margin:0px" bgcolor="#d7d7d7" onLoad="<?=topsethp()?>">
<?
  function drawmap($map1, $map2, $players) {
    global $base, $user;
    $x=$players[0]["x"];
    $y=$players[0]["y"];
    $startx=max($x*2-8,0);
    $starty=max($y*2-8,0);
    $direction=$players[0]["direction"];
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
          else $sq=(int)$map1[$y1][$x1];
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
          else $sq=(int)$map1[$y1][$x1];
          $map[$y0][$x0]=$sq;
          $x1+=$dx;
          $x0++;
        }
        $y0++;
        $y1+=$dy;
      }
    }

    $ret="<div style=\"width:";
    if (CAVESIZE==1) $ret.="530px;height:260px;";
    if (CAVESIZE==2) $ret.="795px;height:390px;";
    if (CAVESIZE==3) $ret.="1060px;height:520px;";
    $ret.="background-image:url($base/podzem.jpg);background-repeat:no-repeat;overflow:hidden\">
    <table cellspacing=0 cellpadding=0><tr><td style=\"";
    if (CAVESIZE==1) $ret.="padding-left:10px;padding-top:10px";
    if (CAVESIZE==2) $ret.="padding-left:15px;padding-top:15px";
    if (CAVESIZE==3) $ret.="padding-left:20px;padding-top:20px";
    $ret.="\">
      <div style=\"position:relative;";
      if (CAVESIZE==1) $ret.="width:354px;height:239px;";
      if (CAVESIZE==2) $ret.="width:531px;height:359px;";
      if (CAVESIZE==3) $ret.="width:708px;height:478px;";
      $ret.="overflow:hidden;\">";

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
        if ($map[-1][6]) $ret.="<img width=\"37\" height=\"78\" src=\"/i/dungeon/mobs/".$map[-1][6].".gif\" style=\"position:absolute;left:-20px;top:60px\">";
      }
      $wall=$i*2-1;
      $sidewall=$i*2;
      if ($map[1][$sidewall] && $i>0) {
        if ($map[1][$sidewall]<10000) {
          if ($i==1) $ret.="<img width=\"86\" height=\"157\" src=\"/i/dungeon/mobs/".$map[1][$sidewall].".gif\" style=\"position:absolute;left:-5px;top:40px\">";
          if ($i==2) $ret.="<img width=\"61\" height=\"112\" src=\"/i/dungeon/mobs/".$map[1][$sidewall].".gif\" style=\"position:absolute;left:35px;top:55px\">";
          if ($i==3) $ret.="<img width=\"44\" height=\"94\" src=\"/i/dungeon/mobs/".$map[1][$sidewall].".gif\" style=\"position:absolute;left:55px;top:50px\">";
        } elseif (CAVESIZE==1) {
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
        if ($map[5][$sidewall]<10000) {
          if ($i==1) $ret.="<img width=\"86\" height=\"157\" src=\"/i/dungeon/mobs/".$map[5][$sidewall].".gif\" style=\"position:absolute;left:260px;top:40px\">";
          if ($i==2) $ret.="<img width=\"61\" height=\"112\" src=\"/i/dungeon/mobs/".$map[5][$sidewall].".gif\" style=\"position:absolute;left:270px;top:55px\">";
          if ($i==3) $ret.="<img width=\"44\" height=\"94\" src=\"/i/dungeon/mobs/".$map[5][$sidewall].".gif\" style=\"position:absolute;left:250px;top:50px\">";
        } elseif (CAVESIZE==1)  {
          $o=$map[5][$sidewall]-10000;
          if ($o==4) {
            if ($i==1) $ret.="<img width=\"106\" height=\"101\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:302px;top:90px\">";
            if ($i==2) $ret.="<img width=\"86\" height=\"84\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:137px;top:90px\">";
            if ($i==3) $ret.="<img width=\"65\" height=\"63\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:152px;top:87px\">";
          } else {
            if ($i==1) $ret.="<img width=\"65\" height=\"80\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:320px;top:90px\">";
            if ($i==2) $ret.="<img width=\"43\" height=\"56\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:300px;top:90px\">";
            if ($i==3) $ret.="<img width=\"32\" height=\"40\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:317px;top:100px\">";
          }
        }
      }
      if ($map[1][$wall]) $ret.="<div class=\"lw$i\"></div>";
      if($map[2][$sidewall]) $ret.="<div class=\"lsw$i\"></div>";
      if($map[4][$sidewall]) $ret.="<div class=\"rsw$i\"></div>";
      if ($map[5][$wall]) $ret.="<div class=\"rw$i\"></div>";
      if ($map[3][$sidewall] && $i>0 && $sidewall<$centerwall) {
        if ($map[3][$sidewall]<10000) {        
          if ($i==1) $ret.="<img width=\"120\" height=\"220\" src=\"/i/dungeon/mobs/".$map[3][$sidewall].".gif\" style=\"position:absolute;left:127px;top:0px\">";
          if ($i==2) $ret.="<img width=\"80\" height=\"145\" src=\"/i/dungeon/mobs/".$map[3][$sidewall].".gif\" style=\"position:absolute;left:147px;top:35px\">";
          if ($i==3) $ret.="<img width=\"60\" height=\"110\" src=\"/i/dungeon/mobs/".$map[3][$sidewall].".gif\" style=\"position:absolute;left:157px;top:40px\">";
        } elseif (CAVESIZE==1) {
          $o=$map[3][$sidewall]-10000;
          if ($o==4) {
            if ($i==1) $ret.="<img width=\"130\" height=\"126\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:112px;top:80px\">";
            if ($i==2) $ret.="<img width=\"86\" height=\"84\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:137px;top:90px\">";
            if ($i==3) $ret.="<img width=\"65\" height=\"63\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:147px;top:87px\">";
          } else {
            if ($i==1) $ret.="<img width=\"65\" height=\"80\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:157px;top:110px\">";
            if ($i==2) $ret.="<img width=\"43\" height=\"56\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:157px;top:90px\">";
            if ($i==3) $ret.="<img width=\"32\" height=\"40\" src=\"/i/dungeon/objects/$o.gif\" style=\"position:absolute;left:157px;top:100px\">";
          }
        }
      }
      if ($map[3][$wall]) {
        $ret.="<div class=\"cw$i\"></div>";
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
    <div style=\"height:116px\">
    <div style=\"";
    if (CAVESIZE==1) $ret.="padding-top:11px;padding-left:32px";
    if (CAVESIZE==2) $ret.="padding-top:18px;padding-left:50px";
    if (CAVESIZE==3) $ret.="padding-top:25px;padding-left:65px";
    $ret.="\">
    <DIV class=\"MoveLine\"><IMG src=\"http://www.virt-life.com/i/move/wait3.gif\" id=\"MoveLine\" class=\"MoveLine\"></DIV>
    <div style=\"visibility:hidden; height:0px\" id=\"moveto\">0</div>
    </div>
    </div>
    <div style=\"";
    if (CAVESIZE==1) $ret.="margin-left:20px;";
    if (CAVESIZE==2) $ret.="margin-left:60px;top:80px;";
    if (CAVESIZE==3) $ret.="margin-left:90px;top:110px;";
    $ret.="position:relative\">";
    foreach ($players as $k=>$v) {
      if ($v["x"]-($startx/2)>=0 && $v["x"]-($startx/2)<=8 && $v["y"]-($starty/2)>=0 && $v["y"]-($starty/2)<=8) {
        $ret.="<img style=\"position:absolute;left:".(($v["x"]-($startx/2))*15+3)."px;top:".(($v["y"]-($starty/2))*15+3)."px\" src=\"/i/dungeon/".($k+1)."$v[direction].gif\">";
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
    
    if (CAVESIZE==1) $max=32;
    if (CAVESIZE==2) $max=48;
    if (CAVESIZE==3) $max=64;

    $ret.="<div align=\"center\" style=\"position:absolute; left:389px; top:10px; font-size:6px;padding:0px;border:solid black 0px; text-align:center\" id=\"prcont\">
    <script language=\"javascript\" type=\"text/javascript\">
    var s=\"\";for (i=1; i<=$max; i++) {s+='<span id=\"progress'+i+'\">&nbsp;</span>';if (i<$max) {s+='&nbsp;'};}document.getElementById('prcont').innerHTML=s;
    </script></div>";
    /*foreach ($map as $k=>$v) {
      echo $k;print_r($v);
      echo "<br>";
    }*/
    if ($direction==0) {
      $forwardlink="?x=".($x-1)."&y=$y&direction=$direction&move=1";
      $backlink="?x=".($x+1)."&y=$y&direction=$direction&move=1";
      $leftlink="?y=".($y+1)."&x=$x&direction=$direction&move=1";
      $rightlink="?y=".($y-1)."&x=$x&direction=$direction&move=1";
    }
    if ($direction==2) {
      $forwardlink="?x=".($x+1)."&y=$y&direction=$direction&move=1";
      $backlink="?x=".($x-1)."&y=$y&direction=$direction&move=1";
      $leftlink="?y=".($y-1)."&x=$x&direction=$direction&move=1";
      $rightlink="?y=".($y+1)."&x=$x&direction=$direction&move=1";
    }
    if ($direction==1) {
      $forwardlink="?y=".($y-1)."&x=$x&direction=$direction&move=1";
      $backlink="?y=".($y+1)."&x=$x&direction=$direction&move=1";
      $leftlink="?x=".($x-1)."&y=$y&direction=$direction&move=1";
      $rightlink="?x=".($x+1)."&y=$y&direction=$direction&move=1";
    }
    if ($direction==3) {
      $forwardlink="?y=".($y+1)."&x=$x&direction=$direction&move=1";
      $backlink="?y=".($y-1)."&x=$x&direction=$direction&move=1";
      $leftlink="?x=".($x+1)."&y=$y&direction=$direction&move=1";
      $rightlink="?x=".($x-1)."&y=$y&direction=$direction&move=1";
    }
    if (!$map[3][1]) {
      $ret.="<div style='position:absolute;";
      if (CAVESIZE==1) $ret.="left:430px;top:37px;";
      if (CAVESIZE==2) $ret.="left:645px;top:57px;";
      if (CAVESIZE==3) $ret.="left:860px;top:75px;";
      $ret.="'><a onClick=\"return check('m1');\" id=\"m1\" href=\"$forwardlink\"><img src=\"/i/dungeon/forward".CAVESIZE.".gif\"  border=\"0\" /></a></div>";
    }
    if (!$map[3][-1]) {
      $ret.="<div style='position:absolute;";
      if (CAVESIZE==1) $ret.="left:430px;top:83px;";
      if (CAVESIZE==2) $ret.="left:645px;top:126px;";
      if (CAVESIZE==3) $ret.="left:865px;top:166px";
      $ret.="'><a onClick=\"return check('m5');\" id=\"m5\" href=\"$backlink\"><img src=\"/i/dungeon/back".CAVESIZE.".gif\" border=\"0\" /></a></div>";
    }
    if (!$map[2][0]) {
      $ret.="<div style='position:absolute;";
      if (CAVESIZE==1) $ret.="left:383px;top:48px;";
      if (CAVESIZE==2) $ret.="left:572px;top:75px;";
      if (CAVESIZE==3) $ret.="left:763px;top:98px;";
      $ret.="'><a onClick=\"return check('m7');\" id=\"m7\" href=\"$leftlink\"><img src=\"/i/dungeon/left".CAVESIZE.".gif\" border=\"0\" /></a></div>";
    }
    if (!$map[4][0]) {
      $ret.="<div style='position:absolute;";
      if (CAVESIZE==1) $ret.="left:492px;top:48px;";
      if (CAVESIZE==2) $ret.="left:737px;top:75px;";
      if (CAVESIZE==3) $ret.="left:980px;top:98px;";
      $ret.="'><a onClick=\"return check('m3');\" id=\"m3\" href=\"$rightlink\"><img src=\"/i/dungeon/right".CAVESIZE.".gif\" border=\"0\" /></a></div>";
    }

    $ret.="<div style='position:absolute;";
    if (CAVESIZE==1) $ret.="left:404px;top:37px;";
    if (CAVESIZE==2) $ret.="left:598px; top:58px;";
    if (CAVESIZE==3) $ret.="left:800px;top:75px;";
    $ret.="'><a href=\"?x=$x&y=$y&direction=".($direction==0?3:$direction-1)."\" title=\"Поворот налево\"><img src=\"/i/dungeon/turnleft".CAVESIZE.".gif\" border=\"0\" /></a></div>";

    $ret.="<div style='position:absolute;";
    if (CAVESIZE==1) $ret.="left:475px;top:37px;";
    if (CAVESIZE==2) $ret.="left:710px; top:60px;";
    if (CAVESIZE==3) $ret.="left:935px;top:75px;";
    $ret.="'><a href=\"?x=$x&y=$y&direction=".(($direction+1)%4)."\" title=\"Поворот направо\"><img src=\"/i/dungeon/turnright".CAVESIZE.".gif\" border=\"0\" /></a></div>";

    $ret.="<div style='position:absolute;";
    if (CAVESIZE==1) $ret.="left:433px;top:62px;";
    if (CAVESIZE==2) $ret.="left:646px;top:92px;";
    if (CAVESIZE==3) $ret.="left:863px;top:124px;";
    $ret.="'><a href=\"$_SERVER[PHP_SELF]\"><img src=\"/i/dungeon/ref".CAVESIZE.".gif\" border=\"0\"/></a></div>";

    $ret.="<TABLE><tr>
    <td nowrap=\"nowrap\" id=\"moveto\">
    </td></tr></TABLE>";
    $ret.="</div>";
    $ret.="<script language=\"javascript\" type=\"text/javascript\">
var progressEnd = ";
if (CAVESIZE==1) $ret.=108;
if (CAVESIZE==2) $ret.=162;
if (CAVESIZE==3) $ret.=216;
$ret.=";  // set to number of progress <span>'s.
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
if( !( progressAt % ".(1+CAVESIZE)." ) )
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
  if ($user["room"]==55) {
    $map=array(
    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,1,2,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,1,0,0,0,1,0,1,0,1,0,1,0,1,0,1,0,1,0,1,0,1,0,1,0,1,0,1,0,0),
    array(0,1,2,0,2,0,2,0,2,0,2,0,2,0,2,0,2,0,2,0,2,0,2,0,2,0,2,0,2,1,0),
    array(0,0,1,0,1,0,1,0,0,0,1,0,0,0,1,0,0,0,1,0,0,0,1,0,0,0,1,0,0,0,0),
    array(0,0,0,0,0,0,0,1,2,1,0,1,2,1,0,1,2,1,0,1,2,1,0,1,2,1,0,1,2,1,0),
    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,1,3,1,0,1,4,1,0,1,3,1,0,1,4,1,0,1,3,1,0,1,2,1,0),
    array(0,0,0,0,0,0,0,0,1,0,0,0,1,0,0,0,1,0,0,0,1,0,0,0,1,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,5,1,0),
    array(0,0,0,0,0,0,0,0,1,0,1,0,1,0,1,0,1,0,1,0,1,0,1,0,1,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,1,2,0,6,0,2,0,2,0,6,0,2,0,5,0,5,0,5,1,0,1,2,1,0),
    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,1,2,0,6,0,2,0,2,0,2,1,0,1,2,0,2,0,2,1,0,1,2,1,0),
    array(0,0,0,0,0,0,0,0,0,0,1,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0),
    array(0,0,0,0,0,0,0,1,2,1,6,1,6,1,2,0,2,1,0,1,2,0,2,0,2,0,5,0,2,1,0),
    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,1,0,0),
    array(0,0,0,0,0,0,0,1,2,1,6,1,6,1,2,0,2,1,0,1,2,0,2,0,2,1,0,0,0,0,0),
    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,1,2,1,2,1,2,1,2,0,2,1,0,1,2,0,2,0,2,1,0,0,0,0,0),
    array(0,0,1,0,1,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,1,0,1,0,0,0,0,0,0),
    array(0,1,7,0,2,0,2,0,6,0,2,0,2,0,2,0,2,1,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,1,0,1,0,1,0,1,0,1,0,1,0,1,0,0,0,1,0,1,0,1,0,1,0,1,0,0),
    array(0,1,2,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,7,0,2,0,2,0,2,0,2,1,0),
    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0),
    array(0,1,2,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,7,1,0,1,8,0,8,0,8,1,0),
    array(0,0,0,0,1,0,1,0,1,0,1,0,1,0,1,0,1,0,1,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,1,7,0,2,0,3,0,2,0,4,0,2,0,5,0,2,0,6,0,2,1,0,1,7,0,7,0,7,1,0),
    array(0,0,1,0,1,0,1,0,1,0,1,0,1,0,1,0,1,0,1,0,1,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,6,0,6,0,6,1,0),
    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,1,0,0),
    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,2,1,0,0,0),
    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0),
    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
  } else {
    $map=array(
    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,0,0,0,0,1,2,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,1,0,1,0,1,0,1,0,0,0,1,0,1,0,1,0,1,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,1,2,0,2,0,2,0,2,0,2,0,2,0,2,0,2,0,2,1,0,0,0,0,0,0,0,0,0),
    array(0,0,1,0,0,0,0,0,1,0,1,0,0,0,1,0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,0),
    array(0,1,'10003',0,2,0,2,1,0,0,0,1,2,1,0,0,0,1,2,0,2,0,'10003',1,0,0,0,0,0,0,0),
    array(0,0,1,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,1,0,0,0,0,0,0,0,0),
    array(0,0,0,1,2,1,0,0,0,0,0,1,2,1,0,0,0,0,0,1,2,1,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,1,2,1,0,0,0,0,0,1,2,1,0,0,0,0,0,1,2,1,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,1,0,0,0,1,0,0,0,1,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,1,2,0,2,1,0,1,2,0,2,0,2,1,0,1,2,0,2,1,0,0,0,0,0,0,0,0,0),
    array(0,0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,0),
    array(0,1,'10002',0,2,0,2,0,2,0,2,0,10004,0,2,0,2,0,2,0,2,0,'10002',1,0,0,0,0,0,0,0),
    array(0,0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,0),
    array(0,0,0,1,2,0,2,1,0,1,2,0,2,0,2,1,0,1,2,0,2,1,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,1,0,0,0,1,0,0,0,1,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,1,2,1,0,0,0,0,0,1,2,1,0,0,0,0,0,1,2,1,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,1,2,1,0,0,0,0,0,1,2,1,0,0,0,0,0,1,2,1,0,0,0,0,0,0,0,0,0),
    array(0,0,1,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,1,0,0,0,0,0,0,0,0),
    array(0,1,'10001',0,2,0,2,1,0,0,0,1,2,1,0,0,0,1,2,0,2,0,'10001',1,0,0,0,0,0,0,0),
    array(0,0,1,0,0,0,0,0,1,0,1,0,0,0,1,0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,0),
    array(0,0,0,1,2,0,2,0,2,0,2,0,2,0,2,0,2,0,2,0,2,1,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,1,0,1,0,1,0,1,0,0,0,1,0,1,0,1,0,1,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,0,0,0,0,1,2,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
  }
  if (@$_GET["x"]) $x=$_GET["x"]; elseif ($_SESSION["$user[room]x"]) $x=$_SESSION["$user[room]x"]; else {
    if ($user["room"]==55) $x=2;
    else $x=6;     
  }
  if (@$_GET["y"]) $y=$_GET["y"]; elseif ($_SESSION["$user[room]y"]) $y=$_SESSION["$user[room]y"]; else $y=1;
  if (isset($_GET["direction"])) $dir=$_GET["direction"]; elseif ($_SESSION["$user[room]direction"]) $dir=$_SESSION["$user[room]direction"]; else  $dir=3;
  $_SESSION["$user[room]x"]=$x;
  $_SESSION["$user[room]y"]=$y;
  $_SESSION["$user[room]direction"]=$dir;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td>&nbsp;</td>
    <td>
<div style="padding-left:30px">
<font style='font-size:14px; color:#8f0000'><b><?=$rooms[$user["room"]]?></b></font>&nbsp;&nbsp;&nbsp;&nbsp;
<font style='font-size:14px; color:#8f0000'><b></b></font>&nbsp;&nbsp;&nbsp;&nbsp;<a style="cursor:hand;" onclick="if (confirm('Вы уверены что хотите выйти?')) window.location='underground.php?exit=1'">&nbsp;<b style='font-size:14px; color:#000066;'>Выйти</b></a>
</div>
<?
  echo drawmap($map, $map2, array(array("x"=>$x, "y"=>$y, "direction"=>$dir)));
?>
</td>
    <td valign="top" align="left" width="440" style="padding-right:20px"><br><br>
<center><table width="440" border="0" cellspacing="1" cellpadding="0" bgcolor="#000000">
  <tr>
<td background="/img/bg_scroll_05.gif" align="center">
<a href=inf.php?7 target=_blank title="Информация о <?=$user["login"]?>"><?=$user["login"]?></a> [<?=$user["level"]?>]<a href='inf.php?<?=$user["id"]?>' target='_blank'><img src='/i/inf.gif' border=0></a></td>
<td background="/img/bg_scroll_05.gif" align="center"><?=$user["hp"]?>/<?=$user["maxhp"]?></td>
<td background="/img/bg_scroll_05.gif" nowrap style="font-size:9px" style="position: relative">
<table cellspacing="0" cellpadding="0" style='line-height: 1;padding-top:5px;'><td nowrap style="font-size:9px" style="position: relative"><SPAN id="HP" style='position: absolute; left: 5; z-index: 1; font-weight: bold; color: #FFFFFF'></SPAN><img src="/i/misc/bk_life_loose.gif" alt="Уровень жизни" name="HP1" width="1" height="9" id="HP1"><img src="/i/misc/bk_life_loose.gif" alt="Уровень жизни" name="HP2" width="1" height="9" id="HP2"></td></table></td>
<td background="/img/bg_scroll_05.gif" align="center"></td>
<td background="/img/bg_scroll_05.gif" align="center"><IMG alt="Лидер группы" src="/i/misc/lead1.gif" width=24 height=15><A href="#" onClick="findlogin( 'Выберите персонажа которого хотите выгнать','canalizaciya.php', 'kill')"><IMG alt="Выгнать супостата" src="/img/podzem/ico_kill_member1.gif" WIDTH="14" HEIGHT="17"></A>&nbsp;<A href="#" onClick="findlogin( 'Выберите персонажа которому хотите передать лидерство','underground.php', 'change')"><IMG alt="Новый царь" src="/img/podzem/ico_change_leader1.gif" WIDTH="14" HEIGHT="17"></A></td>
</tr></table></center>
<br><form action="underground.php">
<center>
Размер экрана: <select name="cavesize" onchange="this.form.submit();">
<option value="1" <? if ($cs==1) echo "selected"; ?>>Стандартный размер</option>
<option value="2" <? if ($cs==2) echo "selected"; ?>>Полуторный размер</option>
<option value="3" <? if ($cs==3) echo "selected"; ?>>Двойной размер</option>
</select>
</center>
</form>
    </td>
</tr></table>
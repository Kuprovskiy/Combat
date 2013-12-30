<?
$Loca=$mesto;
if($mesto<0){$Loca=0;}
if($mesto=="01"){$Loca=1;}
if($mesto=="02"){$Loca=2;}
if($mesto=="03"){$Loca=3;}
if($mesto=="04"){$Loca=4;}
if($mesto=="05"){$Loca=5;}
if($mesto=="06"){$Loca=6;}
if($mesto=="07"){$Loca=7;}
if($mesto=="08"){$Loca=8;}
if($mesto=="09"){$Loca=9;}

$ferrr = mysql_query("SELECT n$Loca FROM podzem3 WHERE glava='$glava' and name='".$mir['name']."'");


if($retr = mysql_fetch_array($ferrr)){
$stloc = $retr["n$Loca"];
}

if ($user['id'] == 7) echo $stloc;

if ($stloc[0]=="i") {
  $tmp=explode("-", $stloc);
  $i=0;
  echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
  foreach ($tmp as $k=>$v) {
    $i++;
    if ($i==1) continue;
    $rec=mqfa("select img, name from smallitems where id='$v'");
    echo "&nbsp;<a href=\"?take=$v\"><img src=\"".IMGBASE."/i/sh/$rec[img]\" width=\"60\" border=\"0\" height=\"60\" alt=\"$rec[name]\"></a>";
  }
}

if($stloc=='511' and $mir['name']=='Ледяная пещера'){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=gaika"><img src="'.IMGBASE.'/img/podzem/carrot.gif" width="60" border="0" height="60" alt="Морковка"></a>';
}


if($stloc=='503' and $mir['name']=='Канализация 1 этаж'){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=gaika"><img src="'.IMGBASE.'/img/podzem/g.gif" width="60" border="0" height="60" alt="Гайка"></a>';
print'&nbsp;<a href="?sun=gaika"><img src="'.IMGBASE.'/img/podzem/g.gif" width="60" border="0" height="60" alt="Гайка"></a>';
print'&nbsp;<a href="?sun=gaika"><img src="'.IMGBASE.'/img/podzem/g.gif" width="60" border="0" height="60" alt="Гайка"></a>';
}
if($stloc=='502' and $mir['name']=='Канализация 1 этаж'){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=gaika"><img src="'.IMGBASE.'/img/podzem/g.gif" width="60" border="0" height="60" alt="Гайка"></a>';
print'&nbsp;<a href="?sun=gaika"><img src="'.IMGBASE.'/img/podzem/g.gif" width="60" border="0" height="60" alt="Гайка"></a>';
}
if($stloc=='501' and $mir['name']=='Канализация 1 этаж'){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=gaika"><img src="'.IMGBASE.'/img/podzem/g.gif" width="60" border="0" height="60" alt="Гайка"></a>';
}

if($stloc=='506' and $mir['name']=='Канализация 1 этаж'){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=ventil"><img src="'.IMGBASE.'/img/podzem/v.gif" width="60" border="0" height="60" alt="Вентиль"></a>';
print'&nbsp;<a href="?sun=ventil"><img src="'.IMGBASE.'/img/podzem/v.gif" width="60" border="0" height="60" alt="Вентиль"></a>';
print'&nbsp;<a href="?sun=ventil"><img src="'.IMGBASE.'/img/podzem/v.gif" width="60" border="0" height="60" alt="Вентиль"></a>';
}
if($stloc=='505' and $mir['name']=='Канализация 1 этаж'){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=ventil"><img src="'.IMGBASE.'/img/podzem/v.gif" width="60" border="0" height="60" alt="Вентиль"></a>';
print'&nbsp;<a href="?sun=ventil"><img src="'.IMGBASE.'/img/podzem/v.gif" width="60" border="0" height="60" alt="Вентиль"></a>';
}
if($stloc=='504' and $mir['name']=='Канализация 1 этаж'){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=ventil"><img src="'.IMGBASE.'/img/podzem/v.gif" width="60" border="0" height="60" alt="Вентиль"></a>';
}


if($stloc=='509' and $mir['name']=='Канализация 1 этаж'){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=bolt"><img src="'.IMGBASE.'/img/podzem/bolt.gif" width="60" border="0" height="60" alt="Болт"></a>';
print'&nbsp;<a href="?sun=bolt"><img src="'.IMGBASE.'/img/podzem/bolt.gif" width="60" border="0" height="60" alt="Болт"></a>';
print'&nbsp;<a href="?sun=bolt"><img src="'.IMGBASE.'/img/podzem/bolt.gif" width="60" border="0" height="60" alt="Болт"></a>';
}
if($stloc=='508' and $mir['name']=='Канализация 1 этаж'){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=bolt"><img src="'.IMGBASE.'/img/podzem/bolt.gif" width="60" border="0" height="60" alt="Болт"></a>';
print'&nbsp;<a href="?sun=bolt"><img src="'.IMGBASE.'/img/podzem/bolt.gif" width="60" border="0" height="60" alt="Болт"></a>';
}
if($stloc=='507' and $mir['name']=='Канализация 1 этаж'){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=bolt"><img src="'.IMGBASE.'/img/podzem/bolt.gif" width="60" border="0" height="60" alt="Болт"></a>';
}



if($stloc=='510' and $mir['name']=='Канализация 1 этаж'){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=kluchiik"><img src="'.IMGBASE.'/img/podzem/kluchik.gif" width="60" border="0" height="60" alt="Ключиик"></a>';
}
if($Location == '29' and $mir['name']=='Канализация 1 этаж'){
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '404',`online`.`room` = '404' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
print "<script>location.href='shop_luka.php'</script>";
exit;
}
////////////////////////2 etaz///////////////////////////
if(($stloc=='609' || $stloc=='603') and $mir['name']=='Канализация 2 этаж'){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=se_gaika_c"><img src="'.IMGBASE.'/img/podzem/g_c.gif" width="60" border="0" height="60" alt="Чистая гайка"></a>';
print'&nbsp;<a href="?sun=se_gaika_c"><img src="'.IMGBASE.'/img/podzem/g_c.gif" width="60" border="0" height="60" alt="Чистая гайка"></a>';
print'&nbsp;<a href="?sun=se_gaika_c"><img src="'.IMGBASE.'/img/podzem/g_c.gif" width="60" border="0" height="60" alt="Чистая гайка"></a>';
}
if(($stloc=='608' || $stloc=='602') and $mir['name']=='Канализация 2 этаж'){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=se_gaika_c"><img src="'.IMGBASE.'/img/podzem/g_c.gif" width="60" border="0" height="60" alt="Чистая гайка"></a>';
print'&nbsp;<a href="?sun=se_gaika_c"><img src="'.IMGBASE.'/img/podzem/g_c.gif" width="60" border="0" height="60" alt="Чистая гайка"></a>';
}
if(($stloc=='607' || $stloc=='601') and $mir['name']=='Канализация 2 этаж'){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=se_gaika_c"><img src="'.IMGBASE.'/img/podzem/g_c.gif" width="60" border="0" height="60" alt="Чистая гайка"></a>';
}
if(($stloc=='606') and ($mir['name']=='Канализация 2 этаж' || $mir['name']=='Канализация 3 этаж')){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=se_gaika_bd"><img src="'.IMGBASE.'/img/podzem/bolt_d.gif" width="60" border="0" height="60" alt="Длинный болт"></a>';
print'&nbsp;<a href="?sun=se_gaika_bd"><img src="'.IMGBASE.'/img/podzem/bolt_d.gif" width="60" border="0" height="60" alt="Длинный болт"></a>';
print'&nbsp;<a href="?sun=se_gaika_bd"><img src="'.IMGBASE.'/img/podzem/bolt_d.gif" width="60" border="0" height="60" alt="Длинный болт"></a>';
}
if(($stloc=='605') and ($mir['name']=='Канализация 2 этаж' || $mir['name']=='Канализация 3 этаж')){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=se_gaika_bd"><img src="'.IMGBASE.'/img/podzem/bolt_d.gif" width="60" border="0" height="60" alt="Длинный болт"></a>';
print'&nbsp;<a href="?sun=se_gaika_bd"><img src="'.IMGBASE.'/img/podzem/bolt_d.gif" width="60" border="0" height="60" alt="Длинный болт"></a>';
}
if(($stloc=='604') and ($mir['name']=='Канализация 2 этаж' || $mir['name']=='Канализация 3 этаж')){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=se_gaika_bd"><img src="'.IMGBASE.'/img/podzem/bolt_d.gif" width="60" border="0" height="60" alt="Длинный болт"></a>';
}

if($stloc=='612' and $mir['name']=='Канализация 3 этаж'){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=se_gaika_rez"><img src="'.IMGBASE.'/img/podzem/g_r.gif" width="60" border="0" height="60" alt="Гайка с резьбой"></a>';
print'&nbsp;<a href="?sun=se_gaika_rez"><img src="'.IMGBASE.'/img/podzem/g_r.gif" width="60" border="0" height="60" alt="Гайка с резьбой"></a>';
print'&nbsp;<a href="?sun=se_gaika_rez"><img src="'.IMGBASE.'/img/podzem/g_r.gif" width="60" border="0" height="60" alt="Гайка с резьбой"></a>';
}
if($stloc=='611' and $mir['name']=='Канализация 3 этаж'){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=se_gaika_rez"><img src="'.IMGBASE.'/img/podzem/g_r.gif" width="60" border="0" height="60" alt="Гайка с резьбой"></a>';
print'&nbsp;<a href="?sun=se_gaika_rez"><img src="'.IMGBASE.'/img/podzem/g_r.gif" width="60" border="0" height="60" alt="Гайка с резьбой"></a>';
}
if($stloc=='610' and $mir['name']=='Канализация 3 этаж'){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=se_gaika_rez"><img src="'.IMGBASE.'/img/podzem/g_r.gif" width="60" border="0" height="60" alt="Гайка с резьбой"></a>';
}




if(($stloc=='612') and $mir['name']=='Канализация 2 этаж'){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=se_gaika_rv"><img src="'.IMGBASE.'/img/podzem/rv.gif" width="60" border="0" height="60" alt="Рабочий вентиль"></a>';
print'&nbsp;<a href="?sun=se_gaika_rv"><img src="'.IMGBASE.'/img/podzem/rv.gif" width="60" border="0" height="60" alt="Рабочий вентиль"></a>';
print'&nbsp;<a href="?sun=se_gaika_rv"><img src="'.IMGBASE.'/img/podzem/rv.gif" width="60" border="0" height="60" alt="Рабочий вентиль"></a>';
}
if(($stloc=='611') and ($mir['name']=='Канализация 2 этаж')){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=se_gaika_rv"><img src="'.IMGBASE.'/img/podzem/rv.gif" width="60" border="0" height="60" alt="Рабочий вентиль"></a>';
print'&nbsp;<a href="?sun=se_gaika_rv"><img src="'.IMGBASE.'/img/podzem/rv.gif" width="60" border="0" height="60" alt="Рабочий вентиль"></a>';
}
if(($stloc=='610') and ($mir['name']=='Канализация 2 этаж')){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=se_gaika_rv"><img src="'.IMGBASE.'/img/podzem/rv.gif" width="60" border="0" height="60" alt="Рабочий вентиль"></a>';
}
/////////////////////////////////////////////////////////
if($stloc=='615' and $mir['name']=='Канализация 3 этаж'){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=se_gaika_nb"><img src="'.IMGBASE.'/img/podzem/nb.gif" width="60" border="0" height="60" alt="Нужный болт"></a>';
print'&nbsp;<a href="?sun=se_gaika_nb"><img src="'.IMGBASE.'/img/podzem/nb.gif" width="60" border="0" height="60" alt="Нужный болт"></a>';
print'&nbsp;<a href="?sun=se_gaika_nb"><img src="'.IMGBASE.'/img/podzem/nb.gif" width="60" border="0" height="60" alt="Нужный болт"></a>';
}
if($stloc=='614' and $mir['name']=='Канализация 3 этаж'){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=se_gaika_nb"><img src="'.IMGBASE.'/img/podzem/nb.gif" width="60" border="0" height="60" alt="Нужный болт"></a>';
print'&nbsp;<a href="?sun=se_gaika_nb"><img src="'.IMGBASE.'/img/podzem/nb.gif" width="60" border="0" height="60" alt="Нужный болт"></a>';
}
if($stloc=='613' and $mir['name']=='Канализация 3 этаж'){echo'<font style="font-size:15px; color:#600"> <b>&nbsp;&nbsp;В комнате разбросаны вещи:</b></font><br>';
print'&nbsp;<a href="?sun=se_gaika_nb"><img src="'.IMGBASE.'/img/podzem/nb.gif" width="60" border="0" height="60" alt="Нужный болт"></a>';
}

?>

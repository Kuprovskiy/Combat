<?php
function smallshowpersout($id,$pas = 0,$battle = 0,$me = 0,$show_pr = 0) {
    global $mysql, $rooms;

    if($id > _BOTSEPARATOR_) {
      $bots = mysql_fetch_array(mysql_query ('SELECT * FROM `bots` WHERE `id` = '.$id.' LIMIT 1;'));
      $id=$bots['prototype'];
      $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
      $user['login'] = $bots['name'];
      $user['hp'] = $bots['hp'];
      $user['id'] = $bots['id'];
    } else {
      $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
    }

    echo "<CENTER>";
   if(!$battle){?>
    <A HREF="javascript:top.AddToPrivate('<?=$user['login']?>', top.CtrlPress)" target=refreshed><img src="i/lock.gif" width=20 height=15></A><?if($user['align']>0){echo"<img src=\"i/align_".$user['align'].".gif\">";} if ($user['klan'] <> '') { echo '<img title="'.$user['klan'].'" src="i/klan/'.$user['klan'].'.gif">'; } ?><B><?=$user['login']?></B> [<?=$user['level']?>]<a href=inf.php?<?=$user['id']?> target=_blank><IMG SRC=i/inf.gif WIDTH=12 HEIGHT=11 ALT="Инф. о <?=$user['login']?>"></a>
    <?}
        if ($user['block']) {
            echo "<BR><FONT class=private>Персонаж заблокирован!</font>";
        }
        if ($user['prison']) {
            echo "<BR><FONT class=private>Персонаж в заточении!</font>";
        }
        if ($user['bar']) {
            echo "<BR><FONT class=private>Пьянствует в баре!</font>";
        }
    ?>

    <TABLE cellspacing=0 cellpadding=0 style="  border-top-width: 1px;
    border-right-width: 1px;
    border-bottom-width: 1px;
    border-left-width: 1px;
    border-top-style: solid;
    border-right-style: solid;
    border-bottom-style: solid;
    border-left-style: solid;
    border-top-color: #FFFFFF;
    border-right-color: #666666;
    border-bottom-color: #666666;
    border-left-color: #FFFFFF;
    padding: 2px;">

<TR>
<TD>
<TABLE border=0 cellSpacing=1 cellPadding=0 width="100%" >
<TBODY>
<TR vAlign=top>
<TD>
<TABLE border=0 cellSpacing=0 cellPadding=0 width="100%">
<TBODY>

<TR><TD style="BACKGROUND-IMAGE:none">
<?php
    $invis = mysql_fetch_array(mysql_query("SELECT `time` FROM `effects` WHERE `owner` = '{$id}' and `type` = '1022' LIMIT 1;"));
    if($battle && $invis && $user['id'] != $_SESSION['uid']) {
        $user['level'] = '??';
        $user['login'] = '</a><b><i>невидимка</i></b>';
        $user['align'] = '0';
        $user['klan'] = '';
        $user['id'] = '';
        $user['hp'] = '??';
        $user['maxhp'] = '??';
        $user['mana'] = '??';
        $user['maxmana'] = '??';
        $user['sila'] ='??';
        $user['lovk'] ='??';
        $user['inta'] ='??';
        $user['vinos'] ='??';
/*      if ($user['level'] > 3) {
        $user['intel'] ='??';
        }
        if ($user['level'] > 6) {
        user['mudra'] ='??';
        }
        if ($user['level'] > 9) {
        $user['spirit'] ='??';
        }
        if ($user['level'] > 12) {
        $user['will'] ='??';
        }
        if ($user['level'] > 15) {
        $user['freedom'] ='??';
        }
        if ($user['level'] > 18) {
        $user['god'] ='??';
        } */
$showme = $user['id'];
if ($user['helm'] >=0) {
echo '<img src="i/helm.gif" width=60 height=60>';
}
?>
</TD></TR>

<TR><TD style="BACKGROUND-IMAGE:none">
<?php
if ($user['naruchi'] >=0) {
            echo '<img src="i/naruchi.gif" width=60 height=40>';
        }
?></TD></TR>

<TR><TD style="BACKGROUND-IMAGE: none">
<?php
if ($user['weap'] >=0) {
            echo '<img src="i/weap.gif" width=60 height=60>';
        }
    ?></TD></TR>

<TR><TD style="BACKGROUND-IMAGE: none">
<?php
if ($user['bron'] >=0) {
            echo '<img src="i/bron.gif" width=60 height=80>';
        }
    ?></TD></TR>

<TR><TD style="BACKGROUND-IMAGE: none">
<?php
if ($user['belt'] >=0) {
            echo '<img src="i/belt.gif" width=60 height=40>';
        }
}else{  ?>
<?php
if ($user['helm'] > 0) {
$dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$user['helm']}' LIMIT 1;"));
if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
showhrefmagic($dress);
} else {
echo '<img  '.((($dress['maxdur']-2)<=$dress['duration'] && !$pas)?" style='background-image:url(i/blink.gif);' ":"").' src="i/sh/'.$dress['img'].'" width=60 height=60 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа шлеме выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа шлеме выгравировано '{$dress['text']}'":"").'" >';
}}else{
echo '<img src="i/w9.gif" width=60 height=60 alt="Пустой слот шлем" >';
}
?>
</TD></TR>

<TR><TD style="BACKGROUND-IMAGE:none">
<?php
        if ($user['naruchi'] > 0) {
            $dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$user['naruchi']}' LIMIT 1;"));
            if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
                showhrefmagic($dress);
            } else {
                echo '<img  '.((($dress['maxdur']-2)<=$dress['duration'] && !$pas)?" style='background-image:url(i/blink.gif);' ":"").' src="i/sh/'.$dress['img'].'" width=60 height=40 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа наручах выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа наручах выгравировано '{$dress['text']}'":"").'" >';
            }
        }
        else
        {
            echo '<img src="i/w18.gif" width=60 height=40 alt="Пустой слот наручи" >';
        }

?></TD></TR>

<TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user['weap'] > 0) {
            $dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$user['weap']}' LIMIT 1;"));
            if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
                showhrefmagic($dress);
            } else {
                echo '<img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(i/blink.gif);' ":"").' src="i/sh/'.$dress['img'].'" width=60 height=60 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['minu']>0)?"\nУрон {$dress['minu']}-{$dress['maxu']}":"").(($dress['text']!=null)?"\nНа оружии выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['minu']>0)?"\nУрон {$dress['minu']}-{$dress['maxu']}":"").(($dress['text']!=null)?"\nНа оружии выгравировано '{$dress['text']}'":"").'" >';
            }
        }
        else
        {
            echo '<img src="i/w3.gif" width=60 height=60 alt="Пустой слот оружие" >';
        }
    ?></TD></TR>

<TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user['bron'] > 0) {
            $dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$user['bron']}' LIMIT 1;"));
            if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
                showhrefmagic($dress);
            } else {
                echo '<img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(i/blink.gif);' ":"").' src="i/sh/'.$dress['img'].'" width=60 height=80 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа одежде вышито '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа одежде вышито '{$dress['text']}'":"").'" >';
            }
        }
        else
        {
            echo '<img src="i/w4.gif" width=60 height=80 alt="Пустой слот броня" >';
        }
    ?></TD></TR>

<TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user['belt'] > 0) {
            $dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$user['belt']}' LIMIT 1;"));
            if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
                showhrefmagic($dress);
            } else {
                echo '<img  '.((($dress['maxdur']-2)<=$dress['duration'] && !$pas)?" style='background-image:url(i/blink.gif);' ":"").' src="i/sh/'.$dress['img'].'" width=60 height=40 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа поясе выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа поясе выгравировано '{$dress['text']}'":"").'" >';
            }
        }
        else
        {
            echo '<img src="i/w5.gif" width=60 height=40 alt="Пустой слот пояс" >';
        }}
    ?></TD></TR>
</TBODY></TABLE>
</TD>

<TD>
<TABLE border=0 cellSpacing=0 cellPadding=0 width="100%">
<TR>
<TD height=20 vAlign=middle>
<table cellspacing="0" cellpadding="0" style='line-height: 1'>


<?

if($battle!='0' or $user['id']==99){?> <tr><td nowrap style="font-size:9px" style="position: relative">
<?
if($user['id']==99){
                $vrag_b = mysql_fetch_array(mysql_query("SELECT `hp` FROM `bots` WHERE  `prototype` = 99 LIMIT 1 ;"));
if($vrag_b){$user['hp']=$vrag_b['hp'];}

}
echo setHP2($user['hp'],$user['maxhp'],$battle);
print"</td>
</tr>";}else{?>

<tr><td nowrap style="font-size:9px" style="position: relative">
<table cellspacing="0" cellpadding="0" style='line-height: 1'><td nowrap style="font-size:9px" style="position: relative"><SPAN id="HP" style='position: absolute; left: 5; z-index: 1; font-weight: bold; color: #FFFFFF'></SPAN><img src="i/misc/bk_life_loose.gif" alt="Уровень жизни" name="HP1" width="1" height="9" id="HP1"><img src="i/misc/bk_life_loose.gif" alt="Уровень жизни" name="HP2" width="1" height="9" id="HP2"></td></table>
</td>
</tr>


<?

}



if($battle!='0'){
if($user['maxmana']){ ?>
<tr><td nowrap height=10 style="font-size:9px" style="position: relative">
<?

echo setMP2($user['mana'],$user['maxmana'],$battle);
print"</td>
</tr>";}
}else{
if($user['maxmana']){ ?>
<tr><tr><td nowrap style="font-size:9px" style="position: relative">
<?
echo setMP2($user['mana'],$user['maxmana'],$battle);
print"</td>
</tr>";}
}
$zver=mysql_fetch_array(mysql_query("SELECT shadow,login,level FROM `users` WHERE `id` = '".$user['zver_id']."' LIMIT 1;"));
?>

</table>
</TD></TR>
<TR><TD height=220 vAlign=top width=120 align=left>
<DIV style="Z-INDEX: 1; POSITION: relative; WIDTH: 120px; HEIGHT: 220px" bgcolor="black">
<?
$strtxt = "<b>".$user['login']."</b><br>";
$strtxt .= "Сила: ".$user['sila']."<BR>";
$strtxt .= "Ловкость: ".$user['lovk']."<BR>";
$strtxt .= "Интуиция: ".$user['inta']."<BR>";
$strtxt .= "Выносливость: ".$user['vinos']."<BR>";
if ($user['level'] > 3) {
$strtxt .= "Интеллект: ".$user['intel']."<BR>";
}
if ($user['level'] > 6) {
$strtxt .= "Мудрость: ".$user['mudra']."<BR>";
}
if ($user['level'] > 9) {
$strtxt .= "Духовность: ".$user['spirit']."<BR>";
}
if ($user['level'] > 12) {
$strtxt .= "Воля: ".$user['will']."<BR>";
}
if ($user['level'] > 15) {
$strtxt .= "Свобода духа: ".$user['freedom']."<BR>";
}
if ($user['level'] > 18) {
$strtxt .= "Божественность: ".$user['god']."<BR>";
}
$strtxt .= "Сексуальность: ".$user['sexy']."<BR>";

if(!$pas && !$battle){
if($zver){
?>
<div style="position:absolute; left:80px; top:145px; width:40px; height:73px; z-index:2">
<a href="zver_inv.php">
<IMG width=40 height=73 src='i/shadow/<?print"".$zver['shadow']."";?>' onmouseout='ghideshow();'  onmouseover='gfastshow("<?=$zver['login']?> [<?=$zver['level']?>] (Перейти к настройкам)");'>
</a></div>
<? }?>
<a href="/main.php?edit=1"><IMG border=0 src="i/shadow/<?=$user['sex']?>/<?print"".$user['shadow']."";?>" width=120 height=218 onmouseout='ghideshow();'  onmouseover='gfastshow("<?=$user['login']?> (Перейти в \"Инвентарь\")");' ></a>
<?
$ch_eff1 = mysql_query ('SELECT * FROM `effects` WHERE `owner` = '.$_SESSION['uid'].' and (`type`=188 or `type`=395 or `type`=201 or `type`=202 or `type`=1022)');
$i=0;
while($ch_eff = mysql_fetch_array($ch_eff1)){
$i++;
                switch ($i) {
                    case '1':$left=0;$top=0;break;
                    case '2':$left=40;$top=0;break;
                    case '3':$left=80;$top=0;break;
                    case '4':$left=0;$top=25;break;
                    case '5':$left=40;$top=25;break;
                    case '6':$left=80;$top=25;break;
                    case '7':$left=0;$top=50;break;
                    case '8':$left=40;$top=50;break;
                    case '9':$left=80;$top=50;break;
                    case '10':$left=0;$top=75;break;
                    case '11':$left=40;$top=75;break;
                    case '12':$left=80;$top=75;break;
                }
$inf_el = mysql_fetch_array(mysql_query ('SELECT img FROM `shop` WHERE `name` = \''.$ch_eff['name'].'\';'));
if($ch_eff['type']==395){$inf_el['img']='defender.gif'; $opp='награда'; $chas=60; $chastxt="час.";}elseif($ch_eff['type']==201){$inf_el['img']='spell_protect10.gif'; $opp='заклятие'; $chas=1; $chastxt="мин.";}elseif($ch_eff['type']==202){$inf_el['img']='spell_powerup10.gif'; $opp='заклятие'; $chas=1; $chastxt="мин.";}elseif($ch_eff['type']==1022){$inf_el['img']='hidden.gif'; $opp='заклятие'; $chas=1; $chastxt="мин.";}else{$opp='эликсир'; $chas=1; $chastxt="мин.";}
 ?> <div style="position:absolute; left:<?=$left?>px; top:<?=$top?>px; width:120px; height:220px; z-index:2"><IMG width=40 height=25 src='i/misc/icon_<?=$inf_el['img']?>' onmouseout='ghideshow();' onmouseover='gfastshow("<B><? echo $ch_eff['name'];?></B> (<?=$opp?>)<BR> еще <? echo ceil(($ch_eff['time']-time())/60/$chas);?> <?=$chastxt?>")';> </div>
<?}
}elseif($show_pr){
if($zver){
?>
<div style="position:absolute; left:80px; top:145px; width:40px; height:73px; z-index:2">
<a href="zver_inv.php">
<IMG width=40 height=73 src='i/shadow/<?print"".$zver['shadow']."";?>' onmouseout='ghideshow();'  onmouseover='gfastshow("<?=$zver['login']?> [<?=$zver['level']?>] (Перейти к настройкам)");'>
</a></div>
<? }?>
<IMG border=0 src="i/shadow/<?=$user['sex']?>/<?print"".$user['shadow']."";?>" width=120 height=218 onmouseout='ghideshow();'  onmouseover='gfastshow("<?=$strtxt?>");'>
<?
$ch_eff1 = mysql_query ('SELECT * FROM `effects` WHERE `owner` = '.$_SESSION['uid'].' and (`type`=188 or `type`=201 or `type`=202 or `type`=1022)');
$i=0;
while($ch_eff = mysql_fetch_array($ch_eff1)){
$i++;
                switch ($i) {
                    case '1':$left=0;$top=0;break;
                    case '2':$left=40;$top=0;break;
                    case '3':$left=80;$top=0;break;
                    case '4':$left=0;$top=25;break;
                    case '5':$left=40;$top=25;break;
                    case '6':$left=80;$top=25;break;
                    case '7':$left=0;$top=50;break;
                    case '8':$left=40;$top=50;break;
                    case '9':$left=80;$top=50;break;
                    case '10':$left=0;$top=75;break;
                    case '11':$left=40;$top=75;break;
                    case '12':$left=80;$top=75;break;
                }
$inf_el = mysql_fetch_array(mysql_query ('SELECT img FROM `shop` WHERE `name` = \''.$ch_eff['name'].'\';'));
if($ch_eff['type']==395){$inf_el['img']='defender.gif'; $opp='награда'; $chas=60; $chastxt="час.";}elseif($ch_eff['type']==201){$inf_el['img']='spell_protect10.gif'; $opp='заклятие'; $chas=1; $chastxt="мин.";}elseif($ch_eff['type']==202){$inf_el['img']='spell_powerup10.gif'; $opp='заклятие'; $chas=1; $chastxt="мин.";}elseif($ch_eff['type']==1022){$inf_el['img']='hidden.gif'; $opp='заклятие'; $chas=1; $chastxt="мин.";}else{$opp='эликсир'; $chas=1; $chastxt="мин.";}
 ?> <div style="position:absolute; left:<?=$left?>px; top:<?=$top?>px; width:120px; height:220px; z-index:2"><IMG width=40 height=25 src='i/misc/icon_<?=$inf_el['img']?>' onmouseout='ghideshow();' onmouseover='gfastshow("<B><? echo $ch_eff['name'];?></B> (<?=$opp?>)<BR> еще <? echo ceil(($ch_eff['time']-time())/60/$chas);?> <?=$chastxt?>")';> </div>
<?}
$ch_priem1 = mysql_query ('SELECT pr_name FROM `person_on` WHERE `id_person` = '.$_SESSION['uid'].' and `pr_active`=2');

while($ch_priem = mysql_fetch_array($ch_priem1)){
$i++;
                switch ($i) {
                    case '1':$left=0;$top=0;break;
                    case '2':$left=40;$top=0;break;
                    case '3':$left=80;$top=0;break;
                    case '4':$left=0;$top=25;break;
                    case '5':$left=40;$top=25;break;
                    case '6':$left=80;$top=25;break;
                    case '7':$left=0;$top=50;break;
                    case '8':$left=40;$top=50;break;
                    case '9':$left=80;$top=50;break;
                    case '10':$left=0;$top=75;break;
                    case '11':$left=40;$top=75;break;
                    case '12':$left=80;$top=75;break;
                }
$inf_priem = mysql_fetch_array(mysql_query ('SELECT name,opisan FROM `priem` WHERE `priem` = \''.$ch_priem['pr_name'].'\';'));

 ?>
<div style="position:absolute; left:<?=$left?>px; top:<?=$top?>px; width:120px; height:220px; z-index:2">       <IMG width=40 height=25 src='i/priem/<?=$ch_priem['pr_name']?>.gif' onmouseout='hideshow();' onmouseover='fastshow("<B><? echo $inf_priem['name'];?></B> (прием)<BR><BR> <? echo $inf_priem['opisan'];?>")';> </div>
<?}
}elseif($zver){
?>
<div style="position:absolute; left:80px; top:145px; width:40px; height:73px; z-index:2">
<IMG width=40 height=73 src='i/shadow/<?print"".$zver['shadow']."";?>' alt="<?print"".$zver['login']."";?> [<?print"".$zver['level']."";?>]">
</div>
<IMG border=0 src="i/shadow/<?=$user['sex']?>/<?print"".$user['shadow']."";?>" width=120 height=218>
<?}elseif($battle && $invis){?>
<IMG border=0 src="i/shadow/invis.gif" width=120 height=218 onmouseout='ghideshow();'  onmouseover='gfastshow("<?=$strtxt?>");'>
<?}elseif($battle){
if($zver){
?>
<div style="position:absolute; left:60px; top:118px; width:120px; height:220px; z-index:2">
<a href="zver_inv.php">
<IMG width=40 height=73 src='i/shadow/<?print"".$zver['shadow']."";?>' alt="alt="<?print"".$zver['login']."";?> [<?print"".$zver['level']."";?>] (Перейтик настройкам)">
</a></div>
<? }?>
<IMG border=0 src="i/shadow/<?=$user['sex']?>/<?print"".$user['shadow']."";?>" width=120 height=218 onmouseout='ghideshow();'  onmouseover='gfastshow("<?=$strtxt?>");'>
<?}else{?>

<IMG border=0 src="i/shadow/<?=$user['sex']?>/<?print"".$user['shadow']."";?>" width=120 height=218>
<?}?>
<DIV style="Z-INDEX: 2; POSITION: absolute; WIDTH: 120px; HEIGHT: 220px; TOP: 0px; LEFT: 0px"></DIV></DIV></TD></TR>
<TR><TD>
<?
if($battle && $invis && $user['id'] != $_SESSION['uid']) {
echo'<IMG border=0 alt="" src="i/slot_invis.gif" width=120 height=40>';
}elseif ($user['vip']==1) {
echo'<IMG border=0 alt="" src="i/slot_bottom60.gif" width=120 height=40>';
}elseif ($user['align']>1 && $user['align']<2) {
echo'<IMG border=0 alt="" src="i/slot_bottom1.gif" width=120 height=40>';
}elseif ($user['align']>=3 && $user['align']<4) {
echo'<IMG border=0 alt="" src="i/slot_bottom3.gif" width=120 height=40>';
}elseif ($user['align']==7) {
echo'<IMG border=0 alt="" src="i/slot_bottom7.gif" width=120 height=40>';
}elseif ($user['align']==0.99) {
echo'<IMG border=0 alt="" src="i/slot_bottom1.gif" width=120 height=40>';
}elseif ($user['align']==0.98) {
echo'<IMG border=0 alt="" src="i/slot_bottom3.gif" width=120 height=40>';
}else{
echo'<IMG border=0 alt="" src="i/slot_bottom0.gif" width=120 height=40>';
}
?>
</TD></TR></TABLE></TD>
<TD><TABLE border=0 cellSpacing=0 cellPadding=0 width="100%"><TBODY>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php
    if($battle && $invis && $user['id'] != $_SESSION['uid']) {
        if ($user['sergi'] >= 0) {

            echo '<img src="i/serg.gif" width=60 height=20>';
        }
    ?></TD></TR>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user['kulon'] >= 0) {

            echo '<img src="i/ojur.gif" width=60 height=20>';
        }
    ?></TD></TR>

<TR><TD><TABLE border=0 cellSpacing=0 cellPadding=0>
<TBODY> <TR>
<TD style="BACKGROUND-IMAGE: none"><?php
        if ($user['r1'] >= 0) {
            echo '<img src="i/ring.gif" width=20 height=20>';
        }
    ?></td>
<TD style="BACKGROUND-IMAGE: none"><?php
        if ($user['r2'] >= 0) {
            echo '<img src="i/ring.gif" width=20 height=20>';
        }
    ?></td>
<TD style="BACKGROUND-IMAGE: none"><?php
        if ($user['r3'] >= 0) {
            echo '<img src="i/ring.gif" width=20 height=20>';
        }
    ?></td>
</TR></TBODY></TABLE></TD></TR>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user['perchi'] >= 0) {
            echo '<img src="i/perchi.gif" width=60 height=40>';
        }
    ?></TD></TR>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user['shit'] >= 0) {
            echo '<img src="i/shit.gif" width=60 height=60>';
        }
    ?></TD></TR>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user['leg'] >= 0) {
            echo '<img src="i/leg.gif" width=60 height=80>';
        }
    ?></TD></TR>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user['boots'] >= 0) {
            echo '<img src="i/boots.gif" width=60 height=40>';
        }
        }else{?>
<?php
        if ($user['sergi'] > 0) {
            $dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$user['sergi']}' LIMIT 1;"));
            if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
                showhrefmagic($dress);
            } else {
                echo '<img '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(i/blink.gif);' ":"").' src="i/sh/'.$dress['img'].'" width=60 height=20 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа серьгах выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа серьгах выгравировано '{$dress['text']}'":"").'" >';
            }
        }
        else
        {
            echo '<img src="i/w1.gif" width=60 height=20 alt="Пустой слот серьги" >';
        }
    ?></TD></TR>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user['kulon'] > 0) {
            $dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$user['kulon']}' LIMIT 1;"));
            if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
                showhrefmagic($dress);
            } else {
                echo '<img  '.((($dress['maxdur']-2)==$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(i/blink.gif);' ":"").' src="i/sh/'.$dress['img'].'" width=60 height=20 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа ожерелье выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа ожерелье выгравировано '{$dress['text']}'":"").'" >';
            }
        }
        else
        {
            echo '<img src="i/w2.gif" width=60 height=20 alt="Пустой слот ожерелье" >';
        }
    ?></TD></TR>

<TR><TD><TABLE border=0 cellSpacing=0 cellPadding=0>
<TBODY> <TR>
<TD style="BACKGROUND-IMAGE: none"><?php
        if ($user['r1'] > 0) {
            $dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$user['r1']}' LIMIT 1;"));
            if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
                showhrefmagic($dress);
            } else {
                echo '<img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(i/blink.gif);' ":"").' src="i/sh/'.$dress['img'].'" width=20 height=20 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа кольце выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа кольце выгравировано '{$dress['text']}'":"").'" >';
            }
        }
        else
        {
            echo '<img src="i/w6.gif" width=20 height=20 alt="Пустой слот кольцо" >';
        }
    ?></td>
<TD style="BACKGROUND-IMAGE: none"><?php
        if ($user['r2'] > 0) {
            $dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$user['r2']}' LIMIT 1;"));
            if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
                showhrefmagic($dress);
            } else {
                echo '<img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(i/blink.gif);' ":"").' src="i/sh/'.$dress['img'].'" width=20 height=20 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа кольце выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа кольце выгравировано '{$dress['text']}'":"").'" >';
            }
        }
        else
        {
            echo '<img src="i/w6.gif" width=20 height=20 alt="Пустой слот кольцо" >';
        }
    ?></td>
<TD style="BACKGROUND-IMAGE: none"><?php
        if ($user['r3'] > 0) {
            $dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$user['r3']}' LIMIT 1;"));
            if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
                showhrefmagic($dress);
            } else {
                echo '<img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(i/blink.gif);' ":"").' src="i/sh/'.$dress['img'].'" width=20 height=20 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа кольце выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа кольце выгравировано '{$dress['text']}'":"").'" >';
            }
        }
        else
        {
            echo '<img src="i/w6.gif" width=20 height=20 alt="Пустой слот кольцо" >';
        }
    ?></td>
</TR></TBODY></TABLE></TD></TR>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user['perchi'] > 0) {
            $dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$user['perchi']}' LIMIT 1;"));
            if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
                showhrefmagic($dress);
            } else {
                echo '<img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(i/blink.gif);' ":"").' src="i/sh/'.$dress['img'].'" width=60 height=40 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа перчатках выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа перчатках выгравировано '{$dress['text']}'":"").'" >';
            }
        }
        else
        {
            echo '<img src="i/w11.gif" width=60 height=40 alt="Пустой слот перчатки" >';
        }
    ?></TD></TR>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user['shit'] > 0) {
            $dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$user['shit']}' LIMIT 1;"));
            if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
                showhrefmagic($dress);
            } else {
                echo '<img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(i/blink.gif);' ":"").' src="i/sh/'.$dress['img'].'" width=60 height=60 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['minu']>0)?"\nУрон {$dress['minu']}-{$dress['maxu']}":"").(($dress['text']!=null)?"\nНа щите выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа щите выгравировано '{$dress['text']}'":"").'" >';
            }
        }
        else
        {
            echo '<img src="i/w10.gif" width=60 height=60 alt="Пустой слот щит" >';
        }
    ?></TD></TR>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user['leg'] > 0) {
            $dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$user['leg']}' LIMIT 1;"));
            if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
                showhrefmagic($dress);
            } else {
                echo '<img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(i/blink.gif);' ":"").' src="i/sh/'.$dress['img'].'" width=60 height=80 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа поножах выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа поножах выгравировано '{$dress['text']}'":"").'" >';
            }
        }
        else
        {
            echo '<img src="i/w19.gif" width=60 height=80 alt="Пустой слот поножи" >';
        }
    ?></TD></TR>
<TR><TD style="BACKGROUND-IMAGE: none">
<?php
        if ($user['boots'] > 0) {
            $dress = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `id` = '{$user['boots']}' LIMIT 1;"));
            if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
                showhrefmagic($dress);
            } else {
                echo '<img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(i/blink.gif);' ":"").' src="i/sh/'.$dress['img'].'" width=60 height=40 title="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа ботинках выгравировано '{$dress['text']}'":"").'" alt="'.$dress['name']."\nПрочность ".$dress['duration']."/".$dress['maxdur']."".(($dress['ghp']>0)?"\nУровень жизни +{$dress['ghp']}":"").(($dress['gmana']>0)?"\nУровень маны +{$dress['gmana']}":"").(($dress['text']!=null)?"\nНа ботинках выгравировано '{$dress['text']}'":"").'" >';
            }
        }
        else
        {
            echo '<img src="i/w12.gif" width=60 height=40 alt="Пустой слот обувь" >';
        }}
        ?></TD></TR>
</TBODY></TABLE></TD></TR>


<? if (!$pas && !$battle && ($user['m1'] > 0 or $user['m2'] > 0 or $user['m3'] > 0 or $user['m4'] > 0 or $user['m5'] > 0 or $user['m6'] > 0 or $user['m7'] > 0 or $user['m8'] > 0 or $user['m9'] > 0 or $user['m10'] > 0 or $user['m11'] > 0 or $user['m12'] > 0)) {?>
<TR>
    <TD colspan=3>
    <?
            echoscroll('m1'); echoscroll('m2'); echoscroll('m3'); echoscroll('m4'); echoscroll('m5');echoscroll('m6');

    ?>
    </TD>
</TR>
<TR>
    <TD colspan=3>
    <?
        echoscroll('m7'); echoscroll('m8'); echoscroll('m9'); echoscroll('m10'); echoscroll('m11');echoscroll('m12');
    ?>
    </TD>
</TR>
<? }?>

</TBODY></TABLE></TD></TR>
<TR><TD></TD>
<?


        $data = mysql_fetch_array(mysql_query("select * from `online` WHERE `date` >= ".(time()-60)." AND `id` = ".$user['id'].";"));
/*      $dd = mysql_query("SELECT * FROM `effects` WHERE `owner` = ".$user['id'].";");
        $ddtravma = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = ".$user['id']." and (`type`=11 or `type`=12 or `type`=13 or `type`=14) order by `type` desc limit 1;"));
        if ($ddtravma['type'] == 14) {$trt="неизлечимая";}
        elseif ($ddtravma['type'] == 13) {$trt="тяжелая";}
        elseif ($ddtravma['type'] == 12) {$trt="средняя";}
        elseif ($ddtravma['type'] == 11) {$trt="легкая";}
        else {$trt=0;} */

    ?></A>
</TABLE>
</CENTER><CENTER>

<TABLE cellPadding=0 cellSpacing=0 width="100%">
        <TBODY>
          <?
    if(!$battle){
?>
        <? if ($pas){ ?><TR>

          <TD align=middle colSpan=2><B>Virt<img src="/i/misc/forum/fo1.gif">City</B></TD></TR>
        <TR>
          <TD colSpan=2>
          <SMALL><?php
$online = mysql_fetch_array(mysql_query('SELECT u.* ,o.date,u.* ,o.real_time FROM `users` as u, `online` as o WHERE u.`id` = o.`id` AND u.`id` = \''.$user['id'].'\' LIMIT 1;'));
            if ($data['id'] != null or ($user['id'] == 99 && vrag=="on")) {
                if($data['room'] > 500 && $data['room'] < 561) {
                    $rrm = 'Башня смерти, участвует в турнире';
                }
                elseif($user['id'] == 99) {
                    $rrm = "Центральная площадь";
                $vrag_b = mysql_fetch_array(mysql_query("SELECT `battle` FROM `bots` WHERE  `prototype` = 99 LIMIT 1 ;"));
                                $user['battle']=$vrag_b['battle'];
                }
                else {
                    $rrm = $rooms[$data['room']];
                }
                echo '<center>Персонаж сейчас находится в клубе.</center><center>Локация : <B>"'.$rrm.'"</B></center>';
            } else
            {

function getDateInterval($pointDate)
{
   $pointNow = time(); // получили метку текущего времени

   $times = array('year' => 60*60*24*365, 'month' =>60*60*24*31, 'week' =>60*60*24*7, 'day' => 60*60*24, 'hour' => 60*60, 'minute' => 60);

   $pointInterval = $pointDate > $pointNow ? $pointDate - $pointNow : $pointNow - $pointDate; // получили метку разности двух дат

   $returnDate = array(); // создаём пока пустой массив возвращаемой даты

   $returnDate['year'] = floor($pointInterval / $times['year']); // высчитываем годы
   $pointInterval = $pointInterval % $times['year']; // находим остаток

   $returnDate['month'] = floor($pointInterval / $times['month']); // высчитываем месяцы
   $pointInterval = $pointInterval % $times['month']; // находим остаток

   $returnDate['week'] = floor($pointInterval / $times['week']); // высчитываем недели
   $pointInterval = $pointInterval % $times['week']; // находим остаток

   $returnDate['day'] = floor($pointInterval / $times['day']); // высчитываем дни
   $pointInterval = $pointInterval % $times['day']; // находим остаток

   $returnDate['hour'] = floor($pointInterval / $times['hour']); // высчитываем часы
   $pointInterval = $pointInterval % $times['hour']; // находим остаток

   $returnDate['minute'] = floor($pointInterval / $times['minute']); // высчитываем минуты
   $pointInterval = $pointInterval % $times['minute']; // находим остаток


   return $returnDate;

}

$date = getDateInterval($online['date']);

function year_text($days) { # склонение слова "год"
    $s=substr($days,strlen($days)-1,1);
    if (strlen($days)>=2) {
        if (substr($days,strlen($days)-2,1)=='1') {return $days." лет ";$ok=true;}
    }if (!$ok) {
        if ($days==0){return "";}
    elseif ($s==0 or $s>=5) {return $days." лет ";}
    elseif ($s==1) {return $days." год ";}
    elseif ($s>=2 && $s<=4) {return $days." года ";}
    }
}
function month_text($days) { # склонение слова "месяц"
    $s=substr($days,strlen($days)-1,1);
    if (strlen($days)>=2) {
        if (substr($days,strlen($days)-2,1)=='1') {return $days." месяцев ";$ok=true;}
    }if (!$ok) {
        if ($days==0){return "";}
    elseif ($s==0 or $s>=5) {return $days." месяцев ";}
    elseif ($s==1) {return $days." месяц ";}
    elseif ($s>=2 && $s<=4) {return $days." месяца ";}
    }
}
function week_text($days) { # склонение слова "неделя"
    $s=substr($days,strlen($days)-1,1);
    if (strlen($days)>=2) {
        if (substr($days,strlen($days)-2,1)=='1') {return $days." недель ";$ok=true;}
    }if (!$ok) {
        if ($days==0){return "";}
    elseif ($s==0 or $s>=5) {return $days." недель ";}
    elseif ($s==1) {return $days." неделю ";}
    elseif ($s>=2 && $s<=4) {return $days." недели ";}
    }
}
function days_text($days) { # склонение слова "дней"
    $s=substr($days,strlen($days)-1,1);
    if (strlen($days)>=2) {
        if (substr($days,strlen($days)-2,1)=='1') {return $days." дней ";$ok=true;}
    }if (!$ok) {
        if ($days==0){return "";}
    elseif ($s==0 or $s>=5) {return $days." дней ";}
    elseif ($s==1) {return $days." день ";}
    elseif ($s>=2 && $s<=4) {return $days." дня ";}
    }
}
function hour_text($days) { # склонение слова "час"
    $s=substr($days,strlen($days)-1,1);
    if (strlen($days)>=2) {
        if (substr($days,strlen($days)-2,1)=='1') {return $days." часов ";$ok=true;}
    }if (!$ok) {
        if ($days==0){return "";}
    elseif ($s==0 or $s>=5) {return $days." часов ";}
    elseif ($s==1) {return $days." час ";}
    elseif ($s>=2 && $s<=4) {return $days." часа ";}
    }
}
function minute_text($days) { # склонение слова "минута"
    $s=substr($days,strlen($days)-1,1);
    if (strlen($days)>=2) {
        if (substr($days,strlen($days)-2,1)=='1') {return $days." минут ";$ok=true;}
    }if (!$ok) {
        if ($days==0){return "1 минуту";}
    elseif ($s==0 or $s>=5) {return $days." минут ";}
    elseif ($s==1) {return $days." минуту ";}
    elseif ($s>=2 && $s<=4) {return $days." минуты ";}
    }
}
$year = year_text($date['year']);
$month = month_text($date['month']);
$week = week_text($date['week']);
$days = days_text($date['day']);
$hour = hour_text($date['hour']);
$minute = minute_text($date['minute']);



if ($days>0 or $week>0 or $month>0 or $year>0){$minute="";}
if ($week>0 or $month>0 or $year>0){$hour="";}
if ($month>0 or $year>0){$week="";}



                echo "<center>Персонаж не в клубе, но был тут:</center><center>".date("Y.m.d H:i", $online['date'])."<IMG src=\"/i/clok3_2.png\" alt=\"Время сервера\"></center>";
echo"<center>(".$year.$month.$week.$days.$hour.$minute." назад)</center>";
                }
            ?><?
            if ($user['battle'] > 0) {
                echo '<center>Персонаж сейчас в <a target=_blank href="logs.php?log=',$user['battle'],'"><IMG height=12 width=12 src="i/fighttype1.gif"> поединке</a></center>';
            }
            ?></CENTER></SMALL></TD></TR><?  }
/*          if ($trt) {
                echo "<TR><TD><IMG height=25 src=\"i/travma.gif\" width=40></TD><TD><SMALL>У персонажа $trt травма.</SMALL></TD></TR>";
            }
            while($row = mysql_fetch_array($dd)) {
                if ($row['time'] < time()) {
                    $row['time'] = time();
                }
                if ($row['type'] == 11 OR $row['type'] == 12 OR $row['type'] == 13 OR $row['type'] == 14) {
                    if ($row['sila']) echo "<TR><TD><IMG height=25 src=\"i/travma.gif\" width=40></TD><TD><SMALL>\"{$row['name']}\" - Ослаблен параметр \"сила\", еще ".floor(($row['time']-time())/60/60)." ч. ".round((($row['time']-time())/60)-(floor(($row['time']-time())/3600)*60))." мин.</SMALL></TD></TR>";
                    if ($row['lovk']) echo "<TR><TD><IMG height=25 src=\"i/travma.gif\" width=40></TD><TD><SMALL>\"{$row['name']}\" - Ослаблен параметр \"ловкость\", еще ".floor(($row['time']-time())/60/60)." ч. ".round((($row['time']-time())/60)-(floor(($row['time']-time())/3600)*60))." мин.</SMALL></TD></TR>";
                    if ($row['inta']) echo "<TR><TD><IMG height=25 src=\"i/travma.gif\" width=40></TD><TD><SMALL>\"{$row['name']}\" - Ослаблен параметр \"интуиция\", еще ".floor(($row['time']-time())/60/60)." ч. ".round((($row['time']-time())/60)-(floor(($row['time']-time())/3600)*60))." мин.</SMALL></TD></TR>";
                }
                if ($row['type'] == 2) {
                    echo "<TR><TD><IMG height=25 src=\"i/magic/sleep.gif\" width=40></TD><TD><SMALL>На персонажа наложено заклятие молчания. Будет молчать еще ".floor(($row['time']-time())/60/60)." ч. ".round((($row['time']-time())/60)-(floor(($row['time']-time())/3600)*60))." мин.</SMALL></TD></TR>";
                }
                if ($row['type'] == 10) {
                    echo "<TR><TD><IMG height=25 src=\"i/magic/chains.gif\" width=40></TD><TD><SMALL>На персонажа наложены путы. Не может двигатся еще ".floor(($row['time']-time())/60/60)." ч. ".round((($row['time']-time())/60)-(floor(($row['time']-time())/3600)*60))." мин.</SMALL></TD></TR>";
                }
                if ($row['type'] == 3) {
                    echo "<TR><TD><IMG height=25 src=\"i/magic/sleepf.gif\" width=40></TD><TD><SMALL>На персонажа наложено заклятие форумного молчания. Будет молчать еще ".floor(($row['time']-time())/60/60)." ч. ".round((($row['time']-time())/60)-(floor(($row['time']-time())/3600)*60))." мин.</SMALL></TD></TR>";
                }
            }*/

            ?>
            </TBODY></TABLE></CENTER>


</TD>
    <TD valign=top <?=(!$pas?"style='width:350px;'":"")?>>
<table><tr><td><BR>
</td></tr></table><?
} else {
?>
</table>
 <?
}
}
    session_start();
    if ($_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    include "functions.php";
    nick99 ($_SESSION['uid']);
$der=mysql_query("SELECT glav_id FROM vxodd WHERE login='".$user['login']."'");
if($deras=mysql_fetch_array($der) && $_GET['cp']){
header('location: vxod.php?warning=3');
die();
}
    $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));

    if ($_GET['strah'] && ($user['room']==42 or $user['room']==34 or $user['room']==31 or $user['room']==28 or $user['room']==37 or $user['room']==402 or $user['room']==20)) {
        mysql_query("UPDATE `users`,`online` SET `users`.`room` = '21',`online`.`room` = '21' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}';");
$user['room']=21;
    }
    if ($_GET['cp'] && ($user['room']==22 or $user['room']==23 or $user['room']==25 or $user['room']==27 or $user['room']==35 or $user['room']==29 or $user['room']==21 or $user['room']==668)) {
mysql_query("UPDATE `users`,`online` SET `users`.`room` = '20',`online`.`room` = '20' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}';");
$user['room']=20;
    }
/*  if ($_GET['bps']!=1 && $_GET['bps']) {

            mysql_query("UPDATE `users`,`online` SET `users`.`room` = '26',`online`.`room` = '26' WHERE `online`.`id` = `users`.`id`;");
$user['room']=26;
    }
*/

    if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }
    if ($user['in_tower'] == 1) { header('Location: towerin.php'); die(); }

    header("Cache-Control: no-cache");

    $d = mysql_fetch_array(mysql_query("SELECT sum(`massa`) FROM `inventory` WHERE `owner` = '{$user['id']}' AND `dressed` = 0 AND `setsale` = 0 ; "));
    if($d[0] > get_meshok() && $_GET['got']) {
        echo "<font color=red><b>У вас переполнен рюкзак, вы не можете передвигатся...</b></font>";
        $_GET['got'] =0;
    }
    $eff = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$u['id']."' AND (`type` = 14 OR `type` = 13);"));
    if($eff && $_GET['got']) {
        echo "<font color=red><b>У вас тяжелая травма, вы не можете передвигатся...</b></font>";
        $_GET['got'] =0;
    }
    $chain = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$u['id']."' AND (`type` = 10);"));
    if($chain && $_GET['got']) {
        echo "<font color=red><b>На Вас наложены путы, вы не можете передвигатся...</b></font>";
        $_GET['got'] =0;
    }
    if($d[0] > get_meshok() && $_GET['strah']) {
        echo "<font color=red><b>У вас переполнен рюкзак, вы не можете передвигатся...</b></font>";
        $_GET['strah'] =0;
    }
    $eff = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$u['id']."' AND (`type` = 14 OR `type` = 13);"));
    if($eff && $_GET['strah']) {
        echo "<font color=red><b>У вас тяжелая травма, вы не можете передвигатся...</b></font>";
        $_GET['strah'] =0;
    }
    $chain = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$u['id']."' AND (`type` = 14 OR `type` = 13);"));
    if($chain && $_GET['strah']) {
        echo "<font color=red><b>На Вас наложены путы, вы не можете передвигатся...</b></font>";
        $_GET['strah'] =0;
    }




    if($d[0] > get_meshok() && $_GET['cp']) {
        echo "<font color=red><b>У вас переполнен рюкзак, вы не можете передвигатся...</b></font>";
        $_GET['cp'] =0;
    }
    $eff = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$u['id']."' AND (`type` = 14 OR `type` = 13);"));
    if($eff && $_GET['cp']) {
        echo "<font color=red><b>У вас тяжелая травма, вы не можете передвигатся...</b></font>";
        $_GET['cp'] =0;
    }
    $chain = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$u['id']."' AND (`type` = 10);"));
    if($chain && $_GET['cp']) {
        echo "<font color=red><b>На Вас наложены путы, вы не можете передвигатся...</b></font>";
        $_GET['cp'] =0;
    }





    if($d[0] > get_meshok() && $_GET['bps']) {
        echo "<font color=red><b>У вас переполнен рюкзак, вы не можете передвигатся...</b></font>";
        $_GET['bps'] =0;
    }
    $eff = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$u['id']."' AND (`type` = 14 OR `type` = 13);"));
    if($eff && $_GET['bps']) {
        echo "<font color=red><b>У вас тяжелая травма, вы не можете передвигатся...</b></font>";
        $_GET['bps'] =0;
    }
    $chain = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$u['id']."' AND (`type` = 10);"));
    if($chain && $_GET['bps']) {
        echo "<font color=red><b>На Вас наложены путы, вы не можете передвигатся...</b></font>";
        $_GET['bps'] =0;
    }

if($_GET['got'] && $_SESSION['perehod']>time()){
                     echo "<div align=right><font color=red><b>Не так быстро...</b></font></div>";
$_GET['got'] =0;
}elseif($_GET['got']){$_SESSION['perehod']=time()+10;}


    if ($user['room']==20) {
        // CP
        // BK
        if ($_GET['got'] && $_GET['level1']) {
            //if ($user['level'] > 0) { $room = 8; } else { $room = 1; }
            mysql_query("UPDATE `users`,`online` SET `users`.`room` = '3',`online`.`room` = '3' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
                        $_SESSION['perehod']=0;
            header('location: main.php?got=1&room3=1');
            die();
        }
        // Stralka strah
        if ($_GET['got'] && $_GET['level7']) {
            header('location: city.php?strah=1');
        }
        if ($_GET['got'] && $_GET['level8']) {
            header('location: city.php?bps=1');
        }
        // shop
        if ($_GET['got'] && $_GET['level2']) {
            mysql_query("UPDATE `users`,`online` SET `users`.`room` = '22',`online`.`room` = '22' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
            header('location: shop.php');
        }
        // repait
        if ($_GET['got'] && $_GET['level4']) {
            mysql_query("UPDATE `users`,`online` SET `users`.`room` = '23',`online`.`room` = '23' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
            header('location: repair.php');
        }
        if ($_GET['got'] && $_GET['level11']) {
            mysql_query("UPDATE `users`,`online` SET `users`.`room` = '668',`online`.`room` = '668' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
            header('location: zoo.php');
        }
        //if ($_GET['level9']) {
        //  mysql_query("UPDATE `users`,`online` SET `users`.`room` = '24',`online`.`room` = '24' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
        //  header('location: elka.php');
        //}
        if ($_GET['got'] && $_GET['level3']) {
            if ($user['align'] == 4) {
                print "<script>alert('Хаосникам вход в комиссионный магазин запрещен!')</script>";
            }
            elseif ($user['level'] < 1) {
                print "<script>alert('Вход в комиссионный магазин только с первого уровня!')</script>";
            }
            else {
                mysql_query("UPDATE `users`,`online` SET `users`.`room` = '25',`online`.`room` = '25' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
                header('location: comission.php');
            }
        }
        if ($_GET['got'] && $_GET['level6']) {
            if ($user['level'] < 1) {
                print "<script>alert('Вход на почту только с первого уровня!')</script>";
            }
            else {
                mysql_query("UPDATE `users`,`online` SET `users`.`room` = '27',`online`.`room` = '27' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
                header('location: post.php');
            }
        }
        if ($_GET['got'] && $_GET['room666']) {
            header('location: jail.php');
        }
        if ($_GET['got'] && $_GET['room667']) {
            header('location: bar.php');
        }
        if ($_GET['got'] && $_GET['level10']) {
            mysql_query("UPDATE `users`,`online` SET `users`.`room` = '35',`online`.`room` = '35' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
            header('location: berezka.php');
        }
        if ($_GET['got'] && $_GET['level12']) {
            mysql_query("UPDATE `users`,`online` SET `users`.`room` = '29',`online`.`room` = '29' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
            header('location: bank.php');
        }

    }
    elseif($user['room']==21) {
        // Strashilka
        // strelka cp
        if ($_GET['got'] && $_GET['level4']) {
            header('location: city.php?cp=1');
        }
        if ($_GET['got'] && $_GET['level5']) {
            if (($user['login'] != 'Модератор' && $user['level'] < '4') OR $user['level']>15) {
                print "<script>alert('Вход в водосток только с 4 лвл! Либо вы выросли для посещения данного места.')</script>";
            }
            else {
                mysql_query("UPDATE `users`,`online` SET `users`.`room` = '402',`online`.`room` = '402' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
                header('location: post.php');
            }
        }
        if ($_GET['got'] && $_GET['level6']) {
            mysql_query("UPDATE `users`,`online` SET `users`.`room` = '34',`online`.`room` = '34' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
            header('location: fshop.php');
        }
        if ($_GET['got'] && $_GET['level2']) {
            mysql_query("UPDATE `users`,`online` SET `users`.`room` = '28',`online`.`room` = '28' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
            header('location: klanedit.php');
        }
        if ($_GET['got'] && $_GET['level7']) {
            mysql_query("UPDATE `users`,`online` SET `users`.`room` = '31',`online`.`room` = '31' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
            header('location: tower.php');
        }
        if ($_GET['got'] && $_GET['level1']) {
            mysql_query("UPDATE `users`,`online` SET `users`.`room` = '37',`online`.`room` = '37' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
            header('location: gotzamok.php');
        }
        if ($_GET['got'] && $_GET['level11']) {
            mysql_query("UPDATE `users`,`online` SET `users`.`room` = '42',`online`.`room` = '42' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
            header('location: lotery.php');
        }
}
/*  elseif($user['room']==26) {
        // Strashilka
        // strelka cp
        if ($_GET['level4']) {
            header('location: city.php?cp=1');
        }
        if ($_GET['got'] && $_GET['level1']) {
            mysql_query("UPDATE `users`,`online` SET `users`.`room` = '37',`online`.`room` = '37' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
            header('location: gotzamok.php');
        }
        if ($_GET['got'] && $_GET['level5']) {
            mysql_query("UPDATE `users`,`online` SET `users`.`room` = '401',`online`.`room` = '401' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
            header('location: hell.php');
        }
        if ($_GET['got'] && $_GET['level11']) {
            mysql_query("UPDATE `users`,`online` SET `users`.`room` = '42',`online`.`room` = '42' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
            header('location: lotery.php');
        }

    }
*/






    /*if ($_GET['level7'] OR $_GET['strah']) {
        mysql_query("UPDATE `users`,`online` SET `users`.`room` = '21',`online`.`room` = '21' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
        $user['room'] = 21;
    }
    if ($_GET['level8'] && $_GET['strah']) {
        mysql_query("UPDATE `users`,`online` SET `users`.`room` = '20',`online`.`room` = '20' WHERE `online`.`id` = `users`.`id` AND `online`.`id` = '{$_SESSION['uid']}' ;");
        $user['room'] = 20;
    }*/
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<link href="/i/move/design6.css" rel="stylesheet" type="text/css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<META HTTP-EQUIV="imagetoolbar" CONTENT="no">

<style type="text/css">
img.aFilter { filter:Glow(color=d7d7d7,Strength=4,Enabled=0); cursor:hand }
hr { height: 1px; }
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
function solo(n, name, instant) {
if (instant!="" || check_access()==true) {
window.location.href = '?got=1&level'+n+'=1&rnd='+Math.random();
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
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor="#d7d7d7" onLoad="top.setHP(<?=$user['hp']?>,<?=$user['maxhp']?>,<?if (!$user['battle']){echo"10";}else{echo"0";}?>)">
<div id="mmoves3" style="background-color:#FFFFCC; visibility:hidden; z-index: 101; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px;"></div>

<?
if($_GET['nap']=="attack" && $user['room']==20){include "magic/cityattack.php";}
?>

<div id=hint3 class=ahint></div>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<TR>
    <TD valign=top align=left width=250>
<?
  include_once("questfuncs.php");
  if (canmakequest(1)) {
    smallshowpersout($_SESSION['uid']);
    if (@$_GET["openchest"]) {
      $rnd=rand(0,1);
      if ($rnd==1) {
        $rnd=rand(2,6);
        $taken=takeitem($rnd);
      } else {
        $rnd=rand(1,8);
        $taken=takesmallitem($rnd);
      }
      makequest(1);
      $rand=rand(1,3);
      echo "</td><td width=\"230\" valign=\"top\"><br />
      <img src=\"images/empty.gif\" width=\"230\" height=\"1\">";
      echo "<div style=\"padding:10px\">В сундучке вы обнаружили $taken[name] и ".($rand*0.5)." кр.<br><br>
      <center><img src=\"/i/sh/$taken[img]\"></center><br>
      Приходите через 24 часа за новым подарком.
      </div>";
      mq("update users set money=money+".($rand*0.5)." where id='$_SESSION[uid]'");
    } else {
      echo "<div style=\"padding:10px\">Посередине площади расположен сундук мироздателя, в котором раз в день можно получить небольшой подарочек.</div>
      <center><a href=\"$_SERVER[PHP_SELF]?openchest=1\"><img border=\"0\" src=\"img/podzem/2.gif\"></a></center>";
    }
    echo "</td>";
  } else echo showpersout($_SESSION['uid']);
  ?>
    </TD>

    <TD valign=top align=right>
    <IMG SRC=i/1x1.gif WIDTH=1 HEIGHT=5><BR>





<table  border="0" cellpadding="0" cellspacing="0">
<tr align="right" valign="top">
<td>







<TABLE width=100% height=100% border=0 cellspacing="0" cellpadding="0">

    <TR><TD align=right colspan=2>

            <div align=right id=per></div>

        <?


    function buildset($id,$img,$top,$left,$des) {

                if($img=='up' or $img=='down'){$ebabo='png'; $x=15; $y=15;}else{
        $imga = ImageCreateFromGif("i/city/".$img.".gif");
                #Get image width / height
        $x = ImageSX($imga);
        $y = ImageSY($imga);
        $ebabo='gif';}
                unset($imga);
        echo "<div style=\"position:absolute; left:{$left}px; top:{$top}px; width:{$x}; height:${y}; z-index:90; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);\"
     ><img src=\"i/city/{$img}.{$ebabo}\" width=\"${x}\" height=\"${y}\" alt=\"{$des}\" title=\"{$des}\" class=\"aFilter\" onmouseover=\"imover(this)\" onmouseout=\"imout(this);\"
     id=\"mo_{$id}\" onclick=\"solo('".$id."','".$des."', '')\" /></div>";
    }

if ($user['room'] == 20) {
    if((int)date("H") > 5 && (int)date("H") < 22) {
        $fon = 'losttown001';
        $z_bk = 'cb';
        $z_shop = 'gm';
        $z_comm = 'km';
        $z_mas = 'rm';
        $z_pochta = 'post';
        $z_berezka = 'wm';
//      $z_podzem = 'tree';
        $z_bank = 'bank';
        $z_zoo = 'zvermag';
    } else {
        $fon = 'losttown001_moonnight';
        $z_bk = 'cb_n';
        $z_shop = 'gm_n';
        $z_comm = 'km_n';
        $z_mas = 'rm_n';
        $z_pochta = 'post_n';
        $z_berezka = 'wm_n';
//      $z_podzem = 'tree';
        $z_bank = 'bank_n';
        $z_zoo = 'zvermag_n';
    }
    echo "<table width=1><tr><td><div style=\"position:relative; cursor: pointer;\" id=\"ione\"><img src=\"i/city/",$fon,".jpg\" alt=\"\" border=\"0\"/>";
    buildset(1,"$z_bk",65,264,"Бойцовский клуб");
    buildset(2,"$z_shop",143,434,"Магазин");
    buildset(3,"2stop",160,415,"Первый комиссионный магазин");
    buildset(4,"$z_mas",189,331,"Ремонтная мастерская");
    buildset(6,"$z_pochta",84,228,"Почта");
//  buildset(5,"2pm",160,165,"Памятник");
    buildset(11,"$z_zoo",120,196,"Зоомагазин");
    buildset(7,"down",220,6,"Страшилкина улица");
//  buildset(8,"right",220,21,"Большая парковая улица");
    buildset(10,"$z_berezka",130,172,"Магазин Березка");
    buildset(12,"$z_bank",159,195,"Банк");

}
//buildset(9,"fir",137,235,"Новогодняя елка");
elseif ($user['room'] == 21)
{
    if((int)date("H") > 5 && (int)date("H") < 22) {
        $fon = 'losttown001_1';
                $z_podz='underground';
                $z_1ureg='klanreg';
                $z_1ubkill='tree';
                $z_fshop='flowerm';
                $z_zamok2= 'mozc';
                $z_loto= 'loto';

    } else {
        $fon = 'losttown001_1_night';
                $z_podz='underground_n';
                $z_1ureg='klanreg_n';
                $z_1ubkill='tree';
                $z_fshop='flowerm_n';
                $z_zamok2= 'mozc_n';
                $z_loto= 'loto_n';
    }
    echo "<table width=1><tr><td><div style=\"position:relative; cursor: pointer;\" id=\"ione\"><img src=\"i/city/",$fon,".jpg\" alt=\"\" border=\"0\"/>";
    buildset(5,"$z_podz",90,175,"Вход в водосток");
    buildset(2,"$z_1ureg",79,359,"Регистратура кланов");
//  buildset(10,"euroshop",150,85,"Сувенирный магазинчик");
    buildset(7,"$z_1ubkill",6,190,"Башня смерти");
//  buildset(3,"2stop",150,428,"Проход закрыт");
    buildset(6,"$z_fshop",50,383,"Цветочный магазин");
    buildset(4,"up",220,6,"Центральная площадь");
    buildset(1,"$z_zamok2",104,323,"Магазин Благородства");
        buildset(11,"$z_loto",29,399,"Лотерея");

} else echo "<script>document.location.replace('main.php');</script>";
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
$vsego_u = mysql_query("select id from `users`");
?>
<div id="snow"></div>

<div style="position:absolute; right:0px; top:0px; width:1px; height:1px; z-index:101; overflow:visible;">
<TABLE height=15 border="0" cellspacing="0" cellpadding="0">
<TR>
<TD rowspan=3 valign="bottom"><a href="?rnd=0.604083970286585"><img src="/i/move/rel_1.gif" width="15" height="16" alt="Обновить" border="0" /></a></TD>
<TD colspan="3"><img src="/i/move/navigatin_462s.gif" width="80" height="4" /></TD>
</TR>
<TR>
<TD><IMG src="/i/move/navigatin_481.gif" width="9" height="8"></TD>
<TD width=64 bgcolor=black><DIV class="MoveLine"><IMG src="/i/move/wait2.gif" id="MoveLine" class="MoveLine"></DIV></TD>
<TD><IMG src="/i/move/navigatin_50.gif" width="7" height="8"></TD>
</TR>
<TR>
<TD colspan="3"><IMG src="/i/move/navigatin_tt1_532.gif" width="80" height="5"></TD>
</TR>
</TABLE>
</div>
</div>

<tr><td align="right"><div align="right" id="btransfers"><table cellpadding="0" cellspacing="0" border="0" id="bmoveto">
<tr><td bgcolor="#D3D3D3">
<? if ($user['room'] == 20) { ?>
<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_1" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Бойцовский Клуб</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_2" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Магазин</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_4" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Ремонтная мастерская</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_3" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Комиссионный магазин</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_6" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Почтовое отделение</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_7" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Страшилкина улица</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_10" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Магазин Березка</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_12" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Банк</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_11" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Зоомагазин</a></span>

<?} elseif ($user['room'] == 21) { ?>
<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_11" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Лотерея</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_6" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Цветочный магазин</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_2" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Регистратура кланов</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_1" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Магазин Благородства</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_5" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Вход в водосток</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_7" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Башня Смерти</a></span>

<span style="white-space:nowrap; padding-left:3px; padding-right:3px; height:10px"><img src="/i/move/links.gif" width="9" height="7" />&nbsp;<a href="#" class="menutop" title="Время перехода: 10 сек." id="bmo_4" onmouseover="bimover(this);" onmouseout="bimout(this);" onclick="return bsolo(this);">Центральная площадь</a></span>

<? }

if($_SESSION['perehod']>time()){$vrme=$_SESSION['perehod']-time();}else{$vrme=0;}
?>
</td>
</tr>
</table></div></td></tr>
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
<div id="buttons_on_image" style="cursor:pointer; font-weight:bold; color:#D8D8D8; font-size:10px;">
<? if($user['room'] == 20){?>
<span onMouseMove="this.runtimeStyle.color = 'white';" onMouseOut="this.runtimeStyle.color = this.parentElement.style.color;" onclick="findlogin('Введите имя персонажа', 'city.php?nap=attack', 'target'); ">Напасть</span> &nbsp;
<?}?>
<span onMouseMove="this.runtimeStyle.color = 'white';" onMouseOut="this.runtimeStyle.color = this.parentElement.style.color;" onclick="window.open('/forum.php', 'forum', 'location=yes,menubar=yes,status=yes,resizable=yes,toolbar=yes,scrollbars=yes,scrollbars=yes')">Форум</span> &nbsp;
<span onMouseMove="this.runtimeStyle.color = 'white';" onMouseOut="this.runtimeStyle.color = this.parentElement.style.color;" onclick="window.open('help/city1.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">Подсказка</span> &nbsp;
</div>
<script language="javascript" type="text/javascript">
<!--
if (document.getElementById('ione')) {
document.getElementById('ione').appendChild(document.getElementById('buttons_on_image'));
document.getElementById('buttons_on_image').style.position = 'absolute';
document.getElementById('buttons_on_image').style.bottom = '8px';
document.getElementById('buttons_on_image').style.right = '23px';
} else {
document.getElementById('buttons_on_image').style.display = 'none';
}
-->
</script>
    <small>

    <B>Внимание!</B> Никогда и никому не говорите пароль от своего персонажа. Не вводите пароль на других сайтах, типа "новый город", "лотерея", "там, где все дают на халяву". Пароль не нужен ни паладинам, ни кланам, ни администрации, <U>только взломщикам</U> для кражи вашего героя.<BR>
    <I>Администрация.</I></small>
    <BR>
         Нас уже <?=mysql_num_rows($vsego_u)+121?> и из них в игре только <?=mysql_num_rows($online)+6?>.<BR><br>

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
    include("mail_ru.php"); ?>

    </TD>
</TR>
</TABLE>
</BODY>
</HTML>
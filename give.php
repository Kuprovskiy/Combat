<?php
    session_start();
    if ($_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    //$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
    include "functions.php";
    getfeatures($user);
    $giveprice=1-($user["dodgy"]*0.1);
    if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }
    if ($user['level'] < 4){  header("Location: index.php"); die(); }
    if ($user['in_tower']) {
      $step=1;
      if ($user['in_tower']==1 || $user['in_tower']==71) $mess="В Башне Смерти передачи запрещены.";
      else $mess="В БС передачи запрещены.";
      $_REQUEST=array();
    }
?><HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<SCRIPT src='i/commoninf.js'></SCRIPT>
<SCRIPT>
var Hint3Name = '';
// Заголовок, название скрипта, имя поля с логином
function findlogin(title, script, name){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
    '<form action="'+script+'" method=POST><table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"><td colspan=2>'+
    'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD width=50% align=right><INPUT TYPE=text id="'+name+'" NAME="'+name+'"></TD><TD width=50%><INPUT TYPE="submit" value=" »» "></TD></TR></TABLE></FORM></td></tr></table>';
    document.getElementById("hint3").style.visibility = "visible";
    document.getElementById("hint3").style.left = 100;
    document.getElementById("hint3").style.top = 100;
    document.getElementById(name).focus();
    Hint3Name = name;
}



function returned2(s){
    if (top.oldlocation != '') { top.frames['main'].location=top.oldlocation+'?'+s+'tmp='+Math.random(); top.oldlocation=''; }
    else { top.frames['main'].location='main.php?edit='+Math.random() }
}
<?
$step=1;
if ($step==1) $idkomu=0;
?>
function closehint3(){
    document.all("hint3").style.visibility="hidden";
    Hint3Name='';
}


var transfersale = true;
<?


if (@!$_REQUEST['razdel']) { $_REQUEST['razdel']=1; }
if (@$_REQUEST['FindLogin']) {
    $res=mysql_fetch_array(mysql_query("SELECT `id`, `level`, `room`, `align`, (select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = users.`id`) as `online` FROM `users` WHERE `login` ='".mysql_escape_string($_REQUEST['FindLogin'])."';"));
    $step=3;
}
if (@$_REQUEST['to_id']) {
    $res=mysql_fetch_array(mysql_query("SELECT `id`, `level`, `room`, `align`, (select `id` from `online` WHERE `online`.`date` >= ".(time()-60)." AND `online`.`id` = users.`id`) as `online` FROM `users` WHERE `id` ='".mysql_escape_string($_REQUEST['to_id'])."';"));
    $step=3;
}

$cond="AND `present` = '' ".(@$res['id']==924 || $user[id]==924?"":" AND `destinyinv`<2 AND `artefact` =0")." AND `honor` =0 AND `podzem`<>1 and podzem<>2 and type<>189 and type<>199 and type<>54 and type<>201 AND name NOT LIKE '%лотерейный билет%'";

if (@$step==3){
    $step=0;
    $id_person_x=$res['id'];
    getadditdata($user);
    getfeatures($user);
    $isInjury = mysql_fetch_array(mq("SELECT * FROM `effects` WHERE `owner` = '".$user['id']."' AND (`type` = 14 OR `type` = 13) ORDER BY type DESC;"));
    if ($user["deals"]>=$user["communicable"]*20+100) $mess='Вы исчерпали свой лимит передач на сегодня';     
    elseif ($isInjury) $mess='У персонажа тяжелая травма - не может драться, перемещаться и передавать предметы ещё ' . lefttime($isInjury['time']);
    elseif (@!$id_person_x) $mess='Персонаж не найден';
    elseif ($id_person_x==$user['id'] && $user['id'] != 7) $mess='Незачем передавать самому себе';
    elseif ($res['align']==4 && $_SESSION["uid"]!=7) $mess='Со склонностью хаос передачи предметов запрещены';
    elseif ($user['align']==4) $mess='Со склонностью хаос передачи предметов запрещены';
    elseif ($res['online']<1 && $_SESSION["uid"]!=7) $mess='Персонаж не онлайн';
    elseif ($res['room']!=$user['room'] && $user["id"]!=7) $mess='Вы должны находиться в одной комнате с тем кому хотите передать вещи';
    elseif ($res['level']<1) $mess='К персонажам до 1-го уровня передачи предметов запрещены';
    elseif ($user['level']<8) $mess='Персонажам до 8-го уровня передачи предметов запрещены';
    else{
        $idkomu=$id_person_x;
        $komu=mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` ='".$idkomu."';"));
        $mess=$_REQUEST['FindLogin'];
        $step=3;
    }
} elseif (!$user["in_tower"]) $mess='К персонажам до 1-го уровня передачи предметов запрещены';
 elseif ($user['level']<8) $mess='Персонажам до 8-го уровня передачи предметов запрещены';
if ($step==3) {
    if ($_REQUEST['setkredit']>0 && $_REQUEST['to_id'] && $_REQUEST['sd4']==$user['id'] ) {
        $_REQUEST['setkredit'] = round($_REQUEST['setkredit'],2);
        if ($user['money']<$_REQUEST['setkredit']) $mess="Недостаточно денег";
        elseif (!cangive($_REQUEST['setkredit'])) $mess="Передаваемая сумма превышает допустимый лимит";
        else {
            if ((mysql_query("UPDATE `users` set money=money-".strval($_REQUEST[setkredit])." where id='".$user['id']."'")) && (mysql_query("UPDATE `users` set money=money+".strval($_REQUEST[setkredit])." where id='".$idkomu."'"))) {
                updbalance($user['id'], $idkomu, $_REQUEST["setkredit"]);
                $mess='Удачно переданы '.strval($_REQUEST[setkredit]).' кр к персонажу '.$komu['login'];
                mq("update userdata set deals=deals+1 where id='$user[id]'");
                addchp ('<font color=red>Внимание!</font> Персонаж "'.$user['login'].'" передал вам <B>'.strval($_REQUEST[setkredit]).' кр</B>.   ','{[]}'.$komu['login'].'{[]}');
                $komudata=mqfa("select money, ekr from users where id='$idkomu'");
                $user['money']-=$_REQUEST[setkredit];
                mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','Переведены кредиты ".strval($_REQUEST[setkredit])." от \"".$user['login']."\" к \"".$komu['login']."\" ($user[money]/$user[ekr])','1','".time()."');");
                mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$idkomu}','Переведены кредиты ".strval($_REQUEST[setkredit])." от \"".$user['login']."\" к \"".$komu['login']." ($komudata[money]/$komudata[ekr])\"','1','".time()."');");
            }
            else {
                $mess='Произошла ошибка!';
            }
        }
    }
    if ($_REQUEST['paycast']>0 && $_REQUEST['to_id'] && $_REQUEST['sd4']==$user['id'] ) {
        $_REQUEST['setkredit'] = round($_REQUEST['paycast'],2);
        $eff=mqfa("select id, sila, lovk, inta, intel, mudra, mfdmag, mfdhit, name from effects where owner='$user[id]' and caster='$idkomu' order by id");
        if ($eff["sila"]>=100 || $eff["lovk"]>=100 || $eff["inta"]>=100 || $eff["intel"]>=100 || $eff["mudra"]>=100
        || $eff["mfdmag"]>=500|| $eff["mfhit"]>=500) $maxprice=300;
        else $maxprice=10;
        if ($user['money']<$_REQUEST['setkredit']) $mess="Недостаточно денег";
        elseif (!$eff) $mess="Персонаж $komu[login] не накладывал на вас заклинание или вы уже его оплатили.";
        elseif ($_REQUEST['setkredit']>$maxprice) $mess="Максимальная стоимость этого заклинания $maxprice кр.";
        elseif (!$eff) $mess="Персонаж $komu[login] не накладывал на вас заклинание или вы уже его оплатили.";
        else {
            if ((mysql_query("UPDATE `users` set money=money-".strval($_REQUEST[setkredit])." where id='".$user['id']."'")) && (mysql_query("UPDATE `users` set money=money+".strval($_REQUEST[setkredit])." where id='".$idkomu."'"))) {
              mq("update effects set caster=0 where id='$eff[id]'");
                $mess='Удачно переданы '.strval($_REQUEST[setkredit]).' кр к персонажу '.$komu['login']." за заклинание $eff[name].";
                mq("update userdata set deals=deals+1 where id='$user[id]'");
                addchp ('<font color=red>Внимание!</font> Персонаж "'.$user['login'].'" передал вам <B>'.strval($_REQUEST[setkredit]).' кр</B> за каст '.$eff["name"].'.','{[]}'.$komu['login'].'{[]}');
                $komudata=mqfa("select money, ekr from users where id='$idkomu'");
                $user['money']-=$_REQUEST[setkredit];
                mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','Переведены кредиты ".strval($_REQUEST[setkredit])." от \"".$user['login']."\" к \"".$komu['login']."\" ($user[money]/$user[ekr]) за каст $eff[name]','1','".time()."');");
                mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$idkomu}','Переведены кредиты ".strval($_REQUEST[setkredit])." от \"".$user['login']."\" к \"".$komu['login']." ($komudata[money]/$komudata[ekr])\" за каст $eff[name]','1','".time()."');");
            }
            else {
                $mess='Произошла ошибка!';
            }
        }
    }
    if ($_REQUEST['setekredit']>0 && $_REQUEST['to_id'] && $_REQUEST['sd4']==$user['id'] ) {
        $_REQUEST['setekredit'] = round($_REQUEST['setekredit'],2);
        if ($user['ekr']<$_REQUEST['setekredit']) $mess="Недостаточно денег";
        elseif (!cangive($_REQUEST['setekredit']*11)) $mess="Передаваемая сумма превышает допустимый лимит";
        else {
            if ((mysql_query("UPDATE `users` set ekr=ekr-".strval($_REQUEST[setekredit])." where id='".$user['id']."'")) && (mysql_query("UPDATE `users` set ekr=ekr+".strval($_REQUEST[setekredit])." where id='".$idkomu."'"))) {
                $mess='Удачно переданы '.strval($_REQUEST[setekredit]).' екр к персонажу '.$komu['login'];
                updbalance($user['id'], $idkomu, $_REQUEST["setkredit"]*11);
                mq("update userdata set deals=deals+1 where id='$user[id]'");
                addchp ('<font color=red>Внимание!</font> Персонаж "'.$user['login'].'" передал вам <B>'.strval($_REQUEST[setekredit]).' екр</B>.   ','{[]}'.$komu['login'].'{[]}');
                    mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','Переведены ЕвроКредиты ".strval($_REQUEST[setekredit])." от \"".$user['login']."\" к \"".$komu['login']."\" ($user[money]/$user[ekr])','1','".time()."');");
                    mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$idkomu}','Переведены ЕвроКредиты ".strval($_REQUEST[setekredit])." от \"".$user['login']."\" к \"".$komu['login']."\"','1','".time()."');");
                $user['money']-=$_REQUEST[setekredit];
            }
            else {
                $mess='Произошла ошибка!';
            }
        }
    }
    if ($_REQUEST['setobject'] && $_REQUEST['to_id'] && !$_REQUEST['gift'] && $_REQUEST['sd4']==$user['id'] && $_GET['s4i']==$user['sid']) {

        $res = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `id` = '{$_REQUEST['setobject']}' AND dressed=0 AND `setsale` = 0 $cond LIMIT 1;"));
        if (!$res['id']) $mess="Предмет не найден в рюкзаке";
        elseif ($res['dressed']!=0) $mess="Сначала необходимо снять предмет с себя.";
        elseif (mqfa1('SELECT COUNT(*) FROM clanstorage WHERE id_it = ' . $res['id'])) $mess="Эта вещь принадлежит Клану. Вы не можете ее передавать или продать";
        elseif ($user['money']<$giveprice) $mess='Недостаточно денег на оплату передачи';
        else {
            $value=$res;
            $prc=itemprice($res);
            if (!cangive($prc["price"])) {
              $mess='Цена вещи превышает допустимый лимит передач';
            } elseif ($value['present'] && $user["id"]!=7 && $idkomu!=924 && $user["id"]!=924) $mess='Нельзя передавать подарки';
            elseif ($value['destinyinv']==2 && $user["id"]!=7 && $idkomu!=924 && $user["id"]!=924) $mess='Вещь связана с вами общей судьбой';
            else{
                $mto = mysql_fetch_array(mysql_query("SELECT sum(`massa`) FROM `inventory` WHERE `owner` = '$idkomu' AND `dressed` = 0 AND `honor` = 0 AND `artefact` = 0 AND `setsale` = 0; "));
                
                $u = $user;
                $user['id'] = $idkomu;
                $allmass=get_meshok_to($idkomu);
                $user = $u;

                $newmass=$mto[0]+$res['massa'];
                if ($newmass<=$allmass || $_SESSION["uid"]==7) {
                    if ((mysql_query("update `users` set `money`=`money`-$giveprice where `id`='".$user['id']."'")) && (mysql_query("update `inventory` set `owner` = ".$komu['id']." where `id`='".$res['id']."' and `owner`= '".$user['id']."';"))) {
                        if ($user["in_tower"]!=1) {
                            mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','Передан предмет \"".$res['name']." ".($res["koll"]?"(x$res[koll])":"")."\" id:(cap".$res['id'].") [".$res['duration']."/".$res['maxdur']."] от \"".$user['login']."\" к \"".$komu['login']."\", налог 1 кр ($user[money]/$user[ekr]).','1','".time()."');");
                            mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$idkomu}','Передан предмет \"".$res['name']."\" ".($res["koll"]?"(x$res[koll])":"")." id:(cap".$res['id'].") [".$res['duration']."/".$res['maxdur']."] от \"".$user['login']."\" к \"".$komu['login']."\", налог 1 кр.','1','".time()."');");
                            updbalance($user['id'], $idkomu, $prc["price"]);
                        }
                        $mess='Удачно передано "'.$value['name'].'" к персонажу '.$komu['login'];
                        mq("update userdata set deals=deals+1 where id='$user[id]'");
                        addchp ('<font color=red>Внимание!</font> Персонаж "'.$user['login'].'" передал вам "'.$value['name'].'".   ','{[]}'.$komu['login'].'{[]}');
                        $user['money']-=$giveprice;
                    }
                    else {
                        $mess='Произошла ошибка!';
                    }
                }
                else {
                    $mess='У персонажа "'.$komu['login'].'" переполнен рюкзак!';
                }
            }
        }
    }
    if ($_REQUEST['setobject'] && $_REQUEST['to_id'] && $_REQUEST['gift'] && $_REQUEST['sd4']==$user['id'] && $_GET['s4i']==$user['sid']) {
        $res = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `id` = '{$_REQUEST['setobject']}' AND dressed=0 AND `setsale` = 0 AND `present` = '' AND `destinyinv`<2 AND `honor` = 0 AND `artefact` = 0 AND `podzem`=0 and koll=0 LIMIT 1;"));
        if (!$res['id']) $mess="Предмет не найден в рюкзаке";
        elseif ($res['dressed']!=0) $mess="Сначала необходимо снять предмет с себя.";
        elseif (mqfa1('SELECT COUNT(*) FROM clanstorage WHERE id_it = ' . $res['id'])) $mess="Эта вещь принадлежит Клану. Вы не можете ее передавать или продать";
        else {
            $value=$res;
            $prc=itemprice($res);
            if (!cangive($prc["price"])) {
              $mess='Цена вещи превышает допустимый лимит передач';
            } elseif (@$value['present']) $mess='Нельзя передавать подарки';
            elseif ($value['destinyinv']==2) $mess='Вещь связана с вами общей судьбой';
            else{
                $mto = mysql_fetch_array(mysql_query("SELECT sum(`massa`) FROM `inventory` WHERE `owner` = '$idkomu' AND `dressed` = 0 AND `setsale` = 0; "));

                $u = $user;
                $user['id'] = $idkomu;
                $allmass=get_meshok_to($idkomu);
                $user = $u;

                $newmass=$mto[0]+$res['massa'];
                if ($newmass<=$allmass) {
                    if (mysql_query("update `inventory` set `present` = '{$user['login']}' ,`owner` = ".$komu['id']." where `id`='".$res['id']."' and `owner`= '".$user['id']."';")) {
                        addchp ('<font color=red>Внимание!</font> Персонаж "'.$user['login'].'" подарил вам "'.$value['name'].'"</B>.   ','{[]}'.$komu['login'].'{[]}');
                        if ($user["in_tower"]!=1) {
                            mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','Подарен предмет \"".$res['name']."\" id:(cap".$res['id'].") [".$res['duration']."/".$res['maxdur']."] от \"".$user['login']."\" к \"".$komu['login']."\" ($user[money]/$user[ekr])','1','".time()."');");
                            mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$idkomu}','Подарен предмет \"".$res['name']."\" id:(cap".$res['id'].") [".$res['duration']."/".$res['maxdur']."] от \"".$user['login']."\" к \"".$komu['login']."\"','1','".time()."');");
                            updbalance($user['id'], $komu['id'], $prc["price"]);
                        }
                        $mess='Удачно подарен предмет "'.$value['name'].'"  персонажу '.$komu['login'];
                    }
                    else {
                        $mess='Произошла ошибка!';
                    }
                }
                else {
                    $mess='У персонажа "'.$komu['login'].'" переполнен рюкзак!';
                }
            }
        }
    }

    if ($_REQUEST['cost'] > 0 && $_REQUEST['to_id']) {
        $res = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed`=0 AND `honor` =0 AND `artefact` =0  AND `id` = '{$_REQUEST['id_th']}' LIMIT 1;"));
        $price=itemprice($res);
        if (!$res['id']) $mess="Предмет не найден в рюкзаке";
        elseif ($res['dressed']!=0) $mess="Сначала необходимо снять предмет.";
        elseif (mqfa1('SELECT COUNT(*) FROM clanstorage WHERE id_it = ' . $res['id'])) $mess="Эта вещь принадлежит Клану. Вы не можете ее передавать или продать";
        else {
            $value=$res;
            if (@$value['present']) $mess='Нельзя передавать подарки';
            elseif ($value['destinyinv']==2) $mess='Вещь связана с вами общей судьбой';
            elseif ($_REQUEST['cost']<$price["minprice"]) $mess='Минимальная цена продажи '.$price["minprice"].' кр';
            elseif ($_REQUEST['cost']>$price["maxprice"]) $mess='Максимальная цена продажи '.$price["maxprice"].' кр';
            else{
                #KOMOK_LOG
                $row = $res;
                    function calb ($b) {
                        global $re;
                            $re .= $b;
                    }
                    $row['count'] = 1;
                    //$color = '#D5D5D5';
                    $re .= "<table width=100%><TR ><TD align=center ><IMG SRC=\"".IMGBASE."/i/sh/{$row['img']}\" BORDER=0><BR></TD>";
                    $re .= "<TD valign=top>";

                    //function calb($t) {
                    //    global $re;
                    //    $re .= $t;
                    //}

                    ob_start();
                        showitem ($row);
                    //ob_end_flush();
                    $re .= ob_get_clean();
                    $re .= "</TD></TR></table>";
                    $re = str_replace("\n","",$re);
                    $re = str_replace("'","\\'",$re);
                    $mess = 'Предложение персонажу '.$komu['login'].' сделано.';
                    privatemsg("Поступило предложение покупки от персонажа $user[login]. <b>$row[name] ".($row["koll"]?"($row[koll])":"")."</b> за $_REQUEST[cost] кр.", $komu['login']);
                    mq("update `inventory` set `tradesale` = ".$_REQUEST['cost']." where `id`='".$res['id']."' and `owner`= '".$res['owner']."';");
                    mq("INSERT INTO `trade`(`to_id` ,`login`  ,`txt` ,`kr` ,`id` ,`baer` ) VALUES
                            ('{$_SESSION['uid']}','{$user['login']}','".$re."',{$_REQUEST['cost']},'{$_REQUEST['id_th']}',{$_REQUEST['to_id']});");

            }
        }

    }

    if ($_REQUEST['transfersale'] && $_REQUEST['to_id']) {
        $res = mysql_fetch_array(mysql_query("SELECT * FROM `inventory` WHERE `dressed`=0 AND `owner` = '{$_REQUEST['to_id']}' AND `id` = '{$_REQUEST['transfersale']}' LIMIT 1;"));
        if (!$res) {
            $mess ='<font color=red><b>Продавец отменил сделку</b></font>';
        } elseif($user['money'] < $res['tradesale']) {
            $mess ='<font color=red><b>Не хватает денег для проведения операции</b></font>';
        }
        else
        {
            mysql_query("update `inventory` set `owner` = ".$user['id']." where `id`='".$res['id']."' and `owner`= '".$res['owner']."';");
            mysql_query("update `users` set `money`=`money`-{$res['tradesale']} where `id`='".$user['id']."'");

            
            getfeatures($usr, $_REQUEST['to_id']);
            mysql_query("update `users` set `money`=`money`+{$res['tradesale']}-".(1-($usr["dodgy"]*0.1))." where `id`='{$_REQUEST['to_id']}'");
            if (($user['room'] < 501) || ($user['room'] > 560)) {
                mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','Продажа за {$res['tradesale']}кр $res[name] (ID:".$res['id'].")  к $komu[login] (".$idkomu.") ($user[money]/$user[ekr])',1,'".time()."');");
                mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$idkomu}','Продажа за {$res['tradesale']}кр $res[name] (ID:".$res['id'].")  от $user[login] (".$_SESSION['uid'].")',1,'".time()."');");
            }
            $mess='Удачно куплено "'.$res['name'].'"  у персонажа '.$komu['login'];
            $mess2='Удачно продано "'.$res['name'].'"  персонажу '.$user['login'];
            addchp ('<font color=red>Внимание!</font>  '.$mess2,'{[]}'.$komu['login'].'{[]}');
            $user['money']-=$res['tradesale'];
        }
    }

}
?>

function findmoney(title, script, name, obj){
    document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
    '<form action="'+script+'" method=get><table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><INPUT TYPE=hidden name=id_th value="'+obj+'"><INPUT TYPE=hidden name=to_id value="<? echo @$komu['id']; ?>"><td colspan=2>'+
    'Укажите cумму:<small></TD></TR><TR><TD width=50% align=right><INPUT TYPE=text NAME="'+name+'"></TD><TD width=50%><INPUT TYPE="submit" value=" »» "></TD></TR></TABLE></FORM></td></tr></table>';
    document.all("hint3").style.visibility = "visible";
    document.all("hint3").style.left = 100;
    document.all("hint3").style.top = 100;
    document.all(name).focus();
    Hint3Name = name;
}

var tologin = '<? echo @($step==3?$komu['login']:''); ?>';
function Sale(to_id, name, n, txt, transfer_kredit){
    var s = prompt("Продать \""+txt+"\" к \""+tologin+"\". Укажите цену:", '');
    if (s != null && s!= '') { // продаем
        if (confirm("Продать \""+txt+"\" к \""+tologin+"\" за "+parseFloat(s)+" кр. Вы заплатите "+transfer_kredit+"кр. за передачу! Ваш партнер по сделке должен открыть у себя окно обмена. Продолжить?")) {
           location="/main.php?to_id="+to_id+"&setobject="+name+"&n="+n+"&s4i=<?=$user['sid']?>&sale="+s+"&sd4=<? echo @$user['id']; ?>&0.760742158507544";
        }
    }
}
function transfer(to_id, login, txt, kredit, id, destiny){
    document.getElementById("hint3").innerHTML = '<table width=500 cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>Продажа предмета</td></tr><tr><td>'+
    '<form action="give.php" method=get><table width=100% cellspacing=0 cellpadding=5 bgcolor=FFF6DD><tr><td><INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>"><INPUT TYPE=hidden name=FindLogin value=0><INPUT TYPE=hidden name=to_id value="'+to_id+'"><INPUT TYPE=hidden name=transfersale value="'+id+'">'+
    '<b>'+login+'</b> <a href="inf.php?'+to_id+'" target=_blank><IMG SRC=<?=IMGBASE?>/i/inf.gif WIDTH=12 HEIGHT=11></a> предлагает Вам купить предмет:<BR>'+
    txt+'<BR>за <font color=red><b>'+kredit+' кр.</b></font><BR>Проводим сделку?</TD></TR><TR><TD align=center><INPUT TYPE=submit '+(destiny?" onclick='return confirm(\"Этот предмет может использовать только "+destiny+" Вы уверены, что хотите его купить?\")'":"")+' value="  ДА  "> &nbsp;&nbsp; <INPUT TYPE=button value=" НЕТ " onclick="closehint3()"></TD></TR></TABLE></FORM></td></tr></table>';
    document.getElementById("hint3").style.visibility = "visible";
    document.getElementById("hint3").style.left = 100;
    document.getElementById("hint3").style.top = 60;
}
function reloadit(){
   if (tologin != '') { location="give.php?FindLogin=0&to_id=<? echo $idkomu; ?>&sd4=<? echo $user['id']; ?>&0.760742158507544" }
}
</SCRIPT>
</HEAD>
<body bgcolor=e2e0e0><div id=hint3 class=ahint></div><div id=hint4 class=ahint></div>

<H3>Передача предметов/кредитов другому игроку</H3>
<TABLE width=100% cellspacing=0 cellpadding=0>
<TR><TD>
<? if ($step==3) {
echo 'К кому передавать: <font color=red><SCRIPT>drwfl("'.@$komu['login'].'",'.@$komu['id'].',"'.@$komu['level'].'","'.@$komu['align'].'","'.@$komu['klan'].'")</SCRIPT></font>';
?> <INPUT TYPE=button value="Сменить" onClick="findlogin('Передача предметов','give.php','FindLogin')"><BR><?
}else{
    $roww = mysql_fetch_array(mq("SELECT * FROM `trade` WHERE `baer` = {$user['id']} LIMIT 1;"));
    mysql_query("DELETE FROM `trade` WHERE `baer` = {$user['id']} LIMIT 1;");
    $rwx = mysql_fetch_array(mysql_query("SELECT `id` FROM `inventory` WHERE `owner` = '".$roww['to_id']."' AND `tradesale` > 0 AND `id` = '".$roww['id']."' LIMIT 1;"));
    if (!$roww['id'] OR !$rwx['id']) {
      if (!$user["in_tower"]) echo "<SCRIPT>findlogin('Передача предметов','give.php','FindLogin');</SCRIPT>";
    }
else
 {
   $mess="";
    $roww['txt']=str_replace("'","\\'","$roww[txt]");
    ?> <SCRIPT>transfer(<?=$roww['to_id']?>, '<?=$roww['login']?>', '<?=str_replace("\r\n","",$roww['txt'])?>', <?=$roww['kr']?>, <?=$roww['id']?>, '');</SCRIPT><?

 }
}
?>

</td><TD align=right>
    <INPUT TYPE=button value="Подсказка" style="background-color:#A9AFC0" onClick="window.open('help/transfer.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">
    <INPUT TYPE=button value="Вернуться" onClick="returned2('setcancel=1&')">
</td></tr><tr><td colspan=2 align=right><? if ($step!=4) {?> <FONT COLOR=red><B><? echo $mess; ?></B></FONT> <? } ?></td></tr></table>

<TABLE width=100% cellspacing=0 cellpadding=0>
<FORM ACTION="give.php" METHOD=POST>
<TR>
    <TD valign=top align=left width=40%>
<?
    if ($step==3) { ?>
    <INPUT TYPE=hidden name=to_id value="<? echo $idkomu; ?>">
    <INPUT TYPE=hidden name=sd4 value="<? echo $user['id']; ?>">
    <BR>У вас на счету: <FONT COLOR=339900><B><? echo $user['money']; ?></B></FONT> кр.<BR>
    <small><BR>Передать кредиты, минимально 0.01кр.<BR></small>
    Укажите передаваемую сумму кр: <INPUT TYPE=text onkeydown="document.getElementById('paycast').value=''" id="setkredit" NAME=setkredit maxlength=8 size=6>&nbsp;<INPUT TYPE=submit VALUE="Передать"><br><br>

    <?
/*
<!--    <BR>-------------------------------------------------
    <BR>У вас на счету: <FONT COLOR=339900><B><? echo $user['ekr']; ?></B></FONT> екр.<BR>
    <small><BR>Передать ЕвроКредиты, минимально 1 екр.<BR></small>
    Укажите передаваемую сумму екр: <INPUT TYPE=text NAME=setekredit maxlength=8 size=6>&nbsp;<INPUT TYPE=submit VALUE="Передать">
-->*/
    }
?>
    </TD>
</FORM>

<FORM ACTION="give.php" METHOD=POST>
<INPUT TYPE=hidden name=sd4 value="<? echo @$user['id']; ?>">
<TD valign=top align=right>

<?
if ($step==3) {


    if (@$_GET['razdel'] == '0') { $_SESSION['razdel'] = 0; }
    if (@$_GET['razdel'] == 1) { $_SESSION['razdel'] = 1; }
    if (@$_GET['razdel'] == 2) { $_SESSION['razdel'] = 2; }
    if (@$_GET['razdel'] == 3) { $_SESSION['razdel'] = 3; }
    if (@$_GET['razdel'] == 4) { $_SESSION['razdel'] = 4; }
    if (@$_GET['razdel'] == 5) { $_SESSION['razdel'] = 5; }
    if (@$_GET['razdel'] == 6) { $_SESSION['razdel'] = 6; }

?>
<TABLE border=0 width=100% cellspacing="0" cellpadding="0" bgcolor="#A5A5A5">
<TR><TD>
    <TABLE border=0 width=100% cellspacing="0" cellpadding="3" bgcolor=#d4d2d2><TR>
    <TD  align=center bgcolor="<?=($_SESSION['razdel']==null)?"#A5A5A5":"#C7C7C7"?>"><A HREF="?to_id=<? echo $idkomu; ?>&edit=1&razdel=0&sd4=<? echo $user['id']; ?>">Обмундирование</A></TD>
    <TD  align=center bgcolor="<?=($_SESSION['razdel']==1)?"#A5A5A5":"#C7C7C7"?>"><A HREF="?to_id=<? echo $idkomu; ?>&edit=1&razdel=1&sd4=<? echo $user['id']; ?>">Заклятия</A></TD>
    <TD  align=center bgcolor="<?=($_SESSION['razdel']==2)?"#A5A5A5":"#C7C7C7"?>"><A HREF="?to_id=<? echo $idkomu; ?>&edit=1&razdel=2&sd4=<? echo $user['id']; ?>">Эликсиры</A></TD>
    <TD  align=center bgcolor="<?=($_SESSION['razdel']==6)?"#A5A5A5":"#C7C7C7"?>"><A HREF="?to_id=<? echo $idkomu; ?>&edit=1&razdel=6&sd4=<? echo $user['id']; ?>">Руны</A></TD>
    <TD  align=center bgcolor="<?=($_SESSION['razdel']==3)?"#A5A5A5":"#C7C7C7"?>"><A HREF="?to_id=<? echo $idkomu; ?>&edit=1&razdel=3&sd4=<? echo $user['id']; ?>">Еда</A></TD>
    <TD  align=center bgcolor="<?=($_SESSION['razdel']==4)?"#A5A5A5":"#C7C7C7"?>"><A HREF="?to_id=<? echo $idkomu; ?>&edit=1&razdel=4&sd4=<? echo $user['id']; ?>">Ресурсы</A></TD>
    <TD  align=center bgcolor="<?=($_SESSION['razdel']==5)?"#A5A5A5":"#C7C7C7"?>"><A HREF="?to_id=<? echo $idkomu; ?>&edit=1&razdel=5&sd4=<? echo $user['id']; ?>">Прочее</A></TD>
    </TR></TABLE>
</TD></TR>
<TR>
    <TD align=center><B>Рюкзак (масса: <?php

    $d = mysql_fetch_array(mysql_query("SELECT sum(`massa`) FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `artefact` ='0' AND `honor` ='' AND `setsale` = 0; "));

    echo $d[0];
    ?>/<?=get_meshok()?>)</B></TD>
</TR>
<TR><TD align=center><!--Рюкзак-->
<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">
<?php


    if ($_SESSION['razdel']==null) {
        $data = mqfaa("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `type` < 25 AND `setsale` = 0 $cond ORDER by `update` DESC; ");
    }
    if ($_SESSION['razdel']==1) {
        $data = mqfaa("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `type` = 25 AND `setsale` = 0 $cond  ORDER by `update` DESC; ");
    }
    if ($_SESSION['razdel']==2) {
        $data = mqfaa("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND (`type` = 188 or `type` = 187) AND `setsale` = 0 $cond  ORDER by `update` DESC; ");
    }
    if ($_SESSION['razdel']==3) {
        $data = mqfaa("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `type` = 49 AND `setsale` = 0 $cond  ORDER by `update` DESC; ");
    }
    if ($_SESSION['razdel']==4) {
        //if ($user['id'] == 7) {
            $grass = mqfaa("SELECT name FROM smallitems WHERE id >= 24 AND id <= 36");
            $grassCond = "name = '" . $grass[0]['name'] . "'";
            for ($i = 1; $i < count($grass); $i++ ) {
                $grassCond .= " OR name = '" . $grass[$i]['name'] . "'";
            }
            $gCond = str_replace('type<>189', '(`type` = 190 OR (type = 189 AND (' . $grassCond . ')))', $cond);
            $data = mqfaa("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 $gCond AND `setsale` = 0 ORDER by `update` DESC; ");
        //} else {
            //$data = mqfaa("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND (`type` = 189 or `type` = 190) AND `setsale` = 0 $cond  ORDER by `update` DESC; ");
        //}
    }
    if ($_SESSION['razdel']==5) {
        $data = mqfaa("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND (`type` >= 50 and type<>60 AND `type` != 187 AND `type` != 188 AND `type` != 189 AND `type` != 190) AND `setsale` = 0 $cond  ORDER by `update` DESC; ");
    }
    if ($_SESSION['razdel']==6) {
        $data = mqfaa("SELECT * FROM `inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND type=60 AND `setsale` = 0 $cond  ORDER by `update` DESC; ");
    }

    //while($row = mysql_fetch_array($data)) {
    if ($data) { 
        foreach ($data as $row) {
            $row['count'] = 1;
            if (@$i==0) { 
                $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; 
            }
            echo "<TR bgcolor={$color}><TD style=\"white-space:nowrap;\" align=center ><IMG SRC=\"".IMGBASE."/i/sh/{$row['img']}\" BORDER=0>";
            echo '<br><br>';
            if (isset($row['items_count']) && $row['items_count'] > 1) {
                echo 'Кол-во:&nbsp;<input style="text-align: center; font-size: 1.1em;" size="2" type="text" name="items_count" value="' . $row['items_count'] . '">&nbsp;из&nbsp;' . $row['items_count'] . '<br>';
            }
            echo "<A HREF=\"give.php?to_id=".$idkomu."&id_th=".$row['id']."&setobject=".$row['id']."&s4i=".$user['sid']."&sd4=".$user['id']."&tmp=".rand(0,50000000)."\"".'onclick="return confirm(\'Передать предмет '.$row['name'].'?\')">передать&nbsp;за&nbsp;'.$giveprice.'&nbsp;кр.</A>';
            if (!$row["koll"]) {
                echo "<br><A HREF=\"give.php?to_id=".$idkomu."&id_th=".$row['id']."&setobject=".$row['id']."&gift=1&s4i=".$user['sid']."&sd4=".$user['id']."&tmp=".rand(0,50000000)."\"".'onclick="return confirm(\'Подарить предмет '.$row['name'].'?\')">подарить</A>';
            }
            echo "<br><A HREF=#".' onClick="findmoney(\'Продажа предмета\',\'give.php\',\'cost\','.$row['id'].')">продать</A>';
            echo "</td>";
            echo "<TD valign=top>";
            showitem ($row);
            echo "</TD></TR>";
        }
    } else {
        echo "<tr><td align=center bgcolor=#C7C7C7>Пусто</td></tr>";
    }
?>



</TABLE>
</TD></TR>
</TABLE><?php
 }
?>


</TD></TR>
</FORM>
</TABLE>

</BODY>
</HTML>

<?
function startpod($who,$bot,$nomer,$user){
$query=mysql_query("SELECT id FROM users WHERE login='".mysql_real_escape_string($who)."'");
$db=mysql_fetch_array($query);
$name2="";
$name3="";
if($bot=='1'){$name = "Паук"; $d1 = "Паук";}
else if($bot=='2'){$name = "Зомби"; $d1 = "Зомби";}
else if($bot=='3'){$name = "Жук"; $d1 = "Жук";}


else if($bot=='4'){$name = "Мерзость"; $d1 = "Мерзость";}
else if($bot=='5'){$name = "Обитатель"; $d1 = "Обитатель";}
else if($bot=='6'){$name = "Жудкий"; $d1 = "Жудкий";}
else if($bot=='7'){$name = "Мартын"; $d1 = "Мартын";}
else if($bot=='8'){$name = "Лука"; $d1 = "Лука";}

//////////////////2 этаж/////////////////////
else if($bot=='9'){$name = "Крыса"; $d1 = "Крыса";}
else if($bot=='10'){$name = "Безголовый"; $d1 = "Безголовый";}
else if($bot=='11'){$name = "Стальной"; $d1 = "Стальной";}
else if($bot=='12'){$name = "Кровавый"; $d1 = "Кровавый";}
else if($bot=='13'){$name = "Мышь"; $d1 = "Мышь";}
else if($bot=='14'){$name = "Прораб"; $d1 = "Прораб";}
else if($bot=='15'){$name = "Слесарь"; $d1 = "Слесарь";}
else if($bot=='16'){$name = "Слизь"; $d1 = "Слизь";}
else if($bot=='17'){$name = "Старожил"; $d1 = "Старожил";}
else if($bot=='18'){$name = "Хозяин"; $d1 = "Хозяин";}
////////////////////////Подземелье 1000 проклятий////////////////////////////////////
else if($bot=='19'){$name = "Бродячий Труп"; $d1 = "Бродячий Труп";}
else if($bot=='20'){$name = "Изи"; $d1 = "Изи";}
else if($bot=='21'){$name = "Кошмар Глубин"; $d1 = "Кошмар Глубин";}
else if($bot=='22'){$name = "Проклятие Глубин"; $d1 = "Проклятие Глубин";}
else if($bot=='23'){$name = "Ужас Глубин"; $d1 = "Ужас Глубин";}

else if($bot=='24'){$name = "Бес"; $d1 = "Бес";}
else if($bot=='25'){$name = "Зеленый Голем"; $d1 = "Зеленый Голем";}
else if($bot=='26'){$name = "Крылатый Демон"; $d1 = "Крылатый Демон";}
else if($bot=='27'){$name = "Скелет"; $d1 = "Скелет";}
else if($bot=='28'){$name = "Страж"; $d1 = "Страж";}
//////////////////////////////////////////
else if($bot=='29'){$name = "Проклятие Земель"; $d1 = "Проклятие Земель";}
else if($bot=='30'){$name = "Маул Счастливчик"; $d1 = "Маул Счастливчик";}
else if($bot=='31'){$name = "Пустынник Атаман"; $d1 = "Пустынник Атаман";}
else if($bot=='32'){$name = "Пустынник Атаман2"; $d1 = "Пустынник Атаман2";}
else if($bot=='33'){$name = "Пустынник Убийца"; $d1 = "Пустынник Убийца";}
else if($bot=='34'){$name = "Пустынник Маньяк"; $d1 = "Пустынник Маньяк";}
else if($bot=='35'){$name = "Пустынник Убийца2"; $d1 = "Пустынник Убийца2";}
else if($bot=='36'){$name = "Страж Крантон"; $d1 = "Страж Крантон";}

else if($bot=='32.33'){$name = "Пустынник Атаман2"; $name2 = "Пустынник Убийца"; $d1 = "Пустынник Атаман2"; $d2 = "Пустынник Убийца";}
else if($bot=='34.35'){$name = "Пустынник Маньяк"; $name2 = "Пустынник Убийца2"; $d1 = "Пустынник Маньяк"; $d2 = "Пустынник Убийца2";}

//////////////////////////////////////////
else if($bot=='1.1'){$name = "Паук"; $name2 = "Паук"; $d1 = "Паук(1)"; $d2 = "Паук(2)";}
else if($bot=='1.2'){$name = "Паук"; $name2 = "Зомби"; $d1 = "Паук"; $d2 = "Зомби";}
else if($bot=='1.3'){$name = "Паук"; $name2 = "Жук"; $d1 = "Паук"; $d2 = "Жук";}
else if($bot=='2.2'){$name = "Зомби"; $name2 = "Зомби"; $d1 = "Зомби(1)"; $d2 = "Зомби(2)";}
else if($bot=='2.3'){$name = "Зомби"; $name2 = "Жук"; $d1 = "Зомби"; $d2 = "Жук";}
else if($bot=='3.3'){$name = "Жук"; $name2 = "Жук"; $d1 = "Жук(1)"; $d2 = "Жук(2)";}

//////////////////2 этаж/////////////////////
else if($bot=='9.9'){$name = "Крыса"; $name2 = "Крыса"; $d1 = "Крыса(1)"; $d2 = "Крыса(2)";}
else if($bot=='10.10'){$name = "Безголовый"; $name2 = "Безголовый"; $d1 = "Безголовый(1)"; $d2 = "Безголовый(2)";}
else if($bot=='11.11'){$name = "Стальной"; $name2 = "Стальной"; $d1 = "Стальной(1)"; $d2 = "Стальной(2)";}
else if($bot=='12.12'){$name = "Кровавый"; $name2 = "Кровавый"; $d1 = "Кровавый(1)"; $d2 = "Кровавый(2)"; }
else if($bot=='13.13'){$name = "Мышь"; $name2 = "Мышь"; $d1 = "Мышь(1)"; $d2 = "Мышь(2)";}
else if($bot=='14.14'){$name = "Прораб"; $name2 = "Прораб"; $d1 = "Прораб(1)"; $d2 = "Прораб(2)";}
else if($bot=='15.15'){$name = "Слесарь"; $name2 = "Слесарь"; $d1 = "Слесарь(1)"; $d2 = "Слесарь(2)";}
else if($bot=='16.16'){$name = "Слизь"; $name2 = "Слизь"; $d1 = "Слизь(1)"; $d2 = "Слизь(2)";}
else if($bot=='17.17'){$name = "Старожил"; $name2 = "Старожил"; $d1 = "Старожил(2)"; $d2 = "Старожил(2)";}
else if($bot=='18.18'){$name = "Хозяин"; $name2 = "Хозяин"; $d1 = "Хозяин(1)"; $d2 = "Хозяин(2)";}
////////////////////////Подземелье 1000 проклятий////////////////////////////////////
else if($bot=='19.19'){$name = "Бродячий Труп(1)"; $name2 = "Бродячий Труп(2)"; $d1 = "Бродячий Труп(1)"; $d2 = "Бродячий Труп(2)";}
else if($bot=='20.20'){$name = "Изи"; $name2 = "Изи"; $d1 = "Изи(1)"; $d2 = "Изи(2)";}
else if($bot=='21.21'){$name = "Кошмар Глубин"; $name2 = "Кошмар Глубин"; $d1 = "Кошмар Глубин(1)"; $d2 = "Кошмар Глубин(2)";}
else if($bot=='22.22'){$name = "Проклятие Глубин"; $name2 = "Проклятие Глубин"; $d1 = "Проклятие Глубин(1)"; $d2 = "Проклятие Глубин(2)";}
else if($bot=='23.23'){$name = "Ужас Глубин"; $name2 = "Ужас Глубин"; $d1 = "Ужас Глубин(1)"; $d2 = "Ужас Глубин(2)";}

else if($bot=='24.24'){$name = "Бес"; $name2 = "Бес"; $d1 = "Бес(1)"; $d2 = "Бес(2)";}
else if($bot=='25.25'){$name = "Зеленый Голем"; $name2 = "Зеленый Голем"; $d1 = "Зеленый Голем(1)"; $d2 = "Зеленый Голем(2)";}
else if($bot=='26.26'){$name = "Крылатый Демон"; $name2 = "Крылатый Демон"; $d1 = "Крылатый Демон(1)"; $d2 = "Бродячий ТрупКрылатый Демон(2)";}
else if($bot=='27.27'){$name = "Скелет"; $name2 = "Скелет"; $d1 = "Скелет(1)"; $d2 = "Скелет(2)";}
else if($bot=='28.28'){$name = "Страж"; $name2 = "Страж"; $d1 = "Страж(1)"; $d2 = "Страж(2)";}
//////////////////////////////////////////
else if($bot=='1.1.1'){$name = "Паук"; $name2 = "Паук"; $name3 = "Паук"; $d1 = "Паук(1)"; $d2 = "Паук(2)"; $d3 = "Паук(3)";}
else if($bot=='1.1.2'){$name = "Паук"; $name2 = "Паук"; $name3 = "Зомби"; $d1 = "Паук(1)"; $d2 = "Паук(2)"; $d3 = "Зомби";}
else if($bot=='1.1.3'){$name = "Паук"; $name2 = "Паук"; $name3 = "Жук"; $d1 = "Паук(1)"; $d2 = "Паук(2)"; $d3 = "Жук";}
else if($bot=='1.2.2'){$name = "Паук"; $name2 = "Зомби"; $name3 = "Зомби"; $d1 = "Паук"; $d2 = "Зомби(1)"; $d3 = "Зомби(2)";}
else if($bot=='1.3.2'){$name = "Паук"; $name2 = "Жук"; $name3 = "Зомби"; $d1 = "Паук"; $d2 = "Жук"; $d3 = "Зомби";}
else if($bot=='1.3.3'){$name = "Паук"; $name2 = "Жук"; $name3 = "Жук"; $d1 = "Паук"; $d2 = "Жук(1)"; $d3 = "Жук(2)";}
else if($bot=='2.2.2'){$name = "Зомби"; $name2 = "Зомби"; $name3 = "Зомби"; $d1 = "Зомби(1)"; $d2 = "Зомби(2)"; $d3 = "Зомби(3)";}
else if($bot=='2.2.3'){$name = "Зомби"; $name2 = "Зомби"; $name3 = "Жук"; $d1 = "Зомби(1)"; $d2 = "Зомби(2)"; $d3 = "Жук";}
else if($bot=='2.3.3'){$name = "Зомби"; $name2 = "Жук"; $name3 = "Жук"; $d1 = "Зомби"; $d2 = "Жук(1)"; $d3 = "Жук(2)";}
else if($bot=='3.3.3'){$name = "Жук"; $name2 = "Жук"; $name3 = "Жук"; $d1 = "Жук(1)"; $d2 = "Жук(2)"; $d3 = "Жук(3)";}

else if($bot=='9.9.9'){$name = "Крыса"; $name2 = "Крыса"; $name3 = "Крыса"; $d1 = "Крыса(1)"; $d2 = "Крыса(2)"; $d3 = "Крыса(3)";}
else if($bot=='10.10.10'){$name = "Безголовый"; $name2 = "Безголовый"; $name3 = "Безголовый"; $d1 = "Безголовый(1)"; $d2 = "Безголовый(2)"; $d3 = "Безголовый(3)";}
else if($bot=='11.11.11'){$name = "Стальной"; $name2 = "Стальной"; $name3 = "Стальной"; $d1 = "Стальной(1)"; $d2 = "Стальной(2)"; $d3 = "Стальной(3)";}
else if($bot=='12.12.12'){$name = "Кровавый"; $name2 = "Кровавый"; $name3 = "Кровавый"; $d1 = "Кровавый(1)"; $d2 = "Кровавый(2)";  $d3 = "Кровавый(3)";}
else if($bot=='13.13.13'){$name = "Мышь"; $name2 = "Мышь"; $name3 = "Мышь"; $d1 = "Мышь(1)"; $d2 = "Мышь(2)"; $d3 = "Мышь(3)";}
else if($bot=='14.14.14'){$name = "Прораб"; $name2 = "Прораб"; $name3 = "Прораб"; $d1 = "Прораб(1)"; $d2 = "Прораб(2)"; $d3 = "Прораб(3)";}
else if($bot=='15.15.15'){$name = "Слесарь"; $name2 = "Слесарь"; $name3 = "Слесарь"; $d1 = "Слесарь(1)"; $d2 = "Слесарь(2)"; $d3 = "Слесарь(3)";}
else if($bot=='16.16.16'){$name = "Слизь"; $name2 = "Слизь"; $name3 = "Слизь"; $d1 = "Слизь(1)"; $d2 = "Слизь(2)"; $d3 = "Слизь(3)";}
else if($bot=='17.17.17'){$name = "Старожил"; $name2 = "Старожил"; $name3 = "Старожил"; $d1 = "Старожил(2)"; $d2 = "Старожил(2)"; $d3 = "Старожил(3)";}
else if($bot=='18.18.18'){$name = "Хозяин"; $name2 = "Хозяин"; $name3 = "Хозяин"; $d1 = "Хозяин(1)"; $d2 = "Хозяин(2)"; $d3 = "Хозяин(3)";}
////////////////////////Подземелье 1000 проклятий////////////////////////////////////
else if($bot=='19.19.19'){$name = "Бродячий Труп"; $name2 = "Бродячий Труп"; $name3 = "Бродячий Труп"; $d1 = "Бродячий Труп(1)"; $d2 = "Бродячий Труп(2)"; $d3 = "Бродячий Труп(3)";}
else if($bot=='20.20.20'){$name = "Изи"; $name2 = "Изи"; $name3 = "Изи"; $d1 = "Изи(1)"; $d2 = "Изи(2)"; $d3 = "Изи(3)";}
else if($bot=='21.21.21'){$name = "Кошмар Глубин"; $name2 = "Кошмар Глубин"; $name3 = "Кошмар Глубин"; $d1 = "Кошмар Глубин(1)"; $d2 = "Кошмар Глубин(2)"; $d3 = "Кошмар Глубин(3)";}
else if($bot=='22.22.22'){$name = "Проклятие Глубин"; $name2 = "Проклятие Глубин"; $name3 = "Проклятие Глубин"; $d1 = "Проклятие Глубин(1)"; $d2 = "Проклятие Глубин(2)"; $d3 = "Проклятие Глубин(3)";}
else if($bot=='23.23.23'){$name = "Ужас Глубин"; $name2 = "Ужас Глубин"; $name3 = "Ужас Глубин"; $d1 = "Ужас Глубин(1)"; $d2 = "Ужас Глубин(2)"; $d3 = "Ужас Глубин(3)";}

else if($bot=='24.24.24'){$name = "Бес"; $name2 = "Бес"; $name3 = "Бес"; $d1 = "Бес(1)"; $d2 = "Бес(2)"; $d3 = "Бес(3)";}
else if($bot=='25.25.25'){$name = "Зеленый Голем"; $name2 = "Зеленый Голем"; $name3 = "Зеленый Голем"; $d1 = "Зеленый Голем(1)"; $d2 = "Зеленый Голем(2)"; $d3 = "Зеленый Голем(3)";}
else if($bot=='26.26.26'){$name = "Крылатый Демон"; $name2 = "Крылатый Демон"; $name3 = "Крылатый Демон"; $d1 = "Крылатый Демон(1)"; $d2 = "Крылатый Демон(2)"; $d3 = "Крылатый Демон(3)";}
else if($bot=='27.27.27'){$name = "Скелет"; $name2 = "Скелет"; $name3 = "Скелет"; $d1 = "Скелет(1)"; $d2 = "Скелет(2)"; $d3 = "Скелет(3)";}
else if($bot=='28.28.28'){$name = "Страж"; $name2 = "Страж"; $name3 = "Страж"; $d1 = "Страж(1)"; $d2 = "Страж(2)"; $d3 = "Страж(3)";}
//////////////////////////////////////////Грибница///////////////////////////////////////////////
else if($bot=='37'){$name = "Яростная Мокрица"; $d1 = "Яростная Мокрица"; }
else if($bot=='38'){$name = "Кольчатый Страхочервь"; $d1 = "Кольчатый Страхочервь"; }
else if($bot=='39'){$name = "Пылающий Паразит"; $d1 = "Пылающий Паразит"; }
else if($bot=='40'){$name = "Скользкий Рогоносец"; $d1 = "Скользкий Рогоносец"; }
else if($bot=='41'){$name = "Мясистый Гусениц"; $d1 = "Мясистый Гусениц"; }




else if($bot=='37.38'){$name = "Яростная Мокрица"; $name2 = "Кольчатый Страхочервь"; $d1 = "Яростная Мокрица"; $d2 = "Кольчатый Страхочервь";}
else if($bot=='38.39'){$name = "Кольчатый Страхочервь"; $name2 = "Пылающий Паразит"; $d1 = "Кольчатый Страхочервь"; $d2 = "Пылающий Паразит";}
else if($bot=='39.40'){$name = "Пылающий Паразит"; $name2 = "Скользкий Рогоносец"; $d1 = "Пылающий Паразит"; $d2 = "Скользкий Рогоносец";}
else if($bot=='38.41'){$name = "Кольчатый Страхочервь"; $name2 = "Мясистый Гусениц"; $d1 = "Кольчатый Страхочервь"; $d2 = "Мясистый Гусениц";}
else if($bot=='37.40'){$name = "Яростная Мокрица"; $name2 = "Скользкий Рогоносец"; $d1 = "Яростная Мокрица"; $d2 = "Скользкий Рогоносец";}
else if($bot=='40.41'){$name = "Скользкий Рогоносец"; $name2 = "Мясистый Гусениц"; $d1 = "Скользкий Рогоносец"; $d2 = "Мясистый Гусениц";}


else if($bot=='37.38.39'){$name = "Яростная Мокрица"; $name2 = "Кольчатый Страхочервь"; $name3 = "Мясистый Гусениц"; $d1 = "Яростная Мокрица"; $d2 = "Кольчатый Страхочервь"; $d3 = "Мясистый Гусениц";}
else if($bot=='37.38.41'){$name = "Яростная Мокрица"; $name2 = "Кольчатый Страхочервь"; $name3 = "Мясистый Гусениц"; $d1 = "Яростная Мокрица"; $d2 = "Кольчатый Страхочервь"; $d3 = "Мясистый Гусениц";}
else if($bot=='37.38.40'){$name = "Яростная Мокрица"; $name2 = "Кольчатый Страхочервь"; $name3 = "Скользкий Рогоносец"; $d1 = "Яростная Мокрица"; $d2 = "Кольчатый Страхочервь"; $d3 = "Скользкий Рогоносец";}


        $mine_id=$db["id"];

        $ass = mysql_query("SELECT glav_id,glava FROM labirint WHERE user_id='".mysql_real_escape_string($mine_id)."'");
        $lab = mysql_fetch_array($ass);
        $glav_id = $lab["glav_id"];
		$glava = $lab["glava"];
mysql_query("UPDATE labirint SET boi='$nomer',di='0' WHERE user_id='$mine_id'");
$T1 = mysql_query("INSERT INTO canal_bot (glava,boi,bot,nomer) VALUES('$glava','$nomer','$bot','$nomer')");



//////////////////////////////////////////////////////
$sex = mysql_query("SELECT maxhp,id FROM users WHERE login='$name'");
$dded=mysql_fetch_array($sex);
mysql_query("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('".mysql_real_escape_string($d1)."','".mysql_real_escape_string($dded["id"])."','','".mysql_real_escape_string($dded["maxhp"])."');");
$bot = mysql_insert_id();
$teams = array();

$teams[$user['id']][$bot] = array(0,0,time());
$teams[$bot][$user['id']] = array(0,0,time());

mysql_query("INSERT INTO `battle`(`id`,`coment`,`teams`,`timeout`,`type`,`status`,`t1`,`t2`,`to1`,`to2`)VALUES(NULL,'','".mysql_real_escape_string(serialize($teams))."','3','1','0','".mysql_real_escape_string($user['id'])."','".mysql_real_escape_string($bot)."','".time()."','".time()."')");
$id = mysql_insert_id();
					// апдейтим бота
mysql_query("UPDATE `bots` SET `battle` = '".mysql_real_escape_string($id)."' WHERE `id` = '".mysql_real_escape_string($bot)."' LIMIT 1;");
					// создаем лог
$rr = "<b>".nick3($user['id'])."</b> и <b>".nick3($bot)."</b>";
addlog($id,"Часы показывали <span class=date>".date("Y.m.d H.i")."</span>, когда ".$rr." бросили вызов друг другу. <BR>");
mysql_query("UPDATE users SET `battle` ={$id},`zayavka`=0 WHERE `id`= {$user['id']};");

if($name2!=''){
$sex2 = mysql_query("SELECT maxhp,id FROM users WHERE login='".mysql_real_escape_string($name2)."'");
$dded2=mysql_fetch_array($sex2);
mysql_query("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('".mysql_real_escape_string($d2)."','".mysql_real_escape_string($dded2["id"])."','".mysql_real_escape_string($id)."','".mysql_real_escape_string($dded2["maxhp"])."');");
$bot2 = mysql_insert_id();

$bd2 = mysql_fetch_array(mysql_query ("SELECT * FROM `battle` WHERE `id` = '".mysql_real_escape_string($id)."' LIMIT 1;"));
$battle2 = unserialize($bd2['teams']);
$battle2[$bot2] = $battle2[$bot];
foreach($battle2[$bot2] as $k2 => $v2) {
$battle2[$k2][$bot2] = array(0,0,time());
}
$t12 = explode(";",$bd2['t1']);		
// проставляем кто-где
if (in_array ($user['id'],$t12)) {$ttt2 = 2;} else {	$ttt2 = 1;}					
					
$sdds2 = mysql_query("UPDATE `battle` SET `teams` = '".mysql_real_escape_string(serialize($battle2))."', `t".mysql_real_escape_string($ttt2)."`=CONCAT(`t".mysql_real_escape_string($ttt2)."`,';".mysql_real_escape_string($bot2)."')  WHERE `id` = '".mysql_real_escape_string($id)."'");		
mysql_query("UPDATE `battle` SET `to1` = '".time()."', `to2` = '".time()."' WHERE `id` = '".mysql_real_escape_string($id)."' LIMIT 1;");
}

if($name3!=''){
$sex3 = mysql_query("SELECT maxhp,id FROM users WHERE login='".mysql_real_escape_string($name3)."'");
$dded3=mysql_fetch_array($sex3);
mysql_query("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('".mysql_real_escape_string($d3)."','".mysql_real_escape_string($dded3["id"])."','".mysql_real_escape_string($id)."','".mysql_real_escape_string($dded3["maxhp"])."');");
$bot3 = mysql_insert_id();

$bd3 = mysql_fetch_array(mysql_query ("SELECT * FROM `battle` WHERE `id` = '".mysql_real_escape_string($id)."' LIMIT 1;"));
$battle3 = unserialize($bd3['teams']);
$battle3[$bot3] = $battle3[$bot];
foreach($battle3[$bot3] as $k3 => $v3) {
$battle3[$k3][$bot3] = array(0,0,time());
}
$t13 = explode(";",$bd3['t1']);		
// проставляем кто-где
if (in_array ($user['id'],$t13)) {$ttt3 = 2;} else {	$ttt3 = 1;}					
					
$sdds3 = mysql_query("UPDATE `battle` SET `teams` = '".mysql_real_escape_string(serialize($battle3))."', `t".mysql_real_escape_string($ttt3)."`=CONCAT(`t".mysql_real_escape_string($ttt3)."`,';".mysql_real_escape_string($bot3)."')  WHERE `id` = '".mysql_real_escape_string($id)."'");
		
mysql_query("UPDATE `battle` SET `to1` = '".time()."', `to2` = '".time()."' WHERE `id` = '".mysql_real_escape_string($id)."' LIMIT 1;");
}

//////////////////////////////////////////////////////
die("<script>location.href='fbattle.php';</script>");
//////////////////////////////////////////////////////
}

?>
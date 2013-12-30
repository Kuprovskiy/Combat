<?php
    session_start();
    if ($_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
    include "functions.php";
    if ($user['room'] != 28) header("Location: main.php");
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=#e0e0e0>
    <TABLE border=0 width=100% cellspacing="0" cellpadding="0">
    <td align=right>
    <FORM action="city.php" method=GET>
        <INPUT TYPE="button" value="Подсказка" style="background-color:#A9AFC0" onclick="window.open('help/#', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">
		<INPUT type='button' value='Обновить' style='width: 75px' onclick='location="/klanedit.php"'>
        <INPUT TYPE="submit" value="Вернуться" name="strah">
    </table>
    </form>
<? 
  if ((aligntype($user["align"])==1 || aligntype($user["align"])==2) && 0) {
    $v=mqfa1("select id from votes where user='$user[id]'");
    if (@$_POST["todo"]=="vote" && !$v) {
      $vote=mqfa("select id, align from users where login='$_POST[login]'");
      if ($vote && samealign($vote["align"], $user["align"])) {
        mq("insert into votes set user='$user[id]', vote='$vote[id]', align='".aligntype($user["align"])."', pts='$user[exp]'");
        $v=1;
      } elseif (!$vote) echo "<b><font color=\"red\">Персонаж $_POST[login] не найден.</font></b>";
      elseif (!samealign($vote["align"], $user["align"])) echo "<b><font color=\"red\">У персонажа $_POST[login] не ваша склонность.</font></b>";
    }
    if ($v) {
      if ($_POST["todo"]=="vote") echo "<H3>Ваш голос за воеводу ".(aligntype($user["align"])==1?"Света":"Тьмы")." учтён.</H3><br><br>";
      else echo "<H3>Вы уже отдали свой голос. Следующие выборы начнутся в следующий понедельник.</H3><br><br>";
    } else {
      echo "<H3>Выборы воеводы ".(aligntype($user["align"])==1?"Света":"Тьмы")."</H3><br><br>
      Воевода ".(aligntype($user["align"])==1?"Света":"Тьмы")." руководит войсками ".(aligntype($user["align"])==1?"Света":"Тьмы")." в битвах Света и Тьмы. 
      Только он может исключит любого из своего войска. Вместе с воеводой битвой руководят два сотника, кторые могут исключить из боя кого угодно кроме воеводы и другого сотника.
      Укажите, кого вы считаете достойным звания воеводы больше других.<br><br>
      <form action=\"klanedit.php\" method=\"post\">
        <input type=\"hidden\" name=\"todo\" value=\"vote\">
        <input type=\"text\" name=\"login\"> <input type=\"submit\" value=\"Отдать голос\">
      </form>";
    }
  }
if ($user['klan'] && $user['align']!=2.5 && $user['align']!=2.9 && $user['align']!=2.51) { ?>
<TABLE width="100%" border="0">
<TR valign="top">
<TD width="50%">

Вы уже состоите в клане <B><?=$user['klan']?></B> и не можете подать заявку на регистрацию нового клана.<BR><BR>

А хотите принять участие в демократических выборах нового главы клана? ;)<BR>
Вы можете выставить свою кандидатуру на пост главы клана (услуга платная: 100 кр.). Если в течение недели вы наберете более 50% голосов или в конце недели наберете больше голосов "за", то станете новым главой клана. Если нет, то голосование по вашей кандидатуре будет закрыто.<BR>
<INPUT TYPE=submit name="add_new_vote" value="Хочу стать главой клана" onclick="return confirm('Выставить вашу кандидатуру на пост главы клана и начать голосование?\nУчтите, вы должны заплатить 100кр. и глава может исключить вас из клана, узная, что вы под него копаете ;)')"><BR>
Голосования проводятся только закрытые, чтобы избежать возможных репрессий со стороны действующего главы клана.<BR>



</TD>
<TD>
<FIELDSET><LEGEND><H4>Дипломатия</H4></LEGEND>
<table cellspacing=0 cellpadding=2 border=0 width="100%">
<TR>
<TD>В данный момент у вашего клана нет дипломатических отношений.</TD>
</TR>
</table>
</FIELDSET>
</TD>
</TR>
</TABLE>
<?
}else{
?>

        <H3>Заявка на регистрацию клана</H3>
<br>
    <?
        if($user['align'] == '2.9'  || $user['align'] == '2.5' || $user['align'] == '2.51') {
            $data = mysql_query("SELECT * FROM `reg_klan`;");
            echo "<table>";
            while($clan=mysql_fetch_array($data)) {
                echo "<form action=\"\" method=\"POST\">
                <TR><TD>",$clan['date'],"</TD><TD>",$clan['name'],"</TD><TD>",$clan['abr'],"</TD>
                <TD>",nick2($clan['owner']),"</TD><TD><img src='i/klan/",$clan['sznak'],".gif'></TD>
                <TD><img src='i/klan/",$clan['bznak'],".gif'></TD><TD><img src='i/align_",$clan['align'],".gif'></TD>
                <TD><a href='",$clan['http'],"'>",$clan['http'],"</a></TD><TD>",$clan['descr'],"</TD>
                <input name=\"name\" type=\"hidden\" value=\"".$clan['name']."\">
                <input name=\"abr\" type=\"hidden\" value=\"".$clan['abr']."\">
                <input name=\"align\" type=\"hidden\" value=\"".$clan['align']."\">
                <input name=\"owner\" type=\"hidden\" value=\"".$clan['owner']."\">
                <input name=\"deviz\" type=\"hidden\" value=\"".$clan['deviz']."\">
                <input name=\"http\" type=\"hidden\" value=\"".$clan['http']."\">
                <input name=\"clandem\" type=\"hidden\" value=\"".$clan['clandem']."\">
                <input name=\"sex_control\" type=\"hidden\" value=\"".$clan['sex_control']."\">
                <input name=\"bznak\" type=\"hidden\" value=\"".$clan['bznak']."\">
                <TD><input name=\"ok\" type=\"submit\" value=\"Одобрить\"> <input name=\"del\" type=\"submit\" value=\"Удалить\"></TD></TR>
                </form>";
            }
           if($_POST['ok']){
$vozm=array();
$i=0;
while ($i<=13) {
  $vozm[$_POST['owner']][$i]=1;
  $i++;
}

mysql_query("INSERT `clans` (`short`,`name`,`glava`,`align`,`deviz`,`homepage`,`clandem`,`sex_control`,`clanbig`, vozm)
values ('".$_POST['abr']."','".$_POST['name']."','".$_POST['owner']."','".$_POST['align']."','".$_POST['deviz']."','".$_POST['http']."','".$_POST['clandem']."','".$_POST['sex_control']."','".$_POST['bznak']."', '".serialize($vozm)."') ;");

mysql_query("UPDATE `users` set `align`='".$_POST['align']."',klan='".$_POST['abr']."' where id='".$_POST['owner']."'");
mysql_query("UPDATE `userdata` set `align`='".$_POST['align']."' where id='".$_POST['owner']."'");
mysql_query("UPDATE `allusers` set `align`='".$_POST['align']."',klan='".$_POST['abr']."' where id='".$_POST['owner']."'");
mysql_query("UPDATE `alluserdata` set `align`='".$_POST['align']."' where id='".$_POST['owner']."'");
mysql_query("DELETE FROM reg_klan WHERE owner='".$_POST['owner']."'");


$rec=mqfa("select id, glava, vozm from clans where name='$_POST[name]'");
$vozm=unserialize($rec["vozm"]);
$i=0;
while ($i<=13) {
  $vozm[$rec["glava"]][$i]=1;
  $i++;
}
mq("update clans set vozm='".serialize($vozm)."' where id='$rec[id]'");

print "<script>location.href='main.php'</script>";
            }
            if($_POST['del']){
            mysql_query("DELETE FROM reg_klan WHERE owner='".$_POST['owner']."'");
            print "<script>location.href='main.php'</script>";
            }
            echo "</table>";
        }
        else
        {
            $hasclan=mqfa1("select id from reg_klan where owner='$user[id]'");
            if($_SERVER["REQUEST_METHOD"]=="POST" && !$hasclan) {
                $mon = array(0=>1000,7=>5000,"0.98"=>5000,"0.99"=>5000);
                if($mon[$_POST['klanalign']] >= $user['money']) {
                    $error .= 'Не хватает денег на регистрацию клана. <BR>';
                }

                if (!$_POST['klanname']) $error .= 'Введите название клана. <BR>';
                if (!$_POST['klanabbr']) $error .= 'Введите аббревиатуру клана. <BR>';
                if (!$_POST['deviz']) $error .= 'Введите девиз клана. <BR>';

                if(!preg_match("/.*gif\$/i", $_FILES['small']['name'])) {
                    $error .= 'Маленький значёк не gif файл. <BR>';
                }
                if(!preg_match("/.*gif\$/i", $_FILES['big']['name'])) {
                    $error .= 'Большой значёк не gif файл. <BR>';
                }

                $imageinfo1 = @getimagesize($_FILES['small']['tmp_name']);
                $imageinfo2 = @getimagesize($_FILES['big']['tmp_name']);

                $eff = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$user['id']."' AND `type` = 20;"));
                if (!$eff) {
                    $error .= 'У Вас нет проверки. <BR>';
                }

                if($imageinfo1['mime'] != "image/gif") {
                    $error .= 'Маленький значёк не gif файл. <BR>';
                }
                if($imageinfo2['mime'] != "image/gif") {
                    $error .= 'Большой значёк не gif файл. <BR>';
                }
                if($_FILES['small']['size'] > 1024*4) {
                    $error .= 'Файл маленького значка слишком большой. <BR>';
                }
                if($_FILES['big']['size'] > 1024*10) {
                    $error .= 'Файл большого значка слишком большой. <BR>';
                }
                if(!$error) {
                    mysql_query("INSERT `reg_klan` (`name`,`owner`,`abr`,`http`,`sznak`,`bznak`,`align`,`clandem`,`sex_control`,`deviz`)
                    values ('".$_POST['klanname']."','".$user['id']."','".$_POST['klanabbr']."','".$_POST['http']."','".$_POST['klanabbr']."','".$_POST['klanabbr']."_big','".$_POST['klanalign']."','".$_POST['clandem']."','".$_POST['sex_control']."','".$_POST['deviz']."') ;");
                    move_uploaded_file($_FILES['small']['tmp_name'], './i/klan/'.$_POST['klanabbr'].".gif");
                    move_uploaded_file($_FILES['big']['tmp_name'], './i/klan/'.$_POST['klanabbr']."_big.gif");
                    mysql_query("UPDATE `users` set money=money-".$mon[$_POST['klanalign']]." where id='".$user['id']."'");
                    $hasclan=1;
                }
                else
                {
                    echo "<font color=red><B>",$error,"</B></font>";
                }
            }
            if ($hasclan) {
              echo "<font color=red><B>Заявка на регистрацию клана подана. Вам прийдет извещение о результате регистрации клана.</B></font><br><br>";
            } else {

    ?>
<form method="post" ENCTYPE="multipart/form-data">
<p>Итак, Вы решили зарегистрировать новый клан БК.<br>
Но прежде чем приступить к регистрации нового клана БК, ознакомьтесь, пожалуйста, со следующими рекомендациями:
<p>Перед подачей заявки на регистрацию клана Вам необходимо купить в магазине свиток <IMG SRC=<?=IMGBASE?>/i/magic/check.gif WIDTH=40 HEIGHT=25>"Пропуск в клан",<BR>
использовать на себя и приняться оформлять заявку. Важно: название клана и сокращенное название не должны отличаться ни на символ,<BR>
написаны могут быть только на латинице и без пробелов.Все поля при регистрации клана обязательны к заполнению, без исключения.<BR>
Каждый клан БК является уникальным сообществом игроков БК, поэтому недопустимо связывать его прямо или косвенно с<BR>
ныне существующими или уже распущенными кланами БК (плагиат), как в символике или в названии клана, так и в тексте<BR>
девиза клана БК.Большой (герб) и маленький значок должны быть выполнены в едином стиле.<BR></p>
<p><b>Требования к значкам:</b></p>
<ul>
<li>Большой значок (герб) - размер (ВxШ в пикселях) 100x99, графический тип - GIF, форма - КРУГ, фон за кругом прозрачный;</li>
<li>Маленький значок - размер (ВxШ в пикселях) 24x15, графический тип - GIF, фон прозрачный;</li>
</ul>
<p><b>Недопустимыми в названии клана, его девизе и его значках являются:</b></p>
<ul>
<li>Служебные термины, используемые Администрацией для создания атмосферы мира, такие как: гвардия, ангелы, паладины, и так далее;</li>
<li>Так как игровой мир БК фэнтезийный,  то название клана, его девиз и значки должны соответствовать игровому миру БК; </li>
<li>Игровой мир БК виртуальный, а потому не приветствуется использование государственной (гербы, флаги и т.п.), и не государственной (торговые марки, знаки, названия, и т.п.) символики, названия и произведения разного вида (стихи, высказывания, цитаты, литературные произведения и т.п.) из реального мира;</li>
<li>Наличие  грамматических и орфографических ошибок крайне нежелательно;</li>
<li>Следите за логикой и не создавайте противоречий в девизе, названии и символике своего клана.</li>
<li>Будьте вежливыми и терпимыми по отношению к другим участникам проекта БК, и не используйте в названии, девизе и символике своего клана то, что может быть истолковано, как оскорбление по отношению к другим пользователям.</li>
</ul>
<b>Стоимость регистрации кланов:</b><BR>
<IMG SRC="/i/align_0.gif" WIDTH="12" HEIGHT="15" BORDER=0 ALT=""> серый - 1000 кр.<BR>
<IMG SRC="/i/align_7.gif" WIDTH="12" HEIGHT="15" BORDER=0 ALT=""> нейтральный - 5000 кр.<BR>
<IMG SRC="/i/align_0.99.gif" WIDTH="12" HEIGHT="15" BORDER=0 ALT=""> светлый - 5000 кр.<BR>
<IMG SRC="/i/align_0.98.gif" WIDTH="12" HEIGHT="15" BORDER=0 ALT=""> темный - 5000 кр.<BR>
<BR>
Заявку на регистрацию подает будущий глава клана, у которого должна быть при себе необходимая сумма.<BR>
<BR>
<FIELDSET><LEGEND><H4>Заявка</H4></LEGEND>
Название клана <input type="text" name="klanname" size=60 value="<?=$_POST['klanname']?>"><BR>
Тип управления кланом: <input type="radio" name="clandem" value="1" <? if (@$_POST["clandem"]==1) echo "checked"; ?>>&nbsp;Анархия&nbsp;&nbsp;<input type="radio" name="clandem" value="2" <? if (@$_POST["clandem"]==2) echo "checked"; ?>>&nbsp;Монархия&nbsp;&nbsp;<input type="radio" name="clandem" value="3" <? if (@$_POST["clandem"]==3) echo "checked"; ?>>&nbsp;Диктатура&nbsp;&nbsp;<input type="radio" name="clandem" value="4" <? if (@$_POST["clandem"]==4) echo "checked"; ?>>&nbsp;Демократия&nbsp;&nbsp;<br>
Ограничение управлением:
<input type="radio" name="sex_control" value="1" <? if (@$_POST["sex_control"]==1) echo "checked"; ?>>&nbsp;Матриархат&nbsp;&nbsp;
<input type="radio" name="sex_control" value="2" <? if (@$_POST["sex_control"]==2) echo "checked"; ?>>&nbsp;Патриархат&nbsp;&nbsp;
<input type="radio" name="sex_control" value="0" <? if (@$_POST["sex_control"]==0) echo "checked"; ?>>&nbsp;Не ограничивать по полу&nbsp;&nbsp;&nbsp;
<!--<input type=checkbox name=geront>&nbsp;Геронтократия--><br>
Английская аббревиатура (только английские буквы, одно слово) <input type="text" name="klanabbr" value="<?=$_POST['klanabbr']?>"><BR>
Ссылка на официальный сайт клана <input type="text" size=30 name="http" value="<?=$_POST['http']?>"><BR>
Маленький значок <input type="file" name="small"><BR>
Большой значок <input type="file" name="big"><BR>
Склонность клана <select name="klanalign"><option value="0">серый<option value="7" <?=@$_POST["klanalign"]==7?"selected":"";?>>нейтральный<option value="0.99" <?=@$_POST["klanalign"]=="0.99"?"selected":"";?>>светлый<option value="0.98" <?=@$_POST["klanalign"]=="0.98"?"selected":"";?>>темный</select><BR>
Девиз: <INPUT TYPE="text" NAME="deviz" value="<?=@$_POST["deviz"]; ?>" size=40 maxlength=255><br>
<!--Описание для библиотеки<BR>
<textarea cols=80 rows=10 name="klandescr">
<?=$_POST['klandescr']?>
</textarea>-->
<BR>
<input type="submit" value="Подать заявку">
</fieldset>
</form>
<BR>
  <b>Примечания:</b><UL>
<LI>При подаче заявки с вас снимается сумма необходимая для регистрации клана.
<LI>В случае отказа в регистрации (по любой причине) возвращается 90% от стоимости клана.
<LI>Администрация в праве отказать в регистрации без объяснения причины.
</UL>
    <?}}}?>

<br><div align=left>
    <?php include("mail_ru.php"); ?>
<div>
</BODY>
</HTML>

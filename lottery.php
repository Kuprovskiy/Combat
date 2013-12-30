<?php
 	
session_start();
if (isset($_GET['cronstartlotery'])) { // только cron
    $_SESSION['uid'] = 7;
}
if ($_SESSION['uid'] == null) {
    header("Location: index.php");
}
include './connect.php';
$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '".mysql_real_escape_string($_SESSION['uid'])."' LIMIT 1;"));
include './functions.php';
if ($user['room'] != 7777 && $user['id'] != 7) { 
    header("Location: main.php"); 
    die(); 
}
if ($user['battle'] != 0) { 
    header('location: fbattle.php'); 
    die(); 
}

?>

<html>
    
<head>
    <link rel=stylesheet type="text/css" href="/i/main.css">
    <meta content="text/html; charset=windows-1251" http-equiv=Content-type>
    <meta Http-Equiv=Cache-Control Content=no-cache>
    <meta http-equiv=PRAGMA content=NO-CACHE>
    <meta Http-Equiv=Expires Content=0>
    <style type="text/css">
        p, #table *, input {
            font-size: 9pt;
        }
        #table {
            border-collapse:collapse;
        }
        #table, #table td, #table th {
            border:1px solid black;
        }
        #table td, table th {
            padding: 0.3em;
        }
    </style>
    <?php if ($user['id'] != 7) { ?>
    <script LANGUAGE='JavaScript'>
    document.ondragstart = test;
    document.onselectstart = test;
    document.oncontextmenu = test;
    function test() {
     return false
    }
    </SCRIPT>
    <?php } ?>
</head>

<body bgcolor=e2e0e0 style="background-image: url(i/misc/lottery.png);background-repeat:no-repeat;background-position:top right"> 
<div id=hint3 class=ahint></div>
<div id=hint4 class=ahint></div>
<table border=0 width=100% cellspacing="0" cellpadding="0">
    <form action="city.php" method=GET>
        <tr>
            <td><h3>Лотерея  5 из 30</h3></td>
            <td align=right>
                <!--input style="font-size:12px;" type="button" value="Подсказка" style="background-color:#A9AFC0" onclick="window.open('help/lottery.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')"-->
                <input style="font-size:12px;" type='button' onClick="location='lottery.php'" value="Обновить">
                <input style="font-size:12px;" type='button' onClick="location='city.php?cp=1'" value="Вернуться">
            </td>
        </tr>
    </FORM>
</table>

<div style="width: 64%">

<?php

class Lottery {
	function get_this_user_id() {
		// определеить id пользователя
		global $user;
		return $user['id'];
	}

	function buy($txt = '', $lottery_id) {
		// списать сумму билета
		global $user;
		if ($user['money'] < 1) {
			$this->mess = 'Не хватает денег<BR>';
		} else {
			mysql_query("update users set money = money - 1 where id = '".mysql_real_escape_string($user['id'])."';");
			mysql_query("insert into inventory (`owner`,`name`,`maxdur`,`img`,`letter`,`type`) values ('".mysql_real_escape_string($user['id'])."','Лотерейный билет Nr. $lottery_id','1','loto.gif','".mysql_real_escape_string($txt)."','210');");
		}
	}

	function pay_for_5($summ) {
		// оплата если 5 из 5 угадано
		global $user;
        mysql_query("update users set money = money + '".mysql_real_escape_string($summ)."' where id = '".mysql_real_escape_string($user['id'])."';");
	}

	function pay_for_4($summ) {
		// оплата если 4 из 5 угадано
		global $user;
        mysql_query("update users set money = money + '".mysql_real_escape_string($summ)."' where id = '".mysql_real_escape_string($user['id'])."';");
	}

	function pay_for_3($summ) {
		// оплата если 3 из 5 угадано
		global $user;
		mysql_query("update users set money = money + '".mysql_real_escape_string($summ)."' where id = '".mysql_real_escape_string($user['id'])."';");
	}

	function pay_for_klan($summ) {
		// 10% клану
		global $user;
		//mysql_query("update users set money = money + '".mysql_real_escape_string($summ)."' where id = 7014;");
	}

	function buy_ticket($selected_str) {
		$selected_str = substr($selected_str,0,strlen($selected_str)-1);
		$selected_array = explode(',',$selected_str);
		sort($selected_array);

		$id_user = $this->get_this_user_id();

		if (sizeof($selected_array) > 5){
			$sql_ins_cheat = "insert into lottery_cheaters(`id_user`,`values`,`date`) values('".mysql_real_escape_string($id_user)."','".mysql_real_escape_string($selected_str)."','".date('Y-m-d H:i:s')."')";
			mysql_query($sql_ins_cheat);
		}

		for($i=0;$i<5;$i++){
			$values .= $selected_array[$i].',';
		}

        $sql = "select id from lottery where end='0'";
		$res = mysql_query($sql);
		while($result_lottery = mysql_fetch_assoc($res)){
			$id_lottery = $result_lottery['id'];
		}

		$date = date('Y-m-d H:i:s');



		$sql = "insert into lottery_log(`id_user`,`values`,`date`,`id_lottery`) values('".mysql_real_escape_string($id_user)."','".mysql_real_escape_string($values)."','".mysql_real_escape_string($date)."','".mysql_real_escape_string($id_lottery)."')";
		$res = mysql_query($sql);
        
		$this->buy("Тираж № ".$id_lottery."<BR>Выбраные номера: ".$values, mysql_insert_id());
        if($this->mess != null) {
        	return "<font color=red><B>".$this->mess."</font></b>";
        }
        echo "<font color=red><B>Билет куплен.<BR></font></b>";

		$jackpot = 0;
		$sql = "select * from `lottery` where end=0 limit 1";
		$res = mysql_query($sql);
		while($result = mysql_fetch_assoc($res)){
			$id = $result['id'];
			$jackpot = $result['jackpot'];
			$fond = $result['fond'];
		}

		$fond += 1;

		$sql = "update lottery set fond='".mysql_real_escape_string($fond)."' where id='".mysql_real_escape_string($id)."' ";
		mysql_query($sql);
	}

	function get_result() {
		$array = range(1,30);
		shuffle($array);

		for($i=0;$i<5;$i++){
			$result[] = $array[$i];
		}

		return $result;
	}

	function get_count($win_combination, $user_combination) {
		$user_array = explode(',',$user_combination);

		$count = 0;

		for($i=0;$i<5;$i++){
			if (strpos(",".$win_combination,",".$user_array[$i].",") !== FALSE){
				$count ++; //echo substr($win_combination,$z,1)." ";
			}
		}

		return $count;
	}

	function get_win_combination() {
		$win_combination = $this->get_result();

		for($i=0;$i<5;$i++){
			$win_combination_str .= $win_combination[$i].',';
		}


		$sql = "select id,jackpot,fond from lottery where end='0'";
		$res = mysql_query($sql);
		while($result = mysql_fetch_assoc($res)){
			$id_lottery = $result['id'];
			$jackpot = $result['jackpot'];
			$fond = $result['fond'];
		}
        
		$sql = "insert into lottery_win_combination(`values`,`date`,`id_lottery`) values('".mysql_real_escape_string($win_combination_str)."','".date('Y-m-d H:i:s')."','".mysql_real_escape_string($id_lottery)."') ";
		mysql_query($sql);

		$people_5 = 0;
		$people_4 = 0;
		$people_3 = 0;

		$sql = "select * from lottery_log where id_lottery='".mysql_real_escape_string($id_lottery)."' ";
		$res = mysql_query($sql);
		while($result = mysql_fetch_assoc($res)){
			$count = $this->get_count($win_combination_str,$result['values']);

			if ($count == 5){
				$people_5 ++;
			}
			if ($count == 4){
				$people_4 ++;
			}
			if ($count == 3){
				$people_3 ++;
			}
		}

		//$klan_pay = $fond*0.05;
		//$this->pay_for_klan($klan_pay);
		//$fond = $fond - $klan_pay;

		if ($people_5 > 0 ){
			$summ_5 = ($jackpot+($fond*0.3))/$people_5;
			$jackpot = 0;
		}
		else{
			$summ_5 = ($fond*0.3);
			$jackpot += $fond*0.3;
		}
		if ($people_4 > 0){
			$summ_4 = ($fond*0.3)/$people_4;
		}
		else{
			$summ_4 = ($fond*0.3);
			$jackpot += $fond*0.3;
		}
		if ($people_3 > 0){
			$summ_3 = ($fond*0.4)/$people_3;
		} else{
			$summ_3 = $fond*0.4;
			$jackpot += $fond*0.4;
		}


		$sql_upd = "update lottery set end='1' , fond='".mysql_real_escape_string($fond)."' , summ_5='".mysql_real_escape_string($summ_5)."' , summ_4='".mysql_real_escape_string($summ_4)."' , summ_3='".mysql_real_escape_string($summ_3)."' , count_5='".mysql_real_escape_string($people_5)."' , count_4='".mysql_real_escape_string($people_4)."' , count_3='".mysql_real_escape_string($people_3)."' where id='".mysql_real_escape_string($id_lottery)."'";
		mysql_query($sql_upd);
        $nDate = mktime(20,0,0,date('m',strtotime("+1 day")),date('d',strtotime("+1 day")),date('Y',strtotime("+1 day")));
		$sql_ins = "insert into lottery(`date`,`jackpot`,`fond`,`end`,`summ_5`,`summ_4`,`summ_3`,`count_5`,`count_4`,`count_3`) values('".date('Y-m-d H:i:s',$nDate)."','".mysql_real_escape_string($jackpot)."','0','0','0','0','0','0','0','0')";
        //$sql_ins = "insert into lottery(`date`,`jackpot`,`fond`,`end`,`summ_5`,`summ_4`,`summ_3`,`count_5`,`count_4`,`count_3`) values('".mktime(21,0,0,date('m',strtotime("+1 day")),date('d',strtotime("+1 day")),date('Y',strtotime("+1 day")))."','".mysql_real_escape_string($jackpot)."','0','0','0','0','0','0','0','0')";
		mysql_query($sql_ins);
	}

	function check($id_lottery) {
		$id_user = $this->get_this_user_id();

		//$sql_comb = "select values from lottery_win_combination where id_lottery='".$id_lottery."'";

		if ($id_lottery < 1)  {
			$sql_comb = "select * from lottery where end=1 order by id DESC LIMIT 1;";
			$res_comb = mysql_fetch_array(mysql_query($sql_comb));
			$id_lottery = $res_comb['id'];
		}

        $sql_comb = "select * from lottery_win_combination where id_lottery='".mysql_real_escape_string($id_lottery)."'";

		$res_comb = mysql_query($sql_comb);


		while($result_comb = mysql_fetch_assoc($res_comb)){
			$win_combination_str = $result_comb['values'];
		}

		$sql_summ = "select * from lottery where id='".mysql_real_escape_string($id_lottery)."'";
		$res_summ = mysql_query($sql_summ);
		while($result_summ = mysql_fetch_assoc($res_summ)){
			$summ_5 = $result_summ['summ_5'];
			$summ_4 = $result_summ['summ_4'];
			$summ_3 = $result_summ['summ_3'];
			$jackpot = $result_summ['jackpot'];
		}

		$sql = "select * from lottery_log where id_lottery='".mysql_real_escape_string($id_lottery)."' and id_user='".mysql_real_escape_string($id_user)."' AND send='0' ";
		$res = mysql_query($sql);
		while($result = mysql_fetch_assoc($res)){
			$count = $this->get_count($win_combination_str,$result['values']);

			if ($count == 5){
				$this->pay_for_5($summ_5);
				echo "Билет <B>№ ".$result['id']."</B> выиграл <b>".($summ_5)." кр.</b> Выбраные номера: ".$result['values']."<BR>";
				$zz = 1;
			}
			if ($count == 4){
				$this->pay_for_4($summ_4);
				echo "Билет <B>№ ".$result['id']."</B> выиграл <b>".$summ_4." кр.</b> Выбраные номера: ".$result['values']."<BR>";
				$zz = 1;
			}
			if ($count == 3){
				$this->pay_for_3($summ_3);
				echo "Билет <B>№ ".$result['id']."</B> выиграл <b>".$summ_3." кр.</b> Выбраные номера: ".$result['values']."<BR>";
				$zz = 1;
			}

			$sql_upd = "update lottery_log set send='1' where id='".mysql_real_escape_string($result['id'])."'";
			mysql_query($sql_upd);
		}
		if (!$zz) {
			echo "<p style=\"color: red;\"><b>У Вас нет выигрышных билетов</b></p>";
		}
	}

	function view_results($id_lottery = 0){
		$str = '';
        if ($id_lottery > 0) {
			$sql = "select * from lottery where id='".$id_lottery."' and end=1;";
		}
		else {
			$sql = "select * from lottery where end=1 order by id DESC LIMIT 1;";
		}
        $res = mysql_query($sql);

		while ($result = mysql_fetch_assoc($res)){
			$id_lottery = $result['id'];
			$date = $result['date'];
			$jackpot = $result['jackpot'];
			$fond = $result['fond'];
			$summ_5 = $result['summ_5'];
			$summ_4 = $result['summ_4'];
			$summ_3 = $result['summ_3'];
			$count_5 = $result['count_5'];
			$count_4 = $result['count_4'];
			$count_3 = $result['count_3'];
		}

		$summ = $summ_5 + $summ_4 + $summ_3;
		$count = $count_5 + $count_4 + $count_3;

		$sql_combination = "select * from lottery_win_combination where id_lottery='".mysql_real_escape_string($id_lottery)."'";
		$res_combination = mysql_query($sql_combination);
		while($result_combination = mysql_fetch_assoc($res_combination)){
			$combination = $result_combination['values'];
		}

		$sql = "select * from lottery_log where id_lottery='".mysql_real_escape_string($id_lottery)."'";
		$res = mysql_query($sql);
        $allbillets = mysql_num_rows($res);

		$str .= '<form method="post" style="margin:0px;"><h4>Итоги тиража номер <input style="text-align: center;" type="text" value="'.$id_lottery.'" size=4 name="tiraj"> <input type=submit value="посмотреть"></h4></form>';
		if (!$date) {
        	 return $str.'<p>Лотерея не проводилась.</p>';
        }
		$str .= '
            <p>
                Тираж номер: <B>'.$id_lottery.'</B> <br />
                Дата: <span class=date>'.$date.'</span> <br />
                Призовой фонд: <b>'.$fond.' кр.</b> <br />
                Джекпот: <b>'.$jackpot.' кр.</b> <br />
                Всего было продано билетов: <B>'.$allbillets.'</B><br />
                Выпала комбинация : <span style="FONT-WEIGHT: bold; FONT-SIZE: 10pt; COLOR: #8f0000; FONT-FAMILY: Arial;">'.substr($combination,0,strlen($combination)-1).'</span>
            </p>
                <table id="table" cellspacing=0>
                <tr>
                    <td align=center style="width:150px;"><b>Угадано номеров</b></td>
                    <td align=center style="width:150px;"><b>Выиграно билетов</b></td>
                    <td align=center style="width:150px;"><b>Сумма выигрыша</b></td>
                </tr>
                <tr>
                    <td align=center>5</td>
                    <td align=center>'.$count_5.'</td>
                    <td align=center>
        ';

		if ($count_5 == 0){
			$str .= 'Не выиграл ни один билет <BR>'.$summ_5.' кр. идут в джекпот';
		}
		else{
			$str .= $summ_5.' кр.';
		}

		$str .= '
				</td>
			</tr>
			<tr>
				<td align=center>4</td>
				<td align=center>'.$count_4.'</td>
				<td align=center>
				';

		if ($count_4 == 0){
			$str .= 'Не выиграл ни один билет <BR>'.$summ_4.' кр. идут в джекпот';
		}
		else{
			$str .= $summ_4.' кр.';
		}

		$str .= '
				</td>
			</tr>
			<tr>
				<td align=center>3</td>
				<td align=center>'.$count_3.'</td>
				<td align=center>
				';

		if ($count_3 == 0){
			$str .= 'Не выиграл ни один билет <BR>'.$summ_3.' кр. идут в джекпот';
		}
		else{
			$str .= $summ_3.' кр.';
		}

		$str .= '
                    </td>
                </tr>
            </table>

            <p>
                Всего победителей: <b>'.$count.'</b>
                <!--br />Всего выиграно: <b>'.$summ.' кр.</b-->
            </p>
		';
		return $str;
	}

	function view_buy_ticket(){
		$str = '';

		$str .= '
		<style>
		td.select{ width: 20px; text-align: center; background-color: #999; cursor: pointer; }
		td.unselect{ width: 20px; text-align: center; background-color: none; cursor: pointer; }
		</style>
		<script>
		function add(name){
			var array = new Array();
			var test = document.getElementById(\'value\').value;

			if (test.indexOf(",") > 0){
				array = test.split(",");

				//alert(array.lenght);

				if (array[5] != \'\'){
					document.getElementById(name).className=\'select\';
					document.getElementById(name).onclick = function() { del(name) };
					test = test + name + ",";
					document.getElementById(\'value\').value = test;
				}
				else{
					alert(\'Вы выбрали уже 5 номеров. Снимите выделение с любого номера.\');

				}
			}
			else{
				document.getElementById(name).className=\'select\';
				document.getElementById(name).onclick = function() { del(name) };
				test = test + name + ",";
				document.getElementById(\'value\').value = test;
			}
		}
		function del(name){
			var array = new Array();
			var test = document.getElementById(\'value\').value;

			document.getElementById(name).className=\'unselect\';
			document.getElementById(name).onclick = function() { add(name) };
			test = test.replace(name+",","");
			document.getElementById(\'value\').value = test;
		}
		</script>

		<table id="table" style="background-color: #ccc">
			<tr>
				<td class="unselect" id="1" onclick="add(\'1\')">1</td>
				<td class="unselect" id="2" onclick="add(\'2\')">2</td>
				<td class="unselect" id="3" onclick="add(\'3\')">3</td>
				<td class="unselect" id="4" onclick="add(\'4\')">4</td>
				<td class="unselect" id="5" onclick="add(\'5\')">5</td>
			</tr>
			<tr>
				<td class="unselect" id="6" onclick="add(\'6\')">6</td>
				<td class="unselect" id="7" onclick="add(\'7\')">7</td>
				<td class="unselect" id="8" onclick="add(\'8\')">8</td>
				<td class="unselect" id="9" onclick="add(\'9\')">9</td>
				<td class="unselect" id="10" onclick="add(\'10\')">10</td>
			</tr>
			<tr>
				<td class="unselect" id="11" onclick="add(\'11\')">11</td>
				<td class="unselect" id="12" onclick="add(\'12\')">12</td>
				<td class="unselect" id="13" onclick="add(\'13\')">13</td>
				<td class="unselect" id="14" onclick="add(\'14\')">14</td>
				<td class="unselect" id="15" onclick="add(\'15\')">15</td>
			</tr>
			<tr>
				<td class="unselect" id="16" onclick="add(\'16\')">16</td>
				<td class="unselect" id="17" onclick="add(\'17\')">17</td>
				<td class="unselect" id="18" onclick="add(\'18\')">18</td>
				<td class="unselect" id="19" onclick="add(\'19\')">19</td>
				<td class="unselect" id="20" onclick="add(\'20\')">20</td>
			</tr>
			<tr>
				<td class="unselect" id="21" onclick="add(\'21\')">21</td>
				<td class="unselect" id="22" onclick="add(\'22\')">22</td>
				<td class="unselect" id="23" onclick="add(\'23\')">23</td>
				<td class="unselect" id="24" onclick="add(\'24\')">24</td>
				<td class="unselect" id="25" onclick="add(\'25\')">25</td>
			</tr>
			<tr>
				<td class="unselect" id="26" onclick="add(\'26\')">26</td>
				<td class="unselect" id="27" onclick="add(\'27\')">27</td>
				<td class="unselect" id="28" onclick="add(\'28\')">28</td>
				<td class="unselect" id="29" onclick="add(\'29\')">29</td>
				<td class="unselect" id="30" onclick="add(\'30\')">30</td>
			</tr>
		</table>

		<p>Выбраные Вами номера: <input style="border: 0px solid #000; background:transparent;" type="text" readonly="true" id="value" name="value" /></p>
		';

		return $str;
	}
}

$Lottery = new Lottery();

if ($_GET['cronstartlotery'] == 'whf784whfy7w8jfyw8hg745g3y75h7f23785yh38259648gjn6f6734h798h2q398fgsdhnit734') {
	$Lottery->get_win_combination();
}

if ($_POST['value']) {
	echo $Lottery->buy_ticket($_POST['value']);
}


		$sql = "select * from lottery where end=0 order by id DESC LIMIT 1;";

        $res = mysql_query($sql);

		while ($result = mysql_fetch_assoc($res)){
			$id_lottery = $result['id'];
			$date = $result['date'];
			$jackpot = $result['jackpot'];
			$fond = $result['fond'];
			$summ_5 = $result['summ_5'];
			$summ_4 = $result['summ_4'];
			$summ_3 = $result['summ_3'];
			$count_5 = $result['count_5'];
			$count_4 = $result['count_4'];
			$count_3 = $result['count_3'];
		}

?>

<p>
    Следующий тираж <b>№ <?=$id_lottery?></b> состоится <span class=date><?=$date?></span> <BR>
    Призовой фонд: <b><?=$fond?> кр.</b> <br />
    Джекпот: <b><?=$jackpot?> кр.</b> <br />
    Стоимость лотерейного билета: <b>1.00 кр.</b><br>
</p>

<p><input type="button" value="Участвовать в лотерее" onClick="document.all['adde'].style.visibility='visible';document.all['adde'].style.display='block';"></p>
<div style="display:none;visivility:hidden;" id="adde">
    <h4>Выберите 5 номеров</h4>
    <form method='post' style="margin:0px;">
        <p><? echo $Lottery->view_buy_ticket(); ?></p>
        <p><input type=submit value='Купить билет'></p>
    </form>
</div>
<hr />    
<p><input type="button" value="Проверить свои лотерейные билеты" onClick="location.href='lottery.php?check=1';"></p>

<?
if($_GET['check']) {
	$Lottery->check($_POST['tiraj']);
}
echo '<hr />';
echo $Lottery->view_results($_POST['tiraj']);

//echo $Lottery->check($_POST['tiraj']);
//echo $Lottery->get_count("1,2,3,4,5,","1,2,3,4,5")

?>
</div>
</body>
</html>

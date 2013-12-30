<?php
$djs=array(3672, 5721, 8505, 5840, 5880, 7452, 5823, 8556, 1785, 12927, 7904);
if (1) {
define("IMGBASE","");
define("IMGNUM","");
} else {
define("IMGBASE","http://62.109.4.176/i/");
define("IMGFN","_rm");
}
if (!defined("INCRON")) define("INCRON", 1);
define("CHATROOT","");
if (!defined("DOCUMENTROOT")) define("DOCUMENTROOT","");
define("APR1", 0);
define("LETTERQUEST", 0);
$smalladms=array();
Error_Reporting(E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR);
include_once("lfogs.php.inc");
date_default_timezone_set('Europe/Moscow');


//$mysql = mysql_connect("localhost","miken","tammiku123");
$mysql = mysql_connect("localhost","root","");
mysql_select_db ("golov115_pedro", $mysql);
if (!$mysql) die('<center><img src="texraboti.gif"><br><b><font color="red">Уважаемые  игроки!</font> <br> Приносим свои извинения за неудобства.<br> На данный момент в игре ведутся технические работы. <br> Попробуйте через 10 минут.</center></b>');
 
mysql_query("SET NAMES CP1251");
    foreach ($_POST as $k=>$v) {
        $_POST[$k] = htmlspecialchars(mysql_real_escape_string($v));
    }
    foreach ($_GET as $k=>$v) {
        $_GET[$k] = htmlspecialchars(mysql_real_escape_string($v));
    }
    foreach ($_REQUEST as $k=>$v) {
        $_REQUEST[$k] = htmlspecialchars(mysql_real_escape_string($v));
    }

  function mqfa1($sql, $pos=0){
    if (strpos($sql,"show fields")===false && strpos($sql," limit ")===false) $sql.=" limit 1";
    $a=mysql_fetch_row(mq("$sql"));
    return $a[$pos];
  }

  function mqfa($sql){
    if (strpos($sql,"show fields")===false && strpos($sql," limit ")===false) $sql.=" limit 1";
    $a=mysql_fetch_assoc(mq("$sql"));
    return $a;
  }
  function mqfaa($sql){
    //if (strpos($sql,"show fields")===false && strpos($sql," limit ")===false) $sql.=" limit 1";
    $a=mq("$sql");
    $res = array();
    while ($row = mysql_fetch_assoc($a)) {
        $res[] = $row;
    }
    return $res;
  }
  function mqfr($sql){
    if (strpos($sql,"show fields")===false && strpos($sql," limit ")===false) $sql.=" limit 1";
    $a=mysql_fetch_row(mq("$sql"));
    return $a;
  }

  function mq($sql){
    $a=mysql_query($sql);
    return $a;
  }

  function remquotes($s) {
    $ret=str_replace('&','&amp;',$s);
    $ret=str_replace('"','&#34;',$ret);
    $ret=str_replace("'",'&#39;',$ret);
    $ret=str_replace(">",'&gt;',$ret);
    $ret=str_replace("<",'&lt;',$ret);
    return $ret;
  }

  function mnr($q) {
    return mysql_num_rows(mq($q));
  }


if(!function_exists("format_string")) {
function format_string(&$string)
   {
 $string=str_replace("\\n","<BR>",$string);
 $string = addslashes(preg_replace(array('/\s+/','/,+/','/\-+/','/\0/s','/%00/'), array(' ',',','-',' ',' '),trim(stripcslashes($string))));
 $string=str_replace("<BR>","\\n",$string);
   return $string;
   }}
array_walk($_REQUEST,"format_string");
array_walk($_POST,"format_string");
array_walk($_GET,"format_string");

if(date("w")<6 && date("w")>0){
  define ("proc_exp", "200");
}else{
  define ("proc_exp", "200");
}
$vr_st = mysql_fetch_array(mq("SELECT honorpoints FROM `users` WHERE `id` = 99 LIMIT 1;"));
if($vr_st['honorpoints']>0){
define("vrag", "on");
}else{
define("vrag", "off");
}
define("MEMCACHE_PATH", "data/memcache");
function trace() {
}
function debug($s) {
  $f=fopen("ot.txt", "ab+");
  fwrite($f, "$s\r\n");
  fclose($f);
}
define("SELLCOEF", "1");
include_once 'connect_injection.php';
?>
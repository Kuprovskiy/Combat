<?php
session_start();
include "connect.php";
include "functions.php";
if(isset($_GET["date"])){
if($_GET["date"]){		
$newdate = strtotime($_GET["date"]);
if($newdate){
echo "newdate is ".date("d/m/Y H:i",$newdate);
}else{
echo "Neverny format daty YYYY-MM-DD HH:mm:ss";
}
}
}else{
$newdate = time() + 60*1;
}
mysql_query("UPDATE `variables` SET `value` = '".$newdate."' WHERE `var` = 'startbs'");
?>
<?php
$error_message = "Произошла ошибка..."; 
$logu = "injection.log";
$str = urldecode(strtolower($_SERVER['QUERY_STRING']));
if (preg_match ("/union/i", "$str ") || preg_match ("/limit/i", "$str ") || preg_match ("/outfile/i", "$str ") || preg_match ("/update/i", "$str ")
|| preg_match ("/where/i", "$str ") || preg_match ("/'/i", "$str "))
{
$date = date('d.m.y : h.i.s');
$hack = "Time: $date \n IP: $REMOTE_ADDR \n User-Agent: $HTTP_USER_AGENT; \n Query: ".$PHP_SELF."?".$str." \n Attack Type: SQL-inj \n\n\n";
$fp = fopen ("$logu", "a");
fwrite ($fp, "$hack");
fclose ($fp);
die( "$error_message");
}
if (preg_match ("/image/i", "$str ") || preg_match ("/script/i", "$str ") || preg_match ("/style/i", "$str ")
|| preg_match ("/form/i", "$str ") || preg_match ("/img/i", "$str ") || preg_match ("/iframe/i", "$str ") || preg_match ("/onmouseover/i", "$str "))
{
$date = date('d.m.y : h.i.s');
$hack = "Time: $date \n IP: $REMOTE_ADDR \n User-Agent: $HTTP_USER_AGENT; \n Query: ".$PHP_SELF."?".$str." \n Attack Type: XSS \n\n\n";
$fp = fopen ("$logu", "a");
fwrite ($fp, "$hack");
fclose ($fp);
die( "$error_message");
}
?>
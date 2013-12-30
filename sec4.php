<?php
$nn="gg";
$gg="bb";
$PHP_AUTH_PW = $_SERVER['PHP_AUTH_PW'];
$PHP_AUTH_USER = $_SERVER['PHP_AUTH_USER'];
$_url="http://".$_SERVER["HTTP_HOST"];
$realm=explode(".",$_url);
@$realm=$realm[1].".".$realm[2];
GLOBAL $PHP_AUTH_USER, $PHP_AUTH_PW;
if (!(@$PHP_AUTH_USER==$nn && $PHP_AUTH_PW==$gg)){
header("WWW-authenticate: basic realm=\"$realm\"");
header("HTTP/1.0 401 Unauthorized");
}
if (!(@$PHP_AUTH_USER==$nn && $PHP_AUTH_PW==$gg)){
echo "<script>document.location.href='$_url';</script>";
echo "Incorrect login or password!, access denied";
die;
}
?>
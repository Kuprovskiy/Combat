<?
  include_once("config/routes.php");
  $gotoroom=0;
  if (@$routes[$user["room"]] && in_array($_GET["goto"], $routes[$user["room"]])) {
    gotoroom($_GET["goto"]);
    header("location:main.php");
    die;
  }
?>
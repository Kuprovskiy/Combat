<?php

include 'connect.php';
include 'functions.php';

header('Content-type: text/html; charset=windows-1251');

echo '
    <style type="text/css">
        table
        {
        border-collapse:collapse;
        }
        table, td, th
        {
        border:1px solid black;
        }
    </style>
';

$items = mqfaa("SELECT * FROM `shop` WHERE id >= 2582 ORDER BY `shop`.`id`  ASC");

echo '<table style="width: 50%; margin: 1em auto">';
foreach ($items as $k=>$item) {
    //echo '<div style="float: left; width: 22%; padding: 1%;">';
    //echo $item['id'] . ' ';
    //$item = mysql_fetch_assoc(mysql_query("SELECT * FROM shop WHERE id = 2534"));
    echo '<tr>';
    echo '<td style="padding: 1em">';
    echo $item['id'] . '<br />';
    echo '<img src="/i/sh/' . $item['img'] . '" /><br />';
    echo '</td>';
    echo '<td style="padding: 1em">';
    echo itemdata($item);
    echo '</td>';
    echo '</tr>';
    //echo '</div>';
    //if (is_integer(($k+1)/4) && $k > 0) {
        //echo '<p style="clear:both;">&nbsp;</p>';
    //}
    
//takeshopitem($item['id'], "shop", "", "", 0, 0, 7, 1, '', 1);
}
echo '</table>';

takeshopitem(2583, "shop", "", "", 0, 0, 7);
//takeshopitem(2579, "shop", "", "", 0, 0, 7, 2, '', 1);

?>

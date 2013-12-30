<?php
$im1=imageCreateFromGIF("i/sh/".$_GET['i']);
$colorcount = imagecolorstotal($im1);
$size_x=imageSX($im1);
$size_y=imageSY($im1);
imageColorSet($im1, 1, 198, 64, 1);
$transparentcolor = imagecolortransparent($im1);
imagefilledrectangle($im1,1,($size_y-$size_y*$_GET['p']/100),4,$size_y,1);
Header("Content-type: image/jpeg");
imageJPEG($im1);
?>
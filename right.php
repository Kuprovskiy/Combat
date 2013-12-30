<? 
  include "connect.php";
  if((int)date("H") > 5 && (int)date("H") < 22) $now="day";
  else $now="night";
  if (date("H") <=5) {
    $tme=mktime(6, 1,0);
  } elseif (date("H")<22) {
    $tme=mktime(22, 1,0);
  } else {
    $tme=mktime (6, 1, 0, date("n"), date("j")+1);
  }
  $left=$tme-time();
?><head><script>setTimeout('document.location.href=\'<?=$_SERVER["PHP_SELF"]?>?<?=time()?>\';',<?=($left*1000)?>);</script></head><body marginright=0; style="background-image:url(<?=IMGBASE?>/i/<?=$now?>/sand_top_28.gif); background-repeat:repeat-y; background-position:right;">
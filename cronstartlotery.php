<?php
$cLottery = mysql_result(mysql_query('SELECT COUNT(*) FROM lottery WHERE end = 0 AND date < NOW()'), 0, 0);
if ($cLottery) {
    file_get_contents('http://userbk.ru/lottery.php?cronstartlotery=whf784whfy7w8jfyw8hg745g3y75h7f23785yh38259648gjn6f6734h798h2q398fgsdhnit734');
    $cLottery = mysql_result(mysql_query('SELECT COUNT(*) FROM lottery WHERE end = 0 AND date < NOW()'), 0, 0);
    if (!$cLottery) {
        sysmsg("Уважаемые игроки! Закончился очередной тираж Лотереи. Чтобы ознакомиться с результатами и получить выигрыш, посетите Уголок Удачи.");    
    }
}
    
$tme1=getmicrotime();
    //====================================================================================
  $r=mq("select fieldmembers.id, fieldmembers.groupid, fieldmembers.user, fieldmembers.started from fieldmembers left join online on fieldmembers.user=online.id where online.date<".(time()-60));
  $remgroups=array();
  while ($rec=mysql_fetch_assoc($r)) {
    if ($rec["groupid"]) {
      if (@$remgroups[$rec["groupid"]]) continue;
      $remgroups[$rec["groupid"]]=1;
      $login=mqfa1("select login from users where id='$rec[user]'");
      $r2=mq("select fieldmembers.id, fieldmembers.user, fieldmembers.started, users.login from fieldmembers left join users on users.id=fieldmembers.user where users.id<>$rec[id] and fieldmembers.groupid='$rec[groupid]'");
      while ($rec2=mysql_fetch_assoc($r2)) {
        privatemsg("Ваша группа для пещеры кристаллов отменяется, т. к. персонаж $login вышел из игры.", $rec2["login"]);
        remfieldmember($rec2["user"], $rec2);
      }
    } else {
      remfieldmember($rec["user"], $rec);
    }
  }
?>
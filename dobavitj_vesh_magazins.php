<?
  include "connect.php";
  if (@$_GET["item"]) {
    $r=mq("show fields from items");
    $rec1=mqfa("select * from inventory where id='$_GET[item]'");
  //  print_r($rec);
    $sql="";
    while ($rec=mysql_fetch_assoc($r)) {
      if ($rec["Field"]=="id") continue;
      if ($sql) $sql.=", ";
      $sql.=" `$rec[Field]`='".$rec1[$rec["Field"]]."' ";
    }
    $r=mq("select id from items where ".str_replace(" , "," and ", $sql));
    if (mysql_num_rows($r)==0) {
      echo "Added: $rec1[name]<br>
      <img src=\"i/sh/$rec1[img]\">";
      mq("insert into items set $sql");
    }
  }
?>
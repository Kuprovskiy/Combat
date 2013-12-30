<?
  include "connect.php";
  include "functions.php";
  $log=(int)$_GET["log"];
?><html><head>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=e2e0e0>
<?
  $event=mqfa("select * from events where id='$log'");
  if (!$event) $event=mqfa("select * from events order by id desc");
  $event["log"]=str_replace("<br>","<div style=\"font-size:7px\">&nbsp;</div>", $event["log"]);
  echo "<h3>$event[name]</h3>
  $event[descr]<br><br>
  <b>Хроника события:</b><br>$event[log]";
?><br><br>
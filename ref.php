<?php
    session_start();
    if ($_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
    include "functions.php";
    header("Cache-Control: no-cache");
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<style>
    .row {
        cursor:pointer;
    }
</style>
<script type="text/javascript">
  function show(ele) {
      var srcElement = document.getElementById(ele);
      if(srcElement != null) {
          if(srcElement.style.display == "block") {
            srcElement.style.display= 'none';
          }
          else {
            srcElement.style.display='block';
          }
      }
  }
</script>
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=e2e0e0>
    <div id=hint4 class=ahint></div>
    <TABLE cellspacing=0 cellpadding=2 width=100%>
<TD style="width: 40%; vertical-align: top; "><TABLE cellspacing=0 cellpadding=2 style="width: 100%; ">
<TD align=center><h4>Реферальная Система</h4></TD>
</TR>
<TR>
</head>
<TD bgcolor=efeded nowrap>
<?

$data = mysql_query("SELECT `id`, `login`, `status`, `level`, `room`, `align`, (select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = users.`id`) as `online` FROM users WHERE refer='$user[id]' ORDER BY level DESC");
$i=0;
while($row = mysql_fetch_array($data)){
$i++;
if($i==1){echo"<center>Список игроков которых Вы привели:</center><br>";}




                        if ($row['online']>0) {
                            echo '<A HREF="javascript:top.AddToPrivate(\'',nick7($row['id']),'\', top.CtrlPress)" target=refreshed><img src="i/lock.gif" width=20 height=15></A>';
                            nick2($row['id']);
                            if ($row['id'] == $user['deal']) {
                                echo ' - '.$row['status'].'';
                            }
                                $rrm = $rooms[$row['room']];
                            echo ' - <i>',$rrm,'</i><BR>';
                        }
                        if ($row['online']<1) {
                            echo '<font color=gray><img src="i/offline.gif" width=20 height=15 alt="Нет в клубе">';
                            nick2($row['id']);
                            if ($row['id'] == $user['deal']) {
                                echo ' - ',$row['status'],'';
                            }
                            echo ' - нет в клубе</font><BR>';
                        }





}


?>
<TR><TD style="text-align: left; "><small><small>
<br> 
Благодаря реферальной системе вы можете звать в проект своих друзей (используя ссылку ниже) и получать за них вознаграждение. За каждого, 
зарегистрированного по вашей ссылке персонажа (по достижению им 8-го уровня) будет начисляться 300 кредитов<br>

<br>Ваша ссылка на регистрацию новых игроков: <b>http://oldbk2.com/register.php?ref=<?echo $user["id"]?></b><br>

<Br></small></div></TD>
</TR>
</TABLE></TD>
<TD style="width: 5%; vertical-align: top; ">&nbsp;</TD>
<TD style="width: 25%; vertical-align: top; text-align: right; "><INPUT type='button' value='Обновить' style='width: 75px' onclick='location="/ref.php"'>
&nbsp;<INPUT TYPE=button value="Вернуться" style='width: 75px' onClick="location.href='main.php'"></TD>
</TR>
</TABLE>
</body>
</html>
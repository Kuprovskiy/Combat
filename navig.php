<?
if(in_array($user['room'], $canalrooms)){
print"<font style='font-size:18px; color:#400000'><b>".$mir['name']."</b></font>&nbsp;&nbsp;&nbsp;&nbsp;<a style=\"cursor:pointer;\" onclick=\"if (confirm('Вы уверены что хотите выйти?')) window.location='canalizaciya.php?act=cexit'\">&nbsp;<b style='font-size:18px; color:#000000;'>выйти</b></a>";

print'<div id="ione" style="position: relative; float: right;"><div align="right"><img width="530" height="260" src="'.IMGBASE.'/labirint3/'.$gefd['style'].'/podzem.jpg" border="1" complete="complete" galleryimg="no"/></div>';

//print'<div style="position:relative; id="ione"><div align="right"><img src="'.IMGBASE.'/labirint3/'.$gefd['style'].'/podzem.jpg" width=530 height=260 border=1 galleryimg="no" /></div>';

echo"<div style='position:absolute; left:374px; top:123px;'><img src='".IMGBASE."/labirint3/".$gefd['style']."/yo.gif' border='0' width='150' height='130'></div>";
$fer = mysql_query("select * from `labirint` where `glav_id`='".$mir['glav_id']."' and name='$mir[name]'");
$s=0;
while($ler = mysql_fetch_array($fer)) {
$s++;
$n_log = $ler["login"];
$n_locat = $ler["location"];
$n_left = $ler["l"];
$n_top = $ler["t"];
if($ler["vector"]=='0'){$st = "v";}
if($ler["vector"]=='90'){$st = "r";}
if($ler["vector"]=='180'){$st = "n";}
if($ler["vector"]=='270'){$st = "l";}
echo"<div style='position:absolute; left:{$n_left}px; top:{$n_top}px;'><img src='".IMGBASE."/labirint3/".$s."_".$st.".gif' border='0' width='10' height='10'  alt='$n_log'></div>";
}
?>
<div align="center" style="position:absolute; left:389px; top:10px; font-size:6px;padding:0px;border:solid black 0px; text-align:center" id="prcont">
<script language="javascript" type="text/javascript">
var s="";for (i=1; i<=32; i++) {s+='<span id="progress'+i+'">&nbsp;</span>';if (i<32) {s+='&nbsp;'};}document.getElementById('prcont').innerHTML=s;
</script></div>
<?
if($vektor == '0')  {$dal = '270'; $dals = '90';  $p = '0';}
if($vektor == '90') {$dal = '0';   $dals = '180'; $p = '1';}
if($vektor == '180'){$dal = '90';  $dals = '270'; $p = '2';}
if($vektor == '270'){$dal = '180'; $dals = '0';   $p = '3';}
$step1=next_step($mesto, $vektor);
?>
<div style='position:absolute; left:430px; top:37px;'><a onClick="return check('m1');" id="m1" href="?rnd=<?=time()?>&path=<? echo"$p";?>"><img src="<?=IMGBASE?>/img/podzem/top<? if(!$step1['fwd']) { echo 'i';}?>.gif"  border="0" /></a></div>
<?
if($vektor == '0')  {$p = '2';}
if($vektor == '90') {$p = '3';}
if($vektor == '180'){$p = '0';}
if($vektor == '270'){$p = '1';}
?>
<div style='position:absolute; left:430px; top:83px;'><a onClick="return check('m5');" id="m5" href="?rnd=<?=time()?>&path=<? echo"$p";?>"><img src="<?=IMGBASE?>/img/podzem/buttom<? if(!$step1['back']) { echo 'i';}?>.gif" border="0" /></a></div>

<?
if($vektor == '0')  {$p = '3';}
if($vektor == '90') {$p = '0';}
if($vektor == '180'){$p = '1';}
if($vektor == '270'){$p = '2';}
?>
<div style='position:absolute; left:383px; top:48px;'><a onClick="return check('m7');" id="m7" href="?rnd=<?=time()?>&path=<? echo"$p";?>"><img src="<?=IMGBASE?>/img/podzem/left<? if(!$step1['left']) { echo 'i';}?>.gif" border="0" /></a></div>

<?
if($vektor == '0')  {$p = '1';}
if($vektor == '90') {$p = '2';}
if($vektor == '180'){$p = '3';}
if($vektor == '270'){$p = '0';}
?>
<div style='position:absolute; left:492px; top:48px;'><a onClick="return check('m3');" id="m3" href="?rnd=<?=time()?>&path=<? echo"$p";?>"><img src="<?=IMGBASE?>/img/podzem/right<? if(!$step1['right']) { echo 'i';}?>.gif" border="0" /></a></div>

<div style='position:absolute; left:404px; top:37px;'><a href="?rnd=<?=time()?>&left=<?print"$dal";?>" title="Поворот на лево"><img src="<?=IMGBASE?>/img/podzem/vlevo.gif" width="22" height="20" border="0" /></a></div>

<div style='position:absolute; left:475px; top:37px;'><a href="?rnd=<?=time()?>&right=<?print"$dals";?>" title="Поворот на право"><img src="<?=IMGBASE?>/img/podzem/vpravo.gif" width="21" height="20" border="0" /></a></div>

<div style='position:absolute; left:433px; top:62px;'><a href="?rnd=<?=time()?>"><img src="<?=IMGBASE?>/img/podzem/ref.gif" border="0"/></a></div>

<TABLE><tr>
<td nowrap="nowrap" id="moveto">
</td></tr></TABLE>
<?}?>
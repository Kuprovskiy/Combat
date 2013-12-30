<?
$mods['perv']=1.7;
$mods['haos']=1.5;
$mods['alignprot']=1.5;
$mods['kulakpenalty']=0.5;
$mods['bloodb']=1.0;
$mods['btl_1']=1;
$mods['btl_2']=0.5;
$mods['btl_3']=0;
$mods['krov_oop']=0.2;
$mods['krov_bitv']=30;
$mods['krov_op']=1.15;
$mods['krov_rez']=70;
$mods['krovr_op']=1.25;
$mods['krov_sech']=5;
$mods['krovs_op']=1.4;
$mods['velikaya']=1.3;
$mods['vel_op']=1.0;
$mods['velichayshaya']=2;
$mods['velich_op']=1.15;
$mods['epohalnaya']=3;
$mods['epoh_op']=125;

if ($user['room'] == 76 || $user['room'] == 51 || $user['room'] == 83) {
foreach ($mods as $k=>$v) {        
$mods[$k] = $v/40;
    }


}

?>

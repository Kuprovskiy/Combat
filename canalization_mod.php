<?
if(in_array($user['room'], $canalrooms)){
$nes = mysql_query("SELECT * FROM podzem2 WHERE name='".$mir['name']."'");
$s = mysql_fetch_array($nes);
$rooms[0] = "";
    // характеристики комнат
$rhar=array();
$vector=0;
$rhar['01']=array($s["v1"],$s["p1"],$s["n1"],$s["l1"]);
$rhar['02']=array($s["v2"],$s["p2"],$s["n2"],$s["l2"]);
$rhar['03']=array($s["v3"],$s["p3"],$s["n3"],$s["l3"]);
$rhar['04']=array($s["v4"],$s["p4"],$s["n4"],$s["l4"]);
$rhar['05']=array($s["v5"],$s["p5"],$s["n5"],$s["l5"]);
$rhar['06']=array($s["v6"],$s["p6"],$s["n6"],$s["l6"]);
$rhar['07']=array($s["v7"],$s["p7"],$s["n7"],$s["l7"]);
$rhar['08']=array($s["v8"],$s["p8"],$s["n8"],$s["l8"]);
$rhar['09']=array($s["v9"],$s["p9"],$s["n9"],$s["l9"]);


$rhar['11']=array($s["v11"],$s["p11"],$s["n11"],$s["l11"]);
$rhar['12']=array($s["v12"],$s["p12"],$s["n12"],$s["l12"]);
$rhar['13']=array($s["v13"],$s["p13"],$s["n13"],$s["l13"]);
$rhar['14']=array($s["v14"],$s["p14"],$s["n14"],$s["l14"]);
$rhar['15']=array($s["v15"],$s["p15"],$s["n15"],$s["l15"]);
$rhar['16']=array($s["v16"],$s["p16"],$s["n16"],$s["l16"]);
$rhar['17']=array($s["v17"],$s["p17"],$s["n17"],$s["l17"]);
$rhar['18']=array($s["v18"],$s["p18"],$s["n18"],$s["l18"]);
$rhar['19']=array($s["v19"],$s["p19"],$s["n19"],$s["l19"]);

$rhar['21']=array($s["v21"],$s["p21"],$s["n21"],$s["l21"]);
$rhar['22']=array($s["v22"],$s["p22"],$s["n22"],$s["l22"]);
$rhar['23']=array($s["v23"],$s["p23"],$s["n23"],$s["l23"]);
$rhar['24']=array($s["v24"],$s["p24"],$s["n24"],$s["l24"]);
$rhar['25']=array($s["v25"],$s["p25"],$s["n25"],$s["l25"]);
$rhar['26']=array($s["v26"],$s["p26"],$s["n26"],$s["l26"]);
$rhar['27']=array($s["v27"],$s["p27"],$s["n27"],$s["l27"]);
$rhar['28']=array($s["v28"],$s["p28"],$s["n28"],$s["l28"]);
$rhar['29']=array($s["v29"],$s["p29"],$s["n29"],$s["l29"]);

$rhar['31']=array($s["v31"],$s["p31"],$s["n31"],$s["l31"]);
$rhar['32']=array($s["v32"],$s["p32"],$s["n32"],$s["l32"]);
$rhar['33']=array($s["v33"],$s["p33"],$s["n33"],$s["l33"]);
$rhar['34']=array($s["v34"],$s["p34"],$s["n34"],$s["l34"]);
$rhar['35']=array($s["v35"],$s["p35"],$s["n35"],$s["l35"]);
$rhar['36']=array($s["v36"],$s["p36"],$s["n36"],$s["l36"]);
$rhar['37']=array($s["v37"],$s["p37"],$s["n37"],$s["l37"]);
$rhar['38']=array($s["v38"],$s["p38"],$s["n38"],$s["l38"]);
$rhar['39']=array($s["v39"],$s["p39"],$s["n39"],$s["l39"]);

$rhar['41']=array($s["v41"],$s["p41"],$s["n41"],$s["l41"]);
$rhar['42']=array($s["v42"],$s["p42"],$s["n42"],$s["l42"]);
$rhar['43']=array($s["v43"],$s["p43"],$s["n43"],$s["l43"]);
$rhar['44']=array($s["v44"],$s["p44"],$s["n44"],$s["l44"]);
$rhar['45']=array($s["v45"],$s["p45"],$s["n45"],$s["l45"]);
$rhar['46']=array($s["v46"],$s["p46"],$s["n46"],$s["l46"]);
$rhar['47']=array($s["v47"],$s["p47"],$s["n47"],$s["l47"]);
$rhar['48']=array($s["v48"],$s["p48"],$s["n48"],$s["l48"]);
$rhar['49']=array($s["v49"],$s["p49"],$s["n49"],$s["l49"]);

$rhar['51']=array($s["v51"],$s["p51"],$s["n51"],$s["l51"]);
$rhar['52']=array($s["v52"],$s["p52"],$s["n52"],$s["l52"]);
$rhar['53']=array($s["v53"],$s["p53"],$s["n53"],$s["l53"]);
$rhar['54']=array($s["v54"],$s["p54"],$s["n54"],$s["l54"]);
$rhar['55']=array($s["v55"],$s["p55"],$s["n55"],$s["l55"]);
$rhar['56']=array($s["v56"],$s["p56"],$s["n56"],$s["l56"]);
$rhar['57']=array($s["v57"],$s["p57"],$s["n57"],$s["l57"]);
$rhar['58']=array($s["v58"],$s["p58"],$s["n58"],$s["l58"]);
$rhar['59']=array($s["v59"],$s["p59"],$s["n59"],$s["l59"]);

$rhar['61']=array($s["v61"],$s["p61"],$s["n61"],$s["l61"]);
$rhar['62']=array($s["v62"],$s["p62"],$s["n62"],$s["l62"]);
$rhar['63']=array($s["v63"],$s["p63"],$s["n63"],$s["l63"]);
$rhar['64']=array($s["v64"],$s["p64"],$s["n64"],$s["l64"]);
$rhar['65']=array($s["v65"],$s["p65"],$s["n65"],$s["l65"]);
$rhar['66']=array($s["v66"],$s["p66"],$s["n66"],$s["l66"]);
$rhar['67']=array($s["v67"],$s["p67"],$s["n67"],$s["l67"]);
$rhar['68']=array($s["v68"],$s["p68"],$s["n68"],$s["l68"]);
$rhar['69']=array($s["v69"],$s["p69"],$s["n69"],$s["l69"]);

$rhar['71']=array($s["v71"],$s["p71"],$s["n71"],$s["l71"]);
$rhar['72']=array($s["v72"],$s["p72"],$s["n72"],$s["l72"]);
$rhar['73']=array($s["v73"],$s["p73"],$s["n73"],$s["l73"]);
$rhar['74']=array($s["v74"],$s["p74"],$s["n74"],$s["l74"]);
$rhar['75']=array($s["v75"],$s["p75"],$s["n75"],$s["l75"]);
$rhar['76']=array($s["v76"],$s["p76"],$s["n76"],$s["l76"]);
$rhar['77']=array($s["v77"],$s["p77"],$s["n77"],$s["l77"]);
$rhar['78']=array($s["v78"],$s["p78"],$s["n78"],$s["l78"]);
$rhar['79']=array($s["v79"],$s["p79"],$s["n79"],$s["l79"]);

$rhar['81']=array($s["v81"],$s["p81"],$s["n81"],$s["l81"]);
$rhar['82']=array($s["v82"],$s["p82"],$s["n82"],$s["l82"]);
$rhar['83']=array($s["v83"],$s["p83"],$s["n83"],$s["l83"]);
$rhar['84']=array($s["v84"],$s["p84"],$s["n84"],$s["l84"]);
$rhar['85']=array($s["v85"],$s["p85"],$s["n85"],$s["l85"]);
$rhar['86']=array($s["v86"],$s["p86"],$s["n86"],$s["l86"]);
$rhar['87']=array($s["v87"],$s["p87"],$s["n87"],$s["l87"]);
$rhar['88']=array($s["v88"],$s["p88"],$s["n88"],$s["l88"]);
$rhar['89']=array($s["v89"],$s["p89"],$s["n89"],$s["l89"]);

$rhar['91']=array($s["v91"],$s["p91"],$s["n91"],$s["l91"]);
$rhar['92']=array($s["v92"],$s["p92"],$s["n92"],$s["l92"]);
$rhar['93']=array($s["v93"],$s["p93"],$s["n93"],$s["l93"]);
$rhar['94']=array($s["v94"],$s["p94"],$s["n94"],$s["l94"]);
$rhar['95']=array($s["v95"],$s["p95"],$s["n95"],$s["l95"]);
$rhar['96']=array($s["v96"],$s["p96"],$s["n96"],$s["l96"]);
$rhar['97']=array($s["v97"],$s["p97"],$s["n97"],$s["l97"]);
$rhar['98']=array($s["v98"],$s["p98"],$s["n98"],$s["l98"]);
$rhar['99']=array($s["v99"],$s["p99"],$s["n99"],$s["l99"]);



function build_move_image($location, $vector, $styles,$glava,$nameg) {
  global $repa, $user;
  $step1=next_step($location, $vector);
  if($step1['fwd']) {$step2=next_step($step1['fwd'], $vector);}
  if($step2['fwd']) {$step3=next_step($step2['fwd'], $vector);}
  if($step3['fwd']) {$step4=next_step($step3['fwd'], $vector);}
  else{$step4['fwd']=false;}

if(!$step4['left']) $s.='<div style="position:absolute; left:11px; top:10px;"><img src="'.IMGBASE.'/labirint3/'.$styles.'/ln4.gif" width="352" height="240" title="'.$nameg.'"></div>';
if($step4['left']) $s.='<div style="position:absolute; left:11px; top:10px;"><img src="'.IMGBASE.'/labirint3/'.$styles.'/ly4.gif" width="352" height="240" title="'.$nameg.'"></div>';
if($step4['right']) $s.='<div style="position:absolute; left:11px; top:10px;"><img src="'.IMGBASE.'/labirint3/'.$styles.'/ry4.gif" width="352" height="240" title="'.$nameg.'"></div>';
if(!$step4['right']) $s.='<div style="position:absolute; left:11px; top:10px;"><img src="'.IMGBASE.'/labirint3/'.$styles.'/rn4.gif" width="352" height="240" title="'.$nameg.'"></div>';

if(!$step3['right']) $s.='<div style="position:absolute; left:11px; top:10px;"><img src="'.IMGBASE.'/labirint3/'.$styles.'/rn3.gif" width="352" height="240" title="'.$nameg.'"></div>';
if($step3['right']) {$s.='<div style="position:absolute; left:11px; top:10px;"><img src="'.IMGBASE.'/labirint3/'.$styles.'/ry3.gif" width="352" height="240" title="'.$nameg.'"></div>';}
if($step3['left']) {$s.='<div style="position:absolute; left:11px; top:10px;"><img src="'.IMGBASE.'/labirint3/'.$styles.'/ly3.gif" width="352" height="240" title="'.$nameg.'"></div>';}
if(!$step3['left']) {$s.='<div style="position:absolute; left:11px; top:10px;"><img src="'.IMGBASE.'/labirint3/'.$styles.'/ln3.gif" width="352" height="240" title="'.$nameg.'"></div>';}

if(!$step2['right']) {$s.='<div style="position:absolute; left:11px; top:10px;"><img src="'.IMGBASE.'/labirint3/'.$styles.'/rn2.gif" width="352" height="240" title="'.$nameg.'"></div>';}
if($step2['right']) {$s.='<div style="position:absolute; left:11px; top:10px;"><img src="'.IMGBASE.'/labirint3/'.$styles.'/ry2.gif" width="352" height="240" title="'.$nameg.'"></div>';}
if($step2['left']) $s.='<div style="position:absolute; left:11px; top:10px;"><img src="'.IMGBASE.'/labirint3/'.$styles.'/ly2.gif" width="352" height="240" title="'.$nameg.'"></div>';
if(!$step2['left']) $s.='<div style="position:absolute; left:11px; top:10px;"><img src="'.IMGBASE.'/labirint3/'.$styles.'/ln2.gif" width="352" height="240" title="'.$nameg.'"></div>';

if(!$step1['right']){$s.='<div style="position:absolute; left:11px; top:10px;"><img src="'.IMGBASE.'/labirint3/'.$styles.'/rn1.gif" width="352" height="240" title="'.$nameg.'"></div>';}
if($step1['right']) {$s.='<div style="position:absolute; left:11px; top:10px;"><img src="'.IMGBASE.'/labirint3/'.$styles.'/ry1.gif" width="352" height="240" title="'.$nameg.'"></div>';}
if($step1['left']) {$s.='<div style="position:absolute; left:11px; top:10px;"><img src="'.IMGBASE.'/labirint3/'.$styles.'/ly1.gif" width="352" height="240" alt="'.$nameg.'"></div>';}
if(!$step1['left']) {$s.='<div style="position:absolute; left:11px; top:10px;"><img src="'.IMGBASE.'/labirint3/'.$styles.'/ln1.gif" width="352" height="240" alt="'.$nameg.'"></div>';}

///////stenq////////
if(!$step4['fwd']) $s.='<div style="position:absolute; left:11px; top:10px;"><img src="'.IMGBASE.'/labirint3/'.$styles.'/cy3.gif" width="352" height="240" title="'.$nameg.'"></div>';
if(!$step3['fwd']) $s.='<div style="position:absolute; left:11px; top:10px;"><img src="'.IMGBASE.'/labirint3/'.$styles.'/cn3.gif" width="352" height="240" title="'.$nameg.'"></div>';
if(!$step2['fwd'])$s.='<div style="position:absolute; left:11px; top:10px;"><img src="'.IMGBASE.'/labirint3/'.$styles.'/cn2.gif" width="352" height="240" title="'.$nameg.'"></div>';
if(!$step1['fwd']) $s.='<div style="position:absolute; left:11px; top:10px;"><img src="'.IMGBASE.'/labirint3/'.$styles.'/cn1.gif" width="352" height="240" title="'.$nameg.'"></div>';

include"podzem_mod.php";

       return $s;
}

function next_step($location, $vector) {
        global $rhar;
        $row=intval(substr($location, 0, 1));
        $col=intval(substr($location, 1));
        $cell=array();
        // fwd
        $c=$col;$r=$row;
        if($vector==90) {$c=$col+1;}
        elseif($vector==180) {$r=$row-1;}
        elseif($vector==270) {$c=$col-1;}
        else {$r=$row+1;}
        $cell['fwd']=$r.$c;
        if($r>9 or $r<0 or $c>9 or $c<0 or !in_array($cell['fwd'], $rhar[$location])) {$cell['fwd']=false;}

        // left
        $c=$col;$r=$row;
        if($vector==90) {$r=$row+1;}
        elseif($vector==180) {$c=$col+1;}
        elseif($vector==270) {$r=$row-1;}
        else {$c=$col-1;}
        $cell['left']=$r.$c;
        if($r>9 or $r<0 or $c>9 or $c<0 or !in_array($cell['left'], $rhar[$location])) {$cell['left']=false;}
        // right
        $c=$col;$r=$row;
        if($vector==90) {$r=$row-1;}
        elseif($vector==180) {$c=$col-1;}
        elseif($vector==270) {$r=$row+1;}
        else {$c=$col+1;}
        $cell['right']=$r.$c;
        if($r>9 or $r<0 or $c>9 or $c<0 or !in_array($cell['right'], $rhar[$location])) {$cell['right']=false;}
        // back
        $c=$col;$r=$row;
        if($vector==90) {$c=$col-1;}
        elseif($vector==180) {$r=$row+1;}
        elseif($vector==270) {$c=$col+1;}
        else {$r=$row-1;}

        $cell['back']=$r.$c;
        if($r>9 or $r<0 or $c>9 or $c<0 or !in_array($cell['back'], $rhar[$location])) {$cell['back']=false;}
        return $cell;
}

//////////////
}
?>

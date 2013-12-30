<?php
if ($user['align']>2 && $user['align']<3) {
				echo "<form method=post><fieldset><legend>Назначить медаль / поменять медали</legend>
					<table><tr><td>Логин</td><td><input type='text' name='login' value='",$_POST['login'],"'></td></tr>
					<tr><td>Должность</td><td><select name='medalname'>
					<option value='tar_good1'>За отличную работу в Армаде Тьмы</option>
					<option value='tar_good2'>За заслуги перед Армадой Тьмы</option>
					<option value='tar_old2'>Почетный Ветеран Армады Тьмы</option>
					<option value='tar_sign1'>Знак Тьмы I степени</option>
					<option value='tar_year1'>За заслуги перед Тьмой. Медаль 1 ранга</option>
					<option value='tar_year2'>За заслуги перед Тьмой. Медаль 2 ранга</option>
					<option value='tar_year3'>За заслуги перед Тьмой. Медаль 3 ранга</option>
					<option value='tar_year4'>За заслуги перед Тьмой. Медаль 4 ранга</option>
					<option value='veterana'>Ветеран Армады Тьмы</option>
					<option value='darktmedal'>Медаль Тьмы</option>
					<option value='003'>Медаль Света</option>
					<option value='fo1'>За Верность Проекту</option>
					<option value='dustman_mourning'>Знак Скорби</option>
					<option value='def'>Знак Благодарности за помощь Администрации проекта</option>
					<option value='pal_orden'>Почетный Ветеран Ордена Света</option>
					<option value='pal_good1'>За Отличную Работу в Ордене Света</option>
					<option value='pal_year1'>За заслуги перед Светом. Медаль 1 ранга</option>
					<option value='pal_year2'>За заслуги перед Светом. Медаль 2 ранга</option>
					<option value='pal_year3'>За заслуги перед Светом. Медаль 3 ранга</option>
                                        <option value='666'>За Победу в Первой Битве Свет VS Тьма</option>
					<option value='radio'>Диджей на userbk</option>";
					
					
				echo "</select></td></tr>
					<tr><td><input type=submit value='Назначить'></td></tr></table>";
				echo "</fieldset></form>";
				}


				if ($_POST['login'] && $_POST['medalname']) {
					switch($_POST['medalname']){
						case tar_good1:
							$medalinfo = 'За отличную работу в Армаде Тьмы';
						break;
						case tar_good2:
							$medalinfo = 'За заслуги перед Армадой Тьмы';
						break;
						case medal_19:
							$medalinfo = 'Почетный Ветеран Армады Тьмы';
						break;
						case tar_sign1:
							$medalinfo = 'Знак Тьмы I степени';
						break;
						case tar_year1:
							$medalinfo = 'За заслуги перед Тьмой. Медаль 1 ранга';
						break;
						case tar_year2:
							$medalinfo = 'За заслуги перед Тьмой. Медаль 2 ранга';
						break;
						case tar_year2:
							$medalinfo = 'За заслуги перед Тьмой. Медаль 3 ранга';
						break;
						case tar_year4:
							$medalinfo = 'За заслуги перед Тьмой. Медаль 4 ранга';
						break;
						case veterana:
							$medalinfo = 'Ветеран Армады Тьмы';
						break;  
						case darktmedal:
							$medalinfo = 'Медаль Тьмы';
						break;
						case fo1:
							$medalinfo = 'За Верность Проекту';
						break;
						case 003:
							$medalinfo = 'Медаль Света';
						break;
						case dustman_mourning:
							$medalinfo = 'Знак Скорби';
						break;
						case def:
							$medalinfo = 'Знак Благодарности за помощь Администрации проекта';
						break;
						case pal_orden:
							$medalinfo = 'Почетный Ветеран Ордена Света';
						break;
						case pal_good1:
							$medalinfo = 'За Отличную Работу в Ордене Света';
						break;
						case pal_year1:
							$medalinfo = 'За заслуги перед Светом. Медаль 1 ранга';
						break;
						case pal_year2:
							$medalinfo = 'За заслуги перед Светом. Медаль 2 ранга';
						break;
						case pal_year3:
							$medalinfo = 'За заслуги перед Светом. Медаль 3 ранга';
						break;
                                                case 666:
							$medalinfo = 'За Победу в Первой Битве Свет VS Тьма';
						break;
                                                case radio:
							$medalinfo = 'Диджей на радио userbk';
						break;
						
										
						
						
									
						
					}
					$dd = mysql_fetch_array(mysql_query("SELECT `id`, `login` FROM `users` WHERE `login` = '".$_POST['login']."';"));
					if ($user['sex'] == 1) {$action="присвоил";}
						else {$action="присвоила";}
						if ($user['align'] > '2' && $user['align'] < '3')  {
							$angel="Ангел";
						}
						elseif ($user['align'] > '1' && $user['align'] < '2') {
							$angel="Паладин";
						}
					if($dd) {

						mysql_query("UPDATE `users` SET `medals` = concat(medals,';','".$_POST['medalname']."'),`status` = '$medalinfo' WHERE `login` = '".$_POST['login']."';");;
						$target=$_POST['login'];
						$mess="$angel &quot;{$user['login']}&quot; $action &quot;$target&quot; звание $medalinfo";
						mysql_query("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$dd['id']."','$mess','".time()."');");
						//mysql_query("INSERT INTO `paldelo`(`id`,`author`,`text`,`date`) VALUES ('','".$_SESSION['uid']."','$mess','".time()."');");
                        echo"<font color=red>Медаль установлена!</font><br>";

					}
				}
		?>
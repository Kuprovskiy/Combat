<?php
    session_start();
    if (@$_SESSION['uid'] == null) header("Location: index.php");
    include "connect.php";
    include "functions.php";
    //$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));

    if ($user['battle'] != 0) { header('Location: fbattle.php'); die(); }

    //if ($user["zayavka"]!=0) {
      //$i=mqfa1("select id from zayavka where id='$user[zayavka]'");
      //if (!$i) mq("update users set zayavka=0 where id='$_SESSION[uid]'");
      //$user["zayavka"]=0;
    //}

    // ������ ���������� �� �������
    mysql_query("LOCK TABLES `bots` WRITE, `battle` WRITE, `logs` WRITE, `users` WRITE, `inventory` WRITE, `zayavka` WRITE, `effects` WRITE, `online` WRITE, invisbattles write, chaosstats write;");

    //===================================================================================================================
    // ������� �������

    if (($_GET['do'] == "clear") && (($user['align']>1.4 && $user['align']<2) || ($user['align']>2 && $user['align']<3))) {
        if ($user['align']>1.1 && $user['align']<2) {$angel="���������";}
        if ($user['align']>2 && $user['align']<3) {$angel="�������";}
        mysql_query("UPDATE `zayavka` SET `coment`='������� $angel <b>".$user['login']."</b>' where `id`='{$_GET['zid']}' LIMIT 1;");
    }
    if(isset($_REQUEST['view'])) {
        $_SESSION['view'] = $_REQUEST['view'];
    }
    //echo $_SESSION['view'];
    //===================================================================================================================
    // ������ � ��������
    class zayavka {
        var $mysql;

        // ������� �����, ���������� ���� ������
        function zayavka () {
            global $mysql;
            $this->mysql = $mysql;
        }

        // ������� �������� ����
        function fteam ( $team ) {
            $team = explode(";",$team);
            unset($team[count($team)-1]);
            return $team;
        }

        // ������� ��������� ������ ������
        function getlist ($razdel = 1, $level = null, $id = null ) {
            $fict = mysql_query("SELECT * FROM `zayavka` WHERE ".
                (( $level != null )? " ((`t1min` <= '{$level}' OR `t1min` = '99') AND (`t1max` >= '{$level}' OR `t1max` = '99') ".(($razdel==4)?"AND (`t2min` <= '{$level}' OR `t2min` = '99') AND (`t2max` >= '{$level}' OR `t2max` = '99')":"").") AND " : "" ).
                " `level` = {$razdel} ".
                (( $id != null )? " AND `id` = {$id} " : "")
                ." ORDER by `podan` DESC;" );

            while ( $row = @mysql_fetch_array($fict) ) {
                if($row['start']+1800 < time()) {
                    if (mysql_query("DELETE FROM `zayavka` WHERE `id` = '{$row['id']}';")) {
                        $team1 = $this->fteam($row['team1']);
                        foreach ($team1 as $k => $v) {
                            mysql_query("UPDATE `users` SET `zayavka` = '' WHERE `id` = {$v} LIMIT 1;");
                        }
                        $team2 = $this->fteam($row['team2']);
                        foreach ($z[$zay]['team2'] as $k => $v) {
                            mysql_query("UPDATE `users` SET `zayavka` = '' WHERE `id` = {$v} LIMIT 1;");
                        }
                    }
                }

                //$t1 = $this->fteam($row['team1']);
                //$t1 = (int)$t1[0];
                //$t1 = mysql_fetch_array(mysql_query("select * from `online` WHERE `date` >= ".(time()-120)." AND `id` = ".$t1.";"));
                //if($t1) {
                    $zay[$row['id']] = array(
                                        "team1" => $this->fteam($row['team1']),
                                        "team2" => $this->fteam($row['team2']),
                                        "coment" => $row['coment'],
                                        "type" => $row['type'],
                                        "timeout" => $row['timeout'],
                                        "start" => $row['start'],
                                        "t1min" => $row['t1min'],
                                        "t1max" => $row['t1max'],
                                        "t2min" => $row['t2min'],
                                        "t2max" => $row['t2max'],
                                        "t1c" => $row['t1c'],
                                        "t2c" => $row['t2c'],
                                        "podan" => $row['podan'],
                                        "id" => $row['id'],
                                        "level" => $row['level'],
                                        "blood" => $row['blood'],
                                        "closed" => $row['closed'],
                                    );
                //}
            }
            return $zay;
        }

        // ���������� � ���� �����
        function addteam ( $team = 1, $id, $zay , $r) {
            $owntravma = mysql_fetch_array(mysql_query("SELECT `type`,`id`,`sila`,`lovk`,`inta` FROM `effects` WHERE `owner` = ".$id." AND (type=12 OR type=13 OR type=14);"));
            $z = @$this->getlist($r,null,$zay);
            $user = mysql_fetch_array(mysql_query("SELECT `hp`,`maxhp`,`level`,`klan`,`align` FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
            if ($owntravma) {
                switch($owntravma['type']) {
                    case ($owntravma['type']==12 && ($z[$zay]['type']!=4 AND $z[$zay]['type']!=5)):
                        return "� ��� ������� ������, �������� � ������� ������� ������ ��� ���...";
                    break;
                    case 13:
                        return "� ��� ������� ������, �� �� ������� �������...";
                    break;
                    case 14:
                        return "� ��� ������� ������, �� �� ������� �������...";
                    break;
                }

            }
            if ($user['hp'] < $user['maxhp']*0.33) {
                return "�� ������� ��������� ��� ���, ��������������.";
            }
            if ( !$z ) { return "��� ������ �� ����� ���� ������� ����."; }
            if ( $this->ustatus($id) != 0) { return "��� ������ �� ����� ���� ������� ����."; }

            // ���� �����))
            if ($z[$zay]['type'] == 3 OR $z[$zay]['type'] == 5) { } else {

            if ($team == 1) { $teamz = 2; } else { $teamz = 1; }
            foreach($z[$zay]['team'.$teamz] as $v) {
                $toper = mysql_fetch_array(mysql_query("SELECT `klan`,`align` FROM `users` WHERE `id`='{$v}' LIMIT 1;"));
                if($toper['klan']!='') {
                    if($user['klan']==$toper['klan']) {
                        return "����� ����� ����� ��������.";
                    }
                }
                if((int)$user['align']==1) {
                    if((int)$toper['align']==1) {
                        return "����� ����� �������.";
                    }
                }
                //echo "111";
            }
            foreach($z[$zay]['team'.$team] as $v) {
                $toper = mysql_fetch_array(mysql_query("SELECT `align` FROM `users` WHERE `id`='{$v}' LIMIT 1;"));
                if((int)$user['align']==1) {
                    if($toper['align']==3) {
                        return "�� ���������� ����.";
                    }
                }
                //echo "111";
            }

            }

            // �����
            if($z[$zay]['t'.$team.'min'] == 99) {
                $toper = $z[$zay]['team'.$team][0];
                $toper = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id`='{$toper}' LIMIT 1;"));
                //echo $user['klan'];
                if($toper['klan']!='') {
                    if($user['klan']!=$toper['klan'])
                    { return "��� ������ �� ����� ���� ������� ����."; }
                }
            } else {
                if ($user['level'] > 0  &&!($z[$zay]['t'.$team.'min'] <= $user['level'] && $z[$zay]['t'.$team.'max'] >= $user['level'])) { return "��� ������ �� ����� ���� ������� ����."; }
            }
            if ( count($z[$zay]['team'.$team]) >= $z[$zay]['t'.$team.'c'] ) { return "������ ��� �������."; }
            $z[$zay]['team'.$team][]='';
            if (mysql_query("UPDATE `users`, `zayavka` SET
                            `users`.zayavka = {$zay},
                            `zayavka`.team{$team} = '".implode(";",$z[$zay]['team'.$team])."".$id.";'
                        WHERE
                            `users`.id = {$id} AND
                            `users`.zayavka = 0 AND
                            `zayavka`.id = {$zay};
                        ")) { return "�� ������� ������ �� ���."; }
        }

        // �������� ������ ;)
        function delteam ( $team = 2, $id, $zay, $r ) {
            $z = $this->getlist($r,null,$zay);
            //$z[$zay]['team'.$team][]='';
            //$z[$zay]['']
            //$teams = str_replace(";".$id.";","",";".implode(";",$z[$zay]['team'.$team]));
            //$teams = str_replace(";".$id.";","",";".implode(";",$z[$zay]['team'.$team]));
            if($z[$zay]['level'] > 3 OR $z[$zay]['level'] == null)
            {
                return "��-��-��!";
            }

            foreach($z[$zay]['team'.$team] as $v) {
                if  ($v != $id) {
                    $teams[] = $v;
                }
            }


            if(mysql_query("UPDATE `users`, `zayavka` SET
                                `users`.zayavka = '',
                                `zayavka`.team{$team} = '{$teams}'
                            WHERE
                                `users`.id = {$id} AND
                                `zayavka`.id = {$zay};"))
            {
                return "�� �������� ������";
            }
        }

        // ������ ������
        function addzayavka ( $start = 10, $timeout = 3, $t1c, $t2c, $type, $t1min, $t2min, $t1max, $t2max, $coment, $creator, $level = 1, $stavka, $blood=0, $closed=0) {
            global $user;
            if ((int)$level<1 || (int)$level>5) return "������...";
            if ($level==1 && ($type!=1 && $type!=4)) $type=1;
            if ($level==2 && ($type!=1 && $type!=4 && $type!=6)) $type=1;
            if ($level==4 && ($type!=2 && $type!=4)) $type=2;
            if ($level==5 && ($type!=3 && $type!=5)) $type=3;

            if ($start == 5 OR $start == 10 OR $start == 15 OR $start == 30 OR $start == 45 OR $start == 60) {
            } else { $start = 10; }

            if($timeout==1 || $timeout==3 || $timeout==4 || $timeout==5 || $timeout==7 || $timeout==10) {
            } else { $timeout = 3; }

            // ����� ������ ������
            if ( $this->ustatus($creator) != 0) { exit;}
            $owntravma = mysql_fetch_array(mysql_query("SELECT `type`,`id`,`sila`,`lovk`,`inta` FROM `effects` WHERE `owner` = ".$creator." AND (type=12 OR type=13 OR type=14);"));
            if ($owntravma) {
                switch($owntravma['type']) {
                    case ($owntravma['type']==12 && ($type!=4 AND $type!=5)):
                        return "� ��� ������� ������, �������� � ������� ������� ������ ��� ���...";
                    break;
                    case 13:
                        return "� ��� ������� ������, �� �� ������� �������...";
                    break;
                    case 14:
                        return "� ��� ������� ������, �� �� ������� �������...";
                    break;
                }

            }
            if (!$user['klan'] && $t1min == 99) {
                return "�� �� �������� � �����.";
            }
            // ��
            //$user = mysql_fetch_array(mysql_query("SELECT `hp`,`maxhp` FROM `users` WHERE `id` = '{$creator}' LIMIT 1;"));
            if ($user['hp'] < $user['maxhp']*0.33) {
                return "�� ������� ��������� ��� ���, ��������������.";
            }
            $start = time()+$start*60;
            $stavka = round($stavka,2);
            mysql_query("INSERT INTO `zayavka`
                (`start`, `timeout`, `t1c`, `t2c`, `type`, `level`, `coment`, `team1`, `stavka`, `t1min`, `t2min`, `t1max`, `t2max`,`podan`,`blood`, closed) values
                ({$start},{$timeout},{$t1c},{$t2c},{$type},{$level},'{$coment}','{$creator};','{$stavka}',{$t1min}, {$t2min}, {$t1max}, {$t2max}, '".date("H:i")."', '{$blood}', '$closed');");
            mysql_query("UPDATE `users` SET `zayavka` = ".mysql_insert_id()." WHERE `id` = {$creator};");
        }

        // ����� ������
        function delzayavka ($id, $zay,$r,$f=1) {
            $z = $this->getlist($r,null,$zay);
            if($f!=1) {
                if ($z[$zay]['level'] > 3) {
                    return '��-��-��!';
                }
            }
            if (mysql_query("DELETE FROM `zayavka` WHERE `id` = {$zay} AND `team1` LIKE '{$id};%';")) {
                if(count($z[$zay]['team1'])>0)
                foreach ($z[$zay]['team1'] as $k => $v) {
                    mysql_query("UPDATE `users` SET `zayavka` = 0 WHERE `id` = {$v} LIMIT 1;");
                }
                if(count($z[$zay]['team2'])>0)
                foreach ($z[$zay]['team2'] as $k => $v) {
                    mysql_query("UPDATE `users` SET `zayavka` = 0 WHERE `id` = {$v} LIMIT 1;");
                }
                return '�� �������� ������.';
            }
        }

        // �������� ���������� ������
        function showfiz ( $row ) {
            global $user;
            $rr = "<INPUT TYPE=radio ".((in_array($user['id'],$row['team1']) OR in_array($user['id'],$row['team2']) OR $row['team2'])?"disabled ":"")." NAME='gocombat' value={$row['id']}><font class=date>{$row['podan']}</font> ";
            foreach( $row['team1'] as $k=>$v ) {
                    $rr .= nick3($v);
            }
            if($row['team2']) {
                $rr .= " <i>������</i> ";
                foreach( $row['team2'] as $k=>$v ) {
                    $rr .= nick3($v);
                }
            }
            $rr .= "&nbsp; ��� ���: ";
            if ($row['type'] == 4) {
                $rr .= "<IMG SRC=\"".IMGBASE."/i/fighttype4.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ���\"> ";
            }
            elseif ($row['type'] == 6) {
                $rr .= "<IMG SRC=\"".IMGBASE."/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ���\"> ";
            }
            elseif ($row['type'] == 1) {
                $rr .= "<IMG SRC=\"".IMGBASE."/i/fighttype1.gif\" WIDTH=20 HEIGHT=20 ALT=\"���������� ���\"> ";
            }
            $rr .= " (������� {$row['timeout']} ���.) <BR>";
            return $rr;
        }

        // �������� ��������� ������
        function showgroup ( $row ) {
            if($row['t1min']==99) {
                $range1 = "<i>����</i>";
            }
            else {
                $range1 = "{$row['t1min']}-{$row['t1max']}";
            }
            if($row['t2min']==99) {
                $range2 = "<i>����</i>";
            }
            else {
                $range2 = "{$row['t2min']}-{$row['t2max']}";
            }
            $rr = "<INPUT TYPE=radio ".((in_array($user['id'],$row['team1']) OR in_array($user['id'],$row['team2']))?"disabled ":"")." NAME=gocombat value={$row['id']}><font class=date>{$row['podan']}</font> <b>{$row['t1c']}</b>({$range1}) (";
            foreach( $row['team1'] as $k=>$v ) {
                    if ($k!=0) $rr.=", ";
                    $rr .= nick3($v);
            }
            $rr .= ") <i>������</i> <b>{$row['t2c']}</b>({$range2})(";
            foreach( $row['team2'] as $k=>$v ) {
                if ($k!=0) $rr.=", ";
                $rr .= nick3($v);
            }
            if (count($row['team2']) ==0) { $rr.= "<i>������ �� �������</i>"; }

            if ($row['blood'] && $row['type'] == 5) {
                $rr .= "<IMG SRC=\"".IMGBASE."/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"\">";
            }
            $ali = mysql_fetch_array(mysql_query("SELECT align FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
            $rr .= ")&nbsp; ��� ���: ";
            if ($row['blood'] && $row['type'] == 4) {
                $rr .= "<IMG SRC=\"".IMGBASE."/i/fighttype4.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ���\"><IMG SRC=\"".IMGBASE."/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������\">";
            }
            elseif ($row['blood'] && $row['type'] == 2) {
                $rr .= "<IMG SRC=\"".IMGBASE."/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������\">";
            }
            elseif ($row['type'] == 2) {
                $rr .= "<IMG SRC=\"".IMGBASE."/i/fighttype2.gif\" WIDTH=20 HEIGHT=20 ALT=\"��������� ���\">";
            }
            elseif ($row['type'] == 4) {
                $rr .= "<IMG SRC=\"".IMGBASE."/i/fighttype4.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������� ���\">";
            }
            $rr .= "(������� {$row['timeout']} ���.) <span style='color:gray;'><i >��� �������� ����� ".round(($row['start']-time())/60,1)." ���. ".(($row['coment'])?"(".$row['coment'].")":"")."</i></span>";


            if (($ali['align']>1.4 && $ali['align']<2) || ($ali['align']>2 && $ali['align']<3)) {
              $rr .= "<a href='?zid={$row['id']}&do=clear'><img src='".IMGBASE."/i/clear.gif'></a><BR>";
            } else {
              $rr .= "<BR>";
            }

            return $rr;
        }

        // �������� ����������� ������
        function showhaos ($row, $radio=1) {
            if ($radio) $rr="<INPUT TYPE=radio ".((in_array($user['id'],$row['team1']) OR in_array($user['id'],$row['team2']))?"disabled ":"")." NAME=gocombat value={$row['id']}>";
            else $rr="";
            $rr.="<font class=date>{$row['podan']}</font> (";
            foreach( $row['team1'] as $k=>$v ) {
                    if ($k!=0) $rr.=", ";
                    $rr .= nick3($v);
            }
            $rr .= "";
            if (count($row['team1']) ==0) { $rr.= "<i>������ �� �������</i>"; }

            $ali = mysql_fetch_array(mysql_query("SELECT align FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));

            $rr .= ") (".($row["t1max"]==99?"����� ��������� ���":"$row[t1min]-$row[t1max]").") &nbsp; ��� ���: ";
            if ($row['blood'] && $row['type'] == 5) {
                $rr .= "<IMG SRC=\"".IMGBASE."/i/fighttype5.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ���\"><IMG SRC=\"".IMGBASE."/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������\">";
            }
            elseif ($row['blood'] && $row['type'] == 3) {
                $rr .= "<IMG SRC=\"".IMGBASE."/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������\">";
            }
            elseif ($row['type'] == 3) {
                $rr .= "<IMG SRC=\"".IMGBASE."/i/fighttype3.gif\" WIDTH=20 HEIGHT=20 ALT=\"��������� ���\">";
            }
            elseif ($row['type'] == 5) {
                $rr .= "<IMG SRC=\"".IMGBASE."/i/fighttype5.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������� ���\">";
            }
            if ($row["closed"]) $rr.=" <img src=\"/i/sh/closesphere.gif\" title=\"�������� ���\"> ";
            $rr .= "(������� {$row['timeout']} ���.) <span style='color:gray;'><i >��� �������� ����� ".round(($row['start']-time())/60,1)." ���. ".(($row['coment'])?"(".$row['coment'].")":"")."</i></span>";
            if (($ali['align']>1.4 && $ali['align']<2) || ($ali['align']>2 && $ali['align']<3)) {
                $rr .= "<a href='?zid={$row['id']}&do=clear'><img src='".IMGBASE."/i/clear.gif'></a><BR>";
            } else {
                $rr .= "<BR>";
            }
            return $rr;
        }

        // user status
        function ustatus ( $id ) {
            $fict = mysql_fetch_array(mq("SELECT * FROM `zayavka`, `users` WHERE users.id =".$id." AND zayavka.id = users.zayavka LIMIT 1;"));
            //$fict1 = mysql_fetch_array(mysql_query("SELECT * FROM `zayavka` WHERE `team1` LIKE '{$id};%' OR `team1` LIKE '%;{$id};%' LIMIT 1;"));
            //$fict2 = mysql_fetch_array(mysql_query("SELECT * FROM `zayavka` WHERE `team2` LIKE '{$id};%' OR `team2` LIKE '%;{$id};%' LIMIT 1;"));

            $t1 = $this->fteam($fict['team1']);
            $t2 = $this->fteam($fict['team2']);

            /*if($fict1) {
                $z = $fict1;
            } elseif(fict2) {
                $z = $fict2;
            } else {
                return 0;
            }
            //$t1 = $this->fteam($z['team1']); $t1 = (int)$t1[0];
            //$t1 = mysql_fetch_array(mysql_query("select * from `online` WHERE `date` >= ".(time()-120)." AND `id` = ".$t1.";"));
            //if(!$t1) {
                $teams = str_replace($id.";","",implode(";",$z['team2']));
                if(mysql_query("UPDATE `users` as u, `zayavka` as z SET
                                u.zayavka = '',
                                z.team2 = '{$teams}'
                            WHERE
                                u.id = {$id} AND
                                z.id = {$zay} AND `level` < 4;"))
                {
                    return "��������� ���� � ������";
                }
                return 0;
            }*/
            if(in_array($id,$t1)) { return 1; }
            elseif(in_array($id,$t2)) { return 2; }
            else { return 0; }
        }

        // ���������� ���!
        function battlestart ( $id, $zay, $r) {
          global $user;
            $z = $this->getlist($r,null,$zay);
            if ($id == 'CHAOS') { $id =  $z[$zay]['team1'][0]; }

            //if ($_SERVER["REMOTE_ADDR"]!="127.0.0.1") 
            $this->delzayavka ($id, $zay, $r);

            $z = $z[$zay];
            // ������� ����, ���� �������
            if ($z['type'] == 4 OR $z['type'] == 5) {
                foreach($z['team1'] as $k=>$v) {
                    undressall($v);
                }
                foreach($z['team2'] as $k=>$v) {
                    undressall($v);
                }
            }
            if ($z['level']==2) {
                $btfl=fopen('tmp/'.$z['team1'][0].'.btl','a');
                fwrite($btfl,'{[='.$z['team2'][0].'=]}');
                fclose($btfl);
                $btfl=fopen('tmp/'.$z['team2'][0].'.btl','a');
                fwrite($btfl,'{[='.$z['team1'][0].'=]}');
                fclose($btfl);
                }
            // ������� ����
            if ($z['type'] == 3 OR $z['type'] == 5) {
                if(count($z['team1']) < 1) {
                    mysql_query("UPDATE `users` SET `zayavka`=0 WHERE `zayavka` = '".$zay."';");
                    foreach($z['team1'] as $k=>$v) {
                        addchp ('<font color=red>��������!</font> ��� ��� �� ����� �������� �� ������� "������ �� �������".   ','{[]}'.nick7 ($v).'{[]}');
                    }
                    mysql_query("DELETE FROM `zayavka` WHERE `id`= '".$zay."';");
                    header("Location: zayavka.php");
                    die();
                }

                if ($z["t1max"]==99) $z["type"]=12;

                $all = count($z['team1'])-1;
                $power1 = 0; $power2 = 0;
                // ��������� �������
                define("CHAOSDEBUG",0);

                function findstrongest($fighters) {
                  $i=0;
                  $maxval=0;
                  $ret=0;
                  foreach ($fighters as $k=>$v) {
                    if ($v[1]>$maxval) {
                      $ret=$k;
                      $maxval=$v[1];
                    }
                  }
                  if (CHAOSDEBUG) echo "Found: $maxval ($ret)<br>";
                  return $ret;
                }
                $mages=array();
                $fighters=array();
                mq("insert into chaosstats set minlevel='$z[t1min]', maxlevel='$z[t1max]', members='$all', dat=date_add(now(), interval 2 hour)");
                for($i=0;$i<=$all;$i++) {
                    $gamer = playervalue($z['team1'][$i]);
                    if ($gamer["mage"]) $mages[]=array($z['team1'][$i],$gamer["value"]);
                    else $fighters[]=array($z['team1'][$i],$gamer["value"]);
                    //$cost[] = array($z['team1'][$i],$gamer["value"]);
                }
                if (CHAOSDEBUG) echo "Starting: mages: ".count($mages).", Fighters: ".count($fighters)."<br>";
                //$z=array();
                $z['team1']=array();
                $z['team2']=array();
                $i0=0;
                $strongestfighter=0;
                while (count($mages)+count($fighters)>0) {
                  if ($teamvalue[0]<$teamvalue[1]) {
                    if (CHAOSDEBUG) echo "To team 1<br>";
                    if (count($fighters)==0) $mage=1;
                    elseif (count($mages)==0) $mage=0;
                    elseif ($magesin[0]<$magesin[1]) $mage=1;
                    elseif ($fightersin[0]<$fightersin[1]) $mage=0;
                    else {
                      $f=findstrongest($mages);
                      $f2=findstrongest($fighters);
                      if ($mages[$f][1]>$fighters[$f2][1]) $mage=1;
                      else $mage=0;
                    }
                    if (CHAOSDEBUG) {
                      if ($mage) echo "Adding mage<br>"; else echo "Adding fighter<br>";
                    }
                    if ($mage) {
                      $f=findstrongest($mages);
                      $z['team1'][]=$mages[$f][0];
                      $magesin[0]++;
                      $teamvalue[0]+=$mages[$f][1];
                      if (CHAOSDEBUG) echo "Added with value ".$mages[$f][1]."<br>";
                      unset($mages[$f]);
                    } else {
                      $f=findstrongest($fighters);
                      $z['team1'][]=$fighters[$f][0];
                      $fightersin[0]++;
                      $teamvalue[0]+=$fighters[$f][1];
                      if (CHAOSDEBUG) echo "Added with value ".$fighters[$f][1]."<br>";
                      if (!@$strongestfighter) $strongestfighter=$fighters[$f][0];
                      unset($fighters[$f]);
                    }
                  } else {
                    if (CHAOSDEBUG) echo "To team 2<br>";
                    if (count($fighters)==0) $mage=1;
                    elseif (count($mages)==0) $mage=0;
                    elseif ($magesin[0]>$magesin[1]) $mage=1;
                    elseif ($fightersin[0]>$fightersin[1]) $mage=0;
                    else {
                      $f=findstrongest($mages);
                      $f2=findstrongest($fighters);
                      if ($mages[$f][1]>$fighters[$f2][1]) $mage=1;
                      else $mage=0;
                    }
                    /*elseif ($magesin[0]==$magesin[1] && $magesin[0]+$magesin[1]<$fightersin[0]+$fightersin[1]-1) $mage=1;
                    else $mage=0;*/
                    if (CHAOSDEBUG) {
                      if ($mage) echo "Adding mage<br>"; else echo "Adding fighter<br>";
                    }
                    if ($mage) {
                      $f=findstrongest($mages);
                      $z['team2'][]=$mages[$f][0];
                      $magesin[1]++;
                      $teamvalue[1]+=$mages[$f][1];
                      if (CHAOSDEBUG) echo "Added with value ".$mages[$f][1]."<br>";
                      unset($mages[$f]);
                    } else {
                      $f=findstrongest($fighters);
                      $z['team2'][]=$fighters[$f][0];
                      $fightersin[1]++;
                      $teamvalue[1]+=$fighters[$f][1];
                      if (CHAOSDEBUG) echo "Added with value ".$fighters[$f][1]."<br>";
                      if (!@$strongestfighter) $strongestfighter=$fighters[$f][0];
                      unset($fighters[$f]);
                    }
                  }
                  if (CHAOSDEBUG) echo "Left: ".count($mages)." / ".count($fighters).", current: $magesin[0]/$magesin[1] $fightersin[0]/$fightersin[1] <b>$teamvalue[0]</b> / <b>$teamvalue[1]</b><br>";
                  $i0++;
                  if ($i0>100) break;
                }

                /*while($flag) {
                    $flag=false;
                    for($ii=0;$ii<=$all-1;$ii++){
                        if($cost[$ii][1] < $cost[$ii+1][1]) {
                            $ctr = $cost[$ii+1];
                            $cost[$ii+1] = $cost[$ii];
                            $cost[$ii] = $ctr;
                            $flag=true;
                        }
                    }
                }

                while (count($cost) > 0) {
                    if ($power1 <= $power2) {
                        $tmp = array_shift($cost);
                        //power++
                        $power1 += $tmp[1];
                        // to command
                        $z['team1'][] = $tmp[0];
                    } else {
                        $tmp = array_shift($cost);
                        //power++
                        $power2 += $tmp[1];
                        // to command
                        $z['team2'][] = $tmp[0];
                    }

                }*/
            }
            $bot=0; // ������� �� ����
            /*if (((count($z['team1'])>count($z['team2']) && count($z['team2'])>0) ||
                (count($z['team2'])>count($z['team1']) && count($z['team1'])>0)) && $strongestfighter) {
              $bot=createbot($strongestfighter, 0, "���������");
              if (count($z['team1'])>count($z['team2'])) $z["team2"][]=$bot["id"];
              else $z["team1"][]=$bot["id"];
            }*/

                // ��������� ���� ����
                $teams = array();
                foreach($z['team1'] as $k=>$v) {
                    foreach($z['team2'] as $kk => $vv) {
                        $teams[$v][$vv] = array(0,0,time());
                    }
                }
                foreach($z['team2'] as $k=>$v) {
                    foreach($z['team1'] as $kk => $vv) {
                        $teams[$v][$vv] = array(0,0,time());
                    }
                }

                if(count($z['team2']) ==0) {
                    mysql_query("UPDATE `users` SET `zayavka`=0 WHERE `zayavka` = '".$zay."';");
                    foreach($z['team1'] as $k=>$v) {
                        addchp ('<font color=red>��������!</font> ��� ��� �� ����� �������� �� ������� "������ �� �������".   ','{[]}'.nick7 ($v).'{[]}');
                    }
                    mysql_query("DELETE FROM `zayavka` WHERE `id`= '".$zay."';");
                    header("Location: zayavka.php");
                    die();
                }

            if($z["timeout"]==1 || $z['timeout']==3 || $z['timeout']==4 || $z['timeout']==5 || $z['timeout']==7 || $z['timeout']==10) {
            }   else {
                $z['timeout'] = 3;
            }
            //print_r($teams);
            if (count($teams)>1) {
                mysql_query("INSERT INTO `battle`
                        (
                            `id`,`coment`,`teams`,`timeout`,`type`,`status`,`t1`,`t2`,`to1`,`to2`,`blood`, closed, date
                        )
                        VALUES
                        (
                            NULL,'{$z['coment']}','".serialize($teams)."','{$z['timeout']}','{$z['type']}','0','".implode(";",$z['team1'])."','".implode(";",$z['team2'])."','".time()."','".time()."','".$z['blood']."','".$z['closed']."', '".date("Y-m-d H:i")."'
                        )");
                $id = mysql_insert_id();
                if ($bot) mq("update bots set battle='$id' where id='$bot[id]'");
                // ������� ���
                $rr = "<b>";
                foreach( $z['team1'] as $k=>$v ) {
                    if ($k!=0) { $rr.=", "; $rrc.=", "; }
                    $rr .= nick3($v);
                    $rrc .= nick7($v);
                    addchp ('<font color=red>��������!</font> ��� ��� �������!<BR>\'; top.frames[\'main\'].location=\'fbattle.php\'; var z = \'   ','{[]}'.nick7 ($v).'{[]}');
                }
                $rr .= "</b> � <b>"; $rrc .= "</b> � <b>";
                foreach( $z['team2'] as $k=>$v ) {
                    if ($k!=0) { $rr.=", "; $rrc.=", ";}
                    $rr .= nick3($v);
                    $rrc .= nick7($v);
                    addchp ('<font color=red>��������!</font> ��� ��� �������!<BR>\'; top.frames[\'main\'].location=\'fbattle.php\'; var z = \'   ','{[]}'.nick7 ($v).'{[]}');
                }
                $rr .= "</b>";
                addch ("<a href=logs.php?log=".$id." target=_blank>��������</a> ����� <B>".$rrc."</B> �������.   ",$user['room']);
                mysql_query("INSERT INTO `logs` (`id`,`log`) VALUES('{$id}','���� ���������� <span class=date>".date("Y.m.d H.i")."</span>, ����� ".$rr." ������� ����� ���� �����. <BR>');");

                addlog($id,"���� ���������� <span class=date>".date("Y.m.d H.i")."</span>, ����� ".$rr." ������� ����� ���� �����. <BR>");


                // ���� � ���!!!
                $cond="";
                foreach($z['team1'] as $k=>$v) {
                  if ($cond) $cond.=" or ";
                  $cond.=" id='$v' ";
                }
                foreach($z['team2'] as $k=>$v) {
                  $cond.=" or id='$v' ";
                }
                mq("UPDATE users SET `battle` ={$id},`zayavka`=0 WHERE $cond");
            }
            $b=mqfa1("select battle from users where id='$user[id]'");
            if ($b) die("<script>location.href='fbattle.php';</script>");
            ///=======================================================================================
        }
    }
    $zay = new zayavka;
    //$zay->addzayavka(15,3,2,2,2,7,7,7,7,'111',2,2,0);

    header("Cache-Control: no-cache");
    if ($_POST['open']) {
        //setcookie("botbattle",time());
        $f=fopen("tmp/zayavka/".$user['id'].".txt","w+");
        fputs($f,time());
        fclose($f);
    }
?>
<HTML>
    <HEAD>
        <link rel=stylesheet type="text/css" href="<?=IMGBASE?>/i/main.css">
        <meta content="text/html; charset=windows-1251" http-equiv=Content-type>
        <META Http-Equiv=Cache-Control Content=no-cache>
        <meta http-equiv=PRAGMA content=NO-CACHE>
        <META Http-Equiv=Expires Content=0>
        <style>
            .m {background: #99CCCC;text-align: center;}
            .s {background: #BBDDDD;text-align: center;}
        </style>
        <script>
            function refreshPeriodic()
            {
                <?if ($_REQUEST['logs'] == null) {?>location.href='zayavka.php?level=<?=$_REQUEST['level']?>&tklogs=<?=$_REQUEST['tklogs']?>&logs=<?=$_REQUEST['logs']?>';//reload();
                <?}?>
                timerID=setTimeout("refreshPeriodic()",30000);
            }
            timerID=setTimeout("refreshPeriodic()",30000);
        </script>
    </HEAD>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=e2e0e0 onload="<?=topsethp()?>">
<TABLE width=100% cellspacing=1 cellpadding=1>
<FORM METHOD=POST ACTION=zayavka.php name=F1>
<TR><TD colspan=5>
    <? if ($_REQUEST['level']) { nick($user); } ?>
</TD>
<TD colspan=4 align=right>

<INPUT TYPE=button value="����� �����" onclick="location.href='main.php?top=0.467837356797105';">
<INPUT TYPE=button value="���������" style="background-color:#A9AFC0" onclick="window.open('help/combats.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">
<INPUT TYPE=button value="���������" onclick="location.href='main.php?top=0.467837356797105';">
</TD></TR>
<TR>
<TD class=m width=40>&nbsp;<B>���:</B></TD>
<TD class=<?=($_REQUEST['level']=='begin')?"s":"m"?>><A HREF="zayavka.php?level=begin&0.467837356797105">1 �� 1</A></TD>
<TD class=<?=($_REQUEST['level']=='fiz')?"s":"m"?>><A HREF="zayavka.php?level=fiz&0.467837356797105">����������</A></TD>
<?
/*<TD class=<?=($_REQUEST['level']=='train')?"s":"m"?>><A HREF="zayavka.php?level=train&0.467837356797105&view=<?=$user['level']?>">�������������</A></TD>*/
?>
<TD class=<?=($_REQUEST['level']=='group')?"s":"m"?>><A HREF="zayavka.php?level=group&0.467837356797105">���������</A></TD>
<TD class=<?=($_REQUEST['level']=='haos')?"s":"m"?>><A HREF="zayavka.php?level=haos&0.467837356797105">���������</A></TD>
<TD class=<?=($_REQUEST['tklogs']=='1')?"s":"m"?>><A HREF="zayavka.php?tklogs=1&0.467837356797105">�������</A></TD>
<TD class=<?=($_REQUEST['logs']!=null)?"s":"m"?>><A HREF="zayavka.php?logs=<?=date("d.m.y")?>&0.467837356797105">�����������</A></TD>
</TR></TR></TABLE>
<TABLE width=100% cellspacing=0 cellpadding=0><TR><TD valign=top>
<?


if($user['room'] != 1 && $user['room'] != 5 && $user['room'] != 6 && $user['room'] != 7 && $user['room'] != 9 && $user['room'] != 10 && $user['room'] != 15 && $user['room'] != 16 && $user['room'] != 19 && $user['room'] != 8 && $user['room'] != 201  && $user['room'] != 0 && !$_REQUEST['tklogs'] && !$_REQUEST['logs']){
  if ($_REQUEST['level']=="haos") {
    echo "<br><br><center><b>� ���� ������� ����� ������ �������� ������� ������ �� ��������� ���</b></center><br>";
    if ($z = $zay->getlist(5,$_SESSION['view']))
    foreach ($z as $k=>$v) {
      echo $zay->showhaos($v, 0);
    }
  } else {
    echo "<BR><BR><BR><CENTER><B>� ���� ������� ���������� �������� ������</b></CENTER>";
  }
  die();
}

if(!$_REQUEST['level'] && !$_REQUEST['tklogs'] && !$_REQUEST['logs']){
    }




include "config/extrausers.php";
if (in_array($user["id"], $noattack)) {
  echo "<BR><BR><BR><CENTER><B>��� ��� ��� ���������</b></CENTER>";
  die();
}
if ($_REQUEST['level'] == 'begin') {
    if($user['level']>0 && $user["id"]<>99999) {
        echo "<BR><BR><BR><CENTER><B>�� ��� ������� �� ��������� ;)</b></CENTER>";
        die();
    }
    echo "<font color=red><b>";
    if($_POST['open']) {
        $r=$zay->addzayavka (0,$_POST['timeout'], 1, 1, $_POST['k'], $user['level'], 1, $user['level'], 21, '', $user['id'], 1, 0);
        if ($r) echo $r;
        else die("<script>document.location='zayavka.php?level=begin';</script>");
    }
    if($_POST['back']) {
        unlink("tmp/zayavka/".$user['id'].".txt");
        echo $zay->delzayavka ($user['id'], $user['zayavka'], 1,0);
    }
    if($_POST['back2']) {
        $z =  $zay->getlist(1,null,$user['zayavka']);
        addchp ('<font color=red>��������!</font> '.nick7($user['id']).' ������� ������.   ','{[]}'.nick7 ($z[$user['zayavka']]['team1'][0]).'{[]}');
        echo $zay->delteam (2,$user['id'], $user['zayavka'], 1);
    }
    if($_POST['cansel']) {
        $z =  $zay->getlist(1,null,$user['zayavka']);
        echo $zay->delteam (2,$z[$user['zayavka']]['team2'][0], $user['zayavka'], 1);
        addchp ('<font color=red>��������!</font> '.nick3($user['id']).' ��������� �� ��������.  ','{[]}'.nick7 ($z[$user['zayavka']]['team2'][0]).'{[]}');
    }
    if($_POST['confirm2']) {
        $z =  $zay->getlist(1,null,$_REQUEST['gocombat']);
        addchp ('<font color=red>��������!</font> '.nick3($user['id']).' ������ ������, ����� ������� ����� ��� ��������.  ','{[]}'.nick7 ($z[$_REQUEST['gocombat']]['team1'][0]).'{[]}');
        echo $zay->addteam (2,$user['id'], $_REQUEST['gocombat'], 1);
        die("<script>document.location='zayavka.php?level=begin';</script>");
    }
    if($_POST['gofi']) {
        $zay->battlestart( $user['id'], $user['zayavka'], 1 );
    }
    echo "</b></font>";

    echo '<table cellspacing=0 cellpadding=0><tr><td>';
    $z =  $zay->getlist(1,null,$user['zayavka']);
    if( $zay->ustatus($user['id'])==0 || $user["id"]==99999) {
        //if ($z[$user['zayavka']]['level'] == 1)
        echo '<FIELDSET><LEGEND><B>������ ������ �� ���</B> </LEGEND>������� <SELECT NAME=timeout><OPTION value=1>1 ���.<OPTION value=3>3 ���.<OPTION value=4>4 ���.<OPTION value=5>5 ���.<OPTION value=7>7 ���.<OPTION value=10 selected>10 ���.</SELECT> ��� ��� <SELECT NAME=k><OPTION value=1>� �������<OPTION value=4>��������</SELECT><INPUT TYPE=submit name=open value="������ ������">&nbsp;</FIELDSET>';
    }
    if( $zay->ustatus($user['id'])==1 ) {
        if(count($z[$user['zayavka']]['team2'])>0){
            echo "<B><font color=red>��������! ".nick3($z[$user['zayavka']]['team2'][0])." ������ ������ �� ���, ����� �������� ��� ������� �����.</font></b> <input type=submit value='�����!' name=gofi> <input type=submit value='��������' name=cansel>";
        }
        else {
            if ($z[$user['zayavka']]['level'] == 1)
            echo "������ �� ��� ������, ������� ����������. <input type=submit name=back value='�������� ������'>";
            /*if (file_exists("tmp/zayavka/".$user['id'].".txt")) {
            $Path="tmp/zayavka/".$user['id'].".txt";
            $f=fopen($Path,"r");
            $timeFigth=fread($f, filesize($f));
            fclose($f);*/
            //if($_COOKIE['botbattle']+300 < time() && $user['level'] == 0) {
            if($user['level'] == 0 || $_SESSION['uid']==99999) {

                if($_GET['trainstart']==1 && $user['hp'] > $user['maxhp']*0.33) {
                    //����� ������� ����
                    unlink("tmp/zayavka/".$user['id'].".txt");
                    $zay->delzayavka ($user['id'], $user['zayavka'], 1,0);
                    if ($user["id"]==99999) mysql_query("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('".$user['login']." (���� 1)','".$user['id']."','','".$user['maxhp']."');");
                    else mysql_query("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('����','11121','','50');");
                    $bot = mysql_insert_id();
                    $teams = array();

                    $teams[$user['id']][$bot] = array(0,0,time());
                    $teams[$bot][$user['id']] = array(0,0,time());
                    mysql_query("INSERT INTO `battle`
                        (
                            `id`,`coment`,`teams`,`timeout`,`type`,`status`,`t1`,`t2`,`to1`,`to2`,date
                        )
                        VALUES
                        (
                            NULL,'','".serialize($teams)."','3','1','0','".$user['id']."','".$bot."','".time()."','".time()."', '".date("Y-m-d H:i")."'
                        )");

                    $id = mysql_insert_id();

                    // �������� ����
                    mysql_query("UPDATE `bots` SET `battle` = {$id} WHERE `id` = {$bot} LIMIT 1;");

                    // ������� ���
                    $rr = "<b>".nick3($user['id'])."</b> � <b>".nick3($bot)."</b>";

                    //mysql_query("INSERT INTO `logs` (`id`,`log`) VALUES('{$id}','���� ���������� <span class=date>".date("Y.m.d H.i")."</span>, ����� ".$rr." ������� ����� ���� �����. <BR>');");
                    addlog($id,"���� ���������� <span class=date>".date("Y.m.d H.i")."</span>, ����� ".$rr." ������� ����� ���� �����. <BR>");

                    mysql_query("UPDATE users SET `battle` ={$id},`zayavka`=0 WHERE `id`= {$user['id']};");

                    addch ("������� <a href=logs.php?log=$id target=_blank>��������</a> ����� <B>$user[login]</B> � <b>$user[login] (���� 1)</b>.",$user['room']);
                    die("<script>location.href='fbattle.php';</script>");
                    ///=======================================================================================
                }
                //addchp ('<font color=red>��������!</font> ��� ������������ ������ ������������� ���.   ','{[]}'.$user['login'].'{[]}');
                echo " ��� <input type=button onclick=\"location.href='zayavka.php?level=begin&trainstart=1';\" value=\"������ ������������� ���\">.";

            }
        }
    }
    if( $zay->ustatus($user['id'])==2 ) {
        if ($z[$user['zayavka']]['level'] == 1)
        echo "������� ������������� ���. <input type=submit name=back2 value='�������� ������'>";
    }
    echo '</td></tr></table></TD><TD align=right valign=top rowspan=2><INPUT TYPE=submit name=tmp value="��������">';
    echo '<tr><td><INPUT TYPE=hidden name=level value=begin><INPUT TYPE=submit value="������� �����" NAME=confirm2><BR>';
    if ($z = $zay->getlist(1))
    foreach ($z as $k=>$v) {
        echo $zay->showfiz( $v );
    }
    echo '<INPUT TYPE=submit value="������� �����" NAME=confirm2></TD></TR></TABLE>';
}

if ($_REQUEST['level'] == 'fiz') {
    if($user['level']==0) {
        echo "<BR><BR><BR><CENTER><B>���������� ��� �������� � 1 ������.</b></CENTER>";
        die();
    }
//  if($user['level']>3 && $user['id']!=9534 && $user['id']!=9577 && $user['id']!=2) {//&& $user['id']!=7200
//      echo "<BR><BR><BR><CENTER><B>���������� ��� �������� �� �������� ��� ���������� ���� 3�� ������.</b></CENTER>";
//      die();
//  }
    echo "<font color=red><b>";
        if($_POST['open']) {
        if($_POST['k']==6) {
            $blood = 1;
        } else {
            $blood = 0;
        }
        $err=$zay->addzayavka (0,$_POST['timeout'], 1, 1, $_POST['k'], $user['level'], 1, $user['level'], 21, '', $user['id'], 2, 0,$blood);
        if (!$err) die("<script>document.location='zayavka.php?level=fiz';</script>");
        echo $err;
        //$z[$user['zayavka']]['level'] == 2;
    }
    if($_POST['back']) {
        unlink("tmp/zayavka/".$user['id'].".txt");
        echo $zay->delzayavka ($user['id'], $user['zayavka'], 2,0);
    }
    if($_POST['back2']) {
        $z =  $zay->getlist(2,null,$user['zayavka']);
        addchp ('<font color=red>��������!</font> '.nick3($user['id']).' ������� ������.   ','{[]}'.nick7 ($z[$user['zayavka']]['team1'][0]).'{[]}');
        echo $zay->delteam (2,$user['id'], $user['zayavka'], 2);
    }
    if($_POST['cansel']) {
        $z =  $zay->getlist(2,null,$user['zayavka']);
        echo $zay->delteam (2,$z[$user['zayavka']]['team2'][0], $user['zayavka'], 2);
        addchp ('<font color=red>��������!</font> '.nick3($user['id']).' ��������� �� ��������.  ','{[]}'.nick7 ($z[$user['zayavka']]['team2'][0]).'{[]}');
    }
    if($_POST['confirm2'] && !$user['zayavka']) {
        $z =  $zay->getlist(2,null,$_REQUEST['gocombat']);
        $toper = $z[$_REQUEST['gocombat']]['team1'][0];
        $toper = mysql_fetch_array(mysql_query("SELECT `klan` FROM `users` WHERE `id`='{$toper}' LIMIT 1;"));
        //echo $user['klan'] . " " . $toper['klan'];
        if($user['klan'] != $toper['klan'] OR $user['klan']==''){
            addchp ('<font color=red>��������!</font> '.nick3($user['id']).' ������ ������, ����� ������� ����� ��� ��������.  ','{[]}'.nick7 ($z[$_REQUEST['gocombat']]['team1'][0]).'{[]}');
        }
        echo $zay->addteam (2,$user['id'], $_REQUEST['gocombat'], 2);
        //die("<script>document.location='zayavka.php?level=fiz';</script>");
        echo "</b></font><BR>������� ������������� ���. <input type=submit name=back2 value='�������� ������'>";
    }
    if($_POST['gofi']) {
        $zay->battlestart( $user['id'], $user['zayavka'], 2 );
    }
    echo "</b></font>";
    echo '<table cellspacing=0 cellpadding=0><tr><td>';
    if( $zay->ustatus($user['id'])==0 ) {
        echo '<FIELDSET><LEGEND><B>������ ������ �� ���</B> </LEGEND>������� <SELECT NAME=timeout><OPTION value=1>1 ���.<OPTION value=3>3 ���.<OPTION value=4>4 ���.<OPTION value=5>5 ���.<OPTION value=7>7 ���.<OPTION value=10 selected>10 ���.</SELECT> ��� ��� <SELECT NAME=k><OPTION value=1>� �������<OPTION value=4>��������<OPTION value=6>��������</SELECT><INPUT TYPE=submit name=open value="������ ������">&nbsp;</FIELDSET>';
    }
    $z =  $zay->getlist(2,null,$user['zayavka']);
    if( $zay->ustatus($user['id'])==1 ) {
        if(count($z[$user['zayavka']]['team2'])>0){
            echo "<B><font color=red>��������! ".nick3($z[$user['zayavka']]['team2'][0])." ������ ������ �� ���, ����� �������� ��� ������� �����.</font></b> <input type=submit value='�����!' name=gofi> <input type=submit value='��������' name=cansel>";
        }
        else {
            if ($z[$user['zayavka']]['level'] == 2) {
            echo "������ �� ��� ������, ������� ����������. <input type=submit name=back value='�������� ������'>";
            $Path="tmp/zayavka/".$user['id'].".txt";
            $f=fopen($Path,"r");
            $timeFigth=fread($f, filesize($Path));
            fclose($f);
            if ($user["level"]==1 || $user["level"]==2 || $user["level"]==3  || $user["level"]==4  || $user["level"]==5  || $user["level"]==6 || $user["level"]==7 ) $timeFigth-=61;
            if ($timeFigth+60 < time() && $user['level'] <= 7) {
              $trainers[1]=array(1=>array("login"=>"���� �����", "id"=>"5080", "sila"=>5, "lovk"=>5, "inta"=>5, "vinos"=>7), 
              2=>array("login"=>"���������� �����", "id"=>"11122", "sila"=>8, "lovk"=>3, "inta"=>3, "vinos"=>8), 
              3=>array("login"=>"Michkey", "id"=>"11123", "sila"=>3, "lovk"=>10, "inta"=>3, "vinos"=>5), 
              4=>array("login"=>"Tarzan", "id"=>"11124", "sila"=>6, "lovk"=>3, "inta"=>9, "vinos"=>5));
              $trainers[2]=array(1=>array("login"=>"���� �������", "id"=>"11125", "sila"=>7, "lovk"=>7, "inta"=>7, "vinos"=>9), 
              2=>array("login"=>"��������� �����", "id"=>"11126", "sila"=>11, "lovk"=>6, "inta"=>6, "vinos"=>10), 
              3=>array("login"=>"���� ��������", "id"=>"11127", "sila"=>8, "lovk"=>13, "inta"=>3, "vinos"=>8), 
              4=>array("login"=>"������", "id"=>"11128", "sila"=>8, "lovk"=>5, "inta"=>12, "vinos"=>6));
              $trainers[3]=array(1=>array("login"=>"������� ���", "id"=>"11129", "sila"=>9, "lovk"=>10, "inta"=>10, "vinos"=>10), 
              2=>array("login"=>"������� ���", "id"=>"11130", "sila"=>18, "lovk"=>6, "inta"=>6, "vinos"=>15), 
              3=>array("login"=>"���� ���", "id"=>"11131", "sila"=>11, "lovk"=>20, "inta"=>4, "vinos"=>9), 
              4=>array("login"=>"�������� ���", "id"=>"11132", "sila"=>10, "lovk"=>5, "inta"=>19, "vinos"=>10));

                if(($_GET['trainstart']==1 || $_POST['trainstart']==1) && $user['hp'] > $user['maxhp']*0.33) {
                    unlink("tmp/zayavka/".$user['id'].".txt");
                    $zay->delzayavka ($user['id'], $user['zayavka'], 2,0);
                    if ($user["level"]==1 || $user["level"]==2 || $user["level"]==3 || $user["level"]==4 || $user["level"]==5 || $user["level"]==6) {
/*
                      $_POST["opponent"]=(int)$_POST["opponent"];
                      if ($_POST["opponent"]<1 || $_POST["opponent"]>4) $_POST["opponent"]=rand(1,4);
                      $b=mqfa1("select bots.battle from bots left join battle on bots.battle=battle.id where (prototype='".$trainers[$user["level"]][1]["id"]."' or prototype='".$trainers[$user["level"]][2]["id"]."' or prototype='".$trainers[$user["level"]][3]["id"]."' or prototype='".$trainers[$user["level"]][4]["id"]."') and battle.win=3");
                      if ($b) {
                        $bot=createbot($trainers[$user["level"]]["$_POST[opponent]"]["id"], $b);
                        $t=rand(1,2);
                        joinbattle($b, array(array("id"=>$user["id"], "team"=>$t), array("id"=>$bot["id"], "login"=>$bot["login"], "team"=>($t==1?"2":"1"))), 0);
                        $joined=1;
                      } else {
                        $opp=mqfa("select login, maxhp from users where id='".$trainers[$user["level"]]["$_POST[opponent]"]["id"]."'");
                        mq("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('$opp[login]','".$trainers[$user["level"]]["$_POST[opponent]"]["id"]."','','$opp[maxhp]');");
                        $bot=mysql_insert_id();
                      }
*/
                      mysql_query("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('".$user['login']." (���� 1)','".$user['id']."','','".$user['maxhp']."');");
                      $bot = mysql_insert_id();
                    }

 else {
                      mysql_query("INSERT INTO `bots` (`name`,`prototype`,`battle`,`hp`) values ('".$user['login']." (���� 1)','".$user['id']."','','".$user['maxhp']."');");
                      $bot = mysql_insert_id();
                    }
                    if (!$joined) {
                      $teams = array();
                      $teams[$user['id']][$bot] = array(0,0,time());
                      $teams[$bot][$user['id']] = array(0,0,time());

                      mysql_query("INSERT INTO `battle`
                          (
                              `id`,`coment`,`teams`,`timeout`,`type`,`status`,`t1`,`t2`,`to1`,`to2`,date
                          )
                          VALUES
                          (
                              NULL,'','".serialize($teams)."','".($user["level"]==1?"1":"3")."','1','0','".$user['id']."','".$bot."','".time()."','".time()."', '".date("Y-m-d H:i")."'
                          )");

                      $id = mysql_insert_id();

                      // �������� ����
                      mysql_query("UPDATE `bots` SET `battle` = {$id} WHERE `id` = {$bot} LIMIT 1;");

                      // ������� ���
                      $rr = "<b>".nick3($user['id'])."</b> � <b>".nick3($bot)."</b>";

                      //mysql_query("INSERT INTO `logs` (`id`,`log`) VALUES('{$id}','���� ���������� <span class=date>".date("Y.m.d H.i")."</span>, ����� ".$rr." ������� ����� ���� �����. <BR>');");
                      addlog($id,"���� ���������� <span class=date>".date("Y.m.d H.i")."</span>, ����� ".$rr." ������� ����� ���� �����. <BR>");


                      mysql_query("UPDATE users SET `battle` ={$id},`zayavka`=0 WHERE `id`= {$user['id']};");
                    }

                    die("<script>location.href='fbattle.php';</script>");
                    ///=======================================================================================
                }
                //addchp ('<font color=red>��������!</font> ��� ������������ ������ ������������� ���.   ','{[]}'.$user['login'].'{[]}');
                if ($user["level"]==1 || $user["level"]==2 || $user["level"]==3 || $user["level"]==4 || $user["level"]==5 || $user["level"]==6) {
/*
                  echo "
                  <input type=\"hidden\" name=\"trainstart\" value=\"0\">
                 
                  <table><tr><td><input checked id=\"trainer1\" value=\"1\" type=radio title=\"����� ������, ���� �����\" name=opponent value=1> 
                  <label for=\"trainer1\" title=\"����� ������, ���� �����\"><b>".$trainers[$user["level"]][1]["login"]."</b> [$user[level]]</label> <a target=\"_blank\" href=\"/inf.php?".$trainers[$user["level"]][1]["id"]."\"><img border=\"0\" src=\"".IMGBASE."/i/inf.gif\"></a>
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <table>
                  <tr><td>����</td><td>".$trainers[$user["level"]][1]["sila"]."</td></tr>
                  <tr><td>��������</td><td>".$trainers[$user["level"]][1]["lovk"]."</td></tr>
                  <tr><td>��������</td><td>".$trainers[$user["level"]][1]["inta"]."</td></tr>
                  <tr><td>������������</td><td>".$trainers[$user["level"]][1]["vinos"]."</td></tr>
                  <tr><td colspan=2>����������</td></tr>
                  </table>
                  </td><td>
                  <input id=\"trainer2\" type=radio name=opponent value=2> <label for=\"trainer2\"><b>".$trainers[$user["level"]][2]["login"]."</b> [$user[level]]</label> <a target=\"_blank\" href=\"/inf.php?".$trainers[$user["level"]][2]["id"]."\"><img border=\"0\" src=\"".IMGBASE."/i/inf.gif\"></a>
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <table>
                  <tr><td>����</td><td>".$trainers[$user["level"]][2]["sila"]."</td></tr>
                  <tr><td>��������</td><td>".$trainers[$user["level"]][2]["lovk"]."</td></tr>
                  <tr><td>��������</td><td>".$trainers[$user["level"]][2]["inta"]."</td></tr>
                  <tr><td>������������</td><td>".$trainers[$user["level"]][2]["vinos"]."</td></tr>
                  <tr><td colspan=2>������: 2 ����</td></tr>
                  </table>
                  </td><td>
                  <input id=\"trainer3\" type=radio name=opponent value=3> <label for=\"trainer3\"><b>".$trainers[$user["level"]][3]["login"]."</b> [$user[level]]</label> <a target=\"_blank\" href=\"/inf.php?".$trainers[$user["level"]][3]["id"]."\"><img border=\"0\" src=\"".IMGBASE."/i/inf.gif\"></a>
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <table>
                  <tr><td>����</td><td>".$trainers[$user["level"]][3]["sila"]."</td></tr>
                  <tr><td>��������</td><td>".$trainers[$user["level"]][3]["lovk"]."</td></tr>
                  <tr><td>��������</td><td>".$trainers[$user["level"]][3]["inta"]."</td></tr>
                  <tr><td>������������</td><td>".$trainers[$user["level"]][3]["vinos"]."</td></tr>
                  <tr><td colspan=2>������: 2 �������</td></tr>
                  </table>
                  </td><td>
                  <input id=\"trainer4\" type=radio name=opponent value=4> <label for=\"trainer4\"><b>".$trainers[$user["level"]][4]["login"]."</b> [$user[level]]</label> <a target=\"_blank\" href=\"/inf.php?".$trainers[$user["level"]][4]["id"]."\"><img border=\"0\" src=\"".IMGBASE."/i/inf.gif\"></a>
                  <table>
                  <tr><td>����</td><td>".$trainers[$user["level"]][4]["sila"]."</td></tr>
                  <tr><td>��������</td><td>".$trainers[$user["level"]][4]["lovk"]."</td></tr>
                  <tr><td>��������</td><td>".$trainers[$user["level"]][4]["inta"]."</td></tr>
                  <tr><td>������������</td><td>".$trainers[$user["level"]][4]["vinos"]."</td></tr>
                  <tr><td colspan=2>������: 2 ����</td></tr>
                  </table>
                  </td></tr></table>
                  <div style=\"padding-left:260px;padding-top:10px\">
                    <input onclick=\"document.F1.trainstart.value=1\" type=\"submit\" value=\"������ ������������� ���\">
                  </div>
                  ";
*/
                  echo " ��� <input type=button onclick=\"location.href='zayavka.php?level=fiz&trainstart=1';\" value=\"������ ������������� ���\">";
                } else {
                  echo " ��� <input type=button onclick=\"location.href='zayavka.php?level=fiz&trainstart=1';\" value=\"������ ������������� ���\">";
                }

            }elseif($user['level'] <= 10) {echo " <small>����� ������ ����� ������ ������ �� ������ ������ ��� � ������.</small>";}
            }
        }
    }
    if( $zay->ustatus($user['id'])==2 ) {
        if ($z[$user['zayavka']]['level'] == 2)
        echo "������� ������������� ���. <input type=submit name=back2 value='�������� ������'>";
    }
    echo '</td></tr></table></TD><TD align=right valign=top rowspan=2><INPUT TYPE=submit name=tmp value="��������"><BR><FIELDSET style="width:150px;"><LEGEND>���������� ������</LEGEND><table cellspacing=0 cellpadding=0 ><tr><td width=1%><input type=radio name=view value="'.$user['level'].'" '.(($_SESSION['view'] != null)?"checked":"").'></td><td>����� ������</td></tr><tr><td><input type=radio name=view value="" '.(($_SESSION['view'] == null)?"checked":"").'></td><td>���</td></tr></table></FIELDSET>';
    echo '<tr><td><INPUT TYPE=hidden name=level value=fiz><INPUT TYPE=submit value="������� �����" NAME=confirm2><BR>';
    if ($z = $zay->getlist(2,$_SESSION['view']))
    foreach ($z as $k=>$v) {
        echo $zay->showfiz( $v );
    }
    echo '<INPUT TYPE=submit value="������� �����" NAME=confirm2></TD></TR></TABLE>';
}

if ($_REQUEST['level'] == 'group') {
    if($user['level']<2) {
        echo "<BR><BR><BR><CENTER><B>��������� ��� �������� � 2 ������.</b></CENTER>";
        die();
    }

    if($_POST['open1'] && !$user['zayavka']) {
        echo '<TABLE><TR><TD>
            <H3>������ ������ �� ��������� ���</H3>
            ������ ��� ����� <SELECT NAME=startime>
            <option value=300>5 �����
            <option value=600>10 �����
            <option value=900 selected>15 �����
            <option value=1800>30 �����
            <option value=2700>45 �����
            <option value=3600>1 ���
            </SELECT>
            &nbsp;&nbsp;&nbsp;&nbsp;������� <SELECT NAME=timeout><OPTION value=1>1 ���.<OPTION value=3>3 ���.<OPTION value=4>4 ���.<OPTION value=5 selected>5 ���.<OPTION value=7>7 ���.<OPTION value=10>10 ���.</SELECT>
            <BR><BR>
            ���� ������� <INPUT TYPE=text NAME=nlogin1 size=3 maxlength=2> ������<BR>
            ������ ��������� &nbsp;&nbsp;<SELECT NAME=levellogin1>
            <option value=0>�����
            <option value=1>������ ����� � ����
            <option value=2>������ ���� ����� ������
            <option value=3>������ ����� ������
            <option value=4>�� ������ ���� ����� ��� �� �������
            <option value=5>�� ������ ���� ����� ��� �� �������
            <option value=6>��� ������� +/- 1
            <option value=99>��� ����
            </SELECT><BR><BR>
            ���������� &nbsp;&nbsp;<INPUT TYPE=text NAME=nlogin2 size=3 maxlength=2> ������<BR>
            ������ ����������� <SELECT NAME=levellogin2>
            <option value=0>�����
            <option value=1>������ ����� � ����
            <option value=2>������ ���� ����� ������
            <option value=3>������ ����� ������
            <option value=4>�� ������ ���� ����� ��� �� �������
            <option value=5>�� ������ ���� ����� ��� �� �������
            <option value=6>��� ������� +/- 1
            <option value=99>������ ����
            </SELECT><BR>
            <INPUT TYPE=checkbox NAME=k> �������� ���<BR>
            <INPUT TYPE=checkbox NAME=travma> ��� ��� ������ (<font class=dsc>����������� ������� �������� ������������</font>)<BR>
            ����������� � ��� <INPUT TYPE=text NAME=cmt maxlength=40 size=40>
            </TD></TR>
            <TR><TD align=center>
            <INPUT TYPE=submit value="������ ��������! :)" name=open>
            </TD></TR>
            </TABLE>
            </TD><TD align=right valign=top>
            <INPUT TYPE=submit value="���������">
            </TD></TR></TABLE><INPUT TYPE=hidden name=level value=group>';
            die();
    }

    if($_POST['goconfirm'] && !$user['zayavka']) {
        echo '<TABLE width=100%><TR><TD>';
        $z =  $zay->getlist(4,null,$_POST['gocombat']);
        echo "<B>������� ������ ���������� ���...</B><BR>��� �������� �����: ".round(($z[$_POST['gocombat']]['start']-time())/60,1)." ���.";
        echo '</TD><TD align=right><INPUT TYPE=submit value="���������"></TD></TR></TABLE><H3>�� ���� ������� ������ ���������?</H3>
                <TABLE align=center cellspacing=4 cellpadding=1><TR><TD bgcolor=99CCCC><B>������ 1:</B><BR>
                ������������ ���-��: '.$z[$_POST['gocombat']]['t1c'].'<BR>
                ����������� �� ������: '.($z[$_POST['gocombat']]['t1min']==99?'����':$z[$_POST['gocombat']]['t1min']." - ".$z[$_POST['gocombat']]['t1max']).'
                </TD><TD bgcolor=99CCCC><B>������ 2:</B><BR>
                ������������ ���-��: '.$z[$_POST['gocombat']]['t2c'].'<BR>
                ����������� �� ������: '.($z[$_POST['gocombat']]['t2min']==99?'����':$z[$_POST['gocombat']]['t2min']." - ".$z[$_POST['gocombat']]['t2max']).'
                </TD></TR><TR>
                <TD align=center>';
        foreach( $z[$_POST['gocombat']]['team1'] as $k=>$v ) {
                    if ($k!=0) $rr.="<BR>";
                    echo nick3($v);
        }
        echo '</TD><TD align=center>';
        foreach( $z[$_POST['gocombat']]['team2'] as $k=>$v ) {
                    if ($k!=0) $rr.="<BR>";
                    echo nick3($v);
        }
        echo '</TD></TR><TR><TD align=center><INPUT TYPE=submit name=confirm1 value="� �� ����!"></TD><TD align=center><INPUT TYPE=submit name=confirm2 value="� �� ����!"></TD></TR></TABLE>
                <INPUT TYPE=hidden name=gocombat value="'.$_POST['gocombat'].'"><INPUT TYPE=hidden name=level value=group>';
        die();
    }
    echo "<font color=red><b>";
    // in da battle
    if(($_POST['confirm1']) && $_POST['gocombat'] && !$user['zayavka']) {
        echo $zay->addteam (1,$user['id'], $_REQUEST['gocombat'], 4);
    }
    if(($_POST['confirm2']) && $_POST['gocombat'] && !$user['zayavka']) {
        echo $zay->addteam (2,$user['id'], $_REQUEST['gocombat'], 4);
    }
    /////////////////////////////////
    /////// ������ ���� ������ ///////
    /////////////////////////////////
    if($_POST['open'] && !$user['zayavka']) {
        //print_r($_REQUEST);
        switch($_POST['levellogin1']) {
            case 0 :
                $min1 = 2;
                $max1 = 21;
            break;
            case 1 :
                $min1 = 2;
                $max1 = $user['level'];
            break;
            case 2 :
                $min1 = 2;
                $max1 = $user['level']-1;
            break;
            case 3 :
                $min1 = $user['level'];
                $max1 = $user['level'];
            break;
            case 4 :
                $min1 = $user['level'];
                $max1 = $user['level']+1;
            break;
            case 5 :
                $min1 = $user['level']-1;
                $max1 = $user['level'];
            break;
            case 6 :
                $min1 = (int)$user['level']-1;
                $max1 = (int)$user['level']+1;
            break;
            // KLANNNNNNNNNNNNNN
            case 99 :
                $min1 = 99;
                $max1 = 99;
            break;
        }
        switch($_POST['levellogin2']) {
            case 0 :
                $min2 = 2;
                $max2 = 21;
            break;
            case 1 :
                $min2 = 2;
                $max2 = $user['level'];
            break;
            case 2 :
                $min2 = 2;
                $max2 = $user['level']-1;
            break;
            case 3 :
                $min2 = $user['level'];
                $max2 = $user['level'];
            break;
            case 4 :
                $min2 = $user['level'];
                $max2 = $user['level']+1;
            break;
            case 5 :
                $min2 = $user['level']-1;
                $max2 = $user['level'];
            break;
            case 6 :
                $min2 = (int)$user['level']-1;
                $max2 = (int)$user['level']+1;
            break;
            // KLANNNNNNNNNNNNNN
            case 99 :
                $min2 = 99;
                $max2 = 99;
            break;
        }
        if($_POST['k']) {
            $_POST['k'] = 4;
        } else {
            $_POST['k'] = 2;
        }
        if($_POST['travma']) {
            $blood = 1;
        } else {
            $blood = 0;
        }
        if ($_POST['nlogin1'] == 1 && $_POST['nlogin2'] == 1) {
        echo "�� ���� ���������� ��������� ��� � ���������� ��������";
        }
        else {
        echo $zay->addzayavka ($_POST['startime']/60,$_POST['timeout'], $_POST['nlogin1'], $_POST['nlogin2'], $_POST['k'], $min1, $min2, $max1, $max2, $_POST['cmt'], $user['id'], 4, 0, $blood);
        }
    }
    /////////////////////////////////
    echo "</font></b><INPUT TYPE=hidden name=level value=group>";
    echo '<table cellspacing=0 cellpadding=0><tr><td>';
    if( $zay->ustatus($user['id'])==0 ) {
        echo '<INPUT TYPE=hidden name=level value=group><INPUT TYPE=submit value="������ ����� ������" name=open1>';
    }
    if( $zay->ustatus($user['id'])!=0) {
        $z =  $zay->getlist(4,null,$user['zayavka']);
        if ($z[$user['zayavka']]['level'] == 4) {
            echo "<B>������� ������ ���������� ���...</B><BR>��� �������� �����: ".round(($z[$user['zayavka']]['start']-time())/60,1)." ���.";
        }
    }
    echo '</td></tr></table></TD><TD align=right valign=top rowspan=2><INPUT TYPE=submit name=tmp value="��������"><BR><FIELDSET style="width:150px;"><LEGEND>���������� ������</LEGEND><table cellspacing=0 cellpadding=0 ><tr><td width=1%><input type=radio name=view value="'.$user['level'].'" '.(($_SESSION['view'] != null)?"checked":"").'></td><td>����� ������</td></tr><tr><td><input type=radio name=view value="" '.(($_SESSION['view'] == null)?"checked":"").'></td><td>���</td></tr></table></FIELDSET>';
    echo '<tr><td width=85%>';
    echo '<BR><INPUT TYPE=submit value="������� ������� � ���������" NAME=goconfirm><BR>';
    if ($z = $zay->getlist(4,$_SESSION['view']))
    foreach ($z as $k=>$v) {
        if ((($z[$k]['start']-time()) < 0) OR (($z[$k]['t1c'] == count($z[$k]['team1'])) && ($z[$k]['t2c'] == count($z[$k]['team2'])))) {
            $zay->battlestart("CHAOS", $k, 4);
        }
        echo $zay->showgroup( $v );
    }
    echo '<INPUT TYPE=submit value="������� ������� � ���������" NAME=goconfirm></td></tr></table>';
}


if ($_REQUEST['level'] == 'haos') {
    if($user['level']<2 && !APR1) {
        echo "<BR><BR><BR><CENTER><B>��������� ��� �������� � 2 ������.</b></CENTER>";
        die();
    }
    echo "<font color=red><b>";
    if ($_POST['open'] && $_POST['levellogin1']==7) {
      $i=mqfa1("select id from zayavka where type='$_POST[k]' and t1max=99");
      if ($i) {
        $_POST['confirm2']=1;
        $_REQUEST['gocombat']=$i;
        unset($_POST['open']);
      }
    }
    if($_POST['open'] && !$user['zayavka']) {
        switch($_POST['levellogin1']) {
            case 0 :
                $min1 = 2;
                $max1 = 21;
            break;
            case 1 :
                $min1 = 2;
                $max1 = $user['level'];
            break;
            case 3 :
                $min1 = $user['level'];
                $max1 = $user['level'];
            break;
            case 4 :
                $min1 = 2;
                $max1 = $user['level']+1;
            break;
            case 5 :
                $min1 = ($user["level"]>2?$user['level']-1:$user["level"]);
                $max1 = 21;
            break;

            case 6 :
                $min1 = (int)$user['level']-1;
                $max1 = (int)$user['level']+1;
            break;
            case 7 :
                $min1 = 2;
                $max1 = 99;
            break;
        }
        //$_POST['k'] = 3;

        if($_POST['travma']) {
            $blood = 1;
        } else {
            $blood = 0;
        }
        $closed=(int)@$_POST["closed"];
        echo $zay->addzayavka ($_POST['startime2']/60,$_POST['timeout'], 99, 99, $_POST['k'], $min1, $min1, $max1, $max1, $_POST['cmt'], $user['id'], 5, 0, $blood, $closed);
    }
    if($_POST['confirm2'] && !$user['zayavka']) {
        echo $zay->addteam (1,$user['id'], $_REQUEST['gocombat'], 5);
    }

    echo "</b></font>";

    echo '<table cellspacing=0 cellpadding=0><tr><td>';
    if( $zay->ustatus($user['id'])==0 ) {
        echo '��������� ��� - ������������� ����������, ��� ������ ����������� �������������. ��� �� ��������, ���� ��������� ������ 4-� �������. <DIV id="dv2" style="display:"><A href="#" onclick="clearTimeout(timerID); dv1.style.display=\'\'; dv2.style.display=\'none\'; return false">������ ������ �� ��������� ���</A></DIV><DIV id="dv1" style="display: none"><FIELDSET><LEGEND><B>������ ������ �� ��������� ���</B> </LEGEND>������ ��� ����� <SELECT NAME=startime2><option value=300>5 �����<option value=600>10 �����<option value=900 selected>15 �����<option value=1800>30 �����<option value=2700>45 �����<option value=3600>1 ���</SELECT>&nbsp;&nbsp;&nbsp;&nbsp;������� <SELECT NAME=timeout><OPTION value=1>1 ���.<OPTION value=3 SELECTED>3 ���.<OPTION value=5>5 ���.<OPTION value=10>10 ���.</SELECT><BR>������ ������ &nbsp;&nbsp;<SELECT NAME=levellogin1>
        <option value=0>�����</option>
        <option value=1>������ ����� � ����</option>
        <!--<option value=2>������ ���� ����� ������-->
        <option value=3>������ ����� ������</option>
        <option value=4>�� ������ ���� ����� ��� �� �������</option>
        <option value=5>�� ������ ���� ����� ��� �� �������</option>
        <option value=6 selected>��� ������� +/- 1</option>
        <option value=7>����� ��������� ��� (����� �������)</option>
        </SELECT><BR><BR>��� ��� <SELECT NAME=k><OPTION value=3>� �������<OPTION value=5>��������</SELECT><BR><INPUT TYPE=checkbox NAME=travma> ��� ��� ������ (<font class=dsc>����������� ������� �������� ������������</font>)<BR>
        <INPUT TYPE=checkbox NAME=closed value=1> �������� ��� (<font class=dsc>� ���� ��� ������ ��������� ������ ���������</font>)<BR>

        <INPUT TYPE=submit name=open value="������ ������">&nbsp;<BR>����������� � ��� <INPUT TYPE=text NAME=cmt maxlength=40 size=40></FIELDSET><BR></DIV>';
    }
    if( $zay->ustatus($user['id'])!=0) {
        $z =  $zay->getlist(5,null,$user['zayavka']);
        if ($z[$user['zayavka']]['level'] == 5)
        echo "<B>������� ������ ���������� ���...</B><BR>��� �������� �����: ".round(($z[$user['zayavka']]['start']-time())/60,1)." ���.";
    }
    echo '</td></tr></table></TD><TD align=right valign=top rowspan=2><INPUT TYPE=submit name=tmp value="��������"><BR><FIELDSET style="width:150px;"><LEGEND>���������� ������</LEGEND><table cellspacing=0 cellpadding=0 ><tr><td width=1%><input type=radio name=view value="'.$user['level'].'" '.(($_SESSION['view'] != null)?"checked":"").'></td><td>����� ������</td></tr><tr><td><input type=radio name=view value="" '.(($_SESSION['view'] == null)?"checked":"").'></td><td>���</td></tr></table></FIELDSET>';
    echo '<tr><td width=85%><INPUT TYPE=hidden name=level value=haos><INPUT TYPE=submit value="������� ������� � ���������" NAME=confirm2><BR>';
    if ($z = $zay->getlist(5,$_SESSION['view']))
    foreach ($z as $k=>$v) {
        if (($z[$k]['start']-time()) < 0) {
            $zay->battlestart("CHAOS", $k, 5);
        }
        echo $zay->showhaos( $v );
    }
    echo '<INPUT TYPE=submit value="������� ������� � ���������" NAME=confirm2></TD></TR></TABLE>';
    //print_r($_POST);
}
// teku4ki
if ($_REQUEST['tklogs'] != null) {
$t1=floor(time()-900);

    $data = mysql_query("SELECT battle.*, date_format(`date`,'%d.%m.%Y %H:%i') as `date` FROM `battle` WHERE `win`='3' and `to1`>'".$t1."' and `to2`>'".$t1."' and teams<>'N;' ORDER by `date` ASC;");
    while($row = @mysql_fetch_array($data)) {
        echo "<span class=date>{$row['date']}</span>";
        if ($user['id'] == 99999) {
            echo $row['id'];    
        }
        $z = split(";",$row['t1']);
        foreach($z as $k=>$v) {
            if ($k > 0) {  echo ","; }
            nick2($v);
        }

        echo " <font color=red><b>������</b></font> ";
        $z = split(";",$row['t2']);
        foreach($z as $k=>$v) {
            if ($k > 0) {  echo ","; }
            nick2($v);
        }

        echo "<img src='".IMGBASE."/i/fighttype{$row['type']}.gif'> <a href='logs.php?log={$row['id']}' target=_blank>��</a><BR>";
    }
}
// zavershonki
if ($_REQUEST['logs'] != null) {
    echo '<TABLE width=100% cellspacing=0 cellpadding=0><TR>
            <TD valign=top>&nbsp;<A HREF="zayavka.php?logs='.
            date("d.m.y",mktime(0, 0, 0, substr($_REQUEST['logs'],3,2), substr($_REQUEST['logs'],0,2)-1, "20".substr($_REQUEST['logs'],6,2)))
            .'&filter='.(($_REQUEST['filter'])?$_REQUEST['filter']:$user['login']).'">� ���������� ����</A></TD>
            <TD valign=top align=center><H3>������ � ����������� ���� �� '.(($_REQUEST['logs']!=1)?"{$_REQUEST['logs']}":"".date("d.m.y")).'</H3></TD>
            <TD  valign=top align=right><A HREF="zayavka.php?logs='.
            date("d.m.y",mktime(0, 0, 0, substr($_REQUEST['logs'],3,2), substr($_REQUEST['logs'],0,2)+1, "20".substr($_REQUEST['logs'],6,2)))
            .'&filter='.(($_REQUEST['filter'])?$_REQUEST['filter']:$user['login']).'">��������� ���� �</A>&nbsp;</TD>
            </TR><TR><TD colspan=3 align=center>�������� ������ ��� ���������: <INPUT TYPE=text NAME=filter value="'.(($_REQUEST['filter'])?$_REQUEST['filter']:$user['login']).'"> �� <INPUT TYPE=text NAME=logs size=12 value="'.(($_REQUEST['logs']!=1)?"{$_REQUEST['logs']}":"".date("d.m.y")).'"> <INPUT TYPE=submit value="������!"></TD>
            </TR></TABLE>';

    $u = mysql_fetch_array(mysql_query("SELECT `id` FROM `users` WHERE `login` = '".(($_REQUEST['filter'])?"{$_REQUEST['filter']}":"{$user['login']}")."' LIMIT 1;"));
    $cond="";
    $r=mq("select battle from invisbattles where user='$u[id]'");
    while ($rec=mysql_fetch_assoc($r)) {
      $cond.=" id<>$rec[battle] and ";
    }
    $data = mq("SELECT * FROM `battle` WHERE $cond ((`t1` LIKE '%;{$u[0]};%' OR `t1` LIKE '{$u[0]}' OR `t1` LIKE '{$u[0]};%' OR `t1` LIKE '%;{$u[0]}') OR (`t2` LIKE '%;{$u[0]};%' OR `t2` LIKE '{$u[0]}' OR `t2` LIKE '{$u[0]};%' OR `t2` LIKE '%;{$u[0]}')) AND `date` LIKE '".(($_REQUEST['logs']!=1)?"20".substr($_REQUEST['logs'],6,2)."-".substr($_REQUEST['logs'],3,2)."-".substr($_REQUEST['logs'],0,2):"".date("Y-m-d"))." %' ORDER by `id` ASC;");
    while($row = @mysql_fetch_array($data)) {
        echo "<span class=date>{$row['date']}</span>";
        //$z = split(";",$row['t1']);
        /*foreach($z as $k=>$v) {
            if ($k > 0) {  echo ","; }
            nick2($v);
        }*/
        echo $row['t1hist'];
        if ($row['win'] == 1) { echo '<img src='.IMGBASE.'/i/flag.gif>'; }
        echo " ������ ";
        //$z = split(";",$row['t2']);
        /*foreach($z as $k=>$v) {
            if ($k > 0) {  echo ","; }
            nick2($v);
        }*/
        echo $row['t2hist'];
        if ($row['win'] == 2) { echo '<img src='.IMGBASE.'/i/flag.gif>'; }
        if ($row['type'] == 10) {
                $rr = "<IMG SRC=\"".IMGBASE."/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������\"> ";
            }
            elseif ($row['blood'] && ($row['type'] == 5 OR $row['type'] == 4)) {
                $rr = "<IMG SRC=\"".IMGBASE."/i/fighttype5.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ���\"><IMG SRC=\"".IMGBASE."/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������\"> ";
            }
            elseif ($row['blood'] && ($row['type'] == 2 OR $row['type'] == 3 OR $row['type'] == 6)) {
                $rr = "<IMG SRC=\"".IMGBASE."/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������\"> ";
            }
            elseif ($row['type'] == 5 OR $row['type'] == 4) {
                $rr = "<IMG SRC=\"".IMGBASE."/i/fighttype4.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ���\"> ";
            }
            elseif ($row['type'] == 3 OR $row['type'] == 2) {
                $rr = "<IMG SRC=\"".IMGBASE."/i/fighttype3.gif\" WIDTH=20 HEIGHT=20 ALT=\"��������� ���\"> ";
            }
            elseif ($row['type'] == 1) {
                $rr = "<IMG SRC=\"".IMGBASE."/i/fighttype1.gif\" WIDTH=20 HEIGHT=20 ALT=\"���������� ���\"> ";
            } echo $rr;
        echo " <a href='logs.php?log={$row['id']}' target=_blank>��</a><BR>";
        $i++;
    }
    if($i==0) {
        echo '<CENTER><BR><BR><B>� ���� ���� �� ���� ����, ��� ��, ��������� ����� ������� ������...</B><BR><BR><BR></CENTER>';
    }
    echo '<HR><BR>';
}



mysql_query("UNLOCK TABLES;");

?>
</FORM>
</BODY>
</HTML>

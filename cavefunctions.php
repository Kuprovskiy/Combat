<?php

    function addcaveeffect($name, $time, $ghp) {
        global $user;
        $instime=$time*60*60+time();
        $rec=mqfa("select id, time from effects WHERE owner=".$user['id']." and name='$name'");
        if (($rec["time"]-time())<$time*60*30) {
          if ($rec) mq("update effects set time='$instime' where id='$rec[id]'");
          else mq("insert into effects set name='$name', type=".CAVEEFFECT.", owner='$user[id]', time='$instime', ghp='$ghp'");
          resetmax($user["id"]);
          updeffects($user["id"]);
          return true;
        } else return false;
    }


    function temper() {
        global $user;
        if ($user["level"]<=8) $ghp=160;
        elseif ($user["level"]<=9) $ghp=180;
        elseif ($user["level"]<=10) $ghp=200;
        else $ghp=220;
        if (addcaveeffect("�������", 24, $ghp)) return "����� ������� � ������� �� ���������� ���� ������� �����.";
        else return "�� ����� �������� ������� �����, ���� �� �� ��������.";
    }
 
    function setCaveEffect() {
        global $user;
        $rand = mt_rand(0, (func_num_args() - 1));
        $type = func_get_arg($rand);
        $inUse  = mysql_result(mysql_query("SELECT COUNT(*) FROM effects WHERE owner = $user[id] AND type = $type"), 0, 0);
        if ($inUse) {
            if ($type == 9999) {
                $msg = '� ��� ��� ���� �������';
            }
            if ($type == 9994) {
                $msg = '� ��� ��� ���� ����������';
            }
            if ($type == 9992) {
                $msg = '� ��� ��� ���� ���������';
            }
            if ($type == 9993) {
                $msg = '� ��� ��� ���� �������������';
            }
            header("Location: " . $_SERVER['PHP_SELF'] . ($msg ? '?msg=' . $msg : '' ));
            exit;
        }
        $effect = mqfa("SELECT * FROM caveeffects WHERE type = $type ORDER BY RAND()") or die(mysql_error());
        mysql_query("
            INSERT INTO effects 
            SET
                type  = $effect[type],
                name  = '$effect[name]',
                time  = " . (time() + $effect['duration']) . ",
                sila  = $effect[sila], 
                lovk  = $effect[lovk], 
                inta  = $effect[inta], 
                vinos = $effect[vinos],
                ghp   = $effect[ghp],
                owner = $user[id],
                hprestore = hprestore + $effect[hprestore]
        ") or die(mysql_error());
        mysql_query("
            UPDATE users 
            SET 
                sila  = ($effect[sila] + sila), 
                lovk  = ($effect[lovk] + lovk), 
                inta  = ($effect[inta] + inta), 
                vinos = ($effect[vinos] + vinos),
                maxhp = ($effect[ghp] + maxhp)
            WHERE id = $user[id]
        ") or die(mysql_error());
        if ($effect['type'] == 9999 || $effect['type'] == 9994) {
            $strAction = '����������';
            $strItem   = ($effect['type'] == 9999) ? '��������' : '����' ;
        }
        if ($effect['type'] == 9992 || $effect['type'] == 9993) {
            $strAction = '��������';
            $strItem   = ($effect['type'] == 9992) ? '���������' : '�������������' ;
            $strItem  .= ' ������';
        }
        $msg = '�� ' . $strAction . ' ' . $strItem . ' "' . $effect['name'] . '"'; 
        addchp ('<font color=red>��������!</font> ' . $msg, '{[]}'.$user['login'].'{[]}');
        header("Location: " . $_SERVER['PHP_SELF'] . ($msg ? '?msg=' . $msg : '' ));
        exit;
    }
  
?>

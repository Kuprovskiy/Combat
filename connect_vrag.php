<php
if($vr_st['honorpoints'] == 0  && (int)date("H") >=12  && (int)date("H") <11){
mq("UPDATE `users` SET `honorpoints`=1 WHERE `id`='99' LIMIT 1;");
addch("<font color=red><b>��������!</b></font> �������� �� ����� ����� <b>����� ����</b>.");
}else{
mq("UPDATE `users` SET `honorpoints`=0 WHERE `id`='99' LIMIT 1;");
mq("DELETE `bots` WHERE `prototype`='99' LIMIT 1;");
addch("<font color=red><b>��������!</b></font> <b>����� ����</b> ������� �����!");
}
?>
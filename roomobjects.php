<?
  if ($user["room"]==1) {
    if (@$_GET["drink"]) {
      include_once("questfuncs.php");
      if ($user["level"]==0 || canmakequest(13)) {
        mq("update users set hp=maxhp where id='$user[id]'");
        $user["hp"]=$user["maxhp"];
        $report="<b><font color=red>���� ������� ������������ ����� � �� ����� ����� ���.</b></font>";
        if ($user["level"]>0) makequest(13);
      } else {
        $report="<b><font color=red>�� ����� ���� �� ���� ������� ������� �����, �� ���� �� ������.</b></font>";
      }
    }
    if (@$_GET["sit"]) {
      include_once("questfuncs.php");
      if ($user["level"]==0 || canmakequest(14)) {
        mq("update users set mana=maxmana where id='$user[id]'");
        $user["mana"]=$user["maxmana"];
        $report="��������� ����� � ������ � ������ � ���� ���� �������������.";
        if ($user["level"]>0) makequest(14);
      } else {
        $report="�� ����� �������� ������ ������� �����, ������ ���� ����� �� ���������������.";
      }
    }
  }
?>
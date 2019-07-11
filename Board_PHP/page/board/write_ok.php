<?php

include('../../db.php');
include('../../page/login/functions.php');
$date = date('Y-m-d');
$userpw = password_hash($_POST['pw'], PASSWORD_DEFAULT);
$username = $_SESSION['user']['username'];
if(isset($_POST['lockpost'])){
	$lo_post = '1';
}else{
	$lo_post = '0';
}

$sql = mq("insert into board(name,pw,title,content,date,lock_post) values('".$username."','".$userpw."','".$_POST['title']."','".$_POST['content']."','".$date."','".$lo_post."')"); ?>
<script type="text/javascript">alert("書き物完了しました.");</script>
<meta http-equiv="refresh" content="0 url=/board.php" />

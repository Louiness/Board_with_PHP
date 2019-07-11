<?php
include('../../db.php');

	$bno = $_POST['idx'];
	$userpw = password_hash($_POST['pw'], PASSWORD_DEFAULT);
	if(isset($_POST['lockpost'])){
	$lo_post = '1';
}else{
	$lo_post = '0';
}
	$sql = mq("update board set pw='".$userpw."',title='".$_POST['title']."',content='".$_POST['content']."',lock_post='".$lo_post."' where idx='".$bno."'");
echo "<script>alert('修正なりました.');</script>";
?>
<meta http-equiv="refresh" content="0 url=/board.php ?>">

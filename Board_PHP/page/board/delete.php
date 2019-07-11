<?php
	include "../../db.php";

	$bno = $_GET['idx'];
	$sql = mq("delete from board where idx='$bno';");
	echo "<script>alert('削除なりました.');</script>";
?>
<meta http-equiv="refresh" content="0 url=/board.php" />

<?php
	session_start();
	header('Content-Type: text/html; charset=utf-8'); // utf-8인코딩

	$board_db = new mysqli("localhost","root","","kks");
	$board_db->set_charset("utf8");

	function mq($sql)
	{
		global $board_db;
		return $board_db->query($sql);
	}
?>
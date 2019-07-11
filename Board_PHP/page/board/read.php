<?php include('../../db.php');?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>掲示板</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="/kks/assets/css/jquery-ui.css" />
		<link rel="stylesheet" href="/kks/assets/css/main.css" />
		<script type="text/javascript" src="/kks/assets/js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="/kks/assets/js/jquery-ui.js"></script>
		<script type="text/javascript" src="/kks/assets/js/common.js"></script>
	</head>
	<body>
	<!-- Header -->
		<header id="header">
			<div class="inner">
				<a href="/board.php" class="logo">Louiness</a>
				<nav id="nav">
					<a href="/board.php">Board</a>
					<?php  if (isset($_SESSION['user'])){?>
						<b style="color: white;"><?php echo $_SESSION['user']['username'];?></b>
					<?} else{?>
					<a href="index.php?logout='1'">LogOut</a>
				<?php }?>
				</nav>
			</div>
		</header>
		<a href="#menu" class="navPanelToggle"><span class="fa fa-bars"></span></a>
		<section id="main">
			<div class="inner">
	<?php
		$bno = $_GET['idx']; /* bno함수에 idx값을 받아와 넣음*/
		$hit = mysqli_fetch_array(mq("select * from board where idx ='".$bno."'"));
		$hit = $hit['hit'] + 1;
		$fet = mq("update board set hit = '".$hit."' where idx = '".$bno."'");
		$sql = mq("select * from board where idx='".$bno."'"); /* 받아온 idx값을 선택 */
		$board = $sql->fetch_array();
	?>
		<!-- 글 불러오기 -->
			<div id="board_read">
				<h2><?php echo $board['title']; ?></h2>
				<hr style="border: rgba(0,0,0,0.4) 1px dashed; margin: 15px; width: 100%;">
				<div id="user_info">
					<ul style="display: inline;">
		<li style="display: inline; float: right; padding-left: 10px; ">照会:<?php echo $board['hit'];?></li>
		<li style="display: inline-block; float: right; border-left: 1px; border-right: 1px solid black; border-left: 1px solid black; padding-right: 10px;"><?php echo $board['date'];?></li>
		<li style="display: inline; float: right; padding-right: 10px;"><strong style="color: rgb(0,0,0);"><?php echo $board['name']; ?></strong></li>
<!-- 			<div>
				파일 : <a href="../../upload/<?php echo $board['file'];?>" download><?php echo $board['file']; ?></a>
			</div> -->
			<div style="border-bottom: 1px; width: 100%;height: 10px;"></div>
			<div id="bo_content" style="height: 25em;">
				<?php echo nl2br("$board[content]"); ?>
			</div>
	<!-- 목록, 수정, 삭제 -->
	<div id="bo_ser">
		<ul style="display: inline; float: right;">
			<li style="display: inline;"><a href="/board.php">[目録で行く]</a></li>
			<li style="display: inline;"><a href="modify.php?idx=<?php echo $board['idx']; ?>">[修正]</a></li>
			<li style="display: inline;"><a href="delete.php?idx=<?php echo $board['idx']; ?>">[削除]</a></li>
		</ul>
	</div>

	<!--- 댓글 불러오기 -->
	<div class="reply_view" style="margin-top: 50px;">
	<h3>リプの目録</h3>
		<?php
			$sql3 = mq("select * from reply where con_num='".$bno."' order by idx desc");
			while($reply = $sql3->fetch_array()){
		?>
		<div class="dap_lo">
			<div><b><?php echo $reply['name'];?></b></div>
			<div class="dap_to comt_edit"><?php echo nl2br("$reply[content]"); ?></div>
			<div class="rep_me dap_to"><?php echo $reply['date']; ?></div>
			<!--
			<div class="rep_me rep_menu">
				<a class="dat_edit_bt" href="#">수정</a>
				<a class="dat_delete_bt" href="#">삭제</a>
			</div>
		-->
			<!-- 댓글 수정 폼 dialog -->
			<!--
 			<div class="dat_edit"type="hidden">
				<form method="post" action="rep_modify_ok.php">
					<input type="hidden" name="rno" value="<?php echo $reply['idx']; ?>" /><input type="hidden" name="b_no" value="<?php echo $bno; ?>">
					<input type="password" name="pw" class="dap_sm" placeholder="비밀번호" />
					<textarea name="content" class="dap_edit_t"><?php echo $reply['content']; ?></textarea>
					<input type="submit" value="수정하기" class="re_mo_bt">
				</form>
			</div>
		-->

			<!-- 댓글 삭제 비밀번호 확인 -->
			<!--
 			<div class="dat_delete" type="hidden">
				<form action="reply_delete.php" method="post">
					<input type="hidden" name="rno" value="<?php echo $reply['idx']; ?>" /><input type="hidden" name="b_no" value="<?php echo $bno; ?>">
			 		<p>비밀번호<input type="password" name="pw" /> <input type="submit" value="확인"></p>
				 </form>
			</div>
		-->
		</div>

	<?php } ?>

	<!--- 댓글 입력 폼 -->
	<div class="dap_ins">
		<form method="post" class="reply_form">
			<input type="hidden" name="bno" value="<?php echo $bno; ?>">
			<input type="text" name="dat_user" id="dat_user" size="15" placeholder="ID"style="height: 2em;">
			<input type="password" name="dat_pw" id="dat_pw" size="15" placeholder="暗証番号" style="height: 2em;">
			<div style="margin-top:10px; ">
				<textarea name="content" class="reply_content" id="re_content" style="width: 100%; resize: none;"></textarea>
				<button type="submit" id="rep_bt" class="re_bt">レスする</button>
			</div>
		</form>
	</div>
</div><!--- 댓글 불러오기 끝 -->
<div id="foot_box"></div>
</div>
</div>
</section>
		<!-- Footer -->
			<section id="footer">
				<div class="inner">
					Louiness &copy; 2018. 慶星大學校 ソフトウェア学科 キムグァンス
				</div>
			</section>

</body>
</html>

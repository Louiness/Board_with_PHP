<?php include('../../db.php'); ?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>書き物</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="/kks/assets/css/main.css" />
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
				<section>
					<h3>Form</h3>
					<form method="post" action="write_ok.php" enctype="multipart/form-data">
						<div class="row uniform 50%">
							<div class="Title" style="width: 100%;">
								<input type="text" name="title" id="title"style="width:65em;" value="" placeholder="題目をタイピングしてください" />
							</div>
							<div class="Username" style="width: 100%;">
								<textarea name="content" id="ucontent" placeholder="Enter your message" rows="10" required style="width: 65em;"></textarea>
							</div>
							<div id="in_pw" style="width: 100%;">
                        		<input type="password" name="pw" id="upw"  placeholder="暗証番号">
                    		</div>
							<div class="locking" style="width: 100%;">
								<input type="checkbox" id="lockpost" value="1" name="lockpost">
								<label for="lockpost">文ラック</label>
							</div>
							<div class="12u$" style="margin-bottom: 50px;">
								<ul class="actions">
									<li><input type="submit" value="작 성" class="special" /></li>
									<li><input type="reset" value="Reset" /></li>
								</ul>
							</div>
						</div>
					</form>
				</section>
			</div>
		</section>

		<footer id="footer">
			<div class="inner">
				Louiness &copy; 2018. 慶星大學校 ソフトウェア学科 キムグァンス
			</div>
		</footer>
		<!-- Scripts -->
		<script src="/kks/assets/js/jquery.min.js"></script>
		<script src="/kks/assets/js/skel.min.js"></script>
		<script src="/kks/assets/js/util.js"></script>
		<script src="/kks/assets/js/main.js"></script>
	</body>
</html>

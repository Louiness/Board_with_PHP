<?php
include('db.php');
include('page/login/functions.php');
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>掲示板</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="kks/assets/css/main.css" />
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
					<h3>自由掲示板</h3>
					<div class="table-wrapper">
						<table>
							<thead>
								<tr>
									<th width="8%">番号</th>
									<th width="54%" style="text-align: center;">題目</th>
									<th width="15%">作成者</th>
                	<th width="12%">作成日</th>
                	<th width="11%">照会数</th>
								</tr>
							</thead>
       		<?php
            	if(isset($_GET['page'])){
            		$page = $_GET['page'];
                }else{
                	$page = 1;
                }
                	$sql = mq("select * from board");
                  $row_num = mysqli_num_rows($sql); //게시판 총 레코드 수
                  	$list = 5; //한 페이지에 보여줄 개수
                  	$block_ct = 5; //블록당 보여줄 페이지 개수

                  	$block_num = ceil($page/$block_ct); // 현재 페이지 블록 구하기
                  	$block_start = (($block_num - 1) * $block_ct) + 1; // 블록의 시작번호

                    $block_end = $block_start + $block_ct - 1; //블록 마지막 번호
                  	$total_page = ceil($row_num / $list); // 페이징한 페이지 수 구하기
                  	if($block_end > $total_page) $block_end = $total_page;
                    //만약 블록의 마지박 번호가 페이지수보다 많다면 마지박번호는 페이지 수
                  	$total_block = ceil($total_page/$block_ct); //블럭 총 개수
                  	$start_num = ($page-1) * $list; //시작번호 (page-1)에서 $list를 곱한다.

                  	$sql2 = mq("select * from board order by idx desc limit $start_num, $list");
                  	while($board = $sql2->fetch_array()){
                  		$title=$board["title"];
                    	if(strlen($title)>30){
                      		$title=str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]);
                    	}
                    	$sql3 = mq("select * from reply where con_num='".$board['idx']."'");
                    	$rep_count = mysqli_num_rows($sql3);
            ?>
               				<tbody>
        						<tr>
          							<td width="70"><?php echo $board['idx']; ?></td>
          							<td width="500">
            <?php
              	$lockimg = "<img src='/kks/images/lock.png' alt='lock' title='lock' with='20' height='20' />";
             	if($board['lock_post']=="1"){ ?>
             		<a href='page/board/ck_read.php?idx=<?php echo $board["idx"];?>'><?php echo $title, $lockimg;
              	}else{
          	?>
        							<a href='page/board/read.php?idx=<?php echo $board["idx"]; ?>'><?php echo $title; }?><span class="re_ct">[<?php echo $rep_count;?>] </span></a></td>
          							<td width="120"><?php echo $board['name']; ?></td>
          							<td width="100"><?php echo $board['date']?></td>
          							<td width="100"><?php echo $board['hit']; ?></td>
        						</tr>
      						</tbody>
      	  <?php } ?>
						</table>
					    <div id="page_num" style="text-align: center; margin-bottom: 30px;">
        <?php
          	if($page <= 1){ //만약 page가 1보다 작거나 같다면
            	echo "<span class='fo_re'>最初 </span>"; //처음이라는 글자에 빨간색 표시
          	}else{
           		echo "<a href='?page=1'>最初 </a>"; //아니라면 처음글자에 1번페이지로 갈 수있게 링크
          	}
          	if($page <= 1) { //만약 page가 1보다 작거나 같다면 빈값

          	}else{
          		$pre = $page-1; //pre변수에 page-1을 해준다 만약 현재 페이지가 3인데 이전버튼을 누르면 2번페이지로 갈 수 있게 함
            	echo "<a href='?page=$pre'> 以前 </a>"; //이전글자에 pre변수를 링크한다. 이러면 이전버튼을 누를때마다 현재 페이지에서 -1하게 된다.
          	}
          	//for문 반복문을 사용하여, 초기값을 블록의 시작번호를 조건으로 블록시작번호가 마지박블록보다 작거나 같을 때까지 $i를 반복시킨다
          	for($i=$block_start; $i<=$block_end; $i++){
            	if($page == $i){ //만약 page가 $i와 같다면
              		echo "<span class='fo_re'> [$i] </span>"; //현재 페이지에 해당하는 번호에 굵은 빨간색을 적용한다
            	}else{
              		echo "<a href='?page=$i'> [$i] </a>"; //아니라면 $i
            	}
          	}
          	if($block_num >= $total_block){ //만약 현재 블록이 블록 총개수보다 크거나 같다면 빈 값

          	}else{
          	  	$next = $page + 1; //next변수에 page + 1을 해준다.
            	echo "<a href='?page=$next'> 次 </a>"; //다음글자에 next변수를 링크한다. 현재 4페이지에 있다면 +1하여 5페이지로 이동하게 된다.
          	}
          	if($page >= $total_page){ //만약 page가 페이지수보다 크거나 같다면
            	echo "<span class='fo_re'> 最後</span>"; //마지막 글자에 긁은 빨간색을 적용한다.
          	}else{
            	echo "<a href='?page=$total_page'> 最後</a>"; //아니라면 마지막글자에 total_page를 링크한다.
          	}
        ?>
              <a href="page/board/write.php" class="button alt" style="float: right;">書き物</a>
    					</div>
              <div style="width: 100px; float: left;"></div>
    					<form action="page/board/search_result.php" method="get" style="text-align: center;">
								<div class="select-wrapper" style="width:10%; display: inline; float: left; left: 220px;">
      						<select id="search" name="catgo">
        						<option value="title">題目</option>
        						<option value="name">作成者</option>
        						<option value="content">内容</option>
      						</select>
    						</div>
      					<input type="text" name="search" size="40" style="width: 40%; display: inline; float: left; margin-left: 230px;" required="required" />
								<button style="display: inline; float: left; margin-left: 10px;">検索</button>
    					</form>
					</div>
			</section>
		</div>
	</section>

	<!-- Footer -->
		<section id="footer">
			<div class="inner">
				Louiness &copy; 2018. 慶星大學校 ソフトウェア学科 キムグァンス
			</div>
		</section>
		<!-- Scripts -->
		<script src="/kks/assets/js/jquery.min.js"></script>
		<script src="/kks/assets/js/skel.min.js"></script>
		<script src="/kks/assets/js/util.js"></script>
		<script src="/kks/assets/js/main.js"></script>
	</body>
</html>

<?php
ini_set('display_errors', '0');
include "../../db.php";
include "../../functions.php";
?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>詮索結果</title>
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

    <!-- Banner -->
      <section id="main">
        <div class="inner">

<?php
  /* 검색 변수 */
  $catagory = $_GET['catgo'];
  $search_con = $_GET['search'];
?>
  <h1>'<?php echo $search_con; ?>'検索結果</h1>
    <table class="list-table">
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
          $sql2 = mq("select * from board where $catagory like '%$search_con%' order by idx desc");
          while($board = $sql2->fetch_array()){

          $title=$board["title"];
            if(strlen($title)>30)
              {
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
              if($board['lock_post']=="1")
              { ?><a href='/page/board/ck_read.php?idx=<?php echo $board["idx"];?>'><?php echo $title, $lockimg;
              }else{?>

        <?php
          $boardtime = $board['date']; //$boardtime변수에 board['date']값을 넣음
          $timenow = date("Y-m-d"); //$timenow변수에 현재 시간 Y-M-D를 넣음
          ?>

        <a href='/page/board/read.php?idx=<?php echo $board["idx"]; ?>'><span style="background:yellow;"><?php echo $title; }?></span><span class="re_ct">[<?php echo $rep_count;?>]</span></a></td>
          <td width="120"><?php echo $board['name']?></td>
          <td width="100"><?php echo $board['date']?></td>
          <td width="100"><?php echo $board['hit']; ?></td>

        </tr>
      </tbody>
      <?php } ?>
    </table>
    <div id="page_num" style="text-align: center; margin-bottom: 30px;">
          &nbsp;
    <a href="write.php" class="button alt" style="float: right;">書き物</a>
    </div>
              <div style="width: 100px; float: left;"></div>
              <form action="page/board/search_result.php" method="get" style="text-align: center;">
                <div class="select-wrapper" style="width:10%; display: inline; float: left; left: 220px;">
                  <select id="search" name="catgo" style="width: 150px;">
                    <option value="title">題目</option>
                    <option value="name">作成者</option>
                    <option value="content">内容</option>
                  </select>
                </div>
                <input type="text" name="search" size="40" style="width: 40%; display: inline; float: left; margin-left: 230px;" required="required" />
                <button style="display: inline; float: left; margin-left: 10px;">검색</button>
                <div style="width: 100px; float: right;"></div>
              </form>
</div>
</div>
</section>
</body>
</html>

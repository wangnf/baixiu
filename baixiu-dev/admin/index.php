<?php  
  require_once('../functions.php');
  xiu_get_current_user();

  //获取文章数量
  $page_count = xiu_fetch_one('SELECT COUNT(1) as num FROM posts;');
  //获取草稿数量
  $drafted_count = xiu_fetch_one("SELECT COUNT(1) as num FROM posts WHERE status = 'drafted';");
  //获取分类数量
  $categories_count = xiu_fetch_one('SELECT COUNT(1) as num FROM categories;');
  //获取评论数量
  $comments_count = xiu_fetch_one('SELECT COUNT(1) as num FROM comments;');
  //获取待审核数量
  $held_count = xiu_fetch_one("SELECT COUNT(1) as num FROM comments WHERE status = 'held';");

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
  <script src="/static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include 'inc/topbar.php'; ?>
    <div class="container-fluid">
      <div class="jumbotron text-center">
        <h1>One Belt, One Road</h1>
        <p>Thoughts, stories and ideas.</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.html" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item"><strong><?php echo $page_count['num']; ?></strong>篇文章（<strong><?php echo $drafted_count['num']; ?></strong>篇草稿）</li>
              <li class="list-group-item"><strong><?php echo $categories_count['num']; ?></strong>个分类</li>
              <li class="list-group-item"><strong><?php echo $comments_count['num']; ?></strong>条评论（<strong><?php echo $held_count['num']; ?></strong>条待审核）</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4">
          <canvas id="chart-area"></canvas>
        </div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>
  <?php $current_page = 'index'; ?>
  <?php include 'inc/sidebar.php'; ?>

  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="/static/assets/vendors/chart/Chart.js"></script>
  <script>
    window.onload = function() {
      var ctx = document.getElementById('chart-area').getContext('2d');
      window.myPie = new Chart(ctx, config);
    };

    var config = {
      type: 'pie',
      data: {
        datasets: [{
          data: [
            <?php echo $page_count['num']; ?>,
            <?php echo $categories_count['num']; ?>,
            <?php echo $comments_count['num']; ?>,
          ],
          backgroundColor: [
            'Red',
          'Orange',
          'Yellow',
          ]
        }],
        labels: [
          '文章',
          '分类',
          '评论',
        ]
      }
    };
  </script>
  <script>NProgress.done()</script>
</body>
</html>

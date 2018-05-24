<?php    

  //判断登录
  require_once('../functions.php');
  xiu_get_current_user();

  //处理分页参数
  $page = empty($_GET['page']) ? 1 : (int)$_GET['page'];

  $size = 20;

    //得到筛选参数
  $where = '1=1';
  $search = '';
  if(isset($_GET['c']) && $_GET['c'] != -1){ 
    $where .= ' and posts.category_id = ' . $_GET['c'];
    $search .= '&c='.$_GET['c'];
  }
   if(isset($_GET['s']) && $_GET['s'] != -1){ 
    $s = $_GET['s'];
    $where .= " and posts.status = '{$s}'";
    $search = '&s='.$_GET['s'];
  }

    //求出最大页码
  $total_count = (int)xiu_fetch_one("SELECT 
COUNT(1) as num
FROM posts
inner join categories on posts.category_id = categories.id
inner join users on posts.user_id = users.id
where {$where}")['num'];

  $total_page = (int)ceil($total_count / $size);

  if($page < 1){ 
    header('Location:/admin/posts.php?page=1'.$search);
  }

  if($page > $total_page){ 
    header('Location:/admin/posts.php?page='.$total_page.$search);
  }

  $offset = ($page - 1) * $size;


  //查询
  $posts = xiu_fetch_all("SELECT 
  posts.id,
  posts.title,
  posts.status,
  categories.name as category_name,
  users.nickname as user_name,
  posts.created
from posts
inner join categories on posts.category_id = categories.id
inner join users on posts.user_id = users.id
where {$where}
ORDER BY posts.created DESC
LIMIT {$offset}, {$size};");

  $category_name = xiu_fetch_all("select * from categories");


  //处理分页
  $versible = 5;

  $middle = ($versible - 1) / 2;

  $begin = $page - $middle;

  $end = $begin + $versible;

  //处理 开头
  if($begin < 1){ 
    $begin = 1;
    $end = $begin + $versible;
  }
  //处理最大分页
  if($end >  $total_page + 1){ 
    $end = $total_page + 1;
    $begin = $end - $versible;
    if($begin < 1){ 
      $begin = 1;
    }
  }


  //转化状态
  function xiu_change_status($status){ 

    $status_array = [
      'published' => '已发布',
      'drafted' => '草稿',
      'trashed' => '回收站'
    ];

    return isset($status_array[$status]) ? $status_array[$status] : '未知';
  }
  //转换时间
  function canvert_date($created){ 
    //获得时间戳 
    $timestamp = strtotime($created);
    //转换为固定格式
    return date('Y年m月d日<b\r>H:i:s', $timestamp);
  }

  // function canvert_id($id){  
  //   return xiu_fetch_one("SELECT name FROM categories WHERE id = {$id}")['name'];
  // }

  //   function canvert_user($id){  
  //   return xiu_fetch_one("SELECT nickname FROM users WHERE id = {$id}")['nickname'];
  // }

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
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
      <div class="page-title">
        <h1>所有文章</h1>
        <a href="post-add.html" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <select name="c" class="form-control input-sm">
            <option value="-1">所有分类</option>
            <?php foreach ($category_name as $value): ?>
              <option value="<?php echo $value['id']; ?>"
                <?php echo isset($_GET['c']) && $value['id'] === $_GET['c'] ? 'selected':'' ?>
                ><?php echo $value['name']; ?></option>
            <?php endforeach ?>
          </select>
          <select name="s" class="form-control input-sm">
            <option value="-1">所有状态</option>
            <option value="drafted" <?php echo isset($_GET['s']) && $_GET['s'] === 'drafted' ? 'selected':'' ?>>草稿</option>
            <option value="published" <?php echo isset($_GET['s']) && $_GET['s'] === 'published' ? 'selected':'' ?>>已发布</option>
            <option value="trashed" <?php echo isset($_GET['s']) && $_GET['s'] === 'trashed' ? 'selected':'' ?>>草稿箱</option>
          </select>
          <button class="btn btn-default btn-sm">筛选</button>
        </form>
        <ul class="pagination pagination-sm pull-right">
          <?php if ($page != 1): ?>
            <li><a href="?page=<?php echo $page-1 ?>">上一页</a></li>
          <?php endif ?>    
          <?php for($i = $begin; $i < $end; $i++): ?>
           <li <?php echo $i === $page?'class="active"':''; ?>><a href="?page=<?php echo $i; ?><?php echo $search; ?>"><?php echo $i; ?></a></li>
          <?php endfor ?>
          <?php if ($page != $total_page): ?>
             <li><a href="?page=<?php echo $page+1 ?>">下一页</a></li>
          <?php endif ?>
         
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($posts as $value): ?>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td><?php echo $value['title']; ?></td>
            <td><?php echo $value['user_name']; ?></td>
            <td><?php echo $value['category_name']; ?></td>
            <td class="text-center"><?php echo canvert_date($value['created']); ?></td>
            <td class="text-center"><?php echo xiu_change_status($value['status']); ?></td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
  
  <?php $current_page = 'xiu_posts'; ?>
  <?php include 'inc/sidebar.php'; ?>

  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>

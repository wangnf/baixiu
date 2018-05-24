<?php  

require_once('../functions.php');

xiu_get_current_user();

//更新用户信息
if(!empty($_GET['id'])){ 
  $current_edit_user = xiu_fetch_one('select * from users where id ='. $_GET['id']);
}

function update_user(){ 

  global $current_edit_user;

  if(empty($_POST['password'])){ 
    $GLOBALS['success'] = false;
    $GLOBALS['err_message'] = '请输入密码';
    return;
  }

  $edit_id = $current_edit_user['id'];
  $edit_email = $_POST['email']? $_POST['email'] : $current_edit_user['email'];
  $edit_slug = $_POST['slug']? $_POST['slug'] : $current_edit_user['slug'];
  $edit_nickname = $_POST['nickname']? $_POST['nickname'] : $current_edit_user['nickname'];

  $current_edit_user['email'] = $edit_email;
  $current_edit_user['slug'] = $edit_slug;
  $current_edit_user['nickname'] = $edit_nickname;



  if($_POST['password'] != $current_edit_user['password']){ 
    $GLOBALS['err_message'] = '密码错误';
    return;
  }

  $affected = xiu_inset("UPDATE users SET email = '{$edit_email}',slug = '{$edit_slug}',nickname = '{$edit_nickname}' WHERE id = {$edit_id};");
   $GLOBALS['success'] = $affected > 0;
   $GLOBALS['err_message'] = $affected<=0?'更新失败':'更新成功';

}

//添加用户
function add_user(){  

  if(empty($_POST['email']) || empty($_POST['slug']) || empty($_POST['nickname']) || empty($_POST['password'])){ 
    $GLOBALS['success'] = false;
    $GLOBALS['err_message'] = '请填写正确的表单内容';
    return;
  }

  $email = $_POST['email'];
  $slug = $_POST['slug'];
  $nickname = $_POST['nickname'];
  $password = $_POST['password'];

  $affected = xiu_inset("INSERT INTO users (slug,email,password,nickname,status) VALUES ('{$slug}','{$email}','{$password}','{$nickname}','activated');");

  $GLOBALS['success'] = $affected > 0;
  $GLOBALS['err_message'] = $affected<=0?'添加失败':'添加成功';

}

if($_SERVER['REQUEST_METHOD'] === 'POST'){ 

  if (empty($_GET['id'])) {
    add_user();
  } else {
    update_user();
  }

}


//查询
$users_message = xiu_fetch_all('SELECT * FROM users;');


?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Users &laquo; Admin</title>
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
        <h1>用户</h1>
      </div>
      <?php if (isset($err_message)): ?>
        <?php if ($success): ?>
          <div class="alert alert-success">
            <strong>成功！</strong><?php echo $err_message; ?>
          </div>

        <?php else: ?>
          <div class="alert alert-danger">
            <strong>错误！</strong><?php echo $err_message; ?>
          </div>  
        <?php endif ?>
      <?php endif ?>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <?php if (!empty($current_edit_user)): ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $current_edit_user['id']; ?>" method="post">
              <h2>更新用户</h2>
              <div class="form-group">
                <label for="email">邮箱</label>
                <input id="email" class="form-control" name="email" type="email" placeholder="邮箱" value="<?php echo $current_edit_user['email']; ?>">
              </div>
              <div class="form-group">
                <label for="slug">别名</label>
                <input id="slug" class="form-control" name="slug" type="text" placeholder="slug" value="<?php echo $current_edit_user['slug']; ?>">
                <p class="help-block">https://zce.me/author/<strong>slug</strong></p>
              </div>
              <div class="form-group">
                <label for="nickname">昵称</label>
                <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称" value="<?php echo $current_edit_user['nickname']; ?>">
              </div>
              <div class="form-group">
                <label for="password">密码</label>
                <input id="password" class="form-control" name="password" type="password" placeholder="密码">
              </div>
              <div class="form-group">
                <button class="btn btn-primary" type="submit">保存</button>
              </div>
            </form>
          <?php else: ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
              <h2>添加新用户</h2>
              <div class="form-group">
                <label for="email">邮箱</label>
                <input id="email" class="form-control" name="email" type="email" placeholder="邮箱">
              </div>
              <div class="form-group">
                <label for="slug">别名</label>
                <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
                <p class="help-block">https://zce.me/author/<strong>slug</strong></p>
              </div>
              <div class="form-group">
                <label for="nickname">昵称</label>
                <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称">
              </div>
              <div class="form-group">
                <label for="password">密码</label>
                <input id="password" class="form-control" name="password" type="text" placeholder="密码">
              </div>
              <div class="form-group">
                <button class="btn btn-primary" type="submit">添加</button>
              </div>
            </form>   
          <?php endif ?>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a id="delete_user" class="btn btn-danger btn-sm" href="/admin/users-del.php" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
             <tr>
              <th class="text-center" width="40"><input type="checkbox"></th>
              <th class="text-center" width="80">头像</th>
              <th>邮箱</th>
              <th>别名</th>
              <th>昵称</th>
              <th>状态</th>
              <th class="text-center" width="100">操作</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users_message as $value): ?>
              <tr>
                <td class="text-center"><input type="checkbox" data-id="<?php echo $value['id']; ?>"></td>
                <td class="text-center"><img class="avatar" src="<?php echo $value['avatar']; ?>"></td>
                <td><?php echo $value['email']; ?></td>
                <td><?php echo $value['slug']; ?></td>
                <td><?php echo $value['nickname']; ?></td>
                <td>激活</td>
                <td class="text-center">
                  <a href="/admin/users.php?id=<?php echo $value['id']; ?>" class="btn btn-default btn-xs">编辑</a>
                  <a href="/admin/users-del.php?id=<?php echo $value['id']; ?>" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php $current_page = 'users'; ?>
<?php include 'inc/sidebar.php'; ?>
<script src="/static/assets/vendors/jquery/jquery.js"></script>
<script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
<script>

  $(function($){  

  //获取批量删除按钮
  var $userDelete = $('#delete_user');
  //获取所有的输入框
  var $allInput = $('tbody input');
  //存储改变的input 身上的 自定义id
  var $arrInput = [];
  $allInput.on('change',function(){ 

    var $id = $(this).data('id');

    if($(this).prop('checked')){ 
      $arrInput.includes($id) || $arrInput.push($id);
    }else{   
      $arrInput.splice($arrInput.indexOf($id),1);
    }
    
    $arrInput.length ? $userDelete.fadeIn():$userDelete.fadeOut();

    $userDelete.prop('search','?id='+$arrInput);

  })

  var inputChecked = $('thead input');

  inputChecked.on('change',function(){  

    var $checked = $(this).prop('checked');

    $allInput.prop('checked',$checked).trigger('change');

  })



})

</script>
<script>NProgress.done()</script>
</body>
</html>

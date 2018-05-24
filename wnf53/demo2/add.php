<?php  

function add_user(){
    //验证非空
  if(empty($_POST['name'])){ 
    $GLOBALS['err_message'] = '请输入姓名';
    return;
  }
  if(!(isset($_POST['gender']) && $_POST['gender'] != -1)){ 
    $GLOBALS['err_message'] = '请选择性别';
    return;
  }

  if(empty($_POST['birthday'])){ 
    $GLOBALS['err_message'] = '请选择生日日期';
    return;
  }

  //取值

  if($_POST['name'] === ''){ 
    $GLOBALS['err_message'] = '请输入姓名';
    return;
  }

  if($_POST['birthday'] === ''){ 
    $GLOBALS['err_message'] = '请选择生日日期';
    return;
  }

  $name = $_POST['name'];
  $gender = $_POST['gender'];
  $birthday = $_POST['birthday'];

  var_dump($_FILES['avatar']);

  //验证上传的文件

  if(empty($_FILES['avatar'])){ 
    $GLOBALS['err_message'] = '请选择上传图片';
    return;
  }
  $ext = pathinfo($_FILES['avatar']['name'],PATHINFO_EXTENSION);

  $target_file = uniqid().'.'.$ext;
  if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
    $GLOBALS['err_message'] = '上传图片失败';
    return;     
  }

   $image_file = substr($target_file, 2);


  var_dump($name,$gender,$birthday,$image_file);
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
  add_user();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>XXX管理系统</title>
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <nav class="navbar navbar-expand navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">XXX管理系统</a>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.html">用户管理</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">商品管理</a>
      </li>
    </ul>
  </nav>
  <main class="container">
    <h1 class="heading">添加用户</h1>
    <p><?php echo $err_message; ?></p>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" autocomplete="off" enctype="multipart/form-data">
      <div class="form-group">
        <label for="avatar">头像</label>
        <input type="file" class="form-control" id="avatar" name="avatar">
      </div>
      <div class="form-group">
        <label for="name">姓名</label>
        <input type="text" class="form-control" id="name" name="name">
      </div>
      <div class="form-group">
        <label for="gender">性别</label>
        <select class="form-control" id="gender" name="gender">
          <option value="-1">请选择性别</option>
          <option value="1">男</option>
          <option value="0">女</option>
        </select>
      </div>
      <div class="form-group">
        <label for="birthday">生日</label>
        <input type="date" class="form-control" id="birthday" name="birthday">
      </div>
      <button class="btn btn-primary">保存</button>
    </form>
  </main>
</body>
</html>

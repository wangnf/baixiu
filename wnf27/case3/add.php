<?php 

function add_music(){ 

  //---------校验文本框的信息---------------------

  if(empty($_POST['title'])){ 
    $GLOBALS['error_message'] = '请输入标题名称';
    return;
  }

  if(empty($_POST['sing'])){ 
    $GLOBALS['error_message'] = '请输入歌手名称';
    return;
  }

  //---------校验上传文件------------------

  if(empty($_FILES['song'])){ 
    //判断客户端提交表单中没有song这个文件域
    $GLOBALS['error_message'] = '请正确提交文件';
    return;
  }

  $song = $_FILES['song'];


  //判断用户是否选择文件
  if($song['error'] != UPLOAD_ERR_OK){ 
    $GLOBALS['error_message'] = '请选择音乐文件';
    return;
  }

  //校验文件的大小

  if($song['size'] > 10*1024*1024){
    $GLOBALS['error_message'] = '音乐文件过大';
    return;
  }

  if($song['size'] < 1*1024){
    $GLOBALS['error_message'] = '音乐文件过小';
    return;
  }

  //校验类型
  $allowed_types = array('audio/mp3','audio/wma');
  if(!in_array($song['type'], $allowed_types)){ 
    $GLOBALS['error_message'] = '请上传正确格式的音乐文件';
    return;
  }

  //移动文件
  //一般会将上传的文件重命名
  $source = $song['tmp_name'];
  $target = './uploads/music/'.uniqid().'-'.$song['name'];
  

  if(!move_uploaded_file($source, $target)){ 
    $GLOBALS['error_message'] = '上传音乐文件失败';
    return;
  }

  //---------------校验单个图片上传是否成功----------------------------
  if(empty($_FILES['img'])){ 
    //判断客户端提交表单中没有song这个文件域
    $GLOBALS['error_message'] = '请正确提交文件';
    return;
  }

  $img = $_FILES['img'];


  //判断用户是否选择文件
  if($img['error'] != UPLOAD_ERR_OK){ 
    $GLOBALS['error_message'] = '请选择图片文件';
    return;
  }

  //校验文件的大小

  if($img['size'] > 1*1024*1024){
    $GLOBALS['error_message'] = '图片文件过大';
    return;
  }

  //校验类型
  $allowed_types = array('image/jpeg','image/png','image/gif');
  if(!in_array($img['type'], $allowed_types)){ 
    $GLOBALS['error_message'] = '请上传正确格式的图片文件';
    return;
  }

  //移动文件
  //一般会将上传的文件重命名
  $source = $img['tmp_name'];
  $target = './uploads/img/'.uniqid().'-'.$img['name'];

  
  if(!move_uploaded_file($source, $target)){ 
    $GLOBALS['error_message'] = '上传图片文件失败';
    return;
  }

  //---------------------------上传成功------------------------

  $origin = file_get_contents('storage.json',true);

  $origin[] = array(
    'id' => uniqid(),
    'title' => $_POST['title'],
    'artist' => $_POST['sing'],
    'images' => '1',
    'source' => '2'
  );

  $json = json_encode($origin);

  file_put_contents('storage.json', $json);
  
  //新增成功跳转到列表页
  header('Location: list.php');

}

if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
  add_music();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>添加音乐</title>
  <link rel="stylesheet" href="bootstrap.css">
</head>
<body>
  <div class="container mt-5">
    <h1 class="display-3">添加音乐</h1>
    <hr>
    <?php if (isset($error_message)): ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $error_message; ?>
      </div>
    <?php endif ?>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="title">标题</label>
        <input type="text" name="title" id="title" class="form-control is-invalid" value="">
      </div>
      <div class="form-group">
        <label for="sing">歌手</label>
        <input type="text" name="sing" id="sing" class="form-control">
      </div>
      <div class="form-group">
        <label for="img">海报</label>
        <!-- accept 限制文件上传的类型 -->
        <input type="file" name="img" id="img" class="form-control" accept="image/*">
      </div>
      <div class="form-group">
        <label for="song">歌曲</label>
        <input type="file" name="song" id="song" class="form-control" accept="audio/*">
      </div>

      <button class="btn btn-block btn-primary">保存</button>
    </form>
  </div>
</body>
</html>

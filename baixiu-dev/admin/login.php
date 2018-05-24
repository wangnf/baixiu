<?php

  //得到配置文件
require_once('../config.php');  


function login(){ 

    //1.接受并校验

    //1.1判断 是否有input

    //1.2判断 提交的input是否是空 
  if(empty($_POST['email'])){ 
    $GLOBALS['message'] = '请填写邮箱';
    return;
  }

  if(empty($_POST['password'])){
    $GLOBALS['message'] = '请填写密码';
    return;
  }

    //1.3接收
  $email = $_POST['email'];
  $password = $_POST['password'];

    //1.4校验账号密码  
    // if($email != 'admin@simple.com'){ 
    //   $GLOBALS['message'] = '账号密码不匹配';
    // }
    // if($password != '123456'){ 
    //   $GLOBALS['message'] = '账号密码不匹配';
    // }

    //1.4 数据库账号密码校验
  $connect = mysqli_connect(XIU_DB_HOST,XIU_DB_USER,XIU_DB_PASS,XIU_DB_NAME);
  $connect->query("SET NAMES utf8");
  if(!$connect){ 
    exit('<h1>数据库连接失败</h1>');
  }

    //查询匹配账号
  $query = mysqli_query($connect,"SELECT * FROM users WHERE email = '{$email}' LIMIT 1");
  if(!$query){ 
    $GLOBALS['message'] = '登录失败，请重试';
    return;
  }

  $user = mysqli_fetch_assoc($query);

  if(!$user){ 
    $GLOBALS['message'] = '账号密码不匹配';
    return;
  }

  if($user['password'] != $password){ 
    $GLOBALS['message'] = '账号密码不匹配';
    return;
  }
  session_start();
  $_SESSION['login_message']=$user;


    //2.持久化

    //3.响应
  header('location:/admin/');

}

  //判断是否是post
if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
    //解决代码嵌套问题
  login();
}


//退出功能
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'logout'){ 
  unset($_SESSION['login_message']);
}

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
  <link rel="stylesheet" href="/static//assets/vendors/animate/animate.css">
</head>
<body>
  <div class="login">
    <!-- novalidate取消浏览器自带的校验 -->
    <form class="login-wrap<?php echo isset($message)?' shake animated':''; ?>" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" novalidate autocomplete="off">
      <img class="avatar" src="/static/assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <?php if (isset($message)): ?>
        <div class="alert alert-danger">
          <strong>错误！</strong><?php echo $message; ?>
        </div>
      <?php endif ?>
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong> 用户名或密码错误！
      </div> -->
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" name="email" type="email" class="form-control" placeholder="邮箱" autofocus value="<?php echo empty($_POST['email'])?'':$_POST['email'];?>">
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" name="password" type="password" class="form-control" placeholder="密码">
      </div>
      <button class="btn btn-primary btn-block">登 录</button>
    </form>
  </div>
  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script>

    $(function($){ 
      $('#email').on('blur',function(){ 
        var email_reg = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/
        var value = $(this).val()
        if(!value || !email_reg.test(value)) return
        
        // $.get('/admin/api/avatar.php',{email:value},function(data){
        //   if(!data) return

        //   $('.avatar').fadeOut(function(){  
        //     $(this).attr('src',data)
        //     $(this).on('load',function(){ 
        //       $(this).fadeIn();
        //     })
        //   })
        // })

        $.ajax({  
          method:'get',
          url:'/admin/api/avatar.php',
          data:{
            email:value
          },
          success:function(data){ 
            $('.avatar').fadeOut(function(){  
            $(this).attr('src',data)
            $(this).on('load',function(){ 
              $(this).fadeIn();
            })
          })
          }
        })

      })
    });

  </script>
</body>
</html>

<?php  

require_once('../functions.php');
xiu_get_current_user();

//编辑
if(!empty($_GET['id'])){ 

  $current_edit_category = xiu_fetch_one('select * from categories where id ='. $_GET['id']);

}
function edit_category(){ 
  global $current_edit_category;

  $edit_id = $current_edit_category['id'];
  $edit_name = $_POST['name']? $_POST['name'] : $current_edit_category['name'];
  $edit_slug = $_POST['slug']? $_POST['slug'] : $current_edit_category['slug'];

  $current_edit_category['name'] = $edit_name;
  $current_edit_category['slug'] = $edit_slug;

  $affected = xiu_inset("UPDATE categories SET slug = '{$edit_slug}',name = '{$edit_name}' WHERE id = {$edit_id};");
  $GLOBALS['success'] = $affected > 0;
  $GLOBALS['message'] = $affected<=0?'更新失败':'更新成功';
}

//添加
function xiu_give(){  

  if(empty($_POST['name'] || empty($_POST['slug']))){ 
    $GLOBALS['success'] = false;
    $GLOBALS['message'] = '请正确填写的表单！';
    return;
  }

  $name = $_POST['name'];
  $slug = $_POST['slug'];

  $affected = xiu_inset("INSERT INTO categories VALUES (null,'{$slug}','{$name}');");

  $GLOBALS['success'] = $affected > 0;
  $GLOBALS['message'] = $affected<=0?'提交失败':'添加成功';
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
  if(empty($_GET['id'])){ 
    xiu_give();
  }else{  
    edit_category();
  }

}


//查询
$categories = xiu_fetch_all('select * from categories;');





?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
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
        <h1>分类目录</h1>
      </div>
      <?php if (isset($message)): ?>
        <?php if ($success): ?>
          <div class="alert alert-success">
            <strong>成功！</strong><?php echo $message; ?>
          </div>
        <?php else: ?>
          <div class="alert alert-danger">
            <strong>错误！</strong><?php echo $message; ?>
          </div>
        <?php endif ?> 
      <?php endif ?>     
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <?php if (isset($current_edit_category)): ?>
           <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $current_edit_category['id']; ?>" method="post">
            <h2>编辑《 <?php echo $current_edit_category['name']; ?> 》</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称" value="<?php echo $current_edit_category['name']; ?>">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug" value="<?php echo $current_edit_category['slug']; ?>">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">保存</button>
            </div>
          </form>
        <?php else: ?>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
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
          <a class="btn btn-danger btn-sm" id="category_del_all" href="/admin/category-del.php" style="display: none">批量删除</a>
        </div>
        <table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th class="text-center" width="40"><input type="checkbox"></th>
              <th>名称</th>
              <th>Slug</th>
              <th class="text-center" width="100">操作</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($categories as $value): ?>
              <tr>
                <td class="text-center"><input type="checkbox" data-id="<?php echo $value['id']; ?>"></td>
                <td><?php echo $value['name']; ?></td>
                <td><?php echo $value['slug']; ?></td>
                <td class="text-center">
                  <a href="/admin/categories.php?id=<?php echo $value['id']; ?>" class="btn btn-info btn-xs">编辑</a>
                  <a href="/admin/category-del.php?id=<?php echo $value['id']; ?>" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
            <?php endforeach ?>   
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php $current_page = 'categories'; ?>
<?php include 'inc/sidebar.php'; ?>

<script src="/static/assets/vendors/jquery/jquery.js"></script>
<script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
<script>
  $(function($){

    var $allCheckbox = $('tbody input');
    var $categoryDelAll = $('#category_del_all');

    //第一种方法
    // $allCheckbox.on('change',function(){  
    //   var flag = false;
    //   $allCheckbox.each(function(i,v){ 
    //     if($(v).prop('checked')){ 
    //       flag = true;
    //     }
    //   })
    //   flag ? $categoryDelAll.fadeIn() : $categoryDelAll.fadeOut();

    // })

    //第二种方法
    var $allChecked = [];
    $allCheckbox.on('change',function(){  

      var $id = $(this).data('id');

      if($(this).prop('checked')){ 
        $allChecked.includes($id) || $allChecked.push($id);

       
      }else{  
        $allChecked.splice($allChecked.indexOf($id),1);
      }

      $allChecked.length ? $categoryDelAll.fadeIn() : $categoryDelAll.fadeOut();

      $categoryDelAll.prop('search','?id='+$allChecked);

    })



    //全选
    var allInput = $('thead input');

    allInput.on('change',function(){  

      var inputChecked = $(this).prop('checked');
      $allCheckbox.prop('checked',inputChecked).trigger('change');


    })

  })

</script>
<script>NProgress.done()</script>
</body>
</html>

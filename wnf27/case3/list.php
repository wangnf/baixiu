<?php
    $contents = file_get_contents('storage.json');
    $data = json_decode($contents,true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>音乐列表</title>
  <link rel="stylesheet" href="bootstrap.css">
</head>
<body>
  <div class="container my-5">
    <h1 class="display-3">音乐列表</h1>
    <a href="add.php" class="btn btn-primary">添加</a>
    <hr>
    <table class="table table-bordered table-striped table-hover">
      <thead class="thead-inverse">
      <tr>
          <th>编号</th>
          <th>标题</th>
          <th>歌手</th>
          <th>海报</th>
          <th>音乐</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data as $key => $value): ?>
          <tr>
            <td>59d632855434e</td>
                    <td><?php echo $value['title'] ?></td>
                    <td><?php echo $value['artist'] ?></td>
                    <td><img src="<?php echo $value['images'][0] ?>" alt=""></td>
                    <td><audio src="<?php echo $value['sourch'] ?>" controls></audio></td>
                    <td><button class="btn btn-danger btn-sm">删除</button></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</body>
</html>

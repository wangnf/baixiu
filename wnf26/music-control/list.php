<?php 

//读取本地json文件
$json_string = file_get_contents('data.json');   

// 用参数true把JSON字符串强制转成PHP数组    
$data = json_decode($json_string, true);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>音乐列表</title>
	<link rel="stylesheet" href="bootstrap-4.0.0-dist/css/bootstrap.css">
</head>
<body>
	<div class="container">
		<h3 class="my-3">音乐列表</h3>
		<hr>
		<table class="table">
			<thead class="thead-light">
				<tr>
					<th>编号</th>
					<th>歌曲名</th>
					<th>歌手</th>
					<th>图片</th>
					<th>播放</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($data as $value): ?>
					<tr>
						<?php foreach ($value as $key => $value): ?>
							<?php if ($key=='images'): ?>
								<?php foreach ($value as $value): ?>
									<td><img src="<?php echo $value;?>" alt=""></td>
								<?php endforeach ?>
							<?php else: ?>
								<td><?php echo $value; ?></td>
							<?php endif ?>
						<?php endforeach ?>
						<td><a href="#" class="btn btn-danger btn-sm">删除</a></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</body>
</html>
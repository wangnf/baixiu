<?php 

	$connect = mysqli_connect('localhost','root','123456','demo');

	mysqli_set_charset($connect,'utf8');

	if(!$connect){	
		exit('连接数据库失败');
	};

	$query = mysqli_query($connect,'select * from categories');

	if(!$query){	
		exit('查询数据失败');
	}

	$rows = array();
	while($row = mysqli_fetch_assoc($query)){	
		$rows[]=$row;
	}

	mysqli_free_result($query);
	mysqli_close($connect);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th>编号</th>
				<th>名称</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($rows as $key => $value): ?>
			<tr>
				<th><?php echo $value['id']; ?></th>
				<td><?php echo $value['name'] ?></td>
				<td><a href="#">删除</a></td>
			</tr>
			<?php endforeach ?>		
		</tbody>
	</table>
</body>
</html>
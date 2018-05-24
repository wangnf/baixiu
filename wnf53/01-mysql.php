<?php  
	$cononection = mysqli_connect('localhost','root','123456','demo2');

	if(!$cononection){	
		exit('连接数据库失败');
	}

	$query = mysqli_query($cononection,'select * from users;');

	if(!$query){	

		exit('查询数据失败');
	}

	//等着去取数据
	
	//遍历结果集
	while ($row = mysqli_fetch_assoc($query)) {
		var_dump($row);
	};

	//释放结果集
	mysqli_free_result($query);

	mysqli_close($cononection);
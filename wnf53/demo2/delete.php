<?php  

if(empty($_GET['id'])){	
	exit('必须传入指定参数');
}

//获取GET数据

$id = $_GET['id'];

//连接数据库
$connect = mysqli_connect('localhost','root','123456','test');

if(!$connect){	
	exit('连接数据库失败');
}

//获取数据

$query = mysqli_query($connect,'DELETE FROM users where id='.$id.';');

if(!$query){	
	exit('获取数据失败');
}

$affected_rows = mysqli_affected_rows($connect);

if($affected_rows <= 0){	
	exit('删除失败');
}
header('location: index.php');


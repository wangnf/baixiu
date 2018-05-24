<?php  

//判断传的参数是否为空
if(empty($_GET['email'])){	
	exit('缺少必要的参数');
}
$email = $_GET['email'];
//连接数据库
require_once('../../config.php');

$connect = mysqli_connect(XIU_DB_HOST,XIU_DB_USER,XIU_DB_PASS,XIU_DB_NAME);

if(!$connect){	
	exit('连接数据库失败');
}

$res = mysqli_query($connect,"SELECT avatar FROM users WHERE email = '{$email}' limit 1");

if(!$res){	
	exit('查询数据库失败');
}

$row = mysqli_fetch_assoc($res);

echo $row['avatar'];


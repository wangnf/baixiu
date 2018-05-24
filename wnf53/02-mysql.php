<?php  

$connect = mysqli_connect('localhost','root','123456','demo2');

mysqli_set_charset($connect,'utf8');

if(!$connect){	
	exit('链接数据库失败');
}

$query = mysqli_query($connect,'delete from users where id = 1;');

if(!$query){	
	exit('操作数据库失败');
}

$rows = mysqli_affected_rows($connect);

var_dump($rows);

//释放结果及

mysqli_free_result($query);

//炸掉桥梁

mysqli_close($connect);
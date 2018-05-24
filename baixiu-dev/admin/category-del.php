<?php  

require_once('../functions.php');

if(empty($_GET['id'])){	
	exit('缺少必要的参数');
}

$id = $_GET['id'];


$affected = xiu_inset('DELETE FROM categories WHERE id IN ('. $id .');');


// if($affected<=0){	
// 	exit('<h1>删除失败</h1>');
// }

header('location: /admin/categories.php');
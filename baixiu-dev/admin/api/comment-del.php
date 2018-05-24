<?php 

require_once('../../functions.php');

if(empty($_GET['id'])){	
	exit('缺少必要的参数');
}

$id = $_GET['id'];

$affect = xiu_inset('delete from comments where id in ('. $id .')');

header('Content-Type: appliction/json');

echo json_encode($affect>0);

<?php 

require_once('../functions.php');

if(empty($_GET['id'])){	
	exit();
}

$id=$_GET['id'];

$affected = xiu_inset('DELETE FROM users WHERE id IN ('.$id.');');

header('location:/admin/users.php');

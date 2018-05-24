<?php 
	
if($_SERVER['REQUEST_METHOD'] === 'POST'){	


	var_dump($_FILES['a']);

}

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
	
	<!-- <input type="text" name="foo">
	<input type="text" name="bar"> -->
	<input type="file" name="a">
	<button>提交</button>
</form>
</body>
</html>
<!DOCTYPE html>
<?php  
	
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		var_dump($_POST);
	}
?>

<html>
<head>
	<title></title>
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	

<p>
	<input type="checkbox" name="funs[]" value="lq">篮球<br>
	<input type="checkbox" name="funs[]" value="zq">足球<br>
	<input type="checkbox" name="funs[]" value="dq">地球<br>
</p>
<p>
	<button>提交</button>
</p>

</form>
</body>
</html>
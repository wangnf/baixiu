<?php 

if($_SERVER['REQUEST_METHOD']==='POST'){	
	var_dump($_POST);
};

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
	<p>
		<label>用户名</label>
		<input type="text" name="username" id="username">
	</p>
	<p>
		<label>密码</label>
		<input type="password" name="psw" id="psw">
	</p>
	<p>
		<input type="submit" value="提交 ">
	</p>
</form>
</body>
</html>
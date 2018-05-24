<?php 
	if($_SERVER['REQUEST_METHOD'] === 'POST'){	
	
		var_dump($_POST);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>注册</title >
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<label>
		用户名:<input type="text" name="user">
	</label><br>
	<label>
		密码:<input type="password" name="psd">
	</label><br>
	<label>
		确认密码:<input type="password" name="mpsd">
	</label><br>
	<label>
		<input type="checkbox" name="agree">同意协议
	</label><br>
	<button>提交</button>
</form>
</body>
</html>
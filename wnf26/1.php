<?php  

	if($_SERVER['REQUEST_METHOD'] === 'POST'){	

		if (empty($_POST['user'])) {
			$message= "请输入用户名";
		}else{	
			if(empty($_POST['psw'])){	
				$message = "请输入密码";
			}else{	
				if(empty($_POST['surepsw'])){	
					$message = "请确认密码";
				}else{	
					if($_POST['psw'] != $_POST['surepsw']){	
						$message = "密码不相等";
					}else{	
						if(!(isset($_POST['cb']) && $_POST['cb'] === 'on')){	
							$message = "请同意协议";
						}else{	
							$username = $_POST['user'];
							$password = $_POST['psw'];
							file_put_contents('user.txt', $username.'|'.$password."\n",FILE_APPEND);
							$message = "注册成功";
						}
					}
				}
			}
		}

	}

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	
	<label>
		用户名:<input type="text" name="user" value="<?php echo isset($_POST['user'])?$_POST['user']:''; ?>">
	</label><br>
	<label>
		密码:<input type="password" name="psw">
	</label><br>
	<label>
		确认密码:<input type="password" name="surepsw">
	</label><br>
	<label>
		<input type="checkbox" name="cb">确认
	</label>
	<?php if (isset($message)): ?>
	<p>
		<?php echo $message; ?>
	</p>	
	<?php endif ?>
	<p>
		<button>提交</button>
	</p>

</form>

</body>
</html>
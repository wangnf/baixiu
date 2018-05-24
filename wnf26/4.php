<?php 
	
	function postback(){	

		if(!isset($_FILES['avatar'])){	
			$GLOBALS['message'] = '别玩我了';
			return;
		}

		$avatar = $_FILES['avatar'];

		if($avatar['error'] != UPLOAD_ERR_OK){	
			$GLOBALS['message'] = '上传失败';
			return;
		}

		$sourse = $avatar['tmp_name'];
		$target = './uploads/'.$avatar['name'];

		$moved = move_uploaded_file($sourse, $target);

		if(!$moved){	
			$GLOBALS['message'] = '上传失败';
			return;
		}

		//上传成功
		echo "123";

	}

	if($_SERVER['REQUEST_METHOD'] === 'POST'){	
		postback();
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		
		<input type="file" name="avatar">
		<button>提交</button>
		<?php if (isset($message)): ?>
			<p>
				<?php echo $message; ?>
			</p>
		<?php endif ?>
	</form>
</body>
</html>
<?php 

function postback(){	

	if(empty($_POST['song'])){	
		$GLOBALS['message'] = '请输入歌曲名';
		return;
	}

	if(empty($_POST['sing'])){	
		$GLOBALS['message'] = '请输入歌手名';
		return;
	}

	if ($_FILES['img']['error'] === UPLOAD_ERR_OK){

		  $temp_file = $_FILES['img']['tmp_name'];

		  $target_file = '/uploads/img/' . $_FILES['file']['name'];
		  if (move_uploaded_file($temp_file, $target_file)) {
			    $image_file = '/uploads/img/' . $_FILES['file']['name'];
		  };
	}

	if ($_FILES['music']['error'] === UPLOAD_ERR_OK) {

		  $temp_file = $_FILES['music']['tmp_name'];

		  $target_file = '/uploads/mp3/' . $_FILES['file']['name'];
		  if (move_uploaded_file($temp_file, $target_file)) {
			    $image_file = '/uploads/mp3/' . $_FILES['file']['name'];
			$GLOBALS['message'] = '上传成功';
		  }
	}
};

if($_SERVER['REQUERT_METHOD'] === 'POST'){	
	postback();
};

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>添加歌曲</title>
	<link rel="stylesheet" href="bootstrap-4.0.0-dist/css/bootstrap.css">
</head>
<body>
	<div class="container">
		<h3 class="my-3">添加歌曲</h3>
		<hr>
		<form>
			<div class="form-group">
				<label for="exampleInputEmail1">歌曲名</label>
				<input type="email" class="form-control" name="song" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="请输入歌曲名">
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">歌手</label>
				<input type="text" class="form-control" name="sing" id="exampleInputPassword1" placeholder="请输入歌手名">
			</div>
			<div class="form-group form-control">
				<label for="uploadsimg">选择图片</label>
				<input type="file" name="img" id="uploadsimg">
			</div>
			<div class="form-group form-control">
				<label for="uploadsmusic">选择歌曲文件</label>
				<input type="file" name="music" id="uploadsmusic">
			</div>
			<button class="btn btn-primary">添加歌曲</button>
			<?php if (isset($message)): ?>
				<p style="text-danger text-center"><?php echo $message; ?></p>
			<?php endif ?>
		</form>

	</div>
</body>
</html>
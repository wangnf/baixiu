<?php 

if($_SERVER['REQUEST_METHOD'] === 'POST'){	
var_dump($_POST);
}



?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
	
	性别:
	<label><input type="radio" name="gender" value="men">男</label>
	<label><input type="radio" name="gender" value="women">女</label>
	<label><input type="checkbox" name="agree" value="true">同意</label>
	<button>提交</button>
</form>

</body>
</html>
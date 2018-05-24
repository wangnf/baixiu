<?php  

/**
* 判断用户是否登录
*/
@session_start();
require_once('config.php');



function xiu_get_current_user(){	
	
	if(empty($_SESSION['login_message'])){ 
		header('location:/admin/login.php');
    	exit(); //没有登录的话 ，就没必要再往下执行
    };
  	//否则的话 ， 就将用户信息传出去
    return $_SESSION['login_message'];
};



//通过数据库查询 获取多条数据
function xiu_fetch_all($sql){	

	$connect = mysqli_connect(XIU_DB_HOST,XIU_DB_USER,XIU_DB_PASS,XIU_DB_NAME);
	$connect->query("SET NAMES utf8");
	if(!$connect){	
		exit('数据库连接失败');
	}

	$query = mysqli_query($connect,$sql);

	if(!$query){	
		return false;
	}
	$result = array();
	while ($row = mysqli_fetch_assoc($query)) {
		$result[] = $row;
	}

	mysqli_free_result($query);
	mysqli_close($connect);


	return $result;
}

//通过数据库获取单条数据
function xiu_fetch_one($sql){	
	$res = xiu_fetch_all($sql)[0];
	return isset($res)?$res:'null';

}

//增删改---没有查
function xiu_inset($sql){	
	$connect = mysqli_connect(XIU_DB_HOST,XIU_DB_USER,XIU_DB_PASS,XIU_DB_NAME);
	$connect->query("SET NAMES utf8");
	if(!$connect){	
		exit('数据库连接失败');
	}

	$query = mysqli_query($connect,$sql);

	if(!$query){	
		return false;
	}

	$affected = mysqli_affected_rows($connect);

	mysqli_close($connect);


	return $affected;
}









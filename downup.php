<?php
	define ( "TOKEN", "doubleq");
	//定义数据库参数
	if(!defined('SAE_MYSQL_HOST_M')) {
	  define('SAE_MYSQL_USER', 'duyi324'); //用户名
	  define('SAE_MYSQL_PASS', 'lifayu11'); //密　　码
	  define('SAE_MYSQL_HOST_M', 'localhost'); //主库域名
	  define('SAE_MYSQL_HOST_S', 'localhost'); //从库域名
	  define('SAE_MYSQL_PORT', 3306); //端　　口
	  define('SAE_MYSQL_DB', 'app_ulink'); //数据库名
	}
	
	if ($_GET['data'] && ($_GET['token'] == TOKEN)) {//可以改token,这相当于密码，在Arduino端改成相应的值即可
		$con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS); 
		$data = $_GET['data'];
		mysql_select_db(SAE_MYSQL_DB, $con);//要改成相应的数据库名

		$result = mysql_query("SELECT * FROM `switch`");
		while($arr = mysql_fetch_array($result)){//找到需要的数据的记录，并读出状态值
			if ($arr['ID'] == 1) {
				$state = $arr['state'];
			}
		}
		$dati = date("h:i:sa");//获取时间
		$sql ="UPDATE `sensor` SET `timestamp`='$dati', `data`='$data' WHERE `ID`='1'";//更新相应的传感器的值
		if(!mysql_query($sql,$con)){
			die('Error: ' . mysql_error());//如果出错，显示错误
		}
		mysql_close($con);
		echo "{".$state."}";//返回状态值，加“{”是为了帮助Arduino确定数据的位置
	}else{
		echo "Permission Denied";//请求中没有type或data或token或token错误时，显示Permission Denied
	}
?>
<?php
/**
 *User:判断是否申请试驾
 *Data:2017/8/1
 *time:17:01
 */
/*-----------------------token验证---------------*/
	include_once('token.php');//token验证成功后会生成user_id;
/*----------------------链接数据库查询-----------*/
	$sql = "select test_id from test_drive WHERE user_id = '$user_id'";
	$ret =$mySQLi->query($sql);
	$data = array();
	while ($info = $ret ->fetch_object()) {
	 	$data []= $info;	# code...
	 	} 
	 	$mySQLi->close();//关闭数据库
	 if(empty($data)){
	 	echo json_encode(array('status'=>200));
	 }else{
	 	echo json_encode(array('status'=>400,'msg'=>"你已经申请过试驾了"));
	 }

?>
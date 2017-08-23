<?php
/**
* User:材料上传判断接口
*Data:2017/7/31
*Time:20:43
 */
/*--------------token验证---------------*/
include_once('token.php');//token验证 ，成功后会有user_id;
/*-----------------材料上传判断------------*/
include_once('database.php');
$sql = "select * from file_img WHERE user_id = '$user_id'";
$info = $mySQLi->query($sql);
$data = '';
while ($ret = $info->fetch_array()) {
	$data[]=$ret;
}
if($data==""){
	echo json_encode(array('status'=>400,'msg'=>'请先上传材料'));
}else {
	echo json_encode(array('status'=>200,));
}

<?php
/**
 * User: 送考预约
 * Date: 2017/8/2
 * Time: 12:01
 */
//include_once ('safe.php');
$token = isset($_POST['token'])?$_POST['token']:'';//获取token
if($token==''){
    echo json_encode(array('status'=>500,'msg'=>'token不能为空'));
    return;
}
include_once "database.php";//链接数据库
$sql = "select * from user WHERE token='$token'";
$res = $mySQLi -> query($sql);
$user_id='';
$role_id = '';
while($row = $res -> fetch_array()){
    $user_id = $row['user_id'];
    $role_id = $row['role_id'];
}
$time = isset($_POST['time'])?$_POST['time']:'';
$address = isset($_POST['address'])?$_POST['address']:'';
$subject = isset($_POST['subject'])?$_POST['subject']:'';
if($time=='' or $address=='' or $subject==''){
    echo json_encode(array('statues'=>400,'msg'=>'信息不能为空'));
    return;
}
if($user_id==''){
    echo json_encode(array('status'=>400,'msg'=>'token错误'));
    return;
}
$order_number = 'SK'.date('YmdHis').$user_id;
if($subject=='科目三'){
    $sql="insert into teacher_order (`order_number`,`user_id`,`order_type`,`order_time`,`meet_address`,`subject`,`meet_time`) VALUES ('$order_number','$user_id','date','$time','$address','three','$time')";
}else{
    $sql="insert into teacher_order (`order_number`,`user_id`,`order_type`,`order_time`,`meet_address`,`subject`,`meet_time`) VALUES ('$order_number','$user_id','date','$time','$address','two','$time')";
}

$res=$mySQLi->query($sql);
if($res){
    echo json_encode(array('status'=>200,'msg'=>'约考成功'));
}
else{
    echo json_encode(array('status'=>400,'msg'=>'失败'));
}

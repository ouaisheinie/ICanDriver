<?php
/**
 * User: 老师计划接口
 * Date: 2017/8/3
 * Time: 15:42
 */
$token = isset($_POST['token'])?$_POST['token']:'';//获取token
if($token==''){//如果没传token
    echo json_encode(array('status'=>250,'msg'=>'token不能为空'));
    return;
}
include_once "database.php";//链接数据库
$sql = "select * from user WHERE token='$token'";
$res = $mySQLi -> query($sql);
$user_id='';
$role_id='';
while($row = $res -> fetch_array()){
    $user_id = $row['user_id'];
    $role_id = $row['role_id'];
}
if($user_id==''){//判断token是否正确
    echo json_encode(array('status'=>400,'msg'=>'token错误'));
    return;
}
if($role_id!=2){//判断是否是教练
    echo json_encode(array('status'=>400,'msg'=>'您还不是教练'));
    return;
}
$sql = "select teacher_id from teacher WHERE user_id ='$user_id'";
$res = $mySQLi -> query($sql);
$teacher_id = '';
while($row = $res -> fetch_array()){
    $teacher_id = $row['teacher_id'];
}
$date = date('Y-m-d');

$sql="select * from clear_time WHERE teacher_id='$teacher_id' AND clear_date>='$date'";
$res= $mySQLi->query($sql);
$clear_time=array();
while($ro=$res->fetch_object()){
    $clear_time[]=$ro;
}


$sql="select teacher_order.*,user_info.user_name from teacher_order LEFT JOIN user_info ON user_info.user_id = teacher_order.user_id WHERE teacher_id='$teacher_id' AND order_time>='$date' AND status='success' AND order_status='conduct'";
$res= $mySQLi->query($sql);
$teacher_order=array();
while($ro=$res->fetch_object()){
    $teacher_order[]=$ro;
}

$time = array_merge($clear_time, $teacher_order);

echo json_encode(array('status'=>200,'time'=>$time));
return;
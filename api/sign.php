<?php
/**
 * User: 支付回掉
 * Date: 2017/7/28
 * Time: 14:28
 */
/*----------------------------基础验证------------------------------------*/

include_once('safe.php');//防注入代码
$token = isset($_GET['token'])?$_GET['token']:'';//获取token
if($token==''){
    echo json_encode(array('status'=>250,'msg'=>'token不能为空'));
    return;
}

/*----------------------------token验证------------------------------------*/

include_once "database.php";//链接数据库
$sql = "select * from user WHERE token='$token'";
$res = $mySQLi -> query($sql);
$user_id='';
while($row = $res -> fetch_array()){
    $user_id = $row['user_id'];
}
if($user_id==''){
    echo json_encode(array('status'=>250,'msg'=>'token错误'));
    return;
}

/*----------------------------获取参数------------------------------------*/
$sign_type = isset($_GET['sign_type'])?$_GET['sign_type']:'';//报名类型
$sign_place = isset($_GET['sign_place'])?$_GET['sign_place']:'';//支付金额
$school_id = isset($_GET['school_id'])?$_GET['school_id']:'';//学校id
$payment_type = isset($_GET['payment_type'])?$_GET['payment_type']:'';//支付方式
if($sign_type=='' or $sign_place=='' or $school_id==''){
    echo json_encode(array('status'=>400,'msg'=>'没有传报名信息'));
    return;
}
$time=date('ymdhis');
$order_number=$time.$user_id;
 $sql="INSERT INTO school_order (school_id,user_id,status,sign_type,sign_place,payment_type,order_number) VALUES ('$school_id','$user_id','error','$sign_type','$sign_place','$payment_type','$order_number')";
 $ret = $mySQLi->query($sql);
 $mySQLi->close();//关闭数据库
/*----------------------------支付接口------------------------------------*/
if($ret){
 header("location:payment.php?order_number=$order_number");
}

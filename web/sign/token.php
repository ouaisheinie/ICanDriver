<?php
/**
 * User: token验证
 * Date: 2017/7/29
 * Time: 11:01
 */
/*----------------------------基础验证------------------------------------*/

include_once('safe.php');//防注入代码
$token = isset($_POST['token'])?$_POST['token']:'';//获取token
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
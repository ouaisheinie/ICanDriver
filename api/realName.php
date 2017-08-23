<?php
/**
 * User: 是否实名认证接口
 * Date: 2017/7/27
 * Time: 16:54
 */

/*----------------------------基础验证------------------------------------*/
include_once('token.php');//token验证,验证成功会有$user_id

/*----------------------------判断有无实名验证------------------------------------*/

$sql = "select id from user_info WHERE user_id='$user_id'";
$res = $mySQLi -> query($sql);
$id='';
while($row = $res -> fetch_array()){
     $id = $row['id'];
}
$mySQLi->close();//关闭数据库
if($id==''){//未验证
     echo json_encode(array('status'=>400,'msg'=>'请先进行实名验证'));
}else{//已验证
     echo json_encode(array('status'=>200));
}


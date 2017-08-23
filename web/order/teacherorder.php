<?php
/**
 * User:教练订单
 * Date: 2017/7/30
 * Time: 10:45
 */
/*----------------------------基础验证------------------------------------*/
include_once('safe.php');//防注入代码
$token = isset($_POST['token'])?$_POST['token']:'';//获取token
if($token==''){
    echo json_encode(array('status'=>250,'msg'=>'token不能为空'));
    return;
}

/*----------------------------接收参数------------------------------------*/
$status = isset($_POST['status'])?$_POST['status']:'';//获取status
if($status==''){
    echo json_encode(array('status'=>250,'msg'=>'status不能为空'));
    return;
}

/*----------------------------token验证------------------------------------*/

include_once "database.php";//链接数据库
$sql = "select * from user WHERE token='$token'";
$res = $mySQLi -> query($sql);
$user_id='';
$role_id='';
while($row = $res -> fetch_array()){
    $user_id = $row['user_id'];
    $role_id = $row['role_id'];
}
if($user_id==''){
    echo json_encode(array('status'=>250,'msg'=>'token错误'));
    return;
}
    $sql ="select teacher_id from teacher WHERE user_id = $user_id";
    $res =$mySQLi->query($sql);
    $teacher_id='';
    while ($row=$res->fetch_array()) {
        $teacher_id=$row['teacher_id'];
    }
if($role_id == 2){
        $sql = "select teacher_order.*,user_info.user_name,user_info.photo from teacher_order LEFT JOIN  user_info ON user_info.user_id =  teacher_order.user_id  WHERE  teacher_id='$teacher_id' AND order_status='conduct' AND order_type='test'";
        $res = $mySQLi->query($sql);
        $test = array();
        while($row = $res -> fetch_array()){
            $test[] = $row;
        }

        $sql = "select teacher_order.*,user_info.user_name,user_info.photo from teacher_order LEFT JOIN  user_info ON user_info.user_id =  teacher_order.user_id  WHERE  teacher_id='$teacher_id' AND order_status='conduct' AND order_type='shuttle'";
        $res = $mySQLi->query($sql);
        $shuttle= array();
        while($row = $res -> fetch_array()){
            $shuttle[] = $row;
        }
         $sql = "select teacher_order.*,user_info.user_name,user_info.photo from teacher_order LEFT JOIN  user_info ON user_info.user_id =  teacher_order.user_id  WHERE  teacher_id='$teacher_id' AND order_status='clear' AND order_type='test'";
        $ress = $mySQLi->query($sql);
        $testt= array();
        while($row = $ress -> fetch_array()){
            $testt[] = $row;
        }
         $sql = "select teacher_order.*,user_info.user_name,user_info.photo from teacher_order LEFT JOIN  user_info ON user_info.user_id =  teacher_order.user_id  WHERE  teacher_id='$teacher_id' AND order_status='clear' AND order_type='shuttle'";
        $ress= $mySQLi->query($sql);
        $shuttlee= array();
        while($row = $ress -> fetch_array()){
            $shuttlee[] = $row;
        }
        $sql = "select teacher_order.*,user_info.user_name,user_info.photo from teacher_order LEFT JOIN  user_info ON user_info.user_id =  teacher_order.user_id  WHERE  teacher_id='$teacher_id' AND order_status='complete'";
        $res = $mySQLi->query($sql);
        $complet= array();
        while($row = $res -> fetch_array()){
            $complet[] = $row;
        }

    $conduct['test']=$test;
    $conduct['shuttle'] = $shuttle;
    $clear['test']=$testt;
    $clear['shuttle'] =$shuttlee; 
    $complete =$complet;
    echo json_encode(array('status'=>200,'conduct'=>$conduct,'clear'=>$clear,'complete'=>$complete));
}
  


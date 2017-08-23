<?php
/**
 * User: 保存约教订单
 * Date: 2017/8/2
 * Time: 18:38
 */
//echo json_encode($_POST);
//return;
/*----------------------------基础验证------------------------------------*/
include_once('token.php');//token验证,验证成功会有$user_id

/*----------------------------保存订单------------------------------------*/
//token:token,teacher_id:teacher_id,today:today,tomorrow:tomorrow,after:after,subject:subject,address:address,order_time:order_time
$teacher_id = isset($_POST['teacher_id'])?$_POST['teacher_id']:'';
$place = isset($_POST['place'])?$_POST['place']:'';
$subject = isset($_POST['subject'])?$_POST['subject']:'';
$address = isset($_POST['address'])?$_POST['address']:'';
$order_time1 = isset($_POST['order_time'])?$_POST['order_time']:'';
$today = isset($_POST['today'])?$_POST['today']:array();
$tomorrow = isset($_POST['tomorrow'])?$_POST['tomorrow']:array();
$after = isset($_POST['after'])?$_POST['after']:array();
$order_number = 'DT'.date('YmdHis').$user_id;
$mySQLi->autocommit(false);
if(!empty($today)){
    $order_time = date('y-m-d');
    foreach($today as $key=>$vo){
        $sql = "select order_id from teacher_order WHERE order_time ='$order_time' AND time_id='$vo' AND status='success'";

        $result = $mySQLi -> query($sql);
        $order_id=array();
        while($row = $res -> fetch_object()){
            $order_id[] = $row;
        }
        if(!empty($order_id)){
            $mySQLi->rollback();
            echo json_encode(array('status'=>401,'msg'=>'已有人抢先下单'));
            return;
        }
        $keyStr = 'order_type,user_id,teacher_id,order_time,time_id,subject,order_place,order_number,meet_address,meet_time';
        $valStr = "'test','$user_id','$teacher_id','$order_time','$vo','$subject','$place','$order_number','$address','$order_time1'";
        $sql="INSERT INTO teacher_order ($keyStr)VALUES ($valStr)";
        $res = $mySQLi -> query($sql);
        if(!$res){
            $mySQLi->rollback();
            echo json_encode(array('status'=>400,'msg'=>'存入订单失败'));
            return;
        }
    }
}
if(!empty($tomorrow)){
    $order_time = date('Y-m-d',strtotime("+ 1 day"));
    foreach($tomorrow as $key=>$vo){
        $sql = "select order_id from teacher_order WHERE order_time ='$order_time' AND time_id='$vo' AND status='success'";
        $result = $mySQLi -> query($sql);
        $order_id=array();
        while($row = $result -> fetch_object()){
            $order_id[] = $row;
        }
        if(!empty($order_id)){
            $mySQLi->rollback();
            echo json_encode(array('status'=>401,'msg'=>'已有人抢先下单'));
            return;
        }
        $keyStr = 'order_type,user_id,teacher_id,order_time,time_id,subject,order_place,order_number,meet_address,meet_time';
        $valStr = "'test','$user_id','$teacher_id','$order_time','$vo','$subject','$place','$order_number','$address','$order_time1'";
        $sql="INSERT INTO teacher_order ($keyStr)VALUES ($valStr)";
        $res = $mySQLi -> query($sql);
        if(!$res){
            $mySQLi->rollback();
            echo json_encode(array('status'=>400,'msg'=>'存入订单失败','sql'=>$sql));
            return;
        }
    }
}
if(!empty($after)){
    $order_time = date('Y-m-d',strtotime("+ 2 day"));
    foreach($after as $key=>$vo){
        $sql = "select order_id from teacher_order WHERE order_time ='$order_time' AND time_id='$vo' AND status='success'";
        $result = $mySQLi -> query($sql);
        $order_id=array();
        while($row = $result -> fetch_object()){
            $order_id[] = $row;
        }
        if(!empty($order_id)){
            $mySQLi->rollback();
            echo json_encode(array('status'=>401,'msg'=>'已有人抢先下单'));
            return;
        }
        $keyStr = 'order_type,user_id,teacher_id,order_time,time_id,subject,order_place,order_number,meet_address,meet_time';
        $valStr = "'test','$user_id','$teacher_id','$order_time','$vo','$subject','$place','$order_number','$address','$order_time1'";
        $sql="INSERT INTO teacher_order ($keyStr)VALUES ($valStr)";
        $res = $mySQLi -> query($sql);
        if(!$res){
            $mySQLi->rollback();
            echo json_encode(array('status'=>400,'msg'=>'存入订单失败','sql'=>$sql));
            return;
        }
    }
}
$mySQLi->commit();
echo json_encode(array('status'=>200,'order'=>$order_number));
return;
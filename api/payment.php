<?php
/**
 * User: 支付回掉
 * Date: 2017/7/31
 * Time: 18:10
 */
/*----------------------------支付接口------------------------------------*/
include_once('database.php');
if(false){//支付失败
    echo json_encode(array('status'=>400,'msg'=>'支付失败'));
    return;
}else{//支付成功，存入支付明细表里
    $order_number=$_GET['order_number'];
    $sql = "select * from school_order WHERE order_number=$order_number";
    $reult = $mySQLi->query($sql);
    $data='';
    while ($info = $reult->fetch_array()) {
        $data= $info['payment_type'];
        $school_id = $info['school_id'];
        $user_id = $info['user_id'];
        $sign_type =$info['sign_type'];
    }
    $time=date('Y-m-d H:i:s');
    $sql="INSERT INTO payment (order_number,time,payment_type,order_type,type) VALUES ('$order_number','$time','$data','school','success')";
    $ress = $mySQLi -> query($sql);
    if(!$ress){
        echo json_encode(array('status'=>400,'msg'=>'存入明细失败'));
        return;
    }
    $sql ="UPDATE `school_order` SET status ='success' WHERE order_number='$order_number'";
    $ret =$mySQLi->query($sql);
    $time = date('Y-m-d H:i:s');
    $sql="INSERT INTO sign (school_id,user_id,time,sign_type) VALUES ('$school_id','$user_id','$time','$sign_type')";
    $res = $mySQLi -> query($sql);
    $mySQLi->close();//关闭数据库
    if($res){
            echo json_encode(array('status'=>200));
    }else{
        echo '保存资料失败，请咨询客服（028）';
    }

}



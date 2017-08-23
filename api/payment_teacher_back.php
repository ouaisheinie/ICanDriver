<?php
/**
 * User: 约教回调接口
 * Date: 2017/8/2
 * Time: 20:18
 */
$order=isset($_GET['order'])?$_GET['order']:'';
$place=isset($_GET['place'])?$_GET['place']:'';
$payment_type=isset($_GET['payment_type'])?$_GET['payment_type']:'';
include_once "database.php";//链接数据库

//接收回掉参数
$time = date('Y-m-d H:i:s');
if(true){//支付成功,修改订单状态,保存支付明细
    $mySQLi->autocommit(false);
    //保存支付明细
    $sql="INSERT INTO payment (order_number,time,payment_type,order_type,type)VALUES ('$order','$time','$payment_type','teacher','success')";
    $res = $mySQLi -> query($sql);
    //修改订单状态
    $sql = "UPDATE teacher_order SET status='success' WHERE order_number='$order'";
    $res1 = $mySQLi -> query($sql);
    //修改教练余额
    $sql = "select teacher_id from teacher_order WHERE order_number='$order'";
    $result = $mySQLi -> query($sql);
    $teacher_id='';
    while($row = $result -> fetch_array()){
        $teacher_id = $row['teacher_id'];
    }
    $sql = "UPDATE teacher SET money=money+'$place' WHERE teacher_id='$teacher_id'";
    $res2= $mySQLi -> query($sql);
    if($res && $res1 && $res2){
        $mySQLi->commit();
       header('location:http://localhost/work/web/index/index.html');
    }else{
        $mySQLi->rollback();
        header('location:http://localhost/work/web/index/index.html');
    }

}else{//支付失败
    echo '支付失败';
}
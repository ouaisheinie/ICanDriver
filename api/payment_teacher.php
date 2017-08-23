<?php
/**
 * User: 约教练支付接口
 * Date: 2017/8/2
 * Time: 20:11
 */
$order=isset($_GET['order'])?$_GET['order']:'';
$place=isset($_GET['place'])?$_GET['place']:'';
$payment_type=isset($_GET['payment_type'])?$_GET['payment_type']:'';

//调用第三方支付接口
if($payment_type=='zfb'){//支付宝接口
    header("location:payment_teacher_back.php?order=$order&place=$place&payment_type=$payment_type");
}else{//微信接口
    header("location:payment_teacher_back.php?order=$order&place=$place&payment_type=$payment_type");
}
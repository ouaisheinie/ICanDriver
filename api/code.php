<?php
/**
 * tep: 登陆验证码短信接口
 * Date: 2017/7/27
 * Time: 13:30
 */
/*----------------------------基础验证------------------------------------*/

include_once('safe.php');//防注入代码
$phone = isset($_POST['phone'])?$_POST['phone']:'';//获取手机号
if($phone == ''){//验证手机号码
    echo json_encode(array('status'=>false,'msg'=>'手机号码不能为空'));
    return;
}

/*----------------------------发送短信------------------------------------*/

include_once('php/api_demo/SmsDemo.php');//引入短信类
$SmsDemo = new SmsDemo();
$code = rand(100000,999999);//生成随机验证码
$response = $SmsDemo->sendSms(
    "齐聚", // 短信签名
    "SMS_79090068", // 短信模板编号
    $phone, // 短信接收者
    Array(  // 短信模板中字段的值
        "code"=>$code,
    )
);
$obj =  json_encode($response);
$arr = json_decode($obj,true);
if($arr['Message']=='OK'){//短信发送成功
    $time=time();
    //把code存入数据库
    include_once 'database.php';
    //查询数据库看是否已给此用户发送过短信
    $sql = "select code_id from code WHERE phone='$phone'";
    $res = $mySQLi -> query($sql);
    $code_id='';
    while($row = $res -> fetch_array()){
        $code_id = $row['code_id'];
    }
    if($code_id!=''){
        $sql = "UPDATE code SET code_num='$code',time=$time WHERE code_id='$code_id'";
    }else{
        $sql = "INSERT INTO code (phone, code_num, code_type,time)VALUES ('$phone', '$code', 'login','$time')";
    }
    $res = $mySQLi -> query($sql);
    $mySQLi->close();//关闭数据库
    if($res){//存入成功
        echo json_encode(array('status'=>true));
    }else{//存入失败
        echo json_encode(array('status'=>false,'msg'=>'验证码存入失败'));
    }
}else{//短信发送失败
    echo json_encode(array('status'=>false,'msg'=>$arr['Message']));
}
<?php
/**
 * 登陆接口
 * Date: 2017/7/27
 * Time: 12:42
 */

/*----------------------------基础验证------------------------------------*/

include_once('safe.php');//防注入代码
$phone = isset($_POST['phone'])?$_POST['phone']:'';//获取手机号
$code = isset($_POST['code'])?$_POST['code']:'';//获取验证码
if($phone=='' or  $code==''){
    echo json_encode(array('status'=>false,'msg'=>'没接收到上传参数'));
    return;
}

/*----------------------------验证码验证------------------------------------*/

include_once "database.php";//链接数据库
$sql = "select code_num,time from code WHERE phone='$phone'";
$res = $mySQLi -> query($sql);
$code_num='';
$time='';
while($row = $res -> fetch_array()){
    $code_num = $row['code_num'];
    $time = $row['time'];
}
if($code_num==''){//如果没查询到验证码
    echo json_encode(array('status'=>false,'msg'=>'没有验证码'));
    return;
}
if($code_num!=$code){//如果验证码不对
    echo json_encode(array('status'=>false,'msg'=>'验证码不对'));
}else{//验证成功
    if((time()-$time)/60>5){//判断是否过期（5分钟过期时间）
        echo json_encode(array('status'=>false,'msg'=>'验证码已过期，请重新获取'));
        return;
    }
    //判断是否是新用户
    $sql = "select * from user WHERE phone='$phone'";
    $res = $mySQLi -> query($sql);
    $token='';
    while($row = $res -> fetch_array()){
        $token = $row['token'];
    }
    if($token==''){//新用户添加数据库
        $token=md5(md5($phone.'end'));//设置token
        $sql="INSERT INTO user (phone, token)VALUES ('$phone', '$token')";
        $res = $mySQLi -> query($sql);
        $mySQLi->close();//关闭数据库
        if($res){//添加成功
            echo json_encode(array('status'=>true,'token'=>$token));
        }else{//添加失败
            echo json_encode(array('status'=>false,'msg'=>'用户添加失败'));
        }
    }else{//老用户返回token
                $sql ="select role_id from user WHERE phone=$phone";
                $info = $mySQLi->query($sql);
                $role_id='';
                while ($ret = $info->fetch_array()) {
                    $role_id = $ret['role_id'];
                }
                echo json_encode(array('status'=>true,'token'=>$token,'role_id'=>$role_id));
               
        }
}




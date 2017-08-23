<?php
/**
 * User:申请教练接口
 * Date: 2017/7/29
 * Time: 7:13
 */
/*----------------------------基础验证------------------------------------*/
/*----------------------------基础验证------------------------------------*/
include_once('safe.php');//防注入代码
$token = isset($_POST['token'])?$_POST['token']:'';//获取token
if($token==''){
    echo json_encode(array('status'=>500,'msg'=>'token不能为空'));
    return;
}

/*----------------------------token验证------------------------------------*/

include_once "database.php";//链接数据库
$name = isset($_POST['name'])?$_POST['name']:'';
$number = isset($_POST['ID_number'])?$_POST['ID_number']:'';
$teacher_number = isset($_POST['teacher_number'])?$_POST['teacher_number']:'';
if($name=='' or $number=='' or $teacher_number==''){
    echo json_encode(array('statues'=>400,'msg'=>'信息不能为空'));
    return;
}
$sql = "select * from user WHERE token='$token'";
$res = $mySQLi -> query($sql);
$user_id='';
$role_id = '';
while($row = $res -> fetch_array()){
    $user_id = $row['user_id'];
    $role_id = $row['role_id'];
}
if($user_id==''){
    echo json_encode(array('status'=>500,'msg'=>'token错误'));
    return;
}


if ($role_id == 1){//判断是否学生
    $sql="SELECT * from apply_teacher WHERE user_id='$user_id' ";
    $rot=$mySQLi -> query($sql);
    $status='';
    while($ow=$rot->fetch_array()){
        $status=$ow['status'];
    }
    if($status=='check'){//判断当前状态
        echo json_encode(array('status'=>400,'msg'=>'审核中'));

    }
   else if($status=='pass'){
        echo json_encode(array('status'=>400,'msg'=>'您已经是教练了'));

    }
   else if($status=='down'){
       echo json_encode(array('status'=>400,'msg'=>'未通过'));

   }
    else{
        $sql="INSERT INTO apply_teacher (`user_id`,`name`, `ID_number`,`teacher_number`,`status`) VALUES ('$user_id','$name', '$number','$teacher_number','check')";
        $res = $mySQLi -> query($sql);
        $mySQLi->close();//关闭数据库
        if($res){//添加成功
            echo json_encode(array('status'=>200));
        }else{//添加失败
            echo json_encode(array('status'=>400,'msg'=>'用户添加失败'));
        }
    }
}
if($role_id == 2){
    echo json_encode(array('status'=>400,'msg'=>'已经是教练'));
}




<?php

/**
 * 学生越教
 * User: Administrator
 * Date: 2017/8/1
 * Time: 14:29
 */



$token = isset($_POST['token'])?$_POST['token']:'';//获取token
if($token==''){
    echo json_encode(array('status'=>500,'msg'=>'token不能为空'));
    return;
}

//$_POST['subject']='科目二';
//$_POST['user_id']='93';
//$_POST['teacher_id']='1';
//$_POST['time_id']='3';
//$_POST['token']='4a34a63294e135f0ef527faab41bc1e0';
/*----------------------------token验证------------------------------------*/

include_once "database.php";//链接数据库
$sql = "select * from user WHERE token='$token'";
$res = $mySQLi -> query($sql);
$user_id='';
$role_id = '';
while($row = $res -> fetch_array()){
    $user_id = $row['user_id'];
    $role_id = $row['role_id'];
}
if($user_id==''){
    echo json_encode(array('status'=>400,'msg'=>'token错误'));
    return;
}


$subject=$_POST['subject'];
$teacher_id=$_POST['teacher_id'];
$time_id=isset($_POST['time_id'])?$_POST['time_id']:'';
$time2=isset($_POST['time2'])?$_POST['time2']:'';
$now=isset($_POST['now'])?$_POST['now']:'';

if($subject==2){

    foreach($time_id as $vo){
        $sql="INSERT INTO teacher_order (`user_id`,`teacher_id`, `subject`,`time_id`,`order_time`) VALUES ('$user_id','$teacher_id', '科目二','$vo','$now')";

        $res = $mySQLi -> query($sql);
        if(!$res){
            echo json_encode(false);
            return;
        }

    }
    foreach($time2 as $vol){
        $sql="INSERT INTO teacher_order (`user_id`,`teacher_id`, `subject`,`time_id`,`order_time`) VALUES ('$user_id','$teacher_id', '科目二','$vol','$now')";
        $res = $mySQLi -> query($sql);
        if(!$res){
            echo json_encode(false);
            return;
        }
    }
}
else if($subject==3){
    foreach($time_id as $vo){
        $sql="INSERT INTO teacher_order (`user_id`,`teacher_id`, `subject`,`time_id`,`order_time`) VALUES ('$user_id','$teacher_id', '科目三','$vo','$now')";
        $res = $mySQLi -> query($sql);
        if($res){
            echo json_encode(array('status'=>200,'msg'=>''));

        }
        else{
            echo json_encode(false);
            return;
        }
    }
    foreach($time2 as $vol){
        $sql="INSERT INTO teacher_order (`user_id`,`teacher_id`, `subject`,`time_id`,`order_time`) VALUES ('$user_id','$teacher_id', '科目三','$vol','$now')";
        $res = $mySQLi -> query($sql);
        if($res){
            echo json_encode(array('status'=>200,'msg'=>''));

        }
        else{
            echo json_encode(false);

            return;
        }
    }
}

//
//$mySQLi->close();//关闭数据库
//if($res){//添加成功
//    echo json_encode(array('status'=>200,'msg'=>'约教成功'));
//}else{//添加失败
//    echo json_encode(array('status'=>400,'msg'=>'用户添加失败'));
//}





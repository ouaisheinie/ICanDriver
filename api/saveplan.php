<?php
/**
 * User: 保存计划
 * Date: 2017/8/2
 * Time: 21:02
 */



//include_once ('safe.php');
$token = isset($_POST['token'])?$_POST['token']:'';//获取token
if($token==''){
    echo json_encode(array('status'=>500,'msg'=>'token不能为空'));
    return;
}
$tomorrow=isset($_POST['tomorrow'])?$_POST['tomorrow']:array();
$after=isset($_POST['after'])?$_POST['after']:array();
$ctomorrow=isset($_POST['ctomorrow'])?$_POST['ctomorrow']:array();
$cafter=isset($_POST['cafter'])?$_POST['cafter']:array();
$today=isset($_POST['today'])?$_POST['today']:array();
$ctoday=isset($_POST['ctoday'])?$_POST['ctoday']:array();

include_once "database.php";//链接数据库
$sql = "select * from user WHERE token='$token'";
$res = $mySQLi -> query($sql);
$user_id='';
$role_id = '';
while($row = $res -> fetch_array()){
    $user_id = $row['user_id'];
    $role_id = $row['role_id'];
}
if($role_id!=2){
    echo 1;
    echo json_encode(array('status'=>400,'msg'=>'不是教练'));
    return;
}
//////////////////////////////////////////////查询teacher_id////////////////////////////////////////
$sql="select * from teacher WHERE user_id='$user_id'";
$res=$mySQLi->query($sql);
$teacher_id='';
while($row=$res->fetch_array()){
    $teacher_id=$row['teacher_id'];
}
$Tclear_date=date('Y-m-d',strtotime('+1 day'));
$Aclear_date=date('Y-m-d ',strtotime('+2 day'));
$mySQLi->autocommit(false);
$date = date('Y-m-d');
if(!empty($tomorrow)){
    foreach($tomorrow as $vo){
        $sql="insert into clear_time (`clear_date`,`teacher_id`,`time_id`) VALUES ('$Tclear_date','$teacher_id','$vo')";
        $res=$mySQLi->query($sql);
        if(!$res){
            $mySQLi->rollback();
            echo json_encode(array('status'=>400,'msg'=>'保存失败'));
            return;
        }
    }
}
if(!empty($after)){
    foreach($after as $vol) {
        $sql = "insert into clear_time (`clear_date`,`teacher_id`,`time_id`) VALUES ('$Aclear_date','$teacher_id','$vol')";
        $res = $mySQLi->query($sql);
        if(!$res){
            $mySQLi->rollback();
            echo json_encode(array('status'=>400,'msg'=>'保存失败'));
            return;
        }
    }
}
if(!empty($today)){
    foreach($today as $vot) {
        $sql = "insert into clear_time (`clear_date`,`teacher_id`,`time_id`) VALUES ('$date','$teacher_id','$vot')";
        $res = $mySQLi->query($sql);
        if(!$res){
            $mySQLi->rollback();
            echo json_encode(array('status'=>400,'msg'=>'保存失败'));
            return;
        }
    }
}
if(!empty($ctoday)){
    foreach($ctoday as $voct) {

        $sql="select * from teacher_order where teacher_id='$teacher_id' AND status='success' AND order_time='$date' AND time_id='$voct'";
        $res=$mySQLi->query($sql);
        $order=array();
        while($row = $res -> fetch_array()){
           $order[]=$row;
        }
        if(!empty($order)){
            $mySQLi->rollback();
            echo json_encode(array('status'=>401,'msg'=>'有约，请刷新'));
        }
        else{
            $sql = "delete from clear_time WHERE clear_date='$date' AND teacher_id='$teacher_id' AND time_id='$voct'";
            $res = $mySQLi->query($sql);
            if(!$res){
                $mySQLi->rollback();
                echo json_encode(array('status'=>400,'msg'=>'保存失败'));
                return;
            }
        }

    }
}
if(!empty($cafter)){
    foreach($cafter as $voa) {

        $sql="select * from teacher_order where teacher_id='$teacher_id' AND status='success' AND order_time='$Aclear_date' AND time_id='$voa'";
        $res=$mySQLi->query($sql);
        $order=array();
        while($row = $res -> fetch_array()){
            $order[]=$row;
        }
        if(!empty($order)){
            $mySQLi->rollback();
            echo json_encode(array('status'=>401,'msg'=>'有约，请刷新'));
        }
        else{
            $sql = "delete from clear_time WHERE clear_date='$Aclear_date' AND teacher_id='$teacher_id' AND time_id='$voa'";
            $res = $mySQLi->query($sql);
            if(!$res){
                $mySQLi->rollback();
                echo json_encode(array('status'=>400,'msg'=>'保存失败'));
                return;
            }
        }

    }
}
if(!empty($ctomorrow)){
    foreach($ctomorrow as $voe) {

        $sql="select * from teacher_order where teacher_id='$teacher_id' AND status='success' AND order_time='$Tclear_date' AND time_id='$voe'";
        $res=$mySQLi->query($sql);
        $order=array();
        while($row = $res -> fetch_array()){
            $order[]=$row;
        }
        if(!empty($order)){
            $mySQLi->rollback();
            echo json_encode(array('status'=>401,'msg'=>'有约，请刷新'));
        }
        else{
            $sql = "delete from clear_time WHERE clear_date='$Tclear_date' AND teacher_id='$teacher_id' AND time_id='$voe'";
            $res = $mySQLi->query($sql);
            if(!$res){
                $mySQLi->rollback();
                echo json_encode(array('status'=>400,'msg'=>'保存失败'));
                return;
            }
        }

    }
}
$mySQLi->commit();
echo json_encode(array('status'=>200));



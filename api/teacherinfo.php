<?php
/**
 * User: 附近教练信息
 * Date: 2017/7/30
 * Time: 12:04
 */
/*----------------------------token验证------------------------------------*/
//echo json_encode($_POST);
//return;
include_once('safe.php');//防注入代码
$token = isset($_POST['token'])?$_POST['token']:'';//获取token
if($token==''){//如果没传token
    echo json_encode(array('status'=>250,'msg'=>'token不能为空'));
    return;
}
include_once "database.php";//链接数据库
$sql = "select * from user WHERE token='$token'";
$res = $mySQLi -> query($sql);
$user_id='';
$role_id='';
while($row = $res -> fetch_array()){
    $user_id = $row['user_id'];
    $role_id = $row['role_id'];
}
if($user_id==''){//token验证失败
    echo json_encode(array('status'=>400,'msg'=>'token错误'));
    return;
}
/*----------------------------教练查询------------------------------------*/
if(isset($_POST['teacher_id'])){
    $date = date('Y-m-d');
    $teacher_id = $_POST['teacher_id'];
    $sql = "select * from teacher WHERE teacher_id ='$teacher_id'";
    $res = $mySQLi -> query($sql);
    $teacher=array();
    while($row = $res -> fetch_object()){
        $teacher[] = $row;
    }


    $sql="select * from clear_time WHERE teacher_id='$teacher_id' AND clear_date>='$date'";
    $res= $mySQLi->query($sql);
    $clear_time=array();
    while($ro=$res->fetch_object()){
        $clear_time[]=$ro;
    }


    $sql="select * from teacher_order WHERE teacher_id='$teacher_id' AND order_time>='$date' AND status='success' AND order_status='conduct'";
    $res= $mySQLi->query($sql);
    $teacher_order=array();
    while($ro=$res->fetch_object()){
        $teacher_order[]=$ro;
    }

    $time = array_merge($clear_time, $teacher_order);

    if(empty($teacher)){
        echo json_encode(array('status'=>400,'msg'=>'未找到数据'));
    }else{
        echo json_encode(array('status'=>200,'time'=>$time,'teacher'=>$teacher[0]));
    }
    return;
}
/*----------------------------判断有无传坐标------------------------------------*/
$gps_j=isset($_POST['gps_j'])?$_POST['gps_j']:'';
$gps_w=isset($_POST['gps_w'])?$_POST['gps_w']:'';
if($gps_j=='' or $gps_w==''){
    echo json_encode(array('status'=>400,'msg'=>'检测不到您的位置'));
    return;
}
/*----------------------------查询数据------------------------------------*/
$distance=500000;//设置范围 50公里内
if($role_id==1){
    $sql = 'select * from (select *, ROUND(6378.138*2*ASIN(SQRT(POW(SIN(('.$gps_w.'*PI()/180-gps_w*PI()/180)/2),2)+COS('.$gps_w.'*PI()/180)*COS(gps_w*PI()/180)*POW(SIN(('.$gps_j.'*PI()/180-gps_j*PI()/180)/2),2)))*1000) AS distance from teacher order by distance ) as a where a.distance<='.$distance;
    $res = $mySQLi -> query($sql);
    $teacher=array();
    while($row = $res -> fetch_object()){
        $teacher[] = $row;
    }
    if(empty($teacher)){
        echo json_encode(array('status'=>400,'msg'=>'未找到数据'));
    }else{
        echo json_encode(array('status'=>200,'data'=>$teacher));
    }
}






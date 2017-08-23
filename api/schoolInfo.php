<?php
/**
 * User: 驾校信息接口
 * Date: 2017/7/28
 * Time: 12:03
 */
/*----------------------------基础验证------------------------------------*/

include_once('token.php');//token验证,验证成功会有$user_id

/*----------------------------学校查询------------------------------------*/

if(isset($_POST['school_id'])){
    $sql = "select * from school WHERE school_id = ".$_POST['school_id'];
    $res = $mySQLi -> query($sql);
    $school=array();
    while($row = $res -> fetch_object()){
        $school[] = $row;
    }
    if(empty($school)){
        echo json_encode(array('status'=>400,'msg'=>'未找到数据'));
    }else{
        echo json_encode(array('status'=>200,'data'=>$school));
    }
    return;
}

/*----------------------------判断有无传坐标------------------------------------*/
$gps_j=isset($_POST['gps_j'])?$_POST['gps_j']:'';
$gps_w=isset($_POST['gps_w'])?$_POST['gps_w']:'';
if($gps_j=='' or $gps_w==''){
    echo json_encode(array('status'=>400,'msg'=>'请传入您的坐标'));
    return;

}


/*----------------------------查询数据------------------------------------*/
$distance=500000;//设置范围 50公里内

$sql = 'select * from (select *, ROUND(6378.138*2*ASIN(SQRT(POW(SIN(('.$gps_w.'*PI()/180-gps_w*PI()/180)/2),2)+COS('.$gps_w.'*PI()/180)*COS(gps_w*PI()/180)*POW(SIN(('.$gps_j.'*PI()/180-gps_j*PI()/180)/2),2)))*1000) AS distance from school order by distance ) as a where a.distance<='.$distance;
$res = $mySQLi -> query($sql);
$school=array();
while($row = $res -> fetch_object()){
    $school[] = $row;
}
if(empty($school)){
    echo json_encode(array('status'=>400,'msg'=>'未找到数据'));
}else{
    echo json_encode(array('status'=>200,'data'=>$school));
}


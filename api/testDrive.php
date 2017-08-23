<?php
/**
 * User: 试驾接口
 * Date: 2017/7/27
 * Time: 21:38
 */
/*----------------------------基础验证------------------------------------*/
include_once('token.php');//token验证,验证成功会有$user_id

/*----------------------------试驾信息保存------------------------------------*/

$address=isset($_POST['address'])?$_POST['address']:'';
$time=isset($_POST['time'])?$_POST['time']:'';
if($address!='' or $time!=''){//如果有试驾信息
    //判断是否已经试驾过
    $sql = "select * from test_drive WHERE user_id='$user_id'";
    $res = $mySQLi -> query($sql);
    $test_id='';
    while($row = $res -> fetch_array()){
        $test_id = $row['test_id'];
    }
    if($test_id==''){//未试驾
        $sql="INSERT INTO test_drive (test_address,test_time,user_id)VALUES ('$address','$time','$user_id')";
        $res = $mySQLi -> query($sql);
        $mySQLi->close();//关闭数据库
        if($res){//保存成功
            echo json_encode(array('status'=>200));
        }else{//保存失败
            echo json_encode(array('status'=>400,'msg'=>'保存试驾信息失败'));
        }
    }else{//已试驾
        echo json_encode(array('status'=>450,'msg'=>'已申报过试驾'));
    }
}else{//如果没有试驾信息
    echo json_encode(array('status'=>400,'msg'=>'试驾信息不完整'));
}




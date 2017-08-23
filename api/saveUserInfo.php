<?php
/**
 * User: 保存实名认证信息接口
 * Date: 2017/7/27
 * Time: 19:32
 */
/*----------------------------基础验证------------------------------------*/
include_once('token.php');//token验证,验证成功会有$user_id

/*----------------------------保存实名信息------------------------------------*/

if(isset($_POST['work'])){
    $arr['work']=$_POST['work'];
}
if(isset($_POST['photo'])){
    $arr['photo']=$_POST['photo'];
}
if(isset($_POST['user_name']) and isset($_POST['id_number'])){
    $arr['user_name'] = $_POST['user_name'];
    $arr['id_number'] = $_POST['id_number'];
    //第三方实名验证接口（暂无）
    if(true){//实名认证通过
        $arr['age']=22;
    }else{//实名认证未通过
        echo json_encode(array('status'=>400,'msg'=>'实名认证失败'));
        return;
    }
}
if(isset($arr)){//如果有参数
    if(isset($arr['age'])){//第一次保存信息
        //得到key value
        $keyStr='';
        $voStr='';
        foreach($arr as $key=>$vo){
            $keyStr.=$key.',';
            $voStr.="'$vo'".',';
        }
        $sql="INSERT INTO user_info ($keyStr"."user_id)VALUES ($voStr"."$user_id)";
    }else{//修改实名信息
        $str='';
        foreach($arr as $key=>$vo){
            $str.=$key.'='."'$vo',";
        }
        $str = substr($str,0,-1);
        $sql = "UPDATE user_info SET $str WHERE user_id='$user_id'";
    }
    $res = $mySQLi -> query($sql);
    $mySQLi->close();//关闭数据库
    if($res){//保存成功
        echo json_encode(array('status'=>200));
    }else{//保存失败
        echo json_encode(array('status'=>400,'msg'=>'信息保存失败'));
    }
}else{//如果没有参数
    echo json_encode(array('status'=>400,'msg'=>'没传更改的信息'));
}

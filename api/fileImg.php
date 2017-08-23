<?php
/**
 * User: 报名资料上传接口
 * Date: 2017/7/30
 * Time: 13:52
 */
/*----------------------------基础验证------------------------------------*/

include_once('token.php');//token验证,验证成功会有$user_id
/*----------------------------获取参数------------------------------------*/
$user_img = isset($_FILES['user_img'])?$_FILES['user_img']:'';//白底照片
$ID_img = isset($_FILES['ID_img'])?$_FILES['ID_img']:'';//身份复印件
$live_img = isset($_FILES['live_img'])?$_FILES['live_img']:'';//居住证
$check_img = isset($_FILES['check_img'])?$_FILES['check_img']:'';//体检单
$receipt_img = isset($_FILES['receipt_img'])?$_FILES['receipt_img']:'';//回执单
$address = isset($_POST['address'])?$_POST['address']:'';//居住地址
$temporary = isset($_POST['temporary '])?$_POST['temporary ']:'';//是否需要暂住证


/*----------------------------上传文件------------------------------------*/
$user_img = saveFile($user_img);
$ID_img = saveFile($ID_img);
$live_img = saveFile($live_img);
$check_img = saveFile($check_img);
$receipt_img = saveFile($receipt_img);
//保存文件
function saveFile($param){
    $imgName = md5($param['tmp_name']).'.jpg';
    if( move_uploaded_file($param['tmp_name'],"./img/$imgName")){
        return $imgName;
    }else{
        return '';
    }
}
/*----------------------------保存信息------------------------------------*/
$sql="INSERT INTO file_img (user_id,user_img,ID_img,live_img,check_img,receipt_img,address,temporary)VALUES ('$user_id','$user_img','$ID_img','$live_img','$check_img','$receipt_img','$address','$temporary')";
$res = $mySQLi -> query($sql);
$mySQLi->close();//关闭数据库
if($res){
    echo json_encode(array('status'=>200));
    header("Location:http://localhost/work/web/sign/sign_up.php?school_id=".$_POST['school_id']);
}else{
    echo json_encode(array(array('status'=>400,'msg'=>'保存失败')));
}



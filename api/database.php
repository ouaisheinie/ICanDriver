<?php
/**
 * tep: 链接数据库
 * Date: 2017/7/27
 * Time: 14:30
 */
header ( 'Content-Type:text/html; charset=utf-8;' );
$mySQLi = new MySQLi('localhost','root','root','new_icandrive',3306);

//判断数据库是否连接
if($mySQLi -> connect_errno){
    die('连接错误' . $mySQLi -> connect_error);
}
//设置字符集
$mySQLi -> set_charset('utf8');



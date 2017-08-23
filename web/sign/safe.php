<?php
/**
 * 防注入代码
 * Date: 2017/7/27
 * Time: 10:37
 */
foreach ($_GET as $get_key=>$get_var)
{
    if (is_numeric($get_var)) {
        $get[strtolower($get_key)] = get_int($get_var);
    } else {
        $get[strtolower($get_key)] = get_str($get_var);
    }
}
/* 过滤所有POST过来的变量 */
foreach ($_POST as $post_key=>$post_var)
{
    if (is_numeric($post_var)) {
        $post[strtolower($post_key)] = get_int($post_var);
    } else {
        $post[strtolower($post_key)] = get_str($post_var);
    }
}
/* 过滤函数 */
//整型过滤函数
function get_int($number)
{
    return intval($number);
}
//字符串型过滤函数
function get_str($string)
{
    if (!get_magic_quotes_gpc()) {
        return addslashes($string);
    }
    return $string;
}

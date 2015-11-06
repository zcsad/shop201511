<?php
/**
 * Created by PhpStorm.
 * User: AD
 * Date: 2015-10-30
 * Time: 16:53
 */

//封装一个提示错误的方法
function showError($model){
    $errors=$model->getError();
    $msg='<ul>';
    if(is_array($errors)){
        foreach ($errors as $v) {
            $msg .= "<li>{$v}</li>";
        }
    }else{ //如果不是数组,直接拼装
        $msg .= "<li>{$errors}</li>";
    }
    $msg.='</ul>';
    return $msg;

}
<?php
/**
 * Created by PhpStorm.
 * User: AD
 * Date: 2015-11-12
 * Time: 0:25
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Verify;

class VerifyController extends Controller
{
    //生成验证码
  public function index(){
      $config = array(
          'imageH' => 0, // 验证码图片高度
          'imageW' => 0, // 验证码图片宽度
          'length' => 4, // 验证码位数
      );
      $verify=new Verify($config);
      $verify->entry();
  }
}
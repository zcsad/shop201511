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
    //������֤��
  public function index(){
      $config = array(
          'imageH' => 0, // ��֤��ͼƬ�߶�
          'imageW' => 0, // ��֤��ͼƬ���
          'length' => 4, // ��֤��λ��
      );
      $verify=new Verify($config);
      $verify->entry();
  }
}
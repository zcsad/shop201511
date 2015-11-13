<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/4
 * Time: 14:19
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Upload;

class UploaderController extends Controller
{
    //接收到上传插件上传上来的文件保存到指定的位置
    public function index(){
        //>>1.接收上传的目录参数
        $dir = I('post.dir');  //brand
        if(!is_dir(ROOT_PATH.'Uploads/'.$dir)){
            //如果Uploads下的目录不存在就创建
            mkdir(ROOT_PATH.'Uploads/'.$dir,0777,true);
        }
        //>>2. 接收上传上来的文件保存到上面指定的目录中
        $config = array(
            'exts'         => array(), //允许上传的文件后缀
            'rootPath'     => './Uploads/', //
//            'rootPath'     => './',//如果使用又拍云,就改到根目录下
            'savePath'     => $dir.'/', //保存路径
            'driver'       => '', // 文件上传驱动
            'driverConfig' => array(), // 上传驱动配置
//            'driverConfig' => array(
//                'host'     => 'v0.api.upyun.com', //又拍云服务器
//                'username' => 'itsource', //又拍云操作员用户
//                'password' => 'itsource', //又拍云操作员密码
//                'bucket'   => 'itsource-'.$dir, //空间名称   //itsource-brand
//                'timeout'  => 90, //超时时间
//            ), // 上传驱动配置
        );
        $uploader = new Upload($config);
        //>>3.将上传后的路径放到$_POST
        $info = $uploader->uploadOne($_FILES['Filedata']);
        if($info!==false){
            echo $info['savepath'].$info['savename'];
        }else{
            echo $uploader->getError();
        }
    }
}
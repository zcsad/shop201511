<?php
header("Content-Type:text/html;charset=utf-8");
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 1.检测PHP环境
if (version_compare(PHP_VERSION, '5.3.0', '<')) {
    die('require PHP > 5.3.0 !');
}
//2.定义项目的运行根目录
define('ROOT_PATH',dirname($_SERVER['SCRIPT_FILENAME']).'/');
//3.将thinkphp的框架目录定义为常量
define('THINK_PATH',dirname(ROOT_PATH).'/ThinkPHP'.'/');
//4. 定义应用目录
define('APP_PATH',ROOT_PATH.'Application'.'/');
//4. 定义运行目录
define('RUNTIME_PATH',ROOT_PATH.'Runtime'.'/');
// 5开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', true);
//6.绑定Admin模块,没有就知道创建  创建成功后就删除
define('BIND_MODULE','Admin');
// 7.引入ThinkPHP入口文件
require THINK_PATH.'ThinkPHP.php';
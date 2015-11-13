<?php
return array(
    //'配置项'=>'配置值'
    //数据库配置
    'DB_TYPE' => 'mysql',
    'DB_HOST' => '127.0.0.1',
    'DB_NAME' => 'shop',
    'DB_USER' => 'root',
    'DB_PWD' => '987654',
    'DB_PORT' => '3306',
    'DB_CHARSET' => 'utf8',
    'DB_DEBUG' => TRUE,

    //开启trace功能,  浏览器右下角显示trace图片  =====>开发模式下开启   上线后把true设置为false
//    'SHOW_PAGE_TRACE' => true,

    //默认分页
    'PAGE_SIZE' => 4,
    'SUPER_USER'             =>'root',
    'NO_CHECK_URL'           =>array('Login/checkLogin','Verify/index'),

    //URL访问模式
//    'URL_MODEL'              => 2,
    // URL伪静态后缀设置
//    'URL_HTML_SUFFIX' => 'html',
    ////////////////////配置Redis为Session的驱动///////////////////////
    'SESSION_AUTO_START' => true,    // 是否自动开启Session
    'SESSION_TYPE' => 'Redis',    //session类型
    'SESSION_PERSISTENT' => 1,        //是否长连接(对于php来说0和1都一样)
    'SESSION_CACHE_TIME' => 1,        //连接超时时间(秒)
    'SESSION_EXPIRE' => 0,        //session有效期(单位:秒) 0表示永久缓存
    'SESSION_PREFIX' => 'sess_',        //session前缀
    'SESSION_REDIS_HOST' => '127.0.0.1', //分布式Redis,默认第一个为主服务器
    'SESSION_REDIS_PORT' => '6379',           //端口,如果相同只填一个,用英文逗号分隔
    // 'SESSION_REDIS_AUTH'    =>  'redis123',    //Redis auth认证(密钥中不能有逗号),如果相同只填一个,用英文逗号分隔

    'COOKEI_DOMAIN' => '.shop.com',//cookie被多个子网站所访问

);
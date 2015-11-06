<?php
define('WEB_URL','http://admin.shop.com');
return array(
    //'配置项'=>'配置值'
    'TMPL_PARSE_STRING'  =>array(
        '__IMG__'=>WEB_URL.'/Public/Admin/images',
        '__CSS__'=>WEB_URL.'/Public/Admin/css',
        '__JS__'=>WEB_URL.'/Public/Admin/js',
		 '__LAYER__' => WEB_URL.'/Public/Admin/layer/layer.js', // 增加新的上传路径替换规则
        '__UPLOADIFY__'=>WEB_URL.'/Public/Admin/uploadify',
    )

);
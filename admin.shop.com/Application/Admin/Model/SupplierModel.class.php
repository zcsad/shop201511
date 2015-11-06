<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/10/30
 * Time: 15:16
 */

namespace Admin\Model;


use Think\Model;

class SupplierModel extends BaseModel
{
    // 自动验证定义
    protected $_validate = array(
        array('name','require','名称不能够为空!'),
        array('name','','名称不能够重复!','','unique'),  //unique表示验证是否唯一
        array('intro','require','简介不能够为空!')
    );


}
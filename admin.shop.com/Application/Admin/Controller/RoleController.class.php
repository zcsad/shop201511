<?php
namespace Admin\Controller;

use Think\Controller;

class RoleController extends BaseController
{
    protected $meta_title = '角色';
    protected $usePostAllParams = true;

//在编辑之前准备数据
    protected function _before_edit_view(){
  //展示数据
        //准备所有的权限数据
        $permissionModel = D('Permission');
        $permissions = $permissionModel->getList();
        $this->assign('nodes',json_encode($permissions));

   //编辑时
        $id = I('get.id');
        if(!empty($id)){
            //准备当前角色已经选择的权限
            $permission_ids  = $this->model->getPermissionIdByRoleId($id);
            //需要的是json数据,转换为json
            $this->assign('permission_ids',json_encode($permission_ids));
        }
    }



}
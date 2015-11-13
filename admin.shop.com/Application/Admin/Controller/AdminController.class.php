<?php
namespace Admin\Controller;

use Think\Controller;

class AdminController extends BaseController
{
    protected $meta_title = '管理员';
    protected $usePostAllParams = true;

//准备所有的角色供用户选择
    public function _before_edit_view()
    {
        //查询展示角色数据
        $roleModel = D('Role');
        $roles = $roleModel->getShowList('id,name');
        $this->assign('roles', $roles);
        //查询展示额外权限数据
        $permissionModel = D('Permission');
        $permissiones = $permissionModel->getList();
        $this->assign('nodes',json_encode($permissiones));

        //在编辑时 根据用户的id找到当前用户的角色
        $id = I('get.id');
        if(!empty($id)){
            //本身权限
            $role_ids  = $this->model->getRoleIdByAdminId($id);
            $this->assign('role_ids',json_encode($role_ids));
            //额外权限
            $permission_ids  = $this->model->getPermissionIdByAdminId($id);
            $this->assign('permission_ids',json_encode($permission_ids));
        }
    }


//重置密码
    public function initPassword($id)
    {
        $result = $this->model->initPassword($id);
        if ($result === false) {
            $this->error('重置密码失败!');
        } else {
            $this->success('重置密码成功!', cookie('__forward__'));
        }
    }
}
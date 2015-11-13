<?php
namespace Admin\Model;


use Think\Model;

class RoleModel extends BaseModel
{
    // 自动验证定义
    protected $_validate = array(
        array('name', 'require', '角色名称不能够为空!'),
        array('status', 'require', '状态不能够为空!'),
        array('sort', 'require', '排序不能够为空!'),
    );

//添加
    public function add($requestData) {
//        dump($requestData);exit;
        //将请求中的数据保存到role表中
        $role_id = parent::add();
        if($role_id===false){
            return false;
        }
        //将用户选中的权限保存到role_permission的关系表中
        $result = $this->handlePermission($role_id,$requestData['permission_ids']);
        if($result===false){
            return false;
        }
        return  $role_id;
    }

//修改更新
    public function save($requestData){
        //需要将this->data中的数据更新到role表中
        $result = parent::save();
//        dump($result);exit;
        if($result===false){
            return false;
        }
        //需要将请求中的权限数据更新到中间表(原来的删除, 现在的添加进去)
        $result1 = $this->handlePermission($requestData['id'],$requestData['permission_ids']);
        if($result1===false){
            return false;
        }
        return $result;
    }

//提取保存方法
    private function handlePermission($role_id,$permission_ids){
        $rows = array();
        foreach($permission_ids as $permission_id){
            $rows[] = array('role_id'=>$role_id,'permission_id'=>$permission_id);
        }
//        dump($rows);exit;
        $rolePermissionModel = M('RolePermission');
        $rolePermissionModel->where(array('role_id'=>$role_id))->delete();
        if(!empty($rows)){
            $result = $rolePermissionModel->addAll($rows);
            if($result===false){
                $this->error = '保存权限失败!';
                return false;
            }
        }
    }


//创建回显时的方法    根据角色的id获取所有的权限id
     public function getPermissionIdByRoleId($role_id){
        $sql  = "select permission_id from role_permission where role_id=".$role_id;
        $rows = $this->query($sql);
        $permission_ids = array_column($rows,'permission_id');
        return $permission_ids;
    }

}
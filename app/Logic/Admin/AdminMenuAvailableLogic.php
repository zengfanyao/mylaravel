<?php
namespace App\Logic\Admin;

class AdminMenuAvailableLogic{

    public static function getAdminMenuList()
    {
        $admin_id = \Jwt::get('admin_info.admin_id');
        $redis_name = 'redis_menu_'.$admin_id;
        $redis_menu_values = \Cache::get($redis_name);
        if(empty($redis_menu_values)){
            // 获取当前用户的角色ID
            $role_id_list = \App\Model\AdminUserRoleModel::where('admin_user_id', '=', $admin_id)
                ->select(['admin_role_id'])
                ->get();
            $list = [];
            if(!$role_id_list->isEmpty()){
                $role_id = [];
                foreach($role_id_list as $val){
                    $role_id[] = $val['admin_role_id'];
                }
                if(in_array('1', $role_id)){
                    $is_admin = 1;
                    // 获取一级菜单
                    $list_first = \App\Model\AdminMenuModel::where('level', '=', 1)
                        ->where('is_on', '=', 1)
                        ->orderBy('order')
                        ->select(['id','name','url','icon','level','parent_id','description','order'])
                        ->get();
                    //var_dump($list_first);
                    if(!$list_first->isEmpty()){
                        // 递归获取子集
                        $list = self::recursionAdminMenuList($list_first,0,$is_admin);
                    }
                }else{
                    $is_admin = 0;
                    // 根据用户的角色获取当前用户的权限
                    $permission_id = \App\Model\AdminRolePermissionModel::whereIn('admin_role_id', $role_id)
                        ->select(['admin_permission_id'])
                        ->get();
                    if(!$permission_id->isEmpty()){
                        $new_permission_id = [];
                        foreach($permission_id as $val){
                            $new_permission_id[] = $val['admin_permission_id'];
                        }
                        $new_permission_id = array_unique($new_permission_id);
                        // 根据当前用户的权限获取当前用户可用的菜单
                        $admin_menu_id = \App\Model\AdminPermissionMenuModel::whereIn('admin_permission_id', $new_permission_id)
                            ->select(['admin_menu_id'])
                            ->get();
                        if(!$admin_menu_id->isEmpty()){
                            $new_admin_menu_id = [];
                            foreach($admin_menu_id as $val){
                                $new_admin_menu_id[] = $val['admin_menu_id'];
                            }
                            // 获取一级菜单
                            $list_first = \App\Model\AdminMenuModel::where('level', '=', 1)
                                ->where('is_on', '=', 1)
                                ->orderBy('order')
                                ->select(['id','name','url','icon','level','parent_id','description','order'])
                                ->get();
                            //var_dump($list_first);
                            if(!$list_first->isEmpty()){
                                // 递归获取子集
                                $list = self::recursionAdminMenuList($list_first,$new_admin_menu_id,$is_admin);
                            }
                        }
                    }
                }
            }
            if(empty($list)){
                $new_list['list'] = [];
                $new_list['data'] = [];
            }else{
                foreach($list as $val){
                    if(isset($val['child'])){
                        if(!empty($val['child'])){
                            $new_list['list'][] = $val;
                        }
                    }
                }
                $new_list['data'] = [];
                \Cache::put($redis_name, $new_list, 5);
            }
        }else{
            $new_list = $redis_menu_values;
        }

        return $new_list;
    }


    /**
     * 递归遍历管理员菜单列表
     * @param array $list 上级菜单的数据
     * @return array
     */
    public static function recursionAdminMenuList($list,$new_admin_menu_id,$is_admin)
    {

        $level = $list[0]->level + 1;

        $list_parent = [];
        foreach($list as $val){
            $list_parent[$val['id']] = $val->toArray();
        }
        if($is_admin == 1){
            $list_child = \App\Model\AdminMenuModel::where('level', '=', $level)
                ->where('is_on', '=', 1)
                ->orderBy('order')
                ->select(['id','name','url','icon','level','parent_id'])
                ->get();
        }else{
            $list_child = \App\Model\AdminMenuModel::whereIn('id', $new_admin_menu_id)
                ->where('level', '=', $level)
                ->where('is_on', '=', 1)
                ->orderBy('order')
                ->select(['id','name','url','icon','level','parent_id'])
                ->get();
        }


        if(!$list_child->isEmpty()){
            $list_child = self::recursionAdminMenuList($list_child,$new_admin_menu_id,$is_admin);
            foreach($list_child as $val){
                $list_parent[$val['parent_id']]['child'][] = $val;
            }
        }
        //var_dump($list_parent);
        return $list_parent;
    }

}
<?php
namespace App\Logic\Admin;

use App\Exceptions\ApiException;

class AdminPermissionLogic
{

    /**
     * 权限列表
     * @param int $data 用于判断的数据
     * @return \App\Model\AdminPermissionModel|\Illuminate\Database\Query\Builder
     */
    public static function getAdminPermissionList($data)
    {
        //$list = [];

        /*if($data['is_all'] == 1){
            $list = [];
            $admin_permission_all = \App\Model\AdminPermissionModel::where('is_on', '=', 1)
                ->select(['id', 'name', 'code', 'description', 'parent_id', 'level','created_at','updated_at'])
                ->get();
            $get_list = [];
            if (!$admin_permission_all->isEmpty()) {
                foreach ($admin_permission_all as $val) {
                    if ($val->level == 1) {
                        $get_list[$val->id] = $val->toArray();
                    } elseif ($val->level == 2) {
                        $get_list[$val->parent_id]['child'][] = $val->toArray();
                    }
                }
            }

            if (!empty($get_list)) {
                foreach ($get_list as $val) {
                    $list[] = $val;
                }
            }
        }else{

        }*/
        //$admin_permission_all=collect($admin_permission_all);

        /**/

        if(isset($data['permission_id'])){
            $list['data'] = \App\Model\AdminPermissionModel::where('id', '=', $data['permission_id'])
                ->where('is_on', '=', 1)
                ->first(['id', 'name']);
            $list['list'] = \App\Model\AdminPermissionModel::where('is_on', '=', 1)
                ->where('parent_id', '=', $data['permission_id'])
                ->select(['id', 'name', 'code', 'description', 'parent_id', 'level','created_at','updated_at'])
                ->paginate(15);
        }else{
            $list['data'] = [];
            $list['list'] = \App\Model\AdminPermissionModel::where('is_on', '=', 1)
                ->where('parent_id', '=', 0)
                ->select(['id', 'name', 'code', 'description', 'parent_id', 'level','created_at','updated_at'])
                ->paginate(15);
        }
        return $list;
    }

    /**
     * 单个权限数据
     * @param int $id 权限ID
     * @return \App\Model\AdminPermissionModel|array|\Illuminate\Database\Query\Builder|null|\stdClass
     * @throws ApiException
     */
    public static function getOneAdminPermission($id)
    {
        $data = \App\Model\AdminPermissionModel::where('id', '=', $id)
            ->where('is_on', '=', 1)
            ->first(['id', 'name', 'code', 'description', 'parent_id', 'level']);

        if (!empty($data)) {
            return $data;
        } else {
            throw new ApiException('你访问的ID有误');
        }

    }

    /**
     * 添加权限
     * @param array $data 添加的权限信息
     * @return bool
     * @throws ApiException
     */
    public static function addAdminPermission($data)
    {
        $admin_permission_model = new \App\Model\AdminPermissionModel();
        set_save_data($admin_permission_model, $data);
        $res = $admin_permission_model->save();
        if (!empty($res)) {
            return true;
        } else {
            throw new ApiException('添加权限失败');
        }
    }

    /**
     * 修改权限
     * @param array $data 修改的数据
     * @param int $id 权限ID
     * @return bool
     * @throws ApiException
     */
    public static function udpateAdminPermission($data, $id)
    {
        /*if (empty($data)) {
            throw new ApiException('你没有修改任何数据');
        }*/
        $res = \App\Model\AdminPermissionModel::where('id', '=', $id)
            ->where('is_on', '=', 1)
            ->update($data);
        if (!empty($res)) {
            return true;
        } else {
            throw new ApiException('修改失败');
        }
    }

    /**
     * 删除权限
     * @param int $id 权限ID
     * @return bool
     * @throws ApiException
     */
    public static function deleteAdminPermission($id)
    {
        $permission = \App\Model\AdminPermissionModel::where('id', '=', $id)
            ->where('is_on', '=', 1)
            ->first(['level']);

        if (!empty($permission)) {
            if ($permission->toArray()['level'] == 1) {
                $res = \App\Model\AdminPermissionModel::where('id', '=', $id)
                    ->orWhere('parent_id', '=', $id)
                    ->update(['is_on' => 0]);
            } else if ($permission->toArray()['level'] == 2) {
                $res = \App\Model\AdminPermissionModel::where('id', '=', $id)
                    ->update(['is_on' => 0]);
            }
        } else {
            $res = [];
            throw new ApiException('删除失败');
        }

        if (!empty($res)) {
            return true;
        } else {
            throw new ApiException('删除失败');
        }
    }
    /**
     * 给权限添加菜单
     * @param array $data 需要添加的数据
     * @param int $admin_permission_id 权限ID
     * @return array
     * @throws ApiException
     */
    public static function addAdminPermissionMenu($data, $admin_permission_id)
    {
        $list = [];
        if(!empty($data)){
            foreach($data as $val){
                $admin_permission_menu_model = new \App\Model\AdminPermissionMenuModel();
                $admin_permission_menu_data = array(
                    'admin_permission_id' => $admin_permission_id,
                    'admin_menu_id' => $val['admin_menu_id']
                );
                set_save_data($admin_permission_menu_model, $admin_permission_menu_data);
                $res = $admin_permission_menu_model->save();
                if(!empty($res)){
                    $list[] = $admin_permission_menu_model->id;
                }else{
                    throw new ApiException('添加失败');
                }
            }
        }else{
            throw new ApiException('添加失败');
        }
        return $list;
    }

    /**
     * 删除权限的菜单
     * @param array $data 要删除的菜单ID数组
     * @param int $admin_permission_id 菜单的ID
     * @return bool
     * @throws ApiException
     */
    public static function deleteAdminPermissionMenu($data, $admin_permission_id)
    {
        if(!empty($data)){
            foreach($data as $val){
                $res = \App\Model\AdminPermissionMenuModel::where('admin_permission_id', '=', $admin_permission_id)
                    ->where('admin_menu_id', '=', $val['admin_menu_id'])
                    ->delete();
            }
            if(!empty($res)){
                return true;
            }else{
                throw new ApiException('删除失败');
            }
        }else{
            throw new ApiException('删除失败');
        }
    }

    /**
     * 获取当前权限的菜单
     * @param int $admin_permission_id 权限ID
     * @return array
     */
    public static function getAdminPermissMenuionList($admin_permission_id)
    {
        $list = [];
        //查询所有的菜单
        $admin_menu_all = \App\Model\AdminMenuModel::where('is_on', '=', 1)
            ->select(['id', 'name', 'parent_id','level'])
            ->get();

        //查询当前权限的关联菜单
        $admin_permission_menu = \App\Model\AdminPermissionMenuModel::where('admin_permission_id', '=', $admin_permission_id)
            ->select(['id','admin_menu_id'])
            ->get();

        $admin_menu_id = [];
        if(!$admin_permission_menu->isEmpty()) {
            //将查询角色权限关联表的数据中的ID存到$admin_menu_id的键中，admin_menu_id存到值
            foreach ($admin_permission_menu as $val) {
                $admin_menu_id[$val->id] = $val->admin_menu_id;
            }
        }

        $get_list = [];
        if (!$admin_menu_all->isEmpty()) {
            foreach ($admin_menu_all as $val) {
                if ($val->level == 1) {
                    $get_list[$val->id] = $val->toArray();
                } elseif ($val->level == 2) {
                    //判断这个菜单是否属于当前权限
                    if(in_array($val->id, $admin_menu_id)){
                        //如果这个菜单属于当前权限，则将关联菜单表的ID存入该菜单数据中传出
                        $admin_permission_menu_id = array_search($val->id, $admin_menu_id);
                        $val->admin_permission_menu_id = $admin_permission_menu_id;
                        $val->is_opt = 1;
                    }else{
                        $val->is_opt = 0;
                    }
                    $get_list[$val->parent_id]['child'][] = $val->toArray();
                }
            }

        }


        if (!empty($get_list)) {
            foreach ($get_list as $val) {
                $list[] = $val;
            }
        }

        return $list;
    }

}
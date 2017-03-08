<?php
namespace App\Logic\Admin;

use App\Exceptions\ApiException;

class AdminRoleLogic
{

    /**
     * 角色列表
     * @return \App\Model\AdminRoleModel|\Illuminate\Database\Query\Builder
     */
    public static function getAdminRoleList()
    {
        $list = \App\Model\AdminRoleModel::where('is_on', '=', 1)
            ->select(['id', 'name', 'description', 'created_at', 'updated_at'])
            ->paginate(15);
        if(!$list->isEmpty()){
            foreach($list as $val){
                if($val->id == 1){
                    $val->is_manage = 0;
                    $val->is_update = 0;
                    $val->is_delete = 0;
                }else{
                    $val->is_manage = 1;
                    $val->is_update = 1;
                    $val->is_delete = 1;
                }
            }
        }

        return $list;
    }

    /**
     * 角色单个数据
     * @param int $id 角色ID
     * @return \App\Model\AdminRoleModel|array|\Illuminate\Database\Query\Builder|null|\stdClass
     * @throws ApiException
     */
    public static function getOneAdminRole($id)
    {
        $data = \App\Model\AdminRoleModel::where('id', '=', $id)
            ->where('is_on', '=', 1)
            ->first(['id', 'name', 'description', 'created_at', 'updated_at']);

        if (!empty($data)) {
            return $data;
        } else {
            throw new ApiException('你的访问信息有误');
        }
    }

    /**
     * 添加角色
     * @param array $data 添加的角色信息
     * @return bool
     */
    public static function addAdminRole($data)
    {
        $admin_role_model = new \App\MOdel\AdminRoleModel();
        set_save_data($admin_role_model, $data);
        $admin_role_model->save();

        return true;
    }

    /**
     * 修改角色
     * @param array $data 修改的角色信息
     * @param int $id 角色ID
     * @return bool
     * @throws ApiException
     */
    public static function updateAdminRole($data, $id)
    {
        if (!empty($data)) {
            $res = \App\Model\AdminRoleModel::where('id', '=', $id)
                ->where('is_on', '=', 1)
                ->update($data);
            if (empty($res)) {
                throw new ApiException('输入非法ID，修改失败');
            }
        } else {
            throw new ApiException('你没有做任何修改');
        }

        return true;
    }

    /**
     * 删除角色
     * @param int $id 角色ID
     * @return bool
     */
    public static function deleteAdminRole($id)
    {
        $res = \App\Model\AdminRoleModel::where('id', '=', $id)
            ->update(['is_on' => 0]);
        if(!empty($res)){
            \App\Model\AdminRolePermissionModel::where('admin_role_id', '=', $id)
                ->delete();
            return true;
        }else{
            throw new ApiException('删除失败');
        }
    }

}
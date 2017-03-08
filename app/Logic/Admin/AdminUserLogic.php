<?php
namespace App\Logic\Admin;

use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Password;

class AdminUserLogic
{

    /**
     * 管理员列表
     * @return \App\Model\AdminUserModel|\Illuminate\Database\Query\Builder
     */
    public static function getAdminUserList()
    {
        $admin_id = \Jwt::get('admin_info')['admin_id'];
        $role_id = \App\Model\AdminUserRoleModel::where('admin_user_id', '=', $admin_id)
            ->select(['admin_role_id'])
            ->get();
        if(!$role_id->isEmpty()){
            $new_role_id = [];
            foreach($role_id as $val){
                $new_role_id[] = $val['admin_role_id'];
            }
        }
        $list = \App\Model\AdminUserModel::where('is_on', '=', 1)
            ->select(['id', 'account', 'name', 'last_login_ip', 'last_login_time','created_at', 'updated_at', 'headimg'])
            ->paginate(15);
        /*foreach($list as $val){
            $admin_user_role = \App\Model\AdminUserRoleModel::where('admin_user_id', $val->id)
        }*/
        if(!$list->isEmpty()){
            foreach($list as $val){
                $role = \App\Model\AdminUserModel::find($val['id'])->roles()->get(['name']);
                $role_name = [];
                //var_dump($role);
                foreach($role as $v){
                    $role_name[] = $v['name'];
                }
                if(in_array('1', $new_role_id)){
                    $val['is_can_delete'] = 1;
                    $val['is_can_update'] = 1;
                    $val['is_can_cat'] = 1;
                }else{
                    $val['is_can_delete'] = 0;
                    $val['is_can_update'] = 0;
                    $val['is_can_cat'] = 0;
                }

                if($admin_id == $val['id']){
                    $val['is_can_delete'] = 0;
                    $val['is_can_cat'] = 1;
                }

                $new_role_name = join(',', $role_name);
                $val['role_name'] = $new_role_name;
                $new_list[] = $val;
            }
        }

        return $list;
    }

    /**
     * 管理员单条数据
     * @param int $id 管理员ID
     * @return \App\Model\AdminUserModel|array|\Illuminate\Database\Query\Builder|null|\stdClass
     * @throws ApiException
     */
    public static function getOneAdminUser($id)
    {
        $data = \App\Model\AdminUserModel::where('is_on', '=', 1)
            ->where('id', '=', $id)
            ->first(['id', 'account', 'name', 'last_login_ip', 'last_login_time', 'updated_at', 'headimg']);

        if (!empty($data)) {
            $role_id = \App\Model\AdminUserRoleModel::where('admin_user_id', '=', $data['id'])
                ->select(['admin_role_id'])
                ->get();
           /* $role_name = [];
            foreach($role as $val){
                $role_name[] = $val['name'];
            }
            $new_role_name = join(',', $role_name);*/
            $data['role_name'] = $role_id;
            return $data;
        } else {
            throw new ApiException('你的访问信息有误');
        }
    }

    /**
     * 添加管理员
     * @param array $data 要添加的数据
     * @return bool
     * @throws ApiException
     */
    public static function addAdminUser($data)
    {

        //验证用户名是否已经被使用
        $verift_admin = \App\Model\AdminUserModel::where('is_on', '=', 1)
            ->where('account', '=', $data['account'])
            ->first(['id']);

        if (!empty($verift_admin)) {
            throw new ApiException('该用户已被注册');
        }

        load_helper('Password');
        $get_password = create_password($data['password'], $salt);

        load_helper('Network');

        \DB::beginTransaction();

        $admin_user_model = new \App\Model\AdminUserModel();
        $get_admin_data = array(
            'headimg' => $data['headimg'],
            'account' => $data['account'],
            'password' => $get_password,
            'salt' => $salt,
            'name' => $data['name'],
            'last_login_ip' => get_client_ip()
        );
        set_save_data($admin_user_model, $get_admin_data);
        $res = $admin_user_model->save();

        // 判断刚添加的管理员是否有加入角色，如果有，则添加角色
        if (isset($data['admin_role_id'])) {
            foreach ($data['admin_role_id'] as $val) {
                $admin_user_role_model = new \App\Model\AdminUserRoleModel();
                $get_admin_user_role_data
                    = array(
                    'admin_user_id' => $admin_user_model->id,
                    'admin_role_id' => $val['value']
                );
                set_save_data($admin_user_role_model, $get_admin_user_role_data);
                $res_tow = $admin_user_role_model->save();
                if(empty($res_tow)){
                    \DB::rollBack();
                    throw new ApiException('数据库错误');
                }
            }
        }

        if (!empty($res)) {
            \DB::commit();
            return true;
        } else {
            \DB::rollBack();
            throw new ApiException('注册失败，请检查自己的注册信息');
        }

    }

    /**
     * 修改管理员信息
     * @param array $data 需要修改的数据
     * @param int $id 管理员ID
     * @throws ApiException
     */
    public static function updateAdminUser($data, $id)
    {
        $admin_id = \Jwt::get('admin_info.admin_id');

        if(isset($data['admin_role_id'])){
            $admin_user_role = \App\Model\AdminUserRoleModel::where('admin_user_id', '=', $id)
                ->select(['admin_role_id'])
                ->get();

            $admin_role_id_on = [];
            if(!$admin_user_role->isEmpty()){
                foreach($admin_user_role as $val){
                    $admin_role_id_on[] = $val["admin_role_id"];
                }
            }

            if(!empty($data['admin_role_id'])){
                //循环遍历传入的角色ID，如果这些ID不存在ID表里，则添加
                foreach($data['admin_role_id'] as $val){
                    if(!in_array($val, $admin_role_id_on)){
                        $admin_user_role_model = new \App\Model\AdminUserRoleModel();
                        $admin_user_role_data = array(
                            'admin_role_id' => $val,
                            'admin_user_id' => $id
                        );
                        set_save_data($admin_user_role_model, $admin_user_role_data);
                        $res = $admin_user_role_model->save();
                        if(empty($res)){
                            throw new ApiException('修改失败');
                        }else{
                            $admin_role_id_on[] = $val;
                        }
                    }
                }

                //循环遍历关联表中的角色ID，如果这些ID不存在传入的数据里，则删除
                foreach($admin_role_id_on as $val){
                    if(!in_array($val, $data['admin_role_id'])){
                        $res = \App\Model\AdminUserRoleModel::where('admin_role_id', '=', $val)
                            ->where('admin_user_id', '=', $id)
                            ->delete();
                        if(empty($res)){
                            throw new ApiException('修改失败');
                        }
                    }
                }
            }
            unset($data['admin_role_id']);
        }

        if (isset($data['password'])) {
            load_helper('Password');
            $get_password = create_password($data['password'], $salt);
            $data['password'] = $get_password;
            $data['salt'] = $salt;
        }

        if ($admin_id == 1) {
            \App\Model\AdminUserModel::where('id', '=', $id)
                ->where('is_on', '=', 1)
                ->update($data);
        } else {
            if ($admin_id == $id) {
                \App\Model\AdminUserModel::where('id', '=', $id)
                    ->where('is_on', '=', 1)
                    ->update($data);
            } else {
                throw new ApiException('你没有修改该用户的权限');
            }
        }
    }

    /**
     * 删除管理员
     * @param int $id 管理员ID
     * @throws ApiException
     */
    public static function deleteAdminUser($id)
    {
        $admin_id = \Jwt::get('admin_info.admin_id');

        if ($admin_id == 1) {
            $res = \App\Model\AdminUserModel::where('id', '=', $id)
                ->update(['is_on' => 0]);
            if(!empty($res)){
                $res_tow = \App\Model\AdminUserRoleModel::where('admin_user_id', '=', $id)
                    ->delete();
                if(!empty($res_tow)){
                    return true;
                }else{
                    throw new ApiException('删除失败');
                }
            }else{
                throw new ApiException('删除失败');
            }
        } else {
            throw new ApiException('你没有删除该用户的权限');
        }
    }
}
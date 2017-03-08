<?php
namespace App\Logic\Admin;

use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Redis;

class AdminMenuLogic{

    /**
     * 管理员菜单列表
     * @return array
     */
    public static function getAdminMenuList($data)
    {
        $admin_id = \Jwt::get('admin_info.admin_id');

        if(isset($data['menu_id'])){
            $new_list['data'] = \App\Model\AdminMenuModel::where('id', '=', $data['menu_id'])
                ->where('is_on', '=', 1)
                ->first(['id', 'name']);
            $new_list['list'] = \App\Model\AdminMenuModel::where('is_on', '=', 1)
                ->where('parent_id', '=', $data['menu_id'])
                ->select(['id','name','url','icon','level','parent_id','description','order'])
                ->paginate(15);
        }else{
            $new_list['data'] = [];
            $new_list['list'] = \App\Model\AdminMenuModel::where('is_on', '=', 1)
                ->where('parent_id', '=', 0)
                ->select(['id','name','url','icon','level','parent_id','description','order'])
                ->paginate(15);
        }

        return $new_list;
    }



    /**
     * 获取一条管理员菜单数据
     * @param int $id 菜单ID
     * @return \App\Model\AdminMenuModel|array|\Illuminate\Database\Query\Builder|null|\stdClass
     * @throws ApiException
     */
    public static function getOneAdminMenu($id)
    {
        $data = \App\Model\AdminMenuModel::where('id', '=', $id)
            ->where('is_on', '=', 1)
            ->first(['id','name','url','icon','level','parent_id','description','order']);

        if(!empty($data)){
            return $data;
        }else{
            throw new ApiException('数据库出错');
        }
    }

    /**
     * 添加管理员菜单
     * @param array $data 要添加的数据
     * @return bool
     * @throws ApiException
     */
    public static function addAdminMenu($data)
    {
        /*if(isset($data['permission_id'])){
            $permission_id = $data['permission_id'];
            unset($data['permission_id']);
        }*/

        $admin_menu_model = new \App\Model\AdminMenuModel();
        set_save_data($admin_menu_model, $data);
        $res = $admin_menu_model->save();
        if(!empty($res)){
            /*if(isset($permission_id)){
                foreach($permission_id as $val){
                    $admin_permission_menu_model = new \App\Model\AdminPermissionMenuModel();
                    $admin_permission_menu_data = array(
                        'admin_permission_id' => $val,
                        'admin_menu_id' => $admin_menu_model->id
                    );
                    set_save_data($admin_permission_menu_model, $admin_permission_menu_data);
                    $res_tow = $admin_permission_menu_model->save();
                    if(empty($res_tow)){
                        \DB::rollBack();
                        throw new ApiException('添加失败');
                    }
                }
                \DB::commit();
                return true;
            }else{
                \DB::commit();
                return true;
            }*/
            return true;
        }else{
            throw new ApiException('添加失败');
        }
    }

    /**
     * 修改管理员菜单
     * @param array $data 要修改的数据
     * @param int $id 菜单ID
     * @return bool
     * @throws ApiException
     */
    public static function updateAdminMenu($data, $id)
    {
        /*if(isset($data['permission_id'])){
            $permission_id = $data['permission_id'];
            unset($data['permission_id']);
            \DB::beginTransaction();
            \App\Model\AdminPermissionMenuModel::where('admin_menu_id', '=', $id)
                ->delete();
            if(!empty($permission_id)){
                foreach($permission_id as $val){
                    $admin_permission_menu_model = new \App\Model\AdminPermissionMenuModel();
                    $admin_permission_menu_data = array(
                        'admin_permission_id' => $val,
                        'admin_menu_id' => $id
                    );
                    set_save_data($admin_permission_menu_model, $admin_permission_menu_data);
                    $res_tow = $admin_permission_menu_model->save();
                    if(empty($res_tow)){
                        \DB::rollBack();
                        throw new ApiException('修改失败');
                    }
                }
                \DB::commit();
            }else{
                \DB::commit();
            }
        }*/

        $res = \App\Model\AdminMenuModel::where('id', '=', $id)
            ->where('is_on', '=', 1)
            ->update($data);

        if(!empty($res)){
            return true;
        }else{
            throw new ApiException('修改失败');
        }

    }

    /**
     * 删除管理员菜单
     * @param int $id 菜单ID
     * @return bool
     * @throws ApiException
     */
    public static function deleteAdminMenu($id)
    {
        $level = \App\Model\AdminMenuModel::where('id', '=', $id)
        ->where('is_on', '=', 1)
        ->first(['level']);
        $res = \App\Model\AdminMenuModel::where('id', '=', $id)
            ->update(['is_on' => 0]);

        if($level->level == 1){
            if(!empty($res)){
                /*$admin_menu_id = \App\Model\AdminMenuModel::where('parent_id', '=', $id)
                    ->where(['is_on' => 0])
                    ->select(['id'])
                    ->get();*/
                $res_tow = \App\Model\AdminMenuModel::where('parent_id', '=', $id)
                    ->update(['is_on' => 0]);
            }
        }

        if(!empty($res)){
            /*\App\Model\AdminPermissionMenuModel::where('admin_menu_id', '=', $id)
                ->delete();
            if(!empty($res_tow)){
                foreach($admin_menu_id as $val){
                    \App\Model\AdminPermissionMenuModel::where('admin_menu_id', '=', $val['id'])
                        ->delete();
                }
            }*/
            return true;
        }else{
            throw new ApiException('删除失败');
        }
    }

}
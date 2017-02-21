<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Model AdminUserRoleModel
 * 
 * @property int $id
 * @property int $admin_user_id
 * @property int $admin_role_id
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminUserRoleModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminUserRoleModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminUserRoleModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminUserRoleModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminUserRoleModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminUserRoleModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminUserRoleModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminUserRoleModel first($columns = ['*'])
 * @package App\Model
 */
class AdminUserRoleModel extends Model
{
    protected $table = 'admin_user_role';
    protected $dateFormat = 'U';

    /**
     * 获取对应数据库链接对象
     * @eg 用于分库分表时获取数据所在的数据库对象
     * @param $id
     * @return object
     */
    /*public static function getShardingConnection($id)
    {
        $mod = $id % 4;
        $model = '\App\Model\Mysql2\User_'.$mod.'Model';

        return new $model;
    }*/

}
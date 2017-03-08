<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Model AdminRolePermissionModel
 *
 * @property int $id
 * @property int $admin_role_id
 * @property int $admin_permission_id
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminRolePermissionModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminRolePermissionModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminRolePermissionModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminRolePermissionModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminRolePermissionModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminRolePermissionModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminRolePermissionModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminRolePermissionModel first($columns = ['*'])

 * @package App\Model
 */
class AdminRolePermissionModel extends Model
{
    protected $table = 'admin_role_permission';
    public $timestamps = false;

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
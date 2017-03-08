<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Model AdminPermissionMenuModel
 *
 * @property int $id
 * @property int $admin_permission_id
 * @property int $admin_menu_id
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminPermissionMenuModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminPermissionMenuModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminPermissionMenuModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminPermissionMenuModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminPermissionMenuModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminPermissionMenuModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminPermissionMenuModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminPermissionMenuModel first($columns = ['*'])

 * @package App\Model
 */
class AdminPermissionMenuModel extends Model
{
    protected $table = 'admin_permission_menu';
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
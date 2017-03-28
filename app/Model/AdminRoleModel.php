<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Model AdminRoleModel
 * 
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $created_at
 * @property int $updated_at
 * @property int $is_on
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminRoleModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminRoleModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminRoleModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminRoleModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminRoleModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminRoleModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminRoleModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminRoleModel first($columns = ['*'])
 * @package App\Model
 */
class AdminRoleModel extends Model
{
    protected $table = 'admin_role';
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

    /**
     * 角色权限
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany('\App\Model\AdminPermissionModel','admin_role_permission','admin_role_id','admin_permission_id');
    }


   /* public function adminMenu()
    {
        return $this->belongsToMany('\App\Model\AdminPermissionMenuModel', 'admin_role_permission', '')
    }*/

}
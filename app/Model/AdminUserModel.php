<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Model AdminUserModel
 * 
 * @property int $id
 * @property string $account
 * @property string $password
 * @property string $salt
 * @property string $name
 * @property string $headimg
 * @property int $last_login_ip
 * @property int $last_login_time
 * @property int $created_at
 * @property int $updated_at
 * @property int $is_on
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminUserModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminUserModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminUserModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminUserModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminUserModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminUserModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminUserModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AdminUserModel first($columns = ['*'])
 * @package App\Model
 */
class AdminUserModel extends Model
{
    protected $table = 'admin_user';
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
     * 用户的角色
     */
    public function roles()
    {
        return $this->belongsToMany('App\Model\AdminRoleModel','admin_user_role','admin_user_id','admin_role_id');
    }
}
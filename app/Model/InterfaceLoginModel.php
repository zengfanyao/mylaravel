<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Model InterfaceLoginModel
 * 
 * @property int $id
 * @property string $test_username
 * @property int $test_user_id
 * @property string $token
 * @property int $created_at
 * @property int $updated_at
 * @property int $is_on
 * @property int $project_id
 * @property int $user_id
 * @property int $first_menu_id
 * @property string $test_account
 * @property string $test_password
 * @property string $test_account_field
 * @property string $test_password_field
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceLoginModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceLoginModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceLoginModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceLoginModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceLoginModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceLoginModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceLoginModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceLoginModel first($columns = ['*'])
 * @package App\Model
 */
class InterfaceLoginModel extends Model
{
    protected $table = 'interface_login';
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
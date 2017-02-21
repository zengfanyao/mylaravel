<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Model UserTokenModel
 * 
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property int $project_id
 * @property int $menu_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $is_on
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserTokenModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserTokenModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserTokenModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserTokenModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserTokenModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserTokenModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserTokenModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserTokenModel first($columns = ['*'])
 * @package App\Model
 */
class UserTokenModel extends Model
{
    protected $table = 'user_token';
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
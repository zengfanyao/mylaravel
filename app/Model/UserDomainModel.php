<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Model UserDomainModel
 * 
 * @property int $id
 * @property int $user_id
 * @property int $project_id
 * @property string $domain
 * @property int $is_acquiescent
 * @property int $is_initial
 * @property int $created_at
 * @property int $updated_at
 * @property int $is_on
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserDomainModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserDomainModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserDomainModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserDomainModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserDomainModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserDomainModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserDomainModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserDomainModel first($columns = ['*'])
 * @package App\Model
 */
class UserDomainModel extends Model
{
    protected $table = 'user_domain';
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
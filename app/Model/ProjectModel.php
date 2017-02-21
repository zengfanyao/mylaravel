<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Model ProjectModel
 * 
 * @property int $id
 * @property string $name
 * @property int $interface_num
 * @property int $user_num
 * @property string $project_url
 * @property int $created_at
 * @property int $updated_at
 * @property int $is_on
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ProjectModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ProjectModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ProjectModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ProjectModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ProjectModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ProjectModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ProjectModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ProjectModel first($columns = ['*'])
 * @package App\Model
 */
class ProjectModel extends Model
{
    protected $table = 'project';
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
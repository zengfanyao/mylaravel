<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Model InterfaceModel
 * 
 * @property int $id
 * @property string $name
 * @property string $request_url
 * @property int $request_mode
 * @property int $is_page
 * @property int $project_id
 * @property int $parent_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $is_on
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceModel first($columns = ['*'])
 * @package App\Model
 */
class InterfaceModel extends Model
{
    protected $table = 'interface';
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
<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Model InterfaceReturnParamModel
 * 
 * @property int $id
 * @property string $return_field
 * @property string $return_data_type
 * @property int $is_must
 * @property string $return_data
 * @property string $return_explain
 * @property int $return_type
 * @property int $return_parent_id
 * @property int $interface_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $is_on
 * @property int $is_grade
 * @property int $first_type
 * @property string $leng
 * @property int $isReadonly
 * @property string $hierarchy
 * @property string $parent_name
 * @property int $project_id
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceReturnParamModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceReturnParamModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceReturnParamModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceReturnParamModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceReturnParamModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceReturnParamModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceReturnParamModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceReturnParamModel first($columns = ['*'])
 * @package App\Model
 */
class InterfaceReturnParamModel extends Model
{
    protected $table = 'interface_return_param';
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
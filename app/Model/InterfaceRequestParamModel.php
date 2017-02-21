<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Model InterfaceRequestParamModel
 * 
 * @property int $id
 * @property string $request_field
 * @property string $request_data_type
 * @property int $is_must
 * @property string $request_data
 * @property string $request_explain
 * @property int $project_id
 * @property int $interface_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $is_on
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceRequestParamModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceRequestParamModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceRequestParamModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceRequestParamModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceRequestParamModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceRequestParamModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceRequestParamModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\InterfaceRequestParamModel first($columns = ['*'])
 * @package App\Model
 */
class InterfaceRequestParamModel extends Model
{
    protected $table = 'interface_request_param';
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
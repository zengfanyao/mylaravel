<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Model UserModel
 * 
 * @property int $id
 * @property string $nickname
 * @property string $headimg
 * @property string $city
 * @property string $province
 * @property string $country
 * @property int $created_at
 * @property int $updated_at
 * @property int $is_on
 *
 * @method static \Illuminate\Database\Query\Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder first($columns = ['*']) * @package App\Model
 */
class UserModel extends Model
{
    protected $table = 'user';
    protected $dateFormat = 'U';

}
<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Model SongArtistModel
 * 
 * @property int $id
 * @property string $name
 * @property int $source_artist_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $is_on
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongArtistModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongArtistModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongArtistModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongArtistModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongArtistModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongArtistModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongArtistModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongArtistModel first($columns = ['*'])
 * @package App\Model
 */
class SongArtistModel extends Model
{
    protected $table = 'song_artist';
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
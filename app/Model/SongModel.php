<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Model SongModel
 * 
 * @property int $id
 * @property string $song_name
 * @property int $artist_id
 * @property int $ablum_id
 * @property string $pic
 * @property string $url
 * @property int $api
 * @property int $source_song_id
 * @property string $source_pic
 * @property string $source_url
 * @property int $is_download
 * @property int $like_num
 * @property int $noliken_num
 * @property int $updated_at
 * @property int $created_at
 * @property int $is_on
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongModel first($columns = ['*'])
 * @package App\Model
 */
class SongModel extends Model
{
    protected $table = 'song';
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
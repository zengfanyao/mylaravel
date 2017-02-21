<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Model SongPlaylistModel
 * 
 * @property int $id
 * @property int $song_id
 * @property int $user_id
 * @property int $like_num
 * @property int $nolike_num
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $is_on
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongPlaylistModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongPlaylistModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongPlaylistModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongPlaylistModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongPlaylistModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongPlaylistModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongPlaylistModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SongPlaylistModel first($columns = ['*'])
 * @package App\Model
 */
class SongPlaylistModel extends Model
{
    protected $table = 'song_playlist';
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
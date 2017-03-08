<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Model ArticleTagRelationsModel
 *
 * @property int $id
 * @property int $article_id
 * @property int $tag_id
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ArticleTagRelationsModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ArticleTagRelationsModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ArticleTagRelationsModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ArticleTagRelationsModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ArticleTagRelationsModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ArticleTagRelationsModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ArticleTagRelationsModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\ArticleTagRelationsModel first($columns = ['*'])

 * @package App\Model
 */
class ArticleTagRelationsModel extends Model
{
    protected $table = 'article_tag_relations';
    public $timestamps = false;

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
<?php
namespace App\Logic\Admin;

use App\Exceptions\ApiException;

class ArticleTagLogic{

    /**
     * 标签列表
     * @return \App\Model\ArticleTagModel|array|\Illuminate\Database\Query\Builder
     */
    public static function getArticleTagList()
    {
        $list = \App\Model\ArticleTagModel::where('is_on', '=', '1')
            ->select(['id','name','updated_at','created_at'])
            ->paginate(15);

        if(empty($list)){
            $list = [];
        }

        return $list;
    }

    /**
     * 标签单条数据
     * @param int $id 标签ID
     * @return \App\Model\ArticleTagModel|array|\Illuminate\Database\Query\Builder|null|\stdClass
     * @throws ApiException
     */
    public static function getOneArticleTag($id)
    {
        $data = \App\Model\ArticleTagModel::where('id', '=', $id)
            ->where('is_on', '=', '1')
            ->first(['id','name']);

        if(!empty($data)){
            return $data;
        }else{
            throw new ApiException('数据库出错');
        }
    }

    /**
     * 添加标签
     * @param array $data 要添加的信息
     * @return bool
     * @throws ApiException
     */
    public static function addArticleTag($data)
    {
        $article_tag_model = new \App\Model\ArticleTagModel();
        set_save_data($article_tag_model, $data);
        $res = $article_tag_model->save();
        if(!empty($res)){
            return true;
        }else{
            throw new ApiException('添加失败');
        }
    }

    /**
     * 标签修改
     * @param array $data 要修改的数据
     * @param int $id 标签ID
     * @return bool
     * @throws ApiException
     */
    public static function updateArticleTag($data, $id)
    {
        $res = \App\Model\ArticleTagModel::where('id', '=', $id)
            ->where('is_on', '=', 1)
            ->update($data);

        if(!empty($res)){
            return true;
        }else{
            throw new ApiException('修改失败');
        }
    }

    /**
     * 标签删除
     * @param int $id 标签ID
     * @return bool
     * @throws ApiException
     */
    public static function deleteArticleTag($id)
    {
        $res = \App\Model\ArticleTagModel::where('id', '=', $id)
            ->update(['is_on' => 0]);

        if(!empty($res)){
            \App\Model\ArticleTagRelationsModel::where('tag_id', '=', $id)
                ->delete();
            return true;
        }else{
            throw new ApiException('删除失败');
        }
    }

}
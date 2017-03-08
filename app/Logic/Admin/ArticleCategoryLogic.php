<?php
namespace App\Logic\Admin;

use App\Exceptions\ApiException;

class ArticleCategoryLogic{

    /**
     * 分类列表
     * @return \App\Model\ArticleTagModel|array|\Illuminate\Database\Query\Builder
     */
    public static function getArticleCategoryList()
    {
        $get_list = \App\Model\ArticleCategoryModel::where('is_on', '=', '1')
            ->select(['id','name','parent_id','updated_at','created_at'])
            ->get();
        $new_list = [];
        if(!$get_list->isEmpty()){
            foreach($get_list as $val){
                if($val->parent_id == 0){
                    $list[$val->id] = $val->toArray();
                }else{
                    $list[$val->parent_id]['child'][] = $val;
                }
            }

            foreach($list as $val){
                if(isset($val['child'])){
                    $child = $val['child'];
                    unset($val['child']);
                    $new_list[] = $val;
                    foreach($child as $v){
                        $v['name'] = '|__'.$v['name'];
                        $new_list[] = $v;
                    }
                }else{
                    $new_list[] = $val;
                }
            }
        }

        return $new_list;
    }

    /**
     * 分类单条数据
     * @param int $id 分类ID
     * @return \App\Model\ArticleTagModel|array|\Illuminate\Database\Query\Builder|null|\stdClass
     * @throws ApiException
     */
    public static function getOneArticleCategory($id)
    {
        $data = \App\Model\ArticleCategoryModel::where('id', '=', $id)
            ->where('is_on', '=', '1')
            ->first(['id','name','parent_id']);

        if(!empty($data)){
            return $data;
        }else{
            throw new ApiException('数据库出错');
        }
    }

    /**
     * 添加分类
     * @param array $data 要添加的信息
     * @return bool
     * @throws ApiException
     */
    public static function addArticleCategory($data)
    {
        $article_category_model = new \App\Model\ArticleCategoryModel();
        set_save_data($article_category_model, $data);
        $res = $article_category_model->save();
        if(!empty($res)){
            return true;
        }else{
            throw new ApiException('添加失败');
        }
    }

    /**
     * 分类修改
     * @param array $data 要修改的数据
     * @param int $id 分类ID
     * @return bool
     * @throws ApiException
     */
    public static function updateArticleCategory($data, $id)
    {
        $res = \App\Model\ArticleCategoryModel::where('id', '=', $id)
            ->where('is_on', '=', 1)
            ->update($data);

        if(!empty($res)){
            return true;
        }else{
            throw new ApiException('修改失败');
        }
    }

    /**
     * 分类删除
     * @param int $id 分类ID
     * @return bool
     * @throws ApiException
     */
    public static function deleteArticleCategory($id)
    {
        $parent_id = \App\Model\ArticleCategoryModel::where('id', '=', $id)
            ->first(['parent_id']);
        $res = \App\Model\ArticleCategoryModel::where('id', '=', $id)
            ->update(['is_on' => 0]);
        if($parent_id->parent_id == 0){
            \App\Model\ArticleCategoryModel::where('parent_id', '=', $id)
                ->update(['is_on' => 0]);
        }

        if(!empty($res)){
            return true;
        }else{
            throw new ApiException('删除失败');
        }
    }

}
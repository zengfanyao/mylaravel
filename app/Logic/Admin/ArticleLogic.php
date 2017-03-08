<?php
namespace App\Logic\Admin;

use App\Exceptions\ApiException;

class ArticleLogic{

    /**
     * 文章列表
     * @param array $data 列表查询条件
     * @return \App\Model\ArticleModel|array|\Illuminate\Database\Query\Builder
     */
    public static function getArticleList($data)
    {
        if(!empty($data)){
            if(isset($data['cat_id'])){
                $cat_id = [['cat_id', '=', $data['cat_id']]];
            }else{
                $cat_id = [];
            }
            if(isset($data['article_tag'])){
                $article_tag = $data['article_tag'];
                $article_target = \App\Model\ArticleTagRelationsModel::whereIn('tag_id', $article_tag)
                    ->select(['article_id'])
                    ->get();

                $new_article_target = [];
                foreach($article_target as $val){
                    $new_article_target[] = $val['article_id'];
                }
                $article_tag = $new_article_target;
            }else{
                $article_tag = [];
            }
            if(isset($data['title'])){
                $title = [['title', 'like', '%'.$data['title'].'%']];
            }else{
                $title = [];
            }
        }else{
            $cat_id = [];
            $title = [];
            $article_tag = [];
        }

        if(empty($article_tag)){
            $list = \App\Model\ArticleModel::where('is_on', '=', 1)
                ->where($cat_id)
                ->where($title)
                ->select(['id','title','author','cover','cat_id'])
                ->paginate(15);
        }else{
            $list = \App\Model\ArticleModel::where('is_on', '=', 1)
                ->where($cat_id)
                ->where($title)
                ->whereIn('id', $article_tag)
                ->select(['id','title','author','cover','cat_id'])
                ->paginate(15);
        }
        //dd($list->items('title'));
        //$list = $list->items();

        if(!$list->isEmpty()){
            foreach($list->items() as $val){
                $tags = \App\Model\ArticleModel::find($val['id'])->tags()->get(['name']);

                if(!$tags->isEmpty()){
                    $tag_name = [];
                    foreach($tags as $v){
                        $tag_name[] = $v['name'];
                    }
                    $new_tag_name = join(',', $tag_name);
                }else{
                    $new_tag_name = '';
                }
                $val['tag_name'] = $new_tag_name;
                //$new_list[] = $val;
            }
        }

        return $list;
    }

    /**
     * 获取文章详情
     * @param int $id 文章ID
     * @return \App\Model\ArticleModel|array|\Illuminate\Database\Query\Builder|null|\stdClass
     * @throws ApiException
     */
    public static function getOneArticle($id)
    {
        $data = \App\Model\ArticleModel::where('id', '=', $id)
            ->where('is_on', '=', 1)
            ->first(['id','title','author','cover','cat_id','content']);

        if(!empty($data)){
            return $data;
        }else{
            throw new ApiException('数据错误');
        }
    }

    /**
     * 添加文章
     * @param array $data 要添加的文章数据
     * @return bool
     * @throws ApiException
     */
    public static function addArticle($data)
    {
        if(isset($data['tag_id'])){
            $tag_id = $data['tag_id'];
            unset($data['tag_id']);
        }

        $article_model = new \App\Model\ArticleModel();
        set_save_data($article_model, $data);
        $res = $article_model->save();
        if(!empty($res)){
            if(isset($tag_id)){
                foreach($tag_id as $val){
                    $article_tag_relations_model = new \App\Model\ArticleTagRelationsModel();
                    $article_tag_relations_data = array(
                        'article_id' => $article_model->id,
                        'tag_id' => $val
                    );
                    set_save_data($article_tag_relations_model, $article_tag_relations_data);
                    $res = $article_tag_relations_model->save();
                    if(empty($res)){
                        throw new ApiException('添加失败');
                    }
                }
            }
            return true;
        }else{
            throw new ApiException('添加失败');
        }
    }

    /**
     * 修改文章信息
     * @param array $data 修改的信息
     * @param int $id 文章ID
     * @return bool
     * @throws ApiException
     */
    public static function updateArticle($data, $id)
    {
        if(isset($data['tag_id'])){
            $tag_id = $data['tag_id'];
            unset($data['tag_id']);
        }
        $res = \App\Model\ArticleModel::where('id', '=', $id)
            ->where('is_on', '=', 1)
            ->update($data);

        if(!empty($res)){
            if(isset($tag_id)){

                $get_article_tag_on = \App\Model\ArticleTagRelationsModel::where('article_id', '=', $id)
                    ->select(['tag_id'])
                    ->get();

                if(!$get_article_tag_on->isEmpty()){
                    $article_tag_on = [];
                    foreach($get_article_tag_on as $val){
                        $article_tag_on[] = $val['tag_id'];
                    }
                }

                //循环遍历传入的标签ID，如果这些ID不存在ID表里，则添加
                foreach($tag_id as $val){
                    if(!in_array($val, $article_tag_on)){
                        $article_tag_relations_model = new \App\Model\ArticleTagRelationsModel();
                        $article_tag_relations_data = array(
                            'article_id' => $id,
                            'tag_id' => $val
                        );
                        set_save_data($article_tag_relations_model, $article_tag_relations_data);
                        $res = $article_tag_relations_model->save();
                        if(empty($res)){
                            throw new ApiException('修改失败');
                        }
                    }
                }

                //循环遍历关联表中的标签ID，如果这些ID不存在传入的数据里，则删除
                foreach($article_tag_on as $val){
                    if(!in_array($val, $tag_id)){
                        $res = \App\Model\ArticleTagRelationsModel::where('tag_id', '=', $val)
                            ->where('article_id', '=', $id)
                            ->delete();
                        if(empty($res)){
                            throw new ApiException('修改失败');
                        }
                    }
                }
            }
            \DB::commit();
            return true;
        }else{
            throw new ApiException('修改失败');
        }
    }

    /**
     * 删除文章
     * @param int $id 文章ID
     * @return bool
     * @throws ApiException
     */
    public static function deleteArticle($id)
    {
        $res = \App\Model\ArticleModel::where('id', '=', $id)
            ->update(['is_on' => 0]);
        if(!empty($res)){
            return true;
        }else{
            throw new ApiException('删除失败');
        }
    }

}
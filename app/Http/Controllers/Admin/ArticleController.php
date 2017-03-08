<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->verify([
            'article_tag' => 'no_required',
            'cat_id' => 'no_required',
            'title' => 'no_required'
        ],'GET');
        $list = \App\Logic\Admin\ArticleLogic::getArticleList($this->verifyData);

        return $this->responseList($list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->verify([
            'title' => '',
            'author' => '',
            'cover' => '',
            'content' => '',
            'cat_id' => 'egnum',
            'tag_id' => 'no_required'
        ],'POST');

        \App\Logic\Admin\ArticleLogic::addArticle($this->verifyData);

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->verifyId($id);

        $data = \App\Logic\Admin\ArticleLogic::getOneArticle($id);

        return $this->response($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->verifyId($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->verifyId($id);

        $this->verify([
            'title' => 'no_required',
            'author' => 'no_required',
            'cover' => 'no_required',
            'content' => 'no_required',
            'cat_id' => 'no_required|egnum',
            'tag_id' => 'no_required'
        ],'POST');

        \App\Logic\Admin\ArticleLogic::updateArticle($this->verifyData, $id);

        return $this->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->verifyId($id);

        \App\Logic\Admin\ArticleLogic::deleteArticle($id);

        return $this->response();
    }
}

<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = \App\Logic\Admin\ArticleCategoryLogic::getArticleCategoryList();

        return $this->responseList($list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->verify([
            'name' => '',
            'parent_id' => 'num:0'
        ],'POST');

        \App\Logic\Admin\ArticleCategoryLogic::addArticleCategory($this->verifyData);

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

        $data = \App\Logic\Admin\ArticleCategoryLogic::getOneArticleCategory($id);

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
            'name' => 'no_required',
            'parent_id' => 'no_required|num:0'
        ],'POST');

        \App\Logic\Admin\ArticleCategoryLogic::updateArticleCategory($this->verifyData, $id);

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

        \App\Logic\Admin\ArticleCategoryLogic::deleteArticleCategory($id);

        return $this->response();
    }
}

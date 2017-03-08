<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->verify([
            'menu_id' => 'egnum|no_required'
        ],'GET');
        $list = \App\Logic\Admin\AdminMenuLogic::getAdminMenuList($this->verifyData);

        return $this->response($list['data'], $list['list']);
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->verify([
            'name' => '',
            'description' => 'no_required',
            'url' => 'no_required',
            'icon' => 'no_required',
            'level' => 'num:0',
            'parent_id' => 'num:0',
            'order' => 'egnum'
        ],'POST');

        \App\Logic\Admin\AdminMenuLogic::addAdminMenu($this->verifyData);

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

        $data = \App\Logic\Admin\AdminMenuLogic::getOneAdminMenu($id);

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
            'description' => 'no_required',
            'url' => 'no_required',
            'icon' => 'no_required',
            'level' => 'no_required',
            'parent_id' => 'num:0|no_required',
            'order' => 'egnum|no_required'
        ],'POST');

        \App\Logic\Admin\AdminMenuLogic::updateAdminMenu($this->verifyData, $id);

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

        \App\Logic\Admin\AdminMenuLogic::deleteAdminMenu($id);

        return $this->response();
    }
}

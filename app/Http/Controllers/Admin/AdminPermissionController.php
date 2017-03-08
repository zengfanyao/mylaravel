<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->verify([
            'permission_id' => 'egnum|no_required'
        ],'GET');
        $list = \App\Logic\Admin\AdminPermissionLogic::getAdminPermissionList($this->verifyData);

        return $this->response($list['data'], $list['list']);
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
            'code' => 'no_required',
            'description' => '',
            'parent_id' => 'num:0',
            'level' => 'in:1:2'
        ],'POST');

        \App\Logic\Admin\AdminPermissionLogic::addAdminPermission($this->verifyData);

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

        $data = \App\Logic\Admin\AdminPermissionLogic::getOneAdminPermission($id);

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
            'code' => 'no_required',
            'description' => 'no_required',
            'parent_id' => 'no_required|num:0',
            'level' => 'no_required|in:1:2'
        ], 'POST');
        //dump($this->verifyData);exit;
        if(isset($this->verifyData)){
            \App\Logic\Admin\AdminPermissionLogic::udpateAdminPermission($this->verifyData, $id);
        }
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

        \App\Logic\Admin\AdminPermissionLogic::deleteAdminPermission($id);

        return $this->response();
    }
}

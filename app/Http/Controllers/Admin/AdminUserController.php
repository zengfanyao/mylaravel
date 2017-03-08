<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = \App\Logic\Admin\AdminUserLogic::getAdminUserList();

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
            'account' => '',
            'password' => '',
            'name' => '',
            'headimg' => '',
            'admin_role_id' => 'no_required'
        ],'POST');

        \App\Logic\Admin\AdminUserLogic::addAdminUser($this->verifyData);

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

        $data = \App\Logic\Admin\AdminUserLogic::getOneAdminUser($id);

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
            'account' => 'no_required',
            'password' => 'no_required',
            'name' => 'no_required',
            'admin_role_id' => 'no_required'
        ],'POST');

        \App\Logic\Admin\AdminUserLogic::updateAdminUser($this->verifyData, $id);

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

        \App\Logic\Admin\AdminUserLogic::deleteAdminUser($id);

        return $this->response();
    }
}

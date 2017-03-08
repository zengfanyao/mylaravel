<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPermissionMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->verify([
            'admin_permission_id' => 'egnum'
        ], 'GET');

        $list = \App\Logic\Admin\AdminPermissionLogic::getAdminPermissMenuionList($this->verifyData['admin_permission_id']);

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
        //
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
            'list.*.admin_menu_id' => 'egnum'
        ],'POST');

        $this->verify([
            'list' => '',
            'is_opt' => 'In:0:1'
        ],'POST');
        $data = $this->verifyData;

        $list = [];
        if($data['is_opt'] == 1){
            $list = \App\Logic\Admin\AdminPermissionLogic::addAdminPermissionMenu($this->verifyData['list'], $id);
        }else if($data['is_opt'] == 0){
            \App\Logic\Admin\AdminPermissionLogic::deleteAdminPermissionMenu($this->verifyData['list'], $id);
        }

        return $this->response($list);
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
    }
}

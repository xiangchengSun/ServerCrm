<?php

namespace Modules\Admin\Http\Controllers\v1;

use Modules\Admin\Http\Requests\AdminAddRequest;
use Modules\Admin\Http\Requests\CommonIdRequest;
use Modules\Admin\Http\Requests\CommonPageRequest;
use Modules\Admin\Http\Requests\CommonStatusRequest;
use Modules\Admin\Http\Requests\UpdateUserPwdRequest;
use Modules\Admin\Services\admin\AdminService;

class AdminController extends BaseApiController
{
    public function index(CommonPageRequest $request)
    {
        return (new AdminService())->index($request->only([
            "size",
            "dept_id",
            "username",
            "phone",
            "status"
        ]));
    }

    public function add(AdminAddRequest $request)
    {
        return (new AdminService())->store($request->only([
            'nickname',
            'username',
            'password',
            'status',
            'email',
            'phone',
            'sex',
            'dept_id',
            'status',
            'remark'
        ]));
    }

    //编辑角色
    public function update(CommonIdRequest $request)
    {
        return (new AdminService())->update($request->get('id'), $request->only([
            'nickname',
            'username',
            'status',
            'email',
            'phone',
            'dept_id',
            'sex',
            'status',
            'remark'
        ]));
    }

    public function updateUserRole(CommonIdRequest $request)
    {
        return (new AdminService())->updateUserRole($request->get('id'), $request->only([
            "role_ids"
        ]));
    }

    //删除用户
    public function del(CommonIdRequest $request)
    {
        return (new AdminService())->del($request->get('id'));
    }


    //用户状态
    public function status(CommonStatusRequest $request)
    {
        return (new AdminService())->update($request->get('id'), $request->only(['status']));
    }

    /**
     *@desc 修改密码
     *
     * @return void
     */
    public function updatePwd(UpdateUserPwdRequest $request)
    {
        return (new AdminService)->updatePassword($request->get('id'), $request->only(['newPwd']));
    }

    /**
     *
     */
    public function getUserInfo(CommonIdRequest $request)
    {
        return (new AdminService)->getUserInfo($request->get('id'));
    }

    /**
     *
     */
    public function getUserRole(CommonIdRequest $request)
    {
        return (new AdminService)->getUserRole($request->get('id'));
    }
}

<?php

namespace Modules\Admin\Http\Controllers\v1;

use Modules\Admin\Http\Requests\CommonIdRequest;
use Modules\Admin\Http\Requests\CommonPageRequest;
use Modules\Admin\Http\Requests\CommonStatusRequest;
use Modules\Admin\Http\Requests\RoleAddRequest;
use Modules\Admin\Services\admin\RoleService;

class RoleController extends BaseApiController
{
    //全部角色
    public function all()
    {
        return (new RoleService())->all();
    }
    //角色列表
    public function index(CommonPageRequest $request)
    {
        return (new RoleService())->index($request->only([
            "size",
            "name",
            "code",
            "status"
        ]));
    }
    //创建角色
    public function add(RoleAddRequest $request)
    {
        return (new RoleService())->store($request->only([
            'name',
            'code',
            'remark'
        ]));
    }

    //编辑角色
    public function update(CommonIdRequest $request)
    {
        return (new RoleService())->update($request->get('id'), $request->only([
            'name',
            'code',
            'remark'
        ]));
    }

    //编辑角色权限
    public function updateRule(CommonIdRequest $request)
    {
        return (new RoleService())->updateRule($request->get('id'), $request->only([
            'rule_ids'
        ]));
    }

    //删除角色
    public function del(CommonIdRequest $request)
    {
        return (new RoleService())->delRole($request->get('id'));
    }

    //部门状态
    public function status(CommonStatusRequest $request)
    {
        return (new RoleService())->update($request->get('id'), $request->only(['status']));
    }

    //获取角色权限
    public function getRoleRule(CommonIdRequest $request)
    {
        return (new RoleService())->getRoleRule($request->get('id'));
    }
}

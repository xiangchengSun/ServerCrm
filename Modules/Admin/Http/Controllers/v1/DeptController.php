<?php

namespace Modules\Admin\Http\Controllers\v1;

use Modules\Admin\Http\Requests\CommonIdRequest;
use Modules\Admin\Http\Requests\CommonStatusRequest;
use Modules\Admin\Http\Requests\DeptAddRequest;
use Modules\Admin\Services\admin\DeptService;

class DeptController extends BaseApiController
{
    // 部门列表
    public function index()
    {
        return (new DeptService())->index();
    }

    //添加部门
    public function add(DeptAddRequest $request)
    {
        return (new DeptService())->store($request->only([
            'name',
            'username',
            'phone',
            'email',
            'pid',
            'sort',
            'status',
            'remark'
        ]));
    }
    //编辑部门
    public function update(CommonIdRequest $request)
    {
        return (new DeptService())->update($request->get('id'), $request->only([
            'name',
            'username',
            'phone',
            'email',
            'pid',
            'sort',
            'status',
            'remark'
        ]));
    }

    //删除部门
    public function del(CommonIdRequest $request)
    {
        return (new DeptService())->delDept($request->get('id'));
    }

    //部门状态
    public function status(CommonStatusRequest $request)
    {
        return (new DeptService())->update($request->get('id'), $request->only(['status']));
    }
}

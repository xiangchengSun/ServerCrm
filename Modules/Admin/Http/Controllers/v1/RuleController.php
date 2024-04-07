<?php

namespace Modules\Admin\Http\Controllers\v1;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Http\Requests\CommonIdRequest;
use Modules\Admin\Http\Requests\RuleAddRequest;
use Modules\Admin\Services\admin\RuleService;

class RuleController extends BaseApiController
{
    // 权限列表
    public function index()
    {
        return (new RuleService())->index();
    }

    //添加权限
    public function add(RuleAddRequest $request)
    {
        // "menu_type",
        // "pid",
        // "name",
        // "path",
        // "rank",
        // "permission",
        // "component",
        // "is_active",
        // "title",
        // "icon",
        // "is_frame_Link",
        // "showLink",
        // "showParent",
        // "keepAlive",
        // "frameSrc",
        // "frameLoading",
        // "transition_enter",
        // "transition_leave",
        //// "is_hidden_tag",
        //// "dynamic_level"
        return (new RuleService())->store($request->only([
            "menuType",
            "pid",
            "title",
            "icon",
            "name",
            "path",
            "rank",
            "redirect",
            "component",
            "extraIcon",
            "enterTransition",
            "leaveTransition",
            "auths",
            "activePath",
            "frameSrc",
            "frameLoading",
            "keepAlive",
            "hiddenTag",
            "showLink",
            "showParent"
        ]));
    }

    //编辑部门
    public function update(CommonIdRequest $request)
    {
        return (new RuleService())->update($request->get('id'), $request->only([
            // "menu_type",
            // "pid",
            // "name",
            // "path",
            // "rank",
            // "permission",
            // "component",
            // "is_active",
            // "title",
            // "icon",
            // "is_frame_Link",
            // "showLink",
            // "showParent",
            // "keepAlive",
            // "frameSrc",
            // "frameLoading",
            // "transition_enter",
            // "transition_leave",
            "menuType",
            "pid",
            "title",
            "icon",
            "name",
            "path",
            "rank",
            "redirect",
            "component",
            "extraIcon",
            "enterTransition",
            "leaveTransition",
            "auths",
            "activePath",
            "frameSrc",
            "frameLoading",
            "keepAlive",
            "hiddenTag",
            "showLink",
            "showParent"
        ]));
    }
}

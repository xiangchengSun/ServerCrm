<?php

namespace Modules\Admin\Http\Controllers\v1;

use Illuminate\Routing\Controller;
use Modules\Admin\Http\Requests\CommonIdRequest;
use Modules\Admin\Http\Requests\PwdRequest;
use Modules\Admin\Services\admin\UpdatePasswordService;
use Modules\Admin\Services\auth\MenuService;
use Modules\Admin\Services\auth\TokenService;

class IndexController extends Controller
{
    /**
     *@desc 刷新token
     *
     * @return void
     */
    public function refreshToken()
    {
        return (new TokenService)->refreshToken();
    }

    /**
     *@desc 获取用户信息
     *
     * @return void
     */
    public function userInfo()
    {
        return (new TokenService)->UserInfo();
    }

    /**
     * @desc 退出登录
     */
    public function logout()
    {
        return (new TokenService)->logout();
    }

    /**
     *@desc 修改密码
     *
     * @return void
     */
    public function updatePwd(PwdRequest $request)
    {
        return (new UpdatePasswordService)->updatePassword($request->only(['old_password', 'password']));
    }

    /**
     *@desc 获取模型
     *
     * @return void
     */
    public function getModel()
    {
        return (new MenuService())->getModel();
    }

    public function getMenu()
    {
        return (new MenuService())->getMenu();
    }
}

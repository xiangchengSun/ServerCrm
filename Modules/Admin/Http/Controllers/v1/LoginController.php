<?php

namespace Modules\Admin\Http\Controllers\v1;

use Modules\Admin\Http\Requests\LoginRequest;
use Modules\Admin\Services\auth\LoginService;

class LoginController extends BaseApiController
{
    /**
     * @name 登陆
     *
     * @param LoginRequest $request
     * @return json
     */
    public function login(LoginRequest $request)
    {
        return (new LoginService())->login($request->only([
            'username',
            'password'
        ]));
    }
}

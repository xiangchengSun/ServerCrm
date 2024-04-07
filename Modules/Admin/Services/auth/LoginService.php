<?php

namespace Modules\Admin\Services\auth;

use Illuminate\Support\Facades\Auth;
use Modules\Admin\Models\AuthAdmin;
use Modules\Admin\Services\BaseApiService;
use Modules\Admin\Services\auth\TokenService;

class LoginService extends BaseApiService
{
    /**
     * 登录
     * @param $data 用户登录信息
     * @return JSON
     */
    public function login(array $data)
    {
        if (true == Auth::guard('auth_admin')->attempt($data)) {
            $userInfo = AuthAdmin::where(['username' => $data['username']])->select('id', 'username', 'nickname', 'avatar', 'role_ids', 'is_super', 'status')->first();
            if ($userInfo) {
                $userInfo = $userInfo->toArray();
                $userInfo['password'] = $data['password'];
                $token = (new TokenService())->setToken($userInfo);
                $token['username'] = $userInfo['username'];
                $token['avatar'] = $userInfo['avatar'];
                $token['roles'] = [];
                return $this->apiSuccess('登录成功！', $token);
            }
        }
        return $this->apiError('用户名或密码错误');
    }
}

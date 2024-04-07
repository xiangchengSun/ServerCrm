<?php

namespace Modules\Admin\Services\auth;

use Illuminate\Support\Facades\Config;
use Modules\Admin\Services\BaseApiService;
use Modules\Common\Exceptions\ApiException;
use Modules\Common\Exceptions\MessageData;
use Modules\Common\Exceptions\StatusData;
use PhpParser\Node\Expr\Cast\Object_;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

class TokenService extends BaseApiService
{

    public function __construct()
    {
        \Config::set('auth.defaults.guard', 'auth_admin');
        \Config::set('jwt.ttl', 60);
    }
    /**
     * 获取token
     * @param $username
     * @param $password
     * @return mixed
     */
    public function setToken(array $data): array
    {
        if (!$token = JWTAuth::attempt($data)) {
            $this->apiError('token生成失败');
        }
        return $this->respondWithToken($token);
    }

    /**
     * @name 组合token数据
     * @description
     * @return Array
     **/
    protected function respondWithToken($token): array
    {
        return [
            'accessToken' => $token,
            'token_type' => 'bearer',
            'expires' => date("Y-m-d H:i:s", time() + JWTAuth::factory()->getTTL() * 60)
        ];
    }

    /**
     * @name 刷新token
     * @description
     * @return JSON
     **/
    public function refreshToken()
    {
        try {
            $old_token = JWTAuth::getToken();
            $token = JWTAuth::parseToken()->refresh($old_token);
        } catch (TokenBlacklistedException $e) {
            throw new ApiException(['status' => StatusData::TOKEN_ERROR_BLACK, 'message' => MessageData::TOKEN_ERROR_BLACK]);
        }
        return $this->apiSuccess('', $this->respondWithToken($token));
    }

    /**
     * @name  管理员信息
     *
     * @return void
     */
    public function UserInfo()
    {
        $data = $this->my();
        return $this->apiSuccess('', ['username' => $data['username'], 'id' => $data['id'], 'nickname' => $data['nickname'], 'avatar' => $data['avatar'], 'is_super' => $data['is_super'], 'status' => $data['status']]);
    }

    public function my(): Object
    {
        return JWTAuth::parseToken()->touser();
    }

    /*
     * @name 退出登录
     *
     */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return $this->apiSuccess('退出登录成功');
    }
}

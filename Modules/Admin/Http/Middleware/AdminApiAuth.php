<?php

/**后台权限验证中间件
 *
 */

namespace Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Modules\Common\Exceptions\ApiException;
use Modules\Common\Exceptions\MessageData;
use Modules\Common\Exceptions\StatusData;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Modules\Admin\Services\log\LogService;

class AdminApiAuth
{

    public function handle($request, Closure $next)
    {
        Config::set('auth.defaults.guard', 'auth_admin');
        Config::set('jwt.ttl', 60);
        $route_data = $request->route();
        $url = str_replace($route_data->getAction()['prefix'] . '/', "", $route_data->uri);
        $url_arr = ['login/login', 'index/getMain', 'index/refreshToken']; //,
        $api_key = $request->header('api-key');
        if ($api_key != config('admin.api_key')) {
            throw new ApiException(['status' => StatusData::TOKEN_ERROR_KEY, 'message' => MessageData::TOKEN_ERROR_KEY]);
            return $next();
        }
        if (!in_array($url, $url_arr)) {
            try {
                if (!$user = JWTAuth::parseToken()->authenticate()) {  //获取到用户数据，并赋值给$user   'msg' => '用户不存在'
                    throw new ApiException(['status' => StatusData::TOKEN_ERROR_SET, 'message' => MessageData::TOKEN_ERROR_SET]);
                    return $next();
                }
            } catch (TokenBlacklistedException $e) {
                // 这个时候是老的token被拉到黑名单了
                throw new ApiException(['status' => StatusData::TOKEN_ERROR_BLACK, 'message' => MessageData::TOKEN_ERROR_BLACK]);
                return $next();
            } catch (TokenExpiredException $e) {
                //token已过期
                throw new ApiException(['status' => StatusData::TOKEN_ERROR_EXPIRED, 'message' => MessageData::TOKEN_ERROR_EXPIRED]);
                return $next();
            } catch (TokenInvalidException $e) {
                //token无效
                throw new ApiException(['status' => StatusData::TOKEN_ERROR_JWT, 'message' => MessageData::TOKEN_ERROR_JWT]);
                return $next();
            } catch (JWTException $e) {
                //'缺少token'
                throw new ApiException(['status' => StatusData::TOKEN_ERROR_JTB, 'message' => MessageData::TOKEN_ERROR_JTB]);
                return $next();
            }
        }
        $respone = $next($request);

        // 写入日志
        if (!in_array($url, ['login/login', 'index/refreshToken', 'index/getAsyncRoutes']) && $user['id']) {
            (new LogService())->store($user['id'], $respone->getContent());
        }
        return $respone;
    }
}

<?php

namespace Modules\Admin\Services\admin;

use Illuminate\Support\Facades\Auth;
use Modules\Admin\Models\AuthAdmin;
use Modules\Admin\Services\auth\TokenService;
use Modules\Admin\Services\BaseApiService;

class UpdatePasswordService extends BaseApiService
{
    /**
     * 更新密码
     * @param $data
     * @return array
     */
    public function updatePassword($data)
    {
        $userInfo = (new TokenService())->my();
        if (true == Auth::guard('auth_admin')->attempt(['username' => $userInfo['username'], 'password' => $data['old_password']])) {
            if (AuthAdmin::where('id', $userInfo['id'])->update(['password' => bcrypt($data['password'])])) {
                return $this->apiSuccess('修改成功！');
            }
            $this->apiError('修改失败！');
        }
        $this->apiError('原密码错误！');
    }
}

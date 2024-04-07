<?php

namespace Modules\Admin\Services\admin;

use Modules\Admin\Models\AuthAdmin as AuthAdminModel;
use Modules\Admin\Models\AuthRole;
use Modules\Admin\Services\BaseApiService;

class AdminService  extends BaseApiService
{
    // 实现用户列表的逻辑
    public function index($data)
    {
        $model = AuthAdminModel::query();
        $model = $this->queryCondition($model, $data);
        if (!empty($data['phone'])) {
            $model = $model->where('name', 'like', '%' . $data['name'] . '%');
        }
        if (!empty($data['dept_id'])) {
            $dept_ids = (new DeptService())->getDeptids($data['dept_id']);
            $model = $model->whereIn('dept_id', $dept_ids);
        }

        $list = $model->orderBy('id', 'desc')
            ->paginate($data['size'])->toArray();
        return $this->apiSuccess('', [
            'list' => $list['data'],
            'total' => $list['total'],
            'pageSize' => $list['per_page'],
            'currentPage' => $list['current_page']
        ]);
    }

    // 实现角色添加的逻辑
    public function store($data)
    {
        $model = AuthAdminModel::query();
        $only_admin = $model->where('username', "=", $data['username'])
            ->exists();
        if ($only_admin) {
            $this->apiError('已存在相同用户名称');
        }
        $data['password'] = bcrypt($data['password']);
        return $this->commonCreate($model, $data);
    }

    /**
     * @name 修改
     *
     * @param integer $id
     * @param array $data
     * @return void
     */
    public function update(int $id, array $data)
    {
        return $this->commonStatusUpdate(AuthAdminModel::query(), $id, $data);
    }

    /**
     * @name 修改
     *
     * @param integer $id
     * @param array $data
     * @return void
     */
    public function updateUserRole(int $id, array $data)
    {
        $data['role_ids'] = implode('|', $data['role_ids']);
        return $this->commonStatusUpdate(AuthAdminModel::query(), $id, $data);
    }

    /**
     * @name 删除
     *
     * @param integer $id
     * @return void
     */
    public function del(int $id)
    {
        $model = AuthAdminModel::query();
        $only_admin = $model->find($id);
        if ($only_admin->is_super == 1) {
            $this->apiError('该账号不允许删除');
        }
        $idArr = [$id];
        return $this->commonDestroy(AuthAdminModel::query(), $idArr);
    }

    /**
     * 更新密码
     * @param $data
     * @return array
     */
    public function updatePassword(int $id, array $data)
    {
        $data['password'] = bcrypt($data['newPwd']);
        unset($data['newPwd']);
        return $this->commonStatusUpdate(AuthAdminModel::query(), $id, $data);
    }

    /**
     * @name 获取用户信息
     *
     * @param integer $id
     * @return void
     */
    public function getUserInfo(int $id)
    {
        $model = AuthAdminModel::query();
        $userInfo = $model->find($id)->toArray();
        if (!$userInfo) {
            $this->apiError('用户不存在');
        }
        $userInfo['password'] = '';
        return $this->apiSuccess('', $userInfo);
    }


    public function getUserRole(int $id)
    {
        $model = AuthAdminModel::query();
        $userInfo = $model->find($id)->toArray();
        if (!$userInfo) {
            $this->apiError('用户不存在');
        }
        $role_ids = explode('|', $userInfo['role_ids']);
        return $this->apiSuccess('', $role_ids);
    }
}

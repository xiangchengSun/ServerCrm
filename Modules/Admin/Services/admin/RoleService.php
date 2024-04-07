<?php

namespace Modules\Admin\Services\admin;

use Modules\Admin\Models\AuthRole as RoleModel;
use Modules\Admin\Services\BaseApiService;

class RoleService extends BaseApiService
{
    public function all()
    {
        $list = RoleModel::orderBy('id', 'desc')
            ->get()
            ->toArray();
        return $this->apiSuccess('', $list);
    }

    // 实现角色列表的逻辑
    public function index($data)
    {
        $model = RoleModel::query();
        $model = $this->queryCondition($model, $data);
        if (!empty($data['name'])) {
            $model = $model->where('name', 'like', '%' . $data['name'] . '%');
        }
        if (!empty($data['code'])) {
            $model = $model->where('code', $data['code']);
        }

        if (isset($data['status']) && $data['status'] != '') {
            $model = $model->where('status', $data['status']);
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
        $model = RoleModel::query();
        $only_dept = $model->where('name', "=", $data['name'])
            ->exists();
        if ($only_dept) {
            $this->apiError('角色名称已存在');
        }
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
        return $this->commonStatusUpdate(RoleModel::query(), $id, $data);
    }

    /**
     * @name 修改权限
     *
     * @param integer $id
     * @param array $data
     * @return void
     */
    public function updateRule(int $id, array $data)
    {
        $data['rules'] = implode('|', $data['rule_ids']);
        unset($data['rule_ids']);
        return $this->commonStatusUpdate(RoleModel::query(), $id, $data);
    }

    /**
     * @name 删除
     *
     * @param integer $id
     * @return void
     */
    public function delRole(int $id)
    {
        $idArr[] = $id;
        return $this->commonDestroy(RoleModel::query(), $idArr);
    }


    public function getRoleRule(int $id)
    {
        $model = RoleModel::query();
        $roleInfo = $model->find($id)->toArray();
        if (!$roleInfo) {
            $this->apiError('角色不存在');
        }
        $rule_ids = array_map('intval', explode('|', $roleInfo['rules']));
        return $this->apiSuccess('', $rule_ids);
    }
}

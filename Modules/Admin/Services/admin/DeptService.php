<?php

namespace Modules\Admin\Services\admin;

use Modules\Admin\Models\AuthDept as DeptModel;
use Modules\Admin\Services\BaseApiService;

class DeptService extends BaseApiService
{
    public function index()
    {
        $list = DeptModel::orderBy('sort', 'asc')
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();
        return $this->apiSuccess('', $list);
    }
    /**
     * @name 保存
     *
     * @param array $data
     * @return void
     */
    public function store(array $data)
    {
        $model = DeptModel::query();
        $only_dept = $model->where('pid', "=", $data['pid'])
            ->where('name', "=", $data['name'])
            ->exists();
        if ($only_dept) {
            $this->apiError('已存在相同部门');
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
        return $this->commonStatusUpdate(DeptModel::query(), $id, $data);
    }

    /**
     * @name 获取当前部门及所有子部门
     *
     * @param integer $id
     * @return void
     */
    public function getDeptids(int $id)
    {
        $idArr = $this->ids($id);
        return $idArr;
    }

    /**
     * @name 删除
     *
     * @param integer $id
     * @return void
     */
    public function delDept(int $id)
    {
        $idArr = $this->ids($id);
        return $this->commonDestroy(DeptModel::query(), $idArr);
    }

    private function ids(int $id): array
    {
        $dept = DeptModel::select('id', 'pid')->get()->toArray();
        $arr = $this->delSort($dept, $id);
        $arr[] = $id;
        return $arr;
    }
    public function delSort(array $dept, int $id): array
    {
        //创建新数组
        static $arr = array();
        foreach ($dept as $k => $v) {
            if ($v['pid'] == $id) {
                $arr[] = $v['id'];
                unset($dept[$k]);
                $this->delSort($dept, $v['id']);
            }
        }
        return $arr;
    }
}

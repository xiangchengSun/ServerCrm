<?php

namespace Modules\Admin\Services\admin;

use Modules\Admin\Models\AuthRule;
use Modules\Admin\Services\BaseApiService;

class RuleService extends BaseApiService
{
    public function index()
    {
        $list = AuthRule::orderBy('rank', 'asc')
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();
        return $this->apiSuccess('', $list);
    }

    // 实现角色添加的逻辑
    public function store($data)
    {
        $model = AuthRule::query();
        if ($data['menuType'] != 3) {
            $only_rule = $model->where('name', "=", $data['name'])
                ->exists();
            if ($only_rule) {
                $this->apiError('权限名称已存在');
            }
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
        return $this->commonStatusUpdate(AuthRule::query(), $id, $data);
    }

    /**
     * @name 格式化权限目录
     *
     * @param [type] $data
     * @return void
     */
    public function treeRules($data)
    {
        $items = array();
        foreach ($data as $v) {
            $items[$v['id']] = $v;
        }
        $tree = array();
        // foreach ($items as $k => $item) {
        //     $items[$k]['meta'] = [
        //         'title' => $item['title'],
        //         'icon' => $item['icon'],
        //         'rank' => $item['rank'],
        //         'showLink' => boolval($item['showLink']),
        //         'showParent' => boolval($item['showParent']),
        //         'keepAlive' => boolval($item['keepAlive']),
        //         'hiddenTag' => false,
        //         'dynamicLevel' => 0
        //     ];

        //     if (!empty($item['transition_leave'])) {
        //         $items[$k]['meta']['transition']['leaveTransition'] = 'animate__' . $item['transition_leave'];
        //     }
        //     if (!empty($item['transition_enter'])) {
        //         $items[$k]['meta']['transition']['enterTransition'] = 'animate__' . $item['transition_enter'];
        //     }
        //     if ($item['is_frame_link']) {
        //         $items[$k]['meta']['frameSrc'] = $item['frameSrc'];
        //         $items[$k]['meta']['frameLoading'] = boolval($item['frameLoading']);
        //     }
        //     unset($items[$k]['title']);
        //     unset($items[$k]['icon']);
        //     unset($items[$k]['showLink']);
        //     unset($items[$k]['showParent']);
        //     unset($items[$k]['keepAlive']);
        //     unset($items[$k]['transition_leave']);
        //     unset($items[$k]['transition_enter']);
        //     unset($items[$k]['leaveTransition']);
        //     unset($items[$k]['is_frame_link']);
        //     unset($items[$k]['frameSrc']);
        //     unset($items[$k]['frameLoading']);
        //     unset($items[$k]['rank']);

        //     if (isset($items[$item['pid']])) {
        //         if ($item['menu_type'] == 2) {
        //             $items[$item['pid']]['meta']['auths'][] = $item['permission'];
        //         } else {
        //             unset($items[$k]['permission']);
        //             $items[$item['pid']]['children'][] = &$items[$k];
        //         }
        //     } else {
        //         $tree[] = &$items[$k];
        //     }
        // }
        foreach ($items as $k => $item) {
            $items[$k]['meta'] = [
                'title' => $item['title'],
                'icon' => $item['icon'],
                'extraIcon' => $item['extraIcon'],
                'rank' => $item['rank'],
                'showLink' => boolval($item['showLink']),
                'showParent' => boolval($item['showParent']),
                'keepAlive' => boolval($item['keepAlive']),
                'hiddenTag' => boolval($item['hiddenTag']),
                'dynamicLevel' => 0
            ];

            if (!empty($item['leaveTransition'])) {
                $items[$k]['meta']['transition']['leaveTransition'] = 'animate__' . $item['transition_leave'];
            }
            if (!empty($item['enterTransition'])) {
                $items[$k]['meta']['transition']['enterTransition'] = 'animate__' . $item['transition_enter'];
            }
            $items[$k]['meta']['frameSrc'] = $item['frameSrc'];
            $items[$k]['meta']['frameLoading'] = boolval($item['frameLoading']);
            unset($items[$k]['title']);
            unset($items[$k]['icon']);
            unset($items[$k]['extraIcon']);
            unset($items[$k]['showLink']);
            unset($items[$k]['showParent']);
            unset($items[$k]['keepAlive']);
            unset($items[$k]['leaveTransition']);
            unset($items[$k]['enterTransition']);
            unset($items[$k]['leaveTransition']);
            unset($items[$k]['frameSrc']);
            unset($items[$k]['frameLoading']);
            unset($items[$k]['rank']);
            unset($items[$k]['hiddenTag']);

            if (isset($items[$item['pid']])) {
                if ($item['menuType'] == 3) {
                    $items[$item['pid']]['meta']['auths'][] = $item['auths'];
                } else {
                    $items[$item['pid']]['children'][] = &$items[$k];
                }
            } else {
                unset($items[$k]['auths']);
                $tree[] = &$items[$k];
            }
        }
        return $tree;
    }
}

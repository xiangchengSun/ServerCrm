<?php

namespace Modules\Admin\Services\rule;

use Modules\Admin\Services\BaseApiService;

class RuleService extends BaseApiService
{
    /**
     * 递归遍历有权限的菜单
     * @param array $rule 权限数组
     * @param int $id 当前要删除的菜单id
     * @return array
     */
    public function delSort(array $rule, int $id): array
    {
        static $arr = array();
        foreach ($rule as $k => $v) {
            $arr[] = $v['id'];
            unset($rule[$k]);
            $this->delSort($rule, $v['id']);
        }
        return $arr;
    }

    public function tree2(array $array, int $pid = 0): array
    {
        $tree = array();
        foreach ($array as $key => $value) {
            if ($value['pid'] == $pid) {
                $value['meta'] = [
                    'title' => $value['title'],
                    'icon' => $value['icon'],
                    'showLink' => boolval($value['showLink']),
                    'showParent' => boolval($value['showParent']),
                    'keepAlive' => boolval($value['keepAlive']),
                    'hiddenTag' => false,
                    'dynamicLevel' => 0,
                ];

                if (!empty($value['transition_leave'])) {
                    $value['meta']['transition']['enterTransition'] = $value['transition_leave'];
                }
                if (!empty($value['transition_leave'])) {
                    $value['meta']['transition']['leaveTransition'] = $value['leaveTransition'];
                }
                if ($value['is_frame_link']) {
                    $value['meta']['frameSrc'] = $value['frameSrc'];
                    $value['meta']['frameLoading'] = boolval($value['frameLoading']);
                }
                // unset($value['title']);
                // unset($value['icon']);
                // unset($value['showLink']);
                // unset($value['showParent']);
                // unset($value['keepAlive']);
                // unset($value['transition_leave']);
                // unset($value['leaveTransition']);
                // unset($value['is_frame_link']);
                // unset($value['frameSrc']);
                // unset($value['frameLoading']);

                $value['children'] = $this->tree($array, $value['id']);
                if (!$value['children']) {
                    unset($value['children']);
                }
                $tree[] = $value;
            }
        }
        return $tree;
    }

    public function treeRules($data)
    {
        $items = array();
        foreach ($data as $v) {
            $items[$v['id']] = $v;
        }
        $tree = array();
        foreach ($items as $k => $item) {
            $items[$k]['meta'] = [
                'title' => $item['title'],
                'icon' => $item['icon'],
                'rank' => $item['rank'],
                'showLink' => boolval($item['showLink']),
                'showParent' => boolval($item['showParent']),
                'keepAlive' => boolval($item['keepAlive']),
                'hiddenTag' => false,
                'dynamicLevel' => 0
            ];

            if (!empty($item['transition_leave'])) {
                $items[$k]['meta']['transition']['leaveTransition'] = 'animate__' . $item['transition_leave'];
            }
            if (!empty($item['transition_enter'])) {
                $items[$k]['meta']['transition']['enterTransition'] = 'animate__' . $item['transition_enter'];
            }
            if ($item['is_frame_link']) {
                $items[$k]['meta']['frameSrc'] = $item['frameSrc'];
                $items[$k]['meta']['frameLoading'] = boolval($item['frameLoading']);
            }
            unset($items[$k]['title']);
            unset($items[$k]['icon']);
            unset($items[$k]['showLink']);
            unset($items[$k]['showParent']);
            unset($items[$k]['keepAlive']);
            unset($items[$k]['transition_leave']);
            unset($items[$k]['transition_enter']);
            unset($items[$k]['leaveTransition']);
            unset($items[$k]['is_frame_link']);
            unset($items[$k]['frameSrc']);
            unset($items[$k]['frameLoading']);
            unset($items[$k]['rank']);

            if (isset($items[$item['pid']])) {
                if ($item['menu_type'] == 2) {
                    $items[$item['pid']]['meta']['auths'][] = $item['permission'];
                } else {
                    unset($items[$k]['permission']);
                    $items[$item['pid']]['children'][] = &$items[$k];
                }
            } else {
                $tree[] = &$items[$k];
            }
        }
        return $tree;
    }
}

<?php

namespace Modules\Admin\Services\auth;

use Modules\Admin\Models\AuthRule as AuthRuleModel;
use Modules\Admin\Models\AuthGroup as AuthGroupModel;
use Modules\Admin\Models\AuthRole;
use Modules\Admin\Services\BaseApiService;
use Modules\Admin\Services\admin\RuleService;

class MenuService extends BaseApiService
{
    /**
     * @name 获取模型
     *
     * @return void
     */
    // public function getModel()
    // {
    //     $userInfo = (new TokenService())->my();
    //     $AuthRuleModel  = AuthRuleModel::query()->where(['type' => 1])->select('id', 'path', 'icon', 'name');
    //     $data = [];
    //     if ($userInfo['id'] == 1) {
    //         $data = $AuthRuleModel->get()->toArray();
    //     } else {
    //         $adminRules = AuthGroupModel::where(['id' => $userInfo['group_id']])->pluck('rules')->toArray();
    //         if ($adminRules) {
    //             $data = $AuthRuleModel->whereIn('id', explode("|", $adminRules))->get()->toArray();
    //         }
    //     }
    //     return $this->apiSuccess('', $data);
    // }
    /**
     * 获取菜单
     * @return array
     */
    public function getMenu()
    {
        $data = [];
        $userInfo = (new TokenService())->my();
        // $filed = ["id", "pid", "menu_type", "path", "name", "title", "permission", "icon", "component", "redirect", "showLink", "showParent", "keepAlive", "frameSrc", "frameLoading", "transition_leave", "transition_enter", "rank", "is_frame_link"];
        $filed = [
            "id",
            "menuType",
            "pid",
            "title",
            "icon",
            "name",
            "path",
            "rank",
            "redirect",
            "component",
            "extraIcon",
            "enterTransition",
            "leaveTransition",
            "auths",
            "activePath",
            "frameSrc",
            "frameLoading",
            "keepAlive",
            "hiddenTag",
            "showLink",
            "showParent"
        ];
        if ($userInfo['id'] != 1) {
            $role_ids = explode("|", $userInfo['role_ids']);
            $adminRules = AuthRole::whereIn('id', $role_ids)->select('rules')->get()->toArray();
            $adminRules = array_column($adminRules, 'rules');
            $adminRules = implode("|", $adminRules);
            if ($adminRules) {
                $ruleArr = array_unique(explode("|", $adminRules));
                $rules = AuthRuleModel::whereIn('id', $ruleArr)->select($filed)->get()->toArray();
                $data = (new RuleService())->treeRules($rules);
            }
        } else {
            $rules = AuthRuleModel::select($filed)
                ->get()->toArray();
            $data = (new RuleService())->treeRules($rules);
        }
        return $this->apiSuccess('', $data);
    }
}

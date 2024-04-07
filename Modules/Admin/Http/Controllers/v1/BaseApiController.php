<?php

/**
 * @name 当前模块控制器基类
 * @author 孙向成
 * @desc 用于定义当前模块的控制器基类
 */

namespace Modules\Admin\Http\Controllers\v1;

use Modules\Common\Controllers\BaseController;

class BaseApiController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
}

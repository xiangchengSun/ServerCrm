<?php

namespace Modules\Admin\Http\Controllers\v1;

use Illuminate\Http\Request;
use Modules\Admin\Services\upload\UploadService;

class UploadController extends BaseApiController
{
    /**
     * @name 单文件上传
     * @param Request $request
     * @return void
     */
    public function uploadFile(Request $request)
    {
        return (new UploadService)->upload($request);
    }

    /**
     * @name 批量文件上传
     *
     * @param Request $request
     * @return void
     */
    public function uploadFiles(Request $request)
    {
        return (new UploadService)->uploads($request);
    }
}

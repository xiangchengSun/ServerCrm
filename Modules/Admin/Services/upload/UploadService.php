<?php

namespace Modules\Admin\Services\upload;

use Modules\Admin\Services\BaseApiService;
use PhpParser\Node\Expr\Cast\Object_;

class UploadService extends BaseApiService
{

    /**
     * @name 单文件上传
     *
     * @param Object $request
     * @return void
     */
    public function upload(Object $request)
    {
        if ($request->isMethod('POST')) {
            $fileCharater = $request->file('file');

            if ($fileCharater->isValid()) {
                $imageStatus = 1; //AuthConfigModel::where('id',1)->value('image_status');
                if ($imageStatus == 1) {
                    $path = $request->file('file')->store(date('Ymd'), 'public');
                    if ($path) {
                        $url = '/upload/images/' . $path;
                    }
                } else if ($imageStatus == 2) {
                    $url = $this->addQiniu($fileCharater);
                }
                dd($url);
                if (isset($url)) {
                    $image_id = AuthImageModel::insertGetId([
                        'url' => $url,
                        'open' => $imageStatus,
                        'status' => 0,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                    if ($image_id) {
                        if ($imageStatus == 1) {
                            $url = $this->getHttp() . $url;
                        }
                        return $this->apiSuccess(
                            '上传成功！',
                            [
                                'image_id' => $image_id,
                                'url' => $url
                            ]
                        );
                    }
                }
            }
        }
        $this->apiError('上传失败！');
    }

    /**
     * @name 多文件上传
     *
     * @param Object $file
     * @param string $type
     * @return void
     */
    public function uploads(Object $request)
    {
        return $this->upload($request);
    }
    //上传文件
    public function uploadFile($request)
    {
        if ($request->isMethod('POST')) {
            $fileCharater = $request->file('file');
            if ($fileCharater->isValid()) {
                $imageStatus = AuthConfigModel::where('id', 1)->value('image_status');
                if ($imageStatus == 1) {
                    $path = $request->file('file')->store(date('Ymd'), 'upload');
                    if ($path) {
                        $url = '/upload/images/' . $path;
                    }
                } else if ($imageStatus == 2) {
                    $url = $this->addQiniu($fileCharater);
                }
                if (isset($url)) {
                    $image_id = AuthImageModel::insertGetId([
                        'url' => $url,
                        'open' => $imageStatus,
                        'status' => 0,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                    if ($image_id) {
                        if ($imageStatus == 1) {
                            $url = $this->getHttp() . $url;
                        }
                        return $this->apiSuccess(
                            '上传成功！',
                            [
                                'image_id' => $image_id,
                                'url' => $url
                            ]
                        );
                    }
                }
            }
        }
        $this->apiError('上传失败！');
    }
    //上传视频
    public function uploadVideo($file)
    {
        return $this->upload($file, 'video');
    }
}

<?php

namespace Modules\Admin\Services\log;

use Modules\Admin\Services\BaseApiService;
use Modules\Admin\Models\AuthLog;

class LogService extends BaseApiService
{
    public function store(int $admin_id = 0, string $content = "")
    {
        if ($admin_id) {
            $route_data = request()->route();
            $url = $route_data->uri;
            $data = [
                'content' => $content,
                'url' => $url,
                'method' => request()->getMethod(),
                'ip' => request()->ips()[0],
                'admin_id' => $admin_id,
                'data' => json_encode(request()->all()),
                'header' => json_encode(request()->header())
            ];
            $this->commonCreate(AuthLog::query(), $data);
        }
    }
}

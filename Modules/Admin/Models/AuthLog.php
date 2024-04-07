<?php

namespace Modules\Admin\Models;

class AuthLog extends BaseApiModel
{
    // 主键id
    protected $primaryKey = 'id';
    // 是否开启自动时间戳
    public $timestamps = true;
    protected $fillable = ['created_at', 'updated_at'];
}

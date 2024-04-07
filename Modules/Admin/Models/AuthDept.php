<?php

namespace Modules\Admin\Models;

class AuthDept extends BaseApiModel
{
    // 表名
    protected $table = 'auth_dept';
    // 主键id
    protected $primaryKey = 'id';
    // 是否开启自动时间戳
    public $timestamps = true;
    protected $fillable = ['created_at', 'updated_at'];
    protected $guarded = [];
}

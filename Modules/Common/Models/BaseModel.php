<?php

/**
 * @Name  模型基类
 * @desc  用于所有的数据库定义基类
 * @Auther 孙向成
 */

namespace Modules\Common\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class BaseModel extends EloquentModel
{
    /**
     * @name 主键ID
     */
    protected $primaryKey = 'id';
    /**
     * @name id是否自增
     **/
    public $incrementing = false;

    /**
     * @name   表id的数据类型
     **/
    protected $keyType = 'int';
    /**
     * @name 指示是否自动维护时间戳
     * @description
     **/
    public $timestamps = false;
    /**
     * @name 该字段可被批量赋值
     * @description
     **/
    protected $fillable = [];
    /**
     * @name 该字段不可被批量赋值

     **/
    protected $guarded = [];

    /**
     * @name 时间格式传唤
     **/
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}

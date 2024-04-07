<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_dept', function (Blueprint $table) {

            $table->comment = '部门表';
            $table->increments('id')->comment('部门');
            $table->integer('pid')->default(0)->comment('父级ID');
            $table->string('name', 100)->default('')->comment('部门名称');
            $table->string('username', 50)->default('')->comment('部门负责人');
            $table->string('phone', 100)->default('')->comment('手机号');
            $table->string('email')->default('')->comment('邮箱');
            $table->integer('sort')->default(1)->comment('排序');
            $table->tinyInteger('status')->default(1)->comment('部门状态:0=禁用,1=启用');
            $table->string('remark', 100)->nullable()->default('')->comment('备注描述');
            $table->timestamp('created_at')->nullable()->comment('创建时间');
            $table->timestamp('updated_at')->nullable()->comment('更新时间');
            $table->index('pid');
            $table->index('status');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_dept');
    }
}

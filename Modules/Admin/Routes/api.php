<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1/admin', 'middleware' => 'AdminApiAuth'], function () {
    // 登录
    Route::post('login/login', 'v1\LoginController@login');
    // 登出
    Route::delete('index/logout', 'v1\IndexController@logout');
    // 刷新token
    Route::put('index/refreshToken', 'v1\IndexController@refreshToken');
    // 获取用户信息
    Route::post('index/userInfo', 'v1\IndexController@userInfo');
    // 修改密码
    Route::put('index/updatePwd', 'v1\IndexController@updatePwd');
    //获取模块
    Route::get('index/getModel', 'v1\IndexController@getModel');
    //获取菜单
    Route::post('index/getAsyncRoutes', 'v1\IndexController@getMenu');

    //上传文件
    Route::post('upload/uploadFile', 'v1\UploadController@uploadFile');

    /********部门管理*********/
    //部门列表
    Route::post("dept/index", "v1\DeptController@index");
    //添加部门
    Route::post("dept/add", "v1\DeptController@add");
    //编辑部门
    Route::put("dept/update", "v1\DeptController@update");
    //编辑部门
    Route::put("dept/status", "v1\DeptController@status");
    //删除部门
    Route::delete("dept/del", "v1\DeptController@del");

    /********角色管理*********/

    //全部角色
    Route::get("role/alllist", "v1\RoleController@all");
    //角色列表
    Route::post("role/index", "v1\RoleController@index");
    //获取角色权限
    Route::post("role/getRoleRule", "v1\RoleController@getRoleRule");
    //添加角色
    Route::post("role/add", "v1\RoleController@add");
    //编辑角色
    Route::put("role/update", "v1\RoleController@update");
    //编辑角色权限
    Route::put("role/updateRule", "v1\RoleController@updateRule");
    //编辑角色
    Route::put("role/status", "v1\RoleController@status");
    //删除角色
    Route::delete("role/del", "v1\RoleController@del");

    /********用户管理*********/
    //用户列表
    Route::post("admin/index", "v1\AdminController@index");
    //用户详情
    Route::post("admin/info", "v1\AdminController@getUserInfo");
    //用户角色
    Route::post("admin/role", "v1\AdminController@getUserRole");
    //添加用户
    Route::post("admin/add", "v1\AdminController@add");
    //编辑用户
    Route::put("admin/update", "v1\AdminController@update");
    //编辑用户角色
    Route::put("admin/updateRole", "v1\AdminController@updateUserRole");
    //编辑用户
    Route::put("admin/status", "v1\AdminController@status");
    //删除用户
    Route::delete("admin/del", "v1\AdminController@del");
    //删除用户
    Route::put("admin/updateUserPwd", "v1\AdminController@updatePwd");

    /********权限管理*********/
    //权限列表
    Route::post("rule/index", "v1\RuleController@index");
    //添加权限
    Route::post("rule/add", "v1\RuleController@add");
    //编辑权限
    Route::put("rule/update", "v1\RuleController@update");
    //编辑权限
    Route::put("rule/status", "v1\RuleController@status");
    //删除权限
    Route::delete("rule/del", "v1\RuleController@del");
});

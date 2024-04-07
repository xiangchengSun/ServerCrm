<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PwdRequest extends FormRequest
{
    /**
     * php artisan module:make-request AdminRequest Admin
     */

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'y_password'  => 'required|regex:/^[a-zA-Z0-9]{4,14}$/',
            'password'  => 'required|confirmed|regex:/^[a-zA-Z0-9]{4,14}$/'

        ];
    }
    public function messages()
    {
        return [
            'y_password.required' => '请输入原密码！',
            'y_password.regex' => '原密码必须4到14位的数字或字母！',
            'password.required' => '请输入密码！',
            'password.confirmed' => '两次密码输入不一致！',
            'password.regex' => '密码必须4到14位的数字或字母！',
        ];
    }
}

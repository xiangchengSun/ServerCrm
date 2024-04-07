<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeptAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            // 'username'  => 'required',
            // 'phone'  => 'required',
            // 'email'  => 'required|email'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '请输入部门名称！',
            // 'username.required' => '请输入部门负责人！',
            // 'email.required' => '请输入部门负责人邮箱！',
            // 'email.email' => '邮箱格式不正确！',
            // 'phone.required' => '请输入手机号！',
        ];
    }
}

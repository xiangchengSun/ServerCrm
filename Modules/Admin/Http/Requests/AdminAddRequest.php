<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminAddRequest extends FormRequest
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
            'nickname' => 'required',
            'username'  => 'required',
            'password'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'nickname.required' => '请输入用户昵称！',
            'username.required' => '请输入用户名称！',
            'password.required' => '请输入密码！'
        ];
    }
}

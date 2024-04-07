<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPwdRequest extends FormRequest
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

    public function rules()
    {
        return [
            'id'  => 'required',
            'newPwd'  => 'required|regex:/^[a-zA-Z0-9]{4,14}$/'

        ];
    }
    public function messages()
    {
        return [
            'id.required' => '缺少参数ID！',
            'newPwd.required' => '请输入密码！',
            'newPwd.regex' => '密码必须4到14位的数字或字母！',
        ];
    }
}

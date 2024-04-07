<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommonPageRequest extends FormRequest
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
            'page' => 'required|is_positive_integer',
            'size' => 'required|is_positive_integer',
        ];
    }
    public function messages()
    {
        return [
            'page.required'                 => '缺少参数（page）！',
            'page.is_positive_integer'     => '（page）参数错误！',
            'size.required'                 => '缺少参数（size）！',
            'size.is_positive_integer'     => '（size）参数错误！',
        ];
    }
}

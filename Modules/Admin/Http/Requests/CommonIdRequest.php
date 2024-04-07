<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommonIdRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }
	public function rules()
    {
        return [
			'id' => 'required|is_positive_integer',
        ];
    }
	public function messages(){
		return [
			'id.required' 				=> '缺少参数（id）！',
			'id.is_positive_integer' 	=> '（id）参数错误！',
		];
	}
}










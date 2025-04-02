<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ThayDoiThongTinRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => [
                'required',
                Rule::unique('users', 'username')->ignore($this->user()->id),
            ],
            'phone_number' => 'nullable|regex:/^(\+?[\d\s-()]{7,15})$/',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Tên người dùng không được để trống',
            'username.unique' => 'Tên người dùng đã tồn tại trong hệ thống',
            'phone_number.regex' => 'Số điện thoại không đúng định dạng',
        ];
    }
}

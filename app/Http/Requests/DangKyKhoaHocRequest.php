<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DangKyKhoaHocRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:5|max:20',
            'birthday' => 'required|date_format:d/m/Y',
            'province' => 'nullable|string',
            'district' => 'required_with:province|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.min' => 'Tên phải có ít nhất 5 ký tự',
            'name.max' => 'Tên không được vượt quá 20 ký tự',
            'birthday.required' => 'Ngày sinh không được để trống',
            'birthday.date_format' => 'Ngày sinh phải có định dạng DD/MM/YYYY',
            'district.required_with' => 'Quận/huyện bắt buộc nhập nếu tỉnh/thành phố đã được chọn',
        ];
    }
}

<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DatHangRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'is_shipping_address_same' => 'required|boolean',
            'shipping_address' => 'required_if:is_shipping_address_same,true|string',
        ];
    }

    public function messages()
    {
        return [
            'is_shipping_address_same.required' => 'Vui lòng chọn phương thức giao hàng',
            'is_shipping_address_same.boolean' => 'Giá trị không hợp lệ',
            'shipping_address.required_if' => 'Địa chỉ giao hàng là bắt buộc',
        ];
    }
}

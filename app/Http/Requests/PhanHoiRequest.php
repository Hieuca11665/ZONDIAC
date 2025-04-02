<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhanHoiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'vote_star' => 'required|integer|min:1|max:5',
            'feedback' => 'required|string|min:50|max:500',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'ID người dùng không được để trống',
            'user_id.exists' => 'ID người dùng không tồn tại trong hệ thống',
            'vote_star.required' => 'Vui lòng đánh giá sao',
            'vote_star.integer' => 'Đánh giá phải là số nguyên',
            'vote_star.min' => 'Đánh giá ít nhất là 1 sao',
            'vote_star.max' => 'Đánh giá nhiều nhất là 5 sao',
            'feedback.required' => 'Nội dung phản hồi không được để trống',
            'feedback.min' => 'Nội dung phản hồi phải có ít nhất 50 ký tự',
            'feedback.max' => 'Nội dung phản hồi không được vượt quá 500 ký tự',
        ];
    }
}

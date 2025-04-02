<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ThayDoiThongTinRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ThayDoiThongTinController extends Controller
{
    public function showForm()
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('dang-nhap')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        return view('thong-tin.thay-doi', ['user' => Auth::user()]);
    }

    public function update(ThayDoiThongTinRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();

        // Kiểm tra người dùng tồn tại
        if (!$user) {
            return redirect()->route('dang-nhap')->with('error', 'Phiên đăng nhập đã hết hạn.');
        }

        $updateData = [
            'username' => $validated['username']
        ];

        if (isset($validated['phone_number'])) {
            $updateData['phone_number'] = $validated['phone_number'];
        }

        try {
            User::where('id', $user->id)->update($updateData);
            return redirect()->route('thay-doi-thong-tin')->with('success', 'Thay đổi thông tin thành công.');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi khi cập nhật thông tin. Vui lòng thử lại.');
        }
    }
}

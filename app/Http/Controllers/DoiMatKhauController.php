<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DoiMatKhauRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DoiMatKhauController extends Controller
{
    public function showForm()
    {
        if (!Auth::check()) {
            return redirect()->route('dang-nhap')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        return view('thong-tin.doi-mat-khau', ['user' => Auth::user()]);
    }

    public function update(DoiMatKhauRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();

        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác']);
        }

        try {
            // Sử dụng model User để cập nhật mật khẩu
            User::where('id', $user->id)->update([
                'password' => Hash::make($validated['password'])
            ]);

            return redirect()->route('doi-mat-khau')->with('success', 'Đổi mật khẩu thành công.');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi khi cập nhật mật khẩu. Vui lòng thử lại.');
        }
    }
}

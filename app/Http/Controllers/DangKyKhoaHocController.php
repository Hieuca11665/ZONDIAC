<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DangKyKhoaHocRequest;
use App\Models\KhoaHoc;
use Illuminate\Support\Facades\Auth;

class DangKyKhoaHocController extends Controller
{
    public function showForm()
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('dang-nhap')->with('error', 'Vui lòng đăng nhập để đăng ký khóa học.');
        }

        return view('khoa-hoc.dang-ky');
    }

    public function register(DangKyKhoaHocRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();

        // Kiểm tra người dùng tồn tại
        if (!$user) {
            return redirect()->route('dang-nhap')->with('error', 'Phiên đăng nhập đã hết hạn.');
        }

        try {
            KhoaHoc::create([
                'name' => $validated['name'],
                'birthday' => $validated['birthday'],
                'province' => $validated['province'] ?? null,
                'district' => $validated['district'] ?? null,
                'user_id' => $user->id,
            ]);

            return redirect()->route('trang-chu')->with('success', 'Đăng ký khóa học thành công.');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi khi đăng ký khóa học. Vui lòng thử lại.');
        }
    }
}

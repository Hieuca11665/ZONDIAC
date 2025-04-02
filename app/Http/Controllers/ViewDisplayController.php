<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ViewDisplayController extends Controller
{
    /**
     * Hiển thị trang đổi mật khẩu
     */
    public function showDoiMatKhau()
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('dang-nhap')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        return view('auth.doi-mat-khau', ['user' => Auth::user()]);
    }

    /**
     * Hiển thị trang danh sách khóa học
     */
    public function showDanhSachKhoaHoc()
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('dang-nhap')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        // Giả định có dữ liệu khóa học từ cơ sở dữ liệu
        $courses = []; // Trong thực tế, bạn sẽ lấy dữ liệu từ model KhoaHoc

        return view('khoa-hoc.danh-sach', ['courses' => $courses]);
    }

    /**
     * Hiển thị trang chi tiết khóa học
     */
    public function showChiTietKhoaHoc($id)
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('dang-nhap')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        // Giả định lấy dữ liệu khóa học từ cơ sở dữ liệu
        $course = null; // Trong thực tế, bạn sẽ lấy dữ liệu từ model KhoaHoc

        if (!$course) {
            return redirect()->route('khoa-hoc.danh-sach')->with('error', 'Không tìm thấy khóa học.');
        }

        return view('khoa-hoc.chi-tiet', ['course' => $course]);
    }
}

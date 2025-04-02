<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrangChuController extends Controller
{
    public function index()
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('dang-nhap')->with('error', 'Vui lòng đăng nhập để truy cập trang chủ.');
        }

        return view('trang-chu.index');
    }
}

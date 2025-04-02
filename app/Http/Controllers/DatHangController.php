<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DatHangRequest;
use Illuminate\Support\Facades\Auth;

class DatHangController extends Controller
{
    public function showForm()
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('dang-nhap')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        return view('dat-hang.form');
    }

    public function process(DatHangRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();

        // Kiểm tra người dùng tồn tại
        if (!$user) {
            return redirect()->route('dang-nhap')->with('error', 'Phiên đăng nhập đã hết hạn.');
        }

        try {
            // Xử lý logic đặt hàng ở đây
            // ...

            return redirect()->route('trang-chu')->with('success', 'Đặt hàng thành công.');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi khi đặt hàng. Vui lòng thử lại.');
        }
    }
}

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PhanHoiRequest;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class PhanHoiController extends Controller
{
    public function showForm()
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('dang-nhap')->with('error', 'Vui lòng đăng nhập để gửi phản hồi.');
        }

        return view('phan-hoi.form', ['user' => Auth::user()]);
    }

    public function submit(PhanHoiRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();

        // Kiểm tra người dùng tồn tại
        if (!$user) {
            return redirect()->route('dang-nhap')->with('error', 'Phiên đăng nhập đã hết hạn.');
        }

        try {
            Feedback::create([
                'user_id' => $user->id, // Sử dụng ID của người dùng đã đăng nhập
                'vote_star' => $validated['vote_star'],
                'feedback' => $validated['feedback'],
            ]);

            return redirect()->route('trang-chu')->with('success', 'Cảm ơn bạn đã gửi phản hồi.');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi khi gửi phản hồi. Vui lòng thử lại.');
        }
    }
}

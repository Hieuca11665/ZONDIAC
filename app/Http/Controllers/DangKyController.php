<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\DangKyRequest;
use Illuminate\Support\Facades\Auth;

class DangKyController extends Controller
{
    public function showRegistrationForm()
    {
        // Kiểm tra người dùng đã đăng nhập chưa, nếu đã đăng nhập thì chuyển về trang chủ
        if (Auth::check()) {
            return redirect()->route('trang-chu');
        }

        return view('auth.register');
    }

    public function register(DangKyRequest $request)
    {
        $validated = $request->validated();

        // Kiểm tra email đã tồn tại chưa
        if (User::where('email', $validated['email'])->exists()) {
            return back()->withErrors(['email' => 'Email đã được sử dụng.'])->withInput();
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('dang-nhap')->with('success', 'Đăng ký thành công. Vui lòng đăng nhập.');
    }
}

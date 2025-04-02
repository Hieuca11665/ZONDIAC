<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class CapNhatHoSoController extends Controller
{
    public function showForm()
    {
        if (!Auth::check()) {
            return redirect()->route('dang-nhap')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        // Sửa lại - không thêm header vào view mà thay vào đó trả về response với header
        $response = response()->view('thong-tin.cap-nhat-ho-so', ['user' => Auth::user()]);
        $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        return $response;
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'age' => 'nullable|integer|min:1|max:120',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $userData = [
                'email' => $validated['email'],
                'age' => $validated['age'],
            ];

            // Xử lý upload avatar nếu có
            if ($request->hasFile('avatar')) {
                Log::info('File upload detected');
                Log::info('File name: ' . $request->file('avatar')->getClientOriginalName());

                // Xóa avatar cũ nếu có
                $user = Auth::user();
                if ($user->avatar) {
                    Log::info('Removing old avatar: ' . $user->avatar);
                    try {
                        if (Storage::disk('public')->exists($user->avatar)) {
                            Storage::disk('public')->delete($user->avatar);
                        }
                    } catch (\Exception $e) {
                        Log::error('Error deleting old avatar: ' . $e->getMessage());
                        // Tiếp tục mà không dừng lại
                    }
                }

                // Lưu avatar mới với timestamp để tránh cache
                $filename = time() . '_' . $request->file('avatar')->getClientOriginalName();
                $avatarPath = $request->file('avatar')->storeAs('avatars', $filename, 'public');
                Log::info('New avatar path: ' . $avatarPath);
                $userData['avatar'] = $avatarPath;
            }

            // Cập nhật thông tin người dùng
            User::where('id', Auth::id())->update($userData);

            return redirect()->route('cap-nhat-ho-so')->with('success', 'Cập nhật hồ sơ thành công.');
        } catch (\Exception $e) {
            Log::error('Error updating profile: ' . $e->getMessage());
            return back()->with('error', 'Đã xảy ra lỗi khi cập nhật hồ sơ: ' . $e->getMessage());
        }
    }
}

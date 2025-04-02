<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DangNhapController;
use App\Http\Controllers\DangKyController;
use App\Http\Controllers\TrangChuController;
use App\Http\Controllers\CapNhatHoSoController;
use App\Http\Controllers\DatHangController;
use App\Http\Controllers\PhanHoiController;
use App\Http\Controllers\DangKyKhoaHocController;
use App\Http\Controllers\ThayDoiThongTinController;
use App\Http\Controllers\ViewDisplayController;
use App\Http\Controllers\DoiMatKhauController;

// Public routes
Route::get('/', [DangNhapController::class, 'showLoginForm'])->name('login');

// Đăng nhập
Route::get('/dang-nhap', [DangNhapController::class, 'showLoginForm'])->name('dang-nhap');
Route::post('/dang-nhap', [DangNhapController::class, 'login']);

// Đăng ký
Route::get('/dang-ky', [DangKyController::class, 'showRegistrationForm'])->name('dang-ky');
Route::post('/dang-ky', [DangKyController::class, 'register']);

// Đăng xuất
Route::post('/dang-xuat', [DangNhapController::class, 'logout'])->name('dang-xuat');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Trang chủ
    Route::get('/trang-chu', [TrangChuController::class, 'index'])->name('trang-chu');

    // Cập nhật hồ sơ
    Route::get('/cap-nhat-ho-so', [CapNhatHoSoController::class, 'showForm'])->name('cap-nhat-ho-so');
    Route::post('/cap-nhat-ho-so', [CapNhatHoSoController::class, 'update']);


    // Đặt hàng
    Route::get('/dat-hang', [DatHangController::class, 'showForm'])->name('dat-hang.form');
    Route::post('/dat-hang', [DatHangController::class, 'process'])->name('dat-hang.process');

    // Phản hồi
    Route::get('/phan-hoi', [PhanHoiController::class, 'showForm'])->name('phan-hoi');
    Route::post('/phan-hoi', [PhanHoiController::class, 'submit']);

    // Đăng ký khóa học
    Route::get('/dang-ky-khoa-hoc', [DangKyKhoaHocController::class, 'showForm'])->name('dang-ky-khoa-hoc');
    Route::post('/dang-ky-khoa-hoc', [DangKyKhoaHocController::class, 'register']);

    // Thay đổi thông tin
    Route::get('/thay-doi-thong-tin', [ThayDoiThongTinController::class, 'showForm'])->name('thay-doi-thong-tin');
    Route::post('/thay-doi-thong-tin', [ThayDoiThongTinController::class, 'update']);

    // Đổi mật khẩu
    Route::get('/doi-mat-khau', [DoiMatKhauController::class, 'showForm'])->name('doi-mat-khau');
    Route::post('/doi-mat-khau', [DoiMatKhauController::class, 'update'])->name('doi-mat-khau.update');

    // Các route bổ sung từ ViewDisplayController
    Route::get('/danh-sach-khoa-hoc', [ViewDisplayController::class, 'showDanhSachKhoaHoc'])->name('khoa-hoc.danh-sach');
    Route::get('/khoa-hoc/{id}', [ViewDisplayController::class, 'showChiTietKhoaHoc'])->name('khoa-hoc.chi-tiet');

    Route::get('/', function () {
        return view('welcome'); // Hoặc view tương ứng
    })->name('home');
});

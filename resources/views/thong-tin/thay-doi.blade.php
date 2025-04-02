@extends('layouts.app')

@section('title', 'Thay đổi thông tin cá nhân')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-gradient-primary text-white py-3 rounded-top">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-user-edit me-2"></i>Thay đổi thông tin cá nhân</h4>
                </div>
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('thay-doi-thong-tin') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="username" class="form-label fw-bold">Tên người dùng</label>
                            <div class="input-group input-group-lg shadow-sm">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-primary"></i></span>
                                <input id="username" type="text" class="form-control border-start-0 @error('username') is-invalid @enderror" name="username" value="{{ old('username', $user->username) }}" required placeholder="Nhập tên người dùng">
                            </div>
                            @error('username')
                                <div class="text-danger mt-2 small">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="phone_number" class="form-label fw-bold">Số điện thoại</label>
                            <div class="input-group input-group-lg shadow-sm">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-phone text-primary"></i></span>
                                <input id="phone_number" type="text" class="form-control border-start-0 @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" placeholder="Nhập số điện thoại">
                            </div>
                            @error('phone_number')
                                <div class="text-danger mt-2 small">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a href="{{ route('cap-nhat-ho-so') }}" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">
                                <i class="fas fa-save me-2"></i>Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4 text-muted">
                <small><i class="fas fa-lock me-1"></i>Thông tin của bạn được bảo mật tuyệt đối</small>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4a89dc, #5b6bd1);
    }

    .form-control:focus {
        border-color: #4a89dc;
        box-shadow: 0 0 0 0.25rem rgba(74, 137, 220, 0.15);
    }

    .btn-primary {
        background-color: #4a89dc;
        border-color: #4a89dc;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #3a70b5;
        border-color: #3a70b5;
        transform: translateY(-2px);
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .form-label {
        color: #4a5568;
    }
</style>
@endsection

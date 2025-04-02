@extends('layouts.app')

@section('title', 'Đổi mật khẩu')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-gradient-primary text-white border-0 py-3">
                    <h5 class="mb-0 fw-semibold"><i class="fas fa-key me-2"></i>Đổi mật khẩu</h5>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('doi-mat-khau.update') }}" class="row g-4">
                        @csrf

                        <!-- Mật khẩu hiện tại -->
                        <div class="col-12">
                            <label for="current_password" class="form-label fw-medium">
                                <i class="fas fa-lock text-primary me-2"></i>Mật khẩu hiện tại
                            </label>
                            <div class="input-group input-group-seamless">
                                <span class="input-group-text border-end-0 bg-transparent">
                                    <i class="fas fa-key text-muted"></i>
                                </span>
                                <input id="current_password" type="password"
                                    class="form-control border-start-0 ps-0 @error('current_password') is-invalid @enderror"
                                    name="current_password" required>
                            </div>
                            @error('current_password')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Mật khẩu mới -->
                        <div class="col-12">
                            <label for="password" class="form-label fw-medium">
                                <i class="fas fa-lock-open text-primary me-2"></i>Mật khẩu mới
                            </label>
                            <div class="input-group input-group-seamless">
                                <span class="input-group-text border-end-0 bg-transparent">
                                    <i class="fas fa-key text-muted"></i>
                                </span>
                                <input id="password" type="password"
                                    class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror"
                                    name="password" required>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>Mật khẩu phải có ít nhất 8 ký tự
                            </div>
                        </div>

                        <!-- Xác nhận mật khẩu mới -->
                        <div class="col-12">
                            <label for="password_confirmation" class="form-label fw-medium">
                                <i class="fas fa-check-double text-primary me-2"></i>Xác nhận mật khẩu mới
                            </label>
                            <div class="input-group input-group-seamless">
                                <span class="input-group-text border-end-0 bg-transparent">
                                    <i class="fas fa-key text-muted"></i>
                                </span>
                                <input id="password_confirmation" type="password"
                                    class="form-control border-start-0 ps-0 @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation" required>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Submit buttons -->
                        <div class="col-12 mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('cap-nhat-ho-so') }}" class="btn btn-light px-4">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>Cập nhật mật khẩu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }

    .rounded-4 {
        border-radius: 0.75rem;
    }

    .input-group-seamless .input-group-text {
        border-right: none;
    }

    .input-group-seamless .form-control {
        border-left: none;
    }
</style>
@endpush
@endsection

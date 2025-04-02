@extends('layouts.app')

@section('title', 'Cập nhật hồ sơ')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar thông tin người dùng -->
        <div class="col-lg-4 col-md-5 mb-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-gradient-primary text-white border-0 py-3">
                    <h5 class="mb-0 fw-semibold"><i class="fas fa-user-circle me-2"></i>Thông tin cá nhân</h5>
                </div>
                <div class="card-body text-center py-4">
                    <div class="position-relative mb-4">
                        @if($user->avatar)
    <img src="{{ asset('storage/' . $user->avatar) }}?v={{ time() }}" alt="{{ $user->name }}"
        class="rounded-circle profile-img mb-3 border shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
@else
    <div class="rounded-circle profile-img d-flex align-items-center justify-content-center bg-light mb-3 mx-auto border"
        style="width: 120px; height: 120px;">
        <i class="fas fa-user-alt fa-3x text-primary opacity-50"></i>
    </div>
@endif
                        <div class="position-absolute bottom-0 end-0 bg-white rounded-circle p-1 shadow-sm" style="transform: translate(10px, 10px);">
                            <label for="avatar-upload" role="button" class="cursor-pointer m-0 d-flex align-items-center justify-content-center text-primary"
                                style="width: 32px; height: 32px;">
                                <i class="fas fa-camera"></i>
                            </label>
                        </div>
                    </div>

                    <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">
                        <i class="fas fa-envelope-open me-2 opacity-50"></i>{{ $user->email }}
                    </p>
                    @if($user->age)
                    <p class="text-muted mb-3">
                        <i class="fas fa-birthday-cake me-2 opacity-50"></i>{{ $user->age }} tuổi
                    </p>
                    @endif

                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('thay-doi-thong-tin') }}" class="btn btn-outline-primary rounded-pill">
                            <i class="fas fa-edit me-2"></i>Thay đổi thông tin
                        </a>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-gradient-secondary text-white border-0 py-3">
                    <h5 class="mb-0 fw-semibold"><i class="fas fa-shield-alt me-2"></i>Bảo mật tài khoản</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="feature-icon bg-primary bg-gradient text-white rounded-3 me-3">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Mật khẩu</h6>
                            <p class="text-muted small mb-0">Cập nhật mật khẩu định kỳ để bảo vệ tài khoản</p>
                        </div>
                    </div>

                    <div class="d-grid">
                        <a href="{{ route('doi-mat-khau') }}" class="btn btn-outline-secondary rounded-pill">
                            <i class="fas fa-key me-2"></i>Đổi mật khẩu
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form cập nhật hồ sơ -->
        <div class="col-lg-8 col-md-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-gradient-primary text-white border-0 py-3">
                    <h5 class="mb-0 fw-semibold"><i class="fas fa-user-edit me-2"></i>Cập nhật hồ sơ</h5>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('cap-nhat-ho-so') }}?v={{ time() }}" enctype="multipart/form-data" class="row g-4">
                        @csrf

                        <!-- Email field -->
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-medium">
                                <i class="fas fa-envelope text-primary me-2"></i>Email
                            </label>
                            <div class="input-group input-group-seamless">
                                <span class="input-group-text border-end-0 bg-transparent">
                                    <i class="fas fa-at text-muted"></i>
                                </span>
                                <input id="email" type="email"
                                    class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email', $user->email) }}"
                                    placeholder="your.email@example.com" required>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Age field -->
                        <div class="col-md-6">
                            <label for="age" class="form-label fw-medium">
                                <i class="fas fa-birthday-cake text-primary me-2"></i>Tuổi
                            </label>
                            <div class="input-group input-group-seamless">
                                <span class="input-group-text border-end-0 bg-transparent">
                                    <i class="fas fa-calendar-alt text-muted"></i>
                                </span>
                                <input id="age" type="number"
                                    class="form-control border-start-0 ps-0 @error('age') is-invalid @enderror"
                                    name="age" value="{{ old('age', $user->age) }}"
                                    placeholder="Nhập tuổi của bạn">
                            </div>
                            @error('age')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Avatar field -->
                        <div class="col-12">
                            <label for="avatar" class="form-label fw-medium">
                                <i class="fas fa-image text-primary me-2"></i>Ảnh đại diện
                            </label>
                            <div class="input-group">
                                <input id="avatar" type="file"
                                    class="form-control @error('avatar') is-invalid @enderror"
                                    name="avatar" accept="image/jpeg,image/png,image/gif">
                                <label class="input-group-text" for="avatar">
                                    <i class="fas fa-upload"></i>
                                </label>
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>Tải lên ảnh JPG, PNG, GIF dưới 2MB
                            </div>
                            @error('avatar')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Hidden input for avatar upload -->
                        <input type="file" id="avatar-upload" name="avatar" class="d-none">

                        <!-- Submit buttons -->
                        <div class="col-12 mt-4 d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light px-4">
                                <i class="fas fa-undo me-2"></i>Hủy bỏ
                            </button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>Lưu thay đổi
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

    .bg-gradient-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    }

    .rounded-4 {
        border-radius: 0.75rem;
    }

    .feature-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .input-group-seamless .input-group-text {
        border-right: none;
    }

    .input-group-seamless .form-control {
        border-left: none;
    }

    .cursor-pointer {
        cursor: pointer;
    }
</style>
@endpush

@push('scripts')
<script>
    // Kích hoạt upload ảnh khi click vào biểu tượng camera
    document.addEventListener('DOMContentLoaded', function() {
    const cameraButton = document.querySelector('label[for="avatar-upload"]');
    const fileInput = document.getElementById('avatar-upload');
    const formFileInput = document.getElementById('avatar');

    // Đảm bảo luôn gửi file trong form chính
    formFileInput.addEventListener('change', function() {
        previewImage(this.files[0]);
    });

    if (cameraButton && fileInput && formFileInput) {
        cameraButton.addEventListener('click', function() {
            fileInput.click();
        });

        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                // Chuyển file sang input chính
                const fileTransfer = new DataTransfer();
                fileTransfer.items.add(this.files[0]);
                formFileInput.files = fileTransfer.files;

                // Hiển thị preview
                previewImage(this.files[0]);
            }
        });
    }

    // Hàm hiển thị preview
    function previewImage(file) {
        if (!file) return;

        // Hiển thị tên file
        const existingFileName = formFileInput.parentElement.querySelector('.text-primary');
        if (existingFileName) {
            existingFileName.remove();
        }

        const fileNameElement = document.createElement('span');
        fileNameElement.classList.add('ms-2', 'text-primary');
        fileNameElement.textContent = file.name;
        formFileInput.parentElement.appendChild(fileNameElement);

        // Hiển thị hình ảnh preview
        const reader = new FileReader();
        reader.onload = function(e) {
            const profileImg = document.querySelector('.profile-img');
            if (profileImg.tagName === 'IMG') {
                profileImg.src = e.target.result;
            } else {
                // Nếu là div (trường hợp không có ảnh), tạo một img mới
                const parentDiv = profileImg.parentElement;
                profileImg.remove();

                const newImg = document.createElement('img');
                newImg.src = e.target.result;
                newImg.alt = "User Avatar";
                newImg.className = "rounded-circle profile-img mb-3 border shadow-sm";
                newImg.style.width = "120px";
                newImg.style.height = "120px";
                newImg.style.objectFit = "cover";

                parentDiv.prepend(newImg);
            }
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
@endsection

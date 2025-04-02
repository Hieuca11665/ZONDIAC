@extends('layouts.app')

@section('title', 'Đăng ký khóa học')

@section('styles')
<style>
    .course-registration-wrapper {
        max-width: 900px;
        margin: 0 auto;
    }

    .step-progress {
        display: flex;
        justify-content: space-between;
        margin-bottom: 3rem;
        position: relative;
    }

    .step-progress:before {
        content: '';
        position: absolute;
        top: 24px;
        left: 5%;
        right: 5%;
        height: 2px;
        background: rgba(0, 97, 242, 0.2);
        z-index: 0;
    }

    .step {
        position: relative;
        z-index: 1;
        text-align: center;
        width: 20%;
    }

    .step-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        margin: 0 auto 1rem;
        border: 2px solid var(--primary-color);
        font-size: 1.2rem;
        transition: all 0.3s;
        box-shadow: 0 5px 15px rgba(0, 97, 242, 0.15);
    }

    .step.active .step-icon {
        background: linear-gradient(120deg, var(--primary-color), var(--secondary-color));
        color: white;
        transform: scale(1.1);
        box-shadow: 0 10px 20px rgba(0, 97, 242, 0.3);
    }

    .step-label {
        font-weight: 600;
        color: var(--dark-color);
        font-size: 0.9rem;
        transition: all 0.3s;
    }

    .step.active .step-label {
        color: var(--primary-color);
    }

    .course-card {
        border-radius: 20px;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        transition: all 0.4s;
        cursor: pointer;
        border: 2px solid transparent;
    }

    .course-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .course-card.selected {
        border: 2px solid var(--primary-color);
    }

    .course-card .badge-corner {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 0.5rem 1rem;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 2;
    }

    .course-card .card-img {
        height: 200px;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .course-card .card-img:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(0deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0) 50%);
    }

    .course-card .course-title {
        position: absolute;
        bottom: 20px;
        left: 20px;
        color: white;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .field-group {
        margin-bottom: 2rem;
    }

    .field-group label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }

    .input-icon-wrapper {
        position: relative;
    }

    .input-icon-wrapper i {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 15px;
        color: var(--primary-color);
    }

    .input-icon-wrapper .form-control {
        padding-left: 45px;
    }

    .province-district-row {
        gap: 15px;
    }

    .form-floating>.form-control {
        height: calc(3.7rem + 2px);
    }

    .registration-section {
        display: none;
    }

    .registration-section.active {
        display: block;
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .checkbox-card {
        cursor: pointer;
        border-radius: 15px;
        transition: all 0.3s;
        border: 2px solid transparent;
        height: 100%;
    }

    .checkbox-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
    }

    .checkbox-card.selected {
        border-color: var(--primary-color);
        background-color: rgba(0, 97, 242, 0.05);
    }

    .checkbox-card .form-check-input {
        margin-right: 10px;
    }

    .checkbox-card .form-check-label {
        width: 100%;
        padding: 1.5rem;
    }

    .animate-pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(0, 97, 242, 0.4); }
        70% { box-shadow: 0 0 0 15px rgba(0, 97, 242, 0); }
        100% { box-shadow: 0 0 0 0 rgba(0, 97, 242, 0); }
    }

    .confirmation-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(120deg, var(--primary-color), var(--secondary-color));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        color: white;
        font-size: 3rem;
        box-shadow: 0 15px 30px rgba(0, 97, 242, 0.3);
    }
</style>
@endsection

@section('content')
<div class="course-registration-wrapper">
    <div class="card glass-effect animate__animated animate__fadeIn">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Đăng Ký Khóa Học</h4>
        </div>
        <div class="card-body p-lg-5">
            <!-- Step Progress Bar -->
            <div class="step-progress mb-5">
                <div class="step active" data-step="1">
                    <div class="step-icon">
                        <i class="fas fa-list-ul"></i>
                    </div>
                    <div class="step-label">Thông tin cơ bản</div>
                </div>
                <div class="step" data-step="2">
                    <div class="step-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="step-label">Chọn khóa học</div>
                </div>
                <div class="step" data-step="3">
                    <div class="step-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="step-label">Lịch học</div>
                </div>
                <div class="step" data-step="4">
                    <div class="step-icon">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <div class="step-label">Thanh toán</div>
                </div>
                <div class="step" data-step="5">
                    <div class="step-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="step-label">Hoàn tất</div>
                </div>
            </div>

            <form action="{{ route('dang-ky-khoa-hoc') }}" method="POST" id="courseRegistrationForm">
                @csrf

                <!-- Step 1: Basic Information -->
                <div class="registration-section active" id="step1">
                    <h5 class="text-primary mb-4">Thông tin học viên</h5>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="field-group">
                                <label for="name">Họ và tên <span class="text-danger">*</span></label>
                                <div class="input-icon-wrapper">
                                    <i class="fas fa-user"></i>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->name ?? '') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="field-group">
                                <label for="birthday">Ngày sinh <span class="text-danger">*</span></label>
                                <div class="input-icon-wrapper">
                                    <i class="fas fa-calendar"></i>
                                    <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row province-district-row">
                        <div class="col-md-6">
                            <div class="field-group">
                                <label for="province">Tỉnh/Thành phố</label>
                                <div class="input-icon-wrapper">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <select class="form-select" id="province" name="province">
                                        <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                        <option value="hanoi">Hà Nội</option>
                                        <option value="hochiminh">TP. Hồ Chí Minh</option>
                                        <option value="danang">Đà Nẵng</option>
                                        <option value="haiphong">Hải Phòng</option>
                                        <option value="cantho">Cần Thơ</option>
                                        <!-- Thêm các tỉnh/thành phố khác -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="field-group">
                                <label for="district">Quận/Huyện</label>
                                <div class="input-icon-wrapper">
                                    <i class="fas fa-map"></i>
                                    <select class="form-select" id="district" name="district" disabled>
                                        <option value="">-- Chọn Quận/Huyện --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-primary next-step" data-step="1">
                            Tiếp theo <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 2: Choose Course -->
                <div class="registration-section" id="step2">
                    <h5 class="text-primary mb-4">Chọn khóa học phù hợp</h5>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="course-card card shadow-sm" data-course="web-dev">
                                <span class="badge bg-primary badge-corner">Phổ biến</span>
                                <div class="card-img" style="background-image: url('/api/placeholder/600/320')">
                                    <h5 class="course-title">Lập trình Web Frontend</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="badge bg-light text-dark">
                                            <i class="fas fa-clock me-1"></i> 3 tháng
                                        </div>
                                        <div class="badge bg-info text-white">
                                            <i class="fas fa-signal me-1"></i> Cơ bản đến nâng cao
                                        </div>
                                    </div>
                                    <p class="card-text">Khóa học giúp bạn làm chủ HTML, CSS, JavaScript và các framework phổ biến.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="rating text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            <span class="text-muted ms-2">4.5</span>
                                        </div>
                                        <div class="course-price text-primary fw-bold">4,500,000₫</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="course-card card shadow-sm" data-course="backend-dev">
                                <div class="card-img" style="background-image: url('/api/placeholder/600/320')">
                                    <h5 class="course-title">Lập trình Backend</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="badge bg-light text-dark">
                                            <i class="fas fa-clock me-1"></i> 4 tháng
                                        </div>
                                        <div class="badge bg-warning text-white">
                                            <i class="fas fa-signal me-1"></i> Trung cấp
                                        </div>
                                    </div>
                                    <p class="card-text">Học cách xây dựng API, quản lý cơ sở dữ liệu và phát triển ứng dụng phía server.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="rating text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <span class="text-muted ms-2">4.0</span>
                                        </div>
                                        <div class="course-price text-primary fw-bold">5,200,000₫</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="course-card card shadow-sm" data-course="mobile-dev">
                                <span class="badge bg-success badge-corner">Mới</span>
                                <div class="card-img" style="background-image: url('/api/placeholder/600/320')">
                                    <h5 class="course-title">Lập trình Mobile App</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="badge bg-light text-dark">
                                            <i class="fas fa-clock me-1"></i> 4 tháng
                                        </div>
                                        <div class="badge bg-warning text-white">
                                            <i class="fas fa-signal me-1"></i> Trung cấp
                                        </div>
                                    </div>
                                    <p class="card-text">Phát triển ứng dụng di động đa nền tảng với React Native và Flutter.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="rating text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <span class="text-muted ms-2">5.0</span>
                                        </div>
                                        <div class="course-price text-primary fw-bold">5,800,000₫</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="course-card card shadow-sm" data-course="data-science">
                                <div class="card-img" style="background-image: url('/api/placeholder/600/320')">
                                    <h5 class="course-title">Data Science cơ bản</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="badge bg-light text-dark">
                                            <i class="fas fa-clock me-1"></i> 3 tháng
                                        </div>
                                        <div class="badge bg-danger text-white">
                                            <i class="fas fa-signal me-1"></i> Nâng cao
                                        </div>
                                    </div>
                                    <p class="card-text">Khai phá dữ liệu, phân tích và xây dựng mô hình học máy với Python.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="rating text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            <span class="text-muted ms-2">4.7</span>
                                        </div>
                                        <div class="course-price text-primary fw-bold">6,500,000₫</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-primary prev-step" data-step="2">
                            <i class="fas fa-arrow-left me-2"></i> Quay lại
                        </button>
                        <button type="button" class="btn btn-primary next-step" data-step="2">
                            Tiếp theo <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Schedule -->
                <div class="registration-section" id="step3">
                    <h5 class="text-primary mb-4">Chọn lịch học</h5>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Lịch học</h6>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="schedule" id="schedule1" value="schedule1" checked>
                                        <label class="form-check-label" for="schedule1">
                                            Tối 2-4-6 (18:30 - 21:30)
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="schedule" id="schedule2" value="schedule2">
                                        <label class="form-check-label" for="schedule2">
                                            Tối 3-5-7 (18:30 - 21:30)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="schedule" id="schedule3" value="schedule3">
                                        <label class="form-check-label" for="schedule3">
                                            Sáng T7-CN (8:30 - 11:30)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Hình thức học</h6>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="study_method" id="offline" value="offline" checked>
                                        <label class="form-check-label" for="offline">
                                            Học offline tại trung tâm
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="study_method" id="online" value="online">
                                        <label class="form-check-label" for="online">
                                            Học online qua Zoom
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="study_method" id="hybrid" value="hybrid">
                                        <label class="form-check-label" for="hybrid">
                                            Kết hợp (online + offline)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="card-title">Dịch vụ thêm</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card checkbox-card">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="mentor" name="additional_services[]" value="mentor">
                                            <label class="form-check-label d-block" for="mentor">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-user-tie fs-4 me-2 text-primary"></i>
                                                    <h6 class="mb-0">Mentor 1-1</h6>
                                                </div>
                                                <p class="mb-1 text-muted">Được hỗ trợ bởi chuyên gia trong ngành</p>
                                                <div class="text-primary fw-bold">+ 2,000,000₫</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card checkbox-card">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="certificate" name="additional_services[]" value="certificate">
                                            <label class="form-check-label d-block" for="certificate">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-certificate fs-4 me-2 text-warning"></i>
                                                    <h6 class="mb-0">Chứng chỉ quốc tế</h6>
                                                </div>
                                                <p class="mb-1 text-muted">Được cấp chứng chỉ có giá trị toàn cầu</p>
                                                <div class="text-primary fw-bold">+ 1,500,000₫</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card checkbox-card">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="job_support" name="additional_services[]" value="job_support">
                                            <label class="form-check-label d-block" for="job_support">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-briefcase fs-4 me-2 text-success"></i>
                                                    <h6 class="mb-0">Hỗ trợ việc làm</h6>
                                                </div>
                                                <p class="mb-1 text-muted">Được giới thiệu vào các công ty đối tác</p>
                                                <div class="text-primary fw-bold">+ 1,000,000₫</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card checkbox-card">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="laptop" name="additional_services[]" value="laptop">
                                            <label class="form-check-label d-block" for="laptop">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-laptop fs-4 me-2 text-info"></i>
                                                    <h6 class="mb-0">Thuê laptop trong khóa học</h6>
                                                </div>
                                                <p class="mb-1 text-muted">Được cung cấp laptop cấu hình cao</p>
                                                <div class="text-primary fw-bold">+ 3,000,000₫</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-primary prev-step" data-step="3">
                            <i class="fas fa-arrow-left me-2"></i> Quay lại
                        </button>
                        <button type="button" class="btn btn-primary next-step" data-step="3">
                            Tiếp theo <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 4: Payment -->
                <div class="registration-section" id="step4">
                    <h5 class="text-primary mb-4">Thanh toán</h5>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="card-title">Thông tin khóa học</h6>
                            <div class="d-flex align-items-center mb-3">
                                <img src="/api/placeholder/80/80" class="rounded me-3" alt="Course">
                                <div>
                                    <h6 class="mb-1" id="selected-course-name">Lập trình Web Frontend</h6>
                                    <div class="text-muted small" id="selected-course-schedule">Tối 2-4-6 (18:30 - 21:30)</div>
                                </div>
                            </div>

                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Học phí cơ bản</td>
                                        <td class="text-end fw-bold" id="course-base-price">4,500,000₫</td>
                                    </tr>
                                    <tr>
                                        <td>Dịch vụ thêm</td>
                                        <td class="text-end" id="additional-services">0₫</td>
                                    </tr>
                                    <tr>
                                        <td>Giảm giá</td>
                                        <td class="text-end text-danger">- 0₫</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td class="fw-bold">Tổng cộng</td>
                                        <td class="text-end fw-bold text-primary fs-5" id="total-price">4,500,000₫</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="card-title">Phương thức thanh toán</h6>

                            <div class="row g-3">
                                <div class="col-md-6 mb-3">
                                    <div class="card payment-method-card">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer" checked>
                                            <label class="form-check-label d-block p-3" for="bank_transfer">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-university fs-4 me-2 text-primary"></i>
                                                    <h6 class="mb-0">Chuyển khoản ngân hàng</h6>
                                                </div>
                                                <p class="mb-0 text-muted small">Chuyển khoản đến tài khoản của chúng tôi</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="card payment-method-card">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_method" id="momo" value="momo">
                                            <label class="form-check-label d-block p-3" for="momo">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-wallet fs-4 me-2 text-danger"></i>
                                                    <h6 class="mb-0">Ví MoMo</h6>
                                                </div>
                                                <p class="mb-0 text-muted small">Thanh toán qua ví điện tử MoMo</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="card payment-method-card">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_method" id="vnpay" value="vnpay">
                                            <label class="form-check-label d-block p-3" for="vnpay">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-credit-card fs-4 me-2 text-info"></i>
                                                    <h6 class="mb-0">VNPay</h6>
                                                </div>
                                                <p class="mb-0 text-muted small">Thanh toán qua cổng thanh toán VNPay</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="card payment-method-card">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_method" id="installment" value="installment">
                                            <label class="form-check-label d-block p-3" for="installment">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-money-bill-wave fs-4 me-2 text-success"></i>
                                                    <h6 class="mb-0">Trả góp</h6>
                                                </div>
                                                <p class="mb-0 text-muted small">Thanh toán trả góp qua các đối tác tài chính</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="bank_transfer_info" class="mt-3 p-3 bg-light rounded">
                                <h6 class="mb-3">Thông tin chuyển khoản</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-unstyled">
                                            <li class="mb-2"><strong>Ngân hàng:</strong> Vietcombank</li>
                                            <li class="mb-2"><strong>Số tài khoản:</strong> 1234567890</li>
                                            <li class="mb-2"><strong>Chủ tài khoản:</strong> CÔNG TY TNHH CÔNG NGHỆ ABC</li>
                                            <li><strong>Nội dung CK:</strong> <span class="text-primary">[Họ tên] học [Tên khóa học]</span></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i> Vui lòng chuyển khoản trong vòng 24h sau khi đăng ký để giữ chỗ.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="card-title">Mã giảm giá</h6>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Nhập mã giảm giá nếu có" id="coupon_code" name="coupon_code">
                                <button class="btn btn-outline-primary" type="button" id="apply_coupon">Áp dụng</button>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-primary prev-step" data-step="4">
                            <i class="fas fa-arrow-left me-2"></i> Quay lại
                        </button>
                        <button type="button" class="btn btn-primary next-step animate-pulse" data-step="4">
                            Hoàn tất đăng ký <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 5: Completion -->
                <div class="registration-section" id="step5">
                    <div class="text-center mb-5">
                        <div class="confirmation-icon mb-4">
                            <i class="fas fa-check"></i>
                        </div>
                        <h4 class="text-success mb-3">Đăng ký khóa học thành công!</h4>
                        <p class="lead">Cảm ơn bạn đã đăng ký khóa học tại trung tâm của chúng tôi.</p>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="card-title">Thông tin đăng ký</h6>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td><strong>Mã đăng ký:</strong></td>
                                        <td id="registration_code">REG-2023-12345</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Khóa học:</strong></td>
                                        <td id="confirmation_course">Lập trình Web Frontend</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Lịch học:</strong></td>
                                        <td id="confirmation_schedule">Tối 2-4-6 (18:30 - 21:30)</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Hình thức:</strong></td>
                                        <td id="confirmation_method">Học offline tại trung tâm</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Ngày khai giảng:</strong></td>
                                        <td id="confirmation_start_date">15/04/2023</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tổng học phí:</strong></td>
                                        <td class="text-primary fw-bold" id="confirmation_total">4,500,000₫</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Thông tin chi tiết về khóa học đã được gửi đến email của bạn. Vui lòng kiểm tra hộp thư để biết thêm thông tin.
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary me-3">
                            <i class="fas fa-home me-2"></i> Về trang chủ
                        </a>
                        <a href="/khoa-hoc" class="btn btn-primary">Khóa học</a>
                            <i class="fas fa-book me-2"></i> Xem thêm khóa học
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Step navigation
        $('.next-step').click(function() {
            const currentStep = parseInt($(this).data('step'));
            const nextStep = currentStep + 1;

            // Validation for Step 1
            if (currentStep === 1) {
                if (!$('#name').val()) {
                    alert('Vui lòng nhập họ và tên');
                    return;
                }
                if (!$('#birthday').val()) {
                    alert('Vui lòng chọn ngày sinh');
                    return;
                }
            }

            // Validation for Step 2
            if (currentStep === 2) {
                if (!$('.course-card.selected').length) {
                    alert('Vui lòng chọn một khóa học');
                    return;
                }
            }

            // Hide current step
            $('#step' + currentStep).removeClass('active');
            // Show next step
            $('#step' + nextStep).addClass('active');
            // Update step indicators
            $('.step').removeClass('active');
            $('.step[data-step="' + nextStep + '"]').addClass('active');

            // Scroll to top
            $('html, body').animate({
                scrollTop: $('.step-progress').offset().top - 100
            }, 500);

            // Update confirmation info in Step 5
            if (nextStep === 5) {
                const courseName = $('.course-card.selected').find('.course-title').text();
                const schedule = $('input[name="schedule"]:checked').next('label').text().trim();
                const method = $('input[name="study_method"]:checked').next('label').text().trim();
                const totalPrice = $('#total-price').text();

                $('#confirmation_course').text(courseName);
                $('#confirmation_schedule').text(schedule);
                $('#confirmation_method').text(method);
                $('#confirmation_total').text(totalPrice);

                // Generate random registration code
                const regCode = 'REG-' + new Date().getFullYear() + '-' + Math.floor(10000 + Math.random() * 90000);
                $('#registration_code').text(regCode);

                // Generate start date (two weeks from now)
                const startDate = new Date();
                startDate.setDate(startDate.getDate() + 14);
                $('#confirmation_start_date').text(startDate.toLocaleDateString('vi-VN'));
            }
        });

        $('.prev-step').click(function() {
            const currentStep = parseInt($(this).data('step'));
            const prevStep = currentStep - 1;

            // Hide current step
            $('#step' + currentStep).removeClass('active');
            // Show previous step
            $('#step' + prevStep).addClass('active');
            // Update step indicators
            $('.step').removeClass('active');
            $('.step[data-step="' + prevStep + '"]').addClass('active');

            // Scroll to top
            $('html, body').animate({
                scrollTop: $('.step-progress').offset().top - 100
            }, 500);
        });

        // Course selection
        $('.course-card').click(function() {
            $('.course-card').removeClass('selected');
            $(this).addClass('selected');

            // Update selected course name and price
            const courseName = $(this).find('.course-title').text();
            const coursePrice = $(this).find('.course-price').text();

            $('#selected-course-name').text(courseName);
            $('#course-base-price').text(coursePrice);
            $('#total-price').text(coursePrice);
        });

        // Province-District dynamic selection
        $('#province').change(function() {
            const province = $(this).val();
            if (province) {
                $('#district').prop('disabled', false);
                // Clear previous options
                $('#district').html('<option value="">-- Chọn Quận/Huyện --</option>');

                // Add district options based on selected province
                if (province === 'hanoi') {
                    const hanoiDistricts = ['Ba Đình', 'Hoàn Kiếm', 'Hai Bà Trưng', 'Đống Đa', 'Tây Hồ', 'Cầu Giấy', 'Thanh Xuân', 'Hoàng Mai'];
                    hanoiDistricts.forEach(function(district) {
                        $('#district').append('<option value="' + district.toLowerCase().replace(/\s+/g, '_') + '">' + district + '</option>');
                    });
                } else if (province === 'hochiminh') {
                    const hcmDistricts = ['Quận 1', 'Quận 2', 'Quận 3', 'Quận 4', 'Quận 5', 'Quận 6', 'Quận 7', 'Quận 8', 'Phú Nhuận', 'Bình Thạnh'];
                    hcmDistricts.forEach(function(district) {
                        $('#district').append('<option value="' + district.toLowerCase().replace(/\s+/g, '_') + '">' + district + '</option>');
                    });
                } else if (province === 'danang') {
                    const danangDistricts = ['Hải Châu', 'Thanh Khê', 'Sơn Trà', 'Ngũ Hành Sơn', 'Liên Chiểu', 'Cẩm Lệ'];
                    danangDistricts.forEach(function(district) {
                        $('#district').append('<option value="' + district.toLowerCase().replace(/\s+/g, '_') + '">' + district + '</option>');
                    });
                }
            } else {
                $('#district').prop('disabled', true);
                $('#district').html('<option value="">-- Chọn Quận/Huyện --</option>');
            }
        });

        // Additional services calculation
        $('input[name="additional_services[]"]').change(function() {
            calculateTotal();
        });

        // Checkbox card selection
        $('.checkbox-card').click(function() {
            const checkbox = $(this).find('input[type="checkbox"]');
            checkbox.prop('checked', !checkbox.prop('checked'));
            $(this).toggleClass('selected');
            calculateTotal();
        });

        // Payment method toggle
        $('input[name="payment_method"]').change(function() {
            const method = $(this).val();
            if (method === 'bank_transfer') {
                $('#bank_transfer_info').show();
            } else {
                $('#bank_transfer_info').hide();
            }
        });

        // Calculate total price
        function calculateTotal() {
            let basePrice = parseInt($('#course-base-price').text().replace(/[^\d]/g, ''));
            let additionalPrice = 0;

            $('input[name="additional_services[]"]:checked').each(function() {
                const servicePrice = parseInt($(this).closest('.checkbox-card').find('.text-primary').text().replace(/[^\d]/g, ''));
                additionalPrice += servicePrice;
            });

            $('#additional-services').text(additionalPrice.toLocaleString('vi-VN') + '₫');
            $('#total-price').text((basePrice + additionalPrice).toLocaleString('vi-VN') + '₫');
        }

        // Initialize first course as selected
        $('.course-card:first').addClass('selected');
        const courseName = $('.course-card:first').find('.course-title').text();
        const coursePrice = $('.course-card:first').find('.course-price').text();
        $('#selected-course-name').text(courseName);
        $('#course-base-price').text(coursePrice);
        $('#total-price').text(coursePrice);

        // Apply coupon
        $('#apply_coupon').click(function() {
            const couponCode = $('#coupon_code').val();
            if (couponCode === 'WELCOME10') {
                const totalPrice = parseInt($('#total-price').text().replace(/[^\d]/g, ''));
                const discount = Math.round(totalPrice * 0.1);
                alert('Áp dụng mã giảm giá thành công! Bạn được giảm ' + discount.toLocaleString('vi-VN') + '₫');
                $('#total-price').text((totalPrice - discount).toLocaleString('vi-VN') + '₫');
                $('#coupon_code').prop('disabled', true);
                $('#apply_coupon').prop('disabled', true).text('Đã áp dụng');
            } else if (couponCode) {
                alert('Mã giảm giá không hợp lệ hoặc đã hết hạn!');
            }
        });
    });
    $(document).ready(function() {
    // Handle "Về trang chủ" button click
    $('.btn:contains("Về trang chủ")').click(function(e) {
        e.preventDefault();
        window.location.href = '/trang-chu';
    });
});
</script>
@endsection

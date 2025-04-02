@extends('layouts.app')

@section('title', 'Trang chủ')

@section('styles')
<style>
    :root {
        --primary-color: #4361ee;
        --primary-hover: #3a56d4;
        --secondary-color: #3f37c9;
        --success-color: #4cc9f0;
        --info-color: #4895ef;
        --warning-color: #f72585;
        --dark-color: #242551;
        --light-color: #f8f9fa;
        --border-radius: 0.75rem;
        --box-shadow: 0 10px 20px rgba(67, 97, 238, 0.1);
        --transition: all 0.3s ease;
    }

    .hero-banner {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: var(--border-radius);
        position: relative;
        overflow: hidden;
        z-index: 1;
        box-shadow: var(--box-shadow);
    }

    .hero-banner::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 400px;
        height: 400px;
        background: radial-gradient(var(--info-color), transparent 70%);
        opacity: 0.2;
        border-radius: 50%;
        transform: translate(30%, -30%);
        z-index: -1;
    }

    .hero-banner::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 300px;
        height: 300px;
        background: radial-gradient(var(--success-color), transparent 70%);
        opacity: 0.2;
        border-radius: 50%;
        transform: translate(-30%, 30%);
        z-index: -1;
    }

    .hero-buttons .btn {
        border-radius: 50px;
        padding: 0.8rem 2rem;
        font-weight: 600;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
    }

    .hero-buttons .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .stats-card {
        border-radius: var(--border-radius);
        border: none;
        transition: var(--transition);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--box-shadow);
    }

    .stats-card .icon-circle {
        width: 80px;
        height: 80px;
        background: rgba(67, 97, 238, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        transition: var(--transition);
    }

    .stats-card:hover .icon-circle {
        background: var(--primary-color);
        color: white;
    }

    .stats-card .fas {
        font-size: 2rem;
        color: var(--primary-color);
        transition: var(--transition);
    }

    .stats-card:hover .fas {
        color: white;
    }

    .stats-card.bg-gradient-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    }

    .stats-card.bg-gradient-primary .icon-circle {
        background: rgba(255, 255, 255, 0.2);
    }

    .stats-card.bg-gradient-primary .fas {
        color: white;
    }

    .course-card {
        border-radius: var(--border-radius);
        overflow: hidden;
        transition: var(--transition);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        border: none;
        margin-bottom: 1.5rem;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--box-shadow);
    }

    .course-card .card-img-top {
        height: 180px;
        object-fit: cover;
    }

    .course-card .card-body {
        padding: 1.5rem;
    }

    .course-card .badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .popular-courses .list-group-item {
        border-left: none;
        border-right: none;
        padding: 1.25rem 1rem;
        transition: var(--transition);
    }

    .popular-courses .list-group-item:hover {
        background-color: rgba(67, 97, 238, 0.05);
        transform: translateX(5px);
    }

    .popular-courses .list-group-item:first-child {
        border-top: none;
    }

    .popular-courses .badge {
        font-size: 0.85rem;
        padding: 0.5rem 0.85rem;
    }

    .product-item {
        border-radius: var(--border-radius);
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .product-item:hover {
        box-shadow: var(--box-shadow);
        border-color: transparent;
    }

    .product-item .product-img {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        overflow: hidden;
        background-color: #f8f9fa;
    }

    .notification-card {
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .notification-item {
        position: relative;
        border-left: none;
        border-right: none;
        transition: var(--transition);
    }

    .notification-item:hover {
        background-color: rgba(67, 97, 238, 0.05);
    }

    .notification-item:first-child {
        border-top: none;
    }

    .notification-indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: var(--primary-color);
        display: inline-block;
        margin-right: 0.5rem;
    }

    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0;
        color: var(--dark-color);
    }

    .info-box {
        border-radius: var(--border-radius);
        border: 1px solid rgba(67, 97, 238, 0.1);
        background-color: rgba(67, 97, 238, 0.02);
        transition: var(--transition);
    }

    .info-box:hover {
        background-color: rgba(67, 97, 238, 0.05);
    }

    .btn-floating {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
        z-index: 999;
        transition: var(--transition);
    }

    .btn-floating:hover {
        transform: scale(1.1);
        background: var(--primary-hover);
    }
</style>
@endsection

@section('content')
<!-- Hero Banner Section -->
<div class="row mb-5">
    <div class="col-12">
        <div class="hero-banner text-white p-5">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="display-4 fw-bold mb-3 animate__animated animate__fadeInUp">Xin chào, {{ Auth::user()->name }}!</h1>
                    <p class="lead mb-4 animate__animated animate__fadeInUp animate__delay-1s">
                        Khám phá nền tảng học tập toàn diện với các công cụ mạnh mẽ để theo dõi,
                        quản lý và đăng ký khóa học một cách dễ dàng.
                    </p>
                    <div class="hero-buttons d-flex gap-3 animate__animated animate__fadeInUp animate__delay-2s">
                        <a href="{{ route('dang-ky-khoa-hoc') }}" class="btn btn-light px-4">
                            <i class="fas fa-book-open me-2"></i>Khám phá khóa học
                        </a>
                        <a href="{{ route('dat-hang.form') }}" class="btn btn-outline-light px-4">
                            <i class="fas fa-shopping-cart me-2"></i>Đặt hàng
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block animate__animated animate__fadeIn animate__delay-3s">
                    <img src="{{ asset('img/dashboard.png') }}" alt="Dashboard" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats Section -->
<div class="row mb-5">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card h-100 bg-gradient-primary text-white">
            <div class="card-body text-center p-4">
                <div class="icon-circle mx-auto">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h5 class="card-title mt-3">Khóa học</h5>
                <h2 class="display-4 fw-bold mt-2 mb-0">12</h2>
                <p class="card-text">Khóa học hiện có</p>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card h-100">
            <div class="card-body text-center p-4">
                <div class="icon-circle mx-auto">
                    <i class="fas fa-users"></i>
                </div>
                <h5 class="card-title mt-3">Học viên</h5>
                <h2 class="display-4 fw-bold mt-2 mb-0">248</h2>
                <p class="card-text">Học viên đã đăng ký</p>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 68%;" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card h-100">
            <div class="card-body text-center p-4">
                <div class="icon-circle mx-auto">
                    <i class="fas fa-certificate"></i>
                </div>
                <h5 class="card-title mt-3">Chứng chỉ</h5>
                <h2 class="display-4 fw-bold mt-2 mb-0">156</h2>
                <p class="card-text">Chứng chỉ đã cấp</p>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card h-100">
            <div class="card-body text-center p-4">
                <div class="icon-circle mx-auto">
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="card-title mt-3">Đánh giá</h5>
                <h2 class="display-4 fw-bold mt-2 mb-0">4.8</h2>
                <p class="card-text">Điểm đánh giá trung bình</p>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 95%;" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Order Section -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0">
                <div class="section-header">
                    <h5 class="section-title"><i class="fas fa-shopping-cart me-2 text-primary"></i>Đặt hàng nhanh</h5>
                    <a href="{{ route('dat-hang.form') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                        <i class="fas fa-arrow-right me-1"></i>Xem tất cả
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-7">
                        <p class="mb-4">Dưới đây là danh sách sách dạy học công nghệ bán chạy nhất. Bạn có thể đặt hàng ngay bây giờ!</p>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="product-item d-flex justify-content-between align-items-center p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="product-img me-3">
                                            <img src="/api/placeholder/80/80" alt="Sách Python" class="img-fluid rounded">
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold">Python cho người mới bắt đầu</h6>
                                            <p class="mb-1 text-muted small">Tác giả: Nguyễn Văn A - Bản mới nhất 2025</p>
                                            <div class="d-flex align-items-center mt-1">
                                                <span class="badge bg-success rounded-pill me-2">Bestseller</span>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <p class="text-primary fw-bold mb-1">290.000₫</p>
                                        <a href="{{ route('dat-hang.form') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                            <i class="fas fa-cart-plus me-1"></i>Thêm
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="product-item d-flex justify-content-between align-items-center p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="product-img me-3">
                                            <img src="/api/placeholder/80/80" alt="Sách JavaScript" class="img-fluid rounded">
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold">Lập trình Web với JavaScript</h6>
                                            <p class="mb-1 text-muted small">Tác giả: Trần Văn B - Phiên bản 2025</p>
                                            <div class="d-flex align-items-center mt-1">
                                                <span class="badge bg-info rounded-pill me-2">Hot</span>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <p class="text-primary fw-bold mb-1">350.000₫</p>
                                        <a href="{{ route('dat-hang.form') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                            <i class="fas fa-cart-plus me-1"></i>Thêm
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="product-item d-flex justify-content-between align-items-center p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="product-img me-3">
                                            <img src="/api/placeholder/80/80" alt="Sách Data Science" class="img-fluid rounded">
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold">Sách học Data Science toàn diện</h6>
                                            <p class="mb-1 text-muted small">Tác giả: Lê Thị C - Kèm bài tập thực hành</p>
                                            <div class="d-flex align-items-center mt-1">
                                                <span class="badge bg-warning text-dark rounded-pill me-2">New</span>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <p class="text-primary fw-bold mb-1">450.000₫</p>
                                        <a href="{{ route('dat-hang.form') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                            <i class="fas fa-cart-plus me-1"></i>Thêm
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card h-100 border-0 info-box">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4">Thông tin mua sắm</h5>
                                <ul class="list-group list-group-flush mb-4">
                                    <li class="list-group-item bg-transparent d-flex align-items-center px-0 py-3 border-top-0">
                                        <div class="me-3">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-truck text-primary"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Miễn phí vận chuyển</h6>
                                            <p class="text-muted mb-0 small">Đơn hàng từ 500.000₫</p>
                                        </div>
                                    </li>
                                    <li class="list-group-item bg-transparent d-flex align-items-center px-0 py-3">
                                        <div class="me-3">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-exchange-alt text-primary"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Đổi trả miễn phí</h6>
                                            <p class="text-muted mb-0 small">Trong vòng 15 ngày</p>
                                        </div>
                                    </li>
                                    <li class="list-group-item bg-transparent d-flex align-items-center px-0 py-3 border-bottom-0">
                                        <div class="me-3">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-gift text-primary"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Khóa học online miễn phí</h6>
                                            <p class="text-muted mb-0 small">Kèm mỗi cuốn sách</p>
                                        </div>
                                    </li>
                                </ul>
                                <div class="d-grid">
                                    <a href="{{ route('dat-hang.form') }}" class="btn btn-primary btn-lg rounded-pill">
                                        <i class="fas fa-shopping-cart me-2"></i>Đặt sách ngay
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Section -->
<div class="row">
    <!-- Popular Courses Section -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0">
                <div class="section-header">
                    <h5 class="section-title"><i class="fas fa-book text-primary me-2"></i>Khóa học phổ biến</h5>
                    <a href="#" class="btn btn-sm btn-primary rounded-pill px-3">
                        <i class="fas fa-th-list me-1"></i>Xem tất cả
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="popular-courses">
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center p-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3 d-flex align-items-center justify-content-center" style="min-width: 60px; height: 60px;">
                                <i class="fab fa-php fa-lg text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="fw-bold mb-0">Lập trình PHP & Laravel</h6>
                                    <span class="badge bg-primary rounded-pill d-flex align-items-center">
                                        4.9 <i class="fas fa-star ms-1"></i>
                                    </span>
                                </div>
                                <p class="mb-0 text-muted small">6 tháng - Chứng chỉ cấp bởi CodeMaster</p>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 98%;" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center p-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3 d-flex align-items-center justify-content-center" style="min-width: 60px; height: 60px;">
                                <i class="fas fa-paint-brush fa-lg text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="fw-bold mb-0">Thiết kế UX/UI chuyên nghiệp</h6>
                                    <span class="badge bg-primary rounded-pill d-flex align-items-center">
                                        4.8 <i class="fas fa-star ms-1"></i>
                                    </span>
                                </div>
                                <p class="mb-0 text-muted small">4 tháng - Chứng chỉ cấp bởi DesignPro</p>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 96%;" aria-valuenow="96" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center p-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3 d-flex align-items-center justify-content-center" style="min-width: 60px; height: 60px;">
                                <i class="fas fa-brain fa-lg text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="fw-bold mb-0">Machine Learning cơ bản</h6>
                                    <span class="badge bg-primary rounded-pill d-flex align-items-center">
                                        4.7 <i class="fas fa-star ms-1"></i>
                                    </span>
                                </div>
                                <p class="mb-0 text-muted small">8 tháng - Chứng chỉ cấp bởi AI Academy</p>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 94%;" aria-valuenow="94" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center p-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3 d-flex align-items-center justify-content-center" style="min-width: 60px; height: 60px;">
                                <i class="fab fa-react fa-lg text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="fw-bold mb-0">Phát triển ứng dụng Web với React</h6>
                                    <span class="badge bg-primary rounded-pill d-flex align-items-center">
                                        4.6 <i class="fas fa-star ms-1"></i>
                                    </span>
                                </div>
                                <p class="mb-0 text-muted small">5 tháng - Chứng chỉ cấp bởi WebDev Pro</p>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 92%;" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center p-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3 d-flex align-items-center justify-content-center" style="min-width: 60px; height: 60px;">
                                <i class="fas fa-mobile-alt fa-lg text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="fw-bold mb-0">Phát triển ứng dụng di động</h6>
                                    <span class="badge bg-primary rounded-pill d-flex align-items-center">
                                        4.5 <i class="fas fa-star ms-1"></i>
                                    </span>
                                </div>
                                <p class="mb-0 text-muted small">7 tháng - Chứng chỉ cấp bởi MobileApps</p>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 90%;" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0 p-4">
                <div class="d-grid">
                    <a href="{{ route('dang-ky-khoa-hoc') }}" class="btn btn-outline-primary rounded-pill">
                        <i class="fas fa-graduation-cap me-2"></i>Khám phá tất cả khóa học
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications Section -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm notification-card h-100">
            <div class="card-header bg-white py-3 border-0">
                <div class="section-header">
                    <h5 class="section-title"><i class="fas fa-bell text-primary me-2"></i>Thông báo mới</h5>
                    <a href="#" class="btn btn-sm btn-primary rounded-pill px-3">
                        <i class="fas fa-check-double me-1"></i>Đã đọc
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush notification-list">
                    <a href="#" class="list-group-item notification-item p-3">
                        <div class="d-flex align-items-center">
                            <div class="notification-indicator bg-success"></div>
                            <div class="ms-2">
                                <h6 class="mb-1 fw-bold">Khóa học mới đã được thêm</h6>
                                <p class="mb-1 small">Khóa học "DevOps cho người mới bắt đầu" đã sẵn sàng.</p>
                                <p class="mb-0 text-muted small">
                                    <i class="fas fa-clock me-1"></i>2 giờ trước
                                </p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item notification-item p-3">
                        <div class="d-flex align-items-center">
                            <div class="notification-indicator bg-warning"></div>
                            <div class="ms-2">
                                <h6 class="mb-1 fw-bold">Nhắc nhở lịch học</h6>
                                <p class="mb-1 small">Bạn có buổi học "Thiết kế UX/UI" vào lúc 19:00 hôm nay.</p>
                                <p class="mb-0 text-muted small">
                                    <i class="fas fa-clock me-1"></i>5 giờ trước
                                </p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item notification-item p-3">
                        <div class="d-flex align-items-center">
                            <div class="notification-indicator bg-info"></div>
                            <div class="ms-2">
                                <h6 class="mb-1 fw-bold">Cập nhật sách mới</h6>
                                <p class="mb-1 small">5 đầu sách công nghệ mới đã được cập nhật trong cửa hàng.</p>
                                <p class="mb-0 text-muted small">
                                    <i class="fas fa-clock me-1"></i>1 ngày trước
                                </p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item notification-item p-3">
                        <div class="d-flex align-items-center">
                            <div class="notification-indicator bg-primary"></div>
                            <div class="ms-2">
                                <h6 class="mb-1 fw-bold">Khuyến mãi đặc biệt</h6>
                                <p class="mb-1 small">Giảm 30% cho khóa học Machine Learning từ 01/04-10/04.</p>
                                <p class="mb-0 text-muted small">
                                    <i class="fas fa-clock me-1"></i>2 ngày trước
                                </p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item notification-item p-3">
                        <div class="d-flex align-items-center">
                            <div class="notification-indicator bg-secondary"></div>
                            <div class="ms-2">
                                <h6 class="mb-1 fw-bold">Bài kiểm tra sắp tới</h6>
                                <p class="mb-1 small">Bài kiểm tra PHP & Laravel sẽ diễn ra vào ngày 10/04/2025.</p>
                                <p class="mb-0 text-muted small">
                                    <i class="fas fa-clock me-1"></i>3 ngày trước
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="card-footer bg-white border-0 p-4">
                <div class="d-grid">
                    <a href="#" class="btn btn-outline-primary rounded-pill">
                        <i class="fas fa-bell me-2"></i>Xem tất cả thông báo
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Events & Progress Section -->
<div class="row mb-5">
    <!-- Upcoming Events -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-0">
                <div class="section-header">
                    <h5 class="section-title"><i class="fas fa-calendar-alt text-primary me-2"></i>Sự kiện sắp tới</h5>
                    <a href="#" class="btn btn-sm btn-primary rounded-pill px-3">
                        <i class="fas fa-plus me-1"></i>Thêm
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="timeline">
                    <div class="timeline-item mb-4 pb-4 border-bottom">
                        <div class="d-flex">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3 d-flex align-items-center justify-content-center" style="min-width: 60px; height: 60px;">
                                <i class="fas fa-laptop-code fa-lg text-primary"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Workshop lập trình React</h6>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-calendar-day me-2"></i>01/04/2025
                                    <i class="fas fa-clock ms-3 me-2"></i>18:00 - 20:00
                                </p>
                                <p class="mb-2 small">Tham gia workshop trực tuyến cùng các chuyên gia hàng đầu về React</p>
                                <div>
                                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill me-2">
                                        <i class="fas fa-video me-1"></i>Tham gia
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill">
                                        <i class="fas fa-info-circle me-1"></i>Chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-item mb-4 pb-4 border-bottom">
                        <div class="d-flex">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3 d-flex align-items-center justify-content-center" style="min-width: 60px; height: 60px;">
                                <i class="fas fa-chalkboard-teacher fa-lg text-primary"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Buổi học trực tuyến: Machine Learning</h6>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-calendar-day me-2"></i>05/04/2025
                                    <i class="fas fa-clock ms-3 me-2"></i>19:00 - 21:00
                                </p>
                                <p class="mb-2 small">Học về các thuật toán Machine Learning cơ bản và ứng dụng thực tế</p>
                                <div>
                                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill me-2">
                                        <i class="fas fa-video me-1"></i>Tham gia
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill">
                                        <i class="fas fa-info-circle me-1"></i>Chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="d-flex">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3 d-flex align-items-center justify-content-center" style="min-width: 60px; height: 60px;">
                                <i class="fas fa-users fa-lg text-primary"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Tech Meetup: Cộng đồng lập trình viên</h6>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-calendar-day me-2"></i>10/04/2025
                                    <i class="fas fa-clock ms-3 me-2"></i>09:00 - 17:00
                                </p>
                                <p class="mb-2 small">Gặp gỡ và chia sẻ kinh nghiệm với cộng đồng lập trình viên Việt Nam</p>
                                <div>
                                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill me-2">
                                        <i class="fas fa-map-marker-alt me-1"></i>Địa điểm
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill">
                                        <i class="fas fa-info-circle me-1"></i>Chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- My Progress -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-0">
                <div class="section-header">
                    <h5 class="section-title"><i class="fas fa-chart-line text-primary me-2"></i>Tiến độ học tập</h5>
                    <a href="#" class="btn btn-sm btn-primary rounded-pill px-3">
                        <i class="fas fa-chevron-right me-1"></i>Chi tiết
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="progress-item mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold mb-0">Lập trình PHP & Laravel</h6>
                        <span class="badge bg-success rounded-pill">75%</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <small class="text-muted">Hoàn thành: 6/8 modules</small>
                        <small class="text-muted">Thời hạn: 15/05/2025</small>
                    </div>
                </div>
                <div class="progress-item mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold mb-0">Machine Learning cơ bản</h6>
                        <span class="badge bg-warning text-dark rounded-pill">45%</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <small class="text-muted">Hoàn thành: 5/12 modules</small>
                        <small class="text-muted">Thời hạn: 30/05/2025</small>
                    </div>
                </div>
                <div class="progress-item mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold mb-0">Thiết kế UX/UI chuyên nghiệp</h6>
                        <span class="badge bg-info rounded-pill">30%</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <small class="text-muted">Hoàn thành: 3/10 modules</small>
                        <small class="text-muted">Thời hạn: 10/06/2025</small>
                    </div>
                </div>
                <div class="progress-item">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold mb-0">Phát triển ứng dụng Web với React</h6>
                        <span class="badge bg-danger rounded-pill">15%</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <small class="text-muted">Hoàn thành: 2/12 modules</small>
                        <small class="text-muted">Thời hạn: 20/06/2025</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Action Button -->
<a href="#" class="btn-floating">
    <i class="fas fa-plus fa-lg"></i>
</a>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Animation for stats cards
        $('.stats-card').each(function(index) {
            $(this).addClass('animate__animated animate__fadeInUp')
                .css('animation-delay', `${index * 0.1}s`);
        });

        // Handle notifications clicking
        $('.notification-item').on('click', function(e) {
            e.preventDefault();
            $(this).find('.notification-indicator').removeClass('bg-success bg-warning bg-info bg-primary bg-secondary')
                .addClass('bg-secondary');
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endsection

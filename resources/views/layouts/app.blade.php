<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hệ thống quản lý ')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0061f2;
            --secondary-color: #6900c7;
            --accent-color: #00cfd5;
            --dark-color: #1f2d41;
            --light-color: #f2f6fc;
            --success-color: #00ac69;
            --danger-color: #e81500;
            --warning-color: #f4a100;
            --info-color: #00cfd5;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            position: relative;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Glass Morphism Effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 15px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(120deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 0.8rem 1rem;
        }

        .navbar-brand {
            font-weight: 700;
            color: white !important;
            font-size: 1.5rem;
            letter-spacing: 0.5px;
        }

        .navbar-brand .logo-icon {
            display: inline-block;
            background: white;
            color: var(--primary-color);
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            border-radius: 50%;
            margin-right: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
            transition: all 0.3s;
        }

        .navbar-brand:hover .logo-icon {
            transform: rotate(360deg);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 600;
            transition: all 0.3s;
            position: relative;
            padding: 0.8rem 1.2rem !important;
            margin: 0 5px;
            border-radius: 30px;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white !important;
            transform: translateY(-2px);
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: white !important;
        }

        .nav-link .icon {
            margin-right: 8px;
            font-size: 1.1rem;
        }

        /* Dropdown */
        .dropdown-menu {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 10px;
            margin-top: 15px;
            animation: fadeInUp 0.4s ease;
        }

        .dropdown-item {
            border-radius: 10px;
            padding: 0.8rem 1.5rem;
            transition: all 0.3s;
            font-weight: 500;
        }

        .dropdown-item:hover {
            background-color: rgba(0, 97, 242, 0.1);
            transform: translateX(5px);
        }

        .dropdown-item i {
            width: 20px;
            margin-right: 10px;
            color: var(--primary-color);
        }

        /* Cards */
        .card {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: none;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(120deg, var(--primary-color), var(--secondary-color));
            color: white;
            font-weight: 600;
            border-bottom: none;
            padding: 1.5rem;
            border-radius: 20px 20px 0 0 !important;
        }

        .card-body {
            padding: 1.8rem;
        }

        /* Buttons */
        .btn {
            border-radius: 30px;
            padding: 0.8rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            z-index: -1;
            transition: all 0.5s;
        }

        .btn:hover::before {
            width: 100%;
        }

        .btn-primary {
            background: linear-gradient(120deg, var(--primary-color), var(--secondary-color));
            border: none;
            box-shadow: 0 10px 20px rgba(0, 97, 242, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(0, 97, 242, 0.4);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: linear-gradient(120deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        /* Forms */
        .form-control {
            border-radius: 15px;
            padding: 0.8rem 1.2rem;
            border: 1px solid rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            font-size: 0.95rem;
            background-color: #f8f9fa;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(0, 97, 242, 0.1);
            border-color: var(--primary-color);
            background-color: white;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }

        .form-floating > .form-control {
            padding: 1.5rem 1rem;
        }

        .form-floating > label {
            padding: 1rem;
        }

        /* Alerts */
        .alert {
            border-radius: 15px;
            padding: 1rem 1.5rem;
            border: none;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
            animation: fadeInDown 0.5s ease;
        }

        .alert::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
        }

        .alert-success {
            background-color: rgba(0, 172, 105, 0.1);
            color: var(--success-color);
        }

        .alert-success::before {
            background-color: var(--success-color);
        }

        .alert-danger {
            background-color: rgba(232, 21, 0, 0.1);
            color: var(--danger-color);
        }

        .alert-danger::before {
            background-color: var(--danger-color);
        }

        /* Page Container */
        .page-container {
            padding-top: 100px;
            min-height: 100vh;
            padding-bottom: 300px;
        }

        /* Dashboard Stats */
        .stats-card {
            border-radius: 20px;
            padding: 1.8rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            background-color: white;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(120deg, var(--primary-color), var(--secondary-color));
        }

        .stats-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .stats-card .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .stats-card .stat-label {
            font-size: 1rem;
            color: #6c757d;
            font-weight: 500;
        }

        .stats-card .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            position: absolute;
            top: 20px;
            right: 20px;
            transition: all 0.3s;
        }

        .stats-card:hover .icon-box {
            transform: scale(1.1) rotate(10deg);
        }

        .stats-card .icon-box.bg-primary {
            background: linear-gradient(120deg, var(--primary-color), var(--secondary-color));
        }

        .stats-card .icon-box.bg-success {
            background: linear-gradient(120deg, var(--success-color), #22c55e);
        }

        .stats-card .icon-box.bg-warning {
            background: linear-gradient(120deg, var(--warning-color), #f97316);
        }

        .stats-card .icon-box.bg-info {
            background: linear-gradient(120deg, var(--info-color), #3b82f6);
        }

        /* Profile */
        .profile-card {
            border-radius: 20px;
            padding: 2rem;
            background-color: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
            transition: all 0.3s;
        }

        .profile-img:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.15);
        }

        /* Sidebar */
        .sidebar {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border-radius: 20px;
            padding: 1.5rem;
            background-color: white;
            height: 100%;
        }

        .sidebar-header {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .sidebar .nav-link {
            color: var(--dark-color) !important;
            padding: 0.8rem 1.2rem !important;
            margin-bottom: 0.5rem;
            border-radius: 10px;
            transition: all 0.3s;
            font-weight: 500;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(0, 97, 242, 0.1);
            color: var(--primary-color) !important;
            transform: translateX(5px);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Footer */
        .footer {
        background-color: var(--dark-color);
        color: white;
        padding: 60px 0 30px;
        position: relative; /* Thay đổi từ absolute sang relative */
        width: 100%;
        margin-top: 50px; /* Thêm margin-top để tạo khoảng cách với nội dung trên */
    }

    /* Điều chỉnh lại container cho nội dụng */
    .page-container {
        padding-top: 100px;
        min-height: 100vh;
        padding-bottom: 30px; /* Giảm padding-bottom */
        display: flex;
        flex-direction: column;
    }

    /* Xóa bỏ các điều chỉnh padding-bottom responsive không cần thiết */
    @media (max-width: 992px) {
        .page-container {
            padding-top: 80px;
            padding-bottom: 30px; /* Giảm padding-bottom */
        }
    }

    @media (max-width: 768px) {
        .page-container {
            padding-bottom: 30px; /* Giảm padding-bottom */
        }
    }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Dark Mode */
        body.dark-mode {
            background-color: #121212;
            color: #e0e0e0;
        }

        body.dark-mode .card,
        body.dark-mode .stats-card,
        body.dark-mode .sidebar,
        body.dark-mode .profile-card {
            background-color: #1e1e1e;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        body.dark-mode .form-control {
            background-color: #2d2d2d;
            border-color: #3d3d3d;
            color: #e0e0e0;
        }

        body.dark-mode .form-control:focus {
            background-color: #2d2d2d;
        }

        body.dark-mode .dropdown-menu {
            background-color: #1e1e1e;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        body.dark-mode .dropdown-item {
            color: #e0e0e0;
        }

        body.dark-mode .dropdown-item:hover {
            background-color: #2d2d2d;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .navbar-brand {
                font-size: 1.3rem;
            }
            .page-container {
                padding-top: 80px;
                padding-bottom: 400px;
            }
        }

        @media (max-width: 768px) {
            .nav-link {
                padding: 0.6rem 1rem !important;
            }
            .page-container {
                padding-bottom: 500px;
            }
        }

        /* Preloader */
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, var(--primary-color), var(--secondary-color));
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preloader .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(120deg, var(--primary-color), var(--secondary-color));
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color);
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="spinner"></div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('trang-chu') }}">
                <span class="logo-icon"><i class="fas fa-graduation-cap"></i></span>
                <span class="d-none d-sm-inline">HỆ THỐNG QUẢN LÝ</span>
                <span class="d-inline d-sm-none">HT QUẢN LÝ</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link animate__animated animate__fadeIn" href="{{ route('dang-nhap') }}">
                                <span class="icon"><i class="fas fa-sign-in-alt"></i></span>Đăng nhập
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link animate__animated animate__fadeIn" href="{{ route('dang-ky') }}">
                                <span class="icon"><i class="fas fa-user-plus"></i></span>Đăng ký
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link animate__animated animate__fadeIn" href="{{ route('trang-chu') }}">
                                <span class="icon"><i class="fas fa-home"></i></span>Trang chủ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link animate__animated animate__fadeIn" href="{{ route('dang-ky-khoa-hoc') }}">
                                <span class="icon"><i class="fas fa-book"></i></span>Đăng ký khóa học
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link animate__animated animate__fadeIn" href="{{ route('phan-hoi') }}">
                                <span class="icon"><i class="fas fa-comment"></i></span>Phản hồi
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle animate__animated animate__fadeIn" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="icon"><i class="fas fa-user-circle"></i></span>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('cap-nhat-ho-so') }}">
                                        <i class="fas fa-user-edit"></i>Cập nhật hồ sơ
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('thay-doi-thong-tin') }}">
                                        <i class="fas fa-cog"></i>Thay đổi thông tin
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" id="toggleDarkMode">
                                        <i class="fas fa-moon"></i>Chế độ tối
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('dang-xuat') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt"></i>Đăng xuất
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Container -->
    <div class="page-container">
        <div class="container">
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

            @yield('content')
        </div>
    </div>

   <!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <h5>Về chúng tôi</h5>
                        <p>Hệ thống quản lý toàn diện, cung cấp các giải pháp hiện đại và tiện ích cho người dùng với công nghệ tiên tiến.</p>
                        <div class="mt-3">
                            <a href="#" class="btn btn-outline-light btn-sm rounded-pill">
                                <i class="fas fa-info-circle me-2"></i>Tìm hiểu thêm
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <h5>Liên kết nhanh</h5>
                        <div class="row">
                            <div class="col-6">
                                <ul class="list-unstyled">
                                    <li><a href="#"><i class="fas fa-chevron-right me-2"></i>Điều khoản</a></li>
                                    <li><a href="#"><i class="fas fa-chevron-right me-2"></i>Bảo mật</a></li>
                                    <li><a href="#"><i class="fas fa-chevron-right me-2"></i>Hỗ trợ</a></li>
                                </ul>
                            </div>
                            <div class="col-6">
                                <ul class="list-unstyled">
                                    <li><a href="#"><i class="fas fa-chevron-right me-2"></i>FAQ</a></li>
                                    <li><a href="#"><i class="fas fa-chevron-right me-2"></i>Liên hệ</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <h5>Thông tin liên hệ</h5>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-map-marker-alt me-2"></i>123 Đường ABC, Quận XYZ</li>
                            <li><i class="fas fa-phone-alt me-2"></i>(+84) 123 456 789</li>
                            <li><i class="fas fa-envelope me-2"></i>info@hethongquanly.com</li>
                            <li><i class="fas fa-clock me-2"></i>Thứ 2 - Thứ 6: 8:00 - 17:00</li>
                        </ul>
                        <div class="social-links mt-3">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom text-center mt-3">
            <p class="mb-0">&copy; {{ date('Y') }} Hệ thống quản lý. Thiết kế & phát triển bởi <span class="fw-bold">anhhieu</span></p>
        </div>
    </div>
</footer>

    <!-- Back to top button -->
    <button id="back-to-top" class="btn btn-primary rounded-circle position-fixed" style="bottom: 20px; right: 20px; width: 50px; height: 50px; z-index: 99; display: none;">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Preloader
            setTimeout(function() {
                $('.preloader').fadeOut(500);
            }, 1000);

            // Animate elements on scroll
            function animateOnScroll() {
                $('.card, .stats-card, .btn-primary, .profile-card').each(function() {
                    var bottom_of_object = $(this).offset().top + $(this).outerHeight();
                    var bottom_of_window = $(window).scrollTop() + $(window).height();
                    if (bottom_of_window > bottom_of_object) {
                        $(this).addClass('animate__animated animate__fadeInUp');
                    }
                });
            }

            $(window).scroll(function() {
                animateOnScroll();
                // Back to top button
                if ($(window).scrollTop() > 300) {
                    $('#back-to-top').fadeIn();
                } else {
                    $('#back-to-top').fadeOut();
                }
            });

            // Click event to scroll to top
            $('#back-to-top').click(function() {
                $('html, body').animate({scrollTop : 0}, 800);
                return false;
            });

            // Activate current nav item
            const currentLocation = location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentLocation) {
                    link.classList.add('active');
                }
            });

            // Toggle dark mode
            const darkMode = localStorage.getItem('darkMode');

            // Check if dark mode was previously enabled
            if (darkMode === 'enabled') {
                document.body.classList.add('dark-mode');
                $('#toggleDarkMode i').removeClass('fa-moon').addClass('fa-sun');
            }

            // Toggle dark mode on button click
            $('#toggleDarkMode').click(function(e) {
                e.preventDefault();
                if (document.body.classList.contains('dark-mode')) {
                    document.body.classList.remove('dark-mode');
                    localStorage.setItem('darkMode', null);
                    $('#toggleDarkMode i').removeClass('fa-sun').addClass('fa-moon');
                } else {
                    document.body.classList.add('dark-mode');
                    localStorage.setItem('darkMode', 'enabled');
                    $('#toggleDarkMode i').removeClass('fa-moon').addClass('fa-sun');
                }
            });

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);

            // Initialize first animation
            animateOnScroll();
        });
        $(document).ready(function() {
        // Chỉnh sửa cách xử lý hiển thị footer
        function adjustFooter() {
            // Lấy tổng chiều cao của trang
            var docHeight = $(window).height();
            // Lấy chiều cao của phần footer
            var footerHeight = $('.footer').outerHeight();
            // Lấy vị trí của footer từ đầu trang
            var footerTop = $('.footer').position().top + footerHeight;

            // Nếu nội dung quá ngắn, footer sẽ được đẩy xuống dưới
            if (footerTop < docHeight) {
                $('.footer').css('margin-top', (docHeight - footerTop) + 'px');
            }
        }

        // Chạy khi trang tải xong và khi thay đổi kích thước cửa sổ
        adjustFooter();
        $(window).resize(function() {
            adjustFooter();
        });
    });
    </script>
    @yield('scripts')
</body>
</html>

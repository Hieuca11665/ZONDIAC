<?php
require_once 'config.php';

// Debug function (có thể bỏ comment để test)
// debug_cart();

// Xử lý tìm kiếm
$search = '';
if (isset($_GET['search'])) {
    $search = clean_input($_GET['search']);
}

// Xử lý thêm vào giỏ hàng
if (isset($_POST['add_to_cart'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    
    if ($product_id > 0 && $quantity > 0) {
        // Kiểm tra sản phẩm có tồn tại và có sẵn không
        $check_sql = "SELECT id, so_luong, ten_sp FROM tbl_sanpham WHERE id = :id AND trang_thai = 'active'";
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
        $check_stmt->execute();
        $product = $check_stmt->fetch();
        
        if ($product && $product['so_luong'] >= $quantity) {
            // Khởi tạo session cart nếu chưa có
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }
            
            // Thêm hoặc cập nhật số lượng
            if (isset($_SESSION['cart'][$product_id])) {
                $new_quantity = $_SESSION['cart'][$product_id] + $quantity;
                // Kiểm tra không vượt quá số lượng có sẵn
                if ($new_quantity <= $product['so_luong']) {
                    $_SESSION['cart'][$product_id] = $new_quantity;
                    $success_message = "Đã cập nhật số lượng sản phẩm trong giỏ hàng!";
                } else {
                    $success_message = "Không thể thêm vượt quá số lượng có sẵn!";
                }
            } else {
                $_SESSION['cart'][$product_id] = $quantity;
                $success_message = "Đã thêm sản phẩm vào giỏ hàng!";
            }
            
            // Lưu thông báo vào session và redirect
            $_SESSION['success_message'] = $success_message;
            $redirect_url = $_SERVER['PHP_SELF'];
            if (!empty($search)) {
                $redirect_url .= "?search=" . urlencode($search);
            }
            header("Location: " . $redirect_url);
            exit();
        } else {
            $_SESSION['success_message'] = "Sản phẩm không tồn tại hoặc không đủ số lượng!";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
}

// Hiển thị thông báo từ session nếu có
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // Xóa thông báo sau khi hiển thị
}

// Lấy danh sách sản phẩm
$sql = "SELECT * FROM tbl_sanpham WHERE trang_thai = 'active'";
if ($search) {
    $sql .= " AND ten_sp LIKE :search";
}
$sql .= " ORDER BY ngay_tao DESC";

try {
    $stmt = $pdo->prepare($sql);
    if ($search) {
        $stmt->bindValue(':search', '%' . $search . '%');
    }
    $stmt->execute();
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    $products = [];
    error_log("Database error: " . $e->getMessage());
}

// Đếm số lượng sản phẩm trong giỏ hàng
$cart_count = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $cart_count = array_sum($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo defined('SITE_NAME') ? SITE_NAME : 'Phone Store'; ?> - Điện thoại, laptop, tablet, phụ kiện chính hãng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f8f8f8;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 16px;
        }

        /* Header Styles - CellphoneS Style */
        .header {
            background: #d70018;
            color: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-top {
            background: #b91821;
            padding: 6px 0;
            font-size: 12px;
        }

        .header-top .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-top-left {
            display: flex;
            gap: 24px;
        }

        .header-top-item {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #fff;
            text-decoration: none;
        }

        .header-top-item:hover {
            opacity: 0.8;
        }

        .header-main {
            padding: 12px 0;
        }

        .header-content {
            display: grid;
            grid-template-columns: 200px 1fr auto;
            align-items: center;
            gap: 24px;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 28px;
            font-weight: 800;
            text-decoration: none;
            color: white;
            letter-spacing: -0.5px;
        }

        .logo i {
            margin-right: 8px;
            font-size: 32px;
        }

        .search-container {
            max-width: 500px;
        }

        .search-form {
            display: flex;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            border: 1px solid #e0e0e0;
        }

        .search-input {
            flex: 1;
            padding: 12px 16px;
            border: none;
            outline: none;
            font-size: 14px;
            background: transparent;
        }

        .search-input::placeholder {
            color: #999;
        }

        .search-btn {
            background: #d70018;
            border: none;
            color: white;
            padding: 12px 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }

        .search-btn:hover {
            background: #b91821;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .cart-link {
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 6px;
            transition: all 0.3s;
        }

        .cart-link:hover {
            background: rgba(255,255,255,0.1);
        }

        .cart-link i {
            font-size: 20px;
        }

        .cart-count {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #ffa500;
            color: white;
            border-radius: 10px;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
        }

        .btn {
            padding: 8px 16px;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.3s;
            font-size: 13px;
            font-weight: 500;
        }

        .btn:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.5);
        }

        /* Navigation - CellphoneS Style */
        .nav {
            background: white;
            border-bottom: 1px solid #e5e5e5;
            padding: 0;
        }

        .nav-container {
            display: flex;
            align-items: center;
            overflow-x: auto;
        }

        .nav-menu {
            list-style: none;
            display: flex;
            margin: 0;
            white-space: nowrap;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 16px 20px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s;
            border-bottom: 2px solid transparent;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #d70018;
            border-bottom-color: #d70018;
        }

        .nav-link i {
            margin-right: 8px;
            font-size: 16px;
        }

        /* Category Banner */
        .category-banner {
            background: linear-gradient(135deg, #d70018 0%, #b91821 100%);
            color: white;
            padding: 20px 0;
            margin-bottom: 24px;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 16px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .category-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 16px 12px;
            background: rgba(255,255,255,0.1);
            border-radius: 12px;
            text-decoration: none;
            color: white;
            transition: all 0.3s;
            backdrop-filter: blur(10px);
        }

        .category-item:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }

        .category-icon {
            font-size: 32px;
            margin-bottom: 8px;
        }

        .category-name {
            font-size: 13px;
            font-weight: 500;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            padding: 0;
        }

        /* Alert */
        .alert {
            padding: 16px 20px;
            margin: 16px 0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-success {
            background: #e8f5e8;
            color: #2e7d2e;
            border-left: 4px solid #4caf50;
        }

        /* Filter Section */
        .filter-section {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .clear-filter {
            margin-bottom: 16px;
        }

        .btn-clear {
            background: #f5f5f5;
            color: #666;
            border: 1px solid #ddd;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-clear:hover {
            background: #e9e9e9;
            border-color: #ccc;
        }

        /* Section Header */
        .section-header {
            background: white;
            padding: 24px 20px;
            margin-bottom: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .section-title {
            font-size: 28px;
            color: #333;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .section-subtitle {
            color: #666;
            font-size: 15px;
        }

        /* Products Grid - CellphoneS Style */
        .products-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            padding: 20px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 16px;
        }

        .product-card {
            background: white;
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            border-color: #d70018;
        }

        .product-image {
            position: relative;
            height: 200px;
            background: #fafafa;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 16px;
            transition: transform 0.3s;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .product-image i {
            font-size: 48px;
            color: #ddd;
        }

        .product-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            background: #ff4444;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }

        .product-info {
            padding: 16px;
        }

        .product-name {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            line-height: 1.4;
            height: 40px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-price {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .current-price {
            font-size: 16px;
            font-weight: 700;
            color: #d70018;
        }

        .original-price {
            font-size: 13px;
            color: #999;
            text-decoration: line-through;
        }

        .discount-badge {
            background: #ff4444;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 4px;
            margin-bottom: 8px;
        }

        .stars {
            color: #ffc107;
            font-size: 12px;
        }

        .rating-text {
            font-size: 12px;
            color: #666;
        }

        .product-features {
            margin-bottom: 12px;
        }

        .feature-list {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }

        .feature-tag {
            background: #f0f0f0;
            color: #666;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 500;
        }

        .product-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .quantity-input {
            width: 50px;
            padding: 6px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
            font-size: 12px;
        }

        .btn-add-cart {
            flex: 1;
            background: #d70018;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-add-cart:hover:not(:disabled) {
            background: #b91821;
            transform: translateY(-1px);
        }

        .btn-add-cart:disabled {
            background: #e0e0e0;
            color: #999;
            cursor: not-allowed;
        }

        .btn-out-of-stock {
            flex: 1;
            background: #e0e0e0;
            color: #999;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: not-allowed;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .stock-info {
            font-size: 11px;
            color: #28a745;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Empty State */
        .empty-state {
            grid-column: 1/-1;
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 64px;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 20px;
            color: #333;
            margin-bottom: 8px;
        }

        .empty-state p {
            color: #666;
            font-size: 14px;
        }

        /* Footer - CellphoneS Style */
        .footer {
            background: #333;
            color: #ccc;
            padding: 40px 0 20px;
            margin-top: 40px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .footer-section h4 {
            margin-bottom: 16px;
            color: #d70018;
            font-size: 16px;
            font-weight: 600;
        }

        .footer-section p,
        .footer-section a {
            color: #999;
            text-decoration: none;
            line-height: 1.6;
            font-size: 14px;
            display: block;
            margin-bottom: 8px;
        }

        .footer-section a:hover {
            color: #d70018;
        }

        .footer-section i {
            margin-right: 8px;
            width: 16px;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #444;
            color: #666;
            font-size: 13px;
        }

        .social-links {
            display: flex;
            gap: 12px;
            margin-top: 16px;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: #444;
            border-radius: 50%;
            color: #ccc;
            text-decoration: none;
            transition: all 0.3s;
        }

        .social-link:hover {
            background: #d70018;
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-content {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .search-container {
                max-width: 100%;
            }

            .header-actions {
                justify-content: center;
                gap: 16px;
            }

            .category-grid {
                grid-template-columns: repeat(4, 1fr);
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
                gap: 12px;
            }

            .nav-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .nav-menu {
                padding: 0 16px;
            }

            .section-title {
                font-size: 22px;
            }

            .container {
                padding: 0 12px;
            }
        }

        @media (max-width: 480px) {
            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .category-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .product-name {
                font-size: 13px;
                height: 36px;
            }

            .current-price {
                font-size: 14px;
            }
        }

        /* Loading Animation */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .products-grid .product-card {
            animation: slideInUp 0.6s ease-out forwards;
        }

        .products-grid .product-card:nth-child(odd) {
            animation-delay: 0.1s;
        }

        .products-grid .product-card:nth-child(even) {
            animation-delay: 0.2s;
        }

        .out-stock {
            background: #ff4444 !important;
            color: white !important;
        }

        .text-muted {
            color: #ddd !important;
        }

        .add-to-cart-form {
            width: 100%;
        }

        /* Loading state */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .btn-loading {
            position: relative;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <!-- Header Top -->
        <div class="header-top">
            <div class="container">
                <div class="header-top-left">
                    <a href="tel:18002097" class="header-top-item">
                        <i class="fas fa-phone"></i>
                        <span>Gọi mua hàng 1800.2097</span>
                    </a>
                    <a href="#" class="header-top-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Cửa hàng gần bạn</span>
                    </a>
                </div>
                <div class="header-top-right">
                    <a href="#" class="header-top-item">
                        <i class="fas fa-search"></i>
                        <span>Tra cứu đơn hàng</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Header Main -->
        <div class="header-main">
            <div class="container">
                <div class="header-content">
                    <a href="index.php" class="logo">
                        <i class="fas fa-mobile-alt"></i>
                        <?php echo defined('SITE_NAME') ? SITE_NAME : 'Phone Store'; ?>
                    </a>
                    
                    <div class="search-container">
                        <form method="GET" action="index.php" class="search-form">
                            <input type="text" name="search" class="search-input" 
                                   placeholder="Bạn cần tìm gì?" 
                                   value="<?php echo htmlspecialchars($search); ?>">
                            <button type="submit" class="search-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                    
                    <div class="header-actions">
                        <a href="cart.php" class="cart-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Giỏ hàng</span>
                            <?php if ($cart_count > 0): ?>
                                <span class="cart-count"><?php echo $cart_count; ?></span>
                            <?php endif; ?>
                        </a>
                        
                        <div class="user-info">
                            <?php if (function_exists('is_logged_in') && is_logged_in()): ?>
                                <span>Xin chào, <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'User'; ?></span>
                                <a href="logout.php" class="btn">Đăng xuất</a>
                            <?php else: ?>
                                <a href="login.php" class="btn">Đăng nhập</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="nav">
            <div class="container">
                <div class="nav-container">
                    <ul class="nav-menu">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link active">
                                <i class="fas fa-home"></i>
                                Trang chủ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="products.php" class="nav-link">
                                <i class="fas fa-mobile-alt"></i>
                                Điện thoại
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="products.php" class="nav-link">
                                <i class="fas fa-laptop"></i>
                                Laptop
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="products.php" class="nav-link">
                                <i class="fas fa-tablet-alt"></i>
                                Tablet
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="products.php" class="nav-link">
                                <i class="fas fa-headphones"></i>
                                Phụ kiện
                            </a>
                        </li>
                        <?php if (function_exists('is_logged_in') && is_logged_in()): ?>
                            <li class="nav-item">
                                <a href="orders.php" class="nav-link">
                                    <i class="fas fa-box"></i>
                                    Đơn hàng
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (function_exists('is_admin') && is_admin()): ?>
                            <li class="nav-item">
                                <a href="admin/" class="nav-link">
                                    <i class="fas fa-cog"></i>
                                    Quản trị
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Category Banner -->
    <section class="category-banner">
        <div class="container">
            <div class="category-grid">
                <a href="?search=iPhone" class="category-item">
                    <div class="category-icon">📱</div>
                    <div class="category-name">Điện thoại</div>
                </a>
                <a href="?search=laptop" class="category-item">
                    <div class="category-icon">💻</div>
                    <div class="category-name">Laptop</div>
                </a>
                <a href="?search=watch" class="category-item">
                    <div class="category-icon">⌚</div>
                    <div class="category-name">Đồng hồ</div>
                </a>
                <a href="?search=audio" class="category-item">
                    <div class="category-icon">🎧</div>
                    <div class="category-name">Âm thanh</div>
                </a>
                <a href="?search=tablet" class="category-item">
                    <div class="category-icon">📱</div>
                    <div class="category-name">Tablet</div>
                </a>
                <a href="?search=phụ kiện" class="category-item">
                    <div class="category-icon">🔌</div>
                    <div class="category-name">Phụ kiện</div>
                </a>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <?php if ($search): ?>
                <div class="filter-section">
                    <div class="clear-filter">
                        <a href="index.php" class="btn-clear">
                            <i class="fas fa-times"></i> Xóa bộ lọc
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Section Header -->
            <div class="section-header">
                <?php if ($search): ?>
                    <h1 class="section-title">Kết quả tìm kiếm cho: "<?php echo htmlspecialchars($search); ?>"</h1>
                    <p class="section-subtitle">Tìm thấy <?php echo count($products); ?> sản phẩm</p>
                <?php else: ?>
                    <h1 class="section-title">Sản phẩm nổi bật</h1>
                    <p class="section-subtitle">Khám phá những sản phẩm công nghệ mới nhất với giá tốt nhất</p>
                <?php endif; ?>
            </div>

            <!-- Products Container -->
            <div class="products-container">
                <div class="products-grid">
                    <?php if (count($products) > 0): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="product-card">
                                <!-- Product Badge -->
                                <?php 
                                // Tính toán giảm giá ngẫu nhiên cho demo
                                $discount = rand(5, 30);
                                $original_price = $product['gia'] * (1 + $discount/100);
                                ?>
                                <div class="product-badge">
                                    -<?php echo $discount; ?>%
                                </div>

                                <!-- Product Image -->
                                <div class="product-image">
                                    <?php if (!empty($product['hinh_anh']) && file_exists('uploads/' . $product['hinh_anh'])): ?>
                                        <img src="uploads/<?php echo htmlspecialchars($product['hinh_anh']); ?>" 
                                             alt="<?php echo htmlspecialchars($product['ten_sp']); ?>"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <i class="fas fa-mobile-alt" style="display: none;"></i>
                                    <?php else: ?>
                                        <!-- Hiển thị icon mặc định dựa trên danh mục -->
                                        <?php
                                        $icon = 'fas fa-mobile-alt'; // mặc định
                                        if (stripos($product['danh_muc'], 'laptop') !== false) {
                                            $icon = 'fas fa-laptop';
                                        } elseif (stripos($product['danh_muc'], 'tablet') !== false) {
                                            $icon = 'fas fa-tablet-alt';
                                        } elseif (stripos($product['danh_muc'], 'watch') !== false) {
                                            $icon = 'fas fa-clock';
                                        }
                                        ?>
                                        <i class="<?php echo $icon; ?>"></i>
                                    <?php endif; ?>
                                </div>

                                <!-- Product Info -->
                                <div class="product-info">
                                    <h3 class="product-name">
                                        <?php echo htmlspecialchars($product['ten_sp']); ?>
                                    </h3>

                                    <!-- Product Rating -->
                                    <div class="product-rating">
                                        <div class="stars">
                                            <?php 
                                            $rating = rand(4, 5); // Random rating cho demo
                                            for ($i = 1; $i <= 5; $i++): 
                                            ?>
                                                <i class="fas fa-star <?php echo $i <= $rating ? '' : 'text-muted'; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <span class="rating-text">(<?php echo rand(50, 500); ?>)</span>
                                    </div>

                                    <!-- Product Price -->
                                    <div class="product-price">
                                        <span class="current-price">
                                            <?php echo format_currency($product['gia']); ?>
                                        </span>
                                        <span class="original-price">
                                            <?php echo format_currency($original_price); ?>
                                        </span>
                                        <span class="discount-badge">
                                            -<?php echo $discount; ?>%
                                        </span>
                                    </div>

                                    <!-- Product Features -->
                                    <div class="product-features">
                                        <div class="feature-list">
                                            <span class="feature-tag">Chính hãng</span>
                                            <span class="feature-tag">Bảo hành 12T</span>
                                            <?php if ($product['so_luong'] > 0): ?>
                                                <span class="feature-tag">Còn hàng</span>
                                            <?php else: ?>
                                                <span class="feature-tag out-stock">Hết hàng</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Product Actions -->
                                    <?php if ($product['so_luong'] > 0): ?>
                                        <form method="POST" action="index.php<?php echo !empty($search) ? '?search=' . urlencode($search) : ''; ?>" class="add-to-cart-form">
                                            <div class="product-actions">
                                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                <input type="number" name="quantity" value="1" min="1" 
                                                       max="<?php echo $product['so_luong']; ?>" class="quantity-input">
                                                <button type="submit" name="add_to_cart" class="btn-add-cart">
                                                    <i class="fas fa-cart-plus"></i>
                                                    Thêm vào giỏ
                                                </button>
                                            </div>
                                            <div class="stock-info">
                                                <i class="fas fa-check-circle"></i>
                                                Còn <?php echo $product['so_luong']; ?> sản phẩm
                                            </div>
                                        </form>
                                    <?php else: ?>
                                        <div class="product-actions">
                                            <button class="btn-out-of-stock" disabled>
                                                <i class="fas fa-ban"></i>
                                                Hết hàng
                                            </button>
                                        </div>
                                        <div class="stock-info" style="color: #dc3545;">
                                            <i class="fas fa-times-circle"></i>
                                            Tạm hết hàng
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-search"></i>
                            <h3>Không tìm thấy sản phẩm</h3>
                            <p>Thử lại với từ khóa khác hoặc xem tất cả sản phẩm</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4><?php echo defined('SITE_NAME') ? SITE_NAME : 'Phone Store'; ?></h4>
                    <p>Hệ thống bán lẻ điện thoại, laptop, tablet, phụ kiện chính hãng mới nhất, giá tốt, dịch vụ bảo hành uy tín tại Việt Nam.</p>
                    <div class="social-links">
                        <a href="#" class="social-link">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>
                </div>

                <div class="footer-section">
                    <h4>Thông tin</h4>
                    <a href="#"><i class="fas fa-angle-right"></i>Giới thiệu</a>
                    <a href="#"><i class="fas fa-angle-right"></i>Tin tức</a>
                    <a href="#"><i class="fas fa-angle-right"></i>Tuyển dụng</a>
                    <a href="#"><i class="fas fa-angle-right"></i>Hệ thống cửa hàng</a>
                    <a href="#"><i class="fas fa-angle-right"></i>Liên hệ</a>
                </div>

                <div class="footer-section">
                    <h4>Chính sách</h4>
                    <a href="#"><i class="fas fa-angle-right"></i>Chính sách bảo hành</a>
                    <a href="#"><i class="fas fa-angle-right"></i>Chính sách đổi trả</a>
                    <a href="#"><i class="fas fa-angle-right"></i>Chính sách giao hàng</a>
                    <a href="#"><i class="fas fa-angle-right"></i>Điều khoản sử dụng</a>
                    <a href="#"><i class="fas fa-angle-right"></i>Chính sách bảo mật</a>
                </div>

                <div class="footer-section">
                    <h4>Liên hệ</h4>
                    <p><i class="fas fa-map-marker-alt"></i>123 Đường ABC, Quận 1, TP.HCM</p>
                    <p><i class="fas fa-phone"></i>1800.2097 (miễn phí)</p>
                    <p><i class="fas fa-envelope"></i>support@phonestore.com</p>
                    <p><i class="fas fa-clock"></i>08:00 - 22:00 (T2-CN)</p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2024 <?php echo defined('SITE_NAME') ? SITE_NAME : 'Phone Store'; ?>. All rights reserved. | Thiết kế và phát triển bởi Team Dev</p>
            </div>
        </div>
    </footer>

    <script>
        // Add to cart with better UX
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const button = this.querySelector('.btn-add-cart');
                const originalText = button.innerHTML;
                const productCard = this.closest('.product-card');
                
                // Disable button and show loading
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang thêm...';
                button.disabled = true;
                productCard.classList.add('loading');
                
                // Allow form submission to continue
                setTimeout(() => {
                    button.innerHTML = '<i class="fas fa-check"></i> Đã thêm';
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                        productCard.classList.remove('loading');
                    }, 1500);
                }, 800);
            });
        });

        // Auto-hide success message
        const alertSuccess = document.querySelector('.alert-success');
        if (alertSuccess) {
            setTimeout(() => {
                alertSuccess.style.opacity = '0';
                alertSuccess.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    alertSuccess.remove();
                }, 300);
            }, 4000);
        }

        // Product card hover effects
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
                this.style.boxShadow = '0 12px 30px rgba(0,0,0,0.2)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(-4px)';
                this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
            });
        });

        // Quantity input validation
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const min = parseInt(this.min);
                const max = parseInt(this.max);
                let value = parseInt(this.value);
                
                if (value < min) this.value = min;
                if (value > max) this.value = max;
            });
        });

        // Category items click effect
        document.querySelectorAll('.category-item').forEach(item => {
            item.addEventListener('click', function(e) {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });
    </script>
</body>
</html>
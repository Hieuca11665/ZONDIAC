<?php
require_once 'config.php';

// Debug để kiểm tra giỏ hàng (có thể bỏ comment để test)
// debug_cart();

// Xử lý cập nhật giỏ hàng
if (isset($_POST['update_cart'])) {
    if (isset($_POST['quantities']) && is_array($_POST['quantities'])) {
        foreach ($_POST['quantities'] as $product_id => $quantity) {
            $product_id = (int)$product_id;
            $quantity = (int)$quantity;
            
            if ($quantity <= 0) {
                unset($_SESSION['cart'][$product_id]);
            } else {
                $_SESSION['cart'][$product_id] = $quantity;
            }
        }
    }
    $success_message = "Đã cập nhật giỏ hàng!";
}

// Xử lý xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['remove'])) {
    $product_id = (int)$_GET['remove'];
    unset($_SESSION['cart'][$product_id]);
    $success_message = "Đã xóa sản phẩm khỏi giỏ hàng!";
    // Redirect để tránh reload trang gây lỗi
    header("Location: cart.php");
    exit();
}

// Xóa toàn bộ giỏ hàng
if (isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = array();
    $success_message = "Đã xóa toàn bộ giỏ hàng!";
}

// Lấy thông tin sản phẩm trong giỏ hàng
$cart_products = array();
$total_amount = 0;

if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $product_ids = array_keys($_SESSION['cart']);
    
    if (!empty($product_ids)) {
        $placeholders = str_repeat('?,', count($product_ids) - 1) . '?';
        $sql = "SELECT * FROM tbl_sanpham WHERE id IN ($placeholders) AND trang_thai = 'active'";
        
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($product_ids);
            $products = $stmt->fetchAll();
            
            foreach ($products as $product) {
                $product_id = $product['id'];
                if (isset($_SESSION['cart'][$product_id])) {
                    $quantity = $_SESSION['cart'][$product_id];
                    $subtotal = $product['gia'] * $quantity;
                    $total_amount += $subtotal;
                    
                    $cart_products[] = array(
                        'product' => $product,
                        'quantity' => $quantity,
                        'subtotal' => $subtotal
                    );
                }
            }
        } catch (PDOException $e) {
            error_log("Cart query error: " . $e->getMessage());
            $cart_products = array();
        }
    }
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
    <title>Giỏ hàng - <?php echo SITE_NAME; ?></title>
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

        /* Header Styles - Same as index.php */
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

        /* Navigation */
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

        /* Main Content */
        .main-content {
            padding: 24px 0;
        }

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
            display: flex;
            align-items: center;
            gap: 12px;
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

        /* Debug styles */
        .debug-info {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 16px;
            border-radius: 8px;
            margin: 16px 0;
            font-family: monospace;
            font-size: 12px;
        }

        /* Cart Styles */
        .cart-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            padding: 24px;
            margin-bottom: 24px;
        }

        .empty-cart {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-cart i {
            font-size: 64px;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-cart h3 {
            font-size: 24px;
            color: #333;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .empty-cart p {
            color: #666;
            font-size: 16px;
            margin-bottom: 24px;
        }

        .btn-primary {
            background: #d70018;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background: #b91821;
        }

        .cart-table {
            overflow-x: auto;
            margin-bottom: 24px;
        }

        .cart-table table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        .cart-table th,
        .cart-table td {
            padding: 16px 12px;
            text-align: left;
            border-bottom: 1px solid #e5e5e5;
        }

        .cart-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .cart-table td {
            font-size: 14px;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .product-image {
            width: 60px;
            height: 60px;
            background: #f8f8f8;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-image i {
            font-size: 24px;
            color: #ddd;
        }

        .product-details h4 {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .product-category {
            color: #666;
            font-size: 13px;
        }

        .product-price {
            font-size: 16px;
            font-weight: 600;
            color: #d70018;
        }

        .quantity-input {
            width: 80px;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            text-align: center;
            font-size: 14px;
        }

        .subtotal {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .btn-danger {
            background: #ff4444;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }

        .btn-danger:hover {
            background: #e73c3c;
        }

        .btn-warning {
            background: #ffa500;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-warning:hover {
            background: #ff8c00;
        }

        .cart-actions {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
        }

        .cart-summary {
            background: #f8f9fa;
            padding: 24px;
            border-radius: 12px;
            border: 2px solid #e5e5e5;
        }

        .summary-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .summary-title {
            font-size: 20px;
            font-weight: 700;
            color: #333;
        }

        .summary-details {
            text-align: right;
        }

        .total-items {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }

        .total-price {
            font-size: 24px;
            font-weight: 700;
            color: #d70018;
        }

        .summary-actions {
            display: flex;
            gap: 16px;
            justify-content: flex-end;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.3s;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .btn-success {
            background: #28a745;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.3s;
        }

        .btn-success:hover {
            background: #218838;
        }

        /* Footer */
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

        /* Responsive */
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

            .cart-actions {
                flex-direction: column;
            }

            .summary-actions {
                flex-direction: column;
            }

            .summary-header {
                flex-direction: column;
                gap: 16px;
            }

            .summary-details {
                text-align: left;
            }
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
                        <?php echo SITE_NAME; ?>
                    </a>
                    
                    <div class="search-container">
                        <form method="GET" action="index.php" class="search-form">
                            <input type="text" name="search" class="search-input" 
                                   placeholder="Bạn cần tìm gì?">
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
                            <?php if (is_logged_in()): ?>
                                <span>Xin chào, <?php echo $_SESSION['user_name']; ?></span>
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
                            <a href="index.php" class="nav-link">
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
                        <?php if (is_logged_in()): ?>
                            <li class="nav-item">
                                <a href="orders.php" class="nav-link">
                                    <i class="fas fa-box"></i>
                                    Đơn hàng
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (is_admin()): ?>
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

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header">
                <h1 class="section-title">
                    <i class="fas fa-shopping-cart"></i>
                    Giỏ hàng của bạn
                </h1>
            </div>
            
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <!-- Debug info (bỏ comment để kiểm tra) -->
            <?php if (isset($_GET['debug'])): ?>
                <div class="debug-info">
                    <strong>Debug Info:</strong><br>
                    Session Cart: <?php print_r($_SESSION['cart']); ?><br>
                    Cart Count: <?php echo $cart_count; ?><br>
                    Products Found: <?php echo count($cart_products); ?>
                </div>
            <?php endif; ?>

            <?php if (empty($cart_products)): ?>
                <div class="cart-container">
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart"></i>
                        <h3>Giỏ hàng của bạn đang trống</h3>
                        <p>Hãy thêm một số sản phẩm vào giỏ hàng để tiếp tục mua sắm.</p>
                        <a href="index.php" class="btn-primary">
                            <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
                        </a>
                        <br><br>
                        <small style="color: #666;">
                            <?php if ($cart_count > 0): ?>
                                Lưu ý: Có <?php echo $cart_count; ?> sản phẩm trong session nhưng không tìm thấy trong database.
                                <a href="cart.php?debug=1">Xem debug info</a>
                            <?php endif; ?>
                        </small>
                    </div>
                </div>
            <?php else: ?>
                <div class="cart-container">
                    <form method="POST" action="cart.php">
                        <div class="cart-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart_products as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="product-info">
                                                    <div class="product-image">
                                                        <?php if (!empty($item['product']['hinh_anh']) && file_exists('uploads/' . $item['product']['hinh_anh'])): ?>
                                                            <img src="uploads/<?php echo htmlspecialchars($item['product']['hinh_anh']); ?>" 
                                                                 alt="<?php echo htmlspecialchars($item['product']['ten_sp']); ?>">
                                                        <?php else: ?>
                                                            <i class="fas fa-mobile-alt"></i>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="product-details">
                                                        <h4><?php echo htmlspecialchars($item['product']['ten_sp']); ?></h4>
                                                        <div class="product-category"><?php echo htmlspecialchars($item['product']['danh_muc']); ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><div class="product-price"><?php echo format_currency($item['product']['gia']); ?></div></td>
                                            <td>
                                                <input type="number" 
                                                       name="quantities[<?php echo $item['product']['id']; ?>]" 
                                                       value="<?php echo $item['quantity']; ?>" 
                                                       min="1" 
                                                       max="<?php echo $item['product']['so_luong']; ?>"
                                                       class="quantity-input">
                                            </td>
                                            <td><div class="subtotal"><?php echo format_currency($item['subtotal']); ?></div></td>
                                            <td>
                                                <a href="cart.php?remove=<?php echo $item['product']['id']; ?>" 
                                                   class="btn-danger"
                                                   onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="cart-actions">
                            <button type="submit" name="update_cart" class="btn-warning">
                                <i class="fas fa-sync"></i> Cập nhật giỏ hàng
                            </button>
                            <button type="submit" name="clear_cart" class="btn-danger"
                                    onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')">
                                <i class="fas fa-trash-alt"></i> Xóa toàn bộ
                            </button>
                        </div>
                    </form>

                    <div class="cart-summary">
                        <div class="summary-header">
                            <h3 class="summary-title">Tóm tắt đơn hàng</h3>
                            <div class="summary-details">
                                <div class="total-items">Tổng sản phẩm: <strong><?php echo $cart_count; ?></strong></div>
                                <div class="total-price"><?php echo format_currency($total_amount); ?></div>
                            </div>
                        </div>
                        
                        <div class="summary-actions">
                            <a href="index.php" class="btn-secondary">
                                <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
                            </a>
                            <a href="checkout.php" class="btn-success">
                                <i class="fas fa-credit-card"></i> Thanh toán
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4><?php echo SITE_NAME; ?></h4>
                    <p>Hệ thống bán lẻ điện thoại, laptop, tablet, phụ kiện chính hãng mới nhất, giá tốt, dịch vụ bảo hành uy tín tại Việt Nam.</p>
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
                    <p><i class="fas fa-envelope"></i>support@example.com</p>
                    <p><i class="fas fa-clock"></i>08:00 - 22:00 (T2-CN)</p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2024 <?php echo SITE_NAME; ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Tự động ẩn thông báo sau 3 giây
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 3000);

        // Auto-submit form khi thay đổi quantity
        document.querySelectorAll('.quantity-input').forEach(input => {
            let timeoutId;
            input.addEventListener('change', function() {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(() => {
                    this.form.submit();
                }, 500);
            });
        });
    </script>
</body>
</html>
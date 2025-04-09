<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Báo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --success-color: #2ecc71;
            --background-color: #f8f9fa;
            --text-color: #333;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notification-container {
            max-width: 600px;
            width: 100%;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin: 20px;
        }

        .notification-header {
            background: linear-gradient(135deg, var(--primary-color), #2980b9);
            color: white;
            padding: 20px;
        }

        .notification-header h2 {
            margin: 0;
            font-weight: 600;
        }

        .notification-body {
            padding: 40px 30px;
        }

        .notification-icon {
            font-size: 80px;
            color: var(--success-color);
            margin-bottom: 20px;
        }

        .notification-message {
            font-size: 24px;
            font-weight: 300;
            margin-bottom: 30px;
            color: #555;
        }

        .btn-action {
            display: inline-block;
            background: var(--primary-color);
            color: white;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            margin: 0 10px 10px 10px;
        }

        .btn-action:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
            color: white;
        }

        .btn-back {
            background: #7f8c8d;
        }

        .btn-back:hover {
            background: #6c7a7d;
            box-shadow: 0 5px 15px rgba(127, 140, 141, 0.3);
        }

        /* Responsive styles */
        @media (max-width: 576px) {
            .notification-message {
                font-size: 20px;
            }

            .notification-actions {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .btn-action {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="notification-container">
        <div class="notification-header">
            <h2><i class="fas fa-bell me-2"></i>THÔNG BÁO</h2>
        </div>

        <div class="notification-body">
            <div class="notification-icon">
                <i class="fas fa-check-circle"></i>
            </div>

            <div class="notification-message">
                {{$thongbao}}
            </div>

            <div class="notification-actions">
                <a href="/" class="btn-action">
                    <i class="fas fa-home me-2"></i>Trang chủ
                </a>
                <a href="/lienhe" class="btn-action btn-back">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
            </div>
        </div>
    </div>
</body>
</html>

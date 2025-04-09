<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Báo Liên Hệ Mới</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background-color: #3498db;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        .email-body {
            padding: 30px;
        }

        .customer-info {
            background-color: #f1f8fe;
            border-left: 4px solid #3498db;
            padding: 15px;
            margin-bottom: 20px;
        }

        .info-item {
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: 600;
            color: #555;
        }

        .message-content {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .email-footer {
            background-color: #f1f1f1;
            padding: 15px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }

        .divider {
            height: 1px;
            background-color: #e0e0e0;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Thông Báo Liên Hệ Mới</h1>
        </div>

        <div class="email-body">
            <p>Chào Admin!</p>
            <p>Bạn vừa nhận được một yêu cầu liên hệ mới từ website. Dưới đây là thông tin chi tiết:</p>

            <div class="customer-info">
                <div class="info-item">
                    <span class="info-label">Họ tên khách hàng:</span>
                    <span>{{$hoten}}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Email khách hàng:</span>
                    <span>{{$email}}</span>
                </div>
            </div>

            <div class="divider"></div>

            <p class="info-label">Nội dung liên hệ:</p>
            <div class="message-content">
                {!! nl2br($noidung) !!}
            </div>
        </div>

        <div class="email-footer">
            <p>Email này được gửi tự động từ hệ thống website. Vui lòng không trả lời email này.</p>
            <p>&copy; 2025 Website của bạn. Tất cả quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html>

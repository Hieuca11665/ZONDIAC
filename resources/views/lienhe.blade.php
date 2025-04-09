<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --accent-color: #f39c12;
            --background-color: #f8f9fa;
            --text-color: #333;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .contact-container {
            max-width: 800px;
            margin: 40px auto;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .contact-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 30px;
            text-align: center;
            font-weight: 300;
        }

        .contact-header h2 {
            margin: 0;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .contact-form {
            background: white;
            padding: 40px;
        }

        .form-label {
            font-weight: 500;
            color: #555;
        }

        .form-control {
            border-radius: 5px;
            padding: 12px 15px;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }

        .btn-submit {
            background: var(--accent-color);
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            background: #e67e22;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(243, 156, 18, 0.3);
        }

        .contact-info {
            margin-top: 20px;
            padding: 20px;
            background-color: #f1f8fe;
            border-radius: 5px;
            border-left: 4px solid var(--primary-color);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            top: 14px;
            left: 15px;
            color: #aaa;
        }

        .input-icon input,
        .input-icon textarea {
            padding-left: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="contact-container">
            <div class="contact-header">
                <h2><i class="fas fa-paper-plane me-2"></i>LIÊN HỆ VỚI CHÚNG TÔI</h2>
                <p class="mb-0">Hãy để lại thông tin, chúng tôi sẽ liên hệ với bạn sớm nhất!</p>
            </div>

            <div class="contact-form">
                <form method="post" action="/guilienhe">
                    @csrf
                    <div class="form-group">
                        <label for="hoten" class="form-label">Họ tên</label>
                        <div class="input-icon">
                            <i class="fas fa-user"></i>
                            <input id="hoten" class="form-control" name="ht" required placeholder="Nhập họ tên của bạn">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-icon">
                            <i class="fas fa-envelope"></i>
                            <input id="email" class="form-control" name="em" type="email" required placeholder="example@domain.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="noidung" class="form-label">Nội dung</label>
                        <div class="input-icon">
                            <i class="fas fa-comment-alt"></i>
                            <textarea id="noidung" class="form-control" name="nd" rows="5" placeholder="Nhập nội dung liên hệ..."></textarea>
                        </div>
                    </div>

                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-paper-plane me-2"></i>Gửi liên hệ
                        </button>
                    </div>
                </form>

                <div class="contact-info mt-4">
                    <h5><i class="fas fa-info-circle me-2"></i>Thông tin liên hệ khác</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i>Địa chỉ: 123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh</p>
                    <p><i class="fas fa-phone me-2"></i>Điện thoại: (028) 1234 5678</p>
                    <p><i class="fas fa-envelope me-2"></i>Email: info@website.com</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

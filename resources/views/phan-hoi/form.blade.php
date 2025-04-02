@extends('layouts.app')

@section('title', 'Gửi phản hồi')

@section('styles')
<style>
    /* Thiết kế Star Rating nâng cấp */
    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        margin-bottom: 10px;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        cursor: pointer;
        font-size: 2.5rem;
        color: #e0e0e0;
        transition: all 0.3s ease;
        margin-right: 8px;
        filter: drop-shadow(0 0 1px rgba(0, 0, 0, 0.1));
    }

    .star-rating label:before {
        content: '\f005';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
    }

    .star-rating input:checked ~ label {
        color: #FFD700;
        transform: scale(1.1);
        filter: drop-shadow(0 0 3px rgba(255, 215, 0, 0.5));
    }

    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #FFD700;
        transform: scale(1.1);
        filter: drop-shadow(0 0 5px rgba(255, 215, 0, 0.7));
    }

    /* Animation cho các phần tử */
    .animated-card {
        transition: all 0.3s ease;
    }

    .animated-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    /* Custom styling cho form */
    .feedback-form {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: none;
        overflow: hidden;
    }

    .feedback-form .card-header {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        border-bottom: none;
        padding: 20px 25px;
    }

    .feedback-form .card-body {
        padding: 30px;
    }

    .feedback-form textarea {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: 15px;
        transition: all 0.3s ease;
        resize: none;
    }

    .feedback-form textarea:focus {
        border-color: #6a11cb;
        box-shadow: 0 0 0 0.2rem rgba(106, 17, 203, 0.2);
    }

    .btn-submit {
        padding: 12px 25px;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        border: none;
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(106, 17, 203, 0.3);
    }

    .rating-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        display: block;
    }

    /* Custom alert */
    .custom-alert {
        background: rgba(37, 117, 252, 0.1);
        border-left: 4px solid #2575fc;
        border-radius: 6px;
        padding: 15px 20px;
    }

    .custom-alert i {
        color: #2575fc;
    }

    /* FAQ section styling */
    .faq-card {
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: none;
        overflow: hidden;
    }

    .faq-card .card-header {
        background: linear-gradient(135deg, #2575fc 0%, #6a11cb 100%);
        color: white;
        border-bottom: none;
        padding: 18px 25px;
    }

    .accordion-item {
        border: none;
        border-bottom: 1px solid #f0f0f0;
    }

    .accordion-item:last-child {
        border-bottom: none;
    }

    .accordion-button {
        padding: 18px 25px;
        font-weight: 600;
        color: #444;
    }

    .accordion-button:not(.collapsed) {
        background-color: rgba(106, 17, 203, 0.05);
        color: #6a11cb;
    }

    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(106, 17, 203, 0.1);
    }

    .accordion-button::after {
        background-size: 1.2rem;
        transition: all 0.3s ease;
    }

    .accordion-body {
        padding: 20px 25px;
        color: #666;
        background-color: #f9f9ff;
    }

    /* Rating visualization */
    .star-value {
        display: none;
        font-size: 3rem;
        font-weight: bold;
        text-align: center;
        margin-top: 10px;
        color: #6a11cb;
        text-shadow: 0 0 10px rgba(106, 17, 203, 0.2);
    }

    /* Feedback bubble styling */
    .feedback-bubble {
        position: relative;
        background: #f9f9ff;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .feedback-bubble:hover {
        background: #f5f5ff;
        transform: scale(1.01);
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Form phản hồi -->
            <div class="card feedback-form animated-card mb-5">
                <div class="card-header">
                    <h4 class="mb-0 d-flex align-items-center">
                        <i class="fas fa-comment-dots me-3"></i>
                        <span>Đánh giá & Phản hồi</span>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="custom-alert mb-4">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-lightbulb fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Ý kiến của bạn rất quan trọng!</h5>
                                <p class="mb-0">Phản hồi của bạn sẽ giúp chúng tôi không ngừng cải thiện và nâng cao chất lượng dịch vụ.</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('phan-hoi') }}" id="feedbackForm">
                        @csrf

                        <div class="feedback-bubble">
                            <h5 class="rating-label text-center mb-3">Bạn đánh giá trải nghiệm của mình như thế nào?</h5>
                            <div class="star-rating mb-2 justify-content-center">
                                <input type="radio" id="star5" name="vote_star" value="5" {{ old('vote_star') == 5 ? 'checked' : '' }}/>
                                <label for="star5" title="5 sao"></label>

                                <input type="radio" id="star4" name="vote_star" value="4" {{ old('vote_star') == 4 ? 'checked' : '' }}/>
                                <label for="star4" title="4 sao"></label>

                                <input type="radio" id="star3" name="vote_star" value="3" {{ old('vote_star') == 3 ? 'checked' : '' }}/>
                                <label for="star3" title="3 sao"></label>

                                <input type="radio" id="star2" name="vote_star" value="2" {{ old('vote_star') == 2 ? 'checked' : '' }}/>
                                <label for="star2" title="2 sao"></label>

                                <input type="radio" id="star1" name="vote_star" value="1" {{ old('vote_star') == 1 ? 'checked' : '' }}/>
                                <label for="star1" title="1 sao"></label>
                            </div>

                            <!-- Visual feedback of star rating -->
                            <div class="star-value" id="ratingValue"></div>

                            @error('vote_star')
                                <div class="text-danger text-center">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="feedback" class="form-label fw-bold">Nội dung phản hồi</label>
                            <textarea id="feedback" class="form-control @error('feedback') is-invalid @enderror" name="feedback" rows="5" placeholder="Chia sẻ trải nghiệm hoặc góp ý của bạn...">{{ old('feedback') }}</textarea>
                            @error('feedback')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-submit">
                                <i class="fas fa-paper-plane me-2"></i>Gửi phản hồi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- FAQ section -->
            <div class="card faq-card animated-card">
                <div class="card-header">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="fas fa-question-circle me-3"></i>
                        <span>Câu hỏi thường gặp</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeading1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="false" aria-controls="faqCollapse1">
                                    <i class="fas fa-graduation-cap me-2"></i>Làm thế nào để đăng ký khóa học?
                                </button>
                            </h2>
                            <div id="faqCollapse1" class="accordion-collapse collapse" aria-labelledby="faqHeading1" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Để đăng ký khóa học, bạn cần đăng nhập vào hệ thống và truy cập trang "Đăng ký khóa học". Điền đầy đủ thông tin yêu cầu và hoàn tất quá trình đăng ký. Nếu bạn gặp khó khăn, vui lòng liên hệ với đội ngũ hỗ trợ của chúng tôi.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeading2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                                    <i class="fas fa-user-edit me-2"></i>Làm sao để thay đổi thông tin cá nhân?
                                </button>
                            </h2>
                            <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Bạn có thể thay đổi thông tin cá nhân bằng cách truy cập vào mục "Cập nhật hồ sơ" hoặc "Thay đổi thông tin" từ menu người dùng trên thanh điều hướng. Tại đây, bạn có thể cập nhật các thông tin như số điện thoại, địa chỉ, và thay đổi ảnh đại diện.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeading3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                                    <i class="fas fa-headset me-2"></i>Làm thế nào để liên hệ với đội ngũ hỗ trợ?
                                </button>
                            </h2>
                            <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Bạn có thể liên hệ với đội ngũ hỗ trợ qua email <strong>hotro@example.com</strong> hoặc gửi phản hồi trực tiếp qua trang này. Chúng tôi cũng có hỗ trợ trực tuyến từ 8:00 - 22:00 hàng ngày và sẽ phản hồi trong vòng 24 giờ làm việc.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hiệu ứng hiển thị số sao đánh giá
        const starInputs = document.querySelectorAll('input[name="vote_star"]');
        const ratingValue = document.getElementById('ratingValue');

        starInputs.forEach(input => {
            input.addEventListener('change', function() {
                ratingValue.style.display = 'block';
                ratingValue.textContent = this.value + ' ★';

                // Hiệu ứng animation
                ratingValue.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    ratingValue.style.transform = 'scale(1)';
                }, 200);
            });
        });

        // Kiểm tra nếu có sao đã được chọn trước đó
        const checkedStar = document.querySelector('input[name="vote_star"]:checked');
        if (checkedStar) {
            ratingValue.style.display = 'block';
            ratingValue.textContent = checkedStar.value + ' ★';
        }

        // Hiệu ứng khi focus vào textarea
        const feedbackTextarea = document.getElementById('feedback');
        feedbackTextarea.addEventListener('focus', function() {
            this.style.boxShadow = '0 0 0 0.25rem rgba(106, 17, 203, 0.25)';
        });

        feedbackTextarea.addEventListener('blur', function() {
            this.style.boxShadow = '';
        });
    });
</script>
@endsection

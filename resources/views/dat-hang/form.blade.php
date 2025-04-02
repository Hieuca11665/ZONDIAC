@extends('layouts.app')

@section('title', 'Đặt hàng')

@section('styles')
<style>
    .order-form {
        background-color: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 30px rgba(0, 0, 0, 0.08);
    }

    .order-form-header {
        padding: 25px;
        background: linear-gradient(135deg, #3490dc, #38c172);
        color: white;
        position: relative;
    }

    .order-form-header::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 0;
        right: 0;
        height: 30px;
        background-color: white;
        border-radius: 50% 50% 0 0;
    }

    .order-form-body {
        padding: 40px 30px 30px;
    }

    .form-floating {
        margin-bottom: 20px;
    }

    .form-floating label {
        color: #6c757d;
    }

    .form-control:focus + label {
        color: #3490dc;
    }

    .shipping-option {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        transition: all 0.3s;
        cursor: pointer;
        position: relative;
    }

    .shipping-option:hover {
        border-color: #baddff;
    }

    .shipping-option.selected {
        border-color: #3490dc;
        background-color: rgba(52, 144, 220, 0.05);
    }

    .shipping-option .form-check-input {
        position: absolute;
        top: 20px;
        right: 20px;
    }

    .shipping-price {
        font-weight: 600;
        color: #3490dc;
    }

    .payment-method {
        display: flex;
        align-items: center;
        gap: 15px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        transition: all 0.3s;
        cursor: pointer;
    }

    .payment-method:hover {
        border-color: #baddff;
    }

    .payment-method.selected {
        border-color: #3490dc;
        background-color: rgba(52, 144, 220, 0.05);
    }

    .payment-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #3490dc;
        background-color: rgba(52, 144, 220, 0.1);
        border-radius: 8px;
    }

    .submit-btn {
        padding: 12px 25px;
        font-weight: 600;
        border-radius: 50px;
        box-shadow: 0 5px 15px rgba(52, 144, 220, 0.3);
        transition: all 0.3s;
    }

    .submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(52, 144, 220, 0.4);
    }

    .order-summary {
        background-color: #f8f9fa;
        border-radius: 15px;
        padding: 25px;
        height: 100%;
    }

    .order-summary-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 20px;
        color: #343a40;
        padding-bottom: 15px;
        border-bottom: 1px solid #dee2e6;
    }

    .product-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px dashed #dee2e6;
    }

    .product-image {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        overflow: hidden;
        background-color: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .product-details {
        flex-grow: 1;
        padding: 0 15px;
    }

    .product-title {
        font-weight: 600;
        margin-bottom: 5px;
        color: #343a40;
    }

    .product-variant {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .product-price {
        font-weight: 600;
        color: #3490dc;
    }

    .summary-total {
        margin-top: 20px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .summary-label {
        color: #6c757d;
    }

    .summary-value {
        font-weight: 600;
    }

    .total-row {
        font-size: 1.2rem;
        font-weight: 700;
        color: #343a40;
        padding-top: 15px;
        margin-top: 15px;
        border-top: 2px solid #dee2e6;
    }

    .step-indicator {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
    }

    .step {
        flex: 1;
        text-align: center;
        position: relative;
    }

    .step:not(:last-child):after {
        content: '';
        position: absolute;
        top: 15px;
        left: 60%;
        right: 0;
        height: 2px;
        background-color: #e9ecef;
        z-index: 0;
    }

    .step.active:not(:last-child):after {
        background-color: #3490dc;
    }

    .step-icon {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background-color: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        position: relative;
        z-index: 1;
        transition: all 0.3s;
    }

    .step.active .step-icon {
        background: linear-gradient(135deg, #3490dc, #38c172);
        color: white;
        box-shadow: 0 5px 10px rgba(52, 144, 220, 0.3);
    }

    .step-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: #6c757d;
    }

    .step.active .step-title {
        color: #3490dc;
    }

    @media (max-width: 768px) {
        .order-summary {
            margin-top: 30px;
        }
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="order-form">
                <div class="order-form-header">
                    <h2 class="m-0"><i class="fas fa-shopping-cart me-2"></i>Đặt hàng</h2>
                    <p class="mb-0 mt-2">Vui lòng điền đầy đủ thông tin để hoàn tất đơn hàng</p>
                </div>

                <div class="order-form-body">
                    <div class="step-indicator mb-5">
                        <div class="step active">
                            <div class="step-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="step-title">Giỏ hàng</div>
                        </div>
                        <div class="step active">
                            <div class="step-icon">
                                <i class="fas fa-address-card"></i>
                            </div>
                            <div class="step-title">Thông tin</div>
                        </div>
                        <div class="step">
                            <div class="step-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="step-title">Vận chuyển</div>
                        </div>
                        <div class="step">
                            <div class="step-icon">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div class="step-title">Thanh toán</div>
                        </div>
                    </div>

                    <form action="{{ route('dat-hang.process') }}" method="POST">
                        @csrf

                        <h4 class="mb-4">Thông tin cá nhân</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('ho_ten') is-invalid @enderror" id="ho_ten" name="ho_ten" placeholder="Họ và tên" value="{{ old('ho_ten', Auth::user()->name) }}">
                                    <label for="ho_ten">Họ và tên</label>
                                    @error('ho_ten')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ old('email', Auth::user()->email) }}">
                                    <label for="email">Email</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="tel" class="form-control @error('so_dien_thoai') is-invalid @enderror" id="so_dien_thoai" name="so_dien_thoai" placeholder="Số điện thoại" value="{{ old('so_dien_thoai') }}">
                                    <label for="so_dien_thoai">Số điện thoại</label>
                                    @error('so_dien_thoai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <h4 class="mb-4 mt-4">Địa chỉ giao hàng</h4>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('dia_chi') is-invalid @enderror" id="dia_chi" name="dia_chi" placeholder="Địa chỉ" value="{{ old('dia_chi') }}">
                            <label for="dia_chi">Địa chỉ</label>
                            @error('dia_chi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('tinh_thanh') is-invalid @enderror" id="tinh_thanh" name="tinh_thanh" placeholder="Tỉnh/Thành phố" value="{{ old('tinh_thanh') }}">
                                    <label for="tinh_thanh">Tỉnh/Thành phố</label>
                                    @error('tinh_thanh')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('quan_huyen') is-invalid @enderror" id="quan_huyen" name="quan_huyen" placeholder="Quận/Huyện" value="{{ old('quan_huyen') }}">
                                    <label for="quan_huyen">Quận/Huyện</label>
                                    @error('quan_huyen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('phuong_xa') is-invalid @enderror" id="phuong_xa" name="phuong_xa" placeholder="Phường/Xã" value="{{ old('phuong_xa') }}">
                                    <label for="phuong_xa">Phường/Xã</label>
                                    @error('phuong_xa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <h4 class="mb-4 mt-4">Phương thức vận chuyển</h4>
                        <div class="shipping-options mb-4">
                            <div class="shipping-option selected" onclick="selectShipping(this, 'standard')">
                                <input type="radio" class="form-check-input" name="phuong_thuc_van_chuyen" id="shipping_standard" value="standard" checked>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Giao hàng tiêu chuẩn</h6>
                                    <span class="shipping-price">30.000₫</span>
                                </div>
                                <p class="text-muted mb-0 small">Thời gian giao hàng: 3-5 ngày làm việc</p>
                            </div>

                            <div class="shipping-option" onclick="selectShipping(this, 'express')">
                                <input type="radio" class="form-check-input" name="phuong_thuc_van_chuyen" id="shipping_express" value="express">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Giao hàng nhanh</h6>
                                    <span class="shipping-price">60.000₫</span>
                                </div>
                                <p class="text-muted mb-0 small">Thời gian giao hàng: 1-2 ngày làm việc</p>
                            </div>
                        </div>

                        <h4 class="mb-4 mt-4">Phương thức thanh toán</h4>
                        <div class="payment-methods mb-4">
                            <div class="payment-method selected" onclick="selectPayment(this, 'cod')">
                                <input type="radio" class="form-check-input" name="phuong_thuc_thanh_toan" id="payment_cod" value="cod" checked>
                                <div class="payment-icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Thanh toán khi nhận hàng (COD)</h6>
                                    <p class="text-muted mb-0 small">Thanh toán bằng tiền mặt khi nhận hàng</p>
                                </div>
                            </div>

                            <div class="payment-method" onclick="selectPayment(this, 'bank')">
                                <input type="radio" class="form-check-input" name="phuong_thuc_thanh_toan" id="payment_bank" value="bank">
                                <div class="payment-icon">
                                    <i class="fas fa-university"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Chuyển khoản ngân hàng</h6>
                                    <p class="text-muted mb-0 small">Chuyển khoản qua ngân hàng</p>
                                </div>
                            </div>

                            <div class="payment-method" onclick="selectPayment(this, 'momo')">
                                <input type="radio" class="form-check-input" name="phuong_thuc_thanh_toan" id="payment_momo" value="momo">
                                <div class="payment-icon">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Ví MoMo</h6>
                                    <p class="text-muted mb-0 small">Thanh toán qua ví điện tử MoMo</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-4">
                            <textarea class="form-control" id="ghi_chu" name="ghi_chu" placeholder="Ghi chú" style="height: 100px">{{ old('ghi_chu') }}</textarea>
                            <label for="ghi_chu">Ghi chú đơn hàng (tùy chọn)</label>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary submit-btn">
                                <i class="fas fa-check-circle me-2"></i>Xác nhận đặt hàng
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="order-summary">
                <h4 class="order-summary-title">Thông tin đơn hàng</h4>

                <div class="product-list">
                    <div class="product-item">
                        <div class="product-image">
                            <img src="/api/placeholder/60/60" alt="Sách Python" class="img-fluid">
                        </div>
                        <div class="product-details">
                            <div class="product-title">Python cơ bản đến nâng cao</div>
                            <div class="product-variant">Bìa cứng / Phiên bản 2025</div>
                        </div>
                        <div class="product-price">350.000₫</div>
                    </div>

                    <div class="product-item">
                        <div class="product-image">
                            <img src="/api/placeholder/60/60" alt="Sách Web Development" class="img-fluid">
                        </div>
                        <div class="product-details">
                            <div class="product-title">Lập trình Web hiện đại</div>
                            <div class="product-variant">Bìa mềm / Có kèm CD bài tập</div>
                        </div>
                        <div class="product-price">550.000₫</div>
                    </div>
                </div>

                <div class="summary-total">
                    <div class="summary-item">
                        <div class="summary-label">Tạm tính</div>
                        <div class="summary-value">900.000₫</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Phí vận chuyển</div>
                        <div class="summary-value">30.000₫</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Giảm giá</div>
                        <div class="summary-value">0₫</div>
                    </div>
                    <div class="summary-item total-row">
                        <div class="summary-label">Tổng cộng</div>
                        <div class="summary-value">930.000₫</div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <div>
                            Vui lòng kiểm tra lại thông tin đơn hàng trước khi xác nhận.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function selectShipping(element, type) {
        // Xóa class selected khỏi tất cả các phương thức vận chuyển
        document.querySelectorAll('.shipping-option').forEach(option => {
            option.classList.remove('selected');
        });

        // Thêm class selected cho phương thức được chọn
        element.classList.add('selected');

        // Chọn radio button tương ứng
        document.getElementById('shipping_' + type).checked = true;

        // Cập nhật phí vận chuyển và tổng tiền
        updateTotals();
    }

    function selectPayment(element, type) {
        // Xóa class selected khỏi tất cả các phương thức thanh toán
        document.querySelectorAll('.payment-method').forEach(method => {
            method.classList.remove('selected');
        });

        // Thêm class selected cho phương thức được chọn
        element.classList.add('selected');

        // Chọn radio button tương ứng
        document.getElementById('payment_' + type).checked = true;
    }

    function updateTotals() {
        const shippingStandard = document.getElementById('shipping_standard').checked;
        const shippingCost = shippingStandard ? 30000 : 60000;
        const subtotal = 900000;
        const discount = 0;
        const total = subtotal + shippingCost - discount;

        // Cập nhật hiển thị
        document.querySelector('.summary-item:nth-child(2) .summary-value').textContent =
            shippingCost.toLocaleString('vi-VN') + '₫';
        document.querySelector('.total-row .summary-value').textContent =
            total.toLocaleString('vi-VN') + '₫';
    }
</script>
@endsection

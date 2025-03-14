@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <main style="padding-top: 90px;">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h2 class="page-title">GIAO HÀNG VÀ THANH TOÁN</h2>
            <div class="checkout-steps">
                <a href="shop_cart.html" class="checkout-steps__item active d-flex align-items-center py-3">
                    <h2 style="background: #b42020; color:#fff" class="me-1 mb-0 p-2">01</h2>
                    <span class="checkout-steps__item-title d-flex flex-column justify-content-center text-start">
                        <span class="step-title fw-bold">Giỏ hàng</span>
                        <em class="step-description text-muted">Quản lý danh sách sản phẩm của bạn</em>
                    </span>
                </a>

                <a href="shop_checkout.html" class="checkout-steps__item active d-flex align-items-center py-3">
                    <h2 style="background: #b42020; color:#fff" class="me-1 mb-0 p-2">02</h2>
                    <span class="checkout-steps__item-title d-flex flex-column justify-content-center text-start">
                        <span class="step-title fw-bold">Giao hàng và thanh toán</span>
                        <em class="step-description text-muted">Tiến hành thanh toán</em>
                    </span>
                </a>

                <a href="shop_order_complete.html" class="checkout-steps__item d-flex align-items-center py-3">
                    <h2 style="background: #b42020; color:#fff" class="me-1 mb-0 p-2">03</h2>
                    <span class="checkout-steps__item-title d-flex flex-column justify-content-center text-start">
                        <span class="step-title fw-bold">Xác nhận</span>
                        <em class="step-description text-muted">Kiểm tra và gửi đơn hàng</em>
                    </span>
                </a>
            </div>
            <form action="{{ route('payment.checkout') }}" method="POST">
                @csrf
                <div class="checkout-form">
                    <div class="billing-info__wrapper col-xl-6">
                        <h4>THÔNG TIN KHÁCH HÀNG</h4>
                        <div class="row">
                            <!-- Họ tên -->
                            <div class="col-md-12">
                                <div class="form-floating my-3">
                                    <input name="name" type="text" class="form-control" id="checkout_first_name"
                                        value="{{ $data['full_name'] ?? '' }}">
                                    <label for="checkout_first_name">Họ tên</label>
                                </div>
                            </div>

                            <!-- Số điện thoại -->
                            <div class="col-md-12">
                                <div class="form-floating my-3">
                                    <input name="phone_number" type="text" class="form-control" id="checkout_phone"
                                        value="{{ $data['phone_number'] ?? '' }}">
                                    <label for="checkout_phone">Số điện thoại *</label>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-12">
                                <div class="form-floating my-3">
                                    <input name="email" type="email" class="form-control" id="checkout_email"
                                        value="{{ $data['email'] ?? '' }}">
                                    <label for="checkout_email">Email *</label>
                                </div>
                            </div>

                            <!-- Địa chỉ (Gộp các phần: street, ward, district, city, country) -->
                            <div class="col-md-12">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" id="checkout_address"
                                        value="{{ $data['street_address'] ?? '' }}, {{ $data['ward'] ?? '' }}, {{ $data['district'] ?? '' }}, {{ $data['city'] ?? '' }}, {{ $data['country'] ?? '' }}">
                                    <label for="checkout_address">Địa chỉ</label>
                                </div>
                            </div>
                            <input type="hidden" name="street_address" value="{{ $data['street_address'] }}">
                            <input type="hidden" name="ward" value="{{ $data['ward'] }}">
                            <input type="hidden" name="district" value="{{ $data['district'] }}">
                            <input type="hidden" name="city" value="{{ $data['city'] }}">
                            <input type="hidden" name="country" value="{{ $data['country'] }}">
                            <input type="hidden" name="total_amount" value="{{ $data['total_amount'] }}">
                            <input type="hidden" name="voucher_id" value="{{ $data['voucher_id'] }}">
                            <!-- Ghi chú -->
                            <div class="col-md-12">
                                <div class="mt-3">
                                    <textarea name="note" class="form-control form-control_gray" placeholder="Ghi chú" cols="30" rows="8">{{ $data['note'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="checkout__totals-wrapper">
                        <div class="sticky-content">
                            <div style="width:100%" class="checkout__totals">
                                @php
                                    $total = 0;
                                    $shipping = isset($data['shipping']) ? $data['shipping'] : 0;

                                    // Tính tổng tạm tính
                                    foreach ($cartItems as $item) {
                                        $total += $item['price'] * $item['quantity'];
                                    }

                                    // Tính tổng tiền phải thanh toán

                                @endphp
                                <h3>Đơn hàng của bạn</h3>
                                <table class="checkout-cart-items">
                                    <thead>
                                        <tr>
                                            <th>SẢN PHẨM</th>
                                            <th>THÀNH TIỀN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (Auth::check())
                                            @foreach ($cartItems as $index => $item)
                                                <input type="hidden" name="cart_items[{{ $index }}][variant_id]"
                                                    value="{{ $item['variant_id'] }}">
                                                <input type="hidden" name="cart_items[{{ $index }}][quantity]"
                                                    value="{{ $item['quantity'] }}">
                                                <input type="hidden" name="cart_items[{{ $index }}][price]"
                                                    value="{{ $item['price'] }}">
                                                <tr>
                                                    <td style="width: 80%">
                                                        {{ $item->productVariant->product->name }} x
                                                        {{ $item['quantity'] }}
                                                    </td>
                                                    <td>
                                                        {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @php
                                                $cartItems = session()->get('cart', []);
                                            @endphp
                                            @foreach ($cartItems as $index => $item)
                                                <input type="hidden" name="cart_items[{{ $index }}][variant_id]"
                                                    value="{{ $item['variant_id'] }}">
                                                <input type="hidden" name="cart_items[{{ $index }}][quantity]"
                                                    value="{{ $item['quantity'] }}">
                                                <input type="hidden" name="cart_items[{{ $index }}][price]"
                                                    value="{{ $item['price'] }}">
                                                <tr>
                                                    <td style="width: 80%">
                                                        {{ $item['name'] }} x {{ $item['quantity'] }}
                                                    </td>
                                                    <td>
                                                        {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif

                                    </tbody>
                                </table>
                                <table class="checkout-totals">
                                    <tbody>
                                        <tr class="justify-content-between">
                                            <th style="width: 80%">Tạm tính</th>
                                            <td>{{ number_format($total, 0, ',', '.') }}đ</td>
                                        </tr>
                                        <tr>
                                            <th style="width: 80%">Giảm giá</th>
                                            <td>
                                                {{ number_format($data['discount_price'], 0, ',', '.') }}đ
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 80%">Phí vận chuyển</th>
                                            <td>
                                                @if ($data['shipping'] == 0)
                                                    Miễn phí
                                                @else
                                                    {{ number_format($shipping, 0, ',', '.') }}đ
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 80%">Tổng cộng</th>
                                            <td><strong>{{ number_format($data['total_amount'], 0, ',', '.') }}đ</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div style="width:100%" class="checkout__payment-methods col-xl-6">
                                <div class="form-check">
                                    <input name="payment_method" value="cash"
                                        class="form-check-input form-check-input_fill" type="radio"
                                        name="checkout_payment_method" id="checkout_payment_method_cod" checked>
                                    <label class="form-check-label" for="checkout_payment_method_cod">
                                        <b> Thanh toán khi nhận hàng (COD)</b>
                                        <span class="option-detail d-block">
                                            Thanh toán trực tiếp bằng tiền mặt khi nhận hàng. Vui lòng chuẩn bị số tiền
                                            chính xác để thuận tiện cho việc giao hàng.
                                        </span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio"
                                        name="payment_method" id="checkout_payment_method_vnpay" value="vnpay">
                                    <label class="form-check-label" for="checkout_payment_method_vnpay">
                                        <b> Thanh toán qua VNPay</b>
                                        <span class="option-detail d-block">
                                            Thanh toán an toàn qua VNPay. Bạn sẽ được chuyển hướng đến cổng thanh toán VNPay
                                            để hoàn tất giao dịch.
                                        </span>
                                    </label>
                                </div>
                                <div class="policy-text">
                                    Dữ liệu cá nhân của bạn sẽ được sử dụng để xử lý đơn hàng, hỗ trợ trải nghiệm của bạn
                                    trên website này,
                                    và cho các mục đích khác được mô tả trong <a href="terms.html" target="_blank">chính
                                        sách bảo mật</a> của chúng tôi.
                                </div>
                            </div>

                            <button style="width:100%" type="submit" class="btn btn-primary">Tiến hành thanh
                                toán</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
@endsection
@section('script')
@endsection
@section('style')
@endsection

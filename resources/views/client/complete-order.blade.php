@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5">
    </div>
    <main style="padding-top: 90px;">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Order Received</h2>
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

                <a href="shop_order_complete.html" class="checkout-steps__item active d-flex align-items-center py-3">
                    <h2 style="background: #b42020; color:#fff" class="me-1 mb-0 p-2">03</h2>
                    <span class="checkout-steps__item-title d-flex flex-column justify-content-center text-start">
                        <span class="step-title fw-bold">Xác nhận</span>
                        <em class="step-description text-muted">Kiểm tra và gửi đơn hàng</em>
                    </span>
                </a>
            </div>
            <div class="order-complete">
                <div class="order-complete__message">
                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <circle cx="40" cy="40" r="40" fill="#1fc17b"></circle>
                        <path
                            d="M52.9743 35.7612C52.9743 35.3426 52.8069 34.9241 52.5056 34.6228L50.2288 32.346C49.9275 32.0446 49.5089 31.8772 49.0904 31.8772C48.6719 31.8772 48.2533 32.0446 47.952 32.346L36.9699 43.3449L32.048 38.4062C31.7467 38.1049 31.3281 37.9375 30.9096 37.9375C30.4911 37.9375 30.0725 38.1049 29.7712 38.4062L27.4944 40.683C27.1931 40.9844 27.0257 41.4029 27.0257 41.8214C27.0257 42.24 27.1931 42.6585 27.4944 42.9598L33.5547 49.0201L35.8315 51.2969C36.1328 51.5982 36.5513 51.7656 36.9699 51.7656C37.3884 51.7656 37.8069 51.5982 38.1083 51.2969L40.385 49.0201L52.5056 36.8996C52.8069 36.5982 52.9743 36.1797 52.9743 35.7612Z"
                            fill="white"></path>
                    </svg>
                    <h3>Đơn hàng của bạn đã hoàn tất!</h3>
                    <p>Cảm ơn bạn. Chúng tôi đã nhận được đơn hàng của bạn.</p>

                </div>
                <div class="order-info">
                    <div class="order-info__item">
                        <label>Mã đơn hàng</label>
                        <span>{{ $order->order_code }}</span>
                    </div>
                    <div class="order-info__item">
                        <label>Ngày đặt</label>
                        <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="order-info__item">
                        <label>Giá trị đơn hàng</label>
                        <span>{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
                    </div>
                    <div class="order-info__item">
                        <label>Phương thức thanh toán</label>
                        <span>{{ $order->payment->payment_method }}</span>
                    </div>
                </div>

                <div class="checkout__totals-wrapper">
                    <div class="checkout__totals">
                        <h3>Chi tiết đơn hàng</h3>
                        <table class="checkout-cart-items">
                            <thead>
                                <tr>
                                    <th class="fw-bold">Sản phẩm</th>
                                    <th></th>
                                    <th class="fw-bold text-center">Giá</th>
                                    <th class="fw-bold text-center">Số lượng</th>
                                    <th class="fw-bold text-end">Tổng cộng</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            <div class="shopping-cart__product-item">
                                                <a
                                                    href="{{ route('client.shop.show', $item->productVariant->product->id) }}">
                                                    <img style="border: 1px solid #c4bebe;width:88px"
                                                        src="{{ Storage::url($item->productVariant->image) }}"
                                                        alt="">
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="shopping-cart__product-item__detail">
                                                <h4><a
                                                        href="{{ route('client.shop.show', $item->productVariant->product->id) }}">
                                                        <strong>{{ $item->productVariant->product->name ?? 'Sản phẩm không tồn tại' }}</strong></a>
                                                </h4>
                                                <ul class="shopping-cart__product-item__options">
                                                    @foreach ($item->productVariant->attributeValues as $value)
                                                        <li>{{ $value->nameValue->attribute->attribute_name ?? 'Thuộc tính' }}:
                                                            {{ $value->nameValue->value_name ?? 'Không xác định' }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="shopping-cart__product-price">{{ number_format($item->unit_price, 0, ',', '.') }}đ</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="shopping-cart__product-price">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="text-end">
                                            <span
                                                class="shopping-cart__product-price">{{ number_format($item->total_price, 0, ',', '.') }}đ</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @php
                            $total = $order->orderItems->sum('total_price');
                        @endphp

                        <table class="checkout-totals">
                            <tbody>
                                <tr>
                                    <th>Tạm tính</th>
                                    <td class="text-end">
                                        <span class="shopping-cart__product-price">
                                            {{ number_format($total, 0, ',', '.') }}đ
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Phí vận chuyển</th>
                                    <td class="text-end">
                                        @if ($order->shipping_method == 'fixed')
                                            <span class="shopping-cart__product-price">
                                                {{ number_format($order->getShippingFee(), 0, ',', '.') }}đ</span>
                                        @else
                                            Miễn phí
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Mã giảm giá
                                        @if ($order->voucher)
                                            | <strong>{{ $order->voucher->code }}</strong>
                                        @endif
                                    </th>
                                    <td class="text-end"> <span class="shopping-cart__product-price">
                                            {{ number_format($order->getDiscountAmount(), 0, ',', '.') }}đ
                                        </span></td>
                                </tr>
                                <tr>
                                    <th>Tổng cộng</th>
                                    <td class="text-end"> <span class="shopping-cart__product-price">
                                            {{ number_format($order->total_amount, 0, ',', '.') }}đ
                                        </span></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </section>
    </main>
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
@endsection
@section('script')
@endsection
@section('style')
@endsection

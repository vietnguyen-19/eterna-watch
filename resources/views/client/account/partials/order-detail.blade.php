@extends('client.account.main')
@section('account_content')
    <div class="checkout__totals-wrapper">
        <div style="width: 100%" class="checkout__totals">
            <div class="d-flex justify-content-between align-items-center mb-3">
                @php
                    if ($order->status == 'pending') {
                        $mauChu = '#856404'; // cam đậm
                        $mauNen = '#fff3cd'; // cam nhạt
                        $tenTrangThai = 'Đang chờ xử lý';
                    } elseif ($order->status == 'confirmed') {
                        $mauChu = '#004085'; // xanh dương đậm
                        $mauNen = '#cce5ff'; // xanh dương nhạt
                        $tenTrangThai = 'Đã xác nhận';
                    } elseif ($order->status == 'processing') {
                        $mauChu = '#0c5460'; // xanh đậm
                        $mauNen = '#d1ecf1'; // xanh nhạt
                        $tenTrangThai = 'Đang xử lý';
                    } elseif ($order->status == 'completed') {
                        $mauChu = '#155724'; // xanh lá đậm
                        $mauNen = '#d4edda'; // xanh lá nhạt
                        $tenTrangThai = 'Hoàn tất';
                    } elseif ($order->status == 'cancelled') {
                        $mauChu = '#721c24'; // đỏ đậm
                        $mauNen = '#f8d7da'; // đỏ nhạt
                        $tenTrangThai = 'Đã hủy';
                    } else {
                        $mauChu = '#383d41'; // xám đậm
                        $mauNen = '#e2e3e5'; // xám nhạt
                        $tenTrangThai = 'Không xác định';
                    }
                @endphp

                <h4 class="mb-0 d-flex align-items-center gap-2">
                    Chi tiết đơn hàng | <strong>{{ $order->order_code }}</strong> | TTĐH:
                    <span class="badge px-3 py-1" style="color: {{ $mauChu }}; background-color: {{ $mauNen }};">
                        {{ $tenTrangThai }}
                    </span>
                </h4>
            </div>


            <div class="card mb-3">
                @php
                    switch ($order->payment->payment_status) {
                        case 'completed':
                            $mauChuTT = '#155724'; // xanh đậm
                            $mauNenTT = '#d4edda'; // xanh nhạt
                            $tenTrangThaiTT = 'Đã thanh toán';
                            break;
                        case 'pending':
                            $mauChuTT = '#856404'; // cam đậm
                            $mauNenTT = '#fff3cd'; // cam nhạt
                            $tenTrangThaiTT = 'Chờ thanh toán';
                            break;
                        case 'failed':
                            $mauChuTT = '#721c24'; // đỏ đậm
                            $mauNenTT = '#f8d7da'; // đỏ nhạt
                            $tenTrangThaiTT = 'Thanh toán thất bại';
                            break;
                        default:
                            $mauChuTT = '#383d41'; // xám đậm
                            $mauNenTT = '#e2e3e5'; // xám nhạt
                            $tenTrangThaiTT = 'Không xác định';
                            break;
                    }
                @endphp

                <div class="card-body">
                    <h5 class="card-title">Thông tin thanh toán</h5>
                    <p class="card-text">
                        <strong>Phương thức thanh toán:</strong>
                        @if ($order->payment->payment_method == 'Cash')
                            Tiền mặt
                        @elseif ($order->payment->payment_method == 'vnpay')
                            VNPay
                        @else
                            {{ $order->payment->payment_method }}
                        @endif
                        <br>
                        <strong>Trạng thái thanh toán:</strong>
                        <span
                            style="color: {{ $mauChuTT }}; background-color: {{ $mauNenTT }}; padding: 0.25em 0.6em; border-radius: 0.25rem;">
                            {{ $tenTrangThaiTT }}
                        </span>
                    </p>
                </div>

            </div>


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
                                    <a href="{{ route('client.shop.show', $item->productVariant->product->id) }}">
                                        <img style="border: 1px solid #c4bebe;width:88px"
                                            src="{{ Storage::url($item->productVariant->image) }}" alt="">
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="shopping-cart__product-item__detail">
                                    <h4><a href="{{ route('client.shop.show', $item->productVariant->product->id) }}">
                                            <strong>{{ $item->productVariant->product->name ?? 'Sản phẩm không tồn tại' }}</strong></a>
                                    </h4>
                                    <ul class="shopping-cart__product-item__options">
                                        @foreach ($item->productVariant->attributeValues as $value)
                                            <li>{{ $value->nameValue->attribute->attribute_name ?? 'Thuộc tính' }}:
                                                {{ $value->nameValue->value_name ?? 'Không xác định' }}
                                            </li>
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
                    @php
                        $discount = $total - $order->total_amount + 30000;
                    @endphp
                    <tr>
                        <th>Mã giảm giá
                            @if ($order->voucher)
                                | <strong><span style="background:#bd2c0b"
                                        class="badge">{{ $order->voucher->code }}</span></strong>
                            @endif
                        </th>
                        <td class="text-end"> <span style="color: #bd2c0b" class="shopping-cart__product-price">
                                -{{ number_format($order->getDiscountAmount(), 0, ',', '.') }}đ
                            </span></td>
                    </tr>
                    <tr>
                        <th><strong>Tổng cộng</strong></th>
                        <td class="text-end"> <span class="shopping-cart__product-price">
                                <strong> {{ number_format($order->total_amount, 0, ',', '.') }}đ</strong>
                            </span></td>
                    </tr>
                </tbody>
            </table>
            <hr>
            <div class="text-end">
                <button class="btn btn-sm btn-cancel-order" style="background: #bd2c0b; color:#fff; border-radius:3px"
                    data-order-id="{{ $order->id }}"
                    data-allow-cancel="{{ !in_array($order->status, ['cancelled', 'completed']) ? '1' : '0' }}">
                    Hủy đơn hàng
                </button>

                <a href="{{ $order->status == 'completed' && !$order->refund ? route('refunds.create', $order->id) : 'javascript:void(0)' }}"
                    class="btn btn-sm btn-refund-order" style="background: #d7b20e; color:#fff; border-radius:3px"
                    data-allow-refund="{{ $order->status == 'completed' && !$order->refund ? '1' : '0' }}">
                    Yêu cầu hoàn tiền
                </a>
            </div>
        </div>
    </div>
@endsection

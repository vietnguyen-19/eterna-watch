@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <main style="padding-top: 90px;">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container py-5">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <nav class="nav flex-column  account-sidebar sticky-sidebar">
                        <a href="{{ route('account.dashboard') }}" class="nav-link text-dark fw-semibold ">Bảng điều
                            khiển</a>
                        <a href="{{ route('account.order') }}" class="nav-link text-dark active">Đơn hàng</a>
                        <a href="{{ route('account.address') }}" class="nav-link text-dark">Địa chỉ</a>
                        <a href="{{ route('account.detail') }}" class="nav-link text-dark">Chi tiết tài khoản</a>
                        <a href="{{ route('account.wishlist') }}" class="nav-link text-dark">Danh sách yêu thích</a>

                        <form action="{{ route('client.logout') }}" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="nav-link fw-semibold text-danger logout-btn">Đăng xuất</button>
                        </form>
                    </nav>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">

                    <div class="checkout__totals-wrapper">
                        <div style="width: 100%" class="checkout__totals">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="mb-0 d-flex align-items-center gap-2">
                                    Chi tiết đơn hàng | <strong>{{ $order->order_code }}</strong> | 
                                    <span class="badge text-white px-3 py-1"
                                        style="background-color: 
                                                 {{ $order->status == 'pending'
                                                     ? '#f0ad4e'
                                                     : ($order->status == 'confirmed'
                                                         ? '#5bc0de'
                                                         : ($order->status == 'cancelled'
                                                             ? '#d9534f'
                                                             : '#a2a2a2')) }} !important;">
                                        {{ $order->status }}
                                    </span>
                                </h4>

                                <button class="btn btn-sm btn-cancel-order"
                                    style="background: #bd2c0b; color:#fff; border-radius:3px"
                                    data-order-id="{{ $order->id }}">
                                    Hủy đơn hàng
                                </button>

                            </div>
                            <hr>
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
                                                    {{ number_format(30000, 0, ',', '.') }}đ</span>
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
                                                | <strong>{{ $order->voucher->code }}</strong>
                                            @endif
                                        </th>
                                        <td class="text-end"> <span class="shopping-cart__product-price">
                                                {{ number_format($discount, 0, ',', '.') }}đ
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
            </div>
        </section>
    </main>
    <div class="mb-5 pb-xl-5"></div>
@endsection

@section('style')
    <style>
        .nav-link {
            font-size: 16px;
            padding: 12px 16px;
            transition: background-color 0.3s ease, padding-left 0.3s ease;
            background: rgb(255, 243, 243);
        }

        .nav-link:hover {
            background: #f0f0f0;
            padding-left: 20px;
        }

        .nav-link.active {
            background: hsl(0, 87%, 94%);
            font-weight: bold;
            color: #d3401f !important;
            border-left: 3px solid #fda3a3;
        }

        /* Hiệu ứng hover cho các liên kết */
        .link-hover {
            transition: color 0.3s ease-in-out;
        }

        .link-hover:hover {
            color: #0d47a1 !important;
            text-decoration: underline;
        }

        /* Bố cục nội dung đẹp hơn */
        .content-box {
            background: white;
            border-radius: 8px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .logout-btn {
            background: none;
            border: none;
            text-align: left;
            width: 100%;
            padding: 12px 16px;
            transition: background-color 0.3s, padding-left 0.3s;
            font-size: 16px;
            color: #c61a18 !important;
            background: rgb(255, 243, 243);
        }

        .logout-btn:hover {
            background: #f5f5f5;
            padding-left: 18px;
        }

        /* Responsive tối ưu */
        @media (max-width: 768px) {
            .container {
                max-width: 100%;
            }

            .nav {
                border-bottom: 1px solid #ddd;
            }

            .content-box {
                margin-top: 20px;
            }
        }
    </style>
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".btn-cancel-order").forEach(button => {
                button.addEventListener("click", function() {
                    let orderId = this.getAttribute("data-order-id");

                    if (confirm("Bạn có chắc chắn muốn hủy đơn hàng này không?")) {
                        fetch(`/account/cancel/${orderId}`, {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute("content"),
                                    "Content-Type": "application/json",
                                },
                                body: JSON.stringify({
                                    order_id: orderId
                                }),
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert("Đơn hàng đã được hủy thành công!");
                                    location.reload();
                                } else {
                                    alert("Lỗi: " + data.message);
                                }
                            })
                            .catch(error => console.error("Lỗi:", error));
                    }
                });
            });
        });
    </script>
@endsection

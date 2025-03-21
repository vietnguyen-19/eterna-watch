@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-4"></div>
    <main style="padding-top: 90px;">
        <div class="mb-2 pb-2"></div>
        <section class="my-account container py-5">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <div class="user-info mb-3"
                        style="display: flex; align-items: center; padding: 15px; border-bottom: 1px solid #eee; background-color: #f8f9fa; border-radius: 5px 5px 0 0; width: 100%; box-sizing: border-box;">
                        <div class="avatar" style="width: 88px; height: 88px; margin-right: 15px;">
                            <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar"
                                style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                        </div>
                        <div class="user-details">
                            <strong>{{ auth()->user()->name }}</strong> <br>
                            <small>{{ auth()->user()->email }}</small>
                        </div>
                    </div>
                    <nav class="nav flex-column account-sidebar sticky-sidebar">
                       
                        <a href="{{ route('account.order') }}" class="nav-link active">
                            <i class="fas fa-shopping-bag me-2"></i> Đơn hàng
                        </a>
                        <a href="{{ route('account.re_password') }}" class="nav-link">
                            <i class="fas fa-key me-2"></i> Cập nhật mật khẩu
                        </a>
                        <a href="{{ route('account.edit') }}" class="nav-link">
                            <i class="fas fa-user me-2"></i> Chi tiết tài khoản
                        </a>
                        <form action="{{ route('client.logout') }}" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="nav-link text-danger logout-btn">
                                <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                            </button>
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

                                @if (!in_array($order->status, ['cancelled', 'completed']))
                                    <button class="btn btn-sm btn-cancel-order"
                                        style="background: #bd2c0b; color:#fff; border-radius:3px"
                                        data-order-id="{{ $order->id }}">
                                        Hủy đơn hàng
                                    </button>
                                @endif

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
                                                | <strong><span style="background:#bd2c0b" class="badge">{{ $order->voucher->code }}</span></strong>
                                            @endif
                                        </th>
                                        <td class="text-end"> <span style="color: #bd2c0b" class="shopping-cart__product-price">
                                                -{{number_format($order->getDiscountAmount(), 0, ',', '.') }}đ
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
    /* Sidebar */
    .account-sidebar .nav-link {
        font-size: 16px;
        padding: 12px 18px;
        border-radius: 3px;
        background: #fdfdfd;
        transition: all 0.3s ease-in-out;
        display: flex;
        align-items: center;
        color: #333;
        font-weight: 500;
    }

    .account-sidebar .nav-link i {
        font-size: 18px;
        width: 24px;
        text-align: center;
    }

    .account-sidebar .nav-link:hover {
        background: #ececec;
        padding-left: 22px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .account-sidebar .nav-link.active {
        background: #e84040;
        color: #ffffff;
        font-weight: bold;
    }

    /* Hiệu ứng hover cho liên kết */
    .link-hover {
        transition: color 0.3s ease-in-out;
    }

    .link-hover:hover {
        color: #0d47a1 !important;
        text-decoration: underline;
    }

    /* Nội dung chính */
    .content-box {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 24px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }

    .logout-btn {
        background: none;
        border: none;
        text-align: left;
        width: 100%;
        padding: 12px 18px;
        transition: background-color 0.3s, padding-left 0.3s;
        font-size: 16px;
        color: #d3401f !important;
        font-weight: bold;
    }

    .logout-btn:hover {
        background: #fff5f5;
        padding-left: 22px;
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
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-cancel-order').forEach(button => {
                button.addEventListener('click', function() {
                    let orderId = this.getAttribute('data-order-id');

                    if (!confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')) {
                        return;
                    }

                    fetch(`{{ route('account.cancel', '') }}/${orderId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                location.reload(); // Hoặc cập nhật UI
                            } else {
                                alert(data.error);
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                        });
                });
            });
        });
    </script>
@endsection

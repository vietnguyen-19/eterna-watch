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
                        @if ($order->payment_method === 'cash')
                            Tiền mặt
                        @else
                           Thanh toán online VNPay
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
            @php
                $status_display = [
                    'pending' => [
                        'label' => 'Đang chờ xử lý',
                        'color' => '#0d6efd',
                        'icon' => 'bi-cart-plus',
                        'description' => 'Đơn hàng đã được tạo.',
                    ],
                    'confirmed' => [
                        'label' => 'Đã xác nhận',
                        'color' => '#0d6efd',
                        'icon' => 'bi-clipboard-check',
                        'description' => 'Đơn hàng được xác nhận.',
                    ],
                    'processing' => [
                        'label' => 'Đang xử lý',
                        'color' => '#ffc107',
                        'icon' => 'bi-box-seam',
                        'description' => 'Đơn hàng đang được xử lý.',
                    ],
                    'completed' => [
                        'label' => 'Hoàn tất',
                        'color' => '#198754',
                        'icon' => 'bi-check-circle-fill',
                        'description' => 'Đơn hàng đã hoàn tất.',
                    ],
                    'cancelled' => [
                        'label' => 'Đã hủy',
                        'color' => '#dc3545',
                        'icon' => 'bi-x-circle-fill',
                        'description' => 'Đơn hàng đã bị hủy.',
                    ],
                ];

                // Danh sách trạng thái cố định, luôn bắt đầu bằng 'pending'
                $fixed_statuses = ['pending'];

                // Thêm các trạng thái khác nếu chúng đã hoàn thành
                $completed_statuses = $order->statusHistories->pluck('new_status')->toArray();
                $possible_statuses = ['confirmed', 'processing', 'completed', 'cancelled'];

                foreach ($possible_statuses as $status) {
                    if (in_array($status, $completed_statuses)) {
                        $fixed_statuses[] = $status;
                    }
                }

                // Đảm bảo không có trạng thái trùng lặp
                $fixed_statuses = array_unique($fixed_statuses);
            @endphp
            <div class="card p-3">
                <h5 class="mb-4">Lịch sử trạng thái đơn hàng</h5>
                <div class="d-flex flex-wrap justify-content-between align-items-start position-relative"
                    style="gap: 1.5rem;">
                    <!-- Connecting line background -->
                    <div class="position-absolute"
                        style="top: 24px; left: 90px; right: 90px; height: 4px; background-color: #dee2e6; z-index: 0;">
                    </div>

                    <?php
                        $total_statuses = count($fixed_statuses);
                        $index = 0;
                        $left_offset = 180;
                
                        foreach ($fixed_statuses as $status):
                            $is_completed = in_array($status, $completed_statuses);
                            $status_data = $order->statusHistories->firstWhere('new_status', $status);
                            $color = $is_completed ? $status_display[$status]['color'] : '#6c757d';
                            $icon = $status_display[$status]['icon'];
                            $label = $status_display[$status]['label'];
                            $description = $status_data ? ($status_data['note'] ?: $status_display[$status]['description']) : 'Trạng thái chưa đạt được.';
                            $changed_at = $status_data ? date('d-m-Y H:i', strtotime($status_data['changed_at'])) : '';
                        ?>
                    <!-- Timeline item -->
                    <div class="text-center position-relative" style="flex: 1; min-width: 180px; z-index: 1;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2"
                            style="width: 48px; height: 48px; background-color: #ffffff; border: 2px solid <?php echo $color; ?>; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            <i class="bi <?php echo $icon; ?>" style="font-size: 1.5rem; color: <?php echo $color; ?>;"></i>
                        </div>
                        <div class="card border-0 shadow-sm" style="border-radius: 0.5rem; background-color: #ffffff;">
                            <div class="card-body p-3">
                                <h6 class="card-title mb-1 fw-semibold"
                                    style="color: <?php echo $color; ?>; font-size: 1rem;"><?php echo $label; ?></h6>
                                <smal font-size: 0.85rem;"><?php echo $changed_at; ?></small>
                                <p class="card-text mb-0 mt-2 font-size: 0.85rem;">
                                    <?php echo $description; ?></p>
                            </div>
                        </div>
                    </div>

                    <?php if ($index < $total_statuses - 1): ?>
                    <!-- Connecting line -->
                    <?php
                    $next_status = $fixed_statuses[$index + 1];
                    $is_next_completed = in_array($next_status, $completed_statuses);
                    $line_color = $is_completed && $is_next_completed ? $color : '#dee2e6';
                    ?>
                    <div class="position-absolute"
                        style="top: 24px; left: <?php echo $left_offset; ?>px; width: 20%; height: 4px; background-color: <?php echo $line_color; ?>; z-index: 0;">
                    </div>
                    <?php $left_offset += 180; ?>
                    <?php endif; ?>

                    <?php
                        $index++;
                    endforeach;
                    ?>
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
                    Hoàn trả đơn hàng
                </a>

            </div>

        </div>
        @if ($order->refund)
            @php
                $status = $order->refund->status ?? 'pending';

                // Gán inline style màu sắc theo trạng thái
                switch ($status) {
                    case 'approved':
                        $borderColor = '#28a745'; // xanh lá

                        break;
                    case 'rejected':
                        $borderColor = '#dc3545'; // đỏ

                        break;
                    default:
                        // pending
                        $borderColor = '#ffc107'; // vàng

                        break;
                }
            @endphp


<div class="card mb-4 border-0 rounded-3" style="box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <!-- Card Header -->
    <div class="card-header border-0 bg-white py-3" style="border-top: 2px solid {{ $borderColor }};">
        <h5 class="card-title mb-0 fw-bold" style="color: #212529;">Thông tin hoàn trả đơn hàng</h5>
    </div>

    <!-- Card Body -->
    <div class="card-body p-4">
        <!-- Refund Information -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <p class="fw-bold mb-1">Ngày yêu cầu</p>
                <p style="color: #212529;">{{ $order->refund->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="col-md-6">
                <p class="fw-bold mb-1">Trạng thái</p>
                @if ($status == 'pending')
                    <span class="badge" style="background-color: #fff3cd; color: #664d03; padding: 0.5em 1em; font-size: 0.875rem;">
                        <i class="bi bi-hourglass-split me-1"></i> Đang chờ duyệt
                    </span>
                @elseif ($status == 'approved')
                    <span class="badge" style="background-color: #d1e7dd; color: #0f5132; padding: 0.5em 1em; font-size: 0.875rem;">
                        <i class="bi bi-check-circle-fill me-1"></i> Đã duyệt
                    </span>
                @else
                    <span class="badge" style="background-color: #f8d7da; color: #842029; padding: 0.5em 1em; font-size: 0.875rem;">
                        <i class="bi bi-x-circle-fill me-1"></i> Bị từ chối
                    </span>
                @endif
            </div>
           
            <div class="col-md-12">
                <p class="fw-bold mb-1">Lý do hoàn</p>
                <p style="color: #212529;">{{ $order->refund->refund_reason }}</p>
            </div>
           
            @if ($status == 'rejected' && $order->refund->rejected_reason)
                <div class="col-md-12">
                    <p class="fw-bold mb-1">Lý do từ chối</p>
                    <p style="color: #212529;">{{ $order->refund->rejected_reason }}</p>
                </div>
            @endif
            <div class="mb-4">
                <p class="fw-bold mb-3">Sản phẩm hoàn</p>
                <div class="list-group">
                    @foreach ($order->refund->refundItems as $item)
                        <div class="list-group-item border-0 rounded-3 mb-2" style="background-color: #e7e7e7;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-1 fw-bold" style="color: #212529;">{{ $item->orderItem->productVariant->product->name }}</p>
                                    <p class="mb-0 small">Số lượng: {{ $item->quantity }}</p>
                                </div>
                                <p class="mb-0 fw-semibold" style="color: #212529;">{{ number_format($item->unit_price) }}đ</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-3 border-top" style="border-color: #dee2e6;">
                <p class="fw-bold">Tổng tiền hoàn</p>
                <p class="fw-bold fs-5" style="color: #212529;">{{ number_format($order->refund->total_refund_amount) }}đ</p>
            </div>
        </div>

        <!-- Divider -->
        <hr class="my-4" style="border-color: #dee2e6;">

        <!-- Refund Items -->
        

        <!-- Total Refund Amount -->
        
    </div>
</div>

<!-- Bootstrap JS Bundle CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        @endif
    </div>
@endsection


@section('style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        </script>
    @endif
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
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công!',
                                    text: data.message,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    showConfirmButton: false
                                }).then(() => {
                                    location
                                        .reload(); // Hoặc cập nhật lại giao diện nếu muốn
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi!',
                                    text: data.message,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    showConfirmButton: false
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                        });
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const refundButton = document.querySelector('.btn-refund-order');
            if (refundButton) {
                refundButton.addEventListener('click', function(e) {
                    if (this.dataset.allowRefund === '0') {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Không thể hoàn trả đơn hàng này.',
                            confirmButtonText: 'OK',
                            timer: 3000,
                            timerProgressBar: true,
                            showConfirmButton: false
                        });
                    }
                });
            }
        });
    </script>
@endsection

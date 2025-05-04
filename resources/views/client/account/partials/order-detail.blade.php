@extends('client.account.main')
@section('account_content')
    <div class="checkout__totals-wrapper">
        <div style="width: 100%" class="checkout__totals">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="text-center">
                    <h4 class="mb-0">
                        Chi tiết đơn hàng | <strong>{{ $order->order_code }}</strong>
                    </h4>
                </div>
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
                            @if (!empty($order->payment?->txn_ref))
                                <br>
                                <strong>Mã giao dịch VNPay:</strong> {{ $order->payment->txn_ref }}
                            @endif
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
                        'description' => 'Đơn hàng đã được tạo thành công.',
                    ],
                    'confirmed' => [
                        'label' => 'Đã xác nhận',
                        'color' => '#0d6efd',
                        'icon' => 'bi-clipboard-check',
                        'description' => 'Đơn hàng được cửa hàng xác nhận.',
                    ],
                    'processing' => [
                        'label' => 'Đang vận chuyển',
                        'color' => '#ffc107',
                        'icon' => 'bi-box-seam',
                        'description' => 'Đơn hàng đang được vận chuyển',
                    ],
                    'completed' => [
                        'label' => 'Hoàn tất',
                        'color' => '#198754',
                        'icon' => 'bi-check-circle-fill',
                        'description' => 'Đơn hàng hoàn tất đến khách hàng.',
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
            <div class="card p-3 mb-3">
                <h5 class="mb-2">Địa chỉ giao hàng</h5>
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                    <tbody style="font-size: 0.9rem; color: #333;">
                        <tr>
                            <td style="padding: 8px; border-bottom: 1px solid #ddd; font-weight: bold; width: 150px;">Họ và
                                tên:</td>
                            <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $order->address->full_name }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; border-bottom: 1px solid #ddd; font-weight: bold;">Số điện thoại:</td>
                            <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $order->address->phone_number }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; border-bottom: 1px solid #ddd; font-weight: bold;">Email:</td>
                            <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $order->address->email }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; border-bottom: 1px solid #ddd; font-weight: bold;">Địa chỉ:</td>
                            <td style="padding: 8px; border-bottom: 1px solid #ddd;">
                                {{ $order->address->street_address }},
                                {{ $order->address->ward }},
                                {{ $order->address->district }},
                                {{ $order->address->city }},
                                {{ $order->address->country }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

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
                        @if ($order->status == 'completed')
                            <th class="fw-bold text-end">Hành động</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td colspan="2">
                                <div class="d-flex align-items-center">
                                    {{-- Ảnh sản phẩm --}}
                                    @if ($item->productVariant?->product)
                                        <a href="{{ route('client.shop.show', $item->productVariant->product->id) }}">
                                            <img src="{{ Storage::url($item->image ?? 'default-avatar.png') }}"
                                                alt="product image" width="88" height="88"
                                                style="object-fit: cover; border: 1px solid #c4bebe;">
                                        </a>
                                    @else
                                        <img src="{{ Storage::url($item->image ?? 'default-avatar.png') }}"
                                            alt="product image" width="88" height="88"
                                            style="object-fit: cover; border: 1px solid #c4bebe;">
                                    @endif

                                    {{-- Phần thông tin sản phẩm --}}
                                    <div class="ms-3">
                                        {{-- Tên sản phẩm --}}
                                        <div>
                                            @if ($item->productVariant?->product)
                                                <a href="{{ route('client.shop.show', $item->productVariant->product->id) }}"
                                                    class="text-dark text-decoration-none">
                                                    <strong>{{ $item->product_name }}</strong>
                                                </a>
                                            @else
                                                <strong
                                                    onclick="alert('Sản phẩm này đã bị xóa')">{{ $item->product_name }}</strong>
                                            @endif

                                        </div>

                                        {{-- Hiển thị thuộc tính và giá trị --}}
                                        <ul class="mb-0 small text-muted">
                                            @foreach ($item->value_attribute_objects as $attrVal)
                                                <li>{{ $attrVal->attribute->attribute_name }}: {{ $attrVal->value_name }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                <span class="shopping-cart__product-price">
                                    {{ number_format($item->unit_price, 0, ',', '.') }}đ
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="shopping-cart__product-price">{{ $item->quantity }}</span>
                            </td>
                            <td class="text-end">
                                <span class="shopping-cart__product-price">
                                    {{ number_format($item->total_price, 0, ',', '.') }}đ
                                </span>
                            </td>

                            @if ($order->status == 'completed')
                                <td class="text-end">
                                    @php
                                        // Kiểm tra xem sản phẩm có tồn tại hay không
                                        $product = $item->productVariant->product;
                                        $daDanhGia = $product
                                            ? \App\Models\Comment::where('user_id', auth()->id())
                                                ->where('entity_type', 'product')
                                                ->where('entity_id', $product->id)
                                                ->exists()
                                            : false;

                                        $modalId = 'reviewModal_' . $item->id; // mỗi modal là duy nhất
                                    @endphp

                                    @php
                                        $buttonStyle =
                                            'width: 110px; padding: 6px 14px; font-weight: 500; font-size: 0.9rem; border: none; border-radius: 3px;';
                                    @endphp

                                    @if ($product)
                                        <!-- Kiểm tra nếu sản phẩm tồn tại -->
                                        @if ($daDanhGia)
                                            <button class="btn btn-sm"
                                                style="{{ $buttonStyle }} background-color: #22c55e; color: #ffffff;">
                                                Đã đánh giá
                                            </button>
                                        @else
                                            <button class="btn btn-sm"
                                                style="{{ $buttonStyle }} background-color: #f97316; color: #ffffff;"
                                                data-bs-toggle="modal" data-bs-target="#{{ $modalId }}"
                                                onmouseover="this.style.backgroundColor='#ea580c';"
                                                onmouseout="this.style.backgroundColor='#f97316';">
                                                Đánh giá
                                            </button>
                                        @endif

                                        {{-- Modal đánh giá --}}
                                        <div class="modal fade" id="{{ $modalId }}" tabindex="-1"
                                            aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content" style="border-radius: 2px;">
                                                    <div class="modal-header"
                                                        style="background-color: #d0d0d0; color: #ffffff; border-radius: 2px 2px 0 0;">
                                                        <h5 class="modal-title" id="{{ $modalId }}Label">
                                                            <strong>Đánh giá sản phẩm
                                                                "{{ $product->name }}"</strong>
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <div class="product-single__review-form">
                                                            <form method="POST"
                                                                action="{{ route('comments.store', $product->id) }}">
                                                                @csrf

                                                                <div class="select-star-rating mb-4">
                                                                    <span class="star-rating d-flex gap-1">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            <svg class="star-rating__star-icon"
                                                                                width="16" height="16"
                                                                                fill="#ccc" viewBox="0 0 12 12"
                                                                                xmlns="http://www.w3.org/2000/svg">
                                                                                <path
                                                                                    d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z" />
                                                                            </svg>
                                                                        @endfor
                                                                    </span>
                                                                    <input name="rating" type="hidden"
                                                                        id="form-input-rating-{{ $item->id }}"
                                                                        value="">
                                                                </div>

                                                                <input type="hidden" name="entity_type" value="product">
                                                                <div class="mb-4">
                                                                    <textarea name="content" class="form-control" rows="6" placeholder="Nội dung đánh giá của bạn"></textarea>
                                                                </div>

                                                                <div class="text-end">
                                                                    <button type="submit" class="btn"
                                                                        style="background-color: #f97316; color: #ffffff;">
                                                                        Gửi đánh giá
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- End Modal --}}
                                    @else
                                        {{-- Sản phẩm đã bị xóa --}}
                                        <strong style="color:red" class="">Sản phẩm đã bị xóa</strong>
                                    @endif
                                </td>
                            @endif

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
                @if (in_array($order->status, ['pending', 'confirmed']))
                    <button class="btn btn-sm btn-cancel-order" style="background: #bd2c0b; color:#fff; border-radius:3px"
                        data-order-id="{{ $order->id }}" data-allow-cancel="1">
                        Hủy đơn hàng
                    </button>
                @endif
                @if ($order->status == 'completed' && !$order->refund)
                    <a href="{{ route('refunds.create', $order->id) }}" class="btn btn-sm btn-refund-order"
                        style="background: #d7b20e; color:#fff; border-radius:3px" data-allow-refund="1">
                        Hoàn trả đơn hàng
                    </a>
                @endif
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


            <!-- Simplified Refund Card Layout -->
            <div
                style="margin:0 auto; background:#f4f4f4; border:1px solid #000000;  padding:24px; font-family:Arial, sans-serif;">
                <h3 style="text-align:center; font-size:1.8em; margin-bottom:24px; color:#333;">Hoàn trả đơn hàng</h3>

                {{-- Thông tin ngày yêu cầu & trạng thái --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:24px;">
                    <div style="background:#fff; padding:16px; border-radius:6px; text-align:center;">
                        <p style="margin:0 0 6px; font-size:0.9em; color:#6c757d; font-weight:500;">Ngày yêu cầu</p>
                        <p style="margin:0; font-size:1.1em; font-weight:600; color:#212529;">
                            {{ $order->refund->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                    <div style="background:#fff; padding:16px; border-radius:6px; text-align:center;">
                        <p style="margin:0 0 6px; font-size:0.9em; color:#6c757d; font-weight:500;">Trạng thái</p>
                        @if ($status == 'pending')
                            <span
                                style="display:inline-block; padding:6px 12px; font-weight:600; color:#856404; background:#fff3cd; border-radius:4px;">
                                <i class="bi bi-hourglass-split" style="margin-right:5px;"></i>Chờ duyệt
                            </span>
                        @elseif ($status == 'approved')
                            <span
                                style="display:inline-block; padding:6px 12px; font-weight:600; color:#155724; background:#d4edda; border-radius:4px;">
                                <i class="bi bi-check-circle-fill" style="margin-right:5px;"></i>Đã duyệt
                            </span>
                        @else
                            <span
                                style="display:inline-block; padding:6px 12px; font-weight:600; color:#721c24; background:#f8d7da; border-radius:4px;">
                                <i class="bi bi-x-circle-fill" style="margin-right:5px;"></i>Từ chối
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Thông tin hoàn tiền VNPay --}}
                @if ($status == 'approved' && $order->refund->vnp_transaction_no && $order->refund->refunded_at)
                    <div style="margin-bottom:24px;">
                        <p style="margin:0 0 6px; font-size:0.9em; color:#6c757d; font-weight:500;">Thông tin hoàn tiền
                            VNPay</p>
                        <div style="background:#fff; padding:16px; border-radius:6px;">
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                                <div>
                                    <p style="margin:0 0 5px; font-size:0.9em; color:#6c757d; font-weight:500;">Mã giao
                                        dịch VNPay</p>
                                    <p style="margin:0; font-size:1.1em; font-weight:600; color:#212529;">
                                        {{ $order->refund->vnp_transaction_no }}
                                    </p>
                                </div>
                                <div>
                                    <p style="margin:0 0 5px; font-size:0.9em; color:#6c757d; font-weight:500;">Thời gian
                                        hoàn tiền</p>
                                    <p style="margin:0; font-size:1.1em; font-weight:600; color:#212529;">
                                        {{ $order->refund->refunded_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Lý do hoàn --}}
                <div style="margin-bottom:24px;">
                    <p style="margin:0 0 6px; font-size:0.9em; color:#6c757d; font-weight:500;">Lý do hoàn</p>
                    <div style="background:#fff; padding:16px; border-radius:6px;">
                        <p style="margin:0; font-size:1.1em; color:#212529;">
                            {{ $order->refund->refund_reason }}
                        </p>
                    </div>
                </div>

                {{-- Lý do từ chối --}}
                @if ($status == 'rejected' && $order->refund->rejected_reason)
                    <div style="margin-bottom:24px;">
                        <p style="margin:0 0 6px; font-size:0.9em; color:#6c757d; font-weight:500;">Lý do từ chối</p>
                        <div style="background:#fff; padding:16px; border-radius:6px;">
                            <p style="margin:0; font-size:1.1em; color:#212529;">
                                {{ $order->refund->rejected_reason }}
                            </p>
                        </div>
                    </div>
                @endif

                {{-- Sản phẩm hoàn --}}
                <div style="margin-bottom:24px;">
                    <p style="margin:0 0 10px; font-size:0.9em; color:#6c757d; font-weight:500;">Sản phẩm hoàn</p>
                    <div style="background:#fff; border-radius:6px; padding:12px;">
                        @foreach ($order->refund->refundItems as $item)
                            <div
                                style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #e9ecef;">
                                <div>
                                    <p style="margin:0 0 4px; font-size:1.1em; font-weight:500; color:#212529;">
                                        {{ $item->orderItem->product_name }}
                                    </p>
                                    <p style="margin:0; font-size:0.9em; color:#6c757d;">Số lượng: {{ $item->quantity }}
                                    </p>
                                </div>
                                <p style="margin:0; font-size:1.1em; font-weight:600; color:#212529;">
                                    {{ number_format($item->unit_price) }}₫
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Tổng tiền hoàn --}}
                <div
                    style="background:#fff; padding:16px; border-radius:6px; display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
                    <p style="margin:0; font-size:1.1em; font-weight:600; color:#212529;">Tổng tiền hoàn</p>
                    <p style="margin:0; font-size:1.3em; font-weight:700; color:#28a745;">
                        {{ number_format($order->refund->total_refund_amount) }}₫
                    </p>
                </div>
            </div>

            <!-- Bootstrap JS Bundle CDN -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
            </script>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.select-star-rating').forEach(function(container) {
                const stars = container.querySelectorAll('.star-rating__star-icon');
                const input = container.querySelector('input[name="rating"]');

                stars.forEach((star, index) => {
                    star.style.cursor = 'pointer';
                    star.addEventListener('click', function() {
                        const rating = index + 1;

                        // Cập nhật input
                        input.value = rating;

                        // Highlight sao
                        stars.forEach((s, i) => {
                            s.querySelector('path').setAttribute('fill', i <
                                rating ? '#f97316' : '#ccc');
                        });
                    });
                });
            });
        });
    </script>
@endsection

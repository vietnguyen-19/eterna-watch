@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-light border-bottom">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <h5 class="mb-2 mb-sm-0">
                                    <b>Yêu cầu hoàn hàng - Đơn hàng #{{ $refund->order->order_code }}</b> |
                                    <strong>Trạng thái hoàn hàng:</strong>
                                    <span
                                        class="badge fs-6 {{ $refund->status == 'approved' ? 'bg-success text-white' : ($refund->status == 'pending' ? 'bg-warning text-dark' : 'bg-danger text-white') }}">
                                        @php
                                            $statusMap = [
                                                'approved' => 'Đã duyệt',
                                                'pending' => 'Đang chờ duyệt',
                                                'rejected' => 'Từ chối',
                                            ];
                                            echo $statusMap[$refund->status] ?? 'Không xác định';
                                        @endphp
                                    </span>
                                </h5>

                                <div class="d-flex gap-2 align-items-center">
                                    {{-- Hiển thị trạng thái hiện tại --}}

                                    {{-- Nút duyệt và từ chối --}}
                                    @if ($refund->status != 'approved' && $refund->status != 'rejected')
                                        {{-- Nút duyệt --}}
                                        @if ($refund->order->payment_method == 'vnpay')
                                            {{-- Duyệt và hoàn tiền VNPay --}}
                                            <form method="POST"
                                                action="{{ route('admin.refunds.approve.vnpay', $refund) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-success"
                                                    onclick="return confirm('Duyệt hoàn tiền qua VNPay?')">
                                                    <i class="bi bi-credit-card"></i> Duyệt và hoàn tiền VNPay
                                                </button>
                                            </form>
                                        @else
                                            {{-- Duyệt đơn hoàn COD --}}
                                            <form method="POST" action="{{ route('admin.refunds.approve.cod', $refund) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-success"
                                                    onclick="return confirm('Xác nhận duyệt hoàn hàng (COD)?')">
                                                    <i class="bi bi-check-circle"></i> Duyệt hoàn hàng
                                                </button>
                                            </form>
                                        @endif
                                        {{-- Nút mở modal từ chối --}}
                                        <button type="button" class="btn btn-danger ml-1" data-bs-toggle="modal"
                                            data-bs-target="#rejectModal">
                                            <i class="bi bi-x-circle me-1"></i> Từ chối
                                        </button>
                                    @else
                                        {{-- Nút bị vô hiệu hóa khi trạng thái là approved hoặc rejected --}}
                                        @if ($refund->order->payment_method == 'vnpay')
                                            <button type="button" class="btn btn-success" disabled
                                                title="Yêu cầu đã {{ $refund->status == 'approved' ? 'được duyệt' : 'bị từ chối' }}">
                                                <i class="bi bi-credit-card"></i> Duyệt và hoàn tiền VNPay
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-success" disabled
                                                title="Yêu cầu đã {{ $refund->status == 'approved' ? 'được duyệt' : 'bị từ chối' }}">
                                                <i class="bi bi-check-circle"></i> Duyệt hoàn hàng
                                            </button>
                                        @endif
                                        <button type="button" class="btn btn-danger ml-1" disabled
                                            title="Yêu cầu đã {{ $refund->status == 'approved' ? 'được duyệt' : 'bị từ chối' }}">
                                            <i class="bi bi-x-circle me-1"></i> Từ chối
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Modal từ chối --}}
                        <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('admin.refunds.reject', $refund) }}">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="rejectModalLabel">Lý do từ chối hoàn hàng</h5>

                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="rejectReason" class="form-label">Lý do:</label>
                                                <input type="text" class="form-control" name="rejected_reason"
                                                    id="rejectReason" placeholder="Nhập lý do từ chối..." required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Hủy</button>
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Xác nhận từ chối hoàn hàng?')">Xác nhận từ
                                                chối</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>



                        <div class="card-body">
                            <div class="row">
                                <!-- Cột thông tin người dùng -->
                                <div class="col-md-3">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <div class="row g-4 align-items-center">
                                                <div class="col-sm">
                                                    <h5 class="card-title mb-0"><b>Thông tin khách hàng</b></h5>
                                                </div>
                                                <div class="col-sm-auto">
                                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                                        <a href="{{ route('admin.users.show', $refund->order->user->id) }}"
                                                            class="btn btn-sm btn-info" data-bs-toggle="tooltip"
                                                            title="Xem người dùng">
                                                            <i class="fas fa-eye"></i>
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-4">
                                                <img src="{{ $refund->order->user->avatar ? Storage::url($refund->order->user->avatar) : asset('images/default-avatar.png') }}"
                                                    alt="Avatar" class="rounded-circle shadow-sm me-3" width="80"
                                                    height="80" style="object-fit: cover; border: 2px solid #0d6efd;">
                                                <div class="ml-3">
                                                    <h5 class="fw-bold mb-0">{{ $refund->order->user->name ?? 'N/A' }}</h5>
                                                    <p class="text-muted small mb-0">Khách hàng</p>
                                                </div>
                                            </div>

                                            <!-- Thông tin khách hàng -->
                                            <div class="info-list">
                                                <p class="mb-2 text-center">

                                                    <strong>Email:</strong> {{ $refund->order->user->email ?? 'N/A' }}
                                                </p>
                                                <p class="mb-2 text-center">

                                                    <strong>Số điện thoại:</strong>
                                                    {{ $refund->order->user->phone ?? 'N/A' }}
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <div class="row g-4 align-items-center">
                                                <div class="col-sm">
                                                    <h5 class="card-title mb-0"><b>Thông tin đơn hàng</b></h5>
                                                </div>
                                                <div class="col-sm-auto">
                                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                                        <a href="{{ route('admin.orders.edit', $refund->order->id) }}"
                                                            class="btn btn-sm btn-info" title="Xem đơn hàng">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">

                                            <div class="info-list">
                                                <p class="mb-2 d-flex justify-content-between">
                                                    <strong>PT thanh toán:</strong>
                                                    <span>{{ strtoupper($refund->order->payment_method) }}</span>
                                                </p>

                                                <p class="mb-2 d-flex justify-content-between">
                                                    <strong>TT thanh toán:</strong>
                                                    <span>
                                                        @php
                                                            $status =
                                                                $refund->order->payment->payment_status ?? 'unknown';
                                                            $paymentStatusLabels = [
                                                                'completed' => 'Thành công',
                                                                'pending' => 'Đang xử lý',
                                                                'failed' => 'Thất bại',
                                                            ];
                                                            $paymentStatusColors = [
                                                                'completed' => 'success',
                                                                'pending' => 'warning',
                                                                'failed' => 'danger',
                                                                'canceled' => 'secondary',
                                                                'unknown' => 'dark',
                                                            ];
                                                        @endphp
                                                        <span
                                                            class="badge bg-{{ $paymentStatusColors[$status] ?? 'dark' }}">
                                                            {{ $paymentStatusLabels[$status] ?? ucfirst($status) }}
                                                        </span>
                                                    </span>
                                                </p>

                                                <p class="mb-2 d-flex justify-content-between">
                                                    <strong>TT đơn hàng:</strong>
                                                    <span>
                                                        @php
                                                            $orderStatus = $refund->order->status ?? 'unknown';
                                                            $orderStatusLabels = [
                                                                'pending' => 'Chờ xác nhận',
                                                                'processing' => 'Đang xử lý',
                                                                'shipping' => 'Đang giao',
                                                                'completed' => 'Đã hoàn tất',
                                                                'cancelled' => 'Đã hủy',
                                                            ];
                                                            $orderStatusColors = [
                                                                'pending' => 'secondary',
                                                                'processing' => 'info',
                                                                'shipping' => 'warning',
                                                                'completed' => 'success',
                                                                'cancelled' => 'danger',
                                                                'unknown' => 'dark',
                                                            ];
                                                        @endphp
                                                        <span
                                                            class="badge bg-{{ $orderStatusColors[$orderStatus] ?? 'dark' }}">
                                                            {{ $orderStatusLabels[$orderStatus] ?? ucfirst($orderStatus) }}
                                                        </span>
                                                    </span>
                                                </p>

                                                @php
                                                    $completedHistory = $refund->order->statusHistories->firstWhere(
                                                        'new_status',
                                                        'completed',
                                                    );
                                                @endphp
                                                <p class="mb-0 d-flex justify-content-between">
                                                    <strong>Ngày hoàn tất:</strong>
                                                    <span>{{ $completedHistory ? \Carbon\Carbon::parse($completedHistory->changed_at)->format('d/m/Y H:i') : 'Chưa hoàn tất' }}</span>
                                                </p>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="card" id="refundStatusHistory">
                                        <div class="card-header border-bottom-dashed">
                                            <h5 class="card-title mb-0"><b>Lịch sử trạng thái hoàn hàng</b></h5>
                                        </div>

                                        @php
                                            if (!function_exists('getStatusColorClass')) {
                                                function getStatusColorClass($status)
                                                {
                                                    $colors = [
                                                        'pending' => 'badge bg-warning',
                                                        'approved' => 'badge bg-success',
                                                        'rejected' => 'badge bg-danger',
                                                    ];

                                                    return $colors[$status] ?? 'badge bg-dark';
                                                }
                                            }

                                            if (!function_exists('getStatusLabel')) {
                                                function getStatusLabel($status)
                                                {
                                                    $labels = [
                                                        'pending' => 'Chờ duyệt',
                                                        'approved' => 'Đã chấp nhận',
                                                        'rejected' => 'Bị từ chối',
                                                    ];

                                                    return $labels[$status] ?? 'Không xác định';
                                                }
                                            }

                                            $hasPending =
                                                $statusHistories->contains('old_status', 'pending') ||
                                                $statusHistories->contains('new_status', 'pending');
                                        @endphp
                                        <div class="card-body">
                                            <div class="list-group">
                                                {{-- Nếu chưa có bản ghi "pending", hiển thị mặc định --}}
                                                @if (!$hasPending)
                                                    <div
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <span
                                                                class="badge bg-warning fs-5 px-2 py-1">{{ getStatusLabel('pending') }}</span>
                                                            <div class="text-muted">
                                                                {{ \Carbon\Carbon::parse($refund->created_at)->format('d-m-Y H:i:s') }}
                                                            </div>
                                                        </div>
                                                        <div><strong>Hệ thống</strong></div>
                                                    </div>
                                                @endif

                                                @foreach ($statusHistories as $history)
                                                    <div
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <span
                                                                class="{{ getStatusColorClass($history->new_status) }} fs-5 px-2 py-1">
                                                                {{ getStatusLabel($history->new_status) }}
                                                            </span>
                                                            <div class="text-muted">
                                                                {{ \Carbon\Carbon::parse($history->changed_at)->format('d-m-Y H:i:s') }}
                                                            </div>
                                                        </div>
                                                        <div><strong>{{ $history->user->name ?? 'Hệ thống' }}</strong>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- Cột danh sách sản phẩm hoàn hàng -->
                                <div class="col-md-9">
                                    <div class="card">
                                        <div class="card-header fw-bold text-primary">
                                            <strong> Sản phẩm hoàn lại</strong>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead class="">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Sản phẩm</th>
                                                            <th>Số lượng trong đơn hàng</th>
                                                            <th>Số lượng hoàn</th>

                                                            <th>Giá (đ)</th>
                                                            <th>Thành tiền (đ)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $subtotal = 0; @endphp

                                                        @foreach ($refund->refundItems as $refundItem)
                                                            @php
                                                                $item = $refundItem->orderItem;
                                                                $product = $item->productVariant->product;
                                                                $subtotal += $item->total_price;
                                                            @endphp
                                                            <tr>
                                                                <td class="align-middle">{{ $product->id }}</td>
                                                                <td class="align-middle">
                                                                    <div class="d-flex align-items-center">
                                                                        {{-- Ảnh sản phẩm --}}
                                                                        <img src="{{ Storage::url($item->image ?? 'default-avatar.png') }}"
                                                                            width="88" height="88"
                                                                            class="rounded border" alt="product image">

                                                                        {{-- Thông tin sản phẩm --}}
                                                                        <div class="ms-3 ml-2">
                                                                            {{-- Tên sản phẩm --}}
                                                                            <div><strong>{{ $item->product_name }}</strong>
                                                                            </div>

                                                                            {{-- Danh sách thuộc tính --}}
                                                                            <ul class="mb-0 ps-3">
                                                                                @foreach ($item->value_attribute_objects as $attrVal)
                                                                                    <li class="small text-muted">
                                                                                        {{ $attrVal->attribute->attribute_name }}:
                                                                                        {{ $attrVal->value_name }}
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="align-middle">
                                                                    {{ $refundItem->orderItem->quantity }}</td>
                                                                <td class="align-middle">{{ $refundItem->quantity }}</td>
                                                                <td class="align-middle">
                                                                    {{ number_format($refundItem->unit_price, 0, ',', '.') }}
                                                                    đ</td>
                                                                <td class="align-middle">
                                                                    {{ number_format($refundItem->quantity * $refundItem->unit_price, 0, ',', '.') }}
                                                                    đ</td>
                                                            </tr>
                                                        @endforeach


                                                        @php
                                                            $order = $refund->order;

                                                        @endphp

                                                        <tr>
                                                            <th colspan="5" class="text-end">Đã thanh toán</th>
                                                            <td class="text-end">
                                                                {{ number_format($order->total_amount, 0, ',', '.') }} đ
                                                            </td>
                                                        </tr>

                                                        @if ($order->voucher)
                                                            <tr>
                                                                <th colspan="5" class="text-end">Mã giảm giá đã sử dụng
                                                                    trong đơn hàng</th>
                                                                <td class="text-end">
                                                                    <span
                                                                        class="badge bg-success">{{ $order->voucher->code }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="5" class="text-end">Giảm giá</th>
                                                                <td class="text-end">
                                                                    -{{ number_format($order->getDiscountAmount(), 0, ',', '.') }}
                                                                    đ
                                                                </td>
                                                            </tr>
                                                        @endif

                                                        <tr>
                                                            <th colspan="5" class="text-end"><strong>Tổng hoàn
                                                                    trả</strong></th>
                                                            <td class="text-end">
                                                                <strong>{{ number_format($refund->total_refund_amount, 0, ',', '.') }}
                                                                    đ</strong>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div style="border-top: 1px rgb(237, 237, 237) solid; "
                                            class="card-header fw-bold text-primary">
                                            <strong> Lý do hoàn hàng</strong>
                                        </div>
                                        <div class="card-body">
                                            {{ $refund->refund_reason }}
                                        </div>
                                        @if ($order->refund->rejected_reason)
                                            <div style="border-top: 1px rgb(237, 237, 237) solid; "
                                                class="card-header fw-bold text-danger">
                                                <strong> Lý do từ chối hoàn hàng</strong>
                                            </div>
                                            <div class="card-body">
                                                {{ $refund->rejected_reason }}
                                            </div>
                                        @endif
                                        <div style="border-top: 1px rgb(237, 237, 237) solid; "
                                            class="card-header fw-bold text-primary">
                                            <strong> Hình ảnh minh chứng</strong>
                                        </div>
                                        <div class="card-body">
                                            @foreach ($refund->imageRefunds as $item)
                                                <img src="{{ Storage::url($item->image) }}" alt="Avatar"
                                                    width="200" height="200" class="me-2 rounded">
                                            @endforeach

                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

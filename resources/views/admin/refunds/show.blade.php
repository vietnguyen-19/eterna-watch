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

                                <div class="d-flex gap-2">
                                    {{-- Nút duyệt --}}
                                    <form method="POST" action="{{ route('admin.refunds.approve', $refund) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success"
                                            onclick="return confirm('Xác nhận duyệt hoàn hàng?')">
                                            <i class="bi bi-check-circle me-1"></i> Duyệt
                                        </button>
                                    </form>

                                    {{-- Nút mở modal từ chối --}}
                                    <button type="button" class="btn btn-danger ml-1" data-bs-toggle="modal"
                                        data-bs-target="#rejectModal">
                                        <i class="bi bi-x-circle me-1"></i> Từ chối
                                    </button>
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
                                        <div class="card-header fw-semibold text-primary">
                                            <strong> Thông tin khách hàng</strong>
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
                                                <p class="mb-2">
                                                    <i class="bi bi-envelope-fill me-2 text-primary"></i>
                                                    <strong>Email:</strong> {{ $refund->order->user->email ?? 'N/A' }}
                                                </p>
                                                <p class="mb-2">
                                                    <i class="bi bi-telephone-fill me-2 text-primary"></i>
                                                    <strong>Số điện thoại:</strong>
                                                    {{ $refund->order->user->phone ?? 'N/A' }}
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
                                                            <span class="badge bg-warning fs-5 px-2 py-1">pending</span>
                                                            <div class="text-muted">
                                                                {{ \Carbon\Carbon::parse($refund->created_at)->format('d-m-Y H:i:s') }}
                                                            </div>
                                                        </div>
                                                        <div><strong>Hệ thống</strong></div>
                                                    </div>
                                                @endif

                                                {{-- Hiển thị các lịch sử trạng thái --}}
                                                @foreach ($statusHistories as $history)
                                                    <div
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <span
                                                                class="{{ getStatusColorClass($history->new_status) }} fs-5 px-2 py-1">
                                                                {{ $history->new_status }}
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

                                                            <th>Giá (VNĐ)</th>
                                                            <th>Thành tiền (VNĐ)</th>
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
                                                                <td>{{ $product->id }}</td>
                                                                <td>
                                                                    <img src="{{ Storage::url($product->avatar ?? 'default-avatar.png') }}"
                                                                        alt="Avatar" width="40" height="40"
                                                                        class="me-2 rounded">
                                                                    {{ $product->name }}
                                                                </td>
                                                                <td>{{ $refundItem->orderItem->quantity }}</td>
                                                                <td>{{ $refundItem->quantity }}</td>
                                                                <td>{{ number_format($refundItem->unit_price, 0, ',', '.') }}
                                                                    VND
                                                                </td>
                                                                <td>{{ number_format($refundItem->quantity * $refundItem->unit_price, 0, ',', '.') }}
                                                                    VND</td>
                                                            </tr>
                                                        @endforeach

                                                        @php
                                                            $order = $refund->order;

                                                        @endphp

                                                        <tr>
                                                            <th colspan="5" class="text-end">Đã thanh toán</th>
                                                            <td class="text-end">
                                                                {{ number_format($order->total_amount, 0, ',', '.') }} VND
                                                            </td>
                                                        </tr>

                                                        @if ($order->voucher)
                                                            <tr>
                                                                <th colspan="4" class="text-end">Mã giảm giá đã sử dụng
                                                                    trong đơn hàng</th>
                                                                <td class="text-end">
                                                                    <span
                                                                        class="badge bg-success">{{ $order->voucher->code }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="4" class="text-end">Giảm giá</th>
                                                                <td class="text-end">
                                                                    -{{ number_format($order->getDiscountAmount(), 0, ',', '.') }}
                                                                    VND
                                                                </td>
                                                            </tr>
                                                        @endif

                                                        <tr>
                                                            <th colspan="4" class="text-end"><strong>Tổng hoàn
                                                                    trả</strong></th>
                                                            <td class="text-end">
                                                                <strong>{{ number_format($refund->total_refund_amount, 0, ',', '.') }}
                                                                    VND</strong>
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
                                        <div style="border-top: 1px rgb(237, 237, 237) solid; "
                                            class="card-header fw-bold text-primary">
                                            <strong> Hình ành minh chứng</strong>
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

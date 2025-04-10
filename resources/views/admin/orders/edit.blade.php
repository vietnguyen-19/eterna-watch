@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @php
                        $thongbao = session('thongbao');
                    @endphp
                    @if ($thongbao)
                        <div id="thongbao-alert"
                            class="alert alert-{{ $thongbao['type'] }} alert-dismissible bg-{{ $thongbao['type'] }} text-white alert-label-icon fade show"
                            role="alert">
                            <i class="ri-notification-off-line label-icon"></i>
                            <strong>{{ $thongbao['message'] }}</strong>
                        </div>
                        @php
                            session()->forget('thongbao');
                        @endphp
                    @endif

                    <div class="card" id="customerList">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <!-- Cột tiêu đề -->
                                <div class="col-6">
                                    <h5 class="card-title mb-0">Chi tiết đơn hàng | <b>{{ $order->order_code }}</b></h5>
                                </div>
                                <div class="col-6">
                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                        @csrf
                                        <div class="d-flex align-items-center justify-content-end gap-3">
                                            <select name="status" id="status" class="form-control form-select w-auto"
                                                required>
                                                @php
                                                    $statuses = [
                                                        'pending' => 'Chờ duyệt',
                                                        'confirmed' => 'Đã xác nhận',
                                                        'processing' => 'Đã giao bên vận chuyển',
                                                        'completed' => 'Hoàn thành',
                                                        'cancelled' => 'Đã hủy',
                                                    ];
                                                @endphp
                                                @foreach ($statuses as $key => $label)
                                                    <option value="{{ $key }}"
                                                        {{ old('status', $order->status) == $key ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-info ml-2">Cập nhật trạng thái</button>
                                        </div>
                                        @error('status')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row invoice-info">
                                <div class="col-sm-6 invoice-col">
                                    Trạng thái đơn hàng: <span class="badge bg-success">{{ $order->status }}</span><br>

                                    Phương thức thanh toán:
                                    <span class="badge bg-success">
                                        {{ optional($order->payment)->payment_method ?? 'Chưa có phương thức thanh toán' }}

                                    </span>

                                    | Trạng thái:
                                    {{-- <span
                                        class="badge bg-warning text-dark">{{ $order->payment->payment_status }}
                                    </span> --}}

                                    <span class="badge bg-warning text-dark">
                                        {{ optional($order->payment)->payment_status ?? 'Chưa thanh toán' }}
                                    </span>

                                    <br>

                                    Nhà vận chuyển: <b>968-34567</b><br>

                                    Giá trị đơn hàng:
                                    <b> <span
                                            class="text-primary fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }}
                                            VND</span></b><br>

                                    Ngày đặt hàng:
                                    <b><span
                                            class="text-info fw-bold">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</span></b><br>
                                </div>

                                <div class="col-sm-3 invoice-col">
                                    From
                                    <address>
                                        <strong>EternaWatch Shop.</strong><br>
                                        Số 8 Trịnh Văn Bô, Phương Canh<br>
                                        Q. Nam Từ Liên, Hà Nội<br>
                                        Phone: (084) 123.569.876<br>
                                        Email: eternawatchshop@gmail.com
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 invoice-col">
                                    To
                                    <address>
                                        <strong>{{ $order->user->name }}</strong><br>
                                        @php
                                            $address = $order->user->addresses->first();
                                        @endphp
                                        @if ($address)
                                            {{ $address->specific_address }},
                                            P.{{ $address->ward }}<br>
                                            Q. {{ $address->district }}, TP.{{ $address->city }} <br>
                                        @else
                                            <span class="text-danger">Chưa có địa chỉ</span>
                                        @endif

                                        Phone: {{ $order->user->phone }}<br>
                                        Email: {{ $order->user->email }}
                                    </address>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card" id="customerList">
                        
                    </div>
                    <div class="card" id="customerList">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0"><b>Lịch sử trạng thái đơn hàng</b></h5>
                        </div>
                        @php
                            if (!function_exists('getStatusColorClass')) {
                                function getStatusColorClass($status)
                                {
                                    $statusColors = [
                                        'pending' => 'badge bg-warning', // Màu vàng cho trạng thái pending
                                        'confirmed' => 'badge bg-info', // Màu xanh cho trạng thái confirmed
                                        'processing' => 'badge bg-primary', // Màu xanh đậm cho trạng thái processing
                                        'completed' => 'badge bg-success', // Màu xanh lá cho trạng thái completed
                                        'cancelled' => 'badge bg-danger', // Màu đỏ cho trạng thái cancelled
                                    ];

                                    return $statusColors[$status] ?? 'bg-secondary'; // Mặc định màu xám nếu không có trạng thái nào khớp
                                }
                            }
                        @endphp

                        <div class="card-body">
                            <div class="list-group">

                                @foreach ($statusHistories as $history)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <span
                                                class="badge {{ getStatusColorClass($history->new_status) }} fs-5 px-1 py-1">{{ $history->new_status }}</span>
                                            <div class="text-muted">
                                                {{ \Carbon\Carbon::parse($history->changed_at)->format('d-m-Y H:i:s') }}
                                            </div>
                                        </div>
                                        <div>
                                            <strong>{{ $history->user->name ?? 'Hệ thống' }}</strong>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge badge bg-warning fs-5 px-1 py-1">pending</span>
                                        <div class="text-muted">
                                            {{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i:s') }}</div>
                                    </div>
                                    <div>
                                        <b>Hệ thống</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="card" id="customerList">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0">Sản phẩm trong đơn hàng |
                                            <b>{{ $order->order_code }}</b>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <table class="table table-bordered display" id="danhmucTable">
                                <thead class="text-muted">
                                    <tr>
                                        <th style="width:5%" class="sort" data-sort="id">STT</th>
                                        <th class="sort" data-sort="ten_danh_muc">Ảnh sản phẩm</th>
                                        <th class="sort" data-sort="ten_danh_muc">Sản phẩm</th>
                                        <th class="sort" data-sort="mo_ta">Biến Thể</th>
                                        <th class="sort" data-sort="mo_ta">Giá</th>
                                        <th class="sort" data-sort="mo_ta">Số lượng</th>
                                        <th class="sort" data-sort="action">Tổng</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @php
                                        $subtotal = 0; // Tạm tính tổng giá trị đơn hàng chưa giảm giá
                                    @endphp

                                    @foreach ($order->orderItems as $item)
                                        @php
                                            $subtotal += $item->total_price;
                                        @endphp
                                        <tr>

                                            <td class="align-middle">{{ $loop->iteration }}</td>
                                            <td class="align-middle">
                                                <img src="{{ Storage::url($item->productVariant->product->avatar ?? 'default-avatar.png') }}"
                                                    alt="product Avatar" class="me-2" width="40" height="40">
                                            </td>

                                            <td class="align-middle">  
                                                <a href="{{ route('admin.products.show', $item->productVariant->product->id) }}" class="text-decoration-none ">
                                                    {{ $item->productVariant->product->name ?? 'N/A' }}

                                                </a>
                                            </td>

                                            
                                            <td>
                                                @foreach ($item->productVariant->attributeValues as $value)
                                                    <small>{{ $value->nameValue->attribute->attribute_name ?? 'Thuộc tính' }}:
                                                        {{ $value->nameValue->value_name ?? 'Không xác định' }}
                                                    </small><br>
                                                @endforeach
                                            </td>
                                            <td class="align-middle">
                                                {{ number_format($item->unit_price, 0, ',', '.') }}&nbsp; VND
                                            </td>
                                            <td class="align-middle">{{ $item->quantity }}</td>
                                            
                                            <td class="align-middle">
                                                {{ number_format($item->total_price, 0, ',', '.') }}&nbsp; VND
                                            </td>
                                        </tr>
                                    @endforeach

                                    {{-- Tính giảm giá nếu có voucher --}}
                                    @php
                                        $discountAmount = 0;
                                        if ($order->voucher) {
                                            if ($order->voucher->discount_type === 'percent') {
                                                $discountAmount = ($subtotal * $order->voucher->discount_value) / 100;
                                            } elseif ($order->voucher->discount_type === 'fixed') {
                                                $discountAmount = $order->voucher->discount_value;
                                            }

                                            // Đảm bảo giảm giá không vượt quá tổng tiền đơn hàng
                                            $discountAmount = min($discountAmount, $subtotal);
                                        }

                                        $totalPayment = $subtotal - $discountAmount; // Tổng tiền thanh toán sau khi giảm giá
                                    @endphp

                                    <tr>
                                        <th colspan="6" class="text-end">Tạm tính</th>
                                        <td class="text-end">{{ number_format($subtotal, 0, ',', '.') }}
                                            VND</td>
                                    </tr>

                                    @if ($order->voucher)
                                        <tr>
                                            <th colspan="6" class="text-end">Mã giảm giá</th>
                                            <td class="text-end"><span
                                                    class="badge bg-success">{{ $order->voucher->code }}</span></td>
                                        </tr>
                                        <tr>
                                            <th colspan="6" class="text-end">Giảm giá</th>
                                            <td class="text-end">-{{ number_format($discountAmount, 0, ',', '.') }}
                                                VND</td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <th colspan="6" class="text-end"><strong>Tổng thanh toán</strong></th>
                                        <td class="text-end text-danger">
                                            <strong>{{ number_format($totalPayment, 0, ',', '.') }} VND</strong>
                                        </td>
                                    </tr>
                                </tbody>


                            </table>

                        </div>

                    </div>
                </div>
            </div>

        </div>
        </div>
    </section>

    </div>
@endsection
@section('script-lib')
    <script src="http://chiccorner-project.test/theme/velzon/assets/libs/list.js/list.min.js"></script>
    <script src="http://chiccorner-project.test/theme/velzon/assets/libs/list.pagination.js/list.pagination.min.js">
    </script>
    <script src="{{ asset('theme/velzon/assets/libs/list.js/list.min.js') }}"></script>
    <script src="{{ asset('theme/velzon/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ asset('theme/velzon/assets/js/pages/ecommerce-customer-list.init.js') }}"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
@section('script')
    <script>
        // Tự động đóng thông báo sau 5 giây (5000ms)
        setTimeout(function() {
            var alert = document.getElementById('thongbao-alert');
            if (alert) {
                // Sử dụng Bootstrap để đóng alert
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 10000); // 5000ms = 5 giây
    </script>
@endsection
@section('style')
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />
    <style>
        .timeline {
            position: relative;
            padding: 20px 0;
            list-style-type: none;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }

        .timeline-icon {
            position: absolute;
            left: -10px;
            width: 20px;
            height: 20px;
            background-color: #007bff;
            /* Màu xanh cho biểu tượng */
            border-radius: 50%;
            top: 0;
        }

        .timeline-content {
            padding-left: 40px;
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 10px;
            border: 1px solid #ddd;
        }
    </style>
@endsection

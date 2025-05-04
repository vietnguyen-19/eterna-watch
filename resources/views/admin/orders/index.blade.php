@extends('admin.layouts.master')
@section('content')
    <!-- Modal dùng cho Edit và Reply -->
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <h5 class="card-title mb-0"><b>Danh sách đơn hàng</b></h5>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <a href="{{ route('admin.orders.trash') }}" class="btn btn-sm btn-danger">
                                            <i class="ri-delete-bin-line align-bottom me-1"></i> Thùng rác
                                        </a>
                                        <a href="{{ route('admin.orders.create') }}" class="btn btn-sm btn-primary">
                                            <i class="ri-add-line align-bottom me-1"></i> Tạo đơn thủ công
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Thêm vào phần card-body, trước bảng danh sách đơn hàng -->
                        <div class="card-body bg-light" style="border-bottom: 1px rgb(219, 219, 219) solid">
                            <div class="filter-form mb-4">
                                <form method="GET" action="{{ route('admin.orders.index') }}" id="filterForm">
                                    <div class="row g-3 align-items-end">
                                        <!-- Trạng thái đơn hàng -->
                                        <div class="col-md-2">
                                            <label for="status" class="form-label">Trạng thái đơn hàng</label>
                                            <select name="status" id="status" class="form-select">
                                                <option value="all">Tất cả</option>
                                                <option value="pending"
                                                    {{ request('status') == 'pending' ? 'selected' : '' }}>Đơn mới
                                                </option>
                                                <option value="confirmed"
                                                    {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác
                                                    nhận</option>
                                                <option value="processing"
                                                    {{ request('status') == 'processing' ? 'selected' : '' }}>Đang
                                                    chuẩn bị</option>
                                                <option value="completed"
                                                    {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn
                                                    thành</option>
                                                <option value="cancelled"
                                                    {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy
                                                </option>
                                            </select>
                                        </div>
                                        <!-- Phương thức thanh toán -->
                                        <div class="col-md-2">
                                            <label for="payment_method" class="form-label">Phương thức thanh toán</label>
                                            <select name="payment_method" id="payment_method" class="form-select">
                                                <option value="">Tất cả</option>
                                                <option value="cash"
                                                    {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Tiền mặt
                                                </option>

                                                <option value="vnpay"
                                                    {{ request('payment_method') == 'vnpay' ? 'selected' : '' }}>
                                                    Thanh toán VNPay</option>
                                            </select>
                                        </div>
                                        <!-- Trạng thái thanh toán -->
                                        <div class="col-md-2">
                                            <label for="payment_status" class="form-label">Trạng thái thanh toán</label>
                                            <select name="payment_status" id="payment_status" class="form-select">
                                                <option value="">Tất cả</option>
                                                <option value="pending"
                                                    {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Chờ xử
                                                    lý
                                                </option>
                                                <option value="completed"
                                                    {{ request('payment_status') == 'completed' ? 'selected' : '' }}>Hoàn
                                                    thành</option>
                                                <option value="failed"
                                                    {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Thất bại
                                                </option>
                                            </select>
                                        </div>

                                        <!-- Ngày đặt hàng -->
                                        <div class="col-md-2">
                                            <label for="date_from" class="form-label">Từ ngày</label>
                                            <input type="date" name="date_from" id="date_from" class="form-control"
                                                value="{{ request('date_from') }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="date_to" class="form-label">Đến ngày</label>
                                            <input type="date" name="date_to" id="date_to" class="form-control"
                                                value="{{ request('date_to') }}">
                                        </div>



                                        <!-- Nút hành động -->
                                        <div class="col-md-2 text-end">
                                            <button type="submit" class="btn btn-info me-2">Áp dụng lọc</button>
                                            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Xóa
                                                lọc</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Phần còn lại của Blade template giữ nguyên -->
                            <div class="tab-content">
                                <!-- Tabs trạng thái và bảng danh sách đơn hàng -->
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <!-- Tabs trạng thái đơn hàng -->
                                            <style>
                                                .nav-tabs-custom {
                                                    display: flex;
                                                    justify-content: space-between;
                                                    flex-wrap: wrap;
                                                }

                                                .nav-tabs-custom .nav-item {
                                                    flex: 1;
                                                    text-align: center;
                                                }

                                                .nav-tabs-custom .nav-link {
                                                    border: none;
                                                    border-radius: 0;
                                                    padding: 12px 0;
                                                    font-weight: 500;
                                                    transition: all 0.3s ease;
                                                }



                                                .nav-tabs-custom .nav-link.active {
                                                    background-color: #f0f0f0;
                                                    border-bottom: 3px solid #0d6efd;
                                                    color: #0d6efd;
                                                }

                                                .nav-tabs-custom .badge {
                                                    margin-left: 5px;
                                                    font-size: 12px;
                                                    vertical-align: middle;
                                                }
                                            </style>

                                            <ul class="nav nav-tabs nav-tabs-custom w-100">
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $status === 'all' ? 'active' : '' }}"
                                                        href="{{ route('admin.orders.index', ['status' => 'all']) }}">
                                                        Tất cả
                                                        <span
                                                            class="badge rounded-pill bg-dark">{{ $statusCounts['all'] }}</span>
                                                    </a>
                                                </li>

                                                
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $status === 'pending' ? 'active' : '' }}"
                                                        href="{{ route('admin.orders.index', ['status' => 'pending']) }}">
                                                        Đơn mới
                                                        <span
                                                            class="badge rounded-pill bg-danger text-dark">{{ $statusCounts['pending'] }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $status === 'confirmed' ? 'active' : '' }}"
                                                        href="{{ route('admin.orders.index', ['status' => 'confirmed']) }}">
                                                        Đã xác nhận
                                                        <span
                                                            class="badge rounded-pill bg-warning text-dark">{{ $statusCounts['confirmed'] }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $status === 'processing' ? 'active' : '' }}"
                                                        href="{{ route('admin.orders.index', ['status' => 'processing']) }}">
                                                        Đang chuẩn bị
                                                        <span
                                                            class="badge rounded-pill bg-primary">{{ $statusCounts['processing'] }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $status === 'completed' ? 'active' : '' }}"
                                                        href="{{ route('admin.orders.index', ['status' => 'completed']) }}">
                                                        Hoàn thành
                                                        <span
                                                            class="badge rounded-pill bg-success">{{ $statusCounts['completed'] }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $status === 'cancelled' ? 'active' : '' }}"
                                                        href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}">
                                                        Đã hủy
                                                        <span
                                                            class="badge rounded-pill bg-danger">{{ $statusCounts['cancelled'] }}</span>
                                                    </a>
                                                </li>
                                            </ul>


                                            <!-- Bảng danh sách đơn hàng -->
                                            <div class="table-responsive mt-4">
                                                <table class="table table-bordered" id="orderTable{{ $status }}">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 4%">
                                                                <input type="checkbox" id="checkAll"
                                                                    class="align-middle">
                                                            </th>
                                                            <th>ID</th>
                                                            <th style="width: 15%;">Mã đơn hàng</th>
                                                            <th style="width: 10%;">Khách hàng</th>
                                                            <th style="width: 8%;">Tổng tiền</th>
                                                            <th style="width: 10%;">PT thanh toán</th>
                                                            <th style="width: 12%;">TT đơn hàng</th>
                                                            <th style="width: 12%;">TT thanh toán</th>
                                                            <th style="width: 15%;">Ngày tạo</th>
                                                            <th style="width: 8%;">Hành động</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($orders as $order)
                                                            <tr>
                                                                <td class="align-middle">
                                                                    <input type="checkbox" class="checkbox-item"
                                                                        value="{{ $order->id }}">
                                                                </td>
                                                                <td class="align-middle">{{ $order->id }}</td>
                                                                <td class="align-middle">
                                                                    <strong>{{ $order->order_code }}</strong>
                                                                </td>
                                                                <td class="align-middle">
                                                                    {{ $order->user->name ?? 'Khách vãng lai' }}</td>
                                                                <td class="align-middle">
                                                                    {{ number_format($order->total_amount, 0, ',', '.') }}
                                                                    đ</td>
                                                                <td class="align-middle">
                                                                    @if ($order->payment_method === 'cash')
                                                                        Tiền mặt
                                                                    @elseif ($order->payment_method === 'vnpay')
                                                                        VNPay
                                                                    @endif
                                                                </td>

                                                                <td class="align-middle">
                                                                    @switch($order->status)
                                                                        @case('pending')
                                                                            <span class="badge bg-warning-subtle text-warning">Chỡ
                                                                                xác nhận</span>
                                                                        @break

                                                                        @case('confirmed')
                                                                            <span class="badge bg-primary-subtle text-info">Đã xác
                                                                                nhận</span>
                                                                        @break

                                                                        @case('processing')
                                                                            <span class="badge bg-primary-subtle text-primary">Đã
                                                                                giao bên vận chuyển</span>
                                                                        @break

                                                                        @case('completed')
                                                                            <span
                                                                                class="badge bg-success-subtle  text-success">Hoàn
                                                                                thành</span>
                                                                        @break

                                                                        @case('cancelled')
                                                                            <span class="badge bg-danger text-danger"-subtle>Đã
                                                                                hủy</span>
                                                                        @break

                                                                        @default
                                                                            <span class="badge bg-secondary  text-dark">Không xác
                                                                                định</span>
                                                                    @endswitch
                                                                </td>
                                                                <td class="align-middle">
                                                                    @switch($order->payment->payment_status)
                                                                        @case('pending')
                                                                            <span class="badge bg-warning-subtle text-warning">Chờ
                                                                                xử
                                                                                lý</span>
                                                                        @break

                                                                        @case('completed')
                                                                            <span
                                                                                class="badge bg-success-subtle  text-success">Hoàn
                                                                                thành</span>
                                                                        @break

                                                                        @case('failed')
                                                                            <span class="badge bg-danger text-danger"-subtle>Thất
                                                                                bại</span>
                                                                        @break

                                                                        @default
                                                                            <span class="badge bg-secondary text-dark">Không xác
                                                                                định</span>
                                                                    @endswitch
                                                                </td>
                                                                <td class="align-middle">
                                                                    {{ $order->created_at->format('d/m/Y H:i') }}</td>
                                                                <td class="align-middle">
                                                                    <div class="btn">
                                                                        <a href="{{ route('admin.orders.edit', $order->id) }}"
                                                                            class="btn btn-info btn-sm"
                                                                            title="Xem chi tiết">
                                                                            <i class="fas fa-eye"></i>
                                                                        </a>
                                                                        <form
                                                                            action="{{ route('admin.orders.destroy', $order->id) }}"
                                                                            method="POST" class="d-inline-block">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-danger btn-sm"
                                                                                title="Xóa đơn hàng"
                                                                                onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');">
                                                                                <i class="fas fa-trash-alt"></i>
                                                                            </button>
                                                                        </form>
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="8" class="text-center">Không có đơn hàng
                                                                        nào
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                        
                                                    </table>
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
    @section('style')
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            .nav-tabs-custom .nav-item .nav-link.active {
                background-color: #007bff;
                color: white !important;
                border-radius: 4px;
                font-weight: bold;
            }

            .nav-tabs-custom .nav-item .nav-link {
                color: #007bff;
                transition: background-color 0.3s;
            }

            .nav-tabs-custom .nav-item .nav-link:hover {
                background-color: #e9ecef;
            }

            .btn.btn-outline-info:hover {
                color: #fff;
                /* Màu chữ khi hover */
                background-color: #464d4e;
                /* Màu nền khi hover */
                border-color: #17a2b8;
                /* Màu viền khi hover */
            }
        </style>
        <style>
            .avatar-xs {
                height: 2.2rem;
                width: 2.2rem;
            }

            .bg-success-subtle {
                background-color: rgba(10, 179, 156, .1);
            }

            .bg-danger-subtle {
                background-color: rgba(240, 101, 72, .1);
            }

            .bg-warning-subtle {
                background-color: rgba(247, 184, 75, .1);
            }

            .bg-primary-subtle {
                background-color: rgba(64, 81, 137, .1);
            }

            .bg-secondary-subtle {
                background-color: rgba(116, 120, 141, .1);
            }

            .bg-dark-subtle {
                background-color: rgba(33, 37, 41, .1);
            }
        </style>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    @endsection
    @section('script')
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
        <!-- Bootstrap CSS -->
        <!-- Bootstrap CSS -->

        <!-- Bootstrap JS + Popper -->
        <script></script>
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script>
            // Mảng chứa các ID của các bảng cần áp dụng DataTable
            var tableIds = [
                'orderTableall',
                'orderTablepending',
                'orderTableprocessing',
                'orderTableconfirmed',
                'orderTablecompleted',
                'orderTablecancelled',
            ];

            // Lặp qua từng ID và áp dụng DataTable
            tableIds.forEach(function(tableId) {
                var $table = $('#' + tableId);

                // Kiểm tra bảng có tồn tại không
                if ($table.length) {
                    // Lấy số cột từ phần thead
                    var thCount = $table.find('thead th').length;
                    var isValid = true;

                    // Kiểm tra các dòng trong tbody có đúng số lượng cột không
                    $table.find('tbody tr').each(function() {
                        if ($(this).find('td').length !== thCount) {
                            isValid = false;
                        }
                    });

                    // Nếu số cột hợp lệ thì áp dụng DataTable
                    if (isValid) {
                        $table.DataTable({
                            paging: true,
                            lengthMenu: [10, 20, 50],
                            searching: true,
                            ordering: true,
                            info: true,
                            language: {
                                lengthMenu: "Hiển thị _MENU_ dòng",
                                zeroRecords: "Không tìm thấy dữ liệu",
                                info: "Đang hiển thị _START_ đến _END_ của _TOTAL_ mục",
                                infoEmpty: "Không có dữ liệu",
                                search: "Tìm kiếm:",
                                paginate: {
                                    first: "Trang đầu",
                                    last: "Trang cuối",
                                    next: "Sau",
                                    previous: "Trước"
                                }
                            }
                        });
                    } else {
                        console.warn(`❌ Bảng ${tableId} có số cột <td> không khớp với <th>, bỏ qua DataTables.`);
                    }
                }
            });
        </script>
    @endsection

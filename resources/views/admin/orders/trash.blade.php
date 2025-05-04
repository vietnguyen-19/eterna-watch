@extends('admin.layouts.master')
@section('content')
    <!-- Modal dùng cho Edit và Reply -->
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if (session('success'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Khôi phục đơn hàng thành công',
                                text: '{{ session('success') }}',
                                confirmButtonText: 'OK',
                                timer: 3000
                            });
                        </script>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0"><b>Danh sách đơn hàng đã xóa</b></h5>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap align-items-start gap-2">
                                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary add-btn"><i
                                                class="ri-add-line align-bottom me-1"></i>Quay lại danh sách</a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card-body">
                            <div class="tab-content">
                                <div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <!-- Tabs trạng thái đơn hàng -->

                                            <!-- Bảng danh sách đơn hàng -->
                                            <div class="table-responsive mt-4">
                                                <table class="table table-bordered" id="orderTable{{ $status }}">
                                                    <thead>
                                                        <tr>

                                                            <th>ID</th>
                                                            <th>Mã đơn hàng</th>
                                                            <th>Khách hàng</th>
                                                            <th style="width: 15%;">Tổng tiền</th>
                                                            <th style="width: 12%;">Trạng thái</th>
                                                            <th style="width: 15%;">Ngày tạo</th>
                                                            <th style="width: 15%;">Ngày xóa</th>
                                                            <th style="width: 15%;">Hành động</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @forelse($orders as $order)
                                                            <tr>

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
                                                                    @switch($order->status)
                                                                        @case('pending')
                                                                            <span class="badge bg-warning text-dark">Chờ xử
                                                                                lý</span>
                                                                        @break

                                                                        @case('processing')
                                                                            <span class="badge bg-primary">Đang xử lý</span>
                                                                        @break

                                                                        @case('completed')
                                                                            <span class="badge bg-success">Hoàn thành</span>
                                                                        @break

                                                                        @case('cancelled')
                                                                            <span class="badge bg-danger">Đã hủy</span>
                                                                        @break

                                                                        @default
                                                                            <span class="badge bg-secondary">Không xác định</span>
                                                                    @endswitch
                                                                </td>
                                                                <td class="align-middle">
                                                                    {{ $order->created_at->format('d/m/Y H:i') }}</td>
                                                                <td class="align-middle">
                                                                    {{ $order->updated_at->format('d/m/Y H:i') }}</td>
                                                                <td class="align-middle">
                                                                    <div class="btn">
                                                                        <form
                                                                            action="{{ route('admin.orders.restore', $order->id) }}"
                                                                            method="POST" class="d-inline-block">
                                                                            @csrf
                                                                            <button type="submit"
                                                                                class="btn btn-info btn-sm"
                                                                                title="Khôi phục">
                                                                                <i class="fas fa-rotate-left"></i>
                                                                            </button>
                                                                        </form>

                                                                        <form
                                                                            action="{{ route('admin.orders.forceDelete', $order->id) }}"
                                                                            method="POST" class="d-inline-block">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-danger btn-sm"
                                                                                onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');"
                                                                                title="Xóa vĩnh viễn">
                                                                                <i class="fas fa-trash-alt"></i>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="7" class="text-center">Không có đơn hàng nào
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

        <!-- Bootstrap CSS -->
        <!-- Bootstrap CSS -->

        <!-- Bootstrap JS + Popper -->
        <script></script>
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script>
            tableIds.forEach(function(tableId) {
                var $table = $('#' + tableId);

                if ($table.length) {
                    var thCount = $table.find('thead th').length;
                    var valid = true;

                    $table.find('tbody tr').each(function() {
                        if ($(this).find('td').length !== thCount) {
                            valid = false;
                        }
                    });

                    if (valid) {
                        $table.DataTable({
                            paging: true,
                            lengthMenu: [10, 20, 50],
                            searching: true,
                            ordering: true,
                            info: true,
                            language: {
                                lengthMenu: "Hiển thị _MENU_ dòng",
                                zeroRecords: "Không tìm thấy dữ liệu",
                                info: "Đang hiển thị  _START_  đến  _END_  của  _TOTAL_  mục",
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
                        console.warn(`❌ Bảng ${tableId} có số cột <td> không khớp với <th>, bỏ qua DataTables`);
                    }
                }
            });
        </script>

        <script>
            // Tự động đóng thông báo sau 5 giây (5000ms)
            setTimeout(function() {
                var alert = document.getElementById('thongbao-alert');
                if (alert) {
                    // Sử dụng Bootstrap để đóng alert
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000); // 5000ms = 5 giây
        </script>
    @endsection

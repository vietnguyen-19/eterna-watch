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
                                    <h5 class="card-title mb-0"><b>Danh sách yêu cầu hoàn hàng</b></h5>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <a href="{{ route('admin.orders.trash') }}" class="btn btn-danger">
                                            <i class="ri-delete-bin-line align-bottom me-1"></i> Thùng rác
                                        </a>
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
                                                        href="{{ route('admin.refunds.index', ['status' => 'all']) }}">
                                                        Tất cả
                                                        <span
                                                            class="badge rounded-pill bg-dark">{{ $statusCounts['all'] }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $status === 'pending' ? 'active' : '' }}"
                                                        href="{{ route('admin.refunds.index', ['status' => 'pending']) }}">
                                                        Đang chờ duyệt
                                                        <span
                                                            class="badge rounded-pill bg-warning text-dark">{{ $statusCounts['pending'] }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $status === 'approved' ? 'active' : '' }}"
                                                        href="{{ route('admin.refunds.index', ['status' => 'approved']) }}">
                                                        Chấp nhận
                                                        <span
                                                            class="badge rounded-pill bg-success text-dark">{{ $statusCounts['approved'] }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $status === 'rejected' ? 'active' : '' }}"
                                                        href="{{ route('admin.refunds.index', ['status' => 'rejected']) }}">
                                                        Từ chối
                                                        <span
                                                            class="badge rounded-pill bg-danger">{{ $statusCounts['rejected'] }}</span>
                                                    </a>
                                                </li>

                                            </ul>


                                            <!-- Bảng danh sách đơn hàng -->
                                            <div class="table-responsive mt-4">
                                                <table class="table table-bordered" id="orderTable{{ $status }}">
                                                    <thead>
                                                        <tr>
                                                            <th>#ID</th>
                                                            <th>Khách hàng</th>
                                                            <th>Đơn hàng</th>
                                                            <th>Tổng tiền hoàn</th>
                                                            <th>Trạng thái</th>
                                                            <th>Hành động</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($refunds as $refund)
                                                            <tr>
                                                                <td>{{ $refund->id }}</td>
                                                                <td>{{ $refund->order->user->name }}</td>
                                                                <td>
                                                                    <a href="{{ route('admin.orders.edit', $refund->order->id) }}">
                                                                        {{ $refund->order->order_code }}
                                                                    </a>
                                                                </td>
                                                                
                                                                <td>{{ number_format($refund->total_refund_amount) }}đ
                                                                </td>
                                                                <td>
                                                                    @if ($refund->status == 'pending')
                                                                        <span class="badge bg-warning text-dark">Đang chờ duyệt</span>
                                                                    @elseif ($refund->status == 'approved')
                                                                        <span class="badge bg-success">Đã duyệt</span>
                                                                    @else
                                                                        <span class="badge bg-danger">Bị từ chối</span>
                                                                    @endif
                                                                </td>
                                                                
                                                                <td>
                                                                    <div class="list-inline-item edit" title="Xem chi tiết sản phẩm">
                                                                        <a href="{{ route('admin.refunds.show', $refund) }}"
                                                                            class="btn btn-info btn-icon waves-effect waves-light btn-sm">
                                                                            <i class="fas fa-eye"></i>
                                                                        </a>
                                                                    </div>
                                                                   
                                                                </td>
                                                            </tr>

                                                        @empty
                                                            <tr>
                                                                <td colspan="8" class="text-center">Không có đơn hàng nào
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

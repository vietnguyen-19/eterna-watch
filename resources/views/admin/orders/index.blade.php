@extends('admin.layouts.master')
@section('content')
    <!-- Modal dùng cho Edit và Reply -->
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if (session('thongbao'))
                        <div id="thongbao-alert"
                            class="alert alert-{{ session('thongbao.type') }} alert-dismissible bg-{{ session('thongbao.type') }} text-white alert-label-icon fade show"
                            role="alert">
                            <i class="ri-notification-off-line label-icon"></i><strong>
                                {{ session('thongbao.message') }}</strong>

                        </div>
                        @php
                            session()->forget('thongbao');
                        @endphp
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0"><b>Danh sách đơn hàng</b></h5>
                                    </div>
                                </div>
                                {{-- <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap align-items-start gap-2">
                                        <a href="{{ route('admin.orders.create') }}" class="btn btn-success add-btn"><i
                                                class="ri-add-line align-bottom me-1"></i>Thêm đơn hàng mới</a>
                                    </div>
                                </div> --}}
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
                                                        <span class="badge rounded-pill bg-dark">{{ $statusCounts['all'] }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $status === 'pending' ? 'active' : '' }}"
                                                        href="{{ route('admin.orders.index', ['status' => 'pending']) }}">
                                                        Đơn mới
                                                        <span class="badge rounded-pill bg-danger text-dark">{{ $statusCounts['pending'] }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $status === 'confirmed' ? 'active' : '' }}"
                                                        href="{{ route('admin.orders.index', ['status' => 'confirmed']) }}">
                                                        Đã xác nhận
                                                        <span class="badge rounded-pill bg-warning text-dark">{{ $statusCounts['confirmed'] }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $status === 'processing' ? 'active' : '' }}"
                                                        href="{{ route('admin.orders.index', ['status' => 'processing']) }}">
                                                        Đang chuẩn bị
                                                        <span class="badge rounded-pill bg-primary">{{ $statusCounts['processing'] }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $status === 'completed' ? 'active' : '' }}"
                                                        href="{{ route('admin.orders.index', ['status' => 'completed']) }}">
                                                        Hoàn thành
                                                        <span class="badge rounded-pill bg-success">{{ $statusCounts['completed'] }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $status === 'cancelled' ? 'active' : '' }}"
                                                        href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}">
                                                        Đã hủy
                                                        <span class="badge rounded-pill bg-danger">{{ $statusCounts['cancelled'] }}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            

                                            <!-- Bảng danh sách đơn hàng -->
                                            <div class="table-responsive mt-4">
                                                <table class="table table-bordered" id="orderTable{{ $status }}">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 4%">
                                                                <input type="checkbox" id="checkAll" class="align-middle">
                                                            </th>
                                                            <th>ID</th>
                                                            <th>Mã đơn hàng</th>
                                                            <th>Khách hàng</th>
                                                            <th style="width: 15%;">Tổng tiền</th>
                                                            <th style="width: 12%;">Trạng thái</th>
                                                            <th style="width: 15%;">Ngày tạo</th>
                                                            <th style="width: 15%;">Hành động</th>
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
                                                                    <div class="btn-group">
                                                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                                                            class="btn btn-info btn-sm">
                                                                            Chi tiết
                                                                        </a>
                                                                        <a href="{{ route('admin.orders.edit', $order->id) }}"
                                                                            class="btn btn-dark btn-sm">
                                                                            Sửa
                                                                        </a>
                                                                        <form
                                                                            action="{{ route('admin.orders.destroy', $order->id) }}"
                                                                            method="POST" class="d-inline-block">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-danger btn-sm"
                                                                                onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');">
                                                                                Xóa
                                                                            </button>
                                                                        </form>
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
                                                        <tfoot>
                                                            <tr>
                                                                <th></th>
                                                                <th>ID</th>
                                                                <th>Mã đơn hàng</th>
                                                                <th>Khách hàng</th>
                                                                <th>Tổng tiền</th>
                                                                <th>Trạng thái</th>
                                                                <th>Ngày tạo</th>
                                                                <th>Hành động</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="card-header">
                                <button class="btn btn-danger" id="deleteSelected">Xóa đã chọn</button>
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
                $('#' + tableId).DataTable({
                    "paging": true,
                    "lengthMenu": [10, 20, 50],
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "language": {
                        "lengthMenu": "Hiển thị _MENU_ dòng",
                        "zeroRecords": "Không tìm thấy dữ liệu",
                        "info": "Đang hiển thị  _START_  đến  _END_  của  _TOTAL_  mục",
                        "infoEmpty": "Không có dữ liệu",
                        "search": "Tìm kiếm:",
                        "paginate": {
                            "first": "Trang đầu",
                            "last": "Trang cuối",
                            "next": "Sau",
                            "previous": "Trước"
                        }
                    }
                });
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

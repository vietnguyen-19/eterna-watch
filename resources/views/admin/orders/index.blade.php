@extends('admin.layouts.master')
@section('content')
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
                                        <h1 class="card-title mb-0">Danh sách Đơn Hàng </h1>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    {{-- <div class="d-flex flex-wrap align-items-start gap-2">
                                        <a href="{{ route('admin.orders.create') }}" class="btn btn-success add-btn"><i
                                                class="ri-add-line align-bottom me-1"></i>Thêm đơn hàng mới</a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-4">
                                            <div class="row g-2 align-items-center">
                                                <div class="col-auto">
                                                    <label for="">Lọc theo trang thái : </label>
                                                    <select name="status" class="form-select"
                                                        onchange="this.form.submit()">
                                                        <option value="">-- Tất cả trạng thái --
                                                        </option>
                                                        @foreach (['pending', 'confirmed', 'processing', 'completed', 'cancelled'] as $status)
                                                            <option value="{{ $status }}"
                                                                {{ request('status') === $status ? 'selected' : '' }}>
                                                                {{ ucfirst($status) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @if (request('status'))
                                                    <div class="col-auto">
                                                        <a href="{{ route('admin.orders.index') }}"
                                                            class="btn btn-secondary btn-sm">Xóa lọc</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-sm-12 col-md-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <!-- Tabs trạng thái đơn hàng -->
                                        <ul class="nav nav-tabs nav-tabs-custom">
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
                                        <table class="table table-bordered" aria-describedby="example2_info" >

                                            <thead class="text-muted">
                                                <tr>
                                                    <th class="" >ID</th>
                                                    <th class="" >Mã đơn hàng</th>
                                                    <th class="" ">Khách hàng</th>
                                                    <th class="" >Tổng tiền</th>
                                                    <th class="" >Trang thái</th>
                                                    <th class="" > Ngày đặt</th>
                                                    <th class="" >Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list form-check-all">
                                                @foreach ($orders as $item)
                                                    <tr>

                                                        <td class="id">{{ $item->id }}</td>
                                                        <td class="align-middle">
                                                            <strong>{{ $item->order_code }}</strong>
                                                        </td>
                                                        <td class="ten_user">
                                                            {{ $item->user->name ?? 'Khách vãng lai' }}
                                                        </td>
                                                        <td class="tong_tien">
                                                            {{ number_format($item->total_amount, 0, ',', '.') }}Đ
                                                        </td>

                                                        <td class="align-middle">
                                                            @switch($item->status)
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


                                                        <td class="created_at"> {{ $item->created_at->format('d/m/Y') }}
                                                        </td>

                                                        <td class="align-middle">
                                                            <div class="btn-group">
                                                                <a href="{{ route('admin.orders.show', $item->id) }}"
                                                                    class="btn btn-info btn-sm">
                                                                    Chi tiết
                                                                </a>
                                                                <a href="{{ route('admin.orders.edit', $item->id) }}"
                                                                    class="btn btn-dark btn-sm">
                                                                    Sửa
                                                                </a>
                                                                {{-- <form
                                                                    action="{{ route('admin.orders.destroy', $item->id) }}"
                                                                    method="POST" class="d-inline-block">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');">
                                                                        Xóa
                                                                    </button>
                                                                </form> --}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            {{-- <thead class="text-muted">
                                                <tr>
                                                    <th class="sort" data-sort="id">ID</th>
                                                    <th class="sort" data-sort="order_code">Mã đơn hàng</th>
                                                    <th class="sort" data-sort="ten_user">Khách hàng</th>
                                                    <th class="sort" data-sort="tong_tien">Tổng tiền</th>
                                                    <th class="sort" data-sort="trang_thai">Trang thái</th>
                                                    <th class="sort" data-sort="created_at"> Ngày đặt</th>
                                                    <th class="sort" data-sort="hanh_dong">Hành động</th>
                                                </tr>
                                            </thead> --}}
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        $(document).ready(function() {
            $('#danhmucTable').DataTable({
                "paging": true, // Bật phân trang
                "lengthMenu": [10, 20, 50], // Số dòng hiển thị mỗi trang
                "searching": true, // Bật ô tìm kiếm
                "ordering": true, // Bật sắp xếp cột
                "info": true, // Hiển thị thông tin tổng số dòng
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
@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

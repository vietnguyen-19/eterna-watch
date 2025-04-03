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
                                        <h5 class="card-title mb-0">Danh sách Đơn Hàng </h5>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap align-items-start gap-2">
                                        <a href="{{ route('admin.orders.create') }}" class="btn btn-success add-btn"><i
                                                class="ri-add-line align-bottom me-1"></i>Thêm đơn hàng mới</a>
                                    </div>
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

                                        <table class="table table-bordered" aria-describedby="example2_info"
                                            id="danhmucTable">

                                            <thead class="text-muted">
                                                <tr>
                                                    <th style="width: 4%">
                                                        <input type="checkbox" id="checkAll" class="align-middle">
                                                    </th>
                                                    <th class="sort" data-sort="id">ID</th>
                                                    <th class="sort" data-sort="ten_user">Mã đơn hàng</th>
                                                    <th class="sort" data-sort="ten_user">Khách hàng</th>
                                                    <th class="sort" data-sort="tong_tien">Tổng tiền</th>
                                                    <th class="sort" data-sort="trang_thai">Trang thái</th>
                                                    <th class="sort" data-sort="created_at"> Ngày đặt</th>
                                                    <th class="sort" data-sort="hanh_dong">Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list form-check-all">
                                                @foreach ($data as $item)
                                                    <tr>
                                                        <td class="align-middle">
                                                            <input type="checkbox" class="checkbox-item"
                                                                value="{{ $item->id }}">
                                                        </td>
                                                        <td class="id">{{ $item->id }}</td>
                                                        <td class="align-middle">
                                                            <strong>{{ $order->order_code }}</strong>
                                                        </td>
                                                        <td class="ten_user">
                                                            {{ $item->user->name ?? 'Khách vãng lai' }}
                                                        </td>
                                                        <td class="tong_tien">
                                                            {{ number_format($item->total_amount, 0, ',', '.') }}Đ
                                                        </td>

                                                        <td class="trang_thai">
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
                                                        </td>
                                                        <td class="created_at"> {{ $item->created_at->format('d/m/Y') }}
                                                        </td>

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
                                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');">
                                                                        Xóa
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <thead class="text-muted">
                                                <tr>
                                                    <th style="width: 4%">
                                                        <input type="checkbox" id="checkAll" class="align-middle">
                                                    </th>
                                                    <th class="sort" data-sort="id">ID</th>
                                                    <th class="sort" data-sort="ten_user">Mã đơn hàng</th>
                                                    <th class="sort" data-sort="ten_user">Khách hàng</th>
                                                    <th class="sort" data-sort="tong_tien">Tổng tiền</th>
                                                    <th class="sort" data-sort="trang_thai">Trang thái</th>
                                                    <th class="sort" data-sort="created_at"> Ngày đặt</th>
                                                    <th class="sort" data-sort="hanh_dong">Hành động</th>
                                                </tr>
                                            </thead>
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

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#danhmucTable').DataTable({
                "paging": true, // Bật phân trang
                "lengthMenu": [5, 20, 50], // Số dòng hiển thị mỗi trang
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

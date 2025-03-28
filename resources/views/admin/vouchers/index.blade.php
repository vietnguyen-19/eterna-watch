@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @if (session('thongbao'))
                        <div id="thongbao-alert" class="alert alert-{{ session('thongbao.type') }} alert-dismissible bg-{{ session('thongbao.type') }} text-white alert-label-icon fade show" role="alert">
                            <i class="ri-notification-off-line label-icon"></i><strong>{{ session('thongbao.message') }}</strong>
                        </div>
                        @php session()->forget('thongbao'); @endphp
                    @endif

                    <div class="card" id="voucherList">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <h5 class="card-title mb-0">Danh sách Voucher</h5>
                                </div>
                                <div class="col-sm-auto">
                                    <a href="{{ route('admin.vouchers.trash') }}" class="btn btn-warning me-2">
                                        <i class="ri-delete-bin-line align-bottom me-1"></i> Thùng rác
                                    </a>
                                    <a href="{{ route('admin.vouchers.create') }}" class="btn btn-success add-btn">
                                        <i class="ri-add-line align-bottom me-1"></i>Thêm mới Voucher
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive table-card mb-1 mt-2">
                                <table class="table table-bordered display" id="voucherTable">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên Voucher</th>
                                            <th>Mã Code</th>
                                            <th>Loại Giảm Giá</th>
                                            <th>Giá Trị</th>
                                            <th>Đơn Hàng Tối Thiểu</th>
                                            <th>Số Lần Dùng Tối Đa</th>
                                            <th>Đã Dùng</th>
                                            <th>Ngày Bắt Đầu</th>
                                            <th>Hạn Sử Dụng</th>
                                            <th>Trạng Thái</th>
                                            <th>Hành Động</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($vouchers as $voucher)
                                            <tr>
                                                <td>{{ $voucher->id }}</td>
                                                <td>{{ $voucher->name }}</td>
                                                <td>{{ $voucher->code }}</td>
                                                <td>{{ $voucher->discount_type == 'percent' ? 'Phần trăm' : 'Tiền mặt' }}</td>
                                                <td>
                                                    @if($voucher->discount_type == 'percent')
                                                        {{ $voucher->discount_value }}%
                                                    @else
                                                        {{ number_format($voucher->discount_value, 0, ',', '.') }} đ
                                                    @endif
                                                </td>
                                                <td>{{ $voucher->min_order ? number_format($voucher->min_order, 0, ',', '.') . ' đ' : 'Không' }}</td>
                                                <td>{{ $voucher->max_uses ?? 'Không giới hạn' }}</td>
                                                <td>{{ $voucher->used_count }}</td>
                                                <td>{{ $voucher->start_date ? date('d/m/Y H:i', strtotime($voucher->start_date)) : 'Chưa áp dụng' }}</td>
                                                <td>{{ $voucher->expires_at ? date('d/m/Y H:i', strtotime($voucher->expires_at)) : 'Không hạn' }}</td>
                                                <td>
                                                    <span class="badge {{ $voucher->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ ucfirst($voucher->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="btn btn-warning btn-sm">
                                                        <i class="fa-solid fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
            $('#voucherTable').DataTable({
                "paging": true,
                "lengthMenu": [5, 10, 20, 50],
                "searching": true,
                "ordering": true,
                "info": true,
                "language": {
                    "lengthMenu": "Hiển thị _MENU_ dòng",
                    "zeroRecords": "Không tìm thấy dữ liệu",
                    "info": "Đang hiển thị _START_ đến _END_ của _TOTAL_ mục",
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
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    </script>
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

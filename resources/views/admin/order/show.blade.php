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
                                        <h5 class="card-title mb-0">Chi Tiết Đơn Hàng </h5>
                                    </div>
                                </div>
                                <div class="col-sm-auto">

                                </div>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">

                                    </div>
                                    <div class="col-sm-12 col-md-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h3 class="mb-4">Chi tiết đơn hàng #{{ $order->id }}</h3>

                                        <div class="mb-4">
                                            <div class="card-header fw-bold">
                                                Thông tin khách hàng
                                            </div>
                                            <p><strong>Khách hàng:</strong> {{ $order->user->name ?? 'Khách ẩn danh' }}</p>
                                            <p><strong>Trạng thái:</strong> <span
                                                    class="badge bg-success">{{ ucfirst($order->status) }}</span></p>
                                            <p><strong>Địa chỉ:</strong>
                                                {{ $order->shippingAddress->street_address ?? 'N/A' }}</p>
                                            <p><strong>Số điện thoại:</strong>
                                                {{ $order->shippingAddress->phone ?? 'N/A' }}</p>
                                            <!-- Form đổi trạng thái -->
                                            <form id="statusForm" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <label for="status">Thay đổi trạng thái:</label>
                                                <select name="status" class="form-select w-auto d-inline"
                                                    onchange="submitStatusForm(this.value)">
                                                    <option disabled selected>Chọn trạng thái</option>
                                                    @php
                                                        $next = [
                                                            'pending' => ['confirmed'],
                                                            'confirmed' => ['processing'],
                                                            'processing' => ['completed'],
                                                            'completed' => [],
                                                            'cancelled' => [],
                                                        ];
                                                    @endphp
                                                    @foreach ($next[$order->status] ?? [] as $status)
                                                        <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </div>

                                        <table class="table table-bordered" aria-describedby="example2_info"
                                            id="danhmucTable">
                                            <h4>Sản phẩm trong đơn</h4>
                                            <thead class="text-muted">
                                                <tr>
                                                    <th class="sort" data-sort="id">Tên Sản phẩm</th>
                                                    <th class="sort" data-sort="ten_user">Biến THể</th>
                                                    <th class="sort" data-sort="tong_tien">Đơn Giá </th>
                                                    <th class="sort" data-sort="trang_thai">Số Lượng</th>
                                                    <th class="sort" data-sort="created_at"> Thành Tiền</th>
                                                    {{-- <th class="sort" data-sort="hanh_dong">Hành động</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody class="list form-check-all">

                                                @foreach ($order->orderItems as $item)
                                                    <tr>
                                                        <td>{{ $item->productVariant->product->name ?? 'N/A' }}</td>
                                                        <td>{{ $item->productVariant->name ?? 'N/A' }}</td>
                                                        <td>{{ number_format($item->unit_price, 0, ',', '.') }} đ</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>{{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}
                                                            đ</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" class="text-end fw-bold">Tổng tiền:</td>
                                                    <td class="fw-bold text-danger">
                                                        {{ number_format($order->orderItems->sum(fn($item) => $item->unit_price * $item->quantity), 0, ',', '.') }}
                                                        đ
                                                    </td>
                                                </tr>
                                            </tfoot>
                                            <thead class="text-muted">
                                                <tr>
                                                    <th class="sort" data-sort="id">Tên Sản phẩm</th>
                                                    <th class="sort" data-sort="ten_user">Biến THể</th>
                                                    <th class="sort" data-sort="tong_tien">Đơn Giá </th>
                                                    <th class="sort" data-sort="trang_thai">Số Lượng</th>
                                                    <th class="sort" data-sort="created_at"> Thành Tiền</th>
                                                    {{-- <th class="sort" data-sort="hanh_dong">Hành động</th> --}}
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

    <script>
        function submitStatusForm(status) {
            if (confirm('Bạn có chắc muốn cập nhật trạng thái?')) {
                fetch('{{ route('admin.orders.update', $order->id) }}', {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            status
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status) {
                            alert(data.message);
                            location.reload();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(err => {
                        alert('Lỗi cập nhật trạng thái!');
                        console.error(err);
                    });
            }
        }
    </script>
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

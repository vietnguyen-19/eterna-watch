@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0"><b>Danh sách mã ưu đãi đã xóa</b></h5>
                                    </div>
                                </div>
                                <div class="col-sm-auto">

                                        <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary add-btn mr-1">
                                            <i class="ri-add-line align-bottom me-1"></i>Quay lại trang danh sách
                                        </a>

                                </div>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6"></div>
                                    <div class="col-sm-12 col-md-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-bordered display" id="voucherTable">
                                            <thead class="table-light text-muted">
                                                <tr>
                                                    <th class="sort align-middle" data-sort="id">ID</th>
                                                    <th class="sort align-middle" data-sort="code">Mã Voucher</th>
                                                    <th class="sort align-middle" data-sort="discount_type">Loại Giảm Giá
                                                    </th>
                                                    <th class="sort align-middle" data-sort="discount_value">Giá Trị Giảm
                                                    </th>
                                                    <th class="sort align-middle" data-sort="status">Trạng Thái</th>
                                                    <th class="sort align-middle" data-sort="deleted_at">Thời Gian Xóa</th>
                                                    <th class="sort align-middle" data-sort="action">Hành Động</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list form-check-all">
                                                @foreach ($vouchers as $voucher)
                                                    <tr>
                                                        <td class="align-middle">{{ $voucher->id }}</td>
                                                        <td class="align-middle"><b>{{ $voucher->code }}</b></td>
                                                        <td class="align-middle">
                                                            @if ($voucher->discount_type == 'percent')
                                                                Phần trăm (%)
                                                            @else
                                                                Số tiền cố định
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">
                                                            @if ($voucher->discount_type == 'percent')
                                                                {{ $voucher->discount_value }}%
                                                            @else
                                                                {{ number_format($voucher->discount_value, 0, ',', '.') }}
                                                                VNĐ
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">
                                                            <span
                                                                class="badge
                                                                @if ($voucher->status == 'active') bg-success
                                                                @elseif($voucher->status == 'inactive') bg-warning
                                                                @else bg-danger @endif">
                                                                @if ($voucher->status == 'active') Hoạt động
                                                                @elseif($voucher->status == 'inactive') Vô hiệu hóa
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td class="align-middle">
                                                            {{ $voucher->deleted_at ? $voucher->deleted_at->format('d/m/Y H:i:s') : 'Chưa xóa' }}
                                                            <!-- Thời gian xóa -->
                                                        </td>
                                                        <td class="align-middle">
                                                            <ul class="list-inline hstack gap-2 mb-0">
                                                                <!-- Restore Button with Icon -->
                                                                <li class="list-inline-item" title="Khôi phục">
                                                                    <form
                                                                        action="{{ route('admin.vouchers.restore', $voucher->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Bạn có chắc chắn muốn khôi phục voucher này?');">
                                                                        @csrf

                                                                        <button type="submit"
                                                                            class="btn btn-info btn-icon waves-effect waves-light btn-sm">
                                                                            <i class="fas fa-undo-alt"></i>
                                                                            <!-- Font Awesome icon for restore -->
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                                <!-- Delete Permanently Button with Icon -->
                                                                <li class="list-inline-item" title="Xóa vĩnh viễn">
                                                                    <form
                                                                        action="{{ route('admin.vouchers.forceDelete', $voucher->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn voucher này?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-danger btn-icon waves-effect waves-light btn-sm">
                                                                            <i class="fas fa-trash-alt"></i>
                                                                            <!-- Font Awesome icon for delete -->
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

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
        $('#voucherTable').DataTable({
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
    </script>

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
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

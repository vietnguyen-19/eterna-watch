@extends('admin.layouts.master')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <h5 class="card-title mb-0"><b>Danh sách mã ưu đãi</b></h5>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('admin.vouchers.trash') }}" class="btn btn-danger add-btn mr-1">
                                            <i class="ri-delete-bin-line me-1"></i>Thùng rác
                                        </a>
                                        <a href="{{ route('admin.vouchers.create') }}" class="btn btn-success add-btn">
                                            <i class="ri-add-line me-1"></i>Thêm mã ưu đãi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered display" id="voucherTable">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th>ID</th>
                                        <th>Mã Voucher</th>
                                        <th>Loại Giảm Giá</th>
                                        <th>Giá Trị Giảm</th>
                                        <th>Đơn Hàng Tối Thiểu</th>
                                        <th>Số Lần Tối Đa</th>
                                        <th>Đã Sử Dụng</th>
                                        <th>Ngày Bắt Đầu</th>
                                        <th>Ngày Kết Thúc</th>
                                        <th>Trạng Thái</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vouchers as $voucher)
                                        <tr>
                                            <td>{{ $voucher->id }}</td>
                                            <td><b>{{ $voucher->code }}</b></td>
                                            <td>
                                                {{ $voucher->discount_type === 'percent' ? 'Phần trăm (%)' : 'Số tiền cố định' }}
                                            </td>
                                            <td>
                                                {{ $voucher->discount_type === 'percent' ? $voucher->discount_value . '%' : number_format($voucher->discount_value, 0, ',', '.') . 'đ' }}
                                            </td>
                                            <td>
                                                {{ $voucher->min_order ? number_format($voucher->min_order, 0, ',', '.') . 'đ' : 'Không yêu cầu' }}
                                            </td>
                                            <td>{{ $voucher->max_uses ?? 'Không giới hạn' }}</td>
                                            <td>{{ $voucher->used_count }}</td>
                                            <td>{{ $voucher->start_date ? $voucher->start_date->format('d/m/Y') : 'Không có' }}</td>
                                            <td>{{ $voucher->expires_at ? $voucher->expires_at->format('d/m/Y') : 'Không có' }}</td>
                                            <td>
                                                <span class="badge 
                                                    @if ($voucher->status == 'active') bg-success
                                                    @elseif($voucher->status == 'inactive') bg-warning
                                                    @else bg-danger @endif">
                                                    @if ($voucher->status == 'active')
                                                        Hoạt động
                                                    @elseif($voucher->status == 'inactive')
                                                        Vô hiệu hóa
                                                    @elseif($voucher->status == 'expired')
                                                        Hết hạn
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item edit" title="Chỉnh sửa">
                                                        <a href="{{ route('admin.vouchers.edit', $voucher->id) }}"
                                                            class="btn btn-warning btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item" title="Xóa">
                                                        <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}"
                                                              method="POST"
                                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa voucher này?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light text-muted">
                                    <tr>
                                        <th>ID</th>
                                        <th>Mã Voucher</th>
                                        <th>Loại Giảm Giá</th>
                                        <th>Giá Trị Giảm</th>
                                        <th>Đơn Hàng Tối Thiểu</th>
                                        <th>Số Lần Tối Đa</th>
                                        <th>Đã Sử Dụng</th>
                                        <th>Ngày Bắt Đầu</th>
                                        <th>Ngày Kết Thúc</th>
                                        <th>Trạng Thái</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </tfoot>
                            </table>
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

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#voucherTable').DataTable({
                paging: true,
                lengthMenu: [10, 20, 50],
                searching: true,
                ordering: true,
                info: true,
                language: {
                    lengthMenu: "Hiển thị _MENU_ dòng",
                    zeroRecords: "Không tìm thấy dữ liệu",
                    info: "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
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

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: '{{ session('error') }}',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            @endif
        });
    </script>
@endsection

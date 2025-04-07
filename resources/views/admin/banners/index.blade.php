@extends('admin.layouts.master')
@section('content')
    <div class="container mt-4">
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
                                            <h5 class="card-title mb-0">Danh sách banner</h5>
                                        </div>
                                    </div>
                                    <div class="col-sm-auto">

                                            <a href="{{ route('admin.banners.trash') }}" class="btn btn-warning me-2">
                                                <i class="ri-delete-bin-line align-bottom me-1"></i> Thùng rác
                                            </a>

                                            <a href="{{ route('admin.banners.create') }}" class="btn btn-success add-btn"><i
                                                    class="ri-add-line align-bottom me-1"></i>Thêm banner</a>

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
                                            <table class="table table-bordered" aria-describedby="example2_info"
                                                id="danhmucTable">
                                                <thead class="text-muted">
                                                    <tr>
                                                        <th class="sort" data-sort="id">ID</th>
                                                        <th class="sort" data-sort="image_link">Liên kết hình ảnh</th>
                                                        <th class="sort" data-sort="redirect_link">Liên kết chuyển hướng</th>
                                                        <th class="sort" data-sort="action">Hành động</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list form-check-all">
                                                    @foreach ($banners as $banner)
                                                        <tr>

                                                            <td class="id">{{ $banner->id }}</td>
                                                            <td class="image_link">
                                                                @if ($banner->image_link)
                                                                    <img src="{{ asset($banner->image_link) }}"
                                                                        alt="Banner" width="100" height="60"
                                                                        style="object-fit: cover; border-radius: 5px;">
                                                                @else
                                                                    <span class="text-muted">Không có ảnh</span>
                                                                @endif
                                                            </td>

                                                            <td class="redirect_link">
                                                                @if ($banner->redirect_link)
                                                                    <a href="{{ $banner->redirect_link }}"
                                                                        target="_blank">{{ $banner->redirect_link }}</a>
                                                                @else
                                                                    <span class="text-muted">Không có liên kết chuyển
                                                                        hướng</span>
                                                                @endif
                                                            </td>

                                                            <td>
                                                                <ul class="list-inline hstack gap-2 mb-0">
                                                                    <!-- Edit Button -->
                                                                    <li class="list-inline-item edit" title="Edit">
                                                                        <a href="{{ route('admin.banners.edit', $banner->id) }}"
                                                                            class="btn btn-warning btn-icon waves-effect waves-light btn-sm">
                                                                            <i class="fa-solid fa-edit"></i>
                                                                        </a>
                                                                    </li>
                                                                    <!-- Remove Button -->
                                                                    <li class="list-inline-item delete" title="Remove">
                                                                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" style="display:inline;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                                                <i class="fa-solid fa-trash"></i>
                                                                            </button>
                                                                        </form>
                                                                    </li>

                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <thead class="text-muted">
                                                    <tr>
                                                        <th class="sort" data-sort="id">ID</th>
                                                        <th class="sort" data-sort="image_link">Liên kết hình ảnh</th>
                                                        <th class="sort" data-sort="redirect_link">Liên kết chuyển hướng
                                                        </th>
                                                        <th class="sort" data-sort="action">Hành động</th>
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

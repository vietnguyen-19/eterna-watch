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
                                    <h5 class="card-title mb-0">Danh sách banner</h5>
                                </div>
                                <div class="col-sm-auto">
                                    <a href="{{ route('admin.banners.create') }}" class="btn btn-success">
                                        <i class="ri-add-line align-bottom me-1"></i>Thêm banner
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead class="text-muted">
                                    <tr>
                                        <th>ID</th>
                                        <th>Ảnh Banner</th>
                                        <th>Liên kết</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($banners as $banner)
                                        <tr>
                                            <td>{{ $banner->id }}</td>
                                            <td>
                                                <img src="{{ $banner->image_link }}" alt="Banner"
                                                    style="width: 120px; height: auto;">
                                            </td>
                                            <td>
                                                @if ($banner->redirect_link)
                                                    <a href="{{ $banner->redirect_link }}" target="_blank">
                                                        {{ Str::limit($banner->redirect_link, 30, '...') }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">Không có liên kết</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $banner->status == 'active' ? 'success' : 'danger' }}">
                                                    {{ $banner->status == 'active' ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.banners.edit', $banner->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pen"></i> Sửa
                                                </a>
                                                <a onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                                                    href="{{ route('admin.banners.destroy', $banner->id) }}"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i> Xóa
                                                </a>
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

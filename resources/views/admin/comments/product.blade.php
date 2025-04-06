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

                    <!-- Thanh điều hướng -->
                    <div class="col-12 mb-3">
                        <div class="tab-menu">
                            <a href="{{ route('admin.comments.index') }}" class="tab-item  ">Bình luận tin tức</a>
                            <a href="{{ route('admin.comments.product') }}" class="tab-item tab-active">Đánh giá sản
                                phẩm</a>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0">Danh sách đánh giá sản phẩm</h5>
                                    </div>
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
                                                    <th class="sort" data-sort="nguoi_binh_luan">Người bình luận</th>
                                                    <th class="sort" data-sort="noi_dung">Nội dung</th>
                                                    <th class="sort" data-sort="loai_noi_dung">Loại bình luận</th>
                                                    <th class="sort" data-sort="rate">Đánh giá</th>
                                                    <th class="sort" data-sort="status">Trạng thái</th>
                                                    <th class="sort" data-sort="date">Ngày bình luận</th>
                                                    <th class="sort" data-sort="action">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list form-check-all">
                                                @foreach ($product as $item)
                                                    <tr>

                                                        <td class="id">{{ $item->id }}</td>
                                                        <td class="nguoi_binh_luan">
                                                            {{ optional($item->user)->name ?? 'Ẩn danh' }}</td>

                                                        <td class="noi_dung">
                                                            {{ Str::limit($item->content, 50, '...') }}
                                                        </td>

                                                        <td class="loai_noi_dung">
                                                            {{ $item->entity_type }}
                                                        </td>
                                                        <td class="rate">
                                                            @for ($i = 0; $i < $item->rating; $i++)
                                                                <i class="fa-solid fa-star text-warning"></i>
                                                            @endfor
                                                        </td>

                                                        <td class="status">
                                                            <span
                                                                class="badge
                                                                @if ($item->status == 'approved') bg-success
                                                                @elseif($item->status == 'rejected') bg-danger
                                                                @else bg-secondary @endif">
                                                                @if ($item->status == 'approved')
                                                                    Đã chấp thuận
                                                                @elseif($item->status == 'rejected')
                                                                    Từ chối
                                                                @else
                                                                    Chờ duyệt
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td class="date">
                                                            {{ $item->created_at->format('d/m/y - h:i') }}
                                                        </td>
                                                        <td>
                                                            <ul class="list-inline hstack gap-2 mb-0">
                                                                <!-- Edit Button -->
                                                                <li class="list-inline-item edit" title="Edit">
                                                                    <a href="{{ route('admin.comments.edit', $item->id) }}"
                                                                        class="btn btn-warning btn-icon waves-effect waves-light btn-sm">
                                                                        Sửa
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <thead class="text-muted">
                                                <tr>
                                                    <th class="sort" data-sort="id">ID</th>
                                                    <th class="sort" data-sort="nguoi_binh_luan">Người bình luận</th>
                                                    <th class="sort" data-sort="noi_dung">Nội dung</th>
                                                    <th class="sort" data-sort="loai_noi_dung">Loại bình luận</th>
                                                    <th class="sort" data-sort="rate">Đánh giá</th>
                                                    <th class="sort" data-sort="status">Trạng thái</th>
                                                    <th class="sort" data-sort="date">Ngày bình luận</th>
                                                    <th class="sort" data-sort="action">Action</th>
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
<style>
    .tab-menu {
        display: flex;
        justify-content: center;
        background: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 12px;
        border-radius: 8px;
        gap: 10px;
    }

    .tab-item {
        flex: 1;
        text-align: center;
        padding: 10px 15px;
        font-weight: 600;
        color: #6c757d;
        text-decoration: none;
        border-bottom: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .tab-item:hover {
        color: #0d6efd;
        border-bottom: 2px solid #0d6efd;
    }

    .tab-active {

        color: #0d6efd;
        border-bottom: 3px solid #0d6efd;
        font-weight: bold;
        background: rgb(237, 237, 237)
    }

    .btn.active {
        background-color: #03a990 !important;
        color: white !important;
    }

    canvas {
        width: 100% !important;
        height: 300px !important;
    }
</style>

@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="customerList">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <h5 class="card-title mb-0"><b>Danh sách bài viết</b></h5>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap align-items-start gap-2">
                                        <a href="{{ route('admin.posts.trash') }}" class="btn btn-sm btn-danger mr-1">
                                            <i class="ri-delete-bin-line align-bottom me-1"></i> Thùng rác
                                        </a>
                                        <a href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-success">
                                            <i class="ri-add-line align-bottom me-1"></i> Thêm bài viết mới
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div>
                                <div class="table-responsive table-card mb-1 mt-2">
                                    <table class="table table-bordered display" id="postTable">
                                        <thead class="table-light text-muted">
                                            <tr>
                                                <th class="sort" data-sort="title">ID</th>
                                                <th class="sort" data-sort="image">Tiêu đề</th>
                                                <th class="sort" data-sort="user">Tác giả</th>
                                                
                                                <th class="sort" data-sort="published_at">Ngày đăng</th>
                                                <th class="sort" data-sort="published_at">Trạng thái</th>
                                                <th class="sort" data-sort="action">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($posts as $post)
                                                <tr>
                                                    <!-- Title -->
                                                    <td class="align-middle">
                                                       {{ $post->id }}</a>
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $post->title }}
                                                    </td>
                                                    <!-- Image -->
                                                    
                                                    <!-- User Name -->
                                                    <td class="align-middle">
                                                        {{ $post->user->name ?? 'N/A' }}
                                                    </td>
                                                    <!-- Tags -->
                                                    
                                                    <!-- Published Date -->
                                                    <td class="align-middle">
                                                        {{ $post->published_at ? $post->published_at->format('d/m/Y') : 'Chưa xuất bản' }}
                                                    </td>
                                                    <td class="align-middle">
                                                        @switch($post->status)
                                                            @case('draft')
                                                                <span class="badge bg-warning-subtle text-warning">Bản nháp</span>
                                                                @break
                                                            @case('published')
                                                                <span class="badge bg-success-subtle text-success">Đã xuất bản</span>
                                                                @break
                                                            @case('archived')
                                                                <span class="badge bg-dark-subtle text-dark">Đã lưu trữ</span>
                                                                @break
                                                            @default
                                                                <span class="badge bg-light text-dark">Không rõ</span>
                                                        @endswitch
                                                    </td>
                                                    <!-- Action -->
                                                    <td class="align-middle">
                                                        <ul class="list-inline hstack d-flex flex-nowrap gap-2 mb-0">
                                                            <!-- Edit Button -->
                                                            <li class="list-inline-item" title="Chỉnh sửa">
                                                                <a href="{{ route('admin.posts.edit', $post->id) }}"
                                                                   class="btn btn-warning btn-icon waves-effect waves-light btn-sm">
                                                                    <i class="fa-solid fa-pen-nib"></i>
                                                                </a>
                                                            </li>
                                                            <!-- Delete Button -->
                                                            <li class="list-inline-item" title="Xóa">
                                                                <form action="{{ route('admin.posts.destroy', $post->id) }}" 
                                                                      method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="btn btn-danger btn-icon waves-effect waves-light btn-sm"
                                                                            onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')">
                                                                        <i class="fa-solid fa-trash"></i>
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

                </div>
            </div>
        </div>
    </section>
@endsection
@section('script-lib')
    <script src="{{ asset('theme/velzon/theme/velzon/assets/libs/list.js/list.min.js') }}"></script>
    <script src="{{ asset('theme/velzon/theme/velzon/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
    <script src="{{ asset('theme/velzon/assets/libs/list.js/list.min.js') }}"></script>
    <script src="{{ asset('theme/velzon/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ asset('theme/velzon/assets/js/pages/ecommerce-customer-list.init.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

    <!-- Sweet Alerts js -->


    <!-- Sweet alert init js-->
    <script src="{{ asset('theme/velzon/assets/js/pages/sweetalerts.init.js') }}"></script>

    <script src="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@endsection
@section('script')
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $('#postTable').DataTable({
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
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />
        <style>
            .avatar-xs {
                height: 2.2rem;
                width: 2.2rem;
            }

            .bg-success-subtle {
                background-color: rgba(10, 179, 156, .1);
            }

            .bg-danger-subtle {
                background-color: rgba(240, 101, 72, .1);
            }

            .bg-warning-subtle {
                background-color: rgba(247, 184, 75, .1);
            }

            .bg-primary-subtle {
                background-color: rgba(64, 81, 137, .1);
            }

            .bg-secondary-subtle {
                background-color: rgba(116, 120, 141, .1);
            }

            .bg-dark-subtle {
                background-color: rgba(33, 37, 41, .1);
            }
        </style>
@endsection

@extends('admin.layouts.master')
@section('content')
    <!-- Modal dùng cho Edit và Reply -->
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm-auto">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="card-title mb-0"><strong>Danh sách đánh giá sản phẩm</strong></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <ul class="nav nav-tabs nav-tabs-custom">
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $status === 'all' ? 'active' : '' }}"
                                                        href="{{ route('admin.comments.products', ['type' => 'product', 'status' => 'all']) }}">
                                                        Tất cả
                                                        <span
                                                            class="badge rounded-pill bg-dark">{{ $productStatusCounts['all'] }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $status === 'pending' ? 'active' : '' }}"
                                                        href="{{ route('admin.comments.products', ['type' => 'product', 'status' => 'pending']) }}">
                                                        Đang chờ duyệt
                                                        <span
                                                            class="badge rounded-pill bg-warning text-dark">{{ $productStatusCounts['pending'] }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $status === 'approved' ? 'active' : '' }}"
                                                        href="{{ route('admin.comments.products', ['type' => 'product', 'status' => 'approved']) }}">
                                                        Đã duyệt
                                                        <span
                                                            class="badge rounded-pill bg-success">{{ $productStatusCounts['approved'] }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $status === 'rejected' ? 'active' : '' }}"
                                                        href="{{ route('admin.comments.products', ['type' => 'product', 'status' => 'rejected']) }}">
                                                        Bị từ chối
                                                        <span
                                                            class="badge rounded-pill bg-danger">{{ $productStatusCounts['rejected'] }}</span>
                                                    </a>
                                                </li>
                                            </ul>

                                            <!-- Bảng hiển thị bình luận -->
                                            <div class="table-responsive mt-4">
                                                <table class="table table-bordered" id="reviewTable{{ $status }}">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 4%">
                                                                <input type="checkbox" id="checkAll">
                                                            </th>
                                                            <th>ID</th>
                                                            <th>Người dùng</th>
                                                            <th style="width: 40%;">Nội dung</th>
                                                            <th style="width: 20%;">Sản phẩm</th>
                                                            <th style="width: 12%;">Trạng thái</th>
                                                            <th style="width: 10%;">Ngày tạo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($comments as $comment)
                                                            <tr>
                                                                <td class="align-middle">
                                                                    <input type="checkbox" class="checkbox-item"
                                                                        value="{{ $comment->id }}">
                                                                </td>
                                                                <td class="align-middle">{{ $comment->id }}</td>

                                                                <td class="align-middle">
                                                                    <div class="d-flex align-items-center">
                                                                        <div>
                                                                            <img src="{{ Storage::url($comment->user->avatar ?? 'default-avatar.png') }}"
                                                                                class=""
                                                                                style="width: 66px; height: 66px; object-fit: cover;">
                                                                        </div>
                                                                        <div class="m-3">
                                                                            <span
                                                                                class="user-name text-info"><b>{{ $comment->user->name }}</b></span><br>
                                                                            <span
                                                                                class="user-email">{{ $comment->user->email }}</span>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                                <td>
                                                                    <div>
                                                                        <p> {{ $comment->content }}</p>
                                                                        <br>
                                                                        @if (isset($comment->parent) && isset($comment->parent->user))
                                                                            Trả lời tới | <span
                                                                                class="text-info">{{ $comment->parent->user->name }}</span>
                                                                        @endif
                                                                        <br>
                                                                        @if (isset($comment->rating))
                                                                            Rating | <span
                                                                                class="text-info">{{ $comment->rating }}</span>
                                                                            <i style="width: 16px"
                                                                                class="fa-solid fa-star text-warning"></i>
                                                                        @endif
                                                                        <br>
                                                                        <div class="mt-2 btn-group">
                                                                            <button class="btn btn-dark btn-sm edit-comment"
                                                                                data-id="{{ $comment->id }}"
                                                                                data-content="{{ $comment->content }}">
                                                                                Sửa
                                                                            </button>
                                                                            <button
                                                                                class="btn btn-info btn-sm reply-comment"
                                                                                data-id="{{ $comment->id }}"
                                                                                data-entity-id="{{ $comment->entity_id }}"
                                                                                data-entity-type="{{ $comment->entity_type }}">
                                                                                Trả lời
                                                                            </button>
                                                                            @switch($comment->status)
                                                                                @case('pending')
                                                                                    <a href="#"
                                                                                        class="btn btn-warning btn-sm comment-action"
                                                                                        data-id="{{ $comment->id }}"
                                                                                        data-action="approve">Chấp nhận</a>
                                                                                @break

                                                                                @case('approved')
                                                                                    <a href="#"
                                                                                        class="btn btn-warning btn-sm comment-action"
                                                                                        data-id="{{ $comment->id }}"
                                                                                        data-action="reject">Không duyệt</a>
                                                                                @break

                                                                                @case('rejected')
                                                                                    <a href="#"
                                                                                        class="btn btn-warning btn-sm comment-action"
                                                                                        data-id="{{ $comment->id }}"
                                                                                        data-action="approve">Chấp nhận</a>
                                                                                @break
                                                                            @endswitch
                                                                            <a href="#"
                                                                                class="btn btn-danger btn-sm comment-action"
                                                                                data-id="{{ $comment->id }}"
                                                                                data-action="delete">Xóa</a>

                                                                        </div>


                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    {{ optional($comment->entity)->name }}

                                                                </td>
                                                                <td>
                                                                    @switch($comment->status)
                                                                        @case('pending')
                                                                            <span class="badge bg-warning text-dark">Đang chờ
                                                                                duyệt</span>
                                                                        @break

                                                                        @case('approved')
                                                                            <span class="badge bg-success">Đã duyệt</span>
                                                                        @break

                                                                        @case('rejected')
                                                                            <span class="badge bg-danger">Bị từ chối</span>
                                                                        @break

                                                                        @default
                                                                            <span class="badge bg-secondary">Không xác định</span>
                                                                    @endswitch
                                                                </td>
                                                                <td>{{ $comment->created_at->format('d/m/Y H:i') }}</td>
                                                                <div class="modal fade" id="editCommentModal" tabindex="-1"
                                                                    role="dialog" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered"
                                                                        role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Sửa Bình Luận</h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="form-group">
                                                                                    <label for="editCommentContent">Nội
                                                                                        dung bình luận:</label>
                                                                                    <textarea class="form-control" id="editCommentContent" rows="4" placeholder="Nhập nội dung..."></textarea>
                                                                                </div>
                                                                                <input type="hidden" id="editCommentId">
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">Hủy</button>
                                                                                <button type="button"
                                                                                    class="btn btn-primary"
                                                                                    id="saveEditComment">Lưu
                                                                                    Thay Đổi</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <!-- Modal Trả Lời Bình Luận -->
                                                                <div class="modal fade" id="replyCommentModal"
                                                                    tabindex="-1" role="dialog" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered"
                                                                        role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Trả Lời Bình Luận
                                                                                </h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="form-group">
                                                                                    <label for="replyCommentContent">Nội
                                                                                        dung trả lời:</label>
                                                                                    <textarea class="form-control" id="replyCommentContent" rows="4" placeholder="Nhập nội dung trả lời..."></textarea>
                                                                                </div>
                                                                                <input type="hidden" id="replyCommentId">
                                                                                <input type="hidden" id="entityId"
                                                                                    value="{{ $comment->entity_id }}">
                                                                                <input type="hidden" id="entityType"
                                                                                    value="{{ $comment->entity_type }}">
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">Hủy</button>
                                                                                <button type="button"
                                                                                    class="btn btn-primary"
                                                                                    id="saveReplyComment">Gửi Trả
                                                                                    Lời</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="6" class="text-center">Không có bình luận
                                                                        nào
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th></th>
                                                                <th>ID</th>
                                                                <th>Người dùng</th>
                                                                <th style="width: 50%;">Nội dung</th>
                                                                <th>Sản phẩm</th>
                                                                <th>Trạng thái</th>
                                                                <th>Ngày tạo</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="card-header">
                        <button class="btn btn-danger" id="deleteSelected">Xóa đã chọn</button>
                    </div>
                </div>
            </div>
            </div>
        </section>
    @endsection
    @section('style')
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

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
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    @endsection
    @section('script')
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

        <!-- Bootstrap CSS -->
        <!-- Bootstrap CSS -->

        <!-- Bootstrap JS + Popper -->
        <script></script>
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script>
            // Mảng chứa các ID của các bảng cần áp dụng DataTable
            var tableIds = [
                'commentTablepending',
                'commentTableapproved',
                'commentTablerejected',
                'commentTableall',
                'reviewTablepending',
                'reviewTableapproved',
                'reviewTablerejected',
                'reviewTableall'
            ];
        
            // Lặp qua từng ID và áp dụng DataTable
            tableIds.forEach(function(tableId) {
                var $table = $('#' + tableId);
        
                // Kiểm tra bảng có tồn tại không
                if ($table.length) {
                    // Lấy số cột từ phần thead
                    var thCount = $table.find('thead th').length;
                    var isValid = true;
        
                    // Kiểm tra các dòng trong tbody có đúng số lượng cột không
                    $table.find('tbody tr').each(function() {
                        if ($(this).find('td').length !== thCount) {
                            isValid = false;
                        }
                    });
        
                    // Nếu số cột hợp lệ thì áp dụng DataTable
                    if (isValid) {
                        $table.DataTable({
                            paging: true,
                            lengthMenu: [10, 20, 50],
                            searching: true,
                            ordering: true,
                            info: true,
                            language: {
                                lengthMenu: "Hiển thị _MENU_ dòng",
                                zeroRecords: "Không tìm thấy dữ liệu",
                                info: "Đang hiển thị _START_ đến _END_ của _TOTAL_ mục",
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
                    } else {
                        console.warn(`❌ Bảng ${tableId} có số cột <td> không khớp với <th>, bỏ qua DataTables.`);
                    }
                }
            });
        </script>
        
        <script>
            $(document).ready(function() {
                // Chọn tất cả
                $('#checkAll').on('click', function() {
                    $('.checkbox-item').prop('checked', this.checked);
                });

                // Xóa nhiều
                $('#deleteSelected').on('click', function() {
                    var ids = [];
                    $('.checkbox-item:checked').each(function() {
                        ids.push($(this).val());
                    });
                    if (ids.length === 0) {
                        alert("Vui lòng chọn ít nhất một mục để xóa.");
                    } else {
                        if (confirm("Bạn có chắc chắn muốn xóa các mục đã chọn không?")) {
                            $.ajax({
                                url: "{{ route('admin.comments.deleteMultiple') }}",
                                type: 'POST',
                                data: {
                                    ids: ids.join(","),
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    if (response.success) {
                                        alert(response.success);
                                        location.reload();
                                    } else {
                                        alert(response.error);
                                    }
                                }
                            });
                        }
                    }
                });
            });
        </script>
        <script>
            // Hiển thị modal sửa bình luận
            $(document).on('click', '.edit-comment', function() {
                var id = $(this).data('id');
                var content = $(this).data('content');
                $('#editCommentContent').val(content);
                $('#editCommentId').val(id);
                $('#editCommentModal').modal('show');
            });

            // AJAX sửa bình luận
            $('#saveEditComment').on('click', function() {
                var id = $('#editCommentId').val();
                var content = $('#editCommentContent').val();

                $.ajax({
                    url: '/admin/comments/update/' + id, // Thay đổi cách gọi URL
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        content: content
                    },
                    success: function(response) {
                        $('#editCommentModal').modal('hide');
                        alert('Sửa bình luận thành công!');
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Có lỗi xảy ra. Vui lòng thử lại.');
                    }
                });
            });


            // Hiển thị modal trả lời bình luận
            $(document).on('click', '.reply-comment', function() {
                var id = $(this).data('id');
                $('#replyCommentId').val(id);
                $('#replyCommentModal').modal('show');
            });

            // AJAX trả lời bình luận
            // AJAX trả lời bình luận
            $('#saveReplyComment').on('click', function() {
                var parentId = $('#replyCommentId').val();
                var content = $('#replyCommentContent').val();
                var entityId = $('#entityId').val(); // Lấy entity_id
                var entityType = $('#entityType').val(); // Lấy entity_type

                $.ajax({
                    url: '{{ route('admin.comments.reply') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        parent_id: parentId,
                        content: content,
                        entity_id: entityId,
                        entity_type: entityType
                    },
                    success: function(response) {
                        $('#replyCommentModal').modal('hide');
                        alert('Đã trả lời bình luận thành công!');
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Có lỗi xảy ra. Vui lòng thử lại.');
                    }
                });
            });
        </script>
        <script>
            $(document).on('click', '.comment-action', function(e) {
                e.preventDefault();

                var commentId = $(this).data('id'); // Lấy ID của bình luận
                var action = $(this).data('action'); // Lấy hành động cần thực hiện
                var url = '';

                // Xác định URL dựa trên hành động
                switch (action) {
                    case 'approve':
                        url = '/admin/comments/approve/' + commentId;
                        break;
                    case 'reject':
                        url = '/admin/comments/reject/' + commentId;
                        break;
                    case 'delete':
                        if (!confirm('Bạn có chắc muốn xóa bình luận này không?')) {
                            return; // Nếu không xác nhận thì thoát
                        }
                        url = '/admin/comments/delete/' + commentId;
                        break;
                    default:
                        return;
                }

                // Gửi yêu cầu Ajax
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}' // Laravel yêu cầu CSRF token
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload(); // Tải lại trang để cập nhật trạng thái
                    },
                    error: function(xhr) {
                        alert('Có lỗi xảy ra!');
                        console.log(xhr.responseText);
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

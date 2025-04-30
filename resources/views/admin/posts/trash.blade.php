@extends('admin.layouts.master')
@section('content')
<section class="content pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="trashList">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <h5 class="card-title mb-0"><b>Danh sách bài viết đã xóa</b></h5>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-secondary mr-1">
                                        <i class="ri-delete-bin-line align-bottom me-1"></i> Quay về danh sách
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive table-card mb-1 mt-2">
                            <table class="table table-bordered display" id="postTable">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tiêu đề</th>
                                        <th>Tác giả</th>
                                        <th>Ngày đăng</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày xóa</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td>{{ $post->id }}</td>
                                            <td>{{ $post->title }}</td>
                                            <td>{{ $post->user->name ?? 'N/A' }}</td>
                                            <td>{{ $post->published_at ? $post->published_at->format('d/m/Y') : 'Chưa xuất bản' }}</td>
                                            <td>
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
                                            <td>{{ $post->deleted_at ? $post->deleted_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                            <td>
                                                <form action="{{ route('admin.posts.restore', $post->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button class="btn btn-primary btn-icon btn-sm" title="Khôi phục"
                                                        onclick="return confirm('Bạn có chắc muốn khôi phục bài viết này không?')">
                                                        <i class="fa-solid fa-rotate-left"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.posts.forceDelete', $post->id) }}" 
                                                    method="POST" style="display:inline;">
                                                  @csrf
                                                  @method('DELETE')
                                                  <button class="btn btn-danger btn-icon waves-effect waves-light btn-sm"
                                                          onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn bài viết này?')">
                                                      <i class="fa-solid fa-trash"></i>
                                                  </button>
                                              </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- card-body -->
                </div> <!-- card -->
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    setTimeout(function () {
        var alert = document.getElementById('thongbao-alert');
        if (alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);
</script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
    $('#postTable').DataTable({
        paging: true,
        lengthMenu: [10, 20, 50],
        searching: true,
        ordering: true,
        info: true,
        language: {
            lengthMenu: "Hiển thị _MENU_ dòng",
            zeroRecords: "Không tìm thấy dữ liệu",
            info: "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ mục",
            infoEmpty: "Không có dữ liệu",
            search: "Tìm kiếm:",
            paginate: {
                first: "Đầu",
                last: "Cuối",
                next: "Sau",
                previous: "Trước"
            }
        }
    });
</script>
@endsection

@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
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

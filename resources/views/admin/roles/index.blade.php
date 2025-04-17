@extends('admin.layouts.master')

@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0">Danh sách vai trò</h5>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap align-items-start gap-2">
                                        <a href="{{ route('admin.roles.create') }}" class="btn btn-success"><i
                                                class="ri-add-line align-bottom me-1"></i>Thêm vai trò</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('thongbao'))
                                <div id="thongbao-alert"
                                    class="alert alert-{{ session('thongbao.type') }} alert-dismissible bg-{{ session('thongbao.type') }} text-white fade show"
                                    role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                        aria-label="Đóng"></button>
                                    <i class="ri-notification-off-line label-icon me-2"></i>
                                    <strong>{{ session('thongbao.message') }}</strong>
                                </div>
                            @endif


                            <div class="table-responsive">
                                <table class="table table-hover align-middle" id="roleTable">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên vai trò</th>
                                            <th>Người dùng</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $index => $role)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $role->name }}</td>

                                                <td>{{ $role->users->count() ?? 0 }}</td>
                                                <td>
                                                    <a href="{{ route('admin.roles.show', $role->id) }}"
                                                        class="btn btn-info btn-sm">Chi tiết</a>
                                                    <a href="{{ route('admin.roles.edit', $role->id) }}"
                                                        class="btn btn-warning btn-sm">Sửa</a>
                                                    <form action="{{ route('admin.roles.destroy', $role->id) }}"
                                                        method="POST" style="display: inline-block;"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa vai trò này?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
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
                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0">Danh sách phân quyền</h5>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap align-items-start gap-2">
                                        <a href="{{ route('admin.permissions.create') }}" class="btn btn-success"><i
                                                class="ri-add-line align-bottom me-1"></i>Thêm phân quyền</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('thongbao'))
                                <div id="thongbao-alert"
                                    class="alert alert-{{ session('thongbao.type') }} alert-dismissible bg-{{ session('thongbao.type') }} text-white fade show"
                                    role="alert">
                                    <i
                                        class="ri-notification-off-line label-icon"></i><strong>{{ session('thongbao.message') }}</strong>
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-hover align-middle" id="permissionTable">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên phân quyền</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $index => $permission)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $permission->name }}</td>
                                                <td>
                                                    <a href="{{ route('admin.permissions.edit', $permission->id) }}"
                                                        class="btn btn-warning btn-sm">Sửa</a>
                                                    <form
                                                        action="{{ route('admin.permissions.destroy', $permission->id) }}"
                                                        method="POST" style="display: inline-block;"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa vai trò này?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
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
@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#permissionTable').DataTable({
                "pageLength": 10,
                "lengthMenu": [10, 25, 50],
                "order": [
                    [0, 'desc']
                ],
                "language": {
                    "lengthMenu": "Hiển thị _MENU_ dòng",
                    "zeroRecords": "Không tìm thấy dữ liệu",
                    "info": "Trang _PAGE_ / _PAGES_",
                    "infoEmpty": "Không có dữ liệu",
                    "search": "Tìm kiếm:",
                    "paginate": {
                        "first": "Đầu",
                        "last": "Cuối",
                        "next": "Sau",
                        "previous": "Trước"
                    }
                }
            });

            // Tự động ẩn thông báo sau 5 giây

        });
    </script>
    <script>
        $(document).ready(function() {
            // Tự động ẩn thông báo sau 5 giây (5000ms)
            setTimeout(function() {
                $('#thongbao-alert').fadeOut('slow');
            }, 3000);
        });
    </script>
@endsection

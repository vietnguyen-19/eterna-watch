@extends('admin.layouts.master')

@section('content')
<section class="content pt-3">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Vai trò: <strong>{{ $role->name }}</strong>
                        </h5>
                    </div>
                    <div class="card-body">
                        @if (session('thongbao'))
                            <div id="thongbao-alert" class="alert alert-{{ session('thongbao.type') }} alert-dismissible fade show" role="alert">
                                <strong>{{ session('thongbao.message') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.roles.update_permissions', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                @foreach ($permissions as $module => $perms)
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="border rounded p-3 h-100">
                                            <div class="form-check mb-2">
                                                <input type="checkbox" class="form-check-input check-module" id="module_{{ $module }}" data-module="{{ $module }}">
                                                <label class="form-check-label fw-bold" for="module_{{ $module }}">
                                                    {{ ucfirst($module) ? 'Quản lý ' . str_replace('_', ' ', $module) : 'Khác' }}
                                                </label>
                                            </div>
                                            <div class="ms-3">
                                                @foreach ($perms as $permission)
                                                    <div class="form-check">
                                                        <input class="form-check-input check-permission permission-{{ $module }}"
                                                               type="checkbox"
                                                               name="permissions[]"
                                                               value="{{ $permission->name }}"
                                                               id="perm_{{ $permission->id }}"
                                                               {{ $role->permissions->contains('name', $permission->name) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                            {{ ucwords(str_replace('_', ' ', str_replace($module . '_', '', $permission->name))) }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-save me-1"></i> Lưu thay đổi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    // Chọn/bỏ chọn tất cả quyền theo module
    document.querySelectorAll('.check-module').forEach(function(moduleCheckbox) {
        moduleCheckbox.addEventListener('change', function() {
            const module = this.dataset.module;
            const checkboxes = document.querySelectorAll('.permission-' + module);
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    });
</script>
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

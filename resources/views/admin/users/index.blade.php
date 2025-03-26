@extends('admin.layouts.master')

@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title mb-0 me-3">Danh sách tài khoản</h5>
                                    <select name="role_id" class="form-select" style="width: 200px;" onchange="window.location.href='{{ route('admin.users.index') }}?role_id=' + this.value">
                                        <option value="">Tất cả vai trò</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                                                {{ $role->name == 'employee' ? 'Nhân viên' : ($role->name == 'user' ? 'Khách hàng' : $role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                        <i class="ri-add-line align-bottom me-1"></i>Thêm tài khoản
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @if (session('thongbao'))
                                <div id="thongbao-alert" class="alert alert-{{ session('thongbao.type') }} alert-dismissible fade show" role="alert">
                                    <i class="ri-notification-off-line me-2"></i>
                                    {{ session('thongbao.message') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-hover align-middle" id="userTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 5%">ID</th>
                                            <th style="width: 25%">Tên</th>
                                            <th style="width: 20%">Email</th>
                                            <th style="width: 15%">Số điện thoại</th>
                                            <th style="width: 10%">Trạng thái</th>
                                            <th style="width: 10%">Vai trò</th>
                                            <th style="width: 15%">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            @if($user->avatar && Storage::exists('public/' . $user->avatar))
                                                                <img src="{{ Storage::url($user->avatar) }}" alt="Avatar"
                                                                    class="rounded-circle avatar-xs">
                                                            @else
                                                                <img src="{{ asset('theme/velzon/assets/images/users/avatar-1.jpg') }}"
                                                                    alt="Avatar" class="rounded-circle avatar-xs">
                                                            @endif
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone ?? 'Chưa có' }}</td>
                                                <td>
                                                    @switch($user->status)
                                                        @case('active')
                                                            <span class="badge bg-success-subtle text-success">Hoạt động</span>
                                                            @break
                                                        @case('inactive')
                                                            <span class="badge bg-danger-subtle text-danger">Ngưng hoạt động</span>
                                                            @break
                                                        @case('banned')
                                                            <span class="badge bg-dark-subtle text-dark">Đã khóa</span>
                                                            @break
                                                        @case('pending')
                                                            <span class="badge bg-warning-subtle text-warning">Chờ duyệt</span>
                                                            @break
                                                        @default
                                                            <span class="badge bg-secondary-subtle text-secondary">Không xác định</span>
                                                    @endswitch
                                                </td>
                                                <td>
                                                    @if($user->role)
                                                        <span class="badge bg-primary-subtle text-primary">
                                                            {{ $user->role->name == 'employee' ? 'Nhân viên' : ($user->role->name == 'user' ? 'Khách hàng' : $user->role->name) }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary-subtle text-secondary">Chưa có</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="hstack gap-2">
                                                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                                                           class="btn btn-sm btn-warning">
                                                            <i class="ri-edit-2-line"></i> Sửa
                                                        </a>
                                                        <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                                              method="POST" 
                                                              class="d-inline"
                                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="ri-delete-bin-line"></i> Xóa
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">Không có tài khoản nào.</td>
                                            </tr>
                                        @endforelse
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
    <style>
        .avatar-xs {
            height: 2.2rem;
            width: 2.2rem;
        }
        .btn-soft-warning {
            background-color: rgba(247, 184, 75, .1);
            color: #f7b84b;
            border: none;
        }
        .btn-soft-warning:hover {
            background-color: #f7b84b;
            color: #fff;
        }
        .btn-soft-danger {
            background-color: rgba(240, 101, 72, .1);
            color: #f06548;
            border: none;
        }
        .btn-soft-danger:hover {
            background-color: #f06548;
            color: #fff;
        }
        .bg-success-subtle { background-color: rgba(10, 179, 156, .1); }
        .bg-danger-subtle { background-color: rgba(240, 101, 72, .1); }
        .bg-warning-subtle { background-color: rgba(247, 184, 75, .1); }
        .bg-primary-subtle { background-color: rgba(64, 81, 137, .1); }
        .bg-secondary-subtle { background-color: rgba(116, 120, 141, .1); }
        .bg-dark-subtle { background-color: rgba(33, 37, 41, .1); }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
                "pageLength": 10,
                "lengthMenu": [10, 25, 50],
                "order": [[0, 'desc']],
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

            // Tự động ẩn thông báo
            setTimeout(function() {
                $("#thongbao-alert").fadeOut('slow');
            }, 3000);
        });
    </script>
@endsection

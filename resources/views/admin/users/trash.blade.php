@extends('admin.layouts.master')

@section('title', 'Thùng rác - Người dùng')

@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title mb-0 me-3">Thùng rác tài khoản</h5>
                                </div>
                                <div>
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                                        <i class="ri-arrow-left-line align-bottom me-1"></i>Quay lại
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong>Thành công!</strong> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-border-left alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <strong>Lỗi!</strong> {{ session('error') }}
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
                                                                    alt="" class="rounded-circle avatar-xs">
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
                                                    <div class="d-flex gap-2">
                                                        <form action="{{ route('admin.users.restore', $user->id) }}" 
                                                              method="POST" 
                                                              class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success">
                                                                <i class="fas fa-undo"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.users.force-delete', $user->id) }}" 
                                                              method="POST" 
                                                              class="d-inline"
                                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn tài khoản này?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">Thùng rác trống.</td>
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

            // Tự động ẩn thông báo sau 5 giây
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
@endsection 
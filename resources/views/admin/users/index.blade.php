@extends('admin.layouts.master')

@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0">
                                            Danh sách 
                                            <b>
                                                {{ isset($role) && $role->name == 'employee' ? 'Nhân viên' : (isset($role) && $role->name == 'user' ? 'Khách hàng' : 'Tất cả người dùng') }}
                                            </b>
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap align-items-start gap-2">
                                        <a href="{{ route('admin.users.create') }}" class="btn btn-success">
                                            <i class="ri-add-line align-bottom me-1"></i>Thêm tài khoản mới
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @if (session('thongbao'))
                                <div id="thongbao-alert"
                                    class="alert alert-{{ session('thongbao.type') }} alert-dismissible bg-{{ session('thongbao.type') }} text-white fade show"
                                    role="alert">
                                    <i class="ri-notification-off-line label-icon"></i>
                                    <strong>{{ session('thongbao.message') }}</strong>
                                </div>
                            @endif

                            <div class="table-responsive mt-2">
                                <table class="table table-hover align-middle" id="userTable">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên</th>
                                            <th>Email</th>
                                            <th>Số điện thoại</th>
                                            <th>Trạng thái</th>
                                            <th>Vai trò</th>  <!-- Cột vai trò thêm vào -->
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('avatar/default.jpeg') }}"
                                                            alt="User Avatar" class="rounded-circle me-2"
                                                            width="40" height="40">
                                                        {{ $user->name }}
                                                    </div>
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone ?? 'Chưa có' }}</td>
                                                <td class="text-center">
                                                    <span class="badge bg-{{ $user->status == 'active' ? 'success' : 'danger' }}">
                                                        {{ $user->status == 'active' ? 'Hoạt động' : 'Ngưng hoạt động' }}
                                                    </span>
                                                </td>
                                                <td>{{ $user->role->name ?? 'Chưa có' }}</td>  <!-- Hiển thị tên vai trò -->
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                                            class="btn btn-warning btn-sm">Sửa</a>

                                                        <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                            method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                Xóa
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">Không có tài khoản nào được tìm thấy.</td>
                                            </tr>
                                        @endforelse
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

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('script')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
                "paging": true,
                "lengthMenu": [10, 20, 50],
                "searching": true,
                "ordering": true,
                "autoWidth": false,
                "responsive": true,
                "info": true,
                "language": {
                    "lengthMenu": "Hiển thị _MENU_ dòng",
                    "zeroRecords": "Không tìm thấy dữ liệu",
                    "info": "Đang hiển thị _START_ đến _END_ của _TOTAL_ mục",
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

        // Tự động đóng thông báo sau 5 giây
        setTimeout(function() {
            var alert = document.getElementById('thongbao-alert');
            if (alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    </script>
@endsection

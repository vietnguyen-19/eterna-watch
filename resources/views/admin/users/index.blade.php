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
                                    <div>
                                        <h5 class="card-title mb-0">Danh sách <b>
                                                {{ $role->name == 'employee' ? 'Nhân viên' : 'Khách hàng' }}</b></h5>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap align-items-start gap-2">
                                        <a href="{{ route('admin.users.create') }}" class="btn btn-success add-btn"><i
                                                class="ri-add-line align-bottom me-1"></i>Thêm tài khoản mới</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div>
                                @if (session('thongbao'))
                                    <div id="thongbao-alert"
                                        class="alert alert-{{ session('thongbao.type') }} alert-dismissible bg-{{ session('thongbao.type') }} text-white alert-label-icon fade show"
                                        role="alert">
                                        <i class="ri-notification-off-line label-icon"></i><strong>
                                            {{ session('thongbao.message') }}</strong>
                                    </div>
                                @endif
                                <div class="table-responsive table-card mb-1 mt-2">
                                    <table class="table align-middle" id="userTable">
                                        <thead class="table-light text-muted">
                                            <tr>
                                                <th class="sort" data-sort="id">ID</th>
                                                <th class="sort" data-sort="name">Tên</th>
                                                <th class="sort" data-sort="email">Email</th>
                                                <th class="sort" data-sort="phone">Số điện thoại</th>
                                                <th class="sort" data-sort="status">Trạng thái</th>
                                                <th class="sort" data-sort="action">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($data as $user)
                                                <tr>
                                                    <td class="id">{{ $user->id }}</td>
                                                    <td class="name">
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ Storage::url($user->avatar ?? 'avatar/default.jpeg') }}"
                                                                alt="User Avatar" class="rounded-circle me-2 mr-2"
                                                                width="40" height="40">
                                                            {{ $user->name }}
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">{{ $user->email }}</td>
                                                    <td class="align-middle">{{ $user->phone ?? 'Chưa có' }}</td>
                                                    <td class="align-middle">{{ $user->status }}</td>


                                                    <td class="align-middle">
                                                        <ul class="list-inline hstack gap-2 mb-0">
                                                            <!-- Edit Button -->
                                                            <li class="list-inline-item edit" title="Chỉnh sửa">
                                                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                                                    class="btn btn-warning btn-icon waves-effect waves-light btn-sm">
                                                                    Sửa
                                                                </a>
                                                            </li>
                                                            <!-- Remove Button -->
                                                            <li class="list-inline-item" title="Xóa">
                                                                <form
                                                                    action="{{ route('admin.users.destroy', $user->id) }}"
                                                                    method="POST" style="display: inline-block;"
                                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-icon waves-effect waves-light btn-sm">
                                                                        Xóa
                                                                    </button>
                                                                </form>

                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-light text-muted">
                                            <tr>
                                                <th class="sort" data-sort="id">ID</th>
                                                <th class="sort" data-sort="name">Tên</th>
                                                <th class="sort" data-sort="email">Email</th>
                                                <th class="sort" data-sort="phone">Số điện thoại</th>
                                                <th class="sort" data-sort="status">Trạng thái</th>
                                                <th class="sort" data-sort="action">Hành động</th>
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
    </section>
@endsection
@section('script')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
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

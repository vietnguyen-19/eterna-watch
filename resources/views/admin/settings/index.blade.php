@extends('admin.layouts.master')

@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    {{-- Hiển thị thông báo --}}
                    @if (session('thongbao'))
                        <div id="thongbao-alert"
                             class="alert alert-{{ session('thongbao.type') }} alert-dismissible bg-{{ session('thongbao.type') }} text-white alert-label-icon fade show"
                             role="alert">
                            <i class="ri-notification-off-line label-icon"></i>
                            <strong>{{ session('thongbao.message') }}</strong>
                        </div>
                        @php session()->forget('thongbao'); @endphp
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <h5 class="card-title mb-0">Danh sách cài đặt</h5>
                                </div>
                                <div class="col-sm-auto">
                                    <a href="{{ route('admin.settings.create') }}" class="btn btn-success add-btn">
                                        <i class="ri-add-line align-bottom me-1"></i>Thêm cài đặt
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered" id="danhmucTable">
                                <thead class="text-muted">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên cài đặt</th>
                                        <th>Nội dung</th>
                                        <th>Kiểu dữ liệu</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($setting as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->key }}</td>
                                            <td>{{ $item->value }}</td>
                                            <td>{{ $item->type }}</td>
                                            <td>
                                                <a href="{{ route('admin.settings.edit', $item->id) }}"
                                                   class="btn btn-warning btn-sm">Sửa</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#danhmucTable').DataTable({
                "paging": true,
                "lengthMenu": [5, 20, 50],
                "searching": true,
                "ordering": true,
                "info": true,
                "language": {
                    "lengthMenu": "Hiển thị _MENU_ dòng",
                    "zeroRecords": "Không tìm thấy dữ liệu",
                    "info": "Hiển thị từ _START_ đến _END_ của _TOTAL_ dòng",
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
        setTimeout(function () {
            var alert = document.getElementById('thongbao-alert');
            if (alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    </script>
@endsection

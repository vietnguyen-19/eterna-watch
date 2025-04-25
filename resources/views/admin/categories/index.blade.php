@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0"><strong>Danh sách danh mục</strong></h5>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap align-items-start gap-2">
                                        <a href="{{ route('admin.categories.trash') }}" class="btn btn-sm btn-danger">
                                            <i class="ri-add-line align-bottom me-1"></i>Thùng rác
                                        </a>
                                        <!-- Nút Thêm danh mục Cha -->
                                        <a href="{{ route('admin.categories.create', ['type' => 'parent']) }}"
                                            class="btn btn-sm btn-success add-btn mr-1 ml-1">
                                            <i class="ri-add-line align-bottom me-1"></i>Thêm danh mục cha
                                        </a>

                                        <!-- Nút Thêm danh mục Con -->
                                        <a href="{{ route('admin.categories.create', ['type' => 'child']) }}"
                                            class="btn btn-sm btn-info add-btn">
                                            <i class="ri-add-line align-bottom me-1"></i>Thêm danh mục con
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6"></div>
                                    <div class="col-sm-12 col-md-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="categoryTable" class="table table-bordered align-middle text-center">
                                            <thead>
                                                <tr>
                                                    <th style="width: 100px;">Hình ảnh</th>
                                                    <th class="text-left">Tên danh mục</th>
                                                    <th>Trạng thái</th>
                                                    <th>Ngày tạo</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($categories as $parent)
                                                    @php
                                                        $childCount = $parent->children->count();
                                                        $rowspan = $childCount > 0 ? $childCount + 1 : 1;
                                                    @endphp
                                                    <tr>
                                                        {{-- Ảnh to hơn, canh giữa --}}
                                                        <td class="align-middle text-center" rowspan="{{ $rowspan }}">
                                                            <div
                                                                class="d-flex justify-content-center align-items-center h-100">
                                                                <img src="{{ Storage::url($parent->image ?? 'default-avatar.png') }}"
                                                                    alt="Hình danh mục" class="rounded border"
                                                                    style="width: 160px; height: 160px; object-fit: cover;">
                                                            </div>
                                                        </td>

                                                        <td class="text-left text-info fw-bold">{{ $parent->name }}</td>
                                                        <td>
                                                            <span
                                                                class="badge {{ $parent->status ? 'badge-success' : 'badge-danger' }}">
                                                                {{ $parent->status ? 'Active' : 'Inactive' }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $parent->created_at->format('Y-m-d') }}</td>

                                                        <td>

                                                            <a href="{{ route('admin.categories.edit', ['id' => $parent->id, 'type' => 'parent']) }}"
                                                                class="btn btn-sm btn-warning" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form
                                                                action="{{ route('admin.categories.destroy', $parent->id) }}"
                                                                method="POST" style="display:inline-block;"
                                                                onsubmit="return confirm('Bạn có chắc chắn muốn thực hiện hành động này không?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-danger" title="Delete">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>

                                                    @foreach ($parent->children as $child)
                                                        <tr>
                                                            <td class="text-left">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳
                                                                {{ $child->name }}
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="badge {{ $child->status ? 'badge-success' : 'badge-danger' }}">
                                                                    {{ $child->status ? 'Active' : 'Inactive' }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $child->created_at->format('Y-m-d') }}</td>
                                                            <td>
                                                                <a href="{{ route('admin.categories.edit', ['id' => $child->id, 'type' => 'child']) }}"
                                                                    class="btn btn-sm btn-warning" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>

                                                                <form
                                                                    action="{{ route('admin.categories.destroy', $child->id) }}"
                                                                    method="POST" style="display:inline-block;"
                                                                    onsubmit="return confirm('Delete this category?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="btn btn-sm btn-danger" title="Delete">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
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
            $('#danhmucTable').DataTable({
                "paging": true, // Bật phân trang
                "lengthMenu": [5, 20, 50], // Số dòng hiển thị mỗi trang
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        </script>
    @endif
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

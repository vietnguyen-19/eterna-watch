@extends('admin.layouts.master')
@section('content')
    <!-- Modal dùng cho Edit và Reply -->
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- Header -->
                        <div class="card-header">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <h5 class="card-title mb-0"><b>Danh sách liên hệ</b></h5>
                                </div>
                                <div class="col-sm-auto">
                                    <a href="{{ route('admin.contacts.trash') }}" class="btn btn-sm btn-danger">
                                        <i class="ri-delete-bin-line align-bottom me-1"></i> Thùng rác
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Tabs -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul class="nav nav-tabs nav-tabs-custom w-100">
                                            <li class="nav-item">
                                                <a class="nav-link {{ $status === 'all' ? 'active' : '' }}"
                                                    href="{{ route('admin.contacts.index', ['status' => 'all']) }}">
                                                    Tất cả
                                                    <span class="badge rounded-pill bg-dark">{{ $statusCounts['all'] }}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link {{ $status === 'new' ? 'active' : '' }}"
                                                    href="{{ route('admin.contacts.index', ['status' => 'new']) }}">
                                                    Mới
                                                    <span class="badge rounded-pill bg-danger">{{ $statusCounts['new'] }}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link {{ $status === 'read' ? 'active' : '' }}"
                                                    href="{{ route('admin.contacts.index', ['status' => 'read']) }}">
                                                    Đã xem
                                                    <span class="badge rounded-pill bg-warning text-dark">{{ $statusCounts['read'] }}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link {{ $status === 'done' ? 'active' : '' }}"
                                                    href="{{ route('admin.contacts.index', ['status' => 'done']) }}">
                                                    Đã xử lý
                                                    <span class="badge rounded-pill bg-primary">{{ $statusCounts['done'] }}</span>
                                                </a>
                                            </li>
                                        </ul>
    
                                        <!-- Table -->
                                        <div class="table-responsive mt-4">
                                            <table class="table table-bordered table-hover" id="contactTable{{ $status }}">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Họ tên</th>
                                                        <th>Email</th>
                                                        <th>Nội dung</th>
                                                        <th>Ngày gửi</th>
                                                        <th>Trạng thái</th>
                                                        <th>Hành động</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($contacts as $contact)
                                                        <tr>
                                                            <td>{{ $contact->id }}</td>
                                                            <td>{{ $contact->name }}</td>
                                                            <td>{{ $contact->email }}</td>
                                                            <td>{{ Str::limit($contact->message, 50) }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($contact->sent_at)->format('d/m/Y H:i') }}</td>
                                                            <td>
                                                                @switch($contact->status)
                                                                    @case('new')
                                                                        <span class="badge bg-danger">Mới</span>
                                                                        @break
                                                                    @case('read')
                                                                        <span class="badge bg-warning text-dark">Đã xem</span>
                                                                        @break
                                                                    @case('done')
                                                                        <span class="badge bg-success">Đã xử lý</span>
                                                                        @break
                                                                @endswitch
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-sm btn-info">
                                                                    Xem
                                                                </a>
                                                                <form action="{{ route('admin.contacts.destroy', $contact->id) }}"
                                                                      method="POST" class="d-inline"
                                                                      onsubmit="return confirm('Bạn có chắc muốn xóa liên hệ này?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="text-center">Không có liên hệ nào.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End card-body -->
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
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    @endsection
    @section('script')
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
        <!-- Bootstrap CSS -->
        <!-- Bootstrap CSS -->

        <!-- Bootstrap JS + Popper -->
        <script></script>
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script>
            // Mảng chứa các ID của các bảng cần áp dụng DataTable
            var tableIds = [
                'contactTableall',
                'contactTablenew',
                'contactTableread',
                'contactTabledone',
                
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
    @endsection

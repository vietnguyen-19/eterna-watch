@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-4"></div>
    <div class="mb-4 pb-lg-3"></div>
    <main style="padding-top: 90px;">
        <div class="mb-4"></div>
        <section class="my-account container py-5">
            <div class="row">
                <div class="col-lg-3">
                    <div class="user-info mb-3"
                        style="display: flex; justify-content: center; padding: 15px; border-bottom: 1px solid #eee; background-color: #f8f9fa; border-radius: 5px 5px 0 0; width: 100%; box-sizing: border-box;">

                        <div class="d-flex flex-column align-items-center text-center p-3">
                            {{-- Avatar có viền --}}
                            <div class="avatar"
                                style="width: 200px; height: 200px; overflow: hidden; border-radius: 50%; border: 6px solid #dee2e6; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar"
                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            </div>

                            {{-- Thông tin căn giữa dưới avatar --}}
                            <h5 class="mt-3 mb-1" style="font-weight: bold;">{{ auth()->user()->name }}</h5>
                            <p class="text-muted" style="margin: 0;">{{ auth()->user()->email }}</p>
                        </div>

                    </div>
                    <nav class="nav flex-column account-sidebar sticky-sidebar">
                        <a href="{{ route('account.order') }}"
                           class="nav-link {{ request()->routeIs('account.order') ? 'active' : '' }}">
                            <i class="fas fa-shopping-bag me-2"></i> Đơn hàng
                        </a>
                        <a href="{{ route('account.re_password') }}"
                           class="nav-link {{ request()->routeIs('account.re_password') ? 'active' : '' }}">
                            <i class="fas fa-key me-2"></i> Cập nhật mật khẩu
                        </a>
                        <a href="{{ route('account.edit') }}"
                           class="nav-link {{ request()->routeIs('account.edit') ? 'active' : '' }}">
                            <i class="fas fa-user me-2"></i> Chi tiết tài khoản
                        </a>
                        <form action="{{ route('client.logout') }}" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="nav-link text-danger logout-btn">
                                <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                            </button>
                        </form>
                    </nav>
                    
                </div>
                <div class="col-lg-9">
                    <div class="content-box p-4">
                        @yield('account_content')
                    </div>
                </div>
            </div>
        </section>
    </main>


    <div class="mb-5 pb-xl-5"></div>
@endsection
@section('script')
    <!-- DataTables CSS -->


    <!-- jQuery và DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#orderTable').DataTable({
                "paging": true, // Bật phân trang
                "searching": true, // Bật tìm kiếm
                "ordering": true, // Bật sắp xếp
                "info": true, // Hiển thị thông tin số dòng
                "lengthMenu": [5, 10, 25, 50], // Chọn số dòng hiển thị
                "language": {
                    "sProcessing": "Đang xử lý...",
                    "sLengthMenu": "Hiển thị _MENU_ dòng",
                    "sZeroRecords": "Không tìm thấy kết quả nào",
                    "sInfo": "Hiển thị _START_ đến _END_ của _TOTAL_ dòng",
                    "sInfoEmpty": "Hiển thị 0 đến 0 của 0 dòng",
                    "sInfoFiltered": "(lọc từ _MAX_ dòng)",
                    "sSearch": "Tìm kiếm:",
                    "oPaginate": {
                        "sFirst": "Đầu",
                        "sLast": "Cuối",
                        "sNext": "Tiếp",
                        "sPrevious": "Trước"
                    }
                }
            });
        });
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        #orderTable thead th {
            background-color: #9e9e9e !important;
            color: rgb(31, 31, 31) !important;
            text-transform: uppercase;
        }

        .account-sidebar .nav-link {
            font-size: 16px;
            padding: 12px 18px;
            border-radius: 3px;
            background: #fdfdfd;
            transition: all 0.3s ease-in-out;
            display: flex;
            align-items: center;
            color: #333;
            font-weight: 500;
        }

        .account-sidebar .nav-link i {
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .account-sidebar .nav-link:hover {
            background: #ececec;
            padding-left: 22px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .account-sidebar .nav-link.active {
            background: #e84040;
            color: #ffffff;
            font-weight: bold;
        }

        /* Hiệu ứng hover cho liên kết */
        .link-hover {
            transition: color 0.3s ease-in-out;
        }

        .link-hover:hover {
            color: #0d47a1 !important;
            text-decoration: underline;
        }

        /* Nội dung chính */
        .content-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 24px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .logout-btn {
            background: none;
            border: none;
            text-align: left;
            width: 100%;
            padding: 12px 18px;
            transition: background-color 0.3s, padding-left 0.3s;
            font-size: 16px;
            color: #d3401f !important;
            font-weight: bold;
        }

        .logout-btn:hover {
            background: #fff5f5;
            padding-left: 22px;
        }

        /* Responsive tối ưu */
        @media (max-width: 768px) {
            .container {
                max-width: 100%;
            }

            .nav {
                border-bottom: 1px solid #ddd;
            }

            .content-box {
                margin-top: 20px;
            }
        }
    </style>
@endsection

@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-4"></div>
    <main style="padding-top: 90px;">
        <div class="mb-4"></div>
        <section class="my-account container py-5">
            <div class="row">
                <div class="col-lg-3">
                    <nav class="nav flex-column">
                        <a href="{{ route('account.dashboard') }}" class="nav-link text-dark fw-semibold">Bảng điều
                            khiển</a>
                        <a href="{{ route('account.order') }}" class="nav-link text-dark active">Đơn hàng</a>
                        <a href="{{ route('account.address') }}" class="nav-link text-dark">Địa chỉ</a>
                        <a href="{{ route('account.detail') }}" class="nav-link text-dark">Chi tiết tài khoản</a>
                        <a href="{{ route('account.wishlist') }}" class="nav-link text-dark">Danh sách yêu thích</a>

                        <form action="{{ route('client.logout') }}" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="nav-link fw-semibold text-danger logout-btn">Đăng xuất</button>
                        </form>
                    </nav>
                </div>
                <div class="col-lg-9">
                    <table id="orderTable" class="table table-bordered align-middle">
                        <thead style="background-color: #aeaeae">
                            <tr>
                                <th scope="col">Mã đơn hàng</th>
                                <th scope="col">Ngày đặt</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Thanh toán</th>
                                <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td><strong>{{ $order->order_code }}</strong></td>
                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge text-white px-3 py-1"
                                            style="background-color: 
                                            {{ $order->status == 'pending'
                                                ? '#f0ad4e'
                                                : ($order->status == 'completed'
                                                    ? '#28a745'
                                                    : ($order->status == 'cancelled'
                                                        ? '#dc3545'
                                                        : '#6c757d')) }} !important;">
                                            {{ $order->status }}
                                        </span>

                                    </td>
                                    <td>{{ number_format($order->total_amount, 0, ',', '.') }}đ với
                                        {{ $order->orderItems->count() }} sản phẩm</td>

                                    <td>
                                        <a style="background-color: #188cc6; color:#fff; border-radius:3px" href="{{ route('account.order_detail', $order->id) }}"
                                            class="btn btn-sm">
                                            Chi tiết
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


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
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        .nav-link {
            font-size: 16px;
            padding: 12px 16px;
            transition: background-color 0.3s ease, padding-left 0.3s ease;
            background: rgb(255, 243, 243);
        }

        .nav-link:hover {
            background: #f0f0f0;
            padding-left: 20px;
        }

        .nav-link.active {
            background: hsl(0, 87%, 94%);
            font-weight: bold;
            color: #d3401f !important;
            border-left: 3px solid #fda3a3;
        }

        /* Hiệu ứng hover cho các liên kết */
        .link-hover {
            transition: color 0.3s ease-in-out;
        }

        .link-hover:hover {
            color: #0d47a1 !important;
            text-decoration: underline;
        }

        /* Bố cục nội dung đẹp hơn */
        .content-box {
            background: white;
            border-radius: 8px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .logout-btn {
            background: none;
            border: none;
            text-align: left;
            width: 100%;
            padding: 12px 16px;
            transition: background-color 0.3s, padding-left 0.3s;
            font-size: 16px;
            color: #c61a18 !important;
            background: rgb(255, 243, 243);
        }

        .logout-btn:hover {
            background: #f5f5f5;
            padding-left: 18px;
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

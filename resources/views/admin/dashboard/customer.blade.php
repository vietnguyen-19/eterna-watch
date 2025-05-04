@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid p-4">
        <div class="row">
            <!-- Thanh điều hướng -->
            <div class="col-12 mb-3">
                <div class="tab-menu">
                    <a href="{{ route('admin.dashboard.revenue') }}" class="tab-item">Doanh thu</a>
                    <a href="{{ route('admin.dashboard.revenue') }}" class="tab-item tab-active">Khách hàng</a>
                    <a href="{{ route('admin.dashboard.stock') }}" class="tab-item">Hết hàng</a>
                </div>
            </div>

            <div class="col-12">
                @php
                    $currentFilter = request('filter');
                    $fromDate = request('from_date');
                    $toDate = request('to_date');
                    $isDateRangeSelected = !empty($fromDate) || !empty($toDate);

                    // Kiểm tra nếu người dùng chọn khoảng ngày trước
                    if (!empty($fromDate) && !empty($toDate)) {
                        $title =
                            'Từ ' . date('d/m/Y', strtotime($fromDate)) . ' đến ' . date('d/m/Y', strtotime($toDate));
                    } elseif (!empty($fromDate)) {
                        $title = 'Từ ' . date('d/m/Y', strtotime($fromDate));
                    } elseif (!empty($toDate)) {
                        $title = 'Đến ' . date('d/m/Y', strtotime($toDate));
                    } elseif ($currentFilter == 'today') {
                        $title = 'Hôm nay';
                    } elseif ($currentFilter == 'week') {
                        $title = 'Tuần này';
                    } elseif ($currentFilter == 'month') {
                        $title = 'Tháng này';
                    } elseif ($currentFilter == 'year') {
                        $title = 'Năm nay';
                    } else {
                        $title = 'Tất cả'; // Mặc định nếu không có thông tin gì
                    }
                @endphp

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 text-dark">Thống kê tài khoản</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-start flex-wrap mb-4">
                            <a href="{{ route('admin.dashboard.customer', ['filter' => 'month']) }}"
                                class="btn btn-outline-secondary {{ !$isDateRangeSelected && ($currentFilter == 'month' || $currentFilter == '') ? 'active bg-primary text-white border-primary' : '' }}"
                                style="border-radius: 0; height: 2.5rem;">
                                Tháng này
                            </a>
                            <a href="{{ route('admin.dashboard.customer', ['filter' => 'today']) }}"
                                class="btn btn-outline-secondary {{ $currentFilter == 'today' ? 'active bg-primary text-white border-primary' : '' }}"
                                style="border-radius: 0; height: 2.5rem;">
                                Hôm nay
                            </a>
                            <a href="{{ route('admin.dashboard.customer', ['filter' => 'week']) }}"
                                class="btn btn-outline-secondary {{ $currentFilter == 'week' ? 'active bg-primary text-white border-primary' : '' }}"
                                style="border-radius: 0; height: 2.5rem;">
                                Tuần này
                            </a>
                            <a href="{{ route('admin.dashboard.customer', ['filter' => 'year']) }}"
                                class="btn btn-outline-secondary {{ $currentFilter == 'year' ? 'active bg-primary text-white border-primary' : '' }}"
                                style="border-radius: 0; height: 2.5rem;">
                                Năm
                            </a>
                            <a href="{{ route('admin.dashboard.customer', ['filter' => 'all']) }}"
                                class="btn btn-outline-secondary mr-5 {{ $currentFilter == 'all' ? 'active bg-primary text-white border-primary' : '' }}"
                                style="border-radius: 0; height: 2.5rem;">
                                Tất cả
                            </a>
                            <form action="{{ route('admin.dashboard.customer') }}" method="GET"
                                class="d-flex align-items-center gap-2">
                                <input type="hidden" name="filter" value="custom">
                                <span class="text-muted px-2">Từ </span>
                                <input class="form-control form-control-sm" type="date" name="from_date"
                                    value="{{ $fromDate }}" style="max-width: 150px; height: 2.5rem;">
                                <span class="text-muted px-2">đến</span>
                                <input class="form-control form-control-sm" type="date" name="to_date"
                                    value="{{ $toDate }}" style="max-width: 150px; height: 2.5rem;">
                                <button type="submit" class="btn btn-primary btn-sm"
                                    style="height: 2.5rem; border-radius: 0;">Xem</button>
                            </form>
                        </div>
                        <div class="bg-light rounded-md p-3">
                            <h5 class="mb-0 text-dark">Thống kê tài khoản: <span
                                    class="fw-semibold">{{ $title }}</span></h5>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-4">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ number_format($totalCustomers) }}</h3>
                        <p>Tổng số tài khoản</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                    <a style="border-radius: 4px" href="#" class="small-box-footer bg-info">
                    </a>
                </div>
            </div>
            <div class="col-lg-4">

                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ number_format($successfulOrders) }}</h3>
                        <p>Tổng số đơn hàng thành công</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a style="border-radius: 4px" href="#" class="small-box-footer bg-success">
                    </a>
                </div>
            </div>
            <div class="col-lg-4">

                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ number_format($totalRevenue) }}đ</h3>
                        <p>Tổng doanh thu</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a style="border-radius: 4px" href="#" class="small-box-footer">
                    </a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card bg-gradient-primary">
                    <div class="card-header border-0 ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            Biểu đồ doanh thu
                        </h3>
                        <!-- card tools -->
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse"
                                title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <div class="card-body bg-white">
                        <canvas id="chartDoanhThu"></canvas>
                    </div>
                    <!-- /.card-body-->
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-info ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title align-middle">
                            Danh sách khách hàng
                        </h3>
                        <!-- card tools -->
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse"
                                title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <div class="card-body bg-white">
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered" id="orderTable">
                                <thead>
                                    <tr>
                                        <th>Tên</th>
                                        <th>Email</th>
                                        <th>Số đơn hàng đã đặt</th>
                                        <th>Số đơn hàng thành công</th>
                                        <th style="width: 15%;">Tổng tiền đã chi tiêu</th>
                                        <th style="width: 15%;">Ngày đăng ký</th>
                                        <th style="width: 10%;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($customers as $customer)
                                        <tr>
                                            <td class="align-middle"><strong>{{ $customer->name }}</strong></td>
                                            <td class="align-middle">{{ $customer->email }}</td>
                                            <td class="align-middle">{{ $customer->total_orders }}</td>
                                            <td class="align-middle">{{ $customer->total_completed_orders }}</td>
                                            <td class="align-middle">
                                                {{ number_format($customer->total_spent, 0, ',', '.') }} đ
                                            </td>
                                            <td class="align-middle">{{ $customer->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#orderModal_{{ $customer->id }}">
                                                        Chi tiết
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Không có khách hàng nào</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @foreach ($customers as $customer)
                                <div class="modal fade" id="orderModal_{{ $customer->id }}" tabindex="-1"
                                    aria-labelledby="orderModalLabel_{{ $customer->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="orderModalLabel_{{ $customer->id }}">
                                                    Danh Sách Đơn Hàng - {{ $customer->name }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Mã Đơn Hàng</th>
                                                            <th>Tổng Tiền</th>
                                                            <th>Trạng Thái</th>
                                                            <th>Ngày Đặt</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($customer->orders as $order)
                                                            <tr>
                                                                <td>{{ $order->order_code }}</td>
                                                                <td>{{ number_format($order->total_amount, 0, ',', '.') }}
                                                                    đ</td>
                                                                <td class="align-middle">
                                                                    @switch($order->status)
                                                                        @case('pending')
                                                                            <span class="badge bg-warning text-dark">Chờ xử
                                                                                lý</span>
                                                                        @break

                                                                        @case('completed')
                                                                            <span class="badge bg-success">Hoàn thành</span>
                                                                        @break

                                                                        @case('cancelled')
                                                                            <span class="badge bg-danger">Đã hủy</span>
                                                                        @break

                                                                        @default
                                                                            <span class="badge bg-secondary">Không xác định</span>
                                                                    @endswitch
                                                                </td>

                                                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                                            </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="4" class="text-center">Không có đơn hàng
                                                                        nào</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- /.card-body-->
                    </div>
                </div>
            </div>
        </div>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    @endsection

    @section('style')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
        <style>
            .tab-menu {
                display: flex;
                justify-content: center;
                background: #fff;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                padding: 12px;
                border-radius: 8px;
                gap: 10px;
            }

            .tab-item {
                flex: 1;
                text-align: center;
                padding: 10px 15px;
                font-weight: 600;
                color: #6c757d;
                text-decoration: none;
                border-bottom: 2px solid transparent;
                transition: all 0.3s ease;
            }

            .tab-item:hover {
                color: #0d6efd;
                border-bottom: 2px solid #0d6efd;
            }

            .tab-active {

                color: #0d6efd;
                border-bottom: 3px solid #0d6efd;
                font-weight: bold;
                background: rgb(237, 237, 237)
            }

            .btn.active {
                background-color: #03a990 !important;
                color: white !important;
            }


            #chartDoanhThu {
                max-width: 100% !important;
                height: 100% !important;
            }

            canvas {
                width: 100% !important;
                height: 300px !important;
            }
        </style>
        <!-- Bootstrap 5 CSS CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @endsection

    @section('script')
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

        <script>
            $(document).ready(function() {
                if ($('#orderTable tbody tr').length > 1) { // Chỉ khởi tạo DataTables khi có dữ liệu
                    $('#orderTable').DataTable({
                        "paging": true,
                        "lengthMenu": [25, 50, 100],
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
                }
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
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var ctx = document.getElementById('chartDoanhThu').getContext('2d');

                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($labels), // Trục X: ngày/tháng
                        datasets: [{
                            label: 'Số tài khoản đăng ký',
                            data: @json($dataCustomers), // Dữ liệu số lượng tài khoản
                            borderColor: 'blue',
                            backgroundColor: 'rgba(0, 0, 255, 0.2)', // Màu nền với độ trong suốt
                            borderWidth: 2,
                            pointRadius: 5, // Kích thước điểm dữ liệu
                            pointBackgroundColor: 'blue', // Màu của điểm dữ liệu
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false, // Giúp tùy chỉnh chiều cao dễ dàng
                        plugins: {
                            title: {
                                display: true,
                                text: 'Biểu đồ số tài khoản đăng ký mới',
                                font: {
                                    size: 18
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let value = context.raw || 0;
                                        return ' ' + value;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Thời gian',
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Số tài khoản',
                                    font: {
                                        size: 14
                                    }
                                },
                                ticks: {
                                    stepSize: 1, // Bước nhảy tối thiểu là 1 (không có số lẻ)
                                    callback: function(value) {
                                        return value;
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endsection

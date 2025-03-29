@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid p-4">
        <div class="row">
            <!-- Thanh điều hướng -->
            <div class="col-12 mb-3">
                <div class="tab-menu">
                    <a href="{{ route('admin.dashboard.revenue') }}" class="tab-item tab-active">Doanh thu</a>
                    <a href="{{ route('admin.dashboard.customer') }}" class="tab-item">Khách hàng</a>
                    <a href="{{ route('admin.dashboard.stock') }}" class="tab-item">Kho hàng</a>
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
                    <div class="card-header">
                        <div class="d-flex justify-content-left gap-2 flex-wrap">
                            <a href="{{ route('admin.dashboard.revenue', ['filter' => 'all']) }}"
                                class="btn btn-light border {{ !$isDateRangeSelected && ($currentFilter == 'all' || $currentFilter == '') ? 'active' : '' }}">
                                Tất cả
                            </a>
                            <a href="{{ route('admin.dashboard.revenue', ['filter' => 'today']) }}"
                                class="btn btn-light border {{ $currentFilter == 'today' ? 'active' : '' }}">
                                Hôm nay
                            </a>
                            <a href="{{ route('admin.dashboard.revenue', ['filter' => 'week']) }}"
                                class="btn btn-light border {{ $currentFilter == 'week' ? 'active' : '' }}">
                                Tuần này
                            </a>
                            <a href="{{ route('admin.dashboard.revenue', ['filter' => 'month']) }}"
                                class="btn btn-light border {{ $currentFilter == 'month' ? 'active' : '' }}">
                                Tháng này
                            </a>
                            <a href="{{ route('admin.dashboard.revenue', ['filter' => 'year']) }}"
                                class="btn btn-light border {{ $currentFilter == 'year' ? 'active' : '' }}">
                                Năm
                            </a>
                            <form action="{{ route('admin.dashboard.revenue') }}" method="GET"
                                class="d-flex align-items-center">
                                <input class="form-control form-control-sm mx-2" type="date" name="from_date"
                                    value="{{ $fromDate }}">
                                <span>-</span>
                                <input class="form-control form-control-sm mx-2" type="date" name="to_date"
                                    value="{{ $toDate }}">
                                <button type="submit" class="btn btn-primary btn-sm">Xem</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-header">
                        <h5 class="mb-0">Thống kê doanh thu: <b>{{ $title }}</b></h5>
                    </div>
                </div>
            </div>


            <div class="col-lg-4">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3 class="">{{ number_format($totalRevenue) }} đ</h3>
                        <p>Tổng doanh thu</p>
                    </div>
                    <a href="#" class="small-box-footer">

                    </a>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ number_format($totalOrders) }}</h3>
                        <p>Số đơn hàng</p>
                    </div>
                    <a style="border-radius: 4px" href="#" class="small-box-footer">
                    </a>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 class="">{{ number_format($successfulOrders) }}</h3>
                        <p>Đơn thành công</p>
                    </div>
                    <a style="border-radius: 4px" href="#" class="small-box-footer">
                    </a>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 >{{ number_format($failedOrders) }}</h3>
                        <p>Đơn thất bại</p>
                    </div>
                    <a style="border-radius: 4px" href="#" class="small-box-footer">
                    </a>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 >{{ number_format($pendingOrders) }}</h3>
                        <p>Đang xử lý</p>
                    </div>
                    <a style="border-radius: 4px" href="#" class="small-box-footer">
                    </a>
                </div>
            </div>

            <!-- Biểu đồ doanh thu (col-9) -->
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
                <div class="card bg-gradient-success">
                    <div class="card-header border-0 ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            Danh sách đơn hàng
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
                                        <th style="width: 4%">
                                            <input type="checkbox" id="checkAll" class="align-middle">
                                        </th>
                                        <th>ID</th>
                                        <th>Mã đơn hàng</th>
                                        <th>Khách hàng</th>
                                        <th style="width: 15%;">Tổng tiền</th>
                                        <th style="width: 12%;">Trạng thái</th>
                                        <th style="width: 15%;">Ngày tạo</th>
                                        <th style="width: 15%;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                        <tr>
                                            <td class="align-middle">
                                                <input type="checkbox" class="checkbox-item"
                                                    value="{{ $order->id }}">
                                            </td>
                                            <td class="align-middle">{{ $order->id }}</td>
                                            <td class="align-middle">
                                                <strong>{{ $order->order_code }}</strong>
                                            </td>
                                            <td class="align-middle">
                                                {{ $order->user->name ?? 'Khách vãng lai' }}</td>
                                            <td class="align-middle">
                                                {{ number_format($order->total_amount, 0, ',', '.') }}
                                                đ</td>
                                            <td class="align-middle">
                                                @switch($order->status)
                                                    @case('pending')
                                                        <span class="badge bg-warning text-dark">Chờ xử
                                                            lý</span>
                                                    @break

                                                    @case('processing')
                                                        <span class="badge bg-primary">Đang xử lý</span>
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
                                            <td class="align-middle">
                                                {{ $order->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <a href="#" class="btn btn-info btn-sm">
                                                        Chi tiết
                                                    </a>

                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Không có đơn hàng nào
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>ID</th>
                                            <th>Mã đơn hàng</th>
                                            <th>Khách hàng</th>
                                            <th>Tổng tiền</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
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
                            label: 'Doanh thu (VNĐ)',
                            data: @json($dataDoanhThu), // Giá trị doanh thu
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
                                text: 'Biểu đồ Doanh Thu',
                                font: {
                                    size: 18
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let value = context.raw || 0;
                                        return ' ' + new Intl.NumberFormat('vi-VN', {
                                            style: 'currency',
                                            currency: 'VND'
                                        }).format(value);
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
                                    text: 'Doanh thu (VNĐ)',
                                    font: {
                                        size: 14
                                    }
                                },
                                ticks: {
                                    callback: function(value) {
                                        return new Intl.NumberFormat('vi-VN').format(value) + ' đ';
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endsection

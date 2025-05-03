@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid p-4">
        <div class="row">
            <!-- Thanh điều hướng -->
            <div class="col-12 mb-3">
                <div class="tab-menu">
                    <a href="{{ route('admin.dashboard.revenue') }}" class="tab-item tab-active">Doanh thu</a>
                    <a href="{{ route('admin.dashboard.customer') }}" class="tab-item">Khách hàng</a>
                    <a href="{{ route('admin.dashboard.stock') }}" class="tab-item">Sản phẩm săp hết</a>
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
                    <div class="card-body">
                        <div class="d-flex justify-content-start gap-2 flex-wrap mb-4">
                            <a href="{{ route('admin.dashboard.revenue', ['filter' => 'all']) }}"
                                class="btn btn-outline-secondary {{ !$isDateRangeSelected && ($currentFilter == 'all' || $currentFilter == '') ? 'active bg-primary text-white border-primary' : '' }}"
                                style="border-radius: 0; height: 2.5rem;">
                                Tất cả
                            </a>
                            <a href="{{ route('admin.dashboard.revenue', ['filter' => 'today']) }}"
                                class="btn btn-outline-secondary {{ $currentFilter == 'today' ? 'active bg-primary text-white border-primary' : '' }}"
                                style="border-radius: 0; height: 2.5rem;">
                                Hôm nay
                            </a>
                            <a href="{{ route('admin.dashboard.revenue', ['filter' => 'week']) }}"
                                class="btn btn-outline-secondary {{ $currentFilter == 'week' ? 'active bg-primary text-white border-primary' : '' }}"
                                style="border-radius: 0; height: 2.5rem;">
                                Tuần này
                            </a>
                            <a href="{{ route('admin.dashboard.revenue', ['filter' => 'month']) }}"
                                class="btn btn-outline-secondary {{ $currentFilter == 'month' ? 'active bg-primary text-white border-primary' : '' }}"
                                style="border-radius: 0; height: 2.5rem;">
                                Tháng này
                            </a>
                            <a href="{{ route('admin.dashboard.revenue', ['filter' => 'year']) }}"
                                class="btn btn-outline-secondary {{ $currentFilter == 'year' ? 'active bg-primary text-white border-primary' : '' }}"
                                style="border-radius: 0; height: 2.5rem;">
                                Năm
                            </a>
                            <form action="{{ route('admin.dashboard.revenue') }}" method="GET"
                                class="d-flex align-items-center gap-2">
                                @csrf
                                <input type="hidden" name="filter" value="custom">
                                <span class="text-muted px-2">Từ </span>
                                <input class="form-control form-control-sm" type="date" name="from_date"
                                    value="{{ $fromDate }}" style="max-width: 150px; height: 2.5rem;">
                                <span class="text-muted px-2">đến </span>
                                <input class="form-control form-control-sm" type="date" name="to_date"
                                    value="{{ $toDate }}" style="max-width: 150px; height: 2.5rem;">
                                <button type="submit" class="btn btn-primary btn-sm"
                                    style="height: 2.5rem; border-radius: 0;">Xem</button>
                            </form>
                        </div>
                        <div class="bg-light rounded-md p-3">
                            <h5 class="mb-0 text-dark">Thống kê doanh thu: <span
                                    class="fw-semibold">{{ $title }}</span></h5>
                        </div>
                    </div>
                </div>

            </div>


            <div class="col-lg-4">
                <a href="#" class="text-decoration-none">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3 class="">{{ number_format($totalRevenue) }} đ</h3>
                            <p>Tổng doanh thu</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="small-box-footer">
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-2">
                <a href="{{ route('admin.orders.index', ['status' => 'all']) }}" class="text-decoration-none">
                    <div class="small-box bg-info" style="border-radius: 4px;">
                        <div class="inner">
                            <h3>{{ number_format($totalOrders) }}</h3>
                            <p>Số đơn hàng</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="small-box-footer" style="border-radius: 4px;">
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-2">
                <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="text-decoration-none">
                    <div class="small-box bg-success" style="border-radius: 4px;">
                        <div class="inner">
                            <h3 class="">{{ number_format($successfulOrders) }}</h3>
                            <p>Đơn thành công</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="small-box-footer" style="border-radius: 4px;">
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-2">
                <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="text-decoration-none">
                    <div class="small-box bg-danger" style="border-radius: 4px;">
                        <div class="inner">
                            <h3>{{ number_format($failedOrders) }}</h3>
                            <p>Đơn thất bại</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="small-box-footer" style="border-radius: 4px;">
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-2">
                <a href="#" class="text-decoration-none">
                    <div class="small-box bg-warning" style="border-radius: 4px;">
                        <div class="inner">
                            <h3>{{ number_format($pendingOrders) }}</h3>
                            <p>Đang xử lý</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-spinner"></i>
                        </div>
                        <div class="small-box-footer" style="border-radius: 4px;">
                        </div>
                    </div>
                </a>
            </div>

            <!-- Biểu đồ doanh thu (col-9) -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title text-info">
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
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title text-info">Danh sách đơn hàng trong khoảng thời gian được chọn</h3>
                        
                    </div>
                    <div class="card-body bg-white">
                        <div class="table-responsive mt-3">
                            <table class="table table-hover table-bordered" id="orderTable">
                                <thead>
                                    <tr class="text-center text-uppercase">
                                      
                                        <th>ID</th>
                                        <th>Mã đơn hàng</th>
                                        <th>Khách hàng</th>
                                     
                                        <th style="width: 12%;">Trạng thái</th>
                                        <th style="width: 15%;">Ngày tạo</th>
                                        <th style="width: 15%;">Tổng tiền</th>
                                        <th style="width: 10%;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                        <tr class="align-middle">
                                            <td class="text-left">{{ $order->id }}</td>
                                            <td><strong>{{ $order->order_code }}</strong></td>
                                            <td>{{ $order->user->name ?? 'Khách vãng lai' }}</td>
                                          
                                            <td>
                                                @switch($order->status)
                                                    @case('pending')
                                                        <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                                    @break

                                                    @case('confirmed')
                                                        <span class="badge bg-warning text-dark">Đã xác nhận</span>
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
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ number_format($order->total_amount, 0, ',', '.') }} đ</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-info" title="Chi tiết đơn hàng">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                            
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-muted">Không có đơn hàng nào</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Thống kê sản phẩm --}}
                <style>
                    .top-1 { background-color: #fff3cd !important; font-weight: bold; border-left: 4px solid #ffc107; }
                    .top-2 { background-color: #fff8e1 !important; font-weight: bold; border-left: 4px solid #ffecb3; }
                    .top-3 { background-color: #fffde7 !important; font-weight: bold; border-left: 4px solid #fff59d; }
                </style>
                
                <div class="col-lg-6 mt-4">
                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title text-info mb-0">Top sản phẩm bán chạy</h3>
                          
                        </div>
                        <div class="card-body bg-white">
                            @if (count($products) > 0)
                                <div class="table-responsive mt-2">
                                    <table class="table table-hover table-bordered table-sm">
                                        <thead class="text-center text-uppercase bg-light">
                                            <tr>
                                                <th style="width:5%">STT</th>
                                                <th class="text-left">Tên sản phẩm</th>
                                                <th>Số lượng bán</th>
                                                <th class="text-right">Doanh thu</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                usort($products, fn($a, $b) => $b['quantity'] - $a['quantity']);
                                                $top10Products = array_slice($products, 0, 10);
                                            @endphp
                                            @foreach ($top10Products as $index => $product)
                                                @php
                                                    $topClass = match(true) {
                                                        $index === 0 => 'top-1',
                                                        $index === 1 => 'top-2',
                                                        $index === 2 => 'top-3',
                                                        default => ''
                                                    };
                                                @endphp
                                                <tr class="text-center {{ $topClass }}">
                                                    <td>{{ $index + 1 }}</td>
                                                    <td class="text-left">{{ $product['product_name'] ?? 'N/A' }}</td>
                                                    <td>{{ $product['quantity'] }}</td>
                                                    <td class="text-right">{{ number_format($product['total_price'], 0, ',', '.') }} đ</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">Không có sản phẩm nào để hiển thị.</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mt-4">
                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title text-info mb-0">Top khách hàng</h3>
                           
                        </div>
                        <div class="card-body bg-white">
                            @if (isset($top10Users) && count($top10Users) > 0)
                                <div class="table-responsive mt-2">
                                    <table class="table table-hover table-bordered table-sm">
                                        <thead class="text-center bg-light text-uppercase">
                                            <tr>
                                                <th>#</th>
                                                <th class="text-left">Tên Người Dùng</th>
                                                <th class="text-right">Tổng Doanh Thu</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($top10Users as $index => $user)
                                                @php
                                                    $topClass = match(true) {
                                                        $index === 0 => 'top-1',
                                                        $index === 1 => 'top-2',
                                                        $index === 2 => 'top-3',
                                                        default => ''
                                                    };
                                                @endphp
                                                <tr class="text-center {{ $topClass }}">
                                                    <td>{{ $index + 1 }}</td>
                                                    <td class="text-left">{{ $user->name }}</td>
                                                    <td class="text-right">{{ number_format($user->total_revenue) }} đ</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">Không có dữ liệu để hiển thị.</p>
                            @endif
                        </div>
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
                // Khởi tạo DataTables cho các bảng được chỉ định
                ['#orderTable', '#productTable'].forEach(function(tableId) {
                    if ($(tableId + ' tbody tr').length > 1) {
                        $(tableId).DataTable({
                            "paging": true,
                            "lengthMenu": [10, 25, 100],
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

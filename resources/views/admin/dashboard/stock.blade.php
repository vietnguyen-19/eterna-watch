@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid p-4">
        <div class="row">
            <!-- Thanh điều hướng -->
            <div class="col-12 mb-3">
                <div class="tab-menu">
                    <a href="{{ route('admin.dashboard.revenue') }}" class="tab-item">Doanh thu</a>
                    <a href="{{ route('admin.dashboard.revenue') }}" class="tab-item">Khách hàng</a>
                    <a href="{{ route('admin.dashboard.stock') }}" class="tab-item tab-active">Hết hàng</a>
                </div>
            </div>


            <div class="col-lg-12">
                <div class="card bg-gradient-light">
                    <div class="card-header border-0 ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            Danh sách sản phẩm sắp hết hàng
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
                            <table class="table table-bordered display" id="productTable">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th class="sort" data-sort="id">ID</th>
                                        <th class="sort" data-sort="status">Sản phẩm gốc</th>
                                        <th class="sort" data-sort="product">Biến thể</th>
                                        <th class="sort" data-sort="phone">Số lượng hiện tại</th>
                                        <th class="sort" data-sort="created_at">Trạng thái</th>
                                        <th class="sort" data-sort="action">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($variants as $variant)
                                        <tr>
                                            <td class="align-middle">{{ $variant->id }}</td>

                                            <!-- Sản phẩm gốc -->
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ Storage::url($variant->image ?? 'default-product.png') }}"
                                                        alt="product Avatar" class="me-3 rounded" width="50"
                                                        height="50">
                                                    <div class="ml-3">
                                                        {{-- Sản phẩm gốc --}}
                                                        @if ($variant->product)
                                                            <a href="{{ route('admin.products.show', $variant->product->id) }}"
                                                                class="text-decoration-none fw-bold">
                                                                {{ $variant->product->name }}
                                                            </a><br>
                                                            <small class="text-muted mb-0">Danh mục |
                                                                <b>{{ $variant->product->category->name ?? 'Không có' }}</b>
                                                            </small>
                                                        @else
                                                            <span class="text-danger">Sản phẩm đã xóa</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Biến thể (Thuộc tính) -->
                                            <td class="align-middle">
                                                @if ($variant->attributeValues->isNotEmpty())
                                                    @foreach ($variant->attributeValues as $attr)
                                                        <span>{{ $attr->nameValue->attribute->attribute_name }}</span>:
                                                        <span>{{ $attr->nameValue->value_name }}</span><br>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">Không có</span>
                                                @endif
                                            </td>

                                            <!-- Số lượng tồn kho -->
                                            <td class="align-middle text-danger fw-bold">
                                                {{ $variant->stock }}
                                            </td>

                                            <!-- Trạng thái (Out of Stock nếu stock = 0) -->
                                            <td class="align-middle">
                                                <span
                                                    class="badge 
                                                    @if ($variant->stock == 0) bg-danger
                                                    @elseif($variant->stock < 5) bg-warning
                                                    @else bg-success @endif">
                                                    {{ $variant->stock == 0 ? 'Hết hàng' : 'Sắp hết' }}
                                                </span>
                                            </td>

                                            <!-- Hành động -->
                                            <td class="align-middle">
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <!-- Xem chi tiết -->
                                                    <li class="list-inline-item edit" title="Xem chi tiết biến thể">
                                                        {{-- Hành động --}}
                                                        @if ($variant->product)
                                                            <a href="{{ route('admin.products.show', $variant->product->id) }}"
                                                                class="btn btn-info btn-icon waves-effect waves-light btn-sm">
                                                                <i class="fa-solid fa-circle-info"></i>
                                                            </a>
                                                        @else
                                                            <span class="text-danger">Không khả dụng</span>
                                                        @endif
                                                    </li>
                                                    <!-- Xóa -->
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
            $('#productTable').DataTable({
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

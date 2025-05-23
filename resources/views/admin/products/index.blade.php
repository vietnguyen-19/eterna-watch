@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @if (session('thongbao'))
                        <div id="thongbao-alert"
                            class="alert alert-{{ session('thongbao.type') }} alert-dismissible bg-{{ session('thongbao.type') }} text-white alert-label-icon fade show"
                            role="alert">
                            <i class="ri-notification-off-line label-icon"></i><strong>
                                {{ session('thongbao.message') }}</strong>

                        </div>
                        @php
                            session()->forget('thongbao');
                        @endphp
                    @endif
                    <div class="card" id="customerList">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center justify-content-between">
                                <div class="col-sm">
                                    <h5 class="card-title mb-0">Danh sách sản phẩm</h5>
                                </div>
                                <div class="col-sm-auto">
                                    <a href="{{ route('admin.products.trash') }}" class="btn btn-sm btn-danger"
                                        title="Thùng rác">
                                        <i class="ri-delete-bin-line align-bottom me-1"></i>
                                        Thùng rác
                                    </a>
                                    <div class="btn-group" role="group">

                                        <a href="{{ route('admin.products.create', ['type' => 'simple']) }}"
                                            class="btn btn-sm btn-success me-2" title="Thêm sản phẩm thường">
                                            <i class="ri-add-line align-bottom me-1"></i>
                                            Thêm sản phẩm thường
                                        </a>
                                        <a href="{{ route('admin.products.create', ['type' => 'variant']) }}"
                                            class="btn btn-sm btn-primary" title="Thêm sản phẩm có biến thể">
                                            <i class="ri-add-line align-bottom me-1"></i>
                                            Thêm sản phẩm có biến thể
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card-body">
                            <div>
                                <div class="table-responsive table-card mb-1 mt-2">
                                    <table class="table table-bordered display" id="productTable">
                                        <thead class="table-light text-muted">
                                            <tr>
                                                <th class="sort" data-sort="id">ID</th>
                                                <th class="sort" data-sort="product">Sản phẩm</th>
                                                <th class="sort" data-sort="status">Thương hiệu</th>
                                                <th class="sort" data-sort="phone">Giá</th>
                                                <th style="width:8%" class="sort" data-sort="phone">Đã bán</th>
                                                <th style="width:8%" class="sort" data-sort="phone">Tồn kho</th>
                                                <th style="width:8%" class="sort" data-sort="phone">Lượt xem</th>
                                                <th class="sort" data-sort="created_at">Trạng thái</th>
                                                <th class="sort" data-sort="action">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($data as $product)
                                                <tr>
                                                    <td class="align-middle">{{ $product->id }}</td>
                                                    <td class="align-middle">
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ Storage::url($product->avatar ?? 'default-avatar.png') }}"
                                                                alt="product Avatar" class="me-3 rounded" width="50"
                                                                height="50">
                                                            <div class="ml-3">
                                                                <a href="{{ route('admin.products.show', $product->id) }}"
                                                                    class="text-decoration-none fw-bold">
                                                                    {{ $product->name }}
                                                                </a><br>
                                                                <small class="text-muted mb-0">Danh mục |
                                                                    <b>{{ $product->category->name }}</b></small>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="align-middle"> {{ $product->brand->name }}</td>
                                                    <td class="align-middle">
                                                        @if($product->type=='simple')
                                                        {{ number_format($product->price_default, 0, ',', '.') }} đ
                                                        @else    
                                                        {{ number_format($product->min_price, 0, ',', '.') }} -
                                                        {{ number_format($product->max_price, 0, ',', '.') }} đ
                                                        @endif
                                                        
                                                      </td>
                                                    <td class="align-middle"> {{ $product->sold_quantity }}</td>
                                                    <td class="align-middle"> {{ $product->current_stock }}</td>
                                                    <td class="align-middle"> {{ $product->view_count }}</td>
                                                    <td class="align-middle">
                                                        <span
                                                            class="badge
                                                            @if ($product->status == 'active') bg-success
                                                            @elseif($product->status == 'inactive') bg-warning
                                                            @else bg-danger @endif">
                                                            @if ($product->status == 'active')
                                                                Đang bán
                                                            @elseif($product->status == 'inactive')
                                                                Ngừng bán
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <ul class="list-inline hstack mb-0">
                                                            <!-- Edit Button -->
                                                            <li class="list-inline-item edit" title="Xem chi tiết sản phẩm">
                                                                <a href="{{ route('admin.products.show', $product->id) }}"
                                                                    class="btn btn-info btn-icon waves-effect waves-light btn-sm">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <!-- Remove Button -->
                                                            <li class="list-inline-item" title="Xóa">
                                                                <form
                                                                    action="{{ route('admin.products.destroy', $product->id) }}"
                                                                    method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button
                                                                        class="btn btn-danger btn-icon waves-effect waves-light btn-sm"
                                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                                                        <i class="nav-icon fa-solid fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

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
@section('script-lib')
    <script src="{{ asset('theme/velzon/theme/velzon/assets/libs/list.js/list.min.js') }}"></script>
    <script src="{{ asset('theme/velzon/theme/velzon/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
    <script src="{{ asset('theme/velzon/assets/libs/list.js/list.min.js') }}"></script>
    <script src="{{ asset('theme/velzon/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ asset('theme/velzon/assets/js/pages/ecommerce-customer-list.init.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

    <!-- Sweet Alerts js -->


    <!-- Sweet alert init js-->
    <script src="{{ asset('theme/velzon/assets/js/pages/sweetalerts.init.js') }}"></script>

    <script src="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@endsection
@section('script')
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $('#productTable').DataTable({
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />
@endsection

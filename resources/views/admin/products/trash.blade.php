@extends('admin.layouts.master')

@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="trashProductList">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center justify-content-between">
                                <div class="col-sm">
                                    <h5 class="card-title mb-0">Sản phẩm đã xóa</h5>
                                </div>
                                <div class="col-sm-auto">
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                        <i class="ri-arrow-go-back-line align-bottom me-1"></i> Quay lại danh sách
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive table-card mt-2 mb-1">
                                <table class="table table-bordered display" id="trashTable">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th>ID</th>
                                            <th>Sản phẩm</th>
                                            <th>Thương hiệu</th>
                                            <th>Giá mặc định</th>
                                            <th>Thời gian xóa</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ Storage::url($product->avatar ?? 'default-avatar.png') }}"
                                                            class="me-3 rounded" width="50" height="50">
                                                        <div class="ml-3">
                                                            <strong>{{ $product->name }}</strong><br>
                                                            <small class="text-muted">Danh mục: {{ $product->category->name }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $product->brand->name }}</td>
                                                <td>{{ number_format($product->price_default, 0, ',', '.') }} VND</td>
                                                <td>{{ $product->deleted_at ? $product->deleted_at->format('d/m/Y H:i') : '' }}</td>
                                                <td class="align-middle">
                                                    <ul class="list-inline hstack mb-0">
                                                        <!-- Restore Button with Icon -->
                                                        <li class="list-inline-item" title="Khôi phục">
                                                            <form
                                                                action="{{ route('admin.products.restore', $product->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Bạn có chắc chắn muốn khôi phục product này?');">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit"
                                                                    class="btn btn-info btn-icon waves-effect waves-light btn-sm">
                                                                    <i class="fas fa-undo-alt"></i>
                                                                    <!-- Font Awesome icon for restore -->
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <!-- Delete Permanently Button with Icon -->
                                                        <li class="list-inline-item" title="Xóa vĩnh viễn">
                                                            <form
                                                                action="{{ route('admin.products.force-delete', $product->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn product này?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-icon waves-effect waves-light btn-sm">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                    <!-- Font Awesome icon for delete -->
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
    </section>
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#trashTable').DataTable({
                language: {
                    lengthMenu: "Hiển thị _MENU_ dòng",
                    zeroRecords: "Không tìm thấy dữ liệu",
                    info: "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ mục",
                    search: "Tìm kiếm:",
                    paginate: {
                        first: "Đầu",
                        last: "Cuối",
                        next: "Sau",
                        previous: "Trước"
                    }
                }
            });
        });
    </script>
@endsection

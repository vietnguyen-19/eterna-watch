@extends('admin.layouts.master')
@section('content')

    <div class="col-lg-12">
        <div class="card" id="customerList">
            <div class="card-header border-bottom-dashed">

                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">Thêm mới thương hiệu</h5>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Hiển thị lỗi --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif


            <form action="{{ route('admin.brands.store') }}" autocomplete="off" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="body row">
                        <div class="mb-3 col-12">
                            <label for="name" class="form-label">Tên thương hiệu</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required placeholder="Enter name">
                        </div>

                        <div class="mb-3 col-12">
                            <select name="parent_id" class="form-control">
                                <option value="">Chọn danh mục cha</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ old('parent_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="hstack gap-2 justify-content-left">
                        <button type="submit" class="btn btn-success" id="add-btn">Thêm thương hiệu</button>
                        <a href="{{ route('admin.brands.index') }}" class="btn btn-light">Đóng</a>
                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                    </div>
                </div>
            </form>
        </div>


    </div>

    </div>

@endsection
@section('script-lib')
    <script src="http://chiccorner-project.test/theme/velzon/assets/libs/list.js/list.min.js"></script>
    <script src="http://chiccorner-project.test/theme/velzon/assets/libs/list.pagination.js/list.pagination.min.js">
    </script>
    <script src="{{ asset('theme/velzon/assets/libs/list.js/list.min.js') }}"></script>
    <script src="{{ asset('theme/velzon/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ asset('theme/velzon/assets/js/pages/ecommerce-customer-list.init.js') }}"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
@section('script')
    <script>
        document.getElementById('name').addEventListener('input', function() {
            // Lấy giá trị từ ô nhập liệu Tên danh mục
            var tenDanhMuc = this.value;

            // Chuyển đổi Tên danh mục thành Slug
            var slug = tenDanhMuc.toLowerCase()
                .normalize('NFD') // Chuẩn hóa Unicode để xử lý các ký tự tiếng Việt
                .replace(/[\u0300-\u036f]/g, '') // Xóa các dấu phụ
                .replace(/[^a-z0-9\s-]/g, '') // Xóa các ký tự đặc biệt không phải chữ cái Latin hoặc số
                .replace(/\s+/g, '-') // Thay thế khoảng trắng bằng dấu gạch ngang
                .replace(/-+/g, '-'); // Loại bỏ các dấu gạch ngang thừa

            // Gán giá trị Slug vào ô nhập liệu Slug
            document.getElementById('slug').value = slug;
        });
    </script>
@endsection
@section('style')
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />
@endsection

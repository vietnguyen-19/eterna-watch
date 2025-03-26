@extends('admin.layouts.master')
@section('content')

    <div class="container">
        <h2 class="mt-3 mb-4">Chỉnh sửa Thương hiệu</h2>
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
        <div class="card p-4 shadow-lg">
            <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">Tên Thương hiệu</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $brand->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Thương hiệu cha (nếu có)</label>
                    <select name="parent_id" class="form-select">
                        <option value="">Không có</option>
                        @foreach ($brands as $b)
                            <option value="{{ $b->id }}"
                                {{ old('parent_id', $brand->parent_id) == $b->id ? 'selected' : '' }}>
                                {{ $b->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Cập nhật</button>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay
                    lại</a>
            </form>
        </div>
    </div>
    <<<<<<< HEAD=======</div>
        >>>>>>> 7a1b9543a606d606d0ba582c363b42f59857daf1
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

@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card" id="bannerCreate">
                        <div class="card-header border-bottom-dashed">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="card-title mb-0">Tạo mới Banner</h5>
                                <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="ri-arrow-go-back-line"></i> Quay lại
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                {{-- Tiêu đề --}}
                                <div class="mb-3">
                                    <label for="title" class="form-label">Tiêu đề</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                        value="{{ old('title') }}" required>
                                </div>

                                {{-- Vị trí --}}
                                <div class="mb-3">
                                    <label for="position" class="form-label">Vị trí hiển thị</label>
                                    <select name="position" id="position" class="form-select form-control" required>
                                        @foreach ([
            'home_start' => 'Trang chủ - Phần đầu',
            'home_new_product' => 'Trang chủ - Sản phẩm mới',
            'login' => 'Trang đăng nhập',
            'register' => 'Trang đăng ký',
            'shop' => 'Trang cửa hàng',
            'blog' => 'Trang blog',
            'forward_password' => 'Trang quên mật khẩu',
        ] as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ old('position') === $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Hình ảnh --}}
                                <div class="mb-3">
                                    <label for="image" class="form-label">Chọn ảnh</label>
                                    <input type="file" name="image" id="image" class="form-control" required>
                                </div>

                                {{-- Liên kết --}}
                                <div class="mb-3">
                                    <label for="link" class="form-label">Liên kết</label>
                                    <input type="text" name="link" id="link" class="form-control"
                                        value="{{ old('link') }}">
                                </div>

                                {{-- Mô tả --}}
                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea name="description" id="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                                </div>

                                {{-- Trạng thái --}}
                                <div class="mb-3">
                                    <label class="form-label d-block">Trạng thái</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="active"
                                            value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active">Hiển thị</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="inactive"
                                            value="0" {{ old('is_active') == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inactive">Ẩn</label>
                                    </div>
                                </div>

                                {{-- Nút lưu --}}
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-success">
                                        <i class="ri-add-line"></i> Tạo mới
                                    </button>
                                    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary ms-2">Hủy</a>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </section>

    <style>
        .card {
            border-radius: 4px;
            /* Giảm bo góc */
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .form-control,
        .form-select {
            border-radius: 4px;
            /* Giảm bo góc */
            transition: border-color 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
        }

        .btn-primary {
            background-color: #4a90e2;
            border: none;
            border-radius: 4px;
            /* Giảm bo góc */
        }

        .btn-primary:hover {
            background-color: #357abd;
        }

        .btn-outline-secondary {
            border-radius: 4px;
            /* Giảm bo góc */
        }

        .btn-outline-secondary:hover {
            background-color: #f8f9fa;
        }

        .bg-light {
            border-radius: 4px;
            /* Giảm bo góc */
        }
    </style>
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

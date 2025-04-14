@extends('admin.layouts.master')
@section('content')
<section class="content pt-3">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0" id="bannerEdit">
                    <!-- Card Header -->
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0 fw-semibold text-dark">Chỉnh sửa Banner</h5>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                        
                            <div class="row">
                                <!-- Cột ảnh -->
                                <div class="col-md-3 mb-4">
                                    <div class="bg-light p-2 rounded">
                                        <input type="hidden" name="old_image" value="{{ $banner->image }}">
                                        @if ($banner->image)
                                            <img src="{{ Storage::url($banner->image) }}" alt="Banner" class="img-fluid w-100 rounded">
                                        @else
                                            <img src="{{ asset('theme/velzon/assets/images/no-img.jpg') }}" alt="No Image" class="img-fluid w-100 rounded">
                                        @endif
                                    </div>
                        
                                    <label for="image" class="form-label fw-medium mt-3">Chọn ảnh mới</label>
                                    <input type="file" name="image" id="image" class="form-control shadow-sm" accept="image/*">
                                    <small class="text-muted">Định dạng hỗ trợ: JPG, PNG (Tối đa 5MB)</small>
                                </div>
                        
                                <!-- Cột thông tin -->
                                <div class="col-md-9">
                                    <div class="mb-4">
                                        <label for="position" class="form-label fw-medium">
                                            Vị trí hiển thị <span class="text-danger">*</span> |
                                            <span class="badge bg-secondary">{{ $banner->position }}</span>
                                            <input type="hidden" name="position" value="{{ $banner->position }}">
                                        </label>
                                    </div>
                        
                                    <div class="mb-4">
                                        <label for="title" class="form-label fw-medium">Tiêu đề <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title" class="form-control shadow-sm" value="{{ old('title', $banner->title) }}" placeholder="Nhập tiêu đề banner">
                                    </div>
                        
                                    <div class="mb-4">
                                        <label for="link" class="form-label fw-medium">Liên kết</label>
                                        <input type="text" name="link" id="link" class="form-control shadow-sm" value="{{ old('link', $banner->link) }}" placeholder="Nhập URL liên kết">
                                    </div>
                        
                                    <div class="mb-4">
                                        <label for="description" class="form-label fw-medium">Mô tả</label>
                                        <textarea name="description" id="description" class="form-control shadow-sm" rows="4" placeholder="Nhập mô tả banner">{{ old('description', $banner->description) }}</textarea>
                                    </div>
                        
                                    <div class="mb-4">
                                        <label class="form-label fw-medium d-block">Trạng thái</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_active" id="active" value="1" {{ $banner->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label" for="active">Hiển thị</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_active" id="inactive" value="0" {{ !$banner->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label" for="inactive">Ẩn</label>
                                            </div>
                                        </div>
                                    </div>
                        
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary px-4 mr-2">
                                            <i class="ri-save-line me-1"></i> Cập nhật
                                        </button>
                                        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary px-4">Hủy</a>
                                    </div>
                                </div>
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
        border-radius: 4px; /* Giảm bo góc */
        transition: all 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    .form-control, .form-select {
        border-radius: 4px; /* Giảm bo góc */
        transition: border-color 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #4a90e2;
        box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
    }
    .btn-primary {
        background-color: #4a90e2;
        border: none;
        border-radius: 4px; /* Giảm bo góc */
    }
    .btn-primary:hover {
        background-color: #357abd;
    }
    .btn-outline-secondary {
        border-radius: 4px; /* Giảm bo góc */
    }
    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
    }
    .bg-light {
        border-radius: 4px; /* Giảm bo góc */
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

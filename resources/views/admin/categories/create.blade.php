@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="customerList">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0"><strong>Thêm mới danh mục</strong></h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('admin.categories.store') }}" autocomplete="off" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="body row">
                                    <!-- Tên danh mục -->
                                    <div class="mb-3 col-12">
                                        <label for="name" class="form-label">Tên danh mục</label>
                                        <input value="{{ old('name') }}" name="name" type="text" id="name"
                                            class="form-control" placeholder="Enter name">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Ảnh danh mục (chỉ hiển thị khi type == child) -->

                                    <!-- Chọn danh mục cha (chỉ hiển thị khi type == parent) -->
                                    @if ($type == 'parent')
                                        <input type="hidden" name="parent_id" value="">
                                    @else
                                        <div class="mb-3 col-12">
                                            <label for="parent_id" class="form-label">Chọn danh mục cha</label>
                                            <select name="parent_id" class="form-control">
                                                <option value="">Chọn danh mục cha</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('parent_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif

                                    <!-- Trạng thái -->
                                    <div class="mb-3 col-12">
                                        <label for="status">Trạng thái</label>
                                        <select name="status" class="form-control" required>
                                            <option value="active">Hiển thị</option>
                                            <option value="inactive">Tạm ẩn</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if ($type == 'parent')
                                        <div class="mb-3 col-12">
                                            <label for="image" class="form-label">Chọn ảnh</label>

                                            <div class="input-group">
                                                <input type="file"
                                                    class="form-control d-none @error('image') is-invalid @enderror"
                                                    id="image" name="image" accept="image/*"
                                                    onchange="previewImage(this)">
                                                <label class="input-group-text btn btn-outline-primary" for="image">📁
                                                    Chọn ảnh</label>
                                            </div>

                                            @error('image')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror

                                            <div class="mt-3 d-none" id="previewContainer">
                                                <p class="mb-1">Ảnh xem trước:</p>
                                                <img id="previewImageTag" alt="Xem trước ảnh" class="img-thumbnail"
                                                    style="max-height: 200px;">
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="hstack gap-2 justify-content-left">
                                    <button type="submit" class="btn btn-success" id="add-btn">Thêm danh mục</button>
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Đóng</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
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
   <script>
    function previewImage(input) {
        const previewContainer = document.getElementById('previewContainer');
        const previewImageTag = document.getElementById('previewImageTag');

        const file = input.files[0];

        // Kiểm tra nếu có ảnh được chọn
        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                // Đặt đường dẫn ảnh vào thẻ img
                previewImageTag.src = e.target.result;

                // Hiển thị ảnh xem trước
                previewContainer.classList.remove('d-none');
            };

            // Đọc ảnh dưới dạng Data URL
            reader.readAsDataURL(file);
        } else {
            // Nếu không có ảnh, ẩn phần xem trước
            previewContainer.classList.add('d-none');
        }
    }
</script>

@endsection
@section('style')
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />
@endsection

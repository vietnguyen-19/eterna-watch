@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <form action="{{ route('admin.products.update', $data->id) }}" autocomplete="off" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input name="productId" value="{{ $data->id }}" type="text" hidden>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" id="customerList">
                            <div class=" card-header border-bottom-dashed ">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <div>
                                            <h5 class="card-title mb-0"><b>Chỉnh sửa sản phẩm</b></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">

                                    <div class="col-3">
                                        <div class="mb-3 col-md-12">
                                            <label for="name" class="form-label">Tên sản phẩm</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                value="{{ $data->name }}">
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Danh mục cha -->
                                        <!-- Danh mục cha -->
                                        <div class="mb-3 col-md-12">
                                            <label for="categorySelect" class="form-label">Danh mục sản phẩm</label>
                                            <select id="categorySelect" name="category_id"
                                                class="form-control form-select @error('category_id') is-invalid @enderror">
                                                <option value="">Chọn danh mục</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', optional($data->category->parent)->id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Danh mục con -->
                                        <div class="mb-3 col-md-12">
                                            <label for="subcategorySelect" class="form-label">Danh mục con</label>
                                            <select id="subcategorySelect" name="subcategory_id"
                                                class="form-control form-select @error('subcategory_id') is-invalid @enderror">
                                                <option value="">Chọn danh mục con</option>
                                                <!-- Danh mục con sẽ được load qua AJAX -->
                                            </select>
                                            @error('subcategory_id')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>




                                        <div class="mb-3 col-md-12">
                                            <label for="brand" class="form-label">Thương hiệu</label>
                                            <select class="form-control" name="brand_id" class="form-select">
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ $brand->id == $data->brand->id ? 'selected' : '' }}>
                                                        {{ $brand->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('brand_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-12">
                                            <label for="price_default" class="form-label">Giá mặc định</label>
                                            <input type="text" name="price_default" id="price_default"
                                                class="form-control" value="{{ $data->price_default }}"
                                                oninput="formatPrice(this)">
                                            @error('price_default')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror

                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="price_sale" class="form-label">Giá khuyến mãi</label>
                                            <input type="text" name="price_sale" id="price_sale" class="form-control"
                                                value="{{ $data->price_sale }}" oninput="formatPrice(this)">
                                            @error('price_sale')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror

                                        </div>

                                        <div class="mb-3 col-md-12">
                                            <label for="status" class="form-label">Trạng thái</label>
                                            <select class="form-control" name="status" class="form-select">
                                                <option value="active" {{ $data->status === 'active' ? 'selected' : '' }}>
                                                    Đang
                                                    bán
                                                </option>
                                                <option value="inactive"
                                                    {{ $data->status === 'inactive' ? 'selected' : '' }}>
                                                    Ngừng bán
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="image" class="form-label">Chọn ảnh mới (nếu muốn thay)</label>

                                            <div class="input-group">
                                                <input type="file"
                                                    class="form-control d-none @error('image') is-invalid @enderror"
                                                    id="avatar" name="avatar" accept="image/*"
                                                    onchange="previewImage(this)">
                                                    <label class="input-group-text btn btn-outline-primary w-100"
                                                    for="avatar">
                                                    <i class="fas fa-cloud-upload-alt mr-2"></i> Chọn ảnh
                                                </label>
                                            </div>

                                            @error('avatar')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror

                                            <div class="mt-3">
                                                <img src="{{ Storage::url($data->avatar) }}" id="previewImageTag"
                                                    alt="Ảnh hiện tại" class="img-thumbnail w-100">
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-9">
                                        <div class="mb-3 col-12">
                                            <label for="short_description" class="form-label">Mô tả ngắn</label>
                                            <textarea name="short_description" id="short_description" class="form-control" rows="3">{{ $data->short_description }}</textarea>
                                            @error('short_description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-4 col-12">
                                            <label for="short_description" class="form-label">Mô tả đầy đủ</label>
                                            <textarea name="full_description" id="full_description" class="form-control summernote" rows="4"
                                                placeholder="Nhập mô tả đầy đủ">{{ $data->full_description }}</textarea>
                                            @error('full_description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="submit" class="btn btn-success mr-2">Lưu thay đổi</button>
                                    <a href="{{ route('admin.products.show', $data->id) }}"
                                        class="btn btn-secondary">Hủy</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </section>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>


    <!-- Khởi tạo Summernote cho textarea -->
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Nhập mô tả đầy đủ',
                tabsize: 2,
                height: 640 // Chiều cao của editor
            });
        });
    </script>

    <script>
        function previewImage(input) {
            const file = input.files[0];
            const preview = document.getElementById('previewImageTag');
            const container = document.getElementById('previewContainer');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
    <!-- FilePond JS -->

    </script>
    <script>
        $(document).ready(function () {
            function loadSubcategories(parentId, selectedSubId = null) {
                $('#subcategorySelect').html('<option value="">Chọn danh mục con</option>');
    
                if (parentId) {
                    $.ajax({
                        url: '/admin/products/get-subcategories/' + parentId,
                        type: 'GET',
                        success: function (data) {
                            data.forEach(function (subcategory) {
                                $('#subcategorySelect').append(
                                    `<option value="${subcategory.id}" 
                                        ${selectedSubId == subcategory.id ? 'selected' : ''}>
                                        ${subcategory.name}
                                    </option>`
                                );
                            });
                        },
                        error: function () {
                            alert('Có lỗi xảy ra khi tải danh mục con!');
                        }
                    });
                }
            }
    
            // Lấy ID danh mục cha & con ban đầu từ Blade
            let initialParentId = '{{ old('category_id', optional($data->category->parent)->id) }}';
            let initialSubId = '{{ old('subcategory_id', $data->category_id) }}';
    
            // Nếu đã có sẵn ID => Load danh mục con tương ứng
            if (initialParentId) {
                loadSubcategories(initialParentId, initialSubId);
            }
    
            // Khi người dùng thay đổi danh mục cha => cập nhật danh mục con
            $('#categorySelect').change(function () {
                let selectedParentId = $(this).val();
                loadSubcategories(selectedParentId);
            });
        });
    </script>
    
@endsection
@section('style')
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

    <!-- FilePond CSS -->
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
@endsection

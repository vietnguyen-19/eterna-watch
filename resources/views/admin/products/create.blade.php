@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <form action="{{ route('admin.products.store') }}" autocomplete="off" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">
            <div class="container-fluid">
                <div class="row">
                    <!-- Cột 1: Thông tin cơ bản -->
                    <div class="col-lg-4">
                        <div class="card" id="customerList">
                            <div class="card-header bg-info text-white">
                                <h5 class="card-title mb-0"><b>Thêm thông tin sản phẩm</b></h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Tên sản phẩm -->
                                    <div class="mb-3 col-md-12">
                                        <label for="name" class="form-label">Tên sản phẩm</label>
                                        <input value="{{ old('name') }}" name="name" type="text" id="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Nhập tên sản phẩm">
                                        @error('name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Giá sản phẩm -->
                                    <div class="mb-3 col-md-12">
                                        <label for="price_default" class="form-label">Giá sản phẩm</label>
                                        <input value="{{ old('price_default') }}" name="price_default" type="number"
                                            id="price_default"
                                            class="form-control @error('price_default') is-invalid @enderror"
                                            placeholder="Nhập giá sản phẩm">
                                        @error('price_default')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                   
                                    <!-- Giá khuyến mãi -->
                                    <div class="mb-3 col-md-12">
                                        <label for="price_sale" class="form-label">Giá khuyến mãi (nếu có)</label>
                                        <input value="{{ old('price_sale') }}" name="price_sale" type="number"
                                            id="price_sale" class="form-control @error('price_sale') is-invalid @enderror"
                                            placeholder="Nhập giá sản phẩm">
                                        @error('price_sale')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if ($type != 'variant')
                                    <div class="mb-3 col-md-12">
                                        <label for="stock" class="form-label">Tồn kho</label>
                                        <input value="{{ old('stock') }}" name="stock" type="number"
                                            id="stock"
                                            class="form-control @error('stock') is-invalid @enderror"
                                            placeholder="Nhập giá sản phẩm">
                                        @error('stock')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @endif
                                    <!-- Danh mục sản phẩm -->
                                    <div class="mb-3 col-md-12">
                                        <label for="categorySelect" class="form-label">Danh mục sản phẩm</label>
                                        <select id="categorySelect" name="category_id"
                                            class="form-control form-select @error('category_id') is-invalid @enderror">
                                            <option value="">Chọn danh mục</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                        </select>
                                        @error('subcategory_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Thương hiệu -->
                                    <div class="mb-3 col-md-12">
                                        <label for="brand_id" class="form-label">Thương hiệu</label>
                                        <select name="brand_id"
                                            class="form-control form-select @error('brand_id') is-invalid @enderror">
                                            <option value="">Chọn thương hiệu</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}"
                                                    {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('brand_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Trạng thái -->
                                    <div class="mb-3 col-md-12">
                                        <label for="status" class="form-label">Trạng thái</label>
                                        <select name="status"
                                            class="form-control form-select @error('status') is-invalid @enderror" required>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                                Inactive
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Chọn ảnh -->
                                    <div class="mb-3 col-md-12">
                                        <div class="" style="max-width: 400px; width: 100%;">
                                            <label for="avatar" class="form-label text-start">Chọn ảnh</label>
                                            <div class="input-group justify-content-center">
                                                <input type="file"
                                                    class="form-control d-none @error('avatar') is-invalid @enderror"
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

                                            <div class="mt-3 d-none" id="previewContainer">
                                                <img id="previewImageTag" alt="Xem trước ảnh" class="img-thumbnail"
                                                    style="max-height: 200px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Cột 2: Mô tả -->
                    <div class="col-lg-8">
                        <div class="card" id="customerList">
                            <div class="card-header bg-info text-white">
                                <h5 class="card-title mb-0"><b>Mô tả sản phẩm</b></h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Mô tả ngắn -->
                                    <div class="mb-3 col-md-12">
                                        <label for="short_description" class="form-label">Mô tả ngắn</label>
                                        <textarea name="short_description" id="short_description" class="form-control" rows="2"
                                            placeholder="Nhập mô tả ngắn">{{ old('short_description') }}</textarea>
                                        @error('short_description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Mô tả đầy đủ -->
                                    <div class="col-12">
                                        <label for="full_description" class="form-label">Mô tả đầy đủ</label>
                                        <textarea name="full_description" id="full_description" class="form-control summernote" rows="4"
                                            placeholder="Nhập mô tả đầy đủ">{{ old('full_description') }}</textarea>
                                        @error('full_description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($type != 'simple')
                        <div class="card" id="customerList">
                            <div class="card-header bg-info text-white">
                                <h5 class="card-title mb-0"><b>Chọn các thuộc tính</b></h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="attribute-values" class="form-label">Chọn các thuộc tính</label>
                                        <select name="attribute_values[]" class="form-control select2" multiple
                                            id="attribute-values">
                                            @foreach ($attributes as $attribute)
                                                <option value="{{ $attribute->id }}"
                                                    {{ is_array(old('attribute_values')) && in_array($attribute->id, old('attribute_values')) ? 'selected' : '' }}>
                                                    {{ $attribute->attribute_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('attribute_values')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    </div>

                    <!-- Cột 3: Biến thể -->
                   

                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end gap-2">
                        @if ($type == 'simple')
                            <button type="submit" class="btn btn-success">Thêm mới sản phẩm</button>
                        @else
                            <button type="submit" class="btn btn-success">Tiếp theo</button>
                        @endif
                    </div>
                </div>

            </div>
        </form>
    </section>
@endsection

@section('style')
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
    <script src="{{ asset('js/product-create.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Khởi tạo Dropzone cho ảnh đại diện
            // Khởi tạo Select2
            $('#attribute-values').select2({
                placeholder: "Chọn các loại biến thể",
                allowClear: true,
                width: "100%"
            });

            // Khởi tạo Summernote
            $('.summernote').summernote({
                placeholder: 'Nhập mô tả đầy đủ',
                tabsize: 2,
                height: 560
            });
        });
    </script>

    <!-- FilePond CSS -->


    <!-- FilePond JS -->

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

    <script>
        $(document).ready(function() {
            // Hàm lấy danh mục con
            function loadSubcategories(parentId, selectedSubcategoryId = null) {
                $('#subcategorySelect').html('<option value="">Chọn danh mục con</option>');

                if (parentId) {
                    $.ajax({
                        url: '/admin/products/get-subcategories/' + parentId,
                        type: 'GET',
                        success: function(data) {
                            data.forEach(function(subcategory) {
                                $('#subcategorySelect').append(
                                    `<option value="${subcategory.id}" 
                                    ${selectedSubcategoryId == subcategory.id ? 'selected' : ''}>
                                    ${subcategory.name}
                                </option>`
                                );
                            });
                        },
                        error: function() {
                            alert('Có lỗi xảy ra, vui lòng thử lại!');
                        }
                    });
                }
            }

            // Xử lý khi thay đổi danh mục cha
            $('#categorySelect').change(function() {
                let parentId = $(this).val();
                loadSubcategories(parentId);
            });

            // Kiểm tra nếu có old('category_id') khi validate thất bại
            @if (old('category_id'))
                let oldCategoryId = '{{ old('category_id') }}';
                let oldSubcategoryId = '{{ old('subcategory_id') }}';
                if (oldCategoryId) {
                    loadSubcategories(oldCategoryId, oldSubcategoryId);
                }
            @endif
        });
    </script>
@endsection

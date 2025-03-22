@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <form action="{{ route('admin.products.store') }}" autocomplete="off" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container-fluid">
                <div class="row">
                    <!-- Cột 1: Thông tin cơ bản -->
                    <div class="col-lg-4">
                        <div class="card" id="customerList">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0"><b>Bước 1 | Thêm thông tin sản phẩm</b></h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Tên sản phẩm -->
                                    <div class="mb-3 col-md-12">
                                        <label for="name" class="form-label">Tên sản phẩm</label>
                                        <input value="{{ old('name') }}" name="name" type="text" id="name"
                                            class="form-control" placeholder="Nhập tên sản phẩm">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Ảnh đại diện với Dropzone -->
                                    <div class="mb-3 col-md-12">
                                        <label for="avatar" class="form-label">Ảnh đại diện</label>
                                        <input type="hidden" name="avatar" id="avatar-hidden">
                                        <input type="file" id="avatar"> <!-- Không đặt name -->
                                        @error('avatar')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="price_default" class="form-label">Giá sản phẩm</label>
                                        <input value="{{ old('price_default') }}" name="price_default" type="number"
                                            id="price_default" class="form-control" placeholder="Nhập giá sản phẩm">
                                        @error('price_default')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Danh mục sản phẩm -->
                                    <div class="mb-3 col-md-12">
                                        <label for="category_id" class="form-label">Danh mục sản phẩm</label>
                                        <select name="category_id" class="form-control form-select">
                                            <option value="">Chọn danh mục</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Thương hiệu -->
                                    <div class="mb-3 col-md-12">
                                        <label for="brand_id" class="form-label">Thương hiệu</label>
                                        <select name="brand_id" class="form-control form-select">
                                            <option value="">Chọn thương hiệu</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}"
                                                    {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('brand_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Trạng thái -->
                                    <div class="mb-3 col-md-12">
                                        <label for="status" class="form-label">Trạng thái</label>
                                        <select name="status" class="form-control form-select" required>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                                Inactive</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cột 2: Mô tả -->
                    <div class="col-lg-8">
                        <div class="card" id="customerList">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0"><b>Bước 1 | Thêm thông tin sản phẩm</b></h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Mô tả ngắn -->
                                    <div class="mb-3 col-md-12">
                                        <label for="short_description" class="form-label">Mô tả ngắn</label>
                                        <textarea name="short_description" id="short_description" class="form-control" rows="4"
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
                    </div>

                    <!-- Cột 3: Biến thể -->
                    <div class="col-lg-12">
                        <div class="card" id="customerList">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0"><b>Bước 2 | Chọn các loại biến thể</b></h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="attribute-values" class="form-label">Chọn các loại biến
                                            thể</label>
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
                            <div class="card-footer">
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="submit" class="btn btn-success">Tiếp theo</button>
                                </div>
                            </div>
                        </div>
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
                height: 305
            });
        });
    </script>

    <!-- FilePond CSS -->


    <!-- FilePond JS -->

    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
    <!-- HTML của bạn giữ nguyên, thêm script này -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginImageResize);

            const pond = FilePond.create(document.querySelector('#avatar'), {
                name: 'avatar', // Key của file upload
                allowMultiple: false,
                imagePreviewHeight: 150,
                server: {
                    process: {
                        url: '/admin/upload-image',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        onload: (response) => {
                            let res = JSON.parse(response);
                            if (res.success) {
                                document.querySelector('#avatar-hidden').value = res.path;
                                console.log('Uploaded:', res.path);
                                return res.path;
                            } else {
                                alert(res.message);
                                return;
                            }
                        },
                        onerror: (response) => {
                            console.error('Upload error:', response);
                        }
                    },
                    revert: {
                        url: '/admin/remove-image',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        onload: (response) => {
                            let res = JSON.parse(response);
                            if (res.success) {
                                document.querySelector('#avatar-hidden').value = '';
                                console.log('Removed:', res.message);
                            } else {
                                console.error('Remove error:', res.message);
                            }
                        },
                        onerror: (error) => {
                            console.error('Revert error:', error);
                        }
                    }
                }
            });
        });
    </script>
@endsection

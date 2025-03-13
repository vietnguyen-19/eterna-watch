@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <form action="{{ route('admin.products.store') }}" autocomplete="off" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card" id="customerList">
                            <div class="bg-primary card-header border-bottom-dashed ">

                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <div>
                                            <h5 class="card-title mb-0"><b>Bước 1 | Thêm thông tin sản phẩm</b></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <!-- Tên sản phẩm -->
                                    <div class="mb-4 col-md-12">
                                        <label for="name" class="form-label">Tên sản phẩm</label>
                                        <input value="{{ old('name') }}" name="name" type="text" id="name"
                                            class="form-control" placeholder="Nhập tên sản phẩm">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Ảnh đại diện -->
                                    <div class="mb-4 col-md-12">
                                        <label for="avatar" class="form-label">Ảnh đại diện</label>
                                        <input name="avatar" type="file" id="avatar" class="form-control">
                                        @error('avatar')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Giá sản phẩm -->
                                    <div class="mb-4 col-md-12">
                                        <label for="price_default" class="form-label">Giá sản phẩm</label>
                                        <input value="{{ old('price_default') }}" name="price_default" type="number"
                                            id="price_default" class="form-control" placeholder="Nhập giá sản phẩm">
                                        @error('price_default')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Danh mục sản phẩm -->
                                    <div class="mb-4 col-md-12">
                                        <label for="category_id" class="form-label">Danh mục sản phẩm</label>
                                        <select name="category_id" class="form-control">
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
                                    <div class="mb-4 col-md-12">
                                        <label for="brand_id" class="form-label">Thương hiệu</label>
                                        <select name="brand_id" class="form-control">
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
                                    <div class="col-md-12">
                                        <label for="status" class="form-label">Trạng thái</label>
                                        <select name="status" class="form-control" required>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
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
                    <div class="col-lg-8">
                        <div class="card" id="customerList">
                            <div class="bg-primary card-header border-bottom-dashed ">

                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <div>
                                            <h5 class="card-title mb-0"><b>Bước 1 | Thêm thông tin sản phẩm</b></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="mb-4 col-md-12">
                                        <label for="short_description" class="form-label">Mô tả ngắn</label>
                                        <textarea name="short_description" id="short_description" class="form-control" rows="4"
                                            placeholder="Nhập mô tả ngắn">{{ old('short_description') }}</textarea>
                                        @error('short_description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Mô tả đầy đủ -->
                                    <div class="col-12">
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
                    <div class="col-lg-12">
                        <div class="card" id="customerList">
                            <div class="bg-primary card-header border-bottom-dashed ">

                                <div class="row g-4 align-items-center">
                                    <div class="">
                                        <div>
                                            <h5 class="card-title mb-0"><b>Bước 2 | Chọn các loại biến thể</b></h5>
                                        </div>
                                    </div>
                                </div>
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
                                <!-- Phần chứa form cho từng thuộc tính được tạo động -->
                                <div id="attributes-value-forms"></div>
                                <!-- Phần hiển thị tổ hợp biến thể (nếu cần) -->
                                <div id="variants-combinations"></div>
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
            </div>
        </form>
    </section>
    </div>
@endsection
@section('style')
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#attribute-values').select2({
                placeholder: "Chọn các loại biến thể",
                allowClear: true,
                width: "100%" // Căn chỉnh full width
            });
        });
    </script>

    <!-- Khởi tạo Summernote cho textarea -->
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Nhập mô tả đầy đủ',
                tabsize: 2,
                height: 305 // Chiều cao của editor
            });
        });
    </script>
@endsection

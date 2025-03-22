@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <form action="{{ route('admin.productvariants.store') }}" autocomplete="off" method="POST"
            enctype="multipart/form-data">
            @csrf
            <input name="productId" value="{{ $data->id }}" type="text" hidden>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Thông tin sản phẩm -->
                        <div class="card" id="customerList">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0"><b>Thông tin sản phẩm</b></h5>
                                    </div>
                                    <div class="col-sm-auto">
                                        <a href="{{ route('admin.products.edit', $data->id) }}"
                                            class="btn btn-warning add-btn">
                                            <i class="ri-add-line align-bottom me-1"></i>Chỉnh sửa thông tin sản phẩm
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Cột ảnh và thông tin cơ bản -->
                                    <div class="col-3">
                                        <div class="col-md-12 text-center">
                                            <img src="{{ asset('storage/' . $data->avatar) }}"
                                                class="img-fluid rounded shadow mb-3" style="object-fit: cover;"
                                                alt="Ảnh sản phẩm">
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="name" class="form-label">Tên sản phẩm</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                value="{{ $data->name }}" disabled>
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="category" class="form-label">Danh mục</label>
                                            <select class="form-control form-select" name="category_id" disabled>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $category->id == $data->category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="brand" class="form-label">Thương hiệu</label>
                                            <select class="form-control form-select" name="brand_id" disabled>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ $brand->id == $data->brand->id ? 'selected' : '' }}>
                                                        {{ $brand->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="price_default" class="form-label">Giá mặc định</label>
                                            <input type="text" name="price_default" id="price_default"
                                                class="form-control"
                                                value="{{ number_format($data->price_default, 0, ',', '.') }}" disabled>
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="status" class="form-label">Trạng thái</label>
                                            <select class="form-control form-select" name="status" disabled>
                                                <option value="active" {{ $data->status === 'active' ? 'selected' : '' }}>
                                                    Đang bán</option>
                                                <option value="inactive"
                                                    {{ $data->status === 'inactive' ? 'selected' : '' }}>Ngừng bán</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Cột mô tả -->
                                    <div class="col-9">
                                        <div class="row">
                                            <div class="mb-4 col-12">
                                                <label for="short_description" class="form-label">Mô tả ngắn</label>
                                                <textarea name="short_description" id="short_description" class="form-control" rows="2"
                                                    placeholder="Nhập mô tả ngắn" disabled>{{ $data->short_description }}</textarea>
                                                @error('short_description')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-4 col-12">
                                                <label for="full_description" class="form-label">Mô tả đầy đủ</label>
                                                <textarea name="full_description" id="full_description" class="form-control summernote" rows="4"
                                                    placeholder="Nhập mô tả đầy đủ" disabled>{{ $data->full_description }}</textarea>
                                                @error('full_description')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Các biến thể của sản phẩm -->
                        <div class="card" id="customerList">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0"><b>Các biến thể của sản phẩm</b></h5>
                                    </div>
                                    <div class="col-sm-auto">
                                        <a href="{{ route('admin.productvariants.edit', $data->id) }}"
                                            class="btn btn-warning add-btn">
                                            <i class="ri-add-line align-bottom me-1"></i>Chỉnh sửa biến thể sản phẩm
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle bg-light table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Ảnh</th>
                                                    <th>Biến thể</th>
                                                    <th>SKU</th>
                                                    <th>Giá</th>
                                                    <th>Số lượng tồn</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($data->variants as $variant)
                                                    <tr>
                                                        <td class="align-middle">
                                                            @if ($variant->image)
                                                                <img src="{{ asset('storage/' . $variant->image) }}"
                                                                    class="" style="max-width: 88px;"
                                                                    alt="Ảnh biến thể">
                                                            @else
                                                                <span class="text-muted">Chưa có ảnh</span>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">
                                                            <ul class="list-unstyled mb-0">
                                                                @foreach ($variant->attributeValues as $value)
                                                                    <li>
                                                                        {{ $value->nameValue->attribute->attribute_name }}:
                                                                        @if ($value->nameValue->attribute->attribute_name === 'Màu sắc')
                                                                            <div class="badge"
                                                                                style="background-color: {{ $value->nameValue->note }};">
                                                                                &nbsp;</div>
                                                                        @else
                                                                            {{ $value->nameValue->value_name }}
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                        <td class="align-middle">{{ $variant->sku }}</td>
                                                        <td class="align-middle">
                                                            {{ number_format($variant->price, 0, ',', '.') }} VND</td>
                                                        <td class="align-middle">{{ $variant->stock }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center text-muted">Không có biến
                                                            thể nào.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Phần chứa form cho từng thuộc tính được tạo động -->
                                <div id="attributes-value-forms"></div>
                                <!-- Phần hiển thị tổ hợp biến thể (nếu cần) -->
                                <div id="variants-combinations"></div>
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

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>


    <!-- Khởi tạo Summernote cho textarea -->
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Nhập mô tả đầy đủ',
                tabsize: 2,
                height: 620, // Chiều cao của editor
                toolbar: false, // Ẩn thanh công cụ
            });

            // Tắt chế độ chỉnh sửa (chỉ xem)
            $('.summernote').summernote('disable');
        });
    </script>
@endsection
@section('style')
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />
@endsection

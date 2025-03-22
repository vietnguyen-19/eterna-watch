@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <form action="{{ route('admin.productvariants.update', $product->id) }}" autocomplete="off" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input name="productId" value="{{ $product->id }}" type="text" hidden>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" id="customerList">
                            <div class=" card-header border-bottom-dashed ">

                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <div>
                                            <h5 class="card-title mb-0"><b>Thông tin sản phẩm</b></h5>
                                        </div>
                                    </div>
                                    <div class="col-sm-auto">
                                        <div class="d-flex flex-wrap align-items-start gap-2">
                                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                                class="btn btn-warning add-btn"><i
                                                    class="ri-add-line align-bottom me-1"></i>Chỉnh sửa thông tin sản
                                                phẩm</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Ảnh đại diện -->
                                    <div class="col-3">
                                        <div class="col-md-12 text-center">
                                            <img src="{{ asset('storage/' . $product->avatar) }}"
                                                class="img-fluid rounded shadow" style="object-fit: cover;"
                                                alt="Ảnh sản phẩm">
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="row">
                                            <div class="mb-3 col-md-12">
                                                <label for="name" class="form-label">Tên sản phẩm</label>
                                                <input type="text" name="name" id="name" class="form-control"
                                                    value="{{ $product->name }}" disabled>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="category" class="form-label">Danh mục</label>
                                                <select class="form-control" name="category_id" class="form-select"
                                                    disabled>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ $category->id == $product->category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="brand" class="form-label">Thương hiệu</label>
                                                <select class="form-control" name="brand_id" class="form-select" disabled>
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->id }}"
                                                            {{ $brand->id == $product->brand->id ? 'selected' : '' }}>
                                                            {{ $brand->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="price_default" class="form-label">Giá mặc định</label>
                                                <input type="text" name="price_default" id="price_default"
                                                    class="form-control"
                                                    value="{{ number_format($product->price_default, 0, ',', '.') }}"
                                                    disabled>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="status" class="form-label">Trạng thái</label>
                                                <select class="form-control" name="status" class="form-select" disabled>
                                                    <option value="active"
                                                        {{ $product->status === 'active' ? 'selected' : '' }}>
                                                        Đang
                                                        bán
                                                    </option>
                                                    <option value="inactive"
                                                        {{ $product->status === 'inactive' ? 'selected' : '' }}>
                                                        Ngừng bán
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="mb-4 col-12">
                                                <label for="status" class="form-label">Mô tả ngắn</label>
                                                <textarea name="short_description" id="short_description" class="form-control" rows="2"
                                                    placeholder="Nhập mô tả ngắn" disabled>{{ $product->short_description }}</textarea>
                                                @error('short_description')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3" id="customerList">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <div>
                                            <h5 class="card-title mb-0"><b>Danh sách biến thể sản phẩm</b></h5>
                                        </div>
                                    </div>
                                    <div class="col-sm-auto">
                                        <div class="d-flex flex-wrap align-items-start gap-2">
                                            <button id="add-variant" href="" class="btn btn-success add-btn"><i
                                                    class="ri-add-line align-bottom me-1"></i>Thêm biến thể mới</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table id="variants" class="table table-bordered align-middle bg-light">
                                    <thead>
                                        <tr>
                                            <th class="text-center" class="text-center">Ảnh</th>
                                            <th class="text-center">Thuộc tính</th>
                                            <th class="text-center">SKU</th>
                                            <th class="text-center">Giá</th>
                                            <th class="text-center">Số lượng tồn</th>
                                            <th class="text-center">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($product->variants as $variant)
                                            <tr>
                                                <td class="text-center align-middle" style="width: 20%">
                                                    @if ($variant->image)
                                                        <img src="{{ asset('storage/' . $variant->image) }}"
                                                            class="img-thumbnail d-block mx-auto" style="max-width:25%;"
                                                            alt="Ảnh biến thể">
                                                        <input type="file" name="image[{{ $variant->id }}]"
                                                            class="form-control form-control-sm mt-1">
                                                    @else
                                                        <span class="text-muted">Chưa có ảnh</span>
                                                        <input type="file" name="image[{{ $variant->id }}]"
                                                            class="form-control form-control-sm mt-1">
                                                    @endif
                                                </td>
                                                <td class="align-middle" style="width: 25%;">
                                                    <div class="">
                                                        @foreach ($variant->attributeValues as $value)
                                                            <div class="d-flex align-items-đcenter mb-2">
                                                                <input type="hidden"
                                                                    name="attributes[{{ $variant->id }}][{{ $value->id }}]"
                                                                    value="{{ $value->nameValue->id }}">
                                                                <span class="text-muted mb-0">
                                                                    <strong>{{ $value->nameValue->attribute->attribute_name }}</strong>: {{ $value->nameValue->value_name }}
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                        
                                                    </div>
                                                </td>
                                                <td class="align-middle" style="width: 15%">
                                                    <input type="text" name="sku[{{ $variant->id }}]"
                                                        class="form-control form-control-sm" value="{{ $variant->sku }}"
                                                        required>
                                                </td>
                                                <td class="align-middle" style="width: 15%;">
                                                    <input type="text" name="price[{{ $variant->id }}]"
                                                        class="form-control form-control-sm price-input"
                                                        value="{{ $variant->price}}"
                                                        required>
                                                </td>
                                                <td class="align-middle" style="width:10%">
                                                    <input type="text" name="stock[{{ $variant->id }}]"
                                                        class="form-control form-control-sm stock-input"
                                                        value="{{ $variant->stock }}" required>
                                                </td>
                                                <td class="align-middle text-center" style="width:10%">
                                                    <div class="list-inline-item" title="Xóa">
                                                        <button
                                                            class="btn btn-danger btn-icon waves-effect waves-light btn-sm delete-variant"
                                                            data-id="{{ $variant->id }}">
                                                            <i class="nav-icon fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">Không có biến thể nào.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                            </div>
                            <div class="card-footer">
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                                    <a href="{{ route('admin.products.show', $product->id) }}"
                                        class="btn btn-secondary">Trở về</a>
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

    <script>
        // Thêm biến thể mới vào bảng
        document.getElementById('add-variant').addEventListener('click', function(event) {
            event.preventDefault();

            // Lấy phần tbody trong table
            var tbody = document.querySelector('#variants tbody');

            // Kiểm tra nếu có hàng hiện có (loại trừ hàng empty) thì validate thông tin trong hàng cuối cùng
            var existingRows = tbody.querySelectorAll('tr:not(.empty)');
            if (existingRows.length > 0) {
                var lastRow = existingRows[existingRows.length - 1];
                // Lấy tất cả các input và select có thuộc tính required trong hàng cuối cùng
                var requiredFields = lastRow.querySelectorAll('input[required], select[required]');
                var incomplete = false;
                requiredFields.forEach(function(field) {
                    if (field.value.trim() === '') {
                        incomplete = true;
                    }
                });
                if (incomplete) {
                    alert("Vui lòng điền đầy đủ thông tin cho biến thể hiện tại trước khi thêm mới.");
                    return;
                }
            }

            // Đếm số lượng hàng hiện có để tạo index cho hàng mới
            var index = tbody.querySelectorAll('tr').length;

            // Tạo hàng tr mới
            var newRow = document.createElement('tr');

            // Nội dung của hàng mới với tên mảng đồng nhất và chỉ số động
            newRow.innerHTML = `
                <td class="text-center align-middle" style="width: 20%">
                    <input type="file" name="variants[new][${index}][image][]" class="form-control form-control-sm mt-1" required>
                </td>
                <td class="align-middle" style="width: 20%;">
                    <div>
                        @foreach ($product->attributes as $attribute)
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <label class="text-muted mb-0" style="width: 150px;">
                                    {{ $attribute->attribute_name }}:
                                </label>
                                <select class="form-select form-select-sm w-100" required
                                    name="variants[new][${index}][attributes][{{ $attribute->id }}]">
                                    <option value="">-- Chọn giá trị --</option>
                                    @foreach ($allAttributeValues[$attribute->id] as $option)
                                        <option value="{{ $option->id }}">
                                            {{ $option->value_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>
                </td>
                <td class="align-middle" style="width: 15%">
                    <input type="text" name="variants[new][${index}][sku]" class="form-control form-control-sm" value="" required>
                </td>
                <td class="align-middle" style="width: 15%;">
                    <input type="text" name="variants[new][${index}][price]" class="form-control form-control-sm" value="" required>
                </td>
                <td class="align-middle" style="width:10%">
                    <input type="text" name="variants[new][${index}][stock]" class="form-control form-control-sm" value="" required>
                </td>
                <td class="align-middle text-center" style="width:10%">
                    <button class="btn btn-danger btn-icon waves-effect waves-light btn-sm delete-variant" type="button">
                        <i class="nav-icon fa-solid fa-trash"></i>
                    </button>
                </td>
            `;

            // Thêm hàng mới vào tbody
            tbody.appendChild(newRow);
        });



        // Lắng nghe sự kiện click trên nút xóa (cho cả biến thể cũ và mới)
        document.addEventListener('click', function(event) {
            var deleteButton = event.target.closest('.delete-variant');
            if (!deleteButton) return;

            event.preventDefault();

            // Hiển thị xác nhận trước khi xóa
            if (!confirm('Bạn có chắc chắn muốn xóa biến thể này?')) {
                // Nếu người dùng từ chối, không thực hiện hành động nào
                return;
            }

            // Kiểm tra nếu nút xóa có data-id => biến thể cũ đã lưu trên server
            var variantId = deleteButton.getAttribute('data-id');
            if (variantId) {
                // Gửi yêu cầu xóa bằng Ajax đến server
                fetch(`/admin/productvariants/destroy/${variantId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            alert('Xóa biến thể thành công!');
                            deleteButton.closest('tr').remove();
                        } else {
                            alert('Đã xảy ra lỗi, vui lòng thử lại.');
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi:', error);
                        alert('Đã xảy ra lỗi, vui lòng thử lại.');
                    });
            } else {
                // Nếu không có data-id, biến thể đó chưa được lưu trên server nên chỉ xóa khỏi DOM
                deleteButton.closest('tr').remove();
            }
        });
    </script>
    <!-- Khởi tạo Summernote cho textarea -->
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Nhập mô tả đầy đủ',
                tabsize: 2,
                height: 200, // Chiều cao của editor
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
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

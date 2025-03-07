@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <form id="variantForm" action="{{ route('admin.productvariants.store') }}" autocomplete="off" method="POST"
            enctype="multipart/form-product">
            @csrf
            <input name="productId" value="{{ $product->id }}" type="hidden">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Thông tin sản phẩm -->
                        <div class="card">
                            <div class="bg-primary card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0"><b>Thông tin sản phẩm</b></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <!-- Ảnh đại diện -->
                                    <div class="col-3">
                                        <label for="brand" class="form-label">Hình ảnh</label>
                                        <div class="mb-3 col-md-12 text-center">
                                            <img src="{{ asset('storage/' . $product->avatar) }}"
                                                class="img-fluid rounded shadow" style="object-fit: cover;"
                                                alt="Ảnh sản phẩm">
                                            <input type="file" name="avatar" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="row">
                                            <div class="mb-3 col-md-12">
                                                <label for="name" class="form-label">Tên sản phẩm</label>
                                                <input type="text" name="name" id="name" class="form-control"
                                                    value="{{ $product->name }}">
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="category" class="form-label">Danh mục</label>
                                                <select class="form-control" name="category_id" class="form-select">
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
                                                <select class="form-control" name="brand_id" class="form-select">
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
                                                    value="{{ number_format($product->price_default, 0, ',', '.') }}">
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="status" class="form-label">Trạng thái</label>
                                                <select class="form-control" name="status" class="form-select">
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
                                                <label for="brand" class="form-label">Mô tả ngắn</label>
                                                <textarea name="short_description" id="short_description" class="form-control" rows="3"
                                                    placeholder="Nhập mô tả ngắn">{{ $product->short_description }}</textarea>
                                                @error('short_description')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Thông tin sản phẩm -->

                        <!-- Bản chọn biến thể -->
                        <div class="row">
                            <div class="col-3">
                                <div class="card">
                                    <div class="bg-light card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0"><b>Bước 3 | Chọn các giá trị của thuộc tính</b>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach ($product->attributes as $attribute)
                                                <div class="mb-3 col-md-12">
                                                    <label for="name_values"
                                                        class="form-label">{{ $attribute->attribute_name }}</label>
                                                    <select name="name_values[]" class="form-control" multiple
                                                        id="attribute-values">
                                                        @foreach ($attribute->attributeValues as $value)
                                                            <option value="{{ $value->id }}"
                                                                {{ is_array(old('name_values')) && in_array($value->id, old('name_values')) ? 'selected' : '' }}>
                                                                {{ $value->value_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('name_values')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex">
                                            <button id="add-variants" class="btn btn-success w-100" type="button">Tạo các
                                                biến thể tự động</button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Cột hiển thị biến thể -->
                            <div class="col-9">
                                <div class="card">
                                    <div class="bg-light card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-12">
                                                <h5 class="card-title mb-0"><b>Biến thể sản phẩm</b>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form id="variantForm" action="your-upload-endpoint" method="POST"
                                            enctype="multipart/form-data">
                                            <!-- Nội dung form -->
                                        </form>

                                        <div id="variants-combinations">
                                            <!-- Nội dung mặc định khi chưa có biến thể nào -->
                                            <p class="text-center text-muted m-0">Chưa có biến thể nào</p>
                                        </div>
                                    </div>
                                    <div id="button-variant"></div>
                                </div>
                            </div>

                        </div>
                        <!-- End bản chọn biến thể -->
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        // Sử dụng Event Delegation cho nút submit
        document.addEventListener('click', function(e) {
            if (e.target && e.target.id === 'submit-form') {
                e.preventDefault(); // Ngăn form submit

                // Gọi hàm validate
                if (validateVariants()) {
                    // Nếu hợp lệ thì submit form
                    document.getElementById('variantForm').submit();
                }
            }
        });

        // Function validate
        function validateVariants() {
            let isValid = true;

            // Lặp qua tất cả các input có class validate-required
            document.querySelectorAll('.validate-required').forEach(function(input) {
                // Nếu input rỗng thì hiển thị lỗi
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('is-invalid');

                    // Kiểm tra nếu đã có thông báo lỗi chưa, nếu chưa thì thêm vào
                    if (!input.nextElementSibling || !input.nextElementSibling.classList.contains(
                            'invalid-feedback')) {
                        let errorDiv = document.createElement('div');
                        errorDiv.classList.add('invalid-feedback');
                        errorDiv.textContent = 'Trường này không được để trống.';
                        input.parentNode.appendChild(errorDiv);
                    }
                } else {
                    // Xóa thông báo lỗi nếu có giá trị
                    input.classList.remove('is-invalid');
                    if (input.nextElementSibling && input.nextElementSibling.classList.contains(
                            'invalid-feedback')) {
                        input.nextElementSibling.remove();
                    }
                }
            });

            return isValid;
        }


        document.getElementById('add-variants').addEventListener('click', function(e) {
            // Ngăn form submit khi click button "Tạo các biến thể"
            e.preventDefault();

            // Đảm bảo form có thuộc tính enctype="multipart/form-data"
            let form = document.getElementById('variantForm');
            form.setAttribute('enctype', 'multipart/form-data');

            // Lấy tất cả các select chứa giá trị thuộc tính (dùng name="name_values[]")
            let selects = document.querySelectorAll('select[name="name_values[]"]');
            let arrays = [];

            selects.forEach(function(select) {
                // Lấy các option được chọn, chuyển thành mảng các đối tượng {id, name}
                let selectedOptions = Array.from(select.selectedOptions).map(option => ({
                    id: option.value,
                    name: option.textContent.trim()
                }));
                if (selectedOptions.length > 0) {
                    arrays.push(selectedOptions);
                }
            });

            // Hàm tính tích Descartes (cartesian product) của các mảng
            function cartesian(arrays) {
                return arrays.reduce((a, b) => a.flatMap(d => b.map(e => [...d, e])), [
                    []
                ]);
            }

            let combinations = cartesian(arrays);
            let container = document.getElementById('variants-combinations');
            container.innerHTML = ''; // Xóa nội dung cũ nếu có

            // Nếu có tổ hợp và ít nhất một thuộc tính được chọn
            if (combinations.length > 0 && combinations[0].length > 0) {
                let table = document.createElement('table');
                table.classList.add('table', 'table-bordered');

                // Tạo header cho bảng, bao gồm cột "Xóa"
                let thead = document.createElement('thead');
                let headerRow = document.createElement('tr');
                ['Biến thể', 'SKU', 'Giá', 'Số lượng tồn', 'Ảnh', 'Xóa'].forEach(function(text) {
                    let th = document.createElement('th');
                    th.textContent = text;
                    headerRow.appendChild(th);
                });
                thead.appendChild(headerRow);
                table.appendChild(thead);

                // Tạo body cho bảng
                let tbody = document.createElement('tbody');
                combinations.forEach(function(combo, index) {
                    let row = document.createElement('tr');

                    // Ô Biến thể: ghép tên của các giá trị (ví dụ: "Đỏ - XL")
                    let variantName = combo.map(item => item.name).join(' - ');
                    let tdVariant = document.createElement('td');
                    tdVariant.textContent = variantName;
                    row.appendChild(tdVariant);

                    // Ô SKU
                    let tdSKU = document.createElement('td');
                    let inputSKU = document.createElement('input');
                    inputSKU.type = 'text';
                    inputSKU.name = `variants[${index}][sku]`;
                    inputSKU.classList.add('form-control', 'validate-required');
                    tdSKU.appendChild(inputSKU);
                    row.appendChild(tdSKU);

                    // Ô Giá
                    let tdPrice = document.createElement('td');
                    let inputPrice = document.createElement('input');
                    inputPrice.type = 'number';
                    inputPrice.name = `variants[${index}][price]`;
                    inputPrice.classList.add('form-control', 'validate-required');
                    tdPrice.appendChild(inputPrice);
                    row.appendChild(tdPrice);

                    // Ô Số lượng tồn
                    let tdStock = document.createElement('td');
                    let inputStock = document.createElement('input');
                    inputStock.type = 'number';
                    inputStock.name = `variants[${index}][stock]`;
                    inputStock.classList.add('form-control', 'validate-required');
                    tdStock.appendChild(inputStock);
                    row.appendChild(tdStock);

                    // Ô Ảnh: Người dùng cần chọn file để upload
                    let tdImage = document.createElement('td');
                    let inputImage = document.createElement('input');
                    inputImage.type = 'file';
                    inputImage.name = `variants[${index}][image]`;
                    inputImage.classList.add('form-control', 'validate-required');
                    tdImage.appendChild(inputImage);
                    row.appendChild(tdImage);

                    // Cột Xóa: Thêm nút xóa để loại bỏ hàng nếu cần
                    let tdRemove = document.createElement('td');
                    let btnRemove = document.createElement('button');
                    btnRemove.textContent = 'Xóa';
                    btnRemove.classList.add('btn', 'btn-danger', 'btn-sm');
                    btnRemove.addEventListener('click', function() {
                        row.remove();
                    });
                    tdRemove.appendChild(btnRemove);
                    row.appendChild(tdRemove);

                    // Thêm hidden input cho từng giá trị thuộc tính
                    combo.forEach(function(item) {
                        let hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = `variants[${index}][name_value_ids][]`;
                        hiddenInput.value = item.id;
                        tdVariant.appendChild(hiddenInput);
                    });

                    tbody.appendChild(row);
                });

                table.appendChild(tbody);
                container.appendChild(table);

                // Thêm nút submit cho form tại div button-variant
                let buttonContainer = document.getElementById('button-variant');
                buttonContainer.innerHTML = `
            <div class="card-footer">
                <div class="d-flex justify-content-end gap-2">
                    <button id="submit-form" type="submit" class="btn btn-success mr-2">Thêm sản phẩm biến thể</button>
                </div>
            </div>
        `;
            } else {
                // Nếu không có biến thể nào, hiển thị thông báo mặc định
                container.innerHTML = '<p class="text-center text-muted">Chưa có biến thể nào</p>';
                document.getElementById('button-variant').innerHTML = '';
            }
        });
    </script>
@endsection
@section('style')
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 JS -->
@endsection

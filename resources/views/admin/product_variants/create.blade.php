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
                                        <div class="mb-3 col-md-12 text-center">
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
                                                <label for="brand" class="form-label">Mô tả ngắn</label>
                                                <textarea name="short_description" id="short_description" class="form-control" rows="3"
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
                        <!-- End Thông tin sản phẩm -->

                        <!-- Bản chọn biến thể -->
                        <div class="row">
                            <div class="col-3">
                                <div class="card">
                                    <div class="bg-light card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0"><b>Chọn các giá trị của thuộc tính</b>
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

    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
    <script>
        // Sử dụng Event Delegation cho nút submit
        document.addEventListener("click", function(e) {
            if (e.target && e.target.id === "submit-form") {
                e.preventDefault(); // Ngăn form submit

                if (validateVariants()) {
                    document.getElementById("variantForm").submit();
                }
            }
        });

        // Function validate
        function validateVariants() {
            let isValid = true;

            document.querySelectorAll(".validate-required").forEach(function(input) {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add("is-invalid");

                    if (!input.nextElementSibling || !input.nextElementSibling.classList.contains(
                            "invalid-feedback")) {
                        let errorDiv = document.createElement("div");
                        errorDiv.classList.add("invalid-feedback");
                        errorDiv.textContent = "Trường này không được để trống.";
                        input.parentNode.appendChild(errorDiv);
                    }
                } else {
                    input.classList.remove("is-invalid");
                    if (input.nextElementSibling && input.nextElementSibling.classList.contains(
                            "invalid-feedback")) {
                        input.nextElementSibling.remove();
                    }
                }
            });

            return isValid;
        }

        document.getElementById("add-variants").addEventListener("click", function(e) {
            e.preventDefault();

            let form = document.getElementById("variantForm");
            form.setAttribute("enctype", "multipart/form-data");

            let selects = document.querySelectorAll('select[name="name_values[]"]');
            let arrays = [];

            selects.forEach(function(select) {
                let selectedOptions = Array.from(select.selectedOptions).map((option) => ({
                    id: option.value,
                    name: option.textContent.trim(),
                }));
                if (selectedOptions.length > 0) {
                    arrays.push(selectedOptions);
                }
            });

            function cartesian(arrays) {
                return arrays.reduce((a, b) => a.flatMap((d) => b.map((e) => [...d, e])), [
                    []
                ]);
            }

            let combinations = cartesian(arrays);
            let container = document.getElementById("variants-combinations");
            container.innerHTML = "";

            if (combinations.length > 0 && combinations[0].length > 0) {
                let table = document.createElement("table");
                table.classList.add("table", "table-bordered", "align-middle", "shadow-sm", "table-hover");

                // Tạo header
                let thead = document.createElement("thead");
                thead.classList.add("table-primary");
                let headerRow = document.createElement("tr");
                ["Biến thể", "SKU", "Giá", "Số lượng tồn", "Ảnh", "Xóa"].forEach(function(text, index) {
                    let th = document.createElement("th");
                    th.textContent = text;
                    th.classList.add("text-center", "fw-medium");
                    if (index === 4) th.style.width = "30%"; // Điều chỉnh độ rộng cột ảnh
                    headerRow.appendChild(th);
                });
                thead.appendChild(headerRow);
                table.appendChild(thead);

                // Tạo body
                let tbody = document.createElement("tbody");
                combinations.forEach(function(combo, index) {
                    let row = document.createElement("tr");
                    row.style.verticalAlign = "middle"; // Căn giữa nội dung theo chiều dọc

                    // Cột Biến thể
                    let variantName = combo.map((item) => item.name).join(" - ");
                    let tdVariant = document.createElement("td");
                    tdVariant.textContent = variantName;
                    tdVariant.classList.add("text-center");

                    combo.forEach(function(item) {
                        let hiddenInput = document.createElement("input");
                        hiddenInput.type = "hidden";
                        hiddenInput.name = `variants[${index}][name_value_ids][]`;
                        hiddenInput.value = item.id;
                        tdVariant.appendChild(hiddenInput);
                    });

                    row.appendChild(tdVariant);

                    // Các cột nhập liệu
                    ["sku", "price", "stock"].forEach((field) => {
                        let td = document.createElement("td");
                        let input = document.createElement("input");
                        input.type = field === "price" || field === "stock" ? "number" : "text";
                        input.name = `variants[${index}][${field}]`;
                        input.classList.add("form-control", "form-control-sm", "validate-required");
                        if (field === "price") {
                            input.min = 0.01;
                            input.step = "0.01";
                        } else if (field === "stock") {
                            input.min = 1;
                            input.step = "1";
                        }
                        td.appendChild(input);
                        row.appendChild(td);
                    });

                    // Cột Ảnh
                    FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginImageResize);

                    // Tạo cột chứa ảnh
                    let tdImage = document.createElement("td");
                    tdImage.style.width = "20%";

                    // Tạo input file để upload ảnh
                    let inputImage = document.createElement("input");
                    inputImage.type = "file";
                    inputImage.name = `avatar`;
                    inputImage.classList.add("filepond");

                    // Tạo input hidden để lưu đường dẫn ảnh sau khi upload
                    let inputHidden = document.createElement("input");
                    inputHidden.type = "hidden";
                    inputHidden.name = `variants[${index}][image]`;
                    inputHidden.id = `avatar-hidden-${index}`;

                    // Thêm input file và input hidden vào cột ảnh
                    tdImage.appendChild(inputImage);
                    tdImage.appendChild(inputHidden);
                    row.appendChild(tdImage);

                    // Khởi tạo FilePond với preview ảnh
                    const pond = FilePond.create(inputImage, {
                        name: 'avatar', // Key của file upload
                        allowMultiple: false,
                        imagePreviewHeight: 100,
                        server: {
                            process: {
                                url: '/admin/upload-image',
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        "meta[name='csrf-token']").getAttribute("content")
                                },
                                onload: (response) => {
                                    let res = JSON.parse(response);
                                    if (res.success) {
                                        document.querySelector(`#avatar-hidden-${index}`)
                                            .value = res.path;
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
                                    'X-CSRF-TOKEN': document.querySelector(
                                        "meta[name='csrf-token']").getAttribute("content")
                                },
                                onload: (response) => {
                                    let res = JSON.parse(response);
                                    if (res.success) {
                                        document.querySelector(`#avatar-hidden-${index}`)
                                            .value = '';
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

                    // Cột Xóa
                    let tdRemove = document.createElement("td");
                    let btnRemove = document.createElement("button");
                    btnRemove.type = "button";
                    btnRemove.textContent = "Xóa";
                    btnRemove.classList.add("btn", "btn-danger", "btn-sm", "w-100");
                    btnRemove.addEventListener("click", function() {
                        if (confirm("Bạn có chắc muốn xóa biến thể này?")) {
                            row.remove();
                        }
                    });

                    tdRemove.classList.add("text-center");
                    tdRemove.appendChild(btnRemove);
                    row.appendChild(tdRemove);

                    tbody.appendChild(row);
                });

                table.appendChild(tbody);
                container.appendChild(table);

                let buttonContainer = document.getElementById('button-variant');
                buttonContainer.innerHTML = `
            <div class="card-footer">
                <div class="d-flex justify-content-end gap-2">
                    <button id="submit-form" type="submit" class="btn btn-success mr-2">Thêm sản phẩm biến thể</button>
                </div>
            </div>
        `;
            } else {
                container.innerHTML = '<p class="text-center text-muted py-3">Chưa có biến thể nào</p>';
            }
        });
    </script>
@endsection
@section('style')
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <!-- Select2 JS -->
@endsection

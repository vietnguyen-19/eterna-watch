@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="bg-primary card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <h5 class="card-title mb-0 text-white"><b>Thông tin sản phẩm</b></h5>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row d-flex align-items-stretch">
                                <!-- Ảnh sản phẩm -->
                                <div class="col-md-3 d-flex">
                                    <div
                                        class="w-100 h-100 d-flex align-items-center justify-content-center border rounded shadow-sm p-2 bg-light">
                                        <img src="{{ asset('storage/' . $product->avatar) }}" class="img-fluid rounded"
                                            style="max-height: 100%; max-width: 100%; object-fit: cover;"
                                            alt="Ảnh sản phẩm">
                                    </div>
                                </div>

                                <!-- Thông tin sản phẩm -->
                                <div class="col-md-9 d-flex">
                                    <div class="table-responsive w-100 border rounded shadow-sm p-2 bg-white">
                                        <table class="table table-bordered mb-0 h-100">
                                            <tbody>
                                                <tr>
                                                    <th class="text-muted" style="width: 180px;">Tên sản phẩm</th>
                                                    <td class="fs-5">{{ $product->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-muted">Danh mục</th>
                                                    <td class="fs-5">{{ $product->category->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-muted">Thương hiệu</th>
                                                    <td class="fs-5">{{ $product->brand->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-muted">Giá mặc định</th>
                                                    <td class="fs-5">
                                                        {{ number_format($product->price_default, 0, ',', '.') }} VND
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-muted">Trạng thái</th>
                                                    <td
                                                        class="fs-5 {{ $product->status === 'active' ? 'text-success' : 'text-danger' }}">
                                                        {{ $product->status === 'active' ? 'Đang bán' : 'Ngừng bán' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-muted align-top">Mô tả ngắn</th>
                                                    <td class="fs-5">{{ $product->short_description }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="card">
                                <div class="bg-light card-header border-bottom-dashed">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-sm">
                                            <h5 class="card-title mb-0"><b>Chọn giá trị</b>
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
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-info add-btn w-100 mt-2"
                                            data-bs-toggle="modal" data-bs-target="#variantModal">
                                            <i class="ri-add-line align-bottom me-1"></i> Tạo biến thể thủ công
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-9">
                            <form id="variantForm" method="POST" action="{{ route('admin.productvariants.store-many') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input name="productId" value="{{ $product->id }}" type="hidden">
                                <div class="card">
                                    <div class="bg-light card-header border-bottom-dashed">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm">
                                                <h5 class="card-title mb-0"><b>Biến thể sản phẩm</b></h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <table class="table table-bordered align-middle text-center">
                                            <thead>
                                                <tr>
                                                    <th>Biến thể</th>
                                                    <th>SKU</th>
                                                    <th>Giá</th>
                                                    <th>Số lượng tồn</th>
                                                    <th>Ảnh</th>
                                                    <th>Xóa</th>
                                                </tr>
                                            </thead>
                                            <tbody id="variantTableBody">
                                                <tr id="no-variant-row">
                                                    <td colspan="6" class="text-muted">Chưa có biến thể nào.</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="card-footer">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="submit" class="btn btn-primary">Lưu biến thể</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal fade" id="variantModal" tabindex="-1" aria-labelledby="variantModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content shadow">
                                <form action="{{ route('admin.productvariants.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input name="productId" value="{{ $product->id }}" type="hidden">

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card shadow-sm h-100">
                                                    <div class="card-body d-flex flex-column">

                                                        {{-- Hình ảnh --}}
                                                        <div class="mb-3">
                                                            <label class="form-label mb-1">Hình ảnh</label>
                                                            <input type="file" name="variants[image]"
                                                                class="form-control form-control-sm mt-2">
                                                            @error('variants.image')
                                                                <div class="text-danger mt-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        {{-- Biến thể --}}
                                                        <div class="mb-3">
                                                            <label class="form-label mb-1">Biến thể</label>
                                                            <div class="card p-3">
                                                                @foreach ($product->attributes as $attribute)
                                                                    <div class="mb-3">
                                                                        <label
                                                                            class="form-label">{{ $attribute->attribute_name }}</label>
                                                                        <select
                                                                            name="variants[attributes][{{ $attribute->id }}]"
                                                                            class="form-select form-control @error('variants.attributes.' . $attribute->id) is-invalid @enderror">
                                                                            <option value="">-- Chọn
                                                                                {{ strtolower($attribute->attribute_name) }}
                                                                                --</option>
                                                                            @foreach ($attribute->attributeValues as $value)
                                                                                <option value="{{ $value->id }}"
                                                                                    {{ old('variants.attributes.' . $attribute->id) == $value->id ? 'selected' : '' }}>
                                                                                    {{ $value->value_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('variants.attributes.' . $attribute->id)
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        {{-- SKU --}}
                                                        <div class="mb-2">
                                                            <label class="form-label mb-1">SKU</label>
                                                            <input type="text" name="variants[sku]"
                                                                class="form-control form-control-sm @error('variants.sku') is-invalid @enderror"
                                                                value="{{ old('variants.sku') }}">
                                                            @error('variants.sku')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        {{-- Giá --}}
                                                        <div class="mb-2">
                                                            <label class="form-label mb-1">Giá</label>
                                                            <input type="text" name="variants[price]"
                                                                class="form-control form-control-sm @error('variants.price') is-invalid @enderror"
                                                                value="{{ old('variants.price') }}">
                                                            @error('variants.price')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        {{-- Số lượng tồn --}}
                                                        <div class="mb-2">
                                                            <label class="form-label mb-1">Số lượng tồn</label>
                                                            <input type="text" name="variants[stock]"
                                                                class="form-control form-control-sm @error('variants.stock') is-invalid @enderror"
                                                                value="{{ old('variants.stock') }}">
                                                            @error('variants.stock')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Footer --}}
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-primary">Thêm biến thể mới</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
    <script>
        // Gọi lại sau khi DOM load (sau khi redirect do lỗi)
        window.addEventListener('DOMContentLoaded', function() {
            displayValidationErrors();
        });

        document.getElementById("variantForm").addEventListener("submit", function(e) {
            console.log("Form đang submit!");
        });

        document.getElementById("add-variants").addEventListener("click", function(e) {
            e.preventDefault();

            let selects = document.querySelectorAll('select[name="name_values[]"]');
            let arrays = [];

            selects.forEach(function(select) {
                let selectedOptions = Array.from(select.selectedOptions).map(option => ({
                    id: option.value,
                    name: option.textContent.trim()
                }));
                if (selectedOptions.length > 0) {
                    arrays.push(selectedOptions);
                }
            });

            let combinations = cartesian(arrays);
            createVariantsTable(combinations);
        });

        function cartesian(arrays) {
            return arrays.reduce((a, b) => a.flatMap(d => b.map(e => [...d, e])), [
                []
            ]);
        }

        function createVariantsTable(combinations) {
            let tbody = document.getElementById("variantTableBody");
            tbody.innerHTML = "";

            if (combinations.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" class="text-muted">Chưa có biến thể nào.</td></tr>`;
                return;
            }

            combinations.forEach((combo, index) => {
                let row = document.createElement("tr");

                row.appendChild(createVariantColumn(combo, index));

                ["sku", "price", "stock"].forEach((field) => {
                    row.appendChild(createInputColumn(field, index));
                });

                row.appendChild(createImageColumn(index));
                row.appendChild(createRemoveColumn(row));

                tbody.appendChild(row);
            });
        }

        function createVariantColumn(combo, index) {
            let td = document.createElement("td");
            td.classList.add("text-center");
            td.textContent = combo.map(i => i.name).join(" - ");

            combo.forEach(item => {
                let input = document.createElement("input");
                input.type = "hidden";
                input.name = `variants[${index}][name_value_ids][]`;
                input.value = item.id;
                td.appendChild(input);
            });

            return td;
        }

        function createInputColumn(field, index) {
            let td = document.createElement("td");

            let input = document.createElement("input");
            input.name = `variants[${index}][${field}]`;
            input.classList.add("form-control", "form-control-sm");
            input.type = (field === "price" || field === "stock") ? "number" : "text";

            if (field === "price") {
                input.min = 0.01;
                input.step = "0.01";
            } else if (field === "stock") {
                input.min = 1;
                input.step = "1";
            }

            td.appendChild(input);

            // Tạo div hiển thị lỗi Laravel (ẩn nếu không có lỗi)
            let errorDiv = document.createElement("div");
            errorDiv.classList.add("text-danger", "small", "mt-1");
            errorDiv.id = `error-variants-${index}-${field}`;
            td.appendChild(errorDiv);

            return td;
        }

        function createImageColumn(index) {
            let td = document.createElement("td");
            td.style.width = "20%";

            let fileInput = document.createElement("input");
            fileInput.type = "file";
            fileInput.name = "avatar";
            fileInput.classList.add("filepond");

            let hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = `variants[${index}][image]`;
            hiddenInput.id = `avatar-hidden-${index}`;

            td.appendChild(fileInput);
            td.appendChild(hiddenInput);

            initializeFilePond(fileInput, index);
            return td;
        }

        function createRemoveColumn(row) {
            let td = document.createElement("td");
            td.classList.add("text-center");

            let btn = document.createElement("button");
            btn.classList.add("btn", "btn-danger", "btn-sm", "w-100");
            btn.type = "button";
            btn.textContent = "Xóa";

            btn.onclick = function() {
                if (confirm("Bạn có chắc muốn xóa biến thể này?")) {
                    row.remove();
                    if (document.querySelectorAll("#variantTableBody tr").length === 0) {
                        document.getElementById("variantTableBody").innerHTML =
                            `<tr><td colspan="6" class="text-muted">Chưa có biến thể nào.</td></tr>`;
                    }
                }
            };

            td.appendChild(btn);
            return td;
        }

        function displayValidationErrors() {
            let errors = @json($errors->messages());

            // Xóa lỗi cũ
            document.querySelectorAll('.text-danger.small').forEach(div => {
                div.innerHTML = '';
            });
            document.querySelectorAll('.filepond-error-message').forEach(div => div.remove());

            Object.keys(errors).forEach(key => {
                let errorMessages = errors[key];
                let fieldParts = key.split('.');

                if (fieldParts[0] === 'variants' && fieldParts.length >= 3) {
                    let index = fieldParts[1];
                    let field = fieldParts[2];

                    if (field === 'image') {
                        // Filepond: chèn lỗi sau phần tử filepond
                        const filepondRoot = document.querySelectorAll('.filepond--root')[index];
                        if (filepondRoot) {
                            const errorDiv = document.createElement("div");
                            errorDiv.classList.add("text-danger", "small", "filepond-error-message");
                            errorDiv.style.marginTop = "5px";
                            errorDiv.innerHTML = errorMessages.map(msg => `<div>${msg}</div>`).join('');
                            filepondRoot.insertAdjacentElement('afterend', errorDiv);
                        }
                    } else {
                        let errorDiv = document.getElementById(`error-variants-${index}-${field}`);
                        if (errorDiv) {
                            errorMessages.forEach(message => {
                                let errorSpan = document.createElement('span');
                                errorSpan.textContent = message;
                                errorSpan.style.display = 'block';
                                errorDiv.appendChild(errorSpan);
                            });
                        }
                    }
                }
            });
        }


        function initializeFilePond(inputImage, index) {
            FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginImageResize);

            FilePond.create(inputImage, {
                name: 'avatar',
                allowMultiple: false,
                imagePreviewHeight: 100,
                server: {
                    process: {
                        url: '/admin/upload-image',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute(
                                "content")
                        },
                        onload: (res) => {
                            let json = JSON.parse(res);
                            if (json.success) {
                                document.getElementById(`avatar-hidden-${index}`).value = json.path;
                            } else {
                                alert(json.message);
                            }
                        },
                        onerror: (err) => {
                            console.error('Upload error:', err);
                        }
                    },
                    revert: {
                        url: '/admin/remove-image',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute(
                                "content")
                        },
                        onload: (res) => {
                            let json = JSON.parse(res);
                            if (json.success) {
                                document.getElementById(`avatar-hidden-${index}`).value = '';
                            } else {
                                console.error('Remove error:', json.message);
                            }
                        }
                    }
                }
            });
        }
    </script>

    <script>
        const oldVariants = @json(old('variants'));
        const nameValueMap = @json(session('nameValues', []));


        if (typeof oldVariants !== 'undefined' && oldVariants.length > 0) {
            const combinations = oldVariants.map(variant => {
                return (variant.name_value_ids || []).map(id => {
                    return {
                        id: id,
                        name: nameValueMap[id] || 'Không rõ'
                    };
                });
            });

            createVariantsTable(combinations);

            // Đổ lại các input đã nhập
            oldVariants.forEach((variant, index) => {
                if (variant.sku) document.querySelector(`input[name="variants[${index}][sku]"]`).value = variant
                    .sku;
                if (variant.price) document.querySelector(`input[name="variants[${index}][price]"]`).value = variant
                    .price;
                if (variant.stock) document.querySelector(`input[name="variants[${index}][stock]"]`).value = variant
                    .stock;
                if (variant.image) document.getElementById(`avatar-hidden-${index}`).value = variant.image;
            });
        }
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

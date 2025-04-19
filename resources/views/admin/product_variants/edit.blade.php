@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">

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
                                            class="btn btn-info add-btn"><i class="ri-add-line align-bottom me-1"></i>Chỉnh
                                            sửa thông tin sản
                                            phẩm</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row d-flex align-items-stretch">
                                <!-- Ảnh sản phẩm -->
                                <div class="col-md-3 d-flex">
                                    <div
                                        class="w-100 h-100 d-flex align-items-center justify-content-center border rounded shadow-sm p-2 bg-light">
                                        <img src="{{ Storage::url($product->avatar ?? 'default-avatar.png') }}"
                                            class="img-fluid rounded"
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
                                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                            data-bs-target="#variantModal">
                                            <i class="ri-add-line align-bottom me-1"></i> Thêm biến thể mới
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Nút mở modal -->


                        <!-- Modal -->
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

                        <form action="{{ route('admin.productvariants.update', $product->id) }}" autocomplete="off"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input name="productId" value="{{ $product->id }}" type="text" hidden>
                            <div id="card_variant" class="card-body bg-light">
                                <div class="row">
                                    <div class="table-responsive mb-4 w-100">
                                        <table class="table bg-white table-bordered align-middle text-center">
                                            <thead class="">
                                                <tr>
                                                    <th>Ảnh biến thể</th>
                                                    <th>Biến thể</th>
                                                    <th>SKU</th>
                                                    <th>Giá</th>
                                                    <th>Số lượng tồn</th>
                                                    <th>Trạng thái</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($product->variants as $variant)
                                                <tr>
                                                    <td style="width: 180px;">
                                                        @if ($variant->image)
                                                            <img src="{{ asset('storage/' . $variant->image) }}"
                                                                class="img-thumbnail"
                                                                style="max-height: 100%; object-fit: contain;"
                                                                alt="Ảnh biến thể">
                                                        @else
                                                            <div class="text-muted">Chưa có ảnh</div>
                                                        @endif
                                                
                                                        <input type="file" name="image[{{ $variant->id }}]"
                                                            class="form-control form-control-sm mt-2 @error("image.{$variant->id}") is-invalid @enderror">
                                                        @error("image.{$variant->id}")
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                
                                                    <td class="text-start align-middle">
                                                        <table class="table table-bordered table-sm mb-0">
                                                            <tbody>
                                                                @foreach ($variant->attributeValues as $value)
                                                                    <tr>
                                                                        <td class="text-muted text-left" style="width: 60%;">
                                                                            <strong>{{ $value->nameValue->attribute->attribute_name }}</strong>
                                                                        </td>
                                                                        <td class="text-muted text-left">
                                                                            {{ $value->nameValue->value_name }}
                                                                        </td>
                                                                    </tr>
                                                                    <input type="hidden"
                                                                        name="attributes[{{ $variant->id }}][{{ $value->id }}]"
                                                                        value="{{ $value->nameValue->id }}">
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                
                                                    <td class="align-middle">
                                                        <input type="text" name="sku[{{ $variant->id }}]"
                                                            class="form-control form-control @error("sku.{$variant->id}") is-invalid @enderror"
                                                            value="{{ old("sku.{$variant->id}", $variant->sku) }}">
                                                        @error("sku.{$variant->id}")
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                
                                                    <td class="align-middle">
                                                        <input type="text" name="price[{{ $variant->id }}]"
                                                            class="form-control form-control price-input @error("price.{$variant->id}") is-invalid @enderror"
                                                            value="{{ old("price.{$variant->id}", $variant->price) }}">
                                                        @error("price.{$variant->id}")
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                
                                                    <td class="align-middle">
                                                        <input type="text" name="stock[{{ $variant->id }}]"
                                                            class="form-control form-control stock-input @error("stock.{$variant->id}") is-invalid @enderror"
                                                            value="{{ old("stock.{$variant->id}", $variant->stock) }}">
                                                        @error("stock.{$variant->id}")
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                
                                                    <td class="align-middle">
                                                        @php
                                                            switch ($variant->status) {
                                                                case 'in_stock':
                                                                    $class = 'badge bg-success';
                                                                    $text = 'Còn hàng';
                                                                    break;
                                                                case 'out_of_stock':
                                                                    $class = 'badge bg-danger';
                                                                    $text = 'Hết hàng';
                                                                    break;
                                                                case 'pre_order':
                                                                    $class = 'badge bg-warning text-dark';
                                                                    $text = 'Đặt trước';
                                                                    break;
                                                                default:
                                                                    $class = 'badge bg-secondary';
                                                                    $text = 'Không xác định';
                                                            }
                                                        @endphp
                                                        <span class="{{ $class }}">{{ $text }}</span>
                                                    </td>
                                                </tr>
                                                
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted">
                                                            Không có biến thể nào.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                                    <a href="{{ route('admin.products.show', $product->id) }}"
                                        class="btn btn-secondary">Trở
                                        về</a>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </section>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Tải jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        </script>
    @endif
    @if (session('close_modal'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const myModal = new bootstrap.Modal(document.getElementById('variantModal'));
                myModal.hide(); // Đóng modal
            });
        </script>
    @endif
    @if (session('open_modal'))
        <script>
            window.onload = function() {
                var modal = new bootstrap.Modal(document.getElementById('variantModal'));
                modal.show();
            };
        </script>
    @endif





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

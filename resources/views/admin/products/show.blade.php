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
                                            class="btn btn-info add-btn">
                                            <i class="ri-add-line align-bottom me-1"></i>Chỉnh sửa thông tin sản phẩm
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row d-flex align-items-stretch">
                                    <!-- Ảnh sản phẩm -->
                                    <div class="col-md-3 d-flex">
                                        <div
                                            class="w-100 h-100 d-flex align-items-center justify-content-center border rounded shadow-sm p-2 bg-light">
                                            <img src="{{ Storage::url($data->avatar ?? 'default-avatar.png') }}"
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
                                                        <td class="fs-5">{{ $data->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted">Danh mục</th>
                                                        <td class="fs-5">{{ $data->category->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted">Thương hiệu</th>
                                                        <td class="fs-5">{{ $data->brand->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted">Giá mặc định</th>
                                                        <td class="fs-5">
                                                            {{ number_format($data->price_default, 0, ',', '.') }} đ
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted">Trạng thái</th>
                                                        <td
                                                            class="fs-5 {{ $data->status === 'active' ? 'text-success' : 'text-danger' }}">
                                                            {{ $data->status === 'active' ? 'Đang bán' : 'Ngừng bán' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted align-top">Mô tả ngắn</th>
                                                        <td class="fs-5">{{ $data->short_description }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-flex mt-3">
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


                        @if ($data->type != 'simple')
                        <!-- Các biến thể của sản phẩm -->
                        <div class="card" id="customerList">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0"><b>Các biến thể của sản phẩm</b></h5>
                                    </div>
                                    <div class="col-sm-auto">
                                        <a href="{{ route('admin.productvariants.edit', $data->id) }}"
                                            class="btn btn-info add-btn">
                                            <i class="ri-add-line align-bottom me-1"></i>Chỉnh sửa biến thể sản phẩm
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="table-responsive rounded shadow-sm border">
                                        <table class="table table-bordered align-middle mb-0">
                                            <thead class="text-center align-middle">
                                                <tr>
                                                    <th scope="col" style="width: 100px;">Ảnh</th>
                                                    <th class="text-left" scope="col">Biến thể</th>
                                                    <th scope="col">SKU</th>
                                                    <th scope="col">Giá</th>
                                                    <th scope="col">Tồn kho</th>
                                                    <th scope="col">Đã bán</th>
                                                    <th scope="col">Trạng thái</th>
                                                    <th scope="col">Thao tác</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($data->variants as $variant)
                                                    <tr>
                                                        <td style="width:10%;" class="text-center align-middle p-2">
                                                            @if ($variant->image)
                                                                <img src="{{ Storage::url($variant->image ?? 'default-avatar.png') }}"
                                                                    class="img-fluid border rounded"
                                                                    style="width: 100%; height: auto; object-fit: contain;"
                                                                    alt="Ảnh biến thể">
                                                            @else
                                                                <span class="text-muted fst-italic">Chưa có ảnh</span>
                                                            @endif
                                                        </td>

                                                        <td class="align-middle">
                                                            <ul class="list-unstyled mb-0">
                                                                @foreach ($variant->attributeValues as $value)
                                                                    <li class="mb-1">
                                                                        <strong>{{ $value->nameValue->attribute->attribute_name }}:</strong>
                                                                        @if ($value->nameValue->attribute->attribute_name === 'Màu sắc')
                                                                            <span
                                                                                class="d-inline-block rounded-circle border"
                                                                                style="width: 16px; height: 16px; background-color: {{ $value->nameValue->note }};"
                                                                                title="{{ $value->nameValue->value_name }}">
                                                                            </span>
                                                                        @else
                                                                            {{ $value->nameValue->value_name }}
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                        <td class="text-center text-nowrap align-middle">
                                                            {{ $variant->sku }}</td>
                                                        <td class="text-center text-nowrap align-middle">
                                                            {{ number_format($variant->price, 0, ',', '.') }} <span
                                                                class="text-muted">đ</span>
                                                        </td>
                                                        <td class="text-center align-middle">{{ $variant->stock }}</td>
                                                        <td class="text-center align-middle">{{ $variant->sold_quantity }}</td>
                                                        <td class="align-middle">
                                                            @php
                                                                switch ($variant->status) {
                                                                    case 'active':
                                                                        $class = 'badge bg-success';
                                                                        $text = 'Còn hàng';
                                                                        break;
                                                                    case 'out_of_stock':
                                                                        $class = 'badge bg-danger';
                                                                        $text = 'Hết hàng';
                                                                        break;
                                                                    case 'inactive':
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
                                                        <td class="align-middle">
                                                            <form
                                                                action="{{ route('admin.productvariants.destroy', $variant->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa biến thể này?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    title="Xóa biến thể">
                                                                    <i class="fa-solid fa-trash"></i> Xóa
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center text-muted py-4">
                                                            <i class="bi bi-box-seam fs-5 me-1"></i> Không có biến thể nào.
                                                        </td>
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
                        @endif
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

    <!-- Khởi tạo Summernote cho textarea -->
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Nhập mô tả đầy đủ',
                tabsize: 2,
                height: 300, // Chiều cao của editor
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
    <style>
        .note-editor.note-frame .note-editing-area .note-editable {
            background-color: #ffffff !important;
            /* Màu trắng */
            color: #000000;
            /* Tùy chọn: chữ màu đen cho dễ đọc */
        }
    </style>
@endsection

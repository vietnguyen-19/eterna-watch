@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <form action="{{ route('admin.products.update', $data->id) }}" autocomplete="off" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input name="productId" value="{{ $data->id }}" type="text" hidden>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" id="customerList">
                            <div class=" card-header border-bottom-dashed ">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <div>
                                            <h5 class="card-title mb-0"><b>Chỉnh sửa sản phẩm</b></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">

                                    <div class="col-3">
                                        <div class="mb-3 col-md-12">
                                            <label for="name" class="form-label">Tên sản phẩm</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                value="{{ $data->name }}">
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-12">
                                            <label for="category" class="form-label">Danh mục</label>
                                            <select class="form-control" name="category_id" class="form-select">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $category->id == $data->category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-12">
                                            <label for="brand" class="form-label">Thương hiệu</label>
                                            <select class="form-control" name="brand_id" class="form-select">
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ $brand->id == $data->brand->id ? 'selected' : '' }}>
                                                        {{ $brand->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('brand_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-12">
                                            <label for="price_default" class="form-label">Giá mặc định</label>
                                            <input type="text" name="price_default" id="price_default"
                                                class="form-control" value="{{ $data->price_default }}"
                                                oninput="formatPrice(this)">
                                            @error('price_default')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror

                                        </div>

                                        <div class="mb-3 col-md-12">
                                            <label for="status" class="form-label">Trạng thái</label>
                                            <select class="form-control" name="status" class="form-select">
                                                <option value="active" {{ $data->status === 'active' ? 'selected' : '' }}>
                                                    Đang
                                                    bán
                                                </option>
                                                <option value="inactive"
                                                    {{ $data->status === 'inactive' ? 'selected' : '' }}>
                                                    Ngừng bán
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <label for="avatar" class="d-block mb-2">Ảnh hiện tại</label>
                                            <div class="col-md-12 text-center">
                                                <input type="file" id="avatar" name="avatar" class="filepond">
                                                <input type="hidden" id="avatar-hidden" name="avatar_hidden"
                                                    value="{{ $data->avatar ?? '' }}">
                                            </div>

                                            @error('avatar')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-9">
                                        <div class="mb-3 col-12">
                                            <label for="short_description" class="form-label">Mô tả ngắn</label>
                                            <textarea name="short_description" id="short_description" class="form-control" rows="3">{{ $data->short_description }}</textarea>
                                            @error('short_description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-4 col-12">
                                            <label for="short_description" class="form-label">Mô tả đầy đủ</label>
                                            <textarea name="full_description" id="full_description" class="form-control summernote" rows="4"
                                                placeholder="Nhập mô tả đầy đủ">{{ $data->full_description }}</textarea>
                                            @error('full_description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="submit" class="btn btn-success mr-2">Lưu thay đổi</button>
                                    <a href="{{ route('admin.products.show', $data->id) }}"
                                        class="btn btn-secondary">Hủy</a>
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


    <!-- Khởi tạo Summernote cho textarea -->
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Nhập mô tả đầy đủ',
                tabsize: 2,
                height: 640 // Chiều cao của editor
            });
        });
    </script>


    <!-- FilePond JS -->
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            FilePond.registerPlugin(FilePondPluginImagePreview);

            const avatarInput = document.getElementById("avatar");
            const avatarHidden = document.getElementById("avatar-hidden");

            const pond = FilePond.create(avatarInput, {
                allowMultiple: false,
                allowImagePreview: true,
                imagePreviewHeight: 200,
                labelIdle: "Kéo & thả ảnh hoặc <span class='filepond--label-action'>chọn ảnh</span>",
                server: {
                    process: {
                        url: "{{ url('/admin/upload-image') }}",
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        onload: (response) => {
                            try {
                                let res = JSON.parse(response);
                                if (res.success) {
                                    avatarHidden.value = res.path;
                                } else {
                                    alert("Lỗi: " + (res.message || "Không thể tải ảnh lên."));
                                }
                            } catch (error) {
                                console.error("Lỗi JSON:", error);
                                alert("Lỗi không xác định khi tải ảnh lên.");
                            }
                        }
                    },
                    revert: (filename, load) => {
                        fetch("{{ url('/admin/remove-image') }}", {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify({
                                    path: avatarHidden.value
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    avatarHidden.value = "";
                                } else {
                                    alert("Lỗi: " + (data.message || "Không thể xóa ảnh."));
                                }
                                load();
                            })
                            .catch(error => {
                                console.error("Lỗi khi xóa ảnh:", error);
                                alert("Lỗi kết nối đến server.");
                                load();
                            });
                    }
                }
            });

            // ✅ Thêm ảnh cũ vào FilePond sau khi khởi tạo
            let oldImage = "{{ $data->avatar ? asset('storage/' . $data->avatar) : '' }}";
            if (oldImage) {
                fetch(oldImage)
                    .then(res => {
                        if (res.ok) {
                            pond.addFile(oldImage, {
                                source: oldImage
                            });
                        } else {
                            console.error("Ảnh không tồn tại hoặc không thể tải.");
                        }
                    })
                    .catch(error => console.error("Lỗi khi tải ảnh:", error));
            }
        });
    </script>
@endsection
@section('style')
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

    <!-- FilePond CSS -->
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
@endsection

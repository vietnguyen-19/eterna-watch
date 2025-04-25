@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <form action="{{ route('admin.posts.update', $post->id) }}" autocomplete="off" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Cần sử dụng PUT để cập nhật -->

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="bg-light card-header border-bottom-dashed">
                                <h5 class="card-title mb-0"><b>Nội dung bài viết</b></h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <textarea name="content" id="content" class="form-control summernote" rows="4"
                                            placeholder="Nhập nội dung bài viết">{{ old('content', $post->content) }}</textarea>
                                        @error('content')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cột bên phải -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="bg-light card-header border-bottom-dashed">
                                <h5 class="card-title mb-0"><b>Thông tin bài viết</b></h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Email tác giả -->
                                    <div class="mb-4 col-md-12 col-sm-12">
                                        <label for="search-customer">Tác giả</label>
                                        <select name="user_id" style="width: 100%" id="search-customer"
                                            class="form-control border-primary shadow-sm">
                                            @if (isset($post))
                                                <option value="{{ $post->user->id }}" selected>
                                                    {{$post->user->name }} - {{ $post->user->email }}
                                                </option>
                                            @endif
                                            <!-- Các option sẽ được load động hoặc tự thêm vào đây -->
                                        </select>
                                        @error('user_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Tiêu đề -->
                                    <div class="mb-4 col-md-12">
                                        <label for="title" class="form-label">Tiêu đề</label>
                                        <input value="{{ old('title', $post->title) }}" name="title" type="text"
                                            id="title" class="form-control" placeholder="Nhập tiêu đề">
                                        @error('title')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Chọn ảnh mới (nếu muốn thay)</label>

                                        <div class="input-group">
                                            <input type="file"
                                                class="form-control d-none @error('image') is-invalid @enderror"
                                                id="avatar" name="image" accept="image/*"
                                                onchange="previewImage(this)">
                                            <label class="input-group-text btn btn-outline-primary w-100" for="avatar">
                                                <i class="fas fa-cloud-upload-alt mr-2"></i> Chọn ảnh
                                            </label>
                                        </div>

                                        @error('image')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror

                                        <div class="mt-3">
                                            <img src="{{ Storage::url($post->image) }}" id="previewImageTag"
                                                alt="Ảnh hiện tại" class="img-thumbnail w-100">
                                        </div>
                                    </div><!-- Ảnh đại diện -->


                                    <!-- Mô tả ngắn -->
                                    <div class="mb-4 col-md-12">
                                        <label for="excerpt" class="form-label">Mô tả ngắn</label>
                                        <textarea name="excerpt" id="excerpt" class="form-control" placeholder="Nhập mô tả ngắn">{{ old('excerpt', $post->excerpt) }}</textarea>
                                        @error('excerpt')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Trạng thái -->
                                    <div class="mb-4 col-md-6">
                                        <label for="status" class="form-label">Trạng thái</label>
                                        <select class="form-control" name="status">
                                            <option value="draft"
                                                {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Nháp
                                            </option>
                                            <option value="published"
                                                {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Đã xuất
                                                bản</option>
                                            <option value="archived"
                                                {{ old('status', $post->status) == 'archived' ? 'selected' : '' }}>Lưu trữ
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Ngày xuất bản -->
                                    <div class="mb-4 col-md-6">
                                        <label for="published_at" class="form-label">Ngày xuất bản</label>
                                        <input
                                            value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}"
                                            name="published_at" type="datetime-local" id="published_at"
                                            class="form-control">
                                        @error('published_at')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Chọn danh mục (Multiple) -->
                                    <div class="mb-4 col-md-6">
                                        <label for="categories" class="form-label">Danh mục</label>
                                        <select class="form-control" name="categories[]" id="categories" multiple>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ in_array($category->id, old('categories', $post->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('categories')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Chọn Tags (Multiple) -->
                                    <div class="mb-4 col-md-6">
                                        <label for="tags" class="form-label">Tags</label>
                                        <select class="form-control" name="tags[]" id="tags" multiple>
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->id }}"
                                                    {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                    {{ $tag->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('tags')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="hstack gap-2 justify-content-left">
                                    <button type="submit" class="btn btn-primary">Cập nhật bài viết</button>
                                    <a href="{{ route('admin.posts.index') }}" class="btn btn-light">Hủy</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
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
                height: $(window).height() // Chiều cao bằng toàn bộ màn hình
            });

            // Cập nhật chiều cao khi thay đổi kích thước cửa sổ
            $(window).resize(function() {
                $('.summernote').summernote('height', $(window).height());
            });
        });
    </script>
    <script>
        function previewImage(input) {
            const file = input.files[0];
            const preview = document.getElementById('previewImageTag');
            const container = document.getElementById('previewContainer');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#search-customer').select2({
                placeholder: 'Tìm kiếm người dùng theo tên hoặc email',
                ajax: {
                    url: "{{ route('admin.orders.user-search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term // Gửi từ khóa người dùng nhập
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(user) {
                                return {
                                    id: user
                                        .id, // Giá trị thực sẽ được gửi lên server khi submit form
                                    text: user.name + ' - ' + user.email
                                };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1
            });

        });
    </script>
@endsection
@section('style')
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

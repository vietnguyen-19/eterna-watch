@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <form action="{{ route('admin.posts.store') }}" autocomplete="off" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card" id="customerList">
                            <div class="bg-light card-header border-bottom-dashed ">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <div>
                                            <h5 class="card-title mb-0"><b>Nội dung bài viết</b></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <textarea name="content" id="content" class="form-control summernote" rows="4"
                                            placeholder="Nhập mô tả đầy đủ">{{ old('content') }}</textarea>
                                        @error('content')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-lg-4">
                        <div class="card" id="customerList">
                            <div class="bg-light card-header border-bottom-dashed ">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <div>
                                            <h5 class="card-title mb-0"><b>Thông tin bài viết</b></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <!-- Tiêu đề -->

                                    <div class="mb-4 col-md-12 col-sm-12">
                                        <label for="email_user" class="form-label">Email tác giả *</label>
                                        <input value="{{ old('email_user') }}" name="email_user" type="text" id="email_user"
                                            class="form-control" placeholder="Nhập email">
                                        @error('email_user')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-4 col-md-12 col-sm-12">
                                        <label for="title" class="form-label">Tiêu đề</label>
                                        <input value="{{ old('title') }}" name="title" type="text" id="title"
                                            class="form-control" placeholder="Nhập tiêu đề">
                                        @error('title')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Ảnh đại diện -->
                                    <div class="mb-4 col-md-12 col-sm-12">
                                        <label for="image" class="form-label">Ảnh đại diện</label>
                                        <input name="image" type="file" id="image" class="form-control">
                                        @error('image')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Mô tả ngắn -->
                                    <div class="mb-4 col-md-12">
                                        <label for="excerpt" class="form-label">Mô tả ngắn</label>
                                        <textarea name="excerpt" id="excerpt" class="form-control" placeholder="Nhập mô tả ngắn">{{ old('excerpt') }}</textarea>
                                        @error('excerpt')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Trạng thái -->
                                    <div class="mb-4 col-md-6 col-sm-12">
                                        <label for="status" class="form-label">Trạng thái</label>
                                        <select class="form-control" name="status" class="form-control" required>
                                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Nháp
                                            </option>
                                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>
                                                Đã xuất bản</option>
                                            <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>
                                                Lưu trữ</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Ngày xuất bản -->
                                    <div class="mb-4 col-md-6 col-sm-12">
                                        <label for="published_at" class="form-label">Ngày xuất bản</label>
                                        <input value="{{ old('published_at') }}" name="published_at" type="datetime-local"
                                            id="published_at" class="form-control">
                                        @error('published_at')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Chọn danh mục (Multiple) -->
                                    <div class="mb-4 col-md-6 col-sm-12">
                                        <label for="categories" class="form-label">Danh mục</label>
                                        <select class="form-control" name="categories[]" id="categories"
                                            class="form-control" multiple>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('categories')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Chọn Tags (Multiple) -->
                                    <div class="mb-4 col-md-6 col-sm-12">
                                        <label for="tags" class="form-label">Tags</label>
                                        <select class="form-control" name="tags[]" id="tags" class="form-control"
                                            multiple>
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->id }}"
                                                    {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
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
                                    <button type="submit" class="btn btn-success" id="add-btn">Thêm bài viết</button>
                                    <a href="{{ route('admin.posts.index') }}" class="btn btn-light">Đóng</a>
                                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
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
@endsection
@section('style')
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

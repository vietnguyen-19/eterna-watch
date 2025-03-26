@extends('layouts.admin')

@section('content')
    <h1>Thêm Mới Bài Viết</h1>

    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu Đề:</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Nội Dung:</label>
            <textarea name="content" id="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="author" class="form-label">Tác Giả:</label>
            <input type="text" name="author" id="author" class="form-control" value="{{ old('author') }}">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Hình Ảnh:</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Lưu Bài Viết</button>
        <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Quay Lại</a>
    </form>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Chỉnh sửa bài viết</h2>
    <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary mb-3">← Quay lại danh sách</a>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Tiêu đề -->
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề bài viết:</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $article->title) }}" required>
        </div>

        <!-- Nội dung -->
        <div class="mb-3">
            <label for="content" class="form-label">Nội dung bài viết:</label>
            <textarea name="content" id="content" class="form-control" rows="5" required>{{ old('content', $article->content) }}</textarea>
        </div>

        <!-- Tác giả -->
        <div class="mb-3">
            <label for="author" class="form-label">Tác giả:</label>
            <input type="text" name="author" id="author" class="form-control" value="{{ old('author', $article->author) }}" required>
        </div>

        <!-- Ảnh đại diện -->
        <div class="mb-3">
            <label for="image" class="form-label">Hình ảnh bài viết:</label>
            <input type="file" name="image" id="image" class="form-control">

            <!-- Hiển thị ảnh hiện tại -->
            @if($article->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $article->image) }}" width="150" alt="Ảnh bài viết">
                </div>
            @endif
        </div>

        <!-- Nút submit -->
        <button type="submit" class="btn btn-primary">Cập nhật bài viết</button>
    </form>
</div>
@endsection

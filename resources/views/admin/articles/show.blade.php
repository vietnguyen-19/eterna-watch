@extends('layouts.admin')

@section('content')
    <h1>Chi Tiết Bài Viết</h1>

    <div class="mb-3">
        <h3>{{ $article->title }}</h3>
        <p><strong>Tác giả:</strong> {{ $article->author ?? 'Không rõ' }}</p>
        <p><strong>Ngày tạo:</strong> {{ $article->created_at->format('d/m/Y') }}</p>
        <p><strong>Nội dung:</strong> {!! nl2br(e($article->content)) !!}</p>

        @if($article->image)
            <img src="{{ asset('storage/' . $article->image) }}" alt="Ảnh bài viết" width="300">
        @else
            <p>Không có hình ảnh</p>
        @endif
    </div>

    <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Quay Lại</a>
@endsection

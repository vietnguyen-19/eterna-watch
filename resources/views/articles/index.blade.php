@extends('layouts.app')

@section('content')
<h1>Danh sách bài viết</h1>
<a href="{{ route('admin.articles.create') }}" class="btn btn-primary">Thêm bài viết</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tiêu đề</th>
            <th>Tác giả</th>
            <th>Hình ảnh</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($articles as $article)
            <tr>
                <td>{{ $article->id }}</td>
                <td>{{ $article->title }}</td>
                <td>{{ $article->author }}</td>
                <td>
                    @if($article->image)
                        <img src="{{ asset('storage/' . $article->image) }}" width="100">
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-warning">Sửa</a>
                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $articles->links() }}
@endsection

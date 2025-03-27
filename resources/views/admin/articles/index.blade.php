@extends('layouts.admin')

@section('content')
    <h1>Danh Sách Bài Viết</h1>

    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">Thêm Bài Viết</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu Đề</th>
                <th>Tác Giả</th>
                <th>Hình Ảnh</th>
                <th>Ngày Tạo</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
                <tr>
                    <td>{{ $article->id }}</td>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->author ?? 'Không rõ' }}</td>
                    <td>
                        @if($article->image)
                            <img src="{{ asset('storage/' . $article->image) }}" width="80" alt="Ảnh bài viết">
                        @else
                            Không có ảnh
                        @endif
                    </td>
                    <td>{{ $article->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.articles.show', $article->id) }}" class="btn btn-info btn-sm">Xem</a>
                        <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xóa?');">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $articles->links() }}
@endsection

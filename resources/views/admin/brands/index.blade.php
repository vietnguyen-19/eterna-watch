@extends('admin.layouts.master')

@section('content')
    <h2>Danh sách Thương hiệu</h2>
    {{-- Hiển thị thông báo --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">Thêm mới</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Thương hiệu cha</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($brands as $brand)
                <tr>
                    <td>{{ $brand->id }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>{{ $brand->parent?->name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-warning">Sửa</a>
                        <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

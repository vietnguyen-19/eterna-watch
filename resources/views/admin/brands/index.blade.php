@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h2 class="mt-3 mb-4">Danh sách Thương hiệu</h2>

        {{-- Hiển thị thông báo --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ trim(session('success')) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Ô tìm kiếm --}}
        <form method="GET" action="{{ route('admin.brands.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm thương hiệu..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary">Tìm kiếm</button>
            </div>
        </form>

        <a href="{{ route('admin.brands.create') }}" class="btn btn-primary mb-3">Thêm mới</a>

        <table class="table table-bordered table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Thương hiệu cha</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($brands as $brand)
                    <tr>
                        <td>{{ $brand->id }}</td>
                        <td>{{ $brand->name }}</td>
                        <td>{{ $brand->parent?->name ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-muted">Không có thương hiệu nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Hiển thị phân trang --}}
        {{-- <div class="d-flex justify-content-center">
            {{ $brands->links() }}
        </div> --}}
    </div>
@endsection

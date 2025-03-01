@extends('admin.layouts.master')

@section('content')
    <h2>Chỉnh sửa Thương hiệu</h2>
    <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Tên Thương hiệu</label>
            <input type="text" name="name" class="form-control" value="{{ $brand->name }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Thương hiệu cha (nếu có)</label>
            <select name="parent_id" class="form-control">
                <option value="">Không có</option>
                @foreach($brands as $b)
                    <option value="{{ $b->id }}" {{ $b->id == $brand->parent_id ? 'selected' : '' }}>{{ $b->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
@endsection

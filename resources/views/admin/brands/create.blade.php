@extends('admin.layouts.master')

@section('content')
    <h2>Thêm Thương hiệu</h2>
    <form action="{{ route('admin.brands.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Tên Thương hiệu</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Thương hiệu cha (nếu có)</label>
            <select name="parent_id" class="form-control">
                <option value="">Không có</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
@endsection

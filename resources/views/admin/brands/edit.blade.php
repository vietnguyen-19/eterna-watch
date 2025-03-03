@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h2 class="mt-3 mb-4">Chỉnh sửa Thương hiệu</h2>

        {{-- Hiển thị lỗi --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card p-4 shadow-lg">
            <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">Tên Thương hiệu</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', $brand->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Thương hiệu cha (nếu có)</label>
                    <select name="parent_id" class="form-select">
                        <option value="">Không có</option>
                        @foreach($brands as $b)
                            <option value="{{ $b->id }}" 
                                {{ old('parent_id', $brand->parent_id) == $b->id ? 'selected' : '' }}>
                                {{ $b->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Cập nhật</button>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
            </form>
        </div>
    </div>
@endsection

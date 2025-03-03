@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h2 class="mt-3 mb-4">Thêm Thương hiệu</h2>

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
            <form action="{{ route('admin.brands.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên Thương hiệu</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Thương hiệu cha (nếu có)</label>
                    <select name="parent_id" class="form-select">
                        <option value="">Không có</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('parent_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Lưu</button>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
            </form>
        </div>
    </div>
@endsection

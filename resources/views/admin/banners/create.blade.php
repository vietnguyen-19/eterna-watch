@extends('admin.layouts.master')

@section('title', 'Thêm Mới Banner')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Thêm Mới Banner</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="image">Ảnh Banner <span class="text-danger">*</span></label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" required>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="redirect_link">Đường dẫn chuyển hướng</label>
                    <input type="text" name="redirect_link" id="redirect_link" class="form-control @error('redirect_link') is-invalid @enderror" value="{{ old('redirect_link') }}" placeholder="Nhập URL chuyển hướng">
                    @error('redirect_link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">Thêm mới</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
@endsection

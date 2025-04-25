@extends('admin.layouts.master')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Cập nhật banner</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Hiển thị ảnh hiện tại -->
                    <div class="mb-3">
                        <label class="form-label">Ảnh hiện tại:</label><br>
                        @if ($banner->image_link)
                            <img src="{{ asset($banner->image_link) }}" alt="Banner Image" width="200">
                        @else
                            <p class="text-muted">Chưa có ảnh</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Chọn ảnh mới:</label>
                        <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror">

                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Redirect Link -->
                    <div class="mb-3">
                        <label for="redirect_link" class="form-label">Đường dẫn chuyển hướng:</label>
                        <input type="text" id="redirect_link" name="redirect_link" class="form-control @error('redirect_link') is-invalid @enderror" value="{{ old('redirect_link', $banner->redirect_link) }}">

                        @error('redirect_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-success">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

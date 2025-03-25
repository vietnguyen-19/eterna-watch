@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Thêm mới Banner</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Upload Image -->
                <div class="mb-3">
                    <label class="form-label" for="image">Chọn ảnh</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" required>

                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Redirect Link--->
                <div class="mb-3">
                    <label class="form-label" for="redirect_link">Redirect Link</label>
                    <input type="text" name="redirect_link" id="redirect_link" class="form-control @error('redirect_link') is-invalid @enderror" placeholder="Enter redirect URL" value="{{ old('redirect_link') }}">

                    @error('redirect_link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Thêm mới</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
            </form>
        </div>
    </div>
</div>
@endsection

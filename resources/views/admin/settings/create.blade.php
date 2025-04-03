@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h2>Thêm cài đặt mới</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.settings.store') }}">
        @csrf
        
        <div class="card mb-3">
            <div class="card-header">Thông tin cài đặt</div>
            <div class="card-body">
                <div class="form-group">
                    <label>Tên khóa cài đặt</label>
                    <input type="text" name="key_name" class="form-control @error('key_name') is-invalid @enderror" value="{{ old('key_name') }}">
                    @error('key_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label>Giá trị cài đặt</label>
                    <input type="text" name="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value') }}">
                    @error('value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Lưu cài đặt</button>
        <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
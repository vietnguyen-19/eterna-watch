@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Cài đặt Admin</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Form để cập nhật cài đặt -->
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="site_name" class="form-label">Tên website</label>
            <input type="text" class="form-control" id="site_name" name="site_name" value="{{ $settings['site_name'] ?? '' }}" required>
            @error('site_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="contact_email" class="form-label">Địa chỉ email liên hệ</label>
            <input type="email" class="form-control" id="contact_email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" required>
            @error('contact_email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật cài đặt</button>
    </form>
</div>
@endsection
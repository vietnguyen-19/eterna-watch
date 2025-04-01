@extends('admin.layouts.master')
@section('content')
<div class="container">
    <h2>Cài đặt</h2>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('settings.store') }}">
        @csrf
        
        <!-- Cài đặt ngôn ngữ -->
        <div class="card mb-3">
            <div class="card-header">Cài đặt ngôn ngữ</div>
            <div class="card-body">
                <div class="form-group">
                    <label>Ngôn ngữ</label>
                    <select name="language" class="form-control">
                        <option value="vi" {{ $setting->language == 'vi' ? 'selected' : '' }}>Tiếng Việt</option>
                        <option value="en" {{ $setting->language == 'en' ? 'selected' : '' }}>English</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Cài đặt thông báo -->
        <div class="card mb-3">
            <div class="card-header">Cài đặt thông báo</div>
            <div class="card-body">
                <div class="form-check">
                    <input type="checkbox" name="notification_email" value="1" 
                        class="form-check-input" {{ $setting->notification_email ? 'checked' : '' }}>
                    <label class="form-check-label">Email</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="notification_sms" value="1"
                        class="form-check-input" {{ $setting->notification_sms ? 'checked' : '' }}>
                    <label class="form-check-label">SMS</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="notification_app" value="1"
                        class="form-check-input" {{ $setting->notification_app ? 'checked' : '' }}>
                    <label class="form-check-label">Trong ứng dụng</label>
                </div>
            </div>
        </div>

        <!-- Cài đặt quyền riêng tư -->
        <div class="card mb-3">
            <div class="card-header">Cài đặt quyền riêng tư</div>
            <div class="card-body">
                <div class="form-group">
                    <label>Ai có thể xem hồ sơ</label>
                    <select name="privacy_profile" class="form-control">
                        <option value="public" {{ $setting->privacy_profile == 'public' ? 'selected' : '' }}>Mọi người</option>
                        <option value="friends" {{ $setting->privacy_profile == 'friends' ? 'selected' : '' }}>Bạn bè</option>
                        <option value="private" {{ $setting->privacy_profile == 'private' ? 'selected' : '' }}>Chỉ mình tôi</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Cài đặt giao diện -->
        <div class="card mb-3">
            <div class="card-header">Cài đặt giao diện</div>
            <div class="card-body">
                <div class="form-group">
                    <label>Chủ đề</label>
                    <select name="theme" class="form-control">
                        <option value="light" {{ $setting->theme == 'light' ? 'selected' : '' }}>Sáng</option>
                        <option value="dark" {{ $setting->theme == 'dark' ? 'selected' : '' }}>Tối</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Cài đặt hỗ trợ -->
        <div class="card mb-3">
            <div class="card-header">Hỗ trợ</div>
            <div class="card-body">
                <a href="{{ route('support') }}" class="btn btn-info">Gửi yêu cầu hỗ trợ</a>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Lưu cài đặt</button>
    </form>
</div>
@endsection
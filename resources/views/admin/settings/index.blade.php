@extends('admin.layouts.master')

@section('content')
<//?php dd($settings); ?>
<div class="container">
    <h2>Danh sách cài đặt</h2>

    <!-- Hiển thị thông báo thành công nếu có -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Nút tạo cài đặt mới -->
    <div class="mb-3">
        <a href="{{ route('admin.settings.create') }}" class="btn btn-primary">Tạo cài đặt mới</a>
    </div>

    <div class="card">
        <div class="card-header">Danh sách cài đặt hiện tại</div>
        <div class="card-body">
            @if ($settings->isEmpty())
                <p>Chưa có cài đặt nào được thiết lập.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên khóa</th>
                            <th>Giá trị</th>
                            <th>Người tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($settings as $setting)
                           
                            <tr>
                                <td>{{ $setting->id }}</td>
                                <td>{{ $setting->key_name }}</td>
                                <td>{{ $setting->value }}</td>
                                <td>
                                    @if ($setting->user)
                                        {{ $setting->user->id }} <!-- Hiển thị ID của user -->
                                    @else
                                        Không có
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.settings.edit', $setting->id) }}" class="btn btn-warning btn-sm">Chỉnh sửa</a>
                                    <form action="{{ route('admin.settings.destroy', $setting->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa cài đặt này?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
@extends('admin.layouts.roles')

@section('content')
<div class="container">
    <h1>Danh sách Role</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('roles.create') }}" class="btn btn-primary mb-3">Thêm Role mới</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Role</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        <a href="{{ route('roles.show', $role->id) }}" class="btn btn-info">Xem</a>
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">Sửa</a>
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

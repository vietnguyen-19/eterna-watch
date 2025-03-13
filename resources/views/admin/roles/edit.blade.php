@extends('admin.layouts.roles')

@section('content')
<div class="container">
    <h1>Sửa Role</h1>
    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Tên Role</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Cập nhật</button>
    </form>
</div>
@endsection

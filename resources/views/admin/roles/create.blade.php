@extends('admin.layouts.roles')

@section('content')
<div class="container">
    <h1>Thêm Role mới</h1>
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Tên Role</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Lưu</button>
    </form>
</div>
@endsection

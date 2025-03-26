@extends('admin.layouts.roles')

@section('content')
<div class="container">
    <h1>Chi tiết Role</h1>
    <div class="card">
        <div class="card-header">
            <strong>{{ $role->name }}</strong>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $role->id }}</p>
            <p><strong>Tên Role:</strong> {{ $role->name }}</p>
        </div>
    </div>

    <a href="{{ route('admin.roles.index') }}" class="btn btn-primary mt-3">Quay lại danh sách</a>
</div>
@endsection

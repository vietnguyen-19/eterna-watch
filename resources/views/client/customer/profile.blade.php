@extends('layouts.customer')

@section('content')
<div class="container">
    <h2>Tài khoản của tôi</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Thông tin cá nhân</h5>
            <p class="card-text">Tên: {{ $user->name }}</p>
            <p class="card-text">Email: {{ $user->email }}</p>
            <a href="#" class="btn btn-primary">Chỉnh sửa thông tin</a>
        </div>
    </div>
</div>
@endsection

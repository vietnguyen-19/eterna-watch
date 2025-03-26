@extends('layouts.customer')

@section('content')
<div class="container">
    <h2>Quản lý địa chỉ giao hàng</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Địa chỉ</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($addresses as $address)
            <tr>
                <td>{{ $address->address }}</td>
                <td>
                    <a href="#" class="btn btn-warning">Chỉnh sửa</a>
                    <form action="#" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="#" class="btn btn-success">Thêm địa chỉ mới</a>
</div>
@endsection

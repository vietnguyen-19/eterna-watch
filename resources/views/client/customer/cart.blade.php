@extends('layouts.customer')

@section('content')
<div class="container">
    <h2>Giỏ hàng của tôi</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cartItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->product->price }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->product->price * $item->quantity }}</td>
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
    <a href="#" class="btn btn-success">Tiến hành thanh toán</a>
</div>
@endsection

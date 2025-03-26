@extends('layouts.customer')

@section('content')
<div class="container">
    <h2>Quản lý đơn hàng</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Đơn hàng</th>
                <th>Tổng giá trị</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->total_amount }}</td>
                <td>{{ $order->status }}</td>
                <td><a href="#" class="btn btn-primary">Xem chi tiết</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

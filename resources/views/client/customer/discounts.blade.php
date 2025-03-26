@extends('layouts.customer')

@section('content')
<div class="container">
    <h2>Các mã giảm giá</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Mã giảm giá</th>
                <th>Giảm giá</th>
                <th>Ngày hết hạn</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($discounts as $discount)
            <tr>
                <td>{{ $discount->code }}</td>
                <td>{{ $discount->amount }}%</td>
                <td>{{ $discount->expiration_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@extends('layouts.customer')

@section('content')
<div class="container">
    <h2>Thông báo của tôi</h2>
    <ul class="list-group">
        @foreach ($notifications as $notification)
        <li class="list-group-item">
            {{ $notification->data['message'] }}
        </li>
        @endforeach
    </ul>
</div>
@endsection

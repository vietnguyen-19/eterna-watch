@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="my-4 text-center">Tin Tức Mới Nhất</h2>
    <div class="row">
        @foreach($news as $item)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->title }}</h5>
                        <p class="card-text">{{ Str::limit($item->content, 100) }}</p>
                        <a href="{{ route('news.show', $item->slug) }}" class="btn btn-primary">Đọc tiếp</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{ $news->links() }}
    </div>
</div>
@endsection

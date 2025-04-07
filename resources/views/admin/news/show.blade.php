@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="my-4 text-center">{{ $newsItem->title }}</h2>
    <img src="{{ asset('storage/' . $newsItem->image) }}" class="img-fluid mb-3" alt="{{ $newsItem->title }}">
    <p>{!! nl2br(e($newsItem->content)) !!}</p>
    <a href="{{ route('news.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
</div>
@endsection

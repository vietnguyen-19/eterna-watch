@extends('admin.layouts.master')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h2 class="mb-0">Banner Details</h2>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>ID:</strong> {{ $banner->id }}
                </div>
                <div class="mb-3">
                    <strong>Image Link:</strong>
                    <a href="{{ $banner->image_link }}" target="_blank">{{ $banner->image_link }}</a>
                </div>
                <div class="mb-3">
                    <strong>Redirect Link:</strong>
                    @if ($banner->redirect_link)
                        <a href="{{ $banner->redirect_link }}" target="_blank">{{ $banner->redirect_link }}</a>
                    @else
                        <span class="text-muted">No link</span>
                    @endif
                </div>
                <div class="mb-3">
                    <img src="{{ $banner->image_link }}" alt="Banner Image" class="img-fluid" width="300">
                </div>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
@endsection

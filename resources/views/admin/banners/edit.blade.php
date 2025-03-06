@extends('admin.layouts.master')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Edit Banner</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="image_link" class="form-label">Image Link:</label>
                        <input type="text" id="image_link" name="image_link" class="form-control"
                            value="{{ $banner->image_link }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="redirect_link" class="form-label">Redirect Link:</label>
                        <input type="text" id="redirect_link" name="redirect_link" class="form-control"
                            value="{{ $banner->redirect_link }}">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Back to List</a>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

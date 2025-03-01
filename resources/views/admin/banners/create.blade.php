@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Add New Banner</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.banners.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Image Link</label>
                    <input type="text" name="image_link" class="form-control" placeholder="Enter image URL" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Redirect Link</label>
                    <input type="text" name="redirect_link" class="form-control" placeholder="Enter redirect URL">
                </div>

                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
            </form>
        </div>
    </div>
</div>
@endsection

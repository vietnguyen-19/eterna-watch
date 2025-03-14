@extends('admin.layouts.master')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3">Danh sách Banner</h2>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary mb-3">Thêm mới Banner</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Image Link</th>
                        <th>Redirect Link</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($banners as $banner)
                        <tr>
                            <td>{{ $banner->id }}</td>
                            <td>
                                <a href="{{ $banner->image_link }}" target="_blank" title="{{ $banner->image_link }}">
                                    {{ Str::limit($banner->image_link, 30, '...') }}
                                </a>
                            </td>

                            <td>
                                @if ($banner->redirect_link)
                                    <a href="{{ $banner->redirect_link }}" target="_blank">{{ $banner->redirect_link }}</a>
                                @else
                                    <span class="text-muted">No link</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.banners.show', $banner->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

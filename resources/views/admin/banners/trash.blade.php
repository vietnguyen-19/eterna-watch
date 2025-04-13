@extends('admin.layouts.master')

@section('content')
    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Banner đã xóa</h3>
                        </div>
                        <div class="card-body">
                            @if(session('thongbao'))
                                <div class="alert alert-{{ session('thongbao')['type'] }} alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {{ session('thongbao')['message'] }}
                                </div>
                            @endif
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ảnh</th>
                                        <th>Tiêu để</th>
                                        <th>Ngày xóa</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($banners as $banner)
                                    <tr>
                                        <td class="align-middle">{{ $banner->id }}</td>
                                        <td style="width: 80px;">
                                            <div style="position: relative; width: 100%; padding-top: 56.25%; overflow: hidden; border-radius: 6px;">
                                                @if ($banner->image)
                                                    <img src="{{ Storage::url($banner->image ?? 'avatar/default.jpeg') }}"
                                                         alt="Banner"
                                                         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('theme/velzon/assets/images/no-img.jpg') }}"
                                                         alt="No Image"
                                                         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                                @endif
                                            </div>
                                        </td>
                                        
                                        <td class="align-middle">{{ $banner->title ?? '#' }}</td>
                                        <td class="align-middle">{{ $banner->deleted_at->format('d/m/Y H:i') }}</td>
                                        <td class="align-middle">
                                            <form action="{{ route('admin.banners.restore', $banner->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Khôi phục</button>
                                            </form>
                                            <form action="{{ route('admin.banners.forceDelete', $banner->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xóa vĩnh viễn không thể khôi phục. Tiếp tục?')">
                                                    Xóa vĩnh viễn
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Quay lại</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

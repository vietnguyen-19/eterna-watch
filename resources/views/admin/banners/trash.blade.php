@extends('admin.layouts.master')

@section('content')
    <section class="content">
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
                                        <th>Link chuyển hướng</th>
                                        <th>Ngày xóa</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($banners as $banner)
                                    <tr>
                                        <td>{{ $banner->id }}</td>
                                        <td>
                                            @if($banner->image_link)
                                                <img src="{{ $banner->image_link }}" width="100" alt="Banner">
                                            @else
                                                No Image
                                            @endif
                                        </td>
                                        <td>{{ $banner->redirect_link ?? '#' }}</td>
                                        <td>{{ $banner->deleted_at->format('d/m/Y H:i') }}</td>
                                        <td>
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

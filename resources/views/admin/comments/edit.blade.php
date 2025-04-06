@extends('admin.layouts.master')
@section('content')
    <div class="col-lg-12">
        <div class="card" id="customerList">
            <div class="col-12">
                @if (session('thongbao'))
                    <div id="thongbao-alert"
                        class="alert alert-{{ session('thongbao.type') }} alert-dismissible bg-{{ session('thongbao.type') }} text-white alert-label-icon fade show"
                        role="alert">
                        <i class="ri-notification-off-line label-icon"></i><strong>
                            {{ session('thongbao.message') }}</strong>

                    </div>
                    @php
                        session()->forget('thongbao');
                    @endphp
                @endif

                <div class="card-header border-bottom-dashed">

                    <div class="row g-4 align-items-center">
                        <div class="col-sm">
                            <div>
                                <h5 class="card-title mb-0">Chỉnh sửa bình luận</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.comments.update', $item->id) }}" autocomplete="off" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="body row">
                            @if ($item->entity_type === 'product')
                                <div class="row col-3">
                                    <label for="name" class="form-label">Đánh giá</label>
                                    <div class="mb-3 col-12">
                                            @for ($i = 0; $i < $item->rating; $i++)
                                                <i class="fa-solid fa-star text-warning"></i>
                                            @endfor

                                    </div>
                                </div>
                                @else
                                <span class="text-muted"></span>
                            @endif
                            <div class="mb-3 col-9">
                                <label for="name" class="form-label">Nội dung bình luận</label>
                                <input value="{{ old('content', $item->content) }}" name="content" type="text"
                                    id="content" class="form-control" placeholder="Enter content">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-3">
                                <label for="status" class="form-label">Trạng thái mới</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Chờ duyệt
                                    </option>
                                    <option value="approved" {{ $item->status == 'approved' ? 'selected' : '' }}>Chấp thuận
                                    </option>
                                    <option value="rejected" {{ $item->status == 'rejected' ? 'selected' : '' }}>Từ chối
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="hstack gap-2 justify-content-left">
                            <button type="submit" class="btn btn-success" id="add-btn">Cập nhật danh mục</button>
                            @if ($item->entity_type === 'product')
                            <a href="{{ route('admin.comments.product') }}" class="btn btn-light">Đóng</a>
                            @else
                            <a href="{{ route('admin.comments.index') }}" class="btn btn-light">Đóng</a>
                            @endif
                        </div>
                    </div>
                </form>

            </div>


        </div>

    </div>
@endsection
@section('script-lib')
    <script src="http://chiccorner-project.test/theme/velzon/assets/libs/list.js/list.min.js"></script>
    <script src="http://chiccorner-project.test/theme/velzon/assets/libs/list.pagination.js/list.pagination.min.js">
    </script>
    <script src="{{ asset('theme/velzon/assets/libs/list.js/list.min.js') }}"></script>
    <script src="{{ asset('theme/velzon/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ asset('theme/velzon/assets/js/pages/ecommerce-customer-list.init.js') }}"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
@section('script')
    <script>
        document.getElementById('name').addEventListener('input', function() {
            // Lấy giá trị từ ô nhập liệu Tên danh mục
            var tenDanhMuc = this.value;

            // Chuyển đổi Tên danh mục thành Slug
            var slug = tenDanhMuc.toLowerCase()
                .normalize('NFD') // Chuẩn hóa Unicode để xử lý các ký tự tiếng Việt
                .replace(/[\u0300-\u036f]/g, '') // Xóa các dấu phụ
                .replace(/[^a-z0-9\s-]/g, '') // Xóa các ký tự đặc biệt không phải chữ cái Latin hoặc số
                .replace(/\s+/g, '-') // Thay thế khoảng trắng bằng dấu gạch ngang
                .replace(/-+/g, '-'); // Loại bỏ các dấu gạch ngang thừa

            // Gán giá trị Slug vào ô nhập liệu Slug
            document.getElementById('slug').value = slug;
        });
    </script>
@endsection
@section('style')
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />
@endsection

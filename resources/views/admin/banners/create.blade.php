@section('content')
    <div class="col-lg-12 mt-3">
        <div class="card" id="bannerList">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">Thêm mới Banner</h5>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.banners.store') }}" autocomplete="off" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="body row">
                        <div class="mb-3 col-12">
                            <label for="title" class="form-label">Tiêu đề Banner</label>
                            <input value="{{ old('title') }}" name="title" type="text" id="title"
                                class="form-control" placeholder="Nhập tiêu đề">
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-12">
                            <label for="link" class="form-label">Đường dẫn</label>
                            <input value="{{ old('link') }}" name="link" type="text" id="link"
                                class="form-control" placeholder="Nhập đường dẫn">
                            @error('link')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-12">
                            <label for="type">Loại Banner</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="1">Banner Home</option>
                                <option value="2">Slider Home</option>
                                <option value="3">Banner New Product</option>
                                <option value="4">Slider New Product</option>
                            </select>
                            @error('type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-12">
                            <label for="order" class="form-label">Thứ tự hiển thị</label>
                            <input value="{{ old('order', 0) }}" name="order" type="number" id="order"
                                class="form-control" placeholder="Nhập thứ tự">
                            @error('order')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-12">
                            <label for="status">Trạng thái</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="1" selected>Hiển thị</option>
                                <option value="0">Ẩn</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="hstack gap-2 justify-content-left">
                        <button type="submit" class="btn btn-success" id="add-btn">Thêm Banner</button>
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-light">Đóng</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
@endsection
@section('style')
@endsection

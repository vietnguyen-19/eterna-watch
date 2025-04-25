@extends('admin.layouts.master')
@section('content')
<section class="content pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="customerList">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">Thêm mới giá trị thuộc tính | <b>{{ $attribute->attribute_name }}</b></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('admin.attribute_values.store') }}" autocomplete="off" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="body row">
                                <input type="hidden" name="attribute_id" value="{{ $attribute->id }}">
                                <div class="mb-3 col-12">
                                    <label for="value_name" class="form-label">Giá trị thuộc tính</label>
                                    <input value="{{ old('value_name') }}" name="value_name" type="text" id="value_name"
                                        class="form-control" placeholder="Nhập giá trị">
                                    @error('value_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-12">
                                    <label for="note" class="form-label">Ghi chú</label>
                                    <input value="{{ old('note') }}" name="note" type="text" id="note"
                                        class="form-control" placeholder="Nhập ghi chú">
                                    @error('note')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="hstack gap-2 justify-content-left">
                                <button type="submit" class="btn btn-success" id="add-btn">Thêm giá trị</button>
                                <a href="{{ route('admin.attribute_values.index', $attribute->id) }}" class="btn btn-light">Đóng</a>
                                <!-- <button type="button" class="btn btn-success" id="edit-btn">Cập nhật</button> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script-lib')
    <script src="http://chiccorner-project.test/theme/velzon/assets/libs/list.js/list.min.js"></script>
    <script src="http://chiccorner-project.test/theme/velzon/assets/libs/list.pagination.js/list.pagination.min.js"></script>
    <script src="{{ asset('theme/velzon/assets/libs/list.js/list.min.js') }}"></script>
    <script src="{{ asset('theme/velzon/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>

    <!-- Khởi tạo danh sách khách hàng -->
    <script src="{{ asset('theme/velzon/assets/js/pages/ecommerce-customer-list.init.js') }}"></script>

    <!-- Thư viện SweetAlert -->
    <script src="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection

@section('script')
    <script>
        document.getElementById('name')?.addEventListener('input', function() {
            var tenDanhMuc = this.value;

            var slug = tenDanhMuc.toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');

            document.getElementById('slug')?.value = slug;
        });
    </script>
@endsection

@section('style')
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

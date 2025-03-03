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
                                        <h5 class="card-title mb-0">Thêm mới giá trị thuộc tính |
                                            <b>{{ $attributeValue->attribute->attribute_name }}</b>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('admin.attribute_values.update', $attributeValue->id) }}" method="POST"
                            autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="body row">

                                    <input type="hidden" name="attribute_id" value="{{ $attributeValue->attribute_id }}">
                                    <div class="mb-3 col-12">
                                        <label for="value_name" class="form-label">Gía trị thuộc tính</label>
                                        <input value="{{ $attributeValue->value_name }}" name="value_name" type="text"
                                            id="value_name" class="form-control" placeholder="Enter name">
                                        @error('value_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label for="note" class="form-label">Ghi chú</label>
                                        <input value="{{ $attributeValue->note }}" name="note" type="text"
                                            id="note" class="form-control" placeholder="Enter name">
                                        @error('note')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="hstack gap-2 justify-content-left">
                                    <button type="submit" class="btn btn-success" id="add-btn">Cập nhật giá trị </button>
                                    <a href="{{ route('admin.attribute_values.index', $attributeValue->attribute_id) }}"
                                        class="btn btn-light">Đóng</a>
                                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                </div>
                            </div>
                        </form>
                    </div>


                </div>

            </div>
        </div>
    </section>


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

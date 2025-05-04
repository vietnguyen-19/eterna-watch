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
                                        <h5 class="card-title mb-0"><b>Thêm mới mã ưu đãi</b></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('admin.vouchers.store') }}" autocomplete="off" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="body row">
                                    <!-- Tiêu đề -->
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Tiêu đề mã giảm giá</label>
                                        <input value="{{ old('name') }}" name="name" type="text" id="name" class="form-control" placeholder="Nhập tiêu đề">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Slug (ẩn) -->
                                    <div class="mb-3 col-md-6 d-none">
                                        <label for="slug" class="form-label">Slug</label>
                                        <input value="{{ old('slug') }}" name="slug" type="text" id="slug" class="form-control">
                                        @error('slug')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Mã voucher -->
                                    <div class="mb-3 col-md-6">
                                        <label for="code" class="form-label">Mã Voucher</label>
                                        <input value="{{ old('code') }}" name="code" type="text" id="code" class="form-control" placeholder="Nhập mã voucher">
                                        @error('code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Loại giảm giá -->
                                    <div class="mb-3 col-md-6">
                                        <label for="discount_type" class="form-label">Loại Giảm Giá</label>
                                        <select name="discount_type" id="discount_type" class="form-control">
                                            <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Giảm theo phần trăm</option>
                                            <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Giảm theo số tiền</option>
                                        </select>
                                        @error('discount_type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Giá trị giảm -->
                                    <div class="mb-3 col-md-6">
                                        <label for="discount_value" class="form-label">Giá Trị Giảm</label>
                                        <input value="{{ old('discount_value') }}" name="discount_value" type="number" id="discount_value" class="form-control" placeholder="Nhập giá trị giảm">
                                        @error('discount_value')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Giá trị đơn hàng tối thiểu -->
                                    <div class="mb-3 col-md-6">
                                        <label for="min_order" class="form-label">Giá Trị Đơn Hàng Tối Thiểu</label>
                                        <input value="{{ old('min_order') }}" name="min_order" type="number" id="min_order" class="form-control" placeholder="Không yêu cầu nếu để trống">
                                        @error('min_order')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Số lần sử dụng tối đa -->
                                    <div class="mb-3 col-md-6">
                                        <label for="max_uses" class="form-label">Số Lần Sử Dụng Tối Đa</label>
                                        <input value="{{ old('max_uses') }}" name="max_uses" type="number" id="max_uses" class="form-control" placeholder="Không giới hạn nếu để trống">
                                        @error('max_uses')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Ngày bắt đầu -->
                                    <div class="mb-3 col-md-6">
                                        <label for="start_date" class="form-label">Ngày Bắt Đầu</label>
                                        <input value="{{ old('start_date') }}" name="start_date" type="datetime-local" id="start_date" class="form-control">
                                        @error('start_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Ngày hết hạn -->
                                    <div class="mb-3 col-md-6">
                                        <label for="expires_at" class="form-label">Ngày Hết Hạn</label>
                                        <input value="{{ old('expires_at') }}" name="expires_at" type="datetime-local" id="expires_at" class="form-control">
                                        @error('expires_at')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Trạng thái -->
                                    <div class="mb-3 col-md-6">
                                        <label for="status">Trạng Thái</label>
                                        <select name="status" class="form-control">
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                                            <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Không hoạt động</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="hstack gap-2">
                                    <button type="submit" class="btn btn-success">Thêm mới</button>
                                    <a href="{{ route('admin.vouchers.index') }}" class="btn btn-light">Đóng</a>
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
    <script src="{{ asset('theme/velzon/assets/libs/list.js/list.min.js') }}"></script>
    <script src="{{ asset('theme/velzon/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
    <script src="{{ asset('theme/velzon/assets/js/pages/ecommerce-customer-list.init.js') }}"></script>
    <script src="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection

@section('script')
    <script>
        document.getElementById('name').addEventListener('input', function () {
            var tenDanhMuc = this.value;
            var slug = tenDanhMuc.toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            document.getElementById('slug').value = slug;
        });
    </script>
@endsection

@section('style')
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

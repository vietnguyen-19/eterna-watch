
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
                                    <h5 class="card-title mb-0">Thêm mới tài khoản nhân viên</h5>
                                </div>
                            </div>
                        </div>
                    </div>
        
        
                    <form action="{{ route('admin.users.store') }}" autocomplete="off" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="body row">
                                <!-- Tên -->
                                <div class="mb-3 col-6">
                                    <label for="name" class="form-label">Họ và Tên</label>
                                    <input value="{{ old('name') }}" name="name" type="text" id="name"
                                        class="form-control" placeholder="Nhập họ và tên">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
        
                                <!-- Email -->
                                <div class="mb-3 col-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input value="{{ old('email') }}" name="email" type="email" id="email"
                                        class="form-control" placeholder="Nhập email">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input value="{{ old('phone') }}" name="phone" type="text" id="phone"
                                        class="form-control" placeholder="Nhập số điện thoại">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
        
                                <!-- Mật khẩu -->
                                <div class="mb-3 col-6">
                                    <label for="password" class="form-label">Mật khẩu</label>
                                    <input name="password" type="password" id="password" class="form-control"
                                        placeholder="Nhập mật khẩu">
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
        
                                <!-- Giới tính -->
                                <div class="mb-3 col-6">
                                    <label for="gender">Giới tính</label>
                                    <select name="gender" class="form-control">
                                        <option value="">Chọn giới tính</option>
                                        <option value="male">Nam</option>
                                        <option value="female">Nữ</option>
                                        <option value="other">Khác</option>
                                    </select>
                                    @error('gender')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
        
                                <!-- Avatar -->
        
                                <!-- Ghi chú -->
                                
        
                                <!-- Vai trò -->
                                <div class="mb-3 col-6">
                                    <label for="role_id" class="form-label">Vai trò</label>
                                    <select name="role_id" class="form-control">
                                        <option value="">Chọn vai trò</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-12">
                                    <label for="note" class="form-label">Ghi chú</label>
                                    <textarea name="note" id="note" class="form-control" rows="3" placeholder="Nhập ghi chú">{{ old('note') }}</textarea>
                                    @error('note')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                               
                            </div>
                        </div>
        
                        <div class="card-footer">
                            <div class="hstack gap-2 justify-content-left">
                                <button type="submit" class="btn btn-success">Thêm tài khoản</button>
                                <a href="{{ route('admin.users.index',['id' => 2]) }}" class="btn btn-light">Đóng</a>
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
@endsection
@section('style')
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />
@endsection


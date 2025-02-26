@extends('admin.layouts.master')
@section('content')
    <section class="content pt-3">
        <form action="{{ route('admin.users.update', $user->id) }}" autocomplete="off" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" id="customerList">
                            <div class="card-header border-bottom-dashed">

                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <div>
                                            <h5 class="card-title mb-0"><b>Cập nhật thông tin người dùng</b></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Sử dụng PUT để cập nhật -->
                            <div class="card-body">
                                <div class="row">
                                    <!-- Avatar bên trái (col-4) -->


                                    <!-- Các thuộc tính còn lại bên phải (col-8) -->
                                    <div class="col-md-9">
                                        <!-- Tên người dùng -->
                                        <div class="row">
                                            <div class="mb-3 col-12">
                                                <label for="name" class="form-label">Tên người dùng</label>
                                                <input value="{{ old('name', $user->name) }}" name="name" type="text"
                                                    id="name" class="form-control" placeholder="Nhập tên người dùng"
                                                    >
                                                @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Email -->
                                            <div class="mb-3 col-12">
                                                <label for="email" class="form-label">Email</label>
                                                <input value="{{ old('email', $user->email) }}" name="email"
                                                    type="email" id="email" class="form-control"
                                                    placeholder="Nhập email" >
                                                @error('email')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Số điện thoại -->
                                            <div class="mb-3 col-12">
                                                <label for="phone" class="form-label">Số điện thoại</label>
                                                <input value="{{ old('phone', $user->phone) }}" name="phone"
                                                    type="text" id="phone" class="form-control"
                                                    placeholder="Nhập số điện thoại">
                                                @error('phone')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label for="role" class="form-label">Chọn vai trò</label>
                                                <select name="role_id" id="role" class="form-control">
                                                    <option value="">-- Chọn vai trò --</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}"
                                                            {{ old('role_id', $user->role->id ?? '') == $role->id ? 'selected' : '' }}>
                                                            {{ $role->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('role_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Giới tính -->
                                            <div class="mb-3 col-6">
                                                <label for="gender" class="form-label">Giới tính</label>
                                                <select name="gender" class="form-control">
                                                    <option value="">Chọn giới tính</option>
                                                    <option value="male"
                                                        {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Nam
                                                    </option>
                                                    <option value="female"
                                                        {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Nữ
                                                    </option>
                                                    <option value="other"
                                                        {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>
                                                        Khác</option>
                                                </select>
                                                @error('gender')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3 col-12">
                                                <label for="note" class="form-label">Giới thiệu</label>
                                                <textarea name="note" id="note" class="form-control" placeholder="Nhập ghi chú">{{ old('note', $user->note) }}</textarea>
                                                @error('note')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="avatar" class="form-label">Ảnh đại diện</label>

                                            @if ($user->avatar)
                                                <img src="{{ Storage::url($user->avatar ?? 'avatar/default.jpeg') }}"
                                                    alt="Avatar" class="img-fluid rounded mb-2" width="100%">
                                            @endif
                                            @error('avatar')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <input type="file" class="form-control" id="avatar" name="avatar"
                                                accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header border-bottom-dashed">

                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <div>
                                            <h5 class="card-title mb-0">Thông tin địa chỉ</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- Tên người dùng -->
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label for="country" class="form-label">Quốc gia</label>
                                                <input value="{{ old('country', $address->country ?? '') }}" name="country"
                                                    type="text" id="country" class="form-control"
                                                    placeholder="Nhập tên người dùng" >
                                                @error('country')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label for="city" class="form-label">Thành phố</label>
                                                <input value="{{ old('city', $address->city ?? '') }}" name="city"
                                                    type="text" id="city" class="form-control"
                                                    placeholder="Nhập tên người dùng" >
                                                @error('city')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label for="district" class="form-label">Quận</label>
                                                <input value="{{ old('district', $address->district ?? '') }}" name="district"
                                                    type="text" id="district" class="form-control"
                                                    placeholder="Nhập tên người dùng" >
                                                @error('district')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label for="ward" class="form-label">Phường</label>
                                                <input value="{{ old('ward', $address->ward ?? '') }}" name="ward"
                                                    type="text" id="ward" class="form-control"
                                                    placeholder="Nhập tên người dùng" >
                                                @error('ward')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label for="specific_address" class="form-label">Địa chỉ chi tiết</label>
                                                <input value="{{ old('specific_address', $address->specific_address ?? '') }}"
                                                    name="specific_address" type="text" id="specific_address"
                                                    class="form-control" placeholder="Nhập tên người dùng" >
                                                @error('specific_address')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card">
                            <div class="card-footer">
                                <div class="hstack gap-2 justify-content-left">
                                    <button type="submit" class="btn btn-success" id="update-btn">Cập nhật người
                                        dùng</button>
                                    <a href="{{ route('admin.users.index', ['id' => 2]) }}"
                                        class="btn btn-light">Đóng</a>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </form>
    </section>
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

@extends('admin.layouts.master')

@section('content')
<section class="content pt-3">
    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0"><b>Thêm mới tài khoản nhân viên</b></h5>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">
                                        <!-- Tên người dùng -->
                                        <div class="mb-3 col-12">
                                            <label for="name" class="form-label">Tên người dùng</label>
                                            <input value="{{ old('name') }}" name="name" type="text"
                                                id="name" class="form-control" placeholder="Nhập tên người dùng">
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Email -->
                                        <div class="mb-3 col-12">
                                            <label for="email" class="form-label">Email</label>
                                            <input value="{{ old('email') }}" name="email"
                                                type="email" id="email" class="form-control"
                                                placeholder="Nhập email">
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Số điện thoại -->
                                        <div class="mb-3 col-12">
                                            <label for="phone" class="form-label">Số điện thoại</label>
                                            <input value="{{ old('phone') }}" name="phone"
                                                type="text" id="phone" class="form-control"
                                                placeholder="Nhập số điện thoại">
                                            @error('phone')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Vai trò -->
                                        <div class="mb-3 col-6">
                                            <label for="role" class="form-label">Chọn vai trò</label>
                                            <select name="role_id" id="role" class="form-control">
                                                <option value="">-- Chọn vai trò --</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ old('role_id') == $role->id ? 'selected' : '' }}>
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
                                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Khác</option>
                                            </select>
                                            @error('gender')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Ghi chú -->
                                        <div class="mb-3 col-12">
                                            <label for="note" class="form-label">Ghi chú</label>
                                            <textarea name="note" id="note" class="form-control"
                                                placeholder="Nhập ghi chú">{{ old('note') }}</textarea>
                                            @error('note')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Avatar -->
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="avatar" class="form-label">Ảnh đại diện</label>
                                        <img src="{{ asset('avatar/default.jpeg') }}" alt="Avatar" class="img-fluid rounded mb-2" width="100%">
                                        <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                                        @error('avatar')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Địa chỉ -->
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0">Thông tin địa chỉ</h5>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        @foreach (['country' => 'Quốc gia', 'city' => 'Thành phố', 'district' => 'Quận', 'ward' => 'Phường', 'specific_address' => 'Địa chỉ chi tiết'] as $field => $label)
                                            <div class="mb-3 col-6">
                                                <label for="{{ $field }}" class="form-label">{{ $label }}</label>
                                                <input value="{{ old($field) }}" name="{{ $field }}"
                                                    type="text" id="{{ $field }}" class="form-control"
                                                    placeholder="Nhập {{ strtolower($label) }}">
                                                @error($field)
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nút Submit -->
                    <div class="card">
                        <div class="card-footer">
                            <div class="hstack gap-2 justify-content-left">
                                <button type="submit" class="btn btn-success">Thêm tài khoản</button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-light">Đóng</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection

@section('style')
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@extends('admin.layouts.master')

@section('content')
    <section class="content pt-3">
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                            <h5 class="card-title mb-0"><b>Chỉnh sửa tài khoản nhân viên</b></h5>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="row">
                                            <!-- Tên người dùng -->
                                            <div class="mb-3 col-12">
                                                <label for="name" class="form-label">Tên người dùng</label>
                                                <input value="{{ old('name', $user->name) }}" name="name" type="text"
                                                id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nhập tên người dùng">
                                                @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Email -->
                                            <div class="mb-3 col-12">
                                                <label for="email" class="form-label">Email</label>
                                            <input value="{{ old('email', $user->email) }}" name="email" type="email"
                                                id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Nhập email">
                                                @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Số điện thoại -->
                                            <div class="mb-3 col-12">
                                                <label for="phone" class="form-label">Số điện thoại</label>
                                            <input value="{{ old('phone', $user->phone) }}" name="phone" type="text"
                                                id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Nhập số điện thoại">
                                                @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Mật khẩu -->
                                        <div class="mb-3 col-12">
                                            <label for="password" class="form-label">Mật khẩu mới</label>
                                            <input name="password" type="password"
                                                id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Nhập mật khẩu mới (để trống nếu không muốn thay đổi)">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Giới tính -->
                                        <div class="mb-3 col-12">
                                            <label class="form-label">Giới tính</label>
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="male" value="male" {{ old('gender', $user->gender) == 'male' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="male">Nam</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="female" value="female" {{ old('gender', $user->gender) == 'female' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="female">Nữ</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="other" value="other" {{ old('gender', $user->gender) == 'other' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="other">Khác</label>
                                                </div>
                                            </div>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Trạng thái -->
                                        <div class="mb-3 col-12">
                                            <label for="status" class="form-label">Trạng thái</label>
                                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                                <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                                <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Ngưng hoạt động</option>
                                                <option value="banned" {{ old('status', $user->status) == 'banned' ? 'selected' : '' }}>Đã khóa</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Vai trò -->
                                        <div class="mb-3 col-12">
                                            <label for="role_id" class="form-label">Vai trò</label>
                                            <select name="role_id" id="role_id" class="form-select @error('role_id') is-invalid @enderror">
                                                <option value="">Chọn vai trò</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                                            {{ $role->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('role_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        <!-- Ghi chú -->
                                            <div class="mb-3 col-12">
                                            <label for="note" class="form-label">Ghi chú</label>
                                            <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror" rows="3" placeholder="Nhập ghi chú">{{ old('note', $user->note) }}</textarea>
                                                @error('note')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                        </div>
                                        </div>
                                    </div>

                                    <!-- Avatar -->
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="avatar" class="form-label">Ảnh đại diện</label>
                                        <div class="text-center">
                                            @if($user->avatar && Storage::exists('public/' . $user->avatar))
                                                <img src="{{ Storage::url($user->avatar) }}" 
                                                    alt="Avatar" class="img-fluid rounded mb-2" width="150" height="150" id="avatar-preview">
                                            @else
                                                <img src="{{ asset('theme/velzon/assets/images/users/avatar-1.jpg') }}" 
                                                    alt="Default Avatar" class="img-fluid rounded mb-2" width="150" height="150" id="avatar-preview">
                                            @endif
                                            <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar" accept="image/*" onchange="previewImage(this)">
                                            @error('avatar')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
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
                                        <!-- Họ tên người nhận -->
                                        <div class="mb-3 col-6">
                                            <label for="full_name" class="form-label">Họ tên người nhận</label>
                                            <input value="{{ old('full_name', $address->full_name ?? '') }}" name="full_name"
                                                type="text" id="full_name" class="form-control @error('full_name') is-invalid @enderror"
                                                placeholder="Nhập họ tên người nhận">
                                            @error('full_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Số điện thoại người nhận -->
                                        <div class="mb-3 col-6">
                                            <label for="phone_number" class="form-label">Số điện thoại người nhận</label>
                                            <input value="{{ old('phone_number', $address->phone_number ?? '') }}" name="phone_number"
                                                type="text" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
                                                placeholder="Nhập số điện thoại người nhận">
                                            @error('phone_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Địa chỉ chi tiết -->
                                        <div class="mb-3 col-12">
                                            <label for="street_address" class="form-label">Địa chỉ chi tiết</label>
                                            <input value="{{ old('street_address', $address->street_address ?? '') }}" name="street_address"
                                                type="text" id="street_address" class="form-control @error('street_address') is-invalid @enderror"
                                                placeholder="Nhập địa chỉ chi tiết">
                                            @error('street_address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Phường/Xã -->
                                        <div class="mb-3 col-6">
                                            <label for="ward" class="form-label">Phường/Xã</label>
                                            <input value="{{ old('ward', $address->ward ?? '') }}" name="ward"
                                                type="text" id="ward" class="form-control @error('ward') is-invalid @enderror"
                                                placeholder="Nhập phường/xã">
                                            @error('ward')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Quận/Huyện -->
                                        <div class="mb-3 col-6">
                                            <label for="district" class="form-label">Quận/Huyện</label>
                                            <input value="{{ old('district', $address->district ?? '') }}" name="district"
                                                type="text" id="district" class="form-control @error('district') is-invalid @enderror"
                                                placeholder="Nhập quận/huyện">
                                            @error('district')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Thành phố -->
                                                <div class="mb-3 col-6">
                                            <label for="city" class="form-label">Thành phố</label>
                                            <input value="{{ old('city', $address->city ?? '') }}" name="city"
                                                type="text" id="city" class="form-control @error('city') is-invalid @enderror"
                                                placeholder="Nhập thành phố">
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                        <!-- Quốc gia -->
                                        <div class="mb-3 col-6">
                                            <label for="country" class="form-label">Quốc gia</label>
                                            <input value="{{ old('country', $address->country ?? '') }}" name="country"
                                                type="text" id="country" class="form-control @error('country') is-invalid @enderror"
                                                placeholder="Nhập quốc gia">
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Nút Submit -->
                        <div class="card">
                            <div class="card-footer">
                                <div class="hstack gap-2 justify-content-left">
                                <button type="submit" class="btn btn-success">Cập nhật tài khoản</button>
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

@section('script')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
                document.getElementById('avatar-preview').style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection

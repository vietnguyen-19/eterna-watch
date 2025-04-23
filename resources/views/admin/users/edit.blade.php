@extends('admin.layouts.master')

@section('content')
    <section class="content pt-3">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0 text-info"><b>Chỉnh sửa tài khoản nhân viên</b></h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <!-- Tên người dùng -->
                                            <div class="mb-3 col-12">
                                                <label for="name" class="form-label">Tên người dùng</label>
                                                <input value="{{ old('name', $user->name) }}" name="name" type="text"
                                                    id="name" class="form-control @error('name') is-invalid @enderror"
                                                    placeholder="Nhập tên người dùng">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Email -->
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        id="email" name="email"
                                                        value="{{ old('email', $user->email) }}">
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Số điện thoại -->
                                            <div class="mb-3 col-12">
                                                <label for="phone" class="form-label">Số điện thoại</label>
                                                <input value="{{ old('phone', $user->phone) }}" name="phone"
                                                    type="text" id="phone"
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    placeholder="Nhập số điện thoại">
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Mật khẩu -->
                                            <div class="mb-3 col-12">
                                                <label for="password" class="form-label">Mật khẩu mới</label>
                                                <input name="password" type="password" id="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="Nhập mật khẩu mới (để trống nếu không muốn thay đổi)">
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Giới tính -->
                                            <div class="mb-3 col-12">
                                                <label class="form-label d-block mb-2">Giới tính</label>
                                                <div class="row">
                                                    <div class="col-md-auto">
                                                        <div class="form-check form-check-inline">
                                                            <input
                                                                class="form-check-input @error('gender') is-invalid @enderror"
                                                                type="radio" name="gender" id="male" value="male"
                                                                {{ old('gender', $user->gender) == 'male' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="male">Nam</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-auto">
                                                        <div class="form-check form-check-inline">
                                                            <input
                                                                class="form-check-input @error('gender') is-invalid @enderror"
                                                                type="radio" name="gender" id="female" value="female"
                                                                {{ old('gender', $user->gender) == 'female' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="female">Nữ</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-auto">
                                                        <div class="form-check form-check-inline">
                                                            <input
                                                                class="form-check-input @error('gender') is-invalid @enderror"
                                                                type="radio" name="gender" id="other" value="other"
                                                                {{ old('gender', $user->gender) == 'other' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="other">Khác</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('gender')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <!-- Trạng thái -->
                                            <div class="mb-3 col-6">
                                                <label for="status" class="form-label">Trạng thái</label>
                                                <select name="status" id="status"
                                                    class="form-select form-control @error('status') is-invalid @enderror">
                                                    <option value="active"
                                                        {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>
                                                        Hoạt động</option>
                                                    <option value="inactive"
                                                        {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>
                                                        Ngưng hoạt động</option>
                                                    <option value="banned"
                                                        {{ old('status', $user->status) == 'banned' ? 'selected' : '' }}>Đã
                                                        khóa</option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Vai trò -->
                                            <div class="mb-3 col-6">
                                                <label for="role_id" class="form-label">Vai trò</label>
                                                <select name="role_id" id="role_id"
                                                    class="form-select form-control @error('role_id') is-invalid @enderror">
                                                    <option value="">Chọn vai trò</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}"
                                                            {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
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
                                                <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror" rows="3"
                                                    placeholder="Nhập ghi chú">{{ old('note', $user->note) }}</textarea>
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
                                                @if ($user->avatar && Storage::disk('public')->exists($user->avatar))
                                                    <img src="{{ Storage::url($user->avatar) }}" alt="Avatar"
                                                        class="img-fluid rounded mb-2" width="100%" height="150"
                                                        id="avatar-preview">
                                                @else
                                                    <img src="{{ asset('theme/velzon/assets/images/users/avatar-1.jpg') }}"
                                                        alt="Default Avatar" class="img-fluid rounded mb-2"
                                                        width="150" height="150" id="avatar-preview">
                                                @endif
                                                <input type="file"
                                                    class="form-control @error('avatar') is-invalid @enderror"
                                                    id="avatar" name="avatar" accept="image/*"
                                                    onchange="previewImage(this)">
                                                @error('avatar')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0 text-info"><strong>Cập nhật thông tin địa chỉ</strong></h5>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <!-- Họ tên người nhận -->



                                            <!-- Địa chỉ chi tiết -->
                                            <div class="mb-3 col-12">
                                                <label for="city">Tỉnh/Thành phố</label>
                                                <select id="city" name="city" class="form-control">
                                                    <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                                    {{-- JS sẽ tự thêm các option vào đây --}}
                                                </select>
                                                @error('city')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label for="district">Quận/Huyện</label>
                                                <select id="district" name="district" class="form-control" disabled>
                                                    <option value="">-- Chọn Quận/Huyện --</option>
                                                </select>
                                                @error('district')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label for="ward">Phường/Xã</label>
                                                <select id="ward" name="ward" class="form-control" disabled>
                                                    <option value="">-- Chọn Phường/Xã --</option>
                                                </select>
                                                @error('ward')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>



                                            <div class="mb-3 col-12">
                                                <label for="street_address" class="form-label">Địa chỉ chi tiết</label>
                                                <input value="{{ old('street_address', $address->street_address ?? '') }}"
                                                    name="street_address" type="text" id="street_address"
                                                    class="form-control @error('street_address') is-invalid @enderror"
                                                    placeholder="Nhập địa chỉ chi tiết">
                                                @error('street_address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror @error('street_address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <!-- Địa chỉ cụ thể -->
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
    <link href="{{ asset('theme/velzon/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const apiBase = 'https://provinces.open-api.vn/api';
            const citySelect = document.getElementById('city');
            const districtSelect = document.getElementById('district');
            const wardSelect = document.getElementById('ward');

            const currentCity = @json(Auth::check() ? optional(Auth::user()->defaultAddress)->city : null);
            const currentDistrict = @json(Auth::check() ? optional(Auth::user()->defaultAddress)->district : null);
            const currentWard = @json(Auth::check() ? optional(Auth::user()->defaultAddress)->ward : null);

            let cachedCities = [];

            districtSelect.disabled = true;
            wardSelect.disabled = true;

            // Fetch danh sách tỉnh/thành phố
            fetch(`${apiBase}/?depth=3`)
                .then(res => res.json())
                .then(cities => {
                    cachedCities = cities;
                    citySelect.innerHTML = '<option value="">-- Chọn Tỉnh/Thành phố --</option>';

                    cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.name; // Sử dụng tên thành phố làm giá trị
                        option.textContent = city.name;

                        if (currentCity && city.name.toLowerCase() === currentCity.toLowerCase()) {
                            option.selected = true;
                            loadDistricts(city); // Tải quận/huyện khi khớp
                        }

                        citySelect.appendChild(option);
                    });
                });

            // Load danh sách quận/huyện từ thành phố
            function loadDistricts(city) {
                districtSelect.innerHTML = '<option value="">-- Chọn Quận/Huyện --</option>';
                districtSelect.disabled = false;
                wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
                wardSelect.disabled = true;

                city.districts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.name; // Sử dụng tên quận/huyện làm giá trị
                    option.textContent = district.name;

                    if (currentDistrict && district.name.toLowerCase() === currentDistrict.toLowerCase()) {
                        option.selected = true;
                        loadWards(district); // Tải phường/xã khi khớp
                    }

                    districtSelect.appendChild(option);
                });
            }

            // Load danh sách phường/xã từ quận/huyện
            function loadWards(district) {
                wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
                wardSelect.disabled = false;

                district.wards.forEach(ward => {
                    const option = document.createElement('option');
                    option.value = ward.name; // Sử dụng tên phường/xã làm giá trị
                    option.textContent = ward.name;

                    if (currentWard && ward.name.toLowerCase() === currentWard.toLowerCase()) {
                        option.selected = true;
                    }

                    wardSelect.appendChild(option);
                });
            }

            // Khi người dùng chọn thành phố
            citySelect.addEventListener('change', function() {
                const selectedCity = cachedCities.find(city => city.name === this.value);
                if (selectedCity) loadDistricts(selectedCity);
            });

            // Khi người dùng chọn quận
            districtSelect.addEventListener('change', function() {
                const selectedCity = cachedCities.find(city => city.name === citySelect.value);
                const selectedDistrict = selectedCity?.districts.find(d => d.name === this.value);
                if (selectedDistrict) loadWards(selectedDistrict);
            });
        });
    </script>
@endsection

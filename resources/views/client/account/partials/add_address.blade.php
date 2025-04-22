@extends('client.account.main')
@section('account_content')
    <form action="{{ route('addresses.store') }}" method="POST">
        @csrf
        <div class="">
            <div class="card shadow rounded">
                <div class="card-header bg-white">
                    <h5 class="mb-0 py-2"><strong>Thêm địa chỉ giao hàng</strong></h5>
                </div>
        
                <div class="card-body">
                    {{-- Hiển thị tất cả lỗi nếu có --}}
                    <div class="row">
                        <!-- Họ và tên -->
                        <div class="col-md-12">
                            <div class="form-floating my-2">
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name"
                                    name="full_name" value="{{ old('full_name', Auth::check() ? Auth::user()->name : '') }}"
                                    placeholder="Họ và Tên">
                                <label for="full_name">Họ và Tên *</label>
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
        
                        <!-- Số điện thoại -->
                        <div class="col-md-12">
                            <div class="form-floating my-2">
                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                                    id="phone_number" name="phone_number"
                                    value="{{ old('phone_number', Auth::check() ? Auth::user()->phone : '') }}"
                                    placeholder="Số điện thoại">
                                <label for="phone_number">Số điện thoại *</label>
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
        
                        <!-- Email -->
                        <div class="col-md-12">
                            <div class="form-floating my-2">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}"
                                    placeholder="Email">
                                <label for="email">Email *</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
        
                        <!-- Tỉnh / Thành phố -->
                        <div class="col-md-12">
                            <div class="form-floating my-2">
                                <select id="city" name="city" class="form-select @error('city') is-invalid @enderror">
                                    <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                </select>
                                <label for="city">Tỉnh/Thành phố</label>
                                @error('city')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
        
                        <!-- Quận / Huyện -->
                        <div class="col-md-12">
                            <div class="form-floating my-2">
                                <select id="district" name="district" class="form-select @error('district') is-invalid @enderror">
                                    <option value="">-- Chọn Quận/Huyện --</option>
                                </select>
                                <label for="district">Quận/Huyện</label>
                                @error('district')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
        
                        <!-- Phường / Xã -->
                        <div class="col-md-12">
                            <div class="form-floating my-2">
                                <select id="ward" name="ward" class="form-select @error('ward') is-invalid @enderror">
                                    <option value="">-- Chọn Phường/Xã --</option>
                                </select>
                                <label for="ward">Phường/Xã</label>
                                @error('ward')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
        
                        <!-- Địa chỉ cụ thể -->
                        <div class="col-md-12">
                            <div class="form-floating my-2">
                                <input type="text" class="form-control @error('street_address') is-invalid @enderror" id="street_address"
                                    name="street_address" value="{{ old('street_address') }}" placeholder="Địa chỉ cụ thể">
                                <label for="street_address">Địa chỉ cụ thể *</label>
                                @error('street_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary w-100">Thêm địa chỉ</button>
                </div>
            </div>
        </div>
        
        
    </form>
@endsection
@section('script')
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script>
        // Set timeout to hide the success message after 5 seconds
        setTimeout(function() {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000);
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            FilePond.registerPlugin(FilePondPluginImagePreview);

            const avatarInput = document.getElementById("avatar");
            const avatarHidden = document.getElementById("avatar-hidden");

            const pond = FilePond.create(avatarInput, {
                allowMultiple: false,
                allowImagePreview: true,
                imagePreviewHeight: 200,
                labelIdle: "Kéo & thả ảnh hoặc <span class='filepond--label-action'>chọn ảnh</span>",
                server: {
                    process: {
                        url: "{{ url('/account/upload-image') }}",
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        onload: (response) => {
                            try {
                                let res = JSON.parse(response);
                                if (res.success) {
                                    avatarHidden.value = res.path;
                                } else {
                                    alert("Lỗi: " + (res.message || "Không thể tải ảnh lên."));
                                }
                            } catch (error) {
                                console.error("Lỗi JSON:", error);
                                alert("Lỗi không xác định khi tải ảnh lên.");
                            }
                        }
                    },
                    revert: (filename, load) => {
                        fetch("{{ url('/account/remove-image') }}", {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify({
                                    path: avatarHidden.value
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    avatarHidden.value = "";
                                } else {
                                    alert("Lỗi: " + (data.message || "Không thể xóa ảnh."));
                                }
                                load();
                            })
                            .catch(error => {
                                console.error("Lỗi khi xóa ảnh:", error);
                                alert("Lỗi kết nối đến server.");
                                load();
                            });
                    }
                }
            });

            // ✅ Thêm ảnh cũ vào FilePond sau khi khởi tạo
            let oldImage = "{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : '' }}";
            if (oldImage) {
                fetch(oldImage)
                    .then(res => {
                        if (res.ok) {
                            pond.addFile(oldImage, {
                                source: oldImage
                            });
                        } else {
                            console.error("Ảnh không tồn tại hoặc không thể tải.");
                        }
                    })
                    .catch(error => console.error("Lỗi khi tải ảnh:", error));
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        </script>
    @endif
    <script>
        const currentCity = @json(Auth::check() ? optional(Auth::user()->defaultAddress)->city : null);
        const currentDistrict = @json(Auth::check() ? optional(Auth::user()->defaultAddress)->district : null);
        const currentWard = @json(Auth::check() ? optional(Auth::user()->defaultAddress)->ward : null);

        document.addEventListener('DOMContentLoaded', function() {
            const apiBase = 'https://provinces.open-api.vn/api';
            const citySelect = document.getElementById('city');
            const districtSelect = document.getElementById('district');
            const wardSelect = document.getElementById('ward');

            // Load tỉnh
            fetch(`${apiBase}/p`)
                .then(res => res.json())
                .then(cities => {
                    cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.name;
                        option.textContent = city.name;
                        if (currentCity && city.name === currentCity) option.selected = true;
                        citySelect.appendChild(option);
                    });

                    // Nếu đã có tỉnh, load huyện
                    if (currentCity) {
                        const selectedCity = cities.find(c => c.name === currentCity);
                        if (selectedCity) {
                            loadDistricts(selectedCity.code);
                        }
                    }
                });

            function loadDistricts(cityCode) {
                districtSelect.innerHTML = '<option value="">-- Chọn Quận/Huyện --</option>';
                wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
                wardSelect.disabled = true;

                fetch(`${apiBase}/p/${cityCode}?depth=2`)
                    .then(res => res.json())
                    .then(data => {
                        data.districts.forEach(district => {
                            const option = document.createElement('option');
                            option.value = district.name;
                            option.textContent = district.name;
                            if (currentDistrict && district.name === currentDistrict) option.selected =
                                true;
                            districtSelect.appendChild(option);
                        });
                        districtSelect.disabled = false;

                        // Nếu đã có huyện, load xã
                        if (currentDistrict) {
                            const selectedDistrict = data.districts.find(d => d.name === currentDistrict);
                            if (selectedDistrict) {
                                loadWards(selectedDistrict.code);
                            }
                        }
                    });
            }

            function loadWards(districtCode) {
                wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';

                fetch(`${apiBase}/d/${districtCode}?depth=2`)
                    .then(res => res.json())
                    .then(data => {
                        data.wards.forEach(ward => {
                            const option = document.createElement('option');
                            option.value = ward.name;
                            option.textContent = ward.name;
                            if (currentWard && ward.name === currentWard) option.selected = true;
                            wardSelect.appendChild(option);
                        });
                        wardSelect.disabled = false;
                    });
            }

            // Khi chọn tỉnh
            citySelect.addEventListener('change', function() {
                const selectedName = this.value;
                const selectedOption = Array.from(this.options).find(opt => opt.value === selectedName);

                fetch(`${apiBase}/p`)
                    .then(res => res.json())
                    .then(cities => {
                        const selectedCity = cities.find(city => city.name === selectedName);
                        if (selectedCity) {
                            loadDistricts(selectedCity.code);
                        }
                    });
            });

            // Khi chọn huyện
            districtSelect.addEventListener('change', function() {
                const selectedName = this.value;
                fetch(`${apiBase}/p`)
                    .then(res => res.json())
                    .then(cities => {
                        const selectedCity = cities.find(c => c.name === citySelect.value);
                        if (selectedCity) {
                            fetch(`${apiBase}/p/${selectedCity.code}?depth=2`)
                                .then(res => res.json())
                                .then(data => {
                                    const selectedDistrict = data.districts.find(d => d.name ===
                                        selectedName);
                                    if (selectedDistrict) {
                                        loadWards(selectedDistrict.code);
                                    }
                                });
                        }
                    });
            });
        });
    </script>
@endsection
@section('style')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <style>
        /* Sidebar */
        .account-sidebar .nav-link {
            font-size: 16px;
            padding: 12px 18px;
            border-radius: 3px;
            background: #fdfdfd;
            transition: all 0.3s ease-in-out;
            display: flex;
            align-items: center;
            color: #333;
            font-weight: 500;
        }

        .account-sidebar .nav-link i {
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .account-sidebar .nav-link:hover {
            background: #ececec;
            padding-left: 22px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .account-sidebar .nav-link.active {
            background: #e84040;
            color: #ffffff;
            font-weight: bold;
        }

        /* Hiệu ứng hover cho liên kết */
        .link-hover {
            transition: color 0.3s ease-in-out;
        }

        .link-hover:hover {
            color: #0d47a1 !important;
            text-decoration: underline;
        }

        /* Nội dung chính */
        .content-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 24px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .logout-btn {
            background: none;
            border: none;
            text-align: left;
            width: 100%;
            padding: 12px 18px;
            transition: background-color 0.3s, padding-left 0.3s;
            font-size: 16px;
            color: #d3401f !important;
            font-weight: bold;
        }

        .logout-btn:hover {
            background: #fff5f5;
            padding-left: 22px;
        }

        /* Responsive tối ưu */
        @media (max-width: 768px) {
            .container {
                max-width: 100%;
            }

            .nav {
                border-bottom: 1px solid #ddd;
            }

            .content-box {
                margin-top: 20px;
            }
        }
    </style>
@endsection

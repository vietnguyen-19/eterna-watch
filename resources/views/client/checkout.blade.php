@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1"></div>
    <main style="padding-top: 90px;">

        <section class="shop-checkout container">
            <div class="mb-4 pb-4"></div>
            <div class="mb-4 pb-lg-3"></div>

            <div class="mb-4 pb-4"></div>
            <a href="shop_cart.html" class="d-flex"
                style="background-color: #f6f6f6; border-radius: 3px; overflow: hidden; text-decoration: none; color: inherit; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);">

                <!-- Cột icon full height -->
                <div
                    style="background-color: #242424; padding: 0 35px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-credit-card" style="color: white; font-size: 36px;"></i>
                </div>

                <!-- Phần nội dung -->
                <div style="padding: 20px;">
                    <div style="font-size: 1.8rem; color: #b42020; font-weight: bold; margin-bottom: 5px;">
                        GIAO HÀNG VÀ THANH TOÁN
                    </div>
                    <p style="margin: 0; font-size: 0.95rem; color: #6c757d;">
                        Giao hàng toàn quốc, thanh toán khi nhận hàng hoặc qua VNPay.
                    </p>
                </div>

            </a>
            <form action="{{ route('payment.checkout') }}" method="POST">
                @csrf
                <div class="checkout-form">
                    <div class="billing-info__wrapper col-xl-4">
                        <h4 class="mb-3"><strong>THÔNG TIN GIAO HÀNG</strong></h4>
                    
                        <div class="row">
                            <!-- Chọn kiểu thông tin -->
                            <div class="col-md-12">
                                @php
                                    $hasDefaultInfo =
                                        Auth::check() &&
                                        Auth::user()->defaultAddress &&
                                        Auth::user()->name &&
                                        Auth::user()->phone &&
                                        Auth::user()->email;
                                @endphp

                                @if ($hasDefaultInfo)
                                    <div class="form-check my-2">
                                        <input class="form-check-input" type="radio" name="info_option" id="info_mac_dinh"
                                            value="mac_dinh" checked>
                                        <label class="form-check-label" for="info_mac_dinh">Sử dụng thông tin mặc
                                            định</label>
                                    </div>
                                @endif

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="info_option" id="info_moi"
                                        value="moi" {{ !$hasDefaultInfo ? 'checked' : '' }}>
                                    <label class="form-check-label" for="info_moi">Nhập thông tin mới</label>
                                </div>

                                @if (!$hasDefaultInfo)
                                    <div class="alert alert-warning mb-3">
                                        Bạn chưa có thông tin mặc định. Vui lòng <a href="{{ route('account.edit') }}"
                                            class="fw-bold text-danger">cập nhật thông tin</a> hoặc nhập thông tin mới bên
                                        dưới.
                                    </div>
                                @endif
                            </div>

                            <!-- Thông tin mặc định -->
                            @if ($hasDefaultInfo)
                                <div id="infoMacDinh" class="col-md-12">
                                    <div class="card p-3 mb-3">
                                        <p><strong>Họ và Tên:</strong> {{ Auth::user()->name }}</p>
                                        <p><strong>Số điện thoại:</strong> {{ Auth::user()->phone }}</p>
                                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                                        <p><strong>Địa chỉ:</strong>
                                            {{ trim(optional(Auth::user()->defaultAddress)->street_address . ', ' . optional(Auth::user()->defaultAddress)->ward . ', ' . optional(Auth::user()->defaultAddress)->district . ', ' . optional(Auth::user()->defaultAddress)->city, ', ') }}
                                        </p>
                                    </div>

                                    <!-- Hidden fields cho thông tin mặc định -->
                                    <input type="hidden" name="full_name" value="{{ Auth::user()->name }}">
                                    <input type="hidden" name="phone_number" value="{{ Auth::user()->phone }}">
                                    <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                    <input type="hidden" name="street_address"
                                        value="{{ optional(Auth::user()->defaultAddress)->street_address }}">
                                    <input type="hidden" name="ward"
                                        value="{{ optional(Auth::user()->defaultAddress)->ward }}">
                                    <input type="hidden" name="district"
                                        value="{{ optional(Auth::user()->defaultAddress)->district }}">
                                    <input type="hidden" name="city"
                                        value="{{ optional(Auth::user()->defaultAddress)->city }}">
                                </div>
                            @endif

                            <!-- Thông tin mới -->
                            <div id="infoMoi" style="display: {{ !$hasDefaultInfo ? 'block' : 'none' }};">
                                <!-- Họ và tên -->
                                <input type="hidden" name="type_address" value="new">
                                <div class="col-md-12">
                                    <div class="form-floating my-2">
                                        <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                            id="full_name" name="full_name"
                                            value="{{ old('full_name', Auth::check() ? Auth::user()->name : '') }}"
                                            placeholder="Họ và Tên" required>
                                        <label for="full_name">Họ và Tên *</label>
                                        @error('full_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Số điện thoại -->
                                <div class="col-md-12">
                                    <div class="form-floating my-2">
                                        <input type="text"
                                            class="form-control @error('phone_number') is-invalid @enderror"
                                            id="phone_number" name="phone_number"
                                            value="{{ old('phone_number', Auth::check() ? Auth::user()->phone : '') }}"
                                            placeholder="Số điện thoại" required>
                                        <label for="phone_number">Số điện thoại *</label>
                                        @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-12">
                                    <div class="form-floating my-2">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email"
                                            value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}"
                                            placeholder="Email" required>
                                        <label for="email">Email *</label>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Địa chỉ -->
                                <div class="col-md-12">
                                  
                                    <div class="form-floating my-2">
                                        <select id="city" name="city"
                                            class="form-select @error('city') is-invalid @enderror" required>
                                            <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                        </select>
                                        <label for="city">Tỉnh/Thành phố *</label>
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Quận/Huyện -->
                                    <div class="form-floating my-2">
                                        <select id="district" name="district"
                                            class="form-select @error('district') is-invalid @enderror" required>
                                            <option value="">-- Chọn Quận/Huyện --</option>
                                        </select>
                                        <label for="district">Quận/Huyện *</label>
                                        @error('district')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Phường/Xã -->
                                    <div class="form-floating my-2">
                                        <select id="ward" name="ward"
                                            class="form-select @error('ward') is-invalid @enderror" required>
                                            <option value="">-- Chọn Phường/Xã --</option>
                                        </select>
                                        <label for="ward">Phường/Xã *</label>
                                        @error('ward')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Địa chỉ cụ thể -->
                                    <div class="form-floating my-2">
                                        <input type="text"
                                            class="form-control @error('street_address') is-invalid @enderror"
                                            id="street_address" name="street_address"
                                            value="{{ old('street_address', Auth::check() && Auth::user()->defaultAddress ? Auth::user()->defaultAddress->street_address : '') }}"
                                            placeholder="Địa chỉ cụ thể" required>
                                        <label for="street_address">Địa chỉ cụ thể *</label>
                                        @error('street_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Ghi chú đơn hàng -->
                            <div class="col-md-12">
                                <div class="form-floating my-2">
                                    <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note"
                                        placeholder="Ghi chú đơn hàng (nếu có)" rows="4">{{ old('note', Auth::check() ? Auth::user()->note ?? '' : '') }}</textarea>
                                    <label for="note">Ghi chú đơn hàng (tùy chọn)</label>
                                    @error('note')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Script xử lý hiển thị thông tin -->
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const macDinhRadio = document.getElementById('info_mac_dinh');
                                const moiRadio = document.getElementById('info_moi');
                                const infoMacDinhDiv = document.getElementById('infoMacDinh');
                                const infoMoiDiv = document.getElementById('infoMoi');

                                const toggleInfo = () => {
                                    const isMacDinh = macDinhRadio && macDinhRadio.checked;

                                    if (infoMacDinhDiv) {
                                        infoMacDinhDiv.style.display = isMacDinh ? 'block' : 'none';
                                    }
                                    infoMoiDiv.style.display = isMacDinh ? 'none' : 'block';

                                    // Bật/tắt các input trong form thông tin mới
                                    const newInfoInputs = infoMoiDiv.querySelectorAll('input, select, textarea');
                                    newInfoInputs.forEach(el => {
                                        el.disabled = isMacDinh;
                                    });

                                    // Bật/tắt các input hidden trong thông tin mặc định
                                    if (infoMacDinhDiv) {
                                        const hiddenInputs = infoMacDinhDiv.querySelectorAll('input[type="hidden"]');
                                        hiddenInputs.forEach(el => {
                                            el.disabled = !isMacDinh;
                                        });
                                    }
                                };

                                if (macDinhRadio) {
                                    macDinhRadio.addEventListener('change', toggleInfo);
                                }
                                moiRadio.addEventListener('change', toggleInfo);

                                toggleInfo(); // Khởi tạo ban đầu

                                // Xử lý liên kết Tỉnh/Quận/Phường
                                const citySelect = document.getElementById('city');
                                const districtSelect = document.getElementById('district');
                                const wardSelect = document.getElementById('ward');

                                async function fetchCities() {
                                    try {
                                        // Thay bằng API thực tế của bạn (ví dụ: GHN)
                                        const response = await fetch('https://api.example.com/cities');
                                        const cities = await response.json();
                                        cities.forEach(city => {
                                            const option = document.createElement('option');
                                            option.value = city.id;
                                            option.textContent = city.name;
                                            citySelect.appendChild(option);
                                        });
                                    } catch (error) {
                                        console.error('Lỗi khi tải danh sách tỉnh/thành:', error);
                                    }
                                }

                                async function fetchDistricts(cityId) {
                                    districtSelect.innerHTML = '<option value="">-- Chọn Quận/Huyện --</option>';
                                    wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
                                    if (cityId) {
                                        try {
                                            const response = await fetch(`https://api.example.com/districts?city=${cityId}`);
                                            const districts = await response.json();
                                            districts.forEach(district => {
                                                const option = document.createElement('option');
                                                option.value = district.id;
                                                option.textContent = district.name;
                                                districtSelect.appendChild(option);
                                            });
                                        } catch (error) {
                                            console.error('Lỗi khi tải danh sách quận/huyện:', error);
                                        }
                                    }
                                }

                                async function fetchWards(districtId) {
                                    wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
                                    if (districtId) {
                                        try {
                                            const response = await fetch(`https://api.example.com/wards?district=${districtId}`);
                                            const wards = await response.json();
                                            wards.forEach(ward => {
                                                const option = document.createElement('option');
                                                option.value = ward.id;
                                                option.textContent = ward.name;
                                                wardSelect.appendChild(option);
                                            });
                                        } catch (error) {
                                            console.error('Lỗi khi tải danh sách phường/xã:', error);
                                        }
                                    }
                                }

                                citySelect.addEventListener('change', () => fetchDistricts(citySelect.value));
                                districtSelect.addEventListener('change', () => fetchWards(districtSelect.value));

                                fetchCities();
                            });
                        </script>
                        

                    </div>
                    <div class="checkout__totals-wrapper">
                        <div class="sticky-content">
                            <div style="width:100%" class="checkout__totals">
                                <h4 class="mb-3"><strong>SẢN PHẨM TRONG ĐƠN HÀNG</strong></h4>
                                <table class="checkout-cart-items">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%" class="fw-bold">Sản phẩm</th>
                                            <th></th>
                                            <th class="fw-bold text-center">Giá</th>
                                            <th class="fw-bold text-center">Số lượng</th>
                                            <th class="fw-bold text-end">Tổng cộng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($variantDetails as $index => $item)
                                            @php
                                                $variant = $item['variant'];
                                                $quantity = $item['quantity'];
                                                $subtotal = $item['total'];
                                                $name = $variant->product->name ?? 'Sản phẩm không tồn tại';
                                                $price = $variant->price;
                                                $stock = $variant->stock ?? 'NaN';
                                                $variant_id = $variant->id;
                                            @endphp

                                            <input type="hidden" name="cart_items[{{ $index }}][variant_id]"
                                                value="{{ $variant_id }}">
                                            <input type="hidden" name="cart_items[{{ $index }}][price]"
                                                value="{{ $price }}">
                                            <input type="hidden" name="cart_items[{{ $index }}][quantity]"
                                                value="{{ $quantity }}">
                                            <input type="hidden" name="voucher_id"
                                                value="{{ $voucher ? $voucher->id : '' }}">

                                            <tr>
                                                <td style="width: 15%">
                                                    <div class="shopping-cart__product-item">
                                                        <a href="{{ route('client.shop.show', $variant->product->id) }}">
                                                            <img style="border: 1px solid #c4bebe;width:80px"
                                                                src="{{ Storage::url($variant->image) }}"
                                                                alt="{{ $name }}">
                                                        </a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div
                                                        class="shopping-cart__product-item__detail d-flex flex-column justify-content-center">
                                                        <h4 class="mb-1"> <!-- Giảm khoảng cách dưới của tiêu đề -->
                                                            <a
                                                                href="{{ route('client.shop.show', $variant->product->id) }}">
                                                                <strong>{{ $name }}</strong>
                                                            </a>
                                                        </h4>
                                                        <ul class="shopping-cart__product-item__options list-unstyled m-0">
                                                            @foreach ($variant->attributeValues as $value)
                                                                <li>
                                                                    <small>
                                                                        {{ $value->nameValue->attribute->attribute_name ?? 'Thuộc tính' }}:
                                                                        {{ $value->nameValue->value_name ?? 'Không xác định' }}
                                                                    </small>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="subtotal">{{ $quantity }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="shopping-cart__product-price">
                                                        {{ number_format($price, 0, ',', '.') }}đ
                                                    </span>
                                                </td>

                                                <td class="text-end">
                                                    <span
                                                        class="subtotal">{{ number_format($subtotal, 0, ',', '.') }}đ</span>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <table class="w-100">
                                    <tbody>
                                        <tr class="d-flex justify-content-between py-2">
                                            <th class="text-start">Tạm tính</th>
                                            <td class="text-end">
                                                {{ number_format($totalAmount + $discount, 0, ',', '.') }}đ</td>
                                        </tr>
                                        <tr class="d-flex justify-content-between py-2">
                                            <th class="text-start">Giảm giá</th>
                                            <td class="text-end">{{ number_format($discount, 0, ',', '.') }}đ</td>
                                        </tr>
                                        <tr class="d-flex justify-content-between py-2">
                                            <th class="text-start">Phí vận chuyển</th>
                                            <td class="text-end">
                                                <span id="shipping_cost">100.000đ</span>
                                            </td>
                                        </tr>
                                        <tr class="d-flex justify-content-between py-2">
                                            <th class="text-start">Tổng cộng</th>
                                            <td class="text-end">
                                                <strong
                                                    id="total_amount">{{ number_format($totalAmount, 0, ',', '.') }}đ</strong>
                                            </td>

                                        </tr>
                                        <input type="hidden" id="totalAmount" name="total_amount"
                                            value="{{ $totalAmount }}" data-default="{{ $totalAmount }}">

                                    </tbody>
                                </table>


                            </div>

                            <div style="width:100%" class="col-xl-6 mb-3">
                                <select name="shipping_method" id="shipping_method"
                                    class="form-select @error('shipping_method') is-invalid @enderror"
                                    onchange="updateShipping()">

                                    <option value=""><strong>-- Chọn lại phương thức vận chuyển --</strong></option>

                                    <!-- ✅ Đặt selected vào đây -->
                                    <option value="fixed" selected>Phí giao hàng cố định (100.000đ)</option>

                                    <option value="store">Nhận tại cửa hàng (Miễn phí)</option>
                                </select>


                                @error('shipping_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div style="width:100%" class="checkout__payment-methods col-xl-6">
                                <div class="form-check">
                                    <input name="payment_method" value="cash"
                                        class="form-check-input form-check-input_fill" type="radio"
                                        name="checkout_payment_method" id="checkout_payment_method_cod" checked>
                                    <label class="form-check-label" for="checkout_payment_method_cod">
                                        <b> Thanh toán khi nhận hàng (COD)</b>
                                        <span class="option-detail d-block">
                                            Thanh toán trực tiếp bằng tiền mặt khi nhận hàng. Vui lòng chuẩn bị số tiền
                                            chính xác để thuận tiện cho việc giao hàng.
                                        </span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio"
                                        name="payment_method" id="checkout_payment_method_vnpay" value="vnpay">
                                    <label class="form-check-label" for="checkout_payment_method_vnpay">
                                        <b> Thanh toán qua VNPay</b>
                                        <span class="option-detail d-block">
                                            Thanh toán an toàn qua VNPay. Bạn sẽ được chuyển hướng đến cổng thanh toán VNPay
                                            để hoàn tất giao dịch.
                                        </span>
                                    </label>
                                </div>
                                <div class="policy-text">
                                    Dữ liệu cá nhân của bạn sẽ được sử dụng để xử lý đơn hàng, hỗ trợ trải nghiệm của bạn
                                    trên website này,
                                    và cho các mục đích khác được mô tả trong <a href="terms.html" target="_blank">chính
                                        sách bảo mật</a> của chúng tôi.
                                </div>
                            </div>

                            <button style="width:100%" type="submit" class="btn btn-primary">Tiến hành thanh
                                toán</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
@endsection
@section('script')
    <script>
        function updateShipping() {
            let shippingMethod = document.getElementById("shipping_method").value;
            let shippingCostEl = document.getElementById("shipping_cost");
            let totalAmountEl = document.getElementById("total_amount");
            let totalAmountInput = document.getElementById("totalAmount");

            // Lấy giá trị tổng tiền gốc từ `data-default`
            let totalAmount = Number(totalAmountInput.dataset.default) || 0;
            let shippingCost = 0;

            switch (shippingMethod) {
                case "fixed":
                    shippingCost = 100000;
                    break;
                case "store":
                    shippingCost = 0;
                    break;
            }

            // Cập nhật UI
            shippingCostEl.textContent = shippingCost.toLocaleString("vi-VN") + "đ";
            let newTotal = totalAmount + shippingCost;
            totalAmountEl.textContent = newTotal.toLocaleString("vi-VN") + "đ";

            // Cập nhật input hidden để gửi lên server
            totalAmountInput.value = newTotal;
        }

        // ✅ Gọi khi trang load để cập nhật mặc định
        window.addEventListener("DOMContentLoaded", function() {
            updateShipping();
        });
    </script>
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
@endsection

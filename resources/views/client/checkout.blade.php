@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <main style="padding-top: 90px;">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">GIAO HÀNG VÀ THANH TOÁN</h2>
            <div class="checkout-steps">
                <a href="shop_cart.html" class="checkout-steps__item active d-flex align-items-center py-3">
                    <h2 style="background: #b42020; color:#fff" class="me-1 mb-0 p-2">01</h2>
                    <span class="checkout-steps__item-title d-flex flex-column justify-content-center text-start">
                        <span class="step-title fw-bold">Giỏ hàng</span>
                        <em class="step-description text-muted">Quản lý danh sách sản phẩm của bạn</em>
                    </span>
                </a>

                <a href="shop_checkout.html" class="checkout-steps__item active d-flex align-items-center py-3">
                    <h2 style="background: #b42020; color:#fff" class="me-1 mb-0 p-2">02</h2>
                    <span class="checkout-steps__item-title d-flex flex-column justify-content-center text-start">
                        <span class="step-title fw-bold">Giao hàng và thanh toán</span>
                        <em class="step-description text-muted">Tiến hành thanh toán</em>
                    </span>
                </a>

                <a href="shop_order_complete.html" class="checkout-steps__item d-flex align-items-center py-3">
                    <h2 style="background: #b42020; color:#fff" class="me-1 mb-0 p-2">03</h2>
                    <span class="checkout-steps__item-title d-flex flex-column justify-content-center text-start">
                        <span class="step-title fw-bold">Xác nhận</span>
                        <em class="step-description text-muted">Kiểm tra và gửi đơn hàng</em>
                    </span>
                </a>
            </div>

            <form action="{{ route('payment.checkout') }}" method="POST">
                @csrf
                <div class="checkout-form">
                    <div class="billing-info__wrapper col-xl-4">
                        <h4>THÔNG TIN KHÁCH HÀNG</h4>
                        <div class="row">
                            <!-- Họ và tên -->
                            <div class="col-md-12">
                                <div class="form-floating my-2">
                                    <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                        id="full_name" name="full_name"
                                        value="{{ old('full_name', Auth::check() ? Auth::user()->name : '') }}"
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
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email"
                                        value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}"
                                        placeholder="Email">
                                    <label for="email">Email *</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <!-- Chọn kiểu địa chỉ -->
                            <div class="col-md-12">
                                <div class="form-check my-2">
                                    <input class="form-check-input" type="radio" name="dia_chi_option" id="dia_chi_mac_dinh" value="mac_dinh" checked>
                                    <label class="form-check-label" for="dia_chi_mac_dinh">Sử dụng địa chỉ mặc định</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="dia_chi_option" id="dia_chi_moi" value="them_moi">
                                    <label class="form-check-label" for="dia_chi_moi">Thêm địa chỉ mới</label>
                                </div>
                            </div>

                            <!-- Địa chỉ mặc định -->
                            <div id="diaChiMacDinh" class="col-md-12">
                                <div class="form-floating my-2">
                                    <input type="text" class="form-control" id="dia_chi_day_du" name="dia_chi_day_du"
                                        value="{{ old(
                                            'dia_chi_day_du',
                                            Auth::check()
                                                ? trim(
                                                    optional(Auth::user()->defaultAddress)->street_address .
                                                        ', ' .
                                                        optional(Auth::user()->defaultAddress)->ward .
                                                        ', ' .
                                                        optional(Auth::user()->defaultAddress)->district .
                                                        ', ' .
                                                        optional(Auth::user()->defaultAddress)->city,
                                                    ', ',
                                                )
                                                : '',
                                        ) }}"
                                        placeholder="Địa chỉ đầy đủ" readonly>
                                </div>

                                <!-- Hidden fields chỉ dùng khi địa chỉ mặc định được chọn -->
                                <input type="hidden" name="type_address" value="default">
                                <input type="hidden" name="street_address" value="{{ optional(Auth::user()->defaultAddress)->street_address }}">
                                <input type="hidden" name="ward" value="{{ optional(Auth::user()->defaultAddress)->ward }}">
                                <input type="hidden" name="district" value="{{ optional(Auth::user()->defaultAddress)->district }}">
                                <input type="hidden" name="city" value="{{ optional(Auth::user()->defaultAddress)->city }}">
                            </div>

                            <!-- Địa chỉ mới -->
                            <div id="themDiaChiMoi" style="display: none;">
                                <input type="hidden" name="type_address" value="new">
                                <div class="col-md-12">
                                    <div class="form-floating my-2">
                                        <select id="city" name="city" class="form-select" disabled>
                                            <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                        </select>
                                        <label for="city">Tỉnh/Thành phố</label>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-floating my-2">
                                        <select id="district" name="district" class="form-select" disabled>
                                            <option value="">-- Chọn Quận/Huyện --</option>
                                        </select>
                                        <label for="district">Quận/Huyện</label>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-floating my-2">
                                        <select id="ward" name="ward" class="form-select" disabled>
                                            <option value="">-- Chọn Phường/Xã --</option>
                                        </select>
                                        <label for="ward">Phường/Xã</label>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-floating my-2">
                                        <input type="text" class="form-control" id="street_address" name="street_address"
                                            value="{{ old('street_address') }}" placeholder="Địa chỉ" disabled>
                                        <label for="street_address">Địa chỉ cụ thể *</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Script xử lý hiển thị & kích hoạt trường -->
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const macDinhRadio = document.getElementById('dia_chi_mac_dinh');
                                    const moiRadio = document.getElementById('dia_chi_moi');
                                    const diaChiMacDinhDiv = document.getElementById('diaChiMacDinh');
                                    const themDiaChiMoiDiv = document.getElementById('themDiaChiMoi');

                                    const toggleDiaChi = () => {
                                        const isMacDinh = macDinhRadio.checked;

                                        diaChiMacDinhDiv.style.display = isMacDinh ? 'block' : 'none';
                                        themDiaChiMoiDiv.style.display = isMacDinh ? 'none' : 'block';

                                        // Bật/tắt các input trong form thêm địa chỉ mới
                                        const newAddressInputs = themDiaChiMoiDiv.querySelectorAll('select, input');
                                        newAddressInputs.forEach(el => {
                                            el.disabled = isMacDinh;
                                        });

                                        // Ẩn/hiện các input hidden nếu cần thiết
                                        const hiddenInputs = diaChiMacDinhDiv.querySelectorAll('input[type="hidden"]');
                                        hiddenInputs.forEach(el => {
                                            el.disabled = !isMacDinh;
                                        });
                                    };

                                    macDinhRadio.addEventListener('change', toggleDiaChi);
                                    moiRadio.addEventListener('change', toggleDiaChi);

                                    toggleDiaChi(); // Khởi tạo ban đầu
                                });
                            </script>



                            <!-- Ghi chú đơn hàng -->
                            <div class="col-md-12">
                                <div class="mt-3 mb-5">
                                    <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note"
                                        placeholder="Ghi chú đơn hàng (nếu có)" cols="30" rows="4">{{ old('note', Auth::check() ? Auth::user()->note : '') }}</textarea>
                                    @error('note')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="checkout__totals-wrapper">
                        <div class="sticky-content">
                            <div style="width:100%" class="checkout__totals">
                                <h3>Đơn hàng của bạn</h3>
                                <table class="checkout-cart-items">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%" class="fw-bold">Sản phẩm</th>
                                            <th></th>                                       
                                            <th class="fw-bold text-center">Số lượng</th>
                                            <th class="fw-bold text-center">Giá</th>
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

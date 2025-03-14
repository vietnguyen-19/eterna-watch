@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <main>
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">GIỎ HÀNG</h2>
            <div class="checkout-steps">
                <a href="shop_cart.html" class="checkout-steps__item active d-flex align-items-center py-3">
                    <h2 style="background: #b42020; color:#e9ecef" class="me-1 mb-0 p-2">01</h2>
                    <span class="checkout-steps__item-title d-flex flex-column justify-content-center text-start">
                        <span class="step-title fw-bold">Giỏ hàng</span>
                        <em class="step-description text-muted">Quản lý danh sách sản phẩm của bạn</em>
                    </span>
                </a>

                <a href="shop_checkout.html" class="checkout-steps__item d-flex align-items-center py-3">
                    <h2 style="background: #b42020; color:#e9ecef" class="me-1 mb-0 p-2">02</h2>
                    <span class="checkout-steps__item-title d-flex flex-column justify-content-center text-start">
                        <span class="step-title fw-bold">Giao hàng và thanh toán</span>
                        <em class="step-description text-muted">Tiến hành thanh toán</em>
                    </span>
                </a>

                <a href="shop_order_complete.html" class="checkout-steps__item d-flex align-items-center py-3">
                    <h2 style="background: #b42020; color:#e9ecef" class="me-1 mb-0 p-2">03</h2>
                    <span class="checkout-steps__item-title d-flex flex-column justify-content-center text-start">
                        <span class="step-title fw-bold">Xác nhận</span>
                        <em class="step-description text-muted">Kiểm tra và gửi đơn hàng</em>
                    </span>
                </a>
            </div>


            <div class="shopping-cart">
                <div class="cart-table__wrapper">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th class="fw-bold">Sản phẩm</th>
                                <th></th>
                                <th class="fw-bold text-center">Giá</th>
                                <th class="fw-bold text-center">Số lượng</th>
                                <th class="fw-bold text-center">Tổng cộng</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $total = $total ?? 0;
                                $total_amount = $total_amount ?? 0;
                            @endphp
                            @if (empty($cart))
                                <td colspan="6" class="text-center py-4">
                                    <strong>Giỏ hàng của bạn đang trống.</strong>
                                </td>
                            @else
                                @foreach ($cart as $variantId => $item)
                                    @php
                                        $isObject = is_object($item);
                                        $productVariant = $isObject ? $item->productVariant : null;
                                        $product = $productVariant->product ?? null;

                                        $price = $productVariant->price ?? ($item['price'] ?? 0);
                                        $variant_id = $productVariant->id ?? ($item['variant_id'] ?? 0);
                                        $quantity = $isObject ? $item->quantity ?? 0 : $item['quantity'] ?? 0;
                                        $subtotal = $price * $quantity;
                                        $total += $subtotal;
                                        $total_amount = $total;
                                        $image = $productVariant->image ?? ($item['image'] ?? 'avatar/default.jpeg');

                                        $attributes = $isObject
                                            ? $productVariant->attributeValues ?? []
                                            : $item['attributes'] ?? [];
                                        $name = $isObject ? $productVariant->product->name ?? [] : $item['name'] ?? [];
                                    @endphp

                                    <tr data-variant-id="{{ $variant_id }}">
                                        <td>
                                            <div class="shopping-cart__product-item">
                                                <a href="product1_simple.html">
                                                    <img style="border: 1px solid #c4bebe;width:88px"
                                                        src="{{ Storage::url($image) }}" alt="">
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="shopping-cart__product-item__detail">
                                                <h4><a href="product1_simple.html">
                                                        <strong>{{ $name ?? 'Sản phẩm không tồn tại' }}</strong></a>
                                                </h4>
                                                <ul class="shopping-cart__product-item__options">
                                                    @if ($isObject)
                                                        @foreach ($attributes as $value)
                                                            <li>{{ $value->nameValue->attribute->attribute_name ?? 'Thuộc tính' }}:
                                                                {{ $value->nameValue->value_name ?? 'Không xác định' }}</li>
                                                        @endforeach
                                                    @else
                                                        @foreach ($attributes as $attribute)
                                                            <li>{{ $attribute['name'] ?? 'Thuộc tính' }}:
                                                                {{ $attribute['value'] ?? 'Không xác định' }}</li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="shopping-cart__product-price">{{ number_format($price, 0, ',', '.') }}đ</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="input-group quantity-control">
                                                <button class="qty-btn qty-reduce" type="button">-</button>
                                                <input style="width: 50px" type="number" name="quantity"
                                                    value="{{ $quantity }}" min="1" class="text-center qty-input"
                                                    data-variant-id="{{ $variant_id }}">
                                                <button class="qty-btn qty-increase" type="button">+</button>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="shopping-cart__subtotal">{{ number_format($subtotal, 0, ',', '.') }}đ</span>
                                        </td>
                                        <td>
                                            <a href="#" class="remove-cart" data-id="{{ $variant_id }}">
                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                    <path
                                                        d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>

                                    <td style="padding: 24px;" class="text-end" colspan="4"><strong>TẠM TÍNH</strong>
                                    </td>
                                    <td style="padding: 24px;" class="fw-bold text-center total">
                                        {{ number_format($total, 0, ',', '.') }}đ</td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="width:60%; padding: 8px 0px;">
                                        <div style="width:60%" class="position-relative bg-body">
                                            <select class="form-select" id="shipping-method">
                                                <option value="fixed" selected>Giao hàng (Cố định 30.000đ)</option>
                                                <option value="free">Miễn phí (Trên 500.000đ)</option>
                                                <option value="store">Nhận tại cửa hàng (0đ)</option>
                                            </select>

                                        </div>
                                    </td>
                                    <td class="text-end" colspan="2" style="padding: 8px;"><strong>PHÍ VẬN
                                            CHUYỂN</strong>
                                    </td>
                                    <td class="fw-bold text-center shipping" style="padding: 8px;">0đ</td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="width:60%; padding: 8px 0px;">
                                        <div style="width:60%" class="position-relative bg-body">
                                            <input class="form-control" type="text" name="discount-code"
                                                placeholder="Nhập mã giảm giá">
                                            <button style="background: #287bce; color:#fff" id="checkVoucher"
                                                class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4">Kiểm
                                                tra</button>
                                        </div>
                                    </td>
                                    <td style="padding: 8px;" class="text-end" colspan="2"><strong>GIẢM GIÁ</strong>
                                    </td>
                                    <td style="padding: 8px;" class="fw-bold text-center discount">0đ</td>
                                </tr>

                                <tr>

                                    <td colspan="2" style="padding: 8px 0px;">
                                        <button style="background: #b42020; color: #fff; padding:16px"
                                            class="btn btn-sm clear-cart-btn">
                                            XÓA GIỎ HÀNG
                                        </button>
                                    </td>
                                    <td class="text-end" colspan="2" style="padding: 16px;"><strong>THANH
                                            TOÁN</strong></td>
                                    <td class="fw-bold text-center total_amount" style="padding: 16px;">
                                        {{ number_format($total_amount, 0, ',', '.') }}đ</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                </div>
                <div class="shopping-cart__totals-wrapper">
                    <form name="checkout_form" action="{{ route('checkout.index') }}" method="POST">
                        @csrf
                        <div class="sticky-content">
                            <div class="shopping-cart__totals">

                                <div class="billing-info__wrapper">
                                    <h4><b>THÔNG TIN GIAO HÀNG</b></h4>
                                    <hr>
                                    <div class="row">
                                        <input name="total_amount" type="text" hidden>
                                        <input name="voucher_id" type="text" hidden>
                                        <input name="shipping_method" type="text" hidden>
                                        <input name="shipping" type="text" hidden>
                                        <input name="discount_price" type="text" hidden>
                                      

                                        <!-- Họ và tên -->
                                        <div class="col-md-12">
                                            <div class="form-floating my-2">
                                                <input type="text" class="form-control" id="full_name"
                                                    name="full_name"
                                                    value="{{ Auth::check() ? old('full_name', Auth::user()->name) : '' }}"
                                                    placeholder="Họ và Tên">
                                                <label for="full_name">Họ và Tên *</label>
                                            </div>
                                        </div>

                                        <!-- Số điện thoại -->
                                        <div class="col-md-12">
                                            <div class="form-floating my-2">
                                                <input type="text" class="form-control" id="phone_number"
                                                    name="phone_number"
                                                    value="{{ Auth::check() ? old('phone_number', Auth::user()->phone) : '' }}"
                                                    placeholder="Số điện thoại">
                                                <label for="phone_number">Số điện thoại *</label>
                                            </div>
                                        </div>

                                        <!-- Email -->
                                        <div class="col-md-12">
                                            <div class="form-floating my-2">
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ Auth::check() ? old('email', Auth::user()->email) : '' }}"
                                                    placeholder="Email">
                                                <label for="email">Email *</label>
                                            </div>
                                        </div>

                                        <!-- Địa chỉ -->
                                        <div class="col-md-12">
                                            <div class="form-floating my-2">
                                                <input type="text" class="form-control" id="street_address"
                                                    name="street_address"
                                                    value="{{ Auth::check() ? old('street_address', Auth::user()->defaultAddress->street_address) : '' }}"
                                                    placeholder="Địa chỉ">
                                                <label for="street_address">Địa chỉ *</label>
                                            </div>
                                        </div>

                                        <!-- Phường/Xã -->
                                        <div class="col-md-12">
                                            <div class="form-floating my-2">
                                                <input type="text" class="form-control" id="ward" name="ward"
                                                    value="{{ Auth::check() ? old('ward', Auth::user()->defaultAddress->ward) : '' }}"
                                                    placeholder="Phường/Xã">
                                                <label for="ward">Phường/Xã *</label>
                                            </div>
                                        </div>

                                        <!-- Quận/Huyện -->
                                        <div class="col-md-12">
                                            <div class="form-floating my-2">
                                                <input type="text" class="form-control" id="district"
                                                    name="district"
                                                    value="{{ Auth::check() ? old('district', Auth::user()->defaultAddress->district) : '' }}"
                                                    placeholder="Quận/Huyện">
                                                <label for="district">Quận/Huyện *</label>
                                            </div>
                                        </div>

                                        <!-- Tỉnh/Thành phố -->
                                        <div class="col-md-12">
                                            <div class="form-floating my-2">
                                                <input type="text" class="form-control" id="city" name="city"
                                                    value="{{ Auth::check() ? old('city', Auth::user()->defaultAddress->city) : '' }}"
                                                    placeholder="Tỉnh/Thành phố">
                                                <label for="city">Tỉnh/Thành phố *</label>
                                            </div>
                                        </div>

                                        <!-- Quốc gia -->
                                        <div class="col-md-12">
                                            <div class="form-floating my-2">
                                                <input type="text" class="form-control" id="country" name="country"
                                                    value="{{ Auth::check() ? old('country', Auth::user()->defaultAddress->country) : '' }}"
                                                    placeholder="Quốc gia">
                                                <label for="country">Quốc gia *</label>
                                            </div>
                                        </div>


                                        <!-- Ghi chú đơn hàng -->
                                        <div class="col-md-12">
                                            <div class="mt-3 mb-5">
                                                <textarea class="form-control" id="note" name="note" placeholder="Ghi chú đơn hàng (nếu có)" cols="30"
                                                    rows="4">{{ Auth::check() ? old('note', Auth::user()->note) : '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                            <div class="mobile_fixed-btn_wrapper">
                                <div class="button-wrapper container">
                                    <button class="btn btn-primary btn-checkout">TIẾN HÀNH THANH TOÁN</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <div class="mb-5 pb-xl-5"></div>
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".remove-cart").forEach(button => {
                button.addEventListener("click", function(event) {
                    event.preventDefault();

                    let variantId = this.getAttribute("data-id");
                    let row = this.closest("tr"); // Lấy dòng chứa sản phẩm để xóa khỏi giao diện

                    if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?")) {
                        fetch(`/cart/remove/${variantId}`, {
                                method: "DELETE",
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute("content"),
                                    "Content-Type": "application/json"
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    row.remove(); // Xóa dòng khỏi giao diện
                                    alert("Sản phẩm đã được xóa khỏi giỏ hàng.");
                                } else {
                                    alert("Xóa sản phẩm thất bại.");
                                }
                            })
                            .catch(error => console.error("Lỗi:", error));
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".quantity-control").forEach(control => {
                let input = control.querySelector(".qty-input");
                let increaseBtn = control.querySelector(".qty-increase");
                let reduceBtn = control.querySelector(".qty-reduce");

                increaseBtn.onclick = function() {
                    input.value = +input.value + 1;
                    updateCart(input);
                };

                reduceBtn.onclick = function() {
                    if (+input.value > 1) {
                        input.value = +input.value - 1;
                        updateCart(input);
                    }
                };

                input.onchange = function() {
                    if (+input.value < 1 || isNaN(+input.value)) input.value = 1;
                    updateCart(input);
                };
            });

            // Hàm cập nhật giỏ hàng
            function updateCart(input) {
                let variantId = input.dataset.variantId;
                let quantity = parseInt(input.value, 10);

                console.log("Cập nhật giỏ hàng:", {
                    variantId,
                    quantity
                });

                fetch("/cart/update", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                "content"),
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            variant_id: variantId,
                            quantity: quantity
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log("Phản hồi từ server:", data);
                        if (data.success) {
                            // Cập nhật subtotal của sản phẩm vừa thay đổi
                            let subtotalElement = input.closest("tr").querySelector(".shopping-cart__subtotal");
                            subtotalElement.innerText = numberWithCommas(data.subtotal) + "đ";

                            // Cập nhật tổng giỏ hàng
                            updateTotalAmount();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => console.error("Lỗi:", error));
            }

            // Hàm tính lại tổng giỏ hàng
            function updateTotalAmount() {
                let cartTotal = 0;

                document.querySelectorAll(".shopping-cart__subtotal").forEach(el => {
                    let value = parseFloat(el.innerText.replace(/[^\d]/g, "")) || 0;
                    cartTotal += value;
                });

                let shippingFee = 20000; // Phí vận chuyển cố định
                let totalAmount = cartTotal + shippingFee;

                console.log("Tổng giỏ hàng:", cartTotal, "Tổng thanh toán:", totalAmount);

                // Cập nhật tổng tiền hàng và tổng thanh toán trong giao diện
                let totalElement = document.querySelector(".total");
                if (totalElement) {
                    totalElement.innerText = numberWithCommas(cartTotal) + "đ";
                }

                let totalAmountElement = document.querySelector(".total_amount");
                if (totalAmountElement) {
                    totalAmountElement.innerText = numberWithCommas(totalAmount) + "đ";
                }
            }

            // Hàm định dạng số tiền có dấu phẩy
            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        });
    </script>
    <script>
        document.querySelector(".clear-cart-btn").addEventListener("click", function() {
            if (!confirm("Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng?")) return;

            fetch("/cart/clear", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                            "content"),
                        "Content-Type": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) location.reload();
                })
                .catch(error => console.error("Lỗi:", error));
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const shippingSelect = document.getElementById("shipping-method");
            const shippingFeeElement = document.querySelector(".shipping");
            const discountElement = document.querySelector(".discount");
            const totalAmountElement = document.querySelector(".total_amount");
            const voucherButton = document.getElementById("checkVoucher");

            // Các input hidden
            const totalAmountInput = document.querySelector("input[name='total_amount']");
            const voucherIdInput = document.querySelector("input[name='voucher_id']");
            const shippingMethodInput = document.querySelector("input[name='shipping_method']");
            const shippingFeeInput = document.querySelector("input[name='shipping']");
            const discountPrice = document.querySelector("input[name='discount_price']");

            let baseTotal = parseInt(totalAmountElement.innerText.replace(/\D/g, ""), 10) || 0;
            let discount = 0;
            let shippingFee = 30000; // Mặc định phí vận chuyển là 30.000đ (Giao hàng)
            let voucherId = null;

            // Hàm cập nhật tổng tiền
            function updateTotal() {
                let newTotal = baseTotal + shippingFee - discount;
                if (newTotal < 0) newTotal = 0; // Đảm bảo tổng tiền không âm

                totalAmountElement.textContent = numberWithCommas(newTotal) + "đ";
                totalAmountInput.value = newTotal; // Cập nhật vào input hidden
                shippingFeeInput.value = shippingFee; // Cập nhật phí vận chuyển
            }

            // Xử lý chọn phương thức vận chuyển
            shippingSelect.addEventListener("change", function() {
                if (baseTotal < 500000 && shippingSelect.value === "free") {
                    alert("Đơn hàng phải trên 500.000đ mới được miễn phí vận chuyển!");
                    shippingSelect.value = "fixed"; // Quay về "Giao hàng"
                }

                shippingFee = (shippingSelect.value === "fixed") ? 30000 : 0;
                shippingFeeElement.textContent = numberWithCommas(shippingFee) + "đ";
                shippingMethodInput.value = shippingSelect.value; // Cập nhật phương thức vận chuyển
                updateTotal();
            });

            // Xử lý kiểm tra voucher
            voucherButton.addEventListener("click", function() {
                let voucherCode = document.querySelector("input[name='discount-code']").value.trim();
                if (voucherCode === "") {
                    alert("Vui lòng nhập mã giảm giá.");
                    return;
                }

                fetch("/cart/check_voucher", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            code: voucherCode,
                            total: baseTotal
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.valid) {
                            alert(data.message);
                            discount = data.discount;
                            voucherId = data.voucher_id; // Lấy ID voucher từ server
                            discountElement.innerText = "-" + numberWithCommas(discount) + "đ";
                            discountPrice.value = discount;
                            voucherIdInput.value = voucherId; // Cập nhật voucher_id vào input hidden
                        } else {
                            alert(data.message);
                            discount = 0;
                            voucherId = null;
                            discountElement.innerText = "0đ";
                            voucherIdInput.value = ""; // Reset voucher_id
                        }
                        updateTotal();
                    })
                    .catch(error => {
                        console.error("Lỗi kiểm tra voucher:", error);
                        alert("Đã xảy ra lỗi, vui lòng thử lại!");
                    });
            });

            // Hàm định dạng số có dấu phẩy
            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            // ✅ Thiết lập mặc định khi tải trang
            shippingSelect.value = "fixed"; // Mặc định chọn "Giao hàng"
            shippingMethodInput.value = "fixed"; // Cập nhật vào input hidden
            shippingFeeElement.textContent = numberWithCommas(shippingFee) + "đ"; // Hiển thị phí vận chuyển
            updateTotal(); // Cập nhật tổng tiền
        });
    </script>
@endsection
@section('style')
    <style>
        /* Đảm bảo không bị ghi đè bởi CSS theme */
        .quantity-control {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-btn {
            width: 36px;
            height: 36px;
            font-size: 18px;
            border: 1px solid #ccc;
            background: #f8f9fa;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-btn:hover {
            background: #e9ecef;
        }

        .qty-input {
            font-weight: 500;
            width: 50px;
            height: 36px;
            text-align: center;
            font-size: 16px;
            border: 1px solid #ccc;
        }
    </style>
@endsection

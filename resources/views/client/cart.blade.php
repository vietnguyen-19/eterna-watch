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
                                <th style="width: 5%" class="fw-bold text-center">
                                    <input type="checkbox" id="check-all" class="check-all">
                                </th>
                                <th style="width: 10%" class="fw-bold">Sản phẩm</th>
                                <th></th>
                                <th class="fw-bold text-center">Giá</th>
                                <th class="fw-bold text-center">Số lượng</th>
                                <th class="fw-bold text-center">Tổng cộng</th>

                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $total = $total ?? 0;
                                $total_amount = $total_amount ?? 0;
                            @endphp

                            @if (empty($cart))
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <strong>Giỏ hàng của bạn đang trống.</strong>
                                    </td>
                                </tr>
                            @else
                                @foreach ($cart as $variantId => $item)
                                    @php
                                        $isObject = is_object($item);
                                        $productVariant = $isObject ? $item->productVariant : null;
                                        $product = $productVariant->product ?? null;

                                        $price = $productVariant->price ?? ($item['price'] ?? 0);
                                        $stock = $productVariant->stock ?? ($item['stock'] ?? 0);
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
                                        <td class="text-center">
                                            <input type="checkbox" class="check-item" data-variant-id="{{ $variant_id }}">
                                        </td>
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
                                            <span style="color:red">(Còn {{ $stock ?? 'NaN' }} sản phẩm)</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="input-group quantity-control">
                                                <button class="qty-btn qty-reduce" type="button"
                                                    data-variant-id="{{ $variant_id }}">-</button>
                                                <input style="width: 50px" type="number" name="quantity"
                                                    value="{{ $quantity }}" min="1"
                                                    class="text-center qty-input" data-variant-id="{{ $variant_id }}">
                                                <button class="qty-btn qty-increase" type="button"
                                                    data-variant-id="{{ $variant_id }}"
                                                    data-stock="{{ $stock }}">+</button>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <span class="subtotal">{{ number_format($subtotal, 0, ',', '.') }}đ</span>
                                        </td>

                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
                    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
                    <div id="fixedBar" class="card mt-5">
                        <div style="border-bottom:1px solid #a7a7a7" class="card-header bg-dark p-2">
                            <div class="container"> <!-- Thêm container để giới hạn chiều rộng -->
                                <div class="d-flex justify-content-end align-items-center">
                                    <div class="position-relative w-50">
                                        <input class="form-control form-control-sm" type="text" name="discount-code"
                                            placeholder="Nhập mã giảm giá" disabled>
                                        <button data-total="{{ $total }}" style="background: #1d7bda; color:#fff"
                                            id="checkVoucher" class="btn fw-medium position-absolute top-0 end-0 h-100 px-4"
                                            disabled>Kiểm tra</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body bg-dark p-2">
                            <div class="container"> <!-- Thêm container để giới hạn chiều rộng -->
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <button id="remove-selected" class="btn btn-sm text-white"
                                        style="background-color: #c93030; padding: 10px;border-radius: 3px">
                                        Xóa sản phẩm đã chọn
                                    </button>
                                    <div id="total_amount" class="text-end flex-grow-1 mx-2 text-white">
                                        <small style="color: red">
                                            (Giảm giá : <span id="discount">0</span> đ)<br>
                                        </small>
                                        TỔNG THANH TOÁN (<span id="count_product">0</span> sản phẩm):
                                        <span id="total_price">0</span>đ
                                    </div>

                                    <form id="checkout-form" method="POST" action="{{ route('checkout.store') }}">
                                        @csrf
                                        <input type="hidden" name="order_items" id="order_items" value="">
                                        <input type="hidden" name="voucher_id" id="voucher_id" value="">
                                        <input type="hidden" name="discount" id="discount_voucher" value="">
                                        <input type="hidden" name="total_amount" id="total_voucher" value="">

                                        <button type="submit"
                                            style="background-color: #c93030; padding: 10px 24px ; color:#fff; border-radius: 3px"
                                            class="btn btn-sm">MUA HÀNG</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>
    </main>
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkAll = document.querySelector("#check-all");
            const checkVoucherBtn = document.querySelector("#checkVoucher");
            const discountInput = document.querySelector("[name='discount-code']");
            const totalAmountEl = document.querySelector("#total_amount");
            const discount = document.querySelector("#discount");
            const removeSelectedBtn = document.querySelector("#remove-selected");

            let appliedDiscount = 0;

            function updateCheckItems() {
                window.checkItems = document.querySelectorAll(".check-item");
            }

            function updateVoucherStatus() {
                updateCheckItems();
                const hasSelectedProduct = [...checkItems].some(item => item.checked);
                checkVoucherBtn.disabled = !hasSelectedProduct;
                discountInput.disabled = !hasSelectedProduct;

                if (!hasSelectedProduct) {
                    discountInput.value = ""; // Xóa mã giảm giá khi không chọn sản phẩm
                }
            }

            function updateSelectedProducts() {
                updateCheckItems();
                let selectedProducts = [];

                checkItems.forEach(item => {
                    if (item.checked) {
                        selectedProducts.push(item.dataset.variantId);
                    }
                });

                window.selectedProducts = selectedProducts;
                console.log("Danh sách sản phẩm đã chọn:", selectedProducts);
            }

            function updateCartQuantity(input) {
                let variantId = input.dataset.variantId;
                let quantity = parseInt(input.value);
                let row = input.closest("tr");
                let price = parseFloat(row.querySelector(".shopping-cart__product-price").textContent.replace(/\D/g,
                    ""));
                let subtotalEl = row.querySelector(".subtotal");

                let stock = parseInt(input.closest(".input-group").querySelector(".qty-increase").dataset.stock);
                console.log(stock);
                if (quantity > stock) {
                    alert(
                        `Số lượng bạn yêu cầu vượt quá số lượng tồn kho. Tối đa có thể mua là ${stock} sản phẩm.`
                    );
                    input.value = stock; // Đặt lại số lượng về tối đa tồn kho
                    return;
                }
                fetch("/cart/update", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            variant_id: variantId,
                            quantity: quantity
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            let newSubtotal = price * quantity;
                            subtotalEl.textContent = newSubtotal.toLocaleString("vi-VN") + "đ";
                            updateTotalAmount();
                        }
                    });
            }

            function updateTotalAmount() {
                updateCheckItems();
                let selectedProducts = [];
                let totalItems = 0;

                let orderItemsInput = document.getElementById("order_items");
                let voucherIdInput = document.getElementById("voucher_id");
                let discountOrder = document.getElementById("discount_voucher");
                let totalVoucher = document.getElementById("total_voucher");

                checkItems.forEach(item => {
                    if (item.checked) {
                        let row = item.closest("tr");
                        let variantId = item.dataset.variantId;
                        let price = parseFloat(row.querySelector(".shopping-cart__product-price")
                            .textContent.replace(/\D/g, ""));
                        let quantity = parseInt(row.querySelector(".qty-input").value);
                        totalItems += quantity;
                        selectedProducts.push({
                            variant_id: variantId,
                            quantity: quantity,
                            price: price
                        });
                    }
                });

                let discountCode = discountInput.value.trim();

                fetch("/cart/update-total", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            products: selectedProducts,
                            discount_code: discountCode
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            orderItemsInput.value = JSON.stringify(data.order_items);
                            voucherIdInput.value = data.voucher_id;
                            discountOrder.value = data.discount;
                            totalVoucher.value = data.total_amount;
                            document.getElementById("count_product").textContent = totalItems;
                            totalAmountEl.innerHTML =
                                `<small style="color: red">
                                            (Giảm giá : <span id="discount">-${data.discount}</span> đ)<br>
                                        </small>TỔNG THANH TOÁN (<span id="count_product">${totalItems}</span> sản phẩm): ${data.total_amount}đ`;
                        }
                    });
            }

            // Xóa tất cả sản phẩm đã chọn
            removeSelectedBtn.addEventListener("click", function() {
                updateCheckItems();
                let selectedProducts = [];

                checkItems.forEach(item => {
                    if (item.checked) {
                        selectedProducts.push(item.dataset.variantId);
                    }
                });

                if (selectedProducts.length === 0) {
                    alert("Vui lòng chọn ít nhất một sản phẩm để xóa!");
                    return;
                }

                if (!confirm("Bạn có chắc muốn xóa các sản phẩm đã chọn?")) return;

                fetch("/cart/remove-selected", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            variant_ids: selectedProducts
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            checkItems.forEach(item => {
                                if (item.checked) {
                                    item.closest("tr").remove();
                                }
                            });
                            updateCheckItems();
                            updateSelectedProducts();
                            updateTotalAmount();
                        }
                    });
            });

            // Chọn/Bỏ chọn tất cả sản phẩm
            checkAll.addEventListener("change", function() {
                updateCheckItems();
                checkItems.forEach(item => item.checked = this.checked);
                updateVoucherStatus();
                updateTotalAmount();
            });

            // Chọn/Bỏ chọn từng sản phẩm
            document.addEventListener("change", function(event) {
                if (event.target.classList.contains("check-item")) {
                    updateVoucherStatus();
                    updateTotalAmount();
                }
            });

            // Cập nhật số lượng sản phẩm
            document.addEventListener("change", function(event) {
                if (event.target.classList.contains("qty-input")) {
                    updateCartQuantity(event.target);
                }
            });

            document.addEventListener("click", function(event) {
                if (event.target.classList.contains("qty-btn")) {
                    let input = event.target.closest(".quantity-control").querySelector(".qty-input");
                    let decreaseButton = event.target.closest(".quantity-control").querySelector(
                        ".qty-reduce");

                    let newQuantity = parseInt(input.value) + (event.target.classList.contains(
                        "qty-increase") ? 1 : -1);
                    if (newQuantity < 1) newQuantity = 1;

                    input.value = newQuantity;
                    decreaseButton.disabled = newQuantity === 1;
                    updateCartQuantity(input);
                }
            });

            // Kiểm tra mã giảm giá
            checkVoucherBtn.addEventListener("click", function() {
                let voucherCode = discountInput.value.trim();
                if (!voucherCode) return alert("Vui lòng nhập mã giảm giá!");
                let totalProductAmount = parseFloat(this.dataset.total);

                fetch("/cart/check_voucher", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            code: voucherCode,
                            total: totalProductAmount
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.valid) {
                            appliedDiscount = data.discount;
                            alert(`Mã giảm giá hợp lệ! Giảm ${data.discount}đ.`);
                            updateTotalAmount();
                        } else {
                            alert(data.message || "Mã giảm giá không hợp lệ!");
                        }
                    });
            });

            updateVoucherStatus();
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fixedBar = document.getElementById("fixedBar");
            const footer = document.querySelector("footer");

            if (!fixedBar || !footer) return;

            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            // Khi footer xuất hiện trên màn hình, ẩn fixedBar
                            fixedBar.classList.add("hidden");
                        } else {
                            // Khi footer ra khỏi màn hình, hiện lại fixedBar
                            fixedBar.classList.remove("hidden");
                        }
                    });
                }, {
                    threshold: 0.1
                } // Khi footer hiển thị ít nhất 10%, kích hoạt
            );

            observer.observe(footer);
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

        #fixedBar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgb(48, 48, 48);
            /* Nền trắng cho toàn bộ */
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1050;
            transition: transform 0.4s ease-in-out, opacity 0.4s ease-in-out;
        }

        #fixedBar .container {
            width: 80%;
            /* Các phần tử con chỉ chiếm 80% chiều rộng */
            margin: 0 auto;
            /* Căn giữa */
        }

        .hidden {
            opacity: 0;
            transform: translateY(100%);
            pointer-events: none;
        }
    </style>
@endsection

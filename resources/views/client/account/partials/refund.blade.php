@extends('client.account.main')
@section('account_content')
    <form method="POST" action="{{ route('refunds.store', $order->id) }}">
        @csrf
        <div class="checkout__totals-wrapper">
            <div style="width: 100%" class="checkout__totals">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0 d-flex align-items-center gap-2">
                        Hoàn trả đơn hàng | <strong>{{ $order->order_code }}</strong> |
                    </h4>
                </div>


                <table class="checkout-cart-items">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-dark fw-bold" scope="col">Sản phẩm</th>
                            <th class="text-dark fw-bold" scope="col">Thuộc tính</th>
                            <th class="text-dark fw-bold text-center" scope="col">Số lượng đã mua</th>
                            <th class="text-dark fw-bold text-center" scope="col">Giá</th>
                            <th class="text-dark fw-bold text-center" scope="col">Số lượng muốn hoàn</th>
                            <th class="text-dark fw-bold text-end" scope="col">Thành tiền hoàn</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                            <tr>
                                <td>
                                    <div class="shopping-cart__product-item">
                                        <a href="{{ route('client.shop.show', $item->productVariant->product->id) }}">
                                            <img style="border: 1px solid #c4bebe;width:88px"
                                                src="{{ Storage::url($item->productVariant->image) }}" alt="">
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="shopping-cart__product-item__detail">
                                        <h4>
                                            <a href="{{ route('client.shop.show', $item->productVariant->product->id) }}">
                                                <strong>{{ $item->productVariant->product->name ?? 'Sản phẩm không tồn tại' }}</strong>
                                            </a>
                                        </h4>
                                        <ul class="shopping-cart__product-item__options">
                                            @foreach ($item->productVariant->attributeValues as $value)
                                                <li>{{ $value->nameValue->attribute->attribute_name ?? 'Thuộc tính' }}:
                                                    {{ $value->nameValue->value_name ?? 'Không xác định' }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-center">{{ number_format($item->unit_price) }}đ</td>
                                <td class="text-center">
                                    <input type="number" name="refund_quantity[{{ $item->id }}]"
                                        class="form-control form-control-sm refund-quantity" min="0"
                                        max="{{ $item->quantity }}" value="{{ old('refund_quantity.' . $item->id, 0) }}"
                                        data-price="{{ $item->unit_price }}">


                                    @error('refund_quantity.' . $item->id)
                                        <div style="color: #e84040" class="mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </td>

                                <td class="text-end">
                                    <span class="refund-total" data-id="{{ $item->id }}">0đ</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <table class="checkout-totals">
                    <tbody>
                        <tr>
                            <th><strong>Giảm giá khi áp voucher</strong></th>
                            <td class="text-end"> <span class="shopping-cart__product-price">
                                    <strong>
                                        {{ number_format($order->getDiscountAmount(), 0, ',', '.') }}đ</strong>
                                </span></td>
                        </tr>
                        <tr>
                            <th><strong>Đã thanh toán</strong></th>
                            <td class="text-end"> <span class="shopping-cart__product-price">
                                    <strong>
                                        {{ number_format($order->total_amount, 0, ',', '.') }}đ</strong>
                                </span></td>
                        </tr>

                    </tbody>
                </table>
                <!-- Lưu ý với khách hàng -->
                <div
                    style="margin-top: 20px; padding: 12px; border: 1px solid #ffeeba; background-color: #fff3cd; color: #856404;">
                    <strong>Lưu ý:</strong> Nếu bạn hoàn hàng, <strong>voucher sẽ không còn hiệu
                        lực</strong>. Những sản phẩm không hoàn sẽ được tính lại theo <strong>giá
                        gốc</strong>.
                </div>

                <!-- Tổng tiền hoàn -->
                <div class="text-end" style="margin-top: 20px;">
                    <input type="text" name="total_refund_amount" id="total_refund_amount" hidden>
                    <h5><strong>Tổng tiền hoàn:</strong> <span id="tongHoan">0đ</span></h5>
                    @error('total_refund_amount')
                        <div style="color: #e84040" class="mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label><strong>Lý do hoàn hàng:</strong></label>
                    <textarea name="refund_reason" class="form-control">{{ old('refund_reason') }}</textarea>

                    @error('refund_reason')
                        <div style="color: #e84040" class="mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mt-3">Gửi yêu cầu</button>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script>
        document.querySelectorAll('.refund-quantity').forEach(input => {
            input.addEventListener('input', function() {
                const max = parseInt(this.max);
                const min = parseInt(this.min);
                let value = parseInt(this.value);

                if (value > max) {
                    this.value = max;
                } else if (value < min || isNaN(value)) {
                    this.value = min;
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-cancel-order').forEach(button => {
                button.addEventListener('click', function() {
                    let orderId = this.getAttribute('data-order-id');

                    if (!confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')) {
                        return;
                    }

                    fetch(`{{ route('account.cancel', '') }}/${orderId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                location.reload(); // Hoặc cập nhật UI
                            } else {
                                alert(data.error);
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                        });
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const refundInputs = document.querySelectorAll('.refund-quantity');
            const tongHoanEl = document.getElementById('tongHoan');
            const hiddenInput = document.getElementById('total_refund_amount'); // Thêm dòng này
            const discount = {{ $order->getDiscountAmount() ?? 0 }};

            // Hàm định dạng tiền
            function formatCurrency(value) {
                return value.toLocaleString('vi-VN') + 'đ';
            }

            // Hàm cập nhật tổng tiền hoàn
            function updateRefundTotal() {
                let totalRefund = 0;

                refundInputs.forEach(input => {
                    const quantity = parseInt(input.value) || 0;
                    const unitPrice = parseInt(input.getAttribute('data-price')) || 0;
                    const itemId = input.name.match(/\d+/)[0];
                    const itemTotal = quantity * unitPrice;

                    // Cập nhật thành tiền hoàn cho từng sản phẩm
                    const refundTotalEl = document.querySelector(`.refund-total[data-id="${itemId}"]`);
                    if (refundTotalEl) {
                        refundTotalEl.textContent = formatCurrency(itemTotal);
                    }

                    totalRefund += itemTotal;
                });

                // Tính tổng tiền hoàn trừ đi giảm giá
                let finalRefund = totalRefund - discount;
                if (finalRefund < 0) finalRefund = 0;

                tongHoanEl.textContent = formatCurrency(finalRefund);

                // ✅ Cập nhật giá trị input hidden
                if (hiddenInput) {
                    hiddenInput.value = finalRefund;
                }
            }

            // Gắn sự kiện khi người dùng thay đổi số lượng hoàn
            refundInputs.forEach(input => {
                input.addEventListener('input', updateRefundTotal);
            });

            // Gọi khi trang load lần đầu
            updateRefundTotal();
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
@endsection

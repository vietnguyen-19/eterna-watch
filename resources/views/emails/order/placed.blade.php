@component('mail::message')
# 🎉 Cảm ơn bạn đã đặt hàng tại {{ config('app.name') }}!

Xin chào **{{ $order->customer_name }}**,

Chúng tôi đã nhận được đơn hàng **#{{ $order->order_code }}** của bạn vào lúc **{{ $order->created_at->format('H:i d/m/Y') }}**.

---

### 🧾 Thông tin đơn hàng:

- **Tổng tiền:** {{ number_format($order->total_amount, 0, ',', '.') }} VND  
- **Phương thức thanh toán:** {{ strtoupper($order->payment_method) }}  
- **Trạng thái:** {{ $order->status ?? 'Chờ xử lý' }}

---

### 📦 Danh sách sản phẩm:

@foreach ($order->orderItems as $item)
- {{ $item->productVariant->product->name }} × {{ $item->quantity }} — {{ number_format($item->total_price, 0, ',', '.') }} VND
@endforeach

---

@component('mail::button', ['url' => route('account.order')])
🔍 Xem đơn hàng của bạn
@endcomponent

Nếu bạn có bất kỳ câu hỏi nào, hãy liên hệ với chúng tôi qua email hoặc hotline được ghi trên website.

---

Cảm ơn bạn đã mua sắm tại **{{ config('app.name') }}**!  
**Chúc bạn một ngày tốt lành!** 🌟

Trân trọng,  
**{{ config('app.name') }} Team**
@endcomponent

<p>Kính gửi {{ $refund->order->customer_name }},</p>

<p>Chúng tôi xin thông báo rằng yêu cầu hoàn tiền cho đơn hàng <strong>#{{ $refund->order->id }}</strong> của Quý khách đã được <strong>phê duyệt</strong>.</p>

<p><strong>Số tiền hoàn lại:</strong> {{ number_format($refund->total_refund_amount, 0, ',', '.') }} VNĐ</p>

@if ($refund->order->payment_method === 'vnpay')
    <p><strong>Thông tin giao dịch hoàn tiền:</strong></p>
    <ul>
        <li><strong>Mã giao dịch:</strong> {{ $refund->vnp_transaction_no }}</li>
        <li><strong>Mã phản hồi từ VNPay:</strong> {{ $refund->vnp_response_code }}</li>
        <li><strong>Thời gian hoàn tiền:</strong> {{ \Carbon\Carbon::parse($refund->refunded_at)->format('d/m/Y H:i') }}</li>
    </ul>
    <p>Số tiền trên sẽ được hoàn trả trực tiếp về tài khoản ngân hàng hoặc thẻ mà Quý khách đã sử dụng để thanh toán qua VNPay.</p>
@else
    <p>Chúng tôi sẽ thực hiện hoàn tiền theo phương thức thanh toán ban đầu mà Quý khách đã lựa chọn (COD). Bộ phận hỗ trợ sẽ liên hệ nếu cần thêm thông tin.</p>
@endif

<p>Chúng tôi rất mong tiếp tục được phục vụ Quý khách trong những lần mua sắm tiếp theo.</p>

<p>Trân trọng cảm ơn Quý khách đã tin tưởng và lựa chọn {{ config('app.name') }}.</p>

<p>Trân trọng,<br>
Đội ngũ {{ config('app.name') }}</p>

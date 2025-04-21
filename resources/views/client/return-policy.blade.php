@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <section class="policy-section container py-5 px-5">
        <div class="row g-4">
            <!-- Nội dung chính -->
            <h1 class="mb-4 text-center text-uppercase">🎯 Chính Sách Hoàn Trả Và Hoàn Tiền</h1>

            <p>Chúng tôi cam kết mang đến cho quý khách hàng những sản phẩm nội thất chất lượng cùng dịch vụ hậu mãi minh
                bạch và tận tâm. Trong trường hợp sản phẩm không đáp ứng mong đợi, quý khách có thể yêu cầu hoàn trả theo
                chính sách dưới đây:</p>

            <hr>

            <h4>1. 📦 Điều kiện áp dụng hoàn trả</h4>
            <ul>
                <li>Sản phẩm bị lỗi do nhà sản xuất (gãy, hư hỏng, trầy xước…)</li>
                <li>Giao sai sản phẩm, thiếu phụ kiện, sai mẫu mã</li>
                <li>Hàng hóa không đúng mô tả trên website</li>
                <li>Chưa qua sử dụng và còn nguyên bao bì (trong thời hạn cho phép)</li>
            </ul>
            <p><strong>⏰ Thời gian yêu cầu hoàn trả:</strong> Trong vòng <strong>7 ngày</strong> kể từ ngày nhận hàng.</p>

            <hr>

            <h4>2. 📌 Trường hợp không được hoàn trả</h4>
            <ul>
                <li>Sản phẩm đã qua sử dụng, bị tác động vật lý từ phía khách hàng</li>
                <li>Sản phẩm đã hết thời gian yêu cầu hoàn trả</li>
                <li>Sản phẩm thuộc danh mục <strong>không hỗ trợ hoàn trả</strong> (nếu có ghi rõ trong phần mô tả)</li>
            </ul>

            <hr>

            <h4>3. 🔁 Quy trình hoàn trả hàng</h4>
            <ol>
                <li>Quý khách gửi yêu cầu hoàn trả qua website hoặc hotline</li>
                <li>Bộ phận CSKH xác minh và duyệt yêu cầu</li>
                <li>Quý khách đóng gói lại sản phẩm đầy đủ và gửi về kho</li>
                <li>Sau khi kiểm tra hàng hoàn hợp lệ, chúng tôi tiến hành hoàn tiền theo phương thức thanh toán ban đầu
                </li>
            </ol>

            <hr>

            <h4>4. 💳 Phương thức hoàn tiền</h4>

            <h5>➤ Thanh toán qua ví điện tử MoMo hoặc thẻ Stripe:</h5>
            <ul>
                <li>Tiền sẽ được hoàn lại trực tiếp vào tài khoản MoMo/thẻ tín dụng/debit của quý khách</li>
                <li>Thời gian hoàn tiền: từ <strong>5 – 10 ngày làm việc</strong></li>
            </ul>

            <h5>➤ Thanh toán tiền mặt (COD):</h5>
            <ul>
                <li>Quý khách vui lòng cung cấp thông tin tài khoản ngân hàng để chúng tôi chuyển khoản hoàn tiền</li>
                <li>Trường hợp không có tài khoản, có thể hoàn tiền mặt tại văn phòng hoặc qua đối tác vận chuyển</li>
                <li>Thời gian hoàn tiền: từ <strong>3 – 7 ngày làm việc</strong></li>
            </ul>

            <hr>

            <h4>5. 📞 Liên hệ hỗ trợ</h4>
            <p>Nếu quý khách cần hỗ trợ thêm, vui lòng liên hệ:</p>
            <ul>
                <li><strong>Hotline:</strong> 1900 XXX XXX</li>
                <li><strong>Email:</strong> hotro@tenwebsite.com</li>
                <li><strong>Thời gian làm việc:</strong> 8h – 17h từ Thứ 2 đến Thứ 7</li>
            </ul>

            <hr>

            <p><strong>🔒 Lưu ý bảo mật:</strong> Thông tin tài khoản ngân hàng của quý khách chỉ được sử dụng phục vụ mục
                đích hoàn tiền và cam kết bảo mật tuyệt đối.</p>
        </div>
    </section>

    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
@endsection
@section('script')
@endsection
@section('style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

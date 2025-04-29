@extends('client.layouts.master')

@section('content')
    <div class="spacer py-4 py-xl-5"></div>
    <div class="mb-4 pb-lg-3"></div>
    <section class="policy-section container py-5 px-4 px-md-5">
        <div class="row g-4">
            <h1 class="mb-4 text-center text-uppercase fw-bold">Chính Sách Hoàn Trả Và Hoàn Tiền</h1>

            <p class="lead text-muted">
                Chúng tôi cam kết mang đến trải nghiệm mua sắm nội thất chất lượng với dịch vụ hậu mãi minh bạch và chuyên nghiệp. Dưới đây là chính sách hoàn trả chi tiết nhằm đảm bảo quyền lợi tối ưu cho quý khách.
            </p>

            <hr class="my-4">

            <h4 class="fw-semibold">1. Điều Kiện Áp Dụng Hoàn Trả</h4>
            <ul class="list-unstyled ms-3">
                <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Sản phẩm bị lỗi do nhà sản xuất (hư hỏng, trầy xước, gãy vỡ...).</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Giao sai sản phẩm, thiếu phụ kiện hoặc không đúng mẫu mã.</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Sản phẩm không đúng mô tả trên website.</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Sản phẩm chưa qua sử dụng, còn nguyên bao bì và trong thời hạn cho phép.</li>
            </ul>
            <p class="text-muted"><strong>Thời gian yêu cầu:</strong> Trong vòng <strong>7 ngày</strong> kể từ ngày nhận hàng.</p>

            <hr class="my-4">

            <h4 class="fw-semibold">2. Trường Hợp Không Được Hoàn Trả</h4>
            <ul class="list-unstyled ms-3">
                <li class="mb-2"><i class="bi bi-x-circle-fill text-danger me-2"></i>Sản phẩm đã qua sử dụng hoặc bị hư hỏng do tác động từ khách hàng.</li>
                <li class="mb-2"><i class="bi bi-x-circle-fill text-danger me-2"></i>Sản phẩm đã hết thời hạn yêu cầu hoàn trả.</li>
                <li class="mb-2"><i class="bi bi-x-circle-fill text-danger me-2"></i>Sản phẩm thuộc danh mục không hỗ trợ hoàn trả (được ghi rõ trong mô tả).</li>
            </ul>

            <hr class="my-4">

            <h4 class="fw-semibold">3. Quy Trình Hoàn Trả</h4>
            <ol class="ms-3">
                <li class="mb-2">Gửi yêu cầu hoàn trả qua website hoặc hotline chính thức.</li>
                <li class="mb-2">Bộ phận chăm sóc khách hàng xác minh và duyệt yêu cầu.</li>
                <li class="mb-2">Đóng gói sản phẩm đầy đủ và gửi về kho theo hướng dẫn.</li>
                <li class="mb-2">Sau khi kiểm tra hàng hóa hợp lệ, hoàn tiền sẽ được thực hiện theo phương thức thanh toán ban đầu.</li>
            </ol>

            <hr class="my-4">

            <h4 class="fw-semibold">4. Phương Thức Hoàn Tiền</h4>
            <h5 class="fw-medium mt-4">Thanh Toán Qua Ví Điện Tử MoMo Hoặc Thẻ Stripe</h5>
            <ul class="list-unstyled ms-3">
                <li class="mb-2"><i class="bi bi-wallet2 text-primary me-2"></i>Hoàn tiền trực tiếp vào tài khoản MoMo hoặc thẻ tín dụng/debit.</li>
                <li class="mb-2"><i class="bi bi-clock text-primary me-2"></i>Thời gian xử lý: <strong>5 – 10 ngày làm việc</strong>.</li>
            </ul>
            <h5 class="fw-medium mt-4">Thanh Toán Tiền Mặt (COD)</h5>
            <ul class="list-unstyled ms-3">
                <li class="mb-2"><i class="bi bi-bank text-primary me-2"></i>Cung cấp thông tin tài khoản ngân hàng để nhận chuyển khoản.</li>
                <li class="mb-2"><i class="bi bi-cash text-primary me-2"></i>Nếu không có tài khoản, hoàn tiền mặt tại văn phòng hoặc qua đối tác vận chuyển.</li>
                <li class="mb-2"><i class="bi bi-clock text-primary me-2"></i>Thời gian xử lý: <strong>3 – 7 ngày làm việc</strong>.</li>
            </ul>

            <hr class="my-4">

            <h4 class="fw-semibold">5. Liên Hệ Hỗ Trợ</h4>
            <p class="text-muted">Quý khách cần thêm thông tin, vui lòng liên hệ:</p>
            <ul class="list-unstyled ms-3">
                <li class="mb-2"><i class="bi bi-telephone-fill text-primary me-2"></i><strong>Hotline:</strong> 1900 XXX XXX</li>
                <li class="mb-2"><i class="bi bi-envelope-fill text-primary me-2"></i><strong>Email:</strong> hotro@tenwebsite.com</li>
                <li class="mb-2"><i class="bi bi-clock-fill text-primary me-2"></i><strong>Thời gian làm việc:</strong> 8h00 – 17h00, Thứ 2 đến Thứ 7</li>
            </ul>

            <hr class="my-4">

            <p class="text-muted"><strong>Bảo mật thông tin:</strong> Mọi thông tin tài khoản ngân hàng của quý khách chỉ được sử dụng cho mục đích hoàn tiền và được bảo mật tuyệt đối theo chính sách của chúng tôi.</p>
        </div>
    </section>
    <div class="spacer py-4 py-xl-5"></div>
@endsection

@section('script')
@endsection

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .policy-section {
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        h1, h4, h5 {
            color: #1a1a1a;
        }
        hr {
            border-color: #e0e0e0;
        }
        .list-unstyled li {
            line-height: 1.6;
        }
        .text-primary {
            color: #007bff !important;
        }
        .spacer {
            background-color: #fff;
        }
    </style>
@endsection
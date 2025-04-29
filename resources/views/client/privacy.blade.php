@extends('client.layouts.master')

@section('content')
    <div class="spacer py-4 py-xl-5"></div>
    <div class="mb-4 pb-lg-3"></div>
    <section class="policy-section container py-5 px-4 px-md-5">
        <div class="row g-4">
            <!-- Nội dung chính -->
            <div class="col-lg-8">
                <div class="mb-5">
                    <h2 class="fw-bold mb-3 text-uppercase">1. Chính Sách Bảo Mật</h2>
                    <p class="text-muted lead">
                        Chúng tôi cam kết bảo vệ thông tin cá nhân của quý khách hàng, đảm bảo mọi dữ liệu thu thập chỉ phục vụ xử lý đơn hàng và nâng cao trải nghiệm dịch vụ.
                    </p>
                    <ul class="list-unstyled ms-3">
                        <li class="mb-2"><i class="bi bi-shield-lock-fill text-primary me-2"></i>Không chia sẻ thông tin cá nhân với bên thứ ba trừ khi có sự đồng ý của khách hàng.</li>
                        <li class="mb-2"><i class="bi bi-credit-card-fill text-primary me-2"></i>Thông tin thanh toán được mã hóa và bảo mật theo tiêu chuẩn PCI DSS.</li>
                        <li class="mb-2"><i class="bi bi-person-check-fill text-primary me-2"></i>Khách hàng có quyền yêu cầu xem, chỉnh sửa hoặc xóa thông tin cá nhân bất kỳ lúc nào.</li>
                    </ul>
                </div>

                <div class="mb-5">
                    <h2 class="fw-bold mb-3 text-uppercase">2. Điều Khoản Sử Dụng</h2>
                    <p class="text-muted lead">
                        Việc sử dụng website của chúng tôi đồng nghĩa với việc quý khách chấp thuận các điều khoản dưới đây, nhằm đảm bảo trải nghiệm công bằng và minh bạch.
                    </p>
                    <ul class="list-unstyled ms-3">
                        <li class="mb-2"><i class="bi bi-lock-fill text-primary me-2"></i>Cấm sử dụng website cho các mục đích bất hợp pháp hoặc trái quy định pháp luật.</li>
                        <li class="mb-2"><i class="bi bi-copyright text-primary me-2"></i>Không sao chép, phân phối nội dung website mà không có sự cho phép bằng văn bản.</li>
                        <li class="mb-2"><i class="bi bi-info-circle-fill text-primary me-2"></i>Chúng tôi có quyền cập nhật hoặc thay đổi nội dung website mà không cần thông báo trước.</li>
                    </ul>
                </div>

                <div class="mb-5">
                    <h2 class="fw-bold mb-3 text-uppercase">3. Chính Sách Bảo Hành</h2>
                    <p class="text-muted lead">
                        Tất cả sản phẩm đồng hồ chính hãng đều được áp dụng chính sách bảo hành minh bạch, đảm bảo quyền lợi tối đa cho khách hàng.
                    </p>
                    <ul class="list-unstyled ms-3">
                        <li class="mb-2"><i class="bi bi-tools text-primary me-2"></i>Bảo hành <strong>12 tháng</strong> cho các lỗi kỹ thuật do nhà sản xuất.</li>
                        <li class="mb-2"><i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>Không áp dụng bảo hành cho hư hỏng do người dùng (rơi vỡ, vào nước quá mức, tự ý tháo lắp).</li>
                    </ul>
                </div>

                <div>
                    <h2 class="fw-bold mb-3 text-uppercase">4. Trách Nhiệm Pháp Lý</h2>
                    <p class="text-muted lead">
                        Chúng tôi không chịu trách nhiệm đối với các thiệt hại phát sinh từ việc sử dụng sản phẩm không đúng hướng dẫn hoặc sai mục đích.
                    </p>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="bg-white border rounded p-4 shadow-sm">
                    <h5 class="fw-semibold mb-3 text-uppercase">Liên Hệ Pháp Lý</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-telephone-fill text-primary me-2"></i><strong>Hotline:</strong> 0123 456 789</li>
                        <li class="mb-2"><i class="bi bi-envelope-fill text-primary me-2"></i><strong>Email:</strong> support@eterna.vn</li>
                        <li class="mb-2"><i class="bi bi-geo-alt-fill text-primary me-2"></i><strong>Địa chỉ:</strong> 123 Đường Đồng Hồ, Quận 1, TP.HCM</li>
                    </ul>

                    <hr class="my-3">

                    <h6 class="fw-semibold mb-2 text-uppercase">Tài Liệu Liên Quan</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-dark d-block py-1 hover-text-primary">› Chính sách đổi trả</a></li>
                        <li><a href="#" class="text-decoration-none text-dark d-block py-1 hover-text-primary">› Chính sách vận chuyển</a></li>
                        <li><a href="#" class="text-decoration-none text-dark d-block py-1 hover-text-primary">› Quy định thanh toán</a></li>
                    </ul>
                </div>
            </div>
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
        h2, h5, h6 {
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
        .hover-text-primary:hover {
            color: #007bff !important;
        }
        .spacer {
            background-color: #fff;
        }
        .shadow-sm {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <section class="policy-section container py-5 px-5">
        <div class="row g-4">
          <!-- Nội dung chính -->
          <div class="col-lg-8">
            <div class="mb-5">
              <h2 class="fw-bold mb-3">1. Chính Sách Bảo Mật</h2>
              <p>Chúng tôi cam kết bảo vệ thông tin cá nhân của khách hàng. Mọi thông tin thu thập được chỉ dùng để xử lý đơn hàng và nâng cao dịch vụ khách hàng.</p>
              <ul class="list-unstyled ps-3">
                <li class="mb-2">• Không chia sẻ thông tin cá nhân cho bên thứ ba nếu không có sự đồng ý.</li>
                <li class="mb-2">• Thông tin thẻ thanh toán được bảo mật theo tiêu chuẩn PCI DSS.</li>
                <li>• Khách hàng có quyền yêu cầu chỉnh sửa hoặc xóa thông tin cá nhân.</li>
              </ul>
            </div>
      
            <div class="mb-5">
              <h2 class="fw-bold mb-3">2. Điều Khoản Sử Dụng</h2>
              <p>Bằng cách sử dụng website của chúng tôi, bạn đồng ý tuân thủ các điều khoản dưới đây:</p>
              <ul class="list-unstyled ps-3">
                <li class="mb-2">• Không sử dụng website cho mục đích trái pháp luật.</li>
                <li class="mb-2">• Không sao chép, phát tán nội dung mà không có sự cho phép.</li>
                <li>• Chúng tôi có quyền thay đổi nội dung trang web mà không cần báo trước.</li>
              </ul>
            </div>
      
            <div class="mb-5">
              <h2 class="fw-bold mb-3">3. Chính Sách Bảo Hành</h2>
              <p>Mỗi sản phẩm đồng hồ chính hãng được bán ra đều đi kèm chính sách bảo hành rõ ràng:</p>
              <ul class="list-unstyled ps-3">
                <li class="mb-2">• Bảo hành 12 tháng cho tất cả sản phẩm có lỗi kỹ thuật từ nhà sản xuất.</li>
                <li>• Không áp dụng bảo hành với lỗi do người dùng gây ra như rơi vỡ, vào nước quá mức cho phép, tự ý tháo lắp.</li>
              </ul>
            </div>
      
            <div>
              <h2 class="fw-bold mb-3">4. Trách Nhiệm Pháp Lý</h2>
              <p>Chúng tôi không chịu trách nhiệm với các thiệt hại phát sinh do khách hàng sử dụng sản phẩm sai mục đích hoặc không tuân theo hướng dẫn sử dụng.</p>
            </div>
          </div>
      
          <!-- Sidebar -->
          <div class="col-lg-4">
            <div class="bg-white border rounded p-4 shadow-sm">
              <h5 class="fw-bold mb-3">Liên hệ pháp lý</h5>
              <p class="mb-1"><i class="bi bi-telephone-fill me-2 text-primary"></i><strong>Hotline:</strong> 0123 456 789</p>
              <p class="mb-1"><i class="bi bi-envelope-fill me-2 text-primary"></i><strong>Email:</strong> support@eterna.vn</p>
              <p class="mb-1"><i class="bi bi-geo-alt-fill me-2 text-primary"></i><strong>Địa chỉ:</strong> 123 Đường Đồng Hồ, Quận 1, TP.HCM</p>
      
              <hr class="my-3">
      
              <h6 class="fw-bold mb-2">Tài liệu liên quan:</h6>
              <ul class="list-unstyled">
                <li><a href="#" class="text-decoration-none text-dark d-block py-1">› Chính sách đổi trả</a></li>
                <li><a href="#" class="text-decoration-none text-dark d-block py-1">› Chính sách vận chuyển</a></li>
                <li><a href="#" class="text-decoration-none text-dark d-block py-1">› Quy định thanh toán</a></li>
              </ul>
            </div>
          </div>
        </div>
      </section>
      
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
@endsection
@section('script')
   
@endsection
@section('style')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

@endsection

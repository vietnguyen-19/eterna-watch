@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-4"></div>
    <main style="padding-top: 90px;">
        <div class="mb-2 pb-2"></div>
        <section class="my-account container py-5">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <nav class="nav flex-column  account-sidebar sticky-sidebar">
                        <a href="{{ route('account.dashboard') }}" class="nav-link text-dark fw-semibold active">Bảng điều
                            khiển</a>
                        <a href="{{ route('account.order') }}" class="nav-link text-dark">Đơn hàng</a>
                        <a href="{{ route('account.address') }}" class="nav-link text-dark">Địa chỉ</a>
                        <a href="{{ route('account.detail') }}" class="nav-link text-dark">Chi tiết tài khoản</a>
                        <a href="{{ route('account.wishlist') }}" class="nav-link text-dark">Danh sách yêu thích</a>

                        <form action="{{ route('client.logout') }}" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="nav-link fw-semibold text-danger logout-btn">Đăng xuất</button>
                        </form>
                    </nav>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="content-box p-4">
                        <p class="mb-2 text-muted">Xin chào, <strong class="text-dark">{{ Auth::user()->name }}</strong>!
                        </p>
                        <p class="text-muted">Từ bảng điều khiển tài khoản, bạn có thể:</p>
                        <ul class="list-unstyled">
                            <li><a class="text-primary fw-semibold link-hover" href="{{ route('account.order') }}">Xem đơn
                                    hàng gần đây</a></li>
                            <li><a class="text-primary fw-semibold link-hover" href="{{ route('account.address') }}">Quản lý
                                    địa chỉ giao hàng & thanh toán</a></li>
                            <li><a class="text-primary fw-semibold link-hover" href="{{ route('account.detail') }}">Chỉnh
                                    sửa thông tin tài khoản</a></li>
                        </ul>
                        
                    </div>
                </div>
            </div>
        </section>
    </main>



    <div class="mb-5 pb-xl-5"></div>
@endsection

@section('style')
<style>
    .nav-link {
        font-size: 16px;
        padding: 12px 16px;
        transition: background-color 0.3s ease, padding-left 0.3s ease;
        background: rgb(255, 243, 243);
    }

    .nav-link:hover {
        background: #f0f0f0;
        padding-left: 20px;
    }

    .nav-link.active {
        background: hsl(0, 87%, 94%);
        font-weight: bold;
        color: #d3401f !important;
        border-left: 3px solid #fda3a3;
    }

    /* Hiệu ứng hover cho các liên kết */
    .link-hover {
        transition: color 0.3s ease-in-out;
    }

    .link-hover:hover {
        color: #0d47a1 !important;
        text-decoration: underline;
    }

    /* Bố cục nội dung đẹp hơn */
    .content-box {
        background: white;
        border-radius: 8px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .logout-btn {
        background: none;
        border: none;
        text-align: left;
        width: 100%;
        padding: 12px 16px;
        transition: background-color 0.3s, padding-left 0.3s;
        font-size: 16px;
        color: #c61a18 !important;
        background: rgb(255, 243, 243);
    }

    .logout-btn:hover {
        background: #f5f5f5;
        padding-left: 18px;
    }

    /* Responsive tối ưu */
    @media (max-width: 768px) {
        .container {
            max-width: 100%;
        }

        .nav {
            border-bottom: 1px solid #ddd;
        }

        .content-box {
            margin-top: 20px;
        }
    }
</style>
@endsection

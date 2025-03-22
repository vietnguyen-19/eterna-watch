@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <main style="padding-top: 90px;">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container py-5">
            <div class="row">
                <div class="col-lg-3">
                    <div class="user-info mb-3"
                        style="display: flex; align-items: center; padding: 15px; border-bottom: 1px solid #eee; background-color: #f8f9fa; border-radius: 5px 5px 0 0; width: 100%; box-sizing: border-box;">
                        <div class="avatar" style="width: 88px; height: 88px; margin-right: 15px;">
                            <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar"
                                style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                        </div>
                        <div class="user-details">
                            <strong>{{ auth()->user()->name }}</strong> <br>
                            <small>{{ auth()->user()->email }}</small>
                        </div>
                    </div>
                    <nav class="nav flex-column account-sidebar sticky-sidebar">
                        <a href="{{ route('account.order') }}" class="nav-link active">
                            <i class="fas fa-shopping-bag me-2"></i> Đơn hàng
                        </a>
                        <a href="{{ route('account.re_password') }}" class="nav-link">
                            <i class="fas fa-key me-2"></i> Cập nhật mật khẩu
                        </a>
                        <a href="{{ route('account.edit') }}" class="nav-link">
                            <i class="fas fa-user me-2"></i> Chi tiết tài khoản
                        </a>
                        <form action="{{ route('client.logout') }}" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="nav-link text-danger logout-btn">
                                <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                            </button>
                        </form>
                    </nav>
                </div>
                <div class="col-lg-9">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold text-primary">Thông Tin Tài Khoản</h5>
                                <a href="{{route('account.edit')}}" class="btn btn-outline-primary btn-sm">Chỉnh sửa</a>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><strong>Họ tên:</strong> {{ Auth::user()->name }}</p>
                                <p class="mb-1"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                                <p class="mb-1"><strong>Số điện thoại:</strong> {{ Auth::user()->phone }}</p>
                                <p class="mb-1"><strong>Giới tính:</strong>
                                    {{ Auth::user()->gender == 1 ? 'Nam' : 'Nữ' }}</p>
                            </div>
                            @if (Auth::user()->defaultAddress)
                                <div class="border-top pt-3">
                                    <h6 class="text-secondary fw-bold">Địa chỉ mặc định</h6>
                                    <p class="mb-1"><strong>Địa chỉ:</strong>
                                        {{ Auth::user()->defaultAddress->street_address }},
                                        {{ Auth::user()->defaultAddress->district }}</p>
                                    <p class="mb-1"><strong>Thành phố:</strong> {{ Auth::user()->defaultAddress->city }},
                                        {{ Auth::user()->defaultAddress->country }}</p>
                                </div>
                            @else
                                <p class="text-muted">Chưa cập nhật địa chỉ</p>
                            @endif
                        </div>
                    </div>
                </div>

        </section>
    </main>


    <div class="mb-5 pb-xl-5"></div>
@endsection
@section('script')
@endsection
@section('style')
    <style>
        /* Sidebar */
        .account-sidebar .nav-link {
            font-size: 16px;
            padding: 12px 18px;
            border-radius: 3px;
            background: #fdfdfd;
            transition: all 0.3s ease-in-out;
            display: flex;
            align-items: center;
            color: #333;
            font-weight: 500;
        }

        .account-sidebar .nav-link i {
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .account-sidebar .nav-link:hover {
            background: #ececec;
            padding-left: 22px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .account-sidebar .nav-link.active {
            background: #e84040;
            color: #ffffff;
            font-weight: bold;
        }

        /* Hiệu ứng hover cho liên kết */
        .link-hover {
            transition: color 0.3s ease-in-out;
        }

        .link-hover:hover {
            color: #0d47a1 !important;
            text-decoration: underline;
        }

        /* Nội dung chính */
        .content-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 24px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .logout-btn {
            background: none;
            border: none;
            text-align: left;
            width: 100%;
            padding: 12px 18px;
            transition: background-color 0.3s, padding-left 0.3s;
            font-size: 16px;
            color: #d3401f !important;
            font-weight: bold;
        }

        .logout-btn:hover {
            background: #fff5f5;
            padding-left: 22px;
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

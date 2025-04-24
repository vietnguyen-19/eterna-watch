@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <main style="padding-top: 90px;">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container py-5">
            <div class="row">
                <div class="col-lg-3">
                    <div class="user-info mb-3"
                        style="display: flex; justify-content: center; padding: 15px; border-bottom: 1px solid #eee; background-color: #f8f9fa; border-radius: 5px 5px 0 0; width: 100%; box-sizing: border-box;">
                        <div class="d-flex flex-column align-items-center text-center p-3">
                            {{-- Avatar có viền --}}
                            <div class="avatar"
                                style="width: 200px; height: 200px; overflow: hidden; border-radius: 50%; border: 6px solid #dee2e6; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : asset('images/default-avatar.png') }}"
                                    alt="Avatar"
                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            </div>

                            {{-- Thông tin căn giữa dưới avatar --}}
                            <h5 class="mt-3 mb-1" style="font-weight: bold;">{{ auth()->user()->name }}</h5>
                            <p class="text-muted" style="margin: 0;">{{ auth()->user()->email }}</p>
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
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold text-primary">Thông Tin Tài Khoản</h5>
                                <a href="{{ route('account.edit') }}" class="btn btn-outline-primary btn-sm">Chỉnh sửa</a>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><strong>Họ tên:</strong> {{ auth()->user()->name }}</p>
                                <p class="mb-1"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                                <p class="mb-1"><strong>Số điện thoại:</strong> {{ auth()->user()->phone }}</p>
                                @php
                                    $gioiTinh = match (auth()->user()->gender) {
                                        1 => 'Nam',
                                        0 => 'Nữ',
                                        default => 'Không xác định',
                                    };
                                @endphp
                                <p class="mb-1"><strong>Giới tính:</strong> {{ $gioiTinh }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-secondary fw-bold mb-2">Địa chỉ mặc định</h6>
                            @if (auth()->user()->defaultAddress)
                                <p class="mb-1"><strong>Địa chỉ:</strong>
                                    {{ auth()->user()->defaultAddress->street_address }},
                                    {{ auth()->user()->defaultAddress->district }}
                                </p>
                                <p class="mb-1"><strong>Thành phố:</strong>
                                    {{ auth()->user()->defaultAddress->city }},
                                    {{ auth()->user()->defaultAddress->country }}
                                </p>
                            @else
                                <p class="text-muted mb-0">Chưa cập nhật địa chỉ</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div> <!-- 🔧 Thêm dòng này để đóng .row -->
        </section>
    </main>
    <div class="mb-5 pb-xl-5"></div>
@endsection

@section('script')
@endsection

@section('style')
    <style>
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

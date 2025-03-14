@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <main style="padding-top: 90px;">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container py-5">
          <div class="row">
            <div class="col-lg-3">
              <nav class="nav flex-column border-end pe-3">
                  <a href="{{ route('account.dashboard') }}" class="nav-link text-dark fw-semibold">Bảng điều
                      khiển</a>
                  <a href="{{ route('account.order') }}" class="nav-link text-dark">Đơn hàng</a>
                  <a href="{{ route('account.address') }}" class="nav-link text-dark">Địa chỉ</a>
                  <a href="{{ route('account.detail') }}" class="nav-link text-dark active">Chi tiết tài khoản</a>
                  <a href="{{ route('account.wishlist') }}" class="nav-link text-dark">Danh sách yêu thích</a>

                  <form action="{{ route('client.logout') }}" method="POST" class="w-100">
                      @csrf
                      <button type="submit" class="nav-link fw-semibold text-danger logout-btn">Đăng xuất</button>
                  </form>
              </nav>
          </div>
            <div class="col-lg-9">
              <div class="">
                <div class="my-account__edit-form">
                  <form name="account_edit_form" class="needs-validation" novalidate="">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-floating my-3">
                          <input type="text" class="form-control" id="account_first_name" placeholder="First Name" required="">
                          <label for="account_first_name">First Name</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating my-3">
                          <input type="text" class="form-control" id="account_last_name" placeholder="Last Name" required="">
                          <label for="account_last_name">Last Name</label>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-floating my-3">
                          <input type="text" class="form-control" id="account_display_name" placeholder="Display Name" required="">
                          <label for="account_display_name">Display Name</label>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-floating my-3">
                          <input type="email" class="form-control" id="account_email" placeholder="Email Address" required="">
                          <label for="account_email">Email Address</label>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="my-3">
                          <h5 class="text-uppercase mb-0">Password Change</h5>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-floating my-3">
                          <input type="password" class="form-control" id="account_current_password" placeholder="Current password" required="">
                          <label for="account_current_password">Current password</label>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-floating my-3">
                          <input type="password" class="form-control" id="account_new_password" placeholder="New password" required="">
                          <label for="account_new_password">New password</label>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-floating my-3">
                          <input type="password" class="form-control" data-cf-pwd="#account_new_password" id="account_confirm_password" placeholder="Confirm new password" required="">
                          <label for="account_confirm_password">Confirm new password</label>
                          <div class="invalid-feedback">Passwords did not match!</div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="my-3">
                          <button class="btn btn-primary">Save Changes</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
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
        .nav-link {
            font-size: 16px;
            padding: 12px 16px;
            transition: background-color 0.3s ease, padding-left 0.3s ease;
        }

        .nav-link:hover {
            background: #f0f0f0;
            padding-left: 20px;
        }

        .nav-link.active {
            background: hsl(0, 100%, 96%);
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

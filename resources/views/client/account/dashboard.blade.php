@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <main style="padding-top: 90px;">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Tài Khoản Của Tôi</h2>
            <div class="row">
                <div class="col-lg-3">
                    <ul class="account-nav">
                        <li><a href="{{route('accounts.dashboard')}}" class="menu-link menu-link_us-s menu-link_active">Bảng điều
                                khiển</a></li>
                        <li><a href="{{route('accounts.order')}}" class="menu-link menu-link_us-s">Đơn hàng</a></li>
                        <li><a href="{{route('accounts.address')}}" class="menu-link menu-link_us-s">Địa chỉ</a></li>
                        <li><a href="{{route('accounts.detail')}}" class="menu-link menu-link_us-s">Chi tiết tài khoản</a></li>
                        <li><a href="{{route('accounts.wishlist')}}" class="menu-link menu-link_us-s">Danh sách yêu thích</a></li>
                        <li><a href="" class="menu-link menu-link_us-s">Đăng xuất</a></li>
                    </ul>
                </div>
                <div class="col-lg-9">
                    <div class="page-content my-account__dashboard">
                        <p>Xin chào <strong>alitfn58</strong> (Không phải bạn? <a href="./login_register.html">Đăng
                                xuất</a>)</p>
                        <p>Từ bảng điều khiển tài khoản của bạn, bạn có thể xem <a class="unerline-link"
                                href="./account_orders.html">đơn hàng gần đây</a>, quản lý <a class="unerline-link"
                                href="./account_edit_address.html">địa chỉ giao hàng và thanh toán</a>, và <a
                                class="unerline-link" href="./account_edit.html">chỉnh sửa mật khẩu và thông tin tài
                                khoản.</a>
                        </p>
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
@endsection

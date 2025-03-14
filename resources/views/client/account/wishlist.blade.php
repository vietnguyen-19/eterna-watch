@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-4"></div>
    <main style="padding-top: 90px;">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container py-5">
            <div class="row">
                <div class="col-lg-3">
                    <nav class="nav flex-column  account-sidebar sticky-sidebar">
                        <a href="{{ route('account.dashboard') }}" class="nav-link text-dark fw-semibold ">Bảng điều
                            khiển</a>
                        <a href="{{ route('account.order') }}" class="nav-link text-dark">Đơn hàng</a>
                        <a href="{{ route('account.address') }}" class="nav-link text-dark">Địa chỉ</a>
                        <a href="{{ route('account.detail') }}" class="nav-link text-dark">Chi tiết tài khoản</a>
                        <a href="{{ route('account.wishlist') }}" class="nav-link text-dark active">Danh sách yêu thích</a>

                        <form action="{{ route('client.logout') }}" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="nav-link fw-semibold text-danger logout-btn">Đăng xuất</button>
                        </form>
                    </nav>
                </div>
                <div class="col-lg-9">
                    <div class="shopping-cart">
                        <div class="cart-table__wrapper">
                            <table class="cart-table">
                                <thead>
                                    <tr>
                                        <th class="fw-bold">Sản phẩm</th>
                                        <th></th>
                                        <th class="fw-bold text-center">Giá</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($wishlist as $item)
                                        <tr>
                                            <td>
                                                <div class="shopping-cart__product-item">
                                                    <a href="{{ route('client.shop.show', $item->product->id) }}">
                                                        <img style="border: 1px solid #c4bebe;width:88px"
                                                            src="{{ Storage::url($item->product->avatar ?? 'avatar/default.jpeg') }}"
                                                            alt="">
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="shopping-cart__product-item__detail">
                                                    <h4><a href="{{ route('client.shop.show', $item->product->id) }}">
                                                            <strong>{{ $item->product->name ?? 'Sản phẩm không tồn tại' }}</strong></a>
                                                    </h4>
                                                    <ul class="shopping-cart__product-item__options">
                                                        <li>Danh
                                                            mục:{{ $item->product->category->name ?? 'Không xác định' }}
                                                        </li>
                                                        <li>Thương
                                                            hiệu:{{ $item->product->brand->name ?? 'Không xác định' }}</li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="shopping-cart__product-price">{{ number_format($item->product->price_default, 0, ',', '.') }}đ</span>
                                            </td>

                                            <td>
                                            <td>
                                                <a href="#" class="removed-cart" data-id="{{ $item->product->id }}">
                                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                        <path
                                                            d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                                    </svg>
                                                </a>
                                            </td>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <div class="mb-5 pb-xl-5"></div>
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".removed-cart").forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();

                    let productId = this.getAttribute("data-id");

                    if (confirm(
                            "Bạn có chắc chắn muốn xóa sản phẩm này khỏi danh sách yêu thích?")) {
                        fetch(`/account/wishlist/remove/${productId}`, {
                                method: "DELETE",
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute("content"),
                                    "Content-Type": "application/json",
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert("Đã xóa sản phẩm khỏi danh sách yêu thích!");
                                    location.reload();
                                } else {
                                    alert("Có lỗi xảy ra, vui lòng thử lại.");
                                }
                            });
                    }
                });
            });
        });
    </script>
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

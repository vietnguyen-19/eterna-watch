@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <main>
        <section class="full-width_padding">
            <div class="full-width_border border-2" style="border-color: #f5e6e0;">
                <div class="shop-banner position-relative ">
                    <div class="background-img" style="background-color: #f5e6e0;">
                        <img loading="lazy" src="{{ asset('theme/client/images/shop/shop_banner_2.png') }}" width="1759"
                            height="420" alt="Pattern" class="slideshow-bg__img object-fit-cover">
                    </div>

                    <div class="shop-banner__content container position-absolute start-50 top-50 translate-middle">
                        <h2 class="h1 text-uppercase text-center fw-bold mb-3 mb-xl-4 mb-xl-5">Shoes</h2>
                        <ul class="d-flex justify-content-center flex-wrap list-unstyled text-uppercase h6">
                            <li class="me-3 me-xl-4 pe-1"><a href="#"
                                    class="menu-link menu-link_us-s menu-link_active">StayHome</a></li>
                            <li class="me-3 me-xl-4 pe-1"><a href="#" class="menu-link menu-link_us-s">New In</a></li>
                            <li class="me-3 me-xl-4 pe-1"><a href="#" class="menu-link menu-link_us-s">Jackets</a>
                            </li>
                            <li class="me-3 me-xl-4 pe-1"><a href="#" class="menu-link menu-link_us-s">Hoodies</a>
                            </li>
                            <li class="me-3 me-xl-4 pe-1"><a href="shop4.html" class="menu-link menu-link_us-s">Men</a></li>
                            <li class="me-3 me-xl-4 pe-1"><a href="shop5.html" class="menu-link menu-link_us-s">Women</a>
                            </li>
                            <li class="me-3 me-xl-4 pe-1"><a href="#" class="menu-link menu-link_us-s">Trousers</a>
                            </li>
                            <li class="me-3 me-xl-4 pe-1"><a href="shop3.html"
                                    class="menu-link menu-link_us-s">Accessories</a></li>
                            <li class="me-3 me-xl-4 pe-1"><a href="#" class="menu-link menu-link_us-s">Shoes</a></li>
                        </ul>
                    </div><!-- /.shop-banner__content -->
                </div><!-- /.shop-banner position-relative -->
            </div><!-- /.full-width_border -->
        </section><!-- /.full-width_padding-->

        <div class="mb-4 pb-lg-3"></div>

        <section class="shop-main container d-flex">
            <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
                <div class="aside-header d-flex d-lg-none align-items-center">
                    <h3 class="text-uppercase fs-6 mb-0">Filter By</h3>
                    <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
                </div><!-- /.aside-header -->

                <div class="pt-4 pt-lg-0"></div>
                <div class="search-field__input-wrapper mb-3">
                    <input type="text" name="search_text"
                        class="search-field__input form-control form-control-sm border-light border-2" placeholder="SEARCH">
                </div>
                <div class="pt-4 pt-lg-0"></div>
                <div class="accordion" id="categories-list">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-11">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-1" aria-expanded="true"
                                aria-controls="accordion-filter-1">
                                Danh mục sản phẩm
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-1" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-11" data-bs-parent="#categories-list">
                            <div class="accordion-body px-0 pb-0 pt-3">
                                <ul class="list list-inline mb-0">
                                    @foreach ($categories as $category)
                                        <li class="list-item">
                                            <a href="{{ route('client.shop', ['category' => $category->name]) }}"
                                                class="menu-link py-1">
                                                {{ $category->name }} <span
                                                    class="text-muted">({{ $category->products_count }})</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div><!-- /.accordion-item -->
                </div><!-- /.accordion-item -->

                <div class="accordion" id="categories-list">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-11">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-1" aria-expanded="true"
                                aria-controls="accordion-filter-1">
                                Thương hiệu đồng hồ
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-1" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-11" data-bs-parent="#categories-list">
                            <div class="accordion-body px-0 pb-0 pt-3">
                                <ul class="list list-inline mb-0">
                                    @foreach ($brands as $brand)
                                        <li class="list-item">
                                            <a href="{{ route('client.shop', ['brand' => $brand->name]) }}"
                                                class="menu-link py-1">
                                                {{ $brand->name }} <span
                                                    class="text-muted">({{ $brand->products_count }})</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div><!-- /.accordion-item -->
                </div><!-- /.accordion-item -->

                {{-- <div class="accordion" id="color-filters">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-1">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-2" aria-expanded="true"
                                aria-controls="accordion-filter-2">
                                Color
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-2" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-1" data-bs-parent="#color-filters">
                            <div class="accordion-body px-0 pb-0">
                                <div class="d-flex flex-wrap">
                                    <a href="#" class="swatch-color js-filter" style="color: #0a2472"></a>
                                    <a href="#" class="swatch-color js-filter" style="color: #d7bb4f"></a>
                                    <a href="#" class="swatch-color js-filter" style="color: #282828"></a>
                                    <a href="#" class="swatch-color js-filter" style="color: #b1d6e8"></a>
                                    <a href="#" class="swatch-color js-filter" style="color: #9c7539"></a>
                                    <a href="#" class="swatch-color js-filter" style="color: #d29b48"></a>
                                    <a href="#" class="swatch-color js-filter" style="color: #e6ae95"></a>
                                    <a href="#" class="swatch-color js-filter" style="color: #d76b67"></a>
                                    <a href="#" class="swatch-color swatch_active js-filter"
                                        style="color: #bababa"></a>
                                    <a href="#" class="swatch-color js-filter" style="color: #bfdcc4"></a>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.accordion-item -->
                </div><!-- /.accordion --> --}}


                {{-- <div class="accordion" id="size-filters">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-size">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-size" aria-expanded="true"
                                aria-controls="accordion-filter-size">
                                Sizes
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-size" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-size" data-bs-parent="#size-filters">
                            <div class="accordion-body px-0 pb-0">
                                <div class="d-flex flex-wrap">
                                    <a href="#"
                                        class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">XS</a>
                                    <a href="#"
                                        class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">S</a>
                                    <a href="#"
                                        class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">M</a>
                                    <a href="#"
                                        class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">L</a>
                                    <a href="#"
                                        class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">XL</a>
                                    <a href="#"
                                        class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">XXL</a>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.accordion-item -->
                </div><!-- /.accordion --> --}}



                <form action="{{ route('client.shop.filter') }}" method="GET">
                    <div class="accordion" id="price-filters">
                        <div class="accordion-item mb-4">
                            <h5 class="accordion-header mb-2" id="accordion-heading-price">
                                <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#accordion-filter-price"
                                    aria-expanded="true" aria-controls="accordion-filter-price">
                                    Lọc sản phẩm theo giá trị
                                    <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                            <path
                                                d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                        </g>
                                    </svg>
                                </button>
                            </h5>
                            <div id="accordion-filter-price" class="accordion-collapse collapse show border-0"
                                aria-labelledby="accordion-heading-price" data-bs-parent="#price-filters">
                                <input id="price-min" type="range" class="form-range" name="min_price" min="10000"
                                    max="1000000" step="5000" value="{{ request('min_price', 25000) }}">
                                <p class="text-secondary">Giá tối thiểu: <span
                                        class="fw-bold price-range__min">${{ number_format(request('min_price', 25000)) }}</span>
                                </p>
                                <input id="price-max" type="range" class="form-range" name="max_price" min="10000"
                                    max="1000000" step="5000" value="{{ request('max_price', 450000) }}">
                                <p class="text-secondary">Giá tối đa: <span
                                        class="fw-bold price-range__max">${{ number_format(request('max_price', 450000)) }}</span>
                                </p>

                                <!-- Button lọc -->
                                <button type="submit" class="w-100 btn btn-primary mt-3">Lọc theo giá</button>
                            </div>
                        </div>
                    </div>
                </form>


            </div><!-- /.shop-sidebar -->

            <div class="shop-list flex-grow-1">
                <div class="d-flex justify-content-between mb-4 pb-md-2">
                    <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                        <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
                    </div><!-- /.breadcrumb -->

                    <div
                        class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                        <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0"
                            aria-label="Sort Items" name="total-number">
                            <option selected>Default Sorting</option>
                            <option value="1">Featured</option>
                            <option value="2">Best selling</option>
                            <option value="3">Alphabetically, A-Z</option>
                            <option value="3">Alphabetically, Z-A</option>
                            <option value="3">Price, low to high</option>
                            <option value="3">Price, high to low</option>
                            <option value="3">Date, old to new</option>
                            <option value="3">Date, new to old</option>
                        </select>

                        <div class="shop-asc__seprator mx-3 bg-light d-none d-md-block order-md-0"></div>

                        <div class="col-size align-items-center order-1 d-none d-lg-flex">
                            <span class="text-uppercase fw-medium me-2">View</span>
                            <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid"
                                data-cols="2">2</button>
                            <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid"
                                data-cols="3">3</button>
                            <button class="btn-link fw-medium js-cols-size" data-target="products-grid"
                                data-cols="4">4</button>
                        </div><!-- /.col-size -->

                        <div class="shop-filter d-flex align-items-center order-0 order-md-3 d-lg-none">
                            <button class="btn-link btn-link_f d-flex align-items-center ps-0 js-open-aside"
                                data-aside="shopFilter">
                                <svg class="d-inline-block align-middle me-2" width="14" height="10"
                                    viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_filter" />
                                </svg>
                                <span class="text-uppercase fw-medium d-inline-block align-middle">Filter</span>
                            </button>
                        </div><!-- /.col-size d-flex align-items-center ms-auto ms-md-3 -->
                    </div><!-- /.shop-acs -->
                </div><!-- /.d-flex justify-content-between -->

                <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
                    @foreach ($products as $product)
                        <div class="product-card-wrapper">
                            <div class="product-card product-card_style6 hover-container mb-3">
                                <div class="pc__img-wrapper">
                                    <a href="{{ route('client.shop.show', $product->id) }}">
                                        <img loading="lazy"
                                            src="{{ Storage::url($product->avatar ?? 'avatar/default.jpeg') }}"
                                            width="330" height="400" alt="{{ $product->name }}" class="pc__img">
                                    </a>
                                </div>

                                <div style="border: 1px solid #bebebe" class="pc__info position-relative bg-body">
                                    <div class="position-relative">
                                        <p class="pc__category fs-13">{{ $product->category->name ?? 'Danh mục' }}</p>
                                        <h6 class="pc__title fs-base fw-semi-bold mb-1">
                                            <a
                                                href="{{ route('client.shop.show', $product->id) }}">{{ $product->name }}</a>
                                        </h6>
                                        <div class="product-card__price d-flex mb-1">
                                            <span
                                                class="money price fs-base fw-semi-bold">${{ $product->price_default }}</span>
                                        </div>

                                        <div
                                            class="d-flex align-items-center hover__content position-relative mt-3 mt-sm-0">
                                            <!-- Nút Add to Cart -->
                                            <button class="btn-icon me-auto me-xxl-3 js-add-cart js-open-aside"
                                                data-aside="cartDrawer" title="Add To Cart">
                                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_cart"></use>
                                                </svg>
                                            </button>

                                            <!-- Nút Quick View -->
                                            <button class="btn-icon me-3 me-xxl-3 js-quick-view" data-bs-toggle="modal"
                                                data-bs-target="#quickView" data-id="{{ $product->id }}"
                                                data-name="{{ $product->name }}"
                                                data-price="{{ number_format($product->price_default, 0, ',', '.') }}đ"
                                                data-description="{{ $product->short_description }}"
                                                data-category="{{ $product->category->name ?? 'Danh mục' }}"
                                                data-images="{{ json_encode(
                                                    array_merge(
                                                        [Storage::url($product->avatar ?? 'avatar/default.jpeg')], // Ảnh sản phẩm chính
                                                        $product->variants->pluck('image')->map(fn($img) => Storage::url($img))->toArray(), // Ảnh biến thể
                                                    ),
                                                ) }}"
                                                title="Quick View">
                                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_view"></use>
                                                </svg>
                                            </button>


                                            <!-- Nút Wishlist -->
                                            <button class="btn-icon js-add-wishlist" title="Add To Wishlist">
                                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_heart"></use>
                                                </svg>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Hiển thị phân trang -->
                <div class="justify-content-center mt-4">
                    {{ $products->links() }}
                </div>


            </div>
        </section><!-- /.shop-main container -->
    </main>
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let minPriceInput = document.getElementById("price-min");
            let maxPriceInput = document.getElementById("price-max");
            let minPriceDisplay = document.querySelector(".price-range__min");
            let maxPriceDisplay = document.querySelector(".price-range__max");

            // Hàm cập nhật giá khi kéo thanh trượt
            function updatePriceDisplay() {
                minPriceDisplay.textContent = formatCurrency(minPriceInput.value);
                maxPriceDisplay.textContent = formatCurrency(maxPriceInput.value);
            }

            // Hàm định dạng số thành tiền tệ
            function formatCurrency(value) {
                return new Intl.NumberFormat("vi-VN", {
                    style: "currency",
                    currency: "VND"
                }).format(value);
            }

            // Gán sự kiện khi thay đổi giá trị
            minPriceInput.addEventListener("input", updatePriceDisplay);
            maxPriceInput.addEventListener("input", updatePriceDisplay);

            // Cập nhật giá ban đầu khi tải trang
            updatePriceDisplay();
        });
    </script>
@endsection
@section('style')
    <style>
        .btn-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #f1f1f1;
            border: none;
            transition: all 0.3s ease-in-out;
        }

        .btn-icon svg {
            width: 20px;
            height: 20px;
            fill: #333;
            transition: fill 0.3s ease-in-out;
        }

        /* Hiệu ứng hover */
        .btn-icon:hover {
            background-color: #1c1c1c;
            color: #fff;
        }

        .js-add-wishlist:hover {
            background-color: #a81717;
            color: #fff;
        }

        .btn-icon:hover svg {
            fill: #000;
        }
    </style>
@endsection

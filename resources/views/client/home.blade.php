@extends('client.layouts.master')
@section('content')
    <main>

        <section class="position-relative">
            <div class="slideshow-bg position-absolute left-0 top-0 w-100">
                <img loading="lazy" src="{{ asset('theme/client/images/home/demo19/slider_bg_1.jpg') }}" width="1920"
                    height="1260" alt="Pattern" class="slideshow-bg__img object-fit-cover">
            </div>
            <div class="content container mb-0 position-relative pt-3 pt-xl-5">
                <div class="pt-3 pb-3 pt-xl-5 pb-xl-5 mt-3 mt-xl-5"></div>
                <div class="pt-3 pb-3 pt-xl-5 pb-xl-5 mt-3 mt-xl-5"></div>
                <h2 class="text-uppercase h1 fw-semi-bold text-center text-white lh-1 mb-4">Bộ Sưu Tập Đồng Hồ Mới<br>2025
                </h2>
                <div class="d-flex align-items-center text-center justify-content-center">
                    <a href="shop1.html" class="btn btn-outline-primary border-0 fs-13 fw-semi-bold text-uppercase">
                        Mua Ngay
                    </a>
                </div>

                <div class="pt-3 pb-3 pt-xl-5 pb-xl-5 mt-xl-4"></div>
                <div class="position-relative">
                    <div class="swiper-container js-swiper-slider"
                        data-settings='{
          "autoplay": {
            "delay": 5000
          },
          "slidesPerView": 6,
          "slidesPerGroup": 1,
          "effect": "none",
          "loop": true,
          "breakpoints": {
            "320": {
              "slidesPerView": 2,
              "slidesPerGroup": 2,
              "spaceBetween": 15
            },
            "768": {
              "slidesPerView": 3,
              "slidesPerGroup": 1,
              "spaceBetween": 24
            },
            "1200": {
              "slidesPerView": 4,
              "slidesPerGroup": 1,
              "spaceBetween": 30,
              "pagination": false
            }
          }
        }'>
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img loading="lazy" class="w-100 h-auto mb-3 d-block"
                                    src="{{ asset('theme/client/images/home/demo19/category-1.jpg') }}" width="330"
                                    height="400" alt="">
                                <div class="text-center">
                                    <a href="shop1.html"
                                        class="menu-link menu-link_us-s fw-semi-bold fs-18 text-white text-uppercase d-inline-block">
                                        Bộ Sưu Tập Cổ Điển
                                    </a>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <img loading="lazy" class="w-100 h-auto mb-3 d-block"
                                    src="{{ asset('theme/client/images/home/demo19/category-2.jpg') }}" width="330"
                                    height="400" alt="">
                                <div class="text-center">
                                    <a href="shop1.html"
                                        class="menu-link menu-link_us-s fw-semi-bold fs-18 text-white text-uppercase d-inline-block">
                                        Bộ Sưu Tập Vàng
                                    </a>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <img loading="lazy" class="w-100 h-auto mb-3 d-block"
                                    src="{{ asset('theme/client/images/home/demo19/category-2.jpg') }}" width="330"
                                    height="400" alt="">
                                <div class="text-center">
                                    <a href="shop1.html"
                                        class="menu-link menu-link_us-s fw-semi-bold fs-18 text-white text-uppercase d-inline-block">
                                        Bộ Sưu Tập Thể Thao
                                    </a>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <img loading="lazy" class="w-100 h-auto mb-3 d-block"
                                    src="{{ asset('theme/client/images/home/demo19/category-4.jpg') }}" width="330"
                                    height="400" alt="">
                                <div class="text-center">
                                    <a href="shop1.html"
                                        class="menu-link menu-link_us-s fw-semi-bold fs-18 text-white text-uppercase d-inline-block">
                                        Bộ Sưu Tập Di Sản
                                    </a>
                                </div>
                            </div>
                        </div><!-- /.swiper-wrapper -->

                    </div><!-- /.swiper-container js-swiper-slider -->
                </div><!-- /.position-relative -->
                <div class="pt-3 pb-3 pt-xl-5"></div>
            </div>
        </section>

        <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>

        <section class="products-grid container">
            <h2 class="section-title text-uppercase fs-30 fw-semi-bold text-center mb-2">SẢN PHẨM BÁN CHẠY NHẤT</h2>
            <p class="fs-13 mb-3 pb-2 pb-xl-3 text-secondary text-center">Các thương hiệu cao cấp hàng đầu thế giới tại một
                điểm đến.</p>


            <div class="row">
                @foreach ($bestSellingProducts as $product)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
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
                                                data-bs-target="#quickView" title="Quick View">
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
                    </div>
                @endforeach
            </div>
        </section>

        <div class="mb-3 mb-xl-4 pt-xl-1 pb-4"></div>

        <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>

        <section class="image-banner">
            <div class="background-img"
                style="background-image: url('{{ asset('theme/client/images/home/demo19/banner-2.jpg') }}'); background-position: center center;">
            </div>
            <div class="image-banner__content container py-3">
                <h2 class="text-white h1 fw-semi-bold mb-3 mb-xl-4">SẢN PHẨM MỚI</h2>
                <a href="shop1.html"
                    class="btn btn-outline-primary border-0 fs-13 text-uppercase fw-semi-bold btn-50 d-inline-flex align-items-center justify-content-center">
                    <span>Mua Ngay</span>
                </a>
            </div>
        </section>


        <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>

        <section class="product-carousel container">
            <h2 class="section-title text-uppercase fs-30 fw-semi-bold text-center mb-2">XU HƯỚNG</h2>
            <p class="fs-13 mb-3 pb-2 pb-xl-3 text-secondary text-center">
                Những thương hiệu cao cấp hàng đầu thế giới tại một điểm đến.
            </p>

            <div id="product_trending" class="position-relative">
                <div class="swiper-container js-swiper-slider"
                    data-settings='{
        "autoplay": {
          "delay": 5000
        },
        "slidesPerView": 4,
        "slidesPerGroup": 4,
        "effect": "none",
        "loop": false,
        "scrollbar": {
          "el": "#product_trending .products-carousel__scrollbar",
          "draggable": true
        },
        "breakpoints": {
          "320": {
            "slidesPerView": 2,
            "slidesPerGroup": 2,
            "spaceBetween": 14
          },
          "768": {
            "slidesPerView": 3,
            "slidesPerGroup": 3,
            "spaceBetween": 24
          },
          "992": {
            "slidesPerView": 4,
            "slidesPerGroup": 1,
            "spaceBetween": 30,
            "pagination": false
          }
        }
      }'>
                    <div class="swiper-wrapper">
                        @foreach ($trendingProducts as $product)
                            <div class="swiper-slide product-card product-card_style6 hover-container">
                                <div class="pc__img-wrapper">
                                    <a href="{{ route('client.shop.show', $product->id) }}">
                                        <img loading="lazy"
                                            src="{{ Storage::url($product->avatar ?? 'avatar/default.jpeg') }}"
                                            width="330" height="400" alt="{{ $product->name }}" class="pc__img">
                                    </a>
                                </div>

                                <div style="border: 1px solid #bebebe" class="pc__info position-relative bg-body">
                                    <div class="position-relative">
                                        <p class="pc__category fs-13">{{ $product->category->name ?? 'Danh mục' }}
                                        </p>
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
                                                data-bs-target="#quickView" title="Quick View">
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
                        @endforeach


                    </div><!-- /.swiper-wrapper -->
                </div><!-- /.swiper-container js-swiper-slider -->

                <!-- scrollbar -->
                <div class="products-carousel__scrollbar swiper-scrollbar"></div>
            </div><!-- /.position-relative -->
        </section>

        <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>

        <section class="blog-carousel container">
            <h2 class="section-title text-uppercase fs-30 fw-semi-bold text-center mb-2">Tin Tức Mới Nhất</h2>
            <p class="fs-13 mb-3 pb-2 pb-xl-3 text-secondary text-center">
                Những Thương Hiệu Cao Cấp Hàng Đầu Thế Giới Tại Một Điểm Đến.
            </p>

            <div class="position-relative">
                <div class="swiper-container js-swiper-slider"
                    data-settings='{
        "autoplay": {
          "delay": 5000
        },
        "slidesPerView": 3,
        "slidesPerGroup": 3,
        "effect": "none",
        "loop": true,
        "pagination": false,
        "breakpoints": {
          "320": {
            "slidesPerView": 1,
            "slidesPerGroup": 1,
            "spaceBetween": 14
          },
          "768": {
            "slidesPerView": 2,
            "slidesPerGroup": 2,
            "spaceBetween": 24
          },
          "992": {
            "slidesPerView": 3,
            "slidesPerGroup": 1,
            "spaceBetween": 30
          },
          "992": {
            "slidesPerView": 4,
            "slidesPerGroup": 1,
            "spaceBetween": 30
          }
        }
      }'>
                    <div class="swiper-wrapper blog-grid row-cols-xl-3">
                        <div class="swiper-slide blog-grid__item mb-4">
                            <div class="blog-grid__item-image">
                                <img loading="lazy" class="h-auto"
                                    src="{{ asset('theme/client/images/home/demo19/blog-1.jpg') }}" width="331"
                                    height="300" alt="">
                            </div>
                            <div class="blog-grid__item-detail">
                                <div class="blog-grid__item-meta text-lowercase">
                                    <span class="blog-grid__item-meta__author">By Admin</span>
                                    <span class="blog-grid__item-meta__date">Aprial 05, 2023</span>
                                </div>
                                <div class="blog-grid__item-title mb-2">
                                    <a href="blog_single.html" class="fs-15 text-uppercase fw-semi-bold">Woman with
                                        good shoes is never be ugly place</a>
                                </div>
                                <div class="blog-grid__item-content mb-2">
                                    <p class="text-secondary">Est Diam Debitis An, Error Recusabo Id Pro, Quo Eripuit
                                        Civibus Ut.</p>
                                    <a href="blog_single.html"
                                        class="btn-link btn-link_md default-underline fs-13 text-uppercase fw-semi-bold">Read
                                        More</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide blog-grid__item mb-4">
                            <div class="blog-grid__item-image">
                                <img loading="lazy" class="h-auto"
                                    src="{{ asset('theme/client/images/home/demo19/blog-2.jpg') }}" width="331"
                                    height="300" alt="">
                            </div>
                            <div class="blog-grid__item-detail">
                                <div class="blog-grid__item-meta text-lowercase">
                                    <span class="blog-grid__item-meta__author">By Admin</span>
                                    <span class="blog-grid__item-meta__date">Aprial 05, 2023</span>
                                </div>
                                <div class="blog-grid__item-title mb-2">
                                    <a href="blog_single.html" class="fs-15 text-uppercase fw-semi-bold">Woman with
                                        good shoes is never be ugly place</a>
                                </div>
                                <div class="blog-grid__item-content mb-2">
                                    <p class="text-secondary">Est Diam Debitis An, Error Recusabo Id Pro, Quo Eripuit
                                        Civibus Ut.</p>
                                    <a href="blog_single.html"
                                        class="btn-link btn-link_md default-underline fs-13 text-uppercase fw-semi-bold">Read
                                        More</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide blog-grid__item mb-4">
                            <div class="blog-grid__item-image">
                                <img loading="lazy" class="h-auto"
                                    src="{{ asset('theme/client/images/home/demo19/blog-3.jpg') }}" width="331"
                                    height="300" alt="">
                            </div>
                            <div class="blog-grid__item-detail">
                                <div class="blog-grid__item-meta text-lowercase">
                                    <span class="blog-grid__item-meta__author">By Admin</span>
                                    <span class="blog-grid__item-meta__date">Aprial 05, 2023</span>
                                </div>
                                <div class="blog-grid__item-title mb-2">
                                    <a href="blog_single.html" class="fs-15 text-uppercase fw-semi-bold">Woman with
                                        good shoes is never be ugly place</a>
                                </div>
                                <div class="blog-grid__item-content mb-2">
                                    <p class="text-secondary">Est Diam Debitis An, Error Recusabo Id Pro, Quo Eripuit
                                        Civibus Ut.</p>
                                    <a href="blog_single.html"
                                        class="btn-link btn-link_md default-underline fs-13 text-uppercase fw-semi-bold">Read
                                        More</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide blog-grid__item mb-4">
                            <div class="blog-grid__item-image">
                                <img loading="lazy" class="h-auto"
                                    src="{{ asset('theme/client/images/home/demo19/blog-4.jpg') }}" width="331"
                                    height="300" alt="">
                            </div>
                            <div class="blog-grid__item-detail">
                                <div class="blog-grid__item-meta text-lowercase">
                                    <span class="blog-grid__item-meta__author">By Admin</span>
                                    <span class="blog-grid__item-meta__date">Aprial 05, 2023</span>
                                </div>
                                <div class="blog-grid__item-title mb-2">
                                    <a href="blog_single.html" class="fs-15 text-uppercase fw-semi-bold">Woman with
                                        good shoes is never be ugly place</a>
                                </div>
                                <div class="blog-grid__item-content mb-2">
                                    <p class="text-secondary">Est Diam Debitis An, Error Recusabo Id Pro, Quo Eripuit
                                        Civibus Ut.</p>
                                    <a href="blog_single.html"
                                        class="btn-link btn-link_md default-underline fs-13 text-uppercase fw-semi-bold">Read
                                        More</a>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.swiper-wrapper -->
                </div><!-- /.swiper-container js-swiper-slider -->
            </div><!-- /.position-relative -->
        </section>

        <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    </main>
@endsection

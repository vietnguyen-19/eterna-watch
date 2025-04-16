@extends('client.layouts.master')
@section('content')
    <main>

        <section class="position-relative">
            <div class="slideshow-bg position-absolute left-0 top-0 w-100">
                <img loading="lazy" src="{{ Storage::url($banners['home_start']->image ?? 'banners/home_bg.jpg') }}" width="1920"
                    height="1260" alt="Pattern" class="slideshow-bg__img object-fit-cover">

            </div>
            <div class="content container mb-0 position-relative pt-3 pt-xl-5">
                <div class="pt-3 pb-3 pt-xl-5 pb-xl-5 mt-3 mt-xl-5"></div>
                <div class="pt-3 pb-3 pt-xl-5 pb-xl-5 mt-3 mt-xl-5"></div>
                <h2 class="text-uppercase h1 fw-semi-bold text-center text-white lh-1 mb-4">{{  $banners['home_start']->title ?? '' }}
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
                            @foreach ($categories as $index => $item)
                                <div class="swiper-slide">
                                    <a href="{{ route('client.shop', ['category_id' => $item->id]) }}">
                                        <img loading="lazy" class="w-100 h-auto mb-3 d-block"
                                            src="{{ asset('storage/cate/cate' . ($index + 1) . '.jpg') }}" width="330"
                                            height="400" alt=""></a>
                                    <div class="text-center">
                                        <a href="{{ route('client.shop', ['category_id' => $item->id]) }}"
                                            class="menu-link menu-link_us-s fw-semi-bold fs-18 text-white text-uppercase d-inline-block">
                                            {{ $item->name }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
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
                                        <div style="color: rgb(188, 0, 0); "
                                            class="product-card__price d-flex mb-1 fw-bold">
                                            @if ($product->min_price == $product->max_price)
                                                {{ number_format($product->min_price, 0, ',', '.') }} VND
                                            @else
                                                {{ number_format($product->min_price, 0, ',', '.') }} -
                                                {{ number_format($product->max_price, 0, ',', '.') }} VND
                                            @endif
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
                style="background-image: url('{{ Storage::url($banners['home_new_product']->image ?? 'banners/new_watches.jpg') }}'); background-position: center center;">
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
                                        <div style="color: rgb(188, 0, 0); "
                                            class="product-card__price d-flex mb-1 fw-bold">
                                            @if ($product->min_price == $product->max_price)
                                                {{ number_format($product->min_price, 0, ',', '.') }} VND
                                            @else
                                                {{ number_format($product->min_price, 0, ',', '.') }} -
                                                {{ number_format($product->max_price, 0, ',', '.') }} VND
                                            @endif
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
                        @foreach ($posts as $post)
                            <div class="swiper-slide blog-grid__item mb-4">
                                <div class="blog-card">
                                    <div class="blog-card__image">
                                        <img loading="lazy"
                                            src="{{ Storage::url($post->image ?? 'avatar/default.jpeg') }}"
                                            alt="{{ $post->title }}">
                                    </div>
                                    <div class="blog-card__content">
                                        <div class="blog-card__meta">
                                            <span class="blog-card__author">Tác giả:
                                                {{ $post->user->name ?? 'Quản trị viên' }}</span>
                                            <span class="blog-card__date">{{ $post->created_at->format('d/m/Y') }}</span>
                                        </div>
                                        <h3 class="blog-card__title">
                                            <a
                                                href="{{ route('client.blog.detail', $post->id) }}">{{ $post->title }}</a>
                                        </h3>
                                        <p class="blog-card__excerpt">{{ Str::limit($post->content, 100) }}</p>
                                        <a href="{{ route('client.blog.detail', $post->id) }}"
                                            class="blog-card__read-more">Xem thêm</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div><!-- /.swiper-wrapper -->
                </div><!-- /.swiper-container js-swiper-slider -->
            </div><!-- /.position-relative -->
        </section>

        <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    </main>
@endsection
@section('style')
    <style>
        .blog-card {
            background: #fff;
            border-radius: 4px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s;
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .blog-card__image img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
        }

        .blog-card__content {
            padding: 15px;
        }

        .blog-card__meta {
            font-size: 14px;
            color: #777;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }

        .blog-card__title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .blog-card__title a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s;
        }

        .blog-card__title a:hover {
            color: #e20000;
        }

        .blog-card__excerpt {
            font-size: 15px;
            color: #555;
            margin-bottom: 15px;
        }

        .blog-card__read-more {
            font-size: 14px;
            color: #e20000;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .blog-card__read-more:hover {
            color: #e20000;
        }

        <style>

        /* Fix chiều cao cho section */
        section.position-relative {
            height: 100vh;
            min-height: 800px;
            overflow: hidden;
        }

        /* Đảm bảo ảnh nền phủ kín */
        .slideshow-bg__img {
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
        }
    </style>
    </style>

@endsection

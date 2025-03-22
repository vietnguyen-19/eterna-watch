@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <main>
        <section class="shop-main container d-flex">
            <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
                <div class="aside-header d-flex d-lg-none align-items-center">
                    <h3 class="text-uppercase fs-6 mb-0">Filter By</h3>
                    <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
                </div><!-- /.aside-header -->

                <div class="pt-4 pt-lg-0"></div>

                <div class="accordion" id="categories-list">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-11">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-1" aria-expanded="true"
                                aria-controls="accordion-filter-1">
                                Danh mục
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
                                            <a href="{{ route('client.blog', ['category' => $category->name]) }}"
                                                class="menu-link py-1">
                                                {{ $category->name }} <span
                                                    class="text-muted">({{ $category->posts_count }})</span>
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
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-2" aria-expanded="true"
                                aria-controls="accordion-filter-2">
                                Thương hiệu
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
                            aria-labelledby="accordion-heading-11" data-bs-parent="#categories-list">
                            <div class="accordion-body px-0 pb-0 pt-3">
                                <ul class="list list-inline mb-0">
                                    @foreach ($brands as $brand)
                                        <li class="list-item">
                                            <a href="#" class="menu-link py-1">{{ $brand->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div><!-- /.accordion-item -->
                </div><!-- /.accordion-item -->
                <div class="accordion" id="size-filters">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-size">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-size" aria-expanded="true"
                                aria-controls="accordion-filter-size">
                                Tags
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
                                    @foreach ($tags as $tag)
                                        <a href="{{ route('client.blog', ['tag' => $tag->name]) }}"
                                            class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">
                                            {{ $tag->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div><!-- /.accordion-item -->
                </div><!-- /.accordion -->

                <div class="accordion" id="brand-filters">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-brand">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-brand" aria-expanded="true"
                                aria-controls="accordion-filter-brand">
                                Brands
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-brand" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-brand" data-bs-parent="#brand-filters">
                            <div class="search-field multi-select accordion-body px-0 pb-0">
                                <select class="d-none" multiple name="total-numbers-list">
                                    <option value="1">Adidas</option>
                                    <option value="2">Balmain</option>
                                    <option value="3">Balenciaga</option>
                                    <option value="4">Burberry</option>
                                    <option value="5">Kenzo</option>
                                    <option value="5">Givenchy</option>
                                    <option value="5">Zara</option>
                                </select>
                                <div class="search-field__input-wrapper mb-3">
                                    <input type="text" name="search_text"
                                        class="search-field__input form-control form-control-sm border-light border-2"
                                        placeholder="SEARCH">
                                </div>
                                <ul class="multi-select__list list-unstyled">
                                    <li
                                        class="search-suggestion__item multi-select__item text-primary js-search-select js-multi-select">
                                        <span class="me-auto">Adidas</span>
                                        <span class="text-secondary">2</span>
                                    </li>
                                    <li
                                        class="search-suggestion__item multi-select__item text-primary js-search-select js-multi-select">
                                        <span class="me-auto">Balmain</span>
                                        <span class="text-secondary">7</span>
                                    </li>
                                    <li
                                        class="search-suggestion__item multi-select__item text-primary js-search-select js-multi-select">
                                        <span class="me-auto">Balenciaga</span>
                                        <span class="text-secondary">10</span>
                                    </li>
                                    <li
                                        class="search-suggestion__item multi-select__item text-primary js-search-select js-multi-select">
                                        <span class="me-auto">Burberry</span>
                                        <span class="text-secondary">39</span>
                                    </li>
                                    <li
                                        class="search-suggestion__item multi-select__item text-primary js-search-select js-multi-select">
                                        <span class="me-auto">Kenzo</span>
                                        <span class="text-secondary">95</span>
                                    </li>
                                    <li
                                        class="search-suggestion__item multi-select__item text-primary js-search-select js-multi-select">
                                        <span class="me-auto">Givenchy</span>
                                        <span class="text-secondary">1092</span>
                                    </li>
                                    <li
                                        class="search-suggestion__item multi-select__item text-primary js-search-select js-multi-select">
                                        <span class="me-auto">Zara</span>
                                        <span class="text-secondary">48</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- /.accordion-item -->
                </div><!-- /.accordion -->
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
                    @foreach ($posts as $post)
                        <div class="blog-grid__item">
                            <div class="blog-grid__item-image">
                                <img loading="lazy" class="h-auto"
                                    src="{{ Storage::url($post->image ?? 'avatar/default.jpeg') }}" width="450"
                                    height="400" alt="">
                            </div>
                            <div class="blog-grid__item-detail">
                                <div class="blog-grid__item-meta">
                                    <span class="blog-grid__item-meta__author">Đăng bởi |
                                        <strong>{{ $post->user->name }}</strong></span>
                                    <span
                                        class="blog-grid__item-meta__date">{{ \Carbon\Carbon::parse($post->pushlisted_at)->format('M d, Y') }}
                                    </span>
                                </div>
                                <div class="blog-grid__item-title">
                                    <a href="{{route('client.blog.detail', $post->id)}}">{{ $post->title }}</a>
                                </div>
                                <div class="blog-grid__item-content">
                                    <p>{{ $post->excerpt }}</p>
                                    <a href="{{route('client.blog.detail', $post->id)}}" class="readmore-link">Continue Reading</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Hiển thị phân trang -->
                <div class="justify-content-center mt-4">
                    {{ $posts->links() }}
                </div>


            </div>
        </section><!-- /.shop-main container -->
    </main>
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
@endsection
@section('script')
@endsection
@section('style')
@endsection

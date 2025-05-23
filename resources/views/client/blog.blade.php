@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <main>
        <div class="mb-4 pb-lg-3"></div>
        <div class="mb-4 pb-lg-3"></div>
        <section class="shop-main container d-flex">
            <div sty class="shop-sidebar side-sticky bg-body border-1 p-3 shadow-sm" id="shopFilter">
                <div class="aside-header d-flex d-lg-none align-items-center">
                    <h3 class="text-uppercase fs-6 mb-0">Filter By</h3>
                    <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
                </div><!-- /.aside-header -->
                <div class="pt-4 pt-lg-0"></div>
                <form action="{{ route('client.search') }}" method="GET" class="d-flex justify-content-center my-4"
                    role="search">
                    <div class="input-group shadow-sm" style="max-width: 500px;">
                        <input type="text" name="query" class="form-control form-control-lg"
                            placeholder="Tìm bài viết..." aria-label="Search" required>
                        <input type="hidden" name="type" value="post">
                        <button class="btn btn-outline-secondary w-auto px-3" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0
                                                            1.415-1.414l-3.85-3.85zm-5.242 1.106a5.5
                                                            5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11z" />
                            </svg>
                        </button>
                    </div>
                </form>
                <div class="pt-4 pt-lg-0"></div>

                <div class="accordion" id="categories-list">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-11">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-1" aria-expanded="true"
                                aria-controls="accordion-filter-1">
                                <strong> Danh mục</strong>
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
                                                {{ $category->name }}
                                            </a>
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
                                <strong> Tags</strong>
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
                            aria-labelledby="accordion-heading-size">
                            <div class="accordion-body px-0 pb-0">
                                <div class="d-flex flex-column">
                                    @foreach ($tags as $tag)
                                        <a href="{{ route('client.blog', ['tag' => $tag->name]) }}"
                                            class="swatch-size btn btn-sm btn-outline-light mb-2 text-center w-100">
                                            {{ $tag->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div><!-- /.accordion-item -->
                </div><!-- /.accordion -->
            </div><!-- /.shop-sidebar -->

            <div class="shop-list flex-grow-1">
                <div class="d-flex justify-content-between mb-4 pb-md-2">
                    <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium"><strong>Trang
                                chủ</strong></a>
                        <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">|</span>
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium"><strong>Tin
                                tức</strong></a>
                    </div><!-- /.breadcrumb -->

                    <div
                        class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                        @php
                            $currentFilter = request('filter'); // Lấy giá trị filter từ URL
                        @endphp

                        <select style="width: 50%;" class="form-select border-light shadow-sm fw-medium p-1"
                            aria-label="Sắp xếp sản phẩm" name="total-number" onchange="window.location.href = this.value;">

                            <option value="{{ route('client.blog') }}" {{ $currentFilter ? '' : 'selected' }}>Tất cả các
                                bài viết</option>

                            <option value="{{ route('client.blog', ['filter' => 'az']) }}"
                                {{ $currentFilter == 'az' ? 'selected' : '' }}>Theo bảng chữ cái, A-Z</option>
                            <option value="{{ route('client.blog', ['filter' => 'za']) }}"
                                {{ $currentFilter == 'za' ? 'selected' : '' }}>Theo bảng chữ cái, Z-A</option>
                            <option value="{{ route('client.blog', ['filter' => 'feature']) }}"
                                {{ $currentFilter == 'feature' ? 'selected' : '' }}>Bài viết nổi bật</option>
                            <option value="{{ route('client.blog', ['filter' => 'date_old']) }}"
                                {{ $currentFilter == 'date_old' ? 'selected' : '' }}>Ngày: Cũ đến mới</option>
                            <option value="{{ route('client.blog', ['filter' => 'date_new']) }}"
                                {{ $currentFilter == 'date_new' ? 'selected' : '' }}>Ngày: Mới đến cũ</option>
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
                @if (Route::currentRouteName() == 'client.search')
                    <p
                        class="text-center text-primary my-4 p-2 border-left border-4 border-primary rounded shadow-sm bg-light fw-bold">
                        Kết quả tìm kiếm cho: "{{ request('query') }}"
                    </p>
                @endif
                @if (request('category'))
                    <div
                        style="padding: 12px; margin-bottom: 10px; background-color: #f8f9fa; border-left: 6px solid #ad0b0b;">
                        <span style="">Đang lọc theo danh mục:</span>
                        <span style="font-weight: 600;">{{ request('category') }}</span>
                    </div>
                @endif
                @if (request('tag'))
                    <div
                        style="padding: 12px; margin-bottom: 10px; background-color: #f8f9fa; border-left: 6px solid #ad0b0b;">
                        <span style="">Đang lọc theo tag:</span>
                        <span style="font-weight: 600;">{{ request('tag') }}</span>
                    </div>
                @endif
                @php
                    $filterMessages = [
                        'feature' => 'Lượt xem',
                        'az' => 'Tên: A → Z',
                        'za' => 'Tên: Z → A',
                        'date_old' => 'Ngày đăng: Cũ nhất',
                        'date_new' => 'Ngày đăng: Mới nhất',
                    ];
                @endphp

                @if (request('filter') && isset($filterMessages[request('filter')]))
                    <div
                        style="padding: 12px; margin-bottom: 10px; background-color: #f8f9fa; border-left: 6px solid #ad0b0b;">
                        <span style="">Đang sắp xếp theo:</span>
                        <span style="font-weight: 600;">{{ $filterMessages[request('filter')] }}</span>
                    </div>
                @endif
                <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
                    @foreach ($posts as $post)
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="blog-grid__item-image">
                                    <img loading="lazy" class="card-img-top img-fluid"
                                        src="{{ Storage::url($post->image ?? 'avatar/default.jpeg') }}"
                                        alt="{{ $post->title }}" style="object-fit: cover; height: 250px;">
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <div class="text-muted mb-2">
                                        <p class="mb-0">Đăng bởi | <strong>{{ $post->user->name }}</strong></p>
                                        <p class="mb-0">
                                            {{ \Carbon\Carbon::parse($post->pushlisted_at)->format('M d, Y') }}
                                        </p>
                                    </div>
                                    <h5 class="">
                                        <a href="{{ route('client.blog.detail', $post->id) }}"
                                            class="text-decoration-none text-dark">
                                            {{ $post->title }}
                                        </a>
                                    </h5>
                                    <div class="card-text blog-grid__item-content flex-grow-1">
                                        <p class="text-muted">{{ $post->excerpt }}</p>
                                    </div>
                                    <a href="{{ route('client.blog.detail', $post->id) }}"
                                        class="btn btn-outline-primary mt-2">
                                        Đọc bài viết
                                    </a>
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

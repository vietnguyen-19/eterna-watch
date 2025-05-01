@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <main>
        <div class="mb-4 pb-lg-3"></div>
        <div class="mb-4 pb-lg-3"></div>
        <section class="shop-main container d-flex">
            <div class="shop-sidebar side-sticky bg-body border-1" id="shopFilter">
                <div class="pt-4 pt-lg-0"></div>
                <form action="{{ route('client.search') }}" method="GET" class="d-flex justify-content-center my-4"
                    role="search">
                    <div class="input-group shadow-sm" style="max-width: 500px;">
                        <input type="text" name="query" class="form-control form-control-lg"
                            placeholder="Tìm sản phẩm..." aria-label="Search" required>
                        <input type="hidden" name="type" value="product">
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
                                <strong> Danh mục sản phẩm</strong>
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
                                            <a href="{{ route('client.shop', ['category_id' => $category->id]) }}"
                                                class="menu-link py-1 d-flex justify-content-between align-items-center">
                                                <span>{{ $category->name }}</span>
                                                <span style="background: #585858" class="badge text-white">
                                                    {{ str_pad($category->products_count, 2, '0', STR_PAD_LEFT) }}
                                                </span>
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
                                <strong> Thương hiệu đồng hồ</strong>
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
                                        @if ($brand->parent_id === null)
                                            <li class="list-item">
                                                <a href="{{ route('client.shop', ['brand' => $brand->name]) }}"
                                                    class="menu-link py-1 d-flex justify-content-between align-items-center">
                                                    <span>{{ $brand->name }}</span>
                                                    <span class="badge text-white" style="background: #585858;">
                                                        {{ str_pad($brand->products_count, 2, '0', STR_PAD_LEFT) }}
                                                    </span>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div><!-- /.accordion-item -->
                </div><!-- /.accordion-item -->

                <form action="{{ route('client.shop.filter') }}" method="GET">
                    <div class="accordion" id="price-filters">
                        <div class="accordion-item mb-4">
                            <h5 class="accordion-header mb-2" id="accordion-heading-price">
                                <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#accordion-filter-price" aria-expanded="true"
                                    aria-controls="accordion-filter-price">
                                    <strong>Lọc theo giá trị</strong>
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

                                <!-- Nhập khoảng giá -->
                                <div class="mb-3">
                                    <label for="min_price" class="form-label">Giá tối thiểu (₫)</label>
                                    <input type="number" class="form-control" id="min_price" name="min_price"
                                        placeholder="Nhập giá từ..." min="0">
                                </div>
                                <div class="mb-3">
                                    <label for="max_price" class="form-label">Giá tối đa (₫)</label>
                                    <input type="number" class="form-control" id="max_price" name="max_price"
                                        placeholder="Nhập giá đến..." min="0">
                                </div>

                                <!-- Button lọc -->
                                <button type="submit" class="w-100 btn btn-primary">Lọc theo giá</button>
                            </div>
                        </div>
                    </div>
                </form>



            </div><!-- /.shop-sidebar -->

            <div class="shop-list flex-grow-1">
                <div class="d-flex justify-content-between mb-4 pb-md-2">
                    <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-bold">Trang chủ</a>
                        <span class="breadcrumb-separator menu-link fw-bold ps-1 pe-1">|</span>
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-bold">Cửa hàng</a>
                    </div><!-- /.breadcrumb -->

                    <div
                        class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                        @php
                            $currentFilter = request('filter'); // Lấy giá trị filter từ URL
                        @endphp

                        <select style="width: 50%;" class="form-select border-light shadow-sm fw-medium p-1"
                            aria-label="Sắp xếp sản phẩm" name="total-number"
                            onchange="window.location.href = this.value;">

                            <option value="{{ route('client.shop') }}" {{ $currentFilter ? '' : 'selected' }}>Tất cả sản
                                phẩm</option>
                            <option value="{{ route('client.shop', ['filter' => 'best_selling']) }}"
                                {{ $currentFilter == 'best_selling' ? 'selected' : '' }}>Bán chạy nhất</option>
                            <option value="{{ route('client.shop', ['filter' => 'az']) }}"
                                {{ $currentFilter == 'az' ? 'selected' : '' }}>Theo bảng chữ cái, A-Z</option>
                            <option value="{{ route('client.shop', ['filter' => 'za']) }}"
                                {{ $currentFilter == 'za' ? 'selected' : '' }}>Theo bảng chữ cái, Z-A</option>
                            <option value="{{ route('client.shop', ['filter' => 'price_asc']) }}"
                                {{ $currentFilter == 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến cao</option>
                            <option value="{{ route('client.shop', ['filter' => 'price_desc']) }}"
                                {{ $currentFilter == 'price_desc' ? 'selected' : '' }}>Giá: Cao đến thấp</option>
                            <option value="{{ route('client.shop', ['filter' => 'date_old']) }}"
                                {{ $currentFilter == 'date_old' ? 'selected' : '' }}>Ngày: Cũ đến mới</option>
                            <option value="{{ route('client.shop', ['filter' => 'date_new']) }}"
                                {{ $currentFilter == 'date_new' ? 'selected' : '' }}>Ngày: Mới đến cũ</option>
                        </select>



                        <div class="shop-asc__seprator mx-3 bg-light d-none d-md-block order-md-0"></div>

                        <div class="col-size align-items-center order-1 d-none d-lg-flex">
                            <span class="text-uppercase fw-bold me-2">View</span>
                            <button class="btn-link fw-bold me-2 js-cols-size" data-target="products-grid"
                                data-cols="2">2</button>
                            <button class="btn-link fw-bold me-2 js-cols-size" data-target="products-grid"
                                data-cols="3">3</button>
                            <button class="btn-link fw-bold js-cols-size" data-target="products-grid"
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
                @if (request('category_id'))
                    <div
                        style="padding: 12px; margin-bottom: 10px; background-color: #f8f9fa; border-left: 6px solid #0d6efd;">
                        <span style="">Đang lọc theo danh mục:</span>
                        <span style="font-weight: 600;">
                            {{ optional(\App\Models\Category::find(request('category_id')))->name ?? 'Không xác định' }}
                        </span>
                    </div>
                @endif

                @if (request('brand'))
                    <div
                        style="padding: 12px; margin-bottom: 10px; background-color: #f8f9fa; border-left: 6px solid #198754;">
                        <span style="">Đang lọc theo thương hiệu:</span>
                        <span style="font-weight: 600;">{{ request('brand') }}</span>
                    </div>
                @endif

                @php
                    $filterMessages = [
                        'best_selling' => 'Sản phẩm bán chạy',
                        'az' => 'Tên: A → Z',
                        'za' => 'Tên: Z → A',
                        'price_asc' => 'Giá: Thấp đến Cao',
                        'price_desc' => 'Giá: Cao đến Thấp',
                        'date_old' => 'Ngày đăng: Cũ nhất',
                        'date_new' => 'Ngày đăng: Mới nhất',
                    ];
                @endphp

                @if (request('filter') && isset($filterMessages[request('filter')]))
                    <div
                        style="padding: 12px; margin-bottom: 10px; background-color: #f8f9fa; border-left: 6px solid #ffc107;">
                        <span style="">Đang sắp xếp theo:</span>
                        <span style="font-weight: 600;">{{ $filterMessages[request('filter')] }}</span>
                    </div>
                @endif

                @if (request('min_price') && request('max_price'))
                    <div
                        style="padding: 12px; margin-bottom: 10px; background-color: #f8f9fa; border-left: 6px solid #0dcaf0;">
                        <span style="">Đang lọc theo khoảng giá:</span>
                        <span style="font-weight: 600;">
                            từ {{ number_format(request('min_price'), 0, ',', '.') }}₫
                            đến {{ number_format(request('max_price'), 0, ',', '.') }}₫
                        </span>
                    </div>
                @endif


                <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">

                    @foreach ($products as $product)
                        <div class="product-card-wrapper">
                            <div class="product-card product-card_style6 hover-container mb-3">
                                <div class="pc__img-wrapper">
                                    <a href="{{ route('client.shop.show', $product->id) }}">
                                        <img style="border: 1px solid #e4e4e4" loading="lazy"
                                            src="{{ Storage::url($product->avatar ?? 'avatar/default.jpeg') }}"
                                            width="330" height="400" alt="{{ $product->name }}" class="pc__img">
                                    </a>
                                </div>

                                <div style="border: 1px solid #e4e4e4" class="pc__info position-relative bg-body">
                                    <div class="position-relative">
                                        <p class="pc__category fs-13">{{ $product->category->name ?? 'Danh mục' }}</p>
                                        <h6 class="pc__title fs-base fw-semi-bold mb-1">
                                            <a
                                                href="{{ route('client.shop.show', $product->id) }}">{{ $product->name }}</a>
                                        </h6>
                                        <div style="color: rgb(188, 0, 0); "
                                            class="product-card__price d-flex mb-1 fw-bold">
                                            @if ($product->min_price == $product->max_price)
                                                {{ number_format($product->min_price, 0, ',', '.') }} đ
                                            @else
                                                {{ number_format($product->min_price, 0, ',', '.') }} -
                                                {{ number_format($product->max_price, 0, ',', '.') }} đ
                                            @endif
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
    <!-- JS noUiSlider -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var priceSlider = document.getElementById('price-slider');

            noUiSlider.create(priceSlider, {
                start: [{{ request('min_price', 25000) }},
                    {{ request('max_price', 450000) }}
                ], // Giá trị mặc định
                connect: true,
                range: {
                    'min': 10000,
                    'max': 1000000
                },
                step: 5000,
                format: {
                    to: function(value) {
                        return Math.round(value);
                    },
                    from: function(value) {
                        return Number(value);
                    }
                }
            });

            var minPriceInput = document.getElementById('min_price_input');
            var maxPriceInput = document.getElementById('max_price_input');
            var minPriceDisplay = document.getElementById('min-price');
            var maxPriceDisplay = document.getElementById('max-price');

            // Cập nhật giá trị khi thanh trượt thay đổi
            priceSlider.noUiSlider.on('update', function(values) {
                minPriceDisplay.innerHTML = new Intl.NumberFormat().format(values[0]);
                maxPriceDisplay.innerHTML = new Intl.NumberFormat().format(values[1]);

                minPriceInput.value = values[0];
                maxPriceInput.value = values[1];
            });
        });
    </script>
@endsection
@section('style')
    <!-- CSS noUiSlider -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css">

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

        /* Bo tròn đầu tay cầm */
        .noUi-handle {
            width: 8px;
            height: 8px;
            background: #2f2f2f;
            border: 1px solid #a81717;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
            cursor: grab;
        }

        /* Đổi màu thanh trượt */
        .noUi-connect {
            background: #414141;
        }

        /* Màu nền thanh trượt */
        .noUi-target {
            background: #e0e0e0;
            border-radius: 4px;
            border: none;
            box-shadow: none;
        }

        /* Hover hiệu ứng nhẹ */
        .noUi-handle:hover {
            background: #0056b3;
        }

        /* Hiển thị giá trị khi thay đổi */
        .price-value {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        #shopFilter {
            padding: 1.5rem;
            background-color: #f8f9fa;
            /* Màu nền nhẹ, dễ nhìn */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Tạo độ bóng nhẹ cho sidebar */
            border-radius: 8px;
            /* Bo tròn các góc của sidebar */
            position: sticky;
            top: 1rem;
            /* Giữ sidebar ở vị trí cố định khi cuộn */
            transition: all 0.3s ease;
            /* Hiệu ứng mượt mà khi thay đổi trạng thái */
        }
    </style>
@endsection

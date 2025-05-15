@extends('client.layouts.master')
@section('content')
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
    <main>
        <div class="mb-4 pb-lg-3"></div>
        <div class="mb-4 pb-lg-3"></div>
        <section class="shop-main container d-flex">
            <div class="shop-sidebar side-sticky bg-body border-1" id="shopFilter">
                <div class="pt-4 pt-lg-0"></div>
                <!-- Form tìm kiếm chung -->
                <form action="{{ route('client.shop') }}" method="GET" id="filterForm" class="my-4">
                    <!-- Hiển thị lỗi từ server -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Thanh tìm kiếm -->
                    <div class="input-group shadow-sm mb-4" style="max-width: 500px;">
                        <input type="text" name="query" class="form-control form-control-lg"
                            placeholder="Nhập tên sản phẩm..." aria-label="Search"
                            value="{{ old('query', request('query')) }}">
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

                    <!-- Danh mục sản phẩm -->
                    <div class="accordion" id="categories-list">
                        <div class="accordion-item mb-4 pb-3">
                            <h5 class="accordion-header" id="accordion-heading-11">
                                <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#accordion-filter-1" aria-expanded="true"
                                    aria-controls="accordion-filter-1">
                                    <strong>Danh mục sản phẩm</strong>
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
                                                <label class="d-flex align-items-center py-1">
                                                    <input type="checkbox" name="category_ids[]"
                                                        value="{{ $category->id }}"
                                                        {{ in_array($category->id, old('category_ids', request('category_ids', []))) ? 'checked' : '' }}
                                                        onchange="submitFilterForm()">
                                                    <span class="ms-2">{{ $category->name }}</span>
                                                    <span style="background: #585858" class="badge text-white ms-auto">
                                                        {{ str_pad($category->products_count, 2, '0', STR_PAD_LEFT) }}
                                                    </span>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thương hiệu đồng hồ -->
                    <div class="accordion" id="brands-list">
                        <div class="accordion-item mb-4 pb-3">
                            <h5 class="accordion-header" id="accordion-heading-12">
                                <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#accordion-filter-2" aria-expanded="true"
                                    aria-controls="accordion-filter-2">
                                    <strong>Thương hiệu đồng hồ</strong>
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
                                aria-labelledby="accordion-heading-12" data-bs-parent="#brands-list">
                                <div class="accordion-body px-0 pb-0 pt-3">
                                    <ul class="list list-inline mb-0">
                                        @foreach ($brands as $brand)
                                            @if ($brand->parent_id === null)
                                                <li class="list-item">
                                                    <label class="d-flex align-items-center py-1">
                                                        <input type="checkbox" name="brand_ids[]"
                                                            value="{{ $brand->id }}"
                                                            {{ in_array($brand->id, old('brand_ids', request('brand_ids', []))) ? 'checked' : '' }}
                                                            onchange="submitFilterForm()">
                                                        <span class="ms-2">{{ $brand->name }}</span>
                                                        <span style="background: #585858"
                                                            class="badge text-white ms-auto">
                                                            {{ str_pad($brand->products_count, 2, '0', STR_PAD_LEFT) }}
                                                        </span>
                                                    </label>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lọc theo giá -->
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
                                <div class="mb-3">
                                    <label for="min_price" class="form-label">Giá tối thiểu (₫)</label>
                                    <input type="number" class="form-control" id="min_price" name="min_price"
                                        placeholder="Nhập giá từ..." min="0" step="1000000"
                                        value="{{ old('min_price', request('min_price', 0)) }}">
                                    <div class="invalid-feedback" id="min_price_error"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="max_price" class="form-label">Giá tối đa (₫)</label>
                                    <input type="number" class="form-control" id="max_price" name="max_price"
                                        placeholder="Nhập giá đến..." min="0" step="1000000"
                                        value="{{ old('max_price', request('max_price', 500000000)) }}">
                                    <div class="invalid-feedback" id="max_price_error"></div>
                                </div>
                                <!-- Thêm thanh trượt giá -->
                                <div id="price-slider" class="mb-3"></div>
                                <div id="price-display" class="mb-3 text-center"></div>
                                <button type="submit" class="w-100 btn btn-primary" id="filterButton">Lọc theo giá</button>
                                <a href="{{ route('client.shop') }}" class="btn btn-secondary w-100 mt-2">Xóa bộ lọc</a>
                            </div>
                        </div>
                    </div>

                    <!-- Giữ lại các tham số sắp xếp -->
                    @if (request('filter'))
                        <input type="hidden" name="filter" value="{{ old('filter', request('filter')) }}">
                    @endif
                </form>
            </div>

            <div class="shop-list flex-grow-1">
                <div class="d-flex justify-content-between mb-4 pb-md-2">
                    <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-bold">Trang chủ</a>
                        <span class="breadcrumb-separator menu-link fw-bold ps-1 pe-1">|</span>
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-bold">Cửa hàng</a>
                    </div>
                    <div
                        class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                        @php
                            $currentFilter = old('filter', request('filter'));
                            $queryParams = request()->query();
                            unset($queryParams['filter']);
                        @endphp
                        <select style="width: 50%;" class="form-select border-light shadow-sm fw-medium p-1"
                            aria-label="Sắp xếp sản phẩm" name="total-number"
                            onchange="window.location.href = this.value;">
                            <option value="{{ route('client.shop', $queryParams) }}"
                                {{ !$currentFilter ? 'selected' : '' }}>Tất cả sản phẩm</option>
                            <option
                                value="{{ route('client.shop', array_merge($queryParams, ['filter' => 'best_selling'])) }}"
                                {{ $currentFilter == 'best_selling' ? 'selected' : '' }}>Bán chạy nhất</option>
                            <option value="{{ route('client.shop', array_merge($queryParams, ['filter' => 'az'])) }}"
                                {{ $currentFilter == 'az' ? 'selected' : '' }}>Theo bảng chữ cái, A-Z</option>
                            <option value="{{ route('client.shop', array_merge($queryParams, ['filter' => 'za'])) }}"
                                {{ $currentFilter == 'za' ? 'selected' : '' }}>Theo bảng chữ cái, Z-A</option>
                            <option
                                value="{{ route('client.shop', array_merge($queryParams, ['filter' => 'price_asc'])) }}"
                                {{ $currentFilter == 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến cao</option>
                            <option
                                value="{{ route('client.shop', array_merge($queryParams, ['filter' => 'price_desc'])) }}"
                                {{ $currentFilter == 'price_desc' ? 'selected' : '' }}>Giá: Cao đến thấp</option>
                            <option
                                value="{{ route('client.shop', array_merge($queryParams, ['filter' => 'date_old'])) }}"
                                {{ $currentFilter == 'date_old' ? 'selected' : '' }}>Ngày: Cũ đến mới</option>
                            <option
                                value="{{ route('client.shop', array_merge($queryParams, ['filter' => 'date_new'])) }}"
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
                        </div>
                        <div class="shop-filter d-flex align-items-center order-0 order-md-3 d-lg-none">
                            <button class="btn-link btn-link_f d-flex align-items-center ps-0 js-open-aside"
                                data-aside="shopFilter">
                                <svg class="d-inline-block align-middle me-2" width="14" height="10"
                                    viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_filter" />
                                </svg>
                                <span class="text-uppercase fw-medium d-inline-block align-middle">Filter</span>
                            </button>
                        </div>
                    </div>
                </div>
                @if (request('query'))
                    <p
                        class="text-center text-primary my-4 p-2 border-left border-4 border-primary rounded shadow-sm bg-light fw-bold">
                        Kết quả tìm kiếm cho: "{{ old('query', request('query')) }}"
                    </p>
                @endif
                @if (request('category_ids'))
                    <div
                        style="padding: 12px; margin-bottom: 10px; background-color: #f8f9fa; border-left: 6px solid #0d6efd;">
                        <span style="">Đang lọc theo danh mục:</span>
                        <span style="font-weight: 600;">
                            @foreach (old('category_ids', request('category_ids', [])) as $catId)
                                {{ optional(\App\Models\Category::find($catId))->name ?? 'Không xác định' }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </span>
                    </div>
                @endif
                @if (request('brand_ids'))
                    <div
                        style="padding: 12px; margin-bottom: 10px; background-color: #f8f9fa; border-left: 6px solid #198754;">
                        <span style="">Đang lọc theo thương hiệu:</span>
                        <span style="font-weight: 600;">
                            @foreach (old('brand_ids', request('brand_ids', [])) as $brandId)
                                {{ optional(\App\Models\Brand::find($brandId))->name ?? 'Không xác định' }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </span>
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
                        <span style="font-weight: 600;">{{ $filterMessages[old('filter', request('filter'))] }}</span>
                    </div>
                @endif
                @if (request('min_price') && request('max_price'))
                    <div
                        style="padding: 12px; margin-bottom: 10px; background-color: #f8f9fa; border-left: 6px solid #0dcaf0;">
                        <span style="">Đang lọc theo khoảng giá:</span>
                        <span style="font-weight: 600;">
                            từ {{ number_format(old('min_price', request('min_price')), 0, ',', '.') }}₫
                            đến {{ number_format(old('max_price', request('max_price')), 0, ',', '.') }}₫
                        </span>
                    </div>
                @endif
                @if ($products->isEmpty())
                    <p class="text-center text-muted my-4">Không tìm thấy sản phẩm nào khớp với bộ lọc.</p>
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
                                                {{ number_format($product->min_price, 0, ',', '.') }} ₫
                                            @else
                                                {{ number_format($product->min_price, 0, ',', '.') }} -
                                                {{ number_format($product->max_price, 0, ',', '.') }} ₫
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="justify-content-center mt-4">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>
        </section>
    </main>
    <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>
    <script>
        // Hàm định dạng số với dấu phân cách hàng nghìn
        function formatNumber(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        // Hàm debounce để giới hạn tần suất gửi form
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Hàm validate giá trị nhập vào
        function validatePriceInputs(minInput, maxInput, minError, maxError) {
            const minValue = parseFloat(minInput.value) || 0;
            const maxValue = parseFloat(maxInput.value) || 1000000000;
            let isValid = true;

            // Xóa lỗi cũ
            minInput.classList.remove('is-invalid');
            maxInput.classList.remove('is-invalid');
            minError.textContent = '';
            maxError.textContent = '';

            // Kiểm tra min_price
            if (isNaN(minValue) || minValue < 0) {
                minError.textContent = 'Giá tối thiểu không được nhỏ hơn 0 ₫.';
                minInput.classList.add('is-invalid');
                isValid = false;
            } else if (minValue > 1000000000) {
                minError.textContent = 'Giá tối thiểu không được lớn hơn 1,000,000,000 ₫.';
                minInput.classList.add('is-invalid');
                isValid = false;
            }

            // Kiểm tra max_price
            if (isNaN(maxValue) || maxValue < 0) {
                maxError.textContent = 'Giá tối đa không được nhỏ hơn 0 ₫.';
                maxInput.classList.add('is-invalid');
                isValid = false;
            } else if (maxValue > 1000000000) {
                maxError.textContent = 'Giá tối đa không được lớn hơn 1,000,000,000 ₫.';
                maxInput.classList.add('is-invalid');
                isValid = false;
            }

            // Kiểm tra min_price <= max_price
            if (isValid && minValue > maxValue) {
                minError.textContent = 'Giá tối thiểu không được lớn hơn giá tối đa.';
                minInput.classList.add('is-invalid');
                isValid = false;
            }

            return isValid;
        }

        // Hàm gửi form
        const submitFilterForm = debounce(function() {
            const minPriceInput = document.getElementById('min_price');
            const maxPriceInput = document.getElementById('max_price');
            const minPriceError = document.getElementById('min_price_error');
            const maxPriceError = document.getElementById('max_price_error');

            if (validatePriceInputs(minPriceInput, maxPriceInput, minPriceError, maxPriceError)) {
                document.getElementById('filterForm').submit();
            }
        }, 300);

        document.addEventListener("DOMContentLoaded", function() {
            const priceSlider = document.getElementById('price-slider');
            const minPriceInput = document.getElementById('min_price');
            const maxPriceInput = document.getElementById('max_price');
            const priceDisplay = document.getElementById('price-display');
            const minPriceError = document.getElementById('min_price_error');
            const maxPriceError = document.getElementById('max_price_error');

            if (priceSlider && minPriceInput && maxPriceInput && priceDisplay) {
                // Sanitize input values from URL
                const minPrice = parseInt({{ old('min_price', request('min_price', 0)) }}) || 0;
                const maxPrice = parseInt({{ old('max_price', request('max_price', 500000000)) }}) || 500000000;

                noUiSlider.create(priceSlider, {
                    start: [minPrice, maxPrice],
                    connect: true,
                    range: {
                        'min': 0,
                        'max': 1000000000 // Phạm vi tối đa 1 tỷ
                    },
                    step: 1000000, // Bước nhảy 1 triệu
                    format: {
                        to: function(value) {
                            return Math.round(value);
                        },
                        from: function(value) {
                            return Number(value);
                        }
                    }
                });

                // Cập nhật input và hiển thị khi thanh trượt thay đổi
                priceSlider.noUiSlider.on('update', function(values) {
                    minPriceInput.value = values[0];
                    maxPriceInput.value = values[1];
                    priceDisplay.textContent = `Từ ${formatNumber(values[0])} ₫ đến ${formatNumber(values[1])} ₫`;

                    // Xóa lỗi khi thanh trượt thay đổi
                    minPriceInput.classList.remove('is-invalid');
                    maxPriceInput.classList.remove('is-invalid');
                    minPriceError.textContent = '';
                    maxPriceError.textContent = '';
                });

                // Validate khi hoàn thành nhập min_price
                minPriceInput.addEventListener('change', function() {
                    if (validatePriceInputs(minPriceInput, maxPriceInput, minPriceError, maxPriceError)) {
                        const value = parseInt(this.value) || 0;
                        priceSlider.noUiSlider.set([value, null]);
                    }
                });

                // Validate khi hoàn thành nhập max_price
                maxPriceInput.addEventListener('change', function() {
                    if (validatePriceInputs(minPriceInput, maxPriceInput, minPriceError, maxPriceError)) {
                        const value = parseInt(this.value) || 1000000000;
                        priceSlider.noUiSlider.set([null, value]);
                    }
                });

                // Xóa lỗi khi người dùng bắt đầu nhập
                minPriceInput.addEventListener('input', function() {
                    minPriceInput.classList.remove('is-invalid');
                    minPriceError.textContent = '';
                });

                maxPriceInput.addEventListener('input', function() {
                    maxPriceInput.classList.remove('is-invalid');
                    maxPriceError.textContent = '';
                });

                // Gửi form khi nhấn nút Lọc theo giá
                document.getElementById('filterButton').addEventListener('click', function(event) {
                    event.preventDefault();
                    if (validatePriceInputs(minPriceInput, maxPriceInput, minPriceError, maxPriceError)) {
                        document.getElementById('filterForm').submit();
                    }
                });

                // Khởi tạo hiển thị giá ban đầu
                priceDisplay.textContent = `Từ ${formatNumber(minPrice)} ₫ đến ${formatNumber(maxPrice)} ₫`;
            } else {
                console.warn('Price slider or input elements not found in the DOM.');
            }
        });
    </script>
@endsection
@section('style')
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
        .noUi-handle {
            width: 8px;
            height: 8px;
            background: #2f2f2f;
            border: 1px solid #a81717;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
            cursor: grab;
        }
        .noUi-connect {
            background: #414141;
        }
        .noUi-target {
            background: #e0e0e0;
            border-radius: 4px;
            border: none;
            box-shadow: none;
        }
        .noUi-handle:hover {
            background: #0056b3;
        }
        .price-value {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }
        #shopFilter {
            padding: 1.5rem;
            background-color: #f8f9fa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            position: sticky;
            top: 1rem;
            transition: all 0.3s ease;
        }
        .list-item label {
            cursor: pointer;
            width: 100%;
        }
        .list-item input[type="checkbox"] {
            margin: 0;
        }
        #price-slider {
            margin: 20px 10px;
        }
        #price-display {
            font-size: 14px;
            font-weight: 500;
            color: #333;
        }
        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
            display: none;
        }
        .is-invalid ~ .invalid-feedback {
            display: block;
        }
        .is-invalid {
            border-color: #dc3545;
        }
    </style>
@endsection
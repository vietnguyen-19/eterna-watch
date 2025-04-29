<div class="header-mobile header_sticky">
    <div class="container d-flex align-items-center h-100">
        <a class="mobile-nav-activator d-block position-relative" href="#">
            <svg class="nav-icon" width="25" height="18" viewBox="0 0 25 18" xmlns="http://www.w3.org/2000/svg">
                <use href="#icon_nav" />
            </svg>
            <span class="btn-close-lg position-absolute top-0 start-0 w-100"></span>
        </a>

        <div class="logo">
            <a href="index.html">
                <img style="width:50%" src="{{ asset('theme/client/images/logo.png') }}" alt="Uomo"
                    class="logo__image d-block">
            </a>
        </div><!-- /.logo -->

        <a href="#" class="header-tools__item header-tools__cart js-open-aside" data-aside="cartDrawer">
            <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <use href="#icon_cart" />
            </svg>
            <span class="cart-amount d-block position-absolute js-cart-items-count">3</span>
        </a>
    </div><!-- /.container -->

    <nav
        class="header-mobile__navigation navigation d-flex flex-column w-100 position-absolute top-100 bg-body overflow-auto">
        <div class="container">
            <form action="https://uomo-html.flexkitux.com/Demo19/search.html" method="GET"
                class="search-field position-relative mt-4 mb-3">
                <div class="position-relative">
                    <input class="search-field__input w-100 border rounded-1" type="text" name="search-keyword"
                        placeholder="Search products">
                    <button class="btn-icon search-popup__submit pb-0 me-2" type="submit">
                        <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_search" />
                        </svg>
                    </button>
                    <button class="btn-icon btn-close-lg search-popup__reset pb-0 me-2" type="reset"></button>
                </div>

                <div class="position-absolute start-0 top-100 m-0 w-100">
                    <div class="search-result"></div>
                </div>
            </form><!-- /.header-search -->
        </div><!-- /.container -->

        <div class="container">
            <div class="overflow-hidden">
                <ul class="navigation__list list-unstyled position-relative">

                    <li class="navigation__item">
                        <a href="{{ route('client.chatbot.index') }}" class="navigation__link"
                        style="font-weight:bold;{{ Request::is('chatbot') ? 'color: #c20f0f;font-size: 17px' : '' }}">Hỗ trợ</a>
                    </li>

                </ul><!-- /.navigation__list -->
            </div><!-- /.overflow-hidden -->
        </div><!-- /.container -->

    </nav><!-- /.navigation -->
</div><!-- /.header-mobile -->

<header id="header"
    class="header sticky-top w-100 header-transparent-bg header_sticky-bg_dark">
    <div class="header-desk_type_8">
        <div class="header-middle py-3 bg-black">
            <div class="container d-flex align-items-center my-2">
                <div class="flex-1 d-flex align-items-center gap-3">
                    <div class="service-promotion__icon">
                        <svg class="text-white" width="40" height="39" viewBox="0 0 53 52" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_headphone"></use>
                        </svg>
                    </div>
                    <div class="service-promotion__content-wrap">
                        <h3 class="service-promotion__title h6 text-white mb-0">Tư vấn hỗ trợ</h3>
                        <p class=" text-white service-promotion__content fs-base mb-0">{{ $settings['company_phone'] ?? 'chua cap nhat so dien thoai'}}</p>
                    </div>
                </div>
                <div class="logo">
                    <a href="{{ route('client.home') }}">
                        <img src="{{ asset('theme/client/images/logo-white-red.png') }}" alt="Uomo"
                            class="logo__image">
                    </a>
                </div><!-- /.logo -->

                <div class="header-tools d-flex align-items-center flex-1 justify-content-end me-2">
                    <div class="header-tools__item hover-container">
                        <div class="js-hover__open position-relative">
                            <a class="js-search-popup search-field__actor" href="#">
                                <svg class="d-block" width="20" height="20" viewBox="0 0 20 20"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_search"></use>
                                </svg>
                                <i class="btn-icon btn-close-lg"></i>
                            </a>
                        </div>

                        <div class="search-popup js-hidden-content">
                            <form action="{{ route('client.search') }}" method="GET" class="search-field container">
                                <p class="text-uppercase text-secondary fw-medium mb-4">Bạn đang tìm kiếm gì?</p>
                                <div class="position-relative">
                                    <input class="search-field__input search-popup__input w-100 fw-medium"
                                        type="text" name="query" placeholder="Tìm kiếm sản phẩm">
                                    <button class="btn-icon search-popup__submit" type="submit">
                                        <svg class="d-block" width="20" height="20" viewBox="0 0 20 20"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_search"></use>
                                        </svg>
                                    </button>
                                    <button class="btn-icon btn-close-lg search-popup__reset" type="reset"></button>
                                </div>


                            </form><!-- /.header-search -->
                        </div><!-- /.search-popup -->

                    </div><!-- /.header-tools__item hover-container -->
                    <a href="{{ route('cart.index') }}" class="header-tools__item header-tools__cart">
                        <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_cart"></use>
                        </svg>
                        @if (Auth::guard('web')->check())
                            <span class="cart-amount d-block position-absolute js-cart-items-count">
                                {{ Auth::guard('web')->user()->cart ? Auth::guard('web')->user()->cart->countCartDetails() : 0 }}
                            </span>
                        @endif

                    </a>
                    <div class="header-tools__item hover-container dropdown">
                        @if (Auth::guard('web')->check() && Auth::guard('web')->user()->role_id == 3)
                            {{-- Nếu đã đăng nhập, hiển thị avatar và dropdown --}}
                            <a href="#" class="dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img src="{{ Storage::url(Auth::guard('web')->user()->avatar ?? 'avatar/default.jpeg') }}"
                                    alt="Avatar" class="rounded-circle border border-secondary" width="40"
                                    height="40">
                            </a>

                            {{-- Nội dung dropdown --}}
                            <ul style="border-top: 1px solid #fff; padding: 16px 32px"
                                class="dropdown-menu dropdown-menu-end bg-dark text-white mt-2"
                                aria-labelledby="userDropdown" style="min-width: 400px;">
                                <li class="text-center">
                                    <img src="{{ Storage::url(Auth::guard('web')->user()->avatar ?? 'avatar/default.jpeg') }}"
                                        alt="Avatar" class="rounded-circle border border-light mb-2" width="70"
                                        height="70">
                                    <p class="mb-0 fw-bold">{{ Auth::guard('web')->user()->name }}</p>
                                    <p class="text-muted small">{{ Auth::guard('web')->user()->email }}</p>
                                </li>
                                <li>
                                    <hr class="dropdown-divider border-secondary">
                                </li>
                                <li><a class="dropdown-item login text-white py-2 " href="{{route('account.order')}}">Xem tài khoản</a></li>
                                <li>
                                    <hr class="dropdown-divider border-secondary">
                                </li>
                                <li>
                                    <form action="{{ route('client.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item login text-danger py-2">Đăng
                                            xuất</button>
                                    </form>
                                </li>
                            </ul>
                        @else
                            {{-- Nếu chưa đăng nhập, hiển thị icon đăng nhập --}}
                            <a href="{{ route('client.login') }}">
                                <svg class="d-block" width="20" height="20" viewBox="0 0 20 20"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_user"></use>
                                </svg>
                            </a>
                        @endif
                    </div>

                </div><!-- /.header__tools -->
            </div>
        </div><!-- /.header-middle -->

        <div class="header-bottom bg-black">
            <div class="container">
                <nav class="navigation w-100 d-flex align-items-center justify-content-center py-2 border-top-1">
                    <ul class="navigation__list list-unstyled d-flex my-1">
                        <li class="navigation__item">
                            <a href="{{ route('client.home') }}" class="navigation__link"
                                style="font-weight:bold;{{ Request::is('/') ? 'color: #c20f0f;font-size: 17px' : '' }}">Trang chủ</a>
                        </li>

                        <li class="navigation__item">
                            <a href="{{ route('client.shop') }}" class="navigation__link"
                                style="font-weight:bold;{{ Request::is('shop') ? 'color: #c20f0f;font-size: 17px' : '' }}">Cửa hàng</a>
                            <div class="box-menu" style="width: 1200px;">
                                @foreach ($categories as $category)
                                    <div class="col pe-4">
                                        <a href="{{ route('client.shop', ['category_id' => $category->id]) }}"
                                            class="sub-menu__title"><strong>{{ $category->name }}</strong></a>
                                        <ul class="sub-menu__list list-unstyled">
                                            @foreach ($category->children as $item)
                                                <li class="sub-menu__item">
                                                    <a href="{{ route('client.shop', ['category_id' => $item->id]) }}"
                                                        class="menu-link menu-link_us-s">{{ $item->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div><!-- /.box-menu -->
                        </li>
                        <li class="navigation__item">
                            <a href="{{ route('client.blog') }}" class="navigation__link"
                            style="font-weight:bold;{{ Request::is('blog') ? 'color: #c20f0f;font-size: 17px' : '' }}">Tin tức</a>

                        </li>
                        <li class="navigation__item">
                            <a href="{{ route('client.chatbot.index') }}" class="navigation__link"
                            style="font-weight:bold;{{ Request::is('chatbot') ? 'color: #c20f0f;font-size: 17px' : '' }}">Hỗ trợ</a>
                        </li>
                        <li class="navigation__item">
                            <a href="{{ route('client.about_us') }}" class="navigation__link"
                            style="font-weight:bold;{{ Request::is('about_us') ? 'color: #c20f0f;font-size: 17px' : '' }}">Về Aterna</a>
                        </li>
                        <li class="navigation__item">
                            <a href="{{ route('client.contact_us') }}" class="navigation__link"
                            style="font-weight:bold;{{ Request::is('contact_us') ? 'color: #c20f0f;font-size: 17px' : '' }}">Liên hệ</a>
                        </li>
                    </ul><!-- /.navigation__list -->
                </nav><!-- /.navigation -->
            </div>
        </div><!-- /.header-bottom -->
    </div><!-- /.header-desk header-desk_type_6 -->
</header>

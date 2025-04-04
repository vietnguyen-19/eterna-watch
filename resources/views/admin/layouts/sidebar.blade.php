<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link bg-info">
        <img src="{{ asset('theme/admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><b>ETERNA WATCH</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <nav class="">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li style="background-color: rgb(86, 86, 86); border-radius: 4px" class="nav-item">
                        <a href="#" class="nav-link  d-flex align-items-center" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            @if (Auth::check())
                                @if (Auth::user()->avatar && Storage::exists('public/' . Auth::user()->avatar))
                                    <img src=" {{ Storage::url(Auth::user()->avatar) }}"
                                        class="nav-icon rounded-circle me-2" alt="User Image" width="100%">
                                @else
                                    <img src="{{ asset('theme/velzon/assets/images/users/avatar-1.jpg') }}"
                                        class="nav-icon rounded-circle me-2" alt="User Image" width="100%">
                                @endif
                                <p class="fw-semibold ml-2">{{ Auth::user()->name }}</p>
                            @endif

                        </a>
                        <ul class="text-sm align-middle nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.users.show', Auth::user()->id) }}" class="nav-link">
                                    <i class="nav-icon fa-solid fa-caret-right nav-icon"></i>
                                    <p>Xem tài khoản</p>
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <li class="nav-item">
                                <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    href="" class="nav-link">
                                    <i class="nav-icon fa-solid fa-caret-right nav-icon"></i>
                                    <p>Đăng xuất</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- SidebarSearch Form -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                {{-- Bảng điều khiển --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard.revenue') }}"
                        class="nav-link {{ Request::routeIs('admin.dashboard.revenue') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-square-poll-vertical"></i>
                        <p>Bảng điều khiển</p>
                    </a>
                </li>

                {{-- Quản lý sản phẩm --}}
                <li
                    class="nav-item {{ Request::is('admin/products*') || Request::is('admin/attributes*') || Request::is('admin/categories*') || Request::is('admin/brands*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-box"></i>
                        <p>
                            Sản phẩm
                            <i class="nav-icon right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="text-sm align-middle text-sm align-middle nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.products.index') }}"
                                class="nav-link {{ Request::routeIs('admin.products.index') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-caret-right"></i>
                                <p>Danh sách sản phẩm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.categories.index') }}"
                                class="nav-link {{ Request::routeIs('admin.categories.index') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-caret-right"></i>
                                <p>Danh mục sản phẩm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.brands.index') }}"
                                class="nav-link {{ Request::routeIs('admin.brands.index') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-caret-right"></i>
                                <p>Thương hiệu sản phẩm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.attributes.index') }}"
                                class="nav-link {{ Request::routeIs('admin.attributes.index') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-caret-right"></i>
                                <p>Thuộc tính sản phẩm</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!--Quản lý Voucher-->
                <li class="nav-item {{ Request::is('admin/vouchers*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-ticket"></i>
                        <p>
                            Voucher
                            <i class="nav-icon right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="text-sm align-middle nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.vouchers.index') }}"
                                class="nav-link {{ Request::routeIs('admin.vouchers.index') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-caret-right"></i>
                                <p>Danh sách</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.vouchers.create') }}"
                                class="nav-link {{ Request::routeIs('admin.vouchers.create') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-plus"></i>
                                <p>Thêm mới</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Quản lý đơn hàng --}}
                <li class="nav-item {{ Request::is('admin/orders*') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.orders.index') }}  " class="nav-link">
                        <i class="nav-icon fa-solid fa-cart-plus"></i>
                        <p>
                            Đơn hàng
                            <i class="nav-icon right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="text-sm align-middle text-sm align-middle nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.orders.index') }}"
                                class="nav-link {{ Request::routeIs('admin.orders.index') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-caret-right"></i>
                                <p>Danh sách</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <!-- quản lý banner -->
                <li class="nav-item {{ Request::is('admin/banners*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-images"></i>
                        <p>
                            Banner
                            <i class="nav-icon right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="text-sm align-middle text-sm align-middle nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.banners.index') }}"
                                class="nav-link {{ Request::routeIs('admin.banners.index') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-caret-right"></i>
                                <p>Danh sách</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.banners.create') }}"
                                class="nav-link {{ Request::routeIs('admin.banners.create') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-plus"></i>
                                <p>Thêm mới</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Tài khoản -->
                <li
                    class="nav-item {{ Request::is('admin/users*') || Request::is('admin/permissions*') || Request::is('admin/roles*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-users"></i>
                        <p>
                            Tài khoản
                            <i class="nav-icon right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="text-sm align-middle nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}"
                                class="nav-link {{ Request::routeIs('admin.users.index') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-caret-right"></i>
                                <p>Danh sách tài khoản</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.permissions.index') }}"
                                class="nav-link {{ Request::routeIs('admin.permissions.index') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-caret-right"></i>
                                <p>Danh sách phân quyền</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.roles.index') }}"
                                class="nav-link {{ Request::routeIs('admin.roles.index') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-caret-right"></i>
                                <p>Danh sách vai trò</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Quản lý bài viết --}}
                <li class="nav-item {{ Request::is('admin/posts*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-pen-to-square"></i>
                        <p>
                            Bài viết
                            <i class="nav-icon right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="text-sm align-middle text-sm align-middle nav nav-treeview">
                        <!-- Danh sách bài viết -->
                        <li class="nav-item">
                            <a href="{{ route('admin.posts.index') }}"
                                class="nav-link {{ Request::routeIs('admin.posts.index') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-caret-right"></i>
                                <p>Danh sách bài viết</p>
                            </a>
                        </li>
                        <!-- Thêm bài viết mới -->
                        <li class="nav-item">
                            <a href="{{ route('admin.posts.create') }}"
                                class="nav-link {{ Request::routeIs('admin.posts.create') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-plus"></i>
                                <p>Thêm bài viết mới</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Bình luận --}}
                <li class="nav-item {{ Request::is('admin/comments*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-comments"></i>
                        <p>
                            Bình luận/Đánh giá
                            <i class="nav-icon right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="text-sm align-middle text-sm align-middle nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.comments.index') }}"
                                class="nav-link {{ Request::routeIs('admin.comments.index') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-caret-right"></i>
                                <p>Danh sách</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Quản lý cài đặt --}}
                <li class="nav-item {{ Request::is('admin/settings*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-gear"></i>
                        <p>
                            Cài đặt website
                            <i class="nav-icon right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="text-sm align-middle text-sm align-middle nav nav-treeview">
                        <!-- Danh sách bài viết -->
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.index') }}"
                                class="nav-link {{ Request::routeIs('admin.settings.index') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-caret-right"></i>
                                <p>Danh sách cài đặt</p>
                            </a>
                        </li>
                        <!-- Thêm bài viết mới -->
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.create') }}"
                                class="nav-link {{ Request::routeIs('admin.settings.create') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-plus"></i>
                                <p>Thêm cài đặt</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
</aside>

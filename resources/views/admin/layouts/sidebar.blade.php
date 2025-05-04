<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard.revenue') }}" class="brand-link bg-info d-flex justify-content-center align-items-center gap-2">
        <i class="fas fa-clock fa-lg text-white mr-2"></i>
        <span class="brand-text fw-bold text-white text-uppercase"><strong>Eterna Watch</strong></span>
    </a>



    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <nav class="">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li style="background-color: rgb(22, 22, 22); border-radius: 4px" class="nav-item">
                        <a href="#" class="nav-link  d-flex align-items-center" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            @if (Auth::guard('admin')->check() &&
                                    (Auth::guard('admin')->user()->role_id == 1 || Auth::guard('admin')->user()->role_id == 2))
                                <div class="d-flex align-items-center">
                                    <img src="{{ Storage::url(Auth::user()->avatar ?? 'avatars/default.jpeg') }}"
                                        class="rounded-circle me-2" alt="User Image" width="40" height="40"
                                        style="object-fit: cover; border: 1px solid #ccc;">
                                    <div class="d-flex flex-column justify-content-center ml-3">
                                        <p class="text-white fw-semibold mb-0">{{ Auth::user()->name }}</p>
                                        <small
                                            class="text-info">{{ Auth::user()->role_id == 1 ? 'Quản trị viên' : 'Nhân viên' }}</small>

                                    </div>

                                </div>
                            @endif

                        </a>
                        <ul class="text-sm align-middle nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.users.show', Auth::user()->id) }}" class="nav-link">
                                    <i class="nav-icon fa-solid fa-caret-right nav-icon"></i>
                                    <p class="text-white">Xem tài khoản</p>
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                            <li class="nav-item">
                                <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    href="" class="nav-link">
                                    <i class="nav-icon fa-solid fa-caret-right nav-icon"></i>
                                    <p class="text-white">Đăng xuất</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                {{-- Bảng điều khiển --}}
                <li style="display: {{ auth()->user()->role_id == 1 ? 'block' : 'none' }}" class="nav-item">
                    <a href="{{ route('admin.dashboard.revenue') }}"
                        class="nav-link {{ Request::routeIs('admin.dashboard.revenue') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-square-poll-vertical"></i>
                        <p>Thống kê</p>
                    </a>
                </li>
                {{-- Quản lý đơn hàng --}}
                <li class="nav-item {{ Request::is('admin/orders*') ?  'menu-open active' : '' }}">
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
                        <li class="nav-item">
                            <a href="{{ route('admin.refunds.index') }}"
                                class="nav-link {{ Request::routeIs('admin.refunds.index') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-caret-right"></i>
                                <p>Quản lí hoàn hàng</p>
                            </a>
                        </li>

                    </ul>
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
                            Mã giảm giá
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
                                <i class="nav-icon fa-solid fa-caret-right nav-icon"></i>
                                <p>Thêm mới</p>
                            </a>
                        </li>
                    </ul>
                </li>



                <!-- quản lý bann er -->
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
                                <i class="nav-icon fa-solid fa-caret-right nav-icon"></i>
                                <p>Thêm mới</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Tài khoản -->
                <li style="display: {{ auth()->user()->role_id == 1 ? 'block' : 'none' }}"
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
                            <a href="{{ route('admin.roles.index') }}"
                                class="nav-link {{ Request::routeIs('admin.roles.index') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-caret-right"></i>
                                <p>Quản lí phân quyền</p>
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
                                <i class="nav-icon fa-solid fa-caret-right nav-icon"></i>
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
                            <a href="{{ route('admin.comments.posts') }}"
                                class="nav-link {{ Request::routeIs('admin.comments.posts') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-caret-right"></i>
                                <p>Bình luận bài viết</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.comments.products') }}"
                                class="nav-link {{ Request::routeIs('admin.comments.products') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-caret-right"></i>
                                <p>Đánh giá sản phẩm</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Quản lý cài đặt --}}
                <li class="nav-item {{ Request::is('admin/contacts*') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.contacts.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-phone"></i>
                        <p>
                            Liên hệ

                        </p>
                    </a>
                </li>
                <li style="display: {{ auth()->user()->role_id == 1 ? 'block' : 'none' }}"
                    class="nav-item {{ Request::is('admin/settings*') ? 'menu-open' : '' }}">
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
                                <i class="nav-icon fa-solid fa-caret-right nav-icon"></i>
                                <p>Thêm cài đặt</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</aside>

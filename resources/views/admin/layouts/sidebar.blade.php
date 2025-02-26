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
                            <img src="{{ Storage::url('avatar/default.jpeg') }}" class="nav-icon rounded-circle me-2"
                                alt="User Image" width="100%">

                            <p class="fw-semibold ml-2">Alexander Pierce</p>
                        </a>
                        <ul class="text-sm align-middle nav nav-treeview">
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fa-solid fa-caret-right nav-icon"></i>
                                    <p>Profile</p>
                                </a>
                            </li>
                            <form id="logout-form" action="" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <li class="nav-item">
                                <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    href="#" class="nav-link">
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
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-square-poll-vertical"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item {{ Request::is('admin/categories*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-layer-group"></i>
                        <p>
                            Quản lý danh mục
                            <i class="nav-icon right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="text-sm align-middle text-sm align-middle nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.categories.index') }}"
                                class="nav-link {{ Request::routeIs('admin.categories.index') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-caret-right"></i>
                                <p>Danh sách</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.categories.create') }}"
                                class="nav-link {{ Request::routeIs('admin.categories.create') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-caret-right"></i>
                                <p>Thêm mới</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ Request::is('admin/users*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-user"></i>
                        <p>
                            Quản lý tài khoản
                            <i class="nav-icon right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="text-sm align-middle nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index', ['id' => 2]) }}"
                                class="nav-link {{ Request::routeIs('admin.users.index') && request()->id == 2 ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-caret-right"></i>
                                <p>Nhân viên</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index', ['id' => 3]) }}"
                                class="nav-link {{ Request::routeIs('admin.users.index') && request()->id == 3 ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-caret-right"></i>
                                <p>Khách hàng</p>
                            </a>
                        </li>


                    </ul>

                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

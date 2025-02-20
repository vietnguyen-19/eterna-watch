<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('theme/admin/assets/images/logo-sm.png') }}" alt=""
                    height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('theme/admin/assets/images/logo-dark.png') }}" alt=""
                    height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('theme/admin/assets/images/logo-sm.png') }}" alt=""
                    height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('theme/admin/assets/images/logo-light.png') }}" alt=""
                    height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span data-key="t-apps">Quản lý danh mục</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="apps-chat.html" class="nav-link" data-key="t-chat"> Danh sách </a>
                            </li>
                            <li class="nav-item">
                                <a href="apps-chat.html" class="nav-link" data-key="t-chat"> Thêm mới </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPro" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarPro">
                        <i class="ri-apps-2-line"></i> <span data-key="t-apps">Quản lý sản phẩm</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarPro">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="apps-chat.html" class="nav-link" data-key="t-chat"> Danh sách </a>
                            </li>
                            <li class="nav-item">
                                <a href="apps-chat.html" class="nav-link" data-key="t-chat"> Thêm mới </a>
                            </li>
                        </ul>
                    </div>
                </li>          
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApp" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span data-key="t-apps">Quản lý Permission</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApp">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions.index') }}" class="nav-link" data-key="t-chat"> Danh sách </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions.create') }}" class="nav-link" data-key="t-chat"> Thêm mới </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
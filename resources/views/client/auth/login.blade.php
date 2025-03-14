<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="author" content="flexkit">

    <link rel="shortcut icon" href="https://uomo-html.flexkitux.com/images/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com/">

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Allura&amp;display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('theme/client/css/plugins/swiper.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('theme/client/css/style.css') }}" type="text/css">
    @yield('style')

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--[if lt IE 9]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
  <![endif]-->

    <!-- Document Title -->
    <title>EternaWatch | Login</title>

    <style>
        /* Container chính */
        .login-container {
            height: 100vh;
        }

        /* Ảnh nền */
        .login-bg {
            background: url('https://images.unsplash.com/photo-1511370235399-1802cae1d32f?q=80&w=2055&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') no-repeat center center;
            background-size: cover;
            height: 100vh;
        }

        /* Form đăng nhập */
        .login-form {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            background: white;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
        }

        /* Màn hình loading */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Nội dung chính (ẩn ban đầu) */
        .content {
            display: none;
        }
    </style>
</head>

<body>
    <div class="loading-overlay" id="loadingScreen"></div>
    <div class="content" id="mainContent">
        <div class="container-fluid">
            <div class="row login-container">
                <!-- Ảnh nền -->
                <div class="col-lg-9 col-md-6 d-none d-md-block login-bg"></div>

                <!-- Form đăng nhập -->
                <div class="col-lg-3 col-md-6 col-sm-12 d-flex align-items-center justify-content-center">
                    <div class="login-form">
                        <img width="100%" src="{{ Storage::url($settings['logo_url'] ?? 'avatar/default.jpeg') }}"
                            alt="Uomo" class="mb-5">
                        <h3 class="text-uppercase text-center mb-4">Đăng nhập</h3>

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form class="aside-content" method="POST" action="{{ route('client.login') }}">
                            @csrf
                            <div class="form-floating mb-3">
                                <input name="email" type="email" class="form-control"
                                    placeholder="name@example.com">
                                <label>Email *</label>
                                @error('email')
                                    <div style="color:red">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input name="password" type="password" class="form-control"
                                    placeholder="*******">
                                <label>Mật khẩu *</label>
                                @error('password')
                                    <div style="color:red">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex mb-3">
                                <div class="form-check">
                                    <input name="remember" class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Nhớ mật khẩu</label>
                                </div>
                                <a href="{{ route('password.request') }}" class="ms-auto text-decoration-none">Quên mật
                                    khẩu?</a>
                            </div>

                            <button class="btn btn-primary w-100" type="submit">Đăng nhập</button>

                            <div class="text-center mt-3">
                                <span>Bạn chưa có tài khoản?</span>
                                <a href="{{ route('client.register') }}" class="text-decoration-none">Tạo tài khoản
                                    mới</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('theme/client/js/theme.js') }}"></script>
    <script>
        // Tạo hiệu ứng loading với Spin.js
        var target = document.getElementById("loadingScreen");
        var spinner = new Spinner({
            lines: 12, // Số tia
            length: 10, // Chiều dài tia
            width: 5, // Độ rộng tia
            radius: 20, // Bán kính vòng
            color: 'red', // Màu xanh
            speed: 1, // Tốc độ quay
            trail: 60 // Hiệu ứng đuôi
        }).spin(target);

        // Ẩn loading sau 3 giây và hiển thị nội dung chính
        setTimeout(function() {
            document.getElementById("loadingScreen").style.display = "none";
            document.querySelector(".content").style.display = "block"; // Sửa lỗi ID sai
        }, 1500);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('theme/client/js/plugins/jquery.min.js') }}"></script>
    <script src="{{ asset('theme/client/js/plugins/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('theme/client/js/plugins/bootstrap-slider.min.js') }}"></script>

    <script src="{{ asset('theme/client/js/plugins/swiper.min.js') }}"></script>
    <script src="{{ asset('theme/client/js/plugins/countdown.js') }}"></script>

    <!-- Footer Scripts -->
    <script src="{{ asset('theme/client/js/theme.js') }}"></script>

</body>

</html>

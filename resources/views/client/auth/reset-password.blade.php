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
    <title>EternaWatch | Cập nhật mật khẩu</title>

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

</head>

<body>
    <div id="loading-overlay">
        <div id="loading-spinner"></div>
    </div>
    <div class="container-fluid">
        <div class="row login-container">
            <!-- Ảnh nền -->
            <div class="col-lg-9 col-md-6 d-none d-md-block login-bg"></div>
            <!-- Form đăng nhập -->
            <div class="col-lg-3 col-md-6 col-sm-12 d-flex align-items-center justify-content-center">
                <div class="login-form">
                    <img width="100%" src="{{ Storage::url($settings['logo_url'] ?? 'avatar/default.jpeg') }}"
                        alt="Uomo" class="mb-3">
                    <h3 class="text-uppercase text-center mb-4">Cập nhật mật khẩu</h3>
                    @if (session('status'))
                        <p>{{ session('status') }}</p>
                    @endif
                    <form class="aside-content" method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-label-fixed mb-4">
                            <label for="registerEmailInput" class="form-label">Email *</label>
                            <input name="email" id="registerEmailInput" class="form-control form-control_gray"
                                type="email" placeholder="example@gmail.com" value="{{ old('email') }}">
                            @error('email')
                                <div style="color:red">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="pb-1"></div>
                        <div class="pb-1"></div>
                        <div class="form-label-fixed mb-4">
                            <label for="registerPasswordInput" class="form-label">Mật khẩu *</label>
                            <input name="password" id="registerPasswordInput" class="form-control form-control_gray"
                                type="password" placeholder="*******">
                            @error('password')
                                <div style="color:red">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="pb-1"></div>
                        <div class="form-label-fixed mb-4">
                            <label for="registerRePasswordInput" class="form-label">Nhập lại mật khẩu *</label>
                            <input name="password_confirmation" id="registerRePasswordInput"
                                class="form-control form-control_gray" type="password" placeholder="*******">
                            @error('password_confirmation')
                                <div style="color:red">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="btn btn-primary w-100 text-uppercase" type="submit">Cập nhật</button>

                        <div class="customer-option mt-4 text-center">
                            <span class="text-secondary">Bạn đã có tài khoản?</span>
                            <a href="#" class="btn-text js-show-login">Đăng nhập</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('theme/client/js/plugins/jquery.min.js') }}"></script>
    <script src="{{ asset('theme/client/js/plugins/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('theme/client/js/plugins/bootstrap-slider.min.js') }}"></script>

    <script src="{{ asset('theme/client/js/plugins/swiper.min.js') }}"></script>
    <script src="{{ asset('theme/client/js/plugins/countdown.js') }}"></script>

    <!-- Footer Scripts -->
    <script src="{{ asset('theme/client/js/theme.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/spin.js@2.3.2/spin.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var opts = {
                lines: 12,
                length: 10,
                width: 5,
                radius: 15,
                scale: 1,
                corners: 1,
                color: '#c11313',
                opacity: 0.25,
                rotate: 0,
                direction: 1,
                speed: 1,
                trail: 60,
                fps: 20,
                zIndex: 2e9,
                className: 'spinner',
                top: '50%',
                left: '50%',
                shadow: false,
                hwaccel: false,
                position: 'absolute'
            };

            var target = document.getElementById('loading-spinner');
            var spinner = new Spinner(opts).spin(target);

            // Ẩn loading sau khi trang tải xong
            setTimeout(function() {
                document.getElementById('loading-overlay').style.display = 'none';
            }, 1000);
        });
    </script>

    <style>
        #loading-overlay {
            position: fixed;
            width: 100%;
            height: 100%;
            background: #faf8f8;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
    </style>
</body>

</html>

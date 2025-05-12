<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="author" content="flexkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="https://uomo-html.flexkitux.com/images/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: url('{{ Storage::url($banners['login']->image ?? 'avatar/default.jpeg') }}') no-repeat center/cover fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .login-form {
            width: 25vw;
            /* Occupy 1/4 of the screen width */
            max-width: 600px;
            /* Prevent form from becoming too wide on large screens */
            min-width: 400px;
            /* Ensure usability on smaller desktop screens */
            background: #fff;
            border-radius: 3px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
            z-index: 2;
            overflow: hidden;
            border-top: 6px solid #d32f2f;
            margin: 0 auto;
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #eee;
            padding: 2rem 1.5rem 1rem;
            text-align: center;
        }

        .logo-container {
            width: 200px;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-container img {
            width: 100%;
            object-fit: contain;
        }

        .card-body {
            padding: 2rem;
            text-align: center;
        }

        .btn-primary {
            background: #d32f2f;
            border: none;
            padding: 0.75rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .btn-primary:hover {
            background: #b71c1c;
        }

        .form-floating label {
            color: #777;
        }

        .form-control:focus {
            border-color: #d32f2f;
            box-shadow: 0 0 0 0.2rem rgba(211, 47, 47, 0.2);
        }

        .loading-overlay {
            position: fixed;
            inset: 0;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .content {
            display: none;
        }

        @media (max-width: 768px) {
            .login-form {
                width: 90%;
                /* Use more width on smaller screens */
                min-width: 300px;
                /* Adjust for smaller screens */
                margin: 1rem;
            }

            .logo-container {
                width: 60px;
                height: 60px;
            }
        }
    </style>

    <title>EternaWatch | Đăng nhập</title>
</head>

<body>
    <div class="loading-overlay" id="loadingScreen"></div>

    <div class="content" id="mainContent">
        <div class="card login-form">
            <div class="card-header">
                <div class="logo-container">
                    <img src="{{ Storage::url($settings['logo_url'] ?? 'avatar/default.jpeg') }}"
                        alt="EternaWatch Logo">
                </div>
            </div>
            <div class="card-body">
                <h4 class="fw-bold text-dark mb-2">ĐĂNG NHẬP</h4>
                @if (session('status'))
                    <div class="alert alert-success small mb-3">{{ session('status') }}</div>
                @endif
               @if (session('account_disabled'))
    <div class="alert alert-danger small mb-3">
        Tài khoản của bạn đã bị vô hiệu hóa. Vui lòng liên hệ quản trị viên để biết thêm chi tiết.
    </div>
    @php
        Session::forget('account_disabled'); // XÓA session sau khi hiển thị
    @endphp
@endif



                <form method="POST" action="{{ route('client.login') }}">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control" placeholder="name@example.com"
                            value="{{ old('email') }}">
                        <label for="email">Email *</label>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control" placeholder="*******">
                        <label for="password">Mật khẩu *</label>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember">
                            <label class="form-check-label small" for="remember">Nhớ mật khẩu</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="small text-muted text-decoration-none">Quên mật
                            khẩu?</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>

                    <div class="text-center mt-3">
                        <small class="text-muted">Bạn chưa có tài khoản?</small>
                        <a href="{{ route('client.register') }}" class="text-primary text-decoration-none small">Tạo tài
                            khoản mới</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Spinner + Bootstrap + Custom Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>
    <script>
        const target = document.getElementById("loadingScreen");
        const spinner = new Spinner({
            lines: 12,
            length: 10,
            width: 4,
            radius: 20,
            color: '#d32f2f',
            speed: 1,
            trail: 60
        }).spin(target);

        setTimeout(() => {
            document.getElementById("loadingScreen").style.display = "none";
            document.getElementById("mainContent").style.display = "block";
        }, 1500);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('theme/client/js/plugins/jquery.min.js') }}"></script>
    <script src="{{ asset('theme/client/js/plugins/swiper.min.js') }}"></script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eterna Watch | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('theme/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('theme/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('theme/admin/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ route('client.home') }}" class="h1"><b>Eterna Watch</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Cập nhật mật khẩu</p>

                @if (session('status'))
                    <p>{{ session('status') }}</p>
                @endif
                <form class="aside-content" method="POST" action="{{ route('admin.password.update') }}">
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

                <p class="my-1 text-center">
                    <a href="{{ route('admin.password.request') }}">Quên mật khẩu!</a>
                </p>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('theme/admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('theme/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('theme/admin/dist/js/adminlte.min.js') }}"></script>
</body>
</html>

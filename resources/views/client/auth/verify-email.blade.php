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


</head>

<body>
    <div id="loading-overlay">
        <div id="loading-spinner"></div>
    </div>
    <div class="container-fluid">
        <div class="mb-4 mb-xl-5 pt-xl-1 pb-5"></div>
        <main>
            <section class="page-not-found">
                <div class="content container">
                    <h3>Vui lòng xác nhận email của bạn</h3>
                    <p>Một email xác nhận đã được gửi tới email của bạn.</p>

                    @if (session('message'))
                        <p>{{ session('message') }}</p>
                    @endif

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button class="btn btn-primary" type="submit">Gửi lại email xác nhận</button>
                    </form>
                </div>
            </section>
        </main>
        <div class="mb-5 pb-xl-5"></div>
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

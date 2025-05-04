<!DOCTYPE html>
<html dir="ltr" lang="zxx">

<!-- Mirrored from uomo-html.flexkitux.com/Demo19/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Mar 2025 02:20:03 GMT -->

<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="author" content="flexkit">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('storage\images\favicon-eterna-removebg-preview.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="https://uomo-html.flexkitux.com/images/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com/">

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Allura&amp;display=swap" rel="stylesheet">
    <!-- Font Awesome 6 (Mới nhất) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('theme/client/css/plugins/swiper.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('theme/client/css/style.css') }}" type="text/css">
    @yield('style')

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--[if lt IE 9]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
  <![endif]-->

    <!-- Document Title -->
    <title>Eterna Watch</title>
    <style>
        .dropdown-item.login:hover {
            color: rgb(168, 19, 19) !important;
            background: #e7dede
        }

        .header-desk_type_8 {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: white;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            z-index: 1000;
        }
    </style>
</head>

<body>
    <div id="loading-overlay">
        <div id="loading-spinner"></div>
    </div>
    @include('client.layouts.svg')
    <!-- Mobile Header -->

    <!-- End Header Type 1 -->
    @include('client.layouts.header')
    @yield('content')


    <!-- Footer Type 1 with Top block -->
    @include('client.layouts.footer')


    <!-- Customer Login Form -->

    @include('client.layouts.other')


    <!-- Go To Top -->
    <div id="scrollTop" class="visually-hidden end-0"></div>

    <!-- Page Overlay -->
    <div class="page-overlay"></div><!-- /.page-overlay -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let lastScrollTop = 0;
            const header = document.querySelector(".header-desk_type_8");

            window.addEventListener("scroll", function() {
                let scrollTop = window.scrollY || document.documentElement.scrollTop;

                if (scrollTop > lastScrollTop) {
                    // Cuộn xuống -> Ẩn header
                    header.style.transform = "translateY(-100%)";
                } else {
                    // Cuộn lên -> Hiện header
                    header.style.transform = "translateY(0)";
                }

                lastScrollTop = scrollTop;
            });
        });
    </script>

    <!-- External JavaScripts -->
    <script src="{{ asset('theme/client/js/plugins/jquery.min.js') }}"></script>

    @yield('script')
    <script src="{{ asset('theme/client/js/plugins/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('theme/client/js/plugins/bootstrap-slider.min.js') }}"></script>

    <script src="{{ asset('theme/client/js/plugins/swiper.min.js') }}"></script>
    <script src="{{ asset('theme/client/js/plugins/countdown.js') }}"></script>

    <!-- Footer Scripts -->
    <script src="{{ asset('theme/client/js/theme.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/spin.js@2.3.2/spin.min.js"></script>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/6811ddbbcba56419020bf532/1iq2sk9hc';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

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
    @include('client.layouts.messenger')


    <div class="gtranslate_wrapper"></div>
    <script>
      window.gtranslateSettings = {
        default_language: "vi",
        languages: ["vi", "en", "zh-CN"],
        wrapper_selector: ".gtranslate_wrapper",
        alt_flags: { en: "usa" },
      };
    </script>
    <script
      src="https://cdn.gtranslate.net/widgets/latest/float.js"
      defer
    ></script>

</body>

<!-- Mirrored from uomo-html.flexkitux.com/Demo19/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Mar 2025 02:20:34 GMT -->

</html>

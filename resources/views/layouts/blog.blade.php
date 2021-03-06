<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-D507CJCC5K"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-D507CJCC5K');
    </script>

    {{-- Title WEB --}}
    {{-- <title>@yield('title') - {{ $setting->site_name }}</title> --}}
    {{-- Meta Tag --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- {!! SEO::generate() !!} --}}
    {!! SEOMeta::generate(true) !!}
    {!! OpenGraph::generate(true) !!}
    {!! Twitter::generate(true) !!}
    {!! JsonLd::generate(true) !!}
    {!! JsonLdMulti::generate(true) !!}
    {{-- Logo / icon --}}
    <link rel="shortcut icon" href="{{ asset('logo-web/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo-web/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo-web/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo-web/favicon-16x16.png') }}">
    {{-- Assets CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/alertify/css/alertifi.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/jquery-ui/jquery-ui.css') }}">
    {{-- Icon --}}
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/icofont/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/fontawesome/css/all.min.css') }}">
    {{-- jQuery Ui --}}
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/jquery-ui/jquery-ui.css') }}">
    {{-- Main CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/blog/css/st.css') }}">
    {{-- CSS EXT --}}
    @stack('css-external')
    {{-- CSS INT --}}
    @stack('css-internal')
    <!--
    -- Credits --
    <a href="https://www.flaticon.com/free-icons/search" title="search icons">Search icons created by Freepik - Flaticon</a>
    <a href="https://www.flaticon.com/free-icons/video-game" title="video game icons">Video game icons created by juicy_fish - Flaticon</a>
    <a href="https://www.flaticon.com/free-icons/code" title="code icons">Code icons created by Freepik - Flaticon</a>
    <a href="https://www.flaticon.com/free-icons/app-development" title="app development icons">App development icons created by Assia Benkerroum  - Flaticon</a>
    <a href="https://www.flaticon.com/free-icons/developer" title="developer icons">Developer icons created by Freepik - Flaticon</a>
    -->

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Anek+Latin:wght@300;500;700&family=Lato:ital,wght@0,300;0,400;0,700;1,300;1,700&family=Noto+Sans+Display:ital,wght@0,300;0,400;0,500;0,700;1,400&family=Noto+Sans+JP:wght@300;400;700&family=Poppins:ital,wght@0,300;0,500;0,700;1,300;1,500&family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,400&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,500&family=Rubik:ital,wght@0,300;0,500;0,600;1,300;1,500&display=swap');
    </style>
</head>

<body>
    <div class="notif-success" data-notif="{{ Session::get('success') }}"></div>

    @include('layouts._layouts.navbar')

    <main id="main">
        <section id="main-blog" class="main-blog">
            @yield('content')
        </section>
    </main>

    @include('layouts._layouts.footer')

    {{-- <a href="#" class="to-the-top btn-tooltip-hide" data-toggle="tooltip" data-placement="left" title="Keatas">
        <i class="uil uil-angle-up"></i>
    </a> --}}

    {{-- Assets JS --}}
    <script src="{{ asset('vendor/blog/assets/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/jquery-sticky/jquery.sticky.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/jquery.easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/sharerjs/sharer.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/prehighlight/prehighlights.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/alertify/js/alertify.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/js/medium-zoom.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/jquery-mousewheel/jquery.mousewheel.min.js') }}"></script>
    {{-- Main Js --}}
    <script src="{{ asset('vendor/blog/js/app.js') }}"></script>
    {{-- JS Ext --}}
    {{-- @stack('js-external') --}}
    {{-- JS Int --}}
    @stack('js-internal')
    {{-- Script --}}
    <script>
        function buttonBack(targetUrl) {
            var currentUrl = window.location.href;
            window.history.go(-1);
            setTimeout(function() {
                if (currentUrl === window.location.href) {
                    window.location.href = targetUrl;
                }
            }, 100);
        }

        window.onload = function() {
            if (!localStorage.justOnce) {
                localStorage.setItem("justOnce", "true");
                window.location.reload();
            }
        }

        setTimeout(() => {
            history.replaceState('', document.title, window.location.origin + window
                .location.pathname + window
                .location.search);
        }, 100);

        const notif = $('.notif-success').data('notif');
        if (notif) {
            alertify
                .delay(5000)
                .log(notif);
        }

        document.getElementById('buttonBack').onclick = function() {
            window.location = document.referrer;
        }

        $(".btn-tooltip-hide").tooltip().on("click", function() {
            $(this).tooltip("hide")
        });
    </script>
</body>

</html>

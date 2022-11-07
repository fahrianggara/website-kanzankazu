<!DOCTYPE html>

<html lang="id">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-TKJXQ59K5W"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-TKJXQ59K5W');
    </script>
    {{-- Primary Meta Tags --}}
    {!! SEO::generate(true) !!}

    <meta name="author" content="{{ $setting->site_name }}">
    <meta name="keywords" content="{{ $setting->meta_keywords }}">
    <meta property="og:image" content="@yield('image', asset('vendor/blog/img/default.png'))">
    <meta property="og:site_name" content="{{ $setting->site_name }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Logo / icon --}}
    <link rel="shortcut icon" href="{{ asset('logo-web/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo-web/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo-web/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo-web/favicon-16x16.png') }}">
    {{-- Assets CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/venobox/venobox.css') }}" media="screen" />
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/owl.carousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/alertify/css/alertifi.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/jquery-ui/jquery-ui.css') }}">
    {{-- Icon --}}
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/icofont/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    {{-- Main CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/blog/css/style.css') }}">
    {{-- CSS EXT --}}
    @stack('css-external')
    {{-- CSS INT --}}
    @stack('css-internal')
</head>

<body>
    <div class="notif-success" data-notif="{{ Session::get('success') }}"></div>

    {{-- SLIDE --}}
    {{-- @include('home.slide') --}}

    {{-- HEADER --}}
    @include('layouts._layouts.navbar')

    <main id="main">
        @if (Session::has('status'))
            <div class="status-success" data-status="{{ Session::get('status') }}"></div>
        @endif

        {{-- ABOUT --}}
        {{-- @include('home.about') --}}

        {{-- SOCIAL MEDIA --}}
        {{-- @include('home.social-media') --}}

        {{-- Banner --}}
        @include('home.banner')

        {{-- BLOG --}}
        @include('home.blog')

        {{-- TUTORIAL --}}
        @include('home.tutorial')

        {{-- CATEGORIES --}}
        @include('home.category')

        {{-- GALLERY --}}
        {{-- @include('home.gallery') --}}

        {{-- CONTACT --}}
        {{-- @include('home.contact') --}}


    </main>

    {{-- FOOTER --}}
    @include('layouts._layouts.footer')

    {{-- Chat app masih dalam perbaikan --}}
    {{-- @include('layouts._layouts.chat.index') --}}

    <a href="#" class="to-the-top btn-tooltip-hide" data-toggle="tooltip" data-placement="left" title="Keatas">
        <i class="uil uil-angle-up"></i>
    </a>

    {{-- Assets JS --}}
    <script src="{{ asset('vendor/blog/assets/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/jquery.easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/jquery-sticky/jquery.sticky.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/alertify/js/alertify.js') }}"></script>
    {{-- Main Js --}}
    <script src="{{ asset('vendor/blog/js/main.js') }}"></script>
    {{-- JS Ext --}}
    @stack('js-external')
    {{-- JS Int --}}
    @stack('js-internal')

    <script>
        window.onload = function() {
            if (!localStorage.justOnce) {
                localStorage.setItem("justOnce", "true");
                window.location.reload();
            }
        }

        $(function() {})
        $("[data-toggle='tooltip']").tooltip().on("click", function() {
            $(this).tooltip("hide")
        });


        // Notif status
        const notif = $('.notif-success').data('notif');
        if (notif) {
            alertify
                .delay(5000)
                .log(notif);
        }
        const status = $('.status-success').data('status');
        if (status) {
            alertify
                .delay(7000)
                .log(status);
        }
    </script>
</body>

</html>

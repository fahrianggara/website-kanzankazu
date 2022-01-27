<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Primary Meta Tags --}}
    <title>Personal Blog - {{ config('app.name') }}</title>
    <meta name="title" content="Personal Blog - {{ config('app.name') }}">
    <meta name="description" content="Hello, my name is Fahri Anggara, you can call me Angga. I hope you enjoy my Website!
        okay.. First I will explain.. why I made this website? because I like coding. Well my hobby is coding, 
        it's very fun.">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="keywords" content="Personal, Blog, Angga, Fahri Anggara, Personal Website">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:title" content="Personal Blog - {{ config('app.name') }}">
    <meta property="og:description" content="Hello, my name is Fahri Anggara, you can call me Angga. I hope you enjoy my Website!
        okay.. First I will explain.. why I made this website? because I like coding. Well my hobby is coding, 
        it's very fun.">
    <meta property="og:image" content="{{ asset('vendor/my-blog/img/home-img/about.jpeg') }}">
    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ config('app.url') }}">
    <meta property="twitter:title" content="Personal Blog - {{ config('app.name') }}">
    <meta property="twitter:description" content="Hello, my name is Fahri Anggara, you can call me Angga. I hope you enjoy my Website!
        okay.. First I will explain.. why I made this website? because I like coding. Well my hobby is coding, 
        it's very fun.">
    <meta property="twitter:image" content="{{ asset('vendor/my-blog/img/home-img/about.jpeg') }}">

    {{-- Logo --}}
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    {{-- Assets CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/assets/venobox/venobox.css') }}" media="screen" />
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/assets/owl.carousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/css/all-web.css') }}">
    {{-- Alertify --}}
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/assets/alertify/css/alertifi.css') }}">
    {{-- Icon --}}
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/assets/icofont/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/assets/boxicons/css/boxicons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/assets/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/assets/fontawesome/css/all.min.css') }}">
    {{-- Main CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/css/css.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/css/w3school.css') }}">
    {{-- CSS EXT --}}
    @stack('css-external')
    {{-- CSS INT --}}
    @stack('css-internal')
    {{-- JQUERY --}}
    <script src="{{ asset('vendor/my-blog/assets/jquery/jquery.min.js') }}"></script>
</head>

<body onload="init()">
    {{-- SLIDE --}}
    @include('home.slide')
    {{-- HEADER --}}
    @include('layouts._home.navbar')

    <main id="main">

        {{-- ABOUT --}}
        @include('home.about')
        {{-- SOCIAL MEDIA --}}
        @include('home.social-media')
        {{-- QUOTES --}}
        @include('home.quotes')
        {{-- BLOG --}}
        @include('home.blog')
        {{-- GALLERY --}}
        @include('home.gallery')
        {{-- CONTACT --}}
        @include('home.contact')

    </main>

    {{-- FOOTER --}}
    @include('layouts._blog.footer')

    <a href="#" class="to-the-top btn-tooltip-hide" data-toggle="tooltip" data-placement="left"
        title="{{ trans('blog.tooltip.top') }}">
        <i class="uil uil-angle-up"></i>
    </a>

    {{-- Assets JS --}}
    <script src="{{ asset('vendor/my-blog/assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/my-blog/assets/jquery.easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('vendor/my-blog/assets/jquery-sticky/jquery.sticky.js') }}"></script>
    <script src="{{ asset('vendor/my-blog/assets/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendor/my-blog/assets/venobox/venobox.min.js') }}"></script>
    <script src="{{ asset('vendor/my-blog/assets/owl.carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('vendor/my-blog/assets/alertify/js/alertify.js') }}"></script>
    {{-- Main Js --}}
    <script src="{{ asset('vendor/my-blog/js/main.js') }}"></script>

    {{-- JS Ext --}}
    @stack('js-external')
    {{-- JS Int --}}
    @stack('js-internal')

    <script>
        $(document).ready(function() {
            $(".btn-tooltip-hide").tooltip().on("click", function() {
                $(this).tooltip("hide")
            });

            // Remove anchor with 0 sec
            setTimeout(() => {
                history.replaceState('', document.title, window.location.origin + window
                    .location.pathname + window
                    .location.search);
            }, 0);
        });
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="id">

<head>
    {{-- Title WEB --}}
    <title>@yield('title') - {{ $setting->site_name }}</title>
    {{-- Meta Tag --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="@yield('title') - {{ $setting->site_name }}">
    <meta name="description" content="@yield('description', $setting->site_description)">
    <meta name="keywords" content="@yield('keywords', $setting->meta_keywords)">
    <meta name="language" content="id">
    <meta name="author" content="@yield('author', $setting->site_name)">
    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="@yield('url', url()->current())">
    <meta property="og:title" content="@yield('title') - {{ $setting->site_name }}">
    <meta property="og:description" content="@yield('description', $setting->site_description)">
    <meta property="og:image" content="@yield('image', asset('vendor/blog/img/default.png'))">
    <meta property="og:site_name" content="{{ $setting->site_name }}">
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
    <link rel="stylesheet" href="{{ asset('vendor/blog/css/mai.css') }}">
    {{-- CSS EXT --}}
    @stack('css-external')
    {{-- CSS INT --}}
    @stack('css-internal')

    <style>
        .ribbon-wrapper {
            width: 85px;
            height: 88px;
            overflow: hidden;
            position: absolute;
            top: -3px;
            right: -3px
        }

        .ribbon {
            font-size: 12px;
            color: #FFF;
            text-transform: uppercase;
            font-family: 'Montserrat Bold', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            letter-spacing: .05em;
            line-height: 15px;
            text-align: center;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, .4);
            -webkit-transform: rotate(45deg);
            -moz-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            -o-transform: rotate(45deg);
            transform: rotate(45deg);
            position: relative;
            padding: 7px 0;
            right: -11px;
            top: 10px;
            width: 100px;
            height: 28px;
            -webkit-box-shadow: 0 0 3px rgba(0, 0, 0, .3);
            box-shadow: 0 0 3px rgba(0, 0, 0, .3);
            background-color: #dedede;
            background-image: -webkit-linear-gradient(top, #ffffff 45%, #dedede 100%);
            background-image: -o-linear-gradient(top, #ffffff 45%, #dedede 100%);
            background-image: linear-gradient(to bottom, #ffffff 45%, #dedede 100%);
            background-repeat: repeat-x;
            filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffdedede', GradientType=0)
        }

        .ribbon:before,
        .ribbon:after {
            content: "";
            border-top: 3px solid #9e9e9e;
            border-left: 3px solid transparent;
            border-right: 3px solid transparent;
            position: absolute;
            bottom: -3px
        }

        .ribbon:before {
            left: 0
        }

        .ribbon:after {
            right: 0
        }
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

    <a href="#" class="to-the-top btn-tooltip-hide" data-toggle="tooltip" data-placement="left" title="Keatas">
        <i class="uil uil-angle-up"></i>
    </a>

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
    {{-- Main Js --}}
    <script src="{{ asset('vendor/blog/js/main.js') }}"></script>
    {{-- JS Ext --}}
    {{-- @stack('js-external') --}}
    {{-- JS Int --}}
    @stack('js-internal')
    {{-- Script --}}
    <script>
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

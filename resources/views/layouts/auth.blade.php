<!DOCTYPE html>
<html lang="id">

<head>
    {{-- Meta --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="@yield('title') - {{ $setting->site_name }}">
    <meta name="description" content="@yield('description', $setting->site_description)">
    <meta name="keywords" content="@yield('keywords', $setting->meta_keywords)">
    <meta name="language" content="id">
    <meta name="author" content="@yield('author', $setting->site_name)">

    <meta property="og:title" content="@yield('title') - {{ $setting->site_name }}" />
    <meta property="og:description" content="{{ $setting->site_description }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="@yield('image')" />
    {{-- Title --}}
    <title>@yield('title') - {{ $setting->site_name }}</title>
    {{-- Logo / icon --}}
    <link rel="shortcut icon" href="{{ asset('logo-web/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo-web/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo-web/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo-web/favicon-16x16.png') }}">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/blog/css/signs.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/bootstrap-icon/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="{{ asset('vendor/dashboard/plugins/alertify/css/alerts.css') }}">
    @stack('css')
</head>

<body>

    <div class="notif-error" data-notip="{{ session('error') }}"></div>

    @yield('content')

    <script src="{{ asset('vendor/blog/assets/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/js/log.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/plugins/alertify/js/alerts.js') }}"></script>

    <script>
        const notif = $('.notif-success').data('notif');
        if (notif) {
            alertify
                .delay(7000)
                .log(notif);
        }
        const notip = $('.notif-error').data('notip');
        if (notip) {
            alertify
                .delay(5000)
                .error(notip);
        }

        window.onload = function() {
            if (!localStorage.justOnce) {
                localStorage.setItem("justOnce", "true");
                window.location.reload();
            }
        }

        $("[data-toggle='tooltip']").tooltip().on("click", function() {
            $(this).tooltip("hide")
        });

        function buttonBack(targetUrl) {
            var currentUrl = window.location.href;
            window.history.go(-1);
            setTimeout(function() {
                if (currentUrl === window.location.href) {
                    window.location.href = targetUrl;
                }
            }, 100);
        }
    </script>

    @stack('js')
</body>

</html>

<!DOCTYPE html>
<html lang="id">

<head>
    {{-- Meta --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta content="Login" name="description">
    <meta content="Fahri Anggara" name="author">
    {{-- Title --}}
    <title>@yield('title')</title>
    {{-- Logo / icon --}}
    <link rel="shortcut icon" href="{{ asset('logo-web/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo-web/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo-web/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo-web/favicon-16x16.png') }}">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/blog/css/log.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/bootstrap-icon/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    {{-- jQuery --}}
    <script src="{{ asset('vendor/blog/assets/jquery/jquery.min.js') }}"></script>
    @stack('css')
</head>

<body>

    @yield('content')

    {{-- jS --}}
    <script src="{{ asset('vendor/blog/assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/js/login.js') }}"></script>

    <script>
        window.onload = function() {
            if (!localStorage.justOnce) {
                localStorage.setItem("justOnce", "true");
                window.location.reload();
            }
        }
    </script>

    @stack('js')
</body>

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta content="Login" name="description">
    <meta content="Fahri Anggara" name="author">

    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('vendor/my-blog/css/ss.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/assets/bootstrap-icon/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <script src="{{ asset('vendor/my-blog/assets/jquery/jquery.min.js') }}"></script>
</head>

<body>

    @yield('content')

    {{-- jS --}}
    <script src="{{ asset('vendor/my-blog/assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/my-blog/js/log.js') }}"></script>

    @stack('js')
</body>

</html>

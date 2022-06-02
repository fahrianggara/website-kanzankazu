<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- Tittle --}}
    <title>500 Internal Server Error</title>
    {{-- Meta --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Logo / icon --}}
    <link rel="shortcut icon" href="{{ asset('logo-web/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo-web/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo-web/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo-web/favicon-16x16.png') }}">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/blog/css/error.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/fontawesome/css/all.min.css') }}">
    <script src="{{ asset('vendor/blog/assets/jquery/jquery.min.js') }}"></script>

</head>

<body>
    <div id="notFound">
        <div class="notFound">
            <div class="notFound_404">
                <h1>500</h1>
            </div>
            <h2>Internal Server Error</h2>
            <p>
                Sorry! Something went wrong on our server, please try again later.
            </p>
            <a id='buttonBack' class="buttonError" href="" id="refreshpage">Refresh</a>
        </div>
    </div>

    <script>
        document.getElementById('buttonBack').onclick = function() {
            window.location = document.referrer;
        }
    </script>
</body>

</html>

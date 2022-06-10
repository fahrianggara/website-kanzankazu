<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- Title --}}
    <title>404 Page Not Found</title>
    {{-- Meta --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Logo / icon --}}
    <link rel="shortcut icon" href="{{ asset('logo-web/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo-web/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo-web/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo-web/favicon-16x16.png') }}">
    {{-- CCSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/blog/css/error.css') }}" />
</head>

<body>
    <div id="notFound">
        <div class="notFound">
            <div class="notFound_404">
                <h1>4<span></span>4</h1>
            </div>
            <h2>{{ trans('error.404-title') }}</h2>
            <p>
                {{ trans('error.404-description') }}
            </p>
            <a id="buttonBack" class="buttonError" href="">Back</a>
        </div>
    </div>
</body>

</html>

<script>
    document.getElementById('buttonBack').onclick = function() {
        window.location = document.referrer;
    }
</script>

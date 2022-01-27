<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 Page Not Found</title>
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/css/error.css') }}" />
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
            <a class="buttonError" href="javascript:history.back()">Back</a>
        </div>
    </div>
</body>

</html>

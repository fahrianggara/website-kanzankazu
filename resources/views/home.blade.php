<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Multi Language</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
        integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>

    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            Multi Language
        </a>

        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="language" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    @switch(app()->getLocale())
                        @case('id')
                            <span>IND</span>
                        @break
                        @case('en')
                            <span>ENG</span>
                        @break
                        @default
                    @endswitch
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="language">
                    <a class="dropdown-item"
                        href="{{ route('localization.switch', ['language' => 'id']) }}">{{ trans('localization.id') }}</a>
                    <a class="dropdown-item"
                        href="{{ route('localization.switch', ['language' => 'en']) }}">{{ trans('localization.en') }}</a>
                </div>
            </li>
        </ul>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>

</body>

</html>

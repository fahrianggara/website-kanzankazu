<!DOCTYPE html>
<html lang="id">

<head>
    {{-- Meta --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Forgot Password - {{ $setting->site_name }}">
    <meta name="description" content="@yield('description', $setting->site_description)">
    <meta name="keywords" content="@yield('keywords', $setting->meta_keywords)">
    <meta name="language" content="id">
    <meta name="author" content="@yield('author', $setting->site_name)">
    {{-- Title --}}
    <title>Forgot Password</title>
    {{-- Logo / icon --}}
    <link rel="shortcut icon" href="{{ asset('logo-web/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo-web/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo-web/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo-web/favicon-16x16.png') }}">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/blog/css/logs.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/bootstrap-icon/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/alertify/css/alertifi.css') }}">
    {{-- jQuery --}}
    <script src="{{ asset('vendor/blog/assets/jquery/jquery.min.js') }}"></script>
    @stack('css')
</head>

<body>
    <div class="notif-success" data-notif="{{ session('status') }}"></div>

    <div class="container">
        <div class="row px-3">
            <div class="col-lg-10 col-xl-9 card flex-row mx-auto px-0">
                <div class="img-left d-none d-md-flex"></div>

                <div class="card-body">

                    <div class="change-theme">
                        <i class="uil uil-moon btn-tooltip-hide" data-toggle="tooltip" data-placement="left"
                            title="Ganti Tema" id="theme-toggle">
                        </i>
                    </div>

                    <h4 class="title text-center mt-4">
                        Forgot Password
                    </h4>

                    {{-- Form Input --}}
                    <form action="{{ route('password.email') }}" method="POST" class="form-box px-3">
                        @csrf

                        {{-- Email --}}
                        <div class="form-input">
                            <div class="iconForm"><i class="uil uil-envelope"></i></div>
                            <input type="email" id="email"
                                class="form_control @error('email') is-invalid @enderror" name="email"
                                value="{{ Auth::user()->email ?? old('email') }}" autocomplete="off" autofocus>
                            <label for="email">Email kamu</label>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        @if (session('status'))
                            <div class="mb-3">
                                <button type="submit" disabled class="btn btn-block text-uppercase">
                                    Silahkan cek email kamu
                                </button>
                            </div>
                        @else
                            <div class="mb-3">
                                <button type="submit" class="btn btn-block text-uppercase">
                                    Submit
                                </button>
                            </div>
                        @endif


                        <hr class="my-4 hr">

                        <div class="text-center mb-2">
                            <a href="{{ route('homepage') }}" class="mr-1 register-link">
                                Beranda
                            </a>
                            |
                            <a href="{{ route('login') }}" class="ml-1 register-link">
                                Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- jS --}}
    <script src="{{ asset('vendor/blog/assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/js/login.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/alertify/js/alertify.js') }}"></script>

    <script>
        window.onload = function() {
            if (!localStorage.justOnce) {
                localStorage.setItem("justOnce", "true");
                window.location.reload();
            }
        }

        // Notif status
        const notif = $('.notif-success').data('notif');
        if (notif) {
            alertify
                .delay(7000)
                .log(notif);
        }
    </script>

    @stack('js')
</body>

</html>

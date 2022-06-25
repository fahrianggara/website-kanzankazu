<!DOCTYPE html>
<html lang="id">

<head>
    {{-- Meta --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Reset Password - {{ $setting->site_name }}">
    <meta name="description" content="@yield('description', $setting->site_description)">
    <meta name="keywords" content="@yield('keywords', $setting->meta_keywords)">
    <meta name="language" content="id">
    <meta name="author" content="@yield('author', $setting->site_name)">
    {{-- Title --}}
    <title>Reset Password</title>
    {{-- Logo / icon --}}
    <link rel="shortcut icon" href="{{ asset('logo-web/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo-web/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo-web/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo-web/favicon-16x16.png') }}">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/blog/css/logs.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/bootstrap-icon/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/alertify/css/alertifi.css') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    {{-- jQuery --}}
    <script src="{{ asset('vendor/blog/assets/jquery/jquery.min.js') }}"></script>
</head>

<body>
    <div class="notif-success" data-notif="{{ Session::get('success') }}"></div>

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
                        Reset Password
                    </h4>

                    {{-- Form Input --}}
                    <form action="{{ route('password.update') }}" method="POST" class="form-box px-3">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        {{-- Email --}}
                        <div class="form-input">
                            <div class="iconForm"><i class="uil uil-envelope"></i></div>
                            <input id="email" type="email" class="form_control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="off" autofocus>
                            <label for="email">Email kamu</label>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="form-input">
                            <div class="iconForm"><i class="uil uil-key-skeleton-alt"></i></div>
                            <input id="password" type="password"
                                class="form_control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">
                            <label for="password">Password baru</label>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Password confirm --}}
                        <div class="form-input">
                            <div class="iconForm"><i class="uil uil-key-skeleton-alt"></i></div>
                            <input id="password-confirm" type="password" class="form_control"
                                name="password_confirmation" required autocomplete="new-password">
                            <label for="password">Konfirmasi</label>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-block text-uppercase">
                                Reset Password
                            </button>
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
                .delay(5000)
                .log(notif);
        }
    </script>
</body>

</html>

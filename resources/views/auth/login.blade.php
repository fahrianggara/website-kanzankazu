@extends('layouts.auth')

@section('title', 'Login')

@section('keywords')
    login kanzankazu
@endsection

@section('image')
    {{ asset('vendor/blog/img/auth-img/signup.svg') }}
@endsection

@section('content')
    @if (Session::has('success'))
        <div class="notif-success" data-notif="{{ Session::get('success') }}"></div>
    @endif
    @if (Session::has('infoban'))
        <div class="info-ban" data-info="{{ Session::get('infoban') }}"></div>
    @endif

    <div class="container">
        <div class="row px-3">
            <div class="col-lg-10 col-xl-9 card flex-row mx-auto px-0">
                <div class="d-none d-md-flex">
                    <img src="{{ asset('vendor/blog/img/auth-img/signup.svg') }}" class="img-login">
                </div>

                <div class="card-body">

                    @include('auth.nav')

                    <h4 class="title text-center mt-4">
                        Login
                    </h4>

                    {{-- alert warning --}}
                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    {{-- Form Input --}}
                    <form action="{{ route('login') }}" method="POST" class="form-box px-3">
                        @csrf

                        {{-- Email --}}
                        <div class="form-input">
                            <div class="iconForm"><i class="uil uil-envelope"></i></div>
                            <input type="email" id="email" class="form_control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" autocomplete="off" autofocus>
                            <label for="email">Email</label>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        {{-- Password --}}
                        <div class="form-input">
                            <div class="iconForm"><i class="uil uil-key-skeleton"></i></div>

                            <input type="password" class="form_control @error('password') is-invalid @enderror"
                                id="password" type="password" name="password" autocomplete="off">
                            <label for="password">Password</label>

                            <div class="passTog"><i class="bi bi-eye-slash-fill" id="togglePassword"></i></div>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="remember" name="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="remember">{{ __('Remember Me') }}</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <button id="loginUser" type="submit" class="btn btn-block text-uppercase">
                                Login
                            </button>
                        </div>

                        <hr data-content="OR" class="hr-text">

                        <div class="d-flex mt-4 justify-content-center">

                            <div id="tooltipGoogle" class="orLogin mr-4" data-toggle="tooltip" data-placement="top"
                                title="Login dengan Google">
                                <a id="signWithGoogle" href="javascript:void(0)" class="loginGoogle">
                                    <img class="logo-provider" src="{{ asset('vendor/blog/img/google.png') }}"
                                        width="27">
                                </a>
                            </div>

                            <div id="tooltipAnonym" class="orLogin mr-4" data-toggle="tooltip" data-placement="top"
                                title="Login dengan Anonymous">
                                <a id="signWithAnonym" href="javascript:void(0)" class="loginAnonym">
                                    <img class="logo-provider" src="{{ asset('vendor/blog/img/anonymous.png') }}"
                                        width="27">
                                </a>
                            </div>

                            <div id="tooltipGithub" class="orLogin" data-toggle="tooltip" data-placement="top"
                                title="Login dengan Github">
                                <a id="signWithGithub" href="javascript:void(0)" class="loginGithub">
                                    <img class="logo-provider" src="{{ asset('vendor/blog/img/github.png') }}"
                                        width="27">
                                </a>
                            </div>
                        </div>

                        <div class="footer-login clearfix">
                            <div class="register">
                                <ul class="ul">
                                    <li>
                                        <a href="{{ route('register') }}" class="link">
                                            Buat Akun
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <span class="space"></span>
                            <div class="forgot">
                                <ul class="ul">
                                    <li>
                                        <a href="{{ route('password.request') }}" class="link ">
                                            Lupa Sandi?
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .disable {
            pointer-events: none;
            cursor: default;
            text-decoration: none;
            color: rgb(55, 54, 54);
        }
    </style>
@endpush

@push('js')
    <script>
        const infoBan = $('.info-ban').data('info');

        if (infoBan) {
            alertify.okBtn("OK").alert(infoBan);
        }
    </script>

    <script type="module">
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/9.8.4/firebase-app.js";
        import {
            getAnalytics
        } from "https://www.gstatic.com/firebasejs/9.8.4/firebase-analytics.js";
        import {
            GoogleAuthProvider,
            GithubAuthProvider,
            createUserWithEmailAndPassword,
            signInAnonymously,
            getAuth,
            signInWithPopup
        } from "https://www.gstatic.com/firebasejs/9.8.4/firebase-auth.js";

        const firebaseConfig = {
            apiKey: "AIzaSyBjRiwImCUf2YfiylqIF04m08P7_Y5s7lg",
            authDomain: "kanzankazu-d3594.firebaseapp.com",
            databaseURL: "https://kanzankazu-d3594-default-rtdb.firebaseio.com",
            projectId: "kanzankazu-d3594",
            storageBucket: "kanzankazu-d3594.appspot.com",
            messagingSenderId: "74823808367",
            appId: "1:74823808367:web:75e4de27a5e1495f3de49a",
            measurementId: "G-R9TN0JZ4MH"
        };

        const app = initializeApp(firebaseConfig);
        const analytics = getAnalytics(app);
        const googleProvider = new GoogleAuthProvider();
        const githubProvider = new GithubAuthProvider();
        const auth = getAuth();
        auth.languageCode = 'id';

        $('#signWithAnonym').on('click', function() {
            signInAnonymously(auth)
                .then((result) => {

                    const user = result.user;

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: "{{ route('anonymous.login') }}",
                        data: {
                            uid: user.uid,
                        },
                        beforeSend: function() {
                            $('#signWithGoogle').addClass('disable');
                            $('#signWithGithub').addClass('disable');

                            $('#signWithAnonym').addClass('disable');
                            $('#signWithAnonym').html('<i class="fas fa-spin fa-spinner"></i>');
                            $('#tooltipAnonym').tooltip('dispose').attr('title',
                                'Pengecekan..');
                            $('#tooltipAnonym').tooltip('show')
                        },
                        success: function(data) {
                            if (data.status == 200) {

                                $('#signWithAnonym').html('<i class="uil uil-check"></i>');
                                $('#tooltipAnonym').tooltip('dispose').attr('title',
                                    'Status OK..');
                                $('#tooltipAnonym').tooltip('show')

                                setTimeout(function() {
                                    $('#signWithAnonym').html(
                                        '<i class="fas fa-spin fa-spinner"></i>');

                                    $('#tooltipAnonym').tooltip('dispose').attr('title',
                                        'Mengalihkan ke Dashboard...');
                                    $('#tooltipAnonym').tooltip('show');
                                }, 1700);

                                alertify
                                    .delay(3500)
                                    .log(data.msg);

                                setTimeout((function() {
                                    window.location.href = data.redirect;
                                }), 3000);
                            } else if (response.status == 403) {
                                alertify
                                    .delay(4000)
                                    .error(data.msg);

                                $('#signWithAnonym').html('<i class="uil uil-ban"></i>');
                                $('#tooltipAnonym').tooltip('dispose').attr('title',
                                    data.msg);
                                $('#tooltipAnonym').tooltip('show');

                                setTimeout(function() {
                                    $('#signWithAnonym').html(
                                        '<i class="fas fa-spin fa-spinner"></i>');
                                    $('#tooltipAnonym').tooltip('dispose').attr('title',
                                        'Muat ulang halaman..');
                                    $('#tooltipAnonym').tooltip('show');
                                }, 1700);

                                setTimeout((function() {
                                    window.location.href = data.redirect;
                                }), 3000);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                })
                .catch((error) => {
                    const errorCode = error.code;
                    const errorMessage = error.message;
                });

        });

        $('#signWithGithub').click(function() {
            signInWithPopup(auth, githubProvider)
                .then((result) => {

                    const credential = GithubAuthProvider.credentialFromResult(result);
                    const token = credential.accessToken;
                    const user = result.user;

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ route('github.login') }}",
                        type: "POST",
                        data: {
                            token: token,
                            name: user.displayName,
                            email: user.email,
                            user_image: user.photoURL,
                            uid: user.uid
                        },
                        beforeSend: function() {
                            $('#signWithGoogle').addClass('disable');
                            $('#signWithAnonym').addClass('disable');

                            $('#signWithGithub').addClass('disable');
                            $('#signWithGithub').html('<i class="fas fa-spin fa-spinner"></i>');
                            $('#tooltipGithub').tooltip('dispose').attr('title',
                                'Pengecekan..');
                            $('#tooltipGithub').tooltip('show')
                        },
                        success: function(data) {
                            if (data.status == 200) {

                                $('#signWithGithub').html('<i class="uil uil-check"></i>');
                                $('#tooltipGithub').tooltip('dispose').attr('title',
                                    'Status OK..');
                                $('#tooltipGithub').tooltip('show')

                                setTimeout(function() {
                                    $('#signWithGithub').html(
                                        '<i class="fas fa-spin fa-spinner"></i>');

                                    $('#tooltipGithub').tooltip('dispose').attr('title',
                                        'Mengalihkan ke Dashboard...');
                                    $('#tooltipGithub').tooltip('show');
                                }, 1700);

                                alertify
                                    .delay(3500)
                                    .log(data.msg);

                                setTimeout((function() {
                                    window.location.href = data.redirect;
                                }), 3000);

                            } else if (data.status == 403) {
                                alertify
                                    .delay(4000)
                                    .error(data.msg);

                                $('#signWithGithub').html('<i class="uil uil-ban"></i>');
                                $('#tooltipGithub').tooltip('dispose').attr('title',
                                    data.msg);
                                $('#tooltipGithub').tooltip('show');

                                setTimeout(function() {
                                    $('#signWithGithub').html(
                                        '<i class="fas fa-spin fa-spinner"></i>');
                                    $('#tooltipGithub').tooltip('dispose').attr('title',
                                        'Muat ulang halaman..');
                                    $('#tooltipGithub').tooltip('show');
                                }, 1700);

                                setTimeout((function() {
                                    window.location.href = data.redirect;
                                }), 3000);
                            } else {
                                alertify
                                    .delay(4000)
                                    .error(data.error.email[0]);

                                $('#signWithGithub').html(
                                    "<a id='signWithGithub' href='javascript:void(0)' class='loginGithub'><img class='logo-provider' src='{{ asset('vendor/blog/img/github.png') }}' width='27'></a>"
                                );

                                $('#tooltipGithub').tooltip('dispose').attr('title', data.error
                                    .email[0]);
                                $('#tooltipGithub').tooltip('show')

                                setTimeout(function() {
                                    $('#tooltipGithub').tooltip('dispose').attr('title',
                                        'Login dengan Github');
                                    $('#tooltipGithub').tooltip('enable');
                                }, 4000);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                }).catch((error) => {

                    const errorCode = error.code;
                    const errorMessage = error.message;
                    const email = error.customData.email;
                    const credential = GithubAuthProvider.credentialFromError(error);

                    if (errorCode == 'auth/user-disabled') {
                        alertify.okBtn("OK").alert(
                            'Maaf.. akun kamu telah kami blokir. Silahkan kontak admin untuk informasi lebih lanjut :)'
                        );
                    }
                });
        });

        $('#signWithGoogle').on('click', function(e) {
            e.preventDefault();

            signInWithPopup(auth, googleProvider)
                .then((result) => {

                    const credential = GoogleAuthProvider.credentialFromResult(result);
                    const token = credential.accessToken;
                    const user = result.user;

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ route('google.login') }}",
                        type: "POST",
                        data: {
                            name: user.displayName,
                            email: user.email,
                            user_image: user.photoURL,
                            uid: user.uid,
                            disable: user.reloadUserInfo.disabled
                        },
                        beforeSend: function() {
                            $('#signWithGithub').addClass('disable');
                            $('#signWithAnonym').addClass('disable');

                            $('#signWithGoogle').addClass('disable');
                            $('#signWithGoogle').html(
                                '<i class="fas fa-spin fa-spinner" disabled="disabled"></i>');
                            $('#tooltipGoogle').tooltip('dispose').attr('title',
                                'Pengecekan..');
                            $('#tooltipGoogle').tooltip('show')
                        },
                        success: function(data) {
                            if (data.status == 200) {

                                $('#signWithGoogle').html('<i class="uil uil-check"></i>');

                                $('#tooltipGoogle').tooltip('dispose').attr('title',
                                    'Status OK..');
                                $('#tooltipGoogle').tooltip('show')

                                setTimeout(function() {
                                    $('#signWithGoogle').html(
                                        '<i class="fas fa-spin fa-spinner"></i>');

                                    $('#tooltipGoogle').tooltip('dispose').attr('title',
                                        'Mengalihkan ke Dashboard...');
                                    $('#tooltipGoogle').tooltip('show');
                                }, 1700);

                                alertify
                                    .delay(3500)
                                    .log(data.msg);

                                setTimeout((function() {
                                    window.location.href = data.redirect;
                                }), 3000);

                            } else if (data.status == 403) {
                                alertify
                                    .delay(4000)
                                    .error(data.msg);

                                $('#signWithGoogle').html('<i class="uil uil-ban"></i>');

                                $('#tooltipGoogle').tooltip('dispose').attr('title',
                                    data.msg);
                                $('#tooltipGoogle').tooltip('show');

                                setTimeout(function() {
                                    $('#signWithGoogle').html(
                                        '<i class="fas fa-spin fa-spinner"></i>');

                                    $('#tooltipGoogle').tooltip('dispose').attr('title',
                                        'Muat ulang halaman..');
                                    $('#tooltipGoogle').tooltip('show');
                                }, 1500);

                                setTimeout((function() {
                                    window.location.href = data.redirect;
                                }), 3000);
                            } else {
                                alertify
                                    .delay(4000)
                                    .error(data.error.email[0]);

                                $('#signWithGoogle').html(
                                    "<a id='signWithGoogle' href='javascript:void(0)' class='loginGoogle'><img class='logo-provider' src='{{ asset('vendor/blog/img/google.png') }}' width='27'></a>"
                                );

                                $('#tooltipGoogle').tooltip('dispose').attr('title', data.error
                                    .email[0]);
                                $('#tooltipGoogle').tooltip('show')

                                setTimeout(function() {
                                    $('#tooltipGoogle').tooltip('dispose').attr('title',
                                        'Login dengan google');
                                    $('#tooltipGoogle').tooltip('enable');
                                }, 4000);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });

                }).catch((error) => {

                    const errorCode = error.code;
                    const errorMessage = error.message;
                    const email = error.customData;
                    const credential = GoogleAuthProvider.credentialFromError(error);

                    if (errorCode == 'auth/user-disabled') {
                        alertify.okBtn("OK").alert(
                            'Maaf.. akun kamu telah kami blokir. Silahkan kontak admin untuk informasi lebih lanjut :)'
                        );
                    }
                });
        });
    </script>
@endpush

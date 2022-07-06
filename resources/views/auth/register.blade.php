@extends('layouts.auth')

@section('title', 'Register')

@section('keywords')
    register kanzankazu
@endsection

@section('image')
{{ asset('vendor/blog/img/auth-img/signin.svg') }}
@endsection

@section('content')
    <div class="container">
        <div class="row px-3">
            <div class="col-lg-10 col-xl-9 card flex-row mx-auto px-0">
                <div class="d-none d-md-flex">
                    <img src="{{ asset('vendor/blog/img/auth-img/signin.svg') }}" class="img-register">
                </div>

                <div class="card-body">

                    @include('auth.nav')

                    <h4 class="title text-center mt-4">
                        Register
                    </h4>

                    {{-- Form Input --}}
                    <form id="registerForm" action="{{ route('register') }}" method="POST" class="form-box px-3"
                        autocomplete="off">
                        @csrf

                        <input id="slugName" type="hidden" name="slug" value="{{ old('slug') }}">

                        {{-- Name --}}
                        <div class="form-input">
                            <div class="iconForm"><i class="uil uil-user"></i></div>
                            <input type="text" id="name" class="form_control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" style="text-transform: lowercase;" autofocus>
                            <label for="name">User Name</label>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ trans($message) }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="form-input">
                            <div class="iconForm"><i class="uil uil-envelope"></i></div>
                            <input type="email" id="email" class="form_control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" autofocus>
                            <label for="email">Email</label>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ trans($message) }}</strong>
                                </span>
                            @enderror
                        </div>
                        {{-- Password --}}
                        <div class="form-input">
                            <div class="iconForm"><i class="uil uil-key-skeleton"></i></div>

                            <input type="password" class="form_control password @error('password') is-invalid @enderror"
                                id="password" type="password" name="password" autocomplete="new-password">
                            <label for="password">Password</label>

                            <div class="passTog"><i class="bi bi-eye-slash-fill" id="togglePass"></i></div>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="form-input">
                            <div class="iconForm"><i class="uil uil-key-skeleton"></i></div>

                            <input type="password" class="form_control password @error('password') is-invalid @enderror"
                                id="password-confirm" type="password" name="password_confirmation"
                                autocomplete="new-password">
                            <label for="password-confirm">Confirm Password</label>

                            {{-- <div class="passTog"><i class="bi bi-eye-slash-fill" id="toggleNewPass"></i></div> --}}

                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-block text-uppercase">
                                Sign Up
                            </button>
                        </div>

                        <div class="footer-login clearfix">
                            <div class="register">
                                <ul class="ul">
                                    <li>
                                        <a href="{{ route('login') }}" class="link">
                                           Sudah punya akun?
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

    @push('js')
        <script>
            $(function() {
                const generateSlug = (value) => {
                    return value.trim()
                        .toLowerCase()
                        .replace(/[^a-z\d-]/gi, '-')
                        .replace(/-+/g, '-').replace(/^-|-$/g, "")
                }

                $('#name').change(function(e) {
                    e.preventDefault();

                    let title = $(this).val();
                    $('#slugName').val(generateSlug(title));
                });

                document.getElementById("togglePass").addEventListener("click", function() {
                    this.classList.toggle("bi-eye");

                    [...document.querySelectorAll(".password")].forEach(
                        p => p.type = p.type === "password" ? "text" : "password"
                    )
                });
            });
        </script>
    @endpush
@endsection

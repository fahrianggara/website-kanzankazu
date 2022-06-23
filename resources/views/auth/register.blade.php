@extends('layouts.auth')

@section('title', 'Register')

@section('keywords')
    {{ $setting->meta_keywords }} register kanzankazu, {{ $setting->site_name }}
@endsection

@section('content')
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
                        Register
                    </h4>

                    {{-- Form Input --}}
                    <form action="{{ route('register') }}" method="POST" class="form-box px-3" autocomplete="off">
                        @csrf

                        <input id="slugName" type="hidden" name="slug" value="{{ old('slug') }}">

                        {{-- Name --}}
                        <div class="form-input">
                            <div class="iconForm"><i class="uil uil-user"></i></div>
                            <input type="text" id="name" class="form_control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" autofocus>
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

                            <input type="password" class="form_control @error('password') is-invalid @enderror"
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

                            <input type="password" class="form_control @error('password') is-invalid @enderror"
                                id="password-confirm" type="password" name="password_confirmation"
                                autocomplete="new-password">
                            <label for="password">Confirm Password</label>

                            <div class="passTog"><i class="bi bi-eye-slash-fill" id="toggleNewPass"></i></div>

                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-block text-uppercase">
                                Sign Up
                            </button>
                        </div>

                        <hr class="my-4 hr">

                        <div class="text-center mb-2">
                            <a href="{{ route('login') }}" class="register-link">
                                Sudah punya akun?
                            </a>
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

                const togglePassword = document.querySelector('#togglePass');
                const password = document.querySelector('#password');

                togglePassword.addEventListener('click', function(e) {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);

                    this.classList.toggle("bi-eye");
                });

                const toggleNewPassword = document.querySelector('#toggleNewPass');
                const newPassword = document.querySelector('#password-confirm');

                toggleNewPassword.addEventListener('click', function(e) {
                    const type = newPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                    newPassword.setAttribute('type', type);

                    this.classList.toggle("bi-eye");
                });
            });
        </script>
    @endpush
@endsection

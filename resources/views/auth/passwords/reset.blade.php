@extends('layouts.auth')

@section('title', 'Reset Password')

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
                        Reset Password
                    </h4>

                    {{-- Form Input --}}
                    <form action="{{ route('password.update') }}" method="POST" class="form-box px-3">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        {{-- Email --}}
                        <div class="form-input">
                            <div class="iconForm"><i class="uil uil-envelope"></i></div>
                            <input id="email" type="email" class="form_control @error('email') is-invalid @enderror"
                                name="email" value="{{ $email ?? old('email') }}" required autocomplete="off" autofocus>
                            <label for="email" class="@error('email') active @enderror">Email kamu</label>

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
                                class="form_control password @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">
                            <label for="password">Password baru</label>

                            <div class="passTog"><i class="bi bi-eye-slash-fill" id="togglePass"></i></div>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Password confirm --}}
                        <div class="form-input">
                            <div class="iconForm"><i class="uil uil-key-skeleton-alt"></i></div>
                            <input id="password-confirm" type="password" class="form_control password" name="password_confirmation"
                                required autocomplete="new-password">
                            <label for="password-confirm">Konfirmasi</label>
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

    @push('js')
        <script>
            document.getElementById("togglePass").addEventListener("click", function() {
                this.classList.toggle("bi-eye");

                [...document.querySelectorAll(".password")].forEach(
                    p => p.type = p.type === "password" ? "text" : "password"
                )
            });
        </script>
    @endpush
@endsection

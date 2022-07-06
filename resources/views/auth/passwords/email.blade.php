@extends('layouts.auth')

@section('title', 'Forgot password')

@section('content')
    <div class="notif-success" data-notif="{{ session('status') }}"></div>

    <div class="container">
        <div class="row px-3">
            <div class="col-lg-10 col-xl-9 card flex-row mx-auto px-0">
                <div class="img-left d-none d-md-flex"></div>

                <div class="card-body">

                    @include('auth.nav')

                    <h4 class="title text-center mt-4">
                        Forgot password
                    </h4>

                    {{-- Form Input --}}
                    <form action="{{ route('password.email') }}" method="POST" class="form-box px-3">
                        @csrf

                        {{-- Email --}}
                        <div class="form-input">
                            <div class="iconForm"><i class="uil uil-envelope"></i></div>
                            <input  type="email" id="email" class="form_control @error('email') is-invalid @enderror"
                                name="email" value="{{ Auth::user()->email ?? old('email') }}" autocomplete="off"
                                autofocus>
                            <label for="email">Email</label>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        @if (session('status'))
                            <div class="mb-3">
                                <button type="submit" disabled class="btn btn-block text-uppercase">
                                    Terkirim, silahkan cek email kamu.
                                </button>
                            </div>
                        @else
                            <div class="mb-3">
                                <button type="submit" class="btn btn-block text-uppercase">
                                    Submit
                                </button>
                            </div>
                        @endif

                        <div class="footer-login clearfix">
                            <div class="register">
                                <ul class="ul">
                                    <li>
                                        <a href="{{ route('login') }}" class="link">
                                            Ingat sandi?
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

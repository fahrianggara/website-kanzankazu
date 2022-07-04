@extends('layouts.auth')

@section('title', 'Login')

@section('keywords')
    {{ $setting->meta_keywords }} login kanzankazu, {{ $setting->site_name }}
@endsection

@section('content')
    @if (Session::has('success'))
        <div class="notif-success" data-notif="{{ Session::get('success') }}"></div>
    @endif

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
                            <button id="signWithKanzankazu" type="submit" class="btn btn-block text-uppercase">
                                Login
                            </button>
                        </div>

                        <hr data-content="OR" class="hr-text">

                        <div class="d-flex mt-4 justify-content-center">
                            <div class="orLogin mr-3" data-toggle="tooltip" data-placement="top" title="Login dengan Google">
                                <a id="signWithGoogle" href="javascript:void(0)" class="loginGoogle">
                                    <img class="logo-provider" src="{{ asset('vendor/blog/img/google.png') }}"
                                        width="27">
                                </a>
                            </div>
                            <div class="orLogin" data-toggle="tooltip" data-placement="top" title="Login dengan Github">
                                <a id="signWithGithub" href="javascript:void(0)" class="loginGithub">
                                    <img class="logo-provider" src="{{ asset('vendor/blog/img/github.png') }}"
                                        width="27">
                                </a>
                            </div>
                        </div>

                        <hr class="m-0 hr">

                        <div class="text-center mt-3 mb-2">
                            <a href="{{ route('homepage') }}" class="mr-1 register-link">
                                Beranda
                            </a>
                            |
                            <a href="{{ route('register') }}" class="ml-1 register-link">
                                Belum punya akun?
                            </a>
                            |
                            <a href="{{ route('password.request') }}" class="forget-link">
                                Forgot Password?
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Notif status
        const notif = $('.notif-success').data('notif');
        if (notif) {
            alertify
                .delay(5000)
                .log(notif);
        }
    </script>
    <script type="module">
        const _0x13d0e0=_0x5060; function _0x21c7(){const _0x39b730=['#signWithGithub', 'code', 'responseText', 'then', '2299593pdPNWy', 'log', 'photoURL', 'credentialFromResult', 'credentialFromError', 'https://kanzankazu-d3594-default-rtdb.firebaseio.com', 'redirect', 'POST', '52500GUdmaV', 'customData', 'catch', 'click', 'ajaxSetup', 'uid', 'status', 'meta[name=\x22csrf-token\x22]', '1215652bHxCpU', 'languageCode', 'ajax', 'G-R9TN0JZ4MH', '2129504KUNgZi', 'content', '9995464cAwPjc', 'kanzankazu-d3594', 'attr', '58806imebOe', 'message', 'msg', '{{ route('google.login') }}', 'href', 'delay', 'email', 'kanzankazu-d3594.appspot.com', 'kanzankazu-d3594.firebaseapp.com', 'error', 'accessToken', '60965zoKxJt', '#signWithGoogle', '7WqoeVB', 'user', 'location']; _0x21c7=function(){return _0x39b730;}; return _0x21c7();}(function(_0x1aab48, _0x399371){const _0x1e46ef=_0x5060, _0x1474ca=_0x1aab48(); while (!![]){try{const _0x18302b=parseInt(_0x1e46ef(0x1cc)) / 0x1 + -parseInt(_0x1e46ef(0x1e5)) / 0x2 + -parseInt( _0x1e46ef(0x1d5)) / 0x3 + parseInt(_0x1e46ef(0x1bc)) / 0x4 + parseInt(_0x1e46ef(0x1dd)) / 0x5 + parseInt(_0x1e46ef(0x1c1)) / 0x6 + -parseInt(_0x1e46ef(0x1ce)) / 0x7 * (-parseInt( _0x1e46ef(0x1be)) / 0x8); if (_0x18302b===_0x399371) break; else _0x1474ca['push'](_0x1474ca['shift']());}catch (_0x5b276d){_0x1474ca['push'](_0x1474ca['shift']());}}}(_0x21c7, 0x7750e)); import{initializeApp}from 'https://www.gstatic.com/firebasejs/9.8.4/firebase-app.js'; import{getAnalytics}from 'https://www.gstatic.com/firebasejs/9.8.4/firebase-analytics.js'; import{GoogleAuthProvider, GithubAuthProvider, getAuth, signInWithPopup}from 'https://www.gstatic.com/firebasejs/9.8.4/firebase-auth.js'; function _0x5060(_0x3d99e8, _0x42c6b1){const _0x21c738=_0x21c7(); return _0x5060=function(_0x506078, _0x12e5fd){_0x506078=_0x506078 - 0x1bc; let _0x45d850=_0x21c738[_0x506078]; return _0x45d850;}, _0x5060(_0x3d99e8, _0x42c6b1);}const firebaseConfig={'apiKey': 'AIzaSyBjRiwImCUf2YfiylqIF04m08P7_Y5s7lg', 'authDomain': _0x13d0e0(0x1c9), 'databaseURL': _0x13d0e0(0x1da), 'projectId': _0x13d0e0(0x1bf), 'storageBucket': _0x13d0e0(0x1c8), 'messagingSenderId': '74823808367', 'appId': '1:74823808367:web:75e4de27a5e1495f3de49a', 'measurementId': _0x13d0e0(0x1e8)}, app=initializeApp(firebaseConfig), analytics=getAnalytics(app), googleProvider=new GoogleAuthProvider(), githubProvider=new GithubAuthProvider(), auth=getAuth(); auth[_0x13d0e0(0x1e6)]='id', $(_0x13d0e0(0x1d1))[_0x13d0e0(0x1e0)](function(){const _0x531b6f=_0x13d0e0; signInWithPopup(auth, githubProvider)['then'](_0x32e453=>{const _0x419c86=_0x5060, _0x865c03=GithubAuthProvider[_0x419c86(0x1d8)](_0x32e453), _0xf31fb4=_0x865c03[_0x419c86(0x1cb)], _0x2dd952=_0x32e453[_0x419c86(0x1cf)]; console[_0x419c86(0x1d6)](_0x2dd952), $[_0x419c86(0x1e1)]({'headers':{'X-CSRF-TOKEN': $(_0x419c86(0x1e4))[_0x419c86(0x1c0)](_0x419c86(0x1bd))}}), $[_0x419c86(0x1e7)]({'url': '{{ route('github.login') }}', 'type': _0x419c86(0x1dc), 'data':{'token': _0xf31fb4, 'name': _0x2dd952['displayName'], 'email': _0x2dd952[_0x419c86(0x1c7)], 'user_image': _0x2dd952[_0x419c86(0x1d7)], 'uid': _0x2dd952['uid']}, 'success': function(_0x2a3d81){const _0x49368d=_0x419c86; _0x2a3d81[_0x49368d(0x1e3)]==0xc8 ? (alertify[_0x49368d(0x1c6)]( 0xdac)['log'](_0x2a3d81[_0x49368d(0x1c3)]), setTimeout( function(){const _0x1ef44d=_0x49368d; window[_0x1ef44d(0x1d0)][_0x1ef44d(0x1c5)]=_0x2a3d81[ _0x1ef44d(0x1db)];}, 0x3e8)) : alertify[_0x49368d(0x1c6)](0xfa0)['error']( _0x2a3d81['error']['email'][0x0]);}, 'error': function(_0x395d05, _0x2626f8, _0x1f5e70){const _0x554ad0=_0x419c86; alert(_0x395d05[_0x554ad0(0x1e3)] + '\x0a' + _0x395d05[_0x554ad0( 0x1d3)] + '\x0a' + _0x1f5e70);}});})[_0x531b6f(0x1df)](_0x400d40=>{const _0x4f3309=_0x531b6f, _0x28c7c9=_0x400d40[_0x4f3309(0x1d2)], _0x72aef7=_0x400d40[_0x4f3309(0x1c2)], _0x47423d=_0x400d40[_0x4f3309(0x1de)][_0x4f3309(0x1c7)], _0x51f02e=GithubAuthProvider[_0x4f3309(0x1d9)](_0x400d40); console['log'](_0x28c7c9, _0x72aef7, _0x47423d, _0x51f02e);});}), $(_0x13d0e0(0x1cd))[_0x13d0e0(0x1e0)](function(){const _0x40ab18=_0x13d0e0; signInWithPopup(auth, googleProvider)[_0x40ab18(0x1d4)](_0x4f31e8=>{const _0x25c0aa=_0x40ab18, _0x8f6edb=GoogleAuthProvider[_0x25c0aa(0x1d8)](_0x4f31e8), _0x49e386=_0x8f6edb[_0x25c0aa(0x1cb)], _0x495f46=_0x4f31e8[_0x25c0aa(0x1cf)]; console[_0x25c0aa(0x1d6)](_0x495f46), console['log'](_0x8f6edb), $['ajaxSetup']({'headers':{'X-CSRF-TOKEN': $(_0x25c0aa(0x1e4))[_0x25c0aa(0x1c0)]('content')}}), $[_0x25c0aa(0x1e7)]({'url': _0x25c0aa(0x1c4), 'type': _0x25c0aa(0x1dc), 'data':{'token': _0x49e386, 'name': _0x495f46['displayName'], 'email': _0x495f46[_0x25c0aa(0x1c7)], 'user_image': _0x495f46[_0x25c0aa(0x1d7)], 'uid': _0x495f46[_0x25c0aa(0x1e2)]}, 'success': function(_0xb9afc3){const _0x3e52c5=_0x25c0aa; _0xb9afc3[_0x3e52c5(0x1e3)]==0xc8 ? (alertify[_0x3e52c5(0x1c6)]( 0xdac)['log'](_0xb9afc3[_0x3e52c5(0x1c3)]), setTimeout( function(){const _0x22a021=_0x3e52c5; window['location'][_0x22a021(0x1c5)]=_0xb9afc3[ 'redirect'];}, 0x3e8)) : alertify[_0x3e52c5(0x1c6)](0xfa0)[_0x3e52c5(0x1ca)] (_0xb9afc3[_0x3e52c5(0x1ca)][_0x3e52c5(0x1c7)][0x0]);}, 'error': function(_0x998309, _0x450e28, _0x5f104a){const _0x5656f0=_0x25c0aa; alert(_0x998309['status'] + '\x0a' + _0x998309[_0x5656f0(0x1d3)] + '\x0a' + _0x5f104a);}});})[_0x40ab18(0x1df)](_0x491d12=>{const _0x147b95=_0x40ab18, _0x2a92d3=_0x491d12[_0x147b95(0x1d2)], _0x39831c=_0x491d12[_0x147b95(0x1c2)], _0x35ce64=_0x491d12['customData'][_0x147b95(0x1c7)], _0x57d990=GoogleAuthProvider['credentialFromError'](_0x491d12);});});
    </script>
@endpush

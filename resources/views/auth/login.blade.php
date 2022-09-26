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
                        {{-- {{ request()->getClientIp(true) }} --}}
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

                            {{-- <div id="tooltipAnonym" class="orLogin mr-4" data-toggle="tooltip" data-placement="top"
                                title="Login dengan Anonymous">
                                <a id="signWithAnonym" href="javascript:void(0)" class="loginAnonym">
                                    <img class="logo-provider" src="{{ asset('vendor/blog/img/anonymous.png') }}"
                                        width="27">
                                </a>
                            </div> --}}

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
        const _0x303aa7=_0x1463;(function(_0x532427,_0x42f600){const _0x12f422=_0x1463,_0x55508a=_0x532427();while(!![]){try{const _0x3670af=parseInt(_0x12f422(0xc0))/(0x1fd9+0x31*0xbe+-0x4436*0x1)*(-parseInt(_0x12f422(0xb1))/(-0x1823+-0xb*-0x1a9+-0x2*-0x2f1))+parseInt(_0x12f422(0x8b))/(-0x14f1+-0x8*-0x72+0x1164)*(-parseInt(_0x12f422(0xb7))/(-0x1083+-0x1*0x9af+0x1a36))+parseInt(_0x12f422(0x8a))/(0x23fd+0x1*-0x20a9+-0x34f)+parseInt(_0x12f422(0x9d))/(-0x1*-0x2592+0x1*0x2329+-0x1*0x48b5)*(parseInt(_0x12f422(0xa4))/(0x984+-0x25*-0x107+0x2f8*-0x10))+-parseInt(_0x12f422(0xe6))/(0x17*0x15+0x2*-0xe55+0x1acf)*(parseInt(_0x12f422(0xf1))/(0x1452+0xd4c+-0x2195*0x1))+-parseInt(_0x12f422(0xde))/(-0x12f1+-0x296+0x1591)*(-parseInt(_0x12f422(0xae))/(-0x3d*-0x25+-0x1f9c+0x16d6))+parseInt(_0x12f422(0xf2))/(0x2ac+0x563+-0x803)*(parseInt(_0x12f422(0x89))/(0x10a5+0xaaa+-0x1*0x1b42));if(_0x3670af===_0x42f600)break;else _0x55508a['push'](_0x55508a['shift']());}catch(_0x4e0c37){_0x55508a['push'](_0x55508a['shift']());}}}(_0x3d05,0xc4aef+-0x351b3+-0x205b5));const _0x4d8070=(function(){let _0x6282a9=!![];return function(_0x2728b5,_0x141314){const _0x5b76a5=_0x1463;if(_0x5b76a5(0xeb)==='RlpiW'){const _0x119159=_0x4a7aee[_0x5b76a5(0xbe)](_0x11b510,arguments);return _0x520be5=null,_0x119159;}else{const _0x5a06d5=_0x6282a9?function(){const _0x4a4f71=_0x5b76a5;if('mjOmz'!=='mjOmz')_0x53a873(_0x4a4f71(0x9b))['html']('<i class="uil uil-check"></i>'),_0x309cac('#tooltipGithub')[_0x4a4f71(0x9f)]('dispose')['attr'](_0x4a4f71(0xaf),_0x4a4f71(0x8f)),_0x7ca89('#tooltipGithub')['tooltip'](_0x4a4f71(0xd4)),_0x5326d9(function(){const _0xf9abf7=_0x4a4f71;_0x3b777e(_0xf9abf7(0x9b))[_0xf9abf7(0xd2)]('<i class="fas fa-spin fa-spinner"></i>'),_0x1d4e9e('#tooltipGithub')['tooltip'](_0xf9abf7(0x7d))[_0xf9abf7(0xa1)](_0xf9abf7(0xaf),_0xf9abf7(0x7c)),_0x3507d4(_0xf9abf7(0xb0))[_0xf9abf7(0x9f)](_0xf9abf7(0xd4));},0x1d4f+-0xad9*0x1+0x59*-0x22),_0x5dd499[_0x4a4f71(0xcd)](0x1*0x1b85+0x108a+-0x1e63)[_0x4a4f71(0x9c)](_0x3f8cdf['msg']),_0x1d57ee(function(){const _0x1d3473=_0x4a4f71;_0x1c4680[_0x1d3473(0x77)]['href']=_0xd78903[_0x1d3473(0xa8)];},-0x2079+-0x1f*0xe3+0x47ae);else{if(_0x141314){if(_0x4a4f71(0xe1)!==_0x4a4f71(0xa5)){const _0x35ecc6=_0x141314[_0x4a4f71(0xbe)](_0x2728b5,arguments);return _0x141314=null,_0x35ecc6;}else _0x5db81b(_0x4a4f71(0xc6))[_0x4a4f71(0xd2)](_0x4a4f71(0x96)),_0x4e020d(_0x4a4f71(0x98))[_0x4a4f71(0x9f)](_0x4a4f71(0x7d))[_0x4a4f71(0xa1)]('title','Mengalihkan ke Homepage...'),_0x186942(_0x4a4f71(0x98))[_0x4a4f71(0x9f)](_0x4a4f71(0xd4));}}}:function(){};return _0x6282a9=![],_0x5a06d5;}};}()),_0x2d601c=_0x4d8070(this,function(){const _0x5d5a0b=_0x1463;return _0x2d601c['toString']()[_0x5d5a0b(0xd5)](_0x5d5a0b(0xba))['toString']()[_0x5d5a0b(0xa9)](_0x2d601c)[_0x5d5a0b(0xd5)](_0x5d5a0b(0xba));});_0x2d601c();const _0xb525a0=(function(){let _0x3ecb1d=!![];return function(_0x11d933,_0x4b96c9){const _0x29caa0=_0x3ecb1d?function(){const _0x1561f4=_0x1463;if(_0x1561f4(0x90)===_0x1561f4(0x90)){if(_0x4b96c9){const _0x4610d9=_0x4b96c9[_0x1561f4(0xbe)](_0x11d933,arguments);return _0x4b96c9=null,_0x4610d9;}}else{const _0x412900=_0x203bd3?function(){const _0x5aec8e=_0x1561f4;if(_0x4e668d){const _0x473ef7=_0x5a87f4[_0x5aec8e(0xbe)](_0xc6d78c,arguments);return _0x4e96f6=null,_0x473ef7;}}:function(){};return _0x2d99fb=![],_0x412900;}}:function(){};return _0x3ecb1d=![],_0x29caa0;};}()),_0x44fea4=_0xb525a0(this,function(){const _0x1a1115=_0x1463,_0x32fc38=function(){const _0x3ac765=_0x1463;let _0xe3cd44;try{_0xe3cd44=Function(_0x3ac765(0xd9)+_0x3ac765(0xd1)+');')();}catch(_0x42d44e){_0xe3cd44=window;}return _0xe3cd44;},_0x2c961d=_0x32fc38(),_0x3cc33b=_0x2c961d[_0x1a1115(0xd3)]=_0x2c961d['console']||{},_0x2325c9=[_0x1a1115(0x9c),'warn',_0x1a1115(0x9a),'error',_0x1a1115(0xa0),_0x1a1115(0x81),_0x1a1115(0xee)];for(let _0x4bb47b=-0x211*0x9+-0x1643+0x14*0x20b;_0x4bb47b<_0x2325c9[_0x1a1115(0x91)];_0x4bb47b++){const _0x22640c=_0xb525a0[_0x1a1115(0xa9)]['prototype'][_0x1a1115(0xda)](_0xb525a0),_0x4f0bb4=_0x2325c9[_0x4bb47b],_0x4ae261=_0x3cc33b[_0x4f0bb4]||_0x22640c;_0x22640c['__proto__']=_0xb525a0[_0x1a1115(0xda)](_0xb525a0),_0x22640c[_0x1a1115(0x94)]=_0x4ae261[_0x1a1115(0x94)][_0x1a1115(0xda)](_0x4ae261),_0x3cc33b[_0x4f0bb4]=_0x22640c;}});function _0x3d05(){const _0x192faa=['#signWithGoogle','toString','VSQVB','<i class="fas fa-spin fa-spinner"></i>','accessToken','#tooltipAnonym','user','info','#signWithGithub','log','896526fHIsUA','ajax','tooltip','exception','attr','HJXIw','messagingSenderId','21qdYFgw','Vqewy','https://kanzankazu-d3594-default-rtdb.firebaseio.com','addClass','redirect','constructor','click','then','credentialFromError','CizcF','11qMqVbZ','title','#tooltipGithub','6AVCVtq','token','uEeKr','displayName','Maaf, email di akun github kamu telah terdaftar di provider lain. Silahkan kontak admin untuk informasi lebih lanjut :)','ajaxSetup','2652872fxapZV','{{ route("google.login") }}','reloadUserInfo','(((.+)+)+)+$','sqpub','kanzankazu-d3594.appspot.com','KMdcM','apply','G-R9TN0JZ4MH','273584ugczQC','Login dengan Github','<a id="signWithGoogle" href="javascript:void(0)" class="loginGoogle"><img class="logo-provider" src="{{ asset("vendor/blog/img/google.png") }}" width="27"></a>','lIseV','responseText','bPAGb','#signWithAnonym','#tooltipGoogle','content','authDomain','auth/user-disabled','POST','1:74823808367:web:75e4de27a5e1495f3de49a','delay','nQPTi','lbzYV','AIzaSyBjRiwImCUf2YfiylqIF04m08P7_Y5s7lg','{}.constructor("return this")( )','html','console','show','search','<i class="uil uil-check"></i>','message','user_image','return (function() ','bind','auth/account-exists-with-different-credential','<i class="fas fa-spin fa-spinner" disabled="disabled"></i>','jfmSd','4676690pQwsKc','storageBucket','jtKrZ','pbAPZ','error','enable','status','Pengecekan..','16hwAzSL','<i class="uil uil-ban"></i>','alert','msg','<a id="signWithGithub" href="javascript:void(0)" class="loginGithub"><img class="logo-provider" src="{{ asset("vendor/blog/img/github.png") }}" width="27"></a>','jMfgN','iTNUr','href','trace','catch','Muat ulang halaman..','4097043iadksg','12ysohvw','photoURL','tcwyI','ClQRY','HkOVb','ytFPZ','email','meta[name="csrf-token"]','vnZFD','uid','location','customData','Login dengan Google','dEGHj','code','Mengalihkan ke Dashboard...','dispose','apiKey','name','RDQaA','table','okBtn','Maaf.. akun kamu telah kami blokir. Silahkan kontak admin untuk informasi lebih lanjut :)','databaseURL','removeClass','credentialFromResult','stBkK','languageCode','22735453untVqI','925850hQnERa','3Bzvdqk','disable','ebvQb','LbSKr','Status OK..','URYNo','length','preventDefault'];_0x3d05=function(){return _0x192faa;};return _0x3d05();}_0x44fea4();import{initializeApp}from'https://www.gstatic.com/firebasejs/9.8.4/firebase-app.js';import{getAnalytics}from'https://www.gstatic.com/firebasejs/9.8.4/firebase-analytics.js';import{GoogleAuthProvider,GithubAuthProvider,createUserWithEmailAndPassword,signInAnonymously,getAuth,signInWithPopup}from'https://www.gstatic.com/firebasejs/9.8.4/firebase-auth.js';const _0x448927={};function _0x1463(_0x2d601c,_0x4d8070){const _0x3d05f1=_0x3d05();return _0x1463=function(_0x146389,_0x26d903){_0x146389=_0x146389-(0x1c84+-0x5fc*0x4+0x421*-0x1);let _0x25abde=_0x3d05f1[_0x146389];return _0x25abde;},_0x1463(_0x2d601c,_0x4d8070);}_0x448927[_0x303aa7(0x7e)]=_0x303aa7(0xd0),_0x448927[_0x303aa7(0xc9)]='kanzankazu-d3594.firebaseapp.com',_0x448927[_0x303aa7(0x84)]=_0x303aa7(0xa6),_0x448927['projectId']='kanzankazu-d3594',_0x448927[_0x303aa7(0xdf)]=_0x303aa7(0xbc),_0x448927[_0x303aa7(0xa3)]='74823808367',_0x448927['appId']=_0x303aa7(0xcc),_0x448927['measurementId']=_0x303aa7(0xbf);const firebaseConfig=_0x448927,app=initializeApp(firebaseConfig),analytics=getAnalytics(app),googleProvider=new GoogleAuthProvider(),githubProvider=new GithubAuthProvider(),auth=getAuth();auth[_0x303aa7(0x88)]='id',$('#signWithAnonym')['on']('click',function(){const _0x12c130=_0x303aa7;signInAnonymously(auth)['then'](_0x3818cc=>{const _0x542972=_0x1463,_0x4505eb=_0x3818cc[_0x542972(0x99)];$[_0x542972(0xb6)]({'headers':{'X-CSRF-TOKEN':$(_0x542972(0x74))['attr']('content')}});const _0x826e1c={};_0x826e1c[_0x542972(0x76)]=_0x4505eb[_0x542972(0x76)],$[_0x542972(0x9e)]({'type':_0x542972(0xcb),'url':'{{ route("anonymous.login") }}','data':_0x826e1c,'beforeSend':function(){const _0x159d63=_0x542972;_0x159d63(0xa2)!==_0x159d63(0xa2)?_0x40c7b6[_0x159d63(0x82)]('OK')[_0x159d63(0xe8)](_0x159d63(0xb5)):($(_0x159d63(0x93))[_0x159d63(0xa7)](_0x159d63(0x8c)),$(_0x159d63(0x9b))['addClass'](_0x159d63(0x8c)),$(_0x159d63(0xc6))[_0x159d63(0xa7)](_0x159d63(0x8c)),$('#signWithAnonym')['html'](_0x159d63(0x96)),$(_0x159d63(0x98))['tooltip'](_0x159d63(0x7d))[_0x159d63(0xa1)]('title',_0x159d63(0xe5)),$(_0x159d63(0x98))['tooltip'](_0x159d63(0xd4)));},'success':function(_0x593e86){const _0x21e0da=_0x542972;if(_0x593e86[_0x21e0da(0xe4)]==0xcb4+0x21f4+0x2*-0x16f0){if('tcwyI'!==_0x21e0da(0xf4)){const _0x3dd8f9=_0x1c7b89['code'],_0x4970d3=_0x5067a9[_0x21e0da(0xd7)];}else $(_0x21e0da(0xc6))[_0x21e0da(0xd2)]('<i class="uil uil-check"></i>'),$(_0x21e0da(0x98))[_0x21e0da(0x9f)](_0x21e0da(0x7d))[_0x21e0da(0xa1)]('title',_0x21e0da(0x8f)),$(_0x21e0da(0x98))[_0x21e0da(0x9f)](_0x21e0da(0xd4)),setTimeout(function(){const _0x21214c=_0x21e0da;_0x21214c(0xe0)!==_0x21214c(0xdd)?($(_0x21214c(0xc6))['html'](_0x21214c(0x96)),$('#tooltipAnonym')[_0x21214c(0x9f)](_0x21214c(0x7d))[_0x21214c(0xa1)]('title','Mengalihkan ke Homepage...'),$('#tooltipAnonym')[_0x21214c(0x9f)](_0x21214c(0xd4))):_0x406e3c(_0x3275c7[_0x21214c(0xe4)]+'\x0a'+_0x4375a1[_0x21214c(0xc4)]+'\x0a'+_0x29ecba);},0x1a34+-0x1d2e+0x99e),alertify[_0x21e0da(0xcd)](0x3fe*-0x3+-0x17*0x161+0x395d)[_0x21e0da(0x9c)](_0x593e86[_0x21e0da(0xe9)]),setTimeout(function(){const _0x5c2d7a=_0x21e0da;window[_0x5c2d7a(0x77)][_0x5c2d7a(0xed)]=_0x593e86['redirect'];},-0x22*0xef+-0x2*-0xf56+-0x2*-0x665);}else response['status']==-0x91b+-0xc5+-0xb73*-0x1&&(alertify[_0x21e0da(0xcd)](0x10*-0x1a4+-0x1*-0x10f3+0x18ed)[_0x21e0da(0xe2)](_0x593e86[_0x21e0da(0xe9)]),$(_0x21e0da(0xc6))[_0x21e0da(0xd2)](_0x21e0da(0xe7)),$(_0x21e0da(0x98))[_0x21e0da(0x9f)](_0x21e0da(0x7d))[_0x21e0da(0xa1)](_0x21e0da(0xaf),_0x593e86[_0x21e0da(0xe9)]),$(_0x21e0da(0x98))[_0x21e0da(0x9f)](_0x21e0da(0xd4)),setTimeout(function(){const _0x2dbb6b=_0x21e0da;_0x2dbb6b(0x95)!==_0x2dbb6b(0xc3)?($('#signWithAnonym')[_0x2dbb6b(0xd2)]('<i class="fas fa-spin fa-spinner"></i>'),$(_0x2dbb6b(0x98))[_0x2dbb6b(0x9f)](_0x2dbb6b(0x7d))[_0x2dbb6b(0xa1)](_0x2dbb6b(0xaf),_0x2dbb6b(0xf0)),$(_0x2dbb6b(0x98))[_0x2dbb6b(0x9f)](_0x2dbb6b(0xd4))):(_0x156ad6(_0x2dbb6b(0x93))['addClass'](_0x2dbb6b(0x8c)),_0x3341ac(_0x2dbb6b(0xc6))[_0x2dbb6b(0xa7)](_0x2dbb6b(0x8c)),_0x58387e(_0x2dbb6b(0x9b))['addClass']('disable'),_0x31e0ab(_0x2dbb6b(0x9b))[_0x2dbb6b(0xd2)]('<i class="fas fa-spin fa-spinner"></i>'),_0x919ba(_0x2dbb6b(0xb0))[_0x2dbb6b(0x9f)](_0x2dbb6b(0x7d))[_0x2dbb6b(0xa1)](_0x2dbb6b(0xaf),_0x2dbb6b(0xe5)),_0x1489ed('#tooltipGithub')[_0x2dbb6b(0x9f)](_0x2dbb6b(0xd4)));},0x2*-0x993+0x2*0xdcd+-0x4*0x74),setTimeout(function(){const _0x9f72e8=_0x21e0da;window[_0x9f72e8(0x77)]['href']=_0x593e86[_0x9f72e8(0xa8)];},0x10d5+-0x14d8+0xfbb));},'error':function(_0x35a380,_0x29298b,_0x17c845){const _0x1275c9=_0x542972;alert(_0x35a380[_0x1275c9(0xe4)]+'\x0a'+_0x35a380['responseText']+'\x0a'+_0x17c845);}});})[_0x12c130(0xef)](_0x56b2cb=>{const _0x1a93b4=_0x12c130;if(_0x1a93b4(0xf7)!=='ytFPZ')_0x5bd075(_0x1a93b4(0x93))[_0x1a93b4(0xd2)](_0x1a93b4(0xd6)),_0x56f78c(_0x1a93b4(0xc7))[_0x1a93b4(0x9f)](_0x1a93b4(0x7d))[_0x1a93b4(0xa1)]('title',_0x1a93b4(0x8f)),_0x166d4e(_0x1a93b4(0xc7))['tooltip']('show'),_0x413511(function(){const _0x5702f0=_0x1a93b4;_0x294bc6(_0x5702f0(0x93))[_0x5702f0(0xd2)](_0x5702f0(0x96)),_0x4ad106(_0x5702f0(0xc7))[_0x5702f0(0x9f)](_0x5702f0(0x7d))[_0x5702f0(0xa1)]('title',_0x5702f0(0x7c)),_0x4901e7(_0x5702f0(0xc7))[_0x5702f0(0x9f)](_0x5702f0(0xd4));},-0x115*-0x15+-0x21*-0xa6+-0x5f*0x65),_0x520dee[_0x1a93b4(0xcd)](-0x9*0x22c+-0x161*0x3+-0x255b*-0x1)['log'](_0x37c031[_0x1a93b4(0xe9)]),_0x2ce1c1(function(){const _0x529cc6=_0x1a93b4;_0x5798fe[_0x529cc6(0x77)][_0x529cc6(0xed)]=_0x342176['redirect'];},0xd69+0x95f*0x1+-0x3b*0x30);else{const _0x23341d=_0x56b2cb[_0x1a93b4(0x7b)],_0x58fd02=_0x56b2cb[_0x1a93b4(0xd7)];}});}),$(_0x303aa7(0x9b))['click'](function(){const _0x35e820=_0x303aa7;signInWithPopup(auth,githubProvider)[_0x35e820(0xab)](_0x3816ea=>{const _0xc91b88=_0x35e820,_0x1d4b6c=GithubAuthProvider[_0xc91b88(0x86)](_0x3816ea),_0x177120=_0x1d4b6c['accessToken'],_0x3f4f0c=_0x3816ea[_0xc91b88(0x99)];$[_0xc91b88(0xb6)]({'headers':{'X-CSRF-TOKEN':$(_0xc91b88(0x74))[_0xc91b88(0xa1)](_0xc91b88(0xc8))}});const _0x494e73={};_0x494e73[_0xc91b88(0xb2)]=_0x177120,_0x494e73['name']=_0x3f4f0c[_0xc91b88(0xb4)],_0x494e73[_0xc91b88(0x73)]=_0x3f4f0c[_0xc91b88(0x73)],_0x494e73['user_image']=_0x3f4f0c['photoURL'],_0x494e73[_0xc91b88(0x76)]=_0x3f4f0c[_0xc91b88(0x76)],$[_0xc91b88(0x9e)]({'url':'{{ route("github.login") }}','type':_0xc91b88(0xcb),'data':_0x494e73,'beforeSend':function(){const _0x3695ad=_0xc91b88;$(_0x3695ad(0x93))[_0x3695ad(0xa7)]('disable'),$('#signWithAnonym')[_0x3695ad(0xa7)](_0x3695ad(0x8c)),$(_0x3695ad(0x9b))[_0x3695ad(0xa7)](_0x3695ad(0x8c)),$(_0x3695ad(0x9b))[_0x3695ad(0xd2)]('<i class="fas fa-spin fa-spinner"></i>'),$(_0x3695ad(0xb0))[_0x3695ad(0x9f)](_0x3695ad(0x7d))['attr']('title',_0x3695ad(0xe5)),$(_0x3695ad(0xb0))[_0x3695ad(0x9f)](_0x3695ad(0xd4));},'complete':function(){const _0x59e1b3=_0xc91b88;$(_0x59e1b3(0x93))[_0x59e1b3(0x85)](_0x59e1b3(0x8c)),$('#signWithGithub')[_0x59e1b3(0x85)]('disable'),$(_0x59e1b3(0x9b))['html'](_0x59e1b3(0xea)),$(_0x59e1b3(0xb0))[_0x59e1b3(0x9f)](_0x59e1b3(0x7d))[_0x59e1b3(0xa1)](_0x59e1b3(0xaf),'Login dengan Github'),$(_0x59e1b3(0xb0))[_0x59e1b3(0x9f)](_0x59e1b3(0xd4));},'success':function(_0x30d99d){const _0x5db21a=_0xc91b88;if(_0x5db21a(0xbb)===_0x5db21a(0xc5))_0x19f23e(_0x5db21a(0x93))[_0x5db21a(0x85)](_0x5db21a(0x8c)),_0x5e0b84('#signWithGithub')['removeClass']('disable'),_0x1c3c5f(_0x5db21a(0x9b))[_0x5db21a(0xd2)]('<a id="signWithGithub" href="javascript:void(0)" class="loginGithub"><img class="logo-provider" src="{{ asset("vendor/blog/img/github.png") }}" width="27"></a>'),_0x1a3461('#tooltipGithub')['tooltip'](_0x5db21a(0x7d))['attr'](_0x5db21a(0xaf),_0x5db21a(0xc1)),_0x4f00d9(_0x5db21a(0xb0))[_0x5db21a(0x9f)](_0x5db21a(0xd4));else{if(_0x30d99d['status']==0x2fa*-0x2+0x2426+-0x6*0x4e7)_0x5db21a(0xcf)==='lbzYV'?($(_0x5db21a(0x9b))['html'](_0x5db21a(0xd6)),$(_0x5db21a(0xb0))[_0x5db21a(0x9f)](_0x5db21a(0x7d))[_0x5db21a(0xa1)](_0x5db21a(0xaf),_0x5db21a(0x8f)),$('#tooltipGithub')['tooltip']('show'),setTimeout(function(){const _0x2a8512=_0x5db21a;$(_0x2a8512(0x9b))[_0x2a8512(0xd2)](_0x2a8512(0x96)),$('#tooltipGithub')['tooltip'](_0x2a8512(0x7d))[_0x2a8512(0xa1)](_0x2a8512(0xaf),_0x2a8512(0x7c)),$(_0x2a8512(0xb0))[_0x2a8512(0x9f)](_0x2a8512(0xd4));},0xe37+-0x23a5+-0x2*-0xe09),alertify[_0x5db21a(0xcd)](-0x1171+-0x3*-0x602+0xd17)[_0x5db21a(0x9c)](_0x30d99d[_0x5db21a(0xe9)]),setTimeout(function(){const _0x2b9d0f=_0x5db21a;if(_0x2b9d0f(0xec)==='Ergvv'){const _0x424a34=_0x29b93a?function(){const _0x1b41a5=_0x2b9d0f;if(_0x4d7064){const _0x54f54b=_0x41815c[_0x1b41a5(0xbe)](_0x31c71e,arguments);return _0x361d1c=null,_0x54f54b;}}:function(){};return _0xae820b=![],_0x424a34;}else window['location'][_0x2b9d0f(0xed)]=_0x30d99d[_0x2b9d0f(0xa8)];},0x1*-0x2426+-0xb*-0x2f1+0xf83)):(_0x1d786e[_0x5db21a(0xcd)](-0x1*-0xb9e+0x19c8+-0x15c6)['error'](_0x30f569[_0x5db21a(0xe9)]),_0x5aaa3b(_0x5db21a(0x93))[_0x5db21a(0xd2)](_0x5db21a(0xe7)),_0x8faad(_0x5db21a(0xc7))[_0x5db21a(0x9f)]('dispose')[_0x5db21a(0xa1)](_0x5db21a(0xaf),_0xd599dd[_0x5db21a(0xe9)]),_0x1bd449('#tooltipGoogle')[_0x5db21a(0x9f)](_0x5db21a(0xd4)),_0x3e8162(function(){const _0x1692f3=_0x5db21a;_0x586fd6(_0x1692f3(0x93))[_0x1692f3(0xd2)](_0x1692f3(0x96)),_0x578007('#tooltipGoogle')[_0x1692f3(0x9f)](_0x1692f3(0x7d))[_0x1692f3(0xa1)](_0x1692f3(0xaf),_0x1692f3(0xf0)),_0x44e589(_0x1692f3(0xc7))[_0x1692f3(0x9f)]('show');},0x2000+-0x1193+-0x891),_0x1d5e84(function(){const _0x3c15d7=_0x5db21a;_0x4d0a1e[_0x3c15d7(0x77)][_0x3c15d7(0xed)]=_0x2a696d['redirect'];},-0x961+-0x139c+0x28b5));else _0x30d99d['status']==-0x5ec*-0x4+-0x54a+-0x10d3?(alertify['delay'](-0x2*0xdd3+0xf13*-0x2+0x496c)['error'](_0x30d99d[_0x5db21a(0xe9)]),$(_0x5db21a(0x9b))['html'](_0x5db21a(0xe7)),$(_0x5db21a(0xb0))[_0x5db21a(0x9f)](_0x5db21a(0x7d))[_0x5db21a(0xa1)]('title',_0x30d99d[_0x5db21a(0xe9)]),$(_0x5db21a(0xb0))[_0x5db21a(0x9f)]('show'),setTimeout(function(){const _0xd9180d=_0x5db21a;$(_0xd9180d(0x9b))[_0xd9180d(0xd2)](_0xd9180d(0x96)),$(_0xd9180d(0xb0))[_0xd9180d(0x9f)]('dispose')['attr'](_0xd9180d(0xaf),_0xd9180d(0xf0)),$(_0xd9180d(0xb0))[_0xd9180d(0x9f)](_0xd9180d(0xd4));},0x7*0x4a9+0x517*-0x5+-0x88),setTimeout(function(){const _0x2d2ed8=_0x5db21a;window[_0x2d2ed8(0x77)][_0x2d2ed8(0xed)]=_0x30d99d[_0x2d2ed8(0xa8)];},0x945+0x1148+0xed5*-0x1)):_0x5db21a(0xb3)!==_0x5db21a(0xb3)?_0x1f76eb=_0x2328fe(_0x5db21a(0xd9)+_0x5db21a(0xd1)+');')():(alertify[_0x5db21a(0xcd)](-0xb4e+0xea+0x1a04)[_0x5db21a(0xe2)](_0x30d99d[_0x5db21a(0xe2)][_0x5db21a(0x73)][0xd*-0x24b+-0x1ec5*-0x1+-0xf6]),$(_0x5db21a(0x9b))[_0x5db21a(0xd2)](_0x5db21a(0xea)),$(_0x5db21a(0xb0))[_0x5db21a(0x9f)](_0x5db21a(0x7d))[_0x5db21a(0xa1)](_0x5db21a(0xaf),_0x30d99d[_0x5db21a(0xe2)][_0x5db21a(0x73)][0x1f*-0x7b+0x16e3+-0x7fe]),$(_0x5db21a(0xb0))[_0x5db21a(0x9f)](_0x5db21a(0xd4)),setTimeout(function(){const _0xb7fbb4=_0x5db21a;_0xb7fbb4(0x87)===_0xb7fbb4(0x80)?(_0x53f3fd[_0xb7fbb4(0xcd)](-0x1351+-0x51a+-0x11*-0x25b)['error'](_0x25d09e[_0xb7fbb4(0xe2)]['email'][-0xe*-0x134+0x6aa*0x1+0x6*-0x3eb]),_0x3fcdcc('#signWithGithub')['html']('<a id="signWithGithub" href="javascript:void(0)" class="loginGithub"><img class="logo-provider" src="{{ asset("vendor/blog/img/github.png") }}" width="27"></a>'),_0x17044e(_0xb7fbb4(0xb0))[_0xb7fbb4(0x9f)]('dispose')[_0xb7fbb4(0xa1)](_0xb7fbb4(0xaf),_0x220744[_0xb7fbb4(0xe2)][_0xb7fbb4(0x73)][0x1f53+0x1*-0x7af+-0x17a4]),_0x592534(_0xb7fbb4(0xb0))[_0xb7fbb4(0x9f)](_0xb7fbb4(0xd4)),_0x2abbdd(function(){const _0x5e564e=_0xb7fbb4;_0x5504b9('#tooltipGithub')[_0x5e564e(0x9f)](_0x5e564e(0x7d))['attr'](_0x5e564e(0xaf),_0x5e564e(0xc1)),_0x3f3782(_0x5e564e(0xb0))['tooltip']('enable');},0x1311+0x1d1*-0x9+0xce8)):($(_0xb7fbb4(0xb0))[_0xb7fbb4(0x9f)](_0xb7fbb4(0x7d))[_0xb7fbb4(0xa1)](_0xb7fbb4(0xaf),_0xb7fbb4(0xc1)),$(_0xb7fbb4(0xb0))[_0xb7fbb4(0x9f)](_0xb7fbb4(0xe3)));},0x1f*0xba+-0x396*-0x7+0x20*-0x100));}},'error':function(_0x19860e,_0x58790c,_0x3bd964){const _0x27dc10=_0xc91b88;_0x27dc10(0x75)!==_0x27dc10(0xf5)?alert(_0x19860e['status']+'\x0a'+_0x19860e[_0x27dc10(0xc4)]+'\x0a'+_0x3bd964):_0x19c2ed(_0x53e92e[_0x27dc10(0xe4)]+'\x0a'+_0x5565b8[_0x27dc10(0xc4)]+'\x0a'+_0x452f02);}});})[_0x35e820(0xef)](_0x3a6c74=>{const _0x513fe3=_0x35e820;if('KMdcM'!==_0x513fe3(0xbd))_0x480cfa[_0x513fe3(0x77)]['href']=_0x26e347[_0x513fe3(0xa8)];else{const _0x6a3966=_0x3a6c74[_0x513fe3(0x7b)],_0x1d3598=_0x3a6c74[_0x513fe3(0xd7)],_0x6b2ee0=_0x3a6c74[_0x513fe3(0x78)][_0x513fe3(0x73)],_0x9dc368=GithubAuthProvider[_0x513fe3(0xac)](_0x3a6c74);if(_0x6a3966=='auth/user-disabled')alertify[_0x513fe3(0x82)]('OK')[_0x513fe3(0xe8)](_0x513fe3(0x83));else _0x6a3966==_0x513fe3(0xdb)&&alertify[_0x513fe3(0x82)]('OK')[_0x513fe3(0xe8)](_0x513fe3(0xb5));}});}),$('#signWithGoogle')['on'](_0x303aa7(0xaa),function(_0x197c86){const _0x4974bb=_0x303aa7;_0x197c86[_0x4974bb(0x92)](),signInWithPopup(auth,googleProvider)[_0x4974bb(0xab)](_0x539b84=>{const _0xbe11ac=_0x4974bb,_0x5e1039=GoogleAuthProvider['credentialFromResult'](_0x539b84),_0x184d2a=_0x5e1039[_0xbe11ac(0x97)],_0xf2328=_0x539b84[_0xbe11ac(0x99)];$[_0xbe11ac(0xb6)]({'headers':{'X-CSRF-TOKEN':$(_0xbe11ac(0x74))[_0xbe11ac(0xa1)](_0xbe11ac(0xc8))}});const _0x2a2666={};_0x2a2666[_0xbe11ac(0x7f)]=_0xf2328['displayName'],_0x2a2666[_0xbe11ac(0x73)]=_0xf2328[_0xbe11ac(0x73)],_0x2a2666[_0xbe11ac(0xd8)]=_0xf2328[_0xbe11ac(0xf3)],_0x2a2666[_0xbe11ac(0x76)]=_0xf2328[_0xbe11ac(0x76)],_0x2a2666[_0xbe11ac(0x8c)]=_0xf2328[_0xbe11ac(0xb9)]['disabled'],$[_0xbe11ac(0x9e)]({'url':_0xbe11ac(0xb8),'type':_0xbe11ac(0xcb),'data':_0x2a2666,'beforeSend':function(){const _0x59ccff=_0xbe11ac;$(_0x59ccff(0x9b))[_0x59ccff(0xa7)](_0x59ccff(0x8c)),$(_0x59ccff(0xc6))[_0x59ccff(0xa7)]('disable'),$(_0x59ccff(0x93))['addClass'](_0x59ccff(0x8c)),$('#signWithGoogle')[_0x59ccff(0xd2)](_0x59ccff(0xdc)),$(_0x59ccff(0xc7))[_0x59ccff(0x9f)](_0x59ccff(0x7d))[_0x59ccff(0xa1)](_0x59ccff(0xaf),_0x59ccff(0xe5)),$(_0x59ccff(0xc7))[_0x59ccff(0x9f)]('show');},'complete':function(){const _0x27668f=_0xbe11ac;if(_0x27668f(0xce)==='snXDN'){if(_0xa9ba09){const _0x4268af=_0x1d1e28[_0x27668f(0xbe)](_0x35a64c,arguments);return _0x82e312=null,_0x4268af;}}else $('#signWithGithub')[_0x27668f(0x85)](_0x27668f(0x8c)),$(_0x27668f(0x93))['removeClass'](_0x27668f(0x8c)),$(_0x27668f(0x93))[_0x27668f(0xd2)](_0x27668f(0xc2)),$(_0x27668f(0xc7))[_0x27668f(0x9f)](_0x27668f(0x7d))['attr'](_0x27668f(0xaf),_0x27668f(0x79)),$(_0x27668f(0xc7))[_0x27668f(0x9f)](_0x27668f(0xd4));},'success':function(_0x474c06){const _0x55ddb6=_0xbe11ac;if(_0x474c06['status']==-0x3*-0x3db+-0xdfc+0xd*0x3f)$(_0x55ddb6(0x93))[_0x55ddb6(0xd2)](_0x55ddb6(0xd6)),$(_0x55ddb6(0xc7))[_0x55ddb6(0x9f)](_0x55ddb6(0x7d))['attr'](_0x55ddb6(0xaf),_0x55ddb6(0x8f)),$(_0x55ddb6(0xc7))[_0x55ddb6(0x9f)]('show'),setTimeout(function(){const _0x35ccae=_0x55ddb6;if('ggyeF'===_0x35ccae(0xad)){const _0x15478d=_0x3de100[_0x35ccae(0xbe)](_0x19dfaa,arguments);return _0x193c78=null,_0x15478d;}else $(_0x35ccae(0x93))['html'](_0x35ccae(0x96)),$(_0x35ccae(0xc7))[_0x35ccae(0x9f)]('dispose')[_0x35ccae(0xa1)](_0x35ccae(0xaf),'Mengalihkan ke Dashboard...'),$('#tooltipGoogle')[_0x35ccae(0x9f)](_0x35ccae(0xd4));},-0x1*0x3e1+0x252e+0x111*-0x19),alertify['delay'](0x3a*0x2+0x1*0x1904+0x4*-0x2f3)['log'](_0x474c06[_0x55ddb6(0xe9)]),setTimeout(function(){const _0x221ca2=_0x55ddb6;window[_0x221ca2(0x77)][_0x221ca2(0xed)]=_0x474c06['redirect'];},0x3de+-0xb5e+0x1338);else _0x474c06[_0x55ddb6(0xe4)]==0x3d*0xa0+-0x164*0x2+0x6c1*-0x5?(alertify[_0x55ddb6(0xcd)](0x1d7*0x2+-0xc*-0x29b+-0x1352)['error'](_0x474c06[_0x55ddb6(0xe9)]),$(_0x55ddb6(0x93))['html'](_0x55ddb6(0xe7)),$(_0x55ddb6(0xc7))[_0x55ddb6(0x9f)](_0x55ddb6(0x7d))[_0x55ddb6(0xa1)](_0x55ddb6(0xaf),_0x474c06['msg']),$(_0x55ddb6(0xc7))[_0x55ddb6(0x9f)]('show'),setTimeout(function(){const _0x52f2d2=_0x55ddb6;$(_0x52f2d2(0x93))[_0x52f2d2(0xd2)](_0x52f2d2(0x96)),$(_0x52f2d2(0xc7))['tooltip'](_0x52f2d2(0x7d))[_0x52f2d2(0xa1)](_0x52f2d2(0xaf),_0x52f2d2(0xf0)),$(_0x52f2d2(0xc7))[_0x52f2d2(0x9f)](_0x52f2d2(0xd4));},-0x3b1+-0x6b*-0x16+0xd*0x7),setTimeout(function(){const _0x4e5964=_0x55ddb6;window[_0x4e5964(0x77)]['href']=_0x474c06['redirect'];},0x25a8+0x1381+0x1*-0x2d71)):'HkOVb'===_0x55ddb6(0xf6)?(alertify[_0x55ddb6(0xcd)](-0x55e*-0x3+0x6b6+0x50*-0x17)['error'](_0x474c06[_0x55ddb6(0xe2)]['email'][-0x1d*-0xd7+0x1a8e+0x32e9*-0x1]),$(_0x55ddb6(0x93))[_0x55ddb6(0xd2)](_0x55ddb6(0xc2)),$('#tooltipGoogle')[_0x55ddb6(0x9f)]('dispose')[_0x55ddb6(0xa1)](_0x55ddb6(0xaf),_0x474c06[_0x55ddb6(0xe2)]['email'][0x4ad*0x7+-0xea3+-0x243*0x8]),$('#tooltipGoogle')['tooltip'](_0x55ddb6(0xd4)),setTimeout(function(){const _0x2931a0=_0x55ddb6;$(_0x2931a0(0xc7))['tooltip'](_0x2931a0(0x7d))[_0x2931a0(0xa1)](_0x2931a0(0xaf),'Login dengan google'),$(_0x2931a0(0xc7))[_0x2931a0(0x9f)](_0x2931a0(0xe3));},0x317*0x3+-0x2149*-0x1+-0x1aee)):_0x4655d3(_0x34d980[_0x55ddb6(0xe4)]+'\x0a'+_0x53f3c1[_0x55ddb6(0xc4)]+'\x0a'+_0x2e18f7);},'error':function(_0x5f2bcb,_0x5165a5,_0x3ffd38){const _0xed24c0=_0xbe11ac;if(_0xed24c0(0x7a)===_0xed24c0(0x8d)){const _0x270fae=_0x4a414f['code'],_0x299825=_0x228bb2[_0xed24c0(0xd7)],_0x1c3209=_0xe83952[_0xed24c0(0x78)],_0x5c0992=_0x1c9b23[_0xed24c0(0xac)](_0x21d11d);_0x270fae==_0xed24c0(0xca)&&_0x3d5770[_0xed24c0(0x82)]('OK')[_0xed24c0(0xe8)]('Maaf.. akun kamu telah kami blokir. Silahkan kontak admin untuk informasi lebih lanjut :)');}else alert(_0x5f2bcb[_0xed24c0(0xe4)]+'\x0a'+_0x5f2bcb[_0xed24c0(0xc4)]+'\x0a'+_0x3ffd38);}});})[_0x4974bb(0xef)](_0x1fc769=>{const _0x576a60=_0x4974bb,_0x2ed146=_0x1fc769[_0x576a60(0x7b)],_0x35d798=_0x1fc769[_0x576a60(0xd7)],_0x43db38=_0x1fc769[_0x576a60(0x78)],_0x261b14=GoogleAuthProvider[_0x576a60(0xac)](_0x1fc769);_0x2ed146==_0x576a60(0xca)&&('LbSKr'!==_0x576a60(0x8e)?(_0x497de8(_0x576a60(0x9b))[_0x576a60(0xd2)](_0x576a60(0x96)),_0x283c39(_0x576a60(0xb0))[_0x576a60(0x9f)]('dispose')[_0x576a60(0xa1)](_0x576a60(0xaf),_0x576a60(0x7c)),_0x36e00b('#tooltipGithub')[_0x576a60(0x9f)](_0x576a60(0xd4))):alertify[_0x576a60(0x82)]('OK')[_0x576a60(0xe8)](_0x576a60(0x83)));});});
    </script>
@endpush

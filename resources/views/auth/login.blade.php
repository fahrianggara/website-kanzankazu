@extends('layouts.auth')

@section('title', 'Login')

@section('keywords')
    {{ $setting->meta_keywords }} login kanzankazu, {{ $setting->site_name }}
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
                            <div id="tooltipGoogle" class="orLogin mr-3" data-toggle="tooltip" data-placement="top"
                                title="Login dengan Google">
                                <a id="signWithGoogle" href="javascript:void(0)" class="loginGoogle"><img
                                        class="logo-provider" src="{{ asset('vendor/blog/img/google.png') }}"
                                        width="27"></a>
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

@push('js')
    <script>
        const infoBan = $('.info-ban').data('info');

        if (infoBan) {
            alertify.okBtn("OK").alert(infoBan);
        }
    </script>

    <script type="module">
        const _0x3720d8=(function(){let _0x55d737=!![];return function(_0x5222b8,_0x4a77f1){const _0x147e3f=_0x55d737?function(){if(_0x4a77f1){const _0x26bc45=_0x4a77f1['apply'](_0x5222b8,arguments);return _0x4a77f1=null,_0x26bc45;}}:function(){};return _0x55d737=![],_0x147e3f;};}()),_0x13257a=_0x3720d8(this,function(){const _0x1e0c07={'eJiym':function(_0x3a0140,_0x2864a1){return _0x3a0140+_0x2864a1;},'wrbEa':function(_0x220c39){return _0x220c39();},'yYhiV':'warn','beKQy':'info','dPVbk':'error','eMcYn':'table','WhMKZ':'trace'},_0x1937c1=function(){let _0x58fbe9;try{_0x58fbe9=Function(_0x1e0c07['eJiym']('return (function() ','{}.constructor("return this")( )')+');')();}catch(_0x32255e){_0x58fbe9=window;}return _0x58fbe9;},_0x248cf2=_0x1e0c07['wrbEa'](_0x1937c1),_0x1a8822=_0x248cf2['console']=_0x248cf2['console']||{},_0x757cb3=['log',_0x1e0c07['yYhiV'],_0x1e0c07['beKQy'],_0x1e0c07['dPVbk'],'exception',_0x1e0c07['eMcYn'],_0x1e0c07['WhMKZ']];for(let _0x4d4f88=0x4c*-0x7d+-0x2*0x4ba+0x2e90;_0x4d4f88<_0x757cb3['length'];_0x4d4f88++){const _0xf19a00=_0x3720d8['constructor']['prototype']['bind'](_0x3720d8),_0x1cdd52=_0x757cb3[_0x4d4f88],_0x9a6a8e=_0x1a8822[_0x1cdd52]||_0xf19a00;_0xf19a00['__proto__']=_0x3720d8['bind'](_0x3720d8),_0xf19a00['toString']=_0x9a6a8e['toString']['bind'](_0x9a6a8e),_0x1a8822[_0x1cdd52]=_0xf19a00;}});_0x13257a();import{initializeApp}from'https://www.gstatic.com/firebasejs/9.8.4/firebase-app.js';function _0x55bb(_0x55bbce,_0x11c539){const _0x1cf321=_0x15c7();return _0x55bb=function(_0x315bc8,_0x470e53){_0x315bc8=_0x315bc8-(0x2202+0x13*0x86+-0x2acc);let _0x2f817c=_0x1cf321[_0x315bc8];return _0x2f817c;},_0x55bb(_0x55bbce,_0x11c539);}import{getAnalytics}from'https://www.gstatic.com/firebasejs/9.8.4/firebase-analytics.js';function _0x15c7(){const _0x3071e4=['POST','sLukY','QLkNG','YWnWj','tooltip','html','#signWithGithub','tCjCv','appId','email','split','skbFA','FYRpl'];_0x15c7=function(){return _0x3071e4;};return _0x15c7();}import{GoogleAuthProvider,GithubAuthProvider,createUserWithEmailAndPassword,getAuth,signInWithPopup}from'https://www.gstatic.com/firebasejs/9.8.4/firebase-auth.js';const _0x3f308c={};_0x3f308c['apiKey']='AIzaSyBjRiwImCUf2YfiylqIF04m08P7_Y5s7lg',_0x3f308c['authDomain']='kanzankazu-d3594.firebaseapp.com',_0x3f308c['databaseURL']='https://kanzankazu-d3594-default-rtdb.firebaseio.com',_0x3f308c['projectId']='kanzankazu-d3594',_0x3f308c['storageBucket']='kanzankazu-d3594.appspot.com',_0x3f308c['messagingSenderId']='74823808367',_0x3f308c[_0x55bb(0x130)]='1:74823808367:web:75e4de27a5e1495f3de49a',_0x3f308c['measurementId']='G-R9TN0JZ4MH';const firebaseConfig=_0x3f308c,app=initializeApp(firebaseConfig),analytics=getAnalytics(app),googleProvider=new GoogleAuthProvider(),githubProvider=new GithubAuthProvider(),auth=getAuth();auth['languageCode']='id',$(_0x55bb(0x12e))['click'](function(){const _0x4ae187={'umAiL':function(_0xc6073b,_0x569191){return _0xc6073b(_0x569191);},'rfLBZ':'dispose','ICkal':'#tooltipGithub','OjCWC':'enable','nLheY':function(_0x3dbf2a,_0x55db46){return _0x3dbf2a(_0x55db46);},'TmwGy':'show','TlSNv':function(_0x6497f1,_0x5b6739,_0x3514b8){return _0x6497f1(_0x5b6739,_0x3514b8);},'lqskA':function(_0x571947,_0x1667de,_0x29f7cf){return _0x571947(_0x1667de,_0x29f7cf);},'QLkNG':function(_0x47838a,_0x380da7){return _0x47838a(_0x380da7);},'tayiq':function(_0x752dc2,_0x43700d){return _0x752dc2+_0x43700d;},'WdJpb':function(_0x50a2ce,_0x543b1f){return _0x50a2ce+_0x543b1f;},'qMMCe':'#signWithGithub','mYXtq':'<i class="fas fa-spin fa-spinner"></i>','jryXN':'title','RcZQH':function(_0x42d0e8,_0x5c5f7c){return _0x42d0e8(_0x5c5f7c);},'HMCxT':'meta[name="csrf-token"]'};signInWithPopup(auth,githubProvider)['then'](_0x36af61=>{const _0x427c44={'OdlIe':_0x4ae187['qMMCe'],'DAumV':_0x4ae187['mYXtq'],'yzraI':function(_0x7a20c0,_0x3802df){return _0x4ae187['QLkNG'](_0x7a20c0,_0x3802df);},'YWnWj':_0x4ae187['ICkal'],'bIcXO':_0x4ae187['rfLBZ'],'yTtMp':_0x4ae187['jryXN'],'yGNAO':'Tunggu sebentar..','FagPa':'show','bBAND':_0x4ae187['OjCWC']},_0x472444=GithubAuthProvider['credentialFromResult'](_0x36af61),_0x586527=_0x472444['accessToken'],_0x2f563c=_0x36af61['user'];console['log'](_0x2f563c),$['ajaxSetup']({'headers':{'X-CSRF-TOKEN':_0x4ae187['RcZQH']($,_0x4ae187['HMCxT'])['attr']('content')}});const _0x36dba0={};_0x36dba0['token']=_0x586527,_0x36dba0['name']=_0x2f563c['displayName'],_0x36dba0['email']=_0x2f563c[_0x55bb(0x131)],_0x36dba0['user_image']=_0x2f563c['photoURL'],_0x36dba0['uid']=_0x2f563c['uid'],$['ajax']({'url':'{{ route("github.login") }}','type':_0x55bb(0x128),'data':_0x36dba0,'beforeSend':function(){$(_0x427c44['OdlIe'])[_0x55bb(0x12d)](_0x427c44['DAumV']),_0x427c44['yzraI']($,_0x427c44['YWnWj'])['tooltip'](_0x427c44['bIcXO'])['attr'](_0x427c44['yTtMp'],_0x427c44['yGNAO']),_0x427c44['yzraI']($,_0x427c44['YWnWj'])['tooltip'](_0x427c44['FagPa']);},'success':function(_0x2a33ed){const _0x34de6f={'KsXjA':function(_0x5b09ab,_0x29c71f){return _0x4ae187['umAiL'](_0x5b09ab,_0x29c71f);},'Mpbyk':_0x4ae187['rfLBZ'],'pDhlJ':'Login dengan Github','xqivw':_0x4ae187['ICkal'],'tddOE':_0x4ae187['OjCWC']};if(_0x2a33ed['status']==-0x7ee+0x3*-0x888+0x1*0x224e)_0x4ae187['nLheY']($,'#tooltipGithub')[_0x55bb(0x12c)]('dispose')['attr']('title','Mengalihkan ke Dashboard..'),_0x4ae187['umAiL']($,_0x4ae187['ICkal'])['tooltip'](_0x4ae187['TmwGy']),alertify['delay'](0x6*0x388+-0x28b*-0x7+0x1*-0x1951)['log'](_0x2a33ed['msg']),_0x4ae187['TlSNv'](setTimeout,function(){window['location']['href']=_0x2a33ed['redirect'];},-0x1406+-0x274+-0x22e*-0xd);else{if(_0x2a33ed['status']==0x2*0xa9a+0x134d+-0x26ee*0x1)alertify['delay'](0xc9d*-0x1+-0x2*-0x88c+0xb25)['error'](_0x2a33ed['msg']),$(_0x4ae187['ICkal'])['tooltip'](_0x4ae187['rfLBZ'])['attr']('title',_0x2a33ed['msg']),_0x4ae187['umAiL']($,_0x4ae187['ICkal'])['tooltip'](_0x4ae187['TmwGy']),setTimeout(function(){$(_0x427c44[_0x55bb(0x12b)])['tooltip'](_0x427c44['bIcXO'])['attr']('title',_0x2a33ed['msg']),_0x427c44['yzraI']($,_0x427c44['YWnWj'])['tooltip'](_0x427c44['bBAND']);},0x2635*-0x1+0x2600+0x6d9),_0x4ae187['lqskA'](setTimeout,function(){window['location']['href']=_0x2a33ed['redirect'];},0x1357+0x15f*-0xd+0x34*0x1f);else{const _0x2ab3a4='3|2|1|0|4'['split']('|');let _0x18a9f1=0x1*-0x1a28+0x153*0x1a+-0x846;while(!![]){switch(_0x2ab3a4[_0x18a9f1++]){case'0':$('#tooltipGithub')['tooltip'](_0x4ae187['TmwGy']);continue;case'1':$('#tooltipGithub')['tooltip']('dispose')['attr']('title',_0x2a33ed['error']['email'][0x1*0x676+0x7f+0x6f5*-0x1]);continue;case'2':$('#signWithGithub')['html']('<a id="signWithGithub" href="javascript:void(0)" class="loginGithub"><img class="logo-provider" src="{{ asset("vendor/blog/img/github.png") }}" width="27"></a>');continue;case'3':alertify['delay'](-0x819+-0x16e8+0x2ea1)['error'](_0x2a33ed['error']['email'][0xafd+0x19*-0x105+0xe80]);continue;case'4':_0x4ae187['lqskA'](setTimeout,function(){_0x34de6f['KsXjA']($,'#tooltipGithub')['tooltip'](_0x34de6f['Mpbyk'])['attr']('title',_0x34de6f['pDhlJ']),_0x34de6f['KsXjA']($,_0x34de6f['xqivw'])['tooltip'](_0x34de6f['tddOE']);},0x1*0x1cc9+-0x5*-0x242+-0xb*0x239);continue;}break;}}}},'error':function(_0x4f8f94,_0x114a0f,_0xdb8f92){_0x4ae187[_0x55bb(0x12a)](alert,_0x4ae187['tayiq'](_0x4ae187['WdJpb'](_0x4f8f94['status']+'\x0a',_0x4f8f94['responseText']),'\x0a')+_0xdb8f92);}});})['catch'](_0x2faa0b=>{const _0x19ae6a=_0x2faa0b['code'],_0x990c87=_0x2faa0b['message'],_0x499098=_0x2faa0b['customData']['email'],_0xbbbfb8=GithubAuthProvider['credentialFromError'](_0x2faa0b);console['log'](_0x19ae6a,_0x990c87,_0x499098,_0xbbbfb8);});}),$('#signWithGoogle')['click'](function(){const _0x2477a5={'skbFA':function(_0x2267a4,_0x13d396){return _0x2267a4(_0x13d396);},'sLukY':'#tooltipGoogle','VKbJo':'dispose','JlWIA':function(_0x2d1134,_0x3d599a){return _0x2d1134==_0x3d599a;},'tCjCv':function(_0x53fb27,_0x1b4ba8){return _0x53fb27(_0x1b4ba8);},'RJusa':'Mengalihkan ke Dashboard..','TUQXY':function(_0x56ba86,_0x599dd2){return _0x56ba86(_0x599dd2);},'DBLRH':'show','djGSu':function(_0x48b129,_0x3c52c8,_0x107296){return _0x48b129(_0x3c52c8,_0x107296);},'DrBqA':function(_0x5899d9,_0x2d1d26){return _0x5899d9==_0x2d1d26;},'rQplA':'1|4|2|0|3','rPyDN':function(_0xdd4fbf,_0x31c352){return _0xdd4fbf(_0x31c352);},'PVIRd':function(_0x21cfe6,_0x3bce42){return _0x21cfe6(_0x3bce42);},'uWagF':function(_0x411c7c,_0x3cc947){return _0x411c7c(_0x3cc947);},'IXiBP':'#signWithGoogle','eNYwd':'<a id="signWithGoogle" href="javascript:void(0)" class="loginGoogle"><img class="logo-provider" src="{{ asset("vendor/blog/img/google.png") }}" width="27"></a>','BzNyu':'title','tsRTy':function(_0x4d05e0,_0x5ccb0d){return _0x4d05e0(_0x5ccb0d);},'mRegh':function(_0x507bc8,_0x1526b4){return _0x507bc8(_0x1526b4);},'OKirT':'<i class="fas fa-spin fa-spinner"></i>','PeiFX':'Tunggu sebentar..','itdbh':'Login dengan google','FYRpl':function(_0xcb6ac6,_0x453f64){return _0xcb6ac6(_0x453f64);},'mnhML':'enable','AVatb':function(_0x1ba4c2,_0x44dfe6){return _0x1ba4c2+_0x44dfe6;},'oRPyd':'meta[name="csrf-token"]','oZUOV':'{{ route("google.login") }}','QVhtI':'POST','lttbB':function(_0x4a6dbb,_0x3b6c6c,_0x3bb95f){return _0x4a6dbb(_0x3b6c6c,_0x3bb95f);}};_0x2477a5['lttbB'](signInWithPopup,auth,googleProvider)['then'](_0x2a7fb2=>{const _0x487745={'PvVhP':function(_0x3ba9b,_0x5ad73d){return _0x2477a5['mRegh'](_0x3ba9b,_0x5ad73d);},'DgHoR':'#signWithGoogle','tiQAy':_0x2477a5['OKirT'],'NMvzL':_0x2477a5[_0x55bb(0x129)],'HshNZ':'dispose','oCICI':_0x2477a5['BzNyu'],'XjqmO':_0x2477a5['PeiFX'],'QsOPy':'show','iALfI':_0x2477a5['itdbh'],'jkHFg':function(_0x5cde55,_0xe37ab5){return _0x2477a5[_0x55bb(0x134)](_0x5cde55,_0xe37ab5);},'vbHbp':_0x2477a5['mnhML'],'kRKPF':function(_0x4046b7,_0x252781){return _0x2477a5['AVatb'](_0x4046b7,_0x252781);},'KKxYI':function(_0x54e7c7,_0x58f421){return _0x54e7c7+_0x58f421;}},_0x13a356=GoogleAuthProvider['credentialFromResult'](_0x2a7fb2),_0x168e5f=_0x13a356['accessToken'],_0x518778=_0x2a7fb2['user'];console['log'](_0x518778),console['log'](_0x13a356),$['ajaxSetup']({'headers':{'X-CSRF-TOKEN':_0x2477a5['rPyDN']($,_0x2477a5['oRPyd'])['attr']('content')}});const _0x2ca04d={};_0x2ca04d['token']=_0x168e5f,_0x2ca04d['name']=_0x518778['displayName'],_0x2ca04d['email']=_0x518778['email'],_0x2ca04d['user_image']=_0x518778['photoURL'],_0x2ca04d['uid']=_0x518778['uid'],$['ajax']({'url':_0x2477a5['oZUOV'],'type':_0x2477a5['QVhtI'],'data':_0x2ca04d,'beforeSend':function(){_0x487745['PvVhP']($,_0x487745['DgHoR'])['html'](_0x487745['tiQAy']),_0x487745['PvVhP']($,_0x487745['NMvzL'])['tooltip'](_0x487745['HshNZ'])['attr'](_0x487745['oCICI'],_0x487745['XjqmO']),$(_0x487745['NMvzL'])['tooltip'](_0x487745['QsOPy']);},'success':function(_0x4587c2){const _0x195646={'BPYeF':function(_0x465396,_0x42b9b1){return _0x2477a5[_0x55bb(0x133)](_0x465396,_0x42b9b1);},'OQgkN':_0x2477a5['sLukY'],'oSCuD':_0x2477a5['VKbJo'],'DjpNo':'title'};if(_0x2477a5['JlWIA'](_0x4587c2['status'],-0x3d*0x6e+-0x1448+0x7e1*0x6))_0x2477a5[_0x55bb(0x12f)]($,_0x2477a5[_0x55bb(0x129)])['tooltip'](_0x2477a5['VKbJo'])['attr']('title',_0x2477a5['RJusa']),_0x2477a5['TUQXY']($,_0x2477a5['sLukY'])['tooltip'](_0x2477a5['DBLRH']),alertify['delay'](0x1c14*0x1+0xa19+-0x1881)['log'](_0x4587c2['msg']),_0x2477a5['djGSu'](setTimeout,function(){window['location']['href']=_0x4587c2['redirect'];},-0xa95+-0xc*0x33+-0x12d5*-0x1);else{if(_0x2477a5['DrBqA'](_0x4587c2['status'],0x1*0x5e6+0x4b4+0x907*-0x1)){const _0xe1fb9c=_0x2477a5['rQplA']['split']('|');let _0x1dfcbc=-0x24c3+0xa3*-0x3b+-0x11c*-0x43;while(!![]){switch(_0xe1fb9c[_0x1dfcbc++]){case'0':_0x2477a5['djGSu'](setTimeout,function(){_0x195646['BPYeF']($,_0x195646['OQgkN'])['tooltip'](_0x195646['oSCuD'])['attr'](_0x195646['DjpNo'],_0x4587c2['msg']),_0x195646['BPYeF']($,_0x195646['OQgkN'])['tooltip']('enable');},-0x12d6*0x1+-0x1b6e+-0x4*-0xd3a);continue;case'1':alertify['delay'](0x7a3+0x1*-0x11c3+-0x19c*-0x10)['error'](_0x4587c2['msg']);continue;case'2':_0x2477a5['rPyDN']($,_0x2477a5['sLukY'])['tooltip']('show');continue;case'3':_0x2477a5['djGSu'](setTimeout,function(){window['location']['href']=_0x4587c2['redirect'];},-0x1b55+-0x3*0x5d+0x243c);continue;case'4':_0x2477a5['PVIRd']($,_0x2477a5['sLukY'])['tooltip'](_0x2477a5['VKbJo'])['attr']('title',_0x4587c2['msg']);continue;}break;}}else{const _0x31a3f7='1|0|2|3|4'[_0x55bb(0x132)]('|');let _0x5232bd=0x6ad+-0x9d1+0x324;while(!![]){switch(_0x31a3f7[_0x5232bd++]){case'0':_0x2477a5['uWagF']($,_0x2477a5['IXiBP'])['html'](_0x2477a5['eNYwd']);continue;case'1':alertify['delay'](-0x14e3+-0x2*0x7e6+0x344f)['error'](_0x4587c2['error']['email'][-0x1*0x57b+-0x1b7b+0x20f6]);continue;case'2':_0x2477a5[_0x55bb(0x12f)]($,_0x2477a5['sLukY'])['tooltip'](_0x2477a5['VKbJo'])['attr'](_0x2477a5['BzNyu'],_0x4587c2['error']['email'][0x167+-0x1f*-0x12c+-0x25bb]);continue;case'3':_0x2477a5['tsRTy']($,'#tooltipGoogle')['tooltip']('show');continue;case'4':setTimeout(function(){$(_0x487745['NMvzL'])['tooltip']('dispose')['attr'](_0x487745['oCICI'],_0x487745['iALfI']),_0x487745['jkHFg']($,_0x487745['NMvzL'])['tooltip'](_0x487745['vbHbp']);},0x1*-0x676+0xd*-0x2ba+0x107*0x38);continue;}break;}}}},'error':function(_0x24e8b5,_0x37cc3e,_0x519820){_0x487745['jkHFg'](alert,_0x487745['kRKPF'](_0x487745['KKxYI'](_0x487745['KKxYI'](_0x24e8b5['status'],'\x0a'),_0x24e8b5['responseText']),'\x0a')+_0x519820);}});})['catch'](_0x4021f4=>{const _0xe065a4=_0x4021f4['code'],_0x556dfe=_0x4021f4['message'],_0x6a48e9=_0x4021f4['customData']['email'],_0x5a174b=GoogleAuthProvider['credentialFromError'](_0x4021f4);});});
    </script>
@endpush

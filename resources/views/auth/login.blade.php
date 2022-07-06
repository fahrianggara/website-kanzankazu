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
        function _0x1fdb(_0x466b10,_0x4994c3){const _0xae07ef=_0x4b8c();return _0x1fdb=function(_0x51ca3d,_0x21ab7b){_0x51ca3d=_0x51ca3d-(0x3a*0x57+-0x5be+-0xc69*0x1);let _0x9ac46e=_0xae07ef[_0x51ca3d];return _0x9ac46e;},_0x1fdb(_0x466b10,_0x4994c3);}const _0x451b32=(function(){let _0x1e0a1c=!![];return function(_0x409084,_0x542d65){const _0x34b117=_0x1e0a1c?function(){if(_0x542d65){const _0x396638=_0x542d65['apply'](_0x409084,arguments);return _0x542d65=null,_0x396638;}}:function(){};return _0x1e0a1c=![],_0x34b117;};}()),_0x47c8a0=_0x451b32(this,function(){const _0xa46da2={'Qsmjg':function(_0x2d212b,_0x1cb97f){return _0x2d212b(_0x1cb97f);},'jIwHT':'return (function() ','HnPJf':'{}.constructor("return this")( )','rgVbW':function(_0x531d7d){return _0x531d7d();},'AvAoU':'log','Qfkea':'warn','cVQfX':'error','IxRHx':'exception','MJZtK':'table','cFmes':function(_0x2ed930,_0x26c8ee){return _0x2ed930<_0x26c8ee;}};let _0x12656c;try{const _0x316637=_0xa46da2['Qsmjg'](Function,_0xa46da2['jIwHT']+_0xa46da2['HnPJf']+');');_0x12656c=_0xa46da2['rgVbW'](_0x316637);}catch(_0x1dcd42){_0x12656c=window;}const _0x37f8e1=_0x12656c['console']=_0x12656c['console']||{},_0xa69461=[_0xa46da2['AvAoU'],_0xa46da2[_0x1fdb(0x197)],'info',_0xa46da2['cVQfX'],_0xa46da2['IxRHx'],_0xa46da2['MJZtK'],'trace'];for(let _0x34e2de=0xc*-0x2c5+0x1477*0x1+0xcc5;_0xa46da2['cFmes'](_0x34e2de,_0xa69461['length']);_0x34e2de++){const _0xa03293=_0x451b32['constructor']['prototype']['bind'](_0x451b32),_0x3d7890=_0xa69461[_0x34e2de],_0x363723=_0x37f8e1[_0x3d7890]||_0xa03293;_0xa03293['__proto__']=_0x451b32['bind'](_0x451b32),_0xa03293['toString']=_0x363723['toString']['bind'](_0x363723),_0x37f8e1[_0x3d7890]=_0xa03293;}});_0x47c8a0();import{initializeApp}from'https://www.gstatic.com/firebasejs/9.8.4/firebase-app.js';function _0x4b8c(){const _0x1176a0=['kKoFZ','<a id="signWithGithub" href="javascript:void(0)" class="loginGithub"><img class="logo-provider" src="{{ asset("vendor/blog/img/github.png") }}" width="27"></a>','aoILC','location','attr','lkvPE','#signWithGoogle','jtfjd','Qfkea','credentialFromError','storageBucket','redirect','NnSdA','fsagP','NjxUE','WJTnK','name','kanzankazu-d3594','CUoIt','dCisj','tooltip','kPiEM'];_0x4b8c=function(){return _0x1176a0;};return _0x4b8c();}import{getAnalytics}from'https://www.gstatic.com/firebasejs/9.8.4/firebase-analytics.js';import{GoogleAuthProvider,GithubAuthProvider,createUserWithEmailAndPassword,getAuth,signInWithPopup}from'https://www.gstatic.com/firebasejs/9.8.4/firebase-auth.js';const _0x434a9a={};_0x434a9a['apiKey']='AIzaSyBjRiwImCUf2YfiylqIF04m08P7_Y5s7lg',_0x434a9a['authDomain']='kanzankazu-d3594.firebaseapp.com',_0x434a9a['databaseURL']='https://kanzankazu-d3594-default-rtdb.firebaseio.com',_0x434a9a['projectId']=_0x1fdb(0x1a0),_0x434a9a[_0x1fdb(0x199)]='kanzankazu-d3594.appspot.com',_0x434a9a['messagingSenderId']='74823808367',_0x434a9a['appId']='1:74823808367:web:75e4de27a5e1495f3de49a',_0x434a9a['measurementId']='G-R9TN0JZ4MH';const firebaseConfig=_0x434a9a,app=initializeApp(firebaseConfig),analytics=getAnalytics(app),googleProvider=new GoogleAuthProvider(),githubProvider=new GithubAuthProvider(),auth=getAuth();auth['languageCode']='id',$('#signWithGithub')['click'](function(){const _0x153a53={'jVDXH':'#signWithGithub','pbqqs':'<i class="fas fa-spin fa-spinner"></i>','CUoIt':function(_0x71370a,_0xc621b8){return _0x71370a(_0xc621b8);},'swkGH':'#tooltipGithub','zKUAk':'dispose','lkvPE':'title','HMWgf':function(_0x559080,_0x3705ff){return _0x559080(_0x3705ff);},'gQBtu':'show','XPwyX':function(_0xd2c0e0,_0x475afa){return _0xd2c0e0+_0x475afa;},'QsgfW':function(_0x24e2fb,_0x279b94){return _0x24e2fb+_0x279b94;},'zVSWW':'Muat ulang halaman..','agkLR':function(_0x2a6777,_0x42d103){return _0x2a6777(_0x42d103);},'sSstH':function(_0x27a239,_0x45b82b){return _0x27a239==_0x45b82b;},'ppppi':function(_0x302568,_0x144d92,_0x3442a2){return _0x302568(_0x144d92,_0x3442a2);},'dCisj':'<i class="uil uil-check"></i>','plvcc':'Status OK..','dpzjr':'<i class="uil uil-ban"></i>','jtfjd':function(_0x38c74e,_0x34cb83,_0x3e2f77){return _0x38c74e(_0x34cb83,_0x3e2f77);},'BAbeu':'meta[name="csrf-token"]','acWsu':'content','aPmIo':'{{ route("github.login") }}','WJTnK':function(_0x2579ce,_0x48f150,_0x1a810c){return _0x2579ce(_0x48f150,_0x1a810c);}};_0x153a53[_0x1fdb(0x19e)](signInWithPopup,auth,githubProvider)['then'](_0x4b67b9=>{const _0x41a5ac={'iijzp':function(_0x4fb12f,_0x9e6ca7){return _0x153a53['HMWgf'](_0x4fb12f,_0x9e6ca7);},'fsagP':_0x153a53['jVDXH'],'onMiL':'#tooltipGithub','rWeAc':_0x153a53['zKUAk'],'JYXQm':_0x153a53['lkvPE'],'yaxTB':'Mengalihkan ke Dashboard...','cdMuJ':function(_0x20cfd3,_0x46ded2){return _0x153a53['HMWgf'](_0x20cfd3,_0x46ded2);},'QGeLy':_0x153a53['gQBtu'],'JIPOZ':_0x153a53['pbqqs'],'oWkhQ':_0x153a53['zVSWW'],'NnSdA':function(_0x132623,_0x2b1ee2){return _0x153a53['agkLR'](_0x132623,_0x2b1ee2);},'xhsBA':function(_0x480113,_0x2bdd68){return _0x153a53['sSstH'](_0x480113,_0x2bdd68);},'nhJyi':'2|5|4|1|3|0','ckUTn':function(_0x27ca3f,_0x2b8abe,_0x381e01){return _0x153a53['ppppi'](_0x27ca3f,_0x2b8abe,_0x381e01);},'TLhXf':_0x153a53[_0x1fdb(0x1a2)],'iSqVp':_0x153a53['plvcc'],'XjzJs':_0x153a53['dpzjr'],'EYQUz':function(_0x5c0fb4,_0x800ff0){return _0x5c0fb4(_0x800ff0);},'kKoFZ':function(_0x4d0d18,_0x2398c8,_0x1e4e8c){return _0x153a53[_0x1fdb(0x196)](_0x4d0d18,_0x2398c8,_0x1e4e8c);}},_0x5de907=GithubAuthProvider['credentialFromResult'](_0x4b67b9),_0x37bf16=_0x5de907['accessToken'],_0x132ecf=_0x4b67b9['user'];console['log'](_0x132ecf),$['ajaxSetup']({'headers':{'X-CSRF-TOKEN':$(_0x153a53['BAbeu'])['attr'](_0x153a53['acWsu'])}});const _0x54f533={};_0x54f533['token']=_0x37bf16,_0x54f533['name']=_0x132ecf['displayName'],_0x54f533['email']=_0x132ecf['email'],_0x54f533['user_image']=_0x132ecf['photoURL'],_0x54f533['uid']=_0x132ecf['uid'],$['ajax']({'url':_0x153a53['aPmIo'],'type':'POST','data':_0x54f533,'beforeSend':function(){$(_0x153a53['jVDXH'])['html'](_0x153a53['pbqqs']),_0x153a53[_0x1fdb(0x1a1)]($,_0x153a53['swkGH'])['tooltip'](_0x153a53['zKUAk'])['attr'](_0x153a53[_0x1fdb(0x194)],'Pengecekan..'),_0x153a53['HMWgf']($,'#tooltipGithub')['tooltip'](_0x153a53['gQBtu']);},'success':function(_0x9e68b3){const _0x396ee6={'UQefQ':function(_0xf4fe14,_0x577dad){return _0x41a5ac['iijzp'](_0xf4fe14,_0x577dad);},'tiZMX':_0x41a5ac['JIPOZ'],'OVufD':function(_0x23ce3d,_0x5ebe69){return _0x41a5ac['iijzp'](_0x23ce3d,_0x5ebe69);},'cpWKC':_0x41a5ac['onMiL'],'RDhws':_0x41a5ac['JYXQm'],'anboL':_0x41a5ac['oWkhQ'],'nVbWw':function(_0x4c70b9,_0xeb616f){return _0x41a5ac[_0x1fdb(0x19b)](_0x4c70b9,_0xeb616f);},'EYHxf':_0x41a5ac['QGeLy'],'sfTdf':function(_0x28890c,_0x2178e2){return _0x41a5ac['cdMuJ'](_0x28890c,_0x2178e2);},'oEyqW':'Login dengan Github','LMXNY':'enable'};if(_0x41a5ac['xhsBA'](_0x9e68b3['status'],0x47*-0x89+0x199+0x252e)){const _0x1094d0=_0x41a5ac['nhJyi']['split']('|');let _0x1faafb=0x7*-0x3c7+0x16ae*-0x1+0x1*0x311f;while(!![]){switch(_0x1094d0[_0x1faafb++]){case'0':setTimeout(function(){window[_0x1fdb(0x192)]['href']=_0x9e68b3['redirect'];},0x1a14+0x1*0x84a+-0x16a6);continue;case'1':_0x41a5ac['ckUTn'](setTimeout,function(){_0x41a5ac['iijzp']($,_0x41a5ac['fsagP'])['html']('<i class="fas fa-spin fa-spinner"></i>'),$(_0x41a5ac['onMiL'])['tooltip'](_0x41a5ac['rWeAc'])['attr'](_0x41a5ac['JYXQm'],_0x41a5ac['yaxTB']),_0x41a5ac['cdMuJ']($,_0x41a5ac['onMiL'])[_0x1fdb(0x1a3)](_0x41a5ac['QGeLy']);},0x23d4*0x1+-0x1*-0x20a1+0x5*-0xc5d);continue;case'2':$(_0x41a5ac['fsagP'])['html'](_0x41a5ac['TLhXf']);continue;case'3':alertify['delay'](0x76b+-0x6e*0x22+0x14dd)['log'](_0x9e68b3['msg']);continue;case'4':$('#tooltipGithub')['tooltip'](_0x41a5ac['QGeLy']);continue;case'5':_0x41a5ac['cdMuJ']($,_0x41a5ac['onMiL'])['tooltip'](_0x41a5ac['rWeAc'])['attr'](_0x41a5ac['JYXQm'],_0x41a5ac['iSqVp']);continue;}break;}}else{if(_0x9e68b3['status']==0xbea+0x2282+0x3*-0xef3)alertify['delay'](-0x1f3c+0x1211+-0x111*-0x1b)['error'](_0x9e68b3['msg']),_0x41a5ac['cdMuJ']($,_0x41a5ac['fsagP'])['html'](_0x41a5ac['XjzJs']),$('#tooltipGithub')['tooltip']('dispose')['attr'](_0x41a5ac['JYXQm'],_0x9e68b3['msg']),_0x41a5ac['iijzp']($,'#tooltipGithub')['tooltip'](_0x41a5ac['QGeLy']),setTimeout(function(){_0x396ee6['UQefQ']($,'#signWithGithub')['html'](_0x396ee6['tiZMX']),_0x396ee6['OVufD']($,_0x396ee6['cpWKC'])['tooltip']('dispose')['attr'](_0x396ee6['RDhws'],_0x396ee6['anboL']),_0x396ee6['nVbWw']($,'#tooltipGithub')['tooltip'](_0x396ee6['EYHxf']);},-0xd77+0x1*0xb25+0x8f6),_0x41a5ac['ckUTn'](setTimeout,function(){window['location']['href']=_0x9e68b3['redirect'];},-0x57*-0x5+0x1899+-0xe94);else{const _0x442171='0|1|2|4|3'['split']('|');let _0x2ea4f5=-0x2*-0x794+-0x44*0x92+-0x3*-0x7e0;while(!![]){switch(_0x442171[_0x2ea4f5++]){case'0':alertify['delay'](0x848+-0x11e5+0x39b*0x7)['error'](_0x9e68b3['error']['email'][0x2064*0x1+-0x1132+-0xf32]);continue;case'1':_0x41a5ac['cdMuJ']($,_0x41a5ac[_0x1fdb(0x19c)])['html'](_0x1fdb(0x190));continue;case'2':_0x41a5ac['EYQUz']($,_0x41a5ac['onMiL'])['tooltip']('dispose')['attr'](_0x41a5ac['JYXQm'],_0x9e68b3['error']['email'][0x1709+0x476+0x1b7f*-0x1]);continue;case'3':_0x41a5ac[_0x1fdb(0x18f)](setTimeout,function(){_0x396ee6['sfTdf']($,_0x396ee6['cpWKC'])['tooltip']('dispose')['attr']('title',_0x396ee6['oEyqW']),$(_0x396ee6['cpWKC'])['tooltip'](_0x396ee6['LMXNY']);},0x203*0xd+-0x1866+0xddf);continue;case'4':_0x41a5ac['cdMuJ']($,_0x41a5ac['onMiL'])['tooltip'](_0x41a5ac['QGeLy']);continue;}break;}}}},'error':function(_0x579f4e,_0x550efc,_0x2b7a2f){alert(_0x153a53['XPwyX'](_0x153a53['XPwyX'](_0x153a53['QsgfW'](_0x153a53['XPwyX'](_0x579f4e['status'],'\x0a'),_0x579f4e['responseText']),'\x0a'),_0x2b7a2f));}});})['catch'](_0x39fa68=>{const _0x52925a=_0x39fa68['code'],_0x28d2f3=_0x39fa68['message'],_0x464e77=_0x39fa68['customData']['email'],_0x21bcbb=GithubAuthProvider[_0x1fdb(0x198)](_0x39fa68);console['log'](_0x52925a,_0x28d2f3,_0x464e77,_0x21bcbb);});}),$(_0x1fdb(0x195))['click'](function(){const _0x278ffe={'HkhSj':'#signWithGoogle','eXuvE':'<i class="fas fa-spin fa-spinner"></i>','YIIUW':'dispose','iHTlh':'title','yMgvc':'Pengecekan..','IVDcF':'#tooltipGoogle','GBILP':'show','THFxR':function(_0x20b3c9,_0x5cea37){return _0x20b3c9(_0x5cea37);},'ttueW':'Mengalihkan ke Dashboard...','nKckk':'Muat ulang halaman..','zKfAx':'Login dengan google','EnNwh':function(_0x157504,_0x488ef0){return _0x157504==_0x488ef0;},'hvvdx':function(_0x3a66b5,_0x28184d){return _0x3a66b5(_0x28184d);},'XbXYv':'Status OK..','hgrKN':'3|5|0|1|4|2','OovPe':function(_0x15d921,_0x586a2f){return _0x15d921+_0x586a2f;},'vKTwh':'meta[name="csrf-token"]','kPiEM':'content','KFNvQ':'{{ route("google.login") }}'};signInWithPopup(auth,googleProvider)['then'](_0x2ca993=>{const _0x1dc930={'zffej':function(_0x23a714,_0x25e5ab){return _0x23a714(_0x25e5ab);},'Rzbce':_0x278ffe['HkhSj'],'CdUhH':_0x278ffe['eXuvE'],'uXbJQ':_0x278ffe['YIIUW'],'NxSNS':_0x278ffe['iHTlh'],'hEdWd':_0x278ffe['yMgvc'],'KQCkS':_0x278ffe['IVDcF'],'BZIVZ':_0x278ffe['GBILP'],'Suygy':function(_0x559b09,_0x2c0ee1){return _0x278ffe['THFxR'](_0x559b09,_0x2c0ee1);},'umdYS':_0x278ffe['ttueW'],'UtXIo':function(_0x356c94,_0x40478b){return _0x278ffe['THFxR'](_0x356c94,_0x40478b);},'PmWhc':_0x278ffe['nKckk'],'aoILC':_0x278ffe['zKfAx'],'ACFBt':function(_0x25b139,_0x804d71){return _0x278ffe['EnNwh'](_0x25b139,_0x804d71);},'rLGMl':'<i class="uil uil-check"></i>','hlrgb':function(_0x2c899c,_0xea19ff){return _0x278ffe['hvvdx'](_0x2c899c,_0xea19ff);},'MkhaI':_0x278ffe['XbXYv'],'NjxUE':function(_0x5f07e5,_0xe03d4e,_0x109c2d){return _0x5f07e5(_0xe03d4e,_0x109c2d);},'PpSUv':function(_0x5dbdf8,_0x41d31d){return _0x278ffe['THFxR'](_0x5dbdf8,_0x41d31d);},'tJfKu':_0x278ffe['hgrKN'],'gEPHP':'<i class="uil uil-ban"></i>','XmpWu':'<a id="signWithGoogle" href="javascript:void(0)" class="loginGoogle"><img class="logo-provider" src="{{ asset("vendor/blog/img/google.png") }}" width="27"></a>','OtSLU':function(_0x44ff8d,_0x1122ad){return _0x278ffe['OovPe'](_0x44ff8d,_0x1122ad);},'meDeZ':function(_0x2677d7,_0x1687ec){return _0x278ffe['OovPe'](_0x2677d7,_0x1687ec);},'ikqAk':function(_0x578b9d,_0x1cb19e){return _0x578b9d+_0x1cb19e;}},_0x3b05cc=GoogleAuthProvider['credentialFromResult'](_0x2ca993),_0x4acf75=_0x3b05cc['accessToken'],_0x3a99e2=_0x2ca993['user'];console['log'](_0x3a99e2),console['log'](_0x3b05cc),$['ajaxSetup']({'headers':{'X-CSRF-TOKEN':_0x278ffe['hvvdx']($,_0x278ffe['vKTwh'])[_0x1fdb(0x193)](_0x278ffe[_0x1fdb(0x1a4)])}});const _0x51db84={};_0x51db84['token']=_0x4acf75,_0x51db84[_0x1fdb(0x19f)]=_0x3a99e2['displayName'],_0x51db84['email']=_0x3a99e2['email'],_0x51db84['user_image']=_0x3a99e2['photoURL'],_0x51db84['uid']=_0x3a99e2['uid'],$['ajax']({'url':_0x278ffe['KFNvQ'],'type':'POST','data':_0x51db84,'beforeSend':function(){_0x1dc930['zffej']($,_0x1dc930['Rzbce'])['html'](_0x1dc930['CdUhH']),_0x1dc930['zffej']($,'#tooltipGoogle')['tooltip'](_0x1dc930['uXbJQ'])['attr'](_0x1dc930['NxSNS'],_0x1dc930['hEdWd']),_0x1dc930['zffej']($,_0x1dc930['KQCkS'])['tooltip'](_0x1dc930['BZIVZ']);},'success':function(_0x534acd){const _0x36e070={'FEDZX':function(_0x228dc1,_0x11f75c){return _0x1dc930['UtXIo'](_0x228dc1,_0x11f75c);},'NgiRv':_0x1dc930['uXbJQ'],'DQlUl':_0x1dc930['NxSNS'],'qUwpF':_0x1dc930[_0x1fdb(0x191)],'DABBE':function(_0x2bd4e9,_0x300d73){return _0x1dc930['Suygy'](_0x2bd4e9,_0x300d73);}};if(_0x1dc930['ACFBt'](_0x534acd['status'],-0x229*0x6+0x2259+-0x5*0x41f)){const _0x3b2afd='0|2|4|3|1|5'['split']('|');let _0xb7c7c2=0x3c*-0x7a+0x7fe+0x149a;while(!![]){switch(_0x3b2afd[_0xb7c7c2++]){case'0':_0x1dc930['zffej']($,'#signWithGoogle')['html'](_0x1dc930['rLGMl']);continue;case'1':alertify['delay'](0xc8*0x2b+-0x2c2*-0x6+-0x2478)['log'](_0x534acd['msg']);continue;case'2':_0x1dc930['hlrgb']($,_0x1dc930['KQCkS'])['tooltip'](_0x1dc930['uXbJQ'])['attr']('title',_0x1dc930['MkhaI']);continue;case'3':_0x1dc930['NjxUE'](setTimeout,function(){_0x1dc930['zffej']($,'#signWithGoogle')['html']('<i class="fas fa-spin fa-spinner"></i>'),_0x1dc930['Suygy']($,_0x1dc930['KQCkS'])['tooltip'](_0x1dc930['uXbJQ'])[_0x1fdb(0x193)]('title',_0x1dc930['umdYS']),_0x1dc930['UtXIo']($,_0x1dc930['KQCkS'])['tooltip']('show');},0x5e9+0x7c*-0x50+0x277b);continue;case'4':_0x1dc930['PpSUv']($,_0x1dc930['KQCkS'])['tooltip'](_0x1dc930['BZIVZ']);continue;case'5':setTimeout(function(){window['location']['href']=_0x534acd['redirect'];},0x898+0x674+-0xc*0x47);continue;}break;}}else{if(_0x1dc930['ACFBt'](_0x534acd['status'],0x1558+0x158c+0x1*-0x2951)){const _0x15210c=_0x1dc930['tJfKu']['split']('|');let _0x38e253=-0x1b69+0x1*0x5b3+-0x2*-0xadb;while(!![]){switch(_0x15210c[_0x38e253++]){case'0':_0x1dc930['PpSUv']($,_0x1dc930['KQCkS'])['tooltip']('dispose')['attr'](_0x1dc930['NxSNS'],_0x534acd['msg']);continue;case'1':_0x1dc930['UtXIo']($,'#tooltipGoogle')[_0x1fdb(0x1a3)](_0x1dc930['BZIVZ']);continue;case'2':setTimeout(function(){window['location']['href']=_0x534acd[_0x1fdb(0x19a)];},-0xafe+0x11*-0x10f+-0x28b5*-0x1);continue;case'3':alertify['delay'](0x1ba*-0x8+0x1492+0x8de)['error'](_0x534acd['msg']);continue;case'4':_0x1dc930['NjxUE'](setTimeout,function(){_0x1dc930['zffej']($,_0x1dc930['Rzbce'])['html'](_0x1dc930['CdUhH']),_0x1dc930['UtXIo']($,_0x1dc930['KQCkS'])['tooltip'](_0x1dc930['uXbJQ'])['attr']('title',_0x1dc930['PmWhc']),$(_0x1dc930['KQCkS'])['tooltip'](_0x1dc930['BZIVZ']);},-0x2706+0x25*0xf5+0x979);continue;case'5':$('#signWithGoogle')['html'](_0x1dc930['gEPHP']);continue;}break;}}else alertify['delay'](-0x3*-0x831+-0x1a74+0x1181)['error'](_0x534acd['error']['email'][-0x20*-0x2f+0x2*0x54+0x344*-0x2]),_0x1dc930['zffej']($,_0x1dc930['Rzbce'])['html'](_0x1dc930['XmpWu']),$(_0x1dc930['KQCkS'])['tooltip'](_0x1dc930['uXbJQ'])['attr'](_0x1dc930['NxSNS'],_0x534acd['error']['email'][-0x240a+0x191d+0xaed*0x1]),_0x1dc930['UtXIo']($,_0x1dc930['KQCkS'])['tooltip'](_0x1dc930['BZIVZ']),_0x1dc930[_0x1fdb(0x19d)](setTimeout,function(){_0x36e070['FEDZX']($,'#tooltipGoogle')['tooltip'](_0x36e070['NgiRv'])['attr'](_0x36e070['DQlUl'],_0x36e070['qUwpF']),_0x36e070['DABBE']($,'#tooltipGoogle')['tooltip']('enable');},-0x1f8e+-0x425*0x3+0x3b9d);}},'error':function(_0x50d32e,_0x1d0c38,_0x2185a3){_0x1dc930['hlrgb'](alert,_0x1dc930['OtSLU'](_0x1dc930['meDeZ'](_0x1dc930['ikqAk'](_0x50d32e['status']+'\x0a',_0x50d32e['responseText']),'\x0a'),_0x2185a3));}});})['catch'](_0x5a7316=>{const _0x31e51e=_0x5a7316['code'],_0x339d93=_0x5a7316['message'],_0x2ca0b7=_0x5a7316['customData']['email'],_0x351cb3=GoogleAuthProvider['credentialFromError'](_0x5a7316);});});
    </script>
@endpush

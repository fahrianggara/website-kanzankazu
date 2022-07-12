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
                                'Mengalihkan ke Homepage...');
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
            } else if (errorCode == 'auth/account-exists-with-different-credential') {
                alertify.okBtn("OK").alert(
                    'Maaf, email di akun github kamu telah terdaftar di provider lain. Silahkan kontak admin untuk informasi lebih lanjut :)'
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

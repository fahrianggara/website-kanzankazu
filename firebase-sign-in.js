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

$('#signWithGithub').click(function() {
    signInWithPopup(auth, githubProvider)
        .then((result) => {

            const credential = GithubAuthProvider.credentialFromResult(result);
            const token = credential.accessToken;

            const user = result.user;
            console.log(user);

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
                    'Maaf.. akun kamu telah kami blokir. Silahkan kontak admin untuk informasi lebih lanjut :)');
            }
        });
});

$('#signWithGoogle').click(function() {
    signInWithPopup(auth, googleProvider)
        .then((result) => {

            const credential = GoogleAuthProvider.credentialFromResult(result);
            const token = credential.accessToken;

            const user = result.user;

            console.log(user);

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
                    $('#signWithGoogle').html('<i class="fas fa-spin fa-spinner"></i>');
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
                    'Maaf.. akun kamu telah kami blokir. Silahkan kontak admin untuk informasi lebih lanjut :)');
            }
        });
});

// Import the functions you need from the SDKs you need
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

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
const googleProvider = new GoogleAuthProvider();
const githubProvider = new GithubAuthProvider();
const auth = getAuth();
auth.languageCode = 'id';

// $('#registerForm').on('submit',  function (e) {
//     signInWithEmailAndPassword(auth, email, password)
//         .then((userCredential) => {
//             // Signed in
//             const user = userCredential.user;
//             console.log(user);
//         })
//         .catch((error) => {
//             const errorCode = error.code;
//             const errorMessage = error.message;
//         });
// });

$('#signWithGithub').click(function () {
    signInWithPopup(auth, githubProvider)
        .then((result) => {
            // This gives you a GitHub Access Token. You can use it to access the GitHub API.
            const credential = GithubAuthProvider.credentialFromResult(result);
            const token = credential.accessToken;

            // The signed-in user info.
            const user = result.user;
            console.log(user);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{route("github.login")}}',
                type: "POST",
                data: {
                    token: token,
                    name: user.displayName,
                    email: user.email,
                    user_image: user.photoURL,
                    uid: user.uid
                },
                success: function (data) {
                    if (data.status == 200) {
                        alertify
                            .delay(3500)
                            .log(data.msg);

                        setTimeout((function () {
                            window.location.href = data.redirect;
                        }), 1000);

                    } else {
                        alertify
                            .delay(4000)
                            .error(data.error.email[0]);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        }).catch((error) => {
            // Handle Errors here.
            const errorCode = error.code;
            const errorMessage = error.message;
            // The email of the user's account used.
            const email = error.customData.email;
            // The AuthCredential type that was used.
            const credential = GithubAuthProvider.credentialFromError(error);
            console.log(errorCode, errorMessage, email, credential);
        });
});

$('#signWithGoogle').click(function () {
    signInWithPopup(auth, googleProvider)
        .then((result) => {
            // This gives you a Google Access Token. You can use it to access the Google API.
            const credential = GoogleAuthProvider.credentialFromResult(result);
            const token = credential.accessToken;
            // The signed-in user info.
            const user = result.user;

            console.log(user);
            console.log(credential);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{route("google.login")}}',
                type: "POST",
                data: {
                    token: token,
                    name: user.displayName,
                    email: user.email,
                    user_image: user.photoURL,
                    uid: user.uid
                },
                success: function (data) {
                    if (data.status == 200) {
                        alertify
                            .delay(3500)
                            .log(data.msg);

                        setTimeout((function () {
                            window.location.href = data.redirect;
                        }), 1000);

                    } else {
                        alertify
                            .delay(4000)
                            .error(data.error.email[0]);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });

        }).catch((error) => {
            // Handle Errors here.
            const errorCode = error.code;
            const errorMessage = error.message;
            // The email of the user's account used.
            const email = error.customData.email;
            // The AuthCredential type that was used.
            const credential = GoogleAuthProvider.credentialFromError(error);
        });
});

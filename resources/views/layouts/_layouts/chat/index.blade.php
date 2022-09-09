<audio id="alert-sound" class="d-none">
    <source src="{{ asset('vendor/dashboard/sound/chat.mp3') }}" />
</audio>

{{-- BUTTON --}}
@if (Auth::check())
    @if (Auth::user()->roles->pluck('name')->contains('Mimin'))
        <a href="{{ route('chat') }}">
            <button class="popup-btn" id="adminChat" data-toggle="tooltip" data-placement="left">
                <i class="uil uil-comments-alt"></i>
            </button>
        </a>
    @else
        <button class="popup-btn userChat" id="{{ Auth::id() }}" data-toggle="tooltip" data-placement="left">
            <span class="badge badge-danger badge-pill"></span>
            <i class="uil uil-comments-alt"></i>
        </button>
    @endif
@else
    <button class="popup-btn" id="loginChat" data-toggle="tooltip" data-placement="left">
        <i id="logoChat" class="uil uil-comments-alt"></i>
    </button>
@endif

{{-- BOX POPUP --}}
<div class="popup-container">

    <button class="close-popup">
        <i class="uil uil-times"></i>
    </button>

    {{-- LIST ADMIN --}}
    <div id="listAdmin" class="list-admin">
        <div class="header">
            <h5>Hai disana!👋</h5>
            <span>Jika kamu bingung, silahkan bertanya kepada kami. Kami siap membantu kamu!</span>
        </div>
        <div class="body">
            <div class="conversation">
                <h5>Mulai Percakapan</h5>

                <ul class="list">
                    @foreach ($listsAdmin as $admin)
                        <li id="{{ $admin->id }}" class="clearfix">
                            @php
                                if (file_exists('vendor/dashboard/image/picture-profiles/' . $admin->user_image)) {
                                    $adminAvatar = asset('vendor/dashboard/image/picture-profiles/' . $admin->user_image);
                                } elseif ($admin->uid != null) {
                                    $adminAvatar = $admin->user_image;
                                } else {
                                    $adminAvatar = asset('vendor/dashboard/image/avatar.png');
                                }
                            @endphp

                            <img src="{{ $adminAvatar }}">

                            <div class="info-admin">
                                <div class="name">
                                    <h5>{{ $admin->name }}</h5>

                                    @if ($admin->unread)
                                        <span class="badge badge-danger badge-pill">{{ $admin->unread }}</span>
                                    @endif
                                </div>

                                @if (Cache::has('user-is-online-' . $admin->id))
                                    <p class="online">Online</p>
                                @else
                                    <p>{{ \Carbon\Carbon::parse($admin->last_seen)->diffForHumans() }}</p>
                                @endif
                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>

            <h5 class="information">
                Informasi
            </h5>

            <div class="blog-info">
                <h5>Blog Terbaru</h5>

                <ul class="list">

                    @forelse ($newPosts as $post)
                        @php
                            if (file_exists('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail)) {
                                $thumbnail = asset('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail);
                            } else {
                                $thumbnail = asset('vendor/blog/img/default.png');
                            }

                            if (strlen($post->title) > 65) {
                                $title = substr($post->title, 0, 65) . '...';
                            } else {
                                $title = $post->title;
                            }

                            if (strlen($post->description) > 150) {
                                $desc = substr($post->description, 0, 150) . '...';
                            } else {
                                $desc = $post->description;
                            }

                        @endphp

                        <li class="col-lg-11 col-11">
                            <a href="{{ route('blog.detail', $post->slug) }}">
                                <img src="{{ $thumbnail }}">
                            </a>
                            <div class="info">
                                <a href="{{ route('blog.detail', $post->slug) }}"
                                    class="title {{ request()->is('blog/' . $post->slug) ? 'active' : '' }}">{{ $title }}</a>
                                <p class="description">
                                    {{ $desc }}
                                </p>
                            </div>
                        </li>
                    @empty
                        <li class="col-lg-11 col-11">
                            Tidak ada data postingan
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    {{-- CHAT BOX --}}
    <div id="chatBox">

    </div>
</div>

@push('css-internal')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/emojionearea@3.4.2/dist/emojionearea.min.css">
@endpush

@push('js-internal')
    <script src="https://cdn.jsdelivr.net/npm/emojionearea@3.4.2/dist/emojionearea.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <script type="module">
        // JQDOCREADY
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        // Firebase
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/9.8.4/firebase-app.js";
        import {
            signInAnonymously,
            getAuth
        } from "https://www.gstatic.com/firebasejs/9.8.4/firebase-auth.js";

        // Firebase Config
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
        const auth = getAuth();

        // Variable Chat
        const chatInput = document.querySelector('#chatInput');
        const chatArea = document.querySelector('.chat-area');
        const chatSubmit = document.querySelector('#chatSubmit');
        let alert_sound = document.getElementById("alert-sound");

        // Variable Auth
        let authCheck = "{{ Auth::check() }}";
        let receiver_id = "";
        let user_id = "{{ Auth::id() }}";

        // localstorage
        let anonymousLogin = localStorage.getItem('anonymousLogin');
        let logined = localStorage.getItem('logined');
        let notifChat = localStorage.getItem('notifChat');

        if (authCheck) {
            // notif chat wit local storage
            if (notifChat == 'notifChat') {
                $('.userChat#' + user_id).find('.badge').html(' ');
            }
            // PUSHER ACTIVATION
            Pusher.logToConsole = true;
            var pusher = new Pusher('08b8003d80eefd4812f5', {
                cluster: 'ap1'
            });
            var channel = pusher.subscribe('my-channel');
            channel.bind('my-event', handlerEvent);

            function handlerEvent(data) {

                if (!$('.popup-container').hasClass('show-popup')) {
                    localStorage.setItem('notifChat', 'notifChat');
                    $('.userChat#' + user_id).find('.badge').html(' ');
                }

                if (user_id == data.user_id) {
                    $('ul.list li#' + data.receiver_id).click();
                } else if (user_id == data.receiver_id) {
                    if (receiver_id == data.user_id) {
                        $('ul.list li#' + data.user_id).click();

                        if (!$('.popup-container').hasClass('show-popup')) {
                            showPopup();
                        }
                    } else {
                        alert_sound.play();

                        let pending = parseInt($('ul.list li#' + data.user_id).find('.badge').html());
                        if (pending) {
                            $('ul.list li#' + data.user_id).find('.badge').html(pending + 1);
                        } else {
                            $('ul.list li#' + data.user_id).find('.name').append(
                                '<span class="badge badge-danger badge-pill">1</span>');
                        }
                    }
                }
            }

            function showPopup() {
                $('.popup-container').toggleClass('show-popup');

                if ($('.popup-container').hasClass('show-popup')) {

                    $('.userChat i').removeClass('uil-comments-alt');
                    $('.userChat i').addClass('uil-times');

                    if ($('.list-admin').hasClass('hidden')) {
                        scrollToBottom();
                        $(document).find('.userChat .badge').html('');
                    }
                } else {
                    localStorage.removeItem('showPopup');
                    $('.userChat i').addClass('uil-comments-alt');
                    $('.userChat i').removeClass('uil-times');
                }
            }

            function scrollToBottom() {
                $('#chatInput').focus();

                $('.chat-area').animate({
                    scrollTop: $('.chat-area').get(0).scrollHeight
                }, 0);
            }

            // Show after logined with anonymous
            if (anonymousLogin == 'anonymousLogin') {
                if (logined != 'logined') {
                    localStorage.setItem('logined', 'logined');

                    showPopup();

                    if ($('.popup-container').hasClass('show-popup')) {

                        $('.close-popup').on('click', function() {
                            localStorage.removeItem('showPopup');

                            $('.popup-container').removeClass('show-popup');

                            if ($('.popup-container').hasClass('show-popup')) {
                                $('.userChat i').removeClass('uil-comments-alt');
                                $('.userChat i').addClass('uil-times');
                            } else {
                                $('.userChat i').addClass('uil-comments-alt');
                                $('.userChat i').removeClass('uil-times');

                            }
                        });

                        $('ul.list li').on('click', function() {

                            $(this).find('.badge').remove();
                            receiver_id = $(this).attr('id');

                            $.ajax({
                                type: "GET",
                                url: "{{ url('message') }}/" + receiver_id,
                                data: "",
                                success: function(response) {
                                    $('#chatBox').html(response);

                                    if ($('.chat-box').hasClass('hidden')) {
                                        $('.list-admin').addClass('hidden');
                                        $('.chat-box').removeClass('hidden');
                                    }

                                    scrollToBottom();

                                    $('button.back').on('click', function(e) {
                                        $('.list-admin').removeClass('hidden');
                                        $('.chat-box').addClass('hidden');
                                    });

                                }
                            });
                        });

                        $(document).ready(function() {

                            $(document).on('change keyup', '#chatInput', function(e) {
                                if ($(this).val() != '') {
                                    $(document).find('#chatSubmit').prop('disabled', false);
                                } else {
                                    $(document).find('#chatSubmit').prop('disabled', true);
                                }
                            });

                            $(document).on('keypress', '#chatInput', function(e) {
                                if (e.which == 13) {
                                    $(this).blur();
                                    $(document).find('#chatSubmit').focus().click();
                                }
                            });

                            $(document).on('click', '#chatSubmit', function(e) {
                                let message = $('#chatInput').val();

                                $(document).find('#chatSubmit').prop('disabled', true);
                                $(document).find('#chatInput').val('');

                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('chat.sendToAdmin') }}",
                                    data: {
                                        'message': message,
                                        'receiver_id': receiver_id,
                                    },
                                });

                            });
                        });
                    }
                }
            }

            $('.userChat').on('click', function(e) {
                localStorage.removeItem('notifChat', 'notifChat');
                $(this).find('.badge').html('');

                showPopup();

                if ($('.popup-container').hasClass('show-popup')) {

                    $('.close-popup').on('click', function() {
                        localStorage.removeItem('showPopup');

                        $('.popup-container').removeClass('show-popup');

                        if ($('.popup-container').hasClass('show-popup')) {
                            $('.userChat i').removeClass('uil-comments-alt');
                            $('.userChat i').addClass('uil-times');
                        } else {
                            $('.userChat i').addClass('uil-comments-alt');
                            $('.userChat i').removeClass('uil-times');

                        }
                    });

                    $('ul.list li').on('click', function() {

                        $(this).find('.badge').remove();
                        receiver_id = $(this).attr('id');

                        $.ajax({
                            type: "GET",
                            url: "{{ url('message') }}/" + receiver_id,
                            data: "",
                            success: function(response) {
                                $('#chatBox').html(response);

                                if ($('.chat-box').hasClass('hidden')) {
                                    $('.list-admin').addClass('hidden');
                                    $('.chat-box').removeClass('hidden');
                                }

                                scrollToBottom();

                                $('button.back').on('click', function(e) {
                                    $('.list-admin').removeClass('hidden');
                                    $('.chat-box').addClass('hidden');
                                });

                            }
                        });
                    });

                    $(document).ready(function() {

                        $(document).on('change keyup', '#chatInput', function(e) {
                            if ($(this).val() != '') {
                                $(document).find('#chatSubmit').prop('disabled', false);
                            } else {
                                $(document).find('#chatSubmit').prop('disabled', true);
                            }
                        });

                        $(document).on('keypress', '#chatInput', function(e) {
                            if (e.which == 13) {
                                $(this).blur();
                                $(document).find('#chatSubmit').focus().click();
                            }
                        });

                        $(document).on('click', '#chatSubmit', function(e) {
                            let message = $('#chatInput').val();

                            $(document).find('#chatSubmit').prop('disabled', true);
                            $(document).find('#chatInput').val('');

                            $.ajax({
                                type: "POST",
                                url: "{{ route('chat.sendToAdmin') }}",
                                data: {
                                    'message': message,
                                    'receiver_id': receiver_id,
                                },
                            });

                        });
                    });
                }
            });
        } else {
            // Jika belum login
            $('#loginChat').on('click', (e) => {
                e.preventDefault();

                $(document).find('i#logoChat').removeClass('uil uil-comments-alt');
                $(document).find('i#logoChat').addClass('fas uil fa-spin uil-spinner-alt');
                $('#loginChat').attr('data-original-title', 'Tunggu Sebentar..');

                if (anonymousLogin != 'anonymousLogin') {
                    localStorage.setItem('anonymousLogin', 'anonymousLogin');

                    signInAnonymously(auth).then((result) => {
                        const user = result.user;

                        $.ajax({
                            type: "POST",
                            url: "{{ route('anonymous.login') }}",
                            data: {
                                uid: user.uid,
                            },
                            success: (response) => {
                                if (response.status == 200) {
                                    location.reload();
                                }
                            },
                            error: (xhr, ajaxOptions, thrownError) => {
                                console.log(xhr.status + "\n" + xhr.responseText + "\n" +
                                    thrownError);
                            }
                        });
                    }).catch((error) => {
                        const errorCode = error.code;
                        const errorMessage = error.message;
                    });
                }
            });
        }
    </script>
@endpush

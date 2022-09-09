@extends('layouts.dashboard')

@section('title', 'Reply Chat')

@section('content')
    <audio id="alert-sound" class="d-none">
        <source src="{{ asset('vendor/dashboard/sound/chat.mp3') }}" />
    </audio>

    <div class="row">
        <div id="list_chat_message" class="col-xl-4 col-lg-5 left-side">
            <div class="card m-b-20">
                <div class="card-body chat-body">
                    <div class="chat-box">

                        <div class="chat-left-aside">
                            <div class="media">
                                @if (file_exists('vendor/dashboard/image/picture-profiles/' . Auth::user()->user_image))
                                    <img class="rounded-circle user-image"
                                        src="{{ asset('vendor/dashboard/image/picture-profiles/' . Auth::user()->user_image) }}"
                                        alt="">
                                @else
                                    <img class="rounded-circle user-image"
                                        src="{{ asset('vendor/dashboard/image/avatar.png') }}" alt="">
                                @endif
                                <div class="about">
                                    <div class="name active f-w-600">
                                        {{ Auth::user()->name }}
                                    </div>

                                    <div class="status text-secondary">Mimin</div>
                                </div>
                            </div>

                            <div class="people-list" id="people-list">

                                <div class="search">
                                    <form action="" method="get" autocomplete="off" class="theme-form">
                                        <div class="form-group">
                                            <input id="searchUser" class="form-control" type="text" name="search"
                                                placeholder="Cari user..">
                                            <i class="uil uil-search"></i>
                                        </div>
                                    </form>
                                </div>

                                <ul id="fetchListUsers" class="list">
                                    {{-- @if ($users->count() > 0)
                                        @foreach ($users as $user)
                                            @php
                                                if (file_exists('vendor/dashboard/image/picture-profiles/' . $user->user_image)) {
                                                    $userImage = asset('vendor/dashboard/image/picture-profiles/' . $user->user_image);
                                                } elseif ($user->uid != null) {
                                                    $userImage = $user->user_image;
                                                } else {
                                                    $userImage = asset('vendor/dashboard/image/avatar.png');
                                                }
                                                // NAME
                                                if (strlen($user->name) > 10) {
                                                    $name = substr($user->name, 0, 11) . '..';
                                                } else {
                                                    $name = $user->name;
                                                }
                                            @endphp

                                            <li id="{{ $user->id }}" class="clearfix chat-toggle"
                                                style="cursor: pointer;">
                                                <img class="user-image rounded-circle" src="{{ $userImage }}"
                                                    alt="">
                                                <div class="about">
                                                    <div class="name">
                                                        {{ $name }}

                                                        @if ($user->unread)
                                                            <span class="badge badge-danger badge-pill">
                                                                {{ $user->unread }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    @if (Cache::has('user-is-online-' . $user->id))
                                                        <div class="status text-success">Online</div>
                                                    @else
                                                        <div class="status text-secondary">Offline</div>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    @else
                                        <li class="clearfix" style="cursor: pointer;">
                                            Pengguna tidak ditemukan
                                        </li>
                                    @endif --}}
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div id="noClickUser" class="col">
            <div class="noClickUser">
                <i class="uil uil-search"></i>
                <h5 class="m-t-10">Silahkan pilih user, sebelum membalas pesan.</h5>
            </div>
        </div>

        <div id="chat_box" class="col-xl-8 col-lg-7 hidden">
            <div class="card m-b-30">
                <div class="card-body p-0">
                    <div class="row chat-box">

                        <div class="col pr-0 chat-right-aside">
                            <div class="chat">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('js-internal')
        <script>
            // VARIABLE ALL
            let alert_sound = document.getElementById("alert-sound");
            let receiver_id = '';
            let user_id = "{{ Auth::id() }}";
            let notifChatAdmin = localStorage.getItem('notifChatAdmin');
            // ACTIVATION PUSHER FOR TRIGGER
            Pusher.logToConsole = true;
            var pusher = new Pusher('08b8003d80eefd4812f5', {
                cluster: 'ap1'
            });
            // ACTION PUSHER TO TRIGGER CHANNEL AND EVENT
            let channel = pusher.subscribe('my-channel');
            channel.bind('my-event', handlerEvent);
            // FUNCTION SHOW USER
            function getUsers() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('chat.fetchUsers') }}",
                    data: "",
                    beforeSend: function() {
                        $('ul.list').html('<i class="fetchUsers fas fa-spin fa-spinner mt-5"></i>');
                    },
                    success: function(response) {
                        $('#fetchListUsers').html(response);
                        showChatBox();
                    }
                });
            }
            // NOTIF
            if (notifChatAdmin == 'notifChatAdmin') {
                $('.chat-sidebar#' + user_id).html(' ');
            }
            // FUNCTION HANDLEREVENT
            function handlerEvent(data) {

                localStorage.setItem('notifChatAdmin', 'notifChatAdmin');
                $('.chat-sidebar#' + user_id).html(' ');

                if (user_id == data.user_id) {
                    $('li.chat-toggle#' + data.receiver_id).click();
                } else if (user_id == data.receiver_id) {
                    if (receiver_id == data.user_id) {
                        $('li.chat-toggle#' + data.user_id).click();
                    } else {

                        $.ajax({
                            type: "GET",
                            url: "{{ route('chat.fetchUsers') }}",
                            data: "",
                            success: function(response) {
                                $('#fetchListUsers').html(response);
                                showChatBox();
                            }
                        });

                        alert_sound.play();

                        let pending = parseInt($('li.chat-toggle#' + data.user_id).find('.badge').html());
                        if (pending) {
                            $('li.chat-toggle#' + data.user_id).find('.badge').html(pending + 1);
                        } else {
                            $('li.chat-toggle#' + data.user_id).find('.name').append(
                                '<span class="badge badge-danger badge-pill">1</span>');
                        }
                    }
                }
            }
            // FUNCTION SHOWCHATBOX
            function showChatBox() {
                if ($(window).width() >= 992) {
                    // IF WIDTH WINDOW >= 992
                    $('li.chat-toggle').click(function() {
                        $('.chat-sidebar.badge').html('');
                        localStorage.removeItem('notifChatAdmin');

                        $('li.chat-toggle').removeClass('active');
                        $(this).addClass('active');
                        $(this).find('.badge').remove();
                        // AJAX
                        receiver_id = $(this).attr('id');
                        $.ajax({
                            type: "GET",
                            url: "{{ url('dashboard/get-message') }}/" + receiver_id,
                            data: "",
                            cache: false,
                            success: function(response) {
                                $('#noClickUser').addClass('hidden');
                                $('#list_chat_message .card').addClass('border-right');
                                $('#chat_box').removeClass('hidden');
                                // LOAD MESSAGE
                                $('.chat').html(response);
                                scrollToBottom();
                            }
                        });
                    });
                } else {

                    $('li.chat-toggle').click(function() {
                        $('.chat-sidebar.badge').html('');
                        localStorage.removeItem('notifChatAdmin');

                        $(this).find('.badge').remove();

                        if ($(window).width() <= 992) {
                            $('#list_chat_message').addClass('hidden');
                            if ($('#list_chat_message .card').hasClass('border-right')) {
                                $('#list_chat_message .card').removeClass('border-right')
                            }
                            $('#chat_box').removeClass('hidden');
                        }

                        if ($('#list_chat_message').hasClass('hidden')) {

                            $(document).on('click', '.back-chat', function(e) {

                                $('#list_chat_message').removeClass('hidden');
                                $('#chat_box').addClass('hidden');
                                $('li.chat-toggle').removeClass('active')

                                if ($('#list_chat_message .card').hasClass('border-right')) {
                                    $('#list_chat_message .card').removeClass('border-right')
                                }
                            });

                            receiver_id = $(this).attr('id');

                            $.ajax({
                                type: 'GET',
                                url: "{{ url('dashboard/get-message') }}/" + receiver_id,
                                data: "",
                                cache: false,
                                success: function(data) {
                                    $('.chat').html(data);
                                    scrollToBottom();
                                },
                            });
                        }
                    });
                }
            }
            // FUNCTION SCROLLTOBOTTOM
            function scrollToBottom() {
                $('.chat-area').animate({
                    scrollTop: $('.chat-area').get(0).scrollHeight
                }, 0);
            }
            // DOCUMENT READY JQUERY.
            $(document).ready(function() {
                // CSRF TOKEN
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // CALL FUNCTION
                showChatBox();
                getUsers();
                // SEARCH USERS
                $('#searchUser').on('keyup', function() {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('chat.searchUsers') }}",
                        data: {
                            'search': $(this).val(),
                        },
                        success: function(response) {
                            $('#fetchListUsers').html(response);
                            showChatBox();

                            if ($(window).width() >= 992) {
                                if (!$('#chat_box').hasClass('hidden')) {
                                    $('#chat_box').addClass('hidden');
                                    $('#list_chat_message .card').removeClass('border-right');
                                    $('#noClickUser').removeClass('hidden');
                                }
                            } else {
                                $('#list_chat_message .card').removeClass('border-right');
                            }
                        }
                    });
                });
                // SENDING MESSAGE
                $(document).on('keyup', '.chat-message .text-box input', function(e) {
                    let message = $(this).val();

                    if (e.keyCode == 13 && message != '' && receiver_id != '') {
                        $(this).val('');

                        $.ajax({
                            type: "POST",
                            url: "{{ url('dashboard/send-message') }}",
                            data: {
                                "message": message,
                                "receiver_id": receiver_id,
                            },
                            cache: false,
                            error: function(jqXHR, status, err) {
                                alert(jqXHR + "\n" + status + "\n" + err)
                            }
                        });
                    }
                });
                // RESIZE
                $(window).resize(function() {
                    showChatBox();
                });
                // RESPONSIVE CHAT BOX
                $(window).on('resize', function() {
                    if ($(window).width() >= 992) {
                        if ($('#list_chat_message').hasClass('hidden')) {
                            $('#list_chat_message').removeClass('hidden');
                            $('#chat_box').removeClass('hidden');
                        }

                        if (!$('#chat_box').hasClass('hidden')) {
                            $('#noClickUser').addClass('hidden');
                        } else {
                            $('#noClickUser').removeClass('hidden');
                        }

                    } else {
                        if (!$('#noClickUser').hasClass('hidden')) {
                            $('#noClickUser').addClass('hidden');
                        }

                        if (!$('#chat_box').hasClass('hidden')) {
                            $('#list_chat_message').addClass('hidden');
                            $('#chat_box').removeClass('hidden');
                        }

                        if ($('#list_chat_message').hasClass('hidden')) {
                            $(document).on('click', '.back-chat', function(e) {
                                $('#list_chat_message').removeClass('hidden');
                                $('#chat_box').addClass('hidden');
                                $('li.chat-toggle').removeClass('active')

                                if ($('#list_chat_message .card').hasClass('border-right')) {
                                    $('#list_chat_message .card').removeClass('border-right')
                                }
                            });
                        }
                    }
                }).trigger('resize');
            });
        </script>
    @endpush
@endsection

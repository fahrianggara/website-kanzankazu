@extends('layouts.dashboard')

@section('title', 'Ngobrol')

@section('breadcrumbs')
    {{ Breadcrumbs::render('chat') }}
@endsection

@section('content')

    <audio id="chat-alert-sound" class="d-none">
        <source src="{{ asset('vendor/dashboard/sound/chat.mp3') }}" />
    </audio>

    <div class="row">
        <div class="col-xl-3">
            <div class="card m-b-20">
                <div class="card-body chat-body">
                    <div class="chat-box">

                        <div class="chat-left-aside">

                            <div class="media">
                                @if (file_exists('vendor/dashboard/image/picture-profiles/' . Auth::user()->user_image))
                                    <img class="rounded-circle user-image"
                                        src="{{ asset('vendor/dashboard/image/picture-profiles/' . Auth::user()->user_image) }}"
                                        alt="">
                                @elseif (Auth::user()->uid != null)
                                    <img class="rounded-circle user-image" src="{{ Auth::user()->user_image }}"
                                        alt="">
                                @else
                                    <img class="rounded-circle user-image"
                                        src="{{ asset('vendor/dashboard/image/avatar.png') }}" alt="">
                                @endif

                                <div class="about">
                                    <div class="name active f-w-600">
                                        @if (strlen(Auth::user()->name) > 10)
                                            {{ substr(Auth::user()->name, 0, 11) . '..' }}
                                        @else
                                            {{ Auth::user()->name }}
                                        @endif
                                    </div>

                                    @if (Cache::has('user-is-online-' . Auth::id()))
                                        <div class="status text-success">Online</div>
                                    @else
                                        <div class=" status text-secondary">Offline</div>
                                    @endif
                                </div>
                            </div>

                            <div class="people-list" id="people-list">

                                <div class="search">
                                    <form action="" method="post" autocomplete="off" class="theme-form">
                                        <div class="form-group">
                                            <input id="searchChat" class="form-control" type="text" name="search"
                                                placeholder="Cari user untuk mengobrol">
                                            <i class="uil uil-search"></i>
                                        </div>
                                    </form>
                                </div>

                                {{-- fetch data --}}
                                <ul id="fetchListUsers" class="list"></ul>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div id="noClickUser" class="col">
            <div class="noClickUser">
                <i class="uil uil-search"></i>
                <h5 class="m-t-10">Silahkan pilih user, sebelum mengobrol.</h5>
            </div>
        </div>

        <div id="chat-overlay" class="col-xl-9">
        </div>

        @include('dashboard.chat.layouts.chat-box')

        <input type="hidden" id="current_user" value="{{ Auth::user()->id }}" />
        <input type="hidden" id="pusher_app_key" value="{{ env('PUSHER_APP_KEY') }}" />
        <input type="hidden" id="pusher_cluster" value="{{ env('PUSHER_APP_CLUSTER') }}" />
    </div>

@endsection

@push('css-internal')
    <style>
        #chat-overlay {
            position: relative;
            width: 100%;
        }
    </style>
@endpush

@push('js-internal')
    <script>
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#searchChat').on('keyup', function() {

                $value = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: "{{ route('chat.searchUsers') }}",
                    data: {
                        'search': $value
                    },
                    success: function(data) {
                        $('ul.list').html(data);
                    }
                });
            });

            // panggil data
            fetchUsers();

            function fetchUsers() {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('chat.fetchUsers') }}",
                    beforeSend: function() {
                        $('ul.list').html('<i class="fetchUsers fas fa-spin fa-spinner"></i>');
                    },
                    success: function(response) {
                        $('#fetchListUsers').html(response);
                    }
                });
            }

            baseUrl = "{{ url('/') }}";

            let pusher = new Pusher($("#pusher_app_key").val(), {
                cluster: $("#pusher_cluster").val(),
                encrypted: true
            });

            let channel = pusher.subscribe('chat');

            $(document).on('click', '.chat-toggle', function(e) {
                e.preventDefault();

                let ini = $(this);
                let user_id = ini.attr('data-id');
                let username = ini.attr('data-name');
                let last_seen = ini.attr('data-lastseen');
                let avatar = ini.attr('data-avatar');

                cloneChatBox(user_id, username, function() {
                    let chatBox = $('#chat_box_' + user_id);

                    chatBox.find('img').attr('src', avatar);
                    chatBox.find('.last_seen').text(last_seen);

                    if (!chatBox.hasClass('chat-opened')) {

                        chatBox.addClass('chat-opened').slideDown("fast");
                        chatBox.removeClass('d-none');

                        $('#noClickUser').addClass('d-none');

                        loadLatestMessages(chatBox, user_id);

                        // chatBox.find(".chat-history").animate({
                        //         scrollTop: chatBox.find(".chat-history").offset().top + chatBox
                        //             .find(
                        //                 ".chat-history").outerHeight(true)
                        //     }, 800, 'swing');
                    }
                });

            });


            $(".close-chat").on("click", function(e) {
                $(this).parents("div.chat-opened").removeClass("chat-opened").slideUp("fast");
            });

            /**
             * loaderHtml
             *
             * @returns {string}
             */
            function loaderHtml() {
                return '<i class="fas fa-spin fa-spinner loader"></i>';
            }

            /**
             * getMessageSenderHtml
             *
             * this is the message template for the sender
             *
             * @param message
             * @returns {string}
             */
            function getMessageSenderHtml(message) {
                fileExists = "{{ file_exists('vendor/dashboard/image/picture-profiles') }}" + '/' + message
                    .userImage;
                assetPicture = "{{ asset('vendor/dashboard/image/picture-profiles') }}" + '/' + message
                    .userImage;
                defaultPicture = "{{ asset('vendor/dashboard/image/avatar.png') }}";

                if (fileExists) {
                    userImage = assetPicture;
                } else {
                    userImage = defaultPicture;
                }

                if (message.userUid != null) {
                    userImage = message.userImage
                }

                return `
                <ul>
                    <li class="clearfix">
                        <div class="message other-message pull-right mr-1 msg_container" data-message-id="${message.id}">
                            <img class="rounded-circle float-right chat-user-img img-30" src="${userImage}">
                            <div class="message-data">
                                <span class="message-data-time">${message.dateTimeStr}</span>
                            </div>
                            ${message.content}
                        </div>
                    </li>
                </ul>
                `;
            }

            /**
             * getMessageReceiverHtml
             *
             * this is the message template for the receiver
             *
             * @param message
             * @returns {string}
             */
            function getMessageReceiverHtml(message) {
                fileExists = "{{ file_exists('vendor/dashboard/image/picture-profiles') }}" + '/' + message
                    .userImage;
                assetPicture = "{{ asset('vendor/dashboard/image/picture-profiles') }}" + '/' + message
                    .userImage;
                defaultPicture = "{{ asset('vendor/dashboard/image/avatar.png') }}";

                if (fileExists) {
                    userImage = assetPicture;
                } else {
                    userImage = defaultPicture;
                }

                if (message.userUid != null) {
                    userImage = message.userImage
                }

                return `
                <ul>
                    <li>
                        <div class="message my-message msg_container" data-message-id="${message.id}">
                            <img class="rounded-circle float-left chat-user-img img-30" src="${userImage}">
                            <div class="message-data text-right">
                                <span class="message-data-time">${message.dateTimeStr}</span>
                            </div>
                            ${message.content}
                        </div>
                    </li>
                </ul>
                `;


            }

            /**
             * cloneChatBox
             *
             * this helper function make a copy of the html chat box depending on receiver user
             * then append it to 'chat-overlay' div
             *
             * @param user_id
             * @param username
             * @param callback
             */
            function cloneChatBox(user_id, username, callback) {
                if ($("#chat_box_" + user_id).length == 0) {
                    let chatBoxClone = $('#chat_box').clone(true);

                    chatBoxClone.attr('id', 'chat_box_' + user_id);

                    chatBoxClone.find('.chat-user').text(username);
                    chatBoxClone.find('.btn-chat').attr('data-to-user', user_id);
                    chatBoxClone.find('#to_user_id').val(user_id);
                    $('#chat-overlay').append(chatBoxClone);
                }

                callback();
            }

            /**
             * loadLatestMessages
             *
             * this function called on load to fetch the latest messages
             *
             * @param container
             * @param user_id
             */
            function loadLatestMessages(container, user_id) {
                let chat_area = container.find(".chat-history");
                chat_area.html("");

                $.ajax({
                    method: "GET",
                    url: baseUrl + "/dashboard/load-latest-message",
                    data: {
                        user_id: user_id,
                        _token: $("meta[name='csrf-token']").attr("content")
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.state == 1) {
                            response.messages.map(function(val, index) {
                                $(val).appendTo(chat_area);
                            });
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }

            $('.chat_input').on('change keyup', function(e) {
                if ($(this).val() != '') {
                    $(this).parents(".text-box").find(".btn-chat").prop('disabled', false);
                } else {
                    $(this).parents(".text-box").find(".btn-chat").prop('disabled', true);
                }
            });

            $('.btn-chat').on('click', function(e) {
                send($(this).attr('data-to-user'), $('#chat_box_' + $(this).attr('data-to-user')).find(
                    '.chat_input').val());
            });

            // form submit with enter key
            $('.chat_input').keypress(function(e) {
                if (e.which == 13) {
                    jQuery(this).blur();
                    jQuery('.btn-chat').focus().click();
                }
            });

            channel.bind('send', function(data) {
                displayMessage(data.data);
            });

            /**
             * send
             *
             * this function is the main function of chat as it send the message
             *
             * @param to_user
             * @param message
             */
            function send(to_user, message) {
                let chat_box = $("#chat_box_" + to_user);
                let chat_area = chat_box.find(".chat-history");

                $.ajax({
                    type: "POST",
                    url: baseUrl + "/dashboard/send",
                    data: {
                        to_user: to_user,
                        message: message,
                        _token: $("meta[name='csrf-token']").attr("content")
                    },
                    dataType: "json",
                    success: function(response) {

                    },
                    complete: function() {
                        chat_box.find(".btn-chat").prop("disabled", true);
                        chat_box.find(".chat_input").val("");
                    }
                });
            }


            /**
             * This function called by the send event triggered from pusher to display the message
             *
             * @param message
             */
            function displayMessage(message) {
                let alert_sound = document.getElementById("chat-alert-sound");

                if ($("#current_user").val() == message.from_user_id) {
                    alert_sound.play();

                    let messageLine = getMessageSenderHtml(message);
                    $('#chat_box_' + message.to_user_id).find('.chat-history').append(messageLine);

                } else if ($("#current_user").val() == message.to_user_id) {

                    alert_sound.play();

                    cloneChatBox(message.from_user_id, message.fromUserName, function() {
                        let chatBox = $('#chat_box_' + message.from_user_id);
                        if (!chatBox.hasClass('chat-opened')) {
                            chatBox.addClass('chat-opened').slideDown("fast");
                            // chatBox.addClass('d-block');
                            loadLatestMessages(chatBox, message.from_user_id);


                        } else {
                            let messageLine = getMessageReceiverHtml(message);
                            $('#chat_box_' + message.from_user_id).find('.chat-history').append(
                                messageLine);
                        }
                    });
                }
            }

            channel.bind('oldMsgs', function(data) {
                displayOldMessages(data);
            });

            /**
             * fetchOldMessages
             *
             * this function load the old messages if scroll up triggerd
             *
             * @param to_user
             * @param old_message_id
             */
            function fetchOldMessages(to_user, old_message_id) {
                let chat_box = $("#chat_box_" + to_user);
                let chat_area = chat_box.find(".chat-history");

                $.ajax({
                    type: "GET",
                    url: baseUrl + "/dashboard/fetch-old-messages",
                    data: {
                        to_user: to_user,
                        old_message_id: old_message_id,
                        _token: $("meta[name='csrf-token']").attr("content")
                    },
                    dataType: "json",
                    success: function(response) {}
                });
            }

            function displayOldMessages() {
                if (data.data.length > 0) {
                    data.data.map(function(val, index) {
                        $('#chat_box_' + data.to_user).find('.chat-history').prepend(val);
                    });
                }
            }
        });
    </script>
@endpush

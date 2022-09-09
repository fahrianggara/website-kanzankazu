{{-- <div class="chat-popup">
    <div class="chat-header">
        <div class="back-button">
            <button class="back">
                <i class="uil uil-angle-left-b"></i>
            </button>
        </div>
        <div class="chat-header-info">
            <div class="chat-header-info-img">
                @php
                    if (file_exists('vendor/dashboard/image/picture-profiles/' . $user->user_image)) {
                        $userImage = asset('vendor/dashboard/image/picture-profiles/' . $user->user_image);
                    } elseif ($user->uid != null) {
                        $userImage = $user->user_image;
                    } else {
                        $userImage = asset('vendor/dashboard/image/avatar.png');
                    }

                    if (strlen($user->name) > 13) {
                        $name = substr($user->name, 0, 14) . '...';
                    } else {
                        $name = $user->name;
                    }
                @endphp

                <img src="{{ $userImage }}" alt="">

            </div>
            <div class="info-user">
                <h5>{{ $name }}</h5>
                @if (Cache::has('user-is-online-' . $user->id))
                    <span class="status online">Online</span>
                @else
                    <span class="status offline">{{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}</span>
                @endif
            </div>
        </div>
        <div class="close-button">
            <button class="close">
                <i class="uil uil-times"></i>
            </button>
        </div>
    </div>

    <div class="chat-area">
        @foreach ($messages as $message)
            @if ($message->receiver_id === Auth::id())
                <div class="incoming-msg">
                    <div class="img">
                        @php
                            if (file_exists('vendor/dashboard/image/picture-profiles/' . $message->user->user_image)) {
                                $userImage = asset('vendor/dashboard/image/picture-profiles/' . $message->user->user_image);
                            } elseif ($message->user->uid != null) {
                                $userImage = $message->user->user_image;
                            } else {
                                $userImage = asset('vendor/dashboard/image/avatar.png');
                            }
                        @endphp

                        <img src="{{ $userImage }}" alt="">
                    </div>
                    <div class="container-msg">
                        <div class="msg">
                            <span>
                                {{ $message->message }}
                            </span>
                        </div>
                        <time id="date">{{ date('H.i T', strtotime($message->created_at)) }}</time>
                    </div>
                </div>
            @else
                <div class="my-msg">
                    <div class="container-msg">
                        <div class="msg">
                            <span>
                                {{ $message->message }}
                            </span>
                        </div>
                        <time id="date">{{ date('H.i T', strtotime($message->created_at)) }}</time>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <div class="chat-input">
        <input type="text" id="chatInput" placeholder="Type a message" autocomplete="off">
        <button id="chatSubmit" class="send" disabled>
            <i class="uil uil-message"></i>
        </button>
    </div>
</div> --}}

<div class="chat-box hidden">
    <div class="chat-header">
        <button class="back">
            <i class="uil uil-angle-left-b"></i>
        </button>

        <div class="info-admin">
            @php
                if (file_exists('vendor/dashboard/image/picture-profiles/' . $user->user_image)) {
                    $userImage = asset('vendor/dashboard/image/picture-profiles/' . $user->user_image);
                } elseif ($user->uid != null) {
                    $userImage = $user->user_image;
                } else {
                    $userImage = asset('vendor/dashboard/image/avatar.png');
                }

                if (strlen($user->name) > 13) {
                    $name = substr($user->name, 0, 14) . '...';
                } else {
                    $name = $user->name;
                }
            @endphp

            <img src="{{ $userImage }}">

            <div class="profile">
                <h5>{{ $name }}</h5>

                @if (Cache::has('user-is-online-' . $user->id))
                    <span class="status online">Online</span>
                @else
                    <span class="status offline">{{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="chat-area">
        @forelse ($messages as $message)
            @php
                if (file_exists('vendor/dashboard/image/picture-profiles/' . $message->user->user_image)) {
                    $userImage = asset('vendor/dashboard/image/picture-profiles/' . $message->user->user_image);
                } elseif ($message->user->uid != null) {
                    $userImage = $message->user->user_image;
                } else {
                    $userImage = asset('vendor/dashboard/image/avatar.png');
                }
            @endphp

            @if ($message->receiver_id === Auth::id())
                <div class="incoming-msg">
                    <div class="img">
                        <img src="{{ $userImage }}">
                    </div>
                    <div class="container-msg">
                        <div class="msg">
                            {{ $message->message }}
                        </div>
                        <time>{{ date('H.i T', strtotime($message->created_at)) }}</time>
                    </div>
                </div>
            @else
                <div class="my-msg">
                    <div class="container-msg">
                        <div class="msg">
                            {{ $message->message }}
                        </div>
                        <time id="date">{{ date('H.i T', strtotime($message->created_at)) }}</time>
                    </div>
                </div>
            @endif
        @empty
            <div class="empty-chat">
                <i class="uil uil-comment-alt-exclamation"></i>
                <div>Silahkan memulai obrolan dengan Admin <span>{{ $user->name }}</span></div>
            </div>
        @endforelse
    </div>

    <div class="chat-input">
        <input type="text" id="chatInput" placeholder="Type a message" autocomplete="off">
        {{-- <div class="message-wrapper">
            <div id="chatInput" class="message-text" placeholder="Type a message.." contenteditable="true">
            </div>
        </div> --}}
        <button id="chatSubmit" class="send" disabled>
            <i class="uil uil-message"></i>
        </button>
    </div>
</div>

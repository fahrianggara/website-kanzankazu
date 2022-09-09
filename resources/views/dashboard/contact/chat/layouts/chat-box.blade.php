<div class="chat-header clearfix">
    <div class="info-user">
        <div class="back-button">
            <button class="back-chat">
                <i class="uil uil-angle-left-b"></i>
            </button>
        </div>

        @php
            if (file_exists('vendor/dashboard/image/picture-profiles/' . $user->user_image)) {
                $userImage = asset('vendor/dashboard/image/picture-profiles/' . $user->user_image);
            } elseif ($user->uid != null) {
                $userImage = $user->user_image;
            } else {
                $userImage = asset('vendor/dashboard/image/avatar.png');
            }
        @endphp

        <img class="rounded-circle user_image" src="{{ $userImage }}">

        <div class="about">
            <div class="name chat-user active">{{ $user->name }}</div>

            @if (Cache::has('user-is-online-' . $user->id))
                <div class="status last_seen text-success">Online</div>
            @else
                <div class="status last_seen">
                    Terakhir dilihat:
                    {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}
                </div>
            @endif
        </div>
    </div>

    {{-- <div class="close-button">
        <button class="close-chat">
            <i class="uil uil-times"></i>
        </button>
    </div> --}}
</div>

<div class="chat-history chat-area chat-msg-box">
    @foreach ($messages as $message)
        @if ($message->user_id === Auth::id())
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
        @elseif ($message->receiver_id === Auth::id())
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
        @endif
    @endforeach
</div>

<div class="chat-message clearfix">
    <div class="row">
        <div class="col d-flex">
            <div class="input-group text-box">
                <input class="form-control chat_input input-txt-bx" id="chatInput" autofocus type="text"
                    name="message-to-send" placeholder="Type a message......" data-original-title="" title="">
                <div class="input-group-append">
                    <button id="chatSubmit" class="btn btn-primary btn-chat" type="button">
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

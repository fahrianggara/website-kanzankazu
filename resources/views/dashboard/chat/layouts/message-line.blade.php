<ul>
    @if (count((array) $message->from_user) > 0)

        @if ($message->from_user == Auth::user()->id)
            <li class="clearfix">
                <div class="message other-message pull-right mr-1 msg_container" data-message-id="{{ $message->id }}">
                    @if (file_exists('vendor/dashboard/image/picture-profiles/' . $message->fromUser->user_image))
                        <img class="rounded-circle float-right chat-user-img img-30"
                            src="{{ asset('vendor/dashboard/image/picture-profiles/' . $message->fromUser->user_image) }}">
                    @elseif ($message->fromUser->uid != null)
                        <img class="rounded-circle float-right chat-user-img img-30"
                            src="{{ $message->fromUser->user_image }}">
                    @else
                        <img class="rounded-circle float-right chat-user-img img-30"
                            src="{{ asset('vendor/dashboard/image/avatar.png') }}">
                    @endif
                    <div class="message-data">
                        <span
                            class="message-data-time">{{ date('H.i T', strtotime($message->created_at->toDateTimeString())) }}
                        </span>
                    </div>

                    {!! $message->content !!}
                </div>
            </li>
        @else
            <li>
                <div class="message my-message msg_container" data-message-id="{{ $message->id }}">
                    @if (file_exists('vendor/dashboard/image/picture-profiles/' . $message->fromUser->user_image))
                        <img class="rounded-circle float-left chat-user-img img-30"
                            src="{{ asset('vendor/dashboard/image/picture-profiles/' . $message->fromUser->user_image) }}">
                    @elseif ($message->fromUser->uid != null)
                        <img class="rounded-circle float-left chat-user-img img-30"
                            src="{{ $message->fromUser->user_image }}">
                    @else
                        <img class="rounded-circle float-left chat-user-img img-30"
                            src="{{ asset('vendor/dashboard/image/avatar.png') }}">
                    @endif

                    <div class="message-data text-right">
                        <span
                            class="message-data-time">{{ date('H.i T', strtotime($message->created_at->toDateTimeString())) }}</span>
                    </div>

                    {!! $message->content !!}
                </div>
            </li>
        @endif
    @else
        <div class="noMessageWithUser">
            <i class="uil uil-comments-alt"></i>
            <h5 class="m-t-10">Obrolan belum ada, silahkan memulai obrolan.</h5>
        </div>
    @endif
</ul>
{{-- <li>
            <div class="message my-message"><img class="rounded-circle float-left chat-user-img img-30"
                    src="{{ asset('vendor/blog/img/avatar.png') }}" alt="" data-original-title=""
                    title="">
                <div class="message-data text-right"><span class="message-data-time">10:12
                        am</span></div> Are we meeting
                today? Project has been already finished and I have results to show you.
            </div>
        </li> --}}

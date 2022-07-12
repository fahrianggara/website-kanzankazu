{{-- <ul class="list">
@if ($users->count() > 0)
    @foreach ($users as $user)
        <li class="clearfix">
            <a href="javascript:void(0)" class="wafes-effect">
                @if (file_exists('vendor/dashboard/image/picture-profiles/' . $user->user_image))
                    <img class="rounded-circle user-image"
                        src="{{ asset('vendor/dashboard/image/picture-profiles/' . $user->user_image) }}"
                        alt="">
                @elseif ($user->uid != null)
                    <img class="rounded-circle user-image"
                        src="{{ $user->user_image }}" alt="">
                @else
                    <img class="rounded-circle user-image"
                        src="{{ asset('vendor/dashboard/image/avatar.png') }}"
                        alt="">
                @endif

                @if (Cache::has('user-is-online-' . $user->id))
                    <div class="status-circle online"></div>
                @else
                    <div class="status-circle offline"></div>
                @endif

                <div class="about">
                    <div class="name">
                        @if (strlen($user->name) > 10)
                            {{ substr($user->name, 0, 11) . '..' }}
                        @else
                            {{ $user->name }}
                        @endif
                    </div>

                    @if (Cache::has('user-is-online-' . $user->id))
                        <div class="status text-success">Online</div>
                    @else
                        <div class=" status text-secondary">Offline</div>
                    @endif
                </div>
            </a>
        </li>
    @endforeach
@else
    <a href="javascript:void(0)" class="text-center">
        <li class="clearfix">
            nothing to chat
        </li>
    </a>
@endif

</ul> --}}

<div class="topbar">
    <nav class="navbar-custom">

        <ul class="list-inline float-right mb-0">

            <li class="list-inline-item dropdown notification-list" data-toggle="tooltip" data-placement="bottom"
                title="Change theme">
                <a class="nav-link dropdown-toggle arrow-none waves-effect" role="button">
                    <i id="theme-toggle" class="uil uil-moon noti-icon"></i>
                </a>
            </li>

            <li class="list-inline-item dropdown notification-list" data-toggle="tooltip" data-placement="bottom"
                title="Notification">

                @if (!Auth::user()->editorRole())
                    {{-- Mimin / ADMIN --}}
                    @if ($postApprove)
                        <a class="nav-link dropdown-toggle arrow-none waves-effect " data-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="uil uil-bell noti-icon"></i>
                            @if ($postApprove->count() >= 1)
                                <span class="badge badge-success noti-icon-badge">{{ $postApprove->count() }}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg">

                            <div class="dropdown-item noti-title">
                                <h5>
                                    Notification
                                    @if ($postApprove->count() >= 1)
                                        <span class="badge badge-danger float-right">
                                            {{ $postApprove->count() }}
                                        </span>
                                    @endif
                                </h5>
                            </div>

                            @forelse ($postApprove as $post)
                                <a href="{{ url('dashboard/posts') }}?status=approve"
                                    class="dropdown-item notify-item">
                                    <div class="notify-icon bg-primary"><i class="uil uil-file-check-alt"></i></div>
                                    <p class="notify-details">
                                        <b>Approved</b>
                                        <small class="text-muted">
                                            Posts with the title "{{ $post->title }}" are waiting to be approved
                                        </small>
                                    </p>
                                </a>
                            @empty
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <div class="notify-icon bg-primary"><i class="uil uil-bell-slash"></i></div>
                                    <p class="notify-details text-center" style="margin-top: 5px">
                                        <b>no notification.</b>
                                    </p>
                                </a>
                            @endforelse

                            @if ($postApprove->count() >= 3)
                                <a href="{{ url('dashboard/posts') }}?status=approve"
                                    class="dropdown-item notify-item">
                                    View All
                                </a>
                            @endif
                        </div>

                    @endif
                @else
                    {{-- Editor --}}
                    <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="uil uil-bell noti-icon"></i>

                        @if ($postUserApprove->count() ||
                            auth()->user()->unreadNotifications->count() >= 1)
                            <span
                                class="badge badge-success noti-icon-badge">{{ $postUserApprove->count() +auth()->user()->unreadNotifications->count() }}</span>
                        @endif
                    </a>

                    <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg">
                        <div class="dropdown-item noti-title">
                            <h5>
                                Notification
                                @if ($postUserApprove->count() ||
                                    auth()->user()->unreadNotifications->count() >= 1)
                                    <span class="badge badge-danger float-right">
                                        {{ $postUserApprove->count() +auth()->user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </h5>
                        </div>
                        {{-- approve success --}}
                        @foreach (auth()->user()->unreadNotifications as $notif)
                            <a href="{{ route('markasread', $notif->id) }}" class="dropdown-item notify-item">
                                <div class="notify-icon bg-primary"><i class="uil uil-check-circle"></i></div>
                                <p class="notify-details">
                                    <b>{{ $notif->data['title'] }}</b>
                                    <small class="text-muted">
                                        {{ $notif->data['message'] }}
                                    </small>
                                </p>
                            </a>
                        @endforeach
                        {{-- Waiting approve --}}
                        @foreach ($postUserApprove as $post)
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-primary"><i class="uil uil-clock"></i></div>
                                <p class="notify-details">
                                    <b>Waiting Approved..</b>
                                    <small class="text-muted">
                                        Your post with the title "{{ $post->title }}" is waiting to be
                                        approved.
                                    </small>
                                </p>
                            </a>
                        @endforeach

                        @if ($postUserApprove->count() == 0 &&
                            auth()->user()->unreadNotifications->count() == 0)
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-primary"><i class="uil uil-bell-slash"></i></div>
                                <p class="notify-details text-center" style="margin-top: 5px">
                                    <b>no notification.</b>
                                </p>
                            </a>
                        @endif
                    </div>
                @endif

            </li>

            <li class="list-inline-item dropdown notification-list" data-toggle="tooltip" data-placement="bottom"
                title="Menu Profile">
                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    @if (file_exists('vendor/dashboard/image/picture-profiles/' . Auth::user()->user_image))
                        <img src="{{ asset('vendor/dashboard/image/picture-profiles/' . Auth::user()->user_image) }}"
                            alt="{{ Auth::user()->name }}" class="rounded-circle userImage">
                    @else
                        <img src="{{ asset('vendor/dashboard/image/avatar.png') }}" alt="{{ Auth::user()->name }}"
                            class="rounded-circle userImage">
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <h5 class="user_name">{{ Auth::user()->name }}</h5>
                    </div>
                    <a class="dropdown-item" href="{{ route('profile.index') }}"><i
                            class="uil uil-user m-r-5 text-muted"></i>
                        Profile</a>
                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ route('logout') }}" data-toggle="modal"
                        data-target="#logModal">
                        <i class="uil uil-signout m-r-5 text-muted"></i>
                        Logout
                    </a>
                </div>
            </li>

        </ul>

        <ul class="list-inline menu-left mb-0">
            <li class="float-left">
                <button class="button-menu-mobile open-left waves-light waves-effect">
                    <i class="uil uil-bars"></i>
                </button>
            </li>
        </ul>

        <div class="clearfix"></div>

    </nav>

</div>

<div class="modal fade" id="logModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Do you really want to logout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="{{ route('logout') }}" type="button" class="btn btn-danger" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">Logout
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </a>
            </div>
        </div>
    </div>
</div>

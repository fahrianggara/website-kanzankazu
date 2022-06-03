<div class="topbar">

    <nav class="navbar-custom">

        <ul class="list-inline float-right mb-0">

            <li class="list-inline-item dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-effect">
                    <i id="theme-toggle" class="uil uil-moon noti-icon"></i>
                </a>
            </li>

            <li class="list-inline-item dropdown notification-list">
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
                <a href="{{ route('logout') }}" type="button" class="btn btn-primary btn-danger" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">Logout
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </a>
            </div>
        </div>
    </div>
</div>

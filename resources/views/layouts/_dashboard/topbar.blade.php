<div class="topbar">

    <nav class="navbar-custom">

        <ul class="list-inline float-right mb-0">

            <li class="list-inline-item dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{ asset(Auth::user()->user_image) }}" alt="{{ Auth::user()->name }}"
                        class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <h5>{{ Auth::user()->name }}</h5>
                    </div>
                    <a class="dropdown-item" href="#"><i class="uil uil-user m-r-5 text-muted"></i>
                        Profile</a>
                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="uil uil-signout m-r-5 text-muted"></i> Logout

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
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

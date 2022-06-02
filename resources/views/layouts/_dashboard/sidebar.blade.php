<div class="left side-menu">
    <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
        <i class="uil uil-times"></i>
    </button>

    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center">
            <a href="{{ route('dashboard.index') }}" class="logo site_name">{{ $setting->site_name }}</a>
        </div>
    </div>

    <div class="sidebar-inner slimscrollleft">

        <div id="sidebar-menu">
            <ul>
                <li class="menu-title">Main Page</li>
                {{-- DASHBOARD --}}
                <li>
                    <a href="{{ route('dashboard.index') }}"
                        class="waves-effect {{ set_active('dashboard.index') }}">
                        <i class="uil uil-graph-bar"></i>
                        <span> Dashboard</span>
                    </a>
                </li>
                {{-- HOMEPAGE --}}
                <li>
                    <a href="{{ route('homepage') }}" target="_blank" class="waves-effect">
                        <i class="uil uil-estate"></i>
                        <span>Home</span>
                    </a>
                </li>
                {{-- Profile --}}
                <li class="menu-title">Manage Profile</li>
                <li>
                    <a href="{{ route('profile.index') }}" class="{{ set_active('profile.index') }}waves-effect">
                        <i class="uil uil-user"></i>
                        <span>Profile</span>
                    </a>
                </li>

                @can('manage_website')
                    {{-- Settings website --}}
                    <li class="menu-title">Setting Website</li>
                    <li>
                        <a href="{{ route('dashboard.setting') }}"
                            class="waves-effect {{ set_active('dashboard.setting') }}">
                            <i class="uil uil-setting"></i>
                            <span> Settings</span>
                        </a>
                    </li>
                @endcan

                {{-- POSTS --}}
                @can('manage_posts')
                    <li class="menu-title">Manage Articles</li>
                    <li>
                        <a href="{{ route('posts.index') }}"
                            class="waves-effect {{ set_active(['posts.index', 'posts.create', 'posts.edit', 'posts.show', 'posts.delete']) }}">
                            <i class="uil uil-book-medical"></i>
                            <span> Posts</span>
                        </a>
                    </li>
                @endcan
                {{-- CATEGORIES --}}
                @can('manage_categories')
                    <li>
                        <a href="{{ route('categories.index') }}"
                            class="waves-effect {{ set_active(['categories.index', 'categories.create', 'categories.edit']) }}">
                            <i class="uil uil-bookmark"></i>
                            <span> Categories</span>
                        </a>
                    </li>
                @endcan
                {{-- TAGS --}}
                @can('manage_tags')
                    <li>
                        <a href="{{ route('tags.index') }}"
                            class="waves-effect {{ set_active(['tags.index', 'tags.create', 'tags.edit']) }}">
                            <i class="uil uil-tag-alt"></i>
                            <span> Tags</span>
                        </a>
                    </li>
                @endcan

                {{-- USERS --}}
                @can('manage_users')
                    <li class="menu-title">Manage Users</li>
                    <li>
                        <a href="{{ route('users.index') }}"
                            class="waves-effect {{ set_active(['users.index', 'users.create', 'users.edit']) }}">
                            <i class="uil uil-users-alt"></i>
                            <span> Users</span>
                        </a>
                    </li>
                @endcan
                {{-- ROLES --}}
                @can('manage_roles')
                    <li>
                        <a href="{{ route('roles.index') }}"
                            class="waves-effect {{ set_active(['roles.index', 'roles.create', 'roles.edit', 'roles.show']) }}">
                            <i class="uil uil-user-arrows"></i>
                            <span> Roles</span>
                        </a>
                    </li>
                @endcan

                {{-- INBOX CONTACT --}}
                @can('manage_inbox')
                    <li class="menu-title">Inbox</li>
                    <li>
                        <a href="{{ route('contact.index') }}" class="waves-effect {{ set_active('contact.index') }}">
                            <i class="uil uil-inbox"></i>
                            <span> Contact</span>
                        </a>
                    </li>
                @endcan

                {{-- FILEMANAGER --}}
                <li class="menu-title">File Manager</li>
                <li>
                    <a href="{{ route('filemanager.index') }}"
                        class="waves-effect {{ set_active('filemanager.index') }}">
                        <i class="uil uil-folder-open"></i>
                        <span> File Manager</span>
                    </a>
                </li>

                {{-- Logout --}}
                <li class="menu-title">__________________</li>
                <li>
                    <a href="{{ route('logout') }}" data-toggle="modal" data-target="#logModal"
                        class="waves-effect">
                        <i class="uil uil-signout"></i>
                        <span>Logout</span>
                    </a>
                </li>

            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>

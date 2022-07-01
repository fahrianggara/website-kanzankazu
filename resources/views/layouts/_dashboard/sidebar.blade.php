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
                <li class="menu-title" id="dashboard">Halaman Utama</li>
                {{-- DASHBOARD --}}
                <li>
                    <a href="{{ route('dashboard.index', '#dashboard') }}"
                        class="waves-effect {{ set_active('dashboard.index') }}">
                        <i class="uil uil-graph-bar"></i>
                        <span> Dashboard</span>
                    </a>
                </li>
                {{-- HOMEPAGE --}}
                <li>
                    <a href="{{ route('homepage') }}" class="waves-effect">
                        <i class="uil uil-estate"></i>
                        <span>Beranda</span>
                    </a>
                </li>
                {{-- BLOG --}}
                <li>
                    <a href="{{ route('blog.author', ['author' => Auth::user()->slug ]) }}" class="waves-effect">
                        <i class="uil uil-create-dashboard"></i>
                        <span>Blog</span>
                    </a>
                </li>
                {{-- Profile --}}
                <li id="profile" class="menu-title">Kelola Profile</li>
                <li>
                    <a href="{{ route('profile.index', '#profile') }}" class="{{ set_active('profile.index') }} waves-effect">
                        <i class="uil uil-user"></i>
                        <span>Profile</span>
                    </a>
                </li>

                @can('manage_website')
                    {{-- Settings website --}}
                    <li id="website" class="menu-title">Setelan Website</li>
                    <li >
                        <a href="{{ route('dashboard.setting', '#website') }}"
                            class="waves-effect {{ set_active('dashboard.setting') }}">
                            <i class="uil uil-setting"></i>
                            <span>Pengaturan</span>
                        </a>
                    </li>
                @endcan

                {{-- POSTS --}}
                @can('manage_posts')
                    <li id="posts" class="menu-title">Kelola Blog</li>
                    <li>
                        <a href="{{ route('posts.index', '#posts') }}"
                            class="waves-effect {{ set_active(['posts.index', 'posts.create', 'posts.edit', 'posts.show', 'posts.delete']) }}">
                            <i class="uil uil-book-medical"></i>
                            <span>Postingan</span>
                        </a>
                    </li>
                @endcan
                {{-- CATEGORIES --}}
                @can('manage_categories')
                    <li id="categories">
                        <a href="{{ route('categories.index', '#posts') }}"
                            class="waves-effect {{ set_active(['categories.index', 'categories.create', 'categories.edit']) }}">
                            <i class="uil uil-bookmark"></i>
                            <span>Kategori</span>
                        </a>
                    </li>
                @endcan
                {{-- TAGS --}}
                @can('manage_tags')
                    <li id="tags">
                        <a href="{{ route('tags.index', '#posts') }}"
                            class="waves-effect {{ set_active(['tags.index', 'tags.create', 'tags.edit']) }}">
                            <i class="uil uil-tag-alt"></i>
                            <span>Tag</span>
                        </a>
                    </li>
                @endcan
                {{-- Tutorials --}}
                @can('manage_categories')
                    <li id="tutorials">
                        <a href="{{ route('tutorials.index', '#posts') }}"
                            class="waves-effect {{ set_active(['tutorials.index', 'tutorials.create', 'tutorials.edit']) }}">
                            <i class="uil uil-layer-group"></i>
                            <span>Tutorial</span>
                        </a>
                    </li>
                @endcan

                {{-- USERS --}}
                @can('manage_users')
                    <li id="users" class="menu-title">Kelola Pengguna</li>
                    <li >
                        <a href="{{ route('users.index','#users') }}"
                            class="waves-effect {{ set_active(['users.index', 'users.create', 'users.edit']) }}">
                            <i class="uil uil-users-alt"></i>
                            <span>Pengguna</span>
                        </a>
                    </li>
                @endcan
                {{-- ROLES --}}
                @can('manage_roles')
                    <li id="roles">
                        <a href="{{ route('roles.index', '#users') }}"
                            class="waves-effect {{ set_active(['roles.index', 'roles.create', 'roles.edit', 'roles.show']) }}">
                            <i class="uil uil-user-arrows"></i>
                            <span>Role</span>
                        </a>
                    </li>
                @endcan

                {{-- INBOX CONTACT --}}
                @can('manage_inbox')
                    <li id="contact" class="menu-title">Inbox</li>
                    <li >
                        <a href="{{ route('contact.index', '#contact') }}" class="waves-effect {{ set_active('contact.index') }}">
                            <i class="uil uil-inbox"></i>
                            <span>Pesan Kontak</span>
                        </a>
                    </li>
                    <li >
                        <a href="{{ route('newsletter.index', '#contact') }}" class="waves-effect {{ set_active('newsletter.index') }}">
                            <i class="uil uil-at"></i>
                            <span>Pelanggan</span>
                        </a>
                    </li>
                @endcan

                {{-- FILEMANAGER --}}
                <li id="filemanager" class="menu-title">File Manager</li>
                <li >
                    <a href="{{ route('filemanager.index', '#filemanager') }}"
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

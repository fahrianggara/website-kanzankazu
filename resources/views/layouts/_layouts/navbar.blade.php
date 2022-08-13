<header id="header">
    <div class="container d-flex">
        {{-- Button history back --}}
        <div class="history-back">
            @if (Request::is('blog/*'))
                <a onclick="goBackOrTo()" class="btn">
                    <i class="fas fa-arrow-left"></i>
                </a>
            @elseif (Request::is('category/*'))
                <a onclick="goBackOrTo()" class="btn">
                    <i class="fas fa-arrow-left"></i>
                </a>
            @elseif (Request::is('tag/*'))
                <a onclick="goBackOrTo()" class="btn">
                    <i class="fas fa-arrow-left"></i>
                </a>
            @elseif (Request::is('tutorials/*'))
                <a onclick="goBackOrTo()" class="btn">
                    <i class="fas fa-arrow-left"></i>
                </a>
            @elseif(Request::is('authors/*'))
                <a onclick="historyBackAuthor()" class="btn">
                    <i class="fas fa-arrow-left"></i>
                </a>
            @elseif(Request::is('search'))
                <a onclick="goBackOrTo()" class="btn">
                    <i class="fas fa-arrow-left"></i>
                </a>
            @endif
        </div>

        <div class="logo mr-auto">
            {{-- <h1 class="text-light"><a href="{{ route('blog.home') }}"><span>{{ $setting->site_name }}</span></a></h1> --}}
            <a href="{{ route('homepage') }}"><img src="{{ asset('logo-web/android-chrome-192x192.png') }}"
                    alt="{{ $setting->site_name }}" class="img-fluid"></a>
        </div>

        <nav class="nav-menu d-none d-lg-block">
            <ul>
                <li class="{{ set_active(['homepage']) }}"><a href="{{ route('homepage') }}"><i
                            class="uil uil-estate mr-2" style="color: #00b2cc"></i>Beranda</a></li>
                <li class="{{ set_active(['blog.home', 'blog.detail', 'blog.monthYear']) }} blogDetailActive">
                    <a href="{{ route('blog.home') }}"><i class="uil uil-create-dashboard mr-2"
                            style="color: #00b2cc"></i>Blog</a>
                </li>

                <li
                    class="drop-down {{ set_active(['blog.categories', 'blog.posts.categories', 'blog.tags', 'blog.posts.tags', 'blog.author', 'blog.authors', 'blog.tutorials', 'blog.posts.tutorials', 'blog.posts.tutorials.author']) }}">
                    <a href="javascript:void(0)"><i class="uil uil-sliders-v mr-2"></i>Filter Blog</a>
                    <ul>
                        <li
                            class="{{ set_active(['blog.tutorials', 'blog.posts.tutorials', 'blog.posts.tutorials.author']) }}">
                            <a href="{{ route('blog.tutorials') }}"><i class="uil uil-layer-group mr-2"></i>Tutorial</a>
                        </li>
                        <li class="{{ set_active(['blog.categories', 'blog.posts.categories']) }}"><a
                                href="{{ route('blog.categories') }}"><i class="uil uil-bookmark mr-2"></i>Kategori</a>
                        </li>
                        <li class="{{ set_active(['blog.tags', 'blog.posts.tags']) }}"><a
                                href=" {{ route('blog.tags') }}"><i class="uil uil-tag-alt mr-2"></i>Tag</a>
                        </li>
                        <li class="{{ set_active(['blog.authors', 'blog.author']) }}">
                            <a href="{{ route('blog.authors') }}"><i class="uil uil-users-alt mr-2"></i>Author</a>
                        </li>
                    </ul>
                </li>

                {{-- HAS LOGIN --}}
                @if (Route::has('login'))
                    @auth
                        <li class="drop-down">
                            <a href="javascript:void(0)">
                                <i class="uil uil-user mr-2"></i>
                                @if (strlen(Auth::user()->name) > 10)
                                    {{ substr(Auth::user()->name, 0, 10) }}..
                                @else
                                    {{ substr(Auth::user()->name, 0, 10) }}
                                @endif
                            </a>
                            <ul>
                                @if (Auth::user()->provider != 'anonymous')
                                    <li>
                                        <a href="{{ route('dashboard.index') }}"><i class="uil uil-graph-bar mr-2"></i>
                                            Dashboard</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('profile.index') }}"><i class="uil uil-house-user mr-2"></i>
                                            Profile Kamu</a>
                                    </li>
                                    <li class="{{ set_active('blog.author') }}">
                                        <a href="{{ route('blog.author', ['author' => Auth::user()->slug]) }}"><i
                                                class="uil uil uil-document-layout-left mr-2"></i>
                                            Blog Kamu</a>
                                    </li>
                                    <hr style="background-color: #00b2cc; height: 1px; border: 0; margin: 10px 0 10px 0;">
                                @endif
                                <li>
                                    <a id="log-out" href="" data-toggle="modal" data-target="#logModal">Log Out <i
                                            class="uil uil-signout ml-2"></i></a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="drop-down">
                            <a href="javascript:void(0)"><i class="uil uil-user-plus mr-2"></i>JOIN US</a>
                            <ul>
                                <li class="">
                                    <a href="{{ route('login') }}"><i class="uil uil-signin mr-2"></i>Log In</a>
                                </li>
                                <li class="">
                                    <a href=" {{ route('register') }}"><i class="uil uil-file-edit-alt mr-2"></i>Sign
                                        Up</a>
                                </li>
                            </ul>
                        </li>
                    @endauth
                @endif

            </ul>
        </nav>

        {{-- darktheme --}}
        <div class="d-flex tombolNavbar">
            <div class="change-theme-blog" data-toggle="tooltip" data-placement="bottom">
                <i class="uil uil-moon btn-tooltip-hide" id="theme-toggle">
                </i>
            </div>

            {{-- search --}}
            <div class="searchButton">
                <span class="uil uil-search"></span>
                <span class="uil uil-times"></span>
            </div>

            {{-- <div class="search-icon btn-tooltip-hide" data-toggle="tooltip" data-placement="bottom" title="Pencarian">
            </div>
            <div class="cancel-icon btn-tooltip-hide" data-toggle="tooltip" data-placement="bottom" title="Tutup">
            </div> --}}

            <div class="search-nav">
                <form action="{{ route('blog.search') }}" method="GET" autocomplete="off">
                    <input id="search" type="search" name="keyword" value="{{ request()->get('keyword') }}"
                        class="search-blog" placeholder="Cari blog apapun disini...">
                    <button id="buttonSubmit" type="submit" class="uil btn-tooltip-hide" data-toggle="tooltip"
                        data-placement="bottom" title="Telusuri"><i class="uil uil-search"></i></button>
                </form>
            </div>
            <div class="menuButton"></div>
        </div>

    </div>
</header>

<div class="modal fade" id="logModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Apakah kamu ingin Logout?
            </div>
            <div class="modal-footer">
                <button id="close-logOut" type="button" class="btn btn-secondary"
                    data-dismiss="modal">Tutup</button>
                <a href="{{ route('logout') }}" type="button" class="btn btn-danger"
                    onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">Logout
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </a>
            </div>
        </div>
    </div>
</div>

@push('js-internal')
    <script type="text/javascript">
        function historyBackBlog(fallbackUrl) {
            fallbackUrl = fallbackUrl || "{{ route('blog.home') }}";
            var prevPage = window.location.href;

            window.history.go(-1);

            setTimeout(function() {
                if (window.location.href == prevPage) {
                    window.location.href = fallbackUrl;
                }
            }, 0);
        }

        function historyBackAuthor(fallbackUrl) {
            fallbackUrl = fallbackUrl || "{{ route('blog.authors') }}";
            var prevPage = window.location.href;

            window.history.go(-1);

            setTimeout(function() {
                if (window.location.href == prevPage) {
                    window.location.href = fallbackUrl;
                }
            }, 0);
        }

        function goBackOrTo(targetUrl) {
            var currentUrl = window.location.href;
            window.history.go(-1);
            setTimeout(function() {
                if (currentUrl === window.location.href) {
                    window.location.href = targetUrl;
                }
            }, 100);
        }

        $(function() {

            $(document).on('click', '#log-out', function() {
                $('body').removeClass('mobile-nav-active');
                $('div').removeClass('mobile-nav-overly');
                $('#toggleNav').removeClass('icofont-close');
                $('#toggleNav').addClass('uil uil-bars');
            });

            const searchBtn = document.querySelector(".uil-search");
            const cancelBtn = document.querySelector(".uil-times");
            const form = document.querySelector("form");

            cancelBtn.onclick = () => {
                searchBtn.classList.remove("hide");
                cancelBtn.classList.remove("show");
                form.classList.remove("active");
                // add readonly to input
                form.querySelector("input").readOnly = true;
                // reset input value
                form.querySelector("input").value = "";
                $('#overlay').removeClass('overlay-search');
                $('.overlay-search').hide();
            }

            searchBtn.onclick = () => {
                // $('.ui-autocomplete').show();
                form.classList.add("active");
                searchBtn.classList.add("hide");
                cancelBtn.classList.add("show");
                // remove readonly to input
                form.querySelector("input").readOnly = false;
                // focus input
                form.querySelector("input").focus();
                $('#overlay').addClass('overlay-search');
                $('.overlay-search').show();
                // overlay-search add transition css
                $('.overlay-search').addClass('transition-overlay');
            }

            // if fullscreen window remove overlay-search
            $(window).on('resize', function() {
                if ($(window).width() > 768) {
                    $('#overlay').removeClass('overlay-search');
                    form.querySelector("input").readOnly = false;

                    // remove mobile-nav-overly
                    $('body').removeClass('mobile-nav-active');
                    $('#mobileOverly').removeClass('mobile-nav-overly');
                    $('#toggleNav').removeClass('icofont-close');
                    $('#toggleNav').addClass('uil uil-bars');
                    // remove ui autocomplete
                    $('ul.ui-autocomplete').hide();
                } else {
                    // $('ul.ui-autocomplete').show();

                    if ($(cancelBtn).hasClass('show')) {
                        $('#overlay').addClass('overlay-search');
                    } else {
                        $('#overlay').removeClass('overlay-search');
                        // $('ul.ui-autocomplete').hide();
                    }
                }
            }).trigger('resize');

            // === AUTOCOMPLETE SEARCH === //
            $("#search").autocomplete({
                delay: 100,
                source: "{{ route('blog.autocomplete') }}",
                focus: function(event, ui) {
                    $("#search").val(ui.item
                        .title);
                    return false;
                },
                // search: function() {
                //     $('#buttonSubmit').attr('disabled', true);
                //     $('#buttonSubmit').html('<i class="fa fa-spin fa-spinner"></i>');
                // },
                open: function() {
                    $(".ui-autocomplete:visible").css({
                        top: "+=10.6",
                        left: "+=1"
                    });

                    // $('#buttonSubmit').attr('disabled', false);
                    // $('#buttonSubmit').html('<i class="uil uil-search"></i>');

                    // setInterval(() => {
                    //     $('#buttonSubmit').attr('disabled', false);
                    //     $('#buttonSubmit').html('<i class="uil uil-search"></i>');
                    // }, 4000);

                },
                select: function(event, ui) {
                    window.location.href = ui.item.url;
                }
            }).data("ui-autocomplete")._renderItem = function(ul, item) {
                var inner_html = '<a class="align-self-center" href="' + item.url +
                    '"><i class="uil uil-external-link-alt"></i> <p class="title-search">' +
                    item.title +
                    '</p></a>';

                return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append(inner_html)
                    .appendTo(ul);
            };

        });
    </script>
@endpush

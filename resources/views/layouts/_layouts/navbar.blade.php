<header id="header">
    <div class="container d-flex">
        {{-- Button history back --}}
        <div class="history-back">
            @if (Request::is('blog/*'))
                <a onclick="historyBackWFallback()" class="btn">
                    <i class="fas fa-arrow-left"></i>
                </a>
            @elseif (Request::is('category/*'))
                <a href="javascript:history.go(-1)" class="btn">
                    <i class="fas fa-arrow-left"></i>
                </a>
            @elseif (Request::is('tag/*'))
                <a href="javascript:history.go(-1)" class="btn">
                    <i class="fas fa-arrow-left"></i>
                </a>
            @elseif (Request::is('tutorials/*'))
                <a href="javascript:history.go(-1)" class="btn">
                    <i class="fas fa-arrow-left"></i>
                </a>
            @elseif(Request::is('authors/*'))
                <a href="javascript:history.go(-1)" class="btn">
                    <i class="fas fa-arrow-left"></i>
                </a>
            @elseif(Request::is('search'))
                <a href="javascript:history.go(-1)" class="btn">
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
                <li class="{{ set_active(['homepage']) }}"><a href="{{ route('homepage') }}">Beranda</a></li>
                <li class="{{ set_active(['blog.home', 'blog.detail', 'blog.monthYear']) }} blogDetailActive">
                    <a href="{{ route('blog.home') }}">Blog</a>
                </li>

                <li
                    class="drop-down {{ set_active(['blog.categories', 'blog.posts.categories', 'blog.tags', 'blog.posts.tags', 'blog.author', 'blog.authors', 'blog.tutorials', 'blog.posts.tutorials', 'blog.posts.tutorials.author']) }}">
                    <a href="#">Filter Blog</a>
                    <ul>
                        <li
                            class="{{ set_active(['blog.tutorials', 'blog.posts.tutorials', 'blog.posts.tutorials.author']) }}">
                            <a href="{{ route('blog.tutorials') }}">Tutorial</a>
                        </li>
                        <li class="{{ set_active(['blog.categories', 'blog.posts.categories']) }}"><a
                                href="{{ route('blog.categories') }}">Kategori</a>
                        </li>
                        <li class="{{ set_active(['blog.tags', 'blog.posts.tags']) }}"><a
                                href=" {{ route('blog.tags') }}">Tag</a>
                        </li>
                        <li class="{{ set_active(['blog.authors', 'blog.author']) }}">
                            <a href="{{ route('blog.authors') }}">Author</a>
                        </li>
                    </ul>
                </li>

                {{-- HAS LOGIN --}}
                @if (Route::has('login'))
                    @auth
                        <li class="drop-down">
                            <a href="#"><i class="uil uil-user mr-2"></i>{{ Auth::user()->slug }}</a>
                            <ul>
                                <li>
                                    <a href="{{ route('dashboard.index') }}">DASHBOARD</a>
                                </li>
                                <li>
                                    <a href="" data-toggle="modal" data-target="#logModal">LOG OUT</a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="drop-down">
                            <a href="#">JOIN US</a>
                            <ul>
                                <li class="">
                                    <a href="{{ route('login') }}">LOG IN</a>
                                </li>
                                <li class="">
                                    <a href=" {{ route('register') }}">SIGN UP</a>
                                </li>
                            </ul>
                        </li>
                    @endauth
                @endif

            </ul>
        </nav>

        {{-- darktheme --}}
        <i class="uil uil-moon change-theme-blog btn-tooltip-hide" data-toggle="tooltip" data-placement="bottom"
            title="Ganti Tema" id="theme-toggle">
        </i>

        {{-- search --}}
        <div class="search-icon btn-tooltip-hide" data-toggle="tooltip" data-placement="bottom" title="Pencarian">
            <span class="uil uil-search"></span>
        </div>
        <div class="cancel-icon btn-tooltip-hide" data-toggle="tooltip" data-placement="bottom" title="Tutup">
            <span class="uil uil-times"></span>
        </div>

        <div class="search-nav">
            <form action="{{ route('blog.search') }}" method="GET">
                <input id="search" type="search" name="keyword" value="{{ request()->get('keyword') }}"
                    class="search-blog" placeholder="Cari blog apapun disini..." autocomplete="off">
                <button id="buttonSubmit" type="submit" class="uil btn-tooltip-hide" data-toggle="tooltip"
                    data-placement="bottom" title="Telusuri"><i class="uil uil-search"></i></button>
            </form>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
        function historyBackWFallback(fallbackUrl) {
            fallbackUrl = fallbackUrl || "{{ route('blog.home') }}";
            var prevPage = window.location.href;

            window.history.go(-1);

            setTimeout(function() {
                if (window.location.href == prevPage) {
                    window.location.href = fallbackUrl;
                }
            }, 0);
        }

        $(function() {
            // === AUTOCOMPLETE SEARCH === //
            $("#search").autocomplete({
                delay: 100,
                source: "{{ route('blog.autocomplete') }}",
                focus: function(event, ui) {
                    $("#search").val(ui.item
                        .title);
                    return false;
                },
                search: function() {
                    $('#buttonSubmit').attr('disabled', true);
                    $('#buttonSubmit').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                open: function() {
                    $(".ui-autocomplete:visible").css({
                        top: "+=10.6",
                        left: "+=1"
                    });

                    $('#buttonSubmit').attr('disabled', false);
                    $('#buttonSubmit').html('<i class="uil uil-search"></i>');

                    setInterval(() => {
                        $('#buttonSubmit').attr('disabled', false);
                        $('#buttonSubmit').html('<i class="uil uil-search"></i>');
                    }, 4000);
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
        })
    </script>
@endpush

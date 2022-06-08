<header id="header">
    <div class="container d-flex">

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
                    class="drop-down {{ set_active(['blog.categories', 'blog.posts.categories', 'blog.tags', 'blog.posts.tags', 'blog.author', 'blog.authors']) }}">
                    <a href="#">Filter Blog</a>
                    <ul>
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
                            <a href="#">{{ Auth::user()->slug }}</a>
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
                <button type="submit" class="uil uil-search"></button>
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

@push('js-internal')
    <script type="text/javascript">
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
                open: function() {
                    $(".ui-autocomplete:visible").css({
                        top: "+=10.6",
                        left: "+=1"
                    });
                },
                select: function(event, ui) {
                    window.location.href = ui.item.url;
                },
                response: function(event, ui) {
                    if (!ui.content.length) {
                        $(".empty-search").delay(100).show();
                        $("#textEmpty").text("{{ trans('blog.no-data.result_search') }}");
                    } else {
                        $("#textEmpty").empty();
                        $(".empty-search").hide();
                    }
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

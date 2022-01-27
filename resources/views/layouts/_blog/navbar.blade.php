<header id="header">
    <div class="container d-flex">

        <div class="logo mr-auto">
            <h1 class="text-light"><a href="{{ route('blog.home') }}"><span>{{ config('app.name') }}</span></a>
            </h1>
        </div>

        <nav class="nav-menu d-none d-lg-block">
            <ul>
                <li><a href=" {{ url('/') }}">{{ trans('blog.navbar.homepage') }}</a></li>
                <li
                    class="{{ set_active(['blog.home', 'blog.detail', 'blog.search', 'blog.author', 'blog.monthYear']) }} blogDetailActive">
                    <a href="{{ route('blog.home') }}">{{ trans('home.navbar.blog') }}</a>
                </li>

                <li
                    class="drop-down {{ set_active(['blog.categories', 'blog.posts.categories', 'blog.tags', 'blog.posts.tags']) }}">
                    <a href="#">{{ trans('blog.navbar.filter') }}</a>
                    <ul>
                        <li class="{{ set_active(['blog.categories', 'blog.posts.categories']) }}"><a
                                href="{{ route('blog.categories') }}">{{ trans('blog.navbar.categories') }}</a>
                        </li>
                        <li class="{{ set_active(['blog.tags', 'blog.posts.tags']) }}"><a
                                href=" {{ route('blog.tags') }}">{{ trans('blog.navbar.tags') }}</a>
                        </li>
                    </ul>
                </li>

                <li class="drop-down {{ set_active('blog.monthYear') }}"><a
                        href="#">{{ trans('blog.navbar.archive') }}</a>
                    <ul>
                        @foreach ($archiveBlogs as $item)
                            <li
                                class="{{ request()->is('blog/' . $item['year'] . '/' . $item['month']) ? 'active' : '' }}">
                                <a
                                    href="{{ route('blog.monthYear', ['month' => $item['month'], 'year' => $item['year']]) }}">

                                    {{ $item['month'] . ' ' . $item['year'] }}
                                    <div class="countArchive">
                                        (<span class="countArc">{{ $item['publish'] }}</span>)
                                    </div>
                                </a>
                            </li>
                        @endforeach

                        @foreach ($archiveBlogs as $item)
                            @if (request()->is('blog/' . $item['year'] . '/' . $item['month']))
                                <li>
                                    <hr class="hr">
                                    <a href="{{ route('blog.home') }}">
                                        {{ trans('blog.navbar.blogAll') }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>

                <li class="drop-down">
                    <a href="#">
                        @switch(app()->getLocale())
                            @case('id')
                                <i class="flag-icon flag-icon-id mr-1"></i>
                            @break
                            @case('en')
                                <i class="flag-icon flag-icon-gb mr-1"></i>
                            @break
                            @case('jp')
                                <i class="flag-icon flag-icon-jp mr-1"></i>
                            @break
                            @default

                        @endswitch
                        {{ strtoupper(app()->getLocale()) }}
                    </a>

                    <ul>
                        <li class="{{ app()->getLocale() == 'id' ? 'active' : '' }}">
                            <a href="{{ route('localization.switch', ['language' => 'id']) }}">
                                <i
                                    class="flag-icon flag-icon-id mr-2"></i>{{ trans('home.navbar.language.indonesia') }}
                            </a>
                        </li>
                        <li class="{{ app()->getLocale() == 'en' ? 'active' : '' }}">
                            <a href="{{ route('localization.switch', ['language' => 'en']) }}">
                                <i
                                    class="flag-icon flag-icon-gb mr-2"></i>{{ trans('home.navbar.language.english') }}
                            </a>
                        </li>
                        <li class="{{ app()->getLocale() == 'jp' ? 'active' : '' }}">
                            <a href="{{ route('localization.switch', ['language' => 'jp']) }}">
                                <i class="flag-icon flag-icon-jp mr-2"></i>{{ trans('home.navbar.language.japan') }}
                            </a>
                        </li>
                    </ul>
                </li>


            </ul>
        </nav><!-- .nav-menu -->

        {{-- darktheme --}}
        <i class="uil uil-moon change-theme-blog btn-tooltip-hide" data-toggle="tooltip" data-placement="bottom"
            title="{{ trans('blog.tooltip.theme') }}" id="theme-toggle">
        </i>
        <div class="clip"></div>

        {{-- search --}}
        <div class="search-icon btn-tooltip-hide" data-toggle="tooltip" data-placement="bottom"
            title="{{ trans('blog.tooltip.search') }}">
            <span class="uil uil-search"></span>
        </div>
        <div class="cancel-icon btn-tooltip-hide" data-toggle="tooltip" data-placement="bottom"
            title="{{ trans('blog.tooltip.close') }}">
            <span class="uil uil-times"></span>
        </div>

        <div class="search-nav">
            <form action="{{ route('blog.search') }}" method="GET">
                <input id="search" type="search" name="keyword" value="{{ request()->get('keyword') }}"
                    class="search-blog" placeholder="{{ trans('blog.form.search.placeholder') }}"
                    autocomplete="off">
                <button type="submit" class="uil uil-search"></button>
                <div id="empty-search" class="empty-search card" style="display: none">
                    <span id="textEmpty"></span>
                </div>
            </form>
        </div>

    </div>
</header>

@push('js-internal')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#empty-search').click(function() {
                $('#empty-search').hide();
            })

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
                        top: "+=10",
                        left: "-=2"
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
        });
    </script>
@endpush

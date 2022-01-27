<header id="header">
    <div class="container d-flex">

        <div class="logo mr-auto">
            <h1 class="text-light"><a class="underline"
                    href="{{ route('homepage') }}"><span>{{ config('app.name') }}</span></a>
            </h1>
        </div>

        <nav class="nav-menu d-none d-lg-block">
            <ul>
                <li><a href="#slide">{{ trans('home.navbar.home') }}</a></li>
                <li><a href="#about">{{ trans('home.navbar.about') }}</a></li>
                <li><a href="#blog">{{ trans('home.navbar.blog') }}</a></li>
                <li><a href="#gallery">{{ trans('home.navbar.gallery') }}</a></li>
                <li><a href="#contact">{{ trans('home.navbar.contact') }}</a></li>

                <li class="drop-down">
                    <a href="#" style="cursor: default">
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
                        <li>
                            <a class="{{ app()->getLocale() == 'id' ? 'active' : '' }}"
                                href="{{ route('localization.switch', ['language' => 'id']) }}">
                                <i
                                    class="flag-icon flag-icon-id mr-1"></i>{{ trans('home.navbar.language.indonesia') }}
                            </a>
                        </li>
                        <li>
                            <a class="{{ app()->getLocale() == 'en' ? 'active' : '' }}"
                                href="{{ route('localization.switch', ['language' => 'en']) }}">
                                <i
                                    class="flag-icon flag-icon-gb mr-1"></i>{{ trans('home.navbar.language.english') }}
                            </a>
                        </li>
                        <li>
                            <a class="{{ app()->getLocale() == 'jp' ? 'active' : '' }}"
                                href="{{ route('localization.switch', ['language' => 'jp']) }}">
                                <i class="flag-icon flag-icon-jp mr-1"></i>{{ trans('home.navbar.language.japan') }}
                            </a>
                        </li>
                    </ul>
                </li>


            </ul>
        </nav><!-- .nav-menu -->

        {{-- darkmode --}}
        <i class="uil uil-moon change-theme btn-tooltip-hide" data-toggle="tooltip" data-placement="bottom"
            title="{{ trans('blog.tooltip.theme') }}" id="theme-toggle">
        </i>

    </div>
</header>

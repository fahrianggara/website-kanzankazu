@extends('layouts.blog')

@section('keywords')
    {{ $post->title . ' ' . $setting->site_name }}
@endsection

@section('author')
    {{ $post->author }}
@endsection

@section('title')
    {{ $post->title }}
@endsection

@section('description')
    {{ $post->description }}
@endsection

@section('image')
    {{ asset('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail) }}
@endsection

@section('url')
    {{ route('blog.detail', ['slug' => $post->slug]) }}
@endsection

@section('content')
    <div class="progress-read">
        <div class="bar"></div>
    </div>

    <div class="container">

        <div class="row">

            <div class="col-lg-8 entries">

                <article class="entry entry-single">

                    <div class="entry-img loading">
                        @if (file_exists('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail))
                            <img src="{{ asset('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail) }}"
                                alt="{{ $post->title }}" class="img-fluid" />
                        @else
                            <img class="img-fluid" src="{{ asset('vendor/blog/img/default.png') }}"
                                alt="{{ $post->title }}">
                        @endif
                    </div>

                    <h2 class="entry-title loading">
                        <span>{{ $post->title }}</span>
                    </h2>

                    <div class="entry-meta">
                        <ul>
                            <li class="d-flex align-items-center">
                                <div class="loading">
                                    <i class="icofont-user"></i>
                                    @if ($post->user->status == 'banned')
                                        <span>Akun diblokir</span>
                                    @else
                                        <span>{{ $post->user->name }}</span>
                                    @endif
                                </div>
                            </li>
                            <li class="d-flex align-items-center">
                                <div class="loading">
                                    <i class="icofont-ui-calendar"></i>
                                    <span>{{ $post->created_at->format('j F Y') }}</span>
                                </div>
                            </li>
                            <li class="d-flex align-items-center">
                                <div class="loading">
                                    <i class="icofont-eye-alt"></i>
                                    <span> {{ $post->views }}</span>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="entry-content">
                        <div>
                            {!! $post->content !!}
                        </div>
                    </div>

                    <div class="entry-footer clearfix">
                        <div class="tagCats tag_post loading">
                            <i class="icofont-tags btn-tooltip-hide" data-toggle="tooltip" data-placement="bottom"
                                title="Tag"></i>
                            <ul class="tags">
                                @foreach ($post->tags as $tag)
                                    <li>
                                        <a class="link-tagCats"
                                            href="{{ route('blog.posts.tags', ['slug' => $tag->slug]) }}">{{ $tag->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="tagCats cat_post loading">
                            <i class="icofont-folder btn-tooltip-hide" data-toggle="tooltip" data-placement="bottom"
                                title="Kategori"></i>
                            <ul class="tags">
                                @foreach ($post->categories as $category)
                                    <li>
                                        <a class="link-tagCats"
                                            href="{{ route('blog.posts.categories', ['slug' => $category->slug]) }}">{{ $category->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        @if ($post->tutorials->isNotEmpty())
                            <div class="tagCats tuto_post loading">
                                <i class="uil uil-books btn-tooltip-hide" data-toggle="tooltip" data-placement="bottom"
                                    title="Tutorial"></i>
                                <ul class="tags">
                                    @foreach ($post->tutorials as $tutorial)
                                        <li>
                                            <a class="link-tagCats"
                                                href="{{ route('blog.posts.tutorials.author', ['slug' => $tutorial->slug, 'user' => $post->user->slug]) }}">{{ $tutorial->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                </article>

                {{-- Tutorial post --}}
                <div id="tutorialPost" class="related-post mb-4">
                    @include('blog.tutorials.tutorial-post')
                </div>

                <div class="blog-author d-flex align-items-center">
                    @if ($post->user->status == 'banned')
                        <img src="{{ asset('vendor/dashboard/image/avatar.png') }}" class="rounded-circle float-left"
                            alt="">

                        <div>
                            <a class="nameAuthor" href="javascript:void(0)">
                                Akun Diblokir
                            </a>
                            <div class="social-links">
                            </div>
                            <p>
                                " KanzanKazu "
                            </p>
                        </div>
                    @else
                        @if (file_exists('vendor/dashboard/image/picture-profiles/' . $post->user->user_image))
                            <img src="{{ asset('vendor/dashboard/image/picture-profiles/' . $post->user->user_image) }}"
                                alt="" class="rounded-circle float-left" />
                        @elseif ($post->user->provider == 'google' || $post->user->provider == 'github')
                            <img src="{{ $post->user->user_image }}" alt="" class="rounded-circle float-left" />
                        @else
                            <img src="{{ asset('vendor/dashboard/image/avatar.png') }}" class="rounded-circle float-left"
                                alt="">
                        @endif
                        <div>
                            <a class="nameAuthor" href="{{ route('blog.author', ['author' => $post->user->slug]) }}">
                                {{ $post->user->name }}
                            </a>
                            <div class="social-links">
                                @if ($post->user->facebook != null)
                                    <a target="_blank" href="{{ $post->user->facebook }}">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                @elseif ($post->user->twitter != null)
                                    <a target="_blank" href="{{ $post->user->twitter }}">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                @elseif ($post->user->instagram != null)
                                    <a target="_blank" href="{{ $post->user->instagram }}">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                @elseif ($post->user->github != null)
                                    <a target="_blank" href="{{ $post->user->github }}">
                                        <i class="fab fa-github"></i>
                                    </a>
                                @endif
                            </div>
                            <p>
                                @if ($post->user->bio != null)
                                    " {{ $post->user->bio }} "
                                @else
                                    " KanzanKazu "
                                @endif
                            </p>
                        </div>
                    @endif
                </div>

                @if ($prev != null || $next != null)
                    <article class="entry-bottom" style="margin-bottom: 20px">
                        @if ($prev)
                            <div class="float-right">
                                <a href="{{ route('blog.detail', ['slug' => $prev->slug]) }}" class="btn-Next" data-toggle="tooltip" data-placement="bottom"
                                    title="{{ $prev->title }}">
                                    Berikutnya <i class="icofont-rounded-right"></i>
                                </a>
                            </div>
                        @endif

                        @if ($next)
                            <div class="float-left">
                                <a href="{{ route('blog.detail', ['slug' => $next->slug]) }}" class="btn-Prev" data-toggle="tooltip" data-placement="bottom"
                                    title="{{ $next->title }}">
                                    <i class="icofont-rounded-left"></i> Sebelumnya
                                </a>
                            </div>
                        @endif
                    </article>
                @endif

                {{-- RELATED POSTS --}}
                <div id="relatedPost" class="related-post mb-4">
                    @include('blog.sub-blog.related-post')
                </div>

                <div class="count-title">
                    @if ($post->comments->count() >= 1)
                        <h2 class="sect-title"> {{ $post->comments->count() }} Komentar</h2>
                    @else
                        <h2 class="sect-title"> Belum ada komentar</h2>
                    @endif
                </div>

                <article class="sect-coment" id="sectComment">

                    @comments([
                        'model' => $post,
                        'approved' => true,
                        'maxIndentationLevel' => 1,
                        'perPage' => null
                    ])
                </article>

            </div>

            <div class="col-lg-4">

                <div class="fixedInfo">
                    <div class="sidebar">
                        <h3 class="sidebar-title">Blog Terbaru</h3>
                        <div class="sidebar-item recent-posts">

                            @foreach ($recents as $recent)
                                <div class="post-item clearfix">
                                    <div class="imgSidebar img-container loading">
                                        <a href="{{ route('blog.detail', ['slug' => $recent->slug]) }}">
                                            @if (file_exists('vendor/dashboard/image/thumbnail-posts/' . $recent->thumbnail))
                                                <img src="{{ asset('vendor/dashboard/image/thumbnail-posts/' . $recent->thumbnail) }}"
                                                    alt="{{ $recent->title }}" class="img-container" />
                                            @else
                                                <img class="img-container"
                                                    src="{{ asset('vendor/blog/img/default.png') }}"
                                                    alt="{{ $recent->title }}">
                                            @endif
                                        </a>
                                    </div>
                                    <h4 class="titleSidebar loading">
                                        <a class="underline {{ request()->is('blog/' . $recent->slug) ? 'active' : '' }}"
                                            href="{{ route('blog.detail', ['slug' => $recent->slug]) }}">
                                            {{ $recent->title }}
                                        </a>
                                    </h4>
                                    <time class="timeSidebar loading">
                                        <p>
                                            {{ $recent->created_at->format('j M, Y') }}
                                        </p>
                                    </time>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="sidebar">

                        <h3 class="sidebar-title">Kategori</h3>
                        <div class="sidebar-item categories @if ($categories->count() >= 3) height-195 @endif">

                            @foreach ($categories as $category)
                                <div class="category-item clearfix">
                                    <div class="imgSidebar img-container">
                                        <a href="{{ route('blog.posts.categories', ['slug' => $category->slug]) }}">
                                            @if (file_exists('vendor/dashboard/image/thumbnail-categories/' . $category->thumbnail))
                                                <img class="img-container"
                                                    src="{{ asset('vendor/dashboard/image/thumbnail-categories/' . $category->thumbnail) }}"
                                                    alt="{{ $category->title }}">
                                            @else
                                                <img class="img-container"
                                                    src="{{ asset('vendor/blog/img/default.png') }}"
                                                    alt="{{ $category->title }}">
                                            @endif
                                        </a>
                                    </div>
                                    <h4 class="titleSidebar loading">
                                        <a class="underline"
                                            href="{{ route('blog.posts.categories', ['slug' => $category->slug]) }}">
                                            {{ $category->title }}
                                        </a>
                                    </h4>
                                    <time class="timeSidebar loading">
                                        <p>
                                            {{ $category->created_at->format('j M, Y') }}
                                        </p>
                                    </time>
                                </div>
                            @endforeach

                        </div>

                    </div>

                    <div class="sidebar">

                        <h3 class="sidebar-title">Tutorial</h3>
                        <div class="sidebar-item categories @if ($tutorials->count() >= 3) height-195 @endif">

                            @foreach ($tutorials as $tutorial)
                                <div class="category-item clearfix">
                                    <div class="imgSidebar img-container">
                                        <a href="{{ route('blog.posts.tutorials', ['slug' => $tutorial->slug]) }}">
                                            @if (file_exists('vendor/dashboard/image/thumbnail-tutorials/' . $tutorial->thumbnail))
                                                <img class="img-container"
                                                    src="{{ asset('vendor/dashboard/image/thumbnail-tutorials/' . $tutorial->thumbnail) }}"
                                                    alt="{{ $tutorial->title }}">
                                            @else
                                                <img class="img-container"
                                                    src="{{ asset('vendor/blog/img/default.png') }}"
                                                    alt="{{ $tutorial->title }}">
                                            @endif
                                        </a>
                                    </div>
                                    <h4 class="titleSidebar loading">

                                        <a class="underline"
                                            href="{{ route('blog.posts.tutorials', ['slug' => $tutorial->slug]) }}">
                                            {{ $tutorial->title }}
                                        </a>

                                    </h4>
                                    <time class="timeSidebar loading">
                                        <p>
                                            {{ $tutorial->created_at->format('j M, Y') }}
                                        </p>
                                    </time>
                                </div>
                            @endforeach

                        </div>

                    </div>

                    <div class="sidebar">
                        <h3 class="sidebar-title">Tag</h3>

                        <div class="sidebar-item tags ">
                            <ul>
                                @foreach ($tags as $tag)
                                    <li>
                                        <a class="m-0" href="{{ route('blog.posts.tags', ['slug' => $tag->slug]) }}">
                                            # {{ $tag->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>
    </div>
@endsection

@push('js-internal')
    <script>
        mediumZoom('.popup', {
            scrollOffset: 150,
            margin: 5,
        })
    </script>
@endpush

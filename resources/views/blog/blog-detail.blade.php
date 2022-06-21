@extends('layouts.blog')

@section('keywords')
    {{ $setting->meta_keywords }}, {{ $post->keywords }}
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
                                    <span>{{ $post->user->name }}</span>
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
                        <div class="float-left d-flex">
                            <div class="tagCats loading">
                                <i class="icofont-tags"></i>
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

                            <div class="ml-1 tagCats loading">
                                <i class="icofont-folder"></i>
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
                                <div class="ml-1 tagCats loading">
                                    <i class="uil uil-books"></i>
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

                    </div>
                </article>

                {{-- Tutorial post --}}
                <div id="tutorialPost" class="related-post mb-4">
                    @include('blog.sub-blog.tutorial-post')
                </div>

                <div class="blog-author d-flex align-items-center">
                    @if (file_exists('vendor/dashboard/image/picture-profiles/' . $post->user->user_image))
                        <img src="{{ asset('vendor/dashboard/image/picture-profiles/' . $post->user->user_image) }}"
                            alt="{{ $post->user->name }}" class="rounded-circle float-left" />
                    @else
                        <img src="{{ asset('vendor/dashboard/image/avatar.png') }}" class="rounded-circle float-left"
                            alt="">
                    @endif
                    <div>
                        <a class="nameAuthor" href="{{ route('blog.author', ['author' => $post->user->slug]) }}">
                            {{ $post->user->name }}
                        </a>
                        <div class="social-links">
                            <a target="_blank" href="{{ $post->user->facebook }}">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a target="_blank" href="{{ $post->user->twitter }}">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a target="_blank" href="{{ $post->user->instagram }}">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a target="_blank" href="{{ $post->user->github }}">
                                <i class="fab fa-github"></i>
                            </a>
                        </div>
                        <p>
                            " {{ $post->user->bio }} "
                        </p>
                    </div>
                </div>

                @if ($prev != null || $next != null)
                    <article class="entry-bottom" style="margin-bottom: 20px">
                        @if ($prev)
                            <div class="float-right">
                                <a href="{{ route('blog.detail', ['slug' => $prev->slug]) }}" class="btn-Next">
                                    Berikutnya <i class="icofont-rounded-right"></i>
                                </a>
                            </div>
                        @endif

                        @if ($next)
                            <div class="float-left">
                                <a href="{{ route('blog.detail', ['slug' => $next->slug]) }}" class="btn-Prev">
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

                <article class="sect-coment" id="sectComment">
                    @if ($post->comments->count() >= 1)
                        <h2 class="sect-title"> {{ $post->comments->count() }} Komentar</h2>
                        <hr class="hr" style="padding-bottom: 5px">
                    @else
                        <h2 class="sect-title"> Belum ada komentar</h2>
                        <hr class="hr" style="padding-bottom: 5px">
                    @endif

                    @comments([
                        'model' => $post,
                        'approved' => true,
                        'maxIndentationLevel' => 1,
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
                        <div class="sidebar-item categories">

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
                        <div class="sidebar-item categories">

                            @foreach ($tutorials as $tutorial)
                                <div class="category-item clearfix">
                                    <div class="imgSidebar img-container">
                                        <a href="{{ route('blog.posts.tutorials.author', ['slug' => $tutorial->slug, 'user' => $post->user->slug]) }}">
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
                                            href="{{ route('blog.posts.tutorials.author', ['slug' => $tutorial->slug, 'user' => $post->user->slug]) }}">
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

                        <div class="sidebar-item tags">
                            <ul>
                                @foreach ($tags as $tag)
                                    <li>
                                        <a href="{{ route('blog.posts.tags', ['slug' => $tag->slug]) }}">
                                            {{ $tag->title }}
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

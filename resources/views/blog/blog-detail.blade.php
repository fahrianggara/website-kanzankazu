@extends('layouts.blog')

@section('author')
    {{ $post->author }}
@endsection

@section('title')
    {{ $post->title }}
@endsection

@section('desc')
    {{ $post->description }}
@endsection

@section('content')

    <div class="progress-read">
        <div class="bar"></div>
    </div>

    <div class="container">


        <div class="row">

            <div class="col-lg-8 entries">

                <article class="entry entry-single" style="margin-bottom: 20px">

                    <div class="entry-img loading">
                        @if (file_exists(public_path($post->thumbnail)))
                            <img src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}" class="img-fluid" />
                        @else
                            <img class="img-fluid" src="{{ asset('vendor/my-blog/img/noimage.jpg') }}"
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
                        </div>

                    </div>

                </article>

                <article class="entry-bottom" style="margin-bottom: 20px">

                    @if ($prev)
                        <div class="float-right">
                            <a href="{{ route('blog.detail', ['slug' => $prev->slug]) }}" class="btn-Next">
                                {{ trans('blog.button.btnNext') }} <i class="icofont-rounded-right"></i>
                            </a>
                        </div>
                    @endif

                    @if ($next)
                        <div class="float-left">
                            <a href="{{ route('blog.detail', ['slug' => $next->slug]) }}" class="btn-Prev">
                                <i class="icofont-rounded-left"></i> {{ trans('blog.button.btnPrev') }}
                            </a>
                        </div>
                    @endif
                </article>

                <article class="sect-coment">
                    <h2 class="sect-title"> {{ $post->comments->count() }} {{ trans('blog.comment') }}</h2>
                    <hr class="hr" style="padding-bottom: 5px">
                    @comments([
                    'model' => $post,
                    'approved' => true,
                    'maxIndentationLevel' => 1
                    ])
                </article>

                {{-- RELATED POSTS --}}
                <div id="relatedPost" class="related-post">
                    @include('blog.sub-blog.related-post')
                </div>

            </div>

            <div class="col-lg-4">

                <div class="fixedInfo">
                    <div class="sidebar">
                        <h3 class="sidebar-title">{{ trans('blog.sidebar.newPost') }}</h3>
                        <div class="sidebar-item recent-posts">

                            @foreach ($recents as $recent)
                                <div class="post-item clearfix">
                                    <div class="imgSidebar loading">
                                        <a href="{{ route('blog.detail', ['slug' => $recent->slug]) }}">
                                            @if (file_exists(public_path($recent->thumbnail)))
                                                <div class="img-container">
                                                    <img src="{{ asset($recent->thumbnail) }}"
                                                        alt="{{ $recent->title }}" />
                                                </div>
                                            @else
                                                <div class="img-container">
                                                    <img src="{{ asset('vendor/my-blog/img/noimage.jpg') }}"
                                                        alt="{{ $recent->title }}">
                                                </div>
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

                        <h3 class="sidebar-title">{{ trans('blog.sidebar.categories') }}</h3>
                        <div class="sidebar-item categories">

                            @foreach ($categories as $category)
                                <div class="category-item clearfix">
                                    <div class="imgSidebar loading">
                                        <a href="{{ route('blog.posts.categories', ['slug' => $category->slug]) }}">
                                            <div class="img-container">
                                                <img src="{{ asset($category->thumbnail) }}" alt="{{ $category->title }}"
                                                    class="img-fluid" />
                                            </div>
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
                                            {{ $category->created_at->format('j M, Y') }} -
                                            <span>
                                                ({{ $category->posts->count() }})
                                            </span>
                                        </p>
                                    </time>
                                </div>
                            @endforeach

                        </div>

                    </div>

                    <div class="sidebar">
                        <h3 class="sidebar-title">{{ trans('blog.sidebar.tags') }}</h3>

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

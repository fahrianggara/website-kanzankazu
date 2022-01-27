@extends('layouts.blog')

@section('author')
    Fahri Anggara
@endsection

@section('title')
    my BLOGS
@endsection

@section('content')

    <div class="container">
        <div class="row">
            @forelse ($posts as $post)
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up">

                    <article class="entry-thumbnail">
                        <div class="entry-img loading">
                            <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}">
                                @if (file_exists(public_path($post->thumbnail)))
                                    <img src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}"
                                        class="img-fluid" />
                                @else
                                    <img class="img-fluid" src="{{ asset('vendor/my-blog/img/noimage.jpg') }}"
                                        alt="{{ $post->title }}">
                                @endif
                            </a>
                        </div>

                        <h2 class="entry-title loading">
                            <a class="underline"
                                href="{{ route('blog.detail', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
                        </h2>

                        <div class="entry-meta">
                            <ul>
                                <li class="d-flex align-items-center">
                                    <div class="loading">
                                        <i class="icofont-user"></i>
                                        <a class="underline iconAuthor"
                                            href="{{ route('blog.author', ['author' => $post->user->slug]) }}">{{ $post->user->name }}</a>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center">
                                    <div class="loading">
                                        <i class="uil uil-calendar-alt"></i>
                                        <span>{{ $post->created_at->format('j M, Y') }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="entry-content">
                            <div class="loading">
                                <p>
                                    {{ substr($post->description, 0, 200) }}...
                                </p>
                            </div>
                            <div class="read-more loading">
                                <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}">
                                    {{ trans('blog.button.btnDetail') }}
                                </a>
                            </div>
                        </div>
                    </article>

                </div>
            @empty
                <div class="container">
                    <div class="col-lg-12">

                        <div id="empty-blog">

                            <svg viewBox="0 0 117 117" fill="none" class="iconMeh"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle class="face" cx="58.5" cy="58.5" r="57.5" stroke-width="2" />
                                <circle class="eye" cx="40.5" cy="40.5" r="8.5" />
                                <circle class="eye" cx="77.5" cy="40.5" r="8.5" />
                                <line class="mouth" x1="32.6453" y1="89.065" x2="90.6453" y2="67.065"
                                    stroke="white" stroke-width="2" />
                            </svg>


                            <p class="text-emptyBlog">
                                {{ trans('blog.no-data.blogs') }}
                            </p>

                            <a href="{{ route('homepage') }}"
                                class="buttonBlogNotFound">{{ trans('error.404-backLink') }}</a>
                        </div>

                    </div>
                </div>
            @endforelse

        </div>


        @if ($posts->hasPages())
            {{ $posts->links('vendor.pagination.blog') }}
        @endif
    </div>

@endsection

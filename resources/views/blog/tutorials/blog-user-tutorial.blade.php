@extends('layouts.blog')

@section('title')
    Tutorial {{ $tutorial->title }} | by {{ $author->name }}
@endsection

@section('keywords')
    Tutorial {{ $tutorial->title }} | by {{ $author->name }} {{ $setting->site_name }}
@endsection

@section('content')
    <div class="container">
        @if ($tutorial->posts->count() >= 1)
            <div class="section-title">
                <h2>Tutorial {{ $tutorial->title }} oleh {{ $author->name }}.</h2>
                <p>Ada {{ $tutorial->posts->count() }} tutorial <span class="titleFilter">{{ $tutorial->title }}</span> yang
                    dibuat oleh <span class="titleFilter">{{ $author->name }}</span>.</p>
            </div>
        @endif

        <div class="row">
            @forelse ($posts as $post)
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up">

                    <article class="entry-thumbnail">
                        <div class="entry-img loading">
                            <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}">
                                @if (file_exists('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail))
                                    <img src="{{ asset('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail) }}"
                                        alt="{{ $post->title }}" class="img-fluid" />
                                @else
                                    <img class="img-fluid" src="{{ asset('vendor/blog/img/default.png') }}"
                                        alt="{{ $post->title }}">
                                @endif
                            </a>
                        </div>

                        <div class="tag">
                            @foreach ($post->tags as $tag)
                                <a href="{{ route('blog.posts.tags', ['slug' => $tag->slug]) }}"
                                    class="badge badge-primary">
                                    {{ $tag->title }}
                                </a>
                            @endforeach
                        </div>

                        <h2 class="entry-title loading">
                            <a class="underline"
                                href="{{ route('blog.detail', ['slug' => $post->slug]) }}">{{ '#' . $loop->iteration . ' - ' . $post->title }}</a>
                        </h2>

                        <div class="entry-content">
                            <div class="loading">
                                <p>
                                    @if (strlen($post->description) > 150)
                                        {{ substr($post->description, 0, 150) }}...
                                    @else
                                        {{ substr($post->description, 0, 150) }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="entry-meta">
                            <ul>
                                <li class="d-flex align-items-center">
                                    @php
                                        if (file_exists('vendor/dashboard/image/picture-profiles/' . $post->user->user_image)) {
                                            $avatar = asset('vendor/dashboard/image/picture-profiles/' . $post->user->user_image);
                                        } elseif ($post->user->status == 'banned') {
                                            $avatar = asset('vendor/dashboard/image/avatar.png');
                                        } elseif ($post->user->provider == 'google' || $post->user->provider == 'github') {
                                            $avatar = $post->user->user_image;
                                        } else {
                                            $avatar = asset('vendor/dashboard/image/avatar.png');
                                        }
                                    @endphp
                                    <div class="author-thumbnail">
                                        <img class="img-circle img-fluid" src="{{ $avatar }}">
                                        @if ($post->user->status == 'banned')
                                            <a class="underline iconAuthor" href="javascript:void(0)"
                                                style="cursor: default">Akun
                                                diblokir
                                            </a>
                                        @else
                                            <a class="underline iconAuthor"
                                                href="{{ route('blog.author', ['author' => $post->user->slug]) }}">{{ $post->user->name }}</a>
                                        @endif
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </article>

                </div>
            @empty
                <!-- empty -->
                <div class="container">

                    <div class="col-lg-12">

                        <div id="empty-blog">

                            <svg viewBox="0 0 117 117" fill="none" class="iconMeh" xmlns="http://www.w3.org/2000/svg">
                                <circle class="face" cx="58.5" cy="58.5" r="57.5" stroke-width="2" />
                                <circle class="eye" cx="40.5" cy="40.5" r="8.5" />
                                <circle class="eye" cx="77.5" cy="40.5" r="8.5" />
                                <line class="mouth" x1="32.6453" y1="89.065" x2="90.6453" y2="67.065"
                                    stroke="white" stroke-width="2" />
                            </svg>


                            <p class="text-emptyBlog">
                                Oops.. sepertinya author <span class="titleFilter">{{ $author->name }}</span> belum
                                membuat tutorial <span class="titleFilter">{{ $tutorial->title }}</span>.
                            </p>

                            <a id="buttonBack" class="buttonBlogNotFound">Kembali</a>
                        </div>

                    </div>
                </div>
            @endforelse
        </div>

    </div>
@endsection

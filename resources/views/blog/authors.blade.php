@extends('layouts.blog')

@section('title')
    {{ '@' . $user->name }}
@endsection

@section('content')
    <div class="authorSec section-bg">
        <div class="container mb-5">
            <div class="row">
                <div class="col-md-12 text-center authorBlog" data-aos="fade-up">
                    <div class="entry-img loading">
                        @if (file_exists('vendor/dashboard/image/picture-profiles/' . $user->user_image))
                            <img src="{{ asset('vendor/dashboard/image/picture-profiles/' . $user->user_image) }}"
                                alt="" class="img-fluid img-round" />
                        @else
                            <img src="{{ asset('vendor/dashboard/image/avatar.png') }}" alt=""
                                class="img-fluid img-round" />
                        @endif
                    </div>

                    <h3 class="author-title">
                        {{ $user->name }}
                    </h3>

                    <p class="author-bio">
                        @if ($user->bio != null)
                            {{ $user->bio }}
                        @else
                            KanzanKazu
                        @endif
                    </p>

                    <div class="author-sosmed">
                        @if ($user->facebook != null)
                            <a target="_blank" href="{{ $user->facebook }}">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @elseif ($user->twitter != null)
                            <a target="_blank" href="{{ $user->twitter }}">
                                <i class="fab fa-twitter"></i>
                            </a>
                        @elseif ($user->instagram != null)
                            <a target="_blank" href="{{ $user->instagram }}">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @elseif ($user->github != null)
                            <a target="_blank" href="{{ $user->github }}">
                                <i class="fab fa-github"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($recommendationPosts->isNotEmpty())
        <div class="container">
            <div class="section-title">
                <h2>Rekomendasi Blog</h2>
                <p>Ada {{ $recommendationPosts->count() }} blog yang direkomendasikan oleh {{ $user->name }}.</p>
            </div>

            <div class="row">
                @forelse ($recommendationPosts as $recommended)
                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up">

                        <article class="entry-thumbnail">
                            <div class="entry-img loading">
                                @if (file_exists('vendor/dashboard/image/thumbnail-posts/' . $recommended->post->thumbnail))
                                    <a href="{{ route('blog.detail', ['slug' => $recommended->post->slug]) }}">
                                        <img src="{{ asset('vendor/dashboard/image/thumbnail-posts/' . $recommended->post->thumbnail) }}"
                                            alt="{{ $recommended->post->title }}" class="img-fluid" />
                                    </a>
                                @else
                                    <a href="{{ route('blog.detail', ['slug' => $recommended->post->slug]) }}">
                                        <img src="{{ asset('vendor/blog/img/default.png') }}"
                                            alt="{{ $recommended->post->title }}" class="img-fluid" />
                                    </a>
                                @endif
                            </div>

                            <h2 class="entry-title loading">
                                <a class="underline"
                                    href="{{ route('blog.detail', ['slug' => $recommended->post->slug]) }}">{{ $recommended->post->title }}</a>
                            </h2>

                            <div class="entry-meta">
                                <ul>
                                    <li class="d-flex align-items-center">
                                        <div class="loading">
                                            <i class="icofont-user"></i>
                                            <span>{{ $user->name }}</span>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <div class="loading">
                                            <i class="uil uil-calendar-alt"></i>
                                            <span>{{ $recommended->post->created_at->format('j M, Y') }}</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="entry-content">
                                <div class="loading">
                                    <p>
                                        {{ substr($recommended->post->description, 0, 200) }}...
                                    </p>
                                </div>
                                <div class="read-more loading">
                                    <a href=" {{ route('blog.detail', ['slug' => $recommended->post->slug]) }}">
                                        Lihat Postingan
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
                                    Oops.. sepertinya author <span class="titleFilter">{{ $user->name }}</span> belum
                                    membuat artikel.
                                </p>

                                <a id="buttonBack" class="buttonBlogNotFound">Kembali</a>
                            </div>

                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    @endif

    <div class="container">
        @if ($posts->count() >= 1)
            <div class="section-title">
                <h2>by {{ $user->name }}.</h2>
                <p>Ada {{ $posts->count() }} blog yang ditulis oleh {{ $user->name }}.</p>
            </div>
        @endif

        <div class="row">
            @forelse ($posts as $post)
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up">

                    <article class="entry-thumbnail">
                        <div class="entry-img loading">
                            @if (file_exists('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail))
                                <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}">
                                    <img src="{{ asset('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail) }}"
                                        alt="{{ $post->title }}" class="img-fluid" />
                                </a>
                            @else
                                <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}">
                                    <img src="{{ asset('vendor/blog/img/default.png') }}" alt="{{ $post->title }}"
                                        class="img-fluid" />
                                </a>
                            @endif
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
                                        <span>{{ $user->name }}</span>
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
                                <a href=" {{ route('blog.detail', ['slug' => $post->slug]) }}">
                                    Lihat Postingan
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
                                Oops.. sepertinya author <span class="titleFilter">{{ $user->name }}</span> belum
                                membuat artikel.
                            </p>

                            <a id="buttonBack" class="buttonBlogNotFound">Kembali</a>
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

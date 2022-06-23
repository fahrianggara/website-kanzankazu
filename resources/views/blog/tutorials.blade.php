@extends('layouts.blog')

@section('title')
    Tutorial
@endsection

@section('keywords')
    {{ $setting->meta_keywords }} tutorial kanzankazu, {{ $setting->site_name }}
@endsection

@section('content')
    <div class="container">
        @if ($tutorials->count() >= 1)
            <div class="section-title">
                <h2>Mau pilih tutorial apa?</h2>
                <p>Silahkan pilih tutorial yang kamu cari.</p>
            </div>
        @endif

        <div class="row">
            @forelse ($tutorials as $tutorial)
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up">

                    <article class="entry-thumbnail">
                        <div class="entry-img loading">
                            <a href="{{ route('blog.posts.tutorials', ['slug' => $tutorial->slug]) }}">
                                @if (file_exists('vendor/dashboard/image/thumbnail-tutorials/' . $tutorial->thumbnail))
                                    <img src="{{ asset('vendor/dashboard/image/thumbnail-tutorials/' . $tutorial->thumbnail) }}"
                                        alt="{{ $tutorial->title }}" class="img-fluid" />
                                @else
                                    <img class="img-fluid" src="{{ asset('vendor/blog/img/default.png') }}"
                                        alt="{{ $tutorial->title }}">
                                @endif
                            </a>
                        </div>

                        <h2 class="entry-title loading">
                            <a class="underline"
                                href="{{ route('blog.posts.tutorials', ['slug' => $tutorial->slug]) }}">{{ $tutorial->title }}</a>
                        </h2>

                        <div class="entry-meta">
                            <ul>
                                <li class="d-flex align-items-center">
                                    <div class="loading">
                                        <i class="uil uil-file-info-alt"></i>
                                        <span>{{ $tutorial->posts->count() }}</span>
                                    </div>
                                </li>

                                <li class="d-flex align-items-center">
                                    <div class="loading">
                                        <i class="uil uil-calendar-alt"></i>
                                        <span>{{ $tutorial->created_at->format('j M, Y') }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="entry-content">
                            <div class="loading">
                                <p>
                                    {{ substr($tutorial->description, 0, 200) }}...
                                </p>
                            </div>
                            <div class="read-more loading">
                                <a href="{{ route('blog.posts.tutorials', ['slug' => $tutorial->slug]) }}">
                                    Lihat Tutorial
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
                                Oops.. Sepertinya tutorial blog belum dibuat.
                            </p>

                            <a id="buttonBack" class="buttonBlogNotFound">Kembali</a>
                        </div>

                    </div>
                </div>
            @endforelse

        </div>
        @if ($tutorials->hasPages())
            {{ $tutorials->links('vendor.pagination.blog') }}
        @endif
    </div>
@endsection

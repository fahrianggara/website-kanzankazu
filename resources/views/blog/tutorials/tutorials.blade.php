@extends('layouts.blog')

@section('title')
    Tutorial
@endsection

@section('keywords')
    Tutorial kanzankazu
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

                        <div class="entry-content">
                            <div class="loading">
                                <p>
                                    @if ($tutorial->description == null)
                                        {{ $tutorial->title }}
                                    @else
                                        @if (strlen($tutorial->description) > 150)
                                            {{ substr($tutorial->description, 0, 150) }}...
                                        @else
                                            {{ substr($tutorial->description, 0, 150) }}
                                        @endif
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="entry-meta">
                            <ul>
                                <li class="d-flex align-items-center">
                                    <div class="loading">
                                        <i class="uil uil-file-info-alt"></i>
                                        <span>{{ $tutorial->posts->count() }}</span>
                                    </div>
                                </li>
                            </ul>
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

@extends('layouts.blog')

@section('title')
    Author
@endsection

@section('keywords')
    Author {{ $setting->site_name }}
@endsection

@section('content')
    <div class="container">
        @if ($authors->count() >= 1)
            <div class="section-title">
                <h2>Author</h2>
                <p>Ini dia, penulis blog di website ini.</p>
            </div>
        @endif

        <div class="row">
            @forelse ($authors as $author)
                <div class="col-md-5 col-sm-6 col-lg-4 col-xl-3 cardShowAuthors">
                    <div class="card card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @if (file_exists('vendor/dashboard/image/picture-profiles/' . $author->user_image))
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('vendor/dashboard/image/picture-profiles/' . $author->user_image) }}"
                                        alt="{{ $author->name }} avatar">
                                @elseif ($author->provider == 'google' || $author->provider == 'github')
                                    <img class="profile-user-img img-fluid img-circle" src="{{ $author->user_image }}"
                                        alt="{{ $author->name }} avatar">
                                @else
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('vendor/dashboard/image/avatar.png') }}"
                                        alt="{{ $author->name }} avatar">
                                @endif
                            </div>
                            <h3 class="profile-username text-center">
                                <a class="underline" href="{{ route('blog.author', ['author' => $author->slug]) }}">
                                    @if (strlen($author->name) > 10)
                                        {{ substr($author->name, 0, 10) . '..' }}

                                    @else
                                        {{ $author->name }}

                                    @endif
                                </a>
                            </h3>
                            <p class="text-muted text-center">{{ $author->roles->first()->name }}</p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Blog</b> <a class="float-right countPosts">{{ $author->posts->count() }}</a>
                                </li>

                            </ul>
                            <a href="{{ route('blog.author', ['author' => $author->slug]) }}"
                                class="btn btn-primary btn-block"><b>Lihat Profil</b></a>
                        </div>

                    </div>
                </div>
            @empty
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
                                Oops.. Sepertinya belum ada yang berkontribusi di website ini.
                            </p>

                            <a onclick="buttonBack()" class="buttonBlogNotFound">Kembali</a>
                        </div>

                    </div>
                </div>
            @endforelse
        </div>
        @if ($authors->hasPages())
            {{ $authors->links('vendor.pagination.blog') }}
        @endif
    </div>
@endsection

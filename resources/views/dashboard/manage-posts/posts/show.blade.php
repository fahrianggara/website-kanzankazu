@extends('layouts.dashboard')

@section('title')
    {{ $post->title }}
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('detail_post', $post) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8 entries">
            <article class="entry entry-single">

                <div class="entry-img loading">
                    @if (file_exists('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail))
                        <img src="{{ asset('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail) }}"
                            alt="{{ $post->title }}" class="img-fluid" />
                    @else
                        <img class="img-fluid" src="{{ asset('vendor/blog/img/default.png') }}" alt="{{ $post->title }}">
                    @endif
                </div>

                <h1 class="entry-title loading">
                    <span>{{ $post->title }}</span>
                </h1>

                <div class="entry-meta">
                    <ul>
                        <li class="d-flex align-items-center">
                            <div class="loading">
                                <i class="uil uil-user"></i>
                                <span>{{ $post->user->name }}</span>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="loading">
                                <i class="uil uil-calendar-alt"></i>
                                <span>{{ $post->created_at->format('j F Y') }}</span>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="loading">
                                <i class="uil uil-eye"></i>
                                <span> {{ $post->views }}</span>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="loading">
                                <i class="uil uil-file-info-alt"></i>
                                <span> {{ $post->status }}</span>
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
                            <i class="uil uil-tag-alt"></i>
                            <ul class="tags">
                                @foreach ($tags as $tag)
                                    <li>
                                        <span class="link-tagCats">
                                            {{ $tag->title }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="ml-1 tagCats loading">
                            <i class="uil uil-folder"></i>
                            <ul class="tags">
                                @foreach ($categories as $category)
                                    <li>
                                        <span class="link-tagCats">
                                            {{ $category->title }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            </article>
        </div>

        <div class="col-lg-4">
            <div class="sticky">

                {{-- PREV & NEXT STATUS PUBLISH --}}
                @if ($nextPublish != null || $prevPublish != null)
                    @if ($post->status == 'publish')
                        <div class="entry-bottom">
                            @if ($nextPublish)
                                <div class="float-left">
                                    <a href="{{ route('posts.show', ['slug' => $nextPublish->slug]) }}" class="btn-Prev">
                                        <i class="uil uil-angle-double-left"></i> Sebelumnya
                                    </a>
                                </div>
                            @endif
                            @if ($prevPublish)
                                <div class="float-right">
                                    <a href="{{ route('posts.show', ['slug' => $prevPublish->slug]) }}" class="btn-Next">
                                        Berikutnya <i class="uil uil-angle-double-right"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                @endif

                {{-- PREV & NEXT STATUS DRAFT --}}
                @if ($post->status == 'draft')
                    @if ($nextDraft != null || $prevDraft != null)
                        <div class="entry-bottom">
                            @if ($nextDraft)
                                <div class="float-left">
                                    <a href="{{ route('posts.show', ['slug' => $nextDraft->slug]) }}" class="btn-Prev">
                                        <i class="uil uil-angle-double-left"></i> Sebelumnya
                                    </a>
                                </div>
                            @endif
                            @if ($prevDraft)
                                <div class="float-right">
                                    <a href="{{ route('posts.show', ['slug' => $prevDraft->slug]) }}" class="btn-Next">
                                        Berikutnya <i class="uil uil-angle-double-right"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                @endif

                <div class="entry-bottom">
                    <div class="float-left">
                        @if ($post->status == 'draft')
                            <a href="{{ route('posts.index', 'status=draft') }}" class="btn-Prev">
                                <i class="uil uil-angle-double-left"></i> Kembali ke Menu
                            </a>
                        @else
                            <a href="{{ route('posts.index') }}" class="btn-Prev">
                                <i class="uil uil-angle-double-left"></i> Kembali ke Menu
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

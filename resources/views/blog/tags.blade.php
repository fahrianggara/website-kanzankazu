@extends('layouts.blog')

@section('title')
    {{ trans('blog.navbar.tags') }}
@endsection

@section('content')

    <div class="container">
        <div class="tags tags-container">
            <div class="col-lg-12 col-md-12">
                @forelse ($tags as $tag)

                    <a class="button-links btnLinkTag" href="{{ route('blog.posts.tags', ['slug' => $tag->slug]) }}">
                        {{ $tag->title }}
                        ({{ $tag->posts->count() }})
                    </a>
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
                                    {{ trans('blog.no-data.tags') }}
                                </p>

                                <a href="{{ route('homepage') }}"
                                    class="buttonBlogNotFound">{{ trans('error.404-backLink') }}</a>
                            </div>

                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        @if ($tags->hasPages())
            {{ $tags->links('vendor.pagination.blog') }}
        @endif
    </div>

@endsection

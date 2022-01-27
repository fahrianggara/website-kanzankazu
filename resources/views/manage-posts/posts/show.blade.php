@extends('layouts.dashboard')

@section('title')
    Post Detail
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('detail_post', $post) }}
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-8">
            <div class="card m-b-30">
                @if (file_exists(public_path($post->thumbnail)))
                    <img class="card-img-top img-fluid" src="{{ asset($post->thumbnail) }}" alt="Card image cap">
                @else
                    <svg class="img-fluid" width="100%" height="400" xmlns="http://www.w3.org/2000/svg"
                        preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
                        <rect width="100%" height="100%" fill="#868e96"></rect>
                        <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#dee2e6" dy=".3em"
                            font-size="24">
                            {{ $post->title }}
                        </text>
                    </svg>
                @endif
                <div class="card-body">
                    <h4 class="card-title font-20 mt-0" style="margin: 0">{{ $post->title }}</h4>
                    <span class="card-text">
                        <i class="uil uil-user"></i> {{ $post->author }}
                    </span>
                    |
                    <span class="card-text">
                        <i class="uil uil-calendar-alt"></i> {{ $post->created_at->format('d/m/Y') }}
                    </span>
                    |
                    <span class="card-text">
                        <i class="uil uil-eye"></i> {{ $post->views }}
                    </span>
                    |
                    @foreach ($categories as $category)
                        <span class="badge badge-primary">{{ $category->title }} </span>
                    @endforeach
                    /
                    @foreach ($tags as $tag)
                        <span class="badge badge-info">{{ $tag->title }}</span>
                    @endforeach

                    <div class="py-1 card-text">
                        {!! $post->content !!}
                    </div>
                    <hr>

                    <div class="">
                       <a href=" {{ route('posts.index') }}" class="btn btn-info">
                        Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

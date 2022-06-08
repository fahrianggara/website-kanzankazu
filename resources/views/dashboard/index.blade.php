@extends('layouts.dashboard')

@section('title')
    Dashboard
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('dashboard') }}
@endsection

@section('content')
    <div class="row">

        @can('manage_posts')
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <a href="{{ route('posts.index') }}" class="waves-effect">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="col-3 align-self-center">
                                    <div class="round">
                                        <i class="uil uil-book-medical"></i>
                                    </div>
                                </div>
                                <div class="col-9 align-self-center text-center">
                                    <div class="m-l-10">
                                        <h5 class="mt-0 round-inner">{{ $countPost }}</h5>
                                        <p class="mb-0 text-muted">Posts</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan

        @can('manage_categories')
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <a href="{{ route('categories.index') }}" class="waves-effect">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="col-3 align-self-center">
                                    <div class="round">
                                        <i class="uil uil-bookmark"></i>
                                    </div>
                                </div>
                                <div class="col-9 align-self-center text-center">
                                    <div class="m-l-10">
                                        <h5 class="mt-0 round-inner">{{ $countCategory }}</h5>
                                        <p class="mb-0 text-muted">Categories </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan

        @can('manage_tags')
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <a href="{{ route('tags.index') }}" class="waves-effect">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="col-3 align-self-center">
                                    <div class="round">
                                        <i class="uil uil-tag-alt"></i>
                                    </div>
                                </div>
                                <div class="col-9 align-self-center text-center">
                                    <div class="m-l-10">
                                        <h5 class="mt-0 round-inner">{{ $countTag }}</h5>
                                        <p class="mb-0 text-muted">Tags</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan

        @can('manage_roles')
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <a href="{{ route('roles.index') }}" class="waves-effect">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="col-3 align-self-center">
                                    <div class="round">
                                        <i class="uil uil-user-arrows"></i>
                                    </div>
                                </div>
                                <div class="col-9 align-self-center text-center">
                                    <div class="m-l-10">
                                        <h5 class="mt-0 round-inner">{{ $countRole }}</h5>
                                        <p class="mb-0 text-muted">Roles</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan

        @can('manage_users')
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <a href="{{ route('users.index') }}" class="waves-effect">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="col-3 align-self-center">
                                    <div class="round">
                                        <i class="uil uil-users-alt"></i>
                                    </div>
                                </div>
                                <div class="col-9 align-self-center text-center">
                                    <div class="m-l-10">
                                        <h5 class="mt-0 round-inner">{{ $countUser }}</h5>
                                        <p class="mb-0 text-muted">Users</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan

        @can('manage_inbox')
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <a href="{{ route('contact.index') }}" class="waves-effect">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="col-3 align-self-center">
                                    <div class="round">
                                        <i class="uil uil-inbox"></i>
                                    </div>
                                </div>
                                <div class="col-9 align-self-center text-center">
                                    <div class="m-l-10">
                                        <h5 class="mt-0 round-inner">{{ $countContact }}</h5>
                                        <p class="mb-0 text-muted">Inbox</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan

    </div>

    {{-- POST TODAY --}}
    @can('manage_posts')
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        Post Today
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @if ($postToday->count() >= 1)
                @foreach ($postToday as $post)
                    @if ($post->user_id == Auth::user()->id)
                        <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                            <div class="card m-b-30">
                                @if (file_exists('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail))
                                    <img src="{{ asset('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail) }}"
                                        alt="{{ $post->title }}" class="card-img-top img-fluid">
                                @else
                                    <img src="{{ asset('vendor/blog/img/default.png') }}" alt="{{ $post->title }}"
                                        class="card-img-top img-fluid">
                                @endif

                                <div class="card-body">
                                    <h5 class="card-title font-20 mt-0">{{ $post->title }}</h5>
                                    <p class="card-text">{{ substr($post->description, 0, 150) }}...</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="col-12">
                    <div class="text-center m-b-30" role="alert">
                        You don't have today's latest post
                    </div>
                </div>
            @endif
        </div>
        @if ($postToday->count() >= 1)
            <div class="row">
                <div class="col-12 m-b-30">
                    @if ($postToday->hasPages())
                        {{ $postToday->links('vendor.pagination.bootstrap-4') }}
                    @endif
                </div>
            </div>
        @endif
    @endcan

    {{-- CATEGORY TODAY --}}
    @can('manage_categories')
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        Category Today
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @if ($cateToday->count() >= 1)
                @foreach ($cateToday as $cate)
                    <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                        <div class="card m-b-30">
                            @if (file_exists('vendor/dashboard/image/thumbnail-categories/' . $cate->thumbnail))
                                <img src="{{ asset('vendor/dashboard/image/thumbnail-categories/' . $cate->thumbnail) }}"
                                    alt="{{ $cate->title }}" class="card-img-top img-fluid">
                            @else
                                <img src="{{ asset('vendor/blog/img/default.png') }}" alt="{{ $cate->title }}"
                                    class="card-img-top img-fluid">
                            @endif

                            <div class="card-body">
                                <h5 class="card-title font-20 mt-0">{{ $cate->title }}</h5>
                                <p class="card-text">{{ substr($cate->description, 0, 150) }}...</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="text-center m-b-30" role="alert">
                        You don't have today's newest category
                    </div>
                </div>
            @endif
        </div>
        @if ($cateToday->count() >= 1)
            <div class="row">
                <div class="col-12 m-b-30">
                    @if ($cateToday->hasPages())
                        {{ $cateToday->links('vendor.pagination.bootstrap-4') }}
                    @endif
                </div>
            </div>
        @endif
    @endcan

    {{-- TAG TODAY --}}
    @can('manage_tags')
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        Tag Today
                    </div>
                    <div class="card-body">
                        @if ($tagToday->count() >= 1)
                            @foreach ($tagToday as $tag)
                                <span class="badge badge-pill badge-primary">{{ $tag->title }}</span>
                            @endforeach
                        @else
                            <div class="text-center" role="alert">
                                You don't have today's latest tags
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endcan

    {{-- USER TODAY --}}
    @can('manage_users')
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        User Today
                    </div>
                    <div class="card-body">
                        @if ($userToday->count() >= 1)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach ($userToday as $user)
                                            <tr class="text-center">
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->roles->first()->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                @if ($userToday->hasPages())
                                    <div class="card-footer">
                                        <div class="page-footer">
                                            {{ $userToday->links('vendor.pagination.bootstrap-4') }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center">
                                You don't have today's latest users
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endcan

    {{-- ROLE TODAY --}}
    @can('manage_roles')
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        Role Today
                    </div>
                    <div class="card-body">
                        @if ($roleToday->count() >= 1)
                            @foreach ($roleToday as $role)
                                <span class="badge badge-pill badge-primary">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        @else
                            <div class="text-center" role="alert">
                                You don't have today's latest roles
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endcan

    {{-- INBOX CONTACT TODAY --}}
    @can('manage_inbox')
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        Inbox Today
                    </div>
                    <div class="card-body">
                        @if ($inboxToday->count() >= 1)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inboxToday as $inbox)
                                            <tr class="text-center">
                                                <td>{{ $inbox->name }}</td>
                                                <td>{{ $inbox->email }}</td>
                                                <td>{{ $inbox->subject }}</td>
                                                <td>{{ $inbox->message }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center" role="alert">
                                You don't have the newest inbox today
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endcan

@endsection

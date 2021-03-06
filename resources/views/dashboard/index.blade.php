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
                    <a href="{{ route('posts.index') }}#posts" class="waves-effect">
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
                                        <p class="mb-0 text-muted">Postingan</p>
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
                    <a href="{{ route('categories.index') }}#posts" class="waves-effect">
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
                                        <p class="mb-0 text-muted">Kategori</p>
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
                    <a href="{{ route('tags.index') }}#posts" class="waves-effect">
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
                                        <p class="mb-0 text-muted">Tag</p>
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
                    <a href="{{ route('tutorials.index') }}#posts" class="waves-effect">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="col-3 align-self-center">
                                    <div class="round">
                                        <i class="uil uil-layer-group"></i>
                                    </div>
                                </div>
                                <div class="col-9 align-self-center text-center">
                                    <div class="m-l-10">
                                        <h5 class="mt-0 round-inner">{{ $countTutorial }}</h5>
                                        <p class="mb-0 text-muted">Tutorial</p>
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
                    <a href="{{ route('roles.index') }}#users" class="waves-effect">
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
                    <a href="{{ route('users.index') }}#users" class="waves-effect">
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
                    <a href="{{ route('contact.index') }}#contact" class="waves-effect">
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

            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <a href="{{ route('newsletter.index') }}#contact" class="waves-effect">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="col-3 align-self-center">
                                    <div class="round">
                                        <i class="uil uil-at"></i>
                                    </div>
                                </div>
                                <div class="col-9 align-self-center text-center">
                                    <div class="m-l-10">
                                        <h5 class="mt-0 round-inner">{{ $countNewsletter }}</h5>
                                        <p class="mb-0 text-muted">Pelanggan</p>
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
                    <div class="card-body">
                        Postingan hari ini
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
                        Sepertinya kamu belum membuat postingan dihari ini.
                        <a href="{{ route('posts.create') }}#posts">buat postingan?</a>
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
                    <div class="card-body">
                        Kategori hari ini
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
                        Tidak ada kategori yang dibuat hari ini
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
                        Tag hari ini
                    </div>
                    <div class="card-body">
                        @if ($tagToday->count() >= 1)
                            @foreach ($tagToday as $tag)
                                <span class="badge badge-pill badge-primary">{{ $tag->title }}</span>
                            @endforeach
                        @else
                            <div class="text-center" role="alert">
                                Tidak ada tag yang dibuat hari ini
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endcan

    {{-- CATEGORY TODAY --}}
    @can('manage_categories')
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        Tutorial hari ini
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @if ($tutorToday->count() >= 1)
                @foreach ($tutorToday as $tutor)
                    <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                        <div class="card m-b-30">
                            @if (file_exists('vendor/dashboard/image/thumbnail-tutorials/' . $tutor->thumbnail))
                                <img src="{{ asset('vendor/dashboard/image/thumbnail-tutorials/' . $tutor->thumbnail) }}"
                                    alt="{{ $tutor->title }}" class="card-img-top img-fluid">
                            @else
                                <img src="{{ asset('vendor/blog/img/default.png') }}" alt="{{ $tutor->title }}"
                                    class="card-img-top img-fluid">
                            @endif

                            <div class="card-body">
                                <h5 class="card-title font-20 mt-0">{{ $tutor->title }}</h5>
                                <p class="card-text">{{ substr($tutor->description, 0, 150) }}...</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="text-center m-b-30" role="alert">
                        Tidak ada tutorial yang dibuat hari ini
                    </div>
                </div>
            @endif
        </div>
        @if ($tutorToday->count() >= 1)
            <div class="row">
                <div class="col-12 m-b-30">
                    @if ($tutorToday->hasPages())
                        {{ $tutorToday->links('vendor.pagination.bootstrap-4') }}
                    @endif
                </div>
            </div>
        @endif
    @endcan

    {{-- USER TODAY --}}
    @can('manage_users')
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        Pengguna yang mendaftar hari ini
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
                                                <td>{{ $user->email ?? '(anonymous)' }}</td>
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
                                Belum ada yang mendaftar hari ini
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
                        Role hari ini
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
                                Tidak ada role yang dibuat hari ini
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
                        Pesan masuk hari ini
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
                                Belum ada pesan yang masuk hari ini
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        Langganan website hari ini
                    </div>
                    <div class="card-body">
                        @if ($newsletterToday->count() >= 1)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($newsletterToday as $nl)
                                            <tr class="text-center">
                                                <td>{{ $nl->email }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center" role="alert">
                                Belum ada yang berlangganan hari ini
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endcan

@endsection

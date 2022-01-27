@extends('layouts.dashboard')

@section('title')
    Dashboard
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('dashboard') }}
@endsection

@section('content')

    <div class="row">

        <div class="col-md-6 col-lg-6 col-xl-3">
            <div class="card m-b-30">
                <a href="{{ route('posts.index') }}" class="waves-effect">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="col-3 align-self-center">
                                <div class="round">
                                    <i class="uil uil-files-landscapes-alt"></i>
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
        <div class="col-md-6 col-lg-6 col-xl-3">
            <div class="card m-b-30">
                <a href="{{ route('roles.index') }}" class="waves-effect">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="col-3 align-self-center">
                                <div class="round">
                                    <i class="uil uil-user-check"></i>
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
    </div>

@endsection

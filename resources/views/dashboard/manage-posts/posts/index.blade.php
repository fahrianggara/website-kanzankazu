@extends('layouts.dashboard')

@section('title')
    Posts Article
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('posts') }}
@endsection

@section('content')
    {{-- Alert success --}}
    <div class="notif-success" data-notif="{{ Session::get('success') }}"></div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <div class="row">

                        <div class="col-md-6">
                            <form action="" method="GET" class="form-inline form-row">
                                <div class="col-6">
                                    <div class="input-group mx-1">
                                        <select id="statusPost" name="status" class="custom-select"
                                            style="border-radius: 4px">
                                            <option value="publish"
                                                {{ $statusSelected == 'publish' ? 'selected' : null }}>
                                                Publish
                                            </option>
                                            <option value="draft" {{ $statusSelected == 'draft' ? 'selected' : null }}>
                                                Draft
                                            </option>
                                            @if (!Auth::user()->editorRole())
                                                <option value="approve"
                                                    {{ $statusSelected == 'approve' ? 'selected' : null }}>
                                                    Approve
                                                </option>
                                            @endif
                                        </select>
                                        <div class="">
                                            <button id="submitStatus" class="btn btn-primary d-none"
                                                type="submit">Apply</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group mx-1">
                                        <input name="keyword" type="search" value="{{ request()->get('keyword') }}"
                                            class="form-control" placeholder="Search post...">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="uil uil-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @can('post_create')
                            <div class="col-md-6">
                                <a href="{{ route('posts.create') }}" class="btn btn-primary float-right"><i
                                        class="uil uil-plus "></i></a>

                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse ($posts as $post)
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
                            <p class="card-text">{{ substr($post->description, 0, 100) }}...</p>
                            {{-- detail --}}
                            @can('post_detail')
                                <a href="{{ route('posts.show', ['post' => $post]) }}"
                                    class="btn btn-primary btn-sm waves-effect waves-light"><i class="uil uil-eye"></i></a>
                            @endcan
                            @if ($post->user_id == Auth::user()->id)
                                {{-- edit --}}
                                @can('post_update')
                                    <a href="{{ route('posts.edit', ['post' => $post]) }}"
                                        class="btn btn-warning btn-sm waves-effect waves-light"><i
                                            class="uil uil-pen"></i></a>
                                @endcan

                                @can('post_delete')
                                    {{-- delete --}}
                                    <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST"
                                        class="d-inline" role="alertDelete"
                                        alert-text="Are you sure you want to delete the {{ $post->title }} post?">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm waves-effect waves-light">
                                            <i class="uil uil-trash"></i>
                                        </button>
                                    </form>
                                @endcan

                                @if ($post->status == 'publish')
                                    <form action="{{ route('posts.draft', ['post' => $post]) }}" method="POST"
                                        class="d-inline" role="alertPublish"
                                        alert-text="Are you sure you want to archive the {{ $post->title }} post?"
                                        alert-button="Archive">
                                        @csrf
                                        @method('PUT')

                                        <button type="submit" title="Draft"
                                            class="float-right btn btn-secondary btn-sm waves-effect waves-light">
                                            <i class="uil uil-archive"></i>
                                        </button>
                                    </form>
                                @elseif ($post->status == 'draft')
                                    <form action="{{ route('posts.publish', ['post' => $post]) }}" method="POST"
                                        class="d-inline" role="alertPublish"
                                        alert-text="Are you sure you want to publish the {{ $post->title }} post?"
                                        alert-button="Publish">
                                        @csrf
                                        @method('PUT')

                                        <button type="submit" title="Publish"
                                            class="float-right btn btn-secondary btn-sm waves-effect waves-light">
                                            <i class="uil uil-upload-alt"></i>
                                        </button>
                                    </form>
                                @endif
                            @endif

                            @if ($post->status == 'approve')
                                @if (!Auth::user()->editorRole())
                                    <form action="{{ route('posts.approval', ['post' => $post]) }}" method="POST"
                                        class="d-inline" role="alertPublish" alert-button="Approve"
                                        alert-text="Are you sure you want to approve the {{ $post->title }} post?">
                                        @csrf
                                        @method('PUT')

                                        <button type="submit"
                                            class="float-right btn btn-success btn-sm waves-effect waves-light">
                                            <i class="uil uil-upload"></i>
                                        </button>
                                    </form>
                                @endif
                            @endif

                        </div>
                    </div>
                </div>
            @empty
                <b class="ml-5">
                    @if (request()->get('keyword'))
                        Oops.. {{ strtoupper(request()->get('keyword')) }} post not found :(
                    @else
                        No posts data yet
                    @endif
                </b>
            @endforelse
        </div>

        @if ($posts->hasPages())
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-footer">
                        {{ $posts->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('js-internal')
    <script>
        // NOTIF SUCCESS
        const notif = $('.notif-success').data('notif');
        if (notif) {
            alertify
                .delay(3500)
                .log(notif);
        }

        $(document).ready(function() {
            // status post
            $('#statusPost').on('change', function() {
                $('#submitStatus').click();
            });

            $("form[role='alertDelete']").submit(function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "Warning",
                    text: $(this).attr('alert-text'),
                    icon: "warning",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    cancelButtonText: "Cancel",
                    confirmButtonText: "Delete",
                    confirmButtonColor: '#d33',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.target.submit();
                    }
                });
            });

            $("form[role='alertPublish']").submit(function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "Warning",
                    text: $(this).attr('alert-text'),
                    icon: "warning",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    cancelButtonText: "Cancel",
                    confirmButtonText: $(this).attr('alert-button'),
                    confirmButtonColor: '#00829b',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.target.submit();
                    }
                });
            });
        });
    </script>
@endpush

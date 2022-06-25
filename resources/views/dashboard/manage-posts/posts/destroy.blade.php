@extends('layouts.dashboard')

@section('title')
    Posts Delete
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('deleted_posts') }}
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <div class="row">

                        <div class="col-md-6">
                            <form action="" method="GET" class="form-inline form-row">
                                {{-- SEARCH --}}
                                <div class="col">
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

                        <div class="col-md-6">
                            <a href="{{ route('posts.index') }}#posts" class="btn btn-primary float-right"><i
                                    class="uil uil-arrow-left mr-1"></i>Back
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse ($posts as $post)
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="card m-b-30">
                        <img class="card-img-top img-fluid" src="{{ asset($post->thumbnail) }}"
                            alt="{{ $post->title }}">
                        <div class="card-body">
                            <h5 class="card-title font-20 mt-0">{{ $post->title }} | <i class="uil uil-eye"></i>
                                {{ $post->views }}</h5>
                            <p class="card-text">{{ substr($post->description, 0, 100) }}...</p>

                            {{-- restore --}}
                            <form action="{{ route('posts.restore', $post->id) }}" method="POST" class="d-inline"
                                role="alertRestore"
                                alert-text="Are you sure you want to restore the {{ $post->title }} post?">
                                @csrf

                                <button type="submit" class="btn btn-info btn-sm waves-effect waves-light"
                                    alt="Restore {{ $post->title }}">
                                    <i class="uil uil-history"></i>
                                </button>
                            </form>
                            {{-- <a href="{{ route('posts.restore', $post->id) }}"
                                class="btn btn-primary btn-sm waves-effect waves-light" alt="Restore {{ $post->title }}"
                                role="alertRestore"
                                alert-text="Are you sure you want to restore the {{ $post->title }} post?">
                                <i class="uil uil-history"></i>
                            </a> --}}


                            {{-- delete --}}
                            <form action="" method="POST" class="d-inline" role="alertDelete"
                                alert-text="Are you sure you want to delete the {{ $post->title }} post?">
                                @csrf
                                @method('DELETE')


                                <button type="submit" class="btn btn-danger btn-sm waves-effect waves-light"
                                    alt="Delete {{ $post->title }}">
                                    <i class="uil uil-trash"></i>
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            @empty
                <b class="ml-5">
                    @if (request()->get('keyword'))
                        Oops.. {{ strtoupper(request()->get('keyword')) }} deleted posts not found :(
                    @else
                        No deleted posts data yet
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
        $(document).ready(function() {
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
        });

        $(document).ready(function() {
            $("form[role='alertRestore']").submit(function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "Info",
                    text: $(this).attr('alert-text'),
                    icon: "info",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    cancelButtonText: "Cancel",
                    confirmButtonText: "Restore",
                    confirmButtonColor: '#1E90FF',
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

@extends('layouts.dashboard')

@section('title')
    Postingan
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('posts') }}
@endsection

@section('content')
    {{-- Alert success --}}
    <div class="notif-success" data-notif="{{ Session::get('success') }}"></div>

    <div class="row">

        <div class="col-12 m-b-20">
            <form action="#posts" method="GET" class="">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-2 col-3">
                                        @can('post_create')
                                            <a href="{{ route('posts.create') }}#posts" class="btn btn-primary"
                                                data-toggle="tooltip" data-placement="bottom" title="Buat">
                                                <i class="uil uil-plus"></i>
                                            </a>
                                        @endcan
                                    </div>
                                    <div class="col-lg-10 col-9">
                                        <div class="input-group mx-1">
                                            <select id="statusPost" name="status" class="custom-select"
                                                style="border-radius: 4px" data-toggle="tooltip" data-placement="bottom"
                                                title="Status">
                                                <option value="publish"
                                                    {{ $statusSelected == 'publish' ? 'selected' : null }}>
                                                    Publik ({{ $publishPostCount }})
                                                </option>
                                                <option value="draft"
                                                    {{ $statusSelected == 'draft' ? 'selected' : null }}>
                                                    Arsip ({{ $draftPostCount }})
                                                </option>
                                                @if (!Auth::user()->editorRole())
                                                    <option value="approve"
                                                        {{ $statusSelected == 'approve' ? 'selected' : null }}>
                                                        Persetujuan ({{ $approvePostCount }})
                                                    </option>
                                                @endif
                                            </select>

                                            <button id="submitStatus" class="btn btn-primary d-none" type="submit">Apply
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">

                                <div class="col-12">
                                    <div class="input-group mx-1">
                                        <input autocomplete="off" name="keyword" type="search"
                                            value="{{ request()->get('keyword') }}" class="form-control"
                                            placeholder="Cari postingan kamu..">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit" data-toggle="tooltip"
                                                data-placement="bottom" title="Telusuri">
                                                <i class="uil uil-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if ($posts->count() >= 1)
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                        <div class="card m-b-30">
                            @if (file_exists('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail))
                                @foreach ($post->tutorials as $tutorial)
                                    <div class="ribbon-wrapper ribbon-lg">
                                        <div class="ribbon" style="background: {{ $tutorial->bg_color }}">
                                            {{ $tutorial->title }}
                                        </div>
                                    </div>
                                @endforeach

                                <img src="{{ asset('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail) }}"
                                    alt="{{ $post->title }}" class="card-img-top img-fluid">

                                @include('dashboard.manage-posts.posts.sub-post.menu')
                            @else
                                @foreach ($post->tutorials as $tutorial)
                                    <div class="ribbon-wrapper ribbon-lg">
                                        <div class="ribbon" style="background: {{ $tutorial->bg_color }}; ">
                                            {{ $tutorial->title }}
                                        </div>
                                    </div>
                                @endforeach

                                <img src="{{ asset('vendor/blog/img/default.png') }}" alt="{{ $post->title }}"
                                    class="card-img-top img-fluid">

                                @include('dashboard.manage-posts.posts.sub-post.menu')
                            @endif

                            <div class="card-body">
                                {{-- text --}}
                                <h5 class="card-title font-20 mt-0">
                                    @if ($post->recommendedPost)
                                        <i class="fas fa-star mr-2 text-warning"></i>
                                    @endif
                                    @if ($post->title == null)
                                        {{ $post->slug }}
                                    @else
                                        {{ $post->title }}
                                    @endif
                                </h5>

                                @if (strlen($post->description) > 100)
                                    <p class="card-text">{{ substr($post->description, 0, 100) }}...</p>
                                @else
                                    <p class="card-text">{{ $post->description }}</p>
                                @endif

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div id="noPost" class="col-lg-12">
                <div class="noPost">
                    @if (request()->get('keyword'))
                        <i class="uil uil-search"></i>
                        <h5 class="m-t-10">
                            Oops.. sepertinya postingan kamu dengan kata kunci
                            <span class="active">{{ strtoupper(request()->get('keyword')) }}</span>
                            tidak ditemukan.
                        </h5>
                    @elseif (request()->get('status') == 'publish')
                        <i class="uil uil-plus-circle"></i>
                        <h5 class="m-t-10">
                            Hmm.. sepertinya postingan kamu belum dibuat.
                            <a href="{{ route('posts.create') }}#posts">Buat?</a>
                        </h5>
                    @elseif (request()->get('status') == 'draft')
                        <i class="uil uil-archive"></i>
                        <h5 class="m-t-10">
                            Hmm.. kelihatannya postingan kamu belum ada yang diarsip.
                        </h5>
                    @elseif (request()->get('status') == 'approve')
                        <i class="uil uil-users-alt"></i>
                        <h5 class="m-t-10">
                            Hmm.. kelihatannya pengguna belum ada yang buat
                            postingan..
                        </h5>
                    @else
                        <i class="uil uil-plus-circle"></i>
                        <h5 class="m-t-10">
                            Hmm.. sepertinya postingan kamu belum dibuat.
                            <a href="{{ route('posts.create') }}#posts">Buat?</a>
                        </h5>
                    @endif

                </div>
            </div>
            {{-- <b class="text-center">
                @if (request()->get('keyword'))
                    Oops.. sepertinya postingan kamu dengan kata kunci
                    {{ strtoupper(request()->get('keyword')) }}
                    tidak ditemukan.
                @elseif (request()->get('status') == 'publish')
                    Hmm.. sepertinya postingan kamu belum dibuat.
                    <a href="{{ route('posts.create') }}#posts">Buat?</a>
                @elseif (request()->get('status') == 'draft')
                    Hmm.. kelihatannya postingan kamu belum ada yang diarsip.
                @elseif (request()->get('status') == 'approve')
                    Hmm.. kelihatannya pengguna belum ada yang buat
                    postingan..
                @else
                    Hmm.. sepertinya postingan kamu belum dibuat.
                    <a href="{{ route('posts.create') }}#posts">Buat?</a>
                @endif
            </b> --}}
        @endif


        @if ($posts->hasPages())
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
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
                    cancelButtonText: "Ga, batalkan!",
                    confirmButtonText: "Ya, hapus!",
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
                    cancelButtonText: "Gajadi",
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

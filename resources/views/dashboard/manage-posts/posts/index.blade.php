@extends('layouts.dashboard')

@section('title')
    Postingan
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('posts') }}
@endsection

@section('content')
    {{-- Alert success --}}
    <div class="notif-success" data-notif="{{ Session::get('success') }}">
    </div>

    <div class="row">

        <div class="col-12 m-b-20">
            <form action="" method="GET" class="">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-2 col-3">
                                        @can('post_create')
                                            <a href="{{ route('posts.create') }}" class="btn btn-primary"
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
                                                    Publik
                                                </option>
                                                <option value="draft"
                                                    {{ $statusSelected == 'draft' ? 'selected' : null }}>
                                                    Arsip
                                                </option>
                                                @if (!Auth::user()->editorRole())
                                                    <option value="approve"
                                                        {{ $statusSelected == 'approve' ? 'selected' : null }}>
                                                        Persetujuan
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
                            <div class="card-header">

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

        <div class="row">
            @if ($posts->count() >= 1)
                @foreach ($posts as $post)
                    <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                        <div class="card m-b-30">
                            @if (file_exists('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail))
                                @foreach ($post->tutorials as $tutorial)
                                    <div class="ribbon-wrapper ribbon-lg">
                                        <div class="ribbon" style="background: {{$tutorial->bg_color}}">
                                            {{ $tutorial->title }}
                                        </div>
                                    </div>
                                @endforeach

                                <img src="{{ asset('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail) }}"
                                    alt="{{ $post->title }}" class="card-img-top img-fluid">
                            @else
                                @foreach ($post->tutorials as $tutorial)
                                    <div class="ribbon-wrapper ribbon-lg">
                                        <div class="ribbon" style="background: {{$tutorial->bg_color}}">
                                            {{ $tutorial->title }}
                                        </div>
                                    </div>
                                @endforeach

                                <img src="{{ asset('vendor/blog/img/default.png') }}" alt="{{ $post->title }}"
                                    class="card-img-top img-fluid">
                            @endif
                            <div class="card-body">
                                {{-- text --}}
                                <h5 class="card-title font-20 mt-0">{{ $post->title }} @if ($post->recommendedPost)
                                        (Rekomendasi)
                                    @endif
                                </h5>
                                <p class="card-text">{{ substr($post->description, 0, 100) }}...</p>

                                {{-- detail --}}
                                @can('post_detail')
                                    @if (($post->title != null && $post->description != null) || $cateOld != null)
                                        <a href="{{ route('posts.show', ['slug' => $post->slug]) }}"
                                            class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="tooltip"
                                            data-placement="bottom" title="Lihat">
                                            <i class="uil uil-eye"></i>
                                        </a>
                                    @endif
                                @endcan
                                @if ($post->user_id == Auth::user()->id)
                                    {{-- edit --}}
                                    @can('post_update')
                                        <a href="{{ route('posts.edit', ['slug' => $post->slug]) }}"
                                            class="btn btn-warning btn-sm waves-effect waves-light" data-toggle="tooltip"
                                            data-placement="bottom" title="Edit">
                                            <i class="uil uil-pen"></i>
                                        </a>
                                    @endcan

                                    @can('post_delete')
                                        {{-- delete --}}
                                        <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST"
                                            class="d-inline" role="alertDelete"
                                            alert-text='Hmm.. apakah kamu yakin? postingan kamu dengan judul @if ($post->title == null) "{{ $post->slug }}" @else "{{ $post->title }}" @endif akan dihapus permanen?'>
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm waves-effect waves-light"
                                                data-toggle="tooltip" data-placement="bottom" title="Hapus">
                                                <i class="uil uil-trash"></i>
                                            </button>
                                        </form>
                                    @endcan

                                    @if ($post->status == 'publish')
                                        {{-- DRAFT --}}
                                        @if (($post->title != null && $post->description != null) || $cateOld != null)
                                            <form action="{{ route('posts.draft', ['post' => $post]) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')

                                                <button type="submit" data-toggle="tooltip" data-placement="bottom"
                                                    title="Arsip"
                                                    class="float-right btn btn-secondary btn-sm waves-effect waves-light">
                                                    <i class="uil uil-archive"></i>
                                                </button>
                                            </form>
                                        @endif

                                        {{-- RECOMMENDED --}}
                                        @if (($post->title != null && $post->description != null) || $cateOld != null)
                                            <form action="{{ route('posts.recommend', ['id' => $post->id]) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('POST')

                                                <button type="submit" data-toggle="tooltip" data-placement="bottom"
                                                    title="{{ $post->recommendedPost ? 'Rekomendasi' : 'Rekomendasikan' }}"
                                                    class="float-right mr-1 btn btn-gold btn-sm waves-effect waves-light">
                                                    <i
                                                        class="{{ $post->recommendedPost ? 'fas fa-star' : 'far fa-star' }}"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @elseif ($post->status == 'draft')
                                        {{-- PUBLISH --}}
                                        @if (($post->title != null && $post->description != null) || $cateOld != null)
                                            <form action="{{ route('posts.publish', ['post' => $post]) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')

                                                <button type="submit" data-toggle="tooltip" data-placement="bottom"
                                                    title="Publik"
                                                    class="float-right btn btn-secondary btn-sm waves-effect waves-light">
                                                    <i class="uil uil-upload-alt"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if (($post->title != null && $post->description != null) || $cateOld != null)
                                            <form action="{{ route('posts.recommend', ['id' => $post->id]) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('POST')

                                                <button type="submit" data-toggle="tooltip" data-placement="bottom"
                                                    title="{{ $post->recommendedPost ? 'Rekomendasi' : 'Rekomendasikan' }}"
                                                    class="float-right mr-1 btn btn-warning btn-sm waves-effect waves-light">
                                                    <i
                                                        class="{{ $post->recommendedPost ? 'fas fa-star' : 'far fa-star' }}"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                @endif

                                @if ($post->status == 'approve')
                                    @if (!Auth::user()->editorRole())
                                        <form action="{{ route('posts.approval', ['post' => $post]) }}" method="POST"
                                            class="d-inline" role="alertPublish" alert-button="Ya Setuju"
                                            alert-text="Apakah kamu ingin mensetujui postingan {{ $post->title }}?">
                                            @csrf
                                            @method('PUT')

                                            <button type="submit" data-toggle="tooltip" data-placement="bottom"
                                                title="Setujui"
                                                class="float-right btn btn-success btn-sm waves-effect waves-light">
                                                <i class="uil uil-check-circle"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endif

                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <b>
                                @if (request()->get('keyword'))
                                    Oops.. sepertinya postingan kamu dengan kata kunci
                                    {{ strtoupper(request()->get('keyword')) }}
                                    tidak ditemukan.
                                @elseif (request()->get('status') == 'publish')
                                    Hmm.. sepertinya postingan kamu belum dibuat.
                                    <a href="{{ route('posts.create') }}">Buat?</a>
                                @elseif (request()->get('status') == 'draft')
                                    Hmm.. kelihatannya postingan kamu belum ada yang diarsip.
                                @elseif (request()->get('status') == 'approve')
                                    Hmm.. kelihatannya pengguna belum ada yang buat
                                    postingan..
                                @else
                                    Hmm.. sepertinya postingan kamu belum dibuat.
                                    <a href="{{ route('posts.create') }}">Buat?</a>
                                @endif
                            </b>
                        </div>
                    </div>
                </div>
            @endif
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

        setTimeout(() => {
            history.replaceState('', document.title, window.location.origin + window
                .location.pathname + window
                .location.search);
        }, 0);

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

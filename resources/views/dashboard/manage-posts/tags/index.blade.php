@extends('layouts.dashboard')

@section('title')
    Tag postingan
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('tags') }}
@endsection

@section('content')
    {{-- Alert success --}}
    <div class="notif-success" data-notif="{{ Session::get('success') }}"></div>

    <div class="row">
        <div class="col-12">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-1 col-3">
                                    @can('tag_create')
                                        <a href="{{ route('tags.create') }}#posts" class="btn btn-primary float-right"
                                            data-toggle="tooltip" data-placement="bottom" title="Buat">
                                            <i class="uil uil-plus"></i>
                                        </a>
                                    @endcan
                                </div>
                                <div class="col-lg-11 col-9">
                                    <form action="{{ route('tags.index') }}#posts" method="GET">
                                        <div class="input-group">
                                            <input autocomplete="off" type="search" id="keyword" name="keyword"
                                                class="form-control" placeholder="Cari tag.."
                                                value="{{ request()->get('keyword') }}">

                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit" data-toggle="tooltip"
                                                    data-placement="bottom" title="Telusuri">
                                                    <i class="uil uil-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card m-b-30">
                <div class="table-responsive">
                    @if (count($tags) >= 1)
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Nama Tag</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($tags as $tag)
                                    <tr class="text-center">
                                        <td>{{ $tags->perPage() * ($tags->currentPage() - 1) + $no }}
                                        </td>
                                        @php $no++; @endphp
                                        <td>{{ $tag->title }}</td>
                                        <td>
                                            @can('tag_update')
                                                <a href="{{ route('tags.edit', ['tag' => $tag]) }}#posts"
                                                    class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="bottom"
                                                    title="Edit">
                                                    <i class="uil uil-pen"></i>
                                                </a>
                                            @endcan
                                            @can('tag_delete')
                                                <form action="{{ route('tags.destroy', ['tag' => $tag]) }}#posts" method="POST"
                                                    class="d-inline" role="alert"
                                                    alert-text="Apakah kamu yakin? tag {{ $tag->title }} akan dihapus permanen?">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip"
                                                        data-placement="bottom" title="Hapus">
                                                        <i class="uil uil-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="card-body">
                            <div class="text-center">
                                <p class="card-text">
                                    <b>
                                        @if (request()->get('keyword'))
                                            Oops.. sepertinya tag {{ strtoupper(request()->get('keyword')) }}
                                            tidak ditemukan.
                                        @else
                                            Hmm.. sepertinya belum ada tag yang dibuat. <a
                                                href="{{ route('tags.create') }}#posts">Buat?</a>
                                        @endif
                                    </b>
                                </p>
                            </div>
                        </div>
                    @endif
                    @if ($tags->hasPages())
                        <div class="card-footer">
                            <div class="page-footer">
                                {{ $tags->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
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
            $("form[role='alert']").submit(function(e) {
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
        });
    </script>
@endpush

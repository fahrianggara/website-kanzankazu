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
            <div class="card m-b-30">
                <div class="card-header">

                    <form action="{{ route('tags.index') }}" method="GET" class="float-left">
                        <div class="input-group">
                            <input autocomplete="off" type="search" id="keyword" name="keyword" class="form-control"
                                placeholder="Cari tag.." value="{{ request()->get('keyword') }}">
                            {{-- buton submit --}}
                            <div class="input-group-append">
                                <button class="btn btn-info" type="submit" data-toggle="tooltip" data-placement="bottom"
                                    title="Telusuri">
                                    <i class="uil uil-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    @can('tag_create')
                        {{-- button create --}}
                        <a href="{{ route('tags.create') }}" class="btn btn-primary float-right" data-toggle="tooltip"
                            data-placement="bottom" title="Buat">
                            <i class="uil uil-plus"></i>
                        </a>
                    @endcan

                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">

                        @if (count($tags) >= 1)
                            @foreach ($tags as $tag)
                                <li
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center pr-0">

                                    <label class="mt-auto mb-auto">
                                        {{ $tag->title }}
                                    </label>

                                    <div>
                                        @can('tag_update')
                                            {{-- EDIT --}}
                                            <a href="{{ route('tags.edit', ['tag' => $tag]) }}" class="btn btn-warning btn-sm"
                                                data-toggle="tooltip" data-placement="bottom" title="Edit">
                                                <i class="uil uil-pen"></i>
                                            </a>
                                        @endcan
                                        @can('tag_delete')
                                            {{-- DELETE --}}
                                            <form action="{{ route('tags.destroy', ['tag' => $tag]) }}" method="POST"
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
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <b>
                                @if (request()->get('keyword'))
                                    Oops.. sepertinya tag {{ strtoupper(request()->get('keyword')) }}
                                    tidak ditemukan.
                                @else
                                    Hmm.. sepertinya belum ada tag yang dibuat. <a
                                        href="{{ route('tags.create') }}">Buat?</a>
                                @endif
                            </b>
                        @endif

                    </ul>
                </div>
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

@extends('layouts.dashboard')

@section('title')
    Tutorial
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('tutorials') }}
@endsection

@section('content')
    {{-- Alert success --}}
    <div class="notif-success" data-notif="{{ Session::get('success') }}"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <form action="{{ route('tutorials.index') }}" method="GET" class="float-left">
                        <div class="input-group">
                            <input autocomplete="off" type="search" id="keyword" name="keyword" class="form-control"
                                placeholder="Cari tutorial.." value="{{ request()->get('keyword') }}" autocomplete="off">
                            {{-- buton submit --}}
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" data-toggle="tooltip" data-placement="bottom"
                                    title="Telusuri">
                                    <i class="uil uil-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    @can('category_create')
                        {{-- button create --}}
                        <a href="{{ route('tutorials.create') }}" class="btn btn-primary float-right" data-toggle="tooltip"
                            data-placement="bottom" title="Buat">
                            <i class="uil uil-plus"></i>
                        </a>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            @if ($tutorials->count() > 0)
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Tutorial</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tutorials as $tutorial)
                                        <tr class="text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $tutorial->title }}</td>
                                            <td>
                                                <a href="{{ route('tutorials.edit', ['tutorial' => $tutorial]) }}"
                                                    class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                    data-placement="bottom" title="Edit">
                                                    <i class="uil uil-pen"></i>
                                                </a>

                                                <form action="{{ route('tutorials.destroy', ['tutorial' => $tutorial]) }}"
                                                    class="d-inline" role="alert" method="POST"
                                                    alert-text="Apakah kamu yakin? tutorial {{ $tutorial->title }} akan dihapus permanen?">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        data-toggle="tooltip" data-placement="bottom" title="Hapus">
                                                        <i class="uil uil-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <b>
                                        @if (request()->get('keyword'))
                                            Oops.. sepertinya tutorial dengan title
                                            {{ strtoupper(request()->get('keyword')) }} tidak ditemukan.
                                        @else
                                            Hmm.. sepertinya tutorial belum dibuat. <a
                                                href="{{ route('tutorials.create') }}">Buat?</a>
                                        @endif
                                    </b>
                                </tbody>
                            @endif
                        </table>
                    </div>
                </div>
                @if ($tutorials->hasPages())
                    <div class="card-footer">
                        <div class="page-footer">
                            {{ $tutorials->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection

@push('js-internal')
    <script>
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

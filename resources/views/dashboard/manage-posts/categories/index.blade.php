@extends('layouts.dashboard')

@section('title')
    Kategori postingan
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('categories') }}
@endsection

@section('content')

    {{-- Alert success --}}
    <div class="notif-success" data-notif="{{ Session::get('success') }}"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="card m-b-30">

                <div class="card-header">

                    <form action="{{ route('categories.index') }}" method="GET" class="float-left">
                        <div class="input-group">
                            <input autocomplete="off" type="search" id="keyword" name="keyword" class="form-control"
                                placeholder="Cari kategori.." value="{{ request()->get('keyword') }}" autocomplete="off">
                            {{-- buton submit --}}
                            <div class="input-group-append">
                                <button class="btn btn-info" type="submit" data-toggle="tooltip" data-placement="bottom"
                                    title="Telusuri">
                                    <i class="uil uil-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    @can('category_create')
                        {{-- button create --}}
                        <a href="{{ route('categories.create') }}" class="btn btn-primary float-right" data-toggle="tooltip"
                            data-placement="bottom" title="Buat">
                            <i class="uil uil-plus"></i>
                        </a>
                    @endcan
                </div>

                <div class="card-body">

                    <ul class="list-group list-group-flush">
                        @if (count($categories))
                            @include('dashboard.manage-posts.categories.categories-list', [
                                'categories' => $categories,
                                'count' => 0,
                            ])
                        @else
                            <b>
                                @if (request()->get('keyword'))
                                    {{-- Oops.. {{ strtoupper(request()->get('keyword')) }} category not found :( --}}
                                    Oops.. sepertinya kategori {{ strtoupper(request()->get('keyword')) }}
                                    tidak ditemukan.
                                @else
                                    Hmm.. sepertinya belum ada kategori yang dibuat. <a
                                        href="{{ route('categories.create') }}">Buat?</a>
                                @endif
                            </b>
                        @endif
                    </ul>

                </div>

                @if ($categories->hasPages())
                    <div class="card-footer">
                        <div class="page-footer">
                            {{ $categories->links('vendor.pagination.bootstrap-4') }}
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

        // SWAL
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

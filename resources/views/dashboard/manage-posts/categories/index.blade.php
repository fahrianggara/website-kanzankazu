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
        <div class="col-12">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-1 col-3">
                                    @can('category_create')
                                        <a href="{{ route('categories.create') }}" class="btn btn-primary"
                                            data-toggle="tooltip" data-placement="bottom" title="Buat">
                                            <i class="uil uil-plus"></i>
                                        </a>
                                    @endcan
                                </div>
                                <div class="col-lg-11 col-9">
                                    <form action="{{ route('categories.index') }}" method="GET">
                                        <div class="input-group">
                                            <input autocomplete="off" type="search" id="keyword" name="keyword"
                                                class="form-control" placeholder="Cari kategori.."
                                                value="{{ request()->get('keyword') }}" autocomplete="off">

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
                    @if (count($categories) >= 1)
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama Kategori</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($categories as $category)
                                    <tr class="text-center">
                                        <td>{{ $categories->perPage() * ($categories->currentPage() - 1) + $no }}
                                        </td>
                                        @php $no++; @endphp
                                        <td>{{ $category->title }}</td>
                                        <td>
                                            @can('category_update')
                                                <a href="{{ route('categories.edit', ['category' => $category]) }}"
                                                    class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="bottom"
                                                    title="Edit">
                                                    <i class="uil uil-pen"></i>
                                                </a>
                                            @endcan
                                            @can('category_delete')
                                                <form action="{{ route('categories.destroy', ['category' => $category]) }}"
                                                    class="d-inline" role="alert" method="POST"
                                                    alert-text="Apakah kamu yakin? kategori {{ $category->title }} akan dihapus permanen?">
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
                                            Oops.. sepertinya kategori dengan title
                                            {{ strtoupper(request()->get('keyword')) }} tidak ditemukan.
                                        @else
                                            Hmm.. sepertinya kategori belum dibuat. <a
                                                href="{{ route('categories.create') }}">Buat?</a>
                                        @endif
                                    </b>
                                </p>
                            </div>
                        </div>
                    @endif

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

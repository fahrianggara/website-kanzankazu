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
                                        <a href="{{ route('categories.create') }}#posts" class="btn btn-primary"
                                            data-toggle="tooltip" data-placement="bottom" title="Buat">
                                            <i class="uil uil-plus"></i>
                                        </a>
                                    @endcan
                                </div>
                                <div class="col-lg-11 col-9">
                                    <form action="{{ route('categories.index') }}#posts" method="GET">
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
            <div class="card card-body m-b-30 table-responsive shadow-sm table-wrapper">
                @if (count($categories) >= 1)
                    <table class="table table-hover align-items-center overflow-hidden">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>
                                        <a href="javascript:void(0)" class="d-flex align-items-center"
                                            style="cursor: default">
                                            @if (file_exists('vendor/dashboard/image/thumbnail-categories/' . $category->thumbnail))
                                                <img src="{{ asset('vendor/dashboard/image/thumbnail-categories/' . $category->thumbnail) }}"
                                                    width="60" class="avatar me-3">
                                            @else
                                                <img src="{{ asset('vendor/blog/img/default.png') }}" width="60"
                                                    class="avatar me-3">
                                            @endif
                                            <div class="d-block ml-3">
                                                <span class="fw-bold name-user">{{ $category->title }}</span>
                                                <div class="small text-secondary">
                                                    {{ substr($category->description, 0, 20) }}...
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="btn-group dropleft">
                                            <button
                                                class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="uil uil-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mb-4 py-1">
                                                @can('category_update')
                                                    <a href="{{ route('categories.edit', ['category' => $category]) }}#posts"
                                                        class="dropdown-item d-flex align-items-center ">
                                                        <i class="uil uil-pen text-warning"></i>
                                                        <span class="ml-2">Edit Kategori</span>
                                                    </a>
                                                @endcan
                                                @can('category_delete')
                                                    <form
                                                        action="{{ route('categories.destroy', ['category' => $category]) }}#posts"
                                                        class="d-inline" role="alert" method="POST"
                                                        alert-text="Apakah kamu yakin? kategori {{ $category->title }} akan dihapus permanen?">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="dropdown-item d-flex align-items-center ">
                                                            <i class="uil uil-trash text-danger"></i>
                                                            <span class="ml-2">Hapus Kategori</span>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </div>
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
                                            href="{{ route('categories.create') }}#posts">Buat?</a>
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

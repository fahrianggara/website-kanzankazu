@extends('layouts.dashboard')

@section('title')
    Role
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('roles') }}
@endsection

@section('content')
    {{-- Alert success --}}
    <div class="notif-success" data-notif="{{ Session::get('success') }}"></div>

    <div class="row">
        <div class="col-12">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-1 col-3">
                                    @can('role_create')
                                        <a href="{{ route('roles.create') }}#roles" class="btn btn-primary float-right"
                                            data-toggle="tooltip" data-placement="bottom" title="Buat">
                                            <i class="uil uil-plus"></i>
                                        </a>
                                    @endcan
                                </div>
                                <div class="col-lg-11 col-9">
                                    <form action="{{ route('roles.index') }}#roles" method="GET">
                                        <div class="input-group">
                                            <input autocomplete="off" type="search" id="keyword" name="keyword"
                                                class="form-control" placeholder="Cari role.."
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
                <div class=" card-body table-responsive shadow-sm table-wrapper">
                    @if ($roles->count() >= 1)
                        <table class="table table-hover align-items-center overflow-hidden">
                            <thead>
                                <tr>
                                    <th>Role name</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td class="name-user">{{ $role->name }}</td>
                                        <td>
                                            <div class="btn-group dropleft">
                                                <button
                                                    class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="uil uil-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mb-4 py-1">

                                                    @can('role_detail')
                                                        <a href="{{ route('roles.show', ['role' => $role]) }}#roles"
                                                            class="dropdown-item d-flex align-items-center">
                                                            <i class="uil uil-eye text-primary"></i>
                                                            <span class="ml-2">Lihat role</span>
                                                        </a>
                                                    @endcan

                                                    @can('role_update')
                                                        <a href="{{ route('roles.edit', ['role' => $role]) }}#roles"
                                                            class="dropdown-item d-flex align-items-center">
                                                            <i class="uil uil-pen text-warning"></i>
                                                            <span class="ml-2">Edit role</span>
                                                        </a>
                                                    @endcan

                                                    @can('role_delete')
                                                        <form action="{{ route('roles.destroy', ['role' => $role]) }}#roles"
                                                            method="POST" class="d-inline" role="alert"
                                                            alert-text="Apakah kamu yakin? role {{ $role->name }} akan dihapus permanen.">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                class="dropdown-item d-flex align-items-center">
                                                                <i class="uil uil-trash text-danger"></i>
                                                                <span class="ml-2">Hapus role</span>
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
                                            Oops.. sepertinya role {{ strtoupper(request()->get('keyword')) }} tidak
                                            ditemukan.
                                        @else
                                            Hmm.. sepertinya role belum ada yang dibuat. <a
                                                href="{{ route('roles.create') }}#roles">Buat?</a>
                                        @endif
                                    </b>
                                </p>
                            </div>
                        </div>
                    @endif

                    @if ($roles->hasPages())
                        <div class="card-footer">
                            {{ $roles->links('vendor.pagination.bootstrap-4') }}
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

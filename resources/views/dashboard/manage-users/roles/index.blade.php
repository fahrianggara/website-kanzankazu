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
                        <div class="card-header">
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
                <div class="table-responsive">
                    @if ($roles->count() >= 1)
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Role</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($roles as $role)
                                    <tr class="text-center">
                                        <td>{{ $roles->perPage() * ($roles->currentPage() - 1) + $no }}
                                        </td>
                                        @php $no++; @endphp
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @can('role_detail')
                                                <a href="{{ route('roles.show', ['role' => $role]) }}#roles"
                                                    class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="bottom"
                                                    title="Lihat">
                                                    <i class="uil uil-eye"></i>
                                                </a>
                                            @endcan

                                            @can('role_update')
                                                <a href="{{ route('roles.edit', ['role' => $role]) }}#roles"
                                                    class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="bottom"
                                                    title="Edit">
                                                    <i class="uil uil-pen"></i>
                                                </a>
                                            @endcan

                                            @can('role_delete')
                                                <form action="{{ route('roles.destroy', ['role' => $role]) }}#roles" method="POST"
                                                    class="d-inline" role="alert"
                                                    alert-text="Apakah kamu yakin? role {{ $role->name }} akan dihapus permanen.">
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
